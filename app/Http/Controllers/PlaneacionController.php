<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Estado;
use App\Paa;

class PlaneacionController extends BaseController 
{
	public function __construct()
	{

	}

	public function index() 
	{
		$paas = Paa::with('modalidad', 'tipocontrato', 'rubro', 'area', 'area.subdireccion')
						->whereIn('Estado', [Estado::Aprobado])
						->orderBy('Estado')
						->get();

		$datos = [
			'paas' => $paas,
		];
	}
}