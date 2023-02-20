$(document).ready(function () {
    $('input[name=triage_id]').focus();
    $('input[name=triage_id]').keyup(function (e) {
        var triage_id = $(this).val();
        var input = $(this);
        if (triage_id.length == 11 && triage_id != '') {
            $.ajax({
                url: base_url + "Consultorios/AjaxObtenerPaciente",
                type: 'POST',
                dataType: 'json',
                data: {
                    triage_id: triage_id,
                    csrf_token: csrf_token
                }, beforeSend: function (xhr) {
                    msj_loading();
                }, success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    console.log(data)
                    if (data.accion == 'NO_AM') {
                        MsjNotificacion('<h5>ERROR, DATOS INCOMPLETOS </h5>', '<center><i class="fa fa-exclamation-triangle fa-5x" style="color:#E62117"></i><br>DATOS DEL PACIENTE NO CAPTURADOS POR ASISTENTE MÉDICA</center>')
                    } if (data.accion == 'NO_EXISTE_EN_CE') {
                        AjaxAgregarConsultorio(data.paciente)
                    } if (data.accion == 'NO_ASIGNADO') {
                        AjaxIngresoConsultorio(data.paciente)
                    } if (data.accion == 'ASIGNADO') {
                        PacienteAgregado(data.paciente, data.ce, data.medico, data.TieneInterconsulta)
                    }
                }, error: function (jqXHR, textStatus, errorThrown) {
                    bootbox.hideAll();
                    MsjError();
                }
            })
            input.val('');
        }
    });
    function PacienteAgregado(info, ce, medico, TieneInterconsulta) {
        bootbox.confirm({
            title: "<h5>PACIENTE ASIGNADO</h5>",
            message: '<div class="row" style="margin-top:-10px">' +
                '<div class="col-md-12 ">' +
                '<div style="height:10px;width:100%;margin-top:10px" class="' + ColorClasificacion(info.triage_color) + '"></div>' +
                '</div>' +
                '<div class="col-md-12">' +
                '<h3><b>FOLIO:</b> ' + info.triage_id + '</h3>' +
                '<h3 style="margin-top:-5px"><b>PACIENTE:</b> ' + info.triage_nombre + ' ' + info.triage_nombre_ap + ' ' + info.triage_nombre_am + '</h3>' +
                '<h3 style="margin-top:-5px"><b>C. ASIGNADO:</b> ' + ce.ce_asignado_consultorio + '</h3>' +
                '<h3 style="margin-top:-5px"><b>M. ASIGNADO:</b> ' + medico.empleado_nombre + ' ' + medico.empleado_apellidos + '</h3>' +
                '<h3 style="margin-top:-5px"><b>INGRESO:</b> ' + ce.ce_fe + ' ' + ce.ce_he + '</h3>' +
                (ce.ce_status == 'Salida' ? '<h3 style="margin-top:-5px"><b>SALIDA:</b> ' + ce.ce_fs + ' ' + ce.ce_hs + '</h3>' : '') +
                (TieneInterconsulta.length > 0 ? '<hr><h3 style="margin-top:-5px"><b>ESTE PACIENTE CUENTA CON INTERCONSULTA' : '') +
                '</div>' +
                '</div>'
            ,
            buttons: {
                cancel: {
                    label: 'Cancelar',
                    className: 'back-imss'
                }, confirm: {
                    label: 'Ver Expediente',
                    className: 'back-imss'
                }
            },
            callback: function (result) {
                if (result == true) {
                    window.open(base_url + 'Sections/Documentos/Expediente/' + info.triage_id + '/?tipo=Consultorios', '_blank')
                }
            }
        });
    }
    function AjaxIngresoConsultorio(info) {
        bootbox.confirm({
            title: "<h5>AGREGAR PACIENTE A CONSULTORIO</h5>",
            message: '<div class="row" style="margin-top:-10px">' +
                '<div class="col-md-12 ">' +
                '<div style="height:10px;width:100%;margin-top:10px" class="' + ColorClasificacion(info.triage_color) + '"></div>' +
                '</div>' +
                '<div class="col-md-12">' +
                '<h3><b>FOLIO:</b> ' + info.triage_id + '</h3>' +
                '<h3 style="margin-top:-5px"><b>PACIENTE:</b> ' + info.triage_nombre + ' ' + info.triage_nombre_ap + ' ' + info.triage_nombre_am + '</h3>' +
                '<h3 style="margin-top:-5px"><b>N.S.S:</b> ' + info.triage_paciente_afiliacion + '</h3>' +
                '<h3 style="margin-top:-5px"><b>DESTINO:</b> ' + info.triage_consultorio_nombre + '</h3>' +
                '</div>' +
                '</div>'
            ,
            buttons: {
                cancel: {
                    label: 'Cancelar',
                    className: 'back-imss'
                }, confirm: {
                    label: 'Agregar a Consultorio',
                    className: 'back-imss'
                }
            },
            callback: function (result) {
                if (result == true) {
                    $.ajax({
                        url: base_url + "Consultorios/AjaxIngresoConsultorioV2",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'triage_id': info.triage_id,
                            'csrf_token': csrf_token
                        }, beforeSend: function (xhr) {
                            msj_loading();
                        }, success: function (data, textStatus, jqXHR) {
                            bootbox.hideAll()
                            location.reload();
                        }, error: function (e) {
                            bootbox.hideAll();
                            MsjError();
                            ReportarError(window.location.pathname, e.responseText);
                        }
                    })
                }
            }
        });
    }
    function AjaxAgregarConsultorio(info) {
        bootbox.confirm({
            title: "<h5>N° DE PACIENTE ENCONTRADO</h5>",
            message: '<div class="row" style="margin-top:-10px">' +
                '<div class="col-md-12 ">' +
                '<div style="height:10px;width:100%;margin-top:10px" class="' + ColorClasificacion(info.triage_color) + '"></div>' +
                '</div>' +
                '<div class="col-md-12">' +
                '<h3><b>FOLIO:</b> ' + info.triage_id + '</h3>' +
                '<h3 style="margin-top:-5px"><b>PACIENTE:</b> ' + info.triage_nombre + ' ' + info.triage_nombre_ap + ' ' + info.triage_nombre_am + '</h3><br>' +
                '<h5 style="margin-top:-5px"><b>¿DESEA AGREGAR ESTE PACIENTE A ESTE CONSULTORIO?</b></h5>' +
                '</div>' +
                '</div>',
            buttons: {
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-imss-cancel'
                }, confirm: {
                    label: 'Agregar a Consultorio',
                    className: 'back-imss'
                }
            }, callback: function (result) {
                if (result == true) {
                    $.ajax({
                        url: base_url + "Consultorios/AjaxAgregarConsultorioV2",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'triage_id': info.triage_id,
                            'csrf_token': csrf_token
                        }, beforeSend: function (xhr) {
                            msj_loading();
                        }, success: function (data, textStatus, jqXHR) {
                            bootbox.hideAll();
                            location.reload();
                        }, error: function (e) {
                            bootbox.hideAll();
                            MsjError()
                            ReportarError(window.location.pathname, e.responseText);
                        }
                    })
                }
            }
        });
    }
    function ColorClasificacion(Color) {
        if (Color == 'Rojo') {
            return 'red';
        } if (Color == 'Naranja') {
            return 'orange';
        } if (Color == 'Amarillo') {
            return 'yellow-A700';
        } if (Color == 'Verde') {
            return 'green';
        } if (Color == 'Azul') {
            return 'indigo';
        }
    }

    function checkOrdenInternamiento(folio) {
        $.ajax({
            url: base_url + "Consultorios/GetInfoParaOrdenInternamiento/",
            dataType: 'json',
            type: 'POST',
            data: { folio: folio, csrf_token: csrf_token },
            success: function (data, textStatus, jqXHR) {
                if (data.accion == '3') {
                    AbrirEditarDocumento(folio);
                    //msj_success_noti('Mostrando Orden de Internamiento');
                }
                else if (data.accion == '2') {
                    // Pregunta si quiere hacer orden de internamiento
                    bootbox.confirm({
                        message: '<h4 class="text-center">¿Desea hacer una Orden de Internamiento?</h4>',
                        buttons: {
                            cancel: {
                                label: 'NO',
                                className: 'btn-imss-cancel'
                            }, confirm: {
                                label: 'SI',
                                className: 'back-imss'
                            }
                        },
                        callback: function (response) {
                            if (response) {
                                modalOrdenInternamiento(folio);
                            }
                        }
                    })

                } else if (data.accion == '1') {
                    msj_success_noti('Este paciente no tiene Diagnóstico, Genere Nota Médica e intente nuevamente');
                }
            }
        });
    }
    function AbrirEditarDocumento(folio){
        bootbox.confirm({
            message: '<h4 class="text-center">¿Desea editar Orden de Internamiento?</h4>',
            buttons: {
                cancel: {
                    label: 'Mostrar orden',
                    className: 'btn-imss-cancel'
                }, confirm: {
                    label: 'Editar',
                    className: 'back-imss'
                }
            },
            callback: function (response) {
                if (response) {
                    editarOrdenInternamiento(folio);
                }else{
                    AbrirDocumento(base_url + 'Inicio/Documentos/Ordeninternamiento/' + folio);
                }
            }
        })
    }

    function modalOrdenInternamiento(triage_id) {
        console.log(triage_id)
        $.ajax({
            url: base_url + "Consultorios/GetInfoParaOrdenInternamiento",
            dataType: 'json',
            type: 'POST',
            data: { folio: triage_id, csrf_token: csrf_token },
            success: function (data, textStatus, jqXHR) {
                console.log(data)
                if (data.accion == '2') {
                    bootbox.confirm({
                        title: "<h5>Información de Orden de Internamiento</h5>",
                        message: '<div class="row" style="margin-top:-10px">' +
                            '<div class="col-md-12" >' +
                            '<div style="height:10px;width:100%;margin-top:10px" class="' + ObtenerColorClasificacion(data.info.triage_color) + '"></div>' +
                            '</div>' +
                            '<div class="col-md-12">' +
                            '<h5 style="line-height: 1.4;margin-top:5px"><b>Paciente: </b>'+ data.info.triage_nombre_ap + ' ' + data.info.triage_nombre_am + ' ' + data.info.triage_nombre + '</h5>' +
                            '<h5 style="line-height: 1.4;margin-top: 10px"><b>Dx CIE10: </b>' + data.dx + '</b></h5>' +
                            '<h5 style="line-height: 1.4;margin-top:10px">' + (data.dx_complemento ? "<b>Complemento de Dx: </b>" + data.dx_complemento : " ") + '</h5>' +
                            '<h5 style="line-height: 1.4;margin-top:10px"><b>Servicio de Ingreso: </b><select id="select_especilaidad" style="width:50%">' + data.option + '</select></h5>' +
                            '<textarea name="motivo_internamiento" id="motivo" rows="2" style="width: 100%" placeholder="Motivo de Internamiento" required></textarea>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<h6 style="line-height: 1.4"><b><i class="fa fa-clock-o"></i>&nbsp; HORA CERO: </b><br> ' + data.info.triage_horacero_f + ' ' + data.info.triage_horacero_h + '</h6>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<h6 style="line-height: 1.4"><b><i class="fa fa-heartbeat"></i>&nbsp; HORA ENFERMERÍA: </b><br> ' + data.info.triage_fecha + ' ' + data.info.triage_hora + '</h6>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<h6 style="line-height: 1.4"><b><i class="fa fa-user-md"></i>&nbsp; HORA CLASIFICACIÓN: </b><br> ' + data.info.triage_fecha_clasifica + ' ' + data.info.triage_hora_clasifica + '</h6>' +
                            '</div>' +
                            '</div>',
                        buttons: {
                            cancel: {
                                label: 'Cancelar',
                                className: 'back-imss'
                            }, confirm: {
                                label: 'Confirmar',
                                className: 'back-imss'
                            }
                        },
                        callback: function (result) {
                            if (result) {
                                let servicio = $('body #select_especilaidad').val();
                                let motivo = $('body #motivo').val();
                                if (servicio == 0) {
                                    bootbox.alert({
                                        title: "<center>¡ Advertencia !</center>",
                                        message: "<center><h4>Debe seleccionar un servicio de ingreso</h4></center>",
                                        size: "medium"
                                    });
                                    return false;
                                } else if (motivo == '') {
                                    bootbox.alert({
                                        title: "<center>¡ Advertencia !</center>",
                                        message: "<center><h4>Debe comentar el Motivo de Internamiento</h4></center>",
                                    });
                                    return false;
                                } else {
                                    $.ajax({
                                        url: base_url + "Admisionhospitalaria/OrdenInternamiento",
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            triage_id: data.info.triage_id,
                                            servicio_solicitado_id: servicio,
                                            motivo: motivo,
                                            dx_registrado: data.id_dx,
                                            csrf_token: csrf_token
                                        },
                                        beforeSend: function (xhr) {
                                            msj_loading();
                                        },
                                        success: function (data, textStatus, jqXHR) {
                                            bootbox.hideAll()
                                            console.log(data.accion);
                                            console.log(triage_id);
                                            if (data.accion == 1) {
                                                msj_success_noti('Solicitud realizada');
                                                AbrirDocumento(base_url + 'Inicio/Documentos/Ordeninternamiento/' + triage_id);

                                                location.reload();
                                            }
                                        },
                                        error: function (e) {
                                            bootbox.hideAll();
                                            MsjError();
                                        }
                                    });
                                }
                            }

                        }
                    });
                }
            },
            error: function (e) {
                bootbox.hideAll();
                console.log(e)
                MsjError();
            }
        });
    }

    function editarOrdenInternamiento(triage_id) {
        console.log(triage_id)
        $.ajax({
            url: base_url + "Consultorios/UpdateInfoParaOrdenInternamiento",
            dataType: 'json',
            type: 'POST',
            data: { folio: triage_id, csrf_token: csrf_token },
            success: function (data, textStatus, jqXHR) {
                console.log(data)
                if (data.accion == '2') {
                    bootbox.confirm({
                        title: "<h5>Información de Orden de Internamiento</h5>",
                        message: '<div class="row" style="margin-top:-10px">' +
                            '<div class="col-md-12" >' +
                            '<div style="height:10px;width:100%;margin-top:10px" class="' + ObtenerColorClasificacion(data.info.triage_color) + '"></div>' +
                            '</div>' +
                            '<div class="col-md-12">' +
                            '<h5 style="line-height: 1.4;margin-top:5px"><b>Paciente: </b>'  + data.info.triage_nombre_ap + ' ' + data.info.triage_nombre_am + ' ' + data.info.triage_nombre + '</h5>' +
                            '<h5 style="line-height: 1.4;margin-top: 10px"><b>Dx CIE10: </b>' + data.dx + '</b></h5>' +
                            '<h5 style="line-height: 1.4;margin-top:5px"><b>Última vez editado por: </b>' + data.infDoctor.empleado_apellidos + ' ' + data.infDoctor.empleado_nombre + '</h5>' +
                            '<h5 style="line-height: 1.4;margin-top:10px">' + (data.dx_complemento ? "<b>Complemento de Dx: </b>" + data.dx_complemento : " ") + '</h5>' +
                            '<h5 style="line-height: 1.4;margin-top:10px"><b>Servicio de Ingreso: </b><select id="select_especilaidad" style="width:50%">' + data.option + '</select></h5>' +
                            '<textarea name="motivo_internamiento" id="motivo" rows="2" style="width: 100%" placeholder="Motivo de Internamiento" required>' + data.checkOrden.motivo_internamiento + '</textarea>' +
                            '</div>' +

                            '<div class="col-md-4">' +
                            '<h6 style="line-height: 1.4"><b><i class="fa fa-clock-o"></i>&nbsp; HORA CERO: </b><br> ' + data.info.triage_horacero_f + ' ' + data.info.triage_horacero_h + '</h6>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<h6 style="line-height: 1.4"><b><i class="fa fa-heartbeat"></i>&nbsp; HORA ENFERMERÍA: </b><br> ' + data.info.triage_fecha + ' ' + data.info.triage_hora + '</h6>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<h6 style="line-height: 1.4"><b><i class="fa fa-user-md"></i>&nbsp; HORA CLASIFICACIÓN: </b><br> ' + data.info.triage_fecha_clasifica + ' ' + data.info.triage_hora_clasifica + '</h6>' +
                            '</div>' +
                            '</div>',
                        buttons: {
                            cancel: {
                                label: 'Cancelar',
                                className: 'back-imss'
                            }, confirm: {
                                label: 'Confirmar',
                                className: 'back-imss'
                            }
                        },
                        callback: function (result) {
                            if (result) {
                                let servicio = $('body #select_especilaidad').val();
                                let motivo = $('body #motivo').val();
                                if (servicio == 0) {
                                    bootbox.alert({
                                        title: "<center>¡ Advertencia !</center>",
                                        message: "<center><h4>Debe seleccionar un servicio de ingreso</h4></center>",
                                        size: "medium"
                                    });
                                    return false;
                                } else if (motivo == '') {
                                    bootbox.alert({
                                        title: "<center>¡ Advertencia !</center>",
                                        message: "<center><h4>Debe comentar el Motivo de Internamiento</h4></center>",
                                    });
                                    return false;
                                } else {
                                    $.ajax({
                                        url: base_url + "Admisionhospitalaria/updateOrdenInternamiento",
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            triage_id: data.info.triage_id,
                                            servicio_solicitado_id: servicio,
                                            motivo: motivo,
                                            dx_registrado: data.id_dx,
                                            csrf_token: csrf_token
                                        },
                                        beforeSend: function (xhr) {
                                            msj_loading();
                                        },
                                        success: function (data, textStatus, jqXHR) {
                                            bootbox.hideAll()
                                            console.log(data.accion);
                                            console.log(triage_id);
                                            if (data.accion == 1) {
                                                msj_success_noti('Solicitud realizada');
                                                AbrirDocumento(base_url + 'Inicio/Documentos/Ordeninternamiento/' + triage_id);

                                                location.reload();
                                            }
                                        },
                                        error: function (e) {
                                            bootbox.hideAll();
                                            MsjError();
                                        }
                                    });
                                }
                            }

                        }
                    });
                }
            },
            error: function (e) {
                bootbox.hideAll();
                console.log(e)
                MsjError();
            }
        });
    }



    $('body').on('click', '.interconsulta-paciente', function (e) {
        var id = $(this).attr('data-id');
        var ce_id = $(this).attr('data-ce');
        if (confirm('¿Desea solicitar una Interconsulta?')) {
            $.ajax({
                url: base_url + "Consultorios/ObtenerEspecialidades",
                dataType: 'json',
                beforeSend: function (xhr) {
                    msj_loading();
                }, success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    bootbox.confirm({
                        title: '<h5>SELECCIONAR DESTINO</h5>',
                        message: '<div class="row ">' +
                            '<div class="col-sm-12">' +
                            '<div class="form-group">' +
                            '<select id="select_destino" class="form-control" style="width:100%">' + data.option + '</select>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<textarea class="form-control" name="doc_diagnostico" rows="4" maxlength="300" placeholder="Diagnostico"></textarea>' +
                            '</div>' +
                            '</div>' +
                            '</div>',
                        buttons: {
                            cancel: {
                                label: 'Cancelar',
                                className: 'btn-imss-cancel'
                            }, confirm: {
                                label: "Aceptar",
                                className: 'back-imss'
                            }
                        }, callback: function (response) {
                            if (response == true) {
                                var doc_servicio_solicitado = $('body #select_destino').val();
                                var doc_diagnostico = $('body textarea[name=doc_diagnostico]').val();

                                if (doc_diagnostico != '') {
                                    SendAjax({
                                        csrf_token: csrf_token,
                                        ce_id: ce_id,
                                        doc_servicio_solicitado: doc_servicio_solicitado,
                                        doc_diagnostico: doc_diagnostico,
                                        triage_id: id
                                    }, 'Consultorios/AjaxInterConsulta', function (response) {
                                        if (response.accion == '1') {
                                            //AbrirDocumentoMultiple(base_url+'Inicio/Documentos/DOC430200/'+data.Interconsulta); 
                                            ActionWindowsReload();
                                        } if (response.accion == '2') {
                                            MsjNotificacion('<h5>ERROR</h5>', '<center><i class="fa fa-exclamation-triangle fa-5x" style="color:#E62117"></i><br>LA INTERCONSULTA SOLICITADO A ESTE CONSULTORIO YA FUE REALIZADO </center>')
                                        }
                                    }, '')
                                } else {
                                    msj_error_noti('DIAGNOSTICO REQUERIDO');
                                }
                            }
                        }
                        , onEscape: function () { }
                    });
                    $("#select_destino option[value='" + $('input[name=especialidad_nombre]').val() + "']").remove();
                }, error: function (e) {
                    bootbox.hideAll();
                    MsjError();
                    ReportarError(window.location.pathname, e.responseText);
                }
            });
        }
    });

    $('body').on('click', '.salida-paciente-ce', function (e) {
        e.preventDefault();
        var el = $(this);
        if (confirm('¿REPORTAR SALIDA DEL PACIENTE?')) {
            $.ajax({
                url: base_url + "Consultorios/AjaxReportarSalida",
                type: 'POST',
                dataType: 'json',
                data: {
                    'csrf_token': csrf_token,
                    'triage_id': el.attr('data-id')
                }, beforeSend: function (xhr) {
                    msj_loading();
                }, success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if (data.accion == '1') {
                        location.reload();
                    }
                }, error: function (e) {
                    bootbox.hideAll();
                    MsjError();
                    ReportarError(window.location.pathname, e.responseText);

                }
            })
        }
    });

    $('body').on('click', '.orden-internamiento', function (e) {
        var triage_id = $(this).attr('data-folio');
        e.preventDefault();
        // Checar si existe orden de internamiento
        checkOrdenInternamiento(triage_id);

    });

    $('body').on('click', '.salida-paciente-observacion', function (e) {
        e.preventDefault();
        var el = $(this);
        if (confirm('¿REPORTAR SALIDA DEL PACIENTE DE CONSULTORIOS A OBSERVACIÓN?')) {
            $.ajax({
                url: base_url + "Consultorios/AjaxSalidaObservacion",
                type: 'POST',
                dataType: 'json',
                data: {
                    'csrf_token': csrf_token,
                    'triage_id': el.attr('data-id')
                }, beforeSend: function (xhr) {
                    msj_loading();
                }, success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if (data.accion == '1') {
                        ActionWindowsReload();
                    }
                }, error: function (e) {
                    msj_error_serve();
                    ReportarError(window.location.pathname, e.responseText);
                    bootbox.hideAll();
                }
            });
        }
    });
    $('body').on('click', '.abandono-consultorio', function (e) {
        if (confirm('¿DAR DE ALTA PACIENTE, POR NO PRESENTARSE A CONSULTORIO?')) {
            $.ajax({
                url: base_url + "Consultorios/AjaxAltaPorAusencia",
                type: 'POST',
                data: {
                    triage_id: $(this).attr('data-id'),
                    csrf_token: csrf_token
                }, beforeSend: function (xhr) {
                    msj_loading()
                }, success: function (data, textStatus, jqXHR) {
                    if (data.accion == '1') {
                        msj_success_noti('ALTA DE CONSULTORIO POR AUSENCIA');
                        ActionWindowsReload();
                    }
                }, error: function (e) {
                    msj_error_serve(e)
                    ReportarError(window.location.pathname, e.responseText);
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
            url: base_url + "Consultorios/AjaxIndicadores",
            type: 'POST',
            dataType: 'json',
            data: {
                selectTurno: $('select[name=Turno]').val(),
                inputFechaInicio: $('input[name=inputFechaInicio]').val(),
                csrf_token: csrf_token
            }, beforeSend: function (xhr) {
                msj_loading();
            }, success: function (data, textStatus, jqXHR) {
                console.log(data)
                bootbox.hideAll();
                $('.TOTAL_PACIENTES_CONSULTORIOS_DOC').find('span').html(data.TOTAL_DOCS + ' PACIENTES');
                $('.GENERAR_LECHAGA_CONSULTORIOS')
                    .attr({ 'data-inputfecha': $('input[name=inputFechaInicio]').val(), 'data-turno': $('select[name=Turno]').val() }).removeClass('hide');

            }, error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e)
            }
        })
    })
    $('.GENERAR_LECHAGA_CONSULTORIOS').click(function (e) {
        AbrirDocumento(base_url + 'Inicio/Documentos/LechugaConsultorios?inputFechaInicio=' + $(this).attr('data-inputfecha') + '&turno=' + $(this).attr('data-turno'), '_blank');
    });
    /*Destinos*/
    $('.btn-add-dest').click(function (e) {
        e.preventDefault();
        AjaxDestino({
            destino_id: 0,
            destino_nombre: '',
            destino_accion: 'add'
        })
    })
    function AjaxDestino(info) {
        bootbox.confirm({
            title: '<h5>NUEVO DESTINO</h5>',
            message: '<div class="row">' +
                '<div class="col-md-12">' +
                '<div class="form-group">' +
                '<input type="text" name="destino_nombre" value="' + info.destino_nombre + '" class="form-control" placeholder="Nombre del destino">' +
                '</div>' +
                '</div>' +
                '</div>'
            , size: 'small',
            buttons: {
                confirm: {
                    label: 'Aceptar',
                    className: 'back-imss'
                }, cancel: {
                    label: 'Cancelar',
                    className: 'back-imss'
                }
            }, callback: function (response) {
                if (response == true) {
                    var destino_nombre = $('body input[name=destino_nombre]').val();
                    if (destino_nombre != '') {
                        $.ajax({
                            url: base_url + "Consultorios/AjaxDestinos",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                destino_id: info.destino_id,
                                destino_nombre: destino_nombre,
                                destino_accion: info.destino_accion,
                                csrf_token: csrf_token
                            }, beforeSend: function (xhr) {
                                msj_loading();
                            }, success: function (data, textStatus, jqXHR) {
                                if (data.accion == '1') {
                                    msj_success_noti('Dato Guardados');
                                    ActionWindowsReload();
                                }
                            }, error: function (e) {
                                bootbox.hideAll();
                                MsjError();
                                console.log(e);
                            }
                        })
                    } else {
                        msj_error_noti('Campor Requerido');
                    }
                }
            }

        })
    }
    $('body').on('click', '.destino-eliminar', function () {
        var destino_id = $(this).attr('data-id');
        if (confirm('¿ELIMINAR REGISTRO?')) {
            $.ajax({
                url: base_url + "Consultorios/AjaxDestinosEliminar",
                type: 'POST',
                dataType: 'json',
                data: {
                    destino_id: destino_id,
                    csrf_token: csrf_token
                }, beforeSend: function (xhr) {
                    msj_loading();
                }, success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if (data.accion == '1') {
                        msj_success_noti('Registro eliminado');
                    }
                }, error: function (e) {
                    bootbox.hideAll();
                    MsjError();
                    console.log(e)
                }
            });
        }
    });

    $("#Turno").change(function (event) {
        if ($(this)[0].selectedIndex == 0) {
            $(this).prop('required', true);

        }
        else {
            $(this).prop('required', false);

        }
    });


})