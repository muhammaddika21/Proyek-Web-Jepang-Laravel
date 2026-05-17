<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class BudayaController extends Controller
{
    /**
     * Index — tampilkan artikel budaya berdasarkan subkategori dinamis
     */
    public function index()
    {
        // Ambil parent "Budaya" beserta subkategorinya
        $parentBudaya = Category::where('slug', 'budaya')->first();

        if (!$parentBudaya) {
            abort(404, 'Kategori Budaya tidak ditemukan.');
        }

        $subCategoryIds = $parentBudaya->children()->pluck('id');

        $categories = Category::whereIn('id', $subCategoryIds)
            ->with(['articles' => function ($query) {
                $query->where('type', 'umum')
                      ->where('status', 'published')
                      ->with('user')
                      ->latest();
            }])
            ->get();

        $allCategories = $parentBudaya->children()->get();

        return view('pages.budaya.index', compact('categories', 'allCategories'));
    }

    /**
     * Show — tampilkan detail artikel budaya
     */
    public function show($slug)
    {
        $parentBudaya = Category::where('slug', 'budaya')->first();

        if (!$parentBudaya) {
            abort(404, 'Kategori Budaya tidak ditemukan.');
        }

        $subCategoryIds = $parentBudaya->children()->pluck('id');

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

        return view('pages.budaya.show', compact('article', 'prevArticle', 'nextArticle'));
    }
}
