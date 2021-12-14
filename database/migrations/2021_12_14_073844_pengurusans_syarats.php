<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PengurusansSyarats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengurusan_syarat', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pengurusan_id')->unsigned();
            $table->bigInteger('syarat_id')->unsigned();
            $table->text('foto');
            $table->foreign('pengurusan_id')->references('id')->on('pengurusans');
            $table->foreign('syarat_id')->references('id')->on('syarats');
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
        Schema::dropIfExists('pengurusan_syarat');
    }
}
