<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Laboratorio
 *
 * @author Adan Carrillo
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Laboratorio extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() { 
        $this->load->view('laboratorio/index');
    }

    public function Obtenerpacientes() {
        if($this->input->get_post('area')=='admisionContinua'){
            $sql=$this->config_mdl->_query("SELECT os_triage.triage_id,os_triage.triage_paciente_sexo,os_triage.triage_fecha_nac,
            os_triage.triage_nombre, os_triage.triage_nombre_ap, os_triage.triage_nombre_am,os_triage.triage_fecha_clasifica,os_triage.triage_hora_clasifica,
            paciente_info.pum_nss,paciente_info.pum_nss_agregado,paciente_info.pic_mt
            FROM os_triage, os_accesos, os_asistentesmedicas, paciente_info
            WHERE
            os_accesos.acceso_tipo='Asistente Médica' AND
            os_accesos.triage_id=os_triage.triage_id AND
            os_accesos.areas_id=os_asistentesmedicas.asistentesmedicas_id AND
            os_asistentesmedicas.asistentesmedicas_fecha=CURDATE() AND
            paciente_info.triage_id=os_triage.triage_id
            ORDER BY os_accesos.acceso_id LIMIT 100");
        $title="Pacientes en Admisión Continua";
        
        }else {
            $sql=$this->config_mdl->_query("SELECT * FROM doc_43051 INNER JOIN os_triage INNER JOIN paciente_info WHERE doc_43051.triage_id = os_triage.triage_id
            AND doc_43051.triage_id = paciente_info.triage_id LIMIT 150");
            $title="Pacientes Hospitalizados";
        }
        if(!empty($sql)){
           foreach ($sql as $value) {

               $tr.='<tr>
                        <td>'.$value['triage_id'].'</td>
                        <td>'.$value['triage_fecha_clasifica'].' '.$value['triage_hora_clasifica'].'</td>
                        <td>'.$value['triage_paciente_sexo'].'</td>
                        <td>'.$value['triage_nombre'].' '.$value['triage_nombre_ap'].' '.$value['triage_nombre_am'].'</td>
                        <td>'.$value['pum_nss'].' '. $value['pum_nss_agregado'].'</td>
                        <td>'.$value['triage_fecha_nac'].'</td>
                        <td>'.$value['pic_mt'].'</td>
                    </tr>';
            }
        }else{
           $tr.='<tr>
                    <td colspan="7">EL CRITERIO DE BUSQUEDA NO ARROJADO NINGÚN REGISTRO</td>
                </td>';
       }
       $this->setOutput(array('tr'=>$tr, 'title'=>$title));
    }
}
    
   