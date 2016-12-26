<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadComponente extends Model
{
    //
    protected $table = 'actividadComponente';
	protected $primaryKey = 'Id';
	protected $fillable = ['actividadComponente_id','paa_id','valor','estado'];
	protected $connection = ''; 
	public $timestamps = false;


	public function paas()
    {
        return $this->belongsToMany('\App\Paa','PaaActividadCompoenente')
            ->withPivot('paa_id','estado','valor');
    }
}
