<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $categories = collect([
            'Technology',
            'Business',
            'World',
            'Sports',
            'Entertainment',
        ])->map(fn (string $name) => Category::factory()->create([
            'name' => $name,
        ]));

        Article::factory()
            ->count(20)
            ->recycle($categories)
            ->create();
    }
}
