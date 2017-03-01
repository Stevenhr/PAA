<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ModalidadSeleccion;
use App\Rubro;
use App\TipoContrato;
use App\Componente;
use App\Fuente;
use App\Paa;
use App\Utilidades\Comparador;
use Validator;
use App\Proyecto;
use App\CambioPaa;
use App\PersonaPaa;
use App\Observacion;
use App\EstudioConveniencia;
use App\SubDireccion;
use App\FuenteHacienda;
use App\Area;
use App\ActividadComponente;
use App\Actividad;

class PlanAnualAController extends Controller
{
    //
    public function index()
	{
		$modalidadSeleccion = ModalidadSeleccion::all();
		$proyecto = Proyecto::all();
		$tipoContrato = TipoContrato::all();
		$componente = Componente::all();
        $fuente = Fuente::all();
        $subDireccion = SubDireccion::all();
        $fuenteHacienda = FuenteHacienda::all();
        $paa = Paa::with('modalidad','tipocontrato','rubro','area','componentes')->where('IdPersona',$_SESSION['Id_Persona'])->whereIn('Estado',['0','4','5','6','7'])->get();

        $datos = [        
            'modalidades' => $modalidadSeleccion,
            'proyectos' => $proyecto,
            'tipoContratos' => $tipoContrato,
            'componentes' => $componente,
            'fuentes'=>$fuente,
            'paas' => $paa,
            'subDirecciones' => $subDireccion,
            'fuenteHaciendas'=>$fuenteHacienda 
        ];
        //dd($paa);
        //exit();
		return view('paa',$datos);
	}
    
    public function validar_paa(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'id_registro' =>'required',
                'modalidad_seleccion' =>'required',
                'tipo_contrato' =>'required',
                'objeto_contrato' =>'required',
                //'fuente_recurso' =>'required',
                'valor_estimado' =>'required',
                'valor_estimado_actualVigencia' =>'required',
                'vigencias_futuras' =>'required',
                'estado_solicitud' =>'required',
                'estudio_conveniencia' =>'required',
                'fecha_inicio' =>'required',
                'fecha_suscripcion' =>'required',
                'duracion_estimada' =>'required',
                'meta' =>'required',
                'Proyecto_inversion' =>'required',
                'recurso_humano' =>'required',
                'numero_contratista' =>'required',
                'datos_contacto' =>'required',
            ]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

