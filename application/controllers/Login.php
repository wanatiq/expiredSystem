<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('login');
    }

    public function authenticate() {
        // Step 1: Ensure the USERS table exists and is populated
        $this->User_model->ensure_users_table();
    
        // Step 2: Handle login validation
        $username = $this->input->post("USERNAME");
        $password = $this->input->post("PASSWORD");
    
        $user = $this->User_model->validate_user($username, $password);
    
        if ($user) {
            $this->session->set_userdata([
                "ID" => $user->ID,
                "USERNAME" => $user->USERNAME,
                "USER_ROLE" => $user->USER_ROLE, // Correct column name
                "COMPANYNAME" => $user->COMPANYNAME
            ]);
    
            // Redirect to all page
            if ($user->USER_ROLE === "admin") {
                redirect('Control_comp');
            } 
            elseif ($user->USER_ROLE === "users") {
                redirect('Control_comp_users');
            }

        } else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('login');
        }
    } 

    // Method to alter the USERS table

    public function alter_database() {
        // Drop the column if it exists
        $sql_drop = "DROP TABLE USERS;";
        if ($this->db->query($sql_drop)) {
            echo "Table dropped successfully.<br>";
        } else {
            echo "Failed to drop table or it doesn't exist.<br>";
        }
    }


    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }


    public function forgot_password() {
        if ($this->input->post()) {
            $username = $this->input->post('USERNAME');
            $email = $this->input->post('EMAIL');
            $password = $this->input->post('PASSWORD');
            $confirm_password = $this->input->post('CONFIRM_PASSWORD');
    
            // Validate passwords match
            if ($password !== $confirm_password) {
                $this->session->set_flashdata('error', 'Passwords do not match.');
                redirect('login/forgot_password');
            }
    
            // Check if the username exists
            $this->db->where('USERNAME', $username);
            $username_query = $this->db->get('USERS');

            // Check if the email exists
            $this->db->where('EMAIL', $email);
            $email_query = $this->db->get('USERS');
    
            // Handle errors
            if ($username_query->num_rows() === 0 && $email_query->num_rows() === 0) {
                $this->session->set_flashdata('error', 'Invalid username and email.');
                redirect('login/forgot_password');
            } elseif ($username_query->num_rows() === 0) {
                $this->session->set_flashdata('error', 'Invalid username.');
                $this->session->set_flashdata('username_error', true);
                redirect('login/forgot_password');
            } elseif ($email_query->num_rows() === 0) {
                $this->session->set_flashdata('error', 'Invalid email.');
                $this->session->set_flashdata('email_error', true);
                redirect('login/forgot_password');
            }

            // Update the user's password
            if ($this->User_model->reset_password($username, $password)) {
                $this->session->set_flashdata('success', 'Password updated successfully.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Failed to update password. Please try again.');
                redirect('login/forgot_password');
            }
        }
        // Load the view
        $this->load->view('forgotpassword');
    }        
}