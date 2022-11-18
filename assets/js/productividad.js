$(document).ready(function () {   
  
    /*INDICADORES*/
    $('.dd-mm-yyyy-ce').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        placement: 'bottom'
    });
    $('#fechaProductividad').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        placement: 'bottom'
    });
    $('.clockpicker-ce').clockpicker({
        placement: 'bottom',
        autoclose: true
    });
  

    $('.btn-indicador-ac').click(function () {
        var selectArea = $('select[name=area_ac]').val();
        var selectMedico = $('select[name=id_medico]').val();
        var selectTurno = $('select[name=Turno]').val();
        console.log(selectArea, selectMedico,selectTurno);
        $.ajax({
            url: base_url+"urgencias/AjaxProductividad",
            type: 'POST',
            dataType: 'json',
            data: {
                inputArea:selectArea,
                idMedico:selectMedico,
                selectTurno:selectTurno,
                inputFechaInicio:$('input[name=inputFechaInicio]').val(),   
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                console.log(data)
                bootbox.hideAll();
                $('.Registros').removeClass('hide');
                $('.TOTAL_PACIENTES').find('span').html(data.TOTAL_DOCS+' ENCONTRADOS');
                $('.GENERAR_LECHUGA_CONSULTORIOS')
                        .attr({'data-inputfecha':$('input[name=inputFechaInicio]').val(), 
                               'data-idmedico':$('select[name=id_medico]').val(), 
                               'data-area':$('select[name=area_ac]').val(),
                               'data-turno':$('select[name=Turno]').val() 
                              }).removeClass('hide');                       
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e)
            }      
        })
    })
    $('.GENERAR_LECHUGA_CONSULTORIOS').click(function (e) {
        AbrirDocumento(base_url+'Inicio/DocumentosProductividad/lechugaAdmisionContinua?inputFechaInicio='
            +$(this).attr('data-inputfecha')+'&id_medico='
            +$(this).attr('data-idmedico')+'&area_ac='
            +$(this).attr('data-area')+'&turno='
            +$(this).attr('data-turno'), '_blank');
    });
})