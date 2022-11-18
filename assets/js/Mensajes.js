jQuery('body input[type=text],input[type=text] .md-input').keypress(function(tecla) {
    if(tecla.charCode == 60 || tecla.charCode == 62){
        msj_error_noti('CARACTER NO PERMITIDO');
        return false;
    } 
});
jQuery('body .md-input, input.form-control').keypress(function(tecla) {
    if(tecla.charCode == 60 || tecla.charCode == 62){
        msj_error_noti('CARACTER NO PERMITIDO');
        return false;
    } 
});
jQuery('body textarea').keypress(function(tecla) {
    if(tecla.charCode == 60 || tecla.charCode == 62) {
        msj_error_noti('CARACTER NO PERMITIDO');
        return false;
    }
});
var ObtenerColorClasificacion=function (Color) {
    if(Color=='Rojo'){
        return 'red';
    }if(Color=='Naranja'){
        return 'orange';
    }if(Color=='Amarillo'){
        return 'yellow-A700';
    }if(Color=='Verde'){
        return 'green';
    }if(Color=='Azul'){
        return 'indigo';
    }
}
var msj_loading=function (msj,accion='Si'){
   bootbox.dialog({
        title: '<h6>&nbsp;&nbsp;&nbsp;Espere por favor...</h6>',
        message:'<div class="row ">'+
                    '<div class="col-sm-12">'+
                        '<h6 class="text-center" style="line-height:2"><i class="fa fa-spinner fa-pulse fa-5x"></i></h6>'+
                        '<h6 class="text-center" style="line-height:2">'+(msj==undefined ? '': msj)+'</h6>'+
                    '</div>'+
                '</div>'
        ,onEscape : function() {}
    });
    if(accion=='Si'){
        $('.modal-dialog').css({
            'margin-top':'130px',
            'width':'30%'
        })
    }else{
        var y = window.top.outerHeight / 4 ;
        $('.modal-dialog').css({
            'margin-top':y+'px',
        })
    }
};
var MsjError=function (){
   bootbox.dialog({
        title: '<h5>ERROR AL PROCESAR LA PETICIÓN</h5>',
        message:'<div class="row ">'+
                    '<div class="col-sm-12" style=";margin-top:-30px">'+
                        '<h6 class="text-center" style="line-height:2;font-size:50px;color:#F44336"><i class="fa fa-frown-o "></i>  Oops!</h6>'+
                        '<h6 class="text-center" style="line-height:1.4;margin-top:0px;color:#F44336">LO SENTIMOS A OCURRIDO UN ERROR AL PROCESAR LA PETICIÓN. VUELVA A INTENTARLO</h6>'+
                    '</div>'+
                '</div>'
        ,onEscape : function() {}
    });
    $('.modal-dialog').css({
        'margin-top':'130px',
        'width':'30%'
    })
};
var MsjNotificacion=function (title,msj){
   bootbox.dialog({
        title: '<h6>'+title+'</h6>',
        message:'<div class="row " style="margin-top:-20px">'+
                    '<div class="col-sm-12">'+
                        '<h6 style="line-height:2">'+ msj+'</h6>'+
                    '</div>'+
                '</div>'
        ,size:'small'
        ,onEscape : function() {},
        buttons:{
            Cerrar:{
                label:'Cerrar',
                className:'back-imss',
                callback:function (e) {}
            }
        }
    });
    $('.modal-dialog').css({
        'margin-top':'130px',
        'width':'40%'
    })
};
$('body').on('click','.ver-texto',function () {
    MsjNotificacion('<h5>'+$(this).attr('data-content-title')+'</h5>','<h5 style="line-height:1.6">'+$(this).attr('data-content-text')+'</h5>')
});

