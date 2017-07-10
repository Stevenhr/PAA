<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarActividadcompoente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('actividadComponente', function (Blueprint $table) {
            $table->integer('id_fk_meta')->nullable()->unsigned();
            $table->foreign('id_fk_meta')->references('Id')->on('meta');
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
        Schema::table('actividadComponente', function (Blueprint $table) {
           
            $table->dropForeign('actividadComponente_id_fk_meta_foreign');
        });
    }
}
