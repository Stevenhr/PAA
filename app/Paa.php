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
	'Id_ModalidadSeleccion',
	'Id_TipoContrato',
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
	'Id_ProyectoRubro',
	'Id_Componente',
	'IdPersona',
	'Estado',
	'IdPersonaObservo',
	'EsatdoObservo',
	'Observacion'];
	protected $connection = ''; 

	 public function modalidad()
    {
        return $this->belongsTo('App\ModalidadSeleccion','Id_ModalidadSeleccion');
    }
     public function tipocontrato()
    {
        return $this->belongsTo('App\TipoContrato','Id_TipoContrato');
    }
     public function rubro()
    {
        return $this->belongsTo('App\Rubro','Id_ProyectoRubro');
    }
}