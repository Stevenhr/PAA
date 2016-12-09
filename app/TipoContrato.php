<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoContrato extends Model
{
    //
    protected $table = 'tipocontrato';
	protected $primaryKey = 'Id';
	protected $fillable = ['Nombre'];
	protected $connection = ''; 
	public $timestamps = false;

	public function paas()
    {
        return $this->hasMany('App\Paa','Id_TipoContrato');
    }
}
