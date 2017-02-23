<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuenteHacienda extends Model
{
    //
    protected $table = 'fuenteHacienda';
	protected $primaryKey = 'id';
	protected $fillable = ['id','nombre','codigo'];
	protected $connection = ''; 
	public $timestamps = false;


}
