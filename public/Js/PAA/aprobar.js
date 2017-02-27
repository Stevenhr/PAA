$(function()
{
$('body').delegate('#Tabla5 tbody input:radio','click',function(){
    $('#Tabla5 tbody input[name="'+$(this).attr('name')+'"]').each(function(i, e){
        $(this).closest("td").toggleClass("seleccionado", $(this).is(":checked"));
    });
});

  var URL = $('#main_paa_Aprobar').data('url');
  vector_datos_actividad = new Array();

  

   $('#TablaPAA tfoot th').each( function () {
        var title = $(this).text();
        if(title!="Menu" && title!="N°"){
          $(this).html( '<input type="text" placeholder="Buscar" />' );
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
          var html="";
          $.ajax({
              url: URL+'/service/VerFinanciamiento/'+id,
              data: {},
              dataType: 'json',
              success: function(data)
              {   
                   var num=1;
                  $.each(data.dataInfo.componentes, function(i, dato){
                    html += '<tr>'+
                            '<th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+dato.fuente['nombre']+'</td>'+
                            '<td>'+dato['Nombre']+'</td>'+
                            '<td>'+dato.pivot['valor']+'</td>';
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
                      //console.log(data);
                      $.each(data, function(i, dato){
                        var campos =new Array();
                        $.each(dato.cambios_paa, function(ii, cambio){
                            if(cambio.campo){
                               campos[ii]=cambio.campo;
                            }
                        });  
                        /*$.each(cambios, function(ii2, camb){
                          console.log(camb);
                        });  */

                        if(dato['Estado']==0 || dato['Estado']==4 || dato['Estado']==5 || dato['Estado']==6 || dato['Estado']==7){ // Registro Actual
                            $regis=dato['DatosResponsable'];
                            tb1.row.add( [
                                '<th scope="row" class="text-center">'+num+'</th>',
                                '<td>'+dato['Registro']+'</td>',
                                '<td>'+dato['CodigosU']+'</td>',
                                '<td>'+dato.modalidad['Nombre']+'</td>',
                                '<td>'+dato.tipocontrato['Nombre']+'</td>',
                                '<td><div style="width:500px;text-align: justify;">'+dato['ObjetoContractual']+'</div></td>',
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
                                  '<td><div style="width:500px;text-align: justify;">'+dato['ObjetoContractual']+'</div></td>',
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

                            $estilo="";
                            $estilo1="";
                            $estilo2="";
                            $estilo3="";
                            $estilo4="";
                            $estilo5="";
                            $estilo6="";
                            $estilo7="";
                            $estilo8="";
                            $estilo9="";
                            $estilo10="";
                            $estilo11="";
                            $estilo12="";
                            $estilo13="";
                            $estilo14="";
                            $estilo15="";
                            $estilo16="";
                            $estilo17="";
                            $estilo18="";

                             if(campos.indexOf("CodigosU")=='-1')
                              $estilo1="";
                             else
                              $estilo1="color: green !important;";

                             if(campos.indexOf("Id_ModalidadSeleccion")=='-1')
                              $estilo2="";
                             else
                              $estilo2="color: green !important;";

                             if(campos.indexOf("Id_TipoContrato")=='-1')
                              $estilo3="";
                             else
                              $estilo3="color: green !important;";

                             if(campos.indexOf("ObjetoContractual")=='-1')
                              $estilo4="";
                             else
                              $estilo4="color: green !important;";

                             if(campos.indexOf("FuenteRecurso")=='-1')
                              $estilo5="";
                             else
                              $estilo5="color: green !important;";

                             if(campos.indexOf("ValorEstimado")=='-1')
                              $estilo6="";
                             else
                              $estilo6="color: green !important;";

                             if(campos.indexOf("ValorEstimadoVigencia")=='-1')
                              $estilo7="";
                             else
                              $estilo7="color: green !important;";

                             if(campos.indexOf("VigenciaFutura")=='-1')
                              $estilo8="";
                             else
                              $estilo8="color: green !important;";

                             if(campos.indexOf("EstadoVigenciaFutura")=='-1')
                              $estilo9="";
                             else
                              $estilo9="color: green !important;";

                             if(campos.indexOf("FechaEstudioConveniencia")=='-1')
                              $estilo10="";
                             else
                              $estilo10="color: green !important;";

                             if(campos.indexOf("FechaInicioProceso")=='-1')
                              $estilo11="";
                             else
                              $estilo11="color: green !important;";

                             if(campos.indexOf("FechaSuscripcionContrato")=='-1')
                              $estilo12="";
                             else
                              $estilo12="color: green !important;";

                             if(campos.indexOf("DuracionContrato")=='-1')
                              $estilo13="";
                             else
                              $estilo13="color: green !important;";

                             if(campos.indexOf("MetaPlan")=='-1')
                              $estilo14="";
                             else
                              $estilo14="color: green !important;";

                             if(campos.indexOf("RecursoHumano")=='-1')
                              $estilo15="";
                             else
                              $estilo15="color: green !important;";

                             if(campos.indexOf("NumeroContratista")=='-1')
                              $estilo16="";
                             else
                              $estilo16="color: green !important;";

                            if(campos.indexOf("DatosResponsable")=='-1')
                              $estilo17="";
                             else
                              $estilo17="color: green !important;";

                            if(campos.indexOf("Id_ProyectoRubro")=='-1')
                              $estilo18="";
                             else
                              $estilo18="color: green !important;";

                            tb2.row.add( [
                                  '<th scope="row" class="text-center">'+num1+'</th>',
                                  '<td><div style="'+$estilo+'">'+dato['Registro']+'</div></td>',
                                  '<td><div style="'+$estilo1+'">'+dato['CodigosU']+'</div></td>',
                                  '<td><div style="'+$estilo2+'">'+dato.modalidad['Nombre']+'</div></td>',
                                  '<td><div style="'+$estilo3+'">'+dato.tipocontrato['Nombre']+'</div></td>',
                                  '<td><div style="'+$estilo4+'">'+dato['ObjetoContractual']+'</div></td>',
                                  '<td><div style="'+$estilo6+'">'+dato['ValorEstimado']+'</div></td>',
                                  '<td><div style="'+$estilo13+'">'+dato['DuracionContrato']+'</div></td>',
                                  '<td><div style="'+$estilo5+'">'+dato['FuenteRecurso']+'</div></td>',
                                  '<td><div style="'+$estilo7+'">'+dato['ValorEstimadoVigencia']+'</div></td>',
                                  '<td><div style="'+$estilo8+'">'+dato['VigenciaFutura']+'</div></td>',
                                  '<td><div style="'+$estilo9+'">'+dato['EstadoVigenciaFutura']+'</div></td>',
                                  '<td><div style="'+$estilo10+'">'+dato['FechaEstudioConveniencia']+'</div></td>',
                                  '<td><div style="'+$estilo11+'">'+dato['FechaInicioProceso']+'</div></td>',
                                  '<td><div style="'+$estilo12+'">'+dato['FechaSuscripcionContrato']+'</div></td>',
                                  '<td><div style="'+$estilo14+'">'+dato['MetaPlan']+'</div></td>',
                                  '<td><div style="'+$estilo15+'">'+dato['RecursoHumano']+'</div></td>',
                                  '<td><div style="'+$estilo16+'">'+dato['NumeroContratista']+'</div></td>',
                                  '<td><div style="'+$estilo17+'">'+dato['DatosResponsable']+'</div></td>',
                                  '<td><div style="'+$estilo18+'">'+dato.rubro['Nombre']+'</div></td>'
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
                                  $ValorEstimado=dato['ValorEstimado'];
                                  $ValorEstimadoVigencia=dato['ValorEstimadoVigencia'];
                                  $VigenciaFutura=dato['VigenciaFutura'];
                                  $EstadoVigenciaFutura=dato['EstadoVigenciaFutura'];
                                  $FechaEstudioConveniencia=dato['FechaEstudioConveniencia'];
                                  $FechaInicioProceso=dato['FechaInicioProceso'];
                                  $FechaSuscripcionContrato=dato['FechaSuscripcionContrato'];
                                  $DuracionContrato=dato['DuracionContrato'];
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
                          '<td><h5>'+$ValorEstimado+'</h5></td>',
                          '<td><h5>'+$ValorEstimadoVigencia+'</h5></td>',
                          '<td><h5>'+$VigenciaFutura+'</h5></td>',
                          '<td><h5>'+$EstadoVigenciaFutura+'</h5></td>',
                          '<td><h5>'+$FechaEstudioConveniencia+'</h5></td>',
                          '<td><h5>'+$FechaInicioProceso+'</h5></td>',
                          '<td><h5>'+$FechaSuscripcionContrato+'</h5></td>',
                          '<td><h5>'+$DuracionContrato+'</h5></td>',
                          '<td><h5>'+$RecursoHumano+'</h5></td>',
                          '<td><h5>'+$NumeroContratista+'</h5></td>',
                          '<td><h5>'+$DatosResponsable+'</h5></td>',
                          '<td><h5>'+$Nombre_r+'</h5></td>'
                      ] ).draw( false );

                      $.each(data, function(i, dato){

                        if(dato['Estado']==1){ //Cambios aporbados
                             $(this).children('td').eq(0).css('background-color', 'red');
                             
                             if(dato['CodigosU']===$CodigosU)
                              $estilo="";
                             else
                              $estilo="color: red !important;";

                            if(dato.modalidad['Nombre']===$Nombre_m)
                              $estilo1="";
                             else
                              $estilo1="color: red !important;";

                            if(dato.tipocontrato['Nombre']===$Nombre_t)
                              $estilo2="";
                             else
                              $estilo2="color: red !important;";

                             if(dato['ObjetoContractual']===$ObjetoContractual)
                              $estilo3="";
                             else
                              $estilo3="color: red !important;";

                            if(dato['FuenteRecurso']===$FuenteRecurso)
                              $estilo4="";
                             else
                              $estilo4="color: red !important;";

                            if(dato['ValorEstimado']===$ValorEstimado)
                              $estilo5="";
                             else
                              $estilo5="color: red !important;";

                            if(dato['ValorEstimadoVigencia']===$ValorEstimadoVigencia)
                              $estilo6="";
                             else
                              $estilo6="color: red !important;";

                             if(dato['VigenciaFutura']===$VigenciaFutura)
                              $estilo7="";
                             else
                              $estilo7="color: red !important;";

                            if(dato['EstadoVigenciaFutura']===$EstadoVigenciaFutura)
                              $estilo8="";
                             else
                              $estilo8="color: red !important;";

                            if(dato['FechaEstudioConveniencia']===$FechaEstudioConveniencia)
                              $estilo9="";
                             else
                              $estilo9="color: red !important;";

                            if(dato['FechaInicioProceso']===$FechaInicioProceso)
                              $estilo10="";
                             else
                              $estilo10="color: red !important;";

                            if(dato['FechaSuscripcionContrato']===$FechaSuscripcionContrato)
                              $estilo11="";
                             else
                              $estilo11="color: red !important;";

                            if(dato['DuracionContrato']===$DuracionContrato)
                              $estilo12="";
                             else
                              $estilo12="color: red !important;";

                            if(dato['MetaPlan']===$MetaPlan)
                              $estilo13="";
                             else
                              $estilo13="color: red !important;";

                             if(dato['RecursoHumano']===$RecursoHumano)
                              $estilo14="";
                             else
                              $estilo14="color: red !important;";

                            if(dato['NumeroContratista']===$NumeroContratista)
                              $estilo15="";
                             else
                              $estilo15="color: red !important;";

                            if(dato['DatosResponsable']===$DatosResponsable)
                              $estilo16="";
                             else
                              $estilo16="color: red !important;";

                            if(dato.rubro['Nombre']===$Nombre_r)
                              $estilo17="";
                             else
                              $estilo17="color: red !important;";                            


                            tb5.row.add( [
                                  '<th scope="row" class="text-center">'+num1+'<input type="hidden" value="'+dato['Id']+'" name="Id[]"><input type="hidden" value="'+dato['Registro']+'" name="Registro[]"></th>',
                                  '<td style=""><div style="'+$estilo+'">'+dato['CodigosU']+'<br><input type="radio" value="'+dato['CodigosU']+'" name="CodigosU[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo1+'">'+dato.modalidad['Nombre']+'<br><input type="radio" value="'+dato.modalidad['Id']+'" name="Nombre_m[]" ><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo2+'">'+dato.tipocontrato['Nombre']+'<br><input type="radio" value="'+dato.tipocontrato['Id']+'" name="Nombre_t[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo3+'">'+dato['ObjetoContractual']+'<br><input type="radio" value="'+dato['ObjetoContractual']+'" name="ObjetoContractual[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo5+'">'+dato['ValorEstimado']+'<br><input type="radio" value="'+dato['ValorEstimado']+'" name="ValorEstimado[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo6+'">'+dato['ValorEstimadoVigencia']+'<br><input type="radio" value="'+dato['ValorEstimadoVigencia']+'" name="ValorEstimadoVigencia[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo7+'">'+dato['VigenciaFutura']+'<br><input type="radio" value="'+dato['VigenciaFutura']+'" name="VigenciaFutura[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo8+'">'+dato['EstadoVigenciaFutura']+'<br><input type="radio" value="'+dato['EstadoVigenciaFutura']+'" name="EstadoVigenciaFutura[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo9+'">'+dato['FechaEstudioConveniencia']+'<br><input type="radio" value="'+dato['FechaEstudioConveniencia']+'" name="FechaEstudioConveniencia[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo10+'">'+dato['FechaInicioProceso']+'<br><input type="radio" value="'+dato['FechaInicioProceso']+'" name="FechaInicioProceso[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo11+'">'+dato['FechaSuscripcionContrato']+'<br><input type="radio" value="'+dato['FechaSuscripcionContrato']+'" name="FechaSuscripcionContrato[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo12+'">'+dato['DuracionContrato']+'<br><input type="radio" value="'+dato['DuracionContrato']+'" name="DuracionContrato[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo14+'">'+dato['RecursoHumano']+'<br><input type="radio" value="'+dato['RecursoHumano']+'" name="RecursoHumano[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo15+'">'+dato['NumeroContratista']+'<br><input type="radio" value="'+dato['NumeroContratista']+'" name="NumeroContratista[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo16+'">'+dato['DatosResponsable']+'<br><input type="radio" value="'+dato['DatosResponsable']+'" name="DatosResponsable[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                                  '<td><div style="'+$estilo17+'">'+dato.rubro['Nombre']+'<br><input type="radio" value="'+dato.rubro['Id']+'" name="Nombre_r[]"><label for="radio1"><span><span></span></span></label>Selecionar</div></td>',
                              ] ).draw( false );
                          num1++;
                        }
                      });
                      
                      if(num1>1){
                        $('#id_aprobar').show();
                        $('#mensaje_NoCasos').hide();
                      }else{
                        $('#id_aprobar').hide();
                        $('#mensaje_NoCasos').html('No se encuentra cambios por aprobar.');
                        $('#mensaje_NoCasos').show();
                      }

                      $('#Modal_AprobarCambiosH').modal('show'); 
                  }
                      
                  
              },
              'json'
          );
           
     }); 

    $('#TablaPAA').delegate('button[data-funcion="AprobacionFinal"]','click',function (e)
    {
        var id = $(this).data('rel');
        var id2 = $(this).data('rol');
        $('.NumPaa').text(id);
        $('#paa_subDirecion').val(id);
        if(id2==1){
          $('#mensaje_aprobacion_final2').show();
          $('#aprobacion_Sub_Direccion').hide();
        }else{
          $('#mensaje_aprobacion_final2').hide();
          $('#aprobacion_Sub_Direccion').show();
        }

        $('#Modal_AprobarCambiosFinal').modal('show');
    }); 

    $('#aprobacion_Sub_Direccion').on('click', function(e){

          id=$('#paa_subDirecion').val();
          $.ajax({
              url: URL+'/service/aprobarSubDireccion/'+id,
              data: {},
              dataType: 'json',
              success: function(data)
              {   
                  t.clear().draw();
                  var num=1;
                  
                  $.each(data.datos, function(i, e){
                    var var2=0;
                    $.each(data.datos2, function(i, ee){
                        if(ee['Registro']==e['Registro']){
                              var2=1;
                        }
                    });

                    if(var2==1){
                      $btn_Cabmb='<div class="btn-group">'+
                              '<button type="button" data-rel='+e['Id']+' data-funcion="CabiosPendientes" class="btn btn-danger btn-xs2 btn-xs"  title="Cambios Pendientes" disabled><span class="glyphicon glyphicon-alert" aria-hidden="true"></span></button>'+
                          '</div>';
                    }else{
                      $btn_Cabmb='';
                    }

                      
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

                      var $tr1 = $('<tr  class="'+clase+'"></tr>').html(
                          '<th scope="row" class="text-center">'+num+'</th>'+
                          '<td><b><p class="text-info text-center">'+e['Registro']+'</p></b></td>'+
                          '<td><b>'+estado+'</b></td>'+
                          '<td>'+e['CodigosU']+'</td>'+
                          '<td>'+e.modalidad['Nombre']+'</td>'+
                          '<td>'+e.tipocontrato['Nombre']+'</td>'+
                          '<td><div style="width:500px;text-align: justify;">{'+e['ObjetoContractual']+'</div></td>'+
                          '<td>'+e['ValorEstimado']+'</td>'+
                          '<td>'+e.area['nombre']+'</td>'+
                          '<td>'+e['DuracionContrato']+'</td>'+
                          //'<td>'+e['FuenteRecurso']+'</td>'+
                          '<td>'+e['ValorEstimadoVigencia']+'</td>'+
                          '<td>'+e['VigenciaFutura']+'</td>'+
                          '<td>'+e['EstadoVigenciaFutura']+'</td>'+
                          '<td>'+e['FechaEstudioConveniencia']+'</td>'+
                          '<td>'+e['FechaInicioProceso']+'</td>'+
                          '<td>'+e['FechaSuscripcionContrato']+'</td>'+
                          //'<td>'+e['MetaPlan']+'</td>'+
                          '<td>'+e['RecursoHumano']+'</td>'+
                          '<td>'+e['NumeroContratista']+'</td>'+
                          '<td>'+e['DatosResponsable']+'</td>'+
                          '<td>'+e.rubro['Nombre']+'</td>'+
                          '<td>'+
                            '<div class="btn-group tama">'+
                              '<div class="btn-group">'+
                                '<button type="button" data-rel="'+e['Registro']+'" data-funcion="Historial" class="btn btn-primary btn-xs2 btn-xs" title="Historial"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>'+
                              '</div>'+
                              '<div class="btn-group">'+
                                '<button type="button" data-rel="'+e['Id']+'" data-funcion="Financiacion" class="btn btn-success btn-xs2 btn-xs" title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></button>'+
                              '</div>'+
                              '<div class="btn-group">'+
                                '<button type="button" data-rel="'+e['Id']+'" data-funcion="Aprobacion" class="btn btn-warning  btn-xs2 btn-xs" title="Aprobar Cambios" id="Btn_modal_Aprobacion"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></button>'+
                              '</div>'+
                              '<div class="btn-group">'+
                                '<button type="button" data-rel="'+e['Id']+'" data-rol="'+var2+'" data-funcion="AprobacionFinal" class="btn btn-default btn-xs2 btn-xs"  title="Aprobación Final" id="Btn_modal_Aprobacion" '+disable+'><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>'+
                              '</div>'+
                               $btn_Cabmb+
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

                  $('#mensaje_aprobacion_final').html('<strong>Registros de PAA!</strong> Los datos se registraron exitosamente a la sub dirección.');
                  $('#mensaje_aprobacion_final').show();
                  setTimeout(function(){
                     $('#mensaje_aprobacion_final').hide();
                      $('#Modal_AprobarCambiosFinal').modal('hide');
                  }, 6000)
              }
          });
          
          return false;
    }); 

    $('#form_aprobacion').on('submit', function(e){
  
  //  console.log($('input[name="registro"]').val()+' - '+$('input[name="DatosResponsable"]:checked').val());
    var id = new Array();
    $('input[name="Id[]"]').each(function(){
                id.push($(this).val());
    });

     var Registro = new Array();
    $('input[name="Registro[]"]').each(function(){
                Registro.push($(this).val());
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
      {id: id, Registro:Registro, CodigosU:CodigosU, Nombre_m:Nombre_m ,Nombre_t:Nombre_t, ObjetoContractual:ObjetoContractual, FuenteRecurso:0, ValorEstimado:ValorEstimado, ValorEstimadoVigencia:ValorEstimadoVigencia, VigenciaFutura:VigenciaFutura, EstadoVigenciaFutura:EstadoVigenciaFutura, FechaEstudioConveniencia:FechaEstudioConveniencia, FechaInicioProceso:FechaInicioProceso, FechaSuscripcionContrato:FechaSuscripcionContrato, DuracionContrato:DuracionContrato , MetaPlan:0, RecursoHumano:RecursoHumano, NumeroContratista:NumeroContratista ,  Nombre_r:Nombre_r, resposanble : responsble },
      function(data){

             var num=1;
                t.clear().draw();
                $.each(data.datos, function(i, e){
                    var var2=0;
                    $.each(data.datos2, function(i, ee){
                        if(ee['Registro']==e['Registro']){
                              var2=1;
                        }
                    });

                    if(var2==1){
                      $btn_Cabmb='<div class="btn-group">'+
                              '<button type="button" data-rel='+e['Id']+' data-funcion="CabiosPendientes" class="btn btn-danger btn-xs2 btn-xs"  title="Cambios Pendientes" disabled><span class="glyphicon glyphicon-alert" aria-hidden="true"></span></button>'+
                          '</div>';
                    }else{
                      $btn_Cabmb='';
                    }

                    

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

                      var $tr1 = $('<tr  class="'+clase+'"></tr>').html(
                          '<th scope="row" class="text-center">'+num+'</th>'+
                          '<td><b><p class="text-info text-center">'+e['Registro']+'</p></b></td>'+
                          '<td><b>'+estado+'</b></td>'+
                          '<td>'+e['CodigosU']+'</td>'+
                          '<td>'+e.modalidad['Nombre']+'</td>'+
                          '<td>'+e.tipocontrato['Nombre']+'</td>'+
                          '<td>'+e['ObjetoContractual']+'</td>'+
                          '<td>'+e['ValorEstimado']+'</td>'+
                          '<td>'+e.area['nombre']+'</td>'+
                          '<td>'+e['DuracionContrato']+'</td>'+
                          //'<td>'+e['FuenteRecurso']+'</td>'+
                          '<td>'+e['ValorEstimadoVigencia']+'</td>'+
                          '<td>'+e['VigenciaFutura']+'</td>'+
                          '<td>'+e['EstadoVigenciaFutura']+'</td>'+
                          '<td>'+e['FechaEstudioConveniencia']+'</td>'+
                          '<td>'+e['FechaInicioProceso']+'</td>'+
                          '<td>'+e['FechaSuscripcionContrato']+'</td>'+
                          //'<td>'+e['MetaPlan']+'</td>'+
                          '<td>'+e['RecursoHumano']+'</td>'+
                          '<td>'+e['NumeroContratista']+'</td>'+
                          '<td>'+e['DatosResponsable']+'</td>'+
                          '<td>'+e.rubro['Nombre']+'</td>'+
                          '<td>'+
                            '<div class="btn-group tama">'+
                              '<div class="btn-group">'+
                                '<button type="button" data-rel="'+e['Registro']+'" data-funcion="Historial" class="btn btn-primary btn-xs2 btn-xs" title="Historial"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></button>'+
                              '</div>'+
                              '<div class="btn-group">'+
                                '<button type="button" data-rel="'+e['Id']+'" data-funcion="Financiacion" class="btn btn-success btn-xs2 btn-xs" title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></button>'+
                              '</div>'+
                              '<div class="btn-group">'+
                                '<button type="button" data-rel="'+e['Id']+'" data-funcion="Aprobacion" class="btn btn-warning  btn-xs2 btn-xs" title="Aprobar Cambios" id="Btn_modal_Aprobacion"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></button>'+
                              '</div>'+
                              '<div class="btn-group">'+
                                '<button type="button" data-rel="'+e['Id']+'" data-rol="'+var2+'" data-funcion="AprobacionFinal" class="btn btn-default btn-xs2 btn-xs"  title="Aprobación Final" id="Btn_modal_Aprobacion" '+disable+'><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>'+
                              '</div>'+
                               $btn_Cabmb+
                            '</div>'+
                            '<div id=""></div>'+
                          '</td>'
                        );
                      t.row.add($tr1).draw( false );
                    

                      num++;
                });

              $('#mensaje_aprobacion').html('<strong>Registrossss de datos!</strong> Los datos se registraron exitosamente.');
              $('#mensaje_aprobacion').show();
              setTimeout(function(){
                 $('#mensaje_aprobacion').hide();
                  $('#Modal_AprobarCambiosH').modal('hide');
              }, 6000)
    },'json');

        e.preventDefault();
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
                      $('#Modal_HistorialEliminar').modal('show');
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

        $('#Modal_Observaciones').modal('show');
    }); 


    $('#regisgtrar_observacion').on('click', function(e){

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
