@extends('master')             

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/configuracion.js') }}"></script>	
@stop


@section('content') 
        
            <div class="content" id="main_paa_configuracion" class="row" data-url="configuracionPaa" >
            	
            	<div class="btn-group btn-group-justified">
					  <a href="#" class="btn btn-primary" id="Presupuesto" data-role="Presupuesto">Presupuesto</a>
					  <a href="#" class="btn btn-primary" id="Proyecto">Proyecto</a>
					  <a href="#" class="btn btn-primary" id="Meta">Meta</a>
					  <a href="#" class="btn btn-primary" id="Actividad">Actividad</a>
					  <a href="#" class="btn btn-primary" id="Componente">Componente</a>
				</div>
				
				
				<br>
				

				<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  PRESUPUESTO  %%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
				<div id="Presupuesto_dv" style="display:none;">
					
					<h3>Presupuesto</h3>
					<hr style="border: 0; border-top: 1px solid #F6CECE; height:0;">
	            	<br>
	                <p class="text-justify">Registro del prresupuesto total de los proyectos..</p>
			        <br>
			        <form id="form_presupuesto">
			            <div id="div_form_presupuesto"><br></div>
				        <div class="row" >

						    <div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Nombre</label>
						    		<input type="hidden" class="form-control" name="Id_presupuesto" value="0">
									<input type="text" class="form-control" name="nombre_presupuesto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker" name="fecha_inicial_presupuesto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
			        			<div class="form-group">
			        				<label>Fecha final de implementación</label>
									<input type="text" class="form-control" data-role="datepicker" name="fecha_final_presupuesto">
								</div>
			        		</div>

			        		<div class="col-xs-12 col-md-3 ">
			        			<div class="form-group">
			        				<label>Valor </label>
									<input type="text" class="form-control precio" name="precio">
								</div>
			        		</div>
						</div>

						<div class="row">
						    <div class="col-xs-12 col-md-4">
			        		</div>
						    <div class="col-xs-12 col-md-4 text-center"><br>
						    		<div class="alert alert-success" style="display:none;" id="mensaje_presupuesto">
									  <strong>Bien!</strong> Registro creado con exíto.
									</div>
									<div class="alert alert-danger" style="display:none;" id="mensaje_presupuesto2"></div>
									<button class="btn btn-primary" type="submit" id="id_btn_presupuesto">Registrar</button>
									<button class="btn btn-danger" type="submit" id="id_btn_presup_canc" style="display:none;">Cancelar</button>
			        		</div>
			        		<div class="col-xs-12 col-md-4">
			        		</div>
						</div>
					</form>

					
	            	<br>

            			<div class="row">
            				<div class="col-xs-12 col-md-12">
			            		<hr><hr>
					        </div>
            			    <div class="col-xs-12 col-md-12">
			            		<h5>Listado de Presupuestos:</h5>
					        </div>
						    <div class="col-xs-12 col-md-12">
						    	<div class="table-responsive" id="div_Tabla3">
							      		<table id="Tabla3" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Nombre Presupuesto</th>
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Nombre Presupuesto</th>
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </tfoot>
								        <tbody id="registros_actividades_responsable">
								        		<?php $var=1; ?>
								        		@foreach($presupuesto as $presupuestos)
					        						<tr>
					        						<th scope="row" class="text-center">{{ $var }}</th>
							                        <td><h4>{{ $presupuestos['Nombre_Actividad'] }}</h4></td>
							                        <td>{{ $presupuestos['fecha_fin'] }}</td>
							                        <td>{{ $presupuestos['fecha_inicio'] }}</td>
							                        <td>{{ $presupuestos['presupuesto'] }}</td>
							                        <td>
														<div class="btn-group btn-group-justified">
														  <div class="btn-group">
														    <button type="button" data-rel="{{ $presupuestos['Id'] }}" data-funcion="ver_eli" class="btn btn-default btn-xs">Eliminar</button>
														  </div>
														  <div class="btn-group">
														    <button type="button" data-rel="{{ $presupuestos['Id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs">Modificar</button>
														  </div>
														</div>
														<div id="espera{{ $presupuestos['Id'] }}"></div>
							                        </td>
							                        </tr>
							                        <?php $var++; ?>
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


		        <!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  PROYECTO  %%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
				<div id="Proyecto_dv" style="display:none;">
					<h3>Proyecto</h3>
					<hr style="border: 0; border-top: 1px solid #81DAF5; height:0;">
	            	<br>
	                <p class="text-justify">Registro de proyectos.</p>
			        <br>
			        <form id="form_proyecto">
			            <div id="div_form_presupuesto"><br></div>
				        <div class="row" >
						    
				        	<div class="col-xs-12 col-md-2 text-">
						    	<div class="form-group">	
						    		<label>Presupuesto</label>
									<select class="form-control" name="idPresupuesto">
											<option value="">Seleccionar</option>
										@foreach($presupuesto as $presupuestos)
											<option value="{{ $presupuestos['Id'] }}" >{{ $presupuestos['Nombre_Actividad'] }}</option>
									    @endforeach
									</select>
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-2 text-">
						    	<div class="form-group">	
						    		<label>Nombre</label>
						    		<input type="hidden" class="form-control" name="Id_proyecto" value="0">
									<input type="text" class="form-control" name="nombre_proyecto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker" name="fecha_inicial_proyecto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
			        			<div class="form-group">
			        				<label>Fecha final de implementación</label>
									<input type="text" class="form-control" data-role="datepicker" name="fecha_final_proyecto">
								</div>
			        		</div>

			        		<div class="col-xs-12 col-md-2 ">
			        			<div class="form-group">
			        				<label>Valor </label>
									<input type="text" class="form-control precio" name="precio_proyecto">
								</div>
			        		</div>
						</div>

						<div class="row">
						    <div class="col-xs-12 col-md-4">
			        		</div>
						    <div class="col-xs-12 col-md-4 text-center"><br>
						    		<div class="alert alert-success" style="display:none;" id="mensaje_proyecto"></div>
						    		<div class="alert alert-danger" style="display:none;" id="mensaje_proyecto2"></div>
									<button class="btn btn-primary" type="submit" id="id_btn_proyecto">Registrar</button>
									<button class="btn btn-danger" type="submit" id="id_btn_proyect_canc" style="display:none;">Cancelar</button>
			        		</div>
			        		<div class="col-xs-12 col-md-4">
			        		</div>
						</div>
					</form>


	            	<br>

            			<div class="row">
            				<div class="col-xs-12 col-md-12">
			            		<hr><hr>
					        </div>
            			    <div class="col-xs-12 col-md-12">
			            		<h5>Listado de Proyectos:</h5>
					        </div>
						    <div class="col-xs-12 col-md-12">
						    	<div class="table-responsive" id="div_Tabla4">
							      		<table id="Tabla4" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Presupuesto</th>
								                <th>Nombre Proyecto</th>
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Presupuesto</th>
								                <th>Nombre Proyecto</th>
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </tfoot>
								        <tbody i>
								        		<?php $var=1; ?>

								        		@foreach($presupuesto as $presupuestos)
					        							
					        							@if(count($presupuestos->proyectos)!=0)
					        								@foreach($presupuestos->proyectos as $proyecto)
								        						<tr>
								        						<th scope="row" class="text-center">{{ $var }}</th>
								        						<th scope="row">{{ $presupuestos['Nombre_Actividad'] }}</th>
										                        <td><h4>{{ $proyecto['Nombre'] }}</h4></td>
										                        <td>{{ $proyecto['fecha_inicio'] }}</td>
										                        <td>{{ $proyecto['fecha_fin'] }}</td>
										                        <td>{{ $proyecto['valor'] }}</td>
										                        <td>
																	<div class="btn-group btn-group-justified">
																	  <div class="btn-group">
																	    <button type="button" data-rel="{{ $proyecto['Id'] }}" data-funcion="ver_eli" class="btn btn-default btn-xs">Eliminar</button>
																	  </div>
																	  <div class="btn-group">
																	    <button type="button" data-rel="{{ $proyecto['Id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs">Modificar</button>
																	  </div>
																	</div>
																	<div id="espera{{ $proyecto['Id'] }}"></div>
										                        </td>
										                        </tr>
										                        <?php $var++; ?>
									                        @endforeach
									                     @EndIf

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


		        <!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% META %%%%%%%%%%%%%%%%%%%%%%%%% -->
		        <div id="Meta_dv" style="display:none;">

					<h3>Meta</h3>
					<hr style="border: 0; border-top: 1px solid #81DAF5; height:0;">
	            	<br>
	                <p class="text-justify">Registro de metas.</p>
			        <br>

			        <form id="form_metas">
			            <div id="div_form_metas"><br></div>
				        
				        <div class="row" >
				        	<div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Presupuesto</label>
									<select class="form-control" name="idPresupuesto_M">
											<option value="">Seleccionar</option>
										@foreach($presupuesto as $presupuestos)
											<option value="{{ $presupuestos['Id'] }}" >{{ $presupuestos['Nombre_Actividad'] }}</option>
									    @endforeach
									</select>
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Proyecto</label>
									<select class="form-control" name="idProyecto_M">
											<option value="">Seleccionar</option>
									</select>
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
			        		</div>

						</div>

						<div class="row" >
						    <div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Nombre</label>
						    		<input type="hidden" class="form-control" name="Id_meta" value="0">
									<input type="text" class="form-control" name="nombre_meta">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker" name="fecha_inicial_meta">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
			        			<div class="form-group">
			        				<label>Fecha final de implementación</label>
									<input type="text" class="form-control" data-role="datepicker" name="fecha_final_meta">
								</div>
			        		</div>

			        		<div class="col-xs-12 col-md-3 ">
			        			<div class="form-group">
			        				<label>Valor </label>
									<input type="text" class="form-control precio" name="precio_meta">
								</div>
			        		</div>
						</div>

						<div class="row">
						    <div class="col-xs-12 col-md-4">
			        		</div>
						    <div class="col-xs-12 col-md-4 text-center"><br>
						    		<div class="alert alert-success" style="display:none;" id="mensaje_meta"></div>
						    		<div class="alert alert-danger" style="display:none;" id="mensaje_meta2"></div>
									<button class="btn btn-primary" type="submit" id="id_btn_meta">Registrar</button>
									<button class="btn btn-danger" type="submit" id="id_btn_meta_canc" style="display:none;">Cancelar</button>
			        		</div>
			        		<div class="col-xs-12 col-md-4">
			        		</div>
						</div>
					</form>

	            	<br>

            			<div class="row">
            				<div class="col-xs-12 col-md-12">
			            		<hr><hr>
					        </div>
            			    <div class="col-xs-12 col-md-12">
			            		<h5>Listado de Metas:</h5>
					        </div>
						    <div class="col-xs-12 col-md-12">
						    	<div class="table-responsive" id="div_Tabla4">
							      		<table id="Tabla5" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Presupuesto</th>
								                <th>Proyecto</th>
								                <th>Nombre Proyecto</th>
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Presupuesto</th>
								                <th>Proyecto</th>
								                <th>Nombre Proyecto</th>
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </tfoot>
								        <tbody i>
								        		<?php $var=1; ?>

								        		@foreach($presupuesto as $presupuestos)
					        							
					        							@if(count($presupuestos->proyectos)!=0)
				        								@foreach($presupuestos->proyectos as $proyecto)
					        								    
					        								    @if(count($proyecto->metas)!=0)
					        								    @foreach($proyecto->metas as $meta)
									        						<tr>
									        						<th scope="row" class="text-center">{{ $var }}</th>
									        						<th scope="row">{{ $presupuestos['Nombre_Actividad'] }}</th>
									        						<th scope="row">{{ $proyecto['Nombre'] }}</th>
											                        <td><h4>{{ $meta['Nombre'] }}</h4></td>
											                        <td>{{ $meta['fecha_inicio'] }}</td>
											                        <td>{{ $meta['fecha_fin'] }}</td>
											                        <td>{{ $meta['valor'] }}</td>
											                        <td>
																		<div class="btn-group btn-group-justified">
																		  <div class="btn-group">
																		    <button type="button" data-rel="{{ $meta['Id'] }}" data-funcion="ver_eli" class="btn btn-default btn-xs">Eliminar</button>
																		  </div>
																		  <div class="btn-group">
																		    <button type="button" data-rel="{{ $meta['Id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs">Modificar</button>
																		  </div>
																		</div>
																		<div id="espera{{ $meta['Id'] }}"></div>
											                        </td>
											                        </tr>
											                        <?php $var++; ?>
									                        	@endforeach
									                        	@EndIf

								                         @endforeach
									                     @EndIf

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


		        <div id="Actividad_dv" style="display:none;">
					<h3>Actividad</h3>
					<hr style="border: 0; border-top: 1px solid #642EFE; height:0;">
	            	<br>
	                <p class="text-justify">El principal objetivo del Plan Anual de Adquisiciones es permitir que la entidad estatal aumente la probabilidad de lograr mejores condiciones de competencia a través de la participación de un mayor número de operadores económicos interesados en los procesos de selección que se van a adelantar durante el año fiscal, y que el Estado cuente con información suficiente para realizar compras coordinadas.</p>
			        <br>
		        </div>


		        <div id="Componente_dv" style="display:none;">
					<h3>Componente</h3>
					<hr style="border: 0; border-top: 1px solid #DF013A; height:0;">
	            	<br>
	                <p class="text-justify">El principal objetivo del Plan Anual de Adquisiciones es permitir que la entidad estatal aumente la probabilidad de lograr mejores condiciones de competencia a través de la participación de un mayor número de operadores económicos interesados en los procesos de selección que se van a adelantar durante el año fiscal, y que el Estado cuente con información suficiente para realizar compras coordinadas.
			        <br>
		        </div>

            </div>
       
@stop
