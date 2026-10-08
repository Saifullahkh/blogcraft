<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $urls = collect([
            ['loc' => route('home'), 'updated' => now()],
            ['loc' => route('blog.index'), 'updated' => now()],
            ['loc' => route('about'), 'updated' => now()],
            ['loc' => route('contact.create'), 'updated' => now()],
        ]);

        Post::published()->latest('updated_at')->get()->each(function (Post $post) use ($urls): void {
            $urls->push(['loc' => route('blog.show', $post), 'updated' => $post->updated_at]);
        });

        Category::where('status', true)->latest('updated_at')->get()->each(function (Category $category) use ($urls): void {
            $urls->push(['loc' => route('categories.show', $category), 'updated' => $category->updated_at]);
        });

        return response()->view('sitemap', compact('urls'))->header('Content-Type', 'application/xml');
    }
}
