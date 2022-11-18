<?= modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding">
            <div class="col-md-12 col-centered">
                <div class="panel panel-default">
                    <div class="panel-heading p teal-900 back-imss">
                        <span style="font-size: 15px;font-weight: 500">Menu Nivel 2</span>
                        <a class="md-btn md-fab m-b green waves-effect btn-add-mn2 pull-right" data-id="<?=$_GET['m']?>">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                    <div class="panel-body b-b b-light">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group m-b ">
                                    <span class="input-group-addon back-imss no-border" ><i class="fa fa-search"></i></span>
                                    <input type="text" class="form-control " id="filter" placeholder="Buscar...">
                                </div>
                            </div>
                        </div>
                        <table  class="table table-bordered footable table-no-padding"  data-filter="#filter" data-page-size="15">
                            <thead>
                                <tr>
                                    <th>Menu Nivel 1</th>
                                    <th>Menu Nivel 2</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($Gestion as $value) {?>
                                <?php 
                                if($value['menuN2_c_m']=='0'){
                                    $mn2_accion='disabled';
                                }else{
                                    $mn2_accion='';
                                }
                                
                                ?>
                                <tr id="<?=$value['menuN2_id']?>" >
                                    <td><?=$value['menuN1_menu']?> </td>
                                    <td><?=$value['menuN2_menu']?></td>
                                    <td class="text-center ">
                                        <a href="<?=  base_url()?>Sections/Menu/menuN3?m=<?=$value['menuN2_id']?>">
                                            <button <?=$mn2_accion?> class="btn btn-xs green waves-effect color-white">Menu N3</button>
                                        </a>
                                        <button  class="btn btn-xs blue waves-effect color-white btn-edit-mn2" data-id="<?=$value['menuN2_id']?>">Editar</button>
                                        <button class="btn btn-xs red waves-effect color-white btn-delete-mn2" data-id="<?=$value['menuN2_id']?>">Eliminar</button>
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
<script src="<?= base_url('assets/js/Menus.js?'). md5(microtime())?>" type="text/javascript"></script>