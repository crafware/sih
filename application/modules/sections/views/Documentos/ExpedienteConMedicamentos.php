<?= modules::run('Sections/Menu/index'); ?>
<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
<!-- <link rel="stylesheet" href="<?= base_url()?>assets/styles/notas.css"/> -->
<div class="box-row">
  <div class="box-cell">
    <div class="box-inner col-md-12 col-centered">
      <div class="panel panel-default " style="margin-top: 10px">
        <div class="panel-heading p teal-900 back-imss" style="padding-bottom: 0px;">
          <div class="row" style="margin-top: -20px;">
            <div class="col-md-9" style="padding-left: 40px;">
              <div style="position: relative">
                <div style="top: 4px;position: absolute;height: 65px;width: 35px;left: -41px;" class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$info['triage_color']))?>">
                </div>
              </div>
              <h5>
                <b>PACIENTE:</b> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?> | 
                <b>SEXO: </b><?=$info['triage_paciente_sexo']?> <?=$PINFO['pic_indicio_embarazo']=='Si' ? '| - Posible Embarazo' : ''?> | 
                <b>PROCEDENCIA:</b> <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEA '.$PINFO['pia_procedencia_espontanea_lugar'] : ' '.$PINFO['pia_procedencia_hospital'].' '.$PINFO['pia_procedencia_hospital_num']?> | 
                <b>NSS:</b> <?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?> |
                <b>Código de atención médica:</b> <?=$info['triage_color']?>
              </h5><?=$this->UMAE_SERVICIO?>
             <h5 style="margin-top: -5px;text-transform: uppercase">
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
                ?> 
             </h5>
            </div>
            <div class="col-md-3 text-right">
              <h5><b>EDAD</b></h5>
              <h4 style="margin-top: -10px">
                <?php 
                  if($info['triage_fecha_nac']!=''){
                    $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                    echo $fecha->y.' <span>Años</span>';
                  }else{
                    echo 'S/E';
                  }
                ?>
              </h4>
            </div>
          </div>
          <!-- Boton de selección de notas -->
          <div class="card-tools" style="margin-top: 55px">
            <ul class="list-inline"> 
                <li class="dropdown">
                    <a md-ink-ripple data-toggle="dropdown" class="md-btn md-fab red md-btn-circle tip" data-original-title="Realizar Documento" data-placement="bottom">
                        <i class="mdi-social-person-add i-24 " ></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">
                        <?php if(isset($_GET['url'])){?>
                        <li class="disabled">
                            <a href="#">NO PERMITIDO</a>
                        </li>
                        <?php }else{?>
                        <?php if($_GET['tipo']=='Choque'){?>
                        <li class="<?=$info['triage_fecha_clasifica']!='' ? 'disabled' :''?>">
                            <a <?php if($info['triage_fecha_clasifica']==''){?>href="<?= base_url()?>Sections/Documentos/HojaClasificacion/<?=$this->uri->segment(4)?>/?tipo=<?=$_GET['tipo']?>" target="_blank" <?php }?>>Hoja de Clasificación</a>    
                        </li>
                        <?php }?>
                        <?php if(!empty($DocumentosHoja) && !isset($_GET['via'])){ /* Si existe Hoja Frintal en pc_docuemtos */?> 
                        <?php if($this->ConfigHojaInicialAbierta=='No'){?>
                        <li class="<?=!empty($HojasFrontales)  ? 'disabled' :''?>">
                            <a <?php if(empty($HojasFrontales)){?>href="<?= base_url()?>Sections/Documentos/HojaFrontal?hf=0&TipoNota=Nota Inicial&a=add&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>" target="_blank">Generar Inicial (Hoja Frontal)<?php }?></a>
                        </li>
                        <?php }else if($this->UMAE_AREA != 'Médico Hospitalización' && $this->UMAE_AREA != 'Médico COVID'){ /* SI NO SE HA  GENERADO HOJA INICIAL ABIERTO*/?> 
                        <li class="<?=!empty($HojasFrontales)  ? 'disabled' :''?>">
                            <a <?php if(empty($HojasFrontales)){?>href="<?= base_url()?>Sections/Documentos/HojaInicialAbierto?hf=0&TipoNota=Nota Inicial&a=add&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>" target="_blank" <?php }?>><b>Generar "Nota Inicial"</b></a>
                        </li>
                        <?php }else {?>
                        <li class="<?=!empty($NotaIngresoHospital)  ? 'disabled' :''?>">
                            <a <?php if(empty($NotaIngresoHospital)){?>href="<?= base_url()?>Sections/Documentos/NotaIngresoHospitalario?idnota=0&TipoNota=Nota Inicial&a=add&folio=<?=$this->uri->segment(4)?>&via=<?=$this->UMAE_AREA?>&tipo=<?=$_GET['tipo']?>" target="_blank" <?php }?>><b>Generar "Nota de Ingreso"</b></a>
                        </li>
                        <?php }?>
                        <?php } /* Fin de if((!empty($DocumentosHoja) */?>
                        

                        <?php if(!empty($DocumentosNotas)){
                                if($this->UMAE_AREA != 'Médico Hospitalización' && $this->UMAE_AREA != 'Médico COVID'){?>
                        
                        <li class="<?=empty($HojasFrontales)  ? 'disabled' :''?>">
                            <a <?php if(!empty($HojasFrontales)){?>href="<?= base_url()?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Evolución&folio=<?=$this->uri->segment(4)?>&via=<?=$_GET['via']?>&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>" target="_blank" rel="opener" <?php }?>><b>Generar "Nota de Evolución"</b></a>
                        </li> 
                         <li class="<?=empty($HojasFrontales)  ? 'disabled' :''?>">
                            <a <?php if(!empty($HojasFrontales)){?>href="<?= base_url()?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Procedimientos&folio=<?=$this->uri->segment(4)?>&via=<?=$_GET['tipo']?>&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>" target="_blank" <?php }?>><b>Generar "Nota de Procedimientos"</b></a>
                        </li> 
                        <li class="<?=empty($HojasFrontales)  ? 'disabled' :''?>">
                            <a <?php if(!empty($HojasFrontales)){?>href="<?= base_url()?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Egreso&folio=<?=$this->uri->segment(4)?>&via=<?=$_GET['via']?>&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>" target="_blank" <?php }?>><b>Generar "Nota de Egreso"</b></a>
                        </li> 

                        <?php }else if($this->UMAE_AREA == 'Médico COVID') {?>

                        <li class="">
                            <a href="<?= base_url()?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Evolución&folio=<?=$this->uri->segment(4)?>&via=Covid&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>" target="_blank"><b>Generar "Nota de Evolución"</b></a>
                        </li> 
                        <li class="">
                            <a href="<?= base_url()?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Egreso&folio=<?=$this->uri->segment(4)?>&via=Covid&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>" target="_blank"><b>Generar "Nota de Egreso"</b></a>
                        </li>                                        
                        <?php }else {?>

                        <li class="<?=empty($NotaIngresoHospital)  ? 'disabled' :''?>">
                            <a <?php if(!empty($NotaIngresoHospital)){?>href="<?= base_url()?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Evolución&folio=<?=$this->uri->segment(4)?>&via=<?=$_GET['via']?>&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>" target="_blank" <?php }?>><b>Generar "Nota de Evolución"</b></a>
                        </li>
                        <li class="<?=empty($NotaIngresoHospital)  ? 'disabled' :''?>">
                            <a <?php if(!empty($NotaIngresoHospital)){?>href="<?= base_url()?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Procedimientos&folio=<?=$this->uri->segment(4)?>&via=<?=$_GET['tipo']?>&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>" target="_blank" <?php }?>><b>Generar "Nota de Procedimientos"</b></a>
                        </li> 
                        <li class="<?=empty($NotaIngresoHospital)  ? 'disabled' :''?>">
                            <a <?php if(!empty($NotaIngresoHospital)){?>href="<?= base_url()?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Egreso&folio=<?=$this->uri->segment(4)?>&via=<?=$_GET['via']?>&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>" target="_blank" <?php }?>><b>Generar "Nota de Egreso"</b></a>
                        </li>
                        <?php }?>

                        <?php if($_GET['tipo'] !='Consultorios') {?>
                        <li class="<?=empty($HojasFrontales) ? 'disabled' :''?>">
                            <a <?php if(!empty($HojasFrontales)){?>href="<?= base_url()?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Interconsulta&folio=<?=$this->uri->segment(4)?>&via=Valoración&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>" target="_blank" <?php }?>><b>Generar "Nota de Interconsulta (seguimiento)"</b></a>
                        </li>
                        <?php }?>
                        <?php }?>
                        <?php }?>
                        
                    </ul>
                </li>
            </ul>
          </div>
        </div>    
        <!-- TABLA DE DATOS -->
        <div class="panel-body b-b b-light">
          <div class="row">
            <div class="col-md-12" style="margin-top: 0px">
              <style>th,td{padding-left: 5px!important;padding-right: 0px!important;}</style>
              <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
                  <!-- Inicio navegador para seleccion de tipo de documento -->
                  <ul class="nav nav-tabs back-imss width100 table-hover">
                    <li class="active"><a href="#tab1primary" id="btnNotasTriage" data-toggle="tab">Notas Médicas</a></li>
                    <li class=""><a href="#tab2primary" data-toggle="tab">Estudio de laboratorio</a></li>
                    <li class=""><a href="#tab3primary" data-toggle="tab">Imagenología</a></li>
                    <li class=""><a href="#tab4primary" data-toggle="tab">Interconsultas</a></li>
                    <li class=""><a href="#tab5primary" data-toggle="tab">Prescripciones</a></li>
                  </ul>
                </div>
                <div class="panel-body">
                  <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab1primary">
                        <!-- Espacio para la seccion 'Prescripcion' -->
                        <!-- Tabla con el listado de documentos del paciente -->
                        <table class="table table-bordered table-hover">
                          <thead id="cabezaTablaExpediente">
                          </thead>
                          <tbody id="cuerpoTablaExpediente">
                          </tbody>
                        </table><!-- Fin tabla listado de documentos -->
                        <!-- Panel prescripciones inactivas -->
                        <div class="panel-group" id="acordeon" hidden>
                           <div class="back-imss" style="border-radius: 5px 5px 0px 0px; padding:1px;">
                             <h5 style="padding-left:5px"><a id ='prescripcionInactiva' data-toggle="collapse" data-parent="#acordeon" href="#collapse1">
                             Prescripciones inactivas:
                             <label id="total_prescripciones_inactivas"> <?= $Prescripcion[0]['total_prescripcion'] ?> </label>
                            </a></h5>
                           </div>
                           <div id="collapse1" class="panel-collapse collapse" >
                               <table style="width:100%;">
                                 <thead >
                                   <tr>
                                     <th>Fecha</th>
                                     <th>Médico</th>
                                     <th>Medicamento</th>
                                     <th>Dosis</th>
                                     <th>Via</th>
                                     <th>Frecuencia</th>
                                     <th>Aplicacion</th>
                                     <th>Inicio</th>
                                     <th>Fin</th>
                                   </tr>
                                 </thead>
                                 <tbody id='tablaPrescripcionInactiva'>

                                 </tbody>
                               </table>
                           </div>
                        </div> <!-- Fin panel prescripciones -->
                        <div id="PanelPrescripciones">
                        </div>
                        <!-- Tabla de contenido principal -->
                        <table class="table table-bordered table-hover footable footable" >
                            <thead>
                                <tr>
                                    <th style="width: 15%">FECHA Y HORA</th>
                                    <th style="width: 18%">DOCUMENTO</th>
                                    <th style="width: 18%">ÁREA</th>
                                    <th style="width: 14%">SERVICIO</th>
                                    <th style="width: 25%">MÉDICO TRATANTE</th>
                                    <th style="width: 15%">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($info['triage_fecha_clasifica']!=''):?>
                                 <!-- Hoja de Clasificacion en triage -->   
                                <tr>
                                    <td>
                                        <?php if($info['triage_color']!=''){?>
                                        <?=date("d-m-Y", strtotime($info['triage_fecha_clasifica']));?> <?=$info['triage_hora_clasifica']?>
                                        <?php }else{?>
                                        No Aplica
                                        <?php }?>
                                    </td>
                                    <td>Hoja de Clasificación</td>
                                    <td>Médico Triage</td>
                                    <td>Admisión Continua</td>
                                    <td>
                                        <?php $sqlMedicoClass=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                                            'empleado_id'=>$info['triage_crea_medico']
                                        ),'empleado_nombre, empleado_apellidos')[0];?>
                                        <?=$sqlMedicoClass['empleado_nombre']?> <?=$sqlMedicoClass['empleado_apellidos']?>
                                    </td>           
                                    <td>
                                        <?php if($info['triage_color']!=''){?>
                                        <i class="fa fa-file-pdf-o icono-accion pointer tip" data-original-title='Ver Hoja de Clasificación' onclick="AbrirDocumento(base_url+'Inicio/Documentos/Clasificacion/<?=$this->uri->segment(4)?>/?via=<?=$_GET['tipo']?>')"></i>
                                        <?php }else{?>
                                        No Aplica
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php endif;?>
                                <!-- Par cada nota frontal -->
                                <?php foreach ($HojasFrontales as $value) {?>
                                <tr>
                                    <td>
                                        <?php if($value['hf_choque']=='1' || $value['hf_obs']=='1') {
                                                $horaAtencion=$obs['observacion_mha'];
                                            }else {$horaAtencion=$ce['ce_he'];}?>
                                            <?=$value['hf_fg']?> <?=$horaAtencion?>              
                                    </td>
                                    <td>Nota Inicial (Hoja Frontal)</td>
                                    <td><?=$ce['ce_asignado_consultorio']?></td>
                                    <td></td>
                                    <td><?= Modules::run('Sections/Documentos/ExpedienteEmpleado',array('empleado_id'=>$value['empleado_id']))?></td>
                                    <td> <!--Acciones -->
                                        <?php if($this->ConfigHojaInicialAbierta=='No'){?>
                                        <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/HojaFrontalCE/<?=$value['triage_id']?>')" data-original-title="Ver Hoja Frontal"></i>
                                        &nbsp;
                                        <?php }else{?>
                                        <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/HojaInicialAbierto/<?=$value['triage_id']?>')" data-original-title="Ver Hoja Frontal"></i>
                                        &nbsp;
                                        <?php }?> 
                                        <?php if(!empty($ordeninternamiento)){?>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/Ordeninternamiento/<?=$value['triage_id']?>')" data-original-title="Generar Orden de Internamiento"></i>
                                        &nbsp;
                                        <?php }?>
                                        <?php
                                        $solicitud_laboratorio= $this->config_mdl->_query("SELECT * FROM um_solicitud_laboratorio WHERE input_via = '".$_GET['tipo']."' AND tipo_nota='Nota Inicial' AND nota_id= '".$value['hf_id']."' AND  triage_id = '".$this->uri->segment(4)."'")[0];
                                        if($solicitud_laboratorio['solicitud_id'] && $solicitud_laboratorio['estudios']!= "{}"){?>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/OrdenLaboratorio/<?=$value['triage_id']?>?hf=<?=$value['hf_id']?>&TipoNota=Nota Inicial&a=edit&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>')" data-original-title="Generar Orden de Laboratorio"></i>
                                        &nbsp;
                                        <?php }?>  
                                        <?php if($PINFO['pia_lugar_accidente']=='TRABAJO'):?>
                                        <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/ST7/<?=$value['triage_id']?>')" data-original-title="Generar ST7"></i>
                                        &nbsp;
                                        <?php endif;?>
                                        <?php if($_GET['via']!='paciente'){?>
                                        <?php if($value['empleado_id']==$_SESSION['UMAE_USER'] || $obs['observacion_medico']==$_SESSION['UMAE_USER']){?>
                                        <?php if($this->ConfigHojaInicialAbierta=='No'){?>
                                        <a href="<?=  base_url()?>Sections/Documentos/HojaFrontal?hf=<?=$value['hf_id']?>&a=edit&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>" target="_blank">
                                            <i class="fa fa-pencil icono-accion"></i>
                                        </a>&nbsp;
                                        <?php }else{?>
                                        <a href="<?=  base_url()?>Sections/Documentos/HojaInicialAbierto?hf=<?=$value['hf_id']?>&TipoNota=Nota Inicial&a=edit&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>" target="_blank">
                                            <i class="fa fa-pencil icono-accion tip pointer" data-original-title="Editar Nota"></i>
                                        </a>&nbsp;
                                        <?php }?>
                                        <?php }?>
                                        <i class="fa fa-trash-o icono-accion pointer" style="opacity: 0.4"></i>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php }?> 
                                <?php foreach ($NotaIngresoHospital as $value) {?>
                                    <tr>
                                        <td><?=$value['fecha_elabora']?> <b class="blue"><?=$value['hora_elabora']?></b></td>
                                        <td>Nota de Ingreso</td>
                                        <td>
                                            Hospitalización
                                        </td>
                                        <td><?=$value['especialidad_nombre']?>
                                        </td>
                                        <td><?=$value['empleado_nombre']?> <?=$value['empleado_apellidos']?></td>
                                        <td>
                                    
                                        <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/NotaIngresoHosp/<?=$value['triage_id']?>')" data-original-title="Ver Nota de Ingreso"></i>
                                        &nbsp;
                                    
                                        <?php
                                        $solicitud_laboratorio= $this->config_mdl->_query("SELECT * FROM um_solicitud_laboratorio WHERE input_via = '".$_GET['tipo']."' AND tipo_nota='Nota Inicial' AND nota_id= '".$value['hf_id']."' AND  triage_id = '".$this->uri->segment(4)."'")[0];
                                        if($solicitud_laboratorio['solicitud_id'] && $solicitud_laboratorio['estudios']!= "{}"){?>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/OrdenLaboratorio/<?=$value['triage_id']?>?hf=<?=$value['hf_id']?>&TipoNota=Nota Inicial&a=edit&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>')" data-original-title="Generar Orden de Laboratorio"></i>
                                        &nbsp;
                                        <?php }?>  
                                      
                                      
                                        <a href="<?=  base_url()?>Sections/Documentos/NotaIngresoHospitalario?idnota=<?=$value['id_nota']?>&TipoNota=Nota Inicial&a=edit&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>" target="_blank">
                                            <i class="fa fa-pencil icono-accion tip pointer" data-original-title="Editar Nota"></i>
                                        </a>&nbsp;
                                        
                                        <i class="fa fa-trash-o icono-accion pointer" style="opacity: 0.4"></i>
                                        
                                        </td>
                                    </tr>
                                <?php }?>
                                <!-- Genera las notas de evolución, Interconsulta, Valoración, Egreso etc--> 
                                <?php foreach ($NotasAll as $value) {?>
                                <tr>
                                    <td><?=$value['notas_fecha']?>-<?=$value['notas_hora']?></td>
                                    <td>
                                        <?=$value['notas_tipo']?>
                                    </td>
                                    <td><?=$value['notas_area']?></td>
                                    <td><?=$value['especialidad_nombre']?></td>
                                    <?php $medicoTratante= $this->config_mdl->_get_data_condition('os_empleados',array(
                                                                'empleado_id'=> $value['notas_medicotratante']))[0];
                                    ?>
                                    <td><?=$medicoTratante['empleado_nombre']?> <?= $medicoTratante['empleado_apellidos']?></td>
                                    <td> <!-- Acciones -->
                                        <?php 
                                        if($value['notas_tipo']=='Nota de Egreso'){?>

                                        <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/GenerarNotaEgreso/<?=$value['notas_id']?>?inputVia=<?=$_GET['tipo']?>?via=<?=$value['notas_via']?>?tipoNota=<?=$value['notas_tipo']?>')" data-original-title="Ver <?=$value['notas_tipo']?>"></i>
                                        <?php }else 
                                        if($value['notas_tipo']=='Nota de Procedimientos') {?>

                                        <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/GenerarNotaProcedimientos/<?=$value['notas_id']?>?via=<?=$value['notas_via']?>?inputVia=<?=$_GET['tipo']?>?tipoNota=<?=$value['notas_tipo']?>')" data-original-title="Ver <?=$value['notas_tipo']?>"></i>
                                        <?php }else {?>
                                        <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/GenerarNotas/<?=$value['notas_id']?>?inputVia=<?=$_GET['tipo']?>?via=<?=$value['notas_via']?>?inputVia=<?=$_GET['tipo']?>?tipoNota=<?=$value['notas_tipo']?>')" data-original-title="Ver <?=$value['notas_tipo']?>"></i>
                                        <?php }?>
                                        &nbsp;
                                        <?php
                                        $solicitud_laboratorio= $this->config_mdl->_query("SELECT * FROM um_solicitud_laboratorio WHERE input_via = '".$_GET['tipo']."' AND tipo_nota='".$value['notas_tipo']."' AND nota_id= '".$value['notas_id']."' AND  triage_id = '".$this->uri->segment(4)."'")[0];
                                        if($solicitud_laboratorio['solicitud_id'] && $solicitud_laboratorio['estudios']!= "{}"){?>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/OrdenLaboratorio/<?=$value['triage_id']?>?hf=<?=$value['notas_id']?>&TipoNota=<?=$value['notas_tipo']?>&a=edit&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>')" data-original-title="Imprime Orden de Laboratorio"></i>
                                        &nbsp;
                                        <?php }?> 

                                        <?php if($value['empleado_id']==$_SESSION['UMAE_USER']){?>
                                            <a href="<?=  base_url()?>Sections/Documentos/Notas/<?=$value['notas_id']?>/?a=edit&TipoNota=<?=$value['notas_tipo']?>&folio=<?=$this->uri->segment(4)?>&via=<?=$value['notas_via']?>&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>" target="_blank"><i class="fa fa-pencil icono-accion tip pointer" data-original-title="Editar Nota"></i>
                                            </a>&nbsp;
                                                                                  
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php }?>
                                <?php if($_GET['tipo']=='Observación' || $_GET['tipo']=='Consultorios' ){?>
                                <tr>
                                    <td><?=$value['hf_fg']?> <?=$value['hf_hg']?></td>
                                    <td>Consentimiento informado para el ingreso al área de Observación AC</td>
                                    <td>NO APLICA</td>
                                    <td></td>
                                    <td>NO APLICA</td>
                                    <td>
                                        <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/ConsentimientoInformadoIngresoObs/<?=$this->uri->segment(4)?>')" data-original-title="Generar Documento"></i>
                                    </td>
                                </tr>
                                <?php }?>
                                <?php if($_GET['tipo']=='Choque'  ){?>
                                <tr>
                                    <td>NO APLICA</td>
                                    
                                    <td>Consentimiento informado para el ingreso al área de Choque AC</td>
                                    <td>NO APLICA</td>
                                    <td>NO APLICA</td>
                                    <td></td>                                        
                                    <td>
                                        <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/ConsentimientoInformadoIngresoObs/<?=$this->uri->segment(4)?>')" data-original-title="Generar Documento"></i>
                                    </td>
                                </tr>
                                <?php }?>
                                <?php foreach ($AvisoMp as $AvisoMp) {?>
                                <tr>
                                    <td><?=$AvisoMp['mp_fecha']?> <?=$AvisoMp['mp_hora']?></td>
                                    <td>Documento de Avisto al Ministerio Público</td>
                                    <td>NO APLICA</td>
                                    <td><?=$AvisoMp['empleado_nombre']?> <?=$AvisoMp['empleado_apellidos']?></td>
                                    <td>
                                        <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/<?=$this->uri->segment(4)?>')" data-original-title="Generar Documento"></i>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                              <tfoot class="hide-if-no-paging">
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <ul class="pagination"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table> <!-- Fin tabla listado de documentos paciente -->
                    </div>
                    <div class="tab-pane fade" id="tab2primary">
                      <table style="width:100%;">
                        <thead>
                          <tr>
                            <th style="width: 10%">Fecha y hora</th>
                            <th style="width: 15%">Médico solicitante</th>
                            <th style="width: 15%">Servicio solicitante</th>
                            <th style="width: 60%">Resultados</th>
                          </tr>
                        </thead>
                        <tbody id='tablaPrescripcionInactiva'></tbody>
                      </table> 
                    </div>
                    <div class="tab-pane fade" id="tab3primary">
                          
                    </div>
                    <div class="tab-pane fade" id="tab4primary">
                      <div class="container" style="width: 100%">        
                        <h4>Solicitud de interconsultas</h4>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Agregar</button>
                        <input type="hidden" id="ListaPro" name="ListaPro" value="" required />
                        <table id="TablaPro" class="table">
                          <thead>
                            <tr>
                              <th style="width: 8%">Fecha de solicitud</th>
                              <th style="width: 8%">Servicio</th>
                              <th style="width: 20%">Motivo</th>
                              <th style="width: 10%">Estado</th>
                              <th style="width: 10%">Acción</th>
                            </tr>
                          </thead>
                          <tbody id="servSelected"></tbody>
                        </table>
                        <div class="form-group">
                          <button type="submit" id="guardar" name= "guardar" class="btn btn-mg btn-default pull-right">Guardar</button>
                        </div>
                              <!-- Modal -->
                                  <div class="modal fade" id="myModal" role="dialog">
                                      <div class="modal-dialog">
                                          <!-- Modal content-->
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h4 class="modal-title">Agregar especialidad </h4>
                                              </div>
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <label>Especialidad</label>
                                                          <select class="selectpicker form-control" id="servicio_id" name="servicio_id" data-width='40%' >
                                                              <option value="0" label="Seleccionar especialidad"></option>
                                                              <?php  $Especialidades=$this->config_mdl->_query("SELECT especialidad_id, especialidad_nombre FROM um_especialidades WHERE especialidad_hospitalizacion=1 ORDER BY especialidad_nombre");
                                                                  foreach ($Especialidades as $value) {?>
                                                                  <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                                                              <?php }?>
                                                          </select>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="">Motivo de Interconsulta</label>
                                                      <input type="text" class="form-control" name="motivo" placeholder="" width="100%">
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <!--Uso la funcion onclick para llamar a la funcion en javascript-->
                                                  <button type="button" onclick="agregarServicio()" class="btn btn-default" data-dismiss="modal">Agregar</button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="tab5primary">
                      <div class="row">
                        <div class="col-md-12">
                          <button id="btnAdd" type="button" class="btn btn-info" data-toggle="modal" data-original-title="Agregar Medicamento">
                            <i class="material-icons">library_add</i>
                          </button>
                        </div>
                      </div>
                      <table id="tablaPrescripciones" class="table table-striped table-bordered table-condensed" style="width: 100%;">
                        <thead>
                          <tr>
                            <th>Folio</th>
                            <th>Médicamento</th>
                            <th>Indicación</th>
                            <th>Duracion</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tfoot></tfoot>
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
  </div>
</div>
<div class="modal fade" id="modalPrescripcion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:80%; height:60%; position: absolute; left: 10%;top: 5%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form id="formPrescripcion">   
        <div class="modal-body">
          <!-- <iframe id="iframe-modal" src=""  width="100%"  height="600" frameborder="0"></iframe> -->
          <div class="col-md-12">
            <h3>Prescripción Médica</h3>  
          </div>

            <div class="col-md-8 col-sm-8">
              <div class="form-group">
                <label><b>Medicamento / Forma farmacéutica (Cuadro Básico)</b></label>
                <div class="input-group">
                  <div class id="borderMedicamento" >
                    <select id="select_medicamento" onchange="indicarInteraccion()" class="form control select2 selectpicker" style="width: 100%" hidden>
                       <option value="0">-Seleccionar-</option>
                       <?php foreach ($medicamentos as $value) {?>
                       <option value="<?=$value['medicamento_id']?>" ><?=$value['medicamento']?></option>
                       <?php } ?>
                    </select>
                  </div>
                  <div id="border_otro_medicamento" hidden>
                    <input type="text" class="form-control" id="input_otro_medicamento" placeholder="Indicar otro medicamento">
                  </div>
                  <span class="input-group-btn otro_boton_span">
                    <button class="btn btn-default btn_otro_medicamento" type="button" value="0" title="Indicar otro medicamento">Otro medicamento</button>
                  </span>
                </div>
              </div>
            </div>

            <!-- Formulario para antibiotico NTP
            *El formulrio es desplegado en una ventana modal* -->
            <div class="form-group form-antibiotico-npt" hidden>
               <input class="form-control" id="categoria_safe"/>
               <input class="form-control aminoacido" />
               <input class="form-control dextrosa" />
               <input class="form-control lipidos-intravenosos" />
               <input class="form-control agua-inyectable" />
               <input class="form-control cloruro-sodio" />
               <input class="form-control sulfato-magnesio" />
               <input class="form-control cloruro-potasio" />
               <input class="form-control fosfato-potasio" />
               <input class="form-control gluconato-calcio" />
               <input class="form-control albumina" />
               <input class="form-control heparina" />
               <input class="form-control insulina-humana" />
               <input class="form-control zinc" />
               <input class="form-control mvi-adulto" />
               <input class="form-control oligoelementos" />
               <input class="form-control vitamina" />
               <input class="form-control total-npt" />
               <!-- Campos antimicrobianos y oncologicos -->
               <input class="form-control diluyente" />
               <input class="form-control vol_diluyente" />
            </div>
            <!-- Fin formulario para antibiotico NTP -->

            <!-- identificador de los medicamentos con interaccion interaccion_amarilla,
                 el select se llena al seleccionar un medicamento -->
            <div class="col-sm-2" hidden>
              <label><b>interaccion_amarilla</b></label>
              <div id="borderMedicamento">
                <select id="interaccion_amarilla" class="" style="width: 100%" >
                    <option value="0">-Seleccionar-</option>
                    <?php foreach ($medicamentos as $value) {?>
                    <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_amarilla']?></option>
                    <?php } ?>
                </select>
              </div>
            </div>
            
            <div class="col-sm-2" hidden>
              <label><b>interaccion_roja</b></label>
              <div id="borderMedicamento">
                <select id="interaccion_roja" class="" style="width: 100%" >
                  <option value="0">-Seleccionar-</option>
                  <?php foreach ($medicamentos as $value) {?>
                  <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_roja']?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <!-- Via de administracion -->
            <div class="col-sm-12">
              <div class="col-sm-5" style="padding-left: 0px;">
                <label><b>Via de administración</b></label>
                <div class="input-group" id="borderVia">
                  <div id="opcion_vias_administracion">
                    <select name="" class="form control select2 width100" id="via">
                      <option value="0">-Seleccionar-</option>
                   </select>
                  </div>
                  <span class="input-group-btn">
                    <button class="btn btn-default btn_otra_via" type="button" value="0" title="Indicar otra via de administración">Otra</button>
                  </span>
                </div>
              </div>
              <!-- Dosis -->
              <div class="col-sm-1" style="padding-right: 0; padding-left: 0;">
                <div class="form-group" >
                  <label ><b>Dosis</b></label>
                    <div id="borderDosis">
                      <input type="number" min='0' id="input_dosis" class="form-control">
                      <label id="dosis_max" hidden></label>
                      <label id="gramaje_dosis_max" hidden></label>
                    </div>
                </div>
              </div>
              
              <div class="col-sm-1" style="padding-left: 0;">
                <div class="form-group" >
                  <label ><b>Unidad</b></label>
                  <div id="borderUnidad">
                    <select name="" id="select_unidad" class="form-control">
                      <option value="0">-Unidad-</option>
                      <option value="g">g</option>
                      <option value="mg">mg</option>
                      <option value="mcg">mcg</option>
                      <option value="mL">mL</option>
                      <option value="UI">UI</option>
                    </select>
                 </div>
                </div>
              </div>

              <div class="col-sm-2" style="padding-left: 0;">
                <label><b>Frecuencia</b></label>
                <div id="borderFrecuencia">
                  <select class="form-control" id="frecuencia" onchange="asignarHorarioAplicacion()" >
                    <option value="0">- Frecuencia -</option>
                    <option value="4 hrs">4 hrs</option>
                    <option value="6 hrs">6 hrs</option>
                    <option value="8 hrs">8 hrs</option>
                    <option value="12 hrs">12 hrs</option>
                    <option value="24 hrs">24 hrs</option>
                    <option value="48 hrs">48 hrs</option>
                    <option value="72 hrs">72 hrs</option>
                    <option value="Dosis unica">Dosis unica</option>
                  </select>
                </div>
              </div>

              <div class="col-sm-3" style="padding-left: 0; padding-right: 0;">
                <label><b>Horario de administración</b></label>
                <div class="input-group" id="borderAplicacion">
                  <input type="text" class="form-control" id="aplicacion" disabled='disabled' >
                  <span class="input-group-btn">
                    <button class="btn btn-default edit-aplicacion" type="button" value="0" title="Cambiar el horario de aplicación">Cambiar</button>
                  </span>
                </div>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="col-sm-2">
                <label><b>Fecha inicio</b></label>
                <div class="input-group" id="borderFechaInicio">
                  <input id="fechaInicio" onchange="mostrarFechaFin()" class="form-control dd-mm-yyyy"  name="" placeholder="dd/mm/yyyy">
                  <span class="input-group-btn">
                     <button class="btn btn-default btn_fecha_actual" type="button" value="0" title="Fecha actual">Hoy</button>
                  </span>
                </div>
              </div> 
              <!-- El div cambia dependiendo el medicamento que sea prescrito -->
              <div class="tiempo_tipo_medicamento">
              </div>
            </div>
            <div class="col-sm-8">
              <label><b>Observaciones para la prescripción</b></label>
              <div id="borderFechaFin">
              <input name="observacion_prescripcion" class="form-control" id="observacion"   name="" >
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group" style="padding-top:23px;" >
                <div hidden id="div_btnActualizarPrescripcion">
                    <button type="button"  id="btnActualizarPrescripcion" class="btn back-imss btn-block" onclick="actualizarPrescripcion()"> MODIFICAR </button>
                </div>
                <div id="btn-form-npt" hidden>
                  <button type="button" class="btn back-imss btn-block edit-form-npt">MODIFICAR NPT </button>
                </div>
                <div id="btn-form-onco-anti" hidden>
                  <button type="button" class="btn back-imss btn-block edit-form-onco-anti">DILUYENTE</button>
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group" style="padding-top:23px;">
                <div class="btn_agregarPrescripcion">
                    <button type="button" class="btn back-imss btn-block"  onclick="agregarPrescripcion()"> AGREGAR </button>
                </div>
                <div class="btn_modificarPrescripcion" hidden>
                    <button type="button" class="btn back-imss btn-block" data-value="" id="btn_modificar_prescripcion"> MODIFICAR </button>
                </div>
              </div>
            </div>
            <table style="width:100%;">
              <thead >
                <tr>
                  <th colspan='11' class="back-imss">Medicamentos agregados</th>
                </tr>
                <tr>
                  <th hidden>ID</th>
                  <th>Medicamento</th>
                  <th>Dosis</th>
                  <th>Vía</th>
                  <th>Frecuencia</th>
                  <th>Aplicación</th>
                  <th>Inicio</th>
                  <th>Duración</th>
                  <th>Periodo</th>
                  <th>Fin</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody id="tablaPrescripcion">
              </tbody>
             </table>
            <input type="hidden" name="triage_id" value="<?=$this->uri->segment(4)?>" class="triage_id">
            <input type="hidden" name="csrf_token">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-dark">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div> 
<input type="hidden" name="triage_id" value="<?=$this->uri->segment(4)?>" class="triage_id">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/libs/datatables/datatables.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Expediente.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/medicamentos.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() { 
    function RefrescaServicio(){
        var ip = [];
        var i = 0;
        $('#guardar').attr('disabled','disabled'); //Deshabilito el Boton Guardar
        $('.iServicio').each(function(index, element) {
            i++;
            ip.push({ id_pro : $(this).val() });
        });
        // Si la lista de Productos no es vacia Habilito el Boton Guardar
        if (i > 0) {
            $('#guardar').removeAttr('disabled','disabled');
        }
        var ipt=JSON.stringify(ip); //Convierto la Lista de Productos a un JSON para procesarlo en tu controlador
        $('#ListaPro').val(encodeURIComponent(ipt));
    }
    function agregarServicio() {

            var sel = $('#servicio_id').find(':selected').val(); //Capturo el Value del Producto
            var text = $('#servicio_id').find(':selected').text();//Capturo el Nombre del Producto- Texto dentro del Select
           
            
            var sptext = text.split();
            
            var newtr = '<tr class="item"  data-id="'+sel+'">';
            newtr = newtr + '<td><?php echo date('d-m-Y h:i')?></td>';
            newtr = newtr + '<td class="iServicio" >' + sel + '</td>';
            newtr = newtr + '<td><input  class="form-control" name="motivo" required /></td>';
            newtr = newtr + '<td></td>';
            newtr = newtr + '<td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></td></tr>';
            
            $('#servSelected').append(newtr); //Agrego el Producto al tbody de la Tabla con el id=ProSelected
            
            RefrescaServicio();//Refresco 
                
            $('.remove-item').off().click(function(e) {
                $(this).parent('td').parent('tr').remove(); //En accion elimino el Producto de la Tabla
                if ($('#serrSelected tr.item').length == 0)
                    $('#servSelected .no-item').slideDown(300); 
                RefrescaServicio();
            });        
           $('.iProduct').off().change(function(e) {
                RefrescaServicio();
           });
    }
    $('.nav-tabs a').click(function (e) {
        
        e.preventDefault();
        if($(this).closest('li').is('.active')) {  // PAUSA MANDAR OTRO QUERY CUNADO UN TAB ESTE ACTIVO
            return;
        }
        //Obtenemos la id del link que contiene el nombre del contenido que queremos mostrar
        
        //var ts = +new Date();
        //console.log(ts)
        var tabUrlAddress = $(this).attr('href');
        console.log('tabla'+' '+tabUrlAddress);
        var href = this.hash;
        console.log('href'+' '+href);
        var pane = $(this);
        console.log(pane);
        pane.show();

           // $(href).load(tabUrlAddress, function (result) {

           // });

    });
}); 
</script>