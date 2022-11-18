<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Urgencias_mdl
 *
 * @author felipe de jesus | itifjpp@gmail.com 
 */
class Urgencias_mdl extends CI_Model{
    //put your code here
    public function _get_camas($area) {
        return $this->db
                ->where('os_areas.area_id=os_camas.area_id')
                ->where('os_areas.area_id',$area)
                ->get('os_areas,os_camas')
                ->result_array();
    }
    public function _get_camas_jefe() {
        return $this->db
                ->where('os_areas.area_id=os_camas.area_id')
                ->get('os_areas,os_camas')
                ->result_array();
    }
    public function _get_areas_medicos($area) {
        return $this->db
                ->where('os_empleados.empleado_id=os_areas_medico.empleado_id')
                ->where('os_areas.area_id',$area)
                ->where('os_areas.area_id=os_areas_medico.area_id')
                ->get('os_empleados, os_areas , os_areas_medico')
                ->result_array();
    }
}
