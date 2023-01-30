$(document).ready(function (e) {
    $("#selectPiso").change(function () {
        var piso = $(this).val();
        $('.info-tabs').addClass('hide');
        AjaxCamasPiso(piso);
    });

    $('body').on('click', '.cama-no', function () {
        var triage_id = $(this).attr('data-folio');
        var cama_id = $(this).attr('data-cama');
        var camaNombre = $(this).attr('data-cama_nombre');
        if ($(this).hasClass('cyan-400')) {
            triage_id = 0
            //console.log(triage_id, cama_id, camaNombre);
        }
        AjaxInfoPacienteCama(cama_id, triage_id, camaNombre);
    });

    /* acciones de botones para camas */
    /* 1=Reservado,
       2=Ocupado,
       3=Sucia,
       4=Contaminada,
       5=Descompuesta,
       6=Limpia,
       7=vestida=Disponible */
    $('body').on('click', '.btnAccion', function () {
        let infoEmp = $('input[name=infoEmpleado]').val();
        let cama_id = $(this).attr('data-cama');
        let folio = $(this).attr('data-folio');
        let accion = $(this).attr('data-accion');
        console.log(infoEmp)
        switch (accion) {
            case '1':
                mensaje = '¿Confirmar el ingreso de paciente?';
                break;
            case '2':
                mensaje = '¿Desea cambiar a Ocupado?';
                break;
            case '3':
                mensaje = '¿Desea cambiar a cama Sucia?';
                break;
            case '4':
                mensaje = '¿Desea indicar cama Contaminada?';
                break;
            case '5':
                mensaje = '¿Desea indicar cama Descompuesta?';
                break;
            case '6':
                mensaje = '¿Confirmar cama Limpia?';
                break;
            case '7':
                mensaje = '¿Confirmar cama Vestida y hacer Disponible?';
                break;
            default:
                console.log('Lo lamentamos, por el momento no disponemos de ' + accion + '.');
        }
        bootbox.confirm({
            message: mensaje,
            buttons: {
                confirm: {
                    label: 'Si',
                    className: 'back-imss'
                },
                cancel: {
                    label: 'No',
                    className: 'back-imss'
                }
            },
            callback: function (result) {
                if (result) {
                    if (accion == "5") {
                        addNotaDescompuesta(cama_id, infoEmp, folio,)
                    } else {
                        SolicitaCambioEstado(cama_id, accion, folio);
                    }
                }
            }
        })
    });

    function AjaxCamasPiso(piso) {
        $.ajax({
            url: base_url + "Hospitalizacion/AjaxCamasPiso",
            type: 'POST',
            dataType: 'json',
            data: {
                piso: piso,
                csrf_token: csrf_token,
            },
            beforeSend: function (xhr) {
                msj_loading();
            }, success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                
                $('#camasTotal').html(data.Total);
                $('.visor-camas').html(data.Col);
                $('#piso').html(data.Piso + ' ' + '<small style="padding-left: 100px;color:brown">' +
                    'PA=Prealta&nbsp;&nbsp;&nbsp;&nbsp;' +
                    'CC=Cambio de Cama&nbsp;&nbsp;&nbsp;&nbsp;' +
                    'A=Alta&nbsp;&nbsp;&nbsp;&nbsp;' +
                    'AC=Alta Cancelada</small>');
                $('#camasDisponibles').html(data.Disponibles);
                $('#camasOcupadas').html(data.Ocupadas);
                $('#camasSucias').html(data.Sucias);
                $('#camasContaminadas').html(data.Contaminadas);
                $('#camasDescompuestas').html(data.Descompuestas);
                $('#camasLimpias').html(data.Limpias);
                $('#camasPrealta').html(data.Prealtas);
                console.log(data)
            }, error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    }

    function AjaxCamasTooltip() {
        $.ajax({
            url: base_url + "AdmisionHospitalaria/AjaxGetCamas",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading();
            }, success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                for (const bed of data.os_camas) {
                    $("#" + bed.cama_id).mouseenter(function () {
                        if ((!($(this).attr("data-folio") == "" || $(this).attr("data-folio") == "0")) && (!(dropdownToggleForbidden.find(element => element.trim() === $('input[name=area]').val())))) {
                            getDataTooltip(bed.cama_id);
                        }
                        console.log( bed.cama_id)
                    });
                    $("#" + bed.cama_id).mouseleave(function () {
                        hideTooltip("tooltip" + bed.cama_id);
                        console.log( bed.cama_id)
                    });
                    console.log( bed)
                    console.log( bed.cama_id)
                }
                //$('[rel="tooltip"]').tooltip();
            }, error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    }

    function AjaxInfoPacienteCama(cama_id, triage_id, cama_name) {
        $.ajax({
            url: base_url + "Hospitalizacion/AjaxInfoPacienteCama",
            type: 'POST',
            dataType: 'JSON',
            data: {
                cama_id: cama_id,
                cama_name: cama_name,
                triage_id: triage_id,
                csrf_token: csrf_token
            },
            beforeSend: function (xhr) {
                msj_loading();
            },
            success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.info-tabs').removeClass('hide');
                $('.container-info-cama').removeClass('hide');
                $('#dataPatient').html(data.infoPaciente);
                $('#nombreCama').html(data.infoCama);
                $('.buttons-estados').html(data.estados);
                console.log(data.estados);

            }, error: function (e) {
                $('.container-info-cama').addClass('hide');
                //$('.info-tabs').addClass('hide');
                msj_error_noti('No hay paciente en cama solicitada');
                bootbox.hideAll();
                //msj_error_serve();
            }
        })
    }

    function SolicitaCambioEstado(cama_id, accion, folio) {

        //console.log(cama_id,accion,folio);
        $.ajax({
            url: base_url + "Hospitalizacion/SolicitaCambioEstado",
            type: 'POST',
            dataType: 'JSON',
            data: {
                cama_id: cama_id,
                accion: accion,
                triage_id: folio,
                csrf_token: csrf_token
            },
            beforeSend: function (xhr) {
                msj_loading();
            },
            success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if (data.accion == '5') {
                    msj_success_noti("Se reportó cama descompuesta");
                }
            }, error: function (e) {
                msj_error_noti('problemas');
            }
        })
    }

    function addNotaDescompuesta(cama_id, infoEmp, folio) {
        let mensaje = '' +
            '<div><input type="checkbox" id="Mecanica_id" name="contact" value="Mecánica" />' +
            '<label for="contactChoice1">Mecánica</label></div>' +
            '<div><input type="checkbox" id="Electrica_id" name="contact" value="Eléctrica" />' +
            '<label for="contactChoice2">Eléctrica</label></div>' +
            '<div><input type="checkbox" id="Plomeria_id" name="contact" value="Plomería" />' +
            '<label for="contactChoice3">Plomería</label></div>' +
            '<div><input type="checkbox" id="Otros_id" name="contact" value="Otros" />' +
            '<label for="contactChoice3">Otros</label></div>' +
            '<textarea type="text" id="detalles" name="detalles" rows="4" cols="50"></textarea>';
        bootbox.confirm({
            title: '<h5>Selecciona la naturaleza del problema(s)</h5>',
            message: mensaje,
            buttons: {
                confirm: {
                    label: 'Guardar nota',
                    className: 'back-imss'
                }, cancel: {
                    label: 'Cancelar',
                    className: 'back-imss'
                }
            }, callback: function (result) {
                if (result) {
                    var Tipo = ""
                    if (document.getElementById('Mecanica_id').classList.contains('has-value')) {
                        Tipo += "Mecanica "
                    }
                    if (document.getElementById('Electrica_id').classList.contains('has-value')) {
                        Tipo += "Electrica "
                    }
                    if (document.getElementById('Plomeria_id').classList.contains('has-value')) {
                        Tipo += "Plomeria "
                    }
                    if (document.getElementById('Otros_id').classList.contains('has-value')) {
                        Tipo += "Otros "
                    }
                    var detalles = document.getElementById('detalles').value
                    if (Tipo != "" && detalles != "") {
                        var nota = "Tipo: \n" + Tipo + "\n Nota: \n" + detalles
                        GuardarNotaCama(cama_id, infoEmp, nota, 1);
                        SolicitaCambioEstado(cama_id, "5", folio);
                    } else {
                        msj_error_noti("No se cambio el estado de la cama, faltan campos por llenas.");
                    }
                }
            }
        });
    }

    function GuardarNotaCama(cama_Id, empleado_id, result, tipo) {
        $.ajax({
            url: base_url + "AdmisionHospitalaria/AjaxGuardarNotaCama",
            type: "POST",
            dataType: "json",
            data: {
                cama_id: cama_Id,
                empleado_id: empleado_id,
                result: result,
                tipo: tipo,
                csrf_token: csrf_token
            },
            beforeSend: function (xhr) {
                msj_loading();
            }, success: function (data) {
                bootbox.hideAll();
                console.log(data)
                msj_success_noti("Nota agregada");
            }, error: function (e) {
                msj_error_noti(e);
            }
        })
    }
})