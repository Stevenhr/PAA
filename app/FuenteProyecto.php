<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuenteProyecto extends Model
{
    //
    protected $table = 'FuenteProyecto';
	protected $primaryKey = 'id';
	protected $fillable = ['fuente_id','proyecto_id','valor'];
	protected $connection = ''; 
	public $timestamps = true;

	public function presupuestados()
    {
        return $this->hasMany('App\Presupuestado','fuente_proyecto_id');
    }

    public function fuente()
    {
        return $this->belongsTo('App\Fuente','fuente_id');
    }

    public function proyecto()
    {
        return $this->belongsTo('App\Proyecto','proyecto_id');
    }


    public function paas()
    {
        return $this->belongsToMany('\App\Paa','actividadComponente','fuente_id','id_paa')
            ->withPivot('actividad_id','estado','valor','created_at');
    }

	/*public function componentes()
    {
        return $this->hasMany('App\Componente','Id_fuente');
    }

    public function actividadcomponentes()
    {
        return $this->hasMany('App\ActividadComponente','fuente_id');
    }*/

    use SoftDeletes;
}
