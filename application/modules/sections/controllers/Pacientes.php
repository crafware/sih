<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pacientes
 *
 * @author bienTICS
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Pacientes extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->view('Pacientes/index');
    }
    public function ObtenerPacienteFolio() {
        $sql= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(empty($sql)){
            $this->setOutput(array('accion'=>'2'));
        }else{
            $this->setOutput(array('accion'=>'1'));
        }
    }
    public function AjaxPaciente() {
        $inputSelect= $this->input->post('inputSelect');
        $inputSearch= $this->input->post('inputSearch');
        if($inputSelect=='POR_NUMERO'){
            /*$sql= $this->config_mdl->_query("SELECT triage_id,triage_horacero_f, CONCAT_WS(' ',triage_nombre_ap,triage_nombre_am,triage_nombre) AS nombre_paciente
                                            FROM os_triage WHERE triage_id=".$inputSearch);*/
            $sql= $this->config_mdl->_query("SELECT os_triage.triage_id, os_triage.triage_horacero_f, CONCAT_WS(' ',triage_nombre_ap,triage_nombre_am,triage_nombre) AS nombre_paciente, CONCAT_WS(' ',pum_nss,pum_nss_agregado) AS nss, pum_nss_armado FROM os_triage JOIN paciente_info ON paciente_info.triage_id = os_triage.triage_id WHERE paciente_info.triage_id='".$inputSearch."'");
                                            
        }if($inputSelect=='POR_NOMBRE'){
            $sql=  $this->config_mdl->_query("SELECT os_triage.triage_id, os_triage.triage_horacero_f,CONCAT_WS(' ',TRIM(os_triage.triage_nombre_ap),TRIM(os_triage.triage_nombre_am),TRIM(os_triage.triage_nombre)) AS nombre_paciente, CONCAT_WS(' ',pum_nss, pum_nss_agregado) AS nss, pum_nss_armado FROM os_triage JOIN paciente_info ON paciente_info.triage_id = os_triage.triage_id HAVING nombre_paciente LIKE '%$inputSearch%' LIMIT 100");

        }if($inputSelect=='POR_NSS'){
            $sql= $this->config_mdl->_query("SELECT os_triage.triage_id, os_triage.triage_horacero_f, CONCAT_WS(' ',triage_nombre_ap,triage_nombre_am,triage_nombre) AS nombre_paciente, CONCAT_WS(' ',pum_nss,pum_nss_agregado) AS nss, pum_nss_armado FROM os_triage, paciente_info WHERE
                                            paciente_info.triage_id=os_triage.triage_id AND
                                            paciente_info.pum_nss='".$inputSearch."'");
        }
        if(!empty($sql)){
            foreach ($sql as $value) {
                $triage_horacero_f = date("d/m/Y", strtotime($value['triage_horacero_f']));
               
                $nss = ($value['nss']!=' ') ? $value['nss'] : $value['pum_nss_armado'];

                if ($this->UMAE_AREA == 'Consulta Externa Medico') {
                    $tr.='<tr>
                        <td>'.$value['triage_id'].'</td>
                        <td>'.date("d/m/Y", strtotime($value['triage_horacero_f'])).'</td>
                        <td>'.$value['nombre_paciente'].'</td>
                        <td>'.$nss.'</td>
                        <td>
                            <i class="fa fa-print icono-accion tip pointer iconoPrintTicket" data-id="'.$value['triage_id'].'" data-original-title="Reimprimir Orden de Internamiento"></i>&nbsp;
                            <a href="'.base_url().'Sections/Pacientes/Paciente/'.$value['triage_id'].'" target="_blank" rel="opener">
                                <i class="fa fa-share-square-o icono-accion tip" data-original-title="Ver Historial del Paciente"></i>
                            </a>
                            <a href="'.base_url().'Consultaexterna/Ordeninternamiento/'.$value['triage_id'].'" target="_blank">
                                <i class="fa fa-pencil icono-accion tip" data-original-title="Registrar/Editar Orden de Internamiento"></i>
                            </a>
                        </td>
                    <tr>';

                }else if($this->UMAE_AREA == 'Asistente Médica Admisión Continua'){

                    $tr.='<tr>
                            <td>'.$value['triage_id'].'</td>
                            <td>'.date("d/m/Y", strtotime($value['triage_horacero_f'])).'</td>
                            <td>'.$value['nombre_paciente'].'</td>
                            <td>'.$nss.'</td>
                            <td>
                                <i class="fa fa-print icono-accion tip pointer iconoPrintTicket" data-id="'.$value['triage_id'].'" data-original-title="Reimprimir Ticket del Paciente"></i>&nbsp;
                                <a href="'.base_url().'Sections/Pacientes/Paciente/'.$value['triage_id'].'" target="_blank">
                                    <i class="fa fa-share-square-o icono-accion tip" data-original-title="Ver Historial del Paciente"></i>
                                </a>
                                <a href="'.base_url().'Asistentesmedicas/Triagerespiratorio/Registro/'.$value['triage_id'].'" target="_blank" rel="opener">
                                    <i class="fa fa-pencil icono-accion tip" data-original-title="Registrar 43051"></i>
                                </a>
                            </td>
                        <tr>';
                }else {
                    if ($this->UMAE_AREA == 'Médico Hospitalización'){
                        $area = 'Hospitalizacion';
                    }
                    $tr.='<tr>
                            <td>'.$value['triage_id'].'</td>
                            <td>'.date("d-m-Y", strtotime($value['triage_horacero_f'])).'</td>
                            <td>'.$value['nombre_paciente'].'</td>
                            <td>'.$nss.'</td>
                            <td>
                                <a href="'.base_url().'Sections/Documentos/Expediente/'.$value['triage_id'].'?tipo='.$area.'" target="_blank">
                                <i class="fa fa fa-file-text icono-accion tip" data-original-title="Ver Expediente del Paciente"></i>
                                </a>
                            </td>
                        <tr>';
                    }
            }
            $this->setOutput(array('accion'=>'1','tr'=>$tr));
        }else{
            $tr.='<tr>
                        <td colspan="5" class="text-center mayus-bold"><i class="fa fa-frown-o fa-3x" style="color:#256659"></i><br>No se encontro ningún registro</td>
                    <tr>';
            $this->setOutput(array('accion'=>'1','tr'=>$tr));
        }
    }
    public function Paciente($Paciente) {
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['Historial']= $this->config_mdl->_query("SELECT * FROM os_accesos, os_empleados, os_triage
                            WHERE
                            os_accesos.empleado_id=os_empleados.empleado_id AND
                            os_accesos.triage_id=os_triage.triage_id AND
                            os_triage.triage_id='".$Paciente."' ORDER BY os_accesos.acceso_id ASC");
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['PacientesLog']= $this->config_mdl->_query("SELECT * FROM os_empleados, um_pacientes_log
                                WHERE os_empleados.empleado_id=um_pacientes_log.empleado_id AND
                                um_pacientes_log.triage_id='".$Paciente."'");
        $sql['PacientesCamas']= $this->config_mdl->_query("SELECT * FROM os_camas_log,os_camas, os_empleados WHERE os_camas_log.empleado_id=os_empleados.empleado_id AND
                                os_camas_log.cama_id=os_camas.cama_id AND
                                os_camas_log.triage_id='".$Paciente."'");
        $sql['PacientesEnfermera']= $this->config_mdl->_query("SELECT * FROM os_log_cambio_enfermera, os_empleados, os_camas WHERE
                                os_log_cambio_enfermera.empleado_cambio=os_empleados.empleado_id AND
                                os_camas.cama_id=os_log_cambio_enfermera.cambio_cama AND os_log_cambio_enfermera.triage_id='".$Paciente."'");
        $this->load->view('Pacientes/pacienteV2',$sql);
    }
    public function Choque($Paciente) {
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['choque']= $this->config_mdl->_get_data_condition('os_choque_v2',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['IngresoChoque']= $this->config_mdl->_query("SELECT * FROM os_accesos, os_choque_v2, os_triage, os_empleados WHERE
            os_accesos.acceso_tipo='Hora Cero Choque' AND
            os_accesos.areas_id=os_choque_v2.choque_id AND
            os_accesos.empleado_id=os_empleados.empleado_id AND
            os_accesos.triage_id=os_triage.triage_id AND
            os_triage.triage_id=".$Paciente)[0];
        $sql['IngresoChoqueEnf']= $this->config_mdl->_query("SELECT * FROM os_accesos, os_choque_v2, os_triage, os_empleados WHERE
            os_accesos.acceso_tipo='Ingreso Choque (Asignación Cama)' AND
            os_accesos.areas_id=os_choque_v2.choque_id AND
            os_accesos.empleado_id=os_empleados.empleado_id AND
            os_accesos.triage_id=os_triage.triage_id AND
            os_triage.triage_id=".$Paciente)[0];
        $sql['IngresoChoqueMed']= $this->config_mdl->_query("SELECT * FROM os_accesos, os_choque_v2, os_triage, os_empleados WHERE
            os_accesos.acceso_tipo='Médico Choque' AND
            os_accesos.areas_id=os_choque_v2.choque_id AND
            os_accesos.empleado_id=os_empleados.empleado_id AND
            os_accesos.triage_id=os_triage.triage_id AND
            os_triage.triage_id=".$Paciente)[0];
        $sql['Cama']= $this->config_mdl->_get_data_condition('os_camas',array(
            'cama_id'=>$sql['choque']['cama_id']
        ))[0];
        $this->load->view('Pacientes/pacienteChoque',$sql);
    }
    public function SignosVitales($Paciente) {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage_signosvitales, os_empleados
                WHERE os_triage_signosvitales.empleado_id=os_empleados.empleado_id AND
                os_triage_signosvitales.triage_id=".$Paciente);
        $this->load->view('Pacientes/pacienteChoqueSV',$sql);
    }
    public function ObtenerEmpleadoTriage($triage,$campo) {
        return $this->config_mdl->_query("SELECT * FROM os_triage, os_empleados
            WHERE os_empleados.empleado_id=os_triage.$campo AND os_triage.triage_id=".$triage );
    }
    public function ObtenerCE($triage) {
        return $this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad, os_empleados
            WHERE os_empleados.empleado_id=os_consultorios_especialidad.ce_crea AND os_consultorios_especialidad.triage_id=".$triage );
    }
    public function ObtenerOC($triage,$tipo) {
        return $this->config_mdl->_query("SELECT * FROM os_empleados, os_observacion
            WHERE os_empleados.empleado_id=os_observacion.$tipo AND os_observacion.triage_id=".$triage );
    }
    public function CambiarDestino() {
        $info= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $data=array(
            'triage_consultorio'=>'0',
            'triage_observacion'=> 'Observación',
            'triage_consultorio_nombre'=> $this->input->post('destino')
        );
        if($this->input->post('destino')=='Observación'){
            $this->config_mdl->_delete_data('os_consultorios_especialidad',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_consultorios_especialidad_hf',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_consultorios_especialidad_cpr',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_consultorios_especialidad_cpr',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_consultorios_especialidad_llamada',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_observacion',array(
                'observacion_modulo'=>'Choque',
                'triage_id'=> $this->input->post('triage_id')
            ));
            if($this->CalculaEdad($info['triage_fecha_nac'])->y<15){
                $observacion_area='3';
            }else{
                if($info['triage_paciente_sexo']=='MUJER'){
                    $observacion_area='4';
                }else{
                    $observacion_area='5';
                }
            }
            $this->config_mdl->_insert('os_observacion',array(
                'observacion_fe'=>  date('d/m/Y'),
                'observacion_he'=>date('H:i'),
                'triage_id'=>$this->input->post('triage_id'),
                'observacion_area'=>$observacion_area,
                'observacion_modulo'=>'Observación'
            ));

        }if($this->input->post('destino')=='Choque'){
            $this->config_mdl->_delete_data('os_consultorios_especialidad',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_consultorios_especialidad_hf',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_consultorios_especialidad_cpr',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_consultorios_especialidad_cpr',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_consultorios_especialidad_llamada',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_observacion',array(
                'observacion_modulo'=>'Observación',
                'triage_id'=> $this->input->post('triage_id')
            ));
            $this->config_mdl->_insert('os_observacion',array(
                'observacion_fe'=>  date('d/m/Y'),
                'observacion_he'=>date('H:i'),
                'triage_id'=>$this->input->post('triage_id'),
                'observacion_area'=>'6',
                'observacion_modulo'=>'Choque'
            ));
        }if($this->input->post('destino')=='Filtro'){
            unset($data['triage_observacion']);
            $this->config_mdl->_delete_data('os_observacion',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_observacion_cci',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_observacion_ci',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_observacion_cirugiasegura',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_observacion_isq',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_observacion_llamada',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_delete_data('os_observacion_solicitudtransfucion',array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_insert('os_consultorios_especialidad',array(
                'triage_id'=>  $this->input->post('triage_id'),
                'ce_fe'=>date('d/m/Y'),
                'ce_he'=>  date('H:i'),
                'ce_status'=>'En Espera',
                'ce_via'=>'Triage'
            ));
        }
        $this->config_mdl->_update_data('os_triage',$data,array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function Buscar() {
        $this->load->view('Pacientes/Buscar');
    }
    public function AjaxBuscar() {
        $sql= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(!empty($sql)){
            $pum= $this->config_mdl->_get_data_condition('paciente_info',array(
                'triage_id'=> $this->input->post('triage_id')
            ));
            $this->setOutput(array('accion'=>'1','paciente'=>$sql[0],'pum'=>$pum[0]));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxActualizarInfo() {
        $this->config_mdl->_update_data('os_triage',array(
            'triage_nombre'=> $this->input->post('triage_nombre'),
            'triage_nombre_ap'=> $this->input->post('triage_nombre_ap'),
            'triage_nombre_am'=> $this->input->post('triage_nombre_am')
        ),array(
            'triage_id'=> $this->input->post('triage_id_val')
        ));
        $this->config_mdl->_update_data('paciente_um',array(
            'pum_nss'=> $this->input->post('pum_nss'),
            'pum_nss_agregado'=> $this->input->post('pum_nss_agregado'),
        ),array(
            'triage_id'=> $this->input->post('triage_id_val')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxEliminarHistorial() {
//        $this->config_mdl->_delete_data('um_pisos_log_del',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('um_pisos_log',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('um_pacientes_log',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('um_cie10_hojafrontal',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('ts_ministerio_publico',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('paciente_info',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_triage_signosvitales',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_triage_pulseras',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_triage_po',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_triage_numcon_log',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_triage_empresa',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_triage_directorio',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_triage_clasificacion',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_tarjeta_identificacion',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_quirofano_consumo',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_quirofano_cq',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_quirofano_ce',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_quirofanos_pacientes',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_observacion_tratamientos',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_observacion_solicitudtransfucion',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_observacion_llamada',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_observacion_isq',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_observacion_cirugiasegura',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_observacion_ci',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_observacion_cci',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_observacion',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_modulo',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('os_log_cambio_enfermera',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('um_pisos_log_del',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('um_pisos_log_del',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('um_pisos_log_del',array('triage_id'=> $this->input->post('triage_id')));
//        $this->config_mdl->_delete_data('um_pisos_log_del',array('triage_id'=> $this->input->post('triage_id')));
        $this->setOutput(array('accion'=>'1'));
    }
}
