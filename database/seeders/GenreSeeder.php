<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_genre')->truncate();
        DB::table('tbl_genre')->insert([
            ['genre_name' => 'Action', 'description' => 'Action packed', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['genre_name' => 'Drama', 'description' => 'Dramatic stories', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['genre_name' => 'Sci-Fi', 'description' => 'Science fiction', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['genre_name' => 'Crime', 'description' => 'Crime and mystery', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['genre_name' => 'Fantasy', 'description' => 'Fantasy worlds', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

