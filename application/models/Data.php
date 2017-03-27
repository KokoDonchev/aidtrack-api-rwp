<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_campaigns($camp_id = false) {
        if ($camp_id === false) {
            $query = $this->db->query('SELECT * FROM `aidtrack_campaigns`');
            return $query->result_array();
        } else {
            $query = $this->db->get_where('aidtrack_campaigns', array('id' => $camp_id));
            return $query->result_array();
        }
    }

    public function get_last_campaign() {
        $query = $this->db->select('*')->from('aidtrack_campaigns')->order_by('id', 'DESC')->limit(1)->get();
        return $query->result_array();
    }

     public function add_campaign($campaign_name) {
        $query = "INSERT INTO aidtrack_campaigns (id, campaign_name, created_by) VALUES ('', ?, '1')";
        $this->db->query($query, array($campaign_name));
    }

    // public function get_shipments($shipment_id = false) {
    //     if ($shipment_id === false) {
    //         $query = $this->db->query('SELECT * FROM aidtrack_shipments');
    //         return $query->result_array();
    //     } else {
    //         $query = $this->db->get_where('aidtrack_shipments', array('id' => $shipment_id));
    //         return $query->result_array();
    //     }
    // }

    public function get_shipments($shipment_id = 0, $camp_id = 0) {
        if ($camp_id == 0 && $shipment_id != 0) {
            $query = $this->db->get_where('aidtrack_shipments', array('id' => $shipment_id));
            return $query->result_array();
        }
        if ($shipment_id == 0 && $camp_id != 0) {
            $query = $this->db->get_where('aidtrack_shipments', array('campaign_id' => $camp_id));
            return $query->result_array();
        } else {
            $query = $this->db->query('SELECT * FROM aidtrack_shipments');
            return $query->result_array();
        }
    }

    public function add_shipment($shipment_title, $camp_id) {
        $query = "INSERT INTO aidtrack_shipments (id, shipment_title, campaign_id) VALUES ('', ?, ?)";
        $this->db->query($query, array($shipment_title, $camp_id));
    }

    public function get_products($prod_id = false) {
        if ($prod_id === false) {
            $query = $this->db->query('SELECT * FROM aidtrack_products');
            return $query->result_array();
        } else {
            $query = $this->db->get_where('aidtrack_products', array('id' => $prod_id));
            return $query->result_array();
        }
    }
    
    public function add_product($product_name) {
        $query = "INSERT INTO aidtrack_products (id, product_name) VALUES ('', ?)";
        $this->db->query($query, array($product_name));
    }

}