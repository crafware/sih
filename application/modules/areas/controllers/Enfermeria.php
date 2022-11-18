<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Enfermeria
 *
 * @author bienTICS
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Enfermeria extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->view('Enfermeria/index');
    }
    public function ObtenerArea() {
        if($this->UMAE_AREA=='Enfermería Cadera'){
            return 8;
        }if($this->UMAE_AREA=='Enfermería Femúr y Rodilla'){
            return 11;
        }if($this->UMAE_AREA=='Enfermería Fracturas Expuestas'){
            return 12;
        }if($this->UMAE_AREA=='Enfermería Pie y Tobillo'){
            return 14;
        }if($this->UMAE_AREA=='Enfermería Neurocirugía'){
            return 15;
        }if($this->UMAE_AREA=='Enfermería Columna'){
            return 16;
        }if($this->UMAE_AREA=='Enfermería CPR'){
            return 17;
        }if($this->UMAE_AREA=='Enfermería Maxilofacial'){
            return 18;
        }if($this->UMAE_AREA=='Enfermería Quemados'){
            return 19;
        }if($this->UMAE_AREA=='Enfermería Pediatría'){
            return 20;
        }if($this->UMAE_AREA=='Enfermería Corta Estancia'){
            return 21;
        }if($this->UMAE_AREA=='Enfermería Círugia General'){
            return 22;
        }if($this->UMAE_AREA=='Enfermería Miembro Torácico'){
            return 13;
        }
    }
    /*FUNCIONES VIA AJAX*/
    public function AjaxCamas() {
        $Camas=  $this->config_mdl->_query("SELECT * FROM os_camas, os_areas WHERE os_camas.area_id=os_areas.area_id AND os_areas.area_id=".$this->ObtenerArea());
        if(!empty($Camas)){
            foreach ($Camas as $value) {
                $sql_paciente=  $this->config_mdl->_query("SELECT * FROM os_triage, os_areas_pacientes, os_camas WHERE 
                        os_areas_pacientes.triage_id=os_triage.triage_id AND
                        os_areas_pacientes.cama_id=os_camas.cama_id AND os_triage.triage_id=".$value['cama_dh']);
                
                $ColorStatus='';
                $Accion='';
                $Paciente='<br>';
                $Enfermera='<br>';
                $LimpiezaMantenimiento='';
                $Tarjeta='';
                $AltaPaciente='';
                $Asignado='';
                if($value["cama_status"]=="Disponible"){
                    $ColorStatus='blue';
                    $Accion='<button md-ink-ripple="" class="md-btn md-fab m-b green waves-effect tip btn-paciente-agregar" data-accion="Disponible" data-triage="0" data-area="'.$value['area_id'].'" data-cama="'.$value['cama_id'].'"  data-original-title="Agregar Paciente">
                                <i class="mdi-content-add i-24" ></i>
                            </button>';
                }else if($value["cama_status"]=="Ocupado"){
                    $ColorStatus='green';
                    $AltaPaciente='<li><a class="alta-paciente" data-alta="'.$sql_paciente[0]['observacion_alta'].'" data-cama="'.$value['cama_id'].'" data-triage="'.$sql_paciente[0]['triage_id'].'"><i class="fa fa-share-square-o icono-accion"></i> Alta Paciente</a></li>';
                    $sql_ti= $this->config_mdl->_get_data_condition('os_tarjeta_identificacion',array('triage_id'=>$sql_paciente[0]['triage_id']))[0];
                    $sQL_ENF= $this->config_mdl->_get_data_condition('os_empleados',array('empleado_id'=>$sql_paciente[0]['empleado_id_ingreso']))[0];
                    $Enfermera='<br><b style="margin-left: -13px;">ENF:</b>'.$sQL_ENF['empleado_nombre'].' '.$sQL_ENF['empleado_apellidos'].' <i class="fa fa-user-md pull-right pointer cambiar-enfermera i-16" style="margin-top:-3px" data-id="'.$sql_paciente[0]['triage_id'].'"></i>';
                    $Paciente='<b>PACIENTE: </b>'.$sql_paciente[0]['triage_nombre'];
                    $Tarjeta='<li><a href="" class="add-tarjeta-identificacion"  data-area="'.$value['area_id'].'" data-id="'.$sql_paciente[0]['triage_id'].'" data-enfermedad="'.$sql_ti['ti_enfermedades'].'" data-alergia="'.$sql_ti['ti_alergias'].'"><i class="fa fa-address-card-o icono-accion"></i> Tarjeta de Identificación</a></li>';
                    $CambiarCama='<li><a href="" class="cambiar-cama-paciente" data-id="'.$sql_paciente[0]['triage_id'].'" data-area="'.$value['area_id'].'" data-cama="'.$value['cama_id'].'"><i class="fa fa-bed icono-accion"></i> Cambiar Cama</a></li>';
                    $Expediente='<li><a href="'.  base_url().'Sections/Documentos/Expediente/'.$sql_paciente[0]['triage_id'].'/?tipo=Observación&url=Enfermeria" target="_blank"><i class="fa fa-files-o icono-accion"></i> Archivos Anexos</a></li>';
                    $Accion='<ul class="list-inline">
                                    <li class="dropdown">
                                        <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                            <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">'.$AltaPaciente.' '.$CambiarCama.' '.$Tarjeta.' '.$Expediente.' '.$LimpiezaMantenimiento.'</ul>
                                    </li>
                                </ul>';
                }else if($value["cama_status"]=="Asignado"){
                    $sql_ti= $this->config_mdl->_get_data_condition('os_tarjeta_identificacion',array('triage_id'=>$sql_paciente[0]['triage_id']))[0];
                    $sQL_ENF= $this->config_mdl->_get_data_condition('os_empleados',array('empleado_id'=>$sql_paciente[0]['empleado_id_ingreso']))[0];
                    $Enfermera='<br><b style="margin-left: -13px;">ENF:</b>'.$sQL_ENF['empleado_nombre'].' '.$sQL_ENF['empleado_apellidos'];
                    $Paciente='<b>PACIENTE: </b>'.$sql_paciente[0]['triage_nombre'];
                    $Accion='<button md-ink-ripple="" class="md-btn md-fab m-b red waves-effect tip btn-paciente-agregar" data-cama="'.$value['cama_id'].'" data-area="'.$value['area_id'].'" data-accion="Asignado" data-triage="'.$sql_paciente[0]['triage_id'].'" data-original-title="Agregar Paciente">
                                <i class="mdi-content-add i-24" ></i>
                            </button>';
                    $ColorStatus='green';
                    $Asignado='<span class="label red">Asignado/Reservado</span>';
                }else if($value["cama_status"]=="Descompuesta"){
                    $ColorStatus='';
                }else if($value["cama_status"]=="En Limpieza"){
                    $ColorStatus='orange';
                    $LimpiezaMantenimiento='<li><a class="finalizar-mantenimiento" data-id="'.$value['cama_id'].'"><i class="fa fa-wrench icono-accion"></i> Finalizar Limpieza</a></li>';
                }else if($value["cama_status"]=="En Mantenimiento"){
                    $ColorStatus='red';
                    $LimpiezaMantenimiento='<li><a class="finalizar-mantenimiento" data-id="'.$value['cama_id'].'"><i class="fa fa-wrench icono-accion"></i> Finalizar Mantenimiento</a></li>';
                }
                $col_md_3.='<div class="col-md-4 cols-camas" style="padding: 3px;margin-top:-10px">
                                    <div class="card '.$ColorStatus.' color-white">
                                        <div class="row" style="background: #256659!important;padding: 4px 2px 2px 12px;width: 100%;margin-left: 0px;">
                                            <div class="col-md-12" style="padding-left:0px;"><b style="text-transform:uppercase;font-size:10px"><i class="fa fa-window-restore"></i> '.$value['area_nombre'].'</b></div>
                                        </div>
                                        <div class="card-heading" >
                                            <h5 class="font-thin color-white" style="font-size:19px!important;margin-left: -15px;margin-top: -10px;text-transform: uppercase">
                                                <i class="fa fa-bed " ></i> <b>'.$value['cama_nombre'].'</b>
                                            </h5>
                                            <div class="row" style="margin-top:-10px">
                                                <div class="col-md-8" style="margin-left: -14px;">
                                                    <small style="opacity: 1;font-size: 11px"> 
                                                        <i class="fa fa-address-book-o"></i> '.$value['cama_status'].' '.$Asignado.'
                                                    </small>
                                                </div>
                                                <div class="col-md-4" >
                                                    <small style="opacity: 1;font-size: 11px;position:absolute;top: 0px;right: 0px"> 
                                                        '.$value['cama_ingreso_f'].' '.$sql_paciente[0]['cama_ingreso_h'].'
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-tools" style="right:2px;top:2px">'.$Accion.'</div>
                                        <div class="card-divider" style="margin-top:-10px"></div>
                                        <div class="card-body" style="margin-top:-20px;padding-bottom: 6px;">
                                            <span style="font-size: 9px;margin-left: -13px;">'.$Paciente.' '.$Enfermera.'</span>
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
        foreach ($this->config_mdl->_query("SELECT * FROM os_areas WHERE os_areas.area_id BETWEEN 7 AND 23") as $value) {
            $option.='<option value="'.$value['area_id'].'">'.$value['area_nombre'].'</option>';
        }
        if(!empty($sql)){
                if($sql[0]['cama_id']==''){
                    $this->setOutput(array('accion'=>'1','option'=>$option));
                }else{
                    if($sql[0]['ap_status']=='Ingreso'){
                        $this->setOutput(array('accion'=>'4','option'=>$option));
                    }else if($sql[0]['ap_status']=='Asignado'){
                        $this->setOutput(array('accion'=>'1','option'=>$option));
                    }else{
                        $this->setOutput(array('accion'=>'5','option'=>$option));
                    }
                }
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
            $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$info['ap_id']));
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
                'area_id'=> $this->ObtenerArea(),
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
            'cama_status'=>'Disponible',
            'cama_dh'=>'0',
            'cama_ingreso_f'=>'',
            'cama_ingreso_h'=> '',
        ),array(
            'cama_id'=>  $this->input->post('cama_id_old')
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
            'estado_tipo'=>'Disponible',
            'cama_id'=> $this->input->post('cama_id_old'),
            'triage_id'=> $this->input->post('triage_id')
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
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxCambiarEnfermera() {
        $sql= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(!empty($sql)){
            $areas= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
                'triage_id'=>  $this->input->post('triage_id'),
                'area_id'=> $this->ObtenerArea()
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
                'area_id'=> $this->ObtenerArea(),
                'triage_id'=>  $this->input->post('triage_id')
            ));
            $this->AccesosUsuarios(array('acceso_tipo'=>'Cambio de Enfermera'.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$areas['ap_id']));
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
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'area_id'=> $this->ObtenerArea(),
            'ap_f_salida'=> date('d/m/Y'),
            'ap_h_salida'=>  date('H:i') ,
            'ap_status'=>'Salida'
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'En Limpieza',
            'cama_ingreso_f'=> '',
            'cama_ingreso_h'=> '',
            'cama_dh'=>0,
        ),array(
            'cama_id'=>  $this->input->post('cama_id')
        ));
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
}
