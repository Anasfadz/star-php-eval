<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article:permalink}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/media/{media}', [MediaController::class, 'show'])->name('media.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/dashboard/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/dashboard/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/dashboard/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/dashboard/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    Route::get('/dashboard/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/dashboard/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/dashboard/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/dashboard/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/dashboard/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/dashboard/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
