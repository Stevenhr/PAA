<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelaccionSubdirecioArea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
            Schema::table('area', function (Blueprint $table) {
                $table->foreign('id_subdireccion')->references('id')->on('subdireccion')->onDelete('cascade');
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
        Schema::table('area', function (Blueprint $table){
                $table->dropForeign('area_id_subdireccion_foreign');
        });
    }
}
