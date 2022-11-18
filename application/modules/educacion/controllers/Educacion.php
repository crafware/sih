<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Enzeñanza
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Educacion extends Config{
    public function Cursos() {
        $sql['Gestion']= $this->config_mdl->_get_data('edu_cursos');
        $this->load->view('index',$sql);
    }
    public function TotalUsuarios($data) {
        return count($this->config_mdl->_get_data_condition('edu_curso_usuario',array(
            'curso_id'=>$data['curso_id']
        )));
    }
    public function AgregarCurso($Curso) {
        $sql['info']= $this->config_mdl->_get_data_condition('edu_cursos',array(
            'curso_id'=>$Curso
        ))[0];
        $this->load->view('CursoNuevo',$sql);
    }
    public function AjaxAgregarCurso() {
        $data=array(
            'curso_fecha'=> date('d/m/Y'),
            'curso_hora'=> date('H:i'),
            'curso_nombre'=> $this->input->post('curso_nombre'),
            'curso_descripcion'=> $this->input->post('curso_descripcion'),
            'empleado_id'=> $this->UMAE_USER
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('edu_cursos',$data);
        }else{
            unset($data['curso_fecha']);
            unset($data['curso_hora']);
            unset($data['empleado_id']);
            $this->config_mdl->_update_data('edu_cursos',$data,array(
                'curso_id'=> $this->input->post('curso_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function CursoUsuario($Curso) {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM 
            os_empleados, edu_cursos, edu_curso_usuario WHERE
            edu_curso_usuario.curso_id=edu_cursos.curso_id AND
            edu_cursos.curso_id=$Curso AND
            edu_curso_usuario.empleado_id=os_empleados.empleado_id ORDER BY
            edu_curso_usuario.cu_id DESC");
        $this->load->view('CursoUsuario',$sql);
    }
    public function AjaxBuscarUsuario() {
        $sql= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(empty($sql)){
            $this->setOutput(array('accion'=>'2'));
        }else{
            $this->setOutput(array('accion'=>'1'));
        }
    }
    public function AjaxCursoUsuario() {
        $sql= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        $check= $this->config_mdl->_get_data_condition('edu_curso_usuario',array(
            'empleado_id'=> $sql[0]['empleado_id']
        ));
        if(empty($check)){
            $data=array(
                'cu_fecha'=> date('d/m/Y'),
                'cu_hora'=> date('H:i'),
                'curso_id'=> $this->input->post('curso_id'),
                'empleado_id'=> $sql[0]['empleado_id']
            );
            $this->config_mdl->_insert('edu_curso_usuario',$data);
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
        
    }
    public function AjaxEliminarUsuarioCurso() {
        $this->config_mdl->_delete_data('edu_curso_usuario',array(
            'cu_id'=> $this->input->post('cu_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
}
