<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CampoTablaProyecto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('presupuesto', function ($table) {
           $table->integer('Id_proyectoDesarrollo')->unsigned()->nullable();
           $table->string('vigencia');
           $table->foreign('Id_proyectoDesarrollo')->references('id')->on('proyecto_desarrollo');
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
        Schema::table('presupuesto', function ($table) {
             $table->dropForeign('presupuesto_Id_proyectoDesarrollo_foreign');
             $table->dropColumn('vigencia');
             $table->dropColumn('Id_proyectoDesarrollo');
        });
    }
}
