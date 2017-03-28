<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial_cecop extends Model
{
    //
    protected $table = 'historial_cecop';
	protected $primaryKey = 'id';
	protected $fillable = ['id_usuario','fecha_generacion','codigo_cecop','ubicacion_archivo'];
	protected $connection = ''; 
	public $timestamps = true;
}
