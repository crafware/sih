<?= modules::run('Sections/Menu/index'); ?>
<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>assets/styles/expediente.css" />
<div class="box-row">
  <div class="box-cell">
    <div class="box-inner col-md-12 col-centered">
      <div class="panel panel-default " style="margin-top: 10px">
        <div class="panel-heading p teal-900 back-imss" style="padding-bottom: 0px;">
          <div class="row" style="margin-top: -20px;">
            <div class="col-md-9" style="padding-left: 40px;">
              <div style="position: relative">
                <div style="top: 4px;position: absolute;height: 65px;width: 35px;left: -41px;" class="<?= Modules::run('Config/ColorClasificacion', array('color' => $info['triage_color'])) ?>">
                </div>
              </div>
              <h5>
                <b>PACIENTE:</b> <?= $info['triage_nombre_ap'] ?> <?= $info['triage_nombre_am'] ?> <?= $info['triage_nombre'] ?> |
                <b>SEXO: </b><?= $info['triage_paciente_sexo'] ?> <?= $PINFO['pic_indicio_embarazo'] == 'Si' ? '| - Posible Embarazo' : '' ?> |
                <?php if (!empty($PINFO['pia_procedencia_hospital_num'])) { ?>
                  <b>PROCEDENCIA:</b> <?= $PINFO['pia_procedencia_espontanea'] == 'Si' ? 'ESPONTANEA ' . $PINFO['pia_procedencia_espontanea_lugar'] : ' ' . $PINFO['pia_procedencia_hospital'] . ' ' . $PINFO['pia_procedencia_hospital_num'] ?> |
                <?php } ?>
                <b>NSS:</b> <?= $PINFO['pum_nss'] ?>-<?= $PINFO['pum_nss_agregado'] ?> |<br>
                <?php if ($info['triage_color'] != '') { ?>
                  <b>Código de atención médica:</b> <?= $info['triage_color'] ?>
                <?php } ?>
                <b>FOLIO:</b> <?= $info['triage_id'] ?> |
                <b>CAMA:</b> <?= $cama['cama_nombre'] ?> <?= $piso[0]['piso_nombre_corto'] ?>
              </h5><?= $this->UMAE_SERVICIO ?>
              <h5 style="margin-top: -5px;text-transform: uppercase">
                <?php
                if ($info['triage_fecha_nac'] != '') {
                  $fecha = Modules::run('Config/ModCalcularEdad', array('fecha' => $info['triage_fecha_nac']));
                  if ($fecha->y < 15) {
                    echo 'PEDIATRICO';
                  }
                  if ($fecha->y > 15 && $fecha->y < 60) {
                    echo 'ADULTO';
                  }
                  if ($fecha->y > 60) {
                    echo 'GERIATRICO';
                  }
                } else {
                  echo 'S/E';
                }
                ?>
              </h5>
            </div>
            <div class="col-md-3 text-right">
              <h5><b>EDAD</b></h5>
              <h4 style="margin-top: -10px">
                <?php
                if ($info['triage_fecha_nac'] != '') {
                  $fecha = Modules::run('Config/ModCalcularEdad', array('fecha' => $info['triage_fecha_nac']));
                  echo $fecha->y . ' <span>Años</span>';
                } else {
                  echo 'S/E';
                }
                ?>
              </h4>
            </div>
          </div>
          <!-- Boton de selección de notas -->
          <div class="card-tools" style="margin-top: 55px">
            <ul class="list-inline">
              <li class="dropdown">
                <a md-ink-ripple data-toggle="dropdown" class="md-btn md-fab red md-btn-circle tip" data-original-title="Realizar Documento" data-placement="bottom">
                  <i class="mdi-social-person-add i-24 "></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color"> 
                  <?php
                    if(isset($_GET['url'])) {?>
                      <li class="disabled">
                        <a href="#">NO PERMITIDO</a>
                      </li> 
                      <?php
                    }else if($this->UMAE_AREA == 'Trabajo Social') {?>
                      <li class="">
                        <a href="<?= base_url() ?>Sections/Documentos/NotaTrabajosocial/0/?TipoNota=Nota de Trabajo Social&folio=<?= $this->uri->segment(4) ?>" target="_blank" rel="opener">Nota de Trabajo Social</a>
                      </li>
                      <?php 
                    }else {?>
                      <?php 
                      if($_GET['tipo'] == 'Choque') {?>
                        <li class="<?= $info['triage_fecha_clasifica'] != '' ? 'disabled' : '' ?>">
                          <a <?php if ($info['triage_fecha_clasifica'] == '') { ?>href="<?= base_url() ?>Sections/Documentos/HojaClasificacion/<?= $this->uri->segment(4) ?>/?tipo=<?= $_GET['tipo'] ?>" target="_blank" <?php } ?>>Hoja de Clasificación</a>
                        </li>
                        <?php 
                      }?>
                      <?php
                      /* Si existe Hoja Frontal en pc_docuemtos */
                      if (!empty($DocumentosHoja) && !isset($_GET['via'])) {  ?>
                        <?php 
                        if($this->ConfigHojaInicialAbierta == 'No') {?>
                          <li class="<?= !empty($HojasFrontales)  ? 'disabled' : '' ?>">
                            <a <?php if (empty($HojasFrontales)) { ?>href="<?= base_url() ?>Sections/Documentos/HojaFrontal?hf=0&TipoNota=Nota Inicial&a=add&folio=<?= $this->uri->segment(4) ?>&tipo=<?= $_GET['tipo'] ?>" target="_blank" rel="opener">Generar Inicial (Hoja Frontal)<?php } ?></a>
                          </li>
                        <?php 
                        }else if($_GET['tipo'] == 'Consultorios' || $this->UMAE_AREA == 'Médico Observación') { /* SI NO SE HA  GENERADO HOJA INICIAL ABIERTO*/ ?>
                            <li class="<?= !empty($HojasFrontales)  ? 'disabled' : '' ?>">
                              <a <?php if (empty($HojasFrontales)) { ?>href="<?= base_url() ?>Sections/Documentos/HojaInicialAbierto?hf=0&TipoNota=Nota Inicial&a=add&folio=<?= $this->uri->segment(4) ?>&tipo=<?= $_GET['tipo'] ?>" target="_blank" rel="opener" <?php } ?>><b>Generar "Nota Inicial"</b></a>
                            </li>
                        <?php 
                        }else if($this->UMAE_AREA == 'Médico Hospitalización' || $this->UMAE_AREA == 'UCI'|| $this->UMAE_AREA == 'UTR'|| $this->UMAE_AREA == 'UTMO') { ?>
                          <li class="<?= !empty($NotaIngresoPorServicio)  ? 'disabled' : '' ?>">
                            <a <?php if (empty($NotaIngresoPorServicio)) { ?>href="<?= base_url() ?>Sections/Documentos/NotaIngresoHospitalario?idnota=0&TipoNota=Nota Inicial&a=add&folio=<?= $this->uri->segment(4) ?>&via=<?= $this->UMAE_AREA ?>&tipo=<?= $_GET['tipo'] ?>" target="_blank" rel="opener" <?php } ?>><b>Generar "Nota de Ingreso"</b></a>
                          </li>
                        <?php 
                        }?>
                        <?php 
                      } /* Fin de if((!empty($DocumentosHoja) */ ?>


                    <?php if (!empty($DocumentosHoja)) {
                            if ($this->UMAE_AREA != 'Médico Hospitalización' && $_GET['tipo'] != 'Hospitalizacion') { ?>

                        <li class="<?= empty($HojasFrontales)  ? 'disabled' : '' ?>">
                          <a <?php if (!empty($HojasFrontales)) { ?>href="<?= base_url() ?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Evolución&folio=<?= $this->uri->segment(4) ?>&via=<?= $_GET['via'] ?>&doc_id=<?= $_GET['doc_id'] ?>&inputVia=<?= $_GET['tipo'] ?>" target="_blank" rel="opener" <?php } ?>><b>Generar "Nota de Evolución"</b></a>
                        </li>
                        <li class="<?= empty($HojasFrontales)  ? 'disabled' : '' ?>">
                          <a <?php if (!empty($HojasFrontales)) { ?>href="<?= base_url() ?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Procedimientos&folio=<?= $this->uri->segment(4) ?>&via=<?= $_GET['tipo'] ?>&doc_id=<?= $_GET['doc_id'] ?>&inputVia=<?= $_GET['tipo'] ?>" target="_blank" rel="opener" <?php } ?>><b>Generar "Nota de Procedimientos"</b></a>
                        </li>
                        <li class="<?= empty($HojasFrontales)  ? 'disabled' : '' ?>">
                          <a <?php if (!empty($HojasFrontales)) { ?>href="<?= base_url() ?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Egreso&folio=<?= $this->uri->segment(4) ?>&via=<?= $_GET['via'] ?>&doc_id=<?= $_GET['doc_id'] ?>&inputVia=<?= $_GET['tipo'] ?>" target="_blank" rel="opener" <?php } ?>><b>Generar "Nota de Egreso"</b></a>
                        </li>
                        <li class="<?= empty($HojasFrontales)  ? 'disabled' : '' ?>">
                          <a <?php if (!empty($HojasFrontales)) { ?>href="<?= base_url() ?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Indicaciones&folio=<?= $this->uri->segment(4) ?>&via=<?= $_GET['via'] ?>&doc_id=<?= $_GET['doc_id'] ?>&inputVia=<?= $_GET['tipo'] ?>" target="_blank" rel="opener" <?php } ?>><b>Generar "Nota de Indicaciones"</b></a>
                        </li>

                        <li class="<?= empty($HojasFrontales)  ? 'disabled' : '' ?>">
                          <a class="orden-internamiento" <?php if (!empty($HojasFrontales)) { ?>href="#" data-folio="<?= $this->uri->segment(4) ?>" <?php } ?>><b>Generar "Orden de Internamiento"</b></a>
                        </li>


                      <?php } else { ?>

                        <li class="<?= empty($NotaIngresoHospital)  ? 'disabled' : '' ?>">
                          <a <?php if (!empty($NotaIngresoHospital)) { ?>href="<?= base_url() ?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Evolución&folio=<?= $this->uri->segment(4) ?>&via=<?= $_GET['via'] ?>&doc_id=<?= $_GET['doc_id'] ?>&inputVia=<?= $_GET['tipo'] ?>" target="_blank" rel="opener" <?php } ?>><b>Generar "Nota de Evolución"</b></a>
                        </li>
                        <li class="<?= empty($NotaIngresoHospital)  ? 'disabled' : '' ?>">
                          <a <?php if (!empty($NotaIngresoHospital)) { ?>href="<?= base_url() ?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Procedimientos&folio=<?= $this->uri->segment(4) ?>&via=<?= $_GET['tipo'] ?>&doc_id=<?= $_GET['doc_id'] ?>&inputVia=<?= $_GET['tipo'] ?>" target="_blank" rel="opener" <?php } ?>><b>Generar "Nota de Procedimientos"</b></a>
                        </li>
                        <li class="<?= empty($NotaIngresoHospital)  ? 'disabled' : '' ?>">
                          <a <?php if (!empty($NotaIngresoHospital)) { ?>href="<?= base_url() ?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Alta&folio=<?= $this->uri->segment(4) ?>&via=<?= $_GET['via'] ?>&doc_id=<?= $_GET['doc_id'] ?>&inputVia=<?= $_GET['tipo'] ?>" target="_blank" rel="opener" <?php } ?>><b>Generar "Nota de Alta"</b></a>
                        </li>
                      <?php } ?>

                      <?php if ($_GET['tipo'] != 'Consultorios') { ?>
                        <li class="<?= empty($HojasFrontales) ? 'disabled' : '' ?>">
                          <a <?php if (!empty($HojasFrontales)) { ?>href="<?= base_url() ?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Interconsulta&folio=<?= $this->uri->segment(4) ?>&via=Valoración&doc_id=<?= $_GET['doc_id'] ?>&inputVia=<?= $_GET['tipo'] ?>" target="_blank" rel="opener" <?php } ?>><b>Generar "Nota de Interconsulta (seguimiento)"</b></a>
                        </li>
                      <?php } ?>
                    <?php } ?>
                  <?php } ?>

                </ul>
              </li>
            </ul>
          </div>
        </div>
        <!-- TABLA DE DATOS -->
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12" style="margin-top: 0px">
              <style>
                th,
                td {
                  padding-left: 5px !important;
                  padding-right: 0px !important;
                }
              </style>
              <div class="panel with-nav-tabs">
                <div class="panel-heading">
                  <!-- Inicio navegador para seleccion de tipo de documento -->
                  <ul class="nav nav-tabs table-hover">
                    <li class="active bold"><a href="#tab1primary" id="btnNotasTriage" data-toggle="tab">Notas Médicas</a></li>
                    <li class=""><a href="#tab2primary" data-toggle="tab">Notas de Trabajo Social</a></li>
                    <li class=""><a href="#tab3primary" data-toggle="tab">Estudio de laboratorio</a></li>
                    <li class=""><a href="#tab4primary" data-toggle="tab">Imagenología</a></li>
                    <li class=""><a href="#tab5primary" data-toggle="tab">Interconsultas</a></li>
                    <li class=""><a href="#tab6primary" data-toggle="tab">Prescripciones</a></li>
                  </ul>
                </div>
                <div class="panel-body">
                  <div class="tab-content">
                    <!-- Notas Médicas -->
                    <div class="tab-pane fade in active" id="tab1primary">
                      <!-- Tabla de contenido principal -->
                      <table class="table table-bordered table-hover footable footable" data-page-size="10" data-filter="#filterExpediente" data-limit-navigation="6">
                        <thead>
                          <tr>
                            <th style="width: 15%">FECHA Y HORA</th>
                            <th style="width: 18%">DOCUMENTO</th>
                            <th style="width: 18%">ÁREA</th>
                            <th style="width: 14%">SERVICIO</th>
                            <th style="width: 25%">MÉDICO TRATANTE</th>
                            <th style="width: 15%">ACCIONES</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if ($info['triage_fecha_clasifica'] != '') : ?>
                            <!-- Hoja de Clasificacion en triage -->
                            <tr>
                              <td>
                                <?php if ($info['triage_color'] != '') { ?>
                                  <?= date("d-m-Y", strtotime($info['triage_fecha_clasifica'])); ?> <?= $info['triage_hora_clasifica'] ?>
                                <?php } else { ?>
                                  No Aplica
                                <?php } ?>
                              </td>
                              <td>Hoja de Clasificación</td>
                              <td>Médico Triage</td>
                              <td>Admisión Continua</td>
                              <td>
                                <?php $sqlMedicoClass = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
                                  'empleado_id' => $info['triage_crea_medico']
                                ), 'empleado_nombre, empleado_apellidos')[0]; ?>
                                <?= $sqlMedicoClass['empleado_nombre'] ?> <?= $sqlMedicoClass['empleado_apellidos'] ?>
                              </td>
                              <td>
                                <?php if ($info['triage_color'] != '') { ?>
                                  <i class="fa fa-file-pdf-o icono-accion pointer tip" data-original-title='Ver Hoja de Clasificación' onclick="AbrirDocumento(base_url+'Inicio/Documentos/Clasificacion/<?= $this->uri->segment(4) ?>/?via=<?= $_GET['tipo'] ?>')"></i>
                                <?php } else { ?>
                                  No Aplica
                                <?php } ?>
                              </td>
                            </tr>
                          <?php endif; ?>
                          <!-- Par cada nota frontal -->
                          <?php foreach ($HojasFrontales as $value) { ?>
                            <tr>
                              <td>
                                <?php if ($value['hf_choque'] == '1' || $value['hf_obs'] == '1') {
                                  $horaAtencion = $obs['observacion_mha'];
                                } else {
                                  $horaAtencion = $ce['ce_he'];
                                } ?>
                                <?= $value['hf_fg'] ?> <?= $horaAtencion ?>
                              </td>
                              <td>Nota Inicial (Hoja Frontal)</td>
                              <td><?= $ce['ce_asignado_consultorio'] ?></td>
                              <td><?= Modules::run('Config/ObtenerEspecialidad', array('Usuario' => $value['empleado_id'])) ?></td>
                              <td><?= Modules::run('Sections/Documentos/ExpedienteEmpleado', array('empleado_id' => $value['empleado_id'])) ?></td>
                              <td>
                                <!--Acciones -->
                                <?php if ($this->ConfigHojaInicialAbierta == 'No') { ?>
                                  <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/HojaFrontalCE/<?= $value['triage_id'] ?>')" data-original-title="Ver Hoja Frontal"></i>
                                  &nbsp;
                                <?php } else { ?>
                                  <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/HojaInicialAbierto/<?= $value['triage_id'] ?>')" data-original-title="Ver Hoja Frontal"></i>
                                  &nbsp;
                                <?php } ?>
                                <?php if (!empty($ordeninternamiento)) { ?>
                                  <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/Ordeninternamiento/<?= $value['triage_id'] ?>')" data-original-title="Generar Orden de Internamiento"></i>
                                  &nbsp;
                                <?php } ?>
                                <?php
                                $solicitud_laboratorio = $this->config_mdl->_query("SELECT * FROM um_solicitud_laboratorio WHERE input_via = '" . $_GET['tipo'] . "' AND tipo_nota='Nota Inicial' AND nota_id= '" . $value['hf_id'] . "' AND  triage_id = '" . $this->uri->segment(4) . "'")[0];
                                if ($solicitud_laboratorio['solicitud_id'] && $solicitud_laboratorio['estudios'] != "{}") { ?>
                                  <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/OrdenLaboratorio/<?= $value['triage_id'] ?>?hf=<?= $value['hf_id'] ?>&TipoNota=Nota Inicial&a=edit&folio=<?= $this->uri->segment(4) ?>&tipo=<?= $_GET['tipo'] ?>')" data-original-title="Generar Orden de Laboratorio"></i>
                                  &nbsp;
                                <?php } ?>
                                <?php if ($PINFO['pia_lugar_accidente'] == 'TRABAJO') : ?>
                                  <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/ST7/<?= $value['triage_id'] ?>')" data-original-title="Generar ST7"></i>
                                  &nbsp;
                                <?php endif; ?>
                                <?php if ($_GET['via'] != 'paciente') { ?>
                                  <?php if ($value['empleado_id'] == $_SESSION['UMAE_USER'] || $obs['observacion_medico'] == $_SESSION['UMAE_USER']) { ?>
                                    <?php if ($this->ConfigHojaInicialAbierta == 'No') { ?>
                                      <a href="<?= base_url() ?>Sections/Documentos/HojaFrontal?hf=<?= $value['hf_id'] ?>&a=edit&folio=<?= $this->uri->segment(4) ?>&tipo=<?= $_GET['tipo'] ?>" target="_blank">
                                        <i class="fa fa-pencil icono-accion"></i>
                                      </a>&nbsp;
                                      <p class="demo1" id=<?= $value['hf_id'] . "expiredTimeHf_id" ?>></p>
                                    <?php } else { ?>
                                      <a style="display:none;" id=<?= $value['hf_id'] . "EditHf_id" ?> href="<?= base_url() ?>Sections/Documentos/HojaInicialAbierto?hf=<?= $value['hf_id'] ?>&TipoNota=Nota Inicial&a=edit&folio=<?= $this->uri->segment(4) ?>&tipo=<?= $_GET['tipo'] ?>" target="_blank" rel="opener">
                                        <i class="fa fa-pencil icono-accion tip pointer" data-original-title="Editar Nota"></i>
                                      </a>&nbsp;
                                    <?php } ?>
                                  <?php } ?>
                                  <i class="fa fa-trash-o icono-accion pointer" style="opacity: 0.4"></i>
                                <?php } ?>
                              </td>
                            </tr>
                          <?php } ?>
                          <?php foreach ($NotaIngresoHospital as $value) { ?>
                            <tr>
                              <td><?= date('d-m-Y', strtotime($value['fecha_elabora'])) ?> <?= date('H:i', strtotime($value['hora_elabora'])); ?></td>
                              <td>Nota de Ingreso</td>
                              <td>
                                Hospitalización
                              </td>
                              <td><?= $value['especialidad_nombre'] ?>
                              </td>
                              <?php if($value['id_medico_tratante']== 0){ 
                                      $medico = $value['empleado_apellidos'].' '.$value['empleado_nombre'];
                                    }else {
                                      $queryMedico = $this->config_mdl->_get_data_condition('os_empleados',array(
                                        'empleado_id' => $value['id_medico_tratante']
                                      ))[0];
                                      $medico = $queryMedico['empleado_apellidos'].' '.$queryMedico['empleado_nombre'];
                                    }?>
                              <td><?= $medico ?></td>
                              <td>

                                <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/NotaIngresoHosp/<?= $value['id_nota'] ?>')" data-original-title="Ver Nota de Ingreso"></i>&nbsp;

                                <i class="glyphicon glyphicon-list-alt icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/IndicacionesMedicasEnNota/<?= $value['id_nota'] ?>?inputVia=<?= $_GET['tipo'] ?>&indicaciones=1')" data-original-title="Indicaciones médicas <?= $value['notas_tipo'] ?>"></i>
                                &nbsp;

                                <?php
                                  $solicitud_laboratorio = $this->config_mdl->_query("SELECT * FROM um_solicitud_laboratorio WHERE input_via = '" . $_GET['tipo'] . "' AND tipo_nota='Nota Inicial' AND id_nota= '" . $value['id_nota'] . "' AND  triage_id = '" . $this->uri->segment(4) . "'")[0];
                                  if ($solicitud_laboratorio['solicitud_id'] && $solicitud_laboratorio['estudios'] != "{}") { ?>
                                    <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/OrdenLaboratorio/<?= $value['triage_id'] ?>?id_nota=<?= $value['id_nota'] ?>&TipoNota=Nota Inicial&a=edit&folio=<?= $this->uri->segment(4) ?>&tipo=<?= $_GET['tipo'] ?>')" data-original-title="Generar Orden de Laboratorio"></i>
                                    &nbsp;
                                <?php }?>
                                <?php if($value['id_medico'] == $_SESSION['UMAE_USER']) { ?>

                                  <a style="display:none;" id="<?= $value['id_nota'] . "EditId_nota" ?>" href="<?= base_url() ?>Sections/Documentos/NotaIngresoHospitalario?idnota=<?= $value['id_nota'] ?>&TipoNota=Nota Inicial&a=edit&folio=<?= $this->uri->segment(4) ?>&tipo=<?= $_GET['tipo'] ?>" target="_blank" rel="opener">
                                    <i class="fa fa-pencil icono-accion tip pointer" data-original-title="Editar Nota"></i>
                                  </a>&nbsp;
                                  <i class="fa fa-trash-o icono-accion pointer" style="opacity: 0.4"></i>
                                  <p class="demo2" id=<?= $value['id_nota'] . "expiredTimeId_nota" ?>></p>
                              </td>
                              <?php }?>
                            </tr>
                          <?php } ?>
                          <!-- Genera las notas de evolución, Interconsulta, Valoración, Egreso etc-->
                          <?php foreach ($NotasAll as $value) { ?>
                            <tr>
                              <td><?= $value['notas_fecha'] ?> <?= $value['notas_hora'] ?></td>
                              <td>
                                <span class="text-color: warning;"><?= $value['notas_tipo'] ?></span>
                              </td>
                              <td><?= $value['notas_area'] ?></td>
                              <td><?= $value['especialidad_nombre'] ?></td>
                              <?php $medicoTratante = $this->config_mdl->_get_data_condition('os_empleados', array(
                                'empleado_id' => $value['notas_medicotratante']
                              ))[0];
                              ?>
                              <td><?= $medicoTratante['empleado_nombre'] ?> <?= $medicoTratante['empleado_apellidos'] ?></td>
                              <td>
                                <!-- Acciones -->
                                <?php
                                if ($value['notas_tipo'] == 'Nota de Egreso' || $value['notas_tipo'] == 'Nota de Alta') {
                                  $alta =  $this->config_mdl->_get_data_condition('um_alta_hospitalaria', array('id_nota_egreso' => $value['']))[0];

                                ?>

                                  <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/GenerarNotaEgreso/<?= $value['notas_id'] ?>?inputVia=<?= $_GET['tipo'] ?>?via=<?= $value['notas_via'] ?>?tipoNota=<?= $value['notas_tipo'] ?>')" data-original-title="Ver <?= $value['notas_tipo'] ?>"></i>
                                <?php } else if ($value['notas_tipo'] == 'Nota de Procedimientos') { ?>

                                  <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/GenerarNotaProcedimientos/<?= $value['notas_id'] ?>?via=<?= $value['notas_via'] ?>?inputVia=<?= $_GET['tipo'] ?>?tipoNota=<?= $value['notas_tipo'] ?>')" data-original-title="Ver <?= $value['notas_tipo'] ?>"></i>
                                <?php } else if ($value['notas_tipo'] == 'Nota de Indicaciones') { ?>

                                  <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/GenerarNotaIndicaciones/<?= $value['notas_id'] ?>?inputVia=<?= $_GET['tipo'] ?>?via=<?= $value['notas_via'] ?>?inputVia=<?= $_GET['tipo'] ?>?tipoNota=<?= $value['notas_tipo'] ?>')" data-original-title="Ver <?= $value['notas_tipo'] ?>"></i>
                                <?php } else { ?>

                                  <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/GenerarNotas/<?= $value['notas_id'] ?>?inputVia=<?= $_GET['tipo'] ?>?via=<?= $value['notas_via'] ?>?inputVia=<?= $_GET['tipo'] ?>?tipoNota=<?= $value['notas_tipo'] ?>')" data-original-title="Ver <?= $value['notas_tipo'] ?>"></i>
                                <?php } ?>
                                &nbsp;
                                <?php
                                $solicitud_laboratorio = $this->config_mdl->_query("SELECT * FROM um_solicitud_laboratorio WHERE input_via = '" . $_GET['tipo'] . "' AND tipo_nota='" . $value['notas_tipo'] . "' AND nota_id= '" . $value['notas_id'] . "' AND  triage_id = '" . $this->uri->segment(4) . "'")[0];
                                if ($solicitud_laboratorio['solicitud_id'] && $solicitud_laboratorio['estudios'] != "{}") { ?>
                                  <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/OrdenLaboratorio/<?= $value['triage_id'] ?>?hf=<?= $value['notas_id'] ?>&TipoNota=<?= $value['notas_tipo'] ?>&a=edit&folio=<?= $this->uri->segment(4) ?>&tipo=<?= $_GET['tipo'] ?>')" data-original-title="Imprime Orden de Laboratorio"></i>
                                  &nbsp;
                                <?php } ?>

                                <?php if ($value['empleado_id'] == $_SESSION['UMAE_USER']) { ?>
                                  <a style="display:none;" id="<?= $value['notas_id']."EditNotas_id" ?>" href="<?= base_url() ?>Sections/Documentos/Notas/<?= $value['notas_id'] ?>/?a=edit&TipoNota=<?= $value['notas_tipo'] ?>&folio=<?= $this->uri->segment(4) ?>&via=<?= $value['notas_via'] ?>&doc_id=<?= $_GET['doc_id'] ?>&inputVia=<?= $_GET['tipo'] ?>" target="_blank" rel="opener"><i class="fa fa-pencil icono-accion tip pointer" data-original-title="Editar Nota"></i>
                                  </a>&nbsp;
                                  <p class="demo3" id=<?= $value['notas_id'] . "expiredTimeNotas_id" ?>></p>
                                <?php } ?>
                              </td>
                            </tr>
                          <?php } ?>
                          <?php if ($_GET['tipo'] == 'Observación' || $_GET['tipo'] == 'Consultorios') { ?>
                            <tr>
                              <td><?= $value['hf_fg'] ?> <?= $value['hf_hg'] ?></td>
                              <td>Consentimiento informado para el ingreso al área de Observación AC</td>
                              <td>NO APLICA</td>
                              <td></td>
                              <td>NO APLICA</td>
                              <td>
                                <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/ConsentimientoInformadoIngresoObs/<?= $this->uri->segment(4) ?>')" data-original-title="Generar Documento"></i>
                              </td>
                            </tr>
                          <?php } ?>
                          <?php if ($_GET['tipo'] == 'Choque') { ?>
                            <tr>
                              <td>NO APLICA</td>

                              <td>Consentimiento informado para el ingreso al área de Choque AC</td>
                              <td>NO APLICA</td>
                              <td>NO APLICA</td>
                              <td></td>
                              <td>
                                <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/ConsentimientoInformadoIngresoObs/<?= $this->uri->segment(4) ?>')" data-original-title="Generar Documento"></i>
                              </td>
                            </tr>
                          <?php } ?>
                          <?php foreach ($AvisoMp as $AvisoMp) { ?>
                            <tr>
                              <td><?= $AvisoMp['mp_fecha'] ?> <?= $AvisoMp['mp_hora'] ?></td>
                              <td>Documento de Avisto al Ministerio Público</td>
                              <td>NO APLICA</td>
                              <td><?= $AvisoMp['empleado_nombre'] ?> <?= $AvisoMp['empleado_apellidos'] ?></td>
                              <td>
                                <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/<?= $this->uri->segment(4) ?>')" data-original-title="Generar Documento"></i>
                              </td>
                            </tr>
                          <?php } ?>
                        </tbody>
                        <tfoot class="hide-if-no-paging">
                          <tr>
                            <td colspan="6" class="text-center">
                              <ul class="pagination"></ul>
                            </td>
                          </tr>
                        </tfoot>
                      </table> <!-- Fin tabla listado de documentos paciente -->
                    </div>
                    <!-- Notas de Trabajo Social -->
                    <div class="tab-pane fade" id="tab2primary">
                      <table class="table table-bordered table-hover footable footable">
                        <thead>
                          <tr>
                            <th style="width: 15%">Fecha/Hora</th>
                            <th style="width: 18%">Documento</th>
                            <th style="width: 18%">Área</th>
                            <th style="width: 14%">Servicio</th>
                            <th style="width: 25%">Nombre TS</th>
                            <th style="width: 15%">Acciones</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                    <!-- Solicitudes de Laboratorio -->
                    <div class="tab-pane fade" id="tab3primary">
                      <table style="width:100%;">
                        <thead>
                          <tr>
                            <th style="width: 10%">Fecha y hora</th>
                            <th style="width: 15%">Médico solicitante</th>
                            <th style="width: 15%">Servicio solicitante</th>
                            <th style="width: 60%">Resultados</th>
                          </tr>
                        </thead>
                        <tbody id='tablaPrescripcionInactiva'></tbody>
                      </table>
                    </div>
                    <!-- Imagenología -->
                    <div class="tab-pane fade" id="tab4primary">

                    </div>
                    <!-- Interconsultas -->
                    <div class="tab-pane fade" id="tab5primary">

                    </div>
                    <!-- Medicamentos -->
                    <div class="tab-pane fade" id="tab6primary">

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<input type="hidden" name="triage_id" value="<?= $this->uri->segment(4) ?>" class="triage_id">

