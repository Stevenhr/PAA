<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModalidadSeleccion extends Model
{
    //
    protected $table = 'modalidadseleccion';
	protected $primaryKey = 'Id';
	protected $fillable = ['Nombre','Codigo'];
	protected $connection = ''; 
	public $timestamps = true;

	public function paas()
    {
        return $this->hasMany('App\Paa','Id_ModalidadSeleccion');
    }

    use SoftDeletes;
}
