$(document).ready(function () {
    $('.btn-obtener-camas').click(function () {
        if($('select[name=area_id]').val()!=''){
            $.ajax({
                url: base_url+"Pisos/AjaxObtenerCamas",
                type: 'POST',
                dataType: 'json',
                data:{
                    csrf_token:csrf_token,
                    area_id:$('select[name=area_id]').val(),
                    piso_id:$('input[name=piso_id]').val(),
                    sala_id:$('input[name=sala_id]').val()
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    $('.col-camas').html(data.col_md_3);
                    $.each(data.CamasAsignadas,function (i,e) {
                        $('body .cama_'+e.cama_id).prop('checked',true).attr('data-accion','Eliminar');
                    })
                },error: function (jqXHR, textStatus, errorThrown) {
                    bootbox.hideAll();
                    msj_error_serve()
                }
            })
        }else{
            msj_error_noti('Seleccionar una área');
        }
    })
    $('body').on('click','input[name=cama_id]',function () {
        var el=$(this);
        
        var cama_id=$(this).attr('data-id');
        var sala_id=$(this).attr('data-sala');
        var accion=$(this).attr('data-accion');
        $.ajax({
            url: base_url+"Pisos/AjaxAsignarCamas",
            type: 'POST',
            dataType: 'json',
            data:{
                cama_id:cama_id,
                sala_id:sala_id,
                accion:accion,
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                if(accion=='Agregar'){
                    msj_success_noti('Agregando Cama')
                }else{
                    msj_error_noti('Eliminando Cama')
                }
                
            },success: function (data, textStatus, jqXHR) {
                if(data.accion=='1'){
                    if(accion=='Agregar'){
                        msj_success_noti('<i class="fa fa-check" style="color:#4caf50"></i> Agregado')
                    }else{
                        msj_success_noti('<i class="fa fa-check" style="color:#4caf50"></i> Eliminado')
                    }
                    
                }if(data.accion=='2'){
                    el.attr('checked',false);
                    el.attr('data-accion','Agregar');
                    msj_error_noti('<i class="fa fa-times" style="color:red"></i> La cama ya esta asignada a otro piso')
                }
                AjaxCamasAsignadas()
            },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve()
            }
        })
        if(el.is(':checked')){
            el.attr('data-accion','Eliminar');
        }else{
            el.attr('data-accion','Agregar');
        }
    })
    if($('input[name=piso_id]').val()!=undefined){
        AjaxCamasAsignadas();
    }
    function AjaxCamasAsignadas() {
        $.ajax({
            url: base_url+"Pisos/AjaxCamasAsignadas",
            type: 'POST',
            dataType: 'json',
            data: {
                csrf_token:csrf_token,
                piso_id:$('input[name=piso_id]').val(),
                sala_id:$('input[name=sala_id]').val()
            },beforeSend: function (xhr) {
            },success: function (data, textStatus, jqXHR) {
                $('.col-camas-asignadas').html(data.col_md_3);
            },error: function (jqXHR, textStatus, errorThrown) {
                
            }
        })
    }
    $('select[name=SELECCIONAR_AREA]').change(function () {
        AjaxGestionCamas($(this).val());
    })
    if($('input[name=tipo]').val()!=undefined){
        if($('input[name=area]').val()!='Administrador'){
            AjaxGestionCamas($('input[name=area_id]').val());
        }else{
            AjaxGestionCamas('');
        }
    }
    function AjaxGestionCamas(area){
        $.ajax({
            url: base_url+"Pisos/Camas/AjaxGestionCamas",
            type: 'POST',
            dataType: 'json',
            data:{
                area:area,
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.Total_Camas').attr('data-area',area).attr('data-tipo','Total').find('h2').html(data.Total+' Camas');
                $('.Total_Camas_Disponibles').attr('data-area',area).attr('data-tipo','Disponibles').find('h2').html(data.Disponibles+' Camas');
                $('.Total_Camas_Ocupadas').attr('data-area',area).attr('data-tipo','Ocupados').find('h2').html(data.Ocupados+' Camas');
                $('.Total_Camas_Mantenimiento').attr('data-area',area).attr('data-tipo','Mantenimiento').find('h2').html(data.Mantenimiento+' Camas');
                $('.Total_Camas_Limpieza').attr('data-area',area).attr('data-tipo','Limpieza').find('h2').html(data.Limpieza+' Camas');
            },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve();
            }
        });
    }
    $('.Total_Camas,.Total_Camas_Disponibles, .Total_Camas_Ocupadas,.Total_Camas_Limpieza,.Total_Camas_Mantenimiento').click(function (e) {
        e.preventDefault();
        console.log($(this).attr('data-url'));
        if($(this).attr('data-area')!=''){ 
            if($(this).attr('data-url')==undefined){
                window.open(base_url+'Pisos/Camas/CamasDetalles?area='+$(this).attr('data-area')+'&tipo='+$(this).attr('data-tipo'),'_blank')
            }else{
                window.open(base_url+'Observacion/Camas/CamasDetalles?area='+$(this).attr('data-area')+'&tipo='+$(this).attr('data-tipo'),'_blank')
            }
        }
    })
    $('select[name=area_id_lc]').change(function () {
        AjaxLimpiezaCamas($(this).val());
    })
    function AjaxLimpiezaCamas(area_id) {
        $.ajax({
            url: base_url+"Pisos/Camas/AjaxLimpiezaCamas",
            type: 'POST',
            dataType: 'json',
            data: {
                csrf_token:csrf_token,
                area_id:area_id
            },beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.row-camas').html(data.result_camas)
            },error: function (e) {
                msj_error_serve()
                bootbox.hideAll();
                console.log(e);
            }
        })
    }
    $('body').on('click','.cambiar-genero-cama',function (e) {
        e.preventDefault();
        var cama_id=$(this).attr('data-cama');
        bootbox.confirm({
            title:'<h5>Cambiar Genero Cama</h5>',
            message:'<div class="row">'+
                            '<div class="col-md-12">'+
                                '<div class="form-group">'+
                                    '<select class="form-control" name="cama_genero">'+
                                        '<option value="">Seleccionar</option>'+
                                        '<option value="Hombre">Hombre</option>'+
                                        '<option value="Mujer">Mujer</option>'+
                                   '</select>'+
                                '</div>'+
                            '</div>'+
                        '</div>',
            size:'small',
            callback:function (res) {
                if(res==true){
                    $.ajax({
                        url: base_url+"Pisos/Camas/AjaxCambiarGeneroCama",
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            csrf_token:csrf_token,
                            cama_id:cama_id,
                            cama_genero:$('body select[name=cama_genero]').val()
                        },beforeSend: function (xhr) {
                            msj_success_noti('Guardando Cambios...');
                        },success: function (data, textStatus, jqXHR) {
                            if(data.accion=='1'){
                                msj_success_noti('Cambios Guardados.');
                                AjaxLimpiezaCamas($('select[name=area_id_lc]').val());
                            }
                        },error: function (e) {
                            console.log(e);
                            msj_error_serve();
                        }
                    })
                }
            }
        })
    })
    $('body').on('click','.dar-mantenimiento,.finalizar-mantenimiento',function(e){
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
                        if($('input[name=VisorCamas]').val()!=undefined && $('input[name=VisorCamas]').val('Visor de Camas')){
                            AjaxVisorCamas()
                        }else{
                            AjaxLimpiezaCamas($('select[name=area_id_lc]').val());
                        }
                        
                        
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    msj_error_serve()
                }
           })
        }
    })
    $('.btn-add-sala').click(function (e) {
        e.preventDefault();
        var sala_nombre=prompt('Nombre de la Sala:',$(this).attr('data-sala'));
        var sala_id=$(this).attr('data-id');
        var piso_id=$(this).attr('data-piso');
        var accion=$(this).attr('data-accion');
        if(sala_nombre!=null && sala_nombre!=''){
            $.ajax({
                url: base_url+"Pisos/AjaxSala",
                type: 'POST',
                dataType: 'json',
                data:{
                    sala_id:sala_id,
                    sala_nombre:sala_nombre,
                    piso_id:piso_id,
                    accion:accion,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    location.reload();
                },error: function (e) {
                    msj_error_serve();
                    bootbox.hideAll();
                    console.log(e)
                }
            })
        }
    })
    if($('input[name=filtro_camas_por_piso]').val()!=undefined && $('input[name=filtro_camas_por_piso]').val()=='Pisos'){
        AjaxLimpiezaCamas(0);
    }
    $('.info-paciente').click(function (e) {
        var ingreso=$(this).attr('data-ingreso');
        var tiempo=$(this).attr('data-tiempo');
        MsjNotificacion('<h5>Detalles del Paciente</h5>','<h5 style="line-height:1.4">Ingreso: '+ingreso+'<br>Tiempo Transcurrido:'+tiempo+'</h5>')
    })
    if($('input[name=VisorCamas]').val()!=undefined && $('input[name=VisorCamas]').val('Visor de Camas')){
        AjaxVisorCamas()
    }
    $('.actualizar-visor').click(function (e) {
        e.preventDefault();
        AjaxVisorCamas();
    })
    function AjaxVisorCamas() {
        $.ajax({
            url: base_url+"Pisos/Camas/AjaxVisorCamas",
            type: 'POST',
            dataType: 'json',
            data: {
                csrf_token:csrf_token,
            },beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.row-camas-visor').html(data.result_camas)
                $('.visor-camas-disponibles').html(data.TOTAL_CD);
                $('.visor-camas-ocupadas').html(data.TOTAL_CO);
                $('.visor-camas-enmantenimiento').html(data.TOTAL_CM);
                $('.visor-camas-enlimpieza').html(data.TOTAL_CL);
                $('.visor-camas-descompuestas').html(data.TOTAL_CDES);
            },error: function (e) {
                msj_error_serve()
                bootbox.hideAll();
                console.log(e);
            }
        })
    }
        /*Indicador*/
    $('select[name=TipoBusqueda]').change(function () {
        $('.row-result-fecha').addClass('hide');
        $('.row-result-hora').addClass('hide');
        if($(this).val()=='POR_FECHA'){
            
            $('.row-por-fecha').removeClass('hide');
            $('.row-por-hora').addClass('hide');
            $('.FILTRO_POR_FECHA').removeClass('hide');
            
        }if($(this).val()=='POR_HORA'){
            $('.row-por-hora').removeClass('hide');
            $('.row-por-fecha').addClass('hide');
            $('.FILTRO_POR_FECHA').addClass('hide');
        }if($(this).val()==''){
            
            $('.row-por-hora').addClass('hide');
            $('.row-por-fecha').addClass('hide');
            $('.FILTRO_POR_FECHA').addClass('hide');
        }
    })
    $('body').on('click','.btn-indicador-pisos',function () {
        var TipoBusqueda=$('select[name=TipoBusqueda]').val();
        var by_fecha_inicio=$('input[name=by_fecha_inicio]').val();
        var by_fecha_fin=$('input[name=by_fecha_fin]').val();
        var by_hora_fecha=$('input[name=by_hora_fecha]').val();
        var by_hora_inicio=$('input[name=by_hora_inicio]').val();
        var by_hora_fin=$('input[name=by_hora_fin]').val();
        $.ajax({
            url: base_url+"Pisos/Camas/AjaxIndicador",
            type: 'POST',
            data:{
                TipoBusqueda:TipoBusqueda,
                by_fecha_inicio:by_fecha_inicio,
                by_fecha_fin:by_fecha_fin,
                by_hora_fecha:by_hora_fecha,
                by_hora_inicio:by_hora_inicio,
                by_hora_fin:by_hora_fin,
                csrf_token:csrf_token
            },dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                console.log(data)
                $('.total-ingresos')
                        .attr('target','_blank')
                        .attr('href',base_url+'Pisos/Camas/IndicadorDetalles?TipoBusqueda='+TipoBusqueda+'&by_fecha_inicio='+by_fecha_inicio+'&by_fecha_fin='+by_fecha_fin+'&by_hora_fecha='+by_hora_fecha+'&by_hora_inicio='+by_hora_inicio+'&by_hora_fin='+by_hora_fin+'&TIPO_ACCCION=INGRESO')
                        .find('h3').html(data.INGRESOS+' Pacientes');
                $('.total-altas')
                        .attr('target','_blank')
                        .attr('href',base_url+'Pisos/Camas/IndicadorDetalles?TipoBusqueda='+TipoBusqueda+'&by_fecha_inicio='+by_fecha_inicio+'&by_fecha_fin='+by_fecha_fin+'&by_hora_fecha='+by_hora_fecha+'&by_hora_inicio='+by_hora_inicio+'&by_hora_fin='+by_hora_fin+'&TIPO_ACCION=ALTAS')
                        .find('h3').html(data.ALTAS+' Pacientes');
                
        },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    })
    if($('input[name=PisosAjax]').val()=='EstatusCamas'){
        AjaxEstatusCamas();
    }
    function AjaxEstatusCamas() {
        $.ajax({
            url: base_url+"Pisos/Camas/AjaxEstatusCamas",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                console.log(data)
                $('.row-camasEstatus').html(data.colCamas);
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e)
            }
        })
    }
    $('input[name=inputMedicoPisos]').focus();
    $('input[name=inputMedicoPisos]').keyup(function (e) {
        var input=$(this);
        var triage_id=$(this).val();
        if(triage_id.length==11 && triage_id!=''){
            $.ajax({
                url: base_url+"Pisos/Medico/AjaxBuscarPaciente",
                type: 'POST',
                data: {
                    triage_id:triage_id,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.accion=='1'){
                        window.location.href=base_url+'Sections/Documentos/Expediente/'+triage_id+'/?tipo=Médico Torres Hospitalización';
                        //window.open(base_url+'Sections/Documentos/Expediente/'+triage_id+'/?tipo=Observación&via=Médico Pisos','_blank')
                    }if(data.accion=='2'){
                        msj_error_noti('EL PACIENTE NO SE ENCUENTRA EN EL ÁREA DE PISOS');
                    }
                },error: function (e) {
                    bootbox.hideAll();
                    MsjError();
                    console.log(e)
                }
            });
            input.val('');
        }
    });
})