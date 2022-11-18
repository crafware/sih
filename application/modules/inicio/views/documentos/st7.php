<?php ob_start(); ?>
<page backtop="15mm">
    <page_header></page_header>
    <div style="position: absolute;">
        <img src="<?=  base_url()?>assets/doc/ST7/ST7_1.png" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
        <div style="position: absolute;top: 48px;left: 395px;font-size: 8px"><?=$Empresa['empresa_nombre']?></div>
        <div style="position: absolute;top: 70px;left: 395px;font-size: 8px"><?=$DirEmpresa['directorio_cn']?></div>
        <div style="position: absolute;top: 101px;left: 393px;font-size: 8px;width: 320px;">
            <?=$DirEmpresa['directorio_colonia']?> <?=$DirEmpresa['directorio_municipio']?> <?=$DirEmpresa['directorio_estado']?>
        </div>
        <?php 
        $ObtenerEdad= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
        ?>
        <div style="position: absolute;top: 146px;left: 26px;font-size: 12px"><b><?php if($ST7_FOLIO['st7_folio_id']!=''){?>FOLIO: <?=$ST7_FOLIO['st7_folio_id']?><?php }?></b></div>
        <div style="position: absolute;top: 128px;left: 395px;font-size: 8px"><?=$DirEmpresa['directorio_cp']?></div>
        <div style="position: absolute;top: 128px;left: 580px;font-size: 8px"><?=$DirEmpresa['directorio_telefono']?></div>
        <div style="position: absolute;top: 148px;left: 395px;font-size: 8px"><?=$Empresa['empresa_rp']?></div>
        
        <div style="position: absolute;top: 170px;left: 32px;font-size: 8px"><?=$PINFO['pum_nss']?> <?=$PINFO['pum_nss_agregado']?></div>
        <div style="position: absolute;top: 170px;left: 255px;font-size: 8px;text-transform: uppercase"><?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?></div>
        
        <div style="position: absolute;top: 192px;left: 32px;font-size: 8px"><?=$PINFO['pic_identificacion']?></div>
        <div style="position: absolute;top: 192px;left: 367px;font-size: 8px"><?=$info['triage_paciente_curp']?></div>
        <div style="position: absolute;top: 192px;left: 663px;font-size: 8px"><?=$ObtenerEdad->y?> Años</div>
        
        <div style="position: absolute;top: 214px;left: 45px;font-size: 8px">
        <?=$info['triage_paciente_sexo']=='HOMBRE' ? 'X' :''?>
        </div>
        <div style="position: absolute;top: 214px;left: 72px;font-size: 8px">
        <?=$info['triage_paciente_sexo']=='MUJER' ? 'X' :''?>
        </div>
        <div style="position: absolute;top: 219px;left: 105px;font-size: 8px"><?=$info['triage_paciente_estadocivil']?></div>
        <div style="position: absolute;top: 219px;left: 196px;font-size: 8px"><?=$DirPaciente['directorio_cn']?></div>
        <div style="position: absolute;top: 219px;left: 500px;font-size: 8px"><?=$DirPaciente['directorio_colonia']?></div>
        <div style="position: absolute;top: 252px;left: 32px;font-size: 8px"><?=$DirPaciente['directorio_municipio']?> <?=$DirPaciente['directorio_estado']?></div>
        <div style="position: absolute;top: 252px;left: 410px;font-size: 8px"><?=$DirPaciente['directorio_telefono']?></div>
        <div style="position: absolute;top: 252px;left: 510px;font-size: 8px"><?=$DirPaciente['directorio_cp']?></div>
        <div style="position: absolute;top: 252px;left: 615px;font-size: 8px;width: 100px"><?=$PINFO['pum_umf']?></div>
        <div style="position: absolute;top: 290px;left: 32px;font-size: 8px;width: 68px;"><?=$PINFO['pum_delegacion']?></div>
        <div style="position: absolute;top: 290px;left: 110px;font-size: 8px;width: 85px;"><?=$PINFO['pia_dia_pa']?></div>
        <div style="position: absolute;top: 290px;left: 225px;font-size: 8px"><?=$Empresa['empresa_he']?> - <?=$Empresa['empresa_hs']?></div>
        <div style="position: absolute;top: 298px;left: 330px;font-size: 8px"><?=  explode('/', $PINFO['pia_fecha_accidente'])[0]?></div>
        <div style="position: absolute;top: 298px;left: 380px;font-size: 8px"><?=  explode('/', $PINFO['pia_fecha_accidente'])[1]?></div>
        <div style="position: absolute;top: 298px;left: 425px;font-size: 8px"><?=  explode('/', $PINFO['pia_fecha_accidente'])[2]?></div>
        <div style="position: absolute;top: 298px;left: 470px;font-size: 8px"><?=  $PINFO['pia_hora_accidente']?></div>
        
        <div style="position: absolute;top: 298px;left: 525px;font-size: 8px"><?=  explode('-', $am['asistentesmedicas_fecha'])[2]?></div>
        <div style="position: absolute;top: 298px;left: 575px;font-size: 8px"><?=  explode('-', $am['asistentesmedicas_fecha'])[1]?></div>
        <div style="position: absolute;top: 298px;left: 620px;font-size: 8px"><?=  explode('-', $am['asistentesmedicas_fecha'])[0]?></div>
        <div style="position: absolute;top: 298px;left: 665px;font-size: 8px"><?=  $am['asistentesmedicas_hora']?></div>
        
        <div style="position: absolute;top: 330px;left: 32px;font-size: 8px;width: 660px;text-align: justify;line-height: 1.5">
            <?=  $am['asistentesmedicas_da']?>
        </div>
        <div style="position: absolute;top: 410px;left: 32px;font-size: 8px;width: 660px;text-align: justify;line-height: 1.5">
            <?=  $am['asistentesmedicas_dl']?>
        </div>
        <div style="position: absolute;top: 510px;left: 32px;font-size: 8px;width: 660px;text-align: justify;line-height: 1.5">
            <?=  $hojafrontal['hf_diagnosticos']=='' ? $am['asistentesmedicas_ip'] : $hojafrontal['hf_diagnosticos']?>
        </div>
        <div style="position: absolute;top: 570px;left: 32px;font-size: 8px;width: 660px;text-align: justify;line-height: 1.5">
            <?=  $am['asistentesmedicas_tratamientos']?>
        </div>
        <div style="position: absolute;top: 634px;left: 225px;font-size: 8px;">
            <?=$am['asistentesmedicas_ss_in']=='Si' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 634px;left: 296px;font-size: 8px;">
            <?=$am['asistentesmedicas_ss_in']=='No' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 634px;left: 530px;font-size: 8px;">
            <?=$am['asistentesmedicas_ss_ie']=='Si' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 634px;left: 590px;font-size: 8px;">
            <?=$am['asistentesmedicas_ss_ie']=='No' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 670px;left: 224px;font-size: 8px;">
            <?=$am['asistentesmedicas_oc_hr']=='Si' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 670px;left: 298px;font-size: 8px;">
            <?=$am['asistentesmedicas_oc_hr']=='No' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 668px;left: 334px;font-size: 8px;width: 368px">
            <?=$am['asistentesmedicas_am']?>
        </div>
        <div style="position: absolute;top: 717px;left: 140px;font-size: 8px;">
            <?=$am['asistentesmedicas_incapacidad_am']=='Si' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 717px;left: 190px;font-size: 8px;">
            <?=$am['asistentesmedicas_incapacidad_am']=='No' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 720px;left: 230px;font-size: 8px;">
            <?= explode('/', $am['asistentesmedicas_incapacidad_fi'])[0]?>
        </div>
        <div style="position: absolute;top: 720px;left: 260px;font-size: 8px;">
            <?= explode('/', $am['asistentesmedicas_incapacidad_fi'])[1]?>
        </div>
        <div style="position: absolute;top: 720px;left: 290px;font-size: 8px;">
            <?= explode('/', $am['asistentesmedicas_incapacidad_fi'])[2]?>
        </div>
        <div style="position: absolute;top: 720px;left: 350px;font-size: 11px;">
            <?=$am['asistentesmedicas_incapacidad_folio']?>
        </div>
        <div style="position: absolute;top: 720px;left: 480px;font-size: 8px;">
            <?=$am['asistentesmedicas_incapacidad_da']!='' ?$am['asistentesmedicas_incapacidad_da'].' Dias' :'' ?>
        </div>
        <div style="position: absolute;top: 710px;left: 582px;font-size: 8px;width: 113px">
            <?=$ce['ce_hf']?>
        </div>
        <div style="position: absolute;top: 755px;left: 33px;font-size: 8px;width: 160px;">
            <?=$am['asistentesmedicas_mt']?>
        </div>
        <div style="position: absolute;top: 755px;left: 257px;font-size: 8px;width: 130px;">
            <?=$am['asistentesmedicas_mt_m']?>
        </div>
        <div style="position: absolute;top: 755px;left: 528px;font-size: 8px;width: 160px">
            <?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?><br>
        </div>
    </div>
</page>
<page pageset="old" >
    <div style="margin-top: 5px;font-size: 20px;font-weight: 200;width: 100%;margin-right: 20px;position: absolute">
        <img src="<?=  base_url()?>assets/doc/ST7/ST7_2.png" style="position: absolute;width: 100%;margin-top: 10px;margin-left: -5px;">
    </div>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','en','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->SetTitle('ST7 - '.$info['triage_nombre_ap'].' '.$info['triage_nombre_am'].' '.$info['triage_nombre']);
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('ST7_'.$info['triage_nombre_ap'].' '.$info['triage_nombre_am'].' '.$info['triage_nombre']. '.pdf');
?>