<?php

/**
 * Description of Vigilancia
 *
 * @author felipe de jesus <itifjpp@gmail.com>
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Vigilancia extends Config{
    public function Accesos() {
        $this->load->view('Accesos/Accesos');
    }
    public function AjaxAccesos() {
        $sqlCheck= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas WHERE os_camas.area_id=os_areas.area_id AND
                                            os_camas.cama_dh=".$this->input->post('triage_id'));
        if(!empty($sqlCheck)){
            if($sqlCheck[0]['area_modulo']=='Pisos'){
                $this->setOutput(array('accion'=>'1','tipo'=>'Pisos'));
            }else if($sqlCheck[0]['area_modulo']=='Observación'){
                $this->setOutput(array('accion'=>'1','tipo'=>'Observación'));
            }else if($sqlCheck[0]['area_modulo']=='Choque'){
                $this->setOutput(array('accion'=>'1','tipo'=>'Choque'));
            }else{
                $this->setOutput(array('accion'=>'3'));
            }
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function Paciente($Paciente) {
        $sql['info']= $this->config_mdl->sqlGetDataCondition('os_triage',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['Familiares']= $this->config_mdl->sqlGetDataCondition('um_poc_familiares',array(
            'familiar_tipo'=>$_GET['tipo'],
            'triage_id'=>$Paciente
        ));
        $this->load->view('Accesos/Paciente',$sql);
    }
}
