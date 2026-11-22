@props(['category' => null])

<div class="space-y-5">
    <div class="space-y-1.5">
        <label for="name" class="text-sm font-medium text-foreground">Name</label>
        <x-ui.input
            id="name"
            name="name"
            type="text"
            :value="old('name', $category?->name)"
            placeholder="e.g. Technology"
            required
        />
        @error('name')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-1.5">
        <label for="description" class="text-sm font-medium text-foreground">Description</label>
        <x-ui.input
            id="description"
            name="description"
            type="text"
            :value="old('description', $category?->description)"
            placeholder="Optional short description"
        />
        @error('description')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
