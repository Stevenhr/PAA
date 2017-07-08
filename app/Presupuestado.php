<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presupuestado extends Model
{
    //
    protected $table = 'presupuestado';
	protected $primaryKey = 'id';
	protected $fillable = ['componente_id','fuente_proyecto_id','valor','id_fk_meta'];
	protected $connection = ''; 
	public $timestamps = true;

	public function componente()
    {
        return $this->belongsTo('App\Componente','componente_id');
    }

    public function fuente()
    {
        return $this->belongsTo('App\Fuente','fuente_id');
    }

    public function fuenteproyecto()
    {
        return $this->belongsTo('App\FuenteProyecto','fuente_proyecto_id');
    }

    public function componente_c()
    {
        return $this->belongsTo('App\Componente','componente_id');
    }
    public function meta()
    {
        return $this->belongsTo('App\Meta','id_fk_meta');
    }

    use SoftDeletes;
}
