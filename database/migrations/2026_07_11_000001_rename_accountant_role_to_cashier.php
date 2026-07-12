<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("UPDATE tbl_info_user SET role = 'cashier' WHERE role = 'accountant'");
        DB::statement("UPDATE tbl_info_login SET role = 'cashier' WHERE role = 'accountant'");

        DB::statement("ALTER TABLE tbl_info_user MODIFY COLUMN role ENUM('customer','admin','vendor','cashier') NOT NULL DEFAULT 'customer'");
        DB::statement("ALTER TABLE tbl_info_login MODIFY COLUMN role ENUM('customer','admin','vendor','cashier') NOT NULL DEFAULT 'customer'");
    }

    public function down(): void
    {
        DB::statement("UPDATE tbl_info_user SET role = 'accountant' WHERE role = 'cashier'");
        DB::statement("UPDATE tbl_info_login SET role = 'accountant' WHERE role = 'cashier'");

        DB::statement("ALTER TABLE tbl_info_user MODIFY COLUMN role ENUM('customer','admin','vendor','accountant') NOT NULL DEFAULT 'customer'");
        DB::statement("ALTER TABLE tbl_info_login MODIFY COLUMN role ENUM('customer','admin','vendor','accountant') NOT NULL DEFAULT 'customer'");
    }
};
