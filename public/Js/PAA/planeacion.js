$(function()
{
	var rows_selected = [];
	var URL = $('#main').data('url');

	$('#TablaPAA tfoot th').each( function () {
      var title = $(this).text();
      if(title!="Menu" && title!="N°"){
        $(this).html( '<input type="text" placeholder="Buscar" />' );
      }
  } );

  // DataTable
  var table = $('#TablaPAA').DataTable({
    responsive: true,
    columnDefs: [
    		{
        	targets: 22,
          searchable: false,
          orderable: false
      	}
      ],
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'pdf']
  });

  // Apply the search
  table.columns().every( function () {
      var that = this;
      $( 'input', this.footer() ).on( 'keyup change', function () {
          if ( that.search() !== this.value ) {
              that
                  .search( this.value )
                  .draw();
          }
      } );
  });

	var tb1 = $('#Tabla1').DataTable({
		responsive: true
	});

	var tb2 = $('#Tabla2').DataTable({
		responsive: true
	});

	var tb3 = $('#Tabla3').DataTable({
		responsive: true
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

	$('#TablaPAA').delegate('button[data-funcion="Financiacion"]','click',function (e){   
          var id = $(this).data('rel'); 
          $.ajax({
              url: URL+'/service/VerFinanciamiento/'+id,
              data: {},
              dataType: 'json',
              success: function(data)
              {   
                  var html = '';
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
          }).done(function(){
          	$('#Modal_Financiacion').modal('show'); 
          });
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


    $('#TablaPAA').delegate('button[data-funcion="estudioConveniencia"]','click',function (e){   
          var id = $(this).data('rel'); 
          $('#id_paa_estudio_f').val(id);
          $('#estudiopdf_form').submit();
   }); 


});