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
        Schema::table('fuel_suply', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->foreignId('fuel_to_stock_id')->references('id')->on('fuel_to_stock')->onDelete('cascade')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fuel_suply', function (Blueprint $table) {
            //
        });
    }
};
