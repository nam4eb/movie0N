<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblEpisode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_episode', function (Blueprint $table) {
            $table->Increments('eps_id');
            $table->unsignedInteger('movie_id');
            $table->unsignedInteger('eps_num');
            $table->string('title')->nullable();
            $table->string('server')->default('Default');
            $table->string('link');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['movie_id', 'eps_num', 'server']);
            $table->foreign('movie_id')->references('movie_id')->on('tbl_movie')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_episode');
    }
}
