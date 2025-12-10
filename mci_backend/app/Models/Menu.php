<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'label',
        'url',
        'page_id',
        'parent_id',
        'order',
        'location',
        'is_active',
    ];

    // If menu links to a page
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    // Parent menu item
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Child menu items
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }
}
