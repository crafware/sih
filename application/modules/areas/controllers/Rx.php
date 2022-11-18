<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rx
 *
 * @author bienTICS
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Rx extends Config{
    /*Cargar Vistas*/
    public function index() {
        if($_GET['supe']){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_rx, os_rx_llamada, os_triage
            WHERE os_rx.triage_id=os_triage.triage_id AND 
		os_rx.rx_id=os_rx_llamada.rx_id AND
		os_rx.rx_status='Asignado' AND
		os_rx.rx_crea=1 ORDER BY os_rx_llamada.llamada_id DESC");
        }else{
            $UMAR_USER=$_SESSION['UMAE_USER'];
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_rx, os_rx_llamada, os_triage
            WHERE os_rx.triage_id=os_triage.triage_id AND 
		os_rx.rx_id=os_rx_llamada.rx_id AND
		os_rx.rx_status='Asignado' AND
		os_rx.rx_crea=$UMAR_USER ORDER BY os_rx_llamada.llamada_id DESC");
        }
        
        
        $this->load->view('rx/index',$sql);
    }
    /*
     * Fin Cargas Vistas
     * Inicio Datos   
     */
    public function ObtenerPaciente() {
        $sql= $this->config_mdl->_get_data_condition('os_rx',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $info= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(!empty($sql)){
            $this->setOutput(array('accion'=>'1','rx'=>$sql[0],'paciente'=>$info[0]));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AgregarPacienteRx() {
        $info= $this->config_mdl->_get_data_condition('os_rx',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->config_mdl->_update_data('os_rx',array(
            'rx_fecha_entrada'=> date('d/m/Y'),
            'rx_hora_entrada'=> date('H:i'),
            'rx_status'=>'Asignado',
            'rx_crea'=>$_SESSION['UMAE_USER']
        ),array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->config_mdl->_insert('os_rx_llamada',array(
            'rx_id'=>$info['rx_id']
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso a RX','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$info['rx_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AltaIngresoCE() {
        $info= $this->config_mdl->_get_data_condition('os_rx',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->config_mdl->_update_data('os_rx',array(
            'rx_fecha_salida'=> date('d/m/Y'),
            'rx_hora_salida'=> date('H:i'),
            'rx_status'=>'Salida',
            'rx_anexar_url'=> $this->input->post('rx_anexar_url')
        ),array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $sql_check_ce= $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(empty($sql_check_ce)){
            $this->config_mdl->_insert('os_consultorios_especialidad',array(
                'triage_id'=>  $this->input->post('triage_id'),
                'asistentesmedicas_id'=>  $info['asistentesmedicas_id'],
                'ce_fe'=>date('d/m/Y'),
                'ce_he'=>  date('H:i'),
                'ce_status'=>'En Espera',
                'ce_via'=>'RX'
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
}
