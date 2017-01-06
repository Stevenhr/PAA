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
              URL+'/service/obtenerHistorialPaaTodo/'+id,
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
                      
                      $('#mensaje_aprobacion').html('<strong>No hay Registros Pendiente!</strong> Los datos se registraron exitosamente.');
                      $('#mensaje_aprobacion').show();
                      $('#Modal_Historial').modal('show'); 
                      setTimeout(function(){
                         $('#mensaje_aprobacion').hide();
                      }, 6000)
                      
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
                          '<td><h5>'+$DatosResponsable+'</h5></td>',
                          '<td><h5>'+$Nombre_r+'</h5></td>'
                      ] ).draw( false );
                     
                      $.each(data, function(i, dato){
                        if(dato['Estado']==1){ //Cambios aporbados
                            tb5.row.add( [
                                  '<th scope="row" class="text-center">'+num1+'<input type="hidden" value="'+dato['Id']+'" name="Id[]"></th>',
                                  '<td>'+dato['CodigosU']+'<br><label class="radio-inline"><input type="radio" value="'+dato['CodigosU']+'" name="CodigosU[]">Selecionar</label></td>',
                                  '<td>'+dato.modalidad['Nombre']+'<br><label class="radio-inline"><input type="radio" value="'+dato.modalidad['Id']+'" name="Nombre_m[]" >Selecionar</label></td>',
                                  '<td>'+dato.tipocontrato['Nombre']+'<br><label class="radio-inline"><input type="radio" value="'+dato.tipocontrato['Id']+'" name="Nombre_t[]">Selecionar</label></td>',
                                  '<td>'+dato['ObjetoContractual']+'<br><label class="radio-inline"><input type="radio" value="'+dato['ObjetoContractual']+'" name="ObjetoContractual[]">Selecionar</label></td>',
                                  '<td>'+dato['FuenteRecurso']+'<br><label class="radio-inline"><input type="radio" value="'+dato['FuenteRecurso']+'" name="FuenteRecurso[]">Selecionar</label></td>',
                                  '<td>'+dato['ValorEstimado']+'<br><label class="radio-inline"><input type="radio" value="'+dato['ValorEstimado']+'" name="ValorEstimado[]">Selecionar</label></td>',
                                  '<td>'+dato['ValorEstimadoVigencia']+'<br><label class="radio-inline"><input type="radio" value="'+dato['ValorEstimadoVigencia']+'" name="ValorEstimadoVigencia[]">Selecionar</label></td>',
                                  '<td>'+dato['VigenciaFutura']+'<br><label class="radio-inline"><input type="radio" value="'+dato['VigenciaFutura']+'" name="VigenciaFutura[]">Selecionar</label></td>',
                                  '<td>'+dato['EstadoVigenciaFutura']+'<br><label class="radio-inline"><input type="radio" value="'+dato['EstadoVigenciaFutura']+'" name="EstadoVigenciaFutura[]">Selecionar</label></td>',
                                  '<td>'+dato['FechaEstudioConveniencia']+'<br><label class="radio-inline"><input type="radio" value="'+dato['FechaEstudioConveniencia']+'" name="FechaEstudioConveniencia[]">Selecionar</label></td>',
                                  '<td>'+dato['FechaInicioProceso']+'<br><label class="radio-inline"><input type="radio" value="'+dato['FechaInicioProceso']+'" name="FechaInicioProceso[]">Selecionar</label></td>',
                                  '<td>'+dato['FechaSuscripcionContrato']+'<br><label class="radio-inline"><input type="radio" value="'+dato['FechaSuscripcionContrato']+'" name="FechaSuscripcionContrato[]">Selecionar</label></td>',
                                  '<td>'+dato['DuracionContrato']+'<br><label class="radio-inline"><input type="radio" value="'+dato['DuracionContrato']+'" name="DuracionContrato[]">Selecionar</label></td>',
                                  '<td>'+dato['MetaPlan']+'<br><label class="radio-inline"><input type="radio" value="'+dato['MetaPlan']+'" name="MetaPlan[]">Selecionar</label></td>',
                                  '<td>'+dato['RecursoHumano']+'<br><label class="radio-inline"><input type="radio" value="'+dato['RecursoHumano']+'" name="RecursoHumano[]">Selecionar</label></td>',
                                  '<td>'+dato['NumeroContratista']+'<br><label class="radio-inline"><input type="radio" value="'+dato['NumeroContratista']+'" name="NumeroContratista[]">Selecionar</label></td>',
                                  '<td>'+dato['DatosResponsable']+'<br><label class="radio-inline"><input type="radio" value="'+dato['DatosResponsable']+'" name="DatosResponsable[]">Selecionar</label></td>',
                                  '<td>'+dato.rubro['Nombre']+'<br><label class="radio-inline"><input type="radio" value="'+dato.rubro['Id']+'" name="Nombre_r[]">Selecionar</label></td>',
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
    var id = new Array();
    $('input[name="Id[]"]').each(function(){
                id.push($(this).val());
    });

    var CodigosU = new Array();
    $('input[name="CodigosU[]"]').each(function(){
                if( $(this).is(':checked') ){
                    CodigosU.push($(this).val());
                }else{
                    CodigosU.push(0);
                }
    });

    var Nombre_m = new Array();
    $('input[name="Nombre_m[]"]').each(function(){
                if( $(this).is(':checked') ){
                    Nombre_m.push($(this).val());
                }else{
                    Nombre_m.push(0);
                }
    });


    var Nombre_t = new Array();
    $('input[name="Nombre_t[]"]').each(function(){
                if( $(this).is(':checked') ){
                    Nombre_t.push($(this).val());
                }else{
                    Nombre_t.push(0);
                }
    });
    
    var responsble = new Array();
    $('input[name="DatosResponsable[]"]').each(function(){
                if( $(this).is(':checked') ){
                    responsble.push($(this).val());
                }else{
                    responsble.push(0);
                }
    });


     var ObjetoContractual = new Array();
    $('input[name="ObjetoContractual[]"]').each(function(){
                if( $(this).is(':checked') ){
                    ObjetoContractual.push($(this).val());
                }else{
                    ObjetoContractual.push(0);
                }
    });


    var FuenteRecurso = new Array();
    $('input[name="FuenteRecurso[]"]').each(function(){
                if( $(this).is(':checked') ){
                    FuenteRecurso.push($(this).val());
                }else{
                    FuenteRecurso.push(0);
                }
    });

    var ValorEstimado = new Array();
    $('input[name="ValorEstimado[]"]').each(function(){
                if( $(this).is(':checked') ){
                    ValorEstimado.push($(this).val());
                }else{
                    ValorEstimado.push(0);
                }
    });


    var ValorEstimadoVigencia = new Array();
    $('input[name="ValorEstimadoVigencia[]"]').each(function(){
                if( $(this).is(':checked') ){
                    ValorEstimadoVigencia.push($(this).val());
                }else{
                    ValorEstimadoVigencia.push(0);
                }
    });


    var VigenciaFutura = new Array();
    $('input[name="VigenciaFutura[]"]').each(function(){
                if( $(this).is(':checked') ){
                    VigenciaFutura.push($(this).val());
                }else{
                    VigenciaFutura.push(0);
                }
    });


    var EstadoVigenciaFutura = new Array();
    $('input[name="EstadoVigenciaFutura[]"]').each(function(){
                if( $(this).is(':checked') ){
                    EstadoVigenciaFutura.push($(this).val());
                }else{
                    EstadoVigenciaFutura.push(0);
                }
    });


    var FechaEstudioConveniencia = new Array();
    $('input[name="FechaEstudioConveniencia[]"]').each(function(){
                if( $(this).is(':checked') ){
                    FechaEstudioConveniencia.push($(this).val());
                }else{
                    FechaEstudioConveniencia.push(0);
                }
    });


    var FechaInicioProceso = new Array();
    $('input[name="FechaInicioProceso[]"]').each(function(){
                if( $(this).is(':checked') ){
                    FechaInicioProceso.push($(this).val());
                }else{
                    FechaInicioProceso.push(0);
                }
    });


    var FechaSuscripcionContrato = new Array();
    $('input[name="FechaSuscripcionContrato[]"]').each(function(){
                if( $(this).is(':checked') ){
                    FechaSuscripcionContrato.push($(this).val());
                }else{
                    FechaSuscripcionContrato.push(0);
                }
    });

    var DuracionContrato = new Array();
    $('input[name="DuracionContrato[]"]').each(function(){
                if( $(this).is(':checked') ){
                    DuracionContrato.push($(this).val());
                }else{
                    DuracionContrato.push(0);
                }
    });


    var MetaPlan = new Array();
    $('input[name="MetaPlan[]"]').each(function(){
                if( $(this).is(':checked') ){
                    MetaPlan.push($(this).val());
                }else{
                    MetaPlan.push(0);
                }
    });


    var RecursoHumano = new Array();
    $('input[name="RecursoHumano[]"]').each(function(){
                if( $(this).is(':checked') ){
                    RecursoHumano.push($(this).val());
                }else{
                    RecursoHumano.push(0);
                }
    });


    var NumeroContratista = new Array();
    $('input[name="NumeroContratista[]"]').each(function(){
                if( $(this).is(':checked') ){
                    NumeroContratista.push($(this).val());
                }else{
                    NumeroContratista.push(0);
                }
    });

    var Nombre_r = new Array();
    $('input[name="Nombre_r[]"]').each(function(){
                if( $(this).is(':checked') ){
                    Nombre_r.push($(this).val());
                }else{
                    Nombre_r.push(0);
                }
    });

    $.post(
      URL+'/service/DatosAprobacion',
      {id: id, CodigosU:CodigosU, Nombre_m:Nombre_m ,Nombre_t:Nombre_t, ObjetoContractual:ObjetoContractual, FuenteRecurso:FuenteRecurso, ValorEstimado:ValorEstimado, ValorEstimadoVigencia:ValorEstimadoVigencia, VigenciaFutura:VigenciaFutura, EstadoVigenciaFutura:EstadoVigenciaFutura, FechaEstudioConveniencia:FechaEstudioConveniencia, FechaInicioProceso:FechaInicioProceso, FechaSuscripcionContrato:FechaSuscripcionContrato, DuracionContrato:DuracionContrato , MetaPlan:MetaPlan, RecursoHumano:RecursoHumano, NumeroContratista:NumeroContratista ,  Nombre_r:Nombre_r, resposanble : responsble },
      function(data){
            $('#mensaje_aprobacion').html('<strong>Registro de datos!</strong> Los datos se registraron exitosamente.');
            $('#mensaje_aprobacion').show();
            setTimeout(function(){
               $('#mensaje_aprobacion').hide();
                $('#Modal_AprobarCambiosH').modal('hide');
            }, 6000)
    },'json');

        e.preventDefault();
    });

                  
});
