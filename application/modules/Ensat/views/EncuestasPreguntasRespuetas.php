<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12 col-centered" style="margin-top: 10px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">GESTIÓN RESPUESTAS</span>
                    <a href="#" md-ink-ripple="" class="md-btn md-fab m-b red waves-effect pull-right ensat-enc-preg-res-add-edit" data-id="0" data-icon="" data-respuesta="" data-pregunta="<?=$_GET['pregunta']?>" data-accion="add">
                        <i class="mdi-av-my-library-add i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered footable table-striped table-no-padding" data-limit-navigation="7" data-filter="#filter" data-page-size="5">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">N</th>
                                        <th style="width: 30%">PREGUNTA</th>
                                        <th style="width: 30%">RESPUESTA</th>
                                        <th>ICONO</th>
                                        <th class="text-center">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>

                                    <tr id="<?=$value['respuesta_id']?>">
                                        <td><?=$value['respuesta_id']?></td>
                                        <td><?=$value['pregunta_nombre']?></td>
                                        <td><?=$value['respuesta_nombre']?></td>
                                        <td>
                                            <?php if($value['respuesta_icon']!=''){?>
                                            <img src="<?= base_url()?>assets/img/emoji/<?=$value['respuesta_icon']?>" style="width: 10%">
                                            <?php }?>
                                        </td>
                                        <td class="text-center">
                                            <i class="fa fa-pencil icono-accion pointer ensat-enc-preg-res-add-edit" data-id="<?=$value['respuesta_id']?>" data-respuesta="<?=$value['respuesta_nombre']?>" data-icon="<?=$value['respuesta_icon']?>" data-pregunta="<?=$_GET['pregunta']?>" data-accion="edit"></i>&nbsp;
                                            <i class="fa fa-trash-o icono-accion pointer ensat-enc-preg-res-del" data-id="<?=$value['respuesta_id']?>"></i>
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Ensat.js?').md5(microtime())?>" type="text/javascript"></script>