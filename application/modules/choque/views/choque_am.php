<?= modules::run('Sections/Menu/index'); ?> 
<style>input, select, textarea{ text-transform: uppercase!important;}</style>
<style>hr.style-eight {border: 0;border-top: 4px double #8c8c8c;text-align: center;}hr.style-eight:after {content: attr(data-titulo);display: inline-block;position: relative;top: -0.7em;font-size: 1.2em;padding: 0 0.20em;background: white;}</style>
<div class="box-row">
    <div class="box-cell">
        
        <div class="col-md-10 col-centered">
        <div class="box-inner padding">
            <div class="panel panel-default " style="margin-top: -10px">
                
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">
                        <div class="row">
                            <div class="col-md-6">
                                PACIENTE: <?=$info[0]['triage_nombre']?> <?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?>
                            </div>
                            <div class="col-md-6">
                                Destino: <?=$info[0]['triage_consultorio_nombre']?>
                            </div>
                        </div>
                        
                    </span>
                    
                </div>
                <div class="panel-body b-b b-light">
                    <div class="card-body">
                        <form class="solicitud-am-choque">
                            <div class="row" style="margin-left: -40px;margin-top: -20px">
                                
                                <div class="col-md-12">
                                    <div class="row" style="margin-bottom: -20px;">
                                        <div class="col-md-4" style="padding-right: 0px">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Hoja </label>
                                                <input class="md-input " name="asistentesmedicas_hoja" value="<?=$solicitud[0]['asistentesmedicas_hoja']?>">   
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Renglón </label>
                                                <input class="md-input " name="asistentesmedicas_renglon" value="<?=$solicitud[0]['asistentesmedicas_renglon']?>">   
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Nombre </label>
                                        <input class="md-input" name="triage_nombre" required="" placeholder="Ejemplo: Fuentes Cervantes Manuel Alejandro." value="<?=$info[0]['triage_nombre']?> <?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?>">   
                                    </div> 
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Fecha Nac</label>
                                        <input class="md-input dd-mm-yyyy" name="triage_fecha_nac" placeholder="06/10/2016" value="<?=$info[0]['triage_fecha_nac']?>">   
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Sexo</label>
                                        <select class="md-input" required="" name="triage_paciente_sexo" data-value="<?=$info[0]['triage_paciente_sexo']?>">
                                            <option value="">Seleccionar</option>
                                            <option value="HOMBRE">HOMBRE</option>
                                            <option value="MUJER">MUJER</option>
                                        </select>
                                    </div>   
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>N° Afiliación</label>
                                                <input class="md-input" name="triage_paciente_afiliacion" placeholder="" <?=$info[0]['triage_tipo_paciente']!='' ? 'readonly' : ''?> value="<?=$info[0]['triage_paciente_afiliacion']?>">   
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>U.M.F de Adscripción</label>
                                                <input class="md-input" name="triage_paciente_umf" placeholder="" value="<?=$info[0]['triage_paciente_umf']?>"> 
                                            </div>                
                                        </div>

                                        <div class="col-md-4">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Estado Civil</label>
                                                <select class="form-control width100 " name="triage_paciente_estadocivil" data-value="<?=$info[0]['triage_paciente_estadocivil']?>">
                                                    <option value="SOLTERO(A)">SOLTERO(A)</option>
                                                    <option value="COMPROMETIDO(A)">COMPROMETIDO(A)</option>
                                                    <option value="CASADO(A)">CASADO(A)</option>
                                                    <option value="DIVORSIADO(A)">DIVORSIADO(A)</option>
                                                    <option value="VIUDO(A)">VIUDO(A)</option>
                                                </select>
                                            </div>                   
                                        </div> 
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>C.U.R.P</label>
                                        <input class="md-input" name="triage_paciente_curp" placeholder="" value="<?=$info[0]['triage_paciente_curp']?>"> 
                                    </div>                   
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Telefono</label>
                                        <input class="md-input" name="triage_paciente_telefono" placeholder="" value="<?=$info[0]['triage_paciente_telefono']?>"> 
                                    </div>                   
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Identificación Oficial</label>
                                        <input class="md-input" name="triage_paciente_identificacion" placeholder="" value="<?=$info[0]['triage_paciente_identificacion']?>"> 
                                    </div>                   
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        
                                        <hr class="style-eight" data-titulo="Domicilio">
                                        <div class="col-md-4">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Código Postal</label>
                                                <input class="md-input" name="triage_paciente_dir_cp" placeholder="" value="<?=$info[0]['triage_paciente_dir_cp']?>"> 
                                            </div>                   
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Calle y Numero</label>
                                                <input class="md-input" name="triage_paciente_dir_calle" placeholder="" value="<?=$info[0]['triage_paciente_dir_calle']?>"> 
                                            </div>                   
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Colonia</label>
                                                <input class="md-input" name="triage_paciente_dir_colonia" placeholder="" value="<?=$info[0]['triage_paciente_dir_colonia']?>"> 
                                            </div>                   
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Municipio</label>
                                                <input class="md-input" name="triage_paciente_dir_municipio" placeholder="" value="<?=$info[0]['triage_paciente_dir_municipio']?>"> 
                                            </div>                   
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Estado</label>
                                                <input class="md-input" name="triage_paciente_dir_estado" placeholder="" value="<?=$info[0]['triage_paciente_dir_estado']?>"> 
                                            </div>                   
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Delegación IMSS</label>
                                                <input class="md-input" name="triage_paciente_delegacion" placeholder="" value="<?=$info[0]['triage_paciente_delegacion']?>"> 
                                            </div>                   
                                        </div>
                                        <div class="col-md-6">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>En Caso necesario llamar a:</label>
                                                <input class="md-input" name="triage_paciente_res" placeholder="" value="<?=$info[0]['triage_paciente_res']?>"> 
                                            </div>                   
                                        </div>
                                        <div class="col-md-6">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Teléfono:</label>
                                                <input class="md-input" name="triage_paciente_res_telefono" placeholder="" value="<?=$info[0]['triage_paciente_res_telefono']?>"> 
                                            </div>                   
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Médico Tratante</label>
                                                <input class="md-input" name="triage_paciente_medico_tratante" required="" placeholder="" value="<?=$info[0]['triage_paciente_medico_tratante']?>"> 
                                            </div>                   
                                        </div>
                                        <div class="col-md-6">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Asistente Médica</label>
                                                <input class="md-input" name="triage_paciente_asistente_medica" required="" placeholder="" value="<?=$info[0]['triage_paciente_asistente_medica']=='' ? $empleado[0]['empleado_nombre'].' '.$empleado[0]['empleado_apellidos'] : $info[0]['triage_paciente_asistente_medica']?>"> 
                                            </div>                   
                                        </div>
                                        <div class="col-md-6">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Lugar</label>
                                                <select class="md-input" name="triage_paciente_accidente_lugar" data-value="<?=$info[0]['triage_paciente_accidente_lugar']?>">
                                                    <option value="C. RECREATIVO">C. RECREATIVO</option>
                                                    <option value="ESCUELA">ESCUELA</option>
                                                    <option value="TRABAJO">TRABAJO</option>
                                                    <option value="HOGAR">HOGAR</option>
                                                    <option value="TRAYECTO">TRAYECTO</option>
                                                    <option value="VIA PUBLICA">VIA PUBLICA</option>
                                                    <option value="UNIDAD IMSS">UNIDAD IMSS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6" >
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Procedencia</label>
                                                <input type="text" class="md-input" name="triage_paciente_accidente_procedencia" value="<?=$info[0]['triage_paciente_accidente_procedencia']?>">
                                            </div>
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <hr class="style-eight" data-titulo="Trabajo">
                                </div>
                                <div class="col-md-4 lugar_trabajo hide">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Empresa</label>
                                        <input class="md-input" name="triage_paciente_res_empresa" placeholder="" value="<?=$info[0]['triage_paciente_res_empresa']?>"> 
                                    </div>  
                                </div>
                                <div class="col-md-4 lugar_trabajo hide">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Registro Patronal</label>
                                        <input class="md-input" name="triage_paciente_accidente_rp" placeholder="" value="<?=$info[0]['triage_paciente_accidente_rp']?>"> 
                                    </div>
                                </div>
                                
                                <div class="col-md-4 lugar_trabajo hide">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Telefono (Lada)</label>
                                        <input class="md-input" name="triage_paciente_accidente_telefono" placeholder="" value="<?=$info[0]['triage_paciente_accidente_telefono']?>"> 
                                    </div>
                                </div>
                                
                                <div class="col-md-4 lugar_trabajo hide">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Código Postal</label>
                                        <input class="md-input" name="triage_paciente_accidente_cp" placeholder="" value="<?=$info[0]['triage_paciente_accidente_cp']?>"> 
                                    </div>
                                </div>
                                <div class="col-md-4 lugar_trabajo hide">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Calle y Numero</label>
                                        <input class="md-input" name="triage_paciente_accidente_calle" placeholder="" value="<?=$info[0]['triage_paciente_accidente_calle']?>"> 
                                    </div>
                                </div>
                                <div class="col-md-4 lugar_trabajo hide">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Colonia</label>
                                        <input class="md-input" name="triage_paciente_accidente_colonia" placeholder="" value="<?=$info[0]['triage_paciente_accidente_colonia']?>"> 
                                    </div>
                                </div>
                                <div class="col-md-4 lugar_trabajo hide">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Municipio</label>
                                        <input class="md-input" name="triage_paciente_accidente_municipio" placeholder="" value="<?=$info[0]['triage_paciente_accidente_municipio']?>"> 
                                    </div>
                                </div>
                                <div class="col-md-4 lugar_trabajo hide">
                                    <div class="md-form-group" style="margin-top: -20px">
                                        <label>Estado</label>
                                        <input class="md-input" name="triage_paciente_accidente_estado" placeholder="" value="<?=$info[0]['triage_paciente_accidente_estado']?>"> 
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 lugar_trabajo hide">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Horario de Trabajo Entrada/Salida</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input class="md-input clockpicker" name="triage_paciente_accidente_t_hora" placeholder="Entrada" value="<?=$info[0]['triage_paciente_accidente_t_hora']?>"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="md-input clockpicker" name="triage_paciente_accidente_t_hora_s" placeholder="Salida" value="<?=$info[0]['triage_paciente_accidente_t_hora_s']?>"> 
                                                    </div>
                                                </div>
                                                
                                            </div> 
                                        </div>
                                        <div class="col-md-3">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Accidente: Fecha</label>
                                                <input class="md-input d-m-y" name="triage_paciente_accidente_fecha" placeholder="10/02/2016" value="<?=$info[0]['triage_paciente_accidente_fecha']?>"> 
                                            </div> 
                                        </div>
                                        <div class="col-md-3">
                                            <div class="md-form-group" style="margin-top: -20px">
                                                <label>Accidente Hora</label>
                                                <input class="md-input clockpicker" name="triage_paciente_accidente_hora" placeholder="12:00" value="<?=$info[0]['triage_paciente_accidente_hora']?>"> 
                                            </div>
                                        </div>    
                                    </div>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Cuenta con hoja de referencia y ContraReferencia.</label>&nbsp;&nbsp;&nbsp;
                                        <label class="md-check">
                                            <input type="radio" name="rc_cuenta_con_hoja" value="Si" data-value="<?=$hoja_rc[0]['rc_cuenta_con_hoja']?>" class="has-value">
                                            <i class="blue"></i>Si
                                        </label>&nbsp;&nbsp;&nbsp;
                                        <label class="md-check">
                                            <input type="radio" name="rc_cuenta_con_hoja" checked="" value="No" data-value="<?=$hoja_rc[0]['rc_cuenta_con_hoja']?>" class="has-value">
                                            <i class="blue"></i>No
                                        </label>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12 col-referencia-contrareferencia hide">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tipo de referencia</label>
                                                <select class="md-input" name="rc_tipo_referencia" data-value="<?=$hoja_rc[0]['rc_tipo_referencia']?>">
                                                    <option value="Ordinario">Ordinario</option>
                                                    <option value="Urgente">Urgente</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Unidad a la que se envía</label>
                                                <input type="text" name="rc_unidad_que_se_envia" value="<?=$hoja_rc[0]['rc_unidad_que_se_envia']?>" class="md-input">
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha de solicitud:</label>
                                                <input type="text" name="rc_fecha_solicitud" value="<?=$hoja_rc['rc_fecha_solicitud']?>" class="md-input dd-mm-yyyy">
                                            </div>
                                            <div class="form-group">
                                                <label>Delegación a la unidad a la que se envía</label>
                                                <input type="text" name="rc_delegacion_unidad_que_se_envia" value="<?=$hoja_rc[0]['rc_delegacion_unidad_que_se_envia']?>" class="md-input">
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Envío a la especialidad de:</label>
                                                <input type="text" name="rc_envio_especialidad" value="<?=$hoja_rc[0]['rc_envio_especialidad']?>" class="md-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Unidad que envía</label>
                                                <select class="select2 width100" name="unidadmedica_id" data-value="<?=$hoja_rc[0]['unidadmedica_id']?>">
                                                    <option value="">Seleccionar Unidad</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Delegación unidad que envía</label>
                                                <input type="text" name="rc_delegacion_unidad_que_envia" value="<?=$hoja_rc[0]['rc_delegacion_unidad_que_envia']?>" class="md-input">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Diagnostico (s) de envío</label>
                                                <textarea class="md-input" name="rc_diagnosticos" rows="1" style="margin-top: 10px;"><?=$hoja_rc[0]['rc_diagnosticos']?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Motivo de envío.</label>
                                                <select class="md-input" name="rc_motivo_envio" data-value="<?=$hoja_rc[0]['rc_motivo_envio']?>">
                                                    <option value="Falta de respuesta favorable al tratamiento.">Falta de respuesta favorable al tratamiento.</option>
                                                    <option value="Presencia de complicaciones.">Presencia de complicaciones.</option>
                                                    <option value="Requiere de estudios auxiliares de diagnósticos especiales.">Requiere de estudios auxiliares de diagnósticos especiales.</option>
                                                    <option value="Riego de secuela.">Riego de secuela.</option>
                                                    <option value="Complementación diagnostica.">Complementación diagnostica.</option>
                                                    <option value="Tratamiento especializado.">Tratamiento especializado.</option>
                                                    <option value="Protección anticonceptiva.">Protección anticonceptiva.</option>
                                                    <option value="Método anticonceptivo">Método anticonceptivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cuenta con incapacidad inicial.</label><br>
                                                <div style="margin-top: 7px">
                                                    <label class="md-check">
                                                        <input type="radio" name="rc_incapacidad" value="Si" data-value="<?=$hoja_rc[0]['rc_incapacidad']?>" class="has-value">
                                                        <i class="blue"></i>Si
                                                    </label>&nbsp;&nbsp;&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="rc_incapacidad" value="No" checked="" data-value="<?=$hoja_rc[0]['rc_incapacidad']?>" class="has-value">
                                                        <i class="blue"></i>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-incapacidad-inicial hide">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>N° Folio</label>
                                                <input type="text" name="rc_incapacidad_folio" value="<?=$hoja_rc[0]['rc_incapacidad_folio']?>" class="md-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Ramo de Seguro</label>
                                                <select name="rc_incapacidad_ramo_seguro" data-value="<?=$hoja_rc[0]['rc_incapacidad_ramo_seguro']?>" class="md-input">
                                                    <option value="Enfermedad General">Enfermedad General</option>
                                                    <option value="Riesgo de trabajo">Riesgo de trabajo</option>
                                                    <option value="Maternidad">Maternidad)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Días</label>
                                                <input type="text" name="rc_incapacidad_dias" value="<?=$hoja_rc[0]['rc_incapacidad_dias']?>" class="md-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Tipo de Incapacidad</label>
                                                <select name="rc_incapacidad_tipo" data-value="<?=$hoja_rc[0]['rc_incapacidad_tipo']?>" class="md-input">
                                                    <option value="Inicial">Inicial</option>
                                                    <option value="Subsecuente">Subsecuente</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha de Inicio</label>
                                                <input type="text" name="rc_incapacidad_fecha_inicio" value="<?=$hoja_rc[0]['rc_incapacidad_fecha_inicio']?>" class="md-input dd-mm-yyyy">
                                            </div>
                                            <div class="form-group">
                                                <label>Número de días acumulados</label>
                                                <input type="hidden" name="rc_incapacidad_dias_acomulados" value="<?=$hoja_rc[0]['rc_incapacidad_dias_acomulados']?>" class="md-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="url_tipo" value="Am">
                                    <input type="hidden" name="csrf_token" >
                                    <input type="hidden" name="triage_id" value="<?=$this->uri->segment(3)?>"> 
                                    <input type="hidden" name="triage_solicitud_rx" value="<?=$info[0]['triage_solicitud_rx']?>">
                                    <input type="hidden" name="asistentesmedicas_id" value="<?=$solicitud[0]['asistentesmedicas_id']?>">
                                    <button class="md-btn md-raised m-b btn-fw back-imss  waves-effect no-text-transform pull-right" type="submit" style="margin-bottom: -10px">Guardar y Continuar</button>                     
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Asistentemedica.js?'). md5(microtime())?>" type="text/javascript"></script> 
<script src="<?= base_url('assets/js/Choque.js?'). md5(microtime())?>" type="text/javascript"></script>
