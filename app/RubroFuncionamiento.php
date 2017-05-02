<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    public function paas()
    {
        return $this->hasMany('App\Paa','Id_Rubro');
    }

    use SoftDeletes;
}
