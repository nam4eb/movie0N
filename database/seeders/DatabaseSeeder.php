<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            CategorySeeder::class,
            CountrySeeder::class,
            GenreSeeder::class,
            MovieSeeder::class,
            RolesAndPermissionsSeeder::class, // Roles must be created before users
            UserSeeder::class,
            NewsSeeder::class,
            MovieViewsSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
