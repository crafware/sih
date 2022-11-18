<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuarios
 *
 * @author bienTICS
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Usuarios extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->view('Usuarios/index');
    }
    public function Usuario($usuario) {
        $sql['info']=   $this->config_mdl->_get_data_condition('os_empleados',array('empleado_id'=>$usuario));
        $sql['roles']=  $this->config_mdl->_get_data('os_roles');
        $sql['Especialidades']=  $this->config_mdl->sqlGetDataOrderBy('um_especialidades','*', 'especialidad_nombre', 'ASC');
        
        $this->load->view('Usuarios/add',$sql);
    }
    public function VerificarMatricula() {
        $sql=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=>  $this->input->post('empleado_matricula')
        ));
        if(empty($sql)){
            $this->setOutput(array('ACCION'=>'NO_EXISTE'));
        }else{
            $this->setOutput(array('ACCION'=>'EXISTE'));
        }
    }
    public function GuardarUsuario() {
       foreach ($this->input->post('rol_id') as $rol_select) {
          $roles.=$rol_select.',';
       }
       if($this->input->post('empleado_jefe_servicio') == "on"){
            $empleado_jefe_servicio = 1;
       }else{
            $empleado_jefe_servicio = 0;
       }
       if($this->input->post('empleado_status') == "on"){
            $empleado_status = 1;
       }else{
            $empleado_status = 0;
       }
       $data=array(
           'empleado_matricula'=>       $this->input->post('empleado_matricula'),
           'empleado_nombre'=>          $this->input->post('empleado_nombre'),
           'empleado_apellidos'=>       $this->input->post('empleado_apellidos'),
           'empleado_fecha_nac'=>       $this->input->post('empleado_fecha_nac'),
           'empleado_estado'=>          $this->input->post('empleado_estado'),
           'empleado_sexo'=>            $this->input->post('empleado_sexo'),
           'empleado_direccion'=>       $this->input->post('empleado_direccion'),
           'empleado_tel'=>             $this->input->post('empleado_tel'),
           'empleado_email'=>           $this->input->post('empleado_email'),
           'empleado_categoria'=>       $this->input->post('empleado_categoria'),
           'empleado_departamento'=>    $this->input->post('empleado_departamento'),
           'empleado_servicio'=>        $this->input->post('empleado_servicio'),
           'empleado_cedula'=>          $this->input->post('empleado_cedula'),
           'empleado_jefe_servicio'=>   $empleado_jefe_servicio,
           'empleado_status'=>          $empleado_status,

           'empleado_perfil'=>          'default.png',
           'empleado_fecha_registro'=>  date('d/m/Y'), 
           'empleado_turno'=>           $this->input->post('empleado_turno'),
           'empleado_modulo'=>          $this->input->post('empleado_modulo'),
           'empleado_crea'=>$_SESSION['UMAE_USER'],
           'empleado_crea_f'=>  date('d/m/Y'),
           'empleado_crea_h'=>  date('H:i'),
           'empleado_roles'=>  trim($roles, ','),
           'empleado_sc'=>'No'
           
       );
       if($this->input->post('jtf_accion')=='add'){
            $this->config_mdl->_insert('os_empleados',$data);
            $sql_max=  $this->config_mdl->_get_last_id('os_empleados','empleado_id');
            foreach ($this->input->post('rol_id') as $rol_select) {
                $this->config_mdl->_insert('os_empleados_roles',array(
                    'empleado_id'=>$sql_max,
                    'rol_id'=>$rol_select
                ));
            }
            $this->setOutput(array('accion'=>'1'));
       }else{
           unset($data['empleado_matricula']);unset($data['empleado_fecha_registro']);unset($data['empleado_perfil']);
           $this->config_mdl->_update_data('os_empleados',$data,array(
               'empleado_id'=>$this->input->post('empleado_id')
           ));
           $this->config_mdl->_delete_data('os_empleados_roles',array(
               'empleado_id'=>$this->input->post('empleado_id')
           ));
           foreach ($this->input->post('rol_id') as $rol_select) {
                $this->config_mdl->_insert('os_empleados_roles',array(
                    'empleado_id'=>$this->input->post('empleado_id'),
                    'rol_id'=>$rol_select
                )); 
            }
           $this->setOutput(array('accion'=>'1', "x" => $this->input->post('empleado_status')));
       }
   }
   public function AjaxObtenerUsuario() {
       error_reporting(1);
       if($this->input->get_post('FILTRO_TIPO')==''){
           $sql= $this->config_mdl->_query("SELECT * FROM os_empleados ORDER BY empleado_id DESC LIMIT 200");
       }else{
           $sql= $this->config_mdl->GetDataLike('os_empleados',array(
                $this->input->get_post('FILTRO_TIPO')=> $this->input->get_post('FILTRO_VALUE')
           ));
       }
       if(!empty($sql)){
           foreach ($sql as $value) {
               $sqlEspecialidad = $this->config_mdl->sqlGetDataCondition('um_especialidades', array(
                   'especialidad_id' => $value['empleado_servicio']
               ))[0];
               $tr.='<tr>
                        <td>'.$value['empleado_matricula'].'</td>
                        <td>'.$value['empleado_nombre'].'</td>
                        <td>'.$value['empleado_apellidos'].'</td>
                        <td>'.($value['empleado_categoria']!='' ? $value['empleado_categoria'] : 'No especificado').'</td>
                        <td>'.$sqlEspecialidad['especialidad_nombre'].'</td>
                        <td>
                            <a href="'.base_url().'Sections/Usuarios/Usuario/'.$value['empleado_id'].'/?a=edit" target="_blank" rel="opener">
                                <i class="fa fa-pencil icono-accion"></i>
                            </a>&nbsp;
                            <i class="fa fa-trash-o icono-accion pointer" style="opacity: 0.4"></i>
                        </td>
                    </tr>';
           }
       }else{
           $tr.='<tr>
                    <td colspan="5">EL CRITERIO DE BUSQUEDA NO ARROJADO NINGÚN REGISTRO</td>
                </td>';
       }
       $this->setOutput(array('tr'=>$tr));
   }
   public function Sesiones() {
       $this->load->view('Usuarios/Sesiones');
   }
   public function AjaxSesiones() {
       $sql= $this->config_mdl->_query("SELECT * FROM os_empleados WHERE os_empleados.empleado_conexion='1' ORDER BY os_empleados.empleado_acceso_h ASC");
       if(!empty($sql)){
           foreach ($sql as $value) {
               $Tiempo= $this->CalcularTiempoTranscurrido(array(
                   'Tiempo1'=> str_replace('/', '-', $value['empleado_acceso_f']).' '.$value['empleado_acceso_h'],
                   'Tiempo2'=> date('d-m-Y').' '. date('H:i')
               ));
               $tr.='<tr>
                        <td>'.$value['empleado_nombre'].' '.$value['empleado_apellidos'].'</td>
                        <td>'.$value['empleado_area_acceso'].'</td>
                        <td>
                            <i class="fa fa-clock-o icono-accion"></i> '.$value['empleado_acceso_f'].' '.$value['empleado_acceso_h'].' <i class="fa fa-hourglass-end icono-accion"></i> '.$Tiempo->h.' Horas '.$Tiempo->i.' Minutos
                        </td>
                        <td>
                            <i class="fa fa-refresh icono-accion pointer recargar-pagina-usuario" data-id="'.$value['empleado_id'].'"></i>&nbsp;
                            <i class="fa fa-lock icono-accion pointer cerrar-sesion-usuario" data-id="'.$value['empleado_id'].'"></i>
                        </td>
                    </tr>';
           }
       }else{
           $tr.='<tr>
                    <td colspan="5">EL CRITERIO DE BUSQUEDA NO ARROJADO NINGÚN REGISTRO</td>
                </td>';
       }
       $this->setOutput(array('tr'=>$tr,'SESIONES_ACTIVAS'=> count($sql)));
   }
   public function AjaxCerrarSesion() {
      if($this->input->post('empleado_id')=='0'){
           $this->config_mdl->_query("UPDATE os_empleados SET os_empleados.empleado_conexion='0'");
       }else{
           $this->config_mdl->_update_data('os_empleados',array(
                'empleado_conexion'=>'0'
           ),array(
               'empleado_id'=> $this->input->post('empleado_id')
           ));
       }
       
       $this->setOutput(array('accion'=>'1'));
   }
   public function AjaxRecargarPagina() {
      $this->config_mdl->_update_data('os_empleados',array(
            'empleado_pagina_reload'=>'Si'
       ),array(
           'empleado_id'=> $this->input->post('empleado_id')
       ));  
       $this->setOutput(array('accion'=>'1'));
   }
   public function AjaxCheckSesion() {
       $sql= $this->config_mdl->_get_data_condition('os_empleados',array(
          'empleado_id'=> $this->UMAE_USER 
        ));
        if($sql[0]['empleado_conexion']=='1'){
            if(!isset($_SESSION['UMAE_USER'])){
                $this->setOutput(array('accion'=>'3'));
            }else if($sql[0]['empleado_pagina_reload']=='Si'){
                $this->config_mdl->_update_data('os_empleados',array(
                    'empleado_pagina_reload'=>'No'
                ),array(
                    'empleado_id'=> $this->UMAE_USER 
                ));
                $this->setOutput(array('accion'=>'4'));
            }else{
                $this->setOutput(array('accion'=>'1'));
            }
           
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
   }
   public function MiPerfil() {
       $sql['info']= $this->config_mdl->_get_data_condition('os_empleados',array(
           'empleado_id'=> $this->UMAE_USER
       ));
       $sql['Especialidades']=  $this->config_mdl->sqlGetData('um_especialidades');
       $sql['Roles']= $this->config_mdl->_query("SELECT * FROM os_empleados, os_roles, os_empleados_roles
            WHERE
            os_empleados_roles.empleado_id=os_empleados.empleado_id AND
            os_empleados_roles.rol_id=os_roles.rol_id AND
            os_empleados.empleado_id=".$this->UMAE_USER);
       $this->load->view('Sections/Usuarios/MiPerfil',$sql);
   }
   public function AjaxMiPerfil() {
       if(isset($_POST['empleado_sc'])){
           $empleado_sc='Si';
       }else{
           $empleado_sc='No';
       }
       $data=array(
           'empleado_nombre'=> $this->input->post('empleado_nombre'),
           'empleado_sexo'=> $this->input->post('empleado_sexo'),
           'empleado_apellidos'=> $this->input->post('empleado_apellidos'),
           'empleado_sexo'=> $this->input->post('empleado_sexo'),
           'empleado_fecha_nac'=> $this->input->post('empleado_fecha_nac'),
           'empleado_estado'=> $this->input->post('empleado_estado'),
           'empleado_tel'=> $this->input->post('empleado_tel'),
           'empleado_email'=> $this->input->post('empleado_email'),
           'empleado_categoria'=> $this->input->post('empleado_categoria'),
           'empleado_departamento'=> $this->input->post('empleado_departamento'),
           // 'empleado_servicio'=>        $this->input->post('empleado_servicio'),
           'empleado_cedula'=>          $this->input->post('empleado_cedula'),
           'empleado_turno'=> $this->input->post('empleado_turno'),
           'empleado_sc'=> $empleado_sc,
           'empleado_password'=> sha1($this->input->post('empleado_password')),
           'empleado_base64'=> base64_encode($this->input->post('empleado_password')) 
       );
       $this->config_mdl->_update_data('os_empleados',$data,array(
           'empleado_id'=> $this->UMAE_USER
       ));
       $this->setOutput(array('accion'=>'1'));
   }
   public function CambiarPerfil() {
       $this->load->view('Usuarios/CambiarPerfil');
   }
   public function AjaxCambiarPerfil() {
       $this->config_mdl->_update_data('os_empleados',array(
           'empleado_perfil'=> $this->input->post('empleado_perfil')
       ),array(
           'empleado_id'=> $this->UMAE_USER
       ));
       $this->setOutput(array('accion'=>'1'));
   }
   public function AjaxReiniciarSesion() {
        $this->config_mdl->_update_data('os_empleados',array(
            'empleado_conexion'=>'1'
        ),array(
            'empleado_id'=> $this->UMAE_USER
        ));
       
       $this->setOutput(array('accion'=>'1'));
   }
   public function AjaxBuscarEmpleado() {
       $sql= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
           'empleado_matricula'=> $this->input->post('empleado_matricula')
       ),'empleado_id,empleado_nombre,empleado_apellidos,empleado_nivel_acceso');
       if(!empty($sql)){
           $this->setOutput(array('accion'=>'1',
               'empleado_id'=>$sql[0]['empleado_id'],
               'empleado_nombre'=>$sql[0]['empleado_nombre'],
               'empleado_apellidos'=>$sql[0]['empleado_apellidos'],
               'empleado_nivel_acceso'=>$sql[0]['empleado_nivel_acceso']
            ));
       }else{
           $this->setOutput(array('accion'=>'2'));
       }
   }
}
