<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'tbl_country';
    protected $primaryKey = 'country_id';
    protected $guarded = [];
    protected $casts = ['status' => 'boolean'];
    public function movies() { return $this->hasMany(Movie::class, 'country_id'); }
    public function scopeActive($query) { return $query->where('status', true); }
}
