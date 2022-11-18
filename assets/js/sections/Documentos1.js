var cont = 0;
var arrayViasAdministracion = ['(cerebelomedular)','Auricular (ótica)','Bolo Intravenoso','Bucal','campo eléctrico','Conjuntival','Cutánea','Dental',
'Electro-osmosis','En los ventrículos cerebrales','Endocervical','Endosinusial','Endotraqueal','Enteral','Epidural','Extra-amniótico',
'Gastroenteral','Goteo Intravenoso','In vitro','Infiltración','Inhalatoria','Intercelular','Intersticial','Intra corpus cavernoso',
'Intraamniótica','Intraarterial','Intraarticular','Intrabdominal','Intrabiliar','Intrabronquial','Intrabursal','Intracardiaca',
'Intracartilaginoso','Intracaudal','Intracavernosa','Intracavitaria','Intracerebral','Intracervical','Intracisternal','Intracorneal',
'Intracoronaria','Intracoronario','Intradérmica','Intradiscal','Intraductal','Intraduodenal','Intradural','Intraepidermal','Intraesofágica',
'Intraesternal','Intragástrica ','Intragingival','Intrahepática','Intraileal','Intramedular','Intrameníngea','Intramuscular','Intraocular',
'Intraovárica','Intrapericardial','Intraperitoneal','Intrapleural','Intraprostática','Intrapulmonar','Intrasinovial',
'Intrasinusal (senosparanasales)','Intratecal','Intratendinosa','Intratesticular','Intratimpánica','Intratoráxica','Intratraqueal',
'Intratubular','Intratumoral','Intrauterina','Intravascular','Intravenosa','Intraventricular','Intravesicular','Intravítrea','Iontoforesis',
'Irrigación','la túnica fibrosa del ojo)','Laríngeo','Laringofaringeal','médula espinal)','Nasal','Oftálmica','Oral','Orofaríngea',
'Otra Administración es diferente de otros contemplados en ésta lista','Parenteral','Párpados y la superficie del globo ocular',
'Percutánea','Periarticular','Peridura','Perineural','Periodontal','Por difusión','Rectal','Retrobulbal','Sistémico','Sonda nasogástrica',
'Subaracnoidea','Subconjuntival','Subcutánea','Sublingual','Submucosa','Técnica de vendaje oclusivo','Tejido blando','tejidos del cuerpo',
'Tópica','Transdérmica','Transmamaria','Transmucosa','Transplacentaria','Transtimpánica','Transtraqueal','Ureteral','Uretral',
'Uso Intralesional','Uso Intralinfático','Uso oromucosa','Vaginal','Vía a través de Hemodiálisis'];
 // Arreglo donde se almacenara los datos de cada prescripcion
var arrayPrescripcion = [];
    /* Almacena el Id del medicamento y las interacciones con las que se
    se relaciona*/
var arrayInteracciones = [];

var arrayAntibiotico = [];

