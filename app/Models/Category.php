<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'tbl_category';
    protected $primaryKey = 'cat_id';
    public $timestamps = true;

    protected $fillable = [
        'cat_name',
        'description',
        'status',
    ];
}
