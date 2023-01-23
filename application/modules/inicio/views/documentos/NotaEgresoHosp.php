<?php ob_start();
//El margen se modifica dependiendo el número de residentes en la nota
$margenBajo = "50mm";
/*if (count($Residentes) == 3) {
  $margenBajo = "78mm";
} else if (count($Residentes) == 2) {
  $margenBajo = "71mm";
} else if (count($Residentes) == 1) {
  $margenBajo = "60mm";
}*/
// $fechaIngreso = date("d-m-Y", strtotime());

$tiempo_estancia = Modules::run('Config/CalcularTiempoTranscurrido', array(
  'Tiempo1' =>  str_replace('/', '-', $infoIngreso['fecha_ingreso']) . ' ' . $infoIngreso['hora_atencion'],
  'Tiempo2' =>  $notaEgreso['notas_fecha'] . ' ' . $notaEgreso['notas_hora']
));
?>
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
<page backtop="80mm" backbottom="35" backleft="49" backright="5mm">
  <page_header>
    <img src="<?= base_url() ?>assets/doc/DOC430128.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">
    <div style="position: absolute;margin-top: 15px">
      <div style="position: absolute;margin-left: 435px;margin-top: 50px;width: 270px;text-transform: uppercase;font-size: 11px;text-align: left;">
        <b>NOMBRE DEL PACIENTE:</b>
      </div>
      <div style="position: absolute;margin-left: 435px;margin-top: 62px;width: 300px;text-transform: uppercase;font-size: 14px;">
        <?= $info['triage_nombre'] ?> <?= $info['triage_nombre_ap'] ?> <?= $info['triage_nombre_am'] ?>
      </div>
      <div style="position: absolute;margin-left: 435px;margin-top: 77px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>N.S.S:</b> <?= $PINFO['pum_nss'] ?> <?= $PINFO['pum_nss_agregado'] ?>
      </div>
      <?php $fecha = Modules::run('Config/ModCalcularEdad', array('fecha' => $info['triage_fecha_nac'])); ?>
      <div style="position: absolute;margin-left: 435px;margin-top: 92px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>EDAD:</b> <?= $fecha->y == 0 ? $fecha->m . ' MESES' : $fecha->y . ' AÑOS' ?>
      </div>
      <div style="position: absolute;margin-left: 550px;margin-top: 92px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>GENERO:</b> <?= $info['triage_paciente_sexo'] ?>
      </div>
      <div style="position: absolute;margin-left: 435px;margin-top: 107px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>UMF:</b> <?= $PINFO['pum_umf'] ?>/<?= $PINFO['pum_delegacion'] ?>
      </div>
      <div style="position: absolute;margin-left: 550px;margin-top: 107px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>PROCEDENCIA:</b> <?= $PINFO['pia_procedencia_espontanea'] == 'Si' ? 'ESPONTANEO' : 'REFERENCIADO' ?>
      </div>
      <div style="position: absolute;margin-left: 550px;margin-top: 122px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>ATENCIÓN:</b> <?= $PINFO['pia_tipo_atencion'] ?>
      </div>
      <div style="position: absolute;margin-left: 437px;margin-top: 154px;width: 300px;text-transform: uppercase;font-size: 11px;">
        <p style="margin-top: -10px">
          <b>DOMICILIO: </b> <?= $DirPaciente['directorio_cn'] ?>, <?= $DirPaciente['directorio_colonia'] ?>, <?= $DirPaciente['directorio_cp'] ?>, <?= $DirPaciente['directorio_municipio'] ?>, <?= $DirPaciente['directorio_estado'] ?> <B>TEL:</B><?= $DirPaciente['directorio_telefono'] ?>
        </p>
      </div>
      <div style="position: absolute;margin-left: 437px;margin-top: 185px;width: 300px;text-transform: uppercase;font-size: 11px;">
        <p style="margin-top: -1px">
          <b>FOLIO:</b> <?= $info['triage_id'] ?>
        </p>
        <p style="margin-top: -10px">
          <b>FECHA DE INGRESO Y HORA CERO :</b> <?= date('d-m-Y', strtotime($info['triage_horacero_f'])) ?> <?= $info['triage_horacero_h'] ?>
        </p>
        <p style="margin-top: -7px">
          <b>CAMA:</b> <?= $infoCama['cama_nombre'] ?> - <?= $infoCama['piso_nombre_corto'] ?>
        </p>
        <p style="margin-top: -7px; left: 100px;">
          <b>INGRESO SERVICIO:</b> <?= $infoIngreso['fecha_ingreso'] ?>
        </p>
        <p style="margin-top: -9px">
          <b>TIEMPO DE ESTANCIA:</b> <?= $tiempo_estancia->d ?> dias <?= $tiempo_estancia->h ?> hrs <?= $tiempo_estancia->i ?> min.
        </p>
      </div>
      <div style="position: absolute;margin-top:238px;margin-left: 302px ">[[page_cu]]/[[page_nb]]</div>
      <div style="position: absolute;margin-top:222px;margin-left: 12px ">
        <?php
        $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info['triage_codigo_atencion']);
        echo ($codigo_atencion != '') ? "<b>" . mb_strtoupper("Código", 'UTF-8') . ": " . mb_strtoupper($codigo_atencion) . "</b>" : "";
        ?>
      </div>
      <div style="position: absolute;margin-left: 35px;margin-top: 290px;width: 270px;font-size: 12px;">
        <b><?= $notaEgreso['notas_fecha'] ?> <?= $notaEgreso['notas_hora'] ?> hrs.</b><br>
      </div>
      <div style="position: absolute;margin-left: 15px;margin-top: 300px;width: 130px;font-size: 12px;text-align: center">
        <?php if ($SignosVitales['sv_peso'] != '') { ?>
          <h5 style="margin-top: 15px">Peso:<span style="font-weight: normal"><?= $SignosVitales['sv_peso'] ?> Kg</span></h5>
        <?php } ?>
        <?php if ($SignosVitales['sv_talla'] != '') { ?>
          <h5 style="margin-top: 1px">Talla:<span style="font-weight: normal"><?= $SignosVitales['sv_talla'] ?> cm</span></h5>
        <?php } ?>
        <h5 style="margin-top: 10">Presión Arterial</h5>
        <p style="margin-top: -15px"><?= $SignosVitales['sv_ta'] ?> mm Hg</p>
        <h5 style="margin-top: -5">Temperatura</h5>
        <p style="margin-top: -15px"><?= $SignosVitales['sv_temp'] ?> °C</p>
        <h5 style="margin-top: -5">Frecuencia Cardíaca</h5>
        <p style="margin-top: -15px"><?= $SignosVitales['sv_fc'] ?> lpm</p>
        <h5 style="margin-top: -5">Frecuencia Respiratoria</h5>
        <p style="margin-top: -14px"><?= $SignosVitales['sv_fr'] ?> rpm</p>
        <h5 style="margin-top: -5">Oximetria</h5>
        <p style="margin-top: -15px"><?= $SignosVitales['sv_oximetria'] ?> % Sp0<sub>2</sub></p>
        <h5 style="margin-top: -5">Glucosa</h5>
        <p style="margin-top: -15px"><?= $SignosVitales['sv_dextrostix'] ?> mg/dl</p>
      </div>
      <div style="rotate: 90; position: absolute;margin-left: 50px;margin-top: 336px;text-transform: uppercase;font-size: 12px;">
        <?php $sqlEmpleadoSV = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
          'empleado_id' => $SignosVitales['empleado_id']
        ), 'empleado_nombre,empleado_apellidos')[0]; ?>
        <?php $sqlEmpleadoSV['empleado_nombre'] ?> <?php $sqlEmpleadoSV['empleado_apellidos'] ?> <?php $SignosVitales['sv_fecha'] ?> <?php $SignosVitales['sv_hora'] ?><br><br><br>
      </div>
      <div style="margin-left: 280px;margin-top: 980px">
        <barcode type="C128A" value="<?= $info['triage_id'] ?>" style="height: 40px;"></barcode>
      </div>
      <div style="position: absolute;top: 262px;;width: 500px;;left: 205px;font-size: 12px;text-transform: uppercase;text-align: center;font-weight: bold">
        <?= $notaEgreso['notas_tipo'] ?> DEL SERVICIO <?= mb_strtoupper($ServicioM[0]['especialidad_nombre'], 'UTF-8'); ?>
      </div>
    </div>
  </page_header>
  <div style="position:absolute; left: -10px; margin-top: -17px; font-size: 12px;">
    <h5 style="margin-bottom: -6px">MOTIVO DE EGRESO</h5>
    <?php switch ($notaEgreso['motivo_egreso']) {
      case '1':
        $motivoEgreso = 'Alta médica';
        break;
      case '2':
        $motivoEgreso = 'Alta voluntaria';
        break;
      case '3':
        $motivoEgreso = 'Alta por mejoría';
        break;
      case '4':
        $motivoEgreso = 'Alta por máximo beneficio';
        break;
      case '5':
        $motivoEgreso = 'Alta por tranferencia a otro centro hospitalario';
        break;
      case '6':
        $motivoEgreso = 'Alta por defunción';
        break;
      case '7':
        $motivoEgreso = 'Alta por fuga o abandono';
        break;
    } ?>
    <p class="contenido"><?= $motivoEgreso ?></p>
    <p class="contenido">
    <h5 style="margin-bottom: -6px">DIAGNÓSTICOS ENCONTRADOS</h5>
    <div class="table table-hover">
      <table class="table table-condensed">
        <thead>
          <tr>
            <th>Clave</th>
            <th>Diagnóstico de Ingreso</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($Diagnosticos as $value) {
            if ($value['tipodiag'] == 0) { ?>
              <tr>
                <td><?= $value['cie10_clave'] ?></td>
                <td><?= $value['cie10_nombre'] ?></td>
              </tr>
              <tr>
                <td></td>
                <td><?= $value['complemento'] ?></td>
              </tr>
          <?php }
          } ?>
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
          <?php foreach ($Diagnosticos as $value) {
            if ($value['tipodiag'] == 2) { ?>
              <tr>
                <td><?= $value['cie10_clave'] ?></td>
                <td><?= $value['cie10_nombre'] ?></td>
              </tr>
              <tr>
                <td></td>
                <td><?= $value['complemento'] ?> <!-- <?= $value['fecha_dx'] ?> --></td>
              </tr>
          <?php }
          } ?>
        </tbody>
      </table>
    </div>
    <div class="table table-hover">
      <table class="table table-condensed">
        <thead>
          <tr>
            <th>Clave</th>
            <th>Diagnóstico de Egreso</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($Diagnosticos as $value) {
            if ($value['tipodiag'] == 3) { ?>
              <tr>
                <td><?= $value['cie10_clave'] ?></td>
                <td><?= $value['cie10_nombre'] ?></td>
              </tr>
              <tr>
                <td></td>
                <td><?= $value['complemento'] ?> <!-- <?= $value['fecha_dx'] ?> --></td>
              </tr>
          <?php }
          } ?>
        </tbody>
      </table>
    </div>
    </p>
    
    <?php if ($notaEgreso['resumen_clinico_p1'] == '1') { ?>
      <h5 style="margin-bottom: -6px">RESUMEN CLÍNICO</h5>
      <p class="contenido"><?= $notaEgreso['resumen_clinico'] ?></p>
    <?php } ?>

    <?php if ($notaEgreso['exploracion_fisica_p1'] == '1') { ?>
      <h5 style="margin-bottom: -6px">EXPLORACIÓN FISICA</h5>
      <p class="contenido"><?= $notaEgreso['exploracion_fisica'] ?></p>
    <?php } ?>

    <?php if ($notaEgreso['laboratorios_p1'] == '1') { ?>
      <h5 style="margin-bottom: -6px">RESULTADOS DE LABORATORIO</h5>
      <p class="contenido"><?= $notaEgreso['laboratorios'] ?></p>
    <?php } ?>

    <?php if ($notaEgreso['gabinetes_p1'] == '1') { ?>
      <h5 style="margin-bottom: -6px">RESULTADO DE GABINETES</h5>
      <p class="contenido"><?= $notaEgreso['gabinetes'] ?></p>
    <?php } ?>


    <?php if ($notaEgreso['pronostico_p1'] == '1') { ?>
      <h5 style="margin-bottom: -6px">PRONOSTICO</h5>
      <p class="contenido"><?= $notaEgreso['pronostico'] ?></p>
    <?php } ?>

    <?php if ($notaEgreso['plan_p1'] == '1') { ?>
      <h5 style="margin-bottom: -6px">PLAN</h5>
      <p class="contenido"><?= $notaEgreso['plan'] ?></p>
    <?php } ?>

    <?php if ($notaEgreso['comentarios_p1'] == '1') { ?>
      <h5 style="margin-bottom: -6px"></h5>
      <p class="contenido"><?= $notaEgreso['comentarios'] ?></p>
    <?php } ?>
  </div>
