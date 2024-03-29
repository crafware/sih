$(document).ready(function () {
    let area = $('input[name=area]').val();
    $('body').on('click', '.confirmar-Limpieza', function () {
        let camaId = $(this).attr('data-cama');
        let camaNombre = $(this).attr('data-cama_nombre');
        let folio = $(this).attr('data-folio');
        let estadoPaciente = $(this).attr('data-paciente');
        bootbox.confirm({
            message: '<center><h4>¿Confirmar Limpieza de cama ' + camaNombre + ' ?</h4></center>',
            buttons: {
                confirm: {
                    label: 'Si',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    SolicitaCambioEstado(camaId, 6, folio, estadoPaciente);
                }
            }
        });
    });

    $('body').on('click', '.nota-cama', function () {
        let camaId = $(this).attr('data-cama');
        let camaNombre = $(this).attr('data-cama_nombre');
        let empleado_id =  $('input[name=infoEmpleado]').val();
        bootbox.prompt({
            title: '<center><h4>Agregar nota a la cama ' + camaNombre + '</h4></center>',
            inputType: 'textarea',
            callback: function (result) {
                if (result == null){
                    msj_success_noti("Nota no agregada");
                }else if (result != ""){
                    GuardarNotaCama(camaId, empleado_id, result);
                }else{
                    msj_error_noti("Escribe una nota");
                }
            }
        });
    });

    $('body').on('click', '.cambiar-estado-semaforo', function () {
        let data_semaforo       = $(this).attr('data-semaforo');
        let cama_id             = $(this).attr('data-cama');
        let camaNombre          = $(this).attr('data-cama_nombre');
        let data_semaforo_no    = 4 - parseInt(data_semaforo);
        let data_limpieza_no    = parseInt(data_semaforo) - 1;
        bootbox.confirm({
            message: '<center><h4>¿Confirmar limpieza No.'+data_semaforo_no+' de la cama '+camaNombre+'?</h4></center>',
            buttons: {
                confirm: {
                    label: 'Si',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result){
                    GuardarEstadoSemaforo(cama_id,camaNombre, data_limpieza_no,data_semaforo_no);
                }else{
                    msj_error_noti("No se confirmo la limpieza" );
                }
            }
        });
    });

    $('body').on('click', '.cama-no', function () {
        let camaId = $(this).attr('data-cama');
        let camaEstado = $(this).attr('data-estado');
        let camaNombre = $(this).attr('data-cama_nombre');
        let folio = $(this).attr('data-folio');
        let estadoPaciente = $(this).attr('data-paciente');
        let accion;
        switch (area) {
            case 'Conservación':
                if ($(this).hasClass('yellow-600')) {
                    bootbox.confirm({
                        message: '<center><h4>¿Confirmar Reparación de cama ' + camaNombre + ' ?</h4></center>',
                        buttons: {
                            confirm: {
                                label: 'Si',
                                className: 'btn-success'
                            },

                            cancel: {
                                label: 'No',
                                className: 'btn-danger'
                            }
                        },
                        callback: function (result) {
                            if (result) {
                                if (camaEstado === 'Sucia' || camaEstado === 'Contaminada') {
                                    accion = 6; // Cambiar a limpia
                                } else if (camaEstado === 'Descompuesta') {
                                    accion = 7; // Cambio a Reparada 
                                }
                                //console.log(camaId,camaEstado,folio,accion);
                                SolicitaCambioEstado(camaId, accion, folio, estadoPaciente);
                            }
                        }
                    });
                }
                break;
        }

    });

    function GuardarEstadoSemaforo(cama_Id,camaNombre, data_limpieza_no,data_semaforo_no){
        $.ajax({
            url: base_url + "AdmisionHospitalaria/AjaxGuardarEstadoSemaforo",
            type: "POST",
            dataType: "json",
            data: {
                cama_id: cama_Id,
                result: data_limpieza_no,
                csrf_token: csrf_token
            }, success: function(data){
                msj_success_noti('Se confirmo la limpieza No.' + data_semaforo_no+' de la cama '+camaNombre);
            }, error: function(e){
                msj_error_noti(e);
            }
        })
    }

    function GuardarNotaCama(cama_Id, empleado_id, result){
        $.ajax({
            url: base_url + "AdmisionHospitalaria/AjaxGuardarNotaCama",
            type: "POST",
            dataType: "json",
            data: {
                cama_id: cama_Id,
                empleado_id: empleado_id,
                result: result,
                csrf_token: csrf_token
            },
            beforeSend: function (xhr){
                msj_loading();
            }, success: function(data){
                bootbox.hideAll();
                console.log(data)
                msj_success_noti("Nota agregada");
            }, error: function(e){
                msj_error_noti(e);
            }
        })
    }

    function AjaxCamas() {
        $.ajax({
            url: base_url + "AdmisionHospitalaria/AjaxVisorCamasLimpiesaEHigiene",
            dataType: 'json',
            beforeSend: function (xhr) {
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

    function SolicitaCambioEstado(cama_id, accion, folio, estadoPaciente) {
        console.log(cama_id, accion, folio, estadoPaciente);
        $.ajax({
            url: base_url + "Hospitalizacion/SolicitaCambioEstado",
            type: 'POST',
            dataType: 'JSON',
            data: {
                cama_id: cama_id,
                accion: accion,
                triage_id: folio,
                estadoPaciente: estadoPaciente,
                csrf_token: csrf_token
            },
            beforeSend: function (xhr) {
                msj_loading();
            },
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                bootbox.hideAll();
                if (data.accion == '6') {
                    $('.cama' + cama_id).removeClass('grey-900').addClass('cyan-400');

                } else if (data.accion == '7') {
                    $('.cama' + cama_id).removeClass('yellow-600').addClass('lime');
                }
            }, error: function (e) {
                msj_error_noti('problemas');
                //msj_error_serve();

            }
        })
    }
    /*=============================================
    =                 Vestir cama                 =
    =============================================*/
    /*$('body').on('click', '.cyan-400', function () {
        var cama_id = $(this).attr('data-cama');
        //var camaEstado=$(this).attr('data-accion');
        var camaNombre = $(this).attr('data-cama_nombre');
        bootbox.confirm({
            message: '¿DESEA VESTIR CAMA ' + camaNombre + ' ?',
            size: 'medium',
            buttons: {
                confirm: {
                    label: 'Si',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: base_url + "Hospitalizacion/AjaxVestirCama",
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            cama_id: cama_id,
                            csrf_token: csrf_token,
                        },
                        beforeSend: function (xhr) {
                            msj_loading();
                        },
                        success: function (data, textStatus, jqXHR) {
                            console.log(data);
                            bootbox.hideAll();
                            if (data.accion == '1') {
                                msj_error_noti('No se encontro cama');
                            } else if (data.accion == '2') {
                                msj_success_noti('La cama ha cido vestida');
                            }
                        },
                        error: function (e) {
                            bootbox.hideAll();
                            MsjError();
                            //console.log(e);
                        }
                    });
                }
            }
        })
    });*/
    AjaxCamas();
});
