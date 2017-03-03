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

class DireccionController extends BaseController 
{

	protected $Usuario;

	public function __construct()
	{
		if (isset($_SESSION['Usuario']))
			$this->Usuario = $_SESSION['Usuario'];
	}

	public function index()
	{
		$subdireccion = Subdireccion::with('areas')->find($this->Usuario['Id_SubDireccion']);


		$paas = Paa::with('modalidad', 'tipocontrato', 'rubro')
						->whereIn('Estado', [Estado::Subdireccion, Estado::Aprobado, Estado::Rechazado, Estado::Cancelado,Estado::EstudioConveniencia,Estado::EstudioAprobado,Estado::EstudioCorregido,Estado::EstudioCancelado])
						->whereIn('Id_Area', $subdireccion->areas->pluck('id'))
						->orderBy('id')
						->get();

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
		$paas = explode(',', $request->input('paas'));

		foreach ($paas as $id) 
		{
			$paa = Paa::where('Id', $id)->first();
			$paa->Estado = Estado::Aprobado;
			$paa->save();
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
        $estado=$request['estado'];
        $paa = Paa::find($id);
        $paa['estado'] =$estado;
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

    		$id=$request->input('id_paa_estudio');

    		$EstudioConveniencias =  EstudioConveniencia::find($id);
	        $paa = Paa::with('modalidad','tipocontrato','meta.actividades','area','componentes')->find($id);
	        $finanzas = ActividadComponente::with('actividades')->where('id_paa',$id)->get();

	        foreach ($finanzas as $finanza) {
	                $finanza->Componente = Componente::find($finanza['componente_id']);
	            foreach ($finanza->actividades as &$actividad){
	                $actividad->Actividad = Actividad::find($actividad->pivot['actividad_id']);
	                $actividad->Fuente = FuenteHacienda::find($actividad->pivot['fuentehacienda']);
	            }
	        }

	        $datos = [        
	            'EstudioConveniencias' => $EstudioConveniencias,
	            'paas' => $paa,
	            'finanzas' =>$finanzas
	        ];

	        	//return view('pdfEstudio',$datos);
		        $view =  view('pdfEstudio',$datos)->render();
		        $pdf = PDF::loadHTML($view);
		        return $pdf->setPaper(array(0,0,1800,2620), 'portrait')->stream('Sesion '.date('l jS \of F Y h:i:s A'));

    }
}