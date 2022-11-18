<?php
/**
 * Description of Listas
 *
 * @author felipe de jesus
 */
class Listas extends MX_Controller{
    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model(array('config/config_mdl'));
        date_default_timezone_set('America/Mexico_City');
    }
    public function setOutput($json) {
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }  
    public function rx() {
        $this->load->view('listas/listas_rx');
    }
    public function ce() {
        $this->load->view('listas/listas_ce');
    }
    public function AjaxListaCe() {
        $sql_check=  $this->config_mdl->_query("SELECT os_consultorios_especialidad.ce_id FROM os_consultorios_especialidad_llamada,  os_triage, os_consultorios_especialidad
            WHERE os_triage.triage_id=os_consultorios_especialidad.triage_id AND
            os_consultorios_especialidad.ce_id=os_consultorios_especialidad_llamada.ce_id_ce AND
            os_consultorios_especialidad.ce_status='Asignado'");
        
        if(!empty($sql_check)){
            $max=  $this->config_mdl->_query("SELECT MAX(os_consultorios_especialidad_llamada.cel_id) AS ID_MAX FROM
                os_consultorios_especialidad_llamada, os_consultorios_especialidad WHERE
                os_consultorios_especialidad_llamada.ce_id_ce=os_consultorios_especialidad.ce_id AND 
                os_consultorios_especialidad.ce_status='Asignado'");
            
            $sql=  $this->config_mdl->_query("SELECT os_triage.triage_id, triage_nombre, 
                triage_nombre_ap,triage_nombre_am, ce_fe, ce_he,ce_asignado_consultorio, triage_color
                FROM os_triage, os_consultorios_especialidad, os_consultorios_especialidad_llamada
                WHERE 
                os_consultorios_especialidad_llamada.triage_id=os_triage.triage_id AND
                os_consultorios_especialidad_llamada.ce_id_ce=os_consultorios_especialidad.ce_id AND 
                os_consultorios_especialidad.ce_status='Asignado' AND
                os_consultorios_especialidad_llamada.cel_id=".$max[0]['ID_MAX'])[0];
            //if(!empty($sql)){
            $TiempoMax=Modules::run('Config/CalcularTiempoTranscurrido',array(
                    'Tiempo1'=> date('Y-m-d H:i'),
                    'Tiempo2'=> $sql['ce_fe'].' '.$sql['ce_he']));
            if($TiempoMax->i>0){
                $MinMax=$TiempoMax->i.' Minutos';
            }else{
                $MinMax ='Un momento';
            }
            if(strlen($sql['ce_asignado_consultorio'])>30){
                $font_size_ce='35px';
                $margin_top='0px';
            }else{
                $font_size_ce='43px';
                $margin_top='-2px';
            }   // Cabecera de la pantalla  con logo
                $result='<td style="width: 10%;border: none!important" >
                            <img src="'.  base_url().'assets/img/logo.png" style="width: 100px;height: 100px">
                        </td>
                        <td class="'.Modules::run('Config/ColorClasificacion',array('color'=>$sql['triage_color'])).'" style="width: 5%;border: none!important">

                        </td>
                        <td class="back-imss" style="border: none!important">
                            <h3 style="font-weight: bold;font-size: '.$font_size_ce.';text-align:center;margin-top:'.$margin_top.'">'.$sql['ce_asignado_consultorio'].'</h3>
                        </td>
                        <td class="back-imss" style="width: 50%;margin-left:-10px!important;border: none!important">
                            <h3 style="font-weight: bold;font-size: 36px;text-transform: uppercase;margin-top:-4px">'.$sql['triage_nombre_ap'].' '.$sql['triage_nombre_am'].' '.$sql['triage_nombre'].'</h3>
                            <h6 style="font-size:14px;position:absolute;top:95px;text-transform: uppercase">LLAMADO HACE: '.$MinMax.'</h6>
                        </td>
                        
                        ';
                        $existe='MAX_CE_LLAMADA:'.$sql['triage_id'];
            //}
        }else{
            $result='';
            $existe='MAX_CE_LLAMADA:0';
        }
        $sql_ce=  $this->config_mdl->_query("SELECT os_triage.triage_id, triage_nombre, triage_paciente_sexo,
                triage_nombre_ap,triage_nombre_am, ce_fe, ce_he,ce_asignado_consultorio, triage_color FROM os_triage, os_consultorios_especialidad, os_consultorios_especialidad_llamada
                    WHERE 
                    os_consultorios_especialidad.triage_id=os_triage.triage_id AND
                    os_consultorios_especialidad.ce_id=os_consultorios_especialidad_llamada.ce_id_ce AND
                    os_consultorios_especialidad.ce_status='Asignado' ORDER BY os_consultorios_especialidad_llamada.cel_id DESC LIMIT 10");
        $TOTAL_LISTA= 0;
        foreach ($sql_ce as $value) {
            
            $ingreso=new DateTime($value['ce_fe'].' '.$value['ce_he']);  
            $hoy=new DateTime(date('Y-m-d H:i')); 
            $tiempo=$ingreso->diff($hoy);
            if($tiempo->i>0){
                $clock=$tiempo->i.' Minutos</h6>';
            }else{
                $clock='Un momento';
            }
            if($value['triage_paciente_sexo']=='HOMBRE'){
                $ColorSexo='blue';
            }else{
                $ColorSexo='pink-A100';
            }
            if($value['triage_color']!=''){
                $ColorClasificacion=Modules::run('Config/ColorClasificacion',array('color'=>$value['triage_color']));
            }else{
                $ColorClasificacion='back-imss';
            }
            if($tiempo->i<59 && $tiempo->h==0 && $tiempo->d==0){
                $TOTAL_LISTA++;
                if(strlen($value['triage_nombre'].' '.$value['triage_nombre_ap'].' '.$value['triage_nombre_am'])>25){
                    $font_size='18';
                }else{
                    $font_size='20';
                }
                $result_ce.='<div class="col-md-6 " style="margin-top: 5px;width:48.6%;margin-right:6px" >
                                <div class="row">
                                    <div class="col-md-1 '.$ColorClasificacion.'" style="height:85px">
                                    </div>
                                    <div class="col-md-4 back-imss" style="height:85px">
                                        
                                        <h4 style="font-size:18px;text-align:center"><b>'.$value['ce_asignado_consultorio'].'</b></h4>
                                        <h6 style="font-size:10px;position:absolute;bottom: -8px;"><i class="fa fa-clock-o"></i> '.$value['ce_fe'].' '.$value['ce_he'].'</h6>
                                    </div>
                                    
                                    <div class="col-md-7 back-imss" style="height:85px;">
                                        <h3 style="text-transform: uppercase;font-size:'.$font_size.'px;margin-top:8px"><b>'.$value['triage_nombre_ap'].' '.$value['triage_nombre_am'].' '.$value['triage_nombre'].'</b></h3>
                                        <h6 style="text-transform: uppercase;font-size:9px;position:absolute;bottom: -8px;"><i class="fa fa-bullhorn"></i> Llamado Hace: '.$clock.'</h6>
                                        <div style="position:absolute;height:85px;width:12px;top:0px;right: 0px;" class="'.$ColorSexo.'"></div>
                                    </div>
                                </div>        
                            </div>';
                
            }

        }

        $this->setOutput(array(
            'ListaPacientesLast'=>$result,
            'ListaPacientesAll'=>$result_ce,
            'MAX'=>$existe,
            'TOTAL_ACTUAL'=> count($sql_check),
            'ListaAccion'=>'0',
            'TOTAL_LISTA'=>$TOTAL_LISTA
        ));
        
    }
    public function AjaxListaCeVerificar() {
        $TotalLista= $this->config_mdl->_query("SELECT * FROM os_triage, os_consultorios_especialidad, os_consultorios_especialidad_llamada
            WHERE 
            os_consultorios_especialidad.triage_id=os_triage.triage_id AND
            os_consultorios_especialidad.ce_id=os_consultorios_especialidad_llamada.ce_id_ce AND
            os_consultorios_especialidad.ce_status='Asignado'");
        $this->setOutput(array('TotalListaCe'=> count($TotalLista)));
    }
    public function Interconsultas() {
        $this->load->view('Listas/Interconsultas');
    }
    public function AjaxInterconsultas() {
        $sql= $this->config_mdl->_query("SELECT * FROM os_triage, doc_430200 WHERE
        doc_430200.triage_id=os_triage.triage_id AND
        doc_430200.doc_estatus='En Espera'");
       
        foreach ($sql as $value) {
            $Tiempo=Modules::run('Config/CalcularTiempoTranscurrido',array(
                'Tiempo1'=> date('d-m-Y').' '. date('H:i'),
                'Tiempo2'=> $value['doc_fecha'].' '.$value['doc_hora'],
            ));

            $sqlMedicoSolicita = $this->config_mdl->_get_data_condition('os_empleados',array(
                'empleado_id'   =>  $value['empleado_envia']
            ))[0];

            $sqlEspecialidad = $this->config_mdl->_get_data_condition('um_especialidades',array(
                'especialidad_id'   =>  $value['doc_servicio_solicitado']
            ))[0];
            
            $especialidad = $sqlEspecialidad['especialidad_nombre'];
            if(strlen($especialidad)>20){
                $font_ss='12px';
            }else{
                $font_ss='14px';
            }
          

            $col_md_3.='<div class="col-md-3" style="margin-top: 5px" >
                                <div class="row" >
                                    <div class="col-md-1 '.Modules::run('Config/ColorClasificacion',array('color'=>$value['triage_color'])).'" style="height:95px"></div>
                                    <div class="col-md-4 back-imss" style="height:95px;padding-left:2px">
                                        <h5 style="text-transform: uppercase;margin-top:8px;font-size:8px;"><b>SERVICIO SOLICITADO</b></h5>
                                        <h5 style="text-transform: uppercase;margin-top:8px;font-size:'.$font_ss.';text-align:center;line-height:1.5"><b>'.$especialidad.'</b></h5>
                                            <h6 style="font-size:10px;position:absolute;top:69px"><i class="fa fa-clock-o"></i> '.$value['doc_fecha'].' '.$value['doc_hora'].'</h6>
                                    </div>
                                    <div class="col-md-7 back-imss" style="height:95px;font-size:12px;padding-left:2px;padding-right:2px;width:57%;">
                                        <h6 style="text-transform: uppercase;font-size:15px;line-height:1.2;margin-top:2px"><b>'.$value['triage_nombre'].' '.$value['triage_nombre_ap'].' '.$value['triage_nombre_am'].'</b> </h6>
                                        <h6 style="text-transform: uppercase;font-size:9px;line-height:1.6;margin-top:-8px;position:absolute;top:55px"><b>MEDICO QUE SOLICITA: </b><br>'.$sqlMedicoSolicita['empleado_nombre'].' '.$sqlMedicoSolicita['empleado_apellidos'].'</h6>
                                        <h6 style="font-size:10px;line-height:1.6;margin-top:-8px;position:absolute;top:85px"><i class="fa fa-clock-o"></i> <b>'.$Tiempo->d.' Dias '.$Tiempo->h.' Horas '.$Tiempo->i.' Minutos</b></h6>
                                    </div>
                                </div>        
                            </div>';            
        }
        $this->setOutput(array('col_md_3'=>$col_md_3,'page_reload'=>'0'));
    }
}