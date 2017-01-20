<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionPaaArea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
            Schema::table('paa', function (Blueprint $table) {
                $table->integer('Id_Area')->unsigned()->nullable();
                $table->foreign('Id_Area')->references('Id')->on('area')->onDelete('cascade');
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
        Schema::table('paa', function (Blueprint $table){
                $table->dropForeign('paa_Id_Area_foreign');
                $table->dropColumn('Id_Area');
        });
    }
}
