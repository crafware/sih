$(document).ready(function () {
    $('input[name=triage_id]').focus();
    $('input[name=triage_id]').keyup(function (e) {
        var triage_id=$(this).val();
        var input=$(this);
        if(triage_id.length==11 && triage_id!=''){
            $.ajax({
                url: base_url+"Hospitalizacion/AjaxObtenerPaciente",
                type: 'POST',
                dataType: 'json',
                data:{
                    triage_id:triage_id,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    console.log(data)
                    if(data.accion=='NO_AM'){
                        MsjNotificacion('<h5>ERROR, DATOS INCOMPLETOS </h5>','<center><i class="fa fa-exclamation-triangle fa-5x" style="color:#E62117"></i><br>DATOS DEL PACIENTE NO CAPTURADOS POR ASISTENTE MÉDICA</center>')
                    }if(data.accion=='NO_EXISTE_EN_HOSP'){
                        AjaxAgregarIngresoHosp(data.paciente)
                    }if(data.accion=='NO_ASIGNADO'){
                        AjaxIngresoServicio(data.paciente)
                    }if(data.accion=='ASIGNADO'){
                        PacienteAgregado(data.paciente,data.ce,data.medico,data.TieneInterconsulta)
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    bootbox.hideAll();
                    MsjError();
                }
            })
            input.val('');
        }
    });
    $('body').on('click', '#ingresoPaciente', function(e){
        var triage_id = $(this).data("value");
        $.ajax({
                url: base_url+"Hospitalizacion/AjaxObtenerPaciente",
                type: 'POST',
                dataType: 'json',
                data:{
                    triage_id:triage_id,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    console.log(data);
                    if(data.accion=='NO_AM'){
                        MsjNotificacion('<h5>ERROR, DATOS INCOMPLETOS </h5>','<center><i class="fa fa-exclamation-triangle fa-5x" style="color:#E62117"></i><br>DATOS DEL PACIENTE NO CAPTURADOS POR ASISTENTE MÉDICA</center>')
                    }if(data.accion=='NO_EXISTE_EN_HOSP'){
                        AjaxAgregarIngresoHosp(data.paciente)
                    }if(data.accion=='NO_ASIGNADO'){
                        AjaxIngresoServicio(data.paciente)
                    }if(data.accion=='ASIGNADO'){
                        PacienteAgregado(data.paciente,data.ce,data.medico,data.TieneInterconsulta)
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    bootbox.hideAll();
                    MsjError();
                }
            });
    });
    function PacienteAgregado(info,ce, medico,TieneInterconsulta) {
        bootbox.confirm({
            title: "<h5>PACIENTE ASIGNADO</h5>",
            message: '<div class="row" style="margin-top:-10px">'+
                        '<div class="col-md-12 ">'+
                            '<div style="height:10px;width:100%;margin-top:10px" class="'+ColorClasificacion(info.triage_color)+'"></div>'+
                        '</div>'+
                        '<div class="col-md-12">'+
                            '<h3><b>FOLIO:</b> '+info.triage_id+'</h3>'+
                            '<h3 style="margin-top:-5px"><b>PACIENTE:</b> '+info.triage_nombre+' '+info.triage_nombre_ap+' '+info.triage_nombre_am+'</h3>'+
                            '<h3 style="margin-top:-5px"><b>C. ASIGNADO:</b> '+ce.ce_asignado_consultorio+'</h3>'+
                            '<h3 style="margin-top:-5px"><b>M. ASIGNADO:</b> '+medico.empleado_nombre+' '+medico.empleado_apellidos+'</h3>'+
                            '<h3 style="margin-top:-5px"><b>INGRESO:</b> '+ce.ce_fe+' '+ce.ce_he+'</h3>'+
                            (ce.ce_status=='Salida' ? '<h3 style="margin-top:-5px"><b>SALIDA:</b> '+ce.ce_fs+' '+ce.ce_hs+'</h3>' : '')+
                            (TieneInterconsulta.length>0 ? '<hr><h3 style="margin-top:-5px"><b>ESTE PACIENTE CUENTA CON INTERCONSULTA':'')+
                        '</div>'+
                    '</div>'
            ,
            buttons: {
                cancel: {
                    label: 'Cancelar',
                    className: 'back-imss'
                },confirm: {
                    label: 'Ver Expediente',
                    className: 'back-imss'
                }
            },
            callback: function (result) {
                if(result==true){
                    window.open(base_url+'Sections/Documentos/Expediente/'+info.triage_id+'/?tipo=Especialidad','_blank')
                }
            }
        });
    }
    function AjaxIngresoServicio(info) {
        bootbox.confirm({
            title: "<h5>AGREGAR PACIENTE AL SERVICIO</h5>",
            message: '<div class="row" style="margin-top:-10px">'+
                        '<div class="col-md-12 ">'+
                            '<div style="height:10px;width:100%;margin-top:10px" class="'+ColorClasificacion(info.triage_color)+'"></div>'+
                        '</div>'+
                        '<div class="col-md-12">'+
                            '<h3><b>FOLIO:</b> '+info.triage_id+'</h3>'+
                            '<h3 style="margin-top:-5px"><b>PACIENTE:</b> '+info.triage_nombre+' '+info.triage_nombre_ap+' '+info.triage_nombre_am+'</h3>'+
                            '<h3 style="margin-top:-5px"><b>N.S.S:</b> '+info.triage_paciente_afiliacion+'</h3>'+
                            '<h3 style="margin-top:-5px"><b>DESTINO:</b> '+info.triage_consultorio_nombre+'</h3>'+
                        '</div>'+
                    '</div>'
            ,
            buttons: {
                cancel: {
                    label: 'Cancelar',
                    className: 'back-imss'
                },confirm: {
                    label: 'Agregar a Consultorio',
                    className: 'back-imss'
                }
            },
            callback: function (result) {
                if(result==true){
                    $.ajax({
                        url: base_url+"Hospitalizacion/AjaxIngresoConsultorioV2",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'triage_id':info.triage_id,
                            'csrf_token':csrf_token
                        },beforeSend: function (xhr) {
                            msj_loading();
                        },success: function (data, textStatus, jqXHR) { 
                            bootbox.hideAll()
                            location.reload();
                        },error: function (e) {
                            bootbox.hideAll();
                            MsjError();
                            ReportarError(window.location.pathname,e.responseText);
                        }
                    })
                }
            }
        });
    }
    function AjaxAgregarIngresoHosp(info) {
        bootbox.confirm({
            title: "<h5>Ingreso de Paciente</h5>",
            message: '<div class="row" style="margin-top:-10px">'+
                        '<div class="col-md-12 ">'+
                            '<div style="height:10px;width:100%;margin-top:10px" class="'+ColorClasificacion(info.triage_color)+'"></div>'+
                        '</div>'+
                        '<div class="col-md-12">'+
                            '<h3><b>Folio:</b> '+info.triage_id+'</h3>'+
                            '<h3 style="margin-top:-5px"><b>Nombre:</b> '+info.triage_nombre_ap+' '+info.triage_nombre_am+' '+info.triage_nombre+'</h3><br>'+
                            '<h5 style="margin-top:-5px"><b>¿Desea agregar a este paciente al Servicio?</b></h5>'+
                        '</div>'+
                    '</div>',
            buttons: {
                cancel: {
                    label: 'Cancelar',
                    className: 'back-imss'
                },confirm: {
                    label: 'Agregar',
                    className: 'back-imss'
                }
            },callback: function (result) {
                if(result==true){
                    $.ajax({
                        url: base_url+"Hospitalizacion/AjaxAgregarIngreso",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'triage_id':info.triage_id,
                            'csrf_token':csrf_token
                        },beforeSend: function (xhr) {
                            msj_loading();
                        },success: function (data, textStatus, jqXHR) { 
                            bootbox.hideAll();
                            updateTables(data);
                            /*if(data.accion == 1){
                                updateTables(data);
                                //reloadP();
                            }if(data.accion == 2){
                                console.log("error 2");
                            }if(data.accion == 3){
                                console.log("error 3");
                                msj_error_noti('Paciente sin cama asignada, acudir con la Asistente médica.')
                            }*/
                        },error: function (e) {
                            bootbox.hideAll();
                            MsjError();
                            ReportarError(window.location.pathname,e.responseText);
                        }
                    })
                }
            }
        });
    }
    var msj_error_noti=function (msj){
        Messenger().post({
            message: msj,
            type: 'error',
            showCloseButton: true
        }); 
    }
    window.onload = function() {
        var reloading = sessionStorage.getItem("reloading");
        if (reloading) {
            sessionStorage.removeItem("reloading");
            $('#tab_1').removeClass('active');
            $('#li_1').removeClass('active');
            $('#tab_2').addClass('active');
            $('#li_2').addClass('active');
        }
    }
    function updateTables(data){
        $tab_2= document.getElementById("tab_2");
        document.getElementById(data["value"]['triage_id']).remove();
        $tab_2.getElementsByTagName("tbody")[0].innerHTML += data["str"];
        $tab_2.getElementsByClassName("footable-sortable")[1].click();
        $('#tab_1').removeClass('active');
        $('#li_1').removeClass('active');
        $('#tab_2').addClass('active');
        $('#li_2').addClass('active');
        $tab_2.getElementsByClassName("footable-sortable")[1].click();
    }
    function reloadP() {
        sessionStorage.setItem("reloading", "true");
        document.location.reload();
    }
    function ColorClasificacion(Color) {
        if(Color=='Rojo'){
            return'red';
        }if(Color=='Naranja'){
            return 'orange';
        }if(Color=='Amarillo'){
            return 'yellow-A700';
        }if(Color=='Verde'){
            return 'green';
        }if(Color=='Azul'){
            return 'indigo';
        }
    }
    /*
    Boton para abrir ventana modal. La funcion imprime el formulario para indicar el servicio y el diagnostico de
    la interconsulta
    */
    $('body').on('click','.interconsulta-paciente',function (e){
        var id=$(this).attr('data-id');
        var ce_id=$(this).attr('data-ce');
        if(confirm('¿Desea solicitar una Interconsulta?')){
            $.ajax({
                url: base_url+"Consultorios/ObtenerEspecialidades",
                dataType: 'json',
                beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    bootbox.confirm({
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
                            cancel:{
                               label:'Cancelar',
                               className:'btn-imss-cancel'
                            },confirm: {
                                label: "Aceptar",
                                className:'back-imss'
                            }
                        },callback:function(response){
                            if(response==true){
                                var doc_servicio_solicitado=$('body #select_destino').val();
                                var doc_diagnostico=$('body textarea[name=doc_diagnostico]').val();

                                if(doc_diagnostico!=''){
                                    SendAjax({
                                        csrf_token:csrf_token,
                                        ce_id:ce_id,
                                        doc_servicio_solicitado:doc_servicio_solicitado,
                                        doc_diagnostico:doc_diagnostico,
                                        triage_id:id
                                    },'Consultorios/AjaxInterConsulta',function (response) {
                                        if(response.accion=='1'){
                                            //AbrirDocumentoMultiple(base_url+'Inicio/Documentos/DOC430200/'+data.Interconsulta); 
                                            ActionWindowsReload();
                                        }if(response.accion=='2'){
                                            MsjNotificacion('<h5>ERROR</h5>','<center><i class="fa fa-exclamation-triangle fa-5x" style="color:#E62117"></i><br>LA INTERCONSULTA SOLICITADO A ESTE CONSULTORIO YA FUE REALIZADO </center>')
                                        }
                                    },'')
                                }else{
                                    msj_error_noti('DIAGNOSTICO REQUERIDO');
                                }
                            }
                        }
                        ,onEscape : function() {}
                    });
                    $("#select_destino option[value='"+$('input[name=especialidad_nombre]').val()+"']").remove();
                },error: function (e) {
                    bootbox.hideAll();
                    MsjError();
                    ReportarError(window.location.pathname,e.responseText);
                }
            });
        }
    });
    $('body').on('click','.alta-paciente-servicio',function (e){
        e.preventDefault();
        var idp=$(this);
        if(confirm('¿REPORTAR ALTA DEL PACIENTE EN EL SERVICIO?')){
                $.ajax({
                url: base_url+"Hospitalizacion/AjaxReportarAlta",
                type: 'POST',
                dataType: 'json',
                data:{
                    'csrf_token':csrf_token,
                    'triage_id':idp.attr('data-id')
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.accion=='1'){
                        location.reload();
                    }
                },error: function (e) {
                    bootbox.hideAll();
                    MsjError();
                    ReportarError(window.location.pathname,e.responseText);
                    
                }
            })
        }
    })    
    $('body').on('click','.salida-paciente-observacion',function (e){
        e.preventDefault();
        var el=$(this);
        if(confirm('¿REPORTAR SALIDA DEL PACIENTE DE CONSULTORIOS A OBSERVACIÓN?')){
                $.ajax({
                url: base_url+"Consultorios/AjaxSalidaObservacion",
                type: 'POST',
                dataType: 'json',
                data:{
                    'csrf_token':csrf_token,
                    'triage_id':el.attr('data-id')
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.accion=='1'){
                        ActionWindowsReload();
                    }
                },error: function (e) {
                    msj_error_serve();
                    ReportarError(window.location.pathname,e.responseText);
                    bootbox.hideAll();
                }
            });
        }
    });    
    $('body').on('click','.abandono-consultorio',function (e) {
        if(confirm('¿DAR DE ALTA PACIENTE, POR NO PRESENTARSE A CONSULTORIO?')){
            $.ajax({
                url: base_url+"Consultorios/AjaxAltaPorAusencia",
                type: 'POST',
                data:{
                    triage_id:$(this).attr('data-id'),
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading()
                },success: function (data, textStatus, jqXHR) {
                    if(data.accion=='1'){
                        msj_success_noti('ALTA DE CONSULTORIO POR AUSENCIA');
                        ActionWindowsReload();
                    }
                },error: function (e) {
                    msj_error_serve(e)
                    ReportarError(window.location.pathname,e.responseText);
                }
            })
        }
    })
    /*INDICADORES*/
    $('.dd-mm-yyyy-ce').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        placement: 'bottom'
    });
    $('#fechaProductividad').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        placement: 'bottom'
    });
    $('.clockpicker-ce').clockpicker({
        placement: 'bottom',
        autoclose: true
    });
    $('.btn-indicador-ce').click(function () {
        $.ajax({
            url: base_url+"Consultorios/AjaxIndicadores",
            type: 'POST',
            dataType: 'json',
            data: {
                selectTurno: $('select[name=Turno]').val(),
                inputFechaInicio:$('input[name=inputFechaInicio]').val(),
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                console.log(data)
                bootbox.hideAll();
                $('.TOTAL_PACIENTES_CONSULTORIOS_DOC').find('span').html(data.TOTAL_DOCS+' PACIENTES');
                $('.GENERAR_LECHAGA_CONSULTORIOS')
                        .attr({'data-inputfecha': $('input[name=inputFechaInicio]').val(), 'data-turno':$('select[name=Turno]').val()}).removeClass('hide');
                
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e)
            }      
        })
    })
    $('.GENERAR_LECHAGA_CONSULTORIOS').click(function (e) {
        AbrirDocumento(base_url+'Inicio/Documentos/LechugaConsultorios?inputFechaInicio='+$(this).attr('data-inputfecha')+'&turno='+$(this).attr('data-turno'),'_blank');
    });
    /*Destinos*/
    $('.btn-add-dest').click(function (e) {
        e.preventDefault();
        AjaxDestino({
            destino_id:0,
            destino_nombre:'',
            destino_accion:'add'
        })
    })
    function AjaxDestino(info) {
        bootbox.confirm({
            title:'<h5>NUEVO DESTINO</h5>',
            message:'<div class="row">'+
                        '<div class="col-md-12">'+
                            '<div class="form-group">'+
                                '<input type="text" name="destino_nombre" value="'+info.destino_nombre+'" class="form-control" placeholder="Nombre del destino">'+
                            '</div>'+
                        '</div>'+
                    '</div>'
            ,size:'small',
            buttons:{
                confirm:{
                    label:'Aceptar',
                    className:'back-imss'
                },cancel:{
                    label:'Cancelar',
                    className:'back-imss'
                }
            },callback:function (response) {
                if(response==true){
                    var destino_nombre=$('body input[name=destino_nombre]').val();
                    if(destino_nombre!=''){
                        $.ajax({
                            url: base_url+"Consultorios/AjaxDestinos",
                            type: 'POST',
                            dataType: 'json',
                            data:{
                                destino_id:info.destino_id,
                                destino_nombre:destino_nombre,
                                destino_accion:info.destino_accion,
                                csrf_token:csrf_token
                            },beforeSend: function (xhr) {
                                msj_loading();
                            },success: function (data, textStatus, jqXHR) {
                                if(data.accion=='1'){
                                    msj_success_noti('Dato Guardados');
                                    ActionWindowsReload();
                                }
                            },error: function (e) {
                                bootbox.hideAll();
                                MsjError();
                                console.log(e);
                            }
                        })        
                    }else{
                        msj_error_noti('Campor Requerido');
                    }
                }
            }
            
        })
    }
    $('body').on('click','.destino-eliminar',function () {
        var destino_id=$(this).attr('data-id');
        if(confirm('¿ELIMINAR REGISTRO?')){
            $.ajax({
                url: base_url+"Consultorios/AjaxDestinosEliminar",
                type: 'POST',
                dataType: 'json',
                data:{
                    destino_id:destino_id,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.accion=='1'){
                        msj_success_noti('Registro eliminado');
                    }
                },error: function (e) {
                    bootbox.hideAll();
                    MsjError();
                    console.log(e)
                }
            });
        }
    });
    
    $("#Turno").change(function(event) {
    if($(this)[0].selectedIndex==0) {
        $(this).prop('required',true);
        
      }
      else {
        $(this).prop('required',false);

      }
    });

    
})