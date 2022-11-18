<?php ob_start(); ?>
<page backtop="0mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <div style="position: relative">
        <img src="<?=  base_url()?>assets/doc/doc-4-30-51.png" style="position: absolute;width: 100%;margin-top: 32px;margin-left: -5px;">
        <div style="position: absolute;top: 120px;left: 15px;font-size: 12px;width:400px;">
            <b><?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?></b>
        </div>
        <div style="position: absolute;top: 140px;left: 15px;font-size: 12px;width:180px;">
            <b><?=$PINFO['pum_nss']?> <?=$PINFO['pum_nss_agregado']?></b>
        </div>
        <div style="position: absolute;top: 160px;left: 15px;font-size: 12px;width:100px;">
            <b><?=$info['triage_paciente_sexo']?></b>
        </div>
        <div style="position: absolute;top: 160px;left: 80px;font-size: 12px;width:300px;">
            <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac'])); ?>
            <b><?=$fecha->y==0 ? $fecha->m.' Meses' : $fecha->y.' AÑOS,'?> FECHA DE NACIMIENTO: <?=$info['triage_fecha_nac']?></b>
        </div>
        <div style="position: absolute;top: 177px;left: 15px;text-transform: uppercase;font-size: 10px;width:150px;">
            <b>Ingreso <?=$info43051['tipo_ingreso']?></b>
        </div>
        <div style="position: absolute;top:95px;left: 395px;font-size: 10px;;">
           Fecha de Registro: <?=date("d-m-Y", strtotime($info43051['fecha_registro']))?> <?=$info43051['hora_registro']?> hrs.
        </div>
        <div style="position: absolute;top: 120px;left: 500px;font-size: 11px;width:132px;">
           <?=$PINFO['pia_vigencia']?>
        </div>
        <div style="position: absolute;top: 124px;left: 545px;font-size: 10px;width:70px;">
           <?=$PINFO['pum_umf']?> Delg. <?=$PINFO['pum_delegacion']?>
        </div>
        <div style="position: absolute;top: 145px;left: 455px;">
            <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
        </div>
        <!---DATOS DE LA EMPRESA-->
        <div style="position: absolute;top: 215px;left: 15px;font-size: 8px;width:600px;">
            <?=$Empresa['empresa_nombre']=='' ? 'Sin Especificar' : $Empresa['empresa_nombre'] ?> - 
            <?=$dirEmpresa['directorio_cn']?>,
            COL. <?=$dirEmpresa['directorio_colonia']?>, 
            C.P. <?=$dirEmpresa['directorio_cp']?>, 
            <?=$dirEmpresa['directorio_municipio']?>,   
            <?=$dirEmpresa['directorio_estado']?>
        </div>
        <div style="position: absolute;top: 215px;left: 545px;font-size: 9px;">
            <?=$dirEmpresa['directorio_telefono']?>
        </div>
        <!---DATOS DEL PACIENTE-->
        <div style="position: absolute;top: 244px;left: 15px;text-transform: uppercase;font-size: 9px;width:600px;">
            <?=$dirPaciente['directorio_cn']?>, COL. <?=$dirPaciente['directorio_colonia']?>, C.P. <?=$dirPaciente['directorio_cp']?>, <?=$dirPaciente['directorio_municipio']?>,
            <?=$dirPaciente['directorio_estado']?>.
        </div>
        <div style="position: absolute;top: 244px;left:545px;font-size: 9px;">
            <?=$dirPaciente['directorio_telefono']?>
        </div>
        <!---DATOS DEL RESPONSABLE-->
        <div style="position: absolute;top: 274px;left: 15px;text-transform: uppercase;font-size: 9px;width:310px;">
            <?=$PINFO['pic_responsable_nombre']?>
        </div>
        <div style="position: absolute;top: 274px;left: 545px;text-transform: uppercase;font-size: 9px;">
            <?=$PINFO['pic_responsable_parentesco']?>
        </div>

        <div style="position: absolute;top: 305px;left: 15px;text-transform: uppercase;font-size: 9px;width:600px;">
            <?=$dirResponsable['directorio_tipo'] == '' ? 'EL mismo del paciente' : $dirResponsable['directorio_cn'].' '.$dirResponsable['directorio_colonia'].' '.$dirResponsable['directorio_cp'].', '.
            $dirResponsable['directorio_municipio'].', '.$dirResponsable['directorio_estado']?>.
        </div>
        <div style="position: absolute;top: 305px;left: 544px;font-size: 9px;">
            <?=$PINFO['pic_responsable_telefono']?>
        </div>

        <!--DATOS DE INGRESO-->
        <div style="position: absolute;top: 336px;left: 10px;text-transform: uppercase;font-size: 9px;">
            <?=date("d-m-Y",  strtotime($info43051['fecha_ingreso']))?> <?=$info43051['hora_ingreso']?> hrs.
        </div>
        <div style="position: absolute;top: 352px;left: 40px;font-size: 9px;width: 148px;text-align: justify;">
            <!-- <?= mb_substr($Diagnostico['hf_diagnosticos'], 0,240,'UTF-8')?> -->
        </div>
        <!-- servicio tratante -->
        <div style="position: absolute;top: 335px;left: 143px;text-transform: uppercase;font-size: 9px;width: 200px;;">
            <?=$servicio['especialidad_nombre']?>
        </div>
        <!-- Nombre de cama y piso -->
        <div style="position: absolute;top: 335px;left: 330px;font-size: 9px;">
            <?=$cama['cama_nombre'] == '' ? 'por asignar' : $cama['cama_nombre'].' '.$Piso['piso_nombre']?>
        </div>
        <!-- Nombre de la asistente medica -->
        <div style="position: absolute;top: 335px;left: 437px;font-size: 9px;width: 200px;;">
            <?=$AsistenteMedica['empleado_nombre']?> <?=$AsistenteMedica['empleado_apellidos']?>
        </div>
        <!-- Servicio que Ingresa -->
        <div style="position: absolute;top: 365px;left: 143px;text-transform: uppercase;font-size: 9px">
            <?=$servicio_ingresa['especialidad_nombre']?>
        </div>
        <div class="text-uppercase" style="position: absolute;top: 365px;left: 330px;font-size: 9px">
            <?=$medico_ingresa['empleado_nombre']?> <?=$medico_ingresa['empleado_apellidos']?>
            
        </div>
        <div style="position: absolute;top: 365px;left: 545px;font-size: 9px">
            <?=$medico_ingresa['empleado_matricula']?>
        </div>
        <div style="position: absolute;top: 395px;left: 202px;font-size: 9px">
            <?=$Asignacion['ac_salida_servicio']?>
        </div>
        <div style="position: absolute;top: 395px;left: 330px;font-size: 9px">
            <?=$Asignacion['ac_salida_medico']?>
        </div>
        <div style="position: absolute;top: 395px;left: 545px;font-size: 9px;">
            <?=$Asignacion['ac_salida_matricula']?>
        </div>
    </div>
    <!-- Hoja dos -->
    <div style="position: relative;margin-top: 45px">
        <img src="<?=  base_url()?>assets/doc/doc-4-30-51.png" style="position: absolute;width: 100%;margin-top: 32px;margin-left: -5px;">
        <div style="position: absolute;top: 120px;left: 15px;font-size: 12px;width:400px;">
            <b><?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?></b>
        </div>
        <div style="position: absolute;top: 140px;left: 15px;font-size: 12px;width:180px;">
            <b><?=$PINFO['pum_nss']?> <?=$PINFO['pum_nss_agregado']?></b>
        </div>
        <div style="position: absolute;top: 160px;left: 15px;font-size: 12px;width:100px;">
            <b><?=$info['triage_paciente_sexo']?></b>
        </div>
        <div style="position: absolute;top: 160px;left: 80px;font-size: 12px;width:300px;">
            <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac'])); ?>
            <b><?=$fecha->y==0 ? $fecha->m.' Meses' : $fecha->y.' AÑOS,'?> FECHA DE NACIMIENTO: <?=$info['triage_fecha_nac']?></b>
        </div>
        <div style="position: absolute;top: 177px;left: 15px;text-transform: uppercase;font-size: 10px;width:150px;">
            <b>INGRESO <?=$info43051['tipo_ingreso']?></b>
        </div>
        <div style="position: absolute;top:95px;left: 395px;font-size: 10px;;">
           Fecha de Registro: <?=date("d-m-Y", strtotime($info43051['fecha_registro']))?> <?=$info43051['hora_registro']?> hrs.
        </div>
        <div style="position: absolute;top: 120px;left: 500px;font-size: 11px;width:132px;">
           <?=$PINFO['pia_vigencia']?>
        </div>
        <div style="position: absolute;top: 124px;left: 545px;font-size: 10px;width:70px;">
           <?=$PINFO['pum_umf']?> Delg. <?=$PINFO['pum_delegacion']?>
        </div>
        <div style="position: absolute;top: 145px;left: 455px;">
            <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
        </div>
        <!---DATOS DE LA EMPRESA-->
        <div style="position: absolute;top: 215px;left: 15px;font-size: 8px;width:600px;">
            <?=$Empresa['empresa_nombre']=='' ? 'Sin Especificar' : $Empresa['empresa_nombre'] ?> - 
            <?=$dirEmpresa['directorio_cn']?>,
            COL. <?=$dirEmpresa['directorio_colonia']?>, 
            C.P. <?=$dirEmpresa['directorio_cp']?>, 
            <?=$dirEmpresa['directorio_municipio']?>,   
            <?=$dirEmpresa['directorio_estado']?>
        </div>
        <div style="position: absolute;top: 215px;left: 545px;font-size: 9px;">
            <?=$dirEmpresa['directorio_telefono']?>
        </div>
        <!---DATOS DEL PACIENTE-->
        <div style="position: absolute;top: 244px;left: 15px;text-transform: uppercase;font-size: 9px;width:600px;">
            <?=$dirPaciente['directorio_cn']?>, COL. <?=$dirPaciente['directorio_colonia']?>, C.P. <?=$dirPaciente['directorio_cp']?>, <?=$dirPaciente['directorio_municipio']?>,
            <?=$dirPaciente['directorio_estado']?>.
        </div>
        <div style="position: absolute;top: 244px;left:545px;font-size: 9px;">
            <?=$dirPaciente['directorio_telefono']?>
        </div>
        <!---DATOS DEL RESPONSABLE-->
        <div style="position: absolute;top: 274px;left: 15px;text-transform: uppercase;font-size: 9px;width:310px;">
            <?=$PINFO['pic_responsable_nombre']?>
        </div>
        <div style="position: absolute;top: 274px;left: 545px;text-transform: uppercase;font-size: 9px;">
            <?=$PINFO['pic_responsable_parentesco']?>
        </div>
        <div style="position: absolute;top: 305px;left: 15px;text-transform: uppercase;font-size: 9px;width:600px;">
            <?=$dirResponsable['directorio_tipo'] == '' ? 'EL mismo del paciente' : $dirResponsable['directorio_cn'].' '.$dirResponsable['directorio_colonia'].' '.$dirResponsable['directorio_cp'].', '.
            $dirResponsable['directorio_municipio'].', '.$dirResponsable['directorio_estado']?>.
        </div>
        <div style="position: absolute;top: 305px;left: 544px;font-size: 9px;">
            <?=$PINFO['pic_responsable_telefono']?>
        </div>

        <!--DATOS DE INGRESO-->
        <div style="position: absolute;top: 336px;left: 10px;text-transform: uppercase;font-size: 9px;">
            <?=date("d-m-Y",  strtotime($info43051['fecha_ingreso']))?> <?=$info43051['hora_ingreso']?> hrs.
        </div>
        <div style="position: absolute;top: 352px;left: 40px;font-size: 9px;width: 148px;text-align: justify;">
            <!-- <?= mb_substr($Diagnostico['hf_diagnosticos'], 0,240,'UTF-8')?> -->
        </div>
        <!-- servicio tratante -->
        <div style="position: absolute;top: 335px;left: 143px;text-transform: uppercase;font-size: 9px;width: 200px;;">
            <?=$servicio['especialidad_nombre']?>
        </div>
        <!-- Nombre de cama y piso -->
        <div style="position: absolute;top: 335px;left: 330px;font-size: 9px;">
            <?=$cama['cama_nombre'] == '' ? 'por asignar' : $cama['cama_nombre'].' '.$Piso['piso_nombre']?>
        </div>
        <!-- Nombre de la asistente medica -->
        <div style="position: absolute;top: 335px;left: 437px;font-size: 9px;width: 200px;;">
            <?=$AsistenteMedica['empleado_nombre']?> <?=$AsistenteMedica['empleado_apellidos']?>
        </div>
        <!-- Servicio que Ingresa -->
        <div style="position: absolute;top: 365px;left: 143px;text-transform: uppercase;font-size: 9px">
            <?=$servicio_ingresa['especialidad_nombre']?>
        </div>
        <div class="text-uppercase" style="position: absolute;top: 365px;left: 330px;font-size: 9px">
            <?=$medico_ingresa['empleado_nombre']?> <?=$medico_ingresa['empleado_apellidos']?>
            
        </div>
        <div style="position: absolute;top: 365px;left: 545px;font-size: 9px">
            <?=$medico_ingresa['empleado_matricula']?>
        </div>
        <div style="position: absolute;top: 395px;left: 202px;font-size: 9px">
            <?=$Asignacion['ac_salida_servicio']?>
        </div>
        <div style="position: absolute;top: 395px;left: 330px;font-size: 9px">
            <?=$Asignacion['ac_salida_medico']?>
        </div>
        <div style="position: absolute;top: 395px;left: 545px;font-size: 9px;">
            <?=$Asignacion['ac_salida_matricula']?>
        </div>
    </div>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    //$pdf->pdf->IncludeJS("print(true);");
    $pdf->pdf->SetTitle('4-30-51');
    $pdf->Output('DOC_43_0_51.pdf');
?>