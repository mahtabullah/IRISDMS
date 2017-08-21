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
    
    
    function add_challan_part() {
        $db_id = $this->session->userdata('db_id');
        $psr_id=$this->input->post('PSR_id');
        $order_date = date("Y-m-d", strtotime($this->input->post('Orderdate')));
        $data['Order_date']=$this->Challans->getOrder_date($db_id,$psr_id,$order_date);
        var_dump($data);
       // $this->load->view("Challan/part/challan_part", $data);
    }

}
