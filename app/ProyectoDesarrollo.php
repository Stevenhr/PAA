<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProyectoDesarrollo extends Model
{
    //
    protected $table = 'proyecto_desarrollo';
	protected $primaryKey = 'id';
	protected $fillable = ['nombre','fecha_inicio','fecha_fin','valor','descripcion'];
	protected $connection = ''; 
	public $timestamps = true;

	public function presupuestos()
    {
        return $this->hasMany('App\Presupuesto','Id_proyectoDesarrollo');
    }
}
