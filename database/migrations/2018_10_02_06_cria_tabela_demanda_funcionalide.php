<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaDemandaFuncionalide extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demanda_funcionalide', function (Blueprint $table) {
            $table->increments('defid');
            $table->integer('demid')->unsigned();
            $table->integer('funid')->unsigned();
            $table->foreign('demid')->references('demid')->on('demanda');
            $table->foreign('funid')->references('funid')->on('funcionalidade');
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
        Schema::dropIfExists('demanda_funcionalide');
    }
}
