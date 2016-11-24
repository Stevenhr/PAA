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
			        				<label>Presupuesto </label>
									<input type="text" class="form-control" id="precio" name="precio">
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
								                <th>Nombre</th>
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Nombre</th>
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
	            	<br>
	                <p class="text-justify">Registro de proyectos.</p>
			        <br>
			        <form id="form_proyecto">
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
			        				<label>Presupuesto </label>
									<input type="text" class="form-control" id="precio" name="precio">
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
						    	<div class="table-responsive" id="div_Tabla4">
							      		<table id="Tabla4" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Nombre</th>
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								                <th class="text-center">N°</th>
								                <th>Nombre</th>
								                <th>Fecha inicial de implementación</th>
								                <th>Fecha final de implementación</th>
								                <th>Presupuesto</th>
								                <th>Opción</th>
								            </tr>
								        </tfoot>
								        <tbody i>
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

		        <div id="Meta_dv" style="display:none;">
					<h3>Meta</h3>
	            	<br>
	                <p class="text-justify">El principal objetivo del Plan Anual de Adquisiciones es permitir que la entidad estatal aumente la probabilidad de lograr mejores condiciones de competencia a través de la participación de un mayor número de operadores económicos interesados en los procesos de selección que se van a adelantar durante el año fiscal, y que el Estado cuente con información suficiente para realizar compras coordinadas.</p>
			        <br>
		        </div>


		        <div id="Actividad_dv" style="display:none;">
					<h3>Actividad</h3>
	            	<br>
	                <p class="text-justify">El principal objetivo del Plan Anual de Adquisiciones es permitir que la entidad estatal aumente la probabilidad de lograr mejores condiciones de competencia a través de la participación de un mayor número de operadores económicos interesados en los procesos de selección que se van a adelantar durante el año fiscal, y que el Estado cuente con información suficiente para realizar compras coordinadas.</p>
			        <br>
		        </div>


		        <div id="Componente_dv" style="display:none;">
					<h3>Componente</h3>
	            	<br>
	                <p class="text-justify">El principal objetivo del Plan Anual de Adquisiciones es permitir que la entidad estatal aumente la probabilidad de lograr mejores condiciones de competencia a través de la participación de un mayor número de operadores económicos interesados en los procesos de selección que se van a adelantar durante el año fiscal, y que el Estado cuente con información suficiente para realizar compras coordinadas.
			        <br>
		        </div>

            </div>
       
@stop
