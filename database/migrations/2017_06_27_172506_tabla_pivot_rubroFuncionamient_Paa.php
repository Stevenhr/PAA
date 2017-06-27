<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaPivotRubroFuncionamientPaa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('PaaRubroFuncionamiento', function (Blueprint $table) {
            $table->integer('rubro_id')->unsigned();
            $table->foreign('rubro_id')->references('id')->on('rubro_funcionamiento');
            $table->integer('paa_id')->nullable()->unsigned();
            $table->foreign('paa_id')->references('Id')->on('paa');
            $table->timestamps();
            $table->softDeletes();
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
            $table->dropForeign(['rubro_id']);
            $table->dropForeign(['paa_id']);
        });
        Schema::drop('PaaRubroFuncionamiento');
    }
}
