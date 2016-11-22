<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Presupuesto;

class PaaController extends Controller
{
    //
    public function index()
	{
		return view('configuracionPAA');
	}
	public function proyecto()
	{
		return view('proyecto');
	}

	public function validar_presupuesto(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	           
				'precio' => 'required',
				'fecha_final_presupuesto' => 'required',
				'fecha_inicial_presupuesto' => 'required',
				'nombre_presupuesto' => 'required',
        	]
        );

        if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_presupuesto') == '0')
        	$this->guardar($request->all());
        	else
        	$this->modificar($request->all());

        return response()->json(array('status' => 'ok'));
	}

	public function guardar($input)
	{
		$model_A = new Presupuesto;
		return $this->crear_presspuesto($model_A, $input);
	}

	public function modificar($input)
	{
		
		$modelo=Presupuesto::find($input["Id_presupuesto"]);
		//var_dump($modelo);
		return $this->modificar_actividad($modelo, $input);
	}

	public function crear_presspuesto($model, $input)
	{
		$model['Nombre_Actividad'] = $input['nombre_presupuesto'];
		$model['fecha_inicio'] = $input['fecha_inicial_presupuesto'];
		$model['fecha_fin'] = $input['fecha_final_presupuesto'];
		$model['presupuesto'] = $input['precio'];
		$model->save();

		return $model;
	}
	public function modificar_actividad($model, $input)
	{
		$model['Nombre_Actividad'] = $input['nombre_presupuesto'];
		$model['fecha_inicio'] = $input['fecha_inicial_presupuesto'];
		$model['fecha_fin'] = $input['fecha_final_presupuesto'];
		$model['presupuesto'] = $input['precio'];
		$model->save();

		return $model;
	}

}
