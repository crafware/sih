<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <ul class="breadcrumb">
            <li><a >Inicio</a></li>
            <li><a href="#" >Quirófanos</a></li>
            <li><a href="#" ><?=$info['quirofano_nombre']?></a></li>
            <li><a href="#">Gestión de Salas</a></li>
        </ul>
        <div class="box-inner padding col-md-10 col-centered" style="margin-top: 20px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">Gestión de Salas del :<b><?=$info['quirofano_nombre']?></b></span>
                    <a href="#"  md-ink-ripple="" class="md-btn md-fab m-b green waves-effect pull-right add-salas-quirofano" data-quirofano="<?=$this->uri->segment(4)?>">
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
                            <th data-sort-ignore="true">Cama</th>
                            <th data-sort-ignore="true" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($Gestion as $value) {?>
                        
                        <tr id="<?=$value['sala_id']?>">
                            <td><?=$value['sala_id']?></td>
                            <td><?=$value['sala_nombre']?> </td>
                            <td class="text-center">
                                <i class="fa fa-pencil icono-accion pointer edit-sala" data-id="<?=$value['sala_id']?>" data-sala="<?=$value['sala_nombre']?>" data-quirofano="<?=$value['quirofano_id']?>"></i>&nbsp;
                                <i class="fa fa-trash-o icono-accion pointer del-sala" data-id="<?=$value['sala_id']?>"></i>
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