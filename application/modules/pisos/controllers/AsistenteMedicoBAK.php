<?php
/*=====    ======*/
include_once APPPATH.'modules/config/controllers/Config.php';
class AsistenteMedico extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->view('AsistenteMedicoBAK');
    }

    public function ObtenerPisos() {
        if($this->UMAE_AREA=='Hospitalización Piso 1A'){
            return 1;
        }if($this->UMAE_AREA=='Hospitalización Piso 2A'){
            return 2;
        }if($this->UMAE_AREA=='Hospitalización Piso 3A'){
            return 3;
        }if($this->UMAE_AREA=='Hospitalización Piso 4A'){
            return 4;
        }if($this->UMAE_AREA=='Hospitalización 1B UCI'){
            return 5;
        }if($this->UMAE_AREA=='Hospitalización 1B UTR'){
            return 6;
        }if($this->UMAE_AREA=='Hospitalización 1B UTMO'){
            return 7;
        }if($this->UMAE_AREA=='Hospitalización Piso 2B Sur'){
            return 8;
        }if($this->UMAE_AREA=='Hospitalización Piso 2B Norte'){
            return 9;
        }if($this->UMAE_AREA=='Hospitalización Piso 3B Sur'){
            return 10;
        }if($this->UMAE_AREA=='Hospitalización Piso 3B Norte'){
            return 11;
        }if($this->UMAE_AREA=='Hospitalización Piso 4B Sur'){
            return 12;
        }if($this->UMAE_AREA=='Hospitalización Piso 4B Norte'){
            return 13;
        }if($this->UMAE_AREA=='Hospitalización Piso 5B Sur'){
            return 14;
        }if($this->UMAE_AREA=='Hospitalización Piso 5B Norte'){
            return 15;
        }
        
    }
    /*FUNCIONES VIA AJAX*/
    public function AjaxCamas() {
        $Camas=  $this->config_mdl->_query("SELECT * FROM os_camas, os_pisos, os_pisos_camas, os_areas
                                            WHERE
                                            os_areas.area_id=os_camas.area_id AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id AND
                                            os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_pisos.piso_id=".$this->ObtenerPisos()." ORDER BY os_camas.cama_id ASC");
       
        if(!empty($Camas)){
            foreach ($Camas as $value) {
                $sqlTriage=  $this->config_mdl->_query("SELECT * FROM os_triage, os_areas_pacientes, os_camas WHERE 
                        os_areas_pacientes.triage_id=os_triage.triage_id AND
                        os_areas_pacientes.cama_id=os_camas.cama_id AND os_triage.triage_id=".$value['triage_id']);

                $sqlEnfermera= $this->config_mdl->_get_data_condition('os_empleados',array('empleado_id'=>$sqlTriage[0]['empleado_id_ingreso']));

                $Paciente='';
                $Enfermera='';
                $Accion='';
                $Lista='';
                $Status='';
                $ColorSexo='';
                $Sexo='';
                if(!empty($sqlTriage)){
                    $NombrePaciente=$sqlTriage[0]['triage_nombre'].' '.$sqlTriage[0]['triage_nombre_ap'].' '.$sqlTriage[0]['triage_nombre_am'];
                    if(strlen($NombrePaciente)>35){
                        $Paciente= mb_substr($NombrePaciente,0, 35,'UTF-8').'...';
                    }else{
                        $Paciente=$NombrePaciente;
                    }
                }
                if(!empty($sqlEnfermera)){
                    $NombreEnfermera=$sqlEnfermera[0]['empleado_nombre'].' '.$sqlEnfermera[0]['empleado_apellidos'];
                    if(strlen($NombreEnfermera)>35){
                        $Enfermera='<b>ENF.:</b> '.mb_substr($NombreEnfermera,0, 35,'UTF-8').'...'.' <i class="fa fa-user-md pull-right pointer cambiar-enfermera i-16" style="margin-top:-3px" data-area="'.$sqlTriage[0]['ap_area'].'" data-id="'.$sqlTriage[0]['triage_id'].'"></i>';
                    }else{
                        $Enfermera='<b>ENF.:</b> '.$NombreEnfermera.' <i class="fa fa-user-md pull-right pointer cambiar-enfermera i-16" style="margin-top:-3px" data-area="'.$sqlTriage[0]['ap_area'].'" data-id="'.$sqlTriage[0]['triage_id'].'"></i>';
                        
                    }
                }
                
                if($value['cama_status']=='Disponible'){  // Verde --Disponible
                    $CamaStatus='green';
                    
            /*        if(!empty($sqlCheck43051)){
                        $Accion='<button md-ink-ripple="" class="md-btn md-fab m-b green waves-effect tip btn-paciente-agregar-ah" data-triage="'.$sqlCheck43051[0]['triage_id'].'" data-status="'.$value['cama_status'].'" data-cama="'.$value['cama_id'].'" data-area="'.$value['area_id'].'" >
                                <i class="mdi-content-add i-24" ></i>
                            </button>';
                    }else{
                        $Accion='<button md-ink-ripple="" class="md-btn md-fab m-b green waves-effect tip btn-paciente-agregar" data-triage="0" data-status="'.$value['cama_status'].'" data-cama="'.$value['cama_id'].'" data-area="'.$value['area_id'].'" >
                                <i class="mdi-content-add i-24" ></i>
                            </button>';
                    } */
                    
                    $area=$value['cama_status'];
                }else if($value['cama_status']=='En Mantenimiento'){ // Color Naranja
                    $CamaStatus='orange';
                    $area=$value['cama_status'];
                /*    $Accion='<ul class="list-inline">
                                <li class="dropdown">
                                    <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                        <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">
                                        <li><a class="finalizar-mantenimiento" data-id="'.$value['cama_id'].'"><i class="fa fa-wrench icono-accion"></i> Finalizar Mantenimiento</a></li>
                                    </ul>
                                </li>
                            </ul>'; */
                }else if($value['cama_status']=='En Limpieza'){ // Color  Negro
                    $CamaStatus='grey-900';
                    $area=$value['cama_status'];
              /*      $Accion='<ul class="list-inline">
                                <li class="dropdown">
                                    <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                        <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">
                                        <li><a class="finalizar-mantenimiento" data-id="'.$value['cama_id'].'"><i class="fa fa-wrench icono-accion"></i> Finalizar Limpieza</a></li>
                                    </ul>
                                </li>
                            </ul>'; */
                }else if($value['cama_status']=='Ocupado'){  // Cama - Ocupado 
                    if($value['cama_genero']=='HOMBRE') {  // Ocupado-Azul Hombre  color Azul       
                        $CamaStatus='blue-800';
                    }else if($value['cama_genero']=='MUJER'){ // Ocupado-Rosa Mujer  color Rosa
                        $CamaStatus='pink-500';
                    }
                    $Lista.='<li><a href="" class="reportar-cama-descompuesta" data-id="'.$sqlTriage[0]['triage_id'].'" data-piso="'.$value['piso_id'].'" data-cama="'.$value['cama_id'].'"><i class="fa fa fa-wrench icono-accion"></i> Reportar como descompuesta</a></li>';

                    if($sql_paciente[0]['ap_area']!=''){
                        $sql_area= $this->config_mdl->_query("SELECT * FROM os_areas WHERE area_id=".$sqlTriage[0]['ap_area'])[0];
                        $ap_area='<span style="text-transform:uppercase;">&nbsp;<b>'.$sql_area['area_nombre'].'</b></span>';
                    }else{
                        $ap_area='<span style="text-transform:uppercase;">&nbsp;<b>Sin Especificar </b></span>';
                    }

                    $area=$ap_area.'&nbsp;<i class="fa fa-pencil pointer cambiar-area" data-id="'.$sqlTriage[0]['ap_id'].'"></i>';  
                    $Lista.='<li><a class="alta-paciente" data-area="'.$value['area_id'].'" data-alta="'.$sqlTriage[0]['observacion_alta'].'" data-cama="'.$value['cama_id'].'" data-triage="'.$sqlTriage[0]['triage_id'].'"><i class="fa fa-share-square-o icono-accion"></i> Alta Paciente</a></li>';
                    $Lista.='<li><a class="add-tarjeta-identificacion"  data-area="'.$sqlTriage[0]['ap_area'].'" data-id="'.$sqlTriage[0]['triage_id'].'" ><i class="fa fa-address-card-o icono-accion"></i> Tarjeta de Identificación</a></li>';
                    $Lista.='<li><a class="cambiar-cama-paciente" data-id="'.$sqlTriage[0]['triage_id'].'" data-area="'.$sqlTriage[0]['ap_area'].'" data-cama="'.$value['cama_id'].'" data_sexo="'.$value['cama_genero'].'"><i class="fa fa-bed icono-accion"></i> Cambiar Cama</a></li>';
                    $Lista.='<li><a href="'.  base_url().'Sections/Documentos/Expediente/'.$sqlTriage[0]['triage_id'].'/?tipo=Observación&url=Enfermeria" target="_blank"><i class="fa fa-files-o icono-accion"></i> Archivos Anexos</a></li>';
                    $Accion='<ul class="list-inline">
                            <li class="dropdown">
                                <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                    <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">'.$Lista.'</ul>
                            </li>
                        </ul>';
                }else if($value['cama_status']=='Descompuesta'){ // Amarilla
                    $Status='<i class="fa fa-exclamation-triangle mensaje-cama-decompuesta pointer"></i>';
                    $CamaStatus='yellow-500';
                }else if ($value['cama_status']=='Limpia') {     // Cian
                    $CamaStatus='cyan-400';
                }else if($value['cama_status']=='En Espera'){  // Color Morado  Reservada
                    $CamaStatus='deep-purple-400';
                    $sql43051= $this->config_mdl->sqlGetDataCondition('doc_43051',array(
                        'cama_id'=>$value['cama_id'],
                        'ac_estatus'=>'Asignado'));
                    $Accion='<ul class="list-inline">
                                <li class="dropdown">
                                    <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                        <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">
                                        <li><a class="ConfirmarIngreso" data-id="'.$value['cama_id'].'" data-name="'.$value['cama_nombre'].'" data-area="'.$value['area_id'].'" data-triage="'.$sql43051[0]['triage_id'].'"><i class="fa fa-bed icono-accion"></i> Confirmar Ingreso Paciente</a></li>
                                    </ul>
                                </li>
                            </ul>';
                }
                if($value['cama_fh_estatus']!=''){
                    $TT= Modules::run('Config/CalcularTiempoTranscurrido',array(
                        //'Tiempo1'=>$value['cama_fh_estatus'],
                        'Tiempo1'=>'2018-01-24 14:18:39',
                        'Tiempo2'=> date('Y-m-d H:i:s')
                    ));
                    $TT_=$TT->d.' Dias '.$TT->h.' Hrs '.$TT->i.' Min ';
                }else{
                    //$TT_='No se puede determinar';
                }
                $col_md_3.='<div class="col-md-3 cols-camas" style="padding: 3px;margin-top:-20px">
                                <div class="card '.$CamaStatus.' color-white" style="border-radius:3px">
                                    <div style="position:relative">
                                        <!--<div style="position: absolute;width: 10px;height: 112px;top: 25px;" class="'.$ColorSexo.'">
                                        </div> -->
                                    </div>
                                    <div class="row" style=" background: #256659!important;padding: 4px 2px 2px 12px;width: 100%;margin-left: 0px; font-size:7px">
                                        <div class="col-md-12" style="padding-left:0px;"><b style="text-transform:uppercase;font-size:10px"><i class="fa fa-window-restore"></i> '.$Paciente.'</b></div>
                                    </div>
                                    <div class="card-heading" style="margin-top:-10px;padding-bottom: 0px!important;">
                                        <h5 class="font-thin color-white" style="font-size:24px!important;margin-left: -11px;margin-top: -10px">
                                            <i class="fa fa-bed" ></i><b> '.$value['cama_nombre'].' '.$Status.'</b>
                                            <div style="position: absolute;right: 12px;top: 12px;text-transform: none; font-size:12px">'.$TT_.'</div>
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin-left: -10px;margin-top:-9px">
                                            <small style="opacity: 1;font-size: 10px"> 
                                                <b class="text-left"><i style="font-size:14px" class="fa fa-address-book-o"></i> '.$area.'&nbsp;&nbsp;&nbsp;&nbsp;</b>
                                                <b class="text-right pull-right"> '.$sqlTriage[0]['ap_f_ingreso'].' '.$sqlTriage[0]['ap_h_ingreso'].'</b>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="card-tools" style="right:2px;top:-10px">'.$Accion.'</div>
                                    <div class="card-body" style="margin-top:-20px;margin-left:-11px;padding-bottom: 8px;">
                                        <p style="margin-top: -7px;font-size: 10px;margin-bottom: 5px;"> '.$Enfermera.'</p>
                                    </div>
                                </div>
                            </div>';
                $col_md_3.='';
            } //  cierre de foreach
        }else{
            $col_md_3='NO_HAY_CAMAS';
        }
        $this->setOutput(array('result_camas'=>$col_md_3));
    }
    public function AjaxObtenerPaciente(){
        $sql= $this->config_mdl->sqlGetDataCondition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ),'cama_id,ap_status');
        if(!empty($sql)){
            if($sql[0]['ap_status']=='Ingreso'){
                $this->setOutput(array('accion'=>'EN_PISOS'));
            }else if($sql[0]['ap_status']=='Salida'){
                $this->setOutput(array('accion'=>'ALTA_DE_PISOS'));
            }
        }else{
            $this->setOutput(array('accion'=>'NO_EXISTE_EN_PISOS'));
        }
    }
    public function AjaxConfirmarIngreso () {
        $sql43051= $this->config_mdl->sqlGetDataCondition('doc_43051',array(
            'ac_estatus'=>'Asignado',
            'triage_id'=> $this->input->post('triage_id') ));
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_fh_estatus'=> date('Y-m-d H:i:s'),
        ),array(
            'cama_id'=> $this->input->post('cama_id')
        ));    
        $data=array(
            'estado_tipo'=>'Ocupado',
            'estado_fecha'=>date('Y-m-d'),
            'estado_hora'=>date('H:i:s'),
            'cama_id'=> $this->input->post('cama_id'),
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=>$this->input->post('triage_id'),
            );
        $this->config_mdl->_insert('os_camas_estados', $data); 
        $this->config_mdl->_insert('os_areas_pacientes', array(
            'area_id'=> $this->input->post('area_id'),
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id'),
            //'idmedico_tratante'=> $this->input->post('empleado_id'),
            'ap_f_ingreso'=> date('Y-m-d'),
            'ap_h_ingreso'=> date('H:i'),
            'ap_status'=>'Ingreso',
            'ap_origen'=> $this->input->post('ap_origen'),
            'idpersona_ingresa'=> $this->UMAE_USER, 
            ));
        $this->config_mdl->_update_data('doc_43051',array(
                'ac_cama_estatus'=>'Ocupado',
            ),array(
                'ac_estatus'=>'Asignado',
                'triage_id'=> $this->input->post('triage_id'),
            ));
        
        Modules::run('Pisos/Camas/LogPisos',array(
            'log_tipo'=>'Ingreso',
            'log_obs'=>'Ingreso',
            'log_alta'=>'N/A',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
    }
    public function AjaxIngresoPacientePisos() {
    //$this->config_mdl->_delete_data('os_areas_pacientes',array('triage_id'=> $this->input->post('triage_id')));
        $data=array(
            'ap_f_ingreso'=> date('Y-m-d'),
            'ap_h_ingreso'=> date('H:i'),
            'ap_status'=>'Ingreso',
            'ap_origen'=> $this->input->post('ap_origen'),
            'ap_area'=> $this->input->post('area_id'),
            'area_id'=> $this->input->post('area_id'),
            'cama_id'=> $this->input->post('cama_id'),
            'empleado_id'=> $this->UMAE_USER,
            'empleado_id_ingreso'=> $this->input->post('empleado_id'),
            'triage_id'=> $this->input->post('triage_id')
        );
        $this->config_mdl->_insert('os_areas_pacientes',$data);
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_ingreso_f'=> date('Y-m-d'),
            'cama_ingreso_h'=> date('H:i'),
            'cama_fh_estatus'=> date('Y-m-d H:i:s'),
            'triage_id'=>$this->input->post('triage_id')
        ),array(
            'cama_id'=>  $this->input->post('cama_id')
        ));
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'Ocupado',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        Modules::run('Pisos/Camas/LogPisos',array(
            'log_tipo'=>'Ingreso',
            'log_obs'=>'Ingreso',
            'log_alta'=>'N/A',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $sqlCheck43051= $this->config_mdl->sqlGetDataCondition('doc_43051',array(
            'ac_estatus'=>'Asignación',
            'triage_id'=> $this->input->post('triage_id'),
            
        ));
        if(!empty($sqlCheck43051)){
            $this->config_mdl->_update_data('doc_43051',array(
                'ac_estatus'=>'No Asignado',
                'ac_fecha_asignacion'=> date('Y-m-d H:i:s'),
                'cama_id_asignado'=> $this->input->post('cama_id'),
                'empleado_asigna'=> $this->input->post('empleado_id'),
                'triage_asignado'=> $this->input->post('triage_asignado'),
                'ac_estatus_doc'=>'Liberado'
            ),array(
                'ac_estatus'=>'Asignación',
                'triage_id'=> $this->input->post('triage_id'),
            ));
        }
        $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),0));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxCambiarCama() {
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'En Limpieza',
            'cama_genero'=>'Sin Especificar',
            'triage_id'=>0,
            'cama_ingreso_f'=> '',
            'cama_ingreso_h'=> '',
            'cama_fh_estatus'=> date('Y-m-d H:i:s'),
        ),array(
            'cama_id'=>  $this->input->post('cama_id_old')
        ));
        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'En Limpieza',
            'cama_id'=>$this->input->post('cama_id_old'),
        ));
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'Disponible',
            'cama_id'=> $this->input->post('cama_id_old'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_genero'=>$this->input->post('cama_genero'),
            'cama_ingreso_f'=> date('d/m/Y'),
            'cama_ingreso_h'=> date('H:i'),
            'cama_fh_estatus'=> date('Y-m-d H:i:s'),
            'triage_id'=> $this->input->post('triage_id')
        ),array(
            'cama_id'=>  $this->input->post('cama_id_new')
        ));
        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'Ocupado',
            'cama_id'=>$this->input->post('cama_id_new'),
        ));
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'Ocupado',
            'cama_id'=> $this->input->post('cama_id_new'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'cama_id'=>  $this->input->post('cama_id_new'),
            'ap_f_ingreso'=> date('d/m/Y'),
            'ap_h_ingreso'=>  date('H:i') 
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_insert('os_camas_log',array(
            'cama_log_fecha'=> date('d/m/Y'),
            'cama_log_hora'=> date('H:i'),
            'cama_log_tipo'=>'Cambio de Cama',
            'cama_log_modulo'=> $this->UMAE_AREA,
            'cama_id'=> $this->input->post('cama_id_new'),
            'triage_id'=> $this->input->post('triage_id'),
            'empleado_id'=> $this->UMAE_USER
        ));
        $info= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->AccesosUsuarios(array('acceso_tipo'=>'Cambio de Cama '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$info['ap_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxCambiarEnfermera() {
        $sql= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(!empty($sql)){
            $areas= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
                'triage_id'=>  $this->input->post('triage_id'),
                'area_id'=> $this->input->post('area_id')
            ))[0];
            $this->config_mdl->_insert('os_log_cambio_enfermera',array(
                'cambio_fecha'=> date('d/m/Y'),
                'cambio_hora'=> date('H:i'),
                'cambio_modulo'=> $this->UMAE_AREA,
                'cambio_cama'=>$areas['cama_id'],
                'empleado_new'=> $sql[0]['empleado_id'],
                'empleado_old'=> $areas['empleado_id_ingreso'],
                'empleado_cambio'=> $this->UMAE_USER,
                'triage_id'=>$this->input->post('triage_id')
            ));
            
            $this->config_mdl->_update_data('os_areas_pacientes',array(
                'empleado_id_ingreso'=>$sql[0]['empleado_id']
            ),array(
                'area_id'=> $this->input->post('area_id'),
                'triage_id'=>  $this->input->post('triage_id')
            ));
            $this->AccesosUsuarios(array('acceso_tipo'=>'Cambio Enfermera '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$areas['ap_id']));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxAltaPaciente() {
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'ap_alta'=>  $this->input->post('ap_alta')
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        if($this->input->post('ap_alta')=='Alta e ingreso quirófano'){
            $this->config_mdl->_update_data('os_camas',array(
                'cama_status'=>'En Espera',
                'cama_fh_estatus'=> date('Y-m-d H:i:s'),
            ),array(
                'cama_id'=>  $this->input->post('cama_id')
            ));
            Modules::run('Areas/LogCamas',array(
                'log_estatus'=>'En Espera',
                'cama_id'=>$this->input->post('cama_id'),
            ));
        }else{
            $this->config_mdl->_update_data('os_areas_pacientes',array(
                'area_id'=> $this->input->post('area_id'),
                'ap_f_salida'=> date('d/m/Y'),
                'ap_h_salida'=>  date('H:i') ,
                'ap_status'=>'Salida'
            ),array(
                'triage_id'=>  $this->input->post('triage_id')
            ));
            $this->config_mdl->_update_data('os_camas',array(
                'cama_status'=>'En Limpieza',
                'triage_id'=>0,
                'cama_ingreso_f'=> '',
                'cama_ingreso_h'=> '',
                'cama_fh_estatus'=> date('Y-m-d H:i:s'),
            ),array(
                'cama_id'=>  $this->input->post('cama_id')
            ));
            Modules::run('Areas/LogCamas',array(
                'log_estatus'=>'En Limpieza',
                'cama_id'=>$this->input->post('cama_id'),
            ));
        }
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'En Limpieza',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        Modules::run('Pisos/Camas/LogPisos',array(
            'log_tipo'=>'Egreso',
            'log_obs'=> $this->input->post('log_obs'),
            'log_alta'=> $this->input->post('ap_alta'),
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $areas= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->AccesosUsuarios(array('acceso_tipo'=>'Egreso '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$areas['ap_id']));
        
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxObtenerAreas() {
        $option='';
        foreach ($this->config_mdl->_query("SELECT * FROM os_areas WHERE os_areas.area_id BETWEEN 2 AND 16") as $value) {
            $option.='<option value="'.$value['area_id'].'">'.$value['area_nombre'].'</option>';
        }
        $this->setOutput(array('option'=>$option));
    }
    public function AjaxCambiarArea() {
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'ap_area'=> $this->input->post('area_id')
        ),array(
            'ap_id'=> $this->input->post('ap_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxObtenerCamas() {
        $Camas=  $this->config_mdl->_query("SELECT * FROM os_camas, os_pisos, os_pisos_camas, os_areas
                                            WHERE
                                            os_camas.cama_status='Disponible' AND
                                            os_areas.area_id=os_camas.area_id AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id AND
                                            os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_pisos.piso_id=".$this->ObtenerPisos());
        foreach ($Camas as $value) {
            $option.='<option value="'.$value['cama_id'].'">'.$value['cama_nombre'].'</option>';
        }
        $this->setOutput(array('option'=>$option));
    }
    
    public function AjaxReingresoPisos() {
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'triage_id'=> $this->input->post('triage_id'),
            'cama_ingreso_f'=> date('d/m/Y'),
            'cama_ingreso_h'=> date('H:i'),
            'cama_fh_estatus'=> date('Y-m-d H:i:s'),
        ),array(
            'cama_id'=>  $this->input->post('cama_id')
        ));
        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'Ocupado',
            'cama_id'=>$this->input->post('cama_id'),
        ));
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'En Limpieza',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        Modules::run('Pisos/Camas/LogPisos',array(
            'log_tipo'=>'Ingreso',
            'log_obs'=>'Ingreso',
            'log_alta'=> 'N/A',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_areas_pacientes',array(
            'ap_f_ingreso'=> date('d/m/Y'),
            'ap_h_ingreso'=>  date('H:i') ,
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $areas= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        $this->AccesosUsuarios(array('acceso_tipo'=>'Reingreso '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$areas['ap_id']));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxReportarDescompuesta() {
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Descompuesta',
            'cama_fh_estatus'=> date('Y-m-d H:i:s')
        ),array(
            'cama_id'=> $this->input->post('cama_id')
        ));
        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'Descompuesta',
            'cama_id'=>$this->input->post('cama_id'),
        ));
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'Descompuesta',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxTraslados() {
        $sqlTraslado= $this->config_mdl->_get_data_condition('cc_traslados',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $sqlMatricula= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(!empty($sqlMatricula)){
            if(empty($sqlTraslado)){
                $this->config_mdl->_insert('cc_traslados',array(
                    'traslado_sf'=> date('Y-m-d'),
                    'traslado_sh'=> date('H:i:s'),
                    'traslado_codigo'=> $this->input->post('traslado_codigo'),
                    'traslado_servicio'=> $this->input->post('traslado_servicio'),
                    'traslado_medio_traslado'=> $this->input->post('traslado_medio_traslado'),
                    'traslado_estatus'=>'Solicitud Enviada',
                    'cama_id'=> $this->input->post('cama_id'),
                    'triage_id'=> $this->input->post('triage_id'),
                    'empleado_envia'=>$sqlMatricula[0]['empleado_id']
                ));
            }
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function Indicador() {
        $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_areas, os_camas, os_pisos, os_pisos_camas WHERE
            os_areas.area_id=os_camas.area_id AND os_areas.area_modulo='Pisos' AND
            os_pisos.piso_id=os_pisos_camas.piso_id AND os_camas.cama_id=os_pisos_camas.cama_id AND
            os_pisos.piso_id=".$this->ObtenerPisos());
        $this->load->view('EnfermeriaIndicador',$sql);
    }
    /*Asignacion de Camas realizados por Admisión Hospitalaria*/
    public function AjaxCheckAsignacionCama() {
        $sqlAreasPacientes= $this->config_mdl->sqlGetDataCondition('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(empty($sqlAreasPacientes)){
            $sql= $this->config_mdl->sqlGetDataCondition('doc_43051',array(
                'ac_estatus'=>'Asignación',
                'cama_id'=> $this->input->post('cama_id'),
                'triage_id'=> $this->input->post('triage_id_old')
            ))[0];
            if($sql['triage_id'] == $this->input->post('triage_id')){
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }
        }else{    
            $this->setOutput(array('accion'=>'3'));
        }
    }
    public function AjaxIngresoPacienteAdmision() {
        $data=array(
            'ap_f_ingreso'=> date('d/m/Y'),
            'ap_h_ingreso'=> date('H:i'),
            'ap_status'=>'Ingreso',
            'ap_origen'=> $this->input->post('ap_origen'),
            'ap_area'=> $this->input->post('ap_area'),
            'area_id'=> $this->input->post('ap_area'),
            'cama_id'=> $this->input->post('cama_id'),
            'empleado_id'=> $this->UMAE_USER,
            'empleado_id_ingreso'=> $this->UMAE_USER,
            'triage_id'=> $this->input->post('triage_id')
        );
        $this->config_mdl->_insert('os_areas_pacientes',$data,array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $sqlGetId= $this->config_mdl->sqlGetLastId('os_areas_pacientes','ap_id');
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_ingreso_f'=> date('d/m/Y'),
            'cama_ingreso_h'=> date('H:i'),
            'cama_fh_estatus'=> date('Y-m-d H:i:s'),
            'triage_id'=>$this->input->post('triage_id')
        ),array(
            'cama_id'=>  $this->input->post('cama_id')
        ));
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'Ocupado',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        Modules::run('Pisos/Camas/LogPisos',array(
            'log_tipo'=>'Ingreso',
            'log_obs'=>'Ingreso',
            'log_alta'=> 'N/A',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        if($this->input->post('ac_estatus')=='Asignado'){
            $TriageSolicitud=$this->input->post('triage_id_old');
        }else{
            $TriageSolicitud=$this->input->post('triage_id');
        }
        $sqsDoc43051= $this->config_mdl->sqlGetDataCondition('doc_43051',array(
            'triage_id'=> $TriageSolicitud,
            'ac_estatus'=>'Asignación'
        ));
        
        if(empty($sqsDoc43051)){
            $this->config_mdl->_update_data('doc_43051',array(
                'ac_estatus'=> $this->input->post('ac_estatus'),
                'ac_estatus_doc'=> 'Liberado',
                'ac_fecha_asignacion'=> date('Y-m-d H:i:s'),
                'cama_id_asignado'=> $this->input->post('cama_id'),
                'triage_asignado'=>$this->input->post('triage_id'),
                'empleado_asigna'=> $this->UMAE_USER,
            ),array(
                'ac_estatus'=>'Asignación',
                'cama_id'=> $this->input->post('cama_id')
            ));
        }else{
            $this->config_mdl->_update_data('doc_43051',array(
                'ac_estatus'=> $this->input->post('ac_estatus'),
                'ac_estatus_doc'=> 'Liberado',
                'ac_fecha_asignacion'=> date('Y-m-d H:i:s'),
                'cama_id_asignado'=> $this->input->post('cama_id'),
                'triage_asignado'=>$this->input->post('triage_id'),
                'empleado_asigna'=> $this->UMAE_USER,
            ),array(
                'triage_id'=> $TriageSolicitud
            ));
        }
        
        
        $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>$sqlGetId));
        $this->setOutput(array('accion'=>'1'));
    }
    /**/
    public function AjaxBuscarPacienteAreas() {
        $sqlPaciente= $this->config_mdl->sqlGetDataCondition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ),'triage_nombre,triage_nombre_ap,triage_nombre_am')[0];
        $sqlArea= $this->config_mdl->_query("SELECT * FROM os_areas_pacientes, os_camas WHERE os_areas_pacientes.cama_id=os_camas.cama_id AND
            os_areas_pacientes.triage_id=".$this->input->post('triage_id'))[0];
        $sqlCama= $this->config_mdl->sqlGetDataCondition('os_camas',array(
            'cama_id'=> $this->input->post('cama_id')
        ),'cama_id,cama_nombre,cama_status')[0];
        $this->setOutput(array(
            'sqlPaciente'=>$sqlPaciente,
            'sqlArea'=>$sqlArea,
            'sqlCama'=>$sqlCama
        ));
    }
    public function AjaxForzarIngreso() {
        /*Forzar asignacion de cama al paciente*/
        $this->config_mdl->_delete_data('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $data=array(
            'ap_f_ingreso'=> date('d/m/Y'),
            'ap_h_ingreso'=> date('H:i'),
            'ap_status'=>'Ingreso',
            'ap_area'=> $this->input->post('area'),
            'area_id'=> $this->input->post('area'),
            'cama_id'=> $this->input->post('cama_id'),
            'empleado_id'=> $this->UMAE_USER,
            'empleado_id_ingreso'=> $this->UMAE_USER,
            'triage_id'=> $this->input->post('triage_id')
        );
        $this->config_mdl->_insert('os_areas_pacientes',$data);
        if($this->input->post('cama_status_old')=='Ocupado' || $this->input->post('cama_status_old')=='Asignado'){
            $this->config_mdl->_update_data('os_camas',array(
                'cama_status'=>'Disponible',
                'cama_ingreso_f'=> date('d/m/Y'),
                'cama_ingreso_h'=> date('H:i'),
                'cama_fh_estatus'=> date('Y-m-d H:i:s'),
                'triage_id'=>0
            ),array(
                'cama_id'=>  $this->input->post('cama_id_old')
            ));
            Modules::run('Pisos/Camas/LogCamas',array(
                'estado_tipo'=>'Disponible',
                'cama_id'=> $this->input->post('cama_id_old'),
                'triage_id'=> $this->input->post('triage_id')
            ));
        }
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_ingreso_f'=> date('d/m/Y'),
            'cama_ingreso_h'=> date('H:i'),
            'cama_fh_estatus'=> date('Y-m-d H:i:s'),
            'triage_id'=>$this->input->post('triage_id')
        ),array(
            'cama_id'=>  $this->input->post('cama_id')
        ));
        Modules::run('Pisos/Camas/LogCamas',array(
            'estado_tipo'=>'Ocupado',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        Modules::run('Pisos/Camas/LogPisos',array(
            'log_tipo'=>'Ingreso',
            'log_obs'=>'Ingreso',
            'log_alta'=>'N/A',
            'cama_id'=> $this->input->post('cama_id'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso '.$this->UMAE_AREA,'triage_id'=>$this->input->post('triage_id'),'areas_id'=>0));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxEliminarPaciente() {
        $this->config_mdl->_delete_data('os_areas_pacientes',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $sql= $this->config_mdl->sqlGetDataCondition('os_camas',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(!empty($sql)){
            if($sql[0]['cama_status']=='Ocupado'){
                $this->config_mdl->_update_data('os_camas',array(
                    'cama_status'=>'Disponible',
                    'cama_ingreso_f'=> date('d/m/Y'),
                    'cama_ingreso_h'=> date('H:i'),
                    'cama_fh_estatus'=> date('Y-m-d H:i:s'),
                    'triage_id'=>0
                ),array(
                    'triage_id'=>$this->input->post('triage_id')
                ));
            }
        }
        $this->config_mdl->_insert('um_pisos_log_del',array(
            'log_fecha'=> date('Y-m-d H:i:s'),
            'log_piso'=> $this->UMAE_AREA,
            'log_accion'=>'Eliminación de paciente del área de pisos',
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }

}