<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyaratSurat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_syarat', function (Blueprint $table) {
            $table->bigInteger('surat_id')->unsigned();
            $table->bigInteger('syarat_id')->unsigned();
            $table->foreign('surat_id')->references('id')->on('surats');
            $table->foreign('syarat_id')->references('id')->on('syarats');
            $table->primary(['surat_id', 'syarat_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_syarat');
    }
}
