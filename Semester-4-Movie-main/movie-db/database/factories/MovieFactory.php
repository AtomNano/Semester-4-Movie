<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
  public function definition(): array
{
    $title = fake()->sentence(rand(3, 6));
    $slug = Str::slug($title);

   return [
    'title' => $title,
    'slug' => $slug,
    'synopsis' => fake()->paragraphs(rand(5, 10), true),
    'category_id' => \App\Models\Category::inRandomOrder()->first()?->id,
    'year' => fake()->year(),
    'actors' => fake()->name() . ', ' . fake()->name(),
    'cover_image' => 'https://picsum.photos/seed/' . Str::random(10) . '/480/640',
    // Tambahkan field lain yang NOT NULL di sini, misal:
    // 'director' => fake()->name(),
    'created_at' => now(),
    'updated_at' => now(),
];
}
}
