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
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona','1046')->where('Estado','0')->where('EsatdoObservo','0')->get();

        $datos = [        
            'modalidades' => $modalidadSeleccion,
            'proyectos' => $proyecto,
            'tipoContratos' => $tipoContrato,
            'componentes' => $componente,
            'fuentes'=>$fuente,
            'paas' => $paa
        ];
		return view('paa',$datos);
	}
    
    public function validar_paa(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'id_registro' =>'required',
                'codigo_Unspsc' =>'required',
                'modalidad_seleccion' =>'required',
                'tipo_contrato' =>'required',
                'objeto_contrato' =>'required',
                'fuente_recurso' =>'required',
                'valor_estimado' =>'required',
                'valor_estimado_actualVigencia' =>'required',
                'vigencias_futuras' =>'required',
                'estado_solicitud' =>'required',
                'estudio_conveniencia' =>'required',
                'fecha_inicio' =>'required',
                'fecha_suscripcion' =>'required',
                'duracion_estimada' =>'required',
                'meta_plan' =>'required',
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
        $modeloPA = new Paa;
        $modeloPA['Id_paa'] = 0;
        $modeloPA['Registro'] = $input['id_registro'];
        $modeloPA['CodigosU'] = $input['codigo_Unspsc'];
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
        $modeloPA['MetaPlan'] = $input['meta_plan'];
        $modeloPA['RecursoHumano'] = $input['recurso_humano'];
        $modeloPA['NumeroContratista'] = $input['numero_contratista'];
        $modeloPA['DatosResponsable'] = $input['datos_contacto'];
        $modeloPA['Id_ProyectoRubro'] = 1;
        $modeloPA['IdPersona'] = '1046';
        $modeloPA['Estado'] = $estado;
        $modeloPA['IdPersonaObservo'] = '1046';
        $modeloPA['EsatdoObservo'] = $estadoObservo;
        $modeloPA['Observacion'] = '';
        $modeloPA->save();

        if($Modifica==0){
            $id_paa=$modeloPA->Id;
            $modeloP = Paa::find($id_paa);
            $modeloP['Id_paa'] = $id_paa;
            $modeloP['Registro'] = $id_paa;
            $modeloP->save();

            $data0 = json_decode($input['Dato_Actividad']);
            foreach($data0 as $obj){
                $modeloPA->actividadComponentes()->attach($obj->id_pivot_comp,[
                    'paa_id'=>$id_paa,
                    'valor'=>$obj->valor
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
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona','1046')->where('Estado','0')->where('EsatdoObservo','0')->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function fuenteComponente(Request $request, $id)
    {
        $proyecto = Proyecto::with('metas','metas.actividades','metas.actividades.componentes','metas.actividades.componentes.fuente')->find($id);
        //$Fuente = Fuente::with('componentes','componentes.actividades.meta.proyecto.')->find($id);
        return response()->json($proyecto);
    }


    public function verFinanciacion(Request $request, $id)
    {
        $model_A = Paa::with('actividadComponentes','actividadComponentes.actividad','actividadComponentes.componente','actividadComponentes.componente.fuente','actividadComponentes.actividad.meta','actividadComponentes.actividad.meta.proyecto')->find($id);
        return response()->json($model_A->actividadComponentes);
    }

    public function obtenerPaa(Request $request, $id)
    {
        $model_A = Paa::with('rubro')->find($id);
        return response()->json($model_A);
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
    public function aprobarSubDireccion($id)
    {
        $model_A = Paa::find($id);
        $model_A['Estado'] = 4;
        $model_A->save();
        
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona','1046')->whereIn('Estado',['0','4'])->where('EsatdoObservo','0')->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function EliminarPaa(Request $request, $id)
    {
        $modeloPA = Paa::find($id);
        $modeloPA['Estado'] = 3;
        $modeloPA['EsatdoObservo'] = 3;
        $modeloPA->save();

        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona','1046')->where('Estado','0')->where('EsatdoObservo','0')->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function HistorialEliminarPaa(Request $request, $id)
    {
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona','1046')->where('Estado','3')->where('EsatdoObservo','3')->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function HistorialEliminarPaaEspecifico(Request $request, $id)
    {
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona','1046')->where('Estado','0')->where('EsatdoObservo','0')->find(41);
        $paas = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona','1046')->where('Registro',41)->where('Estado','1')->where('EsatdoObservo','1')->get();
        foreach ($paas as &$temp) 
        {
            $temp->cambios = Comparador::comparar($temp->toArray(), $paa->toArray());
        }

        dd($paas);
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }


    public function DatosAprobacion(Request $request)
    {
        $id=$request['id'];
        $Registro=$request['Registro'];
        $resposanble=$request['resposanble'];
        $CodigosU=$request['CodigosU'];
        $Nombre_m=$request['Nombre_m'];
        $Nombre_t=$request['Nombre_t'];
        $ObjetoContractual=$request['ObjetoContractual'];
        $FuenteRecurso=$request['FuenteRecurso'];
        $ValorEstimado=$request['ValorEstimado'];
        $ValorEstimadoVigencia=$request['ValorEstimadoVigencia'];
        $VigenciaFutura=$request['VigenciaFutura'];
        $EstadoVigenciaFutura=$request['EstadoVigenciaFutura'];
        $FechaEstudioConveniencia=$request['FechaEstudioConveniencia'];
        $FechaInicioProceso=$request['FechaInicioProceso'];
        $FechaSuscripcionContrato=$request['FechaSuscripcionContrato'];
        $DuracionContrato=$request['DuracionContrato'];
        $MetaPlan=$request['MetaPlan'];
        $RecursoHumano=$request['RecursoHumano'];
        $NumeroContratista=$request['NumeroContratista'];
        $Nombre_r=$request['Nombre_r'];

        $max = sizeof($id);

        $res="";
        for($i = 0; $i < $max;$i++)
        {
          if($id[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = 'Reviso';
                $modeloCambioPaa['campo'] = 'Reviso';
                $modeloCambioPaa->save();
                $paas = Paa::find($id[$i]);
                $paas['Estado'] = '2';
                $paas->save();
          }

          if(sizeof($CodigosU)>0){
              if($CodigosU[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $CodigosU[$i];
                $modeloCambioPaa['campo'] = 'CodigosU';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['CodigosU'] = $CodigosU[$i];
                $paas->save();
              }
          }

          if(sizeof($Nombre_m)>0){
              if($Nombre_m[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $Nombre_m[$i];
                $modeloCambioPaa['campo'] = 'Id_ModalidadSeleccion';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['Id_ModalidadSeleccion'] = $Nombre_m[$i];
                $paas->save();
              }
          }


          if(sizeof($Nombre_t)>0){
              if($Nombre_t[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $Nombre_t[$i];
                $modeloCambioPaa['campo'] = 'Id_TipoContrato';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['Id_TipoContrato'] = $Nombre_t[$i];
                $paas->save();
              }
          }


          if(sizeof($ObjetoContractual)>0){
              if($ObjetoContractual[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $ObjetoContractual[$i];
                $modeloCambioPaa['campo'] = 'ObjetoContractual';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['ObjetoContractual'] = $ObjetoContractual[$i];
                $paas->save();
              }
          }

          if(sizeof($FuenteRecurso)>0){
              if($FuenteRecurso[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $FuenteRecurso[$i];
                $modeloCambioPaa['campo'] = 'FuenteRecurso';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['FuenteRecurso'] = $FuenteRecurso[$i];
                $paas->save();
              }
          }

          if(sizeof($ValorEstimado)>0){
              if($ValorEstimado[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $ValorEstimado[$i];
                $modeloCambioPaa['campo'] = 'ValorEstimado';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['ValorEstimado'] = $ValorEstimado[$i];
                $paas->save();
              }
          }

          if(sizeof($ValorEstimadoVigencia)>0){
              if($ValorEstimadoVigencia[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $ValorEstimadoVigencia[$i];
                $modeloCambioPaa['campo'] = 'ValorEstimadoVigencia';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['ValorEstimadoVigencia'] = $ValorEstimadoVigencia[$i];
                $paas->save();
              }
          }

          if(sizeof($VigenciaFutura)>0){
              if($VigenciaFutura[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $VigenciaFutura[$i];
                $modeloCambioPaa['campo'] = 'VigenciaFutura';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['VigenciaFutura'] = $VigenciaFutura[$i];
                $paas->save();
              }
          }


          if(sizeof($EstadoVigenciaFutura)>0){
              if($EstadoVigenciaFutura[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $EstadoVigenciaFutura[$i];
                $modeloCambioPaa['campo'] = 'EstadoVigenciaFutura';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['EstadoVigenciaFutura'] = $EstadoVigenciaFutura[$i];
                $paas->save();
              }
          }

          if(sizeof($FechaEstudioConveniencia)>0){
              if($FechaEstudioConveniencia[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $FechaEstudioConveniencia[$i];
                $modeloCambioPaa['campo'] = 'FechaEstudioConveniencia';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['FechaEstudioConveniencia'] = $FechaEstudioConveniencia[$i];
                $paas->save();
              }
          }

          if(sizeof($FechaInicioProceso)>0){
              if($FechaInicioProceso[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $FechaInicioProceso[$i];
                $modeloCambioPaa['campo'] = 'FechaInicioProceso';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['FechaInicioProceso'] = $FechaInicioProceso[$i];
                $paas->save();
              }
          }

          if(sizeof($FechaSuscripcionContrato)>0){
              if($FechaSuscripcionContrato[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $FechaSuscripcionContrato[$i];
                $modeloCambioPaa['campo'] = 'FechaSuscripcionContrato';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['FechaSuscripcionContrato'] = $FechaSuscripcionContrato[$i];
                $paas->save();
              }
          }

          if(sizeof($DuracionContrato)>0){
              if($DuracionContrato[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $DuracionContrato[$i];
                $modeloCambioPaa['campo'] = 'DuracionContrato';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['DuracionContrato'] = $DuracionContrato[$i];
                $paas->save();
              }
          }

          if(sizeof($MetaPlan)>0){
              if($MetaPlan[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $MetaPlan[$i];
                $modeloCambioPaa['campo'] = 'MetaPlan';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['MetaPlan'] = $MetaPlan[$i];
                $paas->save();
              }
          }

          if(sizeof($RecursoHumano)>0){
              if($RecursoHumano[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $RecursoHumano[$i];
                $modeloCambioPaa['campo'] = 'RecursoHumano';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['RecursoHumano'] = $RecursoHumano[$i];
                $paas->save();
              }
          }

          if(sizeof($NumeroContratista)>0){
              if($NumeroContratista[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $NumeroContratista[$i];
                $modeloCambioPaa['campo'] = 'NumeroContratista';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['NumeroContratista'] = $NumeroContratista[$i];
                $paas->save();
              }
          }

          if(sizeof($resposanble)>0){
              if($resposanble[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $resposanble[$i];
                $modeloCambioPaa['campo'] = 'DatosResponsable';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['DatosResponsable'] = $resposanble[$i];
                $paas->save();
              }
          }

          if(sizeof($Nombre_r)>0){
              if($Nombre_r[$i]!="0"){
                $modeloCambioPaa = new CambioPaa;
                $modeloCambioPaa['id_paa'] = $id[$i];
                $modeloCambioPaa['cambio'] = $Nombre_r[$i];
                $modeloCambioPaa['campo'] = 'Id_ProyectoRubro';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['Id_ProyectoRubro'] = $Nombre_r[$i];
                $paas->save();
              }
          }

        }
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona','1046')->where('Estado','0')->where('EsatdoObservo','0')->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa));

    }

}
