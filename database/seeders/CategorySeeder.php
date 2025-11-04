<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_category')->truncate();
        DB::table('tbl_category')->insert([
            ['cat_name' => 'Movie', 'description' => 'Feature films', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['cat_name' => 'TV Series', 'description' => 'Television series', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['cat_name' => 'Anime', 'description' => 'Japanese animation', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

