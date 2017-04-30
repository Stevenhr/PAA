<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModalidadSeleccion extends Model
{
    //
    protected $table = 'modalidadseleccion';
	protected $primaryKey = 'Id';
	protected $fillable = ['Nombre','Codigo'];
	protected $connection = ''; 
	public $timestamps = false;

	public function paas()
    {
        return $this->hasMany('App\Paa','Id_ModalidadSeleccion');
    }
}
