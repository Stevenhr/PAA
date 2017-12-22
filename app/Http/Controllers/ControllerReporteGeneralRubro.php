<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ProyectoDesarrollo;
use App\Presupuesto;
use App\Proyecto;
use App\FuenteProyecto;
use App\Paa;
use App\RubroFuncionamiento;

class ControllerReporteGeneralRubro extends Controller
{
    public function index()
  {
    $proyectoDesarrollo = ProyectoDesarrollo::all();
    $datos = [        
            'planDesarrollo' => $proyectoDesarrollo
        ];
    return view('reportegeneralrubrografico',$datos);
  }

  public function select_vigencia(Request $request, $id)
    {
        $vigencias = Presupuesto::where('Id_proyectoDesarrollo',$id)->get();
        return response()->json(array('vigencias'=>$vigencias ));
    }

    public function select_rubro(Request $request, $id)
    {
        $year = date('Y',strtotime("$id-1-1"));
        $rubro = RubroFuncionamiento::whereYear('fecha_inicio','=',$year)->get();
        return response()->json(array('rubro'=>$rubro ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function proyecto_finanza(Request $request)
    {
      
      $proyecto = RubroFuncionamiento::find($request['proyecto']);

        $paa = Paa::with(['rubro_funcionamiento' => function($query) use ($request)
                    {
                        $query->wherePivot('deleted_at',NULL)->wherePivot('rubro_id',2)->get();
                    }])->whereIn('Estado',['9'])->get();

        $suma_aprobado=0;
        foreach ($paa as $key => $value) 
            {
                foreach ($value->rubro_funcionamiento as $key => $componente) 
                {
                    var_dump($componente->pivot['valor']);
                }
            }

        var_dump($suma_aprobado);
        dd("->> ".$suma_aprobado);
        $paa2 = Paa::with(['componentes' => function($query)
                    {
                        $query->wherePivot('deleted_at',NULL)->get();
                    }])->where('Id_Proyecto',$request['proyecto'])->whereIn('Estado',['0','4','5','8','10'])->get();
        $reservado_por_aprobar=0;
        
        foreach($paa2 as $eee){
          if($eee->componentes!=''){
            foreach($eee->componentes as $eeee){
               //dd($eee->componentes);
                if($eeee->pivot['valor']!='' && $eeee->pivot['proyecto_id']==$request['proyecto'] && $eeee->pivot['deleted_at']=="" ){
                   $reservado_por_aprobar=$reservado_por_aprobar + $eeee->pivot['valor'];
                   //var_dump($eeee->pivot['valor']);
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
