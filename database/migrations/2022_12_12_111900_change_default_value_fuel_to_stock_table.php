<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fuel_to_stock', function (Blueprint $table) {
            $table->float('stock_open', 15, 2)->default(0)->change();
            $table->float('fuel_out_day', 15, 2)->default(0)->change();
            $table->float('fuel_out_night', 15, 2)->default(0)->change();
            $table->float('fuel_out_total', 15, 2)->default(0)->change();
            $table->float('stock', 15, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fuel_to_stock', function (Blueprint $table) {
            //
        });
    }
};
