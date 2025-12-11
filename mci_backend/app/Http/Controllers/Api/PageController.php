<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use App\Http\Resources\PageResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        return PageResource::collection(
            Page::with(['user'])->latest()->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string',
            'content'        => 'nullable|string',
            'featured_image' => 'nullable|string',
            'is_published'   => 'boolean',
        ]);

        $data['slug']    = Str::slug($data['title']) . '-' . time();
        $data['user_id'] = auth()->user()->id ?? 1;

        $page = Page::create($data);

        return new PageResource($page->load(['user']));
    }

    public function show(Page $page)
    {
        return new PageResource($page->load(['user']));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title'          => 'sometimes|string',
            'content'        => 'nullable|string',
            'featured_image' => 'nullable|string',
            'is_published'   => 'boolean',
        ]);

        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']) . '-' . time();
        }

        $page->update($data);

        return new PageResource($page->load(['user']));
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return response()->json(['message' => 'Page deleted']);
    }
}
