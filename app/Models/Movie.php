<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'tbl_movie';
    protected $primaryKey = 'movie_id';
    protected $guarded = [];
    protected $casts = ['status' => 'boolean', 'featured' => 'boolean'];

    public function getRouteKeyName() { return 'slug'; }
    public function genre() { return $this->belongsTo(Genre::class, 'genre_id'); }
    public function country() { return $this->belongsTo(Country::class, 'country_id'); }
    public function category() { return $this->belongsTo(Category::class, 'cat_id'); }
    public function episodes() { return $this->hasMany(Episode::class, 'movie_id'); }
    public function scopePublished($query) { return $query->where('status', true); }
    public function scopeFeatured($query) { return $query->where('featured', true); }
}
