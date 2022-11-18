<?= modules::run('Sections/Menu/HeaderBasico'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-8 col-centered" style="margin-top: 10px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">AGREGAR CONSULTORIO</span>
                </div>
                <div class="panel-body b-b b-light">
                    <form class="form-guardar-especialidad-cons">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="text" name="consultorio_nombre" value="<?=$info['consultorio_nombre']?>" required="" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="mayus-bold">ES DE ESPECIALIDAD:</label>&nbsp;&nbsp;&nbsp;
                                    <label class="md-check">
                                        <input type="radio" name="consultorio_especialidad" value="Si" data-value="<?=$info['consultorio_especialidad']?>">
                                        <i class="blue"></i>Si
                                    </label>&nbsp;&nbsp;&nbsp;
                                    <label class="md-check">
                                        <input type="radio" name="consultorio_especialidad" value="No" checked="">
                                        <i class="blue"></i>No
                                    </label>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="accion" value="<?=$_GET['accion']?>">
                                    <input type="hidden" name="especialidad_id" value="<?=$_GET['es']?>">
                                    <input type="hidden" name="consultorio_id" value="<?=$_GET['cons']?>"> 
                                    <input type="hidden" name="csrf_token">
                                    <button class="btn back-imss btn-block">Guardar</button>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url('assets/js/sections/Especialidades.js?'). md5(microtime())?>" type="text/javascript"></script>