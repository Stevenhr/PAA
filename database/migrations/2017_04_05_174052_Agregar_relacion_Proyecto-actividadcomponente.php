<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarRelacionProyectoActividadcomponente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('actividadComponente', function ($table) {
            
            $table->integer('proyecto_id')->unsigned();
            $table->foreign('proyecto_id')->references('Id')->on('proyecto')->onDelete('cascade');

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
         Schema::table('actividadComponente', function ($table) {
            $table->dropForeign('actividadComponente_proyecto_id_foreign');
             $table->dropColumn('proyecto_id');
        });
    }
}