var AbrirDocumento=function(url){
    coordx= screen.width ? (screen.width-200)/2 : 0; 
    coordy= screen.height ? (screen.height-150)/2 : 0; 
    window.open(url,'Documento','width=800,height=600,top=30,right='+coordx+',left='+coordy);
}
var AbrirVista=function(url,width=800,height=600){
    var y = window.top.outerHeight / 2 + window.top.screenY - ( height / 1.5);
    var x = window.top.outerWidth / 2 + window.top.screenX - ( width / 2)
    window.open(url,'Documento','width='+width+',height='+height+',top='+y+',left='+x);
}
var AbrirDocumentoMultiple=function(url,nombre,left){
    coordx= screen.width ? (screen.width-200)/2 : 0; 
    coordy= screen.height ? (screen.height-150)/2 : 0; 
    window.open(url,nombre,'width=800,height=600,top=30,right='+coordx+',left='+(left==undefined ? coordy : left));
}
var msj_error_noti=function (msj){
    Messenger().post({
        message: msj,
        type: 'error',
        showCloseButton: true
    }); 
}
var msj_error_serve=function (error){
    Messenger().post({
        message: 'Error al procesar la petición al servidor ',
        type: 'error',
        showCloseButton: true
    }); 
    (error==undefined ? '' :  console.log(error))
}
var  msj_success_noti=function (msj){
    Messenger().post({
        message: msj,
        showCloseButton: true
    }); 
}
var BuscarCodigoPostal=function(input) {
    $.ajax({
            url: base_url+"Asistentesmedicas/BuscarCodigoPostal",
            type: 'POST',
            dataType: 'json',
            data:{
                'cp':input.cp,
                'csrf_token':csrf_token
            },success: function (data, textStatus, jqXHR) {
                $('input[name='+input.input1+']').val(data.result_cp.Municipio);
                $('input[name='+input.input2+']').val(data.result_cp.Estado);
                if(data.result_cp.Colonia.length>0){
                    var Colonia=data.result_cp.Colonia.split(';');
                    $('input[name='+input.input3+']').shieldAutoComplete({
                        dataSource: {
                            data: Colonia
                        },minLength: 1
                    });
                    $('input[name='+input.input3+']').removeClass('sui-input');
                }
            },error: function (e) {
                console.log(e);
            }
        })
}
var get_fecha=function (){
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"); 
    var f=new Date(); 
    return diasSemana[f.getDay()] + " " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
}
var fecha_yyyy_mm_dd=function (){        
    var hoy = new Date();
    var dd = hoy.getDate();
    var mm = hoy.getMonth()+1; //hoy es 0!
    var yyyy = hoy.getFullYear();
    if(dd<10) {
        dd='0'+dd;
    } 
    if(mm<10) {
        mm='0'+mm;
    } 
    return yyyy+'/'+mm+'/'+dd;
}    
var fecha_dd_mm_yyyy=function (){
    var hoy = new Date();
    var dd = hoy.getDate();
    var mm = hoy.getMonth()+1; //hoy es 0!
    var yyyy = hoy.getFullYear();
    if(dd<10) {
        dd='0'+dd;
    } 
    if(mm<10) {
        mm='0'+mm;
    } 
    return dd+'/'+mm+'/'+yyyy;
}
var hora_actual=function (e){
    var seconds = new Date().getSeconds();
    var minutes = new Date().getMinutes();
    var hours = new Date().getHours();
    return  (hours < 10 ? "0" : "") + hours  +':'+ (minutes < 10 ? "0" : "") + minutes;
}
var ObtenerHoraActual=function (e){
    var seconds = new Date().getSeconds();
    var minutes = new Date().getMinutes();
    var hours = new Date().getHours();
    return  (hours < 10 ? "0" : "") + hours  +':'+ (minutes < 10 ? "0" : "") + minutes +':'+ (seconds < 10 ? "0" : "") + seconds;
}
$('body .tag-hora').val(hora_actual());
$(".tag-tension-arterial").mask("999/99");
$('.auto').autoNumeric('init');
$('body .tag-fecha').val(fecha_dd_mm_yyyy())
$('.input-fecha-actual').val(get_fecha())
$('.tagsinput').tagsinput();
$('.tip').tooltip();
$('.bootstrap-tagsinput').css('width','100%');
var InicializeFootable=function (table) {
    $('body '+table).footable()
                    .trigger('footable_redraw')
                    .trigger('footable_resize');
}
$('.footable').footable();
var ActionCloseWindows=function () {
    setTimeout(function () {
        window.top.close();
    },1000);
}
var ActionCloseWindowsReload=function () {
    setTimeout(function () {
        window.opener.location.reload();
        window.top.close();
    },1000)
}

var ActionWindowsReload=function () {
    setTimeout(function () {
        location.reload();
    },1000)
}
$('body #example_length ,.DTTT ').addClass('hidden');  
$('#retrievingfilename').html5imageupload({
    onAfterProcessImage: function() {
            $('#filename').val($(this.element).data('name'));
            $('#check-img').val('Nueva');
    },
    onAfterCancel: function() {
            $('#filename').val('');
    }
});
$('.fecha-calendar,.fecha_calendar').datepicker({
    autoclose: true,
    format: 'yyyy/mm/dd',
    todayHighlight: true
});
$('.dd-mm-yyyy').datepicker({
    autoclose: true,
    format: 'dd/mm/yyyy',
    todayHighlight: true
});
$('.dp-yyyy-mm-dd').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    todayHighlight: true
});
$('.d-m-y').datepicker({
    autoclose: true,
    format: 'dd/mm/yyyy'
});
$('.clockpicker').clockpicker({
    placement: 'top',
    autoclose: true
});
$('.clockpicker-bottom').clockpicker({
    placement: 'bottom',
    autoclose: true
});
$('#save').html5imageupload({
    onSave: function(data) {
            console.log(data);
    }

});
$('.upload-archivo').fileinput({
        language: 'es'
});
$('body .fileinput-upload').hide();

