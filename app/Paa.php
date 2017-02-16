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
	'IdPersona',
	'Estado',
	'IdPersonaObservo',
	'EsatdoObservo',
	'Observacion',
    'Id_Area'];
	
	protected $connection = ''; 
	 
	public function modalidad()
    {
        return $this->belongsTo('App\ModalidadSeleccion','Id_ModalidadSeleccion');
    }

    public function estudioComveniencia(){
        return $this->hasOne('App\EstudioConveniencia', 'id_paa', 'Id');
    }
     
    public function tipocontrato()
    {
        return $this->belongsTo('App\TipoContrato','Id_TipoContrato');
    }
    
    public function rubro()
    {
        return $this->belongsTo('App\Rubro','Id_ProyectoRubro');
    }

    public function actividadComponentes()
    {
        return $this->belongsToMany('\App\Componente','actividadComponente','id_paa','componente_id')
            ->withPivot('actividad_id','estado','valor','created_at');
    }

    public function cambiosPaa()
    {
        return $this->hasMany('App\CambioPaa','id_paa');
    }

    public function save(array $options = [])
    {
    	$cambios = $this->isDirty() ? $this->getDirty() : false;

    	if($cambios)
    	{
    		foreach ($cambios as $key => $value) {
    			switch($key)
    			{
    				case 'Estado':
    					switch($value)
    					{
    						case '1':
    						break;
    						case '2':
    						break;
    						case '3':
    						break;
    						case '4':
    						break;
    						case '5':
    					}
    				break;
    			}
    		}
    	}

    	parent::save($options);
    }

    public function area()
    {
        return $this->belongsTo('App\Area','Id_Area');
    }

    public function meta()
    {
        return $this->belongsTo('App\Meta','MetaPlan');
    }

    public function observaciones()
    {
        return $this->hasMany('App\Observacion','id_registro');
    }
}
