$('input[name=triage_id]').focus();
$('input[name=triage_id]').keyup(function (e){
  var triage_id=$(this).val();
  var input=$(this);
  if(triage_id.length==11 && triage_id!=''){
    $.ajax({
      url: base_url+"Asistentesmedicas/Hospitalizacion/BuscarOrdenInternamiento",
      dataType: 'json',
      type: 'POST',
      data:{
            triage_id:triage_id,
            csrf_token:csrf_token
            },
      beforeSend: function (xhr) {
                msj_loading();
            },
      success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.accion=='1' ){
                  window.open(base_url+'Asistentesmedicas/Hospitalizacion/Registro/'+triage_id);
                }else{
                       msj_error_noti('El folio no tiene Una Orden de Internamiento');
                }

            },
      error: function (e) {
          bootbox.hideAll();
          msj_error_serve(e);
          ReportarError(window.location.pathname,e.responseText)
      }
    })
  }
})
$('body').on('click','.generar43051',function (e) {
    e.preventDefault();
    AbrirDocumentoMultiple(base_url+'Inicio/Documentos/DOC43051/'+$(this).attr('data-triage'),'DOC43051');
    $('.modal').modal('hide')   
});