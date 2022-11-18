<?= modules::run('Sections/Menu/index'); ?> 

    
        <div class="box-inner col-md-9 col-centered" style="margin-top: 80px">   
            <div class="panel panel-default" >
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">
                        <b>CONFIGURACIÓN HORA CERO, ENFERMERIA & MÉDICO TRIAGE</b>
                    </span>
                    
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mayus-bold text-left">CONFIGURACIÓN HORA CERO & TRIAGE ENFERMERIA</h4>
                        </div>
                        <div class="col-md-6">
                            <label class="md-check mayus-bold">
                                <input type="radio" class="save-config-um" name="ConfigEnfermeriaHC" data-id="1" value="No" data-value="<?=$this->ConfigEnfermeriaHC?>">
                                <i class="blue"></i>Enfermería Triage
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="md-check mayus-bold">
                                <input type="radio" class="save-config-um" name="ConfigEnfermeriaHC" data-id="1" value="Si" checked="" >
                                <i class="blue"></i>Enfermería Triage & HC
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br><h4 class="mayus-bold text-left">CONFIGURACIÓN TRIAGE ENFERMERIA</h4>
                        </div>
                        <div class="col-md-6">
                            <label class="md-check mayus-bold">
                                <input type="radio" class="save-config-um" name="ConfigSolicitarOD" data-id="2" value="Si" data-value="<?=$this->ConfigSolicitarOD?>">
                                <i class="blue"></i>Solicitar Oximetría & Dextrostix
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="md-check mayus-bold">
                                <input type="radio" class="save-config-um" name="ConfigSolicitarOD" data-id="2" value="No" checked="" >
                                <i class="blue"></i>No Solicitar Oximetría & Dextrostix
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br><h4 class="mayus-bold text-left">CONFIGURACIÓN TRIAGE MÉDICO</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold">
                                    <input type="radio" class="save-config-um" name="ConfigDestinosMT" data-id="3" value="Si" checked="" data-value="<?=$this->ConfigDestinosMT?>">
                                    <i class="blue"></i>Habilitar Destinos Triage Médico
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold">
                                    <input type="radio" class="save-config-um" name="ConfigDestinosMT" data-id="3" value="No" >
                                    <i class="blue"></i>No Habilitar Destinos Triage Médico
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold">
                                    <input type="radio" class="save-config-um" name="ConfigDestinosOAC" data-id="4" checked="" value="Si" data-value="<?=$this->ConfigDestinosOAC?>">
                                    <i class="blue"></i>Habilitar Destino Ortopedia-Admisión Continua
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold destino">
                                    <input type="radio" class="save-config-um" name="ConfigDestinosOAC" data-id="4" value="No" >
                                    <i class="blue"></i>No Habilitar Destino Ortopedia-Admisión Continua
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold destino">
                                    <input type="radio" class="save-config-um" name="ConfigExcepcionCMT" data-id="5" data-value="<?=$this->ConfigExcepcionCMT?>" value="Si" >
                                    <i class="blue"></i>Habilitar Excepcion Hoja Clasificación
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold destino">
                                    <input type="radio" class="save-config-um" name="ConfigExcepcionCMT" data-id="5" value="No" >
                                    <i class="blue"></i>No Habilitar Excepcion Hoja Clasificación
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold destino">
                                    <input type="radio" class="save-config-um" name="ConfigExcepcionRMTR" data-id="13" data-value="<?=$this->ConfigExcepcionRMTR?>" value="Si" >
                                    <i class="blue"></i>Habilitar Registro de Pacientes com Medico en TRIAGE RESPIRATORIO
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold destino">
                                    <input type="radio" class="save-config-um" name="ConfigExcepcionRMTR" data-id="13" value="No" >
                                    <i class="blue"></i>Cancelar Registro de Pacientes con Medico en TRIAGE RESPIRATORIO
                                </label>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>   
        </div>
  
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/Configuracion.js?'). md5(microtime())?>" type="text/javascript"></script>