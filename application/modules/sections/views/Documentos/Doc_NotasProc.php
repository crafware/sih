<?= modules::run('Sections/Menu/HeaderBasico'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/libs/light-bootstrap/all.min.css" />
<link rel="stylesheet" href="<?= base_url()?>assets/libs/jodit-3.2.43/build/jodit.min.css"/>
<link rel="stylesheet" href="<?= base_url()?>assets/styles/notas.css"/>

            <!-- <style> .wysiwyg-text-align-center {text-align: center;}</style> -->
<div class="box-row">
  <div class="box-cell">
    <div class="col-xs-11 col-md-11 col-centered" style="margin-top: 10px">
      <div class="box-inner">
        <div class="panel panel-default ">
          <div class="panel-heading p teal-900 back-imss text-center scroll-box" style=""> <!-- Cabecera de datos del paciente -->
            <div class="row" style="margin-top: -15px!important; padding-top: 12px;">
              <div style="position: relative;">
                <!-- Color franja -->
                <div style="top: 0px; margin-left: -9px;position: absolute; height: 68px; width: 35px;" class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$info['triage_color']))?>"></div>
              </div>
              <div class="col-xs-10 col-sm-10 text-left" style="padding-left: 20px">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <h5>
                  <b>PACIENTE:</b> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
                   | <b>SEXO: </b><?=$info['triage_paciente_sexo']?> <?=$PINFO['pic_indicio_embarazo']=='Si' ? '| - Posible Embarazo' : ''?>
                   | <b>PROCEDENCIA:</b> <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEA '.$PINFO['pia_procedencia_espontanea_lugar'] : ' '.$PINFO['pia_procedencia_hospital'].' '.$PINFO['pia_procedencia_hospital_num']?>
                   | <b>NSS:</b> <?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?>
                  </h5>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <h5><b>ALERGIAS : </b><?=$PINFO['alergias'] ?></h5>
                </div>
              </div>
              <div class="col-xs-2 col-sm-2 col-md-2">
                  <h4 class="text-center">
                  <?php
                      if($info['triage_fecha_nac']!=''){
                          $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                          echo ' <span ><b>Edad: '. $fecha->y.' Años</b></span>';
                      }else{
                          echo 'S/E';
                      }
                  ?>
                  <?php
                    $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info['triage_codigo_atencion']);
                    echo ($codigo_atencion != '')?"<br><span class='text-warning' style='font-size:20px'><b>Código $codigo_atencion</b></span>":"";
                  ?>
                  </h4>
              </div>
            </div>
            <div class="back-imss" style="margin-top: -4px; margin-left:-24px; margin-right:-24px;">
                <div class="col-xs-12 col-sm-12 col-md-12 back-imss" >
                  <h5>Fecha de última toma de signos: <?= date("d-m-Y g:i a", strtotime($UltimosSignosVitales[0]['fecha']));?></h5>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 text-center back-imss" style="width: 12.5%;">
                  <h5 style="margin-top: -5px;"><b>P.A</b></h5>
                  <h5 style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_ta']?> mm Hg</h5>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                  <h5 style="margin-top: -5px;"><b>TEMP.</b></h5>
                  <h5 style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_temp']?> °C</h5>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                  <h5 style="margin-top: -5px;"><b>FREC. CARD.</b></h5>
                  <h5 style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_fc']?> lpm</h5>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                  <h5 style="margin-top: -5px;"><b>FREC. RESP</b></h5>
                  <h5 style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_fr']?> rpm</h5>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                  <h5 style="margin-top: -5px;"><b>SpO2</b></h5>
                  <h5 style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_oximetria']?> %</h5>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                  <h5 style="margin-top: -5px;"><b>GLUCEMIA</b></h5>
                  <h5 style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_dextrostix']?> mg/dL</h5>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                  <h5 style="margin-top: -5px;"><b>PESO</b></h5>
                  <h5 style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_peso']?> kg</h5>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                  <h5 style="margin-top: -5px;"><b>TALLA</b></h5>
                  <h5 style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_talla']?> cm</h5>
                </div>
            </div>
          </div>
            <div class="panel-body b-b b-light scrollspy-body">
              <div class="card-body" style="padding: 20px 0px;">
                <form class="Form-Notas-COC" oninput="x.value=parseInt(nota_eva.value)">
                  <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: -15px">
                    <div class="form-group">
                      <div class="input-group m-b">
                        <?php
                          $tipo_nota = 'Nota de Evolución';
                          if($_GET['via'] == 'Interconsulta'){
                            $tipo_nota = 'Nota de Interconsulta';
                          }else if($_GET['via'] == 'Valoración'){
                            $tipo_nota = 'Nota de Seguimiento de Interconsulta';
                          }?>
                          <span class="input-group-addon back-imss border-back-imss">
                            <input type="text" class="tipo_nota form-control width100" name="notas_tipo" value="<?=$tipo_nota?>" readonly>
                         </span>
                      </div>
                    </div>
                  </div>
                  </div>
                  <!-- Si se agrega nota nueva presenta el boton de importar nota anterior sino ocultar -->
                  <!-- <?php if($_GET['a'] == 'add') {?> -->
                  <!-- <div class="col-md-12">
                    <div class="checkbox">
                        <label>
                          <input type="checkbox" id="checkbox_importaNota" data-toggle="toggle" data-size="small" data-off="importar" data-on="Cancelar">
                          IMPORTAR LA ÚLTIMA NOTA DE VALORACIÓN DE ESTE PACIENTE GENERADA EN EL SERVICIO
                        </label>
                    </div>
                  </div> -->
                  <!-- <?php }?> -->
                  <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <h4><span class = "label back-imss border-back-imss">ACTUALIZACIÓN DE SIGNOS VITALES</span></h4>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="col-xs-4 col-sm-3 col-md-2">
                      <div class="form-group">
                        <label><b>PANI (mmHg)</b></label>
                        <input class="form-control"  name="sv_ta" value="<?=$signosVitalesNota['sv_ta']?>">
                      </div>
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2">
                      <div class="form-group">
                        <label><b>TEMP (°C)</b></label>
                          <input class="form-control" name="sv_temp"  value="<?=$signosVitalesNota['sv_temp']?>">
                      </div>
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2">
                      <div class="form-group">
                        <label><b>f. CARDIACA (lpm)</b></label>
                          <input class="form-control" name="sv_fc"  value="<?=$signosVitalesNota['sv_fc']?>">
                      </div>
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2">
                      <div class="form-group">
                        <label><b>f. RESP (rpm)</b></label>
                        <input class="form-control" name="sv_fr"  value="<?=$signosVitalesNota['sv_fr']?>">
                      </div>
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2">
                      <div class="form-group">
                        <label><b>SP02 (%)</b></label>
                        <input class="form-control" name="sv_oximetria"  value="<?=$signosVitalesNota['sv_oximetria']?>">
                      </div>
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2">
                      <div class="control-group">
                        <label><b>GLUCOSA (mg/dl)</b></label>
                        <input class="form-control" name="sv_dextrostix"  value="<?=$signosVitalesNota['sv_dextrostix']?>">
                      </div>
                    </div>
                  </div>
                
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="col-xs-4 col-sm-3 col-md-2">
                      <div class="control-group">
                        <label><b>PESO (kg)</b></label>
                        <input class="form-control" name="sv_peso"  value="<?=$signosVitalesNota['sv_peso']?>">
                      </div>
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2">
                      <div class="control-group">
                        <label><b>TALLA (cm)</b></label>
                        <input class="form-control" name="sv_talla"  value="<?=$signosVitalesNota['sv_talla']?>">
                      </div>
                    </div>
                  </div>
                  </div>
                  <!-- COMIENZA LOS CAMPOS DEL FORMULARIO PARA LA NOTA MEDICA -->
                  <?php
                    $sololectura = "";
                    if($Nota['notas_tipo']=='NOTA DE INTERCONSULTA' || isset($_GET['via']) && $_GET['via'] == 'Interconsulta' || isset($_GET['via']) && $_GET['via'] == 'Valoración'){
                    $titulo = "MOTIVO DE INTERCONSULTA";
                    $visibleInterconsulta = "";
                    $MotivoInterconsulta = $this->config_mdl->_query("SELECT motivo_interconsulta FROM doc_430200 WHERE triage_id = ". $_GET['folio']." AND doc_servicio_solicitado = (SELECT empleado_servicio
                    FROM os_empleados WHERE empleado_id = $this->UMAE_USER)");
                    // En caso que se realice nota interconsulta el problema sera el diagnostico de ingreso y el motivo de interconsulta
                    $problema ="".$Diagnosticos[0]['cie10_nombre']."\n".    "Motivo interconsulta: ".$MotivoInterconsulta[0]['motivo_interconsulta'];
                    $sololectura = "readonly";
                  }else{
                    $titulo = "DIAGNÓSTICO Y SINTOMAS";
                    $problema = $Nota['nota_problema'];
                }?>
                  <div class="col-md-12">
                    <h4><span class = "label back-imss border-back-imss">EVOLUCIÓN Y/O ACTUALIZACIÓN DEL CUADRO CLÍNICO</span></h4>
                    <div class="form-group evolucion-psoap">
                        <label><b><?=$titulo?></b></label>
                        <textarea class="form-control" name="nota_problema" rows="3" placeholder="Problema o Diagnósticos" <?=$sololectura ?> ><?=$problema?></textarea>
                    </div>
                    <div class="form-group">
                      <label><b id="psoap_subjetivo" >INTERROGATORIO <span style="font-size: 9px">(Subjetivo)</span></b></label>
                      <textarea class="form-control editor" name="nota_interrogatorio" rows="5" id="area_editor1" placeholder="Interrogatorio directo o indirecto" > <?=$Nota['nota_interrogatorio']?> </textarea>
                    </div>
                    <div class="form-group">
                      <label><b id="psoap_objetivo" >EXPLORACIÓN FÍSICA <span style="font-size: 9px">(Objetivo)</span></b></label>
                      <textarea class="form-control editor" name="nota_exploracionf" rows="5" id="area_editor2" placeholder=""><?=$Nota['nota_exploracionf']?></textarea>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label><b>ESCALA DE GLASGOW</b></label>
                    <div class="input-group">
                      <input  name="hf_escala_glasgow" class="form-control" data-toggle="modal" data-target='#myModal1' placeholder="Clic para colocar valor"  value="<?=$Nota['nota_escala_glasgow']?>" autocomplete="off" required>
                      <span class="input-group-addon">Puntos</span>
                    </div>
                  </div>

                  <!-- Modal Escala de glasgow -->

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
                                       <input type="radio" class='sum_glasgow' name="apertura_ocular" value="4" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Espontánea</label>&nbsp;&nbsp;
                                       <label class="md-check">
                                       <input type="radio" class='sum_glasgow' name="apertura_ocular" value="3" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Hablar</label>&nbsp;&nbsp;
                                       <label class="md-check">
                                       <input type="radio" class='sum_glasgow' name="apertura_ocular" value="2" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Dolor</label>&nbsp;&nbsp;
                                       <label class="md-check">
                                       <input type="radio" class='sum_glasgow' name="apertura_ocular" value="1" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausente</label>
                                   </div>
                            </fieldset>
                            <fieldset class="scheduler-border">
                               <legend class="scheduler-border label_glasgow_motora"><b>RESPUESTA MOTORA</b></legend>
                                   <div class="form-group">
                                       <label class="md-check">
                                           <input type="radio" class='sum_glasgow' name="respuesta_motora" value="6" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 6 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Obedece</label>&nbsp;&nbsp;
                                           <label class="md-check">
                                           <input type="radio" class='sum_glasgow' name="respuesta_motora" value="5" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 5 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Localiza</label>&nbsp;&nbsp;
                                           <label class="md-check">
                                           <input type="radio" class='sum_glasgow' name="respuesta_motora" value="4" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Retira</label>
                                           <label class="md-check">
                                           <input type="radio" class='sum_glasgow' name="respuesta_motora" value="3" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Flexión normal</label>&nbsp;&nbsp;
                                           <label class="md-check">
                                           <input type="radio" class='sum_glasgow' name="respuesta_motora" value="2" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Extensión anormal</label>&nbsp;&nbsp;
                                           <label class="md-check">
                                           <input type="radio" class='sum_glasgow' name="respuesta_motora" value="1" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausencia de repuesta</label>
                                   </div>
                            </fieldset>
                            <fieldset class="scheduler-border">
                               <legend class="scheduler-border label_glasgow_verbal"><b>RESPUESTA VERBAL</b></legend>
                                   <div class="form-group">
                                       <label class="md-check">
                                       <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="5" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 5 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Orientado&nbsp;&nbsp;</label>
                                       <label class="md-check">
                                       <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="4" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Confuso&nbsp;&nbsp;</label>
                                       <label class="md-check">
                                       <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="3" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Incoherente&nbsp;&nbsp;</label>
                                       <label class="md-check">
                                       <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="2" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Sonidos Incomprensibles&nbsp;&nbsp;</label>
                                       <label class="md-check">
                                       <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="1" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausencia de respuesta</label>
                                   </div>

                                       <div class="form-group">PUNTUACIÓN TOTAL: &nbsp;<input type="text" name="hf_escala_glasgow" size="3" value="<?=$hojafrontal[0]['hf_escala_glasgow']?>" disable></div>
                            </fieldset>
                         </div> <!-- div del cuerpo del modal -->
                         <div class="modal-footer">
                           <button type="button" class="btn btn-primary btn_modal_glasgow" data-dismiss="">Aceptar</button>
                         </div>
                      </div>
                    </div>
                  </div>      
                <div class="col-md-3">
                  <label><b>RIESGO DE CAÍDA</b></label>
                  <div class="form-group">
                     
                     <label class="md-check">
                     <input type="radio" name="hf_riesgo_caida" data-value="<?=$Nota['hf_riesgo_caida']?>" value="Alta" class="has-value" required><i class="red"></i>Alta
                     </label>&nbsp;&nbsp;&nbsp;
                     <label class="md-check">
                     <input type="radio" name="hf_riesgo_caida" data-value="<?=$Nota['hf_riesgo_caida']?>" value="Media" class="has-value"><i class="red"></i>Media
                     </label>&nbsp;&nbsp;
                     <label class="md-check">
                      <input type="radio" name="hf_riesgo_caida" data-value="<?=$Nota['hf_riesgo_caida']?>" value="Baja" class="has-value"><i class="red"></i>Baja
                     </label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label><b>ESCALA DE DOLOR (EVA)</b></label><br>
                    <div class="row">
                      <div class="col-sm-6">
                           <?php if($Nota['nota_eva'] == ''){
                            $nota_eva = 0;
                            }else{
                              $nota_eva = $Nota['nota_eva'];
                            }?>
                          <input type="range" name="nota_eva" value="<?=$nota_eva?>" min="0" max="10" value="0">
                      </div>
                      <div class="col-sm-6" style="width:10px;height:30px;border:1px solid blue;">
                         <output name="x" for="nota_eva"><?=$nota_eva?></output>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <label><b>RIESGO DE TROMBOSIS</b></label>
                    <div class="input-group">
                        <input type="text" class="form-control" autocomplete="off" data-toggle="modal" data-target='#myModal2' placeholder="Clic para colocar valor" name="nota_riesgotrombosis" id="puntos_rt" value='<?=$Nota['nota_riesgotrombosis']?>' required>
                    </div>
                </div>
                    <!-- Modal Riesgo de Trombosis -->
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
                                          <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="1">Entre 40-60 años. <b>(1 pto).</b></label></div>
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
                <div class="col-md-12">
                  <div class="form-group">
                    <h4><span class = "label back-imss border-back-imss">RESULTADOS DE SERVICIOS AUXILIARES DE DIAGNÓSTICO</span></h4>
                    <label><b><span style="font-size: 9px">(ESTUDIOS DE LABORATORIO Y ESTUDIOS DE GABINETE)</span></b></label>
                    <textarea class="form-control editor" name="nota_auxiliaresd" rows="5" id="area_editor3" placeholder="Si no cuenta con Resultados dejar en blanco"><?=$Nota['nota_auxiliaresd']?></textarea>
                  </div>
                
                    <?php
                        // Declara el estado original checkbox de procedimientos
                        // Al editar, modifica el estado del checkbox
                          if(empty($Nota['nota_procedimientos'])){
                            $checkEstado = "";
                            $estadoDiv = "style='display:none'";
                            $valor_check = "0";
                          }else {
                            $checkEstado = "checked";
                            $estadoDiv = "";
                            $valor_check = "1";
                          }
                    ?>
                  <div class="form-group">
                    <h4><label class="md-check"><input type="checkbox" name="check_procedimientos" <?=$checkEstado ?> value="<?= $valor_check ?>"><i class="indigo"></i></label>
                        <label class = "label back-imss border-back-imss">PROCEDIMIENTOS</label>  
                    </h4>
                    <div class="input-group m-b div_procedimientos" <?= $estadoDiv ?> >
                      <span class="input-group-addon back-imss border-back-imss"><i class="fa fa-user-plus"></i></span>
                        <select class="select2" multiple="" name="procedimientos[]" id="procedimientos" data-value="<?=$Nota['nota_procedimientos']?>" style="width: 100%" >
                          <?php foreach ($Procedimientos as $value) {?>
                             <option value="<?=$value['procedimiento_id']?>"><?=$value['nombre']?></option>
                          <?php }?>
                        </select>
                    </div>
                  </div>
                  <div class="form-group evolucion-psoap">
                    <h4><span class="label back-imss border-back-imss"><b> ANÁLISIS DEL CASO (Comentario y Conclusiones):</b></span></h4>
                    <textarea class="form-control editor" name="nota_analisis" id="area_editor5" placeholder="Anote sus comentarios y conclusiones del caso"><?=$Nota['nota_analisis']?></textarea>
                  </div>
                </div>
                <div class="col-md-12">   
                  <div class="form-group">
                    <h4><span class = "label back-imss border-back-imss">ACTUALIZACIÓN DE DIAGNÓSTICO(S)</span></h4>
                    <label style="margin-top: 10px;padding-bottom: 10px"><b>Diagnóstico(s) Encontrado(s)</b></label>   
                    <div class="row row-diagnostico-principal"> </div>
                    <div class="col-md-3" style="left:-12px;top:-8px">
                      <button type="button" class="fa fa-plus btn btn-success btn_add-dx"  data-original="Agregar o cambiar Diagnóstico" value="add"> Agregar Dx</button>
                    </div>
                    <div class="col-md-12 input-group m-b hidden" id="add_dxsecundario" style="margin-top: 10px">
                      <span class="input-group-addon"><i class="fa fa-stethoscope" style="font-size: 16px"></i></span>
                      <input type="text" class="form-control" name="cie10_nombre" placeholder="Tecleé el diagnóstico a buscar y seleccione (minimo 5 caracteres)" >
                      <span class="input-group-addon back-imss border-back-imss add-cie10"><i class="fas fa fa-search pointer"></i></span>
                    </div>
                  </div>        
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <h4><span class = "label back-imss border-back-imss">ESTADO DE SALUD</span></h4>
                      <label class="md-check">
                          <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Delicado"><i class="red"></i>Delicado
                      </label>&nbsp;&nbsp;&nbsp;
                      <label class="md-check">
                          <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Muy Delicado"><i class="red"></i>Muy Delicado
                      </label>&nbsp;&nbsp;&nbsp;
                      <label class="md-check">
                          <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Grave"><i class="red"></i>Grave
                      </label>&nbsp;&nbsp;&nbsp;
                      <label class="md-check">
                          <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Muy Grave"><i class="red"></i>Muy Grave
                      </label>&nbsp;&nbsp;&nbsp;
                  </div>
                </div>
                <!-- PRONOSTICO -->
                <div class="col-md-12">
                  <div class="form-group">
                    <h4><span class = "label back-imss border-back-imss">PRONÓSTICO</span></h4>
                    <!-- <label class="md-check">
                          <input type="radio" name="nota_pronosticos" data-value="<?=$Nota['nota_pronosticos']?>" class="has-value" value="Bueno"><i class="red"></i>Bueno
                      </label>&nbsp;&nbsp;&nbsp;
                      <label class="md-check">
                          <input type="radio" name="nota_pronosticos" data-value="<?=$Nota['nota_pronosticos']?>" class="has-value" value="Malo"><i class="red"></i>Malo
                      </label>&nbsp;&nbsp;&nbsp;
                      <label class="md-check">
                          <input type="radio" name="nota_pronosticos" data-value="<?=$Nota['nota_pronosticos']?>" class="has-value" value="Malo a corto plazo"><i class="red"></i>Malo a corto plazo
                      </label>&nbsp;&nbsp;&nbsp    -->                   
                    <textarea class="form-control" name="nota_pronosticos" rows="2" placeholder="Anote diagnóstico y problemas clinicos"><?=$Nota['nota_pronosticos']?></textarea>
                  </div>
                </div>
                <!-- PLAN Y ORDENES MEDICAS -->
                <div class="row">
                  <div class="col-sm-2 col-md-2">
                    <h4>
                      <span class = "label back-imss border-back-imss">PLAN Y ORDENES MÉDICAS</span>
                    </h4>
                  </div>
                  <div class="col-sm-4 col-md-4" style="margin-left:40px;">
                    <div class="form-group radio">
                      <label class="md-check">
                        <input type="radio" class="has-value" value="0" id='play_ordenes_nuevo' name="play_ordenes" checked ><i class="red"></i>Nuevo&nbsp;&nbsp;
                      </label>
                      <label class="md-check">
                        <input type="radio" class="has-value" value="1" id='play_ordenes_continuar' name="play_ordenes"><i class="red"></i>Continuar con la anterior
                      </label>
                    </div>
                  </div>
                  <label class="lbl_mensaje"></label>
                </div>

                  <!-- Inicio seccion play y ordenes médicas -->
                <div class="seccion-plan-ordenes">
                  <div class="col-sm-12" id="divNutricion" style="padding:0">
                    <div class="col-sm-3" style="padding:0" id="divRadioNutricion">
                      <label><b>a) Instrucciones de Nutrición:</b></label>
                      <?php
                      // Declara estado original del radio cuando se realiza nueva nota
                      $checkAyuno = '';
                      $checkDieta = '';
                      $divSelectDietas = 'hidden';
                      $select_dietas = '0';
                      $otraDieta = '';
                      $divOtraDieta = 'hidden';
                      if($_GET['a'] == 'edit'){
                        if($Nota['nota_nutricion'] == '0'){
                          $checkAyuno = 'checked';
                        }else if($Nota['nota_nutricion'] == '1' || $Nota['nota_nutricion'] == '2'
                        || $Nota['nota_nutricion'] == '3'|| $Nota['nota_nutricion'] == '4'|| $Nota['nota_nutricion'] == '5'
                        || $Nota['nota_nutricion'] == '6'|| $Nota['nota_nutricion'] == '7'|| $Nota['nota_nutricion'] == '8'
                        || $Nota['nota_nutricion'] == '9'|| $Nota['nota_nutricion'] == '10'|| $Nota['nota_nutricion'] == '11'
                        || $Nota['nota_nutricion'] == '12'){
                          $checkDieta = 'checked';
                          $divSelectDietas = '';
                          $select_dietas = $Nota['nota_nutricion'];
                        }else{
                          $divSelectDietas = '';
                          $checkDieta = 'checked';
                          $divOtraDieta = '';
                          $select_dietas = '13';
                          $otraDieta = $Nota['nota_nutricion'];
                        }
                      }
                      ?>
                      <div class="form-group radio">
                        <label class="md-check">
                          <input type="radio" class="has-value" value="0" id='radioAyuno' name="dieta" <?= $checkAyuno ?> ><i class="red"></i>Ayuno
                        </label>
                        <label class="md-check">
                          <input type="radio" class="has-value" value="" id='radioDieta' name="dieta" <?= $checkDieta ?> ><i class="red"></i>Dieta
                        </label>
                      </div>
                    </div>
                    <div  id="divSelectDietas" class="col-sm-3"  <?= $divSelectDietas ?>>
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
                    <div  id='divOtraDieta' class="col-sm-6" style="padding:0" <?= $divOtraDieta ?> >
                      <div class="form-group">
                        <label>Otra dieta:</label>
                        <input type="text" class="form-control" name="otraDieta" value="<?= $otraDieta ?>" id="inputOtraDieta" placeholder="Otra dieta">
                      </div>
                    </div>
                  </div>
                  <?php
                    // Declara estado original del select cuando se realiza nueva nota
                    $select_signos = 0;
                    $otras_indicaciones = 'hidden';
                    // El estado de las variables cambia al realizar un cambio, esto para determinar si el valor corresponde al select o textarea
                    if($_GET['a'] == 'edit'){
                      if($Nota['nota_svycuidados'] == '0' || $Nota['nota_svycuidados'] == '1' || $Nota['nota_svycuidados'] == '2' ){
                        $select_signos = $Nota['nota_svycuidados'];
                      }else{
                        $select_signos = "3";
                        $otras_indicaciones = '';
                      }
                    }
                  ?>
                  <div class="col-sm-12" id="divSignos" style="padding:0">
                    <div class="col-sm-4 form-group" style="padding:0" id="divTomaSignos">
                      <label><b>b) Toma de signos vitales: </b></label>
                      <select  id="selectTomaSignos" class="form-control" data-value="<?= $select_signos ?>" name="tomaSignos">
                        <option value="0" unselected>Seleccionar</option>
                        <option value="1">Por turno</option>
                        <option value="2">Cada 4 horas</option>
                        <option value="3">Otros</option>
                      </select>
                    </div>
                    <div id="divOtrasInidcacionesSignos"  <?= $otras_indicaciones ?>>
                      <div class="col-sm-8 form-group" style="padding-right: 0">
                      <label>Otras inidcaciones:</label>
                      <input type="text" id="otras-indicaciones-signos" name="otrasIndicacionesSignos" class="form-control" placeholder="Otras indicaciones" value="<?=$Nota['nota_svycuidados']?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12" style="padding:0">
                    <div class="col-sm-12" style="padding:0" id="divCuidadosGenerales">
                      <div class="form-group ">
                        <label><b>c) Cuidados Generales de Enfermería:</b>
                            <?php
                            // Declara el estado original checkbox de cuidados generales de enfermeria
                            $labelCheck = 'SI';
                            $hiddenCheck = 'hidden';
                            // Al editar, modifica el estado del checkbox
                            if($Nota['nota_cgenfermeria'] == 1){
                              $check_generales = 'checked';
                              $labelCheck = '';
                              $hiddenCheck = '';
                            }
                            ?>
                          <input type="checkbox" id="checkCuidadosGenerales" name="nota_cgenfermeria" value="1" <?= $check_generales ?> > -
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
                  </div>
                  <div class="col-sm-12"  style="padding:0">
                    <div class="col-sm-12" style="padding:0">
                      <div class="form-group">
                        <label><b>d) Cuidados Especiales de Enfermería</b></label>
                        <textarea class="form-control nota_cuidadosenfermeria editor" name="nota_cuidadosenfermeria" rows="5" id="area_editor6" placeholder="Cuidados especiales de enfermeria"><?=$Nota['nota_cuidadosenfermeria']?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12" id="divCuidadosGenerales" style="padding:0">
                    <div class="col-sm-12" style="padding:0">
                      <div class="form-group">
                        <label><b>e) Soluciones parenterales</b></label>
                        <textarea class="form-control nota_solucionesp editor" name="nota_solucionesp" rows="5" id="area_editor7" placeholder="Soluciones Parenterales"><?=$Nota['nota_solucionesp']?></textarea>
                      </div>
                    </div>
                  </div>
                </div><!-- Fin seccion play y ordenes médicas -->
                <div>
                  <label><b>f) Prescripción: </b> &nbsp;</label>
                      <label class="md-check">
                        <input type="checkbox" id="check_form_prescripcion"><i class="indigo"></i><label id="label_check_prescripcion">- SI</label>
                      </label>
                      <!-- Panel con el historial de prescripciones -->
                      <nav class=" back-imss">
                          <ul class="nav navbar-nav" >
                            <li>
                              <a class="collapse show" id="acordeon_prescripciones_activas">
                                  Prescripciones activas:
                                  <label id="label_total_activas"><?= $Prescripciones_activas[0]['activas'] ?></label>
                              </a>
                            </li>
                            <!--
                            <li>
                              <a id="acordeon_prescripciones_pendientes">
                                  Pendientes por conciliacion:
                                  <label id="label_total_pendientes"><?= $Prescripciones_pendientes[0]['pendientes'] ?></label>
                              </a>
                            </li>
                            -->
                            <li>
                              <a id="acordeon_prescripciones_canceladas">
                                  Canceladas o actualizadas:
                                  <label id="label_total_canceladas"><?= count($Prescripciones_canceladas) ?></label>
                              </a>
                            </li>
                            <li>
                              <a id="acordeon_reacciones">
                                  Reacciones adversas:
                                  <label id="label_total_reacciones"><?= count($ReaccionesAdversas) ?></label>
                              </a>
                            </li>
                            <li>
                              <a id="acordeon_notificaciones">
                                  Notificaciones:
                                  <label id="label_total_notificaciones"><?= count($Notificaciones) ?></label>
                              </a>
                            </li>
                            <!-- Alegia a medicamentos
                            <li>
                              <a id="acordeon_alergia_medicamentos">
                                  Alergia a medicamentos:
                                  <label id="label_total_reacciones"><?= count($AlergiaMedicamentos) ?></label>
                              </a>
                            </li>
                            -->
                            <!--
                            <li>
                              <a id="acordeon_notificaciones">
                                  Notificaciones Farmacovigilancia:
                                  <label id="label_total_notificaciones">0</label>
                              </a>
                            </li>
                             -->
                          </ul>
                          <label id="estado_panel" hidden>0</label>
                      </nav>
                      <div>
                        <table id="historial_medicamentos_activos" style="width:100%;" hidden>
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
                              <!-- <th id="col_acciones" >Acciones</th>
                              <th id="col_movimiento" >Movimiento</th>
                              <th id="col_fecha_movimiento" >Fecha Movimiento</th> -->
                            </tr>
                          </thead>
                          <tbody id="table_prescripcion_historial">
                          </tbody>
                        </table>
                      </div>
                      <div>
                        <div class="panel-group" id='historial_movimientos' hidden></div>
                      </div>
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
                      <!-- Fin panel prescripcion -->
                      <!-- Inicio formulario prescripcion -->
                      <div class="formulario_prescripcion" style="padding-top: 10px;" hidden>
                        <br>
                        <div class="row" >
                            <div class="col-md-12" style="margin-top: -15px">
                                <div class="form-group">
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss" >
                                          RECETA MÉDICA
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12" style="padding:0">
                          <div class="col-md-12 col-sm-12" style="padding: 0;">
                            <div class="form-group">
                              <label><b>Medicamento / Forma farmacéutica</b></label>
                              <div class="input-group">
                                <div classid="borderMedicamento" >
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
                        </div>

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
                          <div class="tiempo_tipo_medicamento">
                          </div>
                        </div>
                        <div class="col-sm-8" style="padding: 0;" >
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
                              <!-- <th>Cat F.</th> -->
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
                          <tbody id="tablaPrescripcion">
                          </tbody>
                        </table>
                      </div> <!-- Fin formulario prescripcion-->
                      
                      <br/>
                      <div class="col-sm-12" id="divCuidadosGenerales" style="padding:0">
                        <div class="col-sm-12" style="padding:0">
                          <div class="form-group">
                            <label><b>g) Solicitud de estudios de laboratorio y rayos x: &nbsp;  </b></label><input type="checkbox" id="check_estudios">&nbsp;<label id="label_check_estudios">- SI</label>
                            <div class="solicitud_laboratorio" hidden>
                                <textarea class="form-control" name="nota_solicitud_laboratorio" rows="4" placeholder="Indicar los estudios a realizar"><?=$Nota['nota_solicitud_laboratorio']?></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                       <?php
                        // Declara el estado original checkbox de interconsultas
                        // Al editar, modifica el estado del checkbox
                          if(empty($Nota['nota_interconsulta'])){
                            $checkEstado = "";
                            $estadoDiv = "style='display:none";
                            $valor_check = "0";
                          }else {
                            $checkEstado = "checked";
                            $estadoDiv = "";
                            $valor_check = "1";
                          }
                        ?>
                      <div class="form-group">
                        <h4>
                          <label class="md-check"><input type="checkbox" name="check_solicitud_interconsulta" value="<?=$valor_check?>" <?=$checkEstado?>><i class="  indigo"></i></label>
                          <label class = "label back-imss border-back-imss">SOLICITUD DE INTERCONSULTAS</label>
                        </h4>
                        <div class="col-md-12 nota_interconsulta" <?=$estadoDiv?> >
                          <div class="input-group m-b">   
                            <span class="input-group-addon back-imss border-back-imss"><i class="fa fa-user-plus"></i></span>
                              <select class="select2" multiple="" name="nota_interconsulta[]" id="nota_interconsulta" data-value="<?=$Nota['nota_interconsulta']?>" style="width: 100%">
                                <?php foreach ($Especialidades as $value) {?>
                                <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                                <?php } ?>
                              </select>
                          </div>
                          <div class="form-group nota_interconsulta">
                            <label for=""><b>MOTIVO POR EL CÚAL SOLICITA LA INTERCONSULTA</b></label>
                            <textarea class="form-control" name="motivo_interconsulta" rows="2"><?=$Interconsultas[0]['motivo_interconsulta'] ?></textarea>
                          </div>
                        </div>
          
                        <div class="col-md-5">
                          <a data-toggle="collapse" data-target="#listaInterconsultas">
                            <span class="glyphicon glyphicon-collapse-down"></span> Estado de interconsultas solicitadas:
                          </a>            
                          <div class="collapse" id="listaInterconsultas">
                              <table style="margin-bottom: 15px ">
                                  <thead>
                                    <tr>
                                      <th>Servicio</th>
                                      <th>Estado</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                  foreach($Interconsultas as $value) {
                                    if ($value['doc_estatus'] == 'Evaluado'){
                                      $etiquetaColor='green';
                                    }else $etiquetaColor='amber';?>
                                    <tr>
                                      <td style="padding: 3px"><?=$value['especialidad_nombre']?></td>
                                      <td><span class="label <?=$etiquetaColor?>"><?=$value['doc_estatus']?></span></td>
                                    </tr>             
                                  <?php }?>
                                  </tbody>
                              </table>
                          </div>
                        </div>    
                      </div>

                  <div class="col-sm-12">        
                    <label class="mayus-bold">MÉDICO QUIÉN REALIZA LA NOTA</label>      
                  </div>
                  <?php 
                    foreach ($Usuario as $value) {
                      $medicoRol = $value['empleado_roles'];
                    } 
                      if($medicoRol == 2) {?>
                        <div class="col-md-12 <?= $mostrarMedicoTratante ?>">
                          <div class="form-group">
                              <div class="row">
                                  <div class="col-md-5">
                                      <label><b>NOMBRE</b></label>
                                      <input type="text" name="medicoTratante" value="<?=$value['empleado_nombre'].' '.$value['empleado_apellidos']?>" readonly="" class="form-control">
                                  </div>
                                  <div class="col-md-3">
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
                          <label>Nombre de supervisor Médico de Base :</label>
                            <select class="select2 width100" name="medicoBase" id="medicoBase" data-value="<?=$Nota['notas_medicotratante']?>" required>
                              <option value="" disabled selected>Seleccione</option>
                              <?php foreach ($MedicosBase as $value) { ?>
                              <option value="<?=$value['empleado_matricula'] ?>"><?=$value['empleado_nombre'] ?> <?=$value['empleado_apellidos'] ?></option>
                              <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-3 col-md-3">
                          <label style="color: white;">C </label>           
                            <input class="form-control" id="medicoMatricula" type="text" name="medicoMatricula" placeholder="Matrícula Medico" value="<?=$MedicosBaseNota[0]['empleado_matricula']?>"  readonly>  
                        </div>
                      </div>
                    </div>
                    <?php if($_GET['a']=='add') {
                          $colorLabel = 'white'; ?>
                      <div class="col-sm-12 col-md-12 disabled">        
                        <div class="form-group">
                          <div class="col-sm-4 col-md-4"> 
                            <label>Nombre(s) de médico(s) residente(s):</label>  
                            <input type="text" class="form-control" id="" name="nombre_residente[]" placeholder="Nombre(s)" value="" required>
                          </div>
                          <div class="col-sm-4">
                            <label>Apellido paterno y materno </label>
                               <input type="text" class="form-control" id="medico<?=$i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?=$Residentes[$i]['apellido_residente']?>" required>
                             </div>                             
                          <div class="col-sm-3 col-md-3">
                            <label>Cédula Profesional</label>
                            <input class="form-control" id="medicoMatricula" type="text" name="cedula_residente[]" placeholder="Cédula Profesional" value="" required>
                          </div>
                          <div class="col-sm-1 col-md-1">
                            <label>Agregar +</label>
                            <a href='#' class="btn btn-success btn-xs " style="width:100%;height:100%;padding:7px;" id="add_otro_residente" data-original-title="Agregar Médico Residente"><span class="glyphicon glyphicon-plus "></span></a>
                          </div>
                        </div>
                      </div>
                    <?php }else { $colorLabel='black';}?>
                 
                      <div id="medicoResidente">
                      <!-- <label style="color: white;">Nommbre de Medicos residentes</label> -->
                      <div class="col-sm-12 col-md-12" style="color: <?= $colorLabel?>" >        
                        <div class="form-group">
                          <div class="col-sm-4 col-md-4"><label>Nombre(s) de médico(s) residente(s):</label></div>
                          <div class="col-sm-4"><label>Apellido paterno y materno </label></div>                             
                          <div class="col-sm-3 col-md-3"><label>Cédula Profesional</label></div>  
                        </div>
                      </div>
                      <?php for($i = 0; $i < count($Residentes); $i++){?>
                         <div class="col-sm-12 form-group">
                           <div class="col-sm-4 col-md-4">
                            <!-- <label style="color: white;">Nombres</label> -->
                             <input type="text" class="form-control" id="medico<?=$i ?>" name="nombre_residente[]" placeholder="Nombre(s)" value="<?=$Residentes[$i]['nombre_residente']?>"  >
                           </div>
                           <div class="col-sm-4 col-md-4">
                            <!-- <label style="color: white;">Apellidos</label> -->
                             <input type="text" class="form-control" id="medico<?=$i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?=$Residentes[$i]['apellido_residente']?>"  >
                           </div>
                           <div class="col-sm-3 col-md-3">
                            <!-- <label style="color: white;">Cedula</label> -->
                             <input type="text" class="form-control" id="medico<?=$i ?>" name="cedula_residente[]" placeholder="Cédula Profesional" value="<?=$Residentes[$i]['cedulap_residente']?>"  >
                           </div>
                         </div>
                       <?php }?>
                      </div>
                   <?php }?>
                
                    <div class="col-md-offset-8 col-md-2">
                      <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
                    </div>
                    <div class="col-md-2">
                        <input name="csrf_token" type="hidden">
                        <input name="triage_id" value="<?=$_GET['folio']?>" type="hidden">
                        <input name="accion" value="<?=$_GET['a']?>" type="hidden">
                        <input name="notas_id" value="<?=$this->uri->segment(4)?>" type="hidden">
                        <input name="via" value="<?=$_GET['via']?>" type="hidden">
                        <input name="inputVia" value="<?=$_GET['inputVia']?>" type="hidden">
                        <input name="doc_id" value="<?=$_GET['doc_id']?>" type="hidden">
                        <input name="umae_area" value="<?=$this->UMAE_AREA?>" type="hidden">
                        <input name="tipo_nota" value="<?=$_GET['TipoNota']?>" type="hidden">
                        <input name="hf_escala_glasgow" value="<?=$Nota['nota_escala_glasgow']?>" type="hidden">
                        <button class="btn back-imss pull-right btn-block" type="submit" style="margin-bottom: -10px">Guardar</button>
                    </div>
                </form>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js" type="text/javascript" ></script>
<script src="<?= base_url('assets/js/sections/CIE10.js?md5='). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Documentos.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Diagnosticos.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/build/jodit.min.js')?>"></script>

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
                      efaultMode: Jodit.MODE_WYSIWYG,
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
                                  'hr',
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

<script>
$(document).ready(function() {
    $('.Form-Notas-COC').submit(function (e) {
        e.preventDefault();
        SendAjax($(this).serialize(),'Sections/Documentos/AjaxNotas',function (response) {
            if(response.accion=='1'){
                window.opener.location.reload();
                window.top.close();
                AbrirDocumentoMultiple(base_url+'Inicio/Documentos/GenerarNotas/'+response.notas_id+'?inputVia='+$('input[name=inputVia]').val(),'NOTAS');
            }
        },'','No');
    });
});
</script>