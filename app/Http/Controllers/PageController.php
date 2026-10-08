<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class PageController extends Controller
{
    public function home()
    {
        $featuredPosts = Post::published()->where('is_featured', true)->with(['category', 'user'])->latest('published_at')->take(3)->get();
        $latestPosts = Post::published()->with(['category', 'user'])->latest('published_at')->take(6)->get();
        $popularPosts = Post::published()->with(['category', 'user'])->orderByDesc('views')->take(4)->get();
        $categories = Category::query()->where('status', true)->withCount(['posts as published_posts_count' => fn ($query) => $query->published()])->orderBy('name')->take(8)->get();

        return view('pages.home', compact('featuredPosts', 'latestPosts', 'popularPosts', 'categories'));
    }

    public function about()
    {
        $stats = [
            'posts' => Post::published()->count(),
            'categories' => Category::where('status', true)->count(),
            'comments' => Comment::where('status', 'approved')->count(),
            'authors' => User::whereHas('posts', fn ($query) => $query->published())->count(),
        ];

        return view('pages.about', compact('stats'));
    }
}
