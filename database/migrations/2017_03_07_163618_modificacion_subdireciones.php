<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificacionSubdireciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
        Schema::table('subdireccion', function ($table) {
            $table->string('SubDireccion');
            $table->string('Descripcion');
            $table->string('Iniciales');
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
        Schema::table('subdireccion', function (Blueprint $table) {
            $table->dropColumn('SubDireccion');
            $table->dropColumn('Descripcion');
            $table->dropColumn('Iniciales');
        });
    }
}
