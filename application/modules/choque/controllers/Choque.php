<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Choque
 *
 * @author bienTICS
 */
include_once APPPATH.'modules/config/controllers/Config.php';
include_once APPPATH.'third_party/PHPExcel/PHPExcel.php';
class Choque extends Config{
    //construct
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->view('choque_index');
    }
    public function Medico() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_choque_v2 WHERE 
            os_triage.triage_id=os_choque_v2.triage_id AND 
            os_choque_v2.choque_status='Ingreso' AND
            os_triage.triage_via_registro='Choque' ORDER BY os_choque_v2.choque_id DESC");
        $this->load->view('choque_medico',$sql);
    }
    public function ObtenerCamasChoque() {
        $sql= $this->config_mdl->_query("SELECT * FROM os_camas WHERE os_camas.area_id=6 AND os_camas.cama_status='Disponible'");
        if(empty($sql)){
            $this->setOutput(array('accion'=>'2'));
        }else{
            foreach ($sql as $value) {
                $option.='<option value="'.$value['cama_id'].'">'.$value['cama_nombre'].'</option>';
            }
            $this->setOutput(array('accion'=>$option));
        }
    }
    public function AjaxAsignarCama() {
        $data=array(
            'choque_ac_f'=> date('d/m/Y'),
            'choque_ac_h'=> date('H:i'),
            //'choque_cama_status'=>'Asignado',
            'cama_id'=> $this->input->post('cama_id'),
            //'empleado_id'=> $this->UMAE_USER,
            'medico_id'=> $this->UMAE_USER,
            'triage_id'=> $this->input->post('triage_id')
        );
        $this->config_mdl->_update_data('os_choque_v2',$data,array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_ingreso_f'=> date('d/m/Y'),
            'cama_ingreso_h'=> date('H:i'),
            'cama_dh'=>$this->input->post('triage_id')
        ),array(
            'cama_id'=>  $this->input->post('cama_id')
        ));
        $choque= $this->config_mdl->_get_data_condition('os_choque_v2',array('triage_id'=> $this->input->post('triage_id')));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso Choque','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$choque[0]['choque_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    public function Enfermeria() {
               $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_choque_v2 WHERE 
            os_triage.triage_id=os_choque_v2.triage_id AND 
            os_choque_v2.choque_status='Ingreso' AND
            os_triage.triage_via_registro='Choque' ORDER BY os_choque_v2.choque_id DESC");
        $this->load->view('choque_enfermeria',$sql);
    }
    public function EnfermeriaCamas() {
        $this->load->view('choque_enfermeria_camas');
    }
    public function InformacionCama($data) {
        $sql= $this->config_mdl->_get_data_condition('os_camas',array(
            'cama_id'=> $data['cama_id']
        ));
        return $sql[0]['cama_nombre'];
    }
    public function VisorCamas() {
        $this->load->view('choque_visorcamas');
    }
    public function AsistenteMedica($Paciente) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
           'triage_id'=>  $Paciente
        ));
        $sql['solicitud']= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
           'triage_id'=> $Paciente
        ));
        $sql['empleado']= $this->config_mdl->_get_data_condition('os_empleados',array(
           'empleado_id'=> $this->UMAE_USER
        ));
        $sql['hoja_rc']= $this->config_mdl->_get_data_condition('os_asistentesmedicas_rc',array(
           'asistentesmedicas_id'=>  $sql['solicitud'][0]['asistentesmedicas_id']
        ));
        $this->load->view('choque_am',$sql);
    }
    public function AjaxAsistenteMedica() {
        $info=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $this->input->post('triage_id')
        ))[0];
    
        $data=array(
            'asistentesmedicas_fecha'=> date('Y-m-d'),
            'asistentesmedicas_hora'=> date('H:i'), 
            'triage_id'=>  $this->input->post('triage_id')
        );
        /* Incapacidades */
        $this->config_mdl->_update_data('os_asistentesmedicas',$data,
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
        
        $data_triage=array(
            'triage_nombre'         => $this->input->post('triage_nombre'),
            'triage_paciente_sexo'  => $this->input->post('triage_paciente_sexo'),
            'triage_nombre_ap'      => $this->input->post('triage_nombre_ap'),
            'triage_nombre_am'      => $this->input->post('triage_nombre_am'),
            'triage_paciente_curp'  => $this->input->post('triage_paciente_curp'),
            'triage_fecha_nac'      => $this->input->post('triage_fecha_nac'),
            'triage_crea_am'        => $this->UMAE_USER        
        );
        $this->config_mdl->_update_data('os_triage',$data_triage,
                array('triage_id'=>  $this->input->post('triage_id'))
        );
        
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

        $this->AccesosUsuarios(array('acceso_tipo'=>'Asistente Médica Choque','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$this->input->post('asistentesmedicas_id')));
        $this->setOutput(array('accion'=>'1'));     
    }
    public function AjaxTarjetaIdentificacion() {
        $check= $this->config_mdl->_get_data_condition('os_tarjeta_identificacion',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $data=array(
            'ti_enfermedades'=> $this->input->post('ti_enfermedades'),
            'ti_alergias'=> $this->input->post('ti_alergias'),
            'ti_fecha'=> date('d/m/Y'),
            'ti_hora'=> date('H:i'),
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=> $this->input->post('triage_id')
        );
        if(empty($check)){
            $this->config_mdl->_insert('os_tarjeta_identificacion',$data);
        }else{
            unset($data['ti_fecha']);
            unset($data['ti_hora']);
            unset($data['empleado_id']);
            $this->config_mdl->_update_data('os_tarjeta_identificacion',$data,array(
                'triage_id'=> $this->input->post('triage_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxAltaPaciente() {
        $this->config_mdl->_update_data('os_choque_v2',array(
            'choque_alta'=>  $this->input->post('choque_alta')
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_choque_v2',array(
            'choque_salida_f'=> date('d/m/Y'),
            'choque_salida_h'=>  date('H:i') ,
            'choque_status'=>'Salida'
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'En Limpieza',
            'cama_ingreso_f'=> '',
            'cama_ingreso_h'=> '',
            'cama_dh'=>0,
        ),array(
            'cama_id'=>  $this->input->post('cama_id')
        ));
        $choque= $this->config_mdl->_get_data_condition('os_choque_v2',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->EgresoCamas($egreso=array(
            'cama_egreso_cama'=>$this->input->post('cama_id'),
            'cama_egreso_destino'=>$this->input->post('choque_alta'),
            'cama_egreso_table'=>'os_choque_v2',
            'cama_egreso_table_id'=>$choque['choque_id'],
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Egreso Choque','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$choque['choque_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    public function SignosVitales($Paciente) {
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage_signosvitales, os_empleados
                WHERE os_triage_signosvitales.empleado_id=os_empleados.empleado_id AND
                os_triage_signosvitales.triage_id=".$Paciente);
        $this->load->view('choque_signosvitales',$sql);
    }
    public function AjaxSignosVitales() {
        $data=array(
            'triage_tension_arterial'=> $this->input->post('triage_tension_arterial'),
            'triage_temperatura'=> $this->input->post('triage_temperatura'),
            'triage_frecuencia_cardiaco'=> $this->input->post('triage_frecuencia_cardiaco'),
            'triage_frecuencia_respiratoria'=> $this->input->post('triage_frecuencia_respiratoria')
        );
        $this->config_mdl->_update_data('os_triage',$data,array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $data_sv=array(
            'triage_tension_arterial'=> $this->input->post('triage_tension_arterial'),
            'triage_temperatura'=> $this->input->post('triage_temperatura'),
            'triage_frecuencia_cardiaco'=> $this->input->post('triage_frecuencia_cardiaco'),
            'triage_frecuencia_respiratoria'=> $this->input->post('triage_frecuencia_respiratoria'),
            'sv_fecha'=> date('d/m/Y'),
            'sv_hora'=> date('H:i'),
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=> $this->input->post('triage_id')
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('os_triage_signosvitales',$data_sv);
        }else{
            unset($data_sv['sv_fecha']);
            unset($data_sv['sv_hora']);
            unset($data_sv['empleado_id']);
            $this->config_mdl->_update_data('os_triage_signosvitales',$data_sv,array(
                'sv_id'=> $this->input->post('sv_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    
    public function GenerarFolio() {
        $data=array(
            'triage_status'          => 'En Captura',
            'triage_etapa'           => '0',
            'triage_horacero_h'      => date('H:i'),
            'triage_horacero_f'      => date('Y-m-d'),
            'triage_crea_horacero'   => $_SESSION['UMAE_USER'],
            'triage_fecha_clasifica' => date('Y-m-d'),  
            'triage_hora_clasifica'  => date('H:i')
        );
        $this->config_mdl->_insert('os_triage',$data);
        $last_id=  $this->config_mdl->_get_last_id('os_triage','triage_id');
        
        $triage_fecha_nac= explode('/', $this->input->post('triage_fecha_nac'))[2];
        if($this->input->post('triage_paciente_sexo')=='HOMBRE'){
            $triage_paciente_sexo='OM';
        }else{
            $triage_paciente_sexo='OF';
        }
        if($this->input->post('triage_tipo_paciente')=='No Identificado'){
            $numcon_id= $this->NumeroConsecutivo();
            $anio= substr(date('Y'), 2, 4);
            $NSS= date('dm').$anio.'50'.$numcon_id.$triage_paciente_sexo.$triage_fecha_nac.'ND';
            $this->NumeroConsecutivoLog(array(
                'numcon_nss'=>$NSS,
                'numcon_id'=>$numcon_id,
                'triage_id'=>$last_id
            ));
        }else{
            if($this->input->post('triage_paciente_afiliacion')=='No'){
                $numcon_id= $this->NumeroConsecutivo();
                $anio= substr(date('Y'), 2, 4);
                $NSS= date('dm').$anio.'50'.$numcon_id.$triage_paciente_sexo.$triage_fecha_nac.'ND';
                $this->NumeroConsecutivoLog(array(
                    'numcon_nss'=>$NSS,
                    'numcon_id'=>$numcon_id,
                    'triage_id'=>$last_id
                ));
            }else{
                $NSS='';
            }
            
        }
        $this->config_mdl->_update_data('os_triage',array(
            'triage_tipo_paciente'=> $this->input->post('triage_tipo_paciente'),
            'triage_paciente_afiliacion'=>$NSS,
            'triage_paciente_sexo'=> $this->input->post('triage_paciente_sexo'),
            'triage_fecha_nac'=> $this->input->post('triage_fecha_nac')
        ),array(
            'triage_id'=>$last_id
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Hora Cero','triage_id'=>$last_id));
        $this->setOutput(array('accion'=>'1','max_id'=>$last_id,'areas_id'=>$NSS));
    }
    public function NumeroConsecutivoLog($data) {
        $this->config_mdl->_insert('os_triage_numcon_log',array(
            'numcon_log_fecha'=> date('d/m/Y'),
            'numcon_log_hora'=> date('H:i'),
            'numcon_nss'=>$data['numcon_nss'],
            'numcon_id'=>$data['numcon_id'],
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=>$data['triage_id']
        ));
    }
    public function NumeroConsecutivo() {
        $hoy= date('d/m/Y');
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
        $this->config_mdl->_insert('os_triage_numcon',array(
            'numcon_fecha'=> date('d/m/Y')
        ));
        $last_id=$this->config_mdl->_get_last_id('os_triage_numcon','numcon_id');
        if(strlen($last_id)==1){
            $last_id_='0'.$last_id;
        }else{
            $last_id_=$last_id;
        }
        return $last_id_;
    }
}
