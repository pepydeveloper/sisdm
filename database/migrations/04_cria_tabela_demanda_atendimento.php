<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaDemandaAtendimento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demanda_atendimento', function (Blueprint $table) {
            $table->increments('datid');
            $table->integer('datquantidade');
            $table->string('datdescricao', 5000);
            $table->integer('demid')->unsigned();
            $table->integer('ateid')->unsigned();
            $table->foreign('demid')->references('demid')->on('demanda');
            $table->foreign('ateid')->references('ateid')->on('atendimento');
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
        Schema::dropIfExists('demanda_atendimento');
    }
}
