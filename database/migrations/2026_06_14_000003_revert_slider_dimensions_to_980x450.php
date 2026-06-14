<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('tbl_banners')->where('type', 'SLIDER')
            ->update(['rec_width' => 980, 'rec_height' => 450]);
    }

    public function down(): void
    {
        DB::table('tbl_banners')->where('type', 'SLIDER')
            ->update(['rec_width' => 655, 'rec_height' => 330]);
    }
};
