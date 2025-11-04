<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition(): array
    {
        $images = [
            'interstellar.jpg','wall-e.jpg','star-wars.jpg','arcane.jpg','captain-america.jpg','sherlock-holmes.jpg','alien.jpg','avenger.jpg','dune.jpg','the-boys.jpg','peaky-blinders.jpg','the-witcher.jpg','squid-game.jpg','vincenzo.jpg','itewon-class.jpg','guardians-of-the-galaxy.jpg','ironman.jpg','man-of-steel.jpg','titanic.jpg','the-hobbit.jpg','sherlock.jpg','theboys.jpg','spiderman.png','the-shining.jpg','the-walk.webp','godfather.jpg','her.jpg','black-panther.jpg','avatar.jpg','thor.jpg'
        ];

        return [
            'cat_id' => $this->faker->numberBetween(1, 3),
            'country_id' => $this->faker->numberBetween(1, 5),
            'genre_id' => $this->faker->numberBetween(1, 5),
            'eps_id' => $this->faker->boolean ? 1 : 0,
            'movie_name' => ucfirst($this->faker->unique()->words(3, true)),
            'image' => $this->faker->randomElement($images),
            'description' => $this->faker->paragraph(2),
            'status' => $this->faker->boolean ? 1 : 0,
            'created_at' => now()->subDays($this->faker->numberBetween(0, 120)),
            'updated_at' => now(),
        ];
    }
}

