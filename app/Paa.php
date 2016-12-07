<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paa extends Model
{
    //
    protected $table = 'paa';
	protected $primaryKey = 'Id';
	protected $fillable = [
	'Id_paa',
	'Registro',
	'CodigosU',
	'ModalidadSeleccion',
	'TipoContrato',
	'ObjetoContractual',
	'FuenteRecurso',
	'ValorEstimado',
	'ValorEstimadoVigencia',
	'VigenciaFutura',
	'EstadoVigenciaFutura',
	'FechaEstudioConveniencia',
	'FechaInicioProceso',
	'FechaSuscripcionContrato',
	'DuracionContrato',
	'MetaPlan',
	'RecursoHumano',
	'NumeroContratista',
	'DatosResponsable',
	'ProyectoRubro',
	'Estado'];
	protected $connection = ''; 
	public $timestamps = false;
}
