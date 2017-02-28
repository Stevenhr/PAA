<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadComponente extends Model
{
    //
    protected $table = 'actividadComponente';
	protected $primaryKey = 'id';
	protected $fillable = ['componente_id','actividad_id','valor','estado'];
	protected $connection = ''; 
	public $timestamps = false;


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
        return $this->belongsToMany('\App\Actividad','actividadEstudioComponente','componeActiv_id','actividad_id')           ->withPivot('id','estado','fuentehacienda','valor','created_at','porcentaje','total');
    }


}
