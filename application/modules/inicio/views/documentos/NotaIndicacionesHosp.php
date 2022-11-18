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
           <?=$infoPaciente['triage_nombre_ap']?> <?=$infoPaciente['triage_nombre_am']?> <?=$infoPaciente['triage_nombre']?>
        </div>
        <div style="position: absolute;margin-left: 435px;margin-top: 77px;width: 270px;text-transform: uppercase;font-size: 11px;">
          <b>N.S.S:</b> <?=$infoPaciente['pum_nss']?> <?=$infoPaciente['pum_nss_agregado']?>
        </div>
        <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$infoPaciente['triage_fecha_nac'])); ?>
        <div style="position: absolute;margin-left: 435px;margin-top: 92px;width: 270px;text-transform: uppercase;font-size: 11px;">
          <b>EDAD:</b> <?=$fecha->y==0 ? $fecha->m.' MESES' : $fecha->y.' AÑOS'?>
        </div>
        <div style="position: absolute;margin-left: 550px;margin-top: 92px;width: 270px;text-transform: uppercase;font-size: 11px;">
          <b>GENERO:</b> <?=$infoPaciente['triage_paciente_sexo']?>
        </div>
        <div style="position: absolute;margin-left: 435px;margin-top: 107px;width: 270px;text-transform: uppercase;font-size: 11px;">
          <b>UMF:</b> <?=$infoPaciente['pum_umf']?>/<?=$infoPaciente['pum_delegacion']?>
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
              <b>HORA CERO:</b> <?=date('d-m-Y', strtotime($info['triage_horacero_f']))?> <?=$info['triage_horacero_h']?> hrs
          </p>
          
        </div>
        <div style="font-size: 10px; position: absolute;margin-top: 238px; margin-left: 13px ">
            
        </div>
            <div style="position: absolute;margin-top:238px;margin-left: 302px ">[[page_cu]]/[[page_nb]]</div>
            <div style="position: absolute;margin-top:222px;margin-left: 12px ">
              <?php
                    $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info['triage_codigo_atencion']);
                    echo ($codigo_atencion != '')?"<b>".mb_strtoupper("Código", 'UTF-8').": ".mb_strtoupper($codigo_atencion)."</b>":"";
                ?>
            </div>
            <div style="position: absolute;margin-left: 40px;margin-top: 290px;width: 270px;text-transform: uppercase;font-size: 12px;">
                <b><?=$Nota['notas_fecha']?> <?=$Nota['notas_hora']?></b><br>
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
                <?=$NotaIndicacion['notas_tipo']?> SERVICIO <?= mb_strtoupper($ServicioM[0]['especialidad_nombre'], 'UTF-8'); ?>
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
        .contenidos {
         width: 570px; 
         text-align: justify; 
         padding-top: 0px;
         padding-bottom: 0px;
         margin-top: 0px;
         margin-bottom: -10px;  
        }
    </style> 
  <div style="width: 570px; text-align: justify; ">  
    <?php if($NotaIndicacion['dieta'] == '0') {
        $nutricion = 'Ayuno';
      }else if($NotaIndicacion['dieta'] == '1'){
        $nutricion = 'Normal';
      }else if($NotaIndicacion['dieta'] == '2'){
        $nutricion = 'Blanda';
      }else if($NotaIndicacion['dieta'] == '3'){
        $nutricion = 'Astringente';
      }else if($NotaIndicacion['dieta'] == '4'){
        $nutricion = 'Diabética';
      }else if($NotaIndicacion['dieta'] == '5'){
        $nutricion = 'Hiposódica';
      }else if($NotaIndicacion['dieta'] == '6'){
        $nutricion = 'Hipograsa';
      }else if($NotaIndicacion['dieta'] == '7'){
        $nutricion = 'Líquida clara';
      }else if($NotaIndicacion['dieta'] == '8'){
        $nutricion = 'Líquida general';
      }else if($NotaIndicacion['dieta'] == '9'){
        $nutricion = 'Licuada por sonda';
      }else if($NotaIndicacion['dieta'] == '10'){
        $nutricion = 'Licuada por sonda artesanal';
      }else if($NotaIndicacion['dieta'] == '11'){
        $nutricion = 'Papilla';
      }else if($NotaIndicacion['dieta'] == '12'){
        $nutricion = 'Epecial';
      }else{
        $nutricion = $NotaIndicacion['dieta'];
      }
    ?>
    <?php 
      if($NotaIndicacion['dieta'] != ''){?>
        <div><span><b>Dieta:</b> <?=$nutricion?></span></div>
    <?php }?>
           
    <?php 
      if($NotaIndicacion['svitales'] == '1'){
        $toma_signos = 'Por turno';
      }else if($NotaIndicacion['svitales'] == '2'){
        $toma_signos = 'Cada 4 horas';
      }else $toma_signos = $NotaIndicacion['svitales'];
    ?>
    <?php 
      if($toma_signos != '0') {?>
        <div><span><b>Toma de Signos Vitales:</b> <?=$toma_signos?></span></div>
    <?php }?>
    <?php 
      if($NotaIndicacion['cuidados_generales'] == '1'){ ?>
        <div style="padding-top: 10px;"><b>Cuidados Generales de Enfermería:</b><br>
          <label style="margin-left:20px;" >a. Estado neurológico</label><br>
          <label style="margin-left:20px;" >b. Cama con barandales</label><br>
          <label style="margin-left:20px;" >c. Calificación del dolor</label><br>
          <label style="margin-left:20px;" >d. Calificación de riesgo de caida</label><br>
          <label style="margin-left:20px;" >e. Control de liquidos por turno</label><br>
          <label style="margin-left:20px;" >f. Vigilar riesgo de úlceras por presión</label><br>
          <label style="margin-left:20px;" >g. Aseo bucal</label><br>
          <label style="margin-left:20px;" >h. Lavado de manos</label>
        </div>  
    <?php }?>
    <?php 
      if($NotaIndicacion['cuidados_especiales'] != ''){ ?>
      <p class="contenido"><b>Cuidados Especificos de Enfermeria:</b><br>
        <?=$NotaIndicacion['cuidados_especiales']?>
      </p>
    <?php }?>
    <?php 
      if($NotaIndicacion['solucionesp'] != ''){ ?>
        <p class="contenidos"><b>Soluciones Parenterales:</b><br>
          <?= $NotaIndicacion['solucionesp']?>
        </p>
      <?php }?>
    <p>
    <?php   
      if(!empty($Prescripcion)){?>
        <h5>Prescripción de Medicamentos</h5>
        <?php
        $observacion = "";
        $medicamento = "";
                      
        for($x = 0; $x < count($Prescripcion_Basico); $x++){ 
          $observacion = $Prescripcion_Basico[$x]['observacion'];
          $medicamento = $Prescripcion_Basico[$x]['medicamento'];
         
          if($medicamento === "OTRO"){
           $medicamento = substr($observacion, 0, strpos($observacion, "-"));
           $observacion = substr($observacion, (strpos($observacion, "-") + 1),  strlen($observacion) );
          }?>
           <strong><?= $x+1 ?>) <?= $medicamento." ".$Prescripcion_Basico[$x]['forma_farmaceutica'] ?>. </strong>
          Aplicar <?= $Prescripcion_Basico[$x]['dosis'] ?> via <?= strtolower($Prescripcion_Basico[$x]['via']); ?>, <?= ($Prescripcion_Basico[$x]['frecuencia'] == 'Dosis unica')? '' : 'cada'; ?> <?= strtolower($Prescripcion_Basico[$x]['frecuencia']); ?>, en el siguiente horario: <?= $Prescripcion_Basico[$x]['aplicacion'] ?>. Iniciando el <?= $Prescripcion_Basico[$x]['fecha_inicio'] ?>  hasta el <?= $Prescripcion_Basico[$x]['fecha_fin'] ?>.
                    
          <?php 
            if($Prescripcion_Basico[$x]['observacion'] != 'Sin observaciones' ){ ?>
              <br><strong>Observación:</strong> <?= $observacion ?>
          <?php }?>
          <br><!-- Salto entre prescripciones -->
          <?php 
        }?>

        <?= (count($Prescripcion_Onco_Anti) > 0)?"<h5>Antimicrobiano</h5>":""; ?>
          <?php for($x = 0; $x < count($Prescripcion_Onco_Anti); $x++){ ?>
             <strong><?= $x+1 ?>) <?= $Prescripcion_Onco_Anti[$x]['medicamento']." ".$Prescripcion_Onco_Anti[$x]['forma_farmaceutica'] ?>. </strong> Aplicar <?= $Prescripcion_Onco_Anti[$x]['dosis'] ?> via <?= strtolower($Prescripcion_Onco_Anti[$x]['via']); ?>, <?= ($Prescripcion_Onco_Anti[$x]['frecuencia'] == 'Dosis unica')? '' : 'cada'; ?> <?= strtolower($Prescripcion_Onco_Anti[$x]['frecuencia']); ?>, en el siguiente horario: <?= $Prescripcion_Onco_Anti[$x]['aplicacion'] ?>.
             Iniciando el <?= $Prescripcion_Onco_Anti[$x]['fecha_inicio'] ?> hasta el <?= $Prescripcion_Onco_Anti[$x]['fecha_fin'] ?>.
             <br>
             <strong>Diluyente: </strong><u>&nbsp; <?= $Prescripcion_Onco_Anti[$x]['diluente'] ?> &nbsp;</u>&nbsp;&nbsp;&nbsp;
             <strong>Vol. Diluyente: </strong><u>&nbsp; <?= $Prescripcion_Onco_Anti[$x]['vol_dilucion'] ?> ml.&nbsp;</u>
             <?php if($Prescripcion_Onco_Anti[$x]['observacion'] != 'Sin observaciones' ){ ?>
                 <br><strong>Observación</strong>
                 <?= $Prescripcion_Onco_Anti[$x]['observacion'] ?>
               <?php } ?>
             <br>
           <?php } ?>

           <?= (count($Prescripcion_NPT) > 0)?"<h5>Nutrición Parenteral Total</h5>":""; ?>

          <?php for($x = 0; $x < count($Prescripcion_NPT); $x++){ ?>
             <strong><?= $x+1 ?>) <?= $Prescripcion_NPT[$x]['medicamento']." ".$Prescripcion_NPT[$x]['gramaje']." ".$Prescripcion_NPT[$x]['forma_farmaceutica'] ?>. </strong>
             Aplicar <?= $Prescripcion_NPT[$x]['dosis'] ?> via <?= strtolower($Prescripcion_NPT[$x]['via']); ?>, <?= ($Prescripcion_NPT[$x]['frecuencia'] == 'Dosis unica')? '' : 'cada'; ?> <?= strtolower($Prescripcion_NPT[$x]['frecuencia']); ?>,
             en el siguiente horario: <?= $Prescripcion_NPT[$x]['aplicacion'] ?>. Iniciando el <?= $Prescripcion_NPT[$x]['fecha_inicio'] ?>
             hasta el <?= $Prescripcion_NPT[$x]['fecha_fin'] ?>.
             <br>
             <?php $totalvol = (
                               $Prescripcion_NPT[$x]['aminoacido'] +
                               $Prescripcion_NPT[$x]['dextrosa'] +
                               $Prescripcion_NPT[$x]['lipidos'] +
                               $Prescripcion_NPT[$x]['agua_inyect'] +
                               $Prescripcion_NPT[$x]['cloruro_sodio'] +
                               $Prescripcion_NPT[$x]['sulfato'] +
                               $Prescripcion_NPT[$x]['cloruro_potasio'] +
                               $Prescripcion_NPT[$x]['fosfato'] +
                               $Prescripcion_NPT[$x]['gluconato'] +
                               $Prescripcion_NPT[$x]['albumina'] +
                               $Prescripcion_NPT[$x]['heparina'] +
                               $Prescripcion_NPT[$x]['insulina'] +
                               $Prescripcion_NPT[$x]['zinc'] +
                               $Prescripcion_NPT[$x]['mvi'] +
                               $Prescripcion_NPT[$x]['oligoelementos'] +
                               $Prescripcion_NPT[$x]['vitamina']
                             ); ?>
             <strong>OVERFILL:</strong><u>&nbsp; 20 &nbsp;</u>&nbsp;&nbsp;&nbsp;<strong>Vol. Total:</strong><u>&nbsp; <?=$totalvol?> &nbsp;</u>
             <br>
             <!-- Consultar bases -->
             <?php if($Prescripcion_NPT[$x]['aminoacido'] > 0 ||
                     $Prescripcion_NPT[$x]['dextrosa'] > 0 ||
                     $Prescripcion_NPT[$x]['lipidos'] > 0 ||
                     $Prescripcion_NPT[$x]['agua_inyect'] > 0 ){ ?>
                       <br>
                       Solucion Base
                       <br>
                       <?= ($Prescripcion_NPT[$x]['aminoacido'] > 0) ? '<div>Aminoácidos Cristalinos 10% adulto <u>&nbsp;&nbsp; '.$Prescripcion_NPT[$x]['aminoacido'].' ml &nbsp;&nbsp;</u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['dextrosa'] > 0) ? '<div>Dextrosa al 50% <u>&nbsp;&nbsp; '.$Prescripcion_NPT[$x]['dextrosa'].' ml &nbsp;&nbsp;</u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['lipidos'] > 0) ? '<div>Lipdiso Intravenosos con Acidos grasos, Omega 3 y 9 <u>&nbsp;&nbsp; '.$Prescripcion_NPT[$x]['lipidos'].' ml &nbsp;&nbsp;</u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['agua_inyect'] > 0) ? '<div>Agua Inyectable <u>&nbsp;&nbsp; '.$Prescripcion_NPT[$x]['agua_inyect'].' ml &nbsp;&nbsp;</u></div>':'' ?>

             <?php } ?>

             <!-- Consultar sales -->
             <?php if($Prescripcion_NPT[$x]['cloruro_sodio'] > 0 ||
                     $Prescripcion_NPT[$x]['sulfato'] > 0 ||
                     $Prescripcion_NPT[$x]['cloruro_potasio'] > 0 ||
                     $Prescripcion_NPT[$x]['fosfato'] > 0 ||
                     $Prescripcion_NPT[$x]['gluconato'] > 0 ){ ?>
                       <br>
                       Sales
                       <br>
                       <?= ($Prescripcion_NPT[$x]['cloruro_sodio'] > 0) ? '<div>Cloruro de Sodio 17.7% (3mEq/ml Na) <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['cloruro_sodio'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['sulfato'] > 0) ? '<div>Sulfato de Magnesio (0.81) mEq/ml <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['sulfato'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['cloruro_potasio'] > 0) ? '<div>Cloruro de Potasio (4 mEeq/ml K) <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['cloruro_potasio'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['fosfato'] > 0) ? '<div>Fosfato de Potasio (2 mEq/ml k/1.11 m mol PO4) <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['fosfato'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['gluconato'] > 0) ? '<div>Gluconato de Calcio (0.465 mEq/ml) <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['gluconato'].' ml &nbsp;&nbsp; </u></div>':'' ?>
             <?php } ?>

             <!-- Consultar aditivos -->
             <?php if($Prescripcion_NPT[$x]['albumina'] > 0 ||
                     $Prescripcion_NPT[$x]['heparina'] > 0 ||
                     $Prescripcion_NPT[$x]['insulina'] > 0 ||
                     $Prescripcion_NPT[$x]['zinc'] > 0 ||
                     $Prescripcion_NPT[$x]['mvi'] > 0 ||
                     $Prescripcion_NPT[$x]['oligoelementos'] > 0 ||
                     $Prescripcion_NPT[$x]['vitamina'] > 0){ ?>
                       <br>
                       Aditivos:
                       <br>
                       <?= ($Prescripcion_NPT[$x]['albumina'] > 0)?'<div>Albúmina 20% (0.20 g/ml): <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['albumina'].' gr &nbsp;&nbsp; </u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['heparina'] > 0)?'<div>Heparina (1000 UI/ml): <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['heparina'].' UI &nbsp;&nbsp; </u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['insulina'] > 0)?'<div>Insulina Humana (100 UI/ml): <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['insulina'].' UI &nbsp;&nbsp; </u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['zinc'] > 0)?'<div>Zinc: <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['zinc'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['mvi'] > 0)?'<div>MVI - Adulto <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['mvi'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['oligoelementos'] > 0)?'<div>Oligoelementos Tracefusin <u> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['oligoelementos'].' ml &nbsp;&nbsp; </u></div>':'' ?>
                       <?= ($Prescripcion_NPT[$x]['vitamina'] > 0)?'<div>Vitamina C (100 mg/ml) <u style="float:right;"> &nbsp;&nbsp; '.$Prescripcion_NPT[$x]['vitamina'].' mg &nbsp;&nbsp; </u></div>':'' ?>
             <?php } ?>

             <?php if($Prescripcion_NPT[$x]['observacion'] != 'Sin observaciones' ){ ?>
                 <br><strong>Observación</strong>
                 <?= $Prescripcion_NPT[$x]['observacion'] ?><br>
               <?php } ?>
             <br>
           <?php } ?>
         <!-- Fin prescripcion -->
    <?php } ?> 
    </p>    
      
    </div>
 
    <page_footer>
      <?php
        if(count($residentes) == 0){
           $top = 910;
        }else if( count($residentes) > 0){
           $top = 870;
        }
      ?>
        <div style="position: absolute;top: <?=$top?>px;left: 215px;width: 240px;font-size: 10px;text-align: center">
                <?=$medicoTratante['empleado_nombre']?> <?=$medicoTratante['empleado_apellidos']?><br>
                <span style="margin-top: -6px;margin-bottom: -8px">____________________________________</span><br>
                <b>NOMBRE DEL MÉDICO TRATANTE</b>
        </div>
        <div style="position: absolute;top: <?=$top?>px;left: 430px;width: 160px;font-size: 10px;text-align: center">
                <?=$medicoTratante['empleado_cedula']?> - <?=$medicoTratante['empleado_matricula']?> <br>
                <span style="margin-top: -6px;margin-bottom: -8px">_____________________________</span><br>
                <b>CÉDULA Y MATRICULA</b>
        </div>
        <div style="position: absolute;top: <?=$top?>px;left: 590px;width: 110px;font-size: 10px;text-align: center">
                <br>
                <span style="margin-top: -6px;margin-bottom: -8px">_________________</span><br>
                <b>FIRMA</b>
        </div>
    
        <?php if(!empty($residentes)) {?>    
                <div style="position: absolute;top: <?=$top+40?>px;left: 200px;width: 480px;font-size: 10px;text-align: left;">
                    
                    <?php foreach ($residentes as $value){?>
                        <?=$value['nombre_residente']?> <?=$value['apellido_residente']?> (<?=$value['cedulap_residente']?>) - <?=$value['grado']?>,    
                    <?php }?>
                </div>
        <?php }?>
      
    </page_footer>
</page>
<?php
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','en',true,'UTF-8');
    $pdf->writeHTML($html);
    // $pdf->pdf->IncludeJS("print(true);");
    $pdf->pdf->SetTitle($NotaInterconsulta['notas_tipo']);
    $pdf->Output($NotaInterconsulta['notas_tipo'].'.pdf');

?>