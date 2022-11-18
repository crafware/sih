<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Horacero
 *
 * @author felipe de jesus
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Horacero extends Config{
    public function __construct() {
        parent::__construct();
        //$this->VerificarSession();
    }

    public function index() {
        $this->load->view('horacero/index');
    }
    public function GenerarTicket($folio) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $folio
        ))[0];
        $this->load->view('horacero/generar_ticket',$sql);
    }
    public function Indicador() {
        $this->load->view('horacero/indicador');
    }
    
    //Datos
    public function GenerarFolio() {
        $data=array(
            'triage_horacero_h'=>  date('H:i'),
            'triage_horacero_f'=>  date('Y-m-d'),
            'triage_crea_horacero'=>$_SESSION['UMAE_USER']
        );
        $this->config_mdl->_insert('os_triage',$data);
        $last_id=  $this->config_mdl->_get_last_id('os_triage','triage_id');
        $this->config_mdl->_insert('paciente_info',array(
            'triage_id'=>$last_id
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Hora Cero','triage_id'=>$last_id,'areas_id'=>$last_id));
        $this->setOutput(array('accion'=>'1','max_id'=>$last_id));
    }
    public function AjaxIndicador() {
        $UMAE_USER=$_SESSION['UMAE_USER'];
        $inputFecha= $this->input->post('inputFecha');
        $sql=  $this->config_mdl->_query("SELECT * FROM os_triage WHERE os_triage.triage_crea_horacero=$UMAE_USER AND  os_triage.triage_horacero_f='$inputFecha' ORDER BY os_triage.triage_id DESC");
            
        if(!empty($sql)){
            foreach ($sql as $value) {
                $tr.=' <tr>
                            <td>'.$value['triage_id'].'</td>
                            <td>'.$value['triage_horacero_f'].'</td>
                            <td>'.$value['triage_horacero_h'].'</td>
                       </tr>';
            }
        }else{
            $tr.=' <tr>
                            <td colspan="3">NO HAY REGISTROS PARA ESTE CRITERIO DE BUSQUEDA</td>
                       </tr>';
        }
        $total= count($sql);
        $this->setOutput(array('tr'=>$tr,'total'=>$total));
    }
}
