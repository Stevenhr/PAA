<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaFuente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('fuente', function (Blueprint $table){
            $table->increments('Id');

            $table->string('nombre');
            $table->integer('valor');
            $table->string('descripcion');
            $table->string('codigo');
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
        Schema::drop('fuente');
    }
}
