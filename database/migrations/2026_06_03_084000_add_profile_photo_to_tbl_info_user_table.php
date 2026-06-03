<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tbl_info_user', function ($table) {

            $table->string('profile_photo')
                ->nullable()
                ->after('address');

        });
    }

    public function down(): void
    {
        Schema::table('tbl_info_user', function ($table) {

            $table->dropColumn('profile_photo');

        });
    }
};
