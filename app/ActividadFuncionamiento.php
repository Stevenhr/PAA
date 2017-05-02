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

    use SoftDeletes;

}
