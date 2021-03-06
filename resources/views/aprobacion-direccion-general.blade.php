@extends('master')

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/direccionGeneral.js') }}"></script>	
@stop

@section('content') 
<div id="main" class="content" data-url="direccion">
	<div class="row">
		<div class="col-md-12">
			<p class="lead">
				Dirección General:
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
						
						<th>Recurso Humano (Si / No)</th>
						<th>Numero de Contratistas	</th>
						<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
						<th>Proyecto de inversión o rubro de funcionamiento</th>
						<th>Meta plan</th>
						<th data-priority="2">Menú</th>
		            </tr>
		        </thead>
				<tbody id="registros_actividades_responsable">
					<?php $var=0; ?>
					@foreach ($subdirecciones as $subdireccion)
    					@foreach ($subdireccion->areas as $area)
    						@if (count($area->paas))
    							@foreach ($area->paas as $paa)
    							<?php
		                        	$estado = '';
		                        	$class = '';
		                        	switch ($paa['Estado']) 
		                        	{
		                        		/*case '0':
		                        			$estado = 'En consolidación';
		                        			$class = '';
		                        			break;
		                        		case '4':
		                        			$estado = 'En subdirección';
		                        			$class = '';
		                        			break;
		                        		case '5':
		                        			$estado = 'Aprobado por subdirección';
		                        			$class = 'success';
		                        			break;
		                        		case '6':
		                        			$estado = 'Denegado por subdirección';
		                        			$class = 'warning';
		                        			break;
		                        		case '7':
		                        			$estado = 'Cancelado por subdirección';
		                        			$class = 'danger';
		                        			break;*/
		                        		case '9':
		                        			$estado = 'Estudio de conveniencia aprobado.';
		                        			$class = 'success';
		                        			$estudio = '';
		                        			break;
		                        		case '11':
		                        			$estado = 'Estudio de conveniencia cancelado.';
		                        			$class = 'danger';
		                        			$estudio = '';
		                        			break;
				                    }
		                        ?>


		                        	@if ($paa['compartida']>0)
	        							<?php $var0 = 'C'; ?>
							        @else
							        	<?php $var0 = ''; ?>
							        @endif


							        @if ($paa['vinculada']>0)
							            <?php $var1 = 'V'; ?>
							            <?php $var11 = $paa['vinculada']; ?>
							        @else
							        	<?php $var1 = ''; ?>
							        	<?php $var11 = ''; ?>
							        @endif

							 

					                @if ($paa->rubro_funcionamiento->count()>0 && $paa->componentes->count()>0)
	                                    <?php
	                                    $nomProyRubro="Areglar";//$paa->rubro_funcionamiento['nombre'];
	                                    $nombrementa="N.A";
	                                    $Proyecto1Rubro2="P-R";
	                                    ?>
									@elseif ($paa->componentes->count()>0)
	                                    <?php
	                                    $nomProyRubro=$paa->proyecto['Nombre'];
	                                    $nombrementa=$paa->meta['Nombre'];
	                                    $Proyecto1Rubro2="P";
	                                    ?>
	                                @elseif ($paa->rubro_funcionamiento->count()>0)
	                                    <?php
	                                    $nomProyRubro="";
	                                    $nombrementa="N.A";
	                                    $Proyecto1Rubro2="R";
	                                    ?>
									@endif


									<tr data-row="{{ $paa['Id'] }}" class="{{ $class }}">
			    						<td scope="row" class="text-center">{{++$var}}</th>
				                        <td class="text-center"><b><p class="text-info text-center" style="font-size: 15px">{{$paa['Registro']}}<BR>{{$var0}}{{$var1}}{{$var11}}<br>{{$Proyecto1Rubro2}}</b></p></td>
				                        <td>{{$subdireccion['nombre']}}</td>
				                        <td>{{$area['nombre']}}</td>
				                        <td>{{$paa['CodigosU']}}</td>
				                        <td><?php echo "<b>".$estado."</b>" ?></td>
				                        <td>{{$paa->modalidad['Nombre']}}</td>
				                        <td>{{$paa->tipocontrato['Nombre']}}</td>
				                        <td><div style="width:500px;text-align: justify; height: 100px; overflow-y: scroll;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); padding: 10px">'{{$paa['ObjetoContractual']}}</div></td>
				                        <td>{{number_format ($paa['ValorEstimado'])}}</td>
				                        <td>{{$paa['DuracionContrato']}}</td>
				                        <td>{{number_format ($paa['ValorEstimadoVigencia'])}}</td>
				                        <td>{{$paa['VigenciaFutura']}}</td>
				                        <td>{{$paa['EstadoVigenciaFutura']}}</td>
				                        <td>{{ substr($paa['FechaEstudioConveniencia'], 0, 10) }}</td>
				                        <td>{{ substr($paa['FechaInicioProceso'], 0, 10) }}</td>
				                        <td>{{ substr($paa['FechaSuscripcionContrato'], 0, 10) }}</td>
				                        <td>{{$paa['RecursoHumano']}}</td>
				                        <td>{{$paa['NumeroContratista']}}</td>
				                        <td>{{$paa['DatosResponsable']}}</td>
				                        <td>{{$nomProyRubro}}</td>
					                    <td>{{$nombrementa}}</td>
				                        <td data-priority="2" align="right">
				                        	<div class="btn-group" style="width: 160px;">
												<div class="btn-group">
													<button type="button" data-rel="{{$paa['Registro']}}" data-toggle="tooltip" data-placement="bottom" data-funcion="Historial" class="btn btn-primary btn-xs2 btn-xs" title="Historial"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>
												</div>
												<div class="btn-group">
													<button type="button" data-rel="{{$paa['Id']}}" data-toggle="tooltip" data-placement="bottom" data-funcion="Financiacion" class="btn btn-success btn-xs2 btn-xs"  title="Financiación" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></button>
												</div>
												<br>
												<div><a href="#" class="btn btn-xs btn-default" style="width: 100%; margin-top: 20px;" data-rel="{{$paa['Registro']}}" data-funcion="Observaciones"><span class="glyphicon glyphicon-info-sign"></span> Observaciones</a></div>
												<div><button type="button" data-rel="{{$paa['Id']}}" data-estado="{{$paa['Estado']}}" data-funcion="estudioConveniencia" class="btn btn-xs btn-success" style="width: 100%;margin-top: 2px;"  {{$estudio}}><span class="glyphicon glyphicon-info-sign"></span> Est. Conveniencia</button></div>
											</div>
				                        </td>
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
						<th>Valor estimado en <br> la vigencia actual</th>
						<th>¿Se requieren vigencias futuras?</th>
						<th>Estado de solicitud de vigencias futuras</th>
						<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
						<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
						<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
						<th>Meta plan</th>
						<th>Recurso Humano (Si / No)</th>
						<th>Numero de Contratistas	</th>
						<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
						<th>Proyecto de inversión o rubro de funcionamiento</th>
						<th style="width:30px;" data-priority="2"></th>
		            </tr>
		        </tfoot>
		    </table>
		</div>
	</div>
