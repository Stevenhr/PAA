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
use Validator;
use App\Proyecto;

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
        $model_A = Paa::with('modalidad','tipocontrato','rubro')->where('Registro',$id)->get();
        return response()->json($model_A);
    }

}
