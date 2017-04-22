<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteRelacionRubro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* //
        Schema::table('paa', function ($table) {
            $table->dropForeign('paa_Id_ProyectoRubro_foreign');
        });*/

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        /*Schema::table('paa', function ($table) {
            $table->foreign('Id_ProyectoRubro')->references('Id')->on('rubro')->onDelete('cascade');
        });*/
    }
}
