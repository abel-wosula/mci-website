<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(
            Post::with(['user'])->latest()->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'status' => 'in:draft,published',
        ]);

        // Auto-generate slug
        $data['slug'] = Str::slug($data['title']) . '-' . time();
        $data['user_id'] = auth()->user()->id ?? 1;

        $post = Post::create($data);

        return new PostResource($post->load(['user']));
    }

    public function show(Post $post)
    {
        return new PostResource($post->load(['user']));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'   => 'sometimes|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'status' => 'in:draft,published',
        ]);

        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']) . '-' . time();
        }

        $post->update($data);

        return new PostResource($post->load(['user']));
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }
}
