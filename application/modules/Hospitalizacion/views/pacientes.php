<?= modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12" style="margin-top: -20px">
            <div class="panel panel-default ">
                <ul class="nav nav-md nav-tabs nav-lines b-info bg-color-nav" style="color: #9f9f9f!important">
                    <li id="li_1" class="active">
                        <a href="" data-toggle="tab" data-target="#tab_1" aria-expanded="false" style="color: white!important">Ingresos Pendientes</a>
                    </li>
                    <li id="li_2" class="">
                        <a href=""  data-toggle="tab" data-target="#tab_2" style="color: white!important">Pacientes</a>
                    </li>
                    <li id="li_3" class="">
                        <a href=""  data-toggle="tab" data-target="#tab_3" style="color: white!important">Buscar Paciente</a>
                    </li>
                </ul>            
                <div class="tab-content p m-b-md b-t b-t-2x">
                    <div role="tabpanel" class="tab-pane animated fadeIn active" id="tab_1">
                        <div class="row">
                            <div class="col-md-2">
                                <label for=""><b>Filtrar por fecha de ingreso</b></label>
                                <div class="input-group m-b">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="fecha" class="form-control" id="fecha" value="<?php echo date("d-m-Y");?>" placeholder="Seleccionar fecha">
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-6">
                                <div class="input-group m-b ">
                                    <span class="input-group-addon back-imss border-back-imss" >
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="filter" placeholder="Buscar paciente">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <table class="table table-bordered table-hover footable" data-filter="#TriageIdFilter" data-limit-navigation="7"data-page-size="10">
                                    <thead>
                                        <tr class="bg-warning">
                                            <th>FOLIO</th>
                                            <th style="width: 20%;">PACIENTE</th>
                                            <th>FECHA DE REGISTRO</th>
                                            <th>FECHA DE INGRESO</th>
                                            <th>TIPO DE INGRESO</th>
                                            <th>MÉDICO</th>
                                            <th>CAMA</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ingresoPacientes as $value) {?>
                                        <tr id="<?=$value['triage_id']?>" >
                                            <td style="width: 8%"><?=$value['triage_id']?></td>
                                            <td style="width: 15%">
                                                <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?> <?=$value['triage_nombre']?>
                                            </td>
                                            <td style="width: 11%"><?=date("d-m-Y", strtotime($value['fecha_registro']))?> <?=$value['hora_registro']?></td>
                                            <td style="width: 11%"><?=date("d-m-Y", strtotime($value['fecha_ingreso']))?> <?=$value['hora_ingreso']?></td>
                                            <td style="width: 10%;text-align: center">
                                                <?=$value['tipo_ingreso']?> <?=$value['estado_doc']?>
                                            </td>
                                            <!-- 
                                            <td style="width: 15%" class="ver-texto pointer" data-content-title="DIAGNOSTICO" data-content-text="<?=$value['diagnostico']?>">
                                                <?= substr($value['diagnostico'], 0,20)?>
                                            </td> -->
                                            <td style="width: 16%" >
                                                <?php $medicoTratante = $this->config_mdl->_query("SELECT empleado_apellidos, empleado_nombre FROM os_empleados WHERE empleado_id=".$value['ingreso_medico']); ?>
                                                <?=$medicoTratante[0]['empleado_apellidos']?> <?=$medicoTratante[0]['empleado_nombre']?>
                                            </td> 
                                            <td style="width: 8%">
                                                <?php 
                                                    $cama = $this->config_mdl->_query("SELECT cama_nombre,piso_nombre_corto from os_camas, os_pisos WHERE os_camas.area_id=os_pisos.area_id AND triage_id =".$value['triage_id']);
                                                     if (empty($cama)){
                                                        $infoCama = 'Por asignar'; 
                                                    }else   $infoCama = $cama[0]['cama_nombre'].' '.$cama[0]['piso_nombre_corto'];    
                                                ?>
                                                <?=$infoCama?>
                                            </td>
                                            <td style="width: 5%">
                                                <?php if($value['estado_ingreso_med']=='Esperando'){?>
                                                    <i class="fa fa-pencil-square-o icono-accion tip pointer" id='ingresoPaciente' data-original-title="Ingresar paciente al servicio" data-value="<?=$value['triage_id']?>"></i>
                                                <?php }?>

                                                <i class="fa fa-sign-out icono-accion pointer tip borrar-paciente-ingreso" data-id="<?=$value['triage_id']?>" data-original-title="Borrar de la lista"></i>
                                            </td>
                                        </tr>
                                        <?php } ?>
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
                    <div role="tabpanel" class="tab-pane animated fadeIn " id="tab_2">
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
                                        <tr class="bg-primary">
                                            <th style="width: 12%;text-align: center;">FECHA / HORA INGRESO</th>
                                            <th>N° DE FOLIO</th>
                                            <th style="width: 20%;">PACIENTE</th>
                                            <th style="width: 24%">NSS</th>
                                            <th style="width: 9%">CAMA</th>
                                            <th style="width: 13%">TIEMPO ESTANCIA</th>
                                            <th>ESTADO</th>
                                            <th style="width: 12%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($Gestion as $value) {
                                        /* Calcular el Tiempo de estancia en el servicio */     
                                        $tiempo_estancia=Modules::run('Config/CalcularTiempoTranscurrido',array('Tiempo1'=> str_replace('/', '-', $value['fecha_ingreso']).' '.$value['hora_atencion'],'Tiempo2'=>date('d-m-Y').' '.date('H:i')));
                                        if($tiempo_estancia->h<7 || $tiempo_estancia->d>0){}
                                        ?>
                                        
                                        <tr id="<?=$value['triage_id']?>">
                                            <td style="text-align: center">
                                                <?=date("d-m-y", strtotime($value['fecha_ingreso']));?> <?=$value['hora_atencion']?>
                                            </td>
                                            <td><?=$value['triage_id']?></td>         <!-- No de Flolio -->
                                            <td style="font-size: 12px;text-align:left;">              <!-- nombre del paciente -->
                                                <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?> <?=$value['triage_nombre']?>
                                            </td>
                                            <td><?=$value['pum_nss']?>  <?=$value['pum_nss_agregado']?></td>
                                            <?php $piso=$this->config_mdl->_query("SELECT * FROM os_pisos,os_pisos_camas WHERE 
                                                os_pisos.piso_id=os_pisos_camas.piso_id AND os_pisos_camas.cama_id='{$value['cama_id']}'");
                                            ?>
                                            <td>
                                                <?php 
                                                    $cama = $this->config_mdl->_query("SELECT cama_nombre,piso_nombre_corto from os_camas, os_pisos WHERE os_camas.area_id=os_pisos.area_id AND triage_id =".$value['triage_id']);
                                                     if (empty($cama)){
                                                        $infoCama = 'Por asignar'; 
                                                    }else   $infoCama = $cama[0]['cama_nombre'].' '.$cama[0]['piso_nombre_corto'];    
                                                ?>
                                                <?=$infoCama?>                                            
                                            </td>
                                            <td ><?=$tiempo_estancia->d?> d <?=$tiempo_estancia->h?> hrs <?=$tiempo_estancia->i?> min</td> <!-- tiempo trascurrido -->
                                            <td>
                                                <?php
                                                $sqlInterconsulta=$this->config_mdl->_query("SELECT doc_estatus,doc_id,especialidad_nombre FROM doc_430200
                                                INNER JOIN um_especialidades ON
                                                  doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
                                                WHERE triage_id = ".$value['triage_id']." AND doc_modulo = 'Hospitalizacion' "
                                                );
                                                $Total = count($sqlInterconsulta);
                                                 ?>

                                                <?php if($value['status']=='Interconsulta'){
                                                    echo $value['status'].": ".$Total;
                                                    echo '<br>';
                                                    $Evaluados = 0;
                                                    foreach ($sqlInterconsulta as $value_st) {?>
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

                                                            <a href="<?= base_url()?>Consultorios/InterconsultasDetalles?inter=<?=$value_st['doc_id']?>" target="_blank">
                                                                <span class="label green"><?=$value_st['especialidad_nombre']?></span>
                                                            </a>
                                                            <br>
                                                            <?php
                                                            }
                                                        }
                                                }else{
                                                  echo $value['status'];
                                                }?>
                                            </td>
                                            <td >           <!-- Aciones -->
                                                <a href="<?=  base_url()?>Sections/Documentos/Expediente/<?=$value['triage_id']?>/?tipo=Hospitalizacion&empleado_id=<?=$Medico["empleado_id"]?>?empleado_roles=<?=$Medico["empleado_roles"]?>" target="_blank">
                                                    <i class="fa fa-pencil-square-o icono-accion tip" data-original-title="Requisitar Información"></i>
                                                </a>
                                                <?php if($value['ce_hf']){?>
                                                <i class="fa fa-share-square-o icono-accion pointer tip abandono-consultorio" data-id="<?=$value['triage_id']?>" data-original-title="Alta por ausencia del paciente"></i>
                                                <?php }?>
                                                <?php if($value['hora_atencion']){?>
                                                <i class="fa fa-sign-out tip alta-paciente-servicio pointer icono-accion" data-id="<?=$value['triage_id']?>" data-original-title="Reportar ALta del Paciente"></i>
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <?php } ?>
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
                    <div role="tabpanel" class="tab-pane animated fadeIn" id="tab_3">
                        <div class="row">
                            <div class="col-md-4" >
                                <div class="form-group">
                                    <div class="form-group">
                                        <select class="form-control" name="inputSelect" id="inputSelect">
                                            <option value="POR_NUMERO">N° DE PACIENTE</option>
                                            <option value="POR_NOMBRE">NOMBRE DEL PACIENTE</option>
                                            <option value="POR_NSS">N.S.S (SIN AGREGADO)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5" style="padding-right: 2px">
                                <div class="input-group m-b ">
                                    <span class="input-group-addon back-imss "  style="border:1px solid #256659">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <input type="text" id="inputSearch" name="inputSearch" class="form-control" autocomplete="off" placeholder="Ingresar N° de Paciente">
                                </div>
                            </div>
                            <div class="col-md-3" style="padding-left: 0px">
                                <div class="form-group">
                                    <input type="hidden" name="csrf_token">
                                    <button class="btn btn-block back-imss buscarPaciente" name="btnSearch" id = buscarPaciente >BUSCAR</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="inputSelectNombre hide" style="color: red;margin-top: -10px"><i class="fa fa-warning"></i> ESTA CONSULTA ESTA LIMITADA A: 100 REGISTROS</h6>
                                <table class="footable table table-bordered" id="tableResultSearch" data-filter="#search" data-page-size="20" data-limit-navigation="7">
                                    <thead>
                                        <tr>
                                            <th data-sort-ignore="true">N° DE PACIENTE</th>
                                            <th data-sort-ignore="true">FECHA INGRESO</th>
                                            <th data-sort-ignore="true">NOMBRE</th>
                                            <th data-sort-ignore="true">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h5>NO SE HA REALIZADO UNA BÚSQUEDA</h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-center">
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
<input type="hidden" name="umae_user" value="<?=$this->UMAE_USER?>">
<?= modules::run('Sections/Menu/footer'); ?>
<script type="text/javascript" src="<?= base_url('assets/Sections/Pacientes.js?').md5(microtime())?>" ></script>
<script type="text/javascript" src="<?= base_url('assets/js/medicoHospNotas.js?').md5(microtime())?>" ></script>


