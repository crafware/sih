<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12">
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss text-center">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase;text-align: center">
                        <b><?=$_SESSION['UMAE_AREA']?></b>
                    </span>
                    <div style="position: relative;margin-top: 0px">
                        <a href="#" class="md-btn md-fab m-b red pull-right tip enf-obs-del-paciente" data-placement="bottom" data-original-title="" style="position: absolute;right: 110px;top: -40px">
                            <i class="fa fa-user-times i-24"></i>
                        </a>
                        <a href="#" class="md-btn md-fab m-b red pull-right tip actualizar-camas-observacion" data-placement="bottom" data-original-title="Actualizar vista de camas" style="position: absolute;right: 50px;top: -40px">
                            <i class="fa fa-refresh i-24"></i>
                        </a>
                        <a  href="#" class="md-btn md-fab m-b red pull-right tip" data-placement="bottom" data-original-title="Indicadores" style="top:-40px;right: -10px;position: absolute">
                            <i class="fa fa-bar-chart-o i-24"></i>
                        </a>
                    </div>
                    
                </div>
                <div class="panel-body b-b b-light">
                    <div class="" >
                        <div class="row">
                            <style> .cols-camas :nth-child(3n){clear: left!important;}.color-white{color: white!important}</style>
                            <div class="col-md-12" style="padding: 0px;margin-top: -5px">
                                <div class="result_camas"></div>
                                <h3 class="NO_HAY_CAMAS text-center hidden ">HO HAY CAMAS DISPONIBLES PARA ESTA AREA</h3>
                            </div>
                        </div>
                        <input type="hidden" name="observacion_alta">
                        <input type="hidden" name="accion_rol" value="Enfermeria">
                        <input type="hidden" name="triage_id" value="<?=$_GET['folio']?>">
                        <input type="hidden" name="acceso" value="<?=$_GET['acceso']?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Observacion.js?'). md5(microtime())?>" type="text/javascript"></script>