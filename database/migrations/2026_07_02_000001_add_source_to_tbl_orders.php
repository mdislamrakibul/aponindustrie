<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('tbl_orders', 'source')) {
            return;
        }

        Schema::table('tbl_orders', function (Blueprint $table) {
            $table->string('source', 20)->default('online')->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_orders', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};
