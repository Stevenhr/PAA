<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaPaa extends Model
{
    //
    protected $table = 'personapaa';
	protected $primaryKey = 'id';
	protected $fillable = ['id_area'];
	protected $connection = ''; 
	public $timestamps = false;


    public function area()
    {
        return $this->belongsTo('App\Area','id_area');
    }
}
