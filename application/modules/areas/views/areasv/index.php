<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-10 col-centered" style="margin-top: 10px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">GESTIÓN DE ÁREAS OBSERVACIÓN , PISOS, CHOQUE</span>
                    <a href="#" md-ink-ripple="" class="md-btn md-fab m-b red waves-effect pull-right" onclick="AbrirVista(base_url+'Areas/AgregarArea?area=0&accion=add',400,400)">
                        <i class="mdi-av-my-library-add i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered footable table-striped table-no-padding" data-limit-navigation="7" data-filter="#filter" data-page-size="5">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>ÁREA</th>
                                        <th>MODULO</th>
                                        <th>CAMAS</th>
                                        <th class="text-center">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>

                                    <tr id="<?=$value['area_id']?>">
                                        <td><?=$value['area_id']?></td>
                                        <td><?=$value['area_nombre']?></td>
                                        <td><?=$value['area_modulo']?> </td>
                                        <td>
                                            <?php if($value['area_camas']=='Si'){?>
                                            <?= Modules::run('areas/TotalCama',array('area_id'=>$value['area_id']))?> Camas
                                            <?php }else{?>
                                            No Aplica
                                            <?php }?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?=  base_url()?>areas/GestionCamas/<?=$value['area_id']?>">
                                                <i class="fa fa-bed tip icono-accion" data-original-title="Agregar Camas"></i>
                                            </a>&nbsp;
                                            <i class="fa fa-pencil icono-accion pointer" onclick="AbrirVista(base_url+'Areas/AgregarArea?area=<?=$value['area_id']?>&accion=edit',400,400)"></i>&nbsp;
                                            <i class="fa fa-trash-o icono-accion pointer del-area" data-id="<?=$value['area_id']?>"></i>
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
<script src="<?= base_url('assets/js/areas/areas.js?').md5(microtime())?>" type="text/javascript"></script>