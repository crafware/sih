<?php ob_start(); ?>
<page backtop="80mm" backbottom="50mm" backleft="48" backright="1mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/DOC430128_HF.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">
        <div style="position: absolute;margin-top: 15px">
            <div style="position: absolute;top: 80px;left: 120px;width: 270px;">
                <!--<b><?=_UM_CLASIFICACION?> | <?=_UM_NOMBRE?></b> -->
            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 50px;width: 270px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>NOMBRE DEL PACIENTE:</b>
            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 61px;width: 350px;text-transform: uppercase;font-size: 14px;text-align: left;">
                <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
            </div>
            <div style="position: absolute;margin-left: 437px;margin-top: 75px;width: 270px;text-transform: uppercase;font-size: 13px;">
                <b>N.S.S:</b> <?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?>
            </div>
            <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac'])); ?>
            <div style="position: absolute;margin-left: 437px;margin-top: 95px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -2px">
                    <b>EDAD:</b> <?=$fecha->y==0 ? $fecha->m.' MESES' : $fecha->y.' AÑOS'?>
                </p>
                <p style="margin-top: -10px">
                    <b>UMF:</b> <?=$PINFO['pum_umf']?>/<?=$PINFO['pum_delegacion']?>
                </p>
                <p style="margin-top: -10px">
                    <b><?=$hoja['hf_atencion']?></b>
                </p>

            </div>
            <div style="position: absolute;margin-left: 540px;margin-top: 95px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -2px">
                    <b>GENERO:</b> <?=$info['triage_paciente_sexo']?>
                </p>
                <p style="margin-top: -10px">
                    <b>PROCEDE:</b> <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEO' : 'REFERENCIADO'?>
                </p>
                <p style="margin-top: -10px">
                    <b>ATENCION:</b><?=$PINFO['pia_tipo_atencion']?>
                </p>
            </div>

            <div style="position: absolute;margin-left: 437px;margin-top: 136px;width: 270px;text-transform: uppercase;font-size: 11px;">
             <?php if($PINFO['pia_procedencia_espontanea']=='No'){?>

                <p style="margin-top: -7px">
                    <b>4-30-8/NM:</b> <?=$PINFO['pia_procedencia_hospital']?> <?=$PINFO['pia_procedencia_hospital_num']?>
                </p>
                 <?php }?>
            </div>

            <div style="position: absolute;margin-left: 437px;margin-top: 154px;width: 300px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -10px">
                   <b>DOMICILIO: </b> <?=$DirPaciente['directorio_cn']?>, <?=$DirPaciente['directorio_colonia']?>, <?=$DirPaciente['directorio_cp']?>, <?=$DirPaciente['directorio_municipio']?>, <?=$DirPaciente['directorio_estado']?> <B>TEL:</B><?=$DirPaciente['directorio_telefono']?>
                </p>
            </div>
            <div style="position: absolute;margin-left: 437px;margin-top: 185px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -1px">
                    <b>FOLIO:</b> <?=$info['triage_id']?>
                </p>
               <p style="margin-top: -10px">
                    <b>H. INICIO Triage:</b> <?=$info['triage_hora']?>
                </p>
                <p style="margin-top: -7px">
                    <b>MÉD.:</b> <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?>
                </p>
                <p style="margin-top: -9px">
                    <b>AM:</b> <?=$AsistenteMedica['empleado_nombre']?> <?=$AsistenteMedica['empleado_apellidos']?>
                </p>
                <p style="margin-top: -11px">
                    <b>HORA A.M:</b> <?=date("d-m-Y", strtotime($am['asistentesmedicas_fecha']));?> <?=$am['asistentesmedicas_hora']?> hrs.
                </p>
            </div>
            <div style="position: absolute;margin-left: 580px;margin-top: 185px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -1px">
                    <b>H. CERO:</b> <?=date("d-m-Y", strtotime($info['triage_horacero_f']));?> <?=$info['triage_horacero_h']?>
                </p>
                <p style="margin-top: -10px">
                    <b>H. TERMINO Triage:</b> <?=$info['triage_hora_clasifica']?>
                </p>

            </div>
            <div style="position: absolute;margin-left: 337px;margin-top: 263px;width: 270px;text-transform: uppercase;font-size: 13px;">
                <b>NOTA INICIAL DE ADMISIÓN CONTINUA</b>
            </div>

            <div style="position: absolute;margin-top:229px;margin-left: 134px ">
                <?php
                $sqlChoque=$this->config_mdl->_get_data_condition('os_choque_v2',array(
                    'triage_id'=>$info['triage_id']
                ));
                $sqlObs=$this->config_mdl->_get_data_condition('os_observacion',array(
                    'triage_id'=>$info['triage_id']
                ));
                if(empty($sqlChoque)){
                    echo $this->config_mdl->_get_data_condition('os_camas',array(
                        'cama_id'=>$sqlObs[0]['observacion_cama']
                    ))[0]['cama_nombre'];
                }else{
                    echo $this->config_mdl->_get_data_condition('os_camas',array(
                        'cama_id'=>$sqlChoque[0]['cama_id']
                    ))[0]['cama_nombre'];
                }
                ?>
            </div>
            <div style="position:absolute; margin-top:210px; margin-left: 10px; text-transform: uppercase ">
                <b>CLASIFICACIÓN:</b> <?=$info['triage_color']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php
                      $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info['triage_codigo_atencion']);
                      echo ($codigo_atencion != '')?"<b>".mb_strtoupper("Código", 'UTF-8').": </b>$codigo_atencion":"";
                  ?>
            </div>
            <div style="position: absolute;margin-top:237px;margin-left: 360px ">:[[page_cu]]/[[page_nb]]</div>
            <!-- fecha de  creacion del documento -->
            <?php 
               if($hoja['hf_choque']=='1' || $hoja['hf_obs']=='1') {
                 $horaAtencion=$obs['observacion_mha'];
               }else {
                 $horaAtencion=$ce['ce_he'];
                }?>
            <div style="position: absolute;margin-left: 10px;margin-top: 270px;width: 150px;font-size: 12px;text-align: center;">
                <h5><?=$hoja['hf_fg']?> <?=$horaAtencion?></h5>
            </div>
            <div style="position: absolute;margin-left: 30px;margin-top: 320px;width: 120px;font-size: 12px;text-align: center">
                <h5 style="margin-top: -5px">Presión Arterial</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_ta']?> mmHg</p>
                <h5 style="margin-top: -5px">Temperatura</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_temp']?> °C</p>
                <h5 style="margin-top: -5px">Frecuencia Cardíaca</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_fc']?> (lpm)</p>
                <h5 style="margin-top: -5px">Frecuencia Respiratoria</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_fr']?> (rpm)</p>
                <?php if($SignosVitales['sv_oximetria']!=''){?>
                <h5 style="margin-top: -5px">Oximetria</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_oximetria']?> (%SpO2)</p>
                <?php }?>
                <?php if($SignosVitales['sv_dextrostix']!=''){?>
                <h5 style="margin-top: -5px">Glucometría</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_dextrostix']?> (mg/dl)</p>
                <?php }?>
                <h5 style="margin-top: -5px">Escala de dolor (EVA):</h5>
                <p style="margin-top: -28px; margin-left: 65px"><?=$hoja['hf_eva']?></p>
                <h5 style="margin-top: -5px">Riesgo de caída</h5>
                <p style="margin-top: -15px"><?=$hoja['hf_riesgocaida']?></p>
                <h5 style="margin-top: -5px">Riesgo de trombosis:</h5>
                <p style="margin-top: -15px"><?=$hoja['hf_riesgo_trombosis']?></p>
                <h5 style="margin-top: -5px">Escala de Glasgow</h5>
                <p style="margin-top: -28px; margin-left: 75px"><?=$hoja['hf_escala_glasgow']?></p>
                <h5 style="margin-top: -5px">Estado de Salud</h5>
                <p style="margin-top: -15px"><?=$hoja['hf_estadosalud']?></p>
                <h5 style="margin-top: -5px">Grado de funcionalidad</h5>
                <p style="margin-top: -15px"><?=$hoja['funcionalidad_barthel']?></p>
                <h5 style="margin-top: -5px">Escala de Frágilidad</h5>
                <p style="margin-top: -15px"><?=$hoja['escala_fragilidad']?></p>
            </div>
            <div style="rotate: 90; position: absolute;margin-left: 13px;margin-top: 336px;text-transform: uppercase;font-size: 12px;">
                ENF:<?=$Enfermera['empleado_nombre']?> <?=$Enfermera['empleado_apellidos']?> <?=date("d-m-Y", strtotime($info['triage_fecha']));?> <?=$info['triage_hora']?> hrs.
            </div>
            <div style="position: absolute;top: 910px;left: 215px;width: 240px;font-size: 9px;text-align: center">
                <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?><br>
                <span style="margin-top: -6px;margin-bottom: -8px">____________________________________</span><br>
                <b>NOMBRE DEL MÉDICO</b>
            </div>
            <div style="position: absolute;top: 910px;left: 430px;width: 160px;font-size: 9px;text-align: center">
                <?=$Medico['empleado_cedula']?> - <?=$Medico['empleado_matricula']?> <br>
                <span style="margin-top: -6px;margin-bottom: -8px">_____________________________</span><br>
                <b>CÉDULA Y MATRICULA</b>
            </div>
            <div style="position: absolute;top: 910px;left: 590px;width: 110px;font-size: 9px;text-align: center">
                <br>
                <span style="margin-top: -6px;margin-bottom: -8px">_________________</span><br>
                <b>FIRMA</b>
            </div>
            <div style="margin-left: 280px;margin-top: 980px">
                <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
            </div>
        </div>
    </page_header>
    <style type="text/css">
        ul {
          width: 550px;
          text-align: justify;
        }
        ol {
          width: 550px;
          text-align: justify;
        }
        .contenido {
         width: 580px; 
         text-align: justify; 
         padding-top: 5px;
         padding-bottom: 0px;
         margin-top: 0px;
         margin-bottom: 0px;  
        }
    </style>

    <div style="position:absolute; left: 1px; margin-top: -17px; font-size: 12px;">  
            <?php if($hoja['hf_motivo']!=''){?>
                <h5 style="margin-bottom: -6px">MOTIVO DE CONSULTA</h5>
                <p class="contenido"><?= $hoja['hf_motivo'] ?></p>
            <?php }?>
            <?php if($hoja['hf_antecedentes']!=''){?>
                <h5 style="margin-bottom: -6px">ANTECEDENTES</h5>
                <p class="contenido"><?=$hoja['hf_antecedentes']?></p>
            <?php }?>
            <?php if($PINFO['alergias']!=''){?>
                <h5 style="margin-bottom: -6px">ALERGIAS</h5>
                <p class="contenido"><?=$PINFO['alergias']?></p>
            <?php }?>
            <?php if($hoja['hf_padecimientoa']!=''){?>
                <h5 style="margin-bottom: -6px">PADECIMIENTO ACTUAL</h5>
                <p class="contenido"><?=$hoja['hf_padecimientoa']?></p>
            <?php }?>
            <?php if($hoja['hf_exploracionfisica']!=''){?>
                <h5 style="margin-bottom: -6px">EXPLORACIÓN FISICA</h5>
                <p class="contenido"><?=$hoja['hf_exploracionfisica']?></p>
            <?php }?>
            <?php if($hoja['hf_auxiliares']!=''){?>
                <h5 style="margin-bottom: -6px">AUXILIARES DE DIAGNÓSTICO</h5>
                <p class="contenido"><?=$hoja['hf_auxiliares']?></p>
            <?php }?>
                <h5 style="margin-bottom: -6px">DIAGNÓSTICO DE INGRESO</h5>
                
                <p class="contenido"><?=$Diagnosticos[0]['cie10_clave']?> - <?=$Diagnosticos[0]['cie10_nombre']?></p>
                <p class="contenido"><?=($Diagnosticos[0]['complemento'] == 'S/C')?'':$Diagnosticos[0]['complemento'];?></p>
                
            <?php if(count($Diagnosticos) > 1) {?>
                <h5 style="margin-bottom: -6px">DIAGNÓSTICOS SECUNDARIOS</h5>
                
                <?php for($x = 1; $x < count($Diagnosticos); $x++){ ?>
                <p class="contenido"><?=$Diagnosticos[$x]['cie10_clave']?> - <?=$Diagnosticos[$x]['cie10_nombre']?></p>
                <p class="contenido"><?=($Diagnosticos[$x]['complemento'] === 'S/C')?'':$Diagnosticos[$x]['complemento'];?></p>
                
                <?php } ?>
            <?php } ?>

            <h5 style="margin-bottom: -6px">INDICACIONES Y ORDENES MÉDICAS</h5>
            
                <?php if($hoja['hf_nutricion'] == '0') {
                  $nutricion = 'Ayuno';
                }else if($hoja['hf_nutricion'] == '1'){
                  $nutricion = 'IB - Normal';
                }else if($hoja['hf_nutricion'] == '2'){
                  $nutricion = 'IIA - Blanda';
                }else if($hoja['hf_nutricion'] == '3'){
                  $nutricion = 'IIB - Astringente';
                }else if($hoja['hf_nutricion'] == '4'){
                  $nutricion = 'III - Diabetica';
                }else if($hoja['hf_nutricion'] == '5'){
                  $nutricion = 'IV - Hiposodica';
                }else if($hoja['hf_nutricion'] == '6'){
                  $nutricion = 'V - Hipograsa';
                }else if($hoja['hf_nutricion'] == '7'){
                  $nutricion = 'VI - Liquida clara';
                }else if($hoja['hf_nutricion'] == '8'){
                  $nutricion = 'VIA - Liquida general';
                }else if($hoja['hf_nutricion'] == '9'){
                  $nutricion = 'VIB - Licuada por sonda';
                }else if($hoja['hf_nutricion'] == '10'){
                  $nutricion = 'VIB - Licuada por sonda artesanal';
                }else if($hoja['hf_nutricion'] == '11'){
                  $nutricion = 'VII - Papilla';
                }else if($hoja['hf_nutricion'] == '12'){
                  $nutricion = 'VIII - Epecial';
                }else{
                  $nutricion = $hoja['hf_nutricion'];
                }
                ?>
                <!-- DIETA -->
                <p class="contenido"><b>Dieta:</b> <?=$nutricion?></p>

                <?php
                if($hoja['hf_signosycuidados'] == '1'){
                  $toma_signos = 'Por turno';
                }else if($hoja['hf_signosycuidados'] == '2'){
                  $toma_signos = 'Cada 4 horas';
                }else{
                  $toma_signos = $hoja['hf_signosycuidados'];
                }
                ?>
                <!-- SIGNBOS VITALES -->
                <p class="contenido"><b>Toma de Signos Vitales:</b> <?=$toma_signos?></p>

                <?php if($hoja['hf_cgenfermeria'] == '1'){ ?>
                <!-- CUIDADOS GENERALES DE ENFERMERIA -->
                <p class="contenido"><b>Cuidados Generales:</b><br>
                  <label style="margin-left:20px;" >a. Estado neurológico</label><br>
                  <label style="margin-left:20px;" >b. Cama Con barandales</label><br>
                  <label style="margin-left:20px;" >c. Calificación del dolor</label><br>
                  <label style="margin-left:20px;" >d. Calificación de riesgo de caida</label><br>
                  <label style="margin-left:20px;" >e. Control de liquidos por turno</label><br>
                  <label style="margin-left:20px;" >f. Vigilar riesgo de ulceras por presión</label><br>
                  <label style="margin-left:20px;" >g. Aseo bucal</label><br>
                  <label style="margin-left:20px;" >h. Lavado de manos</label>
                </p>
                <?php } ?>
                <!-- CUIDADOS ESPECIFICOS DE ENFERMERIA -->
                <?php if($hoja['hf_cuidadosenfermeria']!=''){?>
                 
                    <p><b>Cuidados Especificos de Enfermeria:</b></p> 
                    <p class="contenido"><?=$hoja['hf_cuidadosenfermeria']?></p>
                <?php }?>
                <!-- SOLUCIONES PARANTERALES -->
                <?php if($hoja['hf_solucionesp']!=''){?>
                    <p class="contenido"><b>Soluciones Parenterales:</b></p> 
                    <p class="contenido"><?=$hoja['hf_solucionesp']?></p>
                <?php }?>
            
            <!-- Alergia a medicamentos -->
            <!-- <?php  echo (count($AlergiaMedicamentos > 0))?'<h5 style="margin-bottom: -6px">ALERGIA A MEDICAMENTOS</h5>':'';?>
            <?php for($x = 0; $x < count($AlergiaMedicamentos); $x++){ ?>
              <?=($x + 1).") ".$AlergiaMedicamentos[$x]['medicamento'] ?><br>
            <?php } ?> -->
            <!-- Fin alergia a medicamentos -->

            <!-- PRESCRIPCIÓN -->
            <?php if(!empty($Prescripcion)){?>  
                <h5>Prescripción de Medicamentos</h5>
                <p class="contenido">
                    <?php
                        $observacion = "";
                        $medicamento = "";
            
                        for($x = 0; $x < count($Prescripcion_Basico); $x++){ 
            
                            $observacion = $Prescripcion_Basico[$x]['observacion'];
                            $medicamento = $Prescripcion_Basico[$x]['medicamento'];
                            if($medicamento === "OTRO"){
                                $medicamento = substr($observacion, 0, strpos($observacion, "-"));
                                $observacion = substr($observacion, (strpos($observacion, "-") + 1),  strlen($observacion) );
                            }?>
                            <strong><?= $x+1 ?>) <?= $medicamento." ".$Prescripcion_Basico[$x]['gramaje']." ".$Prescripcion_Basico[$x]['forma_farmaceutica'] ?>. </strong>
                            Aplicar <?= $Prescripcion_Basico[$x]['dosis'] ?>
                            via <?= strtolower($Prescripcion_Basico[$x]['via']); ?>,
                            <?= ($Prescripcion_Basico[$x]['frecuencia'] == 'Dosis unica')? '' : 'cada'; ?> <?= strtolower($Prescripcion_Basico[$x]['frecuencia']); ?>,
                            en el siguiente horario: <?= $Prescripcion_Basico[$x]['aplicacion'] ?>.
                            Iniciando el <?= $Prescripcion_Basico[$x]['fecha_inicio'] ?>
                            hasta el <?= $Prescripcion_Basico[$x]['fecha_fin'] ?>.

                            <?php if($Prescripcion_Basico[$x]['observacion'] != 'Sin observaciones' ){ ?>
                                    <br><strong>Observación</strong>
                                    <?= $observacion ?>
                            <?php }?>
                            <br><!-- Salto entre prescripciones -->
                    <?php } /* Cierrre de ciclo for */?> 
                        <?= (count($Prescripcion_Onco_Anti) > 0)?"<h5>Antimicrobiano</h5>":""; ?>
                    <?php 
                        for($x = 0; $x < count($Prescripcion_Onco_Anti); $x++){ ?>
                                <strong><?= $x+1 ?>) <?= $Prescripcion_Onco_Anti[$x]['medicamento']." ".$Prescripcion_Onco_Anti[$x]['gramaje']." ".$Prescripcion_Onco_Anti[$x]['forma_farmaceutica'] ?>. 
                                </strong>
                                Aplicar <?= $Prescripcion_Onco_Anti[$x]['dosis'] ?>
                                via <?= strtolower($Prescripcion_Onco_Anti[$x]['via']); ?>,
                                <?= ($Prescripcion_Onco_Anti[$x]['frecuencia'] == 'Dosis unica')? '' : 'cada'; ?> <?= strtolower($Prescripcion_Onco_Anti[$x]['frecuencia']); ?>,
                                en el siguiente horario: <?= $Prescripcion_Onco_Anti[$x]['aplicacion'] ?>.
                                Iniciando el <?= $Prescripcion_Onco_Anti[$x]['fecha_inicio'] ?>
                                hasta el <?= $Prescripcion_Onco_Anti[$x]['fecha_fin'] ?>.
                                    <br>
                               <strong>Diluyente: </strong><u>&nbsp; <?= $Prescripcion_Onco_Anti[$x]['diluente'] ?> &nbsp;</u>&nbsp;&nbsp;&nbsp;
                               <strong>Vol. Diluyente: </strong><u>&nbsp; <?= $Prescripcion_Onco_Anti[$x]['vol_dilucion'] ?> ml.&nbsp;</u>

                                <?php if($Prescripcion_Onco_Anti[$x]['observacion'] != 'Sin observaciones' ){?>
                                        <br><strong>Observación</strong>
                                        <?= $Prescripcion_Onco_Anti[$x]['observacion'] ?>
                                <?php }?>
                                <br>
                    <?php } /* Cierre de ciclo for */ ?>

                        <?= (count($Prescripcion_NPT) > 0)?"<h5>Nutrición Parenteral Total</h5>":""; ?>

                    <?php 
                        for($x = 0; $x < count($Prescripcion_NPT); $x++) {?>
                                    <strong><?= $x+1 ?>) <?= $Prescripcion_NPT[$x]['medicamento']." ".$Prescripcion_NPT[$x]['gramaje']." ".$Prescripcion_NPT[$x]['forma_farmaceutica'] ?>. 
                                    </strong>
                                   Aplicar <?= $Prescripcion_NPT[$x]['dosis'] ?>
                                   via <?= strtolower($Prescripcion_NPT[$x]['via']); ?>,
                                   <?= ($Prescripcion_NPT[$x]['frecuencia'] == 'Dosis unica')? '' : 'cada'; ?> <?= strtolower($Prescripcion_NPT[$x]['frecuencia']); ?>,
                                   en el siguiente horario: <?= $Prescripcion_NPT[$x]['aplicacion'] ?>.
                                   Iniciando el <?= $Prescripcion_NPT[$x]['fecha_inicio'] ?>
                                   hasta el <?= $Prescripcion_NPT[$x]['fecha_fin'] ?>.
                                   <br>
                                   <?php $totalvol = (
                                                     $Prescripcion_NPT[$x]['aminoacido'] +
                                                     $Prescripcion_NPT[$x]['dextrosa'] +
                                                     $Prescripcion_NPT[$x]['lipidos'] +
                                                     $Prescripcion_NPT[$x]['agua_inyect'] +
                                                     $Prescripcion_NPT[$x]['cloruro_sodio'] +
                                                     $Prescripcion_NPT[$x]['sulfato'] +
                                                     $Prescripcion_NPT[$x]['cloruro_potasio'] +
                                                     $Prescripcion_NPT[$x]['fosfato'] +
                                                     $Prescripcion_NPT[$x]['gluconato'] +
                                                     $Prescripcion_NPT[$x]['albumina'] +
                                                     $Prescripcion_NPT[$x]['heparina'] +
                                                     $Prescripcion_NPT[$x]['insulina'] +
                                                     $Prescripcion_NPT[$x]['zinc'] +
                                                     $Prescripcion_NPT[$x]['mvi'] +
                                                     $Prescripcion_NPT[$x]['oligoelementos'] +
                                                     $Prescripcion_NPT[$x]['vitamina']
                                                   );?>
                                   <strong>OVERFILL:</strong><u>&nbsp; 20 &nbsp;</u>&nbsp;&nbsp;&nbsp;<strong>Vol. Total:</strong><u>&nbsp; <?=$totalvol?> &nbsp;</u>
                                   <br>
                                   <!-- Consultar bases -->
                                   <?php if($Prescripcion_NPT[$x]['aminoacido'] > 0 ||
                                           $Prescripcion_NPT[$x]['dextrosa'] > 0 ||
                                           $Prescripcion_NPT[$x]['lipidos'] > 0 ||
                                           $Prescripcion_NPT[$x]['agua_inyect'] > 0 ){ ?>
                                             <br>
                                             Solucion Base
                                             <br>
                                             <?= ($Prescripcion_NPT[$x]['aminoacido'] > 0) ? '<div>Aminoácidos Cristalinos 10% adulto <u>&nbsp;&nbsp; '.$Prescripcion_NPT[$x]['aminoacido'].' ml &nbsp;&nbsp;</u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['dextrosa'] > 0) ? '<div>Dextrosa al 50% <u>&nbsp;&nbsp; '.$Prescripcion_NPT[$x]['dextrosa'].' ml &nbsp;&nbsp;</u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['lipidos'] > 0) ? '<div>Lipdiso Intravenosos con Acidos grasos, Omega 3 y 9 <u>&nbsp;&nbsp; '.$Prescripcion_NPT[$x]['lipidos'].' ml &nbsp;&nbsp;</u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['agua_inyect'] > 0) ? '<div>Agua Inyectable <u>&nbsp;&nbsp; '.$Prescripcion_NPT[$x]['agua_inyect'].' ml &nbsp;&nbsp;</u></div>':'' ?>

                                   <?php } ?>

                                   <!-- Consultar sales -->
                                   <?php if($Prescripcion_NPT[$x]['cloruro_sodio'] > 0 ||
                                           $Prescripcion_NPT[$x]['sulfato'] > 0 ||
                                           $Prescripcion_NPT[$x]['cloruro_potasio'] > 0 ||
                                           $Prescripcion_NPT[$x]['fosfato'] > 0 ||
                                           $Prescripcion_NPT[$x]['gluconato'] > 0 ){ ?>
                                             <br>
                                             Sales
                                             <br>
                                             <?= ($Prescripcion_NPT[$x]['cloruro_sodio'] > 0) ? '<div>Cloruro de Sodio 17.7% (3mEq/ml Na) <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['cloruro_sodio'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['sulfato'] > 0) ? '<div>Sulfato de Magnesio (0.81) mEq/ml <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['sulfato'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['cloruro_potasio'] > 0) ? '<div>Cloruro de Potasio (4 mEeq/ml K) <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['cloruro_potasio'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['fosfato'] > 0) ? '<div>Fosfato de Potasio (2 mEq/ml k/1.11 m mol PO4) <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['fosfato'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['gluconato'] > 0) ? '<div>Gluconato de Calcio (0.465 mEq/ml) <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['gluconato'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                                   <?php } ?>

                                   <!-- Consultar aditivos -->
                                   <?php if($Prescripcion_NPT[$x]['albumina'] > 0 ||
                                           $Prescripcion_NPT[$x]['heparina'] > 0 ||
                                           $Prescripcion_NPT[$x]['insulina'] > 0 ||
                                           $Prescripcion_NPT[$x]['zinc'] > 0 ||
                                           $Prescripcion_NPT[$x]['mvi'] > 0 ||
                                           $Prescripcion_NPT[$x]['oligoelementos'] > 0 ||
                                           $Prescripcion_NPT[$x]['vitamina'] > 0){ ?>
                                             <br>
                                             Aditivos:
                                             <br>
                                             <?= ($Prescripcion_NPT[$x]['albumina'] > 0)?'<div>Albúmina 20% (0.20 g/ml): <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['albumina'].' gr &nbsp;&nbsp; </u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['heparina'] > 0)?'<div>Heparina (1000 UI/ml): <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['heparina'].' UI &nbsp;&nbsp; </u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['insulina'] > 0)?'<div>Insulina Humana (100 UI/ml): <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['insulina'].' UI &nbsp;&nbsp; </u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['zinc'] > 0)?'<div>Zinc: <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['zinc'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['mvi'] > 0)?'<div>MVI - Adulto <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['mvi'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['oligoelementos'] > 0)?'<div>Oligoelementos Tracefusin <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['oligoelementos'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                                             <?= ($Prescripcion_NPT[$x]['vitamina'] > 0)?'<div>Vitamina C (100 mg/ml) <u style="float:right;"> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['vitamina'].' mg &nbsp;&nbsp; </u></div>':'' ?>

                                   <?php }?>

                                    <?php if($Prescripcion_NPT[$x]['observacion'] != 'Sin observaciones' ){ ?>
                                            <br><strong>Observación</strong>
                                            <?= $Prescripcion_NPT[$x]['observacion'] ?><br>
                                    <?php }?>
                                    <br>
                    <?php } /* Cierre de ciclo for */?>
                </p>
            <?php }?> <!-- Fin prescripcion -->
            
            <!-- Indicaciones Escala de fragilidad -->    
            <?php if($hoja['escala_fragilidad'] != '' && $hoja['escala_fragilidad'] != '0 ptos: Paciente robusto') {?>
            <h5>Recomendaciones</h5>
                <?php
                  $escalaf= $hoja['escala_fragilidad'];
                  $escala_fragil = strpos($escalaf, 'Paciente Frágil');
                  $escala_prefragil = strpos($escalaf, 'Paciente prefrágil');

                  if ($escala_fragil) {?>
                    <ol style="margin-top: -15px;">
                        <li>Amerita valoración multidisciplinaria (Medicina interna/Geriatria) en HGZ, Rehabilitación y Nutriología clínica.</li>
                        <li>Se sugiere seguimiento y control de comorbilidades en UMF/HGZ.</li>
                        <li>Se sugiere valoración por servicio de ADEC de HGZ correspondiente (en caso de contar con el servicio) o visitas domiciliarias en su UMF.</li>
                        <li>Paciente que requiere acompañamiento de familiar durante hospitalización y en domicilio.</li>
                        <li>Durante la hospitalización realizar medidas de intervención antidelirium (permitir uso de auxiliares auditivos y visuales, orientación en tiempo, lugar y espacio por personal  de salud y familiares, evitar inmovilidad prolongada, evitar siestas prolongadas durante el día e interrupciones del sueño innecesarias).</li>
                    </ol>

                 <?php }?> 
                 <?php  
                     if ($escala_prefragil) {?>
                        <span>Amerita valoración multidisciplinaria ( Medicina interna/ Geriatria) en HGZ, Rehabilitación y Nutriología clínica. con la finalidad de prevenir abatimiento funcional.</span>
             
                    <?php }?>
            <?php }?>
            <!-- ACCION -->
            <?php if($hoja['hf_ce'] == '1') {?>
                <h5 style="margin-bottom: -6px">ACCIÓN</h5>
            <?php if($hoja['hf_alta']=='Otros') {
                    $envio=$hoja['hf_alta_otros'];
                  }else $envio=$hoja['hf_alta']; ?>
                <p class="contenido">Envio a <?=$envio?></p>
            
            <?php }?>
            <!-- PRONÓSTICOS -->
            <?php if($hoja['hf_indicaciones']!=''){?>
                <h5 style="margin-bottom: -6px">PRONÓSTICO</h5>
                    <?=$hoja['hf_indicaciones']?>
            <?php }?>
            
            <?php if(count($Interconsultas) > 0){ ?>
                    <h5 style="margin-bottom: -6px">INTERCONSULTAS</h5>
                    <table>
                        <tr>
                            <td>Servicio(s) solicitado(s):</td>
                            <td>
                            <?php for($x = 0; $x < count($Interconsultas); $x++){
                                    $y = $x + 1;
                                    $separacion = ($y == $num_interconsultas)?".":", ";?>
                                    <?=$Interconsultas[$x]['especialidad_nombre'].$separacion?>
                        
                            <?php }?>
                            </td>
                        </tr>
                        <tr>
                            <td>Motivo interconsulta:</td>
                            <td><?=$Interconsultas[0]['motivo_interconsulta']?></td>
                        </tr>
                    </table>
            <?php }?>
    </div>
    <page_footer>
    </page_footer>
