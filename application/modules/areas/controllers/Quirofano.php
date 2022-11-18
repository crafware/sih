<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Quirofano
 *
 * @author bienTICS
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Quirofano extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $sql['Gestion']= $this->config_mdl->_get_data('os_quirofanos');
        $this->load->view('quirofano/index',$sql);
    }
    public function AgregarQuirofano() {
        $data=array(
            'quirofano_nombre'=> $this->input->post('quirofano_nombre')
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('os_quirofanos',$data);
        }else{
            $this->config_mdl->_update_data('os_quirofanos',$data,array(
                'quirofano_id'=> $this->input->post('quirofano_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function GestionSalas($Quirofano) {
        $sql['Gestion']= $this->config_mdl->_get_data_condition('os_quirofanos_salas',array(
            'quirofano_id'=>$Quirofano
        ));
        $sql['info']= $this->config_mdl->_get_data_condition('os_quirofanos',array(
            'quirofano_id'=>$Quirofano
        ))[0];
        $this->load->view('quirofano/salas',$sql);
    }
    public function TotalSalas($data) {
        $sql=$this->config_mdl->_query("SELECT * FROM os_quirofanos_salas WHERE os_quirofanos_salas.quirofano_id=".$data['quirofano_id']);
        if(empty($sql)){
            return 0;
        }else{
            return count($sql);
        }
    }
    public function AgregarSala() {
        $data=array(
            'sala_nombre'=> $this->input->post('sala_nombre'),
            'quirofano_id'=> $this->input->post('quirofano_id')
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('os_quirofanos_salas',$data);
        }else{
            $this->config_mdl->_update_data('os_quirofanos_salas',$data,array(
                'sala_id'=> $this->input->post('sala_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function EliminarQuirofano($Quirifano) {
        $this->config_mdl->_delete_data('os_quirofanos',array(
            'quirofano_id'=>$Quirifano
        ));
        $this->config_mdl->_delete_data('os_quirofanos_salas',array(
            'quirofano_id'=>$Quirifano
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function EliminarSala($sala) {
        $this->config_mdl->_delete_data('os_quirofanos_salas',array(
            'sala_id'=>$sala
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function ObtenerPaciente() {
        $sql= $this->config_mdl->_get_data_condition('os_quirofanos_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $info= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(!empty($sql)){
            if($sql[0]['qp_status']=='Sala Asignada'){
                $this->setOutput(array('accion'=>'2','paciente'=>$info[0]));
            }if($sql[0]['qp_status']=='Ingreso'){
                $this->setOutput(array('accion'=>'3'));
            }if($sql[0]['qp_status']=='Salida'){
                $this->setOutput(array('accion'=>'4'));
            }
        }else{
            $this->setOutput(array('accion'=>'1'));
        }
    }
    public function JefeQuirofanos() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_quirofanos, os_quirofanos_pacientes, os_quirofanos_salas, os_triage, os_llamadas
            WHERE 
            os_quirofanos_pacientes.triage_id=os_triage.triage_id AND
            os_quirofanos_pacientes.sala_id=os_quirofanos_salas.sala_id AND
            os_quirofanos_pacientes.qp_id=os_llamadas.tabla_id AND 
            os_llamadas.llamada_tipo='Quirófanos' AND
            os_quirofanos_salas.quirofano_id=os_quirofanos.quirofano_id ORDER BY os_llamadas.llamada_id DESC LIMIT 10");
        $this->load->view("quirofano/JefeQuirofanos",$sql);
    }
    public function ObtenerPacienteJQ() {
        $quirofanos= $this->config_mdl->_get_data('os_quirofanos');
        $option.='<option value="">Seleccionar Quirófano</option>';
        foreach ($quirofanos as $value) {
            $option.='<option value="'.$value['quirofano_id'].'">'.$value['quirofano_nombre'].'</option>';
        }
        $sql_check= $this->config_mdl->_get_data_condition('os_quirofanos_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $salas_asignadas= $this->config_mdl->_get_data_condition('os_quirofanos_pacientes',array(
            'qp_status'=>'Sala Asignada'
        ));
        if(empty($sql_check)){
            $this->setOutput(array('accion'=>'1','option'=>$option,'salas'=>$salas_asignadas));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function ObtenerSalas($Quirofano) {
        $sql= $this->config_mdl->_get_data_condition('os_quirofanos_salas',array(
            'quirofano_id'=>$Quirofano
        ));
        $option.='<option value="">Seleccionar Sala</option>';
        foreach ($sql as $value) {
            $option.='<option value="'.$value['sala_id'].'">'.$value['sala_nombre'].'</option>';
        }
        $this->setOutput(array('option'=>$option));
    }
    public function AsignarSala() {
        $data=array(
            'qp_status'=>'Sala Asignada',
            'sala_id'=> $this->input->post('sala_id') ,
            'triage_id'=> $this->input->post('triage_id')
        );
        $this->config_mdl->_insert('os_quirofanos_pacientes',$data);
        $max_id= $this->config_mdl->_get_last_id('os_quirofanos_pacientes','qp_id');
        $this->config_mdl->_insert('os_llamadas',array(
            'llamada_tipo'=>'Quirófanos',
            'tabla_id'=>$max_id
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function IngresoPaciente($paciente) {
        $info= $this->config_mdl->_get_data_condition('os_quirofanos_pacientes',array(
            'triage_id'=>$paciente
        ))[0];
        $sql_sala= $this->config_mdl->_get_data_condition('os_quirofanos_salas',array(
            'sala_id'=>$info['sala_id'],
            'sala_status'=>''
        ));
        if(empty($sql_sala)){
            $this->config_mdl->_update_data('os_quirofanos_pacientes',array(
                'qp_status'=>'Ingreso',
                'qp_f_entrada'=> date('d/m/Y'),
                'qp_h_entrada'=> date('H:i') ,
                'empleado_id'=>$_SESSION['UMAE_USER']
            ),array(
                'triage_id'=>$paciente
            ));
            $this->config_mdl->_update_data('os_quirofanos_salas',array(
                'sala_status'=>'Ocupado'
            ),array(
                'sala_id'=>$info['sala_id']
            ));
            $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso a Quirófanos','triage_id'=>$paciente,'areas_id'=>$info['qp_id']));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AltaPaciente($paciente) {
        $info= $this->config_mdl->_get_data_condition('os_quirofanos_pacientes',array(
            'qp_id'=> $paciente
        ))[0];
        $this->config_mdl->_update_data('os_quirofanos_salas',array(
            'sala_status'=>''
        ),array(
            'sala_id'=>$info['sala_id']
        ));
        $this->config_mdl->_update_data('os_quirofanos_pacientes',array(
            'qp_status'=>'Salida',
            'qp_f_salida'=> date('d/m/Y'),
            'qp_h_salida'=> date('H:i') ,
        ),array(
            'qp_id'=> $paciente
        ));
        $this->setOutput(array('accion'=>'1'));
    }
}
