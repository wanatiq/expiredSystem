<?php

/**
 * @property Model_comp_users $Model_comp_users
 */

 
class Control_comp_users extends CI_Controller {
    public function __construct(){
        parent::__construct();

        // if (!$this->session->userdata('user_id')) {
        //     redirect('auth/login');
        // }

        $this->load->database();
        $this->load->helper('url');   
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Model_comp_users'); 
    }

    public function index() {
        $data1 = $this->Model_comp_users->get_combined_data(); // Ambil data dari model
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
        $this->load->view('user/mainpage_users', $data);
    }
}