<?php
/**
 * Description of module Triage Respiratorio
 *
 * @author cr@fWARE
 */
include_once APPPATH.'modules/config/controllers/Config.php';

class Hospitalizacion extends Config{
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
        
        $sql['empleado']= $this->config_mdl->_get_data_condition('os_empleados',array(
           'empleado_id'=> $this->UMAE_USER
        ));
        $sql['DirPaciente']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'          => $Paciente,
            'directorio_tipo'   => 'Paciente'
        ))[0];
        
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        
        
        $sql['Especialidades'] = $this->config_mdl->_query("SELECT especialidad_id, especialidad_nombre FROM um_especialidades
                                                            WHERE especialidad_hospitalizacion=1 ORDER BY especialidad_nombre");

        $sql['Doc43051'] = $this->config_mdl->_get_data_condition("doc_43051",array(
          'triage_id'=> $Paciente
        ))[0];

        $sql['Medico']=  $this->config_mdl->_get_data_condition('os_empleados',array( 
            'empleado_servicio' => $sql['Doc43051']['ingreso_servicio'],
            'empleado_jefe_servicio' => 1
        ));

       $sql['Area'] = $this->config_mdl->_get_data_condition("os_areas", array(
            'area_modulo' => 'Pisos'));
        
        $sql['Cama'] =$this->config_mdl->_get_data_condition('os_camas', array(
            'area_id'     => $sql['Doc43051']['area_id']
            
        ));

        $sql['OrdenInternamiento'] = $this->config_mdl->_get_data_condition('um_orden_internamiento',array(
                'triage_id' => $Paciente
            ))[0];

        $sql['Diagnostico'] = $this->config_mdl->_get_data_condition('um_cie10',array(
                'cie10_id' => $sql['OrdenInternamiento']['diagnostico_id']
            ))[0];

        
        $this->load->view('Hospitalizacion/registro43051',$sql);
        
        
    }
 
    public function Ajaxregistro() {
        
        $info =  $this->config_mdl->sqlGetDataCondition('os_triage',array(
            'triage_id' =>  $this->input->post('triage_id')
            ),'triage_crea_am,triage_consultorio_nombre,triage_nombre,triage_nombre_ap,triage_nombre_am')[0];

        $area_acceso =  $this->config_mdl->sqlGetDataCondition('os_areas_acceso',array(
            'areas_acceso_nombre' => $this->input->post('area_nombre')) )[0];

        $check_43051 = $this->config_mdl->sqlGetDataCondition('doc_43051',array(
            'triage_id' => $this->input->post('triage_id')));


        $data_triage=array(
            'triage_nombre'         => $this->input->post('triage_nombre'), 
            'triage_nombre_ap'      => $this->input->post('triage_nombre_ap'), 
            'triage_nombre_am'      => $this->input->post('triage_nombre_am'), 
            'triage_paciente_sexo'  => $this->input->post('triage_paciente_sexo'),
            'triage_fecha_nac'      => $this->input->post('triage_fecha_nac'),
            'triage_paciente_curp'  => $this->input->post('triage_paciente_curp'),
        );

        $data_info= array(
            'pum_nss'                   =>$this->input->post('pum_nss'),
            'pum_nss_agregado'          =>$this->input->post('pum_nss_agregado'),
            'pum_nss_armado'            =>$this->input->post('pum_nss_armado'),
            'pum_umf'                   =>$this->input->post('pum_umf'),
            'pum_delegacion'            =>$this->input->post('pum_delegacion'),
            'pia_lugar_procedencia'     =>$this->input->post('pia_lugar_procedencia'),
            'pia_dia_pa'                =>$this->input->post('pia_dia_pa'),
            'pia_fecha_accidente'       =>$this->input->post('pia_fecha_accidente'),
            'pic_responsable_nombre'    =>$this->input->post('pic_responsable_nombre'),
            'pic_responsable_parentesco'=>$this->input->post('pic_responsable_parentesco'),
            'pic_responsable_telefono'  =>$this->input->post('pic_responsable_telefono'),
        );
        
        $data_43051 = array(
          'cama_id'                 => $this->input->post('cama'),
          'area_id'                 => $this->input->post('area'),
          'tipo_ingreso'            => 'Urgente',
          'estado_cama'             => 'Reservada',
          'estado_ingreso_med'      => 'Esperando',
          'fecha_registro'          => date('Y-m-d'),
          'hora_registro'           => date('H:i:s'),
          'fecha_ingreso'           => date('Y-m-d'),
          'hora_ingreso'            => date('H:i'),
          'fecha_asignacion'        => date('Y-m-d H:i'),
          'ingreso_servicio'        => $this->input->post('ingreso_servicio'),
          'ingreso_medico'          => $this->input->post('ingreso_medico'),
          'diagnostico_presuntivo'  => $this->input->post('dx_id'),
          'motivo_internamiento'    => $this->input->post('motivo_internamiento'),    
          'id_empleado_registra'    => $this->UMAE_USER,
          'empleado_asigna'         => $this->UMAE_USER,
          'riesgo_infeccion'        => $this->input->post('riesgo_infeccion'),
          'triage_id'               => $this->input->post('triage_id')
        );

        $os_triage_empresa = array(
            'empresa_nombre'   => $this->input->post('empresa_nombre'),
            'triage_id'        => $this->input->post('triage_id')
        );

        $os_triage_empresa_directorio = array(
            'directorio_tipo'       => 'Empresa',
            'directorio_cn'         => $this->input->post('empresa_cn'       ),
            'directorio_colonia'    => $this->input->post('empresa_colonia'  ),
            'directorio_municipio'  => $this->input->post('empresa_municipio'),
            'directorio_estado'     => $this->input->post('empresa_estado'   ),
            'directorio_telefono'   => $this->input->post('empresa_telefono' ),
            'triage_id'             => $this->input->post('triage_id')
        );

        /*---------- Si es registro nuevo --------------------*/
        if(empty($check_43051)){
            
            $this->config_mdl->_insert("doc_43051",$data_43051);
            $this->config_mdl->_insert('os_triage_directorio',$os_triage_empresa_directorio);
            $os_triage_empresa['directorio_id'] .= $this->config_mdl->_get_last_id('os_triage_directorio','directorio_id');
            $this->config_mdl->_insert('os_triage_empresa', $os_triage_empresa);
            
            $this->AccesosUsuarios(array(
              'acceso_tipo'  => 'Asistente Médica',
              'triage_id'    => $this->input->post('triage_id'),
              'acceso_tarea' => 'Registro 43051',
              'areas_id'     => $area_acceso['areas_acceso_id'] ));

            $this->config_mdl->_insert('doc_43021',array(
                'doc_fecha'     => date('Y-m-d'),
                'doc_hora'      => date('H:i:s'),
                'doc_turno'     => Modules::run('Config/ObtenerTurno'),
                'doc_destino'   => 'Hospitalización',
                'doc_tipo'      => 'Egreso',
                'empleado_id'   => $this->UMAE_USER,
                'triage_id'     => $this->input->post('triage_id')
            ));
        
        }else{
            unset($data_43051['tipo_ingreso']);
            unset($data_43051['fecha_registro']);  
            unset($data_43051['hora_registro']);
            //unset($data_43051['fecha_ingreso']);
            //unset($data_43051['hora_ingreso']);
            unset($data_43051['fecha_asisgnacion']);
            unset($data_43051['estado_ingreso_med']);
            //unset($data_43051['id_empleado_registra']);

            $this->config_mdl->_update_data('doc_43051', $data_43051, array('triage_id'=> $this->input->post('triage_id') ));
            $this->config_mdl->_update_data('os_triage_empresa',$os_triage_empresa,array('triage_id'=> $this->input->post('triage_id') ));
            $this->config_mdl->_update_data('os_triage_directorio', $os_triage_empresa_directorio, array('directorio_id'=> $os_triage_empresa['directorio_id']));
                        
        }
        $this->config_mdl->_update_data('os_triage',$data_triage,
            array('triage_id'=>  $this->input->post('triage_id')));

        $this->config_mdl->_update_data('paciente_info', $data_info,
            array('triage_id'  =>$this->input->post('triage_id')));

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

       
        $sql43051 = $this->config_mdl->sqlGetDataCondition('doc_43051',array('triage_id' => $this->input->post('triage_id')));

        if(count($sql43051)==1) {

            $this->config_mdl->_update_data('os_camas',array(
                'cama_estado'       => 'Reservada',
                'cama_genero'       => $this->input->post('triage_paciente_sexo'),
                'cama_ingreso_f'    => date('Y-m-d'),
                'cama_ingreso_h'    => date('H:i'),
                'cama_fh_estatus'   => date('Y-m-d H:i:s'),
                'triage_id'         => $this->input->post('triage_id')
            ),array(
                'cama_id'=>  $this->input->post('cama')
            ));
            
            Modules::run('Areas/LogCamas',array(
                'log_estatus'=>'Ocupado',
                'cama_id'=>$this->input->post('cama')
            ));
        }
        
        
        $this->setOutput(array('accion'=>'1'));     
    }

    public function getMedicoEspecialista() {
         
        $medicos= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_servicio'=>$this->input->post('especialidad_id'),
            'empleado_jefe_servicio' =>'Si'
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
            'area_id'     => $this->input->post('area_id'),
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
    
    public function AdmisionContinua(){
        
      $this->load->view('Hospitalizacion/Ingresos',$sql);
    
    }

    public function BuscarOrdenInternamiento() {
      $sqlFolio= $this->config_mdl->_get_data_condition('os_triage',array(
          'triage_id'=> $this->input->post('triage_id')
      ));

      $sqlOrdenInternamiento= $this->config_mdl->_get_data_condition('um_orden_internamiento',array(
          'triage_id'=> $this->input->post('triage_id')
      ));
      if(!empty($sqlOrdenInternamiento)){
          
          //$this->config_mdl->_insert('os_asistentesmedicas',array('triage_id'=> $this->input->post('triage_id')));
        $this->setOutput(array('accion'=>'1'));
      }else {
        $this->setOutput(array('accion'=>'2'));
      }
    }
}