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
                  className: 'back-imss'
              },
              cancel: {
                  label: 'No',
                  className: 'btn-imss-cancel'
              }
          },
          callback: function (result) {
              if (result) {
                  SolicitaCambioEstado(camaId, 6, folio, estadoPaciente);
              }
          }
      });
  });
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
            /*if (data.accion == '6') {
                $('.cama' + cama_id).removeClass('grey-900').addClass('cyan-400');

            } else if (data.accion == '7') {
                $('.cama' + cama_id).removeClass('yellow-600').addClass('lime');
            }*/
        }, error: function (e) {
            msj_error_noti('problemas');
            //msj_error_serve();

        }
    })
}
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
  $('body').on('click','.ocuparCama',function (e){
    e.preventDefault();
    let triage_id=$(this).data('triage');
    let cama_id=$(this).data('cama');
    let cama_nombre=$(this).data('camanombre');
    
    bootbox.confirm({
      title:'<h5>INGRESAR PACIENTE A CAMA</h5>',
      message:'<div class="row">'+
                  '</div class="col-md-12"><h5>¿DESEA CONFIRMAR EL INGRESO A LA CAMA'+' '+cama_nombre+'?</h5></div>'+
              '</div>',
      size:'small',
      buttons:{
          confirm:{
              label:'Aceptar',
              className: 'back-imss'
          },cancel:{
              label:'Cancelar',
              className:'btn-imss-cancel'
          }
      },callback:function (res) {
          if(res==true){
              SendAjax({
                  cama_id:cama_id,
                  triage_id:triage_id,
                  csrf_token:csrf_token
              },'AdmisionHospitalaria/AjaxConfirmarIngreso',function (response) {
                  AjaxCamas();
                    msj_success_noti('Ingresando paciente en cama ');
              },'');
          }
      }
    });
  });
  $('body').on('click','.ReportePiso', function(e){
    e.preventDefault();
    let piso_id = $(this).data("piso");
    AbrirDocumento('http://localhost/sih/inicio/Documentos/reporteEstadoSaludPiso?piso_id='+piso_id);
  })
  $('body').on('click','.ReporteEspe', function(e){
    e.preventDefault();
    let piso_is = $(this).data("piso")
    bootbox.prompt({
      title: 'Selecciona servicio',
      inputType: 'select',
      inputOptions: inputOptions,
      callback: function (result) {
          console.log(result);
          AbrirDocumento('http://localhost/sih/inicio/Documentos/reporteEstadoSaludPiso?especialidad_id='+result);
      }
    });
  })
  AjaxCamas();
});
