<?php

/**
 * @property User_model $User_model
 */

    class User extends CI_Controller {
        public function __construct(){
            parent::__construct();

            $this->load->database();
            $this->load->helper('url');   
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('User_model');        
        }

        public function test(){
            echo '<h1>user</h1>';
        }

    public function index(){
        $data['users'] = $this->User_model->get_users();
        $this->load->view('user/index',$data);
    }

    public function create(){
        if ($this->input->post()){
           $data = array(
                'name' => $this->input->post('name'),
                'email'=> $this->input->post('email')
            );
            $this->User_model->insert_user($data);
            redirect('user');
        }
        $this->load->view('user/create');
    }

    public function edit($id){
        if($this->input->post()){
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email')
            );
            $this->User_model->update_user($id,$data);
            redirect('user');
        }
        $data['user'] = $this->User_model->get_user_by_id($id);
        $this->load->view('user/edit',$data);
    }

    public function delete($id){
        $this->User_model->delete_user($id);
        redirect('user');
    }

    public function mainpage(){
        $data1 = $this->User_model->get_users2();
        $data = [
            'expired_table' => $data1,
        ];
        $this->load->view('user/mainpage', $data);
    }
    
}