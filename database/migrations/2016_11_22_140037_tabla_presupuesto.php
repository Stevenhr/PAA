<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaPresupuesto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('presupuesto', function (Blueprint $table){
            $table->increments('Id');
            $table->string('Nombre_Actividad');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->bigInteger('presupuesto')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('presupuesto');
    }
}
