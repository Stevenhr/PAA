@extends('master')             

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/aprobar.js') }}"></script>	
@stop

@section('content') 
        	<div class="content" id="main_paa_Aprobar" class="row" data-url="aprobar" ></div>
            <div class="content">
            	<div class="row">
	            	<div class="col-xs-12 col-md-12 ">
				    	<br>
						<h4>Consolidación y aprobación PAA</h4>
		            	<br>
		    		</div>

	                <!--<div class="col-xs-12 col-md-12 text-">
				    	<div class="form-group">	
							<div class="btn-group" role="group" aria-label="...">
						
							  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Modal_AprobarCambios"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Aprobar cambios</button>
							  
							</div>
						</div>
		    		</div>-->

				    <div class="col-xs-12 col-md-12">
				    	<hr style="border: 0; border-top: 2px solid #CEECF5; height:0;">
		    		</div>
	    		
	            	<div class="col-xs-12 col-md-12">
				    	
					      		<table id="TablaPAA"  class="display nowrap table table-min" width="100%" cellspacing="0">
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
										<th>Fuente de los recursos (Nombre de la Fuente (s))	</th>
										<th>Valor estimado en la vigencia actual	</th>
										<th>¿Se requieren vigencias futuras?	</th>
										<th>Estado de solicitud de vigencias futuras	</th>
										<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
										<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
										<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
										<th>Meta plan	</th>
										<th>Recurso Humano (Si / No)</th>
										<th>Numero de Contratistas	</th>
										<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
										<th>Proyecto de inversión o rubro de funcionamiento</th>
										<th  data-priority="2">Menu</th>
						            </tr>
						        </thead>
						        <tfoot>
						            <tr>
						            	<th>N°</th>
						                <th><h4>ID</h4></th>
										<th>Códigos<br>UNSPSC</th>
										<th>Modalidad<br>Selección</th>
										<th>Tipo<br>Contrato</th>
										<th>Descripción<br>Objeto</th>
										<th>Valor<br>Estimado</th>
										<th>Duración<br>Estimada (mes)</th>
										<th>Fuente de los recursos (Nombre de la Fuente (s))	</th>
										<th>Valor estimado en la vigencia actual	</th>
										<th>¿Se requieren vigencias futuras?	</th>
										<th>Estado de solicitud de vigencias futuras	</th>
										<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
										<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
										<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
										<th>Meta plan	</th>
										<th>Recurso Humano (Si / No)</th>
										<th>Numero de Contratistas	</th>
										<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
										<th>Proyecto de inversión o rubro de funcionamiento</th>
										<th  data-priority="2">Menu</th>
						            </tr>
						        </tfoot>
						        <tbody id="registros_actividades_responsable">
						        	<?php $var=1; ?>
						        	@foreach($paas as $paa)						    
			        						<tr>
			        						<th scope="row" class="text-center">{{$var}}</th>
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
					                  
					                        <td>
												<div class="btn-group tama">
												  <div class="btn-group">
												    <button type="button" data-rel="{{$paa['Registro']}}" data-funcion="Historial" class="btn btn-primary  btn-xs2 btn-xs" title="Historial"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>
												  </div>
												  <div class="btn-group">
												    <button type="button" data-rel="{{$paa['Id']}}" data-funcion="Financiacion" class="btn btn-success btn-xs2 btn-xs"  title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></button>
												  </div>
												  <div class="btn-group">
												    <button type="button" data-rel="{{$paa['Id']}}" data-funcion="Aprobacion" class="btn btn-warning btn-xs2 btn-xs"  title="Aprobar Cambios" id="Btn_modal_Aprobacion"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></button>
												  </div>
												  <div class="btn-group">
												    <button type="button" data-rel="{{$paa['Id']}}" data-funcion="AprobacionFinal" class="btn btn-default btn-xs2 btn-xs"  title="Aprobación Final" id="Btn_modal_Aprobacion"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
												  </div>
												  <?php $var = 0; ?>
												  @foreach($paas2 as $paa2)	
											  		@if($paa2['Registro']==$paa['Registro'])
											  			<?php $var = 1; ?>
											  		@endif

												  @endforeach

												  @if($var==1)
												  <div class="btn-group">
												  	  <button type="button" data-rel="{{$paa['Id']}}" data-funcion="AprobacionFinal" class="btn btn-danger btn-xs2 btn-xs"  title="Cambios Pendientes" disabled><span class="glyphicon glyphicon-alert" aria-hidden="true"></span></button>
												  </div>
												  @endif
												</div>
												<div id=""></div>
					                        </td>
					                        </tr>
					                        <?php $var++; ?>
					                @endforeach
						        </tbody>
						    </table>
					</div>
					<div class="col-xs-12 col-md-12 ">
		            	<br><br><br>
		    		</div>
		    	</div>
            </div>	


