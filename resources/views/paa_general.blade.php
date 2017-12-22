@extends('master')             

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/general_paa.js?n=5') }}"></script>	
@stop

@section('content') 
        	<div class="content" id="main_paa_" class="row" data-url="paa" ></div>
            <div class="content">
            	<div class="row">

	                <div class="col-xs-12 col-md-12 text-">
				    	<div class="form-group">	
							<div class="btn-group" role="group" aria-label="...">
								<h3>Consolidado informativo de todos los planes de adquisiiones:</h3>
							</div>
						</div>
		    		</div>

				    <div class="col-xs-12 col-md-12 ">
				    	<hr style="border: 0; border-top: 2px solid #CEECF5; height:0;">
		    		</div>
	    		
	            	<div class="col-xs-12 col-md-12 ">
				    	
					      		<table id="TablaPAA"  class="display responsive no-wrap table table-min" width="100%" cellspacing="0">
						        <thead>
						            <tr>
						                <th>N°</th>
						                <th>ID</th>
						                <th>Estado</th>
						                <th>Sub Dirección</th>
						                <th>Área</th>
						                <th>Fecha <br>inicio </th>
										<th>Códigos<br>UNSPSC</th>
										<th>Modalidad<br>Selección</th>
										<th>Tipo<br>Contrato</th>
										<th data-priority="3">Descripción<br>Objeto</th>
										<th>Valor<br>Estimado</th>
										<th>Valor estimado <br> vigencia actual	</th>
										<th>Duración<br>Estimada (mes)</th>
										<!--<th>Fuente de los recursos (Nombre de la Fuente (s))	</th>-->
										
										<th>¿Se requieren <br>vigencias futuras?	</th>
										<th>Estado de solicitud <br> vigencias futuras	</th>
										<th>Estudio de  conveniencia<br> (dd/mm/aaaa)</th>
										
										<th>Fecha suscripción <br>Contrato (dd/mm/aaaa)	</th>
										<th>Recurso Humano (Si / No)</th>
										<th>Numero de Contratistas	</th>
										<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
										<th>Proyecto de inversión o rubro de funcionamiento</th>
										<th>Meta plan	</th>
										<th  data-priority="2">Menú</th>
						            </tr>
						        </thead>
						        <tfoot>
						            <tr>
						            	<th>N°</th>
						                <th>ID</th>
						                <th>Estado</th>
						                <th>Sub Dirección</th>
						                <th>Área</th>
						                <th>Fecha <br>inicio </th>
										<th>Códigos<br>UNSPSC</th>
										<th>Modalidad<br>Selección</th>
										<th>Tipo<br>Contrato</th>
										<th>Descripción<br>Objeto</th>
										<th>Valor<br>Estimado</th>
										<th>Valor estimado <br> vigencia actual	</th>
										<th>Duración<br>Estimada (mes)</th>
										<!--<th>Fuente de los recursos (Nombre de la Fuente (s))	</th>-->
										
										<th>¿Se requieren <br>vigencias futuras?	</th>
										<th>Estado de solicitud <br> vigencias futuras	</th>
										<th>Estudio de  conveniencia<br> (dd/mm/aaaa)</th>
										
										<th>Fecha suscripción <br>Contrato (dd/mm/aaaa)	</th>
										<th>Recurso Humano (Si / No)</th>
										<th>Numero de Contratistas	</th>
										<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
										<th>Proyecto de inversión o rubro de funcionamiento</th>
										<th>Meta plan	</th>
										<th  data-priority="2">Menú</th>
						            </tr>
						        </tfoot>
						        <tbody id="registros_actividades_responsable">
						        	<?php $var=1; ?>
						        	@foreach($paas as $paa)	

			        						<?php $disable=""; $estado=""; $estudioComve="1"?>
						        			@if($paa['Estado']==4)					    
			        							<tr class="warning">
			        						    <?php $disable="disabled"; $estado="En Subdireción"; $estudioComve="1";?>
			        						@elseif($paa['Estado']==5)	
			        							<tr class="success">
			        							<?php $disable="disabled"; $estado="Aprobado Subdireción. (Sin registro de estudio)"; $estudioComve="0";?>
			        						@elseif($paa['Estado']==6)	
			        							<tr class="danger">
			        							<?php $disable=""; $estado="Denegado Subdireción"; $estudioComve="1";?>
			        						@elseif($paa['Estado']==7)	
			        							<tr class="danger">
			        							<?php $disable="disabled"; $estado="CANCELADO"; $estudioComve="1";?>
			        						@elseif($paa['Estado']==8)	
			        							<tr style="background-color: #DFFFD8 !important;">
			        							<?php $disable="disabled"; $estado="Aprobado Subdireción <b>(Por aprobación del estudio)<b>"; $estudioComve="1";?>
			        						@elseif($paa['Estado']==9)	
			        							<tr style="background-color: #DCFFB3 !important;">
			        							<?php $disable="disabled"; $estado="Aprobado Subdireción <b>(Estudio  aprobado)</b>"; $estudioComve="1";?>
			        						@elseif($paa['Estado']==10)	
			        							<tr style="background-color: #DCD664 !important;">
			        							<?php $disable="disabled"; $estado="Aprobado Subdireción <b>(Correciones pendientes del estudio)</b>"; $estudioComve="0";?>
			        						@elseif($paa['Estado']==11)	
			        							<tr style="background-color: #829E48 !important;">
			        							<?php $disable="disabled"; $estado="Aprobado Subdireción <b>(Cancelado el estudio)</b>"; $estudioComve="1";?>
			        						@else
			        							<tr>
			        							<?php $estado="En Consolidación"; $estudioComve="1";?>
			        						@endif


			        						@if ($paa['compartida']>0)
			        							<?php $var0 = 'C'; ?>
									        @else
									        	<?php $var0 = ''; ?>
									        @endif


									        @if ($paa['vinculada']>0)
									            <?php $var1 = 'V'; ?>
									            <?php $var11 = $paa['vinculada']; ?>
									        @else
									        	<?php $var1 = ''; ?>
									        	<?php $var11 = ''; ?>
									        @endif

									        <?php $nombrementa="";
			                                $nomProyRubro="";
			                                $Proyecto1Rubro2="";?>

											@if ($paa->rubro_funcionamiento->count()>0 && $paa->componentes->count()>0)
			                                    <?php
			                                    $nomProyRubro="Arreglar";//$paa->rubro_funcionamiento['nombre'];
			                                    $nombrementa="N.A";
			                                    $Proyecto1Rubro2="P-R";
			                                    ?>
											@elseif ($paa->componentes->count()>0)
			                                    <?php
			                                    $nomProyRubro=$paa->proyecto['Nombre'];
			                                    $nombrementa=$paa->meta['Nombre'];
			                                    $Proyecto1Rubro2="P";
			                                    ?>
			                                @elseif ($paa->rubro_funcionamiento->count()>0)
			                                    <?php
			                                    $nomProyRubro="";
			                                    $nombrementa="N.A";
			                                    $Proyecto1Rubro2="R";
			                                    ?>
			                                @endif


			        						<th scope="row" class="text-center">{{$var}}</th>
					                        <td class="text-center"><b><p class="text-info text-center" style="font-size: 15px">{{$paa['Registro']}}<BR>{{$var0}}{{$var1}}</p>{{$var11}}<br>{{$Proyecto1Rubro2}}</b></td>
					                        <td><?php echo "<b>".$estado."</b>" ?></td>
					                        <td>{{$paa->area->subdirecion['nombre']}} <br> - <b>{{$paa->area->subdirecion['Iniciales']}}</b></td>
					                        <td>{{$paa->area['nombre']}} <br> <?php echo "<b>".strtoupper($paa->persona['Primer_Nombre']." ".$paa->persona['Primer_Apellido'])."" ?></td>
					                        <td>{{$paa['FechaInicioProceso']}}</td>
					                        <td>{{$paa['CodigosU']}}</td>
					                        <td>{{$paa->modalidad['Nombre']}}</td>
					                        <td>{{$paa->tipocontrato['Nombre']}}</td>
					                        <td><div  style="width:400px;text-align: justify; height: 100px; overflow-y: scroll;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); padding: 10px">{{$paa['ObjetoContractual']}}</div></td>
					                        <td>{{number_format($paa['ValorEstimado'],0,',','.')}}</td>
					                        <td>{{number_format($paa['ValorEstimadoVigencia'],0,',','.')}}</td>
					                        <td>{{$paa['DuracionContrato']}}</td>
					                        <!--<td>{{$paa['FuenteRecurso']}}</td>-->
					                        <td>{{$paa['VigenciaFutura']}}</td>
					                        <td>{{$paa['EstadoVigenciaFutura']}}</td>
					                        <td>{{$paa['FechaEstudioConveniencia']}}</td>
					                        <td>{{$paa['FechaSuscripcionContrato']}}</td>
					                        <td>{{$paa['RecursoHumano']}}</td>
					                        <td>{{$paa['NumeroContratista']}}</td>
					                        <td>{{$paa['DatosResponsable']}}</td>
					                        <td>{{$paa->proyecto['Nombre']}}</td>
					                        <td>{{$nombrementa}}</td>
					                        <td>
												<!--
												<div class="btn-group tama">
												  <div class="btn-group">
												    <button type="button" data-rel="{{$paa['Id']}}" data-funcion="ver_eli" class="btn btn-danger btn-xs2 btn-xs" title="Eliminar Paa" {{$disable}}><span class="glyphicon glyphicon-trash" aria-hidden="true" ></span></button>
												  </div>
												  <div class="btn-group">
												    <button type="button" data-rel="{{$paa['Id']}}" data-funcion="Modificacion" class="btn btn-default btn-xs2 btn-xs"  title="Editar Paa" {{$disable}}><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
												  </div>
												  <div class="btn-group">
												    <button type="button" data-rel="{{$paa['Registro']}}" data-funcion="Historial" class="btn btn-primary  btn-xs2 btn-xs" title="Historial" ><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>
												  </div>
												  <div class="btn-group">
												    <button type="button" data-rel="{{$paa['Id']}}" data-funcion="Financiacion" class="btn btn-success btn-xs2 btn-xs"  title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></button>
												  </div>
												  <div class="btn-group">
												    <button type="button" data-rel="{{$paa['Id']}}" data-funcion="EstudioComveniencia" class="btn btn-warning btn-xs2 btn-xs"  title="Estudio Conveniencia" data-toggle="modal" data-target="#Modal_EstudioComveniencia" {{$estudioComve}}><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></button>
												  </div>
												</div>
												-->
												<div class="btn-group" >
												  <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 170px;">
												    Acciones<span class="caret"></span>
												  </button>
												  <ul class="dropdown-menu" style="padding-left: 2px;">
							
												    
												    <li><button type="button" data-rel="{{$paa['Registro']}}" data-funcion="Historial" class="btn btn-link  btn-xs" title="Historial" ><span class="glyphicon glyphicon-header" aria-hidden="true"></span>   Historial</button></li>
												    
												    <li><button type="button" data-rel="{{$paa['Id']}}" data-funcion="Financiacion" class="btn btn-link  btn-xs"  title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>   Financiación</button>  </li>

												  </ul>
												</div>



												<div><a href="#" class="btn btn-xs btn-default" style="width: 100%;    margin-top: 20px;" data-rel="{{$paa['Registro']}}" data-funcion="Observaciones"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" ></span> Observaciones</a></div>
												<div id=""></div>
					                        </td>
					                        </tr>
					                        <?php $var++; ?>
					                @endforeach
						        </tbody>
						    </table>
						    <b>C</b>= compartida   <b>V</b>= vinculada
					</div>
					<div class="col-xs-12 col-md-12 ">
		            	<br><br><br>
		    		</div>
		    	</div>
            </div>	


