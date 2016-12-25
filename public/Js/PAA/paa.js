$(function()
{
  
  var URL = $('#main_paa_').data('url');
  vector_datos_actividad = new Array();

  var t = $('#TablaPAA').DataTable( {responsive: true,
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

  $('input[data-role="datepicker"]').datepicker({
      dateFormat: 'yy-mm-dd',
      yearRange: "-100:+0",
      changeMonth: true,
      changeYear: true,
    });

 $('#form_paa').on('submit', function(e){

    var datos_acti = JSON.stringify(vector_datos_actividad);
    $('input[name="Dato_Actividad"]').val(datos_acti);
    
    if(vector_datos_actividad.length > 0){
          $.post(
            URL+'/validar/paa',
            $(this).serialize(),
            function(data){
              if(data.status == 'error')
              {
                  
                  validad_error(data.errors);
             
              } else {

                  validad_error(data.errors);

                  if(data.status == 'modelo')
                  {
                      document.getElementById("form_paa").reset();                
                      var num=1;
                      t.clear().draw();
                      $.each(data.datos, function(i, e){
                          t.row.add( [
                              '<th scope="row" class="text-center">'+num+'</th>',
                              '<td>'+e['Registro']+'</td>',
                              '<td>'+e['CodigosU']+'</td>',
                              '<td>'+e.modalidad['Nombre']+'</td>',
                              '<td>'+e.tipocontrato['Nombre']+'</td>',
                              '<td>'+e['ObjetoContractual']+'</td>',
                              '<td>'+e['FuenteRecurso']+'</td>',
                              '<td>'+e['ValorEstimado']+'</td>',
                              '<td>'+e['ValorEstimadoVigencia']+'</td>',
                              '<td>'+e['VigenciaFutura']+'</td>',
                              '<td>'+e['EstadoVigenciaFutura']+'</td>',
                              '<td>'+e['FechaEstudioConveniencia']+'</td>',
                              '<td>'+e['FechaInicioProceso']+'</td>',
                              '<td>'+e['FechaSuscripcionContrato']+'</td>',
                              '<td>'+e['DuracionContrato']+'</td>',
                              '<td>'+e['MetaPlan']+'</td>',
                              '<td>'+e['RecursoHumano']+'</td>',
                              '<td>'+e['NumeroContratista']+'</td>',
                              '<td>'+e['DatosResponsable']+'</td>',
                              '<td>'+e.rubro['Nombre']+'</td>',

                              '<td>'+
                                '<div class="btn-group btn-group-justified">'+
                                  '<div class="btn-group">'+
                                    '<button type="button" data-rel="" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                  '</div>'+
                                  '<div class="btn-group">'+
                                    '<button type="button" data-rel="" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                  '</div>'+
                                  '<div class="btn-group">'+
                                    '<button type="button" data-rel="" data-funcion="ver_upd" class="btn btn-primary  btn-xs"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>'+
                                  '</div>'+
                                '</div>'+
                                '<div id=""></div>'+
                              '</td>'

                            
                          ] ).draw( false );
                          num++;

                      });
                      $('#mjs_registroPaa').html(' <strong>Registro Exitoso!</strong> Se realizo el resgistro de su PAA.');
                      $('#mjs_registroPaa').show();
                      setTimeout(function(){
                          $('#mjs_registroPaa').hide();
                      }, 3000)
                  }else{
                      $('#mensaje_presupuesto2').html('<strong>Error!</strong> el valor del presupuesto que intenta modificar es menor a la suma de los proyectos: $'+data.sum_proyectos);
                      $('#mensaje_presupuesto2').show();
                      setTimeout(function(){
                          $('#mensaje_presupuesto2').hide();
                      }, 6000)
                  }
                  
              }
          },'json');
    }else{

            $('#alert_actividad').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> No se ha registrado ninguna fuente de financiación.</div>');
            $('#mensaje_actividad').show();
            setTimeout(function(){
                $('#mensaje_actividad').hide();
            }, 6000)
    }

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
                    case 'numero_contratista':
                    case 'datos_contacto':
                        selector = 'input';
                    break;

                    case 'recurso_humano':
                    case 'modalidad_seleccion':
                    case 'tipo_contrato':
                    case 'vigencias_futuras':
                    case 'estado_solicitud':
                    case 'proyecto_inversion':
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


    $('select[name="fuente_inversion"]').on('change', function(e){
        select_fuente($(this).val());
    });

    var select_fuente = function(id)
    { 

                 /* @foreach($componentes as $componente)
                            <option value="{{ $componente['Id'] }}" >{{ $componente['Nombre'] }}</option>
                  @endforeach*/
                $.ajax({
                    url: URL+'/service/fuenteComponente/'+id,
                    data: {},
                    dataType: 'json',
                    success: function(data)
                    {

                        var html = '<option value="">Seleccionar</option>';
                        if(data.length > 0)
                        {
                          console.log(data);
                            $.each(data, function(i, e){
                                html += '<option value="'+e['Id']+'">'+e['Nombre']+'</option>';
                            });
                        }
                        $('select[name="componnente"]').html(html).val($('select[name="componnente"]').data('value'));
                    }
                });
    };

  
  $('#agregarFinanciacion').on('click', function(e)
    {

        var fuente_inversion=$('select[name="fuente_inversion"]').val();
        var componnente=$('select[name="componnente"]').val();
        var valor_contrato = $('input[name="valor_contrato"]').val();
        if(fuente_inversion===''){
          $('#alert_actividad').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Debe seleccionar un fuente de financiación para poder realizar el registro.</div>');
          $('#mensaje_actividad').show(60);
          $('#mensaje_actividad').delay(2500).hide(600);

        }else{
          if(componnente===''){
            $('#alert_actividad').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Debe seleccionar un compoente para realizar el registro.</div>');
            $('#mensaje_actividad').show(60);
            $('#mensaje_actividad').delay(2500).hide(600);
            return false;
          }else{
              if(valor_contrato===''){
                $('#alert_actividad').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Debe ingresar un valor para realizar el registro.</div>');
                $('#mensaje_actividad').show(60);
                $('#mensaje_actividad').delay(2500).hide(600);
                return false;
              }else{
                    $('#alert_actividad').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato registrados con éxito. </div>');
                    $('#mensaje_actividad').show(60);
                    $('#mensaje_actividad').delay(1500).hide(600);
                    vector_datos_actividad.push({"id_fuente": fuente_inversion, "id_componente": componnente, "valor": valor_contrato});
              }
          }
        }
        console.log(vector_datos_actividad);
    });

});
