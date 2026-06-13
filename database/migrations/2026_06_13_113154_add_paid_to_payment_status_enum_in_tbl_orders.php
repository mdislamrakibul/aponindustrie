<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'PAID' to the payment_status ENUM (was missing from original definition)
        DB::statement("ALTER TABLE tbl_orders MODIFY COLUMN payment_status ENUM('PENDING','PAID','COMPLETE','FAILED','REFUNDED') NOT NULL DEFAULT 'PENDING'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE tbl_orders MODIFY COLUMN payment_status ENUM('PENDING','COMPLETE','FAILED','REFUNDED') NOT NULL DEFAULT 'PENDING'");
    }
};
