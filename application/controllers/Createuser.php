<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createuser extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index() {
        // Load the create user form view
        $this->load->view('createuser');
    }

    public function store_user() {
        // Get the user input
        $username = $this->input->post('USERNAME');
        $password = $this->input->post('PASSWORD');
        $email = $this->input->post('EMAIL');

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare user data
        $user_data = [
            'USERNAME' => $username,
            'PASSWORD' => $hashed_password,
            'EMAIL' => $email,
            'CREATED_AT' => date('Y-m-d H:i:s')
        ];

        // Save the user to the database
        if ($this->User_model->create_user($user_data)) {
            $this->session->set_flashdata('success', 'User created successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to create user. Please try again.');
        }

        // Redirect back to the create user page
        redirect('login');
    }
}
