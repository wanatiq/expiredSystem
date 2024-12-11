<?php

class Model_comp extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_combined_data() {
        $this->db->select('DOCDATE, COMPANYNAME, DESCRIPTION, DOCREF1, DOCNOEX, MOBILE, DOCAMT');
        $this->db->from('SL_IV');
        return $this->db->get()->result();
    }
}
