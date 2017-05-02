<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaEstudioConvencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('estudioComveniencia', function (Blueprint $table) {
            $table->integer('id_paa')->unsigned();
            $table->primary('id_paa');
            $table->text('conveniencia');
            $table->text('oportunidad');
            $table->text('justificacion');
            $table->timestamps();
            $table->foreign('id_paa')->references('Id')->on('paa');
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
         Schema::drop('estudioComveniencia');
    }
}
