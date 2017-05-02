<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubDireccion extends Model
{
    //
    protected $table = 'subdireccion';
	protected $primaryKey = 'id';
	protected $fillable = ['nombre','SubDireccion','Descripcion'];
	protected $connection = ''; 
	public $timestamps = false;

	public function paas()
    {
        return $this->hasMany('App\Paa','Id_Area');
    }

    public function areas()
    {
        return $this->hasMany('App\Area','id_subdireccion');
    }

    use SoftDeletes;

}
