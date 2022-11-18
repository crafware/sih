<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Inventario
 *
 * @author felipe de jesus <itifjpp@gmail.com>
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Inventario extends Config{
    public function index() {
        $sql['Gestion']= $this->config_mdl->_get_data('abs_catalogos');
        $this->load->view('Inventario/CatalogosIndex',$sql);
    }
    public function Sistemas() {
        $sql['material']= $this->config_mdl->_get_data_condition('abs_catalogos',array(
            'catalogo_id'=> $this->input->get_post('catalogo')
        ))[0];
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM abs_catalogos, abs_sistemas WHERE abs_catalogos.catalogo_id=abs_sistemas.catalogo_id AND
            abs_catalogos.catalogo_id=".$_GET['catalogo']);
        $this->load->view('Inventario/SistemasIndex',$sql);
    }
    public function Elementos() {
        $sql['material']= $this->config_mdl->_get_data_condition('abs_catalogos',array(
            'catalogo_id'=>$_GET['catalogo']
        ))[0];
        $sql['sistema']= $this->config_mdl->_get_data_condition('abs_sistemas',array(
            'sistema_id'=>$_GET['sistema']
        ))[0];
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM abs_catalogos, abs_sistemas, abs_elementos WHERE 
            abs_catalogos.catalogo_id=abs_sistemas.catalogo_id AND 
            abs_sistemas.sistema_id=abs_elementos.sistema_id AND
            abs_sistemas.sistema_id=".$_GET['sistema']);
        $this->load->view('Inventario/ElementosIndex',$sql);
    }
     public function Rangos() {
        $sql['material']= $this->config_mdl->_get_data_condition('abs_catalogos',array(
            'catalogo_id'=>$_GET['catalogo']
        ))[0];
        $sql['sistema']= $this->config_mdl->_get_data_condition('abs_sistemas',array(
            'sistema_id'=>$_GET['sistema']
        ))[0];
        $sql['elemento']= $this->config_mdl->_get_data_condition('abs_elementos',array(
            'elemento_id'=>$_GET['elemento']
        ))[0];
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM abs_catalogos, abs_sistemas, abs_elementos, abs_rangos WHERE
            abs_catalogos.catalogo_id=abs_sistemas.catalogo_id AND
            abs_sistemas.sistema_id=abs_elementos.sistema_id AND
            abs_elementos.elemento_id=abs_rangos.elemento_id AND
            abs_elementos.elemento_id=".$_GET['elemento']);
        $this->load->view('Inventario/RangosIndex',$sql);
    }
    public function AjaxAgregarExistencia() {
        for ($i = 0; $i < $this->input->post('existencia_id'); $i++) {
            $this->config_mdl->_insert('abs_rangos_existencia',array(
                'existencia_status'=>'Disponible',
                'rango_id'=> $this->input->post('rango_id'),
                'elemento_id'=> $this->input->post('elemento_id'),
                'sistema_id'=> $this->input->post('sistema_id'),
                'catalogo_id'=> $this->input->post('catalogo_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function Exitencia() {
        $sql['material']= $this->config_mdl->_get_data_condition('abs_catalogos',array(
            'catalogo_id'=>$_GET['catalogo']
        ))[0];
        $sql['sistema']= $this->config_mdl->_get_data_condition('abs_sistemas',array(
            'sistema_id'=>$_GET['sistema']
        ))[0];
        $sql['elemento']= $this->config_mdl->_get_data_condition('abs_elementos',array(
            'elemento_id'=>$_GET['elemento']
        ))[0];
        $sql['rango']= $this->config_mdl->_get_data_condition('abs_rangos',array(
            'rango_id'=>$_GET['rango']
        ))[0];
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM abs_catalogos, abs_sistemas, abs_elementos, abs_rangos, abs_rangos_existencia WHERE
            abs_catalogos.catalogo_id=abs_sistemas.catalogo_id AND
            abs_sistemas.sistema_id=abs_elementos.sistema_id AND
            abs_elementos.elemento_id=abs_rangos.elemento_id AND
            abs_rangos_existencia.rango_id=abs_rangos.rango_id AND
            abs_rangos.rango_id=".$_GET['rango']);
        $this->load->view('Inventario/RangosExistencia',$sql);
    }
    public function GenerarCodigo($Existencia) {
        $sql['info']= $this->config_mdl->_get_data_condition('abs_rangos_existencia',array(
            'existencia_id'=>$Existencia
        ))[0];
        $this->load->view('Inventario/GenerarCodigo',$sql);
    }
}
