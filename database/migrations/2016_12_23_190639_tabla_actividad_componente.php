<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaActividadComponente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('actividadComponente', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('estado');
            $table->integer('componente_id')->unsigned();
            $table->foreign('componente_id')->references('Id')->on('componente');
            $table->integer('actividad_id')->nullable()->unsigned();
            $table->foreign('actividad_id')->references('Id')->on('actividad');
            $table->bigInteger('valor')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('actividadComponente');
    }
}
