<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaPaa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('paa', function (Blueprint $table){
            $table->increments('Id');
            $table->integer('Id_paa');
            $table->integer('Registro');
            $table->string('CodigosU');

            $table->integer('Id_ModalidadSeleccion')->unsigned();
            $table->foreign('Id_ModalidadSeleccion')->references('Id')->on('modalidadseleccion')->onDelete('cascade');

            $table->integer('Id_TipoContrato')->unsigned();
            $table->foreign('Id_TipoContrato')->references('Id')->on('tipocontrato');

            $table->text('ObjetoContractual');
            $table->string('FuenteRecurso');
            $table->bigInteger('ValorEstimado')->unsigned()->index();
            $table->bigInteger('ValorEstimadoVigencia')->unsigned()->index();
            $table->string('VigenciaFutura');
            $table->string('EstadoVigenciaFutura');
            $table->date('FechaEstudioConveniencia');
            $table->date('FechaInicioProceso');
            $table->date('FechaSuscripcionContrato');
            $table->integer('DuracionContrato');
            $table->string('MetaPlan');
            $table->string('RecursoHumano');
            $table->integer('NumeroContratista');
            $table->text('DatosResponsable');

            $table->integer('Id_Proyecto')->nullable()->unsigned();
            //$table->foreign('Id_Proyecto')->references('Id')->on('proyecto');

            
        
            $table->integer('IdPersona');
            $table->string('Estado');
            $table->integer('IdPersonaObservo');
            $table->string('EsatdoObservo');
            $table->text('Observacion');
           
            $table->timestamps();

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
        Schema::drop('paa');
    }
}
