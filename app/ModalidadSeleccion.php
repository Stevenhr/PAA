<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModalidadSeleccion extends Model
{
    //
    protected $table = 'modalidadseleccion';
	protected $primaryKey = 'Id';
	protected $fillable = ['Nombre'];
	protected $connection = ''; 
	public $timestamps = false;
}
