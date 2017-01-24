<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaObservaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
        Schema::create('observacion', function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_registro');
            $table->integer('id_persona');
            $table->text('observacion');
            $table->string('estado');
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
        Schema::drop('observacion');
    }
}
