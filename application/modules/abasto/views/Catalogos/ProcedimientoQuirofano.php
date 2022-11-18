<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-12 col-centered">
            <div class="box-inner padding">
                <div class="panel panel-default " style="margin-top: -20px">
                    <div class="paciente-sexo-mujer hide" style="background: pink;width: 100%;height: 10px"></div>
                    <div class="panel-heading p teal-900 back-imss">
                        <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">
                            <b>VALES DE SERVICIO</b>&nbsp;
                        </span>
                        <a href="<?=  base_url()?>Abasto/MinimaInvacion/ValeServicio?accion=add" target="_blank" class="md-btn md-fab m-b green waves-effect pull-right tip " data-original-title="Nuevo Procedimiento">
                        <i class="mdi-content-add i-24"></i>
                    </a>
                </div>
                    <div class="panel-body b-b b-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss no-border" ><i class="fa fa-search"></i></span>
                                        <input type="text" class="form-control" id="buscar" name="procedimiento" placeholder="BUSCAR PROCEDIMIENTO">
                                    </div>
                                </div>
                                <div class="col-md-12"><br>
                                    <table class="table table-hover table-bordered footable table-filtros" data-page-size="7" data-filter="#buscar" style="font-size: 13px">
                                        <thead>
                                            <tr>
                                                <th>VALE</th>
                                                <th>PACIENTE</th>
                                                <th>NO. SALA</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($PROCEDIMIENTOS AS $value) { ?>
                                            <tr>
                                                <td><?=$value['procedimiento_nombre']?></td>
                                                <td><?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?> <?=$value['triage_nombre']?></td>
                                                <td><?=$value['vale_no_sala']?></td>
                                                <td style="width:10%">
                                                    &nbsp;<a href="<?=base_url()?>Abasto/MinimaInvacion/ValeServicio?vale_servicio_id=<?=$value['vale_id']?>&accion=edit&paciente=<?=$value['triage_id']?>&matricula_medica=<?=$value['matricula_medica']?>&procedimiento_codigo=<?= $value['procedimiento_codigo']?>&servicio=<?= $value['servicio_id']?>" target="_blank">
                                                        <i class="fa fa-pencil i-16 editar pointer icono-accion" title="Editar"></i>
                                                    </a>
                                                    &nbsp;<i class="fa fa-trash i-16 eliminar-Proced_Contr pointer icono-accion" data-nombre="<?=$value['procedimiento_nombre']?>" data-id="<?=$value['procedimiento_id']?>" data-tipo="vale" title="Eliminar"></i>
                                                </td>
                                           </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot class="hide-if-no-paging">
                                            <tr>
                                                <td colspan="4" id="footerCeldas" class="text-center">
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
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/AbsCatalogos.js?').md5(microtime())?>" type="text/javascript"></script>

