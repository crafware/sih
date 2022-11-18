$(document).ready(function () {
    function verificarNss(nss) {
        SendAjaxPost(
                {
                    nss:nss,
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
                        Respuesta+='     <th>TIPO</th><th>NOMBRE</th><th>NSS</th><th>VIGENTE</th> <th>Selecionar</th>';
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
                                        $("input[name = pum_nss_agregado]").val(agregado);
                                        $("input[name = pia_vigencia]").val(vigencia);
                                        $("input[name = pum_delegacion]").val(delegacion);
                                        $("input[name = pum_umf]").val(umf);
                                        $("input[name = triage_paciente_curp]").val(curp);
                                        $("input[name = triage_nombre_ap]").val(paterno);
                                        $("input[name = triage_nombre_am]").val(materno);
                                        $("input[name = triage_nombre]").val(nombre);
                                        $("input[name = triage_fecha_nac]").val(nacimiento);
                                        $("select[name = triage_paciente_sexo]").val(sexo);
                                        $("input[name = directorio_cp]").val(cp);
                                        $("input[name = directorio_municipio]").val(localidad);

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
    init_InputMask();
	$('#btnVerificarNSS').click(function(){
		//var nss = $('input[name=nss]').val();
        var pum_nss = $('input[name=pum_nss]').inputmask('unmaskedvalue');

        if(pum_nss.length < 11 || pum_nss.length > 11 ){
        alert("El NSS debe estar conformado por 11 digitos");
      }else {
            var nss = pum_nss.substring(0,10);
			SendAjaxPost(
				{
                    nss:nss,
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
                        Respuesta+='     <th>TIPO</th><th>NOMBRE</th><th>NSS</th><th>VIGENTE</th> <th>Selecionar</th>';
                        Respuesta+='   </tr>';
                        Respuesta+=' </thead';
                        Respuesta+=' <tbody>';
                        $.each(response,function (i,e) {

                            Respuesta+=' 	<tr>';
                            Respuesta+='    	<td>'+(e.mensajeError!=undefined ? 'TITULAR':'BENEFICIARIO')+'</td>';
                            Respuesta+='		<td>'+e.Nombre+' '+e.Paterno+' '+e.Materno+'</td>';
                            Respuesta+='		<td>'+e.Nss+' '+e.AgregadoMedico+'</td>';
                            Respuesta+='		<td>'+e.ConDerechoSm+'</td>';
                            Respuesta+='		<td class="text-center"><label class="md-check">';
                            Respuesta+='			<input type="radio" name="SelectPacienteNss"';
                            Respuesta+='				data-nss="'+e.Nss+'"';
                            Respuesta+='				data-agregado="'+e.AgregadoMedico+'"';
                            Respuesta+='				data-nombre="'+e.Nombre+'"';
                            Respuesta+='				data-ap="'+e.Paterno+'"';
                            Respuesta+='				data-am="'+e.Materno+'"';
                            Respuesta+='				data-vigencia="'+e.ConDerechoSm+'"';
                            Respuesta+='				data-fechanac="'+e.FechaNacimiento+'"';
                            Respuesta+='				data-sexo="'+(e.Sexo=='F'?'MUJER':'HOMBRE')+'"';
                            Respuesta+='				data-umf="'+e.DhUMF+'"';
                            Respuesta+='				data-delegacion="'+e.DhDeleg+'"';
                            Respuesta+='				data-curp="'+e.Curp+'"';
                            Respuesta+='                data-direccion="'+e.Direccion+'"';
                            Respuesta+='                data-localidad="'+e.Colonia+'"';
                            Respuesta+='                data-consultorio="'+e.Consultorio+'"';
                        	Respuesta+='            ><i class="back-imss"></i></label>'
                            Respuesta+='		</td>';
                            Respuesta+='	</tr>';
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
                                        $("input[name = pum_nss_agregado]").val(agregado);
                                        $("input[name = pia_vigencia]").val(vigencia);
                                        $("input[name = pum_delegacion]").val(delegacion);
                                        $("input[name = pum_umf]").val(umf);
                                        $("input[name = triage_paciente_curp]").val(curp);
                                        $("input[name = triage_nombre_ap]").val(paterno);
                                        $("input[name = triage_nombre_am]").val(materno);
                                        $("input[name = triage_nombre]").val(nombre);
                                        $("input[name = triage_fecha_nac]").val(nacimiento);
                                        $("select[name = triage_paciente_sexo]").val(sexo);
                                        $("input[name = directorio_cp]").val(cp);
                                        $("input[name = directorio_municipio]").val(localidad);

                                    }else{
                                        msj_error_noti('SELECCIONAR UN REGISTRO DE LA LISTA')
                                    }
                                }
                            }

                        });
                	}
			    }
			);//fin
		}
   });
    function init_InputMask() {          
    if( typeof ($.fn.inputmask) === 'undefined'){ return; }        
        $(":input").inputmask();             
    }

});
