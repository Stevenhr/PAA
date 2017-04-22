<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    //
    protected $table = 'rubro';
	protected $primaryKey = 'Id';
	protected $fillable = ['Nombre','Codigo'];
	protected $connection = ''; 
	public $timestamps = false;

	public function paas()
    {
        return $this->hasMany('App\Paa','Id_Rubro');
    }
}