<!-- MODAL CREAR PAA-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_AgregarNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CREAR PAA</h4>
      </div>
      <div class="modal-body">
        <form id="form_paa">
        
        		<input type="hidden" class="form-control" name="id_Paa" value="0">
        		<input type="hidden" class="form-control" name="id_registro" value="0">
		        <div class="row">
				  
				  <div class="col-xs-6 col-sm-8">
				  		<div class="form-group">
					    	<label>Códigos UNSPSC </label>
					    	<div class="input-group">
						      <input type="text" class="form-control" name="codigo_Unspsc" autocomplete="off">
						      <span class="input-group-btn">
						        <button class="btn btn-default" type="button" id="agregarCodigos"  >Agregar</button>
						        <button class="btn btn-default" type="button" id="VerAgregarCodigos">Ver</button>
						        <button class="btn btn-default" type="button" id="CerrarAgregarCodigos">Cerrar</button>
						      </span>
						    </div>
						</div>

				  		<table class="table table-condensed table-bordered" id="t_datos_actividad_codigo" style="display: none;" > 
							<thead>
							<tr>
							<th>#</th>
							<th>Codigo</th>
							<th>Eliminar</th>
							</tr>
							</thead>
							<tbody id="registros_cod"> 
							</tbody> 
						</table>

        				<div class="form-group"  id="mensaje_actividad_codigos" style="display: none;">
        					<div id="alert_actividad_codigos"></div>
        				</div>
				  </div>

				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					  		<label>Modalidad de selección</label>
							<select class="form-control" name="modalidad_seleccion">
									<option value="" >Selecionar</option>
									@foreach($modalidades as $modalidad)
										<option value="{{ $modalidad['Id'] }}" >{{ $modalidad['Nombre'] }}</option>
								    @endforeach
							</select>
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-4 col-sm-4">
			  		<div class="form-group">
				    	<label>Tipo de contrato </label>
						<select class="form-control" name="tipo_contrato">
							<option value="" >Selecionar</option>
							@foreach($tipoContratos as $tipoContrato)
								<option value="{{ $tipoContrato['Id'] }}" >{{ $tipoContrato['Nombre'] }}</option>
						    @endforeach
						</select>
					</div>
				  </div>
				  <div class="col-xs-4 col-sm-4">
				  	<div class="form-group">
					    <label>Proceso en curso:</label>
						<select class="form-control" name="proceso_curso" id="proceso_curso">
							<option value="No" >No</option>
							<option value="Si" >Si</option>
						</select>
					</div>
				  </div>
				  <div class="col-xs-4 col-sm-4">
				  </div>
				</div>
				<div class="row">				 
				  <div class="col-xs-12 col-sm-12">
				  		<div class="form-group">
					    	<label>Descripción/Objeto contractual </label>
							<textarea class="form-control" rows="2" id="objeto_contrato" name="objeto_contrato"></textarea>
							Limite: 3000  Contador: <label id="numTextAre"></label>
						</div>
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Valor total estimado </label>
							<input type="text" class="form-control" name="valor_estimado" autocomplete="off">
							<input type="hidden" class="form-control" name="fuente_recurso" value="" ="off">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Valor estimado en la vigencia actual </label>
							<input type="text" class="form-control" name="valor_estimado_actualVigencia" autocomplete="off">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">	
				  			<label>¿Se requieren vigencias futuras?</label>
							<select class="form-control" name="vigencias_futuras">
								<option value="" >Selecionar</option>
								<option value="Si" >Si</option>
								<option value="No" >No</option>
							</select>
						</div>
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Estado de solicitud de vigencias futuras </label>
							<select class="form-control" name="estado_solicitud">
								<option value="">Seleccionar</option>
								<option value="NO SOLICITADAS">NO SOLICITADAS</option>
								<option value="SI SOLICITADAS">SI SOLICITADAS</option>
								<option value="N/A">N/A</option>
							</select>
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Fecha estudio de  conveniencia</label><br><br>
							<input type="text" class="form-control" name="estudio_conveniencia" data-role="datepicker" placeholder="No aplica" autocomplete="off"  disabled>
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					  		<label> Fecha estimada de inicio de proceso de selección</label>
							<input type="text" class="form-control" name="fecha_inicio"  data-role1="datepicker" placeholder="aa/mm/dd" autocomplete="off" readonly="readonly">
						</div>
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Fecha suscripción Contrato </label><br><br>
							<input type="text" class="form-control" name="fecha_suscripcion"  data-role="datepicker" placeholder="aa/mm/dd" autocomplete="off">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Duración estimada del contrato<br> (Ejem: 10 meses 15 dias)</label>
							<input type="text" class="form-control" name="duracion_estimada" autocomplete="off">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4" style="display: none">
				  		<div class="form-group">
					  		<label>Meta plan</label>
							<input type="text" class="form-control" name="meta_plan" autocomplete="off">
						</div>
				  </div>
				   <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Recurso Humano </label><br><br>
							<select class="form-control" name="recurso_humano">
								<option value="" >Selecionar</option>
								<option value="Si" >Si</option>
								<option value="No" >No</option>
							</select>
						</div>
				  </div>
				</div>

				<div class="row">
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					    	<label>Numero de Contratistas</label>
							<input type="text" class="form-control" name="numero_contratista" autocomplete="off">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  		<div class="form-group">
					  		<label>Ordenador de Gasto Encargado:</label>
							<select class="form-control" id="ordenadorGasto">
								<option value="No" >No</option>
								<option value="Si" >Si</option>
							</select>
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-4">
				  </div>
				</div>
				<div class="row" style="display: none" id="contenidoOrdenado">
				  <div class="col-xs-6 col-sm-6">
				  		<div class="form-group">
					    	<label>Cedula (Ordenador del Gasto E)</label>
							<input type="text" class="form-control" name="cedula_contacto" autocomplete="off">
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-6">
				  		<div class="form-group">
					  		<label>Nombre (Ordenador del Gasto E)</label>
							<input type="text" class="form-control" name="datos_contacto" autocomplete="off">
						</div>
				  </div>
				</div>


				<div class="row">
				  <div class="col-xs-6 col-sm-6">
				  		<div class="form-group">
					    	<label>Proyecto de inversión o rubro</label>
					    	<input type="hidden" name="id_pivot_comp" id="id_pivot_comp"></input>
							<select class="form-control" name="Proyecto_inversion" id="Proyecto_inversion">
								<option value="" >Selecionar</option>
								@foreach($proyectos as $proyecto)
									<option value="{{ $proyecto['Id'] }}" >{{ $proyecto['Nombre'] }}</option>
							    @endforeach
							</select>
						</div>
				  </div>
				  <div class="col-xs-6 col-sm-6">
				  		<div class="form-group">
					    	<label>Meta Plan</label>
					    	<select class="form-control" name="meta" id="meta">
								<option value="" >Selecionar</option>
							</select>
						</div>
				  </div>
				</div>

				<div id="div_finaciacion">
				<div class="row">
				  	<div class="col-xs-12 col-sm-12">
				  	<hr>
				  		<h4 class="modal-title" id="myModalLabel">AGREGAR FINANCIACIÓN</h4>
					</div>
				</div>

				<div class="row">
				  <div class="col-xs-12 col-sm-12">
				  		<div class="form-group">
					    	<label>Fuente</label>
					    	<input type="hidden" name="id_pivot_comp" id="id_pivot_comp"></input>
							<select class="form-control" name="Fuente_inversion" id="Fuente_inversion">
								<option value="" >Selecionar</option>
								@foreach($fuentes as $fuente)
									<option value="{{ $fuente['Id'] }}" >{{ $fuente['codigo'] }} - {{ $fuente['nombre'] }}</option>
							    @endforeach
							</select>
						</div>
				  </div>
				  <div class="col-xs-12 col-sm-12">
				  		<div class="form-group">
					    	<label>Componente</label>
							<select class="form-control" name="componnente" id="componnente">
								<option value="" >Selecionar</option>
							</select>
						</div>
						
				  </div>
				  <div class="col-xs-12 col-sm-4">
				  	<div class="form-group">
					  		<label>Valor</label>
							<input type="text" class="form-control" name="valor_contrato" autocomplete="off">
					</div>
					<button type="button" class="btn btn-primary" id="agregarFinanciacion">Agregar</button>
        			<button  type="button" class="btn btn-info" id="VerAgregarFinanciacion">Ver</button>
				  </div>
				  <div class="col-xs-12 col-sm-8">
				  	<div class="mjs_componente"></div>
				  </div>
				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-12">
        				<div class="form-group"  id="mensaje_actividad" style="display: none;">
        					<div id="alert_actividad"></div>
        				</div>
				  	<hr>
					</div>
					<div class="col-xs-12 col-sm-12">
				  		<table class="table table-bordered" id="datos_actividad" > 
							<thead>
							<tr>
							<th>#</th>
							<th>Proyecto</th>
							<th>Componente</th>
							<th>Valor</th>
							<th>Eliminar</th>
							</tr>
							</thead>
							<tbody id="registros"> 
							</tbody> 
						</table>
					</div>
				</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12">
				  		<div class="alert alert-info" id="mjs_mod_denegada" style="display: none">
						  <strong>Información</strong> Actualmente se encuentra en aprobación por la Sub Dirección y no puede ser modificada. 
						</div>
					</div>
				</div>
      </div>
      <div class="modal-footer">
        <div id="mjs_registroPaa" class="alert alert-success" style="display: none"></div>
        <input type="hidden" name="Dato_Actividad" class="form-control">
        <input type="hidden" name="Dato_Actividad_Codigos" class="form-control">
        <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
        <button  type="submit" class="btn btn-success" id="crear_paa_btn">CREAR</button>
      </div>
     </form>

    </div>
  </div>
