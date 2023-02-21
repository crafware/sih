<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * Description of Documentos
 *
 * @author bienTICS
 */
require_once APPPATH . 'modules/config/controllers/Config.php';
class SolicitudDeIntervencion extends Config
{
    public function index($folio){
        $sql["info"]        = $this->config_mdl->_query("SELECT * FROM os_triage, doc_43051 WHERE 
                                                os_triage.triage_id = doc_43051.triage_id AND
                                                os_triage.triage_id = " . $folio)[0];
        $sql["PINFO"]       = $this->config_mdl->_query("SELECT * FROM paciente_info WHERE triage_id = " . $folio)[0];
        $sql["cama"]        = $this->config_mdl->_query("SELECT * FROM os_camas, os_pisos WHERE 
                                                os_camas.area_id = os_pisos.area_id AND 
                                                os_camas.triage_id = " . $folio)[0];
        //$sql['solicitudes'] = $this->config_mdl->_get_data_condition('um_solicitudesintervencionqx', array('triage_id' => $folio));
        $sql['solicitudes'] = $this->config_mdl->_query("SELECT * FROM um_solicitudesintervencionqx, um_cie9 WHERE 
                                                um_solicitudesintervencionqx.id_cie9  = um_cie9.id_cie9 AND 
                                                um_solicitudesintervencionqx.triage_id  = " . $folio." ORDER BY solicitudInt_id" );
        $sql['um_cie9'] = $this->config_mdl->_query("SELECT * FROM um_cie9");

        $sql['MedicosBase'] = $this->config_mdl->_query("SELECT empleado_id, empleado_matricula,empleado_nombre, empleado_apellidos FROM os_empleados
                                                WHERE empleado_roles != 77 AND empleado_servicio = ".Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)));


        $this->load->view('Documentos/TratamientoQuirurgico/SolicitudeIntervencion', $sql);
    }
    public function AjaxSolicitudeIntervencion(){  
        $fecha2 = explode("/", $this->input->post('fecha_solicitud'));
        $fecha3 = $fecha2[2]."-".$fecha2[1]."-".$fecha2[0];
        if ($this->input->post('editar_solicitud') == "no")
            $fecha_orden = date("Y-m-d H:i");
        else if ($this->input->post('editar_solicitud') == "si")
            $fecha_orden = $this->input->post('fecha_orden');
        $data = array(
            'fecha_solicitud'               => $fecha3,
            'hora_solicitud'                => $this->input->post('hora_solicitud'),
            'fecha_orden'                   => $fecha_orden,
            'triage_id'                     => $this->input->post('triage_id'),
            'cirugia'                       => $this->input->post('cirugia'),
            'diagnostico_preoperatorio'     => $this->input->post('diagnostico_preoperatorio'),
            'operacion_proyectada'          => $this->input->post('operacion_proyectada'),
            'hemoderivados'                 => $this->input->post('hemoderivados'),
            'anestesia'                     => $this->input->post('anestesia'),
            'preoperatoria_permisible'      => $this->input->post('preoperatoria_permisible'),
            'prueva_covid'                  => $this->input->post('prueva_covid'),
            'tiempo_quirurgico'             => $this->input->post('tiempo_quirurgico'),
            'requerimientos_insumos_equipo' => $this->input->post('requerimientos_insumos_equipo'),
            'empleado_matricula'            => $this->input->post('empleado_matricula'),
            'id_cie9'                       => $this->input->post('id_cie9'),
            'tele_preoperatoria'            => $this->input->post('tele_preoperatoria'),
            'solicitudtransfucion_gs_abo'   => $this->input->post('solicitudtransfucion_gs_abo'),
            'solicitudtransfucion_gs_rhd'   => $this->input->post('solicitudtransfucion_gs_rhd'),
            'solicitudtransfucion_disponible'=> $this->input->post('solicitudtransfucion_disponible'),
            'solicitudtransfucion_reserva'  => $this->input->post('solicitudtransfucion_reserva')
        );
        if ($this->input->post('editar_solicitud') == "no") {
            $this->config_mdl->_insert('um_solicitudesintervencionqx', $data);
            $this->setOutput(array('accion' =>  1));
        } else {
            $this->config_mdl->_update_data('um_solicitudesintervencionqx', $data, array(
                'solicitudInt_id' =>  intval($this->input->post('solicitudInt_id'))
            ));
            $this->setOutput(array('accion' =>  0));
        }
        //$this->setOutput(array('accion' =>  -1));
    }
}
