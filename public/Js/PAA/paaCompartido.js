$(function()
{
  var URL = $('#main_paa_').data('url');
  vector_financiacion = new Array();
  vector_financiacion_rubro = new Array();
  $('#TablaPAA tfoot th').each( function () {
        var title = $(this).text();
        if(title!="Menu" && title!="N°"){
          $(this).html( '<input type="text" placeholder="Buscar"/>' );
        }
    } );
 
    // DataTable
    var t = $('#TablaPAA').DataTable( {responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'],
        pageLength: 5
    });
 
    // Apply the search
    t.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    });

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

     function formatCurrency(input)
    {
        var num = input.value.replace(/\./g,'');
        if(!isNaN(num)){
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
        }
          
        else{ alert('Solo se permiten numeros');
            input.value = input.value.replace(/[^\d\.]*/g,'');
        }
    }

    $('input[name="valor_contrato"]').on('keyup', function(e){
        formatCurrency(this);
    });

    $('input[name="valor_contrato_rubro"]').on('keyup', function(e){
        formatCurrency(this);
    });

    $('#TablaPAA').delegate('a[data-funcion="Observaciones"]','click',function (e)
    {
        var id = $(this).data('rel');
        $('.NumPaa').text(id);
        $('#paa_registro').val(id);
        $('#registrosObser').html("<h3>Cargando...</h3>");
        $.ajax({
              url: URL+'/service/historialObservaciones/'+id,
              data: {},
              dataType: 'json',
              success: function(data)
              {   
                  var html = '';
                  var num=1;
                  var notifica='';
                  //console.log(data);
                  $.each(data, function(i, dato){
                    if(!dato['check'])
                      notifica="bg-warning";
                    else
                      notifica="";

                    html += '<tr class="'+notifica+'">'+
                            '<th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+dato.persona['Primer_Nombre']+' '+dato.persona['Primer_Apellido']+'</td>'+
                            '<td>'+dato['observacion']+'</td>'+
                            '<td>'+dato['estado']+'</td>'+
                            '<td>'+dato['created_at']+'</td></tr>';
                    num++;
                  });
                  $('#registrosObser').html(html);
              }
          });

        $('#Modal_Observaciones_paa').modal('show');
    });

    $('#regisgtrar_observacion_ppa').on('click', function(e){

         id=$('#paa_registro').val();
         observacion=$('#observacio').val();
         
         $.post(
          URL+'/service/RegistrarObservacion',
          {id: id, Estado:'Observación',observacion:observacion},
          function(data){
            if(data.status == 'ok')
              {
                      $('#mjs_Observa').html('<strong>Bien!</strong> observación registrada con exíto..');
                      $('#mjs_Observa').show();
                      setTimeout(function(){
                          $('#observacio').val('');
                          $('#mjs_Observa').hide();
                          $('#mjs_Observa').modal('hide'); 
                          $('#Modal_Observaciones').modal('hide');
                      }, 3000)
              }
          },'json');

    });


    $('#TablaPAA').delegate('button[data-funcion="Financiacion"]','click',function (e){   
          var id_act = $(this).data('rel'); 

          var desactivo="";
            vector_financiacion.length =0;
  			vector_financiacion_rubro.length =0;
  			$('#registrosFinanzasCompartida').html('');
			$('#registrosFinanzasRubroCompartida').html('');

			  $('#id_estudio3').val(id_act);
	          $('#id_paa_comp').text(id_act);
	          $('#id_p').text("Id: "+id_act);
	          $('#id_act_agre').val(id_act);
	          $('#id_act_agre2').val(id_act);

                var html = '<br><h3>Cargando....</h3>';
                $('#registrosFinanzas').html(html);

          $.ajax({
              url: URL+'/service/VerFinanciamiento/'+id_act,
              data: {},
              dataType: 'json',
              success: function(data)
              {   

                $('#registrosFinanzas').html('');

                  if($.inArray(data.estado,['4','5','7','8','9','11'])!=-1)
                  {
                    desactivo="none";
                    $('#btn_agregar_finaza_rubro').hide();
                    $('#btn_agregar_finaza').hide();
                  }
                  else
                  {
                    desactivo="block";
                    $('#btn_agregar_finaza_rubro').show();
                    $('#btn_agregar_finaza').show();
                  }

                  $('#registrosFinanzas').html('');
                  $('#registrosFinanzasRubro').html('');


                    // Select Proyecto

                    var html = '<option value="">Seleccionar</option>';
                    if(data.proyectos!=null && data.proyectos.length > 0)
                    {
                      $.each(data.proyectos, function(i, e){
                          html += '<option value="'+e['Id']+'">'+e['Nombre']+'</option>';
                      });
                    }
                    $('select[name="Proyecto_Finanza"]').html(html).val($('select[name="Proyecto_Finanza"]').data('value'));

                    //Select Fuente
                    var html = '<option value="">Seleccionar</option>';
                    if(data.proyecto.fuente){
	                    if(data.proyecto!=null && data.proyecto.fuente.length > 0)
	                    {
	                      $.each(data.proyecto.fuente, function(i, e){
	                          html += '<option value="'+e.pivot['id']+'">'+e['nombre']+'</option>';
	                      });
	                    }
	                }
                    $('select[name="Fuente_inversion"]').html(html).val($('select[name="Fuente_inversion"]').data('value'));
                    
                if(data.Modelo.componentes.length>0)
                { 
              
                    $('input[name="proyectorubro"]').val(data.Modelo['Proyecto1Rubro2']);

                    var num=1;
                    var html = '';
                    $.each(data.ActividadComponente, function(i, dato){
                      html += '<tr>'+
                              '<th scope="row" class="text-center">'+num+'</th>'+
                              '<td>'+dato.fuenteproyecto.proyecto['Nombre']+'</td>'+
                              '<td>'+dato.fuenteproyecto.fuente['nombre']+'</td>'+
                              '<td>'+dato.componente['Nombre']+'</td>'+
                              '<td>'+dato.meta['Nombre']+'</td>'+
                              '<td> $ '+number_format(dato['valor'])+'</td>'+
                              '</tr>';
                      num++;
                    });

                    var html1 ='<option value="1">Seleccionar</option>';
                    $('select[name="componnente"]').html(html1);
                    $('#registrosFinanzas').html(html);
                }
                    
                    var html = '<option value="">Seleccionar</option>';
                    if(data.rubros_all.length > 0)
                    {
                      $.each(data.rubros_all, function(i, e){
                          html += '<option value="'+e['id']+'">'+e['nombre']+'</option>';
                      });
                    }
                    $('select[name="Fuente_funcionamiento"]').html(html).val($('select[name="Fuente_funcionamiento"]').data('value'));


                if(data.Modelo.rubro_funcionamiento.length>0)
                {
                    
                    var num=1;
               
                    $('#fuenPproy').text('Rubro');
                    $('input[name="proyectorubro"]').val(data.Modelo['Proyecto1Rubro2']);

                    
                    var html = '';
                    $.each(data.Modelo.rubro_funcionamiento, function(i,e){
                      //console.log(e.pivot['rubro_id']);
                      html += '<tr>'+
                              '<th scope="row" class="text-center">'+num+'</th>'+
                              '<td>'+e['nombre']+'</td>'+
                              '<td>Otros Distrito</td>'+
                              '<td> $'+number_format(e.pivot['valor'])+'</td>'+
                              '</tr>';
                      num++;
                    });
                    $('#registrosFinanzasRubro').html(html);
                            
                    $('.mjs_componente').hide();
                }

              }
          });
     }); 


    $('select[name="Proyecto_Finanza"]').on('change', function(e){
        select_Meta_Fin($(this).val());
    });

    var select_Meta_Fin = function(id)
    { 
    	var html = '<option value="">Cargando...</option>';
    	$('select[name="Meta_Finanza"]').html(html);
    	var html = '<option value="">Seleccionar</option>';
        $('select[name="Componnente_Finanza"]').html(html)
        $.ajax({
            url: URL+'/service/select_meta_fuente/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var datos=data.Proyecto;
                html = '<option value="">Seleccionar</option>';
                $.each(datos.metas, function(i, eee){
                      html += '<option value="'+eee['Id']+'">'+eee['Nombre'].toLowerCase()+'</option>';
                });   
                $('select[name="Meta_Finanza"]').html(html).val($('select[name="Meta_Finanza"]').data('value'));

                var datos2=data.FuenteProyecto;
                var html2 = '<option value="">Seleccionar</option>';
                $.each(datos2, function(i, eee){
                      html2 += '<option value="'+eee['id']+'">'+eee.fuente['nombre'].toLowerCase()+'</option>';
                });   
                $('select[name="Fuente_Finanza"]').html(html2).val($('select[name="Fuente_Finanza"]').data('value'));
            }
        });
    };


    $('select[name="Fuente_Finanza"]').on('change', function(e){
        select_fuente_finan($(this).val());
    });

    var select_fuente_finan = function(fuenteProyecto)
    { 
        $('.mjs_componente').html('');
        var html = '<option value="">Cargando....</option>';
        $('select[name="Componnente_Finanza"]').html(html)
        $.post(
          URL+'/service/fuenteComponente',
          {fuenteProyecto:fuenteProyecto},
          function(data)
          {
                html = '<option value="">Seleccionar componente</option>';
                $.each(data, function(i, eee){
                            html += '<option value="'+eee['id']+'">'+eee.componente['Nombre'].toLowerCase()+'</option>';
                });
                
                $('select[name="Componnente_Finanza"]').html(html).val($('select[name="Componnente_Finanza"]').data('value'));
          },'json');
    };


    $('#form_agregar_finza').on('submit', function(e){
          var id_act=$('#id_act_agre').val();
          $('.mjs_componente').html('');
            var proyRu=$('input[name="proyectorubro"]').val();

              $.ajax({
                  type: "POST",
                  url: URL+'/service/agregar_finza',
                  data: $(this).serialize(),
                  dataType: 'json',
                  success: function(data)
                  {   
                    if(data.status == 'error')
                    {
                        validad_error_agre(data.errors);
                    } else {

                        if(data.status == 0)
                        {
                        	
                            $('#mjs_componente').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> La sumatoria de los valores ingresados superan el valor del presupuesto disponible.</div>');
                            setTimeout(function(){
                                $('#mjs_componente').html('');
                            }, 2000)
                            validad_error_agre(data.errors);
                        }else{
                          validad_error_agre(data.errors);
                          var html = '';
                          $('#registrosFinanzasCompartida').html('');
                          var num=1;
                          desactivo="";

                          if($.inArray(data.estado,['4','5','7'])!=-1){
                            desactivo="none";
                            $('#btn_agregar_finaza').hide();
                          }else{
                            desactivo="";
                            $('#btn_agregar_finaza').show();
                          }

                          var id_proyecto_Finanza=$('#Proyecto_Finanza').find(':selected').val();
                          var id_meta_Finanza=$('#Meta_Finanza').find(':selected').val();
                          var id_fuente_Finanza=$('#Fuente_Finanza').find(':selected').val();
                          var id_componnente_Finanza=$('#Componnente_Finanza').find(':selected').val();
                          var valor_contrato=$('#valor_contrato').val();

                          var text_proyecto_Finanza=$('#Proyecto_Finanza').find(':selected').text();
                          var text_meta_Finanza=$('#Meta_Finanza').find(':selected').text();
                          var text_fuente_Finanza=$('#Fuente_Finanza').find(':selected').text();
                          var text_componnente_Finanza=$('#Componnente_Finanza').find(':selected').text();


                          vector_financiacion.push({
                            "id_proyecto_Finanza":id_proyecto_Finanza,
                            "text_proyecto_Finanza":text_proyecto_Finanza,
                            "id_meta_Finanza":id_meta_Finanza,
                            "text_meta_Finanza":text_meta_Finanza,
                            "id_fuente_Finanza":id_fuente_Finanza,
                            "text_fuente_Finanza":text_fuente_Finanza,
                            "id_componnente_Finanza":id_componnente_Finanza,
                            "text_componnente_Finanza": text_componnente_Finanza,
                            "valor_contrato": valor_contrato,
                            "id_paa":id_act_agre
                          });

                          html='';
                            if(vector_financiacion.length > 0)
					        {
					            var num=1;
					            $.each(vector_financiacion, function(i, e){
					                html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+
					                    '<td>'+e['text_proyecto_Finanza']+'</td>'+
					                    '<td>'+e['text_meta_Finanza']+'</td>'+
					                    '<td>'+e['text_fuente_Finanza']+'</td>'+
					                    '<td>'+e['text_componnente_Finanza']+'</td>'+
					                    '<td> $'+e['valor_contrato']+'</td>'+
					                    '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarproyecto" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
					                num++;
					            });
					        }

					        var datos_vector_financiacion = JSON.stringify(vector_financiacion);
     						$('input[name="datos_vector_financiacion"]').val(datos_vector_financiacion);

					        $('#registrosFinanzasCompartida').html(html);

                            $('#mjs_componente').html('<div class="alert alert-dismissible alert-success" ><strong>Bien!</strong> Datos agregados exitosamente.</div>');
                           	 setTimeout(function(){
                                $('#mjs_componente').html('');
                            }, 2000)

                           document.getElementById("form_agregar_finza").reset();
                       }
                    }
                  }
              });

           return false;
    });

    var validad_error_agre = function(data)
    {
        $('#form_agregar_finza .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'valor_contrato':
                        selector = 'input';
                    break;

                    case 'Proyecto_Finanza':
                    case 'Meta_Finanza':
                    case 'Fuente_Finanza':
                    case 'Componnente_Finanza':
                    selector = 'select';
                    break;
                
                }
                $('#form_agregar_finza '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }


    $('#tabla_proyecto_compratido').delegate('button[data-funcion="eliminarproyecto"]','click',function (e) {   
      var id = $(this).data('rel'); 
      
      vector_financiacion.splice(id, 1);
          var html = '';
            if(vector_financiacion.length > 0)
            {
               
		            var num=1;
		            $.each(vector_financiacion, function(i, e){
		                html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+
		                    '<td>'+e['text_proyecto_Finanza']+'</td>'+
		                    '<td>'+e['text_meta_Finanza']+'</td>'+
		                    '<td>'+e['text_fuente_Finanza']+'</td>'+
		                    '<td>'+e['text_componnente_Finanza']+'</td>'+
		                    '<td> $'+e['valor_contrato']+'</td>'+
		                    '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarproyecto" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
		                num++;
		            });		        	
            }

            $('#registrosFinanzasCompartida').html(html);
     }); 



    $('#form_agregar_finza_2').on('submit', function(e){
          var id_act=$('#id_act_agre2').val();
           $.ajax({
                  type: "POST",
                  url: URL+'/service/agregar_rubro',
                  data: $(this).serialize(),
                  dataType: 'json',
                  success: function(data)
                  { 
                    if(data.status == 'error')
                    {
                        validad_error_agre_rubro(data.errors);
                    } else {
                        validad_error_agre_rubro(data.errors);

                          var id_fuente_funcionamiento=$('#Fuente_funcionamiento').find(':selected').val();
                          var text_fuente_funcionamiento=$('#Fuente_funcionamiento').find(':selected').text();
                          var valor_contrato_rubro=$('#valor_contrato_rubro').val();


                          vector_financiacion_rubro.push({
                            "id_fuente_funcionamiento":id_fuente_funcionamiento,
                            "text_fuente_funcionamiento":text_fuente_funcionamiento,
                            "valor_contrato_rubro":valor_contrato_rubro,
                            "id_paa":id_act
                          });

                            var html = '';
                            if(vector_financiacion_rubro.length > 0)
					        {
					            var num=1;
					            $.each(vector_financiacion_rubro, function(i, e){
					                html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+
					                    '<td>'+e['text_fuente_funcionamiento']+'</td>'+
					                    '<td>Otros distritos</td>'+
					                    '<td>'+e['valor_contrato_rubro']+'</td>'+
					                    '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarrubro" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
					                num++;
					            });
					        }

					        var datos_vector_financiacion_rubro = JSON.stringify(vector_financiacion_rubro);
     						$('input[name="datos_vector_financiacion_rubro"]').val(datos_vector_financiacion_rubro);

					        $('#registrosFinanzasRubroCompartida').html(html);

        					$('#mjs_componente_2').html('<div class="alert alert-dismissible alert-success" ><strong>Bien!</strong> Datos agregados exitosamente.</div>');
                           	 setTimeout(function(){
                                $('#mjs_componente_2').html('');
                            }, 2000)

                            document.getElementById("form_agregar_finza_2").reset();
                    }
                  }
              });

           return false;
    });

    var validad_error_agre_rubro = function(data)
    {
        $('#form_agregar_finza_2 .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'Fuente_inversion':
                    selector = 'select';
                    break;

                    case 'valor_contrato':
                    selector = 'input';
                    break;
                
                }
                $('#form_agregar_finza_2 '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }


     $('#tabla_finanza_rubros').delegate('button[data-funcion="eliminarrubro"]','click',function (e) {   
      var id = $(this).data('rel'); 
      vector_financiacion_rubro.splice(id, 1);
            var html = '';
            if(vector_financiacion_rubro.length > 0)
	        {
	            var num=1;
	            $.each(vector_financiacion_rubro, function(i, e){
	                html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+
	                    '<td>'+e['text_fuente_funcionamiento']+'</td>'+
	                    '<td>Otros distritos</td>'+
	                    '<td>'+e['valor_contrato_rubro']+'</td>'+
	                    '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarrubro" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
	                num++;
	            });
	        }
	        $('#registrosFinanzasRubroCompartida').html(html);
     }); 



     $('#form_crear_paa_compartido').on('submit', function(e){
           	
           	if(vector_financiacion.length!=0 || vector_financiacion_rubro.length!=0){
           		$.post(
	            URL+'/crear/paaCompartido',
	            $(this).serialize(),
	            function(data){
	           		
	           		if(data.status == 'ok')
              		{
		           		$('#mjs_componente_paa_compartido').html('<div class="alert alert-dismissible alert-success" ><strong>Bien!</strong> Datos agregados exitosamente.</div>');
			           	 setTimeout(function(){
			                $('#mjs_componente_paa_compartido').html('');
			            }, 2000)
			        }else{
			        	$('#mjs_componente_paa_compartido').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Debe registrar algun tipo de financiacion.</div>');
			           	 setTimeout(function(){
			                $('#mjs_componente_paa_compartido').html('');
			            }, 2000)
			        }

		        },'json');

           	}else{
	     		$('#mjs_componente_paa_compartido').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Debe registrar algun tipo de financiacion.</div>');
	           	 setTimeout(function(){
	                $('#mjs_componente_paa_compartido').html('');
	            }, 2000)
           	}
            return false;
    });



});