</div>








	<!-- MODAL FIANANCIACION-->
	<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Financiacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-success" id="myModalLabel">Listado de Financiación Proyecto de Inversión.</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<table class="table table-bordered" id="datos_actividad2" >
								<thead class="thead-inverse table-success">
								<tr class="success">
									<th>#</th>
									<th>Proyecto de Inversión</th>
									<th>Fuente</th>
									<th>Componente</th>
									<th>Meta</th>
									<th>Valor</th>
								</tr>
								</thead>
								<tbody id="registrosFinanzas">
								</tbody>
							</table>
						</div>
					</div>
				</div>

     			<div class="row">
					<div class="col-xs-12 col-sm-12"><hr style="border-color: #178acc;"></div>
				</div>

     			 <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-warning" id="myModalLabel">Listado de Financiación Rubros de Funcionamiento.</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<table class="table table-bordered" id="datos_actividad3" >
								<thead class="thead-inverse">
								<tr class="warning">
									<th>#</th>
									<th>Rubro de funcionamiento.</th>
									<th>Fuente</th>
									<th>Valor</th>
								</tr>
								</thead>
								<tbody id="registrosFinanzasRubro">
								</tbody>
							</table>
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
    		</div>
  		</div>
	</div>










<!-- MODAL FIANANCIACION-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Historial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Historial de modificaciones</h4>
      </div>
      <div class="modal-body">
      			<div class="row">
					<div class="col-xs-12 col-sm-12">
						<div class="panel panel-success">
						  <!-- Default panel contents -->
							<div class="panel-heading">Registro Vigente</div>
							<div class="panel-body">
							    <p>Registro que actualmente es valido para todos los usuarios.</p>
							</div>						 
							<div class="table-responsive">
								<table  id="Tabla1" class="table display nowrap table-bordered" width="780px" cellspacing="0">
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
												<th>Numero de Contratistas	</th>
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
						<div id="mensaje_justi" class="alert alert-success" style="display: none"></div>
					</div>

					<div class="col-xs-12 col-sm-12">
						<hr>
					</div>
					
					<div class="col-xs-12 col-sm-12">
						<div class="panel panel-warning">
						  <!-- Default panel contents -->
							<div class="panel-heading">Historial de registros</div>
							<div class="panel-body">
							    <p>Los siguientes registros son el historial de cambios aprobados por los difrentes usuarios durante el actual proceso.</p>
							</div>	
					  		<div class="table-responsive"> 
						  		<table  id="Tabla2" class="table display nowrap table-bordered" width="780px" cellspacing="0">
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
												<th>Numero de Contratistas	</th>
												<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
												<th>Proyecto de inversión o rubro de funcionamiento</th>
												<th>Meta plan	</th>
								            </tr>
								        </thead>	
								        <tbody id="registrosHtml1">
								        </tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12">
					 	<hr>
					</div>
					<div class="col-xs-12 col-sm-12">
						<div class="panel panel-danger">
						  <!-- Default panel contents -->
							<div class="panel-heading">Registros pendientes por revisión</div>
							<div class="panel-body">
							    <p>Los siguientes registros están pendientes de revisión.</p>
							</div>
							<div class="table-responsive">
						  		<table  id="Tabla3" class="table display nowrap table-bordered" width="780px" cellspacing="0">
							        <thead>
										<tr class="success">
							                <th>N°</th>
							                <th>Id Registro</th>
											<th>Códigos UNSPSC</th>
											<th>Modalidad de selección</th>
											<th>Tipo de contrato</th>
											<th>Descripción/Objeto</th>
											<th>Valor total estimado</th>
											<th>Valor estimado en la vigencia actual</th>
											<th>¿Se requieren vigencias futuras?</th>
											<th>Estado de solicitud de vigencias futuras</th>
											<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
											<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)</th>
											<th>Fecha suscripción Contrato (dd/mm/aaaa)</th>
											<th>Duración estimada del contrato (meses)</th>
											<th>Recurso Humano (Si / No)</th>
											<th>Numero de Contratistas</th>
											<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
											<th>Proyecto de inversión o rubro de funcionamiento</th>
											<th>Meta plan	</th>
							            </tr>
							        </thead>	
							        <tbody id="registrosHtml1">
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









