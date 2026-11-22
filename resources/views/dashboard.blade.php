@php
    $publishedCount = \App\Models\Article::where('status', 'published')->count();
    $draftCount = \App\Models\Article::where('status', 'draft')->count();
    $categoryCount = \App\Models\Category::count();
    $recentArticles = \App\Models\Article::with('category')
        ->latest('published_at')
        ->latest('id')
        ->take(10)
        ->get();
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-foreground">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-muted-foreground">
                    Manage your Star Media articles and categories.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <x-ui.button variant="outline" :href="route('articles.index')">
                    View Site
                </x-ui.button>
                <x-ui.button variant="default" :href="route('articles.create')">
                    + New Article
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 space-y-6">
            @if (session('status'))
                <x-ui.card class="border-emerald-200 bg-emerald-50 px-5 py-3 text-sm font-medium text-emerald-900">
                    {{ session('status') }}
                </x-ui.card>
            @endif

            {{-- Welcome Banner --}}
            <x-ui.card class="p-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-semibold text-foreground">
                                Welcome back, {{ auth()->user()->name }}
                            </h3>
                            <x-ui.badge variant="secondary">Authenticated</x-ui.badge>
                        </div>
                        <p class="text-sm text-muted-foreground">
                            {{ __("You're logged in!") }} Signed in as {{ auth()->user()->email }}.
                        </p>
                    </div>
                    <x-ui.button variant="ghost" :href="route('profile')" wire:navigate>
                        Manage Profile &rarr;
                    </x-ui.button>
                </div>
            </x-ui.card>

            {{-- Stats Grid --}}
            <div class="grid gap-4 sm:grid-cols-3">
                <x-ui.card class="p-5">
                    <p class="text-xs font-medium uppercase tracking-wider text-muted-foreground">
                        Published Articles
                    </p>
                    <p class="mt-2 text-3xl font-semibold tracking-tight text-foreground">
                        {{ $publishedCount }}
                    </p>
                </x-ui.card>

                <x-ui.card class="p-5">
                    <p class="text-xs font-medium uppercase tracking-wider text-muted-foreground">
                        Draft Articles
                    </p>
                    <p class="mt-2 text-3xl font-semibold tracking-tight text-foreground">
                        {{ $draftCount }}
                    </p>
                </x-ui.card>

                <x-ui.card class="p-5">
                    <p class="text-xs font-medium uppercase tracking-wider text-muted-foreground">
                        Categories
                    </p>
                    <p class="mt-2 text-3xl font-semibold tracking-tight text-foreground">
                        {{ $categoryCount }}
                    </p>
                </x-ui.card>
            </div>

            {{-- Articles Management List --}}
            <x-ui.card>
                <div class="flex items-center justify-between p-5">
                    <div>
                        <h3 class="text-base font-semibold text-foreground">Articles</h3>
                        <p class="text-sm text-muted-foreground">Create, edit, or delete articles.</p>
                    </div>
                    <x-ui.button variant="default" :href="route('articles.create')">
                        + New Article
                    </x-ui.button>
                </div>

                <x-ui.separator />

                <div class="divide-y divide-border">
                    @forelse ($recentArticles as $article)
                        <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <x-ui.badge variant="secondary">
                                        {{ $article->category?->name ?? 'Uncategorized' }}
                                    </x-ui.badge>
                                    <x-ui.badge variant="outline">
                                        {{ ucfirst($article->status) }}
                                    </x-ui.badge>
                                    @if ($article->published_at)
                                        <span class="text-xs text-muted-foreground">
                                            {{ $article->published_at->format('M d, Y') }}
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('articles.show', $article) }}" class="block text-sm font-medium text-foreground hover:underline underline-offset-4">
                                    {{ $article->title }}
                                </a>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <x-ui.button variant="outline" :href="route('articles.edit', $article)">
                                    Edit
                                </x-ui.button>
                                <form method="POST" action="{{ route('articles.destroy', $article) }}" data-confirm-delete="{{ $article->title }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-ui.button type="submit" variant="ghost" class="text-red-600 hover:bg-red-50 hover:text-red-700">
                                        Delete
                                    </x-ui.button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-muted-foreground">
                            No articles yet. Click <strong>+ New Article</strong> to create one.
                        </div>
                    @endforelse
                </div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
