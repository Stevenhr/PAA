<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RubroFuncionamiento extends Model
{
    //
    protected $table = 'rubro_funcionamiento';
	protected $primaryKey = 'id';
	protected $fillable = ['codigo','nombre','fecha_inicio','fecha_fin','valor'];
	protected $connection = ''; 
	public $timestamps = true;

	public function actividadesfuncionamiento()
    {
        return $this->hasMany('App\ActividadFuncionamiento','id_rubro_funcionamiento');
    }
}