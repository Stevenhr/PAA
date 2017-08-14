@extends('master')             

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/aprobar.js') }}"></script>	
@stop

@section('content') 
	<div class="content" id="main_paa_Aprobar" class="row" data-url="configuracionPaa" ></div>
    <div class="content">	
    	<div class="row">
			<div class="col-xs-12 col-md-12">
        		<hr><hr>
	        </div>
		    <div class="col-xs-12 col-md-12">
        		<h5>Listado de Proyectos de inversión:</h5>
	        </div>
		    <div class="col-xs-12 col-md-12">
		    	<div class="table-responsive" id="div_Tabla4">
			      		<table id="tb_componente" class="display responsive no-wrap table table-min"  width="100%" cellspacing="0">
				        <thead>
				            <tr>
				                <th class="text-center">N°</th>
				                <th>Plan Desarrollo</th>
				                <th>Vigencia</th>
				                <th>Código</th>
				                <th>Nombre Proyecto</th>
				                <th>SubDirección</th>
				                <th>Fecha inicial de implementación</th>
				                <th>Fecha final de implementación</th>
				                <th>Presupuesto</th>
				                <th>Opción</th>
				            </tr>
				        </thead>
				        <tfoot>
				            <tr>
				                <th class="text-center">N°</th>
				                <th>Plan Desarrollo</th>
				                <th>Vigencia</th>
				                <th>Código</th>
				                <th>Nombre Proyecto</th>
				                <th>SubDirección</th>
				                <th>Fecha inicial de implementación</th>
				                <th>Fecha final de implementación</th>
				                <th>Presupuesto</th>
				                <th>Opción</th>
				            </tr>
				        </tfoot>
				        <tbody i>
				        	<?php $var=1; ?>
				        	@foreach($proyectoDesarrollo as $proyectoDesarrollos)
			        			@if(count($proyectoDesarrollos->presupuestos )!=0)
				        		@foreach($proyectoDesarrollos->presupuestos as $presupuesto)

	        							@if(count($presupuesto->proyectos)!=0)
	        								@foreach($presupuesto->proyectos as $proyecto)
				        						@if($id_subdireccion==$proyecto['id_subdireccion'])
				        						<tr>
				        						<th scope="row" class="text-center">{{ $var }}</th>
				        						<td><h4>{{ $proyectoDesarrollos['nombre'] }}</h4></td>
				                                <td><h4>{{ $presupuesto['vigencia'] }}</h4></td>
						                        <td><h4>{{ $proyecto['codigo'] }}</h4></td>
						                        <td><h4>{{ $proyecto['Nombre'] }}</h4></td>
						                        <td><h4>{{ $proyecto->subDireccion['nombre'] }}</h4></td>
						                        <td>{{ $proyecto['fecha_inicio'] }}</td>
						                        <td>{{ $proyecto['fecha_fin'] }}</td>
						                        <td>{{ number_format($proyecto['valor']) }}</td>
						                        <td>
													<div class="btn-group btn-group-justified tama">
													  <div class="btn-group">
													    <button type="button" data-rel="{{ $proyecto['Id'] }}" data-nombre="{{ $proyecto['Nombre'] }}" data-funcion="Modal_Finanza_Fuente_compo" data-toggle="modal" data-target="#Modal_Finanza_Fuente_compo" data-tooltip="tooltip" data-placement="top" title="Fuente" class="btn btn-success btn-xs">F</button>
													  </div>
													  <div class="btn-group">
													    <button type="button" data-rel="{{ $proyecto['Id'] }}" data-nombre="{{ $proyecto['Nombre'] }}" data-funcion="Modal_Finanza_Componente" data-toggle="modal" data-target="#Modal_Finanza_Componente" data-tooltip="tooltip" data-placement="top" title="Componente"class="btn btn-success btn-xs">C</button>
													  </div>
													</div>
													<div id="espera{{ $proyecto['Id'] }}"></div>
						                        </td>
						                        </tr>
						                        <?php $var++; ?>
						                        @endIf
					                        @endforeach
					                     @EndIf

	        					@endforeach
	        					@endif
    						@endforeach
				        </tbody>
				    </table>
				</div>
    		</div>
    		<div class="col-xs-12 col-md-12">
        		<hr><hr>
	        </div>
		</div>
    </div>	




