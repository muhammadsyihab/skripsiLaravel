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
        Schema::table('tb_jadwal', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->foreignId('shift_id')->references('id')->on('shift')->nullable();
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
        Schema::table('tb_jadwal', function (Blueprint $table) {
            //
        });
    }
};
