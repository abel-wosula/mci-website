<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'is_published',
        'user_id',
    ];

    // This page belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // This page can have many media items attached
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
