<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asistentesmedicas
 *
 * @author Gerardo Santillan
 */
include_once APPPATH.'modules/config/controllers/Config.php';

class Farmacovigilancia extends Config{

  public function __construct()
  {
    parent::__construct();
  }

  public function index(){
    $sql['Activas'] = $this->PacientePrescripcion('estado','2'); //activas
    $sql['Pendientes'] = $this->PacientePrescripcion('estado','1');//pendientes
    $sql['Canceladas'] = $this->PacientePrescripcion('estado','0');//canceladas
    $sql['PacientePrescripcionPendiente'] = $this->PacientePrescripcion();
    $this->load->view('index2',$sql);
  }
  
  public function Interacciones() {

    $this->load->view('interacciones');
  }
  public function AjaxCatalogoMedicamentos() {
     $draw = intval($this->input->post("draw"));
     $catalogo = $this->config_mdl->_get_data('catalogo_medicamentos');
     $datos = array();
     //$moderateInteraction = array();
     //$seriousInteraction = array();
        
      if(!empty($catalogo)) {
        foreach ($catalogo as $value) {
        
          $moderateInteraction= $this->SearchInteraction($value['interaccion_amarilla']);
          $seriousInteraction = $this->SearchInteraction($value['interaccion_roja']);
          

          $datos[] = array(
                    'nombre'        => $value['medicamento'],
                    'gramaje'       => $value['gramaje'],
                    'via'           => $value['via'],
                    'forma'         => $value['forma_farmaceutica'],
                    'categoria'     => $value['categoria_farmacologica'],
                    'dosis_max'     => $value['dosis_max'],
                    'interaccion_a' => $moderateInteraction,
                    'interaccion_r' => $seriousInteraction,
                    'acciones'      => '<a href="RegistrarPaciente/'.$value['triage_id'].'">
                                        <i class="fa fa-edit icono-accion tip" data-original-title="Editar datos"></i></a>'
                    );
          
        }
        $total = count($catalogo);
      }

       $output = array(
                        'draw' => $draw,
                        "recordsTotal" => $total,
                        "recordsFiltered" => $total,
                        'data' => $datos
        );


        $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));


  }

  public function SearchInteraction($interacciones) {
    
    $arreglo = explode("," ,$interacciones);
   // $miCadena  = '2,6,7,8,9,10';
   // $arreglo = explode(",", $miCadena); 
    //$query = $this->config_mdl->_get_data('catalogo_medicamentos');
    $i=0;
    foreach ($arreglo as $id) {
        $query = $this->config_mdl->sqlGetDataCondition('catalogo_medicamentos', array('medicamento_id'=>$id),'medicamento')[0];
        
          // $respuesta[$i] = array(
          //           'id' => $id,
          //           'nombre' => $query['medicamento']
          //         );  
        $respuesta[$i] = array($query['medicamento']);
     $i++;   
    }
        

    return $respuesta;
    
  }

  public function AjaxPrescripcionesPaciente(){
    $folio = $_GET['folio'];
    $consulta = "SELECT prescripcion_id, medicamento, prescripcion.via AS pr_via,
                  frecuencia, dosis, estado, interaccion_roja, interaccion_amarilla,
                  catalogo_medicamentos.medicamento_id AS id_medicamento
                 FROM prescripcion
                 INNER JOIN os_triage
                  ON os_triage.triage_id = prescripcion.triage_id
                 INNER JOIN catalogo_medicamentos
                  ON catalogo_medicamentos.medicamento_id = prescripcion.medicamento_id
                 WHERE os_triage.triage_id = $folio";
    $sql = $this->config_mdl->_query($consulta);
    print json_encode($sql);
  }

  public function AjaxBusqueda(){

    $filtro = $_GET['filtro'];
    $dato = $_GET['consulta'];
    if($filtro == 'triage_id'){
      $filtro = "os_triage.triage_id";
    }
    $condicion = "WHERE $filtro LIKE '%$dato%' ";
    $consulta = "SELECT os_triage.triage_id, area_nombre, triage_nombre, triage_nombre_ap,
                 medicamento , cama_nombre, empleado_nombre,
                 empleado_apellidos,estado
                 FROM prescripcion
                 INNER JOIN os_triage
                 	ON os_triage.triage_id = prescripcion.triage_id
                 INNER JOIN catalogo_medicamentos
                 	ON catalogo_medicamentos.medicamento_id = prescripcion.medicamento_id
                 INNER JOIN os_camas
                 	ON os_camas.triage_id = os_triage.triage_id
                 INNER JOIN os_areas
                 	ON os_areas.area_id = os_camas.area_id
                 INNER JOIN um_medico_tratante
                 	ON um_medico_tratante.triage_id = os_triage.triage_id
                 INNER JOIN os_empleados
                 	ON os_empleados.empleado_id = um_medico_tratante.empleado_id
                 $condicion";

    $sql = $this->config_mdl->_query($consulta);
    print json_encode($sql);


  }

  public function PacientePrescripcion($filtro, $dato){

    $condicion = '';

    if($dato == '0' || $dato == '1' || $dato == '2' ){
      $condicion = "WHERE $filtro = $dato";
    }
    $consulta = "SELECT os_triage.triage_id, area_nombre, triage_nombre, triage_nombre_ap,
                 medicamento , cama_nombre, empleado_nombre,
                 empleado_apellidos,estado
                 FROM prescripcion
                 INNER JOIN os_triage
                 	ON os_triage.triage_id = prescripcion.triage_id
                 INNER JOIN catalogo_medicamentos
                 	ON catalogo_medicamentos.medicamento_id = prescripcion.medicamento_id
                 INNER JOIN os_camas
                 	ON os_camas.triage_id = os_triage.triage_id
                 INNER JOIN os_areas
                 	ON os_areas.area_id = os_camas.area_id
                 INNER JOIN um_medico_tratante
                 	ON um_medico_tratante.triage_id = os_triage.triage_id
                 INNER JOIN os_empleados
                 	ON os_empleados.empleado_id = um_medico_tratante.empleado_id
                 $condicion";

    $sql = $this->config_mdl->_query($consulta);

    return $sql;
  }
  public function AjaxPacientePrescripcion(){

    $val = $this->PacientePrescripcion($_GET['filtro'],$_GET['estado']);
    print json_encode($val);
  }

  public function AsignarColorEstadoPrescripcion($estado){

    switch ($estado) {
      case '0':
        return 'rgb(242, 222, 222)';
      case '1':
        return 'rgb(252, 248, 227)';
      case '2':
        return 'rgb(223, 240, 216)';

    }

  }
  public function AjaxActivarPrescrpciones(){

    $prescripcion_id = $this->input->get('prescripcion_id');
    $consultar_estado = "SELECT estado FROM prescripcion WHERE prescripcion_id = $prescripcion_id";
    $resultado_estado = $this->config_mdl->_query($consultar_estado);

    $nuevo_estado = 0;
    if($resultado_estado[0]['estado'] == 1){
      $nuevo_estado = 2;
    }else if($resultado_estado[0]['estado'] == 2){
      $nuevo_estado = 1;
    }

    $this->config_mdl->_update_data('prescripcion',
                                    array('estado' => $nuevo_estado),
                                    array('prescripcion_id' => $prescripcion_id)
                                    );
  }


  public function AjaxGestionMensajePrescripcion(){
    $prescripcion_id = $_GET['prescripcion_id'];
    $mensaje_prescripcion = $_GET['mensaje_prescripcion'];

    if($this->VerificarExistenciaMensajePrescripcion($prescripcion_id)){

        if($mensaje_prescripcion == ''){
          $this->BorrarMensajePrescripcion($prescripcion_id);
          $mensaje = array('mensaje' => 'Delete' );
        }else{
          $this->ActualizarMensajePrescripcion($prescripcion_id, $mensaje_prescripcion);
          $mensaje = array('mensaje' => 'Update' );
        }

    }else{
      $this->RegistrarMensajePrescripcion($prescripcion_id, $mensaje_prescripcion);
      $mensaje = array('mensaje' => 'Insert' );
    }

    print json_encode($mensaje);
  }

  public function RegistrarMensajePrescripcion($prescripcion_id, $mensaje){
    $sql = "INSERT INTO um_notificaciones_prescripciones(notificacion, prescripcion_id)
            VALUES('$mensaje' , $prescripcion_id)";

    return $this->config_mdl->_query($sql);

  }

  public function VerificarExistenciaMensajePrescripcion($prescripcion_id){
    $query = "SELECT notificacion_id
              FROM um_notificaciones_prescripciones
              WHERE prescripcion_id = $prescripcion_id";
    return $this->config_mdl->_query($query);
  }

  public function BorrarMensajePrescripcion($prescripcion_id){
    $query = "DELETE FROM um_notificaciones_prescripciones
              WHERE prescripcion_id = $prescripcion_id";
    return $this->config_mdl->_query($query);
  }

  public function ActualizarMensajePrescripcion($prescripcion_id, $mensaje){
    $query = "UPDATE um_notificaciones_prescripciones
              SET notificacion =  '$mensaje'
              WHERE prescripcion_id = $prescripcion_id ";
    return $this->config_mdl->_query($query);
  }

  public function ConsultarMensajePrescripcion($prescripcion_id){
    $consulta = "SELECT notificacion, prescripcion_id, notificacion_id
              FROM um_notificaciones_prescripciones
              WHERE prescripcion_id = $prescripcion_id";
    $query = $this->config_mdl->_query($consulta);
    return $query;
  }

  public function AjaxConsultarMensajePrescripcion(){
    $prescripcion_id = $_GET['prescripcion_id'];
    $consultar_mensaje = $this->ConsultarMensajePrescripcion($prescripcion_id);

    $resultado_array = array('num_resultados' => count($consultar_mensaje),
                              'consulta' => $consultar_mensaje);

    print json_encode($resultado_array);

  }

  public function Catalogo() {

    $this->load->view('catalogo', $sql);
  }

  //consulta para ver el total de las preinscripcion sin revisar
  public function PreinscripcionesTotales() {
    $query1 ="SELECT idp,os_triage.triage_nombre, os_empleados.empleado_nombre, os_empleados.empleado_apellidos, um_especialidades.especialidad_nombre,fecha,idp
    FROM prescripcion_history INNER JOIN os_triage ON prescripcion_history.triage_id = os_triage.triage_id
                              INNER JOIN os_empleados ON prescripcion_history.medico_id = os_empleados.empleado_id
                              INNER JOIN um_especialidades ON prescripcion_history.servicio_id = um_especialidades.especialidad_id
                              WHERE revision_fv = 0";
   $sql['nuevas_pre'] = $this->config_mdl->_query($query1);
   $sql['total_nuevos_med'] = $this->config_mdl->_query("SELECT COUNT(idp) AS total FROM prescripcion  WHERE verifica_fv = 0");
   $sql['revisados'] = $this->config_mdl->_query("SELECT COUNT(idp) AS revisados FROM prescripcion WHERE verifica_fv = 1");
   $this->load->view('Farmacovigilancia/nuevas_preinscripciones',$sql);
  }

  //funcion para verificar la preinscripcion
  public function PrescripcionesRevisadas(){
    $idp = $this->input->post('idp');
    $variables = array(
    'revision_fv' => 1
    );
    $condiciones = array(
      'idp' => $this->input->post('idp')
    );
    $sql = $this->config_mdl->_update_data('prescripcion_history',$variables ,$condiciones);
    if($sql){
      $mensaje = array(
        "mensaje" => "La revision de la preinscripcion fue exitosa",
      );
    }
    else{
      $mensaje = array(
        "mensaje" => "El estado no pudo modificarse",
      );
    }
    print json_encode($mensaje);
  }
  
   //funcion para verificar el medicamento
   public function VerificarMedicamento(){
    $variables = array(
    'verifica_fv' => 1
    );
    $condiciones = array(
      'prescripcion_id' => $this->input->post('id_medicamento')
    );
    $sql = $this->config_mdl->_update_data('prescripcion',$variables ,$condiciones);
    if($sql){
      $mensaje = "La revision del Medicamento fue exitosa";
    }
    else{
      $mensaje = "El estado no pudo modificarse";
    }
    
    $medSinRevisar = count($this->config_mdl->_query("SELECT (idp) AS total FROM prescripcion  WHERE verifica_fv = 0"));
    $medRevisados  = count($this->config_mdl->_query("SELECT (idp) AS total FROM prescripcion  WHERE verifica_fv = 1"));

      $this->setOutput(array(
      'mensaje'       => $mensaje,
      'medSinRevisar' => $medSinRevisar,
      'medRevisados'  => $medRevisados
    ));
  }

}
