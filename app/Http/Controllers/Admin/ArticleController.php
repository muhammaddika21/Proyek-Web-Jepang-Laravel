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
        $query = Article::with(['category', 'user']);

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

        // Sorting berdasarkan updated_at (agar artikel yang baru diedit muncul di atas)
        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'oldest' => $query->orderBy('updated_at', 'asc'),
            'views' => $query->orderByDesc('view_count'),
            default => $query->orderBy('updated_at', 'desc'),
        };

        $articles = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        // Statistik untuk header dashboard
        $stats = [
            'total' => Article::count(),
            'published' => Article::where('status', 'published')->count(),
            'draft' => Article::where('status', 'draft')->count(),
            'umum' => Article::where('type', 'umum')->count(),
            'bahasa' => Article::where('type', 'bahasa')->count(),
        ];

        return view('admin.articles.index', compact('articles', 'categories', 'stats'));
    }

    // =============================================
    // CREATE — Form Artikel Umum
    // =============================================
    public function create()
    {
        $categories = Category::where('type', 'umum')->get();

        // Parent categories with children for dependent dropdown
        $parentCategories = Category::where('type', 'umum')
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        return view('admin.articles.create', compact('categories', 'parentCategories'));
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

        // Tentukan status berdasarkan tombol yang ditekan
        // Jika user klik "Simpan Draft" (action=draft), SELALU simpan sebagai draft
        // Jika user klik "Publish" (action=publish), simpan sebagai published
        $status = $request->input('action') === 'draft' ? 'draft' : 'published';

        // Validasi dasar
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        // Validasi tambahan untuk artikel bahasa
        if ($type === 'bahasa') {
            $rules['kemahiran_level'] = 'nullable|in:pemula,menengah,mahir';
        }
        $rules['additional_images.*'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        $rules['audio_files.*']        = 'nullable|mimes:mp3,wav,ogg,m4a|max:20480';
        $rules['video_files.*']        = 'nullable|mimes:mp4,webm|max:102400';

        $request->validate($rules);

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

        // Untuk artikel bahasa, konten dari Quill editor masuk ke grammar_explanation
        // Strip base64 images (dari paste clipboard) agar tidak melebihi batas database
        $content = $this->stripBase64Images($request->content);
        $grammarExplanation = null;
        if ($type === 'bahasa') {
            $grammarExplanation = $content;
            $content = null;
        }

        // Handle upload media tambahan (multiple images)
        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $img) {
                $additionalImages[] = $img->store('articles/media', 'public');
            }
        }

        // Handle multiple audio files
        $audioFiles = [];
        if ($request->hasFile('audio_files')) {
            foreach ($request->file('audio_files') as $audio) {
                $audioFiles[] = [
                    'path'  => $audio->store('articles/audio', 'public'),
                    'label' => '',
                ];
            }
        }
        // Legacy single audio_file (backward compat)
        $audioPath = null;
        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('articles/audio', 'public');
        }

        // Handle multiple video files
        $videoFiles = [];
        if ($request->hasFile('video_files')) {
            foreach ($request->file('video_files') as $video) {
                $videoFiles[] = [
                    'path'  => $video->store('articles/video', 'public'),
                    'label' => '',
                ];
            }
        }

        // Handle multiple YouTube URLs
        $youtubeUrls = array_values(array_filter(
            (array)($request->input('youtube_urls', []))
        ));
        // Legacy single youtube_url (backward compat)
        $youtubeUrl = $request->youtube_url;

        // Merge audio labels
        $audioLabels = (array)($request->input('audio_labels', []));
        foreach ($audioFiles as $i => &$af) {
            $af['label'] = $audioLabels[$i] ?? '';
        }
        unset($af);
        $videoLabels = (array)($request->input('video_labels', []));
        foreach ($videoFiles as $i => &$vf) {
            $vf['label'] = $videoLabels[$i] ?? '';
        }
        unset($vf);

        // Buat artikel
        $article = Article::create([
            'user_id'             => Auth::id(),
            'category_id'         => $request->category_id,
            'title'               => $request->title,
            'slug'                => $slug,
            'type'                => $type,
            'excerpt'             => $request->excerpt,
            'content'             => $content,
            'cover_image'         => $coverPath,
            'cover_image_caption' => $request->cover_image_caption,
            'additional_images'   => !empty($additionalImages) ? $additionalImages : null,
            'audio_file'          => $audioPath,
            'audio_label'         => $request->audio_label,
            'audio_files'         => !empty($audioFiles) ? $audioFiles : null,
            'video_files'         => !empty($videoFiles) ? $videoFiles : null,
            'youtube_url'         => $youtubeUrl,
            'youtube_urls'        => !empty($youtubeUrls) ? $youtubeUrls : null,
            'japanese_title'      => $request->japanese_title,
            'romaji_title'        => $request->romaji_title,
            'kemahiran_level'     => $request->kemahiran_level,
            'grammar_explanation' => $grammarExplanation,
            'vocabulary_list'     => $this->parseVocabList($request->vocabulary_list),
            'quiz_questions'      => $this->parseQuiz($request->quiz_questions),
            'status'              => $status,
            'read_time'           => $request->read_time,
        ]);

        $label = $type === 'bahasa' ? 'Artikel Bahasa' : 'Artikel Umum';
        $statusLabel = $status === 'draft' ? '(Draft)' : '(Published)';

        return redirect()->route('admin.articles.index')
            ->with('success', "✅ {$label} \"{$article->title}\" berhasil disimpan! {$statusLabel}");
    }

    // =============================================
    // EDIT — Form Edit Artikel
    // =============================================
    public function edit(Article $article)
    {
        $categories = Category::where('type', $article->type)->get();
        $view = $article->type === 'bahasa' ? 'admin.articles.edit-bahasa' : 'admin.articles.create';

        // For umum articles, pass parentCategories with children for dependent dropdown
        $parentCategories = collect();
        if ($article->type === 'umum') {
            $parentCategories = Category::where('type', 'umum')
                ->whereNull('parent_id')
                ->with('children')
                ->get();
        }

        return view($view, compact('article', 'categories', 'parentCategories'));
    }

    // =============================================
    // UPDATE — Simpan Perubahan Artikel
    // =============================================
    public function update(Request $request, Article $article)
    {
        // Tentukan status berdasarkan tombol yang ditekan
        $status = $request->input('action') === 'draft' ? 'draft' : 'published';

        $rules = [
            'title'               => 'required|string|max:255',
            'slug'                => 'nullable|string|max:255|unique:articles,slug,' . $article->id,
            'category_id'         => 'nullable|exists:categories,id',
            'excerpt'             => 'nullable|string|max:500',
            'cover_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'audio_file'          => 'nullable|mimes:mp3,wav,ogg,m4a|max:20480',
            'audio_files.*'       => 'nullable|mimes:mp3,wav,ogg,m4a|max:51200',
            'video_files.*'       => 'nullable|mimes:mp4,webm,mov,avi|max:204800',
        ];

        if ($article->type === 'bahasa') {
            $rules['kemahiran_level'] = 'nullable|in:pemula,menengah,mahir';
        }

        $request->validate($rules);

        // Handle cover image baru
        if ($request->hasFile('cover_image')) {
            if ($article->cover_image) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('articles/covers', 'public');
        } else {
            $coverPath = $article->cover_image;
        }

        // Handle additional images
        $additionalImages = $article->additional_images ?? [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $img) {
                $additionalImages[] = $img->store('articles/media', 'public');
            }
        }

        // Handle legacy single audio
        $audioPath = $article->audio_file;
        if ($request->hasFile('audio_file')) {
            if ($article->audio_file) {
                Storage::disk('public')->delete($article->audio_file);
            }
            $audioPath = $request->file('audio_file')->store('articles/audio', 'public');
        }

        // Handle multiple audio files (append new ones)
        $audioFiles = $article->audio_files ?? [];
        if ($request->hasFile('audio_files')) {
            $audioLabels = (array)($request->input('audio_labels', []));
            foreach ($request->file('audio_files') as $i => $audio) {
                $audioFiles[] = [
                    'path'  => $audio->store('articles/audio', 'public'),
                    'label' => $audioLabels[$i] ?? '',
                ];
            }
        }
        // Update labels of existing audio_files
        $existingAudioLabels = (array)($request->input('existing_audio_labels', []));
        foreach ($existingAudioLabels as $i => $lbl) {
            if (isset($audioFiles[$i])) $audioFiles[$i]['label'] = $lbl;
        }

        // Handle multiple video files (append new ones)
        $videoFiles = $article->video_files ?? [];
        if ($request->hasFile('video_files')) {
            $videoLabels = (array)($request->input('video_labels', []));
            foreach ($request->file('video_files') as $i => $video) {
                $videoFiles[] = [
                    'path'  => $video->store('articles/video', 'public'),
                    'label' => $videoLabels[$i] ?? '',
                ];
            }
        }
        $existingVideoLabels = (array)($request->input('existing_video_labels', []));
        foreach ($existingVideoLabels as $i => $lbl) {
            if (isset($videoFiles[$i])) $videoFiles[$i]['label'] = $lbl;
        }

        // Handle multiple YouTube URLs
        $youtubeUrls = array_values(array_filter(
            (array)($request->input('youtube_urls', []))
        ));
        $youtubeUrl = $request->youtube_url;

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : $article->slug;

        // Untuk artikel bahasa, konten dari Quill editor masuk ke grammar_explanation
        // Strip base64 images (dari paste clipboard) agar tidak melebihi batas database
        $content = $this->stripBase64Images($request->content);
        $grammarExplanation = null;
        if ($article->type === 'bahasa') {
            $grammarExplanation = $content;
            $content = null;
        }

        $article->update([
            'category_id'         => $request->category_id,
            'title'               => $request->title,
            'slug'                => $slug,
            'excerpt'             => $request->excerpt,
            'content'             => $content,
            'cover_image'         => $coverPath,
            'cover_image_caption' => $request->cover_image_caption,
            'additional_images'   => !empty($additionalImages) ? $additionalImages : null,
            'audio_file'          => $audioPath,
            'audio_label'         => $request->audio_label,
            'audio_files'         => !empty($audioFiles) ? array_values($audioFiles) : null,
            'video_files'         => !empty($videoFiles) ? array_values($videoFiles) : null,
            'youtube_url'         => $youtubeUrl,
            'youtube_urls'        => !empty($youtubeUrls) ? $youtubeUrls : null,
            'japanese_title'      => $request->japanese_title,
            'romaji_title'        => $request->romaji_title,
            'kemahiran_level'     => $request->kemahiran_level,
            'grammar_explanation' => $grammarExplanation,
            'vocabulary_list'     => $this->parseVocabList($request->vocabulary_list),
            'quiz_questions'      => $this->parseQuiz($request->quiz_questions),
            'status'              => $status,
            'read_time'           => $request->read_time,
        ]);

        $statusLabel = $status === 'draft' ? '(Draft)' : '(Published)';

        return redirect()->route('admin.articles.index')
            ->with('success', "✅ Artikel \"{$article->title}\" berhasil diperbarui! {$statusLabel}");
    }

    // =============================================
    // DESTROY — Hapus Artikel
    // =============================================
    // =============================================
    // SHOW — Preview Artikel
    // =============================================
    public function show(Article $article)
    {
        $article->load(['category', 'user']);
        return view('admin.articles.show', compact('article'));
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
    // DELETE MEDIA — Hapus gambar/audio dari artikel (AJAX)
    // =============================================
    public function deleteMedia(Request $request, Article $article)
    {
        $type  = $request->input('type');   // 'image'|'audio'|'audio_item'|'video_item'|'youtube_item'|'cover'
        $index = $request->input('index');  // int

        if ($type === 'image') {
            $images = $article->additional_images ?? [];
            if (!isset($images[$index])) {
                return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan'], 404);
            }
            Storage::disk('public')->delete($images[$index]);
            array_splice($images, $index, 1);
            $article->update(['additional_images' => !empty($images) ? array_values($images) : null]);
            return response()->json(['success' => true]);
        }

        if ($type === 'audio') {
            if ($article->audio_file) Storage::disk('public')->delete($article->audio_file);
            $article->update(['audio_file' => null, 'audio_label' => null]);
            return response()->json(['success' => true]);
        }

        if ($type === 'audio_item') {
            $files = $article->audio_files ?? [];
            if (!isset($files[$index])) {
                return response()->json(['success' => false, 'message' => 'Audio tidak ditemukan'], 404);
            }
            Storage::disk('public')->delete($files[$index]['path'] ?? '');
            array_splice($files, $index, 1);
            $article->update(['audio_files' => !empty($files) ? array_values($files) : null]);
            return response()->json(['success' => true]);
        }

        if ($type === 'video_item') {
            $files = $article->video_files ?? [];
            if (!isset($files[$index])) {
                return response()->json(['success' => false, 'message' => 'Video tidak ditemukan'], 404);
            }
            Storage::disk('public')->delete($files[$index]['path'] ?? '');
            array_splice($files, $index, 1);
            $article->update(['video_files' => !empty($files) ? array_values($files) : null]);
            return response()->json(['success' => true]);
        }

        if ($type === 'youtube_item') {
            $urls = $article->youtube_urls ?? [];
            if (!isset($urls[$index])) {
                return response()->json(['success' => false, 'message' => 'YouTube URL tidak ditemukan'], 404);
            }
            array_splice($urls, $index, 1);
            $article->update(['youtube_urls' => !empty($urls) ? array_values($urls) : null]);
            return response()->json(['success' => true]);
        }

        if ($type === 'cover') {
            if ($article->cover_image) Storage::disk('public')->delete($article->cover_image);
            $article->update(['cover_image' => null]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Tipe media tidak valid'], 422);
    }

    // =============================================
    // Helper: Buat slug unik
    // =============================================
    private function makeUniqueSlug(string $slug, ?int $exceptId = null): string
    {
        $original = $slug;
        $counter = 1;

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
    // Supports two formats:
    //   1. Grouped (new): [ { title, rows: [{kata,romaji,arti,contoh}] }, ... ]
    //   2. Flat   (old):  [ {kata, romaji, arti, contoh}, ... ]
    // =============================================
    private function parseVocabList($raw): ?array
    {
        if (empty($raw) || !is_array($raw))
            return null;

        // Detect grouped format: first item has 'rows' key
        $firstItem = reset($raw);
        $isGrouped = is_array($firstItem) && array_key_exists('rows', $firstItem);

        if ($isGrouped) {
            // --- GROUPED FORMAT (from create-bahasa / edit-bahasa) ---
            $tables = [];
            foreach ($raw as $tableData) {
                $rows = [];
                foreach ($tableData['rows'] ?? [] as $row) {
                    if (empty($row['kata']) && empty($row['arti'])) continue;
                    $rows[] = [
                        'kata'   => $row['kata']   ?? '',
                        'romaji' => $row['romaji']  ?? '',
                        'arti'   => $row['arti']    ?? '',
                        'contoh' => $row['contoh']  ?? '',
                    ];
                }
                if (!empty($rows)) {
                    $tables[] = [
                        'title' => $tableData['title'] ?? '',
                        'rows'  => $rows,
                    ];
                }
            }
            return !empty($tables) ? $tables : null;
        }

        // --- FLAT FORMAT (legacy) ---
        $result = array_filter(array_map(function ($item) {
            if (empty($item['kata']) && empty($item['arti']))
                return null;
            return [
                'kata'   => $item['kata']   ?? '',
                'romaji' => $item['romaji']  ?? '',
                'arti'   => $item['arti']    ?? '',
                'contoh' => $item['contoh']  ?? '',
            ];
        }, $raw));

        return !empty($result) ? array_values($result) : null;
    }

    // =============================================
    // Helper: Parse quiz questions dari form
    // =============================================
    private function parseQuiz($raw): ?array
    {
        if (empty($raw) || !is_array($raw))
            return null;

        $result = array_filter(array_map(function ($item) {
            if (empty($item['question']))
                return null;
            // Filter out empty options
            $options = array_values(array_filter($item['options'] ?? [], fn($o) => trim($o) !== ''));
            return [
                'question' => $item['question'] ?? '',
                'options' => $options,
                'answer' => (int) ($item['answer'] ?? 0),
            ];
        }, $raw));

        return !empty($result) ? array_values($result) : null;
    }

    // =============================================
    // Helper: Strip base64 images dari konten Quill
    // Gambar yang di-copy paste dari Word/clipboard
    // menjadi base64 sangat besar dan bisa crash.
    // Kita ganti dengan placeholder peringatan.
    // =============================================
    private function stripBase64Images(?string $content): ?string
    {
        if (empty($content))
            return $content;

        // Ganti <img src="data:image/...;base64,..."> dengan peringatan
        return preg_replace(
            '/<img[^>]+src=["\']data:image\/[^;]+;base64,[^"\']+["\'][^>]*>/i',
            '<p style="color:#e67e22;font-style:italic;">[⚠️ Gambar yang di-paste langsung tidak didukung. Gunakan fitur &quot;Media Tambahan&quot; untuk upload gambar.]</p>',
            $content
        );
    }
}
