<?php ob_start(); ?>
<page backleft="0mm" backright="0mm" backtop="91.5mm">
    <page_header>
        <div style="position: absolute">
            <img src="<?=  base_url()?>assets/doc/430_006.png" style="position: absolute;width: 100%">
            <div style="position: absolute;margin-left: 20px;margin-top: 70px;font-size: 10px"><?=$this->UM_CLASIFICACION?> <?=$this->UM_NOMBRE?></div>
            <div style="position: absolute;margin-left: 227px;margin-top: 80px;font-size: 12px"><?=  date('d/m/Y')?></div>
            <div style="position: absolute;margin-left: 310px;margin-top: 80px;font-size: 12px"><?=  $medico['empleado_matricula']?></div>
            <div style="position: absolute;margin-left: 400px;margin-top: 83px;font-size: 8px">a</div>
            <div style="position: absolute;margin-left: 500px;margin-top: 83px;font-size: 8px"><?=$servicio['clave']?></div>
            <div style="position: absolute;margin-left: 650px;margin-top: 83px;font-size: 12px"><?= Modules::run('Config/ObtenerTurno')?></div>
            <div style="position: absolute;margin-left: 140px;margin-top: 115px;font-size: 14px">37B5091C2153</div>
            <div style="position: absolute;margin-left: 440px;margin-top: 115px;font-size: 14px;"><?=$medico['empleado_nombre']?> <?=$medico['empleado_apellidos']?></div>
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
                1200
            </div>
            <div style="position: absolute;margin-left: 530px;margin-top: 81px;font-size: 6px;width: 45px;text-align: center">
                <?=$_SESSION['UMAE_AREA']?>ssssssssssssss
            </div> 
        </div>
    </page_header>
    <div style="position: absolute;">
        <style>
            table{border: 1px solid black; }
            td, th { border: 1px solid black; }
            
            table {border-collapse: collapse;width: 100%;}
            td {vertical-align: central;}
        </style>
        <?php $i=0; foreach ($HojasFrontales as $value) { $i++;?>
        <?php
        $sqlCe=$this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=>$value['triage_id']
        ))
        ?>
        <table style="width: 800px;margin-left: 7px;font-size: 5.8px;margin-top: 53px;" border="0">
            <tr >
                <td style="width: 3.2%;padding: 1px;border:0px!important;margin-top: 15px" rowspan="11" >
                    <?=$i?>
                </td>
