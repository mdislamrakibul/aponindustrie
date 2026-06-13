<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_banners', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['SLIDER', 'BANNER']);
            $table->string('slot')->nullable()->unique();
            $table->string('label');
            $table->string('image_path')->nullable();
            $table->integer('rec_width')->default(0);
            $table->integer('rec_height')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_locked')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();

        // Seed sliders
        $sliders = [
            ['slot' => 'slider_1', 'label' => 'Main Slider 1', 'image_path' => 'assets/uploads/Main Slider Design/Main Slider Design-1-Apon Plastic.png', 'sort_order' => 1, 'is_locked' => true],
            ['slot' => 'slider_2', 'label' => 'Main Slider 2', 'image_path' => 'assets/uploads/Main Slider Design/Main Slider Design-2-Apon Plastic.png', 'sort_order' => 2, 'is_locked' => false],
            ['slot' => 'slider_3', 'label' => 'Main Slider 3', 'image_path' => 'assets/uploads/Main Slider Design/Main Slider Design-3-Apon Plastic.png', 'sort_order' => 3, 'is_locked' => false],
            ['slot' => 'slider_4', 'label' => 'Main Slider 4', 'image_path' => 'assets/uploads/Main Slider Design/Main Slider Design-4-Apon Plastic.png', 'sort_order' => 4, 'is_locked' => false],
            ['slot' => 'slider_5', 'label' => 'Main Slider 5', 'image_path' => 'assets/uploads/Main Slider Design/Main Slider Design-5-Apon Plastic.png', 'sort_order' => 5, 'is_locked' => false],
        ];

        foreach ($sliders as $s) {
            DB::table('tbl_banners')->insert([
                'type'        => 'SLIDER',
                'slot'        => $s['slot'],
                'label'       => $s['label'],
                'image_path'  => $s['image_path'],
                'rec_width'   => 731,
                'rec_height'  => 470,
                'sort_order'  => $s['sort_order'],
                'is_locked'   => $s['is_locked'],
                'is_active'   => true,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }

        // Seed banners
        $banners = [
            [
                'slot'       => 'banner_1',
                'label'      => 'Right Side Banner 1',
                'image_path' => 'assets/uploads/Right Banner/Pink and Blue Modern Aesthetic Fashion Facebook Cover.png',
                'rec_width'  => 370,
                'rec_height' => 200,
                'sort_order' => 1,
            ],
            [
                'slot'       => 'banner_2',
                'label'      => 'Right Side Banner 2',
                'image_path' => 'assets/uploads/Right Banner/Right banner_Apon Plastic.png',
                'rec_width'  => 370,
                'rec_height' => 200,
                'sort_order' => 2,
            ],
            [
                'slot'       => 'banner_3',
                'label'      => 'Large Advertisement Banner',
                'image_path' => 'assets/uploads/Large Adv/Large Adv_Apon Plastic-1.png',
                'rec_width'  => 1320,
                'rec_height' => 300,
                'sort_order' => 3,
            ],
            [
                'slot'       => 'banner_4',
                'label'      => 'Left Side Full-Height Banner',
                'image_path' => 'assets/uploads/Left Side Adv Banner/Apon Plastic Left Side Adv Banner_Apon Plastic.png',
                'rec_width'  => 315,
                'rec_height' => 550,
                'sort_order' => 4,
            ],
        ];

        foreach ($banners as $b) {
            DB::table('tbl_banners')->insert([
                'type'        => 'BANNER',
                'slot'        => $b['slot'],
                'label'       => $b['label'],
                'image_path'  => $b['image_path'],
                'rec_width'   => $b['rec_width'],
                'rec_height'  => $b['rec_height'],
                'sort_order'  => $b['sort_order'],
                'is_locked'   => true,
                'is_active'   => true,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_banners');
    }
};