</div>
<!-- modal financiacion -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Financiacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Financiación PAA</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12">
				  		<table class="table table-bordered" id="datos_actividad" > 
						<thead>
						<tr>
						<th>#</th>
						<th>Proyecto</th>
						<th>Fuente</th>
						<th>Componente</th>
						<th>Valor</th>
						</tr>
						</thead>
						<tbody id="registrosFinanzas"> 
						</tbody> 
					</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- modal historial -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Historial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="myModalLabel">Historial de modificaciones</h4>
      		</div>
      		<div class="modal-body">
      			<div class="row">
					<div class="col-xs-12 col-sm-12">
						<div class="panel panel-success">
							<div class="panel-heading">Registro Vigente</div>
							<div class="panel-body">
							    <p>Registro que actualmente es valido para todos los usuarios.</p>
							</div>						 
							<div class="table-responsive">
								<table id="Tabla1" class="display nowrap table-bordered" width="780px" cellspacing="0">
							        <thead>
										<tr class="success">
								                <th>N°</th>
								                <th>Id Registro</th>
												<th>Códigos UNSPSC</th>
												<th>Modalidad de selección</th>
												<th>Tipo de contrato</th>
												<th>Descripción/Objeto</th>
												<th>Valor total estimado	</th>
												<th>Valor estimado en la vigencia actual	</th>
												<th>¿Se requieren vigencias futuras?	</th>
												<th>Estado de solicitud de vigencias futuras	</th>
												<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
												<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
												<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
												<th>Duración estimada del contrato (meses)	</th>
												<th>Recurso Humano (Si / No)</th>
												<th>Numero de Contratistas	</th>
												<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
												<th>Proyecto de inversión o rubro de funcionamiento</th>
												<th>Meta plan	</th>
								            </tr>
							        </thead>						       
							        <tbody id="registrosHtml">
							        </tbody>
								</table>
							</div>
						</div>
						<div id="mensaje_justi" class="alert alert-success" style="display: none"></div>
					</div>
					<div class="col-xs-12 col-sm-12">
						<hr>
					</div>
					<div class="col-xs-12 col-sm-12">
						<div class="panel panel-warning">
							<div class="panel-heading">Historial de registros</div>
							<div class="panel-body">
							    <p>Los siguientes registros son el historial de cambios aprobados por los difrentes usuarios durante el actual proceso.</p>
							</div>	
					  		<div class="table-responsive"> 
						  		<table id="Tabla2" class="display nowrap table-bordered" width="780px" cellspacing="0">
							        <thead>
										<tr class="success">
								                <th>N°</th>
								                <th>Id Registro</th>
												<th>Códigos UNSPSC</th>
												<th>Modalidad de selección</th>
												<th>Tipo de contrato</th>
												<th>Descripción/Objeto</th>
												<th>Valor total estimado	</th>
												<th>Valor estimado en la vigencia actual	</th>
												<th>¿Se requieren vigencias futuras?	</th>
												<th>Estado de solicitud de vigencias futuras	</th>
												<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
												<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
												<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
												<th>Duración estimada del contrato (meses)	</th>
												<th>Recurso Humano (Si / No)</th>
												<th>Numero de Contratistas	</th>
												<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
												<th>Proyecto de inversión o rubro de funcionamiento</th>
												<th>Meta plan	</th>
								            </tr>
							        </thead>	
							        <tbody id="registrosHtml1">
							        </tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12">
					 	<hr>
					</div>
					<div class="col-xs-12 col-sm-12">
						<div class="panel panel-danger">
							<div class="panel-heading">Registros pendientes por revisión</div>
							<div class="panel-body">
							    <p>Los siguientes registros están pendientes de revisión.</p>
							</div>	
							<div class="table-responsive"> 
						  		<table id="Tabla3" class="display nowrap table-bordered" width="780px" cellspacing="0">
							        <thead>
										<tr class="success">
							                <th>N°</th>
							                <th>Id Registro</th>
											<th>Códigos UNSPSC</th>
											<th>Modalidad de selección</th>
											<th>Tipo de contrato</th>
											<th>Descripción/Objeto</th>
											<th>Valor total estimado</th>
											<th>Valor estimado en la vigencia actual</th>
											<th>¿Se requieren vigencias futuras?</th>
											<th>Estado de solicitud de vigencias futuras</th>
											<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
											<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)</th>
											<th>Fecha suscripción Contrato (dd/mm/aaaa)</th>
											<th>Duración estimada del contrato (meses)</th>
											<th>Recurso Humano (Si / No)</th>
											<th>Numero de Contratistas</th>
											<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
											<th>Proyecto de inversión o rubro de funcionamiento</th>
											<th>Meta plan	</th>
							            </tr>
							        </thead>	
							        <tbody id="registrosHtml1">
							        </tbody>
								</table>
							</div>
						</div>
					</div>	
				</div>
      		</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      	</div>
    	</div>
  	</div>
