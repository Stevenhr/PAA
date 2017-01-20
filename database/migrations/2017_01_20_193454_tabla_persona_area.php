<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaPersonaArea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
        Schema::create('areaPersona', function (Blueprint $table){
            
            $table->integer('id_area')->unsigned();
            $table->foreign('id_area')->references('id')->on('area');

            $table->integer('id_persona')->unsigned();
            $table->foreign('id_persona')->references('id')->on('personaPaa');

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
         Schema::drop('areaPersona');
    }
}
