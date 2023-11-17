<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLgBrgMskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lg_brg_msk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_sparepart_id')->references('id')->on('master_sparepart')->onDelete('cascade')->nullable();
            $table->date('tanggal_masuk');
            $table->integer('qty_masuk');
            $table->integer('status')->default(0);
            $table->string('purchasing_order');
            $table->integer('item_price');
            $table->integer('amount');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('lg_brg_msk');
    }
}
