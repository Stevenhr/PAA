<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CambioPaa extends Model
{
    //
    protected $table = 'cambioPaa';
	protected $primaryKey = 'id';
	protected $fillable = ['id_paa','cambio','campo','persona'];
	protected $connection = ''; 
	public $timestamps = true;

	public function paa()
    {
        return $this->belongsTo('App\Paa','id_paa');
    }

    use SoftDeletes;
}
