<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    //
    protected $table = 'actividad';
	protected $primaryKey = 'Id';
	protected $fillable = ['Id_meta','Nombre','fecha_inicio','fecha_fin','valor','descripcion'];
	protected $connection = ''; 
	public $timestamps = false;

	
    public function meta()
    {
        return $this->belongsTo('App\Meta','Id_meta');
    }

    public function componentes()
    {
        return $this->belongsToMany('\App\Componente','actividadComponente')
            ->withPivot('id','componente_id','estado','valor');
    }

  /*  public function actividadescomponetes()
    {
        return $this->hasMany('App\ActividadComponente','actividad_id');
    }*/

    public function actividadescomponetes1()
    {
        return $this->belongsToMany('\App\ActividadComponente','actividadEstudioComponente','actividad_id','componeActiv_id')
            ->withPivot('id','estado','fuentehacienda','valor','created_at','porcentaje','total');
    }
    
}
