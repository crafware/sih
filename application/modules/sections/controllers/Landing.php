<?php

/**
 * Description of Landing
 *
 * @author felipe de jesus <itifjpp@gmail.com>
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Landing extends Config{
    public function index() {
        $this->load->view('Landing/index');
    }
}
