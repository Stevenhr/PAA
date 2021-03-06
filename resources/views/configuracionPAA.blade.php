@extends('master')             

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/configuracion.js') }}"></script>	
@stop


@section('content') 
        
            <div class="content" id="main_paa_configuracion" class="row" data-url="configuracionPaa" >
            	
            	<div class="btn-group btn-group-justified">
					  <a href="#" class="btn btn-success" id="Fuente">Fuente</a>
					  <a href="#" class="btn btn-success" id="Componente">Crear Componente</a>
					   <a href="#" class="btn btn-primary" id="Presupuesto_desarrollo" data-role="Presupuesto_desarrollo">Plan de desarrollo</a>
					  <a href="#" class="btn btn-primary" id="Presupuesto" data-role="Presupuesto">Vigencias</a>
					  <a href="#" class="btn btn-primary" id="Proyecto">Proyecto Inversión</a>
					  <a href="#" class="btn btn-primary" id="Meta">Meta</a>
					  <a href="#" class="btn btn-primary" id="Actividad">Actividad</a>
					  <a href="#" class="btn btn-warning" id="Rubro">Rubro Funcionamiento</a>
					  <a href="#" class="btn btn-warning" id="Actividad_rubros">Actividad</a>
					  <!--<a href="#" class="btn btn-primary" id="Componente_Conf">Configurar Componente</a> -->
				</div>
				
				<br>

				<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  PLAN DE DESARROLLO  %%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
				<div id="Presupuesto_desarrollo_dv" style="display:none;">
					
					<h3>Plan de desarrollo:</h3>
					<hr style="border: 0; border-top: 1px solid #30a5e7; height:0;">
	            	<br>
	                <p class="text-justify">Registro de los planes de desarrollo.</p>
			        <br>
			        <form id="form_plan_Desarrollo">
			            <div id="div_plan_Desarrollo"><br></div>
				        <div class="row" >
						    <div class="col-xs-12 col-md-3">
						    	<div class="form-group">	
						    		<label>Nombre plan de desarrollo</label>
						    		<input type="hidden" class="form-control" name="Id_plan_desarrollo" value="0">
									<input type="text" class="form-control" name="nombre_plan_desarrollo">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker_1" name="fecha_inicial_plan">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3">
			        			<div class="form-group">
			        				<label>Fecha final de implementación</label>
									<input type="text" class="form-control" data-role="datepicker_1" name="fecha_final_plan">
								</div>
			        		</div>

			        		<div class="col-xs-12 col-md-3">
			        			<div class="form-group">
			        				<label>Valor </label>
									<input type="text" class="form-control precio" name="precio_plan">
								</div>
			        		</div>
						</div>

						<div class="row">
						    <div class="col-xs-12 col-md-4">
			        		</div>
						    <div class="col-xs-12 col-md-4 text-center"><br>
						    		<div class="alert alert-success" style="display:none;" id="mensaje_pplan">
									  <strong>Bien!</strong> Registro creado con exíto.
									</div>
									<div class="alert alert-danger" style="display:none;" id="mensaje_pplan2"></div>
									<button class="btn btn-primary" type="submit" id="id_btn_plan">Registrar</button>
									<button class="btn btn-danger" type="submit" id="id_btn_plan_canc" style="display:none;">Cancelar</button>
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
			            		<h5>Listado de Planes de desarrollo:</h5>
					        </div>
						    <div class="col-xs-12 col-md-12">
						    	<div class="table-responsive" id="div_Tabla_0">
							      		<table id="Tabla0" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Plan Desarrollo</th>
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
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </tfoot>
								        <tbody id="registros_actividades_responsable">
								        		<?php $var=1; ?>
								        		@foreach($proyectoDesarrollo as $proyectoDesarrollos)
								    
						        						<tr>
						        						<th scope="row" class="text-center">{{ $var }}</th>
								                        <td><h4>{{ $proyectoDesarrollos['nombre'] }}</h4></td>								
								                        <td>{{ $proyectoDesarrollos['fecha_fin'] }}</td>
								                        <td>{{ $proyectoDesarrollos['fecha_inicio'] }}</td>
								                        <td>{{ number_format($proyectoDesarrollos['valor']) }}</td>
								                        <td>
															<div class="btn-group btn-group-justified tama">
															  <div class="btn-group">
															    <button type="button" data-rel="{{ $proyectoDesarrollos['id'] }}" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
															  </div>
															  <div class="btn-group">
															    <button type="button" data-rel="{{ $proyectoDesarrollos['id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
															  </div>
															</div>
															<div id="espera_plan{{ $proyectoDesarrollos['id'] }}"></div>
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



				
				<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  PRESUPUESTO  %%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
				<div id="Presupuesto_dv" style="display:none;">
					
					<h3>Vigencias:</h3>
					<hr style="border: 0; border-top: 1px solid #30a5e7; height:0;">
	            	<br>
	                <p class="text-justify">Registro de las vigencias de los planes de desarrollo.</p>
			        <br>
			        <form id="form_presupuesto">
			            <div id="div_form_presupuesto"><br></div>
				        <div class="row" >

						    <div class="col-xs-12 col-md-4 ">
						    	<div class="form-group">	
						    		<label>Plan de desarrollo</label>
						    		<input type="hidden" class="form-control" name="Id_presupuesto" value="0">
								
									<select class="form-control" name="idProyectoDesa" id="idProyectoDesa">
											<option value="">Seleccionar</option>
										@foreach($proyectoDesarrollo as $proyectoDesarrollos)
											<option value="{{ $proyectoDesarrollos['id'] }}" >{{ $proyectoDesarrollos['nombre'] }}</option>
									    @endforeach
									</select>
								</div>
			        		</div>

			        		<div class="col-xs-12 col-md-2 ">
						    	<div class="form-group">	
						    		<label>Vigencia</label>
						    		<select class="form-control" name="vigencia" id="vigencia">
											<option value="">Seleccionar</option>
											<option value="2017">2017</option>
											<option value="2018">2018</option>
											<option value="2019">2019</option>
											<option value="2020">2020</option>
									</select>
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-2 ">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker_1" name="fecha_inicial_presupuesto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-2 ">
			        			<div class="form-group">
			        				<label>Fecha final de implementación</label>
									<input type="text" class="form-control" data-role="datepicker_1" name="fecha_final_presupuesto">
								</div>
			        		</div>

			        		<div class="col-xs-12 col-md-2 ">
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
						    		<div class="alert alert-success" style="display:none;" id="mensaje_presupuesto"></div>
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
								                <th>Plan Desarrollo</th>
								                <th>Vigencia</th>
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
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </tfoot>
								        <tbody id="registros_actividades_responsable">
								        		<?php $var=1; ?>
								        		@foreach($proyectoDesarrollo as $proyectoDesarrollos)
								        			@if(count($proyectoDesarrollos->presupuestos )!=0)
									        		@foreach($proyectoDesarrollos->presupuestos as $presupuesto)
						        						<tr>
						        						<th scope="row" class="text-center">{{ $var }}</th>
								                        <td><h4>{{ $proyectoDesarrollos['nombre'] }}</h4></td>
								                        <td><h4>{{ $presupuesto['vigencia'] }}</h4></td>
								                        <td>{{ $presupuesto['fecha_fin'] }}</td>
								                        <td>{{ $presupuesto['fecha_inicio'] }}</td>
								                        <td>{{ number_format($presupuesto['presupuesto']) }}</td>
								                        <td>
															<div class="btn-group btn-group-justified tama">
															  <div class="btn-group">
															    <button type="button" data-rel="{{ $presupuesto['Id'] }}" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
															  </div>
															  <div class="btn-group">
															    <button type="button" data-rel="{{ $presupuesto['Id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
															  </div>
															</div>
															<div id="espera{{ $presupuesto['Id'] }}"></div>
								                        </td>
								                        </tr>
								                        <?php $var++; ?>
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




		        <!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  PROYECTO DE INVERSION %%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
				<div id="Proyecto_dv" style="display:none;">
					<h3>Proyecto</h3>
					<hr style="border: 0; border-top: 1px solid #30a5e7; height:0;">
	            	<br>
	                <p class="text-justify">Registro de proyectos.</p>
			        <br>
			        <form id="form_proyecto">
			            <div id="div_form_presupuesto"><br></div>
				        
				        <div class="row" >
				        	<div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">	
						    		<label>Plan de desarrollo</label>
									<select class="form-control" name="idProyectoDesa_Proyecto" id="idProyectoDesa_Proyecto">
											<option value="">Seleccionar</option>
										@foreach($proyectoDesarrollo as $proyectoDesarrollos)
											<option value="{{ $proyectoDesarrollos['id'] }}" >{{ $proyectoDesarrollos['nombre'] }}</option>
									    @endforeach
									</select>
								</div>
			        		</div>
				        	<div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Vigencia</label>
									<select class="form-control" name="idPresupuesto"  id="idPresupuesto">
											<option value="">Seleccionar</option>
									</select>
								</div>
			        		</div>
						    <div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">	
						    		<label>Subdirección</label>
									<select class="form-control" name="id_subdireccion" id="id_subdireccion">
											<option value="">Seleccionar</option>
										@foreach($subdirecciones as $subdireccion)
											<option value="{{ $subdireccion['id'] }}" >{{ $subdireccion['nombre'] }}</option>
									    @endforeach
									</select>
								</div>
						    </div>
			        		<div class="col-xs-12 col-md-2 "></div>
						</div>

				        <div class="row" >
				        	<div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Código</label>
									<input type="text" class="form-control" name="codigo_proyecto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Nombre proyecto</label>
						    		<input type="hidden" class="form-control" name="Id_proyecto" value="0">
									<input type="text" class="form-control" name="nombre_proyecto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-2 ">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker_1" name="fecha_inicial_proyecto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-2 ">
			        			<div class="form-group">
			        				<label>Fecha final de implementación</label>
									<input type="text" class="form-control" data-role="datepicker_1" name="fecha_final_proyecto">
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
			            		<h5>Listado de Proyectos de inversión:</h5>
					        </div>
						    <div class="col-xs-12 col-md-12">
						    	<div class="table-responsive" id="div_Tabla4">
							      		<table id="Tabla4" class="display" width="100%" cellspacing="0">
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
																	    <button type="button" data-rel="{{ $proyecto['Id'] }}" data-funcion="ver_eli" data-tooltip="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
																	  </div>
																	  <div class="btn-group">
																	    <button type="button" data-rel="{{ $proyecto['Id'] }}" data-funcion="ver_upd" data-tooltip="tooltip" data-placement="top" title="Editar" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
																	  </div>
																	  <div class="btn-group">
																	    <button type="button" data-rel="{{ $proyecto['Id'] }}" data-nombre="{{ $proyecto['Nombre'] }}" data-funcion="Modal_Finanza_Fuente" data-toggle="modal" data-target="#Modal_Finanza_Fuente" data-tooltip="tooltip" data-placement="top" title="Fuente" class="btn btn-success btn-xs">F</button>
																	  </div>
																	  <div class="btn-group">
																	    <button type="button" data-rel="{{ $proyecto['Id'] }}" data-nombre="{{ $proyecto['Nombre'] }}" data-funcion="Modal_Finanza_Componente" data-toggle="modal" data-target="#Modal_Finanza_Componente" data-tooltip="tooltip" data-placement="top" title="Componente"class="btn btn-success btn-xs">C</button>
																	  </div>
																	</div>
																	<div id="espera{{ $proyecto['Id'] }}"></div>
										                        </td>
										                        </tr>
										                        <?php $var++; ?>
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




		        <!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% META %%%%%%%%%%%%%%%%%%%%%%%%% -->
		        <div id="Meta_dv" style="display:none;">

					<h3>Meta</h3>
					<hr style="border: 0; border-top: 1px solid #30a5e7; height:0;">
	            	<br>
	                <p class="text-justify">Registro de metas.</p>
			        <br>

			        <form id="form_metas">
			            <div id="div_form_metas"><br></div>
				        
				        <div class="row" >

				        	<div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">	
						    		<label>Plan de desarrollo</label>
									<select class="form-control" name="idProyectoDesa_Meta">
											<option value="">Seleccionar</option>
										@foreach($proyectoDesarrollo as $proyectoDesarrollos)
											<option value="{{ $proyectoDesarrollos['id'] }}" >{{ $proyectoDesarrollos['nombre'] }}</option>
									    @endforeach
									</select>
								</div>
			        		</div>

				        	<div class="col-xs-12 col-md-3">
						    	<div class="form-group">	
						    		<label>Vigencia</label>
									<select class="form-control" name="idPresupuesto_M">
											<option value="">Seleccionar</option>
									</select>
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3">
						    	<div class="form-group">	
						    		<label>Proyecto</label>
									<select class="form-control" name="idProyecto_M" id="idProyecto_M">
											<option value="">Seleccionar</option>
									</select>
								</div>
			        		</div>


						    <div class="col-xs-12 col-md-3">
			        		</div>

						</div>

						<div class="row" >
						    <div class="col-xs-12 col-md-3">
						    	<div class="form-group">	
						    		<label>Nombre meta</label>
						    		<input type="hidden" class="form-control" name="Id_meta" value="0">
									<input type="text" class="form-control" name="nombre_meta">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker_1" name="fecha_inicial_meta">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
			        			<div class="form-group">
			        				<label>Fecha final de implementación</label>
									<input type="text" class="form-control" data-role="datepicker_1" name="fecha_final_meta">
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
						    	<div class="table-responsive" id="div_Tabla5">
							      		<table id="Tabla5" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Plan Desarrollo</th>
								                <th>Vigencia</th>
								                <th>Proyecto</th>
								                <th>Nombre Meta</th>
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
								                <th>Proyecto</th>
								                <th>Nombre Meta</th>
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
					        								    
					        								    @if(count($proyecto->metas)!=0)
					        								    @foreach($proyecto->metas as $meta)
									        						<tr>
									        						<th scope="row" class="text-center">{{ $var }}</th>
									        						<td><h4>{{ $proyectoDesarrollos['nombre'] }}</h4></td>
								                        			<td><h4>{{ $presupuesto['vigencia'] }}</h4></td>
									        						<th><h4>{{ $proyecto['Nombre'] }}</h4></th>
											                        <td><h4>{{ $meta['Nombre'] }}</h4></td>
											                        <td>{{ $meta['fecha_inicio'] }}</td>
											                        <td>{{ $meta['fecha_fin'] }}</td>
											                        <td>{{ number_format($meta['valor']) }}</td>
											                        <td>
																		<div class="btn-group btn-group-justified tama">
																		  <div class="btn-group">
																		    <button type="button" data-rel="{{ $meta['Id'] }}" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
																		  </div>
																		  <div class="btn-group">
																		    <button type="button" data-rel="{{ $meta['Id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
																		  </div>
																		</div>
																		<div id="espera_m{{ $meta['Id'] }}"></div>
											                        </td>
											                        </tr>
											                        <?php $var++; ?>
									                        	@endforeach
									                        	@EndIf

								                         @endforeach
									                     @EndIf

					        					@endforeach
					        					@endIf
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




		             <!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% ACTIVIDAD %%%%%%%%%%%%%%%%%%%%%%%%% -->
		        <div id="Actividad_dv" style="display:none;">
					<h3>Actividad de proyecto de inversión.</h3>
					<hr style="border: 0; border-top: 1px solid #30a5e7; height:0;">
	            	<br>
	                <p class="text-justify">Registro de actividades a proyectos de inversión.</p>
			        <br>

			        <form id="form_actividad">
			            <div id="div_form_actividad"><br></div>
				        
				        <div class="row" >
				        	
				        	<div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">	
						    		<label>Plan de desarrollo</label>
									<select class="form-control" name="idProyectoDesa_Actividad">
											<option value="">Seleccionar</option>
										@foreach($proyectoDesarrollo as $proyectoDesarrollos)
											<option value="{{ $proyectoDesarrollos['id'] }}" >{{ $proyectoDesarrollos['nombre'] }}</option>
									    @endforeach
									</select>
								</div>
			        		</div>

				        	<div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Vigencia</label>
									<select class="form-control" name="idPresupuesto_A">
											<option value="">Seleccionar</option>
									</select>
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Proyecto</label>
									<select class="form-control" name="idProyecto_A" id="idProyecto_A">
											<option value="">Seleccionar</option>
									</select>
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">	
						    		<label>Meta</label>
									<select class="form-control" name="idMeta_A" id="idMeta_A">
											<option value="">Seleccionar</option>
									</select>
								</div>
			        		</div>
						</div>

						<div class="row" >
						    <div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Nombre actividad</label>
						    		<input type="hidden" class="form-control" name="Id_actividad" value="0">
									<input type="text" class="form-control" name="nombre_actividad">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker_1" name="fecha_inicial_actividad">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
			        			<div class="form-group">
			        				<label>Fecha final de implementación</label>
									<input type="text" class="form-control" data-role="datepicker_1" name="fecha_final_actividad">
								</div>
			        		</div>

			        		<div class="col-xs-12 col-md-3 ">
			        			<div class="form-group">
			        				<label>Valor </label>
									<input type="text" class="form-control precio" name="precio_actividad">
								</div>
			        		</div>
						</div>

						<div class="row">
						    <div class="col-xs-12 col-md-4">
			        		</div>
						    <div class="col-xs-12 col-md-4 text-center"><br>
						    		<div class="alert alert-success" style="display:none;" id="mensaje_actividad"></div>
						    		<div class="alert alert-danger" style="display:none;" id="mensaje_actividad2"></div>
									<button class="btn btn-primary" type="submit" id="id_btn_actividad">Registrar</button>
									<button class="btn btn-danger" type="submit" id="id_btn_actividad_canc" style="display:none;">Cancelar</button>
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
			            		<h5>Listado de Actividades:</h5>
					        </div>
						    <div class="col-xs-12 col-md-12">
						    	<div class="table-responsive" id="div_Tabla6">
							      		<table id="Tabla6" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Plan Desarrollo</th>
								                <th>Vigencia</th>
								                <th>Proyecto</th>
								                <th>Meta</th>
								                <th>Nombre Actividad</th>
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
								                <th>Proyecto</th>
								                <th>Meta</th>
								                <th>Nombre Actividad</th>
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
					        								    
					        								    @if(count($proyecto->metas)!=0)
					        								    @foreach($proyecto->metas as $meta)
									        						
									        						    @if(count($meta->actividades)!=0)
					        								    		@foreach($meta->actividades as $actividad)
											        						<tr>
											        						<th scope="row" class="text-center">{{ $var }}</th>
											        						<td><h4>{{ $proyectoDesarrollos['nombre'] }}</h4></td>
								                        					<td><h4>{{ $presupuesto['vigencia'] }}</h4></td>
											        						<th><h4>{{ $proyecto['Nombre'] }}</h4></th>
											        						<th><h4>{{ $meta['Nombre'] }}</h4></th>
													                        <td><h4>{{ $actividad['Nombre'] }}</h4></td>
													                        <td>{{ $actividad['fecha_inicio'] }}</td>
													                        <td>{{ $actividad['fecha_fin'] }}</td>
													                        <td>{{ number_format($actividad['valor']) }}</td>
													                        <td>
																				<div class="btn-group btn-group-justified tama">
																				  <div class="btn-group">
																				    <button type="button" data-rel="{{ $actividad['Id'] }}" data-funcion="ver_eli" class="btn btn-danger btn-xs">
																					<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
																				  </div>
																				  <div class="btn-group">
																				    <button type="button" data-rel="{{ $actividad['Id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
																				  </div>
																				</div>
																				<div id="espera_a{{ $actividad['Id'] }}"></div>
													                        </td>
													                        </tr>
											                        		<?php $var++; ?>
											                        	@endforeach
									                        			@EndIf

									                        	@endforeach
									                        	@EndIf

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








		        <!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% COMPONENTE %%%%%%%%%%%%%%%%%%%%%%%%% -->
		        <div id="Componente_dv" style="display:none;">
		        	<h3>Componente</h3>
					<hr style="border: 0; border-top: 1px solid #547a29; height:0;">
	            	<br>
	                <p class="text-justify">Registro de componente.</p>
			        <br>

			        <form id="form_componente_crear">
					<div id="div_form_componente_crear"><br></div>
				        
						<div class="row" >
							<div class="col-xs-12 col-md-4">
			        			<div class="form-group">
			        				<label>Código</label>
									<input type="text" class="form-control precio" name="codigo_componente_crear">
								</div>
			        		</div>
						    <div class="col-xs-12 col-md-8">
						    	<div class="form-group">	
						    		<label>Nombre Componente</label>
						    		<input type="hidden" class="form-control" name="Id_componente_crear" value="0">
									<input type="text" class="form-control" name="nombre_componente_crear">
								</div>
			        		</div>
			        		<!--<div class="col-xs-12 col-md-3">
			        			<div class="form-group">
			        				<label>Valor</label>
									<input type="text" class="form-control precio" name="valor_componente_crear">
								</div>
			        		</div>
			        		<div class="col-xs-12 col-md-3">
						    	<div class="form-group">
						    		<label>Fuente de Financiamiento</label>
									<input type="hidden" class="form-control .form-group" data-role="datepicker_1" name="fecha_inicial_componente" value="0000-00-00">
									<select class="form-control" name="idFuenteF_C" id="idFuenteF_C">
											<option value="">Seleccionar</option>
										@foreach($fuentes as $fuente)
											<option value="{{ $fuente['Id'] }}" >{{ $fuente['nombre'] }}</option>
									    @endforeach
									</select>
								</div>
			        		</div>-->
						</div>

						<div class="row">
						    <div class="col-xs-12 col-md-4">
			        		</div>
						    <div class="col-xs-12 col-md-4 text-center"><br>
						    		<div class="alert alert-success" style="display:none;" id="mensaje_componente_crear"></div>
						    		<div class="alert alert-danger" style="display:none;" id="mensaje_componente2_crear"></div>
									<button class="btn btn-primary" type="submit" id="id_btn_componente_crear">Registrar</button>
									<button class="btn btn-danger" type="submit" id="id_btn_componente_canc_crear" style="display:none;">Cancelar</button>
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
						    	<div class="table-responsive" id="div_Tabla8">
							      		<table id="Tabla8" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Código</th>
								                <th>Componente</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								            	<th class="text-center">N°</th>
								                <th>Código</th>
								                <th>Componente</th>
								                <th>Opción</th>
								            </tr>
								        </tfoot>
								        <tbody i>
								        		<?php $var=1; ?>

								        		@foreach($componentes as $componente)
								        			<tr>
												    	<th scope="row" class="text-center">{{ $var }}</th>
												        <td scope="row">{{ $componente['codigo'] }}</td>
												        <td scope="row"><h4>{{ $componente['Nombre'] }}</h4></td>
												        <td>
															<div class="btn-group btn-group-justified tama">
															  <div class="btn-group">
															    <button type="button" data-rel="{{ $componente['Id'] }}" data-funcion="ver_eli" class="btn btn-danger btn-xs">
															    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
															  </div>
															  <div class="btn-group">
															    <button type="button" data-rel="{{ $componente['Id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
															  </div>
															</div>
															<div id="espera_crear{{ $componente['Id'] }}"></div>
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



				
				<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% FUENTE %%%%%%%%%%%%%%%%%%%%%%%%% -->
		        <div id="Fuente_dv" style="display:none;">
		        	<h3>Fuente</h3>
					<hr style="border: 0; border-top: 1px solid #547a29; height:0;">
	            	<br>
	                <p class="text-justify">Registro de Fuente.</p>
			        <br>

			        <form id="form_fuente_crear">
					<div id="div_form_fuente_crear"><br></div>
				        
						<div class="row" >
							<div class="col-xs-12 col-md-4">
			        			<div class="form-group">
			        				<label>Código</label>
									<input type="text" class="form-control precio" name="codigo_fuente_crear">
								</div>
			        		</div>
						    <div class="col-xs-12 col-md-4">
						    	<div class="form-group">	
						    		<label>Nombre Fuente</label>
						    		<input type="hidden" class="form-control" name="Id_fuente_crear" value="0">
									<input type="text" class="form-control" name="nombre_fuente_crear">
								</div>
			        		</div>
						    <div class="col-xs-12 col-md-4">
						    	<div class="form-group">	
						    		<label>Valor</label>
									<input type="text" class="form-control" name="valor_fuente_crear">
								</div>
			        		</div>
						</div>

						<div class="row">
						    <div class="col-xs-12 col-md-4">
			        		</div>
						    <div class="col-xs-12 col-md-4 text-center"><br>
						    		<div class="alert alert-success" style="display:none;" id="mensaje_fuente_crear"></div>
						    		<div class="alert alert-danger" style="display:none;" id="mensaje_fuente2_crear"></div>
									<button class="btn btn-primary" type="submit" id="id_btn_fuente_crear">Registrar</button>
									<button class="btn btn-danger" type="submit" id="id_btn_fuente_canc_crear" style="display:none;">Cancelar</button>
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
						    	<div class="table-responsive" id="div_Tabla9">
							      		<table id="Tabla9" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Código</th>
								                <th>Fuente</th>
								                <th>Valor</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								            	<th class="text-center">N°</th>
								                <th>Código</th>
								                <th>Fuente</th>
								                <th>Valor</th>
								                <th>Opción</th>
								            </tr>
								        </tfoot>
								        <tbody i>
								        		<?php $var=1; ?>

								        		@foreach($fuentes as $fuente)
								        			<tr>
												    	<th scope="row" class="text-center">{{ $var }}</th>
												        <td scope="row">{{ $fuente['codigo'] }}</td>
												        <td scope="row"><h4>{{ $fuente['nombre'] }}</h4></td>
												        <td scope="row">{{ number_format( $fuente['valor'], 1, '.', ',' ) }}</td>
												        <td>
															<div class="btn-group btn-group-justified tama">
															  <div class="btn-group">
															    <button type="button" data-rel="{{ $fuente['Id'] }}" data-funcion="ver_eli" class="btn btn-danger btn-xs">
															    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
															  </div>
															  <div class="btn-group">
															    <button type="button" data-rel="{{ $fuente['Id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
															  </div>
															</div>
															<div id="espera_crear_fuente{{ $fuente['Id'] }}"></div>
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



		         <!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  RUBRO DE FUNCIONAMIENTO  %%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
				<div id="Rubro_dv" style="display:none;">
					<h3>Rubro de funcionamiento</h3>
					<hr style="border: 0; border-top: 1px solid #f06004; height:0;">
	            	<br>
	                <p class="text-justify">Registro de rubro.</p>
			        <br>
			        <form id="form_rubro_funcionamiento">
			            <div id="div_form_presupuesto"><br></div>

				        <div class="row" >
				        	<div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Código</label>
									<input type="text" class="form-control" name="codigo_rubro_funciona">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Nombre</label>
						    		<input type="hidden" class="form-control" name="Id_rubro_funcionamient" value="0">
									<input type="text" class="form-control" name="nombre_rubro_funciona">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-2 ">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker_1" name="fecha_inicial_rubro_funciona">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-2 ">
			        			<div class="form-group">
			        				<label>Fecha final de implementación</label>
									<input type="text" class="form-control" data-role="datepicker_1" name="fecha_final_rubro_funciona">
								</div>
			        		</div>

			        		<div class="col-xs-12 col-md-2 ">
			        			<div class="form-group">
			        				<label>Valor </label>
									<input type="text" class="form-control precio" name="precio_rubro_funciona">
								</div>
			        		</div>
						</div>

						

						<div class="row">
						    <div class="col-xs-12 col-md-4">
			        		</div>
						    <div class="col-xs-12 col-md-4 text-center"><br>
						    		<div class="alert alert-success" style="display:none;" id="mensaje_rubrofuncionam"></div>
						    		<div class="alert alert-danger" style="display:none;" id="mensaje_rubrofuncionam2"></div>
									<button class="btn btn-primary" type="submit" id="id_btn_rubrof">Registrar</button>
									<button class="btn btn-danger" type="submit" id="id_btn_rubrof_canc" style="display:none;">Cancelar</button>
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
			            		<h5>Listado de rubros de funcionamiento:</h5>
					        </div>
						    <div class="col-xs-12 col-md-12">
						    	<div class="table-responsive" id="div_Tabla_rubro_f">
							      		<table id="Tabla10_rubros_funcionamiento" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Código</th>
								                <th>Rubro</th>
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Valor</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Código</th>
								                <th>Rubro</th>
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Valor</th>
								                <th>Opción</th>
								            </tr>
								        </tfoot>
								        <tbody i>
								        		<?php $var=1; ?>

								        		@foreach($rubrosFuncionamiento as $rubroFuncionamiento)
					        							
											        						<tr>
											        						<th scope="row" class="text-center">{{ $var }}</th>
											        						<th scope="row">{{ $rubroFuncionamiento['codigo'] }}</th>
											        						<th scope="row">{{ $rubroFuncionamiento['nombre'] }}</th>
													                        <td>{{ $rubroFuncionamiento['fecha_inicio'] }}</td>
													                        <td>{{ $rubroFuncionamiento['fecha_fin'] }}</td>
													                        <td>{{ number_format($rubroFuncionamiento['valor']) }}</td>
													                        <td>
																				<div class="btn-group btn-group-justified tama">
																				  <div class="btn-group">
																				    <button type="button" data-rel="{{ $rubroFuncionamiento['id'] }}" data-funcion="ver_eli" class="btn btn-danger btn-xs">
																					<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
																				  </div>
																				  <div class="btn-group">
																				    <button type="button" data-rel="{{ $rubroFuncionamiento['id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
																				  </div>
																				</div>
																				<div id="espera_rubrofunciona{{ $rubroFuncionamiento['id'] }}"></div>
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



		        <!--  ++++-ACTIVIDAD DE LOS RUBROS FUNCIONAMIENTO -->

		        <div id="Actividad_rubros_dv" style="display:none;">
					<h3>Actividad de rubro de funcionamiento</h3>
					<hr style="border: 0; border-top: 1px solid #f06004; height:0;">
	            	<br>
	                <p class="text-justify">Registro de actividades a rubros de funcionamiento.</p>
			        <br>

			        <form id="form_actividad_rubro_funcionamiento">				      

						<div class="row" >
						    <div class="col-xs-12 col-md-6">
						    	<div class="form-group">	
						    		<label>Rubro de funcionamiento</label>
									<select class="form-control" name="id_rubro_func_act" id="id_rubro_func_act">
											<option value="">Seleccionar</option>
										@foreach($rubrosFuncionamiento as $rubroFuncionamiento)
											<option value="{{ $rubroFuncionamiento['id'] }}" >{{ $rubroFuncionamiento['nombre'] }}</option>
									    @endforeach
									</select>
								</div>
			        		</div>
						    <div class="col-xs-12 col-md-6">
						    	<div class="form-group">	
						    		<label>Nombre Actividad</label>
						    		<input type="hidden" class="form-control" name="Id_act_rubro_funcionamient" value="0">
									<input type="text" class="form-control" name="nombre_acividad_funcionamiento">
								</div>
			        		</div>
						</div>

						<div class="row">
						    <div class="col-xs-12 col-md-4">
			        		</div>
						    <div class="col-xs-12 col-md-4 text-center"><br>
						    		<div class="alert alert-success" style="display:none;" id="mensaje_act_rubrofuncionam"></div>
						    		<div class="alert alert-danger" style="display:none;" id="mensaje_act_rubrofuncionam2"></div>
									<button class="btn btn-primary" type="submit" id="id_btn_rf_actividad">Registrar</button>
									<button class="btn btn-danger" type="submit" id="id_btn_actividad_rf_canc" style="display:none;">Cancelar</button>
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
						    	<div class="table-responsive" id="div_Tabla_act_rf">
							      		<table id="Tabla11_actividad_rubro" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Codigo Rubro</th>
								                <th>Rubro</th>
								                <th>Actividad</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Codigo Rubro</th>
								                <th>Rubro</th>
								                <th>Actividad</th>
								                <th>Opción</th>
								            </tr>
								        </tfoot>
								        <tbody>
								        		<?php $var=1; ?>

								        		@foreach($rubrosFuncionamiento as $rubroFuncionamiento)
					        							
					        							@if(count($rubroFuncionamiento->actividadesfuncionamiento )!=0)
					        							@foreach($rubroFuncionamiento->actividadesfuncionamiento as $actividadrubro)
											        						<tr>
											        						<th scope="row" class="text-center">{{ $var }}</th>
											        						<th >{{ $rubroFuncionamiento['codigo'] }}</th>
											        						<th >{{ $rubroFuncionamiento['nombre'] }}</th>
													                        <td scope="row"><h4>{{ $actividadrubro['nombre'] }}</h4></td>
													                        <td>
																				<div class="btn-group btn-group-justified tama">
																				  <div class="btn-group">
																				    <button type="button" data-rel="{{ $actividadrubro['id'] }}" data-funcion="ver_eli" class="btn btn-danger btn-xs">
																					<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
																				  </div>
																				  <div class="btn-group">
																				    <button type="button" data-rel="{{ $actividadrubro['id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
																				  </div>
																				</div>
																				<div id="espera_act_funciona{{ $rubroFuncionamiento['id'] }}"></div>
													                        </td>
													                        </tr>
											                        		<?php $var++; ?>
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

