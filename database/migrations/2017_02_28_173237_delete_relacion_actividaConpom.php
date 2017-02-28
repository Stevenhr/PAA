<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteRelacionActividaConpom extends Migration
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
            $table->dropForeign('actividadComponente_actividad_id_foreign');
            
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
            $table->foreign('actividad_id')->references('Id')->on('actividad');
        });
    }
}
