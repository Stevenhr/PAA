<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    protected $table = 'area';
	protected $primaryKey = 'id';
	protected $fillable = ['id_area','nombre'];
	protected $connection = ''; 
	public $timestamps = false;

	public function paas()
    {
        return $this->hasMany('App\Paa','Id_Area');
    }

    public function personapaas()
    {
        return $this->hasMany('App\PersonaPaa','id_area');
    }

   public function subdirecion()
    {
        return $this->belongsTo('App\SubDireccion','id_subdireccion');
    }
}
