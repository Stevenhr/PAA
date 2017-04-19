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
use App\RubroFuncionamiento;
use App\PersonaPaa;
use App\ProyectoDesarrollo;
use App\Presupuestado;
use App\ActividadFuncionamiento;
use App\ActividadComponente;
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
		$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos','presupuestos.proyectos.metas','presupuestos.proyectos.metas.actividades','presupuestos.proyectos.metas.actividades')->get();
		$fuente = Fuente::all();
		$componente = Componente::with('fuente')->get();
		$rubroFuncionam = RubroFuncionamiento::with('actividadesfuncionamiento')->get();
		
        $datos = [        
            'proyectoDesarrollo' => $proyectoDesarrollo,
            'fuentes'=>$fuente,
            'componentes'=>$componente,
            'rubrosFuncionamiento'=>$rubroFuncionam,
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
		$datos::updateOrCreate(['Id_Persona' => $persona->Id_Persona],['Email' => $request->email, 'Id_Persona' => $persona->Id_Persona]);
        $personapaa = new PersonaPaa;
        $personapaa::updateOrCreate(['id' => $persona->Id_Persona],['id' => $persona->Id_Persona, 'id_area' => $request->area]);
   
        return response()->json(array('status' => 'ok'));		
	}

	public function obtener(Request $request, $id)
	{
		$persona = $this->repositorio_personas->obtener($id);
		$datos = Datos::where('Id_Persona',$id)->first();
		$personapaa = PersonaPaa::find($id);
		if($datos){
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
				'idProyectoDesa' => 'required',
				'vigencia' => 'required',
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
		$proyectoDesa = ProyectoDesarrollo::find($input['idProyectoDesa']);

		$proyectos = Presupuesto::where('Id_proyectoDesarrollo',$input['idProyectoDesa'])->get();
		$sum = $proyectos->sum( 'presupuesto' );

		$disponible=$proyectoDesa['valor']-$sum;
		$valo= str_replace('.', '', $input['precio']);

		if($disponible>=$valo){
			$model['Id_proyectoDesarrollo'] = $input['idProyectoDesa'];
			$model['vigencia'] = $input['vigencia'];
			$model['fecha_inicio'] = $input['fecha_inicial_presupuesto'];
			$model['fecha_fin'] = $input['fecha_final_presupuesto'];
			$model['presupuesto'] = $valo;
			$model->save();
			$disponible=$disponible-$valo;
			$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos')->get();
		    return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo,'disponible'=>$disponible));
		}else{
			$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos')->get();
		    return response()->json(array('status' => 'valor', 'proyectoDesarrollo' => $proyectoDesarrollo,'disponible'=>$disponible));
		}
	}

	public function modificar_actividad($model, $input)
	{
		$proyectos = Proyecto::where('Id_presupuesto',$input['Id_presupuesto'])->get();
		$sum = $proyectos->sum( 'valor' );
		$valo= str_replace('.', '', $input['precio']);
		
		if($valo>=$sum){	
			$proyectoDesa = ProyectoDesarrollo::find($input['idProyectoDesa']);

			$proyectos = Presupuesto::where('Id_proyectoDesarrollo',$input['idProyectoDesa'])->get();
			$sum = $proyectos->sum( 'presupuesto' );
			
			$disponible=$proyectoDesa['valor']-$sum;	
			$disponible1=$disponible+$model['presupuesto'];

			if($disponible1>=$valo){

				$model['vigencia'] = $input['vigencia'];
				$model['Id_proyectoDesarrollo'] = $input['idProyectoDesa'];
				$model['fecha_inicio'] = $input['fecha_inicial_presupuesto'];
				$model['fecha_fin'] = $input['fecha_final_presupuesto'];
				$model['presupuesto'] = $valo;
				$model->save();

				$proyectoDesa = ProyectoDesarrollo::find($input['idProyectoDesa']);
				$proyectos = Presupuesto::where('Id_proyectoDesarrollo',$input['idProyectoDesa'])->get();
				$sum = $proyectos->sum( 'presupuesto' );
				$disponible=$proyectoDesa['valor']-$sum;

				$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos')->get();
				return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo,'disponible'=>$disponible));
			}else{
				$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos')->get();
			    return response()->json(array('status' => 'valor', 'proyectoDesarrollo' => $proyectoDesarrollo,'disponible'=>$disponible));
			}
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
			$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos')->get();
			return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo));
		}

	}


	public function modificar_presupuesto(Request $request, $id)
	{
		$Presupuesto = Presupuesto::with('plandesarrollo')->find($id);
		return response()->json($Presupuesto);
	}


