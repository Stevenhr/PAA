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

class PaaCompartidoController extends Controller
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



        $paa = Paa::with(['modalidad','tipocontrato','rubro','area','proyecto','meta','persona','rubro_funcionamiento','componentes' =>     function($query)
            {
               $query->with('actividadescomponetes.fuenteproyecto.fuente','actividadescomponetes.fuenteproyecto.proyecto');
            }])
            ->whereIn('Estado',['0','4','5','6','7','8','9','10','11'])
            ->where('Compartida',1)
            ->orderby('Id','desc')
            ->get();

        //dd($paa[0]->componentes[0]->actividadescomponetes);
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
        //dd($paa);
        //exit();
		return view('paaCompratida',$datos);
	}

    public function verFinanciacion(Request $request, $id)
    {
        
        $personapaa = PersonaPaa::find($_SESSION['Id_Persona']);
        $subdirecion=Area::with('subdirecion')->find($personapaa['id_area']);

        $ActividadComponente = ActividadComponente::with('proyecto','fuenteproyecto','fuenteproyecto.fuente','fuenteproyecto.proyecto','componente','meta')->where('id_paa',$id)->get();

        $model_A = Paa::with('componentes','componentes.fuente','rubro_funcionamiento')->find($id);
        
        $RubroFuncionamiento = RubroFuncionamiento::find($model_A['Id_Rubro']);
        $RubroFuncionamiento1 = RubroFuncionamiento::all();

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
        //dd($ModeloCompoente['valor']."   -   ".$suma_aprobado." - ".$valor2." - ".$valorAfavor);
        //echo $valorAfavor." - ".$valor."";
        if($valorAfavor>=$valor2){
            $estado="1";
        }else{
            $estado="0";
        }
       
        return response()->json(array('status' => $estado));
    }

    public function agregar_rubro(Request $request)
    {   
        $validator = Validator::make($request->all(),
            [
                'Fuente_funcionamiento' =>'required',
                'valor_contrato_rubro' =>'required',
            ]
        );

        if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        else    
            return response()->json(array('status' => 'ok'));   
    }


    public function crear_paa_compartido(Request $request)
    {

        if (!isset($_SESSION['Id_Persona']))
            return redirect()->away('http://www.idrd.gov.co/SIM/Presentacion/');

        $personapaa = PersonaPaa::find($_SESSION['Id_Persona']);
        $Modifica=0;
        $id_paa=$request["id_estudio3"];
        $paaRequest = Paa::find($id_paa);
        
        $modeloPA = new Paa;
        $modeloPA['Id_paa'] = 0;
        $modeloPA['Registro'] = $paaRequest['Registro'];
        $modeloPA['CodigosU'] = $paaRequest['CodigosU'];
        $modeloPA['Id_ModalidadSeleccion'] = $paaRequest['Id_ModalidadSeleccion'];
        $modeloPA['Id_TipoContrato'] = $paaRequest['Id_TipoContrato'];
        $modeloPA['ObjetoContractual'] = $paaRequest['ObjetoContractual'];
        $modeloPA['FuenteRecurso'] = $paaRequest['FuenteRecurso'];
        $modeloPA['ValorEstimado'] = $paaRequest['ValorEstimado'];
        $modeloPA['ValorEstimadoVigencia'] = $paaRequest['ValorEstimadoVigencia'];
        $modeloPA['VigenciaFutura'] = $paaRequest['VigenciaFutura'];
        $modeloPA['EstadoVigenciaFutura'] = $paaRequest['EstadoVigenciaFutura'];
        $modeloPA['FechaEstudioConveniencia'] = $paaRequest['FechaEstudioConveniencia'];
        $modeloPA['FechaInicioProceso'] = $paaRequest['FechaInicioProceso'];
        $modeloPA['FechaSuscripcionContrato'] = $paaRequest['FechaSuscripcionContrato'];
        $modeloPA['DuracionContrato'] = $paaRequest['DuracionContrato'];
        $modeloPA['MetaPlan'] = $paaRequest['MetaPlan'];
        $modeloPA['RecursoHumano'] = $paaRequest['RecursoHumano'];
        $modeloPA['NumeroContratista'] = $paaRequest['NumeroContratista'];
        $modeloPA['DatosResponsable'] = $paaRequest['DatosResponsable'];
        $modeloPA['Id_Proyecto'] = $paaRequest['Id_Proyecto'];
        $modeloPA['Id_Rubro'] = $paaRequest['Id_Rubro'];
        $modeloPA['Proyecto1Rubro2'] = $paaRequest['Proyecto1Rubro2'];
        $modeloPA['IdPersona'] = $_SESSION['Id_Persona'];
        $modeloPA['Estado'] = 0;
        $modeloPA['IdPersonaObservo'] = '';
        $modeloPA['EsatdoObservo'] = 0;
        $modeloPA['Observacion'] = '';
        $modeloPA['Id_Area'] = $personapaa['id_area'];
        $modeloPA['unidad_tiempo'] = $paaRequest['unidad_tiempo'];
        $modeloPA['vinculada'] = $paaRequest['Id'];
        $modeloPA->save();
        
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
            $modeloPA['Registro'] = $paaRequest['Registro'];
            $modeloPA['CodigosU'] = $paaRequest['CodigosU'];
            $modeloPA['Id_ModalidadSeleccion'] = $paaRequest['Id_ModalidadSeleccion'];
            $modeloPA['Id_TipoContrato'] = $paaRequest['Id_TipoContrato'];
            $modeloPA['ObjetoContractual'] = $paaRequest['ObjetoContractual'];
            $modeloPA['FuenteRecurso'] = $paaRequest['FuenteRecurso'];
            $modeloPA['ValorEstimado'] = $paaRequest['ValorEstimado'];
            $modeloPA['ValorEstimadoVigencia'] = $paaRequest['ValorEstimadoVigencia'];
            $modeloPA['VigenciaFutura'] = $paaRequest['VigenciaFutura'];
            $modeloPA['EstadoVigenciaFutura'] = $paaRequest['EstadoVigenciaFutura'];
            $modeloPA['FechaEstudioConveniencia'] = $paaRequest['FechaEstudioConveniencia'];
            $modeloPA['FechaInicioProceso'] = $paaRequest['FechaInicioProceso'];
            $modeloPA['FechaSuscripcionContrato'] = $paaRequest['FechaSuscripcionContrato'];
            $modeloPA['DuracionContrato'] = $paaRequest['DuracionContrato'];
            $modeloPA['MetaPlan'] = $paaRequest['MetaPlan'];
            $modeloPA['RecursoHumano'] = $paaRequest['RecursoHumano'];
            $modeloPA['NumeroContratista'] = $paaRequest['NumeroContratista'];
            $modeloPA['DatosResponsable'] = $paaRequest['DatosResponsable'];
            $modeloPA['Id_Proyecto'] = $paaRequest['Id_Proyecto'];
            $modeloPA['Id_Rubro'] = $paaRequest['Id_Rubro'];
            $modeloPA['Proyecto1Rubro2'] = $paaRequest['Proyecto1Rubro2'];
            $modeloPA['IdPersona'] = $_SESSION['Id_Persona'];
            $modeloPA['Estado'] = 2;
            $modeloPA['IdPersonaObservo'] = '';
            $modeloPA['EsatdoObservo'] = 2;
            $modeloPA['Observacion'] = '';
            $modeloPA['Id_Area'] = $personapaa['id_area'];
            $modeloPA['unidad_tiempo'] = $paaRequest['unidad_tiempo'];
            $modeloPA['vinculada'] = $paaRequest['Id'];
            $modeloPA->save();

            $id_paa=$modeloPA->Id;
            $modeloP = Paa::find($id_paa);
            $modeloP['Id_paa'] = $id_paa2;
            $modeloP['Registro'] = $id_paa2;
            $id_reg_def=$id_paa2;
            $modeloP->save();

            $data0 = json_decode($request['datos_vector_financiacion']);
            if($data0){
                foreach($data0 as $obj){
                    $presupuestado= Presupuestado::find($obj->id_componnente_Finanza);
                    $id_com=$presupuestado['componente_id'];
                    $modeloPA->componentes()->attach($id_com,[
                        'id_paa'=>$id_paa2,
                        'valor'=>str_replace('.','',$obj->valor_contrato),
                        'fuente_id'=>$obj->id_fuente_Finanza,
                        'proyecto_id'=>$paaRequest['Id_Proyecto'],
                        'estado'=>1,
                        'id_fk_meta'=>$obj->id_meta_Finanza,
                    ]);
                }
            }

            $data_r = json_decode($request['datos_vector_financiacion_rubro']);
            if($data_r){
                if($data_r[0] != null){
                    foreach($data_r as $obj){
                        $modeloPA->rubro_funcionamiento()->attach($obj->id_fuente_funcionamiento,[
                            'paa_id'=>$id_paa2, 'valor'=>str_replace('.','',$obj->valor_contrato_rubro)
                        ]);
                    }
                }
            }

        }

        return response()->json(array('status' => 'ok'));

    }

}