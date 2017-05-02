<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaProyecto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('proyecto', function (Blueprint $table){
            $table->increments('Id');

            $table->integer('Id_presupuesto')->unsigned();
            $table->foreign('Id_presupuesto')->references('Id')->on('presupuesto')->onDelete('cascade');

            $table->string('codigo');
            $table->string('Nombre');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->bigInteger('valor')->unsigned()->index();
            $table->string('descripcion');

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
        Schema::drop('proyecto');
    }
}
