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
        Schema::table('operator_daily', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->foreignId('tb_jadwal_id')->references('id')->on('tb_jadwal')->nullable();
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
        Schema::table('operator_daily', function (Blueprint $table) {
            //
        });
    }
};
