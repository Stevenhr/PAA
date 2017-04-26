<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCampoPaa extends Migration
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
            $table->string('Proyecto1Rubro2');
            $table->integer('Id_Rubro')->nullable()->unsigned();
           // $table->foreign('Id_Rubro')->references('id')->on('rubro_funcionamiento');
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
            $table->dropColumn('Proyecto1Rubro2');
           // $table->dropForeign('paa_Id_Rubro_foreign');
            $table->dropColumn('Id_Rubro');
        });
    }
}