</page>
<page backtop="80mm" backbottom="<?= $margenBajo ?>" backleft="9mm" backright="0mm">
  <page_header>
    <img src="<?= base_url() ?>assets/doc/DOC4301282.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">
    <div style="position: absolute;margin-top: 15px">
      <div style="position: absolute;margin-left: 435px;margin-top: 50px;width: 270px;text-transform: uppercase;font-size: 11px;text-align: left;">
        <b>NOMBRE DEL PACIENTE:</b>
      </div>
      <div style="position: absolute;margin-left: 435px;margin-top: 62px;width: 300px;text-transform: uppercase;font-size: 14px;">
        <?= $info['triage_nombre'] ?> <?= $info['triage_nombre_ap'] ?> <?= $info['triage_nombre_am'] ?>
      </div>
      <div style="position: absolute;margin-left: 435px;margin-top: 77px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>N.S.S:</b> <?= $PINFO['pum_nss'] ?> <?= $PINFO['pum_nss_agregado'] ?>
      </div>
      <?php $fecha = Modules::run('Config/ModCalcularEdad', array('fecha' => $info['triage_fecha_nac'])); ?>
      <div style="position: absolute;margin-left: 435px;margin-top: 92px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>EDAD:</b> <?= $fecha->y == 0 ? $fecha->m . ' MESES' : $fecha->y . ' AÑOS' ?>
      </div>
      <div style="position: absolute;margin-left: 550px;margin-top: 92px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>GENERO:</b> <?= $info['triage_paciente_sexo'] ?>
      </div>
      <div style="position: absolute;margin-left: 435px;margin-top: 107px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>UMF:</b> <?= $PINFO['pum_umf'] ?>/<?= $PINFO['pum_delegacion'] ?>
      </div>
      <div style="position: absolute;margin-left: 550px;margin-top: 107px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>PROCEDENCIA:</b> <?= $PINFO['pia_procedencia_espontanea'] == 'Si' ? 'ESPONTANEO' : 'REFERENCIADO' ?>
      </div>
      <div style="position: absolute;margin-left: 550px;margin-top: 122px;width: 270px;text-transform: uppercase;font-size: 11px;">
        <b>ATENCIÓN:</b> <?= $PINFO['pia_tipo_atencion'] ?>
      </div>
      <div style="position: absolute;margin-left: 437px;margin-top: 154px;width: 300px;text-transform: uppercase;font-size: 11px;">
        <p style="margin-top: -10px">
          <b>DOMICILIO: </b> <?= $DirPaciente['directorio_cn'] ?>, <?= $DirPaciente['directorio_colonia'] ?>, <?= $DirPaciente['directorio_cp'] ?>, <?= $DirPaciente['directorio_municipio'] ?>, <?= $DirPaciente['directorio_estado'] ?> <B>TEL:</B><?= $DirPaciente['directorio_telefono'] ?>
        </p>
      </div>
      <div style="position: absolute;margin-left: 437px;margin-top: 185px;width: 300px;text-transform: uppercase;font-size: 11px;">
        <p style="margin-top: -1px">
          <b>FOLIO:</b> <?= $info['triage_id'] ?>
        </p>
        <p style="margin-top: -10px">
          <b>FECHA DE INGRESO Y HORA CERO :</b> <?= date('d-m-Y', strtotime($info['triage_horacero_f'])) ?> <?= $info['triage_horacero_h'] ?>
        </p>
        <p style="margin-top: -7px">
          <b>CAMA:</b> <?= $infoCama['cama_nombre'] ?> - <?= $infoCama['piso_nombre_corto'] ?>
        </p>
        <p style="margin-top: -7px; left: 100px;">
          <b>INGRESO SERVICIO:</b> <?= $infoIngreso['fecha_ingreso'] ?>
        </p>
        <p style="margin-top: -9px">
          <b>TIEMPO DE ESTANCIA:</b> <?= $tiempo_estancia->d ?> dias <?= $tiempo_estancia->h ?> hrs <?= $tiempo_estancia->i ?> min.
        </p>
      </div>
      <div style="position: absolute;margin-top:238px;margin-left: 302px ">[[page_cu]]/[[page_nb]]</div>
      <div style="position: absolute;margin-top:222px;margin-left: 12px ">
        <?php
        $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info['triage_codigo_atencion']);
        echo ($codigo_atencion != '') ? "<b>" . mb_strtoupper("Código", 'UTF-8') . ": " . mb_strtoupper($codigo_atencion) . "</b>" : "";
        ?>
      </div>

      <div style="rotate: 90; position: absolute;margin-left: 50px;margin-top: 336px;text-transform: uppercase;font-size: 12px;">
        <?php $sqlEmpleadoSV = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
          'empleado_id' => $SignosVitales['empleado_id']
        ), 'empleado_nombre,empleado_apellidos')[0]; ?>
        <?php $sqlEmpleadoSV['empleado_nombre'] ?> <?php $sqlEmpleadoSV['empleado_apellidos'] ?> <?php $SignosVitales['sv_fecha'] ?> <?php $SignosVitales['sv_hora'] ?><br><br><br>
      </div>
      <div style="margin-left: 280px;margin-top: 980px">
        <barcode type="C128A" value="<?= $info['triage_id'] ?>" style="height: 40px;"></barcode>
      </div>
      <div style="position: absolute;top: 262px;;width: 500px;;left: 205px;font-size: 12px;text-transform: uppercase;text-align: center;font-weight: bold">
        <?= $notaEgreso['notas_tipo'] ?> DEL SERVICIO <?= mb_strtoupper($ServicioM[0]['especialidad_nombre'], 'UTF-8'); ?>
      </div>
    </div>
  </page_header>
  <div style="position:absolute; left: -10px; margin-top: -17px; font-size: 12px;">
    <?php if ($notaEgreso['resumen_clinico_p1'] == '2') { ?>
      <h5 style="margin-bottom: -6px">RESUMEN CLÍNICO</h5>
      <p class="contenido"><?= $notaEgreso['resumen_clinico'] ?></p>
    <?php } ?>

    <?php if ($notaEgreso['exploracion_fisica_p1'] == '2') { ?>
      <h5 style="margin-bottom: -6px">EXPLORACIÓN FISICA</h5>
      <p class="contenido"><?= $notaEgreso['exploracion_fisica'] ?></p>
    <?php } ?>

    <?php if ($notaEgreso['laboratorios_p1'] == '2') { ?>
      <h5 style="margin-bottom: -6px">RESULTADOS DE LABORATORIO</h5>
      <p class="contenido"><?= $notaEgreso['laboratorios'] ?></p>
    <?php } ?>

    <?php if ($notaEgreso['gabinetes_p1'] == '2') { ?>
      <h5 style="margin-bottom: -6px">RESULTADO DE GABINETES</h5>
      <p class="contenido"><?= $notaEgreso['gabinetes'] ?></p>
    <?php } ?>


    <?php if ($notaEgreso['pronostico_p1'] == '2') { ?>
      <h5 style="margin-bottom: -6px">PRONOSTICO</h5>
      <p class="contenido"><?= $notaEgreso['pronostico'] ?></p>
    <?php } ?>

    <?php if ($notaEgreso['plan_p1'] == '2') { ?>
      <h5 style="margin-bottom: -6px">PLAN</h5>
      <p class="contenido"><?= $notaEgreso['plan'] ?></p>
    <?php } ?>

    <?php if ($notaEgreso['comentarios_p1'] == '2') { ?>
      <h5 style="margin-bottom: -6px"></h5>
      <p class="contenido"><?= $notaEgreso['comentarios'] ?></p>
    <?php } ?>
  </div>
  <page_footer>
        <?php 
            $top = 935;
            $empleado_roles = explode(",",$_SESSION["empleado_roles"]);
            $mostrar_residentes = 0;
            for($i = 0;$i< count($empleado_roles);$i++){
              if($empleado_roles[$i] == "77"){
                    $mostrar_residentes = 1;
                    $top = 900;
                }
            } 
            ?>
            <div style="position: absolute;top: <?= $top ?>px;left: 30px;right: 5px;font-size: 10px; text-align:right;">
                <b>Dr. <?= $medicoTratante['empleado_apellidos'] ?> <?= $medicoTratante['empleado_nombre'] ?> médico Adscrito del servicio <?= $ServicioM[0]["especialidad_nombre"]?> MATRICULA: <?= $medicoTratante['empleado_matricula'] ?></b>
            </div>
            <?php if($mostrar_residentes == 1){
                if (!empty($residentes)) { ?>
                    <div style="position: absolute;top: <?=$top+15?>px;width:730px;right: 5px;font-size: 10px;text-align: right;">
                        <b>
                            <?php foreach ($residentes as $value){?>
                            Dr. <?=$value['apellido_residente']?>  <?=$value['nombre_residente']?> médico residente del servicio <?= $ServicioM[0]["especialidad_nombre"]?> Matricula <?=$value['cedulap_residente']?> Grado <?=$value['grado']?>;
                            <?php }?>  
                        </b>
                    </div>
        <?php }} ?>
    </page_footer>
</page>
<?php
$html =  ob_get_clean();
$pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8');
$pdf->writeHTML($html);
// // $pdf->pdf->IncludeJS("print(true);");
$pdf->pdf->SetTitle($Nota['notas_tipo']);
$pdf->Output($Nota['notas_tipo'] . '.pdf');
?>