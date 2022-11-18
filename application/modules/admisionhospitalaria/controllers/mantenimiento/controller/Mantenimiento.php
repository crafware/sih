<?php
/**
 * Description beds of maintenance
 *
 * @author Adán Carrillo
 **/
require_once APPPATH.'modules/config/controllers/Config.php';
class Mantenimiento extends Config{
    public function __construct() {
        parent::__construct();
        $this->VerificarSession();
    }
    public function index() {   
        $this->load->view('index',$sql);
    } 
    public function TotalCamasEstatusPisos($Piso,$Estado) {
    return count($this->config_mdl->_query("SELECT os_camas.cama_id FROM os_camas, os_areas, os_pisos, os_pisos_camas
                                            WHERE os_areas.area_id=os_camas.area_id AND os_pisos_camas.cama_id=os_camas.cama_id AND os_camas.cama_status='$Estado' AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id AND os_pisos.piso_id=".$Piso));
            
    }
         
}  
