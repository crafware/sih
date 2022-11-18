<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered"> 
            <ol class="breadcrumb">
                <li><a style="text-transform: uppercase" href="<?= base_url()?>Abasto/MinimaInvacion/CatalogoPrincipalConsumo">Mínima Invasión</a></li>
                <li><a style="text-transform: uppercase" href="<?= base_url()?>Abasto/MinimaInvacion/Categorias_Ins_Equi?name=<?= $_GET['name']?>"><?=$material['catalogo_titulo']?></a></li>
                <li><a style="text-transform: uppercase" href="<?= base_url()?>Abasto/Catalogos/Sistemas?catalogo=<?=$_GET['catalogo']?>"><?=$sistema['sistema_titulo']?></a></li>
                <li><a style="text-transform: uppercase" href="<?= base_url()?>Abasto/Catalogos/Elementos?catalogo=<?=$_GET['catalogo']?>&sistema=<?=$_GET['sistema']?>"><?= substr($elemento['elemento_titulo'], 0,15)?>...</a></li>
                <li><a style="text-transform: uppercase" href="#">RANGOS</a></li>
            </ol>
            <div class="panel panel-default">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center!important">
                        <strong>RANGOS</strong>
                    </span>
                    <a href="<?=  base_url()?>Abasto/Catalogos/NuevoRango?catalogo=<?=$_GET['catalogo']?>&sistema=<?=$_GET['sistema']?>&elemento=<?=$_GET['elemento']?>&rango=0&accion=add" class="md-btn md-fab m-b green waves-effect pull-right tip " data-original-title="Nuevo Rango">
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
                                    <input type="text" name="elemento_id" class="form-control" placeholder="Buscar Elemento">
                                </div>
                            </div>
                            <div class="col-md-12"><br>
                                <table class="table table-hover table-bordered footable" data-page-size="7" data-filter="#elemento_id" style="font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th>CÁTALOGO</th>
                                            <th>SISTEMA</th>
                                            <th>ELEMENTO</th>
                                            <th>RANGO</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th style="width: 20%;">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($Gestion as $value) {?>
                                        <tr>
                                            <td><?=$value['catalogo_titulo']?></td>
                                            <td><?=$value['sistema_titulo']?></td>
                                            <td><?=$value['elemento_titulo']?></td>
                                            <td><?=$value['rango_titulo']?></td>
                                            <td><?=$value['rango_descripcion']?></td>
                                            <td>
                                                <i class="fa fa-image icono-accion i-16 view-image pointer" data-image="<?= base_url()?>assets/materiales/<?=$value['rango_img']?>"></i>&nbsp;
                                                <a href="<?=  base_url()?>Abasto/Catalogos/NuevoRango?catalogo=<?=$_GET['catalogo']?>&sistema=<?=$_GET['sistema']?>&elemento=<?=$_GET['elemento']?>&rango=<?=$value['rango_id']?>&accion=edit">
                                                    &nbsp;<i class="fa fa-pencil i-16 icono-accion" ></i>
                                                </a>&nbsp;
                                                <?php if($value['rangos_status'] != 1) {?>
                                                <i class="fa fa-trash-o pointer i-16 icono-accion eliminar-insumos_tipo" data-tipo="Rango" data-id="<?=$value['rango_id']?>" data-id_dependencia="<?=$_GET['elemento']?>" data-nombre="<?=$value['rango_titulo']?>"></i>
                                                <?php } ?>
                                                &nbsp;<a href="<?=base_url()?>Abasto/MinimaInvacion/RangosInventario?rango_id=<?= $value['rango_id']?>&name=<?= $_GET['name']?>&catalogo=<?= $_GET['catalogo']?>&sistema=<?= $_GET['sistema']?>&elemento=<?= $_GET['elemento']?>" target="_blank" title="Cantidad">
                                                <i class="fa fa-plus-square i-16 icono-accion"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <tfoot class="hide-if-no-paging">
                                        <tr>
                                            <td colspan="6" id="footerCeldas" class="text-center">
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
<script src="<?= base_url('assets/js/AbsCatalogos.js?').md5(microtime())?>" type="text/javascript"></script>