<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class report_filter extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        /$this->load->model('report_filter');
    }
    public function DB_filter() {
        
        $this->load->view('report_filter/DB_filter', $data);
    }
     public function singleDate_filter() {
        
        $this->load->view('report_filter/singleDate_filter', $data);
    }
    
    

}
