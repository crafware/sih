<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12 col-centered">
            <div class="panel panel-default " style="margin-top: 10px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">Procedimiento para la clasificación de pacientes con problemas respiratorios</span>
                    <a href="<?=  base_url()?>Triage/Indicador" class="md-btn md-fab m-b red pull-right tip " data-original-title="Indicadores" target="_blank">
                        <i class="fa fa-bar-chart i-24" ></i>
                    </a>
                    <?php if($this->ConfigExcepcionRMTR=='Si'){?>
                    <a href="#" class="md-btn md-fab m-b green waves-effect pull-right btn-horacero-medico" style="width: 60px;height: 60px; font-size: 35px;margin-right: 20px" target="_blank">
                        <i class="mdi-social-person-add"></i>
                    </a>
                    <?php }?>
                </div>
                <div class="panel-body b-b b-light">
                    
                    <div class="row" style="margin-top: 0px">
                        <div class="col-md-6">
                            <div class="input-group m-b">
                                <span class="input-group-addon back-imss border-back-imss">
                                    <i class="fa fa-user-plus"></i>
                                </span>
                                <input type="text" id="input_search" class="form-control" placeholder="Ingresar N° de Folio">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table footable table-filtros table-bordered table-hover table-no-padding"  data-limit-navigation="7" data-filter="#filter" data-page-size="10">
                                <thead>
                                    <tr>
                                        <th>N° DE FOLIO</th>
                                        <th style="width: 25%">NOMBRE DEL PACIENTE</th>
                                        <th>HORA CERO</th>
                                        <th>HORA ENFERMERÍA</th>
                                        <th>HORA CLASIFICACIÓN</th>
                                        <th colspan="2">T.T</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_filas=  count($Gestion);
                                    $total_minutos=0;
                                    ?>
                                    <?php foreach ($Gestion as $value) {?>
                                    <tr id="<?=$value['triage_id']?>">
                                        <td><?=$value['triage_id']?></td>
                                        <td class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$value['triage_color']))?>" style="color: white">
                                            <?php if($value['triage_nombre']== '') { ?>
                                                        <?=$value['triage_nombre_pseudonimo']?>
                                                        <span style="color:white; text-align: right; ">(En espera de actualización de datos)</span>
                                                <?php }else {?>
                                                       <?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>    
                                                <?php }?>
                                                   
                                        </td>
                                        <td><?=$value['triage_horacero_f']?> <?=$value['triage_horacero_h']?></td>
                                        <td><?=$value['triage_fecha']?> <?=$value['triage_hora']?></td>
                                        <td><?=$value['triage_fecha_clasifica']?> <?=$value['triage_hora_clasifica']?></td>
                                        
                                        <td>
                                            <?= Modules::run('Config/TiempoTranscurrido',array(
                                                'Tiempo1_fecha'=>$value['triage_horacero_f'],
                                                'Tiempo1_hora'=>$value['triage_horacero_h'],
                                                'Tiempo2_fecha'=>$value['triage_fecha_clasifica'],
                                                'Tiempo2_hora'=>$value['triage_hora_clasifica'],
                                            ))?> Min
                                        </td>
                                        <td>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'inicio/Documentos/Clasificacion/<?=$value['triage_id']?>')" data-original-title="Generar Hoja de Clasificación"></i>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Medicotriage_r.js?').md5(microtime())?>" type="text/javascript"></script>