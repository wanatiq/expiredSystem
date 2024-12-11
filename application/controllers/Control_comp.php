<?php

/**
 * @property Model_comp $Model_comp
 */

 
class Control_comp extends CI_Controller {
    public function __construct(){
        parent::__construct();

        // if (!$this->session->userdata('user_id')) {
        //     redirect('auth/login');
        // }

        $this->load->database();
        $this->load->helper('url');   
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Model_comp');
        
    }

    public function index() {
        $data1 = $this->Model_comp->get_combined_data(); // Ambil data dari model
        $today = new DateTime();

        foreach ($data1 as $key => $record) {
            if (!is_object($record)) {
                $data1[$key] = (object)$record;
            }

            // Proses DOCDATE 
            if (!empty($record->DOCDATE)) {
                $dateObj = DateTime::createFromFormat('Y-m-d', $record->DOCDATE);
                if ($dateObj) {
                    $data1[$key]->DOCDATE = $dateObj->format('d/m/Y');
                } else {
                    $data1[$key]->DOCDATE = 'N/A';
                }
            } else {
                $data1[$key]->DOCDATE = 'N/A';
            }
            //Proses DOCREF1
            $data1[$key]->DOCREF1 = !empty($record->DOCREF1) ? $record->DOCREF1 : 'N/A';

            // Validasi dan normalisasi DOCNOEX
            $docnoex = trim($record->DOCNOEX ?? '');
            if ($date = DateTime::createFromFormat('Y-m-d', $docnoex) ?: DateTime::createFromFormat('d/m/Y', $docnoex)) {
                $data1[$key]->DOCNOEX = $date->format('Y-m-d');
            } else {
                $data1[$key]->DOCNOEX = 'N/A';
            }

            // Hitung `day_left`
            if ($data1[$key]->DOCNOEX !== 'N/A') {
                $targetDate = new DateTime($data1[$key]->DOCNOEX);
                $interval = $today->diff($targetDate);

                // Jika tanggal sudah lewat (Expired)
                if ($interval->invert) {
                    $data1[$key]->day_left = -$interval->days; // Tanggal sudah lewat
                } else {
                    $data1[$key]->day_left = $interval->days + 1; // Tanggal akan datang (termasuk hari terakhir)
                }
            } else {
                $data1[$key]->day_left = 'N/A'; // Jika tanggal tidak valid
            }

            // Tetapkan status
            $day_left = $data1[$key]->day_left;
            if ($day_left === 'N/A') {
                $data1[$key]->status = '<span class="badge rounded-pill bg-light text-dark">No subscription</span>';
            } elseif ($day_left < 0) {
                $data1[$key]->status = '<span class="badge rounded-pill bg-danger">Expired</span>';
            } else {
                $data1[$key]->status = '<span class="badge rounded-pill bg-success">Active</span>';
            }
        }

        // Kirimkan data ke view
        $data['combined'] = $data1;
        $this->load->view('user/mainpage', $data);
    }
}



    
    // public function get_companies() {
    //     $this->load->model('Model_comp');
    //     $data = $this->Model_comp->get_users(); // Adjust to fetch data from your model
    //     echo json_encode($data);
    // }

 
    // public function create() {
    //     if ($this->input->post()) {
    //         $data = array(
    //             'COMPANYNAME' => $this->input->post('COMPANYNAME'),
    //             'service' => $this->input->post('service'),
    //             'DOCDATE' => $this->input->post('DOCDATE'),
    //             'DOCNOEX' => $this->input->post('DOCNOEX'),
    //             'day_left' => $this->input->post('day_left'),
    //             'status' => $this->input->post('status')
    //         );
    //         $this->Model_comp->insert_user($data);
    //         redirect('Control_comp');
    //     }
    //     $this->load->view('user/create1');
    // }

    // public function edit1($DOCKEY) {
    //     if ($this->input->post()) {
    //         $data = array(
    //             'COMPANYNAME' => $this->input->post('COMPANYNAME'),
    //             'DESCRIPTION' => $this->input->post('DESCRIPTION'),
    //             'DOCDATE' => $this->input->post('DOCDATE'),
    //             'DOCNOEX' => $this->input->post('DOCNOEX')
    //         );
    //         $this->Model_comp->update_user($DOCKEY, $data);
    //         redirect('Control_comp');    
    //     }

    //     $company = $this->Model_comp->get_user_by_id($DOCKEY);
    //     if(!$company){
    //         show_error('Company not found!',404);
    //     }

    //     $data['company'] = $company;
    //     $this->load->view('user/edit1', $data);
    // }
    
    // public function delete($DOCKEY) {
    //     $company = $this->Model_comp->get_user_by_id($DOCKEY);
    //     if ($company) {
    //         $this->Model_comp->delete_user($DOCKEY);
    //         $this->session->set_flashdata('success', 'Company deleted successfully.');
    //     } else {
    //         $this->session->set_flashdata('error', 'Company not found.');
    //     }
    //     redirect('Control_comp');
    // }
    
    //nak connect ngan firebird

    // public function get_sliv(){
    //     $data1 = $this->Model_comp->get_sliv();
    //     echo json_encode($data1); 
    // }