<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-8 col-centered">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">Gestión de Quirófano</span>
                    <a href="#"   md-ink-ripple="" class="md-btn md-fab m-b green waves-effect pull-right add-quirofano">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group m-b ">
                                <span class="input-group-addon back-imss no-border" ><i class="fa fa-search"></i></span>
                                <input type="text" class="form-control" name="" placeholder="Buscar...">
                            </div>
                        </div>
                    </div>
                    
                </div>
                <table class="table m-b-none" ui-jp="footable" data-limit-navigation="7" data-filter="#filter" data-page-size="10">
                    <thead>
                        <tr>
                            <th data-sort-ignore="true">N°</th>
                            <th data-sort-ignore="true">Quirófano</th>
                            <th data-sort-ignore="true">Salas</th>
                            <th data-sort-ignore="true" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($Gestion as $value) {?>
                        
                        <tr id="<?=$value['quirofano_id']?>">
                            <td><?=$value['quirofano_id']?> </td>
                            <td><?=$value['quirofano_nombre']?> </td>
                            <td>
                                <?= Modules::run('areas/quirofano/TotalSalas',array('quirofano_id'=>$value['quirofano_id']))?> Salas
                            </td>
                            <td class="text-center">
                                <a href="<?=  base_url()?>areas/quirofano/GestionSalas/<?=$value['quirofano_id']?>" target="_blank">
                                    <i class="fa fa-bed tip icono-accion" data-original-title="Agregar Salas"></i>
                                </a>&nbsp;
                                <i class="fa fa-pencil icono-accion pointer edit-quirofano" data-id="<?=$value['quirofano_id']?>" data-quirofano="<?=$value['quirofano_nombre']?>"></i>&nbsp;
                                <i class="fa fa-trash-o icono-accion pointer del-quirofano" data-id="<?=$value['quirofano_id']?>"></i>
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/areas/quirofanos.js')?>" type="text/javascript"></script>