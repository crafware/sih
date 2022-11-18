<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Camas
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Camas extends Config{
    public function index() {
        $this->load->view('Camas/GestionCamas');
    }
    public function CamasDetalles() {
        if($this->input->get('tipo')=='Total'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id  AND os_areas.area_id=".$this->input->get('area'));
        }if($this->input->get('tipo')=='Disponibles'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='Disponible'  AND os_areas.area_id=".$this->input->get('area'));
        }if($this->input->get('tipo')=='Ocupados'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='Ocupado'  AND os_areas.area_id=".$this->input->get('area')." ORDER BY cama_ingreso_f ASC, cama_ingreso_h ASC");
        }if($this->input->get('tipo')=='Mantenimiento'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='En Mantenimiento'  AND os_areas.area_id=".$this->input->get('area'));
        }if($this->input->get('tipo')=='Limpieza'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='En Limpieza'  AND os_areas.area_id=".$this->input->get('area'));
        }
        $this->load->view('Camas/CamasDetalles',$sql);
    }
    public function DetallePaciente($data) {
        return $this->config_mdl->_get_data_condition('os_triage',array('triage_id'=>$data['triage_id']))[0];
    }
    public function Estados() {
        $sql['Areas']= $this->config_mdl->sqlGetDataCondition('os_areas',array(
            'area_modulo'=>'Observación'
        ));
        if(isset($_GET['area_id'])){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_areas, os_camas WHERE os_areas.area_id=os_camas.area_id AND
            os_areas.area_id=".$_GET['area_id']);
        }
        $this->load->view('Camas/Estados',$sql);
    }
    public function AjaxEstados() {
        $this->config_mdl->_update_data('os_camas',array(
            'cama_display'=> $this->input->post('cama_display')
        ),array(
            'cama_id'=> $this->input->post('cama_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
}
