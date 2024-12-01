<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class MyGuestBook extends CI_Controller {
 
    function __construct() {
      parent::__construct();
      $this->load->helper('url');
    }
 
    function index() {
      $data['title'] = 'MyGuestBook';
      $this->load->view('mainmenu', $data);
    }
}
 
?>