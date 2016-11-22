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

	public function componentes()
    {
        return $this->hasMany('App\Componente','Id_actividad');
    }

    public function meta()
    {
        return $this->belongsTo('App\Meta','Id_meta');
    }

}
