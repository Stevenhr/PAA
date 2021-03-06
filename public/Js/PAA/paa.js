$(function()
{
  
  var URL = $('#main_paa_').data('url');
  vector_datos_actividad = new Array();
    vector_datos_actividad_rubro_f = new Array();
  vector_datos_codigos = new Array();
  vector_datos_financiacion = new Array();
  var valorAfavor=0;
  var valor_ingresado_conso=0;

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
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 8, { filter: 'applied' } )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
                'P: $'+number_format(pageTotal) +'<br>T: $'+ number_format(total) +''
            );


            // Total over all pages
            total2 = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal2 = api
                .column( 9, { filter: 'applied' } )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 9 ).footer() ).html(
                'P: $'+number_format(pageTotal2) +'<br>T: $'+ number_format(total2) +''
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

    function replaceAll( text, busca, reemplaza ){
       while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca,reemplaza);
      
      return text;
    }




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

      function formatCurrency(input)
    {
        var num = input.value.replace(/\./g,'');
        if(!isNaN(num)){
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
        }
          
        else{ alert('Solo se permiten numeros');
            input.value = input.value.replace(/[^\d\.]*/g,'');
        }
    }

    $('input[name="valor_contrato"]').on('keyup', function(e){
        formatCurrency(this);
    });

    $('input[name="valor_contrato_rubro"]').on('keyup', function(e){
        formatCurrency(this);
    });


  var tb1 = $('#Tabla1').DataTable( {responsive: true   } );
  var tb2 = $('#Tabla2').DataTable( {responsive: true,  } );
  var tb3 = $('#Tabla3').DataTable( {responsive: true,  } );


    $('#Tabla4 tfoot th').each( function () {
        var title = $(this).text();
        if(title!="Menu" && title!="N°"){
          $(this).html( '<input type="text" placeholder="Buscar"/>' );
        }
    } );
 
    // DataTable
    var tb4 = $('#Tabla4').DataTable( {responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'],
        pageLength: 5
    });
 
    tb4.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    });

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
      changeMonth: true,
      changeYear: true,
      minDate: 0 ,
    });

  $('input[data-role1="datepicker"]').datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      minDate: 0 ,
    });

   function formatCurrency(input)
    {
        var num = input.value.replace(/\./g,'');
        if(!isNaN(num)){
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
        }
          
        else{ 
            input.value = input.value.replace(/[^\d\.]*/g,'');
        }
    }
 $('input[name="valor_estimado"]').on('keyup', function(e){
        formatCurrency(this);
 });
 $('input[name="valor_estimado_actualVigencia"]').on('keyup', function(e){
        formatCurrency(this);
 });


 $('#form_paa').on('submit', function(e){

    var datos_acti = JSON.stringify(vector_datos_actividad);
    $('input[name="Dato_Actividad"]').val(datos_acti);
    var upd=$('input[name="id_Paa"]').val();
    var ProyectOrubro=$('input[name="ProyectOrubro"]').val();

    var datos_cod = JSON.stringify(vector_datos_codigos);
    $('input[name="Dato_Actividad_Codigos"]').val(datos_cod);

     var datos_act_rubro = JSON.stringify(vector_datos_actividad_rubro_f);
     $('input[name="Dato_Actividad_Acti_rubro"]').val(datos_act_rubro);
    
    if(vector_datos_actividad.length > 0 || vector_datos_actividad_rubro_f.length>0){

          if(ProyectOrubro==2){
             vector_datos_actividad.length=0;
          }

              $('#mjs_registroPaa').html(' <center><strong>Cargando... Espere un momento!</strong>  Registrando plan...</center>');
              $('#mjs_registroPaa').show();

              $('#ProyectOrubro').prop("disabled",false);
              $('#Proyecto_inversion').prop("disabled",false);
              $('#meta').prop("disabled",false);  

          /*var duracion=$('input[name="duracion_estimada"]').val();
          var duracion_estimada =duracion.split(",",3);
           if(isNaN(duracion_estimada[0]) || isNaN(duracion_estimada[1]) || isNaN(duracion_estimada[2]))
           {
            $('input[name="duracion_estimada"]').val("");
           }*/

           if($('#ProyectOrubro').val()==2)
           {
            $('#meta').val("1");
           }
             
          $('#crear_paa_btn').html('Esperé un momento...');                 
          $('#crear_paa_btn').attr('disabled',true);

          $.post(
            URL+'/validar/paa',
            $(this).serialize(),
            function(data){
              if(data.status == 'error')
              {
                  validad_error(data.errors);
                  var mej="Campos vacios.";

                  $('#crear_paa_btn').html('CREAR');                 
                  $('#crear_paa_btn').attr('disabled',false);

                  $('#mjs_registroPaa').hide();
                  $('#mjs_registroPaa2').html('<center><strong>Error!</strong> '+mej+'</center>');
                  $('#mjs_registroPaa2').show();
                  setTimeout(function(){
                      $('#mjs_registroPaa2').hide();
                      $('#crear_paa_btn').prop('disabled',false);
                  }, 6000)
             
              } 
              else 
              {

                validad_error(data.errors);

                if(data.status == 'modelo')
                {
                    document.getElementById("form_paa").reset(); 
                    
                    vector_datos_actividad=[];
                    $('#registros').html('');               
                    var num=1;
                    t.clear().draw();
                    $.each(data.datos, function(i, e){

                        var $tr1 = tabla_opciones(e,num);    
                        t.row.add($tr1).draw( false );
                        num++;

                    });

                    if(upd==0)
                    {
                      $('#mjs_registroPaa').html(' <strong>Registro Exitoso!</strong> Se realizo el resgistro de su PAA.');
                      $('#mjs_registroPaa').show();
                      setTimeout(function(){
                          $('#crear_paa_btn').html("CREAR");
                          $('#crear_paa_btn').prop('disabled',false);
                          $('#mjs_registroPaa').hide();
                          $('#Modal_AgregarNuevo').modal('hide');
                          window.location.reload(true);
                      }, 3000)
                      
                    }
                    else
                    {
                      $('#mjs_registroPaa').html(' <strong>Se Registro la Modificación!</strong> Entra en cola de espera para la aprobación de los cambios.');
                      $('#mjs_registroPaa').show();
                      setTimeout(function(){
                          $('#crear_paa_btn').html("CREAR");
                          $('#crear_paa_btn').prop('disabled',false);
                          $('#mjs_registroPaa').hide();
                          $('#Modal_AgregarNuevo').modal('hide');
                          window.location.reload(true);
                      }, 3000) 
                    }
                }else{
                    $('#mensaje_presupuesto2').html('<strong>Error!</strong> el valor del presupuesto que intenta modificar es menor a la suma de los proyectos: $'+data.sum_proyectos);
                    $('#mensaje_presupuesto2').show();
                    setTimeout(function(){
                        $('#crear_paa_btn').html("CREAR");
                        $('#crear_paa_btn').prop('disabled',false);
                        $('#mensaje_presupuesto2').hide();
                    }, 6000)
                }
                
            }
            
          },'json');
          
    }else{
       
            $('#alert_actividad_paa').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> No se ha registrado ninguna fuente de financiación.</div>');
            $('#mensaje_actividad_paa').show();
            setTimeout(function(){
                $('#mensaje_actividad_paa').hide();
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
                    case 'numero_contratista':
                    case 'datos_contacto':
                        selector = 'input';
                    break;

                    case 'recurso_humano':
                    case 'modalidad_seleccion':
                    case 'tipo_contrato':
                    case 'vigencias_futuras':
                    case 'estado_solicitud':
                    case 'Proyecto_inversion':
                    case 'meta':
                    case 'ProyectOrubro':
                    case 'unidad_tiempo':
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

    $('select[name="recurso_humano"]').on('change', function(e){
        if($(this).val()=='No')
            $('#numero_contratista').val(0);
        else
            $('#numero_contratista').val('');
    });

    $('select[name="ProyectOrubro"]').on('change', function(e){
        select_ProyectOrubro($(this).val());
    });


    var select_ProyectOrubro = function(id)
    { 
        $.ajax({
            url: URL+'/service/select_ProyectOrubro/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                if(id==1)
                { //Proyecto
                  var html = '<option value="">Seleccionar Proyecto</option>';
                  $.each(data, function(i, eee){
                        html += '<option value="'+eee['Id']+'">'+eee['codigo']+" - "+eee['Nombre'].toLowerCase()+'</option>';
                  });   
                  $('select[name="Proyecto_inversion"]').html(html).val($('select[name="Proyecto_inversion"]').data('value'));
                  $('.hide_meta').show();
                  $('#Proyecto_inversion').show();
                  $('#paso_1').html("<h5 class='text-success'>1. Proyecto</h4>");
                  $('#agregarRubro').hide();
                  $('#VerAgregarRubro_f').hide();
                  $("#pro_rub").html("<h4 class='text-success'>PROCESO PROYECTO DE INVERSIÓN.</h4>");
                  $('#meta0').prop( "disabled", true);
                  $('#div_finaciacion').show();
                  $('.valor').hide();
                  //vector_datos_actividad.length=0;
                }

                if(id==2)
                { //Rubro 

                  var html = '<option value="">Seleccionar Rubro</option>';
                  $.each(data, function(i, eee){
                        html += '<option value="'+eee['id']+'">'+eee['nombre'].toLowerCase()+'</option>';
                  });   
                  $('select[name="Proyecto_inversion"]').html(html).val($('select[name="Proyecto_inversion"]').data('value'));
                  $('.hide_meta').hide();
                  $('#Proyecto_inversion').show();
                  $('#paso_1').html("<h5 class='text-warning'>1. Rubro</h5>");
                  $('#agregarRubro').show();
                  $('.valor').show();

                  $("#pro_rub").html("<h4 class='text-warning'>PROCESO RUBRO DE FUNCIONAMIENTO.</h4>");
                  $('#meta0').prop( "disabled", false);
                  $('#div_finaciacion').hide();
                }
            }
        });
    };

    $('select[name="Proyecto_inversion"]').on('change', function(e){
        select_Meta($(this).val());
    });

    var select_Meta = function(id)
    { 

      if($('select[name="ProyectOrubro"]').val()!=2){
        $.ajax({
            url: URL+'/service/select_meta_fuente/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var datos=data.Proyecto;
                var html = '<option value="">Seleccionar</option>';
                $.each(datos.metas, function(i, eee){
                      html += '<option value="'+eee['Id']+'">'+eee['Nombre'].toLowerCase()+'</option>';
                });   
                $('select[name="meta"]').html(html).val($('select[name="meta"]').data('value'));

                var datos2=data.FuenteProyecto;
                var html2 = '<option value="">Seleccionar</option>';
                $.each(datos2, function(i, eee){
                      html2 += '<option value="'+eee['id']+'">'+eee.fuente['codigo']+' - '+eee.fuente['nombre'].toLowerCase()+'</option>';
                });   
                $('select[name="Fuente_inversion"]').html(html2).val($('select[name="Fuente_inversion"]').data('value'));
            }
        });
      }
    };


     $('select[name="Proyecto_Finanza"]').on('change', function(e){
        select_Meta_Fin($(this).val());
    });

    var select_Meta_Fin = function(id)
    { 
        var html = '<option value="">Cargando...</option>';
        $('select[name="Meta_Finanza"]').html(html);
        var html = '<option value="">Seleccionar</option>';
        $('select[name="Componnente_Finanza"]').html(html)
        $.ajax({
            url: URL+'/service/select_meta_fuente/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var datos=data.Proyecto;
                html = '<option value="">Seleccionar</option>';
                $.each(datos.metas, function(i, eee){
                      html += '<option value="'+eee['Id']+'">'+eee['Nombre'].toLowerCase()+'</option>';
                });   
                $('select[name="Meta_Finanza"]').html(html).val($('select[name="Meta_Finanza"]').data('value'));

                var datos2=data.FuenteProyecto;
                var html2 = '<option value="">Seleccionar</option>';
                $.each(datos2, function(i, eee){
                      html2 += '<option value="'+eee['id']+'">'+eee.fuente['codigo']+' - '+eee.fuente['nombre'].toLowerCase()+'</option>';
                });   
                $('select[name="Fuente_Finanza"]').html(html2).val($('select[name="Fuente_Finanza"]').data('value'));
            }
        });
    };

    var select_Meta2 = function(id,id_meta)
    { 
        $.ajax({
            url: URL+'/service/select_meta/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                
                var html = '';
                $.each(data.proyecto, function(i, e){
                    if(e['Id']!=id){
                      html += '<option value="'+e['Id']+'">'+e['Nombre'].toLowerCase()+'</option>';
                    }else{
                      html += '<option value="'+e['Id']+'" selected="selected">'+e['Nombre'].toLowerCase()+'</option>';
                    }
                });   
                html +='<option value="">Seleccionar</option>';
                $('select[name="Proyecto_inversion"]').html(html);
                $('#Proyecto_inversion').prop("disabled",true);

                var html = '';
                $.each(data.proyectometas.metas, function(i, eee){
                    if(eee['Id']!=id_meta){
                      html += '<option value="'+eee['Id']+'">'+eee['Nombre'].toLowerCase()+'</option>';
                    }else{
                      html += '<option value="'+eee['Id']+'" selected="selected">'+eee['Nombre'].toLowerCase()+'</option>';
                    }
                });   
                html +='<option value="">Seleccionar</option>';
                $('select[name="meta"]').html(html);
                $('#meta').prop("disabled",true);
            }
        });
    };

    var select_Rubro = function(id)
    { 
        $.ajax({
            url: URL+'/service/select_rubro/'+id,
            data: {},
            dataType: 'json',
            success: function(e)
            {
                var html = '';
                html += '<option value="'+e['id']+'" selected="selected">'+e['nombre'].toLowerCase()+'</option>';
                $('select[name="Proyecto_inversion"]').html(html);
                $('#Proyecto_inversion').prop("disabled",true);

                var html1 ='<option value="1">N.A</option>';
                $('select[name="meta"]').html(html1);
                $('#meta').prop("disabled",true);
            }
        });
    };

    $('select[name="Fuente_inversion"]').on('change', function(e){
        select_fuente($(this).val());
    });

    var select_fuente = function(fuenteProyecto)
    { 
        $('.mjs_componente').html('');
        $.post(
          URL+'/service/fuenteComponente',
          {fuenteProyecto:fuenteProyecto},
          function(data)
          {
                var html = '<option value="">Seleccionar componente</option>';
                $.each(data, function(i, eee){
                            html += '<option value="'+eee['id']+'">'+eee.componente['codigo']+' - '+eee.componente['Nombre'].toLowerCase()+'</option>';
                });
                
                $('select[name="componnente"]').html(html).val($('select[name="componnente"]').data('value'));
          },'json');
    };


    $('select[name="Fuente_Finanza"]').on('change', function(e){
        select_fuente_finan($(this).val());
    });

    var select_fuente_finan = function(fuenteProyecto)
    { 
        $('.mjs_componente').html('');
        var html = '<option value="">Cargando....</option>';
        $('select[name="Componnente_Finanza"]').html(html);
        $.post(
          URL+'/service/fuenteComponente',
          {fuenteProyecto:fuenteProyecto},
          function(data)
          {
                html = '<option value="">Seleccionar componente</option>';
                $.each(data, function(i, eee){
                            html += '<option value="'+eee['id']+'">'+eee.componente['Nombre'].toLowerCase()+'</option>';
                });
                
                $('select[name="Componnente_Finanza"]').html(html).val($('select[name="Componnente_Finanza"]').data('value'));
          },'json');
    };

    $('select[name="Componnente_Finanza"]').on('change', function(e){
        var id_presupuestado=$(this).find(':selected').val();
        presupuesto_vista(id_presupuestado);
      
        
    });

    $('select[name="componnente"]').on('change', function(e){
        var id_presupuestado=$(this).find(':selected').val();
        presupuesto_vista(id_presupuestado);

    });

    function presupuesto_vista(id_presupuestado){

      $.ajax({
            type: "POST",
            url: URL+'/service/PresupuestoComponente',
            data: {id_presupuestado:id_presupuestado},
            dataType: 'json',
            success: function(data)
            {
                var valorCocenpto=0;
                var suma=0;
                var suma2=0;
                
                // valor de la suma de los paa con estudio aprobado.
                $.each(data.ModeloPa, function(i, eee){
                  if(eee.componentes!=''){
                    $.each(eee.componentes, function(ii, eeee){
                       if(eeee.pivot['valor']!='')
                       suma=suma + parseInt(eeee.pivot['valor']);
                    });
                  }
                });
               

                //valor de la suma de los paa pendientes
                console.log(data.ModeloPaPendi);
                $.each(data.ModeloPaPendi, function(i, eee){
                  if(eee.componentes!=''){
                    $.each(eee.componentes, function(ii, eeee){
                       if(eeee.pivot['valor']!='') {
                           suma2 = suma2 + parseInt(eeee.pivot['valor']);
                           //console.log(eeee.pivot['id_paa']);
                       }
                    });
                  }
                });

                /*$.each(data.ModeloPaPendi, function(i, eee){
                    if(eee.componentes!=''){
                        $.each(eee.componentes, function(ii, eeee){
                            if(eeee.pivot['valor']!='')
                                suma2=suma2 + parseInt(eeee.pivot['valor']);
                            if(eeee.pivot['valor']!='') {
                                suma2 = suma2 + parseInt(eeee.pivot['valor']);
                                console.log(eeee.pivot['id_paa']);
                            }
                        });
                    }
                });*/


                valorCocenpto=data.presupuestado['valor'];
                valorAfavor=parseInt(valorCocenpto)-parseInt(suma)-parseInt(suma2);
        
               // console.log(valorAfavor+" - "+valorCocenpto+" - "+suma);
                valor_ingresado_conso=0;
                if(vector_datos_actividad.length > 0)
                {
                  $.each(vector_datos_actividad, function(i, e){
                    //if(e['id_componente']==texto){
                      valor_ingresado_conso=parseInt(valor_ingresado_conso)+parseInt(e['valor']);
                    //}
                  });
                }
                
                $('.mjs_componente').html('<div class="alert "><table class="table table-bordered">'+
                 '<tr class="info"><td>Presupuesto total:</td><td><center><strong>  $'+number_format(valorCocenpto)+'</strong>.<br></td></tr>'+
                 '<tr class="success"><td>Aprobado por el ordenador del gasto:</td><td><center><strong>                 $'+number_format(suma)+'</strong>.<br></td></tr>'+
                 '<tr class="warning"><td>En aprobación por el ordenador del gasto:</td><td><center><strong>                 $'+number_format(suma2)+'</strong>.<br></td></tr>'+
                 '<tr class="active"><td>Recursos por cargar al PAA: </td><td><center><strong>  $'+number_format(valorAfavor)+'</strong>.<br>'+'</td></tr></table></div>');
            }
        });

    }

  function lee_json(codigo_Unspsc) {
    var promise = $.Deferred();
    var res = codigo_Unspsc.substring(0,1);
    var i=0;
    
      if(res=='1')
      {
        $.getJSON("public/Js/unspsc_10.json", function(datos) {
            $.each(datos["UNSPSC"], function(idx,primo)
            {
                if(codigo_Unspsc==primo["Codigo"]){
                    i=primo;
                }
            });
            promise.resolve(i);
        });
      }

      if(res=='2')
      {
        $.getJSON("public/Js/unspsc_20.json", function(datos) {
            $.each(datos["UNSPSC"], function(idx,primo)
            {
                if(codigo_Unspsc==primo["Codigo"]){
                    i=primo;
                }
            });
            promise.resolve(i);
        });
      }

      if(res=='3')
      {
        $.getJSON("public/Js/unspsc_30.json", function(datos) {
            $.each(datos["UNSPSC"], function(idx,primo)
            {
                if(codigo_Unspsc==primo["Codigo"]){
                    i=primo;
                }
            });
            promise.resolve(i);
        });
      }

      if(res=='4')
      {
        $.getJSON("public/Js/unspsc_40.json", function(datos) {
            $.each(datos["UNSPSC"], function(idx,primo)
            {
                if(codigo_Unspsc==primo["Codigo"]){
                    i=primo;
                }
            });
            promise.resolve(i);
        });
      }

      if(res=='5')
      {
        $.getJSON("public/Js/unspsc_50.json", function(datos) {
            $.each(datos["UNSPSC"], function(idx,primo)
            {
                if(codigo_Unspsc==primo["Codigo"]){
                    i=primo;
                }
            });
            promise.resolve(i);
        });
      }

      if(res=='6')
      {
        $.getJSON("public/Js/unspsc_60.json", function(datos) {
            $.each(datos["UNSPSC"], function(idx,primo)
            {
                if(codigo_Unspsc==primo["Codigo"]){
                    i=primo;
                }
            });
            promise.resolve(i);
        });
      }

      if(res=='7')
      {
        $.getJSON("public/Js/unspsc_70.json", function(datos) {
            $.each(datos["UNSPSC"], function(idx,primo)
            {
                if(codigo_Unspsc==primo["Codigo"]){
                    i=primo;
                }
            });
            promise.resolve(i);
        });
      }

      if(res=='8')
      {
        $.getJSON("public/Js/unspsc_80.json", function(datos) {
            $.each(datos["UNSPSC"], function(idx,primo)
            {
                if(codigo_Unspsc==primo["Codigo"]){
                    i=primo;
                }
            });
            promise.resolve(i);
        });
      }

      if(res=='9')
      {
        $.getJSON("public/Js/unspsc_90.json", function(datos) {
            $.each(datos["UNSPSC"], function(idx,primo)
            {
                if(codigo_Unspsc==primo["Codigo"]){
                    i=primo;
                }
            });
            promise.resolve(i);
        });
      }
    
    return promise.promise();
 }


  
  $('#agregarCodigos').on('click', function(e)
  {
      $('#t_datos_actividad_codigo').hide();
      var codigo_Unspsc=$('input[name="codigo_Unspsc"]').val();
      $('input[name="codigo_Unspsc"]').val("");
      if(codigo_Unspsc===''){
          $('#alert_actividad_codigos').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Debe ingresar un código Unspsc para poder realizar el registro.</div>');
          $('#mensaje_actividad_codigos').show(60);
          $('#mensaje_actividad_codigos').delay(2500).hide(600);

      }else{
          
        if(codigo_Unspsc.length>=8){
          var res = codigo_Unspsc.substring(4,8);
          if(res!='0000'){
             $.when(lee_json(codigo_Unspsc).then(function(resultado)
             {
                var ver = resultado;
                if(ver!=0){
                  $('#alert_actividad_codigos').html('<div class="alert alert-dismissible alert-success" ><strong>Bien!</strong> Código agregado.</div>');
                  vector_datos_codigos.push({"codigo": codigo_Unspsc, "nombre":ver["Nombre"]});
                  //console.log(vector_datos_codigos);
                }else{
                  $('#alert_actividad_codigos').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> El código no se encuentra registrado en los listado de SECOP.</div>');
                }
             }));
              //var ver=lee_json(codigo_Unspsc);
           
          }else{
            $('#alert_actividad_codigos').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> El código tiene en sus últimos cuatros dígitos 0000.</div>');
            //vector_datos_codigos.push({"codigo": codigo_Unspsc});
          }
        }else{
          $('#alert_actividad_codigos').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Código agregado tiene menos de 8 numeros.</div>');          
        }
          $('#mensaje_actividad_codigos').show(30);
          $('#mensaje_actividad_codigos').delay(2500).hide(300);
          
      }
  });

  $('#VerAgregarCodigos').on('click', function(e)
  {
      var html = '';
          if(vector_datos_codigos.length > 0)
          {
            var num=1;
            $.each(vector_datos_codigos, function(i, e){
              html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['codigo']+'</td><td>'+e['nombre']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarCod" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
              num++;
            });
          }
          $('#registros_cod').html(html);

      $('#t_datos_actividad_codigo').show();
      return false;
  });


  $('#t_datos_actividad_codigo').delegate('button[data-funcion="eliminarCod"]','click',function (e) {   
      var id = $(this).data('rel'); 

      vector_datos_codigos.splice(id, 1);
          
          $('#mensaje_eliminar').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato eliminado de la actividad con exito. </div>');
          $('#mensaje_eliminar').show(60);
          $('#mensaje_eliminar').delay(1500).hide(600);
          var html = '';
            if(vector_datos_codigos.length > 0)
            {
              var num=1;
              $.each(vector_datos_codigos, function(i, e){
                html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['codigo']+'</td><td>'+e['nombre']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarCod" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                num++;
              });
            }
          $('#registros_cod').html(html);

     }); 

  $('#CerrarAgregarCodigos').on('click', function(e)
    {
        $('#t_datos_actividad_codigo').hide();
        return false;
    });

    $('#agregarRubro').on('click', function(e)
    {
        var id_rubro_funcionamiento = $('select[name="Proyecto_inversion"]').find(':selected').val();
        var Nombre_rubro_funcionamiento= $('select[name="Proyecto_inversion"]').find(':selected').text();
        var valor_rubro = $('input[name="valor_contrato_rubro"]').val();

        if(id_rubro_funcionamiento!='' && valor_rubro!='')
        {
            $('#alert_actividad_rubro').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato registrados con éxito. </div>');
            $('#mensaje_actividad_rubro').show(60);
            $('#mensaje_actividad_rubro').delay(1500).hide(600);
            vector_datos_actividad_rubro_f.push({
                "nombre_r": Nombre_rubro_funcionamiento,
                "id_rubro": id_rubro_funcionamiento,
                "valor_rubro":valor_rubro
            });
        }
        else
        {
            $('#alert_actividad_rubro').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Campos vacios en el formulario.</div>');
            $('#mensaje_actividad_rubro').show(60);
            $('#mensaje_actividad_rubro').delay(2500).hide(600);
        }
        $('#VerAgregarRubro_f').click();
    });



    $('#datos_actividad_rubro').delegate('button[data-funcion="eliminar"]','click',function (e) {
        var id = $(this).data('rel');
        vector_datos_actividad_rubro_f.splice(id, 1);

        $('#alert_actividad_rubro').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato eliminado de la actividad con exito. </div>');
        $('#mensaje_actividad_rubro').show(60);
        $('#mensaje_actividad_rubro').delay(1500).hide(600);
        var html = '';
        valor_ingresado_conso=0;
        if(vector_datos_actividad_rubro_f.length > 0)
        {
            var num=1;
            $.each(vector_datos_actividad_rubro_f, function(i, e){
                html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+
                    '<td>'+e['nombre_r']+'</td>'+
                    '<td>Otros distritos</td>'+
                    '<td>'+e['valor_rubro']+'</td>'+
                    '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminar" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                num++;
            });
        }
        $('#registros_rubro').html(html);

        $('#tabla_rubro_f').show();

    });

    
  $('#agregarFinanciacion').on('click', function(e)
    {
        var id_pivot_comp=$('input[name="id_pivot_comp"]').val();
        
        var Fuente_inversion=$('select[name="Fuente_inversion"]').find(':selected').val();
        var indice = form_paa.Fuente_inversion.selectedIndex;
        var Nom_Proyecto_inversion= form_paa.Fuente_inversion.options[indice].text ;

        var Proyecto_inversion=$('select[name="Proyecto_inversion"]').find(':selected').text();
        
        var meta=$('select[name="meta"]').find(':selected').text();
        var id_meta=$('select[name="meta"]').val();

        var componnente=$('select[name="componnente"]').find(':selected').val();
        var indice = form_paa.componnente.selectedIndex;
        var Nombre_componnente= form_paa.componnente.options[indice].text ;

        //console.log('id Componente: '+componnente+' - '+Nombre_componnente);
        var valor_contrato = $('input[name="valor_contrato"]').val();

        valor_contrato=replaceAll(valor_contrato, ".", "" );
        //console.log("-->"+valorAfavor+" "+valor_contrato);
        valor_ingresado_conso=parseInt(valor_contrato);
        console.log(valorAfavor+" "+valor_ingresado_conso);

        if(Nom_Proyecto_inversion===''){
          $('#alert_actividad').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Debe seleccionar un fuente de financiación para poder realizar el registro.</div>');
          $('#mensaje_actividad').show(60);
          $('#mensaje_actividad').delay(2500).hide(600);
        }else{
          if(componnente===''){
            $('#alert_actividad').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Debe seleccionar un componente para realizar el registro.</div>');
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
                  if(valor_ingresado_conso<=valorAfavor){
                    
                    $('input[name="valor_contrato"]').val('');
                    valorAfavor=valorAfavor-valor_ingresado_conso;
                    $('#alert_actividad').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato registrados con éxito. </div>');
                    $('#mensaje_actividad').show(60);
                    $('#mensaje_actividad').delay(1500).hide(600);
                    vector_datos_actividad.push({"id_Proyecto": Fuente_inversion, "Nom_Proyecto":Nom_Proyecto_inversion, "id_componente": componnente, "Nom_Componente":Nombre_componnente,"valor": valor_contrato,"id_pivot_comp":id_pivot_comp, "Proyecto":Proyecto_inversion , "Meta":meta, "id_meta":id_meta});
                    $('#VerAgregarFinanciacion').click();
                  }else{
                    valor_ingresado_conso=parseInt(valor_ingresado_conso)-parseInt(valor_contrato);
                    $('#alert_actividad').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> El valor ingresado o consolidado es mayor al valor de disponibilidad del componente que es de: $'+number_format(valorAfavor)+'</div>');
                    $('#mensaje_actividad').show(60);
                    $('#mensaje_actividad').delay(2500).hide(600);
                  }
              }
          }
        }
        $('#VerAgregarFinanciacion').click();
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
        $('select[name="Proyecto_inversion"]').val("").closest('.form-group').removeClass('has-error');;

        $('textarea[name="objeto_contrato"]').val("").closest('.form-group').removeClass('has-error');;
        vector_datos_actividad.length=0;
        vector_datos_actividad_rubro_f.length=0;
        vector_datos_codigos.length=0;
        $('#t_datos_actividad_codigo').hide();
        $('#ProyectOrubro').prop("disabled",false);
        $('#Proyecto_inversion').prop("disabled",false);
        $('#meta').prop("disabled",false);  

        $('input[name="proyectorubro"]').val('');
        //$('#div_finaciacion').show();
        $('#crear_paa_btn').html("CREAR");
        $('.mjs_componente').html('');
        $('#registros_rubro').html('');
        $('#registros').html('');

    });
       


    $('#proceso_curso').on('click', function(e)
    { 
      var d = new Date();
      var n = d.getFullYear();
      $('input[name="fecha_inicio"]').val('');

       if($('#proceso_curso').val()=="No"){
           $('input[data-role1="datepicker"]').datepicker('destroy');
           $('input[data-role1="datepicker"]').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            minDate: 0 });
        }

        if($('#proceso_curso').val()=="Si"){
           $('input[data-role1="datepicker"]').datepicker('destroy');
           $('input[data-role1="datepicker"]').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            minDate: 0,
            changeYear: true});
        }

    });

    $('#VerAgregarFinanciacion').on('click', function(e)
    {

        var html = '';
        if(vector_datos_actividad_rubro_f.length > 0)
        {
            var num=1;
            $.each(vector_datos_actividad_rubro_f, function(i, e){
                html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+
                    '<td>'+e['nombre_r']+'</td>'+
                    '<td>Otros distritos</td>'+
                    '<td>'+e['valor_rubro']+'</td>'+
                    '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminar" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                num++;
            });
        }
        $('#registros_rubro').html(html);

        html = '';
            if(vector_datos_actividad.length > 0)
            {
              var num=1;
              $.each(vector_datos_actividad, function(i, e){
                html += '<tr class="success"><th scope="row" class="text-center">'+num+'</th>'+
                             '<td>'+e['Proyecto']+'</td>'+
                             '<td>'+e['Meta']+'</td>'+
                             '<td>'+e['Nom_Proyecto']+'</td>'+
                             '<td>'+e['Nom_Componente']+'</td>'+
                             '<td>'+number_format(e['valor'])+'</td>'+
                             '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                num++;
              });
            }
        $('#tabla_rubro_f').show();
        $('#registros').html(html);
        $('#ver_registros').show();
        return false;
    });

    $('#VerAgregarRubro_f').on('click', function(e)
    {
        var html = '';
        if(vector_datos_actividad_rubro_f.length > 0)
        {
            var num=1;
            $.each(vector_datos_actividad_rubro_f, function(i, e){
                html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+
                    '<td>'+e['nombre_r']+'</td>'+
                    '<td>Otros distritos</td>'+
                    '<td>'+e['valor_rubro']+'</td>'+
                    '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminar" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                num++;
            });
        }
        $('#registros_rubro').html(html);


        html = '';

            num=1;
            $.each(vector_datos_actividad, function(i, e){
                if(e['Proyecto']) {
                    html += '<tr class="success"><th scope="row" class="text-center">' + num + '</th>' +
                        '<td>' + e['Proyecto'] + '</td>' +
                        '<td>' + e['Meta'] + '</td>' +
                        '<td>' + e['Nom_Proyecto'] + '</td>' +
                        '<td>' + e['Nom_Componente'] + '</td>' +
                        '<td>' + number_format(e['valor']) + '</td>' +
                        '<td class="text-center"><button type="button" data-rel="' + i + '" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                    num++;
                }
            });



        $('#tabla_rubro_f').show();
        $('#registros').html(html);
        $('#ver_registros').show();

        return false;
    });

    $('#datos_actividad').delegate('button[data-funcion="crear"]','click',function (e) {   
      var id = $(this).data('rel'); 
      var texto=vector_datos_actividad[id]['id_componente'];
      vector_datos_actividad.splice(id, 1);
          
          $('#mensaje_eliminar').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato eliminado de la actividad con exito. </div>');
          $('#mensaje_eliminar').show(60);
          $('#mensaje_eliminar').delay(1500).hide(600);
          var html = '';
          valor_ingresado_conso=0;
            if(vector_datos_actividad.length > 0)
            {
              var num=1;
              $.each(vector_datos_actividad, function(i, e){
                html += '<tr class="success"><th scope="row" class="text-center">'+num+'</th>'+
                        '<td>'+e['Proyecto']+'</td>'+
                        '<td>'+e['Meta']+'</td>'+
                        '<td>'+e['Nom_Proyecto']+'</td>'+
                        '<td>'+e['Nom_Componente']+'</td>'+
                        '<td>'+number_format(e['valor'])+'</td>'+
                        '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                num++;
                if(e['id_componente']==texto){
                  valor_ingresado_conso=parseInt(valor_ingresado_conso)+parseInt(e['valor']);
                }
              });
            }
            $('select[name="componnente"]').val('');
          $('#registros').html(html);

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
                          html += '<option value="'+e['Id']+'">'+e['codigo']+' - '+e['Nombre']+'</option>';
                      });
                    }
                    $('select[name="Proyecto_Finanza"]').html(html).val($('select[name="Proyecto_Finanza"]').data('value'));

                    //Select Fuente
                    var html = '<option value="">Seleccionar</option>';
                    if(data.proyecto.fuente){
                      if(data.proyecto!=null && data.proyecto.fuente.length > 0)
                      {
                        $.each(data.proyecto.fuente, function(i, e){
                            html += '<option value="'+e.pivot['id']+'">'+e['nombre']+'</option>';
                        });
                      }
                    }
                    $('select[name="Fuente_inversion"]').html(html).val($('select[name="Fuente_inversion"]').data('value'));
                    
                if(data.Modelo.componentes.length>0)
                { 

                    $('input[name="proyectorubro"]').val(data.Modelo['Proyecto1Rubro2']);

                    var num=1;
                    var sum=0;
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
                      sum=sum+dato['valor'];
                    });

                    html += '<tr>'+
                              '<th scope="row" class="text-center">Total</th>'+
                              '<td></td>'+
                              '<td></td>'+
                              '<td></td>'+
                              '<td></td>'+
                              '<td> $ '+number_format(sum)+'</td>'+
                              '<td class="text-center"></td></tr>';

                    var html1 ='<option value="1">Seleccionar</option>';
                    $('select[name="componnente"]').html(html1);
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


     $('#datos_actividad2').delegate('button[data-funcion="eliminar_finanza"]','click',function (e) {   
      var id_act_paa = $(this).data('rel'); 
      var id_key_ele = $(this).data('id');
        $('#registrosFinanzas').html('');

        $.ajax({
              type: "POST",
              url: URL+'/service/EliminarFinanciamiento',
              data: {id:id_act_paa,id_eli:id_key_ele},
              dataType: 'json',
              success: function(data)
              {   
                  var html = '';
                  
                  
                  if($.inArray(data.paa.estado,['4','5','7'])!=-1){
                    desactivo="none";
                    $('#btn_agregar_finaza').hide();
                  }else{
                    desactivo="";
                    $('#btn_agregar_finaza').show();
                  }

                    var num=1;
                  $.each(data.ActividadComponente, function(i, dato){
                    html += '<tr>'+
                            '<th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+dato.proyecto['Nombre']+'</td>'+
                            '<td>'+dato.fuenteproyecto.fuente['nombre']+'</td>'+
                            '<td>'+dato.componente['Nombre']+'</td>'+
                            '<td>'+dato.meta['Nombre']+'</td>'+
                            '<td> $'+number_format(dato['valor'])+'</td>'+
                            '<td class="text-center"><button type="button" data-id="'+dato['id']+'"  data-rel="'+id_act_paa+'" data-funcion="eliminar_finanza" class="eliminar_dato_actividad" style="display:'+desactivo+'""><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                    num++;
                  });
                  $('#registrosFinanzas').html(html);
              }
          });
     });


    $('#datos_actividad3').delegate('button[data-funcion="eliminar_finanza_rubro"]','click',function (e) {   
      var id_act_paa = $(this).data('rel'); 
      var id_key_ele = $(this).data('id');
        $('#registrosFinanzasRubro').html('');

        $.ajax({
              type: "POST",
              url: URL+'/service/EliminarFinanciamientoRubro',
              data: {id:id_act_paa,id_eli:id_key_ele},
              dataType: 'json',
              success: function(data)
              {   
                  var html = '';
                  
                  
                  if($.inArray(data.Modelo.estado,['4','5','7'])!=-1){
                    desactivo="none";
                    $('#btn_agregar_finaza').hide();
                  }else{
                    desactivo="";
                    $('#btn_agregar_finaza').show();
                  }

                  var html = '';
                  var num=1;
                  //console.log(data.Modelo.rubro_funcionamiento);
                  $.each(data.Modelo.rubro_funcionamiento, function(i,e){
                    html += '<tr>'+
                            '<th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+e['nombre']+'</td>'+
                            '<td>Otros Distrito</td>'+
                            '<td> $'+number_format(e.pivot['valor'])+'</td>'+
                            '<td class="text-center"><button type="button" data-id="'+e.pivot['rubro_id']+'"  data-rel="'+id_act_paa+'" data-funcion="eliminar_finanza_rubro" class="eliminar_dato_actividad" style="display:'+desactivo+'""><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                    num++;
                  });
                  $('#registrosFinanzasRubro').html(html);
              }
          });
     });

     $('#form_agregar_finza').on('submit', function(e){
          var id_act=$('#id_act_agre').val();
          $('.mjs_componente').html('');
            var proyRu=$('input[name="proyectorubro"]').val();

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

                        if(data.status == 0)
                        {
                            $('.mjs_componente').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> La sumatoria de los valores ingresados superan el valor del presupuesto disponible.</div>');
                            setTimeout(function(){
                                $('.mjs_componente').html('');
                            }, 2000)
                            validad_error_agre(data.errors);
                        }else{
                          validad_error_agre(data.errors);
                          var html = '';
                          $('#registrosFinanzas').html('');
                          var num=1;
                          desactivo="";

                          if($.inArray(data.estado,['4','5','7'])!=-1){
                            desactivo="none";
                            $('#btn_agregar_finaza').hide();
                          }else{
                            desactivo="";
                            $('#btn_agregar_finaza').show();
                          }

                          var html = '';
                          $.each(data.ActividadComponente, function(i, dato){
                            html += '<tr>'+
                                    '<th scope="row" class="text-center">'+num+'</th>'+
                                    '<td>'+dato.proyecto['Nombre']+'</td>'+
                                    '<td>'+dato.fuenteproyecto.fuente['nombre']+'</td>'+
                                    '<td>'+dato.componente['Nombre']+'</td>'+
                                    '<td>'+dato.meta['Nombre']+'</td>'+
                                    '<td> $ '+number_format(dato['valor'])+'</td>'+
                                    '<td class="text-center"><button type="button" data-id="'+dato['id']+'"  data-rel="'+id_act+'" data-funcion="eliminar_finanza" class="eliminar_dato_actividad" style="display:'+desactivo+'""><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                            num++;
                          });

                          $('#registrosFinanzas').html(html);
                          document.getElementById("form_agregar_finza").reset();
                       }
                    }
                  }
              });

           return false;
    });


    $('#form_agregar_finza_2').on('submit', function(e){
          var id_act=$('#id_act_agre2').val();
           $.ajax({
                  type: "POST",
                  url: URL+'/service/agregar_rubro',
                  data: $(this).serialize(),
                  dataType: 'json',
                  success: function(data)
                  { 
                    if(data.status == 'error')
                    {
                        validad_error_agre_rubro(data.errors);
                    } else {
                        validad_error_agre_rubro(data.errors);

                        var html = '';
                        var num = 1;

                        $.each(data.Modelo.rubro_funcionamiento, function(i,e){
                          html += '<tr>'+
                            '<th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+e['nombre']+'</td>'+
                            '<td>Otros Distrito</td>'+
                            '<td>'+number_format(e.pivot['valor'])+'</td>'+
                            '<td class="text-center"><button type="button" data-id="'+e.pivot['rubro_id']+'"  data-rel="'+id_act+'" data-funcion="eliminar_finanza_rubro" class="eliminar_dato_actividad" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                          num++;
                        });
                         
                       $('#registrosFinanzasRubro').html(html);

                    }
                  }
              });

           return false;
    });



     $('#TablaPAA').delegate('button[data-funcion="EstudioComveniencia"]','click',function (e){   
          
          var id_act = $(this).data('rel'); 
          var estado = $(this).data('estado'); 
          var est=0;
          if(estado!=0){
            est=0;
            $('#RegistrarEstudio').hide();
            $('#agregar_financiacion').hide();
            $('#agregar_financiacion_r').hide();
            $('#mjs_estado_estudio').html('<strong>Edición no activa!</strong>.');
          }else{
            est=1;
            $('#RegistrarEstudio').show();
            $('#agregar_financiacion').show();
            $('#agregar_financiacion_r').show();
            $('#mjs_estado_estudio').html('<strong>ACTIVA!</strong> Aprobado por subdirección');
          }


          $('#id_estudio').val(id_act);
          $('#id_Fin').text(id_act);
          vector_datos_financiacion.length=0;
          $.get(
            URL+'/service/obtenerEstidioConveniencia/'+id_act,
            {},
            function(data)
            { 
               
                if(data.EstudioConveniencias!= null)
                {
                  $('#id_estudio_pass').val(id_act);
                  $('textarea[name="texta_Conveniencia"]').val(data.EstudioConveniencias['conveniencia']);
                  $('textarea[name="texta_Oportunidad"]').val(data.EstudioConveniencias['oportunidad']);
                  $('textarea[name="texta_Justificacion"]').val(data.EstudioConveniencias['justificacion']);
                  $('#RegistrarEstudio').text('Modificar'); 
                  //console.log(data.finanzas);

                  $.each(data.finanzas_p, function(i, eee){
                    $.each(eee.actividades, function(j, ee){ 
                       if(ee.pivot['estado']==0){
                          vector_datos_financiacion.push({
                            "id_act_com":eee['id'],
                            "ProyectoRubro":eee.proyecto['Nombre'],
                            "Id_P_R":eee.proyecto['Id'],
                            "Meta":eee.meta['Nombre'],
                            "Id_Meta":eee.meta['Id'],
                            "componente_name": eee.Componente['Nombre'],
                            "componente": eee['id'],
                            "Fuente_ingre_name": ee.Fuente['nombre'],
                            "Fuente_ingre": ee.Fuente['id'],
                            "actividad_ingre_name": ee.Actividad['Nombre'],
                            "actividad_ingre": ee.Actividad['Id'],
                            "valor_componente": ee.pivot['valor'],
                            "porcentaje": ee.pivot['porcentaje'],
                            "valor_total_ingr": ee.pivot['total'],
                            "tipo":1
                          });
                        }
                    });
                  }); 

                  
                  $.each(data.finanzas_r.actividades_funcionamiento, function(j, ee){ 
                     if(ee.pivot['estado']==0){   
                        vector_datos_financiacion.push({
                          "id_act_com":'',
                          "ProyectoRubro":ee['nombre'],
                          "Id_P_R":ee['id'],
                          "Meta":'N.A',
                          "Id_Meta":'',
                          "componente_name": "N.A",
                          "componente": "1",
                          "Fuente_ingre_name": ee.Fuente['nombre'],
                          "Fuente_ingre": ee.Fuente['id'],
                          "actividad_ingre_name": "N.A",
                          "actividad_ingre": "N.A",
                          "valor_componente":ee.pivot['total'],
                          "porcentaje": ee.pivot['porcentaje'],
                          "valor_total_ingr": ee.pivot['total'],
                          "tipo":2
                        });
                      }
                  });
                
                   verFinanciacion(est);
                }
                else
                {

                    vector_datos_financiacion.length=0;
                    verFinanciacion(est);
                    $('#id_estudio_pass').val(0);
                    $('textarea[name="texta_Conveniencia"]').val('');
                    $('textarea[name="texta_Oportunidad"]').val('');
                    $('textarea[name="texta_Justificacion"]').val('');
                    $('#RegistrarEstudio').text('Registrar'); 
                }

                 
                if(data.paas['vinculada']!=''){
                    $('textarea[name="texta_Conveniencia"]').attr('disabled',true);
                    $('textarea[name="texta_Oportunidad"]').attr('disabled',true);
                    $('textarea[name="texta_Justificacion"]').attr('disabled',true);                  
                    $('#mjs_estado_estudio2').html('<strong>Vinculada!</strong> Esté plan está vinculado con el plan id. '+data.paas['vinculada']+', por tal motivo no puede ingresar los campos inhabilitados.');
                    $('#mjs_estado_estudio2').show();
                }else if(data.paas['compartida']!='') {
                    $('textarea[name="texta_Conveniencia"]').attr('disabled',false);
                    $('textarea[name="texta_Oportunidad"]').attr('disabled',false);
                    $('textarea[name="texta_Justificacion"]').attr('disabled',false);
                    $('#mjs_estado_estudio2').html('<strong>Compartida!</strong> Esté plan está siendo compartido, usted podra ingresar los campos como conveniencia, oportunidad, justificación.. estos campos apareceran predeterminados en los planes viculados.');
                    $('#mjs_estado_estudio2').show();
                }else{
                    $('textarea[name="texta_Conveniencia"]').attr('disabled',false);
                    $('textarea[name="texta_Oportunidad"]').attr('disabled',false);
                    $('textarea[name="texta_Justificacion"]').attr('disabled',false);
                    $('#mjs_estado_estudio2').hide();
                }
                

                if(data.paas.rubro_funcionamiento.length>0){
                  
                  //var html = '<option value="1" selected>No aplica para rubro de funcionamiento</option>';
                  //$('select[name="Componente_ingresado"]').html(html).val(1);

                  var html1 = '<option value="">Selecionar</option>';
                  $.each(data.paas.rubro_funcionamiento, function(i, eee){
                      html1 += '<option data-id="'+eee.pivot.paa_id+'" value="'+eee.id+'">'+eee.nombre+'</option>';
                  });
                  $('select[name="Rubros_ingresado"]').html(html1).val($('select[name="Rubros_ingresado"]').data('value'));

                }

                if(data.paas.componentes.length>0){
                  
                  //$('select[name="Componente_ingresado"]').prop('disabled',false);

                  //Proyectos
                  var html_p = '<option value="">Selecionar</option>';
                  $.each(data.finanzas_p, function(i, eee){
                      //console.log(eee);
                      html_p += '<option data-ac="'+eee['id']+'" data-id="'+eee['id_paa']+'" value="'+eee.fuenteproyecto.proyecto['Id']+'">'+eee.fuenteproyecto.proyecto['Nombre']+'</option>';
                  });
                  $('select[name="Proyecto_ingresado"]').html(html_p).val($('select[name="Proyecto_ingresado"]').data('value'));

                  
                  

                }

                
            },
            'json'
          );

     }); 
    
    $('select[name="Rubros_ingresado"]').on('change', function(e)
    {
        selectRubrosIngresados($(this).val(),$(this).find(':selected').data('id'));
    });

    var selectRubrosIngresados = function(id_rubro,id_paa)
    { 
        
        $.post(
          URL+'/service/selectRubrosIngresados',
          {id_rubro: id_rubro, id_paa:id_paa},
          function(data){

                    if(data.rubro_funcionamiento)
                      $('input[name="valor_total_rubro"]').val(data.rubro_funcionamiento[0].pivot['valor']);
                    else
                      $('input[name="valor_total_rubro"]').val(0);

          },'json');
    };

    $('select[name="Proyecto_ingresado"]').on('change', function(e){
        selectMetasIngresadasProyecto($(this).val(),$(this).find(':selected').data('id'),$(this).find(':selected').data('ac'));
    });

    var selectMetasIngresadasProyecto = function(id_proyecto,id_paa,id_ac)
    { 
        //console.log(id_ac);
        $('#id_actividadcomponente').val(id_ac);
        $.post(
          URL+'/service/selectMetasProyecto',
          {id_proyecto: id_proyecto, id_paa:id_paa,id_ac:id_ac},
          function(data){
                     
                    var html = '<option value="">Selecionar</option>';
                    $('select[name="Actividades_rubros_ingresado"]').html(html);
                    $('select[name="actividad_ingre"]').html(html);
                    $('select[name="Actividades_rubros_ingresado"]').html(html);
                    if(data){

                                  html += '<option data-id="'+data['id']+
                                  '" value="'+data.meta['Id']+'">'+
                                      data.meta['Nombre'].toLowerCase()+'</option>';

                    }
                    $('select[name="Metas_ingresado"]').html(html).val($('select[name="Metas_ingresado"]').data('value'));
              
          },'json');
    };

    $('select[name="Metas_ingresado"]').on('change', function(e){
        selecActivMeta($(this).val(),$(this).find(':selected').data('id'));
    });

    var selecActivMeta = function(id_meta,id)
    { 
        $.post(
          URL+'/service/selecActivMeta',
          {id_meta: id_meta, id:id},
          function(data){

                //Actividades meta
                  var html = '<option value="">Selecionar</option>';
                  $('select[name="Actividades_rubros_ingresado"]').html(html);
                  $.each(data.metas.actividades, function(i, eee){
                              html += '<option value="'+eee['Id']+'">'+eee['Nombre'].toLowerCase()+'</option>';
                  });
                  $('select[name="actividad_ingre"]').html(html).val($('select[name="actividad_ingre"]').data('value'));

                //Componentes
                  var html = '<option value="">Selecionar</option>';
                  console.log(data);
                  if(data.Componentes){
                      html += '<option data-valor="'+data.Componentes['valor']+'" value="'+data.Componentes.componente['Id']+'">'+data.Componentes.componente['Nombre']+'</option>';
                  };
                  $('select[name="Componente_ingresado"]').html(html).val($('select[name="Componente_ingresado"]').data('value'));

          },'json');
    };

   /* $('select[name="Rubros_ingresado"]').on('change', function(e){
        selectActividadesRubro($(this).val());
    });

    var selectActividadesRubro = function(id)
    { 
        $.ajax({
            url: URL+'/service/selectActividadesRubro/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Selecionar</option>';
          
                $.each(data.actividadesfuncionamiento, function(i, eee){
                            html += '<option value="'+eee['id']+'">'+eee['nombre'].toLowerCase()+'</option>';
                });
                $('select[name="Actividades_rubros_ingresado"]').html(html).val($('select[name="Actividades_rubros_ingresado"]').data('value'));
            }
        });
    };*/

    $('select[name="Componente_ingresado"]').on('change', function(e){
        $('input[name="valor_componente"]').val($(this).find(':selected').data('valor'));
        $('input[name="valor_conponente_ingre"]').val('');
        $('input[name="valor_total_ingr"]').val('');
    });

    $('input[name="valor_conponente_ingre"]').on('keyup', function(e){
        var total="";
        var valor=$('input[name="valor_componente"]').val();
        var porcentaje=$('input[name="valor_conponente_ingre"]').val();
        if(porcentaje>100 || porcentaje<0)
        {
          total="Error porcentaje";
        }else{
          total = (parseFloat(valor)*parseInt(porcentaje))/100;
        }
        $('input[name="valor_total_ingr"]').val(total);
    });

    $('#agregar_financiacion').on('click', function(e)
    {
          //Proyecto
          var Id_P_R =$('select[name="Proyecto_ingresado"]').find(':selected').val();
          var poryecto_name =$('select[name="Proyecto_ingresado"]').find(':selected').text();

          //Meta
          var Id_Meta =$('select[name="Metas_ingresado"]').find(':selected').val();
          var meta_name =$('select[name="Metas_ingresado"]').find(':selected').text();

          var componente =$('select[name="Componente_ingresado"]').find(':selected').val();
          var componente_name =$('select[name="Componente_ingresado"]').find(':selected').text();
          var Fuente_ingre =$('select[name="Fuente_ingre"]').find(':selected').val();
          var Fuente_ingre_name =$('select[name="Fuente_ingre"]').find(':selected').text();
          var actividad_ingre =$('select[name="actividad_ingre"]').find(':selected').val();
          var actividad_ingre_nom =$('select[name="actividad_ingre"]').find(':selected').text();
          var valor_componente=$('input[name="valor_componente"]').val();
          var valor_conponente_ingre=$('input[name="valor_conponente_ingre"]').val();
          var valor_total_ingr=$('input[name="valor_total_ingr"]').val();
          var vali_porce=0;

          
          if(Fuente_ingre==='')
          {
              $('#alert_actividad_finca_estudio').html('<div class="alert alert-dismissible alert-danger" ><strong>Fuente de hacienda!</strong> Campo vacio.</div>');
              $('#mensaje_actividad_finan_estudio').show(60);
              $('#mensaje_actividad_finan_estudio').delay(2500).hide(600);

          }else if(Id_P_R===''){
              $('#alert_actividad_finca_estudio').html('<div class="alert alert-dismissible alert-danger" ><strong>Proyecto de inversión!</strong> Campo vacio.</div>');
              $('#mensaje_actividad_finan_estudio').show(60);
              $('#mensaje_actividad_finan_estudio').delay(2500).hide(600);
          }else if(Id_Meta===''){
              $('#alert_actividad_finca_estudio').html('<div class="alert alert-dismissible alert-danger" ><strong>Meta!</strong> Campo vacio.</div>');
              $('#mensaje_actividad_finan_estudio').show(60);
              $('#mensaje_actividad_finan_estudio').delay(2500).hide(600);
          }else if(actividad_ingre===''){
              $('#alert_actividad_finca_estudio').html('<div class="alert alert-dismissible alert-danger" ><strong>Actividad de Meta!</strong> Campo vacio.</div>');
              $('#mensaje_actividad_finan_estudio').show(60);
              $('#mensaje_actividad_finan_estudio').delay(2500).hide(600);
          }else if(componente===''){
              $('#alert_actividad_finca_estudio').html('<div class="alert alert-dismissible alert-danger" ><strong>Componente!</strong> Campo vacio.</div>');
              $('#mensaje_actividad_finan_estudio').show(60);
              $('#mensaje_actividad_finan_estudio').delay(2500).hide(600);
          }else if(valor_conponente_ingre===''){
              $('#alert_actividad_finca_estudio').html('<div class="alert alert-dismissible alert-danger" ><strong>Porcentaje %!</strong> Campo vacio.</div>');
              $('#mensaje_actividad_finan_estudio').show(60);
              $('#mensaje_actividad_finan_estudio').delay(2500).hide(600);
          }
          else{
              
              if(vector_datos_financiacion.length >= 0)
              {
                $.each(vector_datos_financiacion, function(i, e){
                  if(e['componente']==componente && e['Id_Meta']==Id_Meta){
                    vali_porce=parseInt(vali_porce)+parseInt(e['porcentaje']);
                  }
                });
                vali_porce=parseInt(vali_porce)+parseInt(valor_conponente_ingre);
              }
              else{
                    vali_porce=parseInt(vali_porce)+parseInt(e['porcentaje']);
              }

              if(vali_porce<=100)
              {
                $('#alert_actividad_finca_estudio').html('<div class="alert alert-dismissible alert-success" ><strong>Bien!</strong> Registro agregado.</div>');
                $('#mensaje_actividad_finan_estudio').show(30);
                $('#mensaje_actividad_finan_estudio').delay(1000).hide(300);
                var id_act_com =$('input[name="id_actividadcomponente"]').val();
                vector_datos_financiacion.push({
                  "id_act_com":id_act_com,
                  "ProyectoRubro":poryecto_name,
                  "Id_P_R":Id_P_R,
                  "Meta":meta_name,
                  "Id_Meta":Id_Meta,
                  "componente_name": componente_name,
                  "componente": componente,
                  "Fuente_ingre_name": Fuente_ingre_name,
                  "Fuente_ingre": Fuente_ingre,
                  "actividad_ingre_name": actividad_ingre_nom,
                  "actividad_ingre": actividad_ingre,
                  "valor_componente": valor_componente,
                  "porcentaje": valor_conponente_ingre,
                  "valor_total_ingr": valor_total_ingr,
                  "tipo":1
                });
              }
              else{
                $('#alert_actividad_finca_estudio').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> El porcentaje que intenta ingresar para el componente "'+componente_name+'" sobre pasa el 100%.</div>');                $('#mensaje_actividad_finan').show(60);
                $('#mensaje_actividad_finan_estudio').show(30);
                $('#mensaje_actividad_finan_estudio').delay(2500).hide(600);
              }
          }

          verFinanciacion(1);
    });

    $('#agregar_financiacion_r').on('click', function(e)
    {
          var Id_P_R =$('select[name="Rubros_ingresado"]').find(':selected').val();
          var rubro_name =$('select[name="Rubros_ingresado"]').find(':selected').text();

          var Fuente_ingre =$('select[name="Fuente_ingre"]').find(':selected').val();
          var Fuente_ingre_name =$('select[name="Fuente_ingre"]').find(':selected').text();

          var actividad_ingre ='N.A';
          var actividad_ingre_nom ='N.A';

          var valor_componente='N.A';
          var valor_conponente_ingre='100';

          var valor_total_ingr=$('input[name="valor_total_rubro"]').val();
          var vali_porce=0;

          
          if(Fuente_ingre==='')
          {
              $('#alert_actividad_finca_estudio').html('<div class="alert alert-dismissible alert-danger" ><strong>Fuente de hacienda!</strong> Campo vacio.</div>');
              $('#mensaje_actividad_finan_estudio').show(60);
              $('#mensaje_actividad_finan_estudio').delay(2500).hide(600);

          }else if(Id_P_R===''){
              $('#alert_actividad_finca_estudio').html('<div class="alert alert-dismissible alert-danger" ><strong>Rubro de funcionamiento!</strong> Campo vacio.</div>');
              $('#mensaje_actividad_finan_estudio').show(60);
              $('#mensaje_actividad_finan_estudio').delay(2500).hide(600);
          }else{
              
             
                $('#alert_actividad_finca_estudio').html('<div class="alert alert-dismissible alert-success" ><strong>Bien!</strong> Registro agregado.</div>');
                $('#mensaje_actividad_finan_estudio').show(30);
                $('#mensaje_actividad_finan_estudio').delay(1000).hide(300);
                vector_datos_financiacion.push({
                  "id_act_com":'',
                  "ProyectoRubro":rubro_name,
                  "Id_P_R":Id_P_R,
                  "Meta":'N.A',
                  "Id_Meta":'',
                  "componente_name": 'N.A',
                  "componente": '',
                  "Fuente_ingre_name": Fuente_ingre_name,
                  "Fuente_ingre": Fuente_ingre,
                  "actividad_ingre_name": actividad_ingre_nom,
                  "actividad_ingre": actividad_ingre,
                  "valor_componente": valor_componente,
                  "porcentaje": valor_conponente_ingre,
                  "valor_total_ingr": valor_total_ingr,
                  "tipo":2
                });              
          }

          verFinanciacion(1);
    });

    function  verFinanciacion(estado){
        var html = '';
        var classeBoostrap="";

            if(vector_datos_financiacion.length > 0)
            {
              var num=1;

              $.each(vector_datos_financiacion, function(i, e){
                if(e['tipo']==1)
                  classeBoostrap="success";
                else
                  classeBoostrap="warning";

                html += '<tr class="'+classeBoostrap+'">'+
                        '<th scope="row" class="text-center">'+num+'</th>'+
                        '<td>'+e['ProyectoRubro']+'</td>'+
                        '<td>'+e['Meta']+'</td>'+
                        '<td>'+e['actividad_ingre_name']+'</td>'+
                        '<td>'+e['componente_name']+'</td>'+
                        '<td>'+e['Fuente_ingre_name']+'</td>'+
                        '<td>'+e['valor_componente']+'</td>'+
                        '<td>'+e['porcentaje']+'%</td>'+
                        '<td> $'+number_format(e['valor_total_ingr'])+'</td>';
                        if(estado==1)
                        html += '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarFinan" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                        else
                        html += '<td class="text-center"></td></tr>';
                num++;
              });
            }
            $('#registros_finanza_estudio').html(html);

        $('#t_datos_ingreso_finanza').show();
        return false;
    }

    $('#ver_tabla_finanza').on('click', function(e)
    {
        var html = '';
            if(vector_datos_financiacion.length > 0)
            {
              var num=1;
              $.each(vector_datos_financiacion, function(i, e){
                html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['Fuente_ingre_name']+'</td><td>'+e['componente_name']+'</td><td>'+e['actividad_ingre_name']+'</td><td>'+e['valor_componente']+'</td><td>'+e['porcentaje']+'%</td><td> $'+e['valor_total_ingr']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarFinan" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                num++;
              });
            }
            $('#registros_finanza').html(html);

        $('#t_datos_ingreso_finanza').show();
        return false;
    });

    

    $('#t_datos_ingreso_finanza').delegate('button[data-funcion="eliminarFinan"]','click',function (e) {   
      var id = $(this).data('rel'); 
      vector_datos_financiacion.splice(id, 1);
          
          var html = '';
            if(vector_datos_financiacion.length > 0)
            {
              var num=1;
              $.each(vector_datos_financiacion, function(i, e){
                  if(e['tipo']==1)
                   classeBoostrap="success";
                  else
                    classeBoostrap="warning";

                    html += '<tr class="'+classeBoostrap+'">'+
                            '<th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+e['ProyectoRubro']+'</td>'+
                            '<td>'+e['Meta']+'</td>'+
                            '<td>'+e['actividad_ingre_name']+'</td>'+
                            '<td>'+e['componente_name']+'</td>'+
                            '<td>'+e['Fuente_ingre_name']+'</td>'+
                            '<td>'+e['valor_componente']+'</td>'+
                            '<td>'+e['porcentaje']+'%</td>'+
                            '<td> $'+e['valor_total_ingr']+'</td>'+
                            '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarFinan" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                    num++;
              });
            }
            $('#registros_finanza_estudio').html(html);

     }); 

    


      $('#form_agregar_estudio_comveniencia').on('submit', function(e){

              if(vector_datos_financiacion.length>0){
                  var datos_cod = JSON.stringify(vector_datos_financiacion);
                  $('input[name="campos_Clasi_Finan"]').val(datos_cod);
                      
                  $('#RegistrarEstudio').html("Registrando...");
                  $('#RegistrarEstudio').prop("disabled",true); 
                      $.ajax({
                          type: "POST",
                          url: URL+'/service/agregar_estudio',
                          data: $(this).serialize(),
                          dataType: 'json',
                          success: function(data)
                          {   

                            if(data.status == 'error')
                            {
                                validad_error_estidioC(data.errors);
                                $('#RegistrarEstudio').prop("disabled",false); 
                            } else {

                                validad_error_estidioC(data.errors);
                                $('#mjs_Observa_Fina').html('<strong>Bien!</strong> Datos registrados con exíto..');
                                $('#mjs_Observa_Fina').show();
                                setTimeout(function(){
                                    $('#mjs_Observa_Fina').hide();
                                    $('#Modal_EstudioComveniencia').modal('hide');
                                    $('#RegistrarEstudio').prop("disabled",false); 
                                    location.reload();
                                }, 2000)
                            }
                          }
                      });
              }else{
                $('#mjs_Observa_Fina2').html('<strong>Error!</strong> No sea agregado ninguna fuente de financiación');
                $('#mjs_Observa_Fina2').show();
                setTimeout(function(){
                    $('#mjs_Observa_Fina2').hide();
                }, 2000)
              }
           return false;
    });

  var validad_error_estidioC = function(data)
    {
        $('#form_agregar_estudio_comveniencia .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    
                    case 'Proyecto_inversion':
                    case 'componnente':
                    case 'componnente':
                    selector = 'textarea';
                    break;
                
                }
                $('#form_agregar_estudio_comveniencia '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }


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

                    case 'Proyecto_Finanza':
                    case 'Meta_Finanza':
                    case 'Fuente_Finanza':
                    case 'Componnente_Finanza':
                    selector = 'select';
                    break;
                
                }
                $('#form_agregar_finza '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }


  var validad_error_agre_rubro = function(data)
    {
        $('#form_agregar_finza_2 .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'Fuente_inversion':
                    selector = 'select';
                    break;

                    case 'valor_contrato':
                    selector = 'input';
                    break;
                
                }
                $('#form_agregar_finza_2 '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
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

                        if(dato['Proyecto1Rubro2']==1){
                             nom_pro_rubr=dato.proyecto['Nombre'];
                             nom_meta=dato.meta['Nombre'];
                          }else if(dato['Proyecto1Rubro2']==2){
                             nom_pro_rubr=dato.rubro_funcionamiento['nombre'];
                             nom_meta="Na";
                          }else{
                             nom_pro_rubr="";
                             nom_meta="";
                          }
                        
                       if(dato['Estado']==0 || dato['Estado']==4 || dato['Estado']==5 || dato['Estado']==6 || dato['Estado']==7 || dato['Estado']==9){ // Registro Actual
                            tb1.row.add( [
                                '<th scope="row" class="text-center">'+num+'</th>',
                                '<td>'+dato['Registro']+'</td>',
                                '<td>'+dato['CodigosU']+'</td>',
                                '<td>'+dato.modalidad['Nombre']+'</td>',
                                '<td>'+dato.tipocontrato['Nombre']+'</td>',
                                '<td><div class="campoArea">'+dato['ObjetoContractual']+'</div></td>',
                                '<td>'+number_format(dato['ValorEstimado'])+'</td>',
                                '<td>'+number_format(dato['ValorEstimadoVigencia'])+'</td>',
                                '<td>'+dato['VigenciaFutura']+'</td>',
                                '<td>'+dato['EstadoVigenciaFutura']+'</td>',
                                '<td>'+dato['FechaEstudioConveniencia']+'</td>',
                                '<td>'+dato['FechaInicioProceso']+'</td>',
                                '<td>'+dato['FechaSuscripcionContrato']+'</td>',
                                '<td>'+dato['DuracionContrato']+'</td>',
                                '<td>'+dato['RecursoHumano']+'</td>',
                                '<td>'+dato['NumeroContratista']+'</td>',
                                '<td>'+dato['DatosResponsable']+'</td>',
                                '<td>'+nom_pro_rubr+'</td>',
                                '<td>'+nom_meta+'</td>'
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
                                  '<td><div class="campoArea">'+dato['ObjetoContractual']+'</div></td>',
                                  '<td>'+number_format(dato['ValorEstimado'])+'</td>',
                                  '<td>'+number_format(dato['ValorEstimadoVigencia'])+'</td>',
                                  '<td>'+dato['VigenciaFutura']+'</td>',
                                  '<td>'+dato['EstadoVigenciaFutura']+'</td>',
                                  '<td>'+dato['FechaEstudioConveniencia']+'</td>',
                                  '<td>'+dato['FechaInicioProceso']+'</td>',
                                  '<td>'+dato['FechaSuscripcionContrato']+'</td>',
                                  '<td>'+dato['DuracionContrato']+'</td>',
                                  '<td>'+dato['RecursoHumano']+'</td>',
                                  '<td>'+dato['NumeroContratista']+'</td>',
                                  '<td>'+dato['DatosResponsable']+'</td>',
                                  '<td>'+nom_pro_rubr+'</td>',
                                  '<td>'+nom_meta+'</td>'
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
                                  '<td><div class="campoArea">'+dato['ObjetoContractual']+'</div></td>',
                                  '<td>'+number_format(dato['ValorEstimado'])+'</td>',
                                  '<td>'+number_format(dato['ValorEstimadoVigencia'])+'</td>',
                                  '<td>'+dato['VigenciaFutura']+'</td>',
                                  '<td>'+dato['EstadoVigenciaFutura']+'</td>',
                                  '<td>'+dato['FechaEstudioConveniencia']+'</td>',
                                  '<td>'+dato['FechaInicioProceso']+'</td>',
                                  '<td>'+dato['FechaSuscripcionContrato']+'</td>',
                                  '<td>'+dato['DuracionContrato']+'</td>',
                                  '<td>'+dato['RecursoHumano']+'</td>',
                                  '<td>'+dato['NumeroContratista']+'</td>',
                                  '<td>'+dato['DatosResponsable']+'</td>',
                                  '<td>'+nom_pro_rubr+'</td>',
                                  '<td>'+nom_meta+'</td>'

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
        
        vector_datos_codigos.length=0; 
        var CodigosU = datos['CodigosU'].split(","); 
        for (var i=0; i < CodigosU.length; i++) { 
            vector_datos_codigos.push({"codigo": CodigosU[i] }); 
        }
        console.log(datos);
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
       

        $('select[name="ProyectOrubro"]').val(datos['Proyecto1Rubro2']).closest('.form-group').removeClass('has-error');
        $('#ProyectOrubro').prop("disabled",true);
        $('select[name="unidad_tiempo"]').val(datos['unidad_tiempo']).closest('.form-group').removeClass('has-error');

        //$('select[name="Proyecto_inversion"]').val(datos['Id_Proyecto']).closest('.form-group').removeClass('has-error'); 
        if(datos['Proyecto1Rubro2']==1)//Proyecto
          select_Meta2(datos['Id_Proyecto'],datos['MetaPlan']);
        else
          select_Rubro(datos['Id_Rubro']);
        //$('select[name="meta"]').val(datos['MetaPlan']).closest('.form-group').removeClass('has-error'); 
        //$('select[name="Id_Localidad"]').val(datos['Localidad']).change();

        $('textarea[name="objeto_contrato"]').val(datos['ObjetoContractual']).closest('.form-group').removeClass('has-error');;
        vector_datos_actividad.length=1;
        $('#div_finaciacion').hide();

        var html = '';
          if(vector_datos_codigos.length > 0)
          {
            var num=1;
            $.each(vector_datos_codigos, function(i, e){
              html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['codigo']+'</td><td></td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarCod" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
              num++;
            });
          }
          $('#registros_cod').html(html);

        $('#t_datos_actividad_codigo').show();
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
                      /*var num=1;
                      t.clear().draw();
                      $.each(data.datos, function(i, e){
                          
                          
                           var $tr1 = tabla_opciones(e,num);                   
                            

                          t.row.add($tr1).draw( false );
                          num++;
                      });*/
                      $('#mjs_ElimRegistro').html(' <strong>Registro Eliminado con Exitoso!</strong> Se realizo la eliminación del resgistro de su PAA.');
                      $('#mjs_ElimRegistro').show();
                      setTimeout(function(){
                          $('#mjs_ElimRegistro').hide();
                          $('#Modal_Eliminar').modal('hide'); 
                          window.location.reload(true);
                      }, 2000)
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

    function tabla_opciones(e, num){
                          var disable="";
                          var disable2="";
                          var estado="";
                          var clase="";
                          var var0="";
                          var var1="";

                          if(e['Estado']==4){
                            clase="class=\"warning\"";
                            disable="disabled";
                            estado="En Subdireción";
                            estudioComve="1";
                          }else if(e['Estado']==5){
                            clase="class=\"success\"";
                            disable="disabled";
                            estado="Aprobado Subdireción. (Sin registro de estudio)";
                            estudioComve="0";
                          }else if(e['Estado']==6){
                            clase="class=\"danger\"";
                            disable="";
                            estado="Denegado Subdireción";
                            estudioComve="1";
                          }else if(e['Estado']==7){
                            clase="class=\"danger\"";
                            disable="disabled";
                            estado="CANCELADO";
                            estudioComve="1";
                          }else if(e['Estado']==8){
                            clase="style=\"background-color: #DFFFD8 !important;\"";
                            disable="disabled";
                            estado="Aprobado Subdireción <b>(Por aprobación del estudio)";
                            estudioComve="1";
                          }else if(e['Estado']==9){
                            clase="style=\"background-color: #DCFFB3 !important;\"";
                            disable="disabled";
                            estado="Aprobado Subdireción <b>(Estudio  aprobado)";
                            estudioComve="1";
                          }else if(e['Estado']==10){
                            clase="style=\"background-color: #DCD664 !important;\"";
                            disable="disabled";
                            estado="Aprobado Subdireción <b>(Correciones pendientes del estudio)";
                            estudioComve="0";
                          }else if(e['Estado']==11){
                            clase="style=\"background-color: #829E48 !important;\"";
                            disable="disabled";
                            estado="Aprobado Subdireción <b>(Cancelado el estudio)";
                            estudioComve="1";
                          }else{
                            estado="En Consolidación";
                            disable="";
                            estudioComve="1";
                          }


                          if (e['compartida']>0)
                            var0 = 'C';
                          else
                            var0 = '';


                          if (e['vinculada']>0){
                              var1 = 'V';
                              disable2="disabled";
                          }else{
                              var1 = '';
                              disable2="";
                          }

                          nombrementa="";
                          nomProyRubro="";
                          Proyecto1Rubro2="";
                            console.log(e.componentes.length+' '+e.rubro_funcionamiento.length);
                            if (e.rubro_funcionamiento.length>0 && e.componentes.length>0)
                            {
                                nomProyRubro = "Areglar";//$paa->rubro_funcionamiento['nombre'];
                                nombrementa = "N.A";
                                Proyecto1Rubro2 = "P-R";
                            }
                            else if (e.componentes.length>0)
                            {
                                //console.log(e);
                                if(e.proyecto!= null)
                                nomProyRubro = e.proyecto['Nombre'];

                                if(e.meta!=null)
                                nombrementa = e.meta['Nombre'];

                                Proyecto1Rubro2 = "P";
                            }
                            else if (e.rubro_funcionamiento.length>0)
                            {
                                nomProyRubro = "";
                                nombrementa = "N.A";
                                Proyecto1Rubro2 = "R";
                            }

                            var uni_t="";
                            if (e['unidad_tiempo']==0)
                                uni_t = "Dias";
                            else if(e['unidad_tiempo']==1)
                                uni_t = "Mes";
                            else if(e['unidad_tiempo']==2)
                                uni_t = "Años";
                            else
                                uni_t = "";
                          
                          
                            var htm='<th scope="row" class="text-center">'+num+'</th>'+
                                '<td><b><p class="text-info text-center" style="font-size: 15px">'+e['Registro']+'<br>'+var0+var1+e['vinculada']+'<br>'+Proyecto1Rubro2+'</p></b></td>'+
                                '<td><b>'+e.persona['Primer_Apellido']+' '+e.persona['Primer_Nombre']+'</b></td>'+
                                '<td><b>'+estado+'</b></td>'+
                                '<td>'+e['CodigosU']+'</td>'+
                                '<td>'+e.modalidad['Nombre']+'</td>'+
                                '<td>'+e.tipocontrato['Nombre']+'</td>'+
                                '<td><div style="width:500px;text-align: justify;height: 100px; overflow-y: scroll;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); padding: 10px">'+e['ObjetoContractual']+'</div></td>'+
                                '<td>'+number_format(e['ValorEstimado'])+'</td>'+
                                '<td>'+e['DuracionContrato']+' - '+uni_t+'</td>'+
                                '<td>'+number_format(e['ValorEstimadoVigencia'])+'</td>'+
                                '<td>'+e['VigenciaFutura']+'</td>'+
                                '<td>'+e['EstadoVigenciaFutura']+'</td>'+
                                '<td>'+e['FechaEstudioConveniencia']+'</td>'+
                                '<td>'+e['FechaInicioProceso']+'</td>'+
                                '<td>'+e['FechaSuscripcionContrato']+'</td>'+
                                '<td>'+e['RecursoHumano']+'</td>'+
                                '<td>'+e['NumeroContratista']+'</td>'+
                                '<td>'+e['DatosResponsable']+'</td>'+
                                '<td>'+nomProyRubro+'</td>'+
                                '<td>'+nombrementa+'</td>'+
                                '<td>'+
                                  '<div class="btn-group" ><button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 170px;">Acciones<span class="caret"></span></button><ul class="dropdown-menu" style="padding-left: 2px;">'+
                                    '<li><button type="button" data-rel="'+e['Id']+'" data-funcion="ver_eli" class="btn btn-link btn btn-xs" title="Eliminar Paa" '+disable+'><span class="glyphicon glyphicon-trash" aria-hidden="true" ></span>   Eliminar</button>  </li>';
                                    
                                    if(disable2!="disabled")
                                    htm=htm+'<li><button type="button" data-rel="'+e['Id']+'" data-funcion="Modificacion" class="btn btn-link btn-xs"  title="Editar Paa" '+disable+' '+disable2+'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>   Modificación</button></li>';
                                    
                                    htm=htm+'<li><button type="button" data-rel="'+e['Registro']+'" data-funcion="Historial" class="btn btn-link  btn-xs" title="Historial" ><span class="glyphicon glyphicon-header" aria-hidden="true"></span>   Historial</button></li>';
                                    
                                    htm=htm+'<li><button type="button" data-rel="'+e['Id']+'" data-funcion="Financiacion" class="btn btn-link  btn-xs"  title="Financiación" data-toggle="modal" data-target="#Modal_Financiacion"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>   Financiación</button>  </li>';
                                    
                                    if(disable2!="disabled")
                                    htm=htm+'<li><button type="button" data-rel="'+e['Id']+'" data-estado="'+estudioComve+'" data-funcion="EstudioComveniencia" class="btn btn-link btn-xs"  title="Estudio Conveniencia" data-toggle="modal" data-target="#Modal_EstudioComveniencia" '+disable2+' ><span class="glyphicon glyphicon-duplicate" aria-hidden="true" ></span>   Est. Conveniencia</button>  </li>';

                                    if(disable2!="disabled")
                                    htm=htm+'<li><button type="button" data-rel="'+e['Id']+'" data-funcion="Modal_Compartida" class="btn btn-link btn-xs"  title="Compartir Paa" data-toggle="modal" data-target="#Modal_Compartida" '+disable2+'><span class="glyphicon glyphicon-share" aria-hidden="true"></span>   Compartida</button></li>';

                                  htm=htm+'</div>'+
                                  '<div>'+
                                    '<a href="#" class="btn btn-xs btn-default" style="width: 100%;    margin-top: 20px;" data-rel="'+e['Registro']+'" data-funcion="Observaciones"><span class="glyphicon glyphicon-info-sign"></span> Observaciones</a>'+
                                  '</div>'+
                                  '<div id=""></div>'+
                                '</td>';
                          var $tr1 =   $('<tr '+clase+'></tr>').html(htm);
                  return $tr1 ;
    }

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
                          
                          if(e['Proyecto1Rubro2']==1){
                             $nom_pro_rubr=e.proyecto['Nombre'];
                             $nom_meta=e.meta['Nombre'];
                          }else if(e['Proyecto1Rubro2']==2){
                             $nom_pro_rubr=e.rubro_funcionamiento['nombre'];
                             $nom_meta="Na";
                          }else{
                             $nom_pro_rubr="";
                             $nom_meta="";
                          }

                          tb4.row.add( [
                              '<th scope="row" class="text-center">'+num+'</th>',
                              '<td>'+e['Registro']+'</td>',
                              '<td>'+e['CodigosU']+'</td>',
                              '<td>'+e.modalidad['Nombre']+'</td>',
                              '<td>'+e.tipocontrato['Nombre']+'</td>',
                              '<td><div class="campoArea">'+e['ObjetoContractual']+'</div></td>',
                              '<td>'+number_format(e['ValorEstimado'])+'</td>',
                              '<td>'+number_format(e['ValorEstimadoVigencia'])+'</td>',
                              '<td>'+e['VigenciaFutura']+'</td>',
                              '<td>'+e['EstadoVigenciaFutura']+'</td>',
                              '<td>'+e['FechaEstudioConveniencia']+'</td>',
                              '<td>'+e['FechaInicioProceso']+'</td>',
                              '<td>'+e['FechaSuscripcionContrato']+'</td>',
                              '<td>'+e['DuracionContrato']+'</td>',
                              '<td>'+e['RecursoHumano']+'</td>',
                              '<td>'+e['NumeroContratista']+'</td>',
                              '<td>'+e['DatosResponsable']+'</td>',
                              '<td>'+$nom_pro_rubr+'</td>',
                              '<td>'+$nom_meta+'</td>',
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


    $('#Compartida').on('click', function(e){

        id=$('#id_estudio2').val();
        $.get(
            URL+'/service/siCompartirPaa/'+id,
            {},
            function(data)
            {
                if(data)
                {
                    $('#CompartidaNo').removeClass('btn-success');
                    $('#Compartida').addClass('btn-success');
                }
            },
            'json'
        );

    });


    $('#CompartidaNo').on('click', function(e){

        id=$('#id_estudio2').val();
        $.get(
            URL+'/service/noCompartirPaa/'+id,
            {},
            function(data)
            {
                if(data)
                {
                    $('#Compartida').removeClass('btn-success');
                    $('#CompartidaNo').addClass('btn-success');
                }
            },
            'json'
        );

    });

    $('#TablaPAA').delegate('button[data-funcion="Modal_Compartida"]','click',function (e){   
          var id_act = $(this).data('rel'); 
          $('#id_estudio2').val(id_act);
          $('#id_Fin2').text(id_act);

          $.get(
            URL+'/service/verificarCompartPaa/'+id_act,
            {},
            function(data)
            {
                if(data)
                {
                    if(data.compartida==""){
                      $('#Compartida').removeClass('btn-success');
                      $('#CompartidaNo').addClass('btn-success');
                    }else{
                      $('#CompartidaNo').removeClass('btn-success');
                      $('#Compartida').addClass('btn-success');
                    }
                }
            },
            'json'
        );
     }); 


    $('select[name="selectSubdirecion"]').on('change', function(e){
        select_area($(this).val());
    });

    var select_area = function(id)
    { 
        $.ajax({
            url: URL+'/service/select_area/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Selecionar</option>';
          
                $.each(data.areas, function(i, eee){
                            html += '<option value="'+eee['id']+'">'+eee['nombre'].toLowerCase()+'</option>';
                            $('input[name="id_pivot_comp"]').val(eee['id']);
                });
                $('select[name="selectArea"]').html(html).val($('select[name="selectArea"]').data('value'));
            }
        });
    };



    $('select[name="selectArea"]').on('change', function(e){
        select_paa_venc($(this).val());
    });

    var select_paa_venc = function(id)
    { 
        $.ajax({
            url: URL+'/service/select_paVinculada/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                
                var html = '<option value="">Selecionar</option>';          

                $.each(data[0].paas, function(i, eee){
                            var res = eee['ObjetoContractual'].slice(0, 140);
                            html += '<option value="'+eee['Id_paa']+'">'+eee['Id_paa']+' - '+res.toLowerCase()+'</option>';
                });
                $('select[name="selectPaa"]').html(html).val($('select[name="selectPaa"]').data('value'));
            }
        });
    };


    $('#TablaPAA').delegate('button[data-funcion="Modal_Vinculada"]','click',function (e){   
          var id_act = $(this).data('rel'); 
          $('#id_estudio3').val(id_act);
          $('#id_Fin3').text(id_act);

          $.get(
            URL+'/service/verificarCompartPaa/'+id_act,
            {},
            function(data)
            {
                if(data)
                {
                    if(data.compartida==""){
                      $('#Compartida').removeClass('btn-success');
                      $('#CompartidaNo').addClass('btn-success');
                    }else{
                      $('#CompartidaNo').removeClass('btn-success');
                      $('#Compartida').addClass('btn-success');
                    }
                }
            },
            'json'
        );
     }); 


    $('#form_vinvular').on('submit', function(e){
            $.ajax({
                type: "POST",
                url: URL+'/service/datos_vincular',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data)
                {   
                  if(data.status == 'error')
                  {
                      validad_error_vincula(data.errors);
                  } 
                  else 
                  {
                      validad_error_vincula(data.errors);
                      $('#mjs_Observa_vinvula').html('<strong>Bien!</strong>Paa vinculada con exíto..');
                      $('#mjs_Observa_vinvula').show();
                      setTimeout(function(){
                          $('#mjs_Observa_vinvula').hide();
                          $('#Modal_Vinculada').modal('hide');
                      }, 2000)
                  }
                }
            });
           return false;
    });

    $('#ordenadorGasto').on('change', function(e){
      
      if ($('#ordenadorGasto').val()=="Si") 
      {
          $('#contenidoOrdenado').show();
      }else
      {
          $('#contenidoOrdenado').hide();
      }

      
    });


    var validad_error_vincula = function(data)
    {
        $('#form_vinvular .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'selectSubdirecion':
                    case 'selectArea':
                    case 'selectPaa':
                    selector = 'select';
                    break;
                }
                $('#form_vinvular '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }


    $('#objeto_contrato').keydown(function(e){
       valida_longitud();
    });

    var contenido_textarea = "" 
    var num_caracteres_permitidos = 3000;
    function valida_longitud(){ 
       num_caracteres = $('#objeto_contrato').val().length; 
       if (num_caracteres > num_caracteres_permitidos){ 
          $('#objeto_contrato').val(contenido_textarea);
       }else{ 
          contenido_textarea = $('#objeto_contrato').val(); 
       } 
       cuenta() 
    } 
    function cuenta(){ 
       var num=$('#objeto_contrato').val().length; 
       $('#numTextAre').text(num);
    } 
                 
});
