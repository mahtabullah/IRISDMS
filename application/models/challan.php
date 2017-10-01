<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class challan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('orders');
        $this->load->model('stocks');
        $this->load->model('challans');
    }

    function index() {
        $db_id = $this->session->userdata('db_id');
        $data["PSR"] = $this->challans->getDbpSrList($db_id);
        $this->load->view("Challan/index", $data);
    }

    function Create_challan() {
        $db_id = $this->session->userdata('db_id');
        $data["PSR"] = $this->challans->getDbpSrList($db_id);
        $this->load->view("Challan/Create_challan", $data);
    }

    public function getRoutebByPSR() {
        $psr_id = $this->input->post('psr_id');
        $date = date("Y-m-d", strtotime($this->input->post('Date')));
        $Route = $this->orders->getRoutebByPSR($psr_id, $date);

        if (!empty($Route)) {

            foreach ($Route as $subroute) {
                $option .= '<option value="' . $subroute['id'] . '">' . $subroute['route'] . '</option>';
            }
            echo $option;
        }
    }

    function No_of_memo() {
        $db_id = $this->session->userdata('db_id');
        $psr_id = $this->input->post('PSR_id');
        $order_date = date("Y-m-d", strtotime($this->input->post('Orderdate')));
        $No_of_memo = $this->challans->getNumberOfMemobyOrder_date($db_id, $psr_id, $order_date);
        echo $No_of_memo[0][No_of_memo];
    }

    function add_challan_part() {
        $db_id = $this->session->userdata('db_id');
        $psr_id = $this->input->post('PSR_id');
        $order_date = date("Y-m-d", strtotime($this->input->post('Orderdate')));
        $data['Order_data'] = $this->challans->getOrder_date($db_id, $psr_id, $order_date);
        $data['No_of_memo'] = $this->challans->getNumberOfMemobyOrder_date($db_id, $psr_id, $order_date);
        $data['getPsrid'] = $this->challans->getNumberOfMemobyOrder_date($db_id, $psr_id, $order_date);
        $data["PSR"] = $this->challans->getPsrid($psr_id);
        $data["Date"] = $this->input->post('Orderdate');
        $data["subroute"] = $this->orders->getRoutebByPSR($psr_id, $order_date);
        $this->load->view("Challan/part/challan_part", $data);
    }

    public function add_challan() {
        $db_id = $this->session->userdata('db_id');
        $System_date = $this->session->userdata('System_date');
        $route_id = $this->input->post('subroute');
        $psr_id = $this->input->post('Psr_name');
        $No_of_memo = $this->input->post('No_of_memo');
        $Order_challan_Date = date("Y-m-d", strtotime($this->input->post('Order_Date')));
        $grand_total_CS = $this->input->post('grand_total_CS');

        $grand_total = $this->input->post('grand_total');
        $total_amount = $this->input->post('total_amount');
        $challan_status = 1;
        $challan_number_format = $db_id . $psr_id . '-' . $Order_challan_Date;
        ///////////////////Challan Line\\\\\\\\\\\\\\\\\\\\\

        $sku_id = $this->input->post('sku_id');
        $Pack_size = $this->input->post('Pack_Size');
        $TP_price = $this->input->post('TP_price');
        $Totalorder_qty = $this->input->post('Totalorder_qty');
        $Extra_Qty = $this->input->post('Extra_Qty');
        $Grand_total_qty_CS = $this->input->post('Grand_total_qty_CS'); //convert PS to CS
        $Total_qty = $this->input->post('Total_qty'); //order+Extra=Total_qty

        $memo_id = $this->challans->getMemoid($db_id, $psr_id, $Order_challan_Date); //Get MEMO Id



        $challan = array(
            'challan_number' => $challan_number_format,
            'db_id' => $db_id,
            'psr_id' => $psr_id,
            'route_id' => $route_id,
            'challan_status' => $challan_status,
            'No_of_memo' => $No_of_memo,
            'No_of_Outlet' => $No_of_memo,
            'order_date' => $Order_challan_Date,
            'Create_date_time' => date('Y-m-d H:i:s'),
            'System_date' => $System_date,
            'delivery_date' => $System_date,
            'grand_total_CS' => $grand_total_CS,
            'grand_total' => $grand_total
        );

        $insert_into_challan_id = $this->challans->insertData('tblt_challan', $challan);  // insert challan
        foreach ($memo_id As $memo) {
            $Sku_inventory_qty = $this->challans->MemoUpdate($memo[memo_id], $insert_into_challan_id); // Insert challan id in memmo and memo status change
        }
        // $insert_into_challan_id = 0;
        foreach ($sku_id as $key => $value) {
            $challan_line = array(
                'challan_id' => $insert_into_challan_id,
                'sku_id' => $value,
                'price' => $TP_price[$key],
                'Pack_size' => $Pack_size[$key],
                'order_qty' => $Totalorder_qty[$key],
                'Extra_qty' => $Extra_Qty[$key],
                'Total_qty' => $Total_qty[$key],
                'Total_qty_in_cs' => $Grand_total_qty_CS[$key],
                'order_qty_price' => $Totalorder_qty[$key] * $TP_price[$key],
                'Extra_qty_price' => $Extra_Qty[$key] * $TP_price[$key],
                'Total_qty_price' => $Total_qty[$key] * $TP_price[$key],
            );

            if ($Total_qty[$key] != 0) {
                $Sku_inventory_qty = $this->challans->GetinventoryQtybySku_ID($value); //get inventory qty
                $qty = $Sku_inventory_qty[0]['qty'] - $Total_qty[$key];
                $insert_into_challan_line = $this->challans->insertData('tblt_challan_line', $challan_line); //update Inventory
                $inventory_qty_update = $this->challans->UpdateinventoryQtybyID($value, $qty); //insert challan line
            }
        }
        redirect(site_url('Challan/Create_challan'));
    }

    public function allChallan() {
        $date_start = $this->input->post('date_frm');
        $date_end = $this->input->post('date_to');
        $PSR = $this->input->post('PSR');
        $challan_status = $this->input->post('challan_status');
        $db_id = $this->session->userdata('db_id');
        $date_frm = date("Y-m-d", strtotime($date_start));
        $date_to = date("Y-m-d", strtotime($date_end));
        $where = 'AND t1.db_id=' . $db_id;

        if (!empty($date_frm) && !empty($date_to)) {
            $where .= ' AND order_date BETWEEN "' . $date_frm . '" AND "' . $date_to . '" ';
        }
        if (!empty($PSR)) {
            $where .= ' AND t1.psr_id=' . $PSR;
        }
        if (!empty($Sub_Route)) {
            $where .= ' AND t1.route_id=' . $Sub_Route;
        }
        if (!empty($sales_status)) {
            $where .= ' AND t1.$challan_status=' . $challan_status;
        }

        $data["all_challan"] = $this->challans->get_all_challan($where);

        $this->load->view("Challan/allChallan", $data);
    }
    public function Detailsbyid($id) {
       // echo $id;
        $db_id = $this->session->userdata('db_id');
        $data["challanInfo"] = $this->challans->get_challanbyid($id);
        $data["challanLineInfo"] = $this->challans->get_challanLinebyid($id, $db_id) ;
      //  var_dump($data);
        $this->load->view("Challan/challan_details", $data);
        
        
    }



        
    

}