<!-- MODAL EDITAR-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Formulario Editable</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success">Crear</button>
      </div>
    </div>
  </div>
</div>



<!-- MODAL ELIMINAR-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar PAA</h4>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="idRegist_inpt"></input>
      	<div >Desea eliminar el PAA con numero de registro: <label id="idRegist"></label> ?</div>
      	<div id="mjs_ElimRegistro" class="alert alert-success" style="display: none"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger" id="ElimianrPAA_btn">Eliminar</button>
      </div>
    </div>
  </div>
</div>


<!-- MODAL HISTORIAL DE ELIMIANCION-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_HistorialEliminar1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Historial de Eliminación</h4>
      </div>
      
	      <div class="modal-body">
	      		<div class="row">
	      			<div class="col-xs-12 col-sm-12">
						<div class="panel panel-danger">
							<div class="panel-heading">Historial de Registros Eliminados</div>
							<div class="panel-body">
							    <p>Los siguientes registros estan en estado eliminado.</p>
							</div>	
							<div class="table-responsive"> 
						  		<table  id="Tabla4" class="display nowrap table-bordered" width="780px" cellspacing="0">
								        <thead>
											<tr class="success">
								                <th>N°</th>
								                <th>Id Registro</th>
												<th>Códigos UNSPSC</th>
												<th>Modalidad de selección</th>
												<th>Tipo de contrato</th>
												<th>Descripción/Objeto</th>
												<th>Fuente de los recursos (Nombre de la Fuente (s))	</th>
												<th>Valor total estimado	</th>
												<th>Valor estimado en la vigencia actual	</th>
												<th>¿Se requieren vigencias futuras?	</th>
												<th>Estado de solicitud de vigencias futuras	</th>
												<th>Estudio de  conveniencia (dd/mm/aaaa)</th>
												<th>Fecha estimada de inicio de proceso de selección - Fecha  (dd/mm/aaaa)	</th>
												<th>Fecha suscripción Contrato (dd/mm/aaaa)	</th>
												<th>Duración estimada del contrato (meses)	</th>
												<th>Meta plan	</th>
												<th>Recurso Humano (Si / No)</th>
												<th>Numero de Contratistas	</th>
												<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
												<th>Proyecto de inversión o rubro de funcionamiento</th>
								            </tr>
								        </thead>	
								        <tbody id="registrosHtml1">
								        </tbody>
								</table>
							</div>
						</div>
					</div>
	      		</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-success">Crear</button>
	      </div>
      
    </div>
  </div>
