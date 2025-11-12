<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('movie_id');
            $table->unsignedInteger('episode_id')->nullable();
            $table->unsignedInteger('position_seconds')->default(0);
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->timestamp('last_seen_at')->useCurrent();
            $table->timestamps();

            $table->unique(['user_id','movie_id','episode_id']);
            $table->index(['user_id','last_seen_at']);
            $table->index(['movie_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};

