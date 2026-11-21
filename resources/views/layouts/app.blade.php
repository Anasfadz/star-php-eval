<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Star Media — News Portal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background text-foreground font-sans">
    <header class="sticky top-0 z-40 border-b border-border bg-background/95 backdrop-blur-sm">
        <div class="mx-auto flex h-14 max-w-5xl items-center justify-between px-4 sm:px-6">
            <a href="{{ route('articles.index') }}" class="flex items-center gap-2.5 font-semibold tracking-tight text-foreground">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-md bg-red-600 text-xs font-bold text-white">
                    SM
                </span>
                <span>Star Media</span>
            </a>
            <nav class="flex items-center gap-4 text-sm text-muted-foreground">
                <a href="{{ route('articles.index') }}" class="transition-colors hover:text-foreground">
                    Articles
                </a>
                <a href="{{ route('api.articles.index') }}" class="transition-colors hover:text-foreground">
                    API
                </a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6">
        @yield('content')
    </main>
</body>
</html>
