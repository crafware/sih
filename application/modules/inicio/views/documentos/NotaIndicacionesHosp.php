<?php ob_start();
//El margen se modifica dependiendo el número de residentes en la nota
$margenBajo = "50mm";
if (count($Residentes) == 3) {
  $margenBajo = "78mm";
} else if (count($Residentes) == 2) {
  $margenBajo = "71mm";
} else if (count($Residentes) == 1) {
  $margenBajo = "60mm";
}
?>
<page backtop="80mm" backbottom="<?= $margenBajo ?>" backleft="5" backright="5mm">
  <page_header>
    <img src="<?= base_url() ?>assets/doc/DOC4301282.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">
    <div style="position: absolute;margin-top: 15px">
      <div style="position: absolute;margin-left: 435px;margin-top: 50px;width: 270px;text-transform: uppercase;font-size: 11px;text-align: left;">
        <b>NOMBRE DEL PACIENTE:</b>
      </div>
      <div style="position: absolute;margin-left: 435px;margin-top: 62px;width: 300px;text-transform: uppercase;font-size: 14px;">
        <?= $info['triage_nombre_ap'] ?> <?= $info['triage_nombre_am'] ?> <?= $info['triage_nombre'] ?>
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
          <b>HORA CERO:</b> <?= date('d-m-Y', strtotime($info['triage_horacero_f'])) ?> <?= $info['triage_horacero_h'] ?> hrs
        </p>

      </div>
      <div style="font-size: 10px; position: absolute;margin-top: 238px; margin-left: 13px ">

      </div>
      <div style="position: absolute;margin-top:238px;margin-left: 302px ">[[page_cu]]/[[page_nb]]</div>
      <div style="position: absolute;margin-top:222px;margin-left: 12px ">
        <?php
        $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info['triage_codigo_atencion']);
        echo ($codigo_atencion != '') ? "<b>" . mb_strtoupper("Código", 'UTF-8') . ": " . mb_strtoupper($codigo_atencion) . "</b>" : "";
        ?>
      </div>
      <div style="position: absolute;margin-left: 40px;margin-top: 290px;width: 270px;text-transform: uppercase;font-size: 12px;">
        <b><?= $Nota['notas_fecha'] ?> <?= $Nota['notas_hora'] ?></b><br>
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
        <?= $NotaIndicacion['notas_tipo'] ?> SERVICIO <?= mb_strtoupper($ServicioM[0]['especialidad_nombre'], 'UTF-8'); ?>
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
  <div style="position:absolute; left: 1px; margin-top: -10px; font-size: 12px;">
    <p style="font-weight: bold;margin-bottom: 1px">PLAN Y ORDENES MÉDICAS</p>
    <!--<p><?= print_r($nota) ?></p>-->
    <?php if ($plan['dieta'] == '0') {
      $nutricion = 'Ayuno';
    } else if ($plan['dieta'] == '1') {
      $nutricion = 'IB - Normal';
    } else if ($plan['dieta'] == '2') {
    } else if ($plan['dieta'] == '3') {
      $nutricion = 'IIB - Astringente';
    } else if ($plan['dieta'] == '4') {
      $nutricion = 'III - Diabetica';
    } else if ($plan['dieta'] == '5') {
      $nutricion = 'IV - Hiposodica';
    } else if ($plan['dieta'] == '6') {
      $nutricion = 'V - Hipograsa';
    } else if ($plan['dieta'] == '7') {
      $nutricion = 'VI - Liquida clara';
    } else if ($plan['dieta'] == '8') {
      $nutricion = 'VIA - Liquida general';
    } else if ($plan['dieta'] == '9') {
      $nutricion = 'VIB - Licuada por sonda';
    } else if ($plan['dieta'] == '10') {
      $nutricion = 'VIB - Licuada por sonda artesanal';
    } else if ($plan['dieta'] == '11') {
      $nutricion = 'VII - Papilla';
    } else if ($plan['dieta'] == '12') {
      $nutricion = 'VIII - Epecial';
    } else {
      $nutricion = $plan['dieta'];
    }
    ?>
    <!-- DIETA -->
    <p class="contenido"><b>Dieta:</b> <?= $nutricion ?> <?= $plan['dieta_indicaciones'] ?></p>

    <?php
    if ($plan['toma_signos_vitales'] == '1') {
      $toma_signos = 'Por turno';
    } else if ($plan['toma_signos_vitales'] == '2') {
      $toma_signos = 'Cada 4 horas';
    } else {
      $toma_signos = $plan['toma_signos_vitales'];
    }
    ?>
    <!-- SIGNBOS VITALES -->
    <p class="contenido"><b>Toma de Signos Vitales:</b> <?= $toma_signos ?></p>

    <?php if ($plan['cuidados_genfermeria'] == '1') { ?>
      <!-- CUIDADOS GENERALES DE ENFERMERIA -->
      <p class="contenido"><b>Cuidados Generales:</b><br>
        <label style="margin-left:20px;">a. Estado neurológico</label><br>
        <label style="margin-left:20px;">b. Cama Con barandales</label><br>
        <label style="margin-left:20px;">c. Calificación del dolor</label><br>
        <label style="margin-left:20px;">d. Calificación de riesgo de caida</label><br>
        <label style="margin-left:20px;">e. Control de liquidos por turno</label><br>
        <label style="margin-left:20px;">f. Vigilar riesgo de ulceras por presión</label><br>
        <label style="margin-left:20px;">g. Aseo bucal</label><br>
        <label style="margin-left:20px;">h. Lavado de manos</label>
      </p>
    <?php } ?>
    <!-- CUIDADOS ESPECIFICOS DE ENFERMERIA -->
    <?php if ($plan['cuidados_eenfermeria'] != '') { ?>
      <p style="font-weight: bold;margin-bottom: 1px">Cuidados Especificos de Enfermeria:</p>
      <p class="contenido"><?= $plan['cuidados_eenfermeria'] ?></p>
    <?php } ?>
    <!-- SOLUCIONES PARANTERALES -->
    <?php if ($plan['soluciones_parenterales'] != '') { ?>
      <p class="contenido"><b>Soluciones Parenterales:</b>
        <?= $plan['soluciones_parenterales'] ?></p>
    <?php } ?>

    <!-- Alergia a medicamentos -->
    <!-- <?php echo (count($AlergiaMedicamentos) > 0) ? '<h5 style="margin-bottom: -6px">ALERGIA A MEDICAMENTOS</h5>' : ''; ?>
            <?php for ($x = 0; $x < count($AlergiaMedicamentos); $x++) { ?>
              <?= ($x + 1) . ") " . $AlergiaMedicamentos[$x]['medicamento'] ?><br>
            <?php } ?> -->
    <!-- Fin alergia a medicamentos -->

    <!-- PRESCRIPCIÓN -->
    <?php if (!empty($Prescripcion)) { ?>
      <h5>Prescripción de Medicamentos</h5>
      <p class="contenido">
        <?php
        $observacion = "";
        $medicamento = "";

        for ($x = 0; $x < count($Prescripcion_Basico); $x++) {

          $observacion = $Prescripcion_Basico[$x]['observacion'];
          $medicamento = $Prescripcion_Basico[$x]['medicamento'];
          if ($medicamento === "OTRO") {
            $medicamento = substr($observacion, 0, strpos($observacion, "-"));
            $observacion = substr($observacion, (strpos($observacion, "-") + 1),  strlen($observacion));
          } ?>
          <strong><?= $x + 1 ?>) <?= $medicamento . " " . $Prescripcion_Basico[$x]['gramaje'] . " " . $Prescripcion_Basico[$x]['forma_farmaceutica'] ?>. </strong>
          Aplicar <?= $Prescripcion_Basico[$x]['dosis'] ?>
          via <?= strtolower($Prescripcion_Basico[$x]['via']); ?>,
          <?= ($Prescripcion_Basico[$x]['frecuencia'] == 'Dosis unica') ? '' : 'cada'; ?> <?= strtolower($Prescripcion_Basico[$x]['frecuencia']); ?>,
          en el siguiente horario: <?= $Prescripcion_Basico[$x]['aplicacion'] ?>.
          Iniciando el <?= $Prescripcion_Basico[$x]['fecha_inicio'] ?>
          hasta el <?= $Prescripcion_Basico[$x]['fecha_fin'] ?>.

          <?php if ($Prescripcion_Basico[$x]['observacion'] != 'Sin observaciones') { ?>
            <br><strong>Observación</strong>
            <?= $observacion ?>
          <?php } ?>
          <br><!-- Salto entre prescripciones -->
        <?php } /* Cierrre de ciclo for */ ?>
        <?= (count($Prescripcion_Onco_Anti) > 0) ? "<h5>Antimicrobiano</h5>" : ""; ?>
        <?php
        for ($x = 0; $x < count($Prescripcion_Onco_Anti); $x++) { ?>
          <strong><?= $x + 1 ?>) <?= $Prescripcion_Onco_Anti[$x]['medicamento'] . " " . $Prescripcion_Onco_Anti[$x]['gramaje'] . " " . $Prescripcion_Onco_Anti[$x]['forma_farmaceutica'] ?>.
          </strong>
          Aplicar <?= $Prescripcion_Onco_Anti[$x]['dosis'] ?>
          via <?= strtolower($Prescripcion_Onco_Anti[$x]['via']); ?>,
          <?= ($Prescripcion_Onco_Anti[$x]['frecuencia'] == 'Dosis unica') ? '' : 'cada'; ?> <?= strtolower($Prescripcion_Onco_Anti[$x]['frecuencia']); ?>,
          en el siguiente horario: <?= $Prescripcion_Onco_Anti[$x]['aplicacion'] ?>.
          Iniciando el <?= $Prescripcion_Onco_Anti[$x]['fecha_inicio'] ?>
          hasta el <?= $Prescripcion_Onco_Anti[$x]['fecha_fin'] ?>.
          <br>
          <strong>Diluyente: </strong><u>&nbsp; <?= $Prescripcion_Onco_Anti[$x]['diluente'] ?> &nbsp;</u>&nbsp;&nbsp;&nbsp;
          <strong>Vol. Diluyente: </strong><u>&nbsp; <?= $Prescripcion_Onco_Anti[$x]['vol_dilucion'] ?> ml.&nbsp;</u>

          <?php if ($Prescripcion_Onco_Anti[$x]['observacion'] != 'Sin observaciones') { ?>
            <br><strong>Observación</strong>
            <?= $Prescripcion_Onco_Anti[$x]['observacion'] ?>
          <?php } ?>
          <br>
        <?php } /* Cierre de ciclo for */ ?>

        <?= (count($Prescripcion_NPT) > 0) ? "<h5>Nutrición Parenteral Total</h5>" : ""; ?>

        <?php
        for ($x = 0; $x < count($Prescripcion_NPT); $x++) { ?>
          <strong><?= $x + 1 ?>) <?= $Prescripcion_NPT[$x]['medicamento'] . " " . $Prescripcion_NPT[$x]['gramaje'] . " " . $Prescripcion_NPT[$x]['forma_farmaceutica'] ?>.
          </strong>
          Aplicar <?= $Prescripcion_NPT[$x]['dosis'] ?>
          via <?= strtolower($Prescripcion_NPT[$x]['via']); ?>,
          <?= ($Prescripcion_NPT[$x]['frecuencia'] == 'Dosis unica') ? '' : 'cada'; ?> <?= strtolower($Prescripcion_NPT[$x]['frecuencia']); ?>,
          en el siguiente horario: <?= $Prescripcion_NPT[$x]['aplicacion'] ?>.
          Iniciando el <?= $Prescripcion_NPT[$x]['fecha_inicio'] ?>
          hasta el <?= $Prescripcion_NPT[$x]['fecha_fin'] ?>.
          <br>
          <?php $totalvol = ($Prescripcion_NPT[$x]['aminoacido'] +
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
          <strong>OVERFILL:</strong><u>&nbsp; 20 &nbsp;</u>&nbsp;&nbsp;&nbsp;<strong>Vol. Total:</strong><u>&nbsp; <?= $totalvol ?> &nbsp;</u>
          <br>
          <!-- Consultar bases -->
          <?php if (
            $Prescripcion_NPT[$x]['aminoacido'] > 0 ||
            $Prescripcion_NPT[$x]['dextrosa'] > 0 ||
            $Prescripcion_NPT[$x]['lipidos'] > 0 ||
            $Prescripcion_NPT[$x]['agua_inyect'] > 0
          ) { ?>
            <br>
            Solucion Base
            <br>
            <?= ($Prescripcion_NPT[$x]['aminoacido'] > 0) ? '<div>Aminoácidos Cristalinos 10% adulto <u>&nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['aminoacido'] . ' ml &nbsp;&nbsp;</u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['dextrosa'] > 0) ? '<div>Dextrosa al 50% <u>&nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['dextrosa'] . ' ml &nbsp;&nbsp;</u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['lipidos'] > 0) ? '<div>Lipdiso Intravenosos con Acidos grasos, Omega 3 y 9 <u>&nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['lipidos'] . ' ml &nbsp;&nbsp;</u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['agua_inyect'] > 0) ? '<div>Agua Inyectable <u>&nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['agua_inyect'] . ' ml &nbsp;&nbsp;</u></div>' : '' ?>

          <?php } ?>

          <!-- Consultar sales -->
          <?php if (
            $Prescripcion_NPT[$x]['cloruro_sodio'] > 0 ||
            $Prescripcion_NPT[$x]['sulfato'] > 0 ||
            $Prescripcion_NPT[$x]['cloruro_potasio'] > 0 ||
            $Prescripcion_NPT[$x]['fosfato'] > 0 ||
            $Prescripcion_NPT[$x]['gluconato'] > 0
          ) { ?>
            <br>
            Sales
            <br>
            <?= ($Prescripcion_NPT[$x]['cloruro_sodio'] > 0) ? '<div>Cloruro de Sodio 17.7% (3mEq/ml Na) <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['cloruro_sodio'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['sulfato'] > 0) ? '<div>Sulfato de Magnesio (0.81) mEq/ml <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['sulfato'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['cloruro_potasio'] > 0) ? '<div>Cloruro de Potasio (4 mEeq/ml K) <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['cloruro_potasio'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['fosfato'] > 0) ? '<div>Fosfato de Potasio (2 mEq/ml k/1.11 m mol PO4) <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['fosfato'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['gluconato'] > 0) ? '<div>Gluconato de Calcio (0.465 mEq/ml) <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['gluconato'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
          <?php } ?>

          <!-- Consultar aditivos -->
          <?php if (
            $Prescripcion_NPT[$x]['albumina'] > 0 ||
            $Prescripcion_NPT[$x]['heparina'] > 0 ||
            $Prescripcion_NPT[$x]['insulina'] > 0 ||
            $Prescripcion_NPT[$x]['zinc'] > 0 ||
            $Prescripcion_NPT[$x]['mvi'] > 0 ||
            $Prescripcion_NPT[$x]['oligoelementos'] > 0 ||
            $Prescripcion_NPT[$x]['vitamina'] > 0
          ) { ?>
            <br>
            Aditivos:
            <br>
            <?= ($Prescripcion_NPT[$x]['albumina'] > 0) ? '<div>Albúmina 20% (0.20 g/ml): <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['albumina'] . ' gr &nbsp;&nbsp; </u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['heparina'] > 0) ? '<div>Heparina (1000 UI/ml): <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['heparina'] . ' UI &nbsp;&nbsp; </u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['insulina'] > 0) ? '<div>Insulina Humana (100 UI/ml): <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['insulina'] . ' UI &nbsp;&nbsp; </u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['zinc'] > 0) ? '<div>Zinc: <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['zinc'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['mvi'] > 0) ? '<div>MVI - Adulto <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['mvi'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['oligoelementos'] > 0) ? '<div>Oligoelementos Tracefusin <u> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['oligoelementos'] . ' ml &nbsp;&nbsp; </u></div>' : '' ?>
            <?= ($Prescripcion_NPT[$x]['vitamina'] > 0) ? '<div>Vitamina C (100 mg/ml) <u style="float:right;"> &nbsp;&nbsp; ' . $Prescripcion_NPT[$x]['vitamina'] . ' mg &nbsp;&nbsp; </u></div>' : '' ?>

          <?php } ?>

          <?php if ($Prescripcion_NPT[$x]['observacion'] != 'Sin observaciones') { ?>
            <br><strong>Observación</strong>
            <?= $Prescripcion_NPT[$x]['observacion'] ?><br>
          <?php } ?>
          <br>
        <?php } /* Cierre de ciclo for */ ?>
      </p>
    <?php } ?>
    <!-- Fin prescripcion -->



    <?php if (count($Interconsultas) > 0) { ?>
      <h5 style="margin-bottom: -6px">INTERCONSULTAS SOLICITADAS</h5>
      <table>
        <tr>
          <td>Servicio(s) solicitado(s):</td>
          <td>
            <?php for ($x = 0; $x < count($Interconsultas); $x++) {
              $y = $x + 1;
              $separacion = ($y == $num_interconsultas) ? "." : ", "; ?>
              <?= $Interconsultas[$x]['especialidad_nombre'] . $separacion ?>

            <?php } ?>
          </td>
        </tr>
        <tr>
          <td>Motivo interconsulta:</td>
          <td><?= $Interconsultas[0]['motivo_interconsulta'] ?></td>
        </tr>
      </table>
    <?php } ?>
    <!--<p>
           <br /><br /><br /><br /><br /><br /><br />
        </p>-->
  </div>
  <page_footer>
    <?php
    $top = 935;
    $empleado_roles = explode(",", $_SESSION["empleado_roles"]);
    $mostrar_residentes = 0;
    for ($i = 0; $i < count($empleado_roles); $i++) {
      if ($empleado_roles[$i] == "77") {
        $mostrar_residentes = 1;
        $top = 900;
      }
    }
    ?>
    <div style="position: absolute;top: <?= $top ?>px;left: 30px;right: 5px;font-size: 10px; text-align:right;">
      <b>Dr. <?= $medicoTratante['empleado_apellidos'] ?> <?= $medicoTratante['empleado_nombre'] ?> médico Adscrito del servicio <?= $Servicio["especialidad_nombre"] ?> MATRICULA: <?= $medicoTratante['empleado_matricula'] ?></b>
    </div>
    <?php if ($mostrar_residentes == 1) {
      if (!empty($residentes)) { ?>
        <div style="position: absolute;top: <?= $top + 15 ?>px;width:730px;right: 5px;font-size: 10px;text-align: right;">
          <b>
            <?php foreach ($residentes as $value) { ?>
              Dr. <?= $value['apellido_residente'] ?> <?= $value['nombre_residente'] ?> médico residente del servicio <?= $ServicioM["especialidad_nombre"] ?> Matricula <?= $value['cedulap_residente'] ?> Grado <?= $value['grado'] ?>;
            <?php } ?>
          </b>
        </div>
    <?php }
    } ?>
  </page_footer>
</page>
<?php
$html =  ob_get_clean();
$pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8');
$pdf->writeHTML($html);
// $pdf->pdf->IncludeJS("print(true);");
$pdf->pdf->SetTitle($NotaInterconsulta['notas_tipo']);
$pdf->Output($NotaInterconsulta['notas_tipo'] . '.pdf');

?>