$(document).ready(function () {
    // $('textarea[name=nota_cuidadosenfermeria]').data("wysihtml5").editor.setValue(cuidadosenfermeria);
    // $('textarea[name=nota_solucionesp]').data("wysihtml5").editor.setValue(solucionesp);
    $('.select2').select2();
    $('#aplicacion').clockpicker({
      placement: 'bottom',
      autoclose: true
    });
    /* Mascara para signos vitales */
    //$('input[name=sv_ta]').mask('999/990');
    //$('input[name=sv_temp]').mask('99');
    //$('input[name=sv_fc]').mask('999');
    //$('input[name=sv_fr]').mask('99');
    //$('input[name=sv_oximetria]').mask('99');
    //$('input[name=sv_dextrostix]').mask('999');
    //$('input[name=sv_peso]').mask('999');
    //$('input[name=sv_talla]').mask('999');
    $('#nota_interconsulta').val($('#nota_interconsulta').attr('data-value').split(',')).select2();
    // if($('input[name=accion]').val()!=undefined){  
    //$('#nota_interconsulta').val($('#nota_interconsulta').attr('data-value').split(',')).select2(); //divide cada seleccinado
    //$('#hf_procedimientos').val($('#hf_procedimientos').attr('data-value').split(',')).select2(); //divide cada procedimiento seleccinado  separado con comoa
    $('#procedimientos').val($('#procedimientos').attr('data-value').split(',')).select2();
    // }

    var triage_paciente_accidente_lugar=$('input[name=pia_lugar_accidente]').val();
    if(triage_paciente_accidente_lugar=='TRABAJO'){
        $('.col-hojafrontal-info').removeClass('hide');
        $('textarea[name=hf_motivo]').keyup(function (e){
            $('textarea[name=asistentesmedicas_da]').val($(this).val());
        })
        $('textarea[name=hf_exploracionfisica]').keyup(function (e){
            $('textarea[name=asistentesmedicas_dl]').val($(this).val());
        })
        $('textarea[name=hf_diagnosticos]').keyup(function (e){
            $('textarea[name=asistentesmedicas_ip]').val($(this).val());
        })
        $('textarea[name=hf_indicaciones]').keyup(function (e){
            $('textarea[name=asistentesmedicas_tratamientos]').val($(this).val());
        })
    }else{
        $('body .hojafrontal-info').removeAttr('required');
    }
    $('select[name=hf_especialidad]').val($('select[name=hf_especialidad]').attr('data-value'))
    $('input[name=po_donador]').click(function (e) {
        if($(this).val()=='Si'){
            $('.po_donador').removeClass('hide');
        }else{
            $('select[name=po_criterio]').val('');
            $('.po_donador').addClass('hide');
        }
    })
    if($('input[name=po_donador]').attr('data-value')!='' && $('input[name=po_donador]').attr('data-value')=='Si'){
        $('input[name=po_donador][value="Si"]').attr('checked',true);
        $('.po_donador').removeClass('hide');
        $('select[name=po_criterio]').val($('select[name=po_criterio]').attr('data-value'))
    }
    $('input[name=hf_intoxitacion]').click(function (e) {
        if($(this).val()=='No'){
            $('.hf_intoxitacion').addClass('hide');
            $('input[name=hf_intoxitacion_descrip]').val('');
        }else{
            $('.hf_intoxitacion').removeClass('hide');
        }
    })
    if($('input[name=hf_intoxitacion]').attr('data-value')!='' && $('input[name=hf_intoxitacion]').attr('data-value')=='Si'){
        $('input[name=hf_intoxitacion]').attr('checked',true);
        $('.hf_intoxitacion').removeClass('hide');
    }

    $('.guardar-solicitud-hf').submit(function (e){
        e.preventDefault();
        $.ajax({
            url: base_url+"Sections/Documentos/GuardarHojaFrontal",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if($('input[name=tipo]').val()=='Consultorios'){
                    if($('input[name=ce_status]').val()!='Salida'){
                        GuardarDarAlta($('input[name=triage_id]').val());
                    }else{
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaFrontalCE/'+$('input[name=triage_id]').val(),'Hola Frontal',100);
                        if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',500);
                        }if($('input[name=hf_ministeriopublico]:checked').val()=='Si'){
                            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/'+$('input[name=triage_id]').val(),'NMP',800);
                        }
                    }

                }else{
                    bootbox.hideAll();
                    AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaFrontalCE/'+$('input[name=triage_id]').val(),'Hola Frontal',100);
                    if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',500);
                    }if($('input[name=hf_ministeriopublico]:checked').val()=='Si'){
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/'+$('input[name=triage_id]').val(),'NMP',800);
                    }
                    ActionCloseWindowsReload();
                }
            },error: function (e) {
                bootbox.hideAll();
                msj_error_serve()
                ReportarError(window.location.pathname,e.responseText);
            }
        })
    })

    $('body').on('change','.sum-total-npt',function(){

          var aminoacido = $('.modal-aminoacido').val() == "" ? 0:  $('.modal-aminoacido').val(),
          dextrosa = $('.modal-dextrosa').val() == "" ? 0: $('.modal-dextrosa').val(),
          lipidos_intravenosos = $('.modal-lipidos-intravenosos').val() == "" ? 0: $('.modal-lipidos-intravenosos').val(),
          agua_inyectable = $('.modal-agua-inyectable').val() == "" ? 0: $('.modal-agua-inyectable').val(),
          cloruro_sodio = $('.modal-cloruro-sodio').val() == "" ? 0: $('.modal-cloruro-sodio').val(),
          sulfato_magnesio = $('.modal-sulfato-magnesio').val() == "" ? 0: $('.modal-sulfato-magnesio').val(),
          cloruro_potasio = $('.modal-cloruro-potasio').val() == "" ? 0: $('.modal-cloruro-potasio').val(),
          fosfato_potasio = $('.modal-fosfato-potasio').val() == "" ? 0: $('.modal-fosfato-potasio').val(),
          gluconato_calcio = $('.modal-gluconato-calcio').val() == "" ? 0: $('.modal-gluconato-calcio').val(),
          albumina = $('.modal-albumina').val() == "" ? 0: $('.modal-albumina').val(),
          heparina = $('.modal-heparina').val() == "" ? 0: $('.modal-heparina').val(),
          insulina_humana = $('.modal-insulina-humana').val() == "" ? 0: $('.modal-insulina-humana').val(),
          zinc = $('.modal-zinc').val() == "" ? 0: $('.modal-zinc').val(),
          mvi_adulto = $('.modal-mvi-adulto').val() == "" ? 0: $('.modal-mvi-adulto').val() ,
          oligoelementos = $('.modal-oligoelementos').val() == "" ? 0: $('.modal-oligoelementos').val(),
          vitamina = $('.modal-vitamina').val() == "" ? 0: $('.modal-vitamina').val(),
          sum_total_npt = parseInt(aminoacido) + parseInt(dextrosa) + parseInt(lipidos_intravenosos) + parseInt(agua_inyectable) + parseInt(cloruro_sodio) +
                          parseInt(sulfato_magnesio) + parseInt(cloruro_potasio) + parseInt(fosfato_potasio) + parseInt(gluconato_calcio) + parseInt(albumina) +
                          parseInt(heparina) + parseInt(insulina_humana) + parseInt(zinc) + parseInt(mvi_adulto) + parseInt(oligoelementos) + parseInt(vitamina);
          $("#vol_total_npt").text(sum_total_npt);
    });

    $('.btn_otra_via').click(function(){

      if($(this).val() === "1"){  //ver todas las vias
        $(this).val("0");

        ConsultarViasAdministracion();

      }else if($(this).val() === "0"){ //ver vias recomendadas
        $(this).val("1");
        $("#via").empty();
        var option = "<option value='0'></option>";
        $("#via").append(option);


        for(var x = 0; x < arrayViasAdministracion.length; x++){
          option = "<option value="+arrayViasAdministracion[x]+">"+arrayViasAdministracion[x]+"</option>";
          $("#via").append(option);
        }

      }

      $('#via').val('0').trigger('change.select2');
    });

    $('#radioAyuno').click(function(){
      $('#divSelectDietas').attr('hidden','true');
      $('#divOtraDieta').attr('hidden','true');
      $('#selectDietas').val('0');
      $('#inputOtraDieta').val('');
    });

    $('#radioDieta').click(function(){
      $('#divSelectDietas').removeAttr("hidden");
    });
    
    $('#selectDietas').change(function(){
      if($('#selectDietas').val() == 13){
        $('#divOtraDieta').removeAttr("hidden");
      }else{
        $('#divOtraDieta').attr("hidden",'true');
      }
    });
    
    $('#selectTomaSignos').change(function(){
      if( $(this).val() == '3' ){
        $('#divOtrasInidcacionesSignos').removeAttr('hidden');
      }else{
        $('#divOtrasInidcacionesSignos').attr('hidden','true');
      }
    });
    $('#checkCuidadosGenerales').change(function(){
      if($(this).is(':checked')){
        $('#listCuidadosGenerales').removeAttr('hidden');
        $('#labelCheckCuidadosGenerales').text('');
      }else{
        $('#listCuidadosGenerales').attr('hidden', 'true');
        $('#labelCheckCuidadosGenerales').text('SI');
      }
    });
    $('input[name=asistentesmedicas_incapacidad_am]').click(function (e){
        if($(this).val()=='Si'){
            $('input[name=asistentesmedicas_incapacidad_ga]').removeAttr('disabled');
        }else{
            $('input[name=asistentesmedicas_incapacidad_ga]').attr('disabled',true);
            $('input[name=asistentesmedicas_incapacidad_ga][value=No]').prop("checked",true).click();
        }
    })
    $('input[name=asistentesmedicas_incapacidad_ga]').click(function (e){
        if($(this).val()=='Si'){
            $('select[name=asistentesmedicas_incapacidad_tipo]').removeAttr('disabled').click();
            $('input[name=asistentesmedicas_incapacidad_folio]').removeAttr('readonly');
            $('input[name=asistentesmedicas_incapacidad_fi]').removeAttr('readonly');
            $('input[name=asistentesmedicas_incapacidad_da]').removeAttr('readonly');
        }else{
            $('input[name=asistentesmedicas_incapacidad_folio]').attr('readonly',true).val('');
            $('input[name=asistentesmedicas_incapacidad_fi]').attr('readonly',true).val('');
            $('input[name=asistentesmedicas_incapacidad_da]').attr('readonly',true).val('');
            $('select[name=asistentesmedicas_incapacidad_tipo]').attr('disabled',true).val('');
            $('input[name=asistentesmedicas_incapacidad_dias_a]').attr('type','hidden').val('');

        }
    });
    if($('input[name=asistentesmedicas_incapacidad_am]').attr('data-value')=='Si'){
        $('input[name=asistentesmedicas_incapacidad_ga]').removeAttr('disabled');
        $('input[name=asistentesmedicas_incapacidad_ga][value="'+$('input[name=asistentesmedicas_incapacidad_ga]').data('value')+'"]').prop("checked",true).click();
        $('select[name=asistentesmedicas_incapacidad_tipo]').val($('select[name=asistentesmedicas_incapacidad_tipo]').attr('data-value'));
    }
    if($('input[name=asistentesmedicas_incapacidad_ga]').attr('data-value')=='Si' && $('select[name=asistentesmedicas_incapacidad_tipo]').attr('data-value')=='Subsecuente'){
        $('input[name=asistentesmedicas_incapacidad_dias_a]').attr('type','text');
    }
    $('select[name=asistentesmedicas_incapacidad_tipo]').click(function () {
        if($(this).val()=='Subsecuente'){
            $('input[name=asistentesmedicas_incapacidad_dias_a]').attr('type','text');
        }else{
            $('input[name=asistentesmedicas_incapacidad_dias_a]').attr('type','hidden');
        }
    });
    /**/
    $('input[name=hf_intoxitacion][value="'+$('input[name=hf_intoxitacion]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_urgencia][value="'+$('input[name=hf_urgencia]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_atencion][value="'+$('input[name=hf_atencion]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_especialidad][value="'+$('input[name=hf_especialidad]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_mecanismolesion_ab][value="'+$('input[name=hf_mecanismolesion_ab]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_mecanismolesion_td][value="'+$('input[name=hf_mecanismolesion_td]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_mecanismolesion_av][value="'+$('input[name=hf_mecanismolesion_av]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_mecanismolesion_maquinaria][value="'+$('input[name=hf_mecanismolesion_maquinaria]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_mecanismolesion_mordedura][value="'+$('input[name=hf_mecanismolesion_mordedura]').data('value')+'"]').prop("checked",true);

    $('input[name=hf_quemadura_fd][value="'+$('input[name=hf_quemadura_fd]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_quemadura_ce][value="'+$('input[name=hf_quemadura_ce]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_quemadura_e][value="'+$('input[name=hf_quemadura_e]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_quemadura_q][value="'+$('input[name=hf_quemadura_q]').data('value')+'"]').prop("checked",true);

    $('input[name=hf_trataminentos_curacion][value="'+$('input[name=hf_trataminentos_curacion]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_trataminentos_curacion][value="'+$('input[name=hf_trataminentos_curacion]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_trataminentos_sutura][value="'+$('input[name=hf_trataminentos_sutura]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_trataminentos_vendaje][value="'+$('input[name=hf_trataminentos_vendaje]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_trataminentos_ferula][value="'+$('input[name=hf_trataminentos_ferula]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_trataminentos_vacunas][value="'+$('input[name=hf_trataminentos_vacunas]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_ministeriopublico][value="'+$('input[name=hf_ministeriopublico]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_expontanea][value="'+$('input[name=hf_glasgow_expontanea]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_hablar][value="'+$('input[name=hf_glasgow_hablar]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_dolor][value="'+$('input[name=hf_glasgow_dolor]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_ausente][value="'+$('input[name=hf_glasgow_ausente]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_localiza][value="'+$('input[name=hf_glasgow_localiza]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_retira][value="'+$('input[name=hf_glasgow_retira]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_flexion][value="'+$('input[name=hf_glasgow_flexion]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_extension][value="'+$('input[name=hf_glasgow_extension]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_ausencia][value="'+$('input[name=hf_glasgow_ausencia]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_orientado][value="'+$('input[name=hf_glasgow_orientado]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_confuso][value="'+$('input[name=hf_glasgow_confuso]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_incoherente][value="'+$('input[name=hf_glasgow_incoherente]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_sonidos][value="'+$('input[name=hf_glasgow_sonidos]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_arespuesta][value="'+$('input[name=hf_glasgow_arespuesta]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_obedece][value="'+$('input[name=hf_glasgow_obedece]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_riesgocaida][value="'+$('input[name=hf_riesgocaida]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_eva][value="'+$('input[name=hf_eva]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_estadosalud][value="'+$('input[name=hf_estadosalud]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_tipourgencia][value="'+$('input[name=hf_tipourgencia]').data('value')+'"]').prop("checked",true);
    // Toma el valor del 'data-value' y lo asigna en el select
    $('select[name=tomaSignos]').val($('select[name=tomaSignos]').attr('data-value'));
    $('select[name=select_alergias]').val($('select[name=select_alergias]').attr('data-value'));
    $('select[name=tipoDieta]').val($('select[name=tipoDieta]').attr('data-value'));
    $('select[name=hf_alta]').val($('select[name=hf_alta]').attr('data-value'));
    $('select[name=hf_alta]').click(function (e) {
        if($(this).val()=='Otros'){
            $('.hf_alta_otros').removeClass('hide');
        }else{
            $('.hf_alta_otros').addClass('hide');
        }
    });
    if($('select[name=hf_alta]').attr('data-value')=='Otros'){
        $('.hf_alta_otros').removeClass('hide');
    }
    $('input[name=asistentesmedicas_ss_in][value="'+$('input[name=asistentesmedicas_ss_in]').data('value')+'"]').prop("checked",true);
    $('input[name=asistentesmedicas_ss_ie][value="'+$('input[name=asistentesmedicas_ss_ie]').data('value')+'"]').prop("checked",true);
    $('input[name=asistentesmedicas_ss_in][value="'+$('input[name=asistentesmedicas_oc_hr]').data('value')+'"]').prop("checked",true);
    $('input[name=asistentesmedicas_oc_hr][value="'+$('input[name=asistentesmedicas_ss_in]').data('value')+'"]').prop("checked",true);
    $('input[name=asistentesmedicas_incapacidad_am][value="'+$('input[name=asistentesmedicas_incapacidad_am]').data('value')+'"]').prop("checked",true);
    $('input[name=asistentesmedicas_omitir]').click(function (e){
        if($(this).val()=='Si'){
            $('.asistentesmedicas_omitir').addClass('hide').find('.hojafrontal-info').removeAttr('required');
        }else{
            $('.asistentesmedicas_omitir').removeClass('hide').find('.hojafrontal-info').attr('required',true);
        }
    })
    if($('input[name=asistentesmedicas_omitir]').data('value')!='' && triage_paciente_accidente_lugar=='TRABAJO'){
        $('input[name=asistentesmedicas_omitir][value="'+$('input[name=asistentesmedicas_omitir]').data('value')+'"]').prop("checked",true);
        if($('input[name=asistentesmedicas_omitir]').data('value')=='Si'){
            $('.asistentesmedicas_omitir').addClass('hide').find('.hojafrontal-info').removeAttr('required');
        }if($('input[name=asistentesmedicas_omitir]').data('value')=='No'){
            $('.asistentesmedicas_omitir').removeClass('hide').find('.hojafrontal-info').attr('required',true);
        }
    }
    $('input[name=hf_alta][type=radio]').click(function (e){
        $('input[name=hf_alta][type=text]').val('');
    })
    
    // Hoja de Notas parte de riesgo de caida
    $('input[name=hf_riesgo_caida][value="'+$('input[name=hf_riesgo_caida]').data('value')+'"]').prop("checked",true);
    $('input[name=nota_estadosalud][value="'+$('input[name=nota_estadosalud]').data('value')+'"]').prop("checked",true);

    $('#input_dosis').change(function(){
      var dosis = $('#input_dosis').val(),
          dosis_max = $('#dosis_max').text(),
          gramaje_dosis_max = $('#gramaje_dosis_max').text(),
          select_unidad = $('#select_unidad').val(),
          dosis_maxima = parseInt(dosis_max);

          if(dosis != "" && dosis_max != "" && gramaje_dosis_max != "" && select_unidad != ""){

            if(select_unidad.toLowerCase() != gramaje_dosis_max.toLowerCase()){

              var dosis_mcg,
                  dosis_maxima_mcg;

              //convierte la dosis a microgramos segun el gramje que le corresponda
              if(select_unidad.toLowerCase() == "mg"){
                dosis_mcg = dosis * 1000;
              }else if(select_unidad.toLowerCase() == "g"){
                dosis_mcg = dosis * 1000 * 1000;
              }

              //convierte la dosis maxima a microgramos segun el gramje que le corresponda
              if(gramaje_dosis_max.toLowerCase() == "mg"){
                dosis_maxima_mcg = dosis_maxima * 1000;
              }else if(gramaje_dosis_max.toLowerCase() == "g"){
                dosis_maxima_mcg = dosis_maxima * 1000 * 1000;
              }

              dosis = parseInt(dosis_mcg);
              dosis_maxima = parseInt(dosis_maxima_mcg);

              if(dosis > dosis_maxima){
                alert("La dosis rebasa los limites clinicos, favor de modificar el "+
                      "campo o indique en las observaciones el motivo de la dosis");
              }

            }

            if(dosis > dosis_maxima && select_unidad.toLowerCase() == gramaje_dosis_max.toLowerCase()){
              alert("La dosis rebasa los limites clinicos, favor de modificar el "+
                    "campo o indique en las observaciones el motivo de la dosis");
            }

          }
    });

    $('#select_unidad').change(function(){
        var dosis = $('#input_dosis').val(),
            dosis_max = $('#dosis_max').text(),
            gramaje_dosis_max = $('#gramaje_dosis_max').text(),
            select_unidad = $('#select_unidad').val(),
            dosis_maxima = parseInt(dosis_max);

        if(dosis != "" && dosis_max != "" && gramaje_dosis_max != "" && select_unidad != ""){
            if(select_unidad.toLowerCase() != gramaje_dosis_max.toLowerCase()){
                var dosis_mcg,
                dosis_maxima_mcg;
                //convierte la dosis a microgramos segun el gramje que le corresponda
                if(select_unidad.toLowerCase() == "mg"){
                    dosis_mcg = dosis * 1000;
                }else if(select_unidad.toLowerCase() == "g"){
                    dosis_mcg = dosis * 1000 * 1000;
                }
                //convierte la dosis maxima a microgramos segun el gramje que le corresponda
                if(gramaje_dosis_max.toLowerCase() == "mg"){
                    dosis_maxima_mcg = dosis_maxima * 1000;
                }else if(gramaje_dosis_max.toLowerCase() == "g"){
                    dosis_maxima_mcg = dosis_maxima * 1000 * 1000;
                }
                dosis = parseInt(dosis_mcg);
                dosis_maxima = parseInt(dosis_maxima_mcg);
                if(dosis > dosis_maxima){
                    alert("La dosis rebasa los limites clinicos, favor de modificar el "+
                          "campo o indique en las observaciones el motivo de la dosis");
                }
            }
            if(dosis > dosis_maxima && select_unidad.toLowerCase() == gramaje_dosis_max.toLowerCase()){
                alert("La dosis rebasa los limites clinicos, favor de modificar el "+
                      "campo o indique en las observaciones el motivo de la dosis");
            }
        }
    });

    $('#btn_otro_diluyente').click(function(){
      alert("otro diluyente");
    });

    $('.edit-form-npt').click(function(){
      FormularioNPT();
    });

    $('.edit-form-onco-anti').click(function(){
      FormularioAntimicrobianoOncologico();
    });

    $('#select_medicamento').change(function(){
      var medicamento_id = $(this).val();
      var option = "<option value='0'></option>";
      $("#via").append(option);
      $('#via').val('0').trigger('change.select2');
      $('.aminoacido').val("");
      $('.dextrosa').val("");
      $('.lipidos-intravenosos').val("");
      $('.agua-inyectable').val("");
      $('.cloruro-sodio').val("");
      $('.sulfato-magnesio').val("");
      $('.cloruro-potasio').val("");
      $('.fosfato-potasio').val("");
      $('.gluconato-calcio').val("");
      $('.albumina').val("");
      $('.heparina').val("");
      $('.insulina-humana').val("");
      $('.zinc').val("");
      $('.mvi-adulto').val("");
      $('.oligoelementos').val("");
      $('.vitamina').val("");
      ConsultarViasAdministracion();
      $.ajax({
          url: base_url+"Sections/Documentos/AjaxDosisMaxima",
          type: 'GET',
          dataType: 'json',
          data:{
            medicamento_id:medicamento_id
          },success: function (data, textStatus, jqXHR) {
            var categoria_safe = data[0].categoria_safe;
            if(categoria_safe == "npt"){
              $("#categoria_safe").val(categoria_safe);
              $('#btn-form-onco-anti').attr("hidden", true);
              $('#btn-form-npt').removeAttr("hidden");
              FormularioNPT();
            }else if(categoria_safe == "antimicrobiano" || categoria_safe == "oncologico"){
              $("#categoria_safe").val(categoria_safe);
              $('#btn-form-npt').attr("hidden", true);
              $('#btn-form-onco-anti').removeAttr("hidden");
              FormularioAntimicrobianoOncologico();
            }else{
              $('#btn-form-npt').attr("hidden", true);
              $('#btn-form-onco-anti').attr("hidden", true);
            }
            var data_dosis_max = data[0].dosis_max;
            var caracter_delimitador = (data_dosis_max.indexOf(" ") != -1) ? " " : "-";
            //Se remplaza el guion por un espacio y obtener el valor maximo
            data_dosis_max = data_dosis_max.replace("-"," ");
            //Se obtine el valor absoluto de la dosis
            var dosis_val_abosulut = data_dosis_max.slice(0,data_dosis_max.indexOf(" "));
            //dosis_val_abosulut = dosis_val_abosulut.slice(0, dosis_val_abosulut.indexOf("-"));
            //var dosis_gramaje = data_dosis_max.;
            var gramaje_dosis_max = data_dosis_max.substr(-data_dosis_max.indexOf(" "));
            gramaje_dosis_max = gramaje_dosis_max.replace(" ","");
            $('#dosis_max').text("");
            $('#gramaje_dosis_max').text("");
            $('#dosis_max').text(dosis_val_abosulut);
            $('#gramaje_dosis_max').text(gramaje_dosis_max);

            },error: function (e) {
              msj_error_serve();
             }
        }); //fin de ajax
    });

    $('.Form-Notas-HojaFrontal').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Sections/Documentos/AjaxHfCE",
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading()
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.accion=='1'){
                    msj_success_noti('Registro Guardado');
                    AbrirDocumento(base_url+'Inicio/Documentos/NotaConsultoriosEspecialidad/'+data.notas_id);
                    ActionCloseWindowsReload();
                }
            },error: function (e) {
                bootbox.hideAll();
                msj_error_serve(e);
                ReportarError(window.location.pathname,e.responseText);
            }
        })
    })
    /*Uso de generacion de documento dinamicos*/
    if($('select[name=notas_tipo]').attr('data-value')!=''){
        $('select[name=notas_tipo]').val($('select[name=notas_tipo]').attr('data-value'));
    }
    /***/
    $('#hf_mecanismolesion').change(function () {
        if($(this).val().indexOf('Caida')!=-1){
            $('.mecanismo-lesion-caida').removeClass('hide');
        }else{
            $('input[name=hf_mecanismolesion_mtrs]').val('');
            $('.mecanismo-lesion-caida').addClass('hide');
        }
        if($(this).val().indexOf('Otros')!=-1){
            $('.mecanismo-lesion-otros').removeClass('hide');
        }else{
            $('input[name=hf_mecanismolesion_otros]').val('');
            $('.mecanismo-lesion-otros').addClass('hide');
        }
    })
    $('#hf_quemadura').change(function () {
        if($(this).val().indexOf('Otros')!=-1){
            $('.quemadura-otros').removeClass('hide');
        }else{
            $('input[name=hf_quemadura_otros]').val('');
            $('.quemadura-otros').addClass('hide');
        }
    })
    if($("input[name=hf_mecanismolesion_mtrs]").val()!=undefined){
        $("#hf_quemadura").val($('#hf_quemadura').attr('data-value').split(',')).select2();
        $("#hf_mecanismolesion").val($('#hf_mecanismolesion').attr('data-value').split(',')).select2();
        $("#hf_trataminentos").val($('#hf_trataminentos').attr('data-value').split(',')).select2();
    }

    if($('input[name=hf_mecanismolesion_mtrs]').val()!=''){
        $('.mecanismo-lesion-caida').removeClass('hide');
    }
    if($('input[name=hf_mecanismolesion_otros]').val()!=''){
        $('.mecanismo-lesion-otros').removeClass('hide');
    }
    if($('input[name=hf_quemadura_otros]').val()!=''){
        $('.quemadura-otros').removeClass('hide');
    }
    $('#hf_trataminentos').change(function () {
        if($(this).val().indexOf('Otros')!=-1){
            $('.hf_trataminentos_otros').removeClass('hide');
        }else{
            $('input[name=hf_trataminentos_otros]').val('');
            $('.hf_trataminentos_otros').addClass('hide');
        }
    });
    if($('input[name=hf_trataminentos_otros]').val()!=''){
        $('.hf_trataminentos_otros').removeClass('hide');
    }
   
    $('body').on('click','.observaciones-prescripcion',function(){
        var prescripcion_id = $(this).attr('data-value');
        if($('#historial_prescripcion_observacion'+prescripcion_id).val() == 0){
            $('#historial_prescripcion_observacion'+prescripcion_id).removeAttr("hidden");
            $('#historial_prescripcion_observacion'+prescripcion_id).val("1");
        }else{
            $('#historial_prescripcion_observacion'+prescripcion_id).attr("hidden","true");
            $('#historial_prescripcion_observacion'+prescripcion_id).val("0");
        }
    });

    $('body').on('click','.movimientos_prescripcion',function(){
        var medicamento = $(this).attr('data-value');
        if($('#mostrar_ocultar'+medicamento).text() == 0){
            $('#mostrar_ocultar'+medicamento).text('1')
            $('#historial_'+medicamento).removeAttr('hidden');
      }else{
        $('#mostrar_ocultar'+medicamento).text('0')
        $('#historial_'+medicamento).attr('hidden','true');
      }
    });
    $('body').on('click','.editar-prescripcion',function(){
      var prescripcion_id = $(this).attr('data-value');
      var medicamento = $('#fila_medicamento'+prescripcion_id).text();

      if(confirm('¿QUIERES MODIFICAR ESTA PRESCRIPCIÓN? '+medicamento)){

          var medicamento_id = $('#fila_idmedicamento'+prescripcion_id).text();
          var categoria_farmacologica = $('#fila_categoria_farmacologica'+prescripcion_id).text();
          var fecha_prescripcion = $('#fila_fecha_prescripcion'+prescripcion_id).text();
          var dosis = $('#fila_dosis'+prescripcion_id).text();
          var via = $('#fila_via'+prescripcion_id).text();
          var frecuencia = $('#fila_frecuencia'+prescripcion_id).text();
          var aplicacion = $('#fila_aplicacion'+prescripcion_id).text();
          var fecha_inicio = $('#fila_fecha_inicio'+prescripcion_id).text();
          var tiempo = $('#fila_tiempo'+prescripcion_id).text();
          var periodo = $('#fila_periodo'+prescripcion_id).text();
          var fecha_fin = $('#fila_fecha_'+prescripcion_id).text();
          var observacion = $('#fila_observacion'+prescripcion_id).text();
          var opcion_via = "<option value='1'>"+via+"</option>";
          //Fragmento para dividir la dosis en dos, cantidad y unidad
          var arregloDosis = dosis.split(" ");

          if(medicamento_id == 1){
            $('#border_otro_medicamento').removeAttr('hidden');
            $('#borderMedicamento').attr('hidden', true);
            $('#input_otro_medicamento').val(medicamento);
            $('#input_otro_medicamento').attr('disabled', true);
            $('.btn_otro_medicamento').val('1');
            $('.btn_otro_medicamento').text('Ver catalogo');
          }

          $('#via').append(opcion_via);
          $('.formulario_prescripcion').removeAttr('hidden');
          $('.tiempo_tipo_medicamento').empty();
          $('#label_check_prescripcion').text('');
          $('#select_medicamento').select2('val',medicamento_id).select2();
          $('#select_medicamento').select2('enable',false);
          $('#input_dosis').val(arregloDosis[0]);
          $('#select_unidad').val(arregloDosis[1]).trigger('change.select2');
          $('#via').select2('val',1).select2();
          $('#frecuencia').val(frecuencia);
          $('#aplicacion').val(aplicacion);
          $('#fechaInicio').val(fecha_inicio);
          //$('#duracion').val();

          $('#observacion').val(observacion);
          $('#btn_modificar_prescripcion').attr('data-value',prescripcion_id);
          $('.btn_agregarPrescripcion').attr('hidden','true');
          $('.btn_modificarPrescripcion').removeAttr('hidden');

          var motivo =
          "<div class='col-sm-3'>"+
            "<label><b>Motivo de actualización</b></label>"+
            "<input type='text' class='form-control' id='motivo_actualizar' />"+
          "</div>";

          if(categoria_farmacologica.toLowerCase() == 'antibiotico'){
            formulario =
            "<div class='col-sm-2' style='padding: 0;' >"+
              "<label id='categoria_farmacologica' hidden>"+categoria_farmacologica+"</label>"+
              "<label><b>Dias</b></label>"+
              "<div id='borderDuracion'>"+
              "<select id='duracion' onchange='mostrarFechaFin()' class='form-control' >"+
                "<option value='0'>0</option>"+
                "<option value='1'>1</option>"+
                "<option value='2'>2</option>"+
                "<option value='3'>3</option>"+
                "<option value='4'>4</option>"+
                "<option value='5'>5</option>"+
                "<option value='6'>6</option>"+
                "<option value='7'>7</option>"+
                "<option value='8'>8</option>"+
                "<option value='9'>9</option>"+
                "<option value='10'>10</option>"+
              "</select>"+
              "</div>"+
            "</div>"+
            "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
              "<label><b>Fecha fin</b></label>"+
              "<div id='borderFechaFin'>"+
              "<input class='form-control' id='fechaFin'  >"+
              "</div>"+
            "</div>";
          }else{
            formulario =
            "<div class='col-sm-1' style='padding-right: 0; padding-left: 0;' >"+
              "<label id='categoria_farmacologica' hidden>"+categoria_farmacologica+"</label>"+
              "<label><b>Duración</b></label>"+
              "<div class='input-group' >"+
                "<input type='number' min='0' class='form-control' id='duracion' onchange='mostrarFechaFin()' >"+
              "</div>"+
            "</div>"+
            "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
              "<label><b>Periodo</b></label>"+
              "<select class='form-control' id='periodo' onchange='mostrarFechaFin()'>"+
                "<option value='Dias'>Dias</option>"+
                "<option value='Semanas'>Semanas</option>"+
              "</select>"+
            "</div>"+
            "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
              "<label><b>Fecha fin</b></label>"+
              "<div id='borderFechaFin'>"+
              "<input class='form-control' id='fechaFin' >"+
              "</div>"+
            "</div>";
          }

          $('.tiempo_tipo_medicamento').append(formulario);
          $('.tiempo_tipo_medicamento').append(motivo);
          $('#fechaFin').val(fecha_fin);
          $('#duracion').val(tiempo);

          if(categoria_farmacologica.toLowerCase() != 'antibiotico'){
            $('#periodo').val(periodo);
          }
          $('.btn_otro_medicamento').attr('disabled', true);
      }
    });
    $('body').on('click','.desactivar-prescripcion',function(){
        var reaccion = false;
        var motivo = "";
        var prescripcion_id = $(this).attr('data-value');
        var dias = $('#fila_historial_prescripcion'+prescripcion_id).text();
        var estado = 0;
        var paciente = $('input[name=triage_id]').val();

        bootbox.confirm({
          message: '<h5>¿QUIERES RETIRAR ESTE MEDICAMENTO?</h5>',
          buttons: {
            cancel:{
              label: 'NO',
              className: 'btn-imss-cancel'
            },confirm: {
              label: 'SI',
              className: 'back-imss'
            }
          },callback: function(response){
            if(response){
              bootbox.confirm({
                message: '<h5>¿Se presento una reacción adversa?</h5>',
                buttons: {
                  cancel:{
                    label: 'No',
                    className: 'btn-imss-cancel'
                  },confirm: {
                    label: 'Si',
                    className: 'back-imss'
                  }
                },callback: function(response){
                  if(response){
                    reaccion = true;
                  }
                  bootbox.prompt({
                    title: "<h5>Motivo por el que se cancela el medicamento</h5>",
                    inputType: 'text',
                    buttons: {
                      cancel:{
                        label: 'Cancelar',
                        className: 'btn-imss-cancel'
                      },confirm: {
                        label: 'Acepar',
                        className: 'back-imss'
                      }
                    },callback: function(result){
                      motivo = result;
                      if(motivo!=null && motivo!=''){
                        var nota_id = "";
                        var tipo_nota = "";

                        if($('input[name=hf_id]').val() != ''){
                          nota_id = $('input[name=hf_id]').val();
                          tipo_nota = "hojafrontalf";
                        }else if($('input[name=notas_id]').val() != ''){
                          nota_id = $('input[name=notas_id]').val();
                          tipo_nota = "evolucion";
                        }

                        $.ajax({
                          url: base_url+"Sections/Documentos/AjaxCambiarEstadoPrescripcion",
                          type: 'GET',
                          dataType:'json',
                          data: {
                            estado: estado,
                            prescripcion_id: prescripcion_id,
                            paciente: paciente,
                            dias: dias,
                            nota_id: nota_id,
                            tipo_nota: tipo_nota
                          },success: function (data, textStatus, jqXHR) {
                              msj_success_noti(data.mensaje);
                              ActualizarHistorialPrescripcion(paciente,"2");
                              RegistrarAccionBitacoraPrescripcion(prescripcion_id,'Cancelar',motivo);
                              ConteoEstadoPrescripcion(paciente);
                              if(reaccion){
                                RegistrarEfectoAdverso(prescripcion_id,paciente,motivo);
                              }

                          },error: function (e) {
                              msj_error_serve(e)
                              bootbox.hideAll();
                          }
                        });
                      }
                    }
                  });
                }
              });
            }

          }
        });
    });
    $('body').on('click','.prescripcion_historial',function(){
      var prescripcion_id = $(this).attr('data-value');
      var paciente = $('input[name=triage_id]').val();
      BitacoraHistorialMedicamentos(prescripcion_id,paciente);
    });

    $('.btn-edit-diagnostico-principal').click(function(){
      $('input[name=accion_diagnostico_principal]').val("edit");
      $('#text_diagnostico_1').removeAttr('disabled');
      $('#complemento_diagnostico_principal').removeAttr('disabled');
      $('#text_diagnostico_1').val('');
      $('#text_codigo_diagnostico_1').val('');
      $('#complemento_diagnostico_principal').val('');
    });

    $('.btn-diagnostico-principal').click(function(){
      $('#text_diagnostico_1').val('');
      $('#text_codigo_diagnostico_1').val('');
      $('#complemento_diagnostico_principal').val('');
    });

    $('#consulta_diagnosticos').click(function(){
      var folio = $('input[name=triage_id]').val();
      var value_table = $('.table_diagnosticos').attr('data-value');

      if(value_table == 0){
        $('.table_diagnosticos').attr('data-value',"1");
        $('.table_diagnosticos').removeAttr('hidden');
        HistorialDiagnosticos(folio);
      }else if(value_table == 1){
        $('.table_diagnosticos').attr('data-value',"0");
        $('.table_diagnosticos').attr('hidden',true);
        $('.historial_diagnosticos').empty();
      }
    });

    $('#play_ordenes_nuevo').click(function(){
      //Limpiar campos de dieta
      $('#radioAyuno').removeAttr('checked');
      $('#radioDieta').removeAttr('checked');
      $('#divSelectDietas').attr('hidden',true);
      $('#selectDietas').val(0);
      $('#divOtraDieta').attr('hidden',true);
      $('#inputOtraDieta').val('');
      //Limpiar campos de toma de signos
      $('#selectTomaSignos').val(0);
      $('#divOtrasInidcacionesSignos').attr('hidden',true);
      $('#otras-indicaciones-signos').val('');
      //Limpiar campos cuidados generales de enfermeria
      $('#checkCuidadosGenerales').attr('checked',true);
      $('#labelCheckCuidadosGenerales').text(" SI");
      $('#listCuidadosGenerales').attr('hidden',true);
      //Limpiar campo cuidados especiales de enfermeria
      $('textarea[name=nota_cuidadosenfermeria]').data("wysihtml5").editor.setValue('');
      //Limpiar campo soluciones parenterales
      $('textarea[name=nota_solucionesp]').data("wysihtml5").editor.setValue('');
    });

    $('.btn_fecha_actual').click(function(){
      var val = $(this).val(),
          fecha = new Date(),
          dia = fecha.getDate(),
          mes = fecha.getMonth(),
          año = fecha.getFullYear();

      $('#fechaInicio').val(dia+'/'+(mes+1)+'/'+año);
      $(this).val('1');
      mostrarFechaFin();
    });

    $('.btn_otro_medicamento').click(function(){
      var val = $(this).val();
      switch (val) {
        case '0':
          $('#borderMedicamento').attr('hidden', true);
          $('#border_otro_medicamento').removeAttr('hidden');
          $('#select_medicamento').val("1").trigger('change.select2');
          $(this).text('Ver catalogo');
          $(this).val('1');
          break;
        case '1':
          $('#borderMedicamento').removeAttr('hidden');
          $('#border_otro_medicamento').attr('hidden', true);
          $('#select_medicamento').val("0").trigger('change.select2');
          $(this).text('Otro medicamento');
          $(this).val('0');
          break;
      }
    });

    $('#play_ordenes_continuar').click(function(){
      var folio = $('input[name=triage_id]').val();
      ConsultarUltimasOrdenes(folio);
    });

    $('#acordeon_prescripciones_activas').click(function(){
      var paciente = $('input[name=triage_id]').val();
      var val_accion = 1;
      AccionPanelPrescripcion(val_accion, paciente);
    });

    $('#acordeon_prescripciones_canceladas').click(function(){
      var paciente = $('input[name=triage_id]').val();
      var val_accion = 2;
      AccionPanelPrescripcion(val_accion, paciente);

    });

    //Ejecuta las funciones para mostrar el historial de reacciones adversas
    $('#acordeon_reacciones').click(function(){
      var paciente = $('input[name=triage_id]').val();
      var val_accion = 3;
      AccionPanelPrescripcion(val_accion, paciente);
    });
    //Ejecuta la funcion para mostrar alergia a medicamentos
    $('#acordeon_alergia_medicamentos').click(function(){
      var paciente = $('input[name=triage_id]').val();
      var val_accion = 5;
      AccionPanelPrescripcion(val_accion, paciente);
    });

    //Mostrar prescripciones pendientes
    $('#acordeon_prescripciones_pendientes').click(function(){
      var paciente = $('input[name=triage_id]').val();
      var val_accion = 6;
      AccionPanelPrescripcion(val_accion, paciente);
    });

    //Mostrar notificaciones
    $('#acordeon_notificaciones').click(function(){
      var paciente = $('input[name=triage_id]').val();
      var val_accion = 7;
      AccionPanelPrescripcion(val_accion, paciente);
    });
    
    var indice_diagnosticos_secundarios = 2;

    $('.btn_agregarDiagnostico').click(function(){
      var form_diagnosticos_secundarios = '';
      form_diagnosticos_secundarios =
     
      '<div class="row"  id="form_diagnosticos_secundarios_'+indice_diagnosticos_secundarios+'">'+
          '<div class="col-sm-8">'+
          '<div class="form-group">'+
            '<label>Diagnóstico secundario con codigo CIE-10</label>'+
            '<input type="text" class="form-control" autocomplete="off" id="text_diagnostico_'+indice_diagnosticos_secundarios+'" onkeydown=BuscarDiagnostico('+indice_diagnosticos_secundarios+') />'+

              '<ul class="contenedor_consulta_diagnosticos" id="lista_resultado_diagnosticos_'+indice_diagnosticos_secundarios+'" ></ul>'+

          '</div>'+
        '</div>'+

        '<div class="col-sm-2">'+
          '<label>Código</label>'+
          '<input type="text" class="form-control" id="text_codigo_diagnostico_'+indice_diagnosticos_secundarios+'" disabled/>'+
          '<input type="hidden" class="form-control" name="cie10_id[]" id="text_id_diagnostico_'+indice_diagnosticos_secundarios+'"/>'+
          '<input type="hidden" name="tipo_diagnostico[]" value="2" >'+
        '</div>'+

        '<div class="col-sm-1" style="padding-top:25px">'+
          '<button type="button" class="btn btn-default width100 pointer" id="btn_diagnostico_complementario_'+indice_diagnosticos_secundarios+'" title="Complemento de diagnóstico" value="0" onclick="MostrarDiagnosticoComplementario('+indice_diagnosticos_secundarios+')" >'+
            '<span class="fa fa-file-text-o"></span>'+
          '</button>'+
       '</div>'+

        '<div class="col-sm-1" style="padding-top:25px;">'+
          '<a class="btn btn-imms-cancel width100 delete-diagnostico-secundario" onclick="BorrarDiagnosticoDinamico('+indice_diagnosticos_secundarios+')">'+
            '<span class="glyphicon glyphicon-remove"></span>'+
          '</a>'+
        '</div>'+

        '<div class="col-sm-12" id="div_complento_diagnostico_'+indice_diagnosticos_secundarios+'" hidden>'+
          '<div class="form-group">'+
            '<label>Complemento de diagnóstico</label>'+
            '<textarea name="complemento[]"0 rows="2" class="form-control"></textarea>'+
          '</div>'+
        '</div>'+
      '</div>';
      $('.diagnosticos_secundarios_dinamico').append(form_diagnosticos_secundarios);
      indice_diagnosticos_secundarios = indice_diagnosticos_secundarios + 1;
    });

    $('.check_diagnosticos_secundarios').click(function(){
      if($(this).val() == 0){
        $(this).val('1');
        $('.diagnosticos_secundarios').removeAttr('hidden');
        $('.label_check_secundarios').text('');
      }else if($(this).val() == 1){
        $(this).val('0');
        $('.diagnosticos_secundarios').attr('hidden',true);
        $('.label_check_secundarios').text('SI');
      }
      tipo_diagnostico = 2;
    });

    $('input[name=check_solicitud_interconsulta]').click(function(){
      if($(this).val() == 0){
        $(this).val('1');
        $('.nota_interconsulta').removeAttr('style');
        $('.motivo_interconsulta').removeAttr('required');
      }else if ($(this).val() == 1) {
        $(this).val('0');
        $('.nota_interconsulta').css('display', 'none');
        $('.motivo_interconsulta').prop('required', true);
      }
    });
     // Checkbox de Procedimientos 
    $('input[name=check_procedimientos]').click(function(){
      if($(this).val() == 0){
        $(this).val('1');
        $('.div_procedimientos').removeAttr('style');
      }else if ($(this).val() == 1) {
        $(this).val('0');
        $('.div_procedimientos').css('display','none');
      }
    });
    /*Guardar Documento de Hoja Frontal Formato Abierto*/
    $('.guardar-solicitud-hi-abierto').submit(function (e){    
        e.preventDefault();
        $.ajax({
            url: base_url+"Sections/Documentos/AjaxHojaInicialAbierto",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                //msj_loading();
            },success: function (data, textStatus, jqXHR) {
                if(data.accion == '0') {
                    console.log(data.accion);
                    bootbox.alert("No tiene ningun Diagnóstico, tiene que ingresar al menos uno");
                    e.preventDefault();

                }else {
                
                if($('input[name=tipo]').val()=='Consultorios'){
                    if($('input[name=ce_status]').val()!='Salida'){
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaInicialAbierto/'+$('input[name=triage_id]').val(),'Hola Inicial',100);
                        ActionCloseWindowsReload();
                    }else{
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaInicialAbierto/'+$('input[name=triage_id]').val(),'Hola Inicial',100);
                        if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',500);
                        }
                        /*if($('input[name=hf_ministeriopublico]:checked').val()=='Si'){
                            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/'+$('input[name=triage_id]').val(),'NMP',800);
                        }*/
                    }

                }else{
                        bootbox.hideAll();
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaInicialAbierto/'+$('input[name=triage_id]').val(),'Hola Inicial',100);
                        if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',500);
                        }
                        ActionCloseWindowsReload();
                    }
                }
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e);
              }
        }); // fin ajax
    });// fin 

    $('.opcion_alergias').change(function(){
      if($(this).val() == 1){
        $('.alergias').val('');
        $('.alergias').show();
      }else {
        $('.alergias').hide();
      }
    });

    //Permite cambiar el contenido del horario de aplicacion del medicamento
    $('.edit-aplicacion').click(function(){
      if($(this).val() == 0){
        $('#aplicacion').removeAttr('disabled');
        $(this).val('1')
      }else if($(this).val() == 1){
        $('#aplicacion').attr('disabled', true);
        $(this).val('0')
      }
      $('#aplicacion').val('');
    });

    $('input[name=es_residente]').click(function () {
        if($(this).val()=='Si'){
            $('.notas_medicotratante').removeClass('hide');
        }else{
            $('.notas_medicotratante').addClass('hide');
            $('select[name=notas_medicotratante]').select2('val','').select2();
        }
    })

    if($('input[name=es_residente]').attr('data-value')!='0' && $('input[name=es_residente]').attr('data-value')!=''){
        $('input[name=es_residente][value=Si]').prop('checked',true);
        $('.notas_medicotratante').removeClass('hide');
        $('select[name=notas_medicotratante]').select2('val',$('select[name=notas_medicotratante]').attr('data-value')).select2();
    }
    // OCULTA CAMPOS EN EL MODAL DE RIESGO DE TROMBOSIS
    $('input[name=rt_sexo]').click(function (e){
        if($(this).val()=='f'){
            $('.col-mujer').removeClass('hidden');
            }else {
                if($('input[name=rt_sexo]').attr('value')=='m'){
                    $('.col-mujer').addClass('hidden');
            }
        }

    });

    $('select[name=notas_tipo]').click(function (e) {
        if($(this).val()=='NOTA DE INTERCONSULTA'){
            $('.nota_motivoInterconsulta').removeClass('hidden');
            $('.evolucion-psoap').addClass('hidden');
            $('#psoap_subjetivo').text('INTERROGATORIO:');
            $('#psoap_objetivo').text('EXPLORACION FISICA:');
        }else{
            //if($('select[name=notas_tipo').attr('value')=='NOTA DE EVOLUCIÓN'){
                $('.nota_motivoInterconsulta').addClass('hidden');
                $('.evolucion-psoap').removeClass('hidden');
                $('textarea[name=nota_motivoInterconsulta]').val('');
                $('#psoap_subjetivo').text('SUBJETIVO (Interrogatorio):');
                $('#psoap_objetivo').text('OBJETIVO (Exploracion fisica):');
          //  }

        }
    });

    $('select[name=medicoBase]').change(function(){
      var matricula = $('select[name=medicoBase]').val();
      $('#medicoMatricula').val(matricula);
    });

    // $("input[name=residente]").click(function(e) {
    //     if($(this).val()=='Si'){
    //         $('.medico_residente').removeClass('hidden');
    //         $('#nombre_residente').attr('required','true');
    //         $('#apellido_residente').attr('required','true');
    //         $('#cedula').attr('required','true');
    //     } else {
    //       $('#nombre_residente').removeAttr('required');
    //       $('#apellido_residente').removeAttr('required');
    //       $('#cedula').removeAttr('required');
    //       $('.medico_residente').addClass('hidden');
    //   }
    // });

    $('#btn_modificar_prescripcion').click(function(){
      var prescripcion_id = $(this).attr('data-value');
      var medicamento_id = $('#select_medicamento').val();
      var dosis_cantidad = $('#input_dosis').val();
      var unidad = $('#select_unidad').val();
      var dosis = (dosis_cantidad+' '+unidad);
      var via = $('#via option:selected').text()
      var frecuencia = $('#frecuencia').val();
      var aplicacion = $('#aplicacion').val();
      var fecha_inicio = $('#fechaInicio').val();
      var observacion = $('#observacion').val();
      var motivo_actualizar = $('#motivo_actualizar').val();
      var tiempo = $('#duracion').val();
      var periodo = $('#periodo option:selected').text();
      if(medicamento_id == '1'){
        observacion = $('#input_otro_medicamento').val() + '-' + observacion;
      }

      var datos_viejos = DatosTabplaPrescripcionActivas(prescripcion_id);
      var motivo_datos_viejos =
      datos_viejos['via']+","+
      datos_viejos['frecuencia']+","+
      datos_viejos['aplicacion']+","+
      datos_viejos['fecha_inicio']+","+
      datos_viejos['observacion']+","+
      datos_viejos['tiempo']+","+
      datos_viejos['periodo']+","+
      datos_viejos['dosis']+","+
      motivo_actualizar;

      $.ajax({
        url: base_url+"Sections/Documentos/AjaxModificarPrescripcion",
        type: 'GET',
        dataType: 'json',
        data:{
          via : via,
          frecuencia : frecuencia,
          aplicacion : aplicacion,
          fecha_inicio : fecha_inicio,
          observacion : observacion,
          dosis : dosis,
          prescripcion_id : prescripcion_id
        },
        success: function(data, textStatus, jqXHR){
          msj_success_noti("Modificacion correcta");
          limpiarFormularioPrescripcion();
          RegistrarAccionBitacoraPrescripcion(prescripcion_id,'Actualizar',motivo_datos_viejos);
          var paciente = $('input[name=triage_id]').val();
          $('#historial_prescripcion').removeAttr('hidden');
          ActualizarHistorialPrescripcion(paciente,"0");
          $('#select_medicamento').select2('enable',true);
        },error: function (e) {
            bootbox.hideAll();
            msj_error_serve();
        }
      });

    });

    $('#check_estudios').change(function(){
        if($(this).is(':checked')){
          $('.solicitud_laboratorio').removeAttr('hidden');
          $('#label_check_estudios').text('');
        }else {
          $('.solicitud_laboratorio').attr('hidden',true);
          $('#label_check_estudios').text('- SI');
        }
    });

    $('#check_form_prescripcion').change(function(){
      $('.btn_modificarPrescripcion').attr('hidden','true');
      $('.btn_agregarPrescripcion').removeAttr('hidden');

      if($(this).is(':checked')){
        $('.formulario_prescripcion').removeAttr('hidden');
        $('#label_check_prescripcion').text('');
        $('#select_medicamento').select2('enable',true);
      }else{
        $('.formulario_prescripcion').attr('hidden','true');
        $('#label_check_prescripcion').text('- SI');
        limpiarFormularioPrescripcion();
      }

    });

    // $('input[name=residente][value="'+$('input[name=residente]').data('value')+'"]').prop("checked",true);

    /*Evento para agregar dinamicamento nuevos médicos residentes*/

    $("#add_otro_residente").click (function(e) {
        
        /*la varivable cont incrementa cada ves que se genera un nuevo médico residente
        la variable se concatena al identificador del campo con el proposito de tener distinguir cada uno
        en el momento de ser eliminados*/

        if(cont >= 2){
          alert('La nota medica solo acepta maximo 3 medicos residentes');
        }
        else{
          cont += 1;
          $("#medicoResidente").append(
          '<div id=areaResidentes'+ cont +' class="col-sm-12 form-group">'+
          '<div class=col-sm-4 >'+
          '<input id="medico'+ cont +'" class="form-control"  type="text" required name="nombre_residente[]" placeholder="Nombre(s)">'+
          '</div>'+
          '<div class=col-sm-4 >'+
          '<input id="medico'+ cont +'" class=form-control type="text" required name="apellido_residente[]" placeholder="Apellidos">'+
          '</div>'+
          '<div class=col-sm-3 >'+
          '<input id="medico'+ cont +'" class=form-control type="text" required name="cedula_residente[]" placeholder="Cédula Profesional">'+
          '</div>'+
          '<div class=col-sm-1 >'+
          '<a href="#" onclick=quitarResidenteFormulario('+cont+') class="btn btn-danger delete btn-xs" style="width:100%;height:100%;padding:7px;" id="quitar_residente"><span class="glyphicon glyphicon-remove"></span></a>'+
          '</div>'+
          '</div>');
          console.log(cont);
        }

    });
    // valida que se selecciones los campos de la escala de glasgow
    $('.btn_modal_glasgow').click(function(){
      var ocular = ($('input[name=apertura_ocular]').is(':checked')) ? parseInt($('input[name=apertura_ocular]:checked').val()) : 0;
      var motora = ($('input[name=respuesta_motora]').is(':checked')) ? parseInt($('input[name=respuesta_motora]:checked').val()) : 0;
      var verbal = ($('input[name=respuesta_verbal]').is(':checked')) ? parseInt($('input[name=respuesta_verbal]:checked').val()) : 0;

      if(ocular == 0){
        $('.label_glasgow_ocular').css('color','red');
      }else{
        $('.label_glasgow_ocular').css('color','black');
      }

      if(motora == 0){
        $('.label_glasgow_motora').css('color','red');
      }else{
        $('.label_glasgow_motora').css('color','black');
      }

      if(verbal == 0){
        $('.label_glasgow_verbal').css('color','red');
      }else{
        $('.label_glasgow_verbal').css('color','black');
      }

      if(ocular > 0 && motora > 0 && verbal > 0 ){
        $('#myModal1').modal('toggle');
      }

    });

    $('.sum_glasgow').click(function(){
      var ocular = ($('input[name=apertura_ocular]').is(':checked')) ? parseInt($('input[name=apertura_ocular]:checked').val()) : 0;
      var motora = ($('input[name=respuesta_motora]').is(':checked')) ? parseInt($('input[name=respuesta_motora]:checked').val()) : 0;
      var verbal = ($('input[name=respuesta_verbal]').is(':checked')) ? parseInt($('input[name=respuesta_verbal]:checked').val()) : 0;
      var total = (ocular + motora + verbal);
      $('input[name=hf_escala_glasgow]').val(total);
    });

    // var Total=0;
    // $('.sum').click(function (e) {
    //     var valor=parseInt($(this).val());
    //     if($(this).is(':checked')){
    //         Total=valor+Total;
    //     }else{
    //         Total=Total-valor;
    //     }
    //     $('input[name=hf_escala_glasgow]').val(Total);

    // });

    $(document).on('click keyup','.suma_rt',function() {
        calcular();
    });

    $("#checkbox_importaNota").click(function() {  
        $("#checkbox").attr('checked', true); 
        var folio = $('input[name=triage_id]').val();
        importarUltimaNota(folio);
    }); 

}); 
    /* Nuevas funciones para el comportamiento */
    /* Guardar los datos del paciente y dar de alta a consultorios */
    function GuardarDarAlta(Folio) {    
        bootbox.confirm({
            title:'<h5>GUARDAR Y DAR DE ALTA</h5>',
            message:'<div class="row">'+
                        '<div class="col-md-12">'+
                            '<h5>¿GUARDAR DATOS DATOS DEL PACIENTE Y DAR DE ALTA DE CONSULTORIO?</h5>'+
                        '</div>'+
                    '</div>',
            buttons:{
                cancel:{
                    label:'Espera Paciente'
                },confirm:{
                    label:'Egresar Paciente'
                }
            },callback:function (res) {
                if(res==true){
                    $.ajax({
                        url: base_url+"Consultorios/AjaxReportarSalida",
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            'csrf_token':csrf_token,
                            'triage_id':Folio,
                        },beforeSend: function (xhr) {
                            msj_loading();
                        },success: function (data, textStatus, jqXHR) {
                            bootbox.hideAll();
                            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaFrontalCE/'+Folio,'Hola Frontal',100);
                            if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                                AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+Folio,'ST7',500);
                            }if($('input[name=hf_ministeriopublico]:checked').val()=='Si'){
                                AbrirDocumentoMultiple(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/'+Folio,'NMP',800);
                            }
                            ActionCloseWindowsReload()
                        },error: function (e) {
                            msj_error_serve();
                            bootbox.hideAll();
                            ReportarError(window.location.pathname,e.responseText);
                        }
                    })
                }else{
                    bootbox.hideAll();
                    ActionCloseWindowsReload();
                    AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaFrontalCE/'+Folio,'Hola Frontal',100);
                    if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+Folio,'ST7',500);
                    }if($('input[name=hf_ministeriopublico]:checked').val()=='Si'){
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/'+Folio,'NMP',800);
                    }
                }
            }
        })
    }
    function quitarResidenteFormulario(residente){
      $('#areaResidentes'+residente).remove();
      cont -= 1;
    }
    /* Calcular el risgo de Trombosis */
    function calcular() {
      var tot = $('#puntos_rt');
      tot.val(0);
      $('.suma_rt').each(function() {
        if($(this).hasClass('suma_rt')) {
          tot.val(($(this).is(':checked') ? parseInt($(this).attr('value')) : 0) + parseInt(tot.val()) );
        }
        else {

         tot.val(parseInt(suma.val()) + (isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val())));
        }

      });
      //var totalParts = parseInt(tot.val()).toFixed(2).split('.');
      //tot.val('$' + totalParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' +  (totalParts.length > 1 ? totalParts[1] : '0'));
        if(tot.val() <= 2)  {
            $("#puntos_rt").val(tot.val() + ' ptos: ' + 'Riesgo Bajo');
        } else if(tot.val() >= 3 && tot.val() <= 4) {
            $("#puntos_rt").val(tot.val() + ' ptos: ' + 'Riesgo Moderado');
        } else if(tot.val() >= 5 && tot.val() <= 8) {
            $("#puntos_rt").val(tot.val() + ' ptos: ' + 'Riesgo Alto');
        } else if(tot.val() > 8) {
            $("#puntos_rt").val(tot.val() + ' ptos: ' + 'Riesgo Muy Alto');
        }
    }
    /* Horario de aplicación de medicamentos */
    function asignarHorarioAplicacion(){
      $('#duracion').val('');
      $('#duracion').removeAttr('disabled');
      $('#periodo').removeAttr('disabled');
      $('#aplicacion').attr('disabled',true);
      var frecuencia = $('#frecuencia').val();
      var horaAplicacion = "8:00";
      if(frecuencia == "4 hrs"){
        horaAplicacion = "8:00 / 12:00 / 16:00 / 20:00  / 24:00";
      }else if(frecuencia == "6 hrs"){
        horaAplicacion = "6:00 / 12:00 / 18:00 / 24:00";
      }else if(frecuencia == "8 hrs"){
        horaAplicacion = "8:00 / 16:00 / 24:00";
      }else if(frecuencia == "12 hrs"){
        horaAplicacion = "8:00 / 20:00";
      }else if( frecuencia == 0){
        horaAplicacion = "Falta asignar frecuencia"
      }else if(frecuencia == "Dosis unica"){

          $('#duracion').val('0');
          $('#duracion').attr('disabled',true);
          $('#periodo').attr('disabled',true);

      }
      $('#aplicacion').val(horaAplicacion);
    }

    function sumDias(fecha, numDias){

      fecha.setDate(fecha.getDate() + numDias);
      return fecha;
    }
    // Obtine la fecha en que terminara la prescripciones,
    // cuenta con una condicion para hacer una convercion en dias
    function mostrarFechaFin(){
      var categoria_farmacologica = $('#categoria_farmacologica').text();
      var fechaInicio = $('#fechaInicio').val();
      var duracion = $('#duracion').val();
      var periodo = "";
      var dias = 0;
      var fechaFin = "";

      if(categoria_farmacologica.toLowerCase() == 'antibiotico'){
        fechaFin = sumarfecha(duracion, fechaInicio);
      }else{
        periodo = $('#periodo').val();
        dias = ConvercionDias(duracion, periodo);
        fechaFin = sumarfecha(dias, fechaInicio);
      }

      if(duracion === ''){
        $('#fechaFin').val(fechaInicio);
      }else{
        $('#fechaFin').val(fechaFin);
      }
    }
    // Valida el llenado del formulario, indicando si
    // algun campo falta por llenar
    function revisarCamposVaciosPrescripcion(){
      //Declaracion de atributos
      var categoria_farmacologica = $('#categoria_farmacologica').val();
      var medico = $('#select_medicamento').val();
      var dosis = $('#input_dosis').val();
      var unidad = $('#select_unidad').val();
      var via = $('#via').val();
      var frecuencia = $('#frecuencia').val();
      var horaAplicacion = $('#aplicacion').val();
      var fechaInicio = $('#fechaInicio').val();
      var duracion = $('#duracion').val();
      var fechaFin = $('#fechaFin').val();
      var validacion = false;

      //Condicion en caso de no seleccionar un medicamento o categoria farmacologica
      //if(categoria_farmacologica){

      //}
      if(medico === '0'){
        $('#borderMedicamento').css("border","2px solid red");
      }else if(dosis === ''){
        $('#borderDosis').css("border","2px solid red");
      }else if(unidad === '0'){
        $('#borderUnidad').css("border","2px solid red");
      }
      else if(via === '0'){
        $('#borderVia').css("border","2px solid red");
      }
      else if(frecuencia === '0'){
        $('#borderFrecuencia').css("border","1px solid red");
      }else if(horaAplicacion === ''){
        $('#borderAplicacion').css("border","1px solid red");
      }else if(fechaInicio === ''){
        $('#borderFechaInicio').css("border","1px solid red");
      }else if(duracion === ''){
        $('#borderDuracion').css("border","1px solid red");
      }else if(fechaFin === ''){
        $('#borderFechaFin').css("border","1px solid red");
      }else{
        $('#borderMedicamento').css("border","1px solid white");
        $('#borderDosis').css("border","1px solid white");
        $('#borderUnidad').css("border","1px solid white");
        $('#borderVia').css("border","2px solid white");
        $('#borderFrecuencia').css("border","1px solid white");
        $('#borderAplicacion').css("border","1px solid white");
        $('#borderFechaInicio').css("border","1px solid white");
        $('#borderDuracion').css("border","1px solid white");
        $('#borderFechaFin').css("border","1px solid white");
        validacion = true;
      }
      return validacion;
    }
    //Limpia el formulario despues de usarse
    function limpiarFormularioPrescripcion(){
      $('.btn_otro_medicamento').val('0');
      $('.btn_otro_medicamento').text('Otro medicamento');
      $('#borderMedicamento').removeAttr('hidden');
      $('#border_otro_medicamento').attr('hidden', true);
      $('#select_medicamento').val("0").trigger('change.select2');
      $('#input_otro_medicamento').val('');
      $('#via').val("0").trigger('change.select2');
      $('#input_dosis').val("");
      $('#select_unidad').val("0").trigger('change.select2');
      $('#frecuencia').val("0");
      $('#aplicacion').val("");
      $('#fechaInicio').val("");
      $('#duracion').val("0");
      $('#fechaFin').val("");
      $('#observacion').val("");
    }
   
    function indicarInteraccion(){
      var idMedicamento = $('#select_medicamento').val();
      $('#interaccion_amarilla').val(idMedicamento).trigger('change');
      $('#interaccion_roja').val(idMedicamento).trigger('change');
      TipoMedicamento(idMedicamento);
    }

    // Se almacenan los datos de la prescripcion en un arreglo
    function agregarPrescripcion(){
      var validar = revisarCamposVaciosPrescripcion();
      //var validar = true;
      if (validar === true){
        var categoria_farmacologica = $("#categoria_farmacologica").text();
        var periodo = "";


        // tomar valor del formulario y asignar variable
        var idMedicamento = $('#select_medicamento').val();
        var medicamento = (idMedicamento != '1')? $('#select_medicamento option:selected').text() : $('#input_otro_medicamento').val();
        var interaccion_amarilla = $('#interaccion_amarilla option:selected').text();
        var dosis = $('#input_dosis').val();
        var unidad = $('#select_unidad').val();
        var interaccion_roja = $('#interaccion_roja option:selected').text();
        var arrayInteraccionAmarilla = interaccion_amarilla.split(',');
        var arrayInteraccionRoja = interaccion_roja.split(',');
        var via = $('#via option:selected').text();
        var frecuencia = $('#frecuencia').val();
        var horaAplicacion = $('#aplicacion').val();
        var fechaInicio = $('#fechaInicio').val();
        var duracion = $('#duracion').val();
        var fechaFin = $('#fechaFin').val();
        var observacion = $('#observacion').val();
        var periodo = "Dias";
        var categoria_safe = $('#categoria_safe').val();
        //Datos NPT
        //si su valor es indfinido, por defecto sera 0
        var aminoacido = ($('.aminoacido').val() != "" ) ? $('.aminoacido').val(): 0 ;
        var dextrosa = ($('.dextrosa').val() != "" ) ? $('.dextrosa').val(): 0 ;
        var lipidos_intravenosos = ($('.lipidos-intravenosos').val() != "" ) ? $('.lipidos-intravenosos').val(): 0 ;
        var agua_inyectable = ($('.agua-inyectable').val() != "" ) ? $('.agua-inyectable').val(): 0 ;
        var cloruro_sodio = ($('.cloruro-sodio').val() != "" ) ? $('.cloruro-sodio').val(): 0 ;
        var sulfato_magnesio = ($('.sulfato-magnesio').val() != "" ) ? $('.sulfato-magnesio').val(): 0 ;
        var cloruro_potasio = ($('.cloruro-potasio').val() != "" ) ? $('.cloruro-potasio').val(): 0 ;
        var fosfato_potasio = ($('.fosfato-potasio').val() != "" ) ? $('.fosfato-potasio').val(): 0 ;
        var gluconato_calcio = ($('.gluconato-calcio').val() != "" ) ? $('.gluconato-calcio').val(): 0 ;
        var albumina = ($('.albumina').val() != "" ) ? $('.albumina').val(): 0 ;
        var heparina = ($('.heparina').val() != "" ) ? $('.heparina').val(): 0 ;
        var insulina_humana = ($('.insulina-humana').val() != "" ) ? $('.insulina-humana').val(): 0 ;
        var zinc = ($('.zinc').val() != "" ) ? $('.zinc').val(): 0 ;
        var mvi_adulto = ($('.mvi-adulto').val() != "" ) ? $('.mvi-adulto').val(): 0 ;
        var oligoelementos = ($('.oligoelementos').val() != "" ) ? $('.oligoelementos').val(): 0 ;
        var vitamina = ($('.vitamina').val() != "" ) ? $('.vitamina').val(): 0 ;
        var total_npt = ($('.total-npt').val() != "" ) ? $('.total-npt').val(): 0 ;

        //Datos Antimicrobiano u Oncologico
        var diluyente = ($('.diluyente').val() != "" ) ? $('.diluyente').val(): 0 ;
        var vol_diluyente = ($('.vol_diluyente').val() != "" ) ? $('.vol_diluyente').val(): 0 ;

        //Oculatar botones para antibioticos
        $('#btn-form-npt').attr('hidden',true);
        $('#btn-form-onco-anti').attr('hidden',true);
        if(categoria_safe == "npt"){

          arrayAntibiotico = {
            aminoacido : aminoacido,
            dextrosa : dextrosa,
            lipidos_intravenosos : lipidos_intravenosos,
            agua_inyectable : agua_inyectable,
            cloruro_sodio : cloruro_sodio,
            sulfato_magnesio : sulfato_magnesio,
            cloruro_potasio : cloruro_potasio,
            fosfato_potasio : fosfato_potasio,
            gluconato_calcio : gluconato_calcio,
            albumina : albumina,
            heparina : heparina,
            insulina_humana : insulina_humana,
            zinc : zinc,
            mvi_adulto : mvi_adulto,
            oligoelementos : oligoelementos,
            vitamina : vitamina,
            total_npt : total_npt
          };

        }else if(categoria_safe == "antimicrobiano" || categoria_safe == "oncologico"){

          arrayAntibiotico = {
            diluyente: diluyente,
            vol_diluyente : vol_diluyente
          }

        }




        if(observacion === ''){
          observacion = "Sin observaciones";
        }
        if(categoria_farmacologica.toLowerCase() != 'antibiotico'){
          periodo = $("#periodo").val();

        }
        //se hace condicion en caso de existir npt y asi tomar los datos del modal


        var arrayLongitud = arrayPrescripcion.length;
        // verifica si el arreglo esta vacio y determinar si el registro es directo o inicia la comparacion
        if(arrayLongitud > 0){
          var interaccionA;
          var interaccionB;
          var comparaMedicamento;
          var resultadoComparacion;
          var x;
          var longitudInteracciones;
          for(x = 0; x < arrayLongitud; x++){
            comparaMedicamento = arrayPrescripcion[x]['medicamento'];
            longitudInteracciones = arrayInteracciones[x]['arrayInteraccionAmarilla'].length;
            for (var y = 0; y < longitudInteracciones; y++){
              interaccionA = arrayInteracciones[x]['arrayInteraccionAmarilla'][y];
              if(arrayInteracciones[x]['arrayInteraccionAmarilla'][y] == idMedicamento ){
                $('#fila'+x).css("background-color","rgb(252, 255, 124)");// Amarillo para efectos grabes, solo requiere observación
                alert(arrayPrescripcion[x]['medicamento']+" y "+medicamento+" pueden generar efectos adversos. Favor de modificar la prescripción o notificar al área de Farmacovigilancia");

                //break;
              }
            }
            for (var y = 0; y < longitudInteracciones; y++){
              interaccionA = arrayInteracciones[x]['arrayInteraccionRoja'][y];
              if(arrayInteracciones[x]['arrayInteraccionRoja'][y] == idMedicamento ){
                $('#fila'+x).css("background-color","rgb(255, 170, 170)");//color rojo para efectos muy grabes
                alert(arrayPrescripcion[x]['medicamento']+" y "+medicamento+" son medicamentos contraindicados"+
                ". "+
                "Favor de modificar la prescripción o notificar al área de Farmacovigilancia");
                //break;
              }
            }
            if(comparaMedicamento == medicamento){
              alert("El medicamento ya fue ingresado, indique uno nuevo, modifque el existente o eliminelo");
              resultadoComparacion = 1;
              $('#fila'+x).css("border-bottom","2px solid rgb(42, 70, 255)");
              break;
            }else{
              resultadoComparacion = 0;
            }
          }
          if(resultadoComparacion == 0){
            for(x = 0; x < arrayLongitud; x++){
                $('#fila'+x).css("border-bottom","1px solid #ddd");
            }
            arrayInteracciones[arrayLongitud] = {
              idMedicamento: idMedicamento,
              arrayInteraccionAmarilla: arrayInteraccionAmarilla,
              arrayInteraccionRoja: arrayInteraccionRoja
            }
            arrayPrescripcion[arrayLongitud] = {
              idMedicamento:idMedicamento,
              medicamento:medicamento,
              categoria_farmacologica:categoria_farmacologica,
              dosis:dosis,
              unidad:unidad,
              via:via,
              frecuencia:frecuencia,
              horaAplicacion:horaAplicacion,
              fechaInicio:fechaInicio,
              duracion:duracion,
              periodo:periodo,
              fechaFin:fechaFin,
              observacion:observacion,
              safe:categoria_safe,
              antibiotico:arrayAntibiotico
            }
            agregarFilaPrescripcion(arrayPrescripcion);
          }
        }else{
          arrayInteracciones[arrayLongitud] = {
            idMedicamento: idMedicamento,
            arrayInteraccionAmarilla: arrayInteraccionAmarilla,
            arrayInteraccionRoja: arrayInteraccionRoja
          }
          arrayPrescripcion[arrayLongitud] = {
            idMedicamento:idMedicamento,
            medicamento:medicamento,
            categoria_farmacologica:categoria_farmacologica,
            dosis:dosis,
            unidad:unidad,
            via:via,
            frecuencia:frecuencia,
            horaAplicacion:horaAplicacion,
            fechaInicio:fechaInicio,
            duracion:duracion,
            periodo:periodo,
            fechaFin:fechaFin,
            observacion:observacion,
            safe:categoria_safe,
            antibiotico:arrayAntibiotico
          }
          agregarFilaPrescripcion(arrayPrescripcion);
        }
      }
    }
    //pinta la fila con los datos del arraglo 'arrayPrescripcion'
    function agregarFilaPrescripcion(arrayPrescripcion, categoria_safe){
      var arrayLongitud = arrayPrescripcion.length - 1;
      var tipo_medicamento = "";
      if(arrayPrescripcion[arrayLongitud]["safe"] == "npt"){
        tipo_medicamento = "_npt";
      }else if(arrayPrescripcion[arrayLongitud]["safe"] == "oncologico" || arrayPrescripcion[arrayLongitud]["safe"] == "antimicrobiano"){
        tipo_medicamento = "_onco_antimicro";
      }

      var fila ="<tr id='fila"+arrayLongitud+"' >"+
      "<td hidden ><input name=idMedicamento"+tipo_medicamento+"[] size='1' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["idMedicamento"]+"' /></td>"+
      "<td><input readonly name='nomMedicamento[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["medicamento"]+"' /></td>"+
      // "<td>"+arrayPrescripcion[arrayLongitud]["categoria_farmacologica"]+"</td>"+
      "<td><input readonly name='dosis[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["dosis"]+" "+arrayPrescripcion[arrayLongitud]["unidad"]+"' /></td>"+
      "<td><input readonly name='via_admi[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["via"]+"' /></td>"+
      "<td><input readonly name='frecuencia[]' size='4' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["frecuencia"]+"' /></td>"+
      "<td><input readonly name='horaAplicacion[]' size='22' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["horaAplicacion"]+"' /></td>"+
      "<td><input readonly name='fechaInicio[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["fechaInicio"]+"' /></td>"+
      "<td><input readonly name='duracion[]' size='1' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["duracion"]+"' /></td>"+
      "<td><input readonly name='periodo[]' size='1' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["periodo"]+"' /></td>"+
      "<td><input readonly name='fechaFin[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["fechaFin"]+"' /></td>"+
      "<td>"+
        //"<a href='#'><i class='fa fa-pencil icono-accion' onclick=TomarDatosTablaPrescripcion("+arrayLongitud+") ></i></a>"+
        "<a href='#'> <i class='glyphicon glyphicon-remove icono-accion' onclick=EliminarFilaPrescripcion("+arrayLongitud+") ></i> </a>"+
        "<a href='#'> <i class='glyphicon glyphicon-eye-open icono-accion' onclick=MostrarOcularObservacion("+arrayLongitud+") ></i> </a>"+
      "</td>"+
      "</tr>"+
      "<tr hidden class='fila"+arrayLongitud+"Observacion'>"+
      "<td style='text-align: left; background-color:rgb(171, 171, 171);' ><strong>Observación:  </strong></td>"+
      "<td colspan='10' style='background-color:rgb(228, 228, 228); ' ><input hidden style='text-align: left;' class='fila"+arrayLongitud+"Val' value='0' />"+
      "<input readonly name='observacion[]' style='text-align: left;' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["observacion"]+"' />"+
      "</td>"+
      "</tr>"+
      "";

      var fila_npt = "",
          fila_onco_antimicro = "",
          filas_medicamentos = "";

      if(arrayPrescripcion[arrayLongitud]["safe"] == "npt"){

        fila_npt = ""+

        "<tr hidden class='fila"+arrayLongitud+"Observacion'><td colspan='11' ><strong>RECETA:NPT OVERFILL: 20 / Vol. TOTAL: "+arrayPrescripcion[arrayLongitud]["antibiotico"]["total_npt"]+" <input hidden readonly class='label-input' name=total_npt[] value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["total_npt"]+"' /> </strong></td></tr>"+
        "<tr hidden class='fila"+arrayLongitud+"Observacion'><td colspan='11' ><strong>SOLUCIÓN BASE</strong></td></tr>"+
        "<tr hidden style='background-color:rgb(228, 228, 228); ' class='fila"+arrayLongitud+"Observacion'>"+//Iformacion NPT
          "<td colspan='2' hidden><input readonly class='label-input' name='categoria_safe[]' value='"+arrayPrescripcion[arrayLongitud]["safe"]+"' /></td>"+
          "<td colspan='1'>Aminoacido</td>"+
          "<td colspan='3'>Dextrosa</td>"+
          "<td colspan='3'>Lipidos intravenosos</td>"+
          "<td colspan='4'>Agua inyectable</td>"+
        "</tr>"+
        "<tr hidden style='background-color:rgb(228, 228, 228); ' class='fila"+arrayLongitud+"Observacion'>"+
          "<td colspan='1'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["aminoacido"]+" ml"+
            "<input hidden readonly class='label-input' name='aminoacido[]' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["aminoacido"]+"' />"+
          "</td>"+
          "<td colspan='3'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["dextrosa"]+" ml"+
            "<input hidden readonly class='label-input' name='dextrosa[]' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["dextrosa"]+"' /> "+
          "</td>"+
          "<td colspan='3'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["lipidos_intravenosos"]+" ml"+
            "<input hidden readonly class='label-input' name='lipidos_intravenosos[]' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["lipidos_intravenosos"]+"' /> "+
          "</td>"+
          "<td colspan='4'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["agua_inyectable"]+" ml"+
            "<input hidden readonly class='label-input' name='agua_inyectable[]' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["agua_inyectable"]+"' /> "+
          "</td>"+
        "</tr>"+
        "<tr hidden class='fila"+arrayLongitud+"Observacion'><td colspan='10' ><strong>SALES</strong></td></tr>"+
        "<tr hidden style='background-color:rgb(228, 228, 228); ' class='fila"+arrayLongitud+"Observacion'>"+//Iformacion NPT
          "<td colspan='1'>Cloruro sodio</td>"+
          "<td colspan='2'>Sulfato magnesio</td>"+
          "<td colspan='3'>Cloruro potasio</td>"+
          "<td colspan='2'>Fosfato potasio</td>"+
          "<td colspan='3'>Gluconato calcio</td>"+
        "</tr>"+
        "<tr hidden style='background-color:rgb(228, 228, 228); ' class='fila"+arrayLongitud+"Observacion'>"+
          "<td colspan='1'><input readonly class='label-input' name='cloruro_sodio[]' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["cloruro_sodio"]+"' /> </td>"+
          "<td colspan='2'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["sulfato_magnesio"]+" ml"+
            "<input hidden readonly class='label-input' name='sulfato_magnesio[]'  value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["sulfato_magnesio"]+"' /> "+
          "</td>"+
          "<td colspan='3'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["cloruro_potasio"]+" ml"+
            "<input hidden readonly class='label-input' name='cloruro_potasio[]'  value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["cloruro_potasio"]+"' /> "+
          "</td>"+
          "<td colspan='2'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["fosfato_potasio"]+" ml"+
            "<input hidden readonly class='label-input' name='fosfato_potasio[]'  value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["fosfato_potasio"]+"' /> "+
          "</td>"+
          "<td colspan='3'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["gluconato_calcio"]+" ml"+
            "<input hidden readonly class='label-input' name='gluconato_calcio[]'  value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["gluconato_calcio"]+"' /> "+
          "</td>"+
        "</tr>"+
        "<tr hidden class='fila"+arrayLongitud+"Observacion'><td colspan='10' ><strong>ADITIVOS</strong></td></tr>"+
        "<tr hidden style='background-color:rgb(228, 228, 228); ' class='fila"+arrayLongitud+"Observacion'>"+//Iformacion NPT
          "<td colspan='1'>Insulina humana</td>"+
          "<td colspan='1'>Heparina</td>"+
          "<td colspan='1'>MVI</td>"+
          "<td colspan='2'>zinc</td>"+
          "<td colspan='2'>Albumina</td>"+
          "<td colspan='2'>Oligoelementos</td>"+
          "<td colspan='2'>vitamina C</td>"+
        "</tr>"+
        "<tr hidden style='background-color:rgb(228, 228, 228); ' class='fila"+arrayLongitud+"Observacion'>"+
          "<td colspan='1'>"+
          arrayPrescripcion[arrayLongitud]["antibiotico"]["insulina_humana"]+" ml"+
          "<input hidden readonly class='label-input' name='insulina_humana[]' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["insulina_humana"]+"' /> "+
          "</td>"+
          "<td colspan='1'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["heparina"]+" ml"+
            "<input hidden readonly class='label-input' name='heparina[]' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["heparina"]+"' /> "+
          "</td>"+
          "<td colspan='1'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["mvi_adulto"]+" ml"+
            "<input hidden readonly class='label-input' name='mvi_adulto[]' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["mvi_adulto"]+"' /> "+
          "</td>"+
          "<td colspan='2'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["zinc"]+" ml"+
            "<input hidden readonly class='label-input' name='zinc[]' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["zinc"]+"' /> "+
          "</td>"+
          "<td colspan='2'>"+

            arrayPrescripcion[arrayLongitud]["antibiotico"]["albumina"]+" ml"+
            "<input hidden readonly class='label-input' name='albumina[]'  value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["albumina"]+"' /> "+
          "</td>"+
          "<td colspan='2'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["oligoelementos"]+" ml"+
            "<input hidden readonly class='label-input' name='oligoelementos[]'  value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["oligoelementos"]+"' /> "+
          "</td>"+
          "<td colspan='2'>"+
            arrayPrescripcion[arrayLongitud]["antibiotico"]["vitamina"]+" ml"+
            "<input hidden readonly class='label-input' name='vitamina[]' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["vitamina"]+"' /> "+
          "</td>"+
        "</tr>"+
        "";

        filas_medicamentos = fila + fila_npt;

      }else if(arrayPrescripcion[arrayLongitud]["safe"] == "antimicrobiano" || arrayPrescripcion[arrayLongitud]["safe"] == "oncologico"){

        fila_onco_antimicro =
        ""+
          "<tr hidden class='fila"+arrayLongitud+"Observacion'>"+
            "<td colspan='11'><strong>RECETA: "+arrayPrescripcion[arrayLongitud]["safe"].toUpperCase()+"</strong>"+
            "<input hidden readonly name='tipo_antibiotico' value='"+arrayPrescripcion[arrayLongitud]["safe"].toUpperCase()+"' />"+
            "</td>"+
            "<td colspan='2' hidden><input readonly class='label-input' name='categoria_safe[]' value='"+arrayPrescripcion[arrayLongitud]["safe"]+"' /></td>"+
          "</tr>"+
          "<tr hidden class='fila"+arrayLongitud+"Observacion' style='background-color:rgb(171, 171, 171); '>"+
            "<td colspan='6'><strong>Diluyente</strong></td>"+
            "<td colspan='5'><strong>Vol. Diluyente</strong></td>"+
          "</tr>"+
          "<tr hidden class='fila"+arrayLongitud+"Observacion' style='background-color:rgb(228, 228, 228);' > "+
            "<td colspan='6'>"+
              "<input name='diluyente[]' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["diluyente"]+"' />"+
            "</td>"+
            "<td colspan='5'>"+
              arrayPrescripcion[arrayLongitud]["antibiotico"]["vol_diluyente"]+" ml"+
              "<input hidden name='vol_diluyente[]' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["antibiotico"]["vol_diluyente"]+"' />"+
            "</td>"+
          "</tr>"+
        "";
        filas_medicamentos = fila + fila_onco_antimicro;
      }else{
        filas_medicamentos = fila;
      }

      $('#tablaPrescripcion').append(filas_medicamentos);
      limpiarFormularioPrescripcion();
    }

    function MostrarOcularObservacion(fila){
      var observacionOculto = $('.fila'+fila+"Val").val();
      if(observacionOculto == 0){
        $('.fila'+fila+"Observacion").removeAttr("hidden");
        $('.fila'+fila+"Val").val("1");
      }else{
        $('.fila'+fila+"Observacion").attr("hidden","true");
        $('.fila'+fila+"Val").val("0");
      }
    }
    // elimina la fila de la prescripcion con el indice enviado
    function EliminarFilaPrescripcion(fila){

      $('#fila'+fila).remove();
      $('.fila'+fila+"Observacion").remove();
      arrayPrescripcion.splice(fila,1);
    }
    function RestarFechas(fecha1, fecha2){
      var fechaRegistrada = fecha1.split('/');
      var fechaActual = fecha2.split('/');
      var fecha_pasada = Date.UTC(fechaRegistrada[2],fechaRegistrada[1]-1,fechaRegistrada[0]);
      var fecha_actual = Date.UTC(fechaActual[2],fechaActual[1]-1,fechaActual[0]);
      var dif = fecha_actual - fecha_pasada;
      var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
      return dias;
    }

    function HistorialDiagnosticos(folio){
      $.ajax({
        url: base_url+"Sections/Documentos/AjaxConsultarDiagnosticos",
        type:"GET",
        dataType:"json",
        data:{
          folio: folio
        },success: function(data, textStatus, jqXHR){
          var tipo,tabla;
          $('.historial_diagnosticos').empty();

          for(var x = 0; x < data.length; x++){

            if(data[x].tipo_diagnostico == 0){
              tipo = "INGRESO";
            }else if(data[x].tipo_diagnostico == 1){
              tipo = "PRIMARIO";
            }else if(data[x].tipo_diagnostico == 2){
              tipo = "SECUNDARIO";
            }else if(data[x].tipo_diagnostico == 3){
              tipo = "EGRESO";
            }else {
              tipo = "Sin asignar";
            }

            tabla = "<tr>"+
                      "<td>"+data[x].cie10_clave+"</td>"+
                      "<td>"+data[x].cie10_nombre+"</td>"+
                      "<td>"+tipo+"</td>"+
                    "</tr>";

            $('.historial_diagnosticos').append(tabla);
          }


        },error: function (e) {
            msj_error_serve(e)
            bootbox.hideAll();
        }
      });
    }

    function NotificacionesFarmacovigilancia(folio){

      $.ajax({
        url: base_url+"Sections/Documentos/AjaxNotificacionFarmacovigilancia",
        type:"GET",
        dataType:"json",
        data:{
          folio: folio
        },success: function(data, textStatus, jqXHR){
          $("#historial_notificaciones").empty();
          var paneles = "";
          for(var x = 0; x < data.length; x++){
            console.log(data[x].notificacion_id);
            paneles =
            "<div class='panel-container'>"+
              "<div class='panel-heading' >"+
                  "<a data-toggle='collapse' class='accordion-toggle prescripcion_historial' "+
                  "style='font-size: 15px;' data-parent='#accordion' "+
                  "href='#collapse"+x+"' data-value='"+data[x].notificacion_id+"'>"+
                  data[x].medicamento + " / Destinatario: "+data[x].empleado+
                  "</a>"+
              "</div>"+
              "<div id='collapse"+x+"' class='panel-collapse collapse'>"+
                "<div class='panel-body panel_contenido_historial"+data[x].notificacion_id+"'>"+
                  data[x].notificacion+
                "</div>"+
              "</div>"+
            "</div>";
            $("#historial_notificaciones").append(paneles);
          }

        },error: function (e) {
            msj_error_serve(e)
            bootbox.hideAll();
        }
      });
    }

    function BitacoraPrescripcionMedicamento(folio){

      $.ajax({
        url: base_url+"Sections/Documentos/AjaxBitacoraPrescripciones",
        type:"GET",
        dataType:"json",
        data:{
          folio: folio
        },success: function(data, textStatus, jqXHR){
          $("#historial_movimientos").empty();
          var paneles = "";
          var medicamento_id = 0;
          var medicamento = '';
          var observacion = '';
          for(var x = 0; x < data.length; x++){

            medicamento_id = data[x].medicamento_id;
            medicamento = data[x].medicamento;

            if(medicamento_id == 1){
              observacion = data[x].observacion;
              medicamento = observacion.substring(0, observacion.indexOf("-"));
            }

            paneles =
            "<div class='panel-container'>"+
              "<div class='panel-heading' >"+
                  "<a data-toggle='collapse' class='accordion-toggle prescripcion_historial' "+
                  "style='font-size: 15px;' data-parent='#accordion' "+
                  "href='#collapse"+x+"' data-value='"+data[x].prescripcion_id+"'>"+
                  medicamento + " / Fecha Prescripción: "+data[x].fecha_prescripcion+
                  "</a>"+
              "</div>"+
              "<div id='collapse"+x+"' class='panel-collapse collapse'>"+
                "<div class='panel-body panel_contenido_historial"+data[x].prescripcion_id+"'>"+
                  "<table width='100%'>"+
                    "<thead>"+
                    "<tr>"+
                      "<th>Via</th>"+
                      "<th>Dosis</th>"+
                      "<th>Frecuencia</th>"+
                      "<th>Aplicacion</th>"+
                      "<th>Fecha Inicio</th>"+
                      "<th>Movimiento</th>"+
                      "<th>Fecha Movimiento</th>"+
                      "<th>Acciones</th>"+
                    "</tr>"+
                    "</thead>"+
                    "<tbody id='contenido_tabla_bitacora_prescripcion"+data[x].prescripcion_id+"'>"+
                    "</tbody>"+
                  "</table>"+
                "</div>"+
              "</div>"+
            "</div>";
            $("#historial_movimientos").append(paneles);
          }

        },error: function (e) {
            msj_error_serve(e)
            bootbox.hideAll();
        }
      });
    }

    function BitacoraHistorialMedicamentos(prescripcion_id,folio){

      $.ajax({
        url: base_url+"Sections/Documentos/AjaxBitacoraHistorialMedicamentos",
        type:"GET",
        dataType:"json",
        data:{
          prescripcion_id: prescripcion_id,
          folio: folio
        },success: function(data, textStatus, jqXHR){
          $('#contenido_tabla_bitacora_prescripcion'+prescripcion_id).empty();
          var medicamento_id,
              via,
              dosis,
              frecuencia,
              aplicacion,
              fecha_inicio,
              fecha,
              movimiento,
              motivo,
              datos_actualizar,
              filas,
              filas_motivo_observacion,
              motivo_actualizar,
              observacion;

          for(var x = 0; x < data.length; x++){
            medicamento_id = data[x].medicamento_id;
            observacion = data[x].observacion

            if(medicamento_id == 1){
              observacion = observacion.substring((observacion.indexOf("-") + 1), observacion.length);
            }

            movimiento = data[x].tipo_accion;
            motivo = data[x].motivo;
            if(movimiento == "Actualizar"){
              datos_actualizar = motivo.split(',');
              via = datos_actualizar[0];
              dosis = datos_actualizar[5];
              frecuencia = datos_actualizar[1];
              aplicacion = datos_actualizar[2];
              fecha_inicio = datos_actualizar[3]
              motivo_actualizar = datos_actualizar[6];
              filas_motivo_observacion =
              "<th>Observaciones:</th>"+
              "<td colspan = 3 style='text-align:left;'>"+
              observacion+
              "</td>"+
              "<th>Motivo:</th>"+
              "<td colspan = 3 style='text-align:left;'>"+
              motivo_actualizar+
              "</td>";
            }else{
              via = data[x].via_administracion;
              dosis = data[x].dosis;
              frecuencia = data[x].frecuencia;
              aplicacion = data[x].aplicacion;
              fecha_inicio = data[x].fecha_inicio;
              filas_motivo_observacion =
              "<th>Observaciones:</th>"+
              "<td colspan = 3 style='text-align:left;'>"+
              data[x].observacion+
              "</td>"+
              "<th>Motivo:</th>"+
              "<td colspan = 3 style='text-align:left;'>"+
              data[x].motivo+
              "</td>";
            }
            filas =
            "<tr>"+
              "<td width='120px'>"+via+"</td>"+
              "<td>"+dosis+"</td>"+
              "<td>"+frecuencia+"</td>"+
              "<td>"+aplicacion+"</td>"+
              "<td>"+fecha_inicio+"</td>"+
              "<td>"+data[x].tipo_accion+"</td>"+
              "<td>"+data[x].fecha+"</td>"+
              "<td><i style='padding-left: 5px;' class='glyphicon glyphicon-eye-open pointer observaciones-prescripcion' data-value='"+x+prescripcion_id+"' title='Observaciones o Motivo de  cancelacion' ></i></td>"+
            "</tr >"+
            "<tr style='background-color:#ededed;' id='historial_prescripcion_observacion"+x+prescripcion_id+"' value='0' hidden>"+
              filas_motivo_observacion+
            "</tr>";
            $('#contenido_tabla_bitacora_prescripcion'+prescripcion_id).append(filas);
          }
        },error: function (e) {
            msj_error_serve(e)
            bootbox.hideAll();
        }
      });
    }

    function ActualizarHistorialPrescripcion(folio,estado){

      $.ajax({
        url: base_url+"Sections/Documentos/AjaxPrescripciones",
        type:"GET",
        dataType:"json",
        data:{
          folio: folio,
          estado: estado
        },success: function(data, textStatus, jqXHR){
          $("#table_prescripcion_historial").empty();
          var d = new Date();
          var fechaActual = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();

          for(var x = 0; x < data.length; x++){
            var observacion = "";
            var medicamento = "";
            var accion_cancelar = "";
            var accion_editar = "";
            var accion_observaciones = "class='glyphicon glyphicon-eye-open pointer observaciones-prescripcion '";
            var total_dias = RestarFechas(data[x].fecha_inicio,fechaActual);
            var tiempo_transcurrido = "";
            var filas_dias_fechafin = "";
            var filas_diasTranscurridos_acciones = "";
            if(total_dias < 0){
              tiempo_transcurrido = "Sin iniciar";
            }else if (total_dias >= 0) {
              tiempo_transcurrido = total_dias+" dias";
            }
            if(data[x].estado == 1 || data[x].estado == 2){

              accion_cancelar = "class='glyphicon glyphicon-remove pointer desactivar-prescripcion'";

              accion_editar = "class='fa fa-pencil pointer editar-prescripcion'";
              filas_diasTranscurridos_acciones = "<td id='fila_historial_prescripcion"+data[x].prescripcion_id+"' >"+tiempo_transcurrido+"</td>"+
              "<td>"+
                "<i "+accion_cancelar+" title='Cancelar Prescripción' data-value='"+data[x].prescripcion_id+"' ></i>"+
                "<i style='padding-left: 5px;' "+accion_editar+" title='Editar Prescripcion' data-value='"+data[x].prescripcion_id+"' ></i>"+
                "<i style='padding-left: 5px;' "+accion_observaciones+" title='Observaciones' data-value='"+data[x].prescripcion_id+"' ></i>"+
              "</td>";
              $('#col_dias').text('Días Transcurridos');
              $('#col_fechaFin').text('Acciones');
              $('#col_acciones').attr('hidden','true');
              $('#col_movimiento').attr('hidden','true');
              $('#col_fecha_movimiento').attr('hidden','true');
            }else{
              filas_dias_fechafin = "<td>"+data[x].dias+"</td>"+
              "<td>"+data[x].fecha_fin+"</td>"+
              "<td>"+
                "<i style='padding-left: 5px;' "+accion_observaciones+" title='Observaciones' data-value='"+data[x].prescripcion_id+"' ></i>"+
              "</td>";
              $('#col_dias').text('Total días');
              $('#col_fechaFin').text('Fecha Fin');
              $('#col_acciones').removeAttr('hidden');
            }
            observacion = data[x].observacion;
            medicamento = data[x].medicamento;


            if(data[x].id_medicamento == 1){
              medicamento = observacion.substring(0, observacion.indexOf("-"));
              observacion = observacion.substring((observacion.indexOf("-") + 1), observacion.length);
            }
            var prescripciones = "<tr >"+
              "<td hidden id='fila_idmedicamento"+data[x].prescripcion_id+"'  >"+data[x].id_medicamento+"</td>"+
              "<td id='fila_medicamento"+data[x].prescripcion_id+"'  >"+medicamento+"</td>"+
              //"<td id='fila_categoria_farmacologica"+data[x].prescripcion_id+"'  >"+data[x].categoria_farmacologica.toUpperCase()+"</td>"+
              "<td id='fila_fecha_prescripcion"+data[x].prescripcion_id+"'  >"+data[x].fecha_prescripcion+"</td>"+
              "<td id='fila_dosis"+data[x].prescripcion_id+"'  >"+data[x].dosis+"</td>"+
              "<td id='fila_via"+data[x].prescripcion_id+"'  >"+data[x].via_administracion+"</td>"+
              "<td id='fila_frecuencia"+data[x].prescripcion_id+"'  >"+data[x].frecuencia+"</td>"+
              "<td id='fila_aplicacion"+data[x].prescripcion_id+"' style='padding: 5px;' >"+data[x].aplicacion+"</td>"+
              "<td id='fila_fecha_inicio"+data[x].prescripcion_id+"'  >"+data[x].fecha_inicio+"</td>"+
              "<td style='padding-right: 0px;' id='fila_tiempo"+data[x].prescripcion_id+"'  >"+data[x].tiempo+"</td>"+
              "<td style='padding-left: 0px;' id='fila_periodo"+data[x].prescripcion_id+"' style='padding: 5px;' >"+data[x].periodo+"</td>"+
              "<td id='fila_fecha_"+data[x].prescripcion_id+"'  >"+data[x].fecha_fin+"</td>"+
              filas_dias_fechafin+
              filas_diasTranscurridos_acciones+
            "</tr>"+
            "<tr id='historial_prescripcion_observacion"+data[x].prescripcion_id+"' hidden value='0'>"+
              "<th style='background-color:rgb(210, 210, 210);'>Observaciones: </th>"+
              "<td id='fila_observacion"+data[x].prescripcion_id+"' colspan='12' style='text-align:left; background-color:rgb(235, 235, 235);' >"+
                observacion+
              "</td>"+
            "</tr>";
            $("#table_prescripcion_historial").append(prescripciones);
          }
        },error: function (e) {
            msj_error_serve(e)
            bootbox.hideAll();
        }
      });
    }

    function actualizarPrescripcion(){
      var indice = $('#indiceArrayPrescripcion').val();
      EliminarFilaPrescripcion(indice);
      agregarPrescripcion();
      $('#tablaPrescripcion').empty();
      var longitud = arrayPrescripcion.length

        for(var x = 0; x < longitud; x++){
            var fila ="<tr id='fila"+x+"' >"+
            "<td hidden ><input type='text' name=idMedicamento[] size='1' class='label-input' value='"+arrayPrescripcion[x]["idMedicamento"]+"' /></td>"+
            "<td>"+arrayPrescripcion[x]["medicamento"]+"</td>"+
            "<td><input readonly type='text' name='dosis[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["dosis"]+" "+arrayPrescripcion[x]["unidad"]+"' /></td>"+
            "<td><input readonly type='text' name='via[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["via"]+"' /></td>"+
            "<td><input readonly type='text' name='frecuencia[]' size='4' class='label-input' value='"+arrayPrescripcion[x]["frecuencia"]+"' /></td>"+
            "<td><input readonly type='text' name='horaAplicacion[]' size='22' class='label-input' value='"+arrayPrescripcion[x]["horaAplicacion"]+"' /></td>"+
            "<td><input readonly type='text' name='fechaInicio[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["fechaInicio"]+"' /></td>"+
            "<td><input readonly type='text' name='duracion[]' size='1' class='label-input' value='"+arrayPrescripcion[x]["duracion"]+"' /></td>"+
            "<td><input readonly type='text' name='periodo[]' size='1' class='label-input' value='"+arrayPrescripcion[x]["periodo"]+"' /></td>"+
            "<td><input readonly type='text' name='fechaFin[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["fechaFin"]+"' /></td>"+
            "<td>"+
              //"<a href='#'><i class='fa fa-pencil icono-accion' onclick=TomarDatosTablaPrescripcion("+x+") ></i></a>"+
              "<a href='#'> <i class='glyphicon glyphicon-remove icono-accion' onclick=EliminarFilaPrescripcion("+x+") ></i> </a>"+
              "<a href='#'> <i class='glyphicon glyphicon-eye-open icono-accion' onclick=MostrarOcularObservacion("+x+") ></i> </a>"+
            "</td>"+
            "</tr>"+
            "<tr hidden style='background-color:rgb(228, 228, 228);' class='fila"+x+"Observacion'>"+
              "<td style='text-align: right;'><strong>Observación:</strong>  </td>"+
              "<td colspan='10' ><input hidden  class='fila"+x+"Val' value='0' />"+
                "<input readonly type='text' id='' name='observacion[]' style='text-align: left;' class='label-input' value='"+arrayPrescripcion[x]["observacion"]+"' />"+
              "</td>"+
            "</tr>"+
            "<tr>"+//Iformacion NPT
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
            "</tr>"+
            "<tr>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
              "<td>123</td>"+
            "</tr>"+//Fin informacion npt
            "";
            $('#tablaPrescripcion').append(fila);
            $('#div_btnActualizarPrescripcion').attr("hidden","true");
        }
    }

    function TomarDatosTablaPrescripcion(fila){
      $('#div_btnActualizarPrescripcion').removeAttr("hidden");
      $('#indiceArrayPrescripcion').val(fila);
      $('#select_medicamento').select2('val',arrayPrescripcion[fila]["idMedicamento"]).select2();
      $('#input_dosis').val(arrayPrescripcion[fila]["dosis"]);
      $('#select_unidad').val(arrayPrescripcion[fila]["unidad"]);
      $('#via').select2('val',arrayPrescripcion[fila]["via"]).select2();
      $('#frecuencia').val(arrayPrescripcion[fila]["frecuencia"]);
      $('#aplicacion').val(arrayPrescripcion[fila]["horaAplicacion"]);
      $('#fechaInicio').val(arrayPrescripcion[fila]["fechaInicio"]);
      $('#duracion').val(arrayPrescripcion[fila]["duracion"]);
      $('#fechaFin').val(arrayPrescripcion[fila]["fechaFin"]);
      $('#observacion').val(arrayPrescripcion[fila]["observacion"]);
      revisarCamposVaciosPrescripcion();
    }

    function sumarfecha(d, fecha){
     var Fecha = new Date();
     var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
     var sep = sFecha.indexOf('/') != -1 ? '/' : '-';
     var aFecha = sFecha.split(sep);
     var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
     fecha= new Date(fecha);
     fecha.setDate(fecha.getDate()+parseInt(d));
     var anno=fecha.getFullYear();
     var mes= fecha.getMonth()+1;
     var dia= fecha.getDate();
     mes = (mes < 10) ? ("0" + mes) : mes;
     dia = (dia < 10) ? ("0" + dia) : dia;
     var fechaFinal = dia+sep+mes+sep+anno;
     return (fechaFinal);
    }

    function ConteoEstadoPrescripcion(folio){
      $.ajax({
        url: base_url+"Sections/Documentos/AjaxConteoEstadoPrescripciones",
        type: 'GET',
        dataType: 'json',
        data:{
          folio:folio
        },
        success: function(data, textStatus, jqXHR){
          $('#label_total_activas').text(data.Prescripciones_activas[0].activas);
          $('#label_total_canceladas').text(data.Prescripciones_canceladas.length);
        },error: function (e) {
            bootbox.hideAll();
            msj_error_serve();
        }
      });
    }

    function RegistrarAccionBitacoraPrescripcion(prescripcion_id,tipo_accion,motivo){
        $.ajax({
           url: base_url+"Sections/Documentos/AjaxRegistrarBitacoraPrescripcion",
           type: 'GET',
           dataType: 'json',
           data:{
             prescripcion_id : prescripcion_id,
             tipo_accion : tipo_accion,
             motivo : motivo
           },
           success: function(data, textStatus, jqXHR){

           },error: function (e) {
               bootbox.hideAll();
               msj_error_serve();
           }
        });
    }

    function DatosTabplaPrescripcionActivas(prescripcion_id){

        var datos = {
            prescripcion_id : prescripcion_id,
            medicamento_id : $('#fila_idmedicamento'+prescripcion_id).text(),
            medicamento : $('#fila_medicamento'+prescripcion_id).text(),
            fecha_prescripcion : $('#fila_fecha_prescripcion'+prescripcion_id).text(),
            via : $('#fila_via'+prescripcion_id).text(),
            frecuencia : $('#fila_frecuencia'+prescripcion_id).text(),
            aplicacion : $('#fila_aplicacion'+prescripcion_id).text(),
            fecha_inicio : $('#fila_fecha_inicio'+prescripcion_id).text(),
            observacion : $('#fila_observacion'+prescripcion_id).text(),
            tiempo : $('#fila_tiempo'+prescripcion_id).text(),
            periodo : $('#fila_periodo'+prescripcion_id).text(),
            dosis: $('#fila_dosis'+prescripcion_id).text()
        }
        return datos;
    }

    function TipoMedicamento(medicamento_id){
      $.ajax({
        url: base_url+"Sections/Documentos/AjaxTipoMedicamento",
        type: 'GET',
        dataType: 'json',
        data:{
          medicamento_id:medicamento_id
        },
        success: function(data, textStatus, jqXHR){
          $('.tiempo_tipo_medicamento').empty();
          var formulario = "";
          var farmacologica = "null";
          if(data.length > 0){
              farmacologica = data[0].categoria_farmacologica;
          }

          if(farmacologica.toLowerCase() == 'antibiotico'){
            formulario =
            "<div class='col-sm-1' style='padding: 0;' >"+
              "<label id='categoria_farmacologica' hidden>"+farmacologica+"</label>"+
              "<label><b>Dias</b></label>"+
              "<div id='borderDuracion'>"+
              "<select id='duracion' onchange='mostrarFechaFin()' class='form-control' >"+
                "<option value='0'>0</option>"+
                "<option value='1'>1</option>"+
                "<option value='2'>2</option>"+
                "<option value='3'>3</option>"+
                "<option value='4'>4</option>"+
                "<option value='5'>5</option>"+
                "<option value='6'>6</option>"+
                "<option value='7'>7</option>"+
                "<option value='8'>8</option>"+
                "<option value='9'>9</option>"+
                "<option value='10'>10</option>"+
              "</select>"+
              "</div>"+
            "</div>"+
            "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
              "<label><b>Fecha Fin</b></label>"+
              "<div id='borderFechaFin'>"+
              "<input class='form-control' id='fechaFin'  disabled='disabled'>"+
              "</div>"+
            "</div>";
          }else{
            formulario =
            "<div class='col-sm-1' style='padding-right: 0; padding-left: 0;' >"+
              "<label id='categoria_farmacologica' hidden>"+farmacologica+"</label>"+
              "<label><b>Duración</b></label>"+
              "<div class='input-group'>"+
                "<input type='number' min='0' class='form-control' id='duracion' onchange='mostrarFechaFin()' >"+
              "</div>"+
              /*
              "<div class='input-group' >"+
                "<input type='text' class='form-control' id='duracion' onchange='mostrarFechaFin()' >"+
                "<span class='input-group-btn'>"+
                  "<div class='col-sm-12' style=''>"+
                  "<a class='btn' title='Aumentar' onClick=AumentarNum() style='padding=0;margin-left:-28px; margin-top:-8px;' ><span style='border:1px solid #000; width:20px; height:17px;' class='glyphicon glyphicon-menu-up'></span></a>"+
                  "</div>"+
                  "<div class='col-sm-12' style=''>"+
                  "<a class='btn' title='Reducir' onClick=ReducirNum() style='padding=0;margin-left:-28px; margin-top:-17px;' ><span style='border:1px solid #000; width:20px; height:17px;' class='glyphicon glyphicon-menu-down'></span></a>"+
                  "</div>"+
                "</span>"+
              "</div>"+
              */
            "</div>"+
            "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
              "<label><b>Periodo</b></label>"+
              "<select class='form-control' id='periodo' onchange='mostrarFechaFin()'>"+
                "<option value='Dias'>Dias</option>"+
                "<option value='Semanas'>Semanas</option>"+
              "</select>"+
            "</div>"+
            "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
              "<label><b>Fecha Fin</b></label>"+
              "<div id='borderFechaFin'>"+
              "<input class='form-control' id='fechaFin' disabled='disabled' >"+
              "</div>"+
            "</div>";
          }
          $('.tiempo_tipo_medicamento').append(formulario);
        },error: function (e) {
            bootbox.hideAll();
            msj_error_serve();
        }
      });
    }

    function AumentarNum(){
      var numero = $('#duracion').val();
      if(numero != ''){
        $('#duracion').val(Number(numero) + 1);
      }else{
        $('#duracion').val('0');
      }
      mostrarFechaFin();
    }

    function ReducirNum(){
      var numero = $('#duracion').val();
      if(numero == 0 || numero < 0){
        $('#duracion').val('0');
      }else{
        $('#duracion').val(Number(numero) - 1);
      }
      mostrarFechaFin();
    }

    function ConvercionDias(tiempo, periodo){

      var dias = 0;
      if(periodo == 'Dias'){
        dias = tiempo;
      }else if(periodo == 'Semanas'){
          dias = tiempo * 7;
      }
      return dias;
    }

    function multiplo(valor, multiplo){

        var resto = valor % multiplo;
        if(resto==0){
          return true;
        }else{
          return false;
        }
    }

    function ConsultarUltimasOrdenes(folio){
      $.ajax({
          url:base_url+'Sections/Documentos/AjaxUltimasOrdenes',
          type: 'get',
          dataType: 'json',
          data:{
              folio:folio
          },success: function (data, textStatus, jqXHR) {

            var nutricion = data[0].nota_nutricion,
                signoscuidados = data[0].nota_svycuidados,
                cgenfermeria = data[0].nota_cgenfermeria,
                cuidadosenfermeria = data[0].nota_cuidadosenfermeria,
                solucionesp = data[0].nota_solucionesp;

            // si la variable es indefinida, significa que no hay nota de evolucion
            // por lo que tomara los datos de la hoja frontal
            if(nutricion == undefined){
              nutricion = data[0].hf_nutricion,
              signoscuidados = data[0].hf_signosycuidados,
              cgenfermeria = data[0].hf_cgenfermeria,
              cuidadosenfermeria = data[0].hf_cuidadosenfermeria,
              solucionesp = data[0].hf_solucionesp;
            }

            //asignacion nuticion
            if(nutricion == 0){
              $('#radioAyuno').attr('checked',true);
            }else if(nutricion >= 1 || nutricion <= 12){
              $('#radioDieta').attr('checked',true);
              $('#divSelectDietas').removeAttr('hidden');
              $('#selectDietas').val(nutricion);
            }else{
              $('#radioDieta').attr('checked',true);
              $('#divSelectDietas').removeAttr('hidden');
              $('#selectDietas').val(13);
              $('#divOtraDieta').removeAttr('hidden');
              $('#inputOtraDieta').val(nutricion);
            }
            //asignacion toma de signoscuidados
            if(signoscuidados <=3){
              $('#selectTomaSignos').val(signoscuidados);
            }else{
              $('#selectTomaSignos').val(3);
              $('#divOtrasInidcacionesSignos').removeAttr('hidden');
              $('#otras-indicaciones-signos').val(signoscuidados);
            }
            //asignacion cuidados generales de enfermeria
            if(cgenfermeria == 1){
              $('#checkCuidadosGenerales').attr('checked',true);
              $('#labelCheckCuidadosGenerales').text("");
              $('#listCuidadosGenerales').removeAttr('hidden');
            }

            


          },error: function (jqXHR, textStatus, errorThrown) {
              bootbox.hideAll();
              MsjError();
          }
      });
    }

    function ConsultarClaveCIE10(valor_clave,lista,indice,id_cie10){

      var diagnostico = $('.btn_diagnostico_cie10_'+lista).text();
      $('#text_diagnostico_'+indice).val(diagnostico);
      $('#text_codigo_diagnostico_'+indice).val(valor_clave);
      $('#text_id_diagnostico_'+indice).val(id_cie10);
      $('#lista_resultado_diagnosticos_'+indice).empty();
    }
    function BorrarDiagnosticoDinamico(indice){
      $('#form_diagnosticos_secundarios_'+indice).remove();
    }

    function BuscarDiagnostico(indice){

      $('#lista_resultado_diagnosticos_'+indice).empty();
      var diagnostico_solicitado = $('#text_diagnostico_'+indice).val();

      var lista_opciones = "";
      var tipo_diagnostico = $('input:radio[name=tipo_diagnostico_'+indice+']:checked').val();
      var ruta_tipo_diagnostico = "";
      //condicion para validar que un input sea seleccionado y filtrar la busqueda
      //if(diagnostico_solicitado.length >= 3 && tipo_diagnostico != null){
      if(diagnostico_solicitado.length >= 3){
        /*
        if(tipo_diagnostico == 0){
          ruta_tipo_diagnostico = "AjaxDiagnosticosFrecuentes";
        }else if(tipo_diagnostico == 1){
          ruta_tipo_diagnostico = "AjaxDiagnosticos";
        }
        */

        $.ajax({
            url:base_url+'Sections/Documentos/AjaxDiagnosticos',
            type: 'get',
            dataType: 'json',
            data:{
                diagnostico_solicitado:diagnostico_solicitado
            },success: function (data, textStatus, jqXHR) {
              $('#lista_resultado_diagnosticos_'+indice).empty();
                for(var x = 0; x < data.length; x++){
                  lista_opciones =
                  "<li class='lista_diagnosticos' id='lista_diagnosticos_"+indice+"' >"+
                    "<a onclick=ConsultarClaveCIE10('"+data[x].cie10_clave+"',"+x+","+indice+","+data[x].cie10_id+") class='btn_diagnostico_cie10_"+x+"' id='btn_diagnostico_cie10'>"+data[x].cie10_nombre+"</a>"+
                  "</li>";

                  $('#lista_resultado_diagnosticos_'+indice).append(lista_opciones);
                }
            },error: function (jqXHR, textStatus, errorThrown) {
                bootbox.hideAll();
                MsjError();
            }
        });
      }
      /*
      else if(tipo_diagnostico == null){
        alert("Indicar CIE-10 o Frecuentes");
      }
      */
    }

    function RegistrarEfectoAdverso(prescripcion_id, paciente, motivo){
      $.ajax({
          url:base_url+'Sections/Documentos/AjaxRegistrarEfectoAdverso',
          type: 'get',
          dataType: 'json',
          data:{
              prescripcion_id : prescripcion_id,
              paciente : paciente,
              motivo : motivo
          },success: function (data, textStatus, jqXHR) {
            $('#label_total_reacciones').text(data.length);
          },error: function (jqXHR, textStatus, errorThrown) {
              bootbox.hideAll();
              MsjError();
          }
      });
    }

    function HistorialAlergiaMedicamentos(paciente){
        $.ajax({
              url:base_url+'Sections/Documentos/AjaxHistorialAlergiaMedicamentos',
              type: 'get',
              dataType: 'json',
              data:{
                  paciente:paciente
              },success: function (data, textStatus, jqXHR) {
                $('#table_historial_alergia_medicamentos').empty();
                var fila = "";
                var count = 0;
                data.forEach(function(val){
                  count = count + 1;
                  fila = count + ") "+ val.medicamento+ "&nbsp;&nbsp;&nbsp;";
                  $('#table_historial_alergia_medicamentos').append(fila);
                });


              },error: function (jqXHR, textStatus, errorThrown) {
                  bootbox.hideAll();
                  MsjError();
              }
        });
    }

    function HitorialReaccionesAdversas(paciente){
        $.ajax({
          url:base_url+'Sections/Documentos/AjaxHistorialReaccionesAdversas',
          type: 'get',
          dataType: 'json',
          data:{
              paciente:paciente
          },success: function (data, textStatus, jqXHR) {
            $('#table_historial_reacciones').empty();
            var fila = "";

            data.forEach(function(val){
              fila = "<tr>"+
                     "<td>"+val.medicamento+"</td>"+
                     "<td>"+val.efecto+"</td>"+
                     "</tr>";
              $('#table_historial_reacciones').append(fila);
            });


          },error: function (jqXHR, textStatus, errorThrown) {
              bootbox.hideAll();
              MsjError();
          }
        });
    }

    function AccionPanelPrescripcion(tipo_accion , paciente){

      $("#historial_medicamentos_activos").attr('hidden',true);
      $("#historial_movimientos").attr('hidden',true);
      $("#historial_reacciones").attr('hidden',true);
      $("#historial_notificaciones").attr('hidden',true);
      $("#historial_alergia_medicamentos").attr('hidden',true);

      switch (tipo_accion) {
        case 1:
            $("#historial_medicamentos_activos").removeAttr('hidden');
            ActualizarHistorialPrescripcion(paciente,"1");
          break;
        case 2:
            $("#historial_movimientos").removeAttr('hidden');
            BitacoraPrescripcionMedicamento(paciente);
          break;
        case 3:
            $("#historial_reacciones").removeAttr('hidden');
            HitorialReaccionesAdversas(paciente);
          break;
        case 4:
            $("#historial_notificaciones").removeAttr('hidden');
          break;
        case 5:
          $("#historial_alergia_medicamentos").removeAttr('hidden');
          HistorialAlergiaMedicamentos(paciente);
          break;
        case 6:
          $("#historial_medicamentos_activos").removeAttr('hidden');
          ActualizarHistorialPrescripcion(paciente,"1");
          break;
        case 7:
          $("#historial_notificaciones").removeAttr('hidden');
          NotificacionesFarmacovigilancia(paciente);
          break;
      }
    }

    function OtroDiluyente(){
        var diluyente_original = "";
        var val_opcion = $('#btn_otro_diluyente').val();
        var soluciones = ['Cloruro de sodio 0.9%','SSF 0.9%','SGluc 5%'];
        var opciones = "";
        if(diluyente_original == ""){
            diluyente_original = $('#select_diluyente').val();
        }

        $('#select_diluyente').empty();
            switch (val_opcion) {
                case "0":
                    $('#btn_otro_diluyente').val(1);
                    opciones = "<option value='0'>- Seleccionar otro diluyente -</option>";
                    $('#select_diluyente').append(opciones);
                    soluciones.forEach(function(val){
                        opciones = "<option value='"+val+"'>"+val+"</option>";
                    $('#select_diluyente').append(opciones);
                    });
                    break;
                case "1":
                    $('#btn_otro_diluyente').val(0);
                    $('#select_diluyente').append("<option value='"+diluyente_original+"'>"+diluyente_original+"</option>");
                    break;
            }
    }

    function FormularioAntimicrobianoOncologico(){
      var medicamento_id = $('#select_medicamento').val();

      $.ajax({
          url: base_url+"Sections/Documentos/AjaxConsultarDiluyente",
          type: 'GET',
          dataType: 'json',
          data:{
            medicamento_id:medicamento_id
          },success: function (data, textStatus, jqXHR) {
            var diluyente = data[0].diluyente,
                vol_diluyente = data[0].volumen_diluyente;

            $('.diluyente').val(diluyente);
            $('.vol_diluyente').val(vol_diluyente);

            bootbox.confirm({
              title: "Antimicrobiano / Oncologico",
              message: "<label><b>Diluyente</b></label>"+
                        "<div class='input-group'>"+
                          "<select class='form-control' id='select_diluyente'><option value='"+diluyente+"' >"+diluyente+"</option></select>"+
                          "<span class='input-group-btn'>"+
                            "<button class='btn btn-default edit-aplicacion' id='btn_otro_diluyente' onClick=OtroDiluyente(); type='button' value='0' title='Cambiar el diluyente'>Cambiar</button>"+
                          "</span>"+
                        "</div>"+
                        "<label><b>Vol. Diluyente</b></label>"+
                        '<div class="input-group">'+
                          '<input type="text" class="form-control" placeholder="Volumen de diluyente" value='+vol_diluyente+' />'+
                          '<span class="input-group-addon ">ml</span>'+
                        '</div>',
              buttons: {
                confirm: {
                    label: 'Aceptar',
                    className: 'back-imss'
                },
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-basic'
                }
              },
              callback:function(result){

              }
            });

          },error: function (e) {
              msj_error_serve();
          }
      });
    }

    function FormularioNPT(){
      bootbox.confirm({
        title: "OVERFILL: 20 / Vol. Total: <label id='vol_total_npt'>"+$('.total-npt').val()+"</label> ",
        message: '<span class="input-group-addon back-imss border-back-imss"><strong>Solucion Base:</strong></span>'+

                '<div class="row">'+
                   '<div class="col-sm-4">'+
                   '<label>Aminoácidos Cristalinos 10% adultos</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-aminoacido" placeholder="0" value="'+$(".aminoacido").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                   '</div>'+
                   '<div class="col-sm-4">'+
                   '<label>Dextrosa al 50% <br>.</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-dextrosa" placeholder="0" value="'+$(".dextrosa").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                   '</div>'+
                   '<div class="col-sm-4">'+
                   '<label>Lipidos Intravenosos con Acidos grasos, Omega 3 y 9</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-lipidos-intravenosos" placeholder="0" value="'+$(".lipidos-intravenosos").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                   '</div>'+
                   '<div class="col-sm-4">'+
                   '<label>Agua Inyectable</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-agua-inyectable" placeholder="0" value="'+$(".agua-inyectable").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                   '</div>'+
                 '</div>'+
                 '<div style="padding-top:10px" ></div><span class="input-group-addon back-imss border-back-imss"><strong>Sales:</strong></span>'+
                  '<div class="row">'+
                   '<div class="col-sm-4">'+
                   '<label>Cloruro de Sodio 17.7% <br>.</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-cloruro-sodio" placeholder="0" value="'+$(".cloruro-sodio").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                   '</div>'+
                   '<div class="col-sm-4">'+
                   '<label>Sulfato de Magnesio (0.81) mEq/ml</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-sulfato-magnesio" placeholder="0" value="'+$(".sulfato-magnesio").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                   '</div>'+
                   '<div class="col-sm-4">'+
                   '<label>Cloruro de Potasio (4 mEq/ml K)</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-cloruro-potasio" placeholder="0" value="'+$(".cloruro-potasio").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                   '</div>'+
                   '<div class="col-sm-4">'+
                   '<label>Fosfato de Potasio (2 mEq/ml k/1.11 m mol PO4)</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-fosfato-potasio" placeholder="0" value="'+$(".fosfato-potasio").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                   '</div>'+
                   '<div class="col-sm-4">'+
                   '<label>Gluconato de Calcio (0.465 mEq/ml)</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-gluconato-calcio" placeholder="0" value="'+$(".gluconato-calcio").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                   '</div>'+

                   '</div>'+
                '<div style="padding-top:10px" ></div><span class="input-group-addon back-imss border-back-imss"><strong>Aditivos:</strong></span>'+
                '<div class="row">'+
                   '<div class="col-sm-4">'+
                   '<label>Albúmina 20% (0.20 g/ml)</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-albumina" placeholder="0" value="'+$(".albumina").val()+'" />'+
                     '<span class="input-group-addon ">gr</span>'+
                   '</div>'+
                   '</div>'+
                   '<div class="col-sm-4">'+
                   '<label>Heparina (1000 UI/ml)</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-heparina" placeholder="0" value="'+$(".heparina").val()+'" />'+
                     '<span class="input-group-addon ">UI</span>'+
                   '</div>'+
                  '</div>'+
                  '<div class="col-sm-4">'+
                   '<label>Insulina Humana (100 UI/ml)</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-insulina-humana" placeholder="0" value="'+$(".insulina-humana").val()+'" />'+
                     '<span class="input-group-addon ">UI</span>'+
                   '</div>'+
                  '</div>'+
                  '<div class="col-sm-4">'+
                   '<label>Zinc</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-zinc" placeholder="0" value="'+$(".zinc").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                  '</div>'+
                  '<div class="col-sm-4">'+
                   '<label>MVI - Adulto</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-mvi-adulto" placeholder="0" value="'+$(".mvi-adulto").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                  '</div>'+
                  '<div class="col-sm-4">'+
                   '<label>Oligoelementos Tracefusin</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-oligoelementos" placeholder="0" value="'+$(".oligoelementos").val()+'" />'+
                     '<span class="input-group-addon ">ml</span>'+
                   '</div>'+
                   '</div>'+
                   '<div class="col-sm-4">'+
                   '<label>Vitamina C (100 mg/ml)</label>'+
                   '<div class="input-group">'+
                     '<input type="number" min="0" class="sum-total-npt form-control modal-vitamina" placeholder="0" value="'+$(".vitamina").val()+'" />'+
                     '<span class="input-group-addon ">mg</span>'+
                   '</div>'+
                   '</div>'+
                   '</div>'+
                 '</div>',
        buttons: {
          confirm: {
              label: 'Aceptar',
              className: 'back-imss'
          },
          cancel: {
              label: 'Cancelar',
              className: 'btn-basic'
          }
        },
        callback: function(result){
          if(result){
            $('.aminoacido').val($('.modal-aminoacido').val());
            $('.dextrosa').val($('.modal-dextrosa').val());
            $('.lipidos-intravenosos').val($('.modal-lipidos-intravenosos').val());
            $('.agua-inyectable').val($('.modal-agua-inyectable').val());
            $('.cloruro-sodio').val($('.modal-cloruro-sodio').val());
            $('.sulfato-magnesio').val($('.modal-sulfato-magnesio').val());
            $('.cloruro-potasio').val($('.modal-cloruro-potasio').val());
            $('.fosfato-potasio').val($('.modal-fosfato-potasio').val());
            $('.gluconato-calcio').val($('.modal-gluconato-calcio').val());
            $('.albumina').val($('.modal-albumina').val());
            $('.heparina').val($('.modal-heparina').val());
            $('.insulina-humana').val($('.modal-insulina-humana').val());
            $('.zinc').val($('.modal-zinc').val());
            $('.mvi-adulto').val($('.modal-mvi-adulto').val());
            $('.oligoelementos').val($('.modal-oligoelementos').val());
            $('.vitamina').val($('.modal-vitamina').val());
            $('.total-npt').val($('#vol_total_npt').text());
          }else{
            $('.modal-aminoacido').val("");
            $('.modal-dextrosa').val("");
            $('.modal-lipidos-intravenosos').val("");
            $('.modal-agua-inyectable').val("");
            $('.modal-cloruro-sodio').val("");
            $('.modal-sulfato-magnesio').val("");
            $('.modal-cloruro-potasio').val("");
            $('.modal-fosfato-potasio').val("");
            $('.modal-gluconato-calcio').val("");
            $('.modal-albumina').val("");
            $('.modal-heparina').val("");
            $('.modal-insulina-humana').val("");
            $('.modal-zinc').val("")
            $('.modal-mvi-adulto').val("");
            $('.modal-oligoelementos').val("");
            $('.modal-vitamina').val("");
            $('#vol_total_npt').text("0")
          }
        }
      });
    }

    function ConsultarViasAdministracion(){
      var medicamento = $('#select_medicamento option:selected').text().substr(0,4);
      $.ajax({
          url: base_url+"Sections/Documentos/AjaxConsultarViasAdministracion",
          type: 'GET',
          dataType: 'json',
          data:{
            medicamento:medicamento
          },success: function (data, textStatus, jqXHR) {
            var option = "";
            $('#via').empty();
            option = "<option value='0'>-Seleccionar-</option>";
            $('#via').append(option);
            for(var x = 0; x < data.length; x++){
              option = "<option value="+data[x].via+">"+data[x].via+"</option>";
              $('#via').append(option);
            }
          },error: function (e) {
              msj_error_serve();
          }
      });
    }

    function MostrarDiagnosticoComplementario(indice){
      var estado = $('#btn_diagnostico_complementario_'+indice).val();
      switch (estado) {
        case '0':
            $('#btn_diagnostico_complementario_'+indice).val('1');
            $('#div_complento_diagnostico_'+indice).removeAttr('hidden');
          break;
        case '1':
            $('#btn_diagnostico_complementario_'+indice).val('0');
            $('#div_complento_diagnostico_'+indice).attr('hidden', true);
          break;
      }
    }
    function importarUltimaNota(folio){
      $.ajax({
          url:base_url+'Sections/Documentos/AjaxUltimaNota',
          type: 'post',
          dataType: 'json',
          data:{
              folio:folio
          },success: function (data, textStatus, jqXHR) {

            var nutricion = data[0].nota_nutricion,
                signoscuidados = data[0].nota_svycuidados,
                cgenfermeria = data[0].nota_cgenfermeria,
                cuidadosenfermeria = data[0].nota_cuidadosenfermeria,
                solucionesp = data[0].nota_solucionesp;

            // si la variable es indefinida, significa que no hay nota de evolucion
            // por lo que tomara los datos de la hoja frontal
            if(nutricion == undefined){
              nutricion = data[0].hf_nutricion,
              signoscuidados = data[0].hf_signosycuidados,
              cgenfermeria = data[0].hf_cgenfermeria,
              cuidadosenfermeria = data[0].hf_cuidadosenfermeria,
              solucionesp = data[0].hf_solucionesp;
            }

            //asignacion nuticion
            if(nutricion == 0){
              $('#radioAyuno').attr('checked',true);
            }else if(nutricion >= 1 || nutricion <= 12){
              $('#radioDieta').attr('checked',true);
              $('#divSelectDietas').removeAttr('hidden');
              $('#selectDietas').val(nutricion);
            }else{
              $('#radioDieta').attr('checked',true);
              $('#divSelectDietas').removeAttr('hidden');
              $('#selectDietas').val(13);
              $('#divOtraDieta').removeAttr('hidden');
              $('#inputOtraDieta').val(nutricion);
            }
            //asignacion toma de signoscuidados
            if(signoscuidados <=3){
              $('#selectTomaSignos').val(signoscuidados);
            }else{
              $('#selectTomaSignos').val(3);
              $('#divOtrasInidcacionesSignos').removeAttr('hidden');
              $('#otras-indicaciones-signos').val(signoscuidados);
            }
            //asignacion cuidados generales de enfermeria
            if(cgenfermeria == 1){
              $('#checkCuidadosGenerales').attr('checked',true);
              $('#labelCheckCuidadosGenerales').text("");
              $('#listCuidadosGenerales').removeAttr('hidden');
            }

            $('textarea[name=nota_cuidadosenfermeria]').data("wysihtml5").editor.setValue(cuidadosenfermeria);
            $('textarea[name=nota_solucionesp]').data("wysihtml5").editor.setValue(solucionesp);


          },error: function (jqXHR, textStatus, errorThrown) {
              bootbox.hideAll();
              MsjError();
          }
      });
     }