<!-- MODAL CREAR PAA-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_AgregarNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CREAR PAA</h4>
      </div>
      <div class="modal-body">
        <form id="form_paa">
        
        		<input type="hidden" class="form-control" name="id_Paa" value="0">
        		<input type="hidden" class="form-control" name="id_registro" value="0">
		        <div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Códigos UNSPSC </label>
							<input type="text" class="form-control" name="codigo_Unspsc">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					  		<label>Modalidad de selección</label>
							<select class="form-control" name="modalidad_seleccion">
									<option value="" >Selecionar</option>
									@foreach($modalidades as $modalidad)
										<option value="{{ $modalidad['Id'] }}" >{{ $modalidad['Nombre'] }}</option>
								    @endforeach
							</select>
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Tipo de contrato </label>
							<select class="form-control" name="tipo_contrato">
								<option value="" >Selecionar</option>
								@foreach($tipoContratos as $tipoContrato)
									<option value="{{ $tipoContrato['Id'] }}" >{{ $tipoContrato['Nombre'] }}</option>
							    @endforeach
							</select>
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Descripción/Objeto contractual </label>
							<textarea class="form-control" rows="2" id="comment" name="objeto_contrato"></textarea>
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					  		<label>Fuente de los recursos (Nombre de la Fuente (s))</label>
							<input type="text" class="form-control" name="fuente_recurso">
						</div>
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Valor total estimado </label>
							<input type="text" class="form-control" name="valor_estimado">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Valor estimado en la vigencia actual </label>
							<input type="text" class="form-control" name="valor_estimado_actualVigencia">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">	
				  			<label>¿Se requieren vigencias futuras?</label>
							<select class="form-control" name="vigencias_futuras">
								<option value="" >Selecionar</option>
								<option value="Si" >Si</option>
								<option value="No" >No</option>
							</select>
						</div>
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Estado de solicitud de vigencias futuras </label>
							<select class="form-control" name="estado_solicitud">
								<option value="">Seleccionar</option>
								<option value="NO SOLICITADAS">NO SOLICITADAS</option>
								<option value="SI SOLICITADAS">SI SOLICITADAS</option>
								<option value="N/A">N/A</option>
							</select>
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Estudio de  conveniencia </label><br><br>
							<input type="text" class="form-control" name="estudio_conveniencia" data-role="datepicker" placeholder="aa/mm/dd">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					  		<label> Fecha estimada de inicio de proceso de selección</label>
							<input type="text" class="form-control" name="fecha_inicio"  data-role="datepicker" placeholder="aa/mm/dd">
						</div>
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Fecha suscripción Contrato </label>
							<input type="text" class="form-control" name="fecha_suscripcion"  data-role="datepicker" placeholder="aa/mm/dd">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Duración estimada del contrato (meses)</label>
							<input type="text" class="form-control" name="duracion_estimada">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					  		<label>Meta plan</label>
							<input type="text" class="form-control" name="meta_plan">
						</div>
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Recurso Humano </label>
							<select class="form-control" name="recurso_humano">
								<option value="" >Selecionar</option>
								<option value="Si" >Si</option>
								<option value="No" >No</option>
							</select>
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Numero de Contratistas</label>
							<input type="text" class="form-control" name="numero_contratista">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					  		<label>Datos de contacto del responsable</label>
							<input type="text" class="form-control" name="datos_contacto">
						</div>
				  </div>
				</div>
				<div id="div_finaciacion">
				<div class="row">
				  	<div class="col-xs-12 col-sm-12">
				  	<hr>
				  		<h4 class="modal-title" id="myModalLabel">AGREGAR FINANCIACIÓN</h4>
					</div>
				</div>

				<div class="row">
				  <div class="col-xs-12 col-sm-12">
				  		<div class="form-group">
					    	<label>Proyecto de inversión o rubro</label>
					    	<input type="hidden" name="id_pivot_comp" id="id_pivot_comp"></input>
							<select class="form-control" name="Proyecto_inversion" id="Proyecto_inversion">
								<option value="" >Selecionar</option>
								@foreach($proyectos as $proyecto)
									<option value="{{ $proyecto['Id'] }}" >{{ $proyecto['Nombre'] }}</option>
							    @endforeach
							</select>
						</div>
				  </div>
				  <div class="col-xs-12 col-sm-12">
				  		<div class="form-group">
					    	<label>COMPONENTES DEL GASTO</label>
							<select class="form-control" name="componnente" id="componnente">
								<option value="" >Selecionar</option>
							</select>
						</div>
				  </div>
				  <div class="col-xs-12 col-sm-4">
				  	<div class="form-group">
					  		<label>Valor</label>
							<input type="text" class="form-control" name="valor_contrato">
					</div>
				  </div>
				</div>

				<div class="row">
				  	<div class="col-xs-12 col-sm-12">
				  		<button type="button" class="btn btn-primary" id="agregarFinanciacion">Agregar</button>
        				<button  type="button" class="btn btn-info" id="VerAgregarFinanciacion">Ver</button>
					</div>
					<div class="col-xs-12 col-sm-12">
        				<div class="form-group"  id="mensaje_actividad" style="display: none;">
        					<div id="alert_actividad"></div>
        				</div>
				  	<hr>
					</div>
					<div class="col-xs-12 col-sm-12">
				  		<table class="table table-bordered" id="datos_actividad" > 
							<thead>
							<tr>
							<th>#</th>
							<th>Proyecto</th>
							<th>Componente</th>
							<th>Valor</th>
							<th>Eliminar</th>
							</tr>
							</thead>
							<tbody id="registros"> 
							</tbody> 
						</table>
					</div>
				</div>
				</div>
      </div>
      <div class="modal-footer">
        <div id="mjs_registroPaa" class="alert alert-success" style="display: none"></div>
        <input type="hidden" name="Dato_Actividad" class="form-control">
        <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
        <button  type="submit" class="btn btn-success" id="crear_paa_btn">CREAR</button>
      </div>
     </form>

    </div>
  </div>
