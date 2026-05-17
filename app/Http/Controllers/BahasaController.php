<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class BahasaController extends Controller
{
    /**
     * Index — tampilkan artikel bahasa berdasarkan kategori (Complete Guide, Kanji, dll)
     */
    public function index()
    {
        // Ambil semua kategori bertipe 'bahasa' beserta artikelnya
        $allCategories = Category::where('type', 'bahasa')->get();

        $categories = Category::where('type', 'bahasa')
            ->with(['articles' => function ($query) {
                $query->where('type', 'bahasa')
                      ->where('status', 'published')
                      ->with('user')
                      ->latest();
            }])
            ->get();

        return view('pages.bahasa.index', compact('categories', 'allCategories'));
    }

    /**
     * Show — tampilkan detail artikel bahasa
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('type', 'bahasa')
            ->where('status', 'published')
            ->with(['category', 'user'])
            ->firstOrFail();

        $prevArticle = Article::where('type', 'bahasa')
            ->where('status', 'published')
            ->where('id', '<', $article->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextArticle = Article::where('type', 'bahasa')
            ->where('status', 'published')
            ->where('id', '>', $article->id)
            ->orderBy('id', 'asc')
            ->first();

        return view('pages.bahasa.show', compact('article', 'prevArticle', 'nextArticle'));
    }
}