<!-- <td style="width: 6.1%;padding: 2px 1px 1px 1px;text-align: center" >HORA DE LA<br>CITA</td> -->                
                <td style="width: 2.15%;padding: 5px;">1</td>
                <td style="width: 2.15%;padding: 5px">2</td>
                <td style="width: 2.20%;padding: 5px">3</td>
                <td style="width: 2.20%;padding: 5px">4</td>
                <td style="width: 2.20%;padding: 5px">5</td>
                <td style="width: 2.20%;padding: 5px">6</td>
                <td style="width: 2.20%;padding: 5px">7</td>
                <td style="width: 2.20%;padding: 5px">8</td>
                <td style="width: 2.28%;padding: 5px">9</td>
                <td style="width: 2.20%;padding: 5px 3px 5px 3px">10</td>
                <td style="width: 2.30%;padding: 5px 3px 5px 3px">11</td>
                <td style="width: 2.10%;padding: 5px 3px 5px 3px">12</td>
                <td style="width: 57%;padding: 5px;border-left: 2px solid transparent;font-size: 10px" colspan="9">
                    <?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>
                </td>
            </tr>
            <tr style="border:0px !important">
                <!-- <td style="width: 7.8%;padding: 5px 1px 1px 1px;border-left: 2px solid transparent" rowspan="3" ></td> -->
                <td style="width: 2.15%;padding: 5px;">x</td>
                <td style="width: 2.15%;padding: 5px">
                    <?php 
                    $sql430200=$this->config_mdl->_get_data_condition('doc_430200',array(
                        'triage_id'=>$value['triage_id']
                    ));
                    ?>
                    <?=!empty($sql430200) ? 'x' :''?>
                </td>
                <td style="width: 2.20%;padding: 5px"></td>
                <td style="width: 2.20%;padding: 5px"></td>
                <td style="width: 2.20%;padding: 5px">
                    <?=$sqlCe[0]['ce_status']=='Salida' ? 'X' : ''?>
                </td>
                <td style="width: 2.20%;padding: 5px"></td>
                <td style="width: 2.20%;padding: 5px">
                    <?php 
                    $sqlAm=$this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
                        'triage_id'=>$value['triage_id']
                    ))[0]
                    ?>
                    <?=$sqlAm['asistentesmedicas_incapacidad_ga']=='Si' ? 'x' : ''?>
                </td>
                <td style="width: 2.20%;padding: 5px"></td>
                <td style="width: 2.28%;padding: 5px">
                    <?php 
                    $sqlST7=$this->config_mdl->_get_data_condition('paciente_info',array(
                        'triage_id'=>$value['triage_id']
                    ));
                    ?>
                    <?=$sqlST7[0]['pia_lugar_accidente']=='TRABAJO' ? 'X' : ''?>
                </td>
                <td style="width: 2.20%;padding: 5px 3px 5px 3px"></td>
                <td style="width: 2.30%;padding: 5px 3px 5px 3px"></td>
                <td style="width: 2.10%;padding: 5px 3px 5px 3px"></td>
                <td style="width: 25%;padding:3px 3px 3px 5px ;font-size: 10px">
                    <?php 
                    $PUM=$this->config_mdl->_get_data_condition('paciente_info',array(
                        'triage_id'=>$value['triage_id']
                    ))[0];
                    ?>
                    <?=$PUM['pum_nss']?>
                </td>
                <td style="width: 1.15%;font-size: 10px" colspan="8">
                    <?=$PUM['pum_nss_agregado']?>
                </td>
            </tr>
            <tr>
                <td style="width: 2.15%;padding: 5px;">1</td>
                <td style="width: 42%;padding: 5px 3px 2px 3px;border-left: 2px solid transparent;font-size: 8px;text-transform: uppercase" colspan="16" rowspan="2">
                    <b>Hoja Frontal</b><br>
                    <?= substr($value['hf_diagnosticos'], 0,200)?>
                </td>
                <td style="width: 1.15%;padding-top: 4px;text-align: center;font-size:8px " colspan="4"><?=$value['triage_color']?></td>
            </tr>
            <tr>
                <td style="width: 2.15%;padding: 5px;"></td>
                <td style="width: 1.15%"></td>
                <td style="width: 1.15%"></td>
                <td style="width: 1.15%"></td>
                <td style="width: 1.15%"></td>
            </tr>
            <tr>
                <!-- <td style="padding: 5px;text-align: center;border-left: 2px solid transparent" rowspan="2">INICIO<br> DE ATENCIÓN</td> -->
                <td style=""></td>
                <td style=";border-left: 2px solid transparent" colspan="16" rowspan="2"></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
                <td style="padding: 5px;text-align: center;border-left: 2px solid transparent" rowspan="2">
                    <?=$sqlCe[0]['ce_fe']?>  <?=$sqlCe[0]['ce_he']?>
                </td>
                <td style=""></td>
                <td style=";border-left: 2px solid transparent" colspan="16" rowspan="2"></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
                <!-- <td style=";padding: 5px;text-align: center;border-left: 2px solid transparent" >FIN DE LA<br> ATENCIÓN</td> -->
                <td style="padding: 5px;border-left: 2px solid transparent" colspan="17" ></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
               
                <td style="padding: 5px;border-left: 2px solid transparent" colspan="17" ></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
                <td style="padding: 5px;border-left: 2px solid transparent" colspan="17" ></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
        </table>
        <?php }?>
        <?php foreach ($Notas as $value_n) { $i++;?>
        <?php
        $sqlCe=$this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=>$value_n['triage_id']
        ))
        ?>
        <table style="width: 700px;margin-left: 48px;font-size: 5.8px;margin-top: 5px;" border="0">
            <tr >
                <td style="width: 2.5%;padding: 1px;border:0px!important;margin-top: 15px" rowspan="11" >
                    <?=$i?>
                </td>
                <td style="width: 6.1%;padding: 2px 1px 1px 1px;text-align: center" >HORA DE LA<br>CITA</td>
                <td style="width: 2.15%;padding: 5px;">1</td>
                <td style="width: 2.15%;padding: 5px">2</td>
                <td style="width: 2.20%;padding: 5px">3</td>
                <td style="width: 2.20%;padding: 5px">4</td>
                <td style="width: 2.20%;padding: 5px">5</td>
                <td style="width: 2.20%;padding: 5px">6</td>
                <td style="width: 2.20%;padding: 5px">7</td>
                <td style="width: 2.20%;padding: 5px">8</td>
                <td style="width: 2.28%;padding: 5px">9</td>
                <td style="width: 2.20%;padding: 5px 3px 5px 3px">10</td>
                <td style="width: 2.30%;padding: 5px 3px 5px 3px">11</td>
                <td style="width: 2.10%;padding: 5px 3px 5px 3px">12</td>
                <td style="width: 57%;padding: 5px;border-left: 2px solid transparent;font-size: 10px" colspan="9">
                    <?=$value_n['triage_nombre']?> <?=$value_n['triage_nombre_ap']?> <?=$value_n['triage_nombre_am']?>
                </td>
            </tr>
            <tr style="border:0px !important">
                <td style="width: 7.8%;padding: 5px 1px 1px 1px;border-left: 2px solid transparent" rowspan="3" ></td>
                <td style="width: 2.15%;padding: 5px;">x</td>
                <td style="width: 2.15%;padding: 5px">
                    <?php 
                    $sql430200=$this->config_mdl->_get_data_condition('doc_430200',array(
                        'triage_id'=>$value_n['triage_id']
                    ));
                    ?>
                    <?=!empty($sql430200) ? 'x' :''?>
                </td>
                <td style="width: 2.20%;padding: 5px"></td>
                <td style="width: 2.20%;padding: 5px"></td>
                <td style="width: 2.20%;padding: 5px">
                </td>
                <td style="width: 2.20%;padding: 5px"></td>
                <td style="width: 2.20%;padding: 5px"></td>
                <td style="width: 2.20%;padding: 5px"></td>
                <td style="width: 2.28%;padding: 5px">

                </td>
                <td style="width: 2.20%;padding: 5px 3px 5px 3px"></td>
                <td style="width: 2.30%;padding: 5px 3px 5px 3px"></td>
                <td style="width: 2.10%;padding: 5px 3px 5px 3px"></td>
                <td style="width: 25%;padding:3px 3px 3px 5px;font-size: 10px ">
                    <?php 
                    $PUM=$this->config_mdl->_get_data_condition('paciente_info',array(
                        'triage_id'=>$value_n['triage_id']
                    ))[0];
                    ?>
                    <?=$PUM['pum_nss']?>
                </td>
                <td style="width: 1.15%;font-size: 10px" colspan="8">
                    <?=$PUM['pum_nss_agregado']?>
                </td>
            </tr>
            <tr>
                <td style="width: 2.15%;padding: 5px;">1</td>
                <td style="width: 42%;padding: 5px 3px 2px 3px;border-left: 2px solid transparent;font-size: 8px;text-transform: uppercase" colspan="16" rowspan="2">
                    <?php 
                    $sqlNota=$this->config_mdl->_get_data_condition('doc_nota',array(
                       'notas_id'=>$value_n['notas_id'] 
                    ));
                    ?>
                    <b><?=$value_n['notas_tipo']?></b><br>
                    <?= substr($sqlNota[0]['nota_diagnostico'], 0,200)?>
                </td>
                <td style="width: 1.15%;padding-top: 4px;text-align: center;font-size:8px " colspan="4"><?=$value_n['triage_color']?></td>
            </tr>
            <tr>
                <td style="width: 2.15%;padding: 5px;"></td>
                <td style="width: 1.15%"></td>
                <td style="width: 1.15%"></td>
                <td style="width: 1.15%"></td>
                <td style="width: 1.15%"></td>
            </tr>
            <tr>
                <td style="padding: 5px;text-align: center;border-left: 2px solid transparent" rowspan="2">INICIO<br> DE ATENCIÓN</td>
                <td style=""></td>
                <td style=";border-left: 2px solid transparent" colspan="16" rowspan="2"></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
                <td style="padding: 5px;text-align: center;border-left: 2px solid transparent" rowspan="2">
                    <?=$value_n['notas_fecha']?>  <?=$value_n['notas_hora']?>
                </td>
                <td style=""></td>
                <td style=";border-left: 2px solid transparent" colspan="16" rowspan="2"></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
                <td style=";padding: 5px;text-align: center;border-left: 2px solid transparent" >FIN DE LA<br> ATENCIÓN</td>
                <td style="padding: 5px;border-left: 2px solid transparent" colspan="17" ></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
                <td style="padding: 5px;text-align: center;border-left: 2px solid transparent" rowspan="2">
                    
                    <?=$sqlCe[0]['ce_fs']?> <?=$sqlCe[0]['ce_hs']?>
                </td>
                <td style="padding: 5px;border-left: 2px solid transparent" colspan="17" ></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
            <tr>
                <td style="padding: 5px;border-left: 2px solid transparent" colspan="17" ></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
            </tr>
        </table>
        <?php }?>
    </div>
    <page_footer></page_footer>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->SetTitle('DOCUMENTO 4.30.6 CONSULTORIOS');
    //$pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('DOCUMENTO 4.30.6 CONSULTORIOS.pdf');
?>