<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik kartu atas
        $stats = [
            'total_articles'     => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles'     => Article::where('status', 'draft')->count(),
            'bahasa_articles'    => Article::where('type', 'bahasa')->count(),
            'umum_articles'      => Article::where('type', 'umum')->count(),
        ];

        // 5 artikel terbaru
        $recentArticles = Article::with('category')
            ->latest()
            ->take(5)
            ->get();

        // Artikel paling banyak dilihat
        $popularArticles = Article::with('category')
            ->where('status', 'published')
            ->orderByDesc('view_count')
            ->take(5)
            ->get();

        return view('admin.dashboard-new', compact('stats', 'recentArticles', 'popularArticles') + ['title' => 'Dashboard']);
    }
}
