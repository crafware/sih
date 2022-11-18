<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding" style="margin-top: -20px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500"><b>VISOR DE CAMAS</b></span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row row-camas-visor">
                        
                    </div>
                </div>
                <input type="hidden" name="accion_rol" value="VisorCamas">
                <a href="" class="md-btn md-fab md-fab-bottom-right pos-fix teal actualizar-visor-camas-choque">
                    <i class="mdi-action-cached i-24"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Choquev2.js?'). md5(microtime())?>" type="text/javascript"></script>