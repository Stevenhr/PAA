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
use App\Meta;
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
use App\Presupuestado;
use Mail;
use App\FuenteProyecto;
use App\Persona;
use App\RubroFuncionamiento;
use App\Datos;
use App\Estado;
use App\ActividadFuncionamiento;
use Idrd\Usuarios\Repo\PersonaInterface;
use App\Presupuesto;

class PlanAnualAController extends Controller
{
    //

    protected $repositorio_personas;

    public function __construct(PersonaInterface $repositorio_personas)
    {
        $this->repositorio_personas = $repositorio_personas;
    }

    public function index()
	{
        if (!isset($_SESSION['Id_Persona']))
            return redirect()->away('http://www.idrd.gov.co/SIM/Presentacion/');
        
		$modalidadSeleccion = ModalidadSeleccion::all();
		$proyecto = Proyecto::all();
		$tipoContrato = TipoContrato::all();
		$componente = Componente::all();
        $fuente = Fuente::all();
        $subDireccion = SubDireccion::all();
        $fuenteHacienda = FuenteHacienda::all();

        $personapaa = PersonaPaa::find($_SESSION['Id_Persona']);
        $paa_obs=Paa::with('observaciones')->where('IdPersona',$_SESSION['Id_Persona'])->get();

        $area = Area::find($personapaa['id_area']);
        $areasSubdirec=Area::where('id_subdireccion',$area['id_subdireccion'])->get();
//dd($areasSubdirec->pluck('id')->toArray());
        
            $paa = Paa::with(['modalidad','tipocontrato','rubro','area','proyecto','meta','persona','rubro_funcionamiento','fuentesproyectos','componentes' =>     function($query)
            {
               $query->with('actividadescomponetes.fuenteproyecto.fuente','actividadescomponetes.fuenteproyecto.proyecto');
            }])
            ->whereHas('fuentesproyectos', function($query)
                        {
                            $query->whereHas('proyecto', function($query_proyecto)
                            {
                                $query_proyecto->whereHas('presupuesto', function($query_presupuesto)
                                {
                                    $query_presupuesto->where('vigencia', Estado::VIGENCIA);
                                });
                            });
                        })
            ->whereIn('Id_Area',$areasSubdirec->pluck('id')->toArray())
            ->whereIn('Estado',['0','4','5','6','7','8','9','10','11'])
            ->orWhere(function($query) use ($personapaa,$areasSubdirec){
                $query->where('Proyecto1Rubro2',2)
                    ->whereIn('Id_Area',$areasSubdirec->pluck('id')->toArray())
                    ->whereIn('Estado',['0','4','5','6','7','8','9','10','11']);
            })
            ->orderby('Id','asc')
            ->get();

            //dd($paa);
        $datos = [        
            'modalidades' => $modalidadSeleccion,
            'proyectos' => $proyecto,
            'tipoContratos' => $tipoContrato,
            'componentes' => $componente,
            'fuentes'=>$fuente,
            'paas' => $paa,
            'paa_obs' => $paa_obs,
            'id_area'=> $personapaa['id_area'],
            'subDirecciones' => $subDireccion,
            'fuenteHaciendas'=>$fuenteHacienda,
        ];

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
                'fecha_inicio' =>'required',
                'fecha_suscripcion' =>'required',
                'duracion_estimada' =>'required',
                'meta' =>'required',
                'Proyecto_inversion' =>'required',
                'recurso_humano' =>'required',
                'ProyectOrubro' =>'required',
                'numero_contratista' =>'required',
                'unidad_tiempo' =>'required',
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
        $estado=2;
        $estadoObservo=1;
        $Modifica=1;
        $input['estudio_conveniencia']=$model_A['FechaEstudioConveniencia'];

        return $this->gestionar_Paa($model_A, $input,$estado,$estadoObservo,$Modifica);
    }

