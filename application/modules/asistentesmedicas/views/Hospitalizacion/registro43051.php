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
                                <div class="col-md-6">
                                    <b>Actualización de Datos de Paciente:</b> <?=$info[0]['triage_nombre']=='' ? $info[0]['triage_nombre_pseudonimo']: $info[0]['triage_nombre_ap'].' '.$info[0]['triage_nombre_am'].' '.$info[0]['triage_nombre']?>
                                </div>
                                <div class="col-md-2">Folio:&nbsp;<span><?=$info[0]['triage_id']?></span></div>
                                <div class="col-md-4 text-right">
                                    <b>DESTINO: <i class="fa fa-hospital-o"></i>&nbsp;&nbsp;&nbsp;HOSPITALIZACIÓN</b>
                                </div>
                            </div>   
                        </span>
                    </div>
                    <form class="regitroHospUrgente">
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

                                    <div class="col-md-4 hidden">
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
                                    <h5><b>DATOS DE TRABAJO</b></h5>
                                </div>
                            </div>

                            <div class="panel-body b-b b-light">
                                <div class="card-body" style="padding-bottom: 0px">
                                    <div class="row">  
                                      <div class="col-md-8">
                                        <div class="form-group">
                                          <label style="font-weight: bold">NOMBRE DE LA EMPRESA</label>
                                          <input class="form-control" name="empresa_nombre" placeholder="" value="<?=$Empresa['empresa_nombre']?>">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="text-transform: uppercase;font-weight: bold">Calle y Número</label>
                                                <input class="form-control" name="empresa_cn" placeholder="" value="<?=$DirEmpresa['empresa_cn']?>"> 
                                            </div>                   
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="text-transform: uppercase;font-weight: bold">Colonia</label>
                                                <input class="form-control" name="empresa_colonia" placeholder="" value="<?=$DirEmpresa['empresa_colonia']?>"> 
                                            </div>                   
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="text-transform: uppercase;font-weight: bold">Municipio</label>
                                                <input class="form-control" name="empresa_municipio" placeholder="" value="<?=$DirEmpresa['empresa_municipio']?>"> 
                                            </div>    

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="text-transform: uppercase;font-weight: bold">Estado</label>
                                                <input class="form-control" name="empresa_estado" placeholder="" value="<?=$DirEmpresa['empresa_estado']?>"> 
                                            </div>         

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" >
                                                <label><b>TELÉFONO DE LA EMPRESA</b></label>
                                                <input class="form-control" name="empresa_telefono" placeholder="" value="<?=$DirEmpresa['empresa_telefono']?>">  
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
                                                <select name="ingreso_servicio" class="ingreso_servicio form-control" data-value="<?=$Doc43051['ingreso_servicio']?>" required>
                                                        <option value='' disabled selected>Seleccionar</option>
                                                        <?php foreach ($Especialidades as $value) {?>
                                                        <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                                                        <?php }?>
                                                </select>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="mayus-bold">Médico Tratante</label>              
                                                <select name="ingreso_medico" id="divMedicos" class="form-control" data-value="<?=$Doc43051['ingreso_medico']?>" autocomplete="off" required>
                                                        <!-- Se llena las opciones de manera dinamica desde ajax y controlador -->
                                                        <option value='' disabled selected>Seleccionar</option>
                                                        <?php foreach ($Medico as $value) {?>
                                                        <option value="<?=$value['empleado_id']?>"><?=$value['empleado_nombre']?> <?=$value['empleado_apellidos']?></option>
                                                        <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="mayus-bold">MOTIVO DE INTERNAMIENTO</label>
                                                <select name="motivo_internamiento" data-value="<?=$Doc43051['motivo_internamiento']?>" class="form-control" required>
                                                    <option value="" ></option>
                                                    <option value="Tratamiento">Tratamiento</option>
                                                    <option value="Cirugía">Cirugía</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="mayus-bold">DIAGNOSTICO DE INGRESO:</label>
                                                <input class="form-control" name="diagnostico_presuntivo"  value="<?=$Diagnostico['cie10_nombre']?>" readonly>
                                                <input type="hidden" class="form-control" name="dx_id"  value="<?=$Diagnostico['cie10_id']?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                             <div class="form-group">
                                                <label class="mayus-bold">AREA</label>
                                                <select name="area" class="form-control area" data-value="<?=$Doc43051['area_id']?>">
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
                                                <select name="cama" class="form-control cama" data-value="<?=$Doc43051['cama_id']?>">
                                                    <!-- Se llena las opciones de manera dinamica desde ajax y controlador -->
                                                    <option value="" >Selecionar cama</option>
                                                    <?php foreach ($Cama as $value) {?>
                                                     <option value="<?=$value['cama_id']?>"><?=$value['cama_nombre']?> <?=$value['cama_estado']?></option>
                                                    <?php }?>  
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="mayus-bold">PACIENTE RIESGO CONTAGIOSO</label>
                                                <select name="riesgo_infeccion" data-value="<?=$Doc43051['riesgo_infeccion']?>" class="form-control" required>
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="No" >No</option>
                                                    <option value="Si" >Si</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        
                                        <div class="col-md-4">
                                            <div class="form-group" >
                                                <label style="text-transform: uppercase;font-weight: bold">Asistente Médica Registra</label>
                                                <input class="form-control" name="pic_am" required="" placeholder="" value="<?=$PINFO['pic_am']=='' ? $empleado[0]['empleado_nombre'].' '.$empleado[0]['empleado_apellidos'] : $PINFO['pic_am']?>" readonly> 
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
                            <div class="col-md-offset-8 col-md-2">
                                <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
                            </div>
                            <div class="col-md-2">
                                <input type="hidden" name="area_nombre" value="<?=$this->UMAE_AREA?>">
                                <input type="hidden" name="csrf_token" >
                                <input type="hidden" name="triage_id" value="<?=$this->uri->segment(4)?>"> 
                                <input type="hidden" name="triage_solicitud_rx" value="<?=$info[0]['triage_solicitud_rx']?>">
                                <input type="hidden" name="asistentesmedicas_id" value="<?=$solicitud[0]['asistentesmedicas_id']?>">
                                <button class="btn back-imss  btn-block " type="submit" >Guardar</button>                     
                            </div>
                            <br><br><br><br>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
<input type="hidden" name="ConfigHojaInicialAsistentes" value="<?=CONFIG_AM_HOJAINICIAL?>">
<input type="hidden" name="CONFIG_AM_INTERACCION_LT" value="<?=CONFIG_AM_INTERACCION_LT?>">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url()?>assets/libs/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js"></script>
<script src="<?= base_url('assets/js/Asistentemedica.js?'). md5(microtime())?>" type="text/javascript"></script> 
<script src="<?= base_url('assets/js/Asistentemedica_tr.js?'). md5(microtime())?>" type="text/javascript"></script>
