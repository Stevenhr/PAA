<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    //
    protected $table = 'proyecto';
	protected $primaryKey = 'Id';
	protected $fillable = ['Id_presupuesto','codigo','Nombre','fecha_inicio','fecha_fin','valor','descripcion'];
	protected $connection = ''; 
	public $timestamps = true;

	public function metas()
    {
        return $this->hasMany('App\Meta','Id_proyecto');
    }
    public function presupuesto()
    {
        return $this->belongsTo('App\Presupuesto','Id_presupuesto');
    }
    public function paas()
    {
        return $this->hasMany('App\Paa','Id_ProyectoRubro');
    }
}
