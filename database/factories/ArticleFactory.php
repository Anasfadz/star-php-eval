<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
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
}
