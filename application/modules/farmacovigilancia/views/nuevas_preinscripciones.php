<?= modules::run('Sections/Menu/index'); ?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12" style="margin-top: 10px">
            <div class="panel panel-default ">  
                <div class="w3-row-padding">
                    <div class="w3-third w3-margin-bottom">
                        <ul class="w3-ul w3-border w3-center w3-hover-shadow">
                            <li class="w3-black w3-xlarge " >Sin revisar</li>
                                <h2 class="w3-wide" id="nuevos"><?= $total_nuevos_med[0]['total']?></h2>
                                <span class="w3-opacity">Medicamentos</span>
                            </li>
                        </ul>
                    </div>
    

                        <div class="w3-third w3-margin-bottom">
                            <ul class="w3-ul w3-border w3-center w3-hover-shadow">
                                <li class="w3-green w3-xlarge ">Revisados</li>
                                  <h2 class="w3-wide" id="revisados"> <?= $revisados[0]['revisados']?></h2>
                                  <span class="w3-opacity">Rvisados</span>
                                </li>
                            </ul>
                        </div>
                    <div class="w3-third w3-margin-bottom">
                        <ul class="w3-ul w3-border w3-center w3-hover-shadow">
                            <li class="w3-black w3-xlarge ">Canceladas</li>
                              <h2 class="w3-wide"> 50</h2>
                              <span class="w3-opacity">Por Revisar</span>
                            </li>
                        </ul>
                    </div>
                </div>
                    <div class="row">
                      
                     <?php $cont=0; foreach ($nuevas_pre as $value) { ?>
                        <div class="col-md-12" style="padding-bottom: 5px;">
                            <div class="panel-heading">
                            
                                <h4 class="panel-title">
                                 <div class="col-md-3" ><a  data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $cont?>"><i class="fa fa-user"></i>  <?=$value['triage_nombre']?></div> 
                                 <div class="col-md-3"><i class="fa fa-user-md"></i>   <?=$value['empleado_apellidos']?> <?=$value['empleado_nombre']?></div>
                                 <div class="col-md-3">Especialidad: <?=$value['especialidad_nombre']?></div>
                                 <div class="col-md-2">Fecha: <?=$value['fecha']?></div> 
                                 <div class="col-md-0">
                                     <a type="button" id="veri" class="VerificarPre"  data-value="<?=$value['idp']?>" >Validar</a>
                                </div>
                                </h4>
                                
                            </div>
                                <?php 
                                    $sql["medicamentos"] = $this->config_mdl->_query("SELECT *
                                    FROM prescripcion INNER JOIN catalogo_medicamentos ON  prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                    WHERE prescripcion.idp = '".$value['idp']."' AND  prescripcion.verifica_fv = 0"); 
                                ?>

                                
                            <div id="collapse<?php echo $cont?>" class="panel-collapse collapse">
                            
                                <div class="panel-body" > 
                                
                                  <table id="tables" class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th>Medicamento</th>
                                        <th>Dosis</th>
                                        <th>Via</th>
                                        <th>Tiempo</th>
                                        <th>Frecuencia</th>
                                        <th>Aplicacion</th>
                                        <th>Fecha de Inicio</th>
                                        <th>Fecha de Fin</th>
                                        <th>Acciones</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($sql["medicamentos"] as $value) {?>
                                            <tr id="fila<?=$value['prescripcion_id']?>" >
                                                <td><?=$value['medicamento']?></td>
                                                 <td><?=$value['dosis']?></td>
                                                <td><?=$value['via']?></td>
                                                <td><?=$value['tiempo']?></td>
                                                <td><?=$value['frecuencia']?></td>
                                                <td><?=$value['aplicacion']?><br><?=$value['observacion']?></td>
                                                <td><?=$value['fecha_inicio']?></td>
                                                <td><?=$value['fecha_fin']?></td>
                                                <td><i  class="fa fa-check-square Verificar-fv" style="font-size:25px;color:#195e4b" data-value="<?=$value['prescripcion_id']?>" ></i></td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                <?php $cont++; } ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="especialidad_nombre" value="<?= Modules::run('Consultorios/ObtenerEspecialidad',array('Consultorio'=>$this->UMAE_AREA))?>">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/PrescripcionRevisada.js?'). md5(microtime())?>" type="text/javascript"></script>