<script>
    const Gestion = <?= json_encode($Gestion)?>;
   // console.log(Gestion);
    $(document).ready(function($) {
        $('body').on('click', '#buscarPaciente', function(e){
            var inputSelect = $('#inputSelect').val();
            var inputSearch = $('#inputSearch').val();
            console.log(inputSelect);
            console.log(inputSearch);
            var data = {
                "inputSelect" : inputSelect,
                "inputSearch" : inputSearch,
                csrf_token:csrf_token
            };
            e.preventDefault();
            if($('input[name=inputSearch]').val() != ''){
            $.ajax({
                    url: base_url+"Sections/Pacientes/AjaxPaciente",
                    type: 'POST',
                    dataType: 'json',
                    data:data
                    ,beforeSend: function (xhr) {
                        msj_loading('Espere por favor esto puede tardar un momento');
                    },success: function (data, textStatus, jqXHR) {
                        bootbox.hideAll();
                        console.log(data)
                        if($('select[name=inputSelect]').val()=='POR_NOMBRE'){
                            $('.inputSelectNombre').removeClass('hide');
                        }else{
                            $('.inputSelectNombre').addClass('hide');
                        }
                        $('#tableResultSearch tbody').html(data.tr)
                        InicializeFootable('#tableResultSearch');
                        $('body .tip').tooltip();
                    },error: function (e) {
                        bootbox.hideAll()
                        MsjError();
                    }
                })
            }else{
                msj_error_noti('ESPECIFICAR UN VALOR');
            }
        });
    }); 
</script>