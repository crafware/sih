<?php
require_once APPPATH.'modules/config/controllers/Config.php';
class Prescripcion extends Config{
  public function index() {
      die('ACCESO NO PERMITIDO');
  }

  public function Prescripciones($folio) {
    $datos = array();
    $draw = intval($this->input->post("draw"));
    $start = intval($this->input->post("start"));
    $length = intval($this->input->post("length"));
    $order = $this->input->post("order");
    $search= $this->input->post("search");
    $search = $search['value'];
    $col = 0;
    $dir = "";

    $registros = $this->config_mdl->sqlGetDataCondition('prescripcion',array(
            'triage_id' => $folio
        ));
    $total_medicamentos = count($registros);
  

    if(!empty($registros)) {
      foreach ($registros  as $value) {
        $npt = $this->config_mdl->sqlGetDataCondition('prescripcion_npt',array(
                     'prescripcion_id'=>$value['prescripcion_id']))[0];

        $onco_antimicrobiano = $this->config_mdl->sqlGetDataCondition('prescripcion_onco_antimicrobianos',array(
                     'prescripcion_id'=>$value['prescripcion_id']))[0];
        $nombre_medicamento = $this->config_mdl->sqlGetDataCondition('catalogo_medicamentos', array(
                      'medicamento_id' => $value['medicamento_id']), 'medicamento')[0];
        $medico_indica = $this->config_mdl->sqlGetDataCondition('os_empleados', array(
                      'empleado_id' => $value['empleado_id']), 'empleado_nombre, empleado_apellidos')[0];
        if($value['tiempo'] == 0) {
          $duracion = 'dosis única';
        }else $duracion = 'por'.' '.$value['tiempo'].' '.$value['periodo'];

        $datos[] = array(
                     'folio'              => $value['prescripcion_id'],
                     'triage_id'          => $value['triage_id'],
                     'medicamento_id'     => $value['medicamento_id'],
                     'medicamento_nombre' => $nombre_medicamento['medicamento'],
                     'medico_indica'      => $medico_indica['empleado_apellidos'].' '.$medico_indica['empleado_nombre'],
                     'fecha_prescripcion' => $value['fecha_prescripcion'],
                     'fecha_inicio'       => $value['fecha_inicio'],
                     'fecha_final'        => $value['fecha_fin'],
                     'dosis'              => $value['dosis'],  
                     'frecuencia'         => $value['frecuencia'], 
                     'via'                => $value['via'],
                     'aplicacion'         => $value['aplicacion'], 
                     'duracion'           => $duracion,
                     'periodo'            => $vale['periodo'],
                     'aplicacion'         => $value['aplicacion'],
                     'observaciones'      => $value['observaciones'], 
                     'acciones'           => '<a href="RegistrarPaciente/'.$value['prescripcion_id'].'">
                                              <i class="fa fa-edit icono-accion tip" data-original-title="Editar datos"></i></a>'
                    ); 
      }
      

    }
    $output = array(
                  'draw'            => $draw,
                  "recordsTotal"    => $total_medicamentos,
                  "recordsFiltered" => $total_medicamentos,
                  'data'            => $datos
                );
    $this->output->set_content_type('application/json')
                 ->set_output(json_encode($output)); 
  
  }

