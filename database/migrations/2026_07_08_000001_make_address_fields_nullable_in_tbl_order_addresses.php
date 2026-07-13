<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Use raw ALTER TABLE — no doctrine/dbal dependency needed on shared hosting.
        // Guard: only run if the column currently exists. Manual/POS orders
        // (AdminOrderController@storeManual) intentionally allow address,
        // district, and thana to be left blank — only name and phone are
        // required — so these columns must accept NULL.
        if (Schema::hasColumn('tbl_order_addresses', 'address_line1')) {
            DB::statement("ALTER TABLE `tbl_order_addresses` MODIFY `address_line1` VARCHAR(500) NULL DEFAULT NULL");
        }
        if (Schema::hasColumn('tbl_order_addresses', 'district')) {
            DB::statement("ALTER TABLE `tbl_order_addresses` MODIFY `district` VARCHAR(100) NULL DEFAULT NULL");
        }
        if (Schema::hasColumn('tbl_order_addresses', 'thana')) {
            DB::statement("ALTER TABLE `tbl_order_addresses` MODIFY `thana` VARCHAR(100) NULL DEFAULT NULL");
        }
    }

    public function down(): void
    {
        // Intentionally left as a no-op: reverting to NOT NULL would break existing
        // rows that have null address/district/thana from manual orders.
    }
};
