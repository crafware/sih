<?= modules::run('Sections/Menu/index'); ?> 
<?php
function getServerIp()
{
	if ($_SERVER['SERVER_ADDR'] === "::1") {
		return "localhost";
	} else {
		return $_SERVER['SERVER_ADDR'];
	}
}
?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12 col-centered" style="margin-top: 10px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase;">Registro de pacientes para atención médica en admisión continua</span>
                    <a href="<?=  base_url()?>Asistentesmedicas/Indicadores" md-ink-ripple="" target="_blank" class="md-btn md-fab m-b red pull-right tip " data-original-title="Indicadores">
                        <i class="fa fa-bar-chart i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group m-b">
                                <span class="input-group-addon back-imss border-back-imss">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" name="triage_id" class="form-control" placeholder="Ingresar N° de Folio">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table footable table-bordered" data-filter="#filter" id="tabla1">
                                <thead>
                                    <tr>
                                        <th id = "noFolio" data-type="numeric"  data-sort-initial="true" class="footable-first-column footable-sortable footable-sorted">No.</th>
                                        <th>N° DE FOLIO</th>
                                        <th style="width: 25%">PACIENTE</th>
                                        <th>HORA CLAS.</th>
                                        <th>HORA A.M</th>
                                        <th>TIEMPO TRANS.</th>                       
                                        <th>MÉDICO TRATANTE</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cont=0; foreach ($Gestion as $value) {
                                        ++$cont;
                                    ?>
                                    <tr>
                                        <td><?=$cont?></td>
                                        <td><?=$value['triage_id']?></td>
                                        <td class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$value['triage_color']))?>" style="color: white">
                                            <?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>
                                        </td>
                                        <td><!--<?=$value['triage_fecha_clasifica']?> --><?=$value['triage_hora_clasifica']?></td>
                                        <td><!--<?=$value['asistentesmedicas_fecha']?>--><?=$value['asistentesmedicas_hora']?></td>
                                        <td>
                                            <?= Modules::run('Config/TiempoTranscurrido',array(
                                                'Tiempo1_fecha'=>$value['triage_fecha_clasifica'],
                                                'Tiempo1_hora'=>$value['triage_hora_clasifica'],
                                                'Tiempo2_fecha'=>$value['asistentesmedicas_fecha'],
                                                'Tiempo2_hora'=>$value['asistentesmedicas_hora'],
                                            ))?> Minutos
                                        </td>

                                        <td><?=$value['pic_mt']!='' ? $value['pic_mt'] : '<b style="color:#256659">Por asignar, caso COVID-19</b><br>' ?></td>
                                        <td>
                                            <?php if($value['triage_via_registro']=='Hora Cero TR'){?>
                                                <a href="<?= base_url()?>Asistentesmedicas/Triagerespiratorio/Registro/<?=$value['triage_id']?>?a=edit" target="_blank">
                                                <i class="fa fa-pencil icono-accion tip" data-original-title="Editar datos"></i>
                                            </a>&nbsp;
                                            <?php }else{?>

                                            <a href="<?= base_url()?>Asistentesmedicas/Paciente/<?=$value['triage_id']?>" target="_blank">
                                                <i class="fa fa-pencil icono-accion tip" data-original-title="Editar datos"></i>
                                            </a>&nbsp;
                                            <?php }?>
                                            <!--<a href="<?= base_url()?>Asistentesmedicas/Hospitalizacion/Registro/<?=$value['triage_id']?>" target='_blank' rel="opener"> -->
                                            <i class="fa fa-pencil-square-o icono-accion btn-reg-43051 pointer tip" data-paciente="<?=$value['triage_id']?>" data-original-title="Requisitar Información 43051"></i>  
                                            <!-- </a> --> 
                                            <?php 
                                            $sqlST7=$this->config_mdl->sqlGetDataCondition('paciente_info',array(
                                                'triage_id'=>$value['triage_id']
                                            ),'pia_lugar_accidente')[0];
                                            ?>
                                            <?php if(CONFIG_AM_HOJAINICIAL=='Si'){?>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumentoMultiple(base_url+'inicio/documentos/HojaFrontal/<?=$value['triage_id']?>','Hoja Frontal',200)" data-original-title="Generar Hoja Frontal"></i>
                                            <?php }?>
                                            <?php if($sqlST7['pia_lugar_accidente']=='TRABAJO'){?>
                                            &nbsp;<i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumentoMultiple(base_url+'inicio/documentos/ST7/<?=$value['triage_id']?>','ST7',200)" data-original-title="Generar ST7"></i>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                                </tbody>
                                <tfoot class="hide-if-no-paging">
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <ul class="pagination"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12" id="tabla123"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="Asistente Médica" name="AsistenteMedicaTipo">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Asistentemedica.js?'). md5(microtime())?>" type="text/javascript"></script> 