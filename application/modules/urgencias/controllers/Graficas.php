<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Graficas
 *
 * @author felipe de jesus
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Graficas extends Config{
    //put your code here
    public function index() {
        $this->load->view('graficas/indexV2');
    }
    public function v2() {
        $this->load->view('graficas/indexV2');
    }
    /*INDICADOR URGENCIAS V2*/
    public function Indicador($Tipo) {
        if($Tipo=='Triage'){
            $this->load->view('graficas/IndicadorTriage');
        }else if($Tipo=='TriageRespiratorio'){
            $this->load->view('graficas/IndicadorTriageRespiratorio');
        }else if($Tipo=='Consultorios'){
            $this->load->view('graficas/IndicadorConsultorios');
        }else if($Tipo=='Consultorios'){
            $this->load->view('graficas/IndicadorConsultorios');
        }else if($Tipo=='Observacion'){
            $this->load->view('graficas/IndicadorObservacion');
        }else if($Tipo=='Choque'){
            echo 'NO DISPONIBLE';
        }else if($Tipo=='Interconsultas'){
            $sql['Especialidad'] = $this->config_mdl->_query("SELECT especialidad_id, especialidad_nombre, especialidad_interconsulta  FROM um_especialidades 
            WHERE especialidad_interconsulta = 1");
            $this->load->view('graficas/IndicadorInterconsultas', $sql);         
        }
        

    }
    public function AjaxIndicador() {
        if($this->input->post('productividad_tipo')=='Triage'){
            $TRIAGE_HORACERO= count(Modules::run('Urgencias/Graficasfunctions/LogTotalTickets',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno')
            )));
            $TRIAGE_ENFERMERIA=  count(Modules::run('Urgencias/Graficasfunctions/LogEnfermeriaTriage',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=>$this->input->post('productividad_turno')
            )));
            $TRIAGE_MEDICO=  count(Modules::run('Urgencias/Graficasfunctions/LogMedicoTriage',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=>$this->input->post('productividad_turno')
            )));
            $TRIAGE_AM=  count(Modules::run('Urgencias/Graficasfunctions/LogAsistentesMedicas',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=>$this->input->post('productividad_turno')
            )));
            $this->setOutput(array(
                'TRIAGE_HORACERO'=>$TRIAGE_HORACERO,
                'TRIAGE_ENFERMERIA'=>$TRIAGE_ENFERMERIA,
                'TRIAGE_MEDICO'=>$TRIAGE_MEDICO,
                'TRIAGE_AM'=>$TRIAGE_AM
            ));
        }else if($this->input->post('productividad_tipo')=='Consultorios'){
            $CONSULTORIO_F1= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Filtro 1'
            )));
            $CONSULTORIO_F2= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Filtro 2'
            )));
            $CONSULTORIO_F3= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Filtro 3'
            )));
            $CONSULTORIO_F4= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Filtro 4'
            )));
            $CONSULTORIO_F5= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Filtro 5'
            )));
            $CONSULTORIO_F6= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Filtro 6'
            )));
            $CONSULTORIO_F7= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Filtro 7'
            )));
            $CONSULTORIO_F8= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Filtro 8'
            )));
            $CONSULTORIO_F9= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Filtro 9'
            )));
            $CONSULTORIO_F10= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Filtro 10'
            )));
            $CONSULTORIO_N= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Neurocirugía'
            )));
            $CONSULTORIO_CG= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Cirugía General'
            )));
            $CONSULTORIO_M= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Maxilofacial'
            )));
            $CONSULTORIO_CM= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio Cirugía Maxilofacial'
            )));
            $CONSULTORIO_CPR= count(Modules::run('Urgencias/Graficasfunctions/IndicadorConsultorios',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'consultorio'=>'Consultorio CPR'
            )));
            $this->setOutput(array(
                'CONSULTORIO_F1'=>$CONSULTORIO_F1,
                'CONSULTORIO_F2'=>$CONSULTORIO_F2,
                'CONSULTORIO_F3'=>$CONSULTORIO_F3,
                'CONSULTORIO_F4'=>$CONSULTORIO_F4,
                'CONSULTORIO_F5'=>$CONSULTORIO_F5,
                'CONSULTORIO_F6'=>$CONSULTORIO_F6,
                'CONSULTORIO_F7'=>$CONSULTORIO_F7,
                'CONSULTORIO_F8'=>$CONSULTORIO_F8,
                'CONSULTORIO_F9'=>$CONSULTORIO_F9,
                'CONSULTORIO_F10'=>$CONSULTORIO_F10,
                'CONSULTORIO_N'=>$CONSULTORIO_N,
                'CONSULTORIO_CG'=>$CONSULTORIO_CG,
                'CONSULTORIO_M'=>$CONSULTORIO_M,
                'CONSULTORIO_CM'=>$CONSULTORIO_CM,
                'CONSULTORIO_CPR'=>$CONSULTORIO_CPR
            ));
        }else if($this->input->post('productividad_tipo')=='Observacion'){
            $OBSERVACION_ENFERMERIA= count(Modules::run('Urgencias/Graficasfunctions/IndicadorObservacion',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'tipo'=>'Ingreso Enfermería Observación'
            )));
            $OBSERVACION_MEDICO= count(Modules::run('Urgencias/Graficasfunctions/IndicadorObservacion',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno'),'tipo'=>'Médico Observación'
            )));
            $this->setOutput(array(
                'OBSERVACION_ENFERMERIA'=>$OBSERVACION_ENFERMERIA,
                'OBSERVACION_MEDICO'=>$OBSERVACION_MEDICO
            ));
        }else if($this->input->post('productividad_tipo')=='Choque'){
            
        }if($this->input->post('productividad_tipo')=='TriageRespiratorio') {
            $TRIAGE_HORACERO= count(Modules::run('Urgencias/Graficasfunctions/LogTotalTickets',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=> $this->input->post('productividad_turno')
            )));
            $TRIAGE_ENFERMERIA=  count(Modules::run('Urgencias/Graficasfunctions/LogEnfermeriaTriage',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=>$this->input->post('productividad_turno')
            )));
            $TRIAGE_MEDICO=  count(Modules::run('Urgencias/Graficasfunctions/LogMedicoTriage',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=>$this->input->post('productividad_turno')
            )));
            $TRIAGE_AM=  count(Modules::run('Urgencias/Graficasfunctions/LogAsistentesMedicas',array(
                'fecha'=>$this->input->post('productividad_fecha'),
                'turno'=>$this->input->post('productividad_turno')
            )));
            $this->setOutput(array(
                'TRIAGE_HORACERO'=>$TRIAGE_HORACERO,
                'TRIAGE_ENFERMERIA'=>$TRIAGE_ENFERMERIA,
                'TRIAGE_MEDICO'=>$TRIAGE_MEDICO,
                'TRIAGE_AM'=>$TRIAGE_AM
            ));

        }

    }
    public function IndicadorUsuarios($Tipo) {
        if($Tipo=='Triage'){
            $sql['Gestion']= Modules::run('Urgencias/Graficasfunctions/IndicadorUsuarios',array(
                'tipo'=> $this->input->get('section'),
                'fecha'=> $this->input->get('fecha'),
                'turno'=> $this->input->get('turno')
            ));
        }else if($Tipo=='Consultorios'){
            $sql['Gestion']= Modules::run('Urgencias/Graficasfunctions/IndicadorConsultoriosUsuarios',array(
                'consultorio'=> $this->input->get('section'),
                'fecha'=> $this->input->get('fecha'),
                'turno'=> $this->input->get('turno')
            ));
        }else if($Tipo=='Observacion'){
            $sql['Gestion']= Modules::run('Urgencias/Graficasfunctions/IndicadorObservacionUsuarios',array(
                'tipo'=> $this->input->get('section'),
                'fecha'=> $this->input->get('fecha'),
                'turno'=> $this->input->get('turno')
            ));
        }else if($Tipo=='Choque'){
            
        }
        
        $this->load->view('graficas/IndicadorUsuarios',$sql);
    }
    public function IndicadorPacientes($Empleado) {
        if($_GET['tipo']=='Triage'){
            $sql['Gestion']= Modules::run('Urgencias/Graficasfunctions/IndicadorUsuariosTotalConsultas',array(
                                                'tipo'=> $this->input->get('section'),
                                                'fecha'=> $this->input->get('fecha'),
                                                'turno'=> $this->input->get('turno'),
                                                'empleado'=>$Empleado
                                            ));
        }else if($_GET['tipo']=='Consultorios'){
            $sql['Gestion']= Modules::run('Urgencias/Graficasfunctions/IndicadorConsultoriosTotalConsultas',array(
                                                'consultorio'=> $this->input->get('section'),
                                                'fecha'=> $this->input->get('fecha'),
                                                'turno'=> $this->input->get('turno'),
                                                'empleado'=>$Empleado
                                            ));
        }else if($_GET['tipo']=='Observacion'){
            $sql['Gestion']= Modules::run('Urgencias/Graficasfunctions/IndicadorObservacionPacientes',array(
                                                'tipo'=> $this->input->get('section'),
                                                'fecha'=> $this->input->get('fecha'),
                                                'turno'=> $this->input->get('turno'),
                                                'empleado'=>$Empleado
                                            ));
        }
        
        
        $this->load->view('graficas/IndicadorPacientes',$sql);
    }
    
    
    public function AjaxBuscarProductividadV2() {
        if($this->input->post('turno')=='1'){
            $turno='Mañana';
        }if($this->input->post('turno')=='2'){
            $turno='Tarde';
        }if($this->input->post('turno')=='3'){
            $turno='Noche';
        }
        $TIPO= $this->input->post('tipo');
        if($TIPO=='Hora Cero'){
            
        }if($TIPO=='Triage Enfermería'){
            
        }if($TIPO=='Triage Médico'){
            
        }if($TIPO=='Asistente Médica'){
            
        }if($TIPO=='RX'){
            $sql['TOTAL_RX']=  count(Modules::run('Urgencias/Graficasfunctions/LogRx',array(
                'fecha'=>$this->input->post('fecha'),
                'turno'=>$turno
            )));
        }if($TIPO=='Consultorios Especialidad'){
            $sql['TOTAL_CE']=  count(Modules::run('Urgencias/Graficasfunctions/LogConsultoriosEspecialidad',array(
                'fecha'=>$this->input->post('fecha'),
                'turno'=>$turno
            )));
        }if($TIPO=='Choque'){
            $sql['TOTAL_CHOQUE']=  count(Modules::run('Urgencias/Graficasfunctions/LogChoque',array(
                'fecha'=>$this->input->post('fecha'),
                'turno'=>$turno
            )));
        }if($TIPO=='Enfermería Observación'){
            $sql['TOTAL_OBSERVACION_E']=  count(Modules::run('Urgencias/Graficasfunctions/LogEnfermeriaMedicoObs',array(
                'fecha'=>$this->input->post('fecha'),
                'turno'=>$turno,
                'tipo'=>'Enfermería Observación',
            )));
        }if($TIPO=='Médico Observación'){
            $sql['TOTAL_OBSERVACION_M']=  count(Modules::run('Urgencias/Graficasfunctions/LogEnfermeriaMedicoObs',array(
                'fecha'=>$this->input->post('fecha'),
                'turno'=>$turno,
                'tipo'=>'Médico Observación',
            )));
        }if($TIPO=='Cirugía Ambulatoria'){
            $sql['TOTAL_CE_CA']=  count(Modules::run('Urgencias/Graficasfunctions/LogCirugiaAmbulatoria',array(
                'fecha'=>$this->input->post('fecha'),
                'turno'=>$turno
            )));
        }if($TIPO=='Egresos Pacietes A.M'){
            $sql['TOTAL_EGRESOS_AM']=  count(Modules::run('Urgencias/Graficasfunctions/LogEgresosAsistentesMedicas',array(
                'fecha'=>$this->input->post('fecha'),
                'turno'=>$turno
            )));
        }
        $this->setOutput($sql);
    }
    public function ProductividadUsuarios() {
        $this->load->view('graficas/ProductividadUsuarios');
    }
    public function AjaxProductividadUsuarios() {
        $turno=Modules::run('Urgencias/Graficasfunctions/ObtenerTurno',array('turno'=>$this->input->post('turno')));
        $fecha=$this->input->post('fecha');
        if($this->input->post('tipo')!='Cirugía Ambulatoria'){
            $sql= Modules::run('Urgencias/Graficasfunctions/ProductividadUsuarios',array(
                'turno'=> $turno,
                'fecha'=>$fecha,
                'tipo'=>$this->input->post('tipo')
            ));
        }else{
            $sql= Modules::run('Urgencias/Graficasfunctions/ProductividadUsuariosCA',array(
                'turno'=> $turno,
                'fecha'=>$fecha
            ));
        }
        $TOTAL_CONSULTAS_ALL=0;
        foreach ($sql as $value) {
            if($this->input->post('tipo')!='Cirugía Ambulatoria'){
                $TOTAL_CONSULTAS= count(Modules::run('Urgencias/Graficasfunctions/ProductividadUsuariosConsultas',array(
                    'turno'=> $turno,
                    'fecha'=> $fecha,
                    'tipo'=>$this->input->post('tipo'),
                    'empleado'=>$value['empleado_id']
                )));
                $TOTAL_ST7='NO APLICA';
                $TOTAL_INCAPACIDAD='NO APLICA';
                $TOTAL_CONSULTAS_ALL=$TOTAL_CONSULTAS_ALL+$TOTAL_CONSULTAS;
            }else{
                $TOTAL_CONSULTAS= count(Modules::run('Urgencias/Graficasfunctions/ProductividadUsuariosConsultasCA',array(
                    'turno'=> $turno,
                    'fecha'=> $fecha,
                    'empleado'=>$value['empleado_id']
                )));
                $TOTAL_ST7= count(Modules::run('Urgencias/Graficasfunctions/ProductividadUsuariosST7CA',array(
                    'turno'=> $turno,
                    'fecha'=> $fecha,
                    'empleado'=>$value['empleado_id']
                )));
                $TOTAL_INCAPACIDAD= count(Modules::run('Urgencias/Graficasfunctions/ProductividadUsuariosIncapacidadCA',array(
                    'turno'=> $turno,
                    'fecha'=> $fecha,
                    'empleado'=>$value['empleado_id']
                )));
                $TOTAL_CONSULTAS_ALL=$TOTAL_CONSULTAS_ALL+$TOTAL_CONSULTAS;
            }
            $tr.='<tr value="'.$value['empleado_id'].'">
                    <td>'.$value['empleado_matricula'].'</td>
                    <td>'.$value['empleado_nombre'].' '.$value['empleado_apellidos'].'</td>
                    <td>'.$TOTAL_ST7.'</td>
                    <td>'.$TOTAL_INCAPACIDAD.'</td>
                    <td>'.$TOTAL_CONSULTAS.'</td>
                    <td>
                        <a href="'. base_url().'Urgencias/Graficas/ProductividadPacientes?empleado='.$value['empleado_id'].'&turno='.$this->input->post('turno').'&fecha='.$this->input->post('fecha').'&tipo='.$this->input->post('tipo').'" target="_blank">
                            <i class="fa fa-users icono-accion"></i>
                        </a>
                    </td>
                </tr>';
        }
        $tr.='<tr value="">
                    <td colspan="4" class="text-right"></td>
                    <td colspan="2"><b>TOTAL DE CONSULTAS :'.$TOTAL_CONSULTAS_ALL.' </b></td>
                </tr>';
        $this->setOutput(array('tr'=>$tr));
    }
    
    public function ProductividadPacientes() {
        $sql['Empleado']= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=> $this->input->get('empleado')
        ));
        if($this->input->get('tipo')!='Cirugía Ambulatoria'){
            $sql['Gestion']= Modules::run('Urgencias/Graficasfunctions/ProductividadPacientes',array(
                'fecha'=>$this->input->get_post('fecha'),
                'turno'=>Modules::run('Urgencias/Graficasfunctions/ObtenerTurno',array('turno'=>$this->input->get_post('turno'))),
                'empleado'=> $this->input->get_post('empleado'),
                'tipo'=> $this->input->get_post('tipo')
            ));
        }else{
            $sql['Gestion']= Modules::run('Urgencias/Graficasfunctions/ProductividadPacientesCA',array(
                'fecha'=>$this->input->get_post('fecha'),
                'turno'=>Modules::run('Urgencias/Graficasfunctions/ObtenerTurno',array('turno'=>$this->input->get_post('turno'))),
                'empleado'=> $this->input->get_post('empleado')
            ));
        }
        $this->load->view('graficas/ProductividadPacientes',$sql);    
                
    }
    /*Consultorios*/
    public function Consultorios() {
        $this->load->view('Graficas/Consultorios');
    }
    public function ConsultoriosUsuarios() {
        $this->load->view('Graficas/ConsultoriosUsuarios');
    }
    public function ConsultoriosPacientes() {
        $sql['Gestion']=Modules::run('Urgencias/Graficasfunctions/ObtenerPacientesConsultoriosEmpleados',array(
                                'turno'=> Modules::run('Urgencias/Graficasfunctions/ObtenerTurno',array('turno'=>$this->input->get_post('turno'))),
                                'fecha'=>$this->input->get_post('fecha'),
                                'consultorio'=>$this->input->get_post('consultorio'),
                                'empleado'=> $this->input->get_post('empleado')
                            ));
        $this->load->view('Graficas/ConsultoriosPacientes',$sql);
    }
    public function AjaxConsultoriosUsuarios() {
        $sql=Modules::run('Urgencias/Graficasfunctions/ObtenerPacientesConsultoriosUsuarios',array(
            'turno'=> Modules::run('Urgencias/Graficasfunctions/ObtenerTurno',array('turno'=>$this->input->post('turno'))),
            'fecha'=> $this->input->post('fecha'),
            'consultorio'=> $this->input->post('consultorio')
        ));
        foreach ($sql as $value) {
            $tr.='<tr value="'.$value['empleado_id'].'">
                    <td>'.$value['empleado_matricula'].'</td>
                    <td>'.$value['empleado_nombre'].' '.$value['empleado_apellidos'].'</td>
                    <td>
                        '.count(Modules::run('Urgencias/Graficasfunctions/TotalConsultasPacientesConsultorios',array(
                                'turno'=> Modules::run('Urgencias/Graficasfunctions/ObtenerTurno',array('turno'=>$this->input->post('turno'))),
                                'fecha'=>$this->input->post('fecha'),
                                'consultorio'=>$this->input->post('consultorio'),
                                'empleado'=>$value['empleado_id']
                            ))).'
                    </td>
                    <td>
                        '.count(Modules::run('Urgencias/Graficasfunctions/TotalST7PacientesConsultorios',array(
                                'turno'=> Modules::run('Urgencias/Graficasfunctions/ObtenerTurno',array('turno'=>$this->input->post('turno'))),
                                'fecha'=>$this->input->post('fecha'),
                                'consultorio'=>$this->input->post('consultorio'),
                                'empleado'=>$value['empleado_id']
                            ))).'
                    </td>
                    <td>
                        '.count(Modules::run('Urgencias/Graficasfunctions/TotalIncapacidadPacientesConsultorios',array(
                                'turno'=> Modules::run('Urgencias/Graficasfunctions/ObtenerTurno',array('turno'=>$this->input->post('turno'))),
                                'fecha'=>$this->input->post('fecha'),
                                'consultorio'=>$this->input->post('consultorio'),
                                'empleado'=>$value['empleado_id']
                            ))).'
                    </td>
                    <td>
                        <a href="'. base_url().'Urgencias/Graficas/ConsultoriosPacientes?empleado='.$value['empleado_id'].'&turno='.$this->input->post('turno').'&fecha='.$this->input->post('fecha').'&consultorio='.$this->input->post('consultorio').'" target="_blank">
                            <i class="fa fa-users icono-accion"></i>
                        </a>
                    </td>
                </tr>';
        }
        $this->setOutput(array('tr'=>$tr));
    }
}
