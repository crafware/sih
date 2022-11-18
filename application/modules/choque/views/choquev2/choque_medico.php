<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered"> 
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center!important">
                        <strong>MÉDICO CHOQUE</strong><br>
                    </span>
                    
                </div>
                <div class="panel-body b-b b-light">                    
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group m-b">
                                <span class="input-group-addon back-imss no-border">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" id="filter_medico_choque" class="form-control" placeholder="Buscar...">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-hover table-bordered footable" data-page-size="10" data-filter="#filter_medico_choque" style="font-size: 13px">
                                <thead>
                                    <tr>
                                        <th>FOLIO</th>
                                        <th>PACIENTE</th>
                                        <th style="width: 20%">NOMBRE / PSEUDONIMO</th>
                                        <th>N.S.S</th>
                                        <th>SEXO</th>
                                        <th>F. H. DE INGRESO</th>
                                        <th style="width:13%">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                    <tr>
                                        <td ><?=$value['triage_id']?></td>
                                        <td ><?=$value['triage_tipo_paciente']?></td>
                                        <td ><?=$value['triage_nombre']=='' ? $value['triage_nombre_pseudonimo'] : $value['triage_nombre_ap'].' '.$value['triage_nombre_am'].' '.$value['triage_nombre']?> </td>
                                        <td>
                                            <?php 
                                                $sqlInfo=$this->config_mdl->_get_data_condition('paciente_info',array(
                                                    'triage_id'=>$value['triage_id']
                                                ))[0];
                                            ?>
                                            <?=$sqlInfo['pum_nss_armado']!='' ? '<b style="color:#F44336">ARMADO:</b> '.$sqlInfo['pum_nss_armado'].'<br>': ''?>
                                            <?=$sqlInfo['pum_nss']!='' ? '<b>NSS:</b> '.$sqlInfo['pum_nss'].' '.$sqlInfo['pum_nss_agregado']: ''?>
                                        </td>
                                        <td><?=$value['triage_paciente_sexo']?></td>
                                        <td><?=date('d/m/Y', strtotime($value['triage_horacero_f'])); ?>

                                             <?=$value['triage_horacero_h']?></td>
                                        <td>
                                            <i class="fa hide fa-heartbeat icono-accion pointer posible-donador tip" data-id="<?=$value['triage_id']?>" data-donador="<?=$value['po_donador']?>" data-criterio="<?=$value['po_criterio']?>" data-original-title="Reportar Como Posible Donador"></i>&nbsp;
                                            <a href="<?=  base_url()?>Sections/Documentos/Expediente/<?=$value['triage_id']?>/?tipo=Choque" target="_blank" class="paciente_choque" data-triageid="<?= $value['triage_id']?>">
                                                <i class="fa fa-pencil-square-o icono-accion tip" data-original-title="Requisitar Información"></i>
                                            </a>&nbsp;
                                            <a href="<?=  base_url()?>Sections/Documentos/TratamientoQuirurgico/<?=$value['triage_id']?>" target="_blank">
                                                <i class="fa fa-medkit icono-accion tip" data-original-title="Requiere tratamiento quirúrgico"></i>
                                            </a>
                                            <?php //}?>
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Choquev2.js?').md5(microtime())?>" type="text/javascript"></script>