@extends('layouts.public')

@section('title', $article->title . ' — Star Media')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">
        <div>
            <x-ui.button variant="ghost" :href="route('articles.index')" class="-ml-3 text-muted-foreground hover:text-foreground">
                &larr; Back to articles
            </x-ui.button>
        </div>

        <x-ui.card class="p-6 sm:p-8">
            <article class="space-y-6">
                <div class="space-y-3">
                    <div class="flex flex-wrap items-center gap-2.5 text-sm">
                        <x-ui.badge variant="secondary">
                            {{ $article->category?->name ?? 'Uncategorized' }}
                        </x-ui.badge>
                        @if ($article->published_at)
                            <span class="text-muted-foreground">&middot;</span>
                            <time datetime="{{ $article->published_at->toIso8601String() }}" class="text-xs text-muted-foreground">
                                Published {{ $article->published_at->format('F j, Y') }}
                            </time>
                        @endif
                        @if ($article->author)
                            <span class="text-muted-foreground">&middot;</span>
                            <span class="text-xs text-muted-foreground">By {{ $article->author }}</span>
                        @endif
                        <span class="text-muted-foreground">&middot;</span>
                        <span class="inline-flex items-center gap-1 text-xs text-muted-foreground">
                            <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            {{ number_format($article->click_count ?? 0) }} {{ \Illuminate\Support\Str::plural('view', $article->click_count ?? 0) }}
                        </span>
                    </div>

                    <h1 class="text-2xl font-semibold leading-tight tracking-tight sm:text-3xl">
                        {{ $article->title }}
                    </h1>
                </div>

                <x-ui.separator />

                @if ($article->thumbnail)
                    <div class="overflow-hidden rounded-lg border border-border">
                        <img
                            src="{{ $article->thumbnail->url() }}"
                            alt="{{ $article->title }}"
                            class="max-h-96 w-full object-cover"
                        />
                    </div>
                @endif

                <div class="space-y-4 text-base leading-7 text-foreground/90">
                    @foreach (preg_split("/\r\n|\n|\r/", trim($article->body)) as $paragraph)
                        @if (filled($paragraph))
                            <p>{{ $paragraph }}</p>
                        @endif
                    @endforeach
                </div>
            </article>
        </x-ui.card>
    </div>
@endsection
