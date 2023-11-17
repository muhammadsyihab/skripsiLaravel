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
        Schema::create('grup_bulan_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_unit_id')->references('id')->on('master_unit')->onDelete('cascade')->nullable();
            $table->date('awal_bulan');
            $table->date('akhir_bulan');
            $table->float('total_wh', 15, 2)->default(0);
            $table->float('total_stb', 15, 2)->default(0);
            $table->float('total_bd', 15, 2)->default(0);
            $table->float('pu', 15, 2)->default(0);
            $table->float('ua', 15, 2)->default(0);
            $table->float('ma', 15, 2)->default(0);
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
        Schema::dropIfExists('grup_bulan_unit');
    }
};