            if($request->input('id_Paa') == '0'){
                return $this->guardar_Paa($request->all());
            }
            else{
                return $this->modificar_Paa($request->all());  
            }
    }


    public function guardar_Paa($input)
    {
        $model_A = new Paa;
        $estado=0;
        $estadoObservo=0;
        $Modifica=0;
        return $this->gestionar_Paa($model_A, $input,$estado,$estadoObservo,$Modifica);
    }
    public function modificar_Paa($input)
    {
        $model_A = Paa::find($input["id_Paa"]);
        $estado=1;
        $estadoObservo=1;
        $Modifica=1;
        return $this->gestionar_Paa($model_A, $input,$estado,$estadoObservo,$Modifica);
    }

    public function gestionar_Paa($model, $input,$estado,$estadoObservo,$Modifica)
    {
        $personapaa = PersonaPaa::find($_SESSION['Id_Persona']);

            $data0 = json_decode($input['Dato_Actividad_Codigos']);
            $cod="";
            foreach($data0 as $obj){
                if($cod=="")
                 $cod= $cod."".$obj->codigo."";
                else
                 $cod= $cod.",".$obj->codigo."";
            }

            //var_dump($cod);

        $modeloPA = new Paa;
        $modeloPA['Id_paa'] = 0;
        $modeloPA['Registro'] = $input['id_registro'];
        $modeloPA['CodigosU'] = $cod;
        $modeloPA['Id_ModalidadSeleccion'] = $input['modalidad_seleccion'];
        $modeloPA['Id_TipoContrato'] = $input['tipo_contrato'];
        $modeloPA['ObjetoContractual'] = $input['objeto_contrato'];
        $modeloPA['FuenteRecurso'] = $input['fuente_recurso'];
        $modeloPA['ValorEstimado'] = $input['valor_estimado'];
        $modeloPA['ValorEstimadoVigencia'] = $input['valor_estimado_actualVigencia'];
        $modeloPA['VigenciaFutura'] = $input['vigencias_futuras'];
        $modeloPA['EstadoVigenciaFutura'] = $input['estado_solicitud'];
        $modeloPA['FechaEstudioConveniencia'] = $input['estudio_conveniencia'];
        $modeloPA['FechaInicioProceso'] = $input['fecha_inicio'];
        $modeloPA['FechaSuscripcionContrato'] = $input['fecha_suscripcion'];
        $modeloPA['DuracionContrato'] = $input['duracion_estimada'];
        $modeloPA['MetaPlan'] = $input['meta'];
        $modeloPA['RecursoHumano'] = $input['recurso_humano'];
        $modeloPA['NumeroContratista'] = $input['numero_contratista'];
        $modeloPA['DatosResponsable'] = $input['datos_contacto'];
        $modeloPA['Id_ProyectoRubro'] = $input['Proyecto_inversion'];
        $modeloPA['IdPersona'] = $_SESSION['Id_Persona'];
        $modeloPA['Estado'] = $estado;
        $modeloPA['IdPersonaObservo'] = '';
        $modeloPA['EsatdoObservo'] = $estadoObservo;
        $modeloPA['Observacion'] = '';
        $modeloPA['Id_Area'] = $personapaa['id_area'];
        $modeloPA->save();

        if($Modifica==0){
            $id_paa=$modeloPA->Id;
            $id_paa2=$modeloPA->Id;
            $modeloP = Paa::find($id_paa);
            $modeloP['Id_paa'] = $id_paa;
            $modeloP['Registro'] = $id_paa;
            $modeloP->save();

            $modeloPA = new Paa;
            $modeloPA['Id_paa'] = 0;
            $modeloPA['Registro'] = $input['id_registro'];
            $modeloPA['CodigosU'] = $cod;
            $modeloPA['Id_ModalidadSeleccion'] = $input['modalidad_seleccion'];
            $modeloPA['Id_TipoContrato'] = $input['tipo_contrato'];
            $modeloPA['ObjetoContractual'] = $input['objeto_contrato'];
            $modeloPA['FuenteRecurso'] = $input['fuente_recurso'];
            $modeloPA['ValorEstimado'] = $input['valor_estimado'];
            $modeloPA['ValorEstimadoVigencia'] = $input['valor_estimado_actualVigencia'];
            $modeloPA['VigenciaFutura'] = $input['vigencias_futuras'];
            $modeloPA['EstadoVigenciaFutura'] = $input['estado_solicitud'];
            $modeloPA['FechaEstudioConveniencia'] = $input['estudio_conveniencia'];
            $modeloPA['FechaInicioProceso'] = $input['fecha_inicio'];
            $modeloPA['FechaSuscripcionContrato'] = $input['fecha_suscripcion'];
            $modeloPA['DuracionContrato'] = $input['duracion_estimada'];
            $modeloPA['MetaPlan'] = $input['meta'];
            $modeloPA['RecursoHumano'] = $input['recurso_humano'];
            $modeloPA['NumeroContratista'] = $input['numero_contratista'];
            $modeloPA['DatosResponsable'] = $input['datos_contacto'];
            $modeloPA['Id_ProyectoRubro'] = $input['Proyecto_inversion'];
            $modeloPA['IdPersona'] = $_SESSION['Id_Persona'];
            $modeloPA['Estado'] = 2;
            $modeloPA['IdPersonaObservo'] = '';
            $modeloPA['EsatdoObservo'] = 2;
            $modeloPA['Observacion'] = '';
            $modeloPA['Id_Area'] = $personapaa['id_area'];
            $modeloPA->save();

            $id_paa=$modeloPA->Id;
            $modeloP = Paa::find($id_paa);
            $modeloP['Id_paa'] = $id_paa2;
            $modeloP['Registro'] = $id_paa2;
            $modeloP->save();

            $data0 = json_decode($input['Dato_Actividad']);
            foreach($data0 as $obj){
                $modeloPA->componentes()->attach($obj->id_pivot_comp,[
                    'id_paa'=>$id_paa2,
                    'valor'=>$obj->valor,
                    'estado'=>1,
                ]);
            }
        }else{
            $id_paa2=$model->Id;
            $id_paa=$modeloPA->Id;
            $modeloP = Paa::find($id_paa);
            $modeloP['Registro'] = $model->Registro;
            //$modeloP['Observacion'] =$id_paa2;

            $modeloultimo = Paa::where('Registro','=',$model->Registro)->orderby('created_at','DESC')->take(2)->get();
            
            $modeloP['Id_paa'] = $modeloultimo[1]['Id'];
            $modeloP->save();
        }
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona',$_SESSION['Id_Persona'])->whereIn('Estado',['0','4','5','6','7'])->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function fuenteComponente(Request $request, $id)
    {
        $proyecto = Fuente::with('componentes')->find($id);
        return response()->json($proyecto);
    }

    public function select_area(Request $request, $id)
    {
        $areas = SubDireccion::with('areas')->find($id);
        return response()->json($areas);
    }

    public function select_paVinculada(Request $request, $id)
    {   
        $Paa_vin = Area::with(['paas' => function($q) 
        {
            $q->where('compartida', '=', 1);

        }])->get();

        return response()->json($Paa_vin);
    }

    public function select_meta(Request $request, $id)
    {
        $proyecto = Proyecto::with('metas')->find($id);
        return response()->json($proyecto);
    }


    public function verFinanciacion(Request $request, $id)
    {
        $model_A = Paa::with('componentes','componentes.fuente')->find($id);
        //dd($model_A);
        //exit();
        return response()->json(array('dataInfo' => $model_A, 'estado' => $model_A['Estado']) );
    }

     public function EliminarFinanciamiento(Request $request)
    {
 
        $id=$request['id'];
        $paa = Paa::find($id);
        //  $paa->componentes()->detach($request['id_eli']);
        $paa->componentes()->newPivotStatementForId($request['id_eli'])->whereid($request['id_key'])->delete();
        $model_A = Paa::with('componentes','componentes.fuente')->find($id);

        return response()->json($model_A);
    }

    public function agregar_finza(Request $request)
    {   
        $validator = Validator::make($request->all(),
            [
                'valor_contrato' =>'required',
                'Fuente_inversion' =>'required',
                'componnente' =>'required',
            ]
        );

        if ($validator->fails())
        return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

         

        $id=$request['id_act_agre'];
        $id_componente=$request['componnente'];
        $valor=$request['valor_contrato'];

        $paa = new Paa;
        $paa->componentes()->attach($id_componente,[
                    'id_paa'=>$id,
                    'valor'=>$valor,
                    'estado'=>1,
                ]);

        $model_A = Paa::with('componentes','componentes.fuente')->find($id);

        return response()->json(array('status' => 'bein', 'errors' => $validator->errors(),'inf'=>$model_A ));
        
    }

    public function agregar_estudio(Request $request)
    {   
        $validator = Validator::make($request->all(),
            [
                'texta_Conveniencia' =>'required',
                'texta_Oportunidad' =>'required',
                'texta_Justificacion' =>'required',
            ]
        );

        if ($validator->fails())
        return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        $id=$request['id_estudio'];
        $texta_Conveniencia=$request['texta_Conveniencia'];
        $texta_Oportunidad=$request['texta_Oportunidad'];
        $texta_Justificacion=$request['texta_Justificacion'];

        $data0 = json_decode($request['campos_Clasi_Finan']);
        $modeloAct = new ActividadComponente;
        $finanzas = ActividadComponente::with('actividades')->where('id_paa',$id)->get();

            foreach ($finanzas as $finanza) {
                foreach ($finanza->actividades as &$actividad) {
                    $actividad->pivot['estado']=1;
                    $actividad->pivot->save();
                }
            }

            foreach($data0 as $obj){
                $modeloAct->actividades()->attach($obj->actividad_ingre,[
                    'componeActiv_id'=>$obj->componente,
                    'valor'=>$obj->valor_componente,
                    'estado'=>0,
                    'fuentehacienda'=>$obj->Fuente_ingre,
                    'porcentaje'=>$obj->porcentaje,
                    'valor'=>$obj->valor_componente,
                    'total'=>$obj->valor_total_ingr,
                ]);
            }

        if($request['id_estudio_pass']==0)
        {
            $EstudioConveniencia = new EstudioConveniencia;
        }
        else
        {
            $EstudioConveniencia = EstudioConveniencia::find($id);
        }

        $EstudioConveniencia['id_paa'] = $id;
        $EstudioConveniencia['conveniencia'] = $texta_Conveniencia;
        $EstudioConveniencia['oportunidad'] = $texta_Oportunidad;
        $EstudioConveniencia['justificacion'] = $texta_Justificacion;
        $EstudioConveniencia->save();

        $model_A = Paa::with('componentes','componentes.fuente')->find($id);

        return response()->json($model_A->componentes);
    }

    public function obtenerPaa(Request $request, $id)
    {
        $model_A = Paa::with('rubro')->find($id);
        return response()->json($model_A);
    }

    public function verificarCompartPaa(Request $request, $id)
    {
        $model_A = Paa::find($id);
        return response()->json($model_A);
    }

    public function siCompartirPaa(Request $request, $id)
    {
        $modeloPA = Paa::find($id);
        $modeloPA['compartida'] = 1;
        $modeloPA->save();
        return response()->json($modeloPA);
    }
    public function noCompartirPaa(Request $request, $id)
    {
        $modeloPA = Paa::find($id);
        $modeloPA['compartida'] = "";
        $modeloPA->save();
        return response()->json($modeloPA);
    }

    public function obtenerEstidioConveniencia(Request $request, $id)
    {
        $EstudioConveniencias =  EstudioConveniencia::find($id);
        $paa = Paa::with('modalidad','tipocontrato','meta.actividades','area','componentes')->find($id);
        $finanzas = ActividadComponente::with('actividades')->where('id_paa',$id)->get();

        foreach ($finanzas as $finanza) {
                $finanza->Componente = Componente::find($finanza['componente_id']);
            foreach ($finanza->actividades as &$actividad){
                $actividad->Actividad = Actividad::find($actividad->pivot['actividad_id']);
                $actividad->Fuente = FuenteHacienda::find($actividad->pivot['fuentehacienda']);
            }
        }

        $datos = [        
            'EstudioConveniencias' => $EstudioConveniencias,
            'paas' => $paa,
            'finanzas' =>$finanzas
        ];

        return response()->json($datos);
    }

    public function obtenerHistorialPaa(Request $request, $id)
    {
        $model_A = Paa::with('modalidad','tipocontrato','rubro','cambiosPaa')->whereDoesnthave('cambiosPaa')->where('Registro', '=', $id)->get();
        return response()->json($model_A);
    }

     public function obtenerHistorialPaaTodo(Request $request, $id)
    {
        $model_A = Paa::with('modalidad','tipocontrato','rubro','cambiosPaa')->where('Registro', '=', $id)->get();
        return response()->json($model_A);
    }
   

    public function EliminarPaa(Request $request, $id)
    {
        $modeloPA = Paa::find($id);
        $modeloPA['Estado'] = 3;
        $modeloPA['EsatdoObservo'] = 3;
        $modeloPA->save();

        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona',$_SESSION['Id_Persona'])->whereIn('Estado',['0','4','5','6','7'])->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function HistorialEliminarPaa(Request $request, $id)
    {
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona',$_SESSION['Id_Persona'])->where('Estado','3')->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function HistorialEliminarPaaEspecifico(Request $request, $id)
    {
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona',$_SESSION['Id_Persona'])->where('Estado','0')->where('EsatdoObservo','0')->find(41);
        $paas = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona',$_SESSION['Id_Persona'])->where('Registro',41)->where('Estado','1')->get();
        foreach ($paas as &$temp) 
        {
            $temp->cambios = Comparador::comparar($temp->toArray(), $paa->toArray());
        }

        dd($paas);
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function historialObservaciones(Request $request, $id)
    {
        $model_A = Observacion::where('id_registro',$id)->get();
        return response()->json($model_A);
    }

    public function RegistrarObservacion(Request $request)
    {
        $id_persona=$_SESSION['Id_Persona'];

        $modeloObserva = new Observacion;
        $modeloObserva['id_persona'] = $id_persona;
        $modeloObserva['id_registro'] = $request['id'];
        $modeloObserva['estado'] = $request['Estado'];
        $modeloObserva['observacion'] = $request['observacion'];
        $modeloObserva->save();
        return response()->json(array('status' => 'ok'));
    }


    public function datos_vincular(Request $request)
    {   
        $validator = Validator::make($request->all(),
            [
                'selectSubdirecion' =>'required',
                'selectArea' =>'required',
                'selectPaa' =>'required',
            ]
        );

        if ($validator->fails())
        return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        $modeloPA = Paa::find($request['id_estudio3']);
        $modeloPA['vinculada'] = $request['selectPaa'];//-----------voy áca
        $modeloPA->save();

        return response()->json($modeloPA);
    }
    

}
