<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

   protected $hidden = [
        'password',
        'remember_token',
    ];

    // A user can have many pages
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    // A user can have many posts
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // A user can upload many media items
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }


}
