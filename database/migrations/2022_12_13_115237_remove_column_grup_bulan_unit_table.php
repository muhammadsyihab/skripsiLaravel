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
        Schema::table('grup_bulan_unit', function (Blueprint $table) {
            $table->dropColumn(['awal_bulan', 'akhir_bulan']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grup_bulan_unit', function (Blueprint $table) {
            //
        });
    }
};
