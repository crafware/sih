<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered"> 
            <ol class="breadcrumb">
                <li><a style="text-transform: uppercase" href="<?= base_url()?>Abasto/MinimaInvacion/CatalogoPrincipalConsumo">Mínima Invasión</a></li>
                <li><a style="text-transform: uppercase" href="<?= base_url()?>Abasto/MinimaInvacion/Categorias_Ins_Equi?name=<?= $_GET['name']?>"><?=$material['catalogo_titulo']?></a></li>
                <li><a style="text-transform: uppercase" href="#">Sistemas</a></li>
            </ol>  
            <div class="panel panel-default">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center!important">
                        <strong>SISTEMAS</strong><br>
                    </span>
                    <a href="<?=  base_url()?>Abasto/Catalogos/NuevoSistema?catalogo=<?=$_GET['catalogo']?>&sistema=0&accion=add" class="md-btn md-fab m-b green waves-effect pull-right tip " data-original-title="Nuevos Sistemas">
                        <i class="mdi-content-add i-24" ></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">  
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="input-group m-b">
                                    <span class="input-group-addon back-imss no-border">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <input type="text" name="sistema_id" class="form-control" placeholder="Buscar Sistema...">
                                </div>
                            </div>
                            <div class="col-md-12"><br>
                                <table class="table table-hover table-bordered footable" data-page-size="7" data-filter="#sistema_id" style="font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">CATALOGO</th>
                                            <th style="width: 20%">SISTEMA</th>
                                            <th style="width: 30%">DESCRIPCIÓN</th>
                                            <th style="width: 15%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($Gestion as $value) {?>
                                        <tr>
                                            <td><?=$value['catalogo_titulo']?></td>
                                            <td><?=$value['sistema_titulo']?></td>
                                            <td>
                                                <span class="tip pointer" data-original-title="<?=$value['sistema_descripcion']?>"><?= substr($value['sistema_descripcion'], 0,90)?>... </span>
                                            </td>
                                            <td>
                                                <i class="fa fa-image i-16 icono-accion view-image pointer" data-image="<?= base_url()?>assets/materiales/<?=$value['sistema_img']?>"></i>
                                                <a href="<?= base_url()?>Abasto/Catalogos/Elementos?name=<?= $_GET['name']?>&catalogo=<?=$value['catalogo_id']?>&sistema=<?=$value['sistema_id']?>">
                                                    <i class="fa fa-window-restore i-16 icono-accion tip" data-original-title="Agregar Elementos"></i>
                                                </a>
                                                <a href="<?=  base_url()?>Abasto/Catalogos/NuevoSistema?catalogo=<?=$value['catalogo_id']?>&sistema=<?=$value['sistema_id']?>&accion=edit">
                                                    <i class="fa fa-pencil i-16 icono-accion" ></i>
                                                </a>
                                                <?php if($value['sistema_status'] != 1) {?>
                                                <i class="fa fa-trash-o i-16 pointer icono-accion eliminar-insumos_tipo" data-tipo="Sistema" data-id="<?=$value['sistema_id']?>" data-id_dependencia="<?=$value['catalogo_id']?>" data-nombre="<?=$value['sistema_titulo']?>"></i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
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
<script src="<?= base_url('assets/js/AbsCatalogos.js?').md5(microtime())?>" type="text/javascript"></script>