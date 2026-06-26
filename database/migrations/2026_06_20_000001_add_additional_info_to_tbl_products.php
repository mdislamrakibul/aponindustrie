<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_products', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_products', 'additional_info')) {
                $table->longText('additional_info')->nullable()->after('description');
            }
            if (!Schema::hasColumn('tbl_products', 'additional_info_active')) {
                $table->boolean('additional_info_active')->default(false)->after('additional_info');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_products', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_products', 'additional_info')) {
                $table->dropColumn('additional_info');
            }
            if (Schema::hasColumn('tbl_products', 'additional_info_active')) {
                $table->dropColumn('additional_info_active');
            }
        });
    }
};
