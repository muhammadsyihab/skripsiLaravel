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
        Schema::create('fuel_to_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fuel_suply_id')->references('id')->on('fuel_suply')->onDelete('cascade')->nullable();
            $table->date('tanggal');
            $table->integer('stock_open');
            $table->integer('fuel_out_day');
            $table->integer('fuel_out_night');
            $table->integer('fuel_out_total');
            $table->integer('stock');
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
        Schema::dropIfExists('fuel_to_stock');
    }
};
