$(document).ready(function() {
    $('.yyyy-mm-dd').datepicker({
        format:'yyyy-mm-dd',
        autoclose:true
    });
    var fecha_yyyy_mm_dd=function (){        
        var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth()+1;
        var yyyy = hoy.getFullYear();
        if(dd<10) {
            dd='0'+dd;
        } 
        if(mm<10) {
            mm='0'+mm;
        } 
        return yyyy+'-'+mm+'-'+dd;
    };   
    $('body input[name=FECHA_INICIO]').val(fecha_yyyy_mm_dd());
    $('body input[name=FECHA_FIN]').val(fecha_yyyy_mm_dd());
    Graficar({
        mensaje:'no',
        fi:fecha_yyyy_mm_dd(),
        ff:fecha_yyyy_mm_dd()
    });
    $('.graficar').click(function () {
        Graficar({
            mensaje:'si',
            fi:$('input[name=FECHA_INICIO]').val(),
            ff:$('input[name=FECHA_FIN]').val()
        });
    });
    function Graficar(info){
        $('.fechas').html(info.fi+' '+info.ff);
        $.ajax({
           url:base_url+"Sections/Api/PacientesPorSexo",
            type: 'POST',
            dataType: 'json',
            data:{
                fi:info.fi,
                ff:info.ff
            }, beforeSend: function () {
                if(info.mensaje === 'si'){
                    msj_loading();
                };
            }, success: function (data) {
                graficaHombresMujeres({
                    TOTAL_PACIENTES_HOMBRES:data.TOTAL_PACIENTES_HOMBRES,
                    TOTAL_PACIENTES_MUJERES:data.TOTAL_PACIENTES_MUJERES,
                    TIEMPO_TRANSCURRIDO: data.TIEMPO_TRANSCURRIDO
                });
                graficaPorClasificacion({
                    TOTAL_AZUL:data.TOTAL_AZUL,
                    TOTAL_VERDE:data.TOTAL_VERDE,
                    TOTAL_AMARILLO:data.TOTAL_AMARILLO,
                    TOTAL_NARANJA:data.TOTAL_NARANJA,
                    TOTAL_ROJO:data.TOTAL_ROJO
                });
                bootbox.hideAll();
            }, error: function (e) {
            }
        });
    };
    function graficaHombresMujeres(data){
        $('.grafica1').removeClass('hidden');
        $('#diastranscurridos').html(data.TIEMPO_TRANSCURRIDO.m+' Meses y '+data.TIEMPO_TRANSCURRIDO.d);
        var datos1= {
            type: "pie",
        data: {
            datasets: [{
                data: [
                    data.TOTAL_PACIENTES_HOMBRES,
                    data.TOTAL_PACIENTES_MUJERES
                ], backgroundColor: [
                    "#8EDE70",  //Verde 
                    "#BED7AB"  //Verde Claro
                ]
            }], labels: [
                " "+data.TOTAL_PACIENTES_HOMBRES+" Hombres",
                " "+data.TOTAL_PACIENTES_MUJERES+" Hombres"
            ]
            }, options: {responsive: true}
        };
        $('#datosHombres').html('<strong>'+data.TOTAL_PACIENTES_HOMBRES+'</strong>');
        $('#datosMujeres').html('<strong>'+data.TOTAL_PACIENTES_MUJERES+'</strong>');
        var dato1 = parseInt(data.TOTAL_PACIENTES_HOMBRES);
        var dato2 = parseInt(data.TOTAL_PACIENTES_MUJERES);
        $('#total').html('<strong>'+(dato1 + dato2)+'</strong>');
        $('#contenedorGrafica').html('');
        $('#contenedorGrafica').html('<canvas id="graficaHombreMujeres"> </canvas>');
        var canvas = document.getElementById('graficaHombreMujeres').getContext("2d");
        window.pie = new Chart(canvas, datos1);
   };
   function graficaPorClasificacion(data){
       $('.grafica2').removeClass('hidden');
        var datos1= {
            type: "pie",
        data: {
            datasets: [{
                data: [
                    data.TOTAL_AZUL,
                    data.TOTAL_VERDE,
                    data.TOTAL_AMARILLO,
                    data.TOTAL_NARANJA,
                    data.TOTAL_ROJO
                ], backgroundColor: [
                    "#5393E4",  //Azul
                    "#8EDE70",  //Verde
                    "#FFF82A",  //Amarillo
                    "#FF9C2A",  //Naranja
                    "#E73E42"   //Rojo
                ],hoverBackgroundColor: [
                    "#5393E4",  //Azul
                    "#8EDE70",  //Verde
                    "#FFF82A",  //Amarillo
                    "#FF9C2A",  //Naranja
                    "#E73E42"   //Rojo
                ]
            }], labels: [
                " "+data.TOTAL_AZUL+" %",
                " "+data.TOTAL_VERDE+" %",
                " "+data.TOTAL_AMARILLO+" %",
                " "+data.TOTAL_NARANJA+" %",
                " "+data.TOTAL_ROJO+" %"
            ]
            }, options: {responsive: true }
        };
        $('#contenedorGraficaClasificacion').html('');
        $('#contenedorGraficaClasificacion').html('<canvas id="graficaPorClasificacion"> </canvas>');
        $('#AZUL').html('<strong>'+data.TOTAL_AZUL+'</strong>');
        $('#VERDE').html('<strong>'+data.TOTAL_VERDE+'</strong>');
        $('#AMARILLO').html('<strong>'+data.TOTAL_AMARILLO+'</strong>');
        $('#NARANJA').html('<strong>'+data.TOTAL_NARANJA+'</strong>');
        $('#ROJO').html('<strong>'+data.TOTAL_ROJO+'</strong>');
        var azul = parseInt(data.TOTAL_AZUL);
        var verde = parseInt(data.TOTAL_VERDE);
        var amarillo = parseInt(data.TOTAL_AMARILLO);
        var naranja = parseInt(data.TOTAL_NARANJA);
        var rojo = parseInt(data.TOTAL_ROJO);
        $('#total_c').html('<strong>'+(azul + verde + amarillo + naranja + rojo)+'</strong>');
        var canvas = document.getElementById('graficaPorClasificacion').getContext("2d");
        window.pie = new Chart(canvas, datos1);
    };
    function msj_loading () {
        bootbox.dialog({
            title:'<h5 style="color:white">Espere por favor...</h5>',
            message:'<div class="row">'+
                        '<div class="col-md-12">'+
                            '<center><i class="fa fa-spinner fa-pulse fa-3x"></i></center>'+
                        '<div>'+
                    '</div>',
            size:'small'
        });
    };
});
                
                
                
                
                
                
                
                
                
              