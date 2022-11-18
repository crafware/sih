<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12 col-centered">
            <div class="panel panel-default " style="margin-top: 10px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">Procedimiento para la clasificación de pacientes</span>
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
                                        <th >HORA CERO</th>
                                        <th >HORA ENF.</th>
                                        <th style="width: 25%">NOMBRE DEL PACIENTE</th>
                                        <th >SEXO</th>
                                        <th >EDAD</th>
                                        <th>TIPO TRIAGE</th>
                                        <th >T.T</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_filas=  count($Gestion);$total_minutos=0;
                                    ?>
                                    <?php foreach ($Gestion as $value) {?>
                                    <tr id="<?=$value['triage_id']?>">
                                        <td><?=$value['triage_id']?></td>
                                        <td><?=$value['triage_horacero_f']?> <?=$value['triage_horacero_h']?></td>
                                        <td><?=$value['triage_fecha']?> <?=$value['triage_hora']?></td>
                                        <td><?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?> </td>
                                        <td><?=$value['triage_paciente_sexo']?> </td>
                                        <td>
                                            <?php 
                                            if($value['triage_fecha_nac']!=''){
                                                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$value['triage_fecha_nac']));
                                                echo $fecha->y.' Años';
                                            }else{
                                                echo 'S/E';
                                            }
                                            ?>
                                        </td>
                                        <td >
                                            <?php 
                                            if($value['triage_fecha_nac']!=''){
                                                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$value['triage_fecha_nac']));
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
                                            ?>
                                        </td>
                                        <td>
                                            <?= Modules::run('Config/TiempoTranscurrido',array(
                                                'Tiempo1_fecha'=>$value['triage_horacero_f'],
                                                'Tiempo1_hora'=>$value['triage_horacero_h'],
                                                'Tiempo2_fecha'=>$value['triage_fecha'],
                                                'Tiempo2_hora'=>$value['triage_hora'],
                                            ))?> Min
                                        </td>

                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="hide-if-no-paging hidden">
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Enfermeriatriage.js?').md5(microtime())?>" type="text/javascript"></script>