$(function()
{
    var URL = $('#main_paa_configuracion').data('url');
    

    $('#personas').delegate('a[data-role="remover"]', 'click', function(e){
        var id = $(this).data('rel');
    });

    $('select[name="Id_Pais"]').on('change', function(e){
        popular_ciudades($(this).val());
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

    $('#form_persona').on('submit', function(e){
        $("#guardar").button('loading');
        $.post(URL+'/service/procesar',$(this).serialize(),function(data){
            if(data.status == 'error')
            {
                popular_errores_modal(data.errors);
            } else {
                $('#alerta').show();
                $('#modal_form_persona').modal('hide');
                $("#guardar").button('reset');

                setTimeout(function(){
                    $('#alerta').hide();
                }, 4000)
            }
        },'json');

        e.preventDefault();
    });
    
});