$('body .fecha').html(fechaActual());
function fechaActual(){
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"); 
    var f=new Date(); 
    return diasSemana[f.getDay()] + " " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
}
setInterval(function() {
    var seconds = new Date().getSeconds();
    $('.segundo').html((seconds < 10 ? "0" : "") + seconds);
}, 1000);
setInterval(function() {
    var minutes = new Date().getMinutes();
    $('.minuto').html((minutes < 10 ? "0" : "") + minutes);
}, 1000);
setInterval(function() {
    var hours = new Date().getHours();
    $('.hora').html((hours < 10 ? "0" : "") + hours);
}, 1000);
var ExperiredSession=function() {

}
var ActualizarPorCambio=function() {

} 
$('body .tip').tooltip();
var CerrarSesion=function() {
    $.ajax({
        url: base_url+"Sections/Usuarios/AjaxCheckSesion",
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            if(data.accion=='2'){
                window.location.href=base_url+'Config/CerrarSesion';
            }if(data.accion=='3'){
                window.location.href=base_url;
            }if(data.accion=='4'){
                msj_success_noti('POR FAVOR ACTUALIZE LA PÁGINA PARA APLICAR CAMBIOS REQUERIDOS, O HAGA CLICK AQUI PARA ACTUALIZARLO <br><center><a href="#" onclick="location.reload()"><i class="fa fa-refresh fa-2x"></i></center></a>')


            }
        },error: function (e) {
            console.log(e);
        }
    });
}
var Empleado=Array();
var AjaxBuscarEmpleado=function (result,Matricula) {
    $.ajax({
        url: base_url+"Sections/Usuarios/AjaxBuscarEmpleado",
        dataType: 'json',
        type: 'POST',
        data:{
            empleado_matricula:Matricula,
            csrf_token:csrf_token
        },success: function (data, textStatus, jqXHR) {
            if(data.accion=='1'){
                result(data);
            }if(data.accion=='2'){
                result(data);
                msj_error_noti('LA MATRICULA NO EXISTE');
            }
        },error: function (e) {
            console.log(e);
        }
        
    });
    //return data;
}
var SendAjax=function (data,url,response,LoadingMsj='',Loading="Si") {
    $.ajax({
        url: base_url+url,
        dataType: 'json',
        type: 'POST',
        data:data,
        beforeSend: function (xhr) {
            msj_loading(LoadingMsj,Loading);
        },success: function (result, textStatus, jqXHR) {
            bootbox.hideAll();
            response(result);
        },error: function (e) {
            bootbox.hideAll();
            MsjError();
            console.log(e);
        }
        
    });
}
var ViewImage=function (src,size) {
    bootbox.dialog({
        title: '<h6>VER IMAGEN</h6>',
        message:'<div class="row ">'+
                    '<div class="col-sm-12" style="padding: 0px;margin-top: -16px;margin-bottom: -15px;">'+
                        '<img src="'+src+'" style="width:100%;">'+
                    '</div>'+
                '</div>',
        size:size,//'small',//small, medium, large
        closeButton:true,
        onEscape : function() {}
    });
}
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
var SendAjaxPost=function (Data,Url,Response,Loading="Si",Size) {
    $.ajax({
        url: base_url+Url,
        dataType: 'json',
        type: 'POST',
        data:Data,
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
}
var Total_Msj=0;
var ObtenerNotificaciones=function () {
    $.ajax({
        url: base_url+"Sections/Notificaciones/AjaxObtenerNotificaciones",
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            Total_Msj=data.TOTAL_MSJ;
            if(Total_Msj>0){
                $('.notificaciones-total').html(Total_Msj);
                $('.notificaciones-total-list').removeClass('hide');
            }else{
                $('.notificaciones-total-list').addClass('hide');
            }
        },error: function (e) {
            console.log('ERROR AL OBTENER NOTIFICACIONES DE ESTA ÁREA');
        }
    });
    return Total_Msj;
}
var LeerNotificaciones=function () {
    $.ajax({
        url: base_url+"Sections/Notificaciones/AjaxLeerNotificaciones",
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {

        },error: function (e) {
            console.log('ERROR AL LEER NOTIFICACIONES DE ESTA ÁREA');
        }
    });
}
var ReportarError=function (error_url,error_msj) {
    $.ajax({
        url: base_url+"Sections/Error/AjaxLogError",
        dataType: 'json',
        type: 'POST',
        data: {
            error_url:error_url,
            error_msj:error_msj,
            csrf_token:csrf_token
        },success: function (data, textStatus, jqXHR) {
            if(data.accion=='1'){
                //msj_success_noti('EL ERROR HA SIDO REPORTADO AL ADMINISTRADOR DEL SISTEMA')
            }
        },error: function (e) {
            console.log('ERROR AL REPORTAR EL ERROR');
        }
    });
}
var PreventCloseWindows=function () {
     window.onbeforeunload = function (e) {
        var e = e || window.event;
                                   if (e) {
                                     e.returnValue = 'Se perderan todos los datos que no hayas guardado';
                                   }
    }
}

var data_loading=function (msj){
   bootbox.dialog({
        message:'<div class="loading">'+
                    '<div class="loader text-center" style="display:none">'+
                        '<img src="<?=base_url()?>assets/img/loadingimss.gif">'+
                    '</div>'
        ,onEscape : function() {}
    });
    
};