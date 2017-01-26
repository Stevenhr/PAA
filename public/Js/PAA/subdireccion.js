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
          targets: 20,
          searchable: false,
          orderable: false
        },{
          targets: 21,
          searchable: false,
          orderable: false,
          width: '1%',
          className: 'dt-body-center',
          render: function (data, type, row) 
    			{
            var disabled = false;
            switch(row[3])
            {
              case 'En consolidación':
              case 'En subdirección':
                break;
              case 'Aprobado por subdirección':
              case 'Denegado por subdirección':
              case 'Cancelado por subdirección':
                disabled = true;
                break;
            }

    				return '<input type="checkbox" class="default" '+(disabled ? 'disabled' : '')+'>';
    			}
        }
      ],
      rowCallback: function(row, data, dataIndex)
      {
        var rowId = data[1];
        
        if($.inArray(rowId, rows_selected) !== -1)
        {
          $(row).find('input[type="checkbox"]').prop('checked', true);
          $(row).addClass('selected');
        }
      },
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

	$('#TablaPAA tbody').on('click', 'input[type="checkbox"]', function(e)
	{
		var $row = $(this).closest('tr');

		// Get row data
		var data = table.row($row).data();

		// Get row ID
		var rowId = $row.data('row');

		// Determine whether row ID is in the list of selected row IDs 
		var index = $.inArray(rowId, rows_selected);

		// If checkbox is checked and row ID is not in list of selected row IDs
		if(this.checked && index === -1)
		{
			rows_selected.push(rowId);
		// Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
		} else if (!this.checked && index !== -1) {
			rows_selected.splice(index, 1);
		}

		if(this.checked)
		{
			$row.addClass('selected');
		} else {
			$row.removeClass('selected');
		}

		// Prevent click event from propagating to parent
		e.stopPropagation();
	});

	$('#rechazar_paa, #cancelar_paa').on('submit', function(e)
	{
		var $form = $(this);
		var accion = $form.attr('id');
		var id = $form.find('input[name="Id"]').val();
		var observaciones = $.trim($form.find('textarea[name="Observaciones"]').val());
		if(observaciones.length)
		{
			$.post(
				$(this).attr('action'),
				$(this).serialize(),
				function(e)
				{
					if(e)
					{
						var $tr = $('#TablaPAA').find('tr[data-row="'+id+'"]');

						if(accion == "rechazar_paa")
            {
							$tr.addClass('warning');
              $tr.find('td.estado').html('Denegado por subdirección');
            }
						else
            {
							$tr.addClass('danger');
              $tr.find('td.estado').html('Cancelado por subdirección');
            }

						$tr.find('input[type="checkbox"]').prop('checked', false);
						$tr.find('button[data-funcion="rechazar"], button[data-funcion="cancelar"], input[type="checkbox"]').prop('disabled', true);
						var temp = $.grep(rows_selected, function(n, i)
						{
							return n != id;
						});
						rows_selected = temp;
					}
				},
				'json'
			).done(function(){
				$form.closest('.modal').modal('hide');
			});
		} else {
			$form.find('textarea[name="Observaciones"]').closest('.form-group').addClass('has-error');
		}

		e.preventDefault();
	});

	$('#envia_paa').on('submit', function(e)
	{
		if (rows_selected.length > 0)
		{
			$('#envia_paa input[name="paas"]').val(rows_selected.join());
			$.post(
				$(this).attr('action'),
				$(this).serialize(),
				function(e){
					if(e)
					{
						$('#alertas .bg-success').fadeIn();
					}
				}
			).done(function(){
        $.each(rows_selected, function(i, e)
        {
          table.tables().nodes().rows().every(function(rowIdx, tableLoop, rowLoop)
          {
            var $node = $(this.node());
            var rowId = $node.data('row');
            if(rowId == e){
              $node.addClass('success');
              $node.find('input[type="checkbox"]').attr('checked', false);
              $node.find('td.estado').html('Aprobado por subdirección');
              $node.find('button[data-funcion="Rechazar"], button[data-funcion="cancelar"], input[type="checkbox"]').attr('disabled', true);
            }
          });
        });

				rows_selected = [];
			});
		} else {
			$('#alertas .bg-danger').fadeIn();
		}

		setTimeout(function(){
			$('#alertas p').fadeOut();
		}, 5000);

		e.preventDefault();
	});

	$('#TablaPAA').delegate('button[data-funcion="rechazar"], button[data-funcion="cancelar"]', 'click', function (e)
	{
		var form = $(this).data('funcion');
		var id = $(this).data('rel');
		$('#'+form+'_paa input[name="Id"]').val(id);
		$('#'+form+'_paa textarea[name="Observaciones"]').val('');
		$('#'+form+'_paa textarea[name="Observaciones"]').closest('.form-group').removeClass('has-error');

		$('#modal_'+form).modal('show');
	});

	$('thead input[name="select_all"]').on('click', function(e)
  {
    var _this = $(this);
    rows_selected = [];
    table.tables().nodes().rows().every(function(rowIdx, tableLoop, rowLoop)
    {
      var $node = $(this.node());
      var rowId = $node.data('row');
      var checked = $node.find('input[type="checkbox"]').is(':checked');
      var disabled = $node.find('input[type="checkbox"]').is(':disabled');

      if(_this.is(':checked'))
      {
        if(!checked && !disabled)
        { 
          $node.find('input[type="checkbox"]').prop('checked', true);
          $node.addClass('selected');
        }

        rows_selected.push(rowId);
      } else {
        if(checked && !disabled)
        {
          $node.find('input[type="checkbox"]').prop('checked', false);
          $node.removeClass('selected');
        }
      }
    });

		e.stopPropagation();
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
          }).done(function(){
          	$('#Modal_Financiacion').modal('show'); 
          });
    }); 

	$('#TablaPAA').delegate('a[data-funcion="Observaciones"]','click',function (e)
    {
        var id = $(this).data('rel');
        $('.NumPaa').text(id);

        $.ajax({
              url: URL+'/service/historialObservaciones/'+id,
              data: {},
              dataType: 'json',
              success: function(data)
              {   
                  var html = '';
                  $.each(data, function(i, dato){
                    var num=1;
                    html += '<tr>'+
                            '<th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+dato['id_persona']+'</td>'+
                            '<td>'+dato['observacion']+'</td>'+
                            '<td>'+dato['estado']+'</td>';
                    num++;
                  });
                  $('#registrosObser').html(html);
              }
          });

        $('#Modal_Observaciones').modal('show');
    });
});