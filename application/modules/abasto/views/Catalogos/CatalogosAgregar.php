<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-8 col-centered">
        <div class="box-inner padding">
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="paciente-sexo-mujer hide" style="background: pink;width: 100%;height: 10px"></div>
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">
                        <b>NUEVO CÁTALOGO</b>&nbsp;
                    </span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="card-body">
                        <form class="guardar-materiales">
                            <div class="row row-sm" style="margin-left: -40px">
                                <div class="col-sm-12">
                                    <div class="form-group" style="margin-top: -15px">
                                        <label><b>TÍTULO</b> </label>
                                        <input class="form-control" name="catalogo_titulo" required=""  value="<?=$info['catalogo_titulo']?>">   
                                    </div>
                                    <div class="form-group">
                                        <label><b>DESCRIPCIÓN</b></label>
                                        <textarea class="form-control" rows="3" name="catalogo_descripcion"><?=$info['catalogo_descripcion']?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <button class="md-btn md-raised m-b btn-fw back-imss waves-effect no-text-transform pull-right" type="button" onclick="location.href=base_url+'Abasto/Catalogos'" style="margin-bottom: -10px">Cancelar</button>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" name="csrf_token" >
                                    <input type="hidden" name="catalogo_id" value="<?=$_GET['catalogo']?>">
                                    <input type="hidden" name="accion" value="<?=$_GET['accion']?>">
                                    
                                    <button class="md-btn md-raised m-b btn-fw back-imss waves-effect no-text-transform pull-right" type="submit" style="margin-bottom: -10px">Guardar</button>                     
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
<script src="<?= base_url('assets/js/AbsCatalogos.js?').md5(microtime())?>" type="text/javascript"></script>