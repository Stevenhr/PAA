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

});