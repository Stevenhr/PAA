<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ProyectoDesarrollo;
use App\Presupuesto;
use App\Proyecto;
use App\Paa;

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

    public function proyecto_finanza(Request $request)
    {
    	//dd($request['proyecto']);	
        $paa = Paa::with('componentes')->whereIn('Estado',['0','4','5','6','7','8','9','10','11'])->get();
        
        $suma_aprobado=0;
        foreach($paa as $eee){
          if($eee->componentes!=''){
            foreach($eee->componentes as $eeee){
               if($eeee->pivot['valor']!=''){
                   $suma_aprobado=$suma_aprobado + $eeee->pivot['valor'];
               }
            }
          }
        }

        $datos=[
        "aprobado"=>$suma_aprobado
        ];
        
        return response()->json($datos);
    }
}
