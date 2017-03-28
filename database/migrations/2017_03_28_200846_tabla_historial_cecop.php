<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaHistorialCecop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
        Schema::create('historial_cecop', function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_usuario');
            $table->date('fecha_generacion');
            $table->string('codigo_cecop');
            $table->text('ubicacion_archivo');
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
        Schema::drop('historial_cecop');
    }
}
   