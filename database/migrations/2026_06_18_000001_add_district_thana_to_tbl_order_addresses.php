<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_order_addresses', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_order_addresses', 'district')) {
                $table->string('district')->nullable()->after('address_line1');
            }
            if (!Schema::hasColumn('tbl_order_addresses', 'thana')) {
                $table->string('thana')->nullable()->after('district');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_order_addresses', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_order_addresses', 'district')) {
                $table->dropColumn('district');
            }
            if (Schema::hasColumn('tbl_order_addresses', 'thana')) {
                $table->dropColumn('thana');
            }
        });
    }
};
