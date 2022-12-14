<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">INGRESO DE PACIENTES A QUIRÓFANO</span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <input type="text" class="form-control" name="triage_id" placeholder="Ingresar N° de Paciente">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered footable">
                                <tr>
                                    <th>N° Paciente</th>
                                    <th>Paciente</th>
                                    <th>Ingreso</th>
                                    <th>Quirófano</th>
                                    <th>Sala</th>
                                    <th>Acciones</th>
                                </tr>
                                <?php foreach ($Gestion as $value) { ?>
                                <tr>
                                    <td><?=$value['triage_id']?></td>
                                    <td><?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?></td>
                                    <td><?=$value['qp_f_entrada']?> <?=$value['qp_h_entrada']?></td>
                                    <td><?=$value['quirofano_nombre']?></td>
                                    <td><?=$value['sala_nombre']?></td>
                                    <td>
                                        <i class="fa fa-share-square-o icono-accion pointer alta-paciente" data-id="<?=$value['qp_id']?>"></i>
                                    </td>
                                </tr>
                                <?php }?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/areas/quirofanos.js')?>" type="text/javascript"></script>