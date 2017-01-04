<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaCambioPaa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cambioPaa', function (Blueprint $table){
            $table->increments('id');

            $table->integer('id_paa')->unsigned();
            $table->foreign('id_paa')->references('Id')->on('paa')->onDelete('cascade');

            $table->string('cambio');
            $table->string('campo');
            $table->integer('persona');

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
         Schema::drop('cambioPaa');
    }
}
