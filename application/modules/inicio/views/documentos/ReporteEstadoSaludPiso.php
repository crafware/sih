<?php ob_start(); ?>
<page backtop="43mm" backbottom="20mm" backleft="5" backright="5mm">
  <page_header>
    <div style="position: absolute;margin-top: 15px">
      <img src="<?= base_url() ?>assets/img/logo.png" style="position: absolute;width: 85px;margin-top: 0px;margin-left: 0px;">
      <div style="position: absolute;margin-left: 370px;margin-top: 0px;width: 670px;text-transform: uppercase;font-size: 11px;text-align: left;">
        <h4>INSTITUTO MEXICANO DEL SEGURO SOCIAL</h4>
      </div>
      <div style="position: absolute;margin-left: 485px;margin-top: 20px;width: 600px;text-transform: uppercase;font-size: 14px;">
        <h4>CENSO DIARIO</h4>
      </div>
      <div style="position: absolute;margin-left: 0px;margin-top: 105px;width: 470px;text-transform: uppercase;font-size: 11px;">
        <b>UNIDAD MEDICA: UMAE ESPECIALIDADES "DR. BERNARDO SEPULVEDA G."</b>
      </div>
      <div style="position: absolute;margin-left: 440px;margin-top: 105px;width: 470px;text-transform: uppercase;font-size: 11px;">
        <b><?= $piso["piso_nombre"] ?></b>
      </div>
      <?php if ($especialidad_nombre != null) { ?>
        <div style="position: absolute;margin-left: 510px;margin-top: 105px;width: 470px;text-transform: uppercase;font-size: 11px;">
          <b>SERVICIO: <?= $especialidad_nombre['especialidad_nombre'] ?></b>
        </div>
      <?php } ?>
      <?php if ($numero_camas != null) { ?>
        <div style="position: absolute;margin-left: 700px;margin-top: 105px;width: 470px;text-transform: uppercase;font-size: 11px;">
          <b>NUMERO DE CAMAS AUTORIZADAS: <?= $data["numero_camas"] ?></b>
        </div>
      <?php } ?>
      <div style="position: absolute;margin-left: 0px;margin-top: 125px;width: 770px;text-transform: uppercase;font-size: 11px;">
        <b>FECHA: <?= $data["hoy"] ?> DE LAS 0:00 HORAS A LAS 24:00 HORAS</b>
      </div>
      <div style="position: absolute;margin-left: 950px;margin-top: 125px;width: 770px;text-transform: uppercase;font-size: 11px;">
        <b>TURNO: <?= Modules::run('Config/ObtenerTurno') ?></b>
      </div>
      <!--<p>print_r($page_cu)</p>
      <p><?php print_r($page_cu)?></p>
      <p><?php echo $page_cu ?></p>
      <p><?php echo gettype($page_cu) ?></p>
      <p><?php echo var_dump($page_cu) ?></p>
      <p>print_r($page_nb)</p>
      <p><?php print_r($page_nb)?></p>
      <p><?php echo $page_nb ?></p>
      <p><?php echo gettype($page_nb) ?></p>
      <p><?php echo var_dump($page_nb) ?></p>-->
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

    td,
    th {
      text-align: center;
    }

    table,
    td,
    tr {
      border: 1px solid black;
      border-collapse: collapse;
    }

    p {
      margin: 0%;
    }

    .page_footer_tr {
      border: 0px solid black;
      border-collapse: collapse;
      text-align: left;
    }

    .page_footer_tr_res {
      border: 0px solid black;
      border-collapse: collapse;
      text-align: center;
    }

    .delete_celda {
      border: 0px solid black;
    }

    .division_celda_1 {
      border-right: 1px solid blac;
    }

    .division_celda_2 {
      border-left: 1px solid blac;
    }
  </style>

  <div style="position: absolute;margin-left: -20px;margin-top: 0px;width: 770px;font-size: 10px;">
    <table style="table-layout: fixed;width: 880px;">
      <tr>
        <th colspan="4" style="border: 1px solid black;border-collapse: collapse;">
          <p>I N G R E S O S</p>
        </th>
        <th style="border-right: solid;"></th>
        <th colspan="4" style="border: 1px solid black;border-collapse: collapse;">
          <p>E G R E S O S</p>
        </th>
      </tr>
      <tr>
        <td style="width:3%">
          <p>HORA</p>
        </td>
        <td style="width:3%">
          <p>CAMA</p>
        </td>
        <td style="width:30%">
          <p>NOMBRE</p>
        </td>
        <td style="width:20%">
          <p>OBSERVACIONES</p>
        </td>
        <td class="page_footer_tr" style="border-right:1px solid blac;width:2%;">
        </td>
        <td style="width:3%">
          <p>HORA</p>
        </td>
        <td style="width:3%">
          <p>CAMA</p>
        </td>
        <td style="width:30%">
          <p>NOMBRE</p>
        </td>
        <td style="width:20%">
          <p>OBSERVACIONES</p>
        </td>
      </tr>
      <?php
      $divisionStyle = "border-right:1px solid blac;";
      //$ingresos = array_slice($ingresos, 0, 4);
      for ($y = 0; $y < 2; $y++) {
      for ($x = 0; $x < max(count($ingresos), count($egresos)); $x++) {
        if (count($ingresos) == $x) {
          $classTablaIngresos = "delete_celda";
        }
        if (count($egresos) == $x) {
          $classTablaEgresos = "delete_celda";
          $divisionStyle = "";
        }
      ?>
        <tr>
          <td class="<?= $classTablaIngresos ?>">
            <p><?= $ingresos[$x]["hora_ingreso"] ?></p>
          </td>
          <td class="<?= $classTablaIngresos ?>">
            <p><?= $ingresos[$x]["cama_nombre"] ?></p>
          </td>
          <td class="<?= $classTablaIngresos ?>">
            <p><?= $ingresos[$x]["nombre"] ?></p>
          </td>
          <td class="<?= $classTablaIngresos ?>"  style="width: 200px">
            <p style="margin: 0px 0px 0px -0px;text-align: left;">
              <?php if ($ingresos[$x]["tipo_ingreso"] != null) {; ?>
                Ing: <?= $ingresos[$x]["tipo_ingreso"] ?>
              <?php } ?>
              <?php if ($ingresos[$x]["especialidad_nombre"] != null) {; ?>
                Esp: <?= $ingresos[$x]["especialidad_nombre"] ?>
              <?php } ?>
              <?php if ($ingresos[$x]["Cam"] != null) {; ?>
                <?= str_replace(" de Cama ", ":", $ingresos[$x]["Cam"]) ?>
              <?php } ?>
            </p>
          </td>
          <td class="page_footer_tr_res" style="<?= $divisionStyle ?>"></td>
          <td class="<?= $classTablaEgresos ?>">
            <p><?= $egresos[$x]["hora_egreso"] ?></p>
          </td>
          <td class="<?= $classTablaEgresos ?>">
            <p><?= $egresos[$x]["cama_nombre"] ?></p>
          </td>
          <td class="<?= $classTablaEgresos ?>">
            <p><?= $egresos[$x]["paciente_nombre"] ?></p>
          </td>
          <td class="<?= $classTablaEgresos ?>" style="width: 200px">
            <p style="margin: 0px 0px 0px -0px;text-align: left;">
              <?php if ($egresos[$x]["tipo_ingreso"] != null) {; ?>
                Ing: <?= $egresos[$x]["tipo_ingreso"] ?>
              <?php } ?>
              <?php if ($egresos[$x]["especialidad_nombre"] != null) {; ?>
                Esp: <?= $egresos[$x]["especialidad_nombre"] ?>
              <?php } ?>
              <?php if ($egresos[$x]["Cam"] != null) {; ?>
                <?= str_replace(" de Cama ", ":", $egresos[$x]["Cam"]) ?>
              <?php } ?>
            </p>
          </td>
        </tr>
      <?php } ?>
      <?php } ?>
    </table>
  </div>
  <?php if ($page_cu == $page_nb) { ?>
    <page_footer>
      <div style="position: absolute;margin-left: 0px;margin-top: 680px;width: 770px;">
        <table>
          <tr>
            <td style="width:620px; height:55px">
            </td>
          </tr>
        </table>
      </div>
      <div style="position: absolute;margin-left: 10px;margin-top: 690px;width: 770px;font-size: 9px;">
        <table>
          <tr>
            <td class="page_footer_tr">
              <p>EXISTENCIA ANTERIOR DE PACIENTES</p>
            </td>
            <td class="page_footer_tr">
              <p>___________________</p>
            </td>
            <td class="page_footer_tr">
              <p>EXISTENCIA ACTUAL DE PACIENTES</p>
            </td>
            <td class="page_footer_tr_res">
              <p><?= $data["pacientes_actuales"] ?></p>
            </td>
          </tr class="page_footer_tr">
          <tr>
            <td class="page_footer_tr">
              <p>Ingresos</p>
            </td>
            <td class="page_footer_tr_res">
              <p><?= count($ingresos) ?></p>
            </td>
            <td class="page_footer_tr">
              <p>Número de pacientes ingresados y egresados el mismo dia</p>
            </td>
            <td class="page_footer_tr_res">
              <p><?= $data["pacientes_Ing_Egr_dia"] ?></p>
            </td>
          </tr>
          <tr>
            <td class="page_footer_tr">
              <p>SUMA</p>
            </td>
            <td class="page_footer_tr">
              <p>___________________</p>
            </td>
            <td class="page_footer_tr">
              <p></p>
            </td>
            <td class="page_footer_tr">
              <p></p>
            </td>
          </tr>
          <tr>
            <td class="page_footer_tr">
              <p>Egresos</p>
            </td>
            <td class="page_footer_tr_res">
              <p><?= count($egresos) ?></p>
            </td>
            <td class="page_footer_tr">
              <p>TOTAL DIAZ PACIENTES</p>
            </td>
            <td class="page_footer_tr">
              <p>___________________</p>
            </td>
          </tr>
        </table>
      </div>
      <?php if($data["camas_vacias"] != null){ ?>
        <div style="position: absolute;margin-left: 700px;margin-top: 680px;width: 100px;font-size: 9px;">
          <table>
            <tr>
              <td class="page_footer_tr">
                <p>NUMERO DE CAMAS VACIAS <?= $data["camas_vacias"] ?></p>
              </td>
            </tr>
          </table>
        </div>
      <?php } ?>
      <div style="position: absolute;margin-left: 700px;margin-top: 707px;width: 300px;font-size: 12px;">
        <P><?= $empleado["empleado_apellidos"]?> <?= $empleado["empleado_nombre"]?></P>
        <p>---------------------------------------------------------</p>
        <p>NOMBRE Y FIRMA DE LA JEFE DE PISO</p>
      </div>
    </page_footer>
  <?php } ?>
</page>
<?php
$html =  ob_get_clean();
$pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8');
$pdf->writeHTML($html);
if ($pdf->pdf->getPage() == 1) {
  $pdf->writeHTML('<page pageset="old"></page>');
};
$pdf->pdf->SetTitle("INFORME DE ESTADO DE SALUD DE PACIENTES HOSPITALIZADOS");
$pdf->Output('INFORME DE ESTADO DE SALUD DE PACIENTES HOSPITALIZADOS.pdf');
?>