<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $title
 * @property string $link
 * @property int $author_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
    * Get the comments for the news post.
    */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
    * Get the author for the news post.
    */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
    * Get the votes for the news post.
    */
    public function votes(): HasMany
    {
        return $this->hasMany(Votes::class);
    }

}
