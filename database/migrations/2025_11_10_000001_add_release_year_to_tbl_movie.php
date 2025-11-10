<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tbl_movie', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_movie', 'release_year')) {
                $table->integer('release_year')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_movie', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_movie', 'release_year')) {
                $table->dropColumn('release_year');
            }
        });
    }
};

