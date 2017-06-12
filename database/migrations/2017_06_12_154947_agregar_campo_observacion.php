<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCampoObservacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('observacion', function ($table) {
            $table->boolean('check')->default(0);
            $table->boolean('check_cons')->default(0);
            $table->boolean('check_subd')->default(0);
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
         Schema::table('observacion', function ($table) {
            $table->dropColumn('check');
            $table->dropColumn('check_cons');
            $table->dropColumn('check_subd');
        });
    }
}
