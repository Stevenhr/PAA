<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use Illuminate\Http\Request;
use App\Persona;
use App\PersonaPaa;
use App\Area;
use Illuminate\Support\Facades\Session;

class MainController extends Controller {

	protected $Usuario;
	protected $repositorio_personas;

	public function __construct(PersonaInterface $repositorio_personas)
	{
		if (isset($_SESSION['Usuario']))
			$this->Usuario = $_SESSION['Usuario'];

		$this->repositorio_personas = $repositorio_personas;
	}

   public function welcome()
	{ 

			return view('welcome');	
	}

    public function index(Request $request)
	{
		$fake_permissions = 'a:6:{i:0;s:5:"71766";i:1;s:1:"1";i:2;s:1:"1";i:3;s:1:"1";i:4;s:1:"1";i:5;s:1:"1";}';
		$fake_permissions="a%3A15%3A%7Bi%3A0%3Bs%3A4%3A%221046%22%3Bi%3A1%3Bs%3A1%3A%221%22%3Bi%3A2%3Bs%3A1%3A%221%22%3Bi%3A3%3Bs%3A1%3A%221%22%3Bi%3A4%3Bs%3A1%3A%221%22%3Bi%3A5%3Bs%3A1%3A%221%22%3Bi%3A6%3Bs%3A1%3A%221%22%3Bi%3A7%3Bs%3A1%3A%221%22%3Bi%3A8%3Bs%3A1%3A%221%22%3Bi%3A9%3Bs%3A1%3A%221%22%3Bi%3A10%3Bs%3A1%3A%221%22%3Bi%3A11%3Bs%3A1%3A%221%22%3Bi%3A12%3Bs%3A1%3A%221%22%3Bi%3A13%3Bs%3A1%3A%221%22%3Bi%3A14%3Bs%3A1%3A%221%22%3B%7D";


		if ($request->has('vector_modulo') || $fake_permissions)
		{	
			$vector = $request->has('vector_modulo') ? urldecode($request->input('vector_modulo')) : $fake_permissions;
			$vector = urldecode($vector);
			$user_array = unserialize($vector);
			$permissions_array = $user_array;

			$permisos = [
				'Configuracion_paa' => intval($permissions_array[1]),
				'Crear_Usuario' => intval($permissions_array[2]),
				'Gestion_operador' => intval($permissions_array[3]),
				'Gestion_consolidador'=> intval($permissions_array[4]),
				'Gestion_subdireccion'=> intval($permissions_array[5]),
				'Gestion_planeacion'=> intval($permissions_array[6]),
				'Asignar_Actividades'=> intval($permissions_array[7]),
				'Asignar_Tipo_Persona'=> intval($permissions_array[8]),
				'Gestion_Direccion_General'=> intval($permissions_array[9]),
				'General'=> intval($permissions_array[10]),
				'Gestion_cecop'=> intval($permissions_array[11]),
				'Reporte_proyecto'=> intval($permissions_array[12]),
				'Reporte_general'=> intval($permissions_array[13]),
				'Reporte_Sin_Aprobacion'=> intval($permissions_array[14])
			];



			$_SESSION['Usuario'] = $user_array;
			$persona = $this->repositorio_personas->obtener($_SESSION['Usuario'][0]);

			$_SESSION['Usuario']['Persona'] = $persona;
			$_SESSION['Usuario']['Permisos'] = $permisos;
			$this->Usuario = $_SESSION['Usuario']; // [0]=> string(5) "71766" [1]=> string(1) "1"

			$_SESSION['Usuario']['Permisos'] = $permisos;

            $id_Tipos=[61,62,63,64];
            $ModeloPersona = Persona::with(['tipo' => function($query) use ($id_Tipos)
			{
				$query->find($id_Tipos);
			}])->find($_SESSION['Usuario']['Persona']['Id_Persona']);
            $tipo_persona="";
			
			$_SESSION['Id_Persona'] = $_SESSION['Usuario']['Persona']['Id_Persona'];
			foreach ($ModeloPersona->tipo as &$tipo_p) 
	        {
	            $tipo_persona =$tipo_p['Nombre']." ".$tipo_persona;
	        }
			$_SESSION['Tipo'] = $tipo_persona;

			$personapaa = PersonaPaa::find($_SESSION['Id_Persona']);
			$area = Area::with('subdirecion')->find($personapaa['id_area']);
			
			$_SESSION['Usuario']['Id_Area']=$personapaa['id_area'];
			$_SESSION['Usuario']['Id_SubDireccion']=$area->subdirecion['id'];
			$_SESSION['Nombre']=$persona["Primer_Apellido"]." ".$persona["Segundo_Apellido"]." ".$persona["Primer_Nombre"]." ".$persona["Segundo_Nombre"]; 

		} else {
			if(!isset($_SESSION['Usuario']))
				$_SESSION['Usuario'] = '';
		}

		if ($_SESSION['Usuario'] == '')
			return redirect()->away('http://www.idrd.gov.co/SIM/Presentacion/');

		return redirect('/welcome');
	}

	public function logout()
	{
	//dd($_SESSION['Usuario']);
		$_SESSION['Usuario'] = '';
		session_destroy();
		return redirect()->to('/');
	}

}