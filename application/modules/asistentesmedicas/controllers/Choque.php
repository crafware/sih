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
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_choque_v2 WHERE 
            os_triage.triage_id=os_choque_v2.triage_id AND 
            os_choque_v2.choque_status='Ingreso' AND
            os_choque_v2.registro_am = 0 AND
            os_triage.triage_via_registro='Choque' AND 
            os_triage.triage_fecha = CURDATE() ORDER BY os_choque_v2.choque_id DESC");
        // if(MOD_CHOQUE=='Si'){
            $this->load->view('Choque/choque_index',$sql);
        // }else{
        //     $this->ModuleNotAvailable();
        // }
        
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
        $sql['DirPaciente']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'=>  $Paciente,
            'directorio_tipo'=>'Paciente'
        ))[0];
        $sql['DirEmpresa']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'=>  $Paciente,
            'directorio_tipo'=>'Empresa'
        ))[0];
        $sql['Empresa']=  $this->config_mdl->_get_data_condition('os_triage_empresa',array(
           'triage_id'=>  $Paciente,
        ))[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['notaHf'] = $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf', array(
            'triage_id' => $Paciente
        ));
        $sql['medicoValora'] = $this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id' => $notaHf['empleado_id']
        ))[0];
        // if(MOD_CHOQUE=='Si'){
            $this->load->view('Choque/choque_am',$sql);
        // }else{
        //     $this->ModuleNotAvailable();
        // }
        
    }
    public function AjaxAsistenteMedica() {
        
        $data=array(
            'asistentesmedicas_fecha'   => date('Y-m-d'),
            'asistentesmedicas_hora'    => date('H:i'), 
            'asistentesmedicas_hoja'    => $this->input->post('asistentesmedicas_hoja'),
            'asistentesmedicas_renglon' => $this->input->post('asistentesmedicas_renglon'),
            'asistentesmedicas_ss_in'   => $this->input->post('asistentesmedicas_ss_in'),
            'asistentesmedicas_ss_ie'   => $this->input->post('asistentesmedicas_ss_ie'),
            'asistentesmedicas_oc_hr'   => $this->input->post('asistentesmedicas_oc_hr'),
            // 'asistentesmedicas_mt'      => $this->input->post('asistentesmedicas_mt'), 
            // 'asistentesmedicas_mt_m'    => $this->input->post('asistentesmedicas_mt_m'),

            'triage_id'=>  $this->input->post('triage_id')
        );
        $sql_check_am= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(empty($sql_check_am)){
            if($this->input->post('triage_paciente_accidente_lugar')=='TRABAJO'){
                Modules::run('Asistentesmedicas/DOC_ST7_FOLIO',array(
                    'triage_id'=>  $this->input->post('triage_id')
                ));
            }
            $this->config_mdl->_insert('os_asistentesmedicas',$data);
            $asistentesmedicas_id= $this->config_mdl->_get_last_id('os_asistentesmedicas','asistentesmedicas_id');
        }else{
            unset($data['asistentesmedicas_fecha']);
            unset($data['asistentesmedicas_hora']);
            $this->config_mdl->_update_data('os_asistentesmedicas',$data,array(
                 'asistentesmedicas_id'=> $this->input->post('asistentesmedicas_id')
             ));
            $asistentesmedicas_id= $this->input->post('asistentesmedicas_id');
        }
        $data_triage=array(
            'triage_fecha'          => date('Y-m-d'), 
            'triage_hora'           => date('H:i'), 
            'triage_nombre'         => $this->input->post('triage_nombre'), 
            'triage_nombre_ap'      => $this->input->post('triage_nombre_ap'), 
            'triage_nombre_am'      => $this->input->post('triage_nombre_am'), 
            'triage_paciente_sexo'  => $this->input->post('triage_paciente_sexo'),
            'triage_fecha_nac'      => $this->input->post('triage_fecha_nac'),
            'triage_paciente_curp'  => $this->input->post('triage_paciente_curp'),
            'triage_crea_am'        => $this->UMAE_USER
        );
        $this->config_mdl->_update_data('paciente_info',array(
            'pum_nss'                   =>$this->input->post('pum_nss'),
            'pum_nss_agregado'          =>$this->input->post('pum_nss_agregado'),
            'pum_nss_armado'            =>$this->input->post('pum_nss_armado'),
            'pum_umf'                   =>$this->input->post('pum_umf'),
            'pum_delegacion'            =>$this->input->post('pum_delegacion'),
            'pia_lugar_accidente'       =>$this->input->post('pia_lugar_accidente'),
            'pia_lugar_procedencia'     =>$this->input->post('pia_lugar_procedencia'),
            'pia_dia_pa'                =>$this->input->post('pia_dia_pa'),
            'pia_fecha_accidente'       =>$this->input->post('pia_fecha_accidente'),
            'pia_hora_accidente'        =>$this->input->post('pia_hora_accidente'),
            'pic_identificacion'        =>$this->input->post('pic_identificacion'),
            'pic_responsable_nombre'    =>$this->input->post('pic_responsable_nombre'),
            'pic_responsable_parentesco'=>$this->input->post('pic_responsable_parentesco'),
            'pic_responsable_telefono'  =>$this->input->post('pic_responsable_telefono'),
            'pic_mt'                    =>$this->input->post('pic_mt'),
            'pic_am'                    =>$this->input->post('pic_am'),
            'pia_procedencia_espontanea'=>$this->input->post('pia_procedencia_espontanea'),
            'pia_tipo_atencion'         =>$this->input->post('pia_tipo_atencion'),
            'pia_vigencia'              =>$this->input->post('pia_vigencia'),
            'pia_documento'             =>$this->input->post('pia_documento'),
            'pia_procedencia_hospital'  =>$this->input->post('pia_procedencia_hospital'),
            'pia_procedencia_hospital_num' =>$this->input->post('pia_procedencia_hospital_num')
        ),array(
            'triage_id'                 =>$this->input->post('triage_id')
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
        $this->config_mdl->_update_data('os_choque_v2', array(
            'registro_am'   => 1),
            array('triage_id'=>  $this->input->post('triage_id'))
        );
        $this->config_mdl->_insert('doc_43021',array(
            'doc_fecha'=> date('Y-m-d'),
            'doc_hora'=> date('H:i:s'),
            'doc_turno'=>Modules::run('Config/ObtenerTurno'),
            'doc_destino'=>'Choque',
            'doc_tipo'=>'Ingreso',
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Asistente Médica','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$asistentesmedicas_id));
        $this->setOutput(array('accion'=>'1'));     
    }
    public function CheckHojaFrontal($data) {
        $sql= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
            'triage_id'=>$data['triage_id']
        ));
        if(empty($sql)){
            return 'No';
        }else{
            return 'Si';
        }
    }
    
    public function AjaxTarjetaIdentificacion() {
        $check= $this->config_mdl->_get_data_condition('os_tarjeta_identificacion',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $data=array(
            'ti_enfermedades'=> $this->input->post('ti_enfermedades'),
            'ti_alergias'=> $this->input->post('ti_alergias'),
            'ti_fecha'=> date('d-m-Y'),
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
        $this->config_mdl->_update_data('os_choque_camas',array(
            'choque_cama_alta'=>  $this->input->post('choque_cama_alta')
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        if($this->input->post('choque_cama_alta')=='Alta e ingreso a Observación'){
            $paciente= $this->config_mdl->_get_data_condition('os_triage',array(
                'triage_id'=> $this->input->post('triage_id')
            ))[0];
            $this->config_mdl->_delete_data('os_observacion',array(
                'triage_id'=>$this->input->post('triage_id'),
            ));
            if($paciente[0]['triage_paciente_edad']<15){
                $observacion_area='3';
            }else{
                if($paciente['triage_paciente_sexo']=='MUJER'){
                    $observacion_area='4';
                }else{
                    $observacion_area='5';
                }
            }
            $check_obs= $this->config_mdl->_get_data_condition('os_observacion',array(
                'triage_id'=>$this->input->post('triage_id')
            ));
            $data_obs=array(
                'observacion_fe'=>  date('d-m-Y'),
                'observacion_he'=>date('H:i'),
                'triage_id'=>$this->input->post('triage_id'),
                'observacion_area'=>$observacion_area,
                'observacion_status_v2'=>'En Espera'
            );
            if(empty($check_obs)){
                $this->config_mdl->_insert('os_observacion',$data_obs);
            }else{
                $this->config_mdl->_update_data('os_observacion',$data_obs,array('triage_id'=> $this->input->post('triage_id')));
            }
        }else{
            $this->config_mdl->_delete_data('os_modulo',array(
                'modulo_area'=>  $this->input->post('choque_cama_alta'),
                'triage_id'=>$this->input->post('triage_id')
            ));
            $this->config_mdl->_insert('os_modulo',array(
                'modulo_fe'=>  date('d-m-Y'),
                'modulo_he'=>  date('H:i'),
                'modulo_area'=>  $this->input->post('choque_cama_alta'),
                'triage_id'=>$this->input->post('triage_id')
            ));   
        }
        $this->config_mdl->_update_data('os_choque_camas',array(
            'choque_cama_fs'=> date('d-m-Y'),
            'choque_cama_hs'=>  date('H:i') ,
            'choque_cama_status'=>'Salida'
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
        $choque= $this->config_mdl->_get_data_condition('os_choque_camas',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->EgresoCamas($egreso=array(
            'cama_egreso_cama'=>$this->input->post('cama_id'),
            'cama_egreso_destino'=>$this->input->post('choque_cama_alta'),
            'cama_egreso_table'=>'os_choque_camas',
            'cama_egreso_table_id'=>$choque['choque_cama_id'],
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Egreso Choque','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$choque['observacion_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxIngresoChoque() {
        $data=array(
            'triage_id'=> $this->input->post('triage_id')
        );
        $this->config_mdl->_insert('os_choque_camas',$data);
        $this->setOutput(array('accion'=>'1'));
    }
    public function GenerarFolioV2() {
        $this->config_mdl->_insert('os_triage',array(
            'triage_horacero_f'     =>  date('Y-m-d'),
            'triage_horacero_h'     =>  date('H:i'),
            'triage_via_registro'   => 'Choque',
            'triage_crea_enfemeria'=> $this->UMAE_USER
        ));
        $last_id=  $this->config_mdl->_get_last_id('os_triage','triage_id');
        if($this->input->post('triage_paciente_sexo')=='HOMBRE'){
            $triage_paciente_sexo='OM';
        }else{
            $triage_paciente_sexo='OF';
        }
        if($this->input->post('triage_tipo_paciente')=='No Identificado'){
            $numcon_id= $this->NumeroConsecutivo();
            $anio= substr(date('Y'), 2, 4);
            $NSS='';
            $NSS_A= date('dm').$anio.'50'.$numcon_id.$triage_paciente_sexo.$this->input->post('triage_fecha_nac_a').'ND';
            $this->NumeroConsecutivoLog(array(
                'numcon_nss'=>$NSS_A,
                'numcon_id'=>$numcon_id,
                'triage_id'=>$last_id
            ));
        }else{
            if($this->input->post('triage_paciente_afiliacion_bol')=='No'){
                $numcon_id= $this->NumeroConsecutivo();
                $anio= substr(date('Y'), 2, 4);
                $NSS= '';
                $NSS_A= date('dm').$anio.'50'.$numcon_id.$triage_paciente_sexo.$this->input->post('triage_fecha_nac_a').'ND';
                $this->NumeroConsecutivoLog(array(
                    'numcon_nss'=>$NSS_A,
                    'numcon_id'=>$numcon_id,
                    'triage_id'=>$last_id
                ));
            }else{
                $NSS_A='';
                $NSS=$this->input->post('pum_nss');
            }
            
        }
        $data=array(
            'triage_tipo_paciente'      => $this->input->post('triage_tipo_paciente'),
            'triage_nombre'             => $this->input->post('triage_nombre'),
            'triage_nombre_ap'          => $this->input->post('triage_nombre_ap'),
            'triage_nombre_am'          => $this->input->post('triage_nombre_am'),
            'triage_nombre_pseudonimo'  => $this->input->post('triage_nombre_pseudonimo'),
            'triage_paciente_sexo'      => $this->input->post('triage_paciente_sexo'),
            'triage_fecha_nac_a'        => $this->input->post('triage_fecha_nac_a'),
            'triage_color'              => 'Rojo',
            'triage_crea_horacero'      => $_SESSION['UMAE_USER'],
            'triage_fecha'              => date('Y-m-d'),
            'triage_hora'               => date('H:i'),
            'triage_motivoAtencion'     => $this->input->post('triage_motivoAtencion')
        );
        $this->config_mdl->_update_data('os_triage',$data,array(
            'triage_id'=>$last_id
        ));
        $this->config_mdl->_insert('os_triage_po',array(
            'po_donador'=>'No',
            'po_criterio'=>'',
            'triage_id'=>$last_id
        ));
        $this->config_mdl->_insert('os_choque_v2',array(
            'choque_status'     => 'Ingreso',
            'choque_vigilante'  => 'En Espera',
            'choque_ingreso_f'  => date('d-m-Y'),
            'choque_ingreso_h'  => date('H:i'),
            'triage_id'         => $last_id,
            'registro_am'       => 0,
            'empleado_id'=> $this->UMAE_USER
        ));
        $this->config_mdl->_insert('paciente_info',array(
            'pum_nss'=>$NSS,
            'pum_nss_agregado'=> $this->input->post('pum_nss_agregado'),
            'pum_nss_armado'=>$NSS_A,
            'pia_procedencia_espontanea'=>$this->input->post('pia_procedencia_espontanea'),
            'pia_procedencia_espontanea_lugar'=>$this->input->post('pia_procedencia_espontanea_lugar'),
            'pia_procedencia_hospital'=>$this->input->post('pia_procedencia_hospital'),
            'pia_procedencia_hospital_num'=>$this->input->post('pia_procedencia_hospital_num'),
            'triage_id'=>$last_id
        ),array(
            'triage_id'=>$last_id
        ));
        $last_id_choque=  $this->config_mdl->_get_last_id('os_choque_v2','choque_id');
        $this->AccesosUsuarios(array('acceso_tipo'=>'Hora Cero Choque','triage_id'=>$last_id,'areas_id'=>$last_id_choque));
        $this->setOutput(array('accion'=>'1','max_id'=>$last_id));
    }
    public function NumeroConsecutivoLog($data) {
        $this->config_mdl->_insert('os_triage_numcon_log',array(
            'numcon_log_fecha'=> date('d-m-Y'),
            'numcon_log_hora'=> date('H:i'),
            'numcon_nss'=>$data['numcon_nss'],
            'numcon_id'=>$data['numcon_id'],
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=>$data['triage_id']
        ));
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
        $this->config_mdl->_insert('os_triage_numcon',array(
            'numcon_fecha'=> date('d-m-Y')
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
