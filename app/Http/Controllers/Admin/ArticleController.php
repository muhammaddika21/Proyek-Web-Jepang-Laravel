<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // =============================================
    // INDEX — Halaman Kelola Artikel
    // =============================================
    public function index(Request $request)
    {
        $query = Article::with(['category', 'user'])->latest();

        // Filter: Search judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter: Tipe (bahasa / umum)
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter: Kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Filter: Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        match($sort) {
            'oldest' => $query->oldest(),
            'views'  => $query->orderByDesc('view_count'),
            default  => $query->latest(),
        };

        $articles   = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        // Statistik untuk header dashboard
        $stats = [
            'total'     => Article::count(),
            'published' => Article::where('status', 'published')->count(),
            'draft'     => Article::where('status', 'draft')->count(),
            'bahasa'    => Article::where('type', 'bahasa')->count(),
        ];

        return view('admin.articles.index', compact('articles', 'categories', 'stats'));
    }

    // =============================================
    // CREATE — Form Artikel Umum
    // =============================================
    public function create()
    {
        $categories = Category::where('type', 'umum')->get();
        return view('admin.articles.create', compact('categories'));
    }

    // =============================================
    // CREATE BAHASA — Form Artikel Bahasa
    // =============================================
    public function createBahasa()
    {
        $categories = Category::where('type', 'bahasa')->get();
        return view('admin.articles.create-bahasa', compact('categories'));
    }

    // =============================================
    // STORE — Simpan Artikel Baru
    // =============================================
    public function store(Request $request)
    {
        $type = $request->input('type', 'umum');

        // Validasi dasar
        $rules = [
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:articles,slug',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt'     => 'nullable|string|max:500',
            'status'      => 'required|in:draft,published',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        // Validasi tambahan untuk artikel bahasa
        if ($type === 'bahasa') {
            $rules['grammar_explanation'] = 'nullable|string';
            $rules['jlpt_level']          = 'nullable|integer|between:1,5';
        } else {
            $rules['content'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        // Handle upload cover image
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('articles/covers', 'public');
        }

        // Buat slug jika kosong
        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->title);

        // Pastikan slug unik
        $slug = $this->makeUniqueSlug($slug);

        // Buat artikel
        $article = Article::create([
            'user_id'              => Auth::id(),
            'category_id'          => $request->category_id,
            'title'                => $request->title,
            'slug'                 => $slug,
            'type'                 => $type,
            'excerpt'              => $request->excerpt,
            'content'              => $type === 'umum' ? $request->content : null,
            'cover_image'          => $coverPath,
            'cover_image_caption'  => $request->cover_image_caption,
            'japanese_title'       => $request->japanese_title,
            'romaji_title'         => $request->romaji_title,
            'jlpt_level'           => $request->jlpt_level,
            'grammar_explanation'  => $type === 'bahasa' ? $request->grammar_explanation : null,
            'vocabulary_list'      => $this->parseVocabList($request->vocabulary_list),
            'quiz_questions'       => $this->parseQuiz($request->quiz_questions),
            'status'               => $request->status,
            'read_time'            => $request->read_time,
        ]);

        $route = $type === 'bahasa' ? 'admin.articles.createBahasa' : 'admin.articles.create';
        $label = $type === 'bahasa' ? 'Artikel Bahasa' : 'Artikel Umum';

        return redirect()->route('admin.articles.index')
            ->with('success', "✅ {$label} \"{$article->title}\" berhasil disimpan!");
    }

    // =============================================
    // EDIT — Form Edit Artikel
    // =============================================
    public function edit(Article $article)
    {
        $categories = Category::where('type', $article->type)->get();
        $view = $article->type === 'bahasa' ? 'admin.articles.create-bahasa' : 'admin.articles.create';
        return view($view, compact('article', 'categories'));
    }

    // =============================================
    // UPDATE — Simpan Perubahan Artikel
    // =============================================
    public function update(Request $request, Article $article)
    {
        $rules = [
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:articles,slug,' . $article->id,
            'category_id' => 'nullable|exists:categories,id',
            'excerpt'     => 'nullable|string|max:500',
            'status'      => 'required|in:draft,published',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $request->validate($rules);

        // Handle cover image baru
        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama
            if ($article->cover_image) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('articles/covers', 'public');
        } else {
            $coverPath = $article->cover_image;
        }

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : $article->slug;

        $article->update([
            'category_id'          => $request->category_id,
            'title'                => $request->title,
            'slug'                 => $slug,
            'excerpt'              => $request->excerpt,
            'content'              => $article->type === 'umum' ? $request->content : null,
            'cover_image'          => $coverPath,
            'cover_image_caption'  => $request->cover_image_caption,
            'japanese_title'       => $request->japanese_title,
            'romaji_title'         => $request->romaji_title,
            'jlpt_level'           => $request->jlpt_level,
            'grammar_explanation'  => $article->type === 'bahasa' ? $request->grammar_explanation : null,
            'vocabulary_list'      => $this->parseVocabList($request->vocabulary_list),
            'quiz_questions'       => $this->parseQuiz($request->quiz_questions),
            'status'               => $request->status,
            'read_time'            => $request->read_time,
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', "✅ Artikel \"{$article->title}\" berhasil diperbarui!");
    }

    // =============================================
    // DESTROY — Hapus Artikel
    // =============================================
    public function destroy(Article $article)
    {
        // Hapus cover image dari storage
        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }

        $title = $article->title;
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', "🗑️ Artikel \"{$title}\" berhasil dihapus.");
    }

    // =============================================
    // TOGGLE STATUS — Publish / Draft cepat
    // =============================================
    public function toggleStatus(Article $article)
    {
        $article->update([
            'status' => $article->status === 'published' ? 'draft' : 'published',
        ]);

        $label = $article->status === 'published' ? 'dipublikasikan' : 'dikembalikan ke draft';
        return back()->with('success', "✅ Artikel berhasil {$label}.");
    }

    // =============================================
    // Helper: Buat slug unik
    // =============================================
    private function makeUniqueSlug(string $slug, ?int $exceptId = null): string
    {
        $original = $slug;
        $counter  = 1;

        while (
            Article::where('slug', $slug)
                ->when($exceptId, fn($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    // =============================================
    // Helper: Parse vocabulary list dari form
    // =============================================
    private function parseVocabList($raw): ?array
    {
        if (empty($raw) || !is_array($raw)) return null;

        return array_filter(array_map(function ($item) {
            if (empty($item['kata']) && empty($item['arti'])) return null;
            return [
                'kata'   => $item['kata']   ?? '',
                'romaji' => $item['romaji'] ?? '',
                'arti'   => $item['arti']   ?? '',
            ];
        }, $raw));
    }

    // =============================================
    // Helper: Parse quiz questions dari form
    // =============================================
    private function parseQuiz($raw): ?array
    {
        if (empty($raw) || !is_array($raw)) return null;

        return array_filter(array_map(function ($item) {
            if (empty($item['question'])) return null;
            return [
                'question' => $item['question']        ?? '',
                'options'  => $item['options']          ?? [],
                'answer'   => (int)($item['answer']     ?? 0),
            ];
        }, $raw));
    }
}
