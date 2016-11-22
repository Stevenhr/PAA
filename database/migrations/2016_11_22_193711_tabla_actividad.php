<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaActividad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('actividad', function (Blueprint $table){
            $table->increments('Id');

            $table->integer('Id_meta')->unsigned();
            $table->foreign('Id_meta')->references('Id')->on('meta')->onDelete('cascade');

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
        Schema::drop('actividad');
    }
}
