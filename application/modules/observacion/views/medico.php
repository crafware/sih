<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12">   
            <div class="panel panel-default" style="margin-top: 10px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">PACIENTES EN ÁREA DE OBSERVACIÓN (<?=count($Gestion)?> PACIENTES)</span>
                    <a href="<?=  base_url()?>Observacion/Indicadores" class="md-btn md-fab m-b red pull-right tip " data-original-title="Indicadores" target="_self" style="position: absolute;right: 20px;top: 10px">
                        <i class="fa fa-bar-chart i-24"></i>
                    </a>
                    
                </div>
                <div class="panel-body b-b b-light">
                    <div class="" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group m-b ">
                                    <span class="input-group-addon back-imss border-back-imss" >
                                        <i class="fa fa-user-plus"></i>
                                    </span>
                                    <input type="text" class="form-control" name="triage_id" placeholder="Ingresar N° de Folio">
                                </div>
                            </div>
                            <div class="col-md-offset-2 col-md-4">
                                <div class="input-group m-b ">
                                    <span class="input-group-addon back-imss border-back-imss" >
                                        <i class="fa fa-search"></i></span>
                                    <input type="text" class="form-control" id="filter" placeholder="Filtro General">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 0px">
                                <table class="table footable table-bordered table-hover table-no-padding"   data-limit-navigation="10" data-filter="#filter" data-page-size="10">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Folio</th>
                                            <th style="width: 30%" align="center">Paciente</th>
                                            <th align="center">Ingreso</th>
                                            <th align="center">Via de Ingreso </th>
                                            <th style="width: 15%; text-align:center">Cama</th> 
                                            <th align="center">Estado</th>
                                            <th style="width: 15%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($Gestion as $value) {
                                            $check_ordenInternamiento = $this->config_mdl->_get_data_condition('um_orden_internamiento', array('triage_id' => $value['triage_id']))[0];
                                        ?>
                                        <tr>
                                            <td><?=$value['triage_id']?></td>
                                            <td><?php if($value['triage_nombre']== '') { ?>
                                                        <?=$value['triage_nombre_pseudonimo']?>
                                                        <span style="color:red; text-align: right; ">(En espera de actualización de datos)</span>
                                                <?php }else {?>
                                                       <?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>    
                                                <?php }?>
                                                <?php 
                                                  
                                                  if(!empty($check_ordenInternamiento)){
                                                    echo '<br>';
                                                    echo '<span class="label orange-800">Paciente con Orden de Internamiento</span>';
                                                  } 
                                                ?>
                                            </td>
                                            <td><?=$value['observacion_mfa']?> <?=$value['observacion_mha']?></td>
                                            <?php if($value['triage_via_registro']=="Hora Cero") {
                                                    $viaIngreso = 'Consultorios';
                                                  }else { $viaIngreso = 'Choque';} ?>
                                            <td><?php echo $viaIngreso; ?></td>
                                            
                                            <td style="text-align:center;"><?=($value['observacion_cama_nombre']=='' ? 'No Asignado' : $value['observacion_cama_nombre'])?></td>

                                            <td>
                                                <?=$value['observacion_status_v2']?>
                                                <?php if($value['observacion_status_v2']=='Interconsulta'){
                                                    echo '<br>';
                                                    $sqlInterconsulta=$this->config_mdl->_get_data_condition('doc_430200',array(
                                                        'triage_id'=>$value['triage_id'],
                                                        'doc_modulo'=>'Observación'
                                                    ));
                                                    $Total= count($sqlInterconsulta);
                                                    $Evaluados=0;
                                                    foreach ($sqlInterconsulta as $value_st) {
                                                ?>
                                                        <?php 
                                                        if($value_st['doc_estatus']=='En Espera'){
                                                        ?>
                                                        <span class="label amber pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/DOC430200/<?=$value_st['doc_id']?>')"><?=$value_st['doc_servicio_solicitado']?></span><br>
                                                        
                                                        <?php   
                                                        }else{
                                                            $Evaluados++;
                                                        ?>
                                                           
                                                        <a href="<?= base_url()?>Consultorios/InterconsultasDetalles?inter=<?=$value_st['doc_id']?>" target="_blank">
                                                            <span class="label green"><?=$value_st['doc_servicio_solicitado']?></span>
                                                        </a>
                                                        <br>
                                                        <?php
                                                        }

                                                    }
                                                }?>
                                            </td>
                                            <td >
                                                <a href="<?= base_url()?>Sections/Documentos/Expediente/<?=$value['triage_id']?>/?tipo=Observación" target="_blank">
                                                    <i class="fa fa-pencil-square-o icono-accion tip" data-original-title="Ver Expedinete"></i>
                                                </a>&nbsp;

                                                <i class="fa fa-reply-all icono-accion tip interconsulta-paciente pointer" data-ce="<?=$value['ce_id']?>" data-consultorio="<?=$_SESSION['OBSERVACION_SERVICIO_ID']?>;<?=$_SESSION['OBSERVACION_SERVICIO_NOMBRE']?>" data-id="<?=$value['triage_id']?>" data-original-title="Interconsulta"></i>&nbsp;
                                                
                                                <a href="<?= base_url()?>Sections/Documentos/TratamientoQuirurgico/<?=$value['triage_id']?>" target="_blank">
                                                    <i class="fa fa-medkit icono-accion tip" data-original-title="Requiere tratamiento quirúrgico"></i>
                                                </a>&nbsp;

                                                <i class="fa fa-hospital-o orden-internamiento pointer tip icono-accion" data-con="<?=$info_c[0]['empleado_area']?>"  data-folio="<?=$value['triage_id']?>" data-original-title="Ingresar Orden de Internamiento"></i>
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
                    <input type="hidden" name="observacion_alta">
                    <input type="hidden" name="accion_area_acceso" value="Observación">
                    <input type="hidden" name="accion_rol" value="Médico">
                    <input type="hidden" name="empleado_servicio" value="<?=$info['empleado_servicio']?>">
                </div>
                </div>
                
            </div>
            
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Observacion.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/OrdenInternamiento.js?'). md5(microtime())?>" type="text/javascript"></script>