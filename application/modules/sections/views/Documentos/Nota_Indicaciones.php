<?= modules::run('Sections/Menu/HeaderNotas'); ?>
<link rel="stylesheet" href="<?= base_url()?>assets/libs/jodit-3.2.43/build/jodit.min.css"/>

<!-- <link rel="stylesheet" href="<?= base_url()?>assets/styles/notas.css"/> -->
<style type="text/css">
  .label-input{
  text-align: center;
  border:none;
  background:none;
  margin:0;
  outline:0;
  width: 100%;
}

.tile.infopanel {
  background-color: white;
}
</style>
<!-- <link rel="stylesheet" href="<?= base_url()?>assets/styles/notas.css"/>-->
<div class="col-xs-11 col-md-11 col-centered" style="margin-top: 10px">
  <div class="box-inner">
    <div class="panel-heading p bg-white text-center"> <!-- Cabecera de datos del paciente -->
      <div class="row" style="margin-top: -15px!important;">
        <div style="position: relative;">
          <div style="margin-left: -1px;position: absolute;">
            <img src="<?= base_url()?>assets/img/patients/patient_m.png" style="width: 90px;"/>
          </div>
        </div>
        <div class="col-xs-5 col-sm-5 text-left" style="padding-left: 85px">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <h5 class="text-color-cyan">
              <b><?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?></b>
            </h5>
            <?php
              if($info['triage_fecha_nac']!=''){
                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                $edad =  '<b>de'.' '. $fecha->y.' años</b>';
              }else $edad = "<b>desconocido</b>";       
            ?>
            <h5 class="text-color-black">
              <b><?=ucwords(strtolower($info['triage_paciente_sexo']));?> <?=$edad?> 
                <?=$PINFO['pic_indicio_embarazo']=='Si' ? '|   Posible Embarazo' : ''?>
              </b>
            </h5>
            <h5 class="text-color-blue">
              <b>NSS: <?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?></b>
            </h5>  
          </div>
        </div>
        <div class="col-md-7">
          <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="padding: 5px 0px 10px 0px;">
            <span class="text-color-blue">Fecha de última toma de signos: <?= date("d-m-Y", strtotime($UltimosSignosVitales[0]['fecha']));?></span>
          </div>
          <div class="col-xs-1 col-sm-1 col-md-1 text-center" style="width: 20%;">
            <h5 class="text-color-cyan"style="margin-top: -5px;"><b>T.A</b></h5>
            <h5 class="text-color-red" style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_ta']?> mm Hg</h5>
          </div>
          <div class="col-xs-1 col-sm-1 col-md-1 text-center" style="border-left: 1px solid black; width: 20%;">
            <h5 class="text-color-cyan"style="margin-top: -5px;"><b>Temp.</b></h5>
            <h5 class="text-color-red" style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_temp']?> °C</h5>
          </div>
          <div class="col-xs-1 col-sm-1 col-md-1 text-center" style="border-left: 1px solid black; width: 20%;">
            <h5 class="text-color-cyan"style="margin-top: -5px;"><b>F. Card.</b></h5>
            <h5 class="text-color-red" style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_fc']?> lpm</h5>
          </div>
          <div class="col-xs-1 col-sm-1 col-md-1 text-center" style="border-left: 1px solid black; width: 20%;">
            <h5 class="text-color-cyan"style="margin-top: -5px;"><b>F. Resp</b></h5>
            <h5 class="text-color-red" style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_fr']?> rpm</h5>
          </div>
          <div class="col-xs-1 col-sm-1 col-md-1 text-center" style="border-left: 1px solid black; width: 20%;">
            <h5 class="text-color-cyan"style="margin-top: -5px;"><b>SpO2</b></h5>
            <h5 class="text-color-red" style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_oximetria']?> %</h5>
          </div>  
        </div>
        <!--
        <div class="col-xs-2 col-sm-2 col-md-2">
            <h4 class="text-center">    
            <?php
              $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info['triage_codigo_atencion']);
              echo ($codigo_atencion != '')?"<br><span class='text-warning' style='font-size:20px'><b>Código $codigo_atencion</b></span>":"";
            ?>
        </div> -->
      </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:1px">
          <span class="input-group-addon back-imss border-back-imss"><b>NOTA DE INDICACIONES</b></span>
        </div>
    </div>
    <form class="notaIndicacciones">
      <!-- Panel de Actulizar signos vitales -->
      <div class="tile infopanel mb-4" style="margin-top: 15px">
        <div class="">
          <div class="row">
            <div class="col-lg-12">
              <h2 class="mb-3 line-head">Actualización de signos vitales</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-sm-12 col-md-12">
            <div class="col-md-2">
              <div class="form-group">
                <label><b>T. Arterial (mmHg)</b></label>
                <input class="form-control"  name="sv_ta" value="<?=$signosVitalesNota['sv_ta']?>">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label><b>Temp (°C)</b></label>
                  <input class="form-control" name="sv_temp"  value="<?=$signosVitalesNota['sv_temp']?>">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label><b>F. Card (lpm)</b></label>
                  <input class="form-control" name="sv_fc"  value="<?=$signosVitalesNota['sv_fc']?>">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label><b>F. Resp (rpm)</b></label>
                <input class="form-control" name="sv_fr"  value="<?=$signosVitalesNota['sv_fr']?>">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label><b>SP02 (%)</b></label>
                <input class="form-control" name="sv_oximetria"  value="<?=$signosVitalesNota['sv_oximetria']?>">
              </div>
            </div>
            <div class="col-md-2">
              <div class="control-group">
                <label><b>GLUCOSA (mg/dl)</b></label>
                <input class="form-control" name="sv_dextrostix"  value="<?=$signosVitalesNota['sv_dextrostix']?>">
              </div>
            </div>
          </div>
        </div>
     </div>
      <!--Panel de indicaciones -->
      <div class="tile infopanel mb-4">
        <div>
          <div class="row">
            <div class="col-lg-12"><h3 class="line-head" id="resumenProcedimiento">Indicaciones Médicas y Prescripciones</h3></div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <h4 class="bold">Indicaciones de Nutrición</h4>
            <div class="col-md-12">
            <?php
                // Declara estado original del radio cuando se realiza nueva nota
                $checkAyuno = '';
                $checkDieta = '';
                $divSelectDietas = 'hidden';
                $select_dietas = '0';
                $otraDieta = '';
                $divOtraDieta = 'hidden';
                if($_GET['a'] == 'edit'){
                  if($NotaIndicaciones['dieta'] == '0'){
                    $checkAyuno = 'checked';
                  }else if($NotaIndicaciones['dieta'] == '1' || $NotaIndicaciones['dieta'] == '2'
                  || $NotaIndicaciones['dieta'] == '3'|| $NotaIndicaciones['dieta'] == '4'|| $NotaIndicaciones['dieta'] == '5'
                  || $NotaIndicaciones['dieta'] == '6'|| $NotaIndicaciones['dieta'] == '7'|| $NotaIndicaciones['dieta'] == '8'
                  || $NotaIndicaciones['dieta'] == '9'|| $NotaIndicaciones['dieta'] == '10'|| $NotaIndicaciones['dieta'] == '11'
                  || $NotaIndicaciones['dieta'] == '12'){
                    $checkDieta = 'checked';
                    $divSelectDietas = '';
                    $select_dietas = $NotaIndicaciones['dieta'];
                  }else{
                    $divSelectDietas = '';
                    $checkDieta = 'checked';
                    $divOtraDieta = '';
                    $select_dietas = '13';
                    $otraDieta = $NotaIndicaciones['dieta'];
                  }
                }
              ?>
              <div class="form-group radio">
                <label class="md-check">
                  <input type="radio" class="has-value" value="0" id='radioAyuno' name="dieta" <?= $checkAyuno ?> ><i class="cyan"></i>Ayuno
                </label>
                <label class="md-check">
                  <input type="radio" class="has-value" value="" id='radioDieta' name="dieta" <?= $checkDieta ?> ><i class="cyan"></i>Dieta
                </label>
              </div>
            </div>
            <div  class="col-sm-3"  id="divSelectDietas"  <?= $divSelectDietas ?> >
              <div class="form-group">
                <label>Tipos de dieta:</label>
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
            <div class="col-sm-9" id='divOtraDieta' style="padding:0" <?= $divOtraDieta ?> >
              <div class="form-group">
                <label>Otra dieta:</label>
                <input type="text" class="form-control" name="otraDieta" value="<?= $otraDieta ?>" id="inputOtraDieta" placeholder="Otra dieta">
              </div>
            </div>
          </div>
          
          <div class="col-lg-12">
            <h4 class="bold">Indicaciones de Enfermeria</h4>
            <?php
              // Declara estado original del select cuando se realiza nueva nota
              $select_signos = 0;
              $otras_indicaciones = 'hidden';
              // El estado de las variables cambia al realizar un cambio, esto para determinar si el valor corresponde al select o textarea
              if($_GET['a'] == 'edit'){
                if($NotaIndicaciones['svitales'] == '0' || $NotaIndicaciones['svitales'] == '1' || $NotaIndicaciones['svitales'] == '2' ){
                  $select_signos = $NotaIndicaciones['svitales'];
                }else{
                  $select_signos = "3";
                  $otras_indicaciones = '';
                }
              }
            ?>
            <div  id="divSignos">
              <div class="col-sm-4"> 
                <div class="form-group" style="padding:0" id="divTomaSignos">
                  <label>Toma de signos vitales</label>
                  <select  id="selectTomaSignos" class="form-control" data-value="<?= $select_signos ?>" name="tomaSignos">
                    <option value="0" unselected>Seleccionar</option>
                    <option value="1">Por turno</option>
                    <option value="2">Cada 4 horas</option>
                    <option value="3">Otros</option>
                  </select>
                </div>
              </div>
              <div id="divOtrasInidcacionesSignos"  <?= $otras_indicaciones ?>>
                <div class="col-sm-8 form-group" style="padding-right: 0">
                <label>Otras inidcaciones:</label>
                <input type="text" id="otras-indicaciones-signos" name="otrasIndicacionesSignos" class="form-control" placeholder="Otras indicaciones" value="<?=$NotaIndicaciones['svitales']?>">
                </div>
              </div>
            </div>
            <div class="col-sm-12" id="divCuidadosGenerales">
              <div class="form-group ">
                <label>Cuidados Generales de Enfermería:
                    <?php
                    // Declara el estado original checkbox de cuidados generales de enfermeria
                    $labelCheck = 'SI';
                    $hiddenCheck = 'hidden';
                    // Al editar, modifica el estado del checkbox
                    if($NotaIndicaciones['cuidados_generales'] == 1){
                      $check_generales = 'checked';
                      $labelCheck = '';
                      $hiddenCheck = '';
                    }
                    ?>
                  <input type="checkbox" id="checkCuidadosGenerales" name="nota_cgenfermeria" value="1" <?= $check_generales ?> > 
                  <label id="labelCheckCuidadosGenerales"><?= $labelCheck ?></label>
                </label>
                <ul id="listCuidadosGenerales" <?= $hiddenCheck ?> >
                  <li>a. Estado neurológico</li>
                  <li>b. Cama con barandales</li>
                  <li>c. Calificación del dolor</li>
                  <li>d. Calificación de riesgo de caida</li>
                  <li>e. Control de liquidos por turno</li>
                  <li>f. Vigilar riesgo de úlceras por presión</li>
                  <li>g. Aseo bucal</li>
                  <li>h. Lavado de manos</li>
                </ul>
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label>Cuidados Especiales de Enfermería</label>
                <textarea class="form-control nota_cuidadosenfermeria editor" name="nota_cuidadosenfermeria" rows="5" id="area_editor6" placeholder="Anote las Indicaciones de cuidados especiales de enfermeria"><?=$NotaIndicaciones['cuidados_especiales']?></textarea>
              </div>
            </div>
      
            <div class="col-sm-12">
              <div class="form-group">
                <label>Soluciones parenterales</label>
                <textarea class="form-control nota_solucionesp editor" name="nota_solucionesp" rows="5" id="area_editor7" placeholder="Anote las soluciones parenterales indicadas"><?=$NotaIndicaciones['solucionesp']?></textarea>
              </div>
            </div>
      
          </div>
          <div class="col-lg-12">
            <h4 class="bold">Medicamentos</h4>
            <div class="col-md-12">                    
              <div class="panel-heading" style="background-color: #e3f2fd">
                <ul class="nav nav-tabs table-hover submenu">
                  <li class="pointer">
                    <a class=" showclass submenu_prescripciones" id="acordeon_prescripciones_activas" data-toggle="tab"><b>Activas:</b>
                        <label class="indicador" id="label_total_activas"><?= $Prescripciones_activas[0]['activas'] ?></label>
                    </a>
                  </li>
                  <li>
                    <a class="submenu_prescripciones" id="acordeon_prescripciones_sin_validar" data-toggle="tab"><b>Por validar:</b>
                        <label class="indicador" id="label_total_pendientes"><?= $Prescripciones_pendientes[0]['pendientes'] ?></label>
                    </a>
                  </li>                          
                  <li>
                    <a class="submenu_prescripciones" id="acordeon_prescripciones_canceladas" data-toggle="tab"><b>Canceladas o actualizadas:</b>
                        <label class="indicador" id="label_total_canceladas"><?= count($Prescripciones_canceladas) ?></label>
                    </a>
                  </li>
                  <li>
                    <a class="submenu_prescripciones" id="acordeon_reacciones" data-toggle="tab"><b>Reacciones adversas:</b>
                        <label class="indicador" id="label_total_reacciones"><?= count($ReaccionesAdversas) ?></label>
                    </a>
                  </li>
                  <li>
                    <a class="submenu_prescripciones" id="acordeon_notificaciones" data-toggle="tab"><b>Interacciones farmacologica:</b>
                        <label class="indicador" id="label_total_notificaciones"><?= count($Notificaciones) ?></label>
                    </a>
                  </li>
                  <li>
                    <a class="submenu_prescripciones" id="acordeon_alergia_medicamentos" data-toggle="tab"><b>Alergias a medicamentos:</b>
                        <label class="indicador" id="label_total_reacciones" ><?= count($AlergiaMedicamentos) ?></label>
                    </a>
                  </li>  
                  <li>
                    <a class="submenu_prescripciones" id="acordeon_notificaciones" data-toggle="tab"><b>Notificaciones:</b>
                        <label class="indicador" id="label_total_notificaciones">0</label>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-12">
              <table class="tablaPrescripciones" id="historial_medicamentos_activos" style="width:100%;" hidden>
                <thead id="historial_prescripcion" >
                  <tr>
                    <th>Medicamento</th>
                    <th>Fecha prescripción</th>
                    <th>Dosis</th>
                    <th>Vía</th>
                    <th>Frecuencia</th>
                    <th>Aplicación</th>
                    <th>Fecha Inicio</th>
                    <th colspan="2">Tiempo</th>
                    <th>Fecha Fin</th>
                    <th id="col_dias">Días Transcurridos</th>
                    <th id="col_fechaFin" >Acciones</th>
                  </tr>
                </thead>
                <tbody id="table_prescripcion_historial">
                </tbody>
              </table>
            </div>
            <table class="tablaPrescripciones" id="historial_medicamentos_sin_validar" style="width:100%;" hidden>
                <thead>
                  <tr>
                    <th>Medicamento</th>
                    <th>Fecha prescripción</th>
                    <th>Dosis</th>
                    <th>Vía</th>
                    <th>Frecuencia</th>
                    <th>Aplicación</th>
                    <th>Fecha Inicio</th>
                    <th>Tiempo</th>
                    <th>Fecha Fin</th>
                  </tr>
                </thead>
                <tbody id="table_prescripciones_sin_validar">
                </tbody>
              </table>
            <div class="col-md-12">
              <div class="panel-group" id='historial_movimientos' hidden></div>        
            </div>
            <div class="col-md-12">
              <div id='historial_reacciones' hidden>
                <table style="width:100%;">
                  <thead>
                    <th>Medicamento</th>
                    <th>Observacion</th>
                  </thead>
                  <tbody id="table_historial_reacciones">
                  </tbody>
                </table>
              </div>      
            </div>
            <div class="col-md-12">
              
            </div>
            <div id="historial_alergia_medicamentos" hidden>
              <table style="width:100%;" >
                <thead>
                  <th>Medicamentos que presentan alergias</th>
                </thead>
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
              <div class="panel-group" id='historial_notificaciones' hidden>
              </div>
            </div>
            <!-- Agregar Medicamentos nuevos -->
            <div class="col-md-12" style="padding: 40px 0px 20px 0px;"> 
              <button type="button" class="btn btn-warning" id="btnAddMedicamento"><i class="fa fa-plus-square"></i> Agregar</button>
              <label for="" class="bold" id="addMedicamentoLabel" hidden>Agregar medicamentos</label>
            <div class="col-md-12 border-div-b" id="addMedicamentoDiv" style="padding-top: 20px;" hidden>
              <div class="col-md-offset-10 col-md-2">
                <button type="button" class="btn btn-danger right" id="btnCancelAddMedicamento"><i class="fa fa-minus"></i> Cancelar</button>
              </div>
              <div class="col-md-8 col-sm-8">
                <div class="form-group">
                  <label><b>Medicamento / Forma farmacéutica (Cuadro Básico)</b></label>
                  <div class="input-group">
                    <div class id="borderMedicamento" >
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
                      <button class="btn btn-default btn_otro_medicamento" type="button" value="0" title="Indicar otro medicamento">Otro medicamento</button>
                    </span>
                  </div>
                </div>
              </div>
                <!-- Formulario para antibiotico NTP
                *El formulrio es desplegado en una ventana modal* -->
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

                <!-- identificador de los medicamentos con interaccion interaccion_amarilla,
                     el select se llena al seleccionar un medicamento -->
              <div class="col-sm-2" hidden>
                <label><b>interaccion_amarilla</b></label>
                <div id="borderMedicamento">
                  <select id="interaccion_amarilla" class="" style="width: 100%" >
                      <option value="0">-Seleccionar-</option>
                      <?php foreach ($medicamentos as $value) {?>
                      <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_amarilla']?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>
                
              <div class="col-sm-2" hidden>
                <label><b>interaccion_roja</b></label>
                <div id="borderMedicamento">
                  <select id="interaccion_roja" class="" style="width: 100%" >
                    <option value="0">-Seleccionar-</option>
                    <?php foreach ($medicamentos as $value) {?>
                    <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_roja']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <!-- Via de administracion -->
              <div class="col-sm-12 ">
                <div class="col-sm-5" style="padding-left: 0px;">
                  <label><b>Via de administración</b></label>
                  <div class="input-group" id="borderVia">
                    <div id="opcion_vias_administracion">
                      <select name="" class="form control select2 width100" id="via">
                        <option value="0">-Seleccionar-</option>
                     </select>
                    </div>
                    <span class="input-group-btn">
                      <button class="btn btn-default btn_otra_via" type="button" value="0" title="Indicar otra via de administración">Otra</button>
                    </span>
                  </div>
                </div>
                <!-- Dosis -->
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
              </div>

              <div class="col-sm-12">
                <div class="col-sm-2">
                  <label><b>Fecha inicio</b></label>
                  <div class="input-group" id="borderFechaInicio">
                    <input id="fechaInicio" onchange="mostrarFechaFin()" class="form-control dd-mm-yyyy"  name="" placeholder="dd/mm/yyyy">
                    <span class="input-group-btn">
                       <button class="btn btn-default btn_fecha_actual" type="button" value="0" title="Fecha actual">Hoy</button>
                    </span>
                  </div>
                </div> 
                <!-- El div cambia dependiendo el medicamento que sea prescrito -->
                <div class="tiempo_tipo_medicamento">
                </div>
              </div>
              <div class="col-sm-8">
                <label><b>Observaciones para la prescripción</b></label>
                <div id="borderFechaFin">
                <input name="observacion_prescripcion" class="form-control" id="observacion"   name="" >
                </div>
              </div>
              <div class="col-sm-2">
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
              <div class="col-sm-2">
                <div class="form-group" style="padding-top:23px;">
                  <div class="btn_agregarPrescripcion">
                      <button type="button" class="btn back-imss btn-block"  onclick="agregarPrescripcion()"> AGREGAR </button>
                  </div>
                  <div class="btn_modificarPrescripcion" hidden>
                      <button type="button" class="btn back-imss btn-block" data-value="" id="btn_modificar_prescripcion"> MODIFICAR </button>
                  </div>
                </div>
              </div>
              <table class="tablaPrescripciones" style="width:100%;">
                <thead >
                  <tr>
                    <th colspan='11' class="back-imss">Medicamentos nuevos agregados</th>
                  </tr>
                  <tr>
                    <th hidden>ID</th>
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
                <tbody  id="tablaPrescripcion" >
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
                 
  

            <!-- Panel de medico que realiza la nota -->  
            <div class="tile infopanel">
              <div class="">
                <div class="row">
                  <div class="col-lg-12">
                    <h3 class="mb-3 line-head" id="medicoTratante">Médico(s) Tratante(s)</h3>
                  </div>
                </div>
              </div>
              <div class="row">
                <?php 
                foreach ($Usuario as $value) {
                  $medicoRol = $value['empleado_roles'];
                } 
                if($medicoRol == 2) {?>
                  <div class="col-md-12 <?= $mostrarMedicoTratante ?>">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label><b>NOMBRE</b></label>
                          <input type="text" name="medicoTratante" value="<?=$value['empleado_nombre'].' '.$value['empleado_apellidos']?>" readonly="" class="form-control">
                        </div>
                        <div class="col-md-4">
                          <label><b>MATRICULA</b></label>
                          <input type="text" name="noMedicoTratante" value="<?=$value['empleado_matricula']?>" readonly="" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>                      
                <?php }else {?>  
                <div class="col-sm-12 col-md-12">
                  <div class="form-group">
                      <div class="col-sm-8 col-ms-8">
                        <label>Nombre de supervisor Médico de Base</label>
                        <input class="form-control" name="medicosBase" id="medicosBase" placeholder="Teclee el nombre del medico tratante" value="<?=$MedicosBaseNota[0]['empleado_nombre']?> <?=$MedicosBaseNota[0]['empleado_apellidos']?>" autocomplete="off" required>     
                        <input type="hidden" name="autocomplete" id="id_empleado"> 
                      </div>
                      <div class="col-sm-3 col-md-3">
                        <label style="color: white;">C </label>           
                          <input class="form-control" id="medicoMatricula" type="text" name="medicoMatricula" placeholder="Matrícula Medico" value="<?=$MedicosBaseNota[0]['empleado_matricula']?>"  readonly>  
                      </div>
                  </div>
                </div>

                <div class="col-md-12">  
                  <div class="form-group">
                    <div class="col-md-12" style="padding: 15px 0px 15px 15px">
                      <label for="">Médicos Residente(s)</label>
                    </div>

                    <div class="col-sm-3 col-md-3"> 
                      <label>Nombre</label>  
                      <input type="text" class="form-control" id="" name="nombre_residente[]" placeholder="Nombre(s)" value="<?=$Residentes[0]['nombre_residente']?>" required>
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
                      <label>Agregar Residente</label>
                      <a href='#' class="btn btn-success btn-xs " style="width:100%;height:100%;padding:7px;" id="add_otro_residente" data-original-title="Agregar Médico Residente"><span class="glyphicon glyphicon-plus "></span></a>
                    </div>
                  </div>
                </div>
                <?php 
                  if($_GET['a'] == 'edit'){
                    $cont = 0;
                    foreach($Residentes as $value){
                      if($cont != 0) {
                        $listaResidentes .= '<div  id="areaResidentes'.$cont.'" style="padding-bottom: 45px;">
                                              <div class="col-sm-3" >
                                                <input id="medico'.$cont.'" class="form-control"  type="text" required name="nombre_residente[]" value="'.$value['nombre_residente'].'">
                                              </div>
                                              <div class="col-sm-3" >
                                                <input id="medico'.$cont.'" class=form-control type="text" required name="apellido_residente[]" value="'.$value['apellido_residente'].'">
                                              </div>
                                              <div class="col-sm-3" >
                                                <input id="medico'.$cont.'" class="form-control" type="text" required name="cedula_residente[]" value="'.$value['cedulap_residente'].'">
                                              </div>
                                              <div class="col-sm-2" >
                                                <input id="grado'.$cont.'" class="form-control"  type="text" required name="grado[]" value="'.$value['grado'].'">
                                              </div>
                                              <div class="col-sm-1" >
                                                <a href="#" onclick=quitarResidenteFormulario('.$cont.') class="btn btn-danger delete btn-xs" style="width:100%;height:100%;padding:7px;" id="quitar_residente">
                                                  <span class="glyphicon glyphicon-remove"></span>
                                                </a>
                                              </div>
                                            </div>';
                      }
                      $cont ++;

                    }
                  }else $listaResidentes = '<div class="form-group" id="medicoResidente"></div>';
                ?>
                <div class="col-md-12" style="padding-top: 20px;">
                  <!-- <div class="form-group" id="medicoResidente"></div> -->
                  <?php echo $listaResidentes ?>
                </div>
                <?php }?>  
              </div>
            </div>
              
              <div class="row" style="padding-bottom: 15px;">
                <div class="col-md-offset-8 col-md-2">
                    <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
                </div>
                <div class="col-sm-2">
                  <input name="csrf_token" type="hidden">
                  <input name="triage_id" value="<?=$_GET['folio']?>" type="hidden">
                  <input name="accion" value="<?=$_GET['a']?>" type="hidden">
                  <input name="notas_id" value="<?=$this->uri->segment(4)?>" type="hidden">
                  <input name="via" value="<?=$_GET['via']?>" type="hidden">
                  <input name="inputVia" value="<?=$_GET['inputVia']?>" type="hidden">
                  <input name="doc_id" value="<?=$_GET['doc_id']?>" type="hidden">
                  <input name="umae_area" value="<?=$this->UMAE_AREA?>" type="hidden">
                  <input name="tipo_nota" value="<?=$_GET['TipoNota']?>" type="hidden">
                  <button class="btn back-imss pull-right btn-block" type="submit" style="margin-bottom: -10px">Guardar</button>
                </div>
              </div>
          </form>
      </div>
</div>

  
<?= modules::run('Sections/Menu/FooterNotas'); ?>
<script src="<?= base_url('assets/js/sections/Documentos.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url()?>assets/libs/bootstrap3-typeahead/bootstrap3-typeahead.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/build/jodit.min.js')?>"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/assets/prism.js')?>"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/assets/app.js')?>"></script>
<script>
  $(document).ready(function() {
    $('#btnAddMedicamento').click(function(){
      $('#btnAddMedicamento').hide();
      $('#addMedicamentoLabel').removeAttr('hidden');
      $('#addMedicamentoDiv').removeAttr('hidden');
    });
    $('#btnCancelAddMedicamento').click(function(){
      $('#btnAddMedicamento').show()
      $('#addMedicamentoLabel').attr('hidden', true);
      $('#addMedicamentoDiv').attr('hidden', true);
  })
  });
    
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
                                  'hr',
                                  'eraser', '|',              
                                  'symbol',
                                  'fullsize', 
                              ],
                      buttonsMD: 'about,print',
                      buttonsSM:  ',about',
                      buttonsXS: 'source'
  
                });

                //editor.selection.insertCursorAtPoint(e.clientX, e.clientY);
            }
        //});
    });


    
</script>

