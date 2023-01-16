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
class Documentos extends Config
{
    public function index()
    {
        die('ACCESO NO PERMITIDO');
    }
    public function Expediente($paciente)
    {
        if ($_GET['tipo'] == 'Choque') {

            $choque = $this->config_mdl->_get_data_condition('os_choque_v2', array(
                'triage_id' => $paciente
            ));
            if ($choque[0]['medico_id'] == '') {
                $this->config_mdl->_update_data('os_choque_v2', array(
                    'medico_id' => $this->UMAE_USER
                ), array(
                    'triage_id' => $paciente
                ));
                $this->AccesosUsuarios(array('acceso_tipo' => 'Médico Choque', 'triage_id' => $paciente, 'areas_id' => $choque[0]['choque_id']));
            }
        }
        if ($_GET['tipo'] == 'Hospitalizacion') {


            $sql['IngresosHospitalarios'] = $this->config_mdl->_get_data_condition('um_ingresos_hospitalario', array(
                'triage_id' => $paciente
            ));
            $sql['NotaIngresoPorServicio'] = $this->config_mdl->_get_data_condition('um_notas_ingresos_hospitalario', array(
                'triage_id'   => $paciente,
                'id_servicio' => Modules::run('Config/ObtenerEspecialidadID', array('Usuario' => $this->UMAE_USER))

            ));
            $sql['NotaIngresoHospital'] = $this->config_mdl->_query("SELECT * FROM um_notas_ingresos_hospitalario, os_empleados, um_especialidades WHERE
            um_notas_ingresos_hospitalario.id_medico=os_empleados.empleado_id AND
            os_empleados.empleado_servicio=um_especialidades.especialidad_id AND
            um_notas_ingresos_hospitalario.triage_id=" . $paciente . " ORDER BY fecha_elabora DESC");

            $sql['indicaciones'] = $this->config_mdl->_get_data_condition('um_notas_plan_ordenes', array(
                'id_nota' => $NotaIngresoHospital[0]['id_nota']
            ));
        }
        $sql['HojasFrontales'] = $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' => $paciente
        ));

        // $sql['Notas']= $this->config_mdl->_get_data_condition('doc_notas',array(
        //     'triage_id'=> $paciente
        // ));

        $sql['ce'] = $this->config_mdl->_get_data_condition('os_consultorios_especialidad', array(
            'triage_id' => $paciente
        ))[0];

