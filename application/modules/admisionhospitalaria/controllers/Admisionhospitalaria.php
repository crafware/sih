<?php

/**
 * Description of AdmisionHospitalaria
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
include_once APPPATH.'modules/config/controllers/Config.php';

class Admisionhospitalaria extends Config{

  public function __construct() {
    parent::__construct();
  }

  public function AdmisionContinua() {
    $this->load->view('index', $sql);
  }

  public function AjaxPacientes() {
    //$fechaInicial= $this->input->post('fechaInicial');
    //$fechaFinal= $this->input->post('fechaFinal');
    $fecha = $this->input->post('fecha');
    $fecha_ingreso = date('Y-m-d', strtotime($fecha));
    $tipoconsulta = $this->input->post('tipoconsulta');
    $draw = intval($this->input->post("draw"));
    $start = intval($this->input->post("start"));
    $length = intval($this->input->post("length"));
    $order = $this->input->post("order");
    $search= $this->input->post("search");
    $search = $search['value'];
    $col = 0;
    $dir = "";

    if($tipoconsulta == 'preregistro' ) {
        $registros= $this->config_mdl->_query("SELECT * FROM doc_43051 INNER JOIN os_triage INNER JOIN paciente_info WHERE 
        doc_43051.triage_id = os_triage.triage_id AND 
        doc_43051.triage_id=paciente_info.triage_id AND
        doc_43051.fecha_ingreso = '$fecha_ingreso'"); 
    }else {
        $registros= $this->config_mdl->_query("SELECT * FROM doc_43051 INNER JOIN os_triage INNER JOIN paciente_info WHERE 
        doc_43051.triage_id = os_triage.triage_id AND 
        doc_43051.triage_id=paciente_info.triage_id AND
        doc_43051.estado_cama = 'En espera' AND
        doc_43051.fecha_ingreso BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY doc_43051.fecha_ingreso DESC LIMIT 150"); 
    }
    
    $datos=array();
        if(!empty($registros)) {
            foreach ($registros  as $value) {
                $Medico=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                     'empleado_id'=>$value['ingreso_medico']),'empleado_nombre, empleado_apellidos')[0];

                $Servicio=$this->config_mdl->sqlGetDataCondition('um_especialidades',array(
                    'especialidad_id'=>$value['ingreso_servicio']),'especialidad_nombre')[0];

                $camaInfo=$this->config_mdl->_get_data_condition('os_camas', array(
                    'cama_id' => $value['cama_id']),'cama_nombre')[0]; 

                $pisoInfo=$this->config_mdl->_get_data_condition('os_pisos', array(
                    'area_id' => $value['area_id']))[0];

                if($value['cama_id'] !='' || $value['cama_id'] != 0){
                    $cama= $camaInfo['cama_nombre'].'-'.$pisoInfo['piso_nombre_corto'];
                    
                }else{                    
                                            
                    $cama='<button type="button" id="asignarCama" data-folio="'.$value['triage_id'].'">Por asignar</button>';
                }
            
                if($this->UMAE_AREA == 'Asistente Médica Admisión Continua'){
                    $linkEditar= '<a href="'.base_url().'Asistentesmedicas/Hospitalizacion/Registro/'.$value['triage_id'].'" target="_blank" 
                                    rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-title="Editar">
                                    <i class="fa fa-edit icono-accion"></i></a>';
                }else {
                    $linkEditar= '<a href="'.base_url().'Admisionhospitalaria/RegistrarPaciente/'.$value['triage_id'].'" target="_self" 
                                    rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-title="Editar">
                                    <i class="fa fa-edit icono-accion"></i></a>';
                }

                $imprimir43051 = '<a href="#" class="generar43051" data-triage="'.$value['triage_id'].'" ><i class="fa fa-print icono-accion icono-accion pointer tip" data-original-title="Requisitar Información 43051"></i></a>';
                
                $datos[] = array(
                                'triage_id'       => $value['triage_id'],
                                'fecha_ingreso'   => date('d-m-Y H:i', strtotime($value['fecha_ingreso'])),
                                'hora_ingreso'    => $value['hora_ingreso'],
                                'afiliacion'      => $value['pum_nss'].' '.$value['pum_nss_agregado'],
                                'nombre'          => $value['triage_nombre_ap'].' '.$value['triage_nombre_am'].' '.$value['triage_nombre'],
                                'tipo_ingreso'    => $value['tipo_ingreso'],
                                'servicio'        => $Servicio['especialidad_nombre'],
                                'medico'          => $Medico['empleado_apellidos'].' '.$Medico['empleado_nombre'],
                                'cama'            => $cama,
                                'accion'          => $linkEditar.' '.$imprimir43051
                            ); 
            }
             //$this->setOutput(array('accion'=>'1','tr'=>$tr));
            $total_pacientes = count($registros);
        }

        $output = array(
                        'draw' => $draw,
                        "recordsTotal" => $total_pacientes,
                        "recordsFiltered" => $total_pacientes,
                        'data' => $datos
        );
        //$this->output->set_header('Content-Type: application/json');
        $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output)); 
        //echo json_encode($datos);
        //$this->output->set_output(json_encode($datos));
        //$this->setOutput(array('data'=>$datos));    

    }

    public function TableroCamas() {
        $sql['Especialidades'] = $this->config_mdl->_query('SELECT * FROM um_especialidades WHERE especialidad_hospitalizacion = 1 ORDER BY especialidad_nombre ASC');
        $this->load->view('TableroCamas',$sql);
    }
   
  
    public function TotalCamasEstatusPisos($Piso,$Estado) {
        return count($this->config_mdl->_query("SELECT os_camas.cama_id FROM os_camas, os_areas, os_pisos, os_pisos_camas
                                            WHERE os_areas.area_id=os_camas.area_id AND os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_camas.cama_estado='$Estado' AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id AND os_pisos.piso_id=".$Piso));        
    }
    public function TotalCamasEstatus($Estado) {
        return count($this->config_mdl->_query("SELECT os_camas.cama_id FROM os_camas, os_areas, os_pisos, os_pisos_camas
                                            WHERE os_areas.area_id=os_camas.area_id AND os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_camas.cama_estado='$Estado' AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id"));
        
    }

    public function TotalPorPiso($piso_id) {
        return count($this->config_mdl->_query("SELECT os_camas.cama_id FROM os_camas, os_areas, os_pisos, os_pisos_camas
                                            WHERE os_areas.area_id=os_camas.area_id 
                                            AND os_pisos_camas.cama_id=os_camas.cama_id 
                                            AND os_pisos_camas.piso_id=os_pisos.piso_id 
                                            AND os_pisos.piso_id=".$piso_id));
    }

    public function AjaxVisorCamas()
    {
        $Pisos = $this->config_mdl->_query("SELECT * FROM os_pisos");
        $Col = '';
        $TotalDisponibles   = $this->TotalCamasEstatus('Disponible');
        $TotalOcupadas      = $this->TotalCamasEstatus('Ocupado');
        $TotalReservadas    = $this->TotalCamasEstatus('Reservada');
        $TotalSucias        = $this->TotalCamasEstatus('Sucia');
        $TotalContaminadas  = $this->TotalCamasEstatus('Contaminada');
        $TotalLimpias       = $this->TotalCamasEstatus('Limpia');
        $TotalDescompuestas = $this->TotalCamasEstatus('Descompuesta');
        $TotalReparadas     = $this->TotalCamasEstatus('Reparada');
        $Col .= '<div class="tablero">
                <div id="bead-map" >';
        $Notas = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 0");
        $NotasDes = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 1");
        foreach ($Pisos as $value) {
            $Camas = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas, os_pisos, os_pisos_camas, os_pisos_sc WHERE 
            os_areas.area_id        =os_camas.area_id AND 
            os_pisos_camas.cama_id  =os_camas.cama_id AND
            os_pisos_camas.piso_id  =os_pisos.piso_id AND 
            os_pisos_sc.cama_id     =os_camas.cama_id AND 
            os_pisos.piso_id        =" . $value['piso_id']);
            $Disponibles = $this->TotalCamasEstatusPisos($value['piso_id'], 'Disponible'); //Esta Vestida
            $Ocupadas = $this->TotalCamasEstatusPisos($value['piso_id'], 'Ocupado');
            $TotalPiso = $this->TotalPorPiso($value['piso_id']);
            $nombrePiso = '<li><h4 class="text-center link-acciones bold">'.$value["piso_nombre"].'</h4></li>';
            $ReportePiso = '<li><a href="#" class="ReportePiso"  data-piso="'.$value["area_id"].'"><i class="fa fa-share-square-o icono-accion"></i> Reporte por piso</a></li>';
            $ReporteEspe = '<li><a href="#" class="ReporteEspe" data-pisoname="'.$value["piso_nombre"].'"><i class="fa fa-share-square-o icono-accion"></i> Reporte por especialidad</a></li>';
            $ReportesPisos = '<div style="float: left;"> 
                                <ul class="list-inline list-menu">
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-file-text-o icono-accion ttip" data-toggle="tooltip" data-placement="left" title="Ver estado de salud"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -215px">' .$nombrePiso. ' ' .$ReportePiso. ' ' .$ReporteEspe. '</ul>
                                    </li>
                                </ul>
                            </div>';
            $Col .= '<div class="container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="bedCharts-space text-left">
                        <span style="font-weight: bold">' . $value['piso_nombre_corto'] . '</span>
                        <span class="infoPisoTotal">Total:' . $TotalPiso . '</span>
                        <span class="infoPisoDisponibles">Disponibles: ' . $Disponibles . '</span>
                        <span class="infoPisoOcupadas" style="padding-left: 50px">Ocupadas: ' . $Ocupadas . '</span>
                        <span style="float:right;">' . $ReportesPisos . '</span>
                    </div>  
                    <div class="container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12 rowCamas">';

            foreach ($Camas as $valor) {
                $InfectadoColor = '';
                $Accion = '';
                $tiempoIntervalo = '';
                $dataTitle = '';

                $info43051 = $this->config_mdl->_get_data_condition('doc_43051', array('triage_id' => $valor['triage_id']))[0];

                /* Acciones para el popup*/
                $nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' . $valor['cama_nombre'] . '</h5></li>';

                $CambiarCama = '<li><a href="#" class="cambiar-cama-paciente" data-id="' . $info43051['triage_id'] . '" data-area="' . $valor['area_id'] . '" data-cama="' . $valor['cama_nombre'] . '" data-cama-id="' . $valor['cama_id'] . '" data-sexo="' . $valor['cama_genero'] . '"><i class="fa fa-bed icono-accion"></i> Cambiar Cama</a></li>';

                $Imprimir43051 = '<li><a href="#" class="generar43051" data-triage="' . $info43051['triage_id'] . '" data-cama="' . $valor['cama_id'] . '"><i class="fa fa-print icono-accion"></i> Imprimir 43051</a></li>';

                $CancelarIngreso = '<li><a href="#" class="cancelar43051" data_triage="' . $info43051['triage_id'] . '" data-cama="' . $valor['cama_id'] . '"><i class="fa fa-ban icono-accion"></i> Cancelar Ingreso</a></li>';

                $LiberarCama = '<li><a href="#" class="liberar43051" data-triage="' . $info43051['triage_id'] . '" data-cama="' . $valor['cama_id'] . '" data-camanombre="' . $valor['cama_nombre'] . '"><i class="fa fa-share-square-o icono-accion"></i> Liberar Cama</a></li>';

                $OcuparCama = '<li><a href="#" class="ocuparCama" data-triage="' . $info43051['triage_id'] . '" data-cama="' . $valor['cama_id'] . '" data-camanombre="' . $valor['cama_nombre'] . '"><i class="fa fa-bed icono-accion"></i>  Ocupar cama</a></li>';

                $AltaPaciente = '<li><a class="alta-paciente" data-area="' . $valor['area_id'] . '" data-cama="' . $valor['cama_id'] . '" data-triage="' . $info43051['triage_id'] . '"><i class="fa fa-id-badge icono-accion"></i> Alta Paciente</a></li>';

                $PisoMombreCorto = "";
                /* Acciones de sobre la cama asignada */

                if ($valor['cama_estado'] == 'Disponible') { //vestida-color verde
                    $CamaStatus = 'green';
                    $Estado = 'Disponible';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Sucia') { // sucia-color negro
                    $CamaStatus = 'grey-900';
                    $Estado = 'Sucia';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Limpia') { //Limpia
                    $CamaStatus = 'cyan-400';

                    $Estado = 'Limpia';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Descompuesta') { // descompuesta -Amarilla
                    $CamaStatus = 'yellow-600';
                    $Estado = 'Descompuesta';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Reparada') { // Reparada 
                    $CamaStatus = 'lime';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Ocupado') {  // Ocupado-Azul Hombre                
                    $Estado = 'Ocupado';
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

                    if ($this->UMAE_AREA === 'Admisión Hospitalaria') {
                        $acciones = '<ul class="list-inline list-menu">
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bed"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' . $nombreCama . ' ' . $CambiarCama . ' ' . $Imprimir43051 . ' ' . $AltaPaciente . '</ul>
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
                                        <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' . $nombreCama . ' ' . $Imprimir43051 . ' ' . $LiberarCama . ' ' . $OcuparCama . '</ul>
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

                $Col .= '<div class="contenedor fila ' . $borde . '">
                        <div id="proceso" style="color: ' . $color . ';"><strong><center>' . $proceso . '</center></strong></div>
                        <div id="' . $valor['cama_id'] . "_" . $PisoMombreCorto . '" rel="tooltip" class="cama-no cama-celda ' . $CamaStatus . ' color-white cama' . $valor['cama_id'] . '" "  data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso . '" data-toggle="tooltip" data-trigger="hover"
                            data-placement="top" data-html="true">
                            ' . $acciones . '
                            <h6 style="margin-top: 3px; color:black"><b>' . $valor['cama_nombre'] . '</b></h6>
                            <div class="tooltip" id="tooltip' . $valor['cama_id'] . "_" . $PisoMombreCorto . '">
                                <div>
                                    <h3 class="titulo">Torre Eiffel</h3>
                                    <p class="direccion">' . $valor['cama_id'] . "_" . $PisoMombreCorto . '</p>
                                    <p class="resumen">
                                    ' . $valor['cama_id'] . "_" . $PisoMombreCorto . '<br />
                                    </p>
                                    <div class="contenedor-btn">
                                        <button>Comprar Boletos</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                $NotasLen = 0;
                foreach ($Notas as $Nota) {
                    if ($Nota["cama_id"] == $valor['cama_id']) {
                        $NotasLen += 1;
                    }
                }
                if ($NotasLen > 0) { $Op = 1;}else{$Op = 0;}
                $NotasLenDes = 0;
                foreach ($NotasDes as $Nota) {
                    if ($Nota["cama_id"] == $valor['cama_id']) {
                        $NotasLenDes += 1;
                    }
                }
                if ($NotasLenDes > 0) { $OpDes = 1;}else{$OpDes = 0;}
                $Col .=     '<div id = "nota_' . $valor['cama_id'] . '" class="notificacion-nota pointer" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $Op . '"><p>' . "$NotasLen" . '</p></div>
                         <div id = "nota_des_' . $valor['cama_id'] . '" class="notificacion-nota-des pointer" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $OpDes . '"><p>' . "$NotasLenDes" . '</p></div>
                    </div>';
            } //cierre foreach ($Camas as $value)


            $Col .= '</div>'; // cierre de div class="panel panel-default"
            $Col .= '</div>'; // cierre de div class="panel panel-default"

            //$Col.=$modal;
        } // cierre de foreach ($Pisos as $value) 

        $Col .= '<script src="' . base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?') . md5(microtime()) . '" type="text/javascript"></script>';
        $this->setOutput(array(
            'accion' => '1',
            'Col'                => $Col,
            'TotalDisponibles'   => $TotalDisponibles,
            'TotalOcupadas'      => $TotalOcupadas,
            'TotalReservadas'    => $TotalReservadas,
            'TotalSucias'        => $TotalSucias,
            'TotalContaminadas'  => $TotalContaminadas,
            'TotalLimpias'       => $TotalLimpias,
            'TotalDescompuestas' => $TotalDescompuestas,
            'TotalReparadas'     => $TotalReparadas,
            'PorcentajeOcupacion' => round(($TotalOcupadas / $TotalDisponibles) * 100, 2) . ' ' . '%'
        ));
    } //cierre de funcion AjaxvisorCamas

    public function AjaxvisorCamasDivisionDeCalidad()
    {
        $Pisos = $this->config_mdl->_query("SELECT * FROM os_pisos");
        $Col = '';
        $TotalDisponibles   = $this->TotalCamasEstatus('Disponible');
        $TotalOcupadas      = $this->TotalCamasEstatus('Ocupado');
        $TotalReservadas    = $this->TotalCamasEstatus('Reservada');
        $TotalSucias        = $this->TotalCamasEstatus('Sucia');
        $TotalContaminadas  = $this->TotalCamasEstatus('Contaminada');
        $TotalLimpias       = $this->TotalCamasEstatus('Limpia');
        $TotalDescompuestas = $this->TotalCamasEstatus('Descompuesta');
        $TotalReparadas     = $this->TotalCamasEstatus('Reparada');
        $Col .= '<div class="tablero">
                    <div id="bead-map" >';
        $Notas = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 0");
        $NotasDes = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 1");
        foreach ($Pisos as $value) {
            $Camas = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas, os_pisos, os_pisos_camas, os_pisos_sc WHERE 
                os_areas.area_id        =os_camas.area_id AND 
                os_pisos_camas.cama_id  =os_camas.cama_id AND
                os_pisos_camas.piso_id  =os_pisos.piso_id AND 
                os_pisos_sc.cama_id     =os_camas.cama_id AND 
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

            foreach ($Camas as $valor) {
                $tiempoIntervalo = '';

                $info43051 = $this->config_mdl->_get_data_condition('doc_43051', array('triage_id' => $valor['triage_id']))[0];
                /* Acciones para el popup*/
                $nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' . $valor['cama_nombre'] . '</h5></li>';
                $LiberarCama = '<li><a href="#" class="liberar43051" data-triage="' . $info43051['triage_id'] . '" data-cama="' . $valor['cama_id'] . '" data-camanombre="' . $valor['cama_nombre'] . '"><i class="fa fa-share-square-o icono-accion"></i> Liberar Cama</a></li>';
                $PisoMombreCorto = "";
                /* Acciones de sobre la cama asignada */

                if ($valor['cama_estado'] == 'Disponible') { //vestida-color verde
                    $CamaStatus = 'green';
                    $Estado = 'Disponible';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Sucia') { // sucia-color negro
                    $CamaStatus = 'grey-900';
                    $Estado = 'Sucia';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Limpia') { //Limpia
                    $CamaStatus = 'cyan-400';

                    $Estado = 'Limpia';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Descompuesta') { // descompuesta -Amarilla
                    $CamaStatus = 'yellow-600';
                    $Estado = 'Descompuesta';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Reparada') { // Reparada 
                    $CamaStatus = 'lime';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if (($valor['cama_estado'] == 'Ocupado') || ($valor['cama_estado'] == 'Reservada')) {  // Ocupado-Azul Hombre                
                    if ($valor['cama_genero'] == 'HOMBRE') {
                        $CamaStatus = 'blue-800';
                    } else if ($valor['cama_genero'] == 'MUJER') { // Ocupado-Rosa Mujer
                        $CamaStatus = 'pink-A100';
                    }
                    if ($valor['cama_estado'] == 'Reservada') {  // Color Morado  Reservada
                        $CamaStatus = 'purple-300';
                    }

                    $tiempoOcupado = Modules::run('Config/CalcularTiempoTranscurrido', array(
                        'Tiempo1' => $valor['cama_fh_estatus'],
                        'Tiempo2' => date('Y-m-d H:i:s')
                    ));
                    $tiempoIntervalo .= $tiempoOcupado->format('%a Dias');
                    $ExpedienteLink = '<li><a href="'.base_url('/Sections/Documentos/Expediente/' . $info43051['triage_id'] .'/?tipo=Hospitalizacion').'" target="_blank"><i class="fa fa-share-square-o icono-accion"></i>Ver expediente</a></li>';
                    $acciones = '<ul class="list-inline list-menu">
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bed"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' . $nombreCama . ' '/*.$CambiarCama.' '.$AltaPaciente.' '*/ . $ExpedienteLink . '</ul>
                                    </li>
                                </ul>';
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

                $Col .= '<div class="contenedor fila ' . $borde . '">
                            <div id="proceso" style="color: ' . $color . ';"><strong><center>' . $proceso . '</center></strong></div>
                            <div id="' . $valor['cama_id'] . "_" . $PisoMombreCorto . '" rel="tooltip" class="cama-no cama-celda ' . $CamaStatus . ' color-white cama' . $valor['cama_id'] . '" "  data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso . '" data-toggle="tooltip" data-trigger="hover"
                                data-placement="top" data-html="true">
                                ' . $acciones . '
                                <h6 style="margin-top: 3px; color:black"><b>' . $valor['cama_nombre'] . '</b></h6>
                                <div class="tooltip" id="tooltip' . $valor['cama_id'] . "_" . $PisoMombreCorto . '">
                                    <div>
                                        <h3 class="titulo">Torre Eiffel</h3>
                                        <p class="direccion">' . $valor['cama_id'] . "_" . $PisoMombreCorto . '</p>
                                        <p class="resumen">
                                        ' . $valor['cama_id'] . "_" . $PisoMombreCorto . '<br />
                                        </p>
                                        <div class="contenedor-btn">
                                            <button>Comprar Boletos</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                $NotasLen = 0;
                foreach ($Notas as $Nota) {
                    if ($Nota["cama_id"] == $valor['cama_id']) {
                        $NotasLen += 1;
                    }
                }
                if ($NotasLen > 0) { $Op = 1;}else{$Op = 0;}
                $NotasLenDes = 0;
                foreach ($NotasDes as $Nota) {
                    if ($Nota["cama_id"] == $valor['cama_id']) {
                        $NotasLenDes += 1;
                    }
                }
                if ($NotasLenDes > 0) { $OpDes = 1;}else{$OpDes = 0;}
                $Col .=     '<div id = "nota_' . $valor['cama_id'] . '" class="notificacion-nota" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $Op . '"><p>' . "$NotasLen" . '</p></div>
                         <div id = "nota_des_' . $valor['cama_id'] . '" class="notificacion-nota-des" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $OpDes . '"><p>' . "$NotasLenDes" . '</p></div>
                    </div>';
            } //cierre foreach ($Camas as $value)


            $Col .= '</div>'; // cierre de div class="panel panel-default"
            $Col .= '</div>'; // cierre de div class="panel panel-default"

            //$Col.=$modal;
        } // cierre de foreach ($Pisos as $value) 

        $Col .= '<script src="' . base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?') . md5(microtime()) . '" type="text/javascript"></script>';
        $this->setOutput(array(
            'accion' => '1',
            'Col'                => $Col,
            'TotalDisponibles'   => $TotalDisponibles,
            'TotalOcupadas'      => $TotalOcupadas,
            'TotalReservadas'    => $TotalReservadas,
            'TotalSucias'        => $TotalSucias,
            'TotalContaminadas'  => $TotalContaminadas,
            'TotalLimpias'       => $TotalLimpias,
            'TotalDescompuestas' => $TotalDescompuestas,
            'TotalReparadas'     => $TotalReparadas,
            'PorcentajeOcupacion' => round(($TotalOcupadas / $TotalDisponibles) * 100, 2) . ' ' . '%'
        ));
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
                    </div>';
        $Notas = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 0");
        $NotasDes = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 1");
        foreach ($Camas as $valor) {
            $InfectadoColor = '';
            $Accion = '';
            $tiempoIntervalo = '';
            $dataTitle = '';

            $info43051 = $this->config_mdl->_get_data_condition('doc_43051', array('triage_id' => $valor['triage_id']))[0];
            /* Acciones para el popup*/
            $nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' . $valor['cama_nombre'] . '</h5></li>';
            $CambiarCama = '<li><a href="#" class="cambiar-cama-paciente" data-id="' . $info43051['triage_id'] . '" data-area="' . $valor['area_id'] . '" data-cama="' . $valor['cama_nombre'] . '" data-cama-id="' . $valor['cama_id'] . '" data-sexo="' . $valor['cama_genero'] . '"><i class="fa fa-bed icono-accion"></i> Cambiar Cama</a></li>';
            $Imprimir43051 = '<li><a href="#" class="generar43051" data-triage="' . $info43051['triage_id'] . '" data-cama="' . $valor['cama_id'] . '"><i class="fa fa-print icono-accion"></i> Imprimir 43051</a></li>';
            $CancelarIngreso = '<li><a href="#" class="cancelar43051" data_triage="' . $info43051['triage_id'] . '" data-cama="' . $valor['cama_id'] . '"><i class="fa fa-ban icono-accion"></i> Cancelar Ingreso</a></li>';
            $LiberarCama = '<li><a href="#" class="liberar43051" data-triage="' . $info43051['triage_id'] . '" data-cama="' . $valor['cama_id'] . '" data-camanombre="' . $valor['cama_nombre'] . '"><i class="fa fa-share-square-o icono-accion"></i> Liberar Cama</a></li>';
            $AltaPaciente = '<li><a class="alta-paciente" data-area="' . $valor['area_id'] . '" data-cama="' . $valor['cama_id'] . '" data-triage="' . $info43051['triage_id'] . '"><i class="fa fa-id-badge icono-accion"></i> Alta Paciente</a></li>';
            /* Acciones de sobre la cama asignada */

            if ($valor['cama_estado'] == 'Disponible') { //vestida-color verde
                $CamaStatus = 'green';

                $Estado = 'Disponible';
                $acciones = '<i class="fa fa-bed"></i>';
            } else if ($valor['cama_estado'] == 'Sucia') { // sucia-color negro
                $CamaStatus = 'grey-900';

                $Estado = 'Sucia';
                $acciones = '<i class="fa fa-bed"></i>';
            } else if ($valor['cama_estado'] == 'Limpia') { //Limpia
                $CamaStatus = 'cyan-400';

                $Estado = 'Limpia';
                $acciones = '<i class="fa fa-bed"></i>';
            } else if ($valor['cama_estado'] == 'Descompuesta') { // descompuesta -Amarilla
                $CamaStatus = 'yellow-600';
                $Estado = 'Descompuesta';
                $acciones = '<i class="fa fa-bed"></i>';
            } else if ($valor['cama_estado'] == 'Reparada') { // Reparada 
                $CamaStatus = 'lime';
                $acciones = '<i class="fa fa-bed"></i>';
            } else if ($valor['cama_estado'] == 'Ocupado') {  // Ocupado-Azul Hombre

                $Estado = 'Ocupado';
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

                if ($this->UMAE_AREA === 'UCI') {
                    $acciones = '<ul class="list-inline list-menu">
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bed"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' . $nombreCama . ' ' . $CambiarCama . ' ' . $Imprimir43051 . ' ' . $AltaPaciente . '</ul>
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
                                    <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' . $nombreCama . ' ' . $Imprimir43051 . ' ' . $LiberarCama . ' </ul>
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
            $PisoMombreCorto = "";
            $Col .= '<div class="contenedor fila ' . $borde . '">
                        <div id = "proceso" style="color: ' . $color . ';"><strong><center>' . $proceso . '</center></strong></div>
                            <div id="' . $valor['cama_id'] . "_" . $PisoMombreCorto . '" rel="tooltip" class="cama-no cama-celda ' . $CamaStatus . ' color-white cama' . $valor['cama_id'] . '" "  data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso . '" data-toggle="tooltip" data-trigger="hover"
                            data-placement="top" data-html="true">
                            ' . $acciones . '
                            <h6 style="margin-top: 3px; color:black"><b>' . $valor['cama_nombre'] . '</b></h6>
                            <div class="tooltip" id="tooltip' . $valor['cama_id'] . "_" . $PisoMombreCorto . '">
                            </div>
                        </div>
                    </div>';
            $NotasLen = 0;
            foreach ($Notas as $Nota) {
                if ($Nota["cama_id"] == $valor['cama_id']) {
                    $NotasLen += 1;
                }
            }
            if ($NotasLen > 0) { $Op = 1;}else{$Op = 0;}
            $NotasLenDes = 0;
            foreach ($NotasDes as $Nota) {
                if ($Nota["cama_id"] == $valor['cama_id']) {
                    $NotasLenDes += 1;
                }
            }
            if ($NotasLenDes > 0) { $OpDes = 1;}else{$OpDes = 0;}
            $Col .=     '<div id = "nota_' . $valor['cama_id'] . '" class="notificacion-nota" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $Op . '"><p>' . "$NotasLen" . '</p></div>
                    <div id = "nota_des_' . $valor['cama_id'] . '" class="notificacion-nota-des" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $OpDes . '"><p>' . "$NotasLenDes" . '</p></div>
                </div>';
        } //cierre foreach ($Camas as $value)

        $Col .= '</div>'; // cierre de div class="panel panel-default"
        $Col .= '<script src="' . base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?') . md5(microtime()) . '" type="text/javascript"></script>';

        $this->setOutput(array(
            'accion' => '1',
            'Col'                => $Col,
        ));
    } //cierre de funcion AjaxvisorCamasUCI


    public function AjaxvisorCamasDireccionEnfermeria()
    {
        $Pisos = $this->config_mdl->_query("SELECT * FROM os_pisos");
        $Col = '';
        $TotalDisponibles   = $this->TotalCamasEstatus('Disponible');
        $TotalOcupadas      = $this->TotalCamasEstatus('Ocupado');
        $TotalReservadas    = $this->TotalCamasEstatus('Reservada');
        $TotalSucias        = $this->TotalCamasEstatus('Sucia');
        $TotalContaminadas  = $this->TotalCamasEstatus('Contaminada');
        $TotalLimpias       = $this->TotalCamasEstatus('Limpia');
        $TotalDescompuestas = $this->TotalCamasEstatus('Descompuesta');
        $TotalReparadas     = $this->TotalCamasEstatus('Reparada');
        $SemaforoColores    = array(
            array("", "", ""),
            array("yellow", "", ""),
            array("yellow", "yellow", ""),
            array("yellow", "yellow", "yellow")
        );
        $Col .= '<div class="tablero">
                    <div id="bead-map" >';
        $Notas = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 0");
        $NotasDes = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 1");
        foreach ($Pisos as $value) {
            $Camas = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas, os_pisos, os_pisos_camas, os_pisos_sc WHERE 
                os_areas.area_id        =os_camas.area_id AND 
                os_pisos_camas.cama_id  =os_camas.cama_id AND
                os_pisos_camas.piso_id  =os_pisos.piso_id AND 
                os_pisos_sc.cama_id     =os_camas.cama_id AND 
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

            foreach ($Camas as $valor) {
                $tiempoIntervalo = '';
                $info43051 = $this->config_mdl->_get_data_condition('doc_43051', array('triage_id' => $valor['triage_id']))[0];
                /* Acciones para el popup*/
                $nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' . $valor['cama_nombre'] . '</h5></li>';
                /* Acciones de sobre la cama asignada */
                $acciones = "";
                $CamaCeldaSemaforo = "";
                if ($valor['cama_estado'] == 'Disponible') { //vestida-color verde
                    $CamaStatus = 'green';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Sucia') { // sucia-color negro
                    $CamaStatus = 'grey-900';
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
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Reservada') {  // Color Morado  Reservada
                    $CamaStatus = 'purple-300';
                    $tiempoEspera = Modules::run('Config/CalcularTiempoTranscurrido', array(
                        'Tiempo1' => $info43051['ac_fecha_asignacion'],
                        'Tiempo2' => date('Y-m-d H:i:s')
                    ));
                    $tiempoIntervalo .= $tiempoEspera->format('%h:%i min');
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Contaminada') {   // Contaminada
                    $CamaStatus = 'red';
                    $Estado = 'Limpia';
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

                if ($valor['cama_estado'] == 'Sucia' || $valor['cama_estado'] == 'Contaminada') {
                    $CamaCeldaSemaforo = $valor['cama_display'];
                    $ConfirmarLimpieza = '<li><a href="#" class="confirmar-Limpieza" ' . '" data-cama="' . $valor['cama_id'] . '" data-cama-id="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso  . '"><i class="fa fa-bed icono-accion"></i> Confirmar limpieza</a></li>';
                    $AgregarNota = '<li><a href="#" class="nota-cama" ' . '" data-cama="' . $valor['cama_id'] . '" data-cama-id="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso  . '"><i class="fa fa-file-text-o icono-accion"></i> Agregar nota</a></li>';
                    $CamaCeldaSemaforo_int = 4 - intval($CamaCeldaSemaforo);
                    if ($CamaCeldaSemaforo_int <= 3) {
                        $CambiarEstadoSemaforo = '<li><a href="#" class="cambiar-estado-semaforo" ' . '" data-cama="' . $valor['cama_id'] . '" data-cama-id="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-semaforo="' . $CamaCeldaSemaforo  . '"><i class="fa fa-bed icono-accion"></i> Confirmar limpieza No.' . $CamaCeldaSemaforo_int . '</a></li>';
                    } else {
                        $CambiarEstadoSemaforo = "";
                    }
                    $acciones = '<ul class="list-inline list-menu">
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bed"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' . $nombreCama . ' ' . $ConfirmarLimpieza . ' ' . $CambiarEstadoSemaforo . ' </ul>
                                    </li>
                                </ul>';
                }
                $Col .= '<div class="contenedor fila ' . $borde . '">
                            <div id="proceso" style="color: ' . $color . ';">
                                <div id="' . $valor['cama_id'] . "_semaforo_0" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][0] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>
                                <div id="' . $valor['cama_id'] . "_semaforo_1" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][1] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>
                                <div id="' . $valor['cama_id'] . "_semaforo_2" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][2] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>                    
                                <strong>
                                    <center>' . $proceso . '</center>
                                </strong>
                            </div>
                            <div id="' . $valor['cama_id'] . "_" . '" rel="tooltip" class="cama-no cama-celda ' . $CamaStatus . ' color-white cama' . $valor['cama_id'] . '" "  data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso . '" data-toggle="tooltip" data-trigger="hover"
                            data-placement="top" data-html="true">
                            ' . $acciones . '
                                <h6 style="margin-top: 3px; color:black"><b>' . $valor['cama_nombre'] . '</b></h6>
                                <div class="tooltip" id="tooltip' . $valor['cama_id'] . "_" . '">
                                </div>
                            </div>';
                $NotasLen = 0;
                foreach ($Notas as $Nota) {
                    if ($Nota["cama_id"] == $valor['cama_id']) {
                        $NotasLen += 1;
                    }
                }
                if ($NotasLen > 0) { $Op = 1;}else{$Op = 0;}
                $NotasLenDes = 0;
                foreach ($NotasDes as $Nota) {
                    if ($Nota["cama_id"] == $valor['cama_id']) {
                        $NotasLenDes += 1;
                    }
                }
                if ($NotasLenDes > 0) { $OpDes = 1;}else{$OpDes = 0;}
                $Col .=     '<div id = "nota_' . $valor['cama_id'] . '" class="notificacion-nota" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $Op . '"><p>' . "$NotasLen" . '</p></div>
                        <div id = "nota_des_' . $valor['cama_id'] . '" class="notificacion-nota-des" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $OpDes . '"><p>' . "$NotasLenDes" . '</p></div>
                    </div>';
            } //cierre foreach ($Camas as $value)
            $Col .= '</div>'; // cierre de div class="panel panel-default"
            $Col .= '</div>'; // cierre de div class="panel panel-default"
            //$Col.=$modal;
        } // cierre de foreach ($Pisos as $value) 

        $Col .= '<script src="' . base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?') . md5(microtime()) . '" type="text/javascript"></script>';

        $this->setOutput(array(
            'accion' => '1',
            'Col'                => $Col,
            'TotalDisponibles'   => $TotalDisponibles,
            'TotalOcupadas'      => $TotalOcupadas,
            'TotalReservadas'    => $TotalReservadas,
            'TotalSucias'        => $TotalSucias,
            'TotalContaminadas'  => $TotalContaminadas,
            'TotalLimpias'       => $TotalLimpias,
            'TotalDescompuestas' => $TotalDescompuestas,
            'TotalReparadas'     => $TotalReparadas,
            'PorcentajeOcupacion' => round(($TotalOcupadas / $TotalDisponibles) * 100, 2) . ' ' . '%'
        ));
    }

    public function AjaxVisorCamasLimpiesaEHigiene()
    {
        $Pisos = $this->config_mdl->_query("SELECT * FROM os_pisos");
        $Col = '';
        $TotalDisponibles   = $this->TotalCamasEstatus('Disponible');
        $TotalOcupadas      = $this->TotalCamasEstatus('Ocupado');
        $TotalReservadas    = $this->TotalCamasEstatus('Reservada');
        $TotalSucias        = $this->TotalCamasEstatus('Sucia');
        $TotalContaminadas  = $this->TotalCamasEstatus('Contaminada');
        $TotalLimpias       = $this->TotalCamasEstatus('Limpia');
        $TotalDescompuestas = $this->TotalCamasEstatus('Descompuesta');
        $TotalReparadas     = $this->TotalCamasEstatus('Reparada');
        $SemaforoColores    = array(
            array("", "", ""),
            array("yellow", "", ""),
            array("yellow", "yellow", ""),
            array("yellow", "yellow", "yellow")
        );
        $Col .= '<div class="tablero">
                    <div id="bead-map" >';
        $Notas = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 0");
        $NotasDes = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 1");
        foreach ($Pisos as $value) {
            $Camas = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas, os_pisos, os_pisos_camas, os_pisos_sc WHERE 
                os_areas.area_id        =os_camas.area_id AND 
                os_pisos_camas.cama_id  =os_camas.cama_id AND
                os_pisos_camas.piso_id  =os_pisos.piso_id AND 
                os_pisos_sc.cama_id     =os_camas.cama_id AND 
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

            foreach ($Camas as $valor) {
                $tiempoIntervalo = '';
                $info43051 = $this->config_mdl->_get_data_condition('doc_43051', array('triage_id' => $valor['triage_id']))[0];
                /* Acciones para el popup*/
                $nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' . $valor['cama_nombre'] . '</h5></li>';
                /* Acciones de sobre la cama asignada */
                $acciones = "";
                $CamaCeldaSemaforo = "";
                if ($valor['cama_estado'] == 'Disponible') { //vestida-color verde
                    $CamaStatus = 'green';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Sucia') { // sucia-color negro
                    $CamaStatus = 'grey-900';
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
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Reservada') {  // Color Morado  Reservada
                    $CamaStatus = 'purple-300';
                    $tiempoEspera = Modules::run('Config/CalcularTiempoTranscurrido', array(
                        'Tiempo1' => $info43051['ac_fecha_asignacion'],
                        'Tiempo2' => date('Y-m-d H:i:s')
                    ));
                    $tiempoIntervalo .= $tiempoEspera->format('%h:%i min');
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Contaminada') {   // Contaminada
                    $CamaStatus = 'red';
                    $Estado = 'Limpia';
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

                if ($valor['cama_estado'] == 'Sucia' || $valor['cama_estado'] == 'Contaminada') {
                    $CamaCeldaSemaforo = $valor['cama_display'];
                    $ConfirmarLimpieza = '<li><a href="#" class="confirmar-Limpieza" ' . '" data-cama="' . $valor['cama_id'] . '" data-cama-id="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso  . '"><i class="fa fa-paint-brush icono-accion"></i> Confirmar limpieza</a></li>';
                    $AgregarNota = '<li><a href="#" class="nota-cama" ' . '" data-cama="' . $valor['cama_id'] . '" data-cama-id="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso  . '"><i class="fa fa-file-text-o icono-accion"></i> Agregar nota</a></li>';
                    $CamaCeldaSemaforo_int = 4 - intval($CamaCeldaSemaforo);
                    if ($CamaCeldaSemaforo_int <= 3) {
                        $CambiarEstadoSemaforo = '<li><a href="#" class="cambiar-estado-semaforo" ' . '" data-cama="' . $valor['cama_id'] . '" data-cama-id="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-semaforo="' . $CamaCeldaSemaforo  . '"><i class="fa fa-paint-brush icono-accion"></i> Confirmar limpieza No.' . $CamaCeldaSemaforo_int . '</a></li>';
                    } else {
                        $CambiarEstadoSemaforo = "";
                    }
                    if ($this->UMAE_AREA === 'Limpieza e Higiene') {    
                        $acciones = '<ul class="list-inline list-menu">
                                        <li class="dropdown">
                                            <a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-bed"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' . $nombreCama . ' ' . $ConfirmarLimpieza . ' ' . $AgregarNota . ' ' . $CambiarEstadoSemaforo . ' </ul>
                                        </li>
                                    </ul>';
                    }else{
                        $acciones = '<i class="fa fa-bed"></i>';
                    }
                }
                $Col .= '<div class="contenedor fila ' . $borde . '">
                            <div id="proceso" style="color: ' . $color . ';">
                                <div id="' . $valor['cama_id'] . "_semaforo_0" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][0] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>
                                <div id="' . $valor['cama_id'] . "_semaforo_1" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][1] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>
                                <div id="' . $valor['cama_id'] . "_semaforo_2" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][2] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>                    
                                <strong>
                                    <center>' . $proceso . '</center>
                                </strong>
                            </div>
                            <div id="' . $valor['cama_id'] . "_" . '" rel="tooltip" class="cama-no cama-celda ' . $CamaStatus . ' color-white cama' . $valor['cama_id'] . '" "  data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso . '" data-toggle="tooltip" data-trigger="hover"
                            data-placement="top" data-html="true">
                            ' . $acciones . '
                                <h6 style="margin-top: 3px; color:black"><b>' . $valor['cama_nombre'] . '</b></h6>
                                <div class="tooltip" id="tooltip' . $valor['cama_id'] . "_" . '">
                                </div>
                            </div>';
                $NotasLen = 0;
                foreach ($Notas as $Nota) {
                    if ($Nota["cama_id"] == $valor['cama_id']) {
                        $NotasLen += 1;
                    }
                }
                if ($NotasLen > 0) { $Op = 1;}else{$Op = 0;}
                $NotasLenDes = 0;
                foreach ($NotasDes as $Nota) {
                    if ($Nota["cama_id"] == $valor['cama_id']) {
                        $NotasLenDes += 1;
                    }
                }
                if ($NotasLenDes > 0) { $OpDes = 1;}else{$OpDes = 0;}
                $Col .=     '<div id = "nota_' . $valor['cama_id'] . '" class="notificacion-nota pointer" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $Op . '"><p>' . "$NotasLen" . '</p></div>
                        <div id = "nota_des_' . $valor['cama_id'] . '" class="notificacion-nota-des" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $OpDes . '"><p>' . "$NotasLenDes" . '</p></div>
                    </div>';
            } //cierre foreach ($Camas as $value)
            $Col .= '</div>'; // cierre de div class="panel panel-default"
            $Col .= '</div>'; // cierre de div class="panel panel-default"
            //$Col.=$modal;
        } // cierre de foreach ($Pisos as $value) 

        $Col .= '<script src="' . base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?') . md5(microtime()) . '" type="text/javascript"></script>';

        $this->setOutput(array(
            'accion' => '1',
            'Col'                => $Col,
            'TotalDisponibles'   => $TotalDisponibles,
            'TotalOcupadas'      => $TotalOcupadas,
            'TotalReservadas'    => $TotalReservadas,
            'TotalSucias'        => $TotalSucias,
            'TotalContaminadas'  => $TotalContaminadas,
            'TotalLimpias'       => $TotalLimpias,
            'TotalDescompuestas' => $TotalDescompuestas,
            'TotalReparadas'     => $TotalReparadas,
            'PorcentajeOcupacion' => round(($TotalOcupadas / $TotalDisponibles) * 100, 2) . ' ' . '%'
        ));
    } //cierre de funcion AjaxvisorCamasLimpiesaEHigiene

    public function AjaxGetCamas()
    {
        $os_camas = $this->config_mdl->_query("SELECT * FROM os_camas");
        $this->setOutput(array(
            'accion' => '1',
            'os_camas'                =>  $os_camas));
    } 

    public function AjaxVisorDireccionEnfermeria()
    {
        $Pisos = $this->config_mdl->_query("SELECT * FROM os_pisos");
        $Col = '';
        $TotalDisponibles   = $this->TotalCamasEstatus('Disponible');
        $TotalOcupadas      = $this->TotalCamasEstatus('Ocupado');
        $TotalReservadas    = $this->TotalCamasEstatus('Reservada');
        $TotalSucias        = $this->TotalCamasEstatus('Sucia');
        $TotalContaminadas  = $this->TotalCamasEstatus('Contaminada');
        $TotalLimpias       = $this->TotalCamasEstatus('Limpia');
        $TotalDescompuestas = $this->TotalCamasEstatus('Descompuesta');
        $TotalReparadas     = $this->TotalCamasEstatus('Reparada');
        $SemaforoColores    = array(
            array("", "", ""),
            array("yellow", "", ""),
            array("yellow", "yellow", ""),
            array("yellow", "yellow", "yellow")
        );
        $Col .= '<div class="tablero">
                    <div id="bead-map" >';
        $Notas = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 0");
        $NotasDes = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 1");
        //$Especialidades = $this->config_mdl->_get_data("um_especialidades", array("especialidad_hospitalisacion" => 1));
        foreach ($Pisos as $value) {
            $Disponibles = $this->TotalCamasEstatusPisos($value['piso_id'], 'Disponible'); //Esta Vestida
            $Ocupadas = $this->TotalCamasEstatusPisos($value['piso_id'], 'Ocupado');
            $nombrePiso = '<li><h4 class="text-center link-acciones bold">'.$value["piso_nombre"].'</h4></li>';
            $ReportePiso = '<li><a href="#" class="ReportePiso"  data-piso="' . $value["area_id"] . '"><i class="fa fa-share-square-o icono-accion"></i> Reporte por piso</a></li>';
            $ReporteEspe = '<li><a href="#" class="ReporteEspe" data-pisoname="'.$value["piso_nombre"].'"><i class="fa fa-share-square-o icono-accion"></i> Reporte por especialidad</a></li>';
            $ReportesPisos = '<div style="float: left;"> 
                        <ul class="list-inline list-menu">
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file-text-o icono-accion ttip" data-toggle="tooltip" data-placement="left" title="Reporte Censo Diario"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -215px">' .$nombrePiso. ' ' .$ReportePiso. ' ' .$ReporteEspe. '</ul>
                            </li>
                        </ul>
                    </div>';
            $TotalPiso = $this->TotalPorPiso($value['piso_id']);
            $Camas = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas, os_pisos, os_pisos_camas, os_pisos_sc WHERE 
                os_areas.area_id        =os_camas.area_id AND 
                os_pisos_camas.cama_id  =os_camas.cama_id AND
                os_pisos_camas.piso_id  =os_pisos.piso_id AND 
                os_pisos_sc.cama_id     =os_camas.cama_id AND 
                os_pisos.piso_id        =" . $value['piso_id']);
            $Col .= '<div class="container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="bedCharts-space text-left">
                            <span style="font-weight: bold">' . $value['piso_nombre_corto'] . '</span>
                            <span class="infoPisoTotal">Total:' . $TotalPiso . '</span>
                            <span class="infoPisoDisponibles">Disponibles: ' . $Disponibles . '</span>
                            <span class="infoPisoOcupadas" style="padding-left: 50px">Ocupadas: ' . $Ocupadas . '</span>
                            <span style="float:right;">' . $ReportesPisos . '</span>
                        </div>  
                        <div class="container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12 rowCamas">';
            foreach ($Camas as $valor) {
                $tiempoIntervalo = '';
                $info43051 = $this->config_mdl->_get_data_condition('doc_43051', array('triage_id' => $valor['triage_id']))[0];
                $OcuparCama = '<li><a href="#" class="ocuparCama" data-triage="' . $valor['triage_id'] . '" data-cama="' . $valor['cama_id'] . '" data-camanombre="' . $valor['cama_nombre'] . '"><i class="fa fa-bed icono-accion"></i>  Ocupar cama</a></li>';

                /* Acciones para el popup*/
                $nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' . $valor['cama_nombre'] . '</h5></li>';
                /* Acciones de sobre la cama asignada */
                $acciones = "";
                $CamaCeldaSemaforo = "";
                if ($valor['cama_estado'] == 'Disponible') { //vestida-color verde
                    $CamaStatus = 'green';
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Sucia') { // sucia-color negro
                    $CamaStatus = 'grey-900';
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
                    $acciones = '<i class="fa fa-bed"></i>';
                } else if ($valor['cama_estado'] == 'Reservada') {  // Color Morado  Reservada
                    $CamaStatus = 'purple-300';
                    $tiempoEspera = Modules::run('Config/CalcularTiempoTranscurrido', array(
                        'Tiempo1' => $info43051['ac_fecha_asignacion'],
                        'Tiempo2' => date('Y-m-d H:i:s')
                    ));
                    $tiempoIntervalo .= $tiempoEspera->format('%h:%i min');
                    $acciones = '<ul class="list-inline list-menu">
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bed"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' . $nombreCama . ' ' . $OcuparCama . '</ul>
                                    </li>
                                </ul>';
                } else if ($valor['cama_estado'] == 'Contaminada') {   // Contaminada
                    $CamaStatus = 'red';
                    $Estado = 'Limpia';
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

                /*if ($valor['cama_estado'] == 'Sucia' || $valor['cama_estado'] == 'Contaminada') {
                    $CamaCeldaSemaforo = $valor['cama_display'];
                    $acciones = '<i class="fa fa-bed"></i>';
                }*/
                if ($valor['cama_estado'] == 'Sucia' || $valor['cama_estado'] == 'Contaminada') {
                    $CamaCeldaSemaforo = $valor['cama_display'];
                    $ConfirmarLimpieza = '<li><a href="#" class="confirmar-Limpieza" ' . '" data-cama="' . $valor['cama_id'] . '" data-cama-id="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso  . '"><i class="fa fa-paint-brush icono-accion"></i> Confirmar limpieza</a></li>';
                    $AgregarNota = '<li><a href="#" class="nota-cama" ' . '" data-cama="' . $valor['cama_id'] . '" data-cama-id="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso  . '"><i class="fa fa-file-text-o icono-accion"></i> Agregar nota</a></li>';
                    $CamaCeldaSemaforo_int = 4 - intval($CamaCeldaSemaforo);
                    if ($CamaCeldaSemaforo_int <= 3) {
                        $CambiarEstadoSemaforo = '<li><a href="#" class="cambiar-estado-semaforo" ' . '" data-cama="' . $valor['cama_id'] . '" data-cama-id="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-semaforo="' . $CamaCeldaSemaforo  . '"><i class="fa fa-paint-brush icono-accion"></i> Confirmar limpieza No.' . $CamaCeldaSemaforo_int . '</a></li>';
                    } else {
                        $CambiarEstadoSemaforo = "";
                    }
                    $acciones = '<ul class="list-inline list-menu">
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bed"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' . $nombreCama . ' ' . $ConfirmarLimpieza . ' ' . $CambiarEstadoSemaforo . ' </ul>
                                    </li>
                                </ul>';
                }
                $Col .= '<div class="contenedor fila ' . $borde . '">
                            <div id="proceso" style="color: ' . $color . ';">
                                <div id="' . $valor['cama_id'] . "_semaforo_0" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][0] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>
                                <div id="' . $valor['cama_id'] . "_semaforo_1" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][1] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>
                                <div id="' . $valor['cama_id'] . "_semaforo_2" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][2] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>                    
                                <strong>
                                    <center>' . $proceso . '</center>
                                </strong>
                            </div>
                            <div id="' . $valor['cama_id'] . "_" . '" rel="tooltip" class="cama-no cama-celda ' . $CamaStatus . ' color-white cama' . $valor['cama_id'] . '" "  data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $valor['cama_id'] . '" data-estado="' . $valor['cama_estado'] . '" data-cama_nombre="' . $valor['cama_nombre'] . '" data-folio="' . $valor['triage_id'] . '" data-paciente="' . $proceso . '" data-toggle="tooltip" data-trigger="hover"
                            data-placement="top" data-html="true">
                            ' . $acciones . '
                                <h6 style="margin-top: 3px; color:black"><b>' . $valor['cama_nombre'] . '</b></h6>
                                <div class="tooltip" id="tooltip' . $valor['cama_id'] . "_" . '">
                                </div>
                            </div>';
                $NotasLen = 0;
                foreach ($Notas as $Nota) {
                    if ($Nota["cama_id"] == $valor['cama_id']) {
                        $NotasLen += 1;
                    }
                }
                if ($NotasLen > 0) { $Op = 1;}else{$Op = 0;}
                $NotasLenDes = 0;
                foreach ($NotasDes as $Nota) {
                    if ($Nota["cama_id"] == $valor['cama_id']) {
                        $NotasLenDes += 1;
                    }
                }
                if ($NotasLenDes > 0) { $OpDes = 1;}else{$OpDes = 0;}
                $Col .=     '<div id = "nota_' . $valor['cama_id'] . '" class="notificacion-nota" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $Op . '"><p>' . "$NotasLen" . '</p></div>
                        <div id = "nota_des_' . $valor['cama_id'] . '" class="notificacion-nota-des" ' . 'data-cama-nombre=' . $valor['cama_nombre'] . ' data-cama-id=' . $valor['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $OpDes . '"><p>' . "$NotasLenDes" . '</p></div>
                    </div>';
            } //cierre foreach ($Camas as $value)
            
            
            $Col .= '</div>'; // cierre de div class="panel panel-default"
            $Col .= '</div>'; // cierre de div class="panel panel-default"
            //$Col.=$modal;
        } // cierre de foreach ($Pisos as $value) 

        $Col .= '<script src="' . base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?') . md5(microtime()) . '" type="text/javascript"></script>';

        $this->setOutput(array(
            'accion' => '1',
            'Col'                => $Col,
            'TotalDisponibles'   => $TotalDisponibles,
            'TotalOcupadas'      => $TotalOcupadas,
            'TotalReservadas'    => $TotalReservadas,
            'TotalSucias'        => $TotalSucias,
            'TotalContaminadas'  => $TotalContaminadas,
            'TotalLimpias'       => $TotalLimpias,
            'TotalDescompuestas' => $TotalDescompuestas,
            'TotalReparadas'     => $TotalReparadas,
            'PorcentajeOcupacion' => round(($TotalOcupadas / $TotalDisponibles) * 100, 2) . ' ' . '%'
        ));
    } //cierre de funcion AjaxvisorCamasLimpiesaEHigiene

    public function AjaxGuardarNotaCama()
    {
        $cama_id = $this->input->post('cama_id');
        $empleado_id = $this->input->post('empleado_id');
        $nota = $this->input->post('result');
        $tipo = $this->input->post('tipo');

        $this->config_mdl->_insert('os_camas_notas', array(
            'empleado_id'   => $empleado_id,
            'cama_id'       => $cama_id,
            'nota'          => $nota,
            'estado'        => 0,
            'tipo_nota'     => $tipo,
            'fecha_nota'    => date('Y-m-d H:i')
        ));
        $this->setOutput(array("cama_id" => $cama_id, 'empleado_id' => $empleado_id,  "nota" => $nota));
    }

    public function AjaxMarcarLeidoNotaCama(){
        $cama_id = $this->input->post('cama_id');
        $tipo = $this->input->post('tipo');
        $this->config_mdl->_update_data('os_camas_notas', array(  
            'estado'    => 1),array(
            'cama_id'   => $cama_id,
            'tipo_nota' => $tipo,
            'estado'    => 0)
        );
        $this->setOutput(array("cama_id" => $cama_id));
    }

    public function AjaxGuardarEstadoSemaforo(){
        $cama_id = $this->input->post('cama_id');
        $cama_semaforo_estado = $this->input->post('result');
        $this->config_mdl->_update_data("os_camas", array(
            'cama_display'  => $cama_semaforo_estado
        ), array(
            'cama_id'       => $cama_id
        ));
        $this->setOutput(array('accion' => '1'));
    }

    public function BuscarPacienteRegistrado() {
        $sql= $this->config_mdl->_query("SELECT * FROM doc_43051 INNER JOIN os_triage  WHERE 
            doc_43051.triage_id  = os_triage.triage_id AND
            doc_43051.triage_id  =  ".$this->input->post('triage_id')); 
       
        if(!empty($sql)){
            $viaIngreso = $sql[0]['triage_via_registro']; 
            $this->setOutput(array('accion' => '1', 'via_ingreso' => $viaIngreso));
        }else $this->setOutput(array('accion' => '2'));
    }

    public function AjaxBuscarPaciente() {       
        $sql= $this->config_mdl->sqlGetDataCondition('doc_43051',array(
            'triage_id'=> $this->input->post('triage_id')
        )); 
        if(empty($sql)){
            // No existe el folio
            $this->setOutput(array('accion'=>'1')); 
        }else if($sql[0]['estado_cama']=='Asignada'){
            $this->setOutput(array('accion'=>'2'));
        }else if($sql[0]['estado_cama']=='En espera') {
            $this->setOutput(array('accion'=>'3'));
        }
    }
    public function AjaxReservarCama() {

        $infoCamas =  $this->config_mdl->_get_data_condition('os_camas',array(
            'cama_id'=>  $this->input->post('cama_id')
        ))[0];
        
        $infoPaciente = $this->config_mdl->_get_data_condition('os_triage', array(
                'triage_id' => $this->input->post('triage_id')
        ))[0]; 
        
        $empleado = $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));

        $info43051 = $this->config_mdl->_get_data_condition('doc_43051', array(
            'triage_id' => $this->input->post('triage_id')
        ))[0];
    
        if(!empty($empleado)){ // si existe la matricula del que asigna cama
            $this->config_mdl->_update_data('doc_43051',array(
                'cama_id'           => $this->input->post('cama_id'),
                'area_id'           => $infoCamas['area_id'],
                'fecha_asignacion'  => date('Y-m-d H:i'),
                'empleado_asigna'   => $empleado[0]['empleado_id'],
                'estado_cama'       => 'Reservada'
            ),array(
                'triage_id'=>  $this->input->post('triage_id')
            ));
            
            $this->config_mdl->_update_data('os_camas',array(
                'cama_estado'     => 'Reservada',
                'cama_genero'     => $infoPaciente['triage_paciente_sexo'],
                'cama_ingreso_f'  => date('Y-m-d'),
                'cama_ingreso_h'  => date('H:i'),
                'cama_fh_estatus' => date('Y-m-d H:i:s'),
                'triage_id'       => $infoPaciente['triage_id']
            ),array(
                'cama_id' => $this->input->post('cama_id')
            ));
            Modules::run('Areas/LogCamas',array(
                'log_estatus'=>'Reservado',
                'cama_id'=>$this->input->post('cama_id')
            ));

            $datalog=array(
                'id_43051'     => $info43051['id'],
                'cama_id'      => $this->input->post('cama_id'),
                'empleado_id'  => $this->UMAE_USER,
                'triage_id'    => $this->input->post('triage_id'),
                'accion'       => '1',
                'fecha_hora'   => date('Y-m-d H:i'),
                'estado'       => 'Reservada',
                'descripcion'  => 'Asistente Médica reserva cama'
                
            );
            $this->config_mdl->_insert('os_camas_estados', $datalog); 

            //$this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso Enfermería Observación','triage_id'=>$obs['triage_id'],'areas_id'=>$obs['observacion_id']));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxDireccionPaciente(){
      $triage_id = $_GET['triage_id'];
      $sql = $this->config_mdl->_query("SELECT directorio_cp, directorio_cn, directorio_colonia,
                                                     directorio_municipio, directorio_municipio,directorio_estado
                                                     FROM os_triage_directorio
                                                     WHERE triage_id = ".$triage_id);
      $this->setOutput(array('Direccion'=>$sql[0]));
    }

    /* Metodo para insrtar datos en el formato 43051 */

    public function AjaxAsignarCama_v2() { // funcion para asignar cama paciente
        $pacienteGenero= $this->config_mdl->sqlGetDataCondition('os_triage', array(
            'triage_id'=>$this->input->post('triage_id')),'triage_paciente_sexo');
        
        $sqlEmpleado=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')),'empleado_id');

        if(!empty($sqlEmpleado)){
            $this->AccesosUsuarios(array('acceso_tipo'=>'Admisión Hospitalaria','triage_id'=>$this->input->post('triage_id'),'areas_id'=>0));
            $this->config_mdl->_update_data('doc_43051',array(
                'estado'=>'Asignado',
                
                'ac_fecha_asignacion'=> date('Y-m-d H:i:s'),
                //'ac_ingreso_servicio'=> $this->input->post('ac_ingreso_servicio'),
                //'ac_ingreso_medico'=> $this->inpuestado_ingreso_med->post('ac_ingreso_medico'),
                //'ac_ingreso_matricula'=> $this->input->post('ac_ingreso_matricula'),
                'ac_salida_servicio'=> $this->input->post('ac_salida_servicio'),
                'ac_infectado'=> $this->input->post('ac_infectado'),
                'ac_cama_estatus'=> 'En Espera',
                'cama_id'=> $this->input->post('cama_id'),
                'empleado_asigna'=> $sqlEmpleado[0]['empleado_id'],
                //'triage_id'=> $this->input->post('triage_id')
            ),array(
            'triage_id'=> $this->input->post('triage_id')
            ));
            Modules::run('Triage/TriagePacienteDirectorio',array(
                'directorio_tipo'=>'Familiar',
                'directorio_cp'=> $this->input->post('directorio_cp'),
                'directorio_cn'=> $this->input->post('directorio_cn'),
                'directorio_colonia'=> $this->input->post('directorio_colonia'),
                'directorio_municipio'=> $this->input->post('directorio_municipio'),
                'directorio_estado'=> $this->input->post('directorio_estado'),
                'directorio_telefono'=> $this->input->post('directorio_telefono'),
                'triage_id'=>$this->input->post('triage_id')
            ));
            $this->config_mdl->_update_data('os_camas', array(
               'cama_estado'=> 'En Espera',
               'cama_genero'=> $pacienteGenero[0]['triage_paciente_sexo'],
                'triage_id'=>$this->input->post('triage_id')),
                array(
                    'cama_id'=> $this->input->post('cama_id')
                ));
            $data=array(
                'estado_tipo'=>'En Espera',
                'estado_fecha'=>date('Y-m-d'),
                'estado_hora'=>date('H:i:s'),
                'cama_id'=> $this->input->post('cama_id'),
                'empleado_id'=> $sqlEmpleado[0]['empleado_id'],
                'triage_id'=>$this->input->post('triage_id')
            );
            $this->config_mdl->_insert('os_camas_estados', $data); 
            $this->setOutput(array('accion'=>'1'));
        
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxEliminar43051() {
        $this->config_mdl->_delete_data('doc_43051',array(
            'triage_id'=> $this->input->post('triage_id'),
            'cama_id'=> $this->input->post('cama_id'),
        ));
        
        $this->setOutputV2(array('accion'=>'1'));
    }
    public function AjaxLiberarCama43051() {
        $this->config_mdl->_update_data('doc_43051',array(
            'area_id'   => Null,
            'cama_id'   => Null,
           'estado_cama'=>'En espera'
        ),array(
            'estado_cama'=>'Reservada',
            'triage_id'=> $this->input->post('triage_id'),
            'cama_id'=> $this->input->post('cama_id'),
        ));
        $this->setOutputV2(array('accion'=>'1'));
        $this->config_mdl->_update_data('os_camas',array(
            'cama_estado'    => 'Disponible',
            'cama_genero'    => '',
            'cama_ingreso_f' => '',
            'cama_ingreso_h' => '',
            'cama_fh_estatus'=> '',
            'triage_id'      => Null
        ),array(
            'cama_id'        =>  $this->input->post('cama_id')
        ));
    }
  
    public function PasesdeVisitas() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas WHERE os_areas.area_id=os_camas.area_id AND os_camas.cama_estado='Ocupado'");
        $this->load->view('Pases/PasesDeVisitas',$sql);
    }
    public function PasesdeVisitasFamiliares() {
        $sql['Gestion']= $this->config_mdl->sqlGetDataCondition("um_poc_familiares",array(
            'triage_id'=>$_GET['folio'],
            'familiar_tipo'=>$_GET['tipo']
        ));
        $this->load->view('Pases/PasesdeVisitasFamiliares',$sql);
    }
    public function AgregarFamiliar() {
        $sql['info']= $this->config_mdl->sqlGetDataCondition('um_poc_familiares',array(
            'familiar_id'=>$_GET['familiar']
        ))[0];
        $this->load->view('Pases/PasesdeVisitasFamiliaresAgregar',$sql);
    }
    public function AjaxAgregarFamiliar() {
        $data=array(
            'familiar_nombre'=> $this->input->post('familiar_nombre'),
            'familiar_nombre_ap'=> $this->input->post('familiar_nombre_ap'),
            'familiar_nombre_am'=> $this->input->post('familiar_nombre_am'),
            'familiar_parentesco'=> $this->input->post('familiar_parentesco'),
            'familiar_registro'=> date('Y-m-d H:i:s'),
            'familiar_tipo'=> $this->input->post('familiar_tipo'),
            'triage_id'=> $this->input->post('triage_id')
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('um_poc_familiares',$data);
        }else{
            unset($data['familiar_registro']);
            $this->config_mdl->_update_data('um_poc_familiares',$data,array(
                'familiar_id'=> $this->input->post('familiar_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxEliminarFamiliar() {
        $this->config_mdl->_delete_data('um_poc_familiares',array(
            'familiar_id'=> $this->input->post('familiar_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AgregarFamiliarFoto() {
        $this->load->view('Pases/PasesdeVisitasFamiliaresAgregarFoto');
    }
    public function AjaxGuardarPerfilFamiliar() {
        $data = $this->input->post('familiar_perfil');
        $data = str_replace('data:image/jpeg;base64,', '', $data);
        $url_save='assets/img/familiares/';
        $data = base64_decode($data);
        $familiar_perfil = $url_save.$this->input->post('familiar_id').'_'.$this->input->post('triage_id').'.jpeg';
        file_put_contents($familiar_perfil, $data);
        $data = base64_decode($data); 
        $source_img = imagecreatefromstring($data);
        $rotated_img = imagerotate($source_img, 90, 0); 
        $familiar_perfil = $url_save.$this->input->post('familiar_id').'_'.$this->input->post('triage_id').'.jpeg';
        imagejpeg($rotated_img, $familiar_perfil, 10);
        imagedestroy($source_img);
        $this->config_mdl->_update_data('um_poc_familiares',array(
            'familiar_perfil'=>$this->input->post('familiar_id').'_'.$this->input->post('triage_id').'.jpeg'
        ),array(
            'familiar_id'=> $this->input->post('familiar_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function GetCamasDisponibles() {
       $sql = $this->config_mdl->_get_data_condition('os_camas',array(
            'area_id'=> $this->input->post('area_id'),
            'cama_estado'=>'Disponible'
        ));
        $option_camas = '';
        $option_camas .= '<option value="" disabled selected>Selecciona</option>';
        foreach ($sql as $value) {
            $option_camas.='<option value="'.$value['cama_id'].'">'.$value['cama_nombre'].'</option>';
        }
        $this->setOutput(array('option_pisos'  => Modules::run('Admisionhospitalaria/Getpisos'),
                               'option_camas'  => $option_camas ));
    }
    public function AjaxCambiarCamaReservada() {
        $this->config_mdl->_update_data('os_camas',array(
            'cama_estado'=>'Disponible',
            'cama_ingreso_f'=> '',
            'cama_ingreso_h'=> '',
            'cama_fh_estatus'=> '',
            'triage_id'=>0
        ),array(
            'cama_id'=>  $this->input->post('cama_id_old')
        ));
        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'Disponible',
            'cama_id'=>$this->input->post('cama_id_old')
        ));
        $this->config_mdl->_update_data('os_camas',array(
            'cama_estado'=>'En Espera',
            'cama_ingreso_f'=> '',
            'cama_ingreso_h'=> '',
            'cama_fh_estatus'=> '',

            'triage_id'=> $this->input->post('triage_id')
        ),array(
            'cama_id'=>  $this->input->post('cama_id_new')
        ));
        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'En Espera',
            'cama_id'=>$this->input->post('cama_id_new')
        ));
        $camas= $this->config_mdl->_get_data_condition('os_camas',array(
            'cama_id'=> $this->input->post('cama_id_new')
        ))[0];
        $this->config_mdl->_update_data('doc_43051',array(
            'cama_id'=>  $this->input->post('cama_id_new')
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_insert('os_camas_log',array(
            'cama_log_fecha'=> date('d/m/Y'),
            'cama_log_hora'=> date('H:i'),
            'cama_log_tipo'=>'Cambio de Cama',
            'cama_log_modulo'=>'AdmisionHospitalaria',
            'cama_id'=> $this->input->post('cama_id_new'),
            'triage_id'=> $this->input->post('triage_id'),
            'empleado_id'=> $this->UMAE_USER
        ));
        $this->setOutput(array('accion'=>'1'));
    }

    /* ********************************************************************************** */
    /* ****************          Cambio de Cama       *********************************** */
    /* ********************************************************************************** */
    public function AjaxCambiarCamaOcupada() {
        $cama = $this->config_mdl->sqlGetDataCondition('os_camas', array('cama_id' => $this->input->post('cama_id_actual' )))[0];
        $this->config_mdl->_update_data('os_camas',array(
            'cama_estado'     => 'Sucia',
            'proceso'         => 3, //indicacion de cambio
            'cama_ingreso_f'  => '',
            'cama_ingreso_h'  => '',
            'cama_fh_estatus' => date('Y-m-d H:i'),
            'triage_id'       => 0,
            'cama_genero'     => 'Sin Especificar',
            'estado_salud'    => Null,
            'id_medico_trat'  => Null,
            'id_servicio_trat'=> Null
        ),array('cama_id' => $this->input->post('cama_id_actual') ));

        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'Sucia',
            'cama_id'=>$this->input->post('cama_id_actual')
        ));

        $this->config_mdl->_update_data('os_camas',array(
            'cama_estado'     => 'Ocupado',
            'proceso'         => 0,
            'cama_ingreso_f'  => date('Y-m-d'),
            'cama_ingreso_h'  => date('H:i'),
            'cama_fh_estatus' => date('Y-m-d H:i'),
            'cama_genero'     => $this->input->post('cama_genero'),
            'triage_id'       => $this->input->post('triage_id')
        ),array('cama_id' => $this->input->post('cama_id_new') ));

        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'Ocupado',
            'cama_id'=>$this->input->post('cama_id_new')
        ));

        $this->config_mdl->_update_data('doc_43051',array(
            'cama_id' =>  $this->input->post('cama_id_new')
        ),array(
            'triage_id' =>  $this->input->post('triage_id')
        ));
        $cama_nombre_actual =  $this->config_mdl->_get_data_condition("os_camas", array(
            'cama_id' => $this->input->post('cama_id_actual')
        ));
        $cama_id_new        =  $this->config_mdl->_get_data_condition("os_camas", array(
            'cama_id' => $this->input->post('cama_id_new')
        ));
 
        $this->config_mdl->_insert('os_camas_log',array(
            'cama_log_fecha'=> date('d/m/Y'),
            'cama_log_hora'=> date('H:i'),
            'cama_log_tipo'=>'Cambio de Cama '.$cama_nombre_actual[0]["cama_nombre"].' a '.$cama_id_new[0]["cama_nombre"],
            'cama_log_modulo'=>'AdmisionHospitalaria',
            'cama_id'=> $this->input->post('cama_id_new'),
            'triage_id'=> $this->input->post('triage_id'),
            'empleado_id'=> $this->UMAE_USER
        ));

        // Modules::run('Hospitalizacion/RegistroEstadosCamas', array(
        //     'id_43051'    => $id_43051['id'],
        //     'cama_id'     => $cama_id,    
        //     'empleado_id' => $this->UMAE_USER,
        //     'triage_id'   => $triage_id,
        //     'accion'      => $accion,
        //     'fecha_hora'  => date('Y-m-d H:i'),
        //     'estado'      => $estado,
        //     'descripcion' => $descripcion'
        // ));
        
        $this->setOutput(array('accion'=>'1'));
    }

    /* ********************************************************************************** */
    /* *********************          Alta paciente        ****************************** */
    /* ********************************************************************************** */
    public function AjaxAltaPaciente() {
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'ap_alta'=>  $this->input->post('ap_alta')
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        if($this->input->post('ap_alta')=='Alta e ingreso quirófano'){
            $this->config_mdl->_update_data('os_camas',array(
                'cama_estado'=>'En Espera',
                'cama_fh_estatus'=> date('Y-m-d H:i:s'),
            ),array(
                'cama_id'=>  $this->input->post('cama_id')
            ));
            Modules::run('Areas/LogCamas',array(
                'log_estatus'=>'En Espera',
                'cama_id'=>$this->input->post('cama_id'),
            ));
        }else{
            $this->config_mdl->_update_data('os_areas_pacientes',array(
                'area_id'=> $this->input->post('area_id'),
                'ap_f_salida'=> date('d/m/Y'),
                'ap_h_salida'=>  date('H:i') ,
                'ap_status'=>'Salida'
            ),array(
                'triage_id'=>  $this->input->post('triage_id')
            ));
            $this->config_mdl->_update_data('os_camas',array(
                'cama_estado'=>'Limpia',
                'triage_id'=>0,
                'cama_ingreso_f'=> '',
                'cama_ingreso_h'=> '',
                'cama_fh_estatus'=> date('Y-m-d H:i:s'),
            ),array(
                'cama_id'=>  $this->input->post('cama_id')
            ));
            Modules::run('Areas/LogCamas',array(
                'log_estatus'=>'En Limpieza',
                'cama_id'=>$this->input->post('cama_id'),
            ));
        }
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'En Limpieza',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        Modules::run('Pisos/Camas/LogPisos',array(
            'log_tipo'=>'Egreso',
            'log_obs'=> $this->input->post('log_obs'),
            'log_alta'=> $this->input->post('ap_alta'),
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $areas= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->AccesosUsuarios(array('acceso_tipo'=>'Egreso '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$areas['ap_id']));
        
        $this->setOutput(array('accion'=>'1'));
    }

     public function AjaxConfirmarIngreso() {
        
        $info43051= $this->config_mdl->sqlGetDataCondition('doc_43051',array(
            'estado_cama'   =>'Reservada',
            'triage_id'     => $this->input->post('triage_id')))[0];

        if(!empty($info43051)){
            $this->config_mdl->_update_data('doc_43051', array(
                                                'estado_cama'               => 'Asignada',
                                                'fecha_h_enfer_recibe_paci' => date('Y-m-d H:i')), array(
                                                'triage_id'                 => $this->input->post('triage_id')));

            $this->config_mdl->_update_data('os_camas', array(
                                        'cama_estado'     => 'Ocupado',
                                        'id_servicio_trat'=> $info43051['ingreso_servicio'],
                                        'id_medico_trat'  => $info43051['ingreso_medico'],
                                        'cama_fh_estatus' => date('Y-m-d H:i')), array(
                                        'cama_id'         => $this->input->post('cama_id')));

            $this->config_mdl->_insert('os_camas_estados',array(
                'id_43051'        => $info43051['id'],
                'cama_id'         => $this->input->post('cama_id'),
                'empleado_id'     => $this->UMAE_USER,
                'triage_id'       => $this->input->post('triage_id'),
                'accion'          => 2,
                'fecha_hora'      => date('Y-m-d H:i'),
                'estado'          => 'Ocupado',
                'descripcion'     => 'Se Confirma el Ingreso'
            ));

            $this->config_mdl->_insert('os_camas_log',array(
                'cama_log_fecha'=> date('d/m/Y'),
                'cama_log_hora'=> date('H:i'),
                'cama_log_tipo'=> 'Confirma Ingreso',
                'cama_log_modulo'=>'AdmisionHospitalaria',
                'cama_id'=> $this->input->post('cama_id'),
                'triage_id'=> $this->input->post('triage_id'),
                'empleado_id'=> $this->UMAE_USER ));

            $this->setOutput(array('accion'=>'1'));

        }else {
            $this->setOutput(array('accion'=>'2'));
        }
        
    }

    public function Registro($Paciente)  {

        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(    
           'triage_id'=>  $Paciente
        ));

        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['solicitud']= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
           'triage_id'=> $Paciente
        ));
        $sql['empleado']= $this->config_mdl->_get_data_condition('os_empleados',array(
           'empleado_id'=> $this->UMAE_USER
        ));
        $sql['DirPaciente']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'       => $Paciente,
           'directorio_tipo' => 'Paciente'
        ))[0];
        
        $sql['Doc43051'] = $this->config_mdl->_get_data_condition('doc_43051',array(
          'triage_id'=> $Paciente
        ))[0];

        $sql['medicoTratante'] = $this->config_mdl->_get_data_condition('os_empleados',array(
          'empleado_id'=> $sql['Doc43051']['ingreso_medico']
        ),'empleado_matricula,empleado_nombre,empleado_apellidos')[0];

         $sql['ordeninternamiento'] = $this->config_mdl->_get_data_condition('um_orden_internamiento',array(
          'triage_id'=> $Paciente
        ))[0];

         $sql['Especialidad'] = $this->config_mdl->_get_data_condition('um_especialidades',array(
          'especialidad_id'=> $sql['ordeninternamiento']['servicio_destino_id']
        ))[0];
        $sql['pacienteDx'] = $this->config_mdl->_get_data_condition('paciente_diagnosticos', array('diagnostico_id' => $sql['ordeninternamiento']['diagnostico_id']))[0];
        
        $sql['nombreDx'] = $this->config_mdl->_get_data_condition('um_cie10', array('cie10_id' => $sql['pacienteDx']['cie10_id']))[0];

         $sql['Especialidades'] = $this->config_mdl->_query("SELECT especialidad_id, especialidad_nombre FROM um_especialidades WHERE especialidad_hospitalizacion=1 ORDER BY especialidad_nombre");

        $sql['medicosPorServicio']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_roles'=>'2',
            'empleado_servicio'=>$sql['ordeninternamiento']['servicio_destino_id']
        ));
        
        $sql['Area'] = $this->config_mdl->_get_data_condition("os_areas", array(
            'area_modulo' => 'Pisos'));
        
        $sql['Cama'] =$this->config_mdl->_get_data_condition('os_camas', array(
            'area_id'     => $sql['Area'][0]['area_id']
        ));
        
        // if($this->UMAE_AREA=='Asistente Médica Admisión Continua'){
        //     $this->load->view('Registroac',$sql); //Abre pagina donde se hace el registroa 43051
        // }else 
        $this->load->view('Pacientesah',$sql); // Abre el modal para cargar lista de pacientes registrado 
    }

    public function Ingresos() {
        $sql['infoPaciente']= $this->config_mdl->_query("SELECT * FROM os_triage, os_accesos, os_empleados
                                                    WHERE
                                                    os_accesos.acceso_tipo='Triage Médico' AND
                                                    os_accesos.triage_id=os_triage.triage_id AND
                                                    os_accesos.empleado_id=os_empleados.empleado_id AND
                                                    os_triage.triage_via_registro = 'Hora Cero TR' AND
                                                    os_triage.triage_consultorio_nombre = 'Hospitalización' ORDER BY os_accesos.acceso_id DESC LIMIT 10");
        $sql['medico']= $this->config_mdl->_get_data_condition('os_empleados',array(
           'empleado_id'=> $sql['infoPaciente']['triage_crea_medico']
        ))[0];

         $this->load->view('Ingresos', $sql);
    }

    public function ReporteAltas() {
      $this->load->view('ReporteAltas');
    }
    public function GetMedicoEspecialista() {
         
        $medicos= $this->config_mdl->_get_data_order('os_empleados',array(
           'empleado_servicio'   => $this->input->post('especialidad_id'),
           'empleado_roles'      => 2,
           'empleado_status'     => 1
        ), 'empleado_apellidos', 'ASC');
        
       
        if(count($medicos)>0) {
            $select_box = '';
            $select_box .= '<option value="0" selected>Seleccionar Médico</option>';
            foreach ($medicos as $medico) {
                $select_box .= '<option value="'.$medico['empleado_id'].'">'.$medico['empleado_apellidos'].' '.$medico['empleado_nombre'].' ('.$medico['empleado_matricula'].')</option>';
                   }   echo json_encode($select_box);    
        } 
    }
    public function GetMatriculaMedico() {
        $sql=$this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id'=>$this->input->post('empleado_id')))[0];
         echo json_encode($sql['empleado_matricula']); 
    }

    public function getCama(){
        $Camas=$this->config_mdl->_get_data_condition('os_camas', array(
            'area_id'  => $this->input->post('area_id')
        ));
        if(count($Camas)>0) {
            $select_items = '';
            $select_items .= '<option value="" disabled selected>Seleccionar Cama</option>';
            foreach ($Camas as $cama) {
                $select_items .= '<option value="'.$cama['cama_id'].'">'.$cama['cama_nombre'].'</option>';
            } echo json_encode($select_items);
        }
    }

    /* Registro de Paciente desde el modal el el Area de admision hospitalaria*/
    public function RegistrarPaciente($Paciente)  {

        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(    
           'triage_id'=>  $Paciente
        ));

        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['solicitud']= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
           'triage_id'=> $Paciente
        ));
        $sql['empleado']= $this->config_mdl->_get_data_condition('os_empleados',array(
           'empleado_id'=> $this->UMAE_USER
        ));
        $sql['DirPaciente']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'=>  $Paciente,
           'directorio_tipo'=>'Paciente'
        ))[0];
        
        $sql['Doc43051'] = $this->config_mdl->_get_data_condition('doc_43051',array(
          'triage_id'       => $Paciente
        ))[0];

        $sql['medicoTratante'] = $this->config_mdl->_get_data_condition('os_empleados',array(
          'empleado_id'=> $sql['Doc43051']['ingreso_medico']
        ),'empleado_matricula,empleado_nombre,empleado_apellidos')[0];

         $sql['ordeninternamiento'] = $this->config_mdl->_get_data_condition('um_orden_internamiento',array(
          'triage_id' => $Paciente
        ));

        $sql['Especialidad'] = $this->config_mdl->_get_data_condition('um_especialidades',array(
          'especialidad_id'=> $sql['ordeninternamiento']['ordeni_especialidadid']
        ))[0];

         $sql['Especialidades'] = $this->config_mdl->_query("SELECT especialidad_id, especialidad_nombre FROM um_especialidades WHERE especialidad_hospitalizacion=1 ORDER BY especialidad_nombre");

        $sql['Medico']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_roles'=>'2',
            'empleado_jefe_servicio'=>'Si'
        ));
        
        $sql['Area'] = $this->config_mdl->_get_data_condition("os_areas", array(
            'area_modulo' => 'Pisos'));
        
        $sql['Cama'] =$this->config_mdl->_get_data_condition('os_camas', array(
            'area_id'     => $sql['Area'][0]['area_id']
        ));

        $sql['Empresa']  = $this->config_mdl->_get_data_condition('os_triage_empresa', array(
            'triage_id' => $Paciente
        ))[0];

        if(!empty($sql['Empresa'])) {
            $sql['DirEmpresa'] = $this->config_mdl->_get_data_condition('os_triage_directorio',array(
                'directorio_id'     =>  $sql['Empresa']['directorio_id'],
                'directorio_tipo'   => 'Empresa'
            ))[0];

        }

        $responsable = $this->config_mdl->_get_data_condition('os_triage_directorio', array(
            'triage_id' => $Paciente,
            'directorio_tipo'=>'Responsable'
        ));

        if(!empty($responsable)) {
            $sql['DirPaciente']['responsable'] = $responsable[0];
        }

        $this->load->view('Registro',$sql);
    }  

    public function Ajaxregistro43051() {
        /* verifica que este el paciete dado de Alta en el Archivo */
        $nss1 = $this->input->post('pum_nss');
        $nss = str_replace('-','',substr($nss1,0));
        $agregado = $this->input->post('pum_nss_agregado');
        $nssCompleto = $nss.'-'.$agregado;
        /*$area_acceso =  $this->config_mdl->sqlGetDataCondition('os_areas_acceso',array(
            'areas_acceso_nombre' => $this->input->post('area')))[0];*/

        $idPaciente=$this->config_mdl->sqlGetDataCondition('um_pacientes',array(
            'nssCom' =>  $nssCompleto))[0];

        $sql43051=$this->config_mdl->sqlGetDataCondition('doc_43051',array(
            'triage_id'=> $this->input->post('triage_id')
        ));

        $triage_empresa=$this->config_mdl->sqlGetDataCondition('os_triage_empresa',array(
            'triage_id'=> $this->input->post('triage_id')
        ));

        $fecha_i = strtr($this->input->post('fecha_ingreso'), '/', '-');
        $fecha_ingreso = date('Y-m-d', strtotime($fecha_i));

        if($this->input->post('tipo_ingreso') == 'Programado') {
            $medico_ordena_ingreso = $this->input->post('ingreso_medico');
        }
        
        $data_os_triage=array(
            'triage_via_registro'           => $this->input->post('via_registro'),
            'triage_horacero_f'             => date('Y-m-d'),
            'triage_horacero_h'             => date('H:i'),
            'triage_fecha'                  => date('Y-m-d'),
            'triage_hora'                   => date('H:i'),
            'triage_nombre'                 => $this->input->post('triage_nombre'), 
            'triage_nombre_ap'              => $this->input->post('triage_nombre_ap'), 
            'triage_nombre_am'              => $this->input->post('triage_nombre_am'), 
            'triage_paciente_sexo'          => $this->input->post('triage_paciente_sexo'),
            'triage_paciente_curp'          => $this->input->post('triage_paciente_curp'),
            'triage_fecha_nac'              => $this->input->post('triage_fecha_nac'),
            'triage_crea_am'                => $this->UMAE_USER,
            'triage_motivoAtencion'         => $this->input->post('motivo_internamiento')
        );

        $data_paciente_info = array(
            'pic_responsable_nombre'        => $this->input->post('pic_responsable_nombre'),
            'pum_nss'                       => $this->input->post('pum_nss'),
            'pum_nss_agregado'              => $this->input->post('pum_nss_agregado'),
            'pum_nss_armado'                => $this->input->post('pum_nss_armado'),
            'pum_umf'                       => $this->input->post('pum_umf'),
            'pum_delegacion'                => $this->input->post('pum_delegacion'),
            'pia_lugar_procedencia'         => 'Consulta Externa',
            'pic_responsable_parentesco'    => $this->input->post('pic_responsable_parentesco'),
            'pic_responsable_telefono'      => $this->input->post('pic_responsable_telefono'),
            'pia_vigencia'                  => $this->input->post('pia_vigencia'),
            'pia_documento'                 => $this->input->post('pia_documento'),
            'pia_procedencia_hospital'      => $this->input->post('pia_procedencia_hospital'),
            'pia_procedencia_hospital_num'  => $this->input->post('pia_procedencia_hospital_num')
      
        );

        $os_triage_empresa = array(
            'empresa_nombre'                => $this->input->post('empresa_nombre'),
            'triage_id'                     => $this->input->post('triage_id')
        );

        $os_triage_empresa_directorio = array(
            'directorio_tipo'               => 'Empresa',
            'directorio_cp'                 => $this->input->post('empresa_cp'          ),
            'directorio_cn'                 => $this->input->post('empresa_cn'          ),
            'directorio_colonia'            => $this->input->post('empresa_colonia'     ),
            'directorio_municipio'          => $this->input->post('empresa_municipio'   ),
            'directorio_estado'             => $this->input->post('empresa_estado'      ),
            'directorio_telefono'           => $this->input->post('empresa_telefono'    ),
        );
        $data_43051 = array(
            'tipo_ingreso'                  => $this->input->post('tipo_ingreso'),
            'estado_cama'                   => 'En espera',
            'estado_ingreso_med'            => 'Esperando',
            'fecha_registro'                => date('Y-m-d'),
            'hora_registro'                 => date('H:i:s'),
            'fecha_ingreso'                 => $fecha_ingreso,
            'hora_ingreso'                  => $this->input->post('hr_ingreso'),
            'ingreso_servicio'              => $this->input->post('ingreso_servicio'),
            'ingreso_medico'                => $this->input->post('ingreso_medico'),
            'ingresa_idmedico'              => $medico_ordena_ingreso,
            'diagnostico_presuntivo'        => $this->input->post('diagnostico'),
            'motivo_internamiento'          => $this->input->post('motivo_internamiento'),    
            'id_empleado_registra'          => $this->UMAE_USER,
            'riesgo_infeccion'              => $this->input->post('riesgo_infeccion'),
            'cama_id'                       => $this->input->post('cama'), 
            'area_id'                       => $this->input->post('area')
        );

        $idPaciente=Modules::run('Config/ObtenerPacienteUmae', $nssCompleto);
        $sqlFolio = $this->config_mdl->sqlGetDataCondition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $checkbox_p = isset($_POST['direccion_checkbox_parentesco']);
        if($checkbox_p){
            $os_triage_responsable_directorio = array(
                'directorio_tipo'               => 'Responsable',
                'directorio_cp'                 => $this->input->post('responsable_cp'      ),
                'directorio_cn'                 => $this->input->post('responsable_cn'      ),
                'directorio_colonia'            => $this->input->post('responsable_colonia' ),
                'directorio_municipio'          => $this->input->post('responsable_municipio'),
                'directorio_estado'             => $this->input->post('responsable_estado'  ),
                'directorio_telefono'           => $this->input->post('responsable_telefono'),
                'triage_id'                     => $this->input->post('triage_id')
            );
        }
        /* si es registro nuevo */
       
        if(empty($sqlFolio)) {
            $this->config_mdl->_insert('os_triage_directorio',$os_triage_empresa_directorio);
            $os_triage_empresa['directorio_id'] = $this->config_mdl->_get_last_id('os_triage_directorio','directorio_id');
            //$idPaciente=Modules::run('Config/ObtenerPacienteUmae', $nssCompleto);
            $data_os_triage['paciente_id'] = $idPaciente;
            $this->config_mdl->_insert('os_triage',$data_os_triage);
            $triage_id = $this->config_mdl->_get_last_id('os_triage','triage_id');
            //$data_os_triage['triage_id'] = $triage_id;
            $data_paciente_info['triage_id'] = $triage_id;
            $data_43051['triage_id'] = $triage_id;
            $data_43051['paciente_id'] = $idPaciente;
            $os_triage_empresa['triage_id'] = $triage_id;
            $this->config_mdl->_insert('paciente_info',     $data_paciente_info);
            $this->config_mdl->_insert('doc_43051',         $data_43051);
            $this->config_mdl->_insert('os_triage_empresa', $os_triage_empresa);
            if($checkbox_p){
                $os_triage_responsable_directorio['triage_id'] = $triage_id;
                $this->config_mdl->_insert('os_triage_directorio',$os_triage_responsable_directorio);
            }
            $this->AccesosUsuarios(array(
                'acceso_tipo'  => 'Asistente Médica',
                'triage_id'    => $triage_id,
                'acceso_tarea' => 'Registro 43051',
                'areas_id'     => $area_acceso
            ));
        }else {
            unset($data_43051['fecha_registro']); 
            unset($data_43051['hora_registro']);
            unset($data_43051['estado_ingreso_med']);
            unset($data_43051['id_empleado_registra']);
            //unset($data_43051['fecha_ingreso']);
            unset($data_os_triage['triage_horacero_f']);
            unset($data_os_triage['triage_horacero_h']);
            unset($data_os_triage['triage_fecha']);
            unset($data_os_triage['triage_hora']);
            unset($data_os_triage['triage_crea_am']);
            $os_triage_empresa['directorio_id'] = $this->config_mdl->sqlGetDataCondition('os_triage_empresa', array(
                'triage_id'=> $this->input->post('triage_id')
            ))[0]['directorio_id'];
            $this->config_mdl->_update_data('os_triage',$data_os_triage,
                array('triage_id'=> $this->input->post('triage_id'))
            );
            $this->config_mdl->_update_data('doc_43051', $data_43051,
                array('triage_id'=> $this->input->post('triage_id'))
            );
            $this->config_mdl->_update_data('paciente_info',$data_paciente_info,
                array('triage_id'=> $this->input->post('triage_id'))
            ); 
            $this->config_mdl->_update_data('os_triage_empresa',$os_triage_empresa,
                array('triage_id'=> $this->input->post('triage_id'))
            );
            $this->config_mdl->_update_data('os_triage_directorio', $os_triage_empresa_directorio,
                array('directorio_id'=> $os_triage_empresa['directorio_id'])
            );
            $_responsable_directorio = $this->config_mdl->sqlGetDataCondition('os_triage_directorio',array(
                'triage_id'         => $this->input->post('triage_id'),
                'directorio_tipo'   => 'Responsable'
            ));

            if(empty($_responsable_directorio)){     
                if($checkbox_p){
                    $os_triage_responsable_directorio['triage_id'] = $this->input->post('triage_id');
                    $this->config_mdl->_insert('os_triage_directorio',$os_triage_responsable_directorio);
                }
            }else{
                if($checkbox_p){
                    $this->config_mdl->_update_data('os_triage_directorio',  $os_triage_responsable_directorio,
                        array('directorio_tipo'   => 'Responsable',
                              'triage_id'         => $this->input->post('triage_id'))
                    );
                }else{
                    $this->config_mdl->_delete_data('os_triage_directorio',
                        array('directorio_tipo'   => 'Responsable',
                              'triage_id'         => $this->input->post('triage_id'))
                    );
                    //$this->config_mdl->_query("DELETE FROM os_triage_directorio WHERE triage_id =" . $this->input->post('triage_id') . 'AND directorio_tipo = "Responsable"'); 
                }
            }
            $triage_id  = $this->input->post('triage_id');
        }
        Modules::run('Triage/TriagePacienteDirectorio',array(
            'directorio_tipo'       => 'Paciente',
            'directorio_cp'         => $this->input->post('directorio_cp'       ),
            'directorio_cn'         => $this->input->post('directorio_cn'       ),
            'directorio_colonia'    => $this->input->post('directorio_colonia'  ),
            'directorio_municipio'  => $this->input->post('directorio_municipio'),
            'directorio_estado'     => $this->input->post('directorio_estado'   ),
            'directorio_telefono'   => $this->input->post('directorio_telefono' ),
            'triage_id'             => $triage_id
        ));
        $this->setOutput(array('accion'=>'1'));     
    }

    public function GenerarNssConformado() {
        if($this->input->post('triage_paciente_sexo')=='HOMBRE'){
            $agregado_sexo='0M';
        }else{
            $agregado_sexo='0F';
        }
        $numcon_id= $this->NumeroConsecutivo();
        $anio= substr(date('Y'), 2, 4);
        $NSS_c= date('dm').$anio.'50'.$numcon_id.'-'.$agregado_sexo.$this->input->post('fecha_nacimiento').'ND';
        
        // $this->NumeroConsecutivoLog(array(
        //         'numcon_nss'=>$NSS_A,
        //         'numcon_id'=>$numcon_id,
        //         'triage_id'=>$this->input->post('triage_id')
        // ));

        $this->setOutput(array('accion'=>'1','nss_c'=>$NSS_c));
    }

    public function NumeroConsecutivo() {
        $hoy= date('d-m-Y');
        $numcon_id= $this->config_mdl->_query("SELECT * FROM os_triage_numcon WHERE numcon_id=(SELECT MAX(numcon_id) FROM os_triage_numcon)");
        if(!empty($numcon_id)){
            if($hoy==$numcon_id[0]['numcon_fecha']){
                return $this->LastNumeroConsecutivo();
            }else{
                $this->config_mdl->TruncateTable("os_triage_numcon");
                return $this->LastNumeroConsecutivo();
            }
        }else{
            return $this->LastNumeroConsecutivo();
        }
    }
   
    public function LastNumeroConsecutivo() {
        $last_id=$this->config_mdl->_get_last_id('os_triage_numcon','numcon_id');
        if(empty($last_id)){
            $numCons = '01';
        }else {
                if(strlen($last_id)==1){
                    $last_id = ++$last_id;
                    $numCons = '0'.$last_id;
                    if($last_id==10) {
                        $numCons=$last_id;
                    }
                }else $numCons=$last_id+1;
              }
        return $numCons;
    }
    
    public function GuardaNssConformado($data) {
        $pinfo = $this->config_mdl->_get_data_condition('paciente_info', array(
            'triage_id' => $data['triage_id']
        ))[0];
        
        if($data['tiene_nss']=='No' && $pinfo['pum_nss_armado'] == '') {
            $this->config_mdl->_insert('os_triage_numcon',array(
                'numcon_fecha'=> date('d-m-Y')
            ));
            $this->config_mdl->_insert('os_triage_numcon_log',array(
                'numcon_log_fecha'=> date('d-m-Y'),
                'numcon_log_hora'=> date('H:i'),
                'numcon_nss'=>$data['numcon_nss'],
                'numcon_id'=>$data['numcon_id'],
                'empleado_id'=> $this->UMAE_USER,
                'triage_id'=>$data['triage_id']
            ));
        }
    }

    public function Getpisos() {
        $pisos = $this->config_mdl->_get_data_condition('os_pisos', 'area_id > 1'); 
        $optios_pisos = '';
        $optios_pisos .= 
        $option_pisos = '<option value="" disabled selected>Selecciona</option>';;
        foreach ($pisos as $value) {
            $option_pisos.='<option value="'.$value['area_id'].'">'.$value['piso_nombre_corto'].'</option>';
            
        }
       return $option_pisos;
    }

    public function OrdenInternamiento() {
        $check_orden = $this->config_mdl->_get_data_condition('um_orden_internamiento', array(
            'triage_id' => $this->input->post('triage_id')
        ))[0];
       
        if(empty($check_orden)) {
            /* si es de admision continua */
            if(Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER))== 1){
                $fecha_ingreso = date('Y-m-d H:i');
                
            }
            
            $this->config_mdl->_insert('um_orden_internamiento',array(
                'triage_id'           => $this->input->post('triage_id'),
                'servicio_origen_id'  => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'medico_origen_id'    => $this->UMAE_USER,
                'servicio_destino_id' => $this->input->post('servicio_solicitado_id'),
                'diagnostico_id'      => $this->input->post('dx_registrado'), //de la tabla de paciente_diagnostico
                'fecha_registro'      => date('Y-m-d H:i'),
                'fecha_ingreso'       => $fecha_ingreso,
                'motivo_internamiento'=> $this->input->post('motivo')

            ));
        }
         $this->setOutput(array('accion'=>'1'));

    }

    public function updateOrdenInternamiento() {
        $check_orden = $this->config_mdl->_get_data_condition('um_orden_internamiento', array(
            'triage_id' => $this->input->post('triage_id')
        ));
        if(!empty($check_orden)) {
            $this->config_mdl->_update_data('um_orden_internamiento',array(
                'servicio_origen_id'    => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'medico_origen_id'      => $this->UMAE_USER,
                'servicio_destino_id'   => $this->input->post('servicio_solicitado_id'),
                'fecha_ingreso'         => date('Y-m-d H:i'),
                'motivo_internamiento'  => $this->input->post('motivo')
                ),array(
                'triage_id' => $this->input->post('triage_id')
            ));
        }
         $this->setOutput(array('accion'=>'1'));
    }

    public function TestRegistroPacienteUmae($data) {
      $data_um_pacientes = array(
            'nss'       => '199282828',
            'agregado'  => '1M1970OR',
            'nssCom'    => '199282828-1M1970OR',
            'idUmf'     => '',
            'umf'       => 4,
            'nombre'    => 'TEST1',
            'apellidop' => 'TEST2', 
            'apellidom' => 'TEST3',
            'fechaNac'  => '12/12/1990',
            'sexo'      => 'MUJER',
            'estado'    => 'v',
            'fechaReg'  => date('Y-m-d H:i')
            
        );

        /* Buscar paciente en la tabla "um_pacientes" con nsscompleto si no esta insertar los datos */
        //$idPaciente=Modules::run('Config/ObtenerPacienteUmae', $nssCompleto);
        /*$buscaPaciente = $this->config_mdl->sqlGetDataCondition('um_pacientes', array(
            'nssCom' => $nssCompleto
        ))[0]; */
       
        Modules::run('Admisionhospitalaria/RegistrarPacienteUmae',$data_um_pacientes);
    
    }

    public function GetInfoParaAlta() {
        $cama = $this->input->post('cama');
        //$area = $this->input->post('area');
        //$folio = $this->input->post('folio');
        
        $sql= $this->config_mdl->sqlGetDataCondition('os_camas',array(
                'cama_id' => $cama
        ))[0];

        if(!empty($sql)){
            switch ($sql['proceso']){
                case 0:
                        $accion = 0;
                        break;
                case 1:
                        $accion = 1;
                        break;
                case 2:
                        $accion = 2;
                        break;
                case 3: 
                        $accion = 3;
                        break;
            }
        }

        $this->setOutput(array('accion'=>$accion));
       
    }

    public function ProcesoDeAlta() {
        $cama = $this->input->post('cama_id');
        $folio = $this->input->post('folio');
        $especialidad = "";
        $motivoEgreso = "";
        $infoC = $this->config_mdl->_query("SELECT os_camas.cama_id, triage_id, cama_nombre, proceso, cama_genero, piso_nombre_corto FROM os_camas
                                            INNER JOIN os_pisos
                                            INNER JOIN os_pisos_camas
                                            INNER JOIN os_areas
                                            WHERE os_areas.area_id=os_camas.area_id 
                                            AND  os_pisos_camas.cama_id=os_camas.cama_id
                                            AND  os_pisos_camas.piso_id=os_pisos.piso_id
                                            AND  os_camas.cama_id=".$cama)[0];

        $infoP = $this->config_mdl->_query("SELECT id,
                                                   triage_nombre,
                                                   triage_nombre_ap,
                                                   triage_nombre_am,
                                                   fecha_ingreso,
                                                   hora_ingreso,
                                                   fecha_asignacion,
                                                   tipo_ingreso,
                                                   pum_nss,
                                                   pum_nss_agregado,
                                                   pum_umf,
                                                   pum_delegacion
                                            FROM
                                                os_triage
                                                INNER JOIN doc_43051
                                                INNER JOIN paciente_info
                                            WHERE
                                                os_triage.triage_id = doc_43051.triage_id
                                                AND paciente_info.triage_id = os_triage.triage_id
                                                AND os_triage.triage_id = ".$folio)[0];

        /* $sqlDx = $this->config_mdl->_query("SELECT * FROM paciente_diagnosticos, um_cie10 WHERE 
                    paciente_diagnosticos.cie10_id=um_cie10.cie10_id AND 
                    paciente_diagnosticos.triage_id =".$infoC['triage_id']);*/

        $tiempoEstancia=Modules::run('Config/CalcularTiempoTranscurrido',array(
            'Tiempo1' =>  $infoP['fecha_ingreso'].' '.$infoP['hora_ingreso'],
            'Tiempo2' =>  date('Y-m-d H:i')
            ));

        if($infoC['proceso']==2 || $infoC['proceso']==1) {
            $notaEgreso= $this->config_mdl->_query("SELECT especialidad_id,
                                                       especialidad_nombre,
                                                       notas_medicotratante,
                                                       motivo_egreso,
                                                       empleado_apellidos,
                                                       empleado_nombre,
                                                       fecha_hora_alta,
                                                       prealta,
                                                       alta,
                                                       altacancelada

                                                FROM   doc_notas
                                                INNER JOIN doc_nota_egreso
                                                INNER JOIN um_alta_hospitalaria
                                                INNER JOIN um_especialidades
                                                INNER JOIN os_empleados 
                                                WHERE
                                                    doc_notas.notas_id = doc_nota_egreso.nota_id 
                                                    AND doc_nota_egreso.docnota_id = um_alta_hospitalaria.id_nota_egreso 
                                                    AND um_especialidades.especialidad_id = doc_notas.empleado_servicio_id
                                                    AND doc_notas.notas_medicotratante = os_empleados.empleado_id
                                                    AND doc_notas.triage_id =".$folio)[0];
            if(!empty($notaEgreso)) {
                switch ($notaEgreso['motivo_egreso']) {
                      case '1':
                                $motivoEgreso = 'Alta médica';                 
                        break;
                      case '2':
                                $motivoEgreso = 'Alta voluntaria';
                        break;
                      case '3':
                                $motivoEgreso = 'Alta por mejoría';
                        break;
                      case '4':
                                $motivoEgreso = 'Alta por máximo beneficio';
                        break;
                      case '5':
                                $motivoEgreso = 'Alta por tranferencia a otro centro hospitalario';
                        break;
                      case '6':
                                $motivoEgreso = 'Alta por defunción';
                        break;
                      case '7':
                                $motivoEgreso = 'Alta por fuga o abandono';
                        break;
                }
            }
    
            $this->setOutput(array('accion'      => '1',
                                    'infop'       => $infoP, 
                                    'infoc'       => $infoC,
                                    'infon'       => $notaEgreso, 
                                    'motivoe'     => $motivoEgreso,
                                    'cama'        => $cama,
                                    'fecha_egreso'=> date('d/m/Y H:i'),
                                    'testancia'   => $tiempoEstancia->format('%a dias').' '.$tiempoEstancia->h.' hrs' ));
            
        }elseif($infoC['proceso'] == 0 ){

            //$infoEgreso = 
            $sqlEspecialidad=$this->config_mdl->_get_data_order('um_especialidades',array(
                    'especialidad_hospitalizacion' => 1
                ),'especialidad_nombre','ASC');
            $sqlMotivoEgreso=$this->config_mdl->sqlGetData('um_motivo_egreso');
            
            $especialidad.='<option value="0" disable>Selecciona</option>';
            
            foreach ($sqlEspecialidad as $value) {           
                $especialidad.='<option value="'.$value['especialidad_id'].'">'.$value['especialidad_nombre'].'</option>';
            }

            $motivoEgreso .= '<option value="0" disable>Selecciona</option>';;
            
            foreach ($sqlMotivoEgreso as $value) {           
                $motivoEgreso.='<option value="'.$value['id'].'">'.$value['nombre'].'</option>';
            }
            
            $this->setOutput(array('accion'      => '2',
                                   'infop'       => $infoP, 
                                   'infoc'       => $infoC,
                                   'option'      => $especialidad,                                 
                                   'motivoe'     => $motivoEgreso,
                                   'cama'        => $cama,
                                   'fecha_egreso'=> date('d/m/Y H:i'),
                                   'testancia'   => $tiempoEstancia->format('%a dias').' '.$tiempoEstancia->h.' hrs' ));
        }
    }

    public function ConfirmarAltaCamaAsistenteMedica(){
        $folio = $this->input->post('folio');
        $servicio_egreso = $this->input->post('servicio_egreso');
        $paciente = $this->config_mdl->_query("SELECT id,
                                                      doc_43051.paciente_id,
                                                      triage_nombre,
                                                      triage_nombre_ap,
                                                      triage_nombre_am,
                                                      pum_nss,
                                                      pum_nss_agregado,
                                                      pum_umf,
                                                      pum_delegacion,
                                                      os_camas.cama_id,
                                                      cama_nombre,
                                                      os_camas.area_id,
                                                      proceso,
                                                      os_pisos.piso_nombre_corto,
                                                      tipo_ingreso,
                                                      doc_43051.ingresa_idmedico,
                                                      doc_43051.ingreso_servicio,
                                                      doc_43051.ingreso_medico,
                                                      doc_43051.salida_servicio,
                                                      doc_43051.salida_medico,
                                                      doc_43051.fecha_ingreso,
                                                      doc_43051.hora_ingreso,
                                                      doc_43051.fecha_asignacion,
                                                      doc_43051.fecha_egreso,
                                                      doc_43051.hora_egreso,
                                                      doc_43051.fecha_h_enfer_recibe_paci,
                                                      doc_43051.fecha_h_enfer_egresa_paci
                                                FROM  os_triage
                                                      INNER JOIN doc_43051
                                                      INNER JOIN paciente_info
                                                      INNER JOIN os_camas
                                                      INNER JOIN os_pisos
                                                WHERE os_triage.triage_id = doc_43051.triage_id
                                                      AND paciente_info.triage_id = os_triage.triage_id
                                                      AND os_camas.triage_id = doc_43051.triage_id
                                                      AND os_pisos.area_id = os_camas.area_id
                                                      AND os_triage.triage_id =".$folio)[0];

        $dx = $this->config_mdl->_query("SELECT * FROM   paciente_diagnosticos, um_cie10 WHERE  paciente_diagnosticos.cie10_id = um_cie10.cie10_id 
                                                    AND tipo_diagnostico = 3
                                                    AND paciente_diagnosticos.triage_id =".$folio)[0];

        if(!empty($servicio_egreso)){
          $salidaServicio= $servicio_egreso;
          $salidaMedico  = $this->input->post('medico_egreso');
          $motivoalta    = $this->input->post('motivo_egreso');
          $comentario    = $this->input->post('comentario');
          $proceso       = 2;
        }else {
            $notaAlta = $this->config_mdl->_query("SELECT fecha_nota,
                                                        hora_nota,
                                                        motivo_egreso,
                                                        fecha_hora_alta,
                                                        especialidad_id,
                                                        especialidad_nombre,
                                                        empleado_servicio_id,
                                                        notas_medicotratante,
                                                        motivo_egreso,
                                                        empleado_apellidos,
                                                        empleado_nombre,
                                                        notas_fecha,
                                                        notas_hora,
                                                        fecha_alta,
                                                        prealta,
                                                        alta
                                                    FROM  doc_notas
                                                        INNER JOIN doc_nota_egreso
                                                        INNER JOIN um_alta_hospitalaria
                                                        INNER JOIN um_especialidades
                                                        INNER JOIN os_empleados
                                                    WHERE doc_notas.notas_id = doc_nota_egreso.nota_id 
                                                        AND doc_nota_egreso.docnota_id = um_alta_hospitalaria.id_nota_egreso 
                                                        AND um_especialidades.especialidad_id = doc_notas.empleado_servicio_id
                                                        AND notas_medicotratante = os_empleados.empleado_id
                                                        AND um_alta_hospitalaria.alta = 1 
                                                        AND doc_notas.triage_id =".$folio)[0];
            
            $salidaServicio      = $notaAlta['empleado_servicio_id'];
            $salidaMedico        = $notaAlta['notas_medicotratante'];
            $motivoAlta          = $notaAlta['motivo_egreso'];
            $fecha_prealta       = $notaAlta['fecha_nota'];
            $fecha_h_prealta     = $notaAlta['fecha_nota'].' '.$notaAlta['hora_nota'];
            $fecha_h_alta_medico = $notaAlta['fecha_hora_alta'];
            $proceso             = $paciente['proceso'];
        }

        $this->config_mdl->_update_data('os_camas',array(
                'triage_id'      => Null,
                'cama_estado'    => 'Sucia',
                'cama_fh_estatus'=> date('Y-m-d H:i'),
                'proceso'        => $proceso,
                'cama_genero'    => 'Sin Especificar',
            ),array(
                'cama_id' => $this->input->post('cama_id')
            ));

            Modules::run('Areas/LogCamas',array(
                'log_estatus'=>'sucia',
                'cama_id'=>$this->input->post('cama_id'),
            ));
        
        $this->config_mdl->_update_data('doc_43051',array(
                'fecha_egreso'    => date('Y-m-d'),
                'hora_egreso'     => date('H:i'),
                'salida_servicio' => $salidaServicio,
                'salida_medico'   => $salidaMedico,
                'estado_cama'     => 'Liberada'
            ),array(
                'id'=>  $this->input->post('id_43051')
            ));

        /* Inserta en os_camas_estados */
        /* acciones 1=Reservado, 2=Ocupado, 3=Sucia, 4=Contaminada, 5=Descompuesta, 6=Limpia, 7=Disponibe=Vestida */
        $this->config_mdl->_insert('os_camas_estados',array(
            'id_43051'        => $this->input->post('id_43051'),
            'cama_id'         => $this->input->post('cama_id'),
            'empleado_id'     => $this->UMAE_USER,
            'triage_id'       => $folio,
            'accion'          => 3,
            'fecha_hora'      => date('Y-m-d H:i'),
            'estado'          => 'Sucia',
            'descripcion'     => 'Alta paciente por Asitente Médica'
        ));

        /*si enfermeria no  egresó paciente de cama toma la hora en que asistente da de alta*/
        if($paciente['fecha_h_enfer_egresa_paci'] == ''){ 
            $hora_enfer_egresa_pac = date('Y-m-d H:i');
            $hora_cama_sucia = date('Y-m-d H:i');;

        }else {
            /* Enfermeria si egreso paciente */
            $hora_enfer_egresa_pac = $paciente['fecha_h_enfer_egresa_paci']; 
            $hora_cama_sucia= $paciente['fecha_h_enfer_egresa_paci'];

        }

        /* Se manda informacion a Reporte de Egreso Hospitalario */

        $this->config_mdl->_insert('um_reporte_egresos_hospital',array(
                'idcama'                => $this->input->post('cama_id'),
                'idfolio'               => $folio,  
                'id43051'               => $this->input->post('id_43051'),
                'idservicio'            => $salidaServicio, 
                'iddxegreso'            => $dx['diagnostico_id'],          
                'cama'                  => $this->input->post('cama_id'),
                'medico'                => $salidaMedico,
                'servicio'              => $salidaServicio,
                'tipo_ingreso'          => $paciente['tipo_ingreso'],
                'nss'                   => $paciente['pum_nss'].' '.$paciente['pum_nss_agregado'],
                'paciente'              => $paciente['triage_nombre'].' '.$paciente['triage_nombre_ap'].' '.$paciente['triage_nombre_am'],
                'motivoalta'            => $motivoalta,
                'comentario'            => $comentario,
                'fecha_h_asigna_cama'   => $paciente['fecha_asignacion'],
                'fecha_h_ingreso'       => $paciente['fecha_ingreso'],
                'fecha_h_alta_hosp'     => date('Y-m-d H:i'),  // fecha y hora en que asistente medica da alta en camas       
                'fecha_prealta'         => $fecha_prealta,
                'fecha_alta'            => date('d-m-Y'),  // fecha en que asistente medica da alta en camas
                'fecha_h_prealta'       => $fecha_h_prealta,
                'fecha_h_alta_medico'   => $fecha_h_alta_medico, // fecha y hora en que medico da de alta 
                'fecha_h_enf_recibe_pac'=> $paciente['fecha_h_enfer_recibe_paci'],
                'fecha_h_enf_egresa_pac'=> $hora_enfer_egresa_pac,
                'fecha_h_cama_sucia'    => $hora_cama_sucia, 
                'dx'                    => $dx['cie10_nombre'] 

        ));

        $areas= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $folio
        ))[0];
        $this->AccesosUsuarios(array('acceso_tipo'=>'Alta '.$this->UMAE_AREA,'triage_id'=>$folio));
        
        $this->setOutput(array('accion'=>'1'));

    }

    public function ConsultaReporteAltas() {
      $fecha = $this->input->post('fecha');
      //$fecha_consulta = date('d-m-Y', strtotime($fecha));
      $tipoconsulta = $this->input->post('tipoconsulta');
      $draw = intval($this->input->post("draw"));
      $start = intval($this->input->post("start"));
      $length = intval($this->input->post("length"));
      $order = $this->input->post("order");
      $search= $this->input->post("search");
      $search = $search['value'];
      $col = 0;
      $dir = "";

    if($tipoconsulta == 'prealta' ) {
        //$registros= $this->config_mdl->_query("SELECT * FROM um_reporte_egresos_hospital WHERE fecha_prealta = '$fecha'");
        $registros=$this->config_mdl->_query("SELECT  os_triage.triage_id,
                                                      cama_nombre,
                                                      piso_nombre_corto,
                                                      especialidad_nombre,
                                                      triage_nombre_ap,
                                                      triage_nombre_am, 
                                                      triage_nombre,
                                                      pum_nss,
                                                      pum_nss_agregado,
                                                      fecha_nota,
                                                      hora_nota,
                                                      motivo_egreso,
                                                      empleado_apellidos,
                                                      empleado_nombre
                                                      FROM
                                                         doc_notas
                                                      INNER JOIN doc_nota_egreso
                                                      INNER JOIN um_alta_hospitalaria
                                                      INNER JOIN os_triage
                                                      INNER JOIN paciente_info
                                                      INNER JOIN os_camas
                                                      INNER JOIN os_pisos
                                                      INNER JOIN os_empleados
                                                      INNER JOIN um_especialidades                                                
                                                      WHERE doc_notas.notas_id = doc_nota_egreso.nota_id
                                                      AND  doc_nota_egreso.docnota_id = um_alta_hospitalaria.id_nota_egreso
                                                      AND    os_triage.triage_id = doc_notas.triage_id
                                                      AND  paciente_info.triage_id = os_triage.triage_id
                                                      AND  os_camas.triage_id = doc_notas.triage_id
                                                      AND  os_pisos.area_id = os_camas.area_id
                                                      AND  os_empleados.empleado_id = doc_notas.notas_medicotratante
                                                      AND  um_especialidades.especialidad_id = doc_notas.empleado_servicio_id
                                                       -- AND  prealta = 1                                                  
                                                      AND  doc_notas.notas_fecha = '$fecha'");
    }else {
        $registros= $this->config_mdl->_query("SELECT * FROM um_reporte_egresos_hospital WHERE fecha_alta = '$fecha'");
    }
    
    $datos=array();
        if(!empty($registros)) {
            foreach ($registros  as $value) {
                $diagnostico=$this->config_mdl->sqlGetDataCondition('paciente_diagnosticos',array(
                      'triage_id'        => $value['triage_id'],
                      'tipo_diagnostico' => '3'))[0];
                $dx_egreso = $this->config_mdl->_get_data_condition('um_cie10', array(
                     'cie10_id' => $diagnostico['cie10_id']))[0];

                // $Servicio=$this->config_mdl->sqlGetDataCondition('um_especialidades',array(
                //     'especialidad_id'=>$value['ingreso_servicio']),'especialidad_nombre')[0];

                // $camaInfo=$this->config_mdl->_get_data_condition('os_camas', array(
                //     'cama_id' => $value['cama_id']),'cama_nombre')[0]; 

                // $pisoInfo=$this->config_mdl->_get_data_condition('os_pisos', array(
                //     'area_id' => $value['area_id']))[0];

               switch ($value['motivo_egreso']) {
                  case '1':
                            $motivoAlta = 'Alta médica';                 
                    break;
                  case '2':
                            $motivoAlta = 'Alta voluntaria';
                    break;
                  case '3':
                            $motivoAlta = 'Alta por mejoría';
                    break;
                  case '4':
                            $motivoAlta = 'Alta por máximo beneficio';
                    break;
                  case '5':
                            $motivoAlta = 'Alta por tranferencia a otro centro hospitalario';
                    break;
                  case '6':
                            $motivoAlta = 'Alta por defunción';
                    break;
                  case '7':
                            $motivoAlta = 'Alta por fuga o abandono';
                    break;
               }
                

                $datos[] = array(

                                'cama'          => $value['cama_nombre'].' '.$value['piso_nombre_corto'],
                                'servicio'      => $value['especialidad_nombre'],
                                'nss'           => $value['pum_nss'].' '.$value['pum_nss_agregado'],
                                'paciente'      => $value['triage_nombre'].' '.$value['triage_nombre_ap'].' '.$value['triage_nombre_am'],
                                'tipo_ingreso'  => $value['triage_via_registro'],
                                'fecha_prealta' => $value['fecha_nota'].' '.$value['hora_nota'],
                                'servicio'      => $value['especialidad_nombre'],
                                'motivo_alta'   => $motivoAlta,
                                'medico'        => $value['empleado_apellidos'].' '.$value['empleado_nombre'],
                                'dx_alta'       => $dx_egreso['cie10_nombre']
                            ); 
               /* $datos[] = array(

                                'cama'          => $value['cama'],
                                'servicio'      => $value['especialidad_nombre'],
                                'nss'           => $value['n'],
                                'paciente'      => $value['paciente'],
                                'tipo_ingreso'  => $value['tipo_ingreso'],
                                'fecha_prealta' => $value['fecha_prealta'],
                                'fecha_ingreso' => $value['fecha_h_ingreso'],
                                'motivoalta'    => $value['motivoalta'],
                                'medico'        => $value['medico'],
                                'dx'            => $value['dx']
                            ); */
            }
             //$this->setOutput(array('accion'=>'1','tr'=>$tr));
            $total_pacientes = count($registros);
        }

        $output = array(
                        'draw' => $draw,
                        "recordsTotal" => $total_pacientes,
                        "recordsFiltered" => $total_pacientes,
                        'data' => $datos
        );
        //$this->output->set_header('Content-Type: application/json');
        $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output)); 

    }

    public function ToooltipInfoPaciente(){
        $folio = $this->input->post('folio');
        $dataTitle = '';

        $info = $this->config_mdl->_query("SELECT
                                            doc_43051.id,
                                            os_triage.triage_id,
                                            triage_nombre,
                                            triage_nombre_ap,
                                            triage_nombre_am,
                                            pum_nss,
                                            pum_nss_agregado,
                                            pum_umf,
                                            cama_nombre,
                                            os_pisos.piso_nombre_corto,
                                            tipo_ingreso,
                                            doc_43051.ingresa_idmedico,
                                            doc_43051.ingreso_servicio,
                                            doc_43051.ingreso_medico,
                                            doc_43051.salida_servicio,
                                            doc_43051.salida_medico,
                                            doc_43051.fecha_ingreso,
                                            doc_43051.hora_ingreso,
                                            doc_43051.fecha_asignacion,
                                            doc_43051.fecha_egreso,
                                            doc_43051.hora_egreso,
                                            doc_43051.fecha_h_enfer_recibe_paci
                                        FROM
                                            os_triage
                                            INNER JOIN doc_43051
                                            INNER JOIN paciente_info
                                            INNER JOIN os_camas
                                            INNER JOIN os_pisos
                                        WHERE
                                            os_triage.triage_id = doc_43051.triage_id 
                                            AND paciente_info.triage_id = os_triage.triage_id 
                                            AND os_camas.triage_id = doc_43051.triage_id 
                                            AND os_pisos.area_id = os_camas.area_id
                                            AND os_triage.triage_id =".$folio)[0];

        $medico = $this->config_mdl->sqlGetDataCondition('os_empleados',array(
                        'empleado_id'        => $info['ingreso_medico']))[0];

        $servicio = $this->config_mdl->_get_data_condition('um_especialidades', array(
                     'especialidad_id' => $info['ingreso_servicio']))[0];
        $nombrePaciente = $info['triage_nombre_ap'].' '.$info['triage_nombre_am'].' '.$info['triage_nombre'];
        $medicoTratante = $medico['empleado_apellidos'].' '.$medico['empleado_nombre'];

        $dataTitle = "<div class='tooltip-head'>
                        <div class='tooltip-title'>
                            <strong>DETALLE DEL PACIENTE</strong>
                            <strong class='tooltip-folio'>".$info['triage_id']."</strong>
                        </div>
                        <div class='tooltip-paciente '><strong>".$nombrePaciente."</strong></div>
                        
                        <div class='signosv'>
                            
                            <div class='div-sv divnamesv'>
                                <h3 class='sv-title svname'>Servicio</h3>
                                <p class='value-sv valuesv'>".$servicio['especialidad_nombre']."</p>
                            </div>
                            <div class='div-sv divnamesv'>
                                <h3 class='sv-title svname'>Médico</h3>
                                <p class='value-sv valuesv'>".$medicoTratante."</p>
                            </div>         
                        </div> 
                           
                        <div class='tooltip-sv-title'>Signos Vitales</div>
                        <div class='signosv'>
                            <div class='div-sv divnamesv'>
                                <h3 class='sv-title svname'>PANI</h3>
                                <p class='value-sv valuesv'>".$sv['sv_ta']."</p>
                            </div>
                            <div class='div-sv divnamesv'>
                                <h3 class='sv-title svname'>FC</h3>
                                <p class='value-sv valuesv'>".$sv['sv_fc']."</p>
                            </div>
                            <div class='div-sv divnamesv'>
                                <h3 class='sv-title svname'>FR</h3>
                                <p class='value-sv valuesv'>".$sv['sv_fr']."</p>
                            </div>         
                            <div class='div-sv divnamesv'>
                                <h3 class='sv-title svname''>sp02</h3>
                                <p class='value-sv valuesv'>".$sv['sv_oximetria']."</p>
                            </div>
                            <div class='div-sv divnamesv'>
                                <h3 class='sv-title svname''>Temp</h3>
                                <p class='value-sv valuesv'>".$sv['sv_temp']."</p>
                            </div>
                        </div>             
                        <div class='tooltip-footer'>Tiempo de Estancia: ".$tiempoEstancia->d."d"." ".$tiempoEstancia->h."h"." ".$tiempoEstancia->i."min</div>
                     </div>";

        $this->setOutput(array('accion'      => '1',
                               'paciente'    => $info, 
                               'servicio'    => $servicio,
                               'medico'      => $medico,
                               'datatitle'   => $dataTitle));

    }

    public function Bucaringresos() { 
        $fecha=$this->input->post('input_fecha');
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
                                            STR_TO_DATE(doc_43051.fecha_asignacion, '%Y-%m-%d') = '".$fecha."'");//2022-07-06
        foreach ($sql  as &$value) {
            if(is_numeric($value['diagnostico_presuntivo'])){
                $value['diagnostico_presuntivo'] = $this->config_mdl->_query("SELECT cie10_nombre FROM um_cie10 WHERE cie10_id = ".$value['diagnostico_presuntivo'])[0]["cie10_nombre"];
            }
        }
        $this->setOutput(array(
            'num_rows'=> count($sql),
            'sql'=> $sql
        ));
    }

    public function AjaxPacientesFolio() {
        //$fechaInicial= $this->input->post('fechaInicial');
        //$fechaFinal= $this->input->post('fechaFinal');
        $Folio = $this->input->post('Folio');
        $tipoconsulta = $this->input->post('tipoconsulta');
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search= $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if($tipoconsulta == 'preregistro' ) {
            $registros= $this->config_mdl->_query("SELECT * FROM doc_43051 INNER JOIN os_triage INNER JOIN paciente_info WHERE 
            doc_43051.triage_id     = os_triage.triage_id AND 
            doc_43051.triage_id     = paciente_info.triage_id AND
            doc_43051.triage_id     = $Folio"); 
        }
        $datos=array();
            if(!empty($registros)) {
                foreach ($registros  as $value) {
                    $Medico=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                         'empleado_id'=>$value['ingreso_medico']),'empleado_nombre, empleado_apellidos')[0];
                    $Servicio=$this->config_mdl->sqlGetDataCondition('um_especialidades',array(
                        'especialidad_id'=>$value['ingreso_servicio']),'especialidad_nombre')[0];
                    $camaInfo=$this->config_mdl->_get_data_condition('os_camas', array(
                        'cama_id' => $value['cama_id']),'cama_nombre')[0]; 
                    $pisoInfo=$this->config_mdl->_get_data_condition('os_pisos', array(
                        'area_id' => $value['area_id']))[0];
                    if($value['cama_id']!=''){
                        $cama= $camaInfo['cama_nombre'].'-'.$pisoInfo['piso_nombre_corto'];
                    }else{
                        $cama='<button type="button" id="asignarCama" data-cama="'.$value['triage_id'].'">Por asignar</button>';
                    }
                    if($this->UMAE_AREA == 'Asistente Médica Admisión Continua'){
                        $linkEditar= '<a href="'.base_url().'Asistentesmedicas/Hospitalizacion/Registro/'.$value['triage_id'].'" target="_blank" 
                                        rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-title="Editar">
                                        <i class="fa fa-edit icono-accion"></i></a>';
                    }else {
                        $linkEditar= '<a href="'.base_url().'Admisionhospitalaria/RegistrarPaciente/'.$value['triage_id'].'" target="_self" 
                                        rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-title="Editar">
                                        <i class="fa fa-edit icono-accion"></i></a>';
                    }
                    $imprimir43051 = '<a href="#" class="generar43051" data-triage="'.$value['triage_id'].'" ><i class="fa fa-print icono-accion icono-accion pointer tip" data-original-title="Requisitar Información 43051"></i></a>';
                    $datos[] = array(
                                    'triage_id'       => $value['triage_id'],
                                    'fecha_ingreso'   => date('d-m-Y H:i', strtotime($value['fecha_ingreso'])),
                                    'hora_ingreso'    => $value['hora_ingreso'],
                                    'afiliacion'      => $value['pum_nss'].' '.$value['pum_nss_agregado'],
                                    'nombre'          => $value['triage_nombre_ap'].' '.$value['triage_nombre_am'].' '.$value['triage_nombre'],
                                    'tipo_ingreso'    => $value['tipo_ingreso'],
                                    'servicio'        => $Servicio['especialidad_nombre'],
                                    'medico'          => $Medico['empleado_apellidos'].' '.$Medico['empleado_nombre'],
                                    'cama'            => $cama,
                                    'accion'          => $linkEditar.' '.$imprimir43051
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

    public function BuscarPaciente() {
        $this->load->view('BuscarPaciente');
    }

    public function Testquery($Paciente){

        $sql['Empresa']  = $this->config_mdl->_get_data_condition('os_triage_empresa', array(
            'triage_id' => $Paciente
        ))[0];

        if(!empty($sql['Empresa'])) {
            $sql['DirEmpresa'] = $this->config_mdl->_get_data_condition('os_triage_directorio',array(
                'directorio_id'     =>  $sql['Empresa'][0]['directorio_id'],
                'directorio_tipo'   => 'Empresa'
            ))[0];

        }

        echo json_encode($sql['Empresa']);

        /*$query = $this->config_mdl->_query("SELECT os_camas.cama_id,triage_id,cama_nombre,cama_genero,piso_nombre_corto FROM os_camas
                                            INNER JOIN os_pisos
                                            INNER JOIN os_pisos_camas
                                            INNER JOIN os_areas
                                            WHERE os_areas.area_id=os_camas.area_id 
                                            AND  os_pisos_camas.cama_id=os_camas.cama_id
                                            AND  os_pisos_camas.piso_id=os_pisos.piso_id
                                            AND  os_camas.cama_id =".$id)[0]; 
        $query = $this->config_mdl->_query("SELECT CONCAT(notas_fecha,' ',notas_hora) AS fechahora_prealta,
                                                    especialidad_id,
                                                    especialidad_nombre,
                                                    empleado_servicio_id,
                                                    notas_medicotratante,
                                                    motivo_egreso,
                                                    CONCAT(empleado_apellidos,' ',empleado_nombre) AS medico,
                                                    alta
                                                FROM
                                                    doc_notas
                                                    INNER JOIN doc_nota_egreso
                                                    INNER JOIN um_alta_hospitalaria
                                                    INNER JOIN um_especialidades
                                                    INNER JOIN os_empleados

                                                WHERE
                                                    doc_notas.notas_id = doc_nota_egreso.nota_id 
                                                    AND doc_nota_egreso.docnota_id = um_alta_hospitalaria.id_nota_egreso 
                                                    AND um_especialidades.especialidad_id = doc_notas.empleado_servicio_id
                                                    AND notas_medicotratante = os_empleados.empleado_id
                                                    AND um_alta_hospitalaria.alta = 1 
                                                    AND doc_notas.triage_id =".$id)[0];*/
        /*$query = $this->config_mdl->_query("SELECT id,
                                                      doc_43051.paciente_id,
                                                      triage_nombre,
                                                      triage_nombre_ap,
                                                      triage_nombre_am,
                                                      pum_nss,
                                                      pum_nss_agregado,
                                                      pum_umf,
                                                      pum_delegacion,
                                                      os_camas.cama_id,
                                                      cama_nombre,
                                                      os_camas.area_id,
                                                      os_pisos.piso_nombre_corto,
                                                      tipo_ingreso,
                                                      doc_43051.ingresa_idmedico,
                                                      doc_43051.ingreso_servicio,
                                                      doc_43051.ingreso_medico,
                                                      doc_43051.salida_servicio,
                                                      doc_43051.salida_medico,
                                                      doc_43051.fecha_ingreso,
                                                      doc_43051.hora_ingreso,
                                                      doc_43051.fecha_asignacion,
                                                      doc_43051.fecha_egreso,
                                                      doc_43051.hora_egreso,
                                                      doc_43051.fecha_h_enfer_recibe_paci,
                                                      doc_43051.fecha_h_enfer_egresa_paci
                                                FROM
                                                      os_triage
                                                      INNER JOIN doc_43051
                                                      INNER JOIN paciente_info
                                                      INNER JOIN os_camas
                                                      INNER JOIN os_pisos
                                                WHERE
                                                      os_triage.triage_id = doc_43051.triage_id
                                                      AND paciente_info.triage_id = os_triage.triage_id
                                                      AND os_camas.triage_id = doc_43051.triage_id
                                                      AND os_pisos.area_id = os_camas.area_id
                                                      AND os_triage.triage_id =".$id);*/

            /*$query=$this->config_mdl->_query("SELECT  os_triage.triage_id,
                                                      cama_nombre,
                                                      piso_nombre_corto,
                                                      especialidad_nombre,
                                                      triage_nombre_ap,
                                                      triage_nombre_am, 
                                                      triage_nombre,
                                                      pum_nss,
                                                      pum_nss_agregado,
                                                      fecha_nota,
                                                      hora_nota,
                                                      motivo_egreso,
                                                      empleado_apellidos,
                                                      empleado_nombre,
                                                      cie10_nombre
                                                      FROM
                                                         doc_notas
                                                      INNER JOIN doc_nota_egreso
                                                      INNER JOIN um_alta_hospitalaria
                                                      INNER JOIN os_triage
                                                      INNER JOIN paciente_info
                                                      INNER JOIN os_camas
                                                      INNER JOIN os_pisos
                                                      INNER JOIN os_empleados
                                                      INNER JOIN um_especialidades
                                                      INNER JOIN paciente_diagnosticos
                                                      INNER JOIN um_cie10 
                                                      WHERE doc_notas.notas_id = doc_nota_egreso.nota_id
                                                      AND  doc_nota_egreso.docnota_id = um_alta_hospitalaria.id_nota_egreso
                                                      AND    os_triage.triage_id = doc_notas.triage_id
                                                      AND  paciente_info.triage_id = os_triage.triage_id
                                                      AND  os_camas.triage_id = doc_notas.triage_id
                                                      AND  os_pisos.area_id = os_camas.area_id
                                                      AND  os_empleados.empleado_id = doc_notas.notas_medicotratante
                                                      AND  um_especialidades.especialidad_id = doc_notas.empleado_servicio_id
                                                      AND  paciente_diagnosticos.cie10_id = um_cie10.cie10_id
                                                      AND  paciente_diagnosticos.triage_id = doc_notas.triage_id
                                                      AND  tipo_diagnostico = 3
                                                      AND  prealta = 1
                                                      AND  doc_notas.triage_id = '$id'");*/
               

      /*$query= Modules::run('Config/CalcularTiempoTranscurrido',array(
                'Tiempo1'=>'2022-08-08 14:30',
                'Tiempo2'=> date('Y-m-d H:i')
                ));*/
       
     /*$query= Modules::run('Config/TiempoTranscurridoResult', array(
         'Tiempo1'=>'2022-08-05 14:30',
         'Tiempo2'=> date('Y-m-d H:i')
     ));*/


   
        //echo json_encode($query);
    }
    
}

