@extends('master')

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/subdireccion.js') }}"></script>	
@stop

@section('content') 
<div id="main" class="content" data-url="aprobar">
	<div class="row">
		<div class="col-md-12">
			<table id="TablaPAA" class="display nowrap table table-min" width="100%" cellspacing="0">
		        <thead>
		            <tr>
		                <th>N°</th>
		                <th class="info">ID</th>
						<th>Códigos<br>UNSPSC</th>
						<th>Modalidad<br>Selección</th>
						<th>Tipo<br>Contrato</th>
						<th>Descripción<br>Objeto</th>
						<th>Valor<br>Estimado</th>
						<th>Duración<br>Estimada (mes)</th>
						<th>Fuente de los recursos <br> (Nombre de la Fuente (s))</th>
						<th>Valor estimado en <br> la vigencia actual</th>
						<th>¿Se requieren vigencias futuras?</th>
						<th>Estado de solicitud de vigencias futuras	</th>
						<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
						<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
						<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
						<th>Meta plan	</th>
						<th>Recurso Humano (Si / No)</th>
						<th>Numero de Contratistas	</th>
						<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
						<th>Proyecto de inversión o rubro de funcionamiento</th>
						<th style="width:30px;" data-priority="2"></th>
						<th style="width:30px;" data-priority="2" class="center"><input name="select_all" value="1" type="checkbox"></th>
		            </tr>
		        </thead>
		        <tbody id="registros_actividades_responsable">
		        	<?php $var=1; ?>
		        	@foreach($paas as $paa)						    
						<tr data-row="{{ $paa['Id'] }}">
    						<td scope="row" class="text-center">{{$var}}</th>
	                        <td class="info">{{$paa['Registro']}}</td>
	                        <td>{{$paa['CodigosU']}}</td>
	                        <td>{{$paa->modalidad['Nombre']}}</td>
	                        <td>{{$paa->tipocontrato['Nombre']}}</td>
	                        <td>{{$paa['ObjetoContractual']}}</td>
	                        <td>{{$paa['ValorEstimado']}}</td>
	                        <td>{{$paa['DuracionContrato']}}</td>
	                        <td>{{$paa['FuenteRecurso']}}</td>
	                        <td>{{$paa['ValorEstimadoVigencia']}}</td>
	                        <td>{{$paa['VigenciaFutura']}}</td>
	                        <td>{{$paa['EstadoVigenciaFutura']}}</td>
	                        <td>{{$paa['FechaEstudioConveniencia']}}</td>
	                        <td>{{$paa['FechaInicioProceso']}}</td>
	                        <td>{{$paa['FechaSuscripcionContrato']}}</td>
	                        <td>{{$paa['MetaPlan']}}</td>
	                        <td>{{$paa['RecursoHumano']}}</td>
	                        <td>{{$paa['NumeroContratista']}}</td>
	                        <td>{{$paa['DatosResponsable']}}</td>
	                        <td>{{$paa->rubro['Nombre']}}</td>
	                        <td data-priority="2" style="width: 130px; text-align: right;">
	                        	<div class="btn-group">
									<div class="btn-group">
										<button type="button" data-rel="{{$paa['Registro']}}" data-funcion="Historial" class="btn btn-primary btn-xs2 btn-xs" title="Historial"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>
									</div>
									<div class="btn-group">
										<button type="button" data-rel="{{$paa['Id']}}" data-funcion="Financiacion" class="btn btn-success btn-xs2 btn-xs"  title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></button>
									</div>
									<div class="btn-group">
										<button type="button" data-rel="{{$paa['Id']}}" data-funcion="Rechazar" class="btn btn-danger btn-xs2 btn-xs"  title="Rechazar" id="Btn_modal_rechazar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
									</div>
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
						<th>Modalidad<br>Selección</th>
						<th>Tipo<br>Contrato</th>
						<th>Descripción<br>Objeto</th>
						<th>Valor<br>Estimado</th>
						<th>Duración<br>Estimada (mes)</th>
						<th>Fuente de los recursos <br> (Nombre de la Fuente (s))	</th>
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
							<th>Meta</th>
							<th>Actividad</th>
							<th>Componente</th>
							<th>Fuente</th>
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
											<th>Fuente de los recursos (Nombre de la Fuente (s))	</th>
											<th>Valor total estimado	</th>
											<th>Valor estimado en la vigencia actual	</th>
											<th>¿Se requieren vigencias futuras?	</th>
											<th>Estado de solicitud de vigencias futuras	</th>
											<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
											<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
											<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
											<th>Duración estimada del contrato (meses)	</th>
											<th>Meta plan	</th>
											<th>Recurso Humano (Si / No)</th>
											<th>Numero de Contratistas	</th>
											<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
											<th>Proyecto de inversión o rubro de funcionamiento</th>
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
											<th>Fuente de los recursos (Nombre de la Fuente (s))	</th>
											<th>Valor total estimado	</th>
											<th>Valor estimado en la vigencia actual	</th>
											<th>¿Se requieren vigencias futuras?	</th>
											<th>Estado de solicitud de vigencias futuras	</th>
											<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
											<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
											<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
											<th>Duración estimada del contrato (meses)	</th>
											<th>Meta plan	</th>
											<th>Recurso Humano (Si / No)</th>
											<th>Numero de Contratistas	</th>
											<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
											<th>Proyecto de inversión o rubro de funcionamiento</th>
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
							<div class="panel-heading">Registros pendientes por revision</div>
							<div class="panel-body">
							    <p>Los siguientes registros estan pedintes de revision.</p>
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
											<th>Fuente de los recursos (Nombre de la Fuente (s))</th>
											<th>Valor total estimado</th>
											<th>Valor estimado en la vigencia actual</th>
											<th>¿Se requieren vigencias futuras?</th>
											<th>Estado de solicitud de vigencias futuras</th>
											<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
											<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)</th>
											<th>Fecha suscripción Contrato (dd/mm/aaaa)</th>
											<th>Duración estimada del contrato (meses)</th>
											<th>Meta plan</th>
											<th>Recurso Humano (Si / No)</th>
											<th>Numero de Contratistas</th>
											<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
											<th>Proyecto de inversión o rubro de funcionamiento</th>
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
<!--- modal eliminar -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
@stop