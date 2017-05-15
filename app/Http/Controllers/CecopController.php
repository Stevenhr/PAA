<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Paa;
use App\Estado;
use App\SubDireccion;
use App\ActividadComponente;
use App\FuenteHacienda;
use App\Actividad;
use App\Componente;
use App\Historial_cecop;
use Idrd\Usuarios\Repo\PersonaInterface;
use Carbon;
class CecopController extends Controller
{
    //

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

		$historial = Historial_cecop::all();

		$datos = [
			'historiales' => $historial,
		];

		return view('gestion_cecop', $datos);
	}

	public function descargarInformeCecop(Request $request)
    {
		$paas = Paa::with('modalidad', 'tipocontrato', 'rubro','componentes.fuente','area.subdirecion')
					/*->whereIn('Estado', [Estado::Subdireccion, Estado::Aprobado, Estado::Rechazado, Estado::Cancelado,Estado::EstudioConveniencia,Estado::EstudioAprobado,Estado::EstudioCorregido,Estado::EstudioCancelado])*/
					->orderBy('id')
					->get();

		$datos = [
			'paas' => $paas,
		];

		$mytime = Carbon\Carbon::now();
		

		$historial = new Historial_cecop;
		$historial['id_usuario']=$this->Usuario[0];
		$historial['fecha_generacion']=$mytime->toDateTimeString();;
		$historial->save();

        $view =  view('informececop',$datos);
        return $view;

    }
}
