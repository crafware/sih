<?= modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12 col-centered" style="margin-top: 10px">
            <div class="">
                <div class="panel panel-default">
                    <div class="panel-heading p teal-900 back-imss">
                        <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">GESTIÓN DE CAMAS & GENERACIÓN DE PASES</span>
                    </div>
                    <div class="panel-body b-b b-light">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group m-b">
                                    <span class="input-group-addon back-imss border-back-imss">
                                        <i class="fa fa-user-plus"></i>
                                    </span>
                                    <input type="text" id="filter" class="form-control" placeholder="Buscar Cama o Paciente...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped table-no-padding footable"  data-filter="#filter" data-page-size="15">
                                    <thead>
                                        <tr>
                                            <th>MODULO</th>
                                            <th>SERVICIO</th>
                                            <th>CAMA</th>
                                            <th>ESTADO</th>
                                            <th>N° DE FOLIO</th>
                                            <th>PACIENTE</th>
                                            <th class="text-center">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                        <tr id="<?=$value['cam_id']?>" >
                                            <td><?=$value['area_modulo']?></td>
                                            <td><?=$value['area_nombre']?> </td>
                                            <td><?=$value['cama_nombre']?></td>
                                            <td><?=$value['cama_status']?></td>
                                            <td >
                                                <?php 
                                                $sqlTriage=$this->config_mdl->sqlGetDataCondition('os_triage',array(
                                                    'triage_id'=>$value['cama_dh']
                                                ))[0];
                                                echo $sqlTriage['triage_id'];
                                                ?>
                                            </td>
                                            <td>
                                                <?=$sqlTriage['triage_nombre_ap'].' '.$sqlTriage['triage_nombre_am'].' '.$sqlTriage['triage_nombre']?>
                                            </td>
                                            <td class="text-center">
                                                <?php if($value['cama_status']=='Ocupado'){?>
                                                <a href="<?= base_url()?>AdmisionHospitalaria/PasesdeVisitasFamiliares?folio=<?=$sqlTriage['triage_id']?>&tipo=<?=$value['area_modulo']?>">
                                                    <i class="fa fa-credit-card icono-accion tip" data-original-title="Generar pase de visita"></i>
                                                </a>
                                                <?php }?>
                                            </td>
                                        </tr>
                                    <?php }?>
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
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/AdmisionHospitalaria.js?'). md5(microtime())?>" type="text/javascript"></script>