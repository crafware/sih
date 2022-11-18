<?php

/**
 * Description of Movil
 *
 * @author felipe de jesus <itifjpp@gmail.com>
 */
class Movil extends MX_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model(array(
            'config/config_mdl'
        ));
        date_default_timezone_set('America/Mexico_City');
    }

    public function index() {
        $this->load->view('Movil');
        
    }
        public function GenerarFolio() {
        $data=array(
            'triage_horacero_h'=>  date('H:i'),
            'triage_horacero_f'=>  date('Y-m-d'),
            'triage_crea_horacero'=>1
        );
        $this->config_mdl->_insert('os_triage',$data);
        $last_id=  $this->config_mdl->_get_last_id('os_triage','triage_id');
        $this->config_mdl->_insert('paciente_info',array(
            'triage_id'=>$last_id
        ));
        // Es lo mismo que: $this->AccesosUsuarios(array('acceso_tipo'=>'Hora Cero','triage_id'=>$last_id,'areas_id'=>$last_id));
        Modules::run('Config/AccesosUsuarios',array(
            'acceso_tipo'=>'Hora Cero','triage_id'=>$last_id,'areas_id'=>$last_id
        ));
        file_put_contents("assets/AutoPrint.txt",$last_id);
        $this->config_mdl->_update_data('hc_movil',array(
            'mv_status'=>'true',
            'triage_id'=>$last_id
        ),array(
            'mv_id'=>1
        ));
        // Es lo mismo que: $this->setOutput(array('accion'=>'1','max_id'=>$last_id));
        Modules::run('Config/setOutput',array(
            'accion'=>'1','max_id'=>$last_id
        ));
    }
    public function GenerarTicket($folio) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $folio
        ))[0];
        $this->load->view('horacero/MovilTicket',$sql);
    }



    public function Check() {
        $this->load->view('MovilCheck');
    }
    public function AjaxCheck() {
        $sql= $this->config_mdl->_get_data_condition('hc_movil',array(
            'mv_status'=>'true'
        ));
        if(!empty($sql)){
            $this->config_mdl->_update_data('hc_movil',array(
                'mv_status'=>'false',
                'triage_id'=>0
            ),array(
                'mv_id'=>1
            ));
            Modules::run('Config/setOutput',array(
                'accion'=>'1','max_id'=>$sql[0]['triage_id']
            ));
        }else{
            Modules::run('Config/setOutput',array(
                'accion'=>'2'
            ));
        }
    }
}
