<?= modules::run('Sections/Menu/HeaderBasico'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-8 col-centered">
    
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">Nuevo Contendio</span>
                </div>
                <div class="panel-body b-b b-light">
                    
                    <div class="" >
                    <div class="row">
                        <div class="col-md-12">
                            <form  class="guardar-contenido">
                                <div class="form-group">
                                    <textarea rows="10" class="form-control" name="contenido_datos"><?=$info['contenido_datos']?></textarea>
                                </div>
                                <input type="hidden" name="contenido_id" value="<?=$_GET['con']?>">
                                <input type="hidden" name="plantilla_id" value="<?=$_GET['plantilla']?>">
                                <input type="hidden" name="accion" value="<?=$_GET['a']?>">
                                <input type="hidden" name="csrf_token">
                                <button class="btn btn-primary">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url('assets/js/sections/Plantillas.js?').md5(microtime())?>" type="text/javascript"></script>