<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Post $post)
    {
        abort_unless($post->status === 'published', 404);

        $parentId = $request->validated('parent_id');

        if ($parentId) {
            abort_unless(Comment::where('post_id', $post->id)->whereKey($parentId)->exists(), 422);
        }

        Comment::create([
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
            'parent_id' => $parentId,
            'comment' => $request->validated('comment'),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your comment is awaiting moderation.');
    }
}
