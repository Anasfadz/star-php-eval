<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-foreground">
                    Create Article
                </h2>
                <p class="text-sm text-muted-foreground">
                    Publish a new article or save it as a draft.
                </p>
            </div>
            <x-ui.button variant="outline" :href="route('dashboard')">
                &larr; Back to Dashboard
            </x-ui.button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <x-ui.card class="p-6">
                <form method="POST" action="{{ route('articles.store') }}" class="space-y-6">
                    @csrf

                    @include('articles._form', ['categories' => $categories])

                    <x-ui.separator />

                    <div class="flex items-center justify-end gap-2">
                        <x-ui.button variant="outline" :href="route('dashboard')">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit">
                            Create Article
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
