<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\ModalidadSeleccion;
use App\TipoContrato;
use App\Componente;
use App\Fuente;
use App\Paa;
use App\Proyecto;
use App\SubDireccion;
use App\FuenteHacienda;

class GeneralController extends Controller
{
    //
    public function index()
	{
		$modalidadSeleccion = ModalidadSeleccion::all();
		$proyecto = Proyecto::all();
		$tipoContrato = TipoContrato::all();
		$componente = Componente::all();
        $fuente = Fuente::all();
        $subDireccion = SubDireccion::all();
        $fuenteHacienda = FuenteHacienda::all();
        $paa = Paa::with('modalidad','tipocontrato','rubro','area','area.subdirecion','componentes','proyecto','meta')->whereIn('Estado',['0','4','5','6','7','8','9','10','11'])->get();

        $datos = [        
            'modalidades' => $modalidadSeleccion,
            'proyectos' => $proyecto,
            'tipoContratos' => $tipoContrato,
            'componentes' => $componente,
            'fuentes'=>$fuente,
            'paas' => $paa,
            'subDirecciones' => $subDireccion,
            'fuenteHaciendas'=>$fuenteHacienda 
        ];

		return view('paa_general',$datos);
	}

    public function salir()
    {
        //Desconctamos al usuario
        session_destroy();
        //Redireccionamos al inicio de la app con un mensaje
        return Redirect::to('/')->with('msg', 'Gracias por visitarnos!.');
    }
}
