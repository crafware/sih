$(document).ready(function (e){
    setTimeout(function() {
        $('.row-loading').addClass('hide');
        $('.row-load').removeClass('hide');
    },1000)
    setInterval(function (e){
        AjaxInterconsultas();
    },60000);
    AjaxInterconsultas();
    setInterval(function () {
        $('.fecha-actual').html('<b>FECHA Y HORA: </b>'+fecha_dd_mm_yyyy()+' '+ObtenerHoraActual())
    },1000);
    function AjaxInterconsultas(area) {
        Pace.ignore(function () {
            $.ajax({
                url: base_url+"Sections/Listas/AjaxInterconsultas",
                type: 'POST',
                data:{
                   area: area ,
                   csrf_token:csrf_token
                },dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $('.ultima-actualizacion').html('<b>ÚLTIMA ACTUALIZACIÓN: </b>'+ObtenerHoraActual());
                    console.log(data.col_md_3);
                    $('.cols-interconsultas').html(data.col_md_3);
                    if(data.page_reload=='1'){
                        msj_error_noti('ACTUALIZACIÓN POR CAMBIOS');
                        setTimeout(function () {
                            location.reload();
                        },2000)

                    }
                },error: function (e) {
                    console.log('ERROR AL PROCESAR LA PETICIÓN AL SERVIDOR..'+e.responseText)
                }
            })
        })
    }
});