//   ########################  PLAN DE DESARROLLO  @@@@@@@@@@@@@@@@@@

	public function plan_dearrollo(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	           
				'precio_plan' => 'required',
				'fecha_final_plan' => 'required',
				'fecha_inicial_plan' => 'required',
				'nombre_plan_desarrollo' => 'required'
        	]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_plan_desarrollo') == '0'){
        		return $this->guardar_plan($request->all());
        	}
        	else{
        		return $this->modificar_plan($request->all());	
        	}
        	
	}

	public function guardar_plan($input)
	{
		$model_A = new ProyectoDesarrollo;
		return $this->crear_plan($model_A, $input);
	}

	public function modificar_plan($input)
	{
		$modelo=ProyectoDesarrollo::find($input["Id_plan_desarrollo"]);
		return $this->modificar_plan_desarrollo($modelo, $input);
	}

	public function crear_plan($model, $input)
	{
		$valo= str_replace('.', '', $input['precio_plan']);
		$model['nombre'] = $input['nombre_plan_desarrollo'];
		$model['fecha_inicio'] = $input['fecha_inicial_plan'];
		$model['fecha_fin'] = $input['fecha_final_plan'];
		$model['valor'] = $valo;
		$model->save();

		$Presupuesto = ProyectoDesarrollo::all();
		return response()->json(array('status' => 'modelo', 'proyectodesarrollo' => $Presupuesto));
	}

	public function modificar_plan_desarrollo($model, $input)
	{
		$presupuesto = Presupuesto::where('Id_proyectoDesarrollo',$input['Id_plan_desarrollo'])->get();
		$sum = $presupuesto->sum( 'valor' );

		if($input['precio_plan']>=$sum){
			$valo= str_replace('.', '', $input['precio_plan']);
			$model['nombre'] = $input['nombre_plan_desarrollo'];
			$model['fecha_inicio'] = $input['fecha_inicial_plan'];
			$model['fecha_fin'] = $input['fecha_final_plan'];
			$model['valor'] = $valo;
			$model->save();
			$proyectoDesarrollo = ProyectoDesarrollo::all();
			return response()->json(array('status' => 'modelo', 'proyectodesarrollo' => $proyectoDesarrollo));
		}else{
			return response()->json(array('status' => 'Saldo','sum_proyectos' => $sum));
		}
	}

	public function eliminar_plandesarrollo(Request $request, $id)
	{
		//$Presupuesto = Presupuesto::find($id);

		$Plandesarrollo = ProyectoDesarrollo::with('presupuestos')->whereHas('presupuestos', function($q) use ($id)
		{
		    $q->where('Id_proyectoDesarrollo', '=', $id);

		})->get();

		if(count($Plandesarrollo)>0){
			return response()->json(array('status' => 'error', 'datos' => $Plandesarrollo));
		}
		else
		{
			$user = ProyectoDesarrollo::find($id);
			$user->delete();
			$Plandesarrollo = ProyectoDesarrollo::all();
			return response()->json(array('status' => 'bien', 'datos' => $Plandesarrollo));
		}

	}


	public function modificar_plan_datos(Request $request, $id)
	{
		$Presupuesto = ProyectoDesarrollo::find($id);
		return response()->json($Presupuesto);
	}


