<?php ob_start(); ?>
<page backtop="43mm" backbottom="20mm" backleft="5" backright="5mm">
  <page_header>
    <div style="position: absolute;margin-top: 15px">
      <img src="<?= base_url() ?>assets/img/logo.png" style="position: absolute;width: 85px;margin-top: 0px;margin-left: 0px;">
      <div style="position: absolute;margin-left: 200px;margin-top: 0px;width: 670px;text-transform: uppercase;font-size: 11px;text-align: left;">
        <h4>INSTITUTO MEXICANO DEL SEGURO SOCIAL</h4>
      </div>
      <div style="position: absolute;margin-left: 200px;margin-top: 20px;width: 470px;text-transform: uppercase;font-size: 11px;">
        <h5> UMAE ESPECIALIDADES "DR. BERNARDO SEPULVEDA G."</h5>
      </div>
      <div style="position: absolute;margin-left: 220px;margin-top: 40px;width: 600px;text-transform: uppercase;font-size: 14px;">
        <h4>CENTRO MEDICO NACIONAL SIGLO XXI</h4>
      </div>
      <div style="position: absolute;margin-left: 120px;margin-top: 60px;width: 600px;text-transform: uppercase;font-size: 14px;">
        <h4>INFORME DE ESTADO DE SALUD DE PACIENTES HOSPITALIZADOS</h4>
      </div>
      <?php if ($piso["piso_nombre"] != null) { ?>
        <div style="position: absolute;margin-left: 440px;margin-top: 105px;width: 470px;text-transform: uppercase;font-size: 11px;">
          <b><?= $piso["piso_nombre"] ?></b>
        </div>
      <?php } ?>
      <div style="position: absolute;margin-left: 0px;margin-top: 105px;width: 770px;text-transform: uppercase;font-size: 11px;">
        <b>FECHA: <?= $data["hoy"] ?></b>
      </div>
      <div style="position: absolute;margin-left: 0px;margin-top: 125px;width: 770px;text-transform: uppercase;font-size: 11px;">
        <b>ASISTENTE MEDICO: <?= $asistente["empleado_apellidos"]?> <?= $asistente["empleado_nombre"]?></b>
      </div>
      <div style="position: absolute;margin-left: 440px;margin-top: 125px;width: 770px;text-transform: uppercase;font-size: 11px;">
        <b>TURNO: <?= Modules::run('Config/ObtenerTurno') ?></b>
      </div>
      <?php if ($especialidad != null) { ?>
        <div style="position: absolute;margin-left: 440px;margin-top: 105px;width: 470px;text-transform: uppercase;font-size: 11px;">
          <b>SERVICIO: <?= $especialidad['especialidad_nombre'] ?></b>
        </div>
      <?php } ?>
      <?php if ($numero_camas != null) { ?>
        <div style="position: absolute;margin-left: 700px;margin-top: 105px;width: 470px;text-transform: uppercase;font-size: 11px;">
          <b>NUMERO DE CAMAS AUTORIZADAS: <?= $data["numero_camas"] ?></b>
        </div>
      <?php } ?>
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
    th,
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
  </style>

  <div style="position: absolute;margin-left: -20px;margin-top: 0px;width: 700px;font-size: 10px;">
    <table style="table-layout: fixed;width: 880px;">
      <tr>
        <th style="width:4%">
          <p>CAMA</p>
        </th>
        <th style="width:28%">
          <p>NOMBRE</p>
        </th>
        <th style="width:15%">
        <?php if($piso["piso_nombre"] != null){ ?>
          <p>SERVICIO</p>
        <?php } else{ ?>
          <p>PISO</p>
        <?php } ?>
        </th>
        <th style="width:8%">
          <p>ESTADO DE SALUD</p>
        </th>
        <th style="width:28%">
          <p>MEDICO</p>
        </th>
      </tr>
      <?php
        $divisionStyle = "border-right:1px solid blac;";
        for ($x = 0; $x < count($ingresos); $x++) {
      ?>
        <tr>
          <td class="<?= $classTablaIngresos ?>">
            <p><?= $ingresos[$x]["cama_nombre"] ?></p>
          </td>
          <td class="<?= $classTablaIngresos ?>">
            <p><?= $ingresos[$x]["nombre"] ?></p>
          </td>
          <?php if($piso["piso_nombre"] != null){ ?>
            <td class="<?= $classTablaIngresos ?>">
              <p> <?= $ingresos[$x]["especialidad_nombre"] ?> </p>
            </td>
          <?php } ?>
          <?php if($piso["piso_nombre"] == null){ ?>
            <td class="<?= $classTablaIngresos ?>">
              <p> <?= $ingresos[$x]["piso_nombre"] ?> </p>
            </td>
          <?php } ?>
          <td class="<?= $classTablaEgresos ?>">
            <p><?= $ingresos[$x]["estado_salud"] ?></p>
          </td>
          <td class="<?= $classTablaEgresos ?>">
            <p><?= $ingresos[$x]["medico"] ?></p>
          </td>
        </tr>
      <?php } ?>
      <tr>
        <th colspan="5" style="border-top:1px solid blac; border-bottom:1px solid blac; border-left:1px solid blac; border-collapse: collapse; width:3%">
          <p>EGRESOS</p>
        </th>
      </tr>
      <?php
        $divisionStyle = "border-right:1px solid blac;";
        for ($x = 0; $x < count($egresos); $x++) {
      ?>
        <tr>
          <td class="<?= $classTablaIngresos ?>">
            <p><?= $egresos[$x]["cama_nombre"] ?></p>
          </td>
          <td class="<?= $classTablaIngresos ?>">
            <p><?= $egresos[$x]["nombre_paciente"] ?></p>
          </td>
          <?php if($piso["piso_nombre"] != null){ ?>
            <td class="<?= $classTablaIngresos ?>">
              <p> <?= $egresos[$x]["especialidad_nombre"] ?> </p>
            </td>
          <?php } ?>
          <?php if($egresos[$x]["piso_nombre"] != null){ ?>
            <td class="<?= $classTablaIngresos ?>">
              <p> <?= $egresos[$x]["piso_nombre"] ?> </p>
            </td>
          <?php } ?>
          <td colspan="2" class="<?= $classTablaEgresos ?>">
            <p><?= $egresos[$x]["nombre_motivo_egreso"] ?></p>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>
</page>
<?php
$html =  ob_get_clean();
$pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8');
$pdf->writeHTML($html);
$pdf->pdf->SetTitle("INFORME DE ESTADO DE SALUD DE PACIENTES HOSPITALIZADOS");
$pdf->Output('INFORME DE ESTADO DE SALUD DE PACIENTES HOSPITALIZADOS.pdf');
?>