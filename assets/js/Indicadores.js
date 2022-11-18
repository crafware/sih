$(document).ready(function () {
  
    $('#fechaProductividad').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        placement: 'bottom'
    });
     
    $('.btn-indicador-ce-obs').click(function () {
        if($("select[name=Turno]").val() == null) {
            $("#select_error").removeClass('hidden'); // show Warning       
        }else
        {
            $("#select_error").addClass('hidden');
        }
        
        $.ajax({
            url: base_url+"Observacion/AjaxIndicadores",
            type: 'POST',
            dataType: 'json',
            data: {
                selectTurno: $('select[name=Turno]').val(),
                inputFechaInicio:$('input[name=inputFechaInicio]').val(),
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                console.log(data)
                bootbox.hideAll();
                $('.TOTAL_PACIENTES_CONSULTORIOS_OBS').find('span').html(data.TOTAL_DOCS+' PACIENTES');
                $('.GENERAR_LECHUGA_CONSULTORIOS_OBS')
                        .attr({'data-inputfecha': $('input[name=inputFechaInicio]').val(), 'data-turno':$('select[name=Turno]').val()}).removeClass('hide');
                
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e)
            }      
        })
    });
    $('.GENERAR_LECHUGA_CONSULTORIOS_OBS').click(function (e) {
        AbrirDocumento(base_url+'Inicio/Documentos/LechugaConsultorios?inputFechaInicio='+$(this).attr('data-inputfecha')+'&turno='+$(this).attr('data-turno'),'_blank');
    });

    /* Indicadores de Hospitalización */

    $('body').on('click','.btn-buscarIndicador',function (e) {
        //var turno=$('select[name=productividad_turno]').val();
        var fechaInicial=$('input[name=fechaInicial]').val();
        var fechaFinal=$('input[name=fechaFinal]').val();
        var indicador_tipo=$('input[name=indicador_tipo]').val();
        
        e.preventDefault();
        $.ajax({
            url: base_url+"Hospitalizacion/indicadores/AjaxIndicador",
            type: 'POST',
            dataType: 'json',
            data:{                
                    indicador_tipo:indicador_tipo,
                    fechaInicial:fechaInicial,
                    fechaFinal:fechaFinal,
                    csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(indicador_tipo=='interconsultas'){
                    $('.interconsultas-solicitadas')
                        .find('h4').html(data.INTERCONSULTAS_SOLICITADAS+' Interconsultas');
                        
                    $('.interconsultas-atendidas')
                        .find('h4').html(data.INTERCONSULTAS_ATENDIDAS+' Interconsultas');
                        
                        //.attr('target','_blank')
                    // $('.col-ChartInterconsultas').removeClass('hide');
                    // ChartInterconsultas({
                    //     Admision Continua:data.TRIAGE_HORACERO,
                    //     Alergia e Inmunología:data.TRIAGE_ENFERMERIA,
                    //     Angiología:data.TRIAGE_MEDICO,
                    //     Cardiología:data.TRIAGE_AM
                    // })
                    $('body').on('click','.interconsultas-atendidas',function (e) {
                        $('.col-ChartInterconsultas').removeClass('hide');
                        ChartInterconsultas({
                            AC:data.INTERCONSULTAS_AC,
                            Alergia:data.INTERCONSULTAS_ALERGIA,
                            Angiologia:data.INTERCONSULTAS_ANGIOLOGIA,
                            Audiologia:data.INTERCONSULTAS_AUDIOLOGIA,
                            CirgMax:data.INTERCONSULTAS_CIRMAX,
                            Derma:data.INTERCONSULTAS_DERMA,
                            Endocrino:data.INTERCONSULTAS_ENDOCRINO,
                            CCC:data.INTERCONSULTAS_CCC,
                            CCR:data.INTERCONSULTAS_CCR,
                            Gastro:data.INTERCONSULTAS_GASTRO,
                            GC:data.INTERCONSULTAS_GC,
                            Hematologia:data.INTERCONSULTAS_HEMATOLOGIA,
                            Infectologia:data.INTERCONSULTAS_INFECTOLOGIA,
                            MedicinaInterna:data.INTERCONSULTAS_MEDICINA_INTERNA,
                            Nefrologia:data.INTERCONSULTAS_NEFROLOGIA,
                            Neurocirugia:data.INTERCONSULTAS_NEUROCIRUGIA,
                            Neurologia:data.INTERCONSULTAS_NEUROLOGIA,
                            Reumatologia:data.INTERCONSULTAS_REUMATOLOGIA,
                            UCI:data.INTERCONSULTAS_UCI,
                            Urologia:data.INTERCONSULTAS_UROLOGIA,
                            UTR:data.INTERCONSULTAS_UTR,

                            REALIZADAS_AC:data.REALIZADAS_AC,
                            REALIZADAS_Alergia:data.REALIZADAS_ALERGIA,
                            REALIZADAS_Angiologia:data.REALIZADAS_ANGIOLOGIA,
                            REALIZADAS_Audiologia:data.REALIZADAS_AUDIOLOGIA,
                            REALIZADAS_CirgMax:data.INTERCONSULTAS_CIRMAX,
                            REALIZADAS_Derma:data.INTERCONSULTAS_DERMA,
                            REALIZADAS_Endocrino:data.INTERCONSULTAS_ENDOCRINO,
                            REALIZADAS_CCC:data.REALIZADAS_CCC,
                            REALIZADAS_CCR:data.REALIZADAS_CCR,
                            REALIZADAS_Gastro:data.INTERCONSULTAS_GASTRO,
                            REALIZADAS_GC:data.REALIZADAS_GC,
                            REALIZADAS_Hematologia:data.REALIZADAS_HEMATOLOGIA,
                            REALIZADAS_Infectologia:data.REALIZADAS_INFECTOLOGIA,
                            REALIZADAS_MedicinaInterna:data.REALIZADAS_MEDICINA_INTERNA,
                            REALIZADAS_Nefrologia:data.REALIZADAS_NEFROLOGIA,
                            REALIZADAS_Neurocirugia:data.REALIZADAS_NEUROCIRUGIA,
                            REALIZADAS_Neurologia:data.REALIZADAS_NEUROLOGIA,
                            REALIZADAS_Reumatologia:data.REALIZADAS_REUMATOLOGIA,
                            REALIZADAS_UCI:data.REALIZADAS_UCI,
                            REALIZADAS_Urologia:data.REALIZADAS_UROLOGIA,
                            REALIZADAS_UTR:data.REALIZADAS_UTR
                        })
                    })
                    
                }
            },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve();
                bootbox.hideAll();
                console.log(jqXHR)
            }
        })    
    })
    function ChartInterconsultas(info) {
        var data = {
            labels: [   "AC ("+info.AC+"/"+info.REALIZADAS_AC+")", 
                        "Alergía ("+info.Alergia+"/"+info.REALIZADAS_Alergia+")", 
                        "Angiología ("+info.Angiologia+"/"+info.REALIZADAS_Angiologia+")",
                        "Audiologia ("+info.Audiologia+"/"+info.REALIZADAS_Audiologia+")",
                        "Cirg. Max. ("+info.CirgMax+"/"+info.REALIZADAS_CirgMax+")",
                        "Derma. ("+info.Derma+"/"+info.REALIZADAS_Derma+")", 
                        "Endocrino ("+info.Endocrino+"/"+info.REALIZADAS_Endocrino+")",
                        "C. Cabeza C. ("+info.CCC+"/"+info.REALIZADAS_CCC+")", 
                        "C. Colon R. ("+info.CCR+"/"+info.REALIZADAS_CCR+")", 
                        "Gastroenterologia ("+info.Gastro+"/"+info.REALIZADAS_Gastro+")",
                        "Gastro C. ("+info.GC+"/"+info.REALIZADAS_GC+")", 
                        "Hematología ("+info.Hematologia+"/"+info.REALIZADAS_Hematologia+")",
                        "Infectología ("+info.Infectologia+"/"+info.REALIZADAS_Infectologia+")",
                        "Medicina Interna ("+info.MedicinaInterna+"/"+info.REALIZADAS_MedicinaInterna+")",
                        "Nefrologia ("+info.Nefrologia+"/"+info.REALIZADAS_Nefrologia+")",
                        "Neurocirugía ("+info.Neurocirugia+"/"+info.REALIZADAS_Neurocirugia+")",
                        "Neurología ("+info.Neurologia+"/"+info.REALIZADAS_Neurologia+")",
                        "Reumatología ("+info.Reumatologia+"/"+info.REALIZADAS_Reumatologia+")",
                        "UCI ("+info.UCI+"/"+info.REALIZADAS_UCI+")",
                        "Urología ("+info.Urologia+"/"+info.REALIZADAS_Urologia+")",
                        "UTR ("+info.UTR+"/"+info.REALIZADAS_UTR+")"

                    ],
            datasets: [
                {
                    label: "interconsultas",
                    backgroundColor: [
                        'rgba(37, 102, 89, 1)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(80, 50, 89, 1)',
                        'rgba(122, 66, 89, 1)',
                        'rgba(166, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(90, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: [
                        'rgba(37, 102, 89, 1)',
                        'rgba(37, 102, 89, 1)',
                        'rgba(37, 102, 89, 1)',
                        'rgba(37, 102, 89, 1)'
                    ],
                    borderWidth: 1,
                    data: [ info.AC, 
                            info.Alergia, 
                            info.Angiologia, 
                            info.Audiologia,
                            info.CirgMax,    
                            info.Derma,
                            info.Endocrino,
                            info.CCC, 
                            info.CCR, 
                            info.Gastro,
                            info.GC, 
                            info.Hematologia,
                            info.Infectologia,
                            info.NedicinaInterna,
                            info.Nefrologia,
                            info.Neurocirugia,
                            info.Neurologia,
                            info.Reumatologia,
                            info.UCI,
                            info.Urologia,
                            info.UTR
                          ]
                }
            ]
        };
        var ctx = document.getElementById("ChartInterconsultas");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        });
    }
})