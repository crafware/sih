$(document).ready(function () {
	
	/* Agregar Diagnósticos en Nota inicial, Nota de evolución, Nota de Egreso */
	if($('input[name=cie10_nombre').val()!=undefined){
       $('body').on('click','input[name=cie10_nombre]',function() {
           $('input[name=cie10_nombre]').shieldAutoComplete({
                dataSource: {
                    data: CIE10,
                },minLength: 5,
                open: true
            });
           //$('input[name=cie10_nombre]').swidget().refresh();
           $('input[name=cie10_nombre]').swidget().visible();
       });
       	$('body').on('click','.sui-listbox-item',function() {
	        var diagnostico=$(this).text();
	        var tipo_nota = $('input[name=tipo_nota]').val();
            var folio = $('input[name=triage_id]').val();
            var tipo_diagnostico ='';

            $.ajax({
                url: base_url+"Sections/Documentos/AjaxConsultarDiagnosticos",
                type: 'GET',
                dataType: 'json',
                data: { folio: folio },
            })
            .done(function(data) {
                
                if(data.length) {  // Si existe un diagnostico en la nota inicial
                    $.each(data, function(index, obj){
                        if(obj.tipo_diagnostico=='0' || obj.tipo_diagnostico=='1'){
                            var actualizar_dxp=$('input:radio[name=dxprimario]:checked').val();
                            var cambiar_dxp=$('input:radio[name=cambioDxPrincipal]:checked').val();
                            var no_dxEgreso=$('input:radio[name=dxEgreso]:checked').val();
                    /** Si se desea confirmar que el Diagnóstico de Ingreso sea Diagnóstico Primario **/
                        if (actualizar_dxp=='No') { //pregunta si es diagnostco principal
                                // console.log(actualizar_dxp);
                                AjaxGuardarDiagnostico({
                                    cie10_nombre:diagnostico,
                                    complemento:'',
                                    diagnostico_id:0,
                                    tipo_diagnostico:1,
                                    ecabezado_titulo:'Agregar',
                                    accion:'add'
                                });
                            }else if(cambiar_dxp=='Si') {

                                 AjaxGuardarDiagnostico({
                                    cie10_nombre:diagnostico,
                                    complemento:'',
                                    diagnostico_id:0,
                                    tipo_diagnostico:1,
                                    ecabezado_titulo:'Actualizar',
                                    accion:'cambiar principal'
                                })
                            }else if(no_dxEgreso == 'No') {
                                AjaxGuardarDiagnostico({
                                    cie10_nombre:diagnostico,
                                    complemento:'',
                                    diagnostico_id:0,
                                    tipo_diagnostico:3,
                                    ecabezado_titulo:'Agregar',
                                    accion:'add'
                                })

                            }else {
                                AjaxGuardarDiagnostico({
                                    cie10_nombre:diagnostico,
                                    complemento:'',
                                    diagnostico_id:0,
                                    tipo_diagnostico:2,
                                    ecabezado_titulo:'Agregar',
                                    accion:'add'
                                })
                            }
                        }else if(obj.tipo_diagnostico !='0') {
                            AjaxGuardarDiagnostico({
                                cie10_nombre:diagnostico,
                                complemento:'',
                                diagnostico_id:0,
                                tipo_diagnostico:0,
                                ecabezado_titulo:'Agregar',
                                accion:'add'
                            }) 
                        }
                        return false;
                    })
                    
                }else { // de lo contrario si no existe ningun diagnostico
                      AjaxGuardarDiagnostico({
                        cie10_nombre:diagnostico,
                        complemento:'',
                        diagnostico_id:0,
                        tipo_diagnostico:0,
                        ecabezado_titulo:'Agregar',
                        accion:'add'
                      })
                     }
            })

	        $('input[name=cie10_nombre]').val('');
	    });
    }
	
	if($('input[name=cie10_nombre]').val()!=undefined){
        AjaxObtenerDiagnosticos();
    }
	
	$('input[name=cie10_nombre]').removeClass('sui-input');
    $('body').on('click','.add-cie10',function() {
        if($('input[name=cie10_nombre]').val()!=''){
            SendAjax({csrf_token:csrf_token,cie10_nombre:$('input[name=cie10_nombre]').val()},'Sections/Documentos/AjaxCheckCIE10',function (response) {
                if(response.accion=='1'){
                    AjaxGuardarDiagnostico({
                        cie10_nombre:$('input[name=cie10_nombre]').val(),
                        cie10hf_obs:'',
                        cie10hf_id:0,
                        accion:'add'
                    })
                    $('input[name=cie10_nombre]').val('');
                }else{
                    msj_error_noti('EL DIAGNOSTICO CIE10 NO EXISTE POR FAVOR SELECCIONE UNO DE LA LISTA')
                }
            },'');

        }

    });

/* Editar Diagnostico */
    $('body').on('click','.editar-diagnostico-cie10',function() {        
        AjaxGuardarDiagnostico({
            cie10_nombre:$(this).attr('data-nombre'),
            complemento:$(this).attr('data-obs'),
            diagnostico_id:$(this).attr('data-id'),
            tipo_diagnostico:$(this).attr('data-tipo_diagnostico'),
            ecabezado_titulo:'Editar',
            accion:'edit'
        })
    });

/* Eliminar Diagnóstico */
	$('body').on('click','.eliminar-diagnostico-cie10',function(e) {
        //e.preventDefault();
        let diagnostico_id = $(this).attr('data-id');
        console.log(diagnostico_id)
       bootbox.confirm({
            message: "¿Esta seguro de eliminar el Diagnóstico?",
            buttons: {
                    confirm: {
                            label: 'Si',
                            className: 'btn-success'
                             },
                    cancel: {
                            label: 'No',
                            className: 'btn-danger'
                            }
                    },
            callback: function (respuesta) {
                if(respuesta){
                    
                    console.log(respuesta,diagnostico_id)
                    $.ajax({
                        url:base_url+'Sections/Documentos/AjaxEliminarDiagnostico',
                        type:'POST',
                        dataType: 'json',
                        data:{
                            csrf_token:csrf_token,
                            diagnostico_id:diagnostico_id
                        },beforeSend: function (xhr) {

                        },success: function(data,textStatus, jqXHR) {
                            AjaxObtenerDiagnosticos()
                        },error: function (jqXHR, textStatus, errorThrown) {
                            bootbox.hideAll();
                            MsjError();
                        }

                    });
                } 
            }
        });
    });
        
    

/**  Actualización  de Dx de Ingreso a Dx Principal y de Principal 
/** Si es Dx de Ingreso y si si es el Principal                   
 */  
/* Elige cambiar el diagnostico de INGRESO por diagnnóstico PRINCIPAL */   
    $('body').on('click', 'input[name=dxprimario]', function(e) {
    	if($(this).val()=='No'){  // si es No abre elinput para ingresar el Dx principal
            $('#update_dxprincipal').removeClass('hidden');
                                     
        }else{ // si es Dx de Ingreso convierte a Principal
                $('#update_dxprincipal').addClass('hidden');
                //$('input[name=complemento]').val('');
                AjaxCambiarDiagnostico({   
                    diagnostico_id:$(this).attr('data-id'),
                    cie10_nombre:$(this).attr('data-nombre'),
                    complemento:$(this).attr('data-obs'),
                    tipo_diagnostico:$(this).attr('data-tipo_diagnostico'),       
                    accion:'convertir a primario'
                });
        }
    })
/* Elige cambiar el diagnostico PRINCIPAL por otro PRINCIPAL */   
    $('body').on('click','input[name=cambioDxPrincipal]', function(e){
        if($(this).val()=='Si') {
            $('#cambiar_dxprincipal').removeClass('hidden');         
        } else {
             $('#cambiar_dxprincipal').addClass('hidden');
        }

    })
/** Boton Agregar Dx ó Cancelar Dx en Nota de Evolución */
    $('.btn_add-dx').click(function (e) {
        if($(this).val()=='add') {
            $('#add_dxsecundario').removeClass('hidden');
            $(this).removeClass('btn-success');
            $(this).addClass('btn-danger');
            $(this).val('remove');
            $(this).text(' Cancelar');

        }else  {
             $('#add_dxsecundario').addClass('hidden');
             $(this).removeClass('btn-danger');  
             $(this).addClass('btn-success');
             $(this).text(' Agregar Dx Secundario');
             $(this).val('add');
             $('#add_dxsecundario').val('');
             }                         
        });
    
    /* Agreagr el DX de Egreso */   
    $('body').on('click', 'input[name=dxEgreso]', function(e) {
        diagnostico_id=$(this).attr('data-id');
        cie10_id=$(this).attr('data-cie10_id');
        cie10_nombre=$(this).attr('data-nombre');
        complemento=$(this).attr('data-obs');
        tipo_diagnostico=$(this).attr('data-tipo_diagnostico');

        if($(this).val()=='No'){  // si es No abre elinput para ingresar el Dx principal
            $('#cambio_dxi_dxe').removeClass('hidden');
                                     
        }else{ // si es Dx de Ingreso o Principal se convierte de Egreso
                $('#cambio_dxi_dxe').addClass('hidden');
                bootbox.confirm({
                    title: "<h4>Convertir ´Diagnóstico</h4>",
                    message: "¿Desea convertir a Diagnóstico de Egreso?",
                    buttons: {
                        confirm: {
                            label: 'Confirmar',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if(result){                                                           
                            AjaxConvertirDxEgreso({   
                                diagnostico_id:diagnostico_id,
                                cie10_id:cie10_id,
                                cie10_nombre:cie10_nombre,
                                complemento:complemento,
                                tipo_diagnostico:tipo_diagnostico,       
                                accion:'convertir a egreso'
                            });
                        } else {
                            $('input[name=dxEgreso]').removeAttr('checked');
                            console.log('This was logged in the callback: ' + result);
                          }
                    }
                });
                
        }
    })    

}); // fin

function AjaxGuardarDiagnostico(info){
    var valor_dx;
    if(info.tipo_diagnostico=='0') {
        valor_dx = 'de Ingreso';
    }else if(info.tipo_diagnostico=='1') {
        valor_dx = 'Principal';
    }else if(info.tipo_diagnostico=='2') {
        valor_dx = 'Secundario';
    }else { valor_dx = 'De Egreso';}
    
    bootbox.confirm({
        title:'<h5>'+info.ecabezado_titulo+' Diagnóstico ' +valor_dx+'</h5>',
        message:'<div class="row">'+
                    '<div class="col-md-12">'+
                        '<div class="form-group">'+
                            '<label>Diagnóstico seleccionado:</label><br>'+
                            '<label class="mayus-bold">'+info.cie10_nombre+'</label><br>'+ 
                            '<input name="tipo_diagnostico" type="hidden" value="'+info.tipo_diagnostico+'" data-value="'+info.tipo_diagnostico+'">'+                                
                        '</div>'+
                        '<div class="form-group">'+
                            '<label>Complemento del Diagnóstico (opcional):</label>'+
                            '<textarea class="form-control" name="complemento" placeholder="Anote aquí un complemento que de soporte al diagnóstico seleccionado">'+info.complemento+'</textarea>'+
                        '</div>'+
                    '</div>'+
                '</div>',
        buttons:{
            cancel:{
                label:'Cancelar',
                className:'btn-imss-cancel'
            },confirm:{
                label:'Aceptar',
                className:'back-imss'
            }
        },callback:function(response){
            if(response==true){

                    if(info.accion =='cambiar principal') {
                        CambiarPrincipalAPrincipal({   
                            //cie10_nombre:$('body input[name=cambioDxPrincipal]').attr('data-nombre'),
                            //complemento:$('body input[name=cambioDxPrincipal]').attr('data-obs'),
                            diagnostico_id:$('body input[name=cambioDxPrincipal]').attr('data-id'),
                            tipo_diagnostico:2, //$('body input[name=cambioDxPrincipal]').attr('data-tipo_diagnostico'),       
                            accion:'cambiar_principal_a_secundario'
                        });
                    }
                    var complemento = $('body textarea[name=complemento]').val();
                    var triage_id   = $('body input[name=triage_id]').val();
                    var tipo_nota   = $('body input[name=tipo_nota]').val();
                    var hf          = $('body input[name=hf]').val();
                    SendAjax({
                        accion:info.accion,
                        cie10_nombre:info.cie10_nombre,
                        triage_id:triage_id,
                        complemento:complemento,
                        tipo_diagnostico:info.tipo_diagnostico,
                        diagnostico_id:info.diagnostico_id,
                        tipo_nota:tipo_nota,
                        csrf_token:csrf_token
                    },'Sections/Documentos/AjaxGuardarDiagnosticos?a='+ $('body input[name=accion]').val() +'&hf='+hf,function(response) {
                        console.log(response)
                        if(response.accion=='1'){
                            AjaxObtenerDiagnosticos();
                        }else{
                            msj_error_noti('El diagnóstico no existe');
                        }
                    },'');

                    // if(info.accion =='cambiar principal') {
                    //     AjaxCambiarDiagnostico({   
                    //         diagnostico_id:$('body input[name=cambioDxPrincipal]').attr('data-id'),
                    //         tipo_diagnostico:$('body input[name=cambioDxPrincipal]').attr('data-tipo_diagnostico'),       
                    //         accion:'cambiar_principal_a_secundario'
                    //     });
                    // }
            }else{
                    $('body input[name=cambioDxPrincipal]').removeAttr('checked');
                    $('#cambiar_dxprincipal').addClass('hidden');   
            }
        }  
    });
   
}

function AjaxObtenerDiagnosticos() {
	var tipo_nota = $('input[name=tipo_nota]').val();
    var accion = $('input[name=accion]').val();
    var tipo = $('input[name=tipo]').val()

    if(tipo_nota=='Nota de Evolución' || tipo_nota=='Nota de Valoracion' || tipo_nota=='Nota de Interconsulta') {
		SendAjax({
	        triage_id:$('input[name=triage_id]').val(),
            tipo_nota:tipo_nota,
            accion:accion,
            tipo:tipo,
	        csrf_token:csrf_token
	    },'Sections/Documentos/AjaxObtenerDiagnosticos',function(response) {
	    	$('.row-diagnostico-principal').html(response.row)

	    },'');    
	
	}else {  // SI ES NOTA INICIAL O NOTA DE EGRESO
		SendAjax({
	        triage_id:$('input[name=triage_id]').val(),
            tipo_nota:tipo_nota,
            accion:accion,
            tipo:tipo,
	        csrf_token:csrf_token
	    },'Sections/Documentos/AjaxObtenerDiagnosticos',function(response) {
	    	$('.row-diagnosticos').html(response.row)
	    },'');
	}
}

function AjaxActualizarDiagnostico(info){
    //$('input[name=tipo_diagnostico][value="'+$('input[name=tipo_diagnostico]').data('value')+'"]').prop("checked",true);
    bootbox.confirm({
        title:"<h5>Agregar/Actualizar Diagnóstico Principal</h5>",
        message:'<div class="row">'+
                   '<div class="col-md-12">'+
                       '<div class="form-group">'+
                           '<label class="mayus-bold">'+info.cie10_nombre+'</label>'+                              
                        '</div>'+
                        '<div class="form-group">'+
                            '<label>Complemento de Diagnóstico</label>'+  
                            '<textarea class="form-control" name="complemento" placeholder="Anote aquí un complemento del diagnóstico (opcional si lo requiere)">'+info.complemento+'</textarea>'+
                       '</div>'+
                   '</div>'+
                '</div>',
            buttons:{
                cancel:{
                    label:'Cancelar',
                    className:'btn-imss-cancel'
                },confirm:{
                    label:'Aceptar',
                    className:'back-imss'
                }
            },callback:function(response){
                if(response==true){
                    var complemento=$('body textarea[name=complemento]').val();
                    var triage_id=$('body input[name=triage_id]').val();
                    var tipo_diagnostico = 1;
                    SendAjax({
                        accion:info.accion,
                        cie10_nombre:info.cie10_nombre,
                        triage_id:triage_id,
                        complemento:complemento,
                        tipo_diagnostico:tipo_diagnostico,
                        diagnostico_id:info.diagnostico_id,
                        csrf_token:csrf_token
                    },'Sections/Documentos/AjaxActualizarDiagnostico',function(response) {
                        console.log(response)
                        if(response.accion=='1'){
                            AjaxObtenerDiagnosticos();
                        }else{
                            msj_error_noti('El diagnóstico no existe');
                        }
                    },'');
                }
            }

        })
}

function AjaxCambiarDiagnostico(info){
    
        //tipo_diagnostico = 1;
        bootbox.confirm({
        title:'<h5>Convertir Diagnóstico</h5>',
        message:'<div class="row">'+
                    '<div class="col-md-12">'+
                        '<h5>¿Quiere convertir Diagnóstico de INGRESO a PRINCIPAL?</h5>'+
                    '</div>'+
                '</div>',
        buttons:{
            cancel:{
                label:'Cancelar',
                className:'btn-imss-cancel'
            },
            confirm:{
                label:'Aceptar',
                className:'back-imss'
            }
        },callback:function(respuesta){
            if(respuesta==true){
                console.log(info.accion);

                // var diagnostico_id=$('body input[name=dxprimario]').attr('data-id');          
                // var complemento=$('body input[name=dxprimario]').attr('data-obs');
                var triage_id=$('body input[name=triage_id]').val();
                var tipo_nota=$('body input[name=tipo_nota]').val();

                SendAjax({
                   triage_id:triage_id,
                   tipo_nota:tipo_nota,
                   diagnostico_id:info.diagnostico_id,
                   cie10_nombre:info.cie10_nombre,
                   complemento:info.complemento,
                   tipo_diagnostico:1,
                   accion:info.accion,
                   csrf_token:csrf_token
                },'Sections/Documentos/AjaxGuardarDiagnosticos',function(response) {
                    console.log(response)
                    if(response.accion=='1'){
                        AjaxObtenerDiagnosticos();
                    }else{
                        msj_error_noti('El diagnóstico no existe');
                    }
                },'');
            }else {
                  $('body input[name=dxprimario]').removeAttr('checked');
                  // $('body input[name=cambioDxPrincipal]').removeAttr('checked');
                  // $('#cambiar_dxprincipal').addClass('hidden')
                  console.log(info.accion);
                }
            }
        });
} 
function CambiarPrincipalAPrincipal(datos) {
     $.ajax({
        url:base_url+'Sections/Documentos/AjaxGuardarDiagnosticos',
        type: 'POST',
        dataType: 'json',
        data:{
            // cie10_nombre:datos.cie10_nombre,
            // complemento:datos.complemento,
            diagnostico_id:datos.diagnostico_id,
            tipo_diagnostico:datos.tipo_diagnostico,
            accion:datos.accion,
            csrf_token:csrf_token
        },beforeSend: function (xhr) {             
        },success: function (data, textStatus, jqXHR) {       
        },error: function (jqXHR, textStatus, errorThrown) {
            bootbox.hideAll();
            MsjError();
        }
     })
}
function AjaxConvertirDxEgreso(info){
    console.log(info);
           
    var triage_id=$('body input[name=triage_id]').val();
    var tipo_nota=$('body input[name=tipo_nota]').val();

    SendAjax({
       triage_id:triage_id,
       tipo_nota:tipo_nota,
       diagnostico_id:info.diagnostico_id,
       cie10_id:info.cie10_id,
       cie10_nombre:info.cie10_nombre,
       complemento:info.complemento,
       tipo_diagnostico:3,
       accion:info.accion,
       csrf_token:csrf_token
    },'Sections/Documentos/AjaxGuardarDiagnosticos',function(response) {
        console.log(response)
        if(response.accion=='1'){
            AjaxObtenerDiagnosticos();
        }else{
            msj_error_noti('El diagnóstico no existe');
        }
    },'');
    
}