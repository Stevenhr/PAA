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
					   <a href="#" class="btn btn-primary" id="Presupuesto" data-role="Presupuesto">Plan de desarrollo</a>
					  <a href="#" class="btn btn-primary" id="Presupuesto" data-role="Presupuesto">Vigencias</a>
					  <a href="#" class="btn btn-primary" id="Proyecto">Proyecto Inversión</a>
					  <a href="#" class="btn btn-primary" id="Meta">Meta</a>
					  <a href="#" class="btn btn-primary" id="Actividad">Actividad</a>
					  <a href="#" class="btn btn-warning" id="Rubro">Rubro Funcionamiento</a>
					  <a href="#" class="btn btn-warning" id="Actividad_rubros">Actividad</a>
					  <!--<a href="#" class="btn btn-primary" id="Componente_Conf">Configurar Componente</a> -->
				</div>
				
				<br>
				
				<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  PRESUPUESTO  %%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
				<div id="Presupuesto_dv" style="display:none;">
					
					<h3>Plan de desarrollo</h3>
					<hr style="border: 0; border-top: 1px solid #F6CECE; height:0;">
	            	<br>
	                <p class="text-justify">Registro del presupuesto del Plan de desarrollo total de los proyectos.</p>
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
							                        <td>{{ number_format($presupuestos['presupuesto']) }}</td>
							                        <td>
														<div class="btn-group btn-group-justified tama">
														  <div class="btn-group">
														    <button type="button" data-rel="{{ $presupuestos['Id'] }}" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
														  </div>
														  <div class="btn-group">
														    <button type="button" data-rel="{{ $presupuestos['Id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
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


		        <!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  PROYECTO DE INVERSION %%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
				<div id="Proyecto_dv" style="display:none;">
					<h3>Proyecto</h3>
					<hr style="border: 0; border-top: 1px solid #81DAF5; height:0;">
	            	<br>
	                <p class="text-justify">Registro de proyectos.</p>
			        <br>
			        <form id="form_proyecto">
			            <div id="div_form_presupuesto"><br></div>
				        
				        <div class="row" >
				        	<div class="col-xs-12 col-md-3 text-">
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
						    <div class="col-xs-12 col-md-3 "></div>
						    <div class="col-xs-12 col-md-3 "></div>
			        		<div class="col-xs-12 col-md-2 "></div>
						</div>

				        <div class="row" >
				        	<div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Codigo</label>
									<input type="text" class="form-control" name="codigo_proyecto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Nombre</label>
						    		<input type="hidden" class="form-control" name="Id_proyecto" value="0">
									<input type="text" class="form-control" name="nombre_proyecto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-2 ">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker" name="fecha_inicial_proyecto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-2 ">
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
										                        <td>{{ number_format($proyecto['valor']) }}</td>
										                        <td>
																	<div class="btn-group btn-group-justified tama">
																	  <div class="btn-group">
																	    <button type="button" data-rel="{{ $proyecto['Id'] }}" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
																	  </div>
																	  <div class="btn-group">
																	    <button type="button" data-rel="{{ $proyecto['Id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
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
									<select class="form-control" name="idProyecto_M" id="idProyecto_M">
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
						    	<div class="table-responsive" id="div_Tabla5">
							      		<table id="Tabla5" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Presupuesto</th>
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
								                <th>Presupuesto</th>
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
					<h3>Actividad de proyecto de inversión.</h3>
					<hr style="border: 0; border-top: 1px solid #642EFE; height:0;">
	            	<br>
	                <p class="text-justify">Registro de actividades a proyectos de inversión.</p>
			        <br>

			        <form id="form_actividad">
			            <div id="div_form_actividad"><br></div>
				        
				        <div class="row" >
				        	
				        	<div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Presupuesto</label>
									<select class="form-control" name="idPresupuesto_A">
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

						    <div class="col-xs-12 col-md-3 ">
			        		</div>

						</div>

						<div class="row" >
						    <div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Nombre</label>
						    		<input type="hidden" class="form-control" name="Id_actividad" value="0">
									<input type="text" class="form-control" name="nombre_actividad">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker" name="fecha_inicial_actividad">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
			        			<div class="form-group">
			        				<label>Fecha final de implementación</label>
									<input type="text" class="form-control" data-role="datepicker" name="fecha_final_actividad">
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
			            		<h5>Listado de Metas:</h5>
					        </div>
						    <div class="col-xs-12 col-md-12">
						    	<div class="table-responsive" id="div_Tabla6">
							      		<table id="Tabla6" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Presupuesto</th>
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
								                <th>Presupuesto</th>
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

								        		@foreach($presupuesto as $presupuestos)
					        							
					        							@if(count($presupuestos->proyectos)!=0)
				        								@foreach($presupuestos->proyectos as $proyecto)
					        								    
					        								    @if(count($proyecto->metas)!=0)
					        								    @foreach($proyecto->metas as $meta)
									        						
									        						    @if(count($meta->actividades)!=0)
					        								    		@foreach($meta->actividades as $actividad)
											        						<tr>
											        						<th scope="row" class="text-center">{{ $var }}</th>
											        						<th scope="row">{{ $presupuestos['Nombre_Actividad'] }}</th>
											        						<th scope="row">{{ $proyecto['Nombre'] }}</th>
											        						<th scope="row">{{ $meta['Nombre'] }}</th>
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
								        </tbody>
								    </table>
								</div>
			        		</div>
			        		<div class="col-xs-12 col-md-12">
			            		<hr><hr>
					        </div>
						</div>
		        </div>


		        <div id="Componente_dv" style="display:none;">
		        	<h3>Componente</h3>
					<hr style="border: 0; border-top: 1px solid #FF0040; height:0;">
	            	<br>
	                <p class="text-justify">Registro de componente.</p>
			        <br>

			        <form id="form_componente_crear">
					<div id="div_form_componente_crear"><br></div>
				        
						<div class="row" >
							<div class="col-xs-12 col-md-3">
			        			<div class="form-group">
			        				<label>Codigo</label>
									<input type="text" class="form-control precio" name="codigo_componente_crear">
								</div>
			        		</div>
						    <div class="col-xs-12 col-md-3">
						    	<div class="form-group">	
						    		<label>Nombre Componente</label>
						    		<input type="hidden" class="form-control" name="Id_componente_crear" value="0">
									<input type="text" class="form-control" name="nombre_componente_crear">
								</div>
			        		</div>
			        		<div class="col-xs-12 col-md-3">
			        			<div class="form-group">
			        				<label>Valor</label>
									<input type="text" class="form-control precio" name="valor_componente_crear">
								</div>
			        		</div>
			        		<div class="col-xs-12 col-md-3">
						    	<div class="form-group">
						    		<label>Fuente de Financiamiento</label>
									<input type="hidden" class="form-control .form-group" data-role="datepicker" name="fecha_inicial_componente" value="0000-00-00">
									<select class="form-control" name="idFuenteF_C" id="idFuenteF_C">
											<option value="">Seleccionar</option>
										@foreach($fuentes as $fuente)
											<option value="{{ $fuente['Id'] }}" >{{ $fuente['nombre'] }}</option>
									    @endforeach
									</select>
								</div>
			        		</div>
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
								                <th>Codigo</th>
								                <th>Componente</th>
								                <th>Valor</th>
								                <th>Fuente</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								            	<th class="text-center">N°</th>
								                <th>Codigo</th>
								                <th>Componente</th>
								                <th>Valor</th>
								                <th>Fuente</th>
								                <th>Opción</th>
								            </tr>
								        </tfoot>
								        <tbody i>
								        		<?php $var=1; ?>

								        		@foreach($componentes as $componente)
								        			<tr>
												    	<th scope="row" class="text-center">{{ $var }}</th>
												        <td scope="row">{{ $componente['codigo'] }}</td>
												        <td scope="row">{{ $componente['Nombre'] }}</td>
												        <td scope="row">{{ $componente['valor'] }}</td>
												        <td scope="row">{{ $componente->fuente['nombre'] }}</td>
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



		        <div id="Componente_Conf_dv" style="display:none;">
		        	<h3>Componente</h3>
					<hr style="border: 0; border-top: 1px solid #FF0040; height:0;">
	            	<br>
	                <p class="text-justify">Registro de componente.</p>
			        <br>

			        <form id="form_componente">
					<div id="div_form_componente"><br></div>
				        
				        <div class="row" >
				        	<div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Presupuesto</label>
									<select class="form-control" name="idPresupuesto_C">
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
									<select class="form-control" name="idProyecto_C" id="idProyecto_C">
											<option value="">Seleccionar</option>
									</select>
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">	
						    		<label>Meta</label>
									<select class="form-control" name="idMeta_C" id="idMeta_C">
											<option value="">Seleccionar</option>
									</select>
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 ">
						    	<div class="form-group">	
						    		<label>Actividad</label>
									<select class="form-control" name="idActividad_C" id="idActividad_C">
											<option value="">Seleccionar</option>
									</select>
								</div>
			        		</div>
						</div>

						<div class="row" >
						    <div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Nombre Componente</label>
						    		<input type="hidden" class="form-control" name="Id_componente" value="0">
									<input type="hidden" class="form-control .form-group" data-role="datepicker" name="fecha_inicial_componente" value="0000-00-00">
									<select class="form-control" name="nombre_componente" id="nombre_componente">
											<option value="">Seleccionar</option>
											@foreach($componentes as $componente)
											  <option value="{{ $componente['Id'] }}" >{{ $componente['Nombre'] }}</option>
										    @endforeach
									</select>
								</div>
			        		</div>

			        		<div class="col-xs-12 col-md-3 ">
			        			<div class="form-group">
			        				<label>Valor</label>
									<input type="text" class="form-control precio" name="precio_componente">
								</div>
			        		</div>	

						    <div class="col-xs-12 col-md-3 ">
			        		</div>

			        		<div class="col-xs-12 col-md-3 ">
			        		</div>        		
						</div>

						<div class="row">
						    <div class="col-xs-12 col-md-4">
			        		</div>
						    <div class="col-xs-12 col-md-4 text-center"><br>
						    		<div class="alert alert-success" style="display:none;" id="mensaje_componente"></div>
						    		<div class="alert alert-danger" style="display:none;" id="mensaje_componente2"></div>
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
						    	<div class="table-responsive" id="div_Tabla7">
							      		<table id="Tabla7" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Presupuesto</th>
								                <th>Proyecto</th>
								                <th>Meta</th>
								                <th>Actividad</th>
								                <th>Nombre Componente</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Presupuesto</th>
								                <th>Proyecto</th>
								                <th>Meta</th>
								                <th>Actividad</th>
								                <th>Nombre Componente</th>
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
									        						
									        						    @if(count($meta->actividades)!=0)
					        								    		@foreach($meta->actividades as $actividad)
					        								    			
					        								    			@if(count($actividad->componentes)!=0)
					        								    			@foreach($actividad->componentes as $componente)
												        						<tr>
												        						<th scope="row" class="text-center">{{ $var }}</th>
												        						<th scope="row">{{ $presupuestos['Nombre_Actividad'] }}</th>
												        						<th scope="row">{{ $proyecto['Nombre'] }}</th>
												        						<th scope="row">{{ $meta['Nombre'] }}</th>
												        						<td>{{ $actividad['Nombre'] }}</td>
														                        <td><h4>{{ $componente['Nombre'] }}</h4></td>
														                        <td>{{ number_format($componente->pivot['valor']) }}</td>
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
																					<div id="espera_c{{ $componente['Id'] }}"></div>
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




		        <div id="Fuente_dv" style="display:none;">
		        	<h3>Fuente</h3>
					<hr style="border: 0; border-top: 1px solid #FF0040; height:0;">
	            	<br>
	                <p class="text-justify">Registro de Fuente.</p>
			        <br>

			        <form id="form_fuente_crear">
					<div id="div_form_fuente_crear"><br></div>
				        
						<div class="row" >
							<div class="col-xs-12 col-md-4">
			        			<div class="form-group">
			        				<label>Codigo</label>
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
								                <th>Codigo</th>
								                <th>Fuente</th>
								                <th>Valor</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								            	<th class="text-center">N°</th>
								                <th>Codigo</th>
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
					<hr style="border: 0; border-top: 1px solid #81DAF5; height:0;">
	            	<br>
	                <p class="text-justify">Registro de rubro.</p>
			        <br>
			        <form id="form_proyecto">
			            <div id="div_form_presupuesto"><br></div>
				        

				        <div class="row" >
				        	<div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Codigo</label>
									<input type="text" class="form-control" name="codigo_proyecto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-3 text-">
						    	<div class="form-group">	
						    		<label>Nombre</label>
						    		<input type="hidden" class="form-control" name="Id_proyecto" value="0">
									<input type="text" class="form-control" name="nombre_proyecto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-2 ">
						    	<div class="form-group">
						    		<label>Fecha inicial de implementación</label>
									<input type="text" class="form-control .form-group" data-role="datepicker" name="fecha_inicial_proyecto">
								</div>
			        		</div>

						    <div class="col-xs-12 col-md-2 ">
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
			            		<h5>Listado de rubros de funcionamiento:</h5>
					        </div>
						    <div class="col-xs-12 col-md-12">
						    	<div class="table-responsive" id="div_Tabla4">
							      		<table id="Tabla10_rubros_funcionamiento" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Codigo</th>
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
								                <th>Codigo</th>
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
																				    <button type="button" data-rel="{{ $actividad['Id'] }}" data-funcion="ver_eli" class="btn btn-danger btn-xs">
																					<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
																				  </div>
																				  <div class="btn-group">
																				    <button type="button" data-rel="{{ $actividad['Id'] }}" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
																				  </div>
																				</div>
																				<div id="espera_a{{ $rubroFuncionamiento['id'] }}"></div>
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
					<hr style="border: 0; border-top: 1px solid #642EFE; height:0;">
	            	<br>
	                <p class="text-justify">Registro de actividades a rubros de funcionamiento.</p>
			        <br>

			        <form id="form_actividad">				      

						<div class="row" >
						    <div class="col-xs-12 col-md-6">
						    	<div class="form-group">	
						    		<label>Presupuesto</label>
									<select class="form-control" name="idPresupuesto_C">
											<option value="">Seleccionar</option>
										@foreach($rubrosFuncionamiento as $rubroFuncionamiento)
											<option value="{{ $rubroFuncionamiento['id'] }}" >{{ $rubroFuncionamiento['nombre'] }}</option>
									    @endforeach
									</select>
								</div>
			        		</div>
						    <div class="col-xs-12 col-md-6">
						    	<div class="form-group">	
						    		<label>Nombre</label>
									<input type="text" class="form-control" name="nombre_proyecto">
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
			            		<h5>Listado de Metas:</h5>
					        </div>
						    <div class="col-xs-12 col-md-12">
						    	<div class="table-responsive" id="div_Tabla6">
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
													                        <td scope="row">{{ $actividadrubro['nombre'] }}</td>
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
																				<div id="espera_a{{ $rubroFuncionamiento['id'] }}"></div>
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
       
@stop
