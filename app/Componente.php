<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Componente extends Model
{
    //
    protected $table = 'componente';
	protected $primaryKey = 'Id';
	protected $fillable = ['Nombre','fecha_inicio','fecha_fin','valor','descripcion','codigo','Id_fuente'];
	protected $connection = ''; 
	public $timestamps = true;

	public function fuente()
    {
        return $this->belongsTo('App\Fuente','Id_fuente');
    }

    public function actividades()
    {
        return $this->belongsToMany('\App\Actividad','actividadComponente')
            ->withPivot('id','actividad_id','estado','valor');
    }

    public function actividadescomponetes()
    {
        return $this->hasMany('App\ActividadComponente','componente_id');//actividad_id
    }

    public function paas()
    {
        return $this->belongsToMany('\App\Paa','actividadComponente')
            ->withPivot('actividad_id','estado','valor','created_at');
    }

    public function fuentes_proyectos()
    {
        return $this->hasMany('App\FuenteProyecto','componente_id');
    }

    use SoftDeletes;

}
