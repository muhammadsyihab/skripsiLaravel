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
        Schema::create('mekanik_daily', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->foreignId('master_unit_id')->references('id')->on('master_unit')->onDelete('cascade')->nullable();
            $table->date('tanggal');
            $table->string('shift');
            $table->string('area');
            $table->string('kerusakan');
            $table->integer('estimasi_perbaikan_hm'); // planner bisa edit
            $table->integer('perbaikan_hm');
            $table->string('perbaikan');
            $table->string('status');
            $table->string('keterangan');
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
        Schema::dropIfExists('mekanik_daily');
    }
};
