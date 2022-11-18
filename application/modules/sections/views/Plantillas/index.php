<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-8 col-centered">
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">Plantillas</span>
                    <a  href="" md-ink-ripple="" class="md-btn md-fab m-b green waves-effect pull-right add-plantilla">
                        <i class="mdi-content-add i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    
                    <div class="" >
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 0px">
                            <table class="table footable table-bordered table-hover" data-page-size="10">
                                <thead>
                                    <tr>
                                        <th >N°</th>
                                        <th >PLANTILLA</th>
                                        <th style="width: 20%">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($Gestion as $value) { $i++?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$value['plantilla_nombre']?></td>
                                        <td>
                                            <a href="<?=  base_url()?>Sections/Plantillas/Contenidos/<?=$value['plantilla_id']?>/?limit=<?=$value['plantilla_limit']?>" >
                                                <i class="fa fa-plus icono-accion tip" data-original-title="Agregar Contenido"></i>
                                            </a>&nbsp;
                                            <i class="fa fa-pencil icono-accion edit-plantilla pointer" data-id="<?=$value['plantilla_id']?>" data-nombre="<?=$value['plantilla_nombre']?>"></i>&nbsp;
                                            <i class="fa fa-trash-o icono-accion pointer eliminar-plantilla" data-id="<?=$value['plantilla_id']?>"></i>
                                            
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                                <tfoot class="hide-if-no-paging">
                                    <tr>
                                        <td colspan="5" class="text-center">
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
<script src="<?= base_url('assets/js/sections/Plantillas.js')?>" type="text/javascript"></script>