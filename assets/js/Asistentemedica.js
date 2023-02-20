//const { Console } = require("console");

$(document).ready(function () {
    init_InputMask();
    $('input[name=triage_id]').focus();
    $('input[name=triage_id]').keyup(function (e) {
        var triage_id = $(this).val();
        var input = $(this);
        if (triage_id.length == 11 && triage_id != '') {
            $.ajax({
                url: base_url + "Asistentesmedicas/BuscarPaciente",
                dataType: 'json',
                type: 'POST',
                data: {
                    triage_id: triage_id,
                    csrf_token: csrf_token
                }, beforeSend: function (xhr) {
                    msj_loading();
                }, success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if (data.accion == '1') {
                        if ($('input[name=AsistenteMedicaTipo]').val() == 'Asistente Médica') {
                            window.open(base_url + 'Asistentesmedicas/Paciente/' + triage_id, '_blank');
                        } else {
                            window.open(base_url + 'Ortopedia/AsistentesMedicas/Paciente/' + triage_id, '_blank');
                        }

                    } if (data.accion == '2') {
                        msj_error_noti('EL NUM DE PACIENTE NO HA SIDO CLASIFICADO POR MÉDICO TRIAGE');
                    } if (data.accion == '3') {
                        msj_error_noti('ESTE PACIENTE DEBE DE SER REGISTRADO EN EL MENU "CHOQUE"');
                    } if (data.accion == '4') {
                        msj_error_noti('EL FOLIO DEL PACIENTE NO EXISTE');
                    } if (data.accion == '5') {
                        window.open(base_url + 'Asistentesmedicas/Triagerespiratorio/Registro/' + triage_id, '_blank');
                    }
                }, error: function (e) {
                    bootbox.hideAll();
                    msj_error_serve(e);
                    ReportarError(window.location.pathname, e.responseText)
                }
            })
            input.val('');

        }
    })
    /* El elemento select muestra el valor ingresado en su atributo data-value, con esto podemos mostrar
    el valor tomado de la base de datos.*/
    $('select[name=pia_documento]').val($('select[name=pia_documento]').data('value'));
    $('select[name=empleado_servicio]').val($('select[name=empleado_servicio]').data('value'));
    $('select[name=pia_procedencia_hospital]').val($('select[name=pia_procedencia_hospital]').data('value'));
    $('select[name=triage_paciente_sexo]').val($('select[name=triage_paciente_sexo]').data('value'));
    //$('select[name=triage_paciente_estadocivil]').val($('select[name=triage_paciente_estadocivil]').data('value'));
    $('select[name=pia_lugar_accidente]').val($('select[name=pia_lugar_accidente]').data('value'));
    // $('select[name=pia_procedencia_espontanea]').val($('select[name=pia_procedencia_espontanea]').data('value'));
    $('select[name=pia_tipo_atencion]').val($('select[name=pia_tipo_atencion]').data('value'));
    $('select[name=pia_vigencia]').val($('select[name=pia_vigencia]').data('value'));
    
    $('.solicitud-paciente').submit(function (e) {
        var urlAsistenteMedica;
        //console.log($('input[name=AsistenteMedicaTipo]').val())
        if ($('input[name=AsistenteMedicaTipo]').val() == 'Asistente Médica Ortopedia') {
            urlAsistenteMedica = base_url + 'Ortopedia/Asistentesmedicas/AjaxGuardar';
        } else {
            urlAsistenteMedica = base_url + 'Asistentesmedicas/AjaxGuardar';
        }
        e.preventDefault();
        $.ajax({
            url: urlAsistenteMedica,
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            }, success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if (data.accion == '1') {
                    if ($('input[name=ConfigHojaInicialAsistentes]').val() == 'Si') {
                        // AbrirDocumentoMultiple(base_url+'inicio/documentos/HojaFrontal/'+$('input[name=triage_id]').val(),'HojaFrontal',100);
                    }
                    if ($('input[name=AsistenteMedicaTipo]').val() == 'Asistente Médica') {
                        if ($('select[name=pia_lugar_accidente]').val() == 'TRABAJO') {
                            //   AbrirDocumentoMultiple(base_url+'inicio/documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',300);
                        }
                    }
                    ActionCloseWindows()
                }
            }, error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
                ReportarError(window.location.pathname, e.responseText)
            }
        })
    });

    $('.solicitud-paciente-taod').submit(function (e) {
        e.preventDefault();
        AbrirDocumentoMultiple(base_url + 'inicio/documentos/HojaFrontalCE/' + $('input[name=triage_id]').val(), 'HojaFrontal', 100);
        if ($('select[name=triage_paciente_accidente_lugar]').val() == 'TRABAJO') {
            //AbrirDocumentoMultiple(base_url+'inicio/documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',300);
        }
        ActionCloseWindows();
    });
    
    $('select[name=pia_lugar_accidente]').change(function (e) {
        if ($('input[name=CONFIG_AM_INTERACCION_LT]').val() == 'Si') {
            if ($(this).val() == 'TRABAJO') {
                $('.lugar_trabajo').removeClass('hide');
            } else {
                $('.lugar_trabajo').addClass('hide');
            }
        }

    })
    if ($('input[name=CONFIG_AM_INTERACCION_LT]').val() == 'Si') {
        if ($('select[name=pia_lugar_accidente]').attr('data-value') == 'TRABAJO') {
            $('.lugar_trabajo').removeClass('hide');
        }
    } else {
        $('.lugar_trabajo').removeClass('hide');
    }
    if ($('select[name=pia_lugar_accidente]').attr('data-value') == 'TRABAJO' && $('input[name=asistentesmedicas_exectuar_st7]').attr('data-value') == 'Si') {
        $('.omitir_st7').addClass('hide');
        $("input[name=asistentesmedicas_exectuar_st7][value='Si']").attr('checked', true);
    }
    $('#buscarCP').click(function (e) {
        if ($('input[name=directorio_cp]').val() != '') {
            BuscarCodigoPostal({
                'cp': $('input[name=directorio_cp]').val(),
                'input1': 'directorio_municipio',
                'input2': 'directorio_estado',
                'input3': 'directorio_colonia'
            })
        }
    });
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
    $('input[name=directorio_cp_2]').blur(function (e) {
        if ($(this).val() != '') {
            BuscarCodigoPostal({
                'cp': $(this).val(),
                'input1': 'directorio_municipio_2',
                'input2': 'directorio_estado_2',
                'input3': 'directorio_colonia_2'
            })
        }
    })
    function BuscarCodigoPostal(input) {
        $.ajax({
            url: base_url + "Asistentesmedicas/BuscarCodigoPostal",
            type: 'POST',
            dataType: 'json',
            data: {
                'cp': input.cp,
                'csrf_token': csrf_token
            }, success: function (data, textStatus, jqXHR) {
                $('input[name=' + input.input1 + ']').val(data.result_cp.Municipio);
                $('input[name=' + input.input2 + ']').val(data.result_cp.Estado);
                if (data.result_cp.Colonia.length > 0) {
                    var Colonia = data.result_cp.Colonia.split(';');
                    $('input[name=' + input.input3 + ']').shieldAutoComplete({
                        dataSource: {
                            data: Colonia
                        }, minLength: 1
                    });
                    $('input[name=' + input.input3 + ']').removeClass('sui-input');
                }
            }, error: function (e) {
                console.log(e);
            }
        })
    }
    /*INDICADOR*/
    $('select[name=TIPO_BUSQUEDA]').change(function () {
        if ($(this).val() == '') {
            $('.POR_FECHA').addClass('hide');
            $('.POR_HORA').addClass('hide');
        } if ($(this).val() == 'POR_FECHA') {
            $('.POR_FECHA').removeClass('hide');
            $('.POR_HORA').addClass('hide');
        } if ($(this).val() == 'POR_HORA') {
            $('.POR_FECHA').addClass('hide');
            $('.POR_HORA').removeClass('hide');
        }
    })
    $('.clockpicker-am').clockpicker({
        placement: 'bottom',
        autoclose: true
    });
    $('.btn-buscar-st7-rc').click(function () {
        if ($('select[name=TIPO_BUSQUEDA]').val() != '') {
            var inputFechaInicio = $('input[name=inputFechaInicio]').val();
            $.ajax({
                url: base_url + "Asistentesmedicas/AjaxIndicador",
                type: 'POST',
                data: {
                    inputFechaInicio: inputFechaInicio,
                    csrf_token: csrf_token
                }, dataType: 'json',
                beforeSend: function (xhr) {
                    msj_loading();
                }, success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    $('.TOTAL_AM h3 span').html(data.TOTAL + ' Pacientes');
                    $('.TOTAL_ST7_INICIADA')
                        .attr('href', base_url + 'Asistentesmedicas/IndicadorDetalles?TIPO=ST7 INICIADA&TIPO_BUSQUEDA=SN&POR_FECHA_FECHA_I=' + inputFechaInicio + '&POR_FECHA_FECHA_F=' + inputFechaInicio + '&TIPO_INDICADOR=ST7')
                        .attr('target', '_blank')
                        .find('h2').html(data.TOTAL_ST7_INICIADA + ' Pacientes');
                    $('.TOTAL_ST7_TERMINADA')
                        .attr('href', base_url + 'Asistentesmedicas/IndicadorDetalles?TIPO=ST7 TERMINADA&TIPO_BUSQUEDA=SN&POR_FECHA_FECHA_I=' + inputFechaInicio + '&POR_FECHA_FECHA_F=' + inputFechaInicio + '&TIPO_INDICADOR=ST7')
                        .attr('target', '_blank')
                        .find('h2').html(data.TOTAL_ST7_TERMINADA + ' Pacientes');
                    $('.TOTAL_ESPONTANEA')
                        .attr('href', base_url + 'Asistentesmedicas/IndicadorDetalles?TIPO=ESPONTÁNEA&TIPO_BUSQUEDA=SN&POR_FECHA_FECHA_I=' + inputFechaInicio + '&POR_FECHA_FECHA_F=' + inputFechaInicio + '&TIPO_INDICADOR=ST7')
                        .attr('target', '_blank')
                        .find('h2').html(data.TOTAL_ESPONTANEA + ' Pacientes');
                    $('.TOTAL_NO_ESPONTANEA')
                        .attr('href', base_url + 'Asistentesmedicas/IndicadorDetalles?TIPO=NO ESPONTÁNEA&TIPO_BUSQUEDA=SN&POR_FECHA_FECHA_I=' + inputFechaInicio + '&POR_FECHA_FECHA_F=' + inputFechaInicio + '&TIPO_INDICADOR=ST7')
                        .attr('target', '_blank')
                        .find('h2').html(data.TOTAL_NOESPONTANEA + ' Pacientes');
                }, error: function (e) {
                    msj_error_serve(e);
                    ReportarError(window.location.pathname, e.responseText);
                }
            })
        }
    })
    /*Egreso Pacientes Asistente Médica*/
    $('#triage_id_egreso_am').focus();
    $('#triage_id_egreso_am').keyup(function (e) {
        var input = $(this);
        e.preventDefault();
        var triage_id = input.val();

        if (triage_id.length == 11 && triage_id != '') {
            input.val('');
            $.ajax({
                url: base_url + "asistentesmedicas/AjaxObtenerPaciente",
                type: 'POST',
                dataType: 'json',
                context: this,
                data: {
                    triage_id: triage_id,
                    csrf_token: csrf_token
                }, beforeSend: function (xhr) {
                    msj_loading();
                }, success: function (data, textStatus, jqXHR) {
                    bootbox.hideAll();
                    if (data.accion == '1' && triage_id != '') {
                        if (confirm("¿DESEA DAR DE ALTA AL PACIENTE?\n\nFOLIO: " + data.paciente.triage_id + "\nPACIENTE: " + data.paciente.triage_nombre + " " + data.paciente.triage_nombre_ap + " " + data.paciente.triage_nombre_am)) {
                            bootbox.alert({
                                'title': '<h5 class="text-left color-white" >Motivo de Egreso</h5>',
                                'message': '<div class="row">' +
                                    '<div class="col-md-12">' +
                                    '<div class="form-group">' +
                                    '<select class="form-control" id="egreso_motivo">' +
                                    '<option value="">Seleccionar Motivo de Egreso</option>' +
                                    '<option value="Abandona el Servicio">Abandona el Servicio</option>' +
                                    '<option value="Alta voluntaria">Alta voluntaria</option>' +
                                    '<option value="Defunción">Defunción</option>' +
                                    '<option value="Traslado a otra Unidad IMSS">Traslado a otra Unidad IMSS</option>' +
                                    '<option value="Alta a Domicilio">Alta a Domicilio</option>' +
                                    '<option value="Hemodiálisis">Pasa Hemodiálisis</option>' +
                                    '<option value="Hospitalización">Se Hospitaliza</option>' +
                                    '</select>' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<input class="form-control" placeholder="Egreso a Consulta Externa" id="egreso_consultaexterna">' +
                                    '</div>' +
                                    '</div>' +
                                    (data.Destino == 'Observacion' ? '<div class="col-md-6"><div class="form-group"><input id="egreso_cama" type="text" class="form-control" placeholder="No. de Cama"></div></div><div class="col-md-6"><div class="form-group"><input id="egreso_piso" class="form-control" placeholder="No. de Piso"></div></div>' : '') +
                                    '</div>',
                                'size': 'small',
                                callback: function () {
                                    var egreso_motivo = $('body #egreso_motivo').val();
                                    var egreso_cama = $('body #egreso_cama').val();
                                    var egreso_piso = $('body #egreso_piso').val();
                                    var egreso_consultaexterna = $('body #egreso_consultaexterna').val();
                                    $.ajax({
                                        url: base_url + "asistentesmedicas/EgresoPaciente",
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            'csrf_token': csrf_token,
                                            'triage_id': triage_id,
                                            'egreso_motivo': egreso_motivo,
                                            'egreso_cama': egreso_cama,
                                            'egreso_piso': egreso_piso,
                                            egreso_consultaexterna: egreso_consultaexterna
                                        }, beforeSend: function (xhr) {
                                            msj_loading();
                                        }, success: function (data, textStatus, jqXHR) {
                                            bootbox.hideAll();
                                            if (data.accion == '1') {
                                                msj_success_noti('Paciente dado de alta de Unidad Médica');
                                                location.reload();
                                            } if (data.accion == '2') {
                                                msj_error_noti('El paciente ya se encuentra dado de alta')
                                            }
                                        }, error: function (e) {
                                            msj_error_serve();
                                            bootbox.hideAll();
                                            ReportarError(window.location.pathname, e.responseText);

                                        }
                                    })
                                }
                            })
                        }
                    } if (data.accion == '2' && triage_id != '') {
                        msj_error_noti('EL N° DE PACIENTE NO EXISTE');
                    }
                    input.val('');
                }, error: function (e) {
                    msj_error_serve();
                    console.log(e);
                    ReportarError(window.location.pathname, e.responseText);
                }
            })
        }
    })

    /*Filtro Jefa AM*/
    var AjaxJefaAm = null;

    $('.btn-turnos-v2').click(function (e) {
        var inputSelectTurno = $('select[name=inputSelectTurno]').val();
        var input_fecha = $('input[name=input_fecha]').val();

        $.ajax({
            url: base_url + "Asistentesmedicas/Jefa/AjaxFiltroV2",
            type: 'POST',
            dataType: 'json',
            data: {
                inputTurno: inputSelectTurno,
                input_fecha: input_fecha,
                csrf_token: csrf_token
            }, beforeSend: function (xhr) {
                msj_loading('Espere por favor...');
            }, success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.filtro-ingreso').html(data.FILTRO_INGRESO + ' Pacientes');
                $('.filtro-egreso').html(data.FILTRO_EGRESO + ' Pacientes');
                $('.btn-filtro-result').removeClass('hide');
                $('.pdf-4-30-29')
                    .attr('data-fecha_inicio', input_fecha)
                    .attr('data-tipo2', 'No Aplica')
                    .attr('data-tipo', 'Consultorios').removeClass('hide');
                $('.observacion-ingreso').html(data.OBSERVACION_INGRESO + ' Pacientes');
                $('.observacion-egreso').html(data.OBSERVACION_EGRESO + ' Pacientes');
                $('.btn-obs-result').removeClass('hide');

                $('.pdf-4-30-21-I')
                    .attr('data-fecha_inicio', input_fecha)
                    .attr('data-tipo2', 'Ingreso')
                    .attr('data-tipo', 'ObsChoque').removeClass('hide');
                $('.pdf-4-30-21-E')
                    .attr('data-fecha_inicio', input_fecha)
                    .attr('data-tipo2', 'Egreso')
                    .attr('data-tipo', 'ObsChoque').removeClass('hide');

            }, error: function (jqXHR, textStatus, errorThrown) {
                bootbox.hideAll();
                msj_error_serve();
                ReportarError(window.location.pathname, e.responseText);
            }
        })

    })
    $('.pdf-4-30-21-I, .pdf-4-30-21-E, .pdf-4-30-29').click(function (e) {
        AbrirDocumento(base_url + 'inicio/documentos/FormatosJefaAsistentesMedicas?fecha_inicio=' + $(this).attr('data-fecha_inicio') + '&fecha_fin=' + $(this).attr('data-fecha_fin') + '&turno=' + $('select[name=inputSelectTurno]').val() + '&tipo=' + $(this).attr('data-tipo') + '&tipo2=' + $(this).attr('data-tipo2'));
    })

    $('.btn-importador').click(function (e) {
        e.preventDefault();
        bootbox.confirm({
            title: '<h5>Importador de datos</h5>',
            message: '<div class="row">' +
                '<div class="col-md-12">' +
                '<div class="form-group">' +
                '<textarea class="form-control" rows="4" name="importador_datos"></textarea>' +
                '</div>' +
                '</div>' +
                '</div>',
            buttons: {
                cancel: {
                    label: 'Cancelar'
                }, confirm: {
                    label: 'Importar'
                }
            }, callback: function (res) {
                if (res == true) {
                    var vigencia_derecho = $('body textarea[name=importador_datos]').val();

                    if (vigencia_derecho.length > 0) {
                        var someJson = JSON.parse(vigencia_derecho);
                        $('input[name=triage_nombre]').val(someJson[3][1]).css({
                            'background': '#FAFFBD'
                        });
                        $('input[name=triage_nombre_ap]').val(someJson[3][2]).css({
                            'background': '#FAFFBD'
                        });
                        $('input[name=triage_nombre_am]').val(someJson[3][3]).css({
                            'background': '#FAFFBD'
                        });
                        $('input[name=triage_fecha_nac]').val(someJson[5][1]).css({
                            'background': '#FAFFBD'
                        });
                        $('select[name=triage_paciente_sexo]').val(someJson[9][1].toUpperCase()).css({
                            'background': '#FAFFBD'
                        });
                        $('input[name=pum_nss]').val(someJson[1][1]).css({
                            'background': '#FAFFBD'
                        });
                        $('input[name=pum_nss_agregado]').val(someJson[1][1]).css({
                            'background': '#FAFFBD'
                        });
                        $('input[name=pum_umf]').val(someJson[11][0]).css({
                            'background': '#FAFFBD'
                        });
                        $('select[name=triage_paciente_estadocivil]').val(someJson[9][2]).css({
                            'background': '#FAFFBD'
                        });
                        $('input[name=triage_paciente_curp]').val(someJson[5][3]).css({
                            'background': '#FAFFBD'
                        });
                        $('input[name=triage_paciente_estadocivil]').val(someJson[9][2]).css({
                            'background': '#FAFFBD'
                        });
                        $('input[name=pum_delegacion]').val(someJson[15][0]).css({
                            'background': '#FAFFBD'
                        });
                        if (someJson[13][0] == 'VIGENTE') {
                            $('.triage-status-paciente').removeClass('hide').addClass('light-green-A400').find('b').html('VIGENTE');
                        } else {
                            $('.triage-status-paciente').removeClass('hide').addClass('red').find('b').html('BAJA');
                        }
                    } else {
                        msj_error_noti('ERROR AL IMPORTAR LOS DATOS DEL PACIENTE, CAMPO VACIO')
                    }
                }

            }
        })
    });
    /* $('.btn-importador-st7').click(function (e) {
         e.preventDefault();
         bootbox.confirm({
             title:'<h5>IMPORTACIÓN DATOS ST7</h5>',
             message:'<div class="row">'+
                         '<div class="col-md-12">'+
                             '<div class="form-group">'+
                                 '<textarea class="form-control" rows="4" name="importador_datos_st7"></textarea>'+
                             '</div>'+
                         '</div>'+
                     '</div>',
             buttons:{
                 cancel:{
                     label:'Cancelar'
                 },confirm:{
                     label:'Importar'
                 }
             },callback:function (res) {
                 if(res==true){
                     var importador_datos_st7=$('body textarea[name=importador_datos_st7]').val();
 
                     if(importador_datos_st7.length>0){
                         var someJson = JSON.parse(importador_datos_st7);
                         if(someJson.length==3){
                             $('input[name=empresa_nombre]').val(someJson[2][1]).css({
                             'background':'#FAFFBD'
                             });
                             $('input[name=empresa_rp]').val(someJson[0][1]).css({
                                 'background':'#FAFFBD'
                             });;
                             $('input[name=empresa_modalidad]').val(someJson[1][1]).css({
                                 'background':'#FAFFBD'
                             });
                             var triage_paciente_fecha_um=someJson[0][3].split(' ');
                             $('input[name=empresa_fum]').val(triage_paciente_fecha_um[0]).css({
                                 'background':'#FAFFBD'
                             });
                         }else{
                             msj_error_noti('DATOS NO VALIDOS');
                         }
 
                     }else{
                         msj_error_noti('ERROR AL IMPORTAR LOS DATOS DEL PACIENTE, CAMPO VACIO')
                     }
                 }
 
             }
         })
     })*/
    if ($('input[name=INDICADOR_AM]').val() != undefined) {
        var ChartId = $('#ChartAsistentesMedicas');
        var Rojo = ChartId.attr('data-rojo');
        var Naranja = ChartId.attr('data-naranja');
        var Amarillo = ChartId.attr('data-amarillo');
        var Verde = ChartId.attr('data-verde');
        var Azul = ChartId.attr('data-azul');
        var data = {
            labels: ["Rojo (" + Rojo + ")", "Naranja (" + Naranja + ")", "Amarillo (" + Amarillo + ")", "Verde (" + Verde + ")", "Azul (" + Azul + ")"],
            datasets: [
                {
                    label: "Rojo",
                    backgroundColor: [
                        'rgba(229,9,20,1)',
                        'rgba(255, 112, 40, 1)',
                        'rgba(253, 233, 16, 1)',
                        'rgba(76, 187, 23, 1)',
                        'rgba(0, 0, 255, 1)'
                    ],
                    borderColor: [
                        'rgba(229,9,20,1)',
                        'rgba(255, 112, 40, 1)',
                        'rgba(253, 233, 16, 1)',
                        'rgba(76, 187, 23, 1)',
                        'rgba(0, 0, 255, 1)'
                    ],
                    borderWidth: 1,
                    data: [Rojo, Naranja, Amarillo, Verde, Azul]
                }
            ]
        };
        var ctx = document.getElementById("ChartAsistentesMedicas");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        });
    }
    $('.select2').select2();
    $('#btnVerificarNSS').click(function () {

        //var pum_nss = $('input[name=pum_nss]').val();
        var pum_nss = $('input[name=pum_nss]').inputmask('unmaskedvalue');
        console.log(pum_nss);
        /*
        Se verifica que el valor ingresado cuente con el numero de digitos de un NSS
        si la accion es correcta consultara la informacion y la mostrara en
        una ventana modal.
        */
        $("#infoNSS").empty();
        if (pum_nss.length < 11 || pum_nss.length > 11) {
            alert("El NSS debe estar conformado por 11 digitos");
        } else {
            var nss = pum_nss.substring(0, 10);
            var ultimoDigito = pum_nss.charAt(10);

            $("#ModalVigencia").modal();
            $.ajax({
                url: base_url + "Asistentesmedicas/VigenciaDerechos",
                type: 'GET',
                dataType: 'text',
                data: { pum_nss: nss },
                success: function (data) {
                    $("#infoNSS").append(data);
                },
                error: function (data) {
                    alert('Error en el proceso de consulta' + data);
                }
            });
        }
    });

    $('#pia_tipo_atencion').change(function () {
        var dato = $('#pia_tipo_atencion').val();
        if (dato == 'NO DERECHOHABIENTE') {
            $("input[name = pum_nss]").val('S/NA');
            $("input[name = pum_nss_agregado]").val('S/NA');
            $("input[name = pia_vigencia]").val('S/NA');
            $("input[name = pum_delegacion]").val('S/NA');
            $("input[name = pum_umf]").val('S/NA');
        }
    });
    // Se toma el numero del paciente y se ingresa en el telefono del responssable
    $('#btnTelefonoPaciente').click(function () {
        var telefono = $("input[name = directorio_telefono]").val();
        $("input[name = pic_responsable_telefono]").val(telefono);
    });
    /* Al seleccionar un servicio se manda llamar a la funcion AjaxMedicosByServicio
    y obtener los medicos que pertenecen a este*/
    /*$('#selectServicios').change(function(){
      var servicio = $("select[name = empleado_servicio]").val();
      console.log (servicio);
      $.ajax({
        url : base_url+"Asistentesmedicas/AjaxMedicosByServicio/",
        type : 'GET',
        dataType : 'text',
        data : {servicio : servicio},
        success : function(data) {

          $("#divMedicos").html(data);
        },
        error : function(data) {
            alert('Error en el proceso de consulta: '+data);
        }
      });
    }); */



});
/*
Esta funcion toma los valores dentro de la tabla que muestra la vigencia del aseguro
del paciente, recibe un parametro que se agrega al nombre de cada variable para Especificar
el campo al que se tomara el valor.
*/
function datosTablaVigencia(val) {
    var nombre = $("input[name ^= vigenciaNombre" + val + "]").val(),
        paterno = $("input[name ^= vigenciaPaterno" + val + "]").val(),
        materno = $("input[name ^= vigenciaMaterno" + val + "]").val(),
        nacimiento = $("input[name ^= vigenciaNacimiento" + val + "]").val(),
        curp = $("input[name ^= vigenciaCurp" + val + "]").val(),
        agregado = $("input[name ^= vigenciaAgregado" + val + "]").val(),
        vigencia = $("input[name ^= vigencia" + val + "]").val(),
        delegacion = $("input[name ^= vigenciaDelegacion" + val + "]").val(),
        umf = $("input[name ^= vigenciaUmf" + val + "]").val(),
        sexo = $("input[name ^= vigenciaSexo" + val + "]").val(),
        colonia = $("input[name ^= vigenciaColonia" + val + "]").val(),
        direccion = $("input[name ^= vigenciaDireccion" + val + "]").val(),
        /*Se cuenta el numero de caracteres de la direccion para tomar los ultimos 5 digitos correspondientes
        al codigo postal del paciente*/
        longituddireccion = direccion.length,
        cpostal = direccion.substring(longituddireccion - 5, longituddireccion);
    if (sexo == "F") {
        sexo = "MUJER";
    } else if (sexo == "M") {
        sexo = "HOMBRE";
    }
    // Verifica la vigencia del usuario para indicar un estado de color verde si esta activo o rojo en caso contrario
    if (vigencia == "NO") {
        $("input[name = pia_vigencia]").css('background-color', 'rgb(252, 155, 155)');
    } else if (vigencia == "SI") {
        $("input[name = pia_vigencia]").css('background-color', 'rgb(144, 255, 149)');
    }
    //Se agrega los datos seleccionados del modal al formulario principal
    $("input[name = pum_nss_agregado]").val(agregado);
    $("input[name = pia_vigencia]").val(vigencia);
    $("input[name = pum_delegacion]").val(delegacion);
    $("input[name = pum_umf]").val(umf);
    $("input[name = triage_paciente_curp]").val(curp);
    $("input[name = triage_nombre_ap]").val(paterno);
    $("input[name = triage_nombre_am]").val(materno);
    $("input[name = triage_nombre]").val(nombre);
    $("input[name = triage_fecha_nac]").val(nacimiento);
    $("select[name = triage_paciente_sexo]").val(sexo);
    $("input[name = directorio_colonia]").val(colonia);
    $("input[name = directorio_cp]").val(cpostal);
}
function init_InputMask() {
    if (typeof ($.fn.inputmask) === 'undefined') { return; }
    $(":input").inputmask();
}

