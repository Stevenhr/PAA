<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    'Id_Proyecto',
	'Id_Rubro',
	'IdPersona',
	'Estado',
	'IdPersonaObservo',
	'EsatdoObservo',
    'Observacion',
	'Proyecto1Rubro2',
    'Id_Area'];

    public $timestamps = true;
	protected $connection = ''; 
	 
	public function modalidad()
    {
        return $this->belongsTo('App\ModalidadSeleccion','Id_ModalidadSeleccion');
    }
    
    public function estudioComveniencia()
    {
        return $this->hasOne('App\EstudioConveniencia', 'id_paa', 'Id');
    }
     
    public function tipocontrato()
    {
        return $this->belongsTo('App\TipoContrato','Id_TipoContrato');
    }
    
    public function rubro()
    {
        return $this->belongsTo('App\Rubro','Id_Rubro');
    }

    public function rubro_funcionamiento()
    {
        //return $this->belongsTo('App\RubroFuncionamiento','Id_Rubro');
      return $this->belongsToMany('\App\RubroFuncionamiento','paarubrofuncionamiento','paa_id','rubro_id')->withPivot('created_at','valor');
    }
    
    public function proyecto()
    {
        return $this->belongsTo('App\Proyecto','Id_Proyecto');
    }
    
    public function meta()
    {
        return $this->belongsTo('App\Meta','MetaPlan');
    }
    
    public function componentes()
    {
        return $this->belongsToMany('\App\Componente','actividadComponente','id_paa','componente_id')
            ->withPivot('id','actividad_id','estado','valor','created_at','id_paa','fuente_id','proyecto_id');
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

    public function observaciones()
    {
        return $this->hasMany('App\Observacion','id_registro');
    }

    public function actividadesFuncionamiento()
    {
        return $this->belongsToMany('\App\RubroFuncionamiento','actividadEstudioRubro','paa_id','actividad_f_id')->withPivot('id','estado','fuentehacienda','valor','created_at','porcentaje','total');
    }

    public function persona()
    {
        return $this->belongsTo('App\Persona','IdPersona');
    }

    use SoftDeletes;
}
