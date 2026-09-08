<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'tbl_category';
    protected $primaryKey = 'cat_id';
    protected $guarded = [];
    protected $casts = ['status' => 'boolean'];
    public function movies() { return $this->hasMany(Movie::class, 'cat_id'); }
    public function scopeActive($query) { return $query->where('status', true); }
}
