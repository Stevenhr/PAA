@extends('master')

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/planeacion.js') }}"></script>	
@stop

@section('content') 
<div id="main" class="content" data-url="aprobar">
	<div class="row">
		<div class="col-md-12">
			<p class="lead">
				<br>
				Seleccione la subdirección que desea consultar.
				<br>
				<br>
			</p>
		</div>
		<div class="col-md-12">
			<table id="TablaPAA" class="display responsive no-wrap table table-min" width="100%" cellspacing="0">
		        <thead>
		            <tr>
		                <th>N°</th>
		                <th class="info">ID</th>
						<th>Subdirección</th>
						<th>Area</th>
						<th>Códigos<br>UNSPSC</th>
						<th>Estado</th>
						<th>Modalidad<br>Selección</th>
						<th>Tipo<br>Contrato</th>
						<th>Descripción<br>Objeto</th>
						<th>Valor<br>Estimado</th>
						<th>Duración<br>Estimada (mes)</th>
						<!--<th>Fuente de los recursos <br> (Nombre de la Fuente (s))</th>-->
						<th>Valor estimado en <br> la vigencia actual</th>
						<th>¿Se requieren vigencias futuras?</th>
						<th>Estado de solicitud de vigencias futuras	</th>
						<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
						<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
						<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
						<th>Meta plan</th>
						<th>Recurso Humano (Si / No)</th>
						<th>Numero de Contratistas	</th>
						<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
						<th>Proyecto de inversión o rubro de funcionamiento</th>
						<th data-priority="2">Menú</th>
						<th style="width:30px;" data-priority="2" class="center"><input name="select_all" value="1" type="checkbox"></th>
		            </tr>
		        </thead>
				<tbody id="registros_actividades_responsable">
					<?php $var=1; ?>
					@foreach ($subdirecciones as $subdireccion)
    					@foreach ($subdireccion->areas as $area)
    						@if (count($area->paas))
    							@foreach ($area->paas as $paa)
    							<?php
		                        	$estado = '';
		                        	$clase = '';
		                        	switch ($paa['Estado']) 
		                        	{
		                        		case '4':
		                        			$estado = 'En subdirección';
		                        			$class = '';
		                        			break;
		                        		case '5':
		                        			$estado = 'En planeación';
		                        			$class = '';
		                        			break;
		                        		case '6':
		                        			$estado = 'Rechazado';
		                        			$class = 'warning';
		                        			break;
		                        		case '6':
		                        			$estado = 'Cancelado';
		                        			$class = 'danger';
		                        			break;
		                        	}
		                        ?>
									<tr data-row="{{ $paa['Id'] }}" class="{{ $class }}">
			    						<td scope="row" class="text-center">{{$var}}</th>
				                        <td class="info">{{$paa['Registro']}}</td>
				                        <td>{{$subdireccion['nombre']}}</td>
				                        <td>{{$area['nombre']}}</td>
				                        <td>{{$paa['CodigosU']}}</td>
				                        <td>
				                        	{{ $estado }}
				                        </td>
				                        <td>{{$paa->modalidad['Nombre']}}</td>
				                        <td>{{$paa->tipocontrato['Nombre']}}</td>
				                        <td><div style="width:500px;text-align: justify;">'{{$paa['ObjetoContractual']}}</div></td>
				                        <td>{{$paa['ValorEstimado']}}</td>
				                        <td>{{$paa['DuracionContrato']}}</td>
				                        <td>{{$paa['ValorEstimadoVigencia']}}</td>
				                        <td>{{$paa['VigenciaFutura']}}</td>
				                        <td>{{$paa['EstadoVigenciaFutura']}}</td>
				                        <td>{{ substr($paa['FechaEstudioConveniencia'], 0, 10) }}</td>
				                        <td>{{ substr($paa['FechaInicioProceso'], 0, 10) }}</td>
				                        <td>{{ substr($paa['FechaSuscripcionContrato'], 0, 10) }}</td>
				                        <td>{{$paa['MetaPlan']}}</td>
				                        <td>{{$paa['RecursoHumano']}}</td>
				                        <td>{{$paa['NumeroContratista']}}</td>
				                        <td>{{$paa['DatosResponsable']}}</td>
				                        <td>{{$paa->rubro['Nombre']}}</td>
				                        <td data-priority="2" align="right">
				                        	<div class="btn-group" style="width: 160px;">
												<div class="btn-group">
													<button type="button" data-rel="{{$paa['Registro']}}" data-toggle="tooltip" data-placement="bottom" data-funcion="Historial" class="btn btn-primary btn-xs2 btn-xs" title="Historial"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>
												</div>
												<div class="btn-group">
													<button type="button" data-rel="{{$paa['Id']}}" data-toggle="tooltip" data-placement="bottom" data-funcion="Financiacion" class="btn btn-success btn-xs2 btn-xs"  title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></button>
												</div>
												<div class="btn-group">
													<button type="button" data-rel="{{$paa['Id']}}" data-toggle="tooltip" data-placement="bottom" data-funcion="rechazar" class="btn btn-warning btn-xs2 btn-xs"  title="Rechazar"  {{ $paa['Estado'] != '4' ? 'disabled' : '' }} id="Btn_modal_rechazar"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span></button>
												</div>
												<div class="btn-group">
													<button type="button" data-rel="{{$paa['Id']}}" data-toggle="tooltip" data-placement="bottom" data-funcion="cancelar" class="btn btn-danger btn-xs2 btn-xs"  title="Cancelar"  {{ $paa['Estado'] != '4' ? 'disabled' : '' }} id="Btn_modal_cancelar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
												</div>
											</div>
				                        </td>
	                        			<td data-priority="2"></td>
			                        </tr>
    							@endforeach
    						@endif
    					@endforeach
					@endforeach
				</tbody>
				<tfoot>
		            <tr>
		            	<th>N°</th>
		                <th class="info">ID</th>
						<th>Subdirección</th>
						<th>Area</th>
						<th>Códigos<br>UNSPSC</th>
						<th>Estado</th>
						<th>Modalidad<br>Selección</th>
						<th>Tipo<br>Contrato</th>
						<th>Descripción<br>Objeto</th>
						<th>Valor<br>Estimado</th>
						<th>Duración<br>Estimada (mes)</th>
						<!--<th>Fuente de los recursos <br> (Nombre de la Fuente (s))	</th>-->
						<th>Valor estimado en <br> la vigencia actual	</th>
						<th>¿Se requieren vigencias futuras?	</th>
						<th>Estado de solicitud de vigencias futuras	</th>
						<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
						<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
						<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
						<th>Meta plan</th>
						<th>Recurso Humano (Si / No)</th>
						<th>Numero de Contratistas	</th>
						<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
						<th>Proyecto de inversión o rubro de funcionamiento</th>
						<th style="width:30px;" data-priority="2"></th>
						<th style="width:30px;" data-priority="2" class="center"></th>
		            </tr>
		        </tfoot>
		    </table>
		</div>
	</div>
</div>
@stop