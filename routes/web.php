<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Models\Article;
use App\Http\Controllers\CommentController;

// Accueil PUBLIC : derniers articles
Route::get('/', function () {
    $articles = Article::latest()->get();
    return view('welcome', compact('articles'));
});

// Page review PUBLIC (détail d’un article par id)
Route::get('/review/{article:id}', [ArticleController::class, 'show'])
    ->name('articles.review');

// ✅ Commentaires accessibles à tous les utilisateurs connectés
Route::post('/review/{id}/comments', [CommentController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth');

// Dashboard PROTÉGÉ (auth + email vérifié + admin)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Routes PROTÉGÉES (auth + admin)
Route::middleware(['auth', 'admin'])->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Articles CRUD
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

require __DIR__.'/auth.php';
