<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActividadComponente extends Model
{
    //
    protected $table = 'actividadComponente';
	protected $primaryKey = 'id';
	protected $fillable = ['componente_id','actividad_id','fuente_id','proyecto_id','valor','estado','id_fk_meta','id_paa','deleted_at'];
	protected $connection = ''; 
	public $timestamps = true;

    public function paa()
    {
        return $this->hasMany('App\Paa','id_paa');
    }

	public function paas()
    {
        return $this->belongsToMany('\App\Paa','PaaActividadCompoenente')
            ->withPivot('paa_id','estado','valor');
    }

    public function actividad()
    {
        return $this->belongsTo('App\Actividad','actividad_id');
    }

    public function componente()
    {
        return $this->belongsTo('App\Componente','componente_id');
    }

    public function actividades()
    {
        return $this->belongsToMany('\App\Actividad','actividadEstudioComponente','componeActiv_id','actividad_id')->withPivot('id','estado','fuentehacienda','valor','created_at','porcentaje','total');
    }
    public function fuente()
    {
        return $this->belongsTo('App\Fuente','fuente_id');
    }

    public function proyecto()
    {
        return $this->belongsTo('App\Proyecto','proyecto_id');
    }

    public function fuenteproyecto()
    {
        return $this->belongsTo('App\FuenteProyecto','fuente_id');
    }

    public function meta()
    {
        return $this->belongsTo('App\Meta','id_fk_meta');
    }
    use SoftDeletes;
}
