<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Consolidated schema reconcile for live server.
     *
     * Each column is guarded with Schema::hasColumn so this is safe to run
     * even if some columns already exist (partial prior migration). Because
     * this file has a fresh timestamp, live's migrations table has no record
     * of it — `migrate --force` will always run it, bypassing the
     * "recorded-but-not-applied" risk of older migration files.
     */
    public function up(): void
    {
        // ── activity_logs.performed_by ──────────────────────────────────────
        Schema::table('activity_logs', function (Blueprint $t) {
            if (!Schema::hasColumn('activity_logs', 'performed_by')) {
                $t->string('performed_by')->nullable()->after('user_id');
            }
        });

        // ── tbl_products: additional_info + additional_info_active ──────────
        Schema::table('tbl_products', function (Blueprint $t) {
            if (!Schema::hasColumn('tbl_products', 'additional_info')) {
                $t->longText('additional_info')->nullable();
            }
            if (!Schema::hasColumn('tbl_products', 'additional_info_active')) {
                $t->boolean('additional_info_active')->default(0);
            }
        });

        // ── tbl_order_addresses: district + thana ───────────────────────────
        Schema::table('tbl_order_addresses', function (Blueprint $t) {
            if (!Schema::hasColumn('tbl_order_addresses', 'district')) {
                $t->string('district')->nullable();
            }
            if (!Schema::hasColumn('tbl_order_addresses', 'thana')) {
                $t->string('thana')->nullable();
            }
        });

        // ── tbl_order_addresses.email → NULL ────────────────────────────────
        // Raw ALTER TABLE — no doctrine/dbal dependency (safe on shared hosting).
        // The district-based checkout does not collect email, so null inserts must
        // be allowed. Running this when the column is already nullable is harmless.
        DB::statement("ALTER TABLE `tbl_order_addresses` MODIFY `email` VARCHAR(255) NULL DEFAULT NULL");
    }

    public function down(): void
    {
        // Intentional no-op: never drop or constrain these columns on rollback.
        // Removing columns risks data loss; reverting email to NOT NULL would
        // immediately break the live checkout again.
    }
};
