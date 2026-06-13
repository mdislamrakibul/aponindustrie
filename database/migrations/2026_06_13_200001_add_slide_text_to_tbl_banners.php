<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_banners', function (Blueprint $table) {
            $table->text('slide_top')->nullable()->after('sort_order');
            $table->text('slide_title')->nullable()->after('slide_top');
            $table->text('slide_highlight')->nullable()->after('slide_title');
            $table->text('slide_desc')->nullable()->after('slide_highlight');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_banners', function (Blueprint $table) {
            $table->dropColumn(['slide_top', 'slide_title', 'slide_highlight', 'slide_desc']);
        });
    }
};
