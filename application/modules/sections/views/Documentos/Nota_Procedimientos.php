      <form class="notaProcedimientos">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:1px">
            <span class="input-group-addon back-imss border-back-imss">
              <input type="text" class="tipo_nota width100" name="notas_tipo" value="Nota de Procedimientos" readonly>
            </span>
          </div>
        </div>

        <!-- Panel de Actulizar signos vitales -->

        <div class="panel panel-default panel-y">
          <div class="panel-heading">
            <h4>Actualización de Signos Vitales</h4>
          </div>
          <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="form-group">
                  <label><b>T.A (mmHg)</b></label>
                  <input class="form-control" name="sv_ta" value="<?= $signosVitalesNota['sv_ta'] ?>">
                </div>
              </div>
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="form-group">
                  <label><b>Temp (°C)</b></label>
                  <input class="form-control" name="sv_temp" value="<?= $signosVitalesNota['sv_temp'] ?>">
                </div>
              </div>
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="form-group">
                  <label><b>F. Cardiaca (lpm)</b></label>
                  <input class="form-control" name="sv_fc" value="<?= $signosVitalesNota['sv_fc'] ?>">
                </div>
              </div>
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="form-group">
                  <label><b>F. Resp (rpm)</b></label>
                  <input class="form-control" name="sv_fr" value="<?= $signosVitalesNota['sv_fr'] ?>">
                </div>
              </div>
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="form-group">
                  <label><b>SP02 (%)</b></label>
                  <input class="form-control" name="sv_oximetria" value="<?= $signosVitalesNota['sv_oximetria'] ?>">
                </div>
              </div>
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="control-group">
                  <label><b>Glucosa (mg/dl)</b></label>
                  <input class="form-control" name="sv_dextrostix" value="<?= $signosVitalesNota['sv_dextrostix'] ?>">
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="control-group">
                  <label><b>Peso (kg)</b></label>
                  <input class="form-control" name="sv_peso" value="<?= $signosVitalesNota['sv_peso'] ?>">
                </div>
              </div>
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="control-group">
                  <label><b>Talla (cm)</b></label>
                  <input class="form-control" name="sv_talla" value="<?= $signosVitalesNota['sv_talla'] ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- panel de procedimientos-->
        <div class="panel panel-default panel-y">
          <div class="panel-heading">
            <h4>Procedimientos médicos</h4>
          </div>
          <div class="panel-body">
            <div class="col-lg-12">
              <div class="form-group">
                <select class="" name="procedimientos[]" id="procedimiento" data-value="<?= $NotaProcedimiento['procedimientos'] ?>" style="width: 100%" multiple="multiple" required>
                  <?php foreach ($Procedimientos as $value) { ?>
                    <option value="<?= $value['procedimiento_id'] ?>"><?= $value['nombre'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!--Panel de resumen clinico -->
        <div class="panel panel-default panel-y">
          <div class="panel-heading">
            <h4>Resumen del Procedimiento</h4>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <textarea class="form-control editor" name="resumenProcedimiento" id="area_editor1" placeholder="Anote el Resumen de los procedimientos médicos realizados al paciente" required=""><?= $NotaProcedimiento['resumen_procedimiento'] ?></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Panel de medico que realiza la nota -->
        <div class="panel panel-default ">
          <div class="panel-heading">
            <h4>Médico Tratante</h4>
          </div>
          <div class="panel-body">
            <div class="col-md-12">
              <?php
              $medicoRol = -1;
              foreach ($Usuario as $value) {
                $medicoRol = $value['empleado_roles'];
              }
              $empleado_roles = explode(",", $medicoRol);
              for ($i = 0; $i < count($empleado_roles); $i++) {
                if ($empleado_roles[$i] == "77") {
                  $medicoRol = 77;
                }
              }
              if ($medicoRol == 77) { ?>
                <div class="col-sm-12 col-md-12" style="padding-bottom: 10px">
                  <div style="background: white; border-bottom: 2px solid #E6E9ED">
                    <h4>MÉDICO TRATANTE <small>NOMBRE DE MEDICOS RESIDENTES</small></h4>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-8 col-ms-8">
                      <label>Nombre de supervisor Médico de Base:</label>
                      <input class="form-control" name="medicosBase" id="medicosBase" placeholder="Tecleé apellidos del médico y seleccione" value="<?= $medicoTratante['empleado_apellidos'] . ' ' . $medicoTratante['empleado_nombre']; ?>" autocomplete="off" required>
                      <input type="hidden" name="medicoTratante" id="id_medico_tratante" value="<?= $NotaPreAlta['notas_medicotratante'] ?>">
                    </div>
                    <div class="col-sm-3 col-md-3">
                      <label>Matricula</label>
                      <input class="form-control" id="medicoMatricula" type="text" name="medicoMatricula" placeholder="Matrícula Medico" value="<?= $medicoTratante['empleado_matricula'] ?>" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12 disabled" style="padding-bottom: 12px">
                  <div class="form-group">

                    <div class="col-sm-4 col-md-3">
                      <label>Nombre(s) de médico(s) residente(s):</label>
                      <input type="text" required class="form-control" id="" name="nombre_residente[]" placeholder="Nombre(s)" value="<?= $Residentes[0]['nombre_residente'] ?>">
                    </div>
                    <div class="col-sm-3">
                      <label>Apellido paterno y materno </label>
                      <input type="text" class="form-control" id="medico<?= $i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?= $Residentes[0]['apellido_residente'] ?>" required>
                    </div>
                    <div class="col-sm-3 col-md-3">
                      <label>Matricula</label>
                      <input class="form-control" id="residenteCedula" type="text" name="cedula_residente[]" placeholder="Matricula" value="<?= $Residentes[0]['cedulap_residente'] ?>" required>
                    </div>
                    <div class="col-sm-2 col-md-2">
                      <label>Grado</label>
                      <input class="form-control" id="grado" type="text" name="grado[]" placeholder="Grado (ej. R3MI)" value="<?= $Residentes[0]['grado'] ?>" required>
                    </div>
                    <?php if(count($Residentes) == 0){?>
                      <div class="col-sm-1 col-md-1">
                        <label>Agregar +</label>
                        <a href='#' class="btn btn-success btn-xs " style="width:100%;height:100%;padding:7px;" id="add_otro_residente" data-original-title="Agregar Médico Residente"><span class="glyphicon glyphicon-plus "></span></a>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div id="medicoResidente" style="padding-top: 10px">
                  <?php for ($i = 1; $i < count($Residentes); $i++) { ?>
                    <div class="col-sm-12 form-group">
                      <div class="col-sm-4 col-md-3">
                        <input type="text" class="form-control" id="medico<?= $i ?>" name="nombre_residente[]" placeholder="Nombre(s)" value="<?= $Residentes[$i]['nombre_residente'] ?>">
                      </div>
                      <div class="col-sm-4 col-md-3">
                        <input type="text" class="form-control" id="medico<?= $i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?= $Residentes[$i]['apellido_residente'] ?>">
                      </div>
                      <div class="col-sm-3 col-md-3">
                        <input type="text" class="form-control" id="medico<?= $i ?>" name="cedula_residente[]" placeholder="Matricula" value="<?= $Residentes[$i]['cedulap_residente'] ?>">
                      </div>
                      <div class="col-sm-2 col-md-2">
                        <input class="form-control" id="grado" type="text" name="grado[]" placeholder="Grado (ej. R3MI)" value="<?= $Residentes[$i]['grado'] ?>" required>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              <?php } else { ?>
                <div class="col-md-12" style="background: white; padding: 25px 15px 15px 15px">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label><b>NOMBRE</b></label>
                        <input type="text" name="medicoTratante" value="<?= $value['empleado_apellidos'] . ' ' . $value['empleado_nombre'] ?>" readonly="" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><b>MATRICULA</b></label>
                        <input type="text" name="MedicoTratante" value="<?= $value['empleado_matricula'] ?>" readonly="" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><b>CEDULA PROFESIONAL</b></label>
                        <input type="text" name="cedulaMedico" value="<?= $value['empleado_cedula'] ?>" readonly="" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-offset-8 col-md-2">
            <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
          </div>
          <div class="col-sm-2">
            <input name="csrf_token" type="hidden">
            <input name="triage_id" value="<?= $_GET['folio'] ?>" type="hidden">
            <input name="accion" value="<?= $_GET['a'] ?>" type="hidden">
            <input name="notas_id" value="<?= $this->uri->segment(4) ?>" type="hidden">
            <input name="via" value="<?= $_GET['via'] ?>" type="hidden">
            <input name="inputVia" value="<?= $_GET['inputVia'] ?>" type="hidden">
            <input name="doc_id" value="<?= $_GET['doc_id'] ?>" type="hidden">
            <input name="umae_area" value="<?= $this->UMAE_AREA ?>" type="hidden">
            <input name="tipo_nota" value="<?= $_GET['TipoNota'] ?>" type="hidden">
            <button class="btn back-imss pull-right btn-block" type="submit" style="margin-bottom: -10px">Guardar</button>
          </div>
        </div>
      </form>
      <?= modules::run('Sections/Menu/FooterNotas'); ?>
      <script src="<?= base_url() ?>assets/libs/bootstrap3-typeahead/bootstrap3-typeahead.min.js" type="text/javascript"></script>
      <script src="<?= base_url('assets/libs/jodit-3.2.43/build/jodit.min.js') ?>"></script>
      <script src="<?= base_url('assets/libs/jodit-3.2.43/assets/prism.js') ?>"></script>
      <script src="<?= base_url('assets/libs/jodit-3.2.43/assets/app.js') ?>"></script>
      <script src="<?= base_url('assets/js/sections/nota_procedimientos.js') ?>"></script>
      <script>
        $('#procedimiento').val($('#procedimiento').attr('data-value').split(',')).select2({
          placeholder: 'Seleccione opción(es)',
          allowClear: true
        });
      </script>
      <script>
        var editors = [].slice.call(document.querySelectorAll('.editor'));
        editors.forEach(function(textarea) {
          //textarea.addEventListener('click', function (e) {
          if (!Jodit.instances[textarea.id]) {
            // Object.keys(Jodit.instances).forEach(function (id) {
            //     Jodit.instances[id].destruct();
            // });

            var editor = new Jodit(textarea, {
              language: 'es',
              textIcons: false,
              iframe: false,
              iframeStyle: '*,.jodit_wysiwyg {color:red;}',
              defaultMode: Jodit.MODE_WYSIWYG,
              enter: 'br',
              // uploader: {
              // url: 'https://xdsoft.net/jodit/connector/index.php?action=fileUpload'
              // },
              // filebrowser: {
              //   ajax: {
              //     url: 'https://xdsoft.net/jodit/connector/index.php'
              //   }
              // },
              buttons: [
                'font',
                'fontsize', '|',
                'bold',
                'italic', '|',
                'ul',
                'ol', '|',
                'outdent', 'indent', '|',
                'brush',
                'paragraph', '|',
                //'image',
                'table', '|',
                'align', 'undo', 'redo', '|',
                'hr',
                'eraser', '|',
                'symbol',
                'fullsize',
              ],
              buttonsMD: 'about,print',
              buttonsSM: ',about',
              buttonsXS: 'source'

            });

            //editor.selection.insertCursorAtPoint(e.clientX, e.clientY);
          }
          //});
        });
      </script>