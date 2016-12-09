$(function()
{
  
  var URL = $('#main_paa_').data('url');

  $('#TablaPAA').DataTable( {responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf']
  } );

  $('#Modal_AgregarNuevo').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	})
  
  $('#Modal_AprobarCambios').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	})

  $('#Modal_Historiaeliminado').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	})

 $('#form_paa').on('submit', function(e){
  alert("fdasf");
      $.post(URL+'/validar/paa/',$(this).serialize(),function(data){
          if(data.status == 'error')
          {
         
              validad_error(data.errors);
         
          } else {
              console.log(data);
              if(data.status == 'modelo')
              {
                  var datos=data.presupuesto;
                  document.getElementById("form_paa").reset();                
                  $("#div_Tabla3").show();
                  var num=1;
                  t.clear().draw();
                  $.each(datos, function(i, e){
                      t.row.add( [
                          '<th scope="row" class="text-center">'+num+'</th>',
                          '<td><h4>'+e['Nombre_Actividad']+'<h4></td>',
                          '<td>'+e['fecha_fin']+'</td>',
                          '<td>'+e['fecha_inicio']+'</td>',
                          '<td>'+e['presupuesto']+'</td>',
                          '<td><div class="btn-group btn-group-justified">'+
                              '<div class="btn-group">'+
                              '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                              '</div>'+
                              '<div class="btn-group">'+
                              '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                              '</div>'+
                              '</div>'+
                              '<div id="espera'+e['Id']+'"></div>'+
                          '</td>'
                      ] ).draw( false );
                      num++;

                  });
                  $('#mensaje_presupuesto').show();
                  setTimeout(function(){
                      $('#mensaje_presupuesto').hide();
                      $("#id_btn_presupuesto").html('Registrar');
                      $("#id_btn_presup_canc").hide();
                  }, 2000)
              }else{
                  $('#mensaje_presupuesto2').html('<strong>Error!</strong> el valor del presupuesto que intenta modificar es menor a la suma de los proyectos: $'+data.sum_proyectos);
                  $('#mensaje_presupuesto2').show();
                  setTimeout(function(){
                      $('#mensaje_presupuesto2').hide();
                  }, 6000)
              }
              
          }
      },'json');

      e.preventDefault();
  });


  var validad_error = function(data)
    {
        $('#form_paa .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    
                    case 'id_registro':
                    case 'codigo_Unspsc':
                    case 'fecha_inicial_presupuesto':
                    case 'nombre_presupuesto':
                    case 'fuente_recurso':
                    case 'valor_estimado':
                    case 'valor_estimado_actualVigencia':
                    case 'estudio_conveniencia':
                    case 'fecha_inicio':
                    case 'fecha_suscripcion':
                    case 'duracion_estimada':
                    case 'meta_plan':
                    case 'recurso_humano':
                    case 'numero_contratista':
                    case 'datos_contacto':
                        selector = 'input';
                    break;

                    case 'modalidad_seleccion':
                    case 'tipo_contrato':
                    case 'vigencias_futuras':
                    case 'estado_solicitud':
                    case 'proyecto_inversion':
                    case 'componnente':
                    selector = 'select';
                    break;

                    case 'objeto_contrato':
                    selector = 'textarea';
                    break;
                
                }
                $('#form_paa '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }

});
