<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author felipe de jesus
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Login extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $sql['Gestion']=  $this->config_mdl->_query('SELECT * FROM os_areas_acceso WHERE areas_acceso_status="" ORDER BY areas_acceso_nombre ASC');
        $this->load->view('login/index',$sql);
    }
    public function ObtenerAreas() {
        $sql_rol=  $this->config_mdl->_get_data('os_areas_acceso');
        $areas=array();
        foreach ($sql_rol as $value) {
            if($value['areas_acceso_status']==''):
                array_push($areas, $value['areas_acceso_nombre']) ;
            endif;
        }
        $this->setOutput($areas);
    }
    public function loginV2() {
        $sql=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=>  $this->input->post('empleado_matricula'),
            "empleado_status"   =>  1
        ));
        $sql_exist=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=>  $this->input->post('empleado_matricula'),
        ));
        $sql_rol=  $this->config_mdl->_get_data('os_areas_acceso');
        $areas=array();
        foreach ($sql_rol as $value) {
            array_push($areas, $value['areas_acceso_nombre']) ;
        }
        $sqlGetRol= $this->config_mdl->_get_data_condition('os_areas_acceso',array(
            'areas_acceso_nombre'=>$this->input->post('empleado_area')
        ))[0];
        if(in_array($this->input->post('empleado_area'), $areas)){
            if(!empty($sql)){
                $_SESSION['empleado_roles']=$sql[0]['empleado_roles'];
                $sql_roles=  $this->config_mdl->_get_data_condition('os_empleados_roles',array(
                    'empleado_id'=>$sql[0]['empleado_id'],
                    'rol_id'=>$sqlGetRol['areas_acceso_rol']
                ));
                if(!empty($sql_roles)){
                    if($sql[0]['empleado_sc']=='Si'){
                        $this->setOutput(array('ACCESS_LOGIN'=>'ACCESS_SC'));
                    }else{
                        $_SESSION['UMAE_USER']=$sql[0]['empleado_id'];
                        $_SESSION['UMAE_AREA']=  $this->input->post('empleado_area');
                        $this->config_mdl->_update_data('os_empleados',array(
                            'empleado_area_acceso'=>$this->input->post('empleado_area'),
                            'empleado_acceso_f'=>  date('d/m/Y'),
                            'empleado_acceso_h'=>  date('H:i') ,
                            'empleado_conexion'=>  '1'
                        ),array(
                            'empleado_id'=>$sql[0]['empleado_id']
                        ));
                        $this->setOutput(array('ACCESS_LOGIN'=>'ACCESS'));
                    }
                }else{
                    $this->setOutput(array('ACCESS_LOGIN'=>'AREA_NO_ROL'));
                }
            }else if(empty($sql_exist)){
                $this->setOutput(array('ACCESS_LOGIN'=>  'MATRICULA_NO_ENCONTRADA'));
            }else{
                $this->setOutput(array('ACCESS_LOGIN'=>  'MATRICULA_NO_ACTIVA'));
            }  
        }else{
            $this->setOutput(array('ACCESS_LOGIN'=>  'AREA_NO_ENCONTRADA'));
        }
    } 
    public function Status() {
        $this->load->view('login/Status');
    }
    public function StatusServe() {
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxSolicitarPassword() {
        $sql= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula'),
            'empleado_password'=> sha1($this->input->post('empleado_password'))
        ));
        if(!empty($sql)){
            $_SESSION['UMAE_USER']=  $sql[0]['empleado_id'];
            $_SESSION['UMAE_AREA']=  $this->input->post('empleado_area');
            $this->config_mdl->_update_data('os_empleados',array(
                'empleado_area_acceso'=>$this->input->post('empleado_area'),
                'empleado_acceso_f'=>  date('d/m/Y'),
                'empleado_acceso_h'=>  date('H:i') ,
                'empleado_conexion'=>  '1'
            ),array(
                'empleado_id'=>$sql[0]['empleado_id']
            ));
            $this->setOutput(array('accion'=>'1',$_SESSION));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
        
    }
}
