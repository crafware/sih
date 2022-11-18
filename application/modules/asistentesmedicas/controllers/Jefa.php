<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Jefa
 *
 * @author felipe de jesus
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Jefa extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->view('JefaAm_v2');
    }
    public function v2() {
        $this->load->view('JefaAm_v2');
    }
    /*SQL*/
    public function Log_43029_IE($data) {
        $fecha=$data['fecha'];
        $turno=$data['turno'];
        $tipo=$data['tipo'];
        return $this->config_mdl->_query("SELECT * FROM doc_43029, os_triage WHERE 
                os_triage.triage_id=doc_43029.triage_id AND doc_43029.doc_tipo='$tipo' AND 
                doc_43029.doc_turno='$turno' AND doc_43029.doc_fecha='$fecha'");
    }
    public function Log_43029_IE_NOCHE($data) {
        $fecha=$data['fecha'];
        $tipo=$data['tipo'];
        $sql1= $this->config_mdl->_query("SELECT * FROM doc_43029, os_triage WHERE 
                os_triage.triage_id=doc_43029.triage_id AND doc_43029.doc_tipo='$tipo' AND 
                doc_43029.doc_turno='Noche A' AND doc_43029.doc_fecha='$fecha'");
        $sql2= $this->config_mdl->_query("SELECT * FROM doc_43029, os_triage WHERE 
                os_triage.triage_id=doc_43029.triage_id AND doc_43029.doc_tipo='$tipo' AND 
                doc_43029.doc_turno='Noche B' AND doc_43029.doc_fecha=INTERVAL 1 DAY +'$fecha'");
        return count($sql1)+ count($sql2); 
    }
    public function Log_43021_IE($data) {
        $fecha=$data['fecha'];
        $turno=$data['turno'];
        $tipo=$data['tipo'];
        return $this->config_mdl->_query("SELECT * FROM doc_43021, os_triage WHERE 
                os_triage.triage_id=doc_43021.triage_id AND doc_43021.doc_tipo='$tipo' AND 
                doc_43021.doc_turno='$turno' AND doc_43021.doc_fecha='$fecha'");
    }
    public function Log_43021_IE_NOCHE($data) {
        $fecha=$data['fecha'];
        $tipo=$data['tipo'];
        $sql1= $this->config_mdl->_query("SELECT * FROM doc_43021, os_triage WHERE 
                os_triage.triage_id=doc_43021.triage_id AND doc_43021.doc_tipo='$tipo' AND 
                doc_43021.doc_turno='Noche A' AND doc_43021.doc_fecha='$fecha'");
        $sql2= $this->config_mdl->_query("SELECT * FROM doc_43021, os_triage WHERE 
                os_triage.triage_id=doc_43021.triage_id AND doc_43021.doc_tipo='$tipo' AND 
                doc_43021.doc_turno='Noche B' AND doc_43021.doc_fecha=INTERVAL 1 DAY+'$fecha'");
        return count($sql1)+ count($sql2);
    }
    public function AjaxFiltroV2() { 
        if($this->input->post('inputTurno')!='Noche'){
            $FILTRO_INGRESO= count($this->Log_43029_IE(array(
                'fecha'=> $this->input->post('input_fecha'),
                'turno'=> $this->input->post('inputTurno'),
                'tipo'=>'Ingreso'
            )));
            $FILTRO_EGRESO= count($this->Log_43029_IE(array(
                'fecha'=> $this->input->post('input_fecha'),
                'turno'=> $this->input->post('inputTurno'),
                'tipo'=> 'Egreso'
            )));   
            $OBSERVACION_INGRESO= count($this->Log_43021_IE(array(
                'fecha'=> $this->input->post('input_fecha'),
                'turno'=> $this->input->post('inputTurno'),
                'tipo'=> 'Ingreso'
            )));
            $OBSERVACION_EGRESO= count($this->Log_43021_IE(array(
                'fecha'=> $this->input->post('input_fecha'),
                'turno'=> $this->input->post('inputTurno'),
                'tipo'=> 'Egreso'
            )));
        }else{
            $FILTRO_INGRESO= $this->Log_43029_IE_NOCHE(array(
                'fecha'=> $this->input->post('input_fecha'),
                'tipo'=>'Ingreso'
            ));
            $FILTRO_EGRESO= $this->Log_43029_IE_NOCHE(array(
                'fecha'=> $this->input->post('input_fecha'),
                'tipo'=> 'Egreso'
            ));  
            $OBSERVACION_INGRESO= $this->Log_43021_IE_NOCHE(array(
                'fecha'=> $this->input->post('input_fecha'),
                'tipo'=> 'Ingreso'
            ));
            $OBSERVACION_EGRESO= $this->Log_43021_IE_NOCHE(array(
                'fecha'=> $this->input->post('input_fecha'),
                'tipo'=> 'Egreso'
            ));
        }
        
        
        $this->setOutput(array(
            'FILTRO_INGRESO'=>$FILTRO_INGRESO,
            'FILTRO_EGRESO'=>$FILTRO_EGRESO, 
            'OBSERVACION_INGRESO'=>$OBSERVACION_INGRESO,
            'OBSERVACION_EGRESO'=>$OBSERVACION_EGRESO
        ));
            
        
    }
}
