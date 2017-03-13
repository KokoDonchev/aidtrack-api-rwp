<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_campaigns() {
        $query = $this->db->query('SELECT * FROM aidtrack_campaigns');
        return $query->result_array();
    }

     public function add_campaign($campaign_name) {
        $query = "INSERT INTO aidtrack_campaigns (id, campaign_name, created_by) VALUES ('', ?, '1')";
        $this->db->query($query, array($campaign_name));
    }

    public function get_shipments() {
        $query = $this->db->query('SELECT * FROM aidtrack_shipments');
        return $query->result_array();
    }

    public function add_shipment($shipment_title, $camp_id) {
        $query = "INSERT INTO aidtrack_shipments (id, shipment_title, campaign_id) VALUES ('', ?, ?)";
        $this->db->query($query, array($shipment_title, $camp_id));
    }

    public function get_products() {
        $query = $this->db->query('SELECT * FROM aidtrack_products');
        return $query->result_array();
    }
    
    public function add_product($product_name) {
        $query = "INSERT INTO aidtrack_products (id, product_name) VALUES ('', ?)";
        $this->db->query($query, array($product_name));
    }

}