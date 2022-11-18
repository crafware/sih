<?php ob_start(); ?>
<page>
    <page_header>
       <img src="<?=  base_url()?>assets/doc/Clasificacion_tresp.png" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
       <div style="position: absolute;">
            <div style="position: absolute;top: 10px;left: 43px;font-size: 10px;width: 645px;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: center;font-weight: bold">
                DESTINO: <?=$info[0]['triage_consultorio_nombre']?>&nbsp;&nbsp;&nbsp;&nbsp;HORA CERO:<?=$info[0]['triage_horacero_h']?>&nbsp;&nbsp;&nbsp;&nbsp;HORA TRIAGE:<?=$info[0]['triage_hora']?>
            </div>
            <div style="position: absolute;top: 155px;left: 184px;font-size: 10px"><?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?></div>
            <div style="position: absolute;top: 155px;left: 440px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[2]?></div>
            <div style="position: absolute;top: 155px;left: 490px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[1]?></div>
            <div style="position: absolute;top: 155px;left: 530px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[0]?></div>
            <div style="position: absolute;top: 155px;left: 640px;font-size: 10px"><?=  explode(':', $info[0]['triage_hora_clasifica'])[0]?></div>
            <div style="position: absolute;top: 155px;left: 655px;font-size: 10px"><?=  explode(':', $info[0]['triage_hora_clasifica'])[1]?></div>
            <!---Seccion 2-->
            <div style="position: absolute;top: 178px;left: 100px;font-size: 10px"><?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?> <?=$info[0]['triage_nombre']?>
            </div>
            <div style="position: absolute;top: 178px;left: 570px;font-size: 10px">
                <?php 
                if($info[0]['triage_fecha_nac']!=''){
                    $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info[0]['triage_fecha_nac']));
                         echo $fecha->y.' <span style="font-size:10px">Años</span>';
                }else{
                         echo 'S/E';
                    }
                 ?>
            </div>
            <div style="position: absolute;top: 207px;left: 90px;font-size: 10px"><?=$pinfo[0]['pum_nss']?> <?=$pinfo[0]['pum_nss_agregado']?></div>
            <div style="position: absolute;top: 207px;left: 90px;font-size: 10px"><?=$pinfo[0]['pum_nss']?> <?=$pinfo[0]['pum_nss_agregado']?></div>
            <div style="position: absolute;top: 207px;left: 300px;font-size: 10px"><?=$pinfo[0]['pum_umf']?></div>
            <div style="position: absolute;top: 207px;left: 450px;font-size: 10px"><?=$pinfo[0]['pum_delegacion']?></div>
            <div style="position: absolute;top: 207px;left: 560px;font-size: 10px"><?=$SignosVitales['sv_peso']?> Kg</div>
            <div style="position: absolute;top: 207px;left: 645px;font-size: 10px"><?=$SignosVitales['sv_talla']?> m</div>
            <div style="position: absolute;top: 256px;left: 128px;font-size: 10px"><?=$SignosVitales['sv_ta']?> mmHg</div> 
            <div style="position: absolute;top: 256px;left: 262px;font-size: 10px"><?=$SignosVitales['sv_temp']?> °C</div>
            <div style="position: absolute;top: 256px;left: 460px;font-size: 10px"><?=$SignosVitales['sv_fc']?> lpm</div>
            <div style="position: absolute;top: 256px;left: 645px;font-size: 10px"><?=$SignosVitales['sv_fr']?> rpm</div>
            
            <?php if($this->ConfigSolicitarOD=='Si'){?>
            <div style="position: absolute;top: 275px;left: 210px;font-size: 10px">
                <?=$SignosVitales['sv_oximetria']?> % spO2
            </div>
            <div style="position: absolute;top: 275px;left: 580px;font-size: 10px">
                <?=$SignosVitales['sv_dextrostix']?> mg/dL
            </div>
            <?php }?>
            
           
            <div style="position: absolute;top: 316px;left: 60px;font-size: 10px"><?=$info[0]['triage_motivoAtencion']?></div>
            <!--Criterios Mayores-->
            <div style="position: absolute;top: 367px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['fiebre']==2){echo 'Si';}else echo 'No'?>
            </div>
            <div style="position: absolute;top: 380px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['tos']==2){echo 'Si';}else echo 'No';?>
            </div>
            <div style="position: absolute;top: 390px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['cefalea']==2){echo 'Si';}else echo 'No';?>   
            </div>
           
            <!-- Otros Sintomas -->
            <div style="position: absolute;top: 429px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['conjuntivitis']==1){echo 'Si';}else echo 'No';?> </div> 
            <div style="position: absolute;top: 441px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['rinorrea']==1){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 454px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['prurito_nasal']==1){echo 'Si';}else echo 'No';?>
            </div>
            <div style="position: absolute;top: 466px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['estornudos']==1){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 478px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['anosmia']==1){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 490px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['dolor_garganta']==1){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 503px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['disgeusia']==1){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 515px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['cansancio']==1){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 528px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['mialgia']==1){echo 'Si';}else echo 'No';?>        
            </div>
            <div style="position: absolute;top: 540px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['artragias']==1){echo 'Si';}else echo 'No';?>        
            </div>
            <div style="position: absolute;top: 553px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['dolor_torax']==1){echo 'Si';}else echo 'No';?>
            </div>
            <div style="position: absolute;top: 565px;left: 254px;font-size: 10px"><?php if($clasificacion[0]['diarrea']==1){echo 'Si';}else echo 'No';?>
            </div>
            
            <!--Factores de Riesgo-->
            <div style="position: absolute;top: 367px;left: 598px;font-size: 10px"><?php if($clasificacion[0]['disnea']==3){echo 'Si';}else echo 'No';?>   
            </div> 
            <div style="position: absolute;top: 378px;left: 598px;font-size: 10px"><?php if($clasificacion[0]['oximetria']==3){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 391px;left: 598px;font-size: 10px"><?php if($clasificacion[0]['edad']==3){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 402px;left: 598px;font-size: 10px"><?php if($clasificacion[0]['obesidad']==3){echo 'Si';}else echo 'No';?>   
            </div>

            <!--Comorbilidades-->
            <div style="position: absolute;top: 441px;left: 598px;font-size: 10px"><?php if($clasificacion[0]['diabetes']==3){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 454px;left: 598px;font-size: 10px"><?php if($clasificacion[0]['hipertension']==3){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 466px;left: 598px;font-size: 10px"><?php if($clasificacion[0]['cardiopatia']==3){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 478px;left: 598px;font-size: 10px"><?php if($clasificacion[0]['nefropata']==3){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 490px;left: 598px;font-size: 10px"><?php if($clasificacion[0]['inmunodef']==3){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 503px;left: 598px;font-size: 10px"><?php if($clasificacion[0]['hepatopatia']==3){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 515px;left: 598px;font-size: 10px"><?php if($clasificacion[0]['epoc']==3){echo 'Si';}else echo 'No';?>   
            </div>
            <div style="position: absolute;top: 529px;left: 382px; width: 310px; margin: auto; font-size: 11px; padding: 0px;text-align: justify">
                <?php if($clasificacion[0]['triage_qsofa'] <= 1) {
                        echo 'Escala de qSOFA: Riesgo Bajo.';
                      } else echo 'Escala de qSOFA: Riesgo Alto de mal pronóstico.';
                      echo '<br>';            
                      if($clasificacion[0]['test_qcovid'] != 0){
                        echo 'Se realiza prueba diagnóstica para COVID-19.';
                      } if($clasificacion[0]['paciente_imss'] != 0){
                        echo '<br>';
                        echo 'Paciente Empleado IMSS';
                      }?>

            </div>  
            <?php if($this->ConfigExcepcionCMT=='Si' && $clasificacion[0]['observaciones']!=''){?>  
            <div style="position: absolute;left: 53px;top: 580px;width: 650px;margin: auto;font-size: 10px;padding: 0px;text-align: justify">
                <b>Observaciones: </b><?=$clasificacion[0]['observaciones']?>
            </div>
            <?php }?> 
            <?php if($clasificacion[0]['tratamiento']!='') {?>        
            <div style="position: absolute;left: 53px;top: 740px;width: 650px;margin: auto;font-size: 10px;padding: 0px;text-align: justify"> 
                <b>Tratamieto: </b>
                                <?php $valueTratamiento = explode("," ,$clasificacion[0]['tratamiento']);?>
                        
                                <?php
                                foreach ($valueTratamiento as $value_p => $tratamiento) {
                                    switch ($tratamiento) {
                                        case '1':
                                            $medicamento = 'OSELTAMIVIR 75 mg C/12 hrs POR 5 DIAS. ';
                                            break;
                                        
                                        case '2':
                                            $medicamento = 'PARACETAMOL 500 mg C/8 hrs POR 5 DIAS. ';
                                            break;
                                        case '3';
                                            $medicamento = 'CIPROFLOXACINO 250 mg VO (2 TABLETAS) C/12 hrs POR  DIAS. ';
                                            break;
                                        case '4';
                                            $medicamento = 'LEVOFLOXACINO 500 mg VO C/24 hrs POR 7 DIAS. ';
                                            break;
                                        case '5';
                                            $medicamento = 'IVERMECTINA tabs 6 mg  tomar 3 tabletas via oral c/24 hrs.';
                                            break;
                                        case '6';
                                            $medicamento = 'CLOROQUINA tabs 150 mgs, tomar 300 mgs VO cada 12 hrs por 6 días. ';
                                            break;
                                        case '7';
                                            $medicamento = 'CLARITROMICINA Tabs 250mgs, tomar 500 mgs VO cada 12 hrs por 7 días. ';
                                            break;
                                    }
                                    ?><?php $num=$value_p+1; echo '<b>'.$num.'</b>'.'.- '.$medicamento; ?><?php                    
                                }?>
                                
            </div>
            <?php }?>
            




            <!-- Datos del medico -->
            <div style="position: absolute;top: 888px;left: 60px;font-size:9px;width: 200px;text-align: center;">
                <?=$medico[0]['empleado_nombre']?> <?=$medico[0]['empleado_apellidos']?>
            </div>
            <div style="position: absolute;top: 888px;left: 280px;font-size:9px;width:200px;text-align: center;">
                <?=$medico[0]['empleado_matricula']?>
            </div>
            
            <div style="position: absolute;left: 280px;top: 970px">
                <barcode type="C128A" value="<?=$info[0]['triage_id']?>" style="height: 40px;" ></barcode>
            </div>
        </div> 
    </page_header>
    
    <page_footer>

        <?php 
        if($info[0]['triage_color']=='Rojo'){
            $color='#E50914';
            $color_name='Rojo';
            $tiempo='Inmediatamente';
            $tipoAtencion='Real';
        }if($info[0]['triage_color']=='Amarillo'){
            $color_name='Amarillo';
            $tiempo='11-60 Minutos';
            $tipoAtencion='Real';
        }if($info[0]['triage_color']=='Verde'){
            $color='#4CBB17';
            $color_name='Verde';
            $tiempo='Ambulatoria';
            $tipoAtencion='Sentida';
        }

        ?>
        
        <div style="height: 15px;width: 645px;background: black;margin: auto;color: white;text-align: center;padding: 10px;border-radius: 5px;font-weight: bold;text-transform: uppercase">
            Color:<?=$info[0]['triage_color']?> |<?=$tiempo?> | URGENCIA: <?=$tipoAtencion?>
        </div>
    </page_footer>
</page>
<page>
    <page_header>
        <div style="position: absolute;">
            <div style="position: absolute;top: 10px;left: 43px;font-size: 10px;width: 645px;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: center;font-weight: bold; font-size: 14px">
                Cuidados en casa para la persona enferma por COVID-19
            </div>
            <div style="position: absolute;top: 35px;left: 43px;font-size: 15px;width: 645px;text-align: justify;">
                <ol style="text-align: justify;">
                    <li>Seguir recomendaciones generales de prevención, asi como las de contención.</li>
                    <li>Restringir actividades fuera de casa, excepto para recibir atención médica.</li>
                    <li>No recibir visitas.</li>
                    <li>No auto medicarse o hacer uso de remedios caseros.</li>
                    <li>Tomar sus medicamentos a tiempo con la dosis indicada por el médico.</li>
                    <li>Permanecer en una habitación especifica lejos de otras personas y animales.</li>
                    <li>Usar cubrebocas (cubriendo nariz y boca) cuando este cerca de las personas con quienes convive en casa o bien cuando salga para recibir atención médica.</li>
                    <li>Evitar compartir artículos de uso personal, así como utensilios para la alimentación.</li>
                    <li>Limpiar y desinfectar diariamente con alcohol, toallitas desinfectantes o cloro los objetos y las superficies de mayor contacto.</li>
                    <li>En caso de presentar algún datos de alarma, acuda a la unidad de atención  médica más cercana e informe al personal de salud que es portador de COVID-19</li>
                    <li>Evitar el uso de trasporte público.</li>
                    <li>Realice baño y cambio de ropa diario, así como las medidas de higiene personal.</li>
                    <li>Procure realizar actividades que ocupen su tiempo libre, sin poner en riesgo su integridad.</li>
                     
                </ol>
            </div>
            <div style="position: absolute;top: 350px;left: 43px;font-size: 10px;width: 645px;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: justify;font-weight: bold; font-size: 14px">
                Cuidados en casa para los familiares de la persona enferma por COVID-19
            </div>
            <div style="position: absolute;top: 380px;left: 43px;font-size: 15px;width: 645px;text-align: justify;">
                <ol style="text-align: justify;">
                    <li>Seguir recomendaciones generales de prevención, asi como las de contención.</li>
                    <li>Asegurese de atender las instrucciones que le proporciona el equipo de salud, en cuanto al tratamiento con medicamentos y cuidados de la persona enferma.</li>
                    <li>Facilitar el aislamiento de la persona enferma en una habitación.</li>
                    <li>Usar cubrebocas cuando este en contacto con la persona enferma.</li>
                    <li>Vigilar estrechamente la presencia de algún dato de alarma y en caso necesario utilice el servicio de atención médica telefónica.</li>
                    <li>Promover la restricción de las visitas y el contacto con mascotas.</li>
                    <li>Limpiar y desinfectar en casa todos los dias los objetos y las superficies de contacto.</li>
                    <li>Asegurar de que los lugares compartidos tengas una buena ventilación.</li>
                    <li>Evitar mezclar la ropa con la de otros miemboros de la familia, debe de lavarse con detergente de uso comercial.</li>
                    <li>Evitarse tocarse los ojos, nariz y boca sin antes labarse las manos.</li>
                </ol>
            </div>

            <div style="position: absolute;top: 630px;left: 43px;font-size: 10px;width: 645px;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: center;font-weight: bold; font-size: 14px">
                Cuidados para el familiar de paciente hospitalizado
            </div>
            <div style="position: absolute;top: 660px;left: 43px;font-size: 15px;width: 645px;text-align: justify;">
                <ol style="text-align: justify;">
                    <li>Se le dotará de un cubrebocas.</li>
                    <li>Vigilar datos de alarma (fiebre, tos, dificultad respiratoria),  y en caso necesario utilice el servicio de atención médica telefónica o acuda a la unidad médica más cercana e informe que estuvo en contacto con paciente sospechoso COVID-19.
                    </li>
                    <li>Debe mantener aislamiento domiciliario.</li>
                </ol>
            </div>
            <div style="position: absolute;top: 780px;left: 43px;font-size: 10px;width: 645px;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: center;font-weight: bold; font-size: 14px">
                OrientaciÓn Médica TelÉfonica
            </div>
            <div style="position: absolute;top: 810px;left: 43px;font-size: 15px;width: 645px;text-align: justify;">
                <p> Llama a la línea <strong>800 222 2668</strong> Personal calificado te orientará y resolverá tus dudas.
                    NO OLVIDE TENER TU NÚMERO DE SEGURIDAD SOCIAL A LA MANO. Con gusto te atenderemos: de Lunes a Domingo de 8:00 a 20:00 horas. ¡Quedate en casa!
                </p>
            </div>
            <div style="position: absolute;top: 890px;left: 43px;font-size: 10px;width: 645px;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: justify;font-weight: bold; font-size: 14px">
                ESTIMADO PACIENTE, UNA VEZ CONCLUIDO SU TRATAMIENTO, POR FAVOR, RECUERDE REGRESAR EL OXIMETRO DE PULSO QUE VIENE DENTRO DEL KIT, EL CUAL SERVIRÁ PARA EL SEGUIMIENTO DOMICILIARIO DE OTRO PACIENTE,ESTA ACCIÓN SE DEBE REALIZAR EN EL MISMO TRIAGE RESPIRATORIO DONDE USTED FUE VALORADO.
            </div>
            <div style="position: absolute;top: 980px;left: 43px;font-size: 10px;width: 645px;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: justify;font-weight: bold; font-size: 14px">
                Si su familiar queda hospitalizado en esta unidad, debe pasar a dar datos de contacto en las oficinas de trabajo social y asistentes médicas ubicadas bajo la rampa del triage.
            </div>

        </div>
    </page_header>
</page>
<page backtop="85mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/covid19/prueba_rapida_covid.png" style="position: absolute;width: 100%;margin-top: 0px;margin-left: -5px;">   
            <div style="position: absolute;top: -5px;left: 580px;font-size: 12px;text-transform: uppercase;width: 150px;">
                <b>H. DE ESPECIALIDADES DEL CMN SIGLO XXI</b>
            </div>
            <div style="position: absolute;top: 250px;left: 155px;font-size: 12px;text-transform: uppercase;width: 390px;">
                <b><?=$info[0]['triage_nombre_ap']?></b>
            </div>
            <div style="position: absolute;top: 250px;left: 300px;font-size: 12px;text-transform: uppercase;width: 390px;">
                <b><?=$info[0]['triage_nombre_am']?></b>
            </div>
            <div style="position: absolute;top: 250px;left: 435px;font-size: 12px;text-transform: uppercase;width: 390px;">
                <b><?=$info[0]['triage_nombre']?></b>
            </div>
            <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info[0]['triage_fecha_nac'])); ?>
            <div style="position: absolute;top: 275;left: 155px;;width: 270px;text-transform: uppercase;font-size: 11px;">
                <b><?=$fecha->y==0 ? $fecha->m.' MESES' : $fecha->y.' AÑOS'?></b>
            </div>
            <div style="position: absolute;top: 295px;left: 155px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$pinfo[0]['pum_nss']?>-<?=$pinfo[0]['pum_nss_agregado']?></b>
            </div>
            <div style="position: absolute;top: 317px;left: 155px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$info[0]['triage_paciente_sexo']?></b>
            </div>
            <div style="position: absolute;top: 380px;left: 430px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$info[0]['triage_id']?></b>
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
            <b><?=$pinfo[0]['pum_nss']?> <?=$pinfo[0]['pum_nss_agregado']?></b>
        </div>
        <div style="position: absolute;top: 140px;left: 135px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$info[0]['triage_nombre_ap']?></b>
        </div>
        <div style="position: absolute;top: 140px;left: 355px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$info[0]['triage_nombre_am']?></b>
        </div>
        <div style="position: absolute;top: 140px;left: 540px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b><?=$info[0]['triage_nombre']?></b>
        </div>
        <?php  
                $fechaNac = $info[0]['triage_fecha_nac'];
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
            <b><?=$info[0]['triage_paciente_curp']?></b>
        </div>
        <?php if($info[0]['triage_paciente_sexo'] == 'HOMBRE') {
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
        <div style="position: absolute;top: 455px;left: 140px;font-size: 10px">
            <b><?= $clasificacion[0]['puesto_empleado']?></b>
        </div>
        <!-- Datos clinicos -->
        <div style="position: absolute;top: 520px;left: 183px;font-size: 10px;text-transform: uppercase;width: 390px;">
            <b>TRIAGE RESPIRATORIO</b>
        </div>
        <div style="position: absolute;top: 557px;left: 235px;font-size: 10px">
            <?= date("d/m/Y", strtotime($info[0]['triage_fecha_clasifica']))?>
        </div>
        <div style="position: absolute;top: 557px;left: 548px;font-size: 10px">
            <?= date("d/m/Y", strtotime($clasificacion[0]['inicio_sintomas']))?>
        </div>
        
        <?php $left1 = ($clasificacion[0]['fiebre']==2) ?'290px':'325px'?>
        <div style="position: absolute;top: 644px;left: <?=$left1?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['tos']==2) ?'290px':'325px'?>
        <div style="position: absolute;top: 658px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['cefalea']==2) ?'290px':'325px'?>
        <div style="position: absolute;top: 674px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['disnea']==3) ?'290px':'325px'?>
        <div style="position: absolute;top: 688px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['cansancio']==1) ?'290px':'325px'?>
        <div style="position: absolute;top: 702px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['dolor_torax']==1) ?'290px':'325px'?>
        <div style="position: absolute;top: 717px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['dolor_garganta']==1) ?'290px':'325px'?>
        <div style="position: absolute;top: 747px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['mialgia']==1) ?'290px':'325px'?>
        <div style="position: absolute;top: 763px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['artragias']==1) ?'290px':'325px'?>
        <div style="position: absolute;top: 778px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['anosmia']==1) ?'290px':'325px'?>
        <div style="position: absolute;top: 792px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['disgeusia']==1) ?'290px':'325px'?>
        <div style="position: absolute;top: 807px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['rinorrea']==1) ?'290px':'325px'?>
        <div style="position: absolute;top: 822px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['conjuntivitis']==1) ?'290px':'325px'?>
        <div style="position: absolute;top: 837px;left: <?=$left2?>;font-size: 10px">X</div>
        
        <?php $left2 = ($clasificacion[0]['diarrea']==1) ?'290px':'325px'?>
        <div style="position: absolute;top: 897px;left: <?=$left2?>;font-size: 10px">X</div>
        
        <?php $left2 = ($clasificacion[0]['diabetes']==3) ?'585px':'620px'?>
        <div style="position: absolute;top: 629px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['epoc']==3) ?'585px':'620px'?>
        <div style="position: absolute;top: 643px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['inmunodef']==3) ?'585px':'620px'?>
        <div style="position: absolute;top: 673px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['hipertension']==3) ?'585px':'620px'?>
        <div style="position: absolute;top: 688px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['cardiopatia']==3) ?'585px':'620px'?>
        <div style="position: absolute;top: 717px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['obesidad']==3) ?'585px':'620px'?>
        <div style="position: absolute;top: 733px;left: <?=$left2?>;font-size: 10px">X</div>
        <?php $left2 = ($clasificacion[0]['hepatopatia']==3) ?'585px':'620px'?>
        <div style="position: absolute;top: 748px;left: <?=$left2?>;font-size: 10px">X</div>
    </page_header>
</page>
<page backtop="85mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/covid19/estudio_epidemiolgico_2.png" style="position: absolute;width: 92%;margin-top: 0px;margin-left: 15px;">
        <div style="position: absolute;top: 1035px;left: 88px;font-size: 9px;text-transform: uppercase;width: 390px;">
            <b><?=$medico[0]['empleado_nombre']?> <?=$medico[0]['empleado_apellidos']?></b>
        </div>
        <div style="position: absolute;top: 1049px;left: 88px;font-size: 9px;text-transform: uppercase;width: 390px;">
            <b><?=$medico[0]['empleado_matricula']?></b>
        </div>
    </page_header>
</page>
<?php 
if($info[0]['triage_consultorio_nombre']!= 'Domicilio') {?>
<page>
    <page_header>
        <img src="<?=  base_url()?>assets/doc/consen_infor_traslado.png" style="position: absolute;width: 100%;margin-top: 50px;margin-left: 0px;">

        <div style="position: absolute;top: 90px;left: 555px;font-size: 12px;text-transform: uppercase;width: 200px;">
            <b><?=$pinfo[0]['pum_umf']?> / Delegación <?=$pinfo[0]['pum_delegacion']?></b>
        </div>
        <div style="position: absolute;top: 140px;left: 555px;font-size: 12px;text-transform: uppercase;width: 200px;">
            <b><?=$info[0]['triage_nombre']?> <?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?></b>
        </div>
        <div style="position: absolute;top: 225px;left: 555px;font-size: 12px;text-transform: uppercase;width: 190px;">
            <b><?=$pinfo[0]['pum_nss']?>  <?=$pinfo[0]['pum_nss_agregado']?></b>
        </div>
        <div style="position: absolute;top: 275px;left: 599px;font-size: 12px;text-transform: uppercase;">
            <?php 
                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info[0]['triage_fecha_nac']));?>
                <b><?=$fecha->y?> AÑOS</b>
        </div>
        <div style="position: absolute;top: 330px;left: 170px;font-size: 12px;text-transform: uppercase;width: 300px;">
            <b>TRIAGE RESPIRATORIO</b>
        </div>
        <div style="position: absolute;top: 330px;left: 555px;font-size: 12px;text-transform: uppercase;width: 390px;">
            <b>CD DE MÉXICO A <?= date("d/m/Y", strtotime($info[0]['triage_fecha_clasifica']))?></b>
        </div>
        <div style="position: absolute;top: 370px;left: 50px;font-size: 12px;text-transform: uppercase;width: 350px;">
            <b><?=$info[0]['triage_nombre']?> <?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?></b>
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
            <b><?=$info[0]['triage_nombre']?> <?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?></b>
        </div>
        <div style="position: absolute;top: 885px;left: 405px;font-size: 12px;text-transform: uppercase;width: 390px;">
            <b><?=$pinfo[0]['pic_responsable_nombre']?></b>
        </div>
        <div style="position: absolute;top: 955px;left: 25px;font-size: 12px;text-transform: uppercase;width: 390px;">
            <b><?=$medico[0]['empleado_nombre']?> <?=$medico[0]['empleado_apellidos']?></b>
        </div>
    </page_header>
</page>
<?php }?>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->SetTitle('CLASIFICACIÓN DE PACIENTES');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('CLASIFICACIÓN DE PACIENTES (TRIAGE).pdf');
?>