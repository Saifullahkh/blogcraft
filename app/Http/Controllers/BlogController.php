<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = $this->baseListingQuery($request)->paginate(9)->withQueryString();
        $categories = Category::where('status', true)->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('blog.index', compact('posts', 'categories', 'tags'));
    }

    public function show(Post $post)
    {
        abort_unless($post->status === 'published' && $post->published_at && $post->published_at->lte(now()), 404);

        $post->increment('views');
        $post->load(['category', 'tags', 'user']);

        $comments = Comment::where('post_id', $post->id)
            ->whereNull('parent_id')
            ->where('status', 'approved')
            ->with(['user', 'approvedReplies.user', 'approvedReplies.approvedReplies.user'])
            ->latest()
            ->get();

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->with(['category', 'user'])
            ->latest('published_at')
            ->take(3)
            ->get();

        $previousPost = Post::published()->where('published_at', '<', $post->published_at)->latest('published_at')->first();
        $nextPost = Post::published()->where('published_at', '>', $post->published_at)->oldest('published_at')->first();

        return view('blog.show', compact('post', 'comments', 'relatedPosts', 'previousPost', 'nextPost'));
    }

    public function category(Category $category)
    {
        abort_unless($category->status, 404);

        $posts = Post::published()
            ->whereBelongsTo($category)
            ->with(['category', 'user'])
            ->latest('published_at')
            ->paginate(9);

        return view('categories.show', compact('category', 'posts'));
    }

    public function tag(Tag $tag)
    {
        $posts = Post::published()
            ->whereHas('tags', fn (Builder $query) => $query->whereKey($tag->id))
            ->with(['category', 'user'])
            ->latest('published_at')
            ->paginate(9);

        return view('tags.show', compact('tag', 'posts'));
    }

    private function baseListingQuery(Request $request): Builder
    {
        return Post::published()
            ->with(['category', 'user'])
            ->search($request->query('q'))
            ->when($request->query('category'), function (Builder $query, string $slug): void {
                $query->whereHas('category', fn (Builder $categoryQuery) => $categoryQuery->where('slug', $slug));
            })
            ->when($request->query('tag'), function (Builder $query, string $slug): void {
                $query->whereHas('tags', fn (Builder $tagQuery) => $tagQuery->where('slug', $slug));
            })
            ->when($request->query('sort') === 'oldest', fn (Builder $query) => $query->oldest('published_at'))
            ->when($request->query('sort') === 'popular', fn (Builder $query) => $query->orderByDesc('views'))
            ->when(! in_array($request->query('sort'), ['oldest', 'popular'], true), fn (Builder $query) => $query->latest('published_at'));
    }
}