<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/libs/datatables/datatables.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Expediente.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/medicamentos.js') ?>" type="text/javascript"></script>
<?php if ($this->UMAE_AREA != 'Médico Hospitalización') { ?>
  <script src="<?= base_url('assets/js/OrdenInternamiento.js?') . md5(microtime()) ?>" type="text/javascript"></script>
<?php } ?>
<script type="text/javascript">
  $(document).ready(function() {
    $(".pdsa-panel-toggle").addClass("glyphicon glyphicon-chevron-down");

    function RefrescaServicio() {
      var ip = [];
      var i = 0;
      $('#guardar').attr('disabled', 'disabled'); //Deshabilito el Boton Guardar
      $('.iServicio').each(function(index, element) {
        i++;
        ip.push({
          id_pro: $(this).val()
        });
      });
      // Si la lista de Productos no es vacia Habilito el Boton Guardar
      if (i > 0) {
        $('#guardar').removeAttr('disabled', 'disabled');
      }
      var ipt = JSON.stringify(ip); //Convierto la Lista de Productos a un JSON para procesarlo en tu controlador
      $('#ListaPro').val(encodeURIComponent(ipt));
    }

    function agregarServicio() {

      var sel = $('#servicio_id').find(':selected').val(); //Capturo el Value del Producto
      var text = $('#servicio_id').find(':selected').text(); //Capturo el Nombre del Producto- Texto dentro del Select


      var sptext = text.split();

      var newtr = '<tr class="item"  data-id="' + sel + '">';
      newtr = newtr + '<td><?php echo date('d-m-Y h:i') ?></td>';
      newtr = newtr + '<td class="iServicio" >' + sel + '</td>';
      newtr = newtr + '<td><input  class="form-control" name="motivo" required /></td>';
      newtr = newtr + '<td></td>';
      newtr = newtr + '<td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></td></tr>';

      $('#servSelected').append(newtr); //Agrego el Producto al tbody de la Tabla con el id=ProSelected

      RefrescaServicio(); //Refresco 

      $('.remove-item').off().click(function(e) {
        $(this).parent('td').parent('tr').remove(); //En accion elimino el Producto de la Tabla
        if ($('#serrSelected tr.item').length == 0)
          $('#servSelected .no-item').slideDown(300);
        RefrescaServicio();
      });
      $('.iProduct').off().change(function(e) {
        RefrescaServicio();
      });
    }
    $('.nav-tabs a').click(function(e) {

      e.preventDefault();
      if ($(this).closest('li').is('.active')) { // PAUSA MANDAR OTRO QUERY CUNADO UN TAB ESTE ACTIVO
        return;
      }
      //Obtenemos la id del link que contiene el nombre del contenido que queremos mostrar

      //var ts = +new Date();
      //console.log(ts)
      var tabUrlAddress = $(this).attr('href');
      console.log('tabla' + ' ' + tabUrlAddress);
      var href = this.hash;
      console.log('href' + ' ' + href);
      var pane = $(this);
      console.log(pane);
      pane.show();

      // $(href).load(tabUrlAddress, function (result) {

      // });

    });

    // Set the date we're counting down to
    const NotasAll = <?= json_encode($NotasAll) ?>;
    const NotasAllTime = [];
    const HojasFrontales = <?= json_encode($HojasFrontales) ?>;
    const HojasFrontalesTime = [];
    const NotaIngresoHospital = <?= json_encode($NotaIngresoHospital) ?>;
    const NotaIngresoHospitalTime = [];
    const dias = 2;
    const limitTime = 1000 * 60 * 60 * 24 * dias;
    const uneditableMessage = "No editable";
    const now = new Date().getTime();

    if (!(NotasAll == null)) {
      for (var i = 0; i < NotasAll.length; i++) {
        notas_fecha = NotasAll[i]["notas_fecha"].split("-")
        notas_hora = NotasAll[i]["notas_hora"].split(":")
        NotasAllTime.push(new Date(notas_fecha[2], notas_fecha[1] - 1, notas_fecha[0], notas_hora[0], notas_hora[1], 0, 0).getTime());
      }
    }
    if (!(HojasFrontales == null)) {
      for (var i = 0; i < HojasFrontales.length; i++) {
        notas_fecha = HojasFrontales[i]["hf_fg"].split("-")
        notas_hora = HojasFrontales[i]["hf_hg"].split(":")
        HojasFrontalesTime.push(new Date(notas_fecha[2], notas_fecha[1] - 1, notas_fecha[0], notas_hora[0], notas_hora[1], 0, 0).getTime());
      }
    }
    if (!(NotaIngresoHospital == null)) {
      for (var i = 0; i < NotaIngresoHospital.length; i++) {
        notas_fecha = NotaIngresoHospital[i]["fecha_elabora"].split("-")
        notas_hora = NotaIngresoHospital[i]["hora_elabora"].split(":")
        NotaIngresoHospitalTime.push(new Date(notas_fecha[0], notas_fecha[1] - 1, notas_fecha[2], notas_hora[0], notas_hora[1], notas_hora[1], 0).getTime());
      }
    }
    for (var i = 0; i < NotasAllTime.length; i++) {
      if (NotasAllTime[i] - now + limitTime > 0) {
        let n = document.getElementById(NotasAll[i]['notas_id'] + "EditNotas_id")
        if(n != null){
          n .style.display = "";
        }
      }
    }
    for (var i = 0; i < HojasFrontalesTime.length; i++) {
      if (HojasFrontalesTime[i] - now + limitTime > 0) {
        document.getElementById(HojasFrontales[i]['hf_id'] + "EditHf_id").style.display = "";
      }
    }
    for (var i = 0; i < NotaIngresoHospitalTime.length; i++) {
      if (NotaIngresoHospitalTime[i] - now + limitTime > 0) {
        //document.getElementById(NotaIngresoHospital[i]['id_nota'] + "EditId_nota").style.display = "";
        let n = document.getElementById(NotaIngresoHospital[i]['id_nota'] + "EditId_nota")
        //console.log(n);
        if(n != null){
          n .style.display = "";
        }
        
      }
    }

    // Update the count down every 1 second
    var x = setInterval(function() {
      // Get today's date and time
      var now = new Date().getTime();
      for (var i = 0; i < NotasAllTime.length; i++) {
        var d = document.getElementById(NotasAll[i]['notas_id'] + "expiredTimeNotas_id")
        if (d != null) {
          var distance = NotasAllTime[i] - now + limitTime;
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);
          if (distance < 0) {
            d.innerHTML = uneditableMessage;
            EditNotas = document.getElementById(NotasAll[i]['notas_id'] + "EditNotas_id")
            if (EditNotas) {
              EditNotas.remove();
            }
          } else {
            d.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
          }
        }
      }
      for (var i = 0; i < HojasFrontalesTime.length; i++) {
        // Find the distance between now and the count down date
        var d = document.getElementById(HojasFrontales[i]['hf_id'] + "expiredTimeHf_id")
        if (d != null) {
          var distance = HojasFrontalesTime[i] - now + limitTime;
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);
          if (distance < 0) {
            d.innerHTML = uneditableMessage;
            EditNotas = document.getElementById(HojasFrontales[i]['hf_id'] + "EditHf_id")
            if (EditNotas) {
              EditNotas.remove();
            }
          } else {
            d.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
          }
        }
      }
      for (var i = 0; i < NotaIngresoHospitalTime.length; i++) {
        var d = document.getElementById(NotaIngresoHospital[i]['id_nota'] + "expiredTimeId_nota")
        if (d != null) {
          var distance = NotaIngresoHospitalTime[i] - now + limitTime;
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);
          if (distance < 0) {
            d.innerHTML = uneditableMessage;
            EditNotas = document.getElementById(NotaIngresoHospital[i]['id_nota'] + "EditId_nota")
            if (EditNotas) {
              EditNotas.remove();
            }
          } else {
            d.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
          }
        }
      }
    }, 1000);
  });
</script>