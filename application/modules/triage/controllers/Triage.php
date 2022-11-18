<?php
/**
 * Description of Triage
 *
 * @author felipe de jesus | itifjpp@gmail.com
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Triage extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function Enfermeriatriage() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_accesos, os_empleados
                                                    WHERE
                                                    os_accesos.acceso_tipo='Triage Enfermería' AND
                                                    os_accesos.triage_id=os_triage.triage_id AND
                                                    os_accesos.empleado_id=os_empleados.empleado_id AND
                                                    os_empleados.empleado_id=$this->UMAE_USER ORDER BY os_accesos.acceso_id DESC LIMIT 10");
        if($this->ConfigEnfermeriaHC=='Si'){
            if($this->UMAE_AREA=='Enfermeria Triage Respiratorio'){
                $sqlr['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_accesos, os_empleados
                                                    WHERE
                                                    os_accesos.acceso_tipo='Triage Enfermería' AND
                                                    os_accesos.triage_id=os_triage.triage_id AND
                                                    os_accesos.empleado_id=os_empleados.empleado_id AND
                                                    os_triage.triage_via_registro ='Hora Cero TR' AND
                                                    os_empleados.empleado_id=$this->UMAE_USER ORDER BY os_accesos.acceso_id DESC LIMIT 10");
                $this->load->view('Enfermeriatrige/horacero_r', $sqlr);
            }else {
                $this->load->view('Enfermeriatrige/Horacero',$sql);
            }
        }else{  
            $this->load->view('Enfermeriatrige/index',$sql);
        }
    }
    public function Medicotriage() {
        
        if($this->UMAE_AREA=='Medico Triage Respiratorio') {
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_accesos, os_empleados
                                                    WHERE
                                                    os_accesos.acceso_tipo='Triage Médico' AND
                                                    os_accesos.triage_id=os_triage.triage_id AND
                                                    os_accesos.empleado_id=os_empleados.empleado_id AND
                                                    os_triage.triage_via_registro = 'Hora Cero TR' AND
                                                    os_empleados.empleado_id=$this->UMAE_USER ORDER BY os_accesos.acceso_id DESC LIMIT 10");
            $this->load->view('Medicotriage/index_r', $sql);
        } else {
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_accesos, os_empleados
                                                    WHERE
                                                    os_accesos.acceso_tipo='Triage Médico' AND
                                                    os_accesos.triage_id=os_triage.triage_id AND
                                                    os_accesos.empleado_id=os_empleados.empleado_id AND
                                                    os_triage.triage_via_registro = 'Hora Cero' AND
                                                    os_empleados.empleado_id=$this->UMAE_USER ORDER BY os_accesos.acceso_id DESC LIMIT 10");
            $this->load->view('Medicotriage/index',$sql);
        }
    }
    public function EtapaPaciente($paciente) {
        $sql=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $paciente
        ));
        if($this->UMAE_AREA=='Enfermeria Triage' || $this->UMAE_AREA=='Enfermeria Triage Respiratorio'){
            if(!empty($sql)){
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }
        }else{
            if($sql[0]['triage_fecha_clasifica']==''){
                if($sql[0]['triage_nombre']==''){
                    if($sql[0]['triage_via_registro']=='Choque'){
                        $this->setOutput(array('accion'=>'1'));   
                    }else{
                          $this->setOutput(array('accion'=>'3'));
                        }
                }else{
                    $this->setOutput(array('accion'=>'1'));
                }
            }else{
                $Medico= $this->config_mdl->_get_data_condition('os_empleados',array(
                    'empleado_id'=>$sql[0]['triage_crea_medico']
                ));
                $this->setOutput(array('accion'=>'2','info'=>$sql[0],'medico'=>$Medico[0]));
            }
        }
    }
    public function Paciente($paciente) {
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$paciente
        ))[0];
        $sql['SignosVitales']= $this->config_mdl->_get_data_condition('os_triage_signosvitales',array(
            'sv_tipo'=>'Triage',
            'triage_id'=>$paciente
        ))[0];
        $sql['PINFO']=$this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$paciente
        ))[0];
        
        if($this->UMAE_AREA=='Enfermeria Triage' || $_GET['via']=='Paciente'){
            $this->load->view('Enfermeriatrige/paciente',$sql);
        }else if($this->UMAE_AREA=='Enfermeria Triage Respiratorio'){
            $this->load->view('Enfermeriatrige/paciente_r',$sql);
        }else if($_GET['via']=='medicoTRHoraCero') {
                $this->load->view('Enfermeriatrige/paciente_r',$sql);
        }else if($this->UMAE_AREA=='Medico Triage Respiratorio') {
            $this->load->view('Medicotriage/paciente_r',$sql);
        }else{
            $this->load->view('Medicotriage/paciente',$sql);
        }     
    }
    /*Guardar datos*/
    public function EnfemeriatriageGuardar() {
        if($this->UMAE_AREA=='Enfermeria Triage Respiratorio' || $this->input->post('via')=='medicoTRHoraCero'){
            $via_registro = 'Hora Cero TR';
        }else {
            $via_registro = 'Hora Cero';
        }
        $data=array(
            'triage_via_registro'    => $via_registro,
            'triage_fecha'           => date('Y-m-d'),
            'triage_hora'            => date('H:i'),
            'triage_nombre'          => $this->input->post('triage_nombre'),
            'triage_nombre_ap'       => $this->input->post('triage_nombre_ap'),
            'triage_nombre_am'       => $this->input->post('triage_nombre_am'),
            'triage_paciente_sexo'   => $this->input->post('triage_paciente_sexo'),
            'triage_fecha_nac'       => $this->input->post('triage_fecha_nac'),
            'triage_codigo_atencion' => $this->input->post('triage_codigo_atencion'),
            'triage_motivoAtencion'  => $this->input->post('motivoAtencion'),
            'triage_crea_enfemeria'  => $this->UMAE_USER
        );
        $this->SignosVitales(array(
            'triage_id'     => $this->input->post('triage_id'),
            'sv_ta'         => $this->input->post('sv_ta'),
            'sv_temp'       => $this->input->post('sv_temp'),
            'sv_fc'         => $this->input->post('sv_fc'),
            'sv_fr'         => $this->input->post('sv_fr'),
            'sv_oximetria'  => $this->input->post('sv_oximetria'),
            'sv_talla'      => $this->input->post('sv_talla'),
            'sv_dextrostix' => $this->input->post('sv_dextrostix'),
            'sv_peso'       => $this->input->post('sv_peso')
        ));
        $info =  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $this->input->post('triage_id')
        ))[0];
        
        if($info['triage_fecha']!=''){
            unset($data['triage_fecha']);
            unset($data['triage_hora']);
            unset($data['triage_crea_enfemeria']);
        }else{
            $this->AccesosUsuarios(array('acceso_tipo'=>'Triage Enfermería','triage_id'=>$this->input->post('triage_id'),'areas_id'=> $this->input->post('triage_id')));
        }

        if($this->input->post('triage_paciente_afiliacion_bol') == 'No'){
                Modules::run('Admisionhospitalaria/GuardaNssConformado', array(
                    'triage_id'  => $this->input->post('triage_id'), 
                    'numcon_nss' => $this->input->post('pum_nss_armado'),
                    'numcon_id'  => Modules::run('Admisionhospitalaria/NumeroConsecutivo'),
                    'tiene_nss'  => $this->input->post('triage_paciente_afiliacion_bol')
                ));
        }
       
        $this->config_mdl->_update_data('paciente_info',array(
            'pic_indicio_embarazo'              => $this->input->post('pic_indicio_embarazo'),
            'pia_procedencia_espontanea'        => $this->input->post('pia_procedencia_espontanea'),
            'pia_procedencia_espontanea_lugar'  => $this->input->post('pia_procedencia_espontanea_lugar'),
            'pia_procedencia_hospital'          => $this->input->post('pia_procedencia_hospital'),
            'pia_procedencia_hospital_num'      => $this->input->post('pia_procedencia_hospital_num'),
            'pum_nss'                           => $this->input->post('pum_nss'),
            'pum_nss_agregado'                  => $this->input->post('pum_nss_agregado'),
            'pum_umf'                           => $this->input->post('pum_umf'),
            'pum_delegacion'                    => $this->input->post('pum_delegacion'),
            'pic_responsable_nombre'            => $this->input->post('pic_responsable_nombre'),
            'pic_responsable_parentesco'        => $this->input->post('pic_responsable_parentesco'),
            'pic_responsable_telefono'          => $this->input->post('pic_responsable_telefono'),
            'pum_nss_armado'                    => $this->input->post('pum_nss_armado')
        ),array(
            'triage_id'=>$this->input->post('triage_id')
        ));
        Modules::run('Triage/LogChangesPatient',array(
            'paciente_old'=>$info['triage_nombre'].' '.$info['triage_nombre_ap'].' '.$info['triage_nombre_am'],
            'paciente_new'=> $this->input->post('triage_nombre').' '.$this->input->post('triage_nombre_ap').' '.$this->input->post('triage_nombre_am'),
            'nss_old'=>'NO APLICA',
            'nss_new'=>'NO APLICA',
            'triage_id'=>$this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_triage',$data,array('triage_id'=>  $this->input->post('triage_id')));

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
        

        
        $this->setOutput(array('accion'=>'1'));
    }

    public function AjaxCalcularEdad() {
        $this->setOutput(array(
            'Anio'=> $this->CalcularEdad_($this->input->post('triage_fecha_nac'))->y,
            'Mes'=> $this->CalcularEdad_($this->input->post('triage_fecha_nac'))->m,
            'Dia'=> $this->CalcularEdad_($this->input->post('triage_fecha_nac'))->d,
        ));
    }
    public function GuardarClasificacion() {


        if($this->input->post('viaRegistroPaciente') == 'Hora Cero TR'){

            $puntosCriteriosMayores = $this->input->post('fiebre')+
                                      $this->input->post('tos')+
                                      $this->input->post('cefalea');
            $puntosSintomas         = $this->input->post('conjuntivitis')+
                                      $this->input->post('rinorrea')+
                                      $this->input->post('prurito_nasal')+
                                      $this->input->post('estornudos')+
                                      $this->input->post('anosmia')+
                                      $this->input->post('dolor-garganta')+
                                      $this->input->post('disgeusia')+
                                      $this->input->post('cansancio')+
                                      $this->input->post('mialgia')+
                                      $this->input->post('artragias')+
                                      $this->input->post('dolor-torax')+
                                      $this->input->post('diarrea');
            $puntosFactoresRiesgo   = $this->input->post('disnea')+
                                      $this->input->post('edad65')+
                                      $this->input->post('sp02')+
                                      $this->input->post('obesidad');
            $puntosComorbilidades   = $this->input->post('epoc')+
                                      $this->input->post('diabetes')+ 
                                      $this->input->post('hipertension')+
                                      $this->input->post('cardiopatia')+
                                      $this->input->post('nefropata')+
                                      $this->input->post('inmunodef')+
                                      $this->input->post('hepatopatia');

        

            if ($puntosCriteriosMayores <= 6 && $puntosSintomas <= 12 && $puntosFactoresRiesgo == 0 && $puntosComorbilidades == 0){
                $totalPuntosTR = $puntosCriteriosMayores + $puntosSintomas;
                $color='#4CBB17';
                $color_name='Verde';
            
            }if(($puntosCriteriosMayores <= 6 && $puntosSintomas <= 12 && $puntosFactoresRiesgo==3) || ($puntosCriteriosMayores <= 6 && $puntosSintomas <= 11 && $puntosComorbilidades == 3)){
                $totalPuntosTR = $puntosCriteriosMayores + $puntosSintomas + $puntosFactoresRiesgo + $puntosComorbilidades;
                $color='#FDE910';
                $color_name='Amarillo';
            
            }if($puntosCriteriosMayores <= 6 && $puntosSintomas <= 12 && $puntosFactoresRiesgo==0 && $puntosComorbilidades >= 3){
                $totalPuntosTR = $puntosCriteriosMayores + $puntosSintomas + $puntosFactoresRiesgo + $puntosComorbilidades;
                $color='#FDE910';
                $color_name='Amarillo';
            
            }if($puntosCriteriosMayores <= 6 && $puntosSintomas <= 12 && $puntosFactoresRiesgo >= 3 && $puntosComorbilidades >=3){
                $totalPuntosTR = $puntosCriteriosMayores + $puntosSintomas + $puntosFactoresRiesgo + $puntosComorbilidades;
                $color='#E50914';
                $color_name='Rojo';
            
            }if($puntosCriteriosMayores <= 6 && $puntosSintomas <= 12 && $puntosFactoresRiesgo >= 3){
                $totalPuntosTR = $puntosCriteriosMayores + $puntosSintomas + $puntosFactoresRiesgo + $puntosComorbilidades;
                $color='#E50914';
                $color_name='Rojo';
            
            }
            
            foreach ($this->input->post('trat') as $trat_select) {
                $tratamiento.= $trat_select.',';
            }
       
            $this->config_mdl->_insert('os_triage_clasificacion_resp',array(
                'triage_id'         => $this->input->post('triage_id'),
                'fiebre'            => $this->input->post('fiebre'),
                'tos'               => $this->input->post('tos'),
                'cefalea'           => $this->input->post('cefalea'),
                'conjuntivitis'     => $this->input->post('conjuntivitis'),
                'rinorrea'          => $this->input->post('rinorrea'),
                'prurito_nasal'     => $this->input->post('prurito_nasal'),
                'estornudos'        => $this->input->post('estornudos'),
                'anosmia'           => $this->input->post('anosmia'),
                'dolor_garganta'    => $this->input->post('dolor-garganta'),
                'disgeusia'         => $this->input->post('disgeusia'),
                'cansancio'         => $this->input->post('cansancio'),
                'mialgia'           => $this->input->post('mialgia'),
                'artragias'         => $this->input->post('artragias'),
                'dolor_torax'       => $this->input->post('dolor-torax'),
                'diarrea'           => $this->input->post('diarrea'),
                'disnea'            => $this->input->post('disnea'),
                'edad'              => $this->input->post('edad65'),
                'oximetria'         => $this->input->post('spO2'),
                'obesidad'          => $this->input->post('obesidad'),
                'glasgow'           => $this->input->post('glasgow'),
                'epoc'              => $this->input->post('epoc'),
                'diabetes'          => $this->input->post('diabetes'),
                'hipertension'      => $this->input->post('hipertension'),
                'cardiopatia'       => $this->input->post('cardiopatia'),
                'nefropata'         => $this->input->post('nefropata'),
                'inmunodef'         => $this->input->post('inmunodef'),
                'hepatopatia'       => $this->input->post('hepatopatia'),
                'totalCM'           => $puntosCriteriosMayores,
                'totalSintomas'     => $puntosSintomas,
                'totalFR'           => $puntosFactoresRiesgo,
                'totalComorb'       => $puntosComorbilidades,
                'tratamiento'       => trim($tratamiento, ','),
                'observaciones'     => $this->input->post('observaciones'),
                'dx_presuntivo'     => $this->input->post('ac_diagnostico'),
                'qsofa'             => $this->input->post('qsofa'),
                'test_qcovid'       => $this->input->post('test_qcovid'),
                'paciente_imss'     => $this->input->post('paciente_imss'),
                'inicio_sintomas'   => $this->input->post('inicio_sintomas'),
                'entrega_kit'       => $this->input->post('entrega_kit'),
                'fecha_infeccion'   => $this->input->post('fechaInfeccionPrevia'),
                'fecha_vacuna'      => $this->input->post('fechaAplicacionVacuna'),
                'laboratorio'       => $this->input->post('vacunaLaboratorio'),
                'puesto_empleado'   => $this->input->post('paciente_imss_puesto')
            ));
        }else { //Area Triage Normal

            $triege_preg_puntaje_s1=$this->input->post('triage_preg1_s1')+
                                    $this->input->post('triage_preg2_s1')+
                                    $this->input->post('triage_preg3_s1')+
                                    $this->input->post('triage_preg4_s1')+
                                    $this->input->post('triage_preg5_s1');
            $triege_preg_puntaje_s2=$this->input->post('triage_preg1_s2')+
                                    $this->input->post('triage_preg2_s2')+
                                    $this->input->post('triage_preg3_s2')+
                                    $this->input->post('triage_preg4_s2')+
                                    $this->input->post('triage_preg5_s2')+
                                    $this->input->post('triage_preg6_s2')+
                                    $this->input->post('triage_preg7_s2')+
                                    $this->input->post('triage_preg8_s2')+
                                    $this->input->post('triage_preg9_s2')+
                                    $this->input->post('triage_preg10_s2')+
                                    $this->input->post('triage_preg11_s2')+
                                    $this->input->post('triage_preg12_s2');
            $triege_preg_puntaje_s3=$this->input->post('triage_preg1_s3')+
                                    $this->input->post('triage_preg2_s3')+
                                    $this->input->post('triage_preg3_s3')+
                                    $this->input->post('triage_preg4_s3')+
                                    $this->input->post('triage_preg5_s3');
            $total_puntos=$triege_preg_puntaje_s1+$triege_preg_puntaje_s2+$triege_preg_puntaje_s3;
            if($total_puntos>30){
                $color='#E50914';
                $color_name='Rojo';
            }if($total_puntos>=21 && $total_puntos<=30){
                $color='#FF7028';
                $color_name='Naranja';
            }if($total_puntos>=11 && $total_puntos<=20){
                $color='#FDE910';
                $color_name='Amarillo';
            }if($total_puntos>=6 && $total_puntos<=10){
                $color='#4CBB17';
                $color_name='Verde';
            }if($total_puntos<=5){
                $color='#0000FF';
                $color_name='Azul';
            }
            if($this->input->post('inputOmitirClasificacion')=='Si'){
                $color_name= $this->input->post('clasificacionColor');
            }
            if($this->input->post('viaRegistroPaciente')=='Choque'){
                $color_name='Rojo';
            }
            
            $data_clasificacion=array(
                'triage_preg1_s1'           =>  $this->input->post('triage_preg1_s1'),
                'triage_preg2_s1'           =>  $this->input->post('triage_preg2_s1'),
                'triage_preg3_s1'           =>  $this->input->post('triage_preg3_s1'),
                'triage_preg4_s1'           =>  $this->input->post('triage_preg4_s1'),
                'triage_preg5_s1'           =>  $this->input->post('triage_preg5_s1'),
                'triege_preg_puntaje_s1'    =>  $triege_preg_puntaje_s1,
                'triage_preg1_s2'           =>  $this->input->post('triage_preg1_s2'),
                'triage_preg2_s2'           =>  $this->input->post('triage_preg2_s2'),
                'triage_preg3_s2'           =>  $this->input->post('triage_preg3_s2'),
                'triage_preg4_s2'           =>  $this->input->post('triage_preg4_s2'),
                'triage_preg5_s2'           =>  $this->input->post('triage_preg5_s2'),
                'triage_preg6_s2'           =>  $this->input->post('triage_preg6_s2'),
                'triage_preg7_s2'           =>  $this->input->post('triage_preg7_s2'),
                'triage_preg8_s2'           =>  $this->input->post('triage_preg8_s2'),
                'triage_preg9_s2'           =>  $this->input->post('triage_preg9_s2'),
                'triage_preg10_s2'          =>  $this->input->post('triage_preg10_s2'),
                'triage_preg11_s2'          =>  $this->input->post('triage_preg11_s2'),
                'triage_preg12_s2'          =>  $this->input->post('triage_preg12_s2'),
                'triege_preg_puntaje_s2'    =>  $triege_preg_puntaje_s2,
                'triage_preg1_s3'           =>  $this->input->post('triage_preg1_s3'),
                'triage_preg2_s3'           =>  $this->input->post('triage_preg2_s3'),
                'triage_preg3_s3'           =>  $this->input->post('triage_preg3_s3'),
                'triage_preg4_s3'           =>  $this->input->post('triage_preg4_s3'),
                'triage_preg5_s3'           =>  $this->input->post('triage_preg5_s3'),
                'triege_preg_puntaje_s3'    =>  $triege_preg_puntaje_s3,
                'triage_puntaje_total'      =>  $total_puntos,
                'triage_color'              =>  $color_name,
                'triage_observacion'        =>  $this->input->post('clasificacionObservacion'),
                'triage_qsofa'              =>  $this->input->post('qsofa'),
                'triage_id'                 =>  $this->input->post('triage_id')
            );
            $this->config_mdl->_insert('os_triage_clasificacion',$data_clasificacion);

        }
        $data=array(
                'triage_fecha_clasifica'    =>  date('Y-m-d'),
                'triage_hora_clasifica'     =>  date('H:i'),
                'triage_color'              =>  $color_name,
                'triage_consultorio'        =>  $this->input->post('triage_consultorio'),
                'triage_consultorio_nombre' =>  $this->input->post('triage_consultorio_nombre'),
                'triage_envio_otraunidad'   =>  $this->input->post('envio_otraunidad'),
                'triage_crea_medico'        =>  $this->UMAE_USER,
                'triage_envio_nombre'       =>  $this->input->post('select_envio')
            );

        $this->AccesosUsuarios(array(
            'acceso_tipo'  =>  'Triage Médico',
            'triage_id'    =>  $this->input->post('triage_id'),
            'areas_id'     =>  $this->input->post('triage_id')
        ));

        $this->config_mdl->_update_data('os_triage',$data,array('triage_id' => $this->input->post('triage_id') ));
        
        $this->setOutput(array('accion'=>'1','triage_id' => $this->input->post('triage_id') ));

    }
    public function Indicador() {
        if($this->UMAE_AREA=='Enfermeria Triage'){
            $this->load->view('Enfermeriatrige/indicador');
        }else{
            $this->load->view('Medicotriage/indicador');
        }
    }
    public function AjaxIndicadorMedico() {
        $by_fecha_inicio= $this->input->post('inputFecha');
        $selectTurno = $this->input->post('Turno');

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

         if($this->UMAE_AREA=='Enfermeria Triage'){
            $ConditionCre='triage_crea_enfemeria';
            $ConditionFecha='triage_fecha';
            $ConditionHora='triage_hora';
        }else{
            $ConditionCre='triage_crea_medico';
            $ConditionFecha='triage_fecha_clasifica';
            $ConditionHora='triage_hora_clasifica';
        }
        if ($selectTurno == 'Noche') {
            
            $TOTAL_CAP1 = count($this->config_mdl->_query("SELECT * FROM os_triage WHERE os_triage.$ConditionCre=$this->UMAE_USER AND
                    os_triage.$ConditionFecha='$by_fecha_inicio' AND
                    os_triage.$ConditionFecha!='' AND
                    os_triage.$ConditionHora BETWEEN '$horaInicial_A' AND '$horaFinal_A'

                    "));
            $fechaNocheB = strtotime('+1 day', strtotime($by_fecha_inicio)); 
            $fechaNocheB = date('Y-m-d', $fechaNocheB);
            
            $TOTAL_CAP2 = count($this->config_mdl->_query("SELECT * FROM os_triage WHERE os_triage.$ConditionCre=$this->UMAE_USER AND
                    os_triage.$ConditionFecha='$fechaNocheB' AND
                    os_triage.$ConditionFecha!='' AND
                    os_triage.$ConditionHora BETWEEN '$horaInicial_B' AND '$horaFinal_B'
                    "));

            $TOTAL_CAP = $TOTAL_CAP1 + $TOTAL_CAP2;
        
        }else {
                $TOTAL_CAP= count($this->config_mdl->_query("SELECT * FROM os_triage WHERE os_triage.$ConditionCre=$this->UMAE_USER AND
                    os_triage.$ConditionFecha='$by_fecha_inicio' AND
                    os_triage.$ConditionFecha!='' AND
                    os_triage.$ConditionHora BETWEEN '$horaInicial' AND '$horaFinal'

                    "));
        }
        $this->setOutput(array(
            'TOTAL_INFO_CAP'=>$TOTAL_CAP
        ));
    }
    public function TriagePacienteDirectorio($data) {
        $sql= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'triage_id'=>$data['triage_id'],
            'directorio_tipo'=>$data['directorio_tipo']
        ));
        $datos=array(
            'directorio_cp'=> $data['directorio_cp'],
            'directorio_cn'=> $data['directorio_cn'],
            'directorio_colonia'=> $data['directorio_colonia'],
            'directorio_municipio'=> $data['directorio_municipio'],
            'directorio_estado'=> $data['directorio_estado'],
            'directorio_telefono'=> $data['directorio_telefono'],
            'directorio_tipo'=>$data['directorio_tipo'],
            'triage_id'=>$data['triage_id']
        );
        if(empty($sql)){
            $this->config_mdl->_insert('os_triage_directorio',$datos);
        }else{
            $this->config_mdl->_update_data('os_triage_directorio',$datos,array(
                'triage_id'=>$data['triage_id'],
                'directorio_tipo'=>$data['directorio_tipo']
            ));
        }
    }
    public function TriagePacienteEmpresa($data) {
        $sql= $this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=>$data['triage_id']
        ));
        $datos=array(
            'empresa_nombre'=> $data['empresa_nombre'],
            'empresa_modalidad'=> $data['empresa_modalidad'],
            'empresa_rp'=> $data['empresa_rp'],
            'empresa_fum'=> $data['empresa_fum'],
            'empresa_he'=> $data['empresa_he'],
            'empresa_hs'=>$data['empresa_hs'],
            'triage_id'=>$data['triage_id']
        );
        if(empty($sql)){
            $this->config_mdl->_insert('os_triage_empresa',$datos);
        }else{
            $this->config_mdl->_update_data('os_triage_empresa',$datos,array(
                'triage_id'=>$data['triage_id']
            ));
        }
    }
    public function SignosVitales($data) {
        // <editor-fold defaultstate="collapsed" desc="Signos Vitales">
        $sqlSv= $this->config_mdl->_get_data_condition('os_triage_signosvitales',array(
            'sv_tipo'=>'Triage',
            'triage_id'=>$data['triage_id']
        ));
        $svData=array(
            'empleado_id'   => $this->UMAE_USER,
            'sv_tipo'       => 'Triage',
            'sv_fecha'      => date('Y-m-d'),
            'sv_hora'       => date('H:i'),
            'sv_ta'         => $data['sv_ta'],
            'sv_temp'       => $data['sv_temp'],
            'sv_fc'         => $data['sv_fc'],
            'sv_fr'         => $data['sv_fr'],
            'sv_oximetria'  => $data['sv_oximetria'],
            'sv_talla'      => $data['sv_talla'],
            'sv_dextrostix' => $data['sv_dextrostix'],
            'triage_id'     => $data['triage_id'],
            'sv_peso'       => $data['sv_peso']
            
        );
        if(empty($sqlSv)){
            $this->config_mdl->_insert('os_triage_signosvitales',$svData);
        }else{
            $this->config_mdl->_update_data('os_triage_signosvitales',$svData,array(
                'sv_tipo'=>'Triage',
                'triage_id'=>$data['triage_id']
            ));
        }
        // </editor-fold>
    }
    public function LogChangesPatient($data) {
        // <editor-fold defaultstate="collapsed" desc="Registro de Cambios">
        $dataPaciente=array(
            'log_fecha'=> date('Y-m-d H:i:s'),
            'log_nombre_paciente'=>$data['paciente_old'].'->'.$data['paciente_new'],
            'log_nss'=>$data['nss_old'].'->'.$data['nss_new'],
            'log_area'=> $this->UMAE_AREA,
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=> $data['triage_id']
        );
        if($data['paciente_old']!=$data['paciente_new']){
            $this->config_mdl->_insert('um_pacientes_log',$dataPaciente);
        }
        if($data['nss_old']!=$data['nss_new']){
            $this->config_mdl->_insert('um_pacientes_log',$dataPaciente);
        }
        // </editor-fold>
    }
    public function AjaxObtenerEdad() {
        $fecha= $this->CalcularEdad_($this->input->post('fechaNac'));
        $this->setOutput(array(
            'Anios'=>$fecha->y
        ));
    }
}