</div>


<!-- MODAL FIANANCIACION-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_EstudioComveniencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
		<div class="modal-header">

	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Estudio de Conveniencia y oportunidad </h4>
	        PAA N°: <label id="id_Fin"></label>
	        <div id="mjs_estado_estudio" class="alert alert-info"></div>
	        <div id="mjs_estado_estudio2" class="alert alert-info"></div>
	    </div>
	    <form id="form_agregar_estudio_comveniencia">
			<div class="modal-body">
				<div class="row"  >
					   <div class="col-xs-12 col-sm-12">
					  		<div class="form-group">
						    	<label>Conveniencia</label>
								<textarea class="form-control" rows="3" name="texta_Conveniencia"></textarea>
							</div>
					  </div>
					   <div class="col-xs-12 col-sm-12">
					  		<div class="form-group">
						    	<label>Oportunidad</label>
								<textarea class="form-control" rows="3" name="texta_Oportunidad"></textarea>
							</div>
					  </div>
					  <div class="col-xs-12 col-sm-12">
					  		<div class="form-group">
						    	<label>Justificación</label>
								<textarea class="form-control" rows="3" name="texta_Justificacion"></textarea>
							</div>
					  </div>

					  <div class="col-xs-12 col-sm-12">
					  		<h4>Clasificación Fuentes de Financiación</h4>
					  		<hr/>
					  </div>
					  <div class="col-xs-12 col-sm-12">
					  		<div class="form-group">
						    	<label>Detalle fuente hacienda</label>
								<select class="form-control" name="Fuente_ingre" id="Fuente_ingre">
									<option value="" >Selecionar</option>
								    @foreach($fuenteHaciendas as $fuente)
										<option value="{{ $fuente['id'] }}" >{{ $fuente['codigo'] }} - {{ $fuente['nombre'] }}</option>
								    @endforeach
								</select>
							</div>
					  </div>

					  <div class="col-xs-12 col-sm-6">
					  		<div class="form-group">
						    	<label>Componentes ingresados</label>
								<select class="form-control" name="Componente_ingresado" id="Componente_ingresado">
								</select>
							</div>
					  </div>
					  
					  <div class="col-xs-12 col-sm-6">
					  		<div class="form-group">
						    	<label>Actividades de la meta:  </label><label id="mensj_meta"></label>
								<select class="form-control" name="actividad_ingre" id="actividad_ingre">
									<option value="" >Selecionar</option>								    
								</select>
							</div>
					  </div>

					  <div class="col-xs-12 col-sm-3">
					  		<div class="form-group">
						    	<label>Valor</label>
								<input type="text" class="form-control" name="valor_componente" readonly="readonly" value="0">
							</div>
					  </div>
					  <div class="col-xs-12 col-sm-3">
					  		<div class="form-group">
						    	<label>Porcentaje</label>
								<input type="text" class="form-control" name="valor_conponente_ingre">
							</div>
					  </div>
					  <div class="col-xs-12 col-sm-3">
					  		<div class="form-group">
						    	<label>Total</label>
								<input type="text" class="form-control" name="valor_total_ingr" readonly="readonly">
							</div>
					  </div>
					  <div class="col-xs-12 col-sm-3">
					  		<div class="form-group">
						    	<label>Opciones</label><br>
								<div class="btn-group" role="group" aria-label="Basic example">
								  <button type="button" class="btn btn-primary" id="agregar_financiacion">Agregar</button>
								  <button type="button" class="btn btn-info" id="ver_tabla_finanza">Ver</button>
								</div>
							</div>
					  </div>
					  <div class="col-xs-12 col-sm-12">
					  	<table class="table table-condensed table-bordered" id="t_datos_ingreso_finanza" > 
							<thead class="thead-inverse">
							<tr>
							<th>#</th>
							<th>Fuente</th>
							<th>Componente</th>
							<th>Actividad</th>
							<th>Valor</th>
							<th>Porcentaje</th>
							<th>Total</th>
							<th>Eliminar</th>
							</tr>
							</thead>
							<tbody id="registros_finanza"> 
							</tbody> 
						</table>

						  <div class="form-group"  id="mensaje_actividad_finan" style="display: none;">
	        				 	<div id="alert_actividad_finca"></div>
	        			  </div>
        			  </div>
					  <div class="col-xs-12 col-sm-12">
					  	<div id="mjs_Observa_Fina" class="alert alert-success" style="display: none"></div>
					  	<div id="mjs_Observa_Fina2" class="alert alert-danger" style="display: none"></div>
					  </div>
				</div>
	      	</div>
      
	      <div class="modal-footer" >
	      	<div class="row">
	        	<div class="col-xs-12 col-sm-12" style="text-align: left;">
	        		
	        		
	        		<input type="hidden" name="campos_Clasi_Finan" id="campos_Clasi_Finan"></input>
	        		<input type="hidden" name="id_estudio" id="id_estudio"></input>
	        		<input type="hidden" name="id_estudio_pass" id="id_estudio_pass" value="0"></input>
	        		<button type="submit" class="btn btn-success" id="RegistrarEstudio">REGISTRAR</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
				</div>
	        </div>
	      </div>
      </form>

    </div>
  </div>
