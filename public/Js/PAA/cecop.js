$(function()
{
	var rows_selected = [];
	var URL = $('#main').data('url');

	$('#TablaHCecop tfoot th').each( function () {
      var title = $(this).text();
      if(title!="Menu" && title!="N°"){
        $(this).html( '<input type="text" placeholder="Buscar" />' );
      }
  } );

  // DataTable
  var table = $('#TablaHCecop').DataTable({
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

   

    $('#regisgtrar_observacion').on('click', function(e){

         id=$('#paa_registro').val();
         observacion=$('#observacio').val();
         $.post(
          URL+'/service/RegistrarObservacion',
          {id: id, Estado:'Observación Dirección',observacion:observacion},
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