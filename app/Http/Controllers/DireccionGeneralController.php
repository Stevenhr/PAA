<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Estado;
use App\Paa;
use App\SubDireccion;
use App\Area;
use App\Proyecto;
use App\ActividadComponente;
use App\Observacion;

class DireccionGeneralController extends Controller
{
    //
    public function index() 
	{
		$subdirecciones = SubDireccion::with(['areas', 'areas.paas' => function($query)
			{
				$query->whereIn('Estado', [Estado::EstudioAprobado,Estado::EstudioCancelado]);
			}, 'areas.paas.modalidad', 'areas.paas.tipocontrato', 'areas.paas.rubro'])->get();


		$datos = [
			'subdirecciones' => $subdirecciones,
		];

		return view('aprobacion-direccion-general', $datos);
	}

    public function obtenerHistorialPaaTodo(Request $request, $id)
    {
        $model_A = Paa::with('modalidad','tipocontrato','cambiosPaa','meta','proyecto','rubro_funcionamiento')->where('Registro', '=', $id)->get();
        return response()->json($model_A);
    }

    public function verFinanciacion(Request $request, $id)
    {
        $ActividadComponente = ActividadComponente::with('proyecto','fuenteproyecto','fuenteproyecto.fuente','componente')->where('id_paa',$id)->get();
        $model_A = Paa::with('componentes','componentes.fuente')->find($id);
        //dd($model_A);
        //exit();
        $Proyecto = Proyecto::with('fuente')->find($model_A['Id_Proyecto']);
        return response()->json(array('estado' => $model_A['Estado'],'proyecto'=>$Proyecto, 'ActividadComponente'=>$ActividadComponente) );
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
