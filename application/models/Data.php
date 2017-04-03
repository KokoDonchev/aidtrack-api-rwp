<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    /*
    | -------------------------------------------------------------------
    |  Campaigns
    | -------------------------------------------------------------------
    */

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

    /*
    | -------------------------------------------------------------------
    |  Shipments
    | -------------------------------------------------------------------
    */

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

    public function get_last_shipment() {
        $query = $this->db->select('*')->from('aidtrack_shipments')->order_by('id', 'DESC')->limit(1)->get();
        return $query->result_array();
    }

    public function add_shipment($shipment_title, $camp_id) {
        $query = "INSERT INTO aidtrack_shipments (id, shipment_title, campaign_id) VALUES ('', ?, ?)";
        $this->db->query($query, array($shipment_title, $camp_id));
    }

    /*
    | -------------------------------------------------------------------
    |  Products
    | -------------------------------------------------------------------
    */

    public function get_products($prod_id = false) {
        if ($prod_id === false) {
            $query = $this->db->query('SELECT * FROM aidtrack_products');
            return $query->result_array();
        } else {
            $query = $this->db->get_where('aidtrack_products', array('id' => $prod_id));
            return $query->result_array();
        }
    }
    
    public function add_product($product_name, $man_id, $product_description) {
        $query = "INSERT INTO `aidtrack_products` (id, product_name, product_description, manufacturer_id) VALUES ('', ?, ?, ?)";
        $this->db->query($query, array($product_name, $product_description, $man_id));
    }

    public function get_last_product() {
        $query = $this->db->select('*')->from('aidtrack_products')->order_by('id', 'DESC')->limit(1)->get();
        return $query->result_array();
    }

    /*
    | -------------------------------------------------------------------
    |  Items
    | -------------------------------------------------------------------
    */

    public function get_item($item_id) {
        $query = $this->db->get_where('aidtrack_items', array('id' => $item_id));
        return $query->result_array();
    }

    public function get_items_by_product($prod_id) {
        $query = $this->db->get_where('aidtrack_items', array('product_id' => $prod_id));
        return $query->result_array();
    }

    public function get_items_by_shipment($shipment_id) {
        $query = $this->db->get_where('aidtrack_items', array('shipment_id' => $shipment_id));
        return $query->result_array();
    }

    public function get_all_items() {
        $query = $this->db->select('*')->from('aidtrack_items')->get();
        return $query->result_array();
    }

    public function add_item($item_nfc, $product_id, $shipment_id) {
        $query = "INSERT INTO `aidtrack_items` (id, item_nfc, product_id, shipment_id) VALUES ('', ?, ?, ?)";
        $this->db->query($query, array($item_nfc, $product_id, $shipment_id));
    }

    public function get_last_item() {
        $query = $this->db->select('*')->from('aidtrack_items')->order_by('id', 'DESC')->limit(1)->get();
        return $query->result_array();
    }

    /*
    | -------------------------------------------------------------------
    |  Items
    | -------------------------------------------------------------------
    */

    public function get_item_history($item_id = false) {
        if ($item_id === false) {
            $query = $this->db->query('SELECT * FROM `aidtrack_item_history`');
            return $query->result_array();
        } else {
            $query = $this->db->get_where('aidtrack_item_history', array('item_id' => $item_id));
            return $query->result_array();
        }
    }

    public function update_item_history($item_id, $status, $latitude, $longitude) {
        $query = "INSERT INTO `aidtrack_item_history` (id, item_id, status, latitude, longitude) VALUES ('', ?, ?, ?, ?)";
        $this->db->query($query, array($item_id, $status, $latitude, $longitude));
    }

    /*
    | -------------------------------------------------------------------
    |  Manufacturers
    | -------------------------------------------------------------------
    */

    public function get_manufacturers($man_id = false) {
        if ($man_id === false) {
            $query = $this->db->query('SELECT * FROM `aidtrack_manufacturers`');
            return $query->result_array();
        } else {
            $query = $this->db->get_where('aidtrack_manufacturers', array('id' => $man_id));
            return $query->row_array();
        }
    }

    public function add_manufacturer($man_name) {
        $query = "INSERT INTO `aidtrack_manufacturers` (id, manufacturer_name) VALUES ('', ?)";
        $this->db->query($query, array($man_name));
    }

    public function get_last_manufacturer() {
        $query = $this->db->select('*')->from('aidtrack_manufacturers')->order_by('id', 'DESC')->limit(1)->get();
        return $query->result_array();
    }

}
