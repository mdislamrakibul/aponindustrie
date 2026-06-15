<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_banners', function (Blueprint $table) {
            $table->boolean('hide_text')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('tbl_banners', function (Blueprint $table) {
            $table->dropColumn('hide_text');
        });
    }
};
