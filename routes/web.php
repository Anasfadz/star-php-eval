<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article:permalink}', [ArticleController::class, 'show'])->name('articles.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/dashboard/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/dashboard/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/dashboard/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/dashboard/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
