<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaDemandaFuncionalidade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demanda_funcionalidade', function (Blueprint $table) {
            $table->increments('defid');
            $table->char('deftipomudanca')->nullable();
            $table->text('defdescricao')->nullable();
            $table->text('defalteracaoarquivos')->nullable();
            $table->text('defcargadados')->nullable();
            $table->string('evidencia1')->nullable();
            $table->string('evidencia2')->nullable();
            $table->string('evidencia3')->nullable();
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
        Schema::dropIfExists('demanda_funcionalidade');
    }
}
