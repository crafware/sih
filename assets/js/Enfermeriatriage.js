$(document).ready(function () {
    let preguntaNss = $('input[name=triage_paciente_afiliacion_bol]').val();
    $('#input_search').focus()
    $('#input_search').keyup(function (e){
        var input=$(this);
        var triage_id=$(this).val();
        if(triage_id.length==11 && triage_id!=''){ 
            SendAjaxGet("Triage/EtapaPaciente/"+triage_id,function (response) {
                if(response.accion=='1'){
                    window.open(base_url+'Triage/Paciente/'+triage_id,'_blank');
                }if(response.accion=='2'){
                    msj_error_noti('EL N° de paciente no existe');
                }     
            });
            input.val('');
        }
    });
    $('input[name=pia_procedencia_espontanea]').click(function (e){
        if($(this).val()=='Si'){
            $('input[name=pia_procedencia_espontanea_lugar]').prop('type','text').attr('required',true);
            $('.col-no-espontaneo').addClass('hidden');
            $('select[name=pia_procedencia_hospital]').val("");
            $('input[name=pia_procedencia_hospital_num]').removeAttr('required').val('');
        }else{
            $('input[name=pia_procedencia_espontanea_lugar]').prop('type','hidden').removeAttr('required').val('');
            $('.col-no-espontaneo').removeClass('hidden');
            $('input[name=pia_procedencia_hospital_num]').attr('required',true);
        }
    })
    if($('input[name=pia_procedencia_espontanea]').attr('data-value')=='No'){
        $('.col-no-espontaneo').removeClass('hidden');
        $('input[name=pia_procedencia_espontanea][value="No"]').prop("checked",true);
        $('input[name=pia_procedencia_espontanea_lugar]').prop('type','hidden').removeAttr('required');
        
        $("select[name=pia_procedencia_hospital]").val($('select[name=pia_procedencia_hospital]').attr('data-value'));
        $('input[name=pia_procedencia_hospital_num]').attr('required',true);
    }

    $('.generarNss').click(function(){
        let triage_id = $('input[name=triage_id]').val();
        let triage_paciente_sexo = $('select[name=triage_paciente_sexo]').val();
        let fecha_nacimiento = $('input[name=triage_fecha_nac]').val().substr(-4);
        
        if(triage_paciente_sexo == ''){
            bootbox.alert({
            title:  "<center>¡ Advertencia !</center>",
            message:"<center><h4>Indique el sexo</h4></center>",
            size:   "Small"
        })
            return false;
        }else if(fecha_nacimiento==''){
            bootbox.alert({
            title:  "<center>¡ Advertencia !</center>",
            message:"<center><h4>Debe incluir una fecha de naciemiento</h4></center>",
            size:   "Small"
        })
            return false;
        }
        $.ajax({
            url: base_url+'Admisionhospitalaria/GenerarNssConformado',
            type: 'POST',
            dataType: 'json',
            data: {
                    triage_paciente_sexo: triage_paciente_sexo,
                    triage_id: triage_id,
                    fecha_nacimiento: fecha_nacimiento,
                    csrf_token: csrf_token
                  },
            success: function (data, textStatus, jqXHR) {
                if(data.accion == '1'){
                    console.log(data.nss_c);
                    $('input[name=pum_nss_armado]').val(data.nss_c);
                    
                }
            }
        })
        
    })
    
    /*Indicador*/
    $('select[name=TipoBusqueda]').change(function () {
        if($(this).val()=='POR_FECHA'){
            $('.row-por-fecha').removeClass('hide');
            $('.row-por-hora').addClass('hide');
        }if($(this).val()=='POR_HORA'){
            $('.row-por-hora').removeClass('hide');
            $('.row-por-fecha').addClass('hide');
        }if($(this).val()==''){
            $('.row-por-hora').addClass('hide');
            $('.row-por-fecha').addClass('hide');
        }
    })
    $('select[name=triage_paciente_sexo]').change(function (e) {
        if($(this).val()=='MUJER'){
            $('.triage_paciente_sexo').removeClass('hide');
            $('.paciente-sexo-mujer').removeClass('hide');
            $('input[name=pic_indicio_embarazo][value=No]').attr('checked',true);
            $('.paciente-sexo').html('<i class="fa fa-female " style="color: pink"></i>').removeClass('hide');
        }else if($(this).val()=='HOMBRE'){
            $('.paciente-sexo-mujer').addClass('hide');
            $('.paciente-embarazo').html('').removeClass('hide');
            $('.triage_paciente_sexo').addClass('hide');
            $('input[name=pic_indicio_embarazo][value=No]').attr('checked',true);
            $('.paciente-sexo').html('<i class="fa fa-male " style="color: blue"></i>').removeClass('hide');
            $('#lbl_cod_mater').empty();
        }else{
            $('.paciente-sexo-mujer').addClass('hide');
            $('.paciente-sexo').html('');
            $('.triage_paciente_sexo').removeClass('hide');
            $('input[name=pic_indicio_embarazo][value=No]').attr('checked',true);
            $('.paciente-embarazo').html('').removeClass('hide');
        }
    })
    $('input[name=pic_indicio_embarazo]').click(function () {
        if($(this).val()=='Si'){
            $('.paciente-embarazo').html('EMBARAZO').removeClass('hide');
            $('#lbl_cod_mater').html('<input type="radio" name="triage_codigo_atencion" value="4"><i class="green"></i>Mater');
        }else{
            $('.paciente-embarazo').html('EMBARAZO').addClass('hide');
             $('#lbl_cod_mater').empty();
        }
    });
    $('input[name=triage_fecha_nac]').mask('99/99/9999');
    $('input[name=triage_fecha_nac]').change(function (e) {
        var triage_fecha_nac=$(this).val();
        if($(this).val()!=''){
            var CheckDate=/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/;
            if(CheckDate.test(triage_fecha_nac)){
                SendAjaxPost({
                    fechaNac:triage_fecha_nac,
                    csrf_token:csrf_token
                },'Triage/AjaxObtenerEdad',function (response) {
                    $('.Error-Formato-Fecha').addClass('hide');
                    $('.paciente-edad').html(response.Anios+' Años').removeClass('hide');
                    if(response.Anios<15){
                        $('.paciente-tipo').html('PEDIATRICO').removeClass('hide');
                    }else if(response.Anios>15 && response.Anios<60){
                        $('.paciente-tipo').html('ADULTO').removeClass('hide');
                    }else if(response.Anios>60){
                        $('.paciente-tipo').html('GERIATRICO').removeClass('hide');
                    }  
                },'No')
                     
            }else{
                $('.Error-Formato-Fecha').removeClass('hide').find('h2').html('FORMATO DE FECHA NO VÁLIDO ESPECIFIQUE UN FORMATO DE FECHA VÁLIDO (EJEMPLO: 05/02/1993)')
            }  
        }
    });
    $('select[name=triage_paciente_sexo]').val($('select[name=triage_paciente_sexo]').attr('data-value'));
    /*SI EL MODULO ENFERMERIA TRIAGE HORA CERO ESTA HABILITADO*/
    $('.btn-horacero-enfermeria').click(function (e) {
        e.preventDefault();
        SendAjaxGet("Horacero/GenerarFolio",function (response) {
            if(response.accion=='1'){
                location.href=base_url+'Triage/Paciente/'+response.max_id+'/?via=EnfermeriaHoraCero'
            }
        })
    })
    $('input[name=motivoAtencion][value="'+$('input[name=motivoAtencion]').data('value')+'"]').prop("checked",true);
    /* Elemento para editar datos de paciente en choque */
    $('.edit_paciente').on('click',function(e){
        e.preventDefault();
        bootbox.confirm({
            title:'<h5>REGISTRO DE PACIENTE EN ESTADO DE ATENCIÓN URGENTE</h5>',
            message:'<div class="row">'+
                '<div class="col-md-12">'+
                    '<div class="form-group">'+
                        '<select class="form-control" id="triage_tipo_paciente" name="triage_tipo_paciente" required>'+
                            '<option value="">SELECCIONAR CONDICIÓN...</option>'+
                            '<option value="Identificado">IDENTIFICADO</option>'+
                            '<option value="No Identificado" selected>NO IDENTIFICADO</option>'+
                        '</select>'+
                    '</div>'+
                    '<div class="form-group form-identificado hide">'+
                        '<label><b>PROCEDENCIA ESPONTANEA</b></label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="pia_procedencia_espontanea" value="Si" checked>'+
                            '<i class="blue"></i>Si'+
                        '</label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="pia_procedencia_espontanea" value="No" >'+
                            '<i class="blue"></i>No'+
                        '</label>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12">'+
                    '<div class="form-group form-espontaneo form-no-identificado ">'+
                        '<input name="pia_procedencia_espontanea_lugar" type="text" placeholder="Lugar de Procedencia"  class="form-control" required>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-no-espontanea hide">'+
                        '<select name="pia_procedencia_hospital"  class="form-control">'+
                            '<option value="UMF">UMF</option>'+
                            '<option value="HGZ">HGZ</option>'+
                            '<option value="UMAE">UMAE</option>'+
                        '</select>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-no-espontanea hide">'+
                        '<input name="pia_procedencia_hospital_num"  type="text" placeholder="NOMBRE/NUMERO DEL HOSPITAL"  class="form-control">'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12"></div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-identificado hide">'+
                        '<input name="triage_nombre_ap"  type="text" placeholder="Apellido Paterno"  class="form-control" required>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group form-identificado hide">'+
                        '<input name="triage_nombre_am"  type="text" placeholder="Apellido Materno"  class="form-control" required>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12">'+
                    '<div class="form-group form-identificado hide">'+
                        '<input name="triage_nombre"  type="text" placeholder="Nombre del Paciente"  class="form-control" required>'+
                    '</div>'+
                    '<div class="form-group form-no-identificado ">'+
                        '<input name="triage_nombre_pseudonimo" type="text" placeholder="Pseudonimo del Paciente"  class="form-control" required>'+
                    '</div>'+
                    '<div class="form-group form-identificado hide">'+
                        '<label><b>Cuenta con N.S.S</b></label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="triage_paciente_afiliacion_bol" value="Si" >'+
                            '<i class="blue"></i>Si'+
                        '</label>&nbsp;&nbsp;'+
                        '<label class="md-check">'+
                            '<input type="radio" name="triage_paciente_afiliacion_bol" value="No" checked="">'+
                            '<i class="blue"></i>No'+
                        '</label>'+
                    '</div>'+
                    '<div class="form-group form-identificado-nss hide">'+
                        '<div class="row">'+
                            '<div class="col-md-6" style="padding-right:2px">'+
                                '<input name="pum_nss" type="text" placeholder="N.S.S"  class="form-control item" required>'+
                            '</div>'+
                            '<div class="col-md-6" style="padding-left:2px">'+
                                '<input name="pum_nss_agregado" type="text" placeholder="N.S.S AGREGADO"  class="form-control" required>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group form-no-paciente">'+
                        '<select class="form-control" name="triage_paciente_sexo" required>'+
                            '<option value="">SELECCIONAR SEXO</option>'+
                            '<option value="HOMBRE">HOMBRE</option>'+
                            '<option value="MUJER">MUJER</option>'+
                        '</select>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<input name="triage_fecha_nac_a" type="text" placeholder="Año de Nac. Ejemplo: 1990"  class="form-control dd-mm-yyyy" required>'+
                    '</div>'+
                '</div>'+
            '</div>'
        });
        });
    
    if($('input[name=triage_paciente_afiliacion_bol]').prop('checked')){
        $('.input-identificado-nss').removeClass('hide');
         
    }else {
         $('#divNssConformado').removeClass('hide');
         $('input[name=pum_nss]').removeAttr('required');
         $('#umf').addClass('hide');
         $('#delegacion').addClass('hide');   
         $('input[name=pum_nss]').removeAttr('required');
         $('input[name=pum_nss_agregado]').removeAttr('required');
    }

    $('body input[name=triage_paciente_afiliacion_bol]').click(function (e) {
        if($(this).val()=='No'){
            $('#divNssConformado').removeClass('hide');
            $('body .input-identificado-nss').addClass('hide');
            $('#umf').addClass('hide');
            $('#delegacion').addClass('hide');
            $('input[name=pum_nss]').removeAttr('required');
            $('input[name=pum_nss_agregado]').removeAttr('required');
            $('input[name=pum_nss_armado]').attr('required',true);
            console.log($('input[name=pum_nss_armado]').attr('required'));
        }else{
            $('body .input-identificado-nss').removeClass('hide');
            $('#divNssConformado').addClass('hide');
            $('#umf').removeClass('hide');
            $('#delegacion').removeClass('hide');
            $('#fechaNacConformado').remove();
            $('input[name=pum_nss]').attr('required',true);
            $('input[name=pum_nss_agregado]').attr('required',true);
            $('input[name=pum_nss_armado]').removeAttr('required');
        } 
    });
// http://localhost/sih/Triage/Paciente/91/?via=EnfermeriaHoraCero
    $('.guardar-triage-enfermeria').submit(function (e) {
    //$('.guardar-triage-enfermeria').
        e.preventDefault();
        //if(verificarEnvio()) 
            SendAjaxPost($(this).serialize(),"Triage/EnfemeriatriageGuardar",function (response) {
                msj_success_noti('DATOS GUARDADOS')
                var triage_id = $('input[name=triage_id]').val();
                if($('input[name=via]').val()!=''){
                    if($('input[name=via]').val()=='medicoTRHoraCero') {
                        //window.open(base_url+'Triage/Paciente/'+triage_id);
                        location.href=base_url+'Triage/Paciente/'+triage_id;
                    }else {
                            AbrirDocumento(base_url+'Horacero/GenerarTicket/'+$('input[name=triage_id]').val());
                            history.go(-1);
                         }
                }else{
                    ActionCloseWindowsReload();
                }
            });
    });
    
    function verificarEnvio() {
       var nssArmado_attr = $('input[name=pum_nss_armado]').attr('required');
        if(nssArmado_attr =='required' || $('input[name=pum_nss_armado]').val()== '') {
            bootbox.alert({
                title:  "<center>¡ Advertencia !</center>",
                message:"<center><h4>Debe generar el NSS armado</h4></center>",
                size:   "medium"
            });
           return false;
        }else return true;
    }

});