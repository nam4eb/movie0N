<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Playlist;
use App\Models\Country;
use App\Models\Category;
use App\Models\Genre;

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
        'release_year',
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

    // Relations for convenience in views
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'cat_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'genre_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'movie_id', 'user_id')->withTimestamps();
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class, 'movie_id', 'movie_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'movie_id', 'movie_id');
    }

    public function views()
    {
        return $this->hasMany(MovieView::class, 'movie_id', 'movie_id');
    }
}


