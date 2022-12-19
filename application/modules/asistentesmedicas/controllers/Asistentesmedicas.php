<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Asistentesmedicas
 *
 * @author felipe de jesus
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Asistentesmedicas extends Config{
    public function __construct() {
        parent::__construct();
        $this->load->model('asistentesmedicas_mdl');
    }
    public function index() {  
        
        /*$hoy = date('Y-m-d');*/
        $sql['Gestion']= []; /*$this->config_mdl->_query("SELECT os_triage.triage_id,
            os_triage.triage_nombre, os_triage.triage_nombre_ap, os_triage.triage_nombre_am,os_triage.triage_color,
            os_triage.triage_fecha_clasifica, os_triage.triage_hora_clasifica, os_triage.triage_via_registro,
            os_asistentesmedicas.asistentesmedicas_fecha, os_asistentesmedicas.asistentesmedicas_hora,
            paciente_info.pic_mt
            FROM os_triage, os_accesos, os_asistentesmedicas, paciente_info
            WHERE
            os_accesos.acceso_tipo='Asistente Médica' AND
            os_accesos.triage_id=os_triage.triage_id AND
            os_accesos.areas_id=os_asistentesmedicas.asistentesmedicas_id AND
            os_asistentesmedicas.asistentesmedicas_fecha= '$hoy' AND
            paciente_info.triage_id=os_triage.triage_id
            ORDER BY os_accesos.acceso_id    LIMIT 150");*/
        $this->load->view('index',$sql);
    }
    public function BuscarPaciente() {
        $sql= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(!empty($sql)){
            $info= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
                'triage_id'=> $this->input->post('triage_id')
            ));
            if($sql[0]['triage_fecha_clasifica']!=''){
                if(empty($info)){
                    $this->config_mdl->_insert('os_asistentesmedicas',array('triage_id'=> $this->input->post('triage_id')));
                }
                $this->setOutput(array('accion'=>'1'));
            }else {
                $this->setOutput(array('accion'=>'2'));
            }
            if($sql[0]['triage_via_registro']=='Choque'){
                $this->setOutput(array('accion'=>'3'));
            }
            if($sql[0]['triage_via_registro']=='Hora Cero TR'){
                $this->setOutput(array('accion'=>'5'));
            }
        }else{
            $this->setOutput(array('accion'=>'4'));
        }
    }
    public function Paciente($paciente) {
        $sql['MedicosTratantes']= $this->config_mdl->_query("SELECT * FROM os_empleados
                                                            WHERE os_empleados.empleado_servicio = 1
                                                            AND os_empleados.empleado_roles = '2' ");
        $sql['info']=  $this->config_mdl->sqlGetDataCondition('os_triage',array(
           'triage_id'=>  $paciente
        ),'triage_id,triage_nombre,triage_nombre_am,triage_nombre_ap,triage_fecha_nac,triage_paciente_sexo,triage_paciente_curp,triage_color,triage_consultorio_nombre');
        $sql['solicitud']= $this->config_mdl->sqlGetDataCondition('os_asistentesmedicas',array(
           'triage_id'=> $paciente
        ));
        $sql['empleado']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
           'empleado_id'=> $this->UMAE_USER
        ),'empleado_nombre,empleado_apellidos');
        $sql['DirPaciente']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'=>  $paciente,
            'directorio_tipo'=>'Paciente'
        ))[0];
        $sql['DirEmpresa']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'=>  $paciente,
            'directorio_tipo'=>'Empresa'
        ))[0];
        $sql['Empresa']=  $this->config_mdl->_get_data_condition('os_triage_empresa',array(
           'triage_id'=>  $paciente,
        ))[0];
        $sql['PINFO']=  $this->config_mdl->sqlGetDataCondition('paciente_info',array('triage_id'=>$paciente,))[0];
        $this->load->view('paciente',$sql);
    }
    public function AjaxGuardar() {
        $info=  $this->config_mdl->sqlGetDataCondition('os_triage',array(
            'triage_id'=>  $this->input->post('triage_id')
        ),'triage_crea_am,triage_consultorio_nombre,triage_nombre,triage_nombre_ap,triage_nombre_am')[0];
        $infoPinfo=  $this->config_mdl->sqlGetDataCondition('paciente_info',array(
            'triage_id'=>  $this->input->post('triage_id')
        ),'pum_nss,pum_nss_agregado')[0];
        $am=  $this->config_mdl->sqlGetDataCondition('os_asistentesmedicas',array(
            'triage_id'=>  $this->input->post('triage_id')
        ),'asistentesmedicas_id,asistentesmedicas_fecha')[0];
        if($info['triage_crea_am']==''){
            if($this->input->post('pia_lugar_accidente')=='TRABAJO'){
                Modules::run('Asistentesmedicas/DOC_ST7_FOLIO',array(
                    'triage_id'=>  $this->input->post('triage_id')
                ));
            }
            $this->config_mdl->_insert('doc_43029',array(
                    'doc_fecha'=> date('Y-m-d'),
                    'doc_hora'=> date('H:i:s'),
                    'doc_turno'=>Modules::run('Config/ObtenerTurno'),
                    'doc_destino'=>$info['triage_consultorio_nombre'],
                    'doc_tipo'=>'Ingreso',
                    'empleado_id'=> $this->UMAE_USER,
                    'triage_id'=>  $this->input->post('triage_id')
                ));
            if(($info['triage_consultorio_nombre']=='Observación') or ($info['triage_consultorio_nombre']=='Choque')){
                $this->config_mdl->_insert('doc_43021',array(
                    'doc_fecha'=> date('Y-m-d'),
                    'doc_hora'=> date('H:i:s'),
                    'doc_turno'=>Modules::run('Config/ObtenerTurno'),
                    'doc_destino'=>$info['triage_consultorio_nombre'],
                    'doc_tipo'=>'Ingreso',
                    'empleado_id'=> $this->UMAE_USER,
                    'triage_id'=>  $this->input->post('triage_id')
                ));
            }
            $this->AccesosUsuarios(array('acceso_tipo'=>'Asistente Médica','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$am['asistentesmedicas_id']));
        }
        $data=array(
            'asistentesmedicas_fecha'=> date('Y-m-d'),
            'asistentesmedicas_hora'=> date('H:i'),
            'triage_id'=>  $this->input->post('triage_id')
        );
        if($am['asistentesmedicas_fecha']!=''){
            unset($data['asistentesmedicas_fecha']);
            unset($data['asistentesmedicas_hora']);
        }
        $this->config_mdl->_update_data('os_asistentesmedicas',$data,
                array('triage_id'=>  $this->input->post('triage_id'))
        );
        $data_triage=array(
            'triage_nombre'=> $this->input->post('triage_nombre'),
            'triage_nombre_ap'=> $this->input->post('triage_nombre_ap') ,
            'triage_nombre_am'=> $this->input->post('triage_nombre_am') ,
            'triage_paciente_sexo'=> $this->input->post('triage_paciente_sexo'),
            'triage_fecha_nac'=> $this->input->post('triage_fecha_nac'),
            // 'triage_paciente_estadocivil'=>  $this->input->post('triage_paciente_estadocivil'),
            'triage_paciente_curp'=>  $this->input->post('triage_paciente_curp'),
            'triage_crea_am'=> $this->UMAE_USER
        );
        Modules::run('Triage/LogChangesPatient',array(
            'paciente_old'=>$info['triage_nombre'].' '.$info['triage_nombre_ap'].' '.$info['triage_nombre_am'],
            'paciente_new'=> $this->input->post('triage_nombre').' '.$this->input->post('triage_nombre_ap').' '.$this->input->post('triage_nombre_am'),
            'nss_old'=>$infoPinfo['pum_nss'].'-'.$infoPinfo['pum_nss_agregado'],
            'nss_new'=> $this->input->post('pum_nss').'-'.$this->input->post('pum_nss_agregado'),
            'triage_id'=>$this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('paciente_info', array(
            'pum_nss'=>$this->input->post('pum_nss'),
            'pum_nss_agregado'=>$this->input->post('pum_nss_agregado'),
            'pum_umf'=>$this->input->post('pum_umf'),
            'pum_delegacion'=>$this->input->post('pum_delegacion'),
            'pia_lugar_accidente'=>$this->input->post('pia_lugar_accidente'),
            'pia_lugar_procedencia'=>$this->input->post('pia_lugar_procedencia'),
            'pia_dia_pa'=>$this->input->post('pia_dia_pa'),
            'pia_fecha_accidente'=>$this->input->post('pia_fecha_accidente'),
            'pia_hora_accidente'=>$this->input->post('pia_hora_accidente'),
            'pic_identificacion'=>$this->input->post('pic_identificacion'),
            'pic_responsable_nombre'=>$this->input->post('pic_responsable_nombre'),
            'pic_responsable_parentesco'=>$this->input->post('pic_responsable_parentesco'),
            'pic_responsable_telefono'=>$this->input->post('pic_responsable_telefono'),
            'pic_mt'=> $this->input->post('pic_mt'),
            'pia_procedencia_espontanea'=>$this->input->post('pia_procedencia_espontanea'),
            'pia_procedencia_espontanea_lugar'=>$this->input->post('pia_procedencia_espontanea_lugar'),
            'pia_tipo_atencion'=> $this->input->post('pia_tipo_atencion'),
            'pia_procedencia_hospital'=> $this->input->post('pia_procedencia_hospital'),
            'pia_procedencia_hospital_num'=> $this->input->post('pia_procedencia_hospital_num'),
            // 'pic_mt'=> $this->input->post('pic_mt'),
            'pia_vigencia'=> $this->input->post('pia_vigencia'),
            'pia_documento'=> $this->input->post('pia_documento')
        ),array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        Modules::run('Triage/TriagePacienteDirectorio',array(
            'directorio_tipo'=>'Paciente',
            'directorio_cp'=> $this->input->post('directorio_cp'),
            'directorio_cn'=> $this->input->post('directorio_cn'),
            'directorio_colonia'=> $this->input->post('directorio_colonia'),
            'directorio_municipio'=> $this->input->post('directorio_municipio'),
            'directorio_estado'=> $this->input->post('directorio_estado'),
            'directorio_telefono'=> $this->input->post('directorio_telefono'),
            'triage_id'=>$this->input->post('triage_id')
        ));
        if($this->input->post('directorio_cp_2')!=''){
            Modules::run('Triage/TriagePacienteDirectorio',array(
                'directorio_tipo'=>'Empresa',
                'directorio_cp'=> $this->input->post('directorio_cp_2'),
                'directorio_cn'=> $this->input->post('directorio_cn_2'),
                'directorio_colonia'=> $this->input->post('directorio_colonia_2'),
                'directorio_municipio'=> $this->input->post('directorio_municipio_2'),
                'directorio_estado'=> $this->input->post('directorio_estado_2'),
                'directorio_telefono'=> $this->input->post('directorio_telefono_2'),
                'triage_id'=>$this->input->post('triage_id')
            ));
            Modules::run('Triage/TriagePacienteEmpresa',array(
                'empresa_nombre'=> $this->input->post('empresa_nombre'),
                'empresa_modalidad'=> $this->input->post('empresa_modalidad'),
                'empresa_rp'=> $this->input->post('empresa_rp'),
                'empresa_fum'=> $this->input->post('empresa_fum'),
                'empresa_tel'=> $this->input->post('empresa_tel'),
                'empresa_he'=> $this->input->post('empresa_he'),
                'empresa_hs'=>$this->input->post('empresa_hs'),
                'triage_id'=> $this->input->post('triage_id')
            ));
        }
        $this->config_mdl->_update_data('os_triage',$data_triage,
                array('triage_id'=>  $this->input->post('triage_id'))
        );
        $this->setOutput(array('accion'=>'1'));
    }
    public function DOC_ST7_FOLIO($info) {
        $this->config_mdl->_insert('doc_st7_folio',array(
            'st7_folio_fecha'=> date('Y-m-d'),
            'st7_folio_hora'=> date('H:i'),
            'triage_id'=>$info['triage_id'],
            'empleado_id'=> $this->UMAE_USER
        ));
    }
    public function BuscarCodigoPostal() {
       $sql=  $this->config_mdl->_get_data_condition('os_codigospostales',array('CodigoPostal'=>  $this->input->post('cp'))) ;
       $this->setOutput(array('result_cp'=>$sql[0]));
    }
    public function Egresos() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_asistentesmedicas_egresos, os_triage WHERE
            os_asistentesmedicas_egresos.triage_id=os_triage.triage_id ORDER BY
            os_asistentesmedicas_egresos.egreso_id DESC LIMIT 10");     
        $this->load->view('egresos/index',$sql);
    }
    public function AjaxObtenerPaciente() {
        $sql= $this->config_mdl->_get_data_condition('os_triage',array(
           'triage_id'=> $this->input->post('triage_id')
        ));
        $sql_observacion= $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $sql_ce= $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(empty($sql_observacion)){
            if(empty($sql_ce)){
                $egreso_area='Sin Especificar';
            }else{
                $egreso_area='Consultorios';
            }
        }else{
            $egreso_area='Observacion';
        }
        if(!empty($sql)){
            $this->setOutput(array('accion'=>'1','paciente'=>$sql[0],'Destino'=>$egreso_area));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function EgresoPaciente() {
        $sql_check= $this->config_mdl->_get_data_condition('os_asistentesmedicas_egresos',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(empty($sql_check)){
            $sql_observacion= $this->config_mdl->_get_data_condition('os_observacion',array(
                'triage_id'=> $this->input->post('triage_id')
            ));
            $sql_ce= $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
                'triage_id'=> $this->input->post('triage_id')
            ));
            if(empty($sql_observacion)){
                if(empty($sql_ce)){
                    $egreso_area='Sin Especificar';
                }else{
                    $egreso_area='Consultorios';
                }
            }else{
                $egreso_area='Observacion';
            }
            $this->config_mdl->_insert('os_asistentesmedicas_egresos',array(
                'egreso_fecha'=> date('Y-m-d'),
                'egreso_hora'=> date('H:i:s'),
                'egreso_area'=>$egreso_area,
                'egreso_motivo'=> $this->input->post('egreso_motivo'),
                'egreso_cama'=> $this->input->post('egreso_cama'),
                'egreso_piso'=> $this->input->post('egreso_piso'),
                'egreso_consultaexterna'=> $this->input->post('egreso_consultaexterna'),
                'empleado_id'=>$_SESSION['UMAE_USER'],
                'triage_id'=> $this->input->post('triage_id')
            ));
            $egreso_id= $this->config_mdl->_get_last_id('os_asistentesmedicas_egresos','egreso_id');
            $this->AccesosUsuarios(array('acceso_tipo'=>'Egreso Paciente Asistente Médica','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$egreso_id));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function Indicadores() {
        $this->load->view("Indicadores");
    }
    public function AjaxIndicador() {
        $inputFechaInicio= $this->input->post('inputFechaInicio');
        $sql_total= count($this->config_mdl->_query("SELECT os_asistentesmedicas.asistentesmedicas_id FROM os_asistentesmedicas, os_triage
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio'"));
        $sql_iniciada= count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info
            WHERE
            os_asistentesmedicas.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio' AND paciente_info.pia_lugar_accidente='TRABAJO'"));
        $sql_terminada= count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info
            WHERE
            os_asistentesmedicas.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_omitir='No' AND
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio' AND paciente_info.pia_lugar_accidente='TRABAJO'"));
        $sql_espontanea= count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info
            WHERE
            os_asistentesmedicas.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio' AND paciente_info.pia_procedencia_espontanea='Si'"));
        $sql_noespontanea= count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info
            WHERE
            os_asistentesmedicas.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio' AND paciente_info.pia_procedencia_espontanea='No'"));
        $this->setOutput(array(
            'TOTAL_ST7_INICIADA'=>$sql_iniciada,
            'TOTAL_ST7_TERMINADA'=>$sql_terminada,
            'TOTAL_ESPONTANEA'=>$sql_espontanea,
            'TOTAL_NOESPONTANEA'=>$sql_noespontanea,
            'TOTAL'=>$sql_total
        ));
    }
    public function IndicadorDetalles() {
        $POR_FECHA_FI= $this->input->get_post('POR_FECHA_FECHA_I');
        if($this->input->get_post('TIPO')=='ST7 INICIADA'){
            $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_triage, paciente_info
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            os_triage.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$POR_FECHA_FI' AND paciente_info.pia_lugar_accidente='TRABAJO'");
        }if($this->input->get_post('TIPO')=='ST7 TERMINADA'){
            $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info, os_triage
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            os_asistentesmedicas.asistentesmedicas_omitir='No' AND
            os_triage.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$POR_FECHA_FI' AND paciente_info.pia_lugar_accidente='TRABAJO'");
        }if($this->input->get_post('TIPO')=='ESPONTÁNEA'){
            $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info, os_triage
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            os_triage.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$POR_FECHA_FI' AND paciente_info.pia_procedencia_espontanea='Si'");
        }if($this->input->get_post('TIPO')=='NO ESPONTÁNEA'){
            $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info, os_triage
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            os_triage.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$POR_FECHA_FI' AND paciente_info.pia_procedencia_espontanea='No'");
        }
        $this->load->view('IndicadoresDetalles',$sql);
    }
    public function ChartSt7Iniciada($data) {
        $POR_FECHA_FI= $data['POR_FECHA_FECHA_I'];
        $POR_FECHA_FF= $data['POR_FECHA_FECHA_F'];
        $POR_HORA_F= $data['POR_HORA_FECHA'];
        $POR_HORA_HI= $data['POR_HORA_HORA_I'];
        $POR_HORA_HF= $data['POR_HORA_HORA_F'];
        $COLOR=$data['COLOR'];
        if($data['FILTRO']=='Por Fecha'){
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha BETWEEN '$POR_FECHA_FI' AND '$POR_FECHA_FF' AND os_triage.triage_paciente_accidente_lugar='TRABAJO'"));
        }else{
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha='$POR_HORA_F' AND
                os_asistentesmedicas.asistentesmedicas_hora BETWEEN '$POR_HORA_HI' AND '$POR_HORA_HF' AND os_triage.triage_paciente_accidente_lugar='TRABAJO'"));
        }
    }
    public function ChartSt7Terminada($data) {
        $POR_FECHA_FI= $data['POR_FECHA_FECHA_I'];
        $POR_FECHA_FF= $data['POR_FECHA_FECHA_F'];
        $POR_HORA_F= $data['POR_HORA_FECHA'];
        $POR_HORA_HI= $data['POR_HORA_HORA_I'];
        $POR_HORA_HF= $data['POR_HORA_HORA_F'];
        $COLOR=$data['COLOR'];
        if($data['FILTRO']=='Por Fecha'){
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_asistentesmedicas.asistentesmedicas_omitir='No' AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha BETWEEN '$POR_FECHA_FI' AND '$POR_FECHA_FF' AND os_triage.triage_paciente_accidente_lugar='TRABAJO'"));
        }else{
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_asistentesmedicas.asistentesmedicas_omitir='No' AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha='$POR_HORA_F' AND
                os_asistentesmedicas.asistentesmedicas_hora BETWEEN '$POR_HORA_HI' AND '$POR_HORA_HF' AND os_triage.triage_paciente_accidente_lugar='TRABAJO'"));
        }
    }
    public function ChartEspontanea($data) {
        $POR_FECHA_FI= $data['POR_FECHA_FECHA_I'];
        $POR_FECHA_FF= $data['POR_FECHA_FECHA_F'];
        $POR_HORA_F= $data['POR_HORA_FECHA'];
        $POR_HORA_HI= $data['POR_HORA_HORA_I'];
        $POR_HORA_HF= $data['POR_HORA_HORA_F'];
        $COLOR=$data['COLOR'];
        if($data['FILTRO']=='Por Fecha'){
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha BETWEEN '$POR_FECHA_FI' AND '$POR_FECHA_FF' AND os_triage.triage_procedencia!=''"));
        }else{
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_asistentesmedicas.asistentesmedicas_omitir='No' AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha='$POR_HORA_F' AND
                os_asistentesmedicas.asistentesmedicas_hora BETWEEN '$POR_HORA_HI' AND '$POR_HORA_HF' AND os_triage.triage_procedencia!=''"));
        }
    }
    public function ChartNoEspontanea($data) {
        $POR_FECHA_FI= $data['POR_FECHA_FECHA_I'];
        $POR_FECHA_FF= $data['POR_FECHA_FECHA_F'];
        $POR_HORA_F= $data['POR_HORA_FECHA'];
        $POR_HORA_HI= $data['POR_HORA_HORA_I'];
        $POR_HORA_HF= $data['POR_HORA_HORA_F'];
        $COLOR=$data['COLOR'];
        if($data['FILTRO']=='Por Fecha'){
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha BETWEEN '$POR_FECHA_FI' AND '$POR_FECHA_FF' AND os_triage.triage_procedencia=''"));
        }else{
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_asistentesmedicas.asistentesmedicas_omitir='No' AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha='$POR_HORA_F' AND
                os_asistentesmedicas.asistentesmedicas_hora BETWEEN '$POR_HORA_HI' AND '$POR_HORA_HF' AND os_triage.triage_procedencia=''"));
        }
    }
    public function AjaxMedicoTratantes() {
        $Medico = "";
        $sql= $this->config_mdl->_query("SELECT * FROM os_empleados, os_empleados_roles, os_roles WHERE
                                        os_empleados.empleado_id=os_empleados_roles.empleado_id AND
                                        os_roles.rol_id=os_empleados_roles.rol_id AND
                                        os_roles.rol_id=2");
        foreach ($sql as $value) {
            $Medico.="'".$value['empleado_nombre'].' '.$value['empleado_apellidos']."',";
        }
        $this->setOutput(array('medicos'=>trim($Medico,',')));
    }
    /*
    La funcion hace una consulta al webService con los datos de los pacientes con base a su
    NSS, estos datos permiten verificar la vigencia del seguro de los pacientes
    */
    public function VigenciaDerechos()
    {
      header("Content-type: text/html; charset=utf8");
      header('Content-Type: text/html; charset=ISO-8859-1');
        $nss = $this->input->get('pum_nss');
        $Cpid="36";
        $datos = array('nss'=>$nss, 'Cpid'=>$Cpid);
        $wsdl = 'http://vigenciaderechos.imss.gob.mx/WSConsVigGpoFamComXNssService/WSConsVigGpoFamComXNss?WSDL';

        $this->load->library("Nusoap_library"); //load the library here
        $client = new nusoap_client($wsdl,'wsdl');
        //se almacenaen un arreglo la informacion obtenida por el webService
        $res1['result'] = $client->call('getInfo', $datos);
        $tipoError = $res1['result']['return']['codigoError'];
        $mensajeError = $res1['result']['return']['mensajeError'];
        $vigenciaPrincipal = $res1['result']['return']['ConDerechoSm'];
        $tipoBeneficiario = $res1['result']['return']['ConDerechoInc'];
        $vigenciaSecundario = "";
        $estadoFila = "";
        $estadoRadio = "";
        if($tipoError == '0'){
          //verfica que el beneficiario principal cuente con su seguro vigente, de lo contrario lo marca en color rojo y niega la seleccion
          if($vigenciaPrincipal == "NO"){
            $estadoFila = "class=danger";
            $estadoRadio = "<a href=# onClick=datosTablaVigencia(1); >Sin vigencia</a>";
          }else{
            $estadoFila = "";
            $estadoRadio = "<input name=radioVigencia id=radioAsegurado onchange=datosTablaVigencia(1); type=radio>";
          }
          //Se imprime en una tabla la informacion del Beneficiario principal
          echo "<div class=row style='padding: 14px;margin-top: -15px;margin-bottom: -35px;'>
                <div class='col-md-12 back-imss text-center'>
                  <h5><b>Beneficiario Principal</b></h5>
                </div>
                </div>";
          echo "<table class='table table-hover' id=tbl >";
          echo "<thead>
          <tr>
            <th class=text-center >Nombre(s)</th>
            <th class=text-center >Primer apellido</th>
            <th class=text-center >Segundo apellido</th>
            <th class=text-center >Fecha de nacimiento</th>
            <th class=text-center >CURP</th>
            <th class=text-center >Agregado m&eacute;dico</th>
            <th class=text-center >Seleccion</th>
          </tr></thead>";
          echo "<tbody>
          <tr ".$estadoFila." class=asegurados >
          <input name=vigencia1 hidden type=text value='".$vigenciaPrincipal."' />
          <input name=vigenciaDelegacion1 hidden type=text value='".$res1['result']['return']['DhDeleg']."' />
          <input name=vigenciaUmf1 hidden type=text value='".$res1['result']['return']['DhUMF']."' />
          <input name=vigenciaSexo1 hidden type=text value='".$res1['result']['return']['Sexo']."' />
          <input name=vigenciaColonia1 hidden type=text value='".$res1['result']['return']['Colonia']."' />
          <input name=vigenciaDireccion1 hidden type=text value='".$res1['result']['return']['Direccion']."' />
            <td class=text-center ><input hidden name=vigenciaNombre1 type=text value='".$res1['result']['return']['Nombre']."' />".$res1['result']['return']['Nombre']."</td>
            <td class=text-center ><input hidden name=vigenciaPaterno1 type=text value='".$res1['result']['return']['Paterno']."' />".$res1['result']['return']['Paterno']."</td>
            <td class=text-center ><input hidden name=vigenciaMaterno1 type=text value='".$res1['result']['return']['Materno']."' />".$res1['result']['return']['Materno']."</td>
            <td class=text-center ><input hidden name=vigenciaNacimiento1 type=text value='".date('d/m/Y',strtotime($res1['result']['return']['FechaNacimiento']))."' />".date('d/m/Y',strtotime($res1['result']['return']['FechaNacimiento']))."</td>
            <td class=text-center ><input hidden name=vigenciaCurp1 type=text value='".$res1['result']['return']['Curp']."' />".$res1['result']['return']['Curp']."</td>
            <td class=text-center ><input hidden name=vigenciaAgregado1 type=text value='".$res1['result']['return']['AgregadoMedico']."' />".$res1['result']['return']['AgregadoMedico']."</td>
            <td class=text-center >".$estadoRadio."</td>
          </tr>
          </tbody>";
          echo "</table>";
          echo "<div class=row style='padding: 14px;margin-top: -15px;margin-bottom: -35px;'>
              <div class='col-md-12 back-imss text-center'>
                  <h5><b>Beneficiarios Secundarios</b></h5>
              </div>
          </div>";
          //tabla con los beneficiarios secundarios
          echo "<table class='table table-hover'>";
          echo "<thead><tr>
          <th class=text-center >Nombre(s)</th>
          <th class=text-center >Primer apellido</th>
          <th class=text-center >Segundo apellido</th>
          <th class=text-center >Fecha de nacimiento</th>
          <th class=text-center >CURP</th>
          <th class=text-center >Agregado m&eacute;dico</th>
          <th class=text-center >Seleccion</th>
          </tr></thead>";
          echo "<tbody>";
          //se cuenta el numero de beneficiarios para imprimir los datos de ellos
        for($i = 0; $i < count($res1['result']['return']['Beneficiarios']); $i++ ){
          $vigenciaSecundario = $res1['result']['return']['Beneficiarios'][$i]['ConDerechoSm'];
          $numeroAgregado = $i+2;
          //verifica la vigencia de los beneficiarios secundarios, si este no lo esta se marca en color rojo y no se puede seleccionar
          if($vigenciaSecundario == "NO"){
            $estadoFila = "class=danger";
            $estadoRadio = "<a href=# onClick=datosTablaVigencia($numeroAgregado); >Sin vigencia</a>";
          }else{
            $estadoFila = "";
            $estadoRadio = "<input name=radioVigencia onchange=datosTablaVigencia($numeroAgregado); id=radioAsegurado type=radio>";
          }
          echo "<input name=vigencia$numeroAgregado hidden type=text value=".$vigenciaSecundario." />
          <input name=vigenciaDelegacion$numeroAgregado hidden type=text value='".$res1['result']['return']['Beneficiarios'][$i]['DhDeleg']."' />
          <input name=vigenciaUmf$numeroAgregado hidden type=text value='".$res1['result']['return']['Beneficiarios'][$i]['DhUMF']."' />
          <input name=vigenciaSexo$numeroAgregado hidden type=text value='".$res1['result']['return']['Beneficiarios'][$i]['Sexo']."' />
          <input name=vigenciaColonia$numeroAgregado hidden type=text value='".$res1['result']['return']['Beneficiarios'][$i]['Colonia']."' />
          <input name=vigenciaDireccion$numeroAgregado hidden type=text value='".$res1['result']['return']['Beneficiarios'][$i]['Direccion']."' />
          <tr ".$estadoFila." class=asegurados>
          <td class=text-center ><input name=vigenciaNombre$numeroAgregado hidden type=text value='".$res1['result']['return']['Beneficiarios'][$i]['Nombre']."' />".$res1['result']['return']['Beneficiarios'][$i]['Nombre']."</td>
          <td class=text-center ><input name=vigenciaPaterno$numeroAgregado hidden type=text value='".$res1['result']['return']['Beneficiarios'][$i]['Paterno']."' />".$res1['result']['return']['Beneficiarios'][$i]['Paterno']."</td>
          <td class=text-center ><input name=vigenciaMaterno$numeroAgregado hidden type=text value='".$res1['result']['return']['Beneficiarios'][$i]['Materno']."' />".$res1['result']['return']['Beneficiarios'][$i]['Materno']."</td>
          <td class=text-center ><input name=vigenciaNacimiento$numeroAgregado hidden type=text value='".date('d/m/Y',strtotime($res1['result']['return']['Beneficiarios'][$i]['FechaNacimiento']))."' />".date('d/m/Y',strtotime($res1['result']['return']['Beneficiarios'][$i]['FechaNacimiento']))."</td>
          <td class=text-center ><input name=vigenciaCurp$numeroAgregado hidden type=text value='".$res1['result']['return']['Beneficiarios'][$i]['Curp']."' />".$res1['result']['return']['Beneficiarios'][$i]['Curp']."</td>
          <td class=text-center ><input name=vigenciaAgregado$numeroAgregado hidden type=text value='".$res1['result']['return']['Beneficiarios'][$i]['AgregadoMedico']."' />".$res1['result']['return']['Beneficiarios'][$i]['AgregadoMedico']."</td>
          <td class=text-center >".$estadoRadio."</td>
          </tr>";
        }
        echo "</tbody>";
        echo "</table>";
        }else if($tipoError == '2'){
          echo "<h1>".$mensajeError."</h1>";
        }else if($tipoError == '3'){
          echo "<h1>".$mensajeError."</h1>";
        }else{
          "<h1>".$mensajeError."</h1>";
        }
    }
    /* Funcion ajax para mostrar los medicos pertenecientes a un servicio seleccionados
    la funcion muestra las opciones para un select, con la matricula como valor y
    el nombreo completo del medico como vista al usuario */
    public function AjaxMedicosByServicio(){
      $servicio = $_GET['servicio'];
      $sql['Medico'] = $this->config_mdl->_query("SELECT empleado_matricula,empleado_nombre,empleado_apellidos
                                                  FROM os_empleados
                                                  WHERE empleado_servicio = '$servicio'
                                                  ORDER BY empleado_nombre;");
      for($i = 0; $i < count($sql['Medico']); $i++){
        echo "<option value='".$sql['Medico'][$i]['empleado_matricula']."'>".$sql['Medico'][$i]['empleado_nombre']." ".$sql['Medico'][$i]['empleado_apellidos']."</option>";
      }
    }

}