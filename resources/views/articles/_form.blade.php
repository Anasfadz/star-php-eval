@props(['article' => null, 'categories'])

<div class="space-y-5">
    <div class="space-y-1.5">
        <label for="title" class="text-sm font-medium text-foreground">Title</label>
        <x-ui.input
            id="title"
            name="title"
            type="text"
            :value="old('title', $article?->title)"
            placeholder="Enter article title"
            required
        />
        @error('title')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="space-y-1.5">
            <label for="category_id" class="text-sm font-medium text-foreground">Category</label>
            <select
                id="category_id"
                name="category_id"
                required
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
            >
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $article?->category_id) === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label for="status" class="text-sm font-medium text-foreground">Status</label>
            <select
                id="status"
                name="status"
                required
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
            >
                <option value="published" @selected(old('status', $article?->status ?? 'published') === 'published')>
                    Published
                </option>
                <option value="draft" @selected(old('status', $article?->status) === 'draft')>
                    Draft
                </option>
            </select>
            @error('status')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label for="author" class="text-sm font-medium text-foreground">Author</label>
            <x-ui.input
                id="author"
                name="author"
                type="text"
                :value="old('author', $article?->author ?? auth()->user()->name)"
                placeholder="Author name"
            />
            @error('author')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="space-y-1.5">
        <label for="summary" class="text-sm font-medium text-foreground">Summary</label>
        <x-ui.input
            id="summary"
            name="summary"
            type="text"
            :value="old('summary', $article?->summary)"
            placeholder="Brief one-sentence summary"
            required
        />
        @error('summary')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-1.5">
        <label for="body" class="text-sm font-medium text-foreground">Body</label>
        <textarea
            id="body"
            name="body"
            rows="8"
            required
            placeholder="Write the full article content..."
            class="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
        >{{ old('body', $article?->body) }}</textarea>
        @error('body')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
