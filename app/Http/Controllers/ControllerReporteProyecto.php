<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ProyectoDesarrollo;
use App\Presupuesto;
use App\Proyecto;

class ControllerReporteProyecto extends Controller
{
    public function index()
	{
		$proyectoDesarrollo = ProyectoDesarrollo::all();
		$datos = [        
            'planDesarrollo' => $proyectoDesarrollo
        ];
		return view('reporteproyecto',$datos);
	}

	public function select_vigencia(Request $request, $id)
    {
        $vigencias = Presupuesto::find($id);
        return response()->json(array('vigencias'=>$vigencias ));
    }

    public function select_proyecto(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);
        return response()->json(array('proyecto'=>$proyecto ));
    }
}
