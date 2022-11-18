<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entregaguardia
 *
 * @author crafware
 */
include_once APPPATH.'modules/config/controllers/Config.php';

class Entregaguardia extends Config {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
        $this->load->view('index');
    }

    public function Diagnostico() {
        $cie10_nombre= $this->input->post('cie10_nombre');
        $sql= $this->config_mdl->_query("SELECT * FROM um_cie10 WHERE cie10_nombre LIKE '%".$cie10_nombre."%' LIMIT 250");
        $data=array();
        foreach ($sql as $value) {
            //$um_cie10.='<li>'.$value['cie10_nombre'].'</li>';
            //$cie10_nombre .= [$value['cie10_nombre'],$value['cie10_clave']];
            $data[] = array('cie10_id' => $value['cie10_id'], 
                            'cie10_clave' => $value['cie10_clave'], 
                            'cie10_nombre' => $value['cie10_nombre'] );
            
        }
        // $this->setOutput(array(
        //     'cie10_nombre'=> $cie10_nombre,
        //     'cie10_clave' => $cie10_clave
        // ));
        echo json_encode($data);
        
        //var_dump($data);
    }

}