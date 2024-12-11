<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'Control_comp';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Add login-related routes
$route['login'] = 'login/index';
$route['login/authenticate'] = 'login/authenticate';
$route['logout'] = 'login/logout';
$route['login/google_auth'] = 'Login/google_auth';