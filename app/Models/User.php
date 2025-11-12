<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Movie;
use App\Models\Comment;
use App\Models\Playlist;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The movies that the user has favorited.
     */
    public function favorites()
    {
        return $this->belongsToMany(Movie::class, 'favorites', 'user_id', 'movie_id')->withTimestamps();
    }

    /**
     * The comments that the user has posted.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The playlists that the user has created.
     */
    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }


    /**
     * The movies that the user is following.
     */
    public function follows()
    {
        return $this->belongsToMany(Movie::class, 'follows', 'user_id', 'movie_id')->withTimestamps();
    }


    /**
     * The ratings that the user has submitted.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
