<?php
class Soapserver extends CI_Controller
{
    function Soapserver()
    {
        parent::__construct();
        $this->load->library("Nusoap_library"); //cargando mi biblioteca
        $this->nusoap_server = new soap_server();
        $this->nusoap_server->configureWSDL("SOAP Server", $ns);
        $this->nusoap_server->wsdl->schemaTargetNamespace = $ns;
 
        //registrando funciones
        $input_array = array ('a' => "xsd:string", 'b' => "xsd:string");
        $return_array = array ("return" => "xsd:string");
        $this->nusoap_server->register('addnumbers', $input_array, $return_array, "urn:SOAPServerWSDL", "urn:".$ns."/addnumbers", "rpc", "encoded", "Addition Of Two Numbers");
    }
 
    function index()
    {
        function addnumbers($a,$b)
        {
            $c = $a + $b;
            return $c;
        }
 
        $this->nusoap_server->service(file_get_contents("php://input"));
    }
}
?>