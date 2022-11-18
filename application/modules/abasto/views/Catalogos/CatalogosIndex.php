<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered"> 
            <ol class="breadcrumb">
                <li><a style="text-transform: uppercase" href="<?= base_url()?>Abasto/MinimaInvacion/CatalogoPrincipalConsumo">Mínima Invasión</a></li>
                <li><a style="text-transform: uppercase" href="#">Categoría</a></li>
            </ol>
            <div class="card back-imss">
                <div class="lt p text-center">
                    <h3 style="margin-top: 0px;margin-bottom: 0px">
                        CATEGOR&Iacute;AS
                    </h3>
                </div>
            </div>
            <a href="<?=  base_url()?>Abasto/Catalogos/NuevoCatalogo?catalogo=0&accion=add" class="md-btn md-fab m-b green waves-effect pull-right tip " data-original-title="Nuevo Catalogo">
                <i class="mdi-content-add i-24" ></i>
            </a>
            <?php foreach ($Gestion as $value) {?>
                <div class="col-md-3">
                    <div class="card">
                        <ul class="nav nav-sm navbar-tool pull-right">
                            <li class="dropdown">
                                <a md-ink-ripple data-toggle="dropdown">
                                    <i class="mdi-navigation-more-vert i-24"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-scale pull-up pull-bottom pull-right text-color">
                                    <?php if($value['catalogo_status'] != 1) {?>
                                    <li class="eliminar-insumos_tipo" data-tipo="Catalogo" data-id="<?= $value['catalogo_id']?>" data-nombre="<?=$value['catalogo_titulo']?>">
                                        <a href="#">
                                            <i class="fa fa-trash-o i-16"></i>&nbsp;&nbsp;Eliminar
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li class="editar-categoria">
                                        <a href="<?=  base_url()?>Abasto/Catalogos/NuevoCatalogo?catalogo=<?= $value['catalogo_id']?>&accion=edit">
                                            <i class="fa fa-edit i-16"></i>&nbsp;&nbsp;Editar
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <a href="<?= base_url()?>Abasto/Catalogos/Sistemas?name=insumos&catalogo=<?=$value['catalogo_id']?>&categoria_id=<?= $value['categoria_id']?>&categoria=<?= $value['catalogo_titulo']?>&catalogo=<?= $value['catalogo_id']?>">
                            <div class="lt p text-center" title="<?= $value['catalogo_descripcion']?>">
                                <h4><?=$value['catalogo_titulo']?></h4>
                                <p><?= substr($value['catalogo_descripcion'], 0,90)?>... </p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/AbsCatalogos.js?').md5(microtime())?>" type="text/javascript"></script>