<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    protected $table = 'tbl_episode';
    protected $primaryKey = 'eps_id';
    protected $guarded = [];
    protected $casts = ['status' => 'boolean'];
    public function movie() { return $this->belongsTo(Movie::class, 'movie_id'); }
    public function scopeActive($query) { return $query->where('status', true); }
}
