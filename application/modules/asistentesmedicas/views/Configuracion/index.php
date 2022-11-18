<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-9 col-centered" style="margin-top: 10px">   
            <div class="panel panel-default" >
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">
                        <b>CONFIGURACIÓN ASISTENTES MÉDICAS</b>
                    </span>
                    
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold destino">
                                    <input type="radio" class="save-config-um" name="CONFIG_AM_HOJAINICIAL" data-id="9" data-value="<?=CONFIG_AM_HOJAINICIAL?>" value="Si" >
                                    <i class="blue"></i>Imprimir Hoja Inicial (AM)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold destino">
                                    <input type="radio" class="save-config-um" name="CONFIG_AM_HOJAINICIAL" data-id="9" value="No" >
                                    <i class="blue"></i>NO Imprimir Hoja Inicial (AM)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold destino">
                                    <input type="radio" class="save-config-um" name="CONFIG_AM_INTERACCION_LT" data-id="12" value="Si" >
                                    <i class="blue"></i>Habilitar Interaccón Lugar Trabajo
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="md-check mayus-bold destino">
                                    <input type="radio" class="save-config-um" name="CONFIG_AM_INTERACCION_LT" data-id="12" data-value="<?=CONFIG_AM_INTERACCION_LT?>" value="No" >
                                    <i class="blue"></i>Inhabilitar Interaccón Lugar Trabajo
                                </label>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>   
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/Configuracion.js?'). md5(microtime())?>" type="text/javascript"></script>