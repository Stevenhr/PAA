<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaActividadEstudioRubro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
        Schema::create('actividadEstudioRubro', function (Blueprint $table){
            $table->increments('id');
            $table->boolean('estado');

            $table->integer('paa_id')->unsigned();
            $table->foreign('paa_id')->references('Id')->on('paa');

            $table->integer('actividad_f_id')->nullable()->unsigned();
            $table->foreign('actividad_f_id')->references('id')->on('actividad_funcionamiento');
            
            $table->integer('fuentehacienda');
            $table->integer('valor');
            $table->integer('porcentaje');
            $table->bigInteger('total')->unsigned()->index();
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
         $table->dropForeign('paa_paa_id_foreign');
         $table->dropForeign('actividad_funcionamiento_actividad_f_id_foreign');
         Schema::drop('actividadEstudioRubro');
    }
}
