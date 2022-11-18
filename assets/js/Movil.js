$(document).ready(function () {
  
    $('.agregar-horacero-paciente-movil').on('click',function(e){
        e.preventDefault();
        $('.agregar-horacero-paciente-movil').addClass('hide');
        $('.msj-generando-ticket').removeClass('hide');
        SendAjaxGet("Horacero/Movil/GenerarFolio",function (response) { 
            console.log(response.max_id); 
            
            setTimeout(function () {
                $('.msj-generando-ticket').addClass('hide');
                $('.agregar-horacero-paciente-movil').removeClass('hide');
            },1000);
            printTicket(response.max_id);
        },'No');
        
        
    });
    

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

    function printTicket(folio) {
        // create print data builder object
        var builder = new epson.ePOSBuilder();
        var now = new Date(); 
        //var number=folio;
        var number = ('00000000000' + folio).slice(-11);
        // initialize (ank mode, smoothing)
        builder.addTextLang('es').addTextSmooth(true);
        // draw image (for raster image)
        var canvas = $('#canvas').get(0);
        var context = canvas.getContext('2d');
        context.drawImage($('#logo').get(0), 0, 0, 170, 140);

        // append raster image
        builder.addTextAlign(builder.ALIGN_CENTER);
        builder.addImage(context, 0, 0, 170, 140);
        builder.addFeedLine(1);

        // append ticket number
        builder.addTextAlign(builder.ALIGN_CENTER);
        builder.addTextDouble(false, false).addText('HOSPITAL DE ESPECIALIDADES DEL CMN SXXI');
        builder.addTextDouble(false, false).addText('\n');
        builder.addFeedUnit(16);
        builder.addTextAlign(builder.ALIGN_CENTER);
        builder.addTextSize(3, 2).addText(number);
        builder.addTextSize(1, 1).addText('\n');
        builder.addFeedUnit(16);
        
        // append message
        builder.addTextStyle(false, false, true);
        builder.addText('Por favor espere hasta que su folio\n');
        builder.addText('sea llamado.\n');
        builder.addTextStyle(false, false, false);
        builder.addFeedUnit(16);

        // append date and time
        var options = { year: 'numeric', month: 'long', day: 'numeric' };
        //builder.addText(now.toDateString() + '\n');
        builder.addText(now.toLocaleDateString("es-Es", options) + '\n');
        builder.addFeedUnit(16);

        // append barcode
        builder.addBarcode(number, builder.BARCODE_CODE39, builder.HRI_BELOW, builder.FONT_A, 2, 100);
        builder.addFeedLine(1);

        // append paper cutting
        builder.addCut();
        //
        // send print data
        //

        // create print object
        var url = 'http://' + ipaddr + '/cgi-bin/epos/service.cgi?devid=' + devid + '&timeout=' + timeout;
        var epos = new epson.ePOSPrint(url);
        // send
        epos.send(builder.toString());
       

    }
    var SendAjaxGet=function (Url,Response,Loading="Si",Size) {
        $.ajax({
            url: base_url+Url,
            dataType: 'json',
            beforeSend: function (xhr) {
                if(Loading=='Si'){
                    MsjLoading(Size);
                }  
            },success: function (result, textStatus, jqXHR) {
                bootbox.hideAll();
                Response(result);
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e);
            }
            
        });
    };
    var MsjLoading=function (size='Si'){
       bootbox.dialog({
            title: '<h6>&nbsp;&nbsp;&nbsp;Espere por favor...</h6>',
            message:'<div class="row ">'+
                        '<div class="col-sm-12">'+
                            '<h6 class="text-center" style="line-height:2"><i class="fa fa-spinner fa-pulse fa-5x"></i></h6>'+
                        '</div>'+
                    '</div>',
            //size:'medium',//small, medium, large
            closeButton:false,
            onEscape : function() {}
        });
        var y = window.top.outerHeight / 4 ;
        if(size=='Si'){
            $('.modal-dialog').css({
                'margin-top':y+'px',
                'width':'400px'
            })
        }else{
            $('.modal-dialog').css({
                'margin-top':y+'px',
            })
        }
    
    };
});