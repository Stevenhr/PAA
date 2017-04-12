<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaPresupuestado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('presupuestado', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('componente_id')->unsigned();
            $table->integer('fuente_id')->nullable()->unsigned();
            $table->integer('proyecto_id')->nullable()->unsigned();
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
        Schema::drop('presupuestado');
    }
}