</page>

<page backtop="85mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/covid19/prueba_rapida_covid.png" style="position: absolute;width: 100%;margin-top: 0px;margin-left: -5px;">   
            <div style="position: absolute;top: -5px;left: 580px;font-size: 12px;text-transform: uppercase;width: 150px;">
                <b>H. DE ESPECIALIDADES DEL CMN SIGLO XXI</b>
            </div>
            <div style="position: absolute;top: 250px;left: 155px;font-size: 12px;text-transform: uppercase;width: 390px;">
                <b><?=$info['triage_nombre_ap']?></b>
            </div>
            <div style="position: absolute;top: 250px;left: 300px;font-size: 12px;text-transform: uppercase;width: 390px;">
                <b><?=$info['triage_nombre_am']?></b>
            </div>
            <div style="position: absolute;top: 250px;left: 435px;font-size: 12px;text-transform: uppercase;width: 390px;">
                <b><?=$info['triage_nombre']?></b>
            </div>
            <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac'])); ?>
            <div style="position: absolute;top: 275;left: 155px;;width: 270px;text-transform: uppercase;font-size: 11px;">
                <b><?=$fecha->y==0 ? $fecha->m.' MESES' : $fecha->y.' AÑOS'?></b>
            </div>
            <div style="position: absolute;top: 295px;left: 155px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?></b>
            </div>
            <div style="position: absolute;top: 317px;left: 155px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$info['triage_paciente_sexo']?></b>
            </div>
            <div style="position: absolute;top: 360px;left: 155px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$info['triage_fecha']?></b>
            </div>
            <div style="position: absolute;top: 380px;left: 430px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$info['triage_id']?></b>
            </div>
    </page_header>
