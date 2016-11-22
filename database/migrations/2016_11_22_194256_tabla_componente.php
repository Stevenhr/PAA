<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaComponente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('componente', function (Blueprint $table){
            $table->increments('Id');

            $table->integer('Id_actividad')->unsigned();
            $table->foreign('Id_actividad')->references('Id')->on('actividad')->onDelete('cascade');

            $table->string('Nombre');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->integer('valor');
            $table->string('descripcion');

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
        Schema::drop('componente');
    }
}
