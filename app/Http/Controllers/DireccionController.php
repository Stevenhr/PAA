<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

	public function rechazar(Request $request)
	{
		$paa = Paa::where('Id', $request->input('Id'))->first();
		$paa->Estado = 3;
		$paa->Observacion = $request->input('Observaciones');
		$paa->save();

		return response()->json(true);
	}
}