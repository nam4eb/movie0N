<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_country')->truncate();
        DB::table('tbl_country')->insert([
            ['country_name' => 'USA', 'description' => 'United States', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['country_name' => 'UK', 'description' => 'United Kingdom', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['country_name' => 'Japan', 'description' => 'Japan', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['country_name' => 'Korea', 'description' => 'South Korea', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['country_name' => 'Vietnam', 'description' => 'Vietnam', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

