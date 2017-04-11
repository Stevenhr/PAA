<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EliminarPaaActividadesComponetes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('PaaActividadCompoenente', function ($table) {
            $table->dropForeign('PaaActividadCompoenente_paa_id_foreign');
            $table->dropForeign('PaaActividadCompoenente_actividadComponente_id_foreign');
        });
        Schema::drop('PaaActividadCompoenente');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::create('PaaActividadCompoenente', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('estado');
            $table->integer('actividadComponente_id')->unsigned();
            $table->foreign('actividadComponente_id')->references('id')->on('actividadComponente');
            $table->integer('paa_id')->unsigned();
            $table->foreign('paa_id')->references('Id')->on('paa');
            $table->bigInteger('valor')->unsigned()->index();
            $table->timestamps();
        });
    }
}
