<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-11 col-centered">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">Asignación de Salas</span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group m-b ">
                                <span class="input-group-addon back-imss no-border" ><i class="fa fa-search"></i></span>
                                <input type="text" class="form-control" name="triage_id_jq" placeholder="Ingresar N° de Paciente">
                            </div>
                        </div>
                    </div>
                    
                </div>
                <table class="table m-b-none" ui-jp="footable" data-limit-navigation="7" data-filter="#filter" data-page-size="10">
                    <thead>
                        <tr>
                            <th data-sort-ignore="true">N° Paciente</th>
                            <th data-sort-ignore="true">Paciente</th>
                            <th data-sort-ignore="true">Quirófano</th>
                            <th data-sort-ignore="true">Sala</th>
                            <th data-sort-ignore="true">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($Gestion as $value) {?>
                        
                        <tr id="<?=$value['triage_id']?>">
                            <td><?=$value['triage_id']?> </td>
                            <td><?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?> </td>
                            <td><?=$value['quirofano_nombre']?> </td>
                            <td><?=$value['sala_nombre']?> </td>
                            <td><?=$value['qp_status']?> </td>
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/areas/quirofanos.js')?>" type="text/javascript"></script>