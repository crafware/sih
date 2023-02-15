
$(document).ready(function () {
    console.log($('input[name=area]').val())
    $area = $('input[name=area]').val()
    if ($area == 'UCI' || $area == 'UTR' || $area == 'UTMO') {
        AjaxCamasAreasCriticas();
        console.log($('input[name=area]').val());
    }
    function AjaxCamasAreasCriticas() {
        $.ajax({
            url: base_url + "Areascriticas/AjaxVisorCamasUCI_UTR_UTMO",
            type: 'GET',
            dataType: 'json',
            data: {
                area: $area,
                csrf_token: csrf_token
            }, beforeSend: function (xhr) {
                msj_loading();
            }, success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.visor-camas').html(data.Col);
            }, error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    }

    //Lee las camas para el ingreso de las areas criticas (UCI, UTR e UTMO).
    function LeerCamaAreasCriticas(camaId, camaEstado, camaNombre) {
        bootbox.confirm({
            title: '<h5>Introduzca el folio</h5>',
            message: '<div class="col-md-12">' +
                '<div class="input-group m-b">' +
                '<input type="text" name="folio" class="form-control" id="inputFolio" placeholder="Ingresar N° de Folio">' +
                '<span class="input-group-addon back-imss border-back-imss pointer" id="pasteFolio">' +
                '<i class="fa fa-paste"></i>' +
                '</span>' +
                ' </div>',

            size: 'small',
            buttons: {
                confirm: {
                    label: 'Aceptar',
                    className: 'back-imss'
                },

                cancel: {
                    label: 'Cancelar',
                    className: 'btn-imss-cancel'
                }
            },
            callback: function (res) {
                if (res) {
                    triage_id = $('body input[name=folio]').val();
                    if (triage_id != null && triage_id != '') {
                        bootbox.prompt({
                            title: "<center>Confirmar su Matricula</center>",
                            inputType: 'password',
                            size: 'small',
                            callback: function (result) {
                                if (result != null && result != '') {
                                    // result es la matricula
                                    AsignarCamaAreasCriticas(triage_id, camaId, result);

                                } else msj_error_noti('CONFIRMACIÓN DE MATRICULA REQUERIDA');
                            }
                        });
                    } else msj_error_noti('Debe introducir un número de Folio valido')
                } else msj_error_noti('Opción Cancelada');
            }
        });
        const pasteButton = document.getElementById("pasteFolio");
        const paste = document.getElementById("inputFolio");

        pasteButton.addEventListener('click', async function (event) {
            paste.textContent = '';
            //const data = await navigator.clipboard.read();
            const text = await navigator.clipboard.readText();
            //const clipboardContent = data[0];
            paste.value = text;
            //console.log(paste.value)
        });
        return;
    }

    function convertDateFormat(string) {
        var info = string.split('-');
        return info[2] + '/' + info[1] + '/' + info[0];
    }

    function ModalAltaPaciente(folio) {
        $.ajax({
            url: base_url + "Areascriticas/ProcesoDeAlta",
            dataType: 'json',
            type: 'POST',
            data: { folio: folio, csrf_token: csrf_token },
            success: function (data, textStatus, jqXHR) {
                if (data.accion == '1') {
                    let id_43051 = data.infop.id;
                    bootbox.confirm({
                        title: "<h5>Información de Alta de Paciente</h5>",
                        message: '<div class="row" style="margin-top:-10px">' +
                            '<div class="col-md-12" >' +
                            '<div style="height:10px;width:100%;margin-top:10px"><center><h4>Cama:' + data.infoc.cama_nombre + ' ' + data.infoc.piso_nombre_corto + '</h4></center></div>' +
                            '</div>' +
                            '<div class="col-md-12">' +
                            '<h5 style="line-height: 1.4;margin-top:20px"><b>Paciente: </b>' + data.infop.triage_nombre + ' ' + data.infop.triage_nombre_ap + ' ' + data.infop.triage_nombre_am + '</h5>' +
                            '<h5 style="line-height: 1.4;margin-top:5px"><b>NSS: </b>' + data.infop.pum_nss + ' ' + data.infop.pum_nss_agregado + '</b></h5>' +
                            '<h5 style="line-height: 1.4;margin-top:5px"><b>Servicio de Egreso: </b>' + data.infon.especialidad_nombre + '</h5>' +
                            '<h5 style="line-height: 1.4;margin-top:5px"><b>Médico: </b>' + data.infon.empleado_apellidos + ' ' + data.infon.empleado_nombre + '</h5>' +
                            '<h5 style="line-height: 1.4;margin-top:5px"><b>Motivo de Alta: </b>' + data.motivoe + '</h5>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<h6 style="line-height: 1.4"><b><i class="fa fa-calendar"></i> Fecha Ingreso: </b><br> ' + convertDateFormat(data.infop.fecha_ingreso) + ' ' + data.infop.hora_ingreso + ' hrs</h6>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<h6 style="line-height: 1.4"><b><i class="fa fa-clock-o"></i> Fecha de egreso: </b><br> ' + data.fecha_egreso + '</h6>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<h6 style="line-height: 1.4"><b><i class="fa fa-clock-o"></i> Tiempo de estancia: </b><br> ' + data.testancia + '</h6>' +
                            '</div>' +
                            '</div>',
                        buttons: {
                            cancel: {
                                label: 'Cancelar',
                                className: 'btn-imss-cancel'
                            }, confirm: {
                                label: 'Confirmar',
                                className: 'back-imss'
                            }
                        },
                        callback: function (result) {
                            if (result) {
                                $.ajax({
                                    url: base_url + "Areascriticas/ConfirmarAltaCamaAsistenteMedica",
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        cama_id: cama_id,
                                        folio: folio,
                                        id_43051: id_43051,
                                        csrf_token: csrf_token
                                    },
                                    beforeSend: function (xhr) {
                                        //msj_loading();
                                    },
                                    success: function (data, textStatus, jqXHR) {
                                        bootbox.hideAll()
                                        if (data.accion == 1) {
                                            location.reload();
                                            msj_success_noti('Solicitud realizada');
                                        }
                                    },
                                    error: function (e) {
                                        bootbox.hideAll();
                                        MsjError();
                                    }
                                });
                            }
                        }
                    });
                } else if (data.accion == '2') {
                    msj_success_noti('El paciente no tiene una Orden de Alta, favor de comentar al Médico tratante');
                }
            },
            error: function (e) {
                bootbox.hideAll();
                console.log(e)
                MsjError();
            }
        });
    }

    $('input[name=directorio_cp]').blur(function (e) {
        if ($(this).val() != '') {
            BuscarCodigoPostal({
                'cp': $(this).val(),
                'input1': 'directorio_municipio',
                'input2': 'directorio_estado',
                'input3': 'directorio_colonia'
            })
        }
    });

    /* =========================================================
        Asignacion de Cama
        ========================================================= */

    $('.form-asignacion-cama').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url + "Areascriticas/AjaxAsignarCama_v2",
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading('', 'No');
            }, success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if (data.accion == '1') {
                    AbrirDocumentoMultiple(base_url + 'Inicio/Documentos/DOC43051/' + $('input[name=triage_id]').val(), 'DOC43051');
                    ActionCloseWindowsReload();

                } if (data.accion == '2') {
                    ActionCloseWindows();
                    msj_error_noti('LA MATRICULA ESPECIFICADA NO EXISTE')
                }
            }, error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e)
            }
        })
    });

    $('body input[name=ac_ingreso_matricula]').blur(function () {
        if ($(this).val() != '') {
            AjaxBuscarEmpleado(function (response) {
                $('input[name=ac_ingreso_medico]').val(response.empleado_nombre + ' ' + response.empleado_apellidos)
            }, $(this).val())
        }

    })
    $('body input[name=ac_salida_matricula]').blur(function () {
        if ($(this).val() != '') {
            AjaxBuscarEmpleado(function (response) {
                $('input[name=ac_salida_medico]').val(response.empleado_nombre + ' ' + response.empleado_apellidos)
            }, $(this).val())
        }
    });


    function getTooltip() {
        let returnValue = '';
        $.ajax({
            url: base_url + "Areascriticas/ToooltipInfoPaciente/",
            type: 'POST',
            dataType: 'json',
            data: {
                folio: folio,
                csrf_token: csrf_token
            },
            async: false,
            success: function (data, textStatus, jqXHR) {
                returnValue = data.datatitle;
                /*$('div[data-estado=Ocupado]').attr("data-title",data.datatitle);
                $('div[data-estado=Ocupado]').tooltip();*/
                //console.log(data.datatitle);
                //console.log(data.servicio,data.medico);
            },
            error: function (e) {
            }
        });
        return returnValue;
    }


    function abrirExpediente(triage_id) {
        var area = document.getElementById("area").value;
        $.ajax({
            url: base_url + "Areascriticas/getPacienteUCI/",
            type: "POST",
            dataType: "json",
            data: {
                area:area,
                triage_id: triage_id,
                csrf_token: csrf_token
            },
            async: false,
            success: function (data) {
                console.log(data)
                console.log(data.accion)
                if (data.accion == "NOT_EXIST") {
                    msj_error_noti("El paciente no ha sido agregado, o ya ha sido egresado.");
                } else if (data.accion == "EXIST") {
                    var host = window.location.host
                    if ("11.47.37.14:8080" != host) {
                        host += '/sih'
                    }
                    var url = 'http://' + host + '/Sections/Documentos/Expediente/' + triage_id + '/?tipo=Hospitalizacion'
                    window.open(url);
                }
            },
            error: function (e) {

            }
        });
    }

    $("body").on('mouseleave', 'div[data-estado=Ocupado]', function () {
        $(this).tooltip();
        $('.tooltip').hide();
        $(this).tooltip({ disabled: true });
        //console.log('sale de div');
    });

    $('.btn-buscar-ingresos').click(function (e) {
        var input_fecha = $('input[name=input_fecha]').val();
        $.ajax({
            url: base_url + "Areascriticas/Bucaringresos/",
            type: 'POST',
            dataType: 'json',
            data: {
                input_fecha: input_fecha,
                csrf_token: csrf_token
            }, beforeSend: function (xhr) {
                msj_loading('Espere por favor...');
            }, success: function (data, textStatus, jqXHR) {
                console.log(data)
                bootbox.hideAll();
                $('.filtro-ingreso').html(data.num_rows + ' Pacientes');
                $('.filtro-egreso').html(data.num_rows + ' Pacientes');
                $('.btn-filtro-result').removeClass('hide');
                $('.pdfIngresosHosp')
                    .attr('data-fecha_inicio', input_fecha)
                    .attr('data-tipo2', 'No Aplica')
                    .attr('data-tipo', 'Consultorios').removeClass('hide');
            }, error: function (jqXHR, textStatus, errorThrown) {
                bootbox.hideAll();
                msj_error_serve();
                ReportarError(window.location.pathname, e.responseText);
            }
        })
    })
    $('.pdfIngresosHosp').click(function (e) {
        AbrirDocumento(base_url + 'inicio/documentos/IngresosAdmisionHospitalaria?fecha_inicio=' + $(this).attr('data-fecha_inicio'));
    });

    $('body').on('click', '#buscarPaciente', function (e) {
        var inputSelect = $('#inputSelect').val();
        var inputSearch = $('#inputSearch').val();
        var IngresosEgr = $('#inputSelectIngresosEgresosGet').val();
        var selectFecha = $('#selectFechaGet').val();
        var data = {
            "inputSelect": inputSelect,
            "inputSearch": inputSearch,
            "IngresosEgr": IngresosEgr,
            "selectFecha": selectFecha,
            csrf_token: csrf_token
        };
        e.preventDefault();
        if ($('input[name=inputSearch]').val() != '' || selectFecha != "") {
            $.ajax({
                url: base_url + "Areascriticas/BuscarPacienteDoc",
                type: 'POST',
                dataType: 'json',
                data: data
                , beforeSend: function (xhr) {
                    msj_loading('Espere por favor esto puede tardar un momento');
                }, success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    console.log(data)
                    if ($('select[name=inputSelect]').val() == 'POR_NOMBRE') {
                        $('.inputSelectNombre').removeClass('hide');
                    } else {
                        $('.inputSelectNombre').addClass('hide');
                    }
                    $('#tableResultSearch').css("display", "");
                    $('#tableResultSearch tbody').html(data.tr)
                    InicializeFootable('#tableResultSearch');
                    $('body .tip').tooltip();
                }, error: function (e) {
                    bootbox.hideAll()
                    MsjError();
                }
            })
        } else {
            msj_error_noti('ESPECIFICAR UN VALOR')
        }
    });
    $('body').on('click', '.agregar-paciente', function (e) {
        var area = $('input[name=area]').val()
        var inputSelect = "POR_NUMERO";
        var inputSearch = $(this).attr('data-folio');
        var data = {
            "inputSelect": inputSelect,
            "inputSearch": inputSearch,
            csrf_token: csrf_token
        };
        e.preventDefault();
        if ($('input[name=inputSearch]').val() != '') {
            $.ajax({
                url: base_url + "Areascriticas/BuscarPacienteData",
                type: 'POST',
                dataType: 'json',
                data: data
                , beforeSend: function (xhr) {
                    msj_loading('Espere por favor esto puede tardar un momento');
                }, success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    console.log(data)
                    bootbox.confirm({
                        title: "<h5>AGREGAR PACIENTE A "+area+"</h5>",
                        message: '<div class="row" style="margin-top:-10px">' +
                            '<div class="col-md-12 ">' +
                            '<div style="height:10px;width:100%;margin-top:10px" class="' + 2 + '"></div>' +
                            '</div>' +
                            '<div class="col-md-12">' +
                            '<h3><b>FOLIO:</b> ' + data.tr.triage_id + '</h3>' +
                            '<h3 style="margin-top:-5px"><b>PACIENTE:</b> ' + data.tr.nombre_paciente + '</h3>' +
                            '<h3 style="margin-top:-5px"><b>N.S.S:</b> ' + data.tr.nss + '</h3>' +
                            '</div>' +
                            '</div>',
                        buttons: {
                            cancel: {
                                label: 'Cancelar',
                                className: 'btn-imss-cancel'
                            }, confirm: {
                                label: 'Agregar a '+area,
                                className: 'back-imss'
                            }
                        },
                        callback: function (result) {
                            if (result) {
                                var input = $(this);
                                console.log(2);
                                console.log(area);
                                $.ajax({
                                    url: base_url + "Areascriticas/AjaxGetPacienteUCI",
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        triage_id: inputSearch,
                                        area:area,
                                        csrf_token: csrf_token
                                    }, beforeSend: function (xhr) {
                                        msj_loading();
                                    }, success: function (data, textStatus, jqXHR) {
                                        bootbox.hideAll();
                                        console.log(1);
                                        console.log(data);
                                        if (data.accion == 'NO_ASIGNADO') {
                                            msj_error_noti("A ocurrido un error, el paciente no ha sido asignado")
                                        } else if (data.accion == 'EXIST') {
                                            msj_error_noti("El paciente ya ha sido asignado")
                                        } else if (data.accion == 'ASIGNADO') {
                                            $('#tableResultSearch').css("display", "none");
                                            $('input[name=inputSearch]').val('');
                                            msj_success_noti('Paciente asignado');
                                        }
                                        $('#tableResultSearch tbody').html('<tr><td colspan="5" class="text-center"><h5>NO SE HA REALIZADO UNA BÚSQUEDA</h5></td></tr>');
                                        $('#ocultarBusquedaRadioButoon').click()
                                    }, error: function (jqXHR, textStatus, errorThrown) {
                                        bootbox.hideAll();
                                        MsjError();
                                    }
                                })
                                input.val('');
                            } else msj_error_noti('Opción Cancelada');
                        }
                    });
                }, error: function (e) {
                    bootbox.hideAll()
                    MsjError();
                }
            })
        } else {
            msj_error_noti('ESPECIFICAR UN VALOR')
        }
    });

    $('body').on('click', '.alta-paciente', function (e) {
        var inputSelect = "POR_NUMERO";
        var inputSearch = $(this).attr('data-triage');
        console.log(inputSearch)
        var data = {
            "inputSelect": inputSelect,
            "inputSearch": inputSearch,
            csrf_token: csrf_token
        };
        e.preventDefault();
        $.ajax({
            url: base_url + "Areascriticas/BuscarPacienteData",
            type: 'POST',
            dataType: 'json',
            data: data
            , beforeSend: function (xhr) {
                msj_loading('Espere por favor esto puede tardar un momento');
            }, success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                console.log(data)
                bootbox.confirm({
                    title: "<h5>DAR PACIENTE DE ALTA</h5>",
                    message: '<div class="row" style="margin-top:-10px">' +
                        '<div class="col-md-12 ">' +
                        '<div style="height:10px;width:100%;margin-top:10px" class="' + 2 + '"></div>' +
                        '</div>' +
                        '<div class="col-md-12">' +
                        '<h3><b>FOLIO:</b> ' + data.tr.triage_id + '</h3>' +
                        '<h3 style="margin-top:-5px"><b>PACIENTE:</b> ' + data.tr.nombre_paciente + '</h3>' +
                        '<h3 style="margin-top:-5px"><b>N.S.S:</b> ' + data.tr.nss + '</h3>' +
                        '</div>' +
                        '</div>',
                    buttons: {
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-imss-cancel'
                        }, confirm: {
                            label: 'Dar de alta',
                            className: 'back-imss'
                        }
                    },
                    callback: function (result) {
                        var input = $(this);
                        var area = document.getElementById("area").value;
                        console.log(result);
                        console.log(1);
                        if (result) {
                            $.ajax({
                                url: base_url + "Areascriticas/AjaxDarDeAltaPacienteUCI",
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    area:area,
                                    triage_id: inputSearch,
                                    csrf_token: csrf_token
                                }, beforeSend: function (xhr) {
                                    msj_loading();
                                }, success: function (data, textStatus, jqXHR) {
                                    console.log(2)
                                    bootbox.hideAll();
                                    console.log(data)
                                    if (data.accion == 'NO_ASIGNADO') {
                                        msj_error_noti("A ocurrido un error, el paciente no ha sido dado de alta")
                                    } else if (data.accion == 'ALTA_HECHA') {
                                        msj_success_noti('Paciente dado de alta');
                                    }
                                }, error: function (jqXHR, textStatus, errorThrown) {
                                    bootbox.hideAll();
                                    MsjError();
                                }
                            })
                            input.val('');
                        } else {
                            msj_error_noti('Opción Cancelada')
                        }
                    }
                });
            }, error: function (e) {
                bootbox.hideAll()
                MsjError();
            }
        })
    });

    $('body').on('click', '.mostrar-expediente', function () {
        var triage_id = $(this).attr('data-folio');
        var area = document.getElementById("area").value;
        var input = $(this);
        if (triage_id.length == 11 && triage_id != '') {
            $.ajax({
                url: base_url + "Areascriticas/AjaxGetPacienteUCI",
                type: 'GET',
                dataType: 'json',
                data: {
                    tipo: area,
                    triage_id: triage_id,
                    csrf_token: csrf_token
                }, beforeSend: function (xhr) {
                    msj_loading();
                }, success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    console.log(data)
                    if (data.accion == 'ERROR') {
                        msj_error_noti("A ocurrido un error, no se puede mostrar el expediente")
                    } else if (data.accion == 'ASIGNADO') {
                        msj_success_noti('Paciente asignado');
                    } EXIST
                }, error: function (jqXHR, textStatus, errorThrown) {
                    bootbox.hideAll();
                    MsjError();
                }
            })
            input.val('');
        }
    });

    $('body').on('click', '.copy', function () {
        let aux = document.createElement("input");
        let folio = $(this).attr('data-folio');
        aux.setAttribute('value', folio);
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);
        $('#modal-preregistro').modal('hide');
        msj_success_noti('Foloio ' + folio + ' copiado');
    });

    $('body').on('click', '#asignarCama', function () {
        pasteButton = document.getElementById("pasteFolio");
        const paste = document.getElementById("inputFolio");
        pasteButton.addEventListener('click', async function (event) {
            paste.textContent = '';
            //const data = await navigator.clipboard.read();
            const text = await navigator.clipboard.readText();
            //const clipboardContent = data[0];
            paste.value = text;
            //console.log(paste.value)
        });
        return;
    });

    $('#ocultarBusquedaRadioButoon').click(function () {
        if ($(this).data('checked') || $(this).data('checked') == undefined) {
            $('#ocultarBusqueda').css("display", 'none');
        } else {
            $('#ocultarBusqueda').css("display", '');
        }
    });
    $('#ocultarCamasRadioButoon').click(function () {
        if ($(this).data('checked') || $(this).data('checked') == undefined) {
            $('.ocultarCamas').css("display", 'none');
        } else {
            $('.ocultarCamas').css("display", '');
        }
    });
    $('#ocultartablaPaciente').click(function () {
        if ($(this).data('checked') || $(this).data('checked') == undefined) {
            $('#tablaPaciente').css("display", 'none');
        } else {
            $('#tablaPaciente').css("display", '');
        }
    });
    $('input[type="checkbox"]').click(function () {
        var $this = $(this);
        if ($this.data('checked') || $(this).data('checked') == undefined) {
            this.checked = false;
            console.log(11)
        } else {
            this.checked = true;
            console.log(22)
        }
        var $otherRadios = $('input[type="radio"]').not($this).filter('[name="' + $this.attr('name') + '"]');
        $otherRadios.prop('checked', false).data('checked', false);
        $this.data('checked', this.checked);
    });
    $('[data-toggle="tooltip"]').tooltip();

    $('body').on('click', '.abrirExpediente', function (e) {
        let triage_id = $(this).data('folio');
        console.log(triage_id)
        abrirExpediente(triage_id)
    });
});
