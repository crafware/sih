<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'modules/config/controllers/Config.php';
class Notificaciones extends Config {
    public function __construct() {
      parent::__construct();
    }

    public function index() {
        $sql['Gestion']=  $this->config_mdl->_get_data('os_notificaciones');
        $this->load->view('notificaciones/index',$sql);
    }
    public function MarcarComoVisto() {
        $this->config_mdl->_update_data('os_notificaciones',array(
            'notificacion_status'=>'Leido'
        ),array(
            'notificacion_id'=>  $this->input->post('id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
}
