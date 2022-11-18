$(document).ready(function (e) {
    $('body').on('click','.acciones-roles',function () {
        var data_id=$(this).attr('data-id');
        var data_accion=$(this).attr('data-accion');
        var data_rol=$(this).attr('data-rol');
        
        if(data_accion=='Agregar'){
            AccionRol({
                title:'Agregar Rol',
                rol_id:data_id,
                rol_nombre:data_rol,
                accion:data_accion
            })
        }if(data_accion=='Editar'){
            AccionRol({
                title:'Editar Rol',
                rol_id:data_id,
                rol_nombre:data_rol,
                accion:data_accion
            })
        }if(data_accion=='Eliminar'){
            
        }
    })
    
    function AccionRol(info) {
        bootbox.dialog({
            title:'<h6>'+info.title+'</h6>',
            message:'<div class="row">'+
                            '<div class="col-md-12">'+
                                '<div class="form-group">'+
                                    '<input name="rol_nombre" value="'+info.rol_nombre+'" placeholder="Nombre del Nuevo Rol" class="form-control">'+
                                '</div>'+
                            '</div>'+
                        '</div>',
            size:'small',
            buttons:{
                Cancelar:{
                    label:'Cancelar'
                },Guardar:{
                    label:'Guardar',
                    callback:function (e) {
                        if($('body input[name=rol_nombre]').val()){
                            $.ajax({
                                url: base_url+"Sections/Roles/AjaxGuardar",
                                type: 'POST',
                                dataType: 'json',
                                data:{
                                    rol_id:info.rol_id,
                                    rol_nombre: $('body input[name=rol_nombre]').val(),
                                    accion: info.accion,
                                    csrf_token:csrf_token
                                },beforeSend: function (xhr) {
                                    msj_loading();
                                },success: function (data, textStatus, jqXHR) {
                                    if(data.accion=='1'){
                                        msj_success_noti('Registro Guardado');
                                        ActionWindowsReload();
                                    }
                                },error: function (error) {
                                    msj_error_serve(error())
                                }
                            })
                        }else{
                            msj_error_noti('Campo requerido')
                        }
                    }
                }
            },onEscape:function () {}
        })
    }
    
})