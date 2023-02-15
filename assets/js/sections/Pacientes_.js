$(document).ready(function (){
    $('select[name=inputSelect]').change(function () {
        if($(this).val()=='POR_NUMERO'){
            $('input[name=inputSearch]').attr('placeholder','Ingresar Folio de paciente');
        }if($(this).val()=='POR_NOMBRE'){
            $('input[name=inputSearch]').attr('placeholder','Apellidos y nombre');
        }if($(this).val()=='POR_NSS'){
            $('input[name=inputSearch]').attr('placeholder','Ingresar NSS (Sin Agregado)');
        }
    });
    
    $('input[name=inputSearch]').keyup(function (e) {
        if($('select[name=inputSelect]').val()=='POR_NUMERO' && $(this).val().length==11){
            AjaxPaciente();
            $(this).val('');
        }
    })
    $('.formSearch').submit(function (e) {
        e.preventDefault();
        if($('input[name=inputSearch]').val()!=''){
            AjaxPaciente();
        }else{
            msj_error_noti('ESPECIFICAR UN VALOR')
        }
    });
    function AjaxPaciente() {
        $.ajax({
            url: base_url+"Sections/Pacientes/AjaxPaciente",
            type: 'POST',
            dataType: 'json',
            data:$('.formSearch').serialize(),
            beforeSend: function (xhr) {
                msj_loading('Espere por favor esto puede tardar un momento');
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if($('select[name=inputSelect]').val()=='POR_NOMBRE'){
                    $('.inputSelectNombre').removeClass('hide');
                }else{
                    $('.inputSelectNombre').addClass('hide');
                }
                $('#tableResultSearch tbody').html(data.tr)
                InicializeFootable('#tableResultSearch');
                $('body .tip').tooltip();

            },error: function (e) {
                bootbox.hideAll()
                MsjError();
            }
        })
    }
    $('body').on('click','.iconoPrintTicket',function (e) {
        e.preventDefault();
        AbrirDocumentoMultiple(base_url+'HoraCero/GenerarTicket/'+$(this).attr('data-id'),'Imprimir Ticket')
    })
    $('body').on('click','.link-cambiar-destino',function (e) {
        var destino_nombre=$(this).data('destino-nombre');
        var triage_id=$(this).data('triage');
        e.preventDefault();
        bootbox.dialog({
            title: '<h5>CAMBIAR DESTINO</h5>',
            message:'<div class="row ">'+
                        '<div class="col-sm-12">'+
                            '<select class="form-control" id="cambiar_destino">'+
                                '<option value="Choque">Choque</option>'+
                                '<option value="Observación">Observación</option>'+
                                '<option value="Filtro">Filtro</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>',
            size:'small',
            buttons: {
                Cancelar: {
                    label: "Cancelar",
                    className: "btn btn-fw green waves-effect",
                    callback:function(){}
                },Aceptar: {
                    label: "Aceptar",
                    className: "btn btn-fw btn-danger waves-effect",
                    callback:function(){
                        if(confirm('ESTA SEGURO QUE DESEA CAMBIAR EL DESTINO DE ESTE PACIENTE, AL HACER SE ELIMINARA DEL DESTINO ACTUAL Y LOS DATOS QUE POSIBLEMENTE SE HAYAN CAPTURADO EN DICHA ÁREA')){
                            bootbox.hideAll();
                            $.ajax({
                                url: base_url+"Sections/Pacientes/CambiarDestino",
                                type: 'POST',
                                dataType: 'json',
                                data:{
                                    'csrf_token':csrf_token,
                                    'triage_id':triage_id,
                                    'destino':$('#cambiar_destino').val()
                                },beforeSend: function (xhr) {
                                    msj_loading()
                                },success: function (data, textStatus, jqXHR) {
                                    bootbox.hideAll();
                                    if(data.accion=='1'){
                                        location.reload();
                                    }
                                },error: function (e) {
                                    msj_error_serve(e);
                                    bootbox.hideAll();
                                }
                            })
                        }
                    }
                }
            }
            ,onEscape : function() {}
        });
        if(destino_nombre=='Observación'){
            $('#cambiar_destino option[value="Observación"]').remove();
        }else if(destino_nombre=='Choque'){
            $('#cambiar_destino option[value="Choque"]').remove();
        }else{
            $('#cambiar_destino option[value="Filtro"]').remove();
        } 
    })
    $('input[name=triage_id]').keyup(function () {
        var input=$(this);
        var triage_id=$(this).val();
        if(triage_id.length==11 && triage_id!=''){
            $.ajax({
                url: base_url+"Sections/Pacientes/AjaxBuscar",
                type: 'POST',
                dataType: 'json',
                data:{
                    triage_id:triage_id,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if(data.accion=='1'){
                        $('.row-info-paciente').removeClass('hide');
                        $('input[name=triage_id_val]').val(data.paciente.triage_id);
                        $('input[name=triage_nombre]').val(data.paciente.triage_nombre);
                        $('input[name=triage_nombre_ap]').val(data.paciente.triage_nombre_ap);
                        $('input[name=triage_nombre_am]').val(data.paciente.triage_nombre_am);
                        $('input[name=pum_nss]').val(data.pum.pum_nss);
                        $('input[name=pum_nss_agregado]').val(data.pum.pum_nss_agregado);
                    }else{
                        msj_error_noti('EL PACIENTE NO EXISTE');
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    MsjError();
                }
            });
            input.val('');
        }
    })
    $('.form-update-info-paciente').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Sections/Pacientes/AjaxActualizarInfo",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.accion=='1'){
                    msj_success_noti('Información Actualizada');
                    $('.row-info-paciente').addClass('hide');
                    $('.row-info-paciente')[0].reset();
                }
            },error: function (e) {
                bootbox.hideAll();
                console.log(e);
                MsjError();
            }
        })
    });
    /*Eliminar Historial del Paciente*/
    $('input[name=inputSearchDelete]').keyup(function (e) {
        e.preventDefault();
        var triage_id=$(this).val();
        var input=$(this);
        if(triage_id!='' && triage_id.length==11){
            SendAjax({
                triage_id:triage_id,
                csrf_token:csrf_token
            },'Sections/Pacientes/AjaxBuscar',function (response) {
                if(response.accion=='1'){
                    bootbox.confirm({
                        title:'<h5>DETALLES DEL PACIENTE</h5>',
                        message:'<div class="row">'+
                                    '<div class="col-md-12">'+
                                        '<h4><b>N° DE FOLIO:</b> '+response.paciente.triage_id+'</h4>'+
                                        '<h4><b>PACIENTE:</b> '+response.paciente.triage_nombre+' '+response.paciente.triage_nombre_ap+' '+response.paciente.triage_nombre_am+'</h4>'+
                                    '</div>'+
                                '</div>',
                        buttons:{
                            cancel:{
                                label:'Cancelar',
                                className:'btn-imss-cancel'
                            },confirm:{
                                label:'Eliminar Historial',
                                className:'back-imss'
                            }
                        },callback:function (res) {
                            if(res==true){
                                var matricula=prompt('CONFIRMAR MATRICULA','');
                                if(matricula!=null & matricula!=''){
                                    AjaxBuscarEmpleado(function (response) {
                                        console.log(response)
                                        if(response.empleado_nivel_acceso=='1'){
                                            SendAjax({
                                                triage_id:triage_id,
                                                csrf_token:csrf_token
                                            },'Sections/Pacientes/AjaxEliminarHistorial',function (response) {
                                                if(response.accion=='1'){
                                                    msj_success_noti('REGISTRO ELIMINADO');
                                                }
                                            },'')
                                        }else{
                                            msj_error_noti('NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN');
                                        }
                                    },matricula)
                                }
                            }
                        }
                    })
                }if(response.accion=='2'){
                    msj_error_noti('EL N° DE FOLIO NO EXISTE');
                }
            })
            input.val('');
        }
    })
});