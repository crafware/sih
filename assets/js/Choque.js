$(document).ready(function (e) {
    $('.guardar-choque-signosvitales').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url: base_url+"Choque/AjaxSignosVitales",
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
            url: base_url+"Choque/Camas/AjaxCamas",
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
                url: base_url+"Choque/Camas/AjaxObtenerPaciente",
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
            url: base_url+"Choque/Camas/AjaxAsociarCama",
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
                url: base_url+"Choque/ObtenerCamasChoque",
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
                                            '<select name="cama_id" class="form-control">'+data.accion+'</select>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>',
                        size:'small',
                        callback:function (res) {
                            if(res==true){
                                bootbox.hideAll();
                                $.ajax({
                                    url: base_url+"Choque/Camas/AjaxCambiarCama",
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
                    url: base_url+"Choque/Camas/AjaxCambiarEnfermera",
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
                                    AbrirDocumento(base_url+'Inicio/Documentos/TarjetaDeIdentificacionChoque/'+triage_id);
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
                                url: base_url+"Choque/AjaxAltaPaciente",
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
                        AjaxVisorCamas();
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
                url: base_url+"Choque/ObtenerCamasChoque",
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
                                            url: base_url+"Choque/AjaxAsignarCama",
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
            triage_tension_arterial:'',
            triage_temperatura:'',
            triage_frecuencia_cardiaco:'',
            triage_frecuencia_respiratoria:'',
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
                                '<label>Tensión arterial: </label>'+
                                '<input class="md-input " placeholder="Ejemplo: 130/90" name="triage_tension_arterial"  value="'+info.triage_tension_arterial+'">'+   
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-6">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                '<label>Temperatura: </label>'+
                                '<input class="md-input" placeholder="Ejemplo: 37" name="triage_temperatura"  value="'+info.triage_temperatura+'">  '+ 
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-6">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                '<label>Frecuencia cardiaca o pulso: </label>'+
                                '<input class="md-input" placeholder="Ejemplo: 78"  name="triage_frecuencia_cardiaco"  value="'+info.triage_frecuencia_cardiaco+'">  '+ 
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-6">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                 '<label>Frecuencia respiratoria: </label>'+
                                '<input class="md-input" placeholder="Ejemplo: 37" name="triage_frecuencia_respiratoria"  value="'+info.triage_frecuencia_respiratoria+'">  '+ 
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
                        url: base_url+"Choque/AjaxSignosVitales",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            sv_id:info.sv_id,
                            triage_tension_arterial:$('body input[name=triage_tension_arterial]').val(),
                            triage_temperatura:$('body input[name=triage_temperatura]').val(),
                            triage_frecuencia_cardiaco:$('input[name=triage_frecuencia_cardiaco]').val(),
                            triage_frecuencia_respiratoria:$('body input[name=triage_frecuencia_respiratoria]').val(),
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
                            msj_error_serve()
                            console.log(e);
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
                url: base_url+"Choque/Camas/AjaxVisorCamas",
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
})