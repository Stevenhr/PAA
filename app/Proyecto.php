<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    //
    protected $table = 'proyecto';
	protected $primaryKey = 'Id';
	protected $fillable = ['Id_presupuesto','Nombre','fecha_inicio','fecha_fin','valor','descripcion'];
	protected $connection = ''; 
	public $timestamps = false;

	public function metas()
    {
        return $this->hasMany('App\Meta','Id_proyecto');
    }
    public function presupuesto()
    {
        return $this->belongsTo('App\Presupuesto','Id_presupuesto');
    }
}
