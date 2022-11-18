<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pacientes
 *
 * @author felipe de jesus
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Pacientes extends Config{
    public function __construct() {
        parent::__construct();
        $this->load->model('inicio_m');
    }

    public function index() {
        $this->load->view('pacientes/index');
    }
    public function paciente() {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $this->input->get('folio')
        ))[0];
        $sql['am']=  $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
            'triage_id'=>  $this->input->get('folio')
        ))[0];
        $sql['ce']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=>  $this->input->get('folio')
        ))[0];
        $sql['egreso']=  $this->config_mdl->_get_data_condition('os_asistentesmedicas_egresos',array(
            'triage_id'=>  $this->input->get('folio')
        ))[0];
        $sql['observacion']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=>  $this->input->get('folio'),
            'observacion_modulo'=>'Observación'
        ))[0];
        $sql['choque']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=>  $this->input->get('folio'),
            'observacion_modulo'=>'Choque'
        ))[0];
        $sql['E_HORACERO']=  $this->ObtenerEmpleadoTriage($this->input->get('folio'), 'triage_crea_horacero')[0];
        $sql['E_ET']=  $this->ObtenerEmpleadoTriage($this->input->get('folio'), 'triage_crea_enfemeria')[0];
        $sql['E_MT']=  $this->ObtenerEmpleadoTriage($this->input->get('folio'), 'triage_crea_medico')[0];
        $sql['E_AM']=  $this->ObtenerEmpleadoTriage($this->input->get('folio'), 'triage_crea_am')[0];
        $sql['E_CE']=  $this->ObtenerCE($this->input->get('folio'))[0];
        $sql['E_EC']=  $this->ObtenerOC($this->input->get('folio'), 'observacion_crea', 'Choque')[0];
        $sql['E_OC']=  $this->ObtenerOC($this->input->get('folio'), 'observacion_crea', 'Observación')[0];
        if( $_SESSION['UMAE_AREA']=='Consultorio CPR' ||
            $_SESSION['UMAE_AREA']=='Consultorio Filtro 1' ||
            $_SESSION['UMAE_AREA']=='Consultorio Filtro 2' ||
            $_SESSION['UMAE_AREA']=='Consultorio Filtro 3' ||
            $_SESSION['UMAE_AREA']=='Consultorio Filtro 4' ||
            $_SESSION['UMAE_AREA']=='Consultorio Filtro 5' ||
            $_SESSION['UMAE_AREA']=='Consultorio Neurocirugía' ||
            $_SESSION['UMAE_AREA']=='Consultorio Cirugía General' ||
            $_SESSION['UMAE_AREA']=='Consultorio Filtro 8' || 
            $_SESSION['UMAE_AREA']=='Consultorio Maxilofacial' || 
            $_SESSION['UMAE_AREA']=='Consultorio Cirugía Maxilofacial'
        ){
            $this->load->view('pacientes/paciente_ce',$sql);
        }else{
            $this->load->view('pacientes/paciente',$sql);
        }
        
        
    }
    
    public function ObtenerEmpleadoTriage($triage,$campo) {
        return $this->config_mdl->_query("SELECT * FROM os_triage, os_empleados
            WHERE os_empleados.empleado_id=os_triage.$campo AND os_triage.triage_id=".$triage );
    }
    public function ObtenerCE($triage) {
        return $this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad, os_empleados
            WHERE os_empleados.empleado_id=os_consultorios_especialidad.ce_crea AND os_consultorios_especialidad.triage_id=".$triage );
    }
    public function ObtenerOC($triage,$tipo,$modulo) {
        return $this->config_mdl->_query("SELECT * FROM os_empleados, os_observacion
            WHERE os_empleados.empleado_id=os_observacion.$tipo AND os_observacion.observacion_modulo='$modulo' AND os_observacion.triage_id=".$triage );
    }
    public function ObtenerPaciente() {
        $sql=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        if(!empty($sql)){
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function BuscarPorNombre() {
        $sql=  $this->inicio_m->_BuscarPorNombre($this->input->post('nombre'));
        if(!empty($sql)){
            foreach ($sql as $value) {
                $tr.='<tr>
                        <td>'.$value['triage_id'].'</td>
                        <td>'.$value['triage_nombre'].'</td>
                        <td>
                            <a href="'.  base_url().'inicio/pacientes/paciente?folio='.$value['triage_id'].'" target="_blank">
                                <i class="fa fa-share-square-o icono-accion" ></i>
                            </a>
                        </td>
                    <tr>';
            }
            
            $this->setOutput(array('accion'=>'1','tr'=>$tr));
        }else{
            $tr.='<tr>
                        <td colspan=3>No se encontro ningún registro</td>
                    <tr>';
            $this->setOutput(array('accion'=>'1','tr'=>$tr));
        }
    }
    public function TriageEnfermeria($id) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$id
        ));
        $this->load->view('pacientes/TriageEnfermeria',$sql);
    }
    public function EditarTriageEnfermeria() {
        $data=array(
            'triage_nombre'=> $this->input->post('triage_nombre'),
            'triage_fecha_nac'=> $this->input->post('triage_fecha_nac'),
            'triage_tension_arterial'=>  $this->input->post('triage_tension_arterial'),
            'triage_temperatura'=>  $this->input->post('triage_temperatura'),
            'triage_frecuencia_cardiaco'=>  $this->input->post('triage_frecuencia_cardiaco'),
            'triage_frecuencia_respiratoria'=>  $this->input->post('triage_frecuencia_respiratoria'),
            'triage_procedencia'=> $this->input->post('triage_procedencia'),
            'triage_hospital_procedencia'=> $this->input->post('triage_hospital_procedencia'),
            'triage_hostital_nombre_numero'=>  $this->input->post('triage_hostital_nombre_numero'),
        );
        $this->config_mdl->_update_data('os_triage',$data,array('triage_id'=>  $this->input->post('triage_id')));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AsistentesMedicas($paciente) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
           'triage_id'=>  $paciente
        ));
        $sql['solicitud']= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
           'triage_id'=>  $paciente
        ));
        $sql['hoja_rc']= $this->config_mdl->_get_data_condition('os_asistentesmedicas_rc',array(
           'asistentesmedicas_id'=>  $sql['solicitud'][0]['asistentesmedicas_id']
        ));
        $this->load->view('pacientes/AsistentesMedicas',$sql);
    }
    public function EditarAsistentesMedicas() {
        $data=array(
            'asistentesmedicas_hoja'=>  $this->input->post('asistentesmedicas_hoja'),
            'asistentesmedicas_renglon'=>  $this->input->post('asistentesmedicas_renglon')
        );
        $this->config_mdl->_update_data('os_asistentesmedicas',$data,
                array('triage_id'=>  $this->input->post('triage_id'))
        );
         $data_triage=array(
            'triage_nombre'=>  $this->input->post('triage_nombre'), 
            'triage_paciente_sexo'=> $this->input->post('triage_paciente_sexo'),
            'triage_fecha_nac'=>  $this->input->post('triage_fecha_nac'),
            'triage_paciente_edad'=>  $this->CalculaEdad($this->input->post('triage_fecha_nac'))->y, 
            'triage_paciente_meses'=>  $this->CalculaEdad($this->input->post('triage_fecha_nac'))->m, 
            'triage_paciente_afiliacion'=> $this->input->post('triage_paciente_afiliacion'),
            'triage_paciente_clinica'=> $this->input->post('triage_paciente_clinica'),
            'triage_paciente_identificacion'=>  $this->input->post('triage_paciente_identificacion'),
            'triage_paciente_estadocivil'=>  strtoupper($this->input->post('triage_paciente_estadocivil')),
            'triage_paciente_telefono'=>  $this->input->post('triage_paciente_telefono'),
            'triage_paciente_curp'=>  $this->input->post('triage_paciente_curp'),
            'triage_paciente_dir_cp'=> $this->input->post('triage_paciente_dir_cp'),
            'triage_paciente_dir_calle'=>  $this->input->post('triage_paciente_dir_calle'),
            'triage_paciente_dir_colonia'=>  $this->input->post('triage_paciente_dir_colonia'),
            'triage_paciente_dir_municipio'=>  $this->input->post('triage_paciente_dir_municipio'),
            'triage_paciente_dir_estado'=>  $this->input->post('triage_paciente_dir_estado'),
            'triage_paciente_umf'=> strtoupper($this->input->post('triage_paciente_umf')),
            'triage_paciente_delegacion'=> $this->input->post('triage_paciente_delegacion'),
            'triage_paciente_res'=> $this->input->post('triage_paciente_res'),
            'triage_paciente_res_telefono'=>  $this->input->post('triage_paciente_res_telefono'),
            'triage_paciente_res_empresa'=> $this->input->post('triage_paciente_res_empresa'),
            'triage_paciente_medico_tratante'=> $this->input->post('triage_paciente_medico_tratante'),
            'triage_paciente_asistente_medica'=> $this->input->post('triage_paciente_asistente_medica'), 
            'triage_paciente_accidente_t_hora'=>  $this->input->post('triage_paciente_accidente_t_hora'),
            'triage_paciente_accidente_t_hora_s'=>  $this->input->post('triage_paciente_accidente_t_hora_s'),
            'triage_paciente_accidente_fecha'=>  $this->input->post('triage_paciente_accidente_fecha'),
            'triage_paciente_accidente_hora'=>  $this->input->post('triage_paciente_accidente_hora'),
            'triage_paciente_accidente_lugar'=> $this->input->post('triage_paciente_accidente_lugar'),
            'triage_paciente_accidente_cp'=> $this->input->post('triage_paciente_accidente_cp'),
            'triage_paciente_accidente_calle'=> $this->input->post('triage_paciente_accidente_calle'),
            'triage_paciente_accidente_colonia'=>  $this->input->post('triage_paciente_accidente_colonia'),
            'triage_paciente_accidente_municipio'=> $this->input->post('triage_paciente_accidente_municipio'),
            'triage_paciente_accidente_estado'=> $this->input->post('triage_paciente_accidente_estado'),
            'triage_paciente_accidente_telefono'=> $this->input->post('triage_paciente_accidente_telefono'),
            'triage_paciente_accidente_rp'=> $this->input->post('triage_paciente_accidente_rp'),
            'triage_paciente_accidente_procedencia'=> $this->input->post('triage_paciente_accidente_procedencia'),
            
        );
        $this->config_mdl->_update_data('os_triage',$data_triage,
                array('triage_id'=>  $this->input->post('triage_id'))
        );
        $sql_hoja_rc= $this->config_mdl->_get_data_condition('os_asistentesmedicas_rc',array(
            'asistentesmedicas_id'=> $this->input->post('asistentesmedicas_id')
        ));
        $data_hoja_rc=array(
            'rc_cuenta_con_hoja'=> $this->input->post('rc_cuenta_con_hoja'),
            'rc_tipo_referencia'=> $this->input->post('rc_tipo_referencia'),
            'rc_fecha_solicitud'=> $this->input->post('rc_fecha_solicitud'),
            'rc_envio_especialidad'=> $this->input->post('rc_envio_especialidad'),
            'rc_tipo_referencia'=> $this->input->post('rc_unidad_que_se_envia'),
            'rc_unidad_que_se_envia'=> $this->input->post('rc_tipo_referencia'),
            'rc_delegacion_unidad_que_se_envia'=> $this->input->post('rc_delegacion_unidad_que_se_envia'),
            'rc_delegacion_unidad_que_envia'=> $this->input->post('rc_delegacion_unidad_que_envia'),
            'rc_diagnosticos'=> $this->input->post('rc_diagnosticos'),
            'rc_motivo_envio'=> $this->input->post('rc_motivo_envio'),
            'rc_incapacidad'=> $this->input->post('rc_incapacidad'),
            'rc_incapacidad_folio'=> $this->input->post('rc_incapacidad_folio'),
            'rc_incapacidad_dias'=> $this->input->post('rc_incapacidad_dias'),
            'rc_incapacidad_fecha_inicio'=> $this->input->post('rc_incapacidad_fecha_inicio'),
            'rc_incapacidad_ramo_seguro'=> $this->input->post('rc_incapacidad_ramo_seguro'),
            'rc_incapacidad_tipo'=> $this->input->post('rc_incapacidad_tipo'),
            'rc_incapacidad_dias_acomulados'=> $this->input->post('rc_incapacidad_dias_acomulados'),
            'unidadmedica_id'=> $this->input->post('unidadmedica_id'),
            'asistentesmedicas_id'=> $this->input->post('asistentesmedicas_id')
        );
        if(empty($sql_hoja_rc)){
            $this->config_mdl->_insert('os_asistentesmedicas_rc',$data_hoja_rc);
        }else{
            $this->config_mdl->_update_data('os_asistentesmedicas_rc',$data_hoja_rc,array(
                'asistentesmedicas_id'=> $this->input->post('asistentesmedicas_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));   
    }
    public function CalculaEdad($fechanac){
        $fecha_hac=  new DateTime(str_replace('/', '-', $fechanac));
        $hoy=  new DateTime(date('d-m-Y')); 
        return $hoy->diff($fecha_hac); 
    }
    public function Consultorios($paciente) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $paciente
        ));
        $sql['hojaforntal']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'triage_id'=>  $paciente
        ));
        $sql['am']=  $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
            'triage_id'=>  $paciente
        ));
        $sql['rx']=  $this->config_mdl->_get_data_condition('os_triage_casosclinicos',array(
            'triage_id'=>  $paciente
        ));
        $this->load->view('pacientes/Consultorios',$sql);
    }
    public function EditarConsultorios() {
        $data=array(
            'hf_intoxitacion'=>  $this->input->post('hf_intoxitacion'),
            'hf_intoxitacion_descrip'=>  $this->input->post('hf_intoxitacion_descrip'),
            'hf_urgencia'=>  $this->input->post('hf_urgencia'),
            'hf_especialidad'=>  $this->input->post('hf_especialidad'),
            'hf_motivo'=>  $this->input->post('hf_motivo'),
            'hf_mecanismolesion_caida'=> $this->input->post('hf_mecanismolesion_mtrs'),
            'hf_mecanismolesion_ab'=>  $this->input->post('hf_mecanismolesion_ab'),
            'hf_mecanismolesion_td'=>  $this->input->post('hf_mecanismolesion_td'),
            'hf_mecanismolesion_av'=>  $this->input->post('hf_mecanismolesion_av'),
            'hf_mecanismolesion_maquinaria'=>  $this->input->post('hf_mecanismolesion_maquinaria'),
            'hf_mecanismolesion_mordedura'=>  $this->input->post('hf_mecanismolesion_mordedura'),
            'hf_mecanismolesion_otros'=>  $this->input->post('hf_mecanismolesion_otros'),
            'hf_quemadura_fd'=>  $this->input->post('hf_quemadura_fd'),
            'hf_quemadura_ce'=>  $this->input->post('hf_quemadura_ce'),
            'hf_quemadura_e'=>  $this->input->post('hf_quemadura_e'),
            'hf_quemadura_q'=>  $this->input->post('hf_quemadura_q'),
            'hf_quemadura_otros'=>  $this->input->post('hf_quemadura_otros'),
            'hf_antecedentes'=>  $this->input->post('hf_antecedentes'),
            'hf_exploracionfisica'=>  $this->input->post('hf_exploracionfisica'),
            'hf_interpretacion'=>  $this->input->post('hf_interpretacion'),
            'hf_diagnosticos'=>  $this->input->post('hf_diagnosticos'),
            'hf_trataminentos_curacion'=> $this->input->post('hf_trataminentos_curacion'),
            'hf_trataminentos_sutura'=> $this->input->post('hf_trataminentos_sutura'),
            'hf_trataminentos_vendaje'=> $this->input->post('hf_trataminentos_vendaje'),
            'hf_trataminentos_ferula'=> $this->input->post('hf_trataminentos_ferula'),
            'hf_trataminentos_vacunas'=> $this->input->post('hf_trataminentos_vacunas'),
            'hf_trataminentos_otros'=>  $this->input->post('hf_trataminentos_otros'),
            'hf_trataminentos_por'=>  $this->input->post('hf_trataminentos_por'),
            'hf_receta_por'=>  $this->input->post('hf_receta_por'),
            'hf_indicaciones'=>  $this->input->post('hf_indicaciones'),
            'hf_ministeriopublico'=>  $this->input->post('hf_ministeriopublico'),
            'hf_incapacidad_dias'=>  $this->input->post('hf_incapacidad_dias'),
            'hf_incapacidad_ptr_eg'=>  $this->input->post('hf_incapacidad_ptr_eg'),
            'triage_id'=>  $this->input->post('triage_id')
            
        );
        $data_am=array(
            'asistentesmedicas_da'=>  $this->input->post('asistentesmedicas_da'),
            'asistentesmedicas_dl'=>  $this->input->post('asistentesmedicas_dl'),
            'asistentesmedicas_ip'=>  $this->input->post('asistentesmedicas_ip'),
            'asistentesmedicas_tratamientos'=>  $this->input->post('asistentesmedicas_tratamientos'),
            'asistentesmedicas_ss_in'=>  $this->input->post('asistentesmedicas_ss_in'),
            'asistentesmedicas_ss_ie'=>  $this->input->post('asistentesmedicas_ss_ie'),
            'asistentesmedicas_oc_hr'=>  $this->input->post('asistentesmedicas_oc_hr'),
            'asistentesmedicas_am'=>  $this->input->post('asistentesmedicas_am'),
            'asistentesmedicas_incapacidad_am'=>  $this->input->post('asistentesmedicas_incapacidad_am'),
            'asistentesmedicas_incapacidad_fi'=>  $this->input->post('asistentesmedicas_incapacidad_fi'),
            'asistentesmedicas_incapacidad_da'=>  $this->input->post('asistentesmedicas_incapacidad_da'),
            'asistentesmedicas_mt'=>  $this->input->post('asistentesmedicas_mt'),
            'asistentesmedicas_mt_m'=>  $this->input->post('asistentesmedicas_mt_m'),
            'asistentesmedicas_incapacidad_folio'=>  $this->input->post('asistentesmedicas_incapacidad_folio'),
            'asistentesmedicas_omitir'=>  $this->input->post('asistentesmedicas_omitir')
        );
        $sql_hf=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        if(empty($sql_hf)){
            $this->config_mdl->_insert('os_consultorios_especialidad_hf',$data);
        }else{
            $this->config_mdl->_update_data('os_consultorios_especialidad_hf',$data,array(
                'triage_id'=>  $this->input->post('triage_id')
            ));
        }
        
        $this->config_mdl->_update_data('os_asistentesmedicas',$data_am,array(
           'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_consultorios_especialidad',array(
            'ce_hf'=>$this->input->post('hf_alta')
        ),array(
           'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function ConsultoriosCpr($paciente) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $paciente
        ));
        $sql['cpr']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_cpr',array(
            'triage_id'=>  $paciente
        ));
        $sql['am']=  $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
            'triage_id'=>  $paciente
        ));
        $this->load->view("pacientes/ConsultoriosCpr",$sql);
    }
    public function EditarConsultoriosCpr() {
        $data=array(
            'cpr_nota'=>  $this->input->post('cpr_nota'),
            'triage_id'=>  $this->input->post('triage_id')
        );
        $data_am=array(
            'asistentesmedicas_da'=>  $this->input->post('asistentesmedicas_da'),
            'asistentesmedicas_dl'=>  $this->input->post('asistentesmedicas_dl'),
            'asistentesmedicas_ip'=>  $this->input->post('asistentesmedicas_ip'),
            'asistentesmedicas_tratamientos'=>  $this->input->post('asistentesmedicas_tratamientos'),
            'asistentesmedicas_ss_in'=>  $this->input->post('asistentesmedicas_ss_in'),
            'asistentesmedicas_ss_ie'=>  $this->input->post('asistentesmedicas_ss_ie'),
            'asistentesmedicas_oc_hr'=>  $this->input->post('asistentesmedicas_oc_hr'),
            'asistentesmedicas_am'=>  $this->input->post('asistentesmedicas_am'),
            'asistentesmedicas_incapacidad_am'=>  $this->input->post('asistentesmedicas_incapacidad_am'),
            'asistentesmedicas_incapacidad_fi'=>  $this->input->post('asistentesmedicas_incapacidad_fi'),
            'asistentesmedicas_incapacidad_da'=>  $this->input->post('asistentesmedicas_incapacidad_da'),
            'asistentesmedicas_mt'=>  $this->input->post('asistentesmedicas_mt'),
            'asistentesmedicas_mt_m'=>  $this->input->post('asistentesmedicas_mt_m'),
            'asistentesmedicas_incapacidad_folio'=>  $this->input->post('asistentesmedicas_incapacidad_folio'),
            'asistentesmedicas_omitir'=>  $this->input->post('asistentesmedicas_omitir')
        );
        $sql_cpr=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_cpr',array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        if(empty($sql_cpr)){
            $this->config_mdl->_insert('os_consultorios_especialidad_cpr',$data);
        }else{
            $this->config_mdl->_update_data('os_consultorios_especialidad_cpr',$data,array(
                'triage_id'=>  $this->input->post('triage_id')
            ));
        }
        $this->config_mdl->_update_data('os_asistentesmedicas',$data_am,array(
           'triage_id'=>  $this->input->post('triage_id')
        ));
        
        $this->setOutput(array('accion'=>'1'));
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
            if($this->CalculaEdad($info['triage_fecha_nac'])->y<18){
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
    
}
