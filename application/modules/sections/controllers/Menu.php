<?php  defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'modules/config/controllers/Config.php';
class Menu extends Config{
    public function __construct(){
        parent::__construct();
        $this->load->model(array('Menu_m','Menus_mdl'));
    }
    public function index(){
        $data['info']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=>$_SESSION['UMAE_USER']
        ));
        $this->load->view('Menu/Header',$data);
    }
    public function index2(){
        $data['info']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=>$_SESSION['UMAE_USER']
        ));
        $this->load->view('Menu/Header2',$data);
    }
    public function ObtenerMenu() {
        $Menus='';
        foreach ($this->Menu_m->_get_menuN1($_SESSION['UMAE_AREA']) as $mn1) { 
            if ($mn1['menuN1_c_m'] == '1'){
                //$AccionN1=$mn1['menuN1_status']=='1' ? 'block': 'none';
                $Menus.='<li class="treeview">';
                        $Menus.='<a class="app-menu__item" href="#" data-toggle="treeview">';
                        $Menus.='<i class="app-menu__icon '.$mn1['menuN1_icono'].'"></i>';
                        $Menus.='<span class="app-menu__label">'.$mn1['menuN1_menu'].'</span>';
                        $Menus.='<span class="pull-right text-muted">';
                        $Menus.='<i class="treeview-indicator fa fa-caret-down"></i>';
                        $Menus.='</span>';
                        $Menus.= '</a>';
                        $Menus.= '<ul class="treeview-menu">';
                        foreach ($this->Menu_m->_get_menuN2($mn1['menuN1_id']) as $mn2) {
                            if ($mn2['menuN2_c_m'] == '1'){
                                $Menus.= '<li>';
                                    $Menus.='<a class="app-menu__item ">';
                                        //$Menus.='<span class="pull-right text-muted">';
                                        //$Menus.='</span>';
                                        $Menus.='<span class="app-menu__label">'.$mn2['menuN2_menu'].'</span>';
                                        $Menus.='<i class="treeview-indicator fa fa-caret-down"></i>';
                                    $Menus.='</a>';
                                    $Menus.='<ul class="treeview-menu">';
                                    foreach ($this->Menu_m->_get_menuN3($mn2['menuN2_id']) as $mn3) { 
                                        $Menus.= '<li>';
                                            $Menus.='<a href="'.  base_url().$mn3['menuN3_url'].'">'.$mn3['menuN3_menu'].'</a>';
                                        $Menus.='</li>';
                                    }
                                    $Menus.='</ul>';
                                $Menus.= '</li>';
                            }else{
                                $Menus.= '<li>';
                                    $Menus.= '<a class="treeview-item" href="'.base_url().$mn2['menuN2_url'].'">'.$mn2['menuN2_menu'].'</a>';
                                $Menus.= '</li>';                     
                            }
                        }
                        $Menus.= '</ul>';
                $Menus.= '</li>';
            }else{

                $Menus.= '<li>';
                    $Menus.= '<a class="app-menu__item" href="'.  base_url().$mn1['menuN1_url'].'">';
                        $Menus.='<i class="app-menu__icon '.$mn1['menuN1_icono'].'"></i>';
                        $Menus.='<span class="app-menu__label">'.$mn1['menuN1_menu'].'</span>';
                    $Menus.='</a>';
                $Menus.='</li>';
            }
        }
        echo $Menus;
    }
    public function footer() {
            return $this->load->view('Menu/Footer.php','',TRUE); 
    }
    public function HeaderBasico() {
        $this->load->view('Menu/HeaderBasico');
    }
    public function FooterBasico() {
        $this->load->view('Menu/FooterBasico');
    }

    public function FooterCamas() {
        $this->load->view('Menu/Footer_camas');
    }
    public function Menus() {
        $sql['Gestion']=  $this->Menus_mdl->_get_menu_n1();
        $this->load->view('Menu/menu_n1',$sql);
    }
    public function insert_menuN1() {
        $data=array(
            'menuN1_menu'=>  $this->input->post('mn1_menu_1'),
            'menuN1_url'=>  $this->input->post('mn1_url'),
            'menuN1_c_m'=>  $this->input->post('mn1_c_m'),
            'menuN1_status'=>  $this->input->post('menuN1_status'),
            'menuN1_icono'=>  $this->input->post('mn1_icono')
        );
        if($this->input->post('accion')=='add'){
            if($this->Menus_mdl->_insert('menu_1',$data)){
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }   
        }else{
            if($this->Menus_mdl->_update_menus('menu_1',$data,array('menuN1_id'=>  $this->input->post('mn1_id')))){
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }
        }
    }
    public function get_menuN1() {
        $this->setOutput($this->Menus_mdl->_get_menus('menu_1',array('menuN1_id'=>  $this->input->post('id'))));
    }
    public function mn1_area() {
        $sql['Gestion']=  $this->Menus_mdl->_get_mn1_rol($this->input->get_post('m'));
        $this->load->view('Menu/menu_n1_rol',$sql);
    }
    public function get_areas_acceso() {
        foreach ($this->config_mdl->_get_data('os_areas_acceso') as $value) {
            $option.='<option value="'.$value['areas_acceso_id'].'">'.$value['areas_acceso_nombre'].'</option>';
        }
        $this->setOutput(array('option'=>$option));
    }
    public function insert_mn1_rol() {
        $sql=$this->Menus_mdl->_get_menus('menu_1_area',array(
            'menuN1_id'=>  $this->input->post('menuN1_id'),
            'areas_acceso_id'=>  $this->input->post('areas_acceso_id')
        ));
        if(empty($sql)){
            if($this->Menus_mdl->_insert('menu_1_area',array(
                'menuN1_id'=>  $this->input->post('menuN1_id'),
                'areas_acceso_id'=>  $this->input->post('areas_acceso_id')
            ))){
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }
        }else{
            $this->setOutput(array('accion'=>'3','msj'=>'El area ya se encuentra agregado a este menu'));
        }
    }  
    public function delete_mn1_rol() {
        $sql=$this->Menus_mdl->_delete_menus('menu_1_area',array(
            'menuN1_id'=>  $this->input->post('menuN1_id'),
            'areas_acceso_id'=>  $this->input->post('areas_acceso_id')
        ));
        if($sql){
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    /*Menu nivel 2*/
    public function menuN2() {
        $sql['Gestion']=  $this->Menus_mdl->_get_menuN2($this->input->get_post('m'));
        $this->load->view('Menu/menu_n2',$sql);
    }
    public function insert_menuN2() {
        $data=array(
            'menuN2_menu'   =>  $this->input->post('menuN2_menu'),
            'menuN2_url'    =>  $this->input->post('menuN2_url'),
            'menuN2_c_m'    =>  $this->input->post('menuN2_c_m'),
            'menuN2_status' =>  $this->input->post('menuN2_status'),
            'menuN2_icono'  =>  $this->input->post('menuN2_icono'),
            'menuN1_id'     =>  $this->input->post('menuN1_id')
        );
        if($this->input->post('accion')=='add'){
            if($this->Menus_mdl->_insert('menu_2',$data)){
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }   
        }else{
            if($this->Menus_mdl->_update_menus('menu_2',$data,array('menuN2_id'=>  $this->input->post('menuN2_id')))){
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }
        }   
    }
    public function get_menuN2() {
        $this->setOutput($this->Menus_mdl->_get_menus('menu_2',array('menuN2_id'=>  $this->input->post('id'))));
    }
    /*Menu nivel 3*/
    public function menuN3() {
        $sql['Gestion']=  $this->Menus_mdl->_get_menuN3($this->input->get_post('m'));
        $this->load->view('Menu/menu_n3',$sql);
    }
    public function insert_menuN3() {
        $data=array(
            'menuN3_menu'   =>  $this->input->post('menuN3_menu'),
            'menuN3_url'    =>  $this->input->post('menuN3_url'),
            'menuN3_status' =>  $this->input->post('menuN3_status'),
            'menuN3_icono'  =>  $this->input->post('menuN3_icono'),
            'menuN2_id'     =>  $this->input->post('menuN2_id')
        );
        if($this->input->post('accion')=='add'){
            if($this->Menus_mdl->_insert('menu_3',$data)){
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }   
        }else{
            if($this->Menus_mdl->_update_menus('menu_3',$data,array('menuN3_id'=>  $this->input->post('menuN3_id')))){
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }
        }   
    }
    public function get_menuN3() {
        $this->setOutput($this->Menus_mdl->_get_menus('menu_3',array('menuN3_id'=>  $this->input->post('id'))));
    }    
    public function delete_mn3() {
        $sql=$this->Menus_mdl->_delete_menus('menu_3',array(
            'menuN3_id'=>  $this->input->post('id')
        ));
        if($sql){
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function delete_mn2() {
        $sql=$this->Menus_mdl->_delete_menus('menu_2',array(
            'menuN2_id'=>  $this->input->post('id')
        ));
        if($sql){
            $sql=$this->Menus_mdl->_delete_menus('menu_3',array(
                'menuN2_id'=>  $this->input->post('id')
            ));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function delete_mn1() {
        foreach ($this->Menus_mdl->_get_menus('menu_2',array('menuN1_id'=>  $this->input->post('id'))) as $mn2) {
            foreach ($this->Menus_mdl->_get_menus('menu_3',array('menuN2_id'=>  $mn2['menuN2_id'])) as $mn3) {
                $sql=$this->Menus_mdl->_delete_menus('menu_3',array(
                    'menuN3_id'=>  $mn3['menuN3_id']
                ));
            }
            $sql=$this->Menus_mdl->_delete_menus('menu_2',array(
                'menuN2_id'=>  $mn2['menuN2_id']
            ));
        }
        if($sql){
            $sql=$this->Menus_mdl->_delete_menus('menu_1',array(
                'menuN1_id'=>  $this->input->post('id')
            ));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function HeaderLanding() {
        $this->load->view('Menu/HeaderLanding');
    }
    public function FooterLanding() {
        $this->load->view('Menu/FooterLanding');
    }
    public function HeaderCamas() {
        $data['info']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=>$_SESSION['UMAE_USER']
        ));
        $this->load->view('Menu/HeaderCamas',$data);
    }
    public function HeaderHC() {
        $this->load->view('Menu/HeaderHC');
    }
    public function FooterHC() {
        $this->load->view('Menu/FooterHC');
    }

    public function Header_modal()
    {
        $this->load->view('Menu/Head_modal');
    }

    public function Footer_modal()
    {
        $this->load->view('Menu/Footer_modal');
    }

    public function HeaderNotas() {
        $this->load->view('Menu/HeaderNotas');
    }

    public function FooterNotas() {
        $this->load->view('Menu/footer_notas');
    }
}
