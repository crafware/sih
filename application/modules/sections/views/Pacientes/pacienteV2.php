<?php echo modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding">
            <div class="col-md-12" style="margin-top: -20px">
                <div class="panel panel-default ">
                    <div class="panel-heading p teal-900 back-imss">
                        <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">
                            <b>HISTORIAL DEL PACIENTE:</b> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
                        </span>
                        <a href="<?=  base_url()?>Sections/Documentos/Expediente/<?=$info['triage_id']?>/?tipo=Consultorios&url=Enfermería"  target="_blank" >
                            <button class="btn btn-imms-cancel pull-right" style="margin-top: -5px">
                                VER EXPEDIENTE <i class="fa fa-share-square-o"></i>
                            </button>
                        </a>
                    </div>
                    <div class="panel-body b-b b-light">
                        <table class="table table-bordered  footable" data-page-size="5" data-limit-navigation="7">
                            <thead>
                                <tr class="teal">
                                    <th colspan="4" class="text-center"><b>HISTORIAL GENERAL</b></th>
                                </tr>
                                <tr>
                                    <th>TIPO DE ACCIÓN</th>
                                    <th>FECHA</th>
                                    <th>EMPLEADO</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php foreach ($Historial as $value) {?>
                                <tr>
                                    <td><?=$value['acceso_tipo']?></td>
                                    <td><?=$value['acceso_fecha']?> <?=$value['acceso_hora']?></td>
                                    <td><?=$value['empleado_nombre']?> <?=$value['empleado_apellidos']?> (<?=$value['empleado_matricula']?>)</td>
                                    <td>
                                        <?php if($value['acceso_tipo']=='Hora Cero'){?>
                                        <i class="fa fa-print icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Horacero/GenerarTicket/<?=$value['triage_id']?>')" data-original-title="Imprimir Ticket"></i>
                                        <?php }?>
                                        <?php if($value['acceso_tipo']=='Triage Enfermería'){?>
                                        
                                        <?php }?>
                                        <?php if($value['acceso_tipo']=='Triage Médico'){?>
                                        <i class="fa fa-print icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/Clasificacion/<?=$value['triage_id']?>')" data-original-title="Imprimir Hoja de Clasificación"></i>
                                        <?php }?>
                                        <?php if($value['acceso_tipo']=='Asistente Médica'){?>
                                        <i class="fa fa-print icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/HojaFrontal/<?=$value['triage_id']?>')" data-original-title="Imprimir Hoja Frontal Emitido por A.M"></i>
                                        <?php }?>
                                        <?php if($value['acceso_tipo']=='Consultorios Especialidad'){?>
                                        <i class="fa fa-print icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/HojaInicialAbierto/<?=$value['triage_id']?>')" data-original-title="Imprimir Nota Inicial Emitido por Consultorios u Observación"></i>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <ul class="pagination"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <?php if(isset($_GET['acceso'])){?>
                        <table class="table table-bordered footable" data-page-size="5" data-limit-navigation="7">
                            <thead>
                                <tr class="teal">
                                    <th colspan="4" class="text-center"><b>CAMBIO DE REGISTROS DE NOMBRE & NSS</b></th>
                                </tr>
                                <tr>
                                    <th><b>NOMBRE DEL PACIENTE</b></th>
                                    <th><b>N.S.S </b></th>
                                    <th><b>EMPLEADO</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php foreach ($PacientesLog as $value) {?>
                                <tr>
                                    <td>
                                        <?=explode('->',$value['log_nombre_paciente'])[0]?><br>
                                        <i class="fa fa-arrow-right"></i> <?=explode('->',$value['log_nombre_paciente'])[1]?>
                                    </td>
                                    <td>
                                        <?=explode('->',$value['log_nss'])[0]?><br>
                                        <i class="fa fa-arrow-right"></i><?=explode('->',$value['log_nss'])[0]?>
                                    </td>
                                    <td style="width: 35%">
                                        <?=$value['empleado_nombre']?> <?=$value['empleado_apellidos']?> (<?=$value['empleado_matricula']?>)<br>
                                        <?=$value['log_fecha']?>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <ul class="pagination"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <table class="table table-bordered footable" data-page-size="5" data-limit-navigation="7">
                            <thead>
                                <tr class="teal">
                                    <th colspan="5" class="text-center"><b>HISTORIAL DEL PACIENTE EN CAMAS</b></th>
                                </tr>
                                <tr class="">
                                    <th><b>FECHA</b></th>
                                    <th><b>CAMA</b></th>
                                    <th><b>TIPO DE ACCIÓN</b></th>
                                    <th><b>ÁREA</b></th>
                                    <th><b>EMPLEADO</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php foreach ($PacientesCamas as $value) {?>
                                <tr>
                                    <td><?=$value['cama_log_fecha']?><?=$value['cama_log_hora']?></td>
                                    <td><?=$value['cama_nombre']?></td>
                                    <td><?=$value['cama_log_tipo']?></td>
                                    <td><?=$value['cama_log_modulo']?></td>
                                    <td><?=$value['empleado_nombre']?> <?=$value['empleado_apellidos']?> (<?=$value['empleado_matricula']?>)</td>
                                    
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <ul class="pagination"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <table class="table table-bordered  footable" data-page-size="5" data-limit-navigation="7">
                            <thead>
                                <tr class="teal">
                                    <th colspan="4" class="text-center"><b>HISTORIAL DEL PACIENTE EN CAMAS-CAMBIOS ENFERMERA</b></th>
                                </tr>
                                <tr>
                                    <th><b>ÁREA</b></th>
                                    <th><b>CAMA</b></th>
                                    <th><b>ENFERMERO(A)</b></th>
                                    <th><b>REALIZO CAMBIO</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php foreach ($PacientesEnfermera as $value) {?>
                                <tr>
                                    <td><?=$value['cambio_modulo']?></td>
                                    <td><?=$value['cama_nombre']?></td>
                                    <td>
                                        <?php $sqlEnfOld=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                                            'empleado_id'=>$value['empleado_old']
                                        ),'empleado_nombre, empleado_apellidos,empleado_matricula')[0]?>
                                        ANTERIOR: <?=$sqlEnfOld['empleado_nombre']?> <?=$sqlEnfOld['empleado_apellidos']?><br>
                                        <?php $sqlEnfNew=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                                            'empleado_id'=>$value['empleado_new']
                                        ),'empleado_nombre, empleado_apellidos,empleado_matricula')[0]?>
                                        NUEVO: <?=$sqlEnfNew['empleado_nombre']?> <?=$sqlEnfNew['empleado_apellidos']?>
                                    </td>
                                    <td>
                                        <?=$value['empleado_nombre']?> <?=$value['empleado_apellidos']?>
                                        <br>
                                        <?=$value['cambio_fecha']?><?=$value['cambio_hora']?>
                                    </td>
                                    
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <ul class="pagination"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/Pacientes.js?'). md5(microtime())?>" type="text/javascript"></script>