</div>





<!-- MODAL APROBAR CAMBIOS-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_AprobarCambios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Aprobar Cambios</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success">Crear</button>
      </div>
    </div>
  </div>
</div>






<!-- MODAL FIANANCIACION-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_AprobarCambios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Aprobar Cambios</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success">Crear</button>
      </div>
    </div>
  </div>
</div>


<!-- MODAL FIANANCIACION-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_AprobarCambios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Aprobar Cambios</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success">Crear</button>
      </div>
    </div>
  </div>
</div>



<!-- MODAL FIANANCIACION-->
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
							<th>Eliminar</th>
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


<!-- MODAL FIANANCIACION-->
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
						  <!-- Default panel contents -->
							<div class="panel-heading">Registro Vigente</div>
							<div class="panel-body">
							    <p>Registro que actualmente es valido para todos los usuarios.</p>
							</div>						 
							<div class="table-responsive">
								<table  id="Tabla1" class="display nowrap table-bordered" width="780px" cellspacing="0">
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
						  <!-- Default panel contents -->
							<div class="panel-heading">Historial de registros</div>
							<div class="panel-body">
							    <p>Los siguientes registros son el historial de cambios aprobados por los difrentes usuarios durante el actual proceso.</p>
							</div>	
					  		<div class="table-responsive"> 
						  		<table  id="Tabla2" class="display nowrap table-bordered" width="780px" cellspacing="0">
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
						  <!-- Default panel contents -->
							<div class="panel-heading">Registros pendientes por revision</div>
							<div class="panel-body">
							    <p>Los siguientes registros estan pedintes de revision.</p>
							</div>	
							<div class="table-responsive"> 
						  		<table  id="Tabla3" class="display nowrap table-bordered" width="780px" cellspacing="0">
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
        <button type="button" class="btn btn-success">Crear</button>
      </div>
    </div>
  </div>
