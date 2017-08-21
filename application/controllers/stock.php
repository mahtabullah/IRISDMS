<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class stock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks');
        $this->load->model('orders');
        $this->load->model('Bundle_prices');

//$this->load->model('Sales_orders');
    }

    public function index() {

        $db_ids = $this->getDbIds();

        $data["current_stock"] = $this->stocks->current_stock($db_ids);


        $this->load->view('stock/Current_stock', $data);
    }

    public function getDbIds() {

        $user_role_code = $this->session->userdata('user_role_code');
        $biz_zone_id = $this->session->userdata('biz_zone_id');

        if ($user_role_code == 'DB') {
            $db_id = $this->session->userdata('db_id');
            $db_ids = "$db_id";
        } else {
            if ($user_role_code == 'MIS') {
                $db_ids = "";
            } else {
                if ($user_role_code == 'TM' || $user_role_code == 'RSM' ||
                        $user_role_code == 'TDM' || $user_role_code == 'CE' || $user_role_code == 'USM' || $user_role_code == 'NSM'
                ) {
                    $db_ids = $this->Homes->getDBIds($biz_zone_id);
                    $db_ids = "" . $db_ids[0]['dbhouse_id'] . "";
                }
            }
        }

        return $db_ids;
    }

    public function new_stock() {

//$db_ids=$this->getDbIds();
//$data["current_stock"]=$this->stocks->current_stock($db_ids);


        $this->load->view('stock/new_stock', $data);
    }

    public function challan_number_check() {
        echo "Done";
    }

    public function add_stock() {

        $System_date = $this->session->userdata('System_date');
        $Challan_number = $this->input->post('Challan');
        $Challan_Date = date("Y-m-d", strtotime($this->input->post('challan_date')));
        $Vat_Challan_number = $this->input->post('VATChallan');
        $db_id = $this->session->userdata('db_id');
        $grand_total_CS = $this->input->post('grand_total_CS');
        $grand_total = $this->input->post('grand_total');

        $sku_id = $this->input->post('sku_id');
        $Pack_size = $this->input->post('Pack_Size');
        $TP_price = $this->input->post('TP_price');
        $order_qty = $this->input->post('Total_qty');
        $total_amount = $this->input->post('total_amount');

        $purchase = array(
            'Challan_no' => $Challan_number,
            'VatChallan_no' => $Vat_Challan_number,
            'system_date' => $System_date,
            'Challan_Entry_Date' => date('Y-m-d H:i:s'),
            'Challan_Date' => $Challan_Date,
            'db_id' => $db_id,
            'total_purchase' => $grand_total,
            'total_purchase_qty' => $grand_total_CS
        );

        $insert_into_purchase = $this->stocks->insertData('tblt_purchase', $purchase);

        //  $insert_into_purchase = 1;
        foreach ($sku_id as $key => $value) {
            $purchase_line = array(
                'Purchase_id' => $insert_into_purchase,
                'sku_id' => $value,
                'Pack_size' => $Pack_size[$key],
                'unit_price' => $TP_price[$key],
                'Purchase_qty' => $order_qty[$key],
                'total_purchase_price' => $total_amount[$key]
            );

            $Sku_inventory_id = $this->stocks->inventory_qty_check($db_id, $value);
            $inventory_id = $Sku_inventory_id[0]['id'];

            if (!empty($inventory_id)) {
                $Sku_inventory_qty = $this->stocks->GetinventoryQtybyID($inventory_id);
                $qty = $order_qty[$key] + $Sku_inventory_qty[0]['qty'];
                $inventory_qty_update = $this->stocks->UpdateinventoryQtybyID($inventory_id, $qty);
            } else {

                $New_inventor = array(
                    'sku_id' => $value,
                    'db_id' => $db_id,
                    'Pack_size' => $Pack_size[$key],
                    'qty' => $order_qty[$key],
                );
                $insert_into_inventory = $this->stocks->insertData('tblt_inventory ', $New_inventor);
            }


            $insert_into_purchase_line = $this->stocks->insertData('tblt_purchase_line', $purchase_line);
        }

        redirect(site_url('stock/'));
    }

    public function add_row() {
        $where = '';
        $count = $this->input->post('count');
        $block_sku_list = $this->input->post('sku_list');
        $spoke_id = $this->input->post('spoke_id');
        if (!empty($spoke_id)) {
            $db_id = $spoke_id; /* ........$db_id means Spoke ID.......... */
        } else {
            $db_id = $this->session->userdata('db_id');
        }
        $sku_lists = $this->orders->getFilteredSku($block_sku_list);
        if ($block_sku_list) {
            $sku_ids = implode(',', $block_sku_list);
            $where .= " AND t2.sku_id not in($sku_ids)";
        }
        $sku_lists = $this->Bundle_prices->getAllBundleSkubyDB($db_id, $where);

        $sku_dropdown = '<option></option>';
        foreach ($sku_lists as $sku_list) {
            $sku_dropdown .= '<option value="' . $sku_list['sku_id'] . '">' . $sku_list['sku_name'] . ' (' .
                    $sku_list['sku_code'] . ')' . '</option>';
        }
        $new_line = '';
        $new_line .= '<tr>';
        $new_line .= '<td style="width:300px;"><select name="sku_id[]" onchange="get_unit_price(id)" id="sku_id' .
                $count . '" class="form-control" required >' . $sku_dropdown . '</select></td>';
        $new_line .= '<td style="width:100px;"><input type="text" name="Pack_Size[]" id="Pack_Size' . $count . '" class="form-control"  onkeyup="openQty(id);" readonly required/></td>';
        $new_line .= '<td style="width:100px;"><input type="text" name="TP_price[]" id="TP_price' . $count . '" class="form-control"  onkeyup="openQty(id);" readonly required/></td>';
        $new_line .= '<td><input type="text"  name="order_qty_CS[]" id="order_qty_CS' . $count . '" onkeyup="total_qty_cs(id);" class="form-control" readonly /></td>';
        $new_line .= '<td><input  type="text"  name="order_qty_PS[]" id="order_qty_PS' . $count . '" onkeyup="total_qty_cs(id);" class="form-control" readonly /></td>';
        $new_line .= '<td><input type="text"  name="Total_qty[]" id="Total_qty' . $count . '" " class="form-control" readonly /></td>';
        $new_line .= '<td><input type="text"  name="Total_qty_cs[]" id="Total_qty_cs' . $count . '" " class="form-control" readonly /></td>';

        $new_line .= '</td>';
        $new_line .= '<td><input type="text" name="total_amount[]" id="total_amount' . $count . '" class="form-control"  readonly /></td>';
        $new_line .= '<td><span class="btn btn-xs btn-danger " id="removeLine"><i class="fa fa-times"></i></span></td>';
        $new_line .= '</tr>';
        echo $new_line;
    }

    public function getBundleDetailbySku() {
        $sku_id = $this->input->post('sku_id');
        $db_id = $this->session->userdata('db_id');
        $TP_price = $this->Bundle_prices->getBundleDetailbySkuforStock($sku_id, $db_id);

        foreach ($TP_price as $key) {
            $data['price'] = $key['unit_price'];
            $data['sku_code'] = $key['sku_code'];
            $data['unit_name'] = $key['unit_name'];

            $data['unit'] = $key['qty'];

            echo json_encode($data);
        }
    }

}
