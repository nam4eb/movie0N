<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id', 'episode_id', 'lang', 'label', 'vtt_url', 'is_default'
    ];
}

