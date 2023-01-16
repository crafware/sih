<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Documentos
 *
 * @author felipe de jesus
 */
require_once APPPATH . 'modules/config/controllers/Config.php';
class Documentos extends Config
{
    public function index()
    {
        $this->load->view('documentos/index');
    }
    public function Clasificacion($paciente)
    {
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' =>  $paciente
        ));

        $sql['medico'] =  $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['info'][0]['triage_crea_medico']
        ));
        $sql['pinfo'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $paciente
        ));

        if ($_GET['via'] == 'Choque') {
            $sql['class_choque'] = $this->config_mdl->_query("SELECT * FROM os_triage_signosvitales
            WHERE
            os_triage_signosvitales.sv_tipo='Choque' AND
            os_triage_signosvitales.triage_id=" . $paciente . " ORDER BY os_triage_signosvitales.sv_id ASC LIMIT 1");
        }
        $sql['SignosVitales'] = $this->config_mdl->_get_data_condition('os_triage_signosvitales', array(
            'sv_tipo' => 'Triage',
            'triage_id' => $paciente
        ))[0];

        $sql['AdmisionContinua'] = $this->config_mdl->_get_data_condition('or_admision_continua', array(
            'triage_id' => $paciente
        ))[0];

        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Paciente',
            'triage_id' => $paciente
        ))[0];

        if ($sql['info'][0]['triage_via_registro'] == 'Hora Cero TR') {
            $sql['clasificacion'] =  $this->config_mdl->_get_data_condition('os_triage_clasificacion_resp', array(
                'triage_id' =>  $paciente
            ));
            $this->load->view('documentos/ClasificacionTR', $sql);
        } else {

            $sql['clasificacion'] =  $this->config_mdl->_get_data_condition('os_triage_clasificacion', array(
                'triage_id' =>  $paciente
            ));
            $this->load->view('documentos/Clasificacion', $sql);
        }
    }
    public function ST7($Paciente)
    {
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['am'] =  $this->config_mdl->_get_data_condition('os_asistentesmedicas', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['ST7_FOLIO'] =  $this->config_mdl->_get_data_condition('doc_st7_folio', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['hojafrontal'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['DirEmpresa'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Empresa',
            'triage_id' => $Paciente
        ))[0];
        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Paciente',
            'triage_id' => $Paciente
        ))[0];
        $sql['Empresa'] = $this->config_mdl->_get_data_condition('os_triage_empresa', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente
        ))[0];
        $this->load->view('documentos/st7', $sql);
    }
    public function HojaFrontal($Paciente)
    {
        $sql['info'] =  $this->config_mdl->sqlGetDataCondition('os_triage', array(
            'triage_id' =>  $Paciente
        ), 'triage_id,triage_nombre,triage_nombre_ap,triage_nombre_am,triage_paciente_sexo,triage_fecha_nac')[0];
        $sql['am'] =  $this->config_mdl->sqlGetDataCondition('os_asistentesmedicas', array(
            'triage_id' =>  $Paciente
        ), 'asistentesmedicas_fecha,asistentesmedicas_hora,asistentesmedicas_hoja,asistentesmedicas_renglon')[0];
        $sql['DirEmpresa'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Empresa',
            'triage_id' => $Paciente
        ))[0];
        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Paciente',
            'triage_id' => $Paciente
        ))[0];
        $sql['Empresa'] = $this->config_mdl->_get_data_condition('os_triage_empresa', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente
        ))[0];
        $this->load->view('documentos/hojafrontal', $sql);
    }
    public function HojaFrontalCE($Paciente)
    {
        $sql['hoja'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['am'] =  $this->config_mdl->sqlGetDataCondition('os_asistentesmedicas', array(
            'triage_id' =>  $Paciente
        ), 'asistentesmedicas_fecha,asistentesmedicas_hora,asistentesmedicas_incapacidad_am,asistentesmedicas_incapacidad_tipo,asistentesmedicas_incapacidad_folio,asistentesmedicas_incapacidad_fi,asistentesmedicas_incapacidad_da')[0];
        $sql['DirEmpresa'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Empresa',
            'triage_id' => $Paciente
        ))[0];
        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Paciente',
            'triage_id' => $Paciente
        ))[0];
        $sql['Empresa'] = $this->config_mdl->_get_data_condition('os_triage_empresa', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['Medico'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['hoja']['empleado_id']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sql['AsistenteMedica'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['info']['triage_crea_am']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sql['Enfermera'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['info']['triage_crea_enfemeria']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sql['SignosVitales'] = $this->config_mdl->_get_data_condition('os_triage_signosvitales', array(
            'sv_tipo' => 'Triage',
            'triage_id' => $Paciente
        ))[0];
        $sql['DiagnosticosCIE10'] = $this->config_mdl->_query("SELECT * FROM um_cie10_hojafrontal, um_cie10 WHERE
                    um_cie10_hojafrontal.cie10_id=um_cie10.cie10_id AND
                    um_cie10_hojafrontal.triage_id=" . $Paciente . " ORDER BY cie10hf_tipo='Primario' DESC");
        $this->load->view('documentos/HojaFrontal430128', $sql);
    }
    public function HojaInicialAbierto($Paciente)
    {
        $sql['hoja'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['am'] =  $this->config_mdl->sqlGetDataCondition('os_asistentesmedicas', array(
            'triage_id' =>  $Paciente
        ), 'asistentesmedicas_fecha,asistentesmedicas_hora,asistentesmedicas_incapacidad_am,asistentesmedicas_incapacidad_tipo,asistentesmedicas_incapacidad_folio,asistentesmedicas_incapacidad_fi,asistentesmedicas_incapacidad_da')[0];
        $sql['DirEmpresa'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Empresa',
            'triage_id' => $Paciente
        ))[0];
        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Paciente',
            'triage_id' => $Paciente
        ))[0];
        $sql['Empresa'] = $this->config_mdl->_get_data_condition('os_triage_empresa', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['Medico'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['hoja']['empleado_id']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula,empleado_cedula')[0];
        $sql['AsistenteMedica'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['info']['triage_crea_am']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sql['Enfermera'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['info']['triage_crea_enfemeria']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sql['SignosVitales'] = $this->config_mdl->_get_data_condition('os_triage_signosvitales', array(
            'sv_tipo' => 'Triage',
            'triage_id' => $Paciente
        ))[0];
        $sql['ce'] = $this->config_mdl->_get_data_condition('os_consultorios_especialidad', array(
            'triage_id' => $Paciente
        ))[0];

        $sql['obs'] = $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT *
          FROM prescripcion INNER JOIN nm_hojafrontal_prescripcion ON
          prescripcion.prescripcion_id = nm_hojafrontal_prescripcion.prescripcion_id
          INNER JOIN catalogo_medicamentos
	        ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
          WHERE triage_id = " . $Paciente);
        /*
        Consulta para las prescripciones de cuadro basico
        antibioticos NPT y Oncologico o antimicrobiano
        */
        $sql['Prescripcion_Basico'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                 INNER JOIN prescripcion
                                                                	 ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                 INNER JOIN nm_hojafrontal_prescripcion
                                                                     ON prescripcion.prescripcion_id = nm_hojafrontal_prescripcion.prescripcion_id
                                                                 WHERE triage_id =$Paciente AND safe = 0;");

        $sql['Prescripcion_NPT'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                              INNER JOIN prescripcion
                                                              	ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                              INNER JOIN prescripcion_npt
                                                              	ON prescripcion.prescripcion_id = prescripcion_npt.prescripcion_id
                                                              INNER JOIN nm_hojafrontal_prescripcion
                                                                ON prescripcion.prescripcion_id = nm_hojafrontal_prescripcion.prescripcion_id
                                                              WHERE triage_id =$Paciente AND safe = 1 AND categoria_safe = 'npt';");

        $sql['Prescripcion_Onco_Anti'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                    INNER JOIN prescripcion
                                                                    	ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                    INNER JOIN prescripcion_onco_antimicrobianos
                                                                    	ON prescripcion.prescripcion_id = prescripcion_onco_antimicrobianos.prescripcion_id
                                                                    INNER JOIN nm_hojafrontal_prescripcion
                                                                        ON prescripcion.prescripcion_id = nm_hojafrontal_prescripcion.prescripcion_id
                                                                    WHERE triage_id =$Paciente AND safe = 1;");
        //fin consultas para la prescripción

        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT cie10_clave, cie10_nombre, complemento, tipo_diagnostico FROM um_cie10
                                    INNER JOIN paciente_diagnosticos
                                        ON um_cie10.cie10_id = paciente_diagnosticos.cie10_id
                                    INNER JOIN diagnostico_hoja_frontal
                                        ON paciente_diagnosticos.diagnostico_id = diagnostico_hoja_frontal.diagnostico_id
                                    WHERE  hf_id = (SELECT hf_id FROM os_consultorios_especialidad_hf
                                    WHERE triage_id = $Paciente)");
        $sql['Interconsultas'] = $this->config_mdl->_query("SELECT * FROM interconsulta_hoja_frontal
                                                            INNER JOIN doc_430200
                                                                ON interconsulta_hoja_frontal.doc_id = doc_430200.doc_id
                                                            INNER JOIN um_especialidades
                                                                ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
                                                            WHERE triage_id = $Paciente AND hf_id = (
                                                            	SELECT hf_id FROM os_consultorios_especialidad_hf
                                                            	WHERE triage_id = $Paciente	)");
        $sql['AlergiaMedicamentos'] = $this->config_mdl->_query("SELECT medicamento FROM um_alergias_medicamentos
                                                                INNER JOIN catalogo_medicamentos
                                                                	ON um_alergias_medicamentos.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                WHERE triage_id = $Paciente");
        $this->load->view('documentos/HojaFrontal430128Abierto', $sql);
    }
    public function FormatosJefaAsistentesMedicas()
    {
        $Turno = $_GET['turno'];
        $Fecha = $_GET['fecha_inicio'];
        $Tipo2 = $_GET['tipo2'];
        if ($_GET['tipo'] == 'Consultorios') {
            if ($Turno == 'Noche') {
                $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM doc_43029, os_triage, os_asistentesmedicas WHERE
                    os_triage.triage_id=os_asistentesmedicas.triage_id AND
                    os_triage.triage_id=doc_43029.triage_id AND
                    doc_43029.doc_turno='Noche A' AND doc_43029.doc_fecha='$Fecha' AND doc_tipo='Ingreso' ORDER BY os_asistentesmedicas.asistentesmedicas_hora ASC");
                $sql['Gestion2'] = $this->config_mdl->_query("SELECT * FROM doc_43029, os_triage, os_asistentesmedicas WHERE
                    os_triage.triage_id=os_asistentesmedicas.triage_id AND
                    os_triage.triage_id=doc_43029.triage_id AND
                    doc_43029.doc_turno='Noche B' AND doc_43029.doc_fecha=INTERVAL 1 DAY +'$Fecha' AND doc_tipo='Ingreso' ORDER BY os_asistentesmedicas.asistentesmedicas_hora ASC");
            } else {
                $sql['Gestion2'] = '';
                $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM doc_43029, os_triage, os_asistentesmedicas WHERE
                    os_triage.triage_id=os_asistentesmedicas.triage_id AND
                    os_triage.triage_id=doc_43029.triage_id AND
                    doc_43029.doc_turno='$Turno' AND doc_43029.doc_fecha='$Fecha' AND doc_tipo='Ingreso' ORDER BY os_asistentesmedicas.asistentesmedicas_hora ASC");
            }
            $this->load->view('documentos/JAM_43029_IE', $sql);
        } else {
            if ($Turno == 'Noche') {
                $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM doc_43021, os_triage WHERE
                    os_triage.triage_id=doc_43021.triage_id AND doc_43021.doc_tipo='$Tipo2' AND
                    doc_43021.doc_turno='Noche A' AND doc_43021.doc_fecha='$Fecha'");
                $sql['Gestion2'] = $this->config_mdl->_query("SELECT * FROM doc_43021, os_triage WHERE
                    os_triage.triage_id=doc_43021.triage_id AND doc_43021.doc_tipo='$Tipo2' AND
                    doc_43021.doc_turno='Noche B' AND doc_43021.doc_fecha=INTERVAL 1 DAY+'$Fecha'");
            } else {
                $sql['Gestion2'] = '';
                $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM doc_43021, os_triage WHERE
                    os_triage.triage_id=doc_43021.triage_id AND doc_43021.doc_tipo='$Tipo2' AND
                    doc_43021.doc_turno='$Turno' AND doc_43021.doc_fecha='$Fecha'");
            }
            if ($Tipo2 == 'Ingreso') {
                $this->load->view('documentos/JAM_43021_I', $sql);
            } else {
                $this->load->view('documentos/JAM_43021_E', $sql);
            }
        }
    }
    public function ObtenerCamasObsChoque($data)
    {
        if ($data['tipo'] == 'Choque') {
            $sql = $this->config_mdl->_query("SELECT * FROM os_observacion, os_camas WHERE os_camas.cama_id=os_observacion.observacion_cama AND
                os_observacion.triage_id=" . $data['triage_id'])[0];
            return $sql['cama_nombre'];
        } else {
            $sql = $this->config_mdl->_query("SELECT * FROM os_choque_v2, os_camas WHERE os_camas.cama_id=os_choque_v2.cama_id AND
                os_choque_v2.triage_id=" . $data['triage_id'])[0];
            return $sql['cama_nombre'];
        }
    }
    public function HojaFrontalPacientes($data)
    {
        $sql = $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' => $data['triage_id']
        ))[0];
        if (empty($sql)) {
            return '';
        } else {
            return $sql['hf_diagnosticos_lechaga'];
        }
    }

    public function SolicitudServicioTransfusion($Tratamiento)
    {
        $sql['st'] =  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion', array(
            'tratamiento_id' => $Tratamiento
        ))[0];
        $sql['observacion'] =  $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' => $this->input->get('folio')
        ))[0];
        $sql['triage'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get('folio')
        ))[0];
        $this->load->view('documentos/SolicitudServicioTransfusion', $sql);
    }
    public function CirugiaSegura($Tratamiento)
    {
        $sql['cs'] =  $this->config_mdl->_get_data_condition('os_observacion_cirugiasegura', array(
            'tratamiento_id' => $Tratamiento
        ))[0];
        $sql['observacion'] =  $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' => $this->input->get('folio')
        ))[0];
        $sql['triage'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get('folio')
        ))[0];
        $this->load->view('documentos/CirugiaSegura', $sql);
    }
    public function SolicitudIntervencionQuirurgica($Tratamiento)
    {
        $sql['cs'] =  $this->config_mdl->_get_data_condition('os_observacion_cirugiasegura', array(
            'tratamiento_id' => $Tratamiento
        ))[0];
        $sql['st'] =  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion', array(
            'tratamiento_id' => $Tratamiento
        ))[0];
        $sql['observacion'] =  $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' => $this->input->get('folio')
        ))[0];
        $sql['triage'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get('folio')
        ))[0];
        $sql['ci'] =  $this->config_mdl->_get_data_condition('os_observacion_ci', array(
            'tratamiento_id' => $Tratamiento
        ))[0];
        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Paciente',
            'triage_id' => $this->input->get('folio')
        ))[0];
        $this->load->view('documentos/SolicitudIntervencionQuirurgica', $sql);
    }
    public function CartaConsentimientoInformado($Tratamiento)
    {
        $sql['observacion'] =  $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' => $this->input->get('folio')
        ))[0];
        $sql['triage'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get('folio')
        ))[0];
        $sql['ci'] =  $this->config_mdl->_get_data_condition('os_observacion_ci', array(
            'tratamiento_id' => $Tratamiento
        ))[0];
        $sql['cci'] =  $this->config_mdl->_get_data_condition('os_observacion_cci', array(
            'tratamiento_id' => $Tratamiento
        ))[0];
        $sql['st'] =  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion', array(
            'tratamiento_id' => $Tratamiento
        ))[0];

        $this->load->view('documentos/CartaConsentimientoInformado', $sql);
    }
    public function ISQ($Tratamiento)
    {
        $sql['isq'] =  $this->config_mdl->_get_data_condition('os_observacion_isq', array(
            'tratamiento_id' => $Tratamiento
        ))[0];
        $sql['triage'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get('folio')
        ))[0];
        $sql['ci'] =  $this->config_mdl->_get_data_condition('os_observacion_ci', array(
            'tratamiento_id' => $Tratamiento
        ))[0];
        $sql['cci'] =  $this->config_mdl->_get_data_condition('os_observacion_cci', array(
            'tratamiento_id' => $Tratamiento
        ))[0];
        $sql['st'] =  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion', array(
            'tratamiento_id' => $Tratamiento
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $this->input->get('folio')
        ))[0];
        $this->load->view('documentos/ISQ', $sql);
    }
    /*NUEVOS FORMATOS*/
    public function FormatoIngreso_Egreso()
    {
        $turno = $this->input->get('turno');
        $fecha = $this->input->get('fecha');
        if ($this->input->get('tipo') == 'Ingreso') {
            $sql['Gestion'] = $this->config_mdl->_query(
                "SELECT * FROM os_accesos, os_triage, os_asistentesmedicas
                                        WHERE
                                        os_accesos.areas_id=os_asistentesmedicas.asistentesmedicas_id AND
                                        os_triage.triage_id=os_accesos.triage_id AND
                                        os_triage.triage_id=os_asistentesmedicas.triage_id AND
                                        os_triage.triage_consultorio_nombre!='Observación' AND
                                        os_accesos.acceso_tipo='Asistente Médica' AND
                                        os_accesos.acceso_turno='$turno' AND
                                        os_accesos.acceso_fecha='$fecha'"
            );
            $this->load->view('documentos/JAM_Ingresos', $sql);
        } else {
            $sql['Gestion'] = $this->config_mdl->_query(
                "SELECT * FROM os_accesos, os_triage,  os_asistentesmedicas_egresos
                    WHERE
                    os_accesos.acceso_tipo='Egreso Paciente Asistente Médica' AND
                    os_accesos.acceso_turno='$turno' AND
                    os_accesos.acceso_fecha='$fecha' AND
                    os_accesos.triage_id=os_triage.triage_id AND
                    os_asistentesmedicas_egresos.triage_id=os_triage.triage_id AND
                    os_asistentesmedicas_egresos.egreso_area='Observacion' AND
                    os_accesos.triage_id=os_triage.triage_id"
            );
            $this->load->view('documentos/JAM_Egresos', $sql);
        }
    }
    public function ListaPacientesEnEspera()
    {
        $hoy = date('d/m/Y');
        $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_triage, os_consultorios_especialidad, os_accesos,os_empleados
            WHERE
            os_triage.triage_id=os_asistentesmedicas.triage_id AND
            os_asistentesmedicas.asistentesmedicas_id=os_consultorios_especialidad.asistentesmedicas_id AND
            os_accesos.acceso_tipo='Asistente Médica' AND
            os_consultorios_especialidad.ce_status='En Espera' AND
            os_asistentesmedicas.asistentesmedicas_id=os_accesos.areas_id AND
            os_empleados.empleado_id=os_accesos.empleado_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$hoy' ");
        $this->load->view('documentos/ListaPacientesEspera', $sql);
    }
    public function ListaPacientesAsignados()
    {
        $sql['Gestion'] =  $this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad, os_consultorios_especialidad_llamada, os_triage, os_empleados
            WHERE os_consultorios_especialidad.ce_status='Asignado' AND os_triage.triage_id=os_consultorios_especialidad.triage_id AND
            os_empleados.empleado_id=os_consultorios_especialidad.ce_crea AND
            os_consultorios_especialidad.ce_id=os_consultorios_especialidad_llamada.ce_id_ce ORDER BY os_consultorios_especialidad_llamada.cel_id DESC");
        $this->load->view('documentos/ListaPacientesAsignados', $sql);
    }
    public function LechugaConsultorios()
    {
        $inputFechaInicio = $this->input->get_post('inputFechaInicio');
        //$fechaNocheNotas = date('d-m-Y', $fechaNoche);
        $selectTurno = $this->input->get_post('turno');
        $from = $this->input->get_post('from');

        switch ($selectTurno) {
            case 'Mañana':
                $horaInicial = '07:20';
                $horaFinal   = '14:00';
                break;
            case 'Tarde':
                $horaInicial = '14:00';
                $horaFinal   = '20:30';
                break;
            case 'Noche':
                $horaInicial_A = '20:30';
                $horaFinal_A   = '23:59';
                $horaInicial_B = '00:00';
                $horaFinal_B   = '07:20';
                break;
        }
        if ($from == 'Medico Triage') {
            if ($selectTurno == 'Noche') {
                $fechaNoche = strtotime('+1 day', strtotime($inputFechaInicio));
                $fechaNoche = date('Y-m-d', $fechaNoche);

                $sql['HojasFrontales_medico_triage'] = $this->config_mdl->_query("
                    SELECT  os_triage.triage_id,
                            os_triage.triage_horacero_f,
                            os_triage.triage_horacero_h,
                            os_triage.triage_hora,
                            os_triage.triage_hora_clasifica,
                            os_triage.triage_nombre,
                            os_triage.triage_nombre_ap,
                            os_triage.triage_nombre_am,
                            os_triage.triage_nombre_pseudonimo,
                            os_triage.triage_color,
                            os_triage.triage_crea_medico,
                            os_triage.triage_motivoAtencion,
                            os_triage.triage_envio_otraunidad,
                            os_triage.triage_envio_nombre,
                            paciente_info.triage_id
                    FROM os_triage
                    JOIN paciente_info on paciente_info.triage_id=os_triage.triage_id 
                        AND os_triage.triage_fecha='$inputFechaInicio'
                        AND os_triage.triage_crea_medico=$this->UMAE_USER
                        AND os_triage.triage_hora_clasifica BETWEEN '$horaInicial_A' AND '$horaFinal_A'
                    UNION
                    SELECT  os_triage.triage_id,
                            os_triage.triage_horacero_f,
                            os_triage.triage_horacero_h,
                            os_triage.triage_hora,
                            os_triage.triage_hora_clasifica,
                            os_triage.triage_nombre,
                            os_triage.triage_nombre_ap,
                            os_triage.triage_nombre_am,
                            os_triage.triage_nombre_pseudonimo,
                            os_triage.triage_color,
                            os_triage.triage_crea_medico,
                            os_triage.triage_motivoAtencion,
                            os_triage.triage_envio_otraunidad,
                            os_triage.triage_envio_nombre,
                            paciente_info.triage_id
                    FROM os_triage
                    JOIN paciente_info on paciente_info.triage_id=os_triage.triage_id 
                        AND os_triage.triage_fecha='$fechaNoche'
                        AND os_triage.triage_crea_medico=$this->UMAE_USER
                        AND os_triage.triage_hora_clasifica BETWEEN '$horaInicial_B' AND '$horaFinal_B'
                    ");
            } else {
                $sql['HojasFrontales_medico_triage'] = $this->config_mdl->_query("
                    SELECT  os_triage.triage_id,
                            os_triage.triage_horacero_f,
                            os_triage.triage_horacero_h,
                            os_triage.triage_hora,
                            os_triage.triage_hora_clasifica,
                            os_triage.triage_nombre,
                            os_triage.triage_nombre_ap,
                            os_triage.triage_nombre_am,
                            os_triage.triage_nombre_pseudonimo,
                            os_triage.triage_color,
                            os_triage.triage_crea_medico,
                            os_triage.triage_motivoAtencion,
                            os_triage.triage_envio_otraunidad,
                            os_triage.triage_envio_nombre,
                            paciente_info.triage_id
                    FROM os_triage
                    JOIN paciente_info on paciente_info.triage_id=os_triage.triage_id 
                        AND os_triage.triage_fecha='$inputFechaInicio'
                        AND os_triage.triage_crea_medico=$this->UMAE_USER
                        AND os_triage.triage_hora_clasifica BETWEEN '$horaInicial' AND '$horaFinal'
                    ");
            }
        } else {
            if ($selectTurno == 'Noche') {
                $fechaNoche = strtotime('+1 day', strtotime($inputFechaInicio));
                $fechaNoche = date('d-m-Y', $fechaNoche);
                $fechaInicioObs = date('d/m/Y', strtotime($inputFechaInicio));
                $fechaObsNoche = date('d/m/Y', strtotime($fechaNoche));
                $sql['HF_Consultorios'] = $this->config_mdl->_query("
                        SELECT  os_triage.triage_id,
                                os_triage.triage_horacero_f,
                                os_triage.triage_horacero_h,
                                os_triage.triage_hora,
                                os_triage.triage_hora_clasifica,
                                os_triage.triage_nombre,
                                os_triage.triage_nombre_ap,
                                os_triage.triage_nombre_am,
                                os_triage.triage_nombre_pseudonimo,
                                os_triage.triage_color,
                                os_consultorios_especialidad.ce_fe,
                                os_consultorios_especialidad.ce_he,
                                os_consultorios_especialidad_hf.hf_ce,
                                os_consultorios_especialidad_hf.hf_obs,
                                os_consultorios_especialidad_hf.hf_choque,
                                os_consultorios_especialidad_hf.empleado_id,
                                os_consultorios_especialidad_hf.hf_fg,
                                os_consultorios_especialidad_hf.hf_hg,
                                os_consultorios_especialidad_hf.hf_alta,
                                os_consultorios_especialidad_hf.hf_procedimientos                             
                        FROM os_consultorios_especialidad, os_consultorios_especialidad_hf, os_triage
                        WHERE os_consultorios_especialidad_hf.triage_id=os_triage.triage_id 
                        AND os_consultorios_especialidad.triage_id = os_consultorios_especialidad_hf.triage_id
                        AND os_consultorios_especialidad_hf.empleado_id=$this->UMAE_USER  
                        AND os_consultorios_especialidad_hf.hf_fg='$inputFechaInicio'
                        AND os_consultorios_especialidad_hf.hf_hg BETWEEN '$horaInicial_A' AND '$horaFinal_A' 
                        UNION
                        SELECT  os_triage.triage_id,
                                os_triage.triage_horacero_f,
                                os_triage.triage_horacero_h,
                                os_triage.triage_hora,
                                os_triage.triage_hora_clasifica,
                                os_triage.triage_nombre,
                                os_triage.triage_nombre_ap,
                                os_triage.triage_nombre_am,
                                os_triage.triage_nombre_pseudonimo,
                                os_triage.triage_color,
                                os_consultorios_especialidad.ce_fe,
                                os_consultorios_especialidad.ce_he,
                                os_consultorios_especialidad_hf.hf_ce,
                                os_consultorios_especialidad_hf.hf_obs,
                                os_consultorios_especialidad_hf.hf_choque,
                                os_consultorios_especialidad_hf.empleado_id,
                                os_consultorios_especialidad_hf.hf_fg,
                                os_consultorios_especialidad_hf.hf_hg,
                                os_consultorios_especialidad_hf.hf_alta,
                                os_consultorios_especialidad_hf.hf_procedimientos                             
                        FROM os_consultorios_especialidad, os_consultorios_especialidad_hf, os_triage
                        WHERE os_consultorios_especialidad_hf.triage_id=os_triage.triage_id 
                        AND os_consultorios_especialidad.triage_id = os_consultorios_especialidad_hf.triage_id
                        AND os_consultorios_especialidad_hf.empleado_id=$this->UMAE_USER  
                        AND os_consultorios_especialidad_hf.hf_fg='$fechaNoche'
                        AND os_consultorios_especialidad_hf.hf_hg BETWEEN '$horaInicial_B' AND '$horaFinal_B' 
                        ");

                $sql['HF_Observacion'] = $this->config_mdl->_query(
                    "SELECT
                            os_triage.triage_id,
                            os_triage.triage_horacero_f,
                            os_triage.triage_horacero_h,
                            os_triage.triage_hora,
                            os_triage.triage_hora_clasifica,
                            os_observacion.observacion_fe,
                            os_observacion.observacion_he,
                            os_triage.triage_nombre,
                            os_triage.triage_nombre_ap,
                            os_triage.triage_nombre_am,
                            os_triage.triage_nombre_pseudonimo,
                            os_triage.triage_color,
                            os_consultorios_especialidad_hf.hf_ce,
                            os_consultorios_especialidad_hf.hf_obs,
                            os_consultorios_especialidad_hf.hf_choque,
                            os_consultorios_especialidad_hf.empleado_id,
                            os_consultorios_especialidad_hf.hf_fg,
                            os_consultorios_especialidad_hf.hf_hg,
                            os_consultorios_especialidad_hf.hf_alta,
                            os_consultorios_especialidad_hf.hf_procedimientos
                            
                        FROM os_consultorios_especialidad_hf, os_observacion, os_triage
                        
                        WHERE
                            os_consultorios_especialidad_hf.triage_id = os_triage.triage_id
                            AND os_observacion.triage_id = os_consultorios_especialidad_hf.triage_id
                            AND os_consultorios_especialidad_hf.empleado_id = $this->UMAE_USER
                            AND os_consultorios_especialidad_hf.hf_fg ='$inputFechaInicio'
                            AND os_observacion.observacion_fe = '$fechaInicioObs'
                            AND os_consultorios_especialidad_hf.hf_hg BETWEEN '$horaInicial_A' AND '$horaFinal_A' 

                        UNION

                        SELECT
                            os_triage.triage_id,
                            os_triage.triage_horacero_f,
                            os_triage.triage_horacero_h,
                            os_triage.triage_hora,
                            os_triage.triage_hora_clasifica,
                            os_observacion.observacion_fe,
                            os_observacion.observacion_he,
                            os_triage.triage_nombre,
                            os_triage.triage_nombre_ap,
                            os_triage.triage_nombre_am,
                            os_triage.triage_nombre_pseudonimo,
                            os_triage.triage_color,
                            os_consultorios_especialidad_hf.hf_ce,
                            os_consultorios_especialidad_hf.hf_obs,
                            os_consultorios_especialidad_hf.hf_choque,
                            os_consultorios_especialidad_hf.empleado_id,
                            os_consultorios_especialidad_hf.hf_fg,
                            os_consultorios_especialidad_hf.hf_hg,
                            os_consultorios_especialidad_hf.hf_alta,
                            os_consultorios_especialidad_hf.hf_procedimientos                         
                        FROM os_consultorios_especialidad_hf, os_observacion, os_triage
                        WHERE
                            os_consultorios_especialidad_hf.triage_id = os_triage.triage_id
                            AND os_observacion.triage_id = os_consultorios_especialidad_hf.triage_id
                            AND os_consultorios_especialidad_hf.empleado_id = $this->UMAE_USER
                            AND os_consultorios_especialidad_hf.hf_fg ='$fechaNoche'
                            AND os_observacion.observacion_fe = '$fechaObsNoche'
                            AND os_consultorios_especialidad_hf.hf_hg BETWEEN '$horaInicial_B' AND '$horaFinal_B' 
                            "
                );

                $sql['Notas'] = $this->config_mdl->_query("
                        SELECT * FROM doc_notas, os_triage WHERE doc_notas.triage_id=os_triage.triage_id 
                            AND doc_notas.empleado_id=$this->UMAE_USER  
                            AND doc_notas.notas_fecha='$inputFechaInicio'
                            AND doc_notas.notas_hora BETWEEN '$horaInicial_A' AND '$horaFinal_A'
                        UNION
                        SELECT * FROM doc_notas, os_triage WHERE doc_notas.triage_id=os_triage.triage_id 
                            AND doc_notas.empleado_id=$this->UMAE_USER  
                            AND doc_notas.notas_fecha='$fechaNoche'
                            AND doc_notas.notas_hora BETWEEN '$horaInicial_B' AND '$horaFinal_B'
                        ");
            } else {
                $fechaInicioObs = date('d/m/Y', strtotime($inputFechaInicio));
                $sql['HF_Consultorios'] = $this->config_mdl->_query("
                        SELECT  os_triage.triage_id,
                                os_triage.triage_horacero_f,
                                os_triage.triage_horacero_h,
                                os_triage.triage_hora,
                                os_triage.triage_hora_clasifica,
                                os_triage.triage_nombre,
                                os_triage.triage_nombre_ap,
                                os_triage.triage_nombre_am,
                                os_triage.triage_nombre_pseudonimo,
                                os_triage.triage_color,
                                os_consultorios_especialidad.ce_fe,
                                os_consultorios_especialidad.ce_he,
                                os_consultorios_especialidad_hf.hf_ce,
                                os_consultorios_especialidad_hf.hf_obs,
                                os_consultorios_especialidad_hf.hf_choque,
                                os_consultorios_especialidad_hf.empleado_id,
                                os_consultorios_especialidad_hf.hf_fg,
                                os_consultorios_especialidad_hf.hf_hg,
                                os_consultorios_especialidad_hf.hf_alta,
                                os_consultorios_especialidad_hf.hf_procedimientos
                        FROM os_consultorios_especialidad, os_consultorios_especialidad_hf, os_triage
                        WHERE os_consultorios_especialidad_hf.triage_id=os_triage.triage_id 
                            AND os_consultorios_especialidad.triage_id = os_consultorios_especialidad_hf.triage_id
                            AND os_consultorios_especialidad_hf.empleado_id=$this->UMAE_USER  
                            AND os_consultorios_especialidad_hf.hf_fg='$inputFechaInicio'
                            AND os_consultorios_especialidad_hf.hf_hg BETWEEN '$horaInicial' AND '$horaFinal' 
                        ");

                $sql['HF_Observacion'] = $this->config_mdl->_query(
                    "SELECT
                                os_triage.triage_id,
                                os_triage.triage_horacero_f,
                                os_triage.triage_horacero_h,
                                os_triage.triage_hora,
                                os_triage.triage_hora_clasifica,
                                os_observacion.observacion_fe,
                                os_observacion.observacion_he,
                                os_triage.triage_nombre,
                                os_triage.triage_nombre_ap,
                                os_triage.triage_nombre_am,
                                os_triage.triage_nombre_pseudonimo,
                                os_triage.triage_color,
                                os_consultorios_especialidad_hf.hf_ce,
                                os_consultorios_especialidad_hf.hf_obs,
                                os_consultorios_especialidad_hf.hf_choque,
                                os_consultorios_especialidad_hf.empleado_id,
                                os_consultorios_especialidad_hf.hf_fg,
                                os_consultorios_especialidad_hf.hf_hg,
                                os_consultorios_especialidad_hf.hf_alta,
                                os_consultorios_especialidad_hf.hf_procedimientos
                        FROM os_consultorios_especialidad_hf, os_observacion, os_triage
                            WHERE os_observacion.triage_id = os_consultorios_especialidad_hf.triage_id
                            AND os_observacion.empleado_id = $this->UMAE_USER
                            AND os_observacion.observacion_fe = '$fechaInicioObs'
                            AND os_consultorios_especialidad_hf.triage_id = os_triage.triage_id
                            AND os_consultorios_especialidad_hf.hf_hg BETWEEN '$horaInicial' AND '$horaFinal' 

                        "
                );
                $sql['Notas'] = $this->config_mdl->_query("
                        SELECT  os_triage.triage_id,
                                os_triage.triage_horacero_f,
                                os_triage.triage_horacero_h,
                                os_triage.triage_hora,
                                os_triage.triage_hora_clasifica,
                                doc_notas.notas_fecha,
                                doc_notas.notas_hora,
                                os_triage.triage_nombre,
                                os_triage.triage_nombre_ap,
                                os_triage.triage_nombre_am,
                                os_triage.triage_nombre_pseudonimo,
                                os_triage.triage_color,
                                doc_notas.empleado_id
                        FROM doc_notas, os_triage WHERE doc_notas.triage_id=os_triage.triage_id 
                            AND doc_notas.empleado_id=$this->UMAE_USER  
                            AND doc_notas.notas_fecha='$inputFechaInicio'
                            AND doc_notas.notas_hora BETWEEN '$horaInicial' AND '$horaFinal'
                        ");
            }
        }


        $sql['medico'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $this->UMAE_USER
        ))[0];
        $sql['medicoEspecialidad'] = $this->config_mdl->_get_data_condition('um_especialidades', array(
            'especialidad_id'   =>  $sql['medico']['empleado_servicio']
        ));

        $this->load->view('documentos/LechugaConsultorios', $sql);
    }

    public function TarjetaDeIdentificacion($Paciente)
    {
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['obs'] =  $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['tarjeta'] =  $this->config_mdl->_get_data_condition('os_tarjeta_identificacion', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['hojafrontal'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['AreaCama'] =  $this->config_mdl->_query("SELECT * FROM os_areas, os_camas WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_id='{$sql['obs']['observacion_cama']}'")[0];

        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente
        ))[0];
        $this->load->view('documentos/TarjetaDeIdentificacion', $sql);
    }
    public function TarjetaDeIdentificacionChoque($Paciente)
    {
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' =>  $Paciente
        ))[0];
        if ($_GET['via'] == 'ChoqueV2') {
            $sql['choque'] =  $this->config_mdl->_get_data_condition('os_choque_v2', array(
                'triage_id' =>  $Paciente
            ))[0];
        } else {
            $sql['choque'] =  $this->config_mdl->_get_data_condition('os_choque_camas', array(
                'triage_id' =>  $Paciente
            ))[0];
        }
        $sql['tarjeta'] =  $this->config_mdl->_get_data_condition('os_tarjeta_identificacion', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['hojafrontal'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['cama'] = $this->config_mdl->_query("SELECT * FROM os_areas, os_camas
            WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_id=" . $sql['choque']['cama_id'])[0];
        $this->load->view('documentos/TarjetaDeIdentificacionChoque', $sql);
    }
    public function TarjetaDeIdentificacionAreas($Paciente)
    {
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['areas'] =  $this->config_mdl->_get_data_condition('os_areas_pacientes', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['tarjeta'] =  $this->config_mdl->_get_data_condition('os_tarjeta_identificacion', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['hojafrontal'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['cama'] = $this->config_mdl->_query("SELECT * FROM os_areas, os_camas
            WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_id=" . $sql['areas']['cama_id'])[0];
        $this->load->view('documentos/TarjetaDeIdentificacionAreas', $sql);
    }
    public function ConsentimientoInformadoIngresoObs($Paciente)
    {
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['obs'] =  $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' =>  $Paciente,
        ))[0];
        $sql['hojafrontal'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' =>  $Paciente,
        ))[0];
        $sql['id_cie10'] = $this->config_mdl->_get_data_condition('paciente_diagnosticos', array(
            'triage_id' => $Paciente,
            'tipo_diagnostico' => '0'
        ))[0];
        $sql['diagnostico_ingreso'] = $this->config_mdl->_get_data_condition('um_cie10', array(
            'cie10_id' => $sql['id_cie10']['cie10_id']
        ))[0];
        $sql['responsable'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente,
        ))[0];
        $sql['medico_tratante'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['hojafrontal']['empleado_id']
        ))[0];

        $this->load->view('documentos/ConsentimientoInformadoIngresoObs', $sql);
    }
    public function AsistentesMedicas()
    {
        $inputFechaInicio = $this->input->get_post('POR_FECHA_FECHA_I');
        $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM os_asistentesmedicas,paciente_info, os_triage, os_empleados
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            paciente_info.triage_id=os_triage.triage_id AND
            os_triage.triage_crea_am=os_empleados.empleado_id AND
            os_asistentesmedicas.asistentesmedicas_omitir='No' AND
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio' AND paciente_info.pia_lugar_accidente='TRABAJO'");
        $sql['Am'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $this->UMAE_USER
        ))[0];
        $this->load->view("documentos/AsistentesMedicas", $sql);
    }
    public function Medico($data)
    {
        $sql = $this->config_mdl->_query('SELECT * FROM os_consultorios_especialidad_hf, os_triage, os_empleados
                WHERE
                os_consultorios_especialidad_hf.triage_id=os_triage.triage_id AND
                os_consultorios_especialidad_hf.empleado_id=os_empleados.empleado_id AND
                os_triage.triage_id=' . $data['triage_id']);
        return $sql[0]['empleado_nombre'] . ' ' . $sql[0]['empleado_apellidos'];
    }
    public function IndicadorPisos()
    {
        $by_fecha_inicio = $this->input->get_post('by_fecha_inicio');
        $by_fecha_fin = $this->input->get_post('by_fecha_fin');
        $by_hora_fecha = $this->input->get_post('by_hora_fecha');
        $by_hora_inicio = $this->input->get_post('by_hora_inicio');
        $by_hora_fin = $this->input->get_post('by_hora_fin');
        if ($this->input->get_post('TipoBusqueda') == 'POR_FECHA') {
            if ($this->input->get_post('TIPO_ACCION') == 'INGRESO') {
                $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM os_triage, os_pisos, os_camas, os_areas, os_areas_pacientes, os_pisos_camas
                                                WHERE
                                                os_areas_pacientes.triage_id=os_triage.triage_id AND
                                                os_areas_pacientes.cama_id=os_camas.cama_id AND
                                                os_pisos_camas.piso_id=os_pisos.piso_id AND
                                                os_pisos_camas.cama_id=os_camas.cama_id AND
                                                os_areas.area_id=os_camas.area_id AND
                                                os_areas_pacientes.ap_f_ingreso BETWEEN '$by_fecha_inicio' AND '$by_fecha_fin'");
            } else {
                $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM os_triage, os_pisos, os_camas, os_areas, os_areas_pacientes, os_pisos_camas
                                                WHERE
                                                os_areas_pacientes.triage_id=os_triage.triage_id AND
                                                os_areas_pacientes.cama_id=os_camas.cama_id AND
                                                os_pisos_camas.piso_id=os_pisos.piso_id AND
                                                os_pisos_camas.cama_id=os_camas.cama_id AND
                                                os_areas.area_id=os_camas.area_id AND
                                                os_areas_pacientes.ap_f_salida BETWEEN '$by_fecha_inicio' AND '$by_fecha_fin'");
            }
        } else {
            if ($this->input->get_post('TIPO_ACCION') == 'INGRESO') {
                $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM os_triage, os_pisos, os_camas, os_areas, os_areas_pacientes, os_pisos_camas
                                                WHERE
                                                os_areas_pacientes.triage_id=os_triage.triage_id AND
                                                os_areas_pacientes.cama_id=os_camas.cama_id AND
                                                os_pisos_camas.piso_id=os_pisos.piso_id AND
                                                os_pisos_camas.cama_id=os_camas.cama_id AND
                                                os_areas.area_id=os_camas.area_id AND
                                                os_areas_pacientes.ap_f_ingreso='$by_hora_fecha' AND
                                                os_areas_pacientes.ap_h_ingreso BETWEEN '$by_hora_inicio' AND '$by_hora_fin'");
            } else {
                $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM os_triage, os_pisos, os_camas, os_areas, os_areas_pacientes, os_pisos_camas
                                                WHERE
                                                os_areas_pacientes.triage_id=os_triage.triage_id AND
                                                os_areas_pacientes.cama_id=os_camas.cama_id AND
                                                os_pisos_camas.piso_id=os_pisos.piso_id AND
                                                os_pisos_camas.cama_id=os_camas.cama_id AND
                                                os_areas.area_id=os_camas.area_id AND
                                                os_areas_pacientes.ap_f_salida='$by_hora_fecha' AND
                                                os_areas_pacientes.ap_h_salida BETWEEN '$by_hora_inicio' AND '$by_hora_fin'");
            }
        }
        $this->load->view('documentos/IndicadorPisos', $sql);
    }
    public function DOC43051($Paciente)
    {
        /*$sql['Diagnostico']= $this->config_mdl->sqlGetDataCondition('os_consultorios_especialidad_hf',array(
            'triage_id'=> $Paciente
        ),'hf_diagnosticos')[0];*/
        $sql['info43051'] = $this->config_mdl->sqlGetDataCondition('doc_43051', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['info'] = $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['area'] = $this->config_mdl->_get_data_condition('os_areas_pacientes', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['dirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Paciente',
            'triage_id' => $Paciente
        ))[0];
        $sql['dirEmpresa'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Empresa',
            'triage_id' => $Paciente
        ))[0];
        $sql['dirResponsable'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Responsable',
            'triage_id' => $Paciente
        ))[0];
        $sql['Empresa'] = $this->config_mdl->_get_data_condition('os_triage_empresa', array(
            'triage_id' => $Paciente
        ))[0];

        $sql['AsistenteMedica'] = $this->config_mdl->sqlGetDataCondition(
            'os_empleados',
            array(
                'empleado_id' => $sql['info43051']['id_empleado_registra']
            ),
            'empleado_nombre,empleado_apellidos'
        )[0];
        /* Servicio Tratante */
        $sql['servicio'] = $this->config_mdl->_get_data_condition(
            'um_especialidades',
            array(
                'especialidad_id' => $sql['info43051']['ingreso_servicio']
            ),
            'especialidad_nombre'
        )[0];

        $sql['medico_ingresa'] = $this->config_mdl->_get_data_condition(
            'os_empleados',
            array(
                'empleado_id' => $sql['info43051']['ingresa_idmedico']
            ),
            'empleado_nombre,empleado_apellidos,empleado_matricula'
        )[0];

        $sql['servicio_ingresa'] = $this->config_mdl->_get_data_condition(
            'um_especialidades',
            array(
                'especialidad_id' => $sql['medico_ingresa']['empleado_servicio']
            ),
            'especialidad_nombre'
        )[0];
        if (!empty($sql['info43051']['cama_id'])) {
            $sql['cama'] = $this->config_mdl->_query(
                "SELECT * FROM os_camas, os_areas WHERE
                os_camas.area_id=os_areas.area_id AND os_camas.cama_id=" . $sql['info43051']['cama_id']
            )[0];
            $sql['Piso'] = $this->config_mdl->_query(
                "SELECT * FROM os_pisos, os_pisos_camas WHERE os_pisos.piso_id=os_pisos_camas.piso_id AND
                os_pisos_camas.cama_id=" . $sql['cama']['cama_id']
            )[0];
        }
        $this->load->view('documentos/DOC43051', $sql);
    }
    public function CamasOcupadas()
    {
        if ($this->input->get('tipo') == 'Total') {
            $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id  AND os_areas.area_id=" . $this->input->get('area'));
        }
        if ($this->input->get('tipo') == 'Disponibles') {
            $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='Disponible'  AND os_areas.area_id=" . $this->input->get('area'));
        }
        if ($this->input->get('tipo') == 'Ocupados') {
            $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='Ocupado'  AND os_areas.area_id=" . $this->input->get('area') . " ORDER BY cama_ingreso_f ASC, cama_ingreso_h ASC");
        }
        if ($this->input->get('tipo') == 'Mantenimiento') {
            $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='En Mantenimiento'  AND os_areas.area_id=" . $this->input->get('area'));
        }
        if ($this->input->get('tipo') == 'Limpieza') {
            $sql['Gestion'] = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='En Limpieza'  AND os_areas.area_id=" . $this->input->get('area'));
        }
        $this->load->view('Inicio/documentos/CamasOcupadas', $sql);
    }
    public function ImprimirPulsera($Paciente)
    {
        $sql['info'] = $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente
        ))[0];
        $this->load->view('documentos/ImprimirPulsera', $sql);
    }
    public function ImprimirPulseraJornadas($Paciente)
    {
        $sql['info'] = $this->config_mdl->_get_data_condition('um_pulseras_oftalmologia', array(
            'id' => $Paciente
        ))[0];

        $this->load->view('documentos/ImprimirPulsera_jornadas', $sql);
    }

    public function DOC430200($Doc)
    {
        $sql['doc'] = $this->config_mdl->_get_data_condition('doc_430200', array(
            'doc_id' => $Doc
        ))[0];
        $sql['info'] = $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $sql['doc']['triage_id']
        ))[0];
        $sql['am'] = $this->config_mdl->_get_data_condition('os_asistentesmedicas', array(
            'triage_id' => $sql['doc']['triage_id']
        ))[0];
        $sql['medico'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['doc']['empleado_envia']
        ))[0];
        $this->load->view('documentos/DOC430200', $sql);
    }

    public function GenerarNotas($Nota)
    {
        $sql['Nota'] = $this->config_mdl->_query("SELECT * FROM doc_notas, doc_nota WHERE
            doc_notas.notas_id=doc_nota.notas_id AND
            doc_notas.notas_id=" . $Nota)[0];

        $sql['ServicioM'] = $this->config_mdl->_query("SELECT empleado_servicio, especialidad_nombre
                                              FROM os_empleados
                                              INNER JOIN um_especialidades
                                               ON os_empleados.empleado_servicio = um_especialidades.especialidad_id
                                              WHERE empleado_id =" . $sql['Nota']['empleado_id']);
        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT fecha_dx, cie10_clave, complemento, cie10_nombre, diagnostico_notas.tipo_diagnostico AS tipodiag
                                                          FROM diagnostico_notas
                                                          INNER JOIN paciente_diagnosticos
                                                            ON  diagnostico_notas.diagnostico_id = paciente_diagnosticos.diagnostico_id
                                                          INNER JOIN um_cie10
                                                          	ON diagnostico_notas.cie10_id = um_cie10.cie10_id
                                                          WHERE notas_id = " . $Nota . " ORDER BY tipodiag");
        $sql['info'] = $this->config_mdl->sqlGetDataCondition('os_triage', array(
            'triage_id' => $sql['Nota']['triage_id']
        ))[0];
        $sql['PINFO'] = $this->config_mdl->sqlGetDataCondition('paciente_info', array(
            'triage_id' => $sql['Nota']['triage_id']
        ))[0];
        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'triage_id' => $sql['Nota']['triage_id']
        ))[0];
        $sql['Medico'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['Nota']['empleado_id']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];

        $sql['AsistenteMedica'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['info']['triage_crea_am']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];

        $sql['SignosVitales'] = $this->config_mdl->_get_data_condition('os_triage_signosvitales', array(
            'nota_id' => $Nota
        ))[0];
        // $sql['Interconsultas'] = $this->config_mdl->_query("SELECT especialidad_nombre, motivo_interconsulta
        //                                                     FROM interconsulta_notas
        //                                                     INNER JOIN doc_430200
        //                                                         ON interconsulta_notas.doc_id = doc_430200.doc_id
        //                                                     INNER JOIN um_especialidades
        //                                                         ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
        //                                                     WHERE notas_id =".$Nota);
        // $sql['Interconsultas_Evaluadas'] = $this->config_mdl->_query("SELECT especialidad_nombre
        //                                                     FROM interconsulta_notas
        //                                                     INNER JOIN doc_430200
        //                                                       ON interconsulta_notas.doc_id = doc_430200.doc_id
        //                                                     INNER JOIN um_especialidades
        //                                                       ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
        //                                                     WHERE notas_id =".$Nota." AND doc_estatus = 'Evaluado'");
        $sql['Interconsultas'] = $this->config_mdl->_query("SELECT especialidad_nombre, motivo_interconsulta
                                                            FROM doc_430200
                                                            INNER JOIN um_especialidades
                                                              ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
                                                            WHERE doc_nota_id =" . $Nota . " AND doc_430200.doc_estatus!='Evaluado'");
        $sql['Prescripcion'] = $this->config_mdl->_query(
            "SELECT fecha_prescripcion,CONCAT(empleado_nombre,empleado_apellidos)empleado,
          CONCAT(medicamento,' ',gramaje)medicamento, dosis, prescripcion.via AS via_administracion, frecuencia,
          aplicacion, fecha_inicio, tiempo, observacion,fecha_fin, estado,doc_notas.notas_id
          FROM prescripcion
          INNER JOIN nm_notas_prescripcion
            ON prescripcion.prescripcion_id = nm_notas_prescripcion.prescripcion_id
          INNER JOIN doc_notas
            ON nm_notas_prescripcion.notas_id = doc_notas.notas_id
          INNER JOIN catalogo_medicamentos
            ON catalogo_medicamentos.medicamento_id = prescripcion.medicamento_id
          INNER JOIN os_empleados
            ON prescripcion.empleado_id = os_empleados.empleado_id
          WHERE prescripcion.triage_id = " . $sql['Nota']['triage_id'] . " AND doc_notas.notas_id = " . $Nota . "
          ORDER BY fecha_prescripcion DESC"
        );
        /*
        Consulta para las prescripciones de cuadro basico
        antibioticos NPT y Oncologico o antimicrobiano
        */
        $sql['Prescripcion_Basico'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                 INNER JOIN prescripcion
                                                                	 ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                 WHERE triage_id = " . $sql['Nota']['triage_id'] . " AND safe = 0;");
        $sql['Prescripcion_NPT'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                              INNER JOIN prescripcion
                                                              	ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                              INNER JOIN prescripcion_npt
                                                              	ON prescripcion.prescripcion_id = prescripcion_npt.prescripcion_id
                                                              WHERE triage_id = " . $sql['Nota']['triage_id'] . " AND safe = 1 AND categoria_safe = 'npt';");
        $sql['Prescripcion_Onco_Anti'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                    INNER JOIN prescripcion
                                                                    	ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                    INNER JOIN prescripcion_onco_antimicrobianos
                                                                    	ON prescripcion.prescripcion_id = prescripcion_onco_antimicrobianos.prescripcion_id
                                                                    WHERE triage_id = " . $sql['Nota']['triage_id'] . " AND safe = 1;");
        $sql['valores'] = array($sql['Nota']['triage_id'], $Nota);
        // if($sqlSV[0]['sv_temp']!='' && !empty($sqlSV)){
        //     $sql['SignosVitales']=$sqlSV[0];
        // }else{
        //     $sql['SignosVitales']= $this->config_mdl->sqlGetDataCondition('os_triage_signosvitales',array(
        //         'triage_id'=>$sql['Nota']['triage_id'],
        //         'sv_tipo'=>'Triage'
        //     ))[0];
        // }
        $sql['AlergiaMedicamentos'] = $this->config_mdl->_query("SELECT medicamento FROM um_alergias_medicamentos
                                          INNER JOIN catalogo_medicamentos
                                            ON um_alergias_medicamentos.medicamento_id = catalogo_medicamentos.medicamento_id
                                          WHERE triage_id = " . $sql['Nota']['triage_id']);

        $sql['medicoTratante'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['Nota']['notas_medicotratante']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula,empleado_cedula')[0];

        $sql['residentes'] = $this->config_mdl->_get_data_condition('um_notas_residentes', array(
            'notas_id' => $sql['Nota']['notas_id']
        ));

        //print json_encode($sql);
        $this->valueGenerarNotas($sql);

        $this->load->view('documentos/Notas', $sql);
    }

    public function valueGenerarNotas(&$sql) //Adactar
    {
        $limFila = 100;
        $limColumna = 46;
        $lim = 0;
        $titulo_len = 4;
        $nota = &$sql["Nota"];
        $Diagnosticos = &$sql["Diagnosticos"];
        $toma_signos = &$sql["toma_signos"];
        if ($sql['indicaciones'] == 1) {
            $this->valueTitleLen('INDICACIONES_Y_ORDENES_MEDICAS', $lim, $titulo_len, $limColumna, $nota, true);
        } else {
            $nombre = 'nota_problema';
            $this->valueTextLen($nota, $nombre, $lim, $limColumna, $titulo_len, $limFila, true);
            $nota['lim_1'] = $lim;
            $nombre = 'nota_interrogatorio';
            $this->valueTextLen($nota, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
            $nota['lim_2'] = $lim;
            $nombre = 'nota_exploracionf';
            $this->valueTextLen($nota, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
            $nota['lim_3'] = $lim;
            $nombre = 'nota_auxiliaresd';
            $this->valueTextLen($nota, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
            $nombre = 'nota_procedimientos';
            if ($nota[$nombre] != '') {
                if ($lim > $limColumna) {
                    $nota[$nombre . '_p1'] = "2";
                } else {
                    $aux = $titulo_len;
                    $procedimiento = explode(',', $nota['nota_procedimientos']);
                    $aux += count($procedimiento) * $titulo_len;
                    if (($lim + $aux) > $limColumna)
                        $nota[$nombre . '_p1'] = "2";
                    else
                        $nota[$nombre . '_p1'] = "1";
                    $lim += $aux;
                }
            }
            $nombre = 'nota_analisis';
            $this->valueTextLen($nota, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
            $nombre = 'Diagnosticos';
            if (!empty($Diagnosticos)) {
                if ($lim > $limColumna) {
                    $nota[$nombre . '_p1'] = "2";
                } else {
                    $aux = 3 * $titulo_len;
                    foreach ($Diagnosticos as $value) {
                        if ($value['tipodiag'] == 1 || $value['tipodiag'] == 2) {
                            $aux += $titulo_len * 3;
                        }
                    }
                    if (($lim + $aux) > $limColumna)
                        $nota[$nombre . '_p1'] = "2";
                    else
                        $nota[$nombre . '_p1'] = "1";
                    $lim += $aux;
                }
            }
            $nombre = 'nota_pronosticos';
            $this->valueTextLen($nota, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
            $this->valueTitleLen('PLAN_Y_ORDENES_M', $lim, $titulo_len, $limColumna, $nota, false);
            $this->valueTitleLen('Dieta', $lim, $titulo_len, $limColumna, $nota, false);
            if ($nota['nota_svycuidados'] != 0) {
                $this->valueTitleLen('nota_svycuidados', $lim, $titulo_len, $limColumna, $nota, false);
            }
            if ($toma_signos != 0) {
                $nombre = 'toma_signos';
                if ($lim > $limColumna) {
                    $nota[$nombre . '_p1'] = "2";
                } else {
                    $aux = $titulo_len;
                    if (($lim + $aux) > $limColumna)
                        $nota[$nombre . '_p1'] = "2";
                    else
                        $nota[$nombre . '_p1'] = "1";
                    $lim += $aux;
                }
            }
            $nombre = 'nota_cgenfermeria';
            if ($nota[$nombre] == '1') {
                if ($lim > $limColumna) {
                    $nota[$nombre . '_p1'] = "2";
                } else {
                    $aux = $titulo_len * 10;
                    if (($lim + $aux) > $limColumna)
                        $nota[$nombre . '_p1'] = "2";
                    else
                        $nota[$nombre . '_p1'] = "1";
                    $lim += $aux;
                }
            }
            $nombre = 'nota_cuidadosenfermeria';
            $this->valueTextLen($nota, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
            $nombre = 'nota_solucionesp';
            $this->valueTextLen($nota, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
        }
    }

    public function valueTextLen(&$nota, $nombre, &$lim, $limColumna, $titulo_len, $limFila, $firsh)
    {
        if ($nota[$nombre] != '') {
            if ($lim > $limColumna) {
                $nota[$nombre . '_p1'] = "2";
            } else {
                $aux = $titulo_len;
                $aux += substr($nota[$nombre], "\n");
                $aux += ceil(strlen($nota[$nombre]) / $limFila) + 1;
                if (($lim + $aux) > $limColumna)
                    $nota[$nombre . '_p1'] = "2";
                else
                    $nota[$nombre . '_p1'] = "1";
                $lim += $aux;
            }
            if ($firsh) {
                $nota[$nombre . '_p1'] = "1";
            }
        }
    }

    public function valueTitleLen($nombre, &$lim, $titulo_len, $limColumna, &$nota, $aux)
    {
        if ($aux) {
            $nota[$nombre . '_p1'] = "1";
        } else {
            if (($lim + $titulo_len) > $limColumna)
                $nota[$nombre . '_p1'] = "2";
            else
                $nota[$nombre . '_p1'] = "1";
        }
        $lim += $titulo_len;
    }

    public function NotaConsultoriosEspecialidad($Nota)
    {
        $sql['Nota'] = $this->config_mdl->_query("SELECT * FROM doc_notas, doc_nota WHERE
            doc_notas.notas_id=doc_nota.notas_id AND
            doc_notas.notas_id=" . $Nota)[0];
        $sql['Medico'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['Nota']['empleado_id']
        ))[0];
        $sql['info'] = $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $sql['Nota']['triage_id']
        ))[0];
        $sql['am'] =  $this->config_mdl->_get_data_condition('os_asistentesmedicas', array(
            'triage_id' =>  $sql['Nota']['triage_id']
        ))[0];
        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Paciente',
            'triage_id' => $sql['Nota']['triage_id']
        ))[0];
        $sql['DirEmpresa'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Empresa',
            'triage_id' => $sql['Nota']['triage_id']
        ))[0];
        $sql['Empresa'] = $this->config_mdl->_get_data_condition('os_triage_empresa', array(
            'triage_id' => $sql['Nota']['triage_id']
        ))[0];
        $this->load->view('documentos/NotaConsultoriosEspecialidad', $sql);
    }
    public function AvisarAlMinisterioPublico($Paciente)
    {
        $sql['info'] = $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['AvisoMp'] = $this->config_mdl->_get_data_condition('ts_ministerio_publico', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['Medico'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['AvisoMp']['medico_familiar']
        ))[0];
        $sql['Ts'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['AvisoMp']['trabajosocial']
        ))[0];
        $this->load->view('documentos/AvisarAlMinisterioPublico', $sql);
    }
    public function ExpedienteAmarillo($Paciente)
    {
        $sql['info'] = $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Paciente',
            'triage_id' => $Paciente
        ))[0];
        $sql['DirEmpresa'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Empresa',
            'triage_id' => $Paciente
        ))[0];
        $sql['Empresa'] = $this->config_mdl->_get_data_condition('os_triage_empresa', array(
            'triage_id' => $Paciente
        ))[0];
        $this->load->view('documentos/ExpedienteAmarillo', $sql);
    }
    public function ExpedienteAmarilloBack($Paciente)
    {
        $sql['info'] = $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $Paciente
        ))[0];
        $this->load->view('documentos/ExpedienteAmarilloBack', $sql);
    }
    public function PaseDeVisita($Paciente)
    {
        $sql['info'] = $this->config_mdl->sqlGetDataCondition('os_triage', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['Cama'] = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas WHERE os_camas.area_id=os_areas.area_id AND
                                                            os_camas.cama_dh=" . $Paciente)[0];
        $sql['Familiares'] = $this->config_mdl->sqlGetDataCondition('um_poc_familiares', array(
            'familiar_tipo' => $_GET['tipo'],
            'triage_id' => $Paciente
        ));
        $this->load->view('documentos/PaseDeVisita', $sql);
    }
    public function Ordeninternamiento($Paciente)
    {
        $sql['info'] = $this->config_mdl->sqlGetDataCondition('os_triage', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente
        ))[0];

        $sql['internamiento'] = $this->config_mdl->_get_data_condition('um_orden_internamiento', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['id_cie10'] = $this->config_mdl->_get_data_condition('paciente_diagnosticos', array(
            'triage_id' => $Paciente,
            'tipo_diagnostico' => '0'
        ))[0];
        $sql['diagnostico_ingreso'] = $this->config_mdl->_get_data_condition('um_cie10', array(
            'cie10_id' => $sql['id_cie10']['cie10_id']
        ))[0];
        $sql['medico_tratante'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['internamiento']['medico_origen_id']
        ))[0];
        $sql['ingreso_servicio'] = $this->config_mdl->_get_data_condition('um_especialidades', array(
            'especialidad_id' => $sql['internamiento']['servicio_destino_id']
        ))[0];
        $this->load->view('documentos/Ordeninternamiento', $sql);
    }
    public function OrdenLaboratorio($Paciente)
    {

        $sql['hoja'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' =>  $Paciente
        ))[0];
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' =>  $Paciente
        ))[0];

        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente
        ))[0];
        $sql['Medico'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $_SESSION['UMAE_USER']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula,empleado_cedula,empleado_servicio')[0];

        $sql['medicoEspecialidad'] = $this->config_mdl->_get_data_condition('um_especialidades', array(
            'especialidad_id'   =>  $sql['Medico']['empleado_servicio']
        ))[0];
        if ($_GET['tipo'] == "Hospitalizacion") {
            $sql['solicitud_laboratorio'] = $this->config_mdl->_query("SELECT * FROM um_solicitud_laboratorio WHERE input_via = '" . $_GET['tipo'] . "' AND tipo_nota='" . $_GET['TipoNota'] . "' AND id_nota = '" . $_GET['id_nota'] . "'" . " AND triage_id = '" . $_GET['folio'] . "'")[0];
        } else {

            $sql['solicitud_laboratorio'] = $this->config_mdl->_query("SELECT * FROM um_solicitud_laboratorio WHERE input_via = '" . $_GET['tipo'] . "' AND tipo_nota='" . $_GET['TipoNota'] . "' AND nota_id= '" . $_GET['hf'] . "'" . " AND triage_id = '" . $_GET['folio'] . "'")[0];
        }

        if ($_GET['TipoNota'] == "Nota Inicial") {

            $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT cie10_clave, cie10_nombre, complemento, tipo_diagnostico FROM um_cie10
                                    INNER JOIN paciente_diagnosticos
                                        ON um_cie10.cie10_id = paciente_diagnosticos.cie10_id
                                    INNER JOIN diagnostico_hoja_frontal
                                        ON paciente_diagnosticos.diagnostico_id = diagnostico_hoja_frontal.diagnostico_id
                                    WHERE  hf_id = (SELECT hf_id FROM os_consultorios_especialidad_hf
                                    WHERE triage_id = $Paciente)");
        } else {

            $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT cie10_clave, cie10_nombre, complemento, tipo_diagnostico FROM um_cie10
                                    INNER JOIN paciente_diagnosticos
                                        ON um_cie10.cie10_id = paciente_diagnosticos.cie10_id
                                    WHERE triage_id = $Paciente AND tipo_diagnostico='1'");
        }

        $this->load->view('documentos/OrdenLaboratorio', $sql);
    }

    public function GenerarNotaEgreso($Nota)
    {
        $datos =    'notas_id,
                     notas_fecha,
                     notas_hora,
                     triage_id,
                     empleado_id,
                     notas_medicotratante,
                     notas_tipo,
                     notas_via,
                     CONCAT(notas_fecha,notas_hora) AS fecha_doc,
                     motivo_egreso,
                     resumen_clinico,
                     exploracion_fisica,
                     laboratorios,
                     gabinetes,
                     pronostico,
                     plan,
                     req_oxigeno,
                     req_ambulancia,
                     recibe_informe,
                     proceso,
                     fecha_hora_alta,
                     comentarios,
                     prealta,
                     alta,
                     altacancelada,
                     especialidad_nombre';
        $sql['notaEgreso'] = $this->config_mdl->_query("SELECT
                            $datos
                            FROM
                                doc_notas
                            INNER JOIN doc_nota_egreso
                            INNER JOIN um_alta_hospitalaria
                            INNER JOIN um_especialidades 
                            WHERE
                                doc_notas.notas_id = doc_nota_egreso.nota_id AND
                            doc_nota_egreso.docnota_id = um_alta_hospitalaria.id_nota_egreso AND
                                um_especialidades.especialidad_id = doc_notas.empleado_servicio_id AND
                                doc_notas.notas_id =" . $Nota)[0];
        /*$sql['notaEgreso']= $this->config_mdl->_query("SELECT * FROM doc_notas, doc_nota_egreso WHERE
        doc_notas.notas_id=doc_nota_egreso.nota_id AND doc_notas.notas_id=".$Nota)[0];*/

        $sql['infoCama'] = $this->config_mdl->_query("SELECT * FROM os_pisos, os_pisos_camas, os_camas WHERE 
            os_pisos.piso_id = os_pisos_camas.piso_id AND os_pisos_camas.cama_id = os_camas.cama_id AND triage_id=" . $sql['notaEgreso']['triage_id'])[0];

        $sql['info'] = $this->config_mdl->sqlGetDataCondition('os_triage', array(
            'triage_id' => $sql['notaEgreso']['triage_id']
        ))[0];
        $sql['PINFO'] = $this->config_mdl->sqlGetDataCondition('paciente_info', array(
            'triage_id' => $sql['notaEgreso']['triage_id']
        ))[0];

        $sql['infoIngreso'] = $this->config_mdl->sqlGetDataCondition('um_ingresos_hospitalario', array(
            'triage_id' => $sql['notaEgreso']['triage_id']
        ))[0];

        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'triage_id' => $sql['notaEgreso']['triage_id']
        ))[0];
        $sql['ServicioM'] = $this->config_mdl->_query("SELECT empleado_servicio, especialidad_nombre
                                              FROM os_empleados
                                              INNER JOIN um_especialidades
                                               ON os_empleados.empleado_servicio = um_especialidades.especialidad_id
                                              WHERE empleado_id =" . $sql['notaEgreso']['empleado_id']);

        $sql['medicoTratante'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['notaEgreso']['notas_medicotratante']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula,empleado_cedula')[0];

        $sql['residentes'] = $this->config_mdl->_get_data_condition('um_notas_residentes', array(
            'notas_id' => $sql['notaEgreso']['notas_id']
        ));


        $sql['AsistenteMedica'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['info']['triage_crea_am']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];

        $sqlSV = $this->config_mdl->_query("SELECT * FROM os_triage_signosvitales WHERE nota_id='$Nota'");


        if (!empty($sqlSV)) {
            $sql['SignosVitales'] = $sqlSV[0];
        } else {
            $sql['SignosVitales'] = $this->config_mdl->_query("SELECT * FROM os_triage_signosvitales    WHERE sv_id = 
                                                            (SELECT MAX(sv_id) FROM os_triage_signosvitales WHERE triage_id=138)")[0];
            /*$sql['SignosVitales']= $this->config_mdl->sqlGetDataCondition('os_triage_signosvitales',array(
                'triage_id'=>$sql['notaEgreso']['triage_id'],
                'sv_tipo'=>'Triage'
            ))[0];*/
        }
        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT fecha_dx, cie10_clave, complemento, cie10_nombre, diagnostico_notas.tipo_diagnostico AS tipodiag
                                                          FROM diagnostico_notas
                                                          INNER JOIN paciente_diagnosticos
                                                            ON  diagnostico_notas.diagnostico_id = paciente_diagnosticos.diagnostico_id
                                                          INNER JOIN um_cie10
                                                            ON diagnostico_notas.cie10_id = um_cie10.cie10_id
                                                          WHERE notas_id = " . $Nota . " ORDER BY tipodiag");


        if ($sql['notaEgreso']['notas_via'] == 'Hospitalizacion') {
            $this->valueNotaEgresoHosp($sql);
            $this->load->view('documentos/NotaEgresoHosp', $sql);
        } else {
            $this->load->view('documentos/NotaEgreso', $sql);
        }
    }

<<<<<<< HEAD
    public function valueNotaEgresoHosp(&$sql)
    {
        $limFila = 100;
        $limColumna = 55;
        $lim = 0;
        $aux = 0;
        $titulo_len = 2;
        $nota = &$sql["nota"];
        $notaEgreso = &$sql["notaEgreso"];
        $Diagnosticos = &$sql["Diagnosticos"];
        $this->valueTitleLen('motivoEgreso', $lim, $titulo_len, $limColumna, $nota, false);
        $this->valueTitleLen('DIAGNÓSTICOS_ENCONTRADOS', $lim, $titulo_len, $limColumna, $nota, false);
        if (!empty($Diagnosticos)) {
            $aux = 3 * $titulo_len;
            foreach ($Diagnosticos as $value) {
                if ($value['tipodiag'] == 1 || $value['tipodiag'] == 2 || $value['tipodiag'] == 3) {
                    $aux += $titulo_len * 3;
                }
            }
            $lim += $aux;
        }
        $notaEgreso['lim_1'] = $lim;
        $nombre = 'resumen_clinico';
        $this->valueTextLen($notaEgreso, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
        $nombre = 'exploracion_fisica';
        $this->valueTextLen($notaEgreso, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
        $nombre = 'laboratorios';
        $this->valueTextLen($notaEgreso, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
        $nombre = 'gabinetes';
        $this->valueTextLen($notaEgreso, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
        $nombre = 'pronostico';
        $this->valueTextLen($notaEgreso, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
        $nombre = 'plan';
        $this->valueTextLen($notaEgreso, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
        $nombre = 'comentarios';
        $this->valueTextLen($notaEgreso, $nombre, $lim, $limColumna, $titulo_len, $limFila, false);
    }

    public function NotaIngresoHosp($Paciente)
    {
        $sql['nota'] =  $this->config_mdl->_get_data_condition('um_notas_ingresos_hospitalario', array(
            'triage_id' =>  $Paciente
        ))[0];

        $sql['escalaSalud'] =  $this->config_mdl->_get_data_condition('um_notas_escalas_salud', array(
            'id_nota'   => $sql['nota']['id_nota'],
            'triage_id' =>  $Paciente
        ))[0];
        $sql['plan'] =  $this->config_mdl->_get_data_condition('um_notas_plan_ordenes', array(
            'id_nota'   => $sql['nota']['id_nota'],
=======
    public function NotaIngresoHosp($idNota){
        
        $sql['nota']=  $this->config_mdl->_get_data_condition('um_notas_ingresos_hospitalario',array(
            'id_nota'=>  $idNota
        ))[0];

        $Paciente = $sql['nota']['triage_id'];

        $sql['escalaSalud']=  $this->config_mdl->_get_data_condition('um_notas_escalas_salud',array(
            'id_nota'   => $idNota,
            'triage_id' => $Paciente
        ))[0];
        $sql['plan']=  $this->config_mdl->_get_data_condition('um_notas_plan_ordenes',array(
            'id_nota'   => $idNota,
>>>>>>> a6775f3a0b2c5a51e4fb9bd7d4f322d2ac3951ec
            'triage_id' =>  $Paciente
        ))[0];

        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' =>  $Paciente
        ))[0];

<<<<<<< HEAD

        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Paciente',
            'triage_id' => $Paciente
        ))[0];

        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $Paciente
=======
        $sql['DirPaciente']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo' => 'Paciente',
            'triage_id'       => $Paciente
        ))[0];
        
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id' => $Paciente
        ))[0];

        $sql['medicoTratante']= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'   =>  $sql['nota']['id_medico_tratante']
        ),'empleado_nombre,empleado_apellidos,empleado_matricula,empleado_cedula')[0];

        $sql['Servicio']= $this->config_mdl->sqlGetDataCondition('um_especialidades',array(
            'especialidad_id'   =>  $sql['nota']['id_servicio']
        ),'especialidad_nombre')[0];


        $sql['SignosVitales']= $this->config_mdl->_get_data_condition('os_triage_signosvitales',array(
            'sv_tipo'   =>  'Triage',
            'triage_id' =>  $Paciente
>>>>>>> a6775f3a0b2c5a51e4fb9bd7d4f322d2ac3951ec
        ))[0];

        $sql['medicoTratante'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['nota']['id_medico_tratante']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula,empleado_cedula')[0];

        $sql['Servicio'] = $this->config_mdl->sqlGetDataCondition('um_especialidades', array(
            'especialidad_id' => $sql['nota']['id_servicio']
        ), 'especialidad_nombre')[0];


        $sql['SignosVitales'] = $this->config_mdl->_get_data_condition('os_triage_signosvitales', array(
            'sv_tipo' => 'Triage',
            'triage_id' => $Paciente
        ))[0];

        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT *
          FROM prescripcion INNER JOIN nm_hojafrontal_prescripcion ON
          prescripcion.prescripcion_id = nm_hojafrontal_prescripcion.prescripcion_id
          INNER JOIN catalogo_medicamentos
            ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
          WHERE triage_id = " . $Paciente);
        /*
        Consulta para las prescripciones de cuadro basico
        antibioticos NPT y Oncologico o antimicrobiano
        */
        $sql['Prescripcion_Basico'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                 INNER JOIN prescripcion
                                                                     ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                 INNER JOIN nm_hojafrontal_prescripcion
                                                                     ON prescripcion.prescripcion_id = nm_hojafrontal_prescripcion.prescripcion_id
                                                                 WHERE triage_id =$Paciente AND safe = 0;");

        $sql['Prescripcion_NPT'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                              INNER JOIN prescripcion
                                                                ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                              INNER JOIN prescripcion_npt
                                                                ON prescripcion.prescripcion_id = prescripcion_npt.prescripcion_id
                                                              INNER JOIN nm_hojafrontal_prescripcion
                                                                ON prescripcion.prescripcion_id = nm_hojafrontal_prescripcion.prescripcion_id
                                                              WHERE triage_id =$Paciente AND safe = 1 AND categoria_safe = 'npt';");

        $sql['Prescripcion_Onco_Anti'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                    INNER JOIN prescripcion
                                                                        ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                    INNER JOIN prescripcion_onco_antimicrobianos
                                                                        ON prescripcion.prescripcion_id = prescripcion_onco_antimicrobianos.prescripcion_id
                                                                    INNER JOIN nm_hojafrontal_prescripcion
                                                                        ON prescripcion.prescripcion_id = nm_hojafrontal_prescripcion.prescripcion_id
                                                                    WHERE triage_id =$Paciente AND safe = 1;");
        //fin consultas para la prescripción

        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT cie10_clave, cie10_nombre, complemento, tipo_diagnostico FROM um_cie10
                                    INNER JOIN paciente_diagnosticos
                                        ON um_cie10.cie10_id = paciente_diagnosticos.cie10_id
                                    INNER JOIN diagnostico_hoja_frontal
                                        ON paciente_diagnosticos.diagnostico_id = diagnostico_hoja_frontal.diagnostico_id
<<<<<<< HEAD
                                    WHERE  id_nota = (SELECT id_nota FROM um_notas_ingresos_hospitalario
                                    WHERE triage_id = $Paciente)");
        $sql['Interconsultas'] = $this->config_mdl->_query("SELECT motivo_interconsulta, especialidad_id, especialidad_nombre FROM um_interconsultas_historial
=======
                                    WHERE  id_nota =".$idNota);
        $sql['Interconsultas'] = $this->config_mdl-> _query("SELECT motivo_interconsulta, especialidad_id, especialidad_nombre FROM um_interconsultas_historial
>>>>>>> a6775f3a0b2c5a51e4fb9bd7d4f322d2ac3951ec
            INNER JOIN doc_430200 ON um_interconsultas_historial.doc_id = doc_430200.doc_id
            INNER JOIN um_especialidades  ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id WHERE triage_id = $Paciente");


        $sql['infoCama'] = $this->config_mdl->_query("SELECT * FROM os_pisos, os_pisos_camas, os_camas WHERE 
            os_pisos.piso_id = os_pisos_camas.piso_id AND os_pisos_camas.cama_id = os_camas.cama_id AND triage_id=" . $Paciente)[0];

        $sql['infoIngreso'] = $this->config_mdl->sqlGetDataCondition('um_ingresos_hospitalario', array(
            'triage_id' => $Paciente
        ))[0];

<<<<<<< HEAD
        $sql['residentes'] = $this->config_mdl->_get_data_condition('um_notas_residentes', array(
            'idnota_ingresohosp' => $sql['nota']['id_nota']
=======
        $sql['residentes']= $this->config_mdl->_get_data_condition('um_notas_residentes',array(
            'idnota_ingresohosp' => $idNota
>>>>>>> a6775f3a0b2c5a51e4fb9bd7d4f322d2ac3951ec
        ));
        $this->valueNotaIngresoHosp($sql);
        $this->load->view('documentos/NotaIngresoHosp', $sql);
    }

    public function valueNotaIngresoHosp(&$sql)
    {
        $limFila = 100;
        $limColumna = 58;
        $lim = 0;
        $aux = 0;
        $titulo_len = 2;
        $nota = &$sql["nota"];
        $nombre = 'tipo_interrogatorio';
        if ($nota[$nombre] != '') {
            if ($lim > $limColumna) {
                $nota[$nombre . '_p1'] = "1";
            } else {
                $aux = $titulo_len; //sub titulo
                $aux += substr($nota[$nombre], "\n");
                $aux += ceil(strlen($nota[$nombre]) / $limFila);
                if (($lim + $aux) > $limColumna)
                    $nota[$nombre . '_p1'] = "1";
                else
                    $nota[$nombre . '_p1'] = "1";
                $lim += $aux;
            }
        }
        $nombre = 'motivo_ingreso';
        if ($nota[$nombre] != '') {
            if ($lim > $limColumna) {
                $nota[$nombre . '_p1'] = "1";
            } else {
                $aux = $titulo_len; //sub titulo
                $aux += substr($nota[$nombre], "\n");
                $aux += ceil(strlen($nota[$nombre]) / $limFila) + 1;
                if (($lim + $aux) > $limColumna)
                    $nota[$nombre . '_p1'] = "1";
                else
                    $nota[$nombre . '_p1'] = "1";
                $lim += $aux;
            }
        }
        $nombre = 'ANTECEDENTES';
        if (($lim + $titulo_len) > $limColumna) //ANTECEDENTES
            $nota[$nombre . '_p1'] = "2";
        else
            $nota[$nombre . '_p1'] = "1";
        $lim += $titulo_len; //ANTECEDENTES
        $nombre = 'antecedentes_heredofamiliares';
        if ($nota[$nombre] != '') {
            if ($lim > $limColumna) {
                $nota[$nombre . '_p1'] = "2";
            } else {
                $aux = $titulo_len; //sub titulo
                $aux += substr($nota[$nombre], "\n");
                $aux += ceil(strlen($nota[$nombre]) / $limFila) + 1;
                if (($lim + $aux) > $limColumna)
                    $nota[$nombre . '_p1'] = "2";
                else
                    $nota[$nombre . '_p1'] = "1";
                $lim += $aux;
            }
        }
        $nombre = 'antecedentes_personales_nopatologicos';
        if ($nota[$nombre] != '') {
            if ($lim > $limColumna) {
                $nota[$nombre . '_p1'] = "2";
            } else {
                $aux = $titulo_len; //sub titulo
                $aux += substr($nota[$nombre], "\n");
                $aux += ceil(strlen($nota[$nombre]) / $limFila) + 1;
                if (($lim + $aux) > $limColumna)
                    $nota[$nombre . '_p1'] = "2";
                else
                    $nota[$nombre . '_p1'] = "1";
                $lim += $aux;
            }
        }
        $nombre = 'antecedentes_personales_patologicos';
        if ($nota[$nombre] != '') {
            if ($lim > $limColumna) {
                $nota[$nombre . '_p1'] = "2";
            } else {
                $aux = $titulo_len; //sub titulo
                $aux += substr($nota[$nombre], "\n");
                $aux += ceil(strlen($nota[$nombre]) / $limFila) + 1;
                if (($lim + $aux) > $limColumna)
                    $nota[$nombre . '_p1'] = "2";
                else
                    $nota[$nombre . '_p1'] = "1";
                $lim += $aux;
            }
        }
        $nombre = 'antecedentes_ginecoobstetricos';
        if ($nota[$nombre] != '') {
            if ($lim > $limColumna) {
                $nota[$nombre . '_p1'] = "2";
            } else {
                $aux = $titulo_len; //sub titulo
                $aux += substr($nota[$nombre], "\n");
                $aux += ceil(strlen($nota[$nombre]) / $limFila) + 1;
                if (($lim + $aux) > $limColumna)
                    $nota[$nombre . '_p1'] = "2";
                else
                    $nota[$nombre . '_p1'] = "1";
                $lim += $aux;
            }
        }
        $nombre = 'ESTADO_ACTUAL';
        if (($lim + $titulo_len) > $limColumna) //ANTECEDENTES
            $nota[$nombre . '_p1'] = "2";
        else
            $nota[$nombre . '_p1'] = "1";
        $lim += $titulo_len; //ANTECEDENTES
        $nombre = 'padecimiento_actual';
        if ($nota[$nombre] != '') {
            if ($lim > $limColumna) {
                $nota[$nombre . '_p1'] = "2";
            } else {
                $aux = $titulo_len; //sub titulo
                $aux += substr($nota[$nombre], "\n");
                $aux += ceil(strlen($nota[$nombre]) / $limFila) + 1;
                if (($lim + $aux) > $limColumna)
                    $nota[$nombre . '_p1'] = "2";
                else
                    $nota[$nombre . '_p1'] = "1";
                $lim += $aux;
            }
        }
        $nombre = 'exploracion_fisica';
        if ($nota[$nombre] != '') {
            if ($lim > $limColumna) {
                $nota[$nombre . '_p1'] = "2";
            } else {
                $aux = $titulo_len; //sub titulo
                $aux += substr($nota[$nombre], "\n");
                $aux += ceil(strlen($nota[$nombre]) / $limFila) + 1;
                if (($lim + $aux) > $limColumna)
                    $nota[$nombre . '_p1'] = "2";
                else
                    $nota[$nombre . '_p1'] = "1";
                $lim += $aux;
            }
        }
        $nombre = 'EXAMENES_AUXILIARES_DE';
        if (($lim + $titulo_len) > $limColumna) //ANTECEDENTES
            $nota[$nombre . '_p1'] = "2";
        else
            $nota[$nombre . '_p1'] = "1";
        $lim += $titulo_len; //ANTECEDENTES
        $nombre = 'estudios_laboratorio';
        if ($nota[$nombre] != '') {
            if ($lim > $limColumna) {
                $nota[$nombre . '_p1'] = "2";
            } else {
                $aux = $titulo_len; //sub titulo
                $aux += substr($nota[$nombre], "\n");
                $aux += ceil(strlen($nota[$nombre]) / $limFila) + 1;
                if (($lim + $aux) > $limColumna)
                    $nota[$nombre . '_p1'] = "2";
                else
                    $nota[$nombre . '_p1'] = "1";
                $lim += $aux;
            }
        }
        $nombre = 'estudios_gabinete';
        if ($nota[$nombre] != '') {
            if ($lim > $limColumna) {
                $nota[$nombre . '_p1'] = "2";
            } else {
                $aux = $titulo_len; //sub titulo
                $aux += substr($nota[$nombre], "\n");
                $aux += ceil(strlen($nota[$nombre]) / $limFila) + 1;
                if (($lim + $aux) > $limColumna)
                    $nota[$nombre . '_p1'] = "2";
                else
                    $nota[$nombre . '_p1'] = "1";
                $lim += $aux;
            }
        }
    }

    public function GenerarNotaProcedimientos($Nota)
    {

        $sql['notaProcedimientos'] = $this->config_mdl->_query("SELECT * FROM doc_notas, um_notas_procedimientos WHERE
        doc_notas.notas_id=um_notas_procedimientos.notas_id AND doc_notas.notas_id=" . $Nota)[0];

        $sql['infoCama'] = $this->config_mdl->_query("SELECT * FROM os_pisos,os_pisos_camas,os_camas WHERE 
            os_pisos.piso_id=os_pisos_camas.piso_id AND os_pisos_camas.cama_id=os_camas.cama_id AND triage_id=" . $sql['notaProcedimientos']['triage_id'])[0];

        $sql['info'] = $this->config_mdl->sqlGetDataCondition('os_triage', array(
            'triage_id' => $sql['notaProcedimientos']['triage_id']
        ))[0];
        $sql['PINFO'] = $this->config_mdl->sqlGetDataCondition('paciente_info', array(
            'triage_id' => $sql['notaProcedimientos']['triage_id']
        ))[0];

        $sql['infoIngreso'] = $this->config_mdl->sqlGetDataCondition('um_ingresos_hospitalario', array(
            'triage_id' => $sql['notaProcedimientos']['triage_id']
        ))[0];

        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'triage_id' => $sql['notaProcedimientos']['triage_id']
        ))[0];
        $sql['ServicioM'] = $this->config_mdl->_query("SELECT empleado_servicio, especialidad_nombre
                                              FROM os_empleados
                                              INNER JOIN um_especialidades
                                               ON os_empleados.empleado_servicio = um_especialidades.especialidad_id
                                              WHERE empleado_id =" . $sql['notaProcedimientos']['empleado_id'])[0];
        $sql['medicoTratante'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['notaProcedimientos']['notas_medicotratante']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula,empleado_cedula')[0];

        $sql['residentes'] = $this->config_mdl->_get_data_condition('um_notas_residentes', array(
            'notas_id' => $sql['notaProcedimientos']['notas_id']
        ));


        $sql['AsistenteMedica'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['info']['triage_crea_am']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];

        $sqlSV = $this->config_mdl->_query("SELECT * FROM os_triage_signosvitales WHERE nota_id='$Nota'");


        if (!empty($sqlSV)) {
            $sql['SignosVitales'] = $sqlSV[0];
        } else {
            $sql['SignosVitales'] = $this->config_mdl->sqlGetDataCondition('os_triage_signosvitales', array(
                'triage_id' => $sql['notaEgreso']['triage_id'],
                'sv_tipo' => 'Triage'
            ))[0];
        }

        $this->load->view('documentos/NotaProcedimientos', $sql);
    }

    public function GenerarNotasd($Nota)
    {
        $sql['Nota'] = $this->config_mdl->_query("SELECT * FROM doc_notas, doc_nota WHERE
            doc_notas.notas_id=doc_nota.notas_id AND
            doc_notas.notas_id=" . $Nota)[0];

        $sql['ServicioM'] = $this->config_mdl->_query("SELECT empleado_servicio, especialidad_nombre
                                              FROM os_empleados
                                              INNER JOIN um_especialidades
                                               ON os_empleados.empleado_servicio = um_especialidades.especialidad_id
                                              WHERE empleado_id =" . $sql['Nota']['empleado_id']);
        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT fecha_dx, cie10_clave, complemento, cie10_nombre, diagnostico_notas.tipo_diagnostico AS tipodiag
                                                          FROM diagnostico_notas
                                                          INNER JOIN paciente_diagnosticos
                                                            ON  diagnostico_notas.diagnostico_id = paciente_diagnosticos.diagnostico_id
                                                          INNER JOIN um_cie10
                                                            ON diagnostico_notas.cie10_id = um_cie10.cie10_id
                                                          WHERE notas_id = " . $Nota . " ORDER BY tipodiag");
        $sql['info'] = $this->config_mdl->sqlGetDataCondition('os_triage', array(
            'triage_id' => $sql['Nota']['triage_id']
        ))[0];
        $sql['PINFO'] = $this->config_mdl->sqlGetDataCondition('paciente_info', array(
            'triage_id' => $sql['Nota']['triage_id']
        ))[0];
        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'triage_id' => $sql['Nota']['triage_id']
        ))[0];
        $sql['Medico'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['Nota']['empleado_id']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];

        $sql['AsistenteMedica'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['info']['triage_crea_am']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];

        $sql['SignosVitales'] = $this->config_mdl->_get_data_condition('os_triage_signosvitales', array(
            'nota_id' => $Nota
        ))[0];
        // $sql['Interconsultas'] = $this->config_mdl->_query("SELECT especialidad_nombre, motivo_interconsulta
        //                                                     FROM interconsulta_notas
        //                                                     INNER JOIN doc_430200
        //                                                         ON interconsulta_notas.doc_id = doc_430200.doc_id
        //                                                     INNER JOIN um_especialidades
        //                                                         ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
        //                                                     WHERE notas_id =".$Nota);
        // $sql['Interconsultas_Evaluadas'] = $this->config_mdl->_query("SELECT especialidad_nombre
        //                                                     FROM interconsulta_notas
        //                                                     INNER JOIN doc_430200
        //                                                       ON interconsulta_notas.doc_id = doc_430200.doc_id
        //                                                     INNER JOIN um_especialidades
        //                                                       ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
        //                                                     WHERE notas_id =".$Nota." AND doc_estatus = 'Evaluado'");
        $sql['Interconsultas'] = $this->config_mdl->_query("SELECT especialidad_nombre, motivo_interconsulta
                                                            FROM doc_430200
                                                            INNER JOIN um_especialidades
                                                              ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
                                                            WHERE doc_nota_id =" . $Nota . " AND doc_430200.doc_estatus!='Evaluado'");
        $sql['Prescripcion'] = $this->config_mdl->_query(
            "SELECT fecha_prescripcion,CONCAT(empleado_nombre,empleado_apellidos)empleado,
          CONCAT(medicamento,' ',gramaje)medicamento, dosis, prescripcion.via AS via_administracion, frecuencia,
          aplicacion, fecha_inicio, tiempo, observacion,fecha_fin, estado,doc_notas.notas_id
          FROM prescripcion
          INNER JOIN nm_notas_prescripcion
            ON prescripcion.prescripcion_id = nm_notas_prescripcion.prescripcion_id
          INNER JOIN doc_notas
            ON nm_notas_prescripcion.notas_id = doc_notas.notas_id
          INNER JOIN catalogo_medicamentos
            ON catalogo_medicamentos.medicamento_id = prescripcion.medicamento_id
          INNER JOIN os_empleados
            ON prescripcion.empleado_id = os_empleados.empleado_id
          WHERE prescripcion.triage_id = " . $sql['Nota']['triage_id'] . " AND doc_notas.notas_id = " . $Nota . "
          ORDER BY fecha_prescripcion DESC"
        );
        /*
        Consulta para las prescripciones de cuadro basico
        antibioticos NPT y Oncologico o antimicrobiano
        */
        $sql['Prescripcion_Basico'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                 INNER JOIN prescripcion
                                                                     ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                 WHERE triage_id = " . $sql['Nota']['triage_id'] . " AND safe = 0;");
        $sql['Prescripcion_NPT'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                              INNER JOIN prescripcion
                                                                ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                              INNER JOIN prescripcion_npt
                                                                ON prescripcion.prescripcion_id = prescripcion_npt.prescripcion_id
                                                              WHERE triage_id = " . $sql['Nota']['triage_id'] . " AND safe = 1 AND categoria_safe = 'npt';");
        $sql['Prescripcion_Onco_Anti'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                    INNER JOIN prescripcion
                                                                        ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                    INNER JOIN prescripcion_onco_antimicrobianos
                                                                        ON prescripcion.prescripcion_id = prescripcion_onco_antimicrobianos.prescripcion_id
                                                                    WHERE triage_id = " . $sql['Nota']['triage_id'] . " AND safe = 1;");
        $sql['valores'] = array($sql['Nota']['triage_id'], $Nota);
        // if($sqlSV[0]['sv_temp']!='' && !empty($sqlSV)){
        //     $sql['SignosVitales']=$sqlSV[0];
        // }else{
        //     $sql['SignosVitales']= $this->config_mdl->sqlGetDataCondition('os_triage_signosvitales',array(
        //         'triage_id'=>$sql['Nota']['triage_id'],
        //         'sv_tipo'=>'Triage'
        //     ))[0];
        // }
        $sql['AlergiaMedicamentos'] = $this->config_mdl->_query("SELECT medicamento FROM um_alergias_medicamentos
                                          INNER JOIN catalogo_medicamentos
                                            ON um_alergias_medicamentos.medicamento_id = catalogo_medicamentos.medicamento_id
                                          WHERE triage_id = " . $sql['Nota']['triage_id']);

        $sql['medicoTratante'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['Nota']['notas_medicotratante']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula,empleado_cedula')[0];

        $sql['residentes'] = $this->config_mdl->_get_data_condition('um_notas_residentes', array(
            'notas_id' => $sql['Nota']['notas_id']
        ));


        $this->load->view('documentos/Notasd', $sql);
    }

    public function GenerarNotaIndicaciones($Nota)
    {

        $sql['NotaIndicacion'] = $this->config_mdl->_query("SELECT * FROM doc_notas, um_notas_indicaciones WHERE
            doc_notas.notas_id=um_notas_indicaciones.notas_id AND
            doc_notas.notas_id=" . $Nota)[0];

        /* $sql['infoCama'] = $this->config_mdl->_query("SELECT * FROM os_pisos, os_pisos_camas, os_camas WHERE 
            os_pisos.piso_id = os_pisos_camas.piso_id AND os_pisos_camas.cama_id = os_camas.cama_id AND triage_id=".$sql['notaEgreso']['triage_id'])[0];*/

        $sql['info'] = $this->config_mdl->sqlGetDataCondition('os_triage', array(
            'triage_id' => $sql['NotaIndicacion']['triage_id']
        ))[0];
        $sql['PINFO'] = $this->config_mdl->sqlGetDataCondition('paciente_info', array(
            'triage_id' => $sql['NotaIndicacion']['triage_id']
        ))[0];

        $sql['infoIngreso'] = $this->config_mdl->sqlGetDataCondition('um_ingresos_hospitalario', array(
            'triage_id' => $sql['NotaIndicacion']['triage_id']
        ))[0];

        $sql['DirPaciente'] = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'triage_id' => $sql['NotaIndicacion']['triage_id']
        ))[0];
        $sql['ServicioM'] = $this->config_mdl->_query("SELECT empleado_servicio, especialidad_nombre
                                              FROM os_empleados
                                              INNER JOIN um_especialidades
                                               ON os_empleados.empleado_servicio = um_especialidades.especialidad_id
                                              WHERE empleado_id =" . $sql['NotaIndicacion']['empleado_id']);
        $sql['medicoTratante'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['NotaIndicacion']['notas_medicotratante']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula,empleado_cedula')[0];

        $sql['residentes'] = $this->config_mdl->_get_data_condition('um_notas_residentes', array(
            'notas_id' => $sql['NotaIndicacion']['notas_id']
        ));


        $sql['AsistenteMedica'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
            'empleado_id' => $sql['info']['triage_crea_am']
        ), 'empleado_nombre,empleado_apellidos,empleado_matricula')[0];

        $sqlSV = $this->config_mdl->_query("SELECT * FROM os_triage_signosvitales WHERE nota_id='$Nota'");


        if (!empty($sqlSV)) {
            $sql['SignosVitales'] = $sqlSV[0];
        } else {
            $sql['SignosVitales'] = $this->config_mdl->sqlGetDataCondition('os_triage_signosvitales', array(
                'triage_id' => $sql['NotaIndicacion']['triage_id'],
                'sv_tipo' => 'Triage'
            ))[0];
        }

        $sql['Prescripcion'] = $this->config_mdl->_query(
            "SELECT fecha_prescripcion,CONCAT(empleado_nombre,empleado_apellidos)empleado,
          CONCAT(medicamento,' ',gramaje)medicamento, dosis, prescripcion.via AS via_administracion, frecuencia,
          aplicacion, fecha_inicio, tiempo, observacion,fecha_fin, estado,doc_notas.notas_id
          FROM prescripcion
          INNER JOIN nm_notas_prescripcion
            ON prescripcion.prescripcion_id = nm_notas_prescripcion.prescripcion_id
          INNER JOIN doc_notas
            ON nm_notas_prescripcion.notas_id = doc_notas.notas_id
          INNER JOIN catalogo_medicamentos
            ON catalogo_medicamentos.medicamento_id = prescripcion.medicamento_id
          INNER JOIN os_empleados
            ON prescripcion.empleado_id = os_empleados.empleado_id
          WHERE prescripcion.triage_id = " . $sql['NotaIndicacion']['triage_id'] . " AND doc_notas.notas_id = " . $Nota . "
          ORDER BY fecha_prescripcion DESC"
        );
        /*
        Consulta para las prescripciones de cuadro basico
        antibioticos NPT y Oncologico o antimicrobiano
        */
        $sql['Prescripcion_Basico'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                 INNER JOIN prescripcion
                                                                     ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                 WHERE triage_id = " . $sql['NotaIndicacion']['triage_id'] . " AND safe = 0
                                                                 AND estado = 1
                                                                 AND STR_TO_DATE(fecha_fin,'%d/%m/%Y') >= CURDATE();");
        $sql['Prescripcion_NPT'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                              INNER JOIN prescripcion
                                                                ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                              INNER JOIN prescripcion_npt
                                                                ON prescripcion.prescripcion_id = prescripcion_npt.prescripcion_id
                                                              WHERE triage_id = " . $sql['NotaIndicacion']['triage_id'] . " AND safe = 1 AND categoria_safe = 'npt';");
        $sql['Prescripcion_Onco_Anti'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                    INNER JOIN prescripcion
                                                                        ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                    INNER JOIN prescripcion_onco_antimicrobianos
                                                                        ON prescripcion.prescripcion_id = prescripcion_onco_antimicrobianos.prescripcion_id
                                                                    WHERE triage_id = " . $sql['NotaIndicacion']['triage_id'] . " AND safe = 1;");


        $this->load->view('documentos/NotaIndicaciones', $sql);
    }
    public function ImprimeAperturaExpedienteArimac($idPaciente)
    {
        $sql['infoPaciente'] = $this->config_mdl->sqlGetDataCondition('um_pacientes', array(
            'idPaciente' => $idPaciente
        ))[0];
        $sql['contacto'] = $this->config_mdl->sqlGetDataCondition('um_pacientes_contacto', array(
            'id_paciente' => $idPaciente
        ))[0];
        $sql['ingreso'] = $this->config_mdl->sqlGetDataCondition('um_pacientes_ingresos_arimac', array(
            'id_paciente' => $idPaciente
        ))[0];
        $sql['especialidad'] = $this->config_mdl->sqlGetDataCondition('um_especialidades', array(
            'especialidad_id' => $sql['ingreso']['id_especialidad']
        ))[0];
        $this->load->view('documentos/CaratulaExpediente', $sql);
    }

    public function IngresosAdmisionHospitalaria()
    {
        $Fecha = $_GET['fecha_inicio'];
        $sql['Gestion'] = $this->config_mdl->_query("SELECT 
                                                    doc_43051.cama_id,
                                                    os_camas.cama_nombre,
                                                    os_pisos.piso_nombre_corto,
                                                    paciente_info.pum_nss,
                                                    os_triage.triage_nombre,
                                                    os_triage.triage_nombre_ap,
                                                    os_triage.triage_nombre_am,
                                                    doc_43051.fecha_asignacion,
                                                    doc_43051.diagnostico_presuntivo,
                                                    um_especialidades.especialidad_nombre,
                                                    os_empleados.empleado_nombre,  /*Servicio y medico*/
                                                    os_empleados.empleado_apellidos,
                                                    paciente_info.pum_umf,
                                                    paciente_info.pum_delegacion
                                                    FROM 
                                                    paciente_info,
                                                    os_triage,
                                                    doc_43051, 
                                                    um_especialidades,
                                                    os_empleados,
                                                    os_camas,
                                                    os_pisos
                                                    WHERE 
                                                    doc_43051.cama_id                                   = os_camas.cama_id and
                                                    os_camas.area_id                                    = os_pisos.area_id and
                                                    paciente_info.triage_id                             = os_triage.triage_id and
                                                    paciente_info.triage_id                             = doc_43051.triage_id and
                                                    doc_43051.ingreso_servicio                          = um_especialidades.especialidad_id and
                                                    doc_43051.ingreso_medico                            = os_empleados.empleado_id and
                                                    STR_TO_DATE(doc_43051.fecha_asignacion, '%Y-%m-%d') = '" . $Fecha . "';");
        foreach ($sql['Gestion']  as &$value) {
            if (is_numeric($value['diagnostico_presuntivo'])) {
                $value['diagnostico_presuntivo'] = $this->config_mdl->_query("SELECT cie10_nombre FROM um_cie10 WHERE cie10_id = " . $value['diagnostico_presuntivo'])[0]["cie10_nombre"];
            }
        }
        $this->load->view('documentos/IngresosAdmisionHospitalaria', $sql);
    }

    public function IndicacionesMedicasEnNota($idNota)
    {

        $sql['indicaciones'] = $this->config_mdl->sqlGetDataCondition('um_notas_plan_ordenes', array(
            'id_nota' => $idNota
        ))[0];

        $sql['infoPaciente'] = $this->config_mdl->_query("SELECT * FROM os_triage,paciente_info WHERE
            os_triage.triage_id=paciente_info.triage_id AND
            os_triage.triage_id=" . $sql['indicaciones']['triage_id'])[0];

        $sql['especialidad'] = $this->config_mdl->sqlGetDataCondition('um_especialidades', array(
            'especialidad_id' => $sql['ingreso']['id_especialidad']
        ))[0];

        $this->load->view('Documentos/NotaIndicacionesHosp', $sql);
    }
}
