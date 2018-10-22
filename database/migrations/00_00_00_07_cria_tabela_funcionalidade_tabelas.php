<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaFuncionalidadeTabelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionalidade_tabelas', function (Blueprint $table) {
            $table->increments('tafid');
            $table->string('tafutilizada');
            $table->string('taftipoacesso');
            $table->integer('funid')->unsigned();
            $table->integer('tabid')->unsigned();
            $table->foreign('funid')->references('funid')->on('funcionalidade');
            $table->foreign('tabid')->references('tabid')->on('tabelas');
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
        Schema::dropIfExists('funcionalidade_tabelas');
    }
}
