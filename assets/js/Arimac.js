$(document).ready(function(){
    function passDate(fecha) {
        $('#tableRegistros').DataTable({
            ajax:{
                    url:base_url+"Arimac/ListaControlExpedientes",
                    type:"POST",
                    data: { fecha:fecha,
                            csrf_token:csrf_token
                          },
                    dataSrc: 'data'
                    },
            columns: [
                      
                        {"data": "folio", "className": "text-left"},
                        {"data": "servicio","className": "text-left"},
                        {"data": "estado","className": "text-left"},
                        {"data": "accion","className": "text-center"}
                    ],
             columnDefs: [

                            {
                            "targets": [0], 
                            "data": "folio",
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;'><b><i class='fa fa-file-text'></i>  &nbsp;"+data+"</b></span><br>"+
                                       "<span style='color:#006699;'><i class='fa fa-address-card-o'></i> &nbsp;"+row.afiliacion+"</span><br>"+
                                       "<span style='color:#006699;'><b><i class='fa fa-user'></i>  &nbsp;"+row.nombre_paciente+"</b></span><br>";
                                }
                            },
                            
                            {
                            "targets": [1], 
                            "data": "servicio", 
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;text-transform: uppercase'><i class='fa fa-medkit'></i> &nbsp;"+data+"</span><br>"+
                                "<span style='color:#008F39;'><i class='fa fa-user-md'></i> &nbsp;"+row.usuario+"</span>";
                                }
                            },

                            {
                            "targets": [2], 
                            "data": "estado", 
                            "render": function(data, type, row) {
                                return ""+data+"";
                                /*"<span style='color:#E60026;text-transform: uppercase'><b><i class='fa fa-hourglass-1'></i> &nbsp;"+data+"</b></span><br>"+
                                       "<span style='color:#006699;'><i class='fa fa-calendar'></i> &nbsp;"+row.fecha_salida+"</span>";*/
                                }
                            },
                            {
                            "target": [3],
                            "data"  : "accion",
                            "render": function (data,type,row) {
                                return ""+data+"";
                                }
                            }

                        ],
            dom: 'flBrtip',
                buttons: [
                    {
                        'extend': 'excel',
                                                 'text': 'Exportar', // Definir el texto del botón de exportación de Excel

                    }
                ]
                
        });
    }
    function init_InputMask() {          
        if( typeof ($.fn.inputmask) === 'undefined'){ return; }        
         $(":input").inputmask();             
     }
     
    function verificarNss(nss_acceder, nss_umae) {
        SendAjaxPost(
                {
                    nss:nss_acceder,
                    csrf_token:csrf_token
                },
                'Sections/VigenciaWs/AjaxVigenciaAcceder',
                function (response) {
                    if(response.codigoError=='2'){
                        msj_error_noti('NO EXISTE EL NSS SOLICITADO');
                    }else{ 
                        var Respuesta='';
                        Respuesta+='<table class="table table-bordered table-striped table-no-padding">';
                        Respuesta+= ' <thead>';
                        Respuesta+='   <tr>';
                        Respuesta+='     <th>TIPO</th><th>NOMBRE</th><th>NSS</th><th>VIGENTE</th><th>Selecionar</th>';
                        Respuesta+='   </tr>';
                        Respuesta+=' </thead';
                        Respuesta+=' <tbody>';
                        $.each(response,function (i,e) {
                            Respuesta+='    <tr>';
                            Respuesta+='        <td>'+(e.mensajeError!=undefined ? 'TITULAR':'BENEFICIARIO')+'</td>';
                            Respuesta+='        <td>'+e.Nombre+' '+e.Paterno+' '+e.Materno+'</td>';
                            Respuesta+='        <td>'+e.Nss+' '+e.AgregadoMedico+'</td>';
                            Respuesta+='        <td>'+e.ConDerechoSm+'</td>';
                            Respuesta+='        <td class="text-center"><label class="md-check">';
                            Respuesta+='            <input type="radio" name="SelectPacienteNss"';
                            Respuesta+='                data-nss="'+e.Nss+'"';
                            Respuesta+='                data-agregado="'+e.AgregadoMedico+'"';
                            Respuesta+='                data-nombre="'+e.Nombre+'"';
                            Respuesta+='                data-ap="'+e.Paterno+'"';
                            Respuesta+='                data-am="'+e.Materno+'"';
                            Respuesta+='                data-vigencia="'+e.ConDerechoSm+'"';
                            Respuesta+='                data-fechanac="'+e.FechaNacimiento+'"';
                            Respuesta+='                data-sexo="'+(e.Sexo=='F'?'MUJER':'HOMBRE')+'"';
                            Respuesta+='                data-umf="'+e.DhUMF+'"';
                            Respuesta+='                data-delegacion="'+e.DhDeleg+'"';
                            Respuesta+='                data-curp="'+e.Curp+'"';
                            Respuesta+='                data-direccion="'+e.Direccion+'"';
                            Respuesta+='                data-localidad="'+e.Colonia+'"';
                            Respuesta+='                data-consultorio="'+e.Consultorio+'"';
                            Respuesta+='            ><i class="back-imss"></i></label>'
                            Respuesta+='        </td>';
                            Respuesta+='    </tr>';
                        });   
                        Respuesta+=' </tbody>';
                        Respuesta+='</table>';

                        bootbox.confirm({
                            title:'<h5>VIGENCIA ACCEDER</h5>',
                            message:'<div class="row"><div class="col-md-12">'+Respuesta+'</div></div>',
                            size:'large',
                            buttons:{
                                cancel:{
                                    label:'Cancelar',
                                    className:'btn-imss-cancel'
                                },confirm:{
                                    label:'Aceptar',
                                    className:'back-imss'
                                    }
                                },
                            callback:function (result) {
                                if(result==true){
                                    var SelectNss=$('body input[name=SelectPacienteNss]:checked');
                                    var nombre      = SelectNss.attr('data-nombre'),
                                        paterno     = SelectNss.attr('data-ap'),
                                        materno     = SelectNss.attr('data-am'),
                                        nacimiento  = SelectNss.attr('data-fechanac'),
                                        curp        = SelectNss.attr('data-curp'),
                                        nss         = SelectNss.attr('data-nss'),
                                        agregado    = SelectNss.attr('data-agregado'),
                                        vigencia    = SelectNss.attr('data-vigencia'),
                                        delegacion  = SelectNss.attr('data-delegacion'),
                                        umf         = SelectNss.attr('data-umf'),
                                        sexo        = SelectNss.attr('data-sexo'),
                                        localidad   = SelectNss.attr('data-localidad'),
                                        direccion   = SelectNss.attr('data-direccion');
                                        long_direcc = direccion.length,
                                        cp          = direccion.substring(long_direcc-5,long_direcc);
                                    if(SelectNss.length==1){
                                        $('.dataPaciente').removeClass('hidden');
                                        
                                        $('input[name=nss]').val('');
                                        $("input[name = nss_umae]").val(nss_umae);
                                        $("input[name = nss_agregado]").val(agregado);
                                        $("input[name = pia_vigencia]").val(vigencia);
                                        $("input[name = delegacion]").val(delegacion);
                                        $("input[name = umf]").val(umf);
                                        $("input[name = curp]").val(curp);
                                        $("input[name = nombre_ap]").val(paterno);
                                        $("input[name = nombre_am]").val(materno);
                                        $("input[name = nombre]").val(nombre);
                                        $("input[name = fechaNac]").val(nacimiento);
                                        $("select[name =sexo]").val(sexo);
                                        $("input[name = cp]").val(cp);
                                        $("input[name = municipio]").val(localidad);

                                    }else{
                                        msj_error_noti('SELECCIONAR UN REGISTRO DE LA LISTA')
                                    }
                                }
                            }

                        });
                    }
                }
            );
    }

    function GuardarExpedienteAsignado(idFolio,idServ, idPer, obs) {
        $.ajax({
            url: base_url+"Arimac/GuardarExpedienteAsignado",
            dataType: 'json',
            type: 'POST',
            data: { idFolio: idFolio, 
                    idServ : idServ, 
                    idPer  : idPer,
                    obs    : obs,
                    csrf_token: csrf_token
            },
            beforeSend: function (xhr) {
                msj_loading();
            },
            success: function (data, textStatus, jqXHR) {
                if(data.accion=='1') {
                    location.reload();
                    
                }else {
                    bootbox.hideAll();
                    bootbox.alert({
                        title:  '<center>¡ Advertencia !</center>',
                        message:'<center><h4>El expediente esta ocupado</h4></center><br>'+
                                 '<div class="col-md-12">'+
                                    '<h5 style="line-height: 1.4;margin-top:5px"><b>Paciente: </b>'+data.info.nombre_paciente+'</h5>'+
                                    '<h5 style="line-height: 1.4;margin-top: 10px"><b>Folio Expediente: </b>'+data.info.folio+'</b></h5>'+
                                    '<h5 style="line-height: 1.4;margin-top: 10px"><b>Fecha de petición: </b>'+data.info.fecha_peticion+'</b></h5>'+
                                    '<h5 style="line-height: 1.4;margin-top: 10px"><b>Servicio: </b>'+data.info.servicio+'</b></h5>'+
                                    '<h5 style="line-height: 1.4;margin-top: 10px"><b>Personal: </b>'+data.info.usuario+'</b></h5>'+
                                 '</div>',
                    })
                    return false;
                }
            },
            error: function (e) {
                bootbox.hideAll();
                console.log(e);
                MsjError();
                //msj_error_noti('SELECCIONAR UN REGISTRO DE LA LISTA');
            }
        });
    }

    function LiberarExpediente(idsolicitud,fecha){
        SendAjaxPost({idsolicitud:idsolicitud,csrf_token:csrf_token}, 'Arimac/LiberarExpediente',
            function(response){
                if(response.accion==1){
                    console.log(fecha);
                    passDate(fecha);
                    msj_success_noti('Expediente Liberado con Exito');
                }
            }
        );
           
    }
    function convertDateFormat(string) {
        let dateSplit = string.split(" ");
        let dateSplit2 = dateSplit[0].split("-");
        let formattedDate = dateSplit2.reverse().join('-');
        let time = dateSplit[1];
        //return info[2] + '/' + info[1] + '/' + info[0];
        return `${formattedDate} ${time}`;
    }
    init_InputMask();
    
    $('.form-expediente').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:base_url+'Arimac/AjaxExpediente',
            type:'POST',
            dataType:'json',
            data:$(this).serialize(),
            beforeSend:function(e){
                msj_loading();
            },success:function(data){
                bootbox.hideAll();
                AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ExpedienteAmarilloBack/'+$('input[name=triage_id_val]').val(),'back',100);
                AbrirDocumento(base_url+'Inicio/Documentos/ExpedienteAmarillo/'+$('input[name=triage_id_val]').val());
                
            },error:function(e){
                bootbox.hideAll;
                MsjError();
            }
        })
    })
    /* Verificar NSS en la umae *
     * Buscar NSS                */
    $('input[name=nss]').focus();
    $('input[name=nss]').keyup(function (e){
        //let nss = $('input[name=nss]').val();
        let nss = $('input[name=nss]').inputmask('unmaskedvalue');
        let nss_acceder = nss.substring(0,10);
        if(nss.length ==11 && nss!=''){
            SendAjaxPost(
                {
                    nss:nss,
                    csrf_token:csrf_token
                },
                'Arimac/BuscarPacienteUmae',
                function (response){
                    if(response.accion=='2'){
                        //msj_error_noti('NO EXISTE EL NSS SOLICITADO');
                        bootbox.confirm({
                            message: '<h4 class="text-left">Paciente no Encontrado en registro,'+ 
                                     '¿Desea agregar nuevo paciente para apertura de expediente?</h4>'+
                                     '<div class="text-center">Número de Afiliación</div>'+
                                     '<h3 class="text-center">'+nss+'</h3>',
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
                                    verificarNss(nss_acceder,nss);
                                }
                            }
                        })
                    }else { /* se encuantra ergistrado el paciente */
                        var Respuesta='';
                            Respuesta+='<table class="table table-bordered table-striped table-no-padding">';
                            Respuesta+= ' <thead>';
                            Respuesta+='   <tr align="center">';
                            Respuesta+='     <th>Folio</th><th>Nombre</th><th>NSS</th><th>CURP</th> <th>Seleccionar</th>';
                            Respuesta+='   </tr>';
                            Respuesta+=' </thead';
                            Respuesta+=' <tbody>';
                            $.each(response.info, function (i,elem) {
                                Respuesta+=' 	<tr>';
                                Respuesta+='    	<td>'+elem.idPaciente+'</td>';
                                Respuesta+='		<td>'+elem.nombre+' '+elem.apellidop+' '+elem.apellidom+'</td>';
                                Respuesta+='		<td>'+elem.nssCom+'</td>';
                                Respuesta+='		<td>'+elem.curp+'</td>';
                                Respuesta+='		<td class="text-center"><label class="md-check">';
                                Respuesta+='			<input type="radio" name="selectPaciente"';
                                Respuesta+='				data-nss="'+elem.nss+'"';
                                Respuesta+='				data-agregado="'+elem.agregado+'"';
                                Respuesta+='				data-nombre="'+elem.nombre+'"';
                                Respuesta+='				data-ap="'+elem.apellidop+'"';
                                Respuesta+='				data-am="'+elem.apellidom+'"';
                                Respuesta+='				data-fechanac="'+elem.fechaNac+'"';
                                Respuesta+='				data-sexo="'+elem.sexo+'"';
                                Respuesta+='				data-umf="'+elem.umf+'"';
                                Respuesta+='				data-delegacion="'+elem.deleg+'"';
                                Respuesta+='				data-curp="'+elem.curp+'"';
                                Respuesta+='                data-telefono="'+elem.telefono+'"';
                                Respuesta+='                data-localidad="'+elem.colonia+'"';
                                Respuesta+='                data-folioExp="'+elem.idPaciente+'"';
                                Respuesta+='                data-umf="'+elem.umf+'"';
                                Respuesta+='                data-fecha_reg="'+elem.fechaReg+'"';
                                //Respuesta+='                data-usuario_registra="'+elem.usuario_registra+'"';
                                Respuesta += '              data-usuario_registra="' + elem.empleado_nombre + ' '+elem.empleado_apellidos+'"';
                                Respuesta+='            ><i class="back-imss"></i></label>'
                                Respuesta+='		</td>';
                                Respuesta+='	</tr>';
                            });   
                            Respuesta+=' </tbody>';
                            Respuesta+='</table>';

                            bootbox.confirm({
                                title:'<h5>Paciente(s) encontrado(s) en la UMAE</h5>',
                                message:'<div class="row"><div class="col-md-12">'+Respuesta+'</div></div>'+
                                        '<div class="row"><div class="col-md-12">'+
                                        '<button type="button" class="btn btn-success" id="btnOtroNSS" >Agregar otro beneficiario</button>'+
                                        '</div></div>',
                                size:'large',
                                buttons:{
                                    cancel:{
                                        label:'Cancelar',
                                        className:'btn-imss-cancel'
                                    },confirm:{
                                        label:'Aceptar',
                                        className:'back-imss'
                                        }
                                    },
                                callback:function (result) {
                                    /* si se seleccinna un paciente */
                                    if(result){
                                        var SelectPac=$('body input[name=selectPaciente]:checked');
                                        var nombre      = SelectPac.attr('data-nombre'),
                                            paterno     = SelectPac.attr('data-ap'),
                                            materno     = SelectPac.attr('data-am'),
                                            fnacimiento = SelectPac.attr('data-fechanac'),
                                            curp        = SelectPac.attr('data-curp'),
                                            nss_umae    = SelectPac.attr('data-nss'),
                                            agregado    = SelectPac.attr('data-agregado'),
                                            vigencia    = SelectPac.attr('data-vigencia'),
                                            delegacion  = SelectPac.attr('data-delegacion'),
                                            umf         = SelectPac.attr('data-umf'),
                                            sexo        = SelectPac.attr('data-sexo'),
                                            telefono    = SelectPac.attr('data-telefono'),
                                            noExpediente= SelectPac.attr('data-folioExp'),
                                            umf         = SelectPac.attr('data-umf'),
                                            fecha_reg   = SelectPac.attr('data-fecha_reg'),
                                            usuario_reg = SelectPac.attr('data-usuario_registra');              
                                        if(SelectPac.length==1){
                                            let fecha_registro = convertDateFormat(fecha_reg);
                                            if(sexo=='HOMBRE') {
                                                avatar = '<img src="'+base_url+'assets/img/perfiles/patient_male.png" class="media-object" style="width:60px"></img>';
                                                //console.log(avatar);
                                            } else {
                                                 avatar = '<img src="'+base_url+'assets/img/perfiles/patient_female.png" class="media-object" style="width:60px"></img>';
                                            }
                                            $('.infoPaciente').removeClass('hidden');
                                            $("input[name = nss_umae]").val(nss_umae);
                                            $("input[name = nss_agregado]").val(agregado);
                                            $("input[name = pia_vigencia]").val(vigencia);
                                            $("input[name = delegacion]").val(delegacion);
                                            $("input[name = umf]").val(umf);
                                            $("input[name = telefono]").val(telefono);
                                            $("input[name = curp]").val(curp);
                                            $("input[name = nombre_ap]").val(paterno);
                                            $("input[name = nombre_am]").val(materno);
                                            $("input[name = nombre]").val(nombre);
                                            $("input[name = fechaNac]").val(fnacimiento);
                                            $("select[name = sexo]").val(sexo);
                                            $("input[name = noExpediente]").val(noExpediente);

                                            $('.nomPaciente').html(`${paterno} ${materno} ${nombre} `);
                                            $('.noExpediente').html(`Folio: ${noExpediente}`);
                                            $('.nss-agregado').html(`${nss_umae} ${agregado}`);
                                            $('.umf_delg').html(`UMF: ${umf} Delegación:${delegacion}`);
                                            $('.umf').html(umf);
                                            $('.deleg').html(delegacion);
                                            $('.curp').html(curp);
                                            $('.tel').html(telefono);
                                            $('.fecha_registro_usuario').html(`<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> ${fecha_registro} por ${usuario_reg}`);
                                            $('.avatar').html(avatar);
                                            $(".imprime").attr("data-id",noExpediente);
                                            $("input[name = nss]").val('');

                                        }else{
                                            msj_error_noti('SELECCIONAR UN REGISTRO DE LA LISTA')
                                        }
                                    }
                                }
    
                            });
                            $('body #btnOtroNSS').click(function(){
                                bootbox.hideAll();
                                verificarNss(nss_acceder,nss);
                            })
                            
                    }
                }
            );
        }
    })
    /* Verificar Folio/Número de Expediente */
    $('input[name=id_paciente]').focus();
    $('input[name=id_paciente]').keyup(function (e){
        let idPaciente=$(this).val();
        
        if(idPaciente.length==11 && idPaciente!=''){
            $.ajax({
                url: base_url+"Arimac/Buscarexpediente",
                dataType: 'json',
                type: 'POST',
                data:{
                        id_paciente:idPaciente,
                        csrf_token:csrf_token
                        },
                beforeSend: function (xhr) {
                            msj_loading();
                        },
                success: function (data, textStatus, jqXHR) {
                            bootbox.hideAll();
                            if(data.accion=='1' ){
                                bootbox.confirm({
                                    title: "<h5>Información del Paciente</h5>",
                                    message: '<div class="row" style="margin-top:-10px">'+
                                                '<div class="col-md-12">'+
                                                    '<h4 style="line-height: 1.4;margin-top:5px"><b>Paciente: </b>'+data.info.apellidop+' '+data.info.apellidom+' '+data.info.nombre+'</h4>'+
                                                    '<h5 style="line-height: 1.4;margin-top: 10px"><b>Folio: </b>'+data.info.idPaciente+'</b></h5>'+
                                                    '<h5 style="line-height: 1.4;margin-top:10px"><b>Servicio solicitante: </b><select id="servicio" style="width:50%">'+data.servicios+'</select></h5>'+
                                                    '<h5 style="line-height: 1.4;margin-top:10px"><b>Persona Solicitante: </b>'+
                                                        '<select id="persona" style="width:50%">'+                                                            
                                                        '</select>'+
                                                    '</h5>'+                                      
                                                    '<h5 style="line-height: 1.4;margin-top:10px"><b>Observaciones: </b>'+
                                                        '<input name="obs" class="form-control" type="text" id="obs" placeholder="Observación ó comentario ">'+
                                                    '</h5>'+                        
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
                                            let folioExp = data.info.idPaciente;                                    
                                            let servicio =$('body #servicio').val();
                                            let personaSolicitante = $('body #persona').val();
                                            let obs = $('body #obs').val();
                                           
                                            if(servicio == 0) {
                                                bootbox.alert({
                                                    title:  "<center>¡ Advertencia !</center>",
                                                    message:"<center><h4>Debe de indicar un Servicio Solicitante</h4></center>",
                                                    size:   "medium"
                                                })
                                                return false;
                                            }else if(personaSolicitante == null){
                                                bootbox.alert({
                                                    title:  "<center>¡ Advertencia !</center>",
                                                    message:"<center><h4>Debe indicar el Usuario que solicita el expediente</h4></center>",
                                                
                                                })
                                                return false;
                                            }else {
                                                GuardarExpedienteAsignado(folioExp,servicio,personaSolicitante,obs);
                                            }
                                        }
                                    
                                    }
                                });
                                $("body #servicio").on('change', function () {
                                    $("#servicio option:selected").each(function () {
                                        let id_servicio=$(this).val();
                                        console.log(id_servicio);
                                        
                                        $.ajax({
                                            url : base_url+'Arimac/getPersonas',
                                            type : 'POST',
                                            data : {
                                                    id_servicio: id_servicio,
                                                    csrf_token:csrf_token,
                                                },
                                            dataType : 'json',
                                            success : function(data, textStatus, jqXHR) {
                                                //alert(data);
                                              $("#persona").html(data);
                                            },
                                            error : function(e) {
                                                    alert('Error en el proceso de consulta');
                                            }
                                        });
                                    });
                                        
                                });
                        
                            }else if(data.accion=="2"){
                                //bootbox.hideAll();
                                bootbox.confirm({
                                    title:  '<center>¡ Advertencia !</center>',
                                    message:'<h4><center>El expediente esta prestado</center></h4>'+
                                            '<div class="col-md-12">'+
                                                '<h5 style="line-height: 1.4;margin-top:5px"><b>Paciente: </b>'+data.info.nombre_paciente+'</h5>'+
                                                '<h5 style="line-height: 1.4;margin-top: 10px"><b>NSS: </b>'+data.info.afiliacion+'</b></h5>'+
                                                '<h5 style="line-height: 1.4;margin-top: 10px"><b>Folio Expediente: </b>'+data.info.folio+'</b></h5>'+
                                                '<h5 style="line-height: 1.4;margin-top: 10px"><b>Fecha de petición: </b>'+data.info.fecha_peticion+'</b></h5>'+
                                                '<h5 style="line-height: 1.4;margin-top: 10px"><b>Servicio: </b>'+data.info.servicio+'</b></h5>'+
                                                '<h5 style="line-height: 1.4;margin-top: 10px"><b>Solicitante: </b>'+data.info.usuario+'</b></h5>'+
                                            '</div>'+
                                            '<div class="col-md-12">'+
                                                '<h4><center>¿Desea liberarlo?</center></h4>'+
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
                                        let idsolicitud = data.info.idsolicitud;
                                        let fecha = data.info.fecha_peticion;                                   
                                        console.log(idsolicitud);
                                        LiberarExpediente(idsolicitud,fecha);
                                    } 
                                
                                }
                                
                                })
                            
                            }
                            
                            else msj_success_noti('No se encontró número de expediente');
                                  //MsjNotificacion('Ni se encontro número de expediente');
                        }
            });
            $(this).val('');
        } 
    })
    $('.ingreso_servicio').change(function(){
        let especialidad_id = $("select[name=ingreso_servicio]").val();
        $.ajax({
          url : base_url+'Admisionhospitalaria/GetMedicoEspecialista',
          type : 'POST',
          data : {
                  especialidad_id: especialidad_id,
                  csrf_token:csrf_token,
              },
          dataType : 'json',
          success : function(data, textStatus, jqXHR) {
              //console.log(data);
            $("#divMedicos").html(data);
          },
              error : function(e) {
                  alert('Error No hay Médicos Registrados');
              }
        });
    });

    $('body #btnVerificarNSS').click(function(){
		//var nss = $('input[name=nss]').val();
        let nss_umae = $('input[name=nss_umae]').inputmask('unmaskedvalue');

        if(nss_umae.length < 11 || nss_umae.length > 11 ){
            alert("El NSS debe estar conformado por 11 digitos");
         }else {
            let nss_acceder = nss_umae.substring(0,10); 
            verificarNss(nss_acceder,nss_umae);
            }
    });
    
    $('.registroPacienteUmae').submit(function (e){    
        e.preventDefault();
        console.log($(this).serialize())
        $.ajax({
            url: base_url+"Arimac/RegistroPacienteUmae",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
              bootbox.hideAll();
              if(data.accion=='1' ){
                
                //AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ImprimeAperturaExpedienteArimac/'+idFolio,'CaratulaExpediente',100);
                AbrirDocumento(base_url+'Inicio/Documentos/ImprimeAperturaExpedienteArimac/'+data.folio);
                window.location.href=base_url+'Arimac/Altapaciente';
                //window.history.back();
              }
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e);
              }
        }); // fin ajax
    });// fin 
    /* Libera el expediente asignado */
    $(document).on("click", "#liberar", function(){
        let idsolicitud = $(this).attr('data-id');
        let fecha = document.getElementById("fecha").value;         
        bootbox.confirm({
            message: '<h4 class="text-center">¿Desea liberar el expediente?',
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
                   LiberarExpediente(idsolicitud,fecha);            
                }
            }
        })
    })

    /* Eventos de  botones */
    $(document).on("click", ".editar", function () {
        bootbox.alert({
            title: "<center>¡ Advertencia !</center>",
            message: "<center><h4>Evento no habilitado por el momento</h4></center>",
            size: "medium"
        })
    });

    $(document).on("click", ".imprime", function () {
        AbrirDocumento(base_url+'Inicio/Documentos/ImprimeAperturaExpedienteArimac/'+$(this).attr('data-id'));
    });

    $(document).on("click", ".cerrar", function () {
        window.location.href = base_url + 'Arimac/Altapaciente';
    })
});