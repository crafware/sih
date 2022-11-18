<?= modules::run('Sections/Menu/HeaderBasico'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/libs/light-bootstrap/all.min.css" />
<link rel="stylesheet" href="<?= base_url()?>assets/libs/jodit-3.2.43/build/jodit.min.css"/>
<link rel="stylesheet" href="<?= base_url()?>assets/styles/notas.css"/>
<link rel="stylesheet" href="<?= base_url()?>assets/libs/bootstrap-toggle-master/css/bootstrap-toggle.min.css">
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
                  <h5>Fecha de última toma de signos: <?= date("d-m-Y", strtotime($UltimosSignosVitales[0]['fecha']));?></h5>
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
              <form class="Form-Nota-Egreso">
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
                          }else if($_GET['TipoNota']=='Nota de Egreso') {
                            $tipo_nota = 'Nota de Egreso';
                          }

                          ?>
                          <span class="input-group-addon back-imss border-back-imss">
                            <input type="text" class="tipo_nota form-control width100" name="notas_tipo" value="<?=$tipo_nota?>" readonly>
                         </span>
                      </div>
                    </div>
                  </div>
                </div>
                <!--   <?php if($_GET['a'] == 'add') {?>
                  <div class="col-md-12">
                    <div class="checkbox">
                        <label>
                          <input type="checkbox" id="checkbox_importaNota" data-toggle="toggle" data-size="small" data-off="importar" data-on="Cancelar">
                          IMPORTAR LA ÚLTIMA NOTA DE VALORACIÓN DE ESTE PACIENTE GENERADA EN EL SERVICIO
                        </label>
                    </div>
                  </div>
                  <?php }?> -->
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
                
                <div class="col-md-12">
                  <h4><span class = "label back-imss border-back-imss">MOTIVO DE EGRESO</span></h4>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="md-check">
                        <input type="radio" name="motivo_egreso" data-value="<?=$NotaEgreso['motivo_egreso']?>" value="1" required><i class="blue"></i><span class="label-text">Alta Médica</span>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="md-check">
                        <input type="radio" name="motivo_egreso" data-value="<?=$NotaEgreso['motivo_egreso']?>" value="2"><i class="blue"></i><span class="label-text">Alta Voluntaria</span>
                      </label>
                    </div>
                  <div class="form-group">
                    <label class="md-check">
                      <input type="radio" name="motivo_egreso" data-value="<?=$NotaEgreso['motivo_egreso']?>" value="3"><i class="blue"></i><span class="label-text">Alta por Mejoria</span>
                    </label>
                  </div>
                  <div class="form-group">
                    <label class="md-check">
                      <input type="radio" name="motivo_egreso" data-value="<?=$NotaEgreso['motivo_egreso']?>" value="4"><i class="blue"></i><span class="label-text">Alta por Máximo Beneficio</span>
                    </label>
                  </div>
                 </div>
                 <div class="col-md-5">
                    <div class="form-group">
                      <label class="md-check">
                        <input type="radio" name="motivo_egreso"  data-value="<?=$NotaEgreso['motivo_egreso']?>" value="5"><i class="blue"></i><span class="label-text">Alta por Transferencia a Otro Centro Hospitalario</span>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="md-check">
                        <input type="radio" name="motivo_egreso" data-value="<?=$NotaEgreso['motivo_egreso']?>" value="6"><i class="blue"></i><span class="label-text">Alta por Defunción</span>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="md-check">
                        <input type="radio" name="motivo_egreso" data-value="<?=$NotaEgreso['motivo_egreso']?>" value="7"><i class="blue"></i><span class="label-text">Alta por Fuga o Abandono</span>
                      </label>
                    </div>
                 </div>
                </div>
                <!-- INTTERCONSULTAS -->
                <div class="col-md-12">
                  <h4>
                    <span class = "label back-imss border-back-imss">SOLICITUD DE INTERCONSULTAS</span>
                  </h4>           
                  <div class="col-md-5">
                    <a data-toggle="collapse" data-target="#listaInterconsultas" aria-expanded="true">
                      <span class="glyphicon glyphicon-collapse-down"></span> Interconsultas solicitadas:
                    </a>            
                    <div class="collapse show" id="listaInterconsultas">
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
                <div class="col-md-12">   
                  <div class="form-group">
                    <h4><span class = "label back-imss border-back-imss">ACTUALIZACIÓN DE DIAGNÓSTICOS DE INGRESO Y EGRESO</span></h4>
                    <label style="margin-top: 10px;padding-bottom: 10px"><b>Diagnóstico(s) Encontrado(s)</b></label>   
                    <div class="row row-diagnosticos"> </div>
                    <div class="col-md-12 input-group m-b hidden" id="add_dxsecundario" style="margin-top: 10px">
                      <span class="input-group-addon"><i class="fa fa-stethoscope" style="font-size: 16px"></i></span>
                      <input type="text" class="form-control" name="cie10_nombre" placeholder="Tecleé el diagnóstico a buscar y seleccione (minimo 5 caracteres)" >
                      <span class="input-group-addon back-imss border-back-imss add-cie10"><i class="fas fa fa-search pointer"></i></span>
                    </div>
                  </div>        
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                      <h4><span class= "label back-imss border-back-imss">RESUMEN CLÍNICO</span></h4>
                      <textarea class="form-control editor" name="resumen_clinico" id="area_editor1" placeholder="Anote el Resumen Clínico y Evolución del Paciente"><?=$NotaEgreso['resumen_clinico']?></textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                      <h4><span class= "label back-imss border-back-imss">EXPLORACIÓN FISICA</span></h4>
                      <textarea class="form-control editor" name="exploracion_fisica" id="area_editor2" placeholder="Anote el estado fisico del paciente,, neurologico, respiratorios, cardiaco, gastrometabolico, genitourinario entre otros"><?=$NotaEgreso['exploracion_fisica']?></textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                      <h4><span class= "label back-imss border-back-imss">RESULTADOS DE ESTUDIOS DE LABORATORIO</span></h4>
                      <textarea class="form-control editor" name="laboratorios" id="area_editor3" placeholder="Anote los resultados de Laboratorio y resultados de Examenes Clínicos"><?=$NotaEgreso['laboratorios']?></textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                      <h4><span class= "label back-imss border-back-imss">RESULTADOS DE ESTUDIOS DE GABINETE</span></h4>
                      <textarea class="form-control editor" name="gabinetes" id="area_editor4" placeholder="Anote los resultados de Rayos X y Gabinete"><?=$NotaEgreso['gabinetes']?></textarea>
                  </div>
                </div>
               
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
                      <textarea class="form-control" name="pronostico" rows="2" placeholder="Anote diagnóstico y problemas clínicos"><?=$NotaEgreso['pronostico']?></textarea>
                  </div>
                </div>
              
                <div class="col-sm-12 col-md-12">
                  <div class="form-group">
                  <h4><span class = "label back-imss border-back-imss">PLAN</span></h4>
                      <textarea class="form-control editor" name="plan" id="area_editor2" placeholder="Anote plan de salud"><?=$NotaEgreso['plan']?>
                      </textarea>
                  </div>
                </div>
                
                <div class="col-sm-12 col-md-12">
                  <h4><span class = "label back-imss border-back-imss">REQUERIMIENTOS DEL PACIENTE</span></h4>
                    
                    <div class="col-md-3">                      
                      <div class="form-group" style="padding-top: 10px">
                        <?php
                        
                          if(empty($NotaEgreso['req_oxigeno'])){
                            $checkEstado = "";
                            $valor_check = "0";
                          }else {
                            $checkEstado = "checked";
                            $valor_check = "1";
                          }
                        ?>
                        <span>Requerimiento de Oxigeno</span>
                        <label class="md-check">
                          <input type="checkbox" name="req_oxigeno" class="has-value"  value="1"><i class="green" <?=$checkEstado?> ></i>
                        </label>
                      </div>  
                    </div>
                    <div class="col-md-3">    
                      <?php
                        
                          if(($NotaEgreso['req_ambulancia'])==NUll){
                            $checkEstado2 = "";
                            $estadoDiv = "style='display:none'";
                            $valor_check2 = "0";
                          }else {
                            $checkEstado2 = "checked";
                            $estadoDiv = "style='padding-top: 10px'";
                            $valor_check2 = "1";
                          }
                      ?>                  
                      <div class="form-group" style="padding-top: 10px">
                        <span>Requerimiento de Ambulancia</span>
                        <label class="md-check">
                          <input type="checkbox" name="check_ambulancia" <?=$checkEstado2 ?> value="<?= $valor_check2 ?>"><i class="green"></i>
                        </label>
                      </div>  
                    </div>
                    <div class="col-md-4"> 
                      <div class="form-group div_ambulancia" <?=$estadoDiv?> >                     
                        
                          <span style="padding: 10px;">Con oxigeno</span>
                          <label class="md-check">
                            <input type="radio" name="req_ambulancia"  data-value="<?=$NotaEgreso['req_ambulancia']?>" value="1"><i class="green"></i>
                          </label>
                                          
                        
                          <span style="padding: 0px 10px 0px 30px;">Sin oxigeno</span>
                          <label class="md-check">
                            <input type="radio" name="req_ambulancia"  data-value="<?=$NotaEgreso['req_ambulancia']?>" value="0"><i class="green"></i>
                          </label>
                         
                      </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                  <h4><span class = "label back-imss border-back-imss">¿SE ENTREGÓ INFORME MEDICO AL FAMILIAR?</span></h4>
                  <div class="col-md-3">
                    <div class="form-group" style="padding-top:25px">
                      <span style="padding: 10px;">No</span>
                        <label class="md-check">
                          <input type="radio" name="informeMedico" data-value="<?=$NotaEgreso['informe_medico']?>" value="0" required><i class="green"></i>
                        </label>
                        <span style="padding: 0px 10px 0px 30px;">Si</span>
                          <label class="md-check">
                            <input type="radio" name="informeMedico" data-value="<?=$NotaEgreso['informe_medico']?>" value="1"><i class="green"></i>
                          </label>
                    </div>
                  </div>
                  <div class="col-md-5 hidden" id="informeFamiliar">
                    <div class="form-group">
                      <label for="">Nombre del Familiar que recibe informes</label>
                      <input type="text" class="form-control" name="familiar_informe" value="<?=$NotaEgreso['informe_medico']?>">
                    </div>
                  </div>

                </div>
                <div class="col-md-12 col-sm-12">        
                  <h4><span class="label back-imss border-back-imss">MÉDICO QUIÉN REALIZA LA NOTA</span></h4>     
                </div>
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
                <?php }else {   

                    $medicoTratante= $this->config_mdl->_get_data_condition('os_empleados',array('empleado_id'=> $NotaEgreso['notas_medicotratante']));

                    if($_GET['via']=='Covid'){?>   
                      <div class="col-sm-12 col-md-12">
                         <div class="form-group">
                            <div class="col-sm-8 col-ms-8">
                              <label>Nombre de supervisor Médico de Base Covid:</label>
                              <input class="form-control" name="medicosBase" id="medicosBase" placeholder="Teclee el nombre del medico tratante" value="<?=$medicoTratante[0]['empleado_nombre']?> <?=$medicoTratante[0]['empleado_apellidos']?>" autocomplete="off" required>     
                              <input type="hidden" name="autocomplete" id="id_empleado"> 
                            </div>
                            <div class="col-sm-3 col-md-3">
                              <label style="color: white;">C </label>           
                                <input class="form-control" id="medicoMatricula" type="text" name="medicoMatricula" placeholder="Matrícula Medico" value="<?=$medicoTratante[0]['empleado_matricula']?>"  readonly>  
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
                    <?php }if($_GET['a']=='add') {
                          $colorLabel = 'white'; ?>
                      <div class="col-sm-12 col-md-12 disabled">        
                        <div class="form-group">
                          <div class="col-sm-3 col-md-3"> 
                            <label>Nombre(s) de médico(s) residente(s):</label>  
                            <input type="text" class="form-control" id="" name="nombre_residente[]" placeholder="Nombre(s)" value="" required>
                          </div>
                          <div class="col-sm-3">
                            <label>Apellido paterno y materno </label>
                               <input type="text" class="form-control" id="medico<?=$i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?=$Residentes[$i]['apellido_residente']?>" required>
                             </div>                             
                          <div class="col-sm-3 col-md-3">
                            <label>Cédula Profesional</label>
                            <input class="form-control" id="residenteCedula" type="text" name="cedula_residente[]" placeholder="Cédula Profesional" value="" required>
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
                           <div class="col-sm-3 col-md-3">
                            <!-- <label style="color: white;">Nombres</label> -->
                             <input type="text" class="form-control" id="medico<?=$i ?>" name="nombre_residente[]" placeholder="Nombre(s)" value="<?=$Residentes[$i]['nombre_residente']?>"  >
                           </div>
                           <div class="col-sm-3 col-md-3">
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
                  <div class="row">
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
        </div>
      </div>
    </div>
  </div>
</div>
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script type="text/javascript" src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js"></script>
<script src="<?= base_url()?>assets/libs/bootstrap3-typeahead/bootstrap3-typeahead.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/CIE10.js?md5='). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/nota_egreso.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Diagnosticos.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/build/jodit.min.js')?>"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/assets/prism.js')?>"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/assets/app.js')?>"></script>y
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

