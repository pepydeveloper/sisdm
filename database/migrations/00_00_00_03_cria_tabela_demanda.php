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
            $table->integer('demnumero')->nullable();
            $table->text('demdescricao')->nullable();
            $table->string('demtipo')->nullable();
            $table->date('demdatainicio')->nullable();
            $table->date('demdatafinalizacao')->nullable();
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
