<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Presupuesto;
use App\Proyecto;
use App\Meta;
use App\Area;
use App\Actividad;
use App\Componente;
use App\Fuente;
use App\Persona;
use App\Datos;
use App\PersonaPaa;
use Idrd\Usuarios\Repo\PersonaInterface;

class PaaController extends Controller
{
    //
    private $repositorio_personas;

	public function __construct(PersonaInterface $repositorio_personas)
	{
		$this->repositorio_personas = $repositorio_personas;
	}
    public function index()
	{
		$presupuesto = Presupuesto::with('proyectos','proyectos.metas','proyectos.metas.actividades','proyectos.metas.actividades')->get();
		$fuente = Fuente::all();
		$componente = Componente::with('fuente')->get();

        $datos = [        
            'presupuesto' => $presupuesto,
            'fuentes'=>$fuente,
            'componentes'=>$componente            
        ];

		return view('configuracionPAA',$datos);
	}

	public function proyecto()
	{
		return view('proyecto');
	}

	public function procesar(Request $request)
	{
		$validator = Validator::make($request->all(),
			[
	            'Id_TipoDocumento' => 'required|min:1',
				'Cedula' => 'required|numeric',
				'Primer_Apellido' => 'required',
				'Primer_Nombre' => 'required',
				'Fecha_Nacimiento' => 'required|date',
				'Id_Etnia' => 'required|min:1',
				'Id_Pais' => 'required|min:1',
				'Id_Genero' => 'required|in:1,2',
				'area' => 'required|numeric'
        	]
        );
        if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        
        if($request->input('Id_Persona') == '0')
        	$persona = $this->repositorio_personas->guardar($request->all());
        else
        	$persona = $this->repositorio_personas->actualizar($request->all());
        $datos = new Datos;
		$datos::updateOrCreate(['Email' => $request->email, 'Id_Persona' => $persona->Id_Persona]);
        $personapaa = new PersonaPaa;
        $personapaa::updateOrCreate(['id' => $persona->Id_Persona, 'id_area' => $request->area]);
   
        return response()->json(array('status' => 'ok'));		
	}

	public function obtener(Request $request, $id)
	{
		$persona = $this->repositorio_personas->obtener($id);
		$datos = Datos::where('Id_Persona',$id)->first();
		$personapaa = PersonaPaa::find($id);
		if($personapaa){

		$persona['email'] = $datos->Email;
		$persona['area'] =  $personapaa->id_area;
	}else{

		$persona['email'] = '';
		$persona['area'] =  '';

	}
		return response()->json($persona);
	}
	


	public function obtener_area(Request $request)
	{


		$areas = Area::get();

		return response()->json($areas);
	}

	public function asignarTipoPersona(){
        return view('persona_tipoPersona');
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
        		return $this->guardar($request->all());
        	}
        	else{
        		return $this->modificar($request->all());	
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
		return response()->json(array('status' => 'modelo', 'presupuesto' => $Presupuesto));
	}

