$(function()
{
  
  var URL = $('#main_paa_').data('url');
  vector_datos_actividad = new Array();
  vector_datos_codigos = new Array();

  
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
    var bolean =true;
    var datos_acti = JSON.stringify(vector_datos_actividad);
    $('input[name="Dato_Actividad"]').val(datos_acti);

    var datos_cod = JSON.stringify(vector_datos_codigos);
    $('input[name="Dato_Actividad_Codigos"]').val(datos_cod);

    if($('#radio_vinculado input:radio:checked').val()==0){
      if($('select[name="numeroPaa_vinculado"]').val()==""){
        bolean=false;
      }
    }

    if(vector_datos_actividad.length > 0 && bolean==true){
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
                            estudioComve="disabled";
                          }else if(e['Estado']==5){  
                            clase="success";
                            disable="disabled"; 
                            estado="Aprobado Subdireción"; 
                            estudioComve="";
                          }else if(e['Estado']==6){  
                            clase="danger";
                            disable=""; 
                            estado="Denegado Subdireción"; 
                            estudioComve="disabled";
                          }else if(e['Estado']==7){  
                            clase="danger";
                            disable="disabled"; 
                            estado="CANCELADO"; 
                            estudioComve="disabled";
                          }else{
                            estado="En Consolidación";
                            disable="";
                            estudioComve="disabled";
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
                                    '<div class="btn-group">'+
                                      '<button type="button" data-rel="'+e['Id']+'" data-funcion="EstudioComveniencia" class="btn btn-warning btn-xs2 btn-xs"  title="Estudio Conveniencia" data-toggle="modal" data-target="#Modal_EstudioComveniencia" '+estudioComve+'><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                  '</div>'+
                                  '<div>'+
                                    '<a href="#" class="btn btn-xs btn-default" style="width: 100%;    margin-top: 20px;" data-rel="'+e['Registro']+'" data-funcion="Observaciones"><span class="glyphicon glyphicon-info-sign"></span> Observaciones</a>'+
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
                          $('#Modal_AgregarNuevo').modal('hide');
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
            if(bolean==false){
              $('#alert_actividad').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> No se ha registrado ninguna actividad (N° Paa) vinculada. (Se vincula con otro contrato de otra área?)</div>');
              $('#mensaje_actividad').show();
              setTimeout(function(){
                  $('#mensaje_actividad').hide();
              }, 6000)
            }
            else{
              $('#alert_actividad').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> No se ha registrado ninguna fuente de financiación.</div>');
              $('#mensaje_actividad').show();
              setTimeout(function(){
                  $('#mensaje_actividad').hide();
              }, 6000)
            }
    }

      e.preventDefault();
  });
 
  

  $('#radio_compartido .btn').on('click', function(e)
  {
    $('input[name="compartido"]').removeAttr('checked');
    $(this).find('input[name="compartido"]').attr('checked', 'checked');
  });


  $('#radio_vinculado .btn').on('click', function(e)
  {
    $('input[name="vinculado"]').removeAttr('checked');
    $(this).find('input[name="vinculado"]').attr('checked', 'checked');
    alert($(this).find('input[name="vinculado"]').val());
    if($(this).find('input[name="vinculado"]').val()==0){
      $('#busqPaa').show();
      $('select[name="subDirecion_vinculado"]').val("");
      $('select[name="area_vinculado"]').val("");
      $('select[name="numeroPaa_vinculado"]').val("");
      //$('#comment').removeAttr("readonly", "readonly");
      //$('#comment').val("");
    }else{
      $('select[name="subDirecion_vinculado"]').val("");
      $('select[name="area_vinculado"]').val("");
      $('select[name="numeroPaa_vinculado"]').val("");
      $('#comment').removeAttr("readonly", "readonly");
      $('#comment').val("");
      $('#busqPaa').hide();
    }

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

    $('select[name="subDirecion_vinculado"]').on('change', function(e){
        select_Area($(this).val());
    });

    var select_Area = function(id)
    { 
        $.ajax({
            url: URL+'/service/select_area/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Seleccionar</option>';
                $.each(data.areas, function(i, eee){
                      html += '<option value="'+eee['id']+'">'+eee['nombre'].toLowerCase()+'</option>';
                });   
                $('select[name="area_vinculado"]').html(html).val($('select[name="area_vinculado"]').data('value'));
            }
        });
    };

    $('select[name="numeroPaa_vinculado"]').on('click', function(e){
         var valor=$(this).val();
         alert("dfdg");
         if(valor==""){
           $('#comment').removeAttr("readonly", "readonly");
           $('#comment').val("");
         }
         else{
            $.get(
                URL+'/service/obtenerPaaVincu/'+valor,
                {},
                function(data)
                {
                    if(data)
                    {
                        //console.log(data[0]['ObjetoContractual']);
                        $('#comment').val(data[0]['ObjetoContractual']);
                        $('#comment').attr("readonly", "readonly");
                    }
                },
                'json'
            );
         }
    });

    $('select[name="area_vinculado"]').on('change', function(e){
        select_Paa($(this).val());
    });

    var select_Paa = function(id)
    { 
        $.ajax({
            url: URL+'/service/select_paa/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                //cconsole.log(data);
                var html = '<option value="">Seleccionar</option>';
                var obje="";
                $.each(data.paas, function(i, eee){
                      if(eee['ObjetoContractual'].length<145){
                        obje=eee['Id_paa']+".  "+eee['ObjetoContractual'];
                      }
                      else{
                        obje=eee['Id_paa']+".  "+eee['ObjetoContractual'].substr(1,145)+"  .....";
                      }

                      html += '<option value="'+eee['Id_paa']+'">'+obje+'</option>';
                });   
                $('select[name="numeroPaa_vinculado"]').html(html).val($('select[name="numeroPaa_vinculado"]').data('value'));
            }
        });
    };


    $('select[name="Proyecto_inversion"]').on('change', function(e){
        select_Meta($(this).val());
    });


    var select_Meta = function(id)
    { 
        $.ajax({
            url: URL+'/service/select_meta/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Seleccionar</option>';
                $.each(data.metas, function(i, eee){
                      html += '<option value="'+eee['Id']+'">'+eee['Nombre'].toLowerCase()+'</option>';
                });   
                $('select[name="meta"]').html(html).val($('select[name="meta"]').data('value'));
            }
        });
    };


    $('select[name="Fuente_inversion"]').on('change', function(e){
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
                console.log(data);
                var html = '<option value="">Seleccionar</option>';
          
                        $.each(data.componentes, function(i, eee){
                                    html += '<option value="'+eee['Id']+'">'+eee['Nombre'].toLowerCase()+'</option>';
                                    $('input[name="id_pivot_comp"]').val(eee['Id']);
                        });
                
                $('select[name="componnente"]').html(html).val($('select[name="componnente"]').data('value'));
            }
        });
    };

  $('#agregarCodigos').on('click', function(e)
  {
      $('#t_datos_actividad_codigo').hide();
      var codigo_Unspsc=$('input[name="codigo_Unspsc"]').val();
      $('input[name="codigo_Unspsc"]').val("");
      if(codigo_Unspsc===''){
          $('#alert_actividad_codigos').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Debe ingresar un codigo Unspsc para poder realizar el registro.</div>');
          $('#mensaje_actividad_codigos').show(60);
          $('#mensaje_actividad_codigos').delay(2500).hide(600);

      }else{
          $('#alert_actividad_codigos').html('<div class="alert alert-dismissible alert-success" ><strong>Bien!</strong> Codigo agregado.</div>');
          $('#mensaje_actividad_codigos').show(30);
          $('#mensaje_actividad_codigos').delay(1000).hide(300);
          vector_datos_codigos.push({"codigo": codigo_Unspsc});
      }
  });

  $('#VerAgregarCodigos').on('click', function(e)
  {
      var html = '';
          if(vector_datos_codigos.length > 0)
          {
            var num=1;
            $.each(vector_datos_codigos, function(i, e){
              html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['codigo']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarCod" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
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
                html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['codigo']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminarCod" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
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


  $('#agregarFinanciacion').on('click', function(e)
    {
        
        var id_pivot_comp=$('input[name="id_pivot_comp"]').val();
        
        var Fuente_inversion=$('select[name="Fuente_inversion"]').val();
        var indice = form_paa.Fuente_inversion.selectedIndex;
        var Nom_Proyecto_inversion= form_paa.Fuente_inversion.options[indice].text ;

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
                    $('select[name="Fuente_inversion"]').val('');
                    $('select[name="componnente"]').val('');

                    $('#alert_actividad').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato registrados con éxito. </div>');
                    $('#mensaje_actividad').show(60);
                    $('#mensaje_actividad').delay(1500).hide(600);
                    vector_datos_actividad.push({"id_Proyecto": Fuente_inversion, "Nom_Proyecto":Nom_Proyecto_inversion, "id_componente": componnente, "Nom_Componente":Nombre_componnente,"valor": valor_contrato,"id_pivot_comp":id_pivot_comp});
              }
          }
        }
        //console.log(vector_datos_actividad);
    });

   $('#Btn_Agregar_Nuevo').on('click', function(e)
    {
        $('#busqPaa').hide();
        $('#t_datos_actividad_codigo').hide();
        $('input[name="compartido"]').removeAttr('checked').parent('.btn').removeClass('active');
        $('input[name="compartido"][value="1"]').trigger('click');

        $('input[name="vinculado"]').removeAttr('checked').parent('.btn').removeClass('active');
        $('input[name="vinculado"][value="1"]').trigger('click');

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
        vector_datos_codigos.length=0;
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


     $('#TablaPAA').delegate('button[data-funcion="EstudioComveniencia"]','click',function (e){   
          var id_act = $(this).data('rel'); 
          $('#id_estudio').val(id_act);
          $('#id_Fin').text(id_act);

          $.get(
            URL+'/service/obtenerEstidioConveniencia/'+id_act,
            {},
            function(data)
            {

                if(data['id_paa']>0)
                {
                    $('#id_estudio_pass').val(id_act);
                    $('textarea[name="texta_Conveniencia"]').val(data['conveniencia']);
                    $('textarea[name="texta_Oportunidad"]').val(data['oportunidad']);
                    $('textarea[name="texta_Justificacion"]').val(data['justificacion']);
                    
                }else{
                    $('#id_estudio_pass').val(0);
                    $('textarea[name="texta_Conveniencia"]').val('');
                    $('textarea[name="texta_Oportunidad"]').val('');
                    $('textarea[name="texta_Justificacion"]').val('');
                }
            },
            'json'
        );
         
     }); 


      $('#form_agregar_estudio_comveniencia').on('submit', function(e){

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
                    } else {
                        validad_error_estidioC(data.errors);
                        $('#mjs_Observa_Fina').html('<strong>Bien!</strong> Datos registrados con exíto..');
                        $('#mjs_Observa_Fina').show();
                        setTimeout(function(){
                            $('#mjs_Observa_Fina').hide();
                            $('#Modal_EstudioComveniencia').modal('hide');
                        }, 2000)
                    }
                  }
              });
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
        vector_datos_codigos.length=0;
        var vincu=1;
        var CodigosU = datos['CodigosU'].split(",");
        for (var i=0; i < CodigosU.length; i++) {
            vector_datos_codigos.push({"codigo": CodigosU[i] });
        }
        

        $('input[name="id_Paa"]').val(datos['Id']).closest('.form-group').removeClass('has-error');
        $('input[name="id_registro"]').val(datos['Registro']).closest('.form-group').removeClass('has-error');
        $('input[name="codigo_Unspsc"]').val("").closest('.form-group').removeClass('has-error');
        $('input[name="fecha_inicial_presupuesto"]').val(datos['FechaEstudioConveniencia']).closest('.form-group').removeClass('has-error');
        $('input[name="fuente_recurso"]').val(datos['FuenteRecurso']).closest('.form-group').removeClass('has-error');
        $('input[name="valor_estimado"]').val(datos['ValorEstimado']).closest('.form-group').removeClass('has-error');
        $('input[name="valor_estimado_actualVigencia"]').val(datos['ValorEstimadoVigencia']).closest('.form-group').removeClass('has-error');
        $('input[name="estudio_conveniencia"]').val(datos['FechaEstudioConveniencia']).closest('.form-group').removeClass('has-error');
        $('input[name="fecha_inicio"]').val(datos['FechaInicioProceso']).closest('.form-group').removeClass('has-error');
        $('input[name="fecha_suscripcion"]').val(datos['FechaSuscripcionContrato']).closest('.form-group').removeClass('has-error');
        $('input[name="duracion_estimada"]').val(datos['DuracionContrato']).closest('.form-group').removeClass('has-error');
        $('input[name="numero_contratista"]').val(datos['NumeroContratista']).closest('.form-group').removeClass('has-error');
        $('input[name="datos_contacto"]').val(datos['DatosResponsable']).closest('.form-group').removeClass('has-error');

        $('select[name="recurso_humano"]').val(datos['RecursoHumano']).closest('.form-group').removeClass('has-error');
        $('select[name="modalidad_seleccion"]').val(datos['Id_ModalidadSeleccion']).closest('.form-group').removeClass('has-error');
        $('select[name="tipo_contrato"]').val(datos['Id_TipoContrato']).closest('.form-group').removeClass('has-error');
        $('select[name="vigencias_futuras"]').val(datos['VigenciaFutura']).closest('.form-group').removeClass('has-error');
        $('select[name="estado_solicitud"]').val(datos['EstadoVigenciaFutura']).closest('.form-group').removeClass('has-error');
        //$('select[name="Id_Localidad"]').val(datos['Localidad']).change();
        $('select[name="Proyecto_inversion"]').val(datos['Id_ProyectoRubro']).closest('.form-group').removeClass('has-error');
        
          var x = document.getElementById("meta");
          var option = document.createElement("option");
          option.text = datos.meta['Nombre']
          option.value = datos.meta['Id'];
          x.add(option);
          $('#meta > option[value="'+datos.meta['Id']+'"]').attr('selected', 'selected');

          //$('#numeroPaa_vinculado').html('');
          var xx = document.getElementById("numeroPaa_vinculado");
          var option1= document.createElement("option");
          option1.text = "Actividad N°. "+datos['vinculada'];
          option1.value = datos['vinculada'];
          xx.add(option1);
         $('#numeroPaa_vinculado > option[value="'+datos['vinculada']+'"]').attr('selected', 'selected');
        
        $('textarea[name="objeto_contrato"]').val("dfasdf sdfsd f sdfds 111"+datos['ObjetoContractual']).closest('.form-group').removeClass('has-error');;
        vector_datos_actividad.length=1;

        $('input[name="compartido"]').removeAttr('checked').parent('.btn').removeClass('active');
        $('input[name="compartido"][value="'+datos['compartida']+'"]').trigger('click');

        if(datos['vinculada']!="")
          vincu=0;

        $('input[name="vinculado"]').removeAttr('checked').parent('.btn').removeClass('active');
        $('input[name="vinculado"][value="'+vincu+'"]').trigger('click');

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
                            estudioComve="disabled";
                          }else if(e['Estado']==5){  
                            clase="success";
                            disable="disabled"; 
                            estado="Aprobado Subdireción"; 
                            estudioComve="";
                          }else if(e['Estado']==6){  
                            clase="danger";
                            disable=""; 
                            estado="Denegado Subdireción"; 
                            estudioComve="disabled";
                          }else if(e['Estado']==7){  
                            clase="danger";
                            disable="disabled"; 
                            estado="CANCELADO"; 
                            estudioComve="disabled";
                          }else{
                            estado="En Consolidación";
                            disable="";
                            estudioComve="disabled";
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
                                    '<div class="btn-group">'+
                                      '<button type="button" data-rel="'+e['Id']+'" data-funcion="EstudioComveniencia" class="btn btn-warning btn-xs2 btn-xs"  title="Estudio Conveniencia" data-toggle="modal" data-target="#Modal_EstudioComveniencia" '+estudioComve+'><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                  '</div>'+
                                  '<div>'+
                                    '<a href="#" class="btn btn-xs btn-default" style="width: 100%;    margin-top: 20px;" data-rel="'+e['Registro']+'" data-funcion="Observaciones"><span class="glyphicon glyphicon-info-sign"></span> Observaciones</a>'+
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
