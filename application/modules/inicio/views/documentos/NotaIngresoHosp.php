<?php ob_start();
$tiempo_estancia = Modules::run('Config/CalcularTiempoTranscurrido', array(
    'Tiempo1' =>  str_replace('/', '-', $infoIngreso['fecha_ingreso']) . ' ' . $infoIngreso['hora_atencion'],
    'Tiempo2' =>  $nota['fecha_elabora'] . ' ' . $nota['hora_elabora']
));
?>
<page backtop="80mm" backbottom="30mm" backleft="48" backright="1mm">
    <page_header>
        <img src="<?= base_url() ?>assets/doc/DOC430128_HF.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">

        <div style="position: absolute;margin-top: 15px">
            <div style="position: absolute;top: 80px;left: 120px;width: 270px;">
                <!--<b><?= _UM_CLASIFICACION ?> | <?= _UM_NOMBRE ?></b> -->
            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 50px;width: 270px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>NOMBRE DEL PACIENTE: </b>

            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 61px;width: 350px;text-transform: uppercase;font-size: 14px;text-align: left;">
                <?= $info['triage_nombre'] ?> <?= $info['triage_nombre_ap'] ?> <?= $info['triage_nombre_am'] ?>
            </div>
            <div style="position: absolute;margin-left: 437px;margin-top: 75px;width: 270px;text-transform: uppercase;font-size: 13px;">
                <b>N.S.S:</b> <?= $PINFO['pum_nss'] ?>-<?= $PINFO['pum_nss_agregado'] ?>
            </div>
            <?php $fecha = Modules::run('Config/ModCalcularEdad', array('fecha' => $info['triage_fecha_nac'])); ?>
            <div style="position: absolute;margin-left: 437px;margin-top: 95px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -2px">
                    <b>EDAD:</b> <?= $fecha->y == 0 ? $fecha->m . ' MESES' : $fecha->y . ' AÑOS' ?>
                </p>
                <p style="margin-top: -10px">
                    <b>UMF:</b> <?= $PINFO['pum_umf'] ?>/<?= $PINFO['pum_delegacion'] ?>
                </p>
                <p style="margin-top: -10px">
                    <b><?= $hoja['hf_atencion'] ?></b>
                </p>

            </div>
            <div style="position: absolute;margin-left: 540px;margin-top: 95px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -2px">
                    <b>GENERO:</b> <?= $info['triage_paciente_sexo'] ?>
                </p>
                <p style="margin-top: -10px">
                    <b>PROCEDE:</b> <?= $PINFO['pia_procedencia_espontanea'] == 'Si' ? 'ESPONTANEO' : 'REFERENCIADO' ?>
                </p>
                <p style="margin-top: -10px">
                    <b>ATENCION:</b><?= $PINFO['pia_tipo_atencion'] ?>
                </p>
            </div>

            <div style="position: absolute;margin-left: 437px;margin-top: 136px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <?php if ($PINFO['pia_procedencia_espontanea'] == 'No') { ?>

                    <p style="margin-top: -7px">
                        <b>4-30-8/NM:</b> <?= $PINFO['pia_procedencia_hospital'] ?> <?= $PINFO['pia_procedencia_hospital_num'] ?>
                    </p>
                <?php } ?>
            </div>

            <div style="position: absolute;margin-left: 437px;margin-top: 154px;width: 300px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -10px">
                    <b>DOMICILIO: </b> <?= $DirPaciente['directorio_cn'] ?>, <?= $DirPaciente['directorio_colonia'] ?>, <?= $DirPaciente['directorio_cp'] ?>, <?= $DirPaciente['directorio_municipio'] ?>, <?= $DirPaciente['directorio_estado'] ?> <B>TEL:</B><?= $DirPaciente['directorio_telefono'] ?>
                </p>
            </div>
            <div style="position: absolute;margin-left: 437px;margin-top: 185px;width: 300px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -1px">
                    <b>FOLIO:</b> <?= $info['triage_id'] ?>
                </p>
                <p style="margin-top: -10px">
                    <b>FECHA DE INGRESO Y HORA CERO:</b> <?= date('d-m-Y', strtotime($info['triage_horacero_f'])) ?> <?= $info['triage_horacero_h'] ?>
                </p>
                <p style="margin-top: -7px">
                    <b>CAMA:</b> <?= $infoCama['cama_nombre'] ?> - <?= $infoCama['piso_nombre_corto'] ?>
                </p>
                <p style="margin-top: -9px">
                    <b>TIEMPO DE ESTANCIA:</b> <?= $tiempo_estancia->d ?> dias <?= $tiempo_estancia->h ?> hrs <?= $tiempo_estancia->i ?> min.
                </p>
                <p style="margin-top: -11px">
                    <b>MEDICO TRATANTE:</b> <?= $medicoTratante['empleado_nombre'] ?> <?= $medicoTratante['empleado_apellidos'] ?>
                </p>
            </div>

            <div style="position: absolute;margin-top: 263px;margin-left: 210px; width: 500px;text-transform: uppercase;font-size: 13px;text-align: center;">
                <b>NOTA DE INGRESO DEL SERVICIO DE <?= $Servicio['especialidad_nombre'] ?></b>
            </div>


            <div style="position: absolute;margin-top:237px;margin-left: 360px ">:[[page_cu]]/[[page_nb]]</div>
            <!-- fecha de  creacion del documento -->

            <div style="position: absolute;margin-left: 10px;margin-top: 270px;width: 150px;font-size: 12px;text-align: center;">
                <h5><?= date("d/m/Y", strtotime($nota['fecha_elabora'])); ?> <?= $nota['hora_elabora'] ?></h5>
            </div>
            <div style="position: absolute;margin-left: 30px;margin-top: 320px;width: 110px;font-size: 12px;text-align: center">
                <?php if ($SignosVitales['sv_ta'] != '') { ?>
                    <h5 style="margin-top: -5px">Presión Arterial</h5>
                    <p style="margin-top: -15px"><?= $SignosVitales['sv_ta'] ?> mmHg</p>
                <?php } ?>
                <?php if ($SignosVitales['sv_temp'] != '') { ?>
                    <h5 style="margin-top: -5px">Temperatura</h5>
                    <p style="margin-top: -15px"><?= $SignosVitales['sv_temp'] ?> °C</p>
                <?php } ?>
                <?php if ($SignosVitales['sv_fc'] != '') { ?>
                    <h5 style="margin-top: -5px">Frecuencia Cardíaca</h5>
                    <p style="margin-top: -15px"><?= $SignosVitales['sv_fc'] ?> (lpm)</p>
                <?php } ?>
                <?php if ($SignosVitales['sv_fr'] != '') { ?>
                    <h5 style="margin-top: -5px">Frecuencia Respiratoria</h5>
                    <p style="margin-top: -15px"><?= $SignosVitales['sv_fr'] ?> (rpm)</p>
                <?php } ?>
                <?php if ($SignosVitales['sv_oximetria'] != '') { ?>
                    <h5 style="margin-top: -5px">Oximetria</h5>
                    <p style="margin-top: -15px"><?= $SignosVitales['sv_oximetria'] ?> (%SpO2)</p>
                <?php } ?>
                <?php if ($SignosVitales['sv_dextrostix'] != '') { ?>
                    <h5 style="margin-top: -5px">Glucometría</h5>
                    <p style="margin-top: -15px"><?= $SignosVitales['sv_dextrostix'] ?> (mg/dl)</p>
                <?php } ?>
                <?php if ($escalaSalud['escala_eva'] != '') { ?>
                    <h5 style="margin-top: -5px">Escala de dolor (EVA):</h5>
                    <p style="margin-top: -28px; margin-left: 65px"><?= $escalaSalud['escala_eva'] ?></p>
                <?php } ?>
                <?php if ($escalaSalud['riesgo_caida'] != '') { ?>
                    <h5 style="margin-top: -5px">Riesgo de caída</h5>
                    <p style="margin-top: -15px"><?= $escalaSalud['riesgo_caida'] ?></p>
                <?php } ?>
                <?php if ($escalaSalud['escala_riesgo_trombosis'] != '') { ?>
                    <h5 style="margin-top: -5px">Riesgo de trombosis:</h5>
                    <p style="margin-top: -15px"><?= $escalaSalud['escala_riesgo_trombosis'] ?></p>
                <?php } ?>
                <?php if ($escalaSalud['escala_glasgow'] != '') { ?>
                    <h5 style="margin-top: -5px">Escala de Glasgow:</h5>
                    <p style="margin-top: -28px; margin-left: 75px"><?= $escalaSalud['escala_glasgow'] ?></p>
                <?php } ?>
                <?php if ($nota['estado_salud'] != '') { ?>
                    <h5 style="margin-top: -5px">Estado de Salud</h5>
                    <p style="margin-top: -15px"><?= $nota['estado_salud'] ?></p>
                <?php } ?>
            </div>


            <div style="margin-left: 280px;margin-top: 980px">
                <barcode type="C128A" value="<?= $info['triage_id'] ?>" style="height: 40px;"></barcode>
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

        .contenidol {
            width: 580px;
            text-align: justify;
            padding-top: 5px;
            padding-bottom: 0px;
            margin-top: 0px;
            margin-bottom: 0px;
        }
    </style>

    <div style="position:absolute; left: 1px; margin-top: -10px; font-size: 12px;">
        <p style="margin-bottom: -6px;"><b>TIPO DE INTERROGATORIO</b> <?= $nota['tipo_interrogatorio'] ?></p>
        <?php if ($nota['motivo_ingreso_p1'] == '1') { ?>
            <span style="margin-bottom: 0px;font-weight: bold;"><br>MOTIVO DE INGRESO</span>
            <p class="contenido"><?= $nota['motivo_ingreso'] ?></p>
        <?php } ?>

        <?php if ($nota['antecedentes_heredofamiliares_p1'] == '1') { ?>
            <span style="font-weight: bold;"><br>ANTECEDENTES</span>
        <?php } ?>

        <?php if ($nota['antecedentes_heredofamiliares_p1'] == '1') { ?>
            <p style="margin-bottom: 1px">Antecedentes Heredo familiares</p>
            <p class="contenido"><?= $nota['antecedentes_heredofamiliares'] ?></p>
        <?php } ?>
        <?php if ($nota['antecedentes_personales_nopatologicos_p1'] == '1') { ?>
            <p style="margin-bottom: 1px;">Antecedentes Personales no Patologicos</p>
            <p class="contenido"><?= $nota['antecedentes_personales_nopatologicos'] ?></p>
        <?php } ?>
        <?php if ($nota['antecedentes_personales_patologicos_p1'] == '1') { ?>
            <p style="margin-bottom: 1px">Antecedentes Personales Patológicos</p>
            <p class="contenido"><?= $nota['antecedentes_personales_patologicos'] ?></p>
        <?php } ?>
        <?php if ($nota['antecedentes_ginecoobstetricos_p1'] == '1') { ?>
            <p style="margin-bottom: 1px">Antecedentes Gineco Obstetricos</p>
            <p class="contenido"><?= $nota['antecedentes_ginecoobstetricos'] ?></p>
        <?php } ?>
        <?php if($nota['padecimiento_actual_p1'] == '1' || $nota['exploracion_fisica_p1'] == '1') {
                if ($nota['ESTADO_ACTUAL_p1'] == '1') {?>
                <span style="font-weight: bold;"><br>ESTADO ACTUAL</span>
            <?php } ?>
        <?php } ?>
        <?php if ($nota['padecimiento_actual_p1'] == '1') { ?>
            <p style="margin-bottom: 1px">Padecimiento Actual</p>
            <p class="contenido"><?= $nota['padecimiento_actual'] ?></p>
        <?php } ?>
        <?php if ($nota['exploracion_fisica_p1'] == '1') { ?>
            <p style="margin-bottom: 1px">Exploracion Fisica</p>
            <p class="contenido"><?= $nota['exploracion_fisica'] ?></p>
        <?php } ?>
        <?php if ($nota['estudios_laboratorio_p1'] == '1' || $nota['estudios_gabinete_p1'] == '1') { ?>
            <?php if ($nota['EXAMENES_AUXILIARES_DE_p1'] == '1') { ?>
                <span style="font-weight: bold;">EXAMENES AUXILIARES DE DIAGNÓSTICO</span>
            <?php } ?>
        <?php } ?>
        <?php if ($nota['estudios_laboratorio_p1'] == '1') { ?>
            <p style="margin-bottom: 1px">Estudios Laboratorio</p>
            <p class="contenido"><?= $nota['estudios_laboratorio'] ?></p>
        <?php } ?>
        <?php if ($nota['estudios_gabinete_p1'] == '1') { ?>
            <p style="margin-bottom: 1px">Estudios de Gabinete</p>
            <p class="contenido"><?= $nota['estudios_gabinete'] ?></p>
        <?php } ?>
    </div>
