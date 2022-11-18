<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-10 col-centered">
        <div class="box-inner padding">
            <div class="panel panel-default no-border" style="background: transparent;border: transparent;margin-top: -20px">
                <ul class="breadcrumb">
                    <li><a >Inicio</a></li>
                    <li><a href="<?=  base_url()?>consultoriosespecialidad" class="">Consultorios de Especialidad</a></li>
                    <li><a href="#" class="back-history1">Reportes</a></li>
                    <li><a href="#"><?=$info[0]['triage_nombre']?> <?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?></a></li>
                </ul>
            </div>
            <div class="panel panel-default ">
                
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500"><b>Paciente:</b> <?=$info[0]['triage_nombre']?> <?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?></span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="card-body" style="padding: 0px">
                        <div class="row">
                            <div class="col-md-7 col-seccion1">
                                <h5></h5>
                                <h5>
                                    <b>H. Cero:</b><br> <?=$triage_crea_horacero['empleado_nombre']?> <?=$triage_crea_horacero['empleado_apellidos']?><br>
                                    <?=$info[0]['triage_horacero_f']?> <?=$info[0]['triage_horacero_h']?>
                                
                                </h5>
                                
                                <h5>
                                    <b>H. Enfermeria:</b> <br><?=$triage_crea_enfemeria['empleado_nombre']?> <?=$triage_crea_enfemeria['empleado_apellidos']?><br>
                                    <?=$info[0]['triage_fecha']?> <?=$info[0]['triage_hora']?>
                                
                                </h5>
                                
                                <h5>
                                    <b>H. Clasificación:</b> <br><?=$triage_crea_medico['empleado_nombre']?> <?=$triage_crea_medico['empleado_apellidos']?><br>
                                    <?=$info[0]['triage_fecha_clasifica']?> <?=$info[0]['triage_crea_medico']?>
                                
                                </h5>
                                <h5>
                                    <b>H. A.M:</b><br> <?=$triage_crea_am['empleado_nombre']?> <?=$triage_crea_am['empleado_apellidos']?><br>
                                    <?=$am['asistentesmedicas_fecha']?> <?=$am['asistentesmedicas_hora']?>
                                
                                </h5>
                                <h5 ><b>Hora Ingreso Consultorio:</b> <br>
                                    <?=$triage_crea_ce['empleado_nombre']?> <?=$triage_crea_ce['empleado_apellidos']?><br> 
                                    <?=$ce['ce_fe']?> <?=$ce['ce_he']?>
                                </h5>
                                <h5><b>Hora Salida Consultorio:</b> <br>
                                    <?=$triage_crea_ce['empleado_nombre']?> <?=$triage_crea_ce['empleado_apellidos']?><br>
                                    <?=$ce['ce_fs']=='' ? 'Sin Especificar' : $ce['ce_fs'] ?> <?=$ce['ce_hs']?></h5>
                            </div>
                            <div class="col-md-5 col-seccion2" style="background: #D9EDF7" >
                                <div class="">
                                    <h4 class="text-right"> Tiempo Transcurrido</h4>
                                    <h2 class="text-right" style="margin-bottom: 30px">
                                        <?php 
                                            date_default_timezone_set('America/Mexico_City');
                                            $hora_cero=new DateTime(str_replace('/', '-', $info[0]['triage_horacero_f']).' '.$info[0]['triage_horacero_h']);
                                            $hora_clas=new DateTime(str_replace('/', '-', $ce['ce_fe']).' '. $ce['ce_he']);
                                            $diff=$hora_cero->diff($hora_clas);
                                            echo $diff->h*60+$diff->i. ' Minutos';
                                            
                                        ?>
                                    </h2>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Documentos</th>
                                <th style="width: 41.5%">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hoja de Clasificación</td>
                                <td>
                                    <a href="<?=  base_url()?>inicio/documentos/Clasificacion/<?=$_GET['id']?>" target="_blank">
                                        <i class="fa fa-file-pdf-o icono-accion"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Hoja Frontal</td>
                                <td>
                                    <a href="<?=  base_url()?>inicio/documentos/HojaFrontal/<?=$_GET['id']?>" target="_blank">
                                        <i class="fa fa-file-pdf-o icono-accion"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php if($info[0]['triage_paciente_accidente_lugar']=='TRABAJO'){?>
                            <tr>
                                <td>ST-7</td>
                                <td>
                                    <a href="<?=  base_url()?>inicio/documentos/ST7/<?=$_GET['id']?>" target="_blank">
                                        <i class="fa fa-file-pdf-o icono-accion"></i>
                                    </a>
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
<script>
    $(document).ready(function (e){
        var seccion1=$('.col-seccion1').height();
        $('.col-seccion2').height(seccion1+"px");
    })
</script>

