<?php
/**
 * Description of module Triage Respiratorio
 *
 * @author cr@fWARE
 */
include_once APPPATH.'modules/config/controllers/Config.php';

class Triagerespiratorio extends Config{
    //construct
    public function __construct() {
        parent::__construct();
    }
    public function index() {
       $sql['infoPaciente']= $this->config_mdl->_query(
        "SELECT * FROM os_triage, os_accesos, os_empleados WHERE
                os_accesos.acceso_tipo='Triage Médico' AND
                os_accesos.triage_id=os_triage.triage_id AND
                os_accesos.empleado_id=os_empleados.empleado_id AND
                os_triage.triage_via_registro = 'Hora Cero TR' AND
                os_triage.triage_crea_am  IS Null AND
                os_triage.triage_consultorio_nombre = 'Hospitalización' ORDER BY os_accesos.acceso_id DESC LIMIT 50");
        
            $this->load->view('Triagerespiratorio/index',$sql);     
        
    }
    public function Registro($Paciente) {

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
        
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        
        
        $sql['Especialidades'] = $this->config_mdl->_query("SELECT especialidad_id, especialidad_nombre FROM                                                um_especialidades WHERE especialidad_hospitalizacion=1 ORDER BY especialidad_nombre");
        
        $sql['Medico']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_roles'=>'2',
            'empleado_jefe_servicio'=>'Si'
        ));

        $sql['Doc43051'] = $this->config_mdl->_get_data_condition("doc_43051",array(
          'triage_id'=> $Paciente
        ))[0];

        $sql['medicoTratante'] = $this->config_mdl->_get_data_condition('os_empleados',array(
          'empleado_id'=> $sql['Doc43051']['ingreso_medico']
        ),'empleado_matricula,empleado_nombre,empleado_apellidos')[0];

        $sql['Area'] = $this->config_mdl->_get_data_condition("os_areas", array(
            'area_modulo' => 'Pisos'));
        
