<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaPresupuestado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('presupuestado', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('componente_id')->unsigned();
            $table->foreign('componente_id')->references('id')->on('componente');
            $table->integer('fuente_proyecto_id')->unsigned();
            $table->foreign('fuente_proyecto_id')->references('id')->on('FuenteProyecto');
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
        Schema::drop('presupuestado');
    }
}