//  #########################   PROYECTO  ################################
	public function listadoVigencia(Request $request, $id)
	{
		$Presupuesto = Presupuesto::where('Id_proyectoDesarrollo',$id)->get();
		return response()->json($Presupuesto);
	}

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
		$valor_nuevProyecto= str_replace('.', '', $input['precio_proyecto']);

		$Saldo=$sum_presupuesto-$sum_proyectos;

		if($valor_nuevProyecto<=$Saldo){
			$model['Id_presupuesto'] = $input['idPresupuesto'];
			$model['codigo'] = $input['codigo_proyecto'];
			$model['Nombre'] = $input['nombre_proyecto'];
			$model['fecha_inicio'] = $input['fecha_inicial_proyecto'];
			$model['fecha_fin'] = $input['fecha_final_proyecto'];
			$model['valor'] = $valor_nuevProyecto;
			$model->save();
			$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos')->get();
			return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo));
		}else{
			return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $input['precio_proyecto'],'mensaje'=>'es mayor al saldo del presupuesto que es de'));
		}
	}

	public function modificar_proyect($model, $input)
	{
		$precio_proyecto=str_replace('.', '', $input['precio_proyecto']);
		if($precio_proyecto<=$model['valor']){
			$metas = Meta::where('Id_proyecto',$input["Id_proyecto"])->get();
		    $sum = $metas->sum( 'valor' );

		    if($sum<=$precio_proyecto){
				$model['Id_presupuesto'] = $input['idPresupuesto'];
				$model['codigo'] = $input['codigo_proyecto'];
				$model['Nombre'] = $input['nombre_proyecto'];
				$model['fecha_inicio'] = $input['fecha_inicial_proyecto'];
				$model['fecha_fin'] = $input['fecha_final_proyecto'];
				$model['valor'] = $precio_proyecto;
				$model->save();
				$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos')->get();
				return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo,'mensaje'=>''));
			}else{
				return response()->json(array('status' => 'Saldo', 'saldo' => $sum, 'valorNuevo' => $input['precio_proyecto'],'mensaje'=>'es menor al valor de las metas que es de'));
			}
		}else{
			$proyectos = Proyecto::where('Id_presupuesto',$input['idPresupuesto'])->get();
			$sum = $proyectos->sum( 'valor' );

			$presupuestos = Presupuesto::find($input['idPresupuesto']);
			$sum_proyectos = $proyectos->sum( 'valor' );

			$sum_presupuesto = $presupuestos['presupuesto'];
			$valor_nuevProyecto=str_replace('.', '', $input['precio_proyecto']);
			$Saldo=$sum_presupuesto-$sum_proyectos;
			$Saldo2=$Saldo+$model['valor'];

			if($valor_nuevProyecto<=$Saldo2){
				$model['Id_presupuesto'] = $input['idPresupuesto'];
				$model['Nombre'] = $input['nombre_proyecto'];
				$model['fecha_inicio'] = $input['fecha_inicial_proyecto'];
				$model['fecha_fin'] = $input['fecha_final_proyecto'];
				$model['valor'] = $valor_nuevProyecto;
				$model->save();
				$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos')->get();
				return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo,'mensaje'=>'sobrepasa el presupuesto actual que tiene un saldo de'));
			}else{
				return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $input['precio_proyecto'],'mensaje'=>' es mayor al presupuesto, el saldo del presupuesto total es'));
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
			$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos')->get();
			return $proyectoDesarrollo;
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
		$precio_meta=str_replace('.', '', $input['precio_meta']);
		if($precio_meta<=$model['valor']){
			$actividad = Actividad::where('Id_meta',$input["Id_meta"])->get();
		    $sum = $actividad->sum( 'valor' );

		    if($sum<=$precio_meta){
				$model['Id_proyecto'] = $input['idProyecto_M'];
				$model['Nombre'] = $input['nombre_meta'];
				$model['fecha_inicio'] = $input['fecha_inicial_meta'];
				$model['fecha_fin'] = $input['fecha_final_meta'];
				$model['valor'] = $precio_meta;
				$model->save();
				$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos','presupuestos.proyectos.metas')->get();
				return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo,'mensaje'=>''));
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

			$valor_nuevProyecto=$precio_meta;
			$Saldo=$sum_presupuesto-$sum;
			$Saldo2=$Saldo+$model['valor'];

			if($valor_nuevProyecto<=$Saldo2){
				$model['Id_proyecto'] = $input['idProyecto_M'];
				$model['Nombre'] = $input['nombre_meta'];
				$model['fecha_inicio'] = $input['fecha_inicial_meta'];
				$model['fecha_fin'] = $input['fecha_final_meta'];
				$model['valor'] = $precio_meta;
				$model->save();
				$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos','presupuestos.proyectos.metas')->get();
				return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo,'mensaje'=>'sobrepasa el presupuesto del proyecto actual que tiene un saldo de'));
			}else{
				return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $input['precio_meta'],'mensaje'=>' es mayor al presupuesto del proyecto, el saldo del proyecto es'));
			}
		}
	}

	public function crear_meta($model, $input)
	{
		$meta = Meta::where('Id_proyecto',$input['idProyecto_M'])->get();
		$sum_meta = $meta->sum( 'valor' );
		$proyecto = Proyecto::find($input['idProyecto_M']);
		$sum_presupuesto = $proyecto['valor'];
		$valor_nuevMeta=str_replace('.', '', $input['precio_meta']);

		$Saldo=$sum_presupuesto-$sum_meta;

		if($valor_nuevMeta<=$Saldo)
		{
			$model['Id_proyecto'] = $input['idProyecto_M'];
			$model['Nombre'] = $input['nombre_meta'];
			$model['fecha_inicio'] = $input['fecha_inicial_meta'];
			$model['fecha_fin'] = $input['fecha_final_meta'];
			$model['valor'] = $valor_nuevMeta;
			$model->save();
			
			$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos','presupuestos.proyectos.metas')->get();
			return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo));
		}
		else
		{
			return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $input['precio_meta'],'mensaje'=>'es mayor al saldo del presupuesto que es de'));
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
			$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos','presupuestos.proyectos.metas')->get();
			return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo));
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
	            'idProyectoDesa_Actividad' => 'required',
	            'idPresupuesto_A' => 'required',
	            'idProyecto_A' => 'required',
				'idMeta_A' => 'required',
				'nombre_actividad' => 'required',
				'fecha_inicial_actividad' => 'required',
				'fecha_final_actividad' => 'required',
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

			$finanzas = Actividad::with('actividadescomponetes1')->find($input["Id_actividad"]);

			$sum=0;
                foreach ($finanzas->actividadescomponetes1 as &$actividad) {
                    $sum=$actividad->pivot->sum( 'valor' );
                }
            
		    if($sum<=$input['precio_actividad']){

				$model['Id_meta'] = $input['idMeta_A'];
				$model['Nombre'] = $input['nombre_actividad'];
				$model['fecha_inicio'] = $input['fecha_inicial_actividad'];
				$model['fecha_fin'] = $input['fecha_final_actividad'];
				$model['valor'] = $input['precio_actividad'];
				$model->save();
				$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos','presupuestos.proyectos.metas','presupuestos.proyectos.metas.actividades')->get();
				return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo,'mensaje'=>''));
			}else{
				return response()->json(array('status' => 'Saldo', 'saldo' => $sum, 'valorNuevo' => $input['precio_actividad'],'mensaje'=>'es menor al valor de los componentes que es de'));
			}
		}else{
			$actividad = Actividad::where('Id_meta',$input['idMeta_A'])->get();
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
				$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos','presupuestos.proyectos.metas','presupuestos.proyectos.metas.actividades')->get();
				return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo,'mensaje'=>'sobrepasa el presupuesto del proyecto actual que tiene un saldo de'));
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
			$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos','presupuestos.proyectos.metas','presupuestos.proyectos.metas.actividades')->get();
			return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo));
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

		if($actividad>0){ //count($actividad)
			return response()->json(array('status' => 'error', 'datos' => $actividad));
		}
		else
		{
			$Actividad = Actividad::find($id);
			$Actividad->delete();
			$proyectoDesarrollo = ProyectoDesarrollo::with('presupuestos','presupuestos.proyectos','presupuestos.proyectos.metas','presupuestos.proyectos.metas.actividades')->get();
			return response()->json(array('status' => 'modelo', 'proyectoDesarrollo' => $proyectoDesarrollo));
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
	            'nombre_componente_crear' => 'required'		
        	]
        );

        	if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_componente_crear') == '0')
        	{
        		return $this->guardar_Componente_Crear($request->all());
        	}
        	else
        	{
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
			$model->save();
			$componente = Componente::all();
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
				$model->save();
				$componente = Componente::all();
			    return response()->json(array('status' => 'modelo', 'componentes' => $componente));
				
	}

	public function eliminar_componente_crear(Request $request, $id)
	{
		$Componente = Componente::with('actividadescomponetes')->whereHas('actividadescomponetes', function($q) use ($id)
		{
		    $q->where('componente_id', '=', $id);

		})->get();

		if(count($Componente)>0){
			return response()->json(array('status' => 'error', 'datos' => $Componente));
		}
		else
		{
			$Componente = Componente::find($id);
			$Componente->delete();
			$componente = Componente::all();
			return response()->json(array('status' => 'modelo', 'componentes' => $componente));
		}
		
	}

	public function modificar_componente_crear(Request $request, $id)
	{
		$Componente = Componente::with('fuente')->find($id);
		return response()->json($Componente);
	}



	//     CREAR FUENTE


	public function validar_fuente(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	           
				'codigo_fuente_crear' => 'required',
				'nombre_fuente_crear' => 'required',
				'valor_fuente_crear' => 'required',
        	]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_fuente_crear') == '0'){
        		return $this->guardar_fuente($request->all());
        	}
        	else{
        		return $this->modificar_fuente($request->all());	
        	}
        	
	}

	public function guardar_fuente($input)
	{
		$fuente = new Fuente;
		return $this->crear_fuente($fuente, $input);
	}

	public function modificar_fuente($input)
	{
		
		$id=$input["Id_fuente_crear"];
		$Fuente = Fuente::with('actividadcomponentes')->find($id);
		$suma=$Fuente->actividadcomponentes->sum('valor');

		if($input['valor_fuente_crear']>=$suma){
			$fuente=Fuente::find($input["Id_fuente_crear"]);
			return $this->crear_fuente($fuente, $input);
		}else{
			return response()->json(array('status' => 'valorInsuficiente', 'suma' => $suma));
		}
	}

	public function crear_fuente($model, $input)
	{
		$valor_fuente_crear=str_replace('.', '', $input['valor_fuente_crear']);
		$model['nombre'] = $input['nombre_fuente_crear'];
		$model['valor'] = $valor_fuente_crear;
		$model['codigo'] = $input['codigo_fuente_crear'];
		$model->save();

		$Fuente = Fuente::all();
		return response()->json(array('status' => 'modelo', 'fuente' => $Fuente));
	}

	
	public function eliminar_fuente(Request $request, $id)
	{

		$Fuente = Fuente::with('actividadcomponentes')->whereHas('actividadcomponentes', function($q) use ($id)
		{
		    $q->where('fuente_id', '=', $id);

		})->get();
		

		if(count($Fuente)>0){
			return response()->json(array('status' => 'error', 'datos' => $Fuente));
		}
		else
		{
			$user = Fuente::find($id);
			$user->delete();
			$Fuente = Fuente::all();
			return $Fuente;
		}
	}


	public function modificarFuente(Request $request, $id)
	{
		$Fuente = Fuente::find($id);
		return response()->json($Fuente);
	}



