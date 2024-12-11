<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Client as GoogleClient;
use Google\Service\Oauth2;

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
            // Set session data
            $this->session->set_userdata("ID", $user->id);
            $this->session->set_userdata("USERNAME", $user->USERNAME);

            redirect(''); // Redirect to index page
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('login');
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


    // Login with Google
    public function google_auth() {
        require_once FCPATH . '../vendor/autoload.php';
        
        $googleClient = new GoogleClient();
        $googleClient->setClientId($this->config->item('google_client_id'));
        $googleClient->setClientSecret($this->config->item('google_client_secret'));
        $googleClient->setRedirectUri($this->config->item('google_redirect_uri'));
        $googleClient->addScope("email");
        $googleClient->addScope("profile");
    
        if ($this->input->get('code')) {
            $token = $googleClient->fetchAccessTokenWithAuthCode($this->input->get('code'));
    
            if (!isset($token['error'])) {
                $googleClient->setAccessToken($token);
    
                // Get user information from Google
                $googleOauth = new Oauth2($googleClient);
                $googleUserInfo = $googleOauth->userinfo->get();
    
                $googleEmail = $googleUserInfo->email;
    
                // Check if email exists in the database
                if ($this->User_model->email_exists($googleEmail)) {
                    // Grant access
                    $user = $this->User_model->get_user_by_email($googleEmail);
    
                    // Set session data
                    $this->session->set_userdata('ID', $user->ID);
                    $this->session->set_userdata('EMAIL', $user->EMAIL);
                    $this->session->set_userdata('USERNAME', $user->USERNAME);
    
                    // Redirect to dashboard
                    redirect('');
                } else {
                    // Deny access with a friendly error message
                    $this->session->set_flashdata('error', 'You Did Not Have Authorization, Please Contact Administration.');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('error', 'Failed to authenticate with Google.');
                redirect('login');
            }
        } else {
            redirect($googleClient->createAuthUrl());
        }
    }           
}
