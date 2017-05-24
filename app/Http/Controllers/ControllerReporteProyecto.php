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
    	
    	$proyecto = Proyecto::find($request['proyecto']);

        $paa = Paa::with('componentes')->where('Id_Proyecto',$request['proyecto'])->whereIn('Estado',['9'])->get();
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

        $paa2 = Paa::with('componentes')->where('Id_Proyecto',$request['proyecto'])->whereIn('Estado',['0','4','5','8','10'])->get();
        $reservado_por_aprobar=0;
        foreach($paa2 as $eee){
          if($eee->componentes!=''){
            foreach($eee->componentes as $eeee){
               if($eeee->pivot['valor']!=''){
                   $reservado_por_aprobar=$reservado_por_aprobar + $eeee->pivot['valor'];
               }
            }
          }
        }
        $Saldo_libre=$proyecto['valor']-($suma_aprobado+$reservado_por_aprobar);
        $datos=[
	        "Proyecto"=>$proyecto['Nombre'],
	        "Codigo"=>$proyecto['codigo'],
	        "aprobado"=>$suma_aprobado,
	        "reservado_por_aprobar"=>$reservado_por_aprobar,
	        "Saldo_libre"=>$Saldo_libre,
	        "Total"=>$proyecto['valor']
        ];
        
        return response()->json($datos);
    }
}
