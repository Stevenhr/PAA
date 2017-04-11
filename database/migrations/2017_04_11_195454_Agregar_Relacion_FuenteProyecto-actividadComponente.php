<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarRelacionFuenteProyectoActividadComponente extends Migration
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
            $table->foreign('fuente_id')->references('id')->on('FuenteProyecto');
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
        });
    }
}
