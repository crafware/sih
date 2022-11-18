<?php ob_start(); ?>
<page backleft="12.5mm" backright="15mm" backtop="65mm" backbottom="5mm">
    <page_header>
        <div style="position: absolute">
            <img src="<?=  base_url()?>assets/doc/JAM_43029_IE.png" style="position: absolute;width: 100%;">
            <div style="position: absolute;margin-left: 136px;margin-top: 175px;font-size: 11px">UMAE HOSPITAL DE ESPECIALIDADES DEL CMN SIGLO XXI "DR. BERNARDO SEPÚLVEDA GUTIERREZ"</div>
            <div style="position: absolute;margin-left: 840px;margin-top: 174px;font-size: 11px">: [[page_cu]]/[[page_nb]]</div>
            <div style="position: absolute;margin-left: 956px;margin-top: 174px;font-size: 9px">: <?= str_replace('-', '/', $_GET['fecha_inicio'])?> <br/> 
			<!--<p style="position: absolute;margin-left:-5px;margin-top: 9px">al <?= str_replace('-', '/', $_GET['fecha_fin'])?></p> -->
			 </div>
        </div>
    </page_header>
    <div style="position: absolute;">

        <style>
            table{border: 1px solid black; }
            td, th {border: 1px solid black; }
            table {border-collapse: collapse;width: 100%;}
            td {vertical-align: bottom;}
        </style>
        <table style="width: 100%;margin-top: -1px;margin-left: 0px">
            <tbody>
                <?php foreach ($Gestion as $value) {?>
                <?php
                $sqlPUM=$this->config_mdl->_get_data_condition('paciente_info',array(
                    'triage_id'=>$value['triage_id']
                ))[0];
                ?>
                <tr style="width: 949px">
                    <td style="width: 6%;font-size: 8px"><span class="es inline-block"><?=$value['triage_id']?></span></td>
                    <td style="width: 9.5%;font-size: 9px;text-transform: uppercase"><?=$sqlPUM['pum_nss']?> <?=$sqlPUM['pum_nss_agregado']?></td>
                    <td style="width: 17.1%;font-size: 8px;text-transform: uppercase"><?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?> <?=$value['triage_nombre']?></td>
                    <td style="width: 5.6%;font-size: 9px">
                        <?=$value['asistentesmedicas_hora']?>
                    </td>
                    <td style="width: 6.6%;font-size: 9px"><?=$sqlPUM['pum_umf']?></td>
                    <td style="width: 4.8%;font-size: 8px"><?=$sqlPUM['pia_procedencia_hospital']?>&nbsp;<?=$sqlPUM['pia_procedencia_hospital_num']?></td>
                    <td style="width: 5.85%;font-size: 9px"><?=$sqlPUM['pum_delegacion']?></td>
                    <td style="width: 6.2%;font-size: 9px"><?=$sqlPUM['pia_procedencia_espontanea']?></td>
                    <td style="width: 8.05%;font-size: 9px"><?php if($sqlPUM['pia_vigencia']=='No')
                        echo '&nbsp;&nbsp;&nbsp;X'; ?></td>                               
                    
                    <td style="width: 13.86%;font-size: 9px">
                        <!-- <?php 
                        $sqlDiagnostico=$this->config_mdl->_query("SELECT hf_diagnosticos_lechaga, hf_hg, hf_fg FROM os_consultorios_especialidad_hf WHERE triage_id=".$value['triage_id']);
                        ?> -->
                        <?php 
                            $sqlConsultorio=$this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
                                'triage_id'=>$value['triage_id']
                            ))[0];
                            echo $sqlConsultorio['ce_hf'];
                        ?>
                        <?php 
                        if(!empty($sqlDiagnostico)){
                            $Tiempo= Modules::run('Config/CalcularTiempoTranscurrido',array(
                                'Tiempo1'=>$value['asistentesmedicas_fecha'].' '.$value['asistentesmedicas_hora'],
                                'Tiempo2'=>$sqlDiagnostico[0]['hf_fg'].' '.$sqlDiagnostico[0]['hf_hg']
                            ));
                            echo '<br>T.T: '.$Tiempo->h.' Horas '.$Tiempo->i.' Minutos';
                        }else{
                            $Tiempo= Modules::run('Config/CalcularTiempoTranscurrido',array(
                                'Tiempo1'=>$value['asistentesmedicas_fecha'].' '.$value['asistentesmedicas_hora'],
                                'Tiempo2'=> date('Y-m-d').' '. date('H:i:s') 
                            ));
                            if($Tiempo->d>0 || $Tiempo->h>6){
                                echo '<br><span style="color:red">Posible abandono</span>';
                            }
                        }
                        ?>
                    </td>
                    <td style="width: 4%;font-size: 9px">
                        
                        <?=$sqlDiagnostico[0]['hf_hg']?>
                        
                        
                    </td>
                    <td style="width: 16.5%;font-size: 9px">
                        <!-- <?=$sqlDiagnostico[0]['hf_diagnosticos_lechaga']?> -->
                    </td>
                </tr>
                <?php }?>
                <?php foreach ($Gestion2 as $value) {?>
                <?php
                $sqlPUM=$this->config_mdl->_get_data_condition('paciente_info',array(
                    'triage_id'=>$value['triage_id']
                ))[0];
                ?>
                <tr style="width: 949px">
                    <td style="width: 6%;font-size: 8px"><span class="es inline-block"><?=$value['triage_id']?></span></td>
                    <td style="width: 9.5%;font-size: 9px;text-transform: uppercase"><?=$sqlPUM['pum_nss']?> <?=$sqlPUM['pum_nss_agregado']?></td>
                    <td style="width: 17.1%;font-size: 8px;text-transform: uppercase"><?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?> <?=$value['triage_nombre']?></td>
                    <td style="width: 5.6%;font-size: 9px">
                        <?=$value['asistentesmedicas_hora']?>
                    </td>
                    <td style="width: 6.6%;font-size: 9px"><?=$sqlPUM['pum_umf']?></td>
                    <td style="width: 4.8%;font-size: 8px"><?=$sqlPUM['pia_procedencia_hospital']?>&nbsp;<?=$sqlPUM['pia_procedencia_hospital_num']?></td>
                    <td style="width: 5.85%;font-size: 9px"><?=$sqlPUM['pum_delegacion']?></td>
                    <td style="width: 6.2%;font-size: 9px"><?=$sqlPUM['pia_procedencia_espontanea']?></td>
                    <td style="width: 8.05%;font-size: 9px"><?php if($sqlPUM['pia_vigencia']==No)
                        echo 'x'; ?></td>                               
                    
                    
                    <td style="width: 13.86%;font-size: 9px">
                        <!-- <?php 
                        $sqlDiagnostico=$this->config_mdl->_query("SELECT hf_diagnosticos_lechaga, hf_hg, hf_fg FROM os_consultorios_especialidad_hf WHERE triage_id=".$value['triage_id']);
                        ?> -->
                        <?php 
                            $sqlConsultorio=$this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
                                'triage_id'=>$value['triage_id']
                            ))[0];
                            echo $sqlConsultorio['ce_hf']
                        ?>
                        <?php 
                        if(!empty($sqlDiagnostico)){
                            $Tiempo= Modules::run('Config/CalcularTiempoTranscurrido',array(
                                'Tiempo1'=>$value['asistentesmedicas_fecha'].' '.$value['asistentesmedicas_hora'],
                                'Tiempo2'=>$sqlDiagnostico[0]['hf_fg'].' '.$sqlDiagnostico[0]['hf_hg']
                            ));
                            echo '<br>T.T: '.$Tiempo->h.' Horas '.$Tiempo->i.' Minutos';
                        }else{
                            $Tiempo= Modules::run('Config/CalcularTiempoTranscurrido',array(
                                'Tiempo1'=>$value['asistentesmedicas_fecha'].' '.$value['asistentesmedicas_hora'],
                                'Tiempo2'=> date('Y-m-d').' '. date('H:i:s') 
                            ));
                            if($Tiempo->d>0 || $Tiempo->h>6){
                                echo '<br><span style="color:red">Posible abandono</span>';
                            }
                        }
                        ?>
                    </td>
                    <td style="width: 4%;font-size: 9px">
                        
                        <?=$sqlDiagnostico[0]['hf_hg']?>
                        
                        
                    </td>
                    <td style="width: 16.5%;font-size: 9px">
                        <!-- <?=$sqlDiagnostico[0]['hf_diagnosticos_lechaga']?> -->
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
        
        
    </div>
    <page_footer>
        <table style="width: 100%;border:0px solid transparent!important;margin-left: 21px">
            <tr style="border:0px solid transparent!important">
                <td style="width: 45%;text-align: right;border:0px solid transparent!important">[[page_cu]]/[[page_nb]]</td>
                <td style="width: 49%;text-align: right;border:0px solid transparent!important">Clave 2430 003 040</td>
            </tr>
        </table>
    </page_footer>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('L','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->SetTitle('CONSULTAS, VISITAS Y CURACIONES 4-30-29/72');
    //$pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('CONSULTAS, VISITAS Y CURACIONES 4-30-29/72.pdf');
?>