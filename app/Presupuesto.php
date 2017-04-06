<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    //
    protected $table = 'presupuesto';
	protected $primaryKey = 'Id';
	protected $fillable = ['Nombre_Actividad','fecha_inicio','fecha_fin','vigencia','presupuesto','Id_proyectoDesarrollo'];
	protected $connection = ''; 
	public $timestamps = false;


	public function proyectos()
    {
        return $this->hasMany('App\Proyecto','Id_presupuesto');
    }

    public function plandesarrollo()
    {
        return $this->belongsTo('App\ProyectoDesarrollo','Id_proyectoDesarrollo');
    }
}
