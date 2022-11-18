<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-10 col-centered" style="margin-top: -20px">
        <div class="box-inner padding">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">AREAS DE ACCESO</span>
                    <a md-ink-ripple="" class="md-btn btn-add md-fab m-b green waves-effect pull-right">
                    <i class="fa fa-plus"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group m-b ">
                                <span class="input-group-addon back-imss no-border" ><i class="fa fa-search"></i></span>
                                <input type="text" class="form-control" id="filter" placeholder="Buscar...">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table footable table-bordered" data-filter="#filter" data-page-size="6">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>ÁREA DE ACCESO</th>
                                        <th>ROL PERTENECIENTE</th>
                                        <th>ESTATUS</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php foreach ($Gestion as $value) {?>
                                    <tr id="<?=$value['areas_acceso_id']?>">
                                        <td><?=$value['areas_acceso_id']?></td>
                                        <td><?=$value['areas_acceso_nombre']?></td>
                                        <td><?=$value['rol_nombre']?></td>
                                        <td>
                                            <?php if($value['areas_acceso_status']=='hidden'){?>
                                            No Disponible
                                            <?php }else{?>
                                            Disponible
                                            <?php }?>
                                        </td>
                                        <td>
                                            <?php if($value['areas_acceso_status']=='hidden'){?>
                                            <i class="fa fa-check icono-accion pointer tip available-not-available-access" data-id="<?=$value['areas_acceso_id']?>" data-accion="" data-original-title="Mostrar esta área de acceso"></i>&nbsp;
                                            <?php }else{?>
                                            <i class="fa fa-times icono-accion pointer tip available-not-available-access" data-id="<?=$value['areas_acceso_id']?>" data-accion="hidden" data-original-title="Ocultar esta área de acceso"></i>&nbsp;
                                            <?php }?>
                                            <i data-id="<?=$value['areas_acceso_id']?>"  data-original-title="Modificar" class="tip fa fa-pencil pointer icono-accion"></i>&nbsp&nbsp
                                            <i data-id="<?=$value['areas_acceso_id']?>" data-original-title="Eliminar" class="tip fa fa-trash-o pointer icono-accion"></i>
                                        </td>
                                    </tr>
                                    <?php } ?>
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
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/Areasacceso.js?'). md5(microtime())?>" type="text/javascript"></script>