<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Estado;
use App\Paa;
use App\SubDireccion;
use App\Area;

class PlaneacionController extends BaseController 
{
	public function __construct()
	{

	}

	public function index() 
	{
		$subdirecciones = SubDireccion::with(['areas', 'areas.paas' => function($query)
			{
				$query->whereIn('Estado', [Estado::EstudioAprobado,Estado::EstudioCancelado])
					  ->whereHas('fuentesproyectos', function($query)
                        {
                            $query->whereHas('proyecto', function($query_proyecto)
                            {
                                $query_proyecto->whereHas('presupuesto', function($query_presupuesto)
                                {
                                    $query_presupuesto->where('vigencia', Estado::VIGENCIA);
                                });
                            });
                        })
                      ->get();
			}, 'areas.paas.modalidad', 'areas.paas.tipocontrato', 'areas.paas.rubro'])->get();


		$datos = [
			'subdirecciones' => $subdirecciones,
		];

		return view('aprobacion-planeacion-paa', $datos);
	}
}


