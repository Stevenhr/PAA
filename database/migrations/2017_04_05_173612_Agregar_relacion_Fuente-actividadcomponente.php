<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarRelacionFuenteActividadcomponente extends Migration
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
            
            $table->integer('fuente_id')->unsigned();
            $table->foreign('fuente_id')->references('Id')->on('fuente');

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
            $table->dropForeign('actividadComponente_fuente_id_foreign');
             $table->dropColumn('fuente_id');
        });
    }
}
