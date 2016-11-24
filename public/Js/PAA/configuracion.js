$(function()
{
    var URL = $('#main_paa_configuracion').data('url');
    

    $('#personas').delegate('a[data-role="remover"]', 'click', function(e){
        var id = $(this).data('rel');
    });

    $('select[name="Id_Pais"]').on('change', function(e){
        popular_ciudades($(this).val());
    });

    $('input[data-role="datepicker"]').datepicker({
      dateFormat: 'yy-mm-dd',
      yearRange: "-100:+0",
      changeMonth: true,
      changeYear: true,
    });

    $('#precio').keydown(function(event) {
   if(event.shiftKey)
   {
        event.preventDefault();
   }
 
   if (event.keyCode == 46 || event.keyCode == 8)    {
   }
   else {
        if (event.keyCode < 95) {
          if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault();
          }
        } 
        else {
              if (event.keyCode < 96 || event.keyCode > 105) {
                  event.preventDefault();
              }
        }
      }
   });

    //Submit formulario único de personas
    $('#Presupuesto').on('click', function(e){
        $(this).addClass("active");
        $('#Proyecto').removeClass("active");
        $('#Meta').removeClass("active");
        $('#Actividad').removeClass("active");
        $('#Componente').removeClass("active");

        $('#Presupuesto_dv').show();
        $('#Proyecto_dv').hide();
        $('#Meta_dv').hide();
        $('#Actividad_dv').hide();
        $('#Componente_dv').hide();
    });

    $('#Proyecto').on('click', function(e){
        $(this).addClass("active");
        $('#Presupuesto').removeClass("active");
        $('#Meta').removeClass("active");
        $('#Actividad').removeClass("active");
        $('#Componente').removeClass("active");

        $('#Proyecto_dv').show();
        $('#Presupuesto_dv').hide();
        $('#Meta_dv').hide();
        $('#Actividad_dv').hide();
        $('#Componente_dv').hide();
    });

    $('#Meta').on('click', function(e){
        $(this).addClass("active");
        $('#Presupuesto').removeClass("active");
        $('#Proyecto').removeClass("active");
        $('#Actividad').removeClass("active");
        $('#Componente').removeClass("active");

        $('#Meta_dv').show();
        $('#Proyecto_dv').hide();
        $('#Presupuesto_dv').hide();
        $('#Actividad_dv').hide();
        $('#Componente_dv').hide();
    });

    $('#Actividad').on('click', function(e){
        $(this).addClass("active");
        $('#Presupuesto').removeClass("active");
        $('#Proyecto').removeClass("active");
        $('#Meta').removeClass("active");
        $('#Componente').removeClass("active");

        $('#Actividad_dv').show();
        $('#Presupuesto_dv').hide();
        $('#Meta_dv').hide();
        $('#Proyecto_dv').hide();
        $('#Componente_dv').hide();
    });

    $('#Componente').on('click', function(e){
        $(this).addClass("active");
        $('#Presupuesto').removeClass("active");
        $('#Proyecto').removeClass("active");
        $('#Meta').removeClass("active");
        $('#Actividad').removeClass("active");

        $('#Componente_dv').show();
        $('#Presupuesto_dv').hide();
        $('#Meta_dv').hide();
        $('#Proyecto_dv').hide();
        $('#Actividad_dv').hide();
    });

    var t = $('#Tabla3').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });

    var tt = $('#Tabla4').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });

    $('#form_presupuesto').on('submit', function(e){
        $.post(URL+'/validar/presupuesto',$(this).serialize(),function(data){
            if(data.status == 'error')
            {
           
                validad_error(data.errors);
           
            } else {
                //console.log(data);
                document.getElementById("form_presupuesto").reset();
                
                $("#div_Tabla3").show();
                var num=1;
                t.clear().draw();
                $.each(data, function(i, e){
                    t.row.add( [
                        '<th scope="row" class="text-center">'+num+'</th>',
                        '<td><h4>'+e['Nombre_Actividad']+'<h4></td>',
                        '<td>'+e['fecha_fin']+'</td>',
                        '<td>'+e['fecha_inicio']+'</td>',
                        '<td>'+e['presupuesto']+'</td>',
                        '<td><div class="btn-group btn-group-justified">'+
                            '<div class="btn-group">'+
                            '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_eli" class="btn btn-default btn-xs">Eliminar</button>'+
                            '</div>'+
                            '<div class="btn-group">'+
                            '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs">Modificar</button>'+
                            '</div>'+
                            '</div>'+
                            '<div id="espera'+e['Id']+'"></div>'+
                        '</td>'
                    ] ).draw( false );
                    num++;

                });
                $('#mensaje_presupuesto').show();
                setTimeout(function(){
                    $('#mensaje_presupuesto').hide();
                    $("#id_btn_presupuesto").html('Registrar');
                    $("#id_btn_presup_canc").hide();
                }, 2000)
                
            }
        },'json');

        e.preventDefault();
    });


    var validad_error = function(data)
    {
        $('#form_presupuesto .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'precio':
                    case 'fecha_final_presupuesto':
                    case 'fecha_inicial_presupuesto':
                    case 'nombre_presupuesto':
                        selector = 'input';
                    break;
                }
                $('#form_presupuesto '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }

    $('#Tabla3').delegate('button[data-funcion="ver_eli"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/presupuesto/eliminar/'+id,
            {},
            function(data)
            {   

                    if(data.status == 'error')
                    {
                        var proyects="";
                        $.each(data.datos, function(i, e){
                            proyects=proyects+'<br><li>'+e.proyectos[i]['Nombre']+'</li>';
                        });
                        $("#espera"+id).html('<div class="alert alert-danger"><strong>Error!</strong> Posee los siguientes proyectos activos.<br>'+proyects+'</div>');
                        setTimeout(function(){
                            $("#espera"+id).html('');
                        }, 4000)
                   
                    } else {
                        $("#espera"+id).html('<div class="alert alert-success"><strong>Exito!</strong>Se elimino el presupuesto correctamente.</div>');
                        setTimeout(function(){
                                $("#espera"+id).html('');
                                t.clear().draw();
                                var num=1;
                                $.each(data, function(i, e){
                                    t.row.add( [
                                        '<th scope="row" class="text-center">'+num+'</th>',
                                        '<td><h4>'+e['Nombre_Actividad']+'<h4></td>',
                                        '<td>'+e['fecha_fin']+'</td>',
                                        '<td>'+e['fecha_inicio']+'</td>',
                                        '<td>'+e['presupuesto']+'</td>',
                                        '<td><div class="btn-group btn-group-justified">'+
                                            '<div class="btn-group">'+
                                            '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_eli" class="btn btn-default btn-xs">Eliminar</button>'+
                                            '</div>'+
                                            '<div class="btn-group">'+
                                            '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs">Modificar</button>'+
                                            '</div>'+
                                            '</div>'+
                                            '<div id="espera'+e['Id']+'"></div>'+
                                        '</td>'
                                    ] ).draw( false );
                                    num++;
                                });
                        }, 2000)
                    }
            }
        );
    }); 

    $('#Tabla3').delegate('button[data-funcion="ver_upd"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/presupuesto/modificar/'+id,
            {},
            function(data)
            {   
                    $("#espera"+id).html("");
                    $('input[name="Id_presupuesto"]').val(data.Id);
                    $('input[name="nombre_presupuesto"]').val(data.Nombre_Actividad);
                    $('input[name="fecha_inicial_presupuesto"]').val(data.fecha_fin);
                    $('input[name="fecha_final_presupuesto"]').val(data.fecha_inicio);
                    $('input[name="precio"]').val(data.presupuesto);
                    $("#id_btn_presupuesto").html('Modificar');
                    $("#id_btn_presup_canc").show();
                    $("#div_Tabla3").hide();


                    $('html,body').animate({
                        scrollTop: $("#main_paa_configuracion").offset().top
                    }, 1000);
                    $( "#div_form_presupuesto" ).toggle( "highlight");            
            }
        );
    }); 

    $('#id_btn_presup_canc').on('click', function(e){
          
                    $('input[name="Id_presupuesto"]').val('0');
                    $('input[name="nombre_presupuesto"]').val('');
                    $('input[name="fecha_inicial_presupuesto"]').val('');
                    $('input[name="fecha_final_presupuesto"]').val('');
                    $('input[name="precio"]').val('');
                    $("#id_btn_presupuesto").html('Registrar');
                    $("#id_btn_presup_canc").hide();

                    $('html,body').animate({
                        scrollTop: $("#Tabla3").offset().top
                    }, 1000);
                    return false;

    }); 

   
});

