<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('playlist_movie', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('playlist_id');
            $table->unsignedInteger('movie_id');
            $table->timestamps();

            $table->foreign('playlist_id')->references('id')->on('playlists')->onDelete('cascade');
            $table->foreign('movie_id')->references('movie_id')->on('tbl_movie')->onDelete('cascade');

            $table->unique(['playlist_id', 'movie_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('playlist_movie');
    }
};

