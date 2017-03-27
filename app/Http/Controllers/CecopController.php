<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Paa;
use App\Estado;
use App\SubDireccion;
class CecopController extends Controller
{
    //

    public function index()
	{
		$subdireccion = Subdireccion::with('areas')->find(1);


		$paas = Paa::with('modalidad', 'tipocontrato', 'rubro')
						->whereIn('Estado', [Estado::Subdireccion, Estado::Aprobado, Estado::Rechazado, Estado::Cancelado,Estado::EstudioConveniencia,Estado::EstudioAprobado,Estado::EstudioCorregido,Estado::EstudioCancelado])
						->whereIn('Id_Area', $subdireccion->areas->pluck('id'))
						->orderBy('id')
						->get();

		$datos = [
			'paas' => $paas,
		];

		return view('gestion_cecop', $datos);
	}
}
