var GetPosAjax=null;
$(document).ready(function () {
    var cama_aislado_select='No';
    $('select[name=area_camas]').val($('select[name=area_camas]').attr('data-value'));
    $('select[name=area_modulo]').val($('select[name=area_modulo]').attr('data-value'));
    $('.form-area-guardar').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"areas/AjaxGuardarArea",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading('','No');
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.accion=='1'){
                    msj_success_noti('Registro Guardado');
                    ActionCloseWindowsReload();
                }
            },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    });
    $('body').on('click','.add-cama-area',function (e) {
        AgregarCama({
            cama_id:0,
            title:'Agregar Cama',
            nombre_cama:'',
            cama_aislado:'Si',
            cama_genero:'Sin Especificar',
            area_id:$(this).attr('data-area'),
            accion:'add'
        });
    });
    $('body').on('click','.edit-cama',function (e) {
        AgregarCama({
            cama_id:$(this).attr('data-id'),
            title:'Editar Cama',
            nombre_cama:$(this).attr('data-cama'),
            cama_aislado:$(this).attr('data-aislado'),
            cama_genero:$(this).attr('data-genero'),
            area_id:$(this).attr('data-area'),
            accion:'edit'
        });
    });
    function AgregarCama(info) {
        bootbox.confirm({
            'title':'<h5>'+info.title+'</h5>',
            'message':'<div class="row">'+
                        '<div class="col-md-12">'+
                            '<div class="form-group">'+
                                '<input type="text" placeholder="Nombre de la Cama" value="'+info.nombre_cama+'" name="cama_nombre" class="form-control">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>Cama Aislada</label>&nbsp;&nbsp;&nbsp;'+
                                '<label class="md-check">'+
                                    '<input type="radio" name="cama_aislado" value="Si">'+
                                    '<i class="green"></i>Si'+
                                '</label>&nbsp;&nbsp;'+
                                '<label class="md-check">'+
                                    '<input type="radio" name="cama_aislado" value="No" >'+
                                    '<i class="green"></i>No'+
                                '</label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<select name="cama_genero" class="form-control">'+
                                    '<option value="Sin Especificar">Sin Especificar</option>'+
                                    '<option value="Hombre">Para Hombre</option>'+
                                    '<option value="Mujer">Para Mujer</option>'+
                                    '<option value="Mixto">Mixto</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                    '</div>',
            size:'small',
            buttons:{
                cancel:{
                    label:'Cancelar',
                    className:'btn-imss-cancel'
                },confirm:{
                    label:'Guardar',
                    className:'back-imss'
                }
            },callback:function (res) {
                if(res==true){
                    var cama_nombre=$('body input[name=cama_nombre]').val();
                    var cama_aislado=cama_aislado_select;
                    var cama_genero=$('body select[name=cama_genero]').val();
                    SendAjaxPost({
                        cama_id:info.cama_id,
                        cama_nombre:cama_nombre,
                        cama_aislado:cama_aislado,
                        cama_genero:cama_genero,
                        area_id:info.area_id,
                        accion:info.accion,
                        csrf_token:csrf_token
                    },'Areas/GuardarCama',function (response) {
                        if(response.accion=='1'){
                            msj_success_noti('Registro Guardado')
                            ActionWindowsReload();
                        }
                    })
                }
            }
        })
        $('body input[name=cama_aislado]').click(function () {
            cama_aislado_select=$(this).val();
        })
        $('body select[name=cama_genero]').val(info.cama_genero);
        $('body input[name=cama_aislado][value="'+info.cama_aislado+'"]').prop("checked",true);
    }
    $('body').on('click','.del-area',function (e) {
        if(confirm('¿ELIMINAR REGISTRO Y TODAS LAS CAMAS ASOCIADOS A EL?')){
            $.ajax({
                url: base_url+"areas/EliminarArea/"+$(this).attr('data-id'),
                dataType: 'json',
                beforeSend: function (xhr) {
                    msj_loading()
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.accion=='1'){
                        msj_success_noti('Registro Eliminado');
                        ActionWindowsReload();
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    msj_error_serve();
                    bootbox.hideAll();
                }
            })
        }
    })
    $('body').on('click','.del-cama',function (e) {
        if(confirm('¿ELIMINAR REGISTRO?')){
            $.ajax({
                url: base_url+"areas/EliminarCama/"+$(this).attr('data-id'),
                dataType: 'json',
                beforeSend: function (xhr) {
                    msj_loading()
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.accion=='1'){
                        msj_success_noti('Registro Eliminado');
                        ActionWindowsReload();
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    msj_error_serve();
                    bootbox.hideAll();
                }
            })
        }
    });
    $('select[name=area_genero]').val($('select[name=area_genero]').attr('data-value'));
    $('select[name=area_modulo]').change(function (e) {
        if($(this).val()=='Observación' && $('input[name=CONFIG_ENFERMERIA_OBSERVACION]').val()=='No'){
            $('.mod-genero').removeClass('hide')
        }
    });
    if($('select[name=area_modulo]').attr('data-value')=='Observación' && $('input[name=CONFIG_ENFERMERIA_OBSERVACION]').val()=='No'){
        $('.mod-genero').removeClass('hide')
    }
//    $('.get-ajax').click(function (e) {
//         if( GetPosAjax != null ) {
//                GetPosAjax.abort();
//                GetPosAjax = null;
//        }
//        GetPosAjax=$.ajax({
//            url: base_url+"Areas/Test",
//            type: 'POST',
//            dataType: 'json',
//            data:{
//                csrf_token:csrf_token
//            },success: function (data, textStatus, jqXHR) {
//                console.log(data)
//            },error: function (e) {
//                console.log(e);
//                msj_error_serve();
//            }
//        });
//    }) 
})