<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_service_id')->references('id')->on('master_service')->onDelete('cascade')->nullable();
            $table->string('no_serial');
            $table->string('no_lambung');
            $table->string('nama_unit');
            $table->string('lokasi_unit');
            $table->string('status_unit')->default('0');
            $table->string('status_kepemilikan')->default('0');
            $table->float('total_hm', 15, 2)->default(0);
            $table->float('sisa_hm', 15, 2)->default(0);
            $table->float('total_wh', 15, 2)->default(0);
            $table->float('total_stb', 15, 2)->default(0);
            $table->float('pu', 15, 2)->default(0);
            $table->float('ua', 15, 2)->default(0);
            $table->float('ma', 15, 2)->default(0);
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
        Schema::dropIfExists('master_unit');
    }
}
