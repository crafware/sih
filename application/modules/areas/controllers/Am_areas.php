<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Am_areas
 *
 * @author bienTICS
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Am_areas extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        
        if($_SESSION['UMAE_AREA']=='Asistente Médica Quirófano'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_quirofanos, os_quirofanos_pacientes, os_quirofanos_salas, os_triage, os_llamadas
            WHERE 
            os_quirofanos_pacientes.qp_status='Ingreso' AND
            os_quirofanos_pacientes.triage_id=os_triage.triage_id AND
            os_quirofanos_pacientes.sala_id=os_quirofanos_salas.sala_id AND
            os_quirofanos_pacientes.qp_id=os_llamadas.tabla_id AND 
            os_llamadas.llamada_tipo='Quirófanos' AND
            os_quirofanos_salas.quirofano_id=os_quirofanos.quirofano_id ORDER BY os_llamadas.llamada_id DESC LIMIT 10");
            $this->load->view('areas_am/quirofano',$sql); 
        }else{
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_camas, os_areas_pacientes,os_areas_pacientes_llamada
                        WHERE
                        os_areas_pacientes.triage_id=os_triage.triage_id AND 
                        os_areas_pacientes.cama_id=os_camas.cama_id AND
                        os_areas_pacientes.ap_status='Ingreso' AND
                        os_areas_pacientes.ap_id=os_areas_pacientes_llamada.ap_id AND
                        os_areas_pacientes.area_id=".$this->SessionAreas()." ORDER BY os_areas_pacientes_llamada.llamada_id");
            $this->load->view('areas_am/index',$sql);    
        }
        
    }
    public function ObtenerPaciente() {
        $paciente= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $paciente_area= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id'),
            'area_id'=> $this->SessionAreas()
        ));
        $sql_camas= $this->config_mdl->_get_data_condition('os_camas',array(
            'area_id'=> $this->SessionAreas(),
            'cama_status'=>'Disponible'
        ));
        foreach ($sql_camas as $value) {
            $option.='<option value="'.$value['cama_id'].'">'.$value['cama_nombre'].'</option>';
        }
        if(!empty($paciente_area)){
            $paciente_area_cama= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
                'triage_id'=> $this->input->post('triage_id'),
                'area_id'=> $this->SessionAreas(),
                'ap_status'=>'Cama Asignada'
            ));
            if(!empty($paciente_area_cama)){
                $cama= $this->config_mdl->_get_data_condition('os_camas',array(
                    'cama_id'=> $paciente_area[0]['cama_id'],
                    'cama_status'=>'Disponible'
                ));
                if(!empty($cama)){
                    $this->setOutput(array('accion'=>'1','paciente'=>$paciente[0]));
                }else{
                    $this->setOutput(array('accion'=>'4','camas'=>$option,'ap_id'=>$paciente_area[0]['ap_id']));
                }
            }else{
                $this->setOutput(array('accion'=>'3'));
            }
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function IngresoPaciente($paciente) {
        $paciente_area= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $paciente,
            'area_id'=> $this->SessionAreas()
        ));
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_dh'=> $paciente
        ),array(
            'cama_id'=> $paciente_area[0]['cama_id']
        ));
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'ap_f_ingreso'=> date('d/m/Y'),
            'ap_h_ingreso'=> date('H:i'),
            'ap_status'=>'Ingreso',
            'empleado_id_ingreso'=>$_SESSION['UMAE_USER']
        ),array(
            'ap_id'=>$paciente_area[0]['ap_id']
        ));
        
        $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso a Pisos','triage_id'=>$paciente,'areas_id'=>$this->input->post('ap_id')));
        $this->setOutput(array('accion'=>'1'));
    }
    public function EgresoPaciente($id) {
        $info= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'ap_id'=>$id
        ));
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Disponible',
            'cama_dh'=>'0'
        ),array(
            'cama_id'=>$info[0]['cama_id']
        ));
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'ap_f_salida'=> date('d/m/Y'),
            'ap_h_salida'=> date('H:i'),
            'ap_status'=>'Egreso',
        ),array(
            'ap_id'=>$id
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function CambioCamaIngreso() {
        $info= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'ap_id'=>$this->input->post('ap_id')
        ))[0];
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_dh'=>$info['triage_id']
        ),array(
            'cama_id'=> $this->input->post('cama_id')
        ));
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'cama_id'=>$this->input->post('cama_id'),
            'ap_f_ingreso'=> date('d/m/Y'),
            'ap_h_ingreso'=> date('H:i'),
            'ap_status'=>'Ingreso',
        ),array(
            'ap_id'=>$this->input->post('ap_id')
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso a Pisos','triage_id'=>$info['triage_id'],'areas_id'=>$this->input->post('ap_id')));
        $this->setOutput(array('accion'=>'1'));
    }
    public function SessionAreas() {
        if($_SESSION['UMAE_AREA']=='Asistente Médica Cadera'){
            return 8;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica Femúr y Rodilla'){
            return 11;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica Fracturas Expuestas'){
            return 12;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica Pie y Tobillo'){
            return 14;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica Neurocirugía'){
            return 15;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica Columna'){
            return 16;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica CPR'){
            return 17;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica Maxilofacial'){
            return 18;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica Quemados '){
            return 19;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica Pediatría'){
            return 20;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica Corta Estancia'){
            return 21;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica Círugia General'){
            return 22;
        }if($_SESSION['UMAE_AREA']=='Asistente Médica Miembro Torácico'){
            return 13;
        }
    }
}
