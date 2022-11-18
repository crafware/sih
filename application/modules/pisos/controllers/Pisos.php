<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pisos
 *
 * @author felipe de jesus
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Pisos extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $sql['Gestion']= $this->config_mdl->_get_data('os_pisos');
        $this->load->view('index',$sql);
    }
    public function TotaSalas($data) {
        $sql= $this->config_mdl->_get_data_condition('os_pisos_salas',array(
            'piso_id'=>$data['piso_id']
        ));
        return count($sql);
    }
    public function TotaCamasAsignadas($data) {
        $sql= $this->config_mdl->_get_data_condition('os_pisos_sc',array(
            'sala_id'=>$data['sala_id']
        ));
        return count($sql);
    }
    public function Salas($Piso) {
        $sql['Gestion']=$this->config_mdl->_get_data_condition('os_pisos_salas',array(
            'piso_id'=>$Piso
        ));
        $sql['info']=$this->config_mdl->_get_data_condition('os_pisos',array(
            'piso_id'=>$Piso
        ))[0];
        $this->load->view('Salas',$sql);     
    }
    public function AsignarCamas($Sala) {
        $sql['Sala']= $this->config_mdl->_get_data_condition('os_pisos_salas',array(
            'sala_id'=>$Sala
        ));
        $sql['Piso']= $this->config_mdl->_get_data_condition('os_pisos',array(
            'piso_id'=> $this->input->get('piso_id')
        ));
        $sql['Areas']= $this->config_mdl->_query("SELECT * FROM os_areas WHERE os_areas.area_id BETWEEN 1 AND 23");
        
        $this->load->view('AsignarCamas',$sql);
    }
    public function AjaxObtenerCamas() {
        $Camas= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas WHERE
        os_camas.area_id=os_areas.area_id AND
        os_areas.area_id=".$this->input->post('area_id'));
        $CamasAsignadas= $this->config_mdl->_query("SELECT * FROM os_camas, os_pisos, os_pisos_sc, os_areas, os_pisos_salas
        WHERE
        os_areas.area_id=os_camas.area_id AND
        os_pisos_salas.piso_id=os_pisos.piso_id AND
        os_pisos_sc.sala_id=os_pisos_salas.sala_id AND
        os_pisos_sc.cama_id=os_camas.cama_id AND
        os_pisos_sc.sala_id=".$this->input->post('sala_id'));
        foreach ($Camas as $value) {
            $col_md_3.='<div class="col-md-3">
                    <div class="form-group">
                        <label class="md-check tip" data-original-title="ssds">
                            <input type="checkbox" class="has-value cama_'.$value['cama_id'].'" name="cama_id" data-accion="Agregar" data-id="'.$value['cama_id'].'" data-sala="'.$this->input->post('sala_id').'">
                            <i class="indigo " ></i><b>Cama: </b>'.$value['cama_nombre'].'
                        </label>
                    </div>
                </div>';
        }
        $this->setOutput(array('col_md_3'=>$col_md_3,'CamasAsignadas'=>$CamasAsignadas));
    }
    public function AjaxCamasAsignadas() {
        $sql= $this->config_mdl->_query("SELECT * FROM os_camas, os_pisos, os_pisos_sc, os_areas, os_pisos_salas
        WHERE
        os_areas.area_id=os_camas.area_id AND
        os_pisos_salas.piso_id=os_pisos.piso_id AND
        os_pisos_sc.sala_id=os_pisos_salas.sala_id AND
        os_pisos_sc.cama_id=os_camas.cama_id AND
        os_pisos_sc.sala_id=".$this->input->post('sala_id'));
        foreach ($sql as $value) {
            $col_md_3.='<div class="col-md-3">
                    <div class="form-group">
                        <label class="md-check tip" data-original-title="ssds">
                            <input type="checkbox" checked  name="cama_id" data-accion="Eliminar" data-id="'.$value['cama_id'].'" data-sala="'.$this->input->post('sala_id').'">
                            <i class="indigo " ></i><b>Cama :</b> '.$value['cama_nombre'].'
                        </label><br>
                        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Área &nbsp;&nbsp;:</b> '.$value['area_nombre'].'</label>
                    </div>
                </div>';
        }
        $this->setOutput(array('col_md_3'=>$col_md_3));
    }
    public function AjaxAsignarCamas() {
        if($this->input->post('accion')=='Agregar'){
            $sql= $this->config_mdl->_get_data_condition('os_pisos_sc',array(
                'cama_id'=>$this->input->post('cama_id')
            ));
            if(empty($sql)){
                $this->config_mdl->_insert('os_pisos_sc',array(
                    'sala_id'=> $this->input->post('sala_id'),
                    'cama_id'=> $this->input->post('cama_id')
                ));
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }
        }else{
            $this->config_mdl->_delete_data('os_pisos_sc',array(
                'sala_id'=> $this->input->post('sala_id'),
                'cama_id'=> $this->input->post('cama_id')
            ));
            $this->setOutput(array('accion'=>'1'));
        }
        
    }
    public function AjaxSala() {
        $data=array(
            'sala_nombre'=> $this->input->post('sala_nombre'),
            'piso_id'=> $this->input->post('piso_id')
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('os_pisos_salas',$data);
        }else{
            $this->config_mdl->_update_data('os_pisos_salas',$data,array(
                'sala_id'=> $this->input->post('sala_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    
}
