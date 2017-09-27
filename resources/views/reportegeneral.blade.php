@extends('master')                              

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/reporteProyectoGeneral.js') }}"></script>
@stop

@section('content')          
    <div class="content">
    	<div class="content" id="main_reporte" class="row" data-url="reporteProyectoGeneral" ></div>
    	
    	<div class="row">
    	    <div class="col-xs-12 col-md-12">
				
				@if($vista==0)
					<h4>Reporte General</h4>
				@elseif($vista==1)
					<h4>Reporte Planes Sin Aprobación.</h4>
				@endif

				<br><br>
    		</div>
    	</div>
    	<form id="form_reporte_general" method="post">
	    	<div class="row">
	    	    <div class="col-xs-12 col-md-4">
			    	<div class="form-group">	
			    		<input type="hidden" name="vista" value="{{$vista}}">
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
					    <label for="proyecto">3. Fecha inicial</label>
					    <input class="form-control" type="date" name="fecha_inicial" id="fecha_inicial" data-role1="datepicker">
					</div>
	    		</div>
	    		<div class="col-xs-12 col-md-4">
			    	<div class="form-group">	
					    <label for="proyecto">4. Fecha final</label>
					    <input class="form-control" type="date" name="fecha_final" id="fecha_final" data-role="datepicker">
					</div>
	    		</div>
	    	</div>

	    	<div class="row">
	    	    <div class="col-xs-12 col-md-4">
			    	<div class="form-group">	
					</div>
	    		</div>
	    		<div class="col-xs-12 col-md-4">
			    	<div class="form-group center">	
					    <button type="submit" class="btn btn-primary">Generar Reporte</button>
					</div>
	    		</div>
	    		<div class="col-xs-12 col-md-4">
	    		</div>
	    	</div>

	    	<div class="row">
	    		<div class="col-xs-12 col-md-12"></div>
	    		<div class="col-xs-12 col-md-12"><br><hr><br></div>
	    		<div class="col-xs-12 col-md-12"></div>
	    	</div>

	    	<div class="row">
	    	    <div class="col-xs-12 col-md-12">
	    			<div id="contenido_reporte2"></div>
	    		</div>
	    	</div>	

	    	<div class="row">
	    		<div class="col-xs-12 col-md-12"></div>
	    		<div class="col-xs-12 col-md-12"><br><hr><br></div>
	    		<div class="col-xs-12 col-md-12"></div>
	    	</div>

    	</form>

    </div>


 
  <!-- MODAL PAA REPORTE-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Paa_Repor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
      			<div class="row">
					<div class="col-xs-12 col-sm-12">
						<div class="panel" id="panel">
						  <!-- Default panel contents -->
							<div class="panel-heading" id="heading"></div>
							<div class="panel-body">
							    <p id="mnjs"></p>
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
												<th>Valor total estimado	</th>
												<th>Valor estimado en la vigencia actual	</th>
												<th>¿Se requieren vigencias futuras?	</th>
												<th>Estado de solicitud de vigencias futuras	</th>
												<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
												<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
												<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
												<th>Duración estimada del contrato (meses)	</th>
												<th>Recurso Humano (Si / No)</th>
												<th>Número de Contratistas	</th>
												<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
												<th>Proyecto de inversión o rubro de funcionamiento</th>
												<th>Meta plan	</th>
								            </tr>
								        </thead>						       
								        <tbody id="registrosHtml">
								        </tbody>
								</table>
							</div>
						</div>
					</div>


				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-success">Crear</button>-->
      </div>
    </div>
  </div>
</div>

@stop
