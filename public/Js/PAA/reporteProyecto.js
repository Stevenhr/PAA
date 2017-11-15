$(function()
{
	var URL = $('#main_reporte').data('url');

	function number_format(amount, decimals) {

        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0) 
            return parseFloat(0).toFixed(decimals);

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

        return amount_parts.join('.');
    }

	$('select[name="planDesarrollo"]').on('change', function(e){
		select_vigencia($(this).val());
	});

	var select_vigencia = function(id)
	{ 
		if(id!=''){
			$.ajax({
				url: URL+'/service/vigencias/'+id,
				data: {},
				dataType: 'json',
				success: function(data)
				{
					
					var html = '<option value="">Seleccionar</option>';
					if(data.vigencias)
					{
            console.log(data);
						$.each(data.vigencias, function(i, e){
							html += '<option value="'+e['Id']+'">'+e['vigencia']+'</option>';
						});
					}
					$('select[name="vigencia"]').html(html).val($('select[name="vigencia"]').data('value'));
				}
			});
		}else{
					var html = '<option value="">Seleccionar</option>';
					$('select[name="vigencia"]').html(html).val($('select[name="vigencia"]').data('value'));
		}
	};


	$('select[name="vigencia"]').on('change', function(e){
		select_proyecto($(this).val());
	});

	var select_proyecto = function(id)
	{ 
		if(id!=''){
			$.ajax({
				url: URL+'/service/proyecto/'+id,
				data: {},
				dataType: 'json',
				success: function(data)
				{
					
					var html = '<option value="">Seleccionar</option>';
					
          if(data.proyecto)
					{
            console.log(data);
						$.each(data.proyecto, function(i, e){
							html += '<option value="'+e['Id']+'">'+e['codigo']+" - "+e['Nombre']+'</option>';
						});
					}
					$('select[name="proyecto"]').html(html).val($('select[name="proyecto"]').data('value'));
				}
			});
		}else{
					var html = '<option value="">Seleccionar</option>';
					$('select[name="proyecto"]').html(html).val($('select[name="proyecto"]').data('value'));
		}
	};


    // Build the chart

    $('#form_reporte_proyecto').on('submit', function(e){
	    $.ajax({
	    	type: "POST",
			url: URL+'/service/proyecto_finanza',
			data: $(this).serialize(),
			dataType: 'json',
			success: function(data)
			{
				//console.log(data);
				$('#NomPro').html(data.Proyecto+' - '+data.Codigo);
				var html='';
				html += '<table class="table table-bordered" id="tablaProyecto">'+
				        '<thead>'+
				        '<tr>'+
							'<th class="text-center">Proyecto</th>'+
							'<th>Código</th>'+
							'<th>Presupuesto/Items Total</th>'+
							'<th>Presupuesto/Items aprobado</th>'+
							'<th>Presupuesto/Items en tramite de aprobación</th>'+
							'<th>Presupuesto/Items pendiente por aprobar</th>'+
						'</tr>'+
						'</thead>'+
						'<tbody>'+
						'<tr>'+
                            '<th scope="row" class="text-center">'+data.Proyecto+'</th>'+
                            '<td>'+data.Codigo+'</td>'+
                            '<th> $'+number_format(data.Total)+'</th>'+
                            '<td> $'+number_format(data.aprobado)+'</td>'+
                            '<td> $'+number_format(data.reservado_por_aprobar)+'</td>'+
                            '<td> $'+number_format(data.Saldo_libre)+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<th scope="row" class="text-center"></th>'+
                            '<td></td>'+
                            '<th> </th>'+
                            '<td> <button type="button" class="btn btn-primary btn-block btn-xs" data-rel="'+data.Id_Proyecto+'" data-funcion="paaAprobado">Planes aprobados</button></td>'+
                            '<td> <button type="button" class="btn btn-primary btn-block btn-xs" data-rel="'+data.Id_Proyecto+'" data-funcion="paaReservado">Planes por aprobar</button></td>'+
                            '<td></td>'+
                        '</tr>';
						'</tbody>'+
						'</table>'+
				$('#datosproyecto').html(html);

				grafica_reporte(data);
				$('#panel_grafico').show();
			}
		});
	    return false;
	});




    $('#Tabla1 tfoot th').each( function () {
        var title = $(this).text();
        if(title!="Menu" && title!="N°"){
            $(this).html( '<input type="text" placeholder="Buscar"/>' );
        }
    } );

    // DataTable
    var tb1 = $('#Tabla1').DataTable( {responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'],
        pageLength: 5
    });

    // Apply the search
    tb1.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    });

	$('body').delegate('button[data-funcion="paaAprobado"]','click',function (e) {   
      var id = $(this).data('rel'); 

            $.get(
              URL+'/service/obtenerPaaAprobado/'+id,
              {},
              function(data)
              {
                  if(data)
                  {
                      var num=1;
                      var num1=1;
                      var num2=1;
                      var html = '';
                      var html1 = '';
                      var html2 = '';

                      //console.log(data);
                      tb1.clear().draw();
                      $.each(data, function(i, dato){

                        if(dato['Proyecto1Rubro2']==1){
                             nom_pro_rubr=dato.proyecto['Nombre'];
                             nom_meta=dato.meta['Nombre'];
                          }else if(dato['Proyecto1Rubro2']==2){
                             nom_pro_rubr=dato.rubro_funcionamiento['nombre'];
                             nom_meta="Na";
                          }else{
                             nom_pro_rubr="";
                             nom_meta="";
                          }

                            tb1.row.add( [
                                '<th scope="row" class="text-center">'+num+'</th>',
                                '<td>'+dato['Registro']+'</td>',
                                '<td>'+dato['CodigosU']+'</td>',
                                '<td>'+dato.modalidad['Nombre']+'</td>',
                                '<td>'+dato.tipocontrato['Nombre']+'</td>',
                                '<td><div class="campoArea">'+dato['ObjetoContractual']+'</div></td>',
                                '<td>'+number_format(dato['ValorEstimado'])+'</td>',
                                '<td>'+number_format(dato['ValorEstimadoVigencia'])+'</td>',
                                '<td>'+dato['VigenciaFutura']+'</td>',
                                '<td>'+dato['EstadoVigenciaFutura']+'</td>',
                                '<td>'+dato['FechaEstudioConveniencia']+'</td>',
                                '<td>'+dato['FechaInicioProceso']+'</td>',
                                '<td>'+dato['FechaSuscripcionContrato']+'</td>',
                                '<td>'+dato['DuracionContrato']+'</td>',
                                '<td>'+dato['RecursoHumano']+'</td>',
                                '<td>'+dato['NumeroContratista']+'</td>',
                                '<td>'+dato['DatosResponsable']+'</td>',
                                '<td>'+nom_pro_rubr+'</td>',
                                '<td>'+nom_meta+'</td>'
                            ] ).draw( false );
                            num++;
                        

                      });
                      $('#panel').removeClass('panel-primary');
                      $('#panel').addClass('panel-success');
                      $('#myModalLabel').html('Presupuesto Aprobado');
                      $('#heading').html('Planes con estudio de conveniencia aprobado.');
                      $('#mnjs').html('Los siguientes planes cuentan con el estudio de conveniencia aprobado.');
                      $('#Modal_Paa_Repor').modal('show'); 
                  }
              },
              'json'
          );
           
     }); 


	$('body').delegate('button[data-funcion="paaReservado"]','click',function (e) {   
      var id = $(this).data('rel'); 

            $.get(
              URL+'/service/obtenerPaaReservado/'+id,
              {},
              function(data)
              {
                  if(data)
                  {
                      var num=1;
                      var num1=1;
                      var num2=1;
                      var html = '';
                      var html1 = '';
                      var html2 = '';

                      //console.log(data);
                      tb1.clear().draw();
                      $.each(data, function(i, dato){

                        if(dato['Proyecto1Rubro2']==1){
                             nom_pro_rubr=dato.proyecto['Nombre'];
                             nom_meta=dato.meta['Nombre'];
                          }else if(dato['Proyecto1Rubro2']==2){
                             nom_pro_rubr=dato.rubro_funcionamiento['nombre'];
                             nom_meta="Na";
                          }else{
                             nom_pro_rubr="";
                             nom_meta="";
                          }

                            tb1.row.add( [
                                '<th scope="row" class="text-center">'+num+'</th>',
                                '<td>'+dato['Registro']+'</td>',
                                '<td>'+dato['CodigosU']+'</td>',
                                '<td>'+dato.modalidad['Nombre']+'</td>',
                                '<td>'+dato.tipocontrato['Nombre']+'</td>',
                                '<td><div class="campoArea">'+dato['ObjetoContractual']+'</div></td>',
                                '<td>'+number_format(dato['ValorEstimado'])+'</td>',
                                '<td>'+number_format(dato['ValorEstimadoVigencia'])+'</td>',
                                '<td>'+dato['VigenciaFutura']+'</td>',
                                '<td>'+dato['EstadoVigenciaFutura']+'</td>',
                                '<td>'+dato['FechaEstudioConveniencia']+'</td>',
                                '<td>'+dato['FechaInicioProceso']+'</td>',
                                '<td>'+dato['FechaSuscripcionContrato']+'</td>',
                                '<td>'+dato['DuracionContrato']+'</td>',
                                '<td>'+dato['RecursoHumano']+'</td>',
                                '<td>'+dato['NumeroContratista']+'</td>',
                                '<td>'+dato['DatosResponsable']+'</td>',
                                '<td>'+nom_pro_rubr+'</td>',
                                '<td>'+nom_meta+'</td>'
                            ] ).draw( false );
                            num++;
                        

                      });
                      $('#panel').removeClass('panel-success');
                      $('#panel').addClass('panel-primary');
                      $('#myModalLabel').html('Presupuesto Reservado');
                      $('#heading').html('Planes con estudio de conveniencia por aprobar.');
                      $('#mnjs').html('Los siguientes planes se encuentran en proceso de aprobación.');
                      $('#Modal_Paa_Repor').modal('show'); 
                  }
              },
              'json'
          );
           
     }); 


	function grafica_reporte(datos){
		
		Highcharts.chart('container', {
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false,
	            type: 'pie'
	        },
	        title: {
	            text: ''+datos.Proyecto+' - '+datos.Codigo+''
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> <br> Valor:<b> ${point.y}</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: false
	                },
	                showInLegend: true
	            }

	        },
	        series: [{
	            name: 'Porcentaje',
	            colorByPoint: true,
	            data: [{
	                name: 'Aprobado',
	                y: datos.aprobado,
	            }, {
	                name: 'Reservado por aprobación',
	                y: datos.reservado_por_aprobar,
	                sliced: true,
	                selected: true
	            }, {
	                name: 'Saldo Libre',
	                y: datos.Saldo_libre,
	            }]
	        }]
	    });
	}
});


