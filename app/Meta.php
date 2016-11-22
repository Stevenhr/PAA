<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    //
    protected $table = 'meta';
	protected $primaryKey = 'Id';
	protected $fillable = ['Id_proyecto','Nombre','fecha_inicio','fecha_fin','valor','descripcion'];
	protected $connection = ''; 
	public $timestamps = false;

	public function actividades()
    {
        return $this->hasMany('App\Actividad','Id_meta');
    }

    public function proyecto()
    {
        return $this->belongsTo('App\Proyecto','Id_proyecto');
    }
}
