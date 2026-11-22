<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-foreground">
                    Edit Category
                </h2>
                <p class="text-sm text-muted-foreground">
                    Update category name or description.
                </p>
            </div>
            <x-ui.button variant="outline" :href="route('categories.index')">
                &larr; Back to Categories
            </x-ui.button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 space-y-6">
            <x-ui.card class="p-6">
                <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @include('categories._form', ['category' => $category])

                    <x-ui.separator />

                    <div class="flex items-center justify-end gap-2">
                        <x-ui.button variant="outline" :href="route('categories.index')">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit">
                            Save Changes
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>

            <x-ui.card class="p-6 border-red-200">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-foreground">Delete Category</h3>
                        <p class="text-xs text-muted-foreground">
                            Remove this category from the portal.
                        </p>
                    </div>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}" data-confirm-delete="{{ $category->name }}">
                        @csrf
                        @method('DELETE')
                        <x-ui.button type="submit" class="bg-red-600 text-white hover:bg-red-700">
                            Delete Category
                        </x-ui.button>
                    </form>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