/*########################################   REGISTRO DE FINANZA-FUENTE-COMPOENTE- ########*/
	public function validar_proyectoFinanza(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
				'id_fuente_finanza' => 'required',
				'id_componente_finza' => 'required',
				'nombre_proyecto' => 'required',
        	]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));	
	}



/*#######################################   REGISTRO FINANZA FUENTE  #######################*/

	public function validar_proyectoFinanza_fuente(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
				'id_fuente_finanza_fuente' => 'required',
				'valor_fuente_proyecto' => 'required',
        	]
        );
        
        if ($validator->fails())
          return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

      	if($request->input('id_finanza_fuente_crear') == '0')
      	{
        	return $this->guardar_fuente_finanza($request->all());
    	}
    	else
    	{
    		return $this->modificar_fuente_finanza($request->all());	
    	}
	}

	public function guardar_fuente_finanza($input)
	{	
		$id_p=$input['id_proyect_fina_f'];
		$id=$input['id_fuente_finanza_fuente'];

		$proyecto = Proyecto::find($id_p);
		$val_proyecto = $proyecto['valor'];
		
		$Fuente = Fuente::with(['proyecto' => function($q) use ($id_p)
		{
		    $q->where('proyecto_id', '=', $id_p);

		}])->find($id);
		
		$fuente_vt=Fuente::with('proyecto')->find($input["id_fuente_finanza_fuente"]);
		$valorSum=0;
		foreach ($fuente_vt->proyecto as $value) {
			$valorSum=$valorSum+$value->pivot['valor'];
		}
		$valor_dispo=$fuente_vt['valor']-$valorSum;


		$proyecto_vt=Proyecto::with('fuente')->find($id_p);
		$valorSum_p=0;
		foreach ($proyecto_vt->fuente as $value) {
			$valorSum_p=$valorSum_p+$value->pivot['valor'];
		}
		$valor_dispo_proy=$proyecto_vt['valor']-$valorSum_p;


		$valor_fuente_proyecto=str_replace('.', '', $input['valor_fuente_proyecto']);
		
		if($valor_dispo_proy<$valor_fuente_proyecto)
		{
			return response()->json(array('status' => 'modelo', 'proyecto' => '','upd'=>4));
		}
		else if($Fuente->proyecto->count())
		{
			return response()->json(array('status' => 'modelo', 'proyecto' => '','upd'=>2));
		}
		else if($valor_dispo<$valor_fuente_proyecto)
		{
			return response()->json(array('status' => 'modelo', 'proyecto' => '','upd'=>3));
		}
		else
		{
			return $this->crear_finanza_fuente($Fuente, $input);
		}
	}

	public function modificar_fuente_finanza($input)
	{
		$id_p=$input['id_proyect_fina_f'];
		$id=$input['id_fuente_finanza_fuente'];


		$Fuente = Fuente::find($id);
		$fuente_vt=Fuente::with('proyecto')->find($id);
		$valorSum=0;

		foreach ($fuente_vt->proyecto as $value) {
			if($value->pivot['proyecto_id']!=$id_p)
			$valorSum=$valorSum+$value->pivot['valor'];
		}
		$valor_dispo=$fuente_vt['valor']-$valorSum;


		$proyecto_vt=Proyecto::with('fuente')->find($id_p);
		$valorSum_p=0;
		foreach ($proyecto_vt->fuente as $value) {
			$valorSum_p=$valorSum_p+$value->pivot['valor'];
		}
		$valor_dispo_proy=$proyecto_vt['valor']-$valorSum_p;


		$valor_fuente_proyecto=str_replace('.', '', $input['valor_fuente_proyecto']);

	    if($valor_dispo_proy<$valor_fuente_proyecto)
		{
			return response()->json(array('status' => 'modelo', 'proyecto' => '','upd'=>4));
		}
		else if($valor_dispo<$valor_fuente_proyecto)
		{
			return response()->json(array('status' => 'modelo', 'proyecto' => '','upd'=>3));
		}
		else
		{
			return $this->modificar_finanza_fuente($Fuente, $input);
		}
	}

	public function modificar_finanza_fuente($Fuente, $input)
	{
		$valor_fuente_proyecto=str_replace('.', '', $input['valor_fuente_proyecto']);
		$Fuente->proyecto()->updateExistingPivot($input['id_proyect_fina_f'], array(
	        'valor'=>$valor_fuente_proyecto
	    ));
	    $Proyecto = Proyecto::with('fuente')->find($input['id_proyect_fina_f']);
		return response()->json(array('status' => 'modelo', 'proyecto' => $Proyecto,'upd'=>1));
	}

	public function modificarFuenteProyecto(Request $request)
	{
		$id_p=$request['idproyecto'];
		$id=$request['idfuente'];

		$Fuente = Fuente::with(['proyecto' => function($q) use ($id_p)
		{
		    $q->where('proyecto_id', '=', $id_p);

		}])->find($id);

		return response()->json($Fuente);
	}

	public function crear_finanza_fuente($model, $input)
	{
		$valor_fuente_proyecto=str_replace('.', '', $input['valor_fuente_proyecto']);
		$model->proyecto()->attach($input['id_proyect_fina_f'],['valor'=>$valor_fuente_proyecto]);

		$Proyecto = Proyecto::with('fuente')->find($input['id_proyect_fina_f']);
		return response()->json(array('status' => 'modelo', 'proyecto' => $Proyecto,'upd'=>1));
	}

	public function consultaproyectoFinanza(Request $request, $id)
	{	
			$Proyecto = Proyecto::with('fuente')->find($id);
			return response()->json(array('status' => 'modelo', 'proyecto' => $Proyecto));		
	}

	

	public function eliminarproyectoFinanza(Request $request)
	{
		$fuente=Fuente::with('proyecto')->find($request["idfuente"]);
		$fuente->proyecto()->detach($request['idproyecto']);

      	$Proyecto = Proyecto::with('fuente')->find($request["idproyecto"]);
		return response()->json(array('status' => 'modelo', 'proyecto' => $Proyecto));
	}





