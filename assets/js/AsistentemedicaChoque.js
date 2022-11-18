$(document).ready(function (e) {
    $('input[name=triage_fecha_nac]').mask('99/99/9999');
    
    $('.agregar-horacero-paciente').on('click',function(e){
        e.preventDefault();
        bootbox.confirm({
            title:'<h5>REGISTRO DE PACIENTE EN ESTADO DE ATENCIÓN URGENTE</h5>',
            message:'<div class="row">'+
                '<div class="col-md-12">'+
                    '<div class="form-group">'+
                        '<select class="form-control" id="triage_tipo_paciente" name="triage_tipo_paciente" required>'+
                            '<option value="">SELECCIONAR CONDICIÓN...</option>'+
                            '<option value="Identificado">IDENTIFICADO</option>'+
                            '<option value="No Identificado" selected>NO IDENTIFICADO</option>'+
                        '</select>'+
                    '</div>'+
                    '<div class="form-group form-identificado hide">'+
                        '<label><b>PROCEDENCIA ESPONTANEA</b></label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="pia_procedencia_espontanea" value="Si" checked>'+
                            '<i class="blue"></i>Si'+
                        '</label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="pia_procedencia_espontanea" value="No" >'+
                            '<i class="blue"></i>No'+
                        '</label>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12">'+
                    '<div class="form-group form-espontaneo form-no-identificado ">'+
                        '<input name="pia_procedencia_espontanea_lugar" type="text" placeholder="Lugar de Procedencia"  class="form-control" required>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-no-espontanea hide">'+
                        '<select name="pia_procedencia_hospital"  class="form-control">'+
                            '<option value="UMF">UMF</option>'+
                            '<option value="HGZ">HGZ</option>'+
                            '<option value="UMAE">UMAE</option>'+
                        '</select>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-no-espontanea hide">'+
                        '<input name="pia_procedencia_hospital_num"  type="text" placeholder="NOMBRE/NUMERO DEL HOSPITAL"  class="form-control">'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12"></div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-identificado hide">'+
                        '<input name="triage_nombre_ap"  type="text" placeholder="Apellido Paterno"  class="form-control" required>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-identificado hide">'+
                        '<input name="triage_nombre_am"  type="text" placeholder="Apellido Materno"  class="form-control" required>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12">'+
                    '<div class="form-group form-identificado hide">'+
                        '<input name="triage_nombre"  type="text" placeholder="Nombre del Paciente"  class="form-control" required>'+
                    '</div>'+
                    '<div class="form-group form-no-identificado ">'+
                        '<input name="triage_nombre_pseudonimo" type="text" placeholder="Pseudonimo del Paciente"  class="form-control" required>'+
                    '</div>'+
                    '<div class="form-group form-identificado hide">'+
                        '<label><b>Cuenta con N.S.S</b></label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="triage_paciente_afiliacion_bol" value="Si" >'+
                            '<i class="blue"></i>Si'+
                        '</label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="triage_paciente_afiliacion_bol" value="No" checked="">'+
                            '<i class="blue"></i>No'+
                        '</label>'+
                    '</div>'+
                    '<div class="form-group form-identificado-nss hide">'+
                        '<div class="row">'+
                            '<div class="col-md-6" style="padding-right:2px">'+
                                '<input name="pum_nss" type="text" placeholder="N.S.S"  class="form-control item" required>'+
                            '</div>'+
                            '<div class="col-md-6" style="padding-left:2px">'+
                                '<input name="pum_nss_agregado" type="text" placeholder="N.S.S AGREGADO"  class="form-control" required>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group form-no-paciente">'+
                        '<select class="form-control" name="triage_paciente_sexo" required>'+
                            '<option value="">SELECCIONAR SEXO</option>'+
                            '<option value="HOMBRE">HOMBRE</option>'+
                            '<option value="MUJER">MUJER</option>'+
                        '</select>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<input name="triage_fecha_nac_a" type="text" placeholder="Año de Nac. Ejemplo: 1990"  class="form-control dd-mm-yyyy" required>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<input name="triage_motivoAtencion" type="text" placeholder="MOTIVO DE ATENCIÓN (Anote brevemente)"  class="form-control" required>'+
                    '</div>'+
                '</div>'+
            '</div>',
            callback:function (result) {
                var triage_tipo_paciente=$('body #triage_tipo_paciente').val();
                var triage_nombre=$('body input[name=triage_nombre]').val();
                var triage_nombre_ap=$('body input[name=triage_nombre_ap]').val();
                var triage_nombre_am=$('body input[name=triage_nombre_am]').val();
                var triage_nombre_pseudonimo=$('body input[name=triage_nombre_pseudonimo]').val();
                var triage_paciente_afiliacion_bol=$('body input[name=triage_paciente_afiliacion_bol]:checked').val();
                var pia_procedencia_espontanea=$('body input[name=pia_procedencia_espontanea]:checked').val();
                var pia_procedencia_espontanea_lugar=$('body input[name=pia_procedencia_espontanea_lugar]').val();
                var pia_procedencia_hospital=$('body select[name=pia_procedencia_hospital]').val();
                var pia_procedencia_hospital_num=$('body input[name=pia_procedencia_hospital_num]').val();
                var pum_nss=$('body input[name=pum_nss]').val();
                var pum_nss_agregado=$('body input[name=pum_nss_agregado]').val();
                var triage_paciente_sexo=$('body select[name=triage_paciente_sexo]').val();
                var triage_fecha_nac_a=$('body input[name=triage_fecha_nac_a]').val();
                var triage_motivoAtencion=$('body input[name=triage_motivoAtencion]').val();
                if(result==true){
                    if(triage_fecha_nac_a.length>=4){
                        $.ajax({
                            url: base_url+"Asistentesmedicas/Choque/GenerarFolioV2",
                            type: 'POST',
                            dataType: 'json',
                            data:{
                                triage_tipo_paciente:triage_tipo_paciente,
                                triage_nombre:triage_nombre,
                                triage_nombre_ap:triage_nombre_ap,
                                triage_nombre_am:triage_nombre_am,
                                triage_nombre_pseudonimo:triage_nombre_pseudonimo,
                                pia_procedencia_espontanea:pia_procedencia_espontanea,
                                pia_procedencia_espontanea_lugar:pia_procedencia_espontanea_lugar,
                                pia_procedencia_hospital:pia_procedencia_hospital,
                                pia_procedencia_hospital_num:pia_procedencia_hospital_num,
                                triage_paciente_afiliacion_bol:triage_paciente_afiliacion_bol,
                                pum_nss:pum_nss,
                                pum_nss_agregado:pum_nss_agregado,
                                triage_paciente_sexo:triage_paciente_sexo,
                                triage_fecha_nac_a:triage_fecha_nac_a,
                                triage_motivoAtencion:triage_motivoAtencion,
                                csrf_token:csrf_token
                            },beforeSend: function (data, textStatus, jqXHR) {
                                msj_loading('Guardando registro...');
                            },success: function (data, textStatus, jqXHR) {
                                bootbox.hideAll();
                                if(data.accion=='1'){
                                    ActionWindowsReload()
                                    //console.log(data);
                                   //location.href=base_url+'Asistentesmedicas/Choque/Triage/'+data.max_id;
                               }
                            },error: function (e) {
                                bootbox.hideAll();
                                msj_error_serve();
                                ReportarError(window.location.pathname,e.responseText)
                            }
                        });
                    }else{
                        msj_error_noti('ERROR AL ESPECIFICAR EL FORMATO DE FECHA');
                    }
                }
            }
        });
        $('body select[name=triage_tipo_paciente]').change(function (e) {
            if($(this).val()=='Identificado'){
                $('body .form-identificado').removeClass('hide');
                $('body .form-no-identificado').addClass('hide');
                $('body .form-espontaneo').removeClass('hide');
            }if($(this).val()=='No Identificado'){
                $('body .form-identificado-nss').addClass('hide');
                $('body .form-identificado').addClass('hide');
                $('body .form-no-identificado').removeClass('hide');
                $('body .form-espontaneo').removeClass('hide');
                $('body .form-no-espontanea').addClass('hide');
            }
        })
        $('body input[name=triage_paciente_afiliacion_bol]').click(function (e) {
           if($(this).val()=='No'){
               $('body .form-identificado-nss').addClass('hide');
           }else{
               $('body .form-identificado-nss').removeClass('hide');
           } 
        });
        $('body input[name=triage_fecha_nac_a]').mask('9999');
        $('body input[name=pum_nss]').mask('9999-99-9999-9');
        $('body').on('click','input[name=pia_procedencia_espontanea]',function (e) {
            if($(this).val()=='Si'){
                $('body .form-no-espontanea').addClass('hide');
                $('body .form-espontaneo').removeClass('hide');
            }else{
                $('body .form-no-espontanea').removeClass('hide');
                $('body .form-espontaneo').addClass('hide');
            }
        })
    });

    $('.solicitud-am-choque').submit(function (e){
        e.preventDefault();
        $.ajax({
            url: base_url+'Asistentesmedicas/Choque/AjaxAsistenteMedica',
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                console.log(data);
                if(data.accion=='1'){
                    // AbrirDocumentoMultiple(base_url+'inicio/documentos/HojaFrontal/'+$('input[name=triage_id]').val(),'HojaFrontal',100);
                    if($('select[name=pia_lugar_accidente]').val()=='TRABAJO'){
                        AbrirDocumentoMultiple(base_url+'inicio/documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',800);
                    }
                    ActionCloseWindowsReload();
                }
            },error: function (e) {
                msj_error_serve();
                console.log(e);
                bootbox.hideAll();
                ReportarError(window.location.pathname,e.responseText)
            }
        })
    })

    if($('input[name=triage_paciente_afiliacion_bol]').attr('data-value')!=''){
        $('.triage_paciente_afiliacion_bol').removeClass('hide');
        $('input[name=triage_paciente_afiliacion_bol][value="Si"]').attr('checked',true);
    }
    $('input[name=triage_paciente_afiliacion_bol]').click(function () {
        if($(this).val()=='Si'){
            $('.triage_paciente_afiliacion_bol').removeClass('hide');
        }else{
            $('.triage_paciente_afiliacion_bol').addClass('hide');
        }
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
                    }if(data.accion=='2'){
                        if(confirm('EL N° DE PACIENTE NO EXISTE, ¿DESEA AGREGARLO A ESTA ÁREA?')){
                            $.ajax({
                                url: base_url+"Choque/Choquev2/AjaxIngresoChoque",
                                type: 'POST',
                                dataType: 'json',
                                data:{
                                    triage_id:triage_id,
                                    csrf_token:csrf_token
                                },beforeSend: function (xhr) {
                                    msj_loading('Ingresando paciente a esta área...');
                                },success: function (data, textStatus, jqXHR) {
                                    bootbox.hideAll();
                                    if(data.accion=='1'){
                                        AsociarCama(triage_id,cama_id);
                                    }
                                },error: function (e) {
                                    msj_error_serve();
                                    console.log(e);
                                    bootbox.hideAll();
                                    ReportarError(window.location.pathname,e.responseText)
                                }
                            })
                        }
                    }if(data.accion=='3'){
                        msj_error_noti('EL N° DE PACIENTE YA TIENE ASIGNADO UNA CAMA');
                    }if(data.accion=='4'){
                        if(confirm('EL PACIENTE YA FUE DADO DE ALTA DE ESTA ÁREA, ¿DESEA REINGRESAR AL PACIENTE?')){
                            $.ajax({
                                url: base_url+"Choque/Camasv2/AjaxReingreso",
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
                                        AsociarCama(triage_id,cama_id);
                                    }
                                },error: function (e) {
                                    msj_error_serve();
                                    console.log(e);
                                    ReportarError(window.location.pathname,e.responseText)
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
                                        msj_error_serve(e);
                                        ReportarError(window.location.pathname,e.responseText)
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
                        ReportarError(window.location.pathname,e.responseText)
                    }
                })
            }else{
                msj_error_noti('INGRESAR MATRICULA');
            }
        }
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
                },error: function (e) {
                    msj_error_serve();
                    ReportarError(window.location.pathname,e.responseText)
                }
           })
        }
    })
      $('input[name=pia_procedencia_espontanea]').click(function (e){
        if($(this).val()=='Si'){
            $('input[name=pia_procedencia_espontanea_lugar]').prop('type','text').attr('required',true);
            $('.col-no-espontaneo').addClass('hidden');
            $('select[name=pia_procedencia_hospital]').val("");
            $('input[name=pia_procedencia_hospital_num]').removeAttr('required').val('');
        }else{
            $('input[name=pia_procedencia_espontanea_lugar]').prop('type','hidden').removeAttr('required').val('');
            $('.col-no-espontaneo').removeClass('hidden');
            $('input[name=pia_procedencia_hospital_num]').attr('required',true);
        }
    })
    if($('input[name=pia_procedencia_espontanea]').attr('data-value')=='No'){
        $('.col-no-espontaneo').removeClass('hidden');
        $('input[name=pia_procedencia_espontanea][value="No"]').prop("checked",true);
        $('input[name=pia_procedencia_espontanea_lugar]').prop('type','hidden').removeAttr('required');
        
        $("select[name=pia_procedencia_hospital]").val($('select[name=pia_procedencia_hospital]').attr('data-value'));
        $('input[name=pia_procedencia_hospital_num]').attr('required',true);
    }
     $('body').on('click','.editar-paciente-choque',function(e) {        
        // guardarDatosPacienteChocado({
        //     nombre:$(this).attr('data-nombre'),
        //     complemento:$(this).attr('data-obs'),
        //     diagnostico_id:$(this).attr('data-id'),
        //     tipo_diagnostico:$(this).attr('data-tipo_diagnostico'),
        //     ecabezado_titulo:'Editar',
        //     accion:'edit'
        // })
        var tipo =  $('select[name="triage_tipo_paciente"] option:selected').text();
        e.preventDefault();
        bootbox.confirm({
            title:'<h5>REGISTRO DE PACIENTE EN ESTADO DE ATENCIÓN URGENTE</h5>',
            message:'<div class="row">'+
                '<div class="col-md-12">'+
                    '<div class="form-group">'+
                        '<select class="form-control" id="triage_tipo_paciente" name="triage_tipo_paciente" required>'+
                            '<option value="" default>SELECCIONAR CONDICIÓN...</option>'+
                            '<option value="Identificado">tipo</option>'+
                            '<option value="No Identificado">NO IDENTIFICADO</option>'+
                        '</select>'+
                    '</div>'+
                    '<div class="form-group form-identificado hide">'+
                        '<label><b>PROCEDENCIA ESPONTANEA</b></label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="pia_procedencia_espontanea" value="Si" checked>'+
                            '<i class="blue"></i>Si'+
                        '</label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="pia_procedencia_espontanea" value="No" >'+
                            '<i class="blue"></i>No'+
                        '</label>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12">'+
                    '<div class="form-group form-espontaneo form-no-identificado ">'+
                        '<input name="pia_procedencia_espontanea_lugar" type="text" placeholder="Lugar de Procedencia"  class="form-control" required>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-no-espontanea hide">'+
                        '<select name="pia_procedencia_hospital"  class="form-control">'+
                            '<option value="UMF">UMF</option>'+
                            '<option value="HGZ">HGZ</option>'+
                            '<option value="UMAE">UMAE</option>'+
                        '</select>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-no-espontanea hide">'+
                        '<input name="pia_procedencia_hospital_num"  type="text" placeholder="NOMBRE/NUMERO DEL HOSPITAL"  class="form-control">'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12"></div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-identificado hide">'+
                        '<input name="triage_nombre_ap"  type="text" placeholder="Apellido Paterno"  class="form-control" required>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-identificado hide">'+
                        '<input name="triage_nombre_am"  type="text" placeholder="Apellido Materno"  class="form-control" required>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12">'+
                    '<div class="form-group form-identificado hide">'+
                        '<input name="triage_nombre"  type="text" placeholder="Nombre del Paciente"  class="form-control" required>'+
                    '</div>'+
                    '<div class="form-group form-no-identificado ">'+
                        '<input name="triage_nombre_pseudonimo" type="text" placeholder="Pseudonimo del Paciente"  class="form-control" required>'+
                    '</div>'+
                    '<div class="form-group form-identificado hide">'+
                        '<label><b>Cuenta con N.S.S</b></label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="triage_paciente_afiliacion_bol" value="Si" >'+
                            '<i class="blue"></i>Si'+
                        '</label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="triage_paciente_afiliacion_bol" value="No" checked="">'+
                            '<i class="blue"></i>No'+
                        '</label>'+
                    '</div>'+
                    '<div class="form-group form-identificado-nss hide">'+
                        '<div class="row">'+
                            '<div class="col-md-6" style="padding-right:2px">'+
                                '<input name="pum_nss" type="text" placeholder="N.S.S"  class="form-control item" required>'+
                            '</div>'+
                            '<div class="col-md-6" style="padding-left:2px">'+
                                '<input name="pum_nss_agregado" type="text" placeholder="N.S.S AGREGADO"  class="form-control" required>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group form-no-paciente">'+
                        '<select class="form-control" name="triage_paciente_sexo" required>'+
                            '<option value="">SELECCIONAR SEXO</option>'+
                            '<option value="HOMBRE">HOMBRE</option>'+
                            '<option value="MUJER">MUJER</option>'+
                        '</select>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<input name="triage_fecha_nac_a" type="text" placeholder="Año de Nac. Ejemplo: 1990"  class="form-control dd-mm-yyyy" required>'+
                    '</div>'+
                '</div>'+
            '</div>',
            callback:function (result) {
                var triage_tipo_paciente=$('body #triage_tipo_paciente').val();
                var triage_nombre=$('body input[name=triage_nombre]').val();
                var triage_nombre_ap=$('body input[name=triage_nombre_ap]').val();
                var triage_nombre_am=$('body input[name=triage_nombre_am]').val();
                var triage_nombre_pseudonimo=$('body input[name=triage_nombre_pseudonimo]').val();
                var triage_paciente_afiliacion_bol=$('body input[name=triage_paciente_afiliacion_bol]:checked').val();
                var pia_procedencia_espontanea=$('body input[name=pia_procedencia_espontanea]:checked').val();
                var pia_procedencia_espontanea_lugar=$('body input[name=pia_procedencia_espontanea_lugar]').val();
                var pia_procedencia_hospital=$('body select[name=pia_procedencia_hospital]').val();
                var pia_procedencia_hospital_num=$('body input[name=pia_procedencia_hospital_num]').val();
                var pum_nss=$('body input[name=pum_nss]').val();
                var pum_nss_agregado=$('body input[name=pum_nss_agregado]').val();
                var triage_paciente_sexo=$('body select[name=triage_paciente_sexo]').val();
                var triage_fecha_nac_a=$('body input[name=triage_fecha_nac_a]').val();
                if(result==true){
                    if(triage_fecha_nac_a.length>=4){
                        $.ajax({
                            url: base_url+"Asistentesmedicas/Choque/GenerarFolioV2",
                            type: 'POST',
                            dataType: 'json',
                            data:{
                                triage_tipo_paciente:triage_tipo_paciente,
                                triage_nombre:triage_nombre,
                                triage_nombre_ap:triage_nombre_ap,
                                triage_nombre_am:triage_nombre_am,
                                triage_nombre_pseudonimo:triage_nombre_pseudonimo,
                                pia_procedencia_espontanea:pia_procedencia_espontanea,
                                pia_procedencia_espontanea_lugar:pia_procedencia_espontanea_lugar,
                                pia_procedencia_hospital:pia_procedencia_hospital,
                                pia_procedencia_hospital_num:pia_procedencia_hospital_num,
                                triage_paciente_afiliacion_bol:triage_paciente_afiliacion_bol,
                                pum_nss:pum_nss,
                                pum_nss_agregado:pum_nss_agregado,
                                triage_paciente_sexo:triage_paciente_sexo,
                                triage_fecha_nac_a:triage_fecha_nac_a,
                                csrf_token:csrf_token
                            },beforeSend: function (data, textStatus, jqXHR) {
                                msj_loading('Guardando registro...');
                            },success: function (data, textStatus, jqXHR) {
                                bootbox.hideAll();
                                if(data.accion=='1'){
                                    ActionWindowsReload()
                                    //console.log(data);
                                   //location.href=base_url+'Asistentesmedicas/Choque/Triage/'+data.max_id;
                               }
                            },error: function (e) {
                                bootbox.hideAll();
                                msj_error_serve();
                                ReportarError(window.location.pathname,e.responseText)
                            }
                        });
                    }else{
                        msj_error_noti('ERROR AL ESPECIFICAR EL FORMATO DE FECHA');
                    }
                }
            }
        });
    });

})