	public function modificar_actividad($model, $input)
	{
		$proyectos = Proyecto::where('Id_presupuesto',$input['Id_presupuesto'])->get();
		$sum = $proyectos->sum( 'valor' );

		if($input['precio']>=$sum){
			$model['Nombre_Actividad'] = $input['nombre_presupuesto'];
			$model['fecha_inicio'] = $input['fecha_inicial_presupuesto'];
			$model['fecha_fin'] = $input['fecha_final_presupuesto'];
			$model['presupuesto'] = $input['precio'];
			$model->save();
			$Presupuesto = Presupuesto::all();
			return response()->json(array('status' => 'modelo', 'presupuesto' => $Presupuesto));
		}else{
			return response()->json(array('status' => 'Saldo','sum_proyectos' => $sum));
		}
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





//  #########################   PROYECTO  ################################
	public function validar_proyecto(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	            'idPresupuesto' => 'required',
				'codigo_proyecto' => 'required',
				'precio_proyecto' => 'required',
				'fecha_final_proyecto' => 'required',
				'fecha_inicial_proyecto' => 'required',
				'nombre_proyecto' => 'required',
        	]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_proyecto') == '0'){
        		return $this->guardar_Proyecto($request->all());
        	}
        	else{
        		return $this->modificar_Proyecto($request->all());	
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
		$proyectos = Proyecto::where('Id_presupuesto',$input['idPresupuesto'])->get();
		$sum = $proyectos->sum( 'valor' );
		$presupuestos = Presupuesto::find($input['idPresupuesto']);
		$sum_proyectos = $proyectos->sum( 'valor' );
		$sum_presupuesto = $presupuestos['presupuesto'];
		$valor_nuevProyecto=$input['precio_proyecto'];

		$Saldo=$sum_presupuesto-$sum_proyectos;

		if($valor_nuevProyecto<=$Saldo){
			$model['Id_presupuesto'] = $input['idPresupuesto'];
			$model['codigo'] = $input['codigo_proyecto'];
			$model['Nombre'] = $input['nombre_proyecto'];
			$model['fecha_inicio'] = $input['fecha_inicial_proyecto'];
			$model['fecha_fin'] = $input['fecha_final_proyecto'];
			$model['valor'] = $valor_nuevProyecto;
			$model->save();
			$presupuesto = Presupuesto::with('proyectos')->get();
			return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto));
		}else{
			return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $valor_nuevProyecto,'mensaje'=>'es mayor al saldo del presupuesto que es de'));
		}

		
	}

	public function modificar_proyect($model, $input)
	{
		if($input['precio_proyecto']<=$model['valor']){
			$metas = Meta::where('Id_proyecto',$input["Id_proyecto"])->get();
		    $sum = $metas->sum( 'valor' );

		    if($sum<=$input['precio_proyecto']){
				$model['Id_presupuesto'] = $input['idPresupuesto'];
				$model['codigo'] = $input['codigo_proyecto'];
				$model['Nombre'] = $input['nombre_proyecto'];
				$model['fecha_inicio'] = $input['fecha_inicial_proyecto'];
				$model['fecha_fin'] = $input['fecha_final_proyecto'];
				$model['valor'] = $input['precio_proyecto'];
				$model->save();
				$presupuesto = Presupuesto::with('proyectos')->get();
				return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto,'mensaje'=>''));
			}else{
				return response()->json(array('status' => 'Saldo', 'saldo' => $sum, 'valorNuevo' => $input['precio_proyecto'],'mensaje'=>'es menor al valor de las metas que es de'));
			}
		}else{
			$proyectos = Proyecto::where('Id_presupuesto',$input['idPresupuesto'])->get();
			$sum = $proyectos->sum( 'valor' );

			$presupuestos = Presupuesto::find($input['idPresupuesto']);
			$sum_proyectos = $proyectos->sum( 'valor' );

			$sum_presupuesto = $presupuestos['presupuesto'];
			$valor_nuevProyecto=$input['precio_proyecto'];
			$Saldo=$sum_presupuesto-$sum_proyectos;
			$Saldo2=$Saldo+$model['valor'];

			if($valor_nuevProyecto<=$Saldo2){
				$model['Id_presupuesto'] = $input['idPresupuesto'];
				$model['Nombre'] = $input['nombre_proyecto'];
				$model['fecha_inicio'] = $input['fecha_inicial_proyecto'];
				$model['fecha_fin'] = $input['fecha_final_proyecto'];
				$model['valor'] = $valor_nuevProyecto;
				$model->save();
				$presupuesto = Presupuesto::with('proyectos')->get();
				return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto,'mensaje'=>'sobrepasa el presupuesto actual que tiene un saldo de'));
			}else{
				return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $valor_nuevProyecto,'mensaje'=>' es mayor al presupuesto, el saldo del presupuesto total es'));
			}
		}
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




