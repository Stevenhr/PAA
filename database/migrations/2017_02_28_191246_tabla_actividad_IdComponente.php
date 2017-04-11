<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaActividadIdComponente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('actividadEstudioComponente', function (Blueprint $table){
            $table->increments('id');
            $table->boolean('estado');

            $table->integer('componeActiv_id')->unsigned();
            $table->foreign('componeActiv_id')->references('id')->on('actividadComponente');

            $table->integer('actividad_id')->nullable()->unsigned();
            $table->foreign('actividad_id')->references('Id')->on('actividad');
            
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
         $table->dropForeign('actividadEstudioComponente_componeActiv_id_foreign');
         $table->dropForeign('actividadEstudioComponente_actividad_id_foreign');
         Schema::drop('actividadEstudioComponente');
    }
}
