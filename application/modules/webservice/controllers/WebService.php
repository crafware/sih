<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'modules/config/controllers/Config.php';

class WebService extends Config {

  public function __construct() {
      parent::__construct();
      $url ="http://localhost/sigTRIAGE/WebService";
      $this->load->library("Nusoap_library");
      $this->nusoap_server = new nusoap_server();
      $this->nusoap_server->configureWSDL("WebService",$url);
      $this->nusoap_server->wsdl->schemaTargetNamespace = $ulr;
      $this->nusoap_server->soap_defencoding = 'utf-8';
      $this->nusoap_server->register(
        "listar",
        array("id" => "xsd:string"),
        array("return" => "xsd:string"),
        $url
      );
  }
  public function index(){
    $this->nusoap_server->service(file_get_contents("php://input"));
  }
  public function listar(){
    $sql = $this->config_mdl->_query("SELECT ac_id FROM doc_43051");
    echo count($sql);
    $cadena = "<? xml version='1.0' encoding='utf-8' ?>";
    for($x = 0; $x < count($sql); $x++ ){

      $cadena .= "<identificadores>";
      $cadena .= "<id>$sql[0]['ac_id']</id>";
      $cadena .= "</identificadores>";

    }
    $respuesta = new nusoapval('return','xsd:string',$cadena);
    return $respuesta;
  }

}
