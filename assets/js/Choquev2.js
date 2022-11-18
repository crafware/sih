$(document).ready(function (e) {
    $('.guardar-choque-signosvitales').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url: base_url+"Choque/Choquev2/AjaxSignosVitales",
            dataType: 'json',
            type: 'POST',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                ActionCloseWindows();
                if($('input[name=accion_rol]').val()=='Choque'){
                    AjaxCamas();
                }
            },error: function (e) {
                bootbox.hideAll();
                console.log(e)
            }
        });

    })
    $('body').on('click','.actualizar-camas-choque',function (e) {
        e.preventDefault();
        AjaxCamas();
    })
    if($('input[name=accion_rol]').val()=='Choque'){
        AjaxCamas();
    }
    function AjaxCamas() {
        $.ajax({
            url: base_url+"Choque/Camasv2/AjaxCamas",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading('Obteniendo información de camas')
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.result_camas=='NO_HAY_CAMAS'){
                    $('.NO_HAY_CAMAS').removeClass('hide')
                }else{
                    $('.result_camas').html(data.result_camas);
                }
                
            },error: function (jqXHR, textStatus, errorThrown) {

            }
        })
    }
    $('body').on('click','.btn-paciente-agregar',function (){
        var cama_id=$(this).data('cama');
        var triage_id=prompt("N° Paciente",$('input[name=triage_id]').val());
        if(triage_id!='' && triage_id!=null){ 
            $.ajax({
                url: base_url+"Choque/Camasv2/AjaxObtenerPaciente",
                type: 'POST',
                dataType: 'json',
                data: {
                    triage_id : triage_id,
                    csrf_token : csrf_token
                },beforeSend: function (xhr) {
                    msj_loading()
                },success: function (data, textStatus, jqXHR) { 
                    bootbox.hideAll();
                    if(data.accion=='1'){
                        AsociarCama(triage_id,cama_id);
                    }if(data.accion=='3'){
                        msj_error_noti('EL N° DE PACIENTE YA TIENE ASIGNADO UNA CAMA');
                    }if(data.accion=='4'){
                        
                    }
                },error: function (e) {
                    msj_error_serve(e);
                    bootbox.hideAll();
                }
            }) 
        }
    
    })
    function AsociarCama(triage_id,cama_id) {
        $.ajax({
            url: base_url+"Choque/Camasv2/AjaxAsociarCama",
            type: 'POST',
            data: {
                triage_id:triage_id,
                cama_id:cama_id,
                csrf_token:csrf_token
            },dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading()
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                AjaxCamas();
            },error: function (e) {
                msj_error_serve(e);
                bootbox.hideAll();
            }
        })
    }
    $('body').on('click','.cambiar-cama-paciente',function (e) {
        e.preventDefault();
        e.preventDefault();
        var triage_id=$(this).attr('data-id');
        var area_id=$(this).attr('data-area');
        var cama_id_old=$(this).attr('data-cama');
        if(confirm('¿ESTA SEGURO QUE DESEA CAMBIAR EN N° DE CAMA?')){
            $.ajax({
                url: base_url+"Choque/Choquev2/ObtenerCamasChoque",
                type: 'POST',
                dataType: 'json',
                data:{
                    area_id:area_id,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    bootbox.confirm({
                        title:'<h5>Cambiar Cama</h5>',
                        message:'<div class="row">'+
                                    '<div class="col-md-12">'+
                                        '<div class="form-group">'+
                                            (data.accion!='2' ? '<label>Seleccionar Cama</label><select name="cama_id" class="form-control">'+data.accion+'</select>' : '<input type="hidden" name="NO_CAMAS" value=""><center><i class="fa fa-warning fa-3x" style="color:#256659"></i><br><h6>NO HAY CAMAS DIPONIBLES</h6></center>')+
                                        '</div>'+
                                    '</div>'+
                                '</div>',
                        size:'small',
                        callback:function (res) {
                            if(res==true){
                                bootbox.hideAll();
                                if($('body input[name=NO_CAMAS]').val()==undefined){
                                    $.ajax({
                                        url: base_url+"Choque/Camasv2/AjaxCambiarCama",
                                        type: 'POST',
                                        dataType: 'json',
                                        data:{
                                            triage_id:triage_id,
                                            area_id:area_id,
                                            cama_id_old:cama_id_old,
                                            cama_id_new:$('body select[name=cama_id]').val(),
                                            csrf_token:csrf_token
                                        },beforeSend: function (xhr) {
                                            msj_loading()
                                        },success: function (data, textStatus, jqXHR) {
                                            bootbox.hideAll();
                                            if(data.accion=='1'){
                                                AjaxCamas()
                                            }
                                        },error: function (e) {
                                           bootbox.hideAll();
                                            msj_error_serve(e)
                                        }
                                    })
                                }else{
                                    msj_error_noti('NO HAY CAMAS DISPONIBLES.');
                                }
                            }
                        }
                    })
                },error: function (e) {
                    bootbox.hideAll();
                    msj_error_serve(e)
                }
            })
            
        }
    })
    $('body').on('click','.cambiar-enfermera',function () {
        var triage_id=$(this).attr('data-id');
        if(confirm('¿ESTA SEGURO QUE DESEA CAMBIAR DE ENFERMERO(A)?')){
            var matricula=prompt('INGRESAR MATRICULA DEL NUEVO ENFERMERO(A)');
            if(matricula!=null && matricula!=''){
                $.ajax({
                    url: base_url+"Choque/Camasv2/AjaxCambiarEnfermera",
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        triage_id:triage_id,
                        empleado_matricula:matricula,
                        csrf_token:csrf_token
                    },beforeSend: function (xhr) {
                        msj_loading('Comprobando existencia de matricula, realizando cambio de enfermero(a)')
                    },success: function (data, textStatus, jqXHR) {
                        bootbox.hideAll();
                        if(data.accion=='1'){
                            msj_success_noti('Cambios guardados')
                            AjaxCamas();
                        }if(data.accion=='2'){
                            msj_error_noti('LA MATRICULA ESCRITA NO EXISTE');
                        }
                    },error: function (e) {
                        msj_error_serve(e)
                        bootbox.hideAll();
                    }
                })
            }else{
                msj_error_noti('INGRESAR MATRICULA');
            }
        }
    })
    $('body').on('click','.add-tarjeta-identificacion',function (e) {
        var enfermedad=$(this).attr('data-enfermedad');
        var alergia=$(this).attr('data-alergia');
        var triage_id=$(this).attr('data-id');
        e.preventDefault();
        bootbox.dialog({
            title:'<h5>Tarjeta de Identificación</h5>',
            message:'<div class="row">'+
                            '<div class="col-md-12">'+
                                '<div class="form-group">'+
                                    '<label>Enfermedades Cronicodegenerativas</label>'+
                                    '<textarea class="form-control" name="ti_enfermedades" maxlength="50" rows="1">'+enfermedad+'</textarea>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>Alergias</label>'+
                                    '<textarea class="form-control" name="ti_alergias" maxlength="85" rows="2">'+alergia+'</textarea>'+
                                '</div>'+
                            '</div>'+
                        '</div>',
            buttons:{
                Cancelar:{
                    label:'Cancelar',
                    callback:function () {}
                },Guardar:{
                    label:'Guardar',
                    callback:function () {
                        var ti_enfermedades=$('body textarea[name=ti_enfermedades]').val();
                        var ti_alergias=$('body textarea[name=ti_alergias]').val();
                        bootbox.hideAll();
                        console.log("TARJETA DE IDEF:"+triage_id)
                        $.ajax({
                            url: base_url+"Choque/Choquev2/AjaxTarjetaIdentificacion",
                            type: 'POST',
                            dataType: 'json',
                            data:{
                                triage_id : triage_id,
                                ti_enfermedades : ti_enfermedades,
                                ti_alergias : ti_alergias,
                                csrf_token : csrf_token
                            },beforeSend: function (xhr) {
                                msj_loading()
                            },success: function (data, textStatus, jqXHR) {
                                bootbox.hideAll();
                                if(data.accion=='1'){
                                    AbrirDocumento(base_url+'Inicio/Documentos/TarjetaDeIdentificacionChoque/'+triage_id+'/?via=ChoqueV2');
                                    AjaxCamas();
                                }
                            },error: function (e) {
                                msj_error_serve(e);
                                bootbox.hideAll();
                            }
                        })
                    }
                }
            },onEscape:function () {}
        });
    });
    $('body').on('click','.alta-paciente',function (e){
        var triage_id=$(this).data('triage');
        var cama_id=$(this).data('cama');
        if(confirm('¿DAR DE ALTA PACIENTE?')){
            bootbox.dialog({
                title: '<h5>SELECCIONAR DESTINO</h5>',
                message:'<div class="row ">'+
                            '<div class="col-sm-12">'+
                                '<input type="radio" name="choque_alta_value" value="Alta a domicilio" id="domicilio"><label for="domicilio">Alta a domicilio</label><br>'+
                                '<input type="radio" name="choque_alta_value" value="Alta e ingreso quirófano" id="quirofano"><label for="quirofano">Alta e ingreso quirófano</label><br>'+
                                '<input type="radio" name="choque_alta_value" value="Alta e ingreso a hospitalización" id="hospitalizacion"><label for="hospitalizacion">Alta e ingreso a hospitalización</label><br> '+
                                '<input type="radio" name="choque_alta_value" value="Alta e ingreso a UCI" id="uic"><label for="uic">Alta e ingreso a UCI</label><br> '+
                                '<input type="radio" name="choque_alta_value" value="Alta e ingreso a Observación" id="obs"><label for="obs">Alta e ingreso a Observación</label><br> '+
                                '<input type="radio" name="choque_alta_value" value="Alta y Translado" id="traslado"><label for="traslado">Alta y Traslado</label><br> '+
                            '</div>'+
                        '</div>',
                size:'small',
                buttons: {
                    main: {
                        label: "Aceptar",
                        className: "btn-fw green-700",
                        callback:function(){
                            var choque_alta=$('body input[name=choque_alta]').val();
                            $.ajax({
                                url: base_url+"Choque/Choquev2/AjaxAltaPaciente",
                                type: 'POST',
                                dataType: 'json',
                                data:{
                                    choque_alta:choque_alta,
                                    cama_id:cama_id,
                                    triage_id:triage_id,
                                    csrf_token:csrf_token
                                },beforeSend: function (xhr) {
                                    msj_loading()
                                },success: function (data, textStatus, jqXHR) {
                                    bootbox.hideAll();
                                    if(data.accion=='1'){
                                        AjaxCamas();
                                    }
                                },error: function (jqXHR, textStatus, errorThrown) {
                                    msj_error_serve();
                                    bootbox.hideAll();
                                }
                            })

                        }
                    }
                }
                ,onEscape : function() {}
            });
            $('body').on('click','input[name=choque_alta_value]',function (e){
                $('input[name=choque_alta]').val($(this).val())
            }) 
        };
    })
    $('body').on('click','.finalizar-mantenimiento',function(e){
        e.preventDefault();
        var el=$(this).attr('data-id');
        if(confirm('¿DESEA FINALIZAR EL MANTENIMIENTO DE ESTA CAMA?')){
           $.ajax({
                url: base_url+"Observacion/FinalizarLimpiezaMantenimiento",
                type: 'POST',
                dataType: 'json',
                data:{id:el,csrf_token:csrf_token},
                beforeSend: function (xhr) {
                    msj_success_noti('Guardando cambios');
                },success: function (data, textStatus, jqXHR) {
                    if(data.accion=='1'){
                        AjaxCamas()
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    msj_error_serve()
                }
           })
        }
    })
    /*------------------------------------------------------------------------*/
    $('body').on('click','.asignar-cama-choque',function (e) {
        var triage_id=$(this).attr('data-id');
        if(confirm('¿ASIGNAR CAMA?')){
            $.ajax({
                url: base_url+"Choque/Choquev2/ObtenerCamasChoque",
                dataType: 'json',
                beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.accion=='2'){
                        msj_error_noti('NO HAY CAMAS DISPONIBLES');
                    }else{
                        bootbox.confirm({
                            title:'Asignar Cama',
                            message:'<div class="row">'+
                                        '<div class="col-md-12">'+
                                            '<div class="form-group">'+
                                                '<select name="cama_id" class="form-control">'+data.accion+'</select>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>',
                            size:'small',
                            callback:function (res) {
                                if(res==true){
                                    var cama_id=$('body select[name=cama_id]').val();
                                    if(cama_id!=''){
                                        $.ajax({
                                            url: base_url+"Choque/Choquev2/AjaxAsignarCama",
                                            type: 'POST',
                                            dataType: 'json',
                                            data:{
                                                triage_id:triage_id,
                                                cama_id:cama_id,
                                                csrf_token:csrf_token
                                            },beforeSend: function (xhr) {
                                                msj_loading();
                                            },success: function (data, textStatus, jqXHR) {
                                                bootbox.hideAll();
                                                msj_success_noti('CAMA ASIGNADA');
                                                ActionWindowsReload();
                                                window.location.assing("http://localhost/sih/Observacion")
                                            },error: function (jqXHR, textStatus, errorThrown) {
                                                msj_error_serve();
                                                bootbox.hideAll();
                                            }
                                        })
                                    }else{
                                        msj_error_noti('SELECCIONAR CAMA');
                                    }
                                }
                            }
                        })
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    msj_error_serve();
                    bootbox.hideAll();
                }
            })
        }
    })
    $('.btn-add-signo-vital').click(function (e) {
        e.preventDefault();
        AjaxSignosVitales({
            sv_id:0,
            sv_ta:'',
            sv_temp:'',
            sv_fc:'',
            sv_fr:'',
            triage_id:$(this).attr('data-triage'),
            accion:'add',
        })
    })
    function AjaxSignosVitales(info) {
        bootbox.confirm({
            title:'<h5><b>SIGNOS VITALES</b></h5>',
            message:'<div class="row">'+
                        '<div class="col-sm-6">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                '<label><b>TENSIÓN ARTERIAL</b></label>'+
                                '<input class="form-control" name="sv_ta"  value="'+info.sv_ta+'">'+   
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-6">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                '<label><b>TEMPERATURA</b> </label>'+
                                '<input class="form-control"  name="sv_temp"  value="'+info.sv_temp+'">  '+ 
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-6">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                '<label><b>FRECUENCIA CARDIACA O PULSO</b></label>'+
                                '<input class="form-control" name="sv_fc"  value="'+info.sv_fc+'">  '+ 
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-6">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                 '<label><b>FRECUENCIA RESPIRATORIA</b></label>'+
                                '<input class="form-control" name="sv_fr"  value="'+info.sv_fr+'">  '+ 
                            '</div>'+
                        '</div>'+
                    '</div>',
            buttons:{
                confirm:{
                    label:'Guardar'
                },cancel:{
                    label:'Cancelar'
                }
            },callback:function (res) {
                if(res==true){
                    $.ajax({
                        url: base_url+"Choque/Choquev2/AjaxSignosVitales",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            sv_id:info.sv_id,
                            sv_ta:$('body input[name=sv_ta]').val(),
                            sv_temp:$('body input[name=sv_temp]').val(),
                            sv_fc:$('input[name=sv_fc]').val(),
                            sv_fr:$('body input[name=sv_fr]').val(),
                            triage_id:info.triage_id,
                            accion:info.accion,
                            csrf_token:csrf_token
                        },beforeSend: function (xhr) {
                            msj_loading()
                        },success: function (data, textStatus, jqXHR) {
                            bootbox.hideAll();
                            msj_success_noti('SIGNOS VITALES GUARDADOS')
                            ActionWindowsReload();
                        },error: function (e) {
                            MsjError();
                            bootbox.hideAll();
                        }
                    })
                }
            }
        })
    }
    AjaxVisorCamas();
    function AjaxVisorCamas() {
        if($('input[name=accion_rol]').val()=='VisorCamas'){
            $.ajax({
                url: base_url+"Choque/Camasv2/AjaxVisorCamas",
                dataType: 'json',
                beforeSend: function (xhr) {
                    msj_loading('Obteniendo información de camas')
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.result_camas=='NO_HAY_CAMAS'){
                        $('.NO_HAY_CAMAS').removeClass('hide')
                    }else{
                        $('.row-camas-visor').html(data.result_camas);
                    }

                },error: function (jqXHR, textStatus, errorThrown) {

                }
            })
        }
    }
    $('.actualizar-visor-camas-choque').click(function (e) {
        e.preventDefault();
        AjaxVisorCamas();
    });
    $('body').on('click','.dar-mantenimiento',function(e){
        e.preventDefault();
        var el=$(this).attr('data-id');
        var accion=$(this).attr('data-accion');
        var msj;
        if(accion=='Disponible'){
            msj='¿DESEA FINALIZAR EL MANTENIMIENTO DE ESTA CAMA?';
        }else{
            msj='¿DESEA MANDAR A MANTENIMIENTO ESTA CAMA?';
        }
        if(confirm(msj)){
           $.ajax({
                url: base_url+"Pisos/Camas/AjaxLimpiezaMantenimientoCama",
                type: 'POST',
                dataType: 'json',
                data:{'id':el,'accion':accion,'csrf_token':csrf_token},
                beforeSend: function (xhr) {
                    msj_success_noti('Guardando cambios');
                },success: function (data, textStatus, jqXHR) {
                    if(data.accion=='1'){
                        AjaxVisorCamas()
                        
                        
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    msj_error_serve()
                }
           })
        }
    })
    $('.hoja-clasificacion-choque').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Sections/Documentos/AjaxHojaClasificacion",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                if(data.accion=='1'){
                    ActionCloseWindowsReload()
                    AbrirDocumento(base_url+'Inicio/Documentos/Clasificacion/'+$('input[name=triage_id]').val()+'?via=Choque')
                }
            },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    })
    
    $('body').on('click','.posible-donador',function () {
        var triage_id=$(this).attr('data-id');
        var po_donador=$(this).attr('data-donador');
        var po_criterio=$(this).attr('data-criterio');
        bootbox.confirm({
            title:'<h5>POSIBLE DONADOR</h5>',
            message:'<div class="row">'+
                        '<div class="col-md-12" style="margin-top: 0px">'+
                            '<div class="form-group">'+
                                '<label class="md-check">'+
                                    '<input type="radio" name="po_donador"  data-value="" value="Si" class="has-value">'+
                                    '<i class="indigo"></i>Si'+
                                '</label>&nbsp;&nbsp;'+
                                '<label class="md-check">'+
                                    '<input type="radio" name="po_donador" checked="" value="No" class="has-value">'+
                                    '<i class="indigo"></i>No'+
                                '</label>'+
                            '</div>'+
                            '<div class="form-group po_donador hide" style="margin-top: 0px;margin-bottom:0px">'+
                                '<select class="form-control" name="po_criterio" data-value="">'+
                                    '<option value="">Seleccionar</option>'+
                                    '<option value="Lesión encefalica severa">Lesión encefalica severa</option>'+
                                    '<option value="Glasgow">Glasgow</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                    '</div>',
            size:'small',
            buttons:{
                cancel:{
                    label:'Cancelar'
                },confirm:{
                    label:'Guardar'
                }
            },callback:function (response) {
                if(response==true){
                    var po_donador=$('body input[name=po_donador]:checked').val();
                    var po_criterio=$('body select[name=po_criterio]').val();
                    $.ajax({
                        url: base_url+"Choque/Choquev2/AjaxPosibleDonador",
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            triage_id:triage_id,
                            po_donador:po_donador,
                            po_criterio:po_criterio,
                            csrf_token:csrf_token
                        },beforeSend: function (xhr) {
                            msj_loading();
                        },success: function (data, textStatus, jqXHR) {
                            bootbox.hideAll();
                            if(data.accion=='1'){
                                msj_success_noti('DATOS GUARDADOS');
                                ActionWindowsReload();
                            }
                        },error: function (e) {
                            msj_error_serve();
                            console.log(e)
                        }
                    })
                }
            }
        })
        $('body input[name=po_donador]').click(function (e) {
            if($(this).val()=='Si'){
                $('body .po_donador').removeClass('hide');
            }else{
                $('body select[name=po_criterio]').val('');
                $('body .po_donador').addClass('hide');
            }
        })
        if(po_donador=='Si'){
            $('body input[name=po_donador][value="Si"]').attr('checked',true);
            $('body .po_donador').removeClass('hide');
            $('body select[name=po_criterio]').val(po_criterio);
        }
    });
    $('body').on('click','.imprimir-pulsera',function (e) {
        e.preventDefault();
        var empleado_matricula=prompt('CONFIRMAR MATRICULA:','');
        var triage_id=$(this).attr('data-id');
        if(empleado_matricula!=null && empleado_matricula!=''){
            $.ajax({
                url: base_url+"Observacion/AjaxVerificaMatricula",
                type: 'POST',
                dataType: 'json',
                data:{
                    csrf_token:csrf_token,
                    empleado_matricula:empleado_matricula,
                    triage_id:triage_id
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.accion=='1'){
                        bootbox.confirm({
                            title:'<h5>CONFIRMAR DATOS DEL PACIENTE</h5>',
                            message:'<div class="row">'+
                                        '<div class="col-md-12">'+
                                            '<div class="form-group" style="margin-bottom: 4px!important;">'+
                                                '<label class="mayus-bold">Nombre del paciente</label>'+
                                                '<input type="text" class="form-control" name="triage_nombre" value="'+data.info.triage_nombre+'">'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-6" style="padding-right:2px;">'+
                                            '<div class="form-group" style="margin-bottom: 4px!important;">'+
                                                '<label class="mayus-bold">A. Paterno</label>'+
                                                '<input type="text" class="form-control" name="triage_nombre_ap" value="'+data.info.triage_nombre_ap+'">'+
                                            '</div>'+
                                            '<div class="form-group" style="margin-bottom: 4px!important;">'+
                                                '<label class="mayus-bold">N.S.S</label>'+    
                                                '<input type="text" class="form-control" name="pum_nss" value="'+data.pinfo.pum_nss+'">'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-6" style="padding-left:2px;">'+
                                            '<div class="form-group" style="margin-bottom: 4px!important;">'+
                                                '<label class="mayus-bold">A. Materno</label>'+
                                                '<input type="text" class="form-control" name="triage_nombre_am" value="'+data.info.triage_nombre_am+'">'+
                                            '</div>'+
                                            '<div class="form-group" style="margin-bottom: 4px!important;">'+
                                                '<label class="mayus-bold">N.S.S AGREGADO</label>'+
                                                '<input type="text" class="form-control" name="pum_nss_agregado" value="'+data.pinfo.pum_nss_agregado+'">'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
                            ,
                            size:'small',
                            buttons:{
                                cancel:{
                                    label:'Cancelar',
                                    className:'btn-danger'
                                },confirm:{
                                    label:'Guardar e Imprimir',
                                    className:'back-imss'
                                }
                            },callback:function (response) {
                                if(response==true){
                                    var triage_nombre=$('body input[name=triage_nombre]').val();
                                    var triage_nombre_ap=$('body input[name=triage_nombre_ap]').val();
                                    var triage_nombre_am=$('body input[name=triage_nombre_am]').val();
                                    var pum_nss=$('body input[name=pum_nss]').val();
                                    var pum_nss_agregado=$('body input[name=pum_nss_agregado]').val();
                                    $.ajax({
                                        url: base_url+"Observacion/AjaxConfirmarDatos",
                                        dataType: 'json',
                                        type: 'POST',
                                        data:{
                                            empleado_matricula:empleado_matricula,
                                            triage_id:triage_id,
                                            triage_nombre:triage_nombre,
                                            triage_nombre_ap:triage_nombre_ap,
                                            triage_nombre_am:triage_nombre_am,
                                            pum_nss:pum_nss,
                                            pum_nss_agregado:pum_nss_agregado,
                                            pulsera_tipo:'Observación',
                                            csrf_token:csrf_token
                                        },beforeSend: function (xhr) {
                                            msj_loading()
                                        },success: function (data, textStatus, jqXHR) {
                                            if(data.accion=='1'){
                                                AbrirDocumento(base_url+'Inicio/Documentos/ImprimirPulsera/'+triage_id);
                                                AjaxCamas()
                                            }
                                        },error: function (jqXHR, textStatus, errorThrown) {
                                            msj_error_serve();
                                            bootbox.hideAll();
                                        }
                                    })
                                }
                            }
                        })
                    }else{
                        msj_error_noti('LA MATRICULA ESCRITA NO EXISTE');
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    msj_error_serve();
                }
            })
        }
    });
    $('body').on('click','.alta-paciente-choque-ne',function(){
        var triage_id=$(this).attr('data-id');
        if(confirm('¿ALTA PACIENTE POR MOTIVO NO ESPECIFICADO?')){
            $.ajax({
                url:base_url+'Choque/Choquev2/AjaxAltaNoEspecificado',
                type:'POST',
                dataType:'json',
                data:{
                    triage_id:triage_id,
                    csrf_token:csrf_token
                },beforeSend:function(e){
                    msj_loading();
                },success:function(data){
                    if(data.accion=='1'){
                        ActionWindowsReload();
                    }
                },error:function(error){
                    bootbox.hideAll();
                    MsjError();
                }
            })
        }
    });
    $('.paciente_choque').click(function(e) {
        var triage_id = $(this).attr('data-triageid');
        e.preventDefault();
        var url = (this).href;  
        bootbox.confirm({
            title:'<h5>AGREGAR PACIENTE</h5>',
            message:'<h5>¿DESEA AGREGAR ESTE PACIENTE A OBSERVACIÓN?</h5>',
            size:'small',
            callback:function (res) {
                if(res==true){
                    $.ajax({
                        url: base_url+"Observacion/AjaxAgregarPacienteObs",
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            triage_id:triage_id,
                            csrf_token:csrf_token
                        },beforeSend: function (xhr) {
                            msj_loading('');
                        },success: function (data, textStatus, jqXHR) {
                            bootbox.hideAll();
                            AsociarMedico(triage_id)
                            if(data.accion=='1'){
                                msj_success_noti('Paciente agregado');
                                
                            }
                            location.href = url;
                        },error: function (e) {
                            bootbox.hideAll();
                            msj_error_serve(e);
                        }
                    })
                }
            }
        })      
    });
})
function AsociarMedico(triage_id) {
        var empleado_matricula=prompt('CONFIRMAR SU MATRICULA');
        console.log(triage_id);
        if(empleado_matricula != null && empleado_matricula !=''){
            $.ajax({
                url: base_url+"Consultorios/AjaxObtenerConsultoriosV2",
                dataType: 'json',
                beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    $.ajax({
                        url: base_url+"Observacion/AjaxAsociarMedico",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            triage_id : triage_id,
                            empleado_matricula:empleado_matricula,
                            csrf_token : csrf_token
                        },beforeSend: function (xhr) {
                            msj_loading();
                        },success: function (data, textStatus, jqXHR) {
                            bootbox.hideAll();

                            if(data.accion=='1'){
                                msj_success_noti('PACIENTE AGREGADO');
                                ActionWindowsReload()
                            }if(data.accion=='2'){
                                msj_error_noti('LA MATRICULA ESCRITA NO EXISTE!');
                            }
                        },error: function (error) {
                            bootbox.hideAll();
                            msj_error_serve(error)
                        }
                    })
                    
                },error: function (e) {
                    bootbox.hideAll();
                    MsjError();
                    console.log(e)
                    ReportarError(window.location.pathname,e.responseText);
                }
            });
            
        }else{
            msj_error_noti('Confirmar Matricula');
        }
}