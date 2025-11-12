<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tbl_movie', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_movie','release_year')) {
                // release_year may be added by another migration; skip here
            }
            $table->index('cat_id');
            $table->index('genre_id');
            $table->index('country_id');
            $table->index('release_year');
            $table->index('created_at');
        });
        if (Schema::hasTable('favorites')) {
            Schema::table('favorites', function (Blueprint $table) {
                $table->index('movie_id');
                $table->index('user_id');
            });
        }
        if (Schema::hasTable('playlist_movie')) {
            Schema::table('playlist_movie', function (Blueprint $table) {
                $table->index('playlist_id');
                $table->index('movie_id');
            });
        }
        if (Schema::hasTable('movie_views')) {
            Schema::table('movie_views', function (Blueprint $table) {
                $table->index('movie_id');
                $table->index('created_at');
            });
        }
    }

    public function down(): void
    {
        Schema::table('tbl_movie', function (Blueprint $table) {
            // Dropping indexes by column name
            $table->dropIndex(['cat_id']);
            $table->dropIndex(['genre_id']);
            $table->dropIndex(['country_id']);
            $table->dropIndex(['release_year']);
            $table->dropIndex(['created_at']);
        });
        if (Schema::hasTable('favorites')) {
            Schema::table('favorites', function (Blueprint $table) {
                $table->dropIndex(['movie_id']);
                $table->dropIndex(['user_id']);
            });
        }
        if (Schema::hasTable('playlist_movie')) {
            Schema::table('playlist_movie', function (Blueprint $table) {
                $table->dropIndex(['playlist_id']);
                $table->dropIndex(['movie_id']);
            });
        }
        if (Schema::hasTable('movie_views')) {
            Schema::table('movie_views', function (Blueprint $table) {
                $table->dropIndex(['movie_id']);
                $table->dropIndex(['created_at']);
            });
        }
    }
};

