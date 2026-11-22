@extends('layouts.public')

@section('title', 'Articles — Star Media')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="space-y-1">
                <div class="flex items-center gap-2.5">
                    <h1 class="text-2xl font-semibold tracking-tight sm:text-3xl">Latest Articles</h1>
                    <x-ui.badge variant="secondary" id="articles-count-badge">
                        {{ $articles->count() }}
                    </x-ui.badge>
                </div>
                <p class="text-sm text-muted-foreground">
                    Browse the latest news stories or filter by title in real time.
                </p>
            </div>

            <div class="relative w-full sm:w-80">
                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <x-ui.input
                    id="article-search"
                    type="search"
                    placeholder="Search articles by title..."
                    aria-label="Search articles by title"
                    class="pl-9"
                />
            </div>
        </div>

        <x-ui.separator />

        <div id="articles-grid" class="grid gap-4 sm:grid-cols-2">
            @foreach ($articles as $article)
                <article
                    class="article-card h-full"
                    data-title="{{ mb_strtolower($article->title) }}"
                >
                    <x-ui.card class="flex h-full flex-col justify-between p-5 transition-colors hover:border-foreground/25">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <x-ui.badge variant="secondary">
                                    {{ $article->category?->name ?? 'Uncategorized' }}
                                </x-ui.badge>
                                @if ($article->published_at)
                                    <time datetime="{{ $article->published_at->toIso8601String() }}" class="text-xs text-muted-foreground">
                                        {{ $article->published_at->format('M d, Y') }}
                                    </time>
                                @endif
                            </div>

                            <h2 class="text-lg font-semibold leading-snug tracking-tight">
                                <a href="{{ route('articles.show', $article) }}" class="hover:underline underline-offset-4">
                                    {{ $article->title }}
                                </a>
                            </h2>

                            <p class="text-sm leading-relaxed text-muted-foreground line-clamp-3">
                                {{ $article->summary }}
                            </p>
                        </div>

                        <div class="mt-5 flex items-center justify-between border-t border-border pt-3 text-xs text-muted-foreground">
                            <div class="flex items-center gap-2">
                                <span>{{ $article->author ?: 'Staff Writer' }}</span>
                                <span>&middot;</span>
                                <span>{{ number_format($article->click_count ?? 0) }} {{ \Illuminate\Support\Str::plural('view', $article->click_count ?? 0) }}</span>
                            </div>
                            <a href="{{ route('articles.show', $article) }}" class="font-medium text-foreground hover:underline underline-offset-4">
                                Read more &rarr;
                            </a>
                        </div>
                    </x-ui.card>
                </article>
            @endforeach
        </div>

        <div id="empty-search-state" class="hidden">
            <x-ui.card class="flex flex-col items-center justify-center p-10 text-center">
                <p class="text-sm font-medium text-foreground">No matching articles found</p>
                <p class="mt-1 text-sm text-muted-foreground">
                    Try adjusting your search query to find what you're looking for.
                </p>
                <x-ui.button variant="outline" id="clear-search-btn" type="button" class="mt-4">
                    Clear search
                </x-ui.button>
            </x-ui.card>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('article-search');
            const cards = Array.from(document.querySelectorAll('.article-card'));
            const emptyState = document.getElementById('empty-search-state');
            const countBadge = document.getElementById('articles-count-badge');
            const clearBtn = document.getElementById('clear-search-btn');

            const filterArticles = () => {
                const query = searchInput.value.trim().toLowerCase();
                let visibleCount = 0;

                cards.forEach((card) => {
                    const title = card.dataset.title || '';
                    const matches = title.includes(query);
                    card.classList.toggle('hidden', !matches);
                    if (matches) {
                        visibleCount++;
                    }
                });

                countBadge.textContent = visibleCount;
                emptyState.classList.toggle('hidden', visibleCount > 0);
            };

            searchInput.addEventListener('input', filterArticles);
            clearBtn.addEventListener('click', () => {
                searchInput.value = '';
                filterArticles();
                searchInput.focus();
            });
        });
    </script>
@endsection
