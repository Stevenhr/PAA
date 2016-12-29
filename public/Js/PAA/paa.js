$(function()
{
  
  var URL = $('#main_paa_').data('url');
  vector_datos_actividad = new Array();

  var t = $('#TablaPAA').DataTable( {responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf']
  } );

   var t = $('#Tabla1').DataTable( {responsive: true,

  } );

   var t = $('#Tabla2').DataTable( {responsive: true,
        
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

  $('#Modal_Financiacion').on('shown.bs.modal', function () {
    $('#myInput').focus()
  })

  $('#Modal_Historial').on('shown.bs.modal', function () {
    $('#myInput').focus()
  })

  $('#Modal_Editar').on('shown.bs.modal', function () {
    $('#myInput').focus()
  })

  $('#Modal_Eliminar').on('shown.bs.modal', function () {
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
                      $('#crear_paa_btn').html("Agregar");
                      vector_datos_actividad=[];
                      $('#registros').html('');               
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
                                    '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs" title="Eliminar Paa"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                  '</div>'+
                                  '<div class="btn-group">'+
                                    '<button type="button" data-rel="'+e['Id']+'" data-funcion="Modificacion" class="btn btn-default btn-xs" title="Editar Paa"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                  '</div>'+
                                  '<div class="btn-group">'+
                                    '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_upd" class="btn btn-primary  btn-xs" title="Historial"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>'+
                                  '</div>'+
                                  '<div class="btn-group">'+
                                    '<button type="button" data-rel="'+e['Id']+'" data-funcion="Financiacion" class="btn btn-success btn-xs"  title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></button>'+
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


    $('select[name="Proyecto_inversion"]').on('change', function(e){
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
                        //console.log(data);
                        var html = '<option value="">Seleccionar</option>';
                  
                                $.each(data.metas, function(i, eee){
                                    $.each(eee.actividades, function(i, eeee){
                                        $.each(eeee.componentes, function(i, eeeee){   

                                            html += '<option value="'+eeeee['Id']+'">'+eeeee.pivot['id']+"<b> ACTIVIDAD:</b>"+eeee['Nombre'].toLowerCase()+"<br> FUENTE:"+eeeee.fuente['nombre'].toLowerCase()+'</option>';
                                            $('input[name="id_pivot_comp"]').val(eeeee.pivot['id']);
                                        });
                                    });
                                });
                        $('select[name="componnente"]').html(html).val($('select[name="componnente"]').data('value'));
                    }
                });
    };

  
  $('#agregarFinanciacion').on('click', function(e)
    {
        
        var id_pivot_comp=$('input[name="id_pivot_comp"]').val();

        var Proyecto_inversion=$('select[name="Proyecto_inversion"]').val();
        var indice = form_paa.Proyecto_inversion.selectedIndex;
        var Nom_Proyecto_inversion= form_paa.Proyecto_inversion.options[indice].text ;

        var componnente=$('select[name="componnente"]').val();
        var indice = form_paa.componnente.selectedIndex;
        var Nombre_componnente= form_paa.componnente.options[indice].text ;

        var valor_contrato = $('input[name="valor_contrato"]').val();
        if(Proyecto_inversion===''){
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
                    $('input[name="valor_contrato"]').val('');
                    $('select[name="Proyecto_inversion"]').val('');
                    $('select[name="componnente"]').val('');

                    $('#alert_actividad').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato registrados con éxito. </div>');
                    $('#mensaje_actividad').show(60);
                    $('#mensaje_actividad').delay(1500).hide(600);
                    vector_datos_actividad.push({"id_Proyecto": Proyecto_inversion, "Nom_Proyecto":Nom_Proyecto_inversion, "id_componente": componnente, "Nom_Componente":Nombre_componnente,"valor": valor_contrato,"id_pivot_comp":id_pivot_comp});
              }
          }
        }
        //console.log(vector_datos_actividad);
    });

   $('#Btn_Agregar_Nuevo').on('click', function(e)
    {
        $('input[name="id_Paa"]').val("0").closest('.form-group').removeClass('has-error');
        $('input[name="id_registro"]').val("").closest('.form-group').removeClass('has-error');
        $('input[name="codigo_Unspsc"]').val("").closest('.form-group').removeClass('has-error');;
        $('input[name="fecha_inicial_presupuesto"]').val("").closest('.form-group').removeClass('has-error');;
        $('input[name="fuente_recurso"]').val("").closest('.form-group').removeClass('has-error');;
        $('input[name="valor_estimado"]').val("").closest('.form-group').removeClass('has-error');;
        $('input[name="valor_estimado_actualVigencia"]').val("").closest('.form-group').removeClass('has-error');;
        $('input[name="estudio_conveniencia"]').val("").closest('.form-group').removeClass('has-error');;
        $('input[name="fecha_inicio"]').val("").closest('.form-group').removeClass('has-error');;
        $('input[name="fecha_suscripcion"]').val("").closest('.form-group').removeClass('has-error');;
        $('input[name="duracion_estimada"]').val("").closest('.form-group').removeClass('has-error');;
        $('input[name="meta_plan"]').val("").closest('.form-group').removeClass('has-error');;
        $('input[name="numero_contratista"]').val("").closest('.form-group').removeClass('has-error');;
        $('input[name="datos_contacto"]').val("").closest('.form-group').removeClass('has-error');;

        $('select[name="recurso_humano"]').val("").closest('.form-group').removeClass('has-error');;
        $('select[name="modalidad_seleccion"]').val("").closest('.form-group').removeClass('has-error');;
        $('select[name="tipo_contrato"]').val("").closest('.form-group').removeClass('has-error');
        $('select[name="vigencias_futuras"]').val("").closest('.form-group').removeClass('has-error');;
        $('select[name="estado_solicitud"]').val("").closest('.form-group').removeClass('has-error');;
        $('select[name="proyecto_inversion"]').val("").closest('.form-group').removeClass('has-error');;

        $('textarea[name="objeto_contrato"]').val("").closest('.form-group').removeClass('has-error');;
        vector_datos_actividad.length=0;
        $('#div_finaciacion').show();
        $('#crear_paa_btn').html("Agregar");

    });
       


    $('#VerAgregarFinanciacion').on('click', function(e)
    {

      //console.log(vector_datos_actividad);
        var html = '';
            if(vector_datos_actividad.length > 0)
            {
              var num=1;
              $.each(vector_datos_actividad, function(i, e){
                html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['Nom_Proyecto']+'</td><td>'+e['Nom_Componente']+'</td><td>'+e['valor']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                num++;
              });
            }
            $('#registros').html(html);

        $('#ver_registros').modal('show');
        return false;
    });

    $('#datos_actividad').delegate('button[data-funcion="crear"]','click',function (e) {   
      var id = $(this).data('rel'); 
      vector_datos_actividad.splice(id, 1);
          
          $('#mensaje_eliminar').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato eliminado de la actividad con exito. </div>');
          $('#mensaje_eliminar').show(60);
          $('#mensaje_eliminar').delay(1500).hide(600);
          var html = '';
            if(vector_datos_actividad.length > 0)
            {
              var num=1;
              $.each(vector_datos_actividad, function(i, e){
                html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['Nom_Proyecto']+'</td><td>'+e['Nom_Componente']+'</td><td>'+e['valor']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                num++;
              });
            }
          $('#registros').html(html);

     }); 


     $('#TablaPAA').delegate('button[data-funcion="Financiacion"]','click',function (e){   
          var id = $(this).data('rel'); 
          $.ajax({
              url: URL+'/service/VerFinanciamiento/'+id,
              data: {},
              dataType: 'json',
              success: function(data)
              {   
                  var html = '';
                  $.each(data, function(i, dato){
                    var num=1;
                    html += '<tr>'+
                            '<th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+dato.actividad.meta.proyecto['Nombre']+'</td>'+
                            '<td>'+dato.actividad.meta['Nombre']+'</td>'+
                            '<td>'+dato.actividad['Nombre']+'</td>'+
                            '<td>'+dato.componente['Nombre']+'</td>'+
                            '<td>'+dato.componente.fuente['nombre']+'</td>'+
                            '<td>'+dato.pivot['valor']+'</td>'+
                            '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                    num++;
                  });
                  $('#registrosFinanzas').html(html);
              }
          });
     }); 


     $('#TablaPAA').delegate('button[data-funcion="Historial"]','click',function (e){   
          var id = $(this).data('rel'); 
          $.get(
              URL+'/service/obtenerHistorialPaa/'+id,
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
                      $.each(data, function(i, dato){
                        
                        if(dato['Estado']==0){
                          html += '<tr>'+
                          '<th scope="row" class="text-center">'+num+'</th>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                          num++;
                        }

                        if(dato['Estado']==1){
                          html1 += '<tr>'+
                          '<th scope="row" class="text-center">'+num2+'</th>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                          num1++;
                        }

                        if(dato['Estado']==2){
                          html2 += '<tr>'+
                          '<th scope="row" class="text-center">'+num2+'</th>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td>'+dato['Estado']+'</td>'+
                          '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                          num2++;
                        }

                      });
                      $('#registrosHtml').html(html);
                      $('#registrosHtml1').html(html1);
                      $('#Modal_Historial').modal('show'); 
                  }
              },
              'json'
          );
           
     }); 


    $('#TablaPAA').delegate('button[data-funcion="Modificacion"]','click',function (e) {  

        var id = $(this).data('rel'); 
        //$("#espera_3_"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/service/obtenerPaa/'+id,
            {},
            function(data)
            {
                if(data)
                {
                    actividad_datos(data);
                    $("#espera_3_"+id).html("");
                }
            },
            'json'
        );
    }); 


    var actividad_datos = function(datos)
    {
        

        $('input[name="id_Paa"]').val(datos['Id']).closest('.form-group').removeClass('has-error');;;
        $('input[name="id_registro"]').val(datos['Registro']).closest('.form-group').removeClass('has-error');;
        $('input[name="codigo_Unspsc"]').val(datos['CodigosU']).closest('.form-group').removeClass('has-error');;
        $('input[name="fecha_inicial_presupuesto"]').val(datos['FechaEstudioConveniencia']).closest('.form-group').removeClass('has-error');;
        $('input[name="fuente_recurso"]').val(datos['FuenteRecurso']).closest('.form-group').removeClass('has-error');;
        $('input[name="valor_estimado"]').val(datos['ValorEstimado']).closest('.form-group').removeClass('has-error');;
        $('input[name="valor_estimado_actualVigencia"]').val(datos['ValorEstimadoVigencia']).closest('.form-group').removeClass('has-error');;
        $('input[name="estudio_conveniencia"]').val(datos['FechaEstudioConveniencia']).closest('.form-group').removeClass('has-error');;
        $('input[name="fecha_inicio"]').val(datos['FechaInicioProceso']).closest('.form-group').removeClass('has-error');;
        $('input[name="fecha_suscripcion"]').val(datos['FechaSuscripcionContrato']).closest('.form-group').removeClass('has-error');;
        $('input[name="duracion_estimada"]').val(datos['DuracionContrato']).closest('.form-group').removeClass('has-error');;
        $('input[name="meta_plan"]').val(datos['MetaPlan']).closest('.form-group').removeClass('has-error');;
        $('input[name="numero_contratista"]').val(datos['NumeroContratista']).closest('.form-group').removeClass('has-error');;
        $('input[name="datos_contacto"]').val(datos['DatosResponsable']).closest('.form-group').removeClass('has-error');;

        $('select[name="recurso_humano"]').val(datos['RecursoHumano']).closest('.form-group').removeClass('has-error');;
        $('select[name="modalidad_seleccion"]').val(datos['Id_ModalidadSeleccion']).closest('.form-group').removeClass('has-error');;
        $('select[name="tipo_contrato"]').val(datos['Id_TipoContrato']).closest('.form-group').removeClass('has-error');;
        $('select[name="vigencias_futuras"]').val(datos['VigenciaFutura']).closest('.form-group').removeClass('has-error');;
        $('select[name="estado_solicitud"]').val(datos['EstadoVigenciaFutura']).closest('.form-group').removeClass('has-error');;
        $('select[name="proyecto_inversion"]').val(datos['Id_ProyectoRubro']).closest('.form-group').removeClass('has-error');;
        //$('select[name="Id_Localidad"]').val(datos['Localidad']).change();

        $('textarea[name="objeto_contrato"]').val(datos['ObjetoContractual']).closest('.form-group').removeClass('has-error');;
        vector_datos_actividad.length=1;
        $('#div_finaciacion').hide();
        $('#crear_paa_btn').html("Modificar");
        $('#Modal_AgregarNuevo').modal('show');      

    };
                  
});
