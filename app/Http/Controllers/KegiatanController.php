<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class KegiatanController extends Controller
{
    /**
     * Index — tampilkan artikel kegiatan berdasarkan subkategori dinamis
     */
    public function index()
    {
        $parentKegiatan = Category::where('slug', 'kegiatan')->first();

        if (!$parentKegiatan) {
            abort(404, 'Kategori Kegiatan tidak ditemukan.');
        }

        $subCategoryIds = $parentKegiatan->children()->pluck('id');

        $categories = Category::whereIn('id', $subCategoryIds)
            ->with(['articles' => function ($query) {
                $query->where('type', 'umum')
                      ->where('status', 'published')
                      ->with('user')
                      ->latest();
            }])
            ->get();

        $allCategories = $parentKegiatan->children()->get();

        return view('pages.kegiatan.index', compact('categories', 'allCategories'));
    }

    /**
     * Show — tampilkan detail artikel kegiatan
     */
    public function show($slug)
    {
        $parentKegiatan = Category::where('slug', 'kegiatan')->first();

        if (!$parentKegiatan) {
            abort(404, 'Kategori Kegiatan tidak ditemukan.');
        }

        $subCategoryIds = $parentKegiatan->children()->pluck('id');

        $article = Article::where('slug', $slug)
            ->where('type', 'umum')
            ->whereIn('category_id', $subCategoryIds)
            ->where('status', 'published')
            ->with(['category', 'user'])
            ->firstOrFail();

        $prevArticle = Article::where('type', 'umum')
            ->whereIn('category_id', $subCategoryIds)
            ->where('status', 'published')
            ->where('id', '<', $article->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextArticle = Article::where('type', 'umum')
            ->whereIn('category_id', $subCategoryIds)
            ->where('status', 'published')
            ->where('id', '>', $article->id)
            ->orderBy('id', 'asc')
            ->first();

        return view('pages.kegiatan.show', compact('article', 'prevArticle', 'nextArticle'));
    }
}
