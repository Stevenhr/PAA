<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    //
    protected $table = 'componente';
	protected $primaryKey = 'Id';
	protected $fillable = ['Nombre','fecha_inicio','fecha_fin','valor','descripcion','codigo','Id_fuente'];
	protected $connection = ''; 
	public $timestamps = false;


	public function fuente()
    {
        return $this->belongsTo('App\Fuente','Id_fuente');
    }

    public function actividades()
    {
        return $this->belongsToMany('\App\Actividad','actividadComponente')
            ->withPivot('id','actividad_id','estado','valor');
    }


}
