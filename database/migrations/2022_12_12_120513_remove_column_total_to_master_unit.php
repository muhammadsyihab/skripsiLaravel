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
        Schema::table('master_unit', function (Blueprint $table) {
            $table->dropColumn(['total_wh', 'total_stb', 'total_bd', 'pu', 'ua', 'ma']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_unit', function (Blueprint $table) {
            //
        });
    }
};
