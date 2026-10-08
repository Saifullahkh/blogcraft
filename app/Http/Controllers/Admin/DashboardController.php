<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'categories' => Category::count(),
            'users' => User::count(),
            'comments' => Comment::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'views' => Post::sum('views'),
        ];

        $recentPosts = Post::with(['user', 'category'])->latest()->take(5)->get();
        $recentComments = Comment::with(['user', 'post'])->latest()->take(5)->get();
        $mostViewedPosts = Post::with('category')->orderByDesc('views')->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentComments', 'mostViewedPosts', 'recentUsers'));
    }
}
