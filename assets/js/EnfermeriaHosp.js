$(document).ready(function (e) {
	$("#selectPiso").change(function(){
		var piso = $(this).val();
        $('.info-tabs').addClass('hide');
		AjaxCamasPiso(piso);
	});

    $('body').on('click','.cama-no',function(){
        var triage_id=$(this).attr('data-folio');
        var cama_id=$(this).attr('data-cama');
        var camaNombre= $(this).attr('data-cama_nombre');
        if($(this).hasClass('cyan-400')){
            triage_id = 0
            //console.log(triage_id, cama_id, camaNombre);
        }
        AjaxInfoPacienteCama(cama_id, triage_id, camaNombre);

    });

    
    /* acciones de botones para camas */
        /* 1=Reservado,
           2=Ocupado,
           3=Sucia,
           4=Contaminada,
           5=Descompuesta,
           6=Limpia,
           7=vestida=Disponible */
    $('body').on('click', '.btnAccion',function(){
        let cama_id= $(this).attr('data-cama');
        let folio  = $(this).attr('data-folio');
        let accion = $(this).attr('data-accion');
      

        switch (accion) {
          case '1':
            mensaje = '¿Confirmar el ingreso de paciente?';
            
            break;
          case '2':
            mensaje = '¿Desea cambiar a Ocupado?';
            
            break;
          case '3':
            mensaje = '¿Desea cambiar a cama Sucia?';
            
            break;
          case '4':
            mensaje = '¿Desea indicar cama Contaminada?';
            
            break;
          case '5':
            mensaje = '¿Desea indicar cama Descompuesta?';
            
            break;
          case '6':
            mensaje = '¿Confirmar cama Limpia?';
            break;
          case '7':
            mensaje = '¿Confirmar cama Vestida y hacer Disponible?';
            break;
          default:
            console.log('Lo lamentamos, por el momento no disponemos de ' + accion + '.');
        }

        bootbox.confirm({
            message : mensaje,
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
                            SolicitaCambioEstado(cama_id,accion,folio)  
                        }
                    }
        })
    }); 

	function AjaxCamasPiso(piso) {
        
        $.ajax({
            url: base_url+"Hospitalizacion/AjaxCamasPiso",
            type: 'POST',
            dataType: 'json',
            data: {
            	piso:piso,
            	csrf_token:csrf_token, 
            },
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('#camasTotal').html(data.Total);
                $('.visor-camas').html(data.Col);
                $('#piso').html(data.Piso+' '+ '<small style="padding-left: 100px;color:brown">'+
                                                'PA=Prealta&nbsp;&nbsp;&nbsp;&nbsp;'+
                                                'CC=Cambio de Cama&nbsp;&nbsp;&nbsp;&nbsp;'+
                                                'A=Alta&nbsp;&nbsp;&nbsp;&nbsp;'+
                                                'AC=Alta Cancelada</small>');
                $('#camasDisponibles').html(data.Disponibles);
                $('#camasOcupadas').html(data.Ocupadas);
                $('#camasSucias').html(data.Sucias);
                $('#camasDescompuestas').html(data.Descompuestas);
                $('#camasPrealta').html(data.Prealtas);

            },error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
            }
        })
    }

    function AjaxInfoPacienteCama(cama_id, triage_id, cama_name) {
        $.ajax({
            url:base_url+"Hospitalizacion/AjaxInfoPacienteCama",
            type: 'POST',
            dataType: 'JSON',
            data: {
                cama_id:cama_id,
                cama_name:cama_name,
                triage_id:triage_id,
                csrf_token:csrf_token
            },
            beforeSend: function(xhr) {                            
                msj_loading();
            },
            success: function(data, textStatus, jqXHR){
                bootbox.hideAll();
                $('.info-tabs').removeClass('hide');
                $('.container-info-cama').removeClass('hide');
                $('#dataPatient').html(data.infoPaciente);
                $('#nombreCama').html(data.infoCama);
                $('.buttons-estados').html(data.estados);
                console.log(data.estados);

            },error: function (e) {
                $('.container-info-cama').addClass('hide');
                //$('.info-tabs').addClass('hide');
                 msj_error_noti('No hay paciente en cama solicitada');
                 bootbox.hideAll();

                //msj_error_serve();
                
            }
        })  
    }

    function SolicitaCambioEstado(cama_id,accion,folio){
        //console.log(cama_id,accion,folio);
        $.ajax({
            url:base_url+"Hospitalizacion/SolicitaCambioEstado",
            type: 'POST',
            dataType: 'JSON',
            data: {
                cama_id : cama_id,
                accion: accion,
                triage_id:folio,
                csrf_token:csrf_token
            },
             beforeSend: function (xhr) {
                msj_loading();
            },
            success: function(data, textStatus, jqXHR){
                bootbox.hideAll();
                /*if(data.accion=='1'){
                    //console.log(data);
                    $('.buttons-estados').html(data.estadosbtns);
                    if($('.cama'+cama_id).hasClass('HOMBRE')){
                        $('.cama'+cama_id).removeClass('purple-300').addClass('blue-800');
                    }else $('.cama'+cama_id).removeClass('purple-300').addClass('pink-A100');                    
                }else if(data.accion=='2'){
                    //console.log(data);
                    $('.buttons-estados').html(data.estadosbtns);
                    if($('.cama'+cama_id).hasClass('HOMBRE')){
                        $('.cama'+cama_id).removeClass('cyan-400').addClass('blue-800');
                    }else $('.cama'+cama_id).removeClass('cyan-400').addClass('pink-A100');  
                }else if(data.accion=='3'){
                    $('.cama'+cama_id).removeClass('purple-300').addClass('pink-A100');
                }else if(data.accion=='4'){
                    if($('.cama'+cama_id).hasClass('blue-800')){
                        $('.cama'+cama_id).removeClass('blue-800').addClass('red-900');
                    }else $('.cama'+cama_id).removeClass('pink-A100').addClass('red-900');
                }else if(data.accion=='5'){ 
                    $('.buttons-estados').html(data.estadosbtns);
                    if($('.cama'+cama_id).hasClass('HOMBRE')){
                        $('.cama'+cama_id).removeClass('lime').addClass('blue-800');
                    }else $('.cama'+cama_id).removeClass('lime').addClass('pink-A100'); 
                }else if(data.accion=='7'){ 
                    $('.buttons-estados').html(data.estadosbtns);
                    if($('.cama'+cama_id).hasClass('cyan-400') ){
                        $('.cama'+cama_id).removeClass('cyan-400').addClass('green');

                    }
                }*/
                /*if(data.accion=='5'){ 
                    addNotaDescompuesta(cama_id);
                }*/
            },error: function (e) {
                msj_error_noti('problemas');
                //msj_error_serve();
                
            }
        })
         
    }


    function addNotaDescompuesta(){
        let camaId = $(this).attr('data-cama');
        let camaNombre = $(this).attr('data-cama_nombre');
        let empleado_id =  $('input[name=infoEmpleado]').val();
        console.log("addNotaDescompuesta")
        console.log(camaId)
        console.log(camaNombre)
        console.log(empleado_id)
        bootbox.prompt({
            title: "Selecciona la naturaleza del problema(s)",
            inputType: 'checkbox',
            inputOptions: [
            {text: 'Mecánico',
                value: 'Mecánico',},
            {text: 'Eléctrico',
                value: 'Eléctrico',},
            {text: 'Plomería',
                value: 'Plomería',},
            {text: 'Otros',
                value: 'Otros',}
            ],
            callback: function (resultCheckbox) {
                console.log(resultCheckbox);
                bootbox.prompt({
                    title: '<center><h4>Realiza una descripción del problema </h4></center>',
                    inputType: 'textarea',
                    callback: function (resultTextarea) {
                        console.log(resultCheckbox);
                        if (resultTextarea == null){
                            msj_success_noti("Nota no agregada");
                        }else if (resultTextarea != ""){
                            result = "";
                            if(resultCheckbox.length > 0){
                                result += "Tipo: \n"
                                for(var r in resultCheckbox){
                                    result += resultCheckbox[r] + " \n"
                                }
                            }
                            result += "Descripción: \n" + resultTextarea;
                            bootbox.alert({
                                message: result,
                                size: 'small'
                            });
                        }else{
                            msj_error_noti("No se escribe una descripción");
                        }
                    }
                });
            }
        });
    }
})