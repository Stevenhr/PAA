$(function()
{
  var URL = $('#main_paa_').data('url');
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
                    if(data.proyecto!=null && data.proyecto.fuente.length > 0)
                    {
                      $.each(data.proyecto.fuente, function(i, e){
                          html += '<option value="'+e.pivot['id']+'">'+e['nombre']+'</option>';
                      });
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
                              '<td class="text-center"><button type="button" data-id="'+dato['id']+'"  data-rel="'+id_act+'" data-funcion="eliminar_finanza" class="eliminar_dato_actividad" style="display:'+desactivo+'""><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                      num++;
                    });

                    var html1 ='<option value="1">Seleccionar</option>';
                    $('select[name="componnente"]').html(html1);
console.log(html);
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
                              '<td>'+e.pivot['valor']+'</td>'+
                              '<td class="text-center"><button type="button" data-id="'+e.pivot['rubro_id']+'"  data-rel="'+id_act+'" data-funcion="eliminar_finanza_rubro" class="eliminar_dato_actividad" style="display:'+desactivo+'""><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                      num++;
                    });
                    $('#registrosFinanzasRubro').html(html);
                            
                    $('.mjs_componente').hide();
                }

              }
          });
     }); 

});