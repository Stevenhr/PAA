<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fuente extends Model
{
    //
    protected $table = 'fuente';
	protected $primaryKey = 'Id';
	protected $fillable = ['codigo','nombre','descripcion','valor'];
	protected $connection = ''; 
	public $timestamps = false;

	public function componentes()
    {
        return $this->hasMany('App\Componente','Id_fuente');
    }
}
