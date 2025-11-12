<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subtitles', function (Blueprint $table) {
            $table->id();
            $table->integer('movie_id')->nullable();
            $table->unsignedInteger('episode_id')->nullable();
            $table->string('lang', 12); // vi, en-US, ja, etc.
            $table->string('label', 64); // Tiếng Việt, English
            $table->string('vtt_url');
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['movie_id','episode_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subtitles');
    }
};

