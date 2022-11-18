<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-10 col-centered">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">Solicitud de Estudios Radiograficos</span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group m-b ">
                                <span class="input-group-addon back-imss no-border" ><i class="fa fa-search"></i></span>
                                <input type="text" class="form-control" name="buscar_paciente_rx" placeholder="Buscar...">
                            </div>
                        </div>
                        
                    </div>
                </div>
                <table class="table m-b-none" ui-jp="footable" data-limit-navigation="7" data-filter="#filter" data-page-size="10">
                    <thead>
                        <tr>
                            <th data-sort-ignore="true">Folio</th>
                            <th data-sort-ignore="true">Nombre</th>
                            <th data-sort-ignore="true">Ingreso</th>
                            <th data-sort-ignore="true" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($Gestion as $value) {?>
                        <?php 
                        if($value['triage_color']=='Rojo'){
                            $color='red';
                        }if($value['triage_color']=='Naranja'){
                            $color='orange';
                        }if($value['triage_color']=='Amarillo'){
                            $color='amber';
                        }if($value['triage_color']=='Verde'){
                            $color='green';
                        }if($value['triage_color']=='Azul'){
                            $color='indigo';
                        }
                        ?>
                        <tr id="<?=$value['triage_id']?>">
                            <td><?=$value['triage_id']?></td>
                            <td class="<?=$color?>" style="color: white;"><?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?></td>
                            <td><?=$value['rx_fecha_entrada']?> <?=$value['rx_hora_entrada']?></td>
                            <td class="text-center">
                                <a href="<?=  base_url()?>inicio/documentos/SolicitudRX/<?=$value['triage_id']?>" target="_blank">
                                    <i class="fa fa-file-pdf-o tip icono-accion" data-original-title="Generar Solicitud RX"></i>
                                </a>&nbsp;
                                <?php if($value['rs_status']!='Salida'){?>
                                <i class="fa fa-sign-out icono-accion tip acceso-area-rx-paciente pointer" data-id="<?=$value['triage_id']?>" data-original-title="Salida"></i>
                                <?php }?>
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/os/rx/rx.js')?>" type="text/javascript"></script>