//  ######################### METAS  ##########################
	public function listadoProyectos(Request $request, $id)
	{
		$Presupuesto = Presupuesto::find($id);
		return response()->json($Presupuesto->proyectos);
	}

	public function validar_meta(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	            'idPresupuesto_M' => 'required',
	            'idProyecto_M' => 'required',
				'precio_meta' => 'required',
				'fecha_final_meta' => 'required',
				'fecha_inicial_meta' => 'required',
				'nombre_meta' => 'required',
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

	public function guardar_Meta($input)
	{
		$model_A = new Meta;
		return $this->crear_meta($model_A, $input);
	}

	public function modificar_Meta($input)
	{
		$modelo=Meta::find($input["Id_meta"]);
		return $this->update_meta($modelo, $input);
	}

	public function update_meta($model, $input)
	{
		//var_dump($input['precio_meta']." ".$model['valor']." ".$input["Id_meta"]);
		if($input['precio_meta']<=$model['valor']){
			$actividad = Actividad::where('Id_meta',$input["Id_meta"])->get();
		    $sum = $actividad->sum( 'valor' );

		    if($sum<=$input['precio_meta']){
				$model['Id_proyecto'] = $input['idProyecto_M'];
				$model['Nombre'] = $input['nombre_meta'];
				$model['fecha_inicio'] = $input['fecha_inicial_meta'];
				$model['fecha_fin'] = $input['fecha_final_meta'];
				$model['valor'] = $input['precio_meta'];
				$model->save();
				$presupuesto = Presupuesto::with('proyectos','proyectos.metas')->get();
				return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto,'mensaje'=>''));
			}else{
				return response()->json(array('status' => 'Saldo', 'saldo' => $sum, 'valorNuevo' => $input['precio_meta'],'mensaje'=>'es menor al valor de las actividades que es de'));
			}

		}else{
			$meta = Meta::where('Id_proyecto',$input['idProyecto_M'])->get();
			//var_dump($meta->lists('Id'));
			//exit();
			$sum = $meta->sum( 'valor' );
			$proyectos = Proyecto::find($input['idProyecto_M']);
			$sum_presupuesto = $proyectos['valor'];

			$valor_nuevProyecto=$input['precio_meta'];
			$Saldo=$sum_presupuesto-$sum;
			$Saldo2=$Saldo+$model['valor'];

			if($valor_nuevProyecto<=$Saldo2){
				$model['Id_proyecto'] = $input['idProyecto_M'];
				$model['Nombre'] = $input['nombre_meta'];
				$model['fecha_inicio'] = $input['fecha_inicial_meta'];
				$model['fecha_fin'] = $input['fecha_final_meta'];
				$model['valor'] = $input['precio_meta'];
				$model->save();
				$presupuesto = Presupuesto::with('proyectos','proyectos.metas')->get();
				return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto,'mensaje'=>'sobrepasa el presupuesto del proyecto actual que tiene un saldo de'));
			}else{
				return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $valor_nuevProyecto,'mensaje'=>' es mayor al presupuesto del proyecto, el saldo del proyecto es'));
			}
		}
	}

	public function crear_meta($model, $input)
	{
		$meta = Meta::where('Id_proyecto',$input['idProyecto_M'])->get();
		$sum_meta = $meta->sum( 'valor' );
		$proyecto = Proyecto::find($input['idProyecto_M']);
		$sum_presupuesto = $proyecto['valor'];
		$valor_nuevMeta=$input['precio_meta'];

		$Saldo=$sum_presupuesto-$sum_meta;

		if($valor_nuevMeta<=$Saldo)
		{
			$model['Id_proyecto'] = $input['idProyecto_M'];
			$model['Nombre'] = $input['nombre_meta'];
			$model['fecha_inicio'] = $input['fecha_inicial_meta'];
			$model['fecha_fin'] = $input['fecha_final_meta'];
			$model['valor'] = $valor_nuevMeta;
			$model->save();
			$presupuesto = Presupuesto::with('proyectos','proyectos.metas')->get();
			return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto));
		}
		else
		{
			return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $valor_nuevMeta,'mensaje'=>'es mayor al saldo del presupuesto que es de'));
		}		
	}


	public function eliminar_meta(Request $request, $id)
	{
		$meta = Meta::with('actividades')->whereHas('actividades', function($q) use ($id)
		{
		    $q->where('Id_meta', '=', $id);

		})->get();

		if(count($meta)>0){
			return response()->json(array('status' => 'error', 'datos' => $meta));
		}
		else
		{
			$Meta = Meta::find($id);
			$Meta->delete();
			$presupuesto = Presupuesto::with('proyectos','proyectos.metas')->get();
			return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto));
		}
	}


	public function modificar_meta2(Request $request, $id)
	{
		$Meta = Meta::with('proyecto','proyecto.presupuesto')->find($id);
		return response()->json($Meta);

	}


