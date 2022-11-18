
 <?php

    $plantilla =  base_url()."assets/doc/430_006c.png";
    $n=0;
    $i=0;

 ?>

<page backleft="0mm" backright="0mm" backtop="91.5mm">
    <page_header>
       <div style="position: absolute">
            <img src="<?= $plantilla?>" style="position: absolute;width: 100%">
            <div style="position: absolute;margin-left: 20px;margin-top: 70px;font-size: 10px"><?=$this->UM_CLASIFICACION?> <?=$this->UM_NOMBRE?></div>
            <div style="position: absolute;margin-left: 232px;margin-top: 80px;font-size: 12px"><?= $_GET['inputFechaInicio']?></div>
            <div style="position: absolute;margin-left: 310px;margin-top: 80px;font-size: 12px"><?=  $medico['empleado_matricula']?></div>
            <div style="position: absolute;margin-left: 400px;margin-top: 83px;font-size: 8px"></div>
            <div style="position: absolute;margin-left: 500px;margin-top: 83px;font-size: 8px"><?=$servicio['clave']?></div>
            <div style="position: absolute;margin-left: 659px;margin-top: 83px;font-size: 12px; width: 45px;text-align: center;"><?= $_GET['turno'] ?></div>
            <div style="position: absolute;margin-left: 140px;margin-top: 115px;font-size: 14px"><b>37B5091C2153</b></div>
            <div style="position: absolute;margin-left: 440px;margin-top: 115px;font-size: 14px;"><b><?=$medico['empleado_nombre']?> <?=$medico['empleado_apellidos']?></b></div>
            <div style="position: absolute;margin-left: 430px;margin-top: 81px;font-size: 9px;width: 45px;text-align: center">
                <?php 
                    $sqlClave= Modules::run('Consultoriosespecialidad/ObtenerServicioConsultorio',array(
                        'Consultorio'=>$_SESSION['UMAE_AREA']
                    ));
                    if($sqlClave=='Cirugía Plastica y Reconstructiva'){
                        echo '4600';
                    }if($sqlClave=='Traumatología'){
                        echo '3801';
                    }if($sqlClave=='Neurocirugía'){
                        echo '4300';
                    }if($sqlClave=='Cirugía General'){
                        echo '1600';
                    }if($sqlClave=='Cirugía Maxilofacial'){
                        echo '1200';
                    }
                ?>
                050
            </div>
            <div style="font-size: 6px;position: absolute;margin-left: <?php

                  if(strpos($_SESSION['UMAE_AREA'], 'onsultorio') !== false){
                     echo  '571px';
                    }if(strpos($_SESSION['UMAE_AREA'], 'riage') !== false){
                        echo '485px; font-size:15px';
                    }if(strpos($_SESSION['UMAE_AREA'], 'bservaci') !== false){
                        echo '571px';
                    }

                ?>;margin-top: 81px;width: 60px;text-align: center;">
                <?php

                  if(strpos($_SESSION['UMAE_AREA'], 'onsultorio') !== false){
                     echo  'Consultorios';
                    }if(strpos($_SESSION['UMAE_AREA'], 'riage') !== false){
                        echo 'X';
                    }if(strpos($_SESSION['UMAE_AREA'], 'bservaci') !== false){
                        echo 'Observación';
                    }

                ?>
            </div> 
        </div>
    </page_header>
 
    <div style="position: absolute;">
        <?php  

            for (;$n<count($HojasFrontales_medico_triage) ; $n++ ) { 

                if($n==9) break;

                $value = current($HojasFrontales_medico_triage);
                next($HojasFrontales_medico_triage);

                $paciente_diagnostico_primario  ='';
                $paciente_diagnosticos_secundarios  ='';
                $paciente_diagnostico_primario_cie10_id  ='';
                $paciente_diagnosticos_secundarios_cie10_id  ='';
                $margin_topNum              = (85 + $i*75);
                $margin_topPacient          = (52 + $i*73);
                $margin_topProcedimiento    = (52 + $i*73);
                $i++;
        ?>
            <?php
                $sqlCe=$this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
                    'triage_id'=>$value['triage_id']
                ));
                $PUM=$this->config_mdl->_get_data_condition('paciente_info',array(
                        'triage_id'=>$value['triage_id']
                ))[0];
                
                $value_procedimiento=explode("," ,$value['hf_procedimientos']);
                /* margin_left para poner la x en Urgencia Real o Sentida */
                switch($value['triage_color']) {
                    case "Rojo": 
                                $triage_color = 1;                
                                $margin_left = 555;   
                                break;
                    case "Naranja": 
                                $triage_color = 2;                                
                                $margin_left = 555;
                                break;
                    case "Amarillo": 
                                $triage_color = 3;                               
                                $margin_left = 555;
                                break;
                    case "Verde": 
                                $triage_color = 4;                                
                                $margin_left = 574;
                                break;
                    case "Azul": 
                                $triage_color = 5;                                
                                $margin_left = 574;
                                break;
                }

                switch($value['triage_envio_otraunidad']) {
                    case "Si": 
                                if($value['triage_envio_nombre']=='UMF' || $value['triage_envio_nombre']=='HGZ' || $value['triage_envio_nombre']=='Otra unidad imss') {
                                    $destino = 2;
                                }else if($value['triage_envio_nombre']=='Ginecología' || $value['triage_envio_nombre']=='Tramautología y Ortopedia'){
                                    $destino = 6;
                                }else if($value['triage_envio_nombre']== 'Otra unidad no imss') {
                                    $destino = 4;
                                }
                                break;
                    case "No": 
                                $sqlHospitalizacion= $this->config_mdl->_get_data_condition('doc_43051', array('triage_id'=>$value['triage_id']))[0];        
                                if(!empty($sqlHospitalizacion)) {
                                    $destino = 1;
                                }else $destino = '';
                                break;
                    
                }

            $triage_id_ = $value['triage_id'];
            $fecha_dx_ =  $value['hf_fg'];

            ?>
                <div style="position: absolute;margin-left: 10px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;text-align: center;"><?=$i?></div>

                <div style="position: absolute;margin-left: 38px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90;">
                        <?=$value['triage_horacero_h']?>
                </div>
                 <div style="position: absolute;margin-left: 54px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90; ">
                        <?=$value['triage_hora']?>
                </div>
                <div style="position: absolute; margin-left: 70px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90; ">
                        <?=$value['triage_hora_clasifica']?>
                </div>
                <!-- Hora de Consulta -->
                <div style="position: absolute;margin-left: 88px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90;">
                    <?php 
                            if($value['triage_envio_otraunidad']=='No') {
                                $hrConsultorio=$this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
                                    'triage_id'=>$value['triage_id']
                                ))[0];
                                $hrObservacion=$this->config_mdl->_get_data_condition('os_observacion',array(
                                    'triage_id'=>$value['triage_id']
                                ))[0];

                                if(isset($hrConsultorio['ce_he'])) { ?> 
                                    <?=$hrConsultorio['ce_he']?> 
                    <?php       }else if(isset($hrObservacion['observacion_he'])){ ?>
                                <?=$hrObservacion['observacion_he']?> 
                    <?php       }
                            }else {?>
                            <?=$value['triage_hora_clasifica']?> <?php } ?> 
                </div>
    
                <div style="position: absolute;margin-left: 110px;margin-top: <?php echo $margin_topProcedimiento; ?>px;font-size: 9px; width: 200px;">
                        <?php echo $triage_color; ?>
                </div>
                <!-- Envio Consensuado a UMF -->
                <div style="position: absolute;margin-left: 125px;margin-top: <?php echo $margin_topProcedimiento; ?>px;font-size: 9px; width: 200px;">
                        <?php  if($value['triage_envio_nombre'] == 'UMF') {
                                    echo 'X';
                        }?>
                </div>
                <!-- Destino -->
                <div style="position: absolute;margin-left: 190px;margin-top: <?php echo $margin_topProcedimiento; ?>px;font-size: 9px; width: 200px;">
                        <?php echo $destino; //echo $value['triage_envio_nombre'];    ?>
                </div>
                
                
                <div style="position: absolute;margin-left: <?php echo  $margin_left; ?>;margin-top: <?php echo  $margin_topPacient; ?>px;font-size: 9px; width: 582px;   ">X
                </div>


                <div style="position: absolute;margin-left: 696px;margin-top: <?php echo $margin_topPacient + 33; ?>px;font-size: 9px; width: 57px; text-align: center;"><?=$paciente_diagnostico_primario_cie10_id?>
                </div>
            

                <div style="position: absolute;margin-left: 110px;margin-top: <?php echo $margin_topPacient + 60; ?>px;font-size: 9px; width: 200px;"><?= $paciente_diagnosticos_secundarios ?>
                </div>


                <div style="position: absolute;margin-left: 696px;margin-top: <?php echo $margin_topPacient + 60; ?>px;font-size: 9px; width: 57px;  text-align: center;"><?=$paciente_diagnosticos_secundarios_cie10_id?>
                </div>


                <div style="position: absolute;margin-left: 270px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 9px; width: 400px;"><?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>
                </div>

                <div style="position: absolute;margin-left: 586px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 10px; width: 109px; text-align: center; ">
                    <?php echo  str_replace("-", "", $PUM['pum_nss']);?>
                </div>
                <div style="position: absolute;margin-left: 700px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 10px; width: 200px; ">
                    <?=$PUM['pum_nss_agregado']?>
                </div>
                <div style="position: absolute;margin-left: 200px;margin-top: <?php echo $margin_topPacient + 32; ?>px;font-size: 10px; width: 400px;"><?=$value['triage_motivoAtencion']?>
                </div>
                <div style="position: absolute;margin-left: 140px;margin-top: <?php echo $margin_topProcedimiento; ?>px;font-size: 9px; width: 200px;"><?php foreach($value_procedimiento as $value_p => $procedimiento) { echo $procedimiento; echo "&nbsp;&nbsp;&nbsp;";} ?>
                </div>
                <!-- border: 1px solid red; -->
                
        <?php }?>
        
    </div>
    <page_footer></page_footer>
