<style type="text/css">
.divBordeIzq {
    border-bottom-color: Black;
    border-bottom-style: solid;
    border-bottom-width: 3px;
    border-left-color: Black;
    border-left-style: solid;
    border-left-width: 3px;
    }
</style>
<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12">
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss text-center" >
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase;text-align: center">
                        <b><?=$_SESSION['UMAE_AREA']?></b>
                    </span>
                    <div style="position: relative;margin-top: 0px">
                        <a href="#" class="md-btn md-fab m-b red eliminar-paciente-pisos pull-right tip " data-placement="bottom"  style="margin-top: -40px;right: 110px;position: absolute">
                            <i class="fa fa-user-times i-24"></i>
                        </a>
                        <a href="#" class="md-btn md-fab m-b red actualizar-camas-pisos pull-right tip " data-placement="bottom" data-original-title="Actualizar vista de camas" style="margin-top: -40px;right: 50px;position: absolute">
                            <i class="fa fa-refresh i-24"></i>
                        </a>
                        <a href="#" onclick="AbrirVista(base_url+'Pisos/Enfermeria/Indicador')" class="md-btn md-fab m-b red pull-right tip" data-placement="bottom" data-original-title="Reporte de Estados de Camas" style="margin-top: -40px;right: -10px;;position: absolute">
                            <i class="fa fa-cloud-download i-24"></i>
                        </a>    
                    </div>
                    
                </div>
                <div class="panel-body b-b b-light">       
                        <div class="row">
                            <style> .cols-camas :nth-child(3n){clear: left!important;}.color-white{color: white!important}</style>
                            <div class="col-md-12" style="margin-top: 10px">
                                <div class="result_camas row"></div>
                                <h3 class="NO_HAY_CAMAS text-center hidden">HO HAY CAMAS DISPONIBLES PARA ESTA AREA</h3>
                            </div>
                        </div>
                        <input type="hidden" name="accion_rol" value="Choque">
                        <input type="hidden" name="triage_id" value="<?=$_GET['folio']?>">
                        <input type="hidden" name="ap_alta">
                        <input type="hidden" name="RealizarAjax" value="Si">              
                </div>
            </div>
        </div>
    </div>
</div>
<input name="Area" value="<?= $this->UMAE_AREA?>">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/PisosAsistMed.js?').md5(microtime())?>" type="text/javascript"></script>