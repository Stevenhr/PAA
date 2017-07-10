<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarActividadestudiorubros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('actividadEstudioRubro', function (Blueprint $table){
            $table->dropForeign('actividadEstudioRubro_actividad_f_id_foreign');
            $table->foreign('actividad_f_id')->references('id')->on('rubro_funcionamiento');
        });

       
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('actividadEstudioRubro', function (Blueprint $table){
            $table->dropForeign('rubro_funcionamiento_actividad_f_id_foreign');
            
            $table->foreign('actividad_f_id')->references('id')->on('actividad_funcionamiento');

        });
    }
}
