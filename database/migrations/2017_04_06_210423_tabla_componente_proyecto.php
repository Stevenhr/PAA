<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaComponenteProyecto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ComponenteProyecto', function (Blueprint $table) {
            $table->integer('componente_id')->unsigned();
            $table->foreign('componente_id')->references('Id')->on('componente');
            $table->integer('proyecto_id')->nullable()->unsigned();
            $table->foreign('proyecto_id')->references('Id')->on('proyecto');
            $table->bigInteger('valor')->unsigned()->index();
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
        Schema::table('ComponenteProyecto', function (Blueprint $table) {
            $table->dropForeign(['componente_id']);
            $table->dropForeign(['proyecto_id']);
        });
        Schema::drop('ComponenteProyecto');
    }
}
