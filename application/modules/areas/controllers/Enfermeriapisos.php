<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pisos
 *
 * @author bienTICS
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Enfermeriapisos extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->view('EnfermeriaPisos/index');
    }
    public function ObtenerPisos() {
        if($this->UMAE_AREA=='Piso 1A'){
            return 1;
        }if($this->UMAE_AREA=='Piso 2A'){
            return 2;
        }if($this->UMAE_AREA=='Piso 3A'){
            return 3;
        }if($this->UMAE_AREA=='Piso 4A'){
            return 4;
        }if($this->UMAE_AREA=='Piso 1B'){
            return 5;
        }if($this->UMAE_AREA=='Piso 1B UCI'){
            return 6;
        }if($this->UMAE_AREA=='Piso 1B UTM'){
            return 7;
        }if($this->UMAE_AREA=='Piso 1B UTR'){
            return 8;
        }if($this->UMAE_AREA=='Piso 2B S'){
            return 9;
        }if($this->UMAE_AREA=='Piso 2B N'){
            return 10;
        }
        
    }
    /*FUNCIONES VIA AJAX*/
    public function AjaxCamas() {
        $Camas=  $this->config_mdl->_query("SELECT * FROM os_camas, os_pisos, os_pisos_camas, os_areas
                                            WHERE
                                            os_areas.area_id=os_camas.area_id AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id AND
                                            os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_pisos.piso_id=".$this->ObtenerPisos()." ORDER BY os_camas.cama_id ASC");
        if(!empty($Camas)){
            foreach ($Camas as $value) {
                $sql_paciente=  $this->config_mdl->_query("SELECT * FROM os_triage, os_areas_pacientes, os_camas WHERE 
                        os_areas_pacientes.triage_id=os_triage.triage_id AND
                        os_areas_pacientes.cama_id=os_camas.cama_id AND os_triage.triage_id=".$value['cama_dh']);
                $Paciente='<br><br>';
                $Enfermera='';
                $Accion='';
                $Limpieza_Mantenimiento='';
                $Tarjeta='';
                $CambiarCama='';
                $AccionCambioE='';
                $Status='';
                $ReportarDescompuesta='';
                if($value['cama_status']=='Disponible'){
                    $CamaStatus='blue';
                    $Accion='<button md-ink-ripple="" class="md-btn md-fab m-b green waves-effect tip btn-paciente-agregar" data-triage="0" data-status="Disponible" data-cama="'.$value['cama_id'].'" data-area="'.$value['area_id'].'" data-original-title="Agregar Paciente">
                                <i class="mdi-content-add i-24" ></i>
                            </button>';
                    
                    $area=$value['cama_status'];
                }else if($value['cama_status']=='Asignado'){
                    $CamaStatus='green';
                    $Accion='<button md-ink-ripple="" class="md-btn md-fab m-b green waves-effect tip btn-paciente-agregar" data-cama="'.$value['cama_id'].'" data-triage="'.$sql_paciente[0]['triage_id'].'" data-area="'.$value['area_id'].'" data-status="Asignado"  data-original-title="Agregar Paciente">
                                <i class="mdi-content-add i-24" ></i>
                            </button>';
                    $sql_enf= $this->config_mdl->_get_data_condition('os_empleados',array('empleado_id'=>$sql_paciente[0]['empleado_id_ingreso']))[0];
                    if($sql_paciente[0]['ap_area']!=''){
                        $sql_area= $this->config_mdl->_query("SELECT * FROM os_areas WHERE area_id=".$sql_paciente[0]['ap_area'])[0];
                        $ap_area='<span style="text-transform:uppercase;">&nbsp;<b>'.$sql_area['area_nombre'].'</b></span>';
                    }else{
                        $ap_area='<span style="text-transform:uppercase;">&nbsp;<b>Sin Especificar </b></span>';
                    }
                    if(strlen($sql_paciente[0]['triage_nombre'])>30){
                        $triage_nombre= substr($sql_paciente[0]['triage_nombre'].' '.$sql_paciente[0]['triage_nombre_ap'].' '.$sql_paciente[0]['triage_nombre'],0, 30).'...';
                    }else{
                        $triage_nombre=$sql_paciente[0]['triage_nombre'].' '.$sql_paciente[0]['triage_nombre_ap'].' '.$sql_paciente[0]['triage_nombre_am'];
                    }
                    $area='&nbsp;<span class="label red">Asignado</span>';
                        $Paciente='PACIENTE: '.$triage_nombre.'<br>';
                        $Enfermera='ENF: '.$sql_enf['empleado_nombre'].' '.$sql_enf['empleado_apellidos'].' <i class="fa fa-user-md pull-right pointer cambiar-enfermera i-16" style="margin-top:-3px" data-area="'.$sql_paciente[0]['ap_area'].'" data-id="'.$sql_paciente[0]['triage_id'].'"></i>';
                        
                }else if($value['cama_status']=='En Mantenimiento'){
                    $CamaStatus='red';
                    $Limpieza_Mantenimiento='<li><a class="finalizar-mantenimiento" data-id="'.$value['cama_id'].'"><i class="fa fa-wrench icono-accion"></i> Finalizar Limpieza / Mantenimiento</a></li>';
                    $area=$value['cama_status'];
                    $Accion='<ul class="list-inline">
                                <li class="dropdown">
                                    <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                        <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">'.$Limpieza_Mantenimiento.'</ul>
                                </li>
                            </ul>';
                }else if($value['cama_status']=='En Limpieza'){
                    $CamaStatus='orange';
                    $Limpieza_Mantenimiento='<li><a class="finalizar-mantenimiento" data-id="'.$value['cama_id'].'"><i class="fa fa-wrench icono-accion"></i> Finalizar Limpieza / Mantenimiento</a></li>';
                    $area=$value['cama_status'];
                    $Accion='<ul class="list-inline">
                                <li class="dropdown">
                                    <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                        <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">'.$Limpieza_Mantenimiento.'</ul>
                                </li>
                            </ul>';
                }else if($value['cama_status']=='Ocupado' || $value['cama_status']=='Descompuesta'){
                    if($value['cama_status']=='Ocupado'){
                        $CamaStatus='green';
                        $ReportarDescompuesta='<li><a href="" class="reportar-cama-descompuesta" data-id="'.$sql_paciente[0]['triage_id'].'" data-piso="'.$value['piso_id'].'" data-cama="'.$value['cama_id'].'"><i class="fa fa fa-wrench icono-accion"></i> Reportar como descompuesta</a></li>';
                    }else if($value['cama_status']=='Descompuesta'){
                        $Status='<i class="fa fa-exclamation-triangle mensaje-cama-decompuesta pointer"></i>';
                        $CamaStatus='red';
                    }
                    
                    $sql_ti= $this->config_mdl->_get_data_condition('os_tarjeta_identificacion',array('triage_id'=>$sql_paciente[0]['triage_id']))[0];
                        $sql_enf= $this->config_mdl->_get_data_condition('os_empleados',array('empleado_id'=>$sql_paciente[0]['empleado_id_ingreso']))[0];
                        if($sql_paciente[0]['ap_area']!=''){
                            $sql_area= $this->config_mdl->_query("SELECT * FROM os_areas WHERE area_id=".$sql_paciente[0]['ap_area'])[0];
                            $ap_area='<span style="text-transform:uppercase;">&nbsp;<b>'.$sql_area['area_nombre'].'</b></span>';
                        }else{
                            $ap_area='<span style="text-transform:uppercase;">&nbsp;<b>Sin Especificar </b></span>';
                        }
                        if(strlen($sql_paciente[0]['triage_nombre'])>30){
                            $triage_nombre= substr($sql_paciente[0]['triage_nombre'].' '.$sql_paciente[0]['triage_nombre_ap'].' '.$sql_paciente[0]['triage_nombre_am'],0, 30).'...';
                        }else{
                            $triage_nombre=$sql_paciente[0]['triage_nombre'].' '.$sql_paciente[0]['triage_nombre_ap'].' '.$sql_paciente[0]['triage_nombre_am'];
                        }
                        $area=$ap_area.'&nbsp;<i class="fa fa-pencil pointer cambiar-area" data-id="'.$sql_paciente[0]['ap_id'].'"></i>';
                        $Paciente='PACIENTE: '.$triage_nombre.'<br>';
                        $Enfermera='ENF: '.$sql_enf['empleado_nombre'].' '.$sql_enf['empleado_apellidos'].' <i class="fa fa-user-md pull-right pointer cambiar-enfermera i-16" style="margin-top:-3px" data-area="'.$sql_paciente[0]['ap_area'].'" data-id="'.$sql_paciente[0]['triage_id'].'"></i>';
                        $alta='<li><a class="alta-paciente" data-area="'.$value['area_id'].'" data-alta="'.$sql_paciente[0]['observacion_alta'].'" data-cama="'.$value['cama_id'].'" data-triage="'.$sql_paciente[0]['triage_id'].'"><i class="fa fa-share-square-o icono-accion"></i> Alta Paciente</a></li>';
                        $Tarjeta='<li><a href="" class="add-tarjeta-identificacion"  data-area="'.$sql_paciente[0]['ap_area'].'" data-id="'.$sql_paciente[0]['triage_id'].'" data-enfermedad="'.$sql_ti['ti_enfermedades'].'" data-alergia="'.$sql_ti['ti_alergias'].'"><i class="fa fa-address-card-o icono-accion"></i> Tarjeta de Identificación</a></li>';
                        $CambiarCama='<li><a href="" class="cambiar-cama-paciente" data-id="'.$sql_paciente[0]['triage_id'].'" data-area="'.$sql_paciente[0]['ap_area'].'" data-cama="'.$value['cama_id'].'"><i class="fa fa-bed icono-accion"></i> Cambiar Cama</a></li>';
                        
                        $list='<li><a href="'.  base_url().'Sections/Documentos/Expediente/'.$sql_paciente[0]['triage_id'].'/?tipo=Observación&url=Enfermeria" target="_blank"><i class="fa fa-files-o icono-accion"></i> Archivos Anexos</a></li>';
                        $Accion='<ul class="list-inline">
                                <li class="dropdown">
                                    <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                        <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">'.$alta.' '.$list.' '.$Limpieza_Mantenimiento.' '.$Tarjeta.' '.$CambiarCama.' '.$ReportarDescompuesta.'</ul>
                                </li>
                            </ul>';
                }else if($value['cama_status']=='En Espera'){
                    $AccionCambioE='hidden';
                    $Status='<i class="fa fa-exclamation-triangle pointer envio-qrirofano" style="color:white"></i>';
                    $Paciente='PACIENTE: '.$triage_nombre.'<br>';
                    $Enfermera='ENF: '.$sql_enf['empleado_nombre'].' '.$sql_enf['empleado_apellidos'].' <i class="fa fa-user-md pull-right pointer cambiar-enfermera i-16 '.$AccionCambioE.'" style="margin-top:-3px" data-area="'.$sql_paciente[0]['ap_area'].'" data-id="'.$sql_paciente[0]['triage_id'].'"></i>';
                    $CamaStatus='blue-grey-700';
                    $Accion='<button md-ink-ripple="" class="md-btn md-fab m-b red waves-effect tip btn-paciente-reingreso" data-id="'.$sql_paciente[0]['triage_id'].'" data-cama="'.$value['cama_id'].'"  data-original-title="Reingreso Paciente">
                                <i class="fa fa-sign-in i-24" ></i>
                            </button>';                    

                }
                if($value['cama_genero']=='Mujer'){
                    $CamaGenero='<i class="fa fa-female"></i>';
                }else{
                    $CamaGenero='<i class="fa fa-male"></i>';
                }
                $col_md_3.='<div class="col-md-4 cols-camas" style="padding: 3px;margin-top:-10px">
                                
                                <div class="card '.$CamaStatus.' color-white" style="border-radius:3px">
                                    <div class="row" style="    background: #256659!important;padding: 4px 2px 2px 12px;width: 100%;margin-left: 0px;">
                                        <div class="col-md-6" style="padding-left:0px;"><b style="text-transform:uppercase;font-size:10px"><i class="fa fa-window-restore"></i> '.$value['area_nombre'].'</b></div>
                                        <div class="col-md-6" "><b style="text-transform:uppercase;font-size:10px">'.$CamaGenero.' '.$value['cama_genero'].'</b></div>
                                    </div>
                                    <div class="card-heading" style="margin-top:-10px">
                                        <h5 class="font-thin color-white" style="font-size:19px!important;margin-left: -10px;margin-top: 0px;text-transform: uppercase">
                                            <i class="fa fa-bed " ></i> <b>'.$value['cama_nombre'].' '.$Status.'</b>
                                        </h5>
                                        <div class="row">
                                            <div class="col-md-12" style="margin-left: -10px;margin-top:-9px">
                                                <small style="opacity: 1;font-size: 10px"> 
                                                    <b class="text-left"><i class="fa fa-address-book-o"></i> '.$area.'&nbsp;&nbsp;&nbsp;&nbsp;</b>
                                                    <b class="text-right pull-right"> '.$sql_paciente[0]['ap_f_ingreso'].' '.$sql_paciente[0]['ap_h_ingreso'].'</b>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-tools" style="right:2px;top:2px">'.$Accion.'</div>
                                    <div class="card-divider" style="margin-top:-10px"></div>
                                    <div class="card-body" style="margin-top:-20px;margin-left:-11px">
                                        <span style="font-size:10px">
                                         '.$Paciente.''.$Enfermera.'
                                        </span>
                                    </div>
                                </div>
                            </div>';
                $col_md_3.='';
            }
        }else{
            $col_md_3='NO_HAY_CAMAS';
        }
        $this->setOutput(array('result_camas'=>$col_md_3));
    }
    public function AjaxObtenerPaciente() {
        $sql= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $option='';
        foreach ($this->config_mdl->_query("SELECT * FROM os_areas WHERE os_areas.area_id BETWEEN 2 AND 16") as $value) {
            $option.='<option value="'.$value['area_id'].'">'.$value['area_nombre'].'</option>';
        }
        if(!empty($sql)){
            //if($sql[0]['area_id']== $this->ObtenerArea()){
                if($sql[0]['cama_id']==''){
                    $this->setOutput(array('accion'=>'1','option'=>$option));
                }else{
                    if($sql[0]['ap_status']=='Ingreso'){
                        $this->setOutput(array('accion'=>'4','option'=>$option));
                    }if($sql[0]['ap_status']=='Asignado'){
                        $this->setOutput(array('accion'=>'1','option'=>$option));
                    }else{
                        $this->setOutput(array('accion'=>'5','option'=>$option));
                    }
                }
//            }else{
//                $this->setOutput(array('accion'=>'3'));
//            }
        }else{
            $this->setOutput(array('accion'=>'2','option'=>$option));
        }
    }
    public function AjaxAsociarCama() {
        $empleado= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(!empty($empleado)){
            $data=array(
                'ap_f_ingreso'=> date('d/m/Y'),
                'ap_h_ingreso'=> date('H:i'),
                'ap_status'=>'Ingreso',
                'ap_origen'=> $this->input->post('ap_origen'),
                'ap_area'=> $this->input->post('ap_area'),
                'area_id'=> $this->input->post('ap_area'),
                'cama_id'=> $this->input->post('cama_id'),
                'empleado_id'=> $this->UMAE_USER,
                'empleado_id_ingreso'=> $empleado[0]['empleado_id'],
                'triage_id'=> $this->input->post('triage_id')
            );
            $this->config_mdl->_update_data('os_areas_pacientes',$data,array(
                'triage_id'=> $this->input->post('triage_id')
            ));
            $this->config_mdl->_update_data('os_camas',array(
                'cama_status'=>'Ocupado',
                'cama_ingreso_f'=> date('d/m/Y'),
                'cama_ingreso_h'=> date('H:i'),
                'cama_dh'=>$this->input->post('triage_id')
            ),array(
                'cama_id'=>  $this->input->post('cama_id')
            ));
            Modules::run('Pisos/Camas/LogCamas',array(
                'estado_tipo'=>'Ocupado',
                'cama_id'=> $this->input->post('cama_id'),
                'triage_id'=> $this->input->post('triage_id')
            ));
            $info= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
                'triage_id'=> $this->input->post('triage_id')
            ))[0];
            $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$info['ap_id']));
            $this->setOutput(array('accion'=>'1'));
        
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxAsociarCamaAH() {
        $empleado= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(!empty($empleado)){
            $data=array(
                'ap_f_ingreso'=> date('d/m/Y'),
                'ap_h_ingreso'=> date('H:i'),
                'ap_status'=>'Ingreso',
                'ap_origen'=> $this->input->post('ap_origen'),
                'ap_area'=> $this->input->post('ap_area'),
                'area_id'=> $this->input->post('ap_area'),
                'cama_id'=> $this->input->post('cama_id'),
                'empleado_id'=> $this->UMAE_USER,
                'empleado_id_ingreso'=> $empleado[0]['empleado_id'],
                'triage_id'=> $this->input->post('triage_id')
            );
            $this->config_mdl->_update_data('os_areas_pacientes',$data,array(
                'triage_id'=> $this->input->post('triage_id')
            ));
            $this->config_mdl->_update_data('os_camas',array(
                'cama_status'=>'Ocupado',
                'cama_ingreso_f'=> date('d/m/Y'),
                'cama_ingreso_h'=> date('H:i'),
                'cama_dh'=>$this->input->post('triage_id')
            ),array(
                'cama_id'=>  $this->input->post('cama_id')
            ));
            Modules::run('Pisos/Camas/LogCamas',array(
                'estado_tipo'=>'Ocupado',
                'cama_id'=> $this->input->post('cama_id'),
                'triage_id'=> $this->input->post('triage_id')
            ));
            $info= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
                'triage_id'=> $this->input->post('triage_id')
            ))[0];
            $this->UMAE_LOG(array(
                'table'=>'log_pisos',
                'log_tipo'=>'Ingreso '.$this->UMAE_AREA,
                'triage_id'=>$this->input->post('triage_id'),
                'areas_id'=>$info['ap_id']
            ));
            if($this->input->post('accion')=='Cambio'){
                $asignacion_estatus='Nuevo Paciente Asignado';
                $triage_id_new= $this->input->post('triage_id');
            }else{
                $asignacion_estatus='Ingreso y Asignación de Cama';
                $triage_id_new= 0;
            }
            $this->config_mdl->_insert('os_areas_pacientes_asignaciones',array(
                'asignacion_fecha'=> date('d/m/Y'),
                'asignacion_hora'=> date('H:i'),
                'asignacion_estatus'=>$asignacion_estatus,
                'cama_id'=> $this->input->post('cama_id'),
                'empleado_id'=>$empleado[0]['empleado_id'],
                'empleado_asigna'=> $this->UMAE_USER,
                'triage_id'=> $this->input->post('triage_id_old'),
                'triage_id_new'=> $triage_id_new

            ));
            $this->AccesosUsuarios(array('acceso_tipo'=>'Asignación de Cama via AH ','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$info['ap_id']));
            $this->setOutput(array('accion'=>'1'));
        
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxAgregarPaciente() {
        $sql= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(!empty($sql)){
            $data=array(
                //'area_id'=> $this->input->post('area_id'),
                'triage_id'=> $this->input->post('triage_id'),
                'empleado_id'=> $this->UMAE_USER,
            );
            $this->config_mdl->_insert('os_areas_pacientes',$data);
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxCambiarCama() {
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'En Limpieza',
            'cama_dh'=>0,
            'cama_ingreso_f'=> '',
            'cama_ingreso_h'=> '',
        ),array(
            'cama_id'=>  $this->input->post('cama_id_old')
        ));
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'Disponible',
            'cama_id'=> $this->input->post('cama_id_old'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_ingreso_f'=> date('d/m/Y'),
            'cama_ingreso_h'=> date('H:i'),
            'cama_dh'=> $this->input->post('triage_id')
        ),array(
            'cama_id'=>  $this->input->post('cama_id_new')
        ));
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'Ocupado',
            'cama_id'=> $this->input->post('cama_id_new'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'cama_id'=>  $this->input->post('cama_id_new'),
            'ap_f_ingreso'=> date('d/m/Y'),
            'ap_h_ingreso'=>  date('H:i') 
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_insert('os_camas_log',array(
            'cama_log_fecha'=> date('d/m/Y'),
            'cama_log_hora'=> date('H:i'),
            'cama_log_tipo'=>'Cambio de Cama',
            'cama_log_modulo'=> $this->UMAE_AREA,
            'cama_id'=> $this->input->post('cama_id_new'),
            'triage_id'=> $this->input->post('triage_id'),
            'empleado_id'=> $this->UMAE_USER
        ));
        $info= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->AccesosUsuarios(array('acceso_tipo'=>'Cambio de Cama '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$info['ap_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxCambiarEnfermera() {
        $sql= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(!empty($sql)){
            $areas= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
                'triage_id'=>  $this->input->post('triage_id'),
                'area_id'=> $this->input->post('area_id')
            ))[0];
            $this->config_mdl->_insert('os_log_cambio_enfermera',array(
                'cambio_fecha'=> date('d/m/Y'),
                'cambio_hora'=> date('H:i'),
                'cambio_modulo'=> $this->UMAE_AREA,
                'cambio_cama'=>$areas['cama_id'],
                'empleado_new'=> $sql[0]['empleado_id'],
                'empleado_old'=> $areas['empleado_id_ingreso'],
                'empleado_cambio'=> $this->UMAE_USER,
                'triage_id'=>$this->input->post('triage_id')
            ));
            
            $this->config_mdl->_update_data('os_areas_pacientes',array(
                'empleado_id_ingreso'=>$sql[0]['empleado_id']
            ),array(
                'area_id'=> $this->input->post('area_id'),
                'triage_id'=>  $this->input->post('triage_id')
            ));
            $this->AccesosUsuarios(array('acceso_tipo'=>'Cambio Enfermera '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$areas['ap_id']));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxAltaPaciente() {
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'ap_alta'=>  $this->input->post('ap_alta')
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        if($this->input->post('ap_alta')=='Alta e ingreso quirófano'){
            $this->config_mdl->_update_data('os_camas',array(
                'cama_status'=>'En Espera',
            ),array(
                'cama_id'=>  $this->input->post('cama_id')
            ));
        }else{
            $this->config_mdl->_update_data('os_areas_pacientes',array(
                'area_id'=> $this->input->post('area_id'),
                'ap_f_salida'=> date('d/m/Y'),
                'ap_h_salida'=>  date('H:i') ,
                'ap_status'=>'Salida'
            ),array(
                'triage_id'=>  $this->input->post('triage_id')
            ));
            $this->config_mdl->_update_data('os_camas',array(
                'cama_status'=>'En Limpieza',
                'cama_dh'=>0,
                'cama_ingreso_f'=> '',
                'cama_ingreso_h'=> '',
            ),array(
                'cama_id'=>  $this->input->post('cama_id')
            ));
        }
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'En Limpieza',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $areas= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->EgresoCamas($egreso=array(
            'cama_egreso_cama'=>$this->input->post('cama_id'),
            'cama_egreso_destino'=>$this->input->post('ap_alta'),
            'cama_egreso_table'=>'os_areas_pacientes',
            'cama_egreso_table_id'=>$areas['ap_id'],
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Egreso '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$areas['ap_id']));
        
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxReingreso() {
        $data=array(
            'ap_f_ingreso'=>'',
            'ap_h_ingreso'=>'',
            'ap_f_salida'=>'',
            'ap_h_salida'=>'',
            'ap_status'=>'',
            'ap_origen'=>'',
            'ap_alta'=>'',
            //'area_id'=>0,
            'cama_id'=>0,
            'empleado_id'=>0,
            'empleado_id_ingreso'=>0
        );
        $this->config_mdl->_update_data('os_areas_pacientes',$data,array(
           'triage_id'=> $this->input->post('triage_id') 
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxObtenerAreas() {
        $option='';
        foreach ($this->config_mdl->_query("SELECT * FROM os_areas WHERE os_areas.area_id BETWEEN 7 AND 23") as $value) {
            $option.='<option value="'.$value['area_id'].'">'.$value['area_nombre'].'</option>';
        }
        $this->setOutput(array('option'=>$option));
    }
    public function AjaxCambiarArea() {
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'ap_area'=> $this->input->post('area_id')
        ),array(
            'ap_id'=> $this->input->post('ap_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxObtenerCamas() {
        $Camas=  $this->config_mdl->_query("SELECT * FROM os_camas, os_pisos, os_pisos_camas, os_areas
                                            WHERE
                                            os_camas.cama_status='Disponible' AND
                                            os_areas.area_id=os_camas.area_id AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id AND
                                            os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_pisos.piso_id=".$this->ObtenerPisos());
        foreach ($Camas as $value) {
            $option.='<option value="'.$value['cama_id'].'">'.$value['cama_nombre'].'</option>';
        }
        $this->setOutput(array('option'=>$option));
    }
    public function AjaxReingresoPisos() {
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_dh'=> $this->input->post('triage_id'),
            'cama_ingreso_f'=> date('d/m/Y'),
            'cama_ingreso_h'=> date('H:i'),
        ),array(
            'cama_id'=>  $this->input->post('cama_id')
        ));
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'En Limpieza',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'ap_f_ingreso'=> date('d/m/Y'),
            'ap_h_ingreso'=>  date('H:i') ,
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $areas= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->AccesosUsuarios(array('acceso_tipo'=>'Reingreso '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$areas['ap_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxReportarDescompuesta() {
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Descompuesta'
        ),array(
            'cama_id'=> $this->input->post('cama_id')
        ));
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'Descompuesta',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
}
