@extends('master')                              

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/reporteProyecto.js') }}"></script>	
@stop

@section('content')          
            <div class="content">
            	<div class="content" id="main_reporte" class="row" data-url="reporteProyecto" ></div>
            	
            	<div class="row">
            	    <div class="col-xs-12 col-md-12">
						<h4>Reporte Proyecto</h4>
						<br><br>
		    		</div>
		    	</div>

            	<div class="row">
            	    <div class="col-xs-12 col-md-4">
				    	<div class="form-group">	
						    <label for="planDesarrollo">1. Plan de desarrollo</label>
						    <select class="form-control" id="planDesarrollo" name="planDesarrollo">
							      <option value="">Seleccionar</option>
							   @foreach($planDesarrollo as $plan)	
								  <option value="{{$plan['id']}}">{{$plan['nombre']}}</option>
							   @endforeach
							</select>
						</div>
		    		</div>
		    		<div class="col-xs-12 col-md-4">
				    	<div class="form-group">	
						    <label for="vigencia">2. Vigencias</label>
						    <select class="form-control" id="vigencia" name="vigencia">
							  <option value="">Seleccionar</option>
							</select>
						</div>
		    		</div>
		    		<div class="col-xs-12 col-md-4">
				    	<div class="form-group">	
						    <label for="proyecto">3. Proyecto de Inversión</label>
						    <select class="form-control" id="proyecto" name="proyecto">
							  <option value="">Seleccionar</option>
							</select>
						</div>
		    		</div>
		    	</div>

		    </div>
@stop
