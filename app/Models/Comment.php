<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

       /**
     * Get the news post that owns the comment.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
