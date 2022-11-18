

$(document).ready(function (e) {
    $('input[name=triage_fecha_nac]').mask('99/99/9999');
    $('select[name=triage_paciente_sexo]').val($('select[name=triage_paciente_sexo]').data('value'));
    $('select[name=ingreso_servicio]').val($('select[name=ingreso_servicio]').data('value'));
    $('select[name=tipo_ingreso]').val($('select[name=tipo_ingreso]').data('value'));
    $('select[name=ingreso_medico]').val($('select[name=ingreso_medico]').data('value'));
    $('select[name=motivo_internamiento]').val($('select[name=motivo_internamiento]').data('value'));
    $('select[name=area]').val($('select[name=area]').data('value'));
    $('select[name=cama]').val($('select[name=cama]').data('value'));
    $('select[name=riesgo_infeccion]').val($('select[name=riesgo_infeccion]').data('value'));
    
    if($('input[name=triage_paciente_afiliacion_bol]').attr('data-value')!=''){
        $('.triage_paciente_afiliacion_bol').removeClass('hide');
        $('input[name=triage_paciente_afiliacion_bol][value="Si"]').attr('checked',true);
    }
    
    $('input[name=triage_paciente_afiliacion_bol]').click(function () {
        if($(this).val()=='Si'){
            $('.triage_paciente_afiliacion_bol').removeClass('hide');
        }else{
            $('.triage_paciente_afiliacion_bol').addClass('hide');
        }
    })
    $('input[name=pia_procedencia_espontanea]').click(function (e){
        if($(this).val()=='Si'){
            $('input[name=pia_procedencia_espontanea_lugar]').prop('type','text').attr('required',true);
            $('.col-no-espontaneo').addClass('hidden');
            $('select[name=pia_procedencia_hospital]').val("");
            $('input[name=pia_procedencia_hospital_num]').removeAttr('required').val('');
        }else{
            $('input[name=pia_procedencia_espontanea_lugar]').prop('type','hidden').removeAttr('required').val('');
            $('.col-no-espontaneo').removeClass('hidden');
            $('input[name=pia_procedencia_hospital_num]').attr('required',true);
        }
    })
    if($('input[name=pia_procedencia_espontanea]').attr('data-value')=='No'){
        $('.col-no-espontaneo').removeClass('hidden');
        $('input[name=pia_procedencia_espontanea][value="No"]').prop("checked",true);
        $('input[name=pia_procedencia_espontanea_lugar]').prop('type','hidden').removeAttr('required');
        
        $("select[name=pia_procedencia_hospital]").val($('select[name=pia_procedencia_hospital]').attr('data-value'));
        $('input[name=pia_procedencia_hospital_num]').attr('required',true);
    }

    $('input[name=buscarPaciente]').focus();
    $('input[name=buscarPaciente]').keyup(function (e){
        var triage_id=$(this).val();
        var input=$(this);

        if(triage_id.length==11 && triage_id!=''){
            console.log(triage_id);
            $.ajax({
                url: base_url+"Admisionhospitalaria/BuscarPacienteRegistrado",
                dataType: 'json',
                type: 'POST',
                data:{
                    triage_id:triage_id,
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading();
                },success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    bootbox.hideAll();
                    if(data.accion=='1' ){
                        if(data.via_ingreso == 'Hora Cero TR'){
                            window.open(base_url+'Asistentesmedicas/Triagerespiratorio/Registro/'+triage_id,'_blank');
                        }else if(data.via_ingreso == 'Hora Cero'){
                            window.open(base_url+'Admisionhospitalaria/Registro/'+triage_id,'_blank');
                        }

                    }if(data.accion=='2'){
                        msj_error_noti('EL FOLIO DEL PACIENTE NO EXISTE O NO HA SIDO REGISTRADO');
                    }
                },error: function (e) {
                    bootbox.hideAll();
                    msj_error_serve(e);
                    ReportarError(window.location.pathname,e.responseText)
                }
            })
            input.val('');

        }
    });
    $('#buscarCP').click(function (e){
        if($('input[name=directorio_cp]').val()!=''){
            BuscarCodigoPostal({
                'cp':$('input[name=directorio_cp]').val(),
                'input1':'directorio_municipio',
                'input2':'directorio_estado',
                'input3':'directorio_colonia'
            })
        }
    });
    $('input[name=directorio_cp]').blur(function (e){
        if($(this).val()!=''){
            BuscarCodigoPostal({
                'cp':$(this).val(),
                'input1':'directorio_municipio',
                'input2':'directorio_estado',
                'input3':'directorio_colonia'
            })
        }
    });

    $('#btnTelefonoPaciente').click(function(){
      var telefono = $("input[name = directorio_telefono]").val();
      $("input[name = pic_responsable_telefono]").val(telefono);
    });
    
    /*$('.regitro43051').submit(function (e){
        e.preventDefault();
        $.ajax({
            url: base_url+'Admisionhospitalaria/Ajaxregistro43051',
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.accion=='1'){
                     window.history.back();
                    AbrirDocumentoMultiple(base_url+'inicio/documentos/DOC43051/'+$('input[name=triage_id]').val());
                    //ActionCloseWindowsReload();
                     //window.location.assign(base_url+'Asistentesmedicas/Hospitalizacion/AdmisionContinua');
                }
            },error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
                ReportarError(window.location.pathname,e.responseText)
            }
        })
    })*/

    $('.ingreso_servicio').change(function(){
      var especialidad_id = $("select[name=ingreso_servicio]").val();
      console.log (especialidad_id);
      $.ajax({
        url : base_url+'Asistentesmedicas/Triagerespiratorio/getMedicoEspecialista',
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
                alert('Error No esta Registrado Medico Jefe de Servicio');
            }
        });
    });
    
    $('.area').change(function(){
      var area_id = $("select[name=area]").val();
      console.log(area_id);
      $.ajax({
        url : base_url+'Asistentesmedicas/Triagerespiratorio/getCama',
        type : 'POST',
        data : {
                area_id: area_id,
                csrf_token:csrf_token,
            },
        dataType : 'json',
        success : function(data, textStatus, jqXHR) {
            //alert(data);
          $("#cama").html(data);
        },
            error : function(e) {
                alert('Error en el proceso de consulta');
            }
        });
    });

    
    
})
