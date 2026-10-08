<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->with(['category', 'user'])
            ->when($request->query('q'), fn (Builder $query, string $q) => $query->search($q))
            ->when($request->query('category'), fn (Builder $query, string $category) => $query->where('category_id', $category))
            ->when($request->query('status'), fn (Builder $query, string $status) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        return view('admin.posts.form', [
            'post' => new Post(['status' => 'draft', 'published_at' => now()]),
            'categories' => Category::where('status', true)->orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'selectedTags' => [],
        ]);
    }

    public function store(PostRequest $request, ImageUploadService $images)
    {
        $data = $this->preparedData($request->validated());
        $data['user_id'] = $request->user()->id;
        $data['featured_image'] = $images->replace(null, $request->file('featured_image'), 'posts');

        $post = Post::create($data);
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.posts.index')->with('success', 'Post created.');
    }

    public function show(Post $post)
    {
        return redirect()->route('admin.posts.edit', $post);
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', [
            'post' => $post->load('tags'),
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'selectedTags' => $post->tags->pluck('id')->all(),
        ]);
    }

    public function update(PostRequest $request, Post $post, ImageUploadService $images)
    {
        $data = $this->preparedData($request->validated());
        $data['featured_image'] = $images->replace($post->featured_image, $request->file('featured_image'), 'posts');

        $post->update($data);
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.posts.index')->with('success', 'Post updated.');
    }

    public function destroy(Post $post, ImageUploadService $images)
    {
        $images->delete($post->featured_image);
        $post->delete();

        return back()->with('success', 'Post deleted.');
    }

    public function publish(Post $post)
    {
        $post->update([
            'status' => $post->status === 'published' ? 'draft' : 'published',
            'published_at' => $post->status === 'published' ? null : ($post->published_at ?? now()),
        ]);

        return back()->with('success', 'Publication status updated.');
    }

    public function feature(Post $post)
    {
        $post->update(['is_featured' => ! $post->is_featured]);

        return back()->with('success', 'Featured status updated.');
    }

    private function preparedData(array $data): array
    {
        unset($data['tags']);

        if (($data['status'] ?? 'draft') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if (($data['status'] ?? 'draft') === 'draft') {
            $data['published_at'] = null;
        }

        return $data;
    }
}
