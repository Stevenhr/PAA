<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    //
    protected $table = 'componente';
	protected $primaryKey = 'Id';
	protected $fillable = ['Id_actividad','Nombre','fecha_inicio','fecha_fin','valor','descripcion'];
	protected $connection = ''; 
	public $timestamps = false;


	public function actividad()
    {
        return $this->belongsTo('App\Actividad','Id_actividad');
    }

}
