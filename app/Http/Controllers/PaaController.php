<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Presupuesto;
use App\Proyecto;

class PaaController extends Controller
{
    //
    public function index()
	{
		$presupuesto = Presupuesto::with('proyectos')->get();
        $datos = [        
            'presupuesto' => $presupuesto
        ];
		return view('configuracionPAA',$datos);
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

        	if($request->input('Id_presupuesto') == '0'){
        		return response()->json($this->guardar($request->all()));
        	}
        	else{
        		return response()->json($this->modificar($request->all()));	
        	}
        	
	}

	public function guardar($input)
	{
		$model_A = new Presupuesto;
		return $this->crear_presspuesto($model_A, $input);
	}

	public function modificar($input)
	{
		$modelo=Presupuesto::find($input["Id_presupuesto"]);
		return $this->modificar_actividad($modelo, $input);
	}

	public function crear_presspuesto($model, $input)
	{
		$model['Nombre_Actividad'] = $input['nombre_presupuesto'];
		$model['fecha_inicio'] = $input['fecha_inicial_presupuesto'];
		$model['fecha_fin'] = $input['fecha_final_presupuesto'];
		$model['presupuesto'] = $input['precio'];
		$model->save();

		$Presupuesto = Presupuesto::all();
		return $Presupuesto;
	}

	public function modificar_actividad($model, $input)
	{
		$model['Nombre_Actividad'] = $input['nombre_presupuesto'];
		$model['fecha_inicio'] = $input['fecha_inicial_presupuesto'];
		$model['fecha_fin'] = $input['fecha_final_presupuesto'];
		$model['presupuesto'] = $input['precio'];
		$model->save();
		$Presupuesto = Presupuesto::all();
		return $Presupuesto;
	}


	public function eliminar_presupuesto(Request $request, $id)
	{
		//$Presupuesto = Presupuesto::find($id);

		$Presupuesto = Presupuesto::with('proyectos')->whereHas('proyectos', function($q) use ($id)
		{
		    $q->where('Id_presupuesto', '=', $id);

		})->get();


		if(count($Presupuesto)>0){
			return response()->json(array('status' => 'error', 'datos' => $Presupuesto));
		}
		else
		{
			$user = Presupuesto::find($id);
			$user->delete();
			$Presupuesto = Presupuesto::all();
			return $Presupuesto;
		}

	}


	public function modificar_presupuesto(Request $request, $id)
	{
		$Presupuesto = Presupuesto::find($id);
		return response()->json($Presupuesto);
	}


	public function validar_proyecto(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	            'idPresupuesto' => 'required',
				'precio_proyecto' => 'required',
				'fecha_final_proyecto' => 'required',
				'fecha_inicial_proyecto' => 'required',
				'nombre_proyecto' => 'required',
        	]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_proyecto') == '0'){
        		return response()->json($this->guardar_Proyecto($request->all()));
        	}
        	else{
        		return response()->json($this->modificar_Proyecto($request->all()));	
        	}
        	
	}

	public function guardar_Proyecto($input)
	{
		$model_A = new Proyecto;
		return $this->crear_proyect($model_A, $input);
	}

	public function modificar_Proyecto($input)
	{
		$modelo=Proyecto::find($input["Id_proyecto"]);
		return $this->modificar_proyect($modelo, $input);
	}

	public function crear_proyect($model, $input)
	{
		$model['Id_presupuesto'] = $input['idPresupuesto'];
		$model['Nombre'] = $input['nombre_proyecto'];
		$model['fecha_inicio'] = $input['fecha_inicial_proyecto'];
		$model['fecha_fin'] = $input['fecha_final_proyecto'];
		$model['valor'] = $input['precio_proyecto'];
		$model->save();

		$presupuesto = Presupuesto::with('proyectos')->get();
		return $presupuesto;
	}

	public function modificar_proyect($model, $input)
	{

		$model['Id_presupuesto'] = $input['idPresupuesto'];
		$model['Nombre'] = $input['nombre_proyecto'];
		$model['fecha_inicio'] = $input['fecha_inicial_proyecto'];
		$model['fecha_fin'] = $input['fecha_final_proyecto'];
		$model['valor'] = $input['precio_proyecto'];
		$model->save();

		$presupuesto = Presupuesto::with('proyectos')->get();
		return $presupuesto;
	}


	public function eliminar_proyecto(Request $request, $id)
	{

		$Proyecto = Proyecto::with('metas')->whereHas('metas', function($q) use ($id)
		{
		    $q->where('Id_proyecto', '=', $id);

		})->get();


		if(count($Proyecto)>0){
			return response()->json(array('status' => 'error', 'datos' => $Proyecto));
		}
		else
		{
			$user = Proyecto::find($id);
			$user->delete();
			$presupuesto = Presupuesto::with('proyectos')->get();
			return $presupuesto;
		}

	}

	public function modificar_proyecto2(Request $request, $id)
	{
		$Presupuesto = Proyecto::find($id);
		return response()->json($Presupuesto);
	}

}
