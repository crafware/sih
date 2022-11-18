<?= modules::run('Sections/Menu/index'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/libs/light-bootstrap/all.min.css" />
<link rel="stylesheet" href="<?= base_url()?>assets/libs/jodit-3.2.43/build/jodit.min.css" />
<link rel="stylesheet" href="<?= base_url()?>assets/styles/notas.css"/>
<div class="box-row">
  <div class="box-cell">
    <div class="col-md-11 col-centered" style="margin-top: 10px ">
      <div class="box-inner">
        <?php if($SignosVitales['sv_ta']==''){?>
        <div class="row " style="margin-top: -10px;padding: 16px;">
          <div class="col-md-12 col-centered back-imss" style="padding:10px;margin-bottom: -7px;">
            <h6 style="text-align: center"><b>EN ESPERA DE CAPTURA DE SIGNOS VITALES</b></h6>
          </div>
        </div>
        <?php }else{?>
        <div class="row " style="margin-top: -30px;padding: 16px; margin-left:-45px; margin-right:-45px;">
          <div class="col-md-12 col-centered " style="padding: 0px;margin-bottom: -7px;">
            <h6 style="font-size: 10px;font-weight: 500;text-align: right">FECHA Y HORA DE REGISTRO:
              <b><span style="font-size: 10px"><?=$info['triage_horacero_f']?> <?=$info['triage_horacero_h']?></span></b>
            </h6>
          </div>
          <div class="panel-heading p teal-900 back-imss" style="padding-bottom: 6px;">
            <span style="font-size: 18px;font-weight: 500;text-transform: uppercase">
              <div class="row" style="margin-top: -20px;">
                  <div style="position: relative">
                      <div style="top: 17px;margin-left: -9px;position: absolute;height: 77px;width: 35px;" class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$info['triage_color']))?>"></div>
                  </div>
                  <div class="col-md-10" style="padding-left: 40px">
                    <br>
                      <h4>
                        <b>PACIENTE:</b> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
                         | <b>SEXO: </b><?=$info['triage_paciente_sexo']?> <?=$PINFO['pic_indicio_embarazo']=='Si' ? '| - Posible Embarazo' : ''?>
                         | <b>PROCEDENCIA:</b> <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEA '.$PINFO['pia_procedencia_espontanea_lugar'] : ' '.$PINFO['pia_procedencia_hospital'].' '.$PINFO['pia_procedencia_hospital_num']?>
                         | <b>NSS:</b> <?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?>
                      </h4>
                      <h5 style="margin-top: -5px;text-transform: uppercase">
                          <?php
                              if($info['triage_fecha_nac']!=''){
                                  $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                  if($fecha->y<15){
                                      echo 'PEDIATRICO';
                                  }if($fecha->y>15 && $fecha->y<60){
                                      echo 'ADULTO';
                                  }if($fecha->y>60){
                                      echo 'GERIATRICO';
                                  }
                              }else{
                                  echo 'S/E';
                              }
                          ?> | <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEA: '.$PINFO['pia_procedencia_espontanea_lugar'] : ': '.$PINFO['pia_procedencia_hospital'].' '.$PINFO['pia_procedencia_hospital_num']?> | <?=$info['triage_color']?>

                      </h5>
                  </div>
                  <div class="col-md-2 text-right">
                    <br>
                      <h5>
                          <b>EDAD</b>
                      </h5>
                      <h3 style="margin-top: -10px">
                          <?php
                          if($info['triage_fecha_nac']!=''){
                              $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                              echo $fecha->y.' <span style="font-size:20px"><b>Años</b></span>';
                          }else{
                              echo 'S/E';
                          }
                          ?>
                          <?php
                                $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info['triage_codigo_atencion']);
                                echo ($codigo_atencion != '')?"<br><span style='font-size:15px'><b>Código $codigo_atencion</b></span>":"";
                            ?>
                      </h3>
                  </div>
              </div>
            </span>
          </div>
        </div>
        <?php }?>
        <div class="panel panel-default" style="margin-top: -16px; margin-left:-30px; margin-right:-30px;">
          <div class="col-md-2 text-center back-imss" style="padding-left: 0px;padding: 5px;">
              <h5 class=""><b>PANI</b></h5>
              <h5 style="margin-top: -8px"> <?=$SignosVitales['sv_ta']?> mmHg</h5>
          </div>
          <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
              <h5><b>TEMP.</b></h5>
              <h5 style="margin-top: -8px"> <?=$SignosVitales['sv_temp']?> °C</h5>
          </div>
          <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
              <h5><b>FREC. CARD. </b></h5>
              <h5 style="margin-top: -8px"> <?=$SignosVitales['sv_fc']?> (lpm)</h5>
          </div>
          <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
              <h5><b>FREC. RESP</b></h5>
              <h5 style="margin-top: -8px"> <?=$SignosVitales['sv_fr']?> (rpm)</h5>
          </div>
          <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
              <h5><b>SpO2</b></h5>
              <h5 style="margin-top: -8px"> <?=$SignosVitales['sv_oximetria']?> (%)</h5>
          </div>
          <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
              <h5><b>GLUCEMIA</b></h5>
              <h5 style="margin-top: -8px"> <?=$SignosVitales['sv_dextrostix']?> (mg/dL)</h5>
          </div>
        </div> 
        <form class="guardar-solicitud-hi-abierto" style="margin-top: 85px" oninput="x.value=parseInt(hf_eva.value)">
          <!-- Motivo de consulta -->
          <div class="panel panel-default panel-x" style="margin-top: -16px; margin-left:-30px; margin-right:-30px;">
            <div class="panel-heading"><h4>Motivo de Consulta</h4></div>
            <div class="panel-body" style="padding: 20px 0px;">
              <div class="row">
                <div class="col-md-12 hide">
                  <div class="input-group m-b">
                    <span class="input-group-addon">FORMATO DE HOJA FRONTAL</span>
                    <select class="form-control" name="hf_documento">
                      <option value="HOJA FRONTAL 4 30 128" selected="">HOJA FRONTAL 4 30 128</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">           
                <div class="form-group">
                  <textarea class="form-control hf_motivo editor" id="area_editor1" name="hf_motivo" placeholder="Escriba aquí el Motivo de la consulta"><?=$hojafrontal[0]['hf_motivo']?></textarea>
                </div>
              </div>
            </div>
          </div>
      
          <!-- Antecedentes -->
          <div class="panel panel-default panel-x">
            <div class="panel-heading"><h4>Antecedentes</h4></div>
            <div class="panel-body ">
              <div class="form-group">
                  <textarea class="form-control editor" id="area_editor2" rows="6" name="hf_antecedentes" placeholder="Escriba aquí los antecedentes"><?=$hojafrontal[0]['hf_antecedentes']?></textarea>
              </div>
            </div>
          </div>
          <!-- Alergias -->
          <div class="panel panel-default panel-x">
            <div class="panel-heading"><h4>Alergias</h4></div>
            <div class="panel-body ">
              <div class="form-group">
                <?php
                $select_alergias = "0";
                $textarea_alergias = "";
                $estilo_alergias = "style='display:none'";
                if($PINFO['alergias'] != ''){
                  if($PINFO['alergias'] == 'Negadas'){
                    $select_alergias = "2";
                  }else{
                    $select_alergias = "1";
                    $textarea_alergias = $PINFO['alergias'];
                    $estilo_alergias = "";
                  }
                }?>
             
               <div class="col-sm-3 col-md-4" style="padding-bottom:12px;">
                 <label><b>¿Alergias a medicamentos u otro?</b></label>
                 <select class="form-control opcion_alergias"  name="select_alergias" data-value="<?= $select_alergias ?>" style="width: 110px" required>
                   <option value="" disabled>Indicar opcion</option>
                   <option value="1">Si</option>
                   <option value="2">Negadas</option>
                 </select>
               </div>
                <textarea class="form-control alergias" rows="1" name="alergias" placeholder="Escriba aquí las alergias"<?= $estilo_alergias ?> ><?= $textarea_alergias ?></textarea>
              </div>
            </div>
          </div>
          <!-- Padecimiento actual -->
          <div class="panel panel-default panel-x">
            <div class="panel-heading"><h4>Padecimiento Actual</h4></div>
            <div class="panel-body ">
              <div class="form-group">
                <textarea class="form-control editor" id="area_editor3" rows="5" name="hf_padecimientoa" placeholder="Escriba aquí el/los pacedimiento actual"><?=$hojafrontal[0]['hf_padecimientoa']?></textarea>
              </div>
            </div>
          </div>
          <!-- Exploracion Fisica -->
          <div class="panel panel-default panel-x">
            <div class="panel-heading"><h4>Exploración Fisica</h4></div>
            <div class="panel-body ">
              <div class="form-group">
                <textarea class="form-control editor" id="area_editor4" rows="8" name="hf_exploracionfisica"><?=$hojafrontal[0]['hf_exploracionfisica']?></textarea>
              </div>
            </div>
          </div>
          <!-- Escalas de Valoracion -->
          <div class="panel panel-default panel-x">
            <div class="panel-heading"><h4>Escalas de Valoración</h4></div>
            <div class="panel-body ">      
              <!-- Glasgow -->            
              <div class="col-md-4">
                <label><b>ESCALA DE GLASGOW</b></label>
                  <div class="input-group">
                    <input type="text" class="form-control" data-toggle="modal" data-target='#myModal1' placeholder="Clic para valor" name="hf_escala_glasgow" value="<?=$hojafrontal[0]['hf_escala_glasgow']?>" required autocomplete="off">
                      <!-- <span class="input-group-addon">Puntos</span> -->
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
              <!-- Riesgo caida -->        
              <div class="col-md-4">
                <label><b>RIESGO DE CAÍDA</b></label>
                <div class="form-group">
                  <label class="md-check">
                  <input required type="radio" name="hf_riesgocaida" data-value="<?=$hojafrontal[0]['hf_riesgocaida']?>" value="Alta" class="has-value"><i class="red"></i>Alta
                  </label>&nbsp;&nbsp;&nbsp;
                  <label class="md-check">
                  <input type="radio" name="hf_riesgocaida" data-value="<?=$hojafrontal[0]['hf_riesgocaida']?>" value="Media" class="has-value"><i class="red"></i>Media
                  </label>&nbsp;&nbsp;
                  <label class="md-check">
                  <input type="radio" name="hf_riesgocaida" data-value="<?=$hojafrontal[0]['hf_riesgocaida']?>" value="Baja" class="has-value"><i class="red"></i>Baja
                  </label>
                </div>
              </div>
              <!-- EVA -->                 
              <div class="col-md-4">
                <label><b>ESCALA DE DOLOR (EVA)</b></label><br>
                <div class="form-group">
                    <div class="row">
                    <div class="col-sm-6">
                      <?php
                      if($hojafrontal[0]['hf_eva'] == ''){
                        $hf_eva = 0;
                      }else{
                        $hf_eva = $hojafrontal[0]['hf_eva'];
                      }
                       ?>
                     <input type="range" name="hf_eva" value="<?= $hf_eva ?>" min="0" max="10" value="0">
                    </div>
                    <div class="col-sm-6" style="width:10px;height:30px;margin-top: -5px;border:1px solid blue;">
                        <output name="x" for="hf_eva"><?= $hf_eva ?></output>
                    </div>
                    </div>
                </div>
              </div>
              <!-- Riesgo de trombosis --> 
              <div class="col-md-4">
                <label><b>RIESGO DE TROMBOSIS</b></label>
                  <div class="input-group">
                    <input  type="text" class="form-control" data-toggle="modal" data-target='#myModal2' placeholder="Clic para colocar valor" name="hf_riesgo_trombosis" id="puntos_rt" value='<?=$hojafrontal[0]['hf_riesgo_trombosis']?>' required autocomplete="off">
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
              <!-- Funcionalidad Barthel -->
              <div class="col-md-4">
                <label><b>FUNCIONALIDAD BARTHEL</b></label>
                <div class="input-group">
                  <input  type="text" size="25" class="form-control" data-toggle="modal" data-target='#barthel' placeholder="Clic para colocar valor" name="funcionalidad_barthel" id="puntos_barthel" value='<?=$hojafrontal[0]['funcionalidad_barthel']?>' required autocomplete="off">
                </div>
              </div>
                <!-- Modal FUNCIONALIDAD BARTHEL -->
                <div class="modal fade" id="barthel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" id="modalTamanioT">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                 <h4 class="modal-title" id="myModalLabel">FUNCIONALIDAD BARTHEL</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label><b>Comer</b></label>
                                        <div class="radio">
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_comer" value="10">Totalmente independiente.  <b>(10 ptos)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_comer" value="5">Necesita ayuda para cortar alimentos o agregar condimentos. <b>(5 ptos)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_comer" value="0">Dependiente. <b>(0 ptos)</b></label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label><b>Bañarse</b></label>
                                        <div class="radio">
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_bañarse" value="5">Independiente, entra y sale solo del baño.<b>(5 pto)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_bañarse" value="0">Dependiente.<b>(0 pto)</b></label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label><b>Vestirse</b></label>
                                        <div class="radio">
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_vestir" value="10">Independiente, capaz de ponerse y quitarse la ropa, abotonarse, atarse los zapatos.<b>(10 ptos)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_vestir" value="5">Necesita ayuda. <b>(5 ptos)</b></label><br></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_vestir" value="0">Dependiente. <b>(0 ptos)</b></label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label><b>Arreglarse </b></label>
                                        <div class="radio">
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_arreglar" value="5">Independiente para lavarse las cara, las manos, peinarse, afeitarse, maquillarse, etc.<b>(5 pto)</b></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_arreglar" value="0">Dependiente. <b>(0 ptos)</b></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label><b>Deposiciones</b></label>
                                        <div class="radio">
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_desposi" value="10">Continente con adecuado tránsito intestinal.<b>(10 ptos)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_desposi" value="5">Ocasionalmente, algún episodio de incontinencia o necesita ayuda para administrarse supositorios o lavativas. <b>(5 ptos)</b></label><br></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_desposi" value="0">Incontinente/Requiere enemas para evacuar de forma rutinaria. <b>(0 ptos)</b></label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                    <label><b>Micción</b></label>
                                        <div class="radio">
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_miccion" value="10">Continente o es capaz de cuidarse la sonda. <b>(10 ptos)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_miccion" value="5">Ocasionalmente algún episodio de incontinencia en 24 h, necesita ayuda para cuidar la sonda.<b>(5 ptos)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_miccion" value="0">Incontinente/usa sonda a permanencia y alguien debe supervisar su funcionalidad. <b>(0 ptos)</b></label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label><b>Usar el retrete </b></label>
                                        <div class="radio">
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_retrete" value="10">Independiente para usar el váter, quitarse y ponerse la ropa. <b>(10 pto)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_retrete" value="5">Necesita ayuda para ir al váter pero se limpia solo. <b>(5 pto)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_retrete" value="0">Dependiente. <b>(0 ptos)</b></label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label><b>Trasladarse  </b></label>
                                        <div class="radio">
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_trasladarse"  value="15">Independiente para ir del sillón a la cama.<b>(15 pto)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_trasladarse"  value="10">Necesita ayuda física o supervisión para caminar 50 m<b>(10 pto)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_trasladarse"  value="5">Gran ayuda pero es capaz de mantenerse sentados sin ayuda<b>(5 pto)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_trasladarse"  value="0">Dependiente. <b>(0 ptos)</b></label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label><b>Deambular   </b></label>
                                        <div class="radio">
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_deambulae" value="15">Independiente camina solo 50m . <b>(15 pto)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_deambulae" value="10">Necesita ayuda física o supervisión para caminar 50m. <b>(10 pto)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_deambulae" value="5">Independiente en silla de ruedas sin ayuda. <b>(5 pto)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_deambulae" value="0">Dependiente. <b>(0 ptos)</b></label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label><b>Uso de Escaleras </b></label>
                                        <div class="radio">
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_uso_retrete" value="10">Independiente para subir y bajar escaleras.<b>(10 pto)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_uso_retrete" value="5">Necesita ayuda física o supervisión.<b>(5 pto)</b></label></div>
                                            <div class="radio"><label><input type="radio" class="suma_barthel" name="rt_uso_retrete" value="0">Dependiente.<b>(0 ptos)</b></label></div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- modal-body  de FUNCIONALIDAD BARTHEL-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
              <!-- Escala de Fragilidad -->
              <div class="col-md-4">
                <label><b>ESCALA DE FRAGILIDAD</b></label>
                <div class="input-group">
                  <input  type="text" size="25" class="form-control" data-toggle="modal" data-target='#eFragilidad' placeholder="Clic para colocar valor" name="escalaFragilidad" id="puntos_eFragilidad" value='<?=$hojafrontal[0]['escala_fragilidad']?>'  autocomplete="off" readonly style="background-color: white;" required>
                </div>
              </div>
              <!-- Modal Esala Faailidad -->
                <div class="modal fade" id="eFragilidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" id="">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel">ESCALA DE FRAGILIDADA</h4>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12">
                              <label><b>CUESTIONARIO FRAIL PARA DETECCIÓN DE FRAGILIDAD EN ADULTO MAYOR</b></label>
                              <div class="checkbox">
                                <label style="TEXT-ALIGN:justify">
                                  <input type="checkbox" class="suma_ef" name="ef1" value="1">
                                  ¿Está usted cansado?
                                </label>
                              </div>
                              <div class="checkbox">
                                <label style="TEXT-ALIGN:justify">
                                  <input type="checkbox" class="suma_ef" name="ef2" value="1">¿Es incapaz de subr un piso de escaleras?
                                </label>
                              </div>
                              <div class="checkbox">
                                <label style="TEXT-ALIGN:justify">
                                  <input type="checkbox" class="suma_ef" name="ef3" value="1">¿Es incapaz de caminar una manzana?
                                </label>
                              </div>
                              <div class="checkbox">
                                <label style="TEXT-ALIGN:justify">
                                  <input type="checkbox" class="suma_ef" name="ef4" value="1">¿Tiene más de 5 enfermedades?
                                </label>
                              </div>
                              <div class="checkbox">
                                <label style="TEXT-ALIGN:justify">
                                  <input type="checkbox" class="suma_ef" name="ef5" value="1">¿Ha perdido más del 5% de su peso en los últimos 6 meses?
                                </label>
                              </div>
                              <div class="checkbox">
                                <label style="TEXT-ALIGN:justify">
                                  <input type="checkbox" class="suma_ef" name="ef6" value="0">Ninguna de las anteriores
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                        </div>
                      </div>
                    </div>
                </div>
            </div> <!-- cierre de fila de escalas medicas -->
          </div>
          <!-- Metodos auxilires de diagnstico -->   
          <div class="panel panel-default panel-x">
            <div class="panel-heading"><h4>Métodos Auxiliares de Diagnóstico</h4></div>
            <div class="panel-body ">
              <div class="form-group">
                <textarea class="form-control editor" id="area_editor5" rows="2" name="hf_auxiliares" placeholder="Anote los análisis clínicos de laboratorio, los estudios de gabinete radiológico y otros"><?=$hojafrontal[0]['hf_auxiliares']?></textarea>
              </div>
            </div>
          </div>
                <!--
                <div class="panel panel-default panel-x">
                  <div class="panel-heading"><h4>Procedimientos</h4></div>
                  <div class="panel-body">
                    <?php
                    // Declara el estado original checkbox de procedimientos
                    // Al editar, modifica el estado del checkbox
                      if(empty($hojafrontal[0]['hf_procedimientos'])){
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
                      <label>Se realizó algun Procedimiento</label>  
                      <h4><label class="md-check"><input type="checkbox" name="check_procedimientos" <?=$checkEstado ?> value="<?= $valor_check ?>">
                           <i class="indigo"></i>
                         </label>
                          </h4>
                          <div class="input-group m-b div_procedimientos" <?= $estadoDiv ?> >
                            <span class="input-group-addon back-imss border-back-imss"><i class="fa fa-user-plus"></i></span>
                            <select class="select2" multiple="" name="procedimientos[]" id="procedimientos" data-value="<?=$hojafrontal[0]['hf_procedimientos']?>" style="width: 100%" >
                                 <?php foreach ($Procedimientos as $value) {?>
                                  <option value="<?=$value['procedimiento_id']?>"><?=$value['nombre']?></option>
                                 <?php }?>
                            </select>
                    </div>
                  </div>
                 </div> -->
          <!-- Exploracion Fisica -->
          <div class="panel panel-default panel-x">
            <div class="panel-heading"><h4>Diagnóstico de Ingreso y Comorbilidades</h4></div>
            <div class="panel-body ">
              <div class="form-group">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="">Diagnóstico con código CIE-10</label>
                    <div class="input-group m-b">
                        <span class="input-group-addon">
                          <i class="fa fa-stethoscope" style="font-size: 16px"></i>
                        </span>
                        <input type="text" class="form-control" name="cie10_nombre" placeholder="Tecleé el diagnóstico a buscar y seleccione (minimo 5 caracteres)" >
                          <span class="input-group-addon back-imss border-back-imss add-cie10"><i class="fas fa fa-search pointer"></i></span>
                    </div>
                    <div class="row row-diagnosticos"></div>
                  </div>                                                           
                </div>
              </div>
            </div>
          </div>
          <!-- Plan y Ordenes Medicas -->
          <div class="panel panel-default panel-x">
            <div class="panel-heading"><h4>Plan y Ordenes Médicas</h4></div>
            <div class="panel-body ">
              <!-- Insrucciones de Nutricion -->
              <div class="col-sm-12" id="divNutricion" style="padding-top: 12px">
                <div class="col-sm-3"  id="divRadioNutricion" style="padding-left: 0px">
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
                        if($hojafrontal[0]['hf_nutricion'] == '0'){
                          $checkAyuno = 'checked';
                        }else if($hojafrontal[0]['hf_nutricion'] == '1' || $hojafrontal[0]['hf_nutricion'] == '2'
                        || $hojafrontal[0]['hf_nutricion'] == '3'|| $hojafrontal[0]['hf_nutricion'] == '4'|| $hojafrontal[0]['hf_nutricion'] == '5'
                        || $hojafrontal[0]['hf_nutricion'] == '6'|| $hojafrontal[0]['hf_nutricion'] == '7'|| $hojafrontal[0]['hf_nutricion'] == '8'
                        || $hojafrontal[0]['hf_nutricion'] == '9'|| $hojafrontal[0]['hf_nutricion'] == '10'|| $hojafrontal[0]['hf_nutricion'] == '11'
                        || $hojafrontal[0]['hf_nutricion'] == '12'){
                          $checkDieta = 'checked';
                          $divSelectDietas = '';
                          $select_dietas = $hojafrontal[0]['hf_nutricion'];
                        }else{
                          $divSelectDietas = '';
                          $checkDieta = 'checked';
                          $divOtraDieta = '';
                          $select_dietas = '13';
                          $otraDieta = $hojafrontal[0]['hf_nutricion'];
                        }
                      }?>

                    <div class="form-group radio">
                      <label class="md-check">
                        <input type="radio" class="has-value" value="0" id='radioAyuno' name="dieta" <?= $checkAyuno ?> ><i class="red"></i>Ayuno
                      </label>
                      <label class="md-check">
                        <input type="radio" class="has-value" value="" id='radioDieta' name="dieta" <?= $checkDieta ?> ><i class="red"></i>Dieta
                      </label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3" id="divSelectDietas" <?= $divSelectDietas ?>>
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
                <div class="col-sm-6" id='divOtraDieta'  style="padding:0" <?= $divOtraDieta ?> >
                  <div class="form-group">
                    <label>Otra dieta:</label>
                    <input type="text" class="form-control" name="otraDieta" value="<?= $otraDieta ?>" id="inputOtraDieta" placeholder="Otra dieta">
                  </div>
                </div>
              </div>
              <!-- Toma de signos vitales -->
              <div class="col-sm-12" id="divSignos">
                <?php
                  // Declara estado original del select cuando se realiza nueva nota
                  $select_signos = 0;
                  $otras_indicaciones = 'hidden';
                  // El estado de las variables cambia al realizar un cambio, esto para determinar si el valor corresponde al select o textarea
                  if($_GET['a'] == 'edit'){
                    if($hojafrontal[0]['hf_signosycuidados'] == '0' || $hojafrontal[0]['hf_signosycuidados'] == '1' || $hojafrontal[0]['hf_signosycuidados'] == '2' ){
                      $select_signos = $hojafrontal[0]['hf_signosycuidados'];
                    }else{
                      $select_signos = "3";
                      $otras_indicaciones = '';
                    }
                }?>    
                <div class="col-sm-4" style="padding:0" id="divTomaSignos">
                  <div class="form-group">
                    <h5><span><b>b) Toma de signos vitales: </b></span></h5>
                    <select  id="selectTomaSignos" class="form-control" data-value="<?= $select_signos ?>" name="tomaSignos">
                      <option value="0">Toma de signos</option>
                      <option value="1">Por turno</option>
                      <option value="2">Cada 4 horas</option>
                      <option value="3">Otros</option>
                    </select>
                  </div>
                </div>
                <div id="divOtrasInidcacionesSignos"  <?= $otras_indicaciones ?>>
                  <div class="col-sm-8" style="padding-right: 0">
                    <div class="form-group">
                      <label>Otras inidcaciones:</label>
                      <input type="text" name="otrasIndicacionesSignos" class="form-control" placeholder="Otras indicaciones" value="<?=$hojafrontal[0]['hf_signosycuidados']?>">
                    </div>
                  </div>
                </div>
              </div>
              <!-- Cuidados generales de enfermeria -->
              <div class="col-sm-12">
                <div class="col-sm-12" id="divCuidadosGenerales" style="padding-left: 0px" >
                  <div class="form-group ">
                    <h5> 
                        <?php
                        // Declara el estado original checkbox de cuidados generales de enfermeria
                        $labelCheck = '';
                        $hiddenCheck = 'hidden';
                        // Al editar, modifica el estado del checkbox
                        if($hojafrontal[0]['hf_cgenfermeria'] == 1){
                          $check_generales = 'checked';
                          $labelCheck = '';
                          $hiddenCheck = '';
                        }?>
                      
                        <b>c)</b>
                        <label class="md-check">
                          <input type="checkbox" id="checkCuidadosGenerales" name="hf_cgenfermeria" value="1" <?= $check_generales ?> ><i class="indigo"></i>
                        </label> 
                        <b>Cuidados generales de enfermeria</b>
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
                  <textarea class="form-control hf_cuidadosenfermeria editor" id="area_editor6" name="hf_cuidadosenfermeria" rows="5" placeholder="Cuidados especiales de enfermeria"><?=$hojafrontal[0]['hf_cuidadosenfermeria']?></textarea>
                </div>
              </div>
              <!-- Soliciones parenterales -->        
              <div class="col-sm-12" id="divCuidadosGenerales">
                <div class="form-group">
                    <h5><span><b>e) Soluciones parenterales</b></span></h5>
                    <textarea class="form-control hf_solucionesp editor" id="area_editor7" name="hf_solucionesp" rows="5" placeholder="Soluciones Parenterales"><?=$hojafrontal[0]['hf_solucionesp']?></textarea>
                  </div>
              </div>
              <!-- Estudios de Laboratorio -->
              <div class="col-sm-12" id="EstudiosLaboratorio">
                <div class="form-group">
                  <h5><b>f) 


            
                          Solicitud de Estudios de Laboratorio</b>
                    <?php
                    if( $um_estudios_obj[0]['solicitud_id'] && $um_estudios_obj[0]['estudios']!="{}"){
                      $hidden = "";?>    
                    
                  </h5>
                  <input type="hidden" name="solicitud_laboratorio_id" value="<?=$um_estudios_obj[0]['solicitud_id']?>">
                  <input type="hidden" id ="arreglo_id_catalogo_estudio" name="arreglo_id_catalogo_estudio"  class="" type="text" size="15" maxlength="30" value='<?=$um_estudios_obj[0]['estudios']?>' name="nombre">                                    
                    <?php
                    }else{
                         $hidden = "hidden"; ?>                                  
                        <label class="md-check" >&nbsp;<input type="checkbox" id="check_estudios_lab"  >
                          <i class="indigo"></i>
                        </label>
                        <input type="hidden" name="solicitud_laboratorio_id" value="<?=$um_estudios_obj[0]['solicitud_id']?>">
                        <input type="hidden" id ="arreglo_id_catalogo_estudio" name="arreglo_id_catalogo_estudio"  class="" type="text" size="15" maxlength="30" value='{}' name="nombre">
                    <?php }?>
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
                                  <td><a class="delete_row_catalogo_lab" title="Delete" data-toggle="tooltip" value = "<?=$nombre?>" ><i class="glyphicon glyphicon-trash"></i></a>
                                  </td>
                              </tr>
                              <?php } ?>
                              </tbody>
                          </table>
                      </div>
                    </div>
                </div>
              </div>                
              <!-- estudios modal-->
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
              <div class="col-md-12">
                <div class="form-group">
                  <h5><span><b>g) <label class="md-check">
                                    <input type="checkbox" id="check_form_prescripcion"><i class="indigo"></i>
                                  </label>
                               Prescripción de medicamentos
                             </b>
                      </span>
                  </h5>
                </div>
                <!-- Panel con el historial de prescripciones -->
                <nav class=" back-imss">
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
                <div>
                  <table class="table-hover table-condensed table-responsive"
                   id="historial_medicamentos_activos" style="width:100%; font-size:11px;" >
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
                  <div class="panel-group" id='historial_movimientos' hidden></div>
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
                  <div class="panel-group" id='historial_notificaciones' hidden></div>
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
                    </div>
                     <!-- Fin formulario prescripcion-->
              </div>
            </div>
          </div>
          <!-- Panel de condiciones de salud -->
          <div class="panel panel-default panel-x">
            <div class="panel-heading"><h4>Condiciones de Salud</h4></div>
            <div class="panel-body ">
              <div class="col-sm-12" style="padding: 0;">
                <div class="form-group">
                  <h5><span><b>Estado de Salud</b></span></h5>
                    &nbsp;&nbsp;&nbsp;
                  <label class="md-check">
                    <input type="radio" name="hf_estadosalud" data-value="<?=$hojafrontal[0]['hf_estadosalud']?>" class="has-value" value="Estable"><i class="red"></i>Estable
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                  <label class="md-check">
                    <input type="radio" name="hf_estadosalud" data-value="<?=$hojafrontal[0]['hf_estadosalud']?>" class="has-value" value="Delicado"><i class="red"></i>Delicado
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                  <label class="md-check">
                    <input type="radio" name="hf_estadosalud" data-value="<?=$hojafrontal[0]['hf_estadosalud']?>" class="has-value" value="Muy Delicado"><i class="red"></i>Muy Delicado
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                  <label class="md-check">
                    <input type="radio" name="hf_estadosalud" data-value="<?=$hojafrontal[0]['hf_estadosalud']?>" class="has-value" value="Grave"><i class="red"></i>Grave
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                  <label class="md-check">
                    <input type="radio" name="hf_estadosalud" data-value="<?=$hojafrontal[0]['hf_estadosalud']?>" class="has-value" value="Muy Grave"><i class="red"></i>Muy Grave
                  </label>
                </div>
              </div>
              <div class="col-sm-12" style="padding: 0;">
                <div class="form-group">
                  <h5><span><b>Pronóstico</b></span></h5>
                    <!-- tabla de hf_indicaciones en -->
                  <textarea class="form-control" rows="1" name="hf_indicaciones"><?=$hojafrontal[0]['hf_indicaciones']?></textarea>
                </div>
              </div> 
            </div>
          </div>
          <!-- Acciones y decisiones medicas -->
          <div class="panel panel-default panel-x">
            <div class="panel-heading"><h4>Acciones y Decisiones Médicas</h4></div>
            <div class="panel-body ">
              <div class="col-md-12">
                <div class="form-group">
                  <h5><span><b>Destino</b></span></h5>
                  <?php 
                  if($_GET['tipo'] != 'Choque' && $_GET['tipo'] != 'Observación' ){?>
                    <div class="col-md-4">
                      <?php 
                      if( $_GET['tipo']=='Consultorios'){
                        if($ce[0]['ce_status']=='Salida'){?>
                          <label><b>ALTA A :</b> </label> <?=$ce[0]['ce_hf']?>
                        <?php 
                        }else{?>
                          <select name="hf_alta" data-value="<?=$hojafrontal[0]['hf_alta']?>" class="form-control" required>
                            <option value="" disabled>Seleccione una acción</option>
                            <option value="Alta a Domicilio">Alta a Domicilio</option>
                            <option value="Observación Admisión Continua">Enviar a observación Admisión Continua</option>
                            <option value="Observación corta estancia">Enviar a observación corta estancia</option>
                            <option value="Alta a Domicilio">Alta a Domicilio</option>
                            <option value="Alta a UMF">Alta a UMF</option>
                            <option value="Alta a HGZ">Alta a HGZ</option>
                            <option value="Alta a HRZ">Alta a HRZ</option>
                            <option value="Otros">Otros</option>
                          </select>
                        <?php }?>     
                      </div>
                      <div class="col-md-8 hf_alta_otros hide">          
                        <input type="text" name="hf_alta_otros" placeholder="Indique otra acción" value="<?=$hojafrontal[0]['hf_alta_otros']?>" class="form-control" autocomplete="off">
                      </div>
                      <?php 
                    }
                  }?>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group"><?php
                  if(count($Interconsultas) > 0){
                    $check = 'checked';
                    $style = "";
                    $value_check = "1";
                  }
                  else{
                    $style = "style='display:none'";
                    $value_check = "0";
                  }?>
                  <h5><span><b><label class="md-check">
                                <input type="checkbox" name="check_solicitud_interconsulta" value="<?=$value_check?>" <?=$check  ?>>
                                  <i class="indigo"></i>
                                </label>
                                Solicitud de Interconsultas
                            </b>
                      </span>
                                        
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
                  <div class="input-group m-b nota_interconsulta " <?=$style?> >
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
                  <textarea class="form-control motivo_interconsulta" name="motivo_interconsulta"><?=$Interconsultas[0]['motivo_interconsulta'] ?></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <h5><span><b>Tipo de Urgencia</b></span></h5>
                  <label class="md-check" style="padding-bottom: 10px">
                    <input type="radio" name="hf_tipourgencia" value="1" data-value="<?=$hojafrontal[0]['hf_tipourgencia']?>" required><i class="red" style="margin-left: 10px;margin-right: 25px"></i>Urgencia Real
                  </label>
                  <label class="md-check" style="padding-bottom: 10px">
                      <input type="radio" name="hf_tipourgencia" value="2"  data-value="<?=$hojafrontal[0]['hf_tipourgencia']?>"><i class="red" style="margin-left: 10px;margin-right: 25px"></i>Urgencia Sentida
                  </label>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <h5><b>Médico Tratante</b></h5>
                        <input type="text" name="asistentesmedicas_mt" value="<?=$INFO_USER[0]['empleado_nombre'].' '.$INFO_USER[0]['empleado_apellidos']?>" readonly="" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <h5><b>Matricula</b></h5>
                        <input type="text" name="asistentesmedicas_mt_m" value="<?=$INFO_USER[0]['empleado_matricula']?>" readonly="" class="form-control">
                    </div>
                 </div>
                </div>
              </div>
            </div>
          </div>
                                    
          <?php 
          if($_GET['tipo']=='Choque'){?>
            <hr style="margin-top: 30px;">
            <div class="col-md-4" style="margin-top: 10px">
              <div class="form-group">
                <label><b>POSIBLE DONADOR</b></label>&nbsp;&nbsp;&nbsp;
                <label class="md-check">
                  <input type="radio" name="po_donador"  data-value="<?=$po[0]['po_donador']?>" value="Si" class="has-value">
                  <i class="indigo"></i>Si
                </label>&nbsp;&nbsp;&nbsp;
                <label class="md-check">
                  <input type="radio" name="po_donador" checked="" value="No" class="has-value">
                  <i class="indigo"></i>No
                </label>
              </div>
            </div>
            <div class="col-md-8" style="margin-top: 10px">
              <div class="form-group po_donador hide" style="margin-top: -10px">
                <select class="form-control" name="po_criterio" data-value="<?=$po[0]['po_criterio']?>">
                  <option value="">Seleccionar</option>
                  <option value="Lesión encefalica severa">Lesión encefalica severa</option>
                  <option value="Glasgow">Glasgow</option>
                </select>
              </div>
            </div>
          <?php }?>
          <div class="row">
            <div class="col-md-12" style="padding-bottom: 25px; padding-top: 25px">
              <div class="col-md-offset-6 col-md-3">
                  <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
              </div>
              <div class="col-md-3">
                  <input type="hidden" name="csrf_token" >
                  <input type="hidden" name="triage_id" value="<?=$_GET['folio']?>">
                  <input type="hidden" name="hf_id" value="<?=$_GET['hf']?>">
                  <input type="hidden" name="accion" value="<?=$_GET['a']?>">
                  <input type="hidden" name="tipo" value="<?=$_GET['tipo']?>">
                  <input type="hidden" name="ce_status" value="<?=$ce[0]['ce_status']?>">
                  <input type="hidden" name="tipo_nota" value="<?=$_GET['TipoNota']?>">
                  <button class="btn back-imss btn-block" type="submit">Guardar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
                      
<?= modules::run('Sections/Menu/footer'); ?>
<script type="text/javascript" src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js"></script>
<script src="<?= base_url()?>assets/libs/bootstrap3-typeahead/bootstrap3-typeahead.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/CIE10.js?md5='). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Documentos.js?md5'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Funcionalidad_Barthel.js?md5'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Diagnosticos.js?md5'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Laboratorios.js?md5'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/build/jodit.min.js')?>"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/assets/prism.js')?>"></script>

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
                      buttonsSM:  ',about',
                      buttonsXS: 'source'
  
                });

                //editor.selection.insertCursorAtPoint(e.clientX, e.clientY);
            }
        //});
    });
</script>