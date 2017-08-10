<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyecto extends Model
{
    //
    protected $table = 'proyecto';
	protected $primaryKey = 'Id';
	protected $fillable = ['Id_presupuesto','codigo','Nombre','fecha_inicio','fecha_fin','valor','descripcion','id_subdireccion'];
	protected $connection = ''; 
	public $timestamps = true;

	public function metas()
    {
        return $this->hasMany('App\Meta','Id_proyecto');
    }
    public function presupuesto()
    {
        return $this->belongsTo('App\Presupuesto','Id_presupuesto');
    }

    public function subDireccion()
    {
        return $this->belongsTo('App\SubDireccion','id_subdireccion');
    }

    public function paas()
    {
        return $this->hasMany('App\Paa','Id_Proyecto');
    }
    public function fuente()
    {
        return $this->belongsToMany('\App\Fuente','FuenteProyecto','proyecto_id','fuente_id')
            ->withPivot('id','valor','created_at');
    }

    use SoftDeletes;
}
