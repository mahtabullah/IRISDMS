<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class report_realtime extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('report_realtime_m');
    }
    public function index() {
        
        echo'report_realtime';
        
    }
    /* Outlet Wise Order Start*/
    public function OutletWiseOrder() {
     
        $this->load->view('report_realtime/OutletWiseOrder/OutletWiseOrder', $data);
        
    }
     public function OutletWiseOrder_filter() {
    
        $this->load->view('report_realtime/OutletWiseOrder/OutletWiseOrder_filter', $data);
        
    }
     /* Outlet Wise Order End*/

}