</page>

<page backtop="85mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/covid19/estudio_epidemiolgico_1.png" style="position: absolute;width: 100%;margin-top: 0px;margin-left: -5px;">

        <div style="position: absolute;top: 95px;left: 123px;font-size: 11px;text-transform: uppercase;width: 290px;">
            <b>HOSP. DE ESPECIALIDADES DEL CMN SIGLO XXI</b>
        </div>
        <div style="position: absolute;top: 96px;left: 592px;font-size: 10px;text-transform: uppercase;width: 190px;">
            <b><?=$PINFO['pum_nss']?> <?=$PINFO['pum_nss_agregado']?></b>
        </div>
        <div style="position: absolute;top: 140px;left: 135px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$info['triage_nombre_ap']?></b>
        </div>
        <div style="position: absolute;top: 140px;left: 355px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$info['triage_nombre_am']?></b>
        </div>
        <div style="position: absolute;top: 140px;left: 540px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$info['triage_nombre']?></b>
        </div>
        <?php  
                $fechaNac = $info['triage_fecha_nac'];
                $dia = substr($fechaNac, -11,2);
                $mes = substr($fechaNac, -7,2);
                $ano = substr($fechaNac, -4); 

        ?>
        <div style="position: absolute;top: 163px;left: 245px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?php echo $dia;?></b>
        </div>
        <div style="position: absolute;top: 163px;left: 318px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?php echo $mes?></b>
        </div>
        <div style="position: absolute;top: 163px;left: 391px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?php echo $ano?></b>
        </div>
        <div style="position: absolute;top: 163px;left: 492px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$info['triage_paciente_curp']?></b>
        </div>
        <?php if($info['triage_paciente_sexo'] == 'HOMBRE') {
                    $top = 185; 
                }else $top = 201;
        ?>
        <div style="position: absolute;top: <?php echo $top;?>px;left: 152px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b>X</b>
        </div>
        <div style="position: absolute;top: 314px;left: 457px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$DirPaciente['directorio_municipio']?></b>
        </div>
        <div style="position: absolute;top: 337px;left: 183px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$DirPaciente['directorio_estado']?></b>
        </div>
        <div style="position: absolute;top: 359px;left: 183px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$DirPaciente['directorio_cn']?></b>
        </div>
        <div style="position: absolute;top: 402px;left: 183px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$DirPaciente['directorio_colonia']?></b>
        </div>
        <div style="position: absolute;top: 402px;left: 390px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$DirPaciente['directorio_cp']?></b>
        </div>
        <div style="position: absolute;top: 402px;left: 568px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$DirPaciente['directorio_telefono']?></b>
        </div>
    </page_header>
