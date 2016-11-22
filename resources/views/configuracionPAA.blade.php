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
				        <div class="row">
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
									<button class="btn btn-primary btn-block" type="submit">Registrar</button>
			        		</div>
			        		<div class="col-xs-12 col-md-4">
			        		</div>
						</div>
					</form>

					<h5>Listado de Presupuestos:</h5>
	            	<br>
		        </div>

		        <!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  PROYECTO  %%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
				<div id="Proyecto_dv" style="display:none;">
					<h3>Proyecto</h3>
	            	<br>
	                <p class="text-justify">El principal objetivo del Plan Anual de Adquisiciones es permitir que la entidad estatal aumente la probabilidad de lograr mejores condiciones de competencia a través de la participación de un mayor número de operadores económicos interesados en los procesos de selección que se van a adelantar durante el año fiscal, y que el Estado cuente con información suficiente para realizar compras coordinadas.</p>
			        <br>
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
