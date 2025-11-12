<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $table = 'tbl_episode';
    protected $primaryKey = 'eps_id';
    public $timestamps = true;

    protected $fillable = [
        'movie_id', 'eps_num', 'link'
    ];
}
