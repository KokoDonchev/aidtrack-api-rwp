<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

/**
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class V1 extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        header('Access-Control-Allow-Origin: *'); // find why it doesn't work from the main config

        $this->load->model('data');

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['get_campaigns_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['campaigns_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['campaigns_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    ///////////////////////
    // Campaigns
    ///////////////////////

    public function campaigns_get() {

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the campaigns
        if ($id === NULL) {
            // getting campaigns from database
            $campaigns = $this->data->get_campaigns();

            // Check if the users data store contains users (in case the database result returns NULL)
            if ($campaigns) {
                // Set the response and exit
                $this->response($campaigns, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No campaigns were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular campaign.
        else {
            $id = (int) $id;

            // getting campaign from database
            $campaigns = $this->data->get_campaigns($id);

            // Validate the id.
            if ($id <= 0) {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            if (!empty($campaigns)) {
                $jsonresponse['campaign'] = $campaigns[0];
                $jsonresponse['campaign']['shipments'] = $this->data->get_shipments(0, $campaigns[0]['id']);
                // $jsonresponse['campaign']['items'] = array('shipment_one' => 'hello', 'shipment_two' => 'there');

                $this->set_response($jsonresponse, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Campaign could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function campaigns_post() {

        // $this->some_model->update_campaign( ... );
        $data = [
            'campaign_name' => $this->post('campaign_name'),
            'status' => true
        ];

        $this->data->add_campaign($data['campaign_name']);

        $jsonresponse = $data;
        $jsonresponse['info'] = $this->data->get_last_campaign();

        $this->set_response($jsonresponse, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    // public function campaigns_delete() {
    //     $id = (int) $this->get('id');

    //     // Validate the id.
    //     if ($id <= 0) {
    //         // Set the response and exit
    //         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
    //     }

    //     // $this->some_model->delete_something($id);
    //     $message = [
    //         'id' => $id,
    //         'message' => 'Deleted the resource'
    //     ];

    //     $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    // }

    ///////////////////////
    // Shipments
    ///////////////////////

    public function shipments_get() {

        $id = $this->get('id');
        
        // If the id parameter doesn't exist return all the users
        if ($id === NULL) {
             // getting campaigns from database
            $shipments = $this->data->get_shipments();
            if ($shipments) {
                // Set the response and exit
                $this->response($shipments, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No shipments were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular campaign.
        else {
            $id = (int) $id;
            $shipment = $this->data->get_shipments($id, 0);
            // Validate the id.
            if ($id <= 0) {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }
            if (!empty($shipment)) {
                $this->set_response($shipment, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Shipment could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function shipments_post() {

        $message = [
            'shipment_title' => $this->post('shipment_title'),
            'camp_id' => $this->post('camp_id')
        ];

        $this->data->add_shipment($message['shipment_title'], $message['camp_id']);

        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function products_get() {

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the users
        if ($id === NULL) {
            // getting campaigns from database
            $products = $this->data->get_products();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($products) {
                // Set the response and exit
                $this->response($products, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No products were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular campaign.
        else {
            $id = (int) $id;
            // getting products from database
            $products = $this->data->get_products($id);
            // Validate the id.
            if ($id <= 0) {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            if (!empty($products)) {
                $this->set_response($products, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Product could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function products_post() {
        
        $message = [
            'product_name' => $this->post('product_name')
        ];

        $this->data->add_product($message['product_name']);

        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

}