//#####################  ACTIVIDAD #######################

	public function listadoMetas(Request $request, $id)
	{
		$Proyecto = Proyecto::find($id);
		return response()->json($Proyecto->metas);
	}

	public function validar_actividad(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	            'idPresupuesto_A' => 'required',
	            'idProyecto_A' => 'required',
				'idMeta_A' => 'required',
				'nombre_actividad' => 'required',
				'fecha_inicial_actividad' => 'required',
				'fecha_final_actividad' => 'required',
				'precio_actividad' => 'required',
        	]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_actividad') == '0'){
        		return $this->guardar_Actividad($request->all());
        	}
        	else{
        		return $this->modificar_Actividades($request->all());	
        	}
	}

	public function guardar_Actividad($input)
	{
		$model_A = new Actividad;
		return $this->crear_Actividad($model_A, $input);
	}

	public function modificar_Actividades($input)
	{
		$modelo=Actividad::find($input["Id_actividad"]);
		return $this->update_Actividad($modelo, $input);
	}

	public function update_Actividad($model, $input)
	{
		//var_dump($input['precio_meta']." ".$model['valor']." ".$input["Id_meta"]);
		if($input['precio_actividad']<=$model['valor']){
			$componente = Componente::where('Id_actividad',$input["Id_actividad"])->get();
		    $sum = $componente->sum( 'valor' );

		    if($sum<=$input['precio_actividad']){

				$model['Id_meta'] = $input['idMeta_A'];
				$model['Nombre'] = $input['nombre_actividad'];
				$model['fecha_inicio'] = $input['fecha_inicial_actividad'];
				$model['fecha_fin'] = $input['fecha_final_actividad'];
				$model['valor'] = $input['precio_actividad'];
				$model->save();
				$presupuesto = Presupuesto::with('proyectos','proyectos.metas','proyectos.metas.actividades')->get();
				return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto,'mensaje'=>''));
			}else{
				return response()->json(array('status' => 'Saldo', 'saldo' => $sum, 'valorNuevo' => $input['precio_actividad'],'mensaje'=>'es menor al valor de los componentes que es de'));
			}

		}else{
			$actividad = Actividad::where('Id_meta',$input['idMeta_A'])->get();
			//var_dump($meta->lists('Id'));
			//exit();
			$sum = $actividad->sum( 'valor' );
			$metas = Meta::find($input['idMeta_A']);
			$sum_presupuesto = $metas['valor'];

			$valor_nuevProyecto=$input['precio_actividad'];
			$Saldo=$sum_presupuesto-$sum;
			$Saldo2=$Saldo+$model['valor'];

			if($valor_nuevProyecto<=$Saldo2){
				$model['Id_meta'] = $input['idMeta_A'];
				$model['Nombre'] = $input['nombre_actividad'];
				$model['fecha_inicio'] = $input['fecha_inicial_actividad'];
				$model['fecha_fin'] = $input['fecha_final_actividad'];
				$model['valor'] = $input['precio_actividad'];
				$model->save();
				$presupuesto = Presupuesto::with('proyectos','proyectos.metas','proyectos.metas.actividades')->get();
				return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto,'mensaje'=>'sobrepasa el presupuesto del proyecto actual que tiene un saldo de'));
			}else{
				return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $valor_nuevProyecto,'mensaje'=>' es mayor al presupuesto de la meta, el saldo del meta es'));
			}
		}
	}

	public function crear_Actividad($model, $input)
	{
		$actividad = Actividad::where('Id_meta',$input['idMeta_A'])->get();
		$sum_actividad = $actividad->sum( 'valor' );

		$meta = Meta::find($input['idMeta_A']);
		$sum_presupuesto = $meta['valor'];

		$valor_nuevMeta=$input['precio_actividad'];

		$Saldo=$sum_presupuesto-$sum_actividad;

		if($valor_nuevMeta<=$Saldo)
		{
			$model['Id_meta'] = $input['idMeta_A'];
			$model['Nombre'] = $input['nombre_actividad'];
			$model['fecha_inicio'] = $input['fecha_inicial_actividad'];
			$model['fecha_fin'] = $input['fecha_final_actividad'];
			$model['valor'] = $valor_nuevMeta;
			$model->save();
			$presupuesto = Presupuesto::with('proyectos','proyectos.metas','proyectos.metas.actividades')->get();
			return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto));
		}
		else
		{
			return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $valor_nuevMeta,'mensaje'=>'es mayor al saldo del presupuesto que es de'));
		}	

	}

	public function eliminar_actividad(Request $request, $id)
	{
		$actividad =0; /*Actividad::with('componentes')->whereHas('componentes', function($q) use ($id)
		{
		    $q->where('Id_actividad', '=', $id);

		})->get();*/

		if(count($actividad)>0){
			return response()->json(array('status' => 'error', 'datos' => $actividad));
		}
		else
		{
			$Actividad = Actividad::find($id);
			$Actividad->delete();
			$presupuesto = Presupuesto::with('proyectos','proyectos.metas','proyectos.metas.actividades')->get();
			return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto));
		}
	}

	public function modificar_actividad2(Request $request, $id)
	{
		$Actividad = Actividad::with('meta','meta.proyecto','meta.proyecto.presupuesto')->find($id);
		return response()->json($Actividad);
	}


	public function listadoActividad(Request $request, $id)
	{
		$meta = Meta::find($id);
		return response()->json($meta->actividades);
	}

	public function validar_componente(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	            'idPresupuesto_C' => 'required',
	            'idProyecto_C' => 'required',
				'idMeta_C' => 'required',
				'idActividad_C' => 'required',
				'nombre_componente' => 'required',
				//'fecha_inicial_componente' => 'required',
				//'fecha_final_componente' => 'required',
				'precio_componente' => 'required',
        	]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_componente') == '0'){
        		return $this->guardar_Componente($request->all());
        	}
        	else{
        		return $this->modificar_Componente($request->all());	
        	}
	}

	public function guardar_Componente($input)
	{
		$model_A = new Componente;
		return $this->crear_Componente($model_A, $input);
	}

	public function crear_Componente($model, $input)
	{
		
		$activida= Actividad::find($input['idActividad_C']);
		$sum_actividad=0;
		foreach ($activida->componentes as $componente) {
		   $sum_actividad=$sum_actividad+$componente->pivot->valor;
		}

		

		//$componente = Componente::where('Id_actividad',$input['idActividad_C'])->get();
		//$sum_actividad = $componente->sum( 'valor' );
		$sum_presupuesto = $activida['valor'];

		$valor_nuevMeta=$input['precio_componente'];

		$Saldo=$sum_presupuesto-$sum_actividad;

		if($valor_nuevMeta<=$Saldo)
		{
			$activida= Actividad::find($input['idActividad_C']);
		    $activida->componentes()->attach($input['nombre_componente'],['estado'=>true,'valor'=>$valor_nuevMeta]);

			$presupuesto = Presupuesto::with('proyectos','proyectos.metas','proyectos.metas.actividades','proyectos.metas.actividades','proyectos.metas.actividades.componentes')->get();
			return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto));
		}
		else
		{
			return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $valor_nuevMeta,'mensaje'=>'es mayor al saldo de la activdad que es de'));
		}	
	}

	public function modificar_Componente($input)
	{
		$model_A =  Componente::find($input["Id_componente"]);
		return $this->update_Componente($model_A, $input);
	}

	public function update_Componente($model, $input)
	{
		//var_dump($input['precio_meta']." ".$model['valor']." ".$input["Id_meta"]);
		if($input['precio_componente']<=$model['valor']){
				$model['Id_actividad'] = $input['idActividad_C'];
				$model['Nombre'] = $input['nombre_componente'];
				$model['fecha_inicio'] = $input['fecha_inicial_componente'];
				$model['fecha_fin'] = $input['fecha_final_componente'];
				$model['valor'] = $input['precio_componente'];
				$model->save();
				$presupuesto = Presupuesto::with('proyectos','proyectos.metas','proyectos.metas.actividades','proyectos.metas.actividades')->get();
				return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto,'mensaje'=>''));
		}else{

			$componente = Componente::where('Id_actividad',$input['idActividad_C'])->get();
			$sum = $componente->sum( 'valor' );

			$actividad = Actividad::find($input['Id_componente']);
			$sum_presupuesto = $actividad['valor'];

			$valor_nuevProyecto=$input['precio_componente'];
			$Saldo=$sum_presupuesto-$sum;
			$Saldo2=$Saldo+$model['valor'];

			if($valor_nuevProyecto<=$Saldo2){
				$model['Id_actividad'] = $input['idActividad_C'];
				$model['Nombre'] = $input['nombre_componente'];
				$model['fecha_inicio'] = $input['fecha_inicial_componente'];
				$model['fecha_fin'] = $input['fecha_final_componente'];
				$model['valor'] = $input['precio_componente'];
				$model->save();
				$presupuesto = Presupuesto::with('proyectos','proyectos.metas','proyectos.metas.actividades','proyectos.metas.actividades')->get();
				return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto,'mensaje'=>'sobrepasa el presupuesto del proyecto actual que tiene un saldo de'));
			}else{
				return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $valor_nuevProyecto,'mensaje'=>' es mayor al presupuesto de la actividad, el saldo de la actividad es'));
			}
		}
	}



	public function eliminar_componente(Request $request, $id)
	{
		
			$Componente = Componente::find($id);
			$Componente->delete();
			$presupuesto = Presupuesto::with('proyectos','proyectos.metas','proyectos.metas.actividades','proyectos.metas.actividades')->get();
			return response()->json(array('status' => 'modelo', 'presupuesto' => $presupuesto));
		
	}

	public function modificar_componente2(Request $request, $id)
	{
		$Actividad = Componente::with('actividad','actividad.meta','actividad.meta.proyecto','actividad.meta.proyecto.presupuesto')->find($id);
		return response()->json($Actividad);
	}




	//%%%%%%%%%%%%%%%%%%%%%%%%%%%   CREAR COMPONENTE


	public function validar_componente_Crear(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	            'codigo_componente_crear' => 'required',
	            'nombre_componente_crear' => 'required',
				'idFuenteF_C' => 'required'			
        	]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_componente_crear') == '0'){
        		return $this->guardar_Componente_Crear($request->all());
        	}
        	else{
        		return $this->modificar_Componente_crear2($request->all());	
        	}
	}

	public function modificar_Componente_crear2($input)
	{
		$model_A =  Componente::find($input["Id_componente_crear"]);
		return $this->update_Componente_crear($model_A, $input);
	}

	public function update_Componente_crear($model, $input)
	{

			$model['codigo'] = $input['codigo_componente_crear'];
			$model['Nombre'] = $input['nombre_componente_crear'];
			$model['Id_fuente'] = $input['idFuenteF_C'];
			$model->save();
			$componente = Componente::with('fuente')->get();
			return response()->json(array('status' => 'modelo', 'componentes' => $componente));
	}

	public function guardar_Componente_Crear($input)
	{
		$model_A = new Componente;
		return $this->crear_Componente_crear($model_A, $input);
	}

	public function crear_Componente_crear($model, $input)
	{
			$model['codigo'] = $input['codigo_componente_crear'];
			$model['Nombre'] = $input['nombre_componente_crear'];
			$model['Id_fuente'] = $input['idFuenteF_C'];
			$model->save();
			$componente = Componente::with('fuente')->get();
			return response()->json(array('status' => 'modelo', 'componentes' => $componente));
	}

	public function eliminar_componente_crear(Request $request, $id)
	{
		
			$Componente = Componente::find($id);
			$Componente->delete();
			$componente = Componente::with('fuente')->get();
			return response()->json(array('status' => 'modelo', 'componentes' => $componente));
		
	}

	public function modificar_componente_crear(Request $request, $id)
	{
		$Componente = Componente::with('fuente')->find($id);
		return response()->json($Componente);
	}

}
