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

    $('.precio').keydown(function(event) {
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
        $('#Componente_Conf').removeClass("active");

        $('#Presupuesto_dv').show();
        $('#Proyecto_dv').hide();
        $('#Meta_dv').hide();
        $('#Actividad_dv').hide();
        $('#Componente_dv').hide();
        $('#Componente_Conf_dv').hide();
    });

    $('#Proyecto').on('click', function(e){
        $(this).addClass("active");
        $('#Presupuesto').removeClass("active");
        $('#Meta').removeClass("active");
        $('#Actividad').removeClass("active");
        $('#Componente').removeClass("active");
        $('#Componente_Conf').removeClass("active");

        $('#Proyecto_dv').show();
        $('#Presupuesto_dv').hide();
        $('#Meta_dv').hide();
        $('#Actividad_dv').hide();
        $('#Componente_dv').hide();
        $('#Componente_Conf_dv').hide();
    });

    $('#Meta').on('click', function(e){
        $(this).addClass("active");
        $('#Presupuesto').removeClass("active");
        $('#Proyecto').removeClass("active");
        $('#Actividad').removeClass("active");
        $('#Componente').removeClass("active");
        $('#Componente_Conf').removeClass("active");

        $('#Meta_dv').show();
        $('#Proyecto_dv').hide();
        $('#Presupuesto_dv').hide();
        $('#Actividad_dv').hide();
        $('#Componente_dv').hide();
        $('#Componente_Conf_dv').hide();
    });

    $('#Actividad').on('click', function(e){
        $(this).addClass("active");
        $('#Presupuesto').removeClass("active");
        $('#Proyecto').removeClass("active");
        $('#Meta').removeClass("active");
        $('#Componente').removeClass("active");
        $('#Componente_Conf').removeClass("active");

        $('#Actividad_dv').show();
        $('#Presupuesto_dv').hide();
        $('#Meta_dv').hide();
        $('#Proyecto_dv').hide();
        $('#Componente_dv').hide();
        $('#Componente_Conf_dv').hide();
    });

    $('#Componente').on('click', function(e){
        $(this).addClass("active");
        $('#Presupuesto').removeClass("active");
        $('#Proyecto').removeClass("active");
        $('#Meta').removeClass("active");
        $('#Actividad').removeClass("active");
        $('#Componente_Conf').removeClass("active");

        $('#Componente_dv').show();
        $('#Presupuesto_dv').hide();
        $('#Meta_dv').hide();
        $('#Proyecto_dv').hide();
        $('#Actividad_dv').hide();
        $('#Componente_Conf_dv').hide();
    });

    $('#Componente_Conf').on('click', function(e){
        $(this).addClass("active");
        $('#Presupuesto').removeClass("active");
        $('#Proyecto').removeClass("active");
        $('#Meta').removeClass("active");
        $('#Actividad').removeClass("active");
        $('#Componente').removeClass("active");

        $('#Componente_Conf_dv').show();
        $('#Presupuesto_dv').hide();
        $('#Meta_dv').hide();
        $('#Proyecto_dv').hide();
        $('#Actividad_dv').hide();
        $('#Componente_dv').hide();
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

   


/*############################   PRESUPUESTO    ###########################*/


    $('#form_presupuesto').on('submit', function(e){
      
        $.post(URL+'/validar/presupuesto',$(this).serialize(),function(data){
            if(data.status == 'error')
            {
           
                validad_error(data.errors);
           
            } else {
                console.log(data);
                if(data.status == 'modelo')
                {
                    var datos=data.presupuesto;
                    document.getElementById("form_presupuesto").reset();                
                    $("#div_Tabla3").show();
                    var num=1;
                    t.clear().draw();
                    $.each(datos, function(i, e){
                        t.row.add( [
                            '<th scope="row" class="text-center">'+num+'</th>',
                            '<td><h4>'+e['Nombre_Actividad']+'<h4></td>',
                            '<td>'+e['fecha_fin']+'</td>',
                            '<td>'+e['fecha_inicio']+'</td>',
                            '<td>'+e['presupuesto']+'</td>',
                            '<td><div class="btn-group btn-group-justified">'+
                                '<div class="btn-group">'+
                                '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                '</div>'+
                                '<div class="btn-group">'+
                                '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
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
                }else{
                    $('#mensaje_presupuesto2').html('<strong>Error!</strong> el valor del presupuesto que intenta modificar es menor a la suma de los proyectos: $'+data.sum_proyectos);
                    $('#mensaje_presupuesto2').show();
                    setTimeout(function(){
                        $('#mensaje_presupuesto2').hide();
                    }, 6000)
                }
                
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
                            $.each(e.proyectos, function(i, ee){
                                proyects=proyects+'<br><li>'+ee['Nombre']+'</li>';
                            });
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
                                        '<td>'+e['fecha_inicio']+'</td>',
                                        '<td>'+e['fecha_fin']+'</td>',
                                        '<td>'+e['presupuesto']+'</td>',
                                        '<td><div class="btn-group btn-group-justified">'+
                                            '<div class="btn-group">'+
                                            '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                            '</div>'+
                                            '<div class="btn-group">'+
                                            '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
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
                    $("#div_Tabla3").show();

                    $('html,body').animate({
                        scrollTop: $("#Tabla3").offset().top
                    }, 1000);
                    return false;

    }); 


/*############################   PROYECTO    ###########################*/


 var tt = $('#Tabla4').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });

    $('#form_proyecto').on('submit', function(e){
        $.post(URL+'/validar/proyecto',$(this).serialize(),function(data){

            if(data.status == 'error')
            {
                validad_error2(data.errors);
            } else {
                
                if(data.status == 'modelo')
                {
                    var datos=data.presupuesto;
                    document.getElementById("form_proyecto").reset();
                    $("#div_Tabla4").show();
                    var num=1;
                    tt.clear().draw();
                    $.each(datos, function(i, e){
                        $.each(e.proyectos, function(i, ee){
                            tt.row.add( [
                                '<th scope="row" class="text-center">'+num+'</th>',
                                '<td><h4>'+e['Nombre_Actividad']+'<h4></td>',
                                '<td>'+ee['Nombre']+'</td>',
                                '<td>'+ee['fecha_inicio']+'</td>',
                                '<td>'+ee['fecha_fin']+'</td>',
                                '<td>'+ee['valor']+'</td>',
                                '<td><div class="btn-group btn-group-justified">'+
                                    '<div class="btn-group">'+
                                    '<button type="button" data-rel="'+ee['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '<div class="btn-group">'+
                                    '<button type="button" data-rel="'+ee['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '</div>'+
                                    '<div id="espera'+ee['Id']+'"></div>'+
                                '</td>'
                            ] ).draw( false );
                            num++;
                        });
                    });

                    $('#mensaje_proyecto').html('<strong>Bien!</strong> Registro creado con exíto.');
                    $('#mensaje_proyecto').show();
                    setTimeout(function(){
                        $('#mensaje_proyecto').hide();
                        $("#id_btn_proyecto").html('Registrar');
                        $("#id_btn_proyect_canc").hide();
                    }, 2000)
                    $('input[name="Id_proyecto"]').val('0');
                }else{
                    $('#mensaje_proyecto2').html('<strong>Error!</strong> el valor del proyecto que intenta ingresar $'+data.valorNuevo+' '+data.mensaje+': $'+data.saldo);
                    $('#mensaje_proyecto2').show();
                    setTimeout(function(){
                        $('#mensaje_proyecto2').hide();
                    }, 6000)
                }
                
            }
        },'json');
        e.preventDefault();
    });


    var validad_error2 = function(data)
    {
        $('#form_proyecto .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'precio_proyecto':
                    case 'fecha_final_presupuesto':
                    case 'fecha_inicial_presupuesto':
                    case 'nombre_presupuesto':
                        selector = 'input';
                    break;

                    case 'idPresupuesto':
                        selector = 'select';
                    break;
                }
                $('#form_proyecto '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }


    $('#Tabla4').delegate('button[data-funcion="ver_eli"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/proyecto/eliminar/'+id,
            {},
            function(data)
            {   

                    if(data.status == 'error')
                    {
                        var proyects="";
                        $.each(data.datos, function(i, e){
                            $.each(e.metas, function(i, ee){
                                proyects=proyects+'<br><li>'+ee['Nombre']+'</li>';
                            });
                        });
                        $("#espera"+id).html('<div class="alert alert-danger"><strong>Error!</strong> Posee los siguientes metas activas.<br>'+proyects+'</div>');
                        setTimeout(function(){
                            $("#espera"+id).html('');
                        }, 4000)
                   
                    } else {
                        $("#espera"+id).html('<div class="alert alert-success"><strong>Exito!</strong>Se elimino el proyecto correctamente.</div>');
                        setTimeout(function(){
                                $("#espera"+id).html('');
                                var num=1;
                                tt.clear().draw();
                                $.each(data, function(i, e){
                                    $.each(e.proyectos, function(i, ee){
                                        tt.row.add( [
                                            '<th scope="row" class="text-center">'+num+'</th>',
                                            '<td><h4>'+e['Nombre_Actividad']+'<h4></td>',
                                            '<td>'+ee['Nombre']+'</td>',
                                            '<td>'+ee['fecha_inicio']+'</td>',
                                            '<td>'+ee['fecha_fin']+'</td>',
                                            '<td>'+ee['valor']+'</td>',
                                            '<td><div class="btn-group btn-group-justified">'+
                                                '<div class="btn-group">'+
                                                '<button type="button" data-rel="'+ee['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                                '</div>'+
                                                '<div class="btn-group">'+
                                                '<button type="button" data-rel="'+ee['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                                '</div>'+
                                                '</div>'+
                                                '<div id="espera'+ee['Id']+'"></div>'+
                                            '</td>'
                                        ] ).draw( false );
                                        num++;
                                    });
                                });
                        }, 2000)
                    }
            }
        );
    }); 


    $('#Tabla4').delegate('button[data-funcion="ver_upd"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/proyecto/modificar/'+id,
            {},
            function(data)
            {   
                    $("#espera"+id).html("");
                    $('input[name="Id_proyecto"]').val(data.Id);
                    $('select[name="idPresupuesto"]').val(data.Id_presupuesto);
                    $('input[name="nombre_proyecto"]').val(data.Nombre);
                    $('input[name="fecha_inicial_proyecto"]').val(data.fecha_inicio);
                    $('input[name="fecha_final_proyecto"]').val(data.fecha_fin);
                    $('input[name="precio_proyecto"]').val(data.valor);
                    $("#id_btn_proyecto").html('Modificar');
                    $("#id_btn_proyect_canc").show();
                    $("#div_Tabla4").hide();


                    $('html,body').animate({
                        scrollTop: $("#main_paa_configuracion").offset().top
                    }, 1000);
                    $( "#div_form_presupuesto" ).toggle( "highlight");            
            }
        );
    }); 


    $('#id_btn_proyect_canc').on('click', function(e){
          
                    $('input[name="Id_proyecto"]').val('0');
                    $('select[name="idPresupuesto"]').val('');
                    $('input[name="nombre_proyecto"]').val('');
                    $('input[name="fecha_inicial_proyecto"]').val('');
                    $('input[name="fecha_final_proyecto"]').val('');
                    $('input[name="valor"]').val('');
                    $("#id_btn_proyecto").html('Registrar');
                    $("#id_btn_proyect_canc").hide();
                    $("#div_Tabla4").show();

                    $('html,body').animate({
                        scrollTop: $("#Tabla4").offset().top
                    }, 1000);
                    return false;

    }); 




/*############################   META    ###########################*/


 var ttt = $('#Tabla5').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });

 $('select[name="idPresupuesto_M"]').on('change', function(e){
    select_presupuesto($(this).val());
 });

 var select_presupuesto = function(id)
    { 
            $.ajax({
                url: URL+'/service/presupuesto/'+id,
                data: {},
                dataType: 'json',
                success: function(data)
                {
                    var html = '<option value="">Seleccionar</option>';
                    if(data.length > 0)
                    {
                        $.each(data, function(i, e){
                            html += '<option value="'+e['Id']+'">'+e['Nombre']+'</option>';
                        });
                    }
                    $('select[name="idProyecto_M"]').html(html).val($('select[name="idProyecto_M"]').data('value'));
                }
            });
    };


     $('#form_metas').on('submit', function(e){
        $.post(URL+'/validar/meta',$(this).serialize(),function(data){
            if(data.status == 'error')
            {
                validad_error3(data.errors);
            } else {
                
                if(data.status == 'modelo')
                {
                    var datos=data.presupuesto;
                    document.getElementById("form_metas").reset();
                    $('select[name="idProyecto_M"]').val('');
                    $("#div_Tabla5").show();
                    var num=1;
                    ttt.clear().draw();
                    $.each(datos, function(i, e){
                        $.each(e.proyectos, function(i, ee){
                            $.each(ee.metas, function(i, eee){
                                ttt.row.add( [
                                    '<th scope="row" class="text-center">'+num+'</th>',
                                    '<td>'+e['Nombre_Actividad']+'</td>',
                                    '<td>'+ee['Nombre']+'</td>',
                                    '<td><h4>'+eee['Nombre']+'</h4></td>',
                                    '<td>'+eee['fecha_inicio']+'</td>',
                                    '<td>'+eee['fecha_fin']+'</td>',
                                    '<td>'+eee['valor']+'</td>',
                                    '<td><div class="btn-group btn-group-justified">'+
                                        '<div class="btn-group">'+
                                        '<button type="button" data-rel="'+eee['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                        '</div>'+
                                        '<div class="btn-group">'+
                                        '<button type="button" data-rel="'+eee['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                        '</div>'+
                                        '</div>'+
                                        '<div id="espera_m'+eee['Id']+'"></div>'+
                                    '</td>'
                                ] ).draw( false );
                                num++;
                            });
                        });
                    });
                    $('#mensaje_meta').html('<strong>Bien!</strong> Registro creado con exíto.');
                    $('#mensaje_meta').show();
                    setTimeout(function(){
                        $('#mensaje_meta').hide();
                        $("#id_btn_meta").html('Registrar');
                        $("#id_btn_meta_canc").hide();
                    }, 2000)
                    $('input[name="Id_meta"]').val('0');
                }else{
                    $('#mensaje_meta2').html('<strong>Error!</strong> el valor de la meta que intenta ingresar $'+data.valorNuevo+' '+data.mensaje+': $'+data.saldo);
                    $('#mensaje_meta2').show();
                    setTimeout(function(){
                        $('#mensaje_meta2').hide();
                    }, 6000)
                }
                
            }
        },'json');
        e.preventDefault();
    });


      var validad_error3 = function(data)
    {
        $('#form_metas .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'precio_meta':
                    case 'fecha_final_meta':
                    case 'fecha_inicial_meta':
                    case 'nombre_meta':
                        selector = 'input';
                    break;

                    case 'idPresupuesto_M':
                    case 'idProyecto_M':
                        selector = 'select';
                    break;
                }
                $('#form_metas '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }


    $('#Tabla5').delegate('button[data-funcion="ver_eli"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera_m"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/meta/eliminar/'+id,
            {},
            function(data)
            {   
                    if(data.status == 'error')
                    {
                        var actividades="";
                        $.each(data.datos, function(i, e){
                            $.each(e.actividades, function(i, ee){
                                actividades=actividades+'<br><li>'+ee['Nombre']+'</li>';
                            });
                        });
                        $("#espera_m"+id).html('<div class="alert alert-danger"><strong>Error!</strong> Posee los siguientes actividades activas.<br>'+actividades+'</div>');
                        setTimeout(function(){
                            $("#espera_m"+id).html('');
                        }, 4000)
                   
                    } else {
                        $("#espera_m"+id).html('<div class="alert alert-success"><strong>Exito!</strong>Se elimino la meta correctamente.</div>');
                        setTimeout(function(){
                                $("#espera_m"+id).html('');
                                var num=1;
                                ttt.clear().draw();
                                var datos=data.presupuesto;
                                $.each(datos, function(i, e){
                                    $.each(e.proyectos, function(i, ee){
                                        $.each(ee.metas, function(i, eee){
                                            ttt.row.add( [
                                                '<th scope="row" class="text-center">'+num+'</th>',
                                                '<td>'+e['Nombre_Actividad']+'</td>',
                                                '<td>'+ee['Nombre']+'</td>',
                                                '<td><h4>'+eee['Nombre']+'</h4></td>',
                                                '<td>'+eee['fecha_inicio']+'</td>',
                                                '<td>'+eee['fecha_fin']+'</td>',
                                                '<td>'+eee['valor']+'</td>',
                                                '<td><div class="btn-group btn-group-justified">'+
                                                    '<div class="btn-group">'+
                                                    '<button type="button" data-rel="'+eee['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                                    '</div>'+
                                                    '<div class="btn-group">'+
                                                    '<button type="button" data-rel="'+eee['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                                    '</div>'+
                                                    '</div>'+
                                                    '<div id="espera_m'+eee['Id']+'"></div>'+
                                                '</td>'
                                            ] ).draw( false );
                                            num++;
                                        });
                                    });
                                });
                        }, 2000)
                    }
            }
        );
    }); 



    $('#Tabla5').delegate('button[data-funcion="ver_upd"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera_m"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/meta/modificar/'+id,
            {},
            function(data)
            {   

                        $("#espera_m"+id).html("");
                        $('input[name="Id_meta"]').val(data.Id);
                        $('select[name="idPresupuesto_M"]').val(data.proyecto.presupuesto.Id);//falta
                        var x = document.getElementById("idProyecto_M");
                        var option = document.createElement("option");
                        option.text = data.proyecto.Nombre;
                        option.value = data.proyecto.Id;
                        x.add(option);
                        $('#idProyecto_M > option[value="'+data.proyecto.Id+'"]').attr('selected', 'selected');
                        $('input[name="nombre_meta"]').val(data.Nombre);
                        $('input[name="fecha_inicial_meta"]').val(data.fecha_inicio);
                        $('input[name="fecha_final_meta"]').val(data.fecha_fin);
                        $('input[name="precio_meta"]').val(data.valor);
                        $("#id_btn_meta").html('Modificar');
                        $("#id_btn_meta_canc").show();
                        $("#div_Tabla5").hide();


                $('html,body').animate({
                    scrollTop: $("#main_paa_configuracion").offset().top
                }, 1000);
                $( "#div_form_metas" ).toggle( "highlight");            
            }
        );
    }); 



     $('#id_btn_meta_canc').on('click', function(e){
          
                    $('input[name="Id_meta"]').val('0');
                    $('select[name="idPresupuesto_M"]').val('');
                    $('select[name="idProyecto_M"]').val('');
                    $('input[name="nombre_meta"]').val('');
                    $('input[name="fecha_inicial_meta"]').val('');
                    $('input[name="fecha_final_meta"]').val('');
                    $('input[name="precio_meta"]').val('');
                    $("#id_btn_meta").html('Registrar');
                    $("#id_btn_meta_canc").hide();
                    $("#div_Tabla5").show();

                    $('html,body').animate({
                        scrollTop: $("#Tabla5").offset().top
                    }, 1000);
                    return false;

    }); 




/*############################   META    ###########################*/


    var tttt = $('#Tabla6').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
    });

    $('select[name="idPresupuesto_A"]').on('change', function(e){
        select_proyecto($(this).val());
    });

    var select_proyecto = function(id)
    { 
                $.ajax({
                    url: URL+'/service/presupuesto/'+id,
                    data: {},
                    dataType: 'json',
                    success: function(data)
                    {
                        var html = '<option value="">Seleccionar</option>';
                        if(data.length > 0)
                        {
                            $.each(data, function(i, e){
                                html += '<option value="'+e['Id']+'">'+e['Nombre']+'</option>';
                            });
                        }
                        $('select[name="idProyecto_A"]').html(html).val($('select[name="idProyecto_A"]').data('value'));
                    }
                });
    };


    $('select[name="idProyecto_A"]').on('change', function(e){
        select_meta($(this).val());
    });

    var select_meta = function(id)
    { 
                $.ajax({
                    url: URL+'/service/meta/'+id,
                    data: {},
                    dataType: 'json',
                    success: function(data)
                    {
                        var html = '<option value="">Seleccionar</option>';
                        if(data.length > 0)
                        {
                            $.each(data, function(i, e){
                                html += '<option value="'+e['Id']+'">'+e['Nombre']+'</option>';
                            });
                        }
                        $('select[name="idMeta_A"]').html(html).val($('select[name="idMeta_A"]').data('value'));
                    }
                });
    };

    $('#form_actividad').on('submit', function(e){
        $.post(URL+'/validar/actividad',$(this).serialize(),function(data){
            if(data.status == 'error')
            {
                validad_error3(data.errors);
            } else {
                
                if(data.status == 'modelo')
                {
                    var datos=data.presupuesto;
                    document.getElementById("form_actividad").reset();
                    $('select[name="idPresupuesto_A"]').val('');
                    $('select[name="idProyecto_A"]').val('');
                    $("#div_Tabla6").show();
                    var num=1;
                    tttt.clear().draw();
                    $.each(datos, function(i, e){
                        $.each(e.proyectos, function(i, ee){
                            $.each(ee.metas, function(i, eee){
                                $.each(eee.actividades, function(i, eeee){
                                    tttt.row.add( [
                                        '<th scope="row" class="text-center">'+num+'</th>',
                                        '<td>'+e['Nombre_Actividad']+'</td>',
                                        '<td>'+ee['Nombre']+'</td>',
                                        '<td>'+eee['Nombre']+'</td>',
                                        '<td><h4>'+eeee['Nombre']+'</h4></td>',
                                        '<td>'+eeee['fecha_inicio']+'</td>',
                                        '<td>'+eeee['fecha_fin']+'</td>',
                                        '<td>'+eeee['valor']+'</td>',
                                        '<td><div class="btn-group btn-group-justified">'+
                                            '<div class="btn-group">'+
                                            '<button type="button" data-rel="'+eeee['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                            '</div>'+
                                            '<div class="btn-group">'+
                                            '<button type="button" data-rel="'+eeee['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                            '</div>'+
                                            '</div>'+
                                            '<div id="espera_a'+eeee['Id']+'"></div>'+
                                        '</td>'
                                    ] ).draw(false);
                                    num++;
                                });
                            });
                        });
                    });
                    $('#mensaje_actividad').html('<strong>Bien!</strong> Registro creado con exíto.');
                    $('#mensaje_actividad').show();
                    setTimeout(function(){
                        $('#mensaje_actividad').hide();
                        $("#id_btn_actividad").html('Registrar');
                        $("#id_btn_actividad_canc").hide();
                    }, 2000)
                    $('input[name="Id_actividad"]').val('0');
                }else{
                    $('#mensaje_actividad2').html('<strong>Error!</strong> el valor de la actividad que intenta ingresar $'+data.valorNuevo+' '+data.mensaje+': $'+data.saldo);
                    $('#mensaje_actividad2').show();
                    setTimeout(function(){
                        $('#mensaje_actividad2').hide();
                    }, 6000)
                }
                
            }
        },'json');
        e.preventDefault();
    });


    $('#Tabla6').delegate('button[data-funcion="ver_eli"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera_a"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/actividad/eliminar/'+id,
            {},
            function(data)
            {   
                    if(data.status == 'error')
                    {
                        var actividades="";
                        $.each(data.datos, function(i, e){
                            $.each(e.componentes, function(i, ee){
                                actividades=actividades+'<br><li>'+ee['Nombre']+'</li>';
                            });
                        });
                        $("#espera_a"+id).html('<div class="alert alert-danger"><strong>Error!</strong> Posee los siguientes componentes activos.<br>'+actividades+'</div>');
                        setTimeout(function(){
                            $("#espera_a"+id).html('');
                        }, 4000)
                    } else {
                        $("#espera_a"+id).html('<div class="alert alert-success"><strong>Exito!</strong>Se elimino la actividad correctamente.</div>');
                        setTimeout(function(){
                                $("#espera_a"+id).html('');
                                var num=1;
                                tttt.clear().draw();
                                var datos=data.presupuesto;
                                $.each(datos, function(i, e){
                                    $.each(e.proyectos, function(i, ee){
                                        $.each(ee.metas, function(i, eee){
                                            $.each(eee.actividades, function(i, eeee){
                                                tttt.row.add( [
                                                    '<th scope="row" class="text-center">'+num+'</th>',
                                                    '<td>'+e['Nombre_Actividad']+'</td>',
                                                    '<td>'+ee['Nombre']+'</td>',
                                                    '<td>'+eee['Nombre']+'</td>',
                                                    '<td><h4>'+eeee['Nombre']+'</h4></td>',
                                                    '<td>'+eeee['fecha_inicio']+'</td>',
                                                    '<td>'+eeee['fecha_fin']+'</td>',
                                                    '<td>'+eeee['valor']+'</td>',
                                                    '<td><div class="btn-group btn-group-justified">'+
                                                        '<div class="btn-group">'+
                                                        '<button type="button" data-rel="'+eeee['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                                        '</div>'+
                                                        '<div class="btn-group">'+
                                                        '<button type="button" data-rel="'+eeee['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                                        '</div>'+
                                                        '</div>'+
                                                        '<div id="espera_a'+eeee['Id']+'"></div>'+
                                                    '</td>'
                                                ] ).draw(false);
                                                num++;
                                            });
                                        });
                                    });
                                });
                        }, 2000)
                    }
            }
        );
    }); 


   $('#Tabla6').delegate('button[data-funcion="ver_upd"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera_a"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/actividad/modificar/'+id,
            {},
            function(data)
            {   
                $("#espera_a"+id).html("");

                $('input[name="Id_actividad"]').val(data.Id);
                $('select[name="idPresupuesto_A"]').val(data.meta.proyecto.presupuesto.Id);//falta
                
                var x = document.getElementById("idProyecto_A");
                var option = document.createElement("option");
                option.text = data.meta.proyecto.Nombre;
                option.value = data.meta.proyecto.Id;
                x.add(option);
                $('#idProyecto_A > option[value="'+data.meta.proyecto.Id+'"]').attr('selected', 'selected');

                var y = document.getElementById("idMeta_A");
                var option2 = document.createElement("option");
                option2.text = data.meta.Nombre;
                option2.value = data.meta.Id;
                y.add(option2);
                $('#idMeta_A > option[value="'+data.meta.Id+'"]').attr('selected', 'selected');

                $('input[name="nombre_actividad"]').val(data.Nombre);
                $('input[name="fecha_inicial_actividad"]').val(data.fecha_inicio);
                $('input[name="fecha_final_actividad"]').val(data.fecha_fin);
                $('input[name="precio_actividad"]').val(data.valor);
                $("#id_btn_actividad").html('Modificar');
                $("#id_btn_actividad_canc").show();
                $("#div_Tabla6").hide();

                $('html,body').animate({
                    scrollTop: $("#main_paa_configuracion").offset().top
                }, 1000);
                $( "#div_form_actividad" ).toggle( "highlight");            
            }
        );
    }); 


    $('#id_btn_actividad_canc').on('click', function(e){
          
                    $('input[name="Id_actividad"]').val('0');
                    $('select[name="idPresupuesto_A"]').val('');
                    $('select[name="idProyecto_A"]').val('');
                    $('select[name="idMeta_A"]').val('');

                    $('input[name="nombre_actividad"]').val('');
                    $('input[name="fecha_inicial_actividad"]').val('');
                    $('input[name="fecha_final_actividad"]').val('');
                    $('input[name="precio_actividad"]').val('');
                    $("#id_btn_actividad").html('Registrar');
                    $("#id_btn_actividad_canc").hide();
                    $("#div_Tabla6").show();

                    $('html,body').animate({
                        scrollTop: $("#Tabla6").offset().top
                    }, 1000);
                    return false;

    }); 






/*############################   COMPONENTE    ###########################*/


    var ttttt = $('#Tabla7').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
    });

    $('select[name="idPresupuesto_C"]').on('change', function(e){
        select_proyecto_2($(this).val());
    });

    var select_proyecto_2 = function(id)
    { 
                $.ajax({
                    url: URL+'/service/presupuesto/'+id,
                    data: {},
                    dataType: 'json',
                    success: function(data)
                    {
                        var html = '<option value="">Seleccionar</option>';
                        if(data.length > 0)
                        {
                            $.each(data, function(i, e){
                                html += '<option value="'+e['Id']+'">'+e['Nombre']+'</option>';
                            });
                        }
                        $('select[name="idProyecto_C"]').html(html).val($('select[name="idProyecto_C"]').data('value'));
                    }
                });
    };




    $('select[name="idProyecto_C"]').on('change', function(e){
        select_meta_2($(this).val());
    });

    var select_meta_2 = function(id)
    { 
                $.ajax({
                    url: URL+'/service/meta/'+id,
                    data: {},
                    dataType: 'json',
                    success: function(data)
                    {
                        var html = '<option value="">Seleccionar</option>';
                        if(data.length > 0)
                        {
                            $.each(data, function(i, e){
                                html += '<option value="'+e['Id']+'">'+e['Nombre']+'</option>';
                            });
                        }
                        $('select[name="idMeta_C"]').html(html).val($('select[name="idMeta_C"]').data('value'));
                    }
                });
    };



    $('select[name="idMeta_C"]').on('change', function(e){
        select_actividad_2($(this).val());
    });

    var select_actividad_2 = function(id)
    { 
                $.ajax({
                    url: URL+'/service/actividad/'+id,
                    data: {},
                    dataType: 'json',
                    success: function(data)
                    {
                        var html = '<option value="">Seleccionar</option>';
                        if(data.length > 0)
                        {
                            $.each(data, function(i, e){
                                html += '<option value="'+e['Id']+'">'+e['Nombre']+'</option>';
                            });
                        }
                        $('select[name="idActividad_C"]').html(html).val($('select[name="idActividad_C"]').data('value'));
                    }
                });
    };

    $('#form_componente').on('submit', function(e){
        $.post(URL+'/validar/componente',$(this).serialize(),function(data){
            if(data.status == 'error')
            {
                validad_error6(data.errors);
            } else {
                validad_error6(data.errors);
                if(data.status == 'modelo')
                {
                    var datos=data.presupuesto;
                    console.log(datos);
                    document.getElementById("form_componente").reset();
                    $('select[name="idPresupuesto_A"]').val('');
                    $('select[name="idProyecto_A"]').val('');
                    $("#div_Tabla7").show();
                    var num=1;
                    ttttt.clear().draw();
                    $.each(datos, function(i, e){
                        $.each(e.proyectos, function(i, ee){
                            $.each(ee.metas, function(i, eee){
                                $.each(eee.actividades, function(i, eeee){
                                    $.each(eeee.componentes, function(i, eeeee){
                                        ttttt.row.add( [
                                            '<th scope="row" class="text-center">'+num+'</th>',
                                            '<td>'+e['Nombre_Actividad']+'</td>',
                                            '<td>'+ee['Nombre']+'</td>',
                                            '<td>'+eee['Nombre']+'</td>',
                                            '<td>'+eeee['Nombre']+'</td>',
                                            '<td><h4>'+eeeee['Nombre']+'</h4></td>',
                                            '<td>'+eeeee.pivot['valor']+'</td>',
                                            '<td><div class="btn-group btn-group-justified">'+
                                                '<div class="btn-group">'+
                                                '<button type="button" data-rel="'+eeeee['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                                '</div>'+
                                                '<div class="btn-group">'+
                                                '<button type="button" data-rel="'+eeeee['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                                '</div>'+
                                                '</div>'+
                                                '<div id="espera_a'+eeeee['Id']+'"></div>'+
                                            '</td>'
                                        ] ).draw(false);
                                        num++;
                                    });
                                });
                            });
                        });
                    });
                    $('#mensaje_componente').html('<strong>Bien!</strong> Registro creado con exíto.');
                    $('#mensaje_componente').show();
                    setTimeout(function(){
                        $('#mensaje_componente').hide();
                        $("#id_btn_componente").html('Registrar');
                        $("#id_btn_componente_canc").hide();
                    }, 2000)
                    $('input[name="Id_actividad"]').val('0');
                }else{
                    $('#mensaje_componente2').html('<strong>Error!</strong> el valor del componente que intenta ingresar $'+data.valorNuevo+' '+data.mensaje+': $'+data.saldo);
                    $('#mensaje_componente2').show();
                    setTimeout(function(){
                        $('#mensaje_componente2').hide();
                    }, 6000)
                }
                
            }
        },'json');
        e.preventDefault();
    });


    var validad_error6 = function(data)
    {
        $('#form_componente .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'precio_componente':
                    case 'fecha_final_componente':
                    case 'fecha_inicial_componente':
                        selector = 'input';
                    break;

                    case 'idActividad_C':
                    case 'idMeta_C':
                    case 'idProyecto_C':
                    case 'idPresupuesto_C':
                    case 'nombre_componente':
                        selector = 'select';
                    break;
                }
                $('#form_componente '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }


    $('#Tabla7').delegate('button[data-funcion="ver_eli"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera_c"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/componente/eliminar/'+id,
            {},
            function(data)
            {   
                    
                $("#espera_c"+id).html('<div class="alert alert-success"><strong>Exito!</strong>Se elimino la actividad correctamente.</div>');
                setTimeout(function(){
                        $("#espera_c"+id).html('');
                        var num=1;
                        var datos=data.presupuesto;
                        ttttt.clear().draw();
                        $.each(datos, function(i, e){
                            $.each(e.proyectos, function(i, ee){
                                $.each(ee.metas, function(i, eee){
                                    $.each(eee.actividades, function(i, eeee){
                                        $.each(eeee.componentes, function(i, eeeee){
                                            ttttt.row.add( [
                                                '<th scope="row" class="text-center">'+num+'</th>',
                                                '<td>'+e['Nombre_Actividad']+'</td>',
                                                '<td>'+ee['Nombre']+'</td>',
                                                '<td>'+eee['Nombre']+'</td>',
                                                '<td>'+eeee['Nombre']+'</td>',
                                                '<td><h4>'+eeeee['Nombre']+'</h4></td>',
                                                '<td>'+eeeee['fecha_inicio']+'</td>',
                                                '<td>'+eeeee['fecha_fin']+'</td>',
                                                '<td>'+eeeee['valor']+'</td>',
                                                '<td><div class="btn-group btn-group-justified">'+
                                                    '<div class="btn-group">'+
                                                    '<button type="button" data-rel="'+eeeee['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                                    '</div>'+
                                                    '<div class="btn-group">'+
                                                    '<button type="button" data-rel="'+eeeee['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                                    '</div>'+
                                                    '</div>'+
                                                    '<div id="espera_c'+eeeee['Id']+'"></div>'+
                                                '</td>'
                                            ] ).draw(false);
                                            num++;
                                        });
                                    });
                                });
                            });
                        });
                }, 2000)
                    
            }
        );
    }); 


    $('#Tabla7').delegate('button[data-funcion="ver_upd"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera_c"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/componente/modificar/'+id,
            {},
            function(data)
            {   
                $("#espera_c"+id).html("");

                $('input[name="Id_componente"]').val(data.Id);
                $('select[name="idPresupuesto_C"]').val(data.actividad.meta.proyecto.presupuesto.Id);//falta
                
                var x = document.getElementById("idProyecto_C");
                var option = document.createElement("option");
                option.text = data.actividad.meta.proyecto.Nombre;
                option.value = data.actividad.meta.proyecto.Id;
                x.add(option);
                $('#idProyecto_C > option[value="'+data.actividad.meta.proyecto.Id+'"]').attr('selected', 'selected');

                var y = document.getElementById("idMeta_C");
                var option2 = document.createElement("option");
                option2.text = data.actividad.meta.Nombre;
                option2.value = data.actividad.meta.Id;
                y.add(option2);
                $('#idMeta_C > option[value="'+data.actividad.meta.Id+'"]').attr('selected', 'selected');

                var z = document.getElementById("idActividad_C");
                var option2 = document.createElement("option");
                option2.text = data.actividad.Nombre;
                option2.value = data.actividad.Id;
                z.add(option2);
                $('#idActividad_C > option[value="'+data.actividad.Id+'"]').attr('selected', 'selected');

                $('input[name="nombre_componente"]').val(data.Nombre);
                $('input[name="fecha_inicial_componente"]').val(data.fecha_inicio);
                $('input[name="fecha_final_componente"]').val(data.fecha_fin);
                $('input[name="precio_componente"]').val(data.valor);
                $("#id_btn_componente").html('Modificar');
                $("#id_btn_componente_canc").show();
                $("#div_Tabla7").hide();

                $('html,body').animate({
                    scrollTop: $("#main_paa_configuracion").offset().top
                }, 1000);
                $( "#div_form_componente" ).toggle( "highlight");            
            }
        );
    }); 


    $('#id_btn_componente_canc').on('click', function(e){
          
                    $('input[name="Id_componente"]').val('0');
                    $('select[name="idPresupuesto_C"]').val('');
                    $('select[name="idProyecto_C"]').val('');
                    $('select[name="idMeta_C"]').val('');
                    $('select[name="idActividad_C"]').val('');

                    $('input[name="nombre_componente"]').val('');
                    $('input[name="fecha_inicial_componente"]').val('');
                    $('input[name="fecha_final_componente"]').val('');
                    $('input[name="precio_componente"]').val('');
                    $("#id_btn_componente").html('Registrar');
                    $("#id_btn_componente_canc").hide();
                    $("#div_Tabla7").show();

                    $('html,body').animate({
                        scrollTop: $("#Tabla7").offset().top
                    }, 1000);
                    return false;

    }); 



    /*############################   CREAR COMPONENTE    ###########################*/


    var ttTttt = $('#Tabla8').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
    });

    $('#form_componente_crear').on('submit', function(e){
        $.post(URL+'/validar/componente_crear',$(this).serialize(),function(data){
            if(data.status == 'error')
            {
                validad_error8(data.errors);
            }
            else 
            {
                validad_error8(data.errors);
                if(data.status == 'modelo')
                {
                    var datos=data.componentes;
                    document.getElementById("form_componente_crear").reset();
                    $("#div_Tabla8").show();
                    var num=1;
                    ttTttt.clear().draw();
                    $.each(datos, function(i, e){
                        
                            ttTttt.row.add([
                                '<th scope="row" class="text-center">'+num+'</th>',
                                '<td>'+e['codigo']+'</td>',
                                '<td>'+e['Nombre']+'</td>',
                                '<td>'+e.fuente['nombre']+'</td>',
                                '<td><div class="btn-group btn-group-justified">'+
                                    '<div class="btn-group">'+
                                    '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '<div class="btn-group">'+
                                    '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                    '</div>'+
                                    '</div>'+
                                    '<div id="espera_crear'+e['Id']+'"></div>'+
                                '</td>'
                            ]).draw(false);
                            num++;
                        
                    });
                    $('#mensaje_componente_crear').html('<strong>Bien!</strong> Registro creado con exíto.');
                    $('#mensaje_componente_crear').show();
                    setTimeout(function(){
                        $('#mensaje_componente_crear').hide();
                        $("#id_btn_componente_crear").html('Registrar');
                        $("#id_btn_componente_canc_crear").hide();
                    }, 2000)
                    $('input[name="Id_componente_crear"]').val('0');
                }else{
                    $('#mensaje_componente2_crear').html('<strong>Error!</strong> el valor del componente que intenta ingresar $'+data.valorNuevo+' '+data.mensaje+': $'+data.saldo);
                    $('#mensaje_componente2_crear').show();
                    setTimeout(function(){
                        $('#mensaje_componente2_crear').hide();
                    }, 6000)
                }
            }
        },'json');
        e.preventDefault();
    });


    var validad_error8 = function(data)
    {
        $('#form_componente_crear .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {

                    case 'codigo_componente_crear':
                    case 'nombre_componente_crear':
                        selector = 'input';
                    break;

                    case 'idFuenteF_C':
                        selector = 'select';
                    break;
                }
                $('#form_componente_crear '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }


    $('#Tabla8').delegate('button[data-funcion="ver_eli"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera_crear"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/componente_crear/eliminar/'+id,
            {},
            function(data)
            {   
                    
                $("#espera_crear"+id).html('<div class="alert alert-success"><strong>Exito!</strong>Se elimino el componente correctamente.</div>');
                setTimeout(function(){
                        $("#espera_crear"+id).html('');
                        var num=1;
                        ttTttt.clear().draw();
                        var datos=data.componentes;
                        $.each(datos, function(i, e){
                            
                                ttTttt.row.add([
                                    '<th scope="row" class="text-center">'+num+'</th>',
                                    '<td>'+e['codigo']+'</td>',
                                    '<td>'+e['Nombre']+'</td>',
                                    '<td>'+e.fuente['nombre']+'</td>',
                                    '<td><div class="btn-group btn-group-justified">'+
                                        '<div class="btn-group">'+
                                        '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_eli" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'+
                                        '</div>'+
                                        '<div class="btn-group">'+
                                        '<button type="button" data-rel="'+e['Id']+'" data-funcion="ver_upd" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+
                                        '</div>'+
                                        '</div>'+
                                        '<div id="espera_crear'+e['Id']+'"></div>'+
                                    '</td>'
                                ]).draw(false);
                                num++;
                            
                        });
                }, 2000)
                    
            }
        );
    }); 



    $('#Tabla8').delegate('button[data-funcion="ver_upd"]','click',function (e){  
        var id = $(this).data('rel'); 
        $("#espera_crear"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/componente_crear/modificar/'+id,
            {},
            function(data)
            {   

                $("#espera_crear"+id).html("");

                $('input[name="Id_componente_crear"]').val(data.Id);

                var z = document.getElementById("idFuenteF_C");
                var option2 = document.createElement("option");
                option2.text = data.fuente.nombre;
                option2.value = data.fuente.Id;
                z.add(option2);
                $('#idFuenteF_C > option[value="'+data.fuente.Id+'"]').attr('selected', 'selected');

                $('input[name="nombre_componente_crear"]').val(data.Nombre);
                $('input[name="codigo_componente_crear"]').val(data.codigo);
         
                $("#id_btn_componente_crear").html('Modificar');
                $("#id_btn_componente_canc_crear").show();
                $("#div_Tabla8").hide();

                $('html,body').animate({
                    scrollTop: $("#main_paa_configuracion").offset().top
                }, 1000);
                $( "#div_form_componente" ).toggle( "highlight");            
            }
        );
    });


    $('#id_btn_componente_canc_crear').on('click', function(e){
          
                    $('input[name="Id_componente_crear"]').val('0');
         
                    $('input[name="nombre_componente_crear"]').val('');
                    $('input[name="codigo_componente_crear"]').val('');
                    $('select[name="idFuenteF_C"]').val('');

                    $("#id_btn_componente_crear").html('Registrar');
                    $("#id_btn_componente_canc_crear").hide();
                    $("#div_Tabla8").show();

                    $('html,body').animate({
                        scrollTop: $("#Tabla8").offset().top
                    }, 1000);
                    return false;

    }); 



});

