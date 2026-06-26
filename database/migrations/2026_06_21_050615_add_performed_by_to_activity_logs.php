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
        Schema::table('activity_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('activity_logs', 'performed_by')) {
                $table->string('performed_by')->nullable()->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            if (Schema::hasColumn('activity_logs', 'performed_by')) {
                $table->dropColumn('performed_by');
            }
        });
    }
};
