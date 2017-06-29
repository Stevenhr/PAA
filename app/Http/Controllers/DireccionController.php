<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Estado;
use App\Observacion;
use App\SubDireccion;
use App\Paa;
use PDF;
use App\EstudioConveniencia;
use App\FuenteHacienda;
use App\Area;
use App\ActividadComponente;
use App\Actividad;
use App\Componente;
use Mail;
use Idrd\Usuarios\Repo\PersonaInterface;
use App\Persona;
use App\Datos;
use App\PersonaPaa;
use App\ActividadFuncionamiento;

class DireccionController extends BaseController 
{

	protected $Usuario;
	protected $repositorio_personas;

	public function __construct(PersonaInterface $repositorio_personas)
	{
		if (isset($_SESSION['Usuario']))
			$this->Usuario = $_SESSION['Usuario'];

			$this->repositorio_personas = $repositorio_personas;
	}

	public function index()
	{
		$subdireccion = Subdireccion::with('areas')->find($this->Usuario['Id_SubDireccion']);


		$paas = Paa::with('modalidad', 'tipocontrato', 'rubro','area','persona','observaciones','rubro_funcionamiento','componentes')->whereIn('Estado', [Estado::Subdireccion, Estado::Aprobado, Estado::Rechazado, Estado::Cancelado,Estado::EstudioConveniencia,Estado::EstudioAprobado,Estado::EstudioCorregido,Estado::EstudioCancelado])
						->whereIn('Id_Area', $subdireccion->areas->pluck('id'))
						->orderBy('id')
						->get();
		//dd($paas);
		$datos = [
			'paas' => $paas,
		];

		return view('aprobacion-subdireccion-paa', $datos);
	}

	public function rechazar(Request $request)
	{
		$paa = Paa::where('Id', $request->input('Id'))->first();
		$paa->Estado = Estado::Rechazado;
		$paa->save();
		
		$this->agregarObservacion($paa, $request->input('Observaciones'));
		return response()->json(true);
	}

	public function cancelar(request $request)
	{
		$paa = Paa::where('Id', $request->input('Id'))->first();
		$paa->Estado = Estado::Cancelado;
		$paa->save();

		$this->agregarObservacion($paa, $request->input('Observaciones'));
		return response()->json(true);
	}

	public function enviar(Request $request)
	{
		$personaSubDirecc = $this->repositorio_personas->obtener($_SESSION['Id_Persona']);
		$paas = explode(',', $request->input('paas'));
		foreach ($paas as $id) 
		{
			$paa = Paa::where('Id', $id)->first();
			$paa->Estado = Estado::Aprobado;
			$id_area_def=$paa->Id_Area;
			$personaOperativo = $this->repositorio_personas->obtener($paa->IdPersona);
			$paa->save();

			$area=Area::with('subdirecion')->find($id_area_def);

	        $personapaas = PersonaPaa::where('id_area',$id_area_def)->get();
	        $pila = array();
	        foreach ($personapaas as &$personapaa) 
	        {
	            array_push($pila, $personapaa['id']);
	        }

	        $id_Tipos=[61,62]; //Enviado a Operario y Consolidador: Reviar por q me trea todos y no solo los 62

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
	        $mensaje="PAA ID. ".$id.": Plan Aprobado!, aprobado por la Sub Dirección.";
	        Mail::send('mailSubDirecc', ['mensaje'=>$mensaje,'personaOperativo'=>$personaOperativo,'personaSubDirecc'=>$personaSubDirecc,'area'=>$area], function ($m) use ($mensaje,$emails)  {
	            $m->from('no-reply_Paa@idrd.gov.co', $mensaje);

	            $m->to($emails, 'Estevenhr')->subject($mensaje."!");
	        });
		}

		return response()->json(true);
	}

	private function agregarObservacion($paa, $texto)
	{		
		$observacion = new Observacion;
		$observacion->id_registro = $paa['Id'];
		$observacion->id_persona = $this->Usuario[0];
		$observacion->observacion = $texto;
		$observacion->Estado =  Estado::toString($paa['Estado']);

		$observacion->save();
	}

	 public function AprobarEstudio(Request $request)
    {
    	$id=$request['id'];
    	$paa = Paa::find($id);
    	$personaSubDirecc = $this->repositorio_personas->obtener($_SESSION['Id_Persona']);
    	$personaOperativo = $this->repositorio_personas->obtener($paa['IdPersona']);
    	$area=Area::with('subdirecion')->find($paa['Id_Area']);

    		$emails = array();
	        $DatosEmail = Datos::whereIn('Id_Persona',[$_SESSION['Id_Persona'],$paa['IdPersona']])->get();
	        foreach ($DatosEmail as &$DatoEmail) 
	        {
	            if($DatoEmail){
	                array_push($emails, $DatoEmail['Email']);
	            }
	        }
	        $mensaje="PAA ID. ".$id.": ".$request['tipo'];
	        Mail::send('mailSubDirecc', ['mensaje'=>$mensaje,'personaOperativo'=>$personaOperativo,'personaSubDirecc'=>$personaSubDirecc,'area'=>$area], function ($m) use ($mensaje,$emails)  {
	            $m->from('no-reply_Paa@idrd.gov.co', $mensaje);

	            $m->to($emails, 'Estevenhr')->subject($mensaje."!");
	        });

 		$ldate = date('Y-m-d H:i:s');
        
        $estado=$request['estado'];
        
        $paa['estado'] =$estado;
        $paa['FechaEstudioConveniencia'] =$ldate;
        $paa->save();
        
        $observacion = new Observacion;
		$observacion->id_registro = $id;
		$observacion->id_persona = $this->Usuario[0];
		$observacion->observacion = $request['observacion'];
		$observacion->Estado =  $request['tipo'];
		$observacion->save();

        return response()->json(array('status' => 'ok'));
    }

