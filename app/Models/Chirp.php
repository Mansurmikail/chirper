<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chirp extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'message',
    ];

    /**
     * Get the user that owns the chirp.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the likes for the chirp.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

        /**
     * Get the comments for the chirp.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}