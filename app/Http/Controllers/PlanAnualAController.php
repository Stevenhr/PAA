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

class PlanAnualAController extends Controller
{
    //
    public function index()
	{
		$modalidadSeleccion = ModalidadSeleccion::all();
		$rubro = Rubro::all();
		$tipoContrato = TipoContrato::all();
		$componente = Componente::all();
        $fuente = Fuente::all();
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona','1046')->get();

        $datos = [        
            'modalidades' => $modalidadSeleccion,
            'rubros' => $rubro,
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
                'proyecto_inversion' =>'required',
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
        return $this->gestionar_Paa($model_A, $input,$estado,$estadoObservo);
    }
    public function modificar_Paa($input)
    {

        $model_A = Paa::find($input["id_Paa"]);
        $estado=1;
        $estadoObservo=0;
        return $this->gestionar_Paa($model_A, $input,$estado,$estadoObservo);
    }

    public function gestionar_Paa($model, $input,$estado,$estadoObservo)
    {
    
        $model['Id_paa'] = 1;
        $model['Registro'] = $input['id_registro'];
        $model['CodigosU'] = $input['codigo_Unspsc'];
        $model['Id_ModalidadSeleccion'] = $input['modalidad_seleccion'];
        $model['Id_TipoContrato'] = $input['tipo_contrato'];
        $model['ObjetoContractual'] = $input['objeto_contrato'];
        $model['FuenteRecurso'] = $input['fuente_recurso'];
        $model['ValorEstimado'] = $input['valor_estimado'];
        $model['ValorEstimadoVigencia'] = $input['valor_estimado_actualVigencia'];
        $model['VigenciaFutura'] = $input['vigencias_futuras'];
        $model['EstadoVigenciaFutura'] = $input['estado_solicitud'];
        $model['FechaEstudioConveniencia'] = $input['estudio_conveniencia'];
        $model['FechaInicioProceso'] = $input['fecha_inicio'];
        $model['FechaSuscripcionContrato'] = $input['fecha_suscripcion'];
        $model['DuracionContrato'] = $input['duracion_estimada'];
        $model['MetaPlan'] = $input['meta_plan'];
        $model['RecursoHumano'] = $input['recurso_humano'];
        $model['NumeroContratista'] = $input['numero_contratista'];
        $model['DatosResponsable'] = $input['datos_contacto'];
        $model['Id_ProyectoRubro'] = $input['proyecto_inversion'];
        $model['Id_Componente'] = $input['componnente'];
        $model['IdPersona'] = '1046';
        $model['Estado'] = $estado;
        $model['IdPersonaObservo'] = '1046';
        $model['EsatdoObservo'] = $estadoObservo;
        $model['Observacion'] = '';
        $model->save();
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona','1046')->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function fuenteComponente(Request $request, $id)
    {
        $Fuente = Fuente::with('componentes','componentes.actividades.meta.proyecto')->find($id);
        return response()->json($Fuente->componentes);
    }

}
