<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Rename slide_* → text_* for slider overlay feature (CHANGE preserves column type)
        DB::statement('ALTER TABLE tbl_banners CHANGE COLUMN slide_top       text_top       TEXT NULL');
        DB::statement('ALTER TABLE tbl_banners CHANGE COLUMN slide_title     text_title     TEXT NULL');
        DB::statement('ALTER TABLE tbl_banners CHANGE COLUMN slide_highlight text_highlight TEXT NULL');
        DB::statement('ALTER TABLE tbl_banners CHANGE COLUMN slide_desc      text_sub       TEXT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE tbl_banners CHANGE COLUMN text_top       slide_top       TEXT NULL');
        DB::statement('ALTER TABLE tbl_banners CHANGE COLUMN text_title     slide_title     TEXT NULL');
        DB::statement('ALTER TABLE tbl_banners CHANGE COLUMN text_highlight slide_highlight TEXT NULL');
        DB::statement('ALTER TABLE tbl_banners CHANGE COLUMN text_sub       slide_desc      TEXT NULL');
    }
};
