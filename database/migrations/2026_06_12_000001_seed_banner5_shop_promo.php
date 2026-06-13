<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('tbl_banners')->insertOrIgnore([
            'type'        => 'BANNER',
            'slot'        => 'banner_5',
            'label'       => 'Shop Page Promo Banner',
            'image_path'  => 'assets/uploads/Left Side Adv Banner/Apon Plastic Left Side Adv Banner_Apon Plastic.png',
            'rec_width'   => 600,
            'rec_height'  => 687,
            'sort_order'  => 5,
            'is_locked'   => true,
            'is_active'   => true,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('tbl_banners')->where('slot', 'banner_5')->delete();
    }
};
