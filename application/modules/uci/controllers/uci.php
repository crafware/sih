<?php

/**
 * Description of Enfermeria
 *
 * @author bienTICS
 */
require_once APPPATH . 'modules/config/controllers/Config.php';

class Uci extends Config
{
    public function __construct()
    {
        parent::__construct();
        $this->VerificarSession();
    }
    public function index()
    {
        $this->load->view('index');
    }
    public function Camas()
    {
        $this->load->view('CamasUCI');
    }

    public function TableroCamas()
    {
        $this->load->view('TableroCamas');
    }
    public function TotalCamasEstatusPisos($Piso, $Estado)
    {
        return count($this->config_mdl->_query("SELECT os_camas.cama_id FROM os_camas, os_areas, os_pisos, os_pisos_camas
                                            WHERE os_areas.area_id=os_camas.area_id AND os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_camas.cama_estado='$Estado' AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id AND os_pisos.piso_id=" . $Piso));
    }
    public function TotalCamasEstatus($Estado)
    {
        return count($this->config_mdl->_query("SELECT os_camas.cama_id FROM os_camas, os_areas, os_pisos, os_pisos_camas
                                            WHERE os_areas.area_id=os_camas.area_id AND os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_camas.cama_estado='$Estado' AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id"));
    }
    public function TotalPorPiso($piso_id)
    {
        return count($this->config_mdl->_query("SELECT os_camas.cama_id FROM os_camas, os_areas, os_pisos, os_pisos_camas
                                            WHERE os_areas.area_id=os_camas.area_id 
                                            AND os_pisos_camas.cama_id=os_camas.cama_id 
                                            AND os_pisos_camas.piso_id=os_pisos.piso_id 
                                            AND os_pisos.piso_id=" . $piso_id));
    }
    function getServerIp()
    {
        if ($_SERVER['SERVER_ADDR'] === "::1") {
            return "localhost";
        } else {
            return $_SERVER['SERVER_ADDR'];
        }
    }

    public function AjaxVisorCamasUCI_UTR_UTMO()
    {
        $area = $_GET['area'];
        $value = $this->config_mdl->_query("SELECT * FROM os_pisos WHERE os_pisos.area_id = " . $area . ";")[0];
        $Col = '';
        $Col .= '<div class=""> <div id="bead-map" >';
        $Camas = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas, os_pisos, os_pisos_camas, os_pisos_sc WHERE 
            os_areas.area_id        =os_camas.area_id AND 
            os_pisos_camas.cama_id  =os_camas.cama_id AND
            os_pisos_camas.piso_id  =os_pisos.piso_id AND 
            os_pisos_sc.cama_id     =os_camas.cama_id AND 
            os_camas.area_id        = 6               AND
            os_pisos.piso_id        =" . $value['piso_id']);
        $Disponibles = $this->TotalCamasEstatusPisos($value['piso_id'], 'Disponible'); //Esta Vestida
        $Ocupadas = $this->TotalCamasEstatusPisos($value['piso_id'], 'Ocupado');
        $TotalPiso = $this->TotalPorPiso($value['piso_id']);

        $Col .= '<div class="container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="bedCharts-space text-left">
                        <span style="font-weight: bold">' . $value['piso_nombre_corto'] . '</span>
                        <span class="infoPisoTotal">Total:' . $TotalPiso . '</span>
                        <span class="infoPisoDisponibles">Disponibles: ' . $Disponibles . '</span>
                        <span class="infoPisoOcupadas" style="padding-left: 50px">Ocupadas: ' . $Ocupadas . '</span>
                    </div>  
                    <div class="container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12 rowCamas">';
        $Notas = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0");
        foreach ($Camas as $valor) {
            $tiempoIntervalo = '';
            $info43051 = $this->config_mdl->_get_data_condition('doc_43051', array('triage_id' => $valor['triage_id']))[0];
            /* Acciones para el popup*/
            $nombreCama         = '<li><h5 class="text-center link-acciones bold">Cama ' . $valor['cama_nombre'] . '</h5></li>';
            //$Imprimir43051='<li><a href="#" class="generar43051" data-triage="'.$info43051['triage_id'].'" data-cama="'.$valor['cama_id'].'"><i class="fa fa-print icono-accion"></i> Imprimir 43051</a></li>';
            $LiberarCama        = '<li><a href="#" class="liberar43051" data-triage="' . $info43051['triage_id'] . '" data-cama="' . $valor['cama_id'] . '" data-camanombre="' . $valor['cama_nombre'] . '"><i class="fa fa-share-square-o icono-accion"></i> Liberar Cama</a></li>';
            /* Acciones de sobre la cama asignada */
            if ($valor['cama_estado'] == 'Disponible') { //vestida-color verde
                $CamaStatus = 'green';
                $acciones = '<i class="fa fa-bed"></i>';
            } else if ($valor['cama_estado'] == 'Sucia') { // sucia-color negro
                $CamaStatus = 'grey-900';
                $acciones = '<i class="fa fa-bed"></i>';
            } else if ($valor['cama_estado'] == 'Limpia') { //Limpia
                $CamaStatus = 'cyan-400';
                $acciones = '<i class="fa fa-bed"></i>';
            } else if ($valor['cama_estado'] == 'Descompuesta') { // descompuesta -Amarilla
                $CamaStatus = 'yellow-600';
                $acciones = '<i class="fa fa-bed"></i>';
            } else if ($valor['cama_estado'] == 'Reparada') { // Reparada 
                $CamaStatus = 'lime';
                $acciones = '<i class="fa fa-bed"></i>';
            } else if ($valor['cama_estado'] == 'Ocupado') {  // Ocupado-Azul Hombre
                if ($valor['cama_genero'] == 'HOMBRE') {
                    $CamaStatus = 'blue-800';
                } else if ($valor['cama_genero'] == 'MUJER') { // Ocupado-Rosa Mujer
                    $CamaStatus = 'pink-A100';
                }
                $tiempoOcupado = Modules::run('Config/CalcularTiempoTranscurrido', array(
                    'Tiempo1' => $valor['cama_fh_estatus'],
                    'Tiempo2' => date('Y-m-d H:i:s')
                ));
                $tiempoIntervalo .= $tiempoOcupado->format('%a Dias');
                $ExpedienteLink = '<li><a onclick="openExpedient('.$info43051['triage_id'].')"  href="" target="_blank"><i class="fa fa-share-square-o icono-accion"></i>Ver expediente</a></li>';

                if ($this->UMAE_AREA === 'UCI') {
                    $Expediente = '<li><a class = "abrirExpediente" data-folio = '.$info43051['triage_id'].'  target="_blank"><i class="fa fa-share-square-o icono-accion"></i>Ver expediente</a></li>';

                    $acciones = '<ul class="list-inline list-menu">
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bed"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' . $nombreCama . ' '/*.$CambiarCama.' '.$AltaPaciente.' '*/ . $Expediente . '</ul>
                                    </li>
                                </ul>';
                } else {
                    $acciones = '<i class="fa fa-bed"></i>';
                }
            } else if ($valor['cama_estado'] == 'Reservada') {  // Color Morado  Reservada
                $CamaStatus = 'purple-300';
                $Estado = 'Asignada';
                $acciones = '<ul class="list-inline list-menu">
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bed"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' . $nombreCama . ' ' . $LiberarCama . ' </ul>
                                </li>
                            </ul>';

                $tiempoEspera = Modules::run('Config/CalcularTiempoTranscurrido', array(
                    'Tiempo1' => $info43051['ac_fecha_asignacion'],
                    'Tiempo2' => date('Y-m-d H:i:s')
                ));
                $tiempoIntervalo .= $tiempoEspera->format('%h:%i min');
            } else if ($valor['cama_estado'] == 'Contaminada') {   // Contaminada
                $CamaStatus = 'red';
                $Estado = 'Limpia';
                $acciones = '<i class="fa fa-bed"></i>';
            }

            if ($valor['borde'] == '0') {
                $borde = 'camaSinBorde';
            } else if ($valor['borde'] == '1') {
                $borde = 'camaBordeIzq';
            } else if ($valor['borde'] == '2') {
                $borde = 'camaBordeMedio';
            } else if ($valor['borde'] == '3') {
                $borde = 'camaBordeDer';
            }

            if ($valor['proceso'] == '0' || $valor['proceso'] == Null) {
                $proceso = '.';
                $color = 'white';
            } else if ($valor['proceso'] == '1') {
                $proceso = 'PA';
                $color = 'orange';
            } else if ($valor['proceso'] == '2') {
                $proceso = 'A';
                $color = 'black';
            } else if ($valor['proceso'] == '3') {
                $proceso = 'CC';
                $color = 'red';
            }
            // DIBUJA CUADRO DE CAMAS 
            $NotasLen = 0;
            foreach($Notas as $Nota){
                if($Nota["cama_id"] == $valor['cama_id']){
                    $NotasLen += 1 ;
                }
            }
            if($NotasLen > 0){
                $Op= 1;
            }else{
                $Op= 0;
            }
            $Col .= '<div class="contenedor fila ' . $borde . '">
                        <div style="color: ' . $color . ';"><strong><center>' . $proceso . '</center></strong></div>
                        <div id="' . $valor['cama_id'] . '" rel="tooltip" class="cama-no cama-celda ' . $CamaStatus . ' color-white cama' . $valor['cama_id'] . '" "  data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso . '" data-toggle="tooltip" data-trigger="hover"
                        data-placement="top" data-html="true">
                            ' . $acciones . '
                            <h6 style="margin-top: 3px; color:black"><b>' . $valor['cama_nombre'] . '</b></h6>
                            <div class="tooltip" id="tooltip' . $valor['cama_id'] . '"></div>
                        </div>';
            $Col .= '<div id = "nota_'.$valor['cama_id'].'" class="notificacion-nota" ' . 'data-cama-nombre=' . $valor['cama_nombre'] .' data-cama-id='.$valor['cama_id'].' data-cama-status='.$CamaStatus.' data-Notas-Len='.$NotasLen.' style="opacity:'.$Op.'"><p>'."$NotasLen".'</p></div></div>';

            
                
        } //cierre foreach ($Camas as $value)

        $Col .= '</div>'; // cierre de div class="panel panel-default"
        $Col .= '</div>'; // cierre de div class="panel panel-default"
        $Col .= '<script src="' . base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?') . md5(microtime()) . '" type="text/javascript"></script>';
        $this->setOutput(array(
            'accion' => '1',
            'Col'                => $Col,
        ));
    } //cierre de funcion AjaxvisorCamasUCI
    public function BuscarPacienteRegistrado()
    {
        $sql = $this->config_mdl->_query("SELECT * FROM doc_43051 INNER JOIN os_triage  WHERE 
            doc_43051.triage_id  = os_triage.triage_id AND
            doc_43051.triage_id  =  " . $this->input->post('triage_id'));
        if (!empty($sql)) {
            $viaIngreso = $sql[0]['triage_via_registro'];
            $this->setOutput(array('accion' => '1', 'via_ingreso' => $viaIngreso));
        } else $this->setOutput(array('accion' => '2'));
    }

    public function AjaxBuscarPaciente()
    {
        $sql = $this->config_mdl->sqlGetDataCondition('doc_43051', array(
            'triage_id' => $this->input->post('triage_id')
        ));

        if (empty($sql)) {
            // No existe el folio
            $this->setOutput(array('accion' => '1'));
        } else if ($sql[0]['estado_cama'] == 'Asignada') {
            $this->setOutput(array('accion' => '2'));
        } else if ($sql[0]['estado_cama'] == 'En espera') {
            $this->setOutput(array('accion' => '3'));
        } else {
            $this->setOutput(array('accion' => '4'));
        }
    }


    public function AjaxObtenerPaciente($triage_id)
    {
        $sqlHosp    = $this->config_mdl->_query("SELECT * FROM um_ingresos_hospitalario WHERE triage_id=" . $triage_id);
        $sqlPaciente = $this->config_mdl->_query("SELECT * FROM os_triage WHERE triage_id=" . $triage_id)[0];
        if ($sqlPaciente['triage_crea_am'] != '') {
            if (!empty($sqlHosp)) {
                $sql = $this->config_mdl->_query("SELECT * FROM  um_ingresos_hospitalario
                                                WHERE
                                                um_ingresos_hospitalario.estado='En Espera' AND
                                                um_ingresos_hospitalario.triage_id=" . $triage_id);
                if (!empty($sql)) {
                    $this->setOutput(array('paciente' => $sqlPaciente, 'accion' => 'NO_ASIGNADO'));
                } else {
                    $Interconsulta = $this->config_mdl->_get_data_condition('doc_430200', array(
                        'triage_id' => $triage_id
                    ));
                    $Medico = $this->config_mdl->_get_data_condition('os_empleados', array(
                        'empleado_id' => $sqlHosp[0]['id_medico']
                    ));
                    $this->setOutput(array('paciente' => $sqlPaciente, 'ce' => $sqlHosp[0], 'medico' => $Medico[0], 'accion' => 'ASIGNADO', 'TieneInterconsulta' => $Interconsulta));
                }
            } else {
                $this->setOutput(array('accion' => 'NO_EXISTE_EN_HOSP', 'paciente' => $sqlPaciente));
            }
        } else {
            $this->setOutput(array('accion' => 'NO_AM'));
        }
    }

    public function Bucaringresos()
    {
        $fecha = $this->input->post('input_fecha');
        $sql = $this->config_mdl->_query("SELECT 
                                            doc_43051.cama_id,
                                            paciente_info.pum_nss,
                                            os_triage.triage_nombre,
                                            doc_43051.fecha_asignacion,
                                            um_especialidades.especialidad_nombre,
                                            os_empleados.empleado_nombre,  /*Servicio y medico*/
                                            os_empleados.empleado_apellidos,
                                            paciente_info.pum_umf,
                                            doc_43051.diagnostico_presuntivo,
                                            paciente_info.pum_delegacion
                                        FROM 
                                            paciente_info,
                                            os_triage,
                                            doc_43051, 
                                            um_especialidades,
                                            os_empleados
                                        WHERE 
                                            paciente_info.triage_id                 = os_triage.triage_id and
                                            paciente_info.triage_id                 = doc_43051.triage_id and
                                            doc_43051.ingreso_servicio              = um_especialidades.especialidad_id and
                                            doc_43051.ingreso_medico                = os_empleados.empleado_id and
                                            STR_TO_DATE(doc_43051.fecha_asignacion, '%Y-%m-%d') = '" . $fecha . "'"); //2022-07-06
        foreach ($sql  as &$value) {
            if (is_numeric($value['diagnostico_presuntivo'])) {
                $value['diagnostico_presuntivo'] = $this->config_mdl->_query("SELECT cie10_nombre FROM um_cie10 WHERE cie10_id = " . $value['diagnostico_presuntivo'])[0]["cie10_nombre"];
            }
        }
        $this->setOutput(array(
            'num_rows' => count($sql),
            'sql' => $sql
        ));
    }

    public function AjaxPacientesFolio()
    {
        //$fechaInicial= $this->input->post('fechaInicial');
        //$fechaFinal= $this->input->post('fechaFinal');
        $Folio = $this->input->post('Folio');
        $tipoconsulta = $this->input->post('tipoconsulta');
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search = $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if ($tipoconsulta == 'preregistro') {
            $registros = $this->config_mdl->_query("SELECT * FROM doc_43051 INNER JOIN os_triage INNER JOIN paciente_info WHERE 
            doc_43051.triage_id     = os_triage.triage_id AND 
            doc_43051.triage_id     = paciente_info.triage_id AND
            doc_43051.triage_id     = $Folio");
        }
        $datos = array();
        if (!empty($registros)) {
            foreach ($registros  as $value) {
                $Medico = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
                    'empleado_id' => $value['ingreso_medico']
                ), 'empleado_nombre, empleado_apellidos')[0];
                $Servicio = $this->config_mdl->sqlGetDataCondition('um_especialidades', array(
                    'especialidad_id' => $value['ingreso_servicio']
                ), 'especialidad_nombre')[0];
                $camaInfo = $this->config_mdl->_get_data_condition('os_camas', array(
                    'cama_id' => $value['cama_id']
                ), 'cama_nombre')[0];
                $pisoInfo = $this->config_mdl->_get_data_condition('os_pisos', array(
                    'area_id' => $value['area_id']
                ))[0];
                if ($value['cama_id'] != '') {
                    $cama = $camaInfo['cama_nombre'] . '-' . $pisoInfo['piso_nombre_corto'];
                } else {
                    $cama = '<button type="button" id="asignarCama" data-cama="' . $value['triage_id'] . '">Por asignar</button>';
                }
                if ($this->UMAE_AREA == 'Asistente Médica Admisión Continua') {
                    $linkEditar = '<a href="' . base_url() . 'Asistentesmedicas/Hospitalizacion/Registro/' . $value['triage_id'] . '" target="_blank" 
                                        rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-title="Editar">
                                        <i class="fa fa-edit icono-accion"></i></a>';
                } else {
                    $linkEditar = '<a href="' . base_url() . 'Admisionhospitalaria/RegistrarPaciente/' . $value['triage_id'] . '" target="_self" 
                                        rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-title="Editar">
                                        <i class="fa fa-edit icono-accion"></i></a>';
                }
                //$imprimir43051 = '<a href="#" class="generar43051" data-triage="'.$value['triage_id'].'" ><i class="fa fa-print icono-accion icono-accion pointer tip" data-original-title="Requisitar Información 43051"></i></a>';
                $datos[] = array(
                    'triage_id'       => $value['triage_id'],
                    'fecha_ingreso'   => date('d-m-Y H:i', strtotime($value['fecha_ingreso'])),
                    'hora_ingreso'    => $value['hora_ingreso'],
                    'afiliacion'      => $value['pum_nss'] . ' ' . $value['pum_nss_agregado'],
                    'nombre'          => $value['triage_nombre_ap'] . ' ' . $value['triage_nombre_am'] . ' ' . $value['triage_nombre'],
                    'tipo_ingreso'    => $value['tipo_ingreso'],
                    'servicio'        => $Servicio['especialidad_nombre'],
                    'medico'          => $Medico['empleado_apellidos'] . ' ' . $Medico['empleado_nombre'],
                    'cama'            => $cama,
                    'accion'          => $linkEditar . ' '
                );
            }
            $total_pacientes = count($registros);
        }
        $output = array(
            'draw' => $draw,
            "recordsTotal" => $total_pacientes,
            "recordsFiltered" => $total_pacientes,
            'data' => $datos
        );
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    public function BuscarPaciente()
    {
        $this->load->view('BuscarPaciente');
    }

    public function BuscarPacienteDoc()
    {
        $inputSelect = $_POST['inputSelect'];
        $inputSearch = $_POST['inputSearch'];
        $IngresosEgr = $_POST['IngresosEgr'];
        $selectFecha = $_POST['selectFecha'];

        $tr = "";
        if ($inputSelect == 'POR_NUMERO') {
            $sql = $this->config_mdl->_query("SELECT os_triage.triage_id, doc_43051.fecha_ingreso, CONCAT_WS(' ',triage_nombre_ap,triage_nombre_am,triage_nombre) AS nombre_paciente, CONCAT_WS(' ',pum_nss,pum_nss_agregado) AS nss, pum_nss_armado FROM os_triage, paciente_info, doc_43051 WHERE
                                            paciente_info.triage_id = os_triage.triage_id AND
                                            doc_43051.triage_id     = os_triage.triage_id AND
                                            paciente_info.triage_id = '" . $inputSearch . "'");
        } else if ($inputSelect == 'POR_NOMBRE') {
            $sql =  $this->config_mdl->_query("SELECT os_triage.triage_id, paciente_info.triage_id, doc_43051.fecha_ingreso,CONCAT_WS(' ',TRIM(os_triage.triage_nombre_ap),TRIM(os_triage.triage_nombre_am),TRIM(os_triage.triage_nombre)) AS nombre_paciente, CONCAT_WS(' ',pum_nss,pum_nss_agregado) AS nss, pum_nss_armado FROM os_triage, paciente_info , doc_43051
                                            WHERE doc_43051.triage_id  = os_triage.triage_id
                                            HAVING os_triage.triage_id = paciente_info.triage_id AND nombre_paciente LIKE '%$inputSearch%' LIMIT 200");
        }else if ($inputSelect == 'POR_NSS') {
            $sql = $this->config_mdl->_query("SELECT os_triage.triage_id, doc_43051.fecha_ingreso, CONCAT_WS(' ',triage_nombre_ap,triage_nombre_am,triage_nombre) AS nombre_paciente, CONCAT_WS(' ',pum_nss,pum_nss_agregado) AS nss, pum_nss_armado FROM os_triage, paciente_info, doc_43051 WHERE
                                            paciente_info.triage_id = os_triage.triage_id AND
                                            doc_43051.triage_id     = os_triage.triage_id AND
                                            paciente_info.pum_nss   = '" . $inputSearch . "'");
        }else if ($inputSelect == 'POR_FECHA') {
            if ($selectFecha != ''){
                $sql = $this->config_mdl->_query("SELECT os_triage.triage_id, doc_43051.fecha_ingreso, CONCAT_WS(' ',triage_nombre_ap,triage_nombre_am,triage_nombre) AS nombre_paciente, CONCAT_WS(' ',pum_nss,pum_nss_agregado) AS nss, pum_nss_armado FROM os_triage, paciente_info, doc_43051 WHERE
                                                paciente_info.triage_id = os_triage.triage_id AND
                                                doc_43051.triage_id     = os_triage.triage_id AND
                                                doc_43051.".$IngresosEgr."= '" . $selectFecha . "'");
            }
        }
        if (!empty($sql)) {
            foreach ($sql as $value) {
                $nss = ($value['nss'] != ' ') ? $value['nss'] : $value['pum_nss_armado'];
                if ($this->UMAE_AREA == 'UCI') {
                    $tr .= '<tr>
                        <td>' . $value['triage_id'] . '</td>
                        <td>' . date("d-m-Y", strtotime($value['fecha_ingreso'])) . '</td>
                        <td>' . $value['nombre_paciente'] . '</td>
                        <td>' . $nss . '</td>
                        <td>
                             <div class="form-group">                             
                                <button class = "agregar-paciente" data-folio = ' . $value['triage_id'] . '>Agregar paciente</button>
                            </div>
                        </td>
                    <tr>';
                }else if ($this->UMAE_AREA == 'División de Calidad') {
                    $tr .= '<tr>
                        <td>' . $value['nombre_paciente'] . '</td>
                        <td>' . $value['triage_id'] . '</td>
                        <td>' . $nss . '</td>
                        <td>' . date("d-m-Y", strtotime($value['fecha_ingreso'])) . '</td>
                       
                        
                    <tr>';
                }
            }
            $this->setOutput(array('accion' => '1', 'tr' => $tr, 'sql' => $sql, "area" => $this->UMAE_AREA, "inputSearch" => $_POST['inputSearch'] ));
        } else {
            $tr .= '<tr> <td colspan="5" class="text-center mayus-bold"><i class="fa fa-frown-o fa-3x" style="color:#256659"></i><br>No se encontro ningún registro</td><tr>';
            $this->setOutput(array('accion' => '1', 'tr' => $tr, 'sql' => $sql, "area" => $this->UMAE_AREA, "inputSearch" => $_POST['inputSearch'] ));
        }
    }

    public function BuscarPacienteData()
    {
        $inputSearch = $_POST['inputSearch'];
        $sql = $this->config_mdl->_query("SELECT os_triage.triage_id, os_triage.triage_horacero_f, CONCAT_WS(' ',triage_nombre_ap,triage_nombre_am,triage_nombre) AS nombre_paciente, CONCAT_WS(' ',pum_nss,pum_nss_agregado) AS nss, pum_nss_armado FROM os_triage, paciente_info, doc_43051 WHERE
                                        paciente_info.triage_id = os_triage.triage_id AND
                                        doc_43051.triage_id     = os_triage.triage_id AND
                                        paciente_info.triage_id = '" . $inputSearch . "'");

        if (!empty($sql)) {
            $this->setOutput(array('accion' => '1', 'tr' => $sql[0]));
        } else {

            $this->setOutput(array('accion' => '2', 'tr' => $sql));
        }
    }

    public function AjaxGetPacienteUCI()
    {
        $sqlConsultorio = $this->config_mdl->_query("SELECT * FROM doc_43051, os_triage WHERE 
                                                    os_triage.triage_id = doc_43051.triage_id AND
                                                    os_triage.triage_id =" . $this->input->post('triage_id'));
        if (!empty($sqlConsultorio)) {
            $sqlPacienteUCI = $this->config_mdl->_query("SELECT * FROM um_pacientes_uci WHERE 
                                                    triage_id =" . $this->input->post('triage_id') . " AND fecha_egreso_uci IS NULL");
            if (empty($sqlPacienteUCI)) {
                $Interconsulta  = $this->config_mdl->_insert('um_pacientes_uci', array(
                    'id_doc43051'       => $sqlConsultorio[0]["id"],
                    "triage_id"         => $sqlConsultorio[0]["triage_id"],
                    "fecha_ingreso_uci" => date("Y-m-d H:i")
                ));
                $this->setOutput(array('accion' => 'ASIGNADO'));
            } else {
                $this->setOutput(array('accion' => 'EXIST'));
            }
        } else {
            $this->setOutput(array('accion' => 'NO_ASIGNADO'));
        }
    }

    public function AjaxDarDeAltaPacienteUCI()
    {
        $triage_id = $this->input->post('triage_id');
        $sqlConsultorio = $this->config_mdl->_query("SELECT * FROM doc_43051, os_triage WHERE 
                                                    os_triage.triage_id = doc_43051.triage_id AND
                                                    os_triage.triage_id =" . $triage_id);
        if (!empty($sqlConsultorio)) {
            $sqlPacienteUCI = $this->config_mdl->_query("SELECT TIMESTAMPDIFF( DAY, fecha_ingreso_uci, now()) AS dias_estancia_uci, paciente_uci_id
                                                          FROM  um_pacientes_uci 
                                                        WHERE  triage_id = " . $triage_id . " AND fecha_egreso_uci IS NULL");
            if (!empty($sqlPacienteUCI)) {
                $this->config_mdl->_update_data('um_pacientes_uci', array(
                    "dias_estancia_uci" => $sqlPacienteUCI[0]["dias_estancia_uci"],
                    "fecha_egreso_uci"  => date("Y-m-d H:i")
                ), array(
                    'paciente_uci_id' => $sqlPacienteUCI[0]["paciente_uci_id"],
                ));
                $this->setOutput(array('accion' => 'ALTA_HECHA', "dias_estancia_uci" => $sqlPacienteUCI,"fecha_egreso_uci"  => date("Y-m-d H:i")));
            } else {
                $this->setOutput(array('accion' => 'NO_EXIST'));
            }
        } else {
            $this->setOutput(array('accion' => 'NO_ASIGNADO'));
        }
    }

    /*Expediente*/
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
            // $sql['NotaIngresoHospital']= $this->config_mdl->_get_data_condition('um_notas_ingresos_hospitalario',array(
            //     'triage_id'=>$paciente
            // ));
            $sql['NotaIngresoHospital'] = $this->config_mdl->_query("SELECT * FROM um_notas_ingresos_hospitalario, os_empleados, um_especialidades, os_camas WHERE
            um_notas_ingresos_hospitalario.id_medico=os_empleados.empleado_id AND
            os_empleados.empleado_servicio=um_especialidades.especialidad_id AND
            os_camas.triage_id=um_notas_ingresos_hospitalario.triage_id AND
            um_notas_ingresos_hospitalario.triage_id=" . $paciente . " ORDER BY fecha_elabora DESC");
        }
        if ($_GET['tipo'] == 'UCI') {
            $sql['PacientesUCI'] = $this->config_mdl->_get_data_condition('um_pacientes_uci', array(
                'triage_id' => $paciente
            ));
        }

        $sql['HojasFrontales'] = $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' => $paciente
        ));

        $sql['Notas'] = $this->config_mdl->_get_data_condition('doc_notas', array(
            'triage_id' => $paciente
        ));

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
    public function getPacienteUCI(){
        $triage_id  = $_POST["triage_id"];
        $paciente   = $this->config_mdl->_query('SELECT * FROM um_pacientes_uci WHERE fecha_egreso_uci IS NULL AND triage_id ='.$triage_id);
        if (empty($paciente)) {
            $this->setOutput(array('accion' => 'NOT_EXIST', 'paciente' => $paciente, 'triage_id' => $triage_id));
        }else{
            $this->setOutput(array('accion' => 'EXIST', 'paciente' => $paciente));
        }
    } 
}
