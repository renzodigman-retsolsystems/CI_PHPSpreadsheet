<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['changepw'] = 'myaccount/userchangepw';
$route['userauth'] = 'login/userauth';
$route['dashboard'] = 'dashboard/index';
$route['signout'] = 'dashboard/signout';

// $route['default_controller'] = 'upload/index';
$route['default_controller'] = 'login/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
