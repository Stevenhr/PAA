<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaFuenteProyecto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('FuenteProyecto', function (Blueprint $table) {
            $table->integer('fuente_id')->unsigned();
            $table->foreign('fuente_id')->references('Id')->on('fuente');
            $table->integer('proyecto_id')->nullable()->unsigned();
            $table->foreign('proyecto_id')->references('Id')->on('proyecto');
            $table->bigInteger('valor')->unsigned()->index();
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
        Schema::table('FuenteProyecto', function (Blueprint $table) {
            $table->dropForeign(['fuente_id']);
            $table->dropForeign(['proyecto_id']);
        });
        Schema::drop('FuenteProyecto');
    }
}
