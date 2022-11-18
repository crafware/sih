<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'modules/config/controllers/Config.php';
class Inicio extends Config {
      
    public function __construct() {
        parent::__construct();
        $this->load->model('Inicio_m');
    }
    public function index() {
        $sql['Alerts']= $this->config_mdl->sqlGetData('um_alerts');
        if($this->UMAE_AREA == 'Arimac'){
            $this->load->view('Dashboard/Inicio_arimac',$sql);
        }elseif($this->UMAE_AREA == 'Urgencias'){
            $this->load->view('Dashboard/Urgencias',$sql);
        }elseif($this->UMAE_AREA == 'Limpieza e Higiene') {
            $this->load->view('Hospitalizacion/Limpiezaehigiene',$sql);
        }elseif($this->UMAE_AREA == 'Conservación') {
            $this->load->view('Hospitalizacion/Limpiezaehigiene',$sql);
        }elseif($this->UMAE_AREA == 'Asistente Médica Admisión Continua') {
            $this->load->view('Multimedia/AsistentesMedicasUrgencias',$sql);
        }elseif($this->UMAE_AREA == 'Admisión Hospitalaria'){
            //$this->load->view('AdmisionHospitalaria/TableroCamas',$sql);
            $this->load->view('Multimedia/AsistentesMedicasUrgencias',$sql);
        }else  $this->load->view('inicio',$sql);
    }
    public function notificaciones_total() {
       $this->setOutput(array('total'=>0));
    }
    public function jefa_asistentesmedicas() {
        if($_GET['triage_color']=='Todos'){
            //$triage_color="";
        }else{
          //  $triage_color="os_triage.triage_color='".$_GET['triage_color']."' AND";
        }
        $triage_color='';
        if($_GET['filter_select']){
            if($_GET['filter_select']=='by_fecha'){
                $fi=  $this->input->get('fi');
                $ff=  $this->input->get('ff');
                $sql['Gestion']=  $this->FiltroPorFecha($fi, $ff);
                $sql['triage_rojo']=$this->FiltroPorFechaByColor($fi, $ff, 'Rojo');
                $sql['triage_naranja']=$this->FiltroPorFechaByColor($fi, $ff, 'Naranja');
                $sql['triage_amarillo']=$this->FiltroPorFechaByColor($fi, $ff, 'Amarilo');
                $sql['triage_verde']=$this->FiltroPorFechaByColor($fi, $ff, 'Verde');
                $sql['triage_azul']=$this->FiltroPorFechaByColor($fi, $ff, 'Azul');
                $sql['CE_FILTRO']=  $this->FiltroPorFechaByConsultorio($fi, $ff, 'Filtro');
                $sql['CE_CPR']=  $this->FiltroPorFechaByConsultorio($fi, $ff, 'Consultorio CPR');
                $sql['CE_N']=  $this->FiltroPorFechaByConsultorio($fi, $ff, 'Consultorio Neurocirugía');
                $sql['CE_CG']=  $this->FiltroPorFechaByConsultorio($fi, $ff, 'Consultorio Cirugía General');
                $sql['CE_M']=  $this->FiltroPorFechaByConsultorio($fi, $ff, 'Consultorio Maxilofacial');
                $sql['CE_CM']=  $this->FiltroPorFechaByConsultorio($fi, $ff, 'Consultorio Cirugía Maxilofacial');

            }if($_GET['filter_select']=='by_hora'){
                $fi=  $this->input->get('fi');
                $hi=  $this->input->get('hi');
                $hf=  $this->input->get('hf');
                
                $sql['Gestion']= $this->FiltroPorHora($fi, $hi, $hf);
                $sql['triage_rojo']=  $this->FiltroPorHoraPorColor($fi, $hi, $hf, 'Rojo');
                $sql['triage_naranja']=  $this->FiltroPorHoraPorColor($fi, $hi, $hf, 'Naranja');
                $sql['triage_amarilo']=  $this->FiltroPorHoraPorColor($fi, $hi, $hf, 'Amarillo');
                $sql['triage_verde']=  $this->FiltroPorHoraPorColor($fi, $hi, $hf, 'Verde');
                $sql['triage_azul']=  $this->FiltroPorHoraPorColor($fi, $hi, $hf, 'Azul');
                $sql['CE_FILTRO']=  $this->FiltroPorHoraPorConsultorio($fi, $hi,$hf, 'Filtro');
                $sql['CE_CPR']=  $this->FiltroPorHoraPorConsultorio($fi, $hi,$hf, 'Consultorio CPR');
                $sql['CE_N']=  $this->FiltroPorHoraPorConsultorio($fi, $hi,$hf, 'Consultorio Neurocirugía');
                $sql['CE_CG']=  $this->FiltroPorHoraPorConsultorio($fi, $hi,$hf, 'Consultorio Cirugía General');
                $sql['CE_M']=  $this->FiltroPorHoraPorConsultorio($fi, $hi,$hf, 'Consultorio Maxilofacial');
                $sql['CE_CM']=  $this->FiltroPorHoraPorConsultorio($fi, $hi,$hf, 'Consultorio Cirugía Maxilofacial');
                
            }
        }
        $this->load->view('jefa_asistentesmedicas',$sql);
    }
    public function FiltroPorFecha($fi,$ff) {
        return $this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad, os_asistentesmedicas, os_triage
                    WHERE os_consultorios_especialidad.triage_id=os_asistentesmedicas.triage_id AND
                    os_asistentesmedicas.triage_id=os_triage.triage_id AND os_consultorios_especialidad.ce_status!='Salida' AND
                    asistentesmedicas_fecha BETWEEN '$fi' AND '$ff'
                ");
    }
    public function FiltroPorFechaByColor($fi,$ff,$color) {
        return count($this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad, os_asistentesmedicas, os_triage
                    WHERE os_consultorios_especialidad.triage_id=os_asistentesmedicas.triage_id AND
                    os_asistentesmedicas.triage_id=os_triage.triage_id AND os_consultorios_especialidad.ce_status!='Salida' AND
                    asistentesmedicas_fecha BETWEEN '$fi' AND '$ff' AND  os_triage.triage_color='$color'
                "));
    }
    public function FiltroPorFechaByConsultorio($fi,$ff,$consultorio) {
        return count($this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad, os_asistentesmedicas, os_triage
                    WHERE os_consultorios_especialidad.triage_id=os_asistentesmedicas.triage_id AND
                    os_asistentesmedicas.triage_id=os_triage.triage_id AND os_consultorios_especialidad.ce_status!='Salida' AND
                    asistentesmedicas_fecha BETWEEN '$fi' AND '$ff' AND  os_triage.triage_consultorio_nombre='$consultorio'
                "));
    }
    public function FiltroPorHora($fi,$hi,$hf) {
        return $this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad, os_asistentesmedicas, os_triage
                    WHERE os_consultorios_especialidad.triage_id=os_asistentesmedicas.triage_id AND
                    os_asistentesmedicas.triage_id=os_triage.triage_id AND os_consultorios_especialidad.ce_status!='Salida' AND
                    asistentesmedicas_fecha='$fi' AND asistentesmedicas_hora BETWEEN '$hi' AND '$hf'
                ");
    }
    public function FiltroPorHoraPorColor($fi,$hi,$hf,$color) {
        return count($this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad, os_asistentesmedicas, os_triage
                    WHERE os_consultorios_especialidad.triage_id=os_asistentesmedicas.triage_id AND
                    os_asistentesmedicas.triage_id=os_triage.triage_id AND os_consultorios_especialidad.ce_status!='Salida' AND
                    asistentesmedicas_fecha='$fi' AND asistentesmedicas_hora BETWEEN '$hi' AND '$hf' AND  os_triage.triage_color='$color'
                "));
    }
    public function FiltroPorHoraPorConsultorio($fi,$hi,$hf,$consultorio) {
        return count($this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad, os_asistentesmedicas, os_triage
                    WHERE os_consultorios_especialidad.triage_id=os_asistentesmedicas.triage_id AND
                    os_asistentesmedicas.triage_id=os_triage.triage_id AND os_consultorios_especialidad.ce_status!='Salida' AND
                    asistentesmedicas_fecha='$fi' AND asistentesmedicas_hora BETWEEN '$hi' AND '$hf' AND  os_triage.triage_consultorio_nombre='$consultorio'
                "));
    }
    
    public function jefa_enfermeras() {
        $this->load->view('jefa_enfermeras');
    }
    public function JefaAMProductividad() {
        $sql['TOTAL_CPR']=  count($this->JefaAMProductividadFiltro($this->input->post('turno'), $this->input->post('fecha'), 'Consultorio CPR'));
        $sql['TOTAL_NEUROCIRUGIA']=  count($this->JefaAMProductividadFiltro($this->input->post('turno'), $this->input->post('fecha'), 'Consultorio Neurocirugía'));
        $sql['TOTAL_CIRURIAGENERAL']=  count($this->JefaAMProductividadFiltro($this->input->post('turno'), $this->input->post('fecha'), 'Consultorio Cirugía General'));
        $sql['TOTAL_MAXILOFACIAL']=  count($this->JefaAMProductividadFiltro($this->input->post('turno'), $this->input->post('fecha'), 'Consultorio Maxilofacial'));
        $sql['TOTAL_CIRUGIAMAXILOFACIAL']= count($this->JefaAMProductividadFiltro($this->input->post('turno'), $this->input->post('fecha'), 'Consultorio Cirugía Maxilofacial'));
        $sql['TOTAL_OBSERVACION']= count($this->JefaAMProductividadFiltro($this->input->post('turno'), $this->input->post('fecha'), 'Observación'));
        $sql['TOTAL_FILTRO']= count($this->JefaAMProductividadFiltro($this->input->post('turno'), $this->input->post('fecha'), 'Filtro'));
        $sql['TOTAL_FILTRO_EGRESO']= count($this->JefaAMProductividadEgresos($this->input->post('turno'), $this->input->post('fecha'), 'Consultorios'));
        $sql['TOTAL_OBSERVACION_EGRESO']= count($this->JefaAMProductividadEgresos($this->input->post('turno'), $this->input->post('fecha'), 'Observacion'));
        $this->setOutput($sql);
    }
    public function JefaAMProductividadEgresos($turno,$fecha,$tipo) {
        return $this->config_mdl->_query("SELECT * FROM os_accesos, os_triage,  os_asistentesmedicas_egresos
                                        WHERE 
                                        os_accesos.acceso_tipo='Egreso Paciente Asistente Médica' AND
                                        os_accesos.acceso_turno='$turno' AND 
                                        os_accesos.acceso_fecha='$fecha' AND
                                        os_accesos.triage_id=os_triage.triage_id AND
                                        os_asistentesmedicas_egresos.triage_id=os_triage.triage_id AND
                                        os_asistentesmedicas_egresos.egreso_area='$tipo' AND
                                        os_accesos.triage_id=os_triage.triage_id"
                );
    }
    public function JefaAMProductividadFiltro($turno,$fecha,$consultorio) {
        if($consultorio==''){
            $consultorio_t='';
        }else{
            $consultorio_t=" AND os_triage.triage_consultorio_nombre='$consultorio'";
        }
        return $this->config_mdl->_query("SELECT * FROM os_accesos, os_triage, os_asistentesmedicas
                                        WHERE 
                                        os_accesos.areas_id=os_asistentesmedicas.asistentesmedicas_id AND
                                        os_triage.triage_id=os_accesos.triage_id AND
                                        os_triage.triage_id=os_asistentesmedicas.triage_id AND 
                                        os_accesos.acceso_tipo='Asistente Médica' AND 
                                        os_accesos.acceso_turno='$turno' AND 
                                        os_accesos.acceso_fecha='$fecha' $consultorio_t"
                );
    }
    
    public function formato_2430_003_039() {
        if($_GET['triage_color']=='Todos'){
            $triage_color="";
        }else{
            $triage_color="os_triage.triage_color='".$_GET['triage_color']."' AND";
            $triage_color_like="os_triage.triage_color='".$_GET['triage_color']."'";
        }
        if($_GET['filter_select']){
            if($_GET['filter_select']=='by_fecha'){
                $fi=  $this->input->get('fi');
                $ff=  $this->input->get('ff');
                $sql['Gestion']=  $this->config_mdl->_query("SELECT * FROM os_triage,os_asistentesmedicas, os_consultorios_especialidad WHERE $triage_color os_consultorios_especialidad.ce_status='Salida' AND os_consultorios_especialidad.triage_id=os_triage.triage_id AND  os_asistentesmedicas.triage_id=os_triage.triage_id AND os_asistentesmedicas.asistentesmedicas_status='Datos Capturados' AND os_triage.triage_fecha_clasifica BETWEEN '$fi' AND '$ff' ORDER BY os_triage.triage_id DESC");
            }if($_GET['filter_select']=='by_hora'){
                $fi=  $this->input->get('fi');
                $hi=  $this->input->get('hi');
                $hf=  $this->input->get('hf');
                $sql['Gestion']=  $this->config_mdl->_query("SELECT * FROM os_triage,os_asistentesmedicas,os_consultorios_especialidad WHERE $triage_color os_consultorios_especialidad.ce_status='Salida' AND  os_consultorios_especialidad.triage_id=os_triage.triage_id AND os_asistentesmedicas.triage_id=os_triage.triage_id AND os_asistentesmedicas.asistentesmedicas_status='Datos Capturados' AND triage_horacero_f='$fi' AND triage_horacero_h BETWEEN '$hi' AND '$hf' ORDER BY os_triage.triage_id DESC");
               
            }
        }
        $this->load->view('formato_2430_003_039',$sql);
    }
    public function ActualizarAccesosAreas() {
        $sql= $this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad, os_accesos, os_triage 
        WHERE 
        os_accesos.triage_id=os_triage.triage_id AND 
        os_accesos.triage_id=os_consultorios_especialidad.triage_id AND 
        os_accesos.acceso_tipo='Consultorios Especialidad'");
        foreach ($sql as $value) {
            if($value['areas_id']==''):
                $this->config_mdl->_update_data('os_accesos',array(
                    'areas_id'=>$value['ce_id']
                ),array(
                    'acceso_id'=>$value['acceso_id']
                ));
            endif;
        }
        $this->setOutput(array('ACCION'=>'OK'));
    }
    public function AsignarRolesExtras() {
        $sql= $this->config_mdl->_query("SELECT * FROM os_empleados, os_roles, os_empleados_roles
                                        WHERE
                                        os_empleados_roles.empleado_id=os_empleados.empleado_id AND
                                        os_empleados_roles.rol_id=os_roles.rol_id AND
                                        os_roles.rol_id=4");
        foreach ($sql as $value) {
            
            $sql_= $this->config_mdl->_get_data_condition('os_empleados_roles',array(
                'empleado_id'=>$value['empleado_id'],
                'rol_id'=>'19'
            ));
            if(empty($sql_)){
                $this->config_mdl->_insert('os_empleados_roles',array(
                    'empleado_id'=>$value['empleado_id'],
                    'rol_id'=>'19'
                ));
            }
        }
    }
    public function AjaxGraficaInicio() {
        
        if($this->input->post('ANIO')==''){
            $hoy= date('Y');
        }else{
            $hoy= $this->input->post('ANIO');
        }
        
        $this->setOutput(array(
            'ENE_ROJO'=> $this->ObtenerValores('Rojo', 1, $hoy),
            'ENE_NARANJA'=> $this->ObtenerValores('Naranja', 1, $hoy),
            'ENE_AMARILLO'=> $this->ObtenerValores('Amarillo', 1, $hoy),
            'ENE_VERDE'=> $this->ObtenerValores('Verde', 1, $hoy),
            'ENE_AZUL'=> $this->ObtenerValores('Azul', 1, $hoy),
            'FEB_ROJO'=> $this->ObtenerValores('Rojo', 2, $hoy),
            'FEB_NARANJA'=> $this->ObtenerValores('Naranja', 2, $hoy),
            'FEB_AMARILLO'=> $this->ObtenerValores('Amarillo', 2, $hoy),
            'FEB_VERDE'=> $this->ObtenerValores('Verde', 2, $hoy),
            'FEB_AZUL'=> $this->ObtenerValores('Azul', 2, $hoy),
            'MAR_ROJO'=> $this->ObtenerValores('Rojo', 3, $hoy),
            'MAR_NARANJA'=> $this->ObtenerValores('Naranja', 3, $hoy),
            'MAR_AMARILLO'=> $this->ObtenerValores('Amarillo', 3, $hoy),
            'MAR_VERDE'=> $this->ObtenerValores('Verde', 3, $hoy),
            'MAR_AZUL'=> $this->ObtenerValores('Azul',3, $hoy),
            'ABR_ROJO'=> $this->ObtenerValores('Rojo', 4, $hoy),
            'ABR_NARANJA'=> $this->ObtenerValores('Naranja', 4, $hoy),
            'ABR_AMARILLO'=> $this->ObtenerValores('Amarillo', 4, $hoy),
            'ABR_VERDE'=> $this->ObtenerValores('Verde', 4, $hoy),
            'ABR_AZUL'=> $this->ObtenerValores('Azul', 4, $hoy),
            'MAY_ROJO'=> $this->ObtenerValores('Rojo', 5, $hoy),
            'MAY_NARANJA'=> $this->ObtenerValores('Naranja', 5, $hoy),
            'MAY_AMARILLO'=> $this->ObtenerValores('Amarillo', 5, $hoy),
            'MAY_VERDE'=> $this->ObtenerValores('Verde', 5, $hoy),
            'MAY_AZUL'=> $this->ObtenerValores('Azul', 5, $hoy),
            'JUN_ROJO'=> $this->ObtenerValores('Rojo', 6, $hoy),
            'JUN_NARANJA'=> $this->ObtenerValores('Naranja', 6, $hoy),
            'JUN_AMARILLO'=> $this->ObtenerValores('Amarillo', 6, $hoy),
            'JUN_VERDE'=> $this->ObtenerValores('Verde', 6, $hoy),
            'JUN_AZUL'=> $this->ObtenerValores('Azul', 6, $hoy),
            'JUL_ROJO'=> $this->ObtenerValores('Rojo', 7, $hoy),
            'JUL_NARANJA'=> $this->ObtenerValores('Naranja', 7, $hoy),
            'JUL_AMARILLO'=> $this->ObtenerValores('Amarillo', 7, $hoy),
            'JUL_VERDE'=> $this->ObtenerValores('Verde', 7, $hoy),
            'JUL_AZUL'=> $this->ObtenerValores('Azul', 7, $hoy),
            'AGO_ROJO'=> $this->ObtenerValores('Rojo', 8, $hoy),
            'AGO_NARANJA'=> $this->ObtenerValores('Naranja', 8, $hoy),
            'AGO_AMARILLO'=> $this->ObtenerValores('Amarillo', 8, $hoy),
            'AGO_VERDE'=> $this->ObtenerValores('Verde', 8, $hoy),
            'AGO_AZUL'=> $this->ObtenerValores('Azul', 8, $hoy),
            'SEP_ROJO'=> $this->ObtenerValores('Rojo', 8, $hoy),
            'SEP_NARANJA'=> $this->ObtenerValores('Naranja', 9, $hoy),
            'SEP_AMARILLO'=> $this->ObtenerValores('Amarillo', 9, $hoy),
            'SEP_VERDE'=> $this->ObtenerValores('Verde', 9, $hoy),
            'SEP_AZUL'=> $this->ObtenerValores('Azul', 9, $hoy),
            'OCT_ROJO'=> $this->ObtenerValores('Rojo', 9, $hoy),
            'OCT_NARANJA'=> $this->ObtenerValores('Naranja', 10, $hoy),
            'OCT_AMARILLO'=> $this->ObtenerValores('Amarillo', 10, $hoy),
            'OCT_VERDE'=> $this->ObtenerValores('Verde', 10, $hoy),
            'OCT_AZUL'=> $this->ObtenerValores('Azul', 10, $hoy),
            'NOV_ROJO'=> $this->ObtenerValores('Rojo', 10, $hoy),
            'NOV_NARANJA'=> $this->ObtenerValores('Naranja', 11, $hoy),
            'NOV_AMARILLO'=> $this->ObtenerValores('Amarillo', 11, $hoy),
            'NOV_VERDE'=> $this->ObtenerValores('Verde', 11, $hoy),
            'NOV_AZUL'=> $this->ObtenerValores('Azul', 11, $hoy),
            'DIC_ROJO'=> $this->ObtenerValores('Rojo', 12, $hoy),
            'DIC_NARANJA'=> $this->ObtenerValores('Naranja', 12, $hoy),
            'DIC_AMARILLO'=> $this->ObtenerValores('Amarillo', 12, $hoy),
            'DIC_VERDE'=> $this->ObtenerValores('Verde', 12, $hoy),
            'DIC_AZUL'=> $this->ObtenerValores('Azul', 12, $hoy),
        ));
    }
    public function ObtenerValores($Color,$Mes,$Anio) {
        return count(
                    $this->config_mdl->_get_data_condition('os_triage',array(
                        'MONTH(os_triage.triage_fecha_clasifica_chart)'=>$Mes,
                        'YEAR(os_triage.triage_fecha_clasifica_chart)'=>$Anio,
                        'triage_color'=>$Color))
                );
    }
    public function AccesosAgresos() {
        $SqlAgreso= $this->config_mdl->_query("SELECT * FROM os_accesos, os_asistentesmedicas_egresos
                                            WHERE 
                                            os_accesos.acceso_tipo='Egreso Paciente Asistente Médica' AND
                                            os_asistentesmedicas_egresos.triage_id=os_accesos.triage_id AND os_accesos.areas_id=''");
        foreach ($SqlAgreso as $value) {
            $this->config_mdl->_update_data('os_accesos',array(
                'areas_id'=>$value['egreso_id']
            ),array(
                'triage_id'=>$value['triage_id'],
                'acceso_id'=>$value['acceso_id']
            ));
        }
        echo 'PROCESO FINALIZADO';
    }
}