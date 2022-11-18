<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-7 col-centered">
        <div class="box-inner padding">
            <div class="panel panel-default no-border" style="background: transparent;border: transparent;margin-top: -20px">
                <ul class="breadcrumb">
                    <li><a >Inicio</a></li>
                    <li><a href="#"><?=$_SESSION['UMAE_AREA']?></a></li>
                    <li><a href="#">Documentos Anexados</a></li>
                    <li><a href="#"><?=$info[0]['triage_nombre']?> <?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?></a></li>
                </ul>
            </div>
            <div class="panel panel-default ">
                
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">Detalles del Paciente</span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="card-body" style="padding: 0px">
                        <div class="row">
                            <div class="col-md-12">
                                <h5><b>Paciente:</b> <?=$info[0]['triage_nombre']?> <?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?></h5>
                                <h5><b>N.S.S:</b> <?=$info[0]['triage_paciente_afiliacion']?></h5>
                            </div>
                        </div>
                        
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Documentos</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hoja de Clasificación</td>
                                <td>
                                    <a href="<?=  base_url()?>triage/generar_documento?t=<?=$_GET['t']?>" target="_blank">
                                        <i class="fa fa-file-pdf-o icono-accion"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Hoja Frontal</td>
                                <td>
                                    <?php if($am[0]['asistentesmedicas_status']=='Datos Capturados'){?>
                                    <a href="<?=  base_url()?>asistentesmedicas/generar_solicitud?t=<?=$_GET['t']?>" target="_blank">
                                        <i class="fa fa-file-pdf-o icono-accion"></i>
                                    </a>
                                    <?php }else{?>
                                    DATOS NO CAPTURADOS POR A.M
                                    <?php }?>
                                </td>
                            </tr>
                            <?php if($info[0]['triage_paciente_accidente_lugar']=='TRABAJO'){?>
                            <tr>
                                <td>ST-7</td>
                                <td>
                                    <?php if($am[0]['asistentesmedicas_status']=='Datos Capturados'){?>
                                    <a href="<?=  base_url()?>asistentesmedicas/st7?t=<?=$_GET['t']?>" target="_blank">
                                        <i class="fa fa-file-pdf-o icono-accion"></i>
                                    </a>
                                    <?php }else{?>
                                    DATOS NO CAPTURADOS POR A.M
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/os/triage/triage.js')?>" type="text/javascript"></script>