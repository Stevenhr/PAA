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

class ControllerReporteGeneral2 extends Controller
{
    public function index()
	{
		$proyectoDesarrollo = ProyectoDesarrollo::all();
		$datos = [        
            'planDesarrollo' => $proyectoDesarrollo,
            'vista'=>0,
        ];
		return view('reportegeneral2',$datos);
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
                    $personapaa = PersonaPaa::find($_SESSION['Id_Persona']);
                    $finanzas_r = Paa::with(['componentes' => function($query)
                    {
                        $query->wherePivot('deleted_at',NULL)->get();
                    }],'persona')->whereBetween('FechaEstudioConveniencia',array($request['fecha_inicial'], $request['fecha_final']))->whereIn('Estado',[Estado::Consolidacion,Estado::Subdireccion,Estado::Aprobado,Estado::Rechazado,Estado::EstudioConveniencia,Estado::EstudioCorregido])->get();
                    
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
                
                

                $tabla="<table id='Tabla_Reporte2' class='display responsive no-wrap' width='100%' cellspacing='0'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><center>Id</center></th>
                            <th>Objeto</th>
                            <th>Valor</th> 
                            <th>Valor estimado </th>
                            <th>Usuario</th> 
                            <th>Proyecto</th>
                            <th>Meta</th>
                            <th>Actividad</th>
                            <th>Concepto</th>
                            <th>Fuente</th>
                            <th>Compartida <br> Vinculada <br> Individual</th>
                            <th>Id Item</th>
                            <th>Códigos<br>UNSPSC</th>
                            <th>Modalidad</th>
                            <th>Tipo<br>Contrato</th>
                            <th>Duración<br>Estimada</th>
                            
                            <th>¿Se requieren <br>vigencias futuras?    </th>
                            <th>Estado de solicitud <br> vigencias futuras  </th>
                            <th>Estudio de  conveniencia<br> (dd/mm/aaaa)</th>
                            <th>Fecha estimada de inicio de <br>proceso de selección - Fecha  (dd/mm/aaaa)  </th>
                            <th>Fecha suscripción <br>Contrato (dd/mm/aaaa) </th>
                            <th>Recurso Humano (Si / No)</th>
                            <th>Número de Contratistas  </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th><center>Id</center></th>
                            <th>Objeto</th>
                            <th>Valor</th> 
                            <th>Valor estimado </th>
                            <th>Usuario</th> 
                            <th>Proyecto</th>
                            <th>Meta</th>
                            <th>Actividad</th>
                            <th>Concepto</th>
                            <th>Fuente</th>
                            <th>Compartida <br> Vinculada <br> Individual</th>
                            <th>Id Item</th>
                            <th>Códigos<br>UNSPSC</th>
                            <th>Modalidad</th>
                            <th>Tipo<br>Contrato</th>
                            <th>Duración<br>Estimada</th>
                            
                            <th>¿Se requieren <br>vigencias futuras?    </th>
                            <th>Estado de solicitud <br> vigencias futuras  </th>
                            <th>Estudio de  conveniencia<br> (dd/mm/aaaa)</th>
                            <th>Fecha estimada de inicio de <br>proceso de selección - Fecha  (dd/mm/aaaa)  </th>
                            <th>Fecha suscripción <br>Contrato (dd/mm/aaaa) </th>
                            <th>Recurso Humano (Si / No)</th>
                            <th>Número de Contratistas  </th>
                        </tr>
                    </tfoot>
                    <tbody>";
                       $num=1;
                       $c_v_i="";
                       $c_v_i_id="";
                           foreach ($finanzas_r as $key => $value) 
                            {
                                foreach ($value->componentes as $key => $componente) 
                                {
                                       $individual = Paa::with(['componentes' => function($query) use($componente,$value)
                                        {
                                            $query->where('id_paa',$value['Id'])                                                  
                                                  ->whereNull('actividadComponente.deleted_at');
                                        }])->find($value['Id']);

                                        $sumValroesEspecificos=0;

                                        foreach ($individual->componentes as $key => $compon) 
                                        {
                                                $sumValroesEspecificos=$sumValroesEspecificos+$compon->pivot['valor'];
                                            
                                        }
                                        $error="";
                                        if($value['ValorEstimado']!=$sumValroesEspecificos)
                                            $error="Incompleto";

                                        $var0='';
                                        if ($value['compartida']>0)
                                            $var0 = 'C'; 
                                        else
                                            $var0 = ''; 

                                        $var1='';
                                        if ($value['vinculada']>0){
                                            $var1 = 'V'; 
                                            $var11 = $paa['vinculada']; 
                                        }else{
                                            $var1 = ''; 
                                            $var11 = ''; 
                                        }

                                        $tabla=$tabla."<tr>
                                            <td>".$num."</td>
                                            <td><center><h4>".$value['Id']." ".$var0." ".$var1."</h4></center></td>
                                            <td ><div  class='campoArea'>".$value['ObjetoContractual']."</div></td>
                                            
                                            <td > $".number_format ($componente->pivot['valor'])."</td>";
                                            $tabla=$tabla."<td> $".number_format ($value['ValorEstimado'])." <br> ".$error."</td>";
                                            $tabla=$tabla."<td >".$value->persona['Primer_Apellido']." ".$value->persona['Primer_Nombre']."</td>";
                                            $tabla=$tabla."<td><b>".$componente->FuenteProyecto->proyecto['codigo']."</b><br>".$componente->FuenteProyecto->proyecto['Nombre']."</td>
                                            <td>".$componente->Meta['Nombre']."</td>
                                            <td>N.R</td>
                                            <td><b>".$componente['codigo']."</b><br>".$componente['Nombre']."</td>
                                            <td><b>".$componente->FuenteProyecto->fuente['codigo']."</b><br>".$componente->FuenteProyecto->fuente['nombre']."</td>";
                                            if($value['compartida']==1){
                                                $c_v_i="Compartida";
                                                $c_v_i_id=$value['Id'];
                                            }elseif($value['vinculada']!=""){
                                                $c_v_i="Vinculada";
                                                $c_v_i_id=$value['vinculada'];
                                            }else{
                                                $c_v_i="Individual";
                                                $c_v_i_id="n.a";
                                            }
                                            $tabla=$tabla."<td>".$c_v_i."</td>";
                                            $tabla=$tabla."<td>".$c_v_i_id."</td>";
                                            $tabla=$tabla."<td>".$value['CodigosU']."</td>";
                                            $tabla=$tabla."<td>".$value->modalidad['Nombre']."</td>";
                                            $tabla=$tabla."<td>".$value->tipocontrato['Nombre']."</td>";

                                            if ($value['unidad_tiempo']==0){
                                                $uni_t = "Dias"; 
                                            }
                                            elseif($value['unidad_tiempo']==1){
                                                $uni_t = "Mes";
                                            }
                                            elseif($value['unidad_tiempo']==2){
                                                $uni_t = "Años";
                                            }
                                            else{
                                                $uni_t = "";
                                            }
                                            $tabla=$tabla."<td>".$value['DuracionContrato']." ".$uni_t."</td>";
                                            
                                            $tabla=$tabla."<td>".$value['VigenciaFutura']."</td>";
                                            $tabla=$tabla."<td>".$value['EstadoVigenciaFutura']."</td>";
                                            $tabla=$tabla."<td>".$value['FechaEstudioConveniencia']."</td>";
                                            $tabla=$tabla."<td>".$value['FechaInicioProceso']."</td>";
                                            $tabla=$tabla."<td>".$value['FechaSuscripcionContrato']."</td>";
                                            $tabla=$tabla."<td>".$value['RecursoHumano']."</td>";
                                            $tabla=$tabla."<td>".$value['NumeroContratista']."</td>";

                                        $tabla=$tabla."</tr>";
                                        $num++;
                                }                        
                            } 
                        
                                             
                $tabla=$tabla."</tbody>
                </table>";
                return response()->json(array('status' => 'ok', 'tabla' => $tabla));
            }
    }
	
}
