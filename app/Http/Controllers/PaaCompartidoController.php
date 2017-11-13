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
}