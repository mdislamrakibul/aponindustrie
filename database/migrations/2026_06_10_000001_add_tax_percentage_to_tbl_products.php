<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxPercentageToTblProducts extends Migration
{
    public function up()
    {
        Schema::table('tbl_products', function (Blueprint $table) {
            $table->decimal('tax_percentage', 8, 2)
                  ->default(0)
                  ->after('discount_value')
                  ->comment('VAT/Tax percentage e.g. 15 = 15%');
        });
    }

    public function down()
    {
        Schema::table('tbl_products', function (Blueprint $table) {
            $table->dropColumn('tax_percentage');
        });
    }
}