@extends('master')             


@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/paa.js') }}"></script>	
@stop

@section('content') 
        	<div class="content" id="main_paa_" class="row" data-url="paa" ></div>
            <div class="content">
            	<div class="row">
	            	<div class="col-xs-12 col-md-12 ">
				    	<br>
						<h4>Gestionar PAA</h4>
		            	<br>
		    		</div>

	                <div class="col-xs-12 col-md-12 text-">
				    	<div class="form-group">	
							<div class="btn-group" role="group" aria-label="...">
							  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Modal_AgregarNuevo">
							  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar nuevo
							  </button>

							  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Modal_AprobarCambios"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Aprobar cambios</button>
							  
							  <button type="button" class="btn btn-danger"data-toggle="modal" data-target="#Modal_Historiaeliminado"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Historial eliminados</button>
							</div>
						</div>
		    		</div>

				    <div class="col-xs-12 col-md-12 ">
				    	<hr style="border: 0; border-top: 2px solid #CEECF5; height:0;">
		    		</div>

	    			<div class="col-xs-12 col-md-12 ">
						<h4>Listado PAA</h4>
		            	<br>
		    		</div>
	    		</div>
            </div>


           
	            	
	            	
				    	
					      		<table id="TablaPAA"  class="display nowrap" width="100%" cellspacing="0">
						        <thead>
						            <tr>
						                <th>Id Registro</th>
										<th>Códigos UNSPSC</th>
										<th>Modalidad de selección</th>
										<th>Tipo de contrato</th>
										<th>Descripción/Objeto contractual</th>
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
										<th  data-priority="2">Menu</th>
						            </tr>
						        </thead>
						        <tfoot>
						            <tr>
						                <th>Id Registro</th>
										<th>Códigos UNSPSC</th>
										<th>Modalidad de selección</th>
										<th>Tipo de contrato</th>
										<th>Descripción/Objeto contractual</th>
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
										<th  data-priority="2">Menu</th>
						            </tr>
						        </tfoot>
						        <tbody id="registros_actividades_responsable">
			        						<tr>
			        						<th scope="row" class="text-center"></th>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td></td>
					                        <td>
												<div class="btn-group btn-group-justified">
												  <div class="btn-group">
												    <button type="button" data-rel="" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
												  </div>
												  <div class="btn-group">
												    <button type="button" data-rel="" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
												  </div>
												  <div class="btn-group">
												    <button type="button" data-rel="" data-funcion="ver_upd" class="btn btn-primary  btn-xs"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>
												  </div>
												</div>
												<div id=""></div>
					                        </td>
					                        </tr>
						        </tbody>
						    </table>
						
		    		


<!-- MODAL CREAR PAA-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_AgregarNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Crear PAA</h4>
      </div>
      <div class="modal-body">
        <form id="form_paa">
		        <div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Id Registro </label>
							<input type="text" class="form-control precio" name="id_registro">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Códigos UNSPSC </label>
							<input type="text" class="form-control precio" name="codigo_Unspsc">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<label>Modalidad de selección</label>
						<select class="form-control" name="modalidad_seleccion">
								<option value="" >Selecionar</option>
								@foreach($modalidades as $modalidad)
									<option value="{{ $modalidad['Id'] }}" >{{ $modalidad['Nombre'] }}</option>
							    @endforeach
						</select>
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
				  		<label>Fuente de los recursos (Nombre de la Fuente (s))</label>
						<input type="text" class="form-control precio" name="fuente_recurso">
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Valor total estimado </label>
							<input type="text" class="form-control precio" name="valor_estimado">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Valor estimado en la vigencia actual </label>
							<input type="text" class="form-control precio" name="valor_estimado_actualVigencia">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<label>¿Se requieren vigencias futuras?</label>
							<select class="form-control" name="vigencias_futuras">
								<option value="" >Selecionar</option>
								<option value="Si" >Si</option>
								<option value="No" >No</option>
							</select>
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
							<input type="text" class="form-control precio" name="estudio_conveniencia">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<label> Fecha estimada de inicio de proceso de selección</label>
						<input type="text" class="form-control precio" name="fecha_inicio">
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Fecha suscripción Contrato </label>
							<input type="text" class="form-control precio" name="fecha_suscripcion">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Duración estimada del contrato (meses)</label>
							<input type="text" class="form-control precio" name="duracion_estimada">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<label>Meta plan</label>
						<input type="text" class="form-control precio" name="meta_plan">
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Recurso Humano </label>
							<input type="text" class="form-control precio" name="recurso_humano">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Numero de Contratistas</label>
							<input type="text" class="form-control precio" name="numero_contratista">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					  		<label>Datos de contacto del responsable</label>
							<input type="text" class="form-control precio" name="datos_contacto">
						</div>
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Proyecto de inversión o rubro de funcionamiento </label>
							<select class="form-control" name="proyecto_inversion">
								<option value="" >Selecionar</option>
								@foreach($rubros as $rubro)
									<option value="{{ $rubro['Id'] }}" >{{ $rubro['Nombre'] }}</option>
							    @endforeach
							</select>
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-8">
				  		<div class="form-group">
					    	<label>Componente</label><br><br>
							<select class="form-control" name="componnente">
								<option value="" >Selecionar</option>
								@foreach($componentes as $componente)
									<option value="{{ $componente['Id'] }}" >{{ $componente['Nombre'] }}</option>
							    @endforeach
							</select>
						</div>
				  </div>
			
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button  type="submit" class="btn btn-success">Crear</button>
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






<!-- MODAL HISTORIAL ELIMINADOS-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Historiaeliminado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Historial Eliminados</h4>
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
@stop