/*#######################################   REGISTRO FINANZA FUENTE - COMPONENTE #######################*/

	public function validar_proyectoFinanza_fuenteComponente(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
				'id_componente_finza_f' => 'required',
				'id_componente_finza_c' => 'required',
				'valor_componente_proyecto' => 'required',
        	]
        );
        
        if ($validator->fails())
          return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

      //	dd($request->input('id_finanza_fuenteCompoente_crear'));
      	if($request->input('id_finanza_fuenteCompoente_crear') === "0")
      	{

        	return $this->guardar_fuente_finanzaComponente($request->all());
    	}
    	else
    	{
    		return $this->modificar_fuente_finanzaComponente($request->all());
    	}
	}

	public function modificar_fuente_finanzaComponente($input)
	{
		
		$id=$input['id_finanza_fuenteCompoente_crear'];
		$fuente_f_c=$input['id_componente_finza_f'];
		$compoennte_f_c=$input['id_componente_finza_c'];
		$proyecto_f_c=$input['id_proyect_fina_c'];
		$valor_f_c=str_replace('.', '', $input['valor_componente_proyecto']);

		$valorSumFC=0;
		$Presupuestado=Presupuestado::where('fuente_id',$fuente_f_c)->where('proyecto_id',$proyecto_f_c)->get();
		foreach ($Presupuestado as $value) {
			if($value['componente_id']!=$compoennte_f_c)
			$valorSumFC=$valorSumFC+$value['valor'];
		}

		$Proyecto = Proyecto::with(['fuente' => function($q) use ($fuente_f_c)
		{
		    $q->where('FuenteProyecto.id', '=', $fuente_f_c);

		}])->find($proyecto_f_c);
		
		$valor_dispo=$Proyecto->fuente[0]->pivot['valor']-$valorSumFC;

		$actividadComponente=ActividadComponente::where('componente_id',$compoennte_f_c)->where('fuente_id',$fuente_f_c)->where('proyecto_id',$proyecto_f_c)->get();
		$sum = $actividadComponente->sum( 'valor' );


		if($sum>$valor_f_c){
			return response()->json(array('status' => 'modelo', 'proyecto' => '','upd'=>5));
		}
		else if($valor_dispo<$valor_f_c)
		{
			//dd($valor_dispo."=".$Proyecto->fuente[0]->pivot['valor']." - ".$valorSumFC);
			return response()->json(array('status' => 'modelo', 'proyecto' => '','upd'=>6));
		}
		else
		{	
			$presu = Presupuestado::find($id);
			$presu['valor']=$valor_f_c;
			$presu->save();
	      	
	      	$Proyecto = Proyecto::with('fuente')->find($proyecto_f_c);
			$presupuestado = Presupuestado::with('componente','fuente')->where('proyecto_id',$proyecto_f_c)->get(); //Cambiar a fuentes
			return response()->json(array('status' => 'modelo', 'presupuestado' => $presupuestado,'proyecto'=>$Proyecto,'upd'=>1));	
		}
	}

	public function guardar_fuente_finanzaComponente($input)
	{	

		$fuente_f_c=$input['id_componente_finza_f'];
		$compoennte_f_c=$input['id_componente_finza_c'];
		$proyecto_f_c=$input['id_proyect_fina_c'];
		$valor_f_c=str_replace('.', '', $input['valor_componente_proyecto']);


		$Presupuestado_1=Presupuestado::where('fuente_id',$fuente_f_c)->where('proyecto_id',$proyecto_f_c)->where('componente_id',$compoennte_f_c)->get();
		

		$valorSumFC=0;
		$Presupuestado=Presupuestado::where('fuente_id',$fuente_f_c)->where('proyecto_id',$proyecto_f_c)->get();
		foreach ($Presupuestado as $value) {
			$valorSumFC=$valorSumFC+$value['valor'];
		}

		$Proyecto = Proyecto::with(['fuente' => function($q) use ($fuente_f_c)
		{
		    $q->where('FuenteProyecto.id', '=', $fuente_f_c);

		}])->find($proyecto_f_c);
		
		$valor_dispo=$Proyecto->fuente[0]->pivot['valor']-$valorSumFC;

		if($Presupuestado_1->count()>0)
		{
			return response()->json(array('status' => 'modelo', 'proyecto' => '','upd'=>2));
		}
		else if($valor_dispo<$valor_f_c)
		{
			return response()->json(array('status' => 'modelo', 'proyecto' => '','upd'=>3));
		}
		else
		{	
			$Presupuestado_ = new Presupuestado;
			return $this->crear_finanza_fuente_componente_proyecto($Presupuestado_, $input);
		}

		
	}

	public function crear_finanza_fuente_componente_proyecto($model, $input)
	{
		$fuente_f_c=$input['id_componente_finza_f'];
		$compoennte_f_c=$input['id_componente_finza_c'];
		$proyecto_f_c=$input['id_proyect_fina_c'];
		$valor_f_c=$input['valor_componente_proyecto'];


		$model['componente_id']=$compoennte_f_c;
		$model['fuente_id']=$fuente_f_c;
		$model['proyecto_id']=$proyecto_f_c;
		$model['valor']=$valor_f_c;
		$model->save();

		$Proyecto = Proyecto::with('fuente')->find($proyecto_f_c);
		return response()->json(array('status' => 'modelo', 'proyecto' => $Proyecto,'upd'=>1));
	}

	public function consultacomponenteFinanza(Request $request, $id)
	{	
			$Proyecto = Proyecto::with('fuente')->find($id);
			$presupuestado = Presupuestado::with('componente','fuente')->where('proyecto_id',$id)->get(); //Cambiar a fuentes
			return response()->json(array('status' => 'modelo', 'presupuestado' => $presupuestado,'proyecto'=>$Proyecto));		
	}

	public function eliminarpresupestado(Request $request)
	{
		$id=$request['idPresupuestado'];
      	$id_p=$request['proyecto_id'];
      	$componente_id=$request['componente_id'];
      	$fuente_id=$request['fuente_id'];

		$actividadComponente=ActividadComponente::where('componente_id',$componente_id)->where('fuente_id',$fuente_id)->where('proyecto_id',$id_p)->get();
		$sum = $actividadComponente->sum( 'valor' );

      	if($sum>0){
      		return response()->json(array('status' => 'NoAutorizado'));	
      	}
      	else{
      		$presu = Presupuestado::find($id);
			$presu->delete();
	      	$Proyecto = Proyecto::with('fuente')->find($id_p);
			$presupuestado = Presupuestado::with('componente','fuente')->where('proyecto_id',$id_p)->get();
			return response()->json(array('status' => 'Autorizado', 'presupuestado' => $presupuestado,'proyecto'=>$Proyecto));	
		}
	}

	public function modificarFuenteProyectoCompoente(Request $request)
	{
		$id_p=$request['idPresupuestado'];
		$presu = Presupuestado::find($id_p);
		return response()->json($presu);
	}





	/*###########################    RUBRO DE FUNCIONAMIENTO     ################################*/

	public function rubro_funcionamiento(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	            'codigo_rubro_funciona' => 'required',
				'precio_rubro_funciona' => 'required',
				'fecha_inicial_rubro_funciona' => 'required',
				'fecha_final_rubro_funciona' => 'required',
				'nombre_rubro_funciona' => 'required',
        	]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_rubro_funcionamient') == '0')
        	{
        		return $this->guardar_rubroFuncionamiento($request->all());
        	}
        	else
        	{
        		return $this->modificar_rubroFuncionamiento($request->all());	
        	}	
	}

	public function guardar_rubroFuncionamiento($input)
	{
		$model_A = new RubroFuncionamiento;
		return $this->crear_rubroF($model_A, $input);
	}

	public function modificar_rubroFuncionamiento($input)
	{
		$modelo= RubroFuncionamiento::find($input["Id_rubro_funcionamient"]);
		return $this->crear_rubroF($modelo, $input);
	}

	public function crear_rubroF($model, $input)
	{
		/*$proyectos = Proyecto::where('Id_presupuesto',$input['idPresupuesto'])->get();
		$sum = $proyectos->sum( 'valor' );
		$presupuestos = Presupuesto::find($input['idPresupuesto']);
		$sum_proyectos = $proyectos->sum( 'valor' );
		$sum_presupuesto = $presupuestos['presupuesto'];
		$valor_nuevProyecto= str_replace('.', '', $input['precio_proyecto']);

		$Saldo=$sum_presupuesto-$sum_proyectos;

		if($valor_nuevProyecto<=$Saldo){*/
			$valor_nuevProyecto= str_replace('.', '', $input['precio_rubro_funciona']);

			$model['codigo'] = $input['codigo_rubro_funciona'];
			$model['nombre'] = $input['nombre_rubro_funciona'];
			$model['fecha_inicio'] = $input['fecha_inicial_rubro_funciona'];
			$model['fecha_fin'] = $input['fecha_final_rubro_funciona'];
			$model['valor'] = $valor_nuevProyecto;
			$model->save();
			$rubroFuncionam = RubroFuncionamiento::with('actividadesfuncionamiento')->get();
			return response()->json(array('status' => 'modelo', 'rubroFuncionamiento' => $rubroFuncionam));
		/*}else{
			return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $input['precio_proyecto'],'mensaje'=>'es mayor al saldo del presupuesto que es de'));
		}*/
	}

	public function eliminarrubrofuncionamiento(Request $request, $id)
	{
		$rubroFuncionam = RubroFuncionamiento::with('actividadesfuncionamiento')->find($id);
      	if(count($rubroFuncionam->actividadesfuncionamiento)>0){
      		return response()->json(array('status' => 'error'));	
      	}
      	else{
      		$rubroFuncionamiento = RubroFuncionamiento::find($id);
			$rubroFuncionamiento->delete();
	      	$rubroFuncionam = RubroFuncionamiento::with('actividadesfuncionamiento')->get();
			return response()->json(array('status' => 'modelo', 'rubroFuncionamiento' => $rubroFuncionam));
		}
	}

	public function modificarrubrofuncionamiento(Request $request, $id)
	{
		$rubroFuncionamiento = RubroFuncionamiento::find($id);
		return response()->json($rubroFuncionamiento);
	}



	/*###########################   ACTIVIDAD RUBRO DE FUNCIONAMINEOT  ##############################*/


	public function act_rubro_funcionamiento(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	            'id_rubro_func_act' => 'required',
				'nombre_acividad_funcionamiento' => 'required',
        	]
        );

           if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_act_rubro_funcionamient') == '0')
        	{
        		return $this->guardar_act_rubroFuncionamiento($request->all());
        	}
        	else
        	{
        		return $this->modificar_act_rubroFuncionamiento($request->all());	
        	}	
	}

	public function guardar_act_rubroFuncionamiento($input)
	{
		$model_A = new ActividadFuncionamiento;;
		return $this->crear_Acti_rubroF($model_A, $input);
	}

	public function modificar_act_rubroFuncionamiento($input)
	{
		$modelo= ActividadFuncionamiento::find($input["Id_act_rubro_funcionamient"]);
		return $this->crear_Acti_rubroF($modelo, $input);
	}

	public function crear_Acti_rubroF($model, $input)
	{
		/*$proyectos = Proyecto::where('Id_presupuesto',$input['idPresupuesto'])->get();
		$sum = $proyectos->sum( 'valor' );
		$presupuestos = Presupuesto::find($input['idPresupuesto']);
		$sum_proyectos = $proyectos->sum( 'valor' );
		$sum_presupuesto = $presupuestos['presupuesto'];
		$valor_nuevProyecto= str_replace('.', '', $input['precio_proyecto']);

		$Saldo=$sum_presupuesto-$sum_proyectos;

		if($valor_nuevProyecto<=$Saldo){*/

			$model['id_rubro_funcionamiento'] = $input['id_rubro_func_act'];
			$model['nombre'] = $input['nombre_acividad_funcionamiento'];
			$model->save();
			$rubroFuncionam = RubroFuncionamiento::with('actividadesfuncionamiento')->get();
			return response()->json(array('status' => 'modelo', 'rubroFuncionamiento' => $rubroFuncionam));
		/*}else{
			return response()->json(array('status' => 'Saldo', 'saldo' => $Saldo, 'valorNuevo' => $input['precio_proyecto'],'mensaje'=>'es mayor al saldo del presupuesto que es de'));
		}*/
	}

	public function ElimActividarubrofuncionamiento(Request $request, $id)
	{
		/*$rubroFuncionam = RubroFuncionamiento::with('actividadesfuncionamiento')->find($id);
      	if(count($rubroFuncionam->actividadesfuncionamiento)>0){
      		return response()->json(array('status' => 'error'));	
      	}
      	else{*/
      		$actividadFuncionamiento = ActividadFuncionamiento::find($id);
			$actividadFuncionamiento->delete();
	      	$rubroFuncionam = RubroFuncionamiento::with('actividadesfuncionamiento')->get();
			return response()->json(array('status' => 'modelo', 'rubroFuncionamiento' => $rubroFuncionam));
		/*}*/
	}

	public function modificarActrubrofuncionamiento(Request $request, $id)
	{
		$actividadFuncionamiento = ActividadFuncionamiento::find($id);
		return response()->json($actividadFuncionamiento);
	}
}
