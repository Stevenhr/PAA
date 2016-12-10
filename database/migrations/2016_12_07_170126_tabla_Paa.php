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
            $table->foreign('Id_TipoContrato')->references('Id')->on('tipocontrato')->onDelete('cascade');

            $table->text('ObjetoContractual');
            $table->string('FuenteRecurso');
            $table->integer('ValorEstimado');
            $table->integer('ValorEstimadoVigencia');
            $table->string('VigenciaFutura');
            $table->string('EstadoVigenciaFutura');
            $table->dateTime('FechaEstudioConveniencia');
            $table->dateTime('FechaInicioProceso');
            $table->dateTime('FechaSuscripcionContrato');
            $table->integer('DuracionContrato');
            $table->string('MetaPlan');
            $table->string('RecursoHumano');
            $table->integer('NumeroContratista');
            $table->text('DatosResponsable');

            $table->integer('Id_ProyectoRubro')->unsigned();
            $table->foreign('Id_ProyectoRubro')->references('Id')->on('rubro')->onDelete('cascade');
            
            $table->integer('Id_Componente')->unsigned();
            $table->foreign('Id_Componente')->references('Id')->on('componente')->onDelete('cascade');

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
