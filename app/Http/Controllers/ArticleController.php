<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display the list of published articles.
     */
    public function index(): View
    {
        $articles = Article::with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->latest('id')
            ->get();

        return view('articles.index', compact('articles'));
    }

    /**
     * Display a single article detail page.
     */
    public function show(Article $article): View
    {
        $article->load('category');

        return view('articles.show', compact('article'));
    }
}
