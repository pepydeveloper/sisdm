<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaDemanda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demanda', function (Blueprint $table) {
            $table->increments('demid');
            $table->integer('demnumero');
            $table->string('demdescricao', 5000);
            $table->string('demtipo');
            $table->dateTime('demdatafinalizacao');
            $table->integer('sisid')->unsigned();
            $table->foreign('sisid')->references('sisid')->on('sistema');
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
        Schema::dropIfExists('demanda');
    }
}