        $sql['Cama'] =$this->config_mdl->_get_data_condition('os_camas', array(
            'area_id'     => $sql['Doc43051']['area_id']
        ));

        
        // if(MOD_TRIAGERESPIRATORIO=='Si'){
            $this->load->view('Triagerespiratorio/registroPaciente',$sql);
        // }else{
        //     $this->ModuleNotAvailable();
        // }
        
    }
 
    public function Ajaxregistro() {
        $info=  $this->config_mdl->sqlGetDataCondition('os_triage',array(
            'triage_id'=>  $this->input->post('triage_id')
            ),'triage_crea_am,triage_consultorio_nombre,triage_nombre,triage_nombre_ap,triage_nombre_am')[0];

        $data=array(
            'asistentesmedicas_fecha'   => date('Y-m-d'),
            'asistentesmedicas_hora'    => date('H:i'), 
            'asistentesmedicas_hoja'    => $this->input->post('asistentesmedicas_hoja'),
            'asistentesmedicas_renglon' => $this->input->post('asistentesmedicas_renglon'),
            'asistentesmedicas_ss_in'   => $this->input->post('asistentesmedicas_ss_in'),
            'asistentesmedicas_ss_ie'   => $this->input->post('asistentesmedicas_ss_ie'),
            'asistentesmedicas_oc_hr'   => $this->input->post('asistentesmedicas_oc_hr'),
            'triage_id'=>  $this->input->post('triage_id')
        );
        $sql_check_am= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        /*---------- Si es registro nuevo --------------------*/
        if(empty($sql_check_am)){
          
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
            'pia_procedencia_hospital_num'=> $this->input->post('pia_procedencia_hospital_num'),
            'pum_nss_armado'              => $this->input->post('pum_nss_armado')
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
        if($info['triage_crea_am']!=''){
            unset($data_triage['triage_crea_am']);
        }
        $this->config_mdl->_update_data('os_triage',$data_triage,
                array('triage_id'=>  $this->input->post('triage_id'))
        );
     
        
        $this->config_mdl->_insert('doc_43021',array(
            'doc_fecha'     => date('Y-m-d'),
            'doc_hora'      => date('H:i:s'),
            'doc_turno'     => Modules::run('Config/ObtenerTurno'),
            'doc_destino'   => 'Hospitalización',
            'doc_tipo'      => 'Egreso',
            'empleado_id'   => $this->UMAE_USER,
            'triage_id'     => $this->input->post('triage_id')
        ));
        $this->AccesosUsuarios(array(
          'acceso_tipo'  => 'Asistente Médica',
          'triage_id'    => $this->input->post('triage_id'),
          'acceso_tarea' => 'Registro 43051',
          'areas_id'     => $asistentesmedicas_id));
        
        //Arreglo con los valores que se registraran en la tabla doc_43051

        $data_43051 = array(
          'cama_id'                 => $this->input->post('cama'),
          'area_id'                 => $this->input->post('area'),
          'tipo_ingreso'            => 'Urgente Admisión Continua',
          'estado_cama'             => 'Asignada',
          'estado_ingreso_med'      => 'Esperando',
          'fecha_registro'          => date('Y-m-d'),
          'hora_registro'           => date('H:i:s'),
          'fecha_ingreso'           => date('Y-m-d'),
          'hora_ingreso'            => date('H:i:s'),
          'fecha_asignacion'        => date('Y-m-d H:i'),
          'ingreso_servicio'        => $this->input->post('ingreso_servicio'),
          'ingreso_medico'          => $this->input->post('ingreso_medico'),
          'diagnostico_presuntivo'  => $this->input->post('diagnostico_presuntivo'),
          'motivo_internamiento'    => $this->input->post('motivo_internamiento'),    
          'id_empleado_registra'    => $this->UMAE_USER,
          'riesgo_infeccion'        => $this->input->post('riesgo_infeccion')
        );

         $sql43051=$this->config_mdl->sqlGetDataCondition('doc_43051',array(
            'triage_id'=> $this->input->post('triage_id')
        ));

        /*Si se encuentra almenos un resultado la informacion se modificara,
        de lo contrario insertara los datos*/
        //if(count($Id43051][0]['ac_id']) == 1){
        if(count($sql43051)==1) {
          //$this->config_mdl->_update_data("doc_43051",$dataInternamiento_43051,
          //array('ac_id' => $query[$Id43051][0]['ac_id'] ));
          unset($data_43051['tipo_ingreso']);
          unset($data_43051['fecha_registro']);  
          unset($data_43051['hora_registro']);
          unset($data_43051['fecha_ingreso']);  
          unset($data_43051['hora_ingreso']);
          unset($data_43051['estado_ingreso_med']);
          unset($data_43051['id_empleado_registra']);
         $this->config_mdl->_update_data('doc_43051', $data_43051,
            array('triage_id'=> $this->input->post('triage_id')));

         // $this->config_mdl->_update_data('os_camas',array(
         //        'cama_status'       => 'Ocupado',
         //        'cama_genero'       => $this->input->post('triage_paciente_sexo'),
         //        'cama_ingreso_f'    => date('d/m/Y'),
         //        'cama_ingreso_h'    => date('H:i'),
         //        'cama_fh_estatus'   => date('Y-m-d H:i:s'),
         //        'triage_id'=>       $this->input->post('triage_id')
         //    ),array(
         //        'cama_id'=>  $this->input->post('cama')
         //    ));
            
         //    Modules::run('Areas/LogCamas',array(
         //        'log_estatus'=>'Ocupado',
         //        'cama_id'=>$this->input->post('cama')
         //    ));
          $this->AccesosUsuarios(array(
              'acceso_tipo'  => 'Asistente Médica',
              'triage_id'    => $this->input->post('triage_id'),
              'acceso_tarea' => 'Actualiza 43051',
              'areas_id'     => $asistentesmedicas_id));
        }else{
          $data_43051 += ['triage_id' => $this->input->post('triage_id')];
          $this->config_mdl->_insert("doc_43051",$data_43051);

          /* soi no es derechohabiente asigna numero consecutivo par NSS */
          Modules::run('Admisionhospitalaria/GuardaNssConformado', 
            array('triage_id'  => $this->input->post('triage_id'), 
                  'numcon_nss' => $this->input->post('pum_nss_armado'),
                  'numcon_id'  => Modules::run('Admisionhospitalaria/NumeroConsecutivo')
          ));
          // $this->config_mdl->_update_data('os_camas',array(
          //       'cama_status'       => 'Ocupado',
          //       'cama_genero'       => $this->input->post('triage_paciente_sexo'),
          //       'cama_ingreso_f'    => date('d/m/Y'),
          //       'cama_ingreso_h'    => date('H:i'),
          //       'cama_fh_estatus'   => date('Y-m-d H:i:s'),
          //       'triage_id'=>       $this->input->post('triage_id')
          //   ),array(
          //       'cama_id'=>  $this->input->post('cama')
          //   ));
          //   Modules::run('Areas/LogCamas',array(
          //       'log_estatus'=>'Ocupado',
          //       'cama_id'=>$this->input->post('cama')
          //   ));
        }
        $this->setOutput(array('accion'=>'1'));     
    }
    /* Funcion que registra la salida de los pacientes en Triage Respiratorio que no requieren Hospitalizacion */
    public function Ajaxsalidapaciente() {
        $data=array(
            'triage_id'   => $this->input->post('triage_id'),
            'fecha'       => date('Y-m-d H:i')
        );
        $this->config_mdl->_update_data('os_triage',
          array('triage_crea_am' => $this->UMAE_USER),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_insert('os_triage_respiratorio_salida', $data);

        $this->setOutput(array('accion'=>'1'));
    }

    public function getMedicoEspecialista() {
         
        $medicos= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_servicio'=>$this->input->post('especialidad_id'),
            'empleado_jefe_servicio' => 1
        ));
       
        if(count($medicos)>0) {
            $select_box = '';
            $select_box .= '<option value="" disabled selected>Seleccionar Médico</option>';
            foreach ($medicos as $medico) {
                $select_box .= '<option value="'.$medico['empleado_id'].'">'.$medico['empleado_nombre'].' '.$medico['empleado_apellidos'].' ('.$medico['empleado_matricula'].')</option>';
                   }   echo json_encode($select_box);    
        } 
    }
    public function getMatriculaMedico() {
        $sql=$this->config_mdl->_get_data_condition('os_empleados', array(
            'empleado_id'=>$this->input->post('empleado_id')))[0];
         echo json_encode($sql['empleado_matricula']); 
    }

    public function getCama(){
        $Camas=$this->config_mdl->_get_data_condition('os_camas', array(
            'area_id'  => $this->input->post('area_id'),
            'cama_estado' => 'Disponible'
        ));
        if(count($Camas)>0) {
            $select_items = '';
            $select_items .= '<option value="" disabled selected>Seleccionar Cama</option>';
            foreach ($Camas as $cama) {
                $select_items .= '<option value="'.$cama['cama_id'].'">'.$cama['cama_nombre'].'</option>';
            } echo json_encode($select_items);
        }
    }
    
}