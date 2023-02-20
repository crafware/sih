$(document).ready(function () {
    if($('input[name=area]').val()=='Admisión Hospitalaria'){
        AjaxCamas();
    }
    
    function AjaxCamas() {
        $.ajax({
            url: base_url+"AdmisionHospitalaria/AjaxVisorCamas",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.visor-camas').html(data.Col);
                $('.camas-ocupadas').html(data.TotalOcupadas+' Ocupadas' );
                $('.camas-disponibles').html(data.TotalDisponibles+' Disponibles');
                $('.porcentaje-ocupacion').html(data.PorcentajeOcupacion);
                $('.camas-limpias').html(data.TotalLimpias+' Limpias');
                $('.camas-sucias').html(data.TotalSucias+' Sucias');
                $('.camas-reparadas').html(data.TotalReparadas+' Reparadas');
                $('.camas-contaminadas').html(data.TotalContaminadas+' Contaminadas');
                $('.camas-descompuestas').html(data.TotalDescompuestas+' Descompuestas');
                $('.camas-reservadas').html(data.TotalReservadas+' Reservadas');

                //$('[rel="tooltip"]').tooltip();
            },error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    }

    function LeerFolio (camaId,camaEstado,camaNombre) {
        bootbox.confirm({
            title:'<h5>Introduzca el folio</h5>',
            message:'<div class="col-md-12">'+
                        '<div class="input-group m-b">'+
                            '<input type="text" name="folio" class="form-control" id="inputFolio" placeholder="Ingresar N° de Folio">'+
                            '<span class="input-group-addon back-imss border-back-imss pointer" id="pasteFolio">'+
                                '<i class="fa fa-paste"></i>'+
                            '</span>'+
                    ' </div>',
                    
            size:'small',
            buttons : {
                        confirm: {
                                   label:     'Aceptar',
                                   className: 'btn-success'
                                },
                
                        cancel: {
                                    label:      'Cancelar',
                                    className:  'btn-danger'
                                }
            },
            callback:function (res) {
                if(res){
                    triage_id = $('body input[name=folio]').val();
                    if(triage_id != null && triage_id != '') {
                        $.ajax({
                            url: base_url+"AdmisionHospitalaria/AjaxBuscarPaciente",
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                                camaId:camaId,
                                triage_id:triage_id,
                                csrf_token: csrf_token,
                                },
                            beforeSend: function(xhr) {
                                    msj_loading();
                                },
                            success: function (data, textStatus, jqXHR){
                                console.log(data.accion);
                                bootbox.hideAll();
                                if(data.accion=='1'){
                                    msj_error_noti('El folio no existe paciente no esta registrado');
                                    
                                }else if(data.accion=='2') {
                                        msj_error_noti('El folio ya tiene asignada una cama');

                                }else if(data.accion=='3'){
                                        bootbox.prompt({
                                            title: "<center>Confirmar su Matricula</center>",
                                            inputType: 'password',
                                            size: 'small',
                                            callback: function (result) {
                                               if(result != null && result != ''){
                                                // result es la matricula
                                                AsignarCama(triage_id,camaId,result);
                                               }else msj_error_noti('CONFIRMACIÓN DE MATRICULA REQUERIDA');
                                            }
                                        });                                        
                                    }
                            },
                            error: function (e) {
                                bootbox.hideAll();
                                MsjError();
                                //console.log(e);
                            }
                        });  
                    }else msj_error_noti('Debe introducir un número de Folio valido')
                }else msj_error_noti('Opción Cancelada');
            }
        });
        const pasteButton = document.getElementById("pasteFolio");
        const paste = document.getElementById("inputFolio");
        
        pasteButton.addEventListener('click', async function (event){
            paste.textContent = '';
            //const data = await navigator.clipboard.read();
            const text = await navigator.clipboard.readText();
            //const clipboardContent = data[0];
            paste.value = text;
            //console.log(paste.value)
        });
        return;
    }

    function DireccionResponsable(folio) {
        $.ajax({
            url: base_url+"AdmisionHospitalaria/AjaxDireccionPaciente",
            type: 'GET',
            dataType: 'json',
            data:{
                'triage_id':folio
            },success: function (data, textStatus, jqXHR) {
                $('input[name=directorio_cp]').val(data.Direccion.directorio_cp);
                $('input[name=directorio_cn]').val(data.Direccion.directorio_cn);
                $('input[name=directorio_colonia]').val(data.Direccion.directorio_colonia);
                $('input[name=directorio_municipio]').val(data.Direccion.directorio_municipio);
                $('input[name=directorio_estado]').val(data.Direccion.directorio_estado);
            },error: function (e) {
              alert("holad"+ e);
                console.log(e);
            }
        });
    }

    function convertDateFormat(string) {
      var info = string.split('-');
      return info[2] + '/' + info[1] + '/' + info[0];
    }

    function AsignarCama(triage_id,camaId,empleadoMatricula) {
        
        $.ajax({
            url: base_url+"AdmisionHospitalaria/AjaxReservarCama",
            type: 'POST',
            data: {
                triage_id:triage_id,
                cama_id:camaId,
                empleado_matricula:empleadoMatricula,
                csrf_token:csrf_token
            },dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading()
            },success: function (data, textStatus, jqXHR) {

                if(data.accion=='1'){
                    bootbox.hideAll();
                    AjaxCamas();
                }if(data.accion=='2'){
                    bootbox.hideAll();
                    msj_error_noti('LA MATRICULA ESCRITA NO EXISTE');
                }
                
            },error: function (e) {
                msj_error_serve(e);
                bootbox.hideAll();
            }
        })
    }

    function CambiarCama(area_id, cama_id, triage_id, genero) {
        $.ajax({
            url: base_url+"AdmisionHospitalaria/GetCamasDisponibles",
            type: 'POST',
            dataType: 'json',
            data:{
                area_id:area_id,
                csrf_token:csrf_token
            },
            beforeSend: function (xhr) {
            //$('.modal').modal('hide');
                msj_loading();
            },
            success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                bootbox.confirm({
                    title:'<h5>Cambiar Cama</h5>',
                    message:'<div class="col-md-12">'+
                                '<div class="form-group">'+
                                    '<label>Seleccionar Piso</label>'+
                                    '<select style="width:120px" name="area_id" class="form-control piso_select">'+data.option_pisos+'</select>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label>Seleccionar Cama</label>'+
                                    '<select style="width:120px" name="cama_id_new" class="form-control cama-nueva">'+data.option_camas+'</select>'+
                                '</div>'+

                             '</div>',
                    size:'small',
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
                    callback:function (res) {
                        if(res==true){
                            console.log(cama_id);
                            console.log(triage_id);
                            bootbox.hideAll();
                            $.ajax({ 
                                url: base_url+"AdmisionHospitalaria/AjaxCambiarCamaOcupada",
                                type: 'POST',
                                dataType: 'json',
                                data:{
                                    triage_id:triage_id,
                                    area_id:area_id,
                                    cama_id_actual:cama_id,
                                    cama_id_new:$('body select[name=cama_id_new]').val(),
                                    cama_genero:genero,
                                    csrf_token:csrf_token
                                },beforeSend: function (xhr) {
                                    //msj_loading()
                                },success: function (data, textStatus, jqXHR) {
                                    bootbox.hideAll();
                                    if(data.accion=='1'){
                                        AjaxCamas()
                                    }
                                },error: function (e) {
                                   bootbox.hideAll();
                                    msj_error_serve(e)
                                }
                            })
                        }
                    }
                });
                $('body .piso_select').change(function(){
                    var area_id = $('select[name=area_id]').val();
                    //console.log(area_id);
                    $.ajax({
                        url : base_url+'Asistentesmedicas/Triagerespiratorio/getCama',
                        type : 'POST',
                        data : {
                            area_id: area_id,
                            csrf_token:csrf_token,
                        },
                        dataType : 'json',
                        success : function(data, textStatus, jqXHR) {
                            //console.log(data)
                        $('body .cama-nueva').html(data);
                        },
                            error : function(e) {
                            alert('Error en el proceso de consulta');
                        }
                    });
                });
             },
            error: function (e) {
                bootbox.hideAll();
                msj_error_serve(e)
            }
        });
       
    }

    function ChecarALta(folio,cama,area){
        $.ajax({
            url: base_url+"AdmisionHospitalaria/GetInfoParaAlta/",
            dataType: 'json',
            type: 'POST',
            data: {folio: folio, cama:cama, area:area, csrf_token:csrf_token},
            success: function (data, textStatus, jqXHR) {
                ConfirmarAltaPaciente(cama,folio,data.accion)
                    /*
                        if(data.accion=='0'){
                          msj_error_noti('El Paciente no tiene una Orden de Alta');
                        }else if(data.accion=='1'){
                          msj_error_noti('El paciente tiene una Orden de Pre-alta');
                        }else if(data.accion=='2'){
                            msj_success_noti('El Médico canceló la Alta');                        
                            ConfirmarAltaPaciente(cama,folio,accion)
                        }else if(data.accion=='3'){
                           msj_success_noti('El Médico canceló la Alta');
                        }
                    */
                    }
        });
    }

    function ConfirmarAltaPaciente(cama,folio,accion) {
        if(accion=='0'){
            msj_error_noti('El Paciente no tiene una Orden de Alta');
        }else if(accion=='1'){
            msj_success_noti('El paciente tiene una Orden de Pre-alta');
        }else if(accion=='2'){                         
            msj_success_noti('El paciente tiene una Orden de Alta');
        }else if(accion=='3'){
           msj_success_noti('El Médico canceló la Alta');
        }
        
        bootbox.confirm({
                            message: '<h4 class="text-center">¿Desea indicar Alta de paciente y liberar cama?</h4>',
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
                                    ModalAltaPaciente(cama,folio);
                                }
                            }
        })

    }

    function ModalAltaPaciente(cama_id,folio){
        console.log(cama_id)
        $.ajax({ 
            url: base_url+"AdmisionHospitalaria/ProcesoDeAlta",
            dataType: 'json',
            type: 'POST',
            data: {cama_id:cama_id, csrf_token:csrf_token},
            success: function (data, textStatus, jqXHR) {
                if(data.accion=='1') {
                    console.log(data.accion)
                    let id_43051 = data.infop.id;

                    bootbox.confirm({
                        title: "<h5>Información de Alta de Paciente</h5>",
                        message: '<div class="row" style="margin-top:-10px">'+
                                    '<div class="col-md-12" >'+
                                        '<div style="height:10px;width:100%;margin-top:10px"><center><h4>Cama:'+data.infoc.cama_nombre+' '+data.infoc.piso_nombre_corto+'</h4></center></div>'+
                                    '</div>'+
                                    '<div class="col-md-12">'+
                                        '<h5 style="line-height: 1.4;margin-top:20px"><b>Paciente: </b>'+data.infop.triage_nombre+' '+data.infop.triage_nombre_ap+' '+data.infop.triage_nombre_am+'</h5>'+
                                        '<h5 style="line-height: 1.4;margin-top:5px"><b>NSS: </b>'+data.infop.pum_nss+' '+data.infop.pum_nss_agregado+'</b></h5>'+
                                        '<h5 style="line-height: 1.4;margin-top:5px"><b>Servicio de Egreso: </b>'+data.infon.especialidad_nombre+'</h5>'+ 
                                        '<h5 style="line-height: 1.4;margin-top:5px"><b>Médico: </b>'+data.infon.empleado_apellidos+' '+data.infon.empleado_nombre+'</h5>'+
                                        '<h5 style="line-height: 1.4;margin-top:5px"><b>Motivo de Alta: </b>'+data.motivoe+'</h5>'+                                                            
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<h6 style="line-height: 1.4"><b><i class="fa fa-calendar"></i> Fecha Ingreso: </b><br> '+convertDateFormat(data.infop.fecha_ingreso)+' '+data.infop.hora_ingreso+' hrs</h6>'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<h6 style="line-height: 1.4"><b><i class="fa fa-clock-o"></i> Fecha de egreso: </b><br> '+data.fecha_egreso+'</h6>'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<h6 style="line-height: 1.4"><b><i class="fa fa-clock-o"></i> Tiempo de estancia: </b><br> '+data.testancia+'</h6>'+
                                    '</div>'+
                                 '</div>',
                        buttons: {
                            cancel: {
                                label: 'Cancelar',
                                className: 'btn-imss-cancel'
                            },confirm: {
                                label: 'Confirmar',
                                className: 'back-imss'
                            }
                        },
                        callback: function (result) {
                            if(result){
                                console.log(cama_id,folio,id_43051)
                                $.ajax({
                                    url: base_url+"AdmisionHospitalaria/ConfirmarAltaCamaAsistenteMedica",
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        cama_id:cama_id,
                                        folio:folio,
                                        id_43051:id_43051,
                                        csrf_token: csrf_token
                                    },
                                    beforeSend: function (xhr) {
                                        //msj_loading();
                                    },
                                    success: function (data, textStatus, jqXHR) { 
                                        bootbox.hideAll()
                                        if(data.accion == 1){
                                            location.reload();
                                            msj_success_noti('Solicitud realizada');
                                        }
                                    },
                                    error: function (e) {
                                        bootbox.hideAll();
                                        MsjError();
                                    }
                                });  
                            }
                        }
                    });
                }else if(data.accion=='2'){
                        //msj_success_noti('El paciente no tiene una Orden de Alta, favor de comentar al Médico tratante');
                        let id_43051 = data.infop.id;

                        bootbox.confirm({
                            title: "<h5>Información de Alta de Paciente</h5>",
                            message: '<div class="row" style="margin-top:-10px">'+
                                        '<div class="col-md-12" >'+
                                            '<div style="height:10px;width:100%;margin-top:10px"><center><h4>Cama:'+data.infoc.cama_nombre+' '+data.infoc.piso_nombre_corto+'</h4></center></div>'+
                                        '</div>'+
                                        '<div class="col-md-12">'+
                                            '<h5 style="line-height: 1.4;margin-top:20px"><b>Paciente: </b>'+data.infop.triage_nombre+' '+data.infop.triage_nombre_ap+' '+data.infop.triage_nombre_am+'</h5>'+
                                            '<h5 style="line-height: 1.4;margin-top:5px"><b>NSS: </b>'+data.infop.pum_nss+' '+data.infop.pum_nss_agregado+'</b></h5>'+
                                            '<h5 style="line-height: 1.4;margin-top:5px"><b>Servicio de egreso: </b><select id="select_especilaidad" style="width:50%">'+data.option+'</select></h5>'+ 
                                            '<h5 style="line-height: 1.4;margin-top:5px"><b>Médico de egreso: </b><select id="medicoEgresa" style="width:61%">'+'</select></h5>'+ 
                                            '<h5 style="line-height: 1.4;margin-top:5px"><b>Motivo de egreso: </b><select id="motivoEgreso" style="width:50%">'+data.motivoe+'</select></h5>'+
                                            '<h5 style="line-height: 1.4;margin-top:5px"><b>Obsevaciones : </b><input type="text" name="obsEgreso" id="obsEgreso" style="width:65%"></h5>'+                                                           
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                            '<h6 style="line-height: 1.4"><b><i class="fa fa-calendar"></i> Fecha Ingreso: </b><br> '+convertDateFormat(data.infop.fecha_ingreso)+' '+data.infop.hora_ingreso+' hrs</h6>'+
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                            '<h6 style="line-height: 1.4"><b><i class="fa fa-clock-o"></i> Fecha de egreso: </b><br> '+data.fecha_egreso+'</h6>'+
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                            '<h6 style="line-height: 1.4"><b><i class="fa fa-clock-o"></i> Tiempo de estancia: </b><br> '+data.testancia+'</h6>'+
                                        '</div>'+
                                     '</div>',
                            buttons: {
                                cancel: {
                                    label: 'Cancelar',
                                    className: 'btn-imss-cancel'
                                },confirm: {
                                    label: 'Confirmar',
                                    className: 'back-imss'
                                }
                            },
                            callback: function (result) {
                                if(result){
                                    let servicioEgreso = $('body #select_especilaidad').val();
                                    let medicoEgreso = $('body #medicoEgresa').val();
                                    let motivoEgreso = $('body #motivoEgreso').val();
                                    let obsEgreso = $('body #obsEgreso').val();
                        
                                    if(servicioEgreso == 0) {
                                        bootbox.alert({
                                            title:  "<center>¡ Advertencia !</center>",
                                            message:"<center><h4>Debe seleccionar un servicio de egreso</h4></center>",
                                            size:   "medium"
                                        });
                                        return false;
                                    }else if(medicoEgreso == ''){
                                        bootbox.alert({
                                            title:  "<center>¡ Advertencia !</center>",
                                            message:"<center><h4>Debe seleccionar el Motivo de egreso</h4></center>",
                                        });
                                        return false;
                                    }else if(motivoEgreso == 0){
                                        bootbox.alert({
                                            title:  "<center>¡ Advertencia !</center>",
                                            message:"<center><h4>Debe seleccionar el Motivo de egreso</h4></center>",
                                        });
                                        return false;
                                    }else {

                                        console.log(cama_id,folio,id_43051,servicioEgreso,motivoEgreso)
                                        $.ajax({
                                            url: base_url+"AdmisionHospitalaria/ConfirmarAltaCamaAsistenteMedica",
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                cama_id:cama_id,
                                                folio:folio,
                                                id_43051:id_43051,
                                                servicio_egreso:servicioEgreso,
                                                medico_egreso:medicoEgreso,
                                                motivo_egreso:motivoEgreso,
                                                csrf_token: csrf_token
                                            },
                                            beforeSend: function (xhr) {
                                                //msj_loading();
                                            },
                                            success: function (data, textStatus, jqXHR) { 
                                                bootbox.hideAll()
                                                if(data.accion == 1){
                                                    //location.reload();
                                                    msj_success_noti('Solicitud realizada');
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
                        
                        $("body #select_especilaidad").on('change', function () {
                            $("#select_especilaidad option:selected").each(function () {
                                let id_servicio=$(this).val();
                                
                                $.ajax({
                                    url : base_url+'Admisionhospitalaria/GetMedicoEspecialista',
                                    type : 'POST',
                                    data : {
                                            especialidad_id: id_servicio,
                                            csrf_token:csrf_token,
                                        },
                                    dataType : 'json',
                                    success : function(data, textStatus, jqXHR) {
                                        //alert(data);
                                      $("#medicoEgresa").html(data);
                                    },
                                    error : function(e) {
                                            alert('No se encontaron médicos en esta solicitud');
                                    }
                                });
                            });
                                
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

    $('input[name=directorio_cp]').blur(function (e){
        if($(this).val()!=''){
            BuscarCodigoPostal({
                'cp':$(this).val(),
                'input1':'directorio_municipio',
                'input2':'directorio_estado',
                'input3':'directorio_colonia'
            })
        }   
    });
    /*=============================================
    =    Asigna en cama disponible             =
    =============================================*/
    $('body').on('click','.green',function () {
        var camaId=$(this).attr('data-cama');
        var camaEstado=$(this).attr('data-accion');
        var camaNombre=$(this).attr('data-cama_nombre');
        
        bootbox.confirm({
            message : '¿DESEA REALIZAR ASIGNACIÓN DE CAMA '+camaNombre+' ?',
            size: 'medium',
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
                            LeerFolio(camaId,camaEstado,camaNombre);
                        }
                    }
        })
    });

    /*=============================================
         Cambio de Cama                          
    =============================================*/

    $('body').on('click','.cambiar-cama-paciente',function (e) {
        e.preventDefault();
        var triage_id = $(this).attr('data-id');
        var area_id = $(this).attr('data-area');
        var cama_id = $(this).attr('data-cama-id');
        var cama_nombre = $(this).attr('data-cama');
        var cama_sexo = $(this).attr('data-sexo');
        bootbox.confirm({
            message : '¿Esta seguro que quiere cambiar la cama '+cama_nombre+' ?',
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
                            CambiarCama(area_id, cama_id, triage_id, cama_sexo )
                        }
                    }
        })
    });

    /* =========================================================
        Asignacion de Cama
       ========================================================= */
        
    $('.form-asignacion-cama').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"AdmisionHospitalaria/AjaxAsignarCama_v2",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading('','No');
            },success: function (data, textStatus, jqXHR) {
                console.log(data);
                bootbox.hideAll();
                if(data.accion=='1'){
                    AbrirDocumentoMultiple(base_url+'Inicio/Documentos/DOC43051/'+$('input[name=triage_id]').val(),'DOC43051');
                    ActionCloseWindowsReload();
                    
                }if(data.accion=='2'){
                    ActionCloseWindows();
                    msj_error_noti('LA MATRICULA ESPECIFICADA NO EXISTE')
                }
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e)
            }
        })
    });
    
    $('body input[name=ac_ingreso_matricula]').blur(function () {
        if($(this).val()!=''){
            AjaxBuscarEmpleado(function (response) {
                $('input[name=ac_ingreso_medico]').val(response.empleado_nombre+' '+response.empleado_apellidos)
            },$(this).val())
        }
        
    })
    $('body input[name=ac_salida_matricula]').blur(function () {
        if($(this).val()!=''){
            AjaxBuscarEmpleado(function (response) {
                $('input[name=ac_salida_medico]').val(response.empleado_nombre+' '+response.empleado_apellidos)
            },$(this).val())
        }
    });
 
    $('body').on('click','.eliminar43051',function () {
        var cama_id=$(this).attr('data-cama');
        var triage_id=$(this).attr('data-triage');
        bootbox.confirm({
            title:'<h5>ELIMINAR SOLICITUD</h5>',
            message:'<div class="row">'+
                        '</div class="col-md-12"><h5>¿ELIMINAR SOLICITUD 43051?</h5></div>'+
                    '</div>',
            size:'small',
            buttons:{
                confirm:{
                    label:'Eliminar',
                    className:'back-imss'
                },cancel:{
                    label:'Cancelar',
                    className:'btn-imss-cancel'
                }
            },callback:function (res) {
                if(res==true){
                    SendAjax({
                        cama_id:cama_id,
                        triage_id:triage_id,
                        csrf_token:csrf_token
                    },'AdmisionHospitalaria/AjaxEliminar43051',function (response) {
                        AjaxCamas();
                        msj_success_noti('SOLICITUD ELIMINADA');
                    },'');
                }
            }
        })
    })
    
    $('body').on('click','.liberar43051',function () {
        let cama_id=$(this).attr('data-cama');
        let triage_id=$(this).attr('data-triage');
        let cama_nombre=$(this).attr('data-camanombre');
        bootbox.confirm({
            title:'<h5>LIBERAR CAMA DE SOLICITUD</h5>',
            message:'<div class="row">'+
                        '</div class="col-md-12"><h5>¿LIBERAR CAMA'+' '+cama_nombre+' RESERVADA?</h5></div>'+
                    '</div>',
            size:'small',
            buttons:{
                confirm:{
                    label:'Liberar',
                    className:'back-imss'
                },cancel:{
                    label:'Cancelar',
                    className:'btn-imss-cancel'
                }
            },callback:function (res) {
                if(res==true){
                    SendAjax({
                        cama_id:cama_id,
                        triage_id:triage_id,
                        csrf_token:csrf_token
                    },'AdmisionHospitalaria/AjaxLiberarCama43051',function (response) {
                        $('.modal').modal('hide')  
                        AjaxCamas();
                        msj_success_noti('CAMA LIBERADA');
                    },'');
                }
            }
        })
    })
    $('body').on('click','.generar43051',function (e) {
        e.preventDefault();
        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/DOC43051/'+$(this).attr('data-triage'),'DOC43051');
        $('.modal').modal('hide')   
    });
    /* ================================================================ *
                            Alta Paciente  
    /* ================================================================ */
    $('body').on('click','.alta-paciente',function(e){
        let triage_id=$(this).data('triage');
        let cama_id=$(this).data('cama');
        let area_id=$(this).data('area');
        
        ChecarALta(triage_id,cama_id,area_id);
        
    }); 

    /* ================================================================ *
                    Confirmar Ingreso de Pacinte                              
    /* ================================================================ */
    $('body').on('click','.ocuparCama',function (e){
        e.preventDefault();
        let triage_id=$(this).data('triage');
        let cama_id=$(this).data('cama');
        let cama_nombre=$(this).data('camanombre');
        
        bootbox.confirm({
            title:'<h5>INGRESAR PACIENTE A CAMA</h5>',
            message:'<div class="row">'+
                        '</div class="col-md-12"><h5>¿DESEA CONFIRMAR EL INGRESO A LA CAMA'+' '+cama_nombre+'?</h5></div>'+
                    '</div>',
            size:'small',
            buttons:{
                confirm:{
                    label:'Aceptar',
                    className: 'back-imss'
                },cancel:{
                    label:'Cancelar',
                    className:'btn-imss-cancel'
                }
            },callback:function (res) {
                if(res==true){
                    SendAjax({
                        cama_id:cama_id,
                        triage_id:triage_id,
                        csrf_token:csrf_token
                    },'AdmisionHospitalaria/AjaxConfirmarIngreso',function (response) {
                        AjaxCamas();
                         msj_success_noti('Ingresando paciente en cama ');
                    },'');
                }
            }
        });
    });

    $('.PaseDeVisitaFamiliar').submit(function (e) {
        e.preventDefault();
        SendAjaxPost($(this).serialize(),'AdmisionHospitalaria/AjaxAgregarFamiliar',function (response) {
            window.top.close();
            window.opener.location.reload();
        },'No')
    });
    $('body').on('click','.pases-eliminar-familiar',function (e) {
        SendAjaxPost({
            familiar_id:$(this).attr('data-id'),
            csrf_token:csrf_token
        },'AdmisionHospitalaria/AjaxEliminarFamiliar',function (response) {
            location.reload();
        });
    });
    
        
    if($('input[name=inputPerfilFamiliar]').val()!=undefined){
        Webcam.set({
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach( '#my_camera' );
        $('.btn-tomar-foto').click(function (e) {
            // TOMAR UNA FOTO INSTANTANEA Y MOSTRARLO EN UNA IMAGEN RETORNANDO EN base64
            Webcam.snap( function(src) {
                    // display results in page
                    $('input[name=familiar_perfil]').val(src);
                    $('.image_profile').attr('src',src).css({
                        width:'100%'
                    });
            } );
        })
        $('.btn-save-img').click(function(e) {
           SendAjaxPost({
               familiar_perfil:$('input[name=familiar_perfil]').val(),
               familiar_id:$('input[name=familiar_id]').val(),
               triage_id:$('input[name=triage_id]').val(),
               csrf_token:csrf_token
           },'AdmisionHospitalaria/AjaxGuardarPerfilFamiliar',function(response) {
               window.close();
               window.opener.location.reload();
            },'Si','No')
        });
    }   //cierre de if

    $('body').on('mouseenter','div[data-estado=Ocupado]',function () {
          //if($(this).hasClass('pink-A100') ||$(this).hasClass('blue-800') ){
            let folio = $(this).attr('data-folio');
            $(this).tooltip({content:getTooltip});
             
            
             //console.log(folio);
        //}
        
    });

    function getTooltip(){
        let returnValue = '';

        $.ajax({
                url: base_url+"AdmisionHospitalaria/ToooltipInfoPaciente/",
                type: 'POST',
                dataType: 'json',
                data:{
                    folio:folio,
                    csrf_token:csrf_token
                },
                async:false,
                success: function (data, textStatus, jqXHR) {
                    returnValue = data.datatitle;
                    /*$('div[data-estado=Ocupado]').attr("data-title",data.datatitle);
                    $('div[data-estado=Ocupado]').tooltip();*/
                    //console.log(data.datatitle);
                   //console.log(data.servicio,data.medico);
                },
                error: function (e) {
                  
                   
                }
            });
        return returnValue;
    }

    $("body").on('mouseleave','div[data-estado=Ocupado]',function(){
        $(this).tooltip();
        $('.tooltip').hide();
        $(this).tooltip({disabled:true});
        //console.log('sale de div');
    });

    $('.btn-buscar-ingresos').click(function (e) {
        var input_fecha=$('input[name=input_fecha]').val();
        $.ajax({
            url: base_url+"Admisionhospitalaria/Bucaringresos/",
            type: 'POST',
            dataType: 'json',
            data: {
                input_fecha : input_fecha,
                csrf_token:csrf_token
            },beforeSend: function (xhr) {
                msj_loading('Espere por favor...');
            },success: function (data, textStatus, jqXHR) {
                console.log(data)
                bootbox.hideAll();
                $('.filtro-ingreso').html(data.num_rows+' Pacientes');
                $('.filtro-egreso').html(data.num_rows+' Pacientes');
                $('.btn-filtro-result').removeClass('hide');
                $('.pdfIngresosHosp')
                        .attr('data-fecha_inicio',input_fecha)
                        .attr('data-tipo2','No Aplica')
                        .attr('data-tipo','Consultorios').removeClass('hide');
            },error: function (jqXHR, textStatus, errorThrown) {
                bootbox.hideAll();
                msj_error_serve();
                ReportarError(window.location.pathname,e.responseText);
            }
        })
      })
      $('.pdfIngresosHosp').click(function (e){
        AbrirDocumento(base_url+'inicio/documentos/IngresosAdmisionHospitalaria?fecha_inicio='+$(this).attr('data-fecha_inicio'));
    });
    $('body').on('click','.ReportePiso', function(e){
        e.preventDefault();
        let piso_id = $(this).data("piso");
        AbrirDocumento('http://localhost/sih/inicio/Documentos/reporteEstadoSaludPisoAdmisionHospitalaria?piso_id='+piso_id);
    })
    $('body').on('click','.ReporteEspe', function(e){
        e.preventDefault();
        bootbox.prompt({
            title: 'Selecciona servicio',
            inputType: 'select',
            inputOptions: inputOptions,
            callback: function (result) {
                console.log(result);
                AbrirDocumento('http://localhost/sih/inicio/Documentos/reporteEstadoSaludPisoAdmisionHospitalaria?especialidad_id='+result);
            }
        });
    })
});
