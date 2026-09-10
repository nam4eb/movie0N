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
            $table->integer('cat_id');
            $table->integer('country_id');
            $table->integer('genre_id');
            $table->integer('eps_id');
            $table->string('movie_name');
            $table->string('image');
            $table->string('description');
            $table->integer('status');
            $table->timestamps();
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
