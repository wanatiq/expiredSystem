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

    // public function get_user_by_id($DOCKEY) {
    //     $this->db->select('SL_IV.*, SL_IVDTL.*'); // Select all fields from both tables
    //     $this->db->from('SL_IV');
    //     $this->db->join('SL_IVDTL', 'SL_IV.DOCKEY = SL_IVDTL.DOCKEY', 'left'); // Left join
    //     $this->db->where('SL_IV.DOCKEY', $DOCKEY); // Filter by DOCKEY
    //     $query = $this->db->get();
    //     return $query->row_array(); // Return a single record as an array
    // }
    

    // public function insert_user($data) {
    //     $sl_iv_data = [
    //         'DOCKEY' => $data['DOCKEY'],
    //         'COMPANYNAME' => $data['COMPANYNAME'],
    //         'DOCDATE' => $data['DOCDATE']
    //         // Add other fields for SL_IV
    //     ];
    
    //     $sl_ivdtl_data = [
    //         'DOCKEY' => $data['DOCKEY'],
    //         'DESCRIPTION' => $data['DESCRIPTION'],
    //         'AMOUNT' => $data['AMOUNT']
    //         // Add other fields for SL_IVDTL
    //     ];
    
    //     // Insert into SL_IV
    //     $this->db->insert('SL_IV', $sl_iv_data);
    
    //     // Insert into SL_IVDTL
    //     $this->db->insert('SL_IVDTL', $sl_ivdtl_data);
    
    //     // Check if both inserts were successful
    //     return $this->db->affected_rows() > 0;
    // }

    // public function update_user($DOCKEY, $data) {
    //         // Update SL_IV
    //     $sl_iv_data = [
    //         'COMPANYNAME' => $data['COMPANYNAME'],
    //         'DOCDATE' => $data['DOCDATE'],
    //         'DOCNOEX' => $data['DOCNOEX']
    //         // Add other fields for SL_IV
    //     ];

    //     $this->db->where('DOCKEY', $DOCKEY);
    //     $this->db->update('SL_IV', $sl_iv_data);

    //     // Update SL_IVDTL
    //     $sl_ivdtl_data = [
    //         'DESCRIPTION' => $data['DESCRIPTION'],
    //         'AMOUNT' => $data['AMOUNT']
    //         // Add other fields for SL_IVDTL
    //     ];

    //     $this->db->where('DOCKEY', $DOCKEY);
    //     $this->db->update('SL_IVDTL', $sl_ivdtl_data);

    //     // Return success only if at least one update occurred
    //     return $this->db->affected_rows() > 0;
    // }

    // public function get_sliv(){
    //     return $this->db->get('SL_IV')->result();
    // }

    // public function delete_user($DOCKEY) {
    //         // Delete from SL_IVDTL
    //     $this->db->delete('SL_IVDTL', ['DOCKEY' => $DOCKEY]);

    //     // Delete from SL_IV
    //     $this->db->delete('SL_IV', ['DOCKEY' => $DOCKEY]);

    //     // Check if either deletion was successful
    //     return $this->db->affected_rows() > 0;
    // }

    // public function calculate_and_update_days_left($DOCKEY) {
    //     // Fetch the record with the specified `DOCKEY` value
    //     $query = $this->db->query("SELECT DOCDATE, DOCNOEX FROM SL_IV WHERE DOCKEY = ?", array($DOCKEY));
    //     $row = $query->row_array();
    
    //     if ($row) {
    //         // Convert start_date and expired_date to DateTime objects
    //         $startDate = new DateTime($row['DOCDATE']);
    //         $expiredDate = new DateTime($row['DOCNOEX']);
    
    //         // Calculate the difference in days
    //         $daysLeft = $expiredDate->diff($startDate)->days;
    
    //         // Update the day_left column in the database
    //         // $updateQuery = "UPDATE SL_IV SET day_left = ? WHERE DOCKEY = ?";
    //         // $this->db->query($updateQuery, array($daysLeft, $DOCKEY));
    
    //         return $daysLeft; // Optionally, return the calculated days left
    //     } else {
    //         return false; // Return false if no record is found
    //     }
    // }

    // public function save($data) {
    //     $this->db->set('DOCDATE', $data['DOCDATE'] ?: null);
    //     $this->db->set('DOCNOEX', $data['DOCNOEX'] ?: null);
    //     $this->db->insert('SL_IV');
    // }