</div>


<!-- MODAL EDITAR-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Formulario Editable</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success">Crear</button>
      </div>
    </div>
  </div>
</div>



<!-- MODAL ELIMINAR-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar PAA</h4>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="idRegist_inpt"></input>
      	<div >Desea eliminar el PAA con numero de registro: <label id="idRegist"></label> ?</div>
      	<div id="mjs_ElimRegistro" class="alert alert-success" style="display: none"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger" id="ElimianrPAA_btn">Eliminar</button>
      </div>
    </div>
  </div>
</div>


<!-- MODAL HISTORIAL DE ELIMIANCION-->

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_HistorialEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Historial de Eliminación</h4>
      </div>
      <div class="modal-body">
      		<div class="row">
      			<div class="col-xs-12 col-sm-12">
					<div class="panel panel-danger">
						<div class="panel-heading">Historial de Registros Eliminados</div>
						<div class="panel-body">
						    <p>Los siguientes registros estan en estado eliminado.</p>
						</div>	
						<div class="table-responsive"> 
					  		<table  id="Tabla4" class="display nowrap table-bordered" width="780px" cellspacing="0">
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
      		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success">Crear</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL APRIOBACION CAMBIOS-->

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_AprobarCambiosH" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Historial de modificaciones</h4>
      </div>
      <form id="form_aprobacion">
	      <div class="modal-body">
	      			<div class="row">
						<div class="col-xs-12 col-sm-12">
							<div class="panel panel-warning">
							  <!-- Default panel contents -->
								<div class="panel-heading">Aprobación de cambios</div>
								<div class="panel-body">
								    <p>Registro que actualmente es valido para todos los usuarios.</p>
								</div>						 
								<div class="table-responsive">
									<table  id="Tabla5" class="display nowrap cell-border compact" width="100%" cellspacing="0">
									        <thead>
												<tr class="success">
									                <th>N°</th>
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
									        <tbody>
									        </tbody>
									</table>
								</div>
								<br><br>
							</div>
							<div id="mensaje_aprobacion" class="alert alert-success" style="display: none"></div>
						</div>
					</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-success">Aprobar</button>
	      </div>
      </form>
    </div>
  </div>
</div>


<!-- MODAL APRIOBACION CAMBIOS-->

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_AprobarCambiosFinal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Paso a Sub Dirección</h4>
      </div>
      <form id="form_aprobacion">
	      <div class="modal-body">
	      			<div class="row">
						<div class="col-xs-12 col-sm-12">
							<div class="panel panel-warning">
							  <!-- Default panel contents -->
								<div class="panel-heading">Aprobación final de PAA N° <label class="NumPaa"></label></div>
								<div class="panel-body">
								    <p>La aprobación final del PAA da paso a la sub dirección de aprobar o denegar el PAA N° <label class="NumPaa"></label>. Ya no podra realizar cambios mientras este en la sub dirección.</p>
								    <div class="text-center"><button type="submit" id="aprobacion_Sub_Direccion" class="btn btn-success">Enviar a Sub Dirección</button></div>
								</div>						 
							</div>
							<input type="hidden" name="paa_subDirecion" id="paa_subDirecion"></input>
							<div id="mensaje_aprobacion_final" class="alert alert-success" style="display: none"></div>
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

@stop
