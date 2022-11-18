<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-9 col-centered" style="margin-top: 10px">   
            <div class="panel panel-default" >
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">
                        <b>CONFIGURACIÓN ENFERMERÍA OBSERVACIÓN OBSERVACIÓN</b>
                    </span>
                    
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-6" >
                            <div class="form-group">
                                <label class="md-check mayus-bold">
                                    <input type="radio" name="CONFIG_ENFERMERIA_OBSERVACION" data-id="11" value="Si" class="has-value save-config-um" data-value="<?=CONFIG_ENFERMERIA_OBSERVACION?>">
                                    <i class="blue"></i>ENFEMERÍA OBSERVACIÓN
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6" >
                            <div class="form-group">
                                <label class="md-check mayus-bold">
                                    <input type="radio" name="CONFIG_ENFERMERIA_OBSERVACION" data-id="11" value="No" class="has-value save-config-um">
                                    <i class="blue"></i>ENFEMERÍA OBSERVACIÓN POR TIPO
                                </label>
                            </div>
                        </div>
                        <?php if(CONFIG_ENFERMERIA_OBSERVACION=='No'){?>
                        <div class="col-md-12">
                            <h5 style="line-height: 1.5">ENFEMERÍA OBSERVACIÓN POR TIPO: ENFERMERIA OBSERVACIÓN ADULTOS HOMBRES, ADULTOS MUJERES Y PEDIATRIA</h5>
                        </div>
                        <?php }?>
                    </div>
                </div> 
            </div>   
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/Configuracion.js?'). md5(microtime())?>" type="text/javascript"></script>