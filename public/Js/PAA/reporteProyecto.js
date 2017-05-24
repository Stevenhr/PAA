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
						$.each(data, function(i, e){
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
						$.each(data, function(i, e){
							html += '<option value="'+e['Id']+'">'+e['Nombre']+'</option>';
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
				var html='';
				html += '<table class="table">'+
				        '<thead>'+
				        '<tr>'+
							'<th>Proyecto</th>'+
							'<th>Código</th>'+
							'<th>Presupuesto Total</th>'+
							'<th>Presupuesto Aprobado</th>'+
							'<th>Presupuesto Reservado</th>'+
							'<th>Presupuesto Libre</th>'+
						'</tr>'+
						'</thead>'+
						'<tbody>'+
						'<tr>'+
                            '<th scope="row" class="text-center">'+data.Proyecto+'</th>'+
                            '<td>'+data.Codigo+'</td>'+
                            '<td> $ '+number_format(data.Total)+'</td>'+
                            '<td> $ '+number_format(data.aprobado)+'</td>'+
                            '<td> $ '+number_format(data.reservado_por_aprobar)+'</td>'+
                            '<td> $ '+number_format(data.Saldo_libre)+'</td>'+
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