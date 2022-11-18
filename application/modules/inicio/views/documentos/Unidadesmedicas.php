<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Unidadesmedicas
 *
 * @author felipe de jesus
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Unidadesmedicas extends Config{
    public function index() {
        $sql['Gestion']= $this->config_mdl->_get_data('os_unidadesmedicas');
        $this->load->view('unidadesmedicas/index',$sql);
    }
    public function add($unidad) {
        $sql['info']= $this->config_mdl->_get_data_condition('os_unidadesmedicas',array(
            'unidadmedica_id'=>$unidad
        ));
        $this->load->view('unidadesmedicas/add',$sql);
    }
    public function GuardarUnidadMedica() {
        $data=array(
            'unidadmedica_tipo'=> $this->input->post('unidadmedica_tipo'),
            'unidadmedica_nombre'=> $this->input->post('unidadmedica_nombre'),
            'unidadmedica_num'=> $this->input->post('unidadmedica_num'),
            'unidadmedica_domicilio'=> $this->input->post('unidadmedica_domicilio'),
            'unidadmedica_estado'=> $this->input->post('unidadmedica_estado'),
            'unidadmedica_titular'=> $this->input->post('unidadmedica_titular'),
            'unidadmedica_titular_titulo'=> $this->input->post('unidadmedica_titular_titulo'),
            'unidadmedica_titular_email'=> $this->input->post('unidadmedica_titular_email'),
            'unidadmedica_nivel'=> $this->input->post('unidadmedica_nivel')
        );
        $sql= $this->config_mdl->_get_data_condition('os_unidadesmedicas',array(
            'unidadmedica_id'=> $this->input->post('unidadmedica_id')
        ));
        if(empty($sql)){
            $this->config_mdl->_insert('os_unidadesmedicas',$data);
        }else{
            $this->config_mdl->_update_data('os_unidadesmedicas',$data,array(
                'unidadmedica_id'=> $this->input->post('unidadmedica_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
}
