<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuenteHacienda extends Model
{
    //
    protected $table = 'fuenteHacienda';
	protected $primaryKey = 'id';
	protected $fillable = ['id','nombre','codigo'];
	protected $connection = ''; 
	public $timestamps = true;
	use SoftDeletes;


}
