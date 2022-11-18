$(document).ready(function (e) {
    $('.form-guardar-especialidad').submit(function (e) {
        e.preventDefault();
        SendAjax($(this).serialize(),'Sections/Especialidades/AjaxGuardarEspecialidad',function (response) {
           if(response.accion=='1'){
               window.opener.location.reload();
               window.top.close();
           } 
        },'','No')
    });
    $('input[name=especialidad_consultorios][value='+$('input[name=especialidad_consultorios]').attr('data-value')+']').attr('checked',true);
    /*Agregar Consultorio*/
    $('.form-guardar-especialidad-cons').submit(function (e) {
        e.preventDefault();
        SendAjax($(this).serialize(),'Sections/Especialidades/AjaxAgregarConsultorios',function (response) {
           if(response.accion=='1'){
               window.opener.location.reload();
               window.top.close();
           } 
        },'','No')
    });
    $('input[name=consultorio_especialidad][value='+$('input[name=consultorio_especialidad]').attr('data-value')+']').attr('checked',true);
    
    
    /*Agregar Consultorios*/
    $('.form-consultorio').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Consultorios/AjaxNuevoConsultorio",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                if(data.accion=='1'){
                    msj_success_noti('Datos Guardados')
                    ActionCloseWindowsReload();
                }
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e)
            }
        })
    });
    $('input[name=consultorio_especialidad][value='+$('input[name=consultorio_especialidad]').attr('data-value')+']').attr('checked',true);
    /*Documentos para el expediente del paciente*/
    $('.form-doc-consultorios').submit(function (e) {
        e.preventDefault();
        SendAjax($(this).serialize(),'Sections/Especialidades/AjaxDocumentosNuevo',function (response) {
            if(response.accion=='1'){
                msj_success_noti('DATOS GUARDADOS');
                window.opener.location.reload();
                window.top.close();
            }
        },'','No')
    });
    
    $('body').on('click','.pc-doc-del',function () {
        var doc_id=$(this).attr('data-id');
        if(confirm('¿ELIMIAR ESTE REGISTRO?')){
            $.ajax({
                url: base_url+"Consultorios/AjaxEliminarDocumentos",
                type: 'POST',
                dataType: 'json',
                data:{
                    doc_id:doc_id,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    if(data.accion=='1'){
                        msj_success_noti('Registro Eliminado');
                        ActionWindowsReload();
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    MsjError();
                }
            })
        }
    })
});