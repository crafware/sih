<?= modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding">
            <div class="col-md-8 col-centered">
                <div class="panel panel-default">
                    <div class="panel-heading p teal-900 back-imss">
                        <span style="font-size: 15px;font-weight: 500">Gestión de Roles</span>
                        <a class="md-btn md-fab m-b green waves-effect acciones-roles pull-right" data-id="0" data-accion="Agregar" data-rol="">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                    <div class="panel-body b-b b-light">
                        <table class="table table-bordered footable" data-filter="#filter" data-page-size="10">
                            <thead>
                                <tr>
                                    <th>Numero</th>
                                    <th>Rol</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($Gestion as $value) {?>
                                
                                <tr id="<?=$value['rol_id']?>" >
                                    <td><?=$value['rol_id']?> </td>
                                    <td><?=$value['rol_nombre']?></td>
                                    <td class="text-center ">
                                        <i class="fa fa-pencil icono-accion pointer acciones-roles" data-id="<?=$value['rol_id']?>" data-accion="Editar" data-rol="<?=$value['rol_nombre']?>"></i> &nbsp;
                                        <i class="fa fa-trash-o icono-accion pointer acciones-roles" style="opacity: 0.4" data-id="<?=$value['rol_id']?>" data-accion="Eliminar" data-rol=""></i>
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                            <tfoot class="hide-if-no-paging">
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <ul class="pagination"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Roles.js?'). md5(microtime())?>" type="text/javascript"></script>