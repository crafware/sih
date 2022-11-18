<?php ob_start();
//El margen se modifica dependiendo el número de residentes en la nota
$margenBajo = "50mm";
if(count($Residentes) == 3){
  $margenBajo = "78mm";
}else if(count($Residentes) == 2){
  $margenBajo = "71mm";
}else if(count($Residentes) == 1){
  $margenBajo = "60mm";
}
?>
<page backtop="80mm" backbottom="<?=$margenBajo ?>" backleft="49" backright="5mm">
  <page_header>
    <img src="<?=  base_url()?>assets/doc/DOC430128.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">
      <div style="position: absolute;margin-top: 15px">
        <div style="position: absolute;margin-left: 435px;margin-top: 50px;width: 270px;text-transform: uppercase;font-size: 11px;text-align: left;">
          <b>NOMBRE DEL PACIENTE:</b>
        </div>
        <div style="position: absolute;margin-left: 435px;margin-top: 62px;width: 300px;text-transform: uppercase;font-size: 14px;">
          <?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?>
        </div>
        <div style="position: absolute;margin-left: 435px;margin-top: 77px;width: 270px;text-transform: uppercase;font-size: 11px;">
          <b>N.S.S:</b> <?=$PINFO['pum_nss']?> <?=$PINFO['pum_nss_agregado']?>
        </div>
        <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac'])); ?>
        <div style="position: absolute;margin-left: 435px;margin-top: 92px;width: 270px;text-transform: uppercase;font-size: 11px;">
          <b>EDAD:</b> <?=$fecha->y==0 ? $fecha->m.' MESES' : $fecha->y.' AÑOS'?>
        </div>
        <div style="position: absolute;margin-left: 550px;margin-top: 92px;width: 270px;text-transform: uppercase;font-size: 11px;">
          <b>GENERO:</b> <?=$info['triage_paciente_sexo']?>
        </div>
        <div style="position: absolute;margin-left: 435px;margin-top: 107px;width: 270px;text-transform: uppercase;font-size: 11px;">
          <b>UMF:</b> <?=$PINFO['pum_umf']?>/<?=$PINFO['pum_delegacion']?>
        </div>
        <div style="position: absolute;margin-left: 550px;margin-top: 107px;width: 270px;text-transform: uppercase;font-size: 11px;">
          <b>PROCEDENCIA:</b> <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEO' : 'REFERENCIADO'?>
        </div>
        <div style="position: absolute;margin-left: 550px;margin-top: 122px;width: 270px;text-transform: uppercase;font-size: 11px;">
          <b>ATENCIÓN:</b> <?=$PINFO['pia_tipo_atencion']?>
        </div>
        <div style="position: absolute;margin-left: 437px;margin-top: 154px;width: 300px;text-transform: uppercase;font-size: 11px;">
          <p style="margin-top: -10px">
          <b>DOMICILIO: </b> <?=$DirPaciente['directorio_cn']?>, <?=$DirPaciente['directorio_colonia']?>, <?=$DirPaciente['directorio_cp']?>, <?=$DirPaciente['directorio_municipio']?>, <?=$DirPaciente['directorio_estado']?> <B>TEL:</B><?=$DirPaciente['directorio_telefono']?>
          </p>
        </div>
        <div style="position: absolute;margin-left: 437px;margin-top: 185px;width: 300px;text-transform: uppercase;font-size: 11px;">
          <p style="margin-top: -1px">
              <b>FOLIO:</b> <?=$info['triage_id']?>
          </p>
          <p style="margin-top: -10px">
              <b>HORA CERO:</b> <?=$info['triage_horacero_f']?> <?=$info['triage_horacero_h']?>
          </p>
          <p style="margin-top: -7px">
              <b>MÉD.:</b> <?=$medicoTratante['empleado_apellidos']?> <?=$medicoTratante['empleado_nombre']?>
          </p>
          
        </div>
        <div style="font-size: 10px; position: absolute;margin-top: 238px; margin-left: 13px ">
            <?php
            $sqlChoque=$this->config_mdl->sqlGetDataCondition('os_choque_v2',array(
                'triage_id'=>$info['triage_id']
            ),'cama_id');
            $sqlObs=$this->config_mdl->sqlGetDataCondition('os_observacion',array(
                'triage_id'=>$info['triage_id']
            ),'observacion_cama');
            if(empty($sqlChoque)){ echo "UBICACIÓN ";
                echo $this->config_mdl->sqlGetDataCondition('os_camas',array(
                    'cama_id'=>$sqlObs[0]['observacion_cama']
                ),'cama_nombre')[0]['cama_nombre'];
            }else{
                echo "UBICACIÓN";
                echo $this->config_mdl->sqlGetDataCondition('os_camas',array(
                    'cama_id'=>$sqlChoque[0]['cama_id']
                ),'cama_nombre')[0]['cama_nombre'];
            }
            ?>
        </div>
            <div style="position: absolute;margin-top:238px;margin-left: 302px ">[[page_cu]]/[[page_nb]]</div>
            <div style="position: absolute;margin-top:22px;margin-left: 12px ">
              <?php
                    $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info['triage_codigo_atencion']);
                    echo ($codigo_atencion != '')?"<b>".mb_strtoupper("Código", 'UTF-8').": ".mb_strtoupper($codigo_atencion)."</b>":"";
                ?>
            </div>
            <div style="position: absolute;margin-left: 40px;margin-top: 286px;width: 270px;text-transform: uppercase;font-size: 12px;">
                <?=$notaProcedimientos['notas_fecha']?> <?=$notaProcedimientos['notas_hora']?><br>
            </div>
            <div style="position: absolute;margin-left: 22px;margin-top: 320px;width: 130px;font-size: 12px;text-align: center">
              <?php if($SignosVitales['sv_peso']!='') {?>
              <h5 style="margin-top: 15px">Peso:<span style="font-weight: normal"><?=$SignosVitales['sv_peso']?> Kg</span></h5>
              <?php }?>
              <?php if($SignosVitales['sv_talla']!='') {?>
              <h5 style="margin-top: 1px">Talla:<span style="font-weight: normal"><?=$SignosVitales['sv_talla']?> cm</span></h5>
              <?php }?>
              <?php if($SignosVitales['sv_ta']!='') {?>
              <h5 style="margin-top: 5">Presión Arterial</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_ta']?> mm Hg</p>
              <?php }?>
              <?php if($SignosVitales['sv_peso']!='') {?>
              <h5 style="margin-top: -5">Temperatura</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_temp']?> °C</p>
              <?php }?>
              <?php if($SignosVitales['sv_temp']!='') {?>
              <h5 style="margin-top: -5">Frecuencia Cardíaca</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_fc']?> lpm</p>
              <?php }?>
              <?php if($SignosVitales['sv_fr']!='') {?>
              <h5 style="margin-top: -5">Frecuencia Respiratoria</h5><p style="margin-top: -14px"><?=$SignosVitales['sv_fr']?> rpm</p>
              <?php }?>
              <?php if($SignosVitales['sv_oximetria']!='') {?>
              <h5 style="margin-top: -5">Oximetria</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_oximetria']?> % Sp0<sub>2</sub></p>
              <?php }?>
              <?php if($SignosVitales['sv_dextrostix']!='') {?>
              <h5 style="margin-top: -5">Glucosa</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_dextrostix']?> mg/dl</p>
              <?php }?>
            </div>
            <div style="rotate: 90; position: absolute;margin-left: 50px;margin-top: 336px;text-transform: uppercase;font-size: 12px;">
                <?php $sqlEmpleadoSV=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                    'empleado_id'=>$SignosVitales['empleado_id']
                ),'empleado_nombre,empleado_apellidos')[0];?>
                <?php $sqlEmpleadoSV['empleado_nombre']?> <?php $sqlEmpleadoSV['empleado_apellidos']?> <?php $SignosVitales['sv_fecha']?> <?php $SignosVitales['sv_hora']?><br><br><br>
            </div>
            <div style="margin-left: 280px;margin-top: 980px">
                <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
            </div>
            <div style="position: absolute;top: 262px;;width: 500px;;left: 205px;font-size: 12px;text-transform: uppercase;text-align: center;font-weight: bold">
                <?=$notaProcedimientos['notas_tipo']?> SERVICIO <?= mb_strtoupper($ServicioM['especialidad_nombre'], 'UTF-8'); ?>
            </div>
        </div>
  </page_header>

    <style type="text/css">
        ul {
          width: 550px;
          text-align: justify;
          padding-top: 5px;
          margin-top: 0px;
        }
        ol {
          width: 550px;
          text-align: justify;
          padding-top: 5px;
          margin-top: 0px;
        }
        .contenido {
         width: 570px; 
         text-align: justify; 
         padding-top: 5px;
         padding-bottom: 0px;
         margin-top: 0px;
         margin-bottom: 0px;  
        }
    </style>

    <div style="position:absolute; left: -10px; margin-top: -17px; font-size: 12px;">
      <h5 style="margin-bottom: -6px">PROCEDIMIENTO(S) REALIZADO(S)</h5>
      <?php $procedimiento = explode(',', $notaProcedimientos['procedimientos']);
            foreach($procedimiento as $value => $procedimiento_id) {
              $nombreProcedimiento=$this->config_mdl->_get_data_condition('um_procedimientos', array('procedimiento_id'=>$procedimiento_id))[0];?>
                <p class="contenido">* <?=$nombreProcedimiento['nombre']?>.</p>
      <?php }?>

      <h5 style="margin-bottom: -6px">RESUMEN</h5>
        <p class="contenido"><?= $notaProcedimientos['resumen_procedimiento'] ?></p>     
    </div>
    
    <page_footer>
       <?php
            $sqlMedico=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                'empleado_id'=>$notaProcedimientos['empleado_id']
            ))[0];
            if(count($MedicoBase) > 0){
              $NombreMedico=$MedicoBase['empleado_nombre'].' '.$MedicoBase['empleado_apellidos'];
              $MatriculaMedico=$MedicoBase['empleado_matricula'];
            }else{
              if(empty($sqlMedico)){
                  $NombreMedico=$Medico['empleado_nombre'].' '.$Medico['empleado_apellidos'];
                  $MatriculaMedico=$Medico['empleado_matricula'];
              }else{
                  $NombreMedico=$sqlMedico['empleado_nombre'].' '.$sqlMedico['empleado_apellidos'];
                  $MatriculaMedico=$sqlMedico['empleado_matricula'];
              }
            }
            ?>
            <?php
            if(count($Residentes) > 0){ 
               if(count($Residentes) == 3){
                $top = 783;
              }else if( count($Residentes) == 2){
                $top = 813;
              }else if( count($Residentes) == 1){
                $top = 853;
              }?>     
          
            <div style="position: absolute;top: <?=$top?>px;left: 215px;width: 250px;font-size: 10px;text-align: center">
            <b>NOMBRE MÉDICO RESIDENTE</b><br><br>
            <?php foreach ($Residentes as $value){?>
                  <?=$value['nombre_residente']?> <?=$value['apellido_residente']?><br><br><br>
            <?php } ?>

            </div>
            <div style="position: absolute;top: <?=$top?>px;left: 480px;width: 110px;font-size: 10px;text-align: center">
            <b>CEDULA</b><br><br>

            <?php foreach ($Residentes as $value){?>
                  <?=$value['cedulap_residente']?><br><br><br>
            <?php } ?>

            </div>
            <div style="position: absolute;top: <?=$top?>px;left: 590px;width: 110px;font-size: 10px;text-align: center">
              <b>FIRMA</b><br><br>
            <?php for($i = 0; $i < count($Residentes); $i++){ ?>
              _________________<br><br><br>
            <?php }?>
            </div>   
            <?php }?>
            <div style="position: absolute;top: 922px;left: 215px;width: 250px;font-size: 10px;text-align: center">
                <?=$NombreMedico?><br>
                <span style="margin-top: -6px;margin-bottom: -8px"></span><br>
                <b>NOMBRE DEL MÉDICO TRATANTE</b>
            </div>
            <div style="position: absolute;top: 922px;left: 480px;width: 110px;font-size: 11px;text-align: center">
                <?=$MatriculaMedico?> <br>
                <span style="margin-top: -6px;margin-bottom: -8px"></span><br>
                <b>MATRICULA</b>
            </div>
            <div style="position: absolute;top: 922px;left: 590px;width: 110px;font-size: 11px;text-align: center">
                <br>
                <span style="margin-top: -6px;margin-bottom: -8px">_________________</span><br>
                <b>FIRMA</b>
            </div>
    </page_footer>
</page>
<?php
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','en',true,'UTF-8');
    $pdf->writeHTML($html);
    // $pdf->pdf->IncludeJS("print(true);");
    $pdf->pdf->SetTitle($notaProcedimientos['notas_tipo']);
    $pdf->Output($notaProcedimientos['notas_tipo'].'.pdf');
?>