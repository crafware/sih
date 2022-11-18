<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Dashboard
 *
 * @author Adan Carrillo crafware@gmail.com
 */

 Class Dashboard extends MX_Controller{
 	public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model(array('config/config_mdl'));
        date_default_timezone_set('America/Mexico_City');
    }
    public function setOutput($json) {
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    } 
    public function AdmisionContinua() {

        $this->load->view('dashboard_ac');
    }
    public function AjaxDashboard_ac() {
    	$checkCamas=  $this->config_mdl->_query("SELECT * FROM os_camas WHERE  area_id='1' AND cama_status='Ocupado'");
        $checkConsultorios =  $this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad WHERE  ce_hf='Observación corta estancia'");
        $fecha_hoy = date("Y-m-d");
        $checkAsignados=  $this->config_mdl->_query("SELECT * FROM os_asistentesmedicas WHERE  asistentesmedicas_fecha='$fecha_hoy'");

    	
    	if(!empty($checkCamas)) {
	    	foreach ($checkCamas as $value) {
	    		$sqlPaciente= $this->config_mdl->_get_data_condition("os_triage",array(
	                        'triage_id'=>$value['triage_id']
	                    ))[0];
	    		 // $sql_enf= $this->config_mdl->_get_data_condition('os_empleados',array(
	       //                  'empleado_id'=>$sqlObs['observacion_crea']
	       //              ))[0];
	    		

	    		$sqlObsData= $this->config_mdl->_get_data_condition('os_observacion',array(
                        'triage_id'=>$value['triage_id']
                    ))[0];
	    		$listaPacientes .= '<li>
	    		 						<i class="'.$sqlPaciente['triage_color'].'"></i>
                                        <p class="ubicacion">'.$value['cama_nombre'].'</p>
                                        <p class="hr_ingreso">'.$value['cama_ingreso_h'].'</p>
                                        <p class="sender">'.$sqlPaciente['triage_nombre'].' '.$sqlPaciente['triage_nombre_ap'].'</p>
                                        <p class="message"><strong>Médico: </strong>'.$sqlObsData['asistentesmedicas_mt'].'</p>
                                        <div class="actions">
                                            
                                        </div>
                                    </li>';
                                    
	    	}
	    } else {
            $listaPacientes='NO_HAY_PACINTES';
        }
        if(!empty($checkConsultorios) ) {
                foreach ($checkConsultorios as $valor) {
                    $sqlPacienteCE= $this->config_mdl->_get_data_condition("os_triage",array(
                                'triage_id'=>$valor['triage_id']
                            ))[0];
                    $listaPacientesCortaEstancia .= '<li>
                                                        <i class="'.$sqlPacienteCE['triage_color'].'"></i>
                                                        <p class="ubicacion"></p>
                                                        <p class="hr_ingreso">'.$valor['ce_he'].'</p>
                                                        <p class="sender">'.$sqlPacienteCE['triage_nombre'].' '.$sqlPacienteCE['triage_nombre_ap'].' '.$sqlPacienteCE['triage_nombre_am'].'</p>
                                                        <p class="message"><strong>Médico: </strong>'.$sqlObsData['observacion_medico_nombre'].'</p>
                                                        <div class="actions">
                                                        </div>
                                                    </li>';
                }
            
            }else {
            $listaPacientesCortaEstancia='NO_HAY_PACIENTES';
        }
        if(!empty($checkAsignados))  {
            foreach ($checkAsignados as $paciente) {
                $sqlPacienteAsignado= $this->config_mdl->_get_data_condition("os_triage",array(
                            'triage_id'=>$paciente['triage_id']
                        ))[0];
                $sqlMedicoAsignado= $this->config_mdl->_get_data_condition("paciente_info",array(
                            'triage_id'=>$paciente['triage_id']
                        ))[0];
                $sqlConsultorios = $this->config_mdl->_get_data_condition("os_consultorios_especialidad", array(
                        'triage_id'=>$paciente['triage_id']))[0];
                switch($sqlConsultorios['ce_asignado_consultorio']) {
                    case "Consultorio 1 AC":
                        $consultorio = "CONS 1";
                        break;
                    case "Consultorio 2 AC":
                        $consultorio = "CONS 2";
                        break;
                    case "Consultorio 3 AC":
                        $consultorio = "CONS 3";
                        break;
                    case "Consultorio 4 AC":
                        $consultorio = "CONS 4";
                        break;
                    case "Consultorio 5 AC":
                        $consultorio = "CONS 5";
                        break;
                }
                
                if($paciente['asistentesmedicas_mt']== "") {
                $listaPacientesAsignados .= '<li>
                                                    <i class="'.$sqlPacienteAsignado['triage_color'].'"></i>
                                                    <p class="ubicacion">'.$consultorio.'</p>
                                                    <p class="hr_ingreso">'.$paciente['asistentesmedicas_hora'].'</p>
                                                    <p class="sender">'.$sqlPacienteAsignado['triage_nombre'].' '.$sqlPacienteAsignado['triage_nombre_ap'].'</p>
                                                    <p class="message"><strong>Médico: </strong>'.$sqlMedicoAsignado['pic_mt'].'</p>
                                                    <div class="actions">
                                                    </div>
                                                </li>';
                }
            }
        }else {
            $listaPacientesAsignados='NO_HAY_PACINTES';
        }
        $this->setOutput(array(
                        'listaPacientes'                => $listaPacientes,
                        'listaPacientesCortaEstancia'   => $listaPacientesCortaEstancia,
                        'listaPacientesAsignados'        => $listaPacientesAsignados
                                ));


    }
}
   