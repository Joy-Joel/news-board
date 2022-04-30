<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $vote
 * @property int $post_id
 * @property int $user_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Vote extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];



}
