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
        Schema::create('fuel_suply', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('transporter');
            $table->string('no_plat_kendaraan');
            $table->string('no_surat_jalan');
            $table->string('driver');
            $table->string('penerima');
            $table->string('nama_storage');
            $table->float('tc_storage_sebelum', 15, 2);
            $table->float('tc_storage_sesudah', 15, 2);
            $table->integer('tc_kenaikan_storage');
            $table->integer('suhu_diterima');
            $table->float('qty_by_do', 15, 2);
            $table->float('do_datang', 15, 2);
            $table->float('do_minus', 15, 2);
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
        Schema::dropIfExists('fuel_suply');
    }
};
