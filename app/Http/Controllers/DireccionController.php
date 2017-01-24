<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Estado;
use App\Observacion;
use App\Subdireccion;
use App\Paa;

class DireccionController extends BaseController 
{

	protected $Usuario;

	public function __construct()
	{
		if (isset($_SESSION['Usuario']))
			$this->Usuario = $_SESSION['Usuario'];
	}

	public function index()
	{
		$subdireccion = Subdireccion::with('areas')->find($this->Usuario['Id_SubDireccion']);


		$paas = Paa::with('modalidad', 'tipocontrato', 'rubro')
						->whereIn('Estado', [Estado::Subdireccion, Estado::Aprobado, Estado::Rechazado, Estado::Cancelado])
						->whereIn('Id_Area', $subdireccion->areas->pluck('id'))
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
		$paa->save();
		
		$this->agregarObservacion($paa, $request->input('Observaciones'));
		return response()->json(true);
	}

	public function cancelar(request $request)
	{
		$paa = Paa::where('Id', $request->input('Id'))->first();
		$paa->Estado = Estado::Cancelado;
		$paa->save();

		$this->agregarObservacion($paa, $request->input('Observaciones'));
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

	private function agregarObservacion($paa, $texto)
	{		
		$observacion = new Observacion;
		$observacion->id_registro = $paa['Id'];
		$observacion->id_persona = $this->Usuario[0];
		$observacion->observacion = $texto;
		$observacion->Estado =  Estado::toString($paa['Estado']);

		$observacion->save();
	}
}