</page>


 <?php

    $plantilla =  base_url()."assets/doc/430_006b.png";
    while($n<count($HojasFrontales_medico_triage)){    

?>



<page backleft="0mm" backright="0mm" backtop="91.5mm">
    <page_header>
       <div style="position: absolute">
            <img src="<?= $plantilla?>" style="position: absolute;width: 100%">
            
        </div>
    </page_header>
 
    <div style="position: absolute;">
        <?php  

            $l = $n;
            $j=0;

            for (;$n<count($HojasFrontales_medico_triage) ; $n++ ) { 

               if($n == $l + 10 ) break;

                $value = current($HojasFrontales_medico_triage);
                next($HojasFrontales_medico_triage);

                $paciente_diagnostico_primario  ='';
                $paciente_diagnosticos_secundarios  ='';

                $paciente_diagnostico_primario_cie10_id  ='';

                $paciente_diagnosticos_secundarios_cie10_id  ='';


                $margin_topNum              = (85 -85+ $j*75);
                $margin_topPacient          = (50 -85+ $j*73);
                $margin_topProcedimiento    = (50 -85+ $j*73);
                $i++;
                $j++;



        ?>
            <?php
                $sqlCe=$this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
                    'triage_id'=>$value['triage_id']
                ));
                $PUM=$this->config_mdl->_get_data_condition('paciente_info',array(
                        'triage_id'=>$value['triage_id']
                ))[0];
                $value_procedimiento=explode("," ,$value['hf_procedimientos']);
                
                switch($value['triage_color']) {
                    case "Rojo": 
                                $triage_color = 1;                
                                $margin_left = 555;   
                                break;
                    case "Naranja": 
                                $triage_color = 2;                                
                                $margin_left = 555;
                                break;
                    case "Amarillo": 
                                $triage_color = 3;                               
                                $margin_left = 555;
                                break;
                    case "Verde": 
                                $triage_color = 4;                                
                                $margin_left = 574;
                                break;
                    case "Azul": 
                                $triage_color = 5;                                
                                $margin_left = 574;
                                break;
                }

                switch($value['triage_envio_otraunidad']) {
                    case "Si": 
                                if($value['triage_envio_nombre']=='UMF' || $value['triage_envio_nombre']=='HGZ' || $value['triage_envio_nombre']=='Otra unidad imss') {
                                    $destino = 2;
                                }else if($value['triage_envio_nombre']=='Ginecología' || $value['triage_envio_nombre']=='Tramautología y Ortopedia'){
                                    $destino = 6;
                                }else if($value['triage_envio_nombre']== 'Otra unidad no imss') {
                                    $destino = 4;
                                }
                                break;
                    case "No": 
                                $sqlHospitalizacion= $this->config_mdl->_get_data_condition('doc_43051', array('triage_id'=>$value['triage_id']))[0];        
                                if(!empty($sqlHospitalizacion)) {
                                    $destino = 1;
                                }//else $destino = '';
                                break;
                    
                }

            $triage_id_ = $value['triage_id'];
            $fecha_dx_ =  $value['hf_fg'];
            ?>

                <div style="position: absolute;margin-left: 10px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;text-align: center;"><?=$i?></div>

                <div style="position: absolute;margin-left: 38px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90;">
                        <?=$value['triage_horacero_h']?>
                </div>
                 <div style="position: absolute;margin-left: 54px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90; ">
                        <?=$value['triage_hora']?>
                </div>
                <div style="position: absolute; margin-left: 70px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90; ">
                        <?=$value['triage_hora_clasifica']?>
                </div>
                
                <!-- Hora de Consulta -->
                <div style="position: absolute;margin-left: 88px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90;">
                    <?php 
                            if($value['triage_envio_otraunidad']=='No') {
                                $hrConsultorio=$this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
                                    'triage_id'=>$value['triage_id']
                                ))[0];
                                $hrObservacion=$this->config_mdl->_get_data_condition('os_observacion',array(
                                    'triage_id'=>$value['triage_id']
                                ))[0];

                                if(isset($hrConsultorio['ce_he'])) { ?> 
                                    <?=$hrConsultorio['ce_he']?> 
                    <?php       }else if(isset($hrObservacion['observacion_he'])){ ?>
                                <?=$hrObservacion['observacion_he']?> 
                    <?php       }
                            }else {?>
                            <?=$value['triage_hora_clasifica']?> <?php } ?> 
                </div>
                <div style="position: absolute;margin-left: 110px;margin-top: <?php echo $margin_topProcedimiento; ?>px;font-size: 9px; width: 200px;">
                        <?php echo $triage_color;?>
                </div>
                <!-- Envio Consensuado a UMF -->
                <div style="position: absolute;margin-left: 125px;margin-top: <?php echo $margin_topProcedimiento; ?>px;font-size: 9px; width: 200px;">
                        <?php  if($value['triage_envio_nombre'] == 'UMF') {
                                    echo 'X';
                        }?>
                </div>
                <!-- Destino -->
                <div style="position: absolute;margin-left: 190px;margin-top: <?php echo $margin_topProcedimiento; ?>px;font-size: 9px; width: 200px;">
                        <?php echo $destino; //echo $value['triage_envio_nombre']; ?>
                </div>
                <div style="position: absolute;margin-left: <?php echo  $margin_left; ?>;margin-top: <?php echo  $margin_topPacient; ?>px;font-size: 9px; width: 582px;   ">X
                </div>
                <div style="position: absolute;margin-left: 110px;margin-top: <?php echo $margin_topPacient + 33; ?>px;font-size: 9px; width: 582px;   "><?=$paciente_diagnostico_primario?>
                </div>


                <div style="position: absolute;margin-left: 696px;margin-top: <?php echo $margin_topPacient + 33; ?>px;font-size: 9px; width: 57px; text-align: center;"><?=$paciente_diagnostico_primario_cie10_id?>
                </div>
            

                <div style="position: absolute;margin-left: 110px;margin-top: <?php echo $margin_topPacient + 60; ?>px;font-size: 9px; width: 300px;"><?= $paciente_diagnosticos_secundarios ?>
                </div>


                <div style="position: absolute;margin-left: 696px;margin-top: <?php echo $margin_topPacient + 60; ?>px;font-size: 9px; width: 57px;  text-align: center;"><?=$paciente_diagnosticos_secundarios_cie10_id?>
                </div>


                <div style="position: absolute;margin-left: 270px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 9px; width: 300px;"><?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>
                </div>

                <div style="position: absolute;margin-left: 586px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 10px; width: 109px; text-align: center; ">
                    <?php echo  str_replace("-", "", $PUM['pum_nss']);?>
                </div>
                <div style="position: absolute;margin-left: 700px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 10px; width: 200px; ">
                    <?=$PUM['pum_nss_agregado']?>
                </div>
                <div style="position: absolute;margin-left: 200px;margin-top: <?php echo $margin_topPacient + 32; ?>px;font-size: 10px; width: 400px;"><?=$value['triage_motivoAtencion']?>
                </div>
                <div style="position: absolute;margin-left: 140px;margin-top: <?php echo $margin_topProcedimiento; ?>px;font-size: 9px; width: 200px;"><?php foreach($value_procedimiento as $value_p => $procedimiento) { echo $procedimiento; echo "&nbsp;&nbsp;&nbsp;";} ?>
                </div>
                <!-- border: 1px solid red; -->
                
        <?php }?>
        
    </div>
    <page_footer></page_footer>
</page>

 <?php

       } 
 ?>