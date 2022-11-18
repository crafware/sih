<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered"> 
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center!important">
                        <strong>ENFERMERÍA CHOQUE</strong><br>
                    </span>
                    <a href="<?=  base_url()?>Choque/Choquev2/EnfermeriaCamas" md-ink-ripple="" class="md-btn md-fab m-b green waves-effect pull-right tip " data-original-title="Gestión y Asignación de Camas">
                        <i class="fa fa-bed i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">                    
                    <div class="row" style="margin-top: 0px">
                        <div class="col-md-6">
                            <div class="input-group m-b">
                                <span class="input-group-addon back-imss no-border">
                                    <i class="fa fa-search-plus"></i>
                                </span>
                                <input type="text" id="filter_medico_choque" class="form-control" placeholder="Buscar paciente...">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-hover table-bordered footable" data-page-size="10" data-filter="#filter_medico_choque" style="font-size: 13px">
                                <thead>
                                    <tr>
                                        <th>FOLIO</th>
                                        <th>TIPO PAC.</th>
                                        <th>NOMBRE/PSEUDONIMO</th>
                                        <th>N.S.S</th>
                                        <th>INGRESO</th>
                                        <th>CAMA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                    <tr>
                                        <td><?=$value['triage_id']?></td>
                                        <td ><?=$value['triage_tipo_paciente']?></td>
                                        <td><?=$value['triage_nombre']=='' ? $value['triage_nombre_pseudonimo'] : $value['triage_nombre'].' '.$value['triage_nombre_ap'].' '.$value['triage_nombre_am']?> </td>
                                        <td> 
                                            <?php 
                                                $sqlInfo=$this->config_mdl->_get_data_condition('paciente_info',array(
                                                    'triage_id'=>$value['triage_id']
                                                ))[0];
                                            ?>
                                            <?=$sqlInfo['pum_nss_armado']!='' ? '<b style="color:#F44336">ARMADO:</b> '.$sqlInfo['pum_nss_armado'].'<br>': ''?>
                                            <?=$sqlInfo['pum_nss']!='' ? '<b>NSS:</b> '.$sqlInfo['pum_nss'].' '.$sqlInfo['pum_nss_agregado']: ''?>
                                        </td>
                                        <td><?=$value['triage_horacero_f']?> <?=$value['triage_horacero_h']?></td>
                                        <td>
                                            <?php if($value['cama_id']==''){?>
                                            <!-- <a href="<?= base_url()?>Choque/Choquev2/EnfermeriaCamas?folio=<?=$value['triage_id']?>" >
                                                <i class="fa fa-bed icono-accion tip" data-original-title="Asignar Cama"></i>
                                            </a> -->
                                            <a href="<?= base_url()?>Observacion?folio=<?=$value['triage_id']?>&acceso=Choque" >
                                                <i class="fa fa-bed icono-accion tip" data-original-title="Asignar Cama"></i>
                                            </a>
                                            <i class="fa fa-share-square-o icono-accion tip pointer alta-paciente-choque-ne" data-original-title="Alta paciente por motivo no especificado" data-id="<?=$value['triage_id']?>"></i>
                                            <?php }else{?>
                                            <a href="<?= base_url()?>Choque/Choquev2/EnfermeriaCamas?folio=<?=$value['triage_id']?>">
                                                <?= Modules::run('Choque/Choquev2/InformacionCama',array('cama_id'=>$value['cama_id']))?>
                                            </a>
                                            <?php }?>
                                            
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