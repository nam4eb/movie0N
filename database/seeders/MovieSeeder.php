<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_movie')->truncate();

        $now = now();
        // Seed a few well-known samples for the homepage screenshots
        DB::table('tbl_movie')->insert([
            [
                'cat_id' => 1,
                'country_id' => 1,
                'genre_id' => 1,
                'eps_id' => 0,
                'movie_name' => 'Interstellar',
                'image' => 'interstellar.jpg',
                'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'status' => 1,
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'cat_id' => 1,
                'country_id' => 1,
                'genre_id' => 1,
                'eps_id' => 0,
                'movie_name' => 'Wall-e',
                'image' => 'wall-e.jpg',
                'description' => 'A small waste-collecting robot inadvertently embarks on a space journey.',
                'status' => 1,
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'cat_id' => 2,
                'country_id' => 4,
                'genre_id' => 2,
                'eps_id' => 1,
                'movie_name' => 'Squid Game',
                'image' => 'squid-game.jpg',
                'description' => 'Hundreds of cash-strapped players accept an invitation to compete in children\'s games.',
                'status' => 1,
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'cat_id' => 2,
                'country_id' => 1,
                'genre_id' => 2,
                'eps_id' => 1,
                'movie_name' => 'The Boys',
                'image' => 'the-boys.jpg',
                'description' => 'A group of vigilantes set out to take down corrupt superheroes.',
                'status' => 1,
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'cat_id' => 1,
                'country_id' => 1,
                'genre_id' => 1,
                'eps_id' => 0,
                'movie_name' => 'Star Wars',
                'image' => 'star-wars.jpg',
                'description' => 'The epic space opera saga.',
                'status' => 1,
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'cat_id' => 2,
                'country_id' => 3,
                'genre_id' => 3,
                'eps_id' => 1,
                'movie_name' => 'Arcane',
                'image' => 'arcane.jpg',
                'description' => 'Amid the stark discord of twin cities, two sisters fight on rival sides of a war.',
                'status' => 1,
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'cat_id' => 1,
                'country_id' => 1,
                'genre_id' => 1,
                'eps_id' => 0,
                'movie_name' => 'Captain America',
                'image' => 'captain-america.jpg',
                'description' => 'Steve Rogers becomes the patriotic super soldier Captain America.',
                'status' => 1,
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'cat_id' => 2,
                'country_id' => 2,
                'genre_id' => 4,
                'eps_id' => 1,
                'movie_name' => 'Sherlock Holmes',
                'image' => 'sherlock-holmes.jpg',
                'description' => 'Detective Sherlock Holmes and his stalwart partner Watson engage in a battle of wits.',
                'status' => 1,
                'created_at' => $now, 'updated_at' => $now,
            ],
        ]);

        // Create additional fake movies to ensure enough data for testing
        Movie::factory()->count(60)->create();
    }
}

