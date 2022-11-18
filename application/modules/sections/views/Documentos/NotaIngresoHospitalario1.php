    <form class="guardarNotaIngreso" oninput="x.value=parseInt(escala_eva.value)">
        <!-- Tipo de Nota -->
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:1px">
            <span class="input-group-addon back-imss border-back-imss">
              <input type="text" class="tipo_nota width100" name="notas_tipo" value="Nota de Ingreso" readonly>
            </span>
          </div>
        </div>
        <!-- Tipo de Interrogatorio y motivo de ingreso-->
        <div class="panel panel-default">   
            <div class="panel-body b-b b-light">
                <div class="card-body" style="padding: 20px 0px;">
                    <div class="row" >
                        <div class="col-md-12 hide">
                            <div class="input-group m-b">
                                <span class="input-group-addon">FORMATO DE HOJA FRONTAL</span>
                                <select class="form-control" name="hf_documento">
                                    <option value="HOJA FRONTAL 4 30 128" selected="">HOJA FRONTAL 4 30 128</option>
                                </select>
                            </div>
                        </div>                                
                    </div>
                    <!-- Tipo de Interrogatorio -->
                    <div class="row">
                        <div class="col-md-12" style="padding-left: 0px">     
                            <div class="col-md-3">
                                    <h5 class=""><span><b>¿Tipo de Interrogatorio?</b></span></h5>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12" style="padding: 8px">
                                    <div class="form-group">
                                        <div style="display: inline-block;">
                                        <label class="md-check">
                                            <input type="radio" name="tipo_interrogatorio" data-value="<?=$notaIngreso[0]['tipo_interrogatorio']?>" class="has-value" value="Directo" requiered><i class="green"></i>Directo
                                        </label>
                                        </div>
                                        <div style="display: inline-block;padding-left: 45px">
                                        <label class="md-check">
                                            <input type="radio" name="tipo_interrogatorio" data-value="<?=$notaIngreso[0]['tipo_interrogatorio']?>" class="has-value" value="Indirecto" required><i class="green"></i>Indirecto
                                        </label>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- Motivo de ingreso -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h5><span class = ""><b>Motivo de Ingreso</b></span></h5>                      
                                <textarea class="form-control motivo_ingreso editor" id="area_editor1" name="motivo_ingreso" placeholder="Escriba aquí el Motivo por el cuál ingresa el paciente al servicio"><?=$notaIngreso[0]['motivo_ingreso']?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Panel de Antecdentes -->
        <div class="panel panel-default panel-y">
            <div class="panel-heading"><h4>ANTECEDENTES</h4></div>
            <div class="panel-body ">
                <div class="form-group">
                   <h5><span class = ""><b>Antecedentes Heredofamiliares</b></span></h5>
                    <textarea class="form-control editor" id="area_editor2" rows="6" name="antecedentes_herfam" placeholder=""><?=$notaIngreso[0]['antecedentes_heredofamiliares']?></textarea>
                </div>
                <div class="form-group">
                    <h5><span class = ""><b>Antecedentes Personales no Patológicos</b></span></h5>
                    <textarea class="form-control editor" id="area_editor3" rows="5" name="antecedentes_no_patologicos" placeholder=""><?=$notaIngreso[0]['antecedentes_personales_nopatologicos']?></textarea>
                </div>
                <div class="form-group">
                    <h5><span class = ""><b>Antecedentes Personales Patológicos</b></span></h5>
                    <textarea class="form-control editor" id="area_editor4" rows="8" name="antecedentes_patologicos"><?=$notaIngreso[0]['antecedentes_personales_patologicos']?></textarea>
                </div>
                <?php if($info['triage_paciente_sexo'] == 'MUJER'){?>
                <div class="form-group">
                    <h5><span class = ""><b>Antecedentes Gineco Obstetricos</b></span></h5>
                    <textarea class="form-control editor" id="area_editor5" rows="8" name="antecedentes_ginecoobstetricos"><?=$notaIngreso[0]['antecedentes_ginecoobstetricos']?></textarea>
                </div>
                <?php }?>
            </div>
        </div>
        <!-- Panel de Estado Actual  padecimiento y exploracion fisica-->
        <div class="panel panel-default panel-y">
            <div class="panel-heading"><h4>ESTADO ACTUAL</h4></div>
            <div class="panel-body">
                <div class="form-group">
                    <h5><span class = ""><b>Padecimiento Actual</b></span></h5>
                    <textarea class="form-control editor" id="area_editor6" rows="8" name="padecimiento_actual"><?=$notaIngreso[0]['padecimiento_actual']?></textarea>
                </div>
                <div class="form-group">
                    <h5><span class = ""><b>Exploración Fisica</b></span></h5>
                    <textarea class="form-control editor" id="area_editor7" rows="8" name="exploracion_fisica"><?=$notaIngreso[0]['exploracion_fisica']?></textarea>
                </div>
                
            </div>
        </div>  
        <!--PAnel de examens auxiliares de diagnostico--> 
        <div class="panel panel-default panel-y">
            <div class="panel-heading"><h4>EXAMENES AUXILIARES DE DIAGNÓSTICO</h4></div>
            <div class="panel-body">
                <div class="form-group">
                    <h5><span class = ""><b>Estudios de Laboratorio</b></span></h5>
                    <textarea class="form-control editor" id="area_editor8" rows="2" name="estudios_laboratorio" placeholder="Anote los análisis clínicos de laboratorio"><?=$notaIngreso[0]['estudios_laboratorio']?></textarea>
                </div>
                <div class="form-group">
                     <h5><span class = ""><b>Estudios de Gabinete</b></span></h5>
                       <textarea class="form-control editor" id="area_editor9" rows="2" name="estudios_gabinete" placeholder="Rayos X, Imagenología Médica"><?=$notaIngreso[0]['estudios_gabinete']?></textarea>
                </div>
            </div> 
        </div>                  
        <!-- Escalas de Salud -->                      
        <div class="panel panel-default panel-y">
            <div class="panel-heading"><h4>ESCALAS Y RIESGOS DE SALUD</h4></div>
            <div class="panel-body">
                <!-- Escla de glasgow -->
                <div class="col-md-3">
                    <div class="form-group">
                        <h5><span><b>Escala de Glasgow</b></span></h5>
                            <div class="input-group">
                                <input type="text" class="form-control" data-toggle="modal" data-target='#myModal1' placeholder="Clic para valor" name="escala_glasgow" value="<?=$escalaSalud[0]['escala_glasgow']?>"  autocomplete="off">
                                <span class="input-group-addon">Puntos</span>
                            </div>
                    </div>
                </div>
                <!-- Riesgo caida -->        
                <div class="col-md-3">
                    <div class="form-group">
                        <h5><span><b>Riesgo de Caida</b></span></h5>
                        <label class="md-check">
                        <input type="radio" name="riesgo_caida" data-value="<?=$escalaSalud[0]['riesgo_caida']?>" value="Alta" class="has-value"><i class="green"></i>Alta
                        </label>&nbsp;&nbsp;&nbsp;
                        <label class="md-check">
                        <input type="radio" name="riesgo_caida" data-value="<?=$escalaSalud[0]['riesgo_caida']?>" value="Media" class="has-value"><i class="green"></i>Media
                        </label>&nbsp;&nbsp;
                        <label class="md-check">
                        <input type="radio" name="riesgo_caida" data-value="<?=$escalaSalud[0]['riesgo_caida']?>" value="Baja" class="has-value"><i class="green"></i>Baja
                        </label>
                    </div>
                </div>
                <!-- EVA -->                 
                <div class="col-md-3">
                    <div class="form-group">
                        <h5><span><b>Escala de Dolor (EVA)</b></span></h5>
                        <div class="row">
                            <div class="col-sm-6">
                                  <?php
                                  if($escalaSalud[0]['escala_eva'] == ''){
                                    $escala_eva = 0;
                                  }else{
                                    $escala_eva = $escalaSalud[0]['escala_eva'];
                                  }
                                   ?>
                                <input type="range" name="escala_eva" value="<?= $escala_eva ?>" min="0" max="10" value="0">
                            </div>
                            <div class="col-sm-6" style="width:10px;height:30px;border:1px solid blue;">
                                <output name="x" for="ecala_eva"><?= $escala_eva ?></output>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Riesgo de trombosis --> 
                <div class="col-md-3">
                    <div class="form-group">
                        <h5><span><b>Riesgo de Trombosis</b></span></h5>
                        <div class="input-group">
                            <input  type="text" class="form-control" data-toggle="modal" data-target='#myModal2' placeholder="Clic para colocar valor" name="escala_riesgo_trombosis" id="puntos_rt" value='<?=$escalaSalud[0]['escala_riesgo_trombosis']?>'  autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <!-- Impresion Dignostica -->
        <div class="panel panel-default panel-y">
            <div class="panel-heading"><h4>IMPRESIÓN DIAGNÓSTICA</h4></div>
            <div class="panel-body">
                <div class="form-group">
                    <h4><span class = ""><b>Diagnóstico de Ingreso y Comorbilidades</b></span></h4>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Diagnóstico con código CIE-10</label>
                            <div class="input-group m-b">
                                <span class="input-group-addon"><i class="fa fa-stethoscope" style="font-size: 16px"></i></span>
                                    <input type="text" class="form-control" name="cie10_nombre" placeholder="Tecleé el diagnóstico a buscar y seleccione (minimo 5 caracteres)" >
                                <span class="input-group-addon back-imss border-back-imss add-cie10"><i class="fas fa fa-search pointer"></i></span>
                            </div>
                            <div class="row row-diagnosticos"></div>
                        </div>                                                           
                    </div>
                </div>
                <div class="form-group">
                     <h5><span class = ""><b>Comentarios</b></span></h5>
                    <textarea class="form-control editor" id="area_editor10" rows="2" name="comentario" placeholder=""><?=$notaIngreso[0]['comentario']?></textarea>
                </div>
                <!-- Estado de salud -->
                <div class="form-group">
                      <h5><span class = ""><b>Estado de Salud</b></span></h5>
                      &nbsp;&nbsp;&nbsp;
                      <label class="md-check">
                        <input type="radio" name="estado_salud" data-value="<?=$notaIngreso[0]['estado_salud']?>" class="has-value" value="Estable" required>
                        <i class="green"></i>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Condición clínica controlada. Signos vitales normalizados. No requiere monitorización ni soporte intensivo. Paciente próximo a trasladarse a una unidad de menor complejidad.">Estable</a>
                      </label>&nbsp;&nbsp;&nbsp;&nbsp;
                      <label class="md-check">
                        <input type="radio" name="estado_salud" data-value="<?=$notaIngreso[0]['estado_salud']?>" class="has-value" value="Delicado"><i class="green"></i>
                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Condición clínica controlada aunque no resuelta. Requiere monitorización y/o soporte intensivo">Delicado</a>
                      </label>&nbsp;&nbsp;&nbsp;&nbsp;
                      <label class="md-check">
                        <input type="radio" name="estado_salud" data-value="<?=$notaIngreso[0]['estado_salud']?>" class="has-value" value="Muy Delicado"><i class="green"></i>
                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="">Muy Delicado</a>
                      </label>&nbsp;&nbsp;&nbsp;&nbsp;
                      <label class="md-check">
                        <input type="radio" name="estado_salud" data-value="<?=$notaIngreso[0]['estado_salud']?>" class="has-value" value="Grave"><i class="green"></i><a href="#" data-toggle="tooltip" data-placement="bottom" title="Condición clínica aún no controlada. Requiere monitorización y soporte intensivo. Paciente con riesgo vital">Grave</a>
                      </label>&nbsp;&nbsp;&nbsp;&nbsp;
                      <label class="md-check">
                        <input type="radio" name="estado_salud" data-value="<?=$notaIngreso[0]['estado_salud']?>" class="has-value" value="Muy Grave"><i class="green"></i><a href="#" data-toggle="tooltip" data-placement="bottom" title="Condición clínica no controlada pese a la aplicación de intervenciones terapéuticas habituales y extraordinarias según corresponda. Paciente con riesgo vital inminente o en riesgo de quedar con graves secuelas">Muy Grave</a>
                      </label>
                </div>
                <div class="form-group">
                    <h5><span class = ""><b>Pronóstico</b></span></h5>
                    <textarea class="form-control" rows="2" name="pronostico"><?=$notaIngreso[0]['pronostico']?></textarea>
                </div>
            </div>
        </div>
        <!-- Plan y ordenes medicas -->
        <div class="panel panel-default panel-y">
            <div class="panel-heading"><h4>PLAN Y ORDENES MEDICAS</h4></div>
            <div class="panel-body">
                <!-- Fila de Dieta -->
                <div class="col-md-12" id="divNutricion" style="padding-top: 12px">
                    <div class="col-md-3" id="divRadioNutricion" style="padding-left: 0px">
                        <div class="form-group">
                            <h5><span><b>a) Instrucciones de nutricion:</b></span></h5>
                                <?php
                                // Declara estado original del radio cuando se realiza nueva nota
                                $checkAyuno = '';
                                $checkDieta = '';
                                $divSelectDietas = 'hidden';
                                $select_dietas = '0';
                                $otraDieta = '';
                                $divOtraDieta = 'hidden';
                                if($_GET['a'] == 'edit'){
                                  if($plan[0]['dieta'] == '0'){
                                    $checkAyuno = 'checked';
                                  }else if($plan[0]['dieta'] == '1' || $plan[0]['dieta'] == '2'
                                  || $plan[0]['dieta'] == '3'|| $plan[0]['dieta'] == '4'|| $plan[0]['dieta'] == '5'
                                  || $plan[0]['dieta'] == '6'|| $plan[0]['dieta'] == '7'|| $plan[0]['dieta'] == '8'
                                  || $plan[0]['dieta'] == '9'|| $plan[0]['dieta'] == '10'|| $plan[0]['dieta'] == '11'
                                  || $plan[0]['dieta'] == '12'){
                                    $checkDieta = 'checked';
                                    $divSelectDietas = '';
                                    $select_dietas = $plan[0]['dieta'];
                                  }else{
                                    $divSelectDietas = '';
                                    $checkDieta = 'checked';
                                    $divOtraDieta = '';
                                    $select_dietas = '13';
                                    $otraDieta = $plan[0]['dieta'];
                                  }
                                }
                                ?>
                            <div class="form-group radio">
                                <label class="md-check">
                                    <input type="radio" class="has-value" value="0" id='radioAyuno' name="dieta" <?= $checkAyuno ?> ><i class="green"></i>Ayuno
                                </label>
                                <label class="md-check">
                                    <input type="radio" class="has-value" value="" id='radioDieta' name="dieta" <?= $checkDieta ?> ><i class="green"></i>Dieta
                                </label>
                            </div>
                        </div>
                    </div>
                    <div  class="col-sm-3" id="divSelectDietas" <?= $divSelectDietas ?>>
                            <div class="form-group">
                                <label>Tipos de dieta:</label>
                                <!-- El valor es numerico para distinguir si la opcion pertenece a los
                                     radios, selects o input -->
                                  <select name="tipoDieta" id="selectDietas" class="form-control" data-value="<?= $select_dietas ?>">
                                    <option value="0">Seleccionar Dieta</option>
                                    <option value="1">IB - Normal</option>
                                    <option value="2">IIA - Blanda</option>
                                    <option value="3">IIB - Astringente</option>
                                    <option value="4">III - Diabetica</option>
                                    <option value="5">IV - Hiposodica</option>
                                    <option value="6">V - Hipograsa</option>
                                    <option value="7">VI - Liquida clara</option>
                                    <option value="8">VIA - Liquida general</option>
                                    <option value="9">VIB - Licuada por sonda</option>
                                    <option value="10">VIB - Licuada por sonda artesanal</option>
                                    <option value="11">VII - Papilla</option>
                                    <option value="12">VIII - Epecial</option>
                                    <option value="13">Otros</option>
                                  </select>
                            </div>
                    </div>
                    <div  class="col-sm-6" id='divOtraDieta'  style="padding:0" <?= $divOtraDieta ?> >
                        <div class="form-group">
                            <label>Otra dieta:</label>
                                <input type="text" class="form-control" name="otraDieta" value="<?= $otraDieta ?>" id="inputOtraDieta" placeholder="Otra dieta">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Indicaciones de la dieta</label>
                            <textarea name="dieta_indicaciones" class="form-control" rows="1"><?=$plan[0]['dieta_indicaciones']?></textarea>
                    </div>

                </div>
                <!-- Toma de signos vitales -->
                <div class="col-sm-12" id="divSignos" style="padding-left: 0px">
                    <?php
                      // Declara estado original del select cuando se realiza nueva nota
                      $select_signos = 0;
                      $otras_indicaciones = 'hidden';
                      // El estado de las variables cambia al realizar un cambio, esto para determinar si el valor corresponde al select o textarea
                      if($_GET['a'] == 'edit'){
                        if($plan[0]['toma_signos_vitales'] == '0' || $plan[0]['toma_signos_vitales'] == '1' || $plan[0]['toma_signos_vitales'] == '2' ){
                          $select_signos = $plan[0]['toma_signos_vitales'];
                        }else{
                          $select_signos = "3";
                          $otras_indicaciones = '';
                        }
                      }
                    ?>
                    <div class="col-sm-4" id="divTomaSignos">
                        <div class="form-group">
                            <h5><span><b>b) Toma de signos vitales: </b></span></h5>
                            <select  id="selectTomaSignos" class="form-control" data-value="<?= $select_signos ?>" name="tomaSignos">
                                <option value="0">Toma de signos</option>
                                <option value="1">Por turno</option>
                                <option value="2">Cada 4 horas</option>
                                <option value="3">Otras</option>
                            </select>
                        </div>
                    </div>
                    <div id="divOtrasInidcacionesSignos" <?= $otras_indicaciones ?> >
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label>Otras inidcaciones:</label>
                                <input type="text" name="otrasIndicacionesSignos" class="form-control" placeholder="Otras indicaciones" value="<?=$plan[0]['toma_signos_vitales']?>">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cuidados generales de enfermeria -->
                <div class="col-sm-12">
                    <div class="col-sm-12" id="divCuidadosGenerales" style="padding-left: 0px">
                        <div class="form-group">
                            <h5><span><b>c) Cuidados generales de enfermeria:</b></span>
                                  <?php
                                  // Declara el estado original checkbox de cuidados generales de enfermeria
                                  $labelCheck = '';
                                  $hiddenCheck = 'hidden';
                                  // Al editar, modifica el estado del checkbox
                                  if($plan[0]['cuidados_genfermeria'] == 1){
                                    $check_generales = 'checked';
                                    $labelCheck = '';
                                    $hiddenCheck = '';
                                  }
                                  ?>
                                  <label class="md-check">
                                    <input type="checkbox" id="checkCuidadosGenerales" name="cuidados_genfermeria" value="1" <?= $check_generales ?> ><i class="green"></i>
                                    <label id="labelCheckCuidadosGenerales"><?= $labelCheck ?></label>
                                  </label>
                            </h5>
                            <ul id="listCuidadosGenerales" <?= $hiddenCheck ?> >
                                <li>a. Estado neurológico</li>
                                <li>b. Cama con barandales</li>
                                <li>c. Calificación del dolor</li>
                                <li>d. Calificación de riesgo de caida</li>
                                <li>e. Control de liquidos por turno</li>
                                <li>f. Vigilar riesgo de ulceras por presión</li>
                                <li>g. Aseo bucal</li>
                                <li>h. Lavado de manos</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Cuidados especificos de enfermeria-->
                <div class="col-sm-12">
                    <div class="form-group">
                          <h5><span><b>d) Cuidados especiales de enfermeria</b></span></h5>
                          <textarea class="form-control hf_cuidadosenfermeria editor" id="area_editor11" name="cuidadosEspecialesEnfermeria" placeholder="Cuidados especiales de enfermeria"><?=$plan[0]['cuidados_eenfermeria']?></textarea>
                    </div>
                </div>
                <!-- Soliciones parenterales -->
                <div class="col-sm-12" id="divCuidadosGenerales">
                    <div class="form-group">
                        <h5><span><b>e) Soluciones parenterales</b></span></h5>
                        <textarea class="form-control hf_solucionesp editor" id="area_editor12" name="solucionesParenterales" rows="5" placeholder="Soluciones Parenterales"><?=$plan[0]['soluciones_parenterales']?></textarea>
                    </div>
                </div>
                <!-- Prescripcion de medicamentos -->
                <div class="col-md-12">
                    <div class="form-group">
                        <h5><span><b>f) Prescripción de medicamentos: </b></span>
                            <label class="md-check">
                                <input type="checkbox" id="check_form_prescripcion"><i class="green"></i><label id="label_check_prescripcion"></label>
                            </label>
                        </h5>
                    </div>
                        <!-- Panel con el historial de prescripciones -->
                        <nav class="back-imss">
                            <ul class="nav navbar-nav" >
                              <li>
                                <a id="acordeon_prescripciones_activas">
                                    Prescripciones activas:
                                    <label id="label_total_activas"><?= count($Prescripcion) ?></label>
                                </a>
                              </li>
                            </ul>
                            <label id="estado_panel" hidden>0</label>
                        </nav>
                        <div class="">
                            <table class="table-hover table-condensed table-responsive" id="historial_medicamentos_activos" style="width:100%; font-size:11px;" >
                                <thead id="historial_prescripcion" >
                                  <tr>
                                    <th>Medicamento</th>
                                    <th>Fecha prescripción</th>
                                    <th>Dosis</th>
                                    <th>Vía</th>
                                    <th>Frecuencia</th>
                                    <th>Aplicación</th>
                                    <th>Inicio</th>
                                    <th colspan="2">Tiempo</th>
                                    <th>Fin</th>
                                    <th id="col_dias">Días Transcurridos</th>
                                    <th id="col_fechaFin" >Acciones</th>
                                    <!-- <th id="col_acciones" >Acciones</th>
                                    <th id="col_movimiento" >Movimiento</th>
                                    <th id="col_fecha_movimiento" >Fecha Movimiento</th> -->
                                  </tr>
                                </thead>
                                <tbody id="table_prescripcion_historial" > </tbody>
                            </table>
                        </div>
                        <div>
                            <div class="panel-group" id='historial_movimientos' hidden> </div>
                        </div>
                        <div id='historial_reacciones' hidden>
                            <table style="width:100%;">
                                <thead>
                                  <th>Medicamento</th>
                                  <th>Observacion</th>
                                </thead>
                                <tbody id="table_historial_reacciones"></tbody>
                            </table>
                        </div>
                        <div id="historial_alergia_medicamentos" hidden>
                            <table style="width:100%;" >
                                <thead><th>Medicamentos que presentan alergias</th></thead>
                                <tbody >
                                  <tr>
                                    <td id="table_historial_alergia_medicamentos">
                                    <?php for($x=0 ;$x < count($AlergiaMedicamentos); $x++){ ?>
                                      <?=($x + 1).") ".$AlergiaMedicamentos[$x]['medicamento']."&nbsp;&nbsp;&nbsp;"?>
                                    <?php } ?>
                                    </td>
                                  </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <div class="panel-group" id='historial_notificaciones' hidden> </div>
                        </div>

                        <!-- Fin panel prescripcion -->
                        <!-- Inicio formulario prescripcion -->
                        <div class="formulario_prescripcion" style="padding-top: 10px;" hidden><br>
                            <div class="row" >
                                <div class="col-md-12" style="margin-top: -15px">
                                    <div class="form-group">
                                        <div class="input-group m-b">
                                            <span class="input-group-addon back-imss border-back-imss" >
                                            AGREGAR PRESCRIPCIÓN DE MEDICAMENTOS
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="padding:0">
                                <div class="col-sm-12" style="padding: 0;">
                                    <div class="form-group">
                                        <label><b>Medicamento / Forma farmaceutica</b></label>
                                        <div class="input-group">
                                            <div id="borderMedicamento" >
                                                <select id="select_medicamento" onchange="indicarInteraccion()" class="form control select2 selectpicker" style="width: 100%" hidden>
                                                    <option value="0">-Seleccionar-</option>
                                                    <?php foreach ($Medicamentos as $value) {?>
                                                    <option value="<?=$value['medicamento_id']?>" ><?=$value['medicamento']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div id="border_otro_medicamento" hidden>
                                                <input type="text" class="form-control" id="input_otro_medicamento" placeholder="Indicar otro medicamento">
                                            </div>
                                            <span class="input-group-btn otro_boton_span">
                                                <button class="btn btn-default btn_otro_medicamento" type="button" value="0" title="Indicar otro medicamento que no esta en catalogo">Otro medicamento</button>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Formulario para antibiotico NTP
                                         El formulrio es desplegado en una ventana modal* -->
                                    <div class="form-group form-antibiotico-npt" hidden>
                                         <input class="form-control" id="categoria_safe"/>
                                         <input class="form-control aminoacido" />
                                         <input class="form-control dextrosa" />
                                         <input class="form-control lipidos-intravenosos" />
                                         <input class="form-control agua-inyectable" />
                                         <input class="form-control cloruro-sodio" />
                                         <input class="form-control sulfato-magnesio" />
                                         <input class="form-control cloruro-potasio" />
                                         <input class="form-control fosfato-potasio" />
                                         <input class="form-control gluconato-calcio" />
                                         <input class="form-control albumina" />
                                         <input class="form-control heparina" />
                                         <input class="form-control insulina-humana" />
                                         <input class="form-control zinc" />
                                         <input class="form-control mvi-adulto" />
                                         <input class="form-control oligoelementos" />
                                         <input class="form-control vitamina" />
                                         <input class="form-control total-npt" />
                                         <!-- Campos antimicrobianos y oncologicos -->
                                         <input class="form-control diluyente" />
                                         <input class="form-control vol_diluyente" />
                                    </div>
                                    <!-- Fin formulario para antibiotico NTP -->
                                </div>
                                <!-- identificador de los medicamentos con interaccion interaccion_amarilla,
                                     el select se llena al seleccionar un medicamento -->
                                <div hidden class="col-sm-2">
                                    <label><b>interaccion_amarilla</b></label>
                                    <div id="borderMedicamento">
                                      <select id="interaccion_amarilla" class="" style="width: 100%" >
                                          <option value="0">-Seleccionar-</option>
                                          <?php foreach ($Medicamentos as $value) {?>
                                          <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_amarilla']?></option>
                                          <?php } ?>
                                      </select>
                                    </div>
                                </div>
                                <div hidden class="col-sm-2" style="padding: 1;">
                                    <label><b>interaccion_roja</b></label>
                                    <div id="borderMedicamento">
                                      <select id="interaccion_roja" class="" style="width: 100%" >
                                          <option value="0">-Seleccionar-</option>
                                          <?php foreach ($Medicamentos as $value) {?>
                                          <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_roja']?></option>
                                          <?php } ?>
                                      </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Via de administración , dosis, unidad, frecuencia, horario -->
                            <div class="col-sm-12" style="padding:0">
                                <div class="col-sm-5" style="padding-left: 0px;">
                                    <label><b>Via de administración</b></label>
                                    <div class="input-group" id="borderVia">
                                        <div id="opcion_vias_administracion">
                                            <select class="form control select2 width100" id="via">
                                                <option value="0">-Seleccionar-</option>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default btn_otra_via" type="button" value="0" title="Indicar otra via de administración">Otra</button>
                                        </span>
                                  </div>
                                </div>
                                <div class="col-sm-1" style="padding-right: 0; padding-left: 0;">
                                    <div class="form-group" >
                                        <label ><b>Dosis</b></label>
                                        <div id="borderDosis">
                                            <input type="number" min='0' id="input_dosis" class="form-control">
                                            <label id="dosis_max" hidden></label>
                                            <label id="gramaje_dosis_max" hidden></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1" style="padding-left: 0;">
                                    <div class="form-group" >
                                        <label ><b>Unidad</b></label>
                                        <div id="borderUnidad">
                                            <select name="" id="select_unidad" class="form-control">
                                                  <option value="0">-Unidad-</option>
                                                  <option value="g">g</option>
                                                  <option value="mg">mg</option>
                                                  <option value="mcg">mcg</option>
                                                  <option value="mL">mL</option>
                                                  <option value="UI">UI</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" style="padding-left: 0;">
                                    <label><b>Frecuencia</b></label>
                                    <div id="borderFrecuencia">
                                        <select class="form-control" id="frecuencia" onchange="asignarHorarioAplicacion()" >
                                            <option value="0">- Frecuencia -</option>
                                            <option value="4 hrs">4 hrs</option>
                                            <option value="6 hrs">6 hrs</option>
                                            <option value="8 hrs">8 hrs</option>
                                            <option value="12 hrs">12 hrs</option>
                                            <option value="24 hrs">24 hrs</option>
                                            <option value="48 hrs">48 hrs</option>
                                            <option value="72 hrs">72 hrs</option>
                                            <option value="Dosis unica">Dosis unica</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3" style="padding-left: 0; padding-right: 0;">
                                    <label><b>Horario de administración</b></label>
                                    <div class="input-group" id="borderAplicacion">
                                        <input type="text" class="form-control" id="aplicacion" disabled='disabled' >
                                        <span class="input-group-btn">
                                            <button class="btn btn-default edit-aplicacion" type="button" value="0" title="Cambiar el horario de aplicación">Cambiar</button>
                                        </span>
                                    </div>
                                </div>
                            </div> <!-- fIN -->
                            <!-- Fecha de inicio -->
                            <div class="col-sm-12" style="padding:0">
                                <div class="col-sm-2" style="padding-left: 0;">
                                  <label><b>Fecha inicio</b></label>
                                  <div class="input-group" id="borderFechaInicio">
                                    <input id="fechaInicio" onchange="mostrarFechaFin()" class="form-control dd-mm-yyyy"  name="" placeholder="dd/mm/yyyy">
                                    <span class="input-group-btn">
                                      <button class="btn btn-default btn_fecha_actual" type="button" value="0" title="Fecha actual">Hoy</button>
                                    </span>
                                  </div>
                                </div>
                                <!-- El div cambia dependiendo el medicamento que sea prescrito -->
                                <div class="tiempo_tipo_medicamento"></div>
                            </div>
                            <!-- Observaciones -->
                            <div class="col-sm-8" style="padding: 0;" >
                                <label><b>Observaciones para la prescripción</b></label>
                                <div id="borderFechaFin">
                                    <input name="observacion_prescripcion" class="form-control" id="observacion"   name="" >
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="padding-top:23px;" >
                                      <div hidden id="div_btnActualizarPrescripcion">
                                          <button type="button"  id="btnActualizarPrescripcion" class="btn back-imss btn-block" onclick="actualizarPrescripcion()"> MODIFICAR </button>
                                      </div>
                                      <div id="btn-form-npt" hidden>
                                            <button type="button" class="btn back-imss btn-block edit-form-npt">MODIFICAR NPT </button>
                                      </div>
                                      <div id="btn-form-onco-anti" hidden>
                                            <button type="button" class="btn back-imss btn-block edit-form-onco-anti">DILUYENTE</button>
                                      </div>
                                </div>
                            </div>
                            <div class="col-sm-2" style="padding-right: 0">
                                <div class="form-group" style="padding-top:23px;">
                                    <div class="btn_agregarPrescripcion">
                                        <button type="button" class="btn back-imss btn-block"  onclick="agregarPrescripcion()"> AGREGAR </button>
                                    </div>
                                    <div class="btn_modificarPrescripcion" hidden>
                                        <button type="button" class="btn back-imss btn-block" data-value="" id="btn_modificar_prescripcion"> MODIFICAR </button>
                                    </div>
                                </div>
                            </div>
                            <table style="width:100%;">
                                <thead >
                                    <tr>
                                        <th colspan='11' class="back-imss">Medicamentos agregados</th>
                                    </tr>
                                    <tr>
                                        <th hidden >ID</th>
                                        <th>Medicamento</th>
                                        <th>Dosis</th>
                                        <th>Vía</th>
                                        <th>Frecuencia</th>
                                        <th>Aplicación</th>
                                        <th>Inicio</th>
                                        <th>Duración</th>
                                        <th>Periodo</th>
                                        <th>Fin</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaPrescripcion"></tbody>
                            </table>
                        </div>
                        <!-- Fin formulario prescripcion-->
                </div>
              
               
            </div>
        </div>
        <!-- Procedimientos Medicos -->
        <div class="panel panel-default panel-y">
            <div class="panel-heading"><h4>PROCEDIMIENTOS MEDICO</h4></div>
            <div class="panel-body">
                 <!-- procedimientos  -->
                <div class="form-group">
                    <h5><span><b>Seleccione el ó los Procedimientos Realizados al Paciente</b></span>
                        <?php
                            // Declara el estado original checkbox de procedimientos
                            // Al editar, modifica el estado del checkbox
                            if(empty($notaIngreso[0]['procedimientos'])){
                                $checkEstado = "";
                                $estadoDiv = "style='display:none'";
                                $valor_check = "0";
                            }else {
                                $checkEstado = "checked";
                                $estadoDiv = "";
                                $valor_check = "1";
                            }
                        ?>
                        <label class="md-check">
                            <input type="checkbox" name="check_procedimientos" <?=$checkEstado ?> value="<?= $valor_check ?>">
                            <i class="green"></i>
                        </label>
                    </h5>
                    
                     <div class="input-group m-b div_procedimientos" <?=$estadoDiv?> >
                        <span class="input-group-addon back-imss border-back-imss"><i class="fa fa-user-plus"></i></span>
                            <select class="select2" multiple="" name="procedimientos[]" id="procedimientos" data-value="<?=$notaIngreso[0]['procedimientos']?>" style="width: 100%" >
                                 <?php foreach ($Procedimientos as $value) {?>
                                    <option value="<?=$value['procedimiento_id']?>"><?=$value['nombre']?></option>
                                 <?php }?>
                            </select>
                     </div>
                </div>                
            </div>
        </div>
        <!-- Solicitudes Medicas -->
        <div class="panel panel-default panel-y">
            <div class="panel-heading"><h4>SOLICITUDES MEDICAS</h4></div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <?php
                            if(count($Interconsultas) > 0){
                                $check = 'checked';
                                $lable_text = "";
                                $style = "";
                                $value_check = "1";
                            }else{
                              $lable_text = "";
                              $style = "style='display:none'";
                              $value_check = "0";
                            }
                        ?>
                        <h5><span class = ""><b>Solicitud de Interconsultas</b><span>
                            <label class="md-check">
                              <input type="checkbox" name="check_solicitud_interconsulta" value="<?=$value_check?>" <?=$check?> >
                              <i class="green"></i>
                              <label id="lbl_check_interconsulta"><?=$lable_text?></label>
                            </label>
                        </h5>
                        <?php
                        $interconsulta_solicitada = "";
                        for ($x=0; $x < count($Interconsultas); $x++) {
                            if($x == 0){
                            $interconsulta_solicitada = $Interconsultas[$x]['doc_servicio_solicitado'];
                        }else{
                          $interconsulta_solicitada = $interconsulta_solicitada.",".$Interconsultas[$x]['doc_servicio_solicitado'];
                            }
                        }
                        ?>
                        <div class="input-group m-b nota_interconsulta" <?=$style?> >
                            <span class="input-group-addon back-imss border-back-imss"><i class="fa fa-user-plus"></i></span>
                            <select class="select2" multiple="" name="nota_interconsulta[]" id="nota_interconsulta" data-value="<?=$interconsulta_solicitada?>" style="width: 100%" >
                              <?php foreach ($Especialidades as $value) {?>
                              <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                              <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group nota_interconsulta" <?=$style?> >
                        <label for=""><b>MOTIVO</b></label>
                        <textarea class="form-control motivo_interconsulta" name="motivo_interconsulta"><?=$Interconsultas[0]['motivo_interconsulta']?></textarea>
                    </div>
                </div>
                  <!-- Solicitud de laboratorio -->
                <div class="col-sm-12" id="EstudiosLaboratorio">
                    <div class="form-group">
                        <h5><span><b>Solicitud de Estudios de Laboratorio:</b></span>
                             <?php
                            if( $um_estudios_obj[0]['solicitud_id'] && $um_estudios_obj[0]['estudios']!="{}"){
                                $hidden = "";
                            ?>    
                            <label class="md-check" >&nbsp;<input type="checkbox" id="check_estudios_lab" checked >
                                <i class="green"></i>
                            </label>
                        </h5>
                            <input type="hidden" name="solicitud_laboratorio_id" value="<?=$um_estudios_obj[0]['solicitud_id']?>">
                            <input type="hidden" id ="arreglo_id_catalogo_estudio" name="arreglo_id_catalogo_estudio"  class="" type="text" size="15" maxlength="30" value='<?=$um_estudios_obj[0]['estudios']?>' name="nombre">                                    
                        <?php
                            }else{
                                 $hidden = "hidden";
                            ?>                                  
                            <label class="md-check" >&nbsp;<input type="checkbox" id="check_estudios_lab"  >
                                <i class="indigo"></i>
                            </label>
                            <input type="hidden" name="solicitud_laboratorio_id" value="<?=$um_estudios_obj[0]['solicitud_id']?>">
                            <input type="hidden" id ="arreglo_id_catalogo_estudio" name="arreglo_id_catalogo_estudio"  class="" type="text" size="15" maxlength="30" value='{}' name="nombre">
                          
                        <?php } ?>
                            <div class="col-sm-12 <?=$hidden?>" id="panel_estudios">
                                <div class="table-wrapper">
                                    <div class="table-title">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn-info add-new pull-right" data-toggle="modal" data-target='#myModaL_1'><i class="fa fa-plus"></i> Agregar Nuevo</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" >
                                    <table class="table table-striped tabla-catalogo-laboratorio">
                                        <thead>
                                            <tr>
                                                <th scope="col">ESTUDIO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $objeto_ = json_decode($um_estudios_obj[0]['estudios']);
                                            foreach($objeto_ as $nombre => $valor){
                                            $estudios = explode("&", $nombre);
                                        ?>                                   
                                        <tr id="catalogo_lab_<?=$estudios[0]?>" value = "<?=$nombre?>"  >
                                            <td><?=$estudios[3]?></td>
                                            <td><a class="delete_row_catalogo_lab" title="Borrar" data-toggle="tooltip" value = "<?=$nombre?>" ><i class="glyphicon glyphicon-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Medico tratante(s) -->
        <div class="panel panel-default ">
          <div class="panel-heading"><h4>Médico Tratante</h4></div>
          <div class="panel-body">
            <div class="col-md-12">
                <?php 
                    foreach ($INFO_MEDICO as $value) {
                      $medicoRol = $value['empleado_roles'];
                    } 
                    if($medicoRol == 2) {?>                                  
                        <div class="col-md-12" style="background: white; padding: 25px 15px 15px 15px">
                          <div class="form-group">
                              <div class="row">
                                  <div class="col-md-6">
                                      <label><b>NOMBRE</b></label>
                                      <input type="text" name="medicoTratante" value="<?=$value['empleado_nombre'].' '.$value['empleado_apellidos']?>" readonly="" class="form-control">
                                  </div>
                                  <div class="col-md-3">
                                      <label><b>MATRICULA</b></label>
                                      <input type="text" name="MedicoTratante" value="<?=$value['empleado_matricula']?>" readonly="" class="form-control">
                                  </div>
                                  <div class="col-md-3">
                                    <label><b>CEDULA PROFESIONAL</b></label>
                                    <input type="text" name="cedulaMedico" value="<?=$value['empleado_cedula']?>" readonly="" class="form-control">
                                </div>
                              </div>
                          </div>
                        </div>                      
                <?php }else {

                    $medicoTratante= $this->config_mdl->sqlGetDataCondition('os_empleados',array('empleado_id'=> $notaIngreso[0]['id_medico_tratante']));
                ?>   
                        <div class="col-sm-12 col-md-12" style="padding-bottom: 10px">
                            <div style="background: white; border-bottom: 2px solid #E6E9ED">
                                <h4>MÉDICO TRATANTE <small>NOMBRE DE MEDICOS RESIDENTES</small></h4>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-ms-8">
                                  <label>Nombre de supervisor Médico de Base:</label>
                                  <input class="form-control" name="medicosBase" id="medicosBase" placeholder="Tecleé el nombre del medico y seleccione" value="<?=$medicoTratante[0]['empleado_nombre']?> <?=$medicoTratante[0]['empleado_apellidos']?>" autocomplete="off" required>     
                                  <input type="hidden" name="medicoTratante" id="id_medico_tratante" value="<?=$notaIngreso[0]['id_medico_tratante']?>"> 
                                </div>
                                <div class="col-sm-3 col-md-3">
                                  <label>Matriucula </label>           
                                    <input class="form-control" id="medicoMatricula" type="text" name="medicoMatricula" placeholder="Matrícula Medico" value="<?=$medicoTratante[0]['empleado_matricula']?>"  readonly>  
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 disabled" style="padding-bottom: 12px">        
                            <div class="form-group">
                               
                              <div class="col-sm-4 col-md-3"> 
                                <label>Nombre(s) de médico(s) residente(s):</label>  
                                <input type="text" required class="form-control" id="" name="nombre_residente[]" placeholder="Nombre(s)" value="<?=$Residentes[0]['nombre_residente']?>" >
                              </div>
                              <div class="col-sm-3">
                                <label>Apellido paterno y materno </label>
                                   <input type="text" class="form-control" id="medico<?=$i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?=$Residentes[0]['apellido_residente']?>" required>
                                 </div>                             
                              <div class="col-sm-3 col-md-3">
                                <label>Cédula Profesional</label>
                                <input class="form-control" id="residenteCedula" type="text" name="cedula_residente[]" placeholder="Cédula Profesional" value="<?=$Residentes[0]['cedulap_residente']?>" required>
                              </div>
                              <div class="col-sm-2 col-md-2">
                                <label>Grado</label>
                                <input class="form-control" id="grado" type="text" name="grado[]" placeholder="Grado (ej. R3MI)" value="<?=$Residentes[0]['grado']?>" required>
                              </div>
                              <div class="col-sm-1 col-md-1">
                                <label>Agregar +</label>
                                <a href='#' class="btn btn-success btn-xs " style="width:100%;height:100%;padding:7px;" id="add_otro_residente" data-original-title="Agregar Médico Residente"><span class="glyphicon glyphicon-plus "></span></a>
                              </div>
                          
                            </div>
                        </div>
                        <div id="medicoResidente" style="padding-top: 10px">
                            <?php for($i = 1; $i < count($Residentes); $i++){?>
                                <div class="col-sm-12 form-group">
                                   <div class="col-sm-4 col-md-3">
                                    <!-- <label style="color: white;">Nombres</label> -->
                                     <input type="text" class="form-control" id="medico<?=$i ?>" name="nombre_residente[]" placeholder="Nombre(s)" value="<?=$Residentes[$i]['nombre_residente']?>"  >
                                   </div>
                                   <div class="col-sm-4 col-md-3">
                                    <!-- <label style="color: white;">Apellidos</label> -->
                                     <input type="text" class="form-control" id="medico<?=$i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?=$Residentes[$i]['apellido_residente']?>"  >
                                   </div>
                                   <div class="col-sm-3 col-md-3">
                                    <!-- <label style="color: white;">Cedula</label> -->
                                     <input type="text" class="form-control" id="medico<?=$i ?>" name="cedula_residente[]" placeholder="Cédula Profesional" value="<?=$Residentes[$i]['cedulap_residente']?>"  >
                                   </div>
                                   <div class="col-sm-2 col-md-2">
                                    <input class="form-control" id="grado" type="text" name="grado[]" placeholder="Grado (ej. R3MI)" value="<?=$Residentes[$i]['grado']?>" required>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                <?php }?>               
            </div>
          </div>
        </div>
        <!-- Botones de Aceptar y Cancelar -->
        <div class="row">
            <div class="col-md-12" style="padding-bottom: 25px; padding-top: 25px">
                <div class="col-md-offset-6 col-md-3" >
                    <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
                </div>
                <div class="col-md-3">
                    <input type="hidden" name="csrf_token" >
                    <input type="" name="triage_id" value="<?=$_GET['folio']?>">
                    <input type="hidden" name="id_nota" value="<?=$_GET['idnota']?>">
                    <input type="hidden" name="accion" value="<?=$_GET['a']?>">
                    <input type="hidden" name="tipo" value="<?=$_GET['tipo']?>">
                    <input type="hidden" name="estado" value="<?=$ingresoHosp[0]['estado']?>">
                    <input type="hidden" name="tipo_nota" value="<?=$_GET['TipoNota']?>">
                    <button class="btn back-imss btn-block" type="submit">Guardar</button>
                </div>
            </div>
        </div>

        <!-- Modal para residentes-->
        <div class="modal fade" tabindex="-1" id="modalResnts" role="dialog">
            <div class="modal-dialog" id="modalTamanioG">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Agregar Datos del Médico Residente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label><b>Grado</b></label>
                                        <select class="selectpicker form-control" id="residente_id" name="residente_id">
                                            <option value="R1">R1</option>
                                            <option value="R2">R2</option>
                                            <option value="R3">R3</option>
                                            <option value="R4">R4</option>
                                            <option value="R5">R5</option>
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name"><b>Nombre(s)</b></label>
                                    <input type="text" class="form-control" name="nombre[]">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lastname"><b>Apellidos</b></label>
                                    <input type="text" class="form-control" name="apellidos[]">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cedula"><b>Cédula</b></label>
                                    <input type="text" class="form-control" name="cedula[]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="agregarResidente()" class="btn btn-default" data-dismiss="modal">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modales para escalas de salud -->
        <!-- Escala de glasgow -->
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" id="modalTamanioG">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Puntuación de la Escala de Glasgow</h4>
                    </div>
                    <div class="modal-body">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border label_glasgow_ocular"><b>APERTURA OCULAR</b></legend>
                                <div class="form-group">
                                    <label class="md-check">
                                    <input type="radio" class='sum_glasgow' name="apertura_ocular" value="4" <?= ($escalaSalud[0]['glasgow_ocular'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Espontánea</label>&nbsp;&nbsp;
                                    <label class="md-check">
                                    <input type="radio" class='sum_glasgow' name="apertura_ocular" value="3" <?= ($escalaSalud[0]['glasgow_ocular'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Hablar</label>&nbsp;&nbsp;
                                    <label class="md-check">
                                    <input type="radio" class='sum_glasgow' name="apertura_ocular" value="2" <?= ($escalaSalud[0]['glasgow_ocular'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Dolor</label>&nbsp;&nbsp;
                                    <label class="md-check">
                                    <input type="radio" class='sum_glasgow' name="apertura_ocular" value="1" <?= ($escalaSalud[0]['glasgow_ocular'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausente</label>
                                </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border label_glasgow_motora"><b>RESPUESTA MOTORA</b></legend>
                                <div class="form-group">
                                    <label class="md-check">
                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="6" <?= ($escalaSalud[0]['glasgow_motora'] == 6 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Obedece</label>&nbsp;&nbsp;
                                        <label class="md-check">
                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="5" <?= ($escalaSalud[0]['glasgow_motora'] == 5 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Localiza</label>&nbsp;&nbsp;
                                        <label class="md-check">
                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="4" <?= ($escalaSalud[0]['glasgow_motora'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Retira</label>
                                        <label class="md-check">
                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="3" <?= ($escalaSalud[0]['glasgow_motora'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Flexión normal</label>&nbsp;&nbsp;
                                        <label class="md-check">
                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="2" <?= ($escalaSalud[0]['glasgow_motora'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Extensión anormal</label>&nbsp;&nbsp;
                                        <label class="md-check">
                                        <input type="radio" class='sum_glasgow' name="respuesta_motora" value="1" <?= ($escalaSalud[0]['glasgow_motora'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausencia de repuesta</label>
                                </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border label_glasgow_verbal"><b>RESPUESTA VERBAL</b></legend>
                                <div class="form-group">
                                    <label class="md-check">
                                    <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="5" <?= ($escalaSalud[0]['glasgow_verbal'] == 5 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Orientado&nbsp;&nbsp;</label>
                                    <label class="md-check">
                                    <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="4" <?= ($escalaSalud[0]['glasgow_verbal'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Confuso&nbsp;&nbsp;</label>
                                    <label class="md-check">
                                    <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="3" <?= ($escalaSalud[0]['glasgow_verbal'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Incoherente&nbsp;&nbsp;</label>
                                    <label class="md-check">
                                    <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="2" <?= ($escalaSalud[0]['glasgow_verbal'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Sonidos Incomprensibles&nbsp;&nbsp;</label>
                                    <label class="md-check">
                                    <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="1" <?= ($escalaSalud[0]['glasgow_verbal'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausencia de respuesta</label>
                                </div>
                                <div class="form-group">PUNTUACIÓN TOTAL: &nbsp;<input type="text" name="escala_glasgow" size="3" value="<?=$escalaSalud[0]['escala_glasgow']?>" readonly>
                                </div>
                        </fieldset>
                    </div> <!-- div del cuerpo del modal -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn_modal_glasgow" data-dismiss="">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal de riesgo de Trombosis -->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" id="modalTamanioT">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                         <h4 class="modal-title" id="myModalLabel">Escala Para Evaluar El Riesgo de Trombosis</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label><b>SELECCIONAR SEXO</b></label>
                                <div class="radio">
                                    <label><input type="radio" name="rt_sexo" value="m">Masculino</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="rt_sexo" value="f">Femenino</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                            <label><b>EDAD</b></label>
                            <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="0">Entre 1-40 años. <b>(0 ptos).</b></label></div>
                            <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="1">Entre 41-60 años. <b>(1 pto).</b></label></div>
                            <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="2">Entre 61-74 años. <b>(2 ptos).</b></label></div>
                            <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="3">75 años o más. <b>(3 ptos).</b></label></div>
                            </div>
                            <div class="col-md-4 col-mujer hidden">
                                <div class="checkbox">
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt4" value="1">Uso de terapia de remplazo hormonal. <b>(1 pto)</b></label>
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt5" value="1">Embarazo o parto en el último mes. <b>(1 pto)</b></label>
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt6" value="1">Historia de muerte inexplicable de recién nacidos, abortos expontáneos (más de 3), hijos prematuros o con restricción del crecimento. <b>(1 pto)</b></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label><b>CIRUGÍAS</b></label>
                                <div class="checkbox">
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt7" value="1">Cirugía menor prevista (≤ 45 minutos). <b>(1 pto)</b></label>
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt8"  value="1">Antecedentes de cirugía mayor (≥ 45 minutos) en el último mes. <b>(1 pto)</b></label>
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt9" value="2">Cirugía mayor a 45 minutos (incluyendo laparoscopía o artroscopia). <b>(2 ptos)</b></label>
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt10" value="5">Cirugía de remplazo de cadera o rodilla. <b>(5 ptos)</b></label></div>
                            </div>
                            <div class="col-md-4">
                                <label><b>HISTORIA DE...</b></label>
                                <div class="checkbox">
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt11" value="3">Historia de trombosis, trombosis venosa profunda (TVP) o tromboembolia pulmonar (TEP). <b>(3 ptos)</b></label>
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt12" value="3">Historia familiar de trombosis. <b>(3 ptos)</b></label>
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt13" value="3">Historia familiar o personal de pruebas de sangre positivas que indican incremento en el riesgo de trombosis. <b>(3 ptos)</b></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label><b>ANTECEDENTES CON MENOS DE 1 MES</b></label>
                                <div class="checkbox">
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt14" value="1">Infarto de miocardio ( ≤ 1 mes). <b>(1 pto)</b></label>
                                <label style="TEXT-ALIGN:left"><input type="checkbox" class="suma_rt" name="rt15" value="1">Insuficiencia cardiaca congestiva ( ≤ 1 mes). <b>(1 pto)</b></label>
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt16" value="1">Infección grave (neumonía) ( ≤ 1 mes). <b>(1 pto)</b></label>
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt17" value="1">Enfermedad pulmonar (Enfisema o EPOC). ( ≤ 1 mes) <b>(1 pto)</b></label>
                                <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt18" value="1">Transfusión  sanguínea ( ≤ 1 mes). <b>(1 pto)</b></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label><b>COMORBILIDADES</b></label>
                                <div class="checkbox">
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt19" value="1">Historia de enfermedad inflamatoria intestinal (CUCI o Crohn). <b>(1 pto)</b></label>
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt20" value="2">Antecedente de cáncer (excluyendo cáncer de piel, no melanoma). <b>(2 ptos)</b></label>
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt21" value="1">Obesidad (índice de masa corporal ≥ de 30 y ≤ de 40). <b>(1 pto)</b></label>
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt22" value="2">Obesidad mórbida (índice de masa corporal mayor a 40). <b>(2 ptos)</b></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label><b>ORTOPEDIA Y TRAUMATISMOS</b></label>
                                <div class="checkbox">
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt23" value="5">Fractura de cadera pelvis o pierna. <b>(5 ptos)</b></label>
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt24" value="5">Traumatismo grave (accidente automovilístico, fracturas múltiples). <b>(5 ptos)</b></label>
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt25" value="5">Lesión de la médula espinal con parálisis. <b>(5 ptos)</b></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label><b>EXPLORACIÓN</b></label>
                                <div class="checkbox">
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt26" value="1">Venas varicosas visibles. <b>(1 pto)</b></label>
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt27" value="1">Edema de piernas. <b>(1 pto)</b></label>
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt28" value="2">Inmovilizador o yeso en miembros inferiores que no permite movilización en el último mes. <b>(2 ptos)</b></label>
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt29" value="2">Catéter en vasos sanguíneos del cuello o tórax que lleva sangre o medicamentos al corazón en el último mes. <b>(2 ptos)</b></label>
                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt30" value="2">Confinado en cama por  72 horas o más. <b>(2 ptos)</b></label>
                                </div>
                            </div>
                        </div>
                    </div> <!-- modal-body  de riesgo de trombosis-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Laboratorio -->
        <div class="modal fade" id="myModaL_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" id="modalTamanioT">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                         <h4 class="modal-title" id="myModalLabel">Estudios de Laboratorio</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                        <select  class="form-control" id="menu" onchange="dimePropiedades();">
                        <?php
                        foreach($um_catalogo_laboratorio_area as $area){ ?>
                          <option value="<?= $area['area']?>"> <label><b><?= $area['area'] ?></b></label></option>
                        <?php }?>
                        </select>
                            <?php
                            $ahidden = "";
                            foreach($um_catalogo_laboratorio_area as $area){
                            ?>
                            <div class="col-md-12 <?= $ahidden ?>" id ="area-<?= $area['area'] ?>">   
                                <div class="row">
                                    <label><b>---------<?= $area['area'] ?>---------</b></label> 
                                </div>
                                <?php
                                foreach ($um_catalogo_laboratorio_tipos[$area['area'] ] as $tipo) {
                                ?>
                                    <div class="col-md-2">                                     
                                    <div class="checkbox">
                                        <div class="row">
                                        <label class="label" style="background-color: #4169E1"><?= $tipo['tipo'] ?></label>
                                        </div>
                                        <?php
                                        foreach($um_catalogo_laboratorio as $estudios){
                                            if($estudios['tipo']==$tipo['tipo'] && $estudios['area']==$area['area']){
                                                $value_estudios = $estudios['catalogo_id'].'&'.$estudios['area'].'&'.$estudios['tipo'].'&'.$estudios['estudio'];
                                                if(property_exists($objeto_, $value_estudios)){
                                        ?>
                                                    <div class="row">
                                                    <label style="TEXT-ALIGN:justify"><input type="checkbox" checked class="catalogo_estudio" name="<?= $estudios['catalogo_id']?>" id="<?= 'check_catalogo_'.$estudios['catalogo_id']?>" value="<?= $value_estudios?>"><?= $estudios['estudio'] ?></label>
                                                    </div>
                                                <?php 
                                                }else{
                                                ?>
                                                    <div class="row">
                                                        <label style="TEXT-ALIGN:justify"><input type="checkbox"  class="catalogo_estudio" name="<?= $estudios['catalogo_id']?>" id="<?= 'check_catalogo_'.$estudios['catalogo_id']?>" value="<?= $value_estudios?>"><?= $estudios['estudio'] ?></label>
                                                    </div>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>                                          
                                    </div>
                                    </div>

                                <?php
                                }
                                ?>
                                </div>
                        <?php
                                $ahidden = "hidden";
                            }
                        ?>
                        </div>
                    </div> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
  </div>
</div>

<?= modules::run('Sections/Menu/footer'); ?>
<script type="text/javascript" src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js"></script>
<script src="<?= base_url('assets/js/sections/CIE10.js?md5='). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/libs/bootstrap3-typeahead/bootstrap3-typeahead.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/DocumentosHosp.js?md5'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Diagnosticos.js?md5'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Laboratorios.js?md5'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/build/jodit.min.js')?>"></script>

<script type="text/javascript">
  var paciente = $('input[name=triage_id]').val();
  window.onload = ActualizarHistorialPrescripcion(paciente, 0);
</script>
<script>
  var editors = [].slice.call(document.querySelectorAll('.editor'));
  editors.forEach(function (textarea) {
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
                                  'source', '|',
                                  'font', 
                                  'fontsize', '|',
                                  'bold',
                                  'italic', '|',
                                  'ul',
                                  'ol', '|',
                                  'outdent', 'indent',  '|',
                                  'brush',
                                  'paragraph', '|',
                                  //'image',
                                  'table', '|',    
                                  'align', 'undo', 'redo', '|',
                                  'eraser', '|',              
                                  'symbol',
                                  'fullsize', 
                              ],
                      buttonsMD: [
                                  'source', '|',
                                  'font', 
                                  'fontsize', '|',
                                  'bold',
                                  'italic', '|',
                                  'ul',
                                  'ol', '|',
                                  'outdent', 'indent',  '|',
                                  'brush',
                                  'paragraph', '|',
                                  //'image',
                                  'table', '|',    
                                  'align', 'undo', 'redo', '|',
                                  'eraser', '|',              
                                  'symbol',
                                  'fullsize',
                                ],
                      buttonsSM:  ',about',
                      buttonsXS: 'source'
  
                });

                //editor.selection.insertCursorAtPoint(e.clientX, e.clientY);
            }
        //});
    });
</script>

