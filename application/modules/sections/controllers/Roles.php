<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Roles
 *
 * @author bienTICS
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Roles extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $sql['Gestion']= $this->config_mdl->_get_data('os_roles');
        $this->load->view('Roles/index',$sql);
    }
    public function AjaxGuardar() {
        $data=array(
            'rol_nombre'=> $this->input->post('rol_nombre')
        );
        if($this->input->post('accion')=='Agregar'){
            $this->config_mdl->_insert('os_roles',$data);
        }else{
            $this->config_mdl->_update_data('os_roles',$data,array(
                'rol_id'=> $this->input->post('rol_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxEliminar() {
        $this->config_mdl->_update_data('os_roles',array(
            
        ),array(
            
        ));
    }
}