</page>

<page backtop="80mm" backbottom="55mm" backleft="5mm" backright="1mm">
    <page_header>
        <img src="<?= base_url() ?>assets/doc/DOC4301282.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">

        <div style="position: absolute;margin-top: 15px">
            <div style="position: absolute;top: 80px;left: 120px;width: 270px;">
                <!--<b><?= _UM_CLASIFICACION ?> | <?= _UM_NOMBRE ?></b> -->
            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 50px;width: 270px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>NOMBRE DEL PACIENTE: </b>

            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 61px;width: 350px;text-transform: uppercase;font-size: 14px;text-align: left;">
                <?= $info['triage_nombre'] ?> <?= $info['triage_nombre_ap'] ?> <?= $info['triage_nombre_am'] ?>
            </div>
            <div style="position: absolute;margin-left: 437px;margin-top: 75px;width: 270px;text-transform: uppercase;font-size: 13px;">
                <b>N.S.S:</b> <?= $PINFO['pum_nss'] ?>-<?= $PINFO['pum_nss_agregado'] ?>
            </div>
            <?php $fecha = Modules::run('Config/ModCalcularEdad', array('fecha' => $info['triage_fecha_nac'])); ?>
            <div style="position: absolute;margin-left: 437px;margin-top: 95px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -2px">
                    <b>EDAD:</b> <?= $fecha->y == 0 ? $fecha->m . ' MESES' : $fecha->y . ' AÑOS' ?>
                </p>
                <p style="margin-top: -10px">
                    <b>UMF:</b> <?= $PINFO['pum_umf'] ?>/<?= $PINFO['pum_delegacion'] ?>
                </p>
                <p style="margin-top: -10px">
                    <b><?= $hoja['hf_atencion'] ?></b>
                </p>

            </div>
            <div style="position: absolute;margin-left: 540px;margin-top: 95px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -2px">
                    <b>GENERO:</b> <?= $info['triage_paciente_sexo'] ?>
                </p>
                <p style="margin-top: -10px">
                    <b>PROCEDE:</b> <?= $PINFO['pia_procedencia_espontanea'] == 'Si' ? 'ESPONTANEO' : 'REFERENCIADO' ?>
                </p>
                <p style="margin-top: -10px">
                    <b>ATENCION:</b><?= $PINFO['pia_tipo_atencion'] ?>
                </p>
            </div>

            <div style="position: absolute;margin-left: 437px;margin-top: 136px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <?php if ($PINFO['pia_procedencia_espontanea'] == 'No') { ?>

                    <p style="margin-top: -7px">
                        <b>4-30-8/NM:</b> <?= $PINFO['pia_procedencia_hospital'] ?> <?= $PINFO['pia_procedencia_hospital_num'] ?>
                    </p>
                <?php } ?>
            </div>

            <div style="position: absolute;margin-left: 437px;margin-top: 154px;width: 300px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -10px">
                    <b>DOMICILIO: </b> <?= $DirPaciente['directorio_cn'] ?>, <?= $DirPaciente['directorio_colonia'] ?>, <?= $DirPaciente['directorio_cp'] ?>, <?= $DirPaciente['directorio_municipio'] ?>, <?= $DirPaciente['directorio_estado'] ?> <B>TEL:</B><?= $DirPaciente['directorio_telefono'] ?>
                </p>
            </div>
            <div style="position: absolute;margin-left: 437px;margin-top: 185px;width: 300px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -1px">
                    <b>FOLIO:</b> <?= $info['triage_id'] ?>
                </p>
                <p style="margin-top: -10px">
                    <b>FECHA DE INGRESO Y HORA CERO:</b> <?= date('d-m-Y', strtotime($info['triage_horacero_f'])) ?> <?= $info['triage_horacero_h'] ?>
                </p>
                <p style="margin-top: -7px">
                    <b>CAMA:</b> <?= $infoCama['cama_nombre'] ?> - <?= $infoCama['piso_nombre_corto'] ?>
                </p>
                <p style="margin-top: -9px">
                    <b>TIEMPO DE ESTANCIA:</b> <?= $tiempo_estancia->d ?> dias <?= $tiempo_estancia->h ?> hrs <?= $tiempo_estancia->i ?> min.
                </p>
                <p style="margin-top: -11px">
                    <b>MEDICO TRATANTE:</b> <?= $medicoTratante['empleado_nombre'] ?> <?= $medicoTratante['empleado_apellidos'] ?>
                </p>
            </div>

            <div style="position: absolute;margin-top: 263px;margin-left: 210px; width: 500px;text-transform: uppercase;font-size: 13px;text-align: center;">
                <b>NOTA DE INGRESO DEL SERVICIO DE <?= $Servicio['especialidad_nombre'] ?></b>
            </div>


            <div style="position: absolute;margin-top:237px;margin-left: 360px ">:[[page_cu]]/[[page_nb]]</div>

            <div style="margin-left: 280px;margin-top: 980px">
                <barcode type="C128A" value="<?= $info['triage_id'] ?>" style="height: 40px;"></barcode>
            </div>
        </div>
    </page_header>
    <style type="text/css">
        ul {
            width: 500px;
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

    <div style="position:absolute; left: 1px; margin-top: -10px; font-size: 12px;">
        <?php if ($nota['tipo_interrogatorio_p1'] == '2') { ?>
            <p style="margin-bottom: -6px;"><b>TIPO DE INTERROGATORIO</b> <?= $nota['tipo_interrogatorio'] ?></p>
        <?php } ?>
        <?php if ($nota['motivo_ingreso_p1'] == '2') { ?>
            <span style="margin-bottom: -6px;font-weight: bold;"><br>MOTIVO DE INGRESO</span>
            <p class="contenido"><?= $nota['motivo_ingreso'] ?></p>
        <?php } ?>
        <?php if ($nota['antecedentes_heredofamiliares_p1'] == '2') { ?>
            <span style="font-weight: bold;"><br>ANTECEDENTES</span>
        <?php } ?>
        <?php if ($nota['antecedentes_heredofamiliares_p1'] == '2') { ?>
            <p style="margin-bottom: 1px">Antecedentes Heredo familiares</p>
            <p class="contenido"><?= $nota['antecedentes_heredofamiliares'] ?></p>
        <?php } ?>
        <?php if ($nota['antecedentes_personales_nopatologicos_p1'] == '2') { ?>
            <p style="margin-bottom: 1px;">Antecedentes Personales no Patologicos</p>
            <p class="contenido"><?= $nota['antecedentes_personales_nopatologicos'] ?></p>
        <?php } ?>
        <?php if ($nota['antecedentes_personales_patologicos_p1'] == '2') { ?>
            <p style="margin-bottom: 1px">Antecedentes Personales Patológicos</p>
            <p class="contenido"><?= $nota['antecedentes_personales_patologicos'] ?></p>
        <?php } ?>
        <?php if ($nota['antecedentes_ginecoobstetricos_p1'] == '2') { ?>
            <p style="margin-bottom: 1px">Antecedentes Gineco Obstetricos</p>
            <p class="contenido"><?= $nota['antecedentes_ginecoobstetricos'] ?></p>
        <?php } ?>
        <?php 
            if(($nota['padecimiento_actual_p1'] == '2' || $nota['exploracion_fisica_p1'] == '2') && !($nota['padecimiento_actual_p1'] == '1' || $nota['exploracion_fisica_p1'] == '1')) {
                if ($nota['ESTADO_ACTUAL_p1'] == '2') { ?>
                    <span style="font-weight: bold;"><br>ESTADO ACTUAL</span>
            <?php } ?>
        <?php } ?>
        <?php if ($nota['padecimiento_actual_p1'] == '2') { ?>
            <p style="margin-bottom: 1px">Padecimiento Actual</p>
            <p class="contenido"><?= $nota['padecimiento_actual'] ?></p>
        <?php } ?>
        <?php if ($nota['exploracion_fisica_p1'] == '2') { ?>
            <p style="margin-bottom: 1px">Exploracion Fisica</p>
            <p class="contenido"><?= $nota['exploracion_fisica'] ?></p>
        <?php } ?>
        <?php if (($nota['estudios_laboratorio_p1'] == '2' || $nota['estudios_gabinete_p1'] == '2') && !($nota['estudios_laboratorio_p1'] == '1' || $nota['estudios_gabinete_p1'] == '1')) { ?>
            <?php if ($nota['EXAMENES_AUXILIARES_DE_p1'] == '2') { ?>
                <span style="font-weight: bold;">EXAMENES AUXILIARES DE DIAGNÓSTICO</span>
            <?php } ?>
        <?php } ?>
        <?php if ($nota['estudios_laboratorio_p1'] == '2') { ?>
            <p style="margin-bottom: 1px">Estudios Laboratorio</p>
            <p class="contenido"><?= $nota['estudios_laboratorio'] ?></p>
        <?php } ?>
        <?php if ($nota['estudios_gabinete_p1'] == '2') { ?>
            <p style="margin-bottom: 1px">Estudios de Gabinete</p>
            <p class="contenido"><?= $nota['estudios_gabinete'] ?></p>
        <?php } ?>
        <p>Diagnosticos_p1: <?= print_r($Diagnosticos_p1)?></p>
        <p>Diagnosticos: <?= print_r($Diagnosticos)?></p>
        <p style="font-weight: bold;margin-bottom: 1px">IMPRESIÓN DIAGNÓSTICA</p>
        <p style="margin-bottom: 1px">Diagnóstico de Ingreso</p>
        <p class="contenido"><?= $Diagnosticos[0]['cie10_clave'] ?> - <?= $Diagnosticos[0]['cie10_nombre'] ?></p>
        <p class="contenido"><?= ($Diagnosticos[0]['complemento'] == 'S/C') ? '' : $Diagnosticos[0]['complemento']; ?></p>

        <?php if (count($Diagnosticos) > 1) { ?>
            <h5 style="margin-bottom: -6px">Diagnosticos Secundarios</h5>
            <?php for ($x = 1; $x < count($Diagnosticos); $x++) { ?>
                <p class="contenido"><?= $Diagnosticos[$x]['cie10_clave'] ?> - <?= $Diagnosticos[$x]['cie10_nombre'] ?></p>
                <p class="contenido"><?= ($Diagnosticos[$x]['complemento'] === 'S/C') ? '' : $Diagnosticos[$x]['complemento']; ?></p>
            <?php } ?>
        <?php } ?>
        <?php if ($nota['comentario'] != '') { ?>
            <p style="margin-bottom: 1px">Comentario</p>
            <p class="contenido"><?= $nota['comentario'] ?></p>
        <?php } ?>
        <?php if ($nota['pronostico'] != '') { ?>
            <p style="font-weight: bold;margin-bottom: 1px">PRONÓSTICO</p>
            <p class="contenido"><?= $nota['pronostico'] ?></p>
        <?php } ?>

        <?php if ($nota['procedimientos'] != '') { ?>
            <h5 style="margin-bottom: -6px">PROCEDIMIENTOS REALIZADOS</h5>
            <?php $procedimiento = explode(',', $nota['procedimientos']);
            foreach ($procedimiento as $value_p => $procedimiento_id) {
                $nombreProcedimiento = $this->config_mdl->_get_data_condition('um_procedimientos', array('procedimiento_id' => $procedimiento_id))[0];
            ?>
                <p class="contenido"><?= $nombreProcedimiento['nombre'] ?></p>

            <?php } ?>

        <?php } ?>

        <p style="font-weight: bold;margin-bottom: 1px">PLAN Y ORDENES MÉDICAS</p>
        <!--<p><?= print_r($nota) ?></p>-->
        <?php if ($plan['dieta'] == '0') {
            $nutricion = 'Ayuno';
        } else if ($plan['dieta'] == '1') {
            $nutricion = 'IB - Normal';
        } else if ($plan['dieta'] == '2') {
        } else if ($plan['dieta'] == '3') {
            $nutricion = 'IIB - Astringente';
        } else if ($plan['dieta'] == '4') {
            $nutricion = 'III - Diabetica';
        } else if ($plan['dieta'] == '5') {
            $nutricion = 'IV - Hiposodica';
        } else if ($plan['dieta'] == '6') {
            $nutricion = 'V - Hipograsa';
        } else if ($plan['dieta'] == '7') {
            $nutricion = 'VI - Liquida clara';
        } else if ($plan['dieta'] == '8') {
            $nutricion = 'VIA - Liquida general';
        } else if ($plan['dieta'] == '9') {
            $nutricion = 'VIB - Licuada por sonda';
        } else if ($plan['dieta'] == '10') {
            $nutricion = 'VIB - Licuada por sonda artesanal';
        } else if ($plan['dieta'] == '11') {
            $nutricion = 'VII - Papilla';
        } else if ($plan['dieta'] == '12') {
            $nutricion = 'VIII - Epecial';
        } else {
            $nutricion = $plan['dieta'];
        }
        ?>
        <!-- DIETA -->
        <p class="contenido"><b>Dieta:</b> <?= $nutricion ?> <?= $plan['dieta_indicaciones'] ?></p>

        <?php
        if ($plan['toma_signos_vitales'] == '1') {
            $toma_signos = 'Por turno';
        } else if ($plan['toma_signos_vitales'] == '2') {
            $toma_signos = 'Cada 4 horas';
        } else {
            $toma_signos = $plan['toma_signos_vitales'];
        }
        ?>
        <!-- SIGNBOS VITALES -->
        <p class="contenido"><b>Toma de Signos Vitales:</b> <?= $toma_signos ?></p>

        <?php if ($plan['cuidados_genfermeria'] == '1') { ?>
            <!-- CUIDADOS GENERALES DE ENFERMERIA -->
            <p class="contenido"><b>Cuidados Generales:</b><br>
                <label style="margin-left:20px;">a. Estado neurológico</label><br>
                <label style="margin-left:20px;">b. Cama Con barandales</label><br>
                <label style="margin-left:20px;">c. Calificación del dolor</label><br>
                <label style="margin-left:20px;">d. Calificación de riesgo de caida</label><br>
                <label style="margin-left:20px;">e. Control de liquidos por turno</label><br>
                <label style="margin-left:20px;">f. Vigilar riesgo de ulceras por presión</label><br>
                <label style="margin-left:20px;">g. Aseo bucal</label><br>
                <label style="margin-left:20px;">h. Lavado de manos</label>
            </p>
        <?php } ?>
        <!-- CUIDADOS ESPECIFICOS DE ENFERMERIA -->
        <?php if ($plan['cuidados_eenfermeria'] != '') { ?>
            <p style="font-weight: bold;margin-bottom: 1px">Cuidados Especificos de Enfermeria:</p>
            <p class="contenido"><?= $plan['cuidados_eenfermeria'] ?></p>
        <?php } ?>
        <!-- SOLUCIONES PARANTERALES -->
        <?php if ($plan['soluciones_parenterales'] != '') { ?>
            <p class="contenido"><b>Soluciones Parenterales:</b>
                <?= $plan['soluciones_parenterales'] ?></p>
        <?php } ?>

        <!-- Alergia a medicamentos -->
        <!-- <?php echo (count($AlergiaMedicamentos) > 0) ? '<h5 style="margin-bottom: -6px">ALERGIA A MEDICAMENTOS</h5>' : ''; ?>
            <?php for ($x = 0; $x < count($AlergiaMedicamentos); $x++) { ?>
              <?= ($x + 1) . ") " . $AlergiaMedicamentos[$x]['medicamento'] ?><br>
            <?php } ?> -->
        <!-- Fin alergia a medicamentos -->

        <!-- PRESCRIPCIÓN -->
        <?php if (!empty($Prescripcion)) { ?>
            <h5>Prescripción de Medicamentos</h5>
            <p class="contenido">
                <?php
                $observacion = "";
                $medicamento = "";

                for ($x = 0; $x < count($Prescripcion_Basico); $x++) {

                    $observacion = $Prescripcion_Basico[$x]['observacion'];
                    $medicamento = $Prescripcion_Basico[$x]['medicamento'];
                    if ($medicamento === "OTRO") {
                        $medicamento = substr($observacion, 0, strpos($observacion, "-"));
                        $observacion = substr($observacion, (strpos($observacion, "-") + 1),  strlen($observacion));
                    } ?>
                    <strong><?= $x + 1 ?>) <?= $medicamento . " " . $Prescripcion_Basico[$x]['gramaje'] . " " . $Prescripcion_Basico[$x]['forma_farmaceutica'] ?>. </strong>
                    Aplicar <?= $Prescripcion_Basico[$x]['dosis'] ?>
                    via <?= strtolower($Prescripcion_Basico[$x]['via']); ?>,
                    <?= ($Prescripcion_Basico[$x]['frecuencia'] == 'Dosis unica') ? '' : 'cada'; ?> <?= strtolower($Prescripcion_Basico[$x]['frecuencia']); ?>,
                    en el siguiente horario: <?= $Prescripcion_Basico[$x]['aplicacion'] ?>.
                    Iniciando el <?= $Prescripcion_Basico[$x]['fecha_inicio'] ?>
                    hasta el <?= $Prescripcion_Basico[$x]['fecha_fin'] ?>.

                    <?php if ($Prescripcion_Basico[$x]['observacion'] != 'Sin observaciones') { ?>
                        <br><strong>Observación</strong>
                        <?= $observacion ?>
                    <?php } ?>
                    <br><!-- Salto entre prescripciones -->
                <?php } /* Cierrre de ciclo for */ ?>
                <?= (count($Prescripcion_Onco_Anti) > 0) ? "<h5>Antimicrobiano</h5>" : ""; ?>
                <?php
                for ($x = 0; $x < count($Prescripcion_Onco_Anti); $x++) { ?>
                    <strong><?= $x + 1 ?>) <?= $Prescripcion_Onco_Anti[$x]['medicamento'] . " " . $Prescripcion_Onco_Anti[$x]['gramaje'] . " " . $Prescripcion_Onco_Anti[$x]['forma_farmaceutica'] ?>.
                    </strong>
                    Aplicar <?= $Prescripcion_Onco_Anti[$x]['dosis'] ?>
                    via <?= strtolower($Prescripcion_Onco_Anti[$x]['via']); ?>,
                    <?= ($Prescripcion_Onco_Anti[$x]['frecuencia'] == 'Dosis unica') ? '' : 'cada'; ?> <?= strtolower($Prescripcion_Onco_Anti[$x]['frecuencia']); ?>,
                    en el siguiente horario: <?= $Prescripcion_Onco_Anti[$x]['aplicacion'] ?>.
                    Iniciando el <?= $Prescripcion_Onco_Anti[$x]['fecha_inicio'] ?>
                    hasta el <?= $Prescripcion_Onco_Anti[$x]['fecha_fin'] ?>.
                    <br>
                    <strong>Diluyente: </strong><u>&nbsp; <?= $Prescripcion_Onco_Anti[$x]['diluente'] ?> &nbsp;</u>&nbsp;&nbsp;&nbsp;
                    <strong>Vol. Diluyente: </strong><u>&nbsp; <?= $Prescripcion_Onco_Anti[$x]['vol_dilucion'] ?> ml.&nbsp;</u>

                    <?php if ($Prescripcion_Onco_Anti[$x]['observacion'] != 'Sin observaciones') { ?>
                        <br><strong>Observación</strong>
                        <?= $Prescripcion_Onco_Anti[$x]['observacion'] ?>
                    <?php } ?>
                    <br>
                <?php } /* Cierre de ciclo for */ ?>

                <?= (count($Prescripcion_NPT) > 0) ? "<h5>Nutrición Parenteral Total</h5>" : ""; ?>

                <?php
                for ($x = 0; $x < count($Prescripcion_NPT); $x++) { ?>
                    <strong><?= $x + 1 ?>) <?= $Prescripcion_NPT[$x]['medicamento'] . " " . $Prescripcion_NPT[$x]['gramaje'] . " " . $Prescripcion_NPT[$x]['forma_farmaceutica'] ?>.
                    </strong>
                    Aplicar <?= $Prescripcion_NPT[$x]['dosis'] ?>
                    via <?= strtolower($Prescripcion_NPT[$x]['via']); ?>,
                    <?= ($Prescripcion_NPT[$x]['frecuencia'] == 'Dosis unica') ? '' : 'cada'; ?> <?= strtolower($Prescripcion_NPT[$x]['frecuencia']); ?>,
                    en el siguiente horario: <?= $Prescripcion_NPT[$x]['aplicacion'] ?>.
                    Iniciando el <?= $Prescripcion_NPT[$x]['fecha_inicio'] ?>
                    hasta el <?= $Prescripcion_NPT[$x]['fecha_fin'] ?>.
                    <br>
                    <?php $totalvol = ($Prescripcion_NPT[$x]['aminoacido'] +
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
                    ); ?>
                    <strong>OVERFILL:</strong><u>&nbsp; 20 &nbsp;</u>&nbsp;&nbsp;&nbsp;<strong>Vol. Total:</strong><u>&nbsp; <?= $totalvol ?> &nbsp;</u>
                    <br>
                    <!-- Consultar bases -->
                    <?php if (
                        $Prescripcion_NPT[$x]['aminoacido'] > 0 ||
                        $Prescripcion_NPT[$x]['dextrosa'] > 0 ||
                        $Prescripcion_NPT[$x]['lipidos'] > 0 ||
                        $Prescripcion_NPT[$x]['agua_inyect'] > 0
                    ) { ?>
                        <br>
                        Solucion Base
                        <br>
                        <?= ($Prescripcion_NPT[$x]['aminoacido'] > 0) ? '<div>Aminoácidos Cristalinos 10% adulto <u>&nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['aminoacido'] . ' ml &nbsp;&nbsp;</u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['dextrosa'] > 0) ? '<div>Dextrosa al 50% <u>&nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['dextrosa'] . ' ml &nbsp;&nbsp;</u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['lipidos'] > 0) ? '<div>Lipdiso Intravenosos con Acidos grasos, Omega 3 y 9 <u>&nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['lipidos'] . ' ml &nbsp;&nbsp;</u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['agua_inyect'] > 0) ? '<div>Agua Inyectable <u>&nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['agua_inyect'] . ' ml &nbsp;&nbsp;</u></div>' : '' ?>

                    <?php } ?>

                    <!-- Consultar sales -->
                    <?php if (
                        $Prescripcion_NPT[$x]['cloruro_sodio'] > 0 ||
                        $Prescripcion_NPT[$x]['sulfato'] > 0 ||
                        $Prescripcion_NPT[$x]['cloruro_potasio'] > 0 ||
                        $Prescripcion_NPT[$x]['fosfato'] > 0 ||
                        $Prescripcion_NPT[$x]['gluconato'] > 0
                    ) { ?>
                        <br>
                        Sales
                        <br>
                        <?= ($Prescripcion_NPT[$x]['cloruro_sodio'] > 0) ? '<div>Cloruro de Sodio 17.7% (3mEq/ml Na) <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['cloruro_sodio'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['sulfato'] > 0) ? '<div>Sulfato de Magnesio (0.81) mEq/ml <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['sulfato'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['cloruro_potasio'] > 0) ? '<div>Cloruro de Potasio (4 mEeq/ml K) <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['cloruro_potasio'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['fosfato'] > 0) ? '<div>Fosfato de Potasio (2 mEq/ml k/1.11 m mol PO4) <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['fosfato'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['gluconato'] > 0) ? '<div>Gluconato de Calcio (0.465 mEq/ml) <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['gluconato'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
                    <?php } ?>

                    <!-- Consultar aditivos -->
                    <?php if (
                        $Prescripcion_NPT[$x]['albumina'] > 0 ||
                        $Prescripcion_NPT[$x]['heparina'] > 0 ||
                        $Prescripcion_NPT[$x]['insulina'] > 0 ||
                        $Prescripcion_NPT[$x]['zinc'] > 0 ||
                        $Prescripcion_NPT[$x]['mvi'] > 0 ||
                        $Prescripcion_NPT[$x]['oligoelementos'] > 0 ||
                        $Prescripcion_NPT[$x]['vitamina'] > 0
                    ) { ?>
                        <br>
                        Aditivos:
                        <br>
                        <?= ($Prescripcion_NPT[$x]['albumina'] > 0) ? '<div>Albúmina 20% (0.20 g/ml): <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['albumina'] . ' gr &nbsp;&nbsp; </u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['heparina'] > 0) ? '<div>Heparina (1000 UI/ml): <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['heparina'] . ' UI &nbsp;&nbsp; </u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['insulina'] > 0) ? '<div>Insulina Humana (100 UI/ml): <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['insulina'] . ' UI &nbsp;&nbsp; </u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['zinc'] > 0) ? '<div>Zinc: <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['zinc'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['mvi'] > 0) ? '<div>MVI - Adulto <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['mvi'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['oligoelementos'] > 0) ? '<div>Oligoelementos Tracefusin <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['oligoelementos'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
                        <?= ($Prescripcion_NPT[$x]['vitamina'] > 0) ? '<div>Vitamina C (100 mg/ml) <u style="float:right;"> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['vitamina'] . ' mg &nbsp;&nbsp; </u></div>' : '' ?>

                    <?php } ?>

                    <?php if ($Prescripcion_NPT[$x]['observacion'] != 'Sin observaciones') { ?>
                        <br><strong>Observación</strong>
                        <?= $Prescripcion_NPT[$x]['observacion'] ?><br>
                    <?php } ?>
                    <br>
                <?php } /* Cierre de ciclo for */ ?>
            </p>
        <?php } ?>
        <!-- Fin prescripcion -->



        <?php if (count($Interconsultas) > 0) { ?>
            <h5 style="margin-bottom: -6px">INTERCONSULTAS SOLICITADAS</h5>
            <table>
                <tr>
                    <td>Servicio(s) solicitado(s):</td>
                    <td>
                        <?php for ($x = 0; $x < count($Interconsultas); $x++) {
                            $y = $x + 1;
                            $separacion = ($y == $num_interconsultas) ? "." : ", "; ?>
                            <?= $Interconsultas[$x]['especialidad_nombre'] . $separacion ?>

                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>Motivo interconsulta:</td>
                    <td><?= $Interconsultas[0]['motivo_interconsulta'] ?></td>
                </tr>
            </table>
        <?php } ?>
        <!--<p>
           <br /><br /><br /><br /><br /><br /><br />
        </p>-->
    </div>
    <page_footer>
        <?php 
            $top = 935;
            $empleado_roles = explode(",",$_SESSION["empleado_roles"]);
            $mostrar_residentes = 0;
            for($i = 0;$i< count($empleado_roles);$i++){
                if($empleado_roles[$i] == "77"){
                    $mostrar_residentes = 1;
                    $top = 900;
                }
            } 
            ?>
            <div style="position: absolute;top: <?= $top ?>px;left: 30px;right: 5px;font-size: 10px; text-align:right;">
                <b>Dr. <?= $medicoTratante['empleado_apellidos'] ?> <?= $medicoTratante['empleado_nombre'] ?> médico Adscrito del servicio <?= $Servicio["especialidad_nombre"]?> MATRICULA: <?= $medicoTratante['empleado_matricula'] ?></b>
            </div>
            <?php if($mostrar_residentes == 1){
                if (!empty($residentes)) { ?>
                    <div style="position: absolute;top: <?=$top+15?>px;width:730px;right: 5px;font-size: 10px;text-align: right;">
                        <b>
                            <?php foreach ($residentes as $value){?>
                            Dr. <?=$value['apellido_residente']?>  <?=$value['nombre_residente']?> médico residente del servicio <?= $ServicioM["especialidad_nombre"]?> Matricula <?=$value['cedulap_residente']?> Grado <?=$value['grado']?>;
                            <?php }?>  
                        </b>
                    </div>
        <?php }} ?>
    </page_footer>
    <!--<p><?= __DIR__?></p>-->
</page>

<?php
$html =  ob_get_clean();
//$pdf = new HTML2PDF('P', 'A4', 'fr', 'UTF-8');
//$pdf->writeHTML($html);
//// $pdf->pdf->IncludeJS("print(true);");
//$pdf->pdf->SetTitle('NOTA DE INGRESO ');
//$pdf->Output($Nota['notas_tipo'] . '.pdf');
require __DIR__.'/vendor/autoload.php';
use spipu\Html2Pdf\Html2Pdf;
$html2pdf = new Html2Pdf();
$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first test');
$html2pdf->output();
?>