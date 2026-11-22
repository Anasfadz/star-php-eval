<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-foreground">
                    Categories
                </h2>
                <p class="text-sm text-muted-foreground">
                    Create, edit, or delete article categories.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <x-ui.button variant="outline" :href="route('dashboard')">
                    &larr; Dashboard
                </x-ui.button>
                <x-ui.button variant="default" :href="route('categories.create')">
                    + New Category
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

            <x-ui.card>
                <div class="flex items-center justify-between p-5">
                    <div>
                        <h3 class="text-base font-semibold text-foreground">All Categories</h3>
                        <p class="text-sm text-muted-foreground">{{ $categories->count() }} total categories.</p>
                    </div>
                </div>

                <x-ui.separator />

                <div class="divide-y divide-border">
                    @forelse ($categories as $category)
                        <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-foreground">{{ $category->name }}</span>
                                    <x-ui.badge variant="secondary">
                                        {{ $category->articles_count }} {{ \Illuminate\Support\Str::plural('article', $category->articles_count) }}
                                    </x-ui.badge>
                                </div>
                                @if ($category->description)
                                    <p class="text-xs text-muted-foreground">{{ $category->description }}</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <x-ui.button variant="outline" :href="route('categories.edit', $category)">
                                    Edit
                                </x-ui.button>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" data-confirm-delete="{{ $category->name }}">
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
                            No categories yet. Click <strong>+ New Category</strong> to create one.
                        </div>
                    @endforelse
                </div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
