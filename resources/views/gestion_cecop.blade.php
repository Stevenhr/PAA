@extends('master')

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/cecop.js') }}"></script>	
@stop

@section('content') 
<div id="main" class="content" data-url="cecop"></div>
<div class="content">
	<div class="row">

        <div class="col-xs-12 col-md-12 text-">
        <h3>Generacion Informe CECOP:</h3>
        <p>Historial y generación de informes de cecop.</p>
	    	<div class="form-group">	
				<div class="btn-group" role="group" aria-label="...">
				  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Modal_AgregarNuevoCecop" id="Btn_Agregar_Nuevo">
				  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar nuevo
				  </button>
				</div>
			</div>
		</div>

	    <div class="col-xs-12 col-md-12 ">
	    	<hr style="border: 0; border-top: 2px solid #CEECF5; height:0;">
		</div>

		<div class="col-xs-12 col-md-12 ">
				    	
					      		<table id="TablaHCecop"  class="display responsive no-wrap table table-min" width="100%" cellspacing="0">
						        <thead>
						            <tr>
						                <th>N°</th>
						                <th>Usuario</th>
						                <th>Fecha Generación</th>
										<th>Codigo Cecop</th>
										<th>Archivo Paa</th>				
										<th>Subir Datos</th>
						            </tr>
						        </thead>
						        <tfoot>
						            <tr>
						                <th>N°</th>
						                <th>Usuario</th>
						                <th>Fecha Generación</th>
										<th>Codigo Cecop</th>
										<th>Archivo Paa</th>				
										<th>Subir Datos</th>
						            </tr>
						        </tfoot>
						        <tbody id="registros_actividades_responsable">
						      		@foreach($historiales as $historial)	
							            <tr>
							                <td>N°</td>
							                <td>{{$historial['id_usuario']}}</td>
							                <td>{{$historial['fecha_generacion']}}</td>
											<td>{{$historial['codigo_cecop']}}</td>
											<td>{{$historial['ubicacion_archivo']}}</td>				
											<td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#Modal_AgregarNuevo" id="Btn_Agregar_Nuevo">
											  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar datos
											  </button>
											</td>
							            </tr>
							        @endforeach
						        </tbody>
						    </table>
					</div>
	</div>
</div>




<!-- MODAL APRIOBACION CAMBIOS-->

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_AgregarNuevoCecop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Generación informe Cecop</h4>
      </div>
     
	      <div class="modal-body">
	      			<div class="row">
						<div class="col-xs-12 col-sm-12">
							<div class="panel panel-warning">
							  <!-- Default panel contents -->
								<div class="panel-heading">Procedimiento Informe Cecop <label class="NumPaa"></label></div>
								<div class="panel-body">
								    <p>En el momento que se genera el informe se crea un registro en la tabla historial, aqui usted debera ingresar el codigo que recibe del sistema Cecop y ademas subir archivo que envio a este sistema.</p>
								    <form action="informececop" >
								    <input type="hidden" name="id_paa_estudio_f" id="id_paa_estudio_f" value="1"/>
								    <div class="text-center"><button type="submit" id="aprobacion_Sub_Direccion" class="btn btn-success">Generar Informe</button></div>
								    </form>
								</div>						 
							</div>
							<input type="hidden" name="paa_subDirecion" id="paa_subDirecion"></input>
							<div id="mensaje_aprobacion_final" class="alert alert-success" style="display: none"></div>
							<div id="mensaje_aprobacion_final2" class="alert alert-info" style="display: none">
								<strong>Cambios Pendiente!</strong> Antes de enviar a Sub. Dirección debe revisar los cambios pendientes.
							</div>
						</div>
					</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      </div>
   
    </div>
  </div>
</div>


@stop