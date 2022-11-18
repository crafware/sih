$(document).ready(function () {
    AjaxCamas();
    function AjaxCamas() {
        $.ajax({
            url: base_url+"Areas/Enfermeria/AjaxCamas",
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
        var data_area=$(this).attr('data-area');
        var data_triage=$(this).attr('data-triage');
        var data_estatus=$(this).attr('data-accion');
        var triage_id=prompt("N° Paciente",$('input[name=triage_id]').val());
        if(triage_id!='' && triage_id!=null){ 
            if(data_estatus=='Asignado'){
                if(data_triage==triage_id){
                    AjaxAgregarPaciente(triage_id, data_estatus,cama_id,data_triage,'No Cambio',data_area);
                }else{
                    if(confirm('ESTA CAMA YA FUE ASIGNADO O RESERVADO PARA OTRO PACIENTE \n\n¿DESEA REASIGNAR OTRO PACIENTE A ESTA CAMA?')){
                        AjaxAgregarPaciente(triage_id, data_estatus,cama_id,data_triage,'Cambio',data_area);
                    }
                }  
            }else{
                AjaxAgregarPaciente(triage_id, data_estatus,cama_id,data_triage,'',data_area);
            }
            
            
        }
    
    })
    function AjaxAgregarPaciente(triage_id,data_estatus,cama_id,data_triage,accion,data_area) {
        $.ajax({
            url: base_url+"Areas/Enfermeria/AjaxObtenerPaciente",
            type: 'POST',
            dataType: 'json',
            data: {
                triage_id : triage_id,
                csrf_token : csrf_token
            },beforeSend: function (xhr) {
                msj_loading()
            },success: function (data, textStatus, jqXHR) {
                var ap_area=data.option;
                bootbox.hideAll();
                if(data.accion=='1'){
                    var empleado_matricula=prompt('CONFIRMAR MATRICULA:','')
                    if(empleado_matricula!=null && empleado_matricula!=''){
                        var ap_origen=prompt('ESPECIFICAR ORIGEN DE ENVÍO:','');
                        if(ap_origen!='' && ap_origen!=null){
                            if(data_estatus=='Asignado'){
                                AsociarCamaAH(triage_id,cama_id,empleado_matricula,ap_origen,data_triage,accion,data_area);
                            }else{
                                AsociarCama(triage_id,cama_id,empleado_matricula,ap_origen,data_area);
                            }
                        }else{
                            msj_error_noti('ESPECIFICAR ORIGEN DE ENVÍO');
                        }
                    }else{
                        msj_error_noti('CONFIRMACIÓN DE MATRICULA REQUERIDA');
                    }

                }if(data.accion=='2'){
                    if(confirm('EL N° DE PACIENTE NO EXISTE, ¿DESEA AGREGAR ESTE PACIENTE A ESTA ÁREA?')){
                        $.ajax({
                            url: base_url+"Areas/Enfermeria/AjaxAgregarPaciente",
                            type: 'POST',
                            dataType: 'json',
                            data:{
                                triage_id:triage_id,
                                csrf_token:csrf_token
                            },beforeSend: function (xhr) {
                                msj_loading('Espere por favor, Agregando paciente a esta área...');
                            },success: function (data_add, textStatus, jqXHR) {
                                bootbox.hideAll();
                                if(data_add.accion=='1'){
                                    var empleado_matricula=prompt('CONFIRMAR MATRICULA:','');
                                    if(empleado_matricula!=null && empleado_matricula!=''){
                                        var ap_origen=prompt('ESPECIFICAR ORIGEN DE ENVÍO:','')
                                        if(ap_origen!='' && ap_origen!=null){
                                            AsociarCama(triage_id,cama_id,empleado_matricula,ap_origen,data_area);
                                        }else{
                                            msj_error_noti('ESPECIFICAR ORIGEN DE ENVÍO');
                                        }
                                    }else{
                                        msj_error_noti('CONFIRMACIÓN DE MATRICULA REQUERIDA');
                                    }
                                }if(data_add.accion=='2'){
                                    msj_error_noti('EL N° DE PACIENTE NO EXISTE');
                                }
                            },error: function (e) {
                                bootbox.hideAll();
                                msj_error_serve();
                                console.log(e)
                            }
                        })
                    }
                }if(data.accion=='3'){
                    msj_error_noti('EL N° DE PACIENTE NO CORRESPONDE A ESTA ÁREA');
                }if(data.accion=='4'){
                    msj_error_noti('EL N° DE PACIENTE YA TIENE ASIGNADO UNA CAMA');
                }if(data.accion=='5'){
                    if(confirm('EL PACIENTE YA FUE DADO DE ALTA DE ESTA ÁREA, ¿DESEA REINGRESAR AL PACIENTE?')){
                        $.ajax({
                            url: base_url+"Areas/Enfermeria/AjaxReingreso",
                            type: 'POST',
                            dataType: 'json',
                            data:{
                                triage_id:triage_id,
                                csrf_token:csrf_token
                            },beforeSend: function (xhr) {
                                msj_loading('Reingresando paciente a esta área...');
                            },success: function (data, textStatus, jqXHR) {
                                bootbox.hideAll();
                                if(data.accion=='1'){
                                    var empleado_matricula=prompt('CONFIRMAR MATRICULA:','');
                                    if(empleado_matricula!=null && empleado_matricula!=''){
                                        var ap_origen=prompt('ESPECIFICAR ORIGEN DE ENVÍO:','')
                                        if(ap_origen!='' && ap_origen!=null){
                                            if(data_estatus=='Asignado'){
                                                AsociarCamaAH(triage_id,cama_id,empleado_matricula,ap_origen,data_triage,accion,data_area);
                                            }else{
                                                AsociarCama(triage_id,cama_id,empleado_matricula,ap_origen,data_area);
                                            }
                                        }else{
                                            msj_error_noti('ESPECIFICAR ORIGEN DE ENVÍO');
                                        }
                                    }else{
                                        msj_error_noti('CONFIRMACIÓN DE MATRICULA REQUERIDA');
                                    }
                                }
                            },error: function (e) {
                                msj_error_serve();
                                console.log(e)
                            }
                        })
                    }
                }
            },error: function (e) {
                msj_error_serve(e);
                bootbox.hideAll();
            }
        }) 
    }
    function SeleccionarArea(option,triage_id,cama_id,empleado_matricula,ap_origen) {
        bootbox.confirm({
            title:'<h5>Seleccionar Área</h5>',
            message:'<div class="row">'+
                        '<div class="col-xs-12">'+
                            '<div class="form-group">'+
                                '<select class="form-control" name="ap_area">'+option+'</select>'+
                            '</div>'+
                        '</div>'+
                    '</div>',
            size:'small',
            callback:function (res) {
                if(res==true){
                    var ap_area=$('body select[name=ap_area]').val();
                    AsociarCama(triage_id,cama_id,empleado_matricula,ap_origen,ap_area)
                }
            }
        })
    }
    function AsociarCama(triage_id,cama_id,empleado_matricula,ap_origen,data_area) {
        $.ajax({
            url: base_url+"Areas/Enfermeria/AjaxAsociarCama",
            type: 'POST',
            data: {
                triage_id:triage_id,
                cama_id:cama_id,
                empleado_matricula:empleado_matricula,
                ap_origen:ap_origen,
                ap_area:data_area,
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
    function AsociarCamaAH(triage_id,cama_id,empleado_matricula,ap_origen,data_triage,accion,data_area) {
        $.ajax({
            url: base_url+"Areas/Enfermeria/AjaxAsociarCamaAH",
            type: 'POST',
            data: {
                triage_id:triage_id,
                triage_id_old:data_triage,
                cama_id:cama_id,
                accion:accion,
                empleado_matricula:empleado_matricula,
                ap_origen:ap_origen,
                ap_area:data_area,
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
                url: base_url+"Observacion/ObtenerCamas",
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
                                            '<label>Seleccionar Cama</label>'+
                                            '<select name="cama_id" class="form-control">'+data.option+'</select>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>',
                        size:'small',
                        callback:function (res) {
                            if(res==true){
                                bootbox.hideAll();
                                $.ajax({
                                    url: base_url+"Areas/Enfermeria/AjaxCambiarCama",
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
                    url: base_url+"Areas/Enfermeria/AjaxCambiarEnfermera",
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
        var area_id=$(this).attr('data-area');
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
                            url: base_url+"Choque/AjaxTarjetaIdentificacion",
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
                                    AbrirDocumento(base_url+'Inicio/Documentos/TarjetaDeIdentificacionAreas/'+triage_id+'/?area='+area_id);
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
                                '<input type="radio" name="ap_alta_value" value="Alta a domicilio" id="domicilio"><label for="domicilio">Alta a domicilio</label><br>'+
                                '<input type="radio" name="ap_alta_value" value="Alta e ingreso quirófano" id="quirofano"><label for="quirofano">Alta e ingreso quirófano</label><br>'+
                                '<input type="radio" name="ap_alta_value" value="Alta e ingreso a hospitalización" id="hospitalizacion"><label for="hospitalizacion">Alta e ingreso a hospitalización</label><br> '+
                                '<input type="radio" name="ap_alta_value" value="Alta e ingreso a UCI" id="uic"><label for="uic">Alta e ingreso a UCI</label><br> '+
                                '<input type="radio" name="ap_alta_value" value="Alta e ingreso a Observación" id="obs"><label for="obs">Alta e ingreso a Observación</label><br> '+
                                '<input type="radio" name="ap_alta_value" value="Alta y Translado" id="traslado"><label for="traslado">Alta y Traslado</label><br> '+
                            '</div>'+
                        '</div>',
                size:'small',
                buttons: {
                    main: {
                        label: "Aceptar",
                        className: "btn-fw green-700",
                        callback:function(){
                            var ap_alta=$('body input[name=ap_alta]').val();
                            $.ajax({
                                url: base_url+"Areas/Enfermeria/AjaxAltaPaciente",
                                type: 'POST',
                                dataType: 'json',
                                data:{
                                    ap_alta:ap_alta,
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
            $('body').on('click','input[name=ap_alta_value]',function (e){
                $('input[name=ap_alta]').val($(this).val())
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
    /*Cambiar Área*/
    $('body').on('click','.cambiar-area',function () {
        var ap_id=$(this).attr('data-id');
        $.ajax({
            url: base_url+"Areas/Enfermeria/AjaxObtenerAreas",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                bootbox.confirm({
                    title:'<h5>Seleccionar Área</h5>',
                    message:'<div class="row">'+
                                '<div class="col-xs-12">'+
                                    '<div class="form-group">'+
                                        '<select class="form-control" name="ap_area">'+data.option+'</select>'+
                                    '</div>'+
                                '</div>'+
                            '</div>',
                    size:'small',
                    callback:function (res) {
                        if(res==true){
                            var area_id=$('body select[name=ap_area]').val();
                            $.ajax({
                                url: base_url+"Areas/Enfermeria/AjaxCambiarArea",
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    ap_id:ap_id,
                                    area_id:area_id,
                                    csrf_token:csrf_token
                                },beforeSend: function (xhr) {
                                    msj_loading();
                                },success: function (data, textStatus, jqXHR) {
                                    bootbox.hideAll()
                                    if(data.accion=='1'){
                                        AjaxCamas();
                                    }
                                },error: function (jqXHR, textStatus, errorThrown) {
                                    msj_error_serve();
                                }
                            })
                        }
                    }
                })
            },error: function (e) {
                msj_error_serve();
                console.log(e)
            }
            
        })
    })
})