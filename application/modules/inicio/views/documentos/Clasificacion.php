<?php ob_start(); ?>
<page>
    <page_header>
       <img src="<?=  base_url()?>assets/doc/Clasificacion_.png" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
       <div style="position: absolute;">
            <div style="position: absolute;top: 10px;left: 43px;font-size: 10px;width: 645px;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: center;font-weight: bold">
                DESTINO: <?=$info[0]['triage_consultorio_nombre']?>&nbsp;&nbsp;&nbsp;&nbsp;HORA CERO:<?=$info[0]['triage_horacero_h']?>&nbsp;&nbsp;&nbsp;&nbsp;HORA TRIAGE:<?=$info[0]['triage_hora']?>
                <?php
                    $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info[0]['triage_codigo_atencion']);
                    echo ($codigo_atencion != '')?"<span style='font-size:10px; color:white'><b>Código $codigo_atencion</b></span>":"";
                ?>
            </div>
            <div style="position: absolute;top: 155px;left: 184px;font-size: 10px"><?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?></div>
            <div style="position: absolute;top: 155px;left: 440px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[2]?></div>
            <div style="position: absolute;top: 155px;left: 490px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[1]?></div>
            <div style="position: absolute;top: 155px;left: 530px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[0]?></div>
            <div style="position: absolute;top: 155px;left: 640px;font-size: 10px"><?=  explode(':', $info[0]['triage_hora_clasifica'])[0]?></div>
            <div style="position: absolute;top: 155px;left: 655px;font-size: 10px"><?=  explode(':', $info[0]['triage_hora_clasifica'])[1]?></div>
            <!---Seccion 2-->
            <div style="position: absolute;top: 178px;left: 100px;font-size: 10px"><?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?> <?=$info[0]['triage_nombre']?></div>
            <div style="position: absolute;top: 192px;left: 440px;font-size: 8px">(Motivo de Atención)</div>
            <div style="position: absolute;top: 178px;left: 400px;font-size: 10px"><?=$info[0]['triage_motivoAtencion']?></div>
            <div style="position: absolute;top: 192px;left: 550px;font-size: 8px">(Peso)</div>
            <div style="position: absolute;top: 192px;left: 577px;font-size: 10px"><?=$SignosVitales['sv_peso']?> Kg</div>
            <div style="position: absolute;top: 192px;left: 610px;font-size: 8px">(Talla)</div>
            <div style="position: absolute;top: 192px;left: 637px;font-size: 10px"><?=$SignosVitales['sv_talla']?> m</div>
            <!---Seccion 3-->
            <?php if($_GET['via']=='Choque'){?>
            <div style="position: absolute;top: 225px;left: 145px;font-size: 10px"><?=$class_choque[0]['sv_ta']?></div> 
            <div style="position: absolute;top: 225px;left: 280px;font-size: 10px"><?=$class_choque[0]['sv_temp']?></div>
            <div style="position: absolute;top: 225px;left: 455px;font-size: 10px"><?=$class_choque[0]['sv_fc']?></div>
            <div style="position: absolute;top: 225px;left: 630px;font-size: 10px"><?=$class_choque[0]['sv_fr']?></div>
            <?php }else{?>
            <div style="position: absolute;top: 225px;left: 145px;font-size: 10px"><?=$SignosVitales['sv_ta']?></div> 
            <div style="position: absolute;top: 225px;left: 260px;font-size: 10px"><?=$SignosVitales['sv_temp']?> °C</div>
            <div style="position: absolute;top: 225px;left: 465px;font-size: 10px"><?=$SignosVitales['sv_fc']?></div>
            <div style="position: absolute;top: 225px;left: 645px;font-size: 10px"><?=$SignosVitales['sv_fr']?></div>
            <?php }?>
            <?php if($this->ConfigSolicitarOD=='Si'){?>
            <div style="position: absolute;top: 208px;left: 50px;font-size: 10px">
                <b>Oximetría:</b> <?=$SignosVitales['sv_oximetria']?> % spO2
            </div>
            <div style="position: absolute;top: 208px;left: 530px;font-size: 10px">
                <b>Glucemia:</b> <?=$SignosVitales['sv_dextrostix']?> mg/dL
            </div>
            <?php }?>
            <!--Seccion 4 Pregunta 1-->
            <div style="position: absolute;top: 292px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg1_s1']==0){echo 'X';}?></div>
            <div style="position: absolute;top: 292px;left: 570px;font-size: 10px"><?php if($info[0]['triage_preg1_s1']!=0){echo 'X';}?></div>
            <!--Seccion 4 Pregunta 2-->
            <div style="position: absolute;top: 310px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg2_s1']==0){echo 'X';}?></div>
            <div style="position: absolute;top: 310px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg2_s1']!=0){echo 'X';}?></div>
            <!--Seccion 4 Pregunta 3-->
            <div style="position: absolute;top: 326px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg3_s1']==0){echo 'X';}?></div>
            <div style="position: absolute;top: 326px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg3_s1']!=0){echo 'X';}?></div>
            <!--Seccion 4 Pregunta 4-->
            <div style="position: absolute;top: 340px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg4_s1']==0){echo 'X';}?></div>
            <div style="position: absolute;top: 340px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg4_s1']!=0){echo 'X';}?></div>
            <!--Seccion 4 Pregunta 5-->
            <div style="position: absolute;top: 355px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg5_s1']==0){echo 'X';}?></div>
            <div style="position: absolute;top: 355px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg5_s1']!=0){echo 'X';}?></div>
            <!--Seccion 4 Total-->
            <div style="position: absolute;top: 370px;left: 595px;font-size: 10px"><?=$clasificacion[0]['triege_preg_puntaje_s1']?></div>

            <!--Seccion 5 Pregunta 1-->
            <div style="position: absolute;top: 440px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg1_s2']?></div>
            <!--Seccion 5 Pregunta 2-->
            <div style="position: absolute;top: 453px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg2_s2']?></div>
            <!--Seccion 5 Pregunta 3-->
            <div style="position: absolute;top: 468px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg3_s2']?></div>
            <!--Seccion 5 Pregunta 4-->
            <div style="position: absolute;top: 486px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg4_s2']?></div>
            <!--Seccion 5 Pregunta 5-->
            <div style="position: absolute;top: 498px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg5_s2']?></div>
            <!--Seccion 5 Pregunta 6-->
            <div style="position: absolute;top: 510px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg6_s2']?></div>
            <!--Seccion 5 Pregunta 7-->
            <div style="position: absolute;top: 528px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg7_s2']?></div>
            <!--Seccion 5 Pregunta 8-->
            <div style="position: absolute;top: 545px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg8_s2']?></div>
            <!--Seccion 5 Pregunta 9-->
            <div style="position: absolute;top: 557px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg9_s2']?></div>
            <!--Seccion 5 Pregunta 10-->
            <div style="position: absolute;top: 575px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg10_s2']?></div>
            <!--Seccion 5 Pregunta 11-->
            <div style="position: absolute;top: 590px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg11_s2']?></div>
            <!--Seccion 5 Pregunta 12-->
            <div style="position: absolute;top: 608px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg12_s2']?></div>
            <!--Seccion 5 Total-->
            <div style="position: absolute;top: 626px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triege_preg_puntaje_s2']?></div>
            <!--Seccion 6 Pregunta l-->
            <div style="position: absolute;top: 676px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg1_s3']?></div>
            <!--Seccion 6 Pregunta 2-->
            <div style="position: absolute;top: 690px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg2_s3']?></div>
            <!--Seccion 6 Pregunta 3-->
            <div style="position: absolute;top: 702px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg3_s3']?></div>
            <!--Seccion 6 Pregunta 4-->
            <div style="position: absolute;top: 714px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg4_s3']?></div>
            <!--Seccion 6 Pregunta 4-->
            <div style="position: absolute;top: 726px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg5_s3']?></div>
            <!--Seccion 6 Total Final-->
            <div style="position: absolute;top: 740px;left: 646px;font-size: 10px"><?=$clasificacion[0]['triage_puntaje_total']?></div>

            <div style="position: absolute;top: 848px;left: 60px;font-size:9px;width: 200px;text-align: center;">
                <?=$medico[0]['empleado_nombre']?> <?=$medico[0]['empleado_apellidos']?>
            </div>
            <div style="position: absolute;top: 848px;left: 280px;font-size:9px;width:200px;text-align: center;">
                <?=$medico[0]['empleado_matricula']?>
            </div>
            <div style="width: 660px;margin: auto;font-size: 11px;top: 900px;padding: 0px;position: absolute;left: 43px;padding: 0px;text-align: justify">
                <?php if($clasificacion[0]['triage_qsofa'] <= 1) {
                        echo 'Escala de qSOFA Riesgo Bajo.';
                      } else echo 'Escala de qSOFA Riesgo Alto de mal pronóstico.'

                ?>
                <?php if($this->ConfigExcepcionCMT=='Si' && $clasificacion[0]['triage_observacion']!=''){?>  
                        <b>Observaciones: </b><?=$clasificacion[0]['triage_observacion']?><br>
                <?php }?>
                <?php if($info[0]['triage_envio_otraunidad']== 'Si') {
                        if($info[0]['triage_envio_nombre']=='Domicilio'){
                            $sql=  $this->config_mdl->_get_data_condition('os_triage_clasificacion_tratamiento',array('triage_id' =>  $info[0]['triage_id']))[0];
                            echo 'Se envia a'.' '.'<b>Domicilio</b>';
                            if(!empty($sql)) {
                                echo ' con tratamiento: ';
                                $valueTratamiento = explode("," ,$sql['tratamiento']);
                                foreach ($valueTratamiento as $value_p => $tratamiento) {
                                    switch ($tratamiento) {
                                        case '1':
                                            echo 'OSELTAMIVIR 75 mg C/12 hrs POR 5 DIAS. ';
                                            break;
                                        
                                        case '2':
                                            echo 'PARACETAMOL 500 mg C/8 hrs POR 5 DIAS. ';
                                            break;
                                        case '3';
                                            echo 'CLARITROMICINA 500 mg C/12 hrs POR 7 DIAS.';
                                            break;
                                    }                        
                                }
                            }
                        }else{ 
                              echo 'Se envia a'.' '.'<b>'.$info[0]['triage_envio_nombre'].'</b>'.' '.'para su seguimiento.';
                            }
                    }?>
            </div>
            <div style="position: absolute;left: 280px;top: 970px">
                <barcode type="C128A" value="<?=$info[0]['triage_id']?>" style="height: 40px;" ></barcode>
            </div>
            <?php if($this->UMAE_AREA=='Medico Triage Respiratorio') {?>
            <div style="font-size: 10px; position: absolute;left: 320px;top: 1023px">Area Triage Respiratorio</div>
            <?php }?>
        </div> 
    </page_header>
    
    <page_footer>

        <?php 
        if($clasificacion[0]['triage_color']=='Rojo'){
            $color='#E50914';
            $color_name='Rojo';
            $tiempo='Inmediatamente';
            $tipoAtencion='Real';
        }if($clasificacion[0]['triage_color']=='Naranja'){
            $color='#FF7028';
            $color_name='Naranja';
            $tiempo='10 Minutos';
            $tipoAtencion='Real';
        }if($clasificacion[0]['triage_color']=='Amarillo'){
            $color_name='Amarillo';
            $tiempo='11-60 Minutos';
            $tipoAtencion='Real';
        }if($clasificacion[0]['triage_color']=='Verde'){
            $color='#4CBB17';
            $color_name='Verde';
            $tiempo='61-120 Minutos';
            $tipoAtencion='Sentida';
        }if($clasificacion[0]['triage_color']=='Azul'){
            $color='#0000FF';
            $color_name='Azul';
            $tiempo='121-240 Minutos';
            $tipoAtencion='Sentida';
        }

        ?>
        
        <div style="height: 15px;width: 645px;background: black;margin: auto;color: white;text-align: center;padding: 10px;border-radius: 5px;font-weight: bold;text-transform: uppercase">
            Puntaje Total:<?=$clasificacion[0]['triage_puntaje_total']?> | Color : <?=$color_name?> <?=$tiempo?> | URGENCIA: <?=$tipoAtencion?>
        </div>
    </page_footer>
