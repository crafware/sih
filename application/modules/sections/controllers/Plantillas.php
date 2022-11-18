<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Plantillas
 *
 * @author felipe de jesus
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Plantillas extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_plantillas, os_empleados
                                                    WHERE
                                                    os_empleados.empleado_id=os_plantillas.empleado_id AND 
                                                    os_empleados.empleado_id=$this->UMAE_USER");
        // if(MOD_CONSULTORIOS=='No'){
            $this->load->view('Plantillas/index',$sql);
        // }else{
            // $this->ModuleNotAvailable();
        //}
        
    }
    public function AjaxPlantilla() {
        $data=array(
            'plantilla_nombre'=>  $this->input->post('plantilla_nombre'),
            'plantilla_limit'=>  $this->input->post('plantilla_limit'),
            'empleado_id'=> $this->UMAE_USER
        );
        $sql_check=  $this->config_mdl->_get_data_condition('os_plantillas',$data);
        
        if($this->input->post('accion')=='add'){
            if(empty($sql_check)){
                $this->config_mdl->_insert('os_plantillas',$data);
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }
            
        }else{
            $this->config_mdl->_update_data('os_plantillas',$data,array(
                'plantilla_id'=>  $this->input->post('plantilla_id')
            ));
            $this->setOutput(array('accion'=>'1'));
        }
    }
    public function AjaxEliminarPlantilla() {
        $this->config_mdl->_delete_data('os_plantillas',array(
            'plantilla_id'=>  $this->input->post('plantilla_id')
        ));
        
        $this->setOutput(array('accion'=>'1'));
    }
    public function Contenidos($Plantilla) {
        $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_plantillas_contenidos, os_plantillas
                                                    WHERE
                                                    os_plantillas_contenidos.plantilla_id=os_plantillas.plantilla_id AND
                                                    os_plantillas_contenidos.plantilla_id=$Plantilla");
        $this->load->view('Plantillas/contenidos',$sql);
    }
    public function AgregarContenido() {
        $sql['info']= $this->config_mdl->_get_data_condition('os_plantillas_contenidos',array(
            'contenido_id'=>$_GET['con']
        ))[0];
        $this->load->view('Plantillas/AgregarContenido',$sql);
    }
    public function AjaxContenido() {
        $data=array(
            'contenido_datos'=>  $this->input->post('contenido_datos'),
            'contenido_fecha'=> date('Y-m-d H:i:s'),
            'empleado_id'=> $this->UMAE_USER,
            'plantilla_id'=>  $this->input->post('plantilla_id')
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('os_plantillas_contenidos',$data);
        }else{
            unset($data['contenido_fecha']);
            $this->config_mdl->_update_data('os_plantillas_contenidos',$data,array(
                'contenido_id'=>  $this->input->post('contenido_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxEliminarContenido() {
        $this->config_mdl->_delete_data('os_plantillas_contenidos',array(
            'contenido_id'=>  $this->input->post('contenido_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxObtenerContenido() {
        $SESSION=$_SESSION['UMAE_USER'];
        $sql=  $this->config_mdl->_query("SELECT * FROM os_plantillas, os_plantillas_contenidos
                WHERE os_plantillas.plantilla_id=os_plantillas_contenidos.plantilla_id AND os_plantillas.empleado_id='$SESSION' AND
                os_plantillas.plantilla_nombre='".$this->input->post('plantilla_nombre')."'");
        
        if(!empty($sql)){
            foreach ($sql as $value) {
                $tr.='  <tr>
                            <td>'.$value['contenido_datos'].'</td>
                            <td>
                                <label class="md-check">
                                    <input type="radio" class="seleccionar_plantilla" name="seleccionar_plantilla" value="'.$value['contenido_datos'].'"><i class="indigo"></i>
                                </label>
                            </td>
                        </tr>';
            }
            $this->setOutput(array('RESULT'=>$tr));
        }else{
            $this->setOutput(array('RESULT'=>'NO SE ENCONTRARÓN PLANTILLAS DISPONIBLES'));
        }
    }
    public function SeleccionarContenido() {
        $SESSION=$_SESSION['UMAE_USER'];
        $sql['Gestion']=  $this->config_mdl->_query("SELECT * FROM os_plantillas, os_plantillas_contenidos
                WHERE os_plantillas.plantilla_id=os_plantillas_contenidos.plantilla_id AND os_plantillas.empleado_id='$SESSION' AND
                os_plantillas.plantilla_nombre='".$this->input->get_post('plantilla')."'");
        $this->load->view('Plantillas/SeleccionarContenido',$sql);
    }
}
