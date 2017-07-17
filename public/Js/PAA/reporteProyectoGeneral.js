$(function()
{
	var URL = $('#main_reporte').data('url');

  $('input[data-role1="datepicker"]').datepicker({
      dateFormat: 'yy-mm-dd',
      yearRange: "-100:+0",
      changeMonth: true,
      changeYear: true,
    });

  $('input[data-role="datepicker"]').datepicker({
      dateFormat: 'yy-mm-dd',
      yearRange: "-100:+0",
      changeMonth: true,
      changeYear: true,
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


  $('#form_reporte_general').on('submit', function(e){
          
          $.post(
            URL+'/validar_form',
            $(this).serialize(),
            function(data){

              console.log(data);
              if(data.status == 'error')
                {
                    validad_error(data.errors);
                } 
              else 
                {
                  validad_error(data.errors);
                  $("#contenido_reporte2").html("<img src='public/Img/loading.gif'/>");
                  
                  // DataTable
                  $('#contenido_reporte2').html(data.tabla);
                  $('#Tabla_Reporte2 tfoot th').each( function () {
                      var title = $(this).text();
                      if(title!="Menu" && title!="N°"){
                        $(this).html( '<input type="text" placeholder="Buscar"/>' );
                      }
                  } );
               
                  
                  var t = $('#Tabla_Reporte2').DataTable( {responsive: true,
                      dom: 'Bfrtip',
                      buttons: [
                          'copy', 'csv', 'excel', 'pdf'],
                      pageLength: 5,
                      "footerCallback": function ( row, data, start, end, display ) {
                          var api = this.api(), data;
               
                          // Remove the formatting to get integer data for summation
                          var intVal = function ( i ) {
                              return typeof i === 'string' ?
                                  i.replace(/[\$,]/g, '')*1 :
                                  typeof i === 'number' ?
                                      i : 0;
                          };
               
                          // Total over all pages
                          total = api
                              .column( 2 )
                              .data()
                              .reduce( function (a, b) {
                                  return intVal(a) + intVal(b);
                              }, 0 );
               
                          // Total over this page
                          pageTotal = api
                              .column( 2, { page: 'current'} )
                              .data()
                              .reduce( function (a, b) {
                                  return intVal(a) + intVal(b);
                              }, 0 );
               
                          // Update footer
                          $( api.column( 2 ).footer() ).html(
                              'P: $'+number_format(pageTotal) +'<br>T: $'+ number_format(total) +''
                          );
                      }
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
                  
                     
                }
            },'json');
          
      e.preventDefault();
  });


  var validad_error = function(data)
    {
        $('#form_reporte_general .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    
                    case 'fecha_inicial':
                    case 'fecha_final':
                        selector = 'input';
                    break;

                    case 'planDesarrollo':
                    selector = 'select';
                    break;
                
                }
                $('#form_reporte_general '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }
    // Build the chart


});


