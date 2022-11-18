<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Urgencias
 *
 * @author felipe de jesus
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Urgencias extends Config{
    public function __construct() {
        parent::__construct();
        $this->VerificarSession();
    }
    public function Areas() {
        $this->load->view('pisos/Camas/GestionCamas');
    }

    public function Productividad() {
        $sql['medicosAC']= $this->config_mdl->_query("SELECT * FROM os_empleados
                                                            WHERE os_empleados.empleado_servicio = 1
                                                            AND os_empleados.empleado_roles = 2 ORDER BY empleado_nombre ASC");
        $this->load->view('Productividad', $sql);
    } 

    public function AjaxProductividad() {
        $areaMedico = $this->input->post('inputArea');
        $idMedico = $this->input->post('idMedico'); 
        $inputFechaInicio= $this->input->post('inputFechaInicio');
        $selectTurno = $this->input->post('selectTurno');
        $sqlDocumentos= $this->config_mdl->_get_data_condition('pc_documentos',array( 
                                    'doc_tipo'=>'NOTAS FORMATO 4 30 128'
                                    ));

        if ($areaMedico == 'Cons-Obs') {
            switch ($selectTurno) {
                case 'Mañana':
                    $HF= count($this->config_mdl->_query("SELECT hf_id FROM os_consultorios_especialidad_hf WHERE
                                                        empleado_id='$idMedico' AND hf_fg='$inputFechaInicio' AND hf_hg BETWEEN '07:20' AND '14:00' "));

                    $Total=0;
                    foreach ($sqlDocumentos as $value) {
                        $TipoDoc=$value['doc_nombre'];
                        $TotalNotas= count($this->config_mdl->_query("SELECT notas_id FROM doc_notas WHERE doc_notas.notas_tipo='$TipoDoc' AND
                            doc_notas.empleado_id='$idMedico' AND doc_notas.notas_fecha='$inputFechaInicio' AND notas_hora  BETWEEN '07:20' AND '14:00' "));
                        $Total=$TotalNotas+$Total;
                    }
                    break;
                
                case 'Tarde':
                    $HF= count($this->config_mdl->_query("SELECT hf_id FROM os_consultorios_especialidad_hf WHERE
                                                        empleado_id='$idMedico' AND hf_fg='$inputFechaInicio' AND hf_hg BETWEEN '14:00' AND '20:30' "));
                    $Total=0;
                    foreach ($sqlDocumentos as $value) {
                        $TipoDoc=$value['doc_nombre'];
                        $TotalNotas= count($this->config_mdl->_query("SELECT notas_id FROM doc_notas WHERE doc_notas.notas_tipo='$TipoDoc' AND
                            doc_notas.empleado_id='$idMedico' AND doc_notas.notas_fecha='$inputFechaInicio' AND notas_hora  BETWEEN '14:00' AND '20:30' "));
                        $Total=$TotalNotas+$Total;
                    }  
                    break;

                case 'Noche':
                    $fechaNocheB = strtotime('+1 day', strtotime($inputFechaInicio)); 
                    $fechaNocheB = date('d-m-Y', $fechaNocheB);
                    $HF_A = count($this->config_mdl->_query("SELECT hf_id FROM os_consultorios_especialidad_hf WHERE
                                                        empleado_id='$idMedico' AND hf_fg='$inputFechaInicio' AND hf_hg BETWEEN '20:30' AND '23:59' "));
                    $HF_B = count($this->config_mdl->_query("SELECT hf_id FROM os_consultorios_especialidad_hf WHERE
                                                        empleado_id='$idMedico' AND hf_fg='$fechaNocheB' AND hf_hg BETWEEN '00:00' AND '07:20' "));
                    $HF = $HF_A + $HF_B;
                    
                    $Total=0;
                    foreach ($sqlDocumentos as $value) {
                        $TipoDoc=$value['doc_nombre'];
                        $TotalNotas= count($this->config_mdl->_query("SELECT notas_id FROM doc_notas WHERE doc_notas.notas_tipo='$TipoDoc' AND
                            doc_notas.empleado_id='$idMedico' AND doc_notas.notas_fecha='$inputFechaInicio' AND notas_hora  BETWEEN '20:30' AND '23:59'
                            UNION
                            SELECT notas_id FROM doc_notas WHERE doc_notas.notas_tipo='$TipoDoc' AND
                            doc_notas.empleado_id='$idMedico' AND doc_notas.notas_fecha='$fechaNocheB' AND notas_hora  BETWEEN '00:00' AND '07:20' "));
                        $Total = $TotalNotas + $Total;
                    }    
                          

                    break;
            }
            
            
            // $sqlDocumentos= $this->config_mdl->_get_data_condition('pc_documentos',array(
            //     'doc_tipo'=>'NOTAS FORMATO 4 30 128'
            // ));
            
            // $Total=0;
            // foreach ($sqlDocumentos as $value) {
            //     $TipoDoc=$value['doc_nombre'];
            //     $TotalConsultorios= count($this->config_mdl->_query("SELECT notas_id FROM doc_notas WHERE doc_notas.notas_tipo='$TipoDoc' AND
            //                 doc_notas.empleado_id='$idMedico' AND doc_notas.notas_fecha='$inputFechaInicio'"));
            //     $Total=$TotalConsultorios+$Total;
            // }
            $this->setOutput(array(
                'TOTAL_DOCS'=>$HF+$Total
            ));
        } else { // Si Médico esta en área de TRIAGE

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
            $fecha = date("Y-m-d", strtotime($inputFechaInicio));
            if ($selectTurno == 'Noche') {
                $fechaNocheB = strtotime('+1 day', strtotime($inputFechaInicio)); 
                $fechaNocheB = date('Y-m-d', $fechaNocheB);

                $TOTAL = count($this->config_mdl->_query(
                    "SELECT * FROM os_triage WHERE triage_crea_medico = '$idMedico' 
                        AND triage_fecha_clasifica = '$fecha'
                        AND triage_fecha_clasifica != ''    
                        AND triage_hora_clasifica BETWEEN '$horaInicial_A' AND '$horaFinal_A'
                    UNION
                    SELECT * FROM os_triage WHERE triage_crea_medico = '$idMedico' 
                        AND triage_fecha_clasifica = '$fechaNocheB'
                        AND triage_fecha_clasifica != ''    
                        AND triage_hora_clasifica BETWEEN '$horaInicial_B' AND '$horaFinal_B'
                "));        
            
            }else {
                 $TOTAL = count($this->config_mdl->_query("
                    SELECT * FROM os_triage WHERE triage_crea_medico = '$idMedico' 
                    AND triage_fecha_clasifica = '$fecha'
                    AND triage_fecha_clasifica != ''    
                    AND triage_hora_clasifica BETWEEN '$horaInicial' AND '$horaFinal'
                    "));
            }
            $this->setOutput(array(
                'TOTAL_DOCS'=>$TOTAL
            ));
        }

    }

    public function CargarCamas(){
        $Camas=  $this->config_mdl->_query("SELECT * FROM os_camas, os_areas WHERE os_areas.area_id=os_camas.area_id AND os_camas.area_id= 1"); 
        $fila .= '<div class="row">';
        
        if(!empty($Camas)){
            
            foreach ($Camas as $value) {
                $pacienteNombre='';
                $Pulsera='';
                $icono = ''; 
                $Medico ='';
                $folio='';
                $triageColor='';
                $colorTriage='';
                $Color='';
                $fhrIngreso='';
                $medico = '';
                $nss = '';
                $dataTitle='';
                $fragilidad='';
               
                if($value["cama_estado"]=='Disponible'){
                    $Color='blue';
                   
                }else if($value["cama_estado"]=='Ocupado'){
                    $Color='green';
                    $sqlPaciente= $this->config_mdl->_get_data_condition("os_triage",array(
                        'triage_id'=>$value['triage_id']
                    ))[0];
                    $infoPaciente= $this->config_mdl->_get_data_condition("paciente_info",array(
                        'triage_id'=>$value['triage_id']
                    ))[0];
                    $sqlObs= $this->config_mdl->_get_data_condition('os_observacion',array(
                        'triage_id'=>$value['triage_id']
                    ))[0];
                    $sv = $this->config_mdl->_query("SELECT * FROM os_triage_signosvitales WHERE sv_id = 
                                                              (SELECT MAX(sv_id) FROM os_triage_signosvitales where triage_id='".$value['triage_id']."')")[0];
                    $sqlEscalas = $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
                        'triage_id'=>$value['triage_id']
                    ))[0];
                                    
                    //$nss = $infoPaciente['pum_nss'].' '.$infoPaciente['pum_nss_agregado'];
                    $fhrIngreso=$value['cama_ingreso_f'].' '.$value['cama_ingreso_h'];

                    $folio='<b>'.$value['triage_id'].'</b>';
                    
                    if ($sqlPaciente['triage_nombre'] == '') {
                        $pacienteNombre= $sqlPaciente['triage_nombre_pseudonimo'];
                    }else {
                        $pacienteNombre= $sqlPaciente['triage_nombre'].' '.$sqlPaciente['triage_nombre_ap'].' '.$sqlPaciente['triage_nombre_am'];
                    }
                    
                    $medico=$sqlObs['observacion_medico_nombre'];                        
                    
                    if($value['cama_genero']=='HOMBRE'){
                        $icono = 'fa-male';
                        $colorIcono = 'powderblue';
                    }else if($value['cama_genero']=='MUJER') {
                        $icono = 'fa-female';
                        $colorIcono = 'pink';
                    }else $icono = '';

                    switch ($sqlPaciente['triage_color']) {
                        case 'Rojo':
                                    $triageColor = "Red";
                            break;
                        case 'Naranja':
                                    $triageColor = "Orange";
                            break;
                        case 'Amarillo':
                                    $triageColor = "Yellow";
                            break;
                        case 'Azul':
                                    $triageColor = "Blue";
                            break;
                        case 'Verde':
                                    $triageColor = "Green";
                            break;
                    }

                    switch ($sqlEscalas['escala_fragilidad']) {
                        case '0 ptos: Paciente robusto':
                                    $fragilidad = "Robusto";
                            break;
                        case '1 ptos: Paciente prefrágil':
                                    $fragilidad = "Prefrágil";
                            break;
                        case '2 ptos: Paciente prefrágil':
                                    $fragilidad = "Prefrágil";
                            break;
                        case '3 ptos: Paciente Frágil':
                                    $fragilidad = "Frágil";
                            break;
                        case '4 ptos: Paciente Frágil':
                                    $fragilidad = "Frágil";
                            break;
                        case '5 ptos: Paciente Frágil':
                                    $fragilidad = "Frágil";
                            break;
                    }

                    $fechaNac= Modules::run('Config/ModCalcularEdad',array('fecha'=>$sqlPaciente['triage_fecha_nac'])); 


                    $colorTriage='<i class="fa fa-square" style="color:'.$triageColor.'"></i>';

                    $dataTitle = "<div class='tooltip-head'>
                                    <div class='tooltip-title'>
                                        <strong>DETALLE DEL PACIENTE</strong>
                                        <strong class='tooltip-folio'>".$sqlPaciente['triage_id']."</strong>
                                    </div>
                                    <div class='tooltip-paciente'>".$pacienteNombre."</div>
                                    <div class='signosv'>
                                        <div class='div-sv divnamesv'>
                                            <h3 class='sv-title svname'>Edad</h3>
                                            <p class='value-sv valuesv'>".($fechaNac->y==0 ? $fechaNac->m.' MESES' : $fechaNac->y.' a.,')."</p>
                                        </div>
                                        <div class='div-sv divnamesv'>
                                            <h3 class='sv-title svname'>Fragilidad</h3>
                                            <p class='value-sv valuesv'>".$fragilidad."</p>
                                        </div>
                                        <div class='div-sv divnamesv'>
                                            <h3 class='sv-title svname'>Funcionalidad</h3>
                                            <p class='value-sv valuesv'>".$sqlEscalas['funcionalidad_barthel']."</p>
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

                }else if($value["cama_estado"]=='En Mantenimiento'){
                    $Color='red';
                }else if($value["cama_estado"]=='En Limpieza'){
                    $Color='orange';    
                }

                $tiempoEstancia=Modules::run('Config/CalcularTiempoTranscurrido',array(
                                    'Tiempo1'   => str_replace('/', '-', $value['cama_ingreso_f']).' '.$value['cama_ingreso_h'],
                                    'Tiempo2'   => date('d-m-Y').' '.date('H:i')));
                                    
                
                $fila .='<div class="col-md-1 cols-camas" style="padding: 3px;margin-top:-10px">
                            <div class="card '.$Color.' color-white">
                                <a rel="tooltip" class="camaInfo" id="'.$value['cama_id'].'" 
                                    data-toggle="tooltip"
                                    data-trigger="hover" 
                                    data-placement="bottom"
                                    data-html="true" 
                                    data-title="'.$dataTitle.'"
                                >
                                    <div class="card-heading">
                                        <h5 class="font-thin color-white" style="font-size:12px!important;margin-left: -20px;margin-top: -15px;margin-bottom:-2px; width:100px;">
                                            <i class="fa fa-bed"></i><br>'.$value['cama_nombre'].'
                                        </h5>
                                    </div>
                                    <div class="card-body"> 
                                        <div class="col-md-12" style="margin: -35px;font-size:12px">
                                            <span>'.$colorTriage.' '.$value['triage_id'].'</span>          
                                        </div>
                                        <div class="col-md-12" style="margin-top:-15px">
                                            <small style="opacity: 1;font-size: 9px"> 
                                                <span class="pull-right" style="width:80px;">'.$fhrIngreso.'</span>
                                            </small>
                                        </div>
                                    </div>
                                </a>              
                            </div>
                        </div>';

                $info[] = array(
            
                    'afiliacion' => $nss,
                    'paciente'   => $pacienteNombre,
                    'medico'     => $medico
                );

                /*$signosVitales[] = array(
                    ''
                );*/
               
            }
             $fila .= '</div>';
            
        }else{
            $fila='NO_HAY_CAMAS';
        }
        $this->setOutput(array(
            'fila'          => $fila,
            'info'         => $info,
            'medico'        => $medico
        ));
    }

    public function FetchDataTooltip(){
        $camaId=  $this->config_mdl->_get_data_condition("os_camas",array(
                        'cama_id' => $this->input->post('id')
                    ))[0];

        
        
        $info = '';
        $nss= '';

        foreach($camaid as $value) {
            $sqlPaciente= $this->config_mdl->_get_data_condition("os_triage",array(
                        'triage_id'=>$camaId['triage_id']
                    ))[0];
            $infoPaciente= $this->config_mdl->_get_data_condition("paciente_info",array(
                'triage_id'=>$camaId['triage_id']
            ))[0];
            $sqlObs= $this->config_mdl->_get_data_condition('os_observacion',array(
                'triage_id'=>$camaId['triage_id']
            ))[0];
            $signosVitales= $this->config_mdl->_get_data_condition('os_triage_signosvitales',array(
                'triage_id'=>$camaId['triage_id']
            ))[0];

            if ($sqlPaciente['triage_nombre'] == '') {
                $pacienteNombre= $sqlPaciente['triage_nombre_pseudonimo'];
            }else {
                $pacienteNombre= $sqlPaciente['triage_nombre'].' '.$sqlPaciente['triage_nombre_ap'].' '.$sqlPaciente['triage_nombre_am'];
            }
            $nss = $infoPaciente['pum_nss'].' '.$infoPaciente['pum_nss_agregado'];

            $info = '<h4>'.$pacienteNombre.'</h4>
                     <label>'.$nss.'</label>
                    ';

        }      

        echo $info;
        /*$this->setOutput(array(
            'paciente'          => $pacienteNombre,
            'nss'         => $nss
        ));*/
    }

    public function example() {
        $value['triage_id']=2;
        $signosVitales = $this->config_mdl->_query("SELECT * FROM os_triage_signosvitales WHERE sv_id = (SELECT MAX(sv_id) FROM os_triage_signosvitales where triage_id='".$value['triage_id']."')");

        echo json_encode($value['triage_id']);
    }
}   