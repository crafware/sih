<?php
function getServerIp()
{
  if ($_SERVER['SERVER_ADDR'] === "::1") {
    return "localhost";
  } else {
    return $_SERVER['SERVER_ADDR'];
  }
}
?>
<?= modules::run('Sections/Menu/index'); ?>
<link rel="stylesheet" href="<?= base_url() ?>assets/styles/typeahead.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/jodit-3.2.43/build/jodit.min.css" />
<style>
  td {
    padding: 1px 2px;
    border-top: 1px solid #e7e8ea;
  }
</style>
<div class="col-md-12 col-centered" style="margin-top: -10px">

  <div class="box-inner">
    <div class="panel panel-default ">
      <div class="panel-body b-b b-light">
        <div class="card-body" style="padding: 20px 0px;">
          <h1><i class="fa fa-file-text-o"></i> Intervenciones y Procedimientos Quirurgicos</h1>
        
          <div class="panel-body b-b b-light">
            <div class="row">
              <div class="panel-heading p bg-white text-center">
                <div class="row">
                  <div style="position: relative;">
                    <div style="margin-left: -1px;position: absolute;">
                      <?php
                      if ($info['triage_paciente_sexo'] == "MUJER") {
                        $paciente_sexo = "icono-mujer-2.png";
                      } else {
                        $paciente_sexo = "patient_m.png";
                      }
                      ?>
                      <img src="<?= base_url() ?>assets/img/patients/<?= $paciente_sexo ?>" style="width: 90px;" />
                    </div>
                  </div>
                  <div class="col-xs-5 col-sm-5 text-left" style="padding-left: 85px">
                    <div class="col-xs-12 col-sm-12 col-md-12" style="width:420px; height:130px">
                      <h5 class="text-color-cyan" style="position:relative;top:-1px;left:1px">
                        <b><?= $info['triage_nombre_ap'] ?> <?= $info['triage_nombre_am'] ?> <?= $info['triage_nombre'] ?></b>
                      </h5>
                      <?php
                      if ($info['triage_fecha_nac'] != '') {
                        $fecha = Modules::run('Config/ModCalcularEdad', array('fecha' => $info['triage_fecha_nac']));
                        $edad =  '<b>de' . ' ' . $fecha->y . ' años</b>';
                      } else $edad = "<b>desconocido</b>";
                      ?>
                      <h5 class="text-color-black" style="position:relative;top:-7px;left:1px">
                        <b><?= ucwords(strtolower($info['triage_paciente_sexo'])); ?> <?= $edad ?>
                          <?= $PINFO['pic_indicio_embarazo'] == 'Si' ? '|   Posible Embarazo' : '' ?>
                        </b>
                      </h5>
                      <h5 class="text-color-blue" style="position:relative;top:-10px;left: 1px">
                        <b>NSS: <?= $PINFO['pum_nss'] ?>-<?= $PINFO['pum_nss_agregado'] ?></b>
                      </h5>
                      <div style="position:relative;top:-15px;left:1px">
                        <h5 class="text-color-black">
                          <b>CAMA:</b> <?= $cama['cama_nombre'] ?>-<?= $cama['piso_nombre_corto'] ?>
                        </h5>
                      </div>
                      <div style="position:relative;top:-15px;left:1px">
                        <h5 class="text-color-black">
                          <b>FOLIO:</b><?= $info['triage_id'] ?>
                        </h5>
                      </div>
                      <div style="position:relative;top:-15px;left:1px">
                        <h5 class="text-color-black">
                          <b>Número Seguro Social:</b> <?= $cama['cama_nombre'] ?>-<?= $cama['piso_nombre_corto'] ?>
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>

            <div class="panel-body b-b b-light">
              <div class="row">
                <div class="col-md-12">
                  <table class="table footable table-bordered" data-filter="#filter" id="tabla1">
                    <thead>
                      <tr>
                        <th style="padding: 1px 2px;" id="noFolio" data-type="numeric" data-sort-initial="true" class="footable-first-column footable-sortable footable-sorted">No.</th>
                        <th style="padding: 1px 2px;">FECHA DE SOLICITUD.</th>
                        <th style="padding: 1px 2px;">HORA SOLICITUD.</th>
                        <th style="padding: 1px 2px;">FECHA ORDEN.</th>
                        <th style="padding: 1px 2px;">DIAGNOSTICO PREOPERATORIO.</th>
                        <th style="padding: 1px 2px;">Cie 9</th>
                        <th style="padding: 1px 2px;">Nombre del Médico Tratante</th>
                        <th style="padding: 1px 2px;">ACCIONES</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $cont = 0;
                      foreach ($solicitudes as $value) {
                        ++$cont;
                        $doctor = "";
                        foreach ($MedicosBase as $v) {
                          if ($value['empleado_matricula'] == $v['empleado_matricula']) {
                            $doctor =  $v['empleado_nombre'] . " " . $v['empleado_apellidos'];
                            break;
                          }
                        }
                      ?>
                        <tr>
                          <td style="padding: 1px 2px;"><?= $cont ?></td>
                          <td style="padding: 1px 2px;"><?= date("d-m-Y", strtotime($value['fecha_solicitud'])) ?></td>
                          <td style="padding: 1px 2px;"><?= $value['hora_solicitud'] ?> </td>
                          <td style="padding: 1px 2px;"><?= $value['fecha_orden'] ?></td>
                          <td style="padding: 1px 2px;"><?= $value['diagnostico_preoperatorio'] ?></td>
                          <td style="padding: 1px 2px;"><?= $value['nombre'] ?></td>
                          <td style="padding: 1px 2px;"><?= $doctor ?></td>
                          <td style="padding: 1px 2px;">
                            <i class="fa fa-pencil icono-accion tip editSolicitud" data-cont=<?= $cont ?> data-original-title="Editar datos"></i>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot class="hide-if-no-paging">
                      <tr>
                        <td colspan="18" class="text-center">
                          <ul class="pagination"></ul>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="col-md-12" id="tabla123"></div>
              </div>
            </div>
<!--
            <div class="row">
              <div class="form-group col-md-5">
                <label class="control-label bold" for="">Cirugía</label>
                <div class="col-md-12">
                  <label class="radio-inline"><input type="radio" name="cirugia" id="electiva" value="0" required="required"> Electiva </label>
                  <label class="radio-inline"><input type="radio" name="cirugia" id="urgencia" value="1"> Urgencia </label>
                  <label class="radio-inline"><input type="radio" name="cirugia" id="reintervencion" value="2"> Reintervención </label>
                </div>
              </div>
              <div class="form-group col-md-4">
                <label class="bold">Fecha Solicitada</label>
                <input name="fecha_solicitud" class="form-control dd-mm-yyyy" required="required">
              </div>
              <div class="form-group col-md-12">
                <label class="bold">Hora solicitada</label>
                <input name="hora_solicitud" class="form-control clockpicker" required="required">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12">
                <label class="bold">Diagnóstico Preoperatorio</label>
                <div class="dxPreop" id="prefetch">
                  <input name="diagnostico_preoperatorio" class="form-control typeahead" value="" required="required">
                  <input type="hidden" name="cie10_id" id="cie10_id" value="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-4">
                <label class="bold">Operación Proyectada</label>
                <div class="cxProyectada" id="prefetch">
                  <input type="text" name="operacion_proyectada" class="form-control typeahead" required="required">
                  <input type="hidden" name="cie9_id" id="cie9_id" value="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-5">
                <label class="control-label bold" for="">Hemoderivados el dia de la cirugía</label>
                <p>
                  <label class="radio-inline"><input type="radio" name="hemoderivados" id="reqSangre1" value="1" required="required"> Si </label>
                  <label class="radio-inline"><input type="radio" name="hemoderivados" id="reqSangre2" value="0"> No </label>
                </p>
              </div>
            </div>
            <div class="row reqSangre hidden">
              <div class="form-group col-md-3">
                <label class="bold">Grupo Sanguineo</label>
                <input name="solicitudtransfucion_gs_abo" value="<?= $st[0]['solicitudtransfucion_gs_abo'] ?>" class="form-control">
              </div>
              <div class="form-group col-md-3">
                <label class="bold">Rh (D)</label>
                <input name="solicitudtransfucion_gs_rhd" value="<?= $st[0]['solicitudtransfucion_gs_rhd'] ?>" class="form-control">
              </div>
              <div class="form-group col-md-3">
                <label class="bold">En quirófano (ml.)</label>
                <input name="solicitudtransfucion_disponible" value="<?= $st[0]['solicitudtransfucion_disponible'] ?>" class="form-control">
              </div>
              <div class="form-group col-md-3">
                <label class="bold">En reserva (ml.)</label>
                <input name="solicitudtransfucion_reserva" value="<?= $st[0]['solicitudtransfucion_reserva'] ?>" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-4">
                <label class="control-label bold" for="">Tipo de Anestesia</label>
                <div class="col-md-12">
                  <label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="1"> Local </label>
                  <label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="2"> Regional </label>
                  <label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="3"> General </label>
                </div>
              </div>
              <div class="form-group col-md-4">
                <label class="control-label bold" for="">Valoración Preoperatoria Permisible</label>
                <div class="col-md-12">
                  <label class="radio-inline"><input type="radio" name="preoperatoria_permisible" id="preoperatoria_permisible" value="1"> Si </label>
                  <label class="radio-inline"><input type="radio" name="preoperatoria_permisible" id="preoperatoria_permisible" value="2"> No </label>
                  <label class="radio-inline"><input type="radio" name="preoperatoria_permisible" id="preoperatoria_permisible" value="0"> No requiere </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-4">
                <label class="control-label bold" for="">Prueba para COVID-19</label>
                <div class="col-md-12" id="prueva_covid">
                  <label class="radio-inline"><input type="radio" name="prueva_covid" id="prueva_covid" value="1"> Si </label>
                  <label class="radio-inline"><input type="radio" name="prueva_covid" id="prueva_covid" value="2"> No </label>
                </div>
              </div>
              <div class="form-group col-md-4">
                <label class="control-label bold" for="">Tele de Torax Preoperatoria</label>
                <div class="col-md-12">
                  <label class="radio-inline"><input type="radio" name="tele_preoperatoria" id="telePreoperatoria" value="1"> Si </label>
                  <label class="radio-inline"><input type="radio" name="tele_preoperatoria" id="telePreoperatoria" value="2"> No </label>
                </div>
              </div>
              <div class="form-group col-md-4">
                <label class="control-label bold" for="">Tiempo Quirurgico Aproximado</label>
                <input name="tiempo_quirurgico" value="" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12">
                <label class="bold">Requerimientos, Insumos y Equipo Necesarios</label>
                <textarea name="requerimientos_insumos_equipo" class="form-control" id="requerimientos_insumos_equipo" rows="3"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-9">
                <label class="bold" for="">Nombre del Médico Tratante</label>
                <select class="select2 width100" name="empleado_matricula" id="empleado_matricula" data-value="<?= $Nota['notas_medicotratante'] ?>" required>
                  <option value="" disabled selected>Seleccione</option>
                  <?php foreach ($MedicosBase as $value) { ?>
                    <option value="<?= $value['empleado_matricula'] ?>"><?= $value['empleado_nombre'] ?> <?= $value['empleado_apellidos'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>-->
            <div class="row">
              <div class="col-md-4 mb-4 mt-5">
                <input type="hidden" name="csrf_token">
                <input type="hidden" name="editar_solicitud" value="no">
                <input type="hidden" name="area" value="<?= $this->UMAE_USER; ?>">
                <input type="hidden" name="asistentesmedicas_id" value="<?= $solicitud[0]['asistentesmedicas_id'] ?>">
                <input type="hidden" name="triage_id" value="<?= $info['triage_id'] ?>">
                <input type="hidden" name="solicitudInt_id" value=-1>
                <input type="hidden" name="fecha_orden" value="">
                <button class="btn back-imss btn-block nueva-solicitud" type="submit">Nueva solicitud</button>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/TratamientoQuirurgico.js?') . md5(microtime()) ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Nss.js?') . md5(microtime()) ?>" type="text/javascript"></script>

<!-- <script src="<?= base_url('assets/libs/bootstrap3-typeahead/bootstrap3-typeahead.min.js') ?>"></script> -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script> -->
<!--<script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script> -->
<!--<script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script> -->
<script type="text/javascript">
  console.log('triage_nombre_am')
  console.log("<?= $info['triage_nombre_am'] ?>")
  var solicitudes = <?= json_encode($solicitudes) ?>;
  var solicitudesForm = <?= json_encode($solicitudes) ?>;
  for(s in solicitudesForm){
    if(typeof(solicitudesForm[s]) == "string"){
      solicitudesForm[s].replace("/n","//n")
    }
  }
  function selectOction(name, Cont) {
    var Elements = document.getElementsByName(name)
    for (d in Elements) {
      if (parseInt(Elements[d].value) == solicitudes[Cont][name]) {
        Elements[d].click()
        break
      }
    }
  }
  $(document).ready(function() {
    $(".nueva-solicitud").click(function(e) {
      e.preventDefault();
      document.getElementsByName("editar_solicitud")[0].value = "no"
      editNuevaSolicitud(-1)
    })
    /*$(".editSolicitud").click(function(e) {
      console.log("editSolicitud")
      $("input:radio").removeAttr('checked')
      var Cont = $(this).data("cont") - 1
      var fecha = solicitudes[Cont]["fecha_solicitud"].split("-")
      fecha = fecha[2] + "/" + fecha[1] + "/" + fecha[0]
      document.getElementsByName("fecha_solicitud")[0].value = fecha
      document.getElementsByName("hora_solicitud")[0].value = solicitudes[Cont]["hora_solicitud"]
      document.getElementsByName("diagnostico_preoperatorio")[0].value = solicitudes[Cont]["diagnostico_preoperatorio"]
      document.getElementsByName("operacion_proyectada")[0].value = solicitudes[Cont]["operacion_proyectada"]
      selectOction("hemoderivados", Cont);
      selectOction("anestesia", Cont);
      selectOction("preoperatoria_permisible", Cont);
      selectOction("prueva_covid", Cont);
      document.getElementsByName("tiempo_quirurgico")[0].value = solicitudes[Cont]["tiempo_quirurgico"]
      document.getElementsByName("requerimientos_insumos_equipo")[0].value = solicitudes[Cont]["requerimientos_insumos_equipo"]
      document.getElementsByName("empleado_matricula")[0].value = solicitudes[Cont]["empleado_matricula"]
      document.getElementsByName("solicitudInt_id")[0].value = solicitudes[Cont]["solicitudInt_id"]
      selectOction("tele_preoperatoria", Cont);
      selectOction("cirugia", Cont);
      document.getElementsByName("editar_solicitud")[0].value = "si"
      document.getElementsByName("fecha_orden")[0].value = solicitudes[Cont]["fecha_orden"]
      console.log(solicitudes[Cont]["fecha_orden"])
    })
    $(".btn-imms-cancel").click(function(e) {
      document.getElementsByName("editar_solicitud")[0].value = "no"
      document.getElementsByName("fecha_solicitud")[0].value = ""
      document.getElementsByName("hora_solicitud")[0].value = ""
      document.getElementsByName("diagnostico_preoperatorio")[0].value = ""
      document.getElementsByName("operacion_proyectada")[0].value = ""
      document.getElementsByName("tiempo_quirurgico")[0].value = ""
      document.getElementsByName("requerimientos_insumos_equipo")[0].value = ""
      document.getElementsByName("empleado_matricula")[0].value = ""
      document.getElementsByName("fecha_orden")[0].value = ""
      $("input:radio").removeAttr('checked')
    })/*
    /*var cie10_data = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: '<?php echo base_url(); ?>Sections/Documentos/BuscarDxPreop',
      remote: {
        url: '<?php echo base_url(); ?>Sections/Documentos/BuscarDxPreop?query=%QUERY',
        wildcard: '%QUERY'
      }
    });

    $('.dxPreop .typeahead').typeahead({
      minLength: 3,
      hint: true,
      highlight: true
    }, {
      name: 'cie10_data',
      display: 'nombre',
      source: cie10_data.ttAdapter(),
      limit: 1500,
      templates: {
        empty: [
          '<div class="empty-message">',
          'Imposible encontrar petición con ese criterio de búsqueda',
          '</div>'
        ].join('\n'),
        suggestion: Handlebars.compile('<div class="row"><div class="col-md-12" style="padding-right:5px; padding-left:5px;">{{nombre}} - <strong>{{clave}}</strong></div></div>')
      }
    });

    $('.dxPreop .typeahead').bind('typeahead:select', function(ev, suggestion) {
      $('#cie10_id').val(suggestion.cie10_id);
    });

    var cie9_data = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: '<?php echo base_url(); ?>Sections/Documentos/BuscarProcedimiento',
      remote: {
        url: '<?php echo base_url(); ?>Sections/Documentos/BuscarProcedimiento?query=%QUERY',
        wildcard: '%QUERY'
      }
    });

    $('.cxProyectada .typeahead').typeahead({
      minLength: 3,
      hint: true,
      highlight: true
    }, {
      name: 'cie9_data',
      display: 'nombre',
      source: cie9_data.ttAdapter(),
      limit: 1500,
      templates: {
        empty: [
          '<div class="empty-message">',
          'Imposible encontrar petición con ese criterio de búsqueda',
          '</div>'
        ].join('\n'),
        suggestion: Handlebars.compile('<div class="row"><div class="col-md-12" style="padding-right:5px; padding-left:5px;">{{nombre}} - <strong>{{clave}}</strong></div></div>')
      }
    });
    $('.cxProyectada .typeahead').bind('typeahead:select', function(ev, suggestion) {
      $('#cie9_id').val(suggestion.id_cx);
    });*/
    $('input[name=hemoderivados]').click(function(e) {
      if ($(this).val() == 1) {
        $('.reqSangre').removeClass('hidden');
      } else $('.reqSangre').addClass('hidden');
    });
    function editNuevaSolicitud(Cont) {
      var aux = '<form class="solicitud-intervencion">'+
            '<div class="panel-body b-b b-light">'+
            '<div class="row">'+
             ' <div class="form-group col-md-5">'+
                '<label class="control-label bold" for="">Cirugía</label>'+
                '<div class="col-md-12">'+
                  '<label class="radio-inline"><input type="radio" name="cirugia" id="electiva" value="0" required="required"> Electiva </label>'+
                  '<label class="radio-inline"><input type="radio" name="cirugia" id="urgencia" value="1"> Urgencia </label>'+
                  '<label class="radio-inline"><input type="radio" name="cirugia" id="reintervencion" value="2"> Reintervención </label>'+
                '</div>'+
              '</div>'+
              '<div class="form-group col-md-4">'+
                '<label class="bold">Fecha Solicitada</label>'+
                '<input name="fecha_solicitud" class="form-control dd-mm-yyyy" required="required">'+
              '</div>'+
              '<div class="form-group col-md-12">'+
                '<label class="bold">Hora solicitada</label>'+
                '<input name="hora_solicitud" class="form-control clockpicker" required="required">'+
              '</div>'+
            '</div>'+
            '<div class="row">'+
              '<div class="form-group col-md-12">'+
                '<label class="bold">Diagnóstico Preoperatorio</label>'+
                '<div class="dxPreop" id="prefetch">'+
                 ' <input style = "width:520px;" name="diagnostico_preoperatorio" class="form-control typeahead" value="" required="required">'+
                  '<input  type="hidden" name="cie10_id" id="cie10_id" value="">'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="row">'+
              '<div class="form-group col-md-4">'+
                '<label class="bold">Operación Proyectada</label>'+
                '<div class="cxProyectada" id="prefetch">'+
                  '<input style = "width:520px;" type="text" name="operacion_proyectada" class="form-control typeahead" required="required">'+
                  '<input type="hidden" name="cie9_id" id="cie9_id" value="">'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="row">'+
              '<div class="form-group col-md-5">'+
                '<label class="control-label bold" for="">Hemoderivados el dia de la cirugía</label>'+
                '<p>'+
                  '<label class="radio-inline"><input type="radio" name="hemoderivados" id="reqSangre1" value="1" required="required"> Si </label>'+
                  '<label class="radio-inline"><input type="radio" name="hemoderivados" id="reqSangre2" value="0"> No </label>'+
                '</p>'+
              '</div>'+
            '</div>'+
            '<div class="row reqSangre hidden">'+
              '<div class="form-group col-md-3">'+
               ' <label class="bold">Grupo Sanguineo</label>'+
               ' <input name="solicitudtransfucion_gs_abo" value="" class="form-control">'+
              '</div>'+
              '<div class="form-group col-md-3">'+
                '<label class="bold">Rh (D)</label>'+
                '<input name="solicitudtransfucion_gs_rhd" value="" class="form-control">'+
              '</div>'+
              '<div class="form-group col-md-3">'+
                '<label class="bold">En quirófano (ml.)</label>'+
                '<input name="solicitudtransfucion_disponible" value="" class="form-control">'+
              '</div>'+
              '<div class="form-group col-md-3">'+
                '<label class="bold">En reserva (ml.)</label>'+
                '<input name="solicitudtransfucion_reserva" value="" class="form-control">'+
             ' </div>'+
            '</div>'+
           ' <div class="row">'+
              '<div class="form-group col-md-4">'+
                '<label class="control-label bold" for="">Tipo de Anestesia</label>'+
                '<div class="col-md-12">'+
                  '<label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="1" required="required"> Local </label>'+
                  '<label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="2"> Regional </label>'+
                  '<label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="3"> General </label>'+
                '</div>'+
              '</div>'+
              '<div class="form-group col-md-4">'+
                '<label class="control-label bold" for="">Valoración Preoperatoria Permisible</label>'+
                '<div class="col-md-12">'+
                  '<label class="radio-inline"><input type="radio" name="preoperatoria_permisible" id="preoperatoria_permisible" value="1" required="required"> Si </label>'+
                  '<label class="radio-inline"><input type="radio" name="preoperatoria_permisible" id="preoperatoria_permisible" value="2"> No </label>'+
                  '<label class="radio-inline"><input type="radio" name="preoperatoria_permisible" id="preoperatoria_permisible" value="0"> No requiere </label>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="row">'+
              '<div class="form-group col-md-4">'+
                '<label class="control-label bold" for="">Prueba para COVID-19</label>'+
                '<div class="col-md-12" id="prueva_covid">'+
                  '<label class="radio-inline"><input type="radio" name="prueva_covid" id="prueva_covid" value="1" required="required"> Si </label>'+
                  '<label class="radio-inline"><input type="radio" name="prueva_covid" id="prueva_covid" value="2"> No </label>'+
                '</div>'+
              '</div>'+
              '<div class="form-group col-md-4">'+
                '<label class="control-label bold" for="">Tele de Torax Preoperatoria</label>'+
                '<div class="col-md-12">'+
                  '<label class="radio-inline"><input type="radio" name="tele_preoperatoria" id="telePreoperatoria" value="1" required="required"> Si </label>'+
                  '<label class="radio-inline"><input type="radio" name="tele_preoperatoria" id="telePreoperatoria" value="2"> No </label>'+
                '</div>'+
              '</div>'+
              '<div class="form-group col-md-4">'+
                '<label class="control-label bold" for="">Tiempo Quirurgico Aproximado</label>'+
                '<input name="tiempo_quirurgico" value="" class="form-control" required="required">'+
              '</div>'+
            '</div>'+
            '<div class="row">'+
              '<div class="form-group col-md-12">'+
                '<label class="bold">Requerimientos, Insumos y Equipo Necesarios</label>'+
                '<textarea name="requerimientos_insumos_equipo" class="form-control" id="requerimientos_insumos_equipo" rows="3" required="required"></textarea>'+
              '</div>'+
           ' </div>'+
            '<div class="row">'+
              '<div class="form-group col-md-9">'+
                '<label class="bold" for="">Nombre del Médico Tratante</label>'
        var empleado_matricula = ""
        if(Cont == -1)
            aux +=    '<select class="select width100" name="empleado_matricula" id="empleado_matricula" required="required">';
        else
            aux +=    '<select class="select width100" name="empleado_matricula" id="empleado_matricula" data-value='+solicitudes[Cont]["empleado_matricula"]+' required="required">';
        aux +=     '<option value="" disabled selected>Seleccione</option>'
                      <?php foreach ($MedicosBase as $value) { ?>
        aux +=        '<option value="<?=$value['empleado_matricula']?>"><?= $value['empleado_nombre'] ?> <?= $value['empleado_apellidos'] ?></option>';
                      <?php } ?>
        aux +=    '</select>'+
              '</div>'+
              '<div class="form-group col-md-9">'+
                '<label class="bold" for="">Cie 9</label>'
        var um_cie9 = ""
        if(Cont != -1)
            aux +=    '<select class="select width100" name="id_cie9" id="id_cie9" data-value='+solicitudes[Cont]["id_cie9"]+' required="required">'
        else
            aux +=    '<select class="select width100" name="id_cie9" id="id_cie9" required="required">'

        aux +=      '<option value="" disabled selected>Seleccione</option>'
                      <?php foreach ($um_cie9 as $value) { ?>
        aux +=          '<option value="<?=$value['id_cie9']?>"><?= $value['nombre'] ?></option>';
                      <?php } ?>
        aux +=    '</select>'+
              '</div>'+
            '</div>'+
            '<div class="row">'+
              '<div class="col-md-4 mb-4 mt-5">'+
                //'<button type="button" class="btn btn-imms-cancel btn-block">Cancelar</button>'+
              '</div>'+
              '<div class="col-md-4 mb-4 mt-5">'+
                '<input type="hidden" name="csrf_token">'+
                '<input type="hidden" name="editar_solicitud" value="no">'+
                '<input type="hidden" name="area" value="<?= $this->UMAE_USER; ?>">'+
                '<input type="hidden" name="asistentesmedicas_id" value="<?= $solicitud[0]['asistentesmedicas_id'] ?>">'+
                '<input type="hidden" name="triage_id" value="<?= $info['triage_id'] ?>">'+
                '<input type="hidden" name="solicitudInt_id" value=-1>'+
                '<input type="hidden" name="fecha_orden" value="">'+
                '<button class="btn back-imss btn-block" type="submit">Guardar</button>'+
              '</div>'+
              '<br><br><br><br>'+
            '</div>'+
          '</form>';
        aux +="<script type='text/javascript'>"+
                "$(document).ready(function(){"+
                  "$('input[name=hemoderivados]').click(function(e) {"+
                    "if ($(this).val() == 1) {"+
                      "$('.reqSangre').removeClass('hidden');"+
                    "} else $('.reqSangre').addClass('hidden');"+
                  "});"+
                  '$(".dd-mm-yyyy").datepicker({'+
                      'autoclose: true,'+
                      'format: "dd/mm/yyyy",'+
                     ' todayHighlight: true'+
                  '});'+
                  '$(".clockpicker").clockpicker({'+
                      'placement: "top",'+
                      'autoclose: true'+
                  '});'+
                "});"+
                'function selectOction(name, Cont) {'+
                  'var Elements = document.getElementsByName(name);'+
                  'for (d in Elements) {'+
                    'if (parseInt(Elements[d].value) == solicitudes[Cont][name]) {'+
                      'Elements[d].click();'+
                      'break;'+
                    '}'+
                  '}'+
                '}'+
                'function getRadioButtonValue(name){'+
                  'element = document.getElementsByName(name);'+
                  'for(e in element){'+
                    'if(element[e].checked){'+
                      'return element[e].value;'+
                      'break;'+
                    '}'+
                  '}'+
                '}'+
                'console.log("editSolicitud");'+
                'var Cont ='+Cont+";"+
                'if(Cont != -1){'
        aux +=  'var solicitudes =<?= json_encode($solicitudes) ?>;'.replaceAll("\n","\\n")+
                'var fecha = solicitudes[Cont]["fecha_solicitud"].split("-");'+
                'fecha = fecha[2] + "/" + fecha[1] + "/" + fecha[0];'+
                'document.getElementsByName("fecha_solicitud")[0].value = fecha;'+
                'document.getElementsByName("hora_solicitud")[0].value = solicitudes[Cont]["hora_solicitud"];'+
                'document.getElementsByName("diagnostico_preoperatorio")[0].value = solicitudes[Cont]["diagnostico_preoperatorio"];'+
                'document.getElementsByName("operacion_proyectada")[0].value = solicitudes[Cont]["operacion_proyectada"];'+
                'selectOction("hemoderivados", Cont);'+
                'selectOction("anestesia", Cont);'+
                'selectOction("preoperatoria_permisible", Cont);'+
                'selectOction("prueva_covid", Cont);'+
                'document.getElementsByName("tiempo_quirurgico")[0].value = solicitudes[Cont]["tiempo_quirurgico"];'+
                'document.getElementsByName("requerimientos_insumos_equipo")[0].value = solicitudes[Cont]["requerimientos_insumos_equipo"];'+
                'document.getElementById("empleado_matricula").value = solicitudes[Cont]["empleado_matricula"];'+
                'document.getElementById("id_cie9").value = solicitudes[Cont]["id_cie9"];'+
                'console.log(solicitudes[Cont]["empleado_matricula"]);'+
                'console.log(document.getElementById("empleado_matricula").value);'+
                'document.getElementsByName("solicitudInt_id")[0].value = solicitudes[Cont]["solicitudInt_id"];'+
                'selectOction("tele_preoperatoria", Cont);'+
                'selectOction("cirugia", Cont);'+
                'document.getElementsByName("editar_solicitud")[0].value = "si";'+
                'document.getElementsByName("fecha_orden")[0].value = solicitudes[Cont]["fecha_orden"];'+
                'document.getElementsByName("solicitudtransfucion_gs_abo")[0].value = solicitudes[Cont]["solicitudtransfucion_gs_abo"];'+
                'document.getElementsByName("solicitudtransfucion_gs_rhd")[0].value = solicitudes[Cont]["solicitudtransfucion_gs_rhd"];'+
                'document.getElementsByName("solicitudtransfucion_disponible")[0].value = solicitudes[Cont]["solicitudtransfucion_disponible"];'+
                'document.getElementsByName("solicitudtransfucion_reserva")[0].value = solicitudes[Cont]["solicitudtransfucion_reserva"];'+
                '}'+
                '\$(".solicitud-intervencion").submit(function (e) {'+
                'console.log("solicitud-intervencion3");'+
                'if (document.getElementsByName("fecha_solicitud")[0].value != null){'+
                  //e.preventDefault()
                  '\$.ajax({'+
                    'url: base_url + "Sections/SolicitudDeIntervencion/AjaxSolicitudeIntervencion",'+
                    'type: "POST",'+
                    'dataType: "json",'+
                    'data: { '+
                      'fecha_solicitud:document.getElementsByName("fecha_solicitud")[0].value,'+
                      'hora_solicitud:document.getElementsByName("hora_solicitud")[0].value,'+
                      'diagnostico_preoperatorio:document.getElementsByName("diagnostico_preoperatorio")[0].value,'+
                      'operacion_proyectada:document.getElementsByName("operacion_proyectada")[0].value,'+
                      'hemoderivados: getRadioButtonValue("hemoderivados"),'+//document.getElementsByName("hemoderivados")[0].value,
                      'anestesia:getRadioButtonValue("anestesia"),'+//document.getElementsByName("anestesia")[0].value,
                      'preoperatoria_permisible:getRadioButtonValue("preoperatoria_permisible"),'+//document.getElementsByName("preoperatoria_permisible")[0].value,
                      'prueva_covid:getRadioButtonValue("prueva_covid"),'+//getElementsByName("prueva_covid")[0].value,
                      'tiempo_quirurgico:document.getElementsByName("tiempo_quirurgico")[0].value,'+
                      'requerimientos_insumos_equipo:document.getElementsByName("requerimientos_insumos_equipo")[0].value,'+
                      'empleado_matricula:document.getElementById("empleado_matricula").value,'+
                      'id_cie9:document.getElementById("id_cie9").value,'+
                      'solicitudInt_id:document.getElementsByName("solicitudInt_id")[0].value,'+
                      'tele_preoperatoria:getRadioButtonValue("tele_preoperatoria"),'+//document.getElementsByName("tele_preoperatoria")[0].value,
                      'cirugia:getRadioButtonValue("cirugia"),'+//document.getElementsByName("cirugia")[0].value,
                      'editar_solicitud:document.getElementsByName("editar_solicitud")[0].value,'+
                      'fecha_orden:document.getElementsByName("fecha_orden")[0].value,'+
                      'editar_solicitud:document.getElementsByName("editar_solicitud")[0].value,'+
                      'area:document.getElementsByName("area")[0].value,'+
                      'asistentesmedicas_id:document.getElementsByName("asistentesmedicas_id")[0].value,'+
                      'triage_id:document.getElementsByName("triage_id")[0].value,'+
                      'solicitudInt_id:document.getElementsByName("solicitudInt_id")[0].value,'+
                      'solicitudtransfucion_gs_abo:document.getElementsByName("solicitudtransfucion_gs_abo")[0].value,'+
                      'solicitudtransfucion_gs_rhd:document.getElementsByName("solicitudtransfucion_gs_rhd")[0].value,'+
                      'solicitudtransfucion_disponible:document.getElementsByName("solicitudtransfucion_disponible")[0].value,'+
                      'solicitudtransfucion_reserva:document.getElementsByName("solicitudtransfucion_reserva")[0].value,'+
                      'csrf_token: csrf_token' +
                    '},' +
                    'beforeSend: function (xhr) {'+
                        'msj_loading();'+
                    '}, success: function (data, textStatus, jqXHR) {'+
                        // bootbox.hideAll();

                        //console.log(document.getElementsByName("fecha_solicitud")[0].value)
                        'ActionWindowsReload();'+
                        'ActionWindowsReload();'+
                        'if(data.accion=="1"){'+
                          'msj_success_noti("Se agregó solicitud");'+
                        '}else if(data.accion=="0"){'+
                          'msj_success_noti("Se editó solicitud");'+
                        '}'+
                    '}, error: function (jqXHR, textStatus, errorThrown) {'+
                      'msj_error_serve();'+
                      'bootbox.hideAll();'+
                    '}'+
                  '})'+
                '}'+
              '})';
        aux += '<\/script>';
        
        var box = bootbox.dialog({
            title: '<b>Add new Handler</b>',
            message: aux,
            buttons: {
                /*main: {
                    label: 'Ok',
                    className: 'btn-default',
                    callback: function (e) {
                        if (document.getElementsByName("fecha_solicitud")[0].value != null){
                          e.preventDefault()
                        
                        $.ajax({
                          url: base_url + "Sections/SolicitudDeIntervencion/AjaxSolicitudeIntervencion",
                          type: 'POST',
                          dataType: 'json',
                          data: { 
                            fecha_solicitud:document.getElementsByName("fecha_solicitud")[0].value,
                            hora_solicitud:document.getElementsByName("hora_solicitud")[0].value,
                            diagnostico_preoperatorio:document.getElementsByName("diagnostico_preoperatorio")[0].value,
                            operacion_proyectada:document.getElementsByName("operacion_proyectada")[0].value,
                            hemoderivados: getRadioButtonValue("hemoderivados"),//document.getElementsByName("hemoderivados")[0].value,
                            anestesia:getRadioButtonValue("anestesia"),//document.getElementsByName("anestesia")[0].value,
                            preoperatoria_permisible:getRadioButtonValue("preoperatoria_permisible"),//document.getElementsByName("preoperatoria_permisible")[0].value,
                            prueva_covid:getRadioButtonValue("prueva_covid"),//getElementsByName("prueva_covid")[0].value,
                            tiempo_quirurgico:document.getElementsByName("tiempo_quirurgico")[0].value,
                            requerimientos_insumos_equipo:document.getElementsByName("requerimientos_insumos_equipo")[0].value,
                            empleado_matricula:document.getElementById("empleado_matricula").value,
                            id_cie9:document.getElementById("id_cie9").value,
                            solicitudInt_id:document.getElementsByName("solicitudInt_id")[0].value,
                            tele_preoperatoria:getRadioButtonValue("tele_preoperatoria"),//document.getElementsByName("tele_preoperatoria")[0].value,
                            cirugia:getRadioButtonValue("cirugia"),//document.getElementsByName("cirugia")[0].value,
                            editar_solicitud:document.getElementsByName("editar_solicitud")[0].value,
                            fecha_orden:document.getElementsByName("fecha_orden")[0].value,
                            editar_solicitud:document.getElementsByName("editar_solicitud")[0].value,
                            area:document.getElementsByName("area")[0].value,
                            asistentesmedicas_id:document.getElementsByName("asistentesmedicas_id")[0].value,
                            triage_id:document.getElementsByName("triage_id")[0].value,
                            solicitudInt_id:document.getElementsByName("solicitudInt_id")[0].value,
                            solicitudtransfucion_gs_abo:document.getElementsByName("solicitudtransfucion_gs_abo")[0].value,
                            solicitudtransfucion_gs_rhd:document.getElementsByName("solicitudtransfucion_gs_rhd")[0].value,
                            solicitudtransfucion_disponible:document.getElementsByName("solicitudtransfucion_disponible")[0].value,
                            solicitudtransfucion_reserva:document.getElementsByName("solicitudtransfucion_reserva")[0].value,
                            csrf_token: csrf_token 
                          }, 
                          beforeSend: function (xhr) {
                              msj_loading();
                          }, success: function (data, textStatus, jqXHR) {
                             // bootbox.hideAll();

                              console.log(data)
                              //console.log(document.getElementsByName("fecha_solicitud")[0].value)
                              ActionWindowsReload();
                              if(data.accion=='1'){
                                msj_success_noti("Se agregó solicitud")
                              }else if(data.accion=='0'){
                                msj_success_noti("Se editó solicitud")
                              }
                          }, error: function (jqXHR, textStatus, errorThrown) {
                            msj_error_serve();
                            bootbox.hideAll();
                          }
                        })
                      } 
                        //intervencion2($(this).serialize())
                    }
                },*/
                cancel: {
                    label: 'Cancel',
                    className: 'btn-default'
                }
            }
        });
    }
    $('.solicitud-intervencion4').submit(function (e) {
      console.log("solicitud-intervencion3")
      if (document.getElementsByName("fecha_solicitud")[0].value != null){
        //e.preventDefault()
        $.ajax({
          url: base_url + "Sections/SolicitudDeIntervencion/AjaxSolicitudeIntervencion",
          type: 'POST',
          dataType: 'json',
          data: { 
            fecha_solicitud:document.getElementsByName("fecha_solicitud")[0].value,
            hora_solicitud:document.getElementsByName("hora_solicitud")[0].value,
            diagnostico_preoperatorio:document.getElementsByName("diagnostico_preoperatorio")[0].value,
            operacion_proyectada:document.getElementsByName("operacion_proyectada")[0].value,
            hemoderivados: getRadioButtonValue("hemoderivados"),//document.getElementsByName("hemoderivados")[0].value,
            anestesia:getRadioButtonValue("anestesia"),//document.getElementsByName("anestesia")[0].value,
            preoperatoria_permisible:getRadioButtonValue("preoperatoria_permisible"),//document.getElementsByName("preoperatoria_permisible")[0].value,
            prueva_covid:getRadioButtonValue("prueva_covid"),//getElementsByName("prueva_covid")[0].value,
            tiempo_quirurgico:document.getElementsByName("tiempo_quirurgico")[0].value,
            requerimientos_insumos_equipo:document.getElementsByName("requerimientos_insumos_equipo")[0].value,
            empleado_matricula:document.getElementById("empleado_matricula").value,
            id_cie9:document.getElementById("id_cie9").value,
            solicitudInt_id:document.getElementsByName("solicitudInt_id")[0].value,
            tele_preoperatoria:getRadioButtonValue("tele_preoperatoria"),//document.getElementsByName("tele_preoperatoria")[0].value,
            cirugia:getRadioButtonValue("cirugia"),//document.getElementsByName("cirugia")[0].value,
            editar_solicitud:document.getElementsByName("editar_solicitud")[0].value,
            fecha_orden:document.getElementsByName("fecha_orden")[0].value,
            editar_solicitud:document.getElementsByName("editar_solicitud")[0].value,
            area:document.getElementsByName("area")[0].value,
            asistentesmedicas_id:document.getElementsByName("asistentesmedicas_id")[0].value,
            triage_id:document.getElementsByName("triage_id")[0].value,
            solicitudInt_id:document.getElementsByName("solicitudInt_id")[0].value,
            solicitudtransfucion_gs_abo:document.getElementsByName("solicitudtransfucion_gs_abo")[0].value,
            solicitudtransfucion_gs_rhd:document.getElementsByName("solicitudtransfucion_gs_rhd")[0].value,
            solicitudtransfucion_disponible:document.getElementsByName("solicitudtransfucion_disponible")[0].value,
            solicitudtransfucion_reserva:document.getElementsByName("solicitudtransfucion_reserva")[0].value,
            csrf_token: csrf_token 
          }, 
          beforeSend: function (xhr) {
              msj_loading();
          }, success: function (data, textStatus, jqXHR) {
              // bootbox.hideAll();

              console.log(data)
              //console.log(document.getElementsByName("fecha_solicitud")[0].value)
              ActionWindowsReload();
              if(data.accion=='1'){
                msj_success_noti("Se agregó solicitud")
              }else if(data.accion=='0'){
                msj_success_noti("Se editó solicitud")
              }
          }, error: function (jqXHR, textStatus, errorThrown) {
            msj_error_serve();
            bootbox.hideAll();
          }
        })
      }
    })
    //function verificarCampos(){

    $(".editSolicitud").click(function (e) {
      e.preventDefault();
      var Cont = $(this).data("cont") - 1
      document.getElementsByName("editar_solicitud")[0].value = "si"
      editNuevaSolicitud(Cont)
    })
  });
</script>