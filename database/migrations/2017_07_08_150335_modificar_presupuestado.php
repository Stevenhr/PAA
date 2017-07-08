<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarPresupuestado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('presupuestado', function (Blueprint $table) {
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
        Schema::table('presupuestado', function (Blueprint $table) {
            $table->Integer('id_fk_meta');
            $table->dropForeign('presupuestado_id_fk_meta_foreign');
        });
    }
}
