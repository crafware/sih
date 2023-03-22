$(document).ready(function () {
  
  //let area = $('input[name=area]').val();
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
            //console.log(data);
            bootbox.hideAll();
            /*if (data.accion == '6') {
                $('.cama' + cama_id).removeClass('grey-900').addClass('cyan-400');

            } else if (data.accion == '7') {
                $('.cama' + cama_id).removeClass('yellow-600').addClass('lime');
            }*/
            msj_success_noti('La cama esta Limpia');
        }, error: function (e) {
            msj_error_noti('problemas');
            //msj_error_serve();

        }
    })
  }

  AjaxCamas();
  /*=============================================
    =                Limpieza Cama               =
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
  /* ================================================================ *
                    Cambiar a Disponible                         
    /* ================================================================ */
  $('body').on('click', '.cyan-400', function () {
      var cama_id = $(this).attr('data-cama');
      //var camaEstado=$(this).attr('data-accion');
      var camaNombre = $(this).attr('data-cama_nombre');
      bootbox.confirm({
          message: '<h4>'+'¿Desea vestir y hacer disponible cama ' + camaNombre + ' ?'+'</h4>',
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
                              msj_success_noti('La cama esta disponible');
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
    AbrirDocumento(base_url+'Inicio/Documentos/reporteEstadoSaludPiso?piso_id='+piso_id);
  })
  $('body').on('click','.ReporteEspe', function(e){
    e.preventDefault();
    let piso_id = $(this).attr('data-pisoname');
    bootbox.prompt({
        title: '<h5>'+`${piso_id} - Seleccionar especialidad`+'</h5>',
        inputType: 'select',
        inputOptions: inputOptions,
        size: 'small',
        buttons: {
                confirm: {
                    label: 'Aceptar',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-danger'
                }
        },
      callback: function (result) {
        if(result){
          AbrirDocumento(base_url+'inicio/Documentos/reporteEstadoSaludPiso?especialidad_id='+result);
        }
      }
    });
  });
});
