<?php defined('BASEPATH') OR exit('No direct script access allowed');
class CheckSession {
    private  $ci;
    private $allowed_controllers;
    private $allowed_methods;
    private $disallowed_methods;
    public function __construct() {
        $this->ci =&get_instance();
        
        $this->allowed_controllers=array(
            'login','Landing','Listas','Multimedia','Movil','Ensat','Vigilancia','Dashboard'
        );
        
        $this->allowed_methods =array(
            'GenerarTicket','AdultosHombres','AdultosMujeres','Pediatria','AjaxCamas',
            'MedicoObservacion','AjaxMedicoObservacion','ProcedimientoQuirurgico','AjaxProcedimientoQuirurgico',
            'AjaxSolicitarPassword',''
        );   
        $this->disallowed_methods=array();
        
        $this->ci->load->helper('url');
       
    }
    public function _CheckSession() {     
        $class= $this->ci->router->class; 
        $method= $this->ci->router->method;
        if(empty($_SESSION['UMAE_USER']) && !in_array($class, $this->allowed_controllers)){
            if(!in_array($method, $this->allowed_methods)){
                redirect('login');
            }   
        }
        if(!empty($_SESSION['UMAE_USER']) && in_array($class, array('login'))){
            //redirect('Inicio');
        }
    }
    
}