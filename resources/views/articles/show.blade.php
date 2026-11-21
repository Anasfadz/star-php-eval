@extends('layouts.app')

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
                    </div>

                    <h1 class="text-2xl font-semibold leading-tight tracking-tight sm:text-3xl">
                        {{ $article->title }}
                    </h1>
                </div>

                <x-ui.separator />

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
