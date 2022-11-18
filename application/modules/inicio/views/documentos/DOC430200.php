<?php ob_start(); ?>
<page backtop="0mm" backbottom="7mm" backleft="0mm" backright="0mm">
    <page_header>
        
    </page_header>
    <div style="margin-top: 20px;">
        <img src="<?=  base_url()?>assets/doc/DOC_430200.png" style="position: absolute;width: 100%;margin-left: -5px;"> 
        <?php
        $sqlPUM=$this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$info['triage_id']
        ))[0];
        ?>
        <div style="position: absolute;margin-top: 168px;margin-left: 227px;font-size: 10px;"><?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?></div>
        <div style="position: absolute;margin-top: 186px;margin-left: 54px;font-size: 10px;">
            FECHA DE ELABORACIÓN<br>
            <?=$doc['doc_fecha']?>
        </div>
        <div style="position: absolute;margin-top: 186px;margin-left: 240px;font-size: 10px;">
            FECHA EN QUE SE PRESENTA EL PACIENTE<br>
            <?=$am['asistentesmedicas_fecha']?>
        </div>
        <div style="position: absolute;margin-top: 200px;margin-left: 486px;font-size: 10px;"><?=$doc['doc_fecha']?></div>
        <div style="position: absolute;margin-top: 256px;margin-left: 53px;font-size: 12px;width: 420px;">
            <?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?>
        </div>
        <div style="position: absolute;margin-top: 255px;margin-left: 486px;font-size: 12px;width: 220px;"><?=$sqlPUM['pum_nss']?> <?=$sqlPUM['pum_nss_agregado']?></div>
        <div style="position: absolute;margin-top: 304px;margin-left: 54px;font-size: 12px;width: 420px;"><?=$doc['doc_servicio_envia']?></div>
        <div style="position: absolute;margin-top: 304px;margin-left: 485px;font-size: 11px;width: 220px;"><?=$doc['doc_servicio_solicitado']?></div>
        <div style="position: absolute;margin-top: 336px;margin-left: 54px;font-size: 10px;width: 650px;"><?=$doc['doc_diagnostico']?></div>
        <div style="position: absolute;margin-top: 400px;margin-left: 50px;font-size: 10px;width: 180px;"><?=$medico['empleado_nombre']?></div>
        <div style="position: absolute;margin-top: 400px;margin-left: 246px;font-size: 10px;width: 225px;"><?=$medico['empleado_matricula']?></div>
        <div style="position: absolute;margin-top: 450px;margin-left: 300px;font-size: 10px;">
            <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
        </div>
        <br><br>
        <hr style="position: absolute;border: 1px dashed black;margin-top: 510px" >
    </div>
    
    <div style="margin-top: 500px;position: absolute">
        <img src="<?=  base_url()?>assets/doc/DOC_430200.png" style="position: absolute;width: 100%;margin-left: -5px;"> 
        <div style="position: absolute;margin-top: 168px;margin-left: 227px;font-size: 10px;"><?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?></div>
        <div style="position: absolute;margin-top: 186px;margin-left: 54px;font-size: 10px;">
            FECHA DE ELABORACIÓN<br>
            <?=$doc['doc_fecha']?>
        </div>
        <div style="position: absolute;margin-top: 186px;margin-left: 240px;font-size: 10px;">
            FECHA EN QUE SE PRESENTA EL PACIENTE<br>
            <?=$am['asistentesmedicas_fecha']?>
        </div>
        <div style="position: absolute;margin-top: 200px;margin-left: 486px;font-size: 10px;"><?=$doc['doc_fecha']?></div>
        <div style="position: absolute;margin-top: 256px;margin-left: 53px;font-size: 12px;width: 420px;">
            <?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?>
        </div>
        <div style="position: absolute;margin-top: 255px;margin-left: 486px;font-size: 12px;width: 220px;"><?=$sqlPUM['pum_nss']?> <?=$sqlPUM['pum_nss_agregado']?></div>
        <div style="position: absolute;margin-top: 304px;margin-left: 54px;font-size: 12px;width: 420px;"><?=$doc['doc_servicio_envia']?></div>
        <div style="position: absolute;margin-top: 304px;margin-left: 485px;font-size: 11px;width: 220px;"><?=$doc['doc_servicio_solicitado']?></div>
        <div style="position: absolute;margin-top: 336px;margin-left: 54px;font-size: 10px;width: 650px;"><?=$doc['doc_diagnostico']?></div>
        <div style="position: absolute;margin-top: 400px;margin-left: 50px;font-size: 10px;width: 180px;"><?=$medico['empleado_nombre']?></div>
        <div style="position: absolute;margin-top: 400px;margin-left: 246px;font-size: 10px;width: 225px;"><?=$medico['empleado_matricula']?></div>
        <div style="position: absolute;margin-top: 450px;margin-left: 300px;font-size: 10px;">
            <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
        </div>
    </div>
    <page_footer>
        <div style="margin-left: 280px;">
            
        </div>
        <div style="text-align:right">
            Página [[page_cu]]/[[page_nb]]
        </div>
    </page_footer>

        
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    //$pdf->pdf->IncludeJS("print(true);");
    $pdf->pdf->SetTitle('SOLICITUD DE SERVICIOS (INTERCONSULTA) 4 30 200');
    $pdf->Output('SOLICITUD DE SERVICIOS (INTERCONSULTA) 4 30 200.pdf');
?>