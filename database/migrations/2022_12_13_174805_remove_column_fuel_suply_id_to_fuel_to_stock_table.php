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
        Schema::table('fuel_to_stock', function (Blueprint $table) {
            $table->dropForeign(['fuel_suply_id']);
            $table->dropColumn('fuel_suply_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fuel_to_stock', function (Blueprint $table) {
            //
        });
    }
};
