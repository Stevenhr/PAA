<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PersonaPaa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('personaPaa', function (Blueprint $table){
            $table->integer('id')->unsigned();
            $table->primary('id');
            $table->integer('id_area')->unsigned()->nullable();
            $table->foreign('id_area')->references('Id')->on('area')->onDelete('cascade');
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
        Schema::drop('personaPaa');
    }
}
