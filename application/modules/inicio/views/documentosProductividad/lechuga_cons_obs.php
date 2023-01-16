
 <?php

    $plantilla =  base_url()."assets/doc/430_006c.png";
    //$plantilla =  base_url()."assets/doc/blanco.png";
    $n=0;
    $i=0;

 ?>

<page backleft="0mm" backright="0mm" backtop="91.5mm">
    <page_header>
       <div style="position: absolute">
            <img src="<?=  $plantilla?>" style="position: absolute;width: 100%">
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
            <div style="position: absolute;margin-left: <?php

                  if(strpos($_SESSION['UMAE_AREA'], 'onsultorio') !== false){
                     echo  '561px';
                    }if(strpos($_SESSION['UMAE_AREA'], 'riage') !== false){
                        echo '485px';
                    }if(strpos($_SESSION['UMAE_AREA'], 'bservaci') !== false){
                        echo '561px';
                    }

                ?>;margin-top: 81px;font-size: 10px;width: 60px;text-align: center;">
                <?php

                  if(strpos($_SESSION['UMAE_AREA'], 'onsultorio') !== false){
                     echo  'Consultorios/Obs';
                    }if(strpos($_SESSION['UMAE_AREA'], 'riage') !== false){
                        echo 'X';
                    }if(strpos($_SESSION['UMAE_AREA'], 'bservaci') !== false){
                        echo 'Obs/Consultorios';
                    }

                ?>
            </div> 
        </div>
    </page_header>
    <div style="position: absolute;">
        <?php  
        //var_dump($HF_Consultorios);
        //var_dump($HF_Observacion);
        //var_dump($Notas);
        $datos = array_merge($HF_Consultorios, $HF_Observacion, $Notas);   
        for (;$n<count($datos) ; $n++ ) { 
            if($n==9) break;
            $value = current($datos);
            next($datos);

            $paciente_diagnostico_primario  ='';
            $paciente_diagnosticos_secundarios  ='';
            $paciente_diagnostico_primario_cie10_id  ='';
            $paciente_diagnosticos_secundarios_cie10_id  ='';
            $margin_topNum              = (85 + $i*75);
            $margin_topPacient          = (50 + $i*73);
            $margin_topProcedimiento    = (50 + $i*73);
            $i++;
        
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
                            break;
                case "Naranja": 
                            $triage_color = 2;
                            break;
                case "Amarillo": 
                            $triage_color = 3;
                            break;
                case "Verde": 
                            $triage_color = 4;
                            break;
                case "Azul": 
                            $triage_color = 5;
                            break;
            }

            $triage_id_ = $value['triage_id'];
            if(isset($value['hf_fg'])) {
                $fecha_dx_ =  $value['hf_fg'];
            }else if(isset($value['notas_fecha'])) {
                $fecha_dx_ =  $value['notas_fecha'];
            }

            $sql_Diagnosticos = $this->config_mdl->_query("
                SELECT  
                    paciente_diagnosticos.tipo_diagnostico,
                    paciente_diagnosticos.complemento,
                    um_cie10.cie10_id,
                    um_cie10.cie10_clave,
                    um_cie10.cie10_nombre
                FROM paciente_diagnosticos
                INNER JOIN um_cie10 
                    ON paciente_diagnosticos.cie10_id = um_cie10.cie10_id
                    AND paciente_diagnosticos.triage_id='$triage_id_'
                    
                     ");

            foreach ($sql_Diagnosticos as $value_diagnosticos) { 
                if($value_diagnosticos['tipo_diagnostico']=='1') {
                    $paciente_diagnostico_primario  = $value_diagnosticos['cie10_nombre'];
                    $paciente_diagnostico_primario_cie10_id  = $value_diagnosticos['cie10_clave'];
                }else if($value_diagnosticos['tipo_diagnostico']=='0' ) {
                    $paciente_diagnostico_primario = $value_diagnosticos['cie10_nombre'];
                    $paciente_diagnostico_primario_cie10_id = $value_diagnosticos['cie10_clave'];
                }else if($paciente_diagnosticos_secundarios==''){
                    $paciente_diagnosticos_secundarios    .= $value_diagnosticos['cie10_nombre'];
                    $paciente_diagnosticos_secundarios_cie10_id    .= $value_diagnosticos['cie10_clave'];
                }else if ($value_diagnosticos['cie10_id'] == 69824){
                    $paciente_diagnostico_primario = $value_diagnosticos['complemento'];
                    $paciente_diagnostico_primario_cie10_id = $value_diagnosticos['cie10_clave'];
                }     
            }
            if($value['hf_ce']== 1) {
                $lugarAtencion = 'Cons';
            } elseif($value['hf_obs']== 1) {
                $lugarAtencion = 'Obs';
            } elseif($value['hf_choque']== 1) {
                $lugarAtencion = 'Choq/Obs';
            }
            $sql_TipoUrgencia = $this->config_mdl->_query("
                SELECT hf_tipourgencia FROM os_consultorios_especialidad_hf WHERE triage_id ='$triage_id_'
                "); 
            
            foreach($sql_TipoUrgencia as $tipoUrgencia) {
                if($tipoUrgencia['hf_tipourgencia'] == '1') {
                    $marginleft= 535;
                }else if($tipoUrgencia['hf_tipourgencia'] == '2'){
                    $marginleft= 552;
                }
            }
            ?>
            <div style="position: absolute;margin-left: 10px;margin-top: -200px;font-size: 10px;width: 750px;text-align:justify;"><?php ?></div>
            <div style="position: absolute;margin-left: 10px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;text-align: center;"><?=$i?></div>
            <!-- LUGAR DE ATENCIÓN PRIMER CONTACTO -->
            <div style="position: absolute;margin-left: 10px;margin-top: <?php echo $margin_topNum - 35; ?>px;font-size: 7px;width: 15px;text-align:left;">
                <?=$lugarAtencion?>
            </div>
            <div style="position: absolute;margin-left: 25px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 7px;width: 15px;text-align:center;rotate:90;"><?=$value['triage_id']?> 
            </div>

            <div style="position: absolute;margin-left: 38px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90;">
                    <?=$value['triage_horacero_h']?>
            </div>
             <div style="position: absolute;margin-left: 54px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90; ">
                    <?=$value['triage_hora']?>
            </div>
            <div style="position: absolute; margin-left: 70px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90; ">
                    <?=$value['triage_hora_clasifica']?>
            </div>
            <div style="position: absolute;margin-left: 88px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90;">
                    <?php 
                            if(isset($value['ce_he'])) {?> 
                                <?=$value['ce_he']?> 
                    <?php   } else if(isset($value['observacion_he'])){?>
                                <?=$value['observacion_he']?> 
                    <?php   } else {?><?=$value['notas_hora']?> <?php }?> 
            </div>
            <div style="position: absolute;margin-left: 110px;margin-top: <?php echo $margin_topProcedimiento; ?>px;font-size: 9px; width: 200px;">
                    <?php echo $triage_color;?>
            </div>
   
            <div style="position: absolute;margin-left: 110px;margin-top: <?php echo $margin_topPacient + 33; ?>px;font-size: 9px; width: 582px;text-transform: uppercase">
                <?=$paciente_diagnostico_primario?>
            </div>

            <div style="position: absolute;margin-left: 696px;margin-top: <?php echo $margin_topPacient + 33; ?>px;font-size: 11px; width: 57px;text-align: center;text-transform: uppercase"><?=$paciente_diagnostico_primario_cie10_id?>
            </div>
        
            <div style="position: absolute;margin-left: 110px;margin-top: <?php echo $margin_topPacient + 60; ?>px;font-size: 9px; width: 582px;text-transform: uppercase"><?= $paciente_diagnosticos_secundarios ?>
            </div>

            <div style="position: absolute;margin-left: 696px;margin-top: <?php echo $margin_topPacient + 60; ?>px;font-size: 11px; width: 582px;  text-align: center;text-transform: uppercase"><?=$paciente_diagnosticos_secundarios_cie10_id?>
            </div>

            <div style="position: absolute;margin-left: 270px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 11px; width: 350px;"><?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>
            </div>

            <div style="position: absolute;margin-left: <?php echo $marginleft; ?>px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 12px; width: 50px; text-align: center;"> X
            </div>

            <div style="position: absolute;margin-left: 586px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 11px; width: 109px; text-align: center; ">
                <?php echo  str_replace("-", " ", $PUM['pum_nss']);?> 
            </div>
            <div style="position: absolute;margin-left: 700px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 11px; width: 200px; ">
                <?=$PUM['pum_nss_agregado']?>
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
    while($n<count($datos)){
?>
<page backleft="0mm" backright="0mm" backtop="91.5mm">
    <page_header>
       <div style="position: absolute">
            <img src="<?=  $plantilla?>" style="position: absolute;width: 100%">
            
        </div>
    </page_header>
 
    <div style="position: absolute;">
        <?php  

            $l=$n;
            $j=0;
            for (;$n<count($datos) ; $n++ ) { 
                if($n==10+$l) break;

               $value = current($datos);
                next($datos);

                $paciente_diagnostico_primario  ='';
                $paciente_diagnosticos_secundarios  ='';
                //$paciente_diagnostico_primario_cie10_id  ='';
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
                            break;
                case "Naranja": 
                            $triage_color = 2;
                            break;
                case "Amarillo": 
                            $triage_color = 3;
                            break;
                case "Verde": 
                            $triage_color = 4;
                            break;
                case "Azul": 
                            $triage_color = 5;
                            break;
            }

            $triage_id_ = $value['triage_id'];
            $fecha_dx_ =  $value['hf_fg'];

            $sql_Diagnosticos = $this->config_mdl->_query("
                SELECT  paciente_diagnosticos.tipo_diagnostico,
                        paciente_diagnosticos.complemento,
                        um_cie10.cie10_id,
                        um_cie10.cie10_clave,
                        um_cie10.cie10_nombre
                FROM paciente_diagnosticos
                INNER JOIN um_cie10 
                ON paciente_diagnosticos.cie10_id = um_cie10.cie10_id
                AND paciente_diagnosticos.triage_id='$triage_id_'

            ");

            foreach ($sql_Diagnosticos as $value_diagnosticos) { 
                if($value_diagnosticos['tipo_diagnostico']=='1') {
                    $paciente_diagnostico_primario              = $value_diagnosticos['cie10_nombre'];
                    $paciente_diagnostico_primario_cie10_id     = $value_diagnosticos['cie10_clave'];
                }else if($value_diagnosticos['tipo_diagnostico']=='0' ) {
                    $paciente_diagnostico_primario              = $value_diagnosticos['cie10_nombre'];
                    $paciente_diagnostico_primario_cie10_id     = $value_diagnosticos['cie10_clave'];
                }else if($paciente_diagnosticos_secundarios==''){
                    $paciente_diagnosticos_secundarios          = $value_diagnosticos['cie10_nombre'];
                    $paciente_diagnosticos_secundarios_cie10_id = $value_diagnosticos['cie10_clave'];
                }else if($value_diagnosticos['cie10_id'] == 69824){
                    $paciente_diagnostico_primario = $value_diagnosticos['complemento'];
                    $paciente_diagnostico_primario_cie10_id = $value_diagnosticos['cie10_clave'];
                }
               
                      
            }?>

            
                <div style="position: absolute;margin-left: 10px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;text-align: center;"><?=$i?>
                </div>
                <div style="position: absolute;margin-left: 10px;margin-top: <?php echo $margin_topNum - 35; ?>px;font-size: 7px;width: 15px;text-align: center;">
                    <?=$lugarAtencion?>
                </div>
                <div style="position: absolute;margin-left: 25px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 7px;width: 15px;text-align:center;rotate:90;"><?=$value['triage_id']?> 
                </div>
                <div style="position: absolute;margin-left: 38px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90;">
                        <?=$value['triage_horacero_h']?>
                </div>
                 <div style="position: absolute;margin-left: 54px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90; ">
                        <?=$value['triage_hora']?>
                </div>
                <div style="position: absolute; margin-left: 70px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90; ">
                        <?=$value['triage_hora_clasifica']?>
                </div>
                <div style="position: absolute;margin-left: 88px;margin-top: <?php echo $margin_topNum; ?>px;font-size: 10px;width: 15px;rotate:90;">
                    <?php 
                            if(isset($value['ce_he'])) {?> 
                                <?=$value['ce_he']?> 
                    <?php   } else if(isset($value['observacion_he'])){?>
                                <?=$value['observacion_he']?> 
                    <?php   } else {?><?=$value['notas_hora']?> <?php }?> 
                </div>
                <div style="position: absolute;margin-left: 110px;margin-top: <?php echo $margin_topProcedimiento; ?>px;font-size: 9px; width: 200px;">
                        <?php echo $triage_color;?>
                </div>    
                <div style="position: absolute;margin-left: 110px;margin-top: <?php echo $margin_topPacient + 32; ?>px;font-size: 9px; width: 582px;text-transform: uppercase"><?=$paciente_diagnostico_primario?>
                </div>
                <div style="position: absolute;margin-left: 696px;margin-top: <?php echo $margin_topPacient + 32; ?>px;font-size: 9px; width: 57px; text-align: center;"><?= $paciente_diagnostico_primario_cie10_id ?>
                </div>
                <div style="position: absolute;margin-left: 110px;margin-top: <?php echo $margin_topPacient + 57; ?>px;font-size: 9px; width: 582px;text-transform: uppercase"><?= $paciente_diagnosticos_secundarios ?>
                </div>
                <div style="position: absolute;margin-left: 696px;margin-top: <?php echo $margin_topPacient + 57; ?>px;font-size: 9px; width: 57px;  text-align: center;"><?=$paciente_diagnosticos_secundarios_cie10_id?>
                </div>
                <div style="position: absolute;margin-left: 270px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 11px; width: 350px;"><?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>
                </div>
                <div style="position: absolute;margin-left: <?php echo $marginleft; ?>px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 12px; width: 50px; text-align: center;"> X
                </div>
                <div style="position: absolute;margin-left: 586px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 11px; width: 109px; text-align: center; ">
                    <?php echo  str_replace("-", " ", $PUM['pum_nss']);?> 
                </div>
                <div style="position: absolute;margin-left: 700px;margin-top: <?php echo $margin_topPacient; ?>px;font-size: 11px; width: 200px; ">
                    <?=$PUM['pum_nss_agregado']?>
                </div>
                <div style="position: absolute;margin-left: 140px;margin-top: <?php echo $margin_topProcedimiento; ?>px;font-size: 9px; width: 200px;"><?php foreach($value_procedimiento as $value_p => $procedimiento) { echo $procedimiento; echo "&nbsp;&nbsp;&nbsp;";} ?>
                </div>
                <!-- border: 1px solid red; -->
                
        <?php }?>
    </div>
    <page_footer></page_footer>
</page>

 <?php }?>



