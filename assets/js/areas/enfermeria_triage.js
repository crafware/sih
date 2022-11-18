/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $('#input_search,#input_search_am').focus()
    $('#input_search').keyup(function (e){
        var input=$(this);
        if($(this).val().length==11 && input.val()!=''){ 
            $.ajax({
                url: base_url+"areas/enfermeriatriage/EtapaPaciente/"+input.val(),
                dataType: 'json',
                success: function (data, textStatus, jqXHR) { 
                    if(data.accion=='1' && input.val()!=''){
                        window.open(base_url+'areas/enfermeriatriage/Paciente/'+input.val(),'_blank');
                    }if(data.accion=='2' && input.val()!=''){
                        msj_error_noti('EL N° de paciente no existe')
                        
                    }     
                    input.val('');
                    e.preventDefault();
                },error: function (e) {
                    msj_error_serve();
                }
            })
            
            
        }
    })
    $('input[name=triage_procedencia_espontanea]').click(function (e){
        if($(this).val()=='Si'){
            $('input[name=triage_procedencia]').prop('type','text').attr('required',true);
            $('.col-no-espontaneo').addClass('hidden');
            $('input[name=triage_hostital_nombre_numero]').removeAttr('required').val('');
            $('select[name=triage_hospital_procedencia]').val("");
        }else{
            $('input[name=triage_procedencia]').prop('type','hidden').removeAttr('required').val('');
            $('.col-no-espontaneo').removeClass('hidden');
            $('input[name=triage_hostital_nombre_numero]').attr('required',true);
        }
    })
    if($('select[name=triage_hospital_procedencia]').attr('data-value')!='' && $('input[name=triage_procedencia]').val()==''){
        $('input[name=triage_procedencia]').prop('type','hidden').removeAttr('required');
        $('.col-no-espontaneo').removeClass('hidden');
        $('input[name=triage_hostital_nombre_numero]').attr('required',true);
        $('input[name=triage_procedencia_espontanea][value="No"]').prop("checked",true);
        $("select[name=triage_hospital_procedencia]").val($('select[name=triage_hospital_procedencia]').attr('data-value'))
    }
    $('.guardar-triage-enfermeria').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"areas/enfermeriatriage/Guardar",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.accion=='1'){
                    msj_success_noti('DATOS GUARDADOS');
                    ActionCloseWindowsReload()
                }
            },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    })
    /*Indicador*/
    $('select[name=TipoBusqueda]').change(function () {
        if($(this).val()=='POR_FECHA'){
            $('.row-por-fecha').removeClass('hide');
            $('.row-por-hora').addClass('hide');
        }if($(this).val()=='POR_HORA'){
            $('.row-por-hora').removeClass('hide');
            $('.row-por-fecha').addClass('hide');
        }if($(this).val()==''){
            $('.row-por-hora').addClass('hide');
            $('.row-por-fecha').addClass('hide');
        }
    })
    $('body').on('click','.btn-indicador-buscar',function () {
        $.ajax({
            url: base_url+"areas/Enfermeriatriage/AjaxIndicador",
            type: 'POST',
            data:{
                TipoBusqueda:$('select[name=TipoBusqueda]').val(),
                by_fecha_inicio:$('input[name=by_fecha_inicio]').val(),
                by_fecha_fin:$('input[name=by_fecha_fin]').val(),
                by_hora_fecha:$('input[name=by_hora_fecha]').val(),
                by_hora_inicio:$('input[name=by_hora_inicio]').val(),
                by_hora_fin:$('input[name=by_hora_fin]').val(),
                csrf_token:csrf_token
            },dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.TOTAL span').html(data.TOTAL+' Pacientes')
                $('.TOTAL_C span').html(data.TOTAL_CLASIFICADOS+' Pacientes')
                $('.TOTAL_NO_C span').html(data.TOTAL_NO_CLASIFICADOS+' Pacientes')
                $('.col-indicador-detalles').removeClass('hide');
                $('.col-indicador-grafica').addClass('hide')
                if(data.TOTAL_CLASIFICADOS!=0 || data.TOTAL_NO_CLASIFICADOS!=0){
                    $('.col-indicador-grafica').removeClass('hide')
                }
                $.plot('.grafica-indicador',[
                    {label:'Clasificados ('+data.TOTAL_CLASIFICADOS+')', data: data.TOTAL_CLASIFICADOS}, 
                    {label:'No Clasificados ('+data.TOTAL_NO_CLASIFICADOS+')', data: data.TOTAL_NO_CLASIFICADOS}
                    
                    ],{
                        series: { 
                            pie: { 
                                show: true, 
                                innerRadius: 0.6, 
                                stroke: { 
                                    width: 3 
                                },label: { 
                                    show: true, 
                                    threshold: 0.05 
                                } 
                            } 
                        },colors: ['#01579B','#4CAF50'],
                        grid: { 
                            hoverable: true, 
                            clickable: true, 
                            borderWidth: 0, 
                            color: '#212121' 
                        },
                        tooltip: true,
                        tooltipOpts: { 
                            content: '%s: %p.0%' 
                        }
                    });
                
            },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    })
});

