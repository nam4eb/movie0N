<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'tbl_genre';
    protected $primaryKey = 'genre_id';
    public $timestamps = true;

    protected $fillable = [
        'genre_name',
        'description',
        'status',
    ];
}