</page>
<?php if($codigo_atencion == 'Cerebro') {?>
<page>
    <page_header>
       <img src="<?=  base_url()?>assets/doc/codigo_cerebro1.png" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
       <div style="position: absolute;">
            
            <div style="position: absolute;top: 100px;left: 610px;font-size: 12px">
                <?=  explode('-', $info[0]['triage_fecha_clasifica'])[2]?>/<?=  explode('-', $info[0]['triage_fecha_clasifica'])[1]?>/<?=  explode('-', $info[0]['triage_fecha_clasifica'])[0]?> <?=  explode(':', $info[0]['triage_hora_clasifica'])[0]?>:<?=  explode(':', $info[0]['triage_hora_clasifica'])[1]?>
            </div>
            <div style="position: absolute;top: 116px;left: 70px;font-size: 12px"><?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?> <?=$info[0]['triage_nombre']?></div>
            <div style="position: absolute;top: 116px;left: 480px;font-size: 12px"><?=$pinfo[0]['pum_nss']?> <?=$pinfo[0]['pum_nss_agregado']?></div>
            <div style="position: absolute;top: 131px;left: 51px;font-size: 12px">
            <?php 
                if($info[0]['triage_fecha_nac']!=''){
                    $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info[0]['triage_fecha_nac']));
                    echo $fecha->y.' <span>años</span>';
                }else{
                    echo 'S/E';
                }
            ?>
        </div>

        </div>
    </page_header>
