<?php

/**
 * Description of Configuracion
 *
 * @author felipe de jesus <itifjpp@gmail.com>
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Configuracion extends Config{
    public function index() {
        $this->load->view('Configuracion/index');
    }
}