    public function descargarEstudio(Request $request)
    {
    		$id=$request->input('id_paa_estudio_f');

    		$EstudioConveniencias =  EstudioConveniencia::find($id);
	        $paa = Paa::with('modalidad','tipocontrato','meta.actividades','area','componentes','proyecto','rubro_funcionamiento','rubro_funcionamiento.actividadesfuncionamiento')->find($id);
	       
	        
	        $subdireccion = Subdireccion::with('areas')->find($this->Usuario['Id_SubDireccion']);


	        if($paa['Proyecto1Rubro2']==1)
	        {
	             $finanzas = ActividadComponente::with('actividades','actividades.meta','fuenteproyecto.fuente')->where('id_paa',$id)->get();
	            foreach ($finanzas as $finanza) 
	            {
	                    $finanza->Componente = Componente::find($finanza['componente_id']);
	                foreach ($finanza->actividades as &$actividad)
	                {
	                    $actividad->Actividad = Actividad::find($actividad->pivot['actividad_id']);
	                    $actividad->Fuente = FuenteHacienda::find($actividad->pivot['fuentehacienda']);
	                }
	            }
	        }
	        else
	        {
	            $finanzas = Paa::with('actividadesFuncionamiento')->find($id);
	            foreach ($finanzas->actividadesFuncionamiento as &$actividad)
	            {
	                $actividad->Actividad = ActividadFuncionamiento::find($actividad->pivot['actividad_f_id']);
	                $actividad->Fuente = FuenteHacienda::find($actividad->pivot['fuentehacienda']);
	            }
	        }


	        $datos = [        
	            'EstudioConveniencias' => $EstudioConveniencias,
	            'paas' => $paa,
	            'finanzas' =>$finanzas,
	            'subdireccion'=>$subdireccion,
	            'RubroPryecto'=>$paa['Proyecto1Rubro2']
	        ];
	        //dd($datos);
	        $view =  view('pdfEstudio',$datos)->render();

	        //return $view;
	        //exit();
	        $pdf = PDF::loadHTML($view);
	        return $pdf->setPaper(array(0,0,1800,2620), 'portrait')->download('Estudio_'.$paa['Id'].'.pdf');

    }

    public function validarEstudio(Request $request, $id)
	{
		$EstudioConveniencias =  EstudioConveniencia::find($id);
        $datos = [        
            'EstudioConveniencias' => $EstudioConveniencias
        ];
        return response()->json($datos);
	}


	public function historialObservaciones(Request $request, $id)
    {
        $model_A = Observacion::with('persona')->where('id_registro',$id)->get();
        foreach ($model_A as $key) {
            $modeloOb = Observacion::find($key['id']);
            $modeloOb['check_subd']=1;
            $modeloOb->save();
        }
        return response()->json($model_A);
    }

	public function RegistrarObservacion(Request $request)
    {
      
    	//dd($request['id']);
      if($request['observacion']!="")
      {
        $id=$request['id'];
        $model_A = Paa::find($id);
        $personaOperativo = $this->repositorio_personas->obtener($model_A['IdPersona']);
        $personaConsolidador = $this->repositorio_personas->obtener($_SESSION['Id_Persona']);
        $emails = array();
        $DatosEmail = Datos::whereIn('Id_Persona',[$model_A['IdPersona'],$_SESSION['Id_Persona']])->get();
        foreach ($DatosEmail as &$DatoEmail) 
        {
            if($DatoEmail){
                array_push($emails, $DatoEmail['Email']);
            }
        }
        //dd($emails);

        $personapaas = PersonaPaa::where('id_area',$model_A['Id_Area'])->get();
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

        $DatosEmail = Datos::whereIn('Id_Persona',$Consolidadore)->get();
        foreach ($DatosEmail as &$DatoEmail) 
        {
            if($DatoEmail){
                array_push($emails, $DatoEmail['Email']);
            }
        }

        //dd($emails);

        $mensaje="PAA ID. ".$id.": Observación.";
        Mail::send('mailMensaje', ['mensaje'=>$mensaje,'personaOperativo'=>$personaOperativo,'personaConsolidador'=>$personaConsolidador,'mensaje'=>$request['observacion']], 
        function ($m) use ($mensaje,$emails)  {
              $m->from('no-reply_Paa@idrd.gov.co', $mensaje);
              $m->to($emails, 'Estevenhr')->subject($mensaje."!");
        });

        $id_persona=$_SESSION['Id_Persona'];
        $modeloObserva = new Observacion;
        $modeloObserva['id_persona'] = $id_persona;
        $modeloObserva['id_registro'] = $request['id'];
        $modeloObserva['estado'] = $request['Estado'];
        $modeloObserva['check_subd']=1;
        $modeloObserva['observacion'] = $request['observacion'];
        $modeloObserva->save();
        return response()->json(array('status' => 'ok'));
      }
      else
      {
        return response()->json(array('status' => 'vacio'));
      }
    }
}