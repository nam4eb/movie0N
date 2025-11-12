<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    protected $table = 'user_progress';

    protected $fillable = [
        'user_id', 'movie_id', 'episode_id', 'position_seconds', 'duration_seconds', 'last_seen_at'
    ];
}

