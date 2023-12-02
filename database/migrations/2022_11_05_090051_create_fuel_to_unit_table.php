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
        Schema::create('fuel_to_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->foreignId('master_unit_id')->references('id')->on('master_unit')->onDelete('cascade')->nullable();
            $table->foreignId('fuel_to_stock_id')->references('id')->on('fuel_to_stock')->onDelete('cascade')->nullable();
            $table->date('tanggal');
            $table->integer('qty_to_unit');
            $table->string('shift');
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
        Schema::dropIfExists('fuel_to_unit');
    }
};
