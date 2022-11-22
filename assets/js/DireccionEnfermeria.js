$(document).ready(function () {
  let area = $('input[name=area]').val();
  function AjaxCamas() {
    $.ajax({
      url: base_url + "AdmisionHospitalaria/AjaxVisorDireccionEnfermeria",
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

  /*function SolicitaCambioEstado(cama_id, accion, folio) {
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
      }, error: function (e) {
        msj_error_noti('problemas');
      }
    })
  }

  $('body').on('click', '.cama-no', function () {
    var triage_id = $(this).attr('data-folio');
    var cama_id = $(this).attr('data-cama');
    var camaNombre = $(this).attr('data-cama_nombre');
    if ($(this).hasClass('cyan-400')) {
      bootbox.confirm({
        title: '<h5>Vestir Cama</h5>',
        message: "¿Quiere vestir la cama?",
        size: 'small',
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
        callback: function (res) {
          if (res == true) {
            triage_id = 0
            SolicitaCambioEstado(cama_id, 7, triage_id)
          }
        }
      });
    }
  });*/
  /*=============================================
    =                 Vestir cama                 =
    =============================================*/
    $('body').on('click', '.cyan-400', function () {
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
    });
  AjaxCamas();
});
