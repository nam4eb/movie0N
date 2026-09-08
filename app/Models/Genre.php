<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $table = 'tbl_genre';
    protected $primaryKey = 'genre_id';
    protected $guarded = [];
    protected $casts = ['status' => 'boolean'];
    public function movies() { return $this->hasMany(Movie::class, 'genre_id'); }
    public function scopeActive($query) { return $query->where('status', true); }
}
