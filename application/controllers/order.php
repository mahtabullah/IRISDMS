<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('orders');
        $this->load->model('Bundle_prices');
        $this->load->model('Outlets');
        $this->load->model('Route_plans');
        // $this->method_call = &get_instance();
    }

    /**
     *
     * @param string $type
     */
    public function index() {
        $db_id = $this->session->userdata('db_id');
        $data["PSR"] = $this->orders->getDbpSrList($db_id);
        $this->load->view('order/index', $data);
    }

    public function allorder() {

        $date_start = $this->input->post('date_frm');
        $date_end = $this->input->post('date_to');
        $PSR = $this->input->post('PSR');
        $Sub_Route = $this->input->post('Sub_Route');
        $sales_status = $this->input->post('sales_status');
        $db_id = $this->session->userdata('db_id');
        $date_frm = date("Y-m-d", strtotime($date_start));
        $date_to = date("Y-m-d", strtotime($date_end));
        $where = 'AND t1.db_id=' . $db_id;

        if (!empty($date_frm) && !empty($date_to)) {
            $where .= ' AND planned_order_date BETWEEN "' . $date_frm . '" AND "' . $date_to . '" ';
        }
        if (!empty($PSR)) {
            $where .= ' AND t1.psr_id=' . $PSR;
        }
        if (!empty($Sub_Route)) {
            $where .= ' AND t1.route_id=' . $Sub_Route;
        }
        if (!empty($sales_status)) {
            $where .= ' AND t1.so_status=' . $sales_status;
        }
        $data["Order"] = $this->orders->getSalesOrderInfo($where);
        $this->load->view('order/allorder', $data);
    }

    public function create() {

        $data['outlet_type_name'] = $this->orders->getsalesTypes();
        $this->load->view('order/create', $data);
    }

    public function getInfoSales_order_type() {
        $type = $this->input->post('sales_order_type');
        $db_id = $this->session->userdata('db_id');

        $data['type'] = $type;
        if ($type == 'regular') {
            $data['title'] = 'Regular Sales';
            $data['PSR'] = $this->Route_plans->getDbpSrList($db_id);
            //$data['subroute'] = $this->orders->getAllsubroute($db_id);

            $this->load->view('order/part/regular.php', $data);
        } else if ($type == 'regular_from_pc') {
            $data['title'] = 'Regular Sales';
            $data['subroute'] = $this->orders->getAllsubroute($db_id);

            $this->load->view('order/part/regular.php', $data);
        }
    }

    public function gerOrderPart() {
        $sales_order_type = $this->input->post('type');
        $outlet_id = $this->input->post('outlet_id');
        $this->load->view('order/part/order', $data);
    }

    public function getOutlet() {
        $sub_route = $this->input->post('sub_route');
        $Systemdate = $this->session->userdata('System_date');
        $outlet = $this->orders->getOutletBySubroute($sub_route, $Systemdate);
        if (!empty($outlet)) {

            foreach ($outlet as $name) {
                $option .= '<option value="' . $name['id'] . '">' . $name['name'] . '</option>';
            }

            echo $option;
        }
    }

    public function getRoutebByPSR() {
        $psr_id = $this->input->post('psr_id');

        $Systemdate = $this->session->userdata('System_date');
        $Route = $this->orders->getRoutebByPSR($psr_id, $Systemdate);
        var_dump($Route);
        if (!empty($Route)) {

            foreach ($Route as $subroute) {
                $option .= '<option value="' . $subroute['id'] . '">' . $subroute['route'] . '</option>';
            }
            echo $option;
        }
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
        $new_line .= '<td style="width:200px;"><input type="text" name="TP_price[]" id="TP_price' . $count . '" class="form-control"  onkeyup="openQty(id);" readonly required/></td>';
        $new_line .= '<td><input type="text"  name="order_qty_CS[]" id="order_qty_CS' . $count . '" onkeyup="total_qty_cs(id);" class="form-control" readonly /></td>';
        $new_line .= '<td><input type="text"  name="order_qty_PS[]" id="order_qty_PS' . $count . '" onkeyup="total_qty_cs(id);" class="form-control" readonly /></td>';
        $new_line .= '<td><input type="text"  name="Offer_txt[]" id="Offer_txt' . $count . '" onkeyup="" class="form-control" readonly /></td>';
        $new_line .= '<td><input type="text"  name="Discount[]" id="Discount' . $count . '" onkeyup="" class="form-control" readonly /></td>';
        $new_line .= '<td><input type="text"  name="Total_qty[]" id="Total_qty' . $count . '" " class="form-control" readonly />';
        $new_line .= '<input type="hidden" name="total_amount[]" id="total_amount' . $count . '" class="form-control"  readonly /></td>';

       
       
        $new_line .= '<td><span class="btn btn-xs btn-danger " id="removeLine"><i class="fa fa-times"></i></span></td>';
        $new_line .= '</tr>';
        echo $new_line;
    }

     public function Editadd_row() {
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
        $new_line .= '<td style="width:20px;"><select name="sku_id[]" onchange="get_unit_price(id)" id="sku_id' .
                $count . '" class="form-control" required >' . $sku_dropdown . '</select></td>';
        $new_line .= '<td style="width:100px;"><input type="text" name="Pack_Size[]" id="Pack_Size' . $count . '" class="form-control"  onkeyup="openQty(id);" readonly required/></td>';
        $new_line .= '<td style="width:200px;"><input type="text" name="TP_price[]" id="TP_price' . $count . '" class="form-control"  onkeyup="openQty(id);" readonly required/></td>';
        $new_line .= '<td><input type="text"  name="order_qty_CS[]" id="order_qty_CS' . $count . '" onkeyup="total_qty_cs(id);" class="form-control" readonly /></td>';
        $new_line .= '<td><input type="text"  name="order_qty_PS[]" id="order_qty_PS' . $count . '" onkeyup="total_qty_cs(id);" class="form-control" readonly /></td>';
        $new_line .= '<td><input type="text"  name="Offer_txt[]" id="Offer_txt' . $count . '" onkeyup="" class="form-control" readonly /></td>';
        $new_line .= '<td><input type="text"  name="Discount[]" id="Discount' . $count . '" onkeyup="" class="form-control" readonly /></td>';
        $new_line .= '<td><input type="text"  name="Total_qty[]" id="Total_qty' . $count . '" " class="form-control" readonly />';
        $new_line .= '<input type="hidden" name="total_amount[]" id="total_amount' . $count . '" class="form-control"  readonly />'
                . ' <input type="hidden" name="TotalOrder_qty[]" value="0" id="total_amount' . $count . '" class="form-control"  readonly />'
                . '</td>';

       
       
        $new_line .= '<td><span class="btn btn-xs btn-danger " id="removeLine"><i class="fa fa-times"></i></span></td>';
        $new_line .= '</tr>';
        echo $new_line;
    }

    public function getBundleDetailbySku() {
        $sku_id = $this->input->post('sku_id');
        $db_id = $this->session->userdata('db_id');
        $TP_price = $this->Bundle_prices->getBundleDetailbySku($sku_id, $db_id);

        foreach ($TP_price as $key) {
            $data['price'] = $key['unit_price'];
            $data['sku_code'] = $key['sku_code'];
            $data['unit_name'] = $key['unit_name'];

            $data['unit'] = $key['qty'];

            echo json_encode($data);
        }
    }

    public function get_unit_price() {
        $sku_id = $this->input->post('sku_id');
        $dd_price = $this->orders->get_unit_price($sku_id);

        //        foreach ($dd_price as $key) {
        //            echo $key['price'];
        //        }
        //
            foreach ($dd_price as $key) {
            $data['price'] = $key['price'];
            $data['sku_code'] = $key['sku_code'];

            echo json_encode($data);
        }
    }

    public function add_other_sale_order() {
        $System_date = $this->session->userdata('System_date');
        $sales_order_type_id = $this->input->post('sales_order_type');
        $type = $this->input->post('type');

        $route_id = $this->input->post('subroute');
        $psr_id = $this->input->post('PSR');
        $outlet_id = $this->input->post('outlet');
        $db_id = $this->session->userdata('db_id');

        $so_status = 1;
        $sku_id = $this->input->post('sku_id');
        $Pack_size = $this->input->post('Pack_Size');
        $TP_price = $this->input->post('TP_price');
        $discount = $this->input->post('Discount');
        $order_qty = $this->input->post('Total_qty');
        $total_amount = $this->input->post('total_amount');
        $invoice_discount = $this->input->post('invoice_discount');

        $grand_total = $this->input->post('grand_total');
        $so_id_format = $System_date . "-" . $route_id . "-" . $outlet_id;

        /**
         * Insert into tblt_sales_order table
         */
        $sales_order = array(
            'so_id' => $so_id_format,
            'route_id' => $route_id,
            'outlet_id' => $outlet_id,
            'planned_order_date' => $System_date,
            'order_date_time' => date('Y-m-d H:i:s'),
            'shipping_date' => $System_date,
            'delivery_date' => $System_date,
            'db_id' => $db_id,
            'psr_id' => $psr_id,
            'so_status' => $so_status,
            'total_order' => $grand_total,
            'total_confirmed' => $grand_total,
            'total_delivered' => $grand_total,
            'sales_order_type_id' => $sales_order_type_id,
            'manual_discount' => $invoice_discount
        );
        //  var_dump($sales_order);
        $insert_into_sales_order = $this->orders->insertData('tblt_sales_order', $sales_order);


        //end

        /**
         * Insert into tblt_sales_order_line table
         * normal sku line item
         */
        foreach ($sku_id as $key => $value) {
            $so_line = array(
                'so_id' => $insert_into_sales_order,
                'sku_id' => $value,
                'sku_order_type_id' => 1,
                'valid_line_item' => 1,
                'Pack_size' => $Pack_size[$key],
                'quantity_ordered' => $order_qty[$key],
                'quantity_confirmed' => $order_qty[$key],
                'quantity_delivered' => $order_qty[$key],
                'unit_sale_price' => $TP_price[$key],
                'total_sale_price' => ($total_amount[$key] - $discount[$key]),
                'total_discount_amount' => $discount[$key],
                'total_billed_amount' => $total_amount[$key]
            );
            $insert_into_sales_order_line = $this->orders->insertData('tblt_sales_order_line', $so_line);
        }
        //end




        echo 'Sales Order Added';
        //redirect(site_url('order/index/others'));
    }

   
    function OrderEditById($order_id) {
      
        $data['orderInfo']=$this->orders->getOrderinfobyid($order_id);
        $data['orderline']=$this->orders->getOrderLInebyid($order_id);
        $data['orderInfo']=$this->orders->getOrderinfobyid($order_id);   
        $this->load->view('order/Edit_byid', $data);
    }
    
    function save_after_edit(){
        
       
        $Order_id = $this->input->post('order_id');
        $so_status = $this->input->post('so_status');
        $sku_id = $this->input->post('sku_id');
        $Pack_size = $this->input->post('Pack_Size');
        $TP_price = $this->input->post('TP_price');
        $discount = $this->input->post('Discount');
        $Totalconfirmed_qty= $this->input->post('Total_qty');
        $TotalOrder_qty=  $this->input->post('TotalOrder_qty');
        $total_amount = $this->input->post('total_amount');       
        $invoice_discount = $this->input->post('invoice_discount');
        $grand_total = $this->input->post('grand_total');
        

        /**
         * update into tblt_sales_order table
         */
        
        $sales_order_edit = array(          
            'total_confirmed' => $grand_total,
            'total_delivered' => $grand_total,            
        );
      
       $this->orders->update_order_table('tblt_sales_order',$Order_id,$sales_order_edit);
     

        foreach ($sku_id as $key => $value) {
            
            $soLine_id=$this->orders->getOrderLInebyid_skid($Order_id,$value);
            $sku_line_id=$soLine_id[0][id];
           if(empty($sku_line_id)){
            $New_so_line_edit = array(               
                'so_id' => $Order_id,
                'sku_id' => $value,
                'sku_order_type_id' => 1,
                'valid_line_item' => 1,
                'Pack_size' => $Pack_size[$key],              
                'quantity_ordered' => $TotalOrder_qty[$key],
                'quantity_confirmed' => $Totalconfirmed_qty[$key],
                'quantity_delivered' => $Totalconfirmed_qty[$key],
                'unit_sale_price' => $TP_price[$key],
                'total_sale_price' => ($total_amount[$key] - $discount[$key]),
                'total_discount_amount' => $discount[$key],
                'total_billed_amount' => $total_amount[$key]
            );          
           $insert_into_sales_order_line = $this->orders->insertData('tblt_sales_order_line', $New_so_line_edit); 
           }else{
               //Order Line Update if Sku Already have
              $so_line_edit = array(
                'quantity_confirmed' => $Totalconfirmed_qty[$key],
                'quantity_delivered' => $Totalconfirmed_qty[$key],
                'total_sale_price' => ($total_amount[$key] - $discount[$key]),
                'total_discount_amount' => $discount[$key],
                'total_billed_amount' => $total_amount[$key]
            );
              
              $this->orders->update_order_table('tblt_sales_order_line',$sku_line_id,$so_line_edit);
                          
               
                }
           
        }
        echo 'Sales Order Save Successfully';



    }
    function Next_order($id){
       $data['Next_orderId']=$this->orders->getnextOrderid($id);                  
    }

    
     function save_after_order_confirm(){
        
       
        $Order_id = $this->input->post('order_id');
        $so_status = $this->input->post('so_status');
        $sku_id = $this->input->post('sku_id');
        $Pack_size = $this->input->post('Pack_Size');
        $TP_price = $this->input->post('TP_price');
        $discount = $this->input->post('Discount');
        $Totalconfirmed_qty= $this->input->post('Total_qty');
        $TotalOrder_qty=  $this->input->post('TotalOrder_qty');
        $total_amount = $this->input->post('total_amount');       
        $invoice_discount = $this->input->post('invoice_discount');
        $grand_total = $this->input->post('grand_total');
        

        /**
         * update into tblt_sales_order table
         */
        
        $sales_order_edit = array(          
               'total_delivered' => $grand_total,            
        );
      
       $this->orders->update_order_table('tblt_sales_order',$Order_id,$sales_order_edit);
     

        foreach ($sku_id as $key => $value) {
            
            $soLine_id=$this->orders->getOrderLInebyid_skid($Order_id,$value);
            $sku_line_id=$soLine_id[0][id];
            
           if(empty($sku_line_id)){
            $New_so_line_edit = array(               
                'so_id' => $Order_id,
                'sku_id' => $value,
                'sku_order_type_id' => 1,
                'valid_line_item' => 1,
                'Pack_size' => $Pack_size[$key],              
                'quantity_ordered' => 0,
                'quantity_confirmed' => 0,
                'quantity_delivered' => $Totalconfirmed_qty[$key],
                'unit_sale_price' => $TP_price[$key],
                'total_sale_price' => ($total_amount[$key] - $discount[$key]),
                'total_discount_amount' => $discount[$key],
                'total_billed_amount' => $total_amount[$key]
            );          
           $insert_into_sales_order_line = $this->orders->insertData('tblt_sales_order_line', $New_so_line_edit); 
           }else{
               //Order Line Update if Sku Already have
              $so_line_edit = array(
               
                'quantity_delivered' => $Totalconfirmed_qty[$key],
                'total_sale_price' => ($total_amount[$key] - $discount[$key]),
                'total_discount_amount' => $discount[$key],
                'total_billed_amount' => $total_amount[$key]
            );
              
              $this->orders->update_order_table('tblt_sales_order_line',$sku_line_id,$so_line_edit);
                          
               
                }
           
        }
        echo 'Sales Order Save Successfully';



    }
    

    //////////////////////////////////////////////
  
 
}
