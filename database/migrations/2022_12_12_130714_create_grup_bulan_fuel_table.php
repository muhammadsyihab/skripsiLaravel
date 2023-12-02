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
        Schema::create('grup_bulan_fuel', function (Blueprint $table) {
            $table->id();
            $table->date('awal_bulan');
            $table->date('akhir_bulan');
            $table->float('qty_by_do_total', 15, 2)->default(0);
            $table->float('do_datang_total', 15, 2)->default(0);
            $table->float('do_minus_total', 15, 2)->default(0);
            $table->float('fuel_out_total_month', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grup_bulan_fuel');
    }
};
