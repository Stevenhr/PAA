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

class ConsolidadoController extends Controller
{
    //

    public function index()
	{
		$modalidadSeleccion = ModalidadSeleccion::all();
		$proyecto = Proyecto::all();
		$tipoContrato = TipoContrato::all();
		$componente = Componente::all();
        $fuente = Fuente::all();
        $paa = Paa::with('modalidad','tipocontrato','rubro')->where('IdPersona','1046')->where('Estado','0')->where('EsatdoObservo','0')->get();

        $datos = [        
            'modalidades' => $modalidadSeleccion,
            'proyectos' => $proyecto,
            'tipoContratos' => $tipoContrato,
            'componentes' => $componente,
            'fuentes'=>$fuente,
            'paas' => $paa
        ];
		return view('consolidador',$datos);
	}

}
