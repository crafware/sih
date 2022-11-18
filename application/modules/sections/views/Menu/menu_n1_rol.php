<?= modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner">
            <ol class="breadcrumb" style="margin-top: 0px">
                <li><a href="#">Inicio</a></li>
                <li><a href="<?=  base_url()?>Sections/Menu/Menus">Menu Nivel 1</a></li>
                <li><a href="#">Asignar area a menu</a></li>
            </ol>   
            <div class="col-md-12 col-centered" style="margin-top: -10px">
                <div class="panel panel-default">
                    <div class="panel-heading p teal-900 back-imss">
                        <span style="font-size: 15px;font-weight: 500">ASIGNAR AREA DE ACCESO A MENUS</span>
                        <a class="md-btn md-fab m-b red waves-effect btn-add-mn1-rol pull-right" data-id="<?=$_GET['m']?>">
                            <i class="mdi-av-queue i-24" ></i>
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
                        <table id="ver-tabla-cirugias" class="table table-bordered footable"  data-filter="#filter" data-page-size="15">
                            <thead>
                                <tr>
                                    <th>MENU</th>
                                    <th>URL</th>
                                    <th>ÁREA DE ACCESO</th>
                                    <th class="text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($Gestion as $value) {?>
                                <tr id="<?=$value['menuN1_id']?>" >
                                    <td><?=$value['menuN1_menu']?> </td>
                                    <td><?=$value['menuN1_url']?></td>
                                    <td><?=$value['areas_acceso_nombre']?></td>
                                    <td class="text-center">
                                        <i class="fa fa-trash-o del-mn1-rol icono-accion pointer" data-m="<?=$value['menuN1_id']?>" data-r="<?=$value['areas_acceso_id']?>"></i>
                                       
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