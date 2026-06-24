<?php

namespace Panelis\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Panelis\Blog\Models\Blog;

/**
 * @extends Factory<Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug,
            'title' => fake()->sentence,
            'content' => fake()->sentence,
            'status' => 'published',
            'published_at' => fake()->dateTime,
        ];
    }
}
