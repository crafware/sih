<?php

/**
 * Description of Medico
 *
 * @author felipe de jesus <itifjpp@gmail.com>
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Medico extends Config{
    public function index() {
        $this->load->view('Medico');
    }
    public function AjaxBuscarPaciente() {
        $sql= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(!empty($sql)){
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
}
