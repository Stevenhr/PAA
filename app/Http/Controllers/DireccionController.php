<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Paa;

class DireccionController extends BaseController 
{

	public function __construct()
	{

	}

	public function index()
	{
		$paas = Paa::with('modalidad', 'tipocontrato', 'rubro')
						->where('Estado', 4)
						->get();

		$datos = [
			'paas' => $paas,
		];

		return view('aprobacion-subdireccion-paa', $datos);
	}
}