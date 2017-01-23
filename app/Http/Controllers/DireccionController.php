<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Estado;
use App\Paa;

class DireccionController extends BaseController 
{
	public function __construct()
	{

	}

	public function index()
	{
		$paas = Paa::with('modalidad', 'tipocontrato', 'rubro')
						->whereIn('Estado', [Estado::Subdireccion, Estado::Aprobado, Estado::Rechazado, Estado::Cancelado])
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
		$paa->Estado = Estado::Rechazado;
		$paa->Observacion = $request->input('Observaciones');
		$paa->save();

		return response()->json(true);
	}

	public function cancelar(request $request)
	{
		$paa = Paa::where('Id', $request->input('Id'))->first();
		$paa->Estado = Estado::Cancelado;
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
			$paa->Estado = Estado::Aprobado;
			$paa->save();
		}

		return response()->json(true);
	}
}