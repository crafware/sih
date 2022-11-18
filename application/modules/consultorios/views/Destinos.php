<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-8 col-centered" style="margin-top: -20px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss" >
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">DESTINOS</span>
                    <a href="#" md-ink-ripple="" class="md-btn md-fab m-b green waves-effect pull-right btn-add-dest" >
                        <i class="mdi-content-add i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row ">
                        <div class="col-md-6">
                            <div class="input-group m-b ">
                                <span class="input-group-addon back-imss no-border" >
                                    <i class="fa fa-search-plus"></i>
                                </span>
                                <input type="text" class="form-control" id="filter" placeholder="Buscar...">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover footable" data-filter="#filter" data-limit-navigation="7"data-page-size="10">
                                <thead>
                                    <tr>
                                        <th>Destino</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                    <tr>
                                        <td><?=$value['destino_nombre']?></td>
                                        <td>
                                            <i class="fa fa-trash-o icono-accion destino-eliminar" data-id="<?=$value['destino_id']?>"></i>
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
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url()?>assets/js/Consultorios.js?time=<?= md5(microtime())?>"></script>