</page>

<page backtop="85mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/covid19/estudio_epidemiolgico_2.png" style="position: absolute;width: 92%;margin-top: 0px;margin-left: 15px;">
        <div style="position: absolute;top: 1035px;left: 88px;font-size: 9px;text-transform: uppercase;width: 390px;">
            <b><?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?></b>
        </div>
        <div style="position: absolute;top: 1049px;left: 88px;font-size: 9px;text-transform: uppercase;width: 390px;">
            <b><?=$Medico['empleado_matricula']?></b>
        </div>
    </page_header>
</page>

<page backtop="85mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/CONSENTIMIENTO_INFORMADO.png" style="position: absolute;width: 100%;margin-top: 0px;margin-left: -5px;">
        <div style="position: absolute;margin-top: 15px">
            <div style="position: absolute;top: 184px;left: 450px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
            </div>
            <div style="position: absolute;top: 218px;left: 480px;font-size: 12px;text-transform: uppercase;width: 160px;">
                <?php
                $sqlPUM=$this->config_mdl->_get_data_condition('paciente_info',array(
                    'triage_id'=>$info['triage_id']
                ))[0];
                ?>
                
                <b>&nbsp;<?=$sqlPUM['pum_nss']?>-<?=$sqlPUM['pum_nss_agregado']?></b>
            </div>
            <div style="position: absolute;top: 233px;left: 440px;font-size: 12px;text-transform: uppercase;">
                <b><?=$info['triage_paciente_sexo']?></b>
            </div>            
            <div style="position: absolute;top: 233px;left: 580px;font-size: 12px;text-transform: uppercase;">
              <?php 
                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));?>
                <b><?=$fecha->y?> AÑOS</b>
            </div>
            <div style="position: absolute;top: 250px;left: 487px;font-size: 12px;">
              <b>CD MX</b> a <b><?=$hoja['hf_fg']?></b>
            </div>
            <div style="position: absolute;top: 307px;left: 120px;font-size: 11px;text-transform: uppercase;">
                <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
            </div>
            <div style="position: absolute;top: 780px;left: 145px;font-size: 11px;text-transform: uppercase;">
                <?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?>
            </div>
            <div style="position: absolute;top: 605px;left: 145px;font-size: 11px;text-transform: uppercase;">
                <?=$Diagnosticos[0]['cie10_nombre']?>
            </div>
            <div style="position: absolute;top: 652px;left: 143px;font-size: 11px;text-align: justify;width: 495px">
                1. COMPLICACIONES ASOCIADAS A PATOLOGIA DE BASE. 2. FALLECIMIENTO DURANTE EL INTERNAMIENTO A PESAR DE INTERVENCIONES TERAPÉUTICAS. 3. INFECCIONES INTRAHOSPITALARIAS Y CAIDAS.
                4. REACCIONES ADVERSAS A MEDICAMENTOS
            </div>
            <div style="position: absolute;top: 710px;left: 145px;font-size: 10px;width: 250px">
                * ESTABILIZACIÓN. * INICIO DE TRATAMIENTO DIRIGIDO A PATOLOGÍA BASE.
                * INICIO DE PROTOCOLO DE ESTUDIO.
            </div>
            <div style="position: absolute;top: 710px;left: 460px;font-size: 11px;text-transform: uppercase;">
                ALTA VOLUNTARIA
            </div>
            <div style="position: absolute;top: 765px;left: 378px;font-size: 11px;text-transform: uppercase;">
                <?=$sqlPUM['pic_responsable_nombre']?> 
            </div>
        </div>
         <div style="position: absolute;top: 875px;left: 127px;width: 240px;font-size: 11px;text-align: center">
            <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?><br><?=$Medico['empleado_matricula']?>
         </div> 
       
        <div style="position: absolute;top: 1000px">
            <div style="margin-left: 280px;">
                <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 20px;" ></barcode>
            </div>
        </div>
    </page_header>
    <page_footer>
    </page_footer>        
