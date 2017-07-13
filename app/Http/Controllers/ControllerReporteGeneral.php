<?php

namespace App\Http\Controllers;

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
use Validator;

class ControllerReporteGeneral extends Controller
{
    public function index()
	{
		$proyectoDesarrollo = ProyectoDesarrollo::all();
		$datos = [        
            'planDesarrollo' => $proyectoDesarrollo
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
                $proyecto = Paa::with('componentes')->get();

                $finanzas_r = Paa::with('componentes')->where('Estado',Estado::EstudioAprobado)->get();
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
                
                $tabla="  <div class='table-responsive'> 
                <table id='Tabla_Reporte2'>
                    <thead>
                        <tr>
                            <th>Id</b></th>
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
                            <th>Id</b></th>
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
                        foreach ($finanzas_r as $key => $value) {
                            foreach ($value->componentes as $key => $componente) {
                                foreach ($componente->actividadMeta->actividades as $key => $atividadmet) {
                                    $tabla=$tabla."<tr>
                                        <td>".$value['Id']."</td>
                                        <td ><div  class='campoArea'>".$value['ObjetoContractual']."</div></td>
                                        <td> $".number_format ($atividadmet->pivot['valor'])."</td>
                                        <td>".$componente->FuenteProyecto->proyecto['Nombre']."</td>
                                        <td>".$componente->Meta['Nombre']."</td>
                                        <td>".$atividadmet['Nombre']."</td>
                                        <td>".$componente['Nombre']."</td>
                                        <td>".$componente->FuenteProyecto->fuente['nombre']."</td>
                                    </tr>";
                                }
                            }                        
                        }                        
                $tabla=$tabla."</tbody>
                </table></div>";
                return response()->json(array('status' => 'ok', 'tabla' => $tabla));
            }
    }
	
}