</div>




<!-- MODAL COMPOARTIDA-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Compartida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
		<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Plan de adquisición compartido</h4>
	        PAA N°: <label id="id_Fin2">

	    </div>
	    <form id="form_agregar_compartida">
			<div class="modal-body">
				<div class="row"  >
					   <div class="col-xs-12 col-sm-12">
					  		<div class="form-group">
						    	<label>Desea que este plan pueda ser compartido con otras áreas?</label><br>
								  <button type="button" class="btn btn-default" id="Compartida">Compartida</button>
								  <button type="button" class="btn btn-default" id="CompartidaNo">No compartida</button>
							</div>
					  </div>
				</div>
	      	</div>
      
	      <div class="modal-footer">
	      	<div class="row">
	        	<div class="col-xs-12 col-sm-12">
	        		<input type="hidden" name="id_estudio2" id="id_estudio2"></input>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
	        </div>
	      </div>
      </form>

    </div>
  </div>
</div>




<!-- MODAL VINCULADA-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Vinculada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
		<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Plan de adquisición vinculada</h4>
	        PAA N°: <label id="id_Fin3">

	    </div>
	    <form id="form_vinvular">
			<div class="modal-body">
				<div class="row"  >
					   <div class="col-xs-12 col-sm-6">
					  		<div class="form-group">
								<div class="form-group">
									<label>SubDirección:</label>
									<select class="form-control" name="selectSubdirecion">
											<option value="" >Selecionar</option>
											@foreach($subDirecciones as $subDireccion)
												<option value="{{ $subDireccion['id'] }}" >{{ $subDireccion['nombre'] }}</option>
										    @endforeach
									</select>
								</div>
							</div>
					  </div>

					  <div class="col-xs-12 col-sm-6">
					  		<div class="form-group">
								<div class="form-group">
									<label>Área:</label>
									<select class="form-control" name="selectArea">
										<option value="" >Selecionar</option>
									</select>
								</div>
							</div>
					  </div>

					  <div class="col-xs-12 col-sm-12">
					  		<div class="form-group">
								<div class="form-group">
									<label>Área:</label>
									<select class="form-control" name="selectPaa">
										<option value="" >Selecionar</option>
									</select>
								</div>
							</div>
					  </div>
					  <div class="col-xs-12 col-sm-12">
					  		<div id="mjs_Observa_vinvula" class="alert alert-success" style="display: none"></div>
					  </div>
				</div>
	      	</div>
      
	      <div class="modal-footer">
	      	<div class="row">
	        	<div class="col-xs-12 col-sm-12">
	        		<input type="hidden" name="id_estudio3" id="id_estudio3"></input>
					<button type="submit" class="btn btn-success" >Agregar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
	        </div>
	      </div>
      </form>

    </div>
  </div>
