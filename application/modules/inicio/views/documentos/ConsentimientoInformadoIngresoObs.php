<?php ob_start(); ?>
<page backtop="85mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/CONSENTIMIENTO_INFORMADO.png" style="position: absolute;width: 100%;margin-top: 0px;margin-left: -5px;">
        <div style="position: absolute;margin-top: 15px">
            <div style="position: absolute;top: 184px;left: 450px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
            </div>
            <div style="position: absolute;top: 218px;left: 480px;font-size: 12px;text-transform: uppercase;width: 160px;">
                <?php
                $sqlPUM=$this->config_mdl->_get_data_condition('paciente_info',array(
                    'triage_id'=>$info['triage_id']
                ))[0];
                ?>
                
                <b>&nbsp;<?=$sqlPUM['pum_nss']?>-<?=$sqlPUM['pum_nss_agregado']?></b>
            </div>
            <div style="position: absolute;top: 233px;left: 440px;font-size: 12px;text-transform: uppercase;">
                <b><?=$info['triage_paciente_sexo']?></b>
            </div>            
            <div style="position: absolute;top: 233px;left: 580px;font-size: 12px;text-transform: uppercase;">
              <?php 
                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));?>
                <b><?=$fecha->y?> AÑOS</b>
            </div>
            <div style="position: absolute;top: 250px;left: 487px;font-size: 12px;">
              <b>CD MX a <?=$hojafrontal['hf_fg']?></b>
            </div>
            <div style="position: absolute;top: 307px;left: 120px;font-size: 11px;text-transform: uppercase;">
                <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
            </div>
            <div style="position: absolute;top: 780px;left: 145px;font-size: 11px;text-transform: uppercase;">
                <?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?>
            </div>
            <div style="position: absolute;top: 605px;left: 145px;font-size: 11px;text-transform: uppercase;">
                <?=$diagnostico_ingreso['cie10_nombre']?>
            </div>
            <div style="position: absolute;top: 652px;left: 143px;font-size: 11px;text-align: justify;width: 495px">
                1. COMPLICACIONES ASOCIADAS A PATOLOGIA DE BASE. 2. FALLECIMIENTO DURANTE EL INTERNAMIENTO A PESAR DE INTERVENCIONES TERAPÉUTICAS. 3. INFECCIONES INTRAHOSPITALARIAS Y CAIDAS.
                4. REACCIONES ADVERSAS A MEDICAMENTOS
            </div>
            <div style="position: absolute;top: 710px;left: 145px;font-size: 10px;width: 250px">
                * ESTABILIZACIÓN. * INICIO DE TRATAMIENTO DIRIGIDO A PATOLOGÍA BASE.
                * INICIO DE PROTOCOLO DE ESTUDIO.
            </div>
            <div style="position: absolute;top: 710px;left: 460px;font-size: 11px;text-transform: uppercase;">
                ALTA VOLUNTARIA
            </div>
            <div style="position: absolute;top: 765px;left: 378px;font-size: 11px;text-transform: uppercase;">
                <?=$responsable['pic_responsable_nombre']?> 
            </div>
        </div>
         <div style="position: absolute;top: 875px;left: 127px;width: 240px;font-size: 11px;text-align: center">
            <?=$medico_tratante['empleado_nombre']?> <?=$medico_tratante['empleado_apellidos']?><br><?=$medico_tratante['empleado_matricula']?>
         </div> 
       
        <div style="position: absolute;top: 1000px">
            <div style="margin-left: 280px;">
                <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 20px;" ></barcode>
            </div>
        </div>
    </page_header>
    
    <page_footer>
        
    </page_footer>

        
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->SetTitle('Consentimiento Informado');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('Consentimiento Informado.pdf');
?>