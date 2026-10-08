<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    public function definition(): array
    {
        $name = Str::title(fake()->unique()->words(rand(1, 2), true));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
