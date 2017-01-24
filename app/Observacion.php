<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    //

    protected $table = 'observacion';
	protected $primaryKey = 'id';
	protected $fillable = ['id_registro','id_persona','observacion','estado'];
	protected $connection = ''; 
	public $timestamps = true;


    public function paa()
    {
        return $this->belongsTo('App\Paa','id_registro');
    }
}
