    function checkOrdenInternamiento(folio){
        $.ajax({
            url: base_url+"Consultorios/GetInfoParaOrdenInternamiento/",
            dataType: 'json',
            type: 'POST',
            data: {folio: folio, csrf_token:csrf_token},
            success: function (data, textStatus, jqXHR) {
                        if(data.accion=='3'){
                          AbrirDocumento(base_url+'Inicio/Documentos/Ordeninternamiento/'+folio);
                           msj_success_noti('Mostrando Orden de Internamiento');
                        }
                        else if(data.accion=='2'){
                          // Pregunta si quiere hacer orden de internamiento
                          bootbox.confirm({
                            message: '<h4 class="text-center">¿Desea hacer una Orden de Internamiento?</h4>',
                            buttons: {
                                cancel:{
                                  label: 'NO',
                                  className: 'btn-imss-cancel'
                                },confirm: {
                                  label: 'SI',
                                  className: 'back-imss'
                                }
                            },
                            callback: function(response){
                                if(response){                    
                                    modalOrdenInternamiento(folio);
                                }
                            }
                        })

                        }else if(data.accion=='1'){
                           msj_success_noti('Este paciente no tiene Diagnóstico, Genere Nota Médica e intente nuevamente');
                        }
                     }
        });
    }
    function modalOrdenInternamiento(triage_id) {
      $.ajax({ 
              url: base_url+"Consultorios/GetInfoParaOrdenInternamiento",
              dataType: 'json',
              type: 'POST',
              data: {folio: triage_id, csrf_token:csrf_token},
              success: function (data, textStatus, jqXHR) {
                if(data.accion=='2') {
                    bootbox.confirm({
                        title: "<h5>Información de Orden de Internamiento</h5>",
                        message: '<div class="row" style="margin-top:-10px">'+
                                    '<div class="col-md-12" >'+
                                        '<div style="height:10px;width:100%;margin-top:10px" class="'+ObtenerColorClasificacion(data.info.triage_color)+'"></div>'+
                                    '</div>'+
                                    '<div class="col-md-12">'+
                                        '<h5 style="line-height: 1.4;margin-top:5px"><b>Paciente: </b>'+data.info.triage_nombre+' '+data.info.triage_nombre_ap+' '+data.info.triage_nombre_am+'</h5>'+
                                        '<h5 style="line-height: 1.4;margin-top: 10px"><b>Dx CIE10: </b>'+data.dx+'</b></h5>'+
                                        '<h5 style="line-height: 1.4;margin-top:10px">'+(data.dx_complemento ? "<b>Complemento de Dx: </b>"+data.dx_complemento : " ")+'</h5>'+
                                        '<h5 style="line-height: 1.4;margin-top:10px"><b>Servicio de Ingreso: </b><select id="select_especilaidad" style="width:50%">'+data.option+'</select></h5>'+                                             
                                        '<textarea name="motivo_internamiento" id="motivo" rows="2" style="width: 100%" placeholder="Motivo de Internamiento" required></textarea>'+                        
                                    '</div>'+
                                    
                                    '<div class="col-md-4">'+
                                        '<h6 style="line-height: 1.4"><b><i class="fa fa-clock-o"></i> HORA CERO: </b><br> '+data.info.triage_horacero_f+' '+data.info.triage_horacero_h+'</h6>'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<h6 style="line-height: 1.4"><b><i class="fa fa-heartbeat"></i> HORA ENFERMERÍA: </b> '+data.info.triage_fecha+' '+data.info.triage_hora+'</h6>'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<h6 style="line-height: 1.4"><b><i class="fa fa-user-md"></i> HORA CLASIFICACIÓN: </b> '+data.info.triage_fecha_clasifica+' '+data.info.triage_hora_clasifica+'</h6>'+
                                    '</div>'+
                                 '</div>',
                        buttons: {
                            cancel: {
                                label: 'Cancelar',
                                className: 'back-imss'
                            },confirm: {
                                label: 'Confirmar',
                                className: 'back-imss'
                            }
                        },
                        callback: function (result) {
                            if(result){
                                let servicio = $('body #select_especilaidad').val();
                                let motivo = $('body #motivo').val();
                                if(servicio == 0) {
                                    bootbox.alert({
                                        title:  "<center>¡ Advertencia !</center>",
                                        message:"<center><h4>Debe seleccionar un servicio de ingreso</h4></center>",
                                        size:   "medium"
                                    });
                                  return false;
                                }else if(motivo == 0){
                                    bootbox.alert({
                                        title:  "<center>¡ Advertencia !</center>",
                                        message:"<center><h4>Debe de mencionar el Motivo de ingreso</h4></center>",
                                    });
                                    return false;
                                }else 
                                  {
                                    $.ajax({
                                        url: base_url+"Admisionhospitalaria/OrdenInternamiento",
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            triage_id: data.info.triage_id,
                                            servicio_solicitado_id: servicio,
                                            motivo: motivo,
                                            dx_registrado: data.id_dx,
                                            csrf_token: csrf_token
                                        },
                                        beforeSend: function (xhr) {
                                            msj_loading();
                                        },
                                        success: function (data, textStatus, jqXHR) { 
                                            bootbox.hideAll()
                                            console.log(data.accion);
                                            console.log(triage_id);
                                            if(data.accion == 1){
                                                msj_success_noti('Solicitud realizada');
                                                AbrirDocumento(base_url+'Inicio/Documentos/Ordeninternamiento/'+triage_id);

                                                location.reload();
                                            }
                                        },
                                        error: function (e) {
                                            bootbox.hideAll();
                                            MsjError();
                                        }
                                    });
                                  }
                            }
                           
                        }
                    });
                  }
                },
              error: function (e) {
                bootbox.hideAll();
                console.log(e)
                MsjError();
              }
            });
    }
   
    
    $('body').on('click','.orden-internamiento',function(e){
        var triage_id = $(this).attr('data-folio');
        e.preventDefault();
        // Checar si existe orden de internamiento
        checkOrdenInternamiento(triage_id);
        
    });  