    public function gestionar_Paa($model, $input,$estado,$estadoObservo,$Modifica)
    {

        $personapaa = PersonaPaa::find($_SESSION['Id_Persona']);
        $data0 = json_decode($input['Dato_Actividad_Codigos']);
        $cod="";
        foreach($data0 as $obj){
            if($cod=="")
             $cod= $cod."".trim($obj->codigo)."";
            else
             $cod= $cod.", ".trim($obj->codigo)."";
        }

            //var_dump($cod);
        $ordenador="";
        $ModiRegi="";
        $id_reg_def=0;
        $id_area_def=0;

        if($input['datos_contacto']!="")
        $ordenador=$input['datos_contacto']." -C.C. ".$input['cedula_contacto'];

        if($input['ProyectOrubro']==1){
            $Id_Proyecto=$input['Proyecto_inversion'];
            $Id_Rubro=null;
        }
        
        if($input['ProyectOrubro']==2){
            $Id_Proyecto=null;
            $Id_Rubro=$input['Proyecto_inversion'];
        }

        $modeloPA = new Paa;
        $modeloPA['Id_paa'] = 0;
        $modeloPA['Registro'] = $input['id_registro'];
        $modeloPA['CodigosU'] = $cod;
        $modeloPA['Id_ModalidadSeleccion'] = $input['modalidad_seleccion'];
        $modeloPA['Id_TipoContrato'] = $input['tipo_contrato'];
        $modeloPA['ObjetoContractual'] = $input['objeto_contrato'];
        $modeloPA['FuenteRecurso'] = $input['fuente_recurso'];
        $modeloPA['ValorEstimado'] = str_replace('.', '', $input['valor_estimado']);
        $modeloPA['ValorEstimadoVigencia'] = str_replace('.','',$input['valor_estimado_actualVigencia']);
        $modeloPA['VigenciaFutura'] = $input['vigencias_futuras'];
        $modeloPA['EstadoVigenciaFutura'] = $input['estado_solicitud'];
        $modeloPA['FechaEstudioConveniencia'] = $input['estudio_conveniencia'];
        $modeloPA['FechaInicioProceso'] = $input['fecha_inicio'];
        $modeloPA['FechaSuscripcionContrato'] = $input['fecha_suscripcion'];
        $modeloPA['DuracionContrato'] = $input['duracion_estimada'];
        $modeloPA['MetaPlan'] = $input['meta'];
        $modeloPA['RecursoHumano'] = $input['recurso_humano'];
        $modeloPA['NumeroContratista'] = $input['numero_contratista'];
        $modeloPA['DatosResponsable'] = $ordenador;
        $modeloPA['Id_Proyecto'] = $Id_Proyecto;
        $modeloPA['Id_Rubro'] = $Id_Rubro;
        $modeloPA['Proyecto1Rubro2'] = $input['ProyectOrubro'];
        $modeloPA['IdPersona'] = $_SESSION['Id_Persona'];
        $modeloPA['Estado'] = $estado;
        $modeloPA['IdPersonaObservo'] = '';
        $modeloPA['EsatdoObservo'] = $estadoObservo;
        $modeloPA['Observacion'] = '';
        $modeloPA['Id_Area'] = $personapaa['id_area'];
        $modeloPA['unidad_tiempo'] = $input['unidad_tiempo'];
        $modeloPA->save();

        $objeto_contrato=$input['objeto_contrato'];
        
        if($Modifica==0)
        {
            $ModiRegi=0;
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
            $modeloPA['ValorEstimado'] = str_replace('.','',$input['valor_estimado']);
            $modeloPA['ValorEstimadoVigencia'] = str_replace('.','',$input['valor_estimado_actualVigencia']);
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
            $modeloPA['Id_Proyecto'] = $Id_Proyecto;
            $modeloPA['Id_Rubro'] = $Id_Rubro;
            $modeloPA['Proyecto1Rubro2'] = $input['ProyectOrubro'];
            $modeloPA['IdPersona'] = $_SESSION['Id_Persona'];
            $modeloPA['Estado'] = 2;
            $modeloPA['IdPersonaObservo'] = '';
            $modeloPA['EsatdoObservo'] = 2;
            $modeloPA['Observacion'] = '';
            $modeloPA['Id_Area'] = $personapaa['id_area'];
            $modeloPA['unidad_tiempo'] = $input['unidad_tiempo'];
            $modeloPA->save();

            $id_paa=$modeloPA->Id;
            $modeloP = Paa::find($id_paa);
            $modeloP['Id_paa'] = $id_paa2;
            $modeloP['Registro'] = $id_paa2;
            $id_reg_def=$id_paa2;
            $id_area_def=$personapaa['id_area'];
            $modeloP->save();

            $data0 = json_decode($input['Dato_Actividad']);
            
            if($data0){
                foreach($data0 as $obj){
                    $presupuestado= Presupuestado::find($obj->id_componente);
                    $id_com=$presupuestado['componente_id'];
                    $modeloPA->componentes()->attach($id_com,[
                        'id_paa'=>$id_paa2,
                        'valor'=>$obj->valor,
                        'fuente_id'=>$obj->id_Proyecto,
                        'proyecto_id'=>$input['Proyecto_inversion'],
                        'estado'=>1,
                        'id_fk_meta'=>$obj->id_meta,
                    ]);
                }
            }

            $data_r = json_decode($input['Dato_Actividad_Acti_rubro']);
            if($data_r){
                if($data_r[0] != null){
                    foreach($data_r as $obj){
                        $modeloPA->rubro_funcionamiento()->attach($obj->id_rubro,[
                            'paa_id'=>$id_paa2, 'valor'=>str_replace('.','',$obj->valor_rubro)
                        ]);
                    }
                }
            }

          


        }
        else
        {
            $ModiRegi=1;
            $id_paa2=$model->Id;//Paa que estan modificando

            $modeloPA_m = Paa::find($id_paa2);
            $modeloPA_m['CodigosU'] = $cod;
            $modeloPA_m['Id_ModalidadSeleccion'] = $input['modalidad_seleccion'];
            $modeloPA_m['Id_TipoContrato'] = $input['tipo_contrato'];
            $modeloPA_m['ObjetoContractual'] = $input['objeto_contrato'];
            $modeloPA_m['FuenteRecurso'] = $input['fuente_recurso'];
            $modeloPA_m['ValorEstimado'] = str_replace('.','',$input['valor_estimado']);
            $modeloPA_m['ValorEstimadoVigencia'] = str_replace('.','',$input['valor_estimado_actualVigencia']);
            $modeloPA_m['VigenciaFutura'] = $input['vigencias_futuras'];
            $modeloPA_m['EstadoVigenciaFutura'] = $input['estado_solicitud'];
            $modeloPA_m['FechaEstudioConveniencia'] = $input['estudio_conveniencia'];
            $modeloPA_m['FechaInicioProceso'] = $input['fecha_inicio'];
            $modeloPA_m['FechaSuscripcionContrato'] = $input['fecha_suscripcion'];
            $modeloPA_m['DuracionContrato'] = $input['duracion_estimada'];
            $modeloPA_m['MetaPlan'] = $input['meta'];
            $modeloPA_m['RecursoHumano'] = $input['recurso_humano'];
            $modeloPA_m['NumeroContratista'] = $input['numero_contratista'];
            $modeloPA_m['DatosResponsable'] = $input['datos_contacto'];
            $modeloPA_m['Id_Proyecto'] = $Id_Proyecto;
            $modeloPA_m['Id_Rubro'] = $Id_Rubro;
            $modeloPA_m['Proyecto1Rubro2'] = $input['ProyectOrubro'];
            $modeloPA_m['IdPersona'] = $_SESSION['Id_Persona'];
            $modeloPA_m['Id_Area'] = $personapaa['id_area'];
            $modeloPA_m['unidad_tiempo'] = $input['unidad_tiempo'];
            $modeloPA_m->save();


            $id_paa=$modeloPA->Id;//Nuevo registro

            $modeloP = Paa::find($id_paa);
            $modeloP['Registro'] = $model->Registro;
            //$modeloP['Observacion'] =$id_paa2;

            $modeloultimo = Paa::where('Registro','=',$model->Registro)->orderby('created_at','DESC')->take(2)->get();
            
            $modeloP['Id_paa'] = $modeloultimo[1]['Id'];
            $modeloP->save();
            $id_reg_def=$model->Id;
            $id_area_def=$model->Id_Area;

                if($model['compartida']==1){

                    $paa_vinculadas = Paa::where('vinculada',$model['Id'])->get();

                    foreach ($paa_vinculadas as &$paa_vinculada) 
                    {
                        $modeloVinculado =  Paa::find($paa_vinculada['Id']);
                        $modeloVinculado['CodigosU'] = $cod;
                        $modeloVinculado['Id_ModalidadSeleccion'] = $input['modalidad_seleccion'];
                        $modeloVinculado['Id_TipoContrato'] = $input['tipo_contrato'];
                        $modeloVinculado['ObjetoContractual'] = $input['objeto_contrato'];
                        $modeloVinculado['FuenteRecurso'] = $input['fuente_recurso'];
                        $modeloVinculado['ValorEstimado'] = str_replace('.','',$input['valor_estimado']);
                        $modeloVinculado['ValorEstimadoVigencia'] = str_replace('.','',$input['valor_estimado_actualVigencia']);
                        $modeloVinculado['VigenciaFutura'] = $input['vigencias_futuras'];
                        $modeloVinculado['EstadoVigenciaFutura'] = $input['estado_solicitud'];
                        $modeloVinculado['FechaEstudioConveniencia'] = $input['estudio_conveniencia'];
                        $modeloVinculado['FechaInicioProceso'] = $input['fecha_inicio'];
                        $modeloVinculado['FechaSuscripcionContrato'] = $input['fecha_suscripcion'];
                        $modeloVinculado['DuracionContrato'] = $input['duracion_estimada'];
                        $modeloVinculado['MetaPlan'] = $input['meta'];
                        $modeloVinculado['RecursoHumano'] = $input['recurso_humano'];
                        $modeloVinculado['NumeroContratista'] = $input['numero_contratista'];
                        $modeloVinculado['DatosResponsable'] = $input['datos_contacto'];
                        $modeloVinculado['Id_Proyecto'] = $Id_Proyecto;
                        $modeloVinculado['Id_Rubro'] = $Id_Rubro;
                        $modeloVinculado['Proyecto1Rubro2'] = $input['ProyectOrubro'];
                        $modeloVinculado['unidad_tiempo'] = $input['unidad_tiempo'];
                        $modeloVinculado->save();
                    }

                }

        }



        if($ModiRegi==0)
            $mensaje="PAA ID. ".$id_reg_def.": Registro Exitoso";
        else
            $mensaje="PAA ID. ".$id_reg_def.": Modificación Exitosa";
       

        $personapaa = PersonaPaa::find($_SESSION['Id_Persona']);
        
        
        $paa = Paa::with('modalidad','tipocontrato','rubro_funcionamiento','proyecto','meta','componentes','persona')->where('Id_Area',$personapaa['id_area'])->whereIn('Estado',['0','4','5','6','7','8','9','10','11'])->get();
        $persona = $this->repositorio_personas->obtener($_SESSION['Id_Persona']);
        $area=Area::find($id_area_def);

        

        $personapaas = PersonaPaa::where('id_area',$id_area_def)->get();
        $pila = array();
        foreach ($personapaas as &$personapaa) 
        {
            array_push($pila, $personapaa['id']);
        }

        $id_Tipos=[62]; //Reviar por q me trea todos y no solo los 62
      
        $ModeloPersona = Persona::whereHas('tipo', function ($query) use ($id_Tipos) {
            $query->whereIn('persona_tipo.Id_Tipo',$id_Tipos);
        })->whereIn('Id_Persona',$pila)->get();

         

        $Consolidadore = array();
        foreach ($ModeloPersona as &$Mpersonapaa) 
        {
            array_push($Consolidadore, $Mpersonapaa['Id_Persona']);
        }
        

        $emails = array();
        $DatosEmail = Datos::whereIn('Id_Persona',$Consolidadore)->get();
        foreach ($DatosEmail as &$DatoEmail) 
        {
            if($DatoEmail)
            {
                array_push($emails, $DatoEmail['Email']);
            }
        }

     
        if(!empty($emails))
        {
            Mail::send('mail', ['mensaje'=>$mensaje,'persona'=>$persona,'area'=>$area,'objeto'=>$objeto_contrato], function ($m) use ($paa,$mensaje,$emails)  {
                $m->from('mails@idrd.gov.co', $mensaje);

                $m->to($emails, 'Estevenhr')->subject($mensaje."!");
            });
        }

        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function fuenteComponente(Request $request)
    {
        $fuenteProyecto=$request['fuenteProyecto'];
        $presupuestado= Presupuestado::with('componente')->where('fuente_proyecto_id',$fuenteProyecto)->get();
        return response()->json($presupuestado);
    }

    public function PresupuestoComponente(Request $request)
    {
        $id_presupuestado=$request['id_presupuestado'];
        $presupuestado= Presupuestado::find($id_presupuestado);
        $id_c=$presupuestado['componente_id'];
        $id_f_p=$presupuestado['fuente_proyecto_id'];

        $ModeloPa = Paa::with(['componentes' => function($query) use ($id_c,$id_f_p)
        {
            $query->where('componente_id',$id_c)->where('fuente_id',$id_f_p)->whereNull('actividadComponente.deleted_at');
        }])->where('Estado','9')->get();

        $ModeloPa2 = Paa::with(['componentes' => function($query) use ($id_c,$id_f_p)
        {
            $query->where('componente_id',$id_c)->where('fuente_id',$id_f_p)->whereNull('actividadComponente.deleted_at');
        }])->whereIn('Estado',[0,4,5,8,10,6])->get();
        //dd($ModeloPa2->count());
        $ModeloCompoente=Componente::find($id_c);
        return response()->json(array('ModeloPa' => $ModeloPa,'ModeloPaPendi'=>$ModeloPa2, 'ModeloCompoente' => $ModeloCompoente,'presupuestado'=>$presupuestado));
    }

    public function select_area(Request $request, $id)
    {
        $areas = RubroFuncionamiento::with('areas')->find($id);
        return response()->json($areas);
    }

    public function selectActividadesRubro(Request $request, $id)
    {
        $rubroFuncionamiento = RubroFuncionamiento::with('actividadesfuncionamiento')->find($id);
        return response()->json($rubroFuncionamiento);
    }

    public function selectMetasProyecto(Request $request)
    {

        $actividadcomponente = ActividadComponente::with('meta')->find($request['id_ac']);
        return response()->json($actividadcomponente);
    }

    public function selectRubrosIngresados(Request $request)
    {
        $idRubro=$request['id_rubro'];
        $paa = Paa::with('rubro_funcionamiento')->whereHas('rubro_funcionamiento', function($query) use ($idRubro) {
            $query->where('rubro_id',$idRubro);
        })->find($request['id_paa']);
        return response()->json($paa);
    }

    public function selecActivMeta(Request $request)
    {
        
        $meta = Meta::with('actividades')->find($request['id_meta']);
        
        $actividadcomponente = ActividadComponente::with('componente')->find($request['id']);
        
        $data=[
        'metas'=>$meta,
        'Componentes'=>$actividadcomponente,
        ];

        return response()->json($data);
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
        $proyecto1 = Proyecto::all();
        $proyecto2 = Proyecto::with('metas')->find($id);
        return response()->json(array('proyecto' =>$proyecto1,'proyectometas'=>$proyecto2 ));
    }


    public function select_rubro(Request $request, $id)
    {
        $RubroFuncionamiento = RubroFuncionamiento::find($id);
        return response()->json($RubroFuncionamiento);
    }

    public function select_meta_fuente(Request $request, $id)
    {
        $FuenteProyecto = FuenteProyecto::with('fuente')->where('proyecto_id',$id)->get();
        $proyecto = Proyecto::with('metas')->find($id);
        return response()->json(array('Proyecto'=>$proyecto,'FuenteProyecto'=>$FuenteProyecto));
    }

    public function select_ProyectOrubro(Request $request, $id)
    {
        if($id==1){ //Proyecto

            $personapaa = PersonaPaa::find($_SESSION['Id_Persona']);
            $subdirecion=Area::with('subdirecion')->find($personapaa['id_area']);
                 
            $grupovigencia[]="";
            $grupovigencia_paso=1;
            $presupuesto = Presupuesto::where('vigencia',Estado::VIGENCIA)->get();
                foreach($presupuesto as $eee){
                  if($eee!=''){
                       if($eee['Id']!=''){
                            if($grupovigencia_paso==1){
                                $grupovigencia[]=$eee['Id'];
                            }
                            else{
                                $grupovigencia[]=$grupovigencia +","+ $eee['Id'];
                            }

                       }
                  }
                }
            $proyecto = Proyecto::whereIn('Id_Presupuesto',$grupovigencia)->where('id_subdireccion',$subdirecion['id_subdireccion'])->get();
            return response()->json($proyecto);
        }
        
        if($id==2){//Rubro
            $rubro = RubroFuncionamiento::all();
            return response()->json($rubro);
        }
    }

    public function verFinanciacion(Request $request, $id)
    {
        
        $personapaa = PersonaPaa::find($_SESSION['Id_Persona']);
        $subdirecion=Area::with('subdirecion')->find($personapaa['id_area']);

        $ActividadComponente = ActividadComponente::with('proyecto','fuenteproyecto','fuenteproyecto.fuente','fuenteproyecto.proyecto','componente','meta')->where('id_paa',$id)->get();


        $model_A = Paa::with('componentes','componentes.fuente','rubro_funcionamiento')->find($id);
        

        $RubroFuncionamiento = RubroFuncionamiento::find($model_A['Id_Rubro']);
        $RubroFuncionamiento1 = RubroFuncionamiento::all();

        //exit();

        $grupovigencia[]="";
            $grupovigencia_paso=1;
            $presupuesto = Presupuesto::where('vigencia',Estado::VIGENCIA)->get();
                foreach($presupuesto as $eee){
                  if($eee!=''){
                       if($eee['Id']!=''){
                            if($grupovigencia_paso==1){
                                $grupovigencia[]=$eee['Id'];
                            }
                            else{
                                $grupovigencia[]=$grupovigencia +","+ $eee['Id'];
                            }

                       }
                  }
                }
            $proyectos = Proyecto::whereIn('Id_Presupuesto',$grupovigencia)->where('id_subdireccion',$subdirecion['id_subdireccion'])->get();

        if($ActividadComponente->count()>0){
        
            $Proyecto = Proyecto::with('fuente')->find($ActividadComponente[0]->proyecto['Id']);
        }else{
         
            $Proyecto = Proyecto::with('fuente')->where('id_subdireccion',$subdirecion['id_subdireccion'])->get();
        }
        return response()->json(array('estado' => $model_A['Estado'],'proyecto'=>$Proyecto,'proyectos'=>$proyectos, 'ActividadComponente'=>$ActividadComponente,'Rubro'=>$RubroFuncionamiento,'Modelo'=>$model_A, 'rubros_all'=>$RubroFuncionamiento1) );
    }

    public function EliminarFinanciamiento(Request $request)
    {

        $id=$request['id'];
        $id_eli=$request['id_eli'];

        $ActividadComponente1 = ActividadComponente::find($id_eli);
        $ActividadComponente1->delete();

        $ActividadComponente = ActividadComponente::with('proyecto','fuenteproyecto','fuenteproyecto.fuente','componente','meta')->where('id_paa',$id)->get();

        $paa = Paa::find($id);
        //  $paa->componentes()->detach($request['id_eli']);
        //$paa->componentes()->newPivotStatementForId($request['id_eli'])->whereid($request['id_key'])->delete();
        //$model_A = Paa::with('componentes','componentes.fuente')->find($id);
        return response()->json(array('ActividadComponente'=>$ActividadComponente, 'paa'=>$paa));
    }

    public function EliminarFinanciamientoRubro(Request $request)
    {

        $id=$request['id'];
        $id_pivot=$request['id_eli'];

        $Paa = Paa::find($id);
        $Paa->rubro_funcionamiento()->detach($id_pivot);

        $paa_data = Paa::with('componentes','componentes.fuente','rubro_funcionamiento')->find($id);
        return response()->json(array('Modelo'=>$paa_data));
    }

    public function agregar_finza(Request $request)
    {   
        $validator = Validator::make($request->all(),
            [
                'valor_contrato' =>'required',
                'Proyecto_Finanza' =>'required',
                'Meta_Finanza' =>'required',
                'Fuente_Finanza' =>'required',
                'Componnente_Finanza' =>'required',
            ]
        );

        if ($validator->fails())
        return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        $id=$request['id_act_agre'];
        $proyecto_Finanza=$request['Proyecto_Finanza'];
        $meta_Finanza=$request['Meta_Finanza'];
        $id_componente=$request['Componnente_Finanza'];
        $Fuente_inversion=$request['Fuente_Finanza'];
        $valor=str_replace('.','',$request['valor_contrato']);

        $ModeloCompoente=Presupuestado::find($id_componente);
        $compo_id=$ModeloCompoente['componente_id'];

        $FuenteProyecto=FuenteProyecto::find($Fuente_inversion);
        
        $ModeloPa = Paa::with(['componentes' => function($query) use ($compo_id,$Fuente_inversion)
        {
            $query->where('componente_id',$compo_id)->where('fuente_id',$Fuente_inversion)->get();
        }])->where('Estado','9')->get();
            
        $suma_aprobado=0;
        $valorCocenpto=0;
        $suma_por_aprobar=0;

        foreach($ModeloPa as $eee){
          if($eee->componentes!=''){
            foreach($eee->componentes as $eeee){
               if($eeee->pivot['valor']!=''){
                   $suma_aprobado=$suma_aprobado + $eeee->pivot['valor'];
               }
            }
          }
        }
        $valorCocenpto=$ModeloCompoente['valor'];

        $ModeloAprobado = Paa::with(['componentes' => function($query) use ($compo_id,$Fuente_inversion)
        {
            $query->where('componente_id',$compo_id)->where('fuente_id',$Fuente_inversion)->wherePivot('deleted_at',NULL)->get();
        }])->find($id);
        
        if($ModeloAprobado!=''){
            foreach($ModeloAprobado->componentes as $componente){
               if($componente->pivot['valor']!=''){
                   $suma_por_aprobar=$suma_por_aprobar + $componente->pivot['valor'];
               }
            }
        }
         
        $valor2=$valor+$suma_por_aprobar;
        $valorAfavor=$valorCocenpto-$suma_aprobado;
        $estado="";
        //echo $ModeloCompoente['valor']."   -   ".$suma_aprobado." - ".$valor2." - ".$suma_por_aprobar."<br>";
        //echo $valorAfavor." - ".$valor2." - ".$id_componente."<br>";
        
        if($valorAfavor>=$valor2){
            $paa = Paa::find($id);
            $paa->componentes()->attach($compo_id,[
                        'valor'=>$valor,
                        'fuente_id'=>$Fuente_inversion,
                        'proyecto_id'=>$FuenteProyecto['proyecto_id'],
                        'estado'=>1,
                        'id_fk_meta'=>$meta_Finanza,
                    ]);
            $estado="1";
        }else{
            $estado="0";
        }
       
        $ActividadComponente = ActividadComponente::with('proyecto','fuenteproyecto','fuenteproyecto.fuente','componente','meta')->where('id_paa',$id)->get();
        return response()->json(array('status' => $estado, 'errors' => $validator->errors(),'ActividadComponente'=>$ActividadComponente));
    }

    public function agregar_rubro(Request $request)
    {   
        $validator = Validator::make($request->all(),
            [
                'Fuente_funcionamiento' =>'required',
                'valor_contrato' =>'required',
            ]
        );

        if ($validator->fails())
        return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        $id=$request['id_act_agre2'];
        $paa = Paa::find($id);                 
        $paa->rubro_funcionamiento()->attach($request['Fuente_funcionamiento'],['valor'=>str_replace('.','',$request['valor_contrato'])]);

        $paa_data = Paa::with('componentes','componentes.fuente','rubro_funcionamiento')->find($id);
        return response()->json(array('Modelo'=>$paa_data));        
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
        $paa = Paa::with('actividadesFuncionamiento')->find($id);

        $texta_Conveniencia=$request['texta_Conveniencia'];
        $texta_Oportunidad=$request['texta_Oportunidad'];
        $texta_Justificacion=$request['texta_Justificacion'];

        $data0 = json_decode($request['campos_Clasi_Finan']);
            

        // Registro de proyecto de inversión
            $finanzas = ActividadComponente::with('actividades')->where('id_paa',$id)->get();

            foreach ($finanzas as $finanza) {
                foreach ($finanza->actividades as &$actividad) {
                    $actividad->pivot['estado']=1;
                    $actividad->pivot->save();
                }
            }

            foreach($data0 as $obj){
                if($obj->tipo==1){
                    //var_dump($obj->componente);
                    $modeloAct = ActividadComponente::find($obj->id_act_com);
                    if($modeloAct)
                    $modeloAct->actividades()->detach();
                }
            }
            foreach($data0 as $obj){
                if($obj->tipo==1){
                    $modeloAct = ActividadComponente::find($obj->id_act_com);
                    $modeloAct->actividades()->attach($obj->actividad_ingre,[
                        'componeActiv_id'=>$obj->id_act_com,
                        'valor'=>$obj->valor_componente,
                        'estado'=>0,
                        'fuentehacienda'=>$obj->Fuente_ingre,
                        'porcentaje'=>$obj->porcentaje,
                        'valor'=>$obj->valor_componente,
                        'total'=>$obj->valor_total_ingr,
                    ]);
                }
            }
        

        // Registro de rubro de funcionamiento
            if($paa->actividadesFuncionamiento){
                foreach ($paa->actividadesFuncionamiento as &$actividad) {
                    $actividad->pivot['estado']=1;
                    $actividad->pivot->save();
                }
            }
            


            $paas = Paa::find($id);
            foreach($data0 as $obj){
                if($obj->tipo==2){
                    $paas->actividadesFuncionamiento()->attach($obj->Id_P_R,[
                        'valor'=>$obj->valor_componente,
                        'estado'=>0,
                        'fuentehacienda'=>$obj->Fuente_ingre,
                        'porcentaje'=>100,
                        'valor'=>$obj->valor_componente,
                        'total'=>$obj->valor_total_ingr,
                    ]);
                }
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
        

        $id_Tipos=[63]; //Tipo sibdirector
        
        $subdirecion=Area::with('subdirecion')->find($model_A['Id_Area']);
        $objeto=$model_A['ObjetoContractual'];
        $areas=Area::where('id_subdireccion',$subdirecion['id_subdireccion'])->get();
        $array_areas = array();
        foreach ($areas as &$area_) 
        {
            array_push($array_areas, $area_['id']);
        }

        $personapaas = PersonaPaa::whereIn('id_area',$array_areas)->get();
        $pila = array();
        foreach ($personapaas as &$personapaa) 
        {
            array_push($pila, $personapaa['id']);
        }

        $ModeloPersona = Persona::whereHas('tipo', function ($query) use ($id_Tipos) {
            $query->whereIn('persona_tipo.Id_Tipo',$id_Tipos);
        })->whereIn('Id_Persona',$pila)->get();

         

        $Consolidadore = array();
        foreach ($ModeloPersona as &$Mpersonapaa) 
        {
            array_push($Consolidadore, $Mpersonapaa['Id_Persona']);
        }
        

        $emails = array();
        $DatosEmail = Datos::whereIn('Id_Persona',$Consolidadore)->get();
        foreach ($DatosEmail as &$DatoEmail) 
        {
            if($DatoEmail){
                array_push($emails, $DatoEmail['Email']);
            }
        }
        
        $id_persona=$_SESSION['Id_Persona'];
        $persona = $this->repositorio_personas->obtener($id_persona);
        $area=Area::find($model_A['Id_Area']);

        $mensaje="PAA ID. ".$id.": Estudio de conveniencia registrado";
       
        if(!empty($emails))
        {
            //dd($emails);
            Mail::send('mail', ['mensaje'=>$mensaje,'persona'=>$persona,'area'=>$area,'objeto'=>$objeto], function ($m) use ($paa,$mensaje,$emails)  {
                $m->from('no-reply_Paa@idrd.gov.co', $mensaje);

                $m->to($emails, 'Estevenhr')->subject($mensaje."!");
            });
        }

        $model_A['Estado']=8;
        $model_A->save();
        return response()->json($model_A->componentes);
    }

    public function obtenerPaa(Request $request, $id)
    {
        $model_A = Paa::with('rubro','proyecto')->find($id);
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
        
        $paa = Paa::with('modalidad','tipocontrato','meta.actividades','area','componentes','rubro_funcionamiento','rubro_funcionamiento.actividadesfuncionamiento')->find($id);

            $finanzas_p = ActividadComponente::with('actividades','proyecto','meta','fuenteproyecto','fuenteproyecto.fuente','fuenteproyecto.proyecto')->where('id_paa',$id)->get();
            if($finanzas_p){
                foreach ($finanzas_p as $finanza) 
                {
                        $finanza->Componente = Componente::find($finanza['componente_id']);
                    foreach ($finanza->actividades as &$actividad)
                    {
                        $actividad->Actividad = Actividad::find($actividad->pivot['actividad_id']);
                        $actividad->Fuente = FuenteHacienda::find($actividad->pivot['fuentehacienda']);
                    }
                }
            }
        
            $finanzas_r = Paa::with('actividadesFuncionamiento','actividadesFuncionamiento')->find($id);
            if($finanzas_r){
                foreach ($finanzas_r->actividadesFuncionamiento as &$actividad)
                {
                    $actividad->Actividad = ActividadFuncionamiento::find($actividad->pivot['actividad_f_id']);
                    $actividad->Fuente = FuenteHacienda::find($actividad->pivot['fuentehacienda']);
                }
            }
        

        if($paa['vinculada']!=""){
            $EstudioConveniencias =  EstudioConveniencia::find($paa['vinculada']);
            $vinculada=0;
        }else{
            $EstudioConveniencias =  EstudioConveniencia::find($id);
            $vinculada=1;
        }

        $datos = [        
            'EstudioConveniencias' => $EstudioConveniencias,
            'paas' => $paa,
            'finanzas_p' =>$finanzas_p,
            'finanzas_r' =>$finanzas_r,
            'vinculada' =>$vinculada
        ];
        return response()->json($datos);
    }

    public function obtenerHistorialPaa(Request $request, $id)
    {
        $model_A = Paa::with('modalidad','tipocontrato','meta','proyecto','cambiosPaa','rubro_funcionamiento')->whereDoesnthave('cambiosPaa')->where('Registro', '=', $id)->get();
        return response()->json($model_A);
    }

    public function obtenerHistorialPaaTodo(Request $request, $id)
    {
        $model_A = Paa::with('modalidad','tipocontrato','cambiosPaa','meta','proyecto','rubro_funcionamiento')->where('Registro', '=', $id)->get();
        return response()->json($model_A);
    }
   

    public function EliminarPaa(Request $request, $id)
    {
        $modeloPA = Paa::find($id);
        $modeloPA['Estado'] = 3;
        $modeloPA['EsatdoObservo'] = 3;
        $modeloPA->save();

        $personapaa = PersonaPaa::find($_SESSION['Id_Persona']);

        $paa = Paa::with('modalidad','tipocontrato','rubro','proyecto','meta','persona')->where('Id_Area',$personapaa['id_area'])->whereIn('Estado',['0','4','5','6','7','8','9','10','11'])->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function HistorialEliminarPaa(Request $request, $id)
    {
        $paa = Paa::with('modalidad','tipocontrato','rubro_funcionamiento','proyecto','meta')->where('IdPersona',$_SESSION['Id_Persona'])->where('Estado','3')->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function HistorialEliminarPaaEspecifico(Request $request, $id)
    {
        $paa = Paa::with('modalidad','tipocontrato','rubro_funcionamiento','proyecto','meta')->where('IdPersona',$_SESSION['Id_Persona'])->where('Estado','0')->where('EsatdoObservo','0')->find(41);
        $paas = Paa::with('modalidad','tipocontrato','rubro','proyecto','meta')->where('IdPersona',$_SESSION['Id_Persona'])->where('Registro',41)->where('Estado','1')->get();
        foreach ($paas as &$temp) 
        {
            $temp->cambios = Comparador::comparar($temp->toArray(), $paa->toArray());
        }

        //dd($paas);
        return response()->json(array('status' => 'modelo', 'datos' => $paa));
    }

    public function historialObservaciones(Request $request, $id)
    {
        $model_A = Observacion::with('persona')->where('id_registro',$id)->get();
   
        foreach ($model_A as $key) {
            $modeloOb = Observacion::find($key['id']);
            $modeloOb['check']=1;
            $modeloOb->save();
        }
        
        return response()->json($model_A);
    }

    public function RegistrarObservacion(Request $request)
    {
        $id_persona=$_SESSION['Id_Persona'];
        $persona = $this->repositorio_personas->obtener($id_persona);
        $paa=Paa::find($request['id']);
        $area=Area::find($paa['Id_Area']);
        $personapaas = PersonaPaa::where('id_area',$paa['Id_Area'])->get();
        $pila = array();
        foreach ($personapaas as &$personapaa) 
        {
            array_push($pila, $personapaa['id']);
        }

        $id_Tipos=[62]; //Reviar por q me trea todos y no solo los 62
      
        $ModeloPersona = Persona::whereHas('tipo', function ($query) use ($id_Tipos) {
            $query->whereIn('persona_tipo.Id_Tipo',$id_Tipos);
        })->whereIn('Id_Persona',$pila)->get();

         

        $Consolidadore = array();
        foreach ($ModeloPersona as &$Mpersonapaa) 
        {
            array_push($Consolidadore, $Mpersonapaa['Id_Persona']);
        }
        

        $emails = array();
        $DatosEmail = Datos::whereIn('Id_Persona',$Consolidadore)->get();
        foreach ($DatosEmail as &$DatoEmail) 
        {
            if($DatoEmail){
                array_push($emails, $DatoEmail['Email']);
            }
        }

        $mensaje="PAA ID. ".$request['id'].": Observación";
        
        if(!empty($emails))
        {
            //dd($emails);
            Mail::send('mail', ['mensaje'=>$request['observacion'],'persona'=>$persona,'area'=>$area, 'objeto'=>$paa['ObjetoContractual']], function ($m) use ($paa,$mensaje,$emails)  {
                $m->from('no-reply_Paa@idrd.gov.co', $mensaje);
                $m->to($emails, 'Estevenhr')->subject($mensaje."!");
            });
        }

        $modeloObserva = new Observacion;
        $modeloObserva['id_persona'] = $id_persona;
        $modeloObserva['id_registro'] = $request['id'];
        $modeloObserva['estado'] = $request['Estado'];
        $modeloObserva['check']=1;
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
