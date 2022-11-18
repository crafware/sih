$(document).ready(function () {
    $('.agregar-horacero-paciente').on('click',function(e){
        e.preventDefault();
        $.ajax({
            url: base_url+"Horacero/GenerarFolio",
            dataType: 'json',
            beforeSend: function (data, textStatus, jqXHR) {
                msj_loading('Guardando registro...');
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.accion=='1'){
                    location.href=base_url+'Consultaexterna/AsistenteMedica/'+data.max_id;
               }
            },error: function (e) {
                bootbox.hideAll();
                msj_error_serve();
                ReportarError(window.location.pathname,e.responseText)
            }
        });
    });
   $('.agregar-orden-internamiento').on('click',function(e){
        e.preventDefault();
        $.ajax({
            url: base_url+"Horacero/GenerarFolio",
            dataType: 'json',
            beforeSend: function (data, textStatus, jqXHR) {
                msj_loading('Guardando registro...');
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.accion=='1'){
                    location.href=base_url+'Consultaexterna/Ordeninternamiento/'+data.max_id;
               }
            },error: function (e) {
                bootbox.hideAll();
                msj_error_serve();
                ReportarError(window.location.pathname,e.responseText)
            }
        });
    });
    $('select[name=ac_ingreso_servicio]').val($('select[name=ac_ingreso_servicio]').data('value'));
    $('select[name=ac_ingreso_medico]').val($('select[name=ac_ingreso_medico]').data('value'));
    $('select[name=ac_internamiento]').val($('select[name=ac_internamiento]').data('value'));
    $('select[name=tipo_ingreso]').val($('select[name=tipo_ingreso]').data('value'));
    $('input[name=triage_fecha_nac]').mask('99/99/9999');
    $('input[name=ac_fecha]').mask('99/99/9999');

    $('.especialidad').change(function(){
      var especialidad_id = $("select[name=ac_ingreso_servicio]").val();
      console.log (especialidad_id);
      $.ajax({
        url : base_url+'Consultaexterna/getMedicoEspecialista',
        type : 'POST',
        data : {
                especialidad_id: especialidad_id,
                csrf_token:csrf_token,
            },
        dataType : 'json',
        success : function(data, textStatus, jqXHR) {
            //alert(data);
          $("#divMedicos").html(data);
        },
            error : function(e) {
                alert('Error en el proceso de consulta');
            }
        });
    });
    $('select[name=ac_ingreso_medico]').change(function(){
      var empleado_id = $('select[name=ac_ingreso_medico]').val();
      console.log (empleado_id);
      $.ajax({ 
            url : base_url+'Consultaexterna/getMatriculaMedico',
            type : 'POST',
            data : {
                 'empleado_id' : empleado_id,
                 csrf_token:csrf_token
            },
            dataType: 'json',
            success : function(data, textStatus, jqXHR) {
                $('#medicoMatricula').val(data);console.log (empleado_id);
            },
        }); 
      
    });
    $('.solicitud-am-consultaexterna').submit(function (e){
        e.preventDefault();
        $.ajax({
            url: base_url+'Consultaexterna/AjaxAsistenteMedica',
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.accion=='1'){
                    AbrirDocumentoMultiple(base_url+'inicio/documentos/DOC43051/'+$('input[name=triage_id]').val(),'HojaFrontal',100);
                    if($('select[name=triage_paciente_accidente_lugar]').val()=='TRABAJO'){
                        AbrirDocumentoMultiple(base_url+'inicio/documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',300);
                    }
                    window.location.href=base_url+'Consultaexterna/';
                }
            },error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
                ReportarError(window.location.pathname,e.responseText)
            }
        })
    })
    
})
