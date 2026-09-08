<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::firstOrCreate(['cat_name' => 'Phim'], ['description' => 'Kho phim', 'status' => true]);
        $genre = Genre::firstOrCreate(['genre_name' => 'Khoa học viễn tưởng'], ['description' => 'Khoa học viễn tưởng', 'status' => true]);
        $country = Country::firstOrCreate(['country_name' => 'Hoa Kỳ'], ['description' => 'Phim Hoa Kỳ', 'status' => true]);

        $movie = Movie::updateOrCreate(['slug' => 'interstellar'], [
            'cat_id' => $category->cat_id, 'genre_id' => $genre->genre_id, 'country_id' => $country->country_id,
            'movie_name' => 'Interstellar', 'original_name' => 'Interstellar', 'image' => 'interstellar.jpg',
            'backdrop' => 'fav-film-4.jpg', 'description' => 'Một nhóm nhà du hành đi qua hố sâu không gian để tìm mái nhà mới cho nhân loại.',
            'type' => 'movie', 'release_year' => 2014, 'duration' => 169, 'rating' => 8.7, 'featured' => true, 'status' => true,
        ]);
        Episode::updateOrCreate(['movie_id' => $movie->movie_id, 'eps_num' => 1, 'server' => 'Demo'], ['title' => 'Bản đầy đủ', 'link' => 'https://www.youtube.com/embed/zSWdZVtXT7E', 'status' => true]);

        if ($password = env('ADMIN_PASSWORD')) {
            User::updateOrCreate(['email' => env('ADMIN_EMAIL', 'admin@movieon.local')], ['name' => 'Administrator', 'password' => Hash::make($password), 'is_admin' => true]);
        }
    }
}
