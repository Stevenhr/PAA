<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstudioConveniencia extends Model
{
    //

    protected $table = 'estudioComveniencia';
	protected $primaryKey = 'id_paa';
	protected $fillable = ['conveniencia','oportunidad','justificacion'];
	protected $connection = ''; 
	public $timestamps = true;

	public function user()
	{
	  return $this->belongsTo('App\User','id_paa');
	}
}
