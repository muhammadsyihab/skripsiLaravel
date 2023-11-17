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
            $table->float('start_hm', 15, 0)->default(0)->after('tanggal');
            $table->float('end_hm', 15, 0)->default(0)->after('start_hm');
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
