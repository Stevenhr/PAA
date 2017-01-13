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
						->whereIn('Estado', [4, 5])
						->orderBy('Estado')
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

	public function enviar(Request $request)
	{
		$paas = explode(',', $request->input('paas'));

		foreach ($paas as $id) 
		{
			$paa = Paa::where('Id', $id)->first();
			$paa->Estado = 5;
			$paa->save();
		}

		return response()->json(true);
	}
}