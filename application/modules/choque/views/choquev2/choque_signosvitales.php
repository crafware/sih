<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-11 col-centered" style="margin-top:-20px">
            <div class="box-inner padding">
                <div class="panel panel-default ">
                    <div class=" ">
                        <div class="panel-heading p teal-900 back-imss text-center" >
                            <span style="font-size: 15px">
                                <b>SIGNOS VITALES</b><br>
                            </span>
                        </div>
                    </div>
                </div>
                
            </div>  
        </div>
        
        <div class="col-md-11 col-centered" style="margin-top: 70px">
            <div class="box-inner padding">
                
                <div class="panel panel-default ">
                    <div class="panel-heading p teal-900 back-imss" style="padding-bottom: 0px;">
                        <div class="row" style="margin-top: -20px;text-transform: uppercase">

                            <div class="col-md-1 <?= Modules::run('Config/ColorClasificacion',array('color'=>$info['triage_color']))?>" style="height: 109px;margin-top: 4px;margin-left: -2px;"></div>
                            <div class="col-md-9" >
                                <h3>
                                    <b>PACIENTE: 
                                        <?=$info['triage_nombre']=='' ? $info['triage_nombre_pseudonimo'] : $info['triage_nombre_ap'].' '.$info['triage_nombre_am'].' '.$info['triage_nombre']?>
                                    </b>
                                </h3>
                                <h4>
                                    <?=$info['triage_paciente_sexo']?> <?=$PINFO['pic_indicio_embarazo']=='Si' ? '| Posible Embarazo' : ''?>
                                </h4>
                                <h4 style="margin-top: -5px;text-transform: uppercase">
                                    <?php 
                                        if($info['triage_fecha_nac']!=''){
                                            $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                            if($fecha->y<15){
                                                echo 'PEDIATRICO';
                                            }if($fecha->y>15 && $fecha->y<60){
                                                echo 'ADULTO';
                                            }if($fecha->y>60){
                                                echo 'GERIATRICO';
                                            }
                                        }else{
                                            echo 'S/E';
                                        }
                                    ?> | <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEA: '.$PINFO['pia_procedencia_espontanea_lugar'] : ': '.$PINFO['pia_procedencia_hospital'].' '.$PINFO['pia_procedencia_hospital_num']?> | <?=$info['triage_color']?>
                                </h4>
                            </div>
                            <div class="col-md-2 text-center">
                                <h3>
                                    <b>EDAD</b>
                                </h3>
                                <h1 style="margin-top: -10px">
                                    <?php 
                                    if($info['triage_fecha_nac']!=''){
                                        $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                        echo $fecha->y.' <span style="font-size:25px"><b>Años</b></span>';
                                    }else{
                                        echo 'S/E';
                                    }
                                    ?>
                                </h1>
                            </div>
                        </div>

                        <a href="" md-ink-ripple="" class="md-btn md-fab m-b green waves-effect pull-right btn-add-signo-vital" data-triage="<?=$this->uri->segment(4)?>" style="margin-top: -20px;">
                            <i class="fa fa-stethoscope i-24"></i>
                        </a>
                    </div>
                    <div class="panel-body b-b b-light">
                        <div class="card-body" >
                            <div class="row">
                                <div class="col-md-12" style="margin-top: -10px">
                                    <br>
                                    <table class="table table-hover table-bordered footable" data-page-size="10" data-filter="#filter_medico_choque" style="font-size: 13px">
                                        <thead class="">
                                            <tr>
                                                <th>N°</th>
                                                <th>T.A</th>
                                                <th>TEMP</th>
                                                <th>F.C</th>
                                                <th>F.R</th>
                                                <th>FECHA</th>
                                                <th>ENFERMERA</th>
                                                <th class="hide">ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num=0; foreach ($Gestion as $value) { $num++;?>
                                            <tr>
                                                <td><?=$num?></td>
                                                <td ><?=$value['sv_ta']?></td>
                                                <td><?=$value['sv_temp']?> °C</td>
                                                <td><?=$value['sv_fc']?> X Min</td>
                                                <td><?=$value['sv_fr']?> X Min</td>
                                                <td><?=$value['sv_fecha']?> <?=$value['sv_hora']?></td>
                                                <td><?=$value['empleado_nombre']?> <?=$value['empleado_apellidos']?></td>
                                                <td class="hide">
                                                    <i class="fa fa-pencil icono-accion pointer" style="opacity: 0.4"></i>&nbsp;
                                                    <i class="fa fa-trash-o icono-accion pointer" style="opacity: 0.4"></i>&nbsp;
                                                </td>
                                            </tr>
                                            <?php }?>
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
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Choquev2.js?').md5(microtime())?>" type="text/javascript"></script>