<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Consultorios
 *
 * @author Francisco Carrillo
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Hospitalizacion extends Config{
    public function __construct() {
        parent::__construct();
        $this->VerificarSession();
    }
    public function index() {
        
        $this->load->view('index',$sql);
    }
    public function DivisionDeCalidad() {
        $sql['Piso'] = $this->config_mdl->_get_data('os_camas');    
        $this->load->view('DivisionDeCalidad', $sql);
    }
    public function DireccionEnfermeria() {
        $sql['Piso'] = $this->config_mdl->_get_data('os_camas');    
        $this->load->view('DireccionEnfermeria', $sql);
    }
    
    public function Enfermeria() {
        $sql['Piso'] = $this->config_mdl->_get_data('os_pisos');    
        $this->load->view('enfermeria', $sql);
    }

    public function Limpiezaehigiene(){
        $this->load->view('Limpiezaehigiene', $sql);
    }

    public function Pacientes() {
        $hoy = date('Y-m-d');
        //$fecha_de_ingreso = date('Y-m-d', strtotime( $fecha));
        $Atributos='os_triage.triage_id, fecha_ingreso, hora_atencion, triage_nombre, triage_nombre_ap, triage_nombre_am, id_servicio, estado, pum_nss, pum_nss_agregado';
        $sql['Gestion']=$this->config_mdl->_query("SELECT $Atributos
            FROM um_ingresos_hospitalario,
                 um_ingresos_hospitalario_llamada, 
                 os_triage, 
                 paciente_info
            WHERE um_ingresos_hospitalario.id=um_ingresos_hospitalario_llamada.id_ingreso AND
                    um_ingresos_hospitalario.triage_id=os_triage.triage_id AND
                    um_ingresos_hospitalario.estado!='Salida' AND
                    os_triage.triage_id=paciente_info.triage_id AND 
                    um_ingresos_hospitalario.id_servicio=".Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER))." ORDER BY fecha_ingreso DESC LIMIT 100");

        $sqlMedico= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_id'=> $this->UMAE_USER
        ));
        $sql['Medico'] = $sqlMedico[0];
        $especialidad = $this->config_mdl->_get_data_condition("um_especialidades",array(
                        'especialidad_id'=>$sqlMedico[0]['empleado_servicio']))[0];

        $sql['ingresoPacientes'] = $this->config_mdl->_query("
            SELECT * FROM doc_43051, os_triage
            WHERE
                doc_43051.triage_id = os_triage.triage_id AND
                doc_43051.estado_ingreso_med = 'Esperando' AND
                fecha_ingreso = '$hoy' AND
                doc_43051.ingreso_servicio ='".$especialidad['especialidad_id']."' ORDER BY id DESC LIMIT 70");
        
        $this->load->view('pacientes', $sql);
    }

    public function AjaxObtenerPaciente() {
        $sqlHosp    = $this->config_mdl->_query("SELECT * FROM um_ingresos_hospitalario WHERE triage_id=".$this->input->post('triage_id'));
        $sqlPaciente= $this->config_mdl->_query("SELECT * FROM os_triage WHERE triage_id=".$this->input->post('triage_id'))[0];
        
        if($sqlPaciente['triage_crea_am']!=''){
            if(!empty($sqlHosp)){
                $medico= $this->config_mdl->_get_data_condition('os_empleados',array(
                    'empleado_id'=>$sqlHosp[0]['id_medico']
                ));
                $this->setOutput(array('paciente'=> $sqlPaciente,
                                       'hosp'    => $sqlHosp[0],
                                       'servicio'=> Modules::run('Config/ObtenerNombreServicio',array('servicio_id'=>$sqlHosp[0]['id_servicio'])),
                                       'medico'  => $medico[0],
                                       'accion'  => 'ASIGNADO'));
            }else{
                
                $this->setOutput(array('accion'=>'NO_EXISTE_EN_HOSP','paciente'=>$sqlPaciente));
            }
        }else{
                $this->setOutput(array('accion'=>'NO_AM'));
        }
        
    }

    /* Funcion para agregar paciente al servicio en area Hospitalización */
     public function AjaxAgregarIngreso() {
        $triage_id = $this->input->post('triage_id');
        if($triage_id == NULL){
            $this->setOutput(array('accion'=> 2, "str" => $triage_id ));
        }else{
            $value = array(
                'fecha_ingreso'     => date('Y-m-d'),
                'hora_atencion'     => date('H:i:s'),
                'id_medico'         => $this->UMAE_USER,
                'estado'            => 'Asignado',
                'id_servicio'       => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'triage_id'         => $triage_id,
                'interconsulta'     => 'No'
            );
            $this->config_mdl->_insert('um_ingresos_hospitalario', $value);
            $this->config_mdl->_insert('um_medico_tratante', array(
                'triage_id' => $triage_id,
                'empleado_id' => $this->UMAE_USER,
                'fecha_inicio' => date('d-m-Y')." ".date('H:i')
            ));
    
            $sqlMaxId= $this->config_mdl->_get_last_id('um_ingresos_hospitalario','id');
            $this->config_mdl->_insert('um_ingresos_hospitalario_llamada',array(
                'triage_id'=> $triage_id,
                'id_ingreso'=>$sqlMaxId
            ));
            
            $this->config_mdl->_update_data('doc_43051', array('estado_ingreso_med' => 'Asignado'), array('triage_id'=> $this->input->post('triage_id')));
            $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso Hospitalizacion Medico','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$sqlMaxId));
    
            $tiempo_estancia=Modules::run('Config/CalcularTiempoTranscurrido',array('Tiempo1'=> str_replace('/', '-', $value['fecha_ingreso']).' '.$value['hora_atencion'],'Tiempo2'=>date('d-m-Y').' '.date('H:i')));
            $Atributos='os_triage.triage_id, fecha_ingreso, hora_atencion, triage_nombre, triage_nombre_ap, triage_nombre_am, pum_nss, pum_nss_agregado, cama_nombre, cama_id';
            
            $cama=$this->config_mdl->_query( "SELECT * FROM os_camas WHERE os_camas.triage_id   = ".$triage_id);
            if (count($cama) != 0){
                $Gestion=$this->config_mdl->_query("SELECT *
                                                    FROM um_ingresos_hospitalario, os_triage, paciente_info, os_camas,um_ingresos_hospitalario_llamada
                                                    WHERE  
                                                    um_ingresos_hospitalario.id=um_ingresos_hospitalario_llamada.id_ingreso AND
                                                    um_ingresos_hospitalario.triage_id=os_triage.triage_id AND
                                                    os_triage.triage_id=paciente_info.triage_id AND
                                                    os_camas.triage_id = um_ingresos_hospitalario.triage_id AND
                                                    os_triage.triage_id = ".$value['triage_id'])[0];
            
                $piso=$this->config_mdl->_query("SELECT * 
                                                        FROM 
                                                            os_pisos,
                                                            os_pisos_camas 
                                                        WHERE 
                                                            os_pisos.piso_id            = os_pisos_camas.piso_id 
                                                            AND os_pisos_camas.cama_id  = ".$Gestion['cama_id'])[0];
            }else{
                $Gestion=$this->config_mdl->_query("SELECT *
                                                    FROM um_ingresos_hospitalario, os_triage, paciente_info,um_ingresos_hospitalario_llamada
                                                    WHERE  
                                                    um_ingresos_hospitalario.id=um_ingresos_hospitalario_llamada.id_ingreso AND
                                                    um_ingresos_hospitalario.triage_id=os_triage.triage_id AND
                                                    os_triage.triage_id=paciente_info.triage_id AND
                                                    os_triage.triage_id = ".$value['triage_id'])[0];
                $piso = [];
            }
            $sqlInterconsulta=$this->config_mdl->_query("SELECT doc_estatus,doc_id,especialidad_nombre FROM doc_430200
                                                            INNER JOIN um_especialidades ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
                                                            WHERE triage_id = ".$value['triage_id']);
            //$sqlInterconsulta = array();
            $Total = count($sqlInterconsulta);
            $str = "<tr id=". $value['triage_id'] .' class="footable-odd" >'.
                '<td style="text-align: center">'.
                    date('d-m-y', strtotime($Gestion['fecha_ingreso'])).$Gestion['hora_atencion'].
                '</td>
                <td>'.$value['triage_id'].'</td>'.        
                '<td style="font-size: 12px;text-align:left;">'.    
                    $Gestion['triage_nombre_ap']." ".$Gestion['triage_nombre_am']." ".$Gestion['triage_nombre'].
                '</td>
                <td>'.$Gestion['pum_nss']." ".$Gestion['pum_nss_agregado'].'</td>
                <td>'.$Gestion['cama_nombre']." ".$piso['piso_nombre_corto'].'</td>
                <td>'.$tiempo_estancia->d.' d '.$tiempo_estancia->h.' hrs '.$tiempo_estancia->i.' min</td><td>';
            $str .= '</td>
                <td >           
                    <a href="'.base_url().'Sections/Documentos/Expediente/'.$value['triage_id'].'/?tipo=Hospitalizacion" target="_blank">
                        <i class="fa fa-pencil-square-o icono-accion tip" data-original-title="Requisitar Información"></i>
                    </a>';
            if($value['hora_atencion']){
                $str .= '<i class="fa fa-sign-out tip alta-paciente-servicio pointer icono-accion" data-id="'.$value['triage_id'].'" data-original-title="Reportar ALta del Paciente"></i>';
            }
            $str .= '</td> </tr>';
            $this->setOutput(array('accion'=>'1', "str" => $str , "ext" => $sqlInterconsulta, "value" => $value ));
        }
    }
    
    public function AjaxReportarAlta() {
        $data=array(
            'estado'        => 'Salida',
            'fecha_salida'  => date('Y-m-d'),
            'hora_salida'   => date('H:i')
         );
        $this->config_mdl->_update_data('um_ingresos_hospitalario',$data,array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        
        $this->AccesosUsuarios(array('acceso_tipo'=>'Alta de Consultorio','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$ce['ce_id']));
        $this->setOutput(array('accion'=>'1'));
    }

    public function AjaxCamasPiso() {
        $SemaforoColores    = array(
            array("", "", ""),
            array("yellow", "", ""),
            array("yellow", "yellow", ""),
            array("yellow", "yellow", "yellow")
        );
        $campos =  'os_camas.cama_id,
                    triage_id,
                    piso_nombre,
                    piso_nombre_corto,
                    cama_nombre,
                    cama_estado,
                    cama_genero,
                    cama_fh_estatus';

        $pisoSelect = $this->input->post('piso');

        $camas = $this->config_mdl->_query("SELECT * FROM os_camas, os_areas, os_pisos, os_pisos_camas, os_pisos_sc 
                                            WHERE 
                                                os_areas.area_id=os_camas.area_id 
                                            AND os_pisos_camas.cama_id = os_camas.cama_id 
                                            AND os_pisos_camas.piso_id = os_pisos.piso_id 
                                            AND os_pisos_sc.cama_id = os_camas.cama_id 
                                            AND os_pisos.piso_id = ".$pisoSelect." ");
        $totalCamas = count($camas);
        $disponibles= $this->totalCamasEstado($pisoSelect, 'Disponible'); //Esta Vestida
        $ocupadas = $this->totalCamasEstado($pisoSelect, 'Ocupado');
        $sucias= $this->totalCamasEstado($pisoSelect, 'Sucia');   // Esta sucia
        $descompuestas = $this->totalCamasEstado($pisoSelect, 'Descompuesta'); 
        $contaminadas = $this->totalCamasEstado($pisoSelect, 'Contaminada');        // Esta descompuesta
        $prealtas = $this->totalCamasEstado($pisoSelect, 'Prealta'); // Esta descompuesta
        $limpias = $this->totalCamasEstado($pisoSelect, 'Limpia');
        $Notas = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 0");
        $NotasDes = $this->config_mdl->_query("SELECT * FROM os_camas_notas WHERE estado = 0 and tipo_nota = 1");
        $col = '';
        $i='';
        $col.='<div class="tablero-piso">
                    <div id="bead-map" >
                        <div class="container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12">  
                            <div class="container-camas col-lg-12 col-md-12 col-sm-12 col-xs-12 rowCamas">'; 
                                foreach($camas as $value) {
                                    if($value['borde']=='0'){
                                        $borde = 'camaSinBorde';
                                    }else if($value['borde']=='1') {
                                        $borde = 'camaBordeIzq';
                                    }else if($value['borde']=='2') {
                                        $borde = 'camaBordeMedio';
                                    }else if($value['borde']=='3') {
                                        $borde = 'camaBordeDer';
                                    }
                                     if($value['proceso']=='0' || $value['proceso']==Null){
                                        $proceso = '.';
                                        $color = 'white';
                                    }else if($value['proceso']=='1') {
                                        $proceso = 'PA';
                                        $color = 'orange';
                                    }else if($value['proceso']=='2') {
                                        $proceso = 'A';
                                        $color = 'black';
                                    }else if($value['proceso']=='3'){
                                        $proceso = 'CC';
                                        $color = 'red';
                                    }
                                    $CamaStatus = $this->CamaStatus($value['cama_estado'], $value['cama_genero']);
                                    $CamaCeldaSemaforo = $value['cama_display'];
                                    $col.='<div class="contenedor  fila '.$borde.'">
                                                <div style="color: '.$color.';">
                                                    <div id="' . $value['cama_id'] . "_semaforo_0" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][0] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $value['cama_id'] . '" data-estado="' . $value['cama_estado'] . '" data-cama_nombre="' . $value['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>
                                                    <div id="' . $value['cama_id'] . "_semaforo_1" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][1] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $value['cama_id'] . '" data-estado="' . $value['cama_estado'] . '" data-cama_nombre="' . $value['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>
                                                    <div id="' . $value['cama_id'] . "_semaforo_2" . '" " class="cama-celda-semaforo ' . $SemaforoColores[$CamaCeldaSemaforo][2] . ' " data-toggle="tooltip" data-animation="true" role="checkbox" data-cama="' . $value['cama_id'] . '" data-estado="' . $value['cama_estado'] . '" data-cama_nombre="' . $value['cama_nombre'] . '"  data-trigger="hover" data-placement="top" data-html="true"></div>                    
                                                    <strong>
                                                        <center>'.$proceso.'</center>
                                                    </strong>
                                                </div>
                                                <div  id="'.$value['cama_id'].'" data-trigger="hover" rel="tooltip" class="cama-no cama-celda '.$CamaStatus.' color-white cama'.$value['cama_id'].' '.$value['cama_genero'].'" data-folio="'.$value['triage_id'].'" data-cama="'.$value['cama_id'].'" data-accion="'.$value['cama_estado'].'" data-cama_nombre='.$value['cama_nombre'].' data-toggle="tooltip" data-placement="top" title="'.$value['triage_id'].'" data-folio="'.$value['triage_id'].'" data-paciente="'.$proceso.'">
                                                    <i class="fa fa-bed"></i>
                                                    <h6 style="margin-top: 3px; color:black"><b>'.$value['cama_nombre'].'</b></h6>
                                                    <div class="tooltip" id="tooltip'.$value['cama_id'].'"> </div>
                                                </div>';
                                    $NotasLen = 0;
                                    foreach ($Notas as $Nota) {
                                        if ($Nota["cama_id"] == $value['cama_id']) {
                                            $NotasLen += 1;
                                        }
                                    }
                                    if ($NotasLen > 0) { $Op = 1;}else{$Op = 0;}
                                    $NotasLenDes = 0;
                                    foreach ($NotasDes as $Nota) {
                                        if ($Nota["cama_id"] == $value['cama_id']) {
                                            $NotasLenDes += 1;
                                        }
                                    }
                                    if ($NotasLenDes > 0) { $OpDes = 1;}else{$OpDes = 0;}
                                    $col .=     '<div id = "nota_' . $value['cama_id'] . '" class="notificacion-nota" ' . 'data-cama-nombre=' . $value['cama_nombre'] . ' data-cama-id=' . $value['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $Op . '"><p>' . "$NotasLen" . '</p></div>
                                    <div id = "nota_des_' . $value['cama_id'] . '" class="notificacion-nota-des" ' . 'data-cama-nombre=' . $value['cama_nombre'] . ' data-cama-id=' . $value['cama_id'] . ' data-cama-status=' . $CamaStatus . ' data-Notas-Len=' . $NotasLen . ' style="opacity:' . $OpDes . '"><p>' . "$NotasLenDes" . '</p></div>       
                                    </div>';
                                }
                      $col.='</div>'; 
                 $col.='</div>'; 
             $col.='</div>';
        $col .='</div>'; 
        $col .='<link href="'.base_url().'assets/libs/css/tooltip.css" rel="stylesheet" type="text/css" />';
        
        //$col .='<script src="'.base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?'). md5(microtime()).'" type="text/javascript"></script>';
        $this->setOutput(array('accion'=>'1',
                'Col'           => $col,
                'Piso'          => $camas[0]['piso_nombre'],
                'Total'         => $totalCamas,
                'Disponibles'   => $disponibles,
                'Ocupadas'      => $ocupadas,
                'Sucias'        => $sucias,
                'Descompuestas' => $descompuestas,
                'Contaminadas'  => $contaminadas,
                'Prealtas'      => $prealtas,
                'Limpias'       => $limpias
            ));

    }

    public function CamaStatus($estado,$genero) {
        switch ($estado) {
            case 'Disponible':
                return 'green';
                break;
            
            case 'Sucia':
                return 'grey-900';
                break;

            case 'Descompuesta':
                return 'yellow-600';
                break;
            case 'Reparada':
                return 'lime';
                break;
            case 'Ocupado':
                
                    if($genero=='HOMBRE') {
                            return 'blue-800';
                        }else if($genero=='MUJER'){ 
                            return 'pink-A100';
                        }
                break;
            case 'Reservada':
                return 'purple-300';
                break;
            case 'Limpia':
                return 'cyan-400';
                break;
            case 'Contaminada':
                return 'red';
                break;
        }
    }

    public function totalCamasEstado($Piso,$Estado) {
        return count($this->config_mdl->_query("SELECT os_camas.cama_id FROM os_camas, os_areas, os_pisos, os_pisos_camas
                                            WHERE os_areas.area_id=os_camas.area_id AND os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_camas.cama_estado='$Estado' AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id AND os_pisos.piso_id=".$Piso));        
    }

    public function AjaxInfoPacienteCama(){
        
        $triage_id = $this->input->post('triage_id');
        $cama_id = $this->input->post('cama_id');
        $cama_name =  $this->input->post('cama_name');
        $proceso = '';

        $pacienteInfo = $this->config_mdl->_query("SELECT * FROM os_triage, paciente_info, os_triage_directorio  
                                            WHERE paciente_info.triage_id = os_triage.triage_id 
                                            AND os_triage_directorio.triage_id=os_triage.triage_id 
                                            AND os_triage.triage_id =".$triage_id);
        $infoEspecialidad= $this->config_mdl->_query("SELECT id,fecha_ingreso,hora_ingreso,fecha_egreso,ingreso_servicio,ingreso_medico,tipo_ingreso,diagnostico_presuntivo,especialidad_nombre,
                                                CONCAT(empleado_apellidos,' ',empleado_nombre) AS medico 
                                               FROM doc_43051 INNER JOIN um_especialidades  
                                                              INNER JOIN os_empleados 
                                               WHERE 
                                               doc_43051.ingreso_servicio = um_especialidades.especialidad_id AND
                                               doc_43051.ingreso_medico = os_empleados.empleado_id AND
                                               doc_43051.triage_id = '$triage_id'");

        $cama=$this->config_mdl->_get_data_condition('os_camas',array(
                'cama_id' => $cama_id))[0];

        $paciente = $pacienteInfo[0]['triage_nombre'].' '.$pacienteInfo[0]['triage_nombre_ap'].' '.$pacienteInfo[0]['triage_nombre_am'];
        switch($cama['proceso']){
            case 1:
                   $proceso = 'Pre-alta';
                   break;
            case 2:
                   $proceso = 'Alta médica';
                   break;
            case 3:
                   $proceso = 'Cambio de Cama';
                   break;
        }
        
        /* acciones de botones para camas */
        /* 1=Reservado,
           2=Ocupado,
           3=Sucia,
           4=Contaminada,
           5=Descompuesta,
           6=Limpia,
           7=vestida=Disponible */
        if($cama['cama_estado'] == 'Reservada'){
            $status = 'Ingreso';
            $botones = '<span class="label label-success btnAccion" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'" data-accion="1">Recibir paciente</span>';
        }elseif($cama['cama_estado'] == 'Ocupado'){
            $botones = '<span class="label label-default btnAccion" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'" data-accion="3">Sucia</span>
                        <span class="label label-danger btnAccion" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'" data-accion="4">Contaminada</span>
                        <span class="label label-warning btnAccion" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'" data-accion="5">Descompuesta</span>';
            $status = 'Ocupada';
        }elseif($cama['cama_estado'] == 'Limpia') {
            if($cama['triage_id']== '' || $cama['triage_id']==Null || $cama['proceso'] == '2' || $cama['proceso'] == '3'){
                $botones = '<span class="label label-success btnAccion" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'" data-accion="7" data-paciente="">Vestir</span>';
            }else {$botones = '<span class="label label-success btnAccion" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'" data-accion="2">Ocupado</span>';}
            $status = 'Limpia';
        }elseif($cama['cama_estado'] == 'Reparada') {
            $botones = '<span class="label label-default btnAccion" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'" data-accion="3">Sucia</span>
                        <span class="label label-success btnAccion" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'" data-accion="7">Vestida o Ocupada</span>';
        }

        if($pacienteInfo[0]['triage_paciente_sexo']=='HOMBRE'){
            $iconColor='color:blue';
        }else{
            $iconColor='color:#ff8499';
        }

        if($triage_id == 0){
            $htmlInfoPaciente='';
        }else {
            $htmlInfoPaciente='<div class="col-md-12">
                                <div class="col-md-1">
                                    <div class="icon-bedpatient"><i class="font-bedpatient" style="'.$iconColor.'">&#xe802;</i></div>                                    
                                    <div class="estado-paciente" style="position: absolute;top:87px;left:15px;"><h4>'.$status.'</h4></div>
                                    <div class="estado-paciente" style="position: absolute;top:110px;left:10px;color:red"><h4>'.$proceso.'</h4></div>
                                </div>
                                <div class="col-md-8">
                                    <h4 ><strong>'.$paciente.'</strong></h4>
                                    <ul class="list-unstyled">
                                      <li><strong>NSS: </strong>'.$pacienteInfo[0]['pum_nss'].' '.$pacienteInfo[0]['pum_nss_agregado'].'</li>
                                      <li><strong>Fecha de nacimiento: </strong>'.$pacienteInfo[0]['triage_fecha_nac'].'</li>
                                      <li><strong>Folio de ingreso: </strong>'.$pacienteInfo[0]['triage_id'].'</li>
                                      <li><strong>Familiar responsable: </strong>'.$pacienteInfo[0]['pic_responsable_nombre'].' / '.'<b>Teléfono:</b> '.$pacienteInfo[0]['pic_responsable_telefono'].'</li>
                                      <li><hr></li>
                                      <li><strong>Servicio: </strong>'.$infoEspecialidad[0]['especialidad_nombre'].'</li>
                                      <li><strong>Médico: </strong>'.$infoEspecialidad[0]['medico'].'</li>
                                      <li><strong>Fecha de Ingreso: </strong>'.date("d-m-Y", strtotime($infoEspecialidad[0]['fecha_ingreso'])).'</li>
                                      <li><strong>Fecha de Alta: </strong>'.$infoEspecialidad[0]['fecha_egreso'].'</li>
                                    </ul>
                                </div>  
                           </div>';
        }
        

        $this->setOutput(array('accion'=>'1',
                'infoPaciente' => $htmlInfoPaciente,
                'infoCama'     => $cama_name,
                'camaid'       => $cama_id,
                'estados'      => $botones

            ));

    }
    public function SolicitaCambioEstado(){
        $accion = $this->input->post('accion');
        $cama_id = $this->input->post('cama_id');
        $triage_id = $this->input->post('triage_id');
        $estado_paciente = $this->input->post('estadoPaciente');
        $cama_display = "0";
        /* acciones de botones en camas */
        /* 1=Reservado,
           2=Ocupado,
           3=Sucia,
           4=Contaminada,
           5=Descompuesta,
           6=Limpia,
           7=vestida=Disponible   
           Acciones de la camas de Limpieza e Higiene y Conservacion 
           Clicck en Cama Sucia  => acccion = 6
           */
        
        switch ($accion) {
            case 1:
                    $estado = 'Ocupado';   //<- Estado a cambiar
                    $descripcion = 'Enfermera recibe paciente';
                    $this->RegistroEstadosCamas($accion,$cama_id,$triage_id,$estado,$descripcion);
                    /* Hace cambio de botones */
                    $botones = '<span class="label label-default sucia" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'">Sucia</span>
                        <span class="label label-danger contaminada" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'">Contaminada</span>
                        <span class="label label-warning descompuesta" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'">Descompuesta</span>';

                    $this->config_mdl->_update_data('doc_43051', array(
                                        'estado_cama'               => 'Asignada',
                                        'fecha_h_enfer_recibe_paci' => date('Y-m-d H:i')), array(
                                        'triage_id'                 => $triage_id));
                break;
            case 2:
                    $estado='Ocupado';
                    $descripcion = 'Enfermera reingresa paciente';
                    $this->RegistroEstadosCamas($accion,$cama_id,$triage_id,$estado,$descripcion);
                    $botones = '<span class="label label-default sucia" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'">Sucia</span>
                        <span class="label label-danger contaminada" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'">Contaminada</span>
                        <span class="label label-warning descompuesta" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'">Descompuesta</span>';
                break;
            case 3:/* accion boton a Sucia */
                    $estado = 'Sucia';
                    $descripcion = 'Enfermera cambia a sucia';
                    $this->RegistroEstadosCamas($accion,$cama_id,$triage_id,$estado,$descripcion);
                    $botones = '';
                break;
            case 4: /*boton Contaminada */
                    $estado = 'Contaminada';
                    $descripcion = 'Enfermera cambia e estado contaminada';
                    $this->RegistroEstadosCamas($accion,$cama_id,$triage_id,$estado,$descripcion);
                    $botones = '';
                    $cama_display = "3";
                break;
            case 5: /*boton Descompuesta */
                    $estado = 'Descompuesta';
                    $descripcion = 'Enfermera cambia e estado Descompuesta';
                    $this->RegistroEstadosCamas($accion,$cama_id,$triage_id,$estado,$descripcion);
                    $botones = '';
                break;
            case 6: 
                    $estado = 'Limpia'; // cambiar a limpia
                    if($triage_id == '0'){
                          $descripcion = 'Limpieza camma sucia por cambio paciente'; 
                    }else $descripcion = 'Limpieza de cama por alta paciente';
                    $this->RegistroEstadosCamas($accion,$cama_id,$triage_id,$estado,$descripcion);
                    $botones = '';
                    if($estado_paciente == 'A'){
                        $this->config_mdl->_update_data('um_reporte_egresos_hospital', array(
                                        'fecha_h_cama_limpia' => date('Y-m-d H:i')), array(
                                        'idcama'         => $this->input->post('cama_id')));
                    }
                    $this->config_mdl->_update_data('os_camas_notas', array(
                        'estado'        => "1"), array(
                        'cama_id'       => $cama_id));
                break;
            case 7: 
                    $cama=$this->config_mdl->sqlGetDataCondition('os_camas',array(
                        'cama_id' => $cama_id))[0];
                    if(($cama['proceso'] == '2' && $cama['cama_estado'] =='Limpia') || $cama['cama_estado']=='Limpia'){
                          $estado = 'Disponible';
                           $this->config_mdl->_update_data('um_reporte_egresos_hospital', array(
                                        'fecha_h_cama_vestida' => date('Y-m-d H:i')), array(
                                        'idcama'         => $cama_id));
                           $this->config_mdl->_update_data('os_camas', array(
                                        'triage_id'       => Null,
                                        'cama_estado'     => $estado,
                                        'proceso'         => 0,
                                        'cama_genero'     => 'Sin Especificar',
                                        'cama_ingreso_f'  => '',
                                        'cama_ingreso_h'  => '',
                                        'cama_fh_estatus' => date('Y-m-d H:i')), array(
                                        'cama_id'         => $this->input->post('cama_id')));
                    $descripcion = 'Enfermeria cambia a vestida';       

                    }else {
                        $estado = 'Ocupado';
                        $descripcion = 'Enfermeria cambia a Ocupado';
                    
                        $this->RegistroEstadosCamas($accion,$cama_id,$triage_id,$estado,$descripcion);
                        $botones = '<span class="label label-default sucia" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'">Sucia</span>
                            <span class="label label-danger contaminada" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'">Contaminada</span>
                            <span class="label label-warning descompuesta" data-cama="'.$cama_id.'" data-folio="'.$triage_id.'">Descompuesta</span>';
                    }
                break;
        }
        
        $this->config_mdl->_update_data('os_camas', array(
                                        'cama_estado'     => $estado,
                                        'cama_fh_estatus' => date('Y-m-d H:i'),
                                        'cama_display'    => $cama_display), array(
                                        'cama_id'         => $cama_id));
        $this->setOutput(array(
            'accion'        => $accion,
            'estadosbtns'   => $botones,
            'estado'        => $estado,
            'descripcion'   => $descripcion,
            'cama_id'       => $cama_id
        ));
    }

    public function RegistroEstadosCamas($accion,$cama_id,$triage_id,$estado,$descripcion){

        $id_43051 = $this->config_mdl->sqlGetDataCondition('doc_43051',array(
            'triage_id' => $triage_id            
            ))[0];
        if(empty($id_43051)){
              $id43051=0;
        }else $id43051=$id_43051['id'];
        
        $this->config_mdl->_insert('os_camas_estados',array(
                            'id_43051'     => $id_43051['id'],
                            'cama_id'      => $cama_id,    
                            'empleado_id'  => $this->UMAE_USER,
                            'triage_id'    => $triage_id,
                            'accion'       => $accion,
                            'fecha_hora'   => date('Y-m-d H:i'),
                            'estado'       => $estado,
                            'descripcion'  => $descripcion));

        //$this->config_mdl->_update_data('doc_43051', array('horaenfrecibpaciente' => date('H:i')), array('triage_id'=> $triage_id));

    }
    public function AjaxVestirCama(){
        $cama_id = $this->input->post('cama_id');
        $cama = $this->config_mdl->sqlGetDataCondition('os_camas',array(
            'cama_id' => $cama_id
        ))[0];
        if(empty($cama)){
            $this->setOutput(array(
                "accion"    => 1,
                "data"      =>  $cama
            ));
        }else{
            $this->config_mdl->_update_data('os_camas', array(
                'cama_estado'     => 'Disponible'), array(
                'cama_id'         => $cama_id));
            $this->setOutput(array(
                "accion"    => 2,
                "data"      =>  $cama
            ));
        }
    }
    public function BuscarPacienteDDC(){
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
                if ($this->UMAE_AREA == 'División de Calidad') {
                    $cama = $this->config_mdl->_query("SELECT cama_nombre, piso_nombre_corto from os_camas, os_pisos where os_pisos.area_id = os_camas.area_id and os_camas.triage_id = '".$value['triage_id']."'");
                    if (empty($cama)){
                        $cama = "Por asignar";
                    }else{
                        $cama = $cama[0]["piso_nombre_corto"]." ".$cama[0]["cama_nombre"];
                    }
                    $tr .= '<tr>
                        <td>' . $value['nombre_paciente'] . '</td>
                        <td>' . $value['triage_id'] . '</td>
                        <td>' . $nss . '</td>
                        <td>' . date("d-m-Y", strtotime($value['fecha_ingreso'])) . '</td>
                        <td>' . $cama . '</td>
                    <tr>';
                }
            }
            $this->setOutput(array('accion' => '1', 'tr' => $tr, 'sql' => $sql, "area" => $this->UMAE_AREA, "inputSearch" => $_POST['inputSearch'] ));
        } else {
            $tr .= '<tr> <td colspan="5" class="text-center mayus-bold"><i class="fa fa-frown-o fa-3x" style="color:#256659"></i><br>No se encontro ningún registro</td><tr>';
            $this->setOutput(array('accion' => '1', 'tr' => $tr, 'sql' => $sql, "area" => $this->UMAE_AREA, "inputSearch" => $_POST['inputSearch'] ));
        }
    }
    public function BorraPacienteIngreso(){
        $data=array(
            'estado_ingreso_med' => 'Borrado'
         );
        $this->config_mdl->_update_data('doc_43051',$data,array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        
        //$this->AccesosUsuarios(array('acceso_tipo'=>'Borrado','triage_id'=>$this->input->post('triage_id'),'areas_id'=>'Hospitalización'));
        $this->setOutput(array('accion'=>'1'));
    }

    public function BuscarPacientesPendientes (){
        
    }
}