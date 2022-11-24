<?php ob_start(); ?>
<page backtop="0mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <div style="position: relative">
        <img src="<?=  base_url()?>assets/doc/2430-021-72.png" style="position: absolute;width: 100%;margin-top: 32px;margin-left: -5px;">
        <div style="position: absolute;top: 210px;left: 42px;font-size: 12px;width:350px;">
            UMAE HOSPITAL DE ESPECIALIDADES DEL CMN SIGLO XXI
        </div>
        <div style="position: absolute;top: 210px;left: 420px;font-size: 12px;width:350px;">
            <?=date("d-m-Y H:i", strtotime($internamiento['fecha_ingreso']))?> hrs.
        </div>
        <div style="position: absolute;top: 245px;left: 42px;font-size: 12px;width:338px;">
            <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
        </div>
        <div style="position: absolute;top: 245px;left: 420px;font-size: 12px;width:170px;">
           <?=$PINFO['pum_nss']?> - <?=$PINFO['pum_nss_agregado']?>
        </div>
        <div style="position: absolute;top: 278px;left: 200px;text-transform: uppercase;font-size: 10px">
            <?=$ingreso_servicio['especialidad_nombre']?>
        </div>
        <div style="position: absolute;top: 313px;left: 40px;text-transform: uppercase;font-size: 10px">
            <?=$internamiento['motivo_internamiento']?>
        </div>
        <div style="position: absolute;top: 344px;left: 40px;width: 530px;text-transform: uppercase;font-size: 10px">
            <?=$diagnostico_ingreso['cie10_nombre']?>
        </div>
        <div class="text-uppercase" style="position: absolute;top: 440px;left: 40px;font-size: 10px">
            <?=$medico_tratante['empleado_apellidos']?> <?=$medico_tratante['empleado_nombre']?> (Mat. <?=$medico_tratante['empleado_matricula']?>)
        </div>
        
        <div style="position: absolute;top: 477px;left: 250px">
            <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
        </div>
    </div>
    <div style="position: relative;margin-top: 20px">
        <img src="<?=  base_url()?>assets/doc/2430-021-72.png" style="position: absolute;width: 100%;margin-top: 32px;margin-left: -5px;">
        <div style="position: absolute;top: 210px;left: 42px;font-size: 12px;width:350px;">
            UMAE HOSPITAL DE ESPECIALIDADES DEL CMN SIGLO XXI
        </div>
        <div style="position: absolute;top: 210px;left: 420px;font-size: 12px;width:350px;">
            <?=$internamiento['fecha_registro']?> hrs.
        </div>
        <div style="position: absolute;top: 245px;left: 42px;font-size: 12px;width:338px;">
            <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
        </div>
        <div style="position: absolute;top: 245px;left: 420px;font-size: 12px;width:180px;">
           <?=$PINFO['pum_nss']?> <?=$PINFO['pum_nss_agregado']?>
        </div>
        <div style="position: absolute;top: 278px;left: 200px;text-transform: uppercase;font-size: 10px">
            <?=$ingreso_servicio['especialidad_nombre']?>
        </div>
        <div style="position: absolute;top: 313px;left: 40px;text-transform: uppercase;font-size: 10px">
            <?=$internamiento['motivo_internamiento']?>
        </div>
        <div style="position: absolute;top: 344px;left: 40px;width: 530px;text-transform: uppercase;font-size: 10px">
            <?=$diagnostico_ingreso['cie10_nombre']?>
        </div>
        <div class="text-uppercase" style="position: absolute;top: 440px;left: 40px;font-size: 10px">
            <?=$medico_tratante['empleado_apellidos']?> <?=$medico_tratante['empleado_nombre']?> (Mat. <?=$medico_tratante['empleado_matricula']?>)
        </div>
        
        <div style="position: absolute;top: 477px;left: 250px">
            <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
        </div>
    </div>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    //$pdf->pdf->IncludeJS("print(true);");
    $pdf->pdf->SetTitle('4-30-51');
    $pdf->Output('DOC_2430_21.pdf');
?>