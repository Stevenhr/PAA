<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EliminarRelacionesRubroFuncionamientoPaa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('paa', function ($table) {
            $table->dropForeign('paa_Id_Rubro_foreign');

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
        Schema::table('paa', function ($table) {

            $table->foreign('Id_Rubro')->references('Id')->on('rubro_funcionamiento');
        });
    }
}
