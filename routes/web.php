<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BahasaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\BudayaController;
use App\Http\Controllers\AuthController;

// ===== PUBLIC ROUTES =====
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/bahasa', [BahasaController::class, 'index'])->name('bahasa.index');
Route::get('/bahasa/{slug}', [BahasaController::class, 'show'])->name('bahasa.show');

Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/kegiatan/{slug}', [KegiatanController::class, 'show'])->name('kegiatan.show');

Route::get('/budaya', [BudayaController::class, 'index'])->name('budaya.index');
Route::get('/budaya/{slug}', [BudayaController::class, 'show'])->name('budaya.show');

// ===== AUTH ROUTES (Admin Login) =====
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== ADMIN ROUTES (Protected, prefix /admin) =====
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    // Articles CRUD
    Route::get('/articles', [App\Http\Controllers\Admin\ArticleController::class, 'index'])
        ->name('articles.index');

    Route::get('/articles/create', [App\Http\Controllers\Admin\ArticleController::class, 'create'])
        ->name('articles.create');

    Route::get('/articles/create-bahasa', [App\Http\Controllers\Admin\ArticleController::class, 'createBahasa'])
        ->name('articles.createBahasa');

    Route::post('/articles', [App\Http\Controllers\Admin\ArticleController::class, 'store'])
        ->name('articles.store');

    Route::get('/articles/{article}', [App\Http\Controllers\Admin\ArticleController::class, 'show'])
        ->name('articles.show');

    Route::get('/articles/{article}/edit', [App\Http\Controllers\Admin\ArticleController::class, 'edit'])
        ->name('articles.edit');

    Route::put('/articles/{article}', [App\Http\Controllers\Admin\ArticleController::class, 'update'])
        ->name('articles.update');

    Route::delete('/articles/{article}', [App\Http\Controllers\Admin\ArticleController::class, 'destroy'])
        ->name('articles.destroy');

    Route::patch('/articles/{article}/toggle-status', [App\Http\Controllers\Admin\ArticleController::class, 'toggleStatus'])
        ->name('articles.toggleStatus');
});
