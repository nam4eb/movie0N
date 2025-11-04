<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movie_views', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('movie_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip')->nullable();
            $table->timestamps();

            $table->index(['movie_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_views');
    }
};

