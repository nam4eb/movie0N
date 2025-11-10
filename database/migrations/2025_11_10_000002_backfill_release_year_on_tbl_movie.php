<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Backfill release_year from created_at if null
        try {
            DB::statement("UPDATE tbl_movie SET release_year = YEAR(created_at) WHERE release_year IS NULL");
        } catch (\Throwable $e) {
            // ignore if table/column not ready when running in some environments
        }
    }

    public function down(): void
    {
        // No-op
    }
};

