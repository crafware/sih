<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered">
            <ol class="breadcrumb" style="margin-top: -30px;color:#2196F3">
                <li><a href="<?= base_url()?>Educacion/Cursos">Cursos</a></li>
                <li><a href="#">Cursos Usuarios</a></li>
            </ol> 
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center!important">
                        <strong>AGREGAR USUARIOS AL CURSO</strong><br>
                    </span>
                </div>
                <div class="panel-body b-b b-light">                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group m-b">
                                <span class="input-group-addon back-imss no-border">
                                    <i class="fa fa-pencil-square-o"></i>
                                </span>
                                <input type="text" name="empleado_matricula" data-curso="<?=$this->uri->segment(3)?>" class="form-control" placeholder="Ingresar Matricula">
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-add-usuario waves-effect btn-primary" type="button">Agregar usuario</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-hover table-bordered footable" data-page-size="10" data-filter="#curso_id" style="font-size: 13px">
                                <thead>
                                    <tr>
                                        <th>CURSO</th>
                                        <th>FECHA Y HORA AGREGADO</th>
                                        <th>USUARIO</th>
                                        <th>MATRICULA</th>
                                        <th class="text-center">ACCIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                    <tr>
                                        <td><?=$value['curso_nombre']?></td>
                                        <td><?=$value['cu_fecha']?> <?=$value['cu_hora']?></td>
                                        <td><?=$value['empleado_nombre']?> <?=$value['empleado_apellidos']?></td>
                                        <td><?=$value['empleado_matricula']?></td>
                                        <td class="text-center">
                                            <i class="fa fa-trash-o icono-accion pointer tip elimiar-user-curso" data-id="<?=$value['cu_id']?>" data-original-title="Eliminar usaurio de este curso"></i>
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