        $sql['obs'] = $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' => $paciente
        ))[0];

        $sql['NotasAll'] = $this->config_mdl->_query("SELECT * FROM doc_notas, os_empleados, um_especialidades WHERE
            doc_notas.empleado_id=os_empleados.empleado_id AND
            os_empleados.empleado_servicio=um_especialidades.especialidad_id AND
            doc_notas.triage_id=" . $paciente . " ORDER BY notas_fecha DESC");

        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $paciente
        ))[0];

        $sql['cama'] =  $this->config_mdl->_get_data_condition('os_camas', array(
            'triage_id' => $paciente
        ))[0];

        $sql['piso'] = $this->config_mdl->_query("SELECT piso_nombre_corto FROM os_pisos,os_pisos_camas WHERE 
            os_pisos.piso_id=os_pisos_camas.piso_id AND os_pisos_camas.cama_id='{$sql['cama']['cama_id']}'");

        $sql['AvisoMp'] = $this->config_mdl->_query("SELECT * FROM os_empleados, ts_ministerio_publico WHERE
            os_empleados.empleado_id=ts_ministerio_publico.medico_familiar AND
            ts_ministerio_publico.triage_id=" . $paciente);
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $paciente
        ))[0];
        $sql['DocumentosHoja'] = $this->config_mdl->_get_data('pc_documentos', array(
            'doc_nombre' => 'Hoja Frontal'
        ));
        $sql['DocumentosNotas'] = $this->config_mdl->_query("SELECT * FROM pc_documentos WHERE doc_nombre!='Hoja Frontal'");
        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT count(prescripcion_id)total_prescripcion
                                                          FROM prescripcion WHERE estado = 0 and triage_id = " . $paciente);
        $sql['ordeninternamiento'] = $this->config_mdl->_get_data_condition('um_orden_internamiento', array(
            'triage_id' => $paciente
        ))[0];
        /* nuevos querys para medicamentos */
        $sql['medicamentos'] = $this->config_mdl->_query("SELECT medicamento_id, CONCAT(medicamento,' ',forma_farmaceutica) AS medicamento, interaccion_amarilla,
                                                      interaccion_roja FROM catalogo_medicamentos WHERE existencia = 1 ORDER BY medicamento");

        $sql['Prescripciones_activas'] = $this->config_mdl->_query("SELECT COUNT(prescripcion_id)activas FROM prescripcion
                                                                    WHERE estado != 0 AND  triage_id = " . $paciente);

        $sql['Prescripciones_pendientes'] = $this->config_mdl->_query("SELECT COUNT(prescripcion_id)pendientes FROM prescripcion WHERE estado = 1 AND triage_id = " . $paciente);

        $sql['Prescripciones_canceladas'] = $this->config_mdl->_query("SELECT prescripcion.prescripcion_id
                                                                      FROM prescripcion
                                                                      INNER JOIN catalogo_medicamentos ON
                                                                      prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                      INNER JOIN os_triage ON
                                                                      prescripcion.triage_id = os_triage.triage_id
                                                                      INNER JOIN btcr_prescripcion ON
                                                                      prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                                                      WHERE os_triage.triage_id =" . $paciente . " GROUP BY prescripcion_id");

        $sql['Notificaciones'] = $this->config_mdl->_query("SELECT notificacion_id
                                                          FROM um_notificaciones_prescripciones
                                                          INNER JOIN prescripcion
                                                            ON um_notificaciones_prescripciones.prescripcion_id = prescripcion.prescripcion_id
                                                          INNER JOIN catalogo_medicamentos
                                                            ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                          INNER JOIN os_empleados
                                                            ON os_empleados.empleado_id = um_notificaciones_prescripciones.empleado_id
                                                          WHERE triage_id =" . $paciente);
        $sql['Prescripciones_history'] = $this->config_mdl->_get_data_order('prescripcion_history', array('triage_id' => $paciente), 'Fecha', 'DESC');

        $query = "SELECT os_triage.triage_id, os_empleados.empleado_nombre, os_empleados.empleado_apellidos, um_especialidades.especialidad_nombre,fecha
                 FROM prescripcion_history INNER JOIN os_triage ON prescripcion_history.triage_id = os_triage.triage_id
                 INNER JOIN os_empleados ON prescripcion_history.medico_id = os_empleados.empleado_id
                 INNER JOIN um_especialidades ON prescripcion_history.servicio_id = um_especialidades.especialidad_id
                 INNER JOIN prescripcion ON prescripcion_history.idp = prescripcion.idp
                 AND prescripcion_history.triage_id=" . $paciente;
        $sql['Prescripciones'] = $this->config_mdl->_query("SELECT * FROM prescripcion
            INNER JOIN prescripcion_history ON prescripcion_history.idp = prescripcion.idp
            AND prescripcion_history.triage_id =" . $paciente . "
            AND prescripcion_history.idp = prescripcion.idp");

        $sql['prescripciones_fecha'] = $this->config_mdl->_query($query);


        /* checar si hay notas de ingreso hospitalaria del paciente y por servicio*/


        $this->load->view('Documentos/Expediente', $sql);
    }
    public function AjaxRegistrarBitacoraPrescripcion()
    {
        $datos = array(
            "empleado_id" => $this->UMAE_USER,
            "prescripcion_id" => $_GET['prescripcion_id'],
            "fecha" => date('Y-m-d') . " " . date('H:i'),
            "tipo_accion" => $_GET['tipo_accion'],
            "motivo" => $_GET['motivo']
        );
        $sql = $this->config_mdl->_insert("btcr_prescripcion", $datos);
        print json_encode($sql);
    }

    /*Retorna JSON con las prescripciones del paciente, ordenadas por fecha de prescripcion y estado*/
    public function AjaxHistorialPrescripcion()
    {
        $paciente = $this->input->get('paciente');
        $estado = $this->input->get('estado');
        $sql = $this->config_mdl->_query("SELECT DISTINCT prescripcion_id,fecha_prescripcion,
                                        CONCAT(empleado_nombre,empleado_apellidos)empleado,
                                        CONCAT(medicamento,' ',gramaje)medicamento,
                                        dosis,via,frecuencia,
                                        aplicacion, fecha_inicio, fecha_fin, estado
                                        FROM prescripcion INNER JOIN os_empleados
                                        ON prescripcion.empleado_id = os_empleados.empleado_id
                                        INNER JOIN catalogo_medicamentos
                                        ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                        WHERE prescripcion.triage_id = " . $paciente . "
                                        AND estado = " . $estado . "
                                        ORDER BY fecha_prescripcion DESC");
        print json_encode($sql);
    }
    public function AjaxCambiarEstadoPrescripcion()
    {
        $paciente = $this->input->get('paciente');
        $variables = array(
            'estado' => $this->input->get('estado'),
            'fecha_fin' => date('d/m/Y'),
            'tiempo' => $this->input->get('dias')
        );
        $condiciones = array(
            'prescripcion_id' => $this->input->get('prescripcion_id')
        );
        $sql = $this->config_mdl->_update_data('prescripcion', $variables, $condiciones);

        $medicamento_inactivo = $this->config_mdl->_query("SELECT count(prescripcion_id)total_prescripcion
                                                        FROM prescripcion WHERE estado = 0
                                                        AND triage_id = " . $paciente);
        if ($sql) {
            $mensaje = array(
                "mensaje" => "El estado de la prescripcion se modifico exitosamente",
                "medicamento_inactivo" => $medicamento_inactivo[0]['total_prescripcion']
            );
        } else {
            $mensaje = array(
                "mensaje" => "El estado no pudo modificarse",
                "medicamento_inactivo" => $medicamento_inactivo[0]['total_prescripcion']
            );
        }
        if ($this->input->get('tipo_nota') == 'hojafrontalf') {
            $this->config_mdl->_delete_data(
                'nm_hojafrontal_prescripcion',
                array(
                    'hf_id' => $this->input->get('nota_id'),
                    'prescripcion_id' => $this->input->get('prescripcion_id')
                )
            );
        } else if ($this->input->get('tipo_nota') == 'evolucion') {
            $this->config_mdl->_delete_data(
                'nm_notas_prescripcion',
                array(
                    'notas_id' => $this->input->get('nota_id'),
                    'prescripcion_id' => $this->input->get('prescripcion_id')
                )
            );
        }
        print json_encode($mensaje);
    }

    public function ExpedienteEmpleado($data)
    {
        $sql = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $data['empleado_id']
        ));
        if (empty($sql)) {
            return 'No Especificado';
        } else {
            return $sql[0]['empleado_nombre'] . ' ' . $sql[0]['empleado_apellidos'];
        }
    }
    public function HojaFrontal()
    {
        $sql['Especialidades'] = $this->config_mdl->_query("SELECT * FROM um_especialidades GROUP BY um_especialidades.especialidad_nombre");
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['hojafrontal'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'hf_id' =>  $this->input->get_post('hf')
        ));
        $sql['am'] =  $this->config_mdl->_get_data_condition('os_asistentesmedicas', array(
            'triage_id' =>  $this->input->get_post('folio')
        ));
        $sql['DirEmpresa'] =  $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Empresa',
            'triage_id' =>  $this->input->get_post('folio')
        ))[0];
        $sql['ce'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad', array(
            'triage_id' =>  $this->input->get_post('folio')
        ));
        $sql['INFO_USER'] =  $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' =>  $_SESSION['UMAE_USER']
        ));
        $sql['Empresa'] = $this->config_mdl->_get_data_condition('os_triage_empresa', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['MinisterioPublico'] = $this->config_mdl->_get_data_condition('ts_ministerio_publico', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['SignosVitales'] = $this->config_mdl->_get_data_condition('os_triage_signosvitales', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['Documentos'] = $this->config_mdl->_get_data_condition('pc_documentos', array(
            'doc_nombre' => 'Hoja Frontal'
        ));
        $this->load->view('Documentos/Doc_HojaFrontal', $sql);
    }
    public function GuardarHojaFrontal()
    {
        $consultorio = $this->config_mdl->_get_data_condition('os_consultorios_especialidad', array(
            'triage_id' =>  $this->input->post('triage_id')
        ))[0];
        foreach ($this->input->post('hf_mecanismolesion') as $value) {
            $hf_mecanismolesion .= $value . ',';
        }
        foreach ($this->input->post('hf_quemadura') as $value) {
            $hf_quemadura .= $value . ',';
        }
        foreach ($this->input->post('hf_trataminentos') as $value) {
            $hf_trataminentos .= $value . ',';
        }
        $data = array(
            'hf_ce' => ($this->input->post('tipo') == 'Consultorios' ? '1' : '0'),
            'hf_obs' => ($this->input->post('tipo') == 'Observación' ? '1' : '0'),
            'hf_choque' => ($this->input->post('tipo') == 'Choque' ? '1' : '0'),
            'hf_fg' => date('Y-m-d'),
            'hf_hg' => date('H:i'),
            'hf_documento' => $this->input->post('hf_documento'),
            'hf_intoxitacion' =>  $this->input->post('hf_intoxitacion'),
            'hf_intoxitacion_descrip' =>  $this->input->post('hf_intoxitacion_descrip'),
            'hf_urgencia' =>  $this->input->post('hf_urgencia'),
            'hf_especialidad' =>  $this->input->post('hf_especialidad'),
            'hf_motivo' =>  $this->input->post('hf_motivo'),
            'hf_mecanismolesion' => rtrim($hf_mecanismolesion, ','),
            'hf_mecanismolesion_mtrs' =>  $this->input->post('hf_mecanismolesion_mtrs'),
            'hf_mecanismolesion_otros' =>  $this->input->post('hf_mecanismolesion_otros'),
            'hf_quemadura' =>  rtrim($hf_quemadura, ','),
            'hf_quemadura_otros' =>  $this->input->post('hf_quemadura_otros'),
            'hf_antecedentes' =>  $this->input->post('hf_antecedentes'),
            'hf_exploracionfisica' =>  $this->input->post('hf_exploracionfisica'),
            'hf_estadosalud' =>  $this->input->post('hf_estadosalud'),
            'hf_diagnosticos' =>  $this->input->post('hf_diagnosticos'),
            'hf_diagnosticos_lechaga' =>  $this->input->post('hf_diagnosticos_lechaga'),
            'hf_trataminentos' => rtrim($hf_trataminentos, ','),
            'hf_trataminentos_otros' =>  $this->input->post('hf_trataminentos_otros'),
            'hf_trataminentos_por' =>  $this->input->post('hf_trataminentos_por'),
            'hf_receta_por' =>  $this->input->post('hf_receta_por'),
            'hf_indicaciones' =>  $this->input->post('hf_indicaciones'),
            'hf_ministeriopublico' =>  $this->input->post('hf_ministeriopublico'),
            'hf_alta' => $this->input->post('hf_alta'),
            'hf_alta_otros' => $this->input->post('hf_alta_otros'),
            'hf_incapacidad_dias' =>  $this->input->post('hf_incapacidad_dias'),
            'hf_incapacidad_ptr_eg' =>  $this->input->post('hf_incapacidad_ptr_eg'),
            'triage_id' =>  $this->input->post('triage_id'),
            'empleado_id' => $this->UMAE_USER
        );
        $data_am = array(
            'asistentesmedicas_da' =>  $this->input->post('asistentesmedicas_da'),
            'asistentesmedicas_dl' =>  $this->input->post('asistentesmedicas_dl'),
            'asistentesmedicas_ip' =>  $this->input->post('asistentesmedicas_ip'),
            'asistentesmedicas_tratamientos' =>  $this->input->post('asistentesmedicas_tratamientos'),
            'asistentesmedicas_ss_in' =>  $this->input->post('asistentesmedicas_ss_in'),
            'asistentesmedicas_ss_ie' =>  $this->input->post('asistentesmedicas_ss_ie'),
            'asistentesmedicas_oc_hr' =>  $this->input->post('asistentesmedicas_oc_hr'),
            'asistentesmedicas_am' =>  $this->input->post('asistentesmedicas_am'),
            'asistentesmedicas_incapacidad_am' =>  $this->input->post('asistentesmedicas_incapacidad_am'),
            'asistentesmedicas_incapacidad_ga' => $this->input->post('asistentesmedicas_incapacidad_ga'),
            'asistentesmedicas_incapacidad_tipo' => $this->input->post('asistentesmedicas_incapacidad_tipo'),
            'asistentesmedicas_incapacidad_dias_a' => $this->input->post('asistentesmedicas_incapacidad_dias_a'),
            'asistentesmedicas_incapacidad_fi' =>  $this->input->post('asistentesmedicas_incapacidad_fi'),
            'asistentesmedicas_incapacidad_da' =>  $this->input->post('asistentesmedicas_incapacidad_da'),
            'asistentesmedicas_mt' =>  $this->input->post('asistentesmedicas_mt'),
            'asistentesmedicas_mt_m' =>  $this->input->post('asistentesmedicas_mt_m'),
            'asistentesmedicas_incapacidad_folio' =>  $this->input->post('asistentesmedicas_incapacidad_folio'),
            'asistentesmedicas_omitir' =>  $this->input->post('asistentesmedicas_omitir')
        );
        if ($this->input->post('tipo') == 'Consultorios') {
            if ($consultorio['ce_status'] == 'Salida') {
                unset($data['hf_alta']);
            } else {
                $this->config_mdl->_update_data('os_consultorios_especialidad', array(
                    'ce_hf' => ($this->input->post('hf_alta') != 'Otros' ? $this->input->post('hf_alta') : $this->input->post('hf_alta_otros'))
                ), array(
                    'triage_id' =>  $this->input->post('triage_id')
                ));
            }
        }
        $sqlCheckHojaFrontal = $this->config_mdl->sqlGetDataCondition('os_consultorios_especialidad_hf', array(
            'triage_id' => $this->input->post('triage_id')
        ), 'hf_id');
        if (empty($sqlCheckHojaFrontal)) {
            $this->config_mdl->_insert('os_consultorios_especialidad_hf', $data);
        } else {
            unset($data['hf_fg']);
            unset($data['hf_hg']);
            unset($data['empleado_id']);
            $this->config_mdl->_update_data('os_consultorios_especialidad_hf', $data, array(
                'hf_id' =>  $this->input->post('hf_id')
            ));
        }
        $this->config_mdl->_update_data('os_asistentesmedicas', $data_am, array(
            'triage_id' =>  $this->input->post('triage_id')
        ));
        if ($this->input->post('hf_ministeriopublico') == 'Si') {
            $sqlMP = $this->config_mdl->_get_data_condition('ts_ministerio_publico', array(
                'triage_id' => $this->input->post('triage_id')
            ));
            if (empty($sqlMP)) {
                $this->config_mdl->_insert('ts_ministerio_publico', array(
                    'mp_estatus' => 'Enviado',
                    'mp_fecha' => date('Y-m-d'),
                    'mp_hora' => date('H:i:s'),
                    'mp_area' => $this->input->post('tipo'),
                    'triage_id' => $this->input->post('triage_id'),
                    'medico_familiar' => $this->UMAE_USER
                ));
            }
        }
        $this->setOutput(array('accion' => '1'));
    }
    public function HojaInicialAbierto()
    {
        $sql['Especialidades'] = $this->config_mdl->_query("SELECT * FROM um_especialidades WHERE especialidad_interconsulta = 1 GROUP BY um_especialidades.especialidad_nombre");
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['hojafrontal'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'hf_id' =>  $this->input->get_post('hf')
        ));
        $sql['am'] =  $this->config_mdl->_get_data_condition('os_asistentesmedicas', array(
            'triage_id' =>  $this->input->get_post('folio')
        ));
        $sql['DirEmpresa'] =  $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'directorio_tipo' => 'Empresa',
            'triage_id' =>  $this->input->get_post('folio')
        ))[0];
        $sql['ce'] =  $this->config_mdl->_get_data_condition('os_consultorios_especialidad', array(
            'triage_id' =>  $this->input->get_post('folio')
        ));
        $sql['INFO_USER'] =  $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' =>  $_SESSION['UMAE_USER']
        ));
        $sql['Empresa'] = $this->config_mdl->_get_data_condition('os_triage_empresa', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['MinisterioPublico'] = $this->config_mdl->_get_data_condition('ts_ministerio_publico', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['SignosVitales'] = $this->config_mdl->_get_data_condition('os_triage_signosvitales', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['Documentos'] = $this->config_mdl->_get_data_condition('pc_documentos', array(
            'doc_nombre' => 'Hoja Frontal'
        ));
        $sql['Medicamentos'] = $this->config_mdl->_query("SELECT medicamento_id,
                                                                 CONCAT(medicamento,' ',gramaje, ', ', forma_farmaceutica)medicamento,
                                                                 interaccion_amarilla,interaccion_roja
                                                          FROM catalogo_medicamentos
                                                          WHERE existencia = 1 ORDER BY medicamento");

        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT *
                                                          FROM prescripcion
                                                          INNER JOIN catalogo_medicamentos
                                                            ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                          WHERE estado != 0 AND triage_id =" . $_GET['folio']);
        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT cie10_clave, cie10_nombre, complemento FROM paciente_diagnosticos
                                                          INNER JOIN diagnostico_hoja_frontal
                                                            ON paciente_diagnosticos.diagnostico_id = diagnostico_hoja_frontal.diagnostico_id
                                                          INNER JOIN um_cie10
                                                            ON um_cie10.cie10_id = paciente_diagnosticos.cie10_id
                                                          WHERE triage_id = " . $_GET['folio'] . " ORDER BY tipo_diagnostico");

        $sql['Prescripciones_canceladas'] = $this->config_mdl->_query("SELECT prescripcion.prescripcion_id
                                                                      FROM prescripcion
                                                                      INNER JOIN catalogo_medicamentos ON
                                                                      prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                      INNER JOIN os_triage ON
                                                                      prescripcion.triage_id = os_triage.triage_id
                                                                      INNER JOIN btcr_prescripcion ON
                                                                      prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                                                      WHERE os_triage.triage_id =" . $_GET['folio'] . " GROUP BY prescripcion_id");

        $sql['Interconsultas'] = $this->config_mdl->_query("SELECT * FROM interconsulta_hoja_frontal
                                                            INNER JOIN doc_430200
                                                                ON doc_430200.doc_id = interconsulta_hoja_frontal.doc_id
                                                            WHERE triage_id = " . $_GET['folio']);

        $sql['Procedimientos'] = $this->config_mdl->_query("SELECT * FROM um_procedimientos WHERE especialidad_id = 1 GROUP BY um_procedimientos.numero");

        //---------------mhma----------///
        $sql['um_catalogo_laboratorio_area'] = $this->config_mdl->_query("SELECT DISTINCT area FROM um_catalogolaboratorio");

        $sql['um_catalogo_laboratorio'] = $this->config_mdl->_query("SELECT * FROM um_catalogolaboratorio");

        foreach ($sql['um_catalogo_laboratorio_area'] as $area) {
            $tipos[$area['area']] = $this->config_mdl->_query("SELECT DISTINCT tipo FROM um_catalogolaboratorio WHERE area = '" . $area['area'] . "'");
        }

        $sql['um_catalogo_laboratorio_tipos'] = $tipos;

        $sql['um_estudios_obj'] = $this->config_mdl->_query("SELECT * FROM um_solicitud_laboratorio WHERE input_via = '" . $_GET['tipo'] . "' AND tipo_nota='" . $_GET['TipoNota'] . "' AND nota_id= '" . $_GET['hf'] . "'" . " AND triage_id = '" . $_GET['folio'] . "'");

        //---------------mhma----------///

        $this->load->view('Documentos/HojaInicialAbierto', $sql);
    }

    public function AjaxHojaInicialAbierto()
    {
        $consultorio = $this->config_mdl->_get_data_condition('os_consultorios_especialidad', array(
            'triage_id' =>  $this->input->post('triage_id')
        ))[0];

        $hf_nutricion = "";
        $radio_nutricion = $this->input->post('dieta');
        $select_nutricion = $this->input->post('tipoDieta');
        $otros_nutricion = $this->input->post('otraDieta');
        /* las siguiendes condiciones son para indexar el campo 'nota_nutricion'
          de esta forma se conoce el origen del dato.*/

        //Indica que el valor viene de una caja de texto
        if ($otros_nutricion != "" & $select_nutricion == 13) {
            $hf_nutricion = $otros_nutricion;
            // Indica que el valor viene de un select
        } else if ($select_nutricion >= 1 || $select_nutricion <= 12) {
            $hf_nutricion = $select_nutricion;
            // Indica que el valor viene de un radio
        } else if ($radio_nutricion == 0) {
            $hf_nutricion = $radio_nutricion;
        }

        $select_signos = $this->input->post("tomaSignos");
        $otros_signos = $this->input->post("otrasIndicacionesSignos");
        $hf_svycuidados = $select_signos;
        if ($select_signos == "3") {
            $hf_svycuidados = $otros_signos;
        }

        $hf_cgenfermeria = 1;
        if ($this->input->post("nota_cgenfermeria") != 1) {
            $hf_cgenfermeria = 0;
        }

        foreach ($this->input->post('procedimientos') as $procedimientos_select) {
            $procedimientos .= $procedimientos_select . ',';
        }
        $data = array(
            'hf_ce'                 => ($this->input->post('tipo') == 'Consultorios' ? '1' : '0'),
            'hf_obs'                => ($this->input->post('tipo') == 'Observación' ? '1' : '0'),
            'hf_choque'             => ($this->input->post('tipo') == 'Choque' ? '1' : '0'),
            'hf_fg'                 => date('d-m-Y'),
            'hf_hg'                 => date('H:i'),
            'hf_documento'          => $this->input->post('hf_documento'),
            'hf_motivo'             => $this->input->post('hf_motivo'), //Motivo de Consulta
            'hf_antecedentes'       => $this->input->post('hf_antecedentes'), //Antecedentes
            'hf_padecimientoa'      => $this->input->post('hf_padecimientoa'), // Padecimiento actual
            'hf_exploracionfisica'  => $this->input->post('hf_exploracionfisica'), // Eploracion fisica
            // ESCALA DE GLASGOW
            'hf_glasgow_ocular'     => $this->input->post('apertura_ocular'),
            'hf_glasgow_motora'     => $this->input->post('respuesta_motora'),
            'hf_glasgow_verbal'     => $this->input->post('respuesta_verbal'),
            'hf_escala_glasgow'     => $this->input->post('hf_escala_glasgow'),
            'hf_auxiliares'         => $this->input->post('hf_auxiliares'), // Auxiliares Diagnóstico
            'hf_riesgocaida'        => $this->input->post('hf_riesgocaida'),
            'hf_eva'                => $this->input->post('hf_eva'),
            'hf_riesgo_trombosis'   => $this->input->post('hf_riesgo_trombosis'),
            'funcionalidad_barthel' => $this->input->post('funcionalidad_barthel'),
            'escala_fragilidad'      => $this->input->post('escalaFragilidad'),
            // PLAN MEDICO
            'hf_nutricion'          => $hf_nutricion,
            'hf_signosycuidados'    => $hf_svycuidados,
            'hf_cgenfermeria'       => $hf_cgenfermeria,
            'hf_cuidadosenfermeria' => $this->input->post('hf_cuidadosenfermeria'),
            'hf_solucionesp'        => $this->input->post('hf_solucionesp'),
            'hf_indicaciones'       => $this->input->post('hf_indicaciones'), //Pronosticos
            'hf_estadosalud'        => $this->input->post('hf_estadosalud'), //Estado de salud
            'hf_alta'               => $this->input->post('hf_alta'),
            'hf_alta_otros'         => $this->input->post('hf_alta_otros'),
            'hf_tipourgencia'       => $this->input->post('hf_tipourgencia'),
            'triage_id'             => $this->input->post('triage_id'),
            'empleado_id'           => $this->UMAE_USER,
            'hf_procedimientos'     => trim($procedimientos, ',')
        );

        $data_am = array(
            /*'asistentesmedicas_da'                  =>  $this->input->post('asistentesmedicas_da'),
            'asistentesmedicas_dl'                  =>  $this->input->post('asistentesmedicas_dl'),
            'asistentesmedicas_ip'                  =>  $this->input->post('asistentesmedicas_ip'),
            'asistentesmedicas_tratamientos'        =>  $this->input->post('asistentesmedicas_tratamientos'),
            'asistentesmedicas_ss_in'               =>  $this->input->post('asistentesmedicas_ss_in'),
            'asistentesmedicas_ss_ie'               =>  $this->input->post('asistentesmedicas_ss_ie'),
            'asistentesmedicas_oc_hr'               =>  $this->input->post('asistentesmedicas_oc_hr'),
            'asistentesmedicas_am'                  =>  $this->input->post('asistentesmedicas_am'),
            'asistentesmedicas_incapacidad_am'      =>  $this->input->post('asistentesmedicas_incapacidad_am'),
            'asistentesmedicas_incapacidad_ga'      =>  $this->input->post('asistentesmedicas_incapacidad_ga'),
            'asistentesmedicas_incapacidad_tipo'    =>  $this->input->post('asistentesmedicas_incapacidad_tipo'),
            'asistentesmedicas_incapacidad_dias_a'  =>  $this->input->post('asistentesmedicas_incapacidad_dias_a'),
            'asistentesmedicas_incapacidad_fi'      =>  $this->input->post('asistentesmedicas_incapacidad_fi'),
            'asistentesmedicas_incapacidad_da'      =>  $this->input->post('asistentesmedicas_incapacidad_da'),*/
            'asistentesmedicas_mt'                  =>  $this->input->post('asistentesmedicas_mt'),
            'asistentesmedicas_mt_m'                =>  $this->input->post('asistentesmedicas_mt_m'),
            'asistentesmedicas_incapacidad_folio'   =>  $this->input->post('asistentesmedicas_incapacidad_folio'),
            'asistentesmedicas_omitir'              =>  $this->input->post('asistentesmedicas_omitir')
        );

        if ($this->input->post('tipo') == 'Consultorios') {
            if ($consultorio['ce_status'] == 'Salida') {
                unset($data['hf_alta']);
            } else {
                $this->config_mdl->_update_data('os_consultorios_especialidad', array(
                    'ce_hf' => ($this->input->post('hf_alta') != 'Otros' ? $this->input->post('hf_alta') : $this->input->post('hf_alta_otros'))
                ), array(
                    'triage_id' =>  $this->input->post('triage_id')
                ));
            }
        }
        $select_alergias = $this->input->post('select_alergias');
        $textarea_alergias = $this->input->post('alergias');
        $alergias = "";

        if ($select_alergias == '1') {
            $alergias = $textarea_alergias;
        } else if ($select_alergias == '2') {
            $alergias = "Negadas";
        }
        $this->config_mdl->_update_data(
            'paciente_info',
            array('alergias' => $alergias),
            array('triage_id' => $this->input->post('triage_id'))
        );

        /* Se hace órden de internamiento */
        // $check_internamiento = $this->input->post('check_internamiento');
        //     if($check_internamiento =! 0) {     
        //         $data_internamiento = array(
        //             'triage_id'         => $this->input->post('triage_id'),
        //             'fecha_solicitud'   => date('d-m-Y H:i'),
        //             'ordeni_tipo'       => 'Urgente',
        //             'ordeni_fecha'      => date('d-m-Y H:i'),
        //             'ordeni_hr'         => date('H:i'),
        //             'ordeni_medicoid' => $this->UMAE_USER,
        //             'ordeni_especialidadid' => $this->input->post('ordeni_especialidadid'),
        //             'ordeni_motivo' => $this->input->post('ordeni_motivo')
        //        );

        $sqlCheckHojaFrontal = $this->config_mdl->sqlGetDataCondition('os_consultorios_especialidad_hf', array(
            'triage_id' => $this->input->post('triage_id')
        ), 'hf_id');

        $sqlCheckDiagnosticos = $this->config_mdl->sqlGetDataCondition('paciente_diagnosticos', array(
            'triage_id' => $this->input->post('triage_id')
        ));

        /** Comprueba si no hay Hoaja inicial y guarda los campos dl formulario Nota Inicial
         *  Regresa en formato Json respuesta 
         */
        if (empty($sqlCheckHojaFrontal)) {
            if (!empty($sqlCheckDiagnosticos)) {
                // $internamiento= $this->config_mdl->sqlGetDataCondition('um_ordeninternamiento', array(
                //     'triage_id'=>  $this->input->post('triage_id')
                // ))[0];
                // Se determina si el valor a registrar es del select o del textarea

                // Se toman los valores del formulario 'Instrucciones de nutricion'

                $last_id_hf = $this->config_mdl->_insert('os_consultorios_especialidad_hf', $data);

                if ($last_id_hf) $last_id_hf = $this->db->insert_id();
                //Se toman los medicamentos a los que es alergico el paciente y se registra
                // for($x = 0; $x < count($this->input->post('alergias_medicamento')); $x++){
                //     $datos = array(
                //       'medicamento_id' => $this->input->post("alergias_medicamento[$x]"),
                //       'triage_id' => $this->input->post('triage_id')
                //     );
                //     $this->config_mdl->_insert('um_alergias_medicamentos',$datos);
                // }

                /* Solicitud de interconsultas */
                for ($x = 0; $x < count($this->input->post('nota_interconsulta')); $x++) {
                    // $existencia_interconsuta = $this->config_mdl->_query(
                    //  "SELECT doc_id
                    //   FROM doc_430200
                    //   WHERE doc_servicio_solicitado = ".$this->input->post("nota_interconsulta[$x]")
                    // );

                    $this->config_mdl->_update_data('os_consultorios_especialidad', array(
                        'ce_status' => 'Interconsulta',
                        'ce_interconsulta' => 'Si'
                    ), array(
                        'triage_id' =>  $this->input->post('triage_id')
                    ));

                    $datos_interconsulta = array(
                        'doc_estatus' => 'En Espera',
                        'doc_fecha' => date('Y-m-d'),
                        'doc_hora' => date('H:i'),
                        'doc_area' => $this->UMAE_AREA,
                        'doc_servicio_envia' => Modules::run('Consultorios/ObtenerEspecialidadID', array('Consultorio' => $this->UMAE_AREA)),
                        'doc_servicio_solicitado' => $this->input->post("nota_interconsulta[$x]"),
                        'triage_id' => $this->input->post('triage_id'),
                        'doc_modulo' => "Consultorios",
                        'motivo_interconsulta' => $this->input->post('motivo_interconsulta'),
                        'empleado_envia' => $this->UMAE_USER
                    );
                    $this->config_mdl->_insert('doc_430200', $datos_interconsulta);
                }
                /*
                Se consultan las interconsultas realizadas en la nota inicial, para
                ser registrados en el historial de interconsultas de la nota
                */
                $interconsultas_hf = $this->config_mdl->_query("SELECT doc_id FROM doc_430200
                                                                WHERE triage_id = " . $this->input->post('triage_id'));
                for ($x = 0; $x < count($interconsultas_hf); $x++) {
                    $datos = array(
                        "hf_id" => $this->config_mdl->_get_last_id('os_consultorios_especialidad_hf', 'hf_id'),
                        "doc_id" => $interconsultas_hf[$x]['doc_id']
                    );
                    $this->config_mdl->_insert('interconsulta_hoja_frontal', $datos);
                }
                /*Inicio Registro de prescricpiones*/
                $fecha_actual = date('d-m-Y');
                // Numero de prescripciones ingresadas, almacena en arreglo y registra en la
                // tabla "prescripcio"
                for ($x = 0; $x < count($this->input->post('idMedicamento')); $x++) {
                    $observacion = $this->input->post("observacion[$x]");
                    $otroMedicamento = $this->input->post("nomMedicamento[$x]");
                    if ($this->input->post("idMedicamento[$x]") == '1') {
                        $observacion = $otroMedicamento . '-' . $observacion;
                    }
                    $datosPrescripcion = array(
                        'empleado_id' => $this->UMAE_USER,
                        'triage_id' => $this->input->post('triage_id'),
                        'medicamento_id' => $this->input->post("idMedicamento[$x]"),
                        'via' => $this->input->post("via_admi[$x]"),
                        'fecha_prescripcion' => $fecha_actual,
                        'dosis' => $this->input->post("dosis[$x]"),
                        'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                        'via' => $this->input->post("via[$x]"),
                        'frecuencia' => $this->input->post("frecuencia[$x]"),
                        'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                        'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                        'tiempo' => $this->input->post("duracion[$x]"),
                        'periodo' => $this->input->post("periodo[$x]"),
                        'fecha_fin' => $this->input->post("fechaFin[$x]"),
                        'observacion' => $observacion,
                        'estado' => "1"
                    );
                    $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                }
                //Número de antibioticos apt
                for ($x = 0; $x < count($this->input->post('idMedicamento_npt')); $x++) {
                    //Se guardan en un arreglo los datos del medicamento
                    $datosPrescripcion = array(
                        'empleado_id' => $this->UMAE_USER,
                        'triage_id' => $this->input->post('triage_id'),
                        'medicamento_id' => $this->input->post("idMedicamento_npt[$x]"),
                        'dosis' => $this->input->post("dosis[$x]"),
                        'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                        'via' => $this->input->post("via[$x]"),
                        'frecuencia' => $this->input->post("frecuencia[$x]"),
                        'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                        'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                        'tiempo' => $this->input->post("duracion[$x]"),
                        'periodo' => $this->input->post("periodo[$x]"),
                        'fecha_fin' => $this->input->post("fechaFin[$x]"),
                        'observacion' => $this->input->post("observacion[$x]"),
                        'estado' => "1"
                    );
                    //Se registra el medicamento
                    $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                    //Se consulta la ultima prescripcion registrada
                    $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                    /*
                  Se toman los datos necesarios para un npt
                  con la variable $ultima_prescripcion, identificamos la prescripcion con la que se
                  asocia prescripcion y npt
                  */
                    $datos_npt = array(
                        'prescripcion_id' => $ultima_prescripcion,
                        'aminoacido' => $this->input->post("aminoacido[$x]"),
                        'dextrosa' => $this->input->post("dextrosa[$x]"),
                        'lipidos' => $this->input->post("lipidos_intravenosos[$x]"),
                        'agua_inyect' => $this->input->post("agua_inyectable[$x]"),
                        'cloruro_sodio' => $this->input->post("cloruro_sodio[$x]"),
                        'sulfato' => $this->input->post("sulfato_magnesio[$x]"),
                        'cloruro_potasio' => $this->input->post("cloruro_potasio[$x]"),
                        'fosfato' => $this->input->post("fosfato_potasio[$x]"),
                        'gluconato' => $this->input->post("gluconato_calcio[$x]"),
                        'albumina' => $this->input->post("albumina[$x]"),
                        'heparina' => $this->input->post("heparina[$x]"),
                        'insulina' => $this->input->post("insulina_humana[$x]"),
                        'zinc' => $this->input->post("zinc[$x]"),
                        'mvi' => $this->input->post("mvi_adulto[$x]"),
                        'oligoelementos' => $this->input->post("oligoelementos[$x]"),
                        'vitamina' => $this->input->post("vitamina[$x]")
                    );
                    $this->config_mdl->_insert('prescripcion_npt', $datos_npt);
                }
                //Número de antibioticos antimicrobiano u oncologico
                for ($x = 0; $x < count($this->input->post('idMedicamento_onco_antimicro')); $x++) {
                    $datosPrescripcion = array(
                        'empleado_id' => $this->UMAE_USER,
                        'triage_id' => $this->input->post('triage_id'),
                        'medicamento_id' => $this->input->post("idMedicamento_onco_antimicro[$x]"),
                        'dosis' => $this->input->post("dosis[$x]"),
                        'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                        'via' => $this->input->post("via[$x]"),
                        'frecuencia' => $this->input->post("frecuencia[$x]"),
                        'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                        'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                        'tiempo' => $this->input->post("duracion[$x]"),
                        'periodo' => $this->input->post("periodo[$x]"),
                        'fecha_fin' => $this->input->post("fechaFin[$x]"),
                        'observacion' => $this->input->post("observacion[$x]"),
                        'estado' => "1"
                    );
                    $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                    $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                    $categoria_safe = $this->input->post("categoria_safe[$x]");
                    $datos_onco_antimicrobiano = array(
                        'prescripcion_id' => $ultima_prescripcion,
                        'categoria_safe' => $categoria_safe,
                        'diluente' => $this->input->post("diluyente[$x]"),
                        'vol_dilucion' => $this->input->post("vol_diluyente[$x]")
                    );
                    $this->config_mdl->_insert('prescripcion_onco_antimicrobianos', $datos_onco_antimicrobiano);
                }
                // Se toma el ID de las precripcines activas
                $Prescripciones = $this->config_mdl->_query("SELECT prescripcion_id FROM prescripcion WHERE estado != 0 
                                                            AND triage_id = '{$this->input->post('triage_id')}'");
                for ($x = 0; $x < count($Prescripciones); $x++) {
                    $FrontalPrescripcion = array(
                        'hf_id' => $this->config_mdl->_get_last_id('os_consultorios_especialidad_hf', 'hf_id'),
                        'prescripcion_id' => $Prescripciones[$x]['prescripcion_id']
                    );
                    // Se registra la relacion entre notas y prescripcion
                    $this->config_mdl->_insert('nm_hojafrontal_prescripcion', $FrontalPrescripcion);
                }

                /*
                Se consultan los diagnosticos del paciente registrados
                para ser asignados en la hoja frontal
                */

                $diagnostico = $this->config_mdl->_query("SELECT diagnostico_id
                                                          FROM paciente_diagnosticos
                                                          WHERE triage_id =" . $this->input->post('triage_id') . "");
                // if(!empty($diagnostico)) {
                for ($x = 0; $x < count($diagnostico); $x++) {
                    $datos = array(
                        'hf_id' => $this->config_mdl->_get_last_id('os_consultorios_especialidad_hf', 'hf_id'),
                        'diagnostico_id' => $diagnostico[$x]['diagnostico_id']
                    );
                    $this->config_mdl->_insert('diagnostico_hoja_frontal', $datos);
                }
                // }else {
                // echo "No hay diagnosticos Ingresados";

                // }
            }

            // $this->config_mdl->_insert('um_ordeninternamiento', $data_internamiento);
        } else {

            unset($data['hf_fg']);
            unset($data['hf_hg']);
            unset($data['empleado_id']);
            $this->config_mdl->_update_data('os_consultorios_especialidad_hf', $data, array(
                'hf_id' =>  $this->input->post('hf_id')
            ));

            /*Inicio Registro de prescricpiones*/
            $fecha_actual = date('d-m-Y');
            for ($x = 0; $x < count($this->input->post('idMedicamento')); $x++) {
                $observacion = $this->input->post("observacion[$x]");
                $otroMedicamento = $this->input->post("nomMedicamento[$x]");
                if ($this->input->post("idMedicamento[$x]") == '1') {
                    $observacion = $otroMedicamento . '-' . $observacion;
                }
                $datosPrescripcion = array(
                    'empleado_id' => $this->UMAE_USER,
                    'triage_id' => $this->input->post('triage_id'),
                    'medicamento_id' => $this->input->post("idMedicamento[$x]"),
                    'via' => $this->input->post("via_admi[$x]"),
                    'fecha_prescripcion' => $fecha_actual,
                    'dosis' => $this->input->post("dosis[$x]"),
                    'frecuencia' => $this->input->post("frecuencia[$x]"),
                    'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                    'tiempo' => $this->input->post("duracion[$x]"),
                    'periodo' => $this->input->post("periodo[$x]"),
                    'fecha_fin' => $this->input->post("fechaFin[$x]"),
                    'observacion' => $observacion,
                    'estado' => "1"
                );
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
            }
            //Número de antibioticos apt
            for ($x = 0; $x < count($this->input->post('idMedicamento_npt')); $x++) {
                //Se guardan en un arreglo los datos del medicamento
                $datosPrescripcion = array(
                    'empleado_id' => $this->UMAE_USER,
                    'triage_id' => $this->input->post('triage_id'),
                    'medicamento_id' => $this->input->post("idMedicamento_npt[$x]"),
                    'dosis' => $this->input->post("dosis[$x]"),
                    'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                    'via' => $this->input->post("via[$x]"),
                    'frecuencia' => $this->input->post("frecuencia[$x]"),
                    'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                    'tiempo' => $this->input->post("duracion[$x]"),
                    'periodo' => $this->input->post("periodo[$x]"),
                    'fecha_fin' => $this->input->post("fechaFin[$x]"),
                    'observacion' => $this->input->post("observacion[$x]"),
                    'estado' => "1"
                );
                //Se registra el medicamento
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                //Se consulta la ultima prescripcion registrada
                $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                /*
                  Se toman los datos necesarios para un npt
                  con la variable $ultima_prescripcion, identificamos la prescripcion con la que se
                  asocia prescripcion y npt
                  */
                $datos_npt = array(
                    'prescripcion_id' => $ultima_prescripcion,
                    'aminoacido' => $this->input->post("aminoacido[$x]"),
                    'dextrosa' => $this->input->post("dextrosa[$x]"),
                    'lipidos' => $this->input->post("lipidos_intravenosos[$x]"),
                    'agua_inyect' => $this->input->post("agua_inyectable[$x]"),
                    'cloruro_sodio' => $this->input->post("cloruro_sodio[$x]"),
                    'sulfato' => $this->input->post("sulfato_magnesio[$x]"),
                    'cloruro_potasio' => $this->input->post("cloruro_potasio[$x]"),
                    'fosfato' => $this->input->post("fosfato_potasio[$x]"),
                    'gluconato' => $this->input->post("gluconato_calcio[$x]"),
                    'albumina' => $this->input->post("albumina[$x]"),
                    'heparina' => $this->input->post("heparina[$x]"),
                    'insulina' => $this->input->post("insulina_humana[$x]"),
                    'zinc' => $this->input->post("zinc[$x]"),
                    'mvi' => $this->input->post("mvi_adulto[$x]"),
                    'oligoelementos' => $this->input->post("oligoelementos[$x]"),
                    'vitamina' => $this->input->post("vitamina[$x]")
                );
                $this->config_mdl->_insert('prescripcion_npt', $datos_npt);
            }
            //Número de antibioticos antimicrobiano u oncologico

            for ($x = 0; $x < count($this->input->post('idMedicamento_onco_antimicro')); $x++) {
                $datosPrescripcion = array(
                    'empleado_id' => $this->UMAE_USER,
                    'triage_id' => $this->input->post('triage_id'),
                    'medicamento_id' => $this->input->post("idMedicamento_onco_antimicro[$x]"),
                    'dosis' => $this->input->post("dosis[$x]"),
                    'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                    'via' => $this->input->post("via[$x]"),
                    'frecuencia' => $this->input->post("frecuencia[$x]"),
                    'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                    'tiempo' => $this->input->post("duracion[$x]"),
                    'periodo' => $this->input->post("periodo[$x]"),
                    'fecha_fin' => $this->input->post("fechaFin[$x]"),
                    'observacion' => $this->input->post("observacion[$x]"),
                    'estado' => "1"
                );
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                $categoria_safe = $this->input->post("categoria_safe[$x]");
                $datos_onco_antimicrobiano = array(
                    'prescripcion_id' => $ultima_prescripcion,
                    'categoria_safe' => $categoria_safe,
                    'diluente' => $this->input->post("diluyente[$x]"),
                    'vol_dilucion' => $this->input->post("vol_diluyente[$x]")
                );
                $this->config_mdl->_insert('prescripcion_onco_antimicrobianos', $datos_onco_antimicrobiano);
            }
            /*Inicio Registro de prescricpiones*/
            // Se toma el ID de las precripcines activas
            $Prescripciones = $this->config_mdl->_query("SELECT prescripcion_id
                                                             FROM prescripcion
                                                             WHERE estado != 0 AND triage_id = " . $this->input->post('triage_id') . ";");
            $this->config_mdl->_delete_data('nm_hojafrontal_prescripcion', array('hf_id' => $this->input->post('hf_id')));
            for ($x = 0; $x < count($Prescripciones); $x++) {
                $FrontalPrescripcion = array(
                    'hf_id' => $this->config_mdl->_get_last_id('os_consultorios_especialidad_hf', 'hf_id'),
                    'prescripcion_id' => $Prescripciones[$x]['prescripcion_id']
                );
                // Se registra la relacion entre notas y prescripcion
                $this->config_mdl->_insert('nm_hojafrontal_prescripcion', $FrontalPrescripcion);
            } /*Fin proceso prescripción*/

            $Dignostico_hf = $this->config_mdl->_query("SELECT * FROM diagnostico_hoja_frontal WHERE hf_id ='{$this->input->post('hf_id')}' ");
            $this->config_mdl->_delete_data('diagnostico_hoja_frontal', array('hf_id' => $this->input->post('hf_id')));

            foreach ($sqlCheckDiagnosticos as $value) {
                $dxs = array(
                    'hf_id'  => $this->config_mdl->_get_last_id('os_consultorios_especialidad_hf', 'hf_id'),
                    'diagnostico_id' => $value['diagnostico_id']
                );
                $this->config_mdl->_insert('diagnostico_hoja_frontal', $dxs);
            }
        }
        $this->config_mdl->_update_data('os_asistentesmedicas', $data_am, array(
            'triage_id' =>  $this->input->post('triage_id')
        ));
        // $this->config_mdl->_update_data('um_ordeninternamiento',$data_internamiento, array(
        //    'triage_id'=>  $this->input->post('triage_id')
        // ));



        //-----------------solicitud_laboratorio------------//

        if ($last_id_hf  && $this->input->post('accion') == 'add') {
            $hf_id = $last_id_hf;
        } else {
            $hf_id = $this->input->post('hf_id');
        }

        if ($hf_id != "0") {

            $data_solicitud_laboratorio = array(
                'input_via'       =>  $this->input->post('tipo'),
                'tipo_nota'       =>  $this->input->post('tipo_nota'),
                'nota_id'         =>  $hf_id,
                'fecha_solicitud' =>  date('d-m-Y'),
                'triage_id'       =>  $this->input->post('triage_id'),
                'estudios'        =>  $this->input->post('arreglo_id_catalogo_estudio')
            );

            if ($this->input->post('solicitud_laboratorio_id')) {
                $this->config_mdl->_update_data('um_solicitud_laboratorio', $data_solicitud_laboratorio, array('solicitud_id' =>  $this->input->post('solicitud_laboratorio_id')));
            } else if ($this->input->post('arreglo_id_catalogo_estudio') != "{}") {
                $this->config_mdl->_insert('um_solicitud_laboratorio', $data_solicitud_laboratorio);
            }
        }

        //-----------------solicitud_laboratorio------------
        /** Comprueba si no se ha ingresado Un diagnostico entonce manda a mensaje a Jquery que no debe de haber un diagnsotico de ingreso
         */
        $os_camas = $this->config_mdl->_query("SELECT * FROM os_camas WHERE area_id = 1 AND triage_id =" . $this->input->post('triage_id') . ";");
        if (!empty($os_camas)) {
            $estado_salud = array("estado_salud" => $this->input->post('hf_estadosalud'));
            $this->config_mdl->_update_data('os_camas', $estado_salud, array('triage_id' =>  $this->input->post('triage_id')));
        }
        if (empty($sqlCheckDiagnosticos)) {
            $this->setOutput(array('accion' => '0'));
        } else {
            $this->setOutput(array('accion' => '1', 'val' => 'f'));
            //$this->setOutput(array('accion'=>'1'));
        }
    }

    public function AjaxUltimasOrdenes()
    {
        $folio = $_GET['folio'];
        $consultaNota = "SELECT nota_nutricion, nota_svycuidados, nota_cgenfermeria,
                          nota_cuidadosenfermeria, nota_solucionesp
                   FROM doc_nota
                   INNER JOIN doc_notas
                     ON doc_nota.notas_id = doc_notas.notas_id
                   WHERE triage_id = " . $folio . "
                   ORDER BY nota_id DESC LIMIT 1";
        $consultaHFrontal = "SELECT hf_nutricion, hf_signosycuidados, hf_cgenfermeria,
                           hf_cuidadosenfermeria, hf_solucionesp
                           FROM os_consultorios_especialidad_hf
                           WHERE triage_id = " . $folio . " ";
        $sql = $this->config_mdl->_query($consultaNota);
        if (COUNT($sql) < 1) {
            $sql = $this->config_mdl->_query($consultaHFrontal);
        }
        print json_encode($sql);
    }
    public function AjaxDiagnosticos()
    {
        $diagnostico_solicitado = $_GET['diagnostico_solicitado'];
        $sql = $this->config_mdl->_query("SELECT * FROM um_cie10
                                        WHERE cie10_nombre LIKE '%$diagnostico_solicitado%' ORDER BY cie10_nombre LIMIT 100 ");
        print json_encode($sql);
    }

    /*DOCUMENTOS OBSERVACIÓN*/
    public function TratamientoQuirurgico($Paciente)
    {
        $sql['tratamientos'] =  $this->config_mdl->_get_data_condition('os_observacion_tratamientos', array(
            'triage_id' => $Paciente
        ));
        $this->load->view('Documentos/TratamientoQuirurgico', $sql);
    }
    public function AjaxTratamientosQuirurgicos()
    {
        $data = array(
            'tratamiento_nombre' => $this->input->post('tratamiento_nombre'),
            'tratamiento_fecha' => date('d/m/Y'),
            'tratamiento_hora' => date('H:i'),
            'triage_id' => $this->input->post('triage_id'),
            'empleado_id' => $this->UMAE_USER
        );
        if ($this->input->post('accion') == 'add') {
            $this->config_mdl->_insert('os_observacion_tratamientos', $data);
        } else {
            unset($data['tratamiento_fecha']);
            unset($data['tratamiento_hora']);
            unset($data['empleado_id']);
            $this->config_mdl->_update_data('os_observacion_tratamientos', $data, array(
                'tratamiento_id' => $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion' => '1'));
    }
    public function DocumentosTratamientoQuirurgico($Tratamiento)
    {
        $sql['triage'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get('folio')
        ));
        $sql['observacion'] =  $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' => $this->input->get('folio')
        ));
        $sql['st'] =  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion', array(
            'tratamiento_id' => $Tratamiento
        ));
        $sql['cs'] =  $this->config_mdl->_get_data_condition('os_observacion_cirugiasegura', array(
            'tratamiento_id' => $Tratamiento
        ));
        $sql['si'] =  $this->config_mdl->_get_data_condition('os_observacion_ci', array(
            'tratamiento_id' => $Tratamiento
        ));
        $sql['cci'] =  $this->config_mdl->_get_data_condition('os_observacion_cci', array(
            'tratamiento_id' => $Tratamiento
        ));
        $sql['isq'] =  $this->config_mdl->_get_data_condition('os_observacion_isq', array(
            'tratamiento_id' => $Tratamiento
        ));
        $this->load->view('Documentos/TratamientoQuirurgico/ComboQuirurgico', $sql);
    }
    public function SolicitudTransfusion($Tratamiento)
    {
        $sql['triage'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get('folio')
        ));
        $sql['observacion'] =  $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' => $this->input->get('folio')
        ));
        $sql['empleado'] =  $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['observacion'][0]['observacion_medico']
        ));
        $sql['st'] =  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion', array(
            'tratamiento_id' => $Tratamiento
        ));
        $this->load->view('Documentos/TratamientoQuirurgico/SolicitudTransfusion', $sql);
    }
    public function AjaxSolicitudTransfusion()
    {
        $data = array(
            'solicitudtransfucion_sangre' =>  $this->input->post('solicitudtransfucion_sangre'),
            'solicitudtransfucion_plasma' =>  $this->input->post('solicitudtransfucion_plasma'),
            'solicitudtransfucion_suspensionconcentrada' =>  $this->input->post('solicitudtransfucion_suspensionconcentrada'),
            'solicitudtransfucion_otros' =>  $this->input->post('solicitudtransfucion_otros'),
            'solicitudtransfucion_otros_val' =>  $this->input->post('solicitudtransfucion_otros_val'),
            'solicitudtransfucion_ordinaria' =>  $this->input->post('solicitudtransfucion_ordinaria'),
            'solicitudtransfucion_urgente' =>  $this->input->post('solicitudtransfucion_urgente'),
            'solicitudtransfucion_urgente_vol' =>  $this->input->post('solicitudtransfucion_urgente_vol'),
            'solicitudtransfucion_operacion_dia' =>  $this->input->post('solicitudtransfucion_operacion_dia'),
            'solicitudtransfucion_operacion_hora' =>  $this->input->post('solicitudtransfucion_operacion_hora'),
            'solicitudtransfucion_disponible' =>  $this->input->post('solicitudtransfucion_disponible'),
            'solicitudtransfucion_reserva' =>  $this->input->post('solicitudtransfucion_reserva'),
            'solicitudtransfucion_gs_abo' =>  $this->input->post('solicitudtransfucion_gs_abo'),
            'solicitudtransfucion_gs_rhd' =>  $this->input->post('solicitudtransfucion_gs_rhd'),
            'solicitudtransfucion_gs_ignora' =>  $this->input->post('solicitudtransfucion_gs_ignora'),
            'solicitudtransfucion_diagnostico' =>  $this->input->post('solicitudtransfucion_diagnostico'),
            'solicitudtransfucion_hb' =>  $this->input->post('solicitudtransfucion_hb'),
            'solicitudtransfucion_ht' =>  $this->input->post('solicitudtransfucion_ht'),
            'solicitudtransfucion_transfuciones_previas' =>  $this->input->post('solicitudtransfucion_transfuciones_previas'),
            'solicitudtransfucion_reacciones_postransfuncionales' =>  $this->input->post('solicitudtransfucion_reacciones_postransfuncionales'),
            'solicitudtransfucion_fecha_ultima' =>  $this->input->post('solicitudtransfucion_fecha_ultima'),
            'solicitudtransfucion_embarazo_previo' =>  $this->input->post('solicitudtransfucion_embarazo_previo'),
            'solicitudtransfucion_pfh' =>  $this->input->post('solicitudtransfucion_pfh'),
            'solicitudtransfucion_solicita_f' =>  $this->input->post('solicitudtransfucion_solicita_f'),
            'solicitudtransfucion_solicita_h' =>  $this->input->post('solicitudtransfucion_solicita_h'),
            'solicitudtransfucion_recibio_nombre' =>  $this->input->post('solicitudtransfucion_recibio_nombre'),
            'solicitudtransfucion_recibio_f' =>  $this->input->post('solicitudtransfucion_recibio_f'),
            'solicitudtransfucion_recibio_h' =>  $this->input->post('solicitudtransfucion_recibio_h'),
            'tratamiento_id' => $this->input->post('tratamiento_id'),
            'triage_id' =>  $this->input->post('triage_id')
        );
        if (empty($this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion', array('tratamiento_id' =>  $this->input->post('tratamiento_id'))))) {
            $this->config_mdl->_insert('os_observacion_solicitudtransfucion', $data);
        } else {
            $this->config_mdl->_update_data('os_observacion_solicitudtransfucion', $data, array(
                'tratamiento_id' =>  $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion' => '1'));
    }
    public function CirugiaSegura($Tratamiento)
    {
        $sql['triage'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get('folio')
        ));
        $sql['observacion'] =  $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' => $this->input->get('folio')
        ));
        $sql['empleado'] =  $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['observacion'][0]['observacion_medico']
        ));
        $sql['cs'] =  $this->config_mdl->_get_data_condition('os_observacion_cirugiasegura', array(
            'triage_id' => $Tratamiento
        ));
        $this->load->view('Documentos/TratamientoQuirurgico/CirugiaSegura', $sql);
    }
    public function AjaxCirugiaSegura()
    {
        $data = array(
            'cirugiasegura_procedimiento' =>  $this->input->post('cirugiasegura_procedimiento'),
            'triage_id' =>  $this->input->post('triage_id'),
            'tratamiento_id' => $this->input->post('tratamiento_id')
        );
        if (empty($this->config_mdl->_get_data_condition('os_observacion_cirugiasegura', array('tratamiento_id' =>  $this->input->post('tratamiento_id'))))) {
            $this->config_mdl->_insert('os_observacion_cirugiasegura', $data);
        } else {
            $this->config_mdl->_update_data('os_observacion_cirugiasegura', $data, array(
                'tratamiento_id' =>  $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion' => '1'));
    }
    public function SolicitudeIntervencion($Tratamiento)
    {
        $sql['triage'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get('folio')
        ));
        $sql['observacion'] =  $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' => $this->input->get('folio')
        ));
        $sql['empleado'] =  $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $sql['observacion'][0]['observacion_medico']
        ));

        $sql['especialidad'] = $this->config_mdl->_get_data_condition('um_especialidades', array(
            'especialidad_id' => $sql['empleado'][0]['empleado_servicio']
        ));

        $sql['si'] =  $this->config_mdl->_get_data_condition('um_cirugias_solicitudes', array(
            'tratamiento_id' => $Tratamiento
        ));
        $sql['MedicosBase'] = $this->config_mdl->_query("SELECT empleado_id, empleado_matricula,empleado_nombre, empleado_apellidos FROM os_empleados
                                                        WHERE empleado_roles != 77 AND empleado_servicio =
                                                          (SELECT empleado_servicio
                                                           FROM os_empleados
                                                           WHERE empleado_id = '$this->UMAE_USER')");

        $this->load->view('Documentos/TratamientoQuirurgico/SolicitudeIntervencion', $sql);
    }
    public function AjaxSolicitudeIntervencion()
    {
        $data = array(
            'ci_servicio' =>  $this->input->post('ci_servicio'),
            'ci_fecha_solicitud' =>  $this->input->post('ci_fecha_solicitud'),
            'ci_fecha_solicitada' =>  $this->input->post('ci_fecha_solicitada'),
            'ci_hora_deseada' =>  $this->input->post('ci_hora_deseada'),
            'ci_prioridad' =>  $this->input->post('ci_prioridad'),
            'ci_diagnostico' =>  $this->input->post('ci_diagnostico'),
            'ci_operacion_planeada' =>  $this->input->post('ci_operacion_planeada'),
            'ci_operacion_eu' =>  $this->input->post('ci_operacion_eu'),
            'ci_ap' =>  $this->input->post('ci_ap'),
            'ci_tec' =>  $this->input->post('ci_tec'),
            'ci_njs' =>  $this->input->post('ci_njs'),
            'ci_nmc' =>  $this->input->post('ci_nmc'),
            'ci_mmc' =>  $this->input->post('ci_mmc'),
            'triage_id' =>  $this->input->post('triage_id'),
            'tratamiento_id' => $this->input->post('tratamiento_id')
        );
        if (empty($this->config_mdl->_get_data_condition('os_observacion_ci', array('tratamiento_id' =>  $this->input->post('tratamiento_id'))))) {
            $this->config_mdl->_insert('os_observacion_ci', $data);
        } else {
            $this->config_mdl->_update_data('os_observacion_ci', $data, array(
                'tratamiento_id' =>  $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion' => '1'));
    }
    public function ConsentimientoInformado($Tratamiento)
    {
        $sql['triage'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get('folio')
        ));
        $sql['observacion'] =  $this->config_mdl->_get_data_condition('os_observacion', array(
            'triage_id' => $this->input->get('folio')
        ));
        $sql['cci'] =  $this->config_mdl->_get_data_condition('os_observacion_cci', array(
            'triage_id' => $Tratamiento
        ));
        $sql['st'] =  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion', array(
            'tratamiento_id' => $Tratamiento
        ));
        $this->load->view('Documentos/TratamientoQuirurgico/ConsentimientoInformado', $sql);
    }
    public function AjaxConsentimientoInformado()
    {
        $data = array(
            'cci_fecha' =>  $this->input->post('cci_fecha'),
            'cci_la_que_suscribe' =>  $this->input->post('cci_la_que_suscribe'),
            'cci_caracter' =>  $this->input->post('cci_caracter'),
            'cci_tipo_ct' =>  $this->input->post('cci_tipo_ct'),
            'cci_pronostico' =>  $this->input->post('cci_pronostico'),
            'triage_id' =>  $this->input->post('triage_id'),
            'tratamiento_id' => $this->input->post('tratamiento_id')
        );
        if (empty($this->config_mdl->_get_data_condition('os_observacion_cci', array('tratamiento_id' =>  $this->input->post('tratamiento_id'))))) {
            $this->config_mdl->_insert('os_observacion_cci', $data);
        } else {
            $this->config_mdl->_update_data('os_observacion_cci', $data, array(
                'tratamiento_id' =>  $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion' => '1'));
    }
    public function ListaVerificacionISQ($Tratamiento)
    {

        $sql['isq'] =  $this->config_mdl->_get_data_condition('os_observacion_isq', array(
            'tratamiento_id' => $Tratamiento
        ));
        $this->load->view('Documentos/TratamientoQuirurgico/ListaVerificacionISQ', $sql);
    }
    public function AjaxListaVerificacionISQ()
    {
        $data = array(
            'isq_servicio_area' =>  $this->input->post('isq_servicio_area'),
            'isq_turno' =>  $this->input->post('isq_turno'),
            'triage_id' =>  $this->input->post('triage_id'),
            'tratamiento_id' => $this->input->post('tratamiento_id')
        );
        if (empty($this->config_mdl->_get_data_condition('os_observacion_isq', array('tratamiento_id' =>  $this->input->post('tratamiento_id'))))) {
            $this->config_mdl->_insert('os_observacion_isq', $data);
        } else {
            $this->config_mdl->_update_data('os_observacion_isq', $data, array(
                'tratamiento_id' =>  $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion' => '1'));
    }
    public function HojaClasificacion($Paciente)
    {
        $sql['info'] = $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $Paciente
        ))[0];
        $this->load->view('Documentos/Doc_HojaClasificacion', $sql);
    }
    public function AjaxHojaClasificacion()
    {
        $triege_preg_puntaje_s1 = 0;
        $triege_preg_puntaje_s2 = $this->input->post('triage_preg1_s2') +
            $this->input->post('triage_preg2_s2') +
            $this->input->post('triage_preg3_s2') +
            $this->input->post('triage_preg4_s2') +
            $this->input->post('triage_preg5_s2') +
            $this->input->post('triage_preg6_s2') +
            $this->input->post('triage_preg7_s2') +
            $this->input->post('triage_preg8_s2') +
            $this->input->post('triage_preg9_s2') +
            $this->input->post('triage_preg10_s2') +
            $this->input->post('triage_preg11_s2') +
            $this->input->post('triage_preg12_s2');

        $triege_preg_puntaje_s3 = $this->input->post('triage_preg1_s3') +
            $this->input->post('triage_preg2_s3') +
            $this->input->post('triage_preg3_s3') +
            $this->input->post('triage_preg4_s3') +
            $this->input->post('triage_preg5_s3');
        $total_puntos = $triege_preg_puntaje_s1 + $triege_preg_puntaje_s2 + $triege_preg_puntaje_s3;
        if ($total_puntos > 30) {
            $color = '#E50914';
            $color_name = 'Rojo';
        }
        if ($total_puntos >= 21 && $total_puntos <= 30) {
            $color = '#FF7028';
            $color_name = 'Naranja';
        }
        if ($total_puntos >= 11 && $total_puntos <= 20) {
            $color = '#FDE910';
            $color_name = 'Amarillo';
        }
        if ($total_puntos >= 6 && $total_puntos <= 10) {
            $color = '#4CBB17';
            $color_name = 'Verde';
        }
        if ($total_puntos <= 5) {
            $color = '#0000FF';
            $color_name = 'Azul';
        }
        $data = array(
            'triage_via_registro' => 'Choque',
            'triage_fecha_clasifica' => date('Y-m-d'),
            'triage_hora_clasifica' => date('H:i'),
            'triage_status' => 'Finalizado',
            'triage_etapa' => '2',
            'triage_color' => $color_name,
            'triage_crea_enfemeria' => $this->UMAE_USER,
            'triage_crea_medico' => $this->UMAE_USER,
        );
        $data_clasificacion = array(
            'triage_preg1_s1' =>  0,
            'triage_preg2_s1' =>  0,
            'triage_preg3_s1' =>  0,
            'triage_preg4_s1' =>  0,
            'triage_preg5_s1' =>  0,
            'triege_preg_puntaje_s1' => $triege_preg_puntaje_s1,
            'triage_preg1_s2' =>  $this->input->post('triage_preg1_s2'),
            'triage_preg2_s2' =>  $this->input->post('triage_preg2_s2'),
            'triage_preg3_s2' =>  $this->input->post('triage_preg3_s2'),
            'triage_preg4_s2' =>  $this->input->post('triage_preg4_s2'),
            'triage_preg5_s2' =>  $this->input->post('triage_preg5_s2'),
            'triage_preg6_s2' =>  $this->input->post('triage_preg6_s2'),
            'triage_preg7_s2' =>  $this->input->post('triage_preg7_s2'),
            'triage_preg8_s2' =>  $this->input->post('triage_preg8_s2'),
            'triage_preg9_s2' =>  $this->input->post('triage_preg9_s2'),
            'triage_preg10_s2' => $this->input->post('triage_preg10_s2'),
            'triage_preg11_s2' => $this->input->post('triage_preg11_s2'),
            'triage_preg12_s2' => $this->input->post('triage_preg12_s2'),
            'triege_preg_puntaje_s2' => $triege_preg_puntaje_s2,
            'triage_preg1_s3' =>  $this->input->post('triage_preg1_s3'),
            'triage_preg2_s3' =>  $this->input->post('triage_preg2_s3'),
            'triage_preg3_s3' =>  $this->input->post('triage_preg3_s3'),
            'triage_preg4_s3' =>  $this->input->post('triage_preg4_s3'),
            'triage_preg5_s3' =>  $this->input->post('triage_preg5_s3'),
            'triege_preg_puntaje_s3' => $triege_preg_puntaje_s3,
            'triage_puntaje_total' => $total_puntos,
            'triage_color' => $color_name,
            'triage_id' => $this->input->post('triage_id')
        );
        $this->config_mdl->_update_data('os_triage', $data, array(
            'triage_id' =>  $this->input->post('triage_id')
        ));

        $this->config_mdl->_insert('os_triage_clasificacion', $data_clasificacion);
        Modules::run('Sections/Api/TriageMedico', $data_clasificacion);
        $this->AccesosUsuarios(array('acceso_tipo' => 'Triage Enfermería (Choque)', 'triage_id' => $this->input->post('triage_id'), 'areas_id' => $this->input->post('triage_id')));
        $this->AccesosUsuarios(array('acceso_tipo' => 'Triage Médico (Choque)', 'triage_id' => $this->input->post('triage_id'), 'areas_id' => $this->input->post('triage_id')));

        $this->setOutput(array('accion' => '1'));
    }

    /*NUEVAS FUNCIONES NOTAS CONSULTORIOS, OBSERVACIÓN, HOSPITALIZACION*/
    public function Notas($Nota)
    {
        $sql['info'] = $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $_GET['folio']
        ))[0];
        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $_GET['folio']
        ))[0];
        //$sql['Documentos']= $this->config_mdl->_query("SELECT * FROM pc_documentos WHERE doc_nombre!='Hoja Frontal'");


        $sql['SignosVitales'] = $this->config_mdl->sqlGetDataCondition('os_triage_signosvitales', array(
            'triage_id' => $_GET['folio'],
            'sv_tipo' => $_GET['inputVia']
        ))[0];
        $sql['Especialidades'] =  $this->config_mdl->sqlGetData('um_especialidades');

        $sql['Usuario'] = $this->config_mdl->_query("SELECT * FROM os_empleados WHERE empleado_id ='$this->UMAE_USER'");


        $sql['MedicosBase'] = $this->config_mdl->_query(
            "SELECT empleado_id, empleado_matricula,empleado_nombre, empleado_apellidos FROM os_empleados
                                                        WHERE empleado_roles != 77 AND empleado_servicio =
                                                          (SELECT empleado_servicio
                                                           FROM os_empleados
                                                           WHERE empleado_id = '$this->UMAE_USER')"
        );

        $sql['Medicamentos'] = $this->config_mdl->_query("SELECT medicamento_id,
                                                                 CONCAT(medicamento,' ',gramaje, ', ', forma_farmaceutica)medicamento,
                                                                 interaccion_amarilla,interaccion_roja
                                                          FROM catalogo_medicamentos
                                                          WHERE existencia = 1 ORDER BY medicamento");


        $sql['cama'] =  $this->config_mdl->_get_data_condition('os_camas', array(
            'triage_id' => $_GET['folio']
        ))[0];

        $sql['piso'] = $this->config_mdl->_query("SELECT piso_nombre_corto FROM os_pisos,os_pisos_camas WHERE 
            os_pisos.piso_id=os_pisos_camas.piso_id AND os_pisos_camas.cama_id='{$sql['cama']['cama_id']}'");



        $sql['Vias'] = array(
            '(cerebelomedular)', 'Auricular (ótica)', 'Bolo Intravenoso', 'Bucal', 'campo eléctrico', 'Conjuntival', 'Cutánea', 'Dental',
            'Electro-osmosis', 'En los ventrículos cerebrales', 'Endocervical', 'Endosinusial', 'Endotraqueal', 'Enteral', 'Epidural', 'Extra-amniótico',
            'Gastroenteral', 'Goteo Intravenoso', 'In vitro', 'Infiltración', 'Inhalatoria', 'Intercelular', 'Intersticial', 'Intra corpus cavernoso',
            'Intraamniótica', 'Intraarterial', 'Intraarticular', 'Intrabdominal', 'Intrabiliar', 'Intrabronquial', 'Intrabursal', 'Intracardiaca',
            'Intracartilaginoso', 'Intracaudal', 'Intracavernosa', 'Intracavitaria', 'Intracerebral', 'Intracervical', 'Intracisternal', 'Intracorneal',
            'Intracoronaria', 'Intracoronario', 'Intradérmica', 'Intradiscal', 'Intraductal', 'Intraduodenal', 'Intradural', 'Intraepidermal', 'Intraesofágica',
            'Intraesternal', 'Intragástrica ', 'Intragingival', 'Intrahepática', 'Intraileal', 'Intramedular', 'Intrameníngea', 'Intramuscular', 'Intraocular',
            'Intraovárica', 'Intrapericardial', 'Intraperitoneal', 'Intrapleural', 'Intraprostática', 'Intrapulmonar', 'Intrasinovial',
            'Intrasinusal (senosparanasales)', 'Intratecal', 'Intratendinosa', 'Intratesticular', 'Intratimpánica', 'Intratoráxica', 'Intratraqueal',
            'Intratubular', 'Intratumoral', 'Intrauterina', 'Intravascular', 'Intravenosa', 'Intraventricular', 'Intravesicular', 'Intravítrea', 'Iontoforesis',
            'Irrigación', 'la túnica fibrosa del ojo)', 'Laríngeo', 'Laringofaringeal', 'médula espinal)', 'Nasal', 'Oftálmica', 'Oral', 'Orofaríngea',
            'Otra Administración es diferente de otros contemplados en ésta lista', 'Parenteral', 'Párpados y la superficie del globo ocular',
            'Percutánea', 'Periarticular', 'Peridura', 'Perineural', 'Periodontal', 'Por difusión', 'Rectal', 'Retrobulbal', 'Sistémico', 'Sonda nasogástrica',
            'Subaracnoidea', 'Subconjuntival', 'Subcutánea', 'Sublingual', 'Submucosa', 'Técnica de vendaje oclusivo', 'Tejido blando', 'tejidos del cuerpo',
            'Tópica', 'Transdérmica', 'Transmamaria', 'Transmucosa', 'Transplacentaria', 'Transtimpánica', 'Transtraqueal', 'Ureteral', 'Uretral',
            'Uso Intralesional', 'Uso Intralinfático', 'Uso oromucosa', 'Vaginal', 'Vía a través de Hemodiálisis'
        );

        $sql['MedicosBaseNota'] = $this->config_mdl->_query("SELECT empleado_nombre,empleado_apellidos,empleado_matricula
                                                             FROM os_empleados
                                                             WHERE empleado_id = (
                                                               SELECT notas_medicotratante FROM doc_notas WHERE notas_id = $Nota)");
        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT *
                                                          FROM prescripcion INNER JOIN catalogo_medicamentos ON
                                                          prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                          INNER JOIN os_triage ON prescripcion.triage_id = os_triage.triage_id
                                                          WHERE os_triage.triage_id =" . $_GET['folio']);

        $sql['Prescripciones_activas'] = $this->config_mdl->_query("SELECT COUNT(prescripcion_id)activas FROM prescripcion WHERE estado != 0
                                                                    AND STR_TO_DATE(fecha_fin,'%d/%m/%Y') >= CURDATE() AND triage_id = " . $_GET['folio']);

        $sql['Prescripciones_pendientes'] = $this->config_mdl->_query("SELECT COUNT(prescripcion_id)pendientes FROM prescripcion WHERE estado = 1 AND triage_id = " . $_GET['folio']);

        $sql['Prescripciones_canceladas'] = $this->config_mdl->_query("SELECT prescripcion.prescripcion_id
                                                                      FROM prescripcion
                                                                      INNER JOIN catalogo_medicamentos ON
                                                                      prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                      INNER JOIN os_triage ON
                                                                      prescripcion.triage_id = os_triage.triage_id
                                                                      INNER JOIN btcr_prescripcion ON
                                                                      prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                                                      WHERE os_triage.triage_id =" . $_GET['folio'] . " GROUP BY prescripcion_id");

        $sql['Notificaciones'] = $this->config_mdl->_query("SELECT notificacion_id
                                                          FROM um_notificaciones_prescripciones
                                                          INNER JOIN prescripcion
                                                            ON um_notificaciones_prescripciones.prescripcion_id = prescripcion.prescripcion_id
                                                          INNER JOIN catalogo_medicamentos
                                                            ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                          INNER JOIN os_empleados
                                                            ON os_empleados.empleado_id = um_notificaciones_prescripciones.empleado_id
                                                          WHERE triage_id =" . $_GET['folio']);



        $sql['signosVitalesNota'] = $this->config_mdl->_get_data_condition('os_triage_signosvitales', array(
            'triage_id' => $_GET['folio'],
            'nota_id'   => $this->uri->segment(4)
        ))[0];


        $sql['UltimosSignosVitales'] = $this->config_mdl->_query("SELECT sv_tipo,CONCAT(sv_fecha,' ',sv_hora) AS fecha,sv_ta,sv_temp,sv_fc,sv_fr,sv_oximetria,sv_talla,sv_dextrostix,sv_peso FROM os_triage_signosvitales
                                                                      WHERE triage_id = " . $_GET['folio'] . " AND
                                                                            sv_tipo = 'Consultorios'
                                                                      ORDER BY fecha DESC");
        //En caso de no existir una nota con signos vitales, se toman de la hoja frontal
        if (COUNT($sql['UltimosSignosVitales']) == 0) {
            $sql['UltimosSignosVitales'] = $this->config_mdl->_query("SELECT sv_tipo,CONCAT(sv_fecha,' ',sv_hora) AS fecha,sv_ta,sv_temp,sv_fc,sv_fr,sv_oximetria,sv_talla,sv_dextrostix,sv_peso
                                                                        FROM os_triage_signosvitales
                                                                        WHERE triage_id = " . $_GET['folio'] . " 
                                                                        ORDER BY fecha DESC");
        }

        $sql['ReaccionesAdversas'] = $this->config_mdl->_get_data_condition('um_ram', array('triage_id' => $_GET['folio']));
        $sql['AlergiaMedicamentos'] = $this->config_mdl->_query("SELECT medicamento FROM um_alergias_medicamentos
                                          INNER JOIN catalogo_medicamentos
                                            ON um_alergias_medicamentos.medicamento_id = catalogo_medicamentos.medicamento_id
                                          WHERE triage_id = " . $_GET['folio']);

        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT diagnostico_id, complemento, triage_id, (paciente_diagnosticos.cie10_id)cie10_id1, tipo_diagnostico, (um_cie10.cie10_id)cie10_id2, cie10_clave, cie10_nombre, fecha_dx
                                                         FROM paciente_diagnosticos
                                                         INNER JOIN um_cie10
                                                             ON paciente_diagnosticos.cie10_id = um_cie10.cie10_id
                                                         WHERE triage_id = " . $_GET['folio']);

        $sql['DiagnosticoPaciente'] = $this->config_mdl->_query("SELECT diagnostico_id, triage_id, (paciente_diagnosticos.cie10_id)cie10_id1, tipo_diagnostico, (um_cie10.cie10_id)cie10_id2, cie10_clave, cie10_nombre, complemento
                                                                FROM paciente_diagnosticos
                                                                INNER JOIN um_cie10
                                                                    ON paciente_diagnosticos.cie10_id = um_cie10.cie10_id
                                                                WHERE triage_id = " . $_GET['folio'] . " AND tipo_diagnostico = 1;");
        // $sql['Interconsultas'] = $this->config_mdl->_query("SELECT doc_estatus, doc_fecha, doc_hora, especialidad_nombre 
        //     FROM doc_430200 INNER JOIN um_especialidades ON
        //     doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
        //     WHERE doc_430200.triage_id=".$_GET['folio']);

        $sql['Interconsultas'] = $this->config_mdl->sqlGetDataCondition('doc_430200', array(
            'triage_id'   => $_GET['folio'],
            'doc_nota_id' => $Nota
        ));

        // $sql['Interconsultas'] = $this->config_mdl->_query("SELECT * FROM interconsulta_notas
        //                                                     INNER JOIN doc_430200
        //                                                         ON doc_430200.doc_id = interconsulta_notas.doc_id
        //                                                     WHERE notas_id = '".$Notas."' AND
        //                                                     triage_id = '".$_GET['folio']."' ");

        $sql['Procedimientos'] = $this->config_mdl->_query("SELECT * FROM um_procedimientos ORDER BY nombre");

        //---------------laboratorio----------///
        $sql['um_catalogo_laboratorio_area'] = $this->config_mdl->_query("SELECT DISTINCT area FROM um_catalogolaboratorio");

        $sql['um_catalogo_laboratorio'] = $this->config_mdl->_query("SELECT * FROM um_catalogolaboratorio");

        foreach ($sql['um_catalogo_laboratorio_area'] as $area) {
            $tipos[$area['area']] = $this->config_mdl->_query("SELECT DISTINCT tipo FROM um_catalogolaboratorio WHERE area = '" . $area['area'] . "'");
        }

        $sql['um_catalogo_laboratorio_tipos'] = $tipos;

        $sql['um_estudios_obj'] = $this->config_mdl->_query("SELECT * FROM um_solicitud_laboratorio WHERE input_via = '" . $_GET['inputVia'] . "' AND tipo_nota='" . $_GET['TipoNota'] . "' AND nota_id= '" . $Nota . "'" . " AND triage_id = '" . $_GET['folio'] . "'");


        //---------------laboratorio----------///

        if ($_GET['TipoNota'] == 'Nota de Egreso') {
            $sql['NotaEgreso'] = $this->config_mdl->_query("SELECT * FROM doc_notas, doc_nota_egreso WHERE
            doc_notas.notas_id=doc_nota_egreso.nota_id AND
            doc_notas.notas_id=" . $Nota)[0];

            $sql['Residentes'] = $this->config_mdl->sqlGetDataCondition('um_notas_residentes', array(
                'notas_id' => $sql['NotaEgreso']['nota_id']
            ));

            $this->load->view('Documentos/Doc_Nota_Egreso', $sql);
        } else if ($_GET['TipoNota'] == 'Nota de Evolución') {
            $sql['Nota'] = $this->config_mdl->_query("SELECT * FROM doc_notas, doc_nota WHERE
            doc_notas.notas_id=doc_nota.notas_id AND
            doc_notas.notas_id=" . $Nota)[0];

            $sql['Residentes'] = $this->config_mdl->sqlGetDataCondition('um_notas_residentes', array(
                'notas_id' => $sql['Nota']['notas_id']
            ));

            $sql['medicoTratante'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array('empleado_id' => $sql['Nota']['notas_medicotratante']))[0];

            $this->load->view('Documentos/Nota_Header', $sql);
            $this->load->view('Documentos/Doc_Notas', $sql);
        } else if ($_GET['TipoNota'] == 'Nota de Procedimientos') {
            $sql['NotaProcedimiento'] = $this->config_mdl->_query("SELECT * FROM doc_notas, um_notas_procedimientos WHERE 
                doc_notas.notas_id = um_notas_procedimientos.notas_id AND doc_notas.notas_id=" . $Nota)[0];

            $sql['medicoTratante'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array('empleado_id' => $sql['NotaProcedimiento']['notas_medicotratante']))[0];

            $sql['Residentes'] = $this->config_mdl->sqlGetDataCondition('um_notas_residentes', array(
                'notas_id' => $sql['NotaProcedimiento']['notas_id']
            ));

            $this->load->view('Documentos/Nota_Header', $sql);
            $this->load->view('Documentos/Nota_Procedimientos', $sql);
        } else if ($_GET['TipoNota'] == 'Nota de Indicaciones') {
            $sql['NotaIndicaciones'] = $this->config_mdl->_query("SELECT * FROM doc_notas, um_notas_indicaciones WHERE 
                doc_notas.notas_id = um_notas_indicaciones.notas_id AND doc_notas.notas_id=" . $Nota)[0];
            $this->load->view('Documentos/Nota_Indicaciones', $sql);
        } else if ($_GET['TipoNota'] == 'Nota de Alta') {
            $sql['NotaAlta'] = $this->config_mdl->_query("SELECT
                            *
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
            $sql['medicoTratante'] = $this->config_mdl->sqlGetDataCondition('os_empleados', array('empleado_id' => $sql['NotaAlta']['notas_medicotratante']))[0];
            $sql['Residentes'] = $this->config_mdl->sqlGetDataCondition('um_notas_residentes', array(
                'notas_id' => $sql['NotaAlta']['nota_id']
            ));

            $this->load->view('Documentos/Nota_Header', $sql);
            $this->load->view('Documentos/Nota_Alta', $sql);
        } else if ($_GET['TipoNota'] == 'Nota de Interconsulta') {
            $this->load->view('Documentos/Nota_Header', $sql);
            $this->load->view('Documentos/Doc_Notas', $sql);
        }
    }

    /* Guardar Nota de Evolución */
    public function AjaxNotas()
    {
        $id_nota = '';
        $sql['empleado'] = $this->config_mdl->_query("SELECT empleado_id, empleado_servicio
                                                        FROM os_empleados WHERE empleado_id = $this->UMAE_USER");

        foreach ($this->input->post('nota_interconsulta') as $interconsulta_select) {
            $interconsulta .= $interconsulta_select . ',';
        }

        $matricula = $this->input->post('medicoMatricula');
        $sql['medicoBaseId'] = $this->config_mdl->_query("SELECT empleado_id, empleado_servicio, empleado_roles
                                                         FROM os_empleados WHERE empleado_matricula = '$matricula'");
        if (empty($sql['medicoBaseId'])) { // Si es un médico de base qioe realiza la nota no selecciona otro
            $medicoTratante = $this->UMAE_USER;
        } else {
            $medicoTratante = $sql['medicoBaseId'][0]['empleado_id'];
        }

        $dataNotas = array(
            'notas_fecha'           => date('d-m-Y'), //date('Y-m-d')
            'notas_hora'            => date('H:i'),
            'notas_tipo'            => $this->input->post('tipo_nota'),
            'notas_via'             => $this->input->post('via'),
            'notas_area'            => $this->UMAE_AREA,
            'empleado_id'           => $this->UMAE_USER,
            'empleado_servicio_id'  => $sql['empleado'][0]['empleado_servicio'],
            'notas_medicotratante'  => $medicoTratante,
            'triage_id'             => $this->input->post('triage_id')
        );

        // Se toman los valores del formulario 'Instrucciones de nutricion'
        $nota_nutricion = "";
        $radio_nutricion = $this->input->post('dieta');
        $select_nutricion = $this->input->post('tipoDieta');
        $otros_nutricion = $this->input->post('otraDieta');
        /* las siguiendes condiciones son para indexar el campo 'nota_nutricion'
          de esta forma se conoce el origen del dato.*/

        //Indica que el valor viene de una caja de texto
        if ($otros_nutricion != "" & $select_nutricion == 13) {
            $nota_nutricion = $otros_nutricion;
            // Indica que el valor viene de un select
        } else if ($select_nutricion >= 1 || $select_nutricion <= 12) {
            $nota_nutricion = $select_nutricion;
            // Indica que el valor viene de un radio
        } else if ($radio_nutricion == 0) {
            $nota_nutricion = $radio_nutricion;
        }

        $select_signos = $this->input->post("tomaSignos");
        $otros_signos = $this->input->post("otrasIndicacionesSignos");
        $nota_svycuidados = $select_signos;
        if ($select_signos == "3") {
            $nota_svycuidados = $otros_signos;
        }

        $nota_cgenfermeria = 1;
        if ($this->input->post("nota_cgenfermeria") != 1) {
            $nota_cgenfermeria = 0;
        }

        foreach ($this->input->post('procedimientos') as $procedimientos_select) {
            $procedimientos .= $procedimientos_select . ',';
        }
        /**
         *  Si es una nota nueva
         */
        if ($this->input->post('accion') == 'add') {

            $last_id_notas = $this->config_mdl->_insert('doc_notas', $dataNotas);
            if ($last_id_notas) $last_id_notas = $this->db->insert_id();

            $id_nota = $this->config_mdl->_get_last_id('doc_notas', 'notas_id');

            for ($i = 0; $i < count($this->input->post('nombre_residente')); $i++) {
                $datosResidente = array(
                    'notas_id'           => $this->config_mdl->_get_last_id('doc_notas', 'notas_id'),
                    'nombre_residente'   => $this->input->post("nombre_residente[$i]"),
                    'apellido_residente' => $this->input->post("apellido_residente[$i]"),
                    'cedulap_residente'  => $this->input->post("cedula_residente[$i]"),
                    'grado'              => $this->input->post("grado[$i]")
                );

                if (count($datosResidente) > 0) {
                    $this->config_mdl->_insert('um_notas_residentes', $datosResidente);
                }
            }

            //Consultar los diagnosticos y registrarlos en la nota para generar el historial

            $consulta = "SELECT diagnostico_id, tipo_diagnostico, cie10_id
                       FROM paciente_diagnosticos
                       WHERE triage_id = " . $this->input->post('triage_id');
            $sqlResult = $this->config_mdl->_query($consulta);

            for ($x = 0; $x < COUNT($sqlResult); $x++) {
                $this->config_mdl->_insert('diagnostico_notas', array(
                    'notas_id' => $this->config_mdl->_get_last_id('doc_notas', 'notas_id'),
                    'diagnostico_id' => $sqlResult[$x]['diagnostico_id'],
                    'tipo_diagnostico' => $sqlResult[$x]['tipo_diagnostico'],
                    'cie10_id' => $sqlResult[$x]['cie10_id']
                ));
            }


            for ($x = 0; $x < count($this->input->post('nota_interconsulta')); $x++) {
                $existencia_interconsuta = $this->config_mdl->_query(
                    "SELECT doc_id
              FROM doc_430200
              WHERE doc_servicio_solicitado = " . $this->input->post("nota_interconsulta[$x]")
                );

                $this->config_mdl->_update_data('os_consultorios_especialidad', array(
                    'ce_status' => 'Interconsulta',
                    'ce_interconsulta' => 'Si'
                ), array(
                    'triage_id' =>  $this->input->post('triage_id')
                ));

                $datos_interconsulta = array(
                    'doc_estatus' => 'En Espera',
                    'doc_fecha' => date('Y-m-d'),
                    'doc_hora' => date('H:i'),
                    'doc_area' => $this->UMAE_AREA,
                    'doc_servicio_envia' => Modules::run('Consultorios/ObtenerEspecialidadID', array('Consultorio' => $this->UMAE_AREA)),
                    'doc_servicio_solicitado' => $this->input->post("nota_interconsulta[$x]"),
                    'triage_id' => $this->input->post('triage_id'),
                    'doc_modulo' => $this->input->post('inputVia'),
                    'motivo_interconsulta' => $this->input->post('motivo_interconsulta'),
                    'doc_nota_id' => $this->config_mdl->_get_last_id('doc_notas', 'notas_id'),
                    'empleado_envia' => $this->UMAE_USER
                );
                $this->config_mdl->_insert('doc_430200', $datos_interconsulta);
            }

            /*
          Se consultan las interconsultas realizadas en el momento en que se genero
          la nota medica
          */
            $Interconsultas = $this->config_mdl->sqlGetDataCondition('doc_430200', array(
                'triage_id'   => $this->input->post('triage_id'),
                'doc_nota_id' => $this->config_mdl->_get_last_id('doc_notas', 'notas_id')
            ));

            // $Interconsultas = $this->config_mdl->_query("SELECT doc_id FROM doc_430200
            //                                             WHERE triage_id = ".$this->input->post('triage_id'));
            for ($x = 0; $x < count($Interconsultas); $x++) {
                $datos = array(
                    'notas_id' => $this->config_mdl->_get_last_id('doc_notas', 'notas_id'),
                    'doc_id' => $Interconsultas[$x]['doc_id']
                );
                $this->config_mdl->_insert('interconsulta_notas', $datos);
            }

            $sqlMax = $this->config_mdl->_get_last_id('doc_notas', 'notas_id');

            $this->config_mdl->_insert('doc_nota', array(
                //'nota_motivoInterconsulta' => $this->input->post('nota_motivoInterconsulta'),
                'nota_interrogatorio'       =>  $this->input->post('nota_interrogatorio'),
                'nota_exploracionf'         =>  $this->input->post('nota_exploracionf'),
                'nota_escala_glasgow'       =>  $this->input->post('nota_escala_glasgow'),
                'hf_riesgo_caida'           =>  $this->input->post('hf_riesgo_caida'),
                'nota_eva'                  =>  $this->input->post('nota_eva'),
                'nota_riesgotrombosis'      =>  $this->input->post('nota_riesgotrombosis'),
                'nota_auxiliaresd'          =>  $this->input->post('nota_auxiliaresd'),
                'nota_procedimientos'       =>  trim($procedimientos, ','),
                'nota_pronosticos'          =>  $this->input->post('nota_pronosticos'),
                'nota_estadosalud'          =>  $this->input->post('nota_estadosalud'),
                'nota_nutricion'            =>  $nota_nutricion,
                'nota_svycuidados'          =>  $nota_svycuidados,
                'nota_cgenfermeria'         =>  $nota_cgenfermeria,
                'nota_cuidadosenfermeria'   =>  $this->input->post('nota_cuidadosenfermeria'),
                'nota_solucionesp'          =>  $this->input->post('nota_solucionesp'),
                'nota_medicamentos'         =>  $this->input->post('nota_medicamentos'),
                'nota_problema'             =>  $this->input->post('nota_problema'),
                'nota_analisis'             =>  $this->input->post('nota_analisis'),
                'nota_interconsulta'        =>  trim($interconsulta, ','),
                'nota_solicitud_laboratorio' =>  $this->input->post('nota_solicitud_laboratorio'),
                'notas_id'                  =>  $sqlMax
            ));

            /*Inicio registro prescripcion*/
            $fecha_actual = date('d-m-Y');
            // Numero de prescripciones ingresadas, almacena en arreglo y registra en la
            // tabla "prescripcio"
            for ($x = 0; $x < count($this->input->post('idMedicamento')); $x++) {
                $observacion = $this->input->post("observacion[$x]");
                $otroMedicamento = $this->input->post("nomMedicamento[$x]");
                if ($this->input->post("idMedicamento[$x]") == '1') {
                    $observacion = $otroMedicamento . '-' . $observacion;
                }
                $datosPrescripcion = array(
                    'empleado_id' => $this->UMAE_USER,
                    'triage_id' => $this->input->post('triage_id'),
                    'medicamento_id' => $this->input->post("idMedicamento[$x]"),
                    'dosis' => $this->input->post("dosis[$x]"),
                    'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                    'via' => $this->input->post("via_admi[$x]"),
                    'frecuencia' => $this->input->post("frecuencia[$x]"),
                    'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                    'tiempo' => $this->input->post("duracion[$x]"),
                    'periodo' => $this->input->post("periodo[$x]"),
                    'fecha_fin' => $this->input->post("fechaFin[$x]"),
                    'observacion' => $observacion,
                    'estado' => "1"
                );
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
            }
            //Número de antibioticos apt
            for ($x = 0; $x < count($this->input->post('idMedicamento_npt')); $x++) {
                //Se guardan en un arreglo los datos del medicamento
                $datosPrescripcion = array(
                    'empleado_id' => $this->UMAE_USER,
                    'triage_id' => $this->input->post('triage_id'),
                    'medicamento_id' => $this->input->post("idMedicamento_npt[$x]"),
                    'via' => $this->input->post("via_admi[$x]"),
                    'fecha_prescripcion' => $fecha_actual,
                    'dosis' => $this->input->post("dosis[$x]"),
                    'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                    // 'via' => $this->input->post("viaAdmon[$x]"),
                    'frecuencia' => $this->input->post("frecuencia[$x]"),
                    'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                    'tiempo' => $this->input->post("duracion[$x]"),
                    'periodo' => $this->input->post("periodo[$x]"),
                    'fecha_fin' => $this->input->post("fechaFin[$x]"),
                    'observacion' => $this->input->post("observacion[$x]"),
                    'estado' => "1"
                );
                //Se registra el medicamento
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                //Se consulta la ultima prescripcion registrada
                $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                /*
              Se toman los datos necesarios para un npt
              con la variable $ultima_prescripcion, identificamos la prescripcion con la que se
              asocia prescripcion y npt
              */
                $datos_npt = array(
                    'prescripcion_id' => $ultima_prescripcion,
                    'aminoacido' => $this->input->post("aminoacido[$x]"),
                    'dextrosa' => $this->input->post("dextrosa[$x]"),
                    'lipidos' => $this->input->post("lipidos_intravenosos[$x]"),
                    'agua_inyect' => $this->input->post("agua_inyectable[$x]"),
                    'cloruro_sodio' => $this->input->post("cloruro_sodio[$x]"),
                    'sulfato' => $this->input->post("sulfato_magnesio[$x]"),
                    'cloruro_potasio' => $this->input->post("cloruro_potasio[$x]"),
                    'fosfato' => $this->input->post("fosfato_potasio[$x]"),
                    'gluconato' => $this->input->post("gluconato_calcio[$x]"),
                    'albumina' => $this->input->post("albumina[$x]"),
                    'heparina' => $this->input->post("heparina[$x]"),
                    'insulina' => $this->input->post("insulina_humana[$x]"),
                    'zinc' => $this->input->post("zinc[$x]"),
                    'mvi' => $this->input->post("mvi_adulto[$x]"),
                    'oligoelementos' => $this->input->post("oligoelementos[$x]"),
                    'vitamina' => $this->input->post("vitamina[$x]")
                );
                $this->config_mdl->_insert('prescripcion_npt', $datos_npt);
            }
            //Número de antibioticos antimicrobiano u oncologico
            for ($x = 0; $x < count($this->input->post('idMedicamento_onco_antimicro')); $x++) {
                $datosPrescripcion = array(
                    'empleado_id' => $this->UMAE_USER,
                    'triage_id' => $this->input->post('triage_id'),
                    'medicamento_id' => $this->input->post("idMedicamento_onco_antimicro[$x]"),
                    'dosis' => $this->input->post("dosis[$x]"),
                    'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                    'via' => $this->input->post("via[$x]"),
                    'frecuencia' => $this->input->post("frecuencia[$x]"),
                    'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                    'tiempo' => $this->input->post("duracion[$x]"),
                    'periodo' => $this->input->post("periodo[$x]"),
                    'fecha_fin' => $this->input->post("fechaFin[$x]"),
                    'observacion' => $this->input->post("observacion[$x]"),
                    'estado' => "1"
                );
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                $categoria_safe = $this->input->post("categoria_safe[$x]");
                $datos_onco_antimicrobiano = array(
                    'prescripcion_id' => $ultima_prescripcion,
                    'categoria_safe' => $categoria_safe,
                    'diluente' => $this->input->post("diluyente[$x]"),
                    'vol_dilucion' => $this->input->post("vol_diluyente[$x]")
                );
                $this->config_mdl->_insert('prescripcion_onco_antimicrobianos', $datos_onco_antimicrobiano);
            }
            // Se toma el ID de las precripcines activas
            $Prescripciones = $this->config_mdl->_query("SELECT prescripcion_id
                                                         FROM prescripcion
                                                         WHERE estado = 1 and triage_id = " . $this->input->post('triage_id') . ";");
            for ($x = 0; $x < count($Prescripciones); $x++) {
                $NotaPrescripcion = array(
                    'notas_id' => $this->config_mdl->_get_last_id('doc_notas', 'notas_id'),
                    'prescripcion_id' => $Prescripciones[$x]['prescripcion_id']
                );
                // Se registra la relacion entre notas y prescripcion
                $this->config_mdl->_insert('nm_notas_prescripcion', $NotaPrescripcion);
            }
            /*Fin registro prescripcion*/
            $MaxNota = $sqlMax;

            $dataSV = array(
                'sv_tipo'       => $this->input->post('inputVia'),
                'sv_fecha'      => date('Y-m-d'),
                'sv_hora'       => date('H:i:s'),
                'sv_ta'         => $this->input->post('sv_ta'),
                'sv_temp'       => $this->input->post('sv_temp'),
                'sv_fc'         => $this->input->post('sv_fc'),
                'sv_fr'         => $this->input->post('sv_fr'),
                'sv_oximetria'  => $this->input->post('sv_oximetria'),
                'sv_dextrostix' => $this->input->post('sv_dextrostix'),
                'sv_peso'       => $this->input->post('sv_peso'),
                'sv_talla'      => $this->input->post('sv_talla'),
                'triage_id'     => $this->input->post('triage_id'),
                'empleado_id'   => $this->UMAE_USER,
                'nota_id'       => $this->config_mdl->_get_last_id('doc_notas', 'notas_id')
            );
            //if($this->input->post('sv_ta') == '' || $this->input->post('sv_temp') == '' || $this->input->post('sv_fc') == '') 
            $this->config_mdl->_insert('os_triage_signosvitales', $dataSV);
        } else {
            unset($data['notas_hora']);
            unset($data['notas_fecha']);
            unset($data['empleado_id']);
            unset($data['empleado_servicio_id']);
            unset($data['notas_via']);
            $this->config_mdl->_update_data('doc_notas', array(
                'notas_medicotratante'  => $medicoTratante,
            ), array(
                'notas_id'  => $this->input->post('notas_id')
            ));
            $id_nota = $this->input->post('notas_id');
            $this->config_mdl->_update_data('doc_nota', array(
                'nota_motivoInterconsulta'  => $this->input->post('nota_motivoInterconsulta'),
                'nota_interrogatorio'       => $this->input->post('nota_interrogatorio'),
                'nota_exploracionf'         => $this->input->post('nota_exploracionf'),
                'nota_escala_glasgow'       => $this->input->post('hf_escala_glasgow'),
                'hf_riesgo_caida'           => $this->input->post('hf_riesgo_caida'),
                'nota_eva'                  => $this->input->post('nota_eva'),
                'nota_riesgotrombosis'      => $this->input->post('nota_riesgotrombosis'),
                'nota_auxiliaresd'          => $this->input->post('nota_auxiliaresd'),
                'nota_procedimientos'       => trim($procedimientos, ','),
                'nota_pronosticos'          => $this->input->post('nota_pronosticos'),
                'nota_estadosalud'          => $this->input->post('nota_estadosalud'),
                'nota_nutricion'            => $nota_nutricion,
                'nota_svycuidados'          => $nota_svycuidados,
                'nota_cgenfermeria'         => $nota_cgenfermeria,
                'nota_cuidadosenfermeria'   => $this->input->post('nota_cuidadosenfermeria'),
                'nota_solucionesp'          => $this->input->post('nota_solucionesp'),
                'nota_medicamentos'         => $this->input->post('nota_medicamentos'),
                'nota_problema'             => $this->input->post('nota_problema'),
                'nota_analisis'             => $this->input->post('nota_analisis'),
                'nota_interconsulta'        => trim($interconsulta, ',')
            ), array(
                'notas_id' => $this->input->post('notas_id')
            ));

            /* Actualizacion de Medicos residentes */
            // for($i = 0; $i < count($this->input->post('nombre_residente')); $i++){
            //     $datosResidente = array(
            //         'nombre_residente'   => $this->input->post("nombre_residente[$i]"),
            //         'apellido_residente' => $this->input->post("apellido_residente[$i]"),
            //         'cedulap_residente'  => $this->input->post("cedula_residente[$i]")
            //     );

            //         $this->config_mdl->_update_data('um_notas_residentes',$datosResidente, array('notas_id'=> $this->input->post('notas_id')));

            // }
            $MaxNota = $this->input->post('notas_id');
            /*Inicio registro prescripcion*/
            $fecha_actual = date('d-m-Y');
            // Numero de prescripciones ingresadas, almacena en arreglo y registra en la
            // tabla "prescripcio"
            for ($x = 0; $x < count($this->input->post('idMedicamento')); $x++) {
                $observacion = $this->input->post("observacion[$x]");
                $otroMedicamento = $this->input->post("nomMedicamento[$x]");
                if ($this->input->post("idMedicamento[$x]") == '1') {
                    $observacion = $otroMedicamento . '-' . $observacion;
                }
                $datosPrescripcion = array(
                    'empleado_id'         => $this->UMAE_USER,
                    'triage_id'           => $this->input->post('triage_id'),
                    'medicamento_id'      => $this->input->post("idMedicamento[$x]"),
                    'via'                 => $this->input->post("via_admi[$x]"),
                    'fecha_prescripcion'  => $fecha_actual,
                    'dosis'               => $this->input->post("dosis[$x]"),
                    'frecuencia'          => $this->input->post("frecuencia[$x]"),
                    'aplicacion'          => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio'        => $this->input->post("fechaInicio[$x]"),
                    'tiempo'              => $this->input->post("duracion[$x]"),
                    'periodo'             => $this->input->post("periodo[$x]"),
                    'fecha_fin'           => $this->input->post("fechaFin[$x]"),
                    'observacion'         => $observacion,
                    'estado'              => "1"
                );
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
            }
            //Número de antibioticos apt
            for ($x = 0; $x < count($this->input->post('idMedicamento_npt')); $x++) {
                //Se guardan en un arreglo los datos del medicamento
                $datosPrescripcion = array(
                    'empleado_id'         => $this->UMAE_USER,
                    'triage_id'           => $this->input->post('triage_id'),
                    'medicamento_id'      => $this->input->post("idMedicamento_npt[$x]"),
                    'via'                 => $this->input->post("via_admi[$x]"),
                    'fecha_prescripcion'  => $fecha_actual,
                    'dosis'               => $this->input->post("dosis[$x]"),
                    'frecuencia'          => $this->input->post("frecuencia[$x]"),
                    'aplicacion'          => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio'        => $this->input->post("fechaInicio[$x]"),
                    'tiempo'              => $this->input->post("duracion[$x]"),
                    'periodo'             => $this->input->post("periodo[$x]"),
                    'fecha_fin'           => $this->input->post("fechaFin[$x]"),
                    'observacion'         => $this->input->post("observacion[$x]"),
                    'estado'              => "1"
                );
                //Se registra el medicamento
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                //Se consulta la ultima prescripcion registrada
                $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                /*
                Se toman los datos necesarios para un npt
                con la variable $ultima_prescripcion, identificamos la prescripcion con la que se
                asocia prescripcion y npt
                */
                $datos_npt = array(
                    'prescripcion_id' => $ultima_prescripcion,
                    'aminoacido' => $this->input->post("aminoacido[$x]"),
                    'dextrosa' => $this->input->post("dextrosa[$x]"),
                    'lipidos' => $this->input->post("lipidos_intravenosos[$x]"),
                    'agua_inyect' => $this->input->post("agua_inyectable[$x]"),
                    'cloruro_sodio' => $this->input->post("cloruro_sodio[$x]"),
                    'sulfato' => $this->input->post("sulfato_magnesio[$x]"),
                    'cloruro_potasio' => $this->input->post("cloruro_potasio[$x]"),
                    'fosfato' => $this->input->post("fosfato_potasio[$x]"),
                    'gluconato' => $this->input->post("gluconato_calcio[$x]"),
                    'albumina' => $this->input->post("albumina[$x]"),
                    'heparina' => $this->input->post("heparina[$x]"),
                    'insulina' => $this->input->post("insulina_humana[$x]"),
                    'zinc' => $this->input->post("zinc[$x]"),
                    'mvi' => $this->input->post("mvi_adulto[$x]"),
                    'oligoelementos' => $this->input->post("oligoelementos[$x]"),
                    'vitamina' => $this->input->post("vitamina[$x]")
                );
                $this->config_mdl->_insert('prescripcion_npt', $datos_npt);
            }
            //Número de antibioticos antimicrobiano u oncologico
            for ($x = 0; $x < count($this->input->post('idMedicamento_onco_antimicro')); $x++) {
                $datosPrescripcion = array(
                    'empleado_id' => $this->UMAE_USER,
                    'triage_id' => $this->input->post('triage_id'),
                    'medicamento_id' => $this->input->post("idMedicamento_onco_antimicro[$x]"),
                    'dosis' => $this->input->post("dosis[$x]"),
                    'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                    'via' => $this->input->post("via_admi[$x]"),
                    'frecuencia' => $this->input->post("frecuencia[$x]"),
                    'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                    'tiempo' => $this->input->post("duracion[$x]"),
                    'periodo' => $this->input->post("periodo[$x]"),
                    'fecha_fin' => $this->input->post("fechaFin[$x]"),
                    'observacion' => $this->input->post("observacion[$x]"),
                    'estado' => "1"
                );
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                $categoria_safe = $this->input->post("categoria_safe[$x]");
                $datos_onco_antimicrobiano = array(
                    'prescripcion_id' => $ultima_prescripcion,
                    'categoria_safe' => $categoria_safe,
                    'diluente' => $this->input->post("diluyente[$x]"),
                    'vol_dilucion' => $this->input->post("vol_diluyente[$x]")
                );
                $this->config_mdl->_insert('prescripcion_onco_antimicrobianos', $datos_onco_antimicrobiano);
            }
            // Se toma el ID de las precripcines activas
            $Prescripciones = $this->config_mdl->_query("SELECT prescripcion_id
                                                           FROM prescripcion
                                                           WHERE estado != 0 and triage_id = " . $this->input->post('triage_id'));

            $this->config_mdl->_delete_data('nm_notas_prescripcion', array('notas_id' => $this->input->post('notas_id')));
            for ($x = 0; $x < count($Prescripciones); $x++) {
                $NotaPrescripcion = array(
                    'notas_id' => $this->config_mdl->_get_last_id('doc_notas', 'notas_id'),
                    'prescripcion_id' => $Prescripciones[$x]['prescripcion_id']
                );
                // Se registra la relacion entre notas y prescripcion
                $this->config_mdl->_insert('nm_notas_prescripcion', $NotaPrescripcion);
            }
            /*Fin registro prescripcion*/
        }
        if ($this->input->post('via') == 'Interconsulta') {
            $this->config_mdl->_update_data('doc_430200', array(
                'doc_estatus' => 'Evaluado',
                'doc_fecha_r' => date('Y-m-d'),
                'doc_hora_r' => date('H:i:s'),
                'doc_nota_id' => $MaxNota,
                'empleado_recive' => $this->UMAE_USER
            ), array(
                'doc_id' => $this->input->post('doc_id')
            ));
        }
        /*$sqlCheck= $this->config_mdl->sqlGetDataCondition('os_triage_signosvitales',array(
            'triage_id'=>$this->input->post('triage_id'),
            'sv_tipo'=> $this->input->post('inputVia')
        ),'sv_id');*/

        //-----------------actualisacion de estado_salud en os_camas-------//

        $os_camas = $this->config_mdl->_query("SELECT * FROM os_camas WHERE  area_id = 1 AND triage_id =" . $this->input->post('triage_id') . ";");
        if (!empty($os_camas)) {
            $estado_salud = array("estado_salud" => $this->input->post('nota_estadosalud'));
            $this->config_mdl->_update_data('os_camas', $estado_salud, array('triage_id' => $this->input->post('triage_id')));
        }


        $this->setOutput(array('accion' => '1', 'notas_id' => $id_nota));


        //-----------------solicitud_laboratorio_nota_evolución------------//

        if ($last_id_notas && $this->input->post('accion') == 'add') {
            $nota_id = $last_id_notas;
        } else {
            $nota_id = $this->input->post('notas_id');
        }

        if ($nota_id != "0") {


            $data_solicitud_laboratorio = array(
                'input_via'       =>  $this->input->post('inputVia'), ///
                'tipo_nota'       =>  $this->input->post('tipo_nota'),
                'nota_id'         =>  $nota_id,   ///
                'fecha_solicitud' =>  date('d-m-Y'),
                'triage_id'       =>  $this->input->post('triage_id'),
                'estudios'        =>  $this->input->post('arreglo_id_catalogo_estudio')
            );

            if ($this->input->post('solicitud_laboratorio_id')) {
                $this->config_mdl->_update_data('um_solicitud_laboratorio', $data_solicitud_laboratorio, array('solicitud_id' =>  $this->input->post('solicitud_laboratorio_id')));
            } else if ($this->input->post('arreglo_id_catalogo_estudio') != "{}") {
                $this->config_mdl->_insert('um_solicitud_laboratorio', $data_solicitud_laboratorio);
            }
        }

        //-----------------solicitud_laboratorio_nota_evolución------------

    }

    public function AjaxConsultarDiluyente()
    {
        $medicamento_id = $this->input->get('medicamento_id');
        $sql = $this->config_mdl->_query("SELECT diluyente, volumen_diluyente
                                       FROM catalogo_medicamentos
                                       WHERE medicamento_id = $medicamento_id");
        print json_encode($sql);
    }
    public function AjaxConteoEstadoPrescripciones()
    {
        $sql['Prescripciones_activas'] = $this->config_mdl->_query("SELECT COUNT(prescripcion_id)activas FROM prescripcion
                                                                  WHERE estado = 1 AND triage_id = " . $_GET['folio']);
        $sql['Prescripciones_canceladas'] = $this->config_mdl->_query("SELECT prescripcion.prescripcion_id
                                                                    FROM prescripcion
                                                                    INNER JOIN catalogo_medicamentos ON
                                                                    prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                    INNER JOIN os_triage ON
                                                                    prescripcion.triage_id = os_triage.triage_id
                                                                    INNER JOIN btcr_prescripcion ON
                                                                    prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                                                    WHERE os_triage.triage_id =" . $_GET['folio'] . " GROUP BY prescripcion_id");
        print json_encode($sql);
    }
    public function AjaxModificarPrescripcion()
    {
        $datos = array(
            'via' => $this->input->get('via'),
            'frecuencia' => $this->input->get('frecuencia'),
            'aplicacion' => $this->input->get('aplicacion'),
            'fecha_inicio' => $this->input->get('fecha_inicio'),
            'tiempo' => $this->input->get('tiempo'),
            'periodo' => $this->input->get('periodo'),
            'observacion' => $this->input->get('observacion'),
            'dosis' => $this->input->get('dosis')
        );

        $condicion = array(
            'prescripcion_id' => $this->input->get('prescripcion_id')
        );

        $sql = $this->config_mdl->_update_data('prescripcion', $datos, $condicion);
        print json_encode($sql);
    }
    public function AjaxPrescripciones()
    {
        $estado = $_GET['estado'];
        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT catalogo_medicamentos.medicamento_id AS id_medicamento, medicamento, categoria_farmacologica,
                                                        fecha_prescripcion, dosis, observacion, prescripcion.via AS via_administracion, frecuencia, aplicacion,
                                                        fecha_inicio, tiempo, periodo, fecha_fin, prescripcion_id, estado
                                                        FROM prescripcion INNER JOIN catalogo_medicamentos ON
                                                        prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                        INNER JOIN os_triage ON prescripcion.triage_id = os_triage.triage_id
                                                        WHERE os_triage.triage_id =" . $_GET['folio'] . " 
                                                        AND estado !=0 
                                                        AND STR_TO_DATE(fecha_fin,'%d/%m/%Y') >= CURDATE()");

        print json_encode($sql['Prescripcion']);
    }

    public function AjaxPrescripcionesSinValidar()
    {
        $estado = $_GET['estado'];
        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT catalogo_medicamentos.medicamento_id AS id_medicamento, medicamento, categoria_farmacologica,
                                                        fecha_prescripcion, dosis, observacion, prescripcion.via AS via_administracion, frecuencia, aplicacion,
                                                        fecha_inicio, tiempo, periodo, fecha_fin, prescripcion_id, estado
                                                        FROM prescripcion INNER JOIN catalogo_medicamentos ON
                                                        prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                        INNER JOIN os_triage ON prescripcion.triage_id = os_triage.triage_id
                                                        WHERE os_triage.triage_id =" . $_GET['folio'] . "  AND estado !=0 ");

        print json_encode($sql['Prescripcion']);
    }

    public function AjaxNotificacionFarmacovigilancia()
    {
        $triage_id = $this->input->get('folio');
        $consulta = "SELECT notificacion_id, medicamento, notificacion,
                  concat(empleado_nombre, ' ' ,empleado_apellidos)empleado
                  FROM `um_notificaciones_prescripciones`
                  INNER JOIN prescripcion
                    ON um_notificaciones_prescripciones.prescripcion_id = prescripcion.prescripcion_id
                  INNER JOIN catalogo_medicamentos
                    ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                  INNER JOIN os_empleados
                    ON os_empleados.empleado_id = um_notificaciones_prescripciones.empleado_id
                  WHERE triage_id = $triage_id";
        $sql = $this->config_mdl->_query($consulta);
        print json_encode($sql);
    }
    public function AjaxBitacoraPrescripciones()
    {
        $sql = $this->config_mdl->_query("SELECT prescripcion.prescripcion_id, fecha_prescripcion,
                                          CONCAT(medicamento, ' ', gramaje)medicamento, catalogo_medicamentos.medicamento_id,
                                          observacion
                                        FROM prescripcion
                                        INNER JOIN catalogo_medicamentos ON
                                        prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                        INNER JOIN os_triage ON
                                        prescripcion.triage_id = os_triage.triage_id
                                        INNER JOIN btcr_prescripcion ON
                                        prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                        WHERE os_triage.triage_id =" . $_GET['folio'] . " GROUP BY prescripcion_id");
        print json_encode($sql);
    }
    // Obtenemos un numero que determina si el medicamento es de safe, infectologia
    // o una solucion.
    public function AjaxTipoMedicamento()
    {
        $sql = $this->config_mdl->_query("SELECT safe, categoria_farmacologica FROM catalogo_medicamentos
                                        WHERE medicamento_id = " . $_GET['medicamento_id'] . "; ");
        print json_encode($sql);
    }
    public function AjaxConsultarViasAdministracion()
    {
        $medicamento = $this->input->get('medicamento');
        $consulta = "SELECT via FROM catalogo_medicamentos WHERE medicamento LIKE '$medicamento%' GROUP BY via ";
        $sql = $this->config_mdl->_query($consulta);
        print json_encode($sql);
    }
    public function AjaxBitacoraHistorialMedicamentos()
    {
        $sql = $this->config_mdl->_query("SELECT fecha_prescripcion,
                                          prescripcion.via as via_administracion, dosis,
                                          frecuencia, aplicacion, fecha_inicio, fecha_fin,
                                          observacion, fecha, tipo_accion, motivo,
                                          catalogo_medicamentos.medicamento_id
                                        FROM prescripcion
                                        INNER JOIN catalogo_medicamentos ON
                                        prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                        INNER JOIN os_triage ON
                                        prescripcion.triage_id = os_triage.triage_id
                                        INNER JOIN btcr_prescripcion ON
                                        prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                        WHERE os_triage.triage_id =" . $_GET['folio'] . "
                                        AND prescripcion.prescripcion_id=" . $_GET['prescripcion_id'] . "
                                        ORDER BY medicamento");
        print json_encode($sql);
    }
    /*Funcion para Guardar Nota medica o editarla*/
    public function TarjetaDeIdentificacion($Paciente)
    {
        $sql['info'] = $this->config_mdl->sqlGetDataCondition('os_tarjeta_identificacion', array(
            'triage_id' => $Paciente
        ))[0];
        $this->load->view('Documentos/Doc_TarjetaIdentificacion', $sql);
    }

    public function AjaxTarjetaDeIdentificacion()
    {
        $check = $this->config_mdl->sqlGetDataCondition('os_tarjeta_identificacion', array(
            'triage_id' => $this->input->post('triage_id')
        ), 'ti_id');
        $data = array(
            'ti_enfermedades' => $this->input->post('ti_enfermedades'),
            'ti_alergias' => $this->input->post('ti_alergias'),
            'ti_fecha' => date('d/m/Y'),
            'ti_hora' => date('H:i'),
            'empleado_id' => $this->UMAE_USER,
            'triage_id' => $this->input->post('triage_id')
        );
        if (empty($check)) {
            $this->config_mdl->_insert('os_tarjeta_identificacion', $data);
        } else {
            unset($data['ti_fecha']);
            unset($data['ti_hora']);
            $this->config_mdl->_update_data('os_tarjeta_identificacion', $data, array(
                'triage_id' => $this->input->post('triage_id')
            ));
        }
        $this->setOutput(array('accion' => '1'));
    }

    public function AjaxGuardarDiagnosticos()
    {
        $sqlDiagnostico = $this->config_mdl->sqlGetDataCondition('um_cie10', array(
            'cie10_nombre' => $this->input->post('cie10_nombre')
        ));

        $data = array(
            'fecha_dx'          => date('d-m-Y'),
            'hora_dx'           => date('H:i'),
            'triage_id'         => $this->input->post('triage_id'),
            'cie10_id'          => $sqlDiagnostico[0]['cie10_id'],
            'tipo_diagnostico'  => $this->input->post('tipo_diagnostico'),
            'complemento'       => $this->input->post('complemento'),
            'medico_id'         => $this->UMAE_USER,
            'tipo_nota'         => $this->input->post('tipo_nota')
        );

        // Condiciones via Jquery de una accion (accion de JS no de URL)
        if ($this->input->post('accion') == 'add') {
            $this->config_mdl->_insert('paciente_diagnosticos', $data);
            if ($_GET['a'] == 'edit') {
                $datos = array(
                    'hf_id'          => $_GET['hf'],
                    'diagnostico_id' => $this->config_mdl->_get_last_id('paciente_diagnosticos', 'diagnostico_id')
                );
                $this->config_mdl->_insert('diagnostico_hoja_frontal', $datos);
            }
        } else if ($this->input->post('accion') == 'convertir a primario') {
            $this->config_mdl->_insert('paciente_diagnosticos', $data);
        } else if ($this->input->post('accion') == 'cambiar principal') {
            $this->config_mdl->_insert('paciente_diagnosticos', $data);
        } else if ($this->input->post('accion') == 'convertir a egreso') {
            $this->config_mdl->_insert('paciente_diagnosticos', $data);
        } else if ($this->input->post('accion') == 'cambiar_principal_a_secundario') {
            $this->config_mdl->_update_data('paciente_diagnosticos', array(
                'tipo_diagnostico' => $this->input->post('tipo_diagnostico')
            ), array(
                'diagnostico_id' => $this->input->post('diagnostico_id')
            ));
        } else {
            unset($data['fecha_dx']);
            $this->config_mdl->_update_data('paciente_diagnosticos', $data, array(
                'diagnostico_id' => $this->input->post('diagnostico_id')
            ));
        }

        $this->setOutput(array('accion' => '1', 'post' => $this->input->post()));
    }


    public function AjaxConsultarDiagnosticos()
    {
        $folio = $this->input->get('folio');
        $consulta = "SELECT *
                   FROM paciente_diagnosticos
                   INNER JOIN um_cie10
                     ON paciente_diagnosticos.cie10_id = um_cie10.cie10_id
                   WHERE triage_id =" . $folio . " ORDER BY tipo_diagnostico";

        $sql = $this->config_mdl->_query($consulta);
        print json_encode($sql);
    }

    public function AjaxEliminarDiagnostico()
    {

        $this->config_mdl->_delete_data('paciente_diagnosticos', array(
            'diagnostico_id' => $this->input->post('diagnostico_id')
        ));
        $this->config_mdl->_delete_data('diagnostico_hoja_frontal', array(
            'diagnostico_id' => $this->input->post('diagnostico_id')
        ));

        $this->setOutput(array('accion' => '1'));
    }

    public function AjaxObtenerDiagnosticos()
    {
        $tipo_nota = $this->input->post('tipo_nota');
        $accion = $this->input->post('accion');
        $area = $this->input->post('tipo');

        // $sqlFechaNotaInicial = $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
        //     'triage_id'=>  $this->input->post('triage_id')
        // ))[0];
        $sqlFechaNotas = $this->config_mdl->_get_data_condition('doc_notas', array(
            'triage_id' =>  $this->input->post('triage_id')
        ), 'notas_fecha')[0];

        if ($area == 'Hospitalizacion') {
            $sqlFechaNotaInicial =  $this->config_mdl->sqlGetDataCondition('um_notas_ingresos_hospitalario', array(
                'triage_id' =>  $this->input->post('triage_id')
            ), 'fecha_elabora')[0];

            $fecha = $sqlFechaNotaInicial['fecha_elabora'];
            $fechas = date("d/m/Y", strtotime($fecha));
        } else {
            $sqlFechaNotaInicial =  $this->config_mdl->sqlGetDataCondition('os_consultorios_especialidad_hf', array(
                'triage_id' =>  $this->input->post('triage_id')
            ), 'hf_fg')[0];

            $fechas = $sqlFechaNotaInicial['hf_fg'];
        }

        //Se consulta la existencia de diagnosticos principales y Dx de Egreso

        $consultaDxPrincipal = $this->config_mdl->_query("SELECT * FROM paciente_diagnosticos
                       WHERE triage_id = '" . $this->input->post('triage_id') . "' AND tipo_diagnostico = 1");

        $consultaDxEgreso = $this->config_mdl->_query("SELECT * FROM paciente_diagnosticos
                       WHERE triage_id = '" . $this->input->post('triage_id') . "' AND tipo_diagnostico = 3");


        switch ($accion) {
            case "add":
                if ($tipo_nota == "Nota Inicial" && empty($sqlFechaNotaInicial)) {
                    $sql = $this->config_mdl->_query("SELECT * FROM paciente_diagnosticos, um_cie10 WHERE 
                    paciente_diagnosticos.cie10_id=um_cie10.cie10_id AND 
                    paciente_diagnosticos.triage_id='{$this->input->post('triage_id')}' ORDER BY tipo_diagnostico='0' DESC");
                } else {

                    $sql = $this->config_mdl->_query("SELECT * FROM paciente_diagnosticos, um_cie10 WHERE 
                    paciente_diagnosticos.cie10_id=um_cie10.cie10_id AND 
                    paciente_diagnosticos.triage_id='" . $this->input->post('triage_id') . "' ORDER BY tipo_diagnostico='0' DESC");
                }
                break;

            case "edit":
                if ($tipo_nota == "Nota Inicial") {
                    $sql = $this->config_mdl->_query("SELECT * FROM paciente_diagnosticos, um_cie10 WHERE 
                    paciente_diagnosticos.cie10_id=um_cie10.cie10_id AND paciente_diagnosticos.fecha_dx <='{$fechas}'  AND
                    paciente_diagnosticos.triage_id='{$this->input->post('triage_id')}' ORDER BY tipo_diagnostico='0' DESC");
                } else {
                    $sql = $this->config_mdl->_query("SELECT * FROM paciente_diagnosticos, um_cie10 WHERE 
                    paciente_diagnosticos.cie10_id=um_cie10.cie10_id AND paciente_diagnosticos.fecha_dx <='{$sqlFechaNotas}'  AND
                    paciente_diagnosticos.triage_id='{$this->input->post('triage_id')}' ORDER BY tipo_diagnostico='0' DESC");
                }
                break;
            default:
                $sql = $this->config_mdl->_query("SELECT * FROM paciente_diagnosticos, um_cie10 WHERE 
                    paciente_diagnosticos.cie10_id=um_cie10.cie10_id AND 
                    paciente_diagnosticos.triage_id='{$this->input->post('triage_id')}' ORDER BY tipo_diagnostico='0' DESC");
        }

        foreach ($sql as $value) {

            if ($value['tipo_diagnostico'] == '0') {
                $tipo_diagnostico = 'Dx de Ingreso';
                $color = "label green";
            } else if ($value['tipo_diagnostico'] == '1') {
                $tipo_diagnostico = 'Dx Principal';
                $color = "label blue";
            } else  if ($value['tipo_diagnostico'] == '2') {
                $tipo_diagnostico = 'Dx Secundario';
                $color = "label amber";
            } else if ($value['tipo_diagnostico'] == '3') {
                $tipo_diagnostico = 'Dx de Egreso';
                $color = "label red";
                $eliminar .= '<i class="fa fa-trash-o icono-accion eliminar-diagnostico-cie10 tip pointer" data-id="' . $value['diagnostico_id'] . '" data-toggle="tooltip" title="Borrar diagnóstico" style="margin-left: 5px"></i>';
            }

            if ($tipo_nota == 'Nota de Evolución' || $tipo_nota == 'Nota de Valoracion' || $tipo_nota == 'Nota de Interconsulta') {

                $row .= '<div class="col-md-12" style="margin-top: -10px;">
                              <div class="alert alert-success alert-dismissable fade in">
                                <div class="row" style="margin-right: -36px; margin-top: -10px;margin-bottom: -9px;">
                                    <div class="col-md-9">
                                        <strong>Diagnóstico:</strong> ' . $value['cie10_nombre'] . '&nbsp;&nbsp;&nbsp;&nbsp;<b>Clave:</b>' . $value['cie10_clave'] . '<br>
                                        <h6 style="font-size:12px"><strong>Complemento de diagnóstico:</strong> ' . ($value['complemento'] != '' ? $value['complemento'] : 'Sin Observaciones') . '</h6>
                                    </div>
                                    <div class="col-md-3" style="margin-top: 10px>
                                        <h6 style="font-size:15px"><strong>' . ($value['tipo_diagnostico'] == '0' || $value['tipo_diagnostico'] == '1' ? '<span class="label green">' . $tipo_diagnostico . '</span>' : '<span class="label amber">' . $tipo_diagnostico . '</span>') . '</strong></h6>
                                        <h6 style="font-size:10px;margin-top: 3px;">Agregado el ' . $value['fecha_dx'] . ' en ' . $value['tipo_nota'] . '</h6>
                                    </div>';
                if ($tipo_diagnostico == 'Dx de Ingreso' && empty($consultaDxPrincipal)) {
                    $idDiv = 'update_dxprincipal';
                    $row .=           '<div class="col-md-4" style="left: 600px;padding: 0px;margin-top:-24px">
                                        <h6>¿Es diagnóstico principal?&nbsp;&nbsp;
                                            <input type="radio" class="custom-control-input" name="dxprimario" value="Si" data-id="' . $value['diagnostico_id'] . '" data-obs="' . $value['complemento'] . '" data-nombre="' . $value['cie10_nombre'] . '" data-tipo_diagnostico="' . $value['tipo_diagnostico'] . '">
                                            <label class="custom-control-label"></i> Si</label>&nbsp;&nbsp;
                                            <input type="radio" class="custom-control-input" name="dxprimario" value="No">
                                           <label class="custom-control-label" for="defaultUnchecked"> No</label>
                                        </h6>
                                    </div>';
                } else if ($tipo_diagnostico == 'Dx Principal' && COUNT($consultaDxPrincipal != 0)) {
                    $idDiv = 'cambiar_dxprincipal';
                    $row .=          '<div class="col-md-4" style="left: 600px;padding: 0px;margin-top:-24px">
                                        <h6>¿Cambiar diagnóstico principal?&nbsp;&nbsp;
                                            <input type="radio" class="custom-control-input" name="cambioDxPrincipal" value="Si" data-id="' . $value['diagnostico_id'] . '" data-obs="' . $value['complemento'] . '" data-nombre="' . $value['cie10_nombre'] . '" data-tipo_diagnostico="' . $value['tipo_diagnostico'] . '">
                                            <label class="custom-control-label"></i> Si</label>&nbsp;&nbsp;
                                            <input type="radio" class="custom-control-input" name="cambioDxPrincipal" value="No">
                                           <label class="custom-control-label" for="defaultUnchecked"> No</label>
                                        </h6>
                                   </div>';
                }
                $row .=      '</div>
                              </div>
                            </div>';
                $row .=  '<div class="col-md-12 hidden" id="' . $idDiv . '" style="margin-top: -10px;">
                                <div class="input-group m-b">
                                    <span class="input-group-addon"><i class="fa fa-stethoscope" style="font-size: 16px"></i></span>
                                    <input type="text" class="form-control update_dx" name="cie10_nombre" placeholder="Tecleé y seleccione el diagnóstico primario (minimo 5 caracteres)" autocomplete="off">
                                    <span class="input-group-addon back-imss border-back-imss add-cie10">
                                    <i class="fas fa fa-search pointer"></i></span>
                                </div>
                            </div>';
            } else if ($tipo_nota == 'Nota Inicial') {

                $row .=  '<div class="col-md-12" style="margin-top: -10px;">
                                <div class="alert alert-info alert-dismissable fade in">
                                    <div class="row" style="margin-right: -36px; margin-top: -10px;margin-bottom: -9px;">
                                        <div class="col-md-9">
                                            <strong>Diagnóstico:</strong> ' . $value['cie10_nombre'] . '&nbsp;&nbsp;&nbsp;&nbsp;Clave:' . $value['cie10_clave'] . ' ' . '<br>
                                            <h6 style="font-size:12px"><strong>Complemento de diagnóstico:</strong> ' . ($value['complemento'] != '' ? $value['complemento'] : 'Sin Observaciones') . '</h6>
                                        </div>
                                        <div class="col-md-2" style="margin-top: 10px>
                                            <h6 style="font-size:15px"><strong>' . ($value['tipo_diagnostico'] == '0' ? '<span class="label green">' . $tipo_diagnostico . '</span>' : '<span class="label amber">' . $tipo_diagnostico . '</span>') . '</strong></h6>
                                            <h6 style="font-size:10px;margin-top: 3px;">Agregado el ' . $value['fecha_dx'] . ' en ' . $value['tipo_nota'] . '</h6>                                
                                        </div>
                                        <div class="col-md-1 center-block" style="margin-top: 10px">
                                            <i class="fa fa-pencil icono-accion editar-diagnostico-cie10 tip pointer" data-id="' . $value['diagnostico_id'] . '" data-obs="' . $value['complemento'] . '" data-nombre="' . $value['cie10_nombre'] . '" data-tipo_diagnostico="' . $value['tipo_diagnostico'] . '" data-toggle="tooltip" title="Editar"></i>&nbsp;
                                            <i class="fa fa-trash-o icono-accion eliminar-diagnostico-cie10 tip pointer" data-id="' . $value['diagnostico_id'] . '" data-toggle="tooltip" title="Borrar diagnóstico"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>';
            } else { // Si es Nota de Egreso

                $row .=  '<div class="col-md-12" style="margin-top: -10px;">
                            <div class="alert alert-info alert-dismissable fade in">
                                <div class="row" style="margin-right: -36px; margin-top: -10px;margin-bottom: -9px;">
                                    <div class="col-md-9">
                                        <strong>Diagnóstico:</strong> ' . $value['cie10_nombre'] . '&nbsp;&nbsp;&nbsp;&nbsp;Clave:' . $value['cie10_clave'] . '<br>
                                        <h6 style="font-size:12px"><strong>Complemento de diagnóstico:</strong> ' . ($value['complemento'] != '' ? $value['complemento'] : 'Sin Observaciones') . '</h6>
                                    </div>
                                    <div class="col-md-2" style="margin-top: 10px>
                                        <h6 style="font-size:15px"><strong><span class="' . $color . '">' . $tipo_diagnostico . '</span></strong></h6>
                                        <h6 style="font-size:10px;margin-top: 3px;">Agregado el ' . $value['fecha_dx'] . ' en ' . $value['tipo_nota'] . '</h6>                                
                                    </div>
                                    <div class="col-md-1 center-block" style="margin-top: 10px">
                                        <i class="fa fa-pencil icono-accion editar-diagnostico-cie10 tip pointer" data-id="' . $value['diagnostico_id'] . '" data-obs="' . $value['complemento'] . '" data-nombre="' . $value['cie10_nombre'] . '" data-tipo_diagnostico="' . $value['tipo_diagnostico'] . '" data-toggle="tooltip" title="Editar"></i>
                                        ' . $eliminar . '
                                    </div>';

                if ($tipo_diagnostico == 'Dx de Ingreso' && empty($consultaDxPrincipal)) {

                    $row .=  '<div class="col-md-10">
                                        <h5><strong>¿Es Diagnóstico de Egreso? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                                <input type="radio" class="custom-control-input" name="dxEgreso" value="Si" data-id="' . $value['diagnostico_id'] . '" data-obs="' . $value['complemento'] . '" data-nombre="' . $value['cie10_nombre'] . '" data-tipo_diagnostico="' . $value['tipo_diagnostico'] . '" data-cie10_id="' . $value['cie10_id'] . '"> <i class="red"></i><strong>Si</strong>
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                                    <input type="radio" class="custom-control-input" name="dxEgreso" value="No">
                                                    <i class="red"></i><strong>No</strong>
                                            </label>
                                        </h5>
                                    </div>';
                } else if ($tipo_diagnostico == 'Dx Principal' && !empty($consultaDxPrincipal)) {
                    if (empty($consultaDxEgreso)) {
                        $row .=  '<div class="col-md-10">
                                        <h5><strong>¿Es Diagnóstico de Egreso éste Dx Principal? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                               <input type="radio" class="custom-control-input" name="dxEgreso" value="Si" data-id="' . $value['diagnostico_id'] . '" data-obs="' . $value['complemento'] . '" data-nombre="' . $value['cie10_nombre'] . '" data-tipo_diagnostico="' . $value['tipo_diagnostico'] . '">
                                                <i class="red"></i><strong>Si</strong>
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                                <input type="radio" class="custom-control-input" name="dxEgreso" value="No">
                                                <i class="red"></i><strong>No</strong>
                                            </label>
                                        </<h5>
                                    </div>';
                    }
                }

                $row .=      '</div>
                            </div>
                        </div>'; // Cierre class="col-md-12"

                $row .=  '<div class="col-md-12 hidden" id="cambio_dxi_dxe" style="margin-top: 0px;">
                                <div class="input-group m-b">
                                    <span class="input-group-addon"><i class="fa fa-stethoscope" style="font-size: 16px"></i></span>
                                    <input type="text" class="form-control update_dx" name="cie10_nombre" placeholder="Tecleé y seleccione el diagnóstico de Egreso (minimo 5 caracteres)" autocomplete="off">
                                    <span class="input-group-addon back-imss border-back-imss add-cie10">
                                    <i class="fas fa fa-search pointer"></i></span>
                                </div>
                            </div>';
            }
        } // fin For
        $this->setOutputV2(array('row' => $row));
    }
    public function AjaxHistorialReaccionesAdversas()
    {
        $paciente = $this->input->get('paciente');
        $sql = $this->config_mdl->_query('SELECT medicamento,efecto FROM um_ram
                                        INNER JOIN prescripcion
                                        	ON um_ram.prescripcion_id = prescripcion.prescripcion_id
                                        INNER JOIN catalogo_medicamentos
                                        	ON catalogo_medicamentos.medicamento_id = prescripcion.medicamento_id
                                        WHERE um_ram.triage_id = ' . $paciente);
        print json_encode($sql);
    }
    public function AjaxHistorialAlergiaMedicamentos()
    {
        $paciente = $this->input->get('paciente');
        $sql = $this->config_mdl->_query("SELECT medicamento FROM um_alergias_medicamentos
                                        INNER JOIN catalogo_medicamentos
                                          ON um_alergias_medicamentos.medicamento_id = catalogo_medicamentos.medicamento_id
                                        WHERE triage_id = $paciente");
        print json_encode($sql);
    }
    public function AjaxRegistrarEfectoAdverso()
    {
        $data = array(
            'prescripcion_id' => $this->input->get('prescripcion_id'),
            'triage_id' => $this->input->get('paciente'),
            'efecto' => $this->input->get('motivo')
        );
        $this->config_mdl->_insert('um_ram', $data);
        $sql = $this->config_mdl->_get_data_condition(
            'um_ram',
            array('triage_id' => $this->input->get('paciente'))
        );
        print json_encode($sql);
    }

    public function AjaxCIE10()
    {
        $cie10_nombre = $this->input->post('cie10_nombre');
        $sql = $this->config_mdl->_query("SELECT * FROM um_cie10 WHERE cie10_nombre LIKE '%$cie10_nombre%' LIMIT 50");
        foreach ($sql as $value) {
            $um_cie10 .= '<li>' . $value['cie10_nombre'] . '</li>';
        }
        $this->setOutput(array('um_cie10' => $um_cie10));
    }
    public function AjaxCheckCIE10()
    {
        $sql = $this->config_mdl->sqlGetDataCondition('um_cie10', array(
            'cie10_nombre' => $this->input->post('cie10_nombre')
        ));
        if (!empty($sql)) {
            $this->setOutput(array('accion' => '1'));
        } else {
            $this->setOutput(array('accion' => '2'));
        }
    }

    public function GuardarGlasgowHfAbierto()
    {

        //apertura ocular
        $hf_abierto_glasgow_s1 = $this->input->post('hf_glasgow_expontanea') +
            $this->input->post('hf_glasgow_hablar') +
            $this->input->post('hf_glasgow_dolor') +
            $this->input->post('hf_glasgow_ausente');
        //Respuesta motora
        $hf_abierto_glasgow_s2 = $this->input->post('hf_glasgow_obedece') +
            $this->input->post('hf_glasgow_localiza') +
            $this->input->post('hf_glasgow_retira') +
            $this->input->post('hf_glasgow_flexion') +
            $this->input->post('hf_glasgow_extension') +
            $this->input->post('hf_glasgow_ausencia');
        // Respuesta verbal
        $hf_abierto_glasgow_s3 = $this->input->post('hf_glasgow_orientado') +
            $this->input->post('hf_glasgow_confuso') +
            $this->input->post('hf_glasgow_incoherente') +
            $this->input->post('hf_glasgow_sonidos') +
            $this->input->post('hf_glasgow_arespuesta');

        $total_glasgow = $hf_abierto_glasgow_s1 + $hf_abierto_glasgow_s2 + $hf_abierto_glasgow_s3;
        $data_totalGlasgow = array(
            'triage_puntaje_total' => $total_glasgow
        );

        $this->config_mdl->_insert('os_consultorios_especialidad_hf', $data_totalGlasgow);
    }
    public function GuardarRiesgoTrobosisHfAbierto()
    {

        //Edad
    }

    public function ObtenerMedicamentos()
    {
        $sql['medicamentos'] = $this->config_mdl->_get_data('catalogo_medicamentos');
        print json_encode($sql);
        return json_encode($sql);
    }
    public function AjaxDosisMaxima()
    {
        $medicamento_id = $this->input->get('medicamento_id');
        $consulta = "SELECT * FROM catalogo_medicamentos WHERE medicamento_id = $medicamento_id";
        $query = $this->config_mdl->_query($consulta);
        print json_encode($query);
    }

    public function AjaxActualizarDiagnostico()
    {
        $sqlDiagnostico = $this->config_mdl->sqlGetDataCondition('um_cie10', array(
            'cie10_nombre' => $this->input->post('cie10_nombre')
        ));
        $data = array(
            'triage_id'         => $this->input->post('triage_id'),
            'cie10_id'          => $sqlDiagnostico[0]['cie10_id'],
            'tipo_diagnostico'  => "1",
            'complemento'       => $this->input->post('complemento'),
            'fecha_dx'          => date('d-m-Y'),
            'medico_id'         => $this->UMAE_USER,
            'tipo_nota'         => $this->input->post('tipo_nota')
        );

        if ($this->input->post('accion') == 'add') {
            $this->config_mdl->_insert('paciente_diagnosticos', $data);
        } else {
            unset($data['fecha_dx']);
            $this->config_mdl->_update_data('paciente_diagnosticos', $data, array(
                'diagnostico_id' => $this->input->post('diagnostico_id')
            ));
        }
        $this->setOutput(array('accion' => '1', 'post' => $this->input->post()));
    }
    public function AjaxUltimaNota()
    {
        $triage_id = $this->input->post('triage_id');;
        $tipo_nota = $this->input->post('tipo_nota');
        switch ($tipo_nota) {
            case 'Nota de Evolución':

                break;
            case 'Nota de Valoracion':

                break;
            case 'Nota de Interconsulta':
                break;
            default:

                break;
        }
        $consultaNota = "SELECT * FROM doc_nota INNER JOIN doc_notas ON doc_nota.notas_id = doc_notas.notas_id AND
                      triage_id = '{$folio}' AND notas_tipo = '{$tipo_nota}' AND empleado_sevicio_id =
                      ORDER BY nota_id DESC LIMIT 1";

        $consulta430200 = "SELECT doc_nota_id FROM doc_430200 WHERE doc_estatus= 'Evaluado' AND triage_id = 3";
        $sql = $this->config_mdl->_query($consultaNota);
        if (COUNT($sql) < 1) {
            $sql = $this->config_mdl->_query($consultaHFrontal);
        }
        print json_encode($sql);
    }

    /* Nota de Egreso */
    public function AjaxNotaEgreso()
    {

        $matricula = $this->input->post('medicoMatricula');
        $selectProceso = $this->input->post('proceso');

        switch ($selectProceso) {
            case 0: // NO haty nada es egreso de admision continua
                $proceso = 0;
                break;
            case 1:  // Pre-alta
                $proceso = 1;
                $fecha_hora_alta = 'Pendiente';
                $prealta = 1;
                $alta = 0;
                $altacancelada = 0;
                break;
            case 2: // ALta
                $proceso = 2;
                $fecha_hora_alta = date('Y-m-d H:i');
                $prealta = 0;
                $alta = 1;
                $altacancelada = 0;
                $doc_43051 = $this->config_mdl->_get_data_condition('doc_43051', array(
                    'triage_id' => $this->input->post('triage_id')
                ))[0];
                break;
            case 3: // Cancelar Alta
                $proceso = 3;
                $fecha_hora_alta = 'Cancelada';
                $prealta = 0;
                $alta = 0;
                $altacancelada = 1;
                break;
        }

        $sql['empleado'] = $this->config_mdl->_query("SELECT empleado_id, empleado_servicio
                                                        FROM os_empleados WHERE empleado_id = $this->UMAE_USER");

        $sql['medicoBaseId'] = $this->config_mdl->_query("SELECT empleado_id, empleado_servicio, empleado_roles
                                                         FROM os_empleados WHERE empleado_matricula = '$matricula'");
        if (empty($sql['medicoBaseId'])) { // Si es un médico de base quiem realiza la nota no selecciona otro
            $medicoTratante = $this->UMAE_USER;
        } else {
            $medicoTratante = $sql['medicoBaseId'][0]['empleado_id'];
        }
        $dataNotas = array(
            'triage_id'             => $this->input->post('triage_id'),
            'empleado_id'           => $this->UMAE_USER,
            'empleado_servicio_id'  => $sql['empleado'][0]['empleado_servicio'],
            'notas_medicotratante'  => $medicoTratante,
            'notas_fecha'           => date('d-m-Y'), //date('Y-m-d')
            'notas_hora'            => date('H:i'),
            'notas_tipo'            => $this->input->post('tipo_nota'),
            'notas_via'             => $this->input->post('inputVia'),
            'notas_area'            => $this->UMAE_AREA

        );

        $dataNotaEgreso = array(
            'fecha_nota'        => date('d-m-Y'),
            'hora_nota'         => date('H:i'),
            'motivo_egreso'     => $this->input->post('motivo_egreso'),
            'resumen_clinico'   => $this->input->post('resumen_clinico'),
            'exploracion_fisica' => $this->input->post('exploracion_fisica'),
            'laboratorios'      => $this->input->post('laboratorios'),
            'gabinetes'         => $this->input->post('gabinetes'),
            'pronostico'        => $this->input->post('pronostico'),
            'plan'              => $this->input->post('plan'),
            'req_oxigeno'       => $this->input->post('req_oxigeno'),
            'req_ambulancia'    => $this->input->post('req_ambulancia'),
            'informe_medico'    => $this->input->post('familiar_informe'),
            'recibe_informe'    => $this->input->post('recibe_informe'),
            'estado_alta'       => $proceso
        );

        $dataAlta = array(
            'proceso'        => $proceso,
            'fecha_alta'     => date('Y-m-d'),
            'fecha_hora_alta'=> $fecha_hora_alta,
            'comentarios'    => $this->input->post('comentarios'),
            'prealta'        => $prealta,
            'alta'           => $alta,
            'altacancelada'  => $altacancelada

        );

        if ($this->input->post('accion') == 'add') { //Si se agrega nueva nota

            $this->config_mdl->_insert('doc_notas', $dataNotas);
            $nota_id = $this->config_mdl->_get_last_id('doc_notas', 'notas_id');
            $dataNotaEgreso += ['nota_id' => $nota_id];

            $this->config_mdl->_insert('doc_nota_egreso', $dataNotaEgreso);

            $dataSV = array(
                'sv_tipo'       => $this->input->post('inputVia'),
                'sv_fecha'      => date('Y-m-d'),
                'sv_hora'       => date('H:i:s'),
                'sv_ta'         => $this->input->post('sv_ta'),
                'sv_temp'       => $this->input->post('sv_temp'),
                'sv_fc'         => $this->input->post('sv_fc'),
                'sv_fr'         => $this->input->post('sv_fr'),
                'sv_oximetria'  => $this->input->post('sv_oximetria'),
                'sv_dextrostix' => $this->input->post('sv_dextrostix'),
                'sv_peso'       => $this->input->post('sv_peso'),
                'sv_talla'      => $this->input->post('sv_talla'),
                'triage_id'     => $this->input->post('triage_id'),
                'empleado_id'   => $this->UMAE_USER,
                'nota_id'       => $nota_id
            );
            $this->config_mdl->_insert('os_triage_signosvitales', $dataSV);

            $consulta = "SELECT diagnostico_id, tipo_diagnostico, cie10_id FROM paciente_diagnosticos
                          WHERE triage_id = " . $this->input->post('triage_id');

            $sqlResult = $this->config_mdl->_query($consulta);

            for ($x = 0; $x < COUNT($sqlResult); $x++) {
                $this->config_mdl->_insert('diagnostico_notas', array(
                    'notas_id'          => $this->config_mdl->_get_last_id('doc_notas', 'notas_id'),
                    'diagnostico_id'    => $sqlResult[$x]['diagnostico_id'],
                    'tipo_diagnostico'  => $sqlResult[$x]['tipo_diagnostico'],
                    'cie10_id'          => $sqlResult[$x]['cie10_id']
                ));
            }
            for ($i = 0; $i < count($this->input->post('nombre_residente')); $i++) {
                $datosResidente = array(
                    'notas_id'           => $this->config_mdl->_get_last_id('doc_notas', 'notas_id'),
                    'nombre_residente'   => $this->input->post("nombre_residente[$i]"),
                    'apellido_residente' => $this->input->post("apellido_residente[$i]"),
                    'cedulap_residente'  => $this->input->post("cedula_residente[$i]"),
                    'grado'              => $this->input->post("grado[$i]")
                );

                if (count($datosResidente) > 0) {
                    $this->config_mdl->_insert('um_notas_residentes', $datosResidente);
                }
            }

            /* Mandar informacion de Pre-alta */
            $id_nota_egreso = $this->config_mdl->_get_last_id('doc_nota_egreso', 'docnota_id');
            $dataAlta += ['id_nota_egreso' => $id_nota_egreso];
            $this->config_mdl->_insert('um_alta_hospitalaria', $dataAlta);

            // si se edita la nota, se confirma o se cancela la Alta si se confirma ALta se actualiza doc_43051
        } else {

            unset($data['notas_hora']);
            unset($data['notas_fecha']);
            unset($data['empleado_id']);

            $this->config_mdl->_update_data('doc_notas', array(
                'notas_medicotratante'  => $medicoTratante,
            ), array(
                'notas_id'  => $this->input->post('notas_id')
            ));
            $nota_id = $this->input->post('notas_id');

            $this->config_mdl->_update_data('doc_nota_egreso', array(
                'motivo_egreso'     =>  $this->input->post('motivo_egreso'),
                'resumen_clinico'   =>  $this->input->post('resumen_clinico'),
                'exploracion_fisica'=>  $this->input->post('exploracion_fisica'),
                'laboratorios'      =>  $this->input->post('laboratorios'),
                'gabinetes'         =>  $this->input->post('gabinetes'),
                'pronostico'        =>  $this->input->post('pronostico'),
                'plan'              =>  $this->input->post('plan'),
                'req_oxigeno'       =>  $this->input->post('req_oxigeno'),
                'req_ambulancia'    =>  $this->input->post('req_ambulancia'),
                'informe_medico'    =>  $this->input->post('familiar_informe'),
                'recibe_informe'    =>  $this->input->post('recibe_informe'),
                'estado_alta'       => $proceso
            ), array(
                'nota_id'  =>  $nota_id
            ));
            if ($this->input->post('tipo_nota') == 'Nota de Prealta') {
                $docnota_id = $this->config_mdl->_get_data_condition('doc_nota_egreso', array(
                    'nota_id' =>  $nota_id
                ))[0];

                $this->config_mdl->_update_data('um_alta_hospitalaria', array(
                    'proceso'        => $proceso,
                    'fecha_alta'     => date('Y-m-d'),
                    'fecha_hora_alta' => $fecha_hora_alta,
                    'comentarios'    => $this->input->post('comentarios'),
                    'prealta'        => $prealta,
                    'alta'           => $alta,
                    'altacancelada'  => $altacancelada
                ), array(
                    'id_nota_egreso' => $docnota_id['docnota_id']
                ));
            }
            /*
            if($proceso == 2){
                
                $this->config_mdl->_update_data('doc_43051',array(
                    'salida_medico'  => $medicoTratante,
                    'salida_servicio'=> Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                ),array(
                    'id'  => $doc_43051['triage_id']
                ));
            }*/
        }

        $this->config_mdl->_update_data('os_camas',
            array('proceso' => $proceso),
            array('cama_id' => $this->input->post('cama_id'))
        );


        $this->setOutput(array(

            'accion'        => '1',
            'notas_id'      => $nota_id,
            'prealta'       => $prealta,
            'alta'          => $alta,
            'altacancelada' => $altacancelada,
            "datos"         => $dataNotaEgreso,
            "dataNotas"     => $dataNotas,
            "tipo_nota"     => $this->input->post('tipo_nota')
        ));
    }

    public function NotaIngresoHospitalario()
    {
        $sql['Especialidades'] = $this->config_mdl->_query("SELECT * FROM um_especialidades WHERE especialidad_interconsulta = 1 GROUP BY um_especialidades.especialidad_nombre");
        $sql['info'] =  $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['ingresoHosp'] =  $this->config_mdl->_get_data_condition('um_ingresos_hospitalario', array(
            'triage_id' =>  $this->input->get_post('folio')
        ));

        $sql['notaIngreso'] =  $this->config_mdl->_get_data_condition('um_notas_ingresos_hospitalario', array(
            'id_nota' =>  $this->input->get_post('idnota')
        ));
        $sql['escalaSalud'] =  $this->config_mdl->_get_data_condition('um_notas_escalas_salud', array(
            'triage_id' =>  $this->input->get_post('folio')
        ));
        $sql['plan'] =  $this->config_mdl->_get_data_condition('um_notas_plan_ordenes', array(
            'triage_id' => $this->input->get_post('folio'),
            'id_nota'  => $_GET['idnota']
        ));

        $sql['INFO_MEDICO'] =  $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' =>  $_SESSION['UMAE_USER']
        ));

        $sql['PINFO'] = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['SignosVitales'] = $this->config_mdl->_get_data_condition('os_triage_signosvitales', array(
            'triage_id' => $this->input->get_post('folio')
        ))[0];
        $sql['Documentos'] = $this->config_mdl->_get_data_condition('pc_documentos', array(
            'doc_nombre' => 'Hoja Frontal'
        ));
        $sql['Medicamentos'] = $this->config_mdl->_query("SELECT medicamento_id,
                                                                 CONCAT(medicamento,' ',gramaje, ', ', forma_farmaceutica)medicamento,
                                                                 interaccion_amarilla,interaccion_roja
                                                          FROM catalogo_medicamentos
                                                          WHERE existencia = 1 ORDER BY medicamento");

        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT *
                                                          FROM prescripcion
                                                          INNER JOIN catalogo_medicamentos
                                                            ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                          WHERE estado != 0 AND triage_id =" . $_GET['folio']);
        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT cie10_clave, cie10_nombre, complemento FROM paciente_diagnosticos
                                                          INNER JOIN diagnostico_hoja_frontal
                                                            ON paciente_diagnosticos.diagnostico_id = diagnostico_hoja_frontal.diagnostico_id
                                                          INNER JOIN um_cie10
                                                            ON um_cie10.cie10_id = paciente_diagnosticos.cie10_id
                                                          WHERE triage_id = " . $_GET['folio'] . " ORDER BY tipo_diagnostico");

        $sql['Prescripciones_canceladas'] = $this->config_mdl->_query("SELECT prescripcion.prescripcion_id
                                                                      FROM prescripcion
                                                                      INNER JOIN catalogo_medicamentos ON
                                                                      prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                      INNER JOIN os_triage ON
                                                                      prescripcion.triage_id = os_triage.triage_id
                                                                      INNER JOIN btcr_prescripcion ON
                                                                      prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                                                      WHERE os_triage.triage_id =" . $_GET['folio'] . " GROUP BY prescripcion_id");

        $sql['Interconsultas'] = $this->config_mdl->_query("SELECT * FROM um_interconsultas_historial
                                                            INNER JOIN doc_430200
                                                                ON doc_430200.doc_id = um_interconsultas_historial.doc_id
                                                            WHERE um_interconsultas_historial.id_nota = '{$this->input->get_post('idnota')}' 
                                                            AND triage_id = " . $_GET['folio']);

        $sql['MedicosBase'] = $this->config_mdl->_query(
            "SELECT empleado_id, empleado_matricula,empleado_nombre, empleado_apellidos FROM os_empleados
                                                        WHERE empleado_roles != 77 AND empleado_servicio =
                                                          (SELECT empleado_servicio
                                                           FROM os_empleados
                                                           WHERE empleado_id = '$this->UMAE_USER')"
        );


        $sql['Procedimientos'] = $this->config_mdl->_query("SELECT * FROM um_procedimientos WHERE especialidad_id = 1 GROUP BY um_procedimientos.numero");

        //---------------mhma----------///
        $sql['um_catalogo_laboratorio_area'] = $this->config_mdl->_query("SELECT DISTINCT area FROM um_catalogolaboratorio");

        $sql['um_catalogo_laboratorio'] = $this->config_mdl->_query("SELECT * FROM um_catalogolaboratorio");

        foreach ($sql['um_catalogo_laboratorio_area'] as $area) {
            $tipos[$area['area']] = $this->config_mdl->_query("SELECT DISTINCT tipo FROM um_catalogolaboratorio WHERE area = '" . $area['area'] . "'");
        }

        $sql['um_catalogo_laboratorio_tipos'] = $tipos;

        $sql['um_estudios_obj'] = $this->config_mdl->_query("SELECT * FROM um_solicitud_laboratorio WHERE input_via = '" . $_GET['tipo'] . "' AND tipo_nota='" . $_GET['TipoNota'] . "' AND id_nota= '" . $_GET['idnota'] . "'" . " AND triage_id = '" . $_GET['folio'] . "'");

        //---------------mhma----------///

        $sql['Residentes'] = $this->config_mdl->sqlGetDataCondition('um_notas_residentes', array(
            'idnota_ingresohosp' => $sql['notaIngreso'][0]['id_nota']
        ));

        $this->load->view('Documentos/Nota_Header', $sql);
        $this->load->view('Documentos/NotaIngresoHospitalario', $sql);
    }

    /* Guardar Nota de Ingreso Hospitalario */
    public function AjaxGuardaNotaIngresoHosp()
    {
        $ingresoHosp = $this->config_mdl->_get_data_condition('um_ingresos_hospitalario', array(
            'triage_id' =>  $this->input->post('triage_id')
        ))[0];

        $sqlCheckDiagnosticos = $this->config_mdl->sqlGetDataCondition('paciente_diagnosticos', array(
            'triage_id' => $this->input->post('triage_id')
        ));
        $sqlCheckNotaIngreso = $this->config_mdl->sqlGetDataCondition('um_notas_ingresos_hospitalario', array(
            'triage_id' => $this->input->post('triage_id')
        ), 'id_nota');


        foreach ($this->input->post('procedimientos') as $procedimientos_select) {
            $procedimientos .= $procedimientos_select . ',';
        }
        if ($this->input->post('medicoTratante')) {
            $medicoTratante = $this->input->post('medicoTratante');
        } else {
            $medicoTratante = $this->UMAE_USER;
        }

        $dataNota = array(
            'triage_id'                             => $this->input->post('triage_id'),
            'id_medico'                             => $this->UMAE_USER,
            'id_medico_tratante'                    =>  $medicoTratante,
            'id_servicio'                           => Modules::run('Config/ObtenerEspecialidadID', array('Usuario' => $this->UMAE_USER)),
            'tipo_documento'                        => $this->input->post('hf_documento'),
            'fecha_elabora'                         => date('Y-m-d'),
            'hora_elabora'                          => date('H:i:s'),
            'tipo_interrogatorio'                   => $this->input->post('tipo_interrogatorio'),
            'motivo_ingreso'                        => $this->input->post('motivo_ingreso'),
            'antecedentes_heredofamiliares'         => $this->input->post('antecedentes_herfam'),
            'antecedentes_personales_nopatologicos' => $this->input->post('antecedentes_no_patologicos'),
            'antecedentes_personales_patologicos'   => $this->input->post('antecedentes_patologicos'),
            'antecedentes_ginecoobstetricos'        => $this->input->post('antecedentes_ginecoobstetricos'),
            'padecimiento_actual'                   => $this->input->post('padecimiento_actual'),
            'exploracion_fisica'                    => $this->input->post('exploracion_fisica'),
            'estudios_laboratorio'                  => $this->input->post('estudios_laboratorio'),
            'estudios_gabinete'                     => $this->input->post('estudios_gabinete'),
            'estado_salud'                          => $this->input->post('estado_salud'),
            'pronostico'                            => $this->input->post('pronostico'),
            'procedimientos'                        => trim($procedimientos, ','),
            'comentario'                            => $this->input->post('comentario')
        );



        /** Comprueba si no hay Hoaja inicial y guarda los campos dl formulario Nota Inicial
         *  Regresa en formato Json respuesta 
         */
        //if(empty($sqlCheckNotaIngreso)){
        if ($this->input->post('accion') == 'add') {
            if (!empty($sqlCheckDiagnosticos)) {
                $last_idnota = $this->config_mdl->_insert('um_notas_ingresos_hospitalario', $dataNota);
                if ($last_idnota) $last_idnota = $this->db->insert_id();

                /*
                Se consultan los diagnosticos del paciente registrados
                para ser asignados en la hoja frontal
                */

                $diagnostico = $this->config_mdl->_query("SELECT diagnostico_id
                                                          FROM paciente_diagnosticos
                                                          WHERE triage_id =" . $this->input->post('triage_id') . "");

                for ($x = 0; $x < count($diagnostico); $x++) {
                    $datos = array(
                        'id_nota' => $this->config_mdl->_get_last_id('um_notas_ingresos_hospitalario', 'id_nota'),
                        'diagnostico_id' => $diagnostico[$x]['diagnostico_id']
                    );
                    $this->config_mdl->_insert('diagnostico_hoja_frontal', $datos);
                }

                /* ------------------------------------- ESCALAS DE SALUD --------------------------------------------------*
                 *-------------------------------- $dataES datos de Escalas De Salud ----------------------------------------*/

                $dataES = array(
                    'id_nota'           => $last_idnota,
                    'triage_id'         => $this->input->post('triage_id'),
                    'id_servicio'       => Modules::run('Config/ObtenerEspecialidadID', array('Usuario' => $this->UMAE_USER)),
                    'escala_eva'        => $this->input->post('escala_eva'),
                    'escala_glasgow'    => $this->input->post('escala_glasgow'),
                    'glasgow_ocular'    => $this->input->post('apertura_ocular'),
                    'glasgow_motora'    => $this->input->post('respuesta_motora'),
                    'glasgow_verbal'    => $this->input->post('respuesta_verbal'),
                    'riesgo_caida'      => $this->input->post('riesgo_caida'),
                    'escala_riesgo_trombosis' => $this->input->post('escala_riesgo_trombosis')
                );
                $this->config_mdl->_insert('um_notas_escalas_salud', $dataES);

                /* --------------------------------------- PLAN ------------------------------------------- *
                  * ---------------------------------- ORDENES MEDICAS --------------------------------------*/

                $hf_nutricion = "";
                $radio_nutricion = $this->input->post('dieta');
                $select_nutricion = $this->input->post('tipoDieta');
                $otros_nutricion = $this->input->post('otraDieta');
                /* las siguiendes condiciones son para indexar el campo 'nota_nutricion'
                  de esta forma se conoce el origen del dato.*/

                //Indica que el valor viene de una caja de texto
                if ($otros_nutricion != "" & $select_nutricion == 13) {
                    $hf_nutricion = $otros_nutricion;
                    // Indica que el valor viene de un select
                } else if ($select_nutricion >= 1 || $select_nutricion <= 12) {
                    $hf_nutricion = $select_nutricion;
                    // Indica que el valor viene de un radio
                } else if ($radio_nutricion == 0) {
                    $hf_nutricion = $radio_nutricion;
                }

                $select_signos = $this->input->post("tomaSignos");
                $otros_signos = $this->input->post("otrasIndicacionesSignos");
                $hf_svycuidados = $select_signos;
                if ($select_signos == "3") {
                    $hf_svycuidados = $otros_signos;
                }

                $hf_cgenfermeria = 1;
                if ($this->input->post("cuidados_genfermeria") != 1) {
                    $hf_cgenfermeria = 0;
                }

                $dataPlan = array(
                    'id_nota'                => $last_idnota,
                    'triage_id'              => $this->input->post('triage_id'),
                    'id_servicio'            => Modules::run('Config/ObtenerEspecialidadID', array('Usuario' => $this->UMAE_USER)),
                    'dieta'                  => $hf_nutricion,
                    'dieta_indicaciones'     => $this->input->post('dieta_indicaciones'),
                    'toma_signos_vitales'    => $hf_svycuidados,
                    'cuidados_genfermeria'   => $hf_cgenfermeria,
                    'cuidados_eenfermeria'   => $this->input->post('cuidadosEspecialesEnfermeria'),
                    'soluciones_parenterales' => $this->input->post('solucionesParenterales')
                );

                $this->config_mdl->_insert('um_notas_plan_ordenes', $dataPlan);

                /* -------------------------------------Solicitud de interconsultas ----------------------------------------*/
                for ($x = 0; $x < count($this->input->post('nota_interconsulta')); $x++) {
                    $this->config_mdl->_update_data('um_ingresos_hospitalario', array(
                        'estado' => 'Interconsulta',
                        'interconsulta' => 'Si'
                    ), array(
                        'triage_id' =>  $this->input->post('triage_id')
                    ));

                    $datos_interconsulta = array(
                        'doc_servicio_envia'      => Modules::run('Config/ObtenerEspecialidadID', array('Usuario' => $this->UMAE_USER)),
                        'doc_servicio_solicitado' => $this->input->post("nota_interconsulta[$x]"),
                        'triage_id'               => $this->input->post('triage_id'),
                        'empleado_envia'          => $this->UMAE_USER,
                        'doc_estatus'             => 'En Espera',
                        'doc_fecha'               => date('Y-m-d'),
                        'doc_hora'                => date('H:i'),
                        'doc_area'                => $this->UMAE_AREA,
                        'doc_modulo'              => 'Hospitalizacion',
                        'motivo_interconsulta'    => $this->input->post('motivo_interconsulta'),
                        'id_nota'                 => $this->config_mdl->_get_last_id('um_notas_ingresos_hospitalario', 'id_nota')
                    );

                    $this->config_mdl->_insert('doc_430200', $datos_interconsulta);
                }
                /*
                    Se consultan las interconsultas realizadas en la nota inicial, para
                    ser registrados en la tabla um_interconsutas _historial
                    */
                $interconsultas_ni = $this->config_mdl->_query("SELECT doc_id FROM doc_430200
                                                                WHERE id_nota = " . $this->config_mdl->_get_last_id('um_notas_ingresos_hospitalario', 'id_nota'));
                for ($x = 0; $x < count($interconsultas_ni); $x++) {
                    $datos = array(
                        "id_nota" => $this->config_mdl->_get_last_id('um_notas_ingresos_hospitalario', 'id_nota'),
                        "doc_id" => $interconsultas_ni[$x]['doc_id']
                    );
                    $this->config_mdl->_insert('um_interconsultas_historial', $datos);
                }

                /* --------------------------  Inicio Registro de prescricpiones  ------------------------------------*
                 * ---------------------------------------------------------------------------------------------------*/

                $fecha_actual = date('d-m-Y');
                // Numero de prescripciones ingresadas, almacena en arreglo y registra en la
                // tabla "prescripcio"
                for ($x = 0; $x < count($this->input->post('idMedicamento')); $x++) {
                    $observacion = $this->input->post("observacion[$x]");
                    $otroMedicamento = $this->input->post("nomMedicamento[$x]");
                    if ($this->input->post("idMedicamento[$x]") == '1') {
                        $observacion = $otroMedicamento . '-' . $observacion;
                    }
                    $datosPrescripcion = array(
                        'empleado_id' => $this->UMAE_USER,
                        'triage_id' => $this->input->post('triage_id'),
                        'medicamento_id' => $this->input->post("idMedicamento[$x]"),
                        'via' => $this->input->post("via_admi[$x]"),
                        'fecha_prescripcion' => $fecha_actual,
                        'dosis' => $this->input->post("dosis[$x]"),
                        'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                        'via' => $this->input->post("via[$x]"),
                        'frecuencia' => $this->input->post("frecuencia[$x]"),
                        'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                        'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                        'tiempo' => $this->input->post("duracion[$x]"),
                        'periodo' => $this->input->post("periodo[$x]"),
                        'fecha_fin' => $this->input->post("fechaFin[$x]"),
                        'observacion' => $observacion,
                        'estado' => "1"
                    );
                    $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                }
                //Número de antibioticos apt
                for ($x = 0; $x < count($this->input->post('idMedicamento_npt')); $x++) {
                    //Se guardan en un arreglo los datos del medicamento
                    $datosPrescripcion = array(
                        'empleado_id' => $this->UMAE_USER,
                        'triage_id' => $this->input->post('triage_id'),
                        'medicamento_id' => $this->input->post("idMedicamento_npt[$x]"),
                        'dosis' => $this->input->post("dosis[$x]"),
                        'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                        'via' => $this->input->post("via[$x]"),
                        'frecuencia' => $this->input->post("frecuencia[$x]"),
                        'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                        'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                        'tiempo' => $this->input->post("duracion[$x]"),
                        'periodo' => $this->input->post("periodo[$x]"),
                        'fecha_fin' => $this->input->post("fechaFin[$x]"),
                        'observacion' => $this->input->post("observacion[$x]"),
                        'estado' => "1"
                    );
                    //Se registra el medicamento
                    $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                    //Se consulta la ultima prescripcion registrada
                    $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                    /*
                  Se toman los datos necesarios para un npt
                  con la variable $ultima_prescripcion, identificamos la prescripcion con la que se
                  asocia prescripcion y npt
                  */
                    $datos_npt = array(
                        'prescripcion_id' => $ultima_prescripcion,
                        'aminoacido' => $this->input->post("aminoacido[$x]"),
                        'dextrosa' => $this->input->post("dextrosa[$x]"),
                        'lipidos' => $this->input->post("lipidos_intravenosos[$x]"),
                        'agua_inyect' => $this->input->post("agua_inyectable[$x]"),
                        'cloruro_sodio' => $this->input->post("cloruro_sodio[$x]"),
                        'sulfato' => $this->input->post("sulfato_magnesio[$x]"),
                        'cloruro_potasio' => $this->input->post("cloruro_potasio[$x]"),
                        'fosfato' => $this->input->post("fosfato_potasio[$x]"),
                        'gluconato' => $this->input->post("gluconato_calcio[$x]"),
                        'albumina' => $this->input->post("albumina[$x]"),
                        'heparina' => $this->input->post("heparina[$x]"),
                        'insulina' => $this->input->post("insulina_humana[$x]"),
                        'zinc' => $this->input->post("zinc[$x]"),
                        'mvi' => $this->input->post("mvi_adulto[$x]"),
                        'oligoelementos' => $this->input->post("oligoelementos[$x]"),
                        'vitamina' => $this->input->post("vitamina[$x]")
                    );
                    $this->config_mdl->_insert('prescripcion_npt', $datos_npt);
                }
                //Número de antibioticos antimicrobiano u oncologico
                for ($x = 0; $x < count($this->input->post('idMedicamento_onco_antimicro')); $x++) {
                    $datosPrescripcion = array(
                        'empleado_id' => $this->UMAE_USER,
                        'triage_id' => $this->input->post('triage_id'),
                        'medicamento_id' => $this->input->post("idMedicamento_onco_antimicro[$x]"),
                        'dosis' => $this->input->post("dosis[$x]"),
                        'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                        'via' => $this->input->post("via[$x]"),
                        'frecuencia' => $this->input->post("frecuencia[$x]"),
                        'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                        'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                        'tiempo' => $this->input->post("duracion[$x]"),
                        'periodo' => $this->input->post("periodo[$x]"),
                        'fecha_fin' => $this->input->post("fechaFin[$x]"),
                        'observacion' => $this->input->post("observacion[$x]"),
                        'estado' => "1"
                    );
                    $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                    $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                    $categoria_safe = $this->input->post("categoria_safe[$x]");
                    $datos_onco_antimicrobiano = array(
                        'prescripcion_id' => $ultima_prescripcion,
                        'categoria_safe' => $categoria_safe,
                        'diluente' => $this->input->post("diluyente[$x]"),
                        'vol_dilucion' => $this->input->post("vol_diluyente[$x]")
                    );
                    $this->config_mdl->_insert('prescripcion_onco_antimicrobianos', $datos_onco_antimicrobiano);
                }
                // Se toma el ID de las precripcines activas
                $Prescripciones = $this->config_mdl->_query("SELECT prescripcion_id FROM prescripcion WHERE estado != 0 
                                                            AND triage_id = '{$this->input->post('triage_id')}'");

                for ($x = 0; $x < count($Prescripciones); $x++) {
                    $FrontalPrescripcion = array(
                        'id_nota' => $this->config_mdl->_get_last_id('um_notas_ingresos_hospitalario', 'id_nota'),
                        'prescripcion_id' => $Prescripciones[$x]['prescripcion_id']
                    );
                    // Se registra la relacion entre notas y prescripcion
                    $this->config_mdl->_insert('nm_hojafrontal_prescripcion', $FrontalPrescripcion);
                }

                /* -------------------------- Medicos Residenetes ----------------------------------**/
                for ($i = 0; $i < count($this->input->post('nombre_residente')); $i++) {
                    $datosResidente = array(
                        'idnota_ingresohosp' => $this->config_mdl->_get_last_id('um_notas_ingresos_hospitalario', 'id_nota'),
                        'nombre_residente'   => $this->input->post("nombre_residente[$i]"),
                        'apellido_residente' => $this->input->post("apellido_residente[$i]"),
                        'cedulap_residente'  => $this->input->post("cedula_residente[$i]"),
                        'grado'              => $this->input->post("grado[$i]")
                    );

                    if (count($datosResidente) > 0) {
                        $this->config_mdl->_insert('um_notas_residentes', $datosResidente);
                    }
                }
            }
        } else {   /* Se edita la nota **/

            unset($dataNota['fecha_elabora']);
            unset($dataNota['hora_elabora']);
            unset($dataNota['id_medico']);
            $this->config_mdl->_update_data('um_notas_ingresos_hospitalario', $dataNota, array(
                'id_nota' =>  $this->input->post('id_nota')
            ));

            /* ------------------------------------- ESCALAS DE SALUD --------------------------------------------------*
                 *-------------------------------- $dataES datos de Escalas De Salud ----------------------------------------*/

            $dataES = array(
                'triage_id'         => $this->input->post('triage_id'),
                'id_servicio'       => Modules::run('Config/ObtenerEspecialidadID', array('Usuario' => $this->UMAE_USER)),
                'escala_eva'        => $this->input->post('escala_eva'),
                'escala_glasgow'    => $this->input->post('escala_glasgow'),
                'glasgow_ocular'    => $this->input->post('apertura_ocular'),
                'glasgow_motora'    => $this->input->post('respuesta_motora'),
                'glasgow_verbal'    => $this->input->post('respuesta_verbal'),
                'riesgo_caida'      => $this->input->post('riesgo_caida'),
                'escala_riesgo_trombosis' => $this->input->post('escala_riesgo_trombosis')
            );
            unset($dataES['id_servicio']);
            $this->config_mdl->_update_data('um_notas_escalas_salud', $dataES, array(
                'id_nota' => $this->input->post('id_nota')
            ));

            /* --------------------------------------- PLAN ------------------------------------------- */

            $hf_nutricion = "";
            $radio_nutricion = $this->input->post('dieta');
            $select_nutricion = $this->input->post('tipoDieta');
            $otros_nutricion = $this->input->post('otraDieta');
            /* las siguiendes condiciones son para indexar el campo 'nota_nutricion'
                  de esta forma se conoce el origen del dato.*/

            //Indica que el valor viene de una caja de texto
            if ($otros_nutricion != "" & $select_nutricion == 13) {
                $hf_nutricion = $otros_nutricion;
                // Indica que el valor viene de un select
            } else if ($select_nutricion >= 1 || $select_nutricion <= 12) {
                $hf_nutricion = $select_nutricion;
                // Indica que el valor viene de un radio
            } else if ($radio_nutricion == 0) {
                $hf_nutricion = $radio_nutricion;
            }

            $select_signos = $this->input->post("tomaSignos");
            $otros_signos = $this->input->post("otrasIndicacionesSignos");
            $hf_svycuidados = $select_signos;
            if ($select_signos == "3") {
                $hf_svycuidados = $otros_signos;
            }

            $hf_cgenfermeria = 1;
            if ($this->input->post("cuidados_genfermeria") != 1) {
                $hf_cgenfermeria = 0;
            }

            $dataPlan = array(
                'triage_id'              => $this->input->post('triage_id'),
                'dieta'                  => $hf_nutricion,
                'dieta_indicaciones'     => $this->input->post('dieta_indicaciones'),
                'toma_signos_vitales'    => $hf_svycuidados,
                'cuidados_genfermeria'   => $hf_cgenfermeria,
                'cuidados_eenfermeria'   => $this->input->post('cuidadosEspecialesEnfermeria'),
                'soluciones_parenterales' => $this->input->post('solucionesParenterales')
            );
            $this->config_mdl->_update_data('um_notas_plan_ordenes', $dataPlan, array(
                'id_nota' => $this->input->post('id_nota')
            ));



            /*-----------------------------------ACTUALIZACION DE INTERCONSULTAS -----------------------------------------------*/
            /* -------------------------------------Solicitud de interconsultas ----------------------------------------*/
            /*for($x = 0; $x < count($this->input->post('nota_interconsulta')); $x++){
                    $existencia_interconsuta = $this->config_mdl->_query("SELECT doc_id FROM doc_430200 WHERE 
                        doc_servicio_solicitado = ".$this->input->post("nota_interconsulta[$x]")
                   );
                     $this->config_mdl->_update_data('um_ingresos_hospitalario',array(
                       'estado'=>'Interconsulta',
                       'interconsulta'=>'Si'
                     ),array(
                        'triage_id'=>  $this->input->post('triage_id')
                  ));

                    
                     $this->config_mdl->_update_data('doc_430200',$datos_interconsulta, array(
                         'triage_id' => $this->input->post('triage_id'),
                         'id_nota'   => $this->input->post('id_nota')
                     ));
                } */

            /*Se consultan las interconsultas realizadas en la nota inicial, para
                ser registrados en el historial de interconsultas de la nota*/

            /*$interconsultas_ni = $this->config_mdl->_query("SELECT doc_id FROM doc_430200
                                                                WHERE id_nota = ".$this->config_mdl->_get_last_id('um_notas_ingresos_hospitalario','id_nota'));
                
                 for($x = 0; $x < count($interconsultas_ni); $x++){
                   $datos = array(
                     "id_nota" => $this->config_mdl->_get_last_id('um_notas_ingresos_hospitalario','id_nota'),
                     "doc_id" => $interconsultas_ni[$x]['doc_id']
                   );
                   $this->config_mdl->_update_data('um_interconsulta_historial',$datos,array(
                     'id_nota'   => $this->input->post('id_nota')
                   ));
                }*/

            /*Inicio Registro de prescricpiones*/
            $fecha_actual = date('d-m-Y');
            for ($x = 0; $x < count($this->input->post('idMedicamento')); $x++) {
                $observacion = $this->input->post("observacion[$x]");
                $otroMedicamento = $this->input->post("nomMedicamento[$x]");
                if ($this->input->post("idMedicamento[$x]") == '1') {
                    $observacion = $otroMedicamento . '-' . $observacion;
                }
                $datosPrescripcion = array(
                    'empleado_id' => $this->UMAE_USER,
                    'triage_id' => $this->input->post('triage_id'),
                    'medicamento_id' => $this->input->post("idMedicamento[$x]"),
                    'via' => $this->input->post("via_admi[$x]"),
                    'fecha_prescripcion' => $fecha_actual,
                    'dosis' => $this->input->post("dosis[$x]"),
                    'frecuencia' => $this->input->post("frecuencia[$x]"),
                    'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                    'tiempo' => $this->input->post("duracion[$x]"),
                    'periodo' => $this->input->post("periodo[$x]"),
                    'fecha_fin' => $this->input->post("fechaFin[$x]"),
                    'observacion' => $observacion,
                    'estado' => "1"
                );
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
            }
            //Número de antibioticos apt
            for ($x = 0; $x < count($this->input->post('idMedicamento_npt')); $x++) {
                //Se guardan en un arreglo los datos del medicamento
                $datosPrescripcion = array(
                    'empleado_id' => $this->UMAE_USER,
                    'triage_id' => $this->input->post('triage_id'),
                    'medicamento_id' => $this->input->post("idMedicamento_npt[$x]"),
                    'dosis' => $this->input->post("dosis[$x]"),
                    'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                    'via' => $this->input->post("via[$x]"),
                    'frecuencia' => $this->input->post("frecuencia[$x]"),
                    'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                    'tiempo' => $this->input->post("duracion[$x]"),
                    'periodo' => $this->input->post("periodo[$x]"),
                    'fecha_fin' => $this->input->post("fechaFin[$x]"),
                    'observacion' => $this->input->post("observacion[$x]"),
                    'estado' => "1"
                );
                //Se registra el medicamento
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                //Se consulta la ultima prescripcion registrada
                $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                /*
                  Se toman los datos necesarios para un npt
                  con la variable $ultima_prescripcion, identificamos la prescripcion con la que se
                  asocia prescripcion y npt
                  */
                $datos_npt = array(
                    'prescripcion_id' => $ultima_prescripcion,
                    'aminoacido' => $this->input->post("aminoacido[$x]"),
                    'dextrosa' => $this->input->post("dextrosa[$x]"),
                    'lipidos' => $this->input->post("lipidos_intravenosos[$x]"),
                    'agua_inyect' => $this->input->post("agua_inyectable[$x]"),
                    'cloruro_sodio' => $this->input->post("cloruro_sodio[$x]"),
                    'sulfato' => $this->input->post("sulfato_magnesio[$x]"),
                    'cloruro_potasio' => $this->input->post("cloruro_potasio[$x]"),
                    'fosfato' => $this->input->post("fosfato_potasio[$x]"),
                    'gluconato' => $this->input->post("gluconato_calcio[$x]"),
                    'albumina' => $this->input->post("albumina[$x]"),
                    'heparina' => $this->input->post("heparina[$x]"),
                    'insulina' => $this->input->post("insulina_humana[$x]"),
                    'zinc' => $this->input->post("zinc[$x]"),
                    'mvi' => $this->input->post("mvi_adulto[$x]"),
                    'oligoelementos' => $this->input->post("oligoelementos[$x]"),
                    'vitamina' => $this->input->post("vitamina[$x]")
                );
                $this->config_mdl->_insert('prescripcion_npt', $datos_npt);
            }
            //Número de antibioticos antimicrobiano u oncologico
            for ($x = 0; $x < count($this->input->post('idMedicamento_onco_antimicro')); $x++) {
                $datosPrescripcion = array(
                    'empleado_id' => $this->UMAE_USER,
                    'triage_id' => $this->input->post('triage_id'),
                    'medicamento_id' => $this->input->post("idMedicamento_onco_antimicro[$x]"),
                    'dosis' => $this->input->post("dosis[$x]"),
                    'fecha_prescripcion' => date('d-m-Y') . " " . date('H:i'),
                    'via' => $this->input->post("via[$x]"),
                    'frecuencia' => $this->input->post("frecuencia[$x]"),
                    'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                    'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                    'tiempo' => $this->input->post("duracion[$x]"),
                    'periodo' => $this->input->post("periodo[$x]"),
                    'fecha_fin' => $this->input->post("fechaFin[$x]"),
                    'observacion' => $this->input->post("observacion[$x]"),
                    'estado' => "1"
                );
                $this->config_mdl->_insert('prescripcion', $datosPrescripcion);
                $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion', 'prescripcion_id');
                $categoria_safe = $this->input->post("categoria_safe[$x]");
                $datos_onco_antimicrobiano = array(
                    'prescripcion_id' => $ultima_prescripcion,
                    'categoria_safe' => $categoria_safe,
                    'diluente' => $this->input->post("diluyente[$x]"),
                    'vol_dilucion' => $this->input->post("vol_diluyente[$x]")
                );
                $this->config_mdl->_insert('prescripcion_onco_antimicrobianos', $datos_onco_antimicrobiano);
            }
            /*Inicio Registro de prescricpiones*/
            // Se toma el ID de las precripcines activas
            $Prescripciones = $this->config_mdl->_query("SELECT prescripcion_id FROM prescripcion
                                                             WHERE estado != 0 AND triage_id = " . $this->input->post('triage_id') . ";");

            $this->config_mdl->_delete_data('nm_hojafrontal_prescripcion', array('id_nota' => $this->input->post('id_nota')));

            for ($x = 0; $x < count($Prescripciones); $x++) {
                $FrontalPrescripcion = array(
                    'id_nota' => $this->config_mdl->_get_last_id('um_notas_ingresos_hospitalario', 'id_nota'),
                    'prescripcion_id' => $Prescripciones[$x]['prescripcion_id']
                );
                // Se registra la relacion entre notas y prescripcion
                $this->config_mdl->_insert('nm_hojafrontal_prescripcion', $FrontalPrescripcion);
            } /*Fin proceso prescripción*/


            /* --------------------- Consulta medico trattante y medicos residentes si es con cuenta de residentes ----------*/
            $notaResidentes = $this->config_mdl->sqlGetDataCondition('um_notas_residentes', array(
                'idnota_ingresohosp' => $this->input->post('id_nota')
            ));


            for ($i = 0; $i < count($this->input->post('nombre_residente')); $i++) {
                $datosResidente = array(
                    'idnota_ingresohosp' => $this->input->post('id_nota'),
                    'nombre_residente'   => $this->input->post("nombre_residente[$i]"),
                    'apellido_residente' => $this->input->post("apellido_residente[$i]"),
                    'cedulap_residente'  => $this->input->post("cedula_residente[$i]"),
                    'grado'              => $this->input->post("grado[$i]")
                );

                if (empty($notaResidentes)) {
                    $this->config_mdl->_insert('um_notas_residentes', $datosResidente);
                }
            }


            /* -------------------------------------ACTUALIZACION DE DIAGNOSTICOS ---------------------------------*/
            $Dignostico_hf = $this->config_mdl->_query("SELECT * FROM diagnostico_hoja_frontal WHERE id_nota ='{$this->input->post('id_nota')}' ");
            $this->config_mdl->_delete_data('diagnostico_hoja_frontal', array('id_nota' => $this->input->post('id_nota')));

            foreach ($sqlCheckDiagnosticos as $value) {
                $dxs = array(
                    'id_nota'  => $this->config_mdl->_get_last_id('um_notas_ingresos_hospitalario', 'id_nota'),
                    'diagnostico_id' => $value['diagnostico_id']
                );
                $this->config_mdl->_insert('diagnostico_hoja_frontal', $dxs);
            }
        }


        /* ------------------------------------------------ SOLICITUDE DE LABORATORIO --------------------------------------*/

        if ($last_idnota  && $this->input->post('accion') == 'add') {
            $id_nota = $last_idnota;
        } else {
            $id_nota = $this->input->post('id_nota');
        }

        if ($id_nota != "0") {
            $data_solicitud_laboratorio = array(
                'input_via'       =>  $this->input->post('tipo'),
                'tipo_nota'       =>  $this->input->post('tipo_nota'),
                'id_nota'         =>  $id_nota, //id nota de ingreso
                'fecha_solicitud' =>  date('d-m-Y H:i:s'),
                'triage_id'       =>  $this->input->post('triage_id'),
                'estudios'        =>  $this->input->post('arreglo_id_catalogo_estudio')
            );
            if ($this->input->post('solicitud_laboratorio_id')) {
                $this->config_mdl->_update_data('um_solicitud_laboratorio', $data_solicitud_laboratorio, array('solicitud_id' =>  $this->input->post('solicitud_laboratorio_id')));
            } else if ($this->input->post('arreglo_id_catalogo_estudio') != "{}") {
                $this->config_mdl->_insert('um_solicitud_laboratorio', $data_solicitud_laboratorio);
            }
        }

        //-----------------solicitud_laboratorio------------
        /** Comprueba si no se ha ingresado Un diagnostico entonce manda a mensaje a Jquery que no debe de haber un diagnsotico de ingreso
         */

        if (empty($sqlCheckDiagnosticos)) {
            $this->setOutput(array('accion' => '0'));
        } else {
            $this->setOutput(array('accion' => '1', 'val' => 'f'));
        }
    }

    public function BuscarMedicoBase()
    {
        $request = $this->input->get('query');
        $query = $this->config_mdl->_query("SELECT empleado_id, empleado_nombre, empleado_apellidos, empleado_matricula FROM os_empleados WHERE empleado_apellidos LIKE '%$request%' LIMIT 50");
        $data = array();
        foreach ($query as $row) {
            $data[] = array(
                'empleado_id'         => $row['empleado_id'],
                'empleado_nombre'     => $row['empleado_nombre'],
                'empleado_apellidos'  => $row['empleado_apellidos'],
                'empleado_matricula'  => $row['empleado_matricula']
            );
            //$data[] = $row['empleado_nombre'].' '+$row['empleado_apellidos'];

        }
        //$this->output->set_header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function AjaxNotaProcedimientos()
    {

        $dataSV = array(
            'sv_tipo'       => $this->input->post('inputVia'),
            'sv_fecha'      => date('Y-m-d'),
            'sv_hora'       => date('H:i:s'),
            'sv_ta'         => $this->input->post('sv_ta'),
            'sv_temp'       => $this->input->post('sv_temp'),
            'sv_fc'         => $this->input->post('sv_fc'),
            'sv_fr'         => $this->input->post('sv_fr'),
            'sv_oximetria'  => $this->input->post('sv_oximetria'),
            'sv_dextrostix' => $this->input->post('sv_dextrostix'),
            'sv_peso'       => $this->input->post('sv_peso'),
            'sv_talla'      => $this->input->post('sv_talla'),
            'triage_id'     => $this->input->post('triage_id'),
            'empleado_id'   => $this->UMAE_USER
            // 'nota_id'       => $this->config_mdl->_get_last_id('doc_notas','notas_id')
        );

        $matricula = $this->input->post('medicoMatricula');
        $sql['medicoBaseId'] = $this->config_mdl->_query("SELECT empleado_id, empleado_servicio, empleado_roles
                                                         FROM os_empleados WHERE empleado_matricula = '$matricula'");
        if (empty($sql['medicoBaseId'])) { // Si es un médico de base qioe realiza la nota no selecciona otro
            $medicoTratante = $this->UMAE_USER;
        } else {
            $medicoTratante = $sql['medicoBaseId'][0]['empleado_id'];
        }

        $dataNota = array(
            'triage_id'             => $this->input->post('triage_id'),
            'empleado_id'           => $this->UMAE_USER,
            'empleado_servicio_id'  => Modules::run('Config/ObtenerEspecialidadID', array('Usuario' => $this->UMAE_USER)),
            'notas_medicotratante'  => $medicoTratante,
            'notas_fecha'           => date('d-m-Y'),
            'notas_hora'            => date('H:i'),
            'notas_tipo'            => $this->input->post('tipo_nota'),
            'notas_via'             => $this->input->post('via'),
            'notas_area'            => $this->UMAE_AREA
        );

        foreach ($this->input->post('procedimientos') as $procedimientos_select) {
            $procedimientos .= $procedimientos_select . ',';
        }

        $dataNotaProcedimiento = array(
            // 'notas_id'          => $this->config_mdl->_get_last_id('doc_notas','notas_id'),
            'resumen_procedimiento'   => $this->input->post('resumenProcedimiento'),
            'procedimientos'    => trim($procedimientos, ',')
        );

        for ($i = 0; $i < count($this->input->post('nombre_residente')); $i++) {
            $dataResidentes = array(
                // 'notas_id'           => $this->config_mdl->_get_last_id('doc_notas','notas_id'),
                'nombre_residente'   => $this->input->post("nombre_residente[$i]"),
                'apellido_residente' => $this->input->post("apellido_residente[$i]"),
                'cedulap_residente'  => $this->input->post("cedula_residente[$i]"),
                'grado'              => $this->input->post("grado[$i]")
            );

            if (count($datosResidente) > 0) {
                $this->config_mdl->_insert('um_notas_residentes', $datosResidente);
            }
        }

        /* Agregar datos a las tablas */

        if ($this->input->post('accion') == 'add') {
            $this->config_mdl->_insert('doc_notas', $dataNota);
            $notas_id = $this->config_mdl->_get_last_id('doc_notas', 'notas_id');
            /* Agrega el id de la noata con notas_id a los arreglos $dataNotaProcedimiento, $dataSV y $dataResidentes */
            $dataNotaProcedimiento['notas_id'] = $notas_id;
            $dataSV['nota_id'] = $notas_id;
            $dataResidentes['notas_id'] = $notas_id;
            $this->config_mdl->_insert('os_triage_signosvitales', $dataSV);
            $this->config_mdl->_insert('um_notas_procedimientos', $dataNotaProcedimiento);
            $this->config_mdl->_insert('um_notas_residentes', $dataResidentes);
        } else {
            unset($dataNota['notas_fecha']);
            unset($dataNota['notas_hora']);
            unset($dataNota['notas_tipo']);
            unset($dataNota['notas_area']);
            $notas_id = $this->input->post('notas_id');

            $this->config_mdl->_update_data('doc_notas', $dataNota, array(
                'notas_id' => $notas_id
            ));

            $this->config_mdl->_update_data('um_notas_procedimientos', array(
                'resumen_procedimiento' => $this->input->post('resumenProcedimiento'),
                'procedimientos'        => trim($procedimientos, ',')
            ), array(
                'notas_id'              =>  $notas_id
            ));
        }

        $this->setOutput(array('accion' => '1', 'notas_id' => $notas_id));
    }

    public function BuscarDxPreop()
    {

        $consulta = $this->input->get('query');
        $sql = $this->config_mdl->_query("SELECT * FROM um_cie10 WHERE cie10_nombre LIKE '%$consulta%' ");


        foreach ($sql as $value) {
            $output[] = array(
                'cie10_id'  => $value['cie10_id'],
                'clave'     => $value['cie10_clave'],
                'nombre'    => $value['cie10_nombre']
            );
        }

        echo json_encode($output);
    }

    public function BuscarProcedimiento()
    {

        $consulta = $this->input->get('query');
        $sql = $this->config_mdl->_query("SELECT * FROM um_cie9 WHERE nombre LIKE '%$consulta%' ORDER BY DESC");


        foreach ($sql as $value) {
            $output[] = array(
                'id_cx'  => $value['id_cx'],
                'clave'  => $value['clave'],
                'nombre' => $value['nombre']
            );
        }

        echo json_encode($output);
    }

    public function BuscarMedicoBasePorServicio()
    {
        $request = $this->input->get('query');
        $especialidad = Modules::run('Config/ObtenerEspecialidadID', array('Usuario' => $this->UMAE_USER));
        $query = $this->config_mdl->_query("SELECT empleado_id, empleado_nombre, empleado_apellidos, empleado_matricula FROM os_empleados WHERE empleado_apellidos LIKE '%$request%' AND empleado_servicio ='$especialidad' ");
        $data = array();
        foreach ($query as $row) {
            $data[] = array(
                'empleado_id'         => $row['empleado_id'],
                'empleado_nombre'     => $row['empleado_nombre'],
                'empleado_apellidos'  => $row['empleado_apellidos'],
                'empleado_matricula'  => $row['empleado_matricula']
            );
            //$data[] = $row['empleado_nombre'].' '+$row['empleado_apellidos'];

        }
        //$this->output->set_header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function GuardarNotaIndicacion()
    {

        $matricula = $this->input->post('medicoMatricula');
        // Se toman los valores del formulario 'Instrucciones de nutricion'
        $nota_nutricion = "";
        $radio_nutricion = $this->input->post('dieta');
        $select_nutricion = $this->input->post('tipoDieta');
        $otros_nutricion = $this->input->post('otraDieta');

        $sql['medicoBaseId'] = $this->config_mdl->_query("SELECT empleado_id, empleado_servicio, empleado_roles
                                                         FROM os_empleados WHERE empleado_matricula = '$matricula'");
        if (empty($sql['medicoBaseId'])) { // Si es un médico de base qioe realiza la nota no selecciona otro
            $medicoTratante = $this->UMAE_USER;
            $servicio = Modules::run('Config/ObtenerEspecialidadID', array('Usuario' => $this->UMAE_USER));
        } else {
            $medicoTratante = $sql['medicoBaseId'][0]['empleado_id'];
            $servicio =  $sql['medicoBaseId'][0]['empleado_servicio'];
        }

        $dataSV = array(
            'sv_tipo'       => $this->input->post('inputVia'),
            'sv_fecha'      => date('Y-m-d'),
            'sv_hora'       => date('H:i:s'),
            'sv_ta'         => $this->input->post('sv_ta'),
            'sv_temp'       => $this->input->post('sv_temp'),
            'sv_fc'         => $this->input->post('sv_fc'),
            'sv_fr'         => $this->input->post('sv_fr'),
            'sv_oximetria'  => $this->input->post('sv_oximetria'),
            'sv_dextrostix' => $this->input->post('sv_dextrostix'),
            'sv_peso'       => $this->input->post('sv_peso'),
            'sv_talla'      => $this->input->post('sv_talla'),
            'triage_id'     => $this->input->post('triage_id'),
            'empleado_id'   => $this->UMAE_USER
        );

        $dataNotas = array(
            'triage_id'             => $this->input->post('triage_id'),
            'empleado_id'           => $this->UMAE_USER,
            'empleado_servicio_id'  => Modules::run('Config/ObtenerEspecialidadID', array('Usuario' => $this->UMAE_USER)),
            'notas_medicotratante'  => $medicoTratante,
            'notas_fecha'           => date('d-m-Y'), //date('Y-m-d')
            'notas_hora'            => date('H:i'),
            'notas_tipo'            => $this->input->post('tipo_nota'),
            'notas_via'             => $this->input->post('via'),
            'notas_area'            => $this->UMAE_AREA,
        );

        //Indica que el valor viene de una caja de texto
        if ($otros_nutricion != "" & $select_nutricion == 13) {
            $nota_nutricion = $otros_nutricion;
            // Indica que el valor viene de un select
        } else if ($select_nutricion >= 1 || $select_nutricion <= 12) {
            $nota_nutricion = $select_nutricion;
            // Indica que el valor viene de un radio
        } else if ($radio_nutricion == 0) {
            $nota_nutricion = $radio_nutricion;
        }

        $select_signos = $this->input->post("tomaSignos");
        $otros_signos = $this->input->post("otrasIndicacionesSignos");
        $nota_svycuidados = $select_signos;
        if ($select_signos == "3") {
            $nota_svycuidados = $otros_signos;
        }

        $nota_cgenfermeria = 1;
        if ($this->input->post("nota_cgenfermeria") != 1) {
            $nota_cgenfermeria = 0;
        }

        $dataNotaIndicaciones = array(
            'dieta'               => $nota_nutricion,
            'svitales'            => $nota_svycuidados,
            'cuidados_generales'  => $nota_cgenfermeria,
            'cuidados_especiales' => $this->input->post('nota_cuidadosenfermeria'),
            'solucionesp'         => $this->input->post('nota_solucionesp')
        );

        /* Si es nota nueva */
        if ($this->input->post('accion') == 'add') {

            $this->config_mdl->_insert('doc_notas', $dataNotas);
            $dataSV['nota_id'] = $this->config_mdl->_get_last_id('doc_notas', 'notas_id');
            $this->config_mdl->_insert('os_triage_signosvitales', $dataSV);
            //if($last_id_notas) $last_id_notas = $this->db->insert_id();
            $id_notas = $this->config_mdl->_get_last_id('doc_notas', 'notas_id');
            $dataNotaIndicaciones['notas_id'] = $id_notas;
            $this->config_mdl->_insert('um_notas_indicaciones', $dataNotaIndicaciones);

            for ($i = 0; $i < count($this->input->post('nombre_residente')); $i++) {
                $datosResidente = array(
                    'notas_id'           => $this->config_mdl->_get_last_id('doc_notas', 'notas_id'),
                    'nombre_residente'   => $this->input->post("nombre_residente[$i]"),
                    'apellido_residente' => $this->input->post("apellido_residente[$i]"),
                    'cedulap_residente'  => $this->input->post("cedula_residente[$i]"),
                    'grado'              => $this->input->post("grado[$i]")
                );

                if (count($datosResidente) > 0) {
                    $this->config_mdl->_insert('um_notas_residentes', $datosResidente);
                }
            }



            /* Registro prescripcion */
            Modules::run('Sections/Prescripcion/AjaxGuardarPrescripcion', array('medicoTratante' => $medicoTratante, 'servicio' => $servicio));
        } else {
            unset($data['notas_hora']);
            unset($data['notas_fecha']);
            unset($data['empleado_id']);
            unset($data['empleado_servicio_id']);
            unset($data['notas_via']);
            unset($dataSV['sv_tipo']);
            unset($dataSV['sv_fecha']);
            unset($dataSV['sv_hora']);

            $this->config_mdl->_update_data('doc_notas', array(
                'notas_medicotratante'  => $medicoTratante,
            ), array(
                'notas_id'  => $this->input->post('notas_id')
            ));

            $this->config_mdl->_update_data('os_triage_signosvitales', $dataSV, array(
                'nota_id' => $this->input->post('notas_id')
            ));

            $this->config_mdl->_update_data('um_notas_indicaciones', $dataNotaIndicaciones, array(
                'notas_id' => $this->input->post('notas_id')
            ));
        }


        $this->setOutput(array('accion' => '1', 'notas_id' => $id_notas));
    }

    public function Ordeninternamiento($paciente)
    {
        $sql['info'] =  $this->config_mdl->sqlGetDataCondition('os_triage', array(
            'triage_id' =>  $paciente
        ), 'triage_id,triage_nombre,triage_nombre_am,triage_nombre_ap,triage_fecha_nac,triage_paciente_sexo,triage_paciente_curp,triage_color,triage_consultorio_nombre')[0];
        if ($info['triage_paciente_sexo'] = 'HOMBRE')

            /*$sql['empleado']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
           'empleado_id'=> $this->UMAE_USER
        ),'empleado_nombre,empleado_apellidos');

        $sql['DirPaciente']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'        => $paciente,
            'directorio_tipo' => 'Paciente'
        ))[0];
                
        $sql['pinfo']=  $this->config_mdl->sqlGetDataCondition('paciente_info',array('triage_id'=>$paciente,))[0];*/

            $this->load->view('Documentos/Ordeninternamiento', $sql);
    }

    public function NotaTrabajosocial($nota)
    {
        $sql['info'] =  $this->config_mdl->sqlGetDataCondition('os_triage', array(
            'triage_id' =>  $_GET['folio']
        ), 'triage_id,triage_nombre,triage_nombre_am,triage_nombre_ap,triage_fecha_nac,triage_paciente_sexo,triage_paciente_curp,triage_color,triage_consultorio_nombre')[0];
        $this->load->view('Documentos/Notatrabajosocial', $sql);
    }
}
