$(function()
{
	var URL = $('#main_reporte').data('url');

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
				grafica_reporte(data);
				$('#panel_grafico').show();
			}
		});
	    return false;
	});


	function grafica_reporte(datos){
		console.log(datos);
		Highcharts.chart('container', {
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false,
	            type: 'pie'
	        },
	        title: {
	            text: ''+datos.aprobado+''
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
	            name: 'Brands',
	            colorByPoint: true,
	            data: [{
	                name: 'Microsoft Internet Explorer',
	                y: 56.33
	            }, {
	                name: 'Chrome',
	                y: 24.03,
	                sliced: true,
	                selected: true
	            }, {
	                name: 'Firefox',
	                y: 10.38
	            }, {
	                name: 'Safari',
	                y: 4.77
	            }, {
	                name: 'Opera',
	                y: 0.91
	            }, {
	                name: 'Proprietary or Undetectable',
	                y: 0.2
	            }]
	        }]
	    });
	}
});