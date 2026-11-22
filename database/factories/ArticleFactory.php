<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'title' => $title,
            'summary' => Str::limit(fake()->paragraph(2), 250),
            'body' => fake()->paragraphs(4, true),
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'permalink' => Str::slug($title).'-'.fake()->unique()->numberBetween(1000, 99999),
            'category_id' => Category::factory(),
            'author' => fake()->name(),
            'status' => 'published',
        ];
    }

    /**
     * Indicate that the article is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
            'status' => 'draft',
        ]);
    }

    /**
     * Download a sample thumbnail image from the web and attach it as media.
     */
    public function withThumbnail(): static
    {
        return $this->afterCreating(function (Article $article): void {
            try {
                $response = Http::timeout(10)->get("https://picsum.photos/seed/{$article->id}/800/450");

                if (! $response->successful()) {
                    return;
                }

                $contents = $response->body();
                $path = "{$article->id}/thumbnail.jpg";

                Storage::disk('article_media')->put($path, $contents);

                $article->media()->create([
                    'collection' => 'thumbnail',
                    'disk' => 'article_media',
                    'path' => $path,
                    'file_name' => 'thumbnail.jpg',
                    'mime_type' => $response->header('Content-Type') ?: 'image/jpeg',
                    'size' => strlen($contents),
                ]);
            } catch (\Throwable) {
                // Skip thumbnail if offline or request fails.
            }
        });
    }
}
