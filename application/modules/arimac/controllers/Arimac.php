<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of AdmisionHospitalaria
 *
 * @author felipe de jesus <itifjpp@gmail.com/>
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Arimac extends Config{
    public function index(){
        $this->load->view('index');
    }
    public function AjaxBuscarPaciente(){
        $sqlPaciente=$this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$this->input->post('triage_id')
        ));
        if(!empty($sqlPaciente)){
            
            $this->setOutput(array('accion'=>'1','info'=>$sqlPaciente[0],'pum'=>$sqlPUM));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function Paciente($Paciente){
        $sql['info']=$this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['pum']=$this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['DirPaciente']=$this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Paciente',
            'triage_id'=>$Paciente
        ))[0];
        $sql['DirEmpresa']=$this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Empresa',
            'triage_id'=>$Paciente
        ))[0];
        $sql['Empresa']=$this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=>$Paciente
        ))[0];
        $this->load->view('paciente',$sql);
    }
    public function AjaxExpediente(){
        $this->config_mdl->_update_data('os_triage',array(
            'triage_nombre'=>  $this->input->post('triage_nombre'),
            'triage_nombre_ap'=>$this->input->post('triage_nombre_ap') ,
            'triage_nombre_am'=>$this->input->post('triage_nombre_am') ,
            'triage_paciente_curp'=> $this->input->post('triage_paciente_curp')
        ),array(
            'triage_id'=> $this->input->post('triage_id_val')
        ));
        $this->config_mdl->_update_data('paciente_info',array(
            'pum_nss'=>$this->input->post('pum_nss'),
            'pum_nss_agregado'=>$this->input->post('pum_nss_agregado'),
            'pum_umf'=>$this->input->post('pum_umf'),
            'pum_delegacion'=>$this->input->post('pum_delegacion')
        ),array(
            'triage_id'=> $this->input->post('triage_id_val')
        ));
        Modules::run('Triage/TriagePacienteDirectorio',array(
            'directorio_tipo'=>'Paciente',
            'directorio_cp'=> $this->input->post('directorio_cp'),
            'directorio_cn'=> $this->input->post('directorio_cn'),
            'directorio_colonia'=> $this->input->post('directorio_colonia'),
            'directorio_municipio'=> $this->input->post('directorio_municipio'),
            'directorio_estado'=> $this->input->post('directorio_estado'),
            'directorio_telefono'=> $this->input->post('directorio_telefono'),
            'triage_id'=>$this->input->post('triage_id_val')
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
                'triage_id'=>$this->input->post('triage_id_val')
            ));
            Modules::run('Triage/TriagePacienteEmpresa',array(
                'empresa_nombre'=> $this->input->post('empresa_nombre'),
                'empresa_modalidad'=> $this->input->post('empresa_modalidad'),
                'empresa_rp'=> $this->input->post('empresa_rp'),
                'empresa_fum'=> $this->input->post('empresa_fum'),
                'empresa_tel'=> $this->input->post('empresa_tel'),
                'empresa_he'=> $this->input->post('empresa_he'),
                'empresa_hs'=>$this->input->post('empresa_hs'),
                'triage_id'=> $this->input->post('triage_id_val')
            ));   
        }
        $this->setOutput(array('accion'=>'1'));
    }

    public function Expedientesasignados(){
        $this->load->view('Cabecera');
        $this->load->view('Expedientesasignados');

    }

    public function BuscarPacienteUmae(){

        $sqlPaciente=$this->config_mdl->_query("SELECT * FROM um_pacientes P 
                                                JOIN um_pacientes_contacto C ON P.idPaciente = C.id_paciente
                                                JOIN os_empleados E ON E.empleado_id = P.usuario_registra
                                                WHERE nss=".$this->input->post('nss'));
        if(!empty($sqlPaciente)){
            
            $this->setOutput(array('accion'=>'1','info'=>$sqlPaciente, 'registra'=>$usuario));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }

    public function Buscarexpediente() {
        $sqlFolio= $this->config_mdl->_get_data_condition('um_pacientes',array(
            'idPaciente' => $this->input->post('id_paciente')
        ));
        
        $sqlExpPrestado=$this->config_mdl->_get_data_condition('um_arimac_expedientes',array(
            'idpaciente' => $this->input->post('id_paciente'),
            'estado'     => 'prestado'
        ));
        $sqlEspecialidad = $this->config_mdl->sqlGetDataOrderBy('um_especialidades','*', 'especialidad_nombre', 'ASC');
        /*$sqlEspecialidad=$this->config_mdl->sqlGetDataCondition('um_especialidades',array(
            'especialidad_hospitalizacion' => 1
        ));*/
    
        $servicios.='<option value="0" disable>Selecciona</option>';
        foreach ($sqlEspecialidad as $value) {           
            $servicios.='<option value="'.$value['especialidad_id'].'">'.$value['especialidad_nombre'].'</option>';
        }
        /* si existe el número de expediente en la UMAE (idPaciente) */
        if(!empty($sqlFolio)){
            /* Si no esta ocupado el expediente pasa información para asignar expeddiente*/
            if(empty($sqlExpPrestado)){
                $this->setOutput(array('accion'    =>  '1', 
                                        'info'      => $sqlFolio[0],
                                        'servicios' => $servicios,
                                        ''));
            }else {
                /* Eñ expediente esta ocupado */
                $persona=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                    'empleado_id'=>$sqlExpPrestado[0]['idpersona']),'empleado_nombre, empleado_apellidos')[0];
    
                $servicio=$this->config_mdl->sqlGetDataCondition('um_especialidades',array(
                   'especialidad_id'=>$sqlExpPrestado[0]['idservicio']),'especialidad_nombre')[0];
    
                
                $info[] = array(
                    'folio'          => $sqlFolio[0]['idPaciente'],
                    'afiliacion'     => $sqlFolio[0]['nssCom'],
                    'nombre_paciente'=> $sqlFolio[0]['apellidop'].' '.$sqlFolio[0]['apellidom'].' '.$sqlFolio[0]['nombre'],
                    'servicio'       => $servicio['especialidad_nombre'],
                    'usuario'        => $persona['empleado_apellidos'].' '.$persona['empleado_nombre'],
                    'fecha_peticion' => $sqlExpPrestado[0]['fecha_solicitud'],
                    'idsolicitud'    => $sqlExpPrestado[0]['idsolicitud']  
                ); 
                $this->setOutput(array('accion'=>'2', 'info'=> $info[0]));
            }
            /* Si no existe el nss */
        }else   $this->setOutput(array('accion'=>'3'));
    }

    public function Altapaciente() {
        $sql['Especialidades'] = $this->config_mdl->_query("SELECT especialidad_id, especialidad_nombre FROM um_especialidades WHERE especialidad_hospitalizacion=1 ORDER BY especialidad_nombre");
        $sql['Especialidad'] = $this->config_mdl->_get_data_condition('um_especialidades',array(
            'especialidad_id'=> $sql['ordeninternamiento']['servicio_destino_id']
          ))[0];
        $sql['pinfo']=  $this->config_mdl->sqlGetDataCondition('um_pacientes',array('idPaciente'=>$noExpediente,))[0];
        $sql['empleado']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_id'=> $this->UMAE_USER
         ),'empleado_nombre,empleado_apellidos');
        $sql['servicioAtencion'] = $this->config_mdl->sqlGetDataCondition('um_pacientes_ingresos_arimac',array('id_paciente'=>$paciente,))[0];
        $this->load->view('Altas',$sql);
    }

    public function RegistroPacienteUmae() {
        //$nssCompleto = str_replace('-','',substr($data_paciente_info['nss_umae'],0,-1)).'-'.$data_paciente_info['nss_agregado'];
        $nssCompleto = $this->input->post('nss_umae').'-'.$this->input->post('nss_agregado');
        $data_um_pacientes = array(
            //'idPaciente'       => $this->input->post('idPaciente'),
            'nss'              => $this->input->post('nss_umae'),
            'agregado'         => $this->input->post('nss_agregado'),
            'nssCom'           => $nssCompleto,
            'umf'              => $this->input->post('umf'),
            'deleg'            => $this->input->post('delegacion'),
            'nombre'           => $this->input->post('nombre'),
            'apellidop'        => $this->input->post('nombre_ap'), 
            'apellidom'        => $this->input->post('nombre_am'),
            'fechaNac'         => $this->input->post('fechaNac'),
            'curp'             => $this->input->post('curp'),
            'sexo'             => $this->input->post('sexo'),
            'estado'           => 'v',
            'fechaReg'         => date('Y-m-d H:i'),
            'usuario_registra' => $this->UMAE_USER
        );
        $data_um_paciente_contacto = array(
            'calle_no'  => $this->input->post('calle_no'),
            'cp'        => $this->input->post('calle_no'),
            'colonia'   => $this->input->post('colonia'),
            'municipio' => $this->input->post('municio'),
            'estado'    => $this->input->post('estado'),
            'telefono'  => $this->input->post('telefono')
        );

        $data_ingreso_paciente = array(
            'id_especialidad' => $this->input->post('ingreso_servicio'),
            'id_medico'       => $this->input->post('ingreso_medico'),
            'id_user_arimac'  => $this->UMAE_USER,
            'fecha_registro'  => date('Y-m-d H:i'),
            'tipo_ingreso'    => $this->input->post('tipo_ingreso')
        );


        $sqlPaciente=$this->config_mdl->_get_data_condition('um_pacientes',array(
            'nssCom'=>$nssCompleto
        ));
        if(empty($sqlPaciente)){
            $this->config_mdl->_insert('um_pacientes',$data_um_pacientes);
            $idPaciente=$this->config_mdl->_get_last_id('um_pacientes','idPaciente');
            $data_ingreso_paciente['id_paciente'] = $idPaciente;
            $data_um_paciente_contacto['id_paciente'] = $idPaciente;
            $this->config_mdl->_insert('um_pacientes_ingresos_arimac',$data_ingreso_paciente);
            $this->config_mdl->_insert('um_pacientes_contacto',$data_um_paciente_contacto);

        }else{
            unset($data_um_pacientes['fechaReg']); 
            unset($data_um_pacientes['usuario_registra']); 
            $this->config_mdl->_update_data('um_pacientes',$data_um_pacientes,array(
                'nssCom'=>$sqlPaciente[0]['nssCom']));
        }
        $this->setOutput(array('accion'=>'1', 'folio'=> $idPaciente)); 
    }
    public function GetPersonas() {
        $personas= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_servicio'=>$this->input->post('id_servicio')
        ));
        if(count($personas)>0) {
            $select_box = '';
            $select_box .= '<option value="" disabled selected>Seleccionar</option>';
            foreach ($personas as $persona) {
                $select_box .= '<option value="'.$persona['empleado_id'].'">'.$persona['empleado_nombre'].' '.$persona['empleado_apellidos'].'</option>';
                   }   echo json_encode($select_box);    
        } 
    }
    public function GuardarExpedienteAsignado(){
        $sql=$this->config_mdl->_get_data_condition('um_arimac_expedientes',array(
            'idpaciente' => $this->input->post('idFolio'),
            'estado'     => 'prestado'
        ));
        $dataExp=array(
            'idservicio'        => $this->input->post('idServ'),
            'idpersona'         => $this->input->post('idPer'),
            'idpaciente'        => $this->input->post('idFolio'),
            'observacion'       => $this->input->post('obs'),
            'fecha_solicitud'   => date('d-m-Y'),
            'hora_registro'     => date('H:i:s'),
            'id_persona_entrega'=> $this->UMAE_USER
        );
        if(empty($sql)){
            $dataExp['estado'] .= 'prestado';
            $this->config_mdl->_insert('um_arimac_expedientes',$dataExp);
            $this->setOutput(array('accion' => '1'));
        }else {
            $persona=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                'empleado_id'=>$sql[0]['idpersona']),'empleado_nombre, empleado_apellidos')[0];

            $servicio=$this->config_mdl->sqlGetDataCondition('um_especialidades',array(
               'especialidad_id'=>$sql[0]['idservicio']),'especialidad_nombre')[0];

            $paciente=$this->config_mdl->_get_data_condition('um_pacientes', array(
               'idPaciente' => $sql[0]['idpaciente']))[0]; 
            
            $info[] = array(
                'folio'          => $sql[0]['idpaciente'],
                'afiliacion'     => $paciente['nssCom'],
                'nombre_paciente'=> $paciente['apellidop'].' '.$paciente['apellidom'].' '.$paciente['nombre'],
                'servicio'       => $servicio['especialidad_nombre'],
                'usuario'        => $persona['empleado_apellidos'].' '.$persona['empleado_nombre'],
                'fecha_peticion' => $sql[0]['fecha_solicitud']    
            ); 
            $this->setOutput(array('accion' => '2', 'info' => $info[0]));
        }
            
        
    }

    public function ListaControlExpedientes() {
        $fecha = $this->input->post('fecha');
        $fecha_registro = date('d-m-Y', strtotime($fecha));
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search= $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        $datos=array();
        
        $registros=$this->config_mdl->_get_data_condition('um_arimac_expedientes',array(
            'fecha_solicitud' => $fecha_registro
            
        ));
       
        if(!empty($registros)) {
            foreach ($registros  as $value) {
                $persona=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                     'empleado_id'=>$value['idpersona']),'empleado_nombre, empleado_apellidos')[0];

                $personaEntrega=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                    'empleado_id'=>$value['id_persona_entrega']),'empleado_nombre, empleado_apellidos')[0];
                
                $personaRecibe=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                    'empleado_id'=>$value['id_persona_recibe']),'empleado_nombre, empleado_apellidos')[0];

                $servicio=$this->config_mdl->sqlGetDataCondition('um_especialidades',array(
                    'especialidad_id'=>$value['idservicio']),'especialidad_nombre')[0];

                $paciente=$this->config_mdl->_get_data_condition('um_pacientes', array(
                    'idPaciente' => $value['idpaciente']))[0]; 
                
                if($value['estado']=='prestado'){
                    $accion = '<span style="color:#006699;font-size:16px">
                                 <i class="fa fa-check-square-o pointer" id="liberar" data-id="'.$value['idsolicitud'].'">&nbsp;Liberar</i>
                               </span>';
                    $estado = '<span style="color:#E60026;text-transform: uppercase"><b><i class="fa fa-hourglass-1"></i> &nbsp;'.$value['estado'].'</b></span><br>
                               <span style="color:#006699;"><i class="fa fa-calendar"></i> &nbsp;'.$value['fecha_solicitud'].' '.$value['hora_registro'].'<br>
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;('.$personaEntrega['empleado_nombre'].' '.$personaEntrega['empleado_apellidos'].')</span>';
                } else {
                    /* Expediente regresado */
                    $accion = '<span style="color:#00BB2D;">Expediente Disponible</span>';
                    $estado = '<span style="color:#00BB2D;text-transform: uppercase"><b><i class="fa fa-check-circle"></i> &nbsp;'.$value['estado'].'</b></span><br>
                               <span style="color:#006699;"><i class="fa fa-calendar"></i> &nbsp;'.$value['fecha_recibe'].' '.$value['hora_recibe'].'
                               <small>('.$personaRecibe['empleado_nombre'].' '.$personaRecibe['empleado_apellidos'].')</small></span><br>
                               <span style="color:#000000;"><i class="fa fa-calendar"></i> &nbsp;'.$value['fecha_solicitud'].' '.$value['hora_registro'].'</span>
                               <small>('.$personaEntrega['empleado_nombre'].' '.$personaEntrega['empleado_apellidos'].')</small>';
                }
                
                $datos[] = array(
                                'folio'          => $value['idpaciente'],
                                'afiliacion'     => $paciente['nssCom'],
                                'nombre_paciente'=> $paciente['apellidop'].' '.$paciente['apellidom'].' '.$paciente['nombre'],
                                'servicio'       => $servicio['especialidad_nombre'],
                                'usuario'        => $persona['empleado_apellidos'].' '.$persona['empleado_nombre'],
                                'estado'         => $estado,
                                'fecha_salida'   => 'El día'.' '. $value['fecha_solicitud'].' '.$value['hora_registro'],
                                'accion'         => $accion
                            ); 
            }
             //$this->setOutput(array('accion'=>'1','tr'=>$tr));
            $total_expedientes = count($registros);
        }

        $output = array(
                        'draw' => $draw,
                        "recordsTotal" => $total_expedientes,
                        "recordsFiltered" => $total_expedientes,
                        'data' => $datos
        );
        
        $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output)); 
    } 
    public function LiberarExpediente(){
        $sql=$this->config_mdl->_get_data_condition('um_arimac_expedientes',array(
            'idsolicitud' => $this->input->post('idsolicitud'),
            'estado'     => 'prestado'
        ));

        if(!empty($sql)){
            $this->config_mdl->_update_data('um_arimac_expedientes',array(
                'estado'           => 'recibido',
                'fecha_recibe'     => date('d-m-Y'),
                'hora_recibe'      => date('H:i:s'),
                'id_persona_recibe'=> $this->UMAE_USER
            ),array(
                'idsolicitud'=> $this->input->post('idsolicitud')
            ));
            $this->setOutput(array('accion'=>'1'));
        }



    }
}