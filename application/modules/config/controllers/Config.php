<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author felipe de jesus
 */
require_once APPPATH.'third_party/html2pdf/html2pdf.class.php';
require_once APPPATH.'third_party/PHPExcel/PHPExcel.php';
class Config extends MX_Controller{
    public $UMAE_USER,$UMAE_AREA, $UMAE_SERVICIO;
    public $UM_NOMBRE;
    public $UM_TIPO;
    public $UM_CLASIFICACION;
    public $UM_DIRECCION;
    public $UM_LOGO;
    public $ConfigEnfermeriaHC,$ConfigSolicitarOD,$ConfigOrtopediaAC,$ConfigDestinosMT,$ConfigDestinosOAC,
           $ConfigExcepcionCMT,$ConfigExpedienteMagdalena,$ConfigExpediente430128,$ConfigDiagnosticosCIE10,
           $ConfigHojaInicialAsistentes,$ConfigHojaInicialAbierta,$ConfigEnfermeriaObsPorTipos,$ConfigExcepcionRMTR;
    public function __construct() {
        parent::__construct(); 
        error_reporting(0);
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','3096M');
        date_default_timezone_set('America/Mexico_City');
        $this->UMAE_USER=$_SESSION['UMAE_USER'];
        $this->UMAE_AREA=$_SESSION['UMAE_AREA'];
        $this->UMAE_SERVICIO=$_SESSION['UMAE_SERVICIO'];
        $this->load->model(array(
            'config/config_mdl'
        ));
        $this->_umConfig();
        $this->_um();
    }
    public function _umConfig() {
        $sql= $this->config_mdl->_get_data('um_config');
        $this->ConfigEnfermeriaHC           =   $sql[0]['config_estatus'];
        $this->ConfigSolicitarOD            =   $sql[1]['config_estatus'];
        $this->ConfigDestinosMT             =   $sql[2]['config_estatus'];
        $this->ConfigDestinosOAC            =   $sql[3]['config_estatus'];
        $this->ConfigExcepcionCMT           =   $sql[4]['config_estatus'];
        $this->ConfigExpedienteMagdalena    =   $sql[5]['config_estatus'];
        $this->ConfigExpediente430128       =   $sql[6]['config_estatus'];
        $this->ConfigDiagnosticosCIE10      =   $sql[7]['config_estatus'];
        define('CONFIG_AM_HOJAINICIAL', $sql[8]['config_estatus']);
        $this->ConfigHojaInicialAsistentes  =   $sql[8]['config_estatus'];
        $this->ConfigHojaInicialAbierta     =   $sql[9]['config_estatus'];
        $this->ConfigEnfermeriaObsPorTipos     =   $sql[10]['config_estatus'];
        define('CONFIG_ENFERMERIA_OBSERVACION', $sql[10]['config_estatus']);
        define('CONFIG_AM_INTERACCION_LT', $sql[11]['config_estatus']);
        $this->ConfigExcepcionRMTR          =   $sql[12]['config_estatus'];
    }
    public function _um() {
        $sql= $this->config_mdl->sqlGetData('um_')[0];
        define('_UM_NOMBRE', $sql['um_nombre']);
        define('_UM_TIPO', $sql['um_tipo']);
        define('_UM_CLASIFICACION', $sql['um_clasificacion']);
        define('_UM_DIRECCION', $sql['um_direccion']);
        define('_UM_LOGO', $sql['um_logo']);
        $this->UM_NOMBRE=$sql['um_nombre'];
        $this->UM_TIPO=$sql['um_tipo'];
        $this->UM_CLASIFICACION=$sql['um_clasificacion'];
        $this->UM_DIRECCION=$sql['um_direccion'];
        $this->UM_LOGO=$sql['um_logo'];
    }
    public function CerrarSesion() {
        $this->config_mdl->_update_data('os_empleados',array('empleado_conexion'=> '0'),array(
                'empleado_id'=> $this->UMAE_USER
        ));
        session_destroy();
        session_unset();
        redirect('login');
    }
    public function VerificarSession() {
        if(!isset($_SESSION['UMAE_USER'])){
            redirect(base_url());
        }
    }
    public function SessionExpired() {
        if(isset($_SESSION['UMAE_USER'])){
            $this->setOutput(array('accion'=>'1')); 
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function ActualizarPorCambio() {
        $this->setOutput(array('accion'=>'1'));
    }
    public function setOutput($json) {
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }  
    public function setOutputV2($json) {
        header('Content-type: application/json');
        echo  json_encode($json,JSON_PRETTY_PRINT);
        //$this->output->set_content_type('application/json')->set_output(json_encode($json,JSON_PRETTY_PRINT));
    }  
    public function mapa() {
        $this->load->view('mapa');
    }    
    public function upload_image_pt() {
        $url_sav = $_GET['tipo'];
        $dir = 'assets/' .$url_sav . '/';
        $serverdir = $dir;
        $tmp = explode(',', $_POST['data']['data']);
        $imgdata = base64_decode($tmp[1]);
        $extension = strtolower(end(explode('.', $_POST['data']['name'])));
        $filename = substr($_POST['data']['name'], 0, -(strlen($extension) + 1)) . '.' . substr(sha1(time()), 0, 6) . '.' . $extension;
        $handle = fopen($serverdir . $filename, 'w');
        fwrite($handle, $imgdata);
        fclose($handle);
        $response = array(
            "status" => "success",
            "url" => $filename . '?' . time(),
            "filename" => $filename
        );
        if (!empty($_POST['original'])) {
            $tmp = explode(',', $_POST['original']);
            $originaldata = base64_decode($tmp[1]);
            $original = substr($_POST['name'], 0, -(strlen($extension) + 1)) . '.' . substr(sha1(time()), 0, 6) . '.original.' . $extension;

            $handle = fopen($serverdir . $original, 'w');
            fwrite($handle, $originaldata);
            fclose($handle);
            $response['original'] = $original;
        }
        $this->setOutput($response);
    }

    
    public function AccesosUsuarios($datas){
        if(strtotime(date('H:i'))>=  strtotime('07:00')){
            $turno='Mañana';
            $turno_test='Mañana';
        }if(strtotime(date('H:i'))>=  strtotime('14:00')){
            $turno='Tarde';
            $turno_test='Tarde';
        }if(strtotime(date('H:i')) >=  strtotime('21:00')){ 
            $turno='Noche';
            $turno_test='Noche A';
        }if(strtotime(date('H:i')) >=  strtotime('00:00') && strtotime(date('H:i'))<  strtotime('07:00') ){ 
            $turno='Noche';
            $turno_test='Noche B';
        }
        $this->config_mdl->_insert('os_accesos',array(
            'acceso_tipo'=>$datas['acceso_tipo'],
            'acceso_fecha'=>  date('d/m/Y'),
            'acceso_hora'=>  date('H:i:s') ,
            'acceso_turno'=>$turno,
            //'acceso_turno_test'=>$turno_test,
            'acceso_tarea'=>$datas['acceso_tarea'],
            'triage_id'=>$datas['triage_id'],
            'empleado_id'=>$_SESSION['UMAE_USER'],
            'areas_id'=>$datas['areas_id']
        ));
    }
    public function ObtenerTurno(){
        if(strtotime(date('H:i'))>=  strtotime('07:00') && strtotime(date('H:i'))< strtotime('13:59')){
            return 'Mañana';
        }if(strtotime(date('H:i'))>=  strtotime('14:00') && strtotime(date('H:i'))< strtotime('20:59')){
            return 'Tarde';
        }if(strtotime(date('H:i')) >=  strtotime('21:00') && strtotime(date('H:i')) <  strtotime('23:59')){ 
            return 'Noche A';
        }if(strtotime(date('H:i')) >=  strtotime('00:00') && strtotime(date('H:i')) <  strtotime('06:59')){ 
            return 'Noche B';
        }
    }
    public function UMAE_LOG($datas){
        if(strtotime(date('H:i'))>=  strtotime('07:00')){
            $turno='Mañana';
            $turno_test='Mañana';
        }if(strtotime(date('H:i'))>=  strtotime('14:00')){
            $turno='Tarde';
            $turno_test='Tarde';
        }if(strtotime(date('H:i')) >=  strtotime('21:00')){ 
            $turno='Noche';
            $turno_test='Noche A';
        }if(strtotime(date('H:i')) >=  strtotime('00:00') && strtotime(date('H:i'))<  strtotime('07:00') ){ 
            $turno='Noche';
            $turno_test='Noche B';
        }
        $this->config_mdl->_insert($datas['table'],array(
            'log_tipo'=>$datas['log_tipo'],
            'log_fecha'=>  date('d/m/Y'),
            'log_hora'=>  date('H:i') ,
            'log_turno'=>$turno,
            'triage_id'=>$datas['triage_id'],
            'empleado_id'=> $this->UMAE_USER,
            'areas_id'=>$datas['areas_id']
        ));
    }
    public function TiempoTranscurridoResult($data) {
        $Tiempo1=new DateTime($data['fecha1']);
        $Tiempo2=new DateTime($data['fecha2']);
        $diff=$Tiempo1->diff($Tiempo2);
        return $diff->h*60 + $diff->i; 
    }
    public function TiempoTranscurrido($data) {
        $Tiempo1=new DateTime(str_replace('/', '-', $data['Tiempo1_fecha']).' '.$data['Tiempo1_hora']);
        $Tiempo2=new DateTime(str_replace('/', '-', $data['Tiempo2_fecha']).' '. $data['Tiempo2_hora']);
        $diff=$Tiempo1->diff($Tiempo2);
        return $diff->h*60 + $diff->i; 
    }
    public function CalcularTiempoTranscurrido($data) {
        $Tiempo1=new DateTime($data['Tiempo1']);
        $Tiempo2=new DateTime($data['Tiempo2']);
        return $Tiempo1->diff($Tiempo2);
    }
    public function ColorClasificacion($data) {
        switch ($data['color']){
            case 'Rojo':
                return 'red';
            case 'Naranja':
                return 'orange';
            case  'Amarillo':
                return 'yellow-A700';
            case 'Verde':
                return 'green';
            case 'Azul':
                return 'indigo';
        }
    }
    public function ColorClasificacionBorder($data) {
        switch ($data['color']){
            case 'Rojo':
                return '#F44336';
            case 'Naranja':
                return '#FF9800';
            case  'Amarillo':
                return '#FFC107';
            case 'Verde':
                return '#4CAF50';
            case 'Azul':
                return '#3F51B5';
        }
    }
    public function CalcularEdad_($fechanac) {
        $fecha_hac=  new DateTime(str_replace('/', '-', $fechanac));
        $hoy=  new DateTime(date('d-m-Y')); 
        return $hoy->diff($fecha_hac); 
    }
    public function ModCalcularEdad($data) {
        $fecha_hac=  new DateTime(str_replace('/', '-', $data['fecha']));
        $hoy=  new DateTime(date('d-m-Y')); 
        return $hoy->diff($fecha_hac); 
    }
    public function ExpiredSession() {
        if(isset($_SESSION['UMAE_USER'])){
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function EgresoCamas($data) { 
        $this->config_mdl->_insert('os_camas_egresos',array(
            'cama_egreso_f'=> date('d/m/Y'),
            'cama_egreso_h'=> date('H:i'),
            'cama_egreso_cama'=>$data['cama_egreso_cama'],
            'cama_egreso_tipo'=>'Egreso',
            'cama_egreso_modulo'=> $this->UMAE_AREA,
            'cama_egreso_destino'=>$data['cama_egreso_destino'],
            'cama_egreso_table'=>$data['cama_egreso_table'],
            'cama_egreso_table_id'=>$data['cama_egreso_table_id'],
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=> $data['triage_id']
        ));
    }
    public function ModuleNotAvailable() {
        echo Modules::run('Sections/Menu/index');
        echo'<div class="box-row">
                    <div class="box-cell">
                        <div class="box-inner padding">
                            <div class="col-md-8 col-centered">
                                <div class="panel p teal text-center">
                                    <i class="fa fa-exclamation-triangle fa-4x"></i>
                                    <h5 style="text-align:center;line-height:1.4">
                                        <b>ESTE MODULO O SECCIÓN NO ESTA DISPONIBLE EN ESTA UNIDAD MÉDICA</b>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        echo Modules::run('Sections/Menu/footer'); 
    }
    //Regresa el valor del codigo de atencion
    public function ConvertirCodigoAtencion($codigo){
      switch ($codigo) {
        case 0:
          return '';
        case 1:
          return 'Infarto';
        case 2:
          return 'Cerebro';
        case 3:
          return 'Procuración';
        case 4:
          return 'Mater';
      }
    }

    /*NUEVAS FUNCIONES  POR SERVICIOS ETC..*/
    public function ObtenerEspecialidad($data) {
        $Usuario=$data['Usuario'];
        $sqlEspecialidad= $this->config_mdl->_query("SELECT * FROM um_especialidades, os_empleados WHERE
            um_especialidades.especialidad_id=os_empleados.empleado_servicio AND
            os_empleados.empleado_id='$Usuario'")[0];
        return $sqlEspecialidad['especialidad_nombre'];

    }
    public function ObtenerEspecialidadID($data) {
        $UsuarioID=$data['Usuario'];
        $sqlEspecialidadID= $this->config_mdl->_query("SELECT * FROM um_especialidades, os_empleados WHERE
            um_especialidades.especialidad_id=os_empleados.empleado_servicio AND
            os_empleados.empleado_id='$UsuarioID'")[0];
        return $sqlEspecialidadID['especialidad_id'];

    }
    /*  Obtener el nombre de la especialidad por el id de especilidad */
     public function ObtenerNombreServicio($data) {
        $servicio_id=$data['servicio_id'];
        $sqlServicio= $this->config_mdl->_query("SELECT * FROM um_especialidades WHERE
            especialidad_id='$servicio_id'")[0];
        return $sqlServicio['especialidad_nombre'];

    }
    public function ObtenerPacienteUmae($data) {
        $nssCompleto = $data;
        $pacienteUmae = $this->config_mdl->sqlGetDataCondition('um_pacientes', array(
            'nssCom' => $nssCompleto
        ))[0]; 
        return $pacienteUmae['idPaciente'];
    }
    
    public function ObtenerInfoPacientePorFolio($data) {
        $folio = $data;
        $sql = $this->config_mdl->_get_data_condition('os_triage', array(
            'triage_id' => $folio
        ));

        if(empty($sql)) {
            $this->setOutput(array('accion'=>'1'));
        }else {
            $this->setOutput(array('accion'=>'2','info'=>$sql[0]));
        } 
    
    }
}