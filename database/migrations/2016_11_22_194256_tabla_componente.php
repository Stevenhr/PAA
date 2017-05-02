<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaComponente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('componente', function (Blueprint $table){
            $table->increments('Id');

            $table->string('Nombre');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->bigInteger('valor')->unsigned()->index();
            $table->string('descripcion');
            $table->string('codigo');

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
        Schema::drop('componente');
    }
}
