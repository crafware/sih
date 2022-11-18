<?php ob_start(); ?>
<page>
    <page_header>
        <img src="<?=  base_url()?>assets/doc/asistentesmedicas_c.png" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
    </page_header>
    <div style="position: absolute;">
        <div style="position: absolute;top: 86px;left: 67px;font-size: 11px"><?=$am['asistentesmedicas_fecha']?></div>
        <div style="position: absolute;top: 86px;left: 250px;font-size: 11px"><?=$am['asistentesmedicas_hora']?></div>
        <div style="position: absolute;top: 86px;left: 430px;font-size: 11px"><?=$am['asistentesmedicas_hoja']?></div>
        <div style="position: absolute;top: 86px;left: 580px;font-size: 11px"><?=$am['asistentesmedicas_renglon']?></div>
        <!--2 fila-->
        <div style="position: absolute;top: 106px;left: 80px;font-size: 11px;text-transform: uppercase">
            <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
        </div>
        <div style="position: absolute;top: 106px;left: 417px;font-size: 11px;text-transform: uppercase">
            <?=$info['triage_paciente_sexo']?>
        </div>
        <?php 
        $ObtenerEdad= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
        ?>
        <div style="position: absolute;top: 106px;left: 514px;font-size: 11px">
            <?=$ObtenerEdad->y?>
        </div>
        <div style="position: absolute;top: 106px;left: 575px;font-size: 11px">
            <?=$ObtenerEdad->m?> 
        </div>
        <!--3 fila-->
        <div style="position: absolute;top: 126px;left: 109px;font-size: 11px;;text-transform: uppercase">
            <?=$PINFO['pum_nss']!='' ? $PINFO['pum_nss'].' - '.$PINFO['pum_nss_agregado'] : $PINFO['pum_nss_armado']?>
        </div>
        <div style="position: absolute;top: 126px;left: 435px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pum_umf']?>
        </div>
        <div style="position: absolute;top: 146px;left: 85px;font-size: 11px;text-transform: uppercase">
            <?=$DirPaciente['directorio_cn']?> <?=$DirPaciente['directorio_colonia']?> <?=$DirPaciente['directorio_cp']?> <?=$DirPaciente['directorio_municipio']?> <?=$DirPaciente['directorio_estado']?> 
        </div>  
        <div style="position: absolute;top: 165px;left: 186px;font-size: 11px;;text-transform: uppercase">
            <?=$PINFO['pic_responsable_nombre']?> <?=$PINFO['pic_responsable_parentesco']!='' ? '(' .$PINFO['pic_responsable_parentesco'].')' : ''?>
        </div>
        <div style="position: absolute;top: 165px;left: 500px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pic_responsable_telefono']?>
        </div>
        <div style="position: absolute;top: 185px;left: 80px;font-size: 11px;text-transform: uppercase">
            <?=  substr($Empresa['empresa_nombre'], 0,50)?>
        </div>
        <?php 
        $DirecccionEmpresa=$DirEmpresa['directorio_cn'].' '.$DirEmpresa['directorio_colonia'].' '.$DirEmpresa['directorio_cp'].' '.$DirEmpresa['directorio_municipio'].' '.$DirEmpresa['directorio_estado'];
        if(strlen($DirecccionEmpresa)>=54){
        ?>
        <div style="position: absolute;top: 178px;left: 400px;font-size: 9px;text-transform: uppercase;width: 310px;">
            <?=$DirecccionEmpresa?>
        </div>
        <?php }else{?>
        <div style="position: absolute;top: 185px;left: 400px;font-size: 10px;text-transform: uppercase;">
            <?=$DirecccionEmpresa?>
        </div>
        <?php }?>
        <div style="position: absolute;top: 205px;left: 130px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pic_mt']?>
        </div>
        <div style="position: absolute;top: 205px;left: 505px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pic_am']?>
        </div>
        <div style="position: absolute;top: 245px;left: 135px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pia_fecha_accidente']?>
        </div>
        <div style="position: absolute;top: 245px;left: 263px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pia_hora_accidente']?>
        </div>
        <div style="position: absolute;top: 245px;left: 380px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pia_lugar_accidente']?>
        </div>
        <div style="position: absolute;top: 245px;left: 554px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pia_lugar_procedencia']?>
        </div> 
        <div style="position: absolute;left: 280px;top: 980px">
            <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 20px;" ></barcode>
        </div>
    </div>
    <page_footer></page_footer>    
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->SetTitle('HOJA FRONTAL EMITIDA POR AM');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('HOJA FRONTAL EMITIDA POR AM.pdf');
?>