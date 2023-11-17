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
            $table->dropColumn(['tanggal', 'start_hm', 'end_hm', 'day_hm', 'night_hm', 'total_hm']);
            $table->after('master_unit_id', function ($table) {
                $table->float('hm', 15, 2)->default(0);
                $table->string('photo_hm');
                $table->string('status');
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
