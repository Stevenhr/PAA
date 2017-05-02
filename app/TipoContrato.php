<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoContrato extends Model
{
    //
    protected $table = 'tipocontrato';
	protected $primaryKey = 'Id';
	protected $fillable = ['Nombre'];
	protected $connection = ''; 
	public $timestamps = true;
    
	public function paas()
    {
        return $this->hasMany('App\Paa','Id_TipoContrato');
    }
    use SoftDeletes;
}
