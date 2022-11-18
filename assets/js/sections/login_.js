$(document).ready(function (){
    $('.select2').select2();
    $('.btn-no-login').click(function (){
        $('.row-login').removeClass('hide');
        $('.row-no-login').addClass('hide');
    })
    var show_hide_pass=0;
    $('.show-hide-matricula').click(function (){
        show_hide_pass=show_hide_pass+1;
        if(show_hide_pass==1){
            $('input[name=empleado_matricula]').attr('type','text');
            $(this).removeClass('fa-unlock').addClass('fa-unlock-alt');
        }else{
            $('input[name=empleado_matricula]').attr('type','password');
            $(this).addClass('fa-unlock').removeClass('fa-unlock-alt');
            show_hide_pass=0;
        }
    })
    $('.tip').tooltip();
    $('.login-form').submit(function (e){
        var el=$(this);
        e.preventDefault();
        $.ajax({
            url: base_url+"sections/login/loginV2",
            dataType: 'json',
            type: 'POST',
            data:{
                'csrf_token':   $.cookie('csrf_cookie'),
                'empleado_area':$('#empleado_area').val(),
                'empleado_matricula':$('input[name=empleado_matricula]').val()
            }
            ,beforeSend: function (xhr) {
                el.find('button[type=submit]').html('<i class="fa fa-spinner fa-spin"></i> Espere por favor...').attr('disabled',true);
                el.find('input[type=text]').attr('readonly',true);
            },success:function (data){
                switch (data.ACCESS_LOGIN){
                    case 'AREA_NO_ENCONTRADA':
                        msj_error_noti('EL AREA ESCRITA NO EXISTE');
                        break;
                    case 'MATRICULA_NO_ENCONTRADA':
                        msj_error_noti('LA MATRICULA ESCRITA NO EXISTE');
                        break;
                    case 'AREA_NO_ROL':
                        msj_error_noti('NO TIENE PERMISOS PARA INGRESAR A ESTA AREA');
                        break;
                    case 'ACCESS':
                        location.href=base_url+'inicio';
                        break;  
                    case 'ACCESS_SC':
                        SolicitarPassword()
                        break;
                }
                el.find('button[type=submit]').html('Acceder').removeAttr('disabled');
                el.find('input[type=text]').removeAttr('readonly');
                
            },error: function (e) {
                console.log(e)
            }
        })
    })
    function SolicitarPassword(resul) {
        bootbox.confirm({
            title:'<h5>INGRESAR CONTRASEÑA </h5>',
            message:'<div class="row">'+
                        '<div class="col-md-12">'+
                            '<div class="input-group ">'+
                                '<span class="input-group-addon back-imss no-border">'+
                                    '<i class="fa fa-unlock-alt"></i>'+
                                '</span>'+
                                '<input type="password" id="empleado_password" class="form-control" placeholder="Ingresar Contraseña">'+
                            '</div>'+
                        '</div>'+
                    '</div>',
            size:'small',
            buttons:{
                confirm:{
                    label:'Acceder',
                    className:'back-imss'
                },cancel:{
                    label:'Cancelar',
                    className:'btn-imss-cancel'
                }
            },callback:function (res) {
                if(res==true){
                    SendAjaxPost({
                        empleado_matricula: $('input[name=empleado_matricula]').val(),
                        empleado_password:  $('body #empleado_password').val(),
                        empleado_area:      $('body #empleado_area').val(),
                        csrf_token:         $.cookie('csrf_cookie')
                    },'Sections/Login/AjaxSolicitarPassword',function (response) {
                        if(response.accion=='1'){
                            location.href=base_url+'inicio';
                        }else{
                            SolicitarPassword();
                            msj_error_noti('Contraseña incorrecta')
                        }
                    })
                }
            }

        })
    }
})
    var msj_error_noti=function (msj){
        Messenger().post({
            message: msj,
            type: 'error',
            showCloseButton: true
        }); 
    }
    var msj_error_serve=function (){
        Messenger().post({
            message: 'Error al procesar la petición al servidor',
            type: 'error',
            showCloseButton: true
        }); 
    }
    var  msj_success_noti=function (msj){
        Messenger().post({
            message: msj,
            showCloseButton: true
        }); 
    }
    var MsjNotificacion=function (title,msj){
       bootbox.dialog({
            title: '<h6>'+title+'</h6>',
            message:'<div class="row ">'+
                        '<div class="col-sm-12">'+
                            '<h6 style="line-height:2;margin-top:-6px">'+ msj+'</h6>'+
                        '</div>'+
                    '</div>'
            ,size:'small'
            ,onEscape : function() {}
        });
        $('.modal-dialog').css({
            'margin-top':'130px',
            'width':'30%'
        })
    };
    var msj_loading=function (msj){
       bootbox.dialog({
            title: '<h6>&nbsp;&nbsp;&nbsp;Espere por favor...</h6>',
            message:'<div class="row ">'+
                        '<div class="col-sm-12">'+
                            '<h6 class="text-center" style="line-height:2"><i class="fa fa-spinner fa-pulse fa-5x"></i></h6>'+
                            '<h6 class="text-center" style="line-height:2">'+(msj==undefined ? '': msj)+'</h6>'+
                        '</div>'+
                    '</div>'
            ,onEscape : function() {}
        });
        $('.modal-dialog').css({
            'margin-top':'130px',
            'width':'30%'
        })
    };

