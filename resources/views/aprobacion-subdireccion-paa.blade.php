@extends('master')

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/subdireccion.js?n=1') }}"></script>	
@stop

@section('content') 
<div id="main" class="content" data-url="aprobar">
	
	<div class="row">
		@foreach($paas as $paa_ob)	
			@foreach($paa_ob->observaciones as $observarcion)	
				@if(!$observarcion['check_subd'])
				<div class="col-xs-3 col-md-3">
            		<div class="alert alert-warning alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>¡Cuidado!</strong> Tienes observaciones pendientes en el paa N° <b>{{$observarcion['id_registro']}}</b>
					</div> 
				</div>
				@endif
			@endforeach
		@endforeach
	</div>

	<div class="row">
		<div class="col-md-12">
			<p class="lead">
				<br>
				Seleccione <small><span class="glyphicon glyphicon-check" aria-hidden="true"></span></small> los planes de adquisión que desea habilitar para el registro del Estudio de Coveniencia y luego haga click en el botón "Enviar".
				<br>
				<br>
			</p>
		</div>
		<div class="col-md-12" id="alertas">
			<p class="bg-success" style="display:none;">Los planes de adquisión fueron habilitados satisfactoriamente.</p>
			<p class="bg-danger" style="display:none;">Debe seleccionar al menos un plan de adquisición para enviar.</p>
		</div>
		<div class="col-md-12">
			<table id="TablaPAA" class="display responsive no-wrap table table-min" width="100%" cellspacing="0">
		        <thead>
		            <tr>
		                <th>N°</th>
		                <th class="info">ID</th>
						<th>Códigos<br>UNSPSC</th>
						<th>Estado</th>
						<th>Área</th>
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
						<th style="width:30px;" data-priority="2" class="center"><input name="select_all" value="1" type="checkbox"></th>
		            </tr>
		        </thead>
		        <tbody id="registros_actividades_responsable">
		        	<?php $var=1; ?>
		        	@foreach($paas as $paa)
                        <?php
                        	$estado = '';
                        	$clase = '';
                        	$estudio = '';
                        	switch ($paa['Estado']) 
                        	{
                        		case '0':
                        			$estado = 'En consolidación';
                        			$class = '';
                        			$estudio = 'disabled';
                        			break;
                        		case '4':
                        			$estado = 'Por Revisión';
                        			$class = '';
                        			$estudio = 'disabled';
                        			break;
                        		case '5':
                        			$estado = 'Aprobado por subdirección';
                        			$class = 'success';
                        			$estudio = '';
                        			break;
                        		case '6':
                        			$estado = 'Denegado por subdirección';
                        			$class = 'warning';
                        			$estudio = '';
                        			break;
                        		case '7':
                        			$estado = 'Cancelado por subdirección';
                        			$class = 'danger';
                        			$estudio = '';
                        			break;
                        		case '8':
                        			$estado = 'Estudio de conveniencia registrado.';
                        			$class = 'success';
                        			$estudio = '';
                        			break;
                        		case '9':
                        			$estado = 'Estudio de conveniencia aprobado.';
                        			$class = 'success';
                        			$estudio = '';
                        			break;
                        		case '10':
                        			$estado = 'Estudio de conveniencia con correcciones.';
                        			$class = 'warning';
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

				        <?php $nombrementa=""; 
	                          $nomProyRubro="";
	                          $Proyecto1Rubro2="";?>

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


						@if ($paa['unidad_tiempo']==0)
                            <?php $uni_t = "Dias"; ?>
						@elseif($paa['unidad_tiempo']==1)
                            <?php $uni_t = "Mes"; ?>
						@elseif($paa['unidad_tiempo']==2)
                            <?php $uni_t = "Años"; ?>
						@else
                            <?php $uni_t = ""; ?>
						@endif

						<tr data-row="{{ $paa['Id'] }}" class="{{ $class }}">
    						<td scope="row" class="text-center">{{$var}}</th>
	                        <td class="text-center"><b><p class="text-info text-center" style="font-size: 15px">{{$paa['Registro']}}<BR>{{$var0}}{{$var1}}{{$var11}}<br>{{$Proyecto1Rubro2}}</b></p></td>
	                        <td>{{$paa['CodigosU']}}</td>
	                        <td class="estado">
	                        	{{ $estado }}
	                        </td>
	                        <td>{{$paa->area['nombre']}} <br> <?php echo "<b>".$paa->persona['Primer_Nombre']." ".$paa->persona['Primer_Apellido']."" ?></td>
	                        <td>{{$paa->modalidad['Nombre']}}</td>
	                        <td>{{$paa->tipocontrato['Nombre']}}</td>
	                        <td><div style="width:500px;text-align: justify; height: 100px; overflow-y: scroll;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); padding: 10px">'{{$paa['ObjetoContractual']}}</div></td>
	                        <td>{{number_format ($paa['ValorEstimado'])}}</td>
	                        <td>{{$paa['DuracionContrato']}}  -  {{$uni_t}}</td>
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
										<button type="button" data-rel="{{$paa['Id']}}" data-toggle="tooltip" data-placement="bottom" data-funcion="Financiacion" class="btn btn-success btn-xs2 btn-xs"  title="Financiación"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></button>
									</div>
									<div class="btn-group">
										<button type="button" data-rel="{{$paa['Id']}}" data-toggle="tooltip" data-placement="bottom" data-funcion="rechazar" class="btn btn-warning btn-xs2 btn-xs"  title="Rechazar"  id="Btn_modal_rechazar"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span></button>
									</div>
									<div class="btn-group">
										<button type="button" data-rel="{{$paa['Id']}}" data-toggle="tooltip" data-placement="bottom" data-funcion="cancelar" class="btn btn-danger btn-xs2 btn-xs"  title="Cancelar"  id="Btn_modal_cancelar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
									</div>
									<br>
									<div><a href="#" class="btn btn-xs btn-default" style="width: 100%; margin-top: 20px;" data-rel="{{$paa['Registro']}}" data-funcion="Observaciones"><span class="glyphicon glyphicon-info-sign"></span> Observaciones</a></div>
									<div><button type="button" data-rel="{{$paa['Id']}}" data-estado="{{$paa['Estado']}}" data-funcion="estudioConveniencia" class="btn btn-xs btn-success" style="width: 100%;margin-top: 2px;"  {{$estudio}}><span class="glyphicon glyphicon-info-sign"></span> Est. Conveniencia</button></div>
									<div id=""></div>
								</div>
	                        </td>
	                        <td data-priority="2"></td>
                        </tr>
	                    <?php $var++; ?>
	                @endforeach
		        </tbody>
		        <tfoot>
		            <tr>
		            	<th>N°</th>
		                <th class="info">ID</th>
						<th>Códigos<br>UNSPSC</th>
						<th>Estado</th>
						<th>Área</th>
						<th>Modalidad<br>Selección</th>
						<th>Tipo<br>Contrato</th>
						<th>Descripción<br>Objeto</th>
						<th>Valor<br>Estimado</th>
						<th>Duración<br>Estimada (mes)</th>
						<!--<th>Fuente de los recursos <br> (Nombre de la Fuente (s))</th>-->
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
		    <b>C</b>= compartida   <b>V</b>= vinculada   
		    <br>
		    <b>P</b>= Proyecto de inversion   <b>R</b>= Rubro de funcionamiento
		</div>
		<div class="col-md-12">
			<hr>
		</div>
		<div class="col-md-12">
			<form id="envia_paa" action="{{ url('enviar/paa') }}" method="post">
				<input type="hidden" name="paas" value="">
				<input type="submit" value="Enviar" class="btn btn-primary" id="btn_env_subd">
			</form>
		</div>
	</div>
</div>
<!-- MODAL FIANANCIACION-->
	<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Financiacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-success" id="myModalLabel">Listado de Financiación Proyecto de Inversión.</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<table class="table table-bordered" id="datos_actividad2" >
								<thead class="thead-inverse table-success">
								<tr class="success">
									<th>#</th>
									<th>Proyecto de Inversión</th>
									<th>Fuente</th>
									<th>Componente</th>
									<th>Meta</th>
									<th>Valor</th>
								</tr>
								</thead>
								<tbody id="registrosFinanzas">
								</tbody>
							</table>
						</div>
					</div>
				</div>

     			<div class="row">
					<div class="col-xs-12 col-sm-12"><hr style="border-color: #178acc;"></div>
				</div>

     			 <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-warning" id="myModalLabel">Listado de Financiación Rubros de Funcionamiento.</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<table class="table table-bordered" id="datos_actividad3" >
								<thead class="thead-inverse">
								<tr class="warning">
									<th>#</th>
									<th>Rubro de funcionamiento.</th>
									<th>Fuente</th>
									<th>Valor</th>
								</tr>
								</thead>
								<tbody id="registrosFinanzasRubro">
								</tbody>
							</table>
						</div>
					</div>
				</div>      
			      <div class="modal-footer">
			      	<div class="row">
			        	<div class="col-xs-12 col-sm-12">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						</div>
			        </div>
			      </div>
    		</div>
  		</div>
	</div>


<!-- modal Estudio de conveniencia -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_EstudioConvenincia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Gestión del Estudio de Conveniencia</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-4 col-sm-4"></div>
					<div class="col-xs-4 col-sm-4">
					<form action="estudiopdf">
                            <input type="hidden" name="id_paa_estudio_f" id="id_paa_estudio_f"/>
							<center>Descargar Estudio<br><button type="submit" class="btn btn-link">
							<img class="img-responsive hidden-xs" src="{{ asset('public/Img/pdf.png') }}" width="106" height="106" alt=""/>
							</button></center>
					</form>
					</div>
					<div class="col-xs-4 col-sm-4"></div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12"><br><br></div>
				</div>
				<div class="row">
					<div class="col-xs-2 col-sm-2"></div>
					<div class="col-xs-8 col-sm-8">
					    	<label>Desea que esté estudio de conveniencia sea?</label><br>
					    	<input type="hidden" name="id_paa_estudio" id="id_paa_estudio"></input>
							<button type="button" class="btn btn-default btn-block" id="AprobadoEstudio">Aprobado</button>
							<button type="button" class="btn btn-default btn-block" id="CancelarEstudio">Cancelado</button>
							<button type="button" class="btn btn-default btn-block" id="devolverEstudio">Devuelto</button>
					</div>
					<div class="col-xs-2 col-sm-2"></div>
				</div>
				<div class="row">
					<div class="col-xs-2 col-sm-2"></div>
					<div class="col-xs-8 col-sm-8">
					    	<br>
					    	<label>Observaciones:</label><br>
					    	<textarea class="form-control" rows="3" id="observacionesEstudio" name="observacionesEstudio"></textarea>
					</div>
					<div class="col-xs-2 col-sm-2"></div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12"><br></div>
				</div>
				<div class="row">
					<div class="col-xs-2 col-sm-2"></div>
					<div class="col-xs-8 col-sm-8">
						<div id="mjs_Observa_estudio" class="alert alert-success" style="display: none"></div>
						<div id="mjs_Observa_mal" class="alert alert-danger" style="display: none"></div>
					</div>
					<div class="col-xs-2 col-sm-2"></div>
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
							    <p>Los siguientes registros están pendientes de revisin.</p>
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
<!--- modal rechazar -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_rechazar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Rechazar PAA</h4>
			</div>
			<form id="rechazar_paa" action="{{ url('rechazar/paa') }}" method="post">
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12">
				  			<div class="row">
				  				<div class="col-md-12 form-group">
				  					<label for="">Observaciones</label>
				  					<textarea name="Observaciones" class="form-control"></textarea>
				  				</div>
				  			</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="Id" value="">
					<input type="submit" class="btn btn-danger" value="Rechazar">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--- modal cancelar -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_cancelar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Cancelar PAA</h4>
			</div>
			<form id="cancelar_paa" action="{{ url('cancelar/paa') }}" method="post">
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12">
				  			<div class="row">
				  				<div class="col-md-12 form-group">
				  					<label for="">Observaciones</label>
				  					<textarea name="Observaciones" class="form-control"></textarea>
				  				</div>
				  			</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="Id" value="">
					<input type="submit" class="btn btn-danger" value="Cancelar">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</form>
		</div>
	</div>
</div>
@stop