</div>




<!-- MODAL FUENTE -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Finanza_Fuente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
		<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Ingreso de fuentes</h4>
	        Proyecto: <label id="id_Nom_proy_fin_f">

	    </div>
	    <form id="form_agregar_finanza_fuente">
			<div class="modal-body">
				<div class="row"  >
				   <div class="col-xs-12 col-sm-12">
				  		<div class="form-group">
					    	<h5><b>Ingreso de las fuentes de financiación:</b></h5>
						</div>
				  </div>
				</div>
				<div class="row" >
				    <div class="col-xs-12 col-md-8 ">
				    	<div class="form-group">	
				    		<input type="hidden" name="id_proyect_fina_f" id="id_proyect_fina_f" ></input>
				    		<label>Fuente</label>					
							<select class="form-control" name="id_fuente_finanza_fuente" id="id_fuente_finanza_fuente" >
									<option value="">Seleccionar</option>
									@foreach($fuentes as $fuente)
										<option value="{{ $fuente['Id'] }}" >{{ $fuente['codigo'] }} - {{ $fuente['nombre'] }}</option>
								    @endforeach
							</select>
						</div>
	        		</div>
	        		<div class="col-xs-12 col-md-4 ">
				    	<div class="form-group">	
				    		<label>Valor</label>					
							<input type="text" class="form-control" name="valor_fuente_proyecto">
						</div>
	        		</div>
			    </div>
			    <div class="row"  >
				   <div class="col-xs-12 col-sm-12">
				  		<div class="form-group">
					    	<button class="btn btn-success" type="submit" id="btn_agregar_finanza_ft">Agregar</button>
					    	<button class="btn btn-danger" type="submit" id="btn_agregar_finanza_ft_c" style="display: none">Cancelar</button>
						</div>
				  </div>
				  <div class="col-xs-12 col-sm-12">
				  		<input type="hidden" name="id_finanza_fuente_crear" id="id_finanza_fuente_crear"  value="0" ></input>
				  		<div id="mjs_registroFinanza_fuente" style="display: none"></div>
				  </div>
				</div>
	      	</div>
	      	<hr>
	      	<hr>

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
						                <th>Opción</th>
						            </tr>
						        </thead>
						        <tfoot>
						             <tr>
						                <th class="text-center">N°</th>
						                <th>Fuente</th>
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
				    		<input type="hidden" name="id_proyect_fina_c" id="id_proyect_fina_c" ></input>
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
					    	<button class="btn btn-success" type="submit" id="agregar_finanza" style="display: none;">Agregar</button>
					    	<button class="btn btn-danger" type="submit" id="cancelar_finanza" style="display: none;">Cancelar</button>
						</div>
				  </div>
				  <div class="col-xs-12 col-sm-12">
				  		<input type="hidden" name="id_finanza_fuenteCompoente_crear" id="id_finanza_fuenteCompoente_crear"  value="0" ></input>
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

