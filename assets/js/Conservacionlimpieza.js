$(document).ready(function () {
    AjaxCamas();
    /*if($('input[name=area]').val()=='Limpieza e Higiene'){*/
        /*=============================================
         =    Limpiar cama sucia o contaminada            =
         =============================================*/
    /*    
        $('body').on('click','.grey-900, .red',function () {
            let camaId=$(this).attr('data-cama');
            let camaEstado=$(this).attr('data-estado');
            let camaNombre=$(this).attr('data-cama_nombre');
            let folio = $(this).attr('data-folio');
            let accion;
            
            bootbox.confirm({
                message : '<center><h4>¿Confirmar Limpieza de cama '+camaNombre+' ?</h4></center>',
                buttons : {
                            confirm: {
                                label:     'Si',
                                className: 'btn-success'
                                },
                            
                            cancel: {
                                  label:      'No',
                                  className:  'btn-danger'
                            }
                         },
                callback: function (result) {
                            if(result) {  
                                if(camaEstado==='Sucia' || camaEstado==='Contaminada'){
                                    accion = 6; // Cambiar a limpia
                                }else if(camaEstado === 'Descompuesta'){
                                    accion = 7; // Cambio a Reparada 
                                } 
                                //console.log(camaId,camaEstado,folio,accion);
                                SolicitaCambioEstado(camaId,accion,folio);
                            }
                        }
            })
        });
    }else if($('input[name=area]').val()=='Conservación'){


    }*/
    let area = $('input[name=area]').val();
    $('body').on('click','.cama-no',function () {
        let camaId=$(this).attr('data-cama');
        let camaEstado=$(this).attr('data-estado');
        let camaNombre=$(this).attr('data-cama_nombre');
        let folio = $(this).attr('data-folio');
        let estadoPaciente = $(this).attr('data-paciente');
        let accion;
        
        switch (area) {
            case 'Limpieza e Higiene':
                if($(this).hasClass('grey-900') || $(this).hasClass('red') ){

                    bootbox.confirm({
                        message : '<center><h4>¿Confirmar Limpieza de cama '+camaNombre+' ?</h4></center>',
                        buttons : {
                                    confirm: {
                                        label:     'Si',
                                        className: 'btn-success'
                                        },
                                    
                                    cancel: {
                                          label:      'No',
                                          className:  'btn-danger'
                                    }
                                 },
                        callback: function (result) {
                                    if(result) {  
                                        if(camaEstado==='Sucia' || camaEstado==='Contaminada'){
                                            accion = 6; // Cambiar a limpia
                                            //console.log(estadoPaciente);
                                        }else if(camaEstado === 'Descompuesta'){
                                            accion = 7; // Cambio a Reparada 
                                        } 
                                        //console.log(camaId,camaEstado,folio,accion);
                                        SolicitaCambioEstado(camaId,accion,folio,estadoPaciente);
                                    }
                                }
                    });
    
                }
            break;
            case 'Conservación':
                if($(this).hasClass('yellow-600') ){
                    bootbox.confirm({
                        message : '<center><h4>¿Confirmar Reparación de cama '+camaNombre+' ?</h4></center>',
                        buttons : {
                                    confirm: {
                                        label:     'Si',
                                        className: 'btn-success'
                                        },
                                    
                                    cancel: {
                                          label:      'No',
                                          className:  'btn-danger'
                                    }
                                 },
                        callback: function (result) {
                                    if(result) {  
                                        if(camaEstado==='Sucia' || camaEstado==='Contaminada'){
                                            accion = 6; // Cambiar a limpia
                                        }else if(camaEstado === 'Descompuesta'){
                                            accion = 7; // Cambio a Reparada 
                                        } 
                                        //console.log(camaId,camaEstado,folio,accion);
                                        SolicitaCambioEstado(camaId,accion,folio,estadoPaciente);
                                    }
                                }
                    });
                }
            break;
        }
        
    });

    function AjaxCamas() {
        $.ajax({
            url: base_url+"AdmisionHospitalaria/AjaxVisorCamas",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.visor-camas').html(data.Col);
                $('.camas-limpias').html(data.TotalLimpias+' Limpias' );
                $('.camas-sucias').html(data.TotalSucias+' Sucias' );
                $('.camas-contaminadas').html(data.TotalContaminadas+' Contaminadas');
                $('.camas-descompuestas').html(data.TotalDescompuestas+' Descompuestas');
                $('.camas-reparadas').html(data.TotalReparadas+' Reparadas');
            },error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    }
    
    function SolicitaCambioEstado(cama_id,accion,folio,estadoPaciente){
        console.log(cama_id,accion,folio,estadoPaciente);
        $.ajax({
            url:base_url+"Hospitalizacion/SolicitaCambioEstado",
            type: 'POST',
            dataType: 'JSON',
            data: {
                cama_id : cama_id,
                accion: accion,
                triage_id:folio,
                estadoPaciente:estadoPaciente,
                csrf_token:csrf_token
            },
             beforeSend: function (xhr) {
                msj_loading();
            },
            success: function(data, textStatus, jqXHR){
                bootbox.hideAll();
                if(data.accion=='6') {
                     $('.cama'+cama_id).removeClass('grey-900').addClass('cyan-400');

                }else if(data.accion=='7') {
                    $('.cama'+cama_id).removeClass('yellow-600').addClass('lime');
                }
            },error: function (e) {
                msj_error_noti('problemas');
                //msj_error_serve();
                
            }
        })
    }
    
});
