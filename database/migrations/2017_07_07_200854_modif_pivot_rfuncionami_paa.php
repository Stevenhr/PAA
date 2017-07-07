<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifPivotRfuncionamiPaa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('PaaRubroFuncionamiento', function (Blueprint $table) {
            $table->bigInteger('valor');
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
        Schema::table('PaaRubroFuncionamiento', function (Blueprint $table) {
            $table->dropColumn('valor');
        });
    }
}
