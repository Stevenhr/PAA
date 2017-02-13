<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelacionPaaActividaComponente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('actividadComponente', function ($table) {
            
            $table->integer('id_paa')->unsigned();
            $table->foreign('id_paa')->references('Id')->on('paa');

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
         Schema::table('actividadComponente', function ($table) {
            $table->dropForeign('actividadComponente_id_paa_foreign');
             $table->dropColumn('id_paa');
        });
    }
}
