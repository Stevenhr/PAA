<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Fuente extends Model
{
    //
    protected $table = 'fuente';
	protected $primaryKey = 'Id';
	protected $fillable = ['codigo','nombre','descripcion','valor'];
	protected $connection = ''; 
	public $timestamps = true;

	public function componentes()
    {
        return $this->hasMany('App\Componente','Id_fuente');
    }

    public function actividadcomponentes()
    {
        return $this->hasMany('App\ActividadComponente','fuente_id');
    }

    public function proyecto()
    {
        return $this->belongsToMany('\App\Proyecto','FuenteProyecto','fuente_id','proyecto_id')
            ->withPivot('id','valor','created_at');
    }

    public function fuentes_proyectos()
    {
        return $this->hasMany('App\FuenteProyecto','fuente_id');
    }

    use SoftDeletes;
}
