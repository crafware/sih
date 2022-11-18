$('document').ready(function() {
    $('select[name=empleado_sexo]').val($('select[name=empleado_sexo]').attr('data-value'));
    $('select[name=empleado_estado]').val($('select[name=empleado_estado]').attr('data-value'));
    $('select[name=empleado_turno]').val($('select[name=empleado_turno]').attr('data-value'));
    $('select[name=empleado_servicio]').val($('select[name=empleado_servicio]').attr('data-value'));
    if($('input[name=jtf_accion]').val()!=undefined){
        $('#rol_id').val($('#rol_id').attr('data-value').split(',')).select2(); //divide cada rol seleccinado  separado con comoa
    }
    if($('input[name=empleado_departamento]').val()!=undefined){
        $('#empleado_estado').val($('#empleado_estado').attr('data-value')).select2();
        $('#empleado_sexo').val($('#empleado_sexo').attr('data-value')).select2();
    }
    $('#registrar-usuario').submit(function (e){
        e.preventDefault()
        $.ajax({
            url: base_url+"Sections/Usuarios/GuardarUsuario",
            dataType: 'json',
            type: 'POST',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_success_noti('Guardando registro...')
            },success: function (data, textStatus, jqXHR) {
                if(data.accion=='1'){
                    msj_success_noti('Regitro guardado correctamente');
                    ActionCloseWindowsReload()
                }
            },error: function (e) {
                msj_error_serve(e)
            }
        })
    })
    if($('input[name=jtf_accion]').val()=='edit'){
        $('input[name=empleado_matricula]').attr('disabled',true);
    }
    $('input[name=empleado_matricula]').blur(function (e){
        if($(this).val()!=''){
            $.ajax({
                url: base_url+"Sections/Usuarios/VerificarMatricula",
                type: 'POST',
                dataType: 'json',
                data: {
                    'empleado_matricula':$(this).val(),
                    'csrf_token':csrf_token
                },beforeSend: function (xhr) {
                    msj_success_noti('Verificando Matricula');
                },success: function (data, textStatus, jqXHR) {
                    if(data.ACCION=='EXISTE'){
                        msj_error_noti('LA MATRICULA ESCRITA YA ESTA ASIGNADA A OTRO USUARIO')
                        $('button[type=submit]').attr('disabled',true);
                    }if(data.ACCION=='NO_EXISTE'){
                        msj_success_noti('MATRICULA DISPONIBLE')
                        $('button[type=submit]').removeAttr('disabled');
                    }
                }
            })
        }
    })
    if($('select[name=FILTRO_TIPO]').val()!=undefined){
        ObtenerUsuario()
    }
    $('.input-buscar').click(function () {
        if($('select[name=FILTRO_TIPO]').val()!=''){
            ObtenerUsuario()
        }
    })
    function ObtenerUsuario() {
        $.ajax({
            url: base_url+"Sections/Usuarios/AjaxObtenerUsuario",
            type: 'POST',
            dataType: 'json',
            data: {
                FILTRO_TIPO:$('select[name=FILTRO_TIPO]').val(),
                FILTRO_VALUE:$('input[name=FILTRO_VALUE]').val(),
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.table-usuarios tbody').html(data.tr);
                InicializeFootable('.table-usuarios');
            },error: function (e) {
                bootbox.hideAll();
                msj_error_serve(e)
            }
        });
    }
    $('.actualizar-sesiones').click(function (e) {
        e.preventDefault();
        AjaxSesiones();
    })
    if($('input[name=UsuariosModulo]').val()!=undefined && $('input[name=UsuariosModulo]').val()=='Sesiones'){
        AjaxSesiones();
    }
    function AjaxSesiones() {
        $.ajax({
            url: base_url+"Sections/Usuarios/AjaxSesiones",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.table-sessiones tbody').html(data.tr);
                InicializeFootable('.table-sessiones');
                $('.btn-sesiones-activas span').html(data.SESIONES_ACTIVAS);
            },error: function (e) {
                bootbox.hideAll();
                msj_error_serve(e)
            }
        })
    }
    $('body').on('click','.cerrar-sesion-usuario',function (e) {
        var empleado_id=$(this).attr('data-id');
        var msj='';
        if(empleado_id=='0'){
           msj='¿DESEA CERRAR TODAS LAS SESIONES?'; 
        }else{
            msj='¿DESEA CERRAR SESIÓN DE ESTE USUARIO?';
        }
        if(confirm(msj)){
            $.ajax({
                url: base_url+"Sections/Usuarios/AjaxCerrarSesion",
                type: 'POST',
                dataType: 'json',
                data:{
                    empleado_id:empleado_id,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    AjaxSesiones()
                },error: function (e) {
                    bootbox.hideAll();
                    msj_error_serve(e)
                }
            })
        }
    })
    $('body').on('click','.recargar-pagina-usuario',function (e) {
        var empleado_id=$(this).attr('data-id');
        if(confirm('¿RECARGAR PÁGINA DE ESTE USUARIO?')){
            $.ajax({
                url: base_url+"Sections/Usuarios/AjaxRecargarPagina",
                type: 'POST',
                dataType: 'json',
                data:{
                    empleado_id:empleado_id,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    AjaxSesiones()
                },error: function (e) {
                    bootbox.hideAll();
                    msj_error_serve(e)
                }
            })
        }
    })
    $('.guardar-info-perfil').submit(function (e) {
        e.preventDefault();
        if($('input[name=empleado_password]').val()==$('input[name=empleado_password_c]').val()){
            $.ajax({
                url: base_url+"Sections/Usuarios/AjaxMiPerfil",
                type: 'POST',
                dataType: 'json',
                data:$(this).serialize(),
                beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.accion=='1'){
                        ActionWindowsReload();
                        msj_success_noti('DATOS GUARDADOS');
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    msj_error_serve();
                    bootbox.hideAll();
                }
            })
        }else{
            msj_error_noti('LAS CONTRASEÑAS ESCRITAS NO COINCIDEN')
        }
    })
    $('.btn-cambiar-perfil').click(function (e) {
        AbrirDocumento(base_url+'Sections/Usuarios/CambiarPerfil');
    })
    $('body .guardar-img-perfil').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Sections/Usuarios/AjaxCambiarPerfil",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                if(data.accion=='1'){
                    window.close();
                    window.opener.location.reload();
                }
            },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve();
            }
        })
    })
    $('input[name=empleado_sc]').click(function (e) {
        if($(this).is(':checked')==true){
            $('.empleado_sc').removeClass('hide');
            $('input[name=empleado_password]').attr('required',true);
        }else{
            $('input[name=empleado_password]').removeAttr('required').val('');
            $('input[name=empleado_password_c]').val('');
            $('.empleado_sc').addClass('hide');
        }
    })
    if($('input[name=empleado_sc]').attr('data-value')=='Si'){
        console.log($('input[name=empleado_sc]').attr('data-value'))
        $('.empleado_sc').removeClass('hide');
        $('input[name=empleado_sc]').click();
    }
    $('input[name=show_hide_password]').click(function (e) {
        if($(this).is(':checked')){
            $('input[name=empleado_password]').attr('type','text');
            $('input[name=empleado_password_c]').attr('type','text');
        }else{
            $('input[name=empleado_password]').attr('type','password');
            $('input[name=empleado_password_c]').attr('type','password');
        }
    })
});