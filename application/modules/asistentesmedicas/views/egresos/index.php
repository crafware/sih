<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">EGRESOS DE PACIENTES DE LA UNIDAD MÉDICA</span>
                    
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <input type="text" class="form-control" id="triage_id_egreso_am" placeholder="Ingresar N° de Paciente">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 15%">Folio</th>
                                        <th style="width: 25%">Paciente</th>
                                        <th style="width: 15%">Area de Envío</th>
                                        <th>Diagnóstico de Ingreso</th>
                                        <th>Alta</th> 
                                        <th style="width: 17%">Fecha Egreso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value):?>
                                    <tr>
                                        <td><?=$value['triage_id']?></td>
                                        <td><?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?></td>
                                        <td><?=$value['egreso_area']?></td>
                                        <td style="font-size: 9px">
                                            <?= Modules::run('inicio/documentos/HojaFrontalPacientes',array(
                                                'triage_id'=>$value['triage_id']
                                            ))?>
                                        </td>
                                        <td><?=$value['egreso_motivo']?></td>
                                        <td>
                                            <?=$value['egreso_fecha']?> <?=$value['egreso_hora']?>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Asistentemedica.js?'). md5(microtime())?>" type="text/javascript"></script>