$(document).ready(function (e) {
    /*AGREGAR & EDITAR ENCUESTAS*/
    $('.ensat-enc-add-edit').click(function (e) {
        e.preventDefault();
        var encuesta_nombre=prompt('NOMBRE DE LA ENCUESTA',$(this).attr('data-nombre'));
        if(encuesta_nombre!='' && encuesta_nombre!=null){
            SendAjaxPost({
                encuesta_id:$(this).attr('data-id'),
                encuesta_nombre:encuesta_nombre,
                encuesta_estado:$(this).attr('data-estado'),
                encuesta_accion:$(this).attr('data-accion'),
                csrf_token:csrf_token
            },'Ensat/AjaxEncuesta',function (response) {
                if(response.accion=='1'){
                    msj_success_noti('DATOS GUARDADOS');
                    ActionWindowsReload();
                }
            })    
        }
    });
    /*AGREGAR & EDITAR PREGUNTAS*/
    $('.ensat-enc-preg-add-edit').click(function (e) {
        e.preventDefault();
        var pregunta_nombre=prompt('NOMBRE DE LA PREGUNTA',$(this).attr('data-pregunta'));
        if(pregunta_nombre!='' && pregunta_nombre!=null){
            SendAjaxPost({
                pregunta_id:$(this).attr('data-id'),
                pregunta_nombre:pregunta_nombre,
                encuesta_id:$(this).attr('data-enc'),
                pregunta_accion:$(this).attr('data-accion'),
                csrf_token:csrf_token
            },'Ensat/AjaxEncuestaPreguntas',function (response) {
                if(response.accion=='1'){
                    msj_success_noti('DATOS GUARDADOS');
                    ActionWindowsReload();
                }
            })    
        }
    });
    /*AGREGAR & EDITAR RESPUESTA*/
    $('.ensat-enc-preg-res-add-edit').click(function (e) {
        var icono=$(this);
        e.preventDefault();
        bootbox.confirm({
            title:'<h5><b>NUEVA PREGUNTA</b></h5>',
            message:'<div class="row">'+
                        '<div class="col-md-12 text-center" >'+
                            '<select class="form-control" name="respuesta_nombre">'+
                                '<option value="EXCELENTE">EXCELENTE</option>'+
                                '<option value="MUY BUENO">MUY BUENO</option>'+
                                '<option value="BUENO">BUENO</option>'+
                                '<option value="REGULAR">REGULAR</option>'+
                                '<option value="MALO">MALO</option>'+
                                '<option value="MUY MALO">MUY MALO</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="col-md-12"><br>'+
                            '<select class="form-control" name="respuesta_icon">'+
                                '<option value="EMO_1.png">EMO 1</option>'+
                                '<option value="EMO_2.png">EMO 2</option>'+
                                '<option value="EMO_3.png">EMO 3</option>'+
                                '<option value="EMO_4.png">EMO 4</option>'+
                                '<option value="EMO_5.png">EMO 5</option>'+
                                '<option value="EMO_6.png">EMO 6</option>'+
                                '<option value="EMO_7.png">EMO 7</option>'+
                                '<option value="EMO_8.png">EMO 8</option>'+
                                '<option value="EMO_9.png">EMO 9</option>'+
                                '<option value="EMO_10.png">EMO 10</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="col-md-12 col-img-emoji"></div>'+
                    '</div>',
            size:'small',
            buttons:{
                cancel:{
                    label:'Cancelar',
                    className:'btn-imss-cancel'
                },confirm:{
                    label:'Aceptar',
                    className:'back-imss'
                }
            },callback:function (res) {
                if(res==true){
                    var respuesta_nombre=$('body select[name=respuesta_nombre]').val();
                    if(respuesta_nombre!='' && respuesta_nombre!=null){
                        SendAjaxPost({
                            respuesta_id:icono.attr('data-id'),
                            respuesta_nombre:respuesta_nombre,
                            respuesta_icon:$('body select[name=respuesta_icon]').val(),
                            pregunta_id:icono.attr('data-pregunta'),
                            respuesta_accion:icono.attr('data-accion'),
                            csrf_token:csrf_token
                        },'Ensat/AjaxEncuestaPreguntasRespuetas',function (response) {
                            if(response.accion=='1'){
                                msj_success_noti('DATOS GUARDADOS');
                                ActionWindowsReload();
                            }
                        })    
                    }
                }
            }
        })
        $('body select[name=respuesta_nombre]').val(icono.attr('data-respuesta'));
        $('body select[name=respuesta_icon]').val(icono.attr('data-icon'));
        $('body .col-img-emoji').html('<br><center><img src="'+base_url+'assets/img/emoji/'+$('body select[name=respuesta_icon]').val()+'" style="width:30%"></center>');
        $('body select[name=respuesta_icon]').change(function (e) {
            $('body .col-img-emoji').html('<br><center><img src="'+base_url+'assets/img/emoji/'+$(this).val()+'" style="width:30%"></center>');
        })
    });
    $('body').on('click','.ensat-enc-preg-res-del',function () {
        SendAjaxPost({
            respuesta_id:$(this).attr('data-id'),
            csrf_token:csrf_token
        },'Ensat/AjaxEliminarRespuestas',function (response) {
            location.reload();
        })
    })
    $('input[name=tipo_paciente]').click(function () {
        if($(this).val()=='Identificado'){
            $('.col-folio-paciente').removeClass('hide');
        }else{
            $('.col-folio-paciente').addClass('hide');
        }
    });
    $('.ensat-encuesta-paciente').submit(function (e) {
        e.preventDefault();
        if($('input[name=tipo_paciente][value="Identificado"]').is(':checked')){
            SendAjaxPost({
                triage_id:$('input[name=triage_id]').val(),
                csrf_token:csrf_token
            },'Ensat/AjaxValidarPaciente',function (response) {
                if(response.accion=='1'){
                    location.href=base_url+'Ensat/Encuesta?tipo=Identificado&triage_id='+$('input[name=triage_id]').val()
                }else{
                    msj_error_noti('EL N° DE FOLIO ESCRITO NO EXISTE');
                }
            })
        }else{
            location.href=base_url+'Ensat/Encuesta?tipo=Anónimo&triage_id=0';
        }
    });
    var TotalRespondidas=0;
    $('body').on('click','.input-radio-save',function () {
        var Respuesta=$(this).attr('data-value').split(';');
        TotalRespondidas++;
        SendAjaxPost({
            encuesta_id:Respuesta[0],
            pregunta_id:Respuesta[1],
            respuesta_id:Respuesta[2],
            triage_tipo:$('input[name=triage_tipo]').val(),
            triage_id:$('input[name=triage_id]').val(),
            csrf_token:csrf_token
        },'Ensat/AjaxResultadoEncuestas',function (response) {
            $('input[name=TotalRespondidas]').val(TotalRespondidas);
            $('body .col_pregunta'+Respuesta[1]).addClass('hide');
            if($('input[name=TotalRespondidas]').val()==$('input[name=TotalPreguntas]').val()){
                bootbox.dialog({
                    title:'<h5><b>EVALUACIÓN FINALIZADA</b></h5>',
                    message:'<div class="row">'+
                                '<div class="col-md-12 text-center">'+
                                    '<i class="fa fa-check-square-o fa-3x text-color-imss"></i><br>'+
                                    '<h5>GRACIAS POR RESPONDER ESTA ESCUESTA</h5>'+
                                '</div>'+
                            '</div>',
                    buttons:{
                        aceptar:{
                            label:'Aceptar',
                            className:'back-imss',
                            callback:function (response) {
                                location.href=base_url+'Ensat/Paciente'
                            }
                        }
                    },
                })
            }
        },'No')
        
        
    });
    setTimeout(function () {
        launchFullScreen('');
    },2000)
    $('.pantalla-completa').click(function (e) {
        launchFullScreen(document.documentElement);
    });
    launchFullScreen('FullScreen');
    function launchFullScreen(element) {
        $('body .accion-windows').addClass('hide');
        
        if(element.requestFullScreen) {
            element.requestFullScreen();
        } else if(element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if(element.webkitRequestFullScreen) {
            element.webkitRequestFullScreen();
        }
        
    }
})