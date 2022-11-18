$(document).ready(function () {
    $('.agregar-horacero-paciente').on('click',function(e){
        e.preventDefault();
        SendAjaxGet("Horacero/GenerarFolio",function (response) {
            if(response.accion=='1'){
                AbrirDocumento(base_url+'Horacero/GenerarTicket/'+response.max_id);
            }
        });
    });
    $('.agregar-horacero-paciente-movil').on('click',function(e){
        e.preventDefault();
        $('.agregar-horacero-paciente-movil').addClass('hide');
        $('.msj-generando-ticket').removeClass('hide');
        SendAjaxGet("Horacero/Movil/GenerarFolio",function (response) {  
            setTimeout(function () {
                $('.msj-generando-ticket').addClass('hide');
                $('.agregar-horacero-paciente-movil').removeClass('hide');
            },1000);
        },'Si');
    });
    $('body').on('click','.select_filter',function (e) {
        
        if($(this).val()=='by_fecha'){
            $('.by_fecha').removeClass('hide');
            $('.by_hora').addClass('hide');
           
        }else if($(this).val()=='by_hora'){
            $('.by_hora').removeClass('hide');
            $('.by_fecha').addClass('hide');
        }else{
            $('.by_fecha').addClass('hide');
            $('.by_hora').addClass('hide');
        }
        $('input[name=filter_select]').val($(this).val());
    });
    $('.by_fecha, .by_hora').submit(function (e) {
        e.preventDefault();
        SendAjaxPost($(this).serialize(),"Horacero/AjaxIndicador",function (response) {
            $('.table-filtros tbody').html(response.tr);
            $('.total_tickets').html('TOTAL DE TICKETS GENERADOS :</b>'+response.total+'</b> Tickets');
            InicializeFootable('.table-filtros');
        });
    })
    if($('input[name=inputAutoPrint]').val()!=undefined){
        setInterval(function () {
            AjaxCheck();
        },5000);
    }
    var total=0;
    function AjaxCheck() {
        SendAjaxGet("Horacero/Movil/AjaxCheck",function (response) {
            if(response.accion=='1'){
                total++;
                $('.total-ingresos').html('<b>TOTAL DE FOLIOS GENERADOS:</b> '+total+' FOLIOS');
                AbrirDocumento(base_url+'Horacero/Movil/GenerarTicket/'+response.max_id);
            }
        })
    }
    if($('input[name=FullScreen]').val()!=undefined){
        $('body,.pantalla-completa').click(function (e) {
            launchFullScreen(document.documentElement);
        });
    }
    /*_*/
    
    function launchFullScreen(element) {
        $('body .accion-windows').addClass('hide');
        if(element.requestFullScreen) {
            element.requestFullScreen();
        } else if(element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if(element.webkitRequestFullScreen) {
            element.webkitRequestFullScreen();
        }
        
    }

});