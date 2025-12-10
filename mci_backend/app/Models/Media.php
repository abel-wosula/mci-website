<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    protected $fillable = [
        'filename',
        'original_name',
        'path',
        'mime_type',
        'size',
        'type',
        'user_id',
    ];

    // The model this media item is attached to (Page, Post, etc.)
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    // The user that uploaded the media
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessor to return full URL
    public function getUrlAttribute()
    {
        return asset('storage/media/' . $this->path);
    }
}

