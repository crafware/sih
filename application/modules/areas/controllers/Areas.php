<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Areas
 *
 * @author bienTICS
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Areas extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $sql['Gestion']= $this->config_mdl->_get_data('os_areas');
        $this->load->view('areasv/index',$sql);
    }
    public function AgregarArea(){
        $sql['info']= $this->config_mdl->sqlGetDataCondition('os_areas',array(
            'area_id'=> $this->input->get('area')
        ))[0];
        $this->load->view('areasv/AreaAgregar',$sql);
    }
    public function AjaxGuardarArea() {
        $data=array(
            'area_nombre'=> $this->input->post('area_nombre'),
            'area_camas'=> 'Si',
            'area_horario_visita'=> $this->input->post('area_horario_visita'),
            'area_modulo'=> $this->input->post('area_modulo'),
            'area_genero'=> $this->input->post('area_genero'),
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('os_areas',$data);
        }else{
            $this->config_mdl->_update_data('os_areas',$data,array(
                'area_id'=> $this->input->post('area_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function EliminarArea($area) {
        $this->config_mdl->_delete_data('os_areas',array(
            'area_id'=>$area
        ));
        $this->config_mdl->_delete_data('os_camas',array(
            'area_id'=>$area
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function GestionCamas($area) {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas WHERE os_camas.area_id='$area' ORDER BY os_camas.cama_id DESC");
        $sql['info']= $this->config_mdl->_get_data_condition('os_areas',array(
            'area_id'=>$area
        ))[0];
        $this->load->view('areasv/camas',$sql);
    }
    public function TotalCama($data) {
        return $this->config_mdl->_query("SELECT COUNT(os_camas.cama_id) AS TOTAL FROM os_camas WHERE os_camas.area_id=".$data['area_id'])[0]['TOTAL'];
    }
    public function GuardarCama() {
        $data=array(
            'cama_nombre'=> $this->input->post('cama_nombre'),
            'cama_status'=> 'Disponible',
            'cama_aislado'=> $this->input->post('cama_aislado'),
            'cama_genero'=> $this->input->post('cama_genero'),
            'area_id'=> $this->input->post('area_id'),
            'cama_dh'=>'0'
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('os_camas',$data);
        }else{
            unset($data['cama_status']);
            unset($data['cama_dh']);
            $this->config_mdl->_update_data('os_camas',$data,array(
                'cama_id'=> $this->input->post('cama_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function EliminarCama($cama) {
        $this->config_mdl->_delete_data('os_camas',array(
            'cama_id'=>$cama
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function ObtenerCamas($area) {
        $sql_cama= $this->config_mdl->_get_data_condition('os_camas',array(
            'area_id'=> $area
        ));
        $option.='<option value="">Seleccionar Cama</option>';
        if(!empty($sql_cama)){
            foreach ($sql_cama as $value) {
                $option.='<option value="'.$value['cama_id'].'">'.$value['cama_nombre'].'</option>';
            }
        }else{
            $this->setOutput(array('camas'=>'NO'));
        }
        
        $this->setOutput(array('camas'=>$option));
    }
    public function LogCamas($data) {
        $this->config_mdl->_insert('cm_camas_log',array(
            'log_estatus'=>$data['log_estatus'],
            'log_fecha'=> date('Y-m-d'),
            'log_hora'=> date('H:i:s'),
            'log_turno'=> Modules::run('Config/ObtenerTurno'),
            'log_area'=> $this->UMAE_AREA,
            'cama_id'=>$data['cama_id'],
            'empleado_id'=> $this->UMAE_USER
        ));
    }
    /**/
    public function AjaxObtenerAreas() {
        $sql= $this->config_mdl->sqlGetDataCondition('os_areas',array(
            'area_modulo'=> $this->input->post('areas_acceso_mod')
        ));
        foreach ($sql as $value) {
            $option.='<option value="'.$value['area_id'].'">'.$value['area_nombre'].'</option>';
        }
        $this->setOutput(array('option'=>$option));
    }
}
