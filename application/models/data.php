<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Site_data extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_campaigns() {
        $query = $this->db->query('SELECT * FROM `aidtrack_campaigns`');
        return $query->result_array();
    }

}