</div>


<!-- MODAL APRIOBACION CAMBIOS-->

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Observaciones_paa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Listado de observaciones</h4>
      </div>
      <form id="form_aprobacion">
	      <div class="modal-body">
	      			<div class="row">
						<div class="col-xs-12 col-sm-12">
							<div class="panel panel-warning">
							  <!-- Default panel contents -->
								<div class="panel-heading">Observaciones PAA N° <label class="NumPaa"></label></div>
								<div class="panel-body">
								    <table class="table table-bordered" id="datos_actividad" > 
										<thead>
										<tr>
										<th>#</th>
										<th>Usuario</th>
										<th>Observación</th>
										<th>Clase</th>
										<th>Fecha y Hora</th>
										</tr>
										</thead>
										<tbody id="registrosObser"> 
										</tbody> 
									</table>
								</div>		
							</div>
							<div class="form-group">
								    <textarea class="form-control" placeholder="Espacio para escribir observaciones.." name="observacio" id="observacio"></textarea>
							</div>
							<div class="form-group">
									<input type="hidden" name="paa_registro" id="paa_registro"></input>
								    <a href="#"  id="regisgtrar_observacion_ppa" class="btn btn-block btn-primary btn-success"><span class="glyphicon glyphicon-ok"></span> Agregar Observación</a>
							</div>
							<div id="mjs_Observa" class="alert alert-success" style="display: none"></div>
						</div>
					</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      </div>
      </form>
    </div>
  </div>
</div>
@stop
