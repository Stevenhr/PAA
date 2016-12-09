<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ModalidadSeleccion;
use App\Rubro;
use App\TipoContrato;
use App\Componente;
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

        $datos = [        
            'modalidades' => $modalidadSeleccion,
            'rubros' => $rubro,
            'tipoContratos' => $tipoContrato,
            'componentes' => $componente
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
                'componnente' =>'required',
            ]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

            if($request->input('Id_meta') == '0'){
                return $this->guardar_Meta($request->all());
            }
            else{
                return $this->modificar_Meta($request->all());  
            }
    }
}
