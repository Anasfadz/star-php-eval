<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Return a JSON list of published articles with their categories.
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->string('search')->trim()->toString();

        $articles = Article::with('category')
            ->where('status', 'published')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest('published_at')
            ->latest('id')
            ->get();

        return response()->json([
            'data' => $articles,
        ]);
    }
}