<!-- MODAL FUENTE -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Finanza_Fuente_compo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
		<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Fuentes registradas</h4>
	        Proyecto: <label id="id_Nom_proy_fin_f">
	    </div>

	    <form id="form_agregar_finanza_fuente">
	      	<div class="modal-body">
    			<div class="row">
    			    <div class="col-xs-12 col-md-12">
	            		<h5><b>Listado fuentes por proyecto:</b></h5>
			        </div>
				    <div class="col-xs-12 col-md-12">
				    	<div class="table-responsive" id="div_Tabla4">
					      		<table id="Tabla_fuentes_financia" class="display" width="100%" cellspacing="0">
						        <thead>
						            <tr>
						                <th class="text-center">N°</th>
						                <th>Fuente</th>
						                <th>Valor</th>
						               
						            </tr>
						        </thead>
						        <tfoot>
						             <tr>
						                <th class="text-center">N°</th>
						                <th>Fuente</th>
						                <th>Valor</th>

						            </tr>						       
						        </tfoot>
						        <tbody>
						        </tbody>
						    </table>
						</div>
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

      </form>

    </div>
  </div>
</div>





<!-- MODAL COMPONENTE-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Finanza_Componente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
		<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Ingreso de componentes</h4>
	        Proyecto: <label id="id_Nom_proy_fin_c">

	    </div>
	    <form id="form_agregar_finanza_componente">
			<div class="modal-body">
				<div class="row"  >
				   <div class="col-xs-12 col-sm-12">
				  		<div class="form-group">
					    	<h5><b>Ingreso de los componentes de financiación:</b></h5><br>
						</div>
				  </div>
				</div>
				<div class="row" >
				    <div class="col-xs-12 col-md-4">
				    	<div class="form-group">	
				    		<input type="hidden" name="id_proyect_fina_c" id="id_proyect_fina_c" >
				    		<label>Fuente</label>					
							<select class="form-control" name="id_componente_finza_f" id="id_componente_finza_f">
									<option value="">Seleccionar</option>
							</select>
						</div>
	        		</div>
	        		<div class="col-xs-12 col-md-4">
				    	<div class="form-group">	
				    		<label>Componente</label>					
							<select class="form-control" name="id_componente_finza_c" id="id_componente_finza_c">
									<option value="">Seleccionar</option>
									@foreach($componentes as $componente)
										<option value="{{ $componente['Id'] }}" >{{ $componente['codigo'] }} - {{ $componente['Nombre'] }}</option>
								    @endforeach
							</select>
						</div>
	        		</div>
	        		<div class="col-xs-12 col-md-4 ">
				    	<div class="form-group">	
				    		<label>Valor</label>					
							<input type="text" class="form-control" name="valor_componente_proyecto">
						</div>
	        		</div>
			    </div>
			    <div class="row"  >
				   <div class="col-xs-12 col-sm-12">
				  		<div class="form-group">
					    	<button class="btn btn-success" type="submit" id="agregar_finanza">Agregar</button>
					    	<button class="btn btn-danger" type="submit" id="cancelar_finanza" style="display: none;">Cancelar</button>
						</div>
				  </div>
				  <div class="col-xs-12 col-sm-12">
				  		<input type="hidden" name="id_finanza_fuenteCompoente_crear" id="id_finanza_fuenteCompoente_crear"  value="0" >
				  		<div id="mjs_registroFinanza_fuente_componente" style="display: none"></div>
				  </div>
				</div>
	      	</div>
	      	<hr>
	      	<hr>
	      	<div class="modal-body">
    			<div class="row">
    			    <div class="col-xs-12 col-md-12">
	            		<h5><b>Listado componentes por fuentes:</b></h5>
			        </div>
				    <div class="col-xs-12 col-md-12">
				    	<div class="table-responsive" id="div_Tabla4">
					      		<table id="Tabla_componentes_fuentes_financia" class="display" width="100%" cellspacing="0">
						        <thead>
						            <tr>
						                <th class="text-center">N°</th>
						                <th>Fuente</th>
						                <th>Componente</th>
						                <th>Valor</th>
						                <th>Opción</th>
						            </tr>
						        </thead>
						         <tfoot>
						             <tr>
						                 <th class="text-center">N°</th>
						                <th>Fuente</th>
						                <th>Componente</th>
						                <th>Valor</th>
						                <th>Opción</th>
						            </tr>						       
						        </tfoot>
						        <tbody>
						        </tbody>
						    </table>
						</div>
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
      </form>

    </div>
  </div>
</div>





@stop
