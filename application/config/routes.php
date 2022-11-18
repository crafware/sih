<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'sections/login';
$route['login']='sections/login';
$route['Status']='sections/login/Status';
$route['404_override'] = 'Error/index';
$route['Landing']='Sections/Landing/index';
$route['translate_uri_dashes'] = FALSE;
