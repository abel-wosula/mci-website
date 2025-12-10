<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    // A role can belong to many users
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}