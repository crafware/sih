    <form class="Form-Nota-Egreso">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
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
                }else if($_GET['TipoNota']=='Nota de Alta'){
                  $tipo_nota = 'Nota de Alta';
                }

                ?>
                <span class="input-group-addon back-imss border-back-imss">
                  <input type="text" class="tipo_nota form-control width100" name="notas_tipo" value="<?=$tipo_nota?>" readonly>
                </span>
            </div>
          </div>
        </div>
      </div>
      <!-- Actualización de Signos Vitales -->
      <div class="panel panel-default panel-y" >
        <div class="panel-heading"><h4>Actualización de Signos Vitales</h4></div>
        <div class="panel-body" >
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-4 col-sm-3 col-md-2">
              <div class="form-group">
                <label><b>T.A (mmHg)</b></label>
                <input class="form-control"  name="sv_ta" value="<?=$signosVitalesNota['sv_ta']?>">
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2">
              <div class="form-group">
                <label><b>Temp (°C)</b></label>
                  <input class="form-control" name="sv_temp"  value="<?=$signosVitalesNota['sv_temp']?>">
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2">
              <div class="form-group">
                <label><b>F. Cardiaca (lpm)</b></label>
                  <input class="form-control" name="sv_fc"  value="<?=$signosVitalesNota['sv_fc']?>">
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2">
              <div class="form-group">
                <label><b>F. Resp (rpm)</b></label>
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
                <label><b>Glucosa (mg/dl)</b></label>
                <input class="form-control" name="sv_dextrostix"  value="<?=$signosVitalesNota['sv_dextrostix']?>">
              </div>
            </div>
          </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="control-group">
                  <label><b>Peso (kg)</b></label>
                  <input class="form-control" name="sv_peso"  value="<?=$signosVitalesNota['sv_peso']?>">
                </div>
              </div>
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="control-group">
                  <label><b>Talla (cm)</b></label>
                  <input class="form-control" name="sv_talla"  value="<?=$signosVitalesNota['sv_talla']?>">
                </div>
              </div>
            </div>
          
        </div>
      </div>
      
      <!-- Motivo de Egreso -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Motivo de Egreso</h4></div>
        <div class="panel-body">
          <div class="col-md-4">
            <div class="form-group">
              <label class="md-check">
                <input type="radio" name="motivo_egreso" data-value="<?=$NotaAlta['motivo_egreso']?>" value="1" required><i class="blue"></i><span class="label-text">Alta Médica</span>
              </label>
            </div>
            <div class="form-group">
              <label class="md-check">
                <input type="radio" name="motivo_egreso" data-value="<?=$NotaAlta['motivo_egreso']?>" value="2"><i class="blue"></i><span class="label-text">Alta Voluntaria</span>
              </label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="md-check">
                <input type="radio" name="motivo_egreso" data-value="<?=$NotaAlta['motivo_egreso']?>" value="3"><i class="blue"></i><span class="label-text">Alta por Mejoria</span>
              </label>
            </div>
            <div class="form-group">
              <label class="md-check">
                <input type="radio" name="motivo_egreso" data-value="<?=$NotaAlta['motivo_egreso']?>" value="4"><i class="blue"></i><span class="label-text">Alta por Máximo Beneficio</span>
              </label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="md-check">
                <input type="radio" name="motivo_egreso" data-value="<?=$NotaAlta['motivo_egreso']?>" value="6"><i class="blue"></i><span class="label-text">Alta por Defunción</span>
              </label>
            </div>
            <div class="form-group">
              <label class="md-check">
                <input type="radio" name="motivo_egreso" data-value="<?=$NotaAlta['motivo_egreso']?>" value="7"><i class="blue"></i><span class="label-text">Alta por Fuga o Abandono</span>
              </label>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label class="md-check">
                <input type="radio" name="motivo_egreso"  data-value="<?=$NotaAlta['motivo_egreso']?>" value="5"><i class="blue"></i><span class="label-text">Alta por Transferencia a Otro Centro Hospitalario</span>
              </label>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Actualización de Diagnósticos -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Actualización de Diagnósticos de Ingreso y Egreso</h4></div>
          <div class="panel-body">
            <div class="col-md-12">   
              <div class="form-group">
                <label style="margin-top: 10px;padding-bottom: 10px"><b>Diagnóstico(s) Encontrado(s)</b></label>   
                <div class="row row-diagnosticos"> </div>
                <div class="col-md-12 input-group m-b hidden" id="add_dxsecundario" style="margin-top: 10px">
                <span class="input-group-addon"><i class="fa fa-stethoscope" style="font-size: 16px"></i></span>
                <input type="text" class="form-control" name="cie10_nombre" placeholder="Tecleé el diagnóstico a buscar y seleccione (minimo 5 caracteres)" >
                <span class="input-group-addon back-imss border-back-imss add-cie10"><i class="fas fa fa-search pointer"></i></span>
              </div>
            </div>        
          </div>
        </div>
      </div>

      <!-- Resumen Clínico -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Resumen Clínico</h4></div>
          <div class="panel-body">
            <div class="col-md-12">
              <div class="form-group" id = 'area_editor_div1'>
                  <textarea onchange="deleteTypeLetter('area_editor_div1');" class="form-control editor" name="resumen_clinico" id="area_editor1" placeholder="Anote el Resumen Clínico y Evolución del Paciente"><?=$NotaAlta['resumen_clinico']?></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Exploración Física -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Exploración fisica</h4></div>
        <div class="panel-body">
          <div class="col-md-12">
            <div class="form-group" id = 'area_editor_div2'>
              <textarea onchange="deleteTypeLetter('area_editor_div2');" class="form-control editor" name="exploracion_fisica" id="area_editor2" placeholder="Anote el estado fisico del paciente,, neurologico, respiratorios, cardiaco, gastrometabolico, genitourinario entre otros"><?=$NotaAlta['exploracion_fisica']?></textarea>
            </div>
          </div>
        </div>
      </div>

        <!-- Resultados de Laboratorio -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Resultados de estudio de Laboratorio</h4></div>
        <div class="panel-body">
          <div class="col-md-12">
            <div class="form-group" id = 'area_editor_div3'>
              <textarea onchange="deleteTypeLetter('area_editor_div3');" class="form-control editor" name="laboratorios" id="area_editor3" placeholder="Anote los resultados de Laboratorio y resultados de Examenes Clínicos"><?=$NotaAlta['laboratorios']?></textarea>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Estudios de Gabinete -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Resultados de estudios de Gabinete</h4></div>
        <div class="panel-body">
          <div class="col-md-12">
            <div class="form-group" id = 'area_editor_div4'>
              <textarea onchange="deleteTypeLetter('area_editor_div4');" class="form-control editor" name="gabinetes" id="area_editor4" placeholder="Anote los resultados de Rayos X y Gabinete"><?=$NotaAlta['gabinetes']?></textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- Pronostico -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Pronóstico</h4></div>
        <div class="panel-body">
          <div class="col-md-12">
            <div class="form-group">        
              <textarea class="form-control" name="pronostico" rows="2" placeholder="Anote"><?=$NotaAlta['pronostico']?></textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- Plan -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Plan</h4></div>
        <div class="panel-body">
          <div class="col-md-12">
            <div class="form-group" id = 'area_editor_div1_2'>        
              <textarea onchange="deleteTypeLetter('area_editor_div1_2');" class="form-control editor" name="plan" id="area_editor2" placeholder="Anote plan de salud"><?=$NotaAlta['plan']?></textarea>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Requerimiento del paciente -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Requerimientos del Paciente</h4></div>
        <div class="panel-body">
          <div class="col-md-12">
            <div class="col-md-3">
              <div class="form-group" style="padding-top: 10px;">        
                <?php
                  if($NotaAlta['req_oxigeno']==Null){
                    $checkEstado = "";
                    $valor_check = "0";
                  }else {
                    $checkEstado = "checked";
                    $valor_check = "1";
                  }
                ?>
                <span class="label-text">Requerimiento de Oxigeno</span>
                <label class="md-check">
                  <input type="checkbox" name="req_oxigeno" class="has-value"  value="<?=$valor_check?>" <?=$checkEstado?>><i class="green" ></i>
                </label>
              </div>  
            </div>
            <div class="col-md-3">    
              <?php
                
                  if(($NotaAlta['req_ambulancia'])==NUll){
                    $checkEstado2 = "";
                    
                    $valor_check2 = "0";
                  }else {
                    $checkEstado2 = "checked";
                    
                    $valor_check2 = "1";
                  }
              ?>                  
              <div class="form-group" style="padding-top: 10px">
                <span class="label-text">Requerimiento de Ambulancia</span>
                <label class="md-check">
                  <input type="checkbox" name="check_ambulancia" <?=$checkEstado2 ?> value="<?=$valor_check2?>"><i class="green"></i>
                </label>
              </div>  
            </div>
            <div class="col-md-4"> 
              <div class="form-group div_ambulancia hidden" style="padding-top: 10px">                     
                  <span class="label-text">Con oxigeno</span>
                  <label class="md-check">
                    <input type="radio" name="req_ambulancia"  data-value="<?=$NotaAlta['req_ambulancia']?>" value="2"><i class="green"></i>
                  </label>
                  <span class="label-text">Sin oxigeno</span>
                  <label class="md-check">
                    <input type="radio" name="req_ambulancia"  data-value="<?=$NotaAlta['req_ambulancia']?>" value="3"><i class="green"></i>
                  </label>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      
      <!-- Confirmación de Alta Paciente -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Confirmación de Alta de Paciente</h4></div>
        <div class="panel-body">
          <?php if($NotaAlta['prealta']==1){
                  $estado="Pre-alta";  ?>
                <div class="col-md-12">
                  <h5 class="text-color-red">Este paciente tiene una <?=$estado?></h5>
                </div>
          <?php }?>
          <div class="col-md-12">
            <?php if($_GET['a']=='add' || $NotaAlta['prealta']!='0' && $NotaAlta['proceso']!='1'){?>
                <div class="col-md-2" id="prealta">
                  <div class="form-group">
                    <label class="md-check">
                      <input type="radio" name="proceso" data-value="<?=$NotaAlta['proceso']?>" value="1" required><i class="blue"></i><span class="label-text">Pre-alta</span>
                    </label>
                  </div>
                </div>
            <?php }?> 
            <?php if($_GET['a']=='add' || $NotaAlta['alta']=='1' || $NotaAlta['alta']=='0'){?>
                <div class="col-md-2" id="alta">
                  <div class="form-group">
                    <label class="md-check">
                      <input type="radio" name="proceso" data-value="<?=$NotaAlta['proceso']?>" value="2" required><i class="blue"></i><span class="label-text">Alta</span>
                    </label>
                  </div>
                </div>
            <?php }?> 
            <?php if($_GET['a']=='edit' ){?>
                <div class="col-md-2" id="altacancelada">
                  <div class="form-group">
                    <label class="md-check">
                      <input type="radio" name="proceso" data-value="<?=$NotaAlta['proceso']?>" value="3"><i class="blue"></i><span class="label-text">Cancelar Alta</span>
                    </label>
                  </div>
                </div>
            <?php }?>
          
            <div class="col-md-4" id="informeFamiliar">
              <div class="form-group">
                <label for=""><span class="label-text">Nombre de persona qué recibe informes</span></label>
                <input type="text" class="form-control" name="recibe_informe" value="<?=$NotaAlta['recibe_informe']?>">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">        
              <textarea class="form-control editor" name="comentarios" id="area_editor3" placeholder="Comentarios"><?=$NotaAlta['comentarios']?></textarea>
            </div>
          </div>
        </div>
      </div>    
        

      <!-- Informacion del medico(s) -->
      <div class="panel panel-default ">
        <div class="panel-heading"><h4>Médico Tratante</h4></div>
        <div class="panel-body">
          <div class="col-md-12">
              <?php 
                  $medicoRol = -1;
                  foreach ($Usuario as $value) {
                    $medicoRol = $value['empleado_roles'];
                  } 
                  $empleado_roles = explode(",",$medicoRol);
                  for($i = 0;$i< count($empleado_roles);$i++){
                      if($empleado_roles[$i] == "77"){
                          $medicoRol = 77;
                      }
                  }
                  if ($medicoRol == 77){?>   

                    <div class="col-sm-12 col-md-12" style="padding-bottom: 10px">
                        <div style="background: white; border-bottom: 2px solid #E6E9ED">
                            <h4>MÉDICO TRATANTE <small>NOMBRE DE MEDICOS RESIDENTES</small></h4>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-ms-8">
                              <label>Nombre de supervisor Médico de Base:</label>
                              <input class="form-control" name="medicosBase" id="medicosBase" placeholder="Tecleé apellidos del médico y seleccione" value="<?=$medicoTratante['empleado_apellidos'].' '.$medicoTratante['empleado_nombre'];?>" autocomplete="off" required>     
                              <input type="hidden" name="medicoTratante" id="id_medico_tratante" value="<?=$NotaAlta['notas_medicotratante']?>"> 
                            </div>
                            <div class="col-sm-3 col-md-3">
                              <label>Matricula</label>           
                                <input class="form-control" id="medicoMatricula" type="text" name="medicoMatricula" placeholder="Matrícula Medico" value="<?=$medicoTratante['empleado_matricula']?>"  readonly>  
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
                            <label>Matricula</label>
                            <input class="form-control" id="residenteCedula" type="text" name="cedula_residente[]" placeholder="Matricula" value="<?=$Residentes[0]['cedulap_residente']?>" required>
                          </div>
                          <div class="col-sm-2 col-md-2">
                            <label>Grado</label>
                            <input class="form-control" id="grado" type="text" name="grado[]" placeholder="Grado (ej. R3MI)" value="<?=$Residentes[0]['grado']?>" required>
                          </div>
                          <div class="col-sm-1 col-md-1">
                            <label>Agregar +</label>
                            <a href='#' class="btn btn-success btn-xs" onclick=medicoResidente()  style="width:100%;height:100%;padding:7px;" id="add_otro_residente17" data-original-title="Agregar Médico Residente"><span class="glyphicon glyphicon-plus "></span></a>
                          </div>
                      
                        </div>
                    </div>
                    <div id="medicoResidente" style="padding-top: 10px;">
                        <?php for($i = 1; $i < count($Residentes); $i++){?>
                            <div class="col-sm-12 form-group" name ="medicoResidenteX" id="areaResidentes<?=$i ?>">
                               <div class="col-sm-4 col-md-3">                    
                                 <input type="text" class="form-control" id="medico<?=$i ?>" name="nombre_residente[]" placeholder="Nombre(s)" value="<?=$Residentes[$i]['nombre_residente']?>"  >
                               </div>
                               <div class="col-sm-4 col-md-3">                                  
                                 <input type="text" class="form-control" id="medico<?=$i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?=$Residentes[$i]['apellido_residente']?>"  >
                               </div>
                               <div class="col-sm-3 col-md-3">                                 
                                 <input type="text" class="form-control" id="medico<?=$i ?>" name="cedula_residente[]" placeholder="Matricula" value="<?=$Residentes[$i]['cedulap_residente']?>"  >
                               </div>
                               <div class="col-sm-2 col-md-2">
                                <input class="form-control" id="grado" type="text" name="grado[]" placeholder="Grado (ej. R3MI)" value="<?=$Residentes[$i]['grado']?>" required>
                              </div>
                              <div class=col-sm-1 >
                                <a href="#" onclick=quitarResidenteFormulario(<?=$i ?>) class="btn btn-danger delete btn-xs" style="width:100%;height:100%;padding:7px;" id="quitar_residente"><span class="glyphicon glyphicon-remove"></span></a>
                              </div>
                            </div>
                        <?php }?>
                        <?php for($i = 1; $i < 4-count($Residentes); $i++){?>
                            <div class="col-sm-12 form-group" name ="medicoResidenteX" id="areaResidentes<?=$i ?>"  style='display:none'>
                               <div class="col-sm-4 col-md-3">                    
                                 <input type="text" class="form-control" id="medico<?=$i ?>" name="nombre_residente[]" placeholder="Nombre(s)" value="<?=$Residentes[$i]['nombre_residente']?>"  >
                               </div>
                               <div class="col-sm-4 col-md-3">                                  
                                 <input type="text" class="form-control" id="medico<?=$i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?=$Residentes[$i]['apellido_residente']?>"  >
                               </div>
                               <div class="col-sm-3 col-md-3">                                 
                                 <input type="text" class="form-control" id="medico<?=$i ?>" name="cedula_residente[]" placeholder="Matricula" value="<?=$Residentes[$i]['cedulap_residente']?>"  >
                               </div>
                               <div class="col-sm-2 col-md-2">
                                <input class="form-control" id="grado" type="text" name="grado[]" placeholder="Grado (ej. R3MI)" value="<?=$Residentes[$i]['grado']?>">
                              </div>
                              <div class=col-sm-1 >
                                <a href="#" onclick=quitarResidenteFormulario(<?=$i ?>) class="btn btn-danger delete btn-xs" style="width:100%;height:100%;padding:7px;" id="quitar_residente"><span class="glyphicon glyphicon-remove"></span></a>
                              </div>
                            </div>
                        <?php }?>
                    </div>
            <?php }else{?>
                      <div class="col-md-12" style="background: white; padding: 25px 15px 15px 15px">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>NOMBRE</b></label>
                                    <input type="text" name="medicoTratante" value="<?=$value['empleado_apellidos'].' '.$value['empleado_nombre']?>" readonly="" class="form-control">
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
            <input name="triage_id" value="<?=$_GET['folio']?>" type="hidden">
            <input name="accion" value="<?=$_GET['a']?>" type="hidden">
            <input name="notas_id" value="<?=$this->uri->segment(4)?>" type="hidden">
            <input name="via" value="<?=$_GET['via']?>" type="hidden">
            <input name="inputVia" value="<?=$_GET['inputVia']?>" type="hidden">
            <input name="doc_id" value="<?=$_GET['doc_id']?>" type="hidden">
            <input name="umae_area" value="<?=$this->UMAE_AREA?>" type="hidden">
            <input name="tipo_nota" value="<?=$_GET['TipoNota']?>" type="hidden">
            <input name="cama_id" value="<?=$cama['cama_id']?>" type="hidden">
            <input name="area" value="<?=$this->UMAE_AREA?>" type="hidden">
            <button class="btn back-imss pull-right btn-block" type="submit" style="margin-bottom: -10px">Guardar</button>
        </div>
      </div>
    </form>  
  </div>
</div>
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js" type="text/javascript"></script>
<script src="<?= base_url()?>assets/libs/bootstrap3-typeahead/bootstrap3-typeahead.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Diagnosticos.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/CIE10.js?md5='). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/nota_egreso.js?'). md5(microtime())?>" type="text/javascript"></script>

<script src="<?= base_url('assets/libs/jodit-3.2.43/build/jodit.min.js')?>"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/assets/prism.js')?>"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/assets/app.js')?>"></script>
<script src="<?= base_url('assets/js/Doc_imagenes_estilo_letra.js?md5=') . md5(microtime()) ?>" type="text/javascript"></script>
<script>
    function quitarResidenteFormulario(residente) {
      $('#areaResidentes' + residente).hide();
      $('#areaResidentes' + residente).find("input").val("");
      $('#areaResidentes' + residente).attr("required",false)
    }
    function medicoResidente(){
      var medicoResidente = document.getElementsByName("medicoResidenteX");
      console.log(medicoResidente)
      for(var i = 0; i<3;i++){
        console.log(medicoResidente[i])
        if(medicoResidente[i].style.display == 'none'){
          medicoResidente[i].style.display = "";
          medicoResidente[i].required = true
          console.log(i)
          return 0
        }
      }
    }


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

