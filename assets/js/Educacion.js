jQuery(document).ready(function (e) {
    jQuery('.agregar-curso').submit(function (e) {
        e.preventDefault()
        $.ajax({
            url: base_url+"Educacion/AjaxAgregarCurso",
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                if(data.accion=='1'){
                    msj_success_noti('REGISTRO GUARDADO');
                    location.href=base_url+'Educacion/Cursos';
                }
            },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    })
    $('input[name=empleado_matricula]').focus();
    $('.btn-add-usuario').click(function (e) {
        
        e.preventDefault()
        var empleado_matricula=$('input[name=empleado_matricula]').val();
        
        var curso_id=$('input[name=empleado_matricula]').attr('data-curso');
        if(empleado_matricula!=''){
            $.ajax({
                url: base_url+"Educacion/AjaxBuscarUsuario",
                type: 'POST',
                dataType: 'json',
                data:{
                    empleado_matricula:empleado_matricula,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.accion=='1'){
                        $.ajax({
                            url: base_url+"Educacion/AjaxCursoUsuario",
                            type: 'POST',
                            dataType: 'json',
                            data:{
                                csrf_token:csrf_token,
                                empleado_matricula:empleado_matricula,
                                curso_id:curso_id
                            },beforeSend: function (xhr) {
                                msj_loading()
                            },success: function (data, textStatus, jqXHR) {
                                bootbox.hideAll();
                                if(data.accion=='1'){
                                    msj_success_noti('USUARIO AGREGADO');
                                    ActionWindowsReload();
                                }else{
                                    msj_error_noti('EL USUARIO YA ESTA AGREGADO A ESTE CURSO')
                                }
                            },error: function (e) {
                                msj_error_serve();
                                console.log(e);
                            }
                        })
                    }else{
                        msj_error_noti('LA MATRICULA ESCTRITA NO EXISTE');
                    }
                },error: function (e) {
                    msj_error_serve();
                    bootbox.hideAll();
                    console.log(e);
                }
            })
            $('input[name=empleado_matricula]').val();
        }
    })
    $('body').on('click','.elimiar-user-curso',function () {
        var cu_id=$(this).attr('data-id');
        $.ajax({
            url: base_url+"Educacion/AjaxEliminarUsuarioCurso",
            type: 'POST',
            dataType: 'json',
            data: {
                cu_id:cu_id,
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                if(data.accion=='1'){
                    msj_success_noti('REGISTRO ELIMINADO');
                    ActionWindowsReload();
                }
            },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve();
            }
        })
    })
})