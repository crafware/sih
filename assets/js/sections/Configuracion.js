$(document).ready(function () {
    $('.inputModules').click(function () {
        if($(this).is(':checked')){
            $(this).attr('value','Si');
        }else{
            $(this).attr('value','No');
        }
    });
    $('input[type=radio]').each(function (i,e) {
        $('input[type=radio][name="'+$(this).attr('name')+'"][value="'+$(this).attr('data-value')+'"]').attr('checked',true);
    })
    $('body').on('click','.save-config-um',function (e) {
        var config_id=$(this).attr('data-id');
        var config_estatus=$(this).val();
        $.ajax({
            url: base_url+"Sections/Configuracion/AjaxGuardar",
            type: 'POST',
            dataType: 'json',
            data:{
                config_id:config_id,
                config_estatus:config_estatus,
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_success_noti('GUARDANDO CAMBIOS...');
            },success: function (data, textStatus, jqXHR) {
                if(data.accion=='1'){
                    msj_success_noti('DATOS GUARDADOS');
                }
            },error: function (e) {
                msj_error_serve();
                console.log(e)
            }
        })
    });
})