  public function Agregar($paciente) {
    $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $paciente))[0];

    $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$paciente))[0];

    $sql['medicamentos'] = $this->config_mdl->_query("SELECT medicamento_id, CONCAT(medicamento,' ',forma_farmaceutica) AS medicamento, interaccion_amarilla,
                                                      interaccion_roja FROM catalogo_medicamentos WHERE existencia = 1 ORDER BY medicamento");

    $sql['Vias'] = array('(cerebelomedular)','Auricular (ótica)','Bolo Intravenoso','Bucal','campo eléctrico','Conjuntival','Cutánea','Dental',
        'Electro-osmosis','En los ventrículos cerebrales','Endocervical','Endosinusial','Endotraqueal','Enteral','Epidural','Extra-amniótico',
        'Gastroenteral','Goteo Intravenoso','In vitro','Infiltración','Inhalatoria','Intercelular','Intersticial','Intra corpus cavernoso',
        'Intraamniótica','Intraarterial','Intraarticular','Intrabdominal','Intrabiliar','Intrabronquial','Intrabursal','Intracardiaca',
        'Intracartilaginoso','Intracaudal','Intracavernosa','Intracavitaria','Intracerebral','Intracervical','Intracisternal','Intracorneal',
        'Intracoronaria','Intracoronario','Intradérmica','Intradiscal','Intraductal','Intraduodenal','Intradural','Intraepidermal','Intraesofágica',
        'Intraesternal','Intragástrica ','Intragingival','Intrahepática','Intraileal','Intramedular','Intrameníngea','Intramuscular','Intraocular',
        'Intraovárica','Intrapericardial','Intraperitoneal','Intrapleural','Intraprostática','Intrapulmonar','Intrasinovial',
        'Intrasinusal (senosparanasales)','Intratecal','Intratendinosa','Intratesticular','Intratimpánica','Intratoráxica','Intratraqueal',
        'Intratubular','Intratumoral','Intrauterina','Intravascular','Intravenosa','Intraventricular','Intravesicular','Intravítrea','Iontoforesis',
        'Irrigación','la túnica fibrosa del ojo)','Laríngeo','Laringofaringeal','médula espinal)','Nasal','Oftálmica','Oral','Orofaríngea',
        'Otra Administración es diferente de otros contemplados en ésta lista','Parenteral','Párpados y la superficie del globo ocular',
        'Percutánea','Periarticular','Peridura','Perineural','Periodontal','Por difusión','Rectal','Retrobulbal','Sistémico','Sonda nasogástrica',
        'Subaracnoidea','Subconjuntival','Subcutánea','Sublingual','Submucosa','Técnica de vendaje oclusivo','Tejido blando','tejidos del cuerpo',
        'Tópica','Transdérmica','Transmamaria','Transmucosa','Transplacentaria','Transtimpánica','Transtraqueal','Ureteral','Uretral',
        'Uso Intralesional','Uso Intralinfático','Uso oromucosa','Vaginal','Vía a través de Hemodiálisis');
    
    $this->load->view('Documentos/Prescripcion',$sql);

  }

  public function AjaxGuardarPrescripcion($data){
    /*$query = $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=>  $this->UMAE_USER
    ))[0];*/
    //$matricula = $this->input->post('medicoMatricula');
    /*$sql['medicoBaseId'] = $this->config_mdl->_query("SELECT empleado_id, empleado_servicio, empleado_roles
                                                         FROM os_empleados WHERE empleado_matricula = '$matricula'");
    if(empty($sql['medicoBaseId'])) { // Si es un médico de base qioe realiza la nota no selecciona otro
        $medicoTratante = $this->UMAE_USER;
        $servicio = Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER));
    }else {
        $medicoTratante = $sql['medicoBaseId'][0]['empleado_id'];
        $servicio =  $sql['medicoBaseId'][0]['empleado_servicio'];
    }*/
    $medico_id = $data['medicoTratante'];
    $servicio_id = $data['servicio'];
    
    $datos = array(
        "medico_id"   => $medico_id,  
        "servicio_id" => $servicio_id,
        "triage_id"   => $this->input->post('triage_id'),
        "fecha"       => date('Y-m-d')." ".date('H:i'),
        "revision_fv" => '0'

      );
    
    $sql = $this->config_mdl->_insert("prescripcion_history" , $datos);
    $idPrescripcion = $this->config_mdl->_get_last_id('prescripcion_history','idp');
   

    for($x = 0; $x < count($this->input->post('idMedicamento')); $x++){
      $observacion = $this->input->post("observacion[$x]");
      $otroMedicamento = $this->input->post("nomMedicamento[$x]");
      if($this->input->post("idMedicamento[$x]") == '1'){
        $observacion = $otroMedicamento.'-'.$observacion;
      }
      $datosPrescripcion = array(
        'idp'                 => $idPrescripcion,
        'empleado_id'         => $this->UMAE_USER,
        'triage_id'           => $this->input->post('triage_id'),
        'medicamento_id'      => $this->input->post("idMedicamento[$x]"),
        'dosis'               => $this->input->post("dosis[$x]"),
        'fecha_prescripcion'  => date('d-m-Y')." ".date('H:i'),
        'via'                 => $this->input->post("via_admi[$x]"),
        'frecuencia'          => $this->input->post("frecuencia[$x]"),
        'aplicacion'          => $this->input->post("horaAplicacion[$x]"),
        'fecha_inicio'        => $this->input->post("fechaInicio[$x]"),
        'tiempo'              => $this->input->post("duracion[$x]"),
        'periodo'             => $this->input->post("periodo[$x]"),
        'fecha_fin'           => $this->input->post("fechaFin[$x]"),
        'observacion'         => $observacion,
        'estado'              => "1"
              );
      $this->config_mdl->_insert('prescripcion',$datosPrescripcion);
    }
    //Número de antibioticos apt
    for($x = 0; $x < count( $this->input->post('idMedicamento_npt')); $x++){
      //Se guardan en un arreglo los datos del medicamento
      $datosPrescripcion = array(
        'empleado_id'         => $this->UMAE_USER,
        'triage_id'           => $this->input->post('triage_id'),
        'medicamento_id'      => $this->input->post("idMedicamento_npt[$x]"),
        'via'                 => $this->input->post("via_admi[$x]"),
        'fecha_prescripcion'  => $fecha_actual,
        'dosis'               => $this->input->post("dosis[$x]"),
        'fecha_prescripcion'  => date('d-m-Y')." ".date('H:i'),
        'frecuencia'          => $this->input->post("frecuencia[$x]"),
        'aplicacion'          => $this->input->post("horaAplicacion[$x]"),
        'fecha_inicio'        => $this->input->post("fechaInicio[$x]"),
        'tiempo'              => $this->input->post("duracion[$x]"),
        'periodo'             => $this->input->post("periodo[$x]"),
        'fecha_fin'           => $this->input->post("fechaFin[$x]"),
        'observacion'         => $this->input->post("observacion[$x]"),
        'estado'              => "1"
      );
      //Se registra el medicamento
      $this->config_mdl->_insert('prescripcion',$datosPrescripcion);
      //Se consulta la ultima prescripcion registrada
      $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion','prescripcion_id');
      /*
      Se toman los datos necesarios para un npt
      con la variable $ultima_prescripcion, identificamos la prescripcion con la que se
      asocia prescripcion y npt
      */
      $datos_npt = array(
        'prescripcion_id' => $ultima_prescripcion,
        'aminoacido'      => $this->input->post("aminoacido[$x]"),
        'dextrosa'        => $this->input->post("dextrosa[$x]"),
        'lipidos'         => $this->input->post("lipidos_intravenosos[$x]"),
        'agua_inyect'     => $this->input->post("agua_inyectable[$x]"),
        'cloruro_sodio'   => $this->input->post("cloruro_sodio[$x]"),
        'sulfato'         => $this->input->post("sulfato_magnesio[$x]"),
        'cloruro_potasio' => $this->input->post("cloruro_potasio[$x]"),
        'fosfato'         => $this->input->post("fosfato_potasio[$x]"),
        'gluconato'       => $this->input->post("gluconato_calcio[$x]"),
        'albumina'        => $this->input->post("albumina[$x]"),
        'heparina'        => $this->input->post("heparina[$x]"),
        'insulina'        => $this->input->post("insulina_humana[$x]"),
        'zinc'            => $this->input->post("zinc[$x]"),
        'mvi'             => $this->input->post("mvi_adulto[$x]"),
        'oligoelementos'  => $this->input->post("oligoelementos[$x]"),
        'vitamina'        => $this->input->post("vitamina[$x]")
      );
      $this->config_mdl->_insert('prescripcion_npt', $datos_npt);
    }
    //Número de antibioticos antimicrobiano u oncologico
    for($x = 0; $x < count( $this->input->post('idMedicamento_onco_antimicro')); $x++){
      $datosPrescripcion = array(
          'empleado_id'         => $this->UMAE_USER,
          'triage_id'           => $this->input->post('triage_id'),
          'medicamento_id'      => $this->input->post("idMedicamento_onco_antimicro[$x]"),
          'dosis'               => $this->input->post("dosis[$x]"),
          'fecha_prescripcion'  => date('d-m-Y')." ".date('H:i'),
          'via'                 => $this->input->post("via[$x]"),
          'frecuencia'          => $this->input->post("frecuencia[$x]"),
          'aplicacion'          => $this->input->post("horaAplicacion[$x]"),
          'fecha_inicio'        => $this->input->post("fechaInicio[$x]"),
          'tiempo'              => $this->input->post("duracion[$x]"),
          'periodo'             => $this->input->post("periodo[$x]"),
          'fecha_fin'           => $this->input->post("fechaFin[$x]"),
          'observacion'         => $this->input->post("observacion[$x]"),
          'estado'              => "1"
      );
      $this->config_mdl->_insert('prescripcion',$datosPrescripcion);
      $ultima_prescripcion = $this->config_mdl->_get_last_id('prescripcion','prescripcion_id');
      $categoria_safe = $this->input->post("categoria_safe[$x]");
      $datos_onco_antimicrobiano = array(
        'prescripcion_id' => $ultima_prescripcion,
        'categoria_safe'  => $categoria_safe,
        'diluente'        => $this->input->post("diluyente[$x]"),
        'vol_dilucion'    => $this->input->post("vol_diluyente[$x]")
      );
      $this->config_mdl->_insert('prescripcion_onco_antimicrobianos', $datos_onco_antimicrobiano);
    }

    $Prescripciones = $this->config_mdl->_query("SELECT prescripcion_id
                                                         FROM prescripcion
                                                         WHERE estado = 1 and triage_id = ".$this->input->post('triage_id').";");
    for($x = 0; $x < count($Prescripciones); $x++){
      $NotaPrescripcion = array(
        'notas_id' => $this->config_mdl->_get_last_id('doc_notas','notas_id'),
        'prescripcion_id' => $Prescripciones[$x]['prescripcion_id']
      );
      // Se registra la relacion entre notas y prescripcion
      $this->config_mdl->_insert('nm_notas_prescripcion', $NotaPrescripcion);
    }
    $this->setOutput(array('accion'=>'1'));
  }

  public function AjaxPrescripciones(){
    $estado = $_GET['estado'];
    $sql['Prescripcion'] = $this->config_mdl->_query("SELECT catalogo_medicamentos.medicamento_id AS id_medicamento, medicamento, categoria_farmacologica,
                                                        fecha_prescripcion, dosis, observacion, prescripcion.via AS via_administracion, frecuencia, aplicacion,
                                                        fecha_inicio, tiempo, periodo, fecha_fin, prescripcion_id, estado
                                                        FROM prescripcion INNER JOIN catalogo_medicamentos ON
                                                        prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                        INNER JOIN os_triage ON prescripcion.triage_id = os_triage.triage_id
                                                        WHERE os_triage.triage_id =".$_GET['folio']." AND estado !=0");

    print json_encode($sql['Prescripcion']);
  }

  public function ImprimirPrescripciones($idp) {

    $sql['Prescripcion'] = $this->config_mdl->_get_data_condition('prescripcion',array(
            'idp'=>  $idp ))[0];

    $sql['Prescripcion_history'] = $this->config_mdl->_get_data_condition('prescripcion_history',array(
            'idp'=>  $idp ))[0];
    $triage_id = $sql['Prescripcion_history']['triage_id'];

    $sql['nombreMedicamento']= $this->config_mdl->_get_data_condition('catalogo_medicamentos',array(
           'medicamento_id'=> $sql['Prescripcion']['medicamento_id'] ))[0];

    $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id' => $sql['Prescripcion_history']['triage_id'] ))[0];

    $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id' => $sql['Prescripcion_history']['triage_id'] ))[0];

    $sql['DirPaciente']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Paciente',
            'triage_id' => $sql['Prescripcion_history']['triage_id'] ))[0];
    $sql['Servicio'] = Modules::run('Config/ObtenerNombreServicio',array('servicio_id' =>  $sql['Prescripcion_history']['servicio_id']));

    /* SQL medicamentos normales */
    $sql['Prescripcion_Basico'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos INNER JOIN prescripcion
                                                                   ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                   WHERE idp=$idp AND safe = 0;");

     $sql['Prescripcion_Onco_Anti'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                    INNER JOIN prescripcion
                                                                      ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                    INNER JOIN prescripcion_onco_antimicrobianos
                                                                      ON prescripcion.prescripcion_id = prescripcion_onco_antimicrobianos.prescripcion_id
                                                                    WHERE idp =$idp AND safe = 1;");

    $this->load->view('inicio/documentos/Prescripcion',$sql);
    
  }
  
}