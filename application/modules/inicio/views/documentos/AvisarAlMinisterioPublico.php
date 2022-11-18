<?php ob_start(); ?>
<page backtop="80mm" backbottom="35mm" backleft="58" backright="15mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/AMP.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">
        <div style="position: absolute;margin-top: 15px">
            <div style="position: absolute;margin-left: 560px;margin-top:130px;width: 220px;text-transform: uppercase;font-size: 12px;">
                <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
            </div>
            <div style="position: absolute;margin-left: 50px;margin-top: 215px;width: 220px;text-transform: uppercase;font-size: 12px;">
                <?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?>
            </div>
            <div style="position: absolute;margin-left: 355px;margin-top: 215px;width: 80px;text-transform: uppercase;font-size: 12px;">
                <?=$AvisoMp['mp_fecha']?>
            </div>
            <div style="position: absolute;margin-left: 590px;margin-top: 215px;width: 80px;text-transform: uppercase;font-size: 12px;">
                <b><?=$AvisoMp['mp_hora']?></b>
            </div>
            <div style="position: absolute;margin-left: 45px;margin-top: 280px;width: 200px;text-transform: uppercase;font-size: 15px;">
                G.A.M 3 EN TURNO
            </div>
            <div style="position: absolute;margin-left: 320px;margin-top: 423px;width: 400px;text-transform: uppercase;font-size: 13px;">
                <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
            </div>
            <div style="position: absolute;margin-left: 340px;margin-top: 483px;width: 400px;text-transform: uppercase;font-size: 13px;">
                <b>
                    <?php 
                    if($AvisoMp['mp_area']=='Consultorios'){
                        $sqlConsultorio=$this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
                            'triage_id'=>$info['triage_id']
                        ))[0];
                        echo Modules::run('Consultoriosespecialidad/ObtenerServicioConsultorio',array(
                                'Consultorio'=>$sqlConsultorio['ce_asignado_consultorio']
                        ));
                    }if($AvisoMp['mp_area']=='Observacion'){
                        $sqlObs=$this->config_mdl->_query("SELECT * FROM os_observacion, os_areas, os_camas WHERE
                            os_camas.area_id=os_areas.area_id AND
                            os_areas.area_id=os_observacion.observacion_area AND triage_id=".$info['triage_id'])[0];
                        echo $sqlObs['area_nombre'];
                    }if($AvisoMp['mp_area']=='Choque'){
                        
                    }
                    ?>
                </b>
            </div>
            <div style="position: absolute;margin-left: 45px;margin-top: 498px;width: 690px;text-transform: uppercase;font-size: 13px;">
                <b>DOMICILIO:</b> EJE FORTUNA ESQUINA CON INSTITUTO POLITECNICO NACIONAL COLONIA MAGDALENA DE SALINAS DELEGACION GUSTAVO A. MADERO, CP 07760<br>
                <b>TELEFONO: </b>574735000 EXTENSION 25572
            </div>
            <div style="position: absolute;margin-left: 170px;margin-top: 540px;width: 690px;text-transform: uppercase;font-size: 13px;">
                URGENCIAS
            </div>
            <?php if($AvisoMp['mp_area']=='Observacion'){?>
            <div style="position: absolute;margin-left: 530px;margin-top: 540px;width: 690px;text-transform: uppercase;font-size: 13px;">
                <b>EN LA CAMA: </b><?=$sqlObs['cama_nombre']?>
            </div>
            <?php }?>
            <div style="position: absolute;margin-left: 42px;margin-top: 578px;width: 695px;text-transform: uppercase;font-size: 13px;">
                <?php 
                $sqlHojaFrontal=$this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
                    'triage_id'=>$info['triage_id']
                ))[0];
                echo $sqlHojaFrontal['hf_diagnosticos']
                ?>
            </div>
            
            <div style="position: absolute;margin-left: 42px;margin-top: 715px;width: 110px;text-transform: uppercase;font-size: 8px;;text-align: center">
                <?=$Medico['empleado_nombre']?><?=$Medico['empleado_apellidos']?>
            </div>
            <div style="position: absolute;margin-left: 160px;margin-top: 716px;width: 110px;text-transform: uppercase;font-size: 11px;text-align: center">
                <?=$Medico['empleado_matricula']?>
            </div>
            
            <div style="position: absolute;margin-left: 400px;margin-top: 715px;width: 110px;text-transform: uppercase;font-size: 8px;text-align: center">
                <?=$Ts['empleado_nombre']?> <?=$Ts['empleado_apellidos']?>
            </div>
            <div style="position: absolute;margin-left: 525px;margin-top: 716px;width: 110px;text-transform: uppercase;font-size: 10px;text-align: center">
                <?=$Ts['empleado_matricula']?>
            </div>
        </div>   
        
    </page_header>
    <page_footer></page_footer>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->pdf->SetTitle("DOCUMENTO DE AVISO AL MINISTERIO PÚBLICO");
    $pdf->Output('DOCUMENTO DE AVISO AL MINISTERIO PÚBLICO.pdf');
?>