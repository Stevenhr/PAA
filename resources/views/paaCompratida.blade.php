@extends('master')

@section('script')
	@parent
	<script src="{{ asset('public/Js/PAA/paaCompartido.js') }}"></script>
@stop

@section('content')

	<div class="content" id="main_paa_" class="row" data-url="paacompartida" ></div>
	<div class="content">

		<div class="row">

			<div class="col-xs-12 col-md-12 ">
				<h3>Planes compartidos por otras áreas</h3>
				<hr style="border: 0; border-top: 2px solid #CEECF5; height:0;">
			</div>

			<div class="col-xs-12 col-md-12 ">

				<table id="TablaPAA"  class="display responsive no-wrap table table-min" width="100%" cellspacing="0">
					<thead>
					<tr>
						<th>N°</th>
						<th>ID</th>
						<th>Usuario</th>
						<th>Estado</th>
						<th>Área</th>
						<th>Códigos<br>UNSPSC</th>
						<th>Modalidad<br>Selección</th>
						<th>Tipo<br>Contrato</th>
						<th data-priority="3">Descripción<br>Objeto</th>
						<th>Valor<br>Estimado</th>
						<th>Duración<br>Estimada</th>
						<!--<th>Fuente de los recursos (Nombre de la Fuente (s))	</th>-->
						<th>Valor estimado <br> vigencia actual	</th>
						<th>¿Se requieren <br>vigencias futuras?	</th>
						<th>Estado de solicitud <br> vigencias futuras	</th>
						<th>Estudio de  conveniencia<br> (dd/mm/aaaa)</th>
						<th>Fecha estimada de inicio de <br>proceso de selección - Fecha  (dd/mm/aaaa)	</th>
						<th>Fecha suscripción <br>Contrato (dd/mm/aaaa)	</th>
						<th>Recurso Humano (Si / No)</th>
						<th>Número de Contratistas	</th>
						<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
						<th>Proyecto de inversión o rubro de funcionamiento</th>
						<th  data-priority="2">Menú</th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th>N°</th>
						<th>ID</th>
						<th>Usuario</th>
						<th>Estado</th>
						<th>Área</th>
						<th>Códigos<br>UNSPSC</th>
						<th>Modalidad<br>Selección</th>
						<th>Tipo<br>Contrato</th>
						<th>Descripción<br>Objeto</th>
						<th>Valor<br>Estimado</th>
						<th>Duración<br>Estimada (mes)</th>
						<!--<th>Fuente de los recursos (Nombre de la Fuente (s))	</th>-->
						<th>Valor estimado <br> vigencia actual	</th>
						<th>¿Se requieren <br>vigencias futuras?	</th>
						<th>Estado de solicitud <br> vigencias futuras	</th>
						<th>Estudio de  conveniencia<br> (dd/mm/aaaa)</th>
						<th>Fecha estimada de inicio de <br>proceso de selección - Fecha  (dd/mm/aaaa)	</th>
						<th>Fecha suscripción <br>Contrato (dd/mm/aaaa)	</th>
						<th>Recurso Humano (Si / No)</th>
						<th>Número de Contratistas	</th>
						<th>Datos de contacto del responsable (Ordenador del Gasto)</th>
						<th>Proyecto de inversión o rubro de funcionamiento</th>
						
						<th  data-priority="2">Menú</th>
					</tr>
					</tfoot>
					<tbody id="registros_actividades_responsable">
                    <?php $var=1; ?>
					@foreach($paas as $paa)

                        <?php $disable=""; $estado=""; $estudioComve="1"?>
						@if($paa['Estado']==4)
							<tr class="danger">
                            <?php $disable="disabled"; $estado="En Subdireción"; $estudioComve="1";?>
						@elseif($paa['Estado']==5)
							<tr class="danger">
                            <?php $disable="disabled"; $estado="Aprobado Subdireción. (Sin registro de estudio)"; $estudioComve="0";?>
						@elseif($paa['Estado']==6)
							<tr class="danger">
                            <?php $disable=""; $estado="Denegado Subdireción"; $estudioComve="1";?>
						@elseif($paa['Estado']==7)
							<tr class="danger">
                            <?php $disable="disabled"; $estado="CANCELADO"; $estudioComve="1";?>
						@elseif($paa['Estado']==8)
							<tr class="danger">
                            <?php $disable="disabled"; $estado="Aprobado Subdireción <b>(Por aprobación del estudio)<b>"; $estudioComve="1";?>
						@elseif($paa['Estado']==9)
							<tr class="danger">
                            <?php $disable="disabled"; $estado="Aprobado Subdireción <b>(Estudio  aprobado)</b>"; $estudioComve="1";?>
						@elseif($paa['Estado']==10)
							<tr class="danger">
                            <?php $disable="disabled"; $estado="Aprobado Subdireción <b>(Correciones pendientes del estudio)</b>"; $estudioComve="0";?>
						@elseif($paa['Estado']==11)
							<tr class="danger">
                            <?php $disable="disabled"; $estado="Aprobado Subdireción <b>(Cancelado el estudio)</b>"; $estudioComve="1";?>
						@else
							<tr class="danger" >
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


								@if ($paa['unidad_tiempo']==0)
									<?php $uni_t = "Dias"; ?>
								@elseif($paa['unidad_tiempo']==1)
									<?php $uni_t = "Mes"; ?>
								@elseif($paa['unidad_tiempo']==2)
									<?php $uni_t = "Años"; ?>
								@else
									<?php $uni_t = ""; ?>
								@endif

                                <?php $nombrementa="";
                                $nomProyRubro="";
                                $Proyecto1Rubro2="";?>

								@if ($paa->rubro_funcionamiento->count()>0 && $paa->componentes->count()>0)
                                    <?php
                                    $nomProyRubro="Areglar";//$paa->rubro_funcionamiento['nombre'];
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
								<td class="text-center"><b><p class="text-info text-center" style="font-size: 15px">{{$paa['Registro']}}<BR>{{$var0}}{{$var1}}{{$var11}}<br>{{$Proyecto1Rubro2}}</b></p></td>
								<td><?php echo "<b>".$paa->persona['Primer_Nombre']." ".$paa->persona['Primer_Apellido']."</b>" ?></td>
								<td><?php echo "<b>".$estado."</b>" ?></td>
								<td>{{$paa->area['nombre']}} <br> <?php echo "<b>".$paa->persona['Primer_Nombre']." ".$paa->persona['Primer_Apellido']."" ?></td>
								<td>{{$paa['CodigosU']}}</td>
								<td>{{$paa->modalidad['Nombre']}}</td>
								<td>{{$paa->tipocontrato['Nombre']}}</td>
								<td><div  class="campoArea">{{$paa['ObjetoContractual']}}</div></td>
								<td>{{number_format ($paa['ValorEstimado'])}}</td>
								<td>{{$paa['DuracionContrato']}} - {{$uni_t}}</td>
							<!--<td>{{$paa['FuenteRecurso']}}</td>-->
								<td>{{number_format($paa['ValorEstimadoVigencia'])}}</td>
								<td>{{$paa['VigenciaFutura']}}</td>
								<td>{{$paa['EstadoVigenciaFutura']}}</td>
								<td>{{$paa['FechaEstudioConveniencia']}}</td>
								<td>{{$paa['FechaInicioProceso']}}</td>
								<td>{{$paa['FechaSuscripcionContrato']}}</td>
								<td>{{$paa['RecursoHumano']}}</td>
								<td>{{$paa['NumeroContratista']}}</td>
								<td>{{$paa['DatosResponsable']}}</td>
								<td>{{$nombrementa}}</td>

								<td>
				
									<div class="btn-group" >
										<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 170px;">
											Acciones<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" style="padding-left: 2px;">

											<li><button type="button" data-rel="{{$paa['Id']}}" data-funcion="Financiacion" class="btn btn-link  btn-xs"  title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>   Financiación</button>  </li>

											<li><button type="button" data-rel="{{$paa['Id']}}" data-funcion="Modal_Vinculada" class="btn btn-link btn-xs"  title="Estudio Conveniencia" data-toggle="modal" data-target="#Modal_Vinculada" ><span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>   Vinculada</button></li>

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
				<br>
				<b>P</b>= Proyecto de inversión   <b>R</b>= Rubro de funcionamiento        <b>P-R</b>= Proyecto y Rubro
			</div>
			<div class="col-xs-12 col-md-12 ">
				<br><br><br>
			</div>
		</div>
	</div>



	<!-- MODAL FIANANCIACION-->
	<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Modal_Financiacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-success" id="myModalLabel">Listado de Financiación PAA compartida. <p id="id_p"></p></h4>

				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<p>Finaciación registrada por otra áreas:</p>
					    </div>
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
						<div class="col-xs-12 col-sm-12">
							<b><p>Registré su finaciación:</p></b>
					    </div>
						<div class="col-xs-12 col-sm-12">
							<table class="table table-bordered" id="tabla_proyecto_compratido" >
								<thead class="thead-inverse table-success">
								<tr class="success">
									<th>#</th>
									<th>Proyecto de Inversión</th>
									<th>Fuente</th>
									<th>Componente</th>
									<th>Meta</th>
									<th>Valor</th>
									<th>Eliminar</th>
								</tr>
								</thead>
								<tbody id="registrosFinanzasCompartida">
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<form id="form_agregar_finza">
						<div class="row"  >
							  <div class="col-xs-12 col-sm-12">
								<div class="form-group">
									<label class="text-success">Proyecto</label>
									<input type="hidden" name="id_act_agre" id="id_act_agre">
									<select class="form-control" name="Proyecto_Finanza" id="Proyecto_Finanza">
										<option value="" >Selecionar</option>
									</select>
								</div>
						      </div>
						      <div class="col-xs-12 col-sm-12">
								<div class="form-group">
									<label class="text-success" >Meta</label>
									<select class="form-control" name="Meta_Finanza" id="Meta_Finanza">
										<option value="" >Selecionar</option>
									</select>
								</div>
						      </div>
							  <div class="col-xs-12 col-sm-12">
								<div class="form-group">
									<label class="text-success" >Fuente</label>
									<select class="form-control" name="Fuente_Finanza" id="Fuente_Finanza">
										<option value="" >Selecionar</option>
									</select>
								</div>
						      </div>
						      <div class="col-xs-12 col-sm-12">
						  		<div class="form-group">
							    	<label class="text-success">Componente de gasto</label>
									<select class="form-control" name="Componnente_Finanza" id="Componnente_Finanza">
										<option value="" >Selecionar</option>
									</select>
								</div>
						      </div>
							  <div class="col-xs-12 col-sm-4">
							  	<div class="form-group">
								  		<label class="text-success">Valor</label>
										<input type="text" class="form-control success" name="valor_contrato" id="valor_contrato" autocomplete="off">
										<input type="hidden" class="form-control" name="proyectorubro" autocomplete="off">
								</div>
								<button type="submit" class="btn btn-block btn-sm btn-success" id="btn_agregar_finaza">Agregar Proyecto</button>
							  </div>
							  
						</div>
					</form>
					  <div class="col-xs-12 col-sm-12">
					  	<div id="mjs_componente"></div>
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
							<p>Finaciación registrada por otra áreas:</p>
					    </div>
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
						<div class="col-xs-12 col-sm-12">
							<b><p>Registré su finaciación:</p></b>
					    </div>
						<div class="col-xs-12 col-sm-12">
							<table class="table table-bordered" id="tabla_finanza_rubros" >
								<thead class="thead-inverse">
								<tr class="warning">
									<th>#</th>
									<th>Rubro de funcionamiento.</th>
									<th>Fuente</th>
									<th>Valor</th>
									<th>Eliminar</th>
								</tr>
								</thead>
								<tbody id="registrosFinanzasRubroCompartida">
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<form id="form_agregar_finza_2">
						<div class="row"  >
							<div class="col-xs-12 col-sm-12">
								<div class="form-group">
									<label class="text-warning" >Rubro de funcionamiento</label>
									<input type="hidden" name="id_act_agre2" id="id_act_agre2">
									<select class="form-control" name="Fuente_funcionamiento" id="Fuente_funcionamiento">
										<option value="" >Selecionar</option>
									</select>
								</div>
						    </div>

							<div class="col-xs-12 col-md-4">
								<div class="form-group">
								  		<label class="text-warning">Valor</label>
										<input type="text" class="form-control " name="valor_contrato_rubro" id="valor_contrato_rubro" autocomplete="off">
										<input type="hidden" class="form-control" name="proyectorubro" autocomplete="off">
								</div>
								<button type="submit" class="btn btn-block btn-sm btn-warning" id="btn_agregar_finaza_rubro">Agregar Rubro</button>
							</div>
							<div class="col-xs-12 col-md-8"></div>
						</div>
					</form>
					<div class="col-xs-12 col-sm-12">
					  	<div id="mjs_componente_2"></div>
					</div>
     			 </div>
      
			      <div class="modal-footer">
			      	<div class="row">
			      		<div id="mjs_componente_paa_compartido"></div>
			        	<div class="col-xs-12 col-sm-12">
			        		<form id="form_crear_paa_compartido">
								<input type="hidden" name="id_estudio3" id="id_estudio3">
								<input type="hidden" name="datos_vector_financiacion" id="datos_vector_financiacion">
								<input type="hidden" name="datos_vector_financiacion_rubro" id="datos_vector_financiacion_rubro">

				        		<button type="submit" class="btn btn-success"><strong>CREAR NUEVO</strong> item Vinculado al item:<label id="id_paa_comp"></label></button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							</form>
						</div>
			        </div>
			      </div>
    		</div>
  		</div>
	</div>





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
										<table class="table table-bordered table-responsive" id="datos_actividad" >
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
									<input type="hidden" name="paa_registro" id="paa_registro">
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
