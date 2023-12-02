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
        Schema::create('daily_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->foreignId('master_unit_id')->references('id')->on('master_unit')->onDelete('cascade')->nullable();
            $table->foreignId('fuel_to_unit_id')->references('id')->on('fuel_to_unit')->onDelete('cascade')->nullable();
            $table->date('tanggal');
            $table->float('end_unit', 15, 2)->default(0); 
            $table->float('qty_fuel_awal', 15, 2)->default(0); 
            $table->float('penggunaan_fuel', 15, 2)->default(0); 
            $table->float('qty_fuel_end', 15, 2)->default(0); 
            $table->float('wh', 15, 2)->default(0);
            $table->float('stb', 15, 2)->default(0);
            $table->float('bd', 15, 2)->default(0);
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
        Schema::dropIfExists('daily_unit');
    }
};