function ColorClasificacion(data) {
    switch (data['triage_color']) {
        case 'Rojo':
            return 'red';
        case 'Naranja':
            return 'orange';
        case 'Amarillo':
            return 'yellow-A700';
        case 'Verde':
            return 'green';
        case 'Azul':
            return 'indigo';
    }
}

function TiempoTranscurrido(data) {
    var Tiempo1_fecha = data['Tiempo1_fecha'].split("-")
    var Tiempo1_hora = data['Tiempo1_hora'].split(":")
    var Tiempo2_fecha = data['Tiempo2_fecha'].split("-")
    var Tiempo2_hora = data['Tiempo2_hora'].split(":")
    var UTC1 = Date.UTC(Tiempo1_fecha[0], Tiempo1_fecha[1], Tiempo1_fecha[2], Tiempo1_hora[0], Tiempo1_hora[1]);
    var UTC2 = Date.UTC(Tiempo2_fecha[0], Tiempo2_fecha[1], Tiempo2_fecha[2], Tiempo2_hora[0], Tiempo2_hora[1]);
    var UTC = UTC2 - UTC1;
    var min = parseInt(UTC / (1000 * 60))
    return parseInt(UTC / (1000 * 60));
}

function updateRegistroPacientesAtencionMedicaAdmisionContinua(data) {
    console.log("updateRegistroPacientesAtencionMedicaAdmisionContinua")
    console.log(data)
    if (data == null) { return 0 }
    noRow += 1;
    var host = window.location.host
    if ("11.47.37.14:8080" != host) {
        host += '/sih'
    }
    var tabla = ""
    var footable = ""
    var displayStyle = "display: table-row;"
    if (noRow % 2 == 0) footable = "footable-odd"; else footable = "footable-even";
    tabla = '<tr class="' + footable + '" style="' + displayStyle + '"> <td><span class="footable-toggle"></span>' + noRow + '</td><td>' + data['triage_id'] + '</td>' +
        '<td class="' + ColorClasificacion(data) + '" style="color: white">' +
        data['triage_nombre'] + data['triage_nombre_ap'] + data['triage_nombre_am'] +
        '</td>' +
        '<td>' + data['triage_hora_clasifica'] + '</td>' +
        '<td>' + data['asistentesmedicas_hora'] + '</td>' +
        '<td>' +
        TiempoTranscurrido(
            {
                'Tiempo1_fecha': data['triage_fecha_clasifica'],
                'Tiempo1_hora': data['triage_hora_clasifica'],
                'Tiempo2_fecha': data['asistentesmedicas_fecha'],
                'Tiempo2_hora': data['asistentesmedicas_hora']
            }
        ) +
        ' Minutos </td>' +
        '<td>'
    if (data['pic_mt'] != '') {
        tabla += data['pic_mt']
    } else {
        tabla += '<b style="color:#256659">Por asignar, caso COVID-19</b><br>'
    }
    tabla += '</td><td>'

    if (data['triage_via_registro'] == 'Hora Cero TR') {
        tabla += '<a href="http://' + host + '/Asistentesmedicas/Triagerespiratorio/Registro/' + data['triage_id'] + '?a=edit" target="_blank">' +
            '<i class="fa fa-pencil icono-accion tip" data-original-title="Editar datos"></i>' +
            '</a>&nbsp;'
    } else {
        tabla += '<a href="http://' + host + '/Asistentesmedicas/Paciente/' + data['triage_id'] + '" target="_blank">' +
            '<i class="fa fa-pencil icono-accion tip" data-original-title="Editar datos"></i>' +
            '</a>&nbsp;'
    }
    // <!--<a href="+ base_url()Asistentesmedicas/Hospitalizacion/Registro/+data[value]['triage_id']" target='_blank' rel="opener"> -->
    tabla += '<i id = "btn-reg-43051' + noRow + '" class="fa fa-pencil-square-o icono-accion btn-reg-43051 pointer tip" data-paciente="' + data['triage_id'] + '" data-original-title="Requisitar Información 43051"></i>'
    //<!-- </a> --> 
    if (um_config['CONFIG_AM_HOJAINICIAL'] == 'Si') {
        tabla += '<i id = class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumentoMultiple(' + window.location.host + 'inicio/documentos/HojaFrontal/' + data[value]['triage_id'] + ',\'Hoja Frontal\',200)" data-original-title="Generar Hoja Frontal"></i>'
    }
    if (data['pia_lugar_accidente'] == 'TRABAJO') {
        tabla += '&nbsp;<i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumentoMultiple(' + window.location.host + 'inicio/documentos/ST7/' + data[value]['triage_id'] + ',\'ST7\',200)" data-original-title="Generar ST7"></i>'
    }
    tabla += '</td></tr>'
    var table = document.getElementById('tabla1');
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount - 2);
    row.innerHTML = tabla;
    document.getElementById("noFolio").click();
    document.getElementById("noFolio").click();
    document.querySelector("[data-page='last']").click();
    $('#btn-reg-43051' + noRow).click(function () {
        var triage_id = $(this).attr('data-paciente');
        bootbox.confirm({
            message: '<h5 style="text-align:center;">¿Quiere Ingresar este Paciente a Hospitalización?</h5>',
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
                    window.open(base_url + 'Asistentesmedicas/Hospitalizacion/Registro/' + triage_id, '_parent', 'rel=opener');
                }
            }
        });
    });
}
var No_pacientes = 0;
function crearTablaRegistroPacientesAdmisionContinua(data) {
    um_config = data["um_config"]
    var host = window.location.host
    if ("11.47.37.14:8080" != host) {
        host += '/sih'
    }
    var tabla = ""
    var cont = 0
    var footable = ""
    var displayStyle = "display: table-row;"
    var rows = []
    for (value in data["table_data"]) {
        if (value % 2 == 0) footable = "footable-odd"; else footable = "footable-even";
        cont += 1;
        tabla = '<tr class="' + footable + '" style="' + displayStyle + '"> <td><span class="footable-toggle"></span>' + cont + '</td><td>' + data["table_data"][value]['triage_id'] + '</td>' +
            '<td class="' + ColorClasificacion(data["table_data"][value]) + '" style="color: white">' +
            data["table_data"][value]['triage_nombre'] + data["table_data"][value]['triage_nombre_ap'] + data["table_data"][value]['triage_nombre_am'] +
            '</td>' +
            '<td>' + data["table_data"][value]['triage_hora_clasifica'] + '</td>' +
            '<td>' + data["table_data"][value]['asistentesmedicas_hora'] + '</td>' +
            '<td>' +
            TiempoTranscurrido(
                {
                    'Tiempo1_fecha': data["table_data"][value]['triage_fecha_clasifica'],
                    'Tiempo1_hora': data["table_data"][value]['triage_hora_clasifica'],
                    'Tiempo2_fecha': data["table_data"][value]['asistentesmedicas_fecha'],
                    'Tiempo2_hora': data["table_data"][value]['asistentesmedicas_hora']
                }
            ) +
            ' Minutos </td>' +
            '<td>'
        if (data["table_data"][value]['pic_mt'] != '') {
            tabla += data["table_data"][value]['pic_mt']
        } else {
            tabla += '<b style="color:#256659">Por asignar, caso COVID-19</b><br>'
        }
        tabla += '</td><td>'

        if (data["table_data"][value]['triage_via_registro'] == 'Hora Cero TR') {
            tabla += '<a href="http://' + host + '/Asistentesmedicas/Triagerespiratorio/Registro/' + data["table_data"][value]['triage_id'] + '?a=edit" target="_blank">' +
                '<i class="fa fa-pencil icono-accion tip" data-original-title="Editar datos"></i>' +
                '</a>&nbsp;'
        } else {
            tabla += '<a href="http://' + host + '/Asistentesmedicas/Paciente/' + data["table_data"][value]['triage_id'] + '" target="_blank">' +
                '<i class="fa fa-pencil icono-accion tip" data-original-title="Editar datos"></i>' +
                '</a>&nbsp;'
        }
        // <!--<a href="+ base_url()Asistentesmedicas/Hospitalizacion/Registro/+data[value]['triage_id']" target='_blank' rel="opener"> -->
        tabla += '<i class="fa fa-pencil-square-o icono-accion btn-reg-43051 pointer tip" data-paciente="' + data["table_data"][value]['triage_id'] + '" data-original-title="Requisitar Información 43051"></i>'
        //<!-- </a> --> 
        if (data["um_config"]['CONFIG_AM_HOJAINICIAL'] == 'Si') {
            tabla += '<i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumentoMultiple(' + window.location.host + 'inicio/documentos/HojaFrontal/' + data[value]['triage_id'] + ',\'Hoja Frontal\',200)" data-original-title="Generar Hoja Frontal"></i>'
        }
        if (data["table_data"][value]['pia_lugar_accidente'] == 'TRABAJO') {
            tabla += '&nbsp;<i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumentoMultiple(' + window.location.host + 'inicio/documentos/ST7/' + data[value]['triage_id'] + ',\'ST7\',200)" data-original-title="Generar ST7"></i>'
        }
        tabla += '</td></tr>';
        rows.unshift(tabla);
        noRow += 1;
    }
    var table = document.getElementById('tabla1');
    var rowCount = table.rows.length;
    for (var i=0; No_pacientes-1>i; i++) {
        table.deleteRow(1);
    }
    for (r in rows) {
        var row = table.insertRow(1);
        row.innerHTML = rows[r];
    }
    No_pacientes = cont;
    if (table.rows.length > 3){
        table.deleteRow(table.rows.length - 2)
    }else{
        table.insertRow(1)
        table.deleteRow(2)
    }
    document.getElementById("noFolio").click();
    document.getElementById("noFolio").click();
    $('.btn-reg-43051').click(function () {
        var triage_id = $(this).attr('data-paciente');
        bootbox.confirm({
            message: '<h5 style="text-align:center;">¿Quiere Ingresar este Paciente a Hospitalización?</h5>',
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

                    window.open(base_url + 'Asistentesmedicas/Hospitalizacion/Registro/' + triage_id, '_parent', 'rel=opener');
                }
            }
        });
    });
}