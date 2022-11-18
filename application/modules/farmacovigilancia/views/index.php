<?= modules::run('Sections/Menu/index'); ?>
<style media="screen">
  .clic-box{
    cursor: pointer;
  }
  th, td{
    text-align: center;

  }

</style>
<div class="box-row">
  <div class="box-cell">
    <div class="box-inner col-md-12 col-centered" style="margin-top: 10px">
      <div class="panel panel-default">
        <div class="panel-heading back-imss" style="text-align: center; font-size: 15px;">
          Actividad del dia <?= date('d-m-Y') ?>
        </div>

        <div style="text-align: center; font-size: 160%;">
          <?php $url_color_estado = 'farmacovigilancia/Farmacologica/AsignarColorEstadoPrescripcion' ?>
          <div class="col-xs-4 clic-box btn_estado_prescripcion" data-value="1"  style="padding: 0px; background-color: <?=modules::run($url_color_estado,'1');?> ; color: rgb(140, 140, 102);">
            Pendientes <br> <?= count($Pendientes) ?>
          </div>
          <div class="col-xs-4 clic-box btn_estado_prescripcion"  data-value="2"  style="padding: 0px; background-color: <?=modules::run($url_color_estado,'2');?> ; color: green;">
            Activas <br> <?= count($Activas) ?>
          </div>
          <div class="col-xs-4 clic-box btn_estado_prescripcion"  data-value="0"  style="padding: 0px; background-color: <?=modules::run($url_color_estado,'0');?>; color: red;">
            Canceladas <br> <?= count($Canceladas) ?>
          </div>
        </div>

        <div class="row" style="padding-left: 35px; padding-right: 35px;">
          <div class="col-sm-3" style="margin-top:20px; margin-bottom: 20px;">
            <select name="" id="select_filtro" class="form-control">
            <option value="Todos">Todos</option>
            <option value="triage_id">Folio</option>
            <option value="triage_nombre">Paciente</option>
            <option value="cama_nombre">Cama</option>
            <option value="area_nombre">Area</option>
            <option value="empleado_nombre">Médico</option>
            <option value="medicamento">Medicamento</option>
          </select>
        </div>
          <div class="col-sm-9" style="margin-top:20px; margin-bottom: 20px;">
            <input type="text" class="form-control" id="input_busqueda" placeholder="Ingresar datos de busqueda" disabled>
          </div>
        </div>

        <div class="table-responsive" style="padding-left:36px; padding-right: 36px;">
          <table class="table table-hover table-condensed table-bordered"
                 id="tb_pacientes" >
            <thead>
              <tr>
                <th>Cama</th>
                <th>Paciente</th>
                <th>Medico</th>
                <th>Medicamento</th>
              </tr>
            </thead>
            <tbody id="tbl_paciente_prescripcion">
              <?php $contador = 0; ?>
              <?php foreach($PacientePrescripcionPendiente as $value){?>

                <tr class="fila_paciente" style="cursor: pointer" data-value="<?=$contador?>">
                  <td id="id_<?=$contador?>" style="background-color:<?=modules::run($url_color_estado,$value['estado']);?>;" ><?=$value['triage_id']?></td>
                  <td id="paciente_<?=$contador?>"><?=$value['triage_nombre'].' '.$value['triage_nombre_ap'] ?></td>
                  <td id="cama_<?=$contador?>"><?=$value['cama_nombre']?></td>
                  <td id="area_<?=$contador?>"><?=$value['area_nombre']?></td>
                  <td id="medico_<?=$contador?>"><?=$value['empleado_nombre'].' '.$value['empleado_apellidos']?></td>
                  <td id="medicamento_<?=$contador?>"><?=$value['medicamento']?></td>
                </tr>
              <?php $contador = $contador + 1; ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Farmacovigilancia.js?'). md5(microtime())?>" type="text/javascript"></script>
