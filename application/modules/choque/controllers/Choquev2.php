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
class Choquev2 extends Config{
    //construct
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->view('choquev2/choque_index');
    }
    public function Medico() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_choque_v2, os_triage_po WHERE 
            os_triage.triage_id=os_triage_po.triage_id AND
            os_triage.triage_id=os_choque_v2.triage_id AND 
            os_choque_v2.choque_status='Ingreso' AND
            os_choque_v2.medico_id is null AND
            os_triage.triage_via_registro='Choque' ORDER BY os_choque_v2.choque_id DESC");
         // if(MOD_CHOQUE=='Si'){
            $this->load->view('choquev2/choque_medico',$sql);
        // }else{
        //     $this->ModuleNotAvailable();
        // }
        
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
            'choque_ac_f'=> date('d-m-Y'),
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
            'cama_ingreso_f'=> date('d-m-Y'),
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
            os_choque_v2.cama_id is NULL AND            
            os_triage.triage_via_registro='Choque' ORDER BY os_choque_v2.choque_id DESC");
        // if(MOD_CHOQUE=='Si'){
            $this->load->view('choquev2/choque_enfermeria',$sql);
        // }else{
        //     $this->ModuleNotAvailable();
        //}
        
    }
    public function EnfermeriaCamas() {
        $this->load->view('choquev2/choque_enfermeria_camas');
    }
    public function InformacionCama($data) {
        $sql= $this->config_mdl->_get_data_condition('os_camas',array(
            'cama_id'=> $data['cama_id']
        ));
        return $sql[0]['cama_nombre'];
    }
    public function VisorCamas() {
        $this->load->view('choquev2/choque_visorcamas');
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
        $this->config_mdl->_update_data('os_choque_v2',array(
            'choque_alta'=>  $this->input->post('choque_alta')
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_insert('doc_43021',array(
            'doc_fecha'=> date('Y-m-d'),
            'doc_hora'=> date('H:i:s'),
            'doc_turno'=>Modules::run('Config/ObtenerTurno'),
            'doc_destino'=> $this->input->post('choque_alta'),
            'doc_tipo'=>'Egreso',
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_choque_v2',array(
            'choque_salida_f'=> date('d-m-Y'),
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
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage_signosvitales, os_empleados
                WHERE os_triage_signosvitales.empleado_id=os_empleados.empleado_id AND
                os_triage_signosvitales.sv_tipo='Choque' AND
                os_triage_signosvitales.triage_id='.$Paciente.'");
        $this->load->view('choquev2/choque_signosvitales',$sql);
    }
    public function AjaxSignosVitales() {
        $data_sv=array(
            'sv_tipo'=>'Choque',
            'sv_ta'=> $this->input->post('sv_ta'),
            'sv_temp'=> $this->input->post('sv_temp'),
            'sv_fc'=> $this->input->post('sv_fc'),
            'sv_fr'=> $this->input->post('sv_fr'),
            'sv_fecha'=> date('Y-m-d'),
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
            'triage_status'=>'En Captura',
            'triage_etapa'=>'0',
            'triage_horacero_h'=>  date('H:i'),
            'triage_horacero_f'=>  date('d-m-Y'),
            'triage_crea_horacero'=>$_SESSION['UMAE_USER']
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
    public function AjaxPosibleDonador() {
        $this->config_mdl->_update_data('os_triage_po',array(
            'po_donador'=> $this->input->post('po_donador'),
            'po_criterio'=> $this->input->post('po_criterio')
        ),array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function RegistrosEnfermeria() {
        $this->load->view('Choquev2/RegistrosEnfermeria');
    }
    public function AjaxAltaNoEspecificado(){
        $this->config_mdl->_update_data('os_choque_v2',array(
            'choque_status'=>'Salida',
            'choque_alta'=>'Alta No Especificado',
            'choque_salida_f'=>date('d-m-Y'),
            'choque_salida_h'=>date('H:i')
        ),array(
            'triage_id'=>$this->input->post('triage_id')
        )); 
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxVerificaMatricula() {
        $sql= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(!empty($sql)){
            $info= $this->config_mdl->_get_data_condition('os_triage',array(
                'triage_id'=> $this->input->post('triage_id')
            ))[0];
            $pinfo= $this->config_mdl->_get_data_condition('paciente_info',array(
                'triage_id'=> $this->input->post('triage_id')
            ))[0];
            $this->setOutput(array('accion'=>'1','info'=>$info,'pinfo'=>$pinfo));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
}
