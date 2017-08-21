<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Challan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('orders');
        $this->load->model('Challans');      
       
    }

    function index() {
        $db_id = $this->session->userdata('db_id');
        $data["PSR"] = $this->Challans->getDbpSrList($db_id);
        $this->load->view("Challan/index", $data);
    }
    
    function Create_challan() {
        $db_id = $this->session->userdata('db_id');
        $data["PSR"] = $this->Challans->getDbpSrList($db_id);
        $this->load->view("Challan/Create_challan", $data);
    }

}
