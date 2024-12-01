<?php
class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
     
    public function get_users() {
        $query = $this->db->query("SELECT * FROM users");
        return $query->result_array();
    }

    
    public function get_users2() {
        return $this->db->get('expired_table')->result();
    }

    public function get_user_by_id($id) {
        $query = $this->db->query("SELECT * FROM users WHERE id = ?", array($id));
        return $query->row_array();
    }

    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }

    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
}