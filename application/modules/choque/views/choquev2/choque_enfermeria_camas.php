<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12">
            <ol class="breadcrumb" style="margin-top: -30px;color:#2196F3">
                <li><a href="#">Inicio</a></li>
                <li><a href="<?= base_url()?>Choque/Choquev2/Enfermeria">Enfermería</a></li>
                <li><a href="#">Gestión y Asignación de Camas</a></li>
            </ol>   
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss text-center">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase;text-align: center"><b><?=$_SESSION['UMAE_AREA']?></b></span>                  
                </div>         
                <div class="panel-body b-b b-light">
                    <div class="" >
                        <div class="row">
                            <style> .cols-camas :nth-child(3n){clear: left!important;}.color-white{color: white!important}</style>
                            <div class="col-md-12" style="padding: 0px;">
                                <div class="result_camas"></div>
                                <h3 class="NO_HAY_CAMAS text-center hidden">NO HAY CAMAS DISPONIBLES PARA ESTA AREA</h3>
                            </div>
                        </div>
                        <input type="hidden" name="accion_rol" value="Choque">
                        <input type="hidden" name="triage_id" value="<?=$_GET['folio']?>">
                        <input type="hidden" name="choque_alta">
                    </div>
                </div>
                <a href="" class="md-btn md-fab md-fab-bottom-right pos-fix teal actualizar-camas-choque" data-triage="<?=$this->uri->segment(3)?>">
                    <i class="mdi-action-cached i-24"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Choquev2.js?'). md5(microtime())?>" type="text/javascript"></script>