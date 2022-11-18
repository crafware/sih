$(document).ready(function (){ 
    if($('input[name=AreaAcceso]').val()=='Administrador'){
        $('.Graficas').removeClass('hide');
        $.ajax({
            url: base_url+"Sections/Api/PacientesPorSexo?fi="+FechaActual()+"&ff="+FechaActual(),
            dataType: 'json',
            type: 'GET',
            beforeSend: function (xhr) {
                
            },success: function (data, textStatus, jqXHR) {
                PorGenero({
                    Hombres:data.TOTAL_PACIENTES_HOMBRES,
                    Mujeres:data.TOTAL_PACIENTES_MUJERES
                })
                PorClasificacion({
                    Rojo:data.TOTAL_ROJO,
                    Naranja:data.TOTAL_NARANJA,
                    Amarillo:data.TOTAL_AMARILLO,
                    Verde:data.TOTAL_VERDE,
                    Azul:data.TOTAL_AZUL,
                });
                $('.loading-grafica').addClass('hide');
                $('#GraficaSexo').removeClass('hide');
                $('#GraficaClasificacion').removeClass('hide');
                var TotalGenero=parseInt(data.TOTAL_PACIENTES_HOMBRES)+parseInt(data.TOTAL_PACIENTES_MUJERES);
                $('.TOTAL_GENERO').html('<b>TOTAL:</b> '+TotalGenero+' Hombres/Mujeres');
                var TotalClasificacion=
                        parseInt(data.TOTAL_ROJO)+ 
                        parseInt(data.TOTAL_NARANJA)+ 
                        parseInt(data.TOTAL_AMARILLO) + 
                        parseInt(data.TOTAL_VERDE)+ 
                        parseInt(data.TOTAL_AZUL);
                $('.TOTAL_CLASIFICACION').html('<b>TOTAL:</b> '+TotalClasificacion+' Clasificados');
            },error: function (e) {
                console.log(e);
                MsjError();
            }
        })
    }

    function PorGenero(info){
        var data = {
            labels: ["Hombres: "+info.Hombres, "Mujeres: "+info.Mujeres],
            datasets: [
                {
                    label: "Hombres",
                    backgroundColor: [
                        '#63AF72',
                        '#2196F3'
                    ],
                    borderColor: [
                        '#63AF72',
                        '#2196F3'
                    ],
                    borderWidth: 1,
                    data: [info.Hombres, info.Mujeres]
                }
            ]
        };
        var ctx = document.getElementById("GraficaSexo");
        var myBarChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true
            }
        });
    }
    function PorClasificacion(info){
        var data = {
            labels: ["Rojo: "+info.Rojo, "Naranja: "+info.Naranja,"Amarillo: "+info.Amarillo,"Verde: "+info.Verde,"Azul: "+info.Azul],
            datasets: [
                {
                    label: "Rojo",
                    backgroundColor: [
                        "#F44336",
                        "#FF9800",
                        "#CFBF30",
                        "#63AF72",
                        "#2196F3"
                    ],
                    borderColor: [
                        "#F44336",
                        "#FF9800",
                        "#CFBF30",
                        "#63AF72",
                        "#2196F3"
                    ],
                    borderWidth: 1,
                    data: [info.Rojo, info.Naranja,info.Amarillo,info.Verde,info.Azul]
                }
            ]
        };
        var ctx = document.getElementById("GraficaClasificacion");
        var myBarChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true
            }
        });
    }
    function FechaActual(){        
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
}); 

