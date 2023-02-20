$(document).ready(function (e) {
    $('input[name=triage_fecha_nac]').mask('99/99/9999');
    $('select[name=triage_paciente_sexo]').val($('select[name=triage_paciente_sexo]').data('value'));
    $('select[name=ingreso_servicio]').val($('select[name=ingreso_servicio]').data('value'));
    $('select[name=ingreso_medico]').val($('select[name=ingreso_medico]').data('value'));
    $('select[name=motivo_internamiento]').val($('select[name=motivo_internamiento]').data('value'));
    $('select[name=area]').val($('select[name=area]').data('value'));
    $('select[name=cama]').val($('select[name=cama]').data('value'));
    $('select[name=riesgo_infeccion]').val($('select[name=riesgo_infeccion]').data('value'));

    if($('input[name=triage_paciente_afiliacion_bol]').attr('data-value')!=''){
        $('.triage_paciente_afiliacion_bol').removeClass('hide');
        $('input[name=triage_paciente_afiliacion_bol][value="Si"]').attr('checked',true);
    }else {
        $('input[name=pum_nss]').removeAttr('required');
        $('#datosAfiliacion').addClass('hide');
        $('#nssConformado').removeClass('hide');
    }
    
    $('input[name=triage_paciente_afiliacion_bol]').click(function () {
        if($(this).val()=='Si'){
            $('.triage_paciente_afiliacion_bol').removeClass('hide');
            $('#datosAfiliacion').removeClass('hide');
            $('#nssConformado').addClass('hide');
        }else{
            $('.triage_paciente_afiliacion_bol').addClass('hide');
            $('#datosAfiliacion').addClass('hide');
            $('#nssConformado').removeClass('hide');
            $('input[name="pum_nss"]').removeAttr("required");
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

    $('.generarNss').click(function(){
       
            let triage_id = $('input[name=triage_id]').val();
            let triage_paciente_sexo = $('select[name=triage_paciente_sexo]').val();
            let fecha_nacimiento = $('input[name=triage_fecha_nac]').val().substr(-4);

            $.ajax({
                url: base_url+'Admisionhospitalaria/GenerarNssConformado',
                type: 'POST',
                dataType: 'json',
                data: {
                        triage_paciente_sexo: triage_paciente_sexo,
                        triage_id: triage_id,
                        fecha_nacimiento: fecha_nacimiento,
                        csrf_token: csrf_token
                      },
                success: function (data, textStatus, jqXHR) {
                    if(data.accion == '1'){
                        console.log(data.nss_c);
                        $('input[name=pum_nss_armado]').val(data.nss_c);
                        
                    }
                }
            })
        
    })

    $('.regitroHospUrgente').submit(function (e){
        e.preventDefault();
        $.ajax({
            //url: base_url+'Asistentesmedicas/Triagerespiratorio/Ajaxregistro',
            url: base_url+'Asistentesmedicas/Hospitalizacion/Ajaxregistro',
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                console.log(data);
                if(data.accion=='1'){
                    // AbrirDocumentoMultiple(base_url+'inicio/documentos/HojaFrontal/'+$('input[name=triage_id]').val(),'HojaFrontal',100);
                    // if($('select[name=pia_lugar_accidente]').val()=='TRABAJO'){
                    //     AbrirDocumentoMultiple(base_url+'inicio/documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',800);
                    // }
                    //ActionCloseWindowsReload();
                    ActionCloseWindows();
                    AbrirDocumentoMultiple(base_url+'inicio/Documentos/DOC43051/'+$('input[name=triage_id]').val(),'430-51',100);
                }
            },error: function (e) {
                msj_error_serve();
                console.log(e);
                bootbox.hideAll();
                ReportarError(window.location.pathname,e.responseText)
            }
        })
    });

    $('body').on('click','.salida-paciente',function (e) {
        if(confirm('¿DAR SALIDA DE PACIENTE?')){
            $.ajax({
                url: base_url+"Asistentesmedicas/Triagerespiratorio/Ajaxsalidapaciente",
                type: 'POST',
                data:{
                    triage_id:$(this).attr('data-id'),
                    csrf_token:csrf_token
                },beforeSend: function (xhr) {
                    msj_loading()
                },success: function (data, textStatus, jqXHR) {
                    if(data.accion=='1'){
                        msj_success_noti('SALIDA REGISTRADA');
                        ActionWindowsReload();
                    }
                },error: function (e) {
                    msj_error_serve(e)
                    ReportarError(window.location.pathname,e.responseText);
                }
            })
        }    
    });

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
                alert('Error no hay definición de Medico Jefe de Servicio');
            }
        });
    });
    
    $('.area').change(function(){
      var area_id = $("select[name=area]").val();
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
          $(".cama").html(data);
        },
            error : function(e) {
                alert('Error en el proceso de consulta');
            }
        });
    });
    
})
