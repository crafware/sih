<?= modules::run('Sections/Menu/index'); ?> 
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/libs/light-bootstrap/all.min.css" />
<style>hr.style-eight {border: 0;border-top: 2px dashed #8c8c8c;text-align: center;}hr.style-eight:after {content: attr(data-titulo);display: inline-block;position: relative;top: -13px;font-size: 1.2em;padding: 0 0.20em;background: white;font-weight:bold;}</style>
<div class="box-row">
   <div class="box-cell">
      <div class="col-md-11 col-centered">
         <div class="box-inner padding">
            <div class="panel panel-default " style="margin-top: -10px">
               <div class="panel-heading p teal-900 back-imss">
                  <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">
                      <div class="row">
                          <div class="col-md-8">
                              <b>Registro de Paciente (430-51) :</b> <?=$info[0]['triage_nombre']=='' ? $info[0]['triage_nombre_pseudonimo']: $info[0]['triage_nombre_ap'].' '.$info[0]['triage_nombre_am'].' '.$info[0]['triage_nombre']?>
                          </div>
                          <div class="col-md-4 text-right">
                              <b>DESTINO: HOSPITALIZACIÓN</b>
                          </div>
                          <div class="col-md-4">
                              <b>FOLIO: <?=$info[0]['triage_id']?></b>
                          </div>
                          
                      </div>   
                  </span>
               </div>
               <form class="regitro43051">
                  <div class="panel-body b-b b-light">
                     <div class="card-body">
                       <div class="row">
                           <div class="col-md-4">
                               <div class="form-group">
                                   <div class="form-group">
                                       <label class="mayus-bold"><b>CUENTA CON N.S.S</b></label><br>
                                       <label class="md-check">
                                           <input type="radio" name="triage_paciente_afiliacion_bol" value="Si" data-value="<?=$PINFO['pum_nss']?>">
                                           <i class="blue"></i>SI
                                       </label>&nbsp;&nbsp;
                                       <label class="md-check">
                                           <input type="radio" name="triage_paciente_afiliacion_bol" value="No" checked="" data-value="<?=$PINFO['pum_nss']?>">
                                           <i class="blue"></i>NO
                                       </label>

                                   </div> 
                               </div>
                           </div>
                           <div class="col-md-4 triage_paciente_afiliacion_bol hide">
                               <label class="mayus-bold">N.S.S</label>
                               <div class="input-group">
                                   <input class="form-control" name="pum_nss" placeholder="" value="<?=$PINFO['pum_nss']?>" data-inputmask="'mask': '9999-99-9999-9'" required>
                                   <span class="input-group-btn">
                                     <button type="button" class="btn btn-success" id="btnVerificarNSS" >Verificar</button>
                                   </span>
                               </div>
                           </div>
                           <div class="col-md-4 triage_paciente_afiliacion_bol hide">
                               <label class="mayus-bold">N.S.S AGREGADO</label>
                               <div class="form-group"> 
                                   <input type="text" name="pum_nss_agregado" value="<?=$PINFO['pum_nss_agregado']?>" class="form-control">
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label class="mayus-bold">APELLIDO PATERNO</label>
                                   <input type="text" name="triage_nombre_ap" value="<?=$info[0]['triage_nombre_ap']?>" class="form-control">
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label class="mayus-bold">APELLIDO MATERNO</label>
                                   <input type="text" name="triage_nombre_am" value="<?=$info[0]['triage_nombre_am']?>" class="form-control">
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group" >
                                   <label class="mayus-bold">NOMBRE/PSEUDONIMO</label>
                                   <input class="form-control" name="triage_nombre" value="<?=$info[0]['triage_nombre']=='' ? $info[0]['triage_nombre_pseudonimo']: $info[0]['triage_nombre']?>">   
                               </div> 
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label class="mayus-bold">FECHA DE NACIMIENTO</label>
                                   <input type="text" name="triage_fecha_nac" value="<?=$info[0]['triage_fecha_nac']?>" class="form-control dd-mm-yyyy" > 
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group" >
                                   <label class="mayus-bold">SEXO</label>
                                   <select class="form-control"  name="triage_paciente_sexo" data-value="<?=$info[0]['triage_paciente_sexo']?>">
                                       <option value="">Seleccionar</option>
                                       <option value="HOMBRE">HOMBRE</option>
                                       <option value="MUJER">MUJER</option>
                                   </select>
                               </div>   
                           </div>

                           <div class="col-md-4">
                               <div class="form-group">
                                   <label>N.S.S ARMADO</label>
                                   <?php if($PINFO['pum_nss_armado']==''){?>
                                   <input type="text" name="" value="NO APLICA" class="form-control" readonly="">
                                   <?php }else{?>
                                   <input type="text" name="pum_nss_armado" value="<?=$PINFO['pum_nss_armado']?>" class="form-control" readonly="">
                                   <?php }?>
                               </div>
                           </div>
                       </div>
                       
                       <div class="row">
                           <div class="col-md-4">
                               <div class="form-group" >
                                   <label><b>U.M.F DE ADSCRIPCIÓN</b></label>
                                   <input class="form-control" name="pum_umf" placeholder="" value="<?=$PINFO['pum_umf']?>"> 
                               </div>                
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label style="text-transform: uppercase;font-weight: bold">Delegación IMSS</label>
                                   <input class="form-control" name="pum_delegacion" placeholder="" value="<?=$PINFO['pum_delegacion']?>"> 
                               </div>     
                               </div>
                           <div class="col-md-4">
                               <div class="form-group" >
                                   <label><b>C.U.R.P</b></label>
                                   <input class="form-control" name="triage_paciente_curp" placeholder="" value="<?=$info[0]['triage_paciente_curp']?>"> 
                               </div>                   
                           </div>                                    
                       </div>
                     </div>
                  </div>
                  <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                      <div class="col-md-12 back-imss text-center">
                          <h5><b>DATOS DEL DOMICILIO</b></h5>
                      </div>
                  </div>
                      <div class="panel-body b-b b-light">
                          <div class="card-body" style="padding-bottom: 0px">
                              <div class="row">
                                  <div class="col-md-4">
                                  <div class="form-group" >
                                      <label style="text-transform: uppercase;font-weight: bold">Código Postal</label>
                                      <div class="input-group">
                                          <input class="form-control" required name="directorio_cp" placeholder="" value="<?=$DirPaciente['directorio_cp']?>">
                                      <span class="input-group-btn">
                                          <button type="button" class="btn btn-secondary" id="buscarCP" ><i class="glyphicon glyphicon-search"></i></button>
                                      </span>
                                   </div>
                                </div>                  
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label style="text-transform: uppercase;font-weight: bold">Calle y Número</label>
                                          <input class="form-control" name="directorio_cn" placeholder="" value="<?=$DirPaciente['directorio_cn']?>"> 
                                      </div>                   
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label style="text-transform: uppercase;font-weight: bold">Colonia</label>
                                          <input class="form-control" name="directorio_colonia" placeholder="" value="<?=$DirPaciente['directorio_colonia']?>"> 
                                      </div>                   
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label style="text-transform: uppercase;font-weight: bold">Municipio</label>
                                          <input class="form-control" name="directorio_municipio" placeholder="" value="<?=$DirPaciente['directorio_municipio']?>"> 
                                      </div>    

                                  </div>

                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label style="text-transform: uppercase;font-weight: bold">Estado</label>
                                          <input class="form-control" name="directorio_estado" placeholder="" value="<?=$DirPaciente['directorio_estado']?>"> 
                                      </div>         

                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group" >
                                          <label><b>TELÉFONO DOMICILIO</b></label>
                                          <input class="form-control" name="directorio_telefono" placeholder="" value="<?=$DirPaciente['directorio_telefono']?>">  
                                      </div>                   
                                  </div>
                                  
                              </div>
                          </div>
                      </div>
                      <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                          <div class="col-md-12 back-imss text-center">
                              <h5><b>FAMILIAR RESPONSABLE</b></h5>
                          </div>
                      </div>
                      <div class="panel-body b-b b-light">
                          <div class="card-body" style="padding-bottom: 0px">
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label style="text-transform: uppercase;font-weight: bold">En Caso necesario llamar a</label>
                                          <input class="form-control" name="pic_responsable_nombre" placeholder="" value="<?=$PINFO['pic_responsable_nombre']?>"> 
                                      </div> 
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group" >
                                          <label style="text-transform: uppercase;font-weight: bold">Parentesco</label>
                                          <input class="form-control" name="pic_responsable_parentesco" placeholder="" value="<?=$PINFO['pic_responsable_parentesco']?>"> 
                                      </div>  
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group" >
                                          <label style="text-transform: uppercase;font-weight: bold">Teléfono del Responsable</label>
                                          <div class="input-group">
                                              <input class="form-control" name="pic_responsable_telefono" placeholder="" value="<?=$PINFO['pic_responsable_telefono']?>">
                                              <span class="input-group-btn">
                                                  <button target="_blank"  data-original-title="Dar click cuando el responsable tenga el mismo número que el paciente" type="button" class="btn btn-secondary tip" id="btnTelefonoPaciente" ><i class="glyphicon glyphicon-earphone"></i></button>
                                              </span>
                                          </div>
                                      </div>  
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                          <div class="col-md-12 back-imss text-center">
                              <h5><b>DATOS DE INTERNAMIENTO</b></h5>
                          </div>
                      </div>
                      <div class="panel-body b-b b-light">
                          <div class="card-body" style="padding-bottom: 0px">
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="mayus-bold">SERVICIO TRATANTE:</label>
                                          <input name="servicio" class="form-control"  value="<?=$Especialidad['especialidad_nombre']?>"readonly>
                                          <input type="hidden" name="ingreso_servicio" class="form-control"  value="<?=$Especialidad['especialidad_id']?>"readonly>  

                                          <!-- 
                                          <select name="ingreso_servicio" class="ingreso_servicio form-control" data-value="<?=$Doc43051['ingreso_servicio']?>" required>
                                                  <option value="" disabled selected>Seleccionar</option>
                                                  <?php foreach ($Especialidades as $value) {?>
                                                  <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                                                  <?php }?>
                                          </select>
                                          -->
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="mayus-bold">Médico Tratante</label>                            
                                          <select name="ingreso_medico" id="divMedicos" class="form-control" data-value="<?=$Doc43051['ingreso_medico']?>" required>
                                              <!-- Se llena las opciones de manera dinamica desde ajax y controlador -->
                                              <option value='' disabled selected>Seleccionar</option>
                                              <?php foreach ($medicosPorServicio as $value) {?>
                                                  <option value="<?=$value['empleado_id']?>"><?=$value['empleado_apellidos']?> <?=$value['empleado_nombre']?></option>
                                              <?php }?>
                                              <!-- <option value="<?=$Doc43051['ingreso_medico']?>"><?=$medicoTratante['empleado_apellidos']?> <?=$medicoTratante['empleado_nombre']?> </option> -->
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group" >
                                          <label style="text-transform: uppercase;font-weight: bold">Asistente Médica Registra</label>
                                          <input class="form-control" name="pic_am" required="" placeholder="" value="<?=$PINFO['pic_am']=='' ? $empleado[0]['empleado_nombre'].' '.$empleado[0]['empleado_apellidos'] : $PINFO['pic_am']?>" readonly> 
                                      </div> 
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="">
                                          <label class="mayus-bold">DIAGNOSTICO DE INGRESO</label>
                                          <div>
                                              <h5><?=$nombreDx['cie10_nombre']?></h5><?php
                                              if($pacienteDx['complemento'] != ""){?>
                                                  <h5><?=$pacienteDx['complemento']?></h5><?php
                                              }?>
                                          </div>
                                  

                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="">
                                          <label class="mayus-bold">MOTIVO DE INTERNAMIENTO</label>
                                          <div>
                                              <h5><?=$ordeninternamiento['motivo_internamiento']?></h5>
                                          </div>
                                  

                                      </div>
                                  </div>
                              </div>
                              <div class="row hidden">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="mayus-bold">DIAGNOSTICO DE INGRESO:</label>
                                          <input class="form-control" name="diagnostico_ingreso"  value="<?=$pacienteDx['cie10_id']?>">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="mayus-bold">MOTIVO DE INTERNAMIENTO</label>
                                          <input class="form-control" name="motivo_internamiento"  value="<?=$ordeninternamiento['motivo_internamiento']?>">          
                                      </div>
                                  </div>
                                  
                              </div>
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="mayus-bold">AREA</label>
                                          <select name="area" data-value="<?=$Doc43051['area_id']?>" class="form-control area" required>
                                              <option value="" >Selecionar area</option>
                                              <?php foreach ($Area as $value) {?>
                                               <option value="<?=$value['area_id']?>"><?=$value['area_nombre']?></option>
                                              <?php }?>                                                   
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="mayus-bold">CAMA</label>
                                          <select name="cama" id="cama" data-value="<?=$Doc43051['cama_id']?>" class="form-control" required>
                                              <!-- Se llena las opciones de manera dinamica desde ajax y controlador -->
                                              <option value="" >Selecionar cama</option>
                                              <?php foreach ($Cama as $value) {?>
                                               <option value="<?=$value['cama_id']?>"><?=$value['cama_nombre']?></option>
                                              <?php }?>  
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="mayus-bold">PACIENTE CONTAGIOSO</label>
                                          <select name="riesgo_infeccion" data-value="<?=$Doc43051['riesgo_infeccion']?>" class="form-control" required>
                                              <option value="" disabled selected>Seleccionar</option>
                                              <option value="No" >No</option>
                                              <option value="Si" >Si</option>

                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                          <div class="col-md-12 back-imss text-center">
                              <h5><b>TIPO DE ATENCIÓN</b></h5>
                          </div>
                      </div>
                      <div class="panel-body b-b b-light">
                          <div class="card-body" style="padding-bottom: 0px">
                              <div class="row">
                                  <div class="col-md-12">
                                          <div class="col-md-4">
                                              <div class="form-group">
                                                  <label><b>PROCEDENCIA ESPONTÁNEA</b></label>&nbsp;
                                              <div>
                                                  <label class="md-check">
                                                      <input type="radio" name="pia_procedencia_espontanea" data-value="<?=$PINFO['pia_procedencia_espontanea']?>" value="Si" checked="" ><i class="green"></i>SI
                                                  </label>&nbsp;&nbsp;
                                                  <label class="md-check">
                                                      <input type="radio" name="pia_procedencia_espontanea" value="No"><i class="green"></i>NO
                                                  </label>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-4">
                                              <div class="form-group">
                                                  <label style="text-transform: uppercase;font-weight: bold">Tipo de atención</label>
                                                  <select class="form-control" id="pia_tipo_atencion" name="pia_tipo_atencion" data-value="<?=$PINFO['pia_tipo_atencion']?>" required>
                                                      <option value="" disabled>SELECCIONAR ATENCIÓN</option>
                                                      <option value="1.a VEZ">1.a VEZ</option>
                                                      <option value="SUBSECUENTE">SUBSECUENTE</option>
                                                      <option value="NO DERECHOHABIENTE">NO DERECHOHABIENTE</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-sm-4 col-no-espontaneo hidden">
                                              <div class="form-group">
                                                  <label><b>HOSPITAL DE PROCEDENCIA</b></label>
                                                  <select name="pia_procedencia_hospital" data-value="<?=$PINFO['pia_procedencia_hospital']?>" class="form-control">
                                                      <option value="">SELECCIONAR</option>
                                                      <option value="UMF">UMF</option>
                                                      <option value="HGZ">HGZ</option>
                                                      <option value="UMAE">UMAE</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-sm-4 col-no-espontaneo hidden">
                                              <div class="form-group">
                                                  <label class="mayus-bold">NÚMERO DEL HOSPITAL</label>
                                                  <input class="form-control" type="number" name="pia_procedencia_hospital_num"  value="<?=$PINFO['pia_procedencia_hospital_num']?>">
                                              </div>
                                          </div>
                                          <div class="col-sm-4 col-no-espontaneo hidden">
                                              <div class="form-group" >
                                                  <label style="text-transform: uppercase;font-weight: bold">Documento</label>
                                                  <input class="form-control"  name="pia_documento" placeholder="" value="<?=$PINFO['pia_documento']?>">
                                              </div>
                                          </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!--   Modal para verificacion del la vigencia de afiliacion -->
                  <div class="modal fade" id="ModalVigencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" id="modalTamanioG">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel">Validacion de Vigencia de Derechos</h4>
                              </div>
                              <div class="modal-body table-responsive" id="infoNSS">
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- fon del moda -->
                  <div class="row">
                      <div class="col-md-offset-8 col-md-2" >
                          <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
                      </div>
                      <div class="col-md-2">
                          <input type="hidden" name="via_registro" value="Hora Cero">
                          <input type="hidden" name="tipo_ingreso" value="Urgente">
                          <input type="hidden" name="csrf_token" >
                          <input type="hidden" name="triage_id" value="<?=$this->uri->segment(3)?>">
                          <input type="hidden" name="asistentesmedicas_id" value="<?=$solicitud[0]['asistentesmedicas_id']?>">
                          <button class="btn back-imss  btn-block" type="submit" >Guardar</button>                     
                      </div>
                      <br><br><br><br>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url()?>assets/libs/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js"></script>
<script src="<?= base_url('assets/js/Asistentemedica.js?'). md5(microtime())?>" type="text/javascript"></script> 
<script src="<?= base_url('assets/js/Asistentemedica_hosp.js?'). md5(microtime())?>" type="text/javascript"></script>
