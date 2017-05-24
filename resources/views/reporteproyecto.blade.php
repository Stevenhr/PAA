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
    	<form id="form_reporte_proyecto" method="post">
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
    	</form>

    	<div class="row" style="display: none; padding-top: 50px; " id="panel_grafico">
    	    <div class="col-xs-12 col-md-12">
    	    	<div class="page-header">
				  <h1 id="NomPro"></h1>
				</div>
			</div>
    	    <div class="col-xs-12 col-md-6">
    	    	<div class="panel panel-default" >
				  <div class="panel-heading">Grafica:</div>
				  <div class="panel-body">
				    <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
				  </div>
				</div>
    		</div>
    		<div class="col-xs-12 col-md-6">
    	    	<div class="panel panel-default" >
				  <div class="panel-heading">Datos:</div>
				  <div class="panel-body">
				  <div class="table-responsive" id="datosproyecto"></div>
				  </div>
				</div>
    		</div>
    	</div>

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
