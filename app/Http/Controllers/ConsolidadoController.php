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
use App\Observacion;
use App\PersonaPaa;
use App\SubDireccion;
use PDF;
use Mail;
use Idrd\Usuarios\Repo\PersonaInterface;
use App\Area;
use App\Persona;
use App\Datos;

class ConsolidadoController extends Controller
{
    //
    protected $repositorio_personas;

    public function __construct(PersonaInterface $repositorio_personas)
    {
        $this->repositorio_personas = $repositorio_personas;
    }
    public function index()
	{
		$modalidadSeleccion = ModalidadSeleccion::all();
		$proyecto = Proyecto::all();
		$tipoContrato = TipoContrato::all();
		$componente = Componente::all();
    $fuente = Fuente::all();
       
        $PersonaPaa = PersonaPaa::with('area')->where('id',$_SESSION['Id_Persona'])->get();
        $idSub=$PersonaPaa[0]->area['id_subdireccion'];
        
        $arreglo1 = array();
        $PaaSubDireccion= SubDireccion::with('areas')->find($idSub);
        foreach ($PaaSubDireccion->areas as $value) {
          $arreglo1[]=$value['id'];
        }

        $paa = Paa::with('modalidad','tipocontrato','rubro','area','proyecto','meta')->whereIn('Id_Area',$arreglo1)->whereIn('Estado',['0','4','5','6','7','8','9','10','11'])->get();

        $paa2 = Paa::whereIn('Id_Area',$arreglo1)->where('Estado','1')->get();

        $datos = [        
            'modalidades' => $modalidadSeleccion,
            'proyectos' => $proyecto,
            'tipoContratos' => $tipoContrato,
            'componentes' => $componente,
            'fuentes'=>$fuente,
            'paas' => $paa,
            'paas2' => $paa2
        ];
		return view('consolidador',$datos);
	}


    public function aprobarSubDireccion($id)
    {
        $model_A = Paa::find($id);
        $model_A['Estado'] = 4;
        $id_area_def=$model_A['Id_Area'];
        $model_A->save();

        $personaOperativo = $this->repositorio_personas->obtener($model_A['IdPersona']);
        $personaConsolidador = $this->repositorio_personas->obtener($_SESSION['Id_Persona']);
        $area=Area::with('subdirecion')->find($id_area_def);

        $personapaas = PersonaPaa::where('id_area',$id_area_def)->get();
        $pila = array();
        foreach ($personapaas as &$personapaa) 
        {
            array_push($pila, $personapaa['id']);
        }

        $id_Tipos=[61,63]; //Enviado Operario y Subdirector
    
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
        $mensaje="PAA ID. ".$id.": Consolidado para aprobación de la sub dirección.";
        Mail::send('mailConsolidado', ['mensaje'=>$mensaje,'personaOperativo'=>$personaOperativo,'personaConsolidador'=>$personaConsolidador,'area'=>$area], function ($m) use ($mensaje,$emails)  {
            $m->from('no-reply@paa.com', $mensaje);

            $m->to($emails, 'Estevenhr')->subject($mensaje."!");
        });
        
        $paa = Paa::with('modalidad','tipocontrato','rubro','area','proyecto','meta')->where('IdPersona','1046')->whereIn('Estado',['0','4','5','6','7','8','9','10','11'])->get();
        $paa2 = Paa::where('IdPersona','1046')->where('Estado','1')->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa, 'datos2' => $paa2));
    }

    public function imprimir(Request $request, $id)
    {
        /*$factura = Factura::with('planesDePagos', 'planesDePagos.pago', 'planesDePagos.matricula', 'planesDePagos.matricula.grado', 'planesDePagos.matricula.estudiante')->find($id);*/
        $html = "<h4>Bien!!! </h4>";
        $pdf = PDF::load($html);

        return $pdf->download(); 
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

         /* if(sizeof($FuenteRecurso)>0){
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
          }*/

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
           // var_dump(sizeof($DuracionContrato));
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

        /*  if(sizeof($MetaPlan)>0){
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
          }*/

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
                $modeloCambioPaa['campo'] = 'Id_Proyecto';
                $modeloCambioPaa->save();
                $paas = Paa::find($Registro[$i]);
                $paas['Id_Proyecto'] = $Nombre_r[$i];
                $paas->save();
              }
          }

        }
        
        $paa = Paa::with('modalidad','tipocontrato','rubro','area','proyecto','meta')->where('IdPersona','1046')->whereIn('Estado',['0','4','5','6','7','8','9','10','11'])->get();
        $paa2 = Paa::where('IdPersona','1046')->where('Estado','1')->get();
        return response()->json(array('status' => 'modelo', 'datos' => $paa, 'datos2' => $paa2));

    }

    public function historialObservaciones(Request $request, $id)
    {
        $model_A = Observacion::where('id_registro',$id)->get();
        return response()->json($model_A);
    }

    public function RegistrarObservacion(Request $request)
    {
        $id_persona=$_SESSION['Id_Persona'];

        $modeloObserva = new Observacion;
        $modeloObserva['id_persona'] = $id_persona;
        $modeloObserva['id_registro'] = $request['id'];
        $modeloObserva['estado'] = $request['Estado'];
        $modeloObserva['observacion'] = $request['observacion'];
        $modeloObserva->save();
        return response()->json(array('status' => 'ok'));
    }

   

}
