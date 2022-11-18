<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of indicadores en Hospitalización
 *
 * @author CRAF
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Indicadores extends Config{
    public function __construct() {
        parent::__construct();
        $this->VerificarSession();
    }
    public function index() {

        $this->load->view('indicadores/index');
    }

    public function Indicador($Tipo) {
        if($Tipo=='interconsultas'){
            $this->load->view('indicadores/interconsultas');
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
        if($this->input->post('indicador_tipo')=='interconsultas'){

            $INTERCONSULTAS_SOLICITADAS=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasSolicitadas',array(
                'fechaInicial'=>$this->input->post('fechaInicial'),
                'fechaFinal'=>$this->input->post('fechaFinal'),
                'servicioEnvia'=> Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER))
                
            )));

            $INTERCONSULTAS_ATENDIDAS=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasAtendidas',array(
                'fechaInicial'=>$this->input->post('fechaInicial'),
                'fechaFinal'=>$this->input->post('fechaFinal'),
                'servicioAtiende'=> Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER))
            )));

            $INTERCONSULTAS_AC=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 1
            )));

            $INTERCONSULTAS_ALERGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 5
            )));

            $INTERCONSULTAS_ANGIOLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 22
            )));

            $INTERCONSULTAS_AUDIOLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 6
            )));

            $INTERCONSULTAS_CCC=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 11
            )));

            $INTERCONSULTAS_CCR=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 8
            )));

            $INTERCONSULTAS_CIRMAX=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 2
            )));

            $INTERCONSULTAS_DERMA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 12
            )));

            $INTERCONSULTAS_ENDOCRINO=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 13
            )));

            $INTERCONSULTAS_GASTRO=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 14
            )));

            $INTERCONSULTAS_GC=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 15
            )));

            $INTERCONSULTAS_HEMATOLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 16
            )));

            $INTERCONSULTAS_INFECTOLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 25
            )));


            $INTERCONSULTAS_MEDICINA_INTERNA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 4
            )));

            $INTERCONSULTAS_NEFROLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 24
            )));

            $INTERCONSULTAS_NEUROCIRUGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 19
            )));
            
            $INTERCONSULTAS_NEUROLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 17
            )));

            $INTERCONSULTAS_REUMATOLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 26
            )));

            $INTERCONSULTAS_UCI=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 33
            )));

            $INTERCONSULTAS_UROLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 21
            )));

            $INTERCONSULTAS_UTR=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadSolicitadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 34
            )));
            /* INTERCONSULTAS REALIZADAS EN EL SISTEMA */
            $REALIZADAS_AC=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 1
            )));

            $REALIZADAS_ALERGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 5
            )));

            $REALIZADAS_ANGIOLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 22
            )));

            $REALIZADAS_AUDIOLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 6
            )));

            $REALIZADAS_CCC=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 11
            )));

            $REALIZADAS_CCR=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 8
            )));

            $REALIZADAS_CIRMAX=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 2
            )));

            $REALIZADAS_DERMA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 12
            )));

            $REALIZADAS_ENDOCRINO=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 13
            )));

            $REALIZADAS_GC=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 15
            )));

            $REALIZADAS_HEMATOLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 16
            )));

            $REALIZADAS_INFECTOLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 25
            )));


            $REALIZADAS_MEDICINA_INTERNA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 4
            )));

            $REALIZADAS_NEFROLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 24
            )));

            $REALIZADAS_NEUROCIRUGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 19
            )));
            
            $REALIZADAS_NEUROLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 17
            )));

            $REALIZADAS_REUMATOLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 26
            )));

            $REALIZADAS_UCI=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 33
            )));

            $REALIZADAS_UROLOGIA=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 21
            )));

            $REALIZADAS_UTR=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasPorEspecilidadRealizadas',array(
                'fechaInicial'      =>$this->input->post('fechaInicial'),
                'fechaFinal'        =>$this->input->post('fechaFinal'),
                'servicioAtiende'   => Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
                'servicioEnvia'     => 34
            )));
            
            // $Especilidad=$this->config_mdl->_get_data_condition("um_especialidades", array('especialidad_interconsulta' => 1 ));
            // foreach ($Especialidad as $value) {
            //     $especialidad[$i]=count(Modules::run('Hospitalizacion/Graficasfunctions/InterconsultasAtendidas',array(
            //         'fechaInicial'=>$this->input->post('fechaInicial'),
            //         'fechaFinal'=>$this->input->post('fechaFinal'),
            //         'servicioAtiende'=> Modules::run('Config/ObtenerEspecialidadID',array('Usuario'=>$this->UMAE_USER)),
            //         'servicioSolicita' => $value['especialidad_id']
            //     ))); 
            // }
            //                 );
            $this->setOutput(array(
                'INTERCONSULTAS_SOLICITADAS'      => $INTERCONSULTAS_SOLICITADAS,
                'INTERCONSULTAS_ATENDIDAS'        => $INTERCONSULTAS_ATENDIDAS,
                'INTERCONSULTAS_AC'               => $INTERCONSULTAS_AC,
                'INTERCONSULTAS_ALERGIA'          => $INTERCONSULTAS_ALERGIA,
                'INTERCONSULTAS_ANGIOLOGIA'       => $INTERCONSULTAS_ANGIOLOGIA,
                'INTERCONSULTAS_AUDIOLOGIA'       => $INTERCONSULTAS_AUDIOLOGIA,
                'INTERCONSULTAS_CIRMAX'           => $INTERCONSULTAS_CIRMAX,
                'INTERCONSULTAS_DERMA'            => $INTERCONSULTAS_DERMA,
                'INTERCONSULTAS_ENDOCRINO'        => $INTERCONSULTAS_ENDOCRINO,
                'INTERCONSULTAS_CCC'              => $INTERCONSULTAS_CCC,
                'INTERCONSULTAS_CCR'              => $INTERCONSULTAS_CCR,
                'INTERCONSULTAS_GASTRO'           => $INTERCONSULTAS_GASTRO,
                'INTERCONSULTAS_GC'               => $INTERCONSULTAS_GC,
                'INTERCONSULTAS_HEMATOLOGIA'      => $INTERCONSULTAS_HEMATOLOGIA,
                'INTERCONSULTAS_INFECTOLOGIA'     => $INTERCONSULTAS_INFECTOLOGIA,
                'INTERCONSULTAS_MEDICINA_INTERNA' => $INTERCONSULTAS_MEDICINA_INTERNA,
                'INTERCONSULTAS_NEFROLOGIA'       => $INTERCONSULTAS_NEFROLOGIA,
                'INTERCONSULTAS_NEUROCIRUGIA'     => $INTERCONSULTAS_NEUROCIRUGIA,
                'INTERCONSULTAS_NEUROLOGIA'       => $INTERCONSULTAS_NEUROLOGIA,
                'INTERCONSULTAS_REUMATOLOGIA'     => $INTERCONSULTAS_REUMATOLOGIA,
                'INTERCONSULTAS_UCI'              => $INTERCONSULTAS_UCI,
                'INTERCONSULTAS_UROLOGIA'         => $INTERCONSULTAS_UROLOGIA,
                'INTERCONSULTAS_UTR'              => $INTERCONSULTAS_UTR,

                'REALIZADAS_AC'                   => $REALIZADAS_AC,
                'REALIZADAS_ALERGIA'              => $REALIZADAS_ALERGIA,
                'REALIZADAS_ANGIOLOGIA'           => $REALIZADAS_ANGIOLOGIA,
                'REALIZADAS_AUDIOLOGIA'           => $REALIZADAS_AUDIOLOGIA,
                'REALIZADAS_CIRMAX'               => $REALIZADAS_CIRMAX,
                'REALIZADAS_DERMA'                => $REALIZADAS_DERMA,
                'REALIZADAS_ENDOCRINO'            => $REALIZADAS_ENDOCRINO,
                'REALIZADAS_CCC'                  => $REALIZADAS_CCC,
                'REALIZADAS_CCR'                  => $REALIZADAS_CCR,
                'REALIZADAS_GASTRO'               => $REALIZADAS_GASTRO,
                'REALIZADAS_GC'                   => $REALIZADAS_GC,
                'REALIZADAS_HEMATOLOGIA'          => $REALIZADAS_HEMATOLOGIA,
                'REALIZADAS_INFECTOLOGIA'         => $REALIZADAS_INFECTOLOGIA,
                'REALIZADAS_MEDICINA_INTERNA'     => $REALIZADAS_MEDICINA_INTERNA,
                'REALIZADAS_NEFROLOGIA'           => $REALIZADAS_NEFROLOGIA,
                'REALIZADAS_NEUROCIRUGIA'         => $REALIZADAS_NEUROCIRUGIA,
                'REALIZADAS_NEUROLOGIA'           => $REALIZADAS_NEUROLOGIA,
                'REALIZADAS_REUMATOLOGIA'         => $REALIZADAS_REUMATOLOGIA,
                'REALIZADAS_UCI'                  => $REALIZADAS_UCI,
                'REALIZADAS_UROLOGIA'             => $REALIZADAS_UROLOGIA,
                'REALIZADAS_UTR'                  => $REALIZADAS_UTR
            ));
        }

    }
}