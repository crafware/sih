$(document).ready(function () {
    $('input[name=triage_id]').focus();
    $('input[name=triage_id]').keyup(function (e){
        var input=$(this);
        if($(this).val().length==11 && input.val()!=''){ 
            $.ajax({
                url: base_url+"Observacion/AjaxObtenerPaciente",
                type: 'POST',
                dataType: 'json',
                data: {
                    'triage_id':input.val(),
                    'csrf_token':csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) { 
                    bootbox.hideAll();
                    if(data.accion=='1' && data.status=='EN_ESPERA'){
                        if(confirm('¿AGREGAR PACIENTE A OBSERVACIÓN?')){
                            AsociarMedico(data.triage_id);
                        }
                    }if(data.accion=='1' && data.status=='ASIGNADO'){
                        bootbox.confirm({
                            title : '<h5>DETALLES DEL PACIENTE</h5>',
                            message: '<div class="row">'+
                                        '<div class="col-md-12" style="margin-top:-10px">'+
                                            '<div style="height:10px;width:100%;margin-top:10px" class="'+ObtenerColorClasificacion(data.info.triage_color)+'"></div>'+
                                        '</div>'+
                                        '<div class="col-md-12">'+
                                            '<h4 style="line-height: 1.4;margin-top:0px"><b>FOLIO: </b>'+data.info.triage_id+'</h4>'+
                                            '<h4 style="line-height: 1.4;margin-top:0px"><b>PACIENTE: </b> '+data.info.triage_nombre+' '+data.info.triage_nombre_ap+' '+data.info.triage_nombre_am+'</h4>'+
                                            '<h4 style="line-height: 1.4;margin-top:-10px"><b>MÉDICO: </b> '+(data.medico.empleado_nombre==null ? 'S/E': data.medico.empleado_nombre)+' '+(data.medico.empleado_apellidos==null ? 'S/E': data.medico.empleado_apellidos)+'</h4>'+
                                            '<h4 style="line-height: 1.4;margin-top:-10px"><b>CAMA: </b> '+(data.obs.observacion_cama_nombre==null ? 'NO ASIGNADO' : data.obs.observacion_cama_nombre )+'</h4>'+
                                            '<h4 style="line-height: 1.4;margin-top:-10px"><b>INGRESO: </b> '+data.obs.observacion_mfa+' '+data.obs.observacion_mha+'</h4>'+
                                        '</div>'+
                                    '</div>',
                            buttons:{
                                confirm:{
                                    label:'Ver Expediente',
                                    className:'back-imss'
                                },cancel:{
                                    label:'Cancelar',
                                    className:'back-imss'
                                }
                            },callback:function (res) {
                                if(res==true){
                                    window.open(base_url+'Sections/Documentos/Expediente/'+data.triage_id+'/?tipo=Observacion','_blank');
                                }
                            }
                        })
                        //msj_error_noti('EL N° DE PACIENTE YA SE ENCUENTRA EN EL ÁREA DE OBSERVACIÓN')
                    }if(data.accion=='1' && data.status=='SALIDA'){
                        AsociarMedico(data.triage_id);
                    }if(data.accion=='2' ){
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
                                            triage_id:data.triage_id,
                                            csrf_token:csrf_token
                                        },beforeSend: function (xhr) {
                                            msj_loading();
                                        },success: function (data2, textStatus, jqXHR) {
                                            bootbox.hideAll();
                                            if(data2.accion=='1'){
                                                AsociarMedico(data.triage_id)
                                            }
                                        },error: function (e) {
                                            bootbox.hideAll();
                                            msj_error_serve(e)
                                        }
                                    })
                                }
                            }
                        })
                    }if(data.accion=='3' ){
                        msj_success_noti('EL N° PACIENTE NO CORRESPONDE A ESTA AREA_') 
                    }if(data.accion=='4'){
                        MsjNotificacion('ERROR DATOS INCOMPLETOS','DATOS DEL PACIENTE NO CAPTURADOS POR ASISTENTE MÉDICA');
                    }
                    
                },error: function (e) {
                    msj_error_serve(e);
                    console.log(e)
                }
            }) 
            input.val('');
        }
        
    })
    function AsociarMedico(triage_id) {
        var empleado_matricula=prompt('CONFIRMAR SU MATRICULA');
        console.log(triage_id);
        if(empleado_matricula!=null && empleado_matricula!=''){
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
    } /*  ASIGNAR CAMA LA PACIENTE POR ENFERMERIA EN LE TABLERO DE CAMAS*/
    $('body').on('click','.btn-paciente-agregar',function (){
        var cama_id=$(this).data('cama');
        var triage_id=prompt("N° Paciente",$('input[name=triage_id]').val());
        var InfoPaciente={};
        if(triage_id!='' && triage_id!=null){ 
            $.ajax({
                url: base_url+"Observacion/AjaxObtenerPacienteEnf",
                type: 'POST',
                dataType: 'json',
                data: {
                    triage_id : triage_id,
                    csrf_token : csrf_token
                },beforeSend: function (xhr) {
                    msj_loading()
                },success: function (data, textStatus, jqXHR) { 
                    bootbox.hideAll();
                    InfoPaciente=data.paciente;
                    console.log(data.accion, InfoPaciente);
                    if(data.accion=='1'){
                        var empleado_matricula=prompt('CONFIRMAR SU MATRICULA:','');
                        if(empleado_matricula!=null && empleado_matricula!=''){
                            AsociarCama(triage_id,cama_id,empleado_matricula);
                        }else{
                            msj_error_noti('CONFIRMACIÓN DE MATRICULA REQUERIDA');
                        }
                    }if(data.accion=='2'){
                        msj_error_noti('EL PACIENTE YA TIENE ASIGNADO UNA CAMA');
                    }if(data.accion=='3'){
                        bootbox.confirm({
                            title:'<h5>Verificar Datos</h5>',
                            message:'<div class="row">'+
                                        '<div class="col-md-12">'+
                                            '<div class="input-group m-b">'+
                                                '<span class="input-group-addon back-imss no-border"><i class="fa fa-calendar"></i></span>'+
                                                '<input type="text" name="triage_fecha_nac" value="'+data.triage_fecha_nac+'" class="form-control">'+
                                            '</div>'+
                                            '<div class="input-group m-b">'+
                                                '<span class="input-group-addon back-imss no-border"><i class="fa fa-user"></i></span>'+
                                                '<select class="form-control" name="triage_paciente_sexo">'+
                                                    '<option value="HOMBRE">HOMBRE</option>'+
                                                    '<option value="MUJER">MUJER</option>'+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>',
                            size:'small',
                            callback:function (res) {
                                if(res==true){
                                    $.ajax({
                                        url: base_url+"Observacion/AjaxActualizarDatosPaciente",
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            triage_fecha_nac:$('body input[name=triage_fecha_nac]').val(),
                                            triage_paciente_sexo:$('body select[name=triage_paciente_sexo]').val(),
                                            triage_id:triage_id,
                                            csrf_token:csrf_token
                                        },beforeSend: function (xhr) {
                                            msj_loading('Actualizando datos del paciente...');
                                        },success: function (data, textStatus, jqXHR) {
                                            bootbox.hideAll();
                                            if(data.accion=='1'){
                                                msj_success_noti('DATOS ACTUALIZADOS, POR FAVOR VOLVER A ESCANEAR FOLIO DE PACIENTE EN CASO DE QUE LOS DATOS ESTABAN INCORRECTOS')
                                            }
                                        },error: function (e) {
                                            bootbox.hideAll();
                                            MsjError();
                                        }
                                    })
                                }
                            }
                        })
                        $('body select[name=triage_paciente_sexo]').val(data.triage_paciente_sexo);
                        msj_error_noti('_EL N° DE PACIENTE NO CORRESPONDE A ESTA ÁREA')
                    }if(data.accion=='4'){ 
                        bootbox.confirm({
                            title:'<h5>AGREGAR PACIENTE</h5>',
                            message:'<h5>N° DE PACIENTE NO ENCONTRADO, DESEA AGREGAR ESTE PACIENTE A OBSERVACIÓN</h5>',
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
                                            msj_loading();
                                        },success: function (data2, textStatus, jqXHR) {
                                            bootbox.hideAll();
                                            if(data2.accion=='1'){
                                                var empleado_matricula=prompt('CONFIRMAR SU MATRICULA:','');
                                                if(empleado_matricula!=null && empleado_matricula!=''){
                                                    AsociarCama(triage_id,cama_id,empleado_matricula);
                                                }else{
                                                    msj_error_noti('CONFIRMACIÓN DE MATRICULA REQUERIDA');
                                                }
                                            }if(data2.accion=='2'){
                                                msj_error_noti('EL N° DE PACIENTE NO EXISTE')
                                            }
                                        },error: function (e) {
                                            bootbox.hideAll();
                                            MsjError();
                                        }
                                    })
                                }
                            }
                        })
                    }if(data.accion=='5'){
                        if(confirm('EL PACIENTE YA FUE DADO DE ALTA, ¿DESEA REINGRESAR ESTA PACIENTE?')){
                            AjaxReingreso({
                                triage_id:triage_id,
                                cama_id:cama_id
                            });
                        }
                    }if(data.accion=='6'){
                        MsjNotificacion('ERROR DATOS INCOMPLETOS','DATOS DEL PACIENTE NO CAPTURADOS POR ASISTENTE MÉDICA');
                    }if(data.accion=='7'){
                        console.log(InfoPaciente);
                        bootbox.confirm({
                            title:'<h6>REINGRESO DE PACIENTE</h6>',
                            message:'<div class="col-md-12" style="padding: 0px;margin-top: 0px;">'+
                                        '<div style="height:10px;width:100%;margin-top:0px" class="'+ObtenerColorClasificacion(InfoPaciente.triage_color)+'"></div>'+
                                    '</div>'+
                                    '<h3 style="margin-top:0px;"><b><br>PACIENTE:</b> '+InfoPaciente.triage_nombre+' '+InfoPaciente.triage_nombre_am+' '+InfoPaciente.triage_nombre_am+'</h3>'+
                                    '<h5 style="margin-top:0px;line-height:1.4">EL PACIENTE FUE DADO DE ALTA A QUIRÓFANO ¿DESEA REINGRESAR ESTE PACIENTE AL ÁREA DE OBSERVACIÓN?</h5>',
                            buttons:{
                                cancel:{
                                    label:'Cancelar'
                                },confirm:{
                                    label:'Reingreso a Observación'
                                }
                            },callback:function (response) {
                                if(response==true){
                                    AjaxReingreso({
                                        triage_id:triage_id,
                                        cama_id:cama_id
                                    });
                                }
                            }
                        })
                    }
                },error: function (e) {
                    bootbox.hideAll();
                    MsjError();
                }
            }) 
        }
    
    });
    function AjaxReingreso(info) {
        $.ajax({
            url: base_url+"Observacion/AjaxReingreso",
            type: 'POST',
            dataType: 'json',
            data:{
                triage_id:info.triage_id,
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_loading('Reingresando de paciente al area de Observación')
            },success: function (data_re, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data_re.accion=='1'){
                    var empleado_matricula=prompt('CONFIRMAR MATRICULA:','');
                    if(empleado_matricula!=null && empleado_matricula!=''){
                        AsociarCama(info.triage_id,info.cama_id,empleado_matricula);
                    }else{
                        msj_error_noti('CONFIRMACIÓN DE MATRICULA REQUERIDA');
                    }
                }
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e);
            }
        })
    }
    
    function AsociarCama(triage_id,cama_id,empleado_matricula) {
        
        $.ajax({
            url: base_url+"Observacion/AjaxAsociarCama",
            type: 'POST',
            data: {
                triage_id:triage_id,
                cama_id:cama_id,
                empleado_matricula:empleado_matricula,
                csrf_token:csrf_token
            },dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading()
            },success: function (data, textStatus, jqXHR) {
                if(data.accion=='1'){
                    bootbox.hideAll();
                    CargarCamasEnfemeria();
                }if(data.accion=='2'){
                    bootbox.hideAll();
                    msj_error_noti('LA MATRICULA ESCRITA NO EXISTE');
                }
                
            },error: function (e) {
                msj_error_serve(e);
                bootbox.hideAll();
            }
        })
    }
    if($('input[name=accion_rol]').val()=='Enfermeria'){
        CargarCamasEnfemeria()
    }
    if($('input[name=accion_rol]').val()=='Médico'){
        if($('input[name=empleado_servicio]').val()==''){
            $.ajax({
                url: base_url+"Consultorios/ObtenerEspecialidades",
                dataType: 'json',
                beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    bootbox.confirm({
                        title: '<h5>SELECCIONAR ESPECIALIDAD</h5>',
                        message:'<div class="row ">'+
                                    '<div class="col-sm-12">'+
                                        '<div class="form-group">'+
                                            '<select id="observacion_servicio" class="form-control" style="width:100%">'+data.option+'</select>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>',
                        size:'small',
                        buttons: {
                            cancel:{
                               label:'Cancelar',
                               className:'back-imss'
                            },confirm: {
                                label: "Aceptar",
                                className: "back-imss"
                            }
                        },callback:function (res) {
                            if(res==true){
                                var observacion_servicio=$('body #observacion_servicio').val();
                                    if(observacion_servicio!=''){
                                        SendAjax({
                                            observacion_servicio: observacion_servicio,
                                            csrf_token:csrf_token
                                        },'Observacion/AjaxCrearSessionServicio',function (response) {
                                            ActionWindowsReload();
                                        },'')
                                    }else{
                                        msj_error_noti('SELECCIONAR SERVICIO AL QUE PERTENECE COMO MÉDICO');
                                    }
                            }else{
                                window.location.reload()
                            }
                        }
                        ,onEscape : function() {}
                    });
                    
                },error: function (e) {
                    bootbox.hideAll();
                    MsjError();
                    ReportarError(window.location.pathname,e.responseText);
                }
            });
        }
    }
    $('.actualizar-camas-observacion').click(function (e) {
        e.preventDefault();
        CargarCamasEnfemeria();
    })
    function CargarCamasEnfemeria() {
        $.ajax({
            url: base_url+"observacion/CargarCamas",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading('Obteniendo información de camas')
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.result_camas=='NO_HAY_CAMAS'){
                    $('.NO_HAY_CAMAS').removeClass('hide');
                }else{
                    $('.result_camas').html(data.result_camas);
                }
                
            },error: function (jqXHR, textStatus, errorThrown) {

            }
        })
    }
    function CargarCamasEnfemeriaDespues() {
        $.ajax({
            url: base_url+"observacion/CargarCamas",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading('Obteniendo información de camas')
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.result_camas=='NO_HAY_CAMAS'){
                    $('.NO_HAY_CAMAS').removeClass('hide');
                }else{
                    $('.result_camas').html(data.result_camas);
                }
            },error: function (jqXHR, textStatus, errorThrown) {

            }
        })
    }
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
                        CargarCamasEnfemeria()
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    msj_error_serve()
                }
           })
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
                            url: base_url+"Observacion/AjaxTarjetaIdentificacion",
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
                                    AbrirDocumento(base_url+'Inicio/Documentos/TarjetaDeIdentificacion/'+triage_id);
                                    CargarCamasEnfemeria()
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
    $('body').on('click','.addSignosVitales',function (e) {
        var triage_id=$(this).attr('data-id');
        e.preventDefault();
        bootbox.dialog({
            title:'<h5>Signos Vitales</h5>',
            message:'<div class="row">'+
                        '<div class="col-sm-4">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                '<label>Presión arterial (mmHg)</label>'+
                                '<input class="md-input " placeholder="" name="triage_tension_arterial"  >'+   
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                '<label>Temperatura (°C)</label>'+
                                '<input class="md-input" placeholder="" name="triage_temperatura"  >  '+ 
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                '<label>Frecuencia cardiaca (lpm)</label>'+
                                '<input class="md-input" placeholder=""  name="triage_frecuencia_cardiaca"  >  '+ 
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                 '<label>Frecuencia respiratoria (rpm)</label>'+
                                '<input class="md-input" placeholder="" name="triage_frecuencia_respiratoria"  >  '+ 
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                 '<label>Glucosa Capilar (mg/dl)</label>'+
                                '<input class="md-input" placeholder="" name="triage_glucosa"  >  '+ 
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="md-form-group" style="margin-top: -20px">'+
                                 '<label>Oximetria (%)</label>'+
                                '<input class="md-input" placeholder="" name="triage_sp02"  >  '+ 
                            '</div>'+
                        '</div>'+
                    '</div>',
            buttons:{
                Cancelar:{
                    label:'Cancelar',
                    callback:function () {}
                },
                Guardar:{
                    label:'Guardar',
                    callback:function () {
                            var pani    = $('body input[name=triage_tension_arterial]').val();
                            var temp    = $('body input[name=triage_temperatura]').val();
                            var fc      = $('body input[name=triage_frecuencia_cardica]').val();
                            var fr      = $('bodu input[name=triage_frecuencia_respiratoria]').val();
                            var glucosa = $('body input[name=triage_glucosa]').val();
                            var sp02    = $('body input[name=triage_sp02]').val();

                            bootbox.hideAll();
                            $.ajax({
                                url:     base_url+"Observacion/AjaxSignosVitales",
                                type:    'POST',
                                datType: 'json',
                                data:    {
                                            triage_id     : triage_id,
                                            sv_ta         : pani,
                                            sv_temp       : temp,
                                            sv_fc         : fc,
                                            sv_fr         : fr,
                                            sv_destrostix : glucosa,
                                            sv_oximetria  : sp02,
                                            csrf_token    : csrf_token
                                },
                                beforeSend: function (xhr) {
                                    msj_loading();
                                },
                                success: function (data, textStatus, jqXHR) {
                                            bootbox.hideAll();
                                            msj_success_noti('SIGNOS VITALES GUARDADOS');
                                            ActionWindowsReload();
                                        
                                },
                                error: function (e) {
                                        msj_error_serve(e);
                                        bootbox.hideAll();
                                }

                            })
                    }
                }
            },
            onEscape:function () {}
        });
    });
    $('body').on('click','.cambiar-cama-paciente',function (e) {
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
                                    url: base_url+"Observacion/AjaxCambiarCama",
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
                                            CargarCamasEnfemeria()
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
                    url: base_url+"Observacion/CambiarEnfermera",
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
                            CargarCamasEnfemeria();
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
    $('body').on('click','.alta-paciente',function (e){
        var triage_id=$(this).data('triage');
        var observacion_cama=$(this).data('cama');
        if(confirm('¿DAR DE ALTA PACIENTE?')){
            bootbox.dialog({
                title: '<h5>SELECCIONAR DESTINO</h5>',
                message:'<div class="row ">'+
                            '<div class="col-sm-12">'+
                                '<input type="radio" name="observacion_alta_value" value="Alta a domicilio" id="domicilio"><label for="domicilio"><p class="text-danger">&nbsp;&nbsp;Alta a domicilio</p></label><br>'+
                                '<input type="radio" name="observacion_alta_value" value="Alta e ingreso quirófano" id="quirofano"><label for="quirofano"><p class="text-danger">&nbsp;&nbsp;Alta e ingreso quirófano</p></label><br>'+
                                '<input type="radio" name="observacion_alta_value" value="Alta e ingreso a hospitalización" id="hospitalizacion"><label for="hospitalizacion"><p class="text-danger">&nbsp;&nbsp;Alta e ingreso a hospitalización</p></label><br>'+
                                '<input type="radio" name="observacion_alta_value" value="Alta e ingreso a UCI" id="uic"><label for="uci"><p class="text-danger">&nbsp;&nbsp;Alta e ingreso a UCI</p></label><br> '+
                                '<input type="radio" name="observacion_alta_value" value="Alta hemodiálisis" id="hemodialisis"><label for="Desconocido"><p class="text-danger">&nbsp;&nbsp;Alta a Hemodiálisis</p></label><br>'+
                                '<input type="radio" name="observacion_alta_value" value="Alta a UMF " id="umf"><label for="umf"><p class="text-danger">&nbsp;&nbsp;Alta a UMF</p></label><br>'+
                                '<input type="radio" name="observacion_alta_value" value="Alta HGZ" id="HGZ"><label for="HGZ"><p class="text-danger">&nbsp;&nbsp;Alta a HGZ</p></label><br>'+
                                '<input type="radio" name="observacion_alta_value" value="Defunción" id="defuncion"><label for="defuncion"><p class="text-danger">&nbsp;&nbsp;Defunción</p></label>'+
                            '</div>'+
                        '</div>',
                size:'small',
                buttons: {
                    main: {
                        label: "Aceptar",
                        className: "btn-fw green-700",
                        callback:function(){
                            var observacion_alta=$('body input[name=observacion_alta]').val();
                            $.ajax({
                                url: base_url+"Observacion/AjaxAltaPaciente",
                                type: 'POST',
                                dataType: 'json',
                                data:{
                                    observacion_alta:observacion_alta,
                                    observacion_cama:observacion_cama,
                                    triage_id:triage_id,
                                    csrf_token:csrf_token
                                },beforeSend: function (xhr) {
                                    msj_loading()
                                },success: function (data, textStatus, jqXHR) {
                                    bootbox.hideAll();
                                    if(data.accion=='1'){
                                        CargarCamasEnfemeria();
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
            $('body').on('click','input[name=observacion_alta_value]',function (e){
                $('input[name=observacion_alta]').val($(this).val())
            }) 
        };
    })
    $('.clockpicker-obs').clockpicker({
        placement: 'bottom',
        autoclose: true
    });
    $('.datepicker-obs').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        placement: 'bottom'
    });
    $('select[name=TIPO_BUSQUEDA]').change(function (e) {
        if($(this).val()=='POR_HORA'){
            $('.POR_FECHA').addClass('hide');
            $('.POR_HORA').removeClass('hide');
        }if($(this).val()=='POR_FECHA'){
            $('.POR_FECHA').removeClass('hide');
            $('.POR_HORA').addClass('hide');
        }
    })
    $('.btn-indicador-obs-enf').click(function (e) {
        $.ajax({
            url: base_url+"Observacion/Indicador/AjaxEnfermeria",
            type: 'POST',
            dataType: 'json',
            data:{
                TIPO_BUSQUEDA:$('select[name=TIPO_BUSQUEDA]').val(),
                POR_FECHA_FI:$('input[name=POR_FECHA_FI]').val(),
                POR_FECHA_FF:$('input[name=POR_FECHA_FF]').val(),
                POR_HORA_FI:$('input[name=POR_HORA_FI]').val(),
                POR_HORA_HI:$('input[name=POR_HORA_HI]').val(),
                POR_HORA_HF:$('input[name=POR_HORA_HF]').val(),
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_loading('Espere por favor, esto puede tardar un momento...');
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.obs-enfermeria-result').removeClass('hide');
                console.log(data)
                $('.obs-enfermeria-ingreso').attr('data-tipo','Ingreso Enfermería Observación').find('h2').html(data.TOTAl_INGRESO+' Pacientes');
                $('.obs-enfermeria-egreso').attr('data-tipo','Egreso Enfermería Observación').find('h2').html(data.TOTAL_EGRESO+' Pacientes');
                $('.obs-enfermeria-ingreso, .obs-enfermeria-egreso')
                        .attr('data-TIPO_BUSQUEDA',$('select[name=TIPO_BUSQUEDA]').val())
                        .attr('data-POR_FECHA_FI',$('input[name=POR_FECHA_FI]').val())
                        .attr('data-POR_FECHA_FF',$('input[name=POR_FECHA_FF]').val())
                        .attr('data-POR_HORA_FI',$('input[name=POR_HORA_FI]').val())
                        .attr('data-POR_HORA_HI',$('input[name=POR_HORA_HI]').val())
                        .attr('data-POR_HORA_HF',$('input[name=POR_HORA_HF]').val())
                        
            },error: function (e) {
                msj_error_serve(e)
                console.log(e);
                bootbox.hideAll();
            }
        })
    })
    $('.obs-enfermeria-ingreso, .obs-enfermeria-egreso').click(function (e) {
        e.preventDefault();
        window.open(base_url+'Observacion/Indicador/EnfemeriaEmpleados?'
        +'TIPO='+$(this).attr('data-tipo')
        +'&TIPO_BUSQUEDA='+$(this).attr('data-tipo_busqueda')
        +'&POR_FECHA_FI='+$(this).attr('data-por_fecha_fi')
        +'&POR_FECHA_FF='+$(this).attr('data-por_fecha_ff')
        +'&POR_HORA_FI='+$(this).attr('data-por_hora_fi')
        +'&POR_HORA_HI='+$(this).attr('data-por_hora_hi')
        +'&POR_HORA_HF='+$(this).attr('data-por_hora_hf')
        ,'_blank');
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
                                                CargarCamasEnfemeria()
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
    $('body').on('click','.interconsulta-paciente',function (e){
        var id=$(this).attr('data-id');
        var ce_id=$(this).attr('data-ce');
        if(confirm('¿SOLICITAR INTERCONSULTA?')){
            $.ajax({
                url: base_url+"Consultorios/ObtenerEspecialidades",
                dataType: 'json',
                beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    bootbox.dialog({
                        title: '<h5>SELECCIONAR DESTINO</h5>',
                        message:'<div class="row ">'+
                                    '<div class="col-sm-12">'+
                                        '<div class="form-group">'+
                                            '<select id="select_destino" class="form-control" style="width:100%">'+data.option+'</select>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<textarea class="form-control" name="doc_diagnostico" rows="4" maxlength="300" placeholder="Diagnostico"></textarea>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>',
                        buttons: {
                            Cancelar:{
                               label:'Cancelar',
                               className:'back-imss',
                               callback:function () {}
                            },Aceptar: {
                                label: "Solicitar Interconsulta",
                                className: "back-imss",
                                callback:function(){
                                    var doc_servicio_solicitado=$('body #select_destino').val();
                                    var doc_diagnostico=$('body textarea[name=doc_diagnostico]').val();
                                    if(doc_diagnostico!=''){
                                        $.ajax({
                                            url: base_url+"Observacion/AjaxInterConsulta",
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                csrf_token:csrf_token,
                                                ce_id:ce_id,
                                                doc_servicio_solicitado:doc_servicio_solicitado,
                                                doc_diagnostico:doc_diagnostico,
                                                triage_id:id
                                            },beforeSend: function (xhr) {
                                                msj_loading();
                                            },success: function (data, textStatus, jqXHR) {
                                                bootbox.hideAll();
                                                if(data.accion=='1'){
                                                    AbrirDocumentoMultiple(base_url+'Inicio/Documentos/DOC430200/'+data.Interconsulta);
                                                    ActionWindowsReload();
                                                }if(data.accion=='2'){
                                                    MsjNotificacion('<h5>ERROR</h5>','<center><i class="fa fa-exclamation-triangle fa-5x" style="color:#E62117"></i><br>LA INTERCONSULTA SOLICITADO A ESTE CONSULTORIO YA FUE REALIZADO </center>')
                                                }
                                                
                                            },error: function (e) {
                                                bootbox.hideAll();
                                                MsjError();
                                                ReportarError(window.location.pathname,e.responseText);
                                            }
                                        })
                                    }else{
                                        msj_error_noti('DIAGNOSTICO REQUERIDO');
                                    }
                                }
                            }
                        }
                        ,onEscape : function() {}
                    });
                    $("#select_destino option[value='"+$('input[name=empleado_servicio]').val()+"']").remove();
                },error: function (e) {
                    bootbox.hideAll();
                    MsjError();
                    ReportarError(window.location.pathname,e.responseText);
                }
            });
        }
    });
    /*OBSERVACION ESTADOS DE CAMAS(HABILITACION Y DESABILITACIÓN)*/
    $('body').on('click','.camas-acciones',function (e) {
        let cama_id=$(this).attr('data-cama');
        let cama_display=$(this).attr('data-display');
        SendAjaxPost({
            cama_id:cama_id,
            cama_display:cama_display,
            csrf_token:csrf_token
        },'Observacion/Camas/AjaxEstados',function (response) {
            if(response.accion=='1'){
                location.reload();
            }
        })
    })
    /*ELIMINAR PACIENTE DEL ÁREA DE OBSERVACIÓN PARA SU POSTERIÓR REINGRESO*/
    $('body').on('click','.enf-obs-del-paciente',function () {
        if(confirm('¿FORZAR ELIMINACIÓN DE PACIENTE DEL ÁREA DE ENFERMERÍA OBSERVACIÓN, PARA SU POSTERIOR REINGRESO A DICHA ÁREA?')){
            var triage_id=prompt('INGRESAR N° DE FOLIO:','');
            if(triage_id!='' && triage_id!=null){
                SendAjaxPost({
                    triage_id:triage_id,
                    csrf_token:csrf_token
                },'Observacion/AjaxEliminarPacienteObs',function (response) {
                    if(response.accion=='1'){
                        msj_success_noti('ACCIÓN REALIZADA CORRECTAMENTE');
                        CargarCamasEnfemeria();
                    }
                })
            }
        }
    });
});