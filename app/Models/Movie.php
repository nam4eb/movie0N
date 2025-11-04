<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Playlist;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'tbl_movie';
    protected $primaryKey = 'movie_id';
    public $timestamps = true;

    protected $fillable = [
        'cat_id',
        'country_id',
        'genre_id',
        'eps_id',
        'movie_name',
        'image',
        'description',
        'status',
    ];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'movie_id', 'user_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'movie_id', 'movie_id');
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_movie', 'movie_id', 'playlist_id');
    }

}
