<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered"> 
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center!important">
                        <strong>CURSOS</strong><br>
                    </span>
                    <a href="<?=  base_url()?>Educacion/AgregarCurso/0/?a=add" md-ink-ripple="" class="md-btn md-fab m-b green waves-effect pull-right tip " data-original-title="Gestión y Asignación de Camas">
                        <i class="fa fa-plus i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group m-b">
                                <span class="input-group-addon back-imss no-border">
                                    <i class="fa fa-pencil-square-o"></i>
                                </span>
                                <input type="text" id="curso_id" class="form-control" placeholder="Buscar Curso">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-hover table-bordered footable" data-page-size="10" data-filter="#curso_id" style="font-size: 13px">
                                <thead>
                                    <tr>
                                        <th>CURSO</th>
                                        <th style="width: 30%">DESCRIPCIÓN</th>
                                        <th style="width: 16%">CREADO</th>
                                        <th style="width: 16%">USUARIOS</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                    <tr>
                                        <td><?=$value['curso_nombre']?></td>
                                        <td><?= substr($value['curso_descripcion'], 0,90)?>... </td>
                                        <td><?=$value['curso_fecha']?> <?=$value['curso_hora']?></td>
                                        <td>
                                            <?= Modules::run('Educacion/TotalUsuarios',array('curso_id'=>$value['curso_id']))?> Usuarios
                                        </td>
                                        <td>
                                            <a href="<?= base_url()?>Educacion/CursoUsuario/<?=$value['curso_id']?>">
                                                <i class="fa fa-users tip icono-accion" data-original-title="Agregar usuarios al curso"></i>
                                            </a>&nbsp;
                                            <a href="<?= base_url()?>Educacion/AgregarCurso/<?=$value['curso_id']?>/?a=edit">
                                                <i class="fa fa-pencil icono-accion"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Educacion.js?').md5(microtime())?>" type="text/javascript"></script>