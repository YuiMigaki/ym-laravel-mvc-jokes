<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Joke>
 */
class JokeFactory extends Factory
{
    /**
     * Define the model's default joke.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content'=> fake()->text(),
            'category'=> fake()->word(),
            'title' => fake()->word(),
            'tag'=> fake()->word(),
            'author' => fake()->name(),
        ];
    }
}
