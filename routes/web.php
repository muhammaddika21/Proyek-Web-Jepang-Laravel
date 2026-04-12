<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BahasaController;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// ===== DEBUG/DEV BYPASS (Hapus rute ini jika sudah selesai) =====
Route::get('/bypass', function () {
    $user = User::first(); 
    if ($user) {
        Auth::login($user);
        return redirect()->route('admin.dashboard');
    }
    return "User tidak ditemukan di database. Pastikan database sudah terisi!";
});

// ===== PUBLIC ROUTES =====
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/bahasa', [BahasaController::class, 'index'])->name('bahasa.index');

// Future routes (to be implemented):
// Route::get('/bahasa/{slug}', [BahasaController::class, 'show'])->name('bahasa.show');
// Route::get('/budaya', [BudayaController::class, 'index'])->name('budaya.index');
// Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
// Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');

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