</page>
<page backtop="85mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/covid19/consen_infor_hosp_en_covid_ac1.png" style="position: absolute;width: 100%;margin-top: 0px;margin-left: -5px;">
        <div style="position: absolute;margin-top: 100px">
            <div style="position: absolute;top: 160px;left: 430px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$hoja['hf_fg']?></b>
            </div>
        </div>
        <div style="position: absolute;margin-top: 100px">
            <div style="position: absolute;top: 184px;left: 255px;font-size: 12px;text-transform: uppercase;width: 390px;">
                <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
            </div>
        </div>
    </page_header>
</page>

<page backtop="85mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/covid19/consen_infor_hosp_en_covid_ac2.png" style="position: absolute;width: 100%;margin-top: 0px;margin-left: -5px;">
        <div style="position: absolute;margin-top: 410px">
            <div style="position: absolute;top: 182px;left: 270px;font-size: 12px;text-transform: uppercase;width: 390px;">
                <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
            </div>
            <div style="position: absolute;top: 199px;left: 160px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?></b>
            </div>
            <div style="position: absolute;top: 265px;left: 100px;font-size: 12px;text-transform: uppercase;width: 390px;">
                <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
            </div>
            <div style="position: absolute;top: 265px;left: 400px;font-size: 12px;text-transform: uppercase;width: 390px;">
                <b><?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?></b>
            </div>
            <div style="position: absolute;top: 412px;left: 100px;font-size: 12px;text-transform: uppercase;width: 390px;">
                <b><?=$PINFO['pic_responsable_nombre']?></b>
            </div>
        </div>
    </page_header>
