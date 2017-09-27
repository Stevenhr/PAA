<?php

namespace App\Http\Controllers;
set_time_limit(-50);
use Illuminate\Http\Request;

use App\Http\Requests;
use App\ProyectoDesarrollo;
use App\Presupuesto;
use App\Proyecto;
use App\Paa;
use App\Meta;
use App\FuenteProyecto;
use App\ActividadComponente;
use App\Estado;
use App\PersonaPaa;
use Validator;

class ControllerReporteGeneral extends Controller
{
    public function index()
	{
		$proyectoDesarrollo = ProyectoDesarrollo::all();
		$datos = [        
            'planDesarrollo' => $proyectoDesarrollo,
            'vista'=>0,
        ];
		return view('reportegeneral',$datos);
	}

    public function index_operario()
    {
        $proyectoDesarrollo = ProyectoDesarrollo::all();
        $datos = [        
            'planDesarrollo' => $proyectoDesarrollo,
            'vista'=>1,
        ];
        return view('reportegeneral',$datos);
    }

    public function validar_form(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'fecha_inicial' =>'required',
                'fecha_final' =>'required',
                'planDesarrollo' =>'required',
            ]
        );

           if ($validator->fails()){
                return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
           }
           else
           {
                
                if($request['vista']==0){
                    $proyecto = Paa::with('componentes')->get();

                    $finanzas_r = Paa::with('componentes')->whereBetween('FechaEstudioConveniencia',array($request['fecha_inicial'], $request['fecha_final']))->where('Estado',Estado::EstudioAprobado)->get();

                    if($finanzas_r)
                    {
                        foreach ($finanzas_r as &$paa)
                        {
                            foreach ($paa->componentes as &$actividad)
                            {
                                
                                $actividad->Meta = Meta::find($actividad->pivot['id_fk_meta']);
                                $actividad->FuenteProyecto = FuenteProyecto::with('fuente','proyecto')->find($actividad->pivot['fuente_id']);
                                $actividad->actividadMeta = ActividadComponente::with('actividades')->find($actividad->pivot['id']);
                            }
                        }
                    }
                }elseif ($request['vista']==1) {

                    $proyecto = Paa::with('componentes')->get();
                    $personapaa = PersonaPaa::find($_SESSION['Id_Persona']);
                    $finanzas_r = Paa::with('componentes')->whereBetween('FechaEstudioConveniencia',array($request['fecha_inicial'], $request['fecha_final']))->where('Id_Area',$personapaa['id_area'])->whereIn('Estado',[Estado::Consolidacion,Estado::Subdireccion,Estado::Aprobado,Estado::Rechazado,Estado::EstudioConveniencia,Estado::EstudioCorregido])->get();
                    
                    if($finanzas_r)
                    {
                        foreach ($finanzas_r as &$paa)
                        {
                            foreach ($paa->componentes as &$actividad)
                            {
                                $actividad->Meta = Meta::find($actividad->pivot['id_fk_meta']);
                                $actividad->FuenteProyecto = FuenteProyecto::with('fuente','proyecto')->find($actividad->pivot['fuente_id']);
                            }
                        }
                    }
                }
                

                $tabla="<table id='Tabla_Reporte2' class='display responsive no-wrap' width='100%' cellspacing='0'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><center>Id</center></th>
                            <th>Objeto</th>
                            <th>Valor</th> 
                            <th>Proyecto</th>
                            <th>Meta</th>
                            <th>Actividad</th>
                            <th>Concepto</th>
                            <th>Fuente</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th><center>Id</center></th>
                            <th>Objeto</th>
                            <th>Valor</th> 
                            <th>Proyecto</th>
                            <th>Meta</th>
                            <th>Actividad</th>
                            <th>Concepto</th>
                            <th>Fuente</th>
                        </tr>
                    </tfoot>
                    <tbody>";
                       $num=1;
                       if($request['vista']==0){
                         foreach ($finanzas_r as $key => $value) {
                            foreach ($value->componentes as $key => $componente) {
                                if($componente->actividadMeta){
                                    foreach ($componente->actividadMeta->actividades as $key => $atividadmet) {
                                        // dd($atividadmet);
                                        $tabla=$tabla."<tr>
                                            <td>".$num."</td>
                                            <td><center><h4>".$value['Id']."</h4></center></td>
                                            <td ><div  class='campoArea'>".$value['ObjetoContractual']."</div></td>
                                            <td> $".number_format ($atividadmet->pivot['valor'])."</td>
                                            <td>".$componente->FuenteProyecto->proyecto['Nombre']."</td>
                                            <td>".$componente->Meta['Nombre']."</td>
                                            <td>".$atividadmet['Nombre']."</td>
                                            <td>".$componente['Nombre']."</td>
                                            <td>".$componente->FuenteProyecto->fuente['nombre']."</td>
                                        </tr>";
                                        $num++;
                                    }
                                }
                            }                        
                         }   
                        }elseif ($request['vista']==1) {
                          foreach ($finanzas_r as $key => $value) {
                            foreach ($value->componentes as $key => $componente) {
                                    //dd($componente);
                                        $tabla=$tabla."<tr>
                                            <td>".$num."</td>
                                            <td><center><h4>".$value['Id']."</h4></center></td>
                                            <td ><div  class='campoArea'>".$value['ObjetoContractual']."</div></td>
                                            <td> $".number_format ($componente->pivot['valor'])."</td>
                                            <td>".$componente->FuenteProyecto->proyecto['Nombre']."</td>
                                            <td>".$componente->Meta['Nombre']."</td>
                                            <td>N.R</td>
                                            <td>".$componente['Nombre']."</td>
                                            <td>".$componente->FuenteProyecto->fuente['nombre']."</td>
                                        </tr>";
                                        $num++;
                                
                            }                        
                          } 
                        }
                                             
                $tabla=$tabla."</tbody>
                </table>";
                return response()->json(array('status' => 'ok', 'tabla' => $tabla));
            }
    }
	
}
