<?php

namespace App\Http\Controllers\Api;

use App\Models\Media;
use App\Http\Resources\MediaResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        return MediaResource::collection(
            Media::with('user', 'mediable')->latest()->paginate(20)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'file'          => 'required|file|max:10240', // max 10MB
            'mediable_id'   => 'required|integer',
            'mediable_type' => 'required|string',
        ]);

        // Store the file
        $path = $request->file('file')->store('media');

        $file = $request->file('file');

        $media = Media::create([
            'filename'      => $file->hashName(),
            'original_name' => $file->getClientOriginalName(),
            'path'          => $path,
            'mime_type'     => $file->getClientMimeType(),
            'size'          => $file->getSize(),
            'type'          => $file->getClientOriginalExtension(),
            'user_id'       => auth()->id(),
            'mediable_id'   => $data['mediable_id'],
            'mediable_type' => $data['mediable_type'],
        ]);

        return new MediaResource($media->load('user', 'mediable'));
    }

    public function show(Media $media)
    {
        return new MediaResource($media->load('user', 'mediable'));
    }

    public function update(Request $request, Media $media)
    {
        $data = $request->validate([
            'filename' => 'sometimes|string',
            'type'     => 'sometimes|string',
        ]);

        $media->update($data);

        return new MediaResource($media->load('user', 'mediable'));
    }

    public function destroy(Media $media)
    {
        // Delete the file from storage if exists
        if (Storage::exists($media->path)) {
            Storage::delete($media->path);
        }

        $media->delete();

        return response()->json(['message' => 'Media deleted']);
    }
}
