<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieView extends Model
{
    protected $table = 'movie_views';

    protected $fillable = ['movie_id', 'user_id', 'ip'];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }
}

