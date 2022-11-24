<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Consultorios
 *
 * @author felipe de jesus
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Consultorios extends Config{
    public function __construct() {
        parent::__construct();
        $this->VerificarSession();
    }
    public function index() {
        $sql['Consultorio']= $this->BuscarConsultorio($this->UMAE_AREA);
        $Atributos='os_triage.triage_id, ce_fe,ce_he,triage_nombre, triage_nombre_ap,triage_nombre_am,ce_asignado_consultorio,ce_status';
        $sql['Gestion']=$this->config_mdl->_query("SELECT $Atributos
          FROM os_consultorios_especialidad, os_consultorios_especialidad_llamada, os_triage
          WHERE os_consultorios_especialidad.ce_id=os_consultorios_especialidad_llamada.ce_id_ce AND
                os_consultorios_especialidad.triage_id=os_triage.triage_id AND
                os_consultorios_especialidad.ce_status!='Salida' AND
                os_consultorios_especialidad.ce_crea=$this->UMAE_USER ORDER BY os_consultorios_especialidad_llamada.cel_id DESC LIMIT 30");
        $this->load->view('index',$sql);
    }
    public function AjaxReportarSalida() {
        $data=array(
            'ce_status'=>'Salida',
            'ce_fs'=>date('Y-m-d'),
            'ce_hs'=>date('H:i')
         );
        $this->config_mdl->_update_data('os_consultorios_especialidad',$data,array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $ce=$this->config_mdl->sqlGetDataCondition('os_consultorios_especialidad',array(
            'triage_id'=>  $this->input->post('triage_id')
        ),'ce_id,ce_hf')[0];
        if($ce['ce_hf']=='Alta a Domicilio'){
            $this->config_mdl->_insert('doc_43029',array(
                'doc_fecha'=> date('Y-m-d'),
                'doc_hora'=> date('H:i:s'),
                'doc_turno'=>Modules::run('Config/ObtenerTurno'),
                'doc_destino'=> 'Domicilio',
                'doc_tipo'=>'Egreso',
                'empleado_id'=> $this->UMAE_USER,
                'triage_id'=>  $this->input->post('triage_id')
            ));
        }
        $this->AccesosUsuarios(array('acceso_tipo'=>'Alta de Consultorio','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$ce['ce_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxAltaPorAusencia() {
        $data=array(
            'ce_status'=>'Salida',
            'ce_fs'=>date('Y-m-d'),
            'ce_hs'=>date('H:i')
        );
        $this->config_mdl->_update_data('os_consultorios_especialidad',$data,array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $ce=$this->config_mdl->sqlGetDataCondition('os_consultorios_especialidad',array(
            'triage_id'=>  $this->input->post('triage_id')
        ),'ce_id')[0];
        $this->AccesosUsuarios(array('acceso_tipo'=>'Alta de Consultorio por Ausencia','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$ce['ce_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxSalidaObservacion() {
        $this->config_mdl->_update_data('os_consultorios_especialidad',array(
            'ce_hf'=>'Observación',
            'ce_status'=>'Salida',
            'ce_fs'=>date('Y-m-d'),
            'ce_hs'=>date('H:i')
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $ce=$this->config_mdl->sqlGetDataCondition('os_consultorios_especialidad',array(
            'triage_id'=>  $this->input->post('triage_id')
        ),'ce_id')[0];
        $this->config_mdl->_insert('doc_43029',array(
            'doc_fecha'=> date('Y-m-d'),
            'doc_hora'=> date('H:i:s'),
            'doc_turno'=>Modules::run('Config/ObtenerTurno'),
            'doc_destino'=> 'Observación',
            'doc_tipo'=>'Egreso',
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_insert('doc_43021',array(
            'doc_fecha'=> date('Y-m-d'),
            'doc_hora'=> date('H:i:s'),
            'doc_turno'=>Modules::run('Config/ObtenerTurno'),
            'doc_destino'=> 'Observación',
            'doc_tipo'=>'Ingreso',
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Alta de Consultorio ','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$ce['ce_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxInterConsulta() {
        $this->config_mdl->_update_data('os_consultorios_especialidad',array(
            'ce_status'=>'Interconsulta',
            'ce_interconsulta'=>'Si'
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $sqlInterconsulta= $this->config_mdl->_get_data_condition('doc_430200',array(
            'triage_id'=> $this->input->post('triage_id'),
            'doc_modulo'=>'Consultorios',
            'doc_servicio_solicitado'=>$this->input->post('doc_servicio_solicitado'),
        ));
        if(empty($sqlInterconsulta)){
            $this->config_mdl->_insert('doc_430200',array(
                'doc_estatus'=>'En Espera',
                'doc_fecha'=> date('Y-m-d'),
                'doc_hora'=> date('H:i'),
                'doc_area'=> $this->UMAE_AREA,
                'doc_servicio_envia'=> Modules::run('Consultorios/ObtenerEspecialidad',array('Consultorio'=>$this->UMAE_AREA)),
                'doc_servicio_solicitado'=>$this->input->post('doc_servicio_solicitado'),
                'doc_diagnostico'=> $this->input->post('doc_diagnostico'),
                'doc_modulo'=>'Consultorios',
                'triage_id'=> $this->input->post('triage_id'),
                'empleado_envia'=> $this->UMAE_USER
            ));
            $sqlInterconsulta= $this->config_mdl->_get_last_id('doc_430200','doc_id');
            $this->setOutput(array('accion'=>'1','Interconsulta'=>$sqlInterconsulta));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function ObtenerServicioInterconsulta() {
        if($_GET['Interconsultas']=='Solicitadas'){

                $sql['Gestion']= $this->config_mdl->_query(
                   "SELECT *, tb1.especialidad_nombre as esp_nom1, tb2.especialidad_nombre as esp_nom2
                    FROM os_triage, doc_430200 INNER JOIN um_especialidades as tb1
                      ON tb1.especialidad_id = doc_430200.doc_servicio_solicitado
                    INNER JOIN um_especialidades as tb2 ON tb2.especialidad_id = doc_430200.doc_servicio_envia
                    WHERE doc_430200.doc_estatus != 'Evaluado' AND
                    doc_430200.empleado_envia!=$this->UMAE_USER AND
                    os_triage.triage_id=doc_430200.triage_id AND
                    doc_430200.doc_servicio_solicitado = (SELECT especialidad_id
                                                          FROM um_especialidades
                                                          WHERE especialidad_id = (SELECT empleado_servicio
                                                                                   FROM os_empleados
                                                                                   WHERE empleado_id = $this->UMAE_USER )) ORDER BY doc_430200.doc_fecha DESC LIMIT 20");
        }else{
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, doc_430200 WHERE
                doc_430200.empleado_envia=$this->UMAE_USER AND
                os_triage.triage_id=doc_430200.triage_id");
        }
        $this->load->view('Interconsultas',$sql);
    }
    public function Interconsultas() {
       
        if($_GET['Interconsultas']=='Solicitadas'){
            if($this->UMAE_AREA=='Médico Observación'){
                $sqlEmpleado= $this->config_mdl->_get_data_condition('os_empleados',array(
                    'empleado_id'=> $this->UMAE_USER
                ))[0];
                $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, doc_430200 WHERE
                    doc_430200.doc_estatus!='Evaluado' AND
                    doc_430200.empleado_envia!=$this->UMAE_USER AND
                    os_triage.triage_id=doc_430200.triage_id AND
                    doc_430200.doc_servicio_solicitado='".Modules::run('Consultorios/ObtenerEspecialidad',array('Consultorio'=>$sqlEmpleado['empleado_servicio']))."'");

            }else{
                $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, doc_430200 WHERE
                    doc_430200.doc_estatus!='Evaluado' AND
                    doc_430200.empleado_envia!=$this->UMAE_USER AND
                    os_triage.triage_id=doc_430200.triage_id AND
                    doc_430200.doc_servicio_solicitado='".Modules::run('Consultorios/ObtenerEspecialidad',array('Consultorio'=>$this->UMAE_AREA))."'");
                $interconsultasPendientes = count($sql['Gestion']);
            }
        }else{
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, doc_430200 WHERE
                doc_430200.empleado_envia=$this->UMAE_USER AND
                os_triage.triage_id=doc_430200.triage_id");
        }
        $this->load->view('Interconsultas',$sql);
    }
    public function InterconsultasDetalles() {
        $sql['info']= $this->config_mdl->_query("SELECT * FROM os_triage, doc_430200, os_empleados WHERE
            doc_430200.empleado_envia=os_empleados.empleado_id AND
            os_triage.triage_id=doc_430200.triage_id AND doc_430200.doc_id=".$this->input->get_post('inter'))[0];
        $sql['MedicoTratante']= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=>$sql['info']['empleado_recive']
        ))[0];
        $this->load->view('InterconsultasDetalles',$sql);
    }
    public function AjaxAltaInterconsulta() {
        $this->config_mdl->_update_data('doc_430200',array(
            'doc_estatus'=>'Evaluado'
        ),array(
            'doc_id'=> $this->input->post('doc_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxObtenerPaciente() {
        $sqlConsultorio=$this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad WHERE triage_id=".$this->input->post('triage_id'));
        $sqlPaciente=  $this->config_mdl->_query("SELECT * FROM os_triage WHERE triage_id=".$this->input->post('triage_id'))[0];
        if($sqlPaciente['triage_crea_am']!=''){
            if(!empty($sqlConsultorio)){
                $sql=  $this->config_mdl->_query("SELECT * FROM  os_consultorios_especialidad
                                                WHERE
                                                os_consultorios_especialidad.ce_status='En Espera' AND
                                                os_consultorios_especialidad.triage_id=".$this->input->post('triage_id'));
                if(!empty($sql)){
                    $this->setOutput(array('paciente'=>$sqlPaciente,'accion'=>'NO_ASIGNADO'));
                }else{
                    $Interconsulta= $this->config_mdl->_get_data_condition('doc_430200',array(
                        'triage_id'=> $this->input->post('triage_id')
                    ));
                    $Medico= $this->config_mdl->_get_data_condition('os_empleados',array(
                        'empleado_id'=>$sqlConsultorio[0]['ce_crea']
                    ));
                    $this->setOutput(array('paciente'=>$sqlPaciente,'ce'=>$sqlConsultorio[0],'medico'=>$Medico[0],'accion'=>'ASIGNADO','TieneInterconsulta'=>$Interconsulta));
                }
            }else{
                $this->setOutput(array('accion'=>'NO_EXISTE_EN_CE','paciente'=>$sqlPaciente));
            }
        }else{
            $this->setOutput(array('accion'=>'NO_AM'));
        }
    }

    public function AjaxAgregarConsultorioV2() {

        $consultaCodigo= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];

        $horaEntrada = $consultaCodigo['triage_hora_clasifica'];
        switch($consultaCodigo['triage_color']){
            case "Rojo":
                        $minutosRandom = rand(1,5);
                        $horaAuxiliar = strtotime('+'.$minutosRandom.' minutes', strtotime( $horaEntrada )); 
                        $ce_he = date ( 'H:i' , $horaAuxiliar );
                        break;

            case "Naranja":
                        $minutosRandom = rand(6,10);
                        $horaAuxiliar = strtotime('+'.$minutosRandom.' minutes', strtotime( $horaEntrada ));
                        $ce_he = date ( 'H:i' , $horaAuxiliar );
                        break;

            case "Amarillo":
                        $minutosRandom = rand(15,30);
                        $horaAuxiliar = strtotime('+'.$minutosRandom.' minutes', strtotime( $horaEntrada ));
                        $ce_he = date ( 'H:i' , $horaAuxiliar );
                        break;

            case "Verde":
                        $ce_he = date('H:i');
                        break;
            case "Azul":
                        $ce_he = date('H:i');
                        break;
        }
       
        $this->config_mdl->_insert('os_consultorios_especialidad',array(
            'ce_fe'=>  date('Y-m-d'),
            'ce_he'=>  $ce_he,
            'ce_crea'=> $this->UMAE_USER,
            'ce_status'=>'Asignado',
            'ce_asignado_consultorio'=> $this->UMAE_AREA,
            'ce_interconsulta'=>'No',
            'triage_id'=> $this->input->post('triage_id')
        ));

        $this->config_mdl->_insert('um_medico_tratante', array(
          'triage_id' => $this->input->post('triage_id'),
          'empleado_id' => $this->UMAE_USER,
          'fecha_inicio' => date('d-m-Y')." ".date('H:i')
        ));

        $sqlMaxId= $this->config_mdl->_get_last_id('os_consultorios_especialidad','ce_id');
        $this->config_mdl->_insert('os_consultorios_especialidad_llamada',array(
            'triage_id'=> $this->input->post('triage_id'),
            'ce_id_ce'=>$sqlMaxId
        ));
        $this->config_mdl->_update_data('os_triage',array(
            'triage_consultorio'=>$this->BuscarConsultorio($this->UMAE_AREA)['ConsultorioId'],
            'triage_consultorio_nombre'=>$this->BuscarConsultorio($this->UMAE_AREA)['ConsultorioNombre']
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Consultorios Especialidad','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$sqlMaxId));
        $this->setOutput(array('accion'=>'1'));

    }

    public function AjaxIngresoConsultorioV2() {
        $sqlConsultorio= $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->config_mdl->_update_data('os_consultorios_especialidad',array(
            'ce_fe'=>  date('Y-m-d'),
            'ce_he'=>  date('H:i'),
            'ce_crea'=> $this->UMAE_USER,
            'ce_status'=>'Asignado',
            'ce_asignado_consultorio'=> $this->UMAE_AREA,
            'ce_interconsulta'=>'No'
        ),array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->config_mdl->_insert('os_consultorios_especialidad_llamada',array(
            'triage_id'=> $this->input->post('triage_id'),
            'ce_id_ce'=>$sqlConsultorio['ce_id']
        ));
        $this->config_mdl->_update_data('os_triage',array(
            'triage_consultorio'=>$this->BuscarConsultorio($this->UMAE_AREA)['ConsultorioId'],
            'triage_consultorio_nombre'=>$this->BuscarConsultorio($this->UMAE_AREA)['ConsultorioNombre']
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Consultorios Especialidad','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$sqlConsultorio['ce_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    /**************************************************************************/
    public function v2() {
        $this->load->view('IndicadoresV2');
    }
    public function Indicadores() {
        $this->load->view('Indicadores');
    }
    public function AjaxIndicadores() {
        $inputFechaInicio = $this->input->post('inputFechaInicio');
        $selectTurno = $this->input->post('selectTurno');
        //$ObtenerTurno = Modules::run('Config/ObtenerTurno');
        switch ($selectTurno) {
            case 'Mañana':
                $HF= count($this->config_mdl->_query("SELECT hf_id FROM os_consultorios_especialidad_hf WHERE
                                                    empleado_id=$this->UMAE_USER AND hf_fg='$inputFechaInicio' AND hf_hg BETWEEN '07:20' AND '14:00' "));
                break;
            
            case 'Tarde':
                $HF= count($this->config_mdl->_query("SELECT hf_id FROM os_consultorios_especialidad_hf WHERE
                                                    empleado_id=$this->UMAE_USER AND hf_fg='$inputFechaInicio' AND hf_hg BETWEEN '14:00' AND '20:30' "));
                break;
            case 'Noche':
                $HF_A = count($this->config_mdl->_query("SELECT hf_id FROM os_consultorios_especialidad_hf WHERE
                                                    empleado_id=$this->UMAE_USER AND hf_fg='$inputFechaInicio' AND hf_hg BETWEEN '20:30' AND '23:59' "));
        
                $fechaNocheB = strtotime('+1 day', strtotime($inputFechaInicio)); 
                $fechaNocheB = date('d-m-Y', $fechaNocheB);

                $HF_B = count($this->config_mdl->_query("SELECT hf_id FROM os_consultorios_especialidad_hf WHERE
                                                    empleado_id=$this->UMAE_USER AND hf_fg='$fechaNocheB' AND hf_hg BETWEEN '00:00' AND '07:20' "));
                $HF = $HF_A + $HF_B;

                break;
        }
        
        
        $sqlDocumentos= $this->config_mdl->_get_data_condition('pc_documentos',array(
            'doc_tipo'=>'NOTAS FORMATO 4 30 128'
        ));
        
        $Total=0;
      foreach ($sqlDocumentos as $value) {
            $TipoDoc=$value['doc_nombre'];

            switch ($selectTurno) {
                case 'Mañana':
                    $totalNotas= count($this->config_mdl->_query("SELECT notas_id FROM doc_notas 
                                    WHERE doc_notas.notas_tipo='$TipoDoc' 
                                    AND doc_notas.empleado_id=$this->UMAE_USER 
                                    AND doc_notas.notas_fecha='$inputFechaInicio'
                                    AND doc_notas.notas_hora BETWEEN '07:20' AND '14:00'
                                    "));                                     
                    break;
                
                case 'Tarde':
                    $totalNotas= count($this->config_mdl->_query("SELECT notas_id FROM doc_notas 
                                    WHERE doc_notas.notas_tipo='$TipoDoc' 
                                    AND doc_notas.empleado_id=$this->UMAE_USER 
                                    AND doc_notas.notas_fecha='$inputFechaInicio'
                                    AND doc_notas.notas_hora BETWEEN '14:00' AND '20:30'
                                    "));
                    break;
                case 'Noche':
                    $totalNotas_A= count($this->config_mdl->_query("SELECT notas_id FROM doc_notas 
                                    WHERE doc_notas.notas_tipo='$TipoDoc' 
                                    AND doc_notas.empleado_id=$this->UMAE_USER 
                                    AND doc_notas.notas_fecha='$inputFechaInicio'
                                    AND doc_notas.notas_hora BETWEEN '20:30' AND '23:59'
                                    "));
            
                    $fechaNocheB = strtotime('+1 day', strtotime($inputFechaInicio)); 
                    $fechaNocheB = date('d-m-Y', $fechaNocheB);

                    $totalNotas_B= count($this->config_mdl->_query("SELECT notas_id FROM doc_notas 
                                    WHERE doc_notas.notas_tipo='$TipoDoc' 
                                    AND doc_notas.empleado_id=$this->UMAE_USER 
                                    AND doc_notas.notas_fecha='$fechaNocheB'
                                    AND doc_notas.notas_hora BETWEEN '00:00' AND '07:20'
                                    "));

                    $totalNotas = $totalNotas_A + $totalNotas_B;

                    break;
            }       
            
            $Total=$totalNotas+$Total;
        }
        $this->setOutput(array(
            'TOTAL_DOCS'=>$HF+$Total

        ));
    }
    /*Gestion y Altas a Nuevos Consultorios*/
    public function BuscarConsultorio($Consultoririo) {
        $sqlConsultorio= $this->config_mdl->_get_data_condition('um_especialidades_consultorios',array(
            'consultorio_nombre'=> $Consultoririo
        ))[0];
        if($sqlConsultorio['consultorio_especialidad']=='Si'){
            return array(
                'ConsultorioId'=>$sqlConsultorio['consultorio_id'],
                'ConsultorioNombre'=>$sqlConsultorio['consultorio_nombre']
            );
        }else{
            return array(
                'ConsultorioId'=>0,
                'ConsultorioNombre'=>'Primer Contacto/Filtro'
            );
        }
    }
    /*NUEVAS FUNCIONES DE CONSULTORIOS POR SERVICIOS ETC..*/
    public function ObtenerEspecialidad($data) {
        $Consultorio=$data['Consultorio'];
        $sqlConsultorio= $this->config_mdl->_query("SELECT * FROM um_especialidades, um_especialidades_consultorios WHERE
            um_especialidades.especialidad_id=um_especialidades_consultorios.especialidad_id AND
            um_especialidades_consultorios.consultorio_nombre='$Consultorio'")[0];
        return $sqlConsultorio['especialidad_nombre'];

    }
    public function ObtenerEspecialidadID($data) {
        $Consultorio=$data['Consultorio'];
        $sqlConsultorio= $this->config_mdl->_query("SELECT * FROM um_especialidades, um_especialidades_consultorios WHERE
            um_especialidades.especialidad_id=um_especialidades_consultorios.especialidad_id AND
            um_especialidades_consultorios.consultorio_nombre='$Consultorio'")[0];
        return $sqlConsultorio['especialidad_id'];

    }


    public function ObtenerEspecialidades() {
        $option = "";
        $sqlEspecialidades= $this->config_mdl->_query("SELECT * FROM um_especialidades");
        foreach ($sqlEspecialidades as $value) {
            $option.='<option value="'.$value['especialidad_nombre'].'">'.$value['especialidad_nombre'].'</option>';
        }
        $this->setOutput(array('option'=>$option));
    }
    /*Funciones para agregar destinos si el modulo de consultorios esta disponible*/
    public function Destinos() {
        $sql['Gestion']= $this->config_mdl->_get_data_condition('pc_destinos');
        $this->load->view('Destinos',$sql);
    }
    public function AjaxDestinos() {
        $data=array(
            'destino_nombre'=> $this->input->post('destino_nombre')
        );
        if($this->input->post('destino_accion')=='add'){
            $this->config_mdl->_insert('pc_destinos',$data);
        }else{
            $this->config_mdl->_update_data('pc_destinos',$data,array(
                'destino_id'=> $this->input->post('destino_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxDestinosEliminar() {
        $this->config_mdl->_delete_data('pc_destinos',array(
            'destino_id'=> $this->input->post('destino_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    /*FUNCIONES DINAMICAS PARA CONSULTORIOS*/
    public function AjaxObtenerConsultoriosV2() {
        $option = "";
        $sqlFiltro=$this->config_mdl->sqlGetDataCondition('um_especialidades_consultorios',array(
            'consultorio_especialidad'=>'No'
        ));
        if(!empty($sqlFiltro)){
            $option.='<option value="0;Primer Contacto/Filtro" >Primer Contacto/Filtro</option>';
        }
        $especialidad=$this->config_mdl->sqlGetDataCondition('um_especialidades_consultorios');
        foreach ($especialidad as $value) {
            if($value['consultorio_especialidad']=='Si'){
                $option.='<option value="'.$value['consultorio_id'].';'.$value['consultorio_nombre'].'">'.$value['consultorio_nombre'].'</option>';
            }
        }

        $sqlDestinos= $this->config_mdl->_get_data('pc_destinos');
        foreach ($sqlDestinos as $value) {
            $option.='<option value="0;'.$value['destino_nombre'].'">'.$value['destino_nombre'].'</option>';
        }
        if($this->ConfigDestinosOAC=='Si'){
            $option.='<option value="0;Ortopedia-Admisión Continua">Ortopedia-Admisión Continua</option>';
        }
        $this->setOutput(array('option'=>$option));
    }

    public function GetInfoParaOrdenInternamiento() {
        $folio = $this->input->post('folio');
        $option = '';
        $sql = $this->config_mdl->_get_data_condition('os_triage', array(
             'triage_id' => $folio
         ));
        $sqlDx = $this->config_mdl->_query("SELECT * FROM paciente_diagnosticos, um_cie10 WHERE 
                    paciente_diagnosticos.cie10_id=um_cie10.cie10_id AND 
                    paciente_diagnosticos.triage_id =".$folio);
        $check_ordenInternamiento = $this->config_mdl->_get_data_condition('um_orden_internamiento', array(
            'triage_id' => $folio
        ))[0];
        /* Si tiene Dx se puede hacer Orden */
        if(!empty($sqlDx)) {
            /* Si si genero la Orden De internamiento ya no se puede generar  otra */
            /* No hat orden de Internamiento */
            if(empty($check_ordenInternamiento)){
                $sqlEspecialidad=$this->config_mdl->sqlGetDataCondition('um_especialidades',array(
                    'especialidad_hospitalizacion' => 1
                ));
                $option.='<option value="0" disable>Selecciona</option>';
                foreach ($sqlEspecialidad as $value) {           
                    $option.='<option value="'.$value['especialidad_id'].'">'.$value['especialidad_nombre'].'</option>';
                }
                foreach($sqlDx as $value){
                    switch ($value['tipo_diagnostico']){
                        case 1: 
                            $id_dx = $value['cie10_id'];
                            $id_dx_registrado = $value['diagnostico_id']; 
                            $dx = $value['cie10_nombre'];
                            $dx_complemento = $value['complemento'];
                            break;
                        case 0:
                            $id_dx = $value['cie10_id'];
                            $id_dx_registrado = $value['diagnostico_id']; 
                            $dx = $value['cie10_nombre'];
                            $dx_complemento = $value['complemento'];
                            break;
                    }
                }
                $sql[0]['triage_horacero_f']            = date("d-m-Y", strtotime($sql[0]['triage_horacero_f']));
                $sql[0]['triage_fecha']                 = date("d-m-Y", strtotime($sql[0]['triage_fecha']));
                $sql[0]['triage_fecha_clasifica']       = date("d-m-Y", strtotime($sql[0]['triage_fecha_clasifica']));
                $this->setOutput(array('accion'         =>'2',
                                       'info'           => $sql[0], 
                                       'option'         => $option, 
                                       'id_dx'          => $id_dx, 
                                       'id_dx_reg'      => $id_dx_registrado,
                                       'dx'             => $dx,
                                       'dx_complemento' => $dx_complemento));
            }else{  
                /* Ya se realizo orden de internamiento */
                $this->setOutput(array('accion'=>'3'));            
            }
        }else{
                $this->setOutput(array('accion'=>'1'));
        }
    }

    public function UpdateInfoParaOrdenInternamiento() {
        $folio = $this->input->post('folio');
        $option = '';
        $sql = $this->config_mdl->_get_data_condition('os_triage', array(
             'triage_id' => $folio
         ));
        $sqlDx = $this->config_mdl->_query("SELECT * FROM paciente_diagnosticos, um_cie10 WHERE 
                    paciente_diagnosticos.cie10_id=um_cie10.cie10_id AND 
                    paciente_diagnosticos.triage_id =".$folio);
        $check_ordenInternamiento = $this->config_mdl->_get_data_condition('um_orden_internamiento', array(
            'triage_id' => $folio
        ))[0];
        /* Si tiene Dx se puede hacer Orden */
        if(!empty($sqlDx)) {
            /* Si si genero la Orden De internamiento ya no se puede generar  otra */
            /* No hat orden de Internamiento */
            if(!empty($check_ordenInternamiento)){

                $inf_doctor = $this->config_mdl->_query('SELECT * from os_empleados where empleado_id = '.$check_ordenInternamiento['medico_origen_id']);
                $sqlEspecialidad=$this->config_mdl->sqlGetDataCondition('um_especialidades',array(
                    'especialidad_hospitalizacion' => 1
                ));
                $option.='<option value="0" disable>Selecciona</option>';
                foreach ($sqlEspecialidad as $value) {           
                    if($value['especialidad_id'] == $check_ordenInternamiento['servicio_destino_id']){
                        $option.='<option value="'.$value['especialidad_id'].'" selected>'.$value['especialidad_nombre'].'</option>';
                    }else{
                        $option.='<option value="'.$value['especialidad_id'].'">'.$value['especialidad_nombre'].'</option>';
                    }
                    
                }
                foreach($sqlDx as $value){
                    switch ($value['tipo_diagnostico']){
                        case 1: 
                            $id_dx = $value['cie10_id'];
                            $id_dx_registrado = $value['diagnostico_id']; 
                            $dx = $value['cie10_nombre'];
                            $dx_complemento = $value['complemento'];
                            break;
                        case 0:
                            $id_dx = $value['cie10_id'];
                            $id_dx_registrado = $value['diagnostico_id']; 
                            $dx = $value['cie10_nombre'];
                            $dx_complemento = $value['complemento'];
                            break;
                    }
                }
                $sql[0]['triage_horacero_f']            = date("d-m-Y", strtotime($sql[0]['triage_horacero_f']));
                $sql[0]['triage_fecha']                 = date("d-m-Y", strtotime($sql[0]['triage_fecha']));
                $sql[0]['triage_fecha_clasifica']       = date("d-m-Y", strtotime($sql[0]['triage_fecha_clasifica']));

                $this->setOutput(array('accion'         =>'2',
                                       'info'           => $sql[0],
                                       "checkOrden"     => $check_ordenInternamiento,
                                       "infDoctor"      => $inf_doctor[0],
                                       'option'         => $option, 
                                       'id_dx'          => $id_dx, 
                                       'id_dx_reg'      => $id_dx_registrado,
                                       'dx'             => $dx,
                                       'dx_complemento' => $dx_complemento));
            }else{  
                /* No existe orden de internamiento */
                $this->setOutput(array('accion'=>'3'));            
            }
        }else{
                $this->setOutput(array('accion'=>'1'));
        }
    }
}