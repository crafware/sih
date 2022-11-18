$(document).ready(function () {
    $('#multi').select2();
    
        $('#multi').val($('#multi').attr('data-value')).select2();
    $('select[name=contrato_id]').val($('select[name=contrato_id]').attr('data-value'));
        
    $('.guardar-materiales').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Abasto/Catalogos/AjaxNuevoCatalogo",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data) {
                if(data.accion==='1'){
                    location.href=base_url+'Abasto/Catalogos';
                }
            },error: function () {
                msj_error_serve();
                bootbox.hideAll();
            }
        });
    });
    $('.guardar-sistemas').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Abasto/Catalogos/AjaxNuevoSistema",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function () {
                msj_loading();
            },success: function (data) {
                if(data.accion=='1'){
                    location.href=base_url+'Abasto/Catalogos/Sistemas?catalogo='+$('input[name=catalogo_id]').val();
                }
            },error: function (e) {
                console.log(e);
                msj_error_serve();
                bootbox.hideAll();
            }
        });
    });
    $('.guardar-elemento').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Abasto/Catalogos/AjaxNuevoElemento",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data) {
                if(data.accion=='1'){
                    location.href=base_url+'Abasto/Catalogos/Elementos?catalogo='+$('input[name=catalogo_id]').val()+'&sistema='+$('input[name=sistema_id]').val();
                }
            },error: function (e) {
                console.log(e);
                msj_error_serve();
                bootbox.hideAll();
            }
        });
    });
    $('.guardar-rango').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Abasto/Catalogos/AjaxNuevoRango",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function () {
                msj_loading();
            },success: function (data) {
                if(data.accion==='1'){
                    location.href=base_url+'Abasto/Catalogos/Rangos?catalogo='+$('input[name=catalogo_id]').val()+'&sistema='+$('input[name=sistema_id]').val()+'&elemento='+$('input[name=elemento_id]').val();
                }
            },error: function (e) {
                console.log(e);
                msj_error_serve();
                bootbox.hideAll();
            }
        });
    });
    if($('input[name=elemento_img]').val()!=''){
        $('.html5imageupload').css({
            'background':'url('+base_url+'assets/materiales/'+$('input[name=elemento_img]').val()+')',
            'width':'100%!important',
            'background-size': 'cover'
        });
    }
    
    $('body').on('click','.view-image',function (e) {
        MsjNotificacion('VER IMAGEN','<img src="'+$(this).attr('data-image')+'" style="width:100%;height:200px">')
    });
    
    $('body').on('click','.eliminar-insumos_tipo',function () {
        var id=$(this).attr('data-id');
        var tipo=$(this).attr('data-tipo');
        var dependencia=$(this).attr('data-id_dependencia');
        if(confirm('¿DESEA ELIMINAR EL '+$(this).attr('data-tipo').toUpperCase()+' '+$(this).attr('data-nombre').toUpperCase()+'?')){
            $.ajax({
                url: base_url+"Abasto/Catalogos/AjaxEliminar",
                type: 'POST',
                dataType: 'json',
                data:{
                    csrf_token:csrf_token,
                    id:id,
                    tipo:tipo,
                    dependencia:dependencia
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data) {
                    if(data.accion==='1'){
                        msj_error_noti('REGISTRO ELIMINADO');
                        ActionWindowsReload();
                    }
                },error: function (e) {
                    console.log(e);
                    msj_error_serve();
                    bootbox.hideAll();
                }
            });
        }
    });
    
    $('body').on('click','.eliminar-cantidad',function () {
        var id=$(this).attr('data-id');
        var tipo=$(this).attr('data-tipo');
        var dependencia=$(this).attr('data-id_dependencia');
        if(confirm('¿DESEA ELIMINAR EL CODIGO '+id+'?')){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/AjaxEliminar",
                type: 'POST',
                dataType: 'json',
                data:{
                    csrf_token:csrf_token,
                    id:id,
                    tipo:tipo,
                    dependencia:dependencia
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data) {
                    if(data.accion==='1'){
                        msj_error_noti('REGISTRO ELIMINADO');
                        ActionWindowsReload();
                    }
                },error: function (e) {
                    console.log(e);
                    msj_error_serve();
                    bootbox.hideAll();
                }
            });
        }
    });
    
    $('body').on('click','.icono-add-existencia',function (e) {
        e.preventDefault();
        var catalogo_id=$(this).attr('data-catalogo');
        var sistema_id=$(this).attr('data-sistema');
        var elemento_id=$(this).attr('data-elemento');
        var rango_id=$(this).attr('data-rango');
        bootbox.confirm({
            title:'<h5>AGREGAR CANTIDAD</h5>',
            message:'<div class="row">'+
                        '<div class="col-md-12">'+
                            '<div class="form-group">'+
                                '<input type="number" name="existencia_id" min="1" class="form-control" placeholder="Cantidad en Existencia">'+
                            '</div>'+
                        '</div>'+
                    '</div>',
            size:'small',
            buttons:{
                cancel:{
                    label:'Cancelar'
                },confirm:{
                    label:'Agregar'
                }
            },callback:function (response) {
                if(response===true){
                    $.ajax({
                        url: base_url+"Abasto/Inventario/AjaxAgregarExistencia",
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            catalogo_id:catalogo_id,
                            sistema_id:sistema_id,
                            elemento_id:elemento_id,
                            rango_id:rango_id,
                            existencia_id:$('body input[name=existencia_id]').val(),
                            csrf_token:csrf_token
                        },beforeSend: function () {
                            msj_loading();
                        },success: function (data) {
                            bootbox.hideAll();
                            if(data.accion==='1'){
                                location.href=base_url+'Abasto/Inventario/Exitencia?catalogo='+catalogo_id+'&sistema='+sistema_id+'&elemento='+elemento_id+'&rango='+rango_id;
                            }
                        },error: function (e) {
                            console.log(e);
                            msj_error_serve();
                            bootbox.hideAll();
                        }
                    });
                }
            }
        });
    });
    

    if($('#consumos_filtrar')[0]){
        FiltrarConsumos();
    }

    $('input[name=rango_id]').focus();
    $('input[name=rango_id]').keyup(function (e) {
        e.preventDefault();
        var rango_id=$(this).val();
        var input=$(this);
        if(rango_id.length===12 && rango_id!==''){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/AjaxBuscarConsumo",
                type: 'POST',
                dataType: 'json',
                data:{
                    tipo:'insumo',
                    vale_servicio_id:$('#vale_servicio_id').val(),
                    rango_id:$('input[name=rango_id]').val(),
                    csrf_token:csrf_token
                },beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    FiltrarConsumos();
                    bootbox.hideAll();
                    if(data.accion === '1'){
                        msj_success_noti('Registro Filtrado');
                    }else if (data.accion === '2') {
                        msj_error_noti('No se encontrarón resultados');
                    }else if(data.accion === '3'){
                        msj_error_noti('El producto ya fue agregado');
                    }
                },error: function (e) {
                    console.log(e);
                    bootbox.hideAll();
                    MsjError();
                }
            });
            input.val('');
        }else {
            input.val('');
            msj_error_noti('Código invalido');
        }
    });
    
    $('input[name=cantidad_id_inst]').focus();
    $('input[name=cantidad_id_inst]').keyup(function (e) {
        e.preventDefault();
        var instrumental_id=$(this).val();
        var input=$(this);
        if(instrumental_id.length===11 && instrumental_id!==''){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/AjaxBuscarConsumo",
                type: 'POST',
                dataType: 'json',
                data:{
                    tipo:'instrumental',
                    vale_servicio_id:$('#vale_servicio_id').val(),
                    cantidad_id_inst:$('input[name=cantidad_id_inst]').val(),
                    csrf_token:csrf_token
                },beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    FiltrarConsumos();
                    bootbox.hideAll();
                    if(data.accion === '3'){
                        msj_success_noti('Registro Filtrado');
                    }else if (data.accion === '2') {
                        msj_error_noti('No se encontrarón resultados');
                    }
                },error: function (e) {
                    console.log(e);
                    bootbox.hideAll();
                    MsjError();
                }
            });
            input.val('');
        }else {
            console.log(e);
            input.val('');
            msj_error_noti('Código invalido');
        }
    });
    
    $('input[name=cantidad_id_equi]').focus();
    $('input[name=cantidad_id_equi]').keyup(function (e) {
        e.preventDefault();
        var cantidad_id_equi=$(this).val();
        var input=$(this);
        if(cantidad_id_equi.length===11 && cantidad_id_equi!==''){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/AjaxBuscarConsumo",
                type: 'POST',
                dataType: 'json',
                data:{
                    tipo:'equipamiento',
                    vale_servicio_id:$('#vale_servicio_id').val(),
                    cantidad_id_equi:$('input[name=cantidad_id_equi]').val(),
                    csrf_token:csrf_token
                },beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    FiltrarConsumos();
                    bootbox.hideAll();
                    if(data.accion === '1'){
                        msj_success_noti('Registro Filtrado');
                    }else if (data.accion === '2') {
                        msj_error_noti('No se encontrarón resultados');
                    }
                },error: function (e) {
                    console.log(e);
                    bootbox.hideAll();
                    MsjError();
                }
            });
            input.val('');
        }else {
            input.val('');
            msj_error_noti('Código invalido');
        }
    });

    $('body').on('click','.eliminar_consumo', function() {
        if(confirm("¿DESEA DESCARTAR EL CONSUMO "+$(this).attr('data-consumo').toUpperCase()+" ?")){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/DescartarConsumo",
                type: 'POST',
                dataType: 'json',
                data:{
                    idpConsumo:$(this).attr('data-idConsumo'),
                    tipo_consumo: $(this).attr('data-idtipo'),
                    csrf_token:csrf_token
                },beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    
                    if(data.accion === '2') {
                        bootbox.hideAll();
                        msj_error_noti('Ocurrion un error');
                    }else {
                        bootbox.hideAll();
                        msj_success_noti("Consumo descartado");
                    }
                    FiltrarConsumos();
                },error: function (e) {
                    console.log(e);
                    bootbox.hideAll();
                    MsjError();
                }
            });
        }
    });
    
    $('input[name=triage_id]').focus();
    $('input[name=triage_id]').keyup(function () {
        var paciente_id=$(this).val();
        var input=$(this);
        if(paciente_id.length===11 && paciente_id!==''){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/AjaxBuscarPaciente",
                type: 'POST',
                dataType: 'json',
                data:{
                    action:$('#accion').val(),
                    triage_id:paciente_id,
                    csrf_token:csrf_token
                },beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    if(data.accion==='1'){
                        console.log(data);
                        if(data.action === 'add') {
                           window.location.href=base_url+'Abasto/MinimaInvacion/ValeServicio?accion=add&paciente='+paciente_id;
                        }else {
                            window.location.href=base_url+'Abasto/MinimaInvacion/ValeServicio?vale_servicio_id='+$('body input[name=vale_servicio_id]').val()+'&accion=edit&paciente='+paciente_id+"&matricula_medica="+$('body input[name=matricula_medica]').val();
                        }
                    }else {
                        msj_error_noti('El paciente no existe');
                    }
                },error: function (e) {
                    console.log(e);
                    bootbox.hideAll();
                    MsjError();
                }
            });
            input.val('');
        }
    });

    $('input[name=medico_matricula]').focus();
    $('input[name=medico_matricula]').keyup(function () {
        var medico_matricula=$(this).val();
        var triage = $('#triage_id').val();
        var input=$(this);
        if(medico_matricula!==''){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/AjaxBuscarMedico",
                type: 'POST',
                dataType: 'json',
                data:{
                    medico_matricula:medico_matricula,
                    action:$('#accion').val(),
                    csrf_token:csrf_token
                },beforeSend: function () {
                },success: function (data) {
                    console.log(medico_matricula+"-"+triage);
                    if(data.accion==='2'){
                        msj_error_noti('Matricula no encontrada');
                    }else {
                        msj_success_noti("Matricula encontrada");
                        if(data.action === 'add') {
                           window.location.href=base_url+'Abasto/MinimaInvacion/ValeServicio?accion=add&paciente='+triage+"&matricula_medica="+medico_matricula;
                        }else {
                            window.location.href=base_url+'Abasto/MinimaInvacion/ValeServicio?vale_servicio_id='+$('body input[name=vale_servicio_id]').val()+'&accion=edit&paciente='+triage+"&matricula_medica="+medico_matricula;
                        }
                    }
                },error: function (e) {
                    console.log(e);
                    bootbox.hideAll();
                    MsjError();
                }
            });
            input.val('');
        }
    });
    
    $('input[name=procedimiento_c]').focus();
    $('input[name=procedimiento_c]').keyup(function () {
        var procedimiento_codigo=$(this).val();
        var proc = $('#vale_servicio_id').val();
        var matr = $('#matricula_medica').val();
        var triage = $('#triage_id').val();
        var action = $('#accion').val();
        var input=$(this);
        if(procedimiento_codigo!==''){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/AjaxBuscarProcedimiento",
                type: 'POST',
                dataType: 'json',
                data:{
                    procedimiento:procedimiento_codigo,
                    action:action,
                    csrf_token:csrf_token
                },beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    bootbox.hideAll();
                    if(data.accion==='2'){
                        msj_error_noti('Instrumental no encontrado');
                    }else {
                        msj_success_noti("Instrumental filtrado");
                        if(data.action === 'add') {
                           window.location.href=base_url+'Abasto/MinimaInvacion/ValeServicio?accion=add&paciente='+triage+"&matricula_medica="+matr+"&procedimiento_codigo="+procedimiento_codigo;
                        }else {
                            window.location.href=base_url+'Abasto/MinimaInvacion/ValeServicio?vale_servicio_id='+proc+'&accion=edit&paciente='+triage+"&matricula_medica="+matr+"&procedimiento_codigo="+procedimiento_codigo;
                        }
                    }
                },error: function (e) {
                    console.log(e);
                    bootbox.hideAll();
                    MsjError();
                }
            });
           input.val('');
        }
    });
    
    $('input[name=servicio]').focus();
    $('input[name=servicio]').keyup(function () {
        var solicitud = $(this).val();
        var procedimiento_codigo=$("#procedimiento_codigo").val();
        var proc = $('#vale_servicio_id').val();
        var matr = $('#matricula_medica').val();
        var triage = $('#triage_id').val();
        var action = $('#accion').val();
        var input=$(this);
        if(procedimiento_codigo!==''){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/AjaxBuscarSolicitud",
                type: 'POST',
                dataType: 'json',
                data:{
                    solicitud:solicitud,
                    action:action,
                    csrf_token:csrf_token
                },beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    bootbox.hideAll();
                    if(data.accion==='2'){
                        msj_error_noti('Servicio no encontrado');
                    }else {
                        msj_success_noti("Servicio filtrado");
                        if(data.action === 'add') {
                           window.location.href=base_url+'Abasto/MinimaInvacion/ValeServicio?accion=add&paciente='+triage+"&matricula_medica="+matr+"&procedimiento_codigo="+procedimiento_codigo+"&servicio="+solicitud;
                        }else {
                            window.location.href=base_url+'Abasto/MinimaInvacion/ValeServicio?vale_servicio_id='+proc+'&accion=edit&paciente='+triage+"&matricula_medica="+matr+"&procedimiento_codigo="+procedimiento_codigo+"&servicio="+solicitud;
                        }
                    }
                },error: function (e) {
                    console.log(e);
                    bootbox.hideAll();
                    MsjError();
                }
            });
           input.val('');
        }
    });
    
    $('body').on('click', '.addRango', function() {
        $.ajax({
            url: base_url+"Abasto/MinimaInvacion/addInventario",
            type: 'POST',
            dataType: 'json',
            data: {
                cantidad: cantidad,
                sistema_id: rango_id[1],
                rango: rango_id[0],
                csrf_token:csrf_token
            },beforeSend: function () {
                msj_loading();
            },success: function (data) {
                bootbox.hideAll();
                if(data.accion==='1'){
                    bootbox.dialog({
                        title:'<h5>CODIGOS NUEVOS GENERADOS</h5>',
                        message:'<div class="row">'+
                                    '<div class="col-md-12">'+
                                        '<table class="table table-hover table-bordered footable" data-page-size="10" style="font-size: 13px">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<th>CODIGO</th>'+
                                                    '<th>RANGO</th>'+
                                                    '<th>PROVEEDOR</th>'+
                                                    '<th>ACCIÓN</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody>'+
                                                data.data+
                                            '</tbody>'+
                                            '<tfoot class="hide-if-no-paging">'+
                                                '<tr>'+
                                                    '<td colspan="6" id="footerCeldas" class="text-center">'+
                                                        '<ul class="pagination"></ul>'+
                                                    '</td>'+
                                                '</tr>'+
                                            '</tfoot>'+
                                    '</div>'+
                                '</div>',
                        size:'big',
                        buttons:{
                            aceptar:{
                                label:'ACEPTAR',
                                className:'back-imss',
                                callback:function () {
                                    location.href = base_url+"Abasto/MinimaInvacion/Inventario";
                                }
                            }
                        }
                    });
                }else {
                    msj_error_noti("Ocurrio un error al consultar!");
                }
            },error: function (e) {
                console.log(e);
                msj_error_serve();
                bootbox.hideAll();
            }
        });
    });
    
    $('.guardar-vale-servicio').submit(function (e) {
        e.preventDefault();
        var formData=new FormData($(this)[0]);
        $.ajax({
            url: base_url+"Abasto/MinimaInvacion/GuardarValeServicio",
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            mimeType: 'multipart/form-data',
            beforeSend: function () {
                msj_loading();
            },success: function (data) {
                if(data.accion==='1'){
                    msj_success_noti('Registro Guardado');
                    opener.location.reload();
                    window.close();
                }
                if(data.accion==='2'){
                    msj_success_noti('Cambios Guardados');
                    opener.location.reload();
                    window.close();
                }
            },error: function (e) {
                msj_error_serve();
                console.log(e);
            }
        });
    });
    
    $('.guardar-procedimiento').submit(function () {
        $.ajax({
            url: base_url+"Abasto/Catalogos/GuardarProcedimiento",
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function () {
                msj_loading();
            },success: function (data) {
                if(data.accion==='1'){
                    msj_success_noti('Registro Guardado');
                    opener.location.reload();
                    window.close();
                }
                if(data.accion==='2'){
                }
            },error: function (e) {
                msj_error_serve();
                console.log(e);
            }
        });
    });
    
    $('body').on('click','.ver-documentos', function() {
        console.log($('body input[name=vale_servicio_id]').val());
        $.ajax({
            url: base_url+"Abasto/MinimaInvacion/VerDocumentos",
            type: 'POST',
            dataType: 'json',
            data:{
                vale_servicio_id:$('body input[name=vale_servicio_id]').val(),
                csrf_token:csrf_token
            },beforeSend: function () {
                msj_loading();
            },success: function (data) {
                if(data.accion === '2') {
                    bootbox.hideAll();
                    msj_error_noti('No tiene archivos guardados');
                }else {
                    bootbox.hideAll();
                    bootbox.dialog({
                        title:'<h5>PROCEDIMIENTO</h5>',
                        message:'<div class="row">'+
                                    '<div class="col-md-12">'+
                                        '<table class="table table-hover table-bordered footable" data-page-size="10" style="font-size: 13px">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<th>ARCHIVO</th>'+
                                                    '<th style="withd: 15%;">ACCIONES</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody>'+
                                                data.accion+
                                            '</tbody>'+
                                            '<tfoot class="hide-if-no-paging">'+
                                                '<tr>'+
                                                    '<td colspan="6" id="footerCeldas" class="text-center">'+
                                                        '<ul class="pagination"></ul>'+
                                                    '</td>'+
                                                '</tr>'+
                                            '</tfoot>'+
                                    '</div>'+
                                '</div>',
                        size:'big',
                        buttons:{
                            cancel:{
                                label:'CERRAR',
                                className:'btn back-imss'
                            }
                        },callback:function () {
                            bootbox.hideAll();
                        }
                    });
                }
            },error: function (e) {
                console.log(e);
                bootbox.hideAll();
                MsjError();
            }
        });
    });
    
    $('body').on('click', '.eliminar-evidencia', function() {
        if (confirm("¿DESEA ELIMINAR ESTA EVIDENCIA PERMANENTEMENTE?")){
            $.ajax({
                url: base_url+"Abasto/Catalogos/EliminarEvidencia",
                type: 'POST',
                dataType: 'json',
                data:{
                    evidencia_id: $(this).attr('data-evidencia_id'),
                    evidencia_nombre: $(this).attr('data-evidencia_nombre'),
                    csrf_token:csrf_token
                },beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    if(data.accion==='1'){
                        bootbox.hideAll();
                        msj_success_noti('Evidencia eliminada');
                        ActionWindowsReload();
                    }
                },error: function (e) {
                    msj_error_serve();
                    console.log(e);
                }
            });
        } 
    });
    
    
    $('body').on('click', '.eliminar-vale-servicio', function() {
        if (confirm("¿DESEA ELIMINAR ESTA EVIDENCIA PERMANENTEMENTE?")){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/EliminarEvidencia",
                type: 'POST',
                dataType: 'json',
                data:{
                    evidencia_id: $(this).attr('data-evidencia_id'),
                    evidencia_nombre: $(this).attr('data-evidencia_nombre'),
                    csrf_token:csrf_token
                },beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    if(data.accion==='1'){
                        bootbox.hideAll();
                        msj_success_noti('Evidencia eliminada');
                        ActionWindowsReload();
                    }
                },error: function (e) {
                    msj_error_serve();
                    console.log(e);
                }
            });
        } 
    });
    
    $('body').on('click', '.eliminar-charola', function() {
        var dependencia = $(this).attr('data-id_dependencia');
        var charola_id=$(this).attr('data-charola_id');
        if (confirm("¿DESEA ELIMINAR LA CHAROLA "+$(this).attr('data-charola').toUpperCase()+" ?")){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/EliminarCharola",
                type: 'POST',
                dataType: 'json',
                data:{
                    dependencia: dependencia,
                    charola_id: charola_id,
                    csrf_token:csrf_token
                },beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    if(data.accion==='1'){
                        bootbox.hideAll();
                        msj_error_noti('Charola eliminada');
                        ActionWindowsReload();
                    }
                },error: function (e) {
                    msj_error_serve();
                    console.log(e);
                }
            });
        } 
    });
    
    $('body').on('click','.eliminar-instrumentaOEquip',function () {
        var id=$(this).attr('data-id');
        var tipo=$(this).attr('data-tipo');
        var dependencia=$(this).attr('data-id_dependencia');
        if(confirm('¿DESEA ELIMINAR EL '+$(this).attr('data-tipo').toUpperCase()+' '+$(this).attr('data-nombre').toUpperCase()+'?')){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/AjaxInstrumentalOequipamiento",
                type: 'POST',
                dataType: 'json',
                data:{
                    csrf_token:csrf_token,
                    id:id,
                    tipo:tipo,
                    dependencia:dependencia
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data) {
                    if(data.accion==='1'){
                        msj_error_noti('REGISTRO ELIMINADO');
                        ActionWindowsReload();
                    }
                },error: function (e) {
                    console.log(e);
                    msj_error_serve();
                    bootbox.hideAll();
                }
            });
        }
    });
    
    $('body').on('click', '.eliminar-imagen-instrumental', function() {
        if (confirm("¿DESEA CAMBIAR ESTA IMAGEN?")){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/EliminarImagen",
                type: 'POST',
                dataType: 'json',
                data:{
                    imagen_Inst_Equip: $(this).attr('data-imagenNombre'),
                    csrf_token:csrf_token
                },beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    if(data.accion==='1'){
                        $("#imagen_inst_equip").addClass("hidden");
                        $("#imagenNew_inst_equip").removeClass("hidden");
                        bootbox.hideAll();
                        msj_success_noti('Imagen descartada');
                    }
                },error: function (e) {
                    msj_error_serve();
                    console.log(e);
                }
            });
        } 
    });
    
    $('.guardar-instrumental').submit(function (e) {
        e.preventDefault();
        var formData=new FormData($(this)[0]);
        $.ajax({
            url: base_url+"Abasto/MinimaInvacion/GuardarNuevoInstrumental",
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            mimeType: 'multipart/form-data',
            beforeSend: function () {
                msj_loading();
            },success: function (data) {
                if(data.accion==='1'){
                    msj_success_noti('Registro Guardado');
                    opener.location.reload();
                    window.close();
                }
            },error: function (e) {
                msj_error_serve();
                console.log(e);
            }
        });
    });
    $('.guardar-equipamiento').submit(function (e) {
        e.preventDefault();
        var formData=new FormData($(this)[0]);
        $.ajax({
            url: base_url+"Abasto/MinimaInvacion/GuardarNuevoEquipamiento",
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            mimeType: 'multipart/form-data',
            beforeSend: function () {
                msj_loading();
            },success: function (data) {
                if(data.accion==='1'){
                    msj_success_noti('Registro Guardado');
                    opener.location.reload();
                    window.close();
                }
            },error: function (e) {
                msj_error_serve();
                console.log(e);
            }
        });
    });
    
    $('.guardar-contrato').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Abasto/MinimaInvacion/GuardarNuevoContrato",
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function () {
                msj_loading();
            },success: function (data) {
                if(data.accion==='1'){
                    msj_success_noti('Registro Guardado');
                    opener.location.reload();
                    window.close();
                }
            },error: function (e) {
                msj_error_serve();
                console.log(e);
            }
        });
    });
    
    $('.guardar-charola').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Abasto/MinimaInvacion/GuardarCharola",
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function () {
                msj_loading();
            },success: function (data) {
                if(data.accion==='1'){
                    msj_success_noti('Registro Guardado');
                    opener.location.reload();
                    window.close();
                }
            },error: function (e) {
                msj_error_serve();
                console.log(e);
            }
        });
    });
    
    $('.guardar-categoria').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Abasto/MinimaInvacion/GuardarCategoria",
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function () {
                msj_loading();
            },success: function (data) {
                if(data.accion==='1'){
                    msj_success_noti('Registro Guardado');
                    opener.location.reload();
                    window.close();
                }
            },error: function (e) {
                msj_error_serve();
                console.log(e);
            }
        });
    });
    
    $('body').on('click','.Agregar-Cantidad',function (e) {
        e.preventDefault();
        var instrumental_id = $("body input[name=instrumental_id]").val();
        var equipamiento_id = $("body input[name=equipamiento_id]").val();
        var rango_id = $("body input[name=rango_id]").val();
        var charola_id = $("body input[name=charola_id]").val();
        var sistema_id = $("body input[name=sistema_id]").val();
        
        bootbox.confirm({
            title:'<h5>AGREGAR CANTIDAD</h5>',
            message:'<div class="row">'+
                        '<div class="col-md-12">'+
                            '<div class="form-group">'+
                                '<input type="number" name="cantidad_agregar" class="form-control" placeholder="Cantidad en Existencia">'+
                            '</div>'+
                        '</div>'+
                    '</div>',
            size:'small',
            buttons:{
                cancel:{
                    label:'Cancelar'
                },confirm:{
                    label:'Agregar'
                }
            },callback:function (response) {
                if(response===true){
                    $.ajax({
                        url: base_url+"Abasto/MinimaInvacion/CantidadAgregar",
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            charola_id:charola_id,
                            sistema_id:sistema_id,
                            rango_id:rango_id,
                            equipamiento_id:equipamiento_id,
                            instrumental_id: instrumental_id,
                            cantidad_agregar:$("input[name=cantidad_agregar]").val() ,
                            csrf_token:csrf_token
                        }, beforeSend: function () {
                            msj_loading();
                        }, success: function (data) {
                            if(data.accion === '1') {
                                ActionWindowsReload();
                            }
                        }, error: function (e) {
                            console.log(e);
                            msj_error_serve();
                            bootbox.hideAll();
                        }
                    });
                }
            }
        });
    });
        
     //La Chika D La MooTo +52 1 919 154 43 97  os_observacion_ci
    
    $('.eliminar-categoria').on('click', function (e) {
        e.preventDefault();
        if(confirm("¿DESEA BORRAR LA CATEGORIA "+$(this).attr("data-nombre_categoria").toUpperCase()+" ?")){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/EliminarCategoria",
                type: 'POST',
                dataType: 'json',
                data: {
                    id_categoria:$(this).attr("data-id_categoria"),
                    csrf_token:csrf_token
                },
                beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    if(data.accion==='1'){
                        msj_success_noti('Registro Guardado');
                        ActionWindowsReload();
                    }
                },error: function (e) {
                    msj_error_serve();
                    console.log(e);
                }
            });
        }
    });
    $('.eliminar-Proced_Contr').on('click', function (e) {
        var tipo = $(this).attr("data-tipo");
        var id = $(this).attr("data-id");
        e.preventDefault();
        if(confirm("¿DESEA BORRAR EL "+$(this).attr("data-tipo").toUpperCase()+" "+$(this).attr("data-nombre").toUpperCase()+" ?")){
            $.ajax({
                url: base_url+"Abasto/MinimaInvacion/EliminarProced_Contr",
                type: 'POST',
                dataType: 'json',
                data: {
                    id:id,
                    tipo:tipo,
                    csrf_token:csrf_token
                },
                beforeSend: function () {
                    msj_loading();
                },success: function (data) {
                    if(data.accion==='1'){
                        msj_success_noti('Registro Guardado');
                        ActionWindowsReload();
                    }
                },error: function (e) {
                    msj_error_serve();
                    console.log(e);
                }
            });
        }
    });
    
    
    function FiltrarConsumos(){
        var vale_servicio_id = $('#vale_servicio_id').val();
        $.ajax({
            url: base_url+"Abasto/MinimaInvacion/AjaxFiltrarConsumos",
            type: 'POST',
            dataType: 'json',
            data:{
                vale_servicio_id:vale_servicio_id,
                csrf_token:csrf_token
            },beforeSend: function () {
            },success: function (data) {
                console.log(data.insumos);
                if(data.insumos === ''){
                    $('#tablainsumos').addClass('hidden');
                }else {
                    $('#tablainsumos').removeClass('hidden');
                    $('.table-insumos tbody').html(data.insumos);
                    InicializeFootable('.table-insumos');
                }
                
                if(data.instrumental === ''){
                    $('#tablainstrumental').addClass('hidden');
                }else {
                    $('#tablainstrumental').removeClass('hidden');
                    $('.table-instrumental tbody').html(data.instrumental);
                    InicializeFootable('.table-instrumental');
                }
                
                if(data.equipamiento === ''){
                    $('#tablaequipamiento').addClass('hidden');
                }else {
                    $('#tablaequipamiento').removeClass('hidden');
                    $('.table-equipamiento tbody').html(data.equipamiento);
                    InicializeFootable('.table-equipamiento');
                }
                
            },error: function (e) {
                console.log(e);
                bootbox.hideAll();
                MsjError();
            }
        });
    }
    
});