</page>
<page>
    <page_header>
        <img src="<?=  base_url()?>assets/doc/consen_infor_traslado.png" style="position: absolute;width: 100%;margin-top: 50px;margin-left: 0px;">
        <div style="position: absolute;top: 90px;left: 555px;font-size: 12px;text-transform: uppercase;width: 200px;">
            <b><?=$PINFO['pum_umf']?> / Delegación <?=$PINFO['pum_delegacion']?></b>
        </div>
        <div style="position: absolute;top: 140px;left: 555px;font-size: 12px;text-transform: uppercase;width: 200px;">
            <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
        </div>
        <div style="position: absolute;top: 225px;left: 555px;font-size: 12px;text-transform: uppercase;width: 190px;">
            <b><?=$PINFO['pum_nss']?>  <?=$PINFO['pum_nss_agregado']?></b>
        </div>
        <div style="position: absolute;top: 275px;left: 599px;font-size: 12px;text-transform: uppercase;">
            <?php 
                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));?>
                <b><?=$fecha->y?> AÑOS</b>
        </div>
        <div style="position: absolute;top: 330px;left: 170px;font-size: 12px;text-transform: uppercase;width: 300px;">
            <b>ADMISIÓN CONTINUA</b>
        </div>
        <div style="position: absolute;top: 330px;left: 555px;font-size: 12px;text-transform: uppercase;width: 390px;">
            <b>CD DE MÉXICO A <?=$hoja['hf_fg']?></b>
        </div>
        <div style="position: absolute;top: 370px;left: 50px;font-size: 12px;text-transform: uppercase;width: 350px;">
            <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
        </div>
        <div style="position: absolute;top: 690px;left: 50px;font-size: 12px;text-transform: uppercase;width: 650px;">
            <b>HOSPITAL DE ESPECIALIDADES DEL C.M.N SIGLO XXI "DR. BERNARDO SEPULVEDA GUTIERREZ"</b>
        </div>
        <div style="position: absolute;top: 773px;left: 50px;font-size: 10px;text-transform: uppercase;width: 750px;">
            <b><?=$Diagnosticos[0]['cie10_nombre']?><br>
               <?=($Diagnosticos[0]['complemento'] == 'S/C')?'':$Diagnosticos[0]['complemento'];?>
            </b>
        </div>
        <div style="position: absolute;top: 885px;left: 25px;font-size: 12px;text-transform: uppercase;width: 390px;">
            <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
        </div>
        <div style="position: absolute;top: 885px;left: 405px;font-size: 12px;text-transform: uppercase;width: 390px;">
            <b><?=$PINFO['pic_responsable_nombre']?></b>
        </div>
        <div style="position: absolute;top: 955px;left: 25px;font-size: 12px;text-transform: uppercase;width: 390px;">
            <b><?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?></b>
        </div>
    </page_header>
</page>

<?php
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    // $pdf->pdf->IncludeJS("print(true);");
    $pdf->pdf->SetTitle('NOTA INICIAL ADMISION CONTINUA');
    $pdf->Output($Nota['notas_tipo'].'.pdf');
?>