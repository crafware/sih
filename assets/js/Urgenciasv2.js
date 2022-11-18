$(document).ready(function () {
    $('body').on('click','.btn-indicador',function (e) {
        var productividad_turno=$('select[name=productividad_turno]').val();
        var productividad_fecha=$('input[name=productividad_fecha]').val();
        var productividad_tipo=$('input[name=productividad_tipo]').val();
        var fechaInicial = $('input[name=fechaInicio]').val();
        var fechaFinal = $('input[name=fechaFinal]').val();
        e.preventDefault();
        $.ajax({
            url: base_url+"Urgencias/Graficas/AjaxIndicador",
            type: 'POST',
            dataType: 'json',
            data:{
                productividad_turno:productividad_turno,
                productividad_fecha:productividad_fecha,
                productividad_tipo:productividad_tipo,
                fechaInicial:fechaInicial,
                fechaFinal:fechaFinal,
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(productividad_tipo=='Triage'){
                    $('.indicador-triage-horacero')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Hora Cero&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.TRIAGE_HORACERO+' Pacientes');
                    $('.indicador-triage-enfermeria')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Triage Enfermería&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.TRIAGE_ENFERMERIA+' Pacientes');
                    $('.indicador-triage-medico')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Triage Médico&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.TRIAGE_MEDICO+' Pacientes');
                    $('.indicador-triage-am')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Asistente Médica&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.TRIAGE_AM+' Pacientes');
                    $('.col-ChartTriage').removeClass('hide');
                    ChartTriage({
                        HoraCero:data.TRIAGE_HORACERO,
                        Enfermeria:data.TRIAGE_ENFERMERIA,
                        Medico:data.TRIAGE_MEDICO,
                        Asistentes:data.TRIAGE_AM
                    })
                    
                }if(productividad_tipo=='Consultorios'){
                    $('.indicador-consultorios-f1')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Filtro 1&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_F1+' Pacientes');
                    $('.indicador-consultorios-f2')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Filtro 2&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_F2+' Pacientes');
                    $('.indicador-consultorios-f3')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Filtro 3&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_F3+' Pacientes');
                    $('.indicador-consultorios-f4')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Filtro 4&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_F4+' Pacientes');
                    $('.indicador-consultorios-f5')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Filtro 5&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_F5+' Pacientes');
                    $('.indicador-consultorios-f6')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Filtro 6&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_F6+' Pacientes');
                    $('.indicador-consultorios-f7')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Filtro 7&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_F7+' Pacientes');
                    $('.indicador-consultorios-f8')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Filtro 8&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_F8+' Pacientes');
                    $('.indicador-consultorios-f9')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Filtro 9&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_F9+' Pacientes');
                    $('.indicador-consultorios-f10')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Filtro 10&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_F10+' Pacientes');
                    $('.indicador-consultorios-n')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Neurocirugía&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_N+' Pacientes');
                    $('.indicador-consultorios-cg')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Cirugía General&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_CG+' Pacientes');
                    $('.indicador-consultorios-m')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Maxilofacial&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_M+' Pacientes');
                    $('.indicador-consultorios-cm')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Cirugía Maxilofacial&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_CM+' Pacientes');
                    $('.indicador-consultorios-cpr')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Consultorio Cpr&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.CONSULTORIO_CPR+' Pacientes');
                    $('.col-ChartConsultorios').removeClass('hide');
                    ChartConsultorios({
                        CONSULTORIO_F1:data.CONSULTORIO_F1,
                        CONSULTORIO_F2:data.CONSULTORIO_F2,
                        CONSULTORIO_F3:data.CONSULTORIO_F3,
                        CONSULTORIO_F4:data.CONSULTORIO_F4,
                        CONSULTORIO_F5:data.CONSULTORIO_F5,
                        CONSULTORIO_F6:data.CONSULTORIO_F6,
                        CONSULTORIO_F7:data.CONSULTORIO_F7,
                        CONSULTORIO_F8:data.CONSULTORIO_F8,
                        CONSULTORIO_F9:data.CONSULTORIO_F9,
                        CONSULTORIO_F10:data.CONSULTORIO_F10,
                        CONSULTORIO_N:data.CONSULTORIO_N,
                        CONSULTORIO_CG:data.CONSULTORIO_CG,
                        CONSULTORIO_M:data.CONSULTORIO_M,
                        CONSULTORIO_CM:data.CONSULTORIO_CM,
                        CONSULTORIO_CPR:data.CONSULTORIO_CPR,
                    })
                }if(productividad_tipo=='Observacion'){
                    $('.col-ChartObservacion').removeClass('hide');
                     $('.indicador-observacion-enfermeria')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Ingreso Enfermería Observación&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.OBSERVACION_ENFERMERIA+' Pacientes');
                     $('.indicador-observacion-medico')
                        .attr('href',base_url+'Urgencias/Graficas/IndicadorUsuarios/'+productividad_tipo+'/?section=Médico Observación&turno='+productividad_turno+'&fecha='+productividad_fecha)
                        .attr('target','_blank')
                        .find('h4').html(data.OBSERVACION_MEDICO+' Pacientes');
                    ChartObservacion({
                        Enfermeria:data.OBSERVACION_ENFERMERIA,
                        Medico:data.OBSERVACION_MEDICO
                    })
                }
            },error: function (jqXHR, textStatus, errorThrown) {
                msj_error_serve();
                bootbox.hideAll();
                console.log(jqXHR)
            }
        })
    })
    function ChartTriage(info) {
        var data = {
            labels: ["Hora Cero ("+info.HoraCero+")", "Enfermería Triage ("+info.Enfermeria+")", "Médico Triage ("+info.Medico+")", "Asistentes Médicas ("+info.Asistentes+")"],
            datasets: [
                {
                    label: "Hora Cero",
                    backgroundColor: [
                        'rgba(37, 102, 89, 1)',
                        'rgba(37, 102, 89, 1)',
                        'rgba(37, 102, 89, 1)',
                        'rgba(37, 102, 89, 1)'
                    ],
                    borderColor: [
                        'rgba(37, 102, 89, 1)',
                        'rgba(37, 102, 89, 1)',
                        'rgba(37, 102, 89, 1)',
                        'rgba(37, 102, 89, 1)'
                    ],
                    borderWidth: 1,
                    data: [info.HoraCero, info.Enfermeria, info.Medico, info.Asistentes]
                }
            ]
        };
        var ctx = document.getElementById("ChartTriage");
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
    function ChartConsultorios(info) {
        var data = {
            labels: [
                "Filtro 1",
                "Filtro 2",
                "Filtro 3",
                "Filtro 4",
                "Filtro 5",
                "Filtro 6",
                "Filtro 7",
                "Filtro 8",
                "Filtro 9",
                "Filtro 10",
                "Neurocirugía",
                "Cirugía General",
                "Maxilofacial",
                "Cirugía Maxilofacial",
                "Cpr"
            ],
            datasets: [
                {
                    label:'Filtro 1',
                    backgroundColor: [
                        'rgba(244, 67, 54, 1)',
                        'rgba(233, 30, 99, 1)',
                        'rgba(156, 39, 176, 1)',
                        'rgba(156, 39, 176, 1)',
                        'rgba(63, 81, 181, 1)',
                        'rgba(33, 150, 243, 1)',
                        'rgba(3, 169, 244, 1)',
                        'rgba(0, 150, 136, 1)',
                        'rgba(76, 175, 80, 1)',
                        'rgba(139, 195, 74, 1)',
                        'rgba(205, 220, 57, 1)',
                        'rgba(0, 191, 165, 1)',
                        'rgba(255, 152, 0, 1)',
                        'rgba(255, 87, 61, 1)',
                        'rgba(121, 85, 72, 1)'
                    ],
                    borderColor: [
                        'rgba(244, 67, 54, 1)',
                        'rgba(233, 30, 99, 1)',
                        'rgba(156, 39, 176, 1)',
                        'rgba(156, 39, 176, 1)',
                        'rgba(63, 81, 181, 1)',
                        'rgba(33, 150, 243, 1)',
                        'rgba(3, 169, 244, 1)',
                        'rgba(0, 150, 136, 1)',
                        'rgba(76, 175, 80, 1)',
                        'rgba(139, 195, 74, 1)',
                        'rgba(205, 220, 57, 1)',
                        'rgba(0, 191, 165, 1)',
                        'rgba(255, 152, 0, 1)',
                        'rgba(255, 87, 61, 1)',
                        'rgba(121, 85, 72, 1)'
                    ],
                    borderWidth: 1,
                    data: [
                        info.CONSULTORIO_F1, 
                        info.CONSULTORIO_F2, 
                        info.CONSULTORIO_F3, 
                        info.CONSULTORIO_F4,
                        info.CONSULTORIO_F5,
                        info.CONSULTORIO_F6,
                        info.CONSULTORIO_F7,
                        info.CONSULTORIO_F8,
                        info.CONSULTORIO_F9,
                        info.CONSULTORIO_F10,
                        info.CONSULTORIO_N,
                        info.CONSULTORIO_CG,
                        info.CONSULTORIO_M,
                        info.CONSULTORIO_CM,
                        info.CONSULTORIO_CPR
                    ]
                }
            ]
        };
        var ctx = document.getElementById("ChartConsultorios");
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
    function ChartObservacion(info) {
        var data = {
            labels: ["Enfermería Observación ("+info.Enfermeria+")", "Médico Observacion ("+info.Medico+")"],
            datasets: [
                {
                    label: "Enfermería Observación",
                    backgroundColor: [
                        'rgba(229,9,20,1)',
                        'rgba(255, 112, 40, 1)',
                    ],
                    borderColor: [
                        'rgba(229,9,20,1)',
                        'rgba(255, 112, 40, 1)',
                    ],
                    borderWidth: 1,
                    data: [info.Enfermeria, info.Medico]
                }
            ]
        };
        var ctx = document.getElementById("ChartObservacion");
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
    /* Funcion para selcccionar el filtro de fechas a buscar */
    $(function() {

        var start = moment().locale('es').subtract(29, 'days');
        var end = moment().locale('es');

        function cb(start, end) {
            //$('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#daterange span').html(start.format('D MMM, YYYY') + ' - ' + end.format('D MMM, YYYY'));
        }

        $('#daterange').daterangepicker({
            showDropdowns: true,
            minYear: 2017,
            maxYear: 2025,
            startDate: start,
            endDate: end,
            
            locale: {
                'format': 'DD/MM/YYYY',
                'applyLabel': 'Aplicar',
                'cancelLabel': 'Cancelar',
                'customRangeLabel': 'Rango',
                'daysOfWeek': [ 'Do','Lu', 'Ma','Mi','Ju','Vi','Sa'],
                'monthNames': ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre','Diciembre'],
            },
            ranges: {
               'Hoy': [moment(), moment()],
               'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
               'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
               'Mes actual': [moment().startOf('month'), moment().endOf('month')],
               'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
             $('input[name=fechaInicio]').val(picker.startDate.format('YYYY-MM-DD'));
             $('input[name=fechaFin]').val(picker.endDate.format('YYYY-MM-DD'));
        });

    });
})