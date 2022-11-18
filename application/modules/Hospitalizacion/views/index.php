<?= modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12" style="margin-top: 10px">
            <div class="panel panel-default ">

                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">LISTA DE PACIENTES EN HOSPITALIZACIÓN (<?=count($Gestion)?> PACIENTES)</span>
                    <a href="<?=  base_url()?>Hospitalizacion/Indicadores" class="md-btn md-fab m-b red pull-right tip " data-original-title="Indicadores" target="_blank" style="position: absolute;right: 20px;top: 0px">
                        <i class="fa fa-bar-chart i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row ">
                        <div class="col-md-6">
                            <div class="input-group m-b ">
                                <span class="input-group-addon back-imss border-back-imss" >
                                    <i class="fa fa-user-plus"></i>
                                </span>
                                <input type="text" class="form-control" name="triage_id" placeholder="Ingresar N° de Folio">
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <div class="input-group m-b ">
                                <span class="input-group-addon back-imss border-back-imss" >
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="filter" placeholder="Filtro General">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover footable table-no-padding" data-filter="#filter" data-limit-navigation="7" data-page-size="10">
                                <thead>
                                    <tr>
                                        <th>&nbsp;FECHA&nbsp;&nbsp;</th>
                                        <th>N° DE FOLIO</th>
                                        <th style="width: 20%;">PACIENTE</th>
                                        <th style="width: 22%">T. TRANSCURRIDO</th>
                                        <th style="width: 24%">CONSULTORIO</th>
                                        <th>ESTADO</th>
                                        <th style="width: 15%">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {
                                    $t_c=Modules::run('Config/CalcularTiempoTranscurrido',array('Tiempo1'=> str_replace('/', '-', $value['ce_fe']).' '.$value['ce_he'],'Tiempo2'=>date('d-m-Y').' '.date('H:i')));
                                    if($t_c->h<7 || $t_c->d>0){}
                                    ?>
                                    <tr id="<?=$value['triage_id']?>">
                                        <td><?=date("d-m-y", strtotime($value['ce_fe']));?></td>
                                        <td><?=$value['triage_id']?></td>         <!-- No de Flolio -->
                                        <td style="font-size: 12px">              <!-- nombre del paciente -->
                                            <?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>
                                        </td>
                                        <td ><?=$t_c->d?> d <?=$t_c->h?> hrs <?=$t_c->i?> min</td> <!-- tiempo trascurrido -->
                                        <td ><?=$value['ce_asignado_consultorio']?></td> <!-- Consultorio Asignado -->
                                        <td>

                                                                                 <!-- Estado -->

                                            <?php
                                            $sqlInterconsulta=$this->config_mdl->_query("SELECT doc_estatus,doc_id,especialidad_nombre FROM doc_430200
                                            INNER JOIN um_especialidades ON
                                              doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
                                            WHERE triage_id = ".$value['triage_id']." AND doc_modulo = 'Consultorios' "
                                            );
                                            $Total = count($sqlInterconsulta);
                                             ?>

                                            <?php if($value['ce_status']=='Interconsulta'){
                                                echo $value['ce_status'].": ".$Total;
                                                echo '<br>';
                                                $Evaluados = 0;
                                                foreach ($sqlInterconsulta as $value_st) {
                                                ?>
                                                        <?php
                                                        if($value_st['doc_estatus']=='En Espera'){
                                                        ?>
                                                        <span class="label amber pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/DOC430200/<?=$value_st['doc_id']?>')">
                                                          <?=$value_st['especialidad_nombre']?>
                                                        </span><br>

                                                        <?php
                                                        }else{
                                                            $Evaluados++;
                                                        ?>

                                                        <a href="<?= base_url()?>Hospitalizacion/InterconsultasDetalles?inter=<?=$value_st['doc_id']?>" target="_blank">
                                                            <span class="label green"><?=$value_st['especialidad_nombre']?></span>
                                                        </a>
                                                        <br>
                                                        <?php
                                                        }
                                                    }
                                            }else{
                                              echo $value['ce_status'];
                                            }?>

                                        </td>
                                        <td >           <!-- Aciones -->
                                            <a href="<?=  base_url()?>Sections/Documentos/Expediente/<?=$value['triage_id']?>/?tipo=Hospitalizacion" target="_blank">
                                                <i class="fa fa-pencil-square-o icono-accion tip" data-original-title="Requisitar Información"></i>
                                            </a>
                                            <?php if($value['ce_hf'] ==''){?>
                                            <i class="fa fa-bed tip salida-paciente-observacion pointer icono-accion" data-con="<?=$info_c[0]['empleado_area']?>"  data-id="<?=$value['triage_id']?>" data-original-title="Enviar a Observación"></i>&nbsp;

                                            <i class="fa fa-share-square-o icono-accion pointer tip abandono-consultorio" data-id="<?=$value['triage_id']?>" data-original-title="Alta por ausencia del paciente"></i>
                                            <?php }?>
                                            <?php if($value['ce_hf'] ==''){?>
                                            <i class="fa fa-sign-out tip salida-paciente-ce pointer icono-accion" data-id="<?=$value['triage_id']?>" data-original-title="Reportar Salida del Paciente"></i>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php } ?>
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
<input type="hidden" name="especialidad_nombre" value="<?= Modules::run('Hospitalizacion/ObtenerEspecialidad',array('Consultorio'=>$this->UMAE_AREA))?>">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Hospitalizacion.js?'). md5(microtime())?>" type="text/javascript"></script>