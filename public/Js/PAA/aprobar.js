$(function()
{
  
  var URL = $('#main_paa_Aprobar').data('url');
  vector_datos_actividad = new Array();

  var t = $('#TablaPAA').DataTable( {responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf']
  } );

  var tb1 = $('#Tabla1').DataTable( {responsive: true  } );

  var tb2 = $('#Tabla2').DataTable( {responsive: true,  } );

  var tb3 = $('#Tabla3').DataTable( {responsive: true,  } );

  var tb4 = $('#Tabla4').DataTable( {responsive: true,  } );

  var tb5 = $('#Tabla5').DataTable( {responsive: true, } );
  var tb6 = $('#Tabla6').DataTable( {responsive: true,  } );

  $('input[data-role="datepicker"]').datepicker({
      dateFormat: 'yy-mm-dd',
      yearRange: "-100:+0",
      changeMonth: true,
      changeYear: true,
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

                      //console.log(data);
                      tb1.clear().draw();
                      tb2.clear().draw();
                      tb3.clear().draw();
                      $.each(data, function(i, dato){
                        
                        if(dato['Estado']==0){ // Registro Actual
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

                        if(dato['Estado']==1){ //Cambios aporbados
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

                        if(dato['Estado']==2){  //Por Aprobar
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
                      });

                      $('#Modal_Historial').modal('show'); 
                  }
              },
              'json'
          );
           
     }); 

    
                        $Registro="";
                        $CodigosU="";
                        $Nombre_m="";
                        $Nombre_t="";
                        $ObjetoContractual="";
                        $FuenteRecurso="";
                        $ValorEstimado="";
                        $ValorEstimadoVigencia="";
                        $VigenciaFutura="";
                        $EstadoVigenciaFutura="";
                        $FechaEstudioConveniencia="";
                        $FechaInicioProceso="";
                        $FechaSuscripcionContrato="";
                        $DuracionContrato="";
                        $MetaPlan="";
                        $RecursoHumano="";
                        $NumeroContratista="";
                        $DatosResponsable="";
                        $Nombre_r="";

    $('#TablaPAA').delegate('button[data-funcion="Aprobacion"]','click',function (e)
    {
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

                      tb5.clear().draw();

                      $.each(data, function(i, dato){
                        
                        if(dato['Estado']==0){ // Registro Actual
                                  $Registro=dato['Registro'];
                                  $CodigosU=dato['CodigosU'];
                                  $Nombre_m=dato.modalidad['Nombre'];
                                  $Nombre_t=dato.tipocontrato['Nombre'];
                                  $ObjetoContractual=dato['ObjetoContractual'];
                                  $FuenteRecurso=dato['FuenteRecurso'];
                                  $ValorEstimado=dato['ValorEstimado'];
                                  $ValorEstimadoVigencia=dato['ValorEstimadoVigencia'];
                                  $VigenciaFutura=dato['VigenciaFutura'];
                                  $EstadoVigenciaFutura=dato['EstadoVigenciaFutura'];
                                  $FechaEstudioConveniencia=dato['FechaEstudioConveniencia'];
                                  $FechaInicioProceso=dato['FechaInicioProceso'];
                                  $FechaSuscripcionContrato=dato['FechaSuscripcionContrato'];
                                  $DuracionContrato=dato['DuracionContrato'];
                                  $MetaPlan=dato['MetaPlan'];
                                  $RecursoHumano=dato['RecursoHumano'];
                                  $NumeroContratista=dato['NumeroContratista'];
                                  $DatosResponsable=dato['DatosResponsable'];
                                  $Nombre_r=dato.rubro['Nombre'];
                        }
                        // 1 Cambios aporbados
                        // 2 Aprobados                       
                        // 3 Eliminados
                      });

                       tb5.row.add( [
                          '<th scope="row" class="text-center">'+num1+'</th>',
                          '<td><h5>'+$CodigosU+'</h5></td>',
                          '<td><h5>'+$Nombre_m+'</h5></td>',
                          '<td><h5>'+$Nombre_t+'</h5></td>',
                          '<td><h5>'+$ObjetoContractual+'</h5></td>',
                          '<td><h5>'+$FuenteRecurso+'</h5></td>',
                          '<td><h5>'+$ValorEstimado+'</h5></td>',
                          '<td><h5>'+$ValorEstimadoVigencia+'</h5></td>',
                          '<td><h5>'+$VigenciaFutura+'</h5></td>',
                          '<td><h5>'+$EstadoVigenciaFutura+'</h5></td>',
                          '<td><h5>'+$FechaEstudioConveniencia+'</h5></td>',
                          '<td><h5>'+$FechaInicioProceso+'</h5></td>',
                          '<td><h5>'+$FechaSuscripcionContrato+'</h5></td>',
                          '<td><h5>'+$DuracionContrato+'</h5></td>',
                          '<td><h5>'+$MetaPlan+'</h5></td>',
                          '<td><h5>'+$RecursoHumano+'</h5></td>',
                          '<td><h5>'+$NumeroContratista+'</h5></td>',
                          '<td><h5>'+$DatosResponsable+'</h5><hr></td>',
                          '<td><h5>'+$Nombre_r+'</h5></td>'
                      ] ).draw( false );
                     
                      $.each(data, function(i, dato){
                        if(dato['Estado']==1){ //Cambios aporbados
                            tb5.row.add( [
                                  '<th scope="row" class="text-center">'+num1+'<input type="hidden" value="'+dato['Id']+'" name="Id[]"></th>',
                                  '<td>'+dato['CodigosU']+'<br><label class="radio-inline"><input type="radio" value="'+dato['CodigosU']+'" name="CodigosU">Selecionar</label></td>',
                                  '<td>'+dato.modalidad['Nombre']+'<br><label class="radio-inline"><input type="radio" value="'+dato.modalidad['Nombre']+'" name="Nombre_m" >Selecionar</label></td>',
                                  '<td>'+dato.tipocontrato['Nombre']+'<br><label class="radio-inline"><input type="radio" value="'+dato.tipocontrato['Nombre']+'" name="Nombre_t">Selecionar</label></td>',
                                  '<td>'+dato['ObjetoContractual']+'<br><label class="radio-inline"><input type="radio" value="'+dato['ObjetoContractual']+'" name="ObjetoContractual">Selecionar</label></td>',
                                  '<td>'+dato['FuenteRecurso']+'<br><label class="radio-inline"><input type="radio" value="'+dato['FuenteRecurso']+'" name="FuenteRecurso">Selecionar</label></td>',
                                  '<td>'+dato['ValorEstimado']+'<br><label class="radio-inline"><input type="radio" value="'+dato['ValorEstimado']+'" name="ValorEstimado">Selecionar</label></td>',
                                  '<td>'+dato['ValorEstimadoVigencia']+'<br><label class="radio-inline"><input type="radio" value="'+dato['ValorEstimadoVigencia']+'" name="ValorEstimadoVigencia">Selecionar</label></td>',
                                  '<td>'+dato['VigenciaFutura']+'<br><label class="radio-inline"><input type="radio" value="'+dato['VigenciaFutura']+'" name="VigenciaFutura">Selecionar</label></td>',
                                  '<td>'+dato['EstadoVigenciaFutura']+'<br><label class="radio-inline"><input type="radio" value="'+dato['EstadoVigenciaFutura']+'" name="EstadoVigenciaFutura">Selecionar</label></td>',
                                  '<td>'+dato['FechaEstudioConveniencia']+'<br><label class="radio-inline"><input type="radio" value="'+dato['FechaEstudioConveniencia']+'" name="FechaEstudioConveniencia">Selecionar</label></td>',
                                  '<td>'+dato['FechaInicioProceso']+'<br><label class="radio-inline"><input type="radio" value="'+dato['FechaInicioProceso']+'" name="FechaInicioProceso">Selecionar</label></td>',
                                  '<td>'+dato['FechaSuscripcionContrato']+'<br><label class="radio-inline"><input type="radio" value="'+dato['FechaSuscripcionContrato']+'" name="FechaSuscripcionContrato">Selecionar</label></td>',
                                  '<td>'+dato['DuracionContrato']+'<br><label class="radio-inline"><input type="radio" value="'+dato['FechaSuscripcionContrato']+'" name="DuracionContrato">Selecionar</label></td>',
                                  '<td>'+dato['MetaPlan']+'<br><label class="radio-inline"><input type="radio" value="" name="MetaPlan">Selecionar</label></td>',
                                  '<td>'+dato['RecursoHumano']+'<br><label class="radio-inline"><input type="radio" value="" name="RecursoHumano">Selecionar</label></td>',
                                  '<td>'+dato['NumeroContratista']+'<br><label class="radio-inline"><input type="radio" value="" name="NumeroContratista">Selecionar</label></td>',
                                  '<td>'+dato['DatosResponsable']+'<br><label class="radio-inline"><input type="radio" value="'+dato['DatosResponsable']+'" name="DatosResponsable[]">Selecionar</label></td>',
                                  '<td>'+dato.rubro['Nombre']+'<br><label class="radio-inline"><input type="radio" value="" name="Nombre_r">Selecionar</label></td>',
                              ] ).draw( false );
                          num1++;
                        }
                      });

                      $('#Modal_AprobarCambiosH').modal('show'); 
                  }
              },
              'json'
          );
           
     }); 

    $('#form_aprobacion').on('submit', function(e){
  
  //  console.log($('input[name="registro"]').val()+' - '+$('input[name="DatosResponsable"]:checked').val());
    var id= new Array();
    $('input[name="Id[]"]').each(function(){
                id.push($(this).val());
    });
    
    var responsble= new Array();
    $('input[name="DatosResponsable[]"]').each(function(){
                if( $(this).is(':checked') ){
                    responsble.push($(this).val());
                }else{
                    responsble.push(0);
                }
    });



    $.post(
            URL+'/service/DatosAprobacion',
            {id: id, resposanble : responsble},
            function(data){
              alert(data);
          },'json');

      

        /*$.post(URL+'/validar/proyecto',$(this).serialize(),function(data){
            if(data.status == 'error')
            {
                validad_error2(data.errors);
            } else {
                
                if(data.status == 'modelo')
                {
                    var datos=data.presupuesto;
                    document.getElementById("form_proyecto").reset();
                    $("#div_Tabla4").show();
                    var num=1;
                    tt.clear().draw();
                    $.each(datos, function(i, e){
                        $.each(e.proyectos, function(i, ee){
                            tt.row.add( [
                                '<th scope="row" class="text-center">'+num+'</th>',
                                '<td><h4>'+e['Nombre_Actividad']+'<h4></td>',
                                '<td>'+ee['Nombre']+'</td>',
                                '<td>'+ee['fecha_inicio']+'</td>',
                                '<td>'+ee['fecha_fin']+'</td>',
                                '<td>'+ee['valor']+'</td>',
                                '<td><div class="btn-group btn-group-justified">'+
                                    '<div class="btn-group">'+
                                    '<button type="button" data-rel="'+ee['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '<div class="btn-group">'+
                                    '<button type="button" data-rel="'+ee['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '</div>'+
                                    '<div id="espera'+ee['Id']+'"></div>'+
                                '</td>'
                            ] ).draw( false );
                            num++;
                        });
                    });

                    $('#mensaje_proyecto').html('<strong>Bien!</strong> Registro creado con exíto.');
                    $('#mensaje_proyecto').show();
                    setTimeout(function(){
                        $('#mensaje_proyecto').hide();
                        $("#id_btn_proyecto").html('Registrar');
                        $("#id_btn_proyect_canc").hide();
                    }, 2000)
                    $('input[name="Id_proyecto"]').val('0');
                }else{
                    $('#mensaje_proyecto2').html('<strong>Error!</strong> el valor del proyecto que intenta ingresar $'+data.valorNuevo+' '+data.mensaje+': $'+data.saldo);
                    $('#mensaje_proyecto2').show();
                    setTimeout(function(){
                        $('#mensaje_proyecto2').hide();
                    }, 6000)
                }
                
            }
        },'json');*/

        e.preventDefault();
    });



                  
});
