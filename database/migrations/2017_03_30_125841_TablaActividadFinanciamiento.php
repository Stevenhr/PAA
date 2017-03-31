<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaActividadFinanciamiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('actividad_funcionamiento', function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_rubro_funcionamiento')->unsigned();
            $table->foreign('id_rubro_funcionamiento')->references('id')->on('rubro_funcionamiento');
            $table->string('nombre');
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
        //
        Schema::drop('actividad_funcionamiento');
    }
}
