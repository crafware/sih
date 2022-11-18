<?php ob_start(); ?>
<page backleft="6.7mm" backright="7mm" backtop="71mm" backbottom="15mm">
    <page_header>
        <div style="position: absolute;">
            <img src="<?=  base_url()?>assets/doc/JAM_43021_I.png" style="position: absolute;width: 100%">
            <div style="position: absolute;margin-left: 136px;margin-top: 188px;font-size: 11px"><?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?></div>
            <div style="position: absolute;margin-left: 897px;margin-top: 191px;font-size: 11px">: [[page_cu]]/[[page_nb]]</div>
            <div style="position: absolute;margin-left: 976px;margin-top: 188px;font-size: 9px"><?= str_replace('-', '/', $_GET['fecha_inicio'])?> <br/> <p style="position: absolute;margin-left:-5px;margin-top: 9px">al <?= str_replace('-', '/', $_GET['fecha_fin'])?></p></div>
        </div>
    </page_header>
    <div style="position: absolute;">
        <style>
            table{border: 1px solid black; }
            td, th {border: 1px solid black; }
            table {border-collapse: collapse;width: 100%;}
            td {vertical-align: bottom;}
            .th_1{padding: 5px 2px 15px 2px;text-align: center}
            .th_2{padding: 5px 5px 15px 5px;}
        </style>
        <table style="width: 960px;margin-top: -1px;">
            <tbody>
                <?php foreach ($Gestion as $value) {?>
                <?php
                $sqlPUM=$this->config_mdl->_get_data_condition('paciente_info',array(
                    'triage_id'=>$value['triage_id']
                ))[0];
                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$value['triage_fecha_nac'])); 
                ?>
                <tr style="width: 100%">
                    <td style="width: 10.3%;font-size: 10px"><?=$sqlPUM['pum_nss']?></td>
                    <td style="width: 7.0%;font-size: 10px"><?=$sqlPUM['pum_nss_agregado']?></td>
                    <td style="width: 28.7%;font-size: 10px"><?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?> <?=$value['triage_nombre']?></td>
                    <td style="width: 5.33%;font-size: 10px"><?=$fecha->y==0 ? $fecha->m.' Meses':$fecha->y.' Años'?></td>
                    
                    <td style="width: 4.2%;font-size: 9px">UMF</td>
                    <td style="width: 3.55%;font-size: 9px"><?=$sqlPUM['pum_umf']?></td>
                    <td style="width: 5.1%;font-size: 9px"><?=$sqlPUM['pum_delegacion']?></td>
                    <td style="width: 4.1%;font-size: 9px">
                        <?php 
                        if($value['doc_destino']=='Choque'){
                            $Obs=$this->config_mdl->_query("SELECT * FROM os_choque_v2, os_camas WHERE os_camas.cama_id=os_choque_v2.cama_id AND
                            os_choque_v2.triage_id=".$value['triage_id'])[0];
                            echo $Obs['choque_ac_h'];
                        }else{
                            $Obs=$this->config_mdl->_query("SELECT * FROM os_observacion, os_camas WHERE os_camas.cama_id=os_observacion.observacion_cama AND
                            os_observacion.triage_id=".$value['triage_id'])[0];
                            echo $Obs['observacion_hac'];
                        }
                        ?>
                    </td>
                    <td style="width: 7.3%;font-size: 9px"><?=$Obs['cama_nombre']?></td>
                    <td style="width: 10.3%;font-size: 9px">
                        <?php 
                            $sqlHojaFrontal=$this->config_mdl->_query("SELECT empleado_matricula FROM os_empleados, os_consultorios_especialidad_hf
                                WHERE os_empleados.empleado_id=os_consultorios_especialidad_hf.empleado_id AND
                                os_consultorios_especialidad_hf.triage_id=".$value['triage_id']);
                            if(!empty($sqlHojaFrontal)){
                                echo $sqlHojaFrontal[0]['empleado_matricula'];
                            }else{
                                $sqlMedicoTriage=$this->config_mdl->_query("SELECT empleado_matricula FROM os_empleados, os_triage
                                    WHERE os_empleados.empleado_id=os_triage.triage_crea_medico AND
                                    os_triage.triage_id=".$value['triage_id']);
                                echo $sqlMedicoTriage[0]['empleado_matricula'];
                            }
                            
                        ?>
                    </td>
                    <td style="width: 21.4%;font-size: 9px">
                        <?=$value['doc_destino']=='Choque' ? 'Choque': 'Observación'?>
                    </td>
                </tr>
                <?php }?>
                <?php foreach ($Gestion2 as $value) {?>
                <?php
                $sqlPUM=$this->config_mdl->_get_data_condition('paciente_info',array(
                    'triage_id'=>$value['triage_id']
                ))[0];
                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$value['triage_fecha_nac'])); 
                ?>
                <tr style="width: 100%">
                    <td style="width: 10.3%;font-size: 9px"><?=$sqlPUM['pum_nss']?></td>
                    <td style="width: 7.0%;font-size: 9px"><?=$sqlPUM['pum_nss_agregado']?></td>
                    <td style="width: 28.7%;font-size: 9px"><?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?> <?=$value['triage_nombre']?></td>
                    <td style="width: 5.33%;font-size: 9px"><?=$fecha->y==0 ? $fecha->m.' Meses':$fecha->y.' Años'?></td>
                    
                    <td style="width: 4.2%;font-size: 9px"><?=$sqlPUM['pia_procedencia_hospital']?></td>
                    <td style="width: 3.55%;font-size: 9px"><?=$sqlPUM['pia_procedencia_hospital_num']?></td>
                    <td style="width: 5.1.2%;font-size: 9px"><?=$sqlPUM['pum_delegacion']?></td>
                    <td style="width: 4.1%;font-size: 9px">
                        <?php 
                        if($value['doc_destino']=='Choque'){
                            $Obs=$this->config_mdl->_query("SELECT * FROM os_choque_v2, os_camas WHERE os_camas.cama_id=os_choque_v2.cama_id AND
                            os_choque_v2.triage_id=".$value['triage_id'])[0];
                            echo $Obs['choque_ac_h'];
                        }else{
                            $Obs=$this->config_mdl->_query("SELECT * FROM os_observacion, os_camas WHERE os_camas.cama_id=os_observacion.observacion_cama AND
                            os_observacion.triage_id=".$value['triage_id'])[0];
                            echo $Obs['observacion_hac'];
                        }
                        ?>
                    </td>
                    <td style="width: 7.3%;font-size: 9px"><?=$Obs['cama_nombre']?></td>
                    <td style="width: 10.3%;font-size: 9px"></td>
                    <td style="width: 21.4%;font-size: 9px">
                        <?=$value['doc_destino']=='Choque' ? 'Choque': 'Observación'?>
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
    $pdf->pdf->SetTitle('Ingresos Registros 4-30-21/35/90 I');
    //$pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('Ingresos Registros 4-30-21/35/90 I.pdf');
?>