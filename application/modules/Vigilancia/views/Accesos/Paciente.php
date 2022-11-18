<?= modules::run('Sections/Menu/HeaderBasico'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-sm-7 col-centered" style="margin-top: 10px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss text-center">
                    <span style="font-size: 20px;font-weight: 500;text-transform: uppercase">
                        <b><?=_UM_CLASIFICACION?> | <?=_UM_NOMBRE?></b><br>
                        <h5 style="margin-bottom: 0px;margin-top: -2px"><?=_UM_TIPO?></h5>
                    </span>
                    <a class="md-btn md-fab m-b red pull-left tip" href="<?= base_url()?>Vigilancia/Accesos" data-original-title="Regresar" data-placement="left" style="position: absolute;left: 0px;top: 15px">
                        <i class="mdi-navigation-arrow-back i-24" ></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row" style="text-transform: uppercase!important">
                        <div class="col-sm-12">
                            <?php $Paciente=$this->uri->segment(3);?>
                            <h3 style="margin-top: -5px"><b>PACIENTE:</b> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?></h3>
                            <?php 
                            $sqlCama=$this->config_mdl->_query("SELECT * FROM os_camas, os_areas WHERE os_camas.area_id=os_areas.area_id AND
                                                            os_camas.cama_dh=".$Paciente)[0];
                            if($_GET['tipo']=='Pisos'){
                                $Pisos= $this->config_mdl->_query("SELECT * FROM os_areas_pacientes , os_camas, os_pisos, os_pisos_camas, os_areas WHERE
                                                                    os_areas.area_id=os_camas.area_id AND
                                                                    os_areas_pacientes.cama_id=os_camas.cama_id AND
                                                                    os_pisos.piso_id=os_pisos_camas.piso_id AND
                                                                    os_pisos_camas.cama_id=os_camas.cama_id AND
                                                                    os_areas_pacientes.triage_id=".$Paciente)[0];
                            ?>
                            <h4 style="margin-top: 20px"><b><i class="fa fa-hospital-o icono-accion"></i> PISO:</b> <?=$Pisos['piso_nombre']?></h4>
                            <?php }?>
                            <h4 style="line-height: 1.6">
                                <b><i class="fa fa-bed icono-accion"></i> CAMA:</b> <?=$sqlCama['cama_nombre']?>
                            </h4>
                            <h4 style="line-height: 1.6">
                                <b><i class="fa fa-window-restore icono-accion"></i> SERVICIO:</b> <?=$sqlCama['area_nombre']?>
                            </h4>
                            <h4 style="line-height: 1.6">
                                <b><i class="fa fa-clock-o"></i> HORARIO DE VISITA:</b> <?=$sqlCama['area_horario_visita']?>
                            </h4>                            
                        </div>
                    </div>
                </div>
                <div class="panel-heading p teal-900 back-imss text-center" style="padding: 4px;margin-top: -10px">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">
                        <b>FAMILIARES CON PASE A VISITA</b><br>
                    </span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <tbody>
                                    <?php foreach ($Familiares as $value) {?>
                                    <tr>
                                        <td style="padding: 0px;">
                                            <?php if($value['familiar_perfil']!=''){?>
                                            <img src="<?= base_url()?>assets/img/familiares/<?=$value['familiar_perfil']?>?<?=md5(microtime())?>" class="view-img pointer" onclick="ViewImage($(this).attr('src'),'small')" style="width: 80px">
                                            <?php }else{?>
                                            <?php }?>
                                        </td>
                                        <td><?=$value['familiar_nombre']?> <?=$value['familiar_nombre_ap']?> <?=$value['familiar_nombre_am']?></td>
                                        <td><?=$value['familiar_parentesco']?></td>
                                        <td>
                                            <i class="mdi-social-person-add fa-3x text-color-imss pointer"></i>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="red " style="padding: 5px">
                    <h5 class="text-center">EL PACIENTE ACTUALMENTE TIENE UN VISITA</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url('assets/js/Vigilancia.js?').md5(microtime())?>" type="text/javascript"></script>