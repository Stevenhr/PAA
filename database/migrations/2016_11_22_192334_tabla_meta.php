<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('meta', function (Blueprint $table){
            $table->increments('Id');

            $table->integer('Id_proyecto')->unsigned();
            $table->foreign('Id_proyecto')->references('Id')->on('proyecto')->onDelete('cascade');

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
        Schema::drop('meta');
    }
}
