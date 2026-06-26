<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Use raw ALTER TABLE — no doctrine/dbal dependency needed on shared hosting.
        // Guard: only run if the column currently exists and is NOT NULL.
        if (Schema::hasColumn('tbl_order_addresses', 'email')) {
            DB::statement("ALTER TABLE `tbl_order_addresses` MODIFY `email` VARCHAR(255) NULL DEFAULT NULL");
        }
    }

    public function down(): void
    {
        // Intentionally left as a no-op: reverting to NOT NULL would break existing
        // rows that have null email, and the new district-based checkout always omits email.
    }
};
