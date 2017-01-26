$(function()
{
  
  var URL = $('#main_paa_').data('url');
  vector_datos_actividad = new Array();

  
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
            'copy', 'csv', 'excel', 'pdf']
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


  var tb1 = $('#Tabla1').DataTable( {responsive: true   } );
  var tb2 = $('#Tabla2').DataTable( {responsive: true,  } );
  var tb3 = $('#Tabla3').DataTable( {responsive: true,  } );
  var tb4 = $('#Tabla4').DataTable( {responsive: true,  } );

  $('#Modal_AgregarNuevo').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	})
  
  $('#Modal_AprobarCambios').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	})

  $('#Modal_HistorialEliminar').on('shown.bs.modal', function () {
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

                        var disable=""; 
                      var estado="";
                      var clase="";
                          if(e['Estado']==4){              
                            clase="warning";
                            disable="disabled"; 
                            estado="En Subdireción";
                          }else if(e['Estado']==5){  
                            clase="success";
                            disable="disabled"; 
                            estado="Aprobado Subdireción"; 
                          }else if(e['Estado']==6){  
                            clase="danger";
                            disable=""; 
                            estado="Denegado Subdireción"; 
                          }else if(e['Estado']==7){  
                            clase="danger";
                            disable="disabled"; 
                            estado="CANCELADO"; 
                          }else{
                            estado="En Consolidación";
                            disable="";
                          }
    
                          var $tr1 = $('<tr class="'+clase+'"></tr>').html(
                            '<th scope="row" class="text-center">'+num+'</th>'+
                                '<td><b><p class="text-info text-center">'+e['Registro']+'</p></b></td>'+
                                '<td><b>'+estado+'</b></td>'+
                                '<td>'+e['CodigosU']+'</td>'+
                                '<td>'+e.modalidad['Nombre']+'</td>'+
                                '<td>'+e.tipocontrato['Nombre']+'</td>'+
                                '<td><div style="width:500px;text-align: justify;">'+e['ObjetoContractual']+'</div></td>'+
                                '<td>'+e['ValorEstimado']+'</td>'+
                                '<td>'+e['DuracionContrato']+'</td>'+
                                '<td>'+e['ValorEstimadoVigencia']+'</td>'+
                                '<td>'+e['VigenciaFutura']+'</td>'+
                                '<td>'+e['EstadoVigenciaFutura']+'</td>'+
                                '<td>'+e['FechaEstudioConveniencia']+'</td>'+
                                '<td>'+e['FechaInicioProceso']+'</td>'+
                                '<td>'+e['FechaSuscripcionContrato']+'</td>'+
                                '<td>'+e['RecursoHumano']+'</td>'+
                                '<td>'+e['NumeroContratista']+'</td>'+
                                '<td>'+e['DatosResponsable']+'</td>'+
                                '<td>'+e.rubro['Nombre']+'</td>'+
                                '<td>'+
                                  '<div class="btn-group tama">'+
                                    '<div class="btn-group">'+
                                      '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs2 btn-xs" title="Eliminar Paa" '+disable+'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '<div class="btn-group">'+
                                      '<button type="button" data-rel="'+e['Id']+'" data-funcion="Modificacion" class="btn btn-default btn-xs2 btn-xs" title="Editar Paa" '+disable+'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '<div class="btn-group">'+
                                      '<button type="button" data-rel="'+e['Id']+'" data-funcion="Historial" class="btn btn-primary  btn-xs2 btn-xs" title="Historial"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '<div class="btn-group">'+
                                      '<button type="button" data-rel="'+e['Id']+'" data-funcion="Financiacion" class="btn btn-success btn-xs2 btn-xs"  title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                  '</div>'+
                                  '<div>'+
                                    '<a href="#" class="btn btn-xs btn-default" style="width: 80%;    margin-top: 20px;" data-rel="'+e['Registro']+'" data-funcion="Observaciones"><span class="glyphicon glyphicon-info-sign"></span> Observaciones</a>'+
                                  '</div>'+
                                  '<div id=""></div>'+
                                '</td>'
                          );
                          t.row.add($tr1).draw( false );
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
                    //case 'fuente_recurso':
                    case 'valor_estimado':
                    case 'valor_estimado_actualVigencia':
                    case 'estudio_conveniencia':
                    case 'fecha_inicio':
                    case 'fecha_suscripcion':
                    case 'duracion_estimada':
                    //case 'meta_plan':
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

                                    html += '<option value="'+eeeee['Id']+'">'+eeeee.pivot['id']+"<b> Componente: </b>"+eeeee['Nombre'].toLowerCase()+"<br> FUENTE:"+eeeee.fuente['nombre'].toLowerCase()+'</option>';
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
        $('input[name="id_registro"]').val("0").closest('.form-group').removeClass('has-error');
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
          var id_act = $(this).data('rel'); 
          var desactivo="";
          $('#id_act_agre').val(id_act);

          $.ajax({
              url: URL+'/service/VerFinanciamiento/'+id_act,
              data: {},
              dataType: 'json',
              success: function(data)
              {   
                  var html = '';

                  if($.inArray(data.estado,['4','5','7'])!=-1){
                    desactivo="none";
                    $('#btn_agregar_finaza').hide();
                  }else{
                    desactivo="";
                    $('#btn_agregar_finaza').show();
                  }

                  $.each(data.dataInfo, function(i, dato){
                    var num=1;
                    html += '<tr>'+
                            '<th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+dato.actividad.meta.proyecto['Nombre']+'</td>'+
                            '<td>'+dato.actividad.meta['Nombre']+'</td>'+
                            '<td>'+dato.actividad['Nombre']+'</td>'+
                            '<td>'+dato.componente['Nombre']+'</td>'+
                            '<td>'+dato.componente.fuente['nombre']+'</td>'+
                            '<td>'+dato.pivot['valor']+'</td>'+
                            '<td class="text-center"><button type="button" data-dat="'+dato.pivot['actividadComponente_id']+'" data-rel="'+id_act+'" data-funcion="eliminar_finanza" class="eliminar_dato_actividad" style="display:'+desactivo+'""><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                    num++;
                  });
                  $('#registrosFinanzas').html(html);
              }
          });
     }); 


     $('#datos_actividad2').delegate('button[data-funcion="eliminar_finanza"]','click',function (e) {   
      var id_act = $(this).data('rel'); 
      var id_eli = $(this).data('dat');
      
        $.ajax({
              type: "POST",
              url: URL+'/service/EliminarFinanciamiento',
              data: {id:id_act,id_eli:id_eli},
              dataType: 'json',
              success: function(data)
              {   
                  var html = '';
                  $('#registrosFinanzas').html('');
                  var num=1;
                  $.each(data, function(i, dato){
                    //console.log(dato);
                    html += '<tr>'+
                            '<th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+dato.actividad.meta.proyecto['Nombre']+'</td>'+
                            '<td>'+dato.actividad.meta['Nombre']+'</td>'+
                            '<td>'+dato.actividad['Nombre']+'</td>'+
                            '<td>'+dato.componente['Nombre']+'</td>'+
                            '<td>'+dato.componente.fuente['nombre']+'</td>'+
                            '<td>'+dato.pivot['valor']+'</td>'+
                            '<td class="text-center"><button type="button" data-dat="'+dato.pivot['actividadComponente_id']+'" data-rel="'+id_act+'" data-funcion="eliminar_finanza" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';

                    num++;
                  });
                  $('#registrosFinanzas').html(html);
              }
          });
     });

     $('#form_agregar_finza').on('submit', function(e){

          var id_act=$('#id_act_agre').val();

          

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
                            validad_error_agre(data.errors);
                           var html = '';
                            $('#registrosFinanzas').html('');
                            var num=1;
                            $.each(data, function(i, dato){
                              //console.log(dato);
                              html += '<tr>'+
                                      '<th scope="row" class="text-center">'+num+'</th>'+
                                      '<td>'+dato.actividad.meta.proyecto['Nombre']+'</td>'+
                                      '<td>'+dato.actividad.meta['Nombre']+'</td>'+
                                      '<td>'+dato.actividad['Nombre']+'</td>'+
                                      '<td>'+dato.componente['Nombre']+'</td>'+
                                      '<td>'+dato.componente.fuente['nombre']+'</td>'+
                                      '<td>'+dato.pivot['valor']+'</td>'+
                                      '<td class="text-center"><button type="button" data-dat="'+dato.pivot['actividadComponente_id']+'" data-rel="'+id_act+'" data-funcion="eliminar_finanza" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';

                              num++;
                            });

                            $('#registrosFinanzas').html(html);
                            document.getElementById("form_agregar_finza").reset();
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

                    case 'Proyecto_inversion':
                    case 'componnente':
                    selector = 'select';
                    break;
                
                }
                $('#form_agregar_finza '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }



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

                      //console.log(data);
                      tb1.clear().draw();
                      tb2.clear().draw();
                      tb3.clear().draw();
                      $.each(data, function(i, dato){
                        
                       if(dato['Estado']==0 || dato['Estado']==4 || dato['Estado']==5 || dato['Estado']==6 || dato['Estado']==7){ // Registro Actual
                            tb1.row.add( [
                                '<th scope="row" class="text-center">'+num+'</th>',
                                '<td>'+dato['Registro']+'</td>',
                                '<td>'+dato['CodigosU']+'</td>',
                                '<td>'+dato.modalidad['Nombre']+'</td>',
                                '<td>'+dato.tipocontrato['Nombre']+'</td>',
                                '<td>'+dato['ObjetoContractual']+'</td>',
                                '<td>'+dato['FuenteRecurso']+'</td>',
                                '<td>'+dato['ValorEstimado']+'</td>',
                                '<td>'+dato['ValorEstimadoVigencia']+'</td>',
                                '<td>'+dato['VigenciaFutura']+'</td>',
                                '<td>'+dato['EstadoVigenciaFutura']+'</td>',
                                '<td>'+dato['FechaEstudioConveniencia']+'</td>',
                                '<td>'+dato['FechaInicioProceso']+'</td>',
                                '<td>'+dato['FechaSuscripcionContrato']+'</td>',
                                '<td>'+dato['DuracionContrato']+'</td>',
                                '<td>'+dato['MetaPlan']+'</td>',
                                '<td>'+dato['RecursoHumano']+'</td>',
                                '<td>'+dato['NumeroContratista']+'</td>',
                                '<td>'+dato['DatosResponsable']+'</td>',
                                '<td>'+dato.rubro['Nombre']+'</td>'
                            ] ).draw( false );
                            num++;
                        }

                        if(dato['Estado']==1){  //Por Aprobar
                              tb3.row.add( [
                                  '<th scope="row" class="text-center">'+num2+'</th>',
                                  '<td>'+dato['Registro']+'</td>',
                                  '<td>'+dato['CodigosU']+'</td>',
                                  '<td>'+dato.modalidad['Nombre']+'</td>',
                                  '<td>'+dato.tipocontrato['Nombre']+'</td>',
                                  '<td>'+dato['ObjetoContractual']+'</td>',
                                  '<td>'+dato['FuenteRecurso']+'</td>',
                                  '<td>'+dato['ValorEstimado']+'</td>',
                                  '<td>'+dato['ValorEstimadoVigencia']+'</td>',
                                  '<td>'+dato['VigenciaFutura']+'</td>',
                                  '<td>'+dato['EstadoVigenciaFutura']+'</td>',
                                  '<td>'+dato['FechaEstudioConveniencia']+'</td>',
                                  '<td>'+dato['FechaInicioProceso']+'</td>',
                                  '<td>'+dato['FechaSuscripcionContrato']+'</td>',
                                  '<td>'+dato['DuracionContrato']+'</td>',
                                  '<td>'+dato['MetaPlan']+'</td>',
                                  '<td>'+dato['RecursoHumano']+'</td>',
                                  '<td>'+dato['NumeroContratista']+'</td>',
                                  '<td>'+dato['DatosResponsable']+'</td>',
                                  '<td>'+dato.rubro['Nombre']+'</td>'
                              ] ).draw( false );
                          num2++;
                        }

                        if(dato['Estado']==2){ //Ya revisados
                            tb2.row.add( [
                                  '<th scope="row" class="text-center">'+num1+'</th>',
                                  '<td>'+dato['Registro']+'</td>',
                                  '<td>'+dato['CodigosU']+'</td>',
                                  '<td>'+dato.modalidad['Nombre']+'</td>',
                                  '<td>'+dato.tipocontrato['Nombre']+'</td>',
                                  '<td>'+dato['ObjetoContractual']+'</td>',
                                  '<td>'+dato['FuenteRecurso']+'</td>',
                                  '<td>'+dato['ValorEstimado']+'</td>',
                                  '<td>'+dato['ValorEstimadoVigencia']+'</td>',
                                  '<td>'+dato['VigenciaFutura']+'</td>',
                                  '<td>'+dato['EstadoVigenciaFutura']+'</td>',
                                  '<td>'+dato['FechaEstudioConveniencia']+'</td>',
                                  '<td>'+dato['FechaInicioProceso']+'</td>',
                                  '<td>'+dato['FechaSuscripcionContrato']+'</td>',
                                  '<td>'+dato['DuracionContrato']+'</td>',
                                  '<td>'+dato['MetaPlan']+'</td>',
                                  '<td>'+dato['RecursoHumano']+'</td>',
                                  '<td>'+dato['NumeroContratista']+'</td>',
                                  '<td>'+dato['DatosResponsable']+'</td>',
                                  '<td>'+dato.rubro['Nombre']+'</td>'
                              ] ).draw( false );
                          num1++;
                        } 
                      });

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

        if(datos['Estado']==4 || datos['Estado'] ==5){
          $('#crear_paa_btn').hide();
          $('#mjs_mod_denegada').show();    
        }else{
          $('#crear_paa_btn').show();
          $('#mjs_mod_denegada').hide();
        }
        $('#Modal_AgregarNuevo').modal('show');      

    };


    
    $('#ElimianrPAA_btn').on('click', function(e)
    {
       
       var id = $('#idRegist_inpt').val();

       $.get(
            URL+'/service/EliminarPaa/'+id,
            $(this).serialize(),
            function(data){
                  if(data.status == 'modelo')
                  {           
                      var num=1;
                      t.clear().draw();
                      $.each(data.datos, function(i, e){
                          var disable=""; 
                          var estado="";
                          var clase="";

                          if(e['Estado']==4){              
                            clase="warning";
                            disable="disabled"; 
                            estado="En Subdireción";
                          }else if(e['Estado']==5){  
                            clase="success";
                            disable="disabled"; 
                            estado="Aprobado Subdireción"; 
                          }else if(e['Estado']==6){  
                            clase="danger";
                            disable=""; 
                            estado="Denegado Subdireción"; 
                          }else if(e['Estado']==7){  
                            clase="danger";
                            disable="disabled"; 
                            estado="CANCELADO"; 
                          }else{
                            estado="Por revisión";
                            disable="";
                          }
    
                          var $tr1 = $('<tr class="'+clase+'"></tr>').html(
                            '<th scope="row" class="text-center">'+num+'</th>'+
                                '<td><b><p class="text-info text-center">'+e['Registro']+'</p></b></td>'+
                                '<td><b>'+estado+'</b></td>'+
                                '<td>'+e['CodigosU']+'</td>'+
                                '<td>'+e.modalidad['Nombre']+'</td>'+
                                '<td>'+e.tipocontrato['Nombre']+'</td>'+
                                '<td><div style="width:500px;text-align: justify;">'+e['ObjetoContractual']+'</div></td>'+
                                '<td>'+e['ValorEstimado']+'</td>'+
                                '<td>'+e['DuracionContrato']+'</td>'+
                                '<td>'+e['ValorEstimadoVigencia']+'</td>'+
                                '<td>'+e['VigenciaFutura']+'</td>'+
                                '<td>'+e['EstadoVigenciaFutura']+'</td>'+
                                '<td>'+e['FechaEstudioConveniencia']+'</td>'+
                                '<td>'+e['FechaInicioProceso']+'</td>'+
                                '<td>'+e['FechaSuscripcionContrato']+'</td>'+
                                '<td>'+e['RecursoHumano']+'</td>'+
                                '<td>'+e['NumeroContratista']+'</td>'+
                                '<td>'+e['DatosResponsable']+'</td>'+
                                '<td>'+e.rubro['Nombre']+'</td>'+
                                '<td>'+
                                  '<div class="btn-group tama">'+
                                    '<div class="btn-group">'+
                                      '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs2 btn-xs" title="Eliminar Paa" '+disable+'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '<div class="btn-group">'+
                                      '<button type="button" data-rel="'+e['Id']+'" data-funcion="Modificacion" class="btn btn-default btn-xs2 btn-xs" title="Editar Paa" '+disable+'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '<div class="btn-group">'+
                                      '<button type="button" data-rel="'+e['Id']+'" data-funcion="Historial" class="btn btn-primary  btn-xs2 btn-xs" title="Historial"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '<div class="btn-group">'+
                                      '<button type="button" data-rel="'+e['Id']+'" data-funcion="Financiacion" class="btn btn-success btn-xs2 btn-xs"  title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                  '</div>'+
                                  '<div>'+
                                    '<a href="#" class="btn btn-xs btn-default" style="width: 80%;    margin-top: 20px;" data-rel="'+e['Registro']+'" data-funcion="Observaciones"><span class="glyphicon glyphicon-info-sign"></span> Observaciones</a>'+
                                  '</div>'+
                                  '<div id=""></div>'+
                                '</td>'
                          );
                          t.row.add($tr1).draw( false );
                          num++;
                      });
                      $('#mjs_ElimRegistro').html(' <strong>Registro Eliminado con Exitoso!</strong> Se realizo la eliminación del resgistro de su PAA.');
                      $('#mjs_ElimRegistro').show();
                      setTimeout(function(){
                          $('#mjs_ElimRegistro').hide();
                          $('#Modal_Eliminar').modal('hide'); 
                      }, 3000)
                  }else{
                      $('#mjs_ElimRegistro').html('<strong>Error!</strong> el valor del presupuesto que intenta eliminar tiene problemas.');
                      $('#mjs_ElimRegistro').show();
                      setTimeout(function(){
                          $('#mjs_ElimRegistro').hide();
                          $('#Modal_Eliminar').modal('hide'); 
                      }, 6000)
                  }
          },'json');
    });

    $('#TablaPAA').delegate('button[data-funcion="ver_eli"]','click',function (e) {  
        var id = $(this).data('rel');
        $('#idRegist_inpt').val(id); 
        $('#idRegist').text(id); 
        $('#Modal_Eliminar').modal('show'); 
    }); 


    $('#Modal_HistorialEliminar_btn').on('click', function(e)
    {
        
       $.get(
            URL+'/service/HistorialEliminarPaa/1',
            $(this).serialize(),
            function(data){
                  if(data.status == 'modelo')
                  {           
                      var num=1;
                      tb4.clear().draw();
                      $.each(data.datos, function(i, e){
                          tb4.row.add( [
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
                          ] ).draw( false );
                          num++;
                      });

                      $('#Modal_HistorialEliminar1').modal('show');
                  }else{
                      $('#mjs_ElimRegistro').html('<strong>Error!</strong> el valor del presupuesto que intenta eliminar tiene problemas.');
                      $('#mjs_ElimRegistro').show();
                      setTimeout(function(){
                          $('#mjs_ElimRegistro').hide();
                          $('#Modal_Eliminar').modal('hide'); 
                      }, 6000)
                  }
          },'json');
        
    });


     $('#TablaPAA').delegate('a[data-funcion="Observaciones"]','click',function (e)
    {
        var id = $(this).data('rel');
        $('.NumPaa').text(id);
        $('#paa_registro').val(id);

        $.ajax({
              url: URL+'/service/historialObservaciones/'+id,
              data: {},
              dataType: 'json',
              success: function(data)
              {   
                  var html = '';
                  var num=1;
                  
                  $.each(data, function(i, dato){
                    html += '<tr>'+
                            '<th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+dato['id_persona']+'</td>'+
                            '<td>'+dato['observacion']+'</td>'+
                            '<td>'+dato['estado']+'</td>'+
                            '<td>'+dato['created_at']+'</td>';
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


                  
});
