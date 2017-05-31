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
        $proyecto = Proyecto::where('Id_presupuesto',$id)->get();
        return response()->json(array('proyecto'=>$proyecto ));
    }

    public function proyecto_finanza(Request $request)
    {
    	
    	$proyecto = Proyecto::find($request['proyecto']);

        $paa = Paa::with('componentes')->where('Id_Proyecto','1')->whereIn('Estado',['9'])->get();
        $suma_aprobado=0;
        foreach($paa as $eee){
          if($eee->componentes!=''){
            foreach($eee->componentes as $eeee){
               if($eeee->pivot['valor']!='' && $eeee->pivot['proyecto_id']==$request['proyecto']){
                   $suma_aprobado=$suma_aprobado + $eeee->pivot['valor'];
               }
            }
          }
        }

        $paa2 = Paa::with('componentes')->where('Id_Proyecto','1')->whereIn('Estado',['0','4','5','8','10'])->get();
        $reservado_por_aprobar=0;
        
        foreach($paa2 as $eee){
          if($eee->componentes!=''){
            foreach($eee->componentes as $eeee){
               //dd($eee->componentes);
               if($eeee->pivot['valor']!='' && $eeee->pivot['proyecto_id']==$request['proyecto']){
                   $reservado_por_aprobar=$reservado_por_aprobar + $eeee->pivot['valor'];
               }
            }
          }
        }
    
        $Saldo_libre=$proyecto['valor']-($suma_aprobado+$reservado_por_aprobar);
        $datos=[
	        "Id_Proyecto"=>$proyecto['Id'],
	        "Proyecto"=>$proyecto['Nombre'],
	        "Codigo"=>$proyecto['codigo'],
	        "aprobado"=>$suma_aprobado,
	        "reservado_por_aprobar"=>$reservado_por_aprobar,
	        "Saldo_libre"=>$Saldo_libre,
	        "Total"=>$proyecto['valor']
        ];
        
        return response()->json($datos);
    }


    public function obtenerPaaAprobado(Request $request, $id)
    {
    	
    	$model_A = Paa::with('modalidad','tipocontrato','meta','proyecto','cambiosPaa','rubro_funcionamiento')->where('Id_Proyecto',$id)->whereIn('Estado',['9'])->get();
        return response()->json($model_A);
    }

    
    public function obtenerPaaReservado(Request $request, $id)
    {
    	
    	$model_A = Paa::with('modalidad','tipocontrato','meta','proyecto','cambiosPaa','rubro_funcionamiento')->where('Id_Proyecto',$id)->whereIn('Estado',['0','4','5','8','10'])->get();
        return response()->json($model_A);
    }
}
