<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscription;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Site Administrator',
                'password' => Hash::make('Password123!'),
                'role' => 'admin',
                'status' => 'active',
                'bio' => 'Editor in chief and platform administrator.',
                'email_verified_at' => now(),
            ]
        );

        $users = User::factory(8)->create();
        $categories = Category::factory(8)->create();
        $tags = Tag::factory(10)->create();

        $posts = Post::factory(20)->make()->each(function (Post $post, int $index) use ($admin, $users, $categories): void {
            $post->user_id = $index < 4 ? $admin->id : $users->random()->id;
            $post->category_id = $categories->random()->id;
            $post->is_featured = $index < 4;
            $post->save();
        });

        $posts->each(function (Post $post) use ($tags, $users): void {
            $post->tags()->sync($tags->random(rand(2, 4))->pluck('id'));
            Comment::factory(rand(2, 5))->create([
                'post_id' => $post->id,
                'user_id' => $users->random()->id,
                'status' => 'approved',
            ]);
        });

        Comment::factory(8)->create([
            'post_id' => $posts->random()->id,
            'user_id' => $users->random()->id,
            'status' => 'pending',
        ]);

        collect([
            'website_name' => 'BlogCraft',
            'website_description' => 'A polished Laravel blog for practical ideas, tutorials, and editorial stories.',
            'contact_email' => 'hello@example.com',
            'footer_text' => 'Copyright '.date('Y').' BlogCraft. All rights reserved.',
            'facebook_url' => 'https://facebook.com',
            'instagram_url' => 'https://instagram.com',
            'linkedin_url' => 'https://linkedin.com',
            'twitter_url' => 'https://x.com',
            'youtube_url' => 'https://youtube.com',
        ])->each(fn ($value, $key) => Setting::setValue($key, $value));

        ContactMessage::create([
            'name' => 'Jordan Lee',
            'email' => 'jordan@example.com',
            'subject' => 'Guest article idea',
            'message' => 'I would love to contribute a practical article about editorial workflows for small teams.',
        ]);

        NewsletterSubscription::firstOrCreate(['email' => 'reader@example.com']);
    }
}
