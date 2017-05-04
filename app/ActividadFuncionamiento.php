<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActividadFuncionamiento extends Model
{
    //
    protected $table = 'actividad_funcionamiento';
	protected $primaryKey = 'id';
	protected $fillable = ['id_rubro_funcionamiento','nombre'];
	protected $connection = ''; 
	public $timestamps = true;


	public function rubrofuncionamiento()
    {
        return $this->belongsTo('App\RubroFuncionamiento','id_rubro_funcionamiento');
    }

    public function paas()
    {
        return $this->belongsToMany('\App\Paa','actividadEstudioRubro','actividad_f_id','paa_id')->withPivot('id','estado','fuentehacienda','valor','created_at','porcentaje','total');
    }

    use SoftDeletes;

}
