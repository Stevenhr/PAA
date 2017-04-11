<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaProyectoDesarrollo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('proyecto_desarrollo', function (Blueprint $table){
            $table->increments('id');
            $table->string('nombre');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->bigInteger('valor')->unsigned()->index();
            $table->string('descripcion');
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
        Schema::drop('proyecto_desarrollo');
    }
}

