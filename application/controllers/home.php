<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Homes');
    }

    public function index() {
        $data['incorrectLogin_flag'] = 0;
        $this->load->view('login/login', $data);
    }

    public function getDbIds() {
        $user_role_code = $this->session->userdata('user_role_code');
        $biz_zone_id = $this->session->userdata('biz_zone_id');
        if ($user_role_code == 'DB') {
            $db_id = $this->session->userdata('db_id');
            $db_ids = "($db_id)";
        } else {
            if ($user_role_code == 'MIS') {
                $db_ids = "";
            } else {
                if ($user_role_code == 'TM' || $user_role_code == 'RSM' ||
                        $user_role_code == 'TDM' || $user_role_code == 'CE' || $user_role_code == 'USM' || $user_role_code == 'NSM'
                ) {
                    $db_ids = $this->Homes->getDBIds($biz_zone_id);
                    $db_ids = " (" . $db_ids[0]['dbhouse_id'] . ")";
                }
            }
        }
        return $db_ids;
    }
    public function home_page() {

        $db_id = $this->session->userdata('db_id');
        $db_ids = $this->getDbIds();
        $start_date = $this->session->userdata("System_date");
        $end_date = $this->session->userdata("System_date");
     
       $this->load->view('home/home', $data);
    }
    public function order_qty(){
        
        $db_ids = $this->getDbIds();
        $start_date = $this->session->userdata("System_date");
        $end_date = $this->session->userdata("System_date");
        $num_of_order = $this->Homes->new_order_qty($start_date, $end_date, $db_ids);
        echo $num_of_order[0][Number_of_order];
    }
    public function Number_of_outlet(){
       
        $db_ids = $this->getDbIds();
        $start_date = $this->session->userdata("System_date");
        $end_date = $this->session->userdata("System_date");
        $num_of_order = $this->Homes->total_outlet($db_ids);
        echo $num_of_order[0][Number_of_outlet];
    }
    public function Schedule_Call(){
       
        $db_ids = $this->getDbIds();
        $start_date = $this->session->userdata("System_date");
        $end_date = $this->session->userdata("System_date");
        $num_of_order = $this->Homes->Total_Schedule_Call($start_date, $end_date, $db_ids);
        echo $num_of_order[0][SC];
    }
     public function Strike_Rate(){
       
        $db_ids = $this->getDbIds();
        $start_date = $this->session->userdata("System_date");
        $end_date = $this->session->userdata("System_date");
        $num_of_sc = $this->Homes->Total_Schedule_Call($start_date, $end_date, $db_ids);
        $num_of_order = $this->Homes->new_order_qty($start_date, $end_date, $db_ids);
       
        echo $num_of_sc[0][SC]/100*$num_of_order[0][Number_of_order].'%';
    }

}
