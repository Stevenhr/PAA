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
				<div id="Presupuesto_dv" style="display:none;">
					<h3>Presupuesto</h3>
	            	<br>
	                <p class="text-justify">El principal objetivo del Plan Anual de Adquisiciones es permitir que la entidad estatal aumente la probabilidad de lograr mejores condiciones de competencia a través de la participación de un mayor número de operadores económicos interesados en los procesos de selección que se van a adelantar durante el año fiscal, y que el Estado cuente con información suficiente para realizar compras coordinadas.
			        <br>
		        </div>


				<div id="Proyecto_dv" style="display:none;">
					<h3>Proyecto</h3>
	            	<br>
	                <p class="text-justify">El principal objetivo del Plan Anual de Adquisiciones es permitir que la entidad estatal aumente la probabilidad de lograr mejores condiciones de competencia a través de la participación de un mayor número de operadores económicos interesados en los procesos de selección que se van a adelantar durante el año fiscal, y que el Estado cuente con información suficiente para realizar compras coordinadas.
			        <br>
		        </div>

		        <div id="Meta_dv" style="display:none;">
					<h3>Meta</h3>
	            	<br>
	                <p class="text-justify">El principal objetivo del Plan Anual de Adquisiciones es permitir que la entidad estatal aumente la probabilidad de lograr mejores condiciones de competencia a través de la participación de un mayor número de operadores económicos interesados en los procesos de selección que se van a adelantar durante el año fiscal, y que el Estado cuente con información suficiente para realizar compras coordinadas.
			        <br>
		        </div>


		        <div id="Actividad_dv" style="display:none;">
					<h3>Actividad</h3>
	            	<br>
	                <p class="text-justify">El principal objetivo del Plan Anual de Adquisiciones es permitir que la entidad estatal aumente la probabilidad de lograr mejores condiciones de competencia a través de la participación de un mayor número de operadores económicos interesados en los procesos de selección que se van a adelantar durante el año fiscal, y que el Estado cuente con información suficiente para realizar compras coordinadas.
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
