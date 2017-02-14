<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CamposPaa extends Migration
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
           $table->string('compartida');
           $table->string('vinculada');
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
           $table->dropColumn('compartida');
           $table->dropColumn('vinculada');
        });
    }
}
