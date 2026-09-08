<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMovie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_movie', function (Blueprint $table) {
            $table->Increments('movie_id');
            $table->unsignedInteger('cat_id')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('genre_id')->nullable();
            $table->string('movie_name');
            $table->string('original_name')->nullable();
            $table->string('slug')->unique();
            $table->string('image');
            $table->string('backdrop')->nullable();
            $table->text('description');
            $table->string('trailer')->nullable();
            $table->enum('type', ['movie', 'series'])->default('movie');
            $table->unsignedSmallInteger('release_year')->nullable();
            $table->unsignedSmallInteger('duration')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('cat_id')->references('cat_id')->on('tbl_category')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_movie');
    }
}
