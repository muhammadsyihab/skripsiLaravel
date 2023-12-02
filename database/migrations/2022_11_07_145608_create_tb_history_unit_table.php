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
        Schema::create('tb_history_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_unit_id')->references('id')->on('master_unit')->onDelete('cascade')->nullable();
            $table->string('ket_sp');
            $table->string('status_sp');
            $table->string('pj_alat');
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
        Schema::dropIfExists('tb_history_unit');
    }
};