</div>
<!-- modal observaciones -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Observaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Listado de observaciones</h4>
      </div>
      <form id="form_aprobacion">
	      <div class="modal-body">
	      			<div class="row">
						<div class="col-xs-12 col-sm-12">
							<div class="panel panel-warning">
							  <!-- Default panel contents -->
								<div class="panel-heading">Observaciones PAA N° <label class="NumPaa"></label></div>
								<div class="panel-body">
								    <table class="table table-bordered" id="datos_actividad" > 
										<thead>
										<tr>
										<th>#</th>
										<th>Usuario</th>
										<th>Observación</th>
										<th>Clase</th>
										<th>Fecha y Hora</th>
										</tr>
										</thead>
										<tbody id="registrosObser"> 
										</tbody> 
									</table>
								</div>		
							</div>
							<div class="form-group">
								    <textarea class="form-control" placeholder="Espacio para escribir observaciones.." name="observacio" id="observacio"></textarea>
							</div>
							<div class="form-group">
									<input type="hidden" name="paa_registro" id="paa_registro"></input>
								    <a href="#"  id="regisgtrar_observacion" class="btn btn-block btn-primary btn-success"><span class="glyphicon glyphicon-ok"></span> Agregar Observación</a>
							</div>
							<div id="mjs_Observa" class="alert alert-success" style="display: none"></div>
						</div>
					</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      </div>
      </form>
    </div>
  </div>
</div>

<form action="estudiopdf" id="estudiopdf_form">
        <input type="hidden" name="id_paa_estudio_f" id="id_paa_estudio_f"/>id_paa_estudio_f
</form>
@stop