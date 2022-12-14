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
        <div style="position: absolute;margin-left: 437px;margin-top: 154px;width: 270px;text-transform: uppercase;font-size: 11px;">
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
              <b>MÉD.:</b> <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?>
          </p>
          <p style="margin-top: -9px">
              <b>AM:</b> <?=$AsistenteMedica['empleado_nombre']?> <?=$AsistenteMedica['empleado_apellidos']?>
          </p>
          <p style="margin-top: -11px">
              <b>HORA A.M:</b> <?=$am['asistentesmedicas_fecha']?> <?=$am['asistentesmedicas_hora']?>
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
            <div style="position: absolute;margin-left: 40px;margin-top: 290px;width: 270px;text-transform: uppercase;font-size: 12px;">
                <?=$Nota['notas_fecha']?> <?=$Nota['notas_hora']?><br>
            </div>
            <div style="position: absolute;margin-left: 15px;margin-top: 300px;width: 130px;font-size: 12px;text-align: center">
              <h5 style="margin-top: 15px">Peso:</h5><p style="margin-top: -28px;margin-left: 77"><?=$SignosVitales['sv_peso']?> Kg</p>
              <h5 style="margin-top: 1px">Talla:</h5><p style="margin-top: -28px;margin-left: 80"><?=$SignosVitales['sv_talla']?> cm</p>
              <h5 style="margin-top: 5">Presión Arterial</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_ta']?> mm Hg</p>
                <h5 style="margin-top: -5">Temperatura</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_temp']?> °C</p>
                <h5 style="margin-top: -5">Frecuencia Cardíaca</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_fc']?> lpm</p>
                <h5 style="margin-top: -5">Frecuencia Respiratoria</h5><p style="margin-top: -14px"><?=$SignosVitales['sv_fr']?> rpm</p>
                <h5 style="margin-top: -5">Oximetria</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_oximetria']?> % Sp0<sub>2</sub></p>
                <h5 style="margin-top: -5">Glucosa</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_dextrostix']?> mg/dl</p>
                <h5 style="margin-top: -5">EVA</h5><p style="margin-top: -15px"><?=$Nota['nota_eva']?></p>
                <h5 style="margin-top: -5">Riesgo de Caída</h5><p style="margin-top: -12px"><?=$Nota['hf_riesgo_caida']?></p>
                <h5 style="margin-top: -5">Riesgo de Trombosis</h5><p style="margin-top: -12px"><?=$Nota['nota_riesgotrombosis']?></p>
                <h5 style="margin-top: -5">Escala de Glasgow</h5><p style="margin-top: -14px"><?=$Nota['nota_escala_glasgow']?></p>
                <h5 style="margin-top: -5">Estado de salud</h5><p style="margin-top: -14px"><?=$Nota['nota_estadosalud']?></p>
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
                <?=$Nota['notas_tipo']?> SERVICIO <?= mb_strtoupper($ServicioM[0]['especialidad_nombre'], 'UTF-8'); ?>
            </div>
        </div>
  </page_header>
  <!-- <div style="left: 1px; right: -2000px; margin-top: -15px; font-size: 12px;"> -->
    <style type="text/css">
        ul {
          width: 550px;
          text-align: justify;
        }
        ol {
          width: 550px;
          text-align: justify;
        }
        .contenido {
         width: 570px; 
         text-align: justify; 
         padding-top: 0px;
         padding-bottom: 0px;
         margin-top: 0px;
         margin-bottom: 0px;  
        }
    </style>
    <!-- <div style="text-align: justify;width: 100%;left: 1px; right: -2000px; margin-top: -15px; font-size: 12px;"> -->
    <div style="position:absolute; left: 1px; margin-top: -17px; font-size: 12px;">
      <?php if($Nota['notas_tipo']== 'Nota de Evolución') { 
                $label1 = "RESUMEN CLÍNICO (DIAGNÓSTICO Y SÍNTOMAS)";
                $label2 = "INTERROGATORIO";
                $label3 = "EXPLORACIÓN FÍSICA";
          }else if($Nota['notas_tipo']== 'Nota de Interconsulta' || $Nota['notas_tipo']== 'Nota de Valoración'){
                $label1 = "MONIVO DE INTERCONSULTA";
                $label2 = "INTERROGATORIO";
                $label3 = "EXPLORACIÓN FÍSICA";
          }?>

        <?php if($_GET['indicaciones'] == 1){ ?>
            <h4>INDICACIONES Y ORDENES MEDICAS</h4>
        <?php }else{ ?> <!-- Informacion general de la nota evolucion -->
        <?php if($Nota['nota_problema']!=''){?>
              <h5 style="margin-bottom: -6px"><?= $label1 ?></h5>
              <div style="width: 570px;"><?= $Nota['nota_problema'] ?></div>
        <?php }?>
        <?php if($Nota['nota_interrogatorio']!=''){?>
              <h5 style="margin-bottom: -6px"><?= $label2 ?></h5>
              <div style="width: 570px;"><?= $Nota['nota_interrogatorio'] ?></div>
        <?php }?>
        <?php if($Nota['nota_exploracionf']!=''){?>
              <h5 style="margin-bottom: -6px"><?= $label3 ?></h5>
              <div style="width: 570px;"><?= $Nota['nota_exploracionf'] ?></div>
        <?php }?>
        <?php if($Nota['nota_auxiliaresd']!=''){?>
              <h5 style="margin-bottom: -6px">RESULTADOS DE SERVICIOS AUXILIARES DE DIAGNÓSTICO</h5>
              <div style="width: 570px;"><?=$Nota['nota_auxiliaresd']?></div>
        <?php }?>
        <?php if($Nota['nota_procedimientos']!=''){?>
              <h5 style="margin-bottom: -6px">PROCEDIMIENTOS REALIZADOS</h5>
              <div style="width: 570px;"><?=$Nota['nota_procedimientos']?></div>
        <?php }?>
        <?php if($Nota['nota_analisis']!=''){?>
              <h5 style="margin-bottom: -6px">ANÁLISIS</h5>
              <div style="width: 570px;"><?=$Nota['nota_analisis']?></div>
        <?php }?>
              <h5 style="margin-bottom: -6px">ACTUALIZACIÓN DE DIAGNÓSTICO(S) Y COMORBILIDADES</h5>
              <div class="table table-hover">          
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th>Clave</th>
                      <th>Diagnóstico Principal</th>
                    </tr>
                  </thead>
                  <tbody>
        <?php foreach ($Diagnosticos as $value){
                if($value['tipodiag']==1) {?>
                     <tr>
                      <td><?=$value['cie10_clave']?></td>
                      <td><?=$value['cie10_nombre']?></td>
                    </tr> 
                    <tr>                   
                    <td></td>
                    <td><?=$value['complemento']?></td>
                  </tr> 
          <?php }
            }?> 
                  </tbody>
                </table>
              </div>
              <div class="table table-hover">          
                <table class="table table-condensed">
                  <thead>
                    <tr>                     
                      <th>Clave</th>
                      <th>Diagnósticos Secundarios</th>
                    </tr>
                  </thead>
                  <tbody>
        <?php foreach ($Diagnosticos as $value){
                if($value['tipodiag']==2) {?>
                    <tr>        
                      <td><?=$value['cie10_clave']?></td>
                      <td><?=$value['cie10_nombre']?></td>
                  </tr> 
                  <tr>                   
                    <td></td>
                    <td><?=$value['complemento']?> <?=$value['fecha_dx']?></td>
                  </tr> 
        <?php }
            }?>           
                  </tbody>
                </table>
              </div>
          
          <?php if($Nota['nota_pronosticos']!=''){?>
                 <h5 style="margin-bottom: -6px">PRONÓSTICO</h5>
                 <div style="width: 570px;"><?=$Nota['nota_pronosticos']?></div>
          <?php }?>

          <h5 style="margin-botton: -6px">PLAN Y ORDENES MÉDICAS:</h5>
        <!-- <?php } ?> -->
        <?php if($Nota['nota_nutricion'] == '0') {
          $nutricion = 'Ayuno';
        }else if($Nota['nota_nutricion'] == '1'){
          $nutricion = 'IB - Normal';
        }else if($Nota['nota_nutricion'] == '2'){
          $nutricion = 'IIA - Blanda';
        }else if($Nota['nota_nutricion'] == '3'){
          $nutricion = 'IIB - Astringente';
        }else if($Nota['nota_nutricion'] == '4'){
          $nutricion = 'III - Diabética';
        }else if($Nota['nota_nutricion'] == '5'){
          $nutricion = 'IV - Hiposódica';
        }else if($Nota['nota_nutricion'] == '6'){
          $nutricion = 'V - Hipograsa';
        }else if($Nota['nota_nutricion'] == '7'){
          $nutricion = 'VI - Líquida clara';
        }else if($Nota['nota_nutricion'] == '8'){
          $nutricion = 'VIA - Líquida general';
        }else if($Nota['nota_nutricion'] == '9'){
          $nutricion = 'VIB - Licuada por sonda';
        }else if($Nota['nota_nutricion'] == '10'){
          $nutricion = 'VIB - Licuada por sonda artesanal';
        }else if($Nota['nota_nutricion'] == '11'){
          $nutricion = 'VII - Papilla';
        }else if($Nota['nota_nutricion'] == '12'){
          $nutricion = 'VIII - Epecial';
        }else{
          $nutricion = $Nota['nota_nutricion'];
        }
        ?>
        <ol><li>NUTRICIÓN: <?= $nutricion ?> </li>

        <?php if($Nota['nota_svycuidados'] == '1'){
          $toma_signos = 'Por turno';
        }else if($Nota['nota_svycuidados'] == '2'){
          $toma_signos = 'Cada 4 horas';
        }else{
          $toma_signos = $Nota['nota_svycuidados'];
        }
        ?>

        <?php if(count($Nota['nota_svycuidados']) > 0){ ?>
          <li>TOMA DE SIGNOS: <?= $toma_signos ?> </li>
        <?php } ?>

        <?php if($Nota['nota_cgenfermeria'] == '1'){ ?>
          <li>CUIDADOS GENERALES:<br>
            <label style="margin-left:20px;" >a. Estado neurológico</label><br>
            <label style="margin-left:20px;" >b. Cama con barandales</label><br>
            <label style="margin-left:20px;" >c. Calificación del dolor</label><br>
            <label style="margin-left:20px;" >d. Calificación de riesgo de caida</label><br>
            <label style="margin-left:20px;" >e. Control de liquidos por turno</label><br>
            <label style="margin-left:20px;" >f. Vigilar riesgo de úlceras por presión</label><br>
            <label style="margin-left:20px;" >g. Aseo bucal</label><br>
            <label style="margin-left:20px;" >h. Lavado de manos</label><br>
          </li>
        <?php } ?>

        <?php if($Nota['nota_cuidadosenfermeria'] != ''){ ?>
         <li>CUIDADOS ESPECIALES:<br> <?= $Nota['nota_cuidadosenfermeria'] ?></li>
        <?php } ?>

        <?php if($Nota['nota_solucionesp'] != ''){ ?>
        <li>SOLUCIONES PARENTERALES:<br> <?= $Nota['nota_solucionesp'] ?></li>
        <?php } ?>
        <!-- Alergia a medicamentos -->
         <?php if(!empty($AlergiaMedicamentos)){ ?>
        <?php  echo (count($AlergiaMedicamentos > 0))?'<h5 style="margin-bottom: -6px">ALERGIA A MEDICAMENTOS</h5>':'';?>
        <?php for($x = 0; $x < count($AlergiaMedicamentos); $x++){ ?>
          <?=($x + 1).") ".$AlergiaMedicamentos[$x]['medicamento'] ?><br>
        <?php }
        }?>
        <!-- Fin alergia a medicamentos -->

        <!-- Prescripcion -->
         <li>MEDICAMENTOS<br>
         <?php
          $observacion = "";
          $medicamento = "";
          ?>
         <?php for($x = 0; $x < count($Prescripcion_Basico); $x++){ ?>
           <?php
           $observacion = $Prescripcion_Basico[$x]['observacion'];
           $medicamento = $Prescripcion_Basico[$x]['medicamento'];
           if($medicamento === "OTRO"){
             $medicamento = substr($observacion, 0, strpos($observacion, "-"));
             $observacion = substr($observacion, (strpos($observacion, "-") + 1),  strlen($observacion) );
           }
            ?>
           <strong><?= $x+1 ?>) <?= $medicamento." ".$Prescripcion_Basico[$x]['gramaje']." ".$Prescripcion_Basico[$x]['forma_farmaceutica'] ?>. </strong>
           Aplicar <?= $Prescripcion_Basico[$x]['dosis'] ?>
           via <?= strtolower($Prescripcion_Basico[$x]['via']); ?>,
           <?= ($Prescripcion_Basico[$x]['frecuencia'] == 'Dosis unica')? '' : 'cada'; ?> <?= strtolower($Prescripcion_Basico[$x]['frecuencia']); ?>,
           en el siguiente horario: <?= $Prescripcion_Basico[$x]['aplicacion'] ?>.
           Iniciando el <?= $Prescripcion_Basico[$x]['fecha_inicio'] ?>
           hasta el <?= $Prescripcion_Basico[$x]['fecha_fin'] ?>.
           <?php if($Prescripcion_Basico[$x]['observacion'] != 'Sin observaciones' ){ ?>
               <br><strong>Observación</strong>
               <?= $observacion ?>
             <?php } ?>

           <br><br><!-- Salto entre prescripciones -->
         <?php } ?>

         <?= (count($Prescripcion_Onco_Anti) > 0)?"<h5>Antimicrobiano</h5>":""; ?>

         <?php for($x = 0; $x < count($Prescripcion_Onco_Anti); $x++){ ?>
           <strong><?= $x+1 ?>) <?= $Prescripcion_Onco_Anti[$x]['medicamento']." ".$Prescripcion_Onco_Anti[$x]['gramaje']." ".$Prescripcion_Onco_Anti[$x]['forma_farmaceutica'] ?>. </strong>
           Aplicar <?= $Prescripcion_Onco_Anti[$x]['dosis'] ?>
           via <?= strtolower($Prescripcion_Onco_Anti[$x]['via']); ?>,
           <?= ($Prescripcion_Onco_Anti[$x]['frecuencia'] == 'Dosis unica')? '' : 'cada'; ?> <?= strtolower($Prescripcion_Onco_Anti[$x]['frecuencia']); ?>,
           en el siguiente horario: <?= $Prescripcion_Onco_Anti[$x]['aplicacion'] ?>.
           Iniciando el <?= $Prescripcion_Onco_Anti[$x]['fecha_inicio'] ?>
           hasta el <?= $Prescripcion_Onco_Anti[$x]['fecha_fin'] ?>.
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
           Aplicar <?= $Prescripcion_NPT[$x]['dosis'] ?>
           via <?= strtolower($Prescripcion_NPT[$x]['via']); ?>,
           <?= ($Prescripcion_NPT[$x]['frecuencia'] == 'Dosis unica')? '' : 'cada'; ?> <?= strtolower($Prescripcion_NPT[$x]['frecuencia']); ?>,
           en el siguiente horario: <?= $Prescripcion_NPT[$x]['aplicacion'] ?>.
           Iniciando el <?= $Prescripcion_NPT[$x]['fecha_inicio'] ?>
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
     </li>
     </ol>
        <!-- Zona interconsultas -->
        <?php if(count($Interconsultas) > 0 && $Interconsultas['doc_estatus'] != 'Evaluado') { ?>
          <h5>INTERCONSULTAS SOLICITADAS</h5>
          <strong>Servicios solicitados:</strong>
          <?php for ($x = 0; $x < count($Interconsultas); $x++) {  ?>
             <?php $separacion = "";  ?>
             <?php $separacion = (($x + 1) == count($Interconsultas))?'.':',';  ?>
             <?= $Interconsultas[$x]['especialidad_nombre'].''.$separacion ?>
          <?php } ?>
            <br><strong>Motivo:</strong> <?= $Interconsultas[0]['motivo_interconsulta'] ?>
        <?php } ?>
        <!-- fin zona interconsultas -->
    </div>
 <!--  </div> -->
    <page_footer>
       <?php
            $sqlMedico=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                'empleado_id'=>$Nota['notas_medicotratante']
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
    $pdf->pdf->SetTitle($Nota['notas_tipo']);
    $pdf->Output($Nota['notas_tipo'].'.pdf');
?>