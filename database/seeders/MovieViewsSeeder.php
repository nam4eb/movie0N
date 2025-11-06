<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieViewsSeeder extends Seeder
{
    public function run(): void
    {
        // Seed some random movie views for the current month for top-movie-this-month widget
        $movieIds = DB::table('tbl_movie')->pluck('movie_id')->all();
        $rows = [];
        $now = now();
        if (empty($movieIds)) return;

        $count = 500; // total fake views
        for ($i = 0; $i < $count; $i++) {
            $rows[] = [
                'movie_id' => $movieIds[array_rand($movieIds)],
                'user_id' => null,
                'ip' => '127.0.0.' . rand(1, 254),
                'created_at' => $now->copy()->subDays(rand(0, 29))->subMinutes(rand(0, 1440)),
                'updated_at' => $now,
            ];
        }

        DB::table('movie_views')->truncate();
        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('movie_views')->insert($chunk);
        }
    }
}

