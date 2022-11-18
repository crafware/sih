<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Camas
 *
 * @author bienTICS
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Camas extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->view('choque_camas');
    }
    public function AjaxCamas() {
        $Camas=  $this->config_mdl->_query("SELECT * FROM os_camas WHERE os_camas.area_id=6");
        if(!empty($Camas)){
            foreach ($Camas as $value) {
                $sql_paciente=  $this->config_mdl->_query("SELECT * FROM os_triage, os_choque_camas, os_camas WHERE 
                        os_choque_camas.triage_id=os_triage.triage_id AND
                        os_choque_camas.cama_id=os_camas.cama_id AND os_triage.triage_id=".$value['cama_dh']);
                if($value["cama_status"]=="Disponible"){
                    $color='blue';
                    $accion='<button md-ink-ripple="" class="md-btn md-fab m-b green waves-effect tip btn-paciente-agregar" data-cama="'.$value['cama_id'].'"  data-original-title="Agregar Paciente">
                                <i class="mdi-content-add i-24" ></i>
                            </button>';
                    $paciente='<h6 style="font-size:11px">&nbsp;</h6>';
                    $enfermera='<h6 style="font-size:11px;margin-bottom:-12px">&nbsp;</h6>';
                }else{
                    if($value['cama_status']=='En Mantenimiento' || $value['cama_status']=='En Limpieza'){
                        $paciente='<h6 style="font-size:11px">&nbsp;</h6>';
                        $enfermera='<h6 style="font-size:11px;margin-bottom:-12px">&nbsp;</h6>';
                        if($value['cama_status']=='En Limpieza'){
                            $color='orange';
                        }else{
                            $color='red';
                        }
                        $Tarjeta='';
                        $Limpieza_Mantenimiento='<li><a class="finalizar-mantenimiento" data-id="'.$value['cama_id'].'">Finalizar Limpieza / Mantenimiento</a></li>';
                        $accion='';
                        $CambiarCama='';
                    }else{
                        $sql_ti= $this->config_mdl->_get_data_condition('os_tarjeta_identificacion',array('triage_id'=>$sql_paciente[0]['triage_id']))[0];
                        $sql_enf= $this->config_mdl->_get_data_condition('os_empleados',array('empleado_id'=>$sql_paciente[0]['enfermera_id']))[0];
                        
                        
                        $paciente='<h6 style="font-size:11px;margin-left: -12px;">PACIENTE: '.$sql_paciente[0]['triage_nombre'].'</h6>';
                        $enfermera='<h6 style="font-size:11px;margin-left: -12px;margin-bottom:-12px;text-transform: uppercase">ENF: '.$sql_enf['empleado_nombre'].' '.$sql_enf['empleado_apellidos'].' <i class="fa fa-user-md pull-right pointer cambiar-enfermera i-16" style="margin-top:-3px" data-id="'.$sql_paciente[0]['triage_id'].'"></i></h6>';
                        $color='green';
                        $alta='<li><a class="alta-paciente" data-alta="'.$sql_paciente[0]['observacion_alta'].'" data-cama="'.$value['cama_id'].'" data-triage="'.$sql_paciente[0]['triage_id'].'">Alta Paciente</a></li>';
                        $Limpieza_Mantenimiento='';
                        
                        $Tarjeta='<li><a href="" class="add-tarjeta-identificacion" data-id="'.$sql_paciente[0]['triage_id'].'" data-enfermedad="'.$sql_ti['ti_enfermedades'].'" data-alergia="'.$sql_ti['ti_alergias'].'">Tarjeta de Identificación</a></li>';
                        $CambiarCama='<li><a href="" class="cambiar-cama-paciente" data-id="'.$sql_paciente[0]['triage_id'].'" data-area="'.$value['area_id'].'" data-cama="'.$value['cama_id'].'">Cambiar Cama</a></li>';
                        $list='<li><a href="'.  base_url().'Sections/Documentos/Expediente/'.$sql_paciente[0]['triage_id'].'/?tipo=Observación" target="_blank">Archivos Anexos</a></li>';
                    }
                    $accion='<ul class="list-inline">
                                    <li class="dropdown">
                                        <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                            <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">'.$alta.' '.$list.' '.$Limpieza_Mantenimiento.' '.$Tarjeta.' '.$CambiarCama.'</ul>
                                    </li>
                                </ul>';
                }
                $col_md_3.='<div class="col-md-4 cols-camas" style="padding: 3px;margin-top:-10px">
                                    <div class="card '.$color.' color-white">
                                        <div class="card-heading" >
                                            <h5 class="font-thin color-white" style="font-size:19px!important;margin-left: -15px;margin-top: 0px;text-transform: uppercase">
                                                <i class="fa fa-bed " ></i> <b>'.$value['cama_nombre'].'</b>
                                            </h5>
                                            <div class="row">
                                            <div class="col-md-4" style="margin-left: -14px;">
                                                <small style="opacity: 1;font-size: 11px"> 
                                                    <i class="fa fa-clock-o"></i> '.$value['cama_status'].'
                                                </small>
                                            </div>
                                            <div class="col-md-6" >
                                                <small style="opacity: 1;font-size: 11px;position:absolute;top: 0px;right: 0px"> 
                                                    '.$sql_paciente[0]['observacion_fl'].' '.$sql_paciente[0]['observacion_hl'].'
                                                </small>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="card-tools" style="right:2px;top:9px">'.$accion.'</div>
                                        <div class="card-divider" style="margin-top:-10px"></div>
                                        <div class="card-body" style="margin-top:-20px">
                                            '.$paciente.' '.$enfermera.'
                                        </div>
                                    </div>
                                </div>';
                $col_md_3.='';
            }
        }else{
            $col_md_3='NO_HAY_CAMAS';
        }
        $this->setOutput(array('result_camas'=>$col_md_3));
    }
    public function AjaxObtenerPaciente() {
        $sql= $this->config_mdl->_get_data_condition('os_choque_camas',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(!empty($sql)){
            if($sql[0]['cama_id']==''){
                $this->setOutput(array('accion'=>'1'));
            }else{
                if($sql[0]['choque_cama_status']=='Asignado'){
                    $this->setOutput(array('accion'=>'3'));
                }else{
                    $this->setOutput(array('accion'=>'4'));
                }
            }
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxReingreso() {
        $data=array(
            'choque_cama_fe'=>'',
            'choque_cama_he'=>'',
            'choque_cama_fs'=>'',
            'choque_cama_hs'=>'',
            'choque_cama_alta'=>'',
            'choque_cama_status'=>'',
            'cama_id'=>0,
            'empleado_id'=>0,
            'enfermera_id'=>0
        );
        $this->config_mdl->_update_data('os_choque_camas',$data,array(
           'triage_id'=> $this->input->post('triage_id') 
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxAsociarCama() {
        
        $data=array(
            'choque_cama_fe'=> date('d/m/Y'),
            'choque_cama_he'=> date('H:i'),
            'choque_cama_status'=>'Asignado',
            'cama_id'=> $this->input->post('cama_id'),
            'empleado_id'=> $this->UMAE_USER,
            'enfermera_id'=> $this->UMAE_USER,
            'triage_id'=> $this->input->post('triage_id')
        );
        $paciente= $this->config_mdl->_get_data_condition('os_choque_camas',array('triage_id'=> $this->input->post('triage_id')));
        if(empty($paciente)){
            $this->config_mdl->_insert('os_choque_camas',$data);
        }else{
            $this->config_mdl->_update_data('os_choque_camas',$data,array(
                'triage_id'=> $this->input->post('triage_id')
            ));
        }
        
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_ingreso_f'=> date('d/m/Y'),
            'cama_ingreso_h'=> date('H:i'),
            'cama_dh'=>$this->input->post('triage_id')
        ),array(
            'cama_id'=>  $this->input->post('cama_id')
        ));
        $choque_cama_id= $this->config_mdl->_get_last_id('os_choque_camas','choque_cama_id');
        $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso Choque','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$choque_cama_id));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxCambiarCama() {
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Disponible',
            'cama_ingreso_f'=> '',
            'cama_ingreso_h'=> '',
            'cama_dh'=>'0'
        ),array(
            'cama_id'=>  $this->input->post('cama_id_old')
        ));
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_ingreso_f'=> date('d/m/Y'),
            'cama_ingreso_h'=> date('H:i'),
            'cama_dh'=> $this->input->post('triage_id')
        ),array(
            'cama_id'=>  $this->input->post('cama_id_new')
        ));
        $this->config_mdl->_update_data('os_choque_camas',array(
            'cama_id'=>  $this->input->post('cama_id_new'),
            'choque_cama_fe'=> date('d/m/Y'),
            'choque_cama_he'=>  date('H:i') 
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_insert('os_camas_log',array(
            'cama_log_fecha'=> date('d/m/Y'),
            'cama_log_hora'=> date('H:i'),
            'cama_log_tipo'=>'Cambio de Cama',
            'cama_log_modulo'=>'Choque',
            'cama_id'=> $this->input->post('cama_id_new'),
            'triage_id'=> $this->input->post('triage_id'),
            'empleado_id'=> $this->UMAE_USER
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxCambiarEnfermera() {
        $sql= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(!empty($sql)){
            $choque= $this->config_mdl->_get_data_condition('os_choque_camas',array(
                'triage_id'=>  $this->input->post('triage_id')
            ))[0];
            $this->config_mdl->_insert('os_log_cambio_enfermera',array(
                'cambio_fecha'=> date('d/m/Y'),
                'cambio_hora'=> date('H:i'),
                'cambio_modulo'=>'Choque',
                'cambio_cama'=>$choque['cama_id'],
                'empleado_new'=> $sql[0]['empleado_id'],
                'empleado_old'=> $choque['enfermera_id'],
                'empleado_cambio'=> $this->UMAE_USER,
                'triage_id'=>$this->input->post('triage_id')
            ));
            
            $this->config_mdl->_update_data('os_choque_camas',array(
                'enfermera_id'=>$sql[0]['empleado_id']
            ),array(
                'triage_id'=>  $this->input->post('triage_id')
            ));
            $this->AccesosUsuarios(array('acceso_tipo'=>'Cambio de Enfermera Choque','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$choque['choque_cama_id']));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
}
