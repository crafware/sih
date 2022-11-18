$(document).ready(function() {
    $('#input_search,#input_search_am').focus()
    $('#input_search').keyup(function (e){
        var input=$(this);
        if($(this).val().length==11 && input.val()!=''){ 
            $.ajax({
                url: base_url+"Triage/EtapaPaciente/"+input.val(),
                dataType: 'json',
                success: function (data, textStatus, jqXHR) { 
                    if(data.accion=='1' && input.val()!=''){
                        window.open(base_url+'Triage/Paciente/'+input.val(),'_blank');
                    }if(data.accion=='2' && input.val()!=''){
                        bootbox.confirm({
                            title:'<h5><b>EL PACIENTE YA FUE CLASIFICADO</b></h5>',
                            message:'<div class="row" style="margin-top:-10px">'+
                                        '<div class="col-md-12" >'+
                                            '<div style="height:10px;width:100%;margin-top:10px" class="'+ObtenerColorClasificacion(data.info.triage_color)+'"></div>'+
                                        '</div>'+
                                        '<div class="col-md-12">'+
                                            '<h3 style="line-height: 1.4;margin-top:0px"><b>PACIENTE: </b> '+data.info.triage_nombre+'</h3>'+
                                            '<h3 style="line-height: 1.4;margin-top:-10px"><b>MÉDICO: </b> '+data.medico.empleado_nombre+' '+data.medico.empleado_apellidos+'</h3>'+
                                            '<h3 style="line-height: 1.4;margin-top:-10px"><b>DESTINO: </b> '+data.info.triage_consultorio_nombre+'</h3>'+
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
                            //size:'small',
                            buttons:{
                                confirm:{
                                    label:'Generar Hoja de Clasificación',
                                    className:'back-imss'
                                },cancel:{
                                    label:'Cancelar',
                                    className:'back-imss'
                                }
                            },callback:function (res) {
                                if(res==true){
                                    AbrirDocumento(base_url+'inicio/Documentos/Clasificacion/'+data.info.triage_id)
                                }
                            }
                        })                    
                    }if(data.accion=='3' && input.val()!=''){ 
                        MsjNotificacion('PACIENTE NO REGISTRADO POR ENFERMERÍA','ESTE PACIENTE NO TIENE REGISTRADO SIGNOS VITALES, ENVIAR AL PACIENTE CON LA ENFERMERA DE TRIAGE')
                    }    
                    input.val('');
                    e.preventDefault();
                },error: function (e) {
                    bootbox.hideAll();
                    console.log(e)
                    MsjError();
                }
            })
        }
    });
    
    $('input[name=inputOmitirClasificacion]').click(function (e) {
        if($(this).val()=='Si'){
            $('.row-clasificacion-omitida').removeClass('hide');
            $('.obsOmitirClasificacion').attr('requiered', true);
                                     
        }else{
                $('.row-clasificacion-omitida').addClass('hide');
                $('.obsOmitirClasificacion').removeAttr('requiered');
                $('.obsOmitirClasificacion').val('');
                $('input[name="clasificacionColor"]').prop('checked',false);
        }
    });
    
    $('input[name=envio_otraunidad]').click(function (e) {
        if($(this).val()=='Si'){
            $('.div-envio').removeClass('hide');
            $('.select_envio').attr('requiered', true);
                                                 
        }else{
                $('.div-envio').addClass('hide');
                $('.select_envio').removeAttr('requiered');
                $('.select_envio').val('');
        }
    });
   
    
    $('.btn-submit-paso2').on('click',function(e){
        var verifica=verificarEnvio();
        e.preventDefault();
        if(verifica) {
                
            SelecionarConsultorio();
        }
        
    });
    

    $('.GENERAR_LECHUGA_CONSULTORIOS').click(function (e) {
        AbrirDocumento(base_url+'Inicio/Documentos/LechugaConsultorios?inputFechaInicio='+$(this).attr('data-inputfecha')+'&from='+$(this).attr('from')+'&turno='+$(this).attr('data-turno'),'_blank');
    });

    function verificarEnvio() {
        var enviarPaciente = $('input:radio[name="envio_otraunidad"]:checked').val();
        var omitirClasificacion = $('input:radio[name="inputOmitirClasificacion"]:checked').val();
         
        if(enviarPaciente==='Si') {
            if($('.select_envio').val() === '') {
                $('#msgSelectEnvio').append(" Debe Seleccionar una opción");
                $('#msgSelectEnvio').fadeOut(5000);
                return false;
                 
            }
        }else if(omitirClasificacion == 'Si') {   
                    if (!$('input[name="clasificacionColor"]').is(':checked')) { 
                        $('#msgColor').append(" Debe Seleccionar una opción");
                        $('#msgColor').fadeOut(4000);
                        return false;
                    }else{ 
                            if(!$.trim($('#comClasifica').val() )) {
                                $('#msgObs').append(" Debe de llenar éste campo");
                                $('#msgObs').fadeOut(5000);
                                return false;
                            }
                        }
                             
              }
        
                return true;
    }

    function SelecionarConsultorio() {
        SendAjaxGet("Consultorios/AjaxObtenerConsultoriosV2",function (response) {
            if($('input[name=ConfigDestinosMT]').val()=='Si'){
               AjaxSeleccionarConsultorio(response.option);
            } else{
                AjaxGuardarTriage()
            }  
        });
    }

    function AjaxSeleccionarConsultorio(option){
        bootbox.confirm({
            title: '<h5>&nbsp;&nbsp;<b>SELECCIONAR DESTINO</b></h5>',
            message:'<div class="row ">'+
                        '<div class="col-sm-12">'+
                            '<select id="select_destino" style="width:100%">'+option+'</select>'+
                            '<textarea name="ac_diagnostico_select" rows="3" maxlength="200" class="form-control hide" placeholder="Diagnostico Presuncional" style="margin-top:10px"></textarea>'+
                        '</div>'+
                    '</div>',
            size:'small',
            buttons: {
                cancel: {
                    label: "Cancelar",
                    className: "btn-imss-cancel",
                },confirm: {
                    label: "Guardar",
                    className: "back-imss",
                }
            },callback:function(res){
                if(res==true){
                    var select_destino=$('body #select_destino').val().split(';')
                    $('input[name=triage_consultorio]').val(select_destino[0]);
                    $('input[name=triage_consultorio_nombre]').val(select_destino[1]);
                    $('input[name=ac_diagnostico]').val($('body textarea[name=ac_diagnostico_select]').val());
                    AjaxGuardarTriage();
                }
            },onEscape : function() {}
        });
        $('body').on('change','#select_destino',function (e){
            if($(this).val()=='0;Ortopedia-Admisión Continua'){
                $('body textarea[name=ac_diagnostico_select]').removeClass('hide');
            }else{
                $('body textarea[name=ac_diagnostico_select]').addClass('hide');
            }
        })
    }
    $('input[name=triage_preg1_s1]').click(function(e){
        if($(this).val()=='31'){
            msj_evaluacion($(this),'Pérdida súbita del estado de alerta','Si el paciente tiene o no el antecedente inmediato previo o situación clínica de ausencia abrupta de respuesta a los'+
            'estímulos del medio ambiente, lo que motiva su atención en el servicio.');
        }
    })
    $('input[name=triage_preg2_s1]').click(function(e){
        if($(this).val()=='31'){
            msj_evaluacion($(this),'Apnea','Si el paciente presenta o no ausencia de movimientos respiratorios al examinar su habitus exterior.');
        }
    })
    $('input[name=triage_preg3_s1]').click(function(e){
        if($(this).val()=='31'){
            msj_evaluacion($(this),'Ausencia de pulso','Si el paciente'+
                'presenta o no ausencia del latido intermitente de las arterias, que normalmente se puede percibir en varias'+
                'partes del cuerpo y especialmente en la muñeca de la mano.')
        }
    })
    $('input[name=triage_preg4_s1]').click(function(e){
        if($(this).val()=='31'){
            msj_evaluacion($(this),'Intubación de vía respiratoria','Si el paciente'+
                'se encuentra o no con intubación de la vía respiratoria orotraqueal, o con la presencia de cualquier dispositivo'+
                'cilíndrico hueco en la vía respiratoria superior, cuya finalidad es asegurar la permeabilidad de las mismas y'+
                'lograr una ventilación pulmonar eficaz.')
        }
    })
    $('input[name=triage_preg5_s1]').click(function(e){
        if($(this).val()=='31'){
            msj_evaluacion($(this),'Angor o equivalente','Si el paciente'+
                'presenta o no un cuadro caracterizado por dolor torácico'+
                'anterior de tipo opresivo habitualmente irradiado al'+
                'brazo izquierdo y al cuello, potencialmente acompañado'+
                'de palidez, sudoración fría, náusea, disnea, sensación'+
                'de ahogo y de urgencia urinaria o deseos de defecar;'+
                'producto todo de isquemia miocárdica.')
        }
    })


    
    function msj_evaluacion(el,title,msj){
        bootbox.confirm({
            title: '<h5 style="text-transform:uppercase">'+title+'</h5>',
            message:'<div class="row " style="margin-top:-10px">'+
                        '<div class="col-sm-12">'+
                            '<h5 style="line-height:1.5">'+msj+'</h5>'+
                        '</div>'+
                    '</div>',
            size:'medium',
            buttons: {
                cancel: {
                    label: "Cancelar",
                    className: "btn-imss-cancel",
                },confirm: {
                    label: "Aceptar",
                    className: "back-imss",
                }
            },callback:function (res) {
                if(res==true){
                    AjaxGuardarTriage();   
                }else{
                    console.log(el.attr('name'))
                    $('body input[name='+el.attr('name')+'][value="0"]').prop('checked',true);
                }
            }
        });
    }
    function AjaxGuardarTriage() {
        var form=$('body .agregar-paso2').serialize();  
        SendAjaxPost(form,"Triage/GuardarClasificacion",function (response) {
            AbrirDocumento(base_url+'inicio/documentos/Clasificacion/'+response.triage_id);
            if(response.accion=='1'){
                ActionCloseWindowsReload()
            }
        })
    }
    
    $('.btn-horacero-medico').click(function (e) {
        e.preventDefault();
        SendAjaxGet("Horacero/GenerarFolio",function (response) {
            if(response.accion=='1'){
                location.href=base_url+'Triage/Paciente/'+response.max_id+'/?via=medicoTRHoraCero'
            }
        })
    })

    $('.form-indicador-triage').submit(function (e) {
        e.preventDefault();
        SendAjaxPost($(this).serialize(),"Triage/AjaxIndicadorMedico",function (response) {
            $('.Total-Pacientes').html(response.TOTAL_INFO_CAP+' Pacientes')  ;

              $('.GENERAR_LECHUGA_CONSULTORIOS')
                        .attr('data-inputfecha',$('input[name=inputFecha]').val()).attr('from',$('input[name=login_area]').val()).attr('data-turno',$('select[name=Turno]').val()).removeClass('hide');
        })
    })

    $('.select_envio').change(function(){
        var destino=$(this).val();
        if (destino=='Domicilio') {
            $('.tratamiento').removeClass('hidden');
        }else {
            $('.tratamiento').addClass('hidden');
        }
    })
    /* Escala de qSOFA */
    var qsofaTotal = 0;
    var glasgow = 0;
    var fresp = 0;
    var ta = 0;
        
     if ($('.qsofa_r').val() >= 22) {
        $('.qsofa2').html(1);
        fresp = 1;
     }
     // var sistolica = $('.qsofa_ta').val().split('/');
     // if(sistolica[0] <= 100) {
     //    $('.qsofa3').html(1);
     //    ta = 1;
     // }
        

     qsofaTotal = glasgow + fresp + ta;
     $('#qsofaTotal').html(qsofaTotal);
     if(qsofaTotal <= 1){
           $('#qsofaMsg').html('Riesgo Bajo');
      }else {      
            $('#qsofaMsg').html('Riesgo Alto de mal pronóstico');
        }
     $('input[name=qsofa]').val(qsofaTotal);   
        $('input[name=triage_preg10_s2]').click(function() {
    
            if($(this).val() > 0){
                $('.qsofa1').html(1);
                qsofaTotal = 1  + fresp + ta;
                $('input[name=qsofa]').val(qsofaTotal);
                         
            }else {
                $('.qsofa1').html('0');
                qsofaTotal = 0 + fresp + ta;
                $('input[name=qsofa]').val(qsofaTotal);
            }
        });
        console.log(qsofaTotal);

});