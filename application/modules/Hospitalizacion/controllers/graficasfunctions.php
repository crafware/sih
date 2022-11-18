<?php 

require_once APPPATH.'modules/config/controllers/Config.php';
class Graficasfunctions extends Config{
    public function __construct() {
        parent::__construct();
    }
    
    public function InterconsultasSolicitadas($data) {
        $fechaInicial=$data['fechaInicial'];
        $fechaFinal=$data['fechaFinal'];
        $servicioEnvia=$data['servicioEnvia'];
        return $this->config_mdl->_query("SELECT doc_id, doc_servicio_envia FROM doc_430200
                WHERE doc_servicio_envia = '$servicioEnvia' AND doc_fecha  
                BETWEEN '$fechaInicial' AND '$fechaFinal'"); 
    }

    public function InterconsultasAtendidas($data) {
        $fechaInicial=$data['fechaInicial'];
        $fechaFinal=$data['fechaFinal'];
        $servicioAtiende=$data['servicioAtiende'];
        return $this->config_mdl->_query("SELECT * FROM doc_430200
                WHERE doc_servicio_solicitado = '$servicioAtiende' AND doc_fecha  
                BETWEEN '$fechaInicial' AND '$fechaFinal'"); 
    }

    public function InterconsultasPorEspecilidadSolicitadas($data) {
        $fechaInicial=$data['fechaInicial'];
        $fechaFinal=$data['fechaFinal'];
        $servicioAtiende=$data['servicioAtiende'];
        $servicioEnvia=$data['servicioEnvia'];
        return $this->config_mdl->_query("SELECT doc_id, doc_servicio_solicitado FROM doc_430200
                WHERE doc_servicio_solicitado = '$servicioAtiende' 
                AND doc_servicio_envia = '$servicioEnvia'
                AND doc_fecha BETWEEN '$fechaInicial' AND '$fechaFinal'"); 
    }

    public function InterconsultasPorEspecilidadRealizadas($data) {
        $fechaInicial=$data['fechaInicial'];
        $fechaFinal=$data['fechaFinal'];
        $servicioAtiende=$data['servicioAtiende'];
        $servicioEnvia=$data['servicioEnvia'];
        return $this->config_mdl->_query("SELECT doc_id, doc_servicio_solicitado FROM doc_430200
                WHERE doc_servicio_solicitado = '$servicioAtiende' 
                AND doc_servicio_envia = '$servicioEnvia'
                AND doc_estatus = 'Evaluado'
                AND doc_fecha BETWEEN '$fechaInicial' AND '$fechaFinal'"); 
    }

}