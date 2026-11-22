<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display the list of published articles.
     */
    public function index(): View
    {
        $articles = Article::with(['category', 'thumbnail'])
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
        $article->increment('click_count');
        $article->load(['category', 'thumbnail']);

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateArticle($request);
        unset($validated['thumbnail']);

        $article = Article::create([
            ...$validated,
            'author' => $validated['author'] ?: $request->user()->name,
            'permalink' => Str::slug($validated['title']).'-'.Str::lower(Str::random(6)),
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        $this->syncThumbnail($request, $article);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Article created successfully.');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article): View
    {
        $article->load('thumbnail');
        $categories = Category::orderBy('name')->get();

        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $this->validateArticle($request);
        unset($validated['thumbnail']);

        $publishedAt = match (true) {
            $validated['status'] === 'draft' => null,
            $article->published_at === null => now(),
            default => $article->published_at,
        };

        $article->update([
            ...$validated,
            'author' => $validated['author'] ?: $request->user()->name,
            'published_at' => $publishedAt,
        ]);

        $this->syncThumbnail($request, $article);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Article updated successfully.');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()
            ->route('dashboard')
            ->with('status', 'Article deleted successfully.');
    }

    /**
     * Validate article form input.
     *
     * @return array<string, mixed>
     */
    private function validateArticle(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', 'in:published,draft'],
            'author' => ['nullable', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    /**
     * Store, replace, or remove the article's thumbnail media.
     */
    private function syncThumbnail(Request $request, Article $article): void
    {
        $existing = $article->thumbnail;

        if ($request->boolean('remove_thumbnail') && $existing) {
            Storage::disk($existing->disk)->delete($existing->path);
            $existing->delete();
        }

        if (! $request->hasFile('thumbnail')) {
            return;
        }

        if ($existing) {
            Storage::disk($existing->disk)->delete($existing->path);
            $existing->delete();
        }

        $file = $request->file('thumbnail');
        $path = $file->store((string) $article->id, 'article_media');

        $article->media()->create([
            'collection' => 'thumbnail',
            'disk' => 'article_media',
            'path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
    }
}
