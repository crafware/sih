<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-8 col-centered"> 
            <ol class="breadcrumb" style="margin-top: -30px;color:#2196F3">
                <li><a href="#">Inicio</a></li>
                <li><a href="<?= base_url()?>Educacion/Curso">Cursos</a></li>
                <li><a href="#">Nuevo Curso</a></li>
            </ol> 
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center!important">
                        <strong>AGREGAR NUEVO CURSOS</strong><br>
                    </span>
                </div>
                <div class="panel-body b-b b-light">                    
                    <div class="row">
                        <div class="col-md-12">
                            <form class="agregar-curso">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>NOMBRE DEL CURSO</label>
                                            <input type="text" name="curso_nombre" class="form-control" value="<?=$info['curso_nombre']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>DESCRIPCIÓN DEL CURSO</label>
                                            <textarea class="form-control" rows="5" name="curso_descripcion"><?=$info['curso_descripcion']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="csrf_token">
                                            <input type="hidden" name="curso_id" value="<?=$this->uri->segment(3)?>">
                                            <input type="hidden" name="accion" value="<?=$_GET['a']?>">
                                            <button class="btn btn-primary pull-right">Guardar</button>
                                        </div>
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
<script src="<?= base_url('assets/js/Educacion.js?').md5(microtime())?>" type="text/javascript"></script>