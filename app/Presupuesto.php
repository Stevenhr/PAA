<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presupuesto extends Model
{
    //
    protected $table = 'presupuesto';
	protected $primaryKey = 'Id';
	protected $fillable = ['Nombre_Actividad','fecha_inicio','fecha_fin','vigencia','presupuesto','Id_proyectoDesarrollo','vigencia'];
	protected $connection = ''; 
	public $timestamps = true;


	public function proyectos()
    {
        return $this->hasMany('App\Proyecto','Id_presupuesto');
    }

    public function plandesarrollo()
    {
        return $this->belongsTo('App\ProyectoDesarrollo','Id_proyectoDesarrollo');
    }

    use SoftDeletes;
}
