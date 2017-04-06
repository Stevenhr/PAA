<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EliminaRelacionFuenteComponente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('componente', function ($table) {
            $table->dropForeign('componente_Id_fuente_foreign');
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
        Schema::table('componente', function ($table) {
                $table->integer('Id_fuente')->unsigned();
                $table->foreign('Id_fuente')->references('Id')->on('fuente');
            });
    }
}
