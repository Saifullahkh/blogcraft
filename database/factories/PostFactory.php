<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(fake()->numberBetween(5, 8));
        $paragraphs = collect(fake()->paragraphs(6))->map(fn ($paragraph) => '<p>'.$paragraph.'</p>')->implode('');

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(2),
            'content' => '<h2>'.fake()->sentence(4).'</h2>'.$paragraphs.'<blockquote>'.fake()->sentence(18).'</blockquote><h3>'.fake()->sentence(3).'</h3><ul><li>'.fake()->sentence(7).'</li><li>'.fake()->sentence(7).'</li><li>'.fake()->sentence(7).'</li></ul>',
            'featured_image' => fake()->randomElement([
                'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1483058712412-4245e9b90334?auto=format&fit=crop&w=1200&q=80',
            ]),
            'status' => 'published',
            'is_featured' => fake()->boolean(25),
            'published_at' => fake()->dateTimeBetween('-90 days', 'now'),
            'meta_title' => null,
            'meta_description' => fake()->sentence(18),
            'views' => fake()->numberBetween(20, 2500),
        ];
    }
}