</page>
<page>
    <page_header>
       <img src="<?=  base_url()?>assets/doc/codigo_cerebro2.png" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
    </page_header>
</page>
<page>
    <page_header>
       <img src="<?=  base_url()?>assets/doc/codigo_cerebro3-1.png" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
    </page_header>
</page>
<page>
    <page_header>
       <img src="<?=  base_url()?>assets/doc/codigo_cerebro4.png" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
    </page_header>
</page>
<page>
    <page_header>
       <img src="<?=  base_url()?>assets/doc/bitacora_codigocerebro.png" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
    </page_header>
</page>
<?php }?>
<?php if($this->UMAE_AREA=='Medico Triage Respiratorio') {?>
<page>
    <page_header>
        <div style="position: absolute;">
            <div style="position: absolute;top: 10px;left: 43px;font-size: 10px;width: 645px;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: center;font-weight: bold; font-size: 14px">
                Cuidados en casa para la persona enferma por COVID-19
            </div>
            <div style="position: absolute;top: 40px;left: 43px;font-size: 15px;width: 605px;text-align: center;">
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
            <div style="position: absolute;top: 350px;left: 43px;font-size: 10px;width: 645px;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: center;font-weight: bold; font-size: 14px">
                Cuidados en casa para los familiares de la persona enferma por COVID-19
            </div>
            <div style="position: absolute;top: 380px;left: 43px;font-size: 15px;width: 605px;text-align: center;">
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