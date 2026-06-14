<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('tbl_banners')->where('type', 'SLIDER')
            ->update(['rec_width' => 655, 'rec_height' => 330]);

        DB::table('tbl_banners')->whereIn('slot', ['banner_1', 'banner_2'])
            ->update(['rec_width' => 218, 'rec_height' => 155]);
    }

    public function down(): void
    {
        DB::table('tbl_banners')->where('type', 'SLIDER')
            ->update(['rec_width' => 731, 'rec_height' => 470]);

        DB::table('tbl_banners')->whereIn('slot', ['banner_1', 'banner_2'])
            ->update(['rec_width' => 370, 'rec_height' => 200]);
    }
};
