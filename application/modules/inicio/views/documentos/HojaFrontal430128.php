<?php ob_start(); ?>
<page backtop="85mm" backbottom="50mm" backleft="56" backright="15mm">
    <page_header>
        <style>
            table, td, th {text-align: left;}
            table {border-collapse: collapse;width: 100%;}
            th, td {padding: 5px;}
        </style>
        <img src="<?=  base_url()?>assets/doc/DOC430128_HF.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">
        <div style="position: absolute;margin-top: 15px">
            <div style="position: absolute;top: 80px;left: 120px;width: 270px;">
                <b><?=_UM_CLASIFICACION?> | <?=_UM_NOMBRE?></b>
            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 105px;width: 270px;text-transform: uppercase;font-size: 20px;text-align: left;">
                <b><?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?></b>
            </div>
            <div style="position: absolute;margin-left: 437px;margin-top: 150px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <b>N.S.S:</b> <?=$PINFO['pum_nss']?> <?=$PINFO['pum_nss_agregado']?>
            </div>
            <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac'])); ?>
            <div style="position: absolute;margin-left: 437px;margin-top: 166px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -2px">
                    <b>EDAD:</b> <?=$fecha->y==0 ? $fecha->m.' MESES' : $fecha->y.' AÑOS'?>
                </p>
                <p style="margin-top: -10px">
                    <b>UMF:</b> <?=$PINFO['pum_umf']?>
                </p>
                <p style="margin-top: -10px">
                    <b><?=$hoja['hf_atencion']?></b> 
                </p>
                
            </div>
            <div style="position: absolute;margin-left: 540px;margin-top: 166px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -2px">
                    <b>FOLIO:</b> <?=$info['triage_id']?>
                </p>
                <p style="margin-top: -10px">
                    <b>PROCEDE:</b> <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEO' : 'REFERENCIADO'?>
                </p>
                <p style="margin-top: -10px">
                    <b>HORA CERO:</b> <?=$info['triage_horacero_f']?> <?=$info['triage_horacero_h']?>
                </p>
            </div>
            <div style="position: absolute;margin-left: 437px;margin-top: 205px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -1px">
                    <b>MÉD.:</b> <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?> <?=$Medico['empleado_matricula']?>
                </p>
                <p style="margin-top: -9px">
                    <b>AM:</b> <?=$AsistenteMedica['empleado_nombre']?> <?=$AsistenteMedica['empleado_apellidos']?>
                </p>
                <p style="margin-top: -11px">
                    <b>HORA A.M:</b> <?=$am['asistentesmedicas_fecha']?> <?=$am['asistentesmedicas_hora']?>
                </p>
            </div>
            <div style="position: absolute;margin-left: 437px;margin-top: 263px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <b>HOJA FRONTAL</b>
            </div>
            
            <div style="position: absolute;margin-top:229px;margin-left: 134px ">
                <?php 
                $sqlChoque=$this->config_mdl->_get_data_condition('os_choque_v2',array(
                    'triage_id'=>$info['triage_id']
                ));
                $sqlObs=$this->config_mdl->_get_data_condition('os_observacion',array(
                    'triage_id'=>$info['triage_id']
                ));
                if(empty($sqlChoque)){
                    echo $this->config_mdl->_get_data_condition('os_camas',array(
                        'cama_id'=>$sqlObs[0]['observacion_cama']
                    ))[0]['cama_nombre'];
                }else{
                    echo $this->config_mdl->_get_data_condition('os_camas',array(
                        'cama_id'=>$sqlChoque[0]['cama_id']
                    ))[0]['cama_nombre'];
                }
                ?>
            </div>
            <div style="position: absolute;margin-top:228px;margin-left: 44px;text-transform: uppercase ">
                <b>CLASIFICACIÓN:</b> <?=$info['triage_color']?>
            </div>
            <div style="position: absolute;margin-top:228px;margin-left: 382px ">:[[page_cu]]/[[page_nb]]</div>
            
            <div style="position: absolute;margin-left: 50px;margin-top: 276px;width: 150px;font-size: 7px;text-align: center;">
                <h6><b>FECHA DE CREACIÓN DOCUMENTO MÉDICO:</b> <?=$hoja['hf_fg']?> <?=$hoja['hf_hg']?></h6>
            </div>
            <div style="position: absolute;margin-left: 66px;margin-top: 320px;width: 130px;font-size: 12px;text-align: center">
                
                <h4>Tensión Arterial</h4>
                <h1 style="margin-top: -10px"><?=$SignosVitales['sv_ta']?></h1>
                <br><br>
                <h4>Temperatura</h4>
                <h1 style="margin-top: -10px"><?=$SignosVitales['sv_temp']?> °C</h1>
                <br><br>
                <h4>Frecuencia Cardiaca</h4>
                <h1 style="margin-top: -10px"><?=$SignosVitales['sv_fc']?> X Min</h1>
                
                <h4>Frecuencia Respiratoria</h4>
                <h1 style="margin-top: -10px"><?=$SignosVitales['sv_fr']?> X Min</h1>
            </div>
            <div style="rotate: 90; position: absolute;margin-left: 50px;margin-top: 336px;text-transform: uppercase;font-size: 12px;">
                <?=$Enfermera['empleado_nombre']?> <?=$Enfermera['empleado_apellidos']?> <?=$info['triage_fecha']?> <?=$info['triage_hora']?><br><br><br>
            </div>
            <div style="position: absolute;top: 910px;left: 215px;width: 240px;font-size: 9px;text-align: center">
                <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?><br>
                <span style="margin-top: -6px;margin-bottom: -8px">____________________________________</span><br>
                <b>NOMBRE DEL MÉDICO</b>
            </div>
            <div style="position: absolute;top: 910px;left: 480px;width: 110px;font-size: 9px;text-align: center">
                <?=$Medico['empleado_matricula']?> <br>
                <span style="margin-top: -6px;margin-bottom: -8px">_________________</span><br>
                <b>MATRICULA</b>
            </div>
            <div style="position: absolute;top: 910px;left: 590px;width: 110px;font-size: 9px;text-align: center">
                <br>
                <span style="margin-top: -6px;margin-bottom: -8px">_________________</span><br>
                <b>FIRMA</b>
            </div>
            <div style="margin-left: 280px;margin-top: 980px">
                <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
            </div>
            
        </div>   
        
    </page_header>
    <div style="font-size: 12px;">
        <p style="margin-top: -10px;text-transform: uppercase">
            <b>DOMICILIO: </b> <?=$DirPaciente['directorio_cn']?> <?=$DirPaciente['directorio_colonia']?> <?=$DirPaciente['directorio_cp']?> <?=$DirPaciente['directorio_municipio']?> <?=$DirPaciente['directorio_estado']?>
        </p>
        <p style="margin-top: -10px;text-transform: uppercase">
            <b>EN CASO NECESARIO LLAMAR: </b> <?=$PINFO['pic_responsable_nombre']?> <?php if($PINFO['pic_responsable_parentesco']!=''){?>(<?=$PINFO['pic_responsable_parentesco']?>)<?php }?>
        </p>
        <p style="margin-top: -10px;text-transform: uppercase">
            <b>TELEFONO: </b> <?=$PINFO['pic_responsable_telefono']=='' ? 'Sin Especificar' : $value['pic_responsable_telefono']?>
        </p>
        <?php if($PINFO['pia_lugar_accidente']=='TRABAJO'){ ?>
        <p style="margin-top: -10px;text-transform: uppercase">
            <b>EMPRESA: </b> <?=$Empresa['empresa_nombre']?>
        </p>
        <p style="margin-top: -10px;text-transform: uppercase">
            <b>DOMICILIO DE LA EMPRESA: </b> <?=$DirEmpresa['directorio_cn'].' '.$DirEmpresa['directorio_colonia'].' '.$DirEmpresa['directorio_cp'].' '.$DirEmpresa['directorio_municipio'].' '.$DirEmpresa['directorio_estado'];?>
        </p>
        <p style="margin-top: -10px;text-transform: uppercase">
            <b>TELEFONO DE LA EMPRESA: </b> <?=$DirEmpresa['directorio_telefono']=='' ? 'Sin Especificar': $DirEmpresa['directorio_telefono']?>
        </p>
        <?php }?>
        
        <p style="margin-top: -10px;text-transform: uppercase">
            <b>FECHA & HORA DE ACCIDENTE: </b> <?=$PINFO['pia_fecha_accidente']?> <?=$PINFO['pia_hora_accidente']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>LUGAR: </b> <?=$PINFO['pia_lugar_accidente']?>
        </p>
        <p style="margin-top: -10px;;text-transform: uppercase">
            <b>PROCEDENCIA: </b> <?=$PINFO['pia_lugar_procedencia']?>
        </p>
    </div>
    <span style="text-align: justify">
        <?php if($hoja['hf_motivo']!=''){?>
        <h3 style="margin-bottom: -6px">MOTIVO DE URGENCIA</h3>
        <?=$hoja['hf_motivo']?>
        <br>
        <?php }?>
        <?php if($hoja['hf_mecanismolesion']!='' || $hoja['hf_mecanismolesion_otros'])?>
        <h3 style="margin-bottom: -6px">MECANISMO DE LESIÓN</h3>
        <?=$hoja['hf_mecanismolesion']?> <?=$hoja['hf_mecanismolesion_otros']?><br>
        <?=$hoja['hf_mecanismolesion_mtrs']!='' ? 'Caida '.$hoja['hf_mecanismolesion_mtrs'].' Metros':'' ?>
        <br>
        <?php if($hoja['hf_quemadura']!='' || $hoja['hf_quemadura_otros']!=''){?>
        <h3 style="margin-bottom: -6px;" >QUEMADURAS</h3>
        <?=$hoja['hf_quemadura']?> <?=$hoja['hf_quemadura_otros']?> 
        <br>
        <?php }?>
        <h3 style="margin-bottom: -6px">ANTECEDENTES</h3>
        <?=$hoja['hf_antecedentes']?>
        <br>
        <h3 style="margin-bottom: -6px">EXPLORACIÓN FÍSICA</h3>
        <?=$hoja['hf_exploracionfisica']?>
        <br>
        <h3 style="margin-bottom: -6px">INTERPRETACIÓN</h3>
        <?=$hoja['hf_interpretacion']?>
        <br>
        <?php if(!empty($DiagnosticosCIE10)){?>
        <h3 style="margin-top: 6px">DIAGNOSTICOS</h3>
        <table class="table" style="width: 100%;margin-top: -10px">
            <tbody>
                <?php foreach ($DiagnosticosCIE10 as $value) {?>
                <tr>
                    <td style="width: 100%;text-transform: uppercase;line-height: 1.4">
                        <b>DIAGNOSTICO: </b><?=$value['cie10_nombre']?><br>
                        <b>TIPO:</b> <?=$value['cie10hf_tipo']?>&nbsp;&nbsp;&nbsp;&nbsp;<b>ESTADO: </b><?=$value['cie10hf_tipo']?><br>
                        <b>OBSERVACIONES: </b> <?=$value['cie10hf_obs']!='' ? $value['cie10hf_obs']:'Sin Observaciones'?>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
       
        <br>
        <?php }?>
        <h3 style="margin-bottom: -6px">DIAGNOSTICOS</h3>
        <?=$hoja['hf_diagnosticos']?>
        <br>
        <?php if($hoja['hf_trataminentos']!='' && $hoja['hf_trataminentos_otros']!=''){?>
        <h3 style="margin-bottom: -6px">TRATAMIENTOS</h3>
        <?=$hoja['hf_trataminentos']?> 
        <?=$hoja['hf_trataminentos_otros']!='' ? ' '.$hoja['hf_trataminentos_otros'] : ''?> <?=$hoja['hf_trataminentos_por']!='' ? ' POR:'.$hoja['hf_trataminentos_por'].' Dias' : ''?>
        <br>
        <?php }?>
        <h3 style="margin-bottom: -6px">RECETA POR</h3>
        <?=$hoja['hf_receta_por']?>
        <br>
        <h3 style="margin-bottom: -6px">INDICACIONES</h3>
        <?=$hoja['hf_indicaciones']?>
        <?php if($hoja['hf_ministeriopublico']=='Si'){?>
        <br>
        <h3 style="margin-bottom: -6px">NOTIFICACIÓN AL MINISTERIO PUBLICO: <?=$hoja['hf_ministeriopublico']=='Si' ? 'Si' : 'No'?></h3>
        <?php }?>
        <br>
        <h3 style="margin-bottom: -6px">AMERITA INCAPACIDAD: <?=$am['asistentesmedicas_incapacidad_am']?></h3>
        <?php if($am['asistentesmedicas_incapacidad_am']=='Si'){?>
        <b>Tipo de Incapacidad: </b><?=$am['asistentesmedicas_incapacidad_tipo']?><br>
        <?=$am['asistentesmedicas_incapacidad_folio']!='' ? '<b>Folio: </b>'.$am['asistentesmedicas_incapacidad_folio'].'<br>' : ''?>
        <?=$am['asistentesmedicas_incapacidad_fi']!='' ? '<b>Fecha de Inicio de Incapacidad: </b>'.$am['asistentesmedicas_incapacidad_fi'].'<br>' : ''?>
        <?=$am['asistentesmedicas_incapacidad_da']!='' ? '<b>Dias Autorizados: </b>'.$am['asistentesmedicas_incapacidad_da'].'<br>' : ''?>
        <?php }?>
    </span>
    <page_footer>

    </page_footer>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->pdf->SetTitle('HOJA FONTRAL');
    $pdf->Output($Nota['notas_tipo'].'.pdf');
?>