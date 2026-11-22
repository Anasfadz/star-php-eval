<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-foreground">
                    Create Category
                </h2>
                <p class="text-sm text-muted-foreground">
                    Add a new category for articles.
                </p>
            </div>
            <x-ui.button variant="outline" :href="route('categories.index')">
                &larr; Back to Categories
            </x-ui.button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <x-ui.card class="p-6">
                <form method="POST" action="{{ route('categories.store') }}" class="space-y-6">
                    @csrf

                    @include('categories._form')

                    <x-ui.separator />

                    <div class="flex items-center justify-end gap-2">
                        <x-ui.button variant="outline" :href="route('categories.index')">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